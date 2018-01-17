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
			$this->arbitrage = false;
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
			else
			{
				// if ( $this->status_id == 3 )
				// {
					// respond in progress
					$arbitrage_ticket_id = $db->getValue("arbitrage","ticket_id","ticket_id",Array("respond_id"=>$this->respond_id,"project_id"=>$this->for_project_id));
					if ( strlen($arbitrage_ticket_id) == 32 )
					{
						// echo $arbitrage_ticket_id;
						$this->arbitrage = new Arbitrage($arbitrage_ticket_id);
					}
				// }
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
		// $project_status_id = $db->getValue("project","status_id","status_id",Array("project_id"=>$this->for_project_id));

		$project = new Project($this->for_project_id);
		$project_user = new User($project_author_id);

		$db->autocommit(false);
		if ( ($project_author_id != $current_user->user_id || !in_array($project->status_id,Array(1,2))) && $current_user->template_id != 2 )
		{
			$response["error"] = "Ошибка доступа";
			return $response;
		}
		if ( $field == "status_id" && $value == 2 && $this->status_id == 2 ) $value = 1;
		if ( $field == "status_id" && $value == 3 && Project::get_accepted_respond($this->for_project_id) > 0 )
		{
			$response["message"] = "У вас уже есть исполнитель данного проекта";
			return $response;
		}
		if ( $field == "status_id" && $value == "3" )
		{
			if ( $project->safe_deal == 1 )
			{
				$project_user->init_wallet();
				$find_transaction = Array (
					"for_project_id" => $this->for_project_id,
					"type" => "HOLD",
					"descr" => "Удержание за безопасную сделку"
				);
				$transaction_hold = $project_user->wallet->find_transaction($find_transaction);
				if ( !isset($transaction_hold->transaction_id) )
				{
					$response["message"] = "Невозможно найти транзакцию на удержание";
					return $response;
				}
				$find_transaction = Array (
					"reference_id"=>$transaction_hold->transaction_id,
					"type"=>"HOLD",
					"descr"=>"Удержание за безопасную сделку (комиссия)",
					"for_project_id"=>$this->for_project_id,
				);
				$transaction_hold_comission = $project_user->wallet->find_transaction($find_transaction);
				if ( !isset($transaction_hold_comission->transaction_id) )
				{
					$response["message"] = "Невозможно найти транзакцию на удержание (комиссия)";
					return $response;
				}

				$more_to_withdrawal = (intval($this->cost) - intval($transaction_hold->amount));
				$safe_deal_comission = $db->getValue("settings","param_value","safe_deal_comission",Array("param_name"=>"safe_deal_comission"));
				if ( $more_to_withdrawal > 0 )
				{
					$more_to_withdrawal_comission = intval($more_to_withdrawal/100*$safe_deal_comission);
					if ( $project_user->wallet->balance < ($more_to_withdrawal + $more_to_withdrawal_comission) )
					{
						// author's balance less than holded amount + respond cost
						$response["message"] = sprintf("Недостаточно средств: %s",(($more_to_withdrawal + $more_to_withdrawal_comission) - $project_user->wallet->balance));
						return $response;
					}

					// insert additional withdrawal transaction overhead project budget
					$new_transaction = Array (
						"reference_id"=>$transaction_hold->transaction_id,
						"type"=>"HOLD",
						"amount"=>intval($more_to_withdrawal),
						"descr"=>"Удержание сверх бюджета в проекте",
						"for_project_id"=>$this->for_project_id,
						"commit"=>false
					);
					if ( ($transaction_id_overcost = $project_user->wallet->create_transaction($new_transaction)) === false )
					{
						$response["message"] = "Не удалось создать транзакцию по сверх-списанию";
						return $response;
					}
					$new_transaction = Array (
						"reference_id"=>$transaction_hold->transaction_id,
						"type"=>"HOLD",
						"amount"=>intval($more_to_withdrawal/100*$safe_deal_comission),
						"descr"=>"Удержание сверх бюджета в проекте (комиссия)",
						"for_project_id"=>$this->for_project_id,
						"commit"=>false
					);
					if ( ($transaction_id_overcost_comission = $project_user->wallet->create_transaction($new_transaction)) === false )
					{
						$response["message"] = "Не удалось создать транзакцию по сверх-списанию (комиссия)";
						return $response;
					}
				}
				// respond cost is less that project budget
				else if ( $more_to_withdrawal < 0 && $this->cost != 0 )
				{
					$final_cost = (intval($transaction_hold->amount) - (intval($transaction_hold->amount) - intval($this->cost)));
					$final_cost_comission = intval($final_cost/100*$safe_deal_comission);
					$sql = sprintf("UPDATE `wallet_transactions` SET `amount` = '%d', `timestamp_modified` = UNIX_TIMESTAMP() WHERE `transaction_id` = '%s'",$final_cost,$transaction_hold->transaction_id);
					$sql2 = sprintf("UPDATE `wallet_transactions` SET `amount` = '%d', `timestamp_modified` = UNIX_TIMESTAMP() WHERE `transaction_id` = '%s'",$final_cost_comission,$transaction_hold_comission->transaction_id);
					try {
						$db->query($sql);
						$db->query($sql2);
					}
					catch ( Exception $e )
					{
						$response["message"] = "Не удалось выполнить перерасчёт";
						return $response;
					}
				}
			}

			$sql = sprintf("UPDATE `project_responds` SET `%s` = '%s', `modify_timestamp` = UNIX_TIMESTAMP() WHERE `respond_id` = '%d'",$field,$value,$this->respond_id);
		}
		else
		{
			$sql = sprintf("UPDATE `project_responds` SET `%s` = '%s' WHERE `respond_id` = '%d'",$field,$value,$this->respond_id);
		}
		try {
			$db->query($sql);
			// if respond accepted -> mark project as 'in progress'
			if ( $field == "status_id" && $value == "3" )
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
		// echo "aaas";
		$data["descr"] = filter_string($data["descr"]);
		$sql = sprintf("INSERT INTO `project_responds` (`for_project_id`,`user_id`,`created`,`descr`,`cost`,`status_id`,`modify_timestamp`)
		VALUES ('%d','%d',UNIX_TIMESTAMP(),'%s','%d',1,UNIX_TIMESTAMP())",
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
			$response["error_e"] = $e->getMessage();
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
			$response["message"] = "Заявка не в работе";
			return $response;
		}
		$db->autocommit(false);
		try {
			$transactions = Array(
				"safe_hold" => Array(),
				"safe_hold_comission" => Array(),
				"overcost" => Array(),
				"overcost_comission" => Array(),
			);
			// check safe deal
			if ( $db->getValue("project","safe_deal","safe_deal",Array("project_id"=>$this->for_project_id)) == 1 ) // project is safe deal. check balances
			{
				// check project author balance > respond cost
				// get HOLD transaction for safe project
				$current_user->init_wallet();
				$find_transaction = Array (
					"for_project_id" => $this->for_project_id,
					"type" => "HOLD",
					"descr" => "Удержание за безопасную сделку"
				);
				$transactions["safe_hold"] = $current_user->wallet->find_transaction($find_transaction);
				if ( !isset($transactions["safe_hold"]->transaction_id) )
				{
					$response["message"] = "Невозможно найти транзакцию на удержание (БС)";
					return $response;
				}

				// get HOLD transaction for safe project comission
				$find_transaction = Array (
					"reference_id" => $transactions["safe_hold"]->transaction_id,
					"for_project_id" => $this->for_project_id,
					"type" => "HOLD",
					"descr" => "Удержание за безопасную сделку (комиссия)"
				);
				$transactions["safe_hold_comission"] = $current_user->wallet->find_transaction($find_transaction);

				// more to withdrawal hold transaction
				$find_transaction = Array (
					"reference_id" => $transactions["safe_hold"]->transaction_id,
					"for_project_id" => $this->for_project_id,
					"type" => "HOLD",
					"descr" => "Удержание сверх бюджета в проекте"
				);
				$transactions["overcost"] = $current_user->wallet->find_transaction($find_transaction);

				$find_transaction = Array (
					"reference_id" => $transactions["safe_hold"]->transaction_id,
					"for_project_id" => $this->for_project_id,
					"type" => "HOLD",
					"descr" => "Удержание сверх бюджета в проекте (комиссия)"
				);
				// $transaction_overcost_comission = $current_user->wallet->find_transaction($find_transaction);
				$transactions["overcost_comission"] = $current_user->wallet->find_transaction($find_transaction);

				// confirm previously HOLD amount as withdrawal from wallet
				// $transactions["safe_hold"] = $transactions["safe_hold"];
				// $transactions["safe_hold_comission"] = $transactions["safe_hold_comission"];
				$system_user = new User(1);
				$system_user->init_wallet();
				foreach ( $transactions as $name => $transaction )
				{
					if ( !isset($transaction->transaction_id) ) continue;
					$transaction->commit = false;
					if ( $current_user->wallet->confirm_holded_transaction((array)$transaction) !== true )
					{
						$response["message"] = "Не удалось подтвердить транзакцию HOLD";
						return $response;
					}
					if ( strstr($name,"comission") !== false )
					{
						// Payment to system (comission)
						$new_transaction = Array (
							"reference_id"=>$transaction->transaction_id,
							"type"=>"PAYMENT",
							"amount"=>intval($transaction->amount),
							"descr"=>$transaction->descr,
							"for_project_id"=>$this->for_project_id,
							"commit"=>false
						);
						if ( $system_user->wallet->create_transaction($new_transaction) === false )
						{
							$response["message"] = "Ошибка зачисления средств в систему";
							return $response;
						}
					}
				}
				// Payment to performer
				$respond_user = new User($this->user_id);
				$respond_user->init_wallet();
				// $project_title = $db->getValue("project","title","title",Array("project_id"=>$this->for_project_id,"user_id"=>$current_user->user_id));
				$project_cost = $db->getValue("project","cost","cost",Array("project_id"=>$this->for_project_id,"user_id"=>$current_user->user_id));
				$cost = (intval($this->cost) > 0) ? intval($this->cost) : intval($project_cost);
				$new_transaction = Array (
					"reference_id"=>$transactions["safe_hold"]->transaction_id,
					"type"=>"PAYMENT",
					"amount"=>intval($cost),
					"descr"=>"Зачисление за исполненную заявку",
					"for_project_id"=>$this->for_project_id,
					"commit"=>false
				);

				if ( ($transaction_id = $respond_user->wallet->create_transaction($new_transaction)) === false )
				{
					$response["message"] = "Ошибка зачисления средств исполнителю";
					return $response;
				}
			}
			$insert = sprintf("INSERT INTO `user_responds` (`user_id`,`project_id`,`author_id`,`descr`,`created`,`grade`)
			VALUES ('%d','%d','%d','%s',UNIX_TIMESTAMP(),'%d')",$this->user_id,$this->for_project_id,$current_user->user_id,$descr,$grade);
			// echo $insert;
			if ( $db->query($insert) && $db->affected_rows == 1 )
			{
				// $update = $this->update("status_id",5);
				$db->query(sprintf("UPDATE `project_responds` SET `status_id` = 5 WHERE `respond_id` = '%d'",$this->respond_id));
				$db->query(sprintf("UPDATE `users` SET `rating` = (SELECT SUM(`grade`) FROM `user_responds` WHERE `user_id` = '%d') WHERE `user_id` = '%d'",$this->user_id,$this->user_id));
				$db->query(sprintf("UPDATE `project` SET `status_id` = '3' WHERE `project_id` = '%d' AND `user_id` = '%d'",$this->for_project_id,$current_user->user_id));
				// $response["update"] = $update;
				$response["result"] = "true";
				$response["message"] = "Отзыв опубликован, проект закрыт";
				$db->commit();
			}
		}
		catch ( Exception $e )
		{
			$response["error"] = $e->getMessage();
			$db->rollback();
		}
		return $response;
	}

	public static function block($respond_id, $message_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Доступ запрещён"
		);
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 ) return $response;
		if ( !$respond_id || intval($respond_id) <= 0 ) return;
		$db->autocommit(false);
		// $sql = sprintf("UPDATE `users` SET `status_id` = '3' WHERE `user_id` = '%d'",$id);
		try {
			$respond = new ProjectRespond($respond_id);
			if ( $respond->status_id != 1 )
			{
				$response["message"] = "Статус не соответствует 'Опубликован'";
				return $response;
			}
			if ( intval($db->getValue("warnings","warning_id","warning_id",Array("for_respond_id"=>$respond->respond_id))) > 0 )
			{
				$response["message"] = "Предупреждение уже вынесено";
				return $response;
			}

			$sql = sprintf("UPDATE `project_responds` SET `status_id` = 4 WHERE `respond_id` = '%d'",$respond->respond_id);
			if ( $db->query($sql) && $db->affected_rows > 0 )
			{
				$sql = sprintf("INSERT INTO `warnings` (`for_project_id`,`for_respond_id`,`for_user_id`,`message`,`user_id`,`timestamp`)
				VALUES ('%d','%d','%d','%s','%d',UNIX_TIMESTAMP())",$respond->for_project_id,$respond_id,$respond->user_id,$message_text,$current_user->user_id);
				if ( $db->query($sql) && $db->affected_rows > 0 )
				{
					$response["message"] = "Отзыв заблокировн, вынесено предупреждение";
					$db->commit();
					return $response;
				}
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;

	}
}

?>