<?php

require_once(PD.'/lib/Attach.class.php');

class Project
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
		$public_fields = Array("title","descr","user_id","created","status_id","status_name","cost","accept_till","start_date","end_date","cat_name","subcat_name","safe_deal","vip","views","for_user_id","for_event_id");
		array_walk($public_fields,'sqlize_array');
		$sql = sprintf("SELECT %s, `cats`.`translated` as `cat_name_translated`, `subcats`.`translated` as `subcat_name_translated`
		FROM `project`
		LEFT JOIN `cats` ON `cats`.`id` = `project`.`cat_id`
		LEFT JOIN `subcats` ON `subcats`.`id` = `project`.`subcat_id`
		LEFT JOIN `project_statuses` ON `project_statuses`.`id` = `project`.`status_id`
		WHERE `project_id` = '%d'",implode(",",$public_fields),$id);
		// echo $sql;
		try {
			$prj = $db->queryRow($sql);
			if ( sizeof($prj) )
			{
				foreach ( $prj as $p => $v ) $this->$p = ($v);
			}
			else
			{
				return;
			}
			$this->project_id = $id;
			$filter = Array("title","descr","cost");
			foreach ( $filter as $field )
			{
				// if ( isset($this->$field) ) $this->$field = filter_string($this->$field,'out');
				if ( isset($this->$field) ) $this->$field = html_entity_decode($this->$field);
			}
			$this->continuous = 0;
			$this->duration_ms = 86400;
			if ( date("Ymd",$this->start_date) != date("Ymd",$this->end_date) )
			{
				$this->continuous = 1;
				$this->duration_ms = $this->end_date - $this->start_date;
			}
			if ( $this->status_id == 1 && time() > $this->accept_till )
			{
				$this->update("status_id",4);
			}
			$this->is_project_author = ( $this->user_id == $current_user->user_id ) ? 1 : 0;
			if ( $this->is_project_author == 1 )
			{
				$this->performer = $this->get_performer();
			}
			else
			{
				unset($this->for_event_id);
			}
			$title_tr = strtolower(r2t($this->title));
			$this->project_link = HOST.'/project/'.$this->cat_name_translated.'/'.$this->subcat_name_translated.'/p'.$this->project_id.'/'.$title_tr.'.html';

			// $this->status_name = $db->getValue("project_statuses","status_name","status_name",Array("id"=>$this->status_id));
			$this->error = false;
		}
		catch (Exception $e)
		{
			// $this->error = $e->getMessage();
			return;
		}
	}

	private function get_performer()
	{
		global $db;
		if ( $this->is_project_author != 1 ) return false;
		$sql = sprintf("SELECT `project_responds`.`user_id`,`project_responds`.`cost`,`real_user_name`
		FROM `project_responds`
		LEFT JOIN `users` ON `users`.`user_id` = `project_responds`.`user_id`
		WHERE `for_project_id` = '%d' AND `project_responds`.`status_id` IN (3,5)",$this->project_id);
		$not_selected = Array(
			"performer_id" => 0,
			"real_user_name" => "<text class='text-warning'>Не выбран</text>",
			"cost" => 0
		);
		try {
			// echo $sql;
			$i = $db->queryRow($sql);
			if ( isset($i->user_id) )
			{
				return $i;
			}
			else 
			{
				return $not_selected;
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
			return $not_selected;
		}
	}

	public function get_responds_counter()
	{
		global $db;
		try {
			$counter = $db->getValue("project_responds","COUNT(`respond_id`)","counter",Array("for_project_id"=>$this->project_id));
			return $counter;
		}
		catch (Exception $e)
		{
			// return $e->getMessage();
			return false;
		}
	}

	public static function get_accepted_respond($project_id)
	{
		global $db;
		try {
			$respond_id = $db->getValue("project_responds","respond_id","respond_id",Array("for_project_id"=>$project_id,"status_id"=>3));
			return $respond_id;
		}
		catch (Exception $e)
		{
			// return $e->getMessage();
			return false;
		}
	}

	public function update($field,$value)
	{
		global $db;
		global $lang;
		$value = htmlentities(addslashes($value));
		$response = Array(
			"result" => "true",
			"message" => "Обновлено"
		);

		$sql = sprintf("UPDATE `project` SET `%s` = '%s' WHERE `project_id` = '%d'",$field,$value,$this->project_id);
		$db->autocommit(false);

		try {
			if ( $field == "status_id" && $value == "5" )
			{
				$project_user = new User($this->user_id);
				$project_user->init_wallet();
				$transactions = Array(
					"hold" => Array(),
					"hold_comission" => Array(),
					"hold_vip" => Array()
				);
				$find_transaction = Array (
					"for_project_id" => $this->project_id,
					"type" => "HOLD",
					"descr" => "Удержание средств за безопасную сделку"
				);
				$transactions["hold"] = $project_user->wallet->find_transaction($find_transaction);

				$find_transaction = Array (
					"for_project_id" => $this->project_id,
					"type" => "HOLD",
					"descr" => "Удержание средств за безопасную сделку (комиссия)"
				);
				$transactions["hold_comission"] = $project_user->wallet->find_transaction($find_transaction);

				$find_transaction = Array (
					"for_project_id" => $this->project_id,
					"type" => "HOLD",
					"descr" => "Удержание средств за платный проект"
				);
				$transactions["hold_vip"] = $project_user->wallet->find_transaction($find_transaction);
				foreach ( $transactions as $name => $transaction )
				{
					if ( !isset($transaction->transaction_id) ) continue;
					$transaction->commit = false;
					if ( $project_user->wallet->cancel_holded_transaction((array)$transaction) !== true )
					{
						$response["message"] = sprintf("Не удалось отменить транзакцию HOLD: %s",$name);
						return $response;
					}
				}
			}
			if ( $db->query($sql) )
			{
				$db->commit();
				$response["message"] = "Обновлено";
				$response["result"] = "true";
			}
			$this->$field = $value;
		}
		catch (Exception $e)
		{
			$response["result"] = "false";
			$response["message"] = ( $e->getCode() == 1062 ) ? "Такой проект уже существует" : $e->getMessage();
		}
		return $response;
	}
	
	public static function publish($data)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Проверьте данные"
		);
		if ( $current_user->status_id != 1 )
		{
			$response["message"] = "Ваш аккаунт заблокирован";
			return $response;
		}
		$all_fields = Array("title","descr","cost","accept_till","start_date","end_date","cat_id","subcat_id","safe_deal","vip","for_user_id","youtube_links","for_event_id");
		$req_fields = Array("title","descr","accept_till","start_date","end_date","cat_id","subcat_id");
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
				$data[$field] = "";
			}
		}
		if ( $data["accept_till"] > $data["start_date"] )
		{
			$response["field"] = $data["accept_till"];
			return $response;
		}
		$status_id = 1;
		if ( $data["safe_deal"] == "true" ) $data["safe_deal"] = 1;
		if ( $data["vip"] == "true" )
		{
			$data["vip"] = 1;
			$status_id = 6;
		}
		$vip_cost = ( $data["vip"] == 1 ) ? $db->getValue("settings","param_value","value",Array("param_name"=>"vip_cost")) : 0;
		try {
			$db->autocommit(false);
			$sql = sprintf("INSERT INTO `project` (`title`,`descr`,`cost`,`created`,`status_id`,`user_id`,`accept_till`,`start_date`,`end_date`,`cat_id`,`subcat_id`,`city_id`,`safe_deal`,`vip`,`views`,`for_user_id`,`for_event_id`,`last_prolong`)
			VALUES ('%s','%s','%d',UNIX_TIMESTAMP(),'%d','%d','%d','%d','%d','%d','%d','%d','%d','%d',0,'%d','%s',0)",
				filter_string($data["title"],'in'),
				filter_string($data["descr"],'in'),
				intval($data["cost"]),
				intval($status_id),
				intval($current_user->user_id),
				intval($data["accept_till"]),
				intval($data["start_date"]),
				intval($data["end_date"]),
				intval($data["cat_id"]),
				intval($data["subcat_id"]),
				intval($_COOKIE['city_id']),
				intval($data["safe_deal"]),
				intval($data["vip"]),
				intval($data["for_user_id"]),
				trim($data["for_event_id"])
			);
			$current_user->init_wallet();
			if ( $db->query($sql) && $db->insert_id > 0 )
			{
				// echo "aaa2";
				$project_id = $db->insert_id;
				$data["cost_w_comission"] = $data["cost"];
				if ( $data["safe_deal"] == 1 )
				{
					// HOLD for safe deal, amount = project cost
					if ( intval($data["cost"]) <= 0 )
					{
						$response["message"] = "Укажите бюджет";
						return $response;
					}
					$data["safe_deal_comission"] = $db->getValue("settings","param_value","safe_deal_comission",Array("param_name"=>"safe_deal_comission"));
					$data["cost_w_comission"] = $data["cost"] + $data["cost"]/100*$data["safe_deal_comission"];
					if ( intval($current_user->wallet->balance) < intval($data["cost_w_comission"]) )
					{
						$response["message"] = "Недостаточно средств";
						$response["balance"] = $current_user->wallet->balance;
						$response["error"] = "Ваш баланс: ".$current_user->wallet->balance." руб.<br />Требуется: ".(intval($vip_cost) + intval($data["cost_w_comission"]))." руб.";
						return $response;
					}
					else
					{
						$new_transaction = Array (
							"reference_id"=>"",
							"type"=>"HOLD",
							"amount"=>intval($data["cost"]),
							"descr"=>"Удержание средств за безопасную сделку",
							"for_project_id"=>$project_id,
							"commit"=>false
						);
						if ( ($transaction_id = $current_user->wallet->create_transaction($new_transaction)) === false )
						{
							$response["message"] = "Ошибка блокирования средств";
							return $response;
						}
						$new_transaction = Array (
							"reference_id"=>$transaction_id,
							"type"=>"HOLD",
							"amount"=>intval($data["cost"]/100*$data["safe_deal_comission"]),
							"descr"=>"Удержание средств за безопасную сделку (комиссия)",
							"for_project_id"=>$project_id,
							"commit"=>false
						);
						if ( ($transaction_id = $current_user->wallet->create_transaction($new_transaction)) === false )
						{
							$response["message"] = "Ошибка блокирования средств";
							return $response;
						}
					}
				}
				// HOLD for VIP project, amount = settings.vip_cost
				if ( $data["vip"] == 1 )
				{
					$vip_cost = $db->getValue("settings","param_value","value",Array("param_name"=>"vip_cost"));
					// $current_user->init_wallet();
					if ( intval($current_user->wallet->balance) < intval($vip_cost) )
					{
						$total_cost = ($data["safe_deal"] == 1) ? (intval($vip_cost) + intval($data["cost_w_comission"])) : intval($vip_cost);
						$response["message"] = "Недостаточно средств";
						$response["error"] = "Ваш баланс: ".$current_user->wallet->balance." руб.<br />Требуется: ".$total_cost." руб.";
						return $response;
					}

					$new_transaction = Array (
						"reference_id"=>"",
						"type"=>"HOLD",
						"amount"=>intval($vip_cost),
						"descr"=>"Удержание средств за платный проект",
						"for_project_id"=>$project_id,
						"commit"=>false
					);
					if ( ($transaction_id = $current_user->wallet->create_transaction($new_transaction)) === false )
					{
						$response["message"] = "Ошибка блокирования средств за платный проект";
						return $response;
					}
				}
				if ( Attach::save_from_user_upload_dir('for_project_id',$project_id,$data["youtube_links"]) )
				{
					$db->commit();
					$response["result"] = "true";
					$response["message"] = "Проект опубликован";
					$cat_tr = strtolower(r2t(Category::get_name($data["cat_id"])));
					$subcat_tr = strtolower(r2t(SubCategory::get_name($data["subcat_id"])));
					$title_tr = strtolower(r2t($data["title"]));
					$response["project_link"] = HOST.'/project/'.$cat_tr.'/'.$subcat_tr.'/p'.$project_id.'/'.$title_tr.'.html';
					$db->autocommit(true);
				}
				else
				{
					$response["error"] = "Не удалось прикрепить файлы к проекту";
				}
			}
			else
			{
				$response["message"] = "error";
			}
		}
		catch ( Exception $e )
		{
			// $response["error"] = $e->getMessage();
		}
		return $response;
	}

	public static function block($project_id,$recipient_id,$message)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Проверьте данные"
		);
		if ( $current_user->user_id <= 0 )
		{
			$response["message"] = "Доступ запрещен";
			return $response;
		}
		$project_status = $db->getValue("project","status_id","status_id",Array("project_id"=>$project_id,"user_id"=>$recipient_id));
		switch ( $project_status )
		{
			case "3":
				$response["message"] = "Проект уже выполнен";
				return $response;
			case "4":
				$response["message"] = "Проект истёк";
				return $response;
			case "5":
				$response["message"] = "Проект уже заблокирован";
				return $response;
		}
		$db->autocommit(false);
		$project_user = new User($recipient_id);
		$project_user->init_wallet();
		$transactions = Array(
			"hold" => Array(),
			"hold_comission" => Array(),
			"hold_vip" => Array()
		);

		try {
			// update project status
			$sql = sprintf("UPDATE `project` SET `status_id` = '5' WHERE `project_id` = '%d' AND `user_id` = '%d'",$project_id,$recipient_id);
			if ( $db->query($sql) && $db->affected_rows > 0 )
			{
				// insert warning for project
				$sql = sprintf("INSERT INTO `warnings` (`for_project_id`,`for_respond_id`,`for_user_id`,`message`,`user_id`,`timestamp`)
				VALUES ('%d',0,'%d','%s','%d',UNIX_TIMESTAMP())",$project_id,$recipient_id,$message,$current_user->user_id);
				if ( $db->query($sql) && $db->affected_rows > 0 )
				{
					$find_transaction = Array (
						"for_project_id" => $project_id,
						"type" => "HOLD",
						"descr" => "Удержание средств за безопасную сделку"
					);
					$transactions["hold"] = $project_user->wallet->find_transaction($find_transaction);

					$find_transaction = Array (
						"for_project_id" => $project_id,
						"type" => "HOLD",
						"descr" => "Удержание средств за безопасную сделку (комиссия)"
					);
					$transactions["hold_comission"] = $project_user->wallet->find_transaction($find_transaction);

					$find_transaction = Array (
						"for_project_id" => $project_id,
						"type" => "HOLD",
						"descr" => "Удержание средств за платный проект"
					);
					$transactions["hold_vip"] = $project_user->wallet->find_transaction($find_transaction);
					foreach ( $transactions as $name => $transaction )
					{
						if ( !isset($transaction->transaction_id) ) continue;
						$transaction->commit = false;
						if ( $project_user->wallet->cancel_holded_transaction((array)$transaction) !== true )
						{
							$response["message"] = sprintf("Не удалось отменить транзакцию HOLD: %s",$name);
							return $response;
						}
					}
					$db->commit();
					$response["message"] = "Предупреждение пользователю вынесено, проект заблокирован";
					$response["result"] = "true";
				}
			}
		}
		catch ( Exception $e )
		{
			// $response["message"] = $e->getMessage();
		}
		return $response;
	}
}

?>