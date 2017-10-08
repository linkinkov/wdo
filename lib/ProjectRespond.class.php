<?php

class ProjectRespond
{
	public function __construct($id = false)
	{
		global $db;
		global $current_user;
		$this->error = true;
		if ( intval($id) == 0 )
		{
			return;
		}
		$sql = sprintf("SELECT `respond_id`, `for_project_id`, `user_id`, `created`, `descr`, `cost`, `status_id`,`status_name`,`modify_timestamp`
		FROM `project_responds`
		LEFT JOIN `project_responds_statuses` ON `project_responds_statuses`.`id` = `project_responds`.`status_id`
		WHERE `respond_id` = '%d'",$id);
		try {
			$respond = $db->queryRow($sql);
			if ( sizeof($respond) )
			{
				foreach ( $respond as $p => $v ) $this->$p = htmlentities($v);
			}
			else
			{
				return;
			}
			$this->respond_id = $id;
			$filter = Array("descr","cost");
			foreach ( $filter as $field )
			{
				if ( isset($this->$field) ) $this->$field = filter_string($this->$field,'out');
			}
			$this->attaches = Attach::get_by_for_type("for_respond_id",$id);
			$project_author_id = $db->getValue("project","user_id","user_id",Array("project_id"=>$this->for_project_id));
			if ( $current_user->user_id != $this->user_id && $current_user->user_id != $project_author_id && $current_user->template_id != 2 )
			{
				unset($this->cost);
				unset($this->status_id);
				unset($this->modify_timestamp);
				unset($this->status_name);
			}
			$this->error = false;
		}
		catch (Exception $e)
		{
			return;
		}
	}

	public function update($field,$value)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		$project_author_id = $db->getValue("project","user_id","user_id",Array("project_id"=>$this->for_project_id));
		$project_status_id = $db->getValue("project","status_id","status_id",Array("project_id"=>$this->for_project_id));
		$db->autocommit(false);
		if ( $project_author_id != $current_user->user_id || !in_array($project_status_id,Array(1,2)) )
		{
			$response["error"] = "Ошибка доступа (Вы не автор проекта)";
			return $response;
		}
		if ( $field == "status_id" && $value == 2 && $this->status_id == 2 ) $value = 1;
		if ( $field == "status_id" && $value == 3 && Project::get_accepted_respond($this->for_project_id) > 0 )
		{
			$response["message"] = "У вас уже есть исполнитель данного проекта";
			return $response;
		}
		if ( $field == "status_id" )
		{
			$sql = sprintf("UPDATE `project_responds` SET `%s` = '%s', `modify_timestamp` = UNIX_TIMESTAMP() WHERE `respond_id` = '%d'",$field,$value,$this->respond_id);
		}
		else
		{
			$sql = sprintf("UPDATE `project_responds` SET `%s` = '%s' WHERE `respond_id` = '%d'",$field,$value,$this->respond_id);
		}
		try {
			$db->query($sql);
			if ( $value == 3 )
			{
				$db->query(sprintf("UPDATE `project` SET `status_id` = '2' WHERE `project_id` = '%d' AND `user_id` = '%d'",$this->for_project_id,$current_user->user_id));
				$db->query(sprintf("DELETE FROM `user_readed_log` WHERE `user_id` = '%d' AND `type` = 'project_respond' AND `id` = '%d'",$this->user_id,$this->respond_id));
				$dates = $db->queryRow(sprintf("SELECT `start_date`,`end_date` FROM `project` WHERE `project_id` = '%d'",$this->for_project_id));
				User::calendar($this->user_id,"set",Array($dates->start_date,$dates->end_date),0);
			}
			$response["result"] = "true";
			$response["message"] = "Обновлено";
			$db->commit();
		}
		catch (Exception $e)
		{
			$response["error"] = $e->getMessage();
		}
		return $response;
	}

	public static function publish($data)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( $current_user->user_id == 0 ) return $response;
		if ( $current_user->status_id != 1 )
		{
			$response["message"] = "Ваш аккаунт заблокирован";
			return $response;
		}
		$all_fields = Array("descr","cost","youtube_links","for_project_id");
		$req_fields = Array("descr","for_project_id");
		if ( intval($data["for_project_id"]) == 0 ) return $response;
		foreach ( $req_fields as $field )
		{
			if ( !isset($data[$field]) )
			{
				$response["field"] = $field;
				return $response;
			}
		}
		foreach ( $all_fields as $field )
		{
			if ( !isset($data[$field]) )
			{
				$data[$field] = 0;
			}
		}
		$data["descr"] = filter_string($data["descr"]);
		$sql = sprintf("INSERT INTO `project_responds` (`for_project_id`,`user_id`,`created`,`descr`,`cost`,`status_id`)
		VALUES ('%d','%d',UNIX_TIMESTAMP(),'%s','%d',1)",
		intval($data["for_project_id"]),
		$current_user->user_id,
		$data["descr"],
		$data["cost"]
		);
		try {
			$db->autocommit(false);
			if ( $db->query($sql) && $db->insert_id > 0 )
			{
				$respond_id = $db->insert_id;
				if ( Attach::save_from_user_upload_dir('for_respond_id',$respond_id,$data["youtube_links"]) )
				{
					$db->commit();
					$response["result"] = "true";
					$response["message"] = "Заявка опубликована";
					$title = $db->getValue("project","title","title",Array("project_id"=>$data["for_project_id"]));
					$cat_id = $db->getValue("project","cat_id","cat_id",Array("project_id"=>$data["for_project_id"]));
					$subcat_id = $db->getValue("project","subcat_id","subcat_id",Array("project_id"=>$data["for_project_id"]));
					$cat_tr = strtolower(r2t(Category::get_name($cat_id)));
					$subcat_tr = strtolower(r2t(SubCategory::get_name($subcat_id)));
					$title_tr = strtolower(r2t($title));
					$response["project_link"] = HOST.'/project/'.$cat_tr.'/'.$subcat_tr.'/p'.$data["for_project_id"].'/'.$title_tr.'.html';
					$db->autocommit(true);
				}
				else
				{
					$response["error"] = "Не удалось прикрепить файлы к заявке";
				}
			}
		}
		catch ( Exception $e )
		{
			// $response["error"] = $e->getMessage();
		}
		return $response;
	}

	public function close($descr,$grade)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( trim($descr) == "" )
		{
			$response["message"] = "Введите текст отзыва";
			return $response;
		}
		$grade = ($grade > 10) ? 10 : ($grade<1) ? 1 : $grade;
		// check respond for user already submitted
		$already_submitted = $db->getValue("user_responds","COUNT(`id`)","counter",Array("author_id"=>$current_user->user_id,"project_id"=>$this->for_project_id,"user_id"=>$this->user_id));
		if ( $already_submitted > 0 )
		{
			$response["message"] = "Ваш отзыв уже опубликован";
			return $response;
		}
		// check current user is author of project
		$can_modify = $db->getValue("project","user_id","user_id",Array("project_id"=>$this->for_project_id,"user_id"=>$current_user->user_id,"status_id"=>2));
		if ( $can_modify != $current_user->user_id )
		{
			$response["temp"] = $can_modify;
			$response["message"] = "Ошибка доступа";
			return $response;
		}
		// check current respond is in progress
		if ( $this->status_id != 3 )
		{
			$response["message"] = "Отзыв на проект не в работе";
			return $response;
		}
		$db->autocommit(false);
		try {

			// check safe deal
			if ( $db->getValue("project","safe_deal","safe_deal",Array("project_id"=>$this->for_project_id)) == 1 ) // project is safe deal. check balances
			{
				// check project author balance > respond cost
				$current_user->init_wallet();
				$find_transaction = Array (
					"for_project_id" => $this->for_project_id,
					"type" => "HOLD",
					"descr" => "Удержание средств за безопасную сделку"
				);
				$transaction_hold = $current_user->wallet->find_transaction($find_transaction);
				// $db->queryRow(sprintf("SELECT `transaction_id`,`amount` FROM `wallet_transactions` WHERE `wallet_id` = '%s' AND `for_project_id` = '%d'",$current_user->wallet->wallet_id,$this->for_project_id));
				if ( !isset($transaction_hold->amount) || $transaction_hold->amount <= 0 )
				{
					$response["message"] = "Невозможно найти транзакцию на удержание";
					return $response;
				}
				$more_to_withdrawal = (intval($this->cost) - intval($transaction_hold->amount));
				if ( $current_user->wallet->balance < $more_to_withdrawal )
				{
					// $response["_1"] = $current_user->wallet->balance;
					// $response["_2"] = $more_to_withdrawal;
					// author's balance less than holded amount + respond cost
					$response["message"] = "Недостаточно средств для перевода исполнителю";
					return $response;
				}
				if ( $more_to_withdrawal > 0 )
				{
					// insert additional withdrawal transaction overhead project budget
					$new_transaction = Array (
						"reference_id"=>$transaction_hold->transaction_id,
						"type"=>"WITHDRAWAL",
						"amount"=>intval($more_to_withdrawal),
						"descr"=>"Дополнительное списание сверх бюджета в проекте",
						"for_project_id"=>$this->for_project_id,
						"commit"=>false
					);
					if ( $current_user->wallet->create_transaction($new_transaction) !== true )
					{
						$response["message"] = "Не удалось создать транзакцию по сверх-списанию";
						return $response;
					}
				}
				// confirm previously HOLD amount as withdrawal from wallet
				$confirm_transaction = Array (
					"transaction_id"=>$transaction_hold->transaction_id,
					"commit"=>false
				);
				if ( $current_user->wallet->confirm_holded_transaction($confirm_transaction) !== true )
				{
					$response["message"] = "Не удалось подтвердить транзакцию HOLD";
					return $response;
				}
				else
				{
					// payment to performer
					$respond_user = new User($this->user_id);
					$respond_user->init_wallet();
					$project_title = $db->getValue("project","title","title",Array("project_id"=>$this->for_project_id,"user_id"=>$current_user->user_id));
					$project_cost = $db->getValue("project","cost","cost",Array("project_id"=>$this->for_project_id,"user_id"=>$current_user->user_id));
					$cost = (intval($this->cost) > 0) ? intval($this->cost) : intval($project_cost);
					$new_transaction = Array (
						"reference_id"=>$transaction_hold->transaction_id,
						"type"=>"PAYMENT",
						"amount"=>intval($cost),
						"descr"=>"Зачисление средств за исполненную заявку",
						"for_project_id"=>$this->for_project_id,
						"commit"=>false
					);

					if ( $respond_user->wallet->create_transaction($new_transaction) !== true )
					{
						$response["message"] = "Ошибка зачисления средств исполнителю";
						return $response;
					}
				}
			}
			$insert = sprintf("INSERT INTO `user_responds` (`user_id`,`project_id`,`author_id`,`descr`,`created`,`grade`)
			VALUES ('%d','%d','%d','%s',UNIX_TIMESTAMP(),'%d')",$this->user_id,$this->for_project_id,$current_user->user_id,$descr,$grade);
			// echo $insert;
			if ( $db->query($insert) && $db->affected_rows == 1 )
			{
				$update = $this->update("status_id",5);
				$db->query(sprintf("UPDATE `users` SET `rating` = (SELECT SUM(`grade`) FROM `user_responds` WHERE `user_id` = '%d') WHERE `user_id` = '%d'",$this->user_id,$this->user_id));
				$db->query(sprintf("UPDATE `project` SET `status_id` = '3' WHERE `project_id` = '%d' AND `user_id` = '%d'",$this->for_project_id,$current_user->user_id));
				$response["update"] = $update;
				$response["result"] = "true";
				$response["message"] = "Отзыв опубликован, проект закрыт";
				$db->commit();
			}
		}
		catch ( Exception $e )
		{
			$response["error"] = $e->getMessage();
		}
		$db->autocommit(true);
		return $response;
	}
}

?>