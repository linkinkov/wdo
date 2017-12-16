<?php

require_once(PD.'/lib/Attach.class.php');

class Adv
{
	public function __construct($adv_id = false)
	{
		global $db;
		global $current_user;
		$response["result"] = "false";
		if ( $current_user->user_id <= 0 )
		{
			$response["message"] = "Доступ запрещен";
			return $response;
		}
		if ( is_array($adv_id) && isset($adv_id["id"]) ) $adv_id = $adv_id["id"];
		$sql = sprintf("SELECT * FROM `adv` WHERE `adv_id` = '%s'",$adv_id);
		$i = $db->queryRow($sql);
		if ( isset($i->adv_id) )
		{
			foreach ( $i as $f=>$v ) $this->$f = $v;
		}
	}

	public static function create($data)
	{
		global $db;
		global $current_user;
		$response["result"] = "false";
		if ( $current_user->user_id <= 0 )
		{
			$response["message"] = "Доступ запрещен";
			return $response;
		}
		$required_fields = Array("cat_id","subcat_id","title","portfolio_id","prolong_limit","prolong_days");
		foreach ( $required_fields as $field )
		{
			if ( !isset($data[$field]) || strlen($data[$field]) <= 0 )
			{
				$response["message"] = "Некорректные данные";
				$response["field"] = $field;
				return $response;
			}
		}
		$db->autocommit(false);
		$status_id = ( $data["as_draft"] == 0 ) ? 2 : 3;
		$adv_id = md5($data["title"].$current_user->user_id);
		$sql = sprintf("INSERT INTO `adv` (`adv_id`,`user_id`,`cat_id`,`subcat_id`,`title`,`descr`,`portfolio_id`,`prolong_limit`,`prolong_days`,`created`,`modified`,`status_id`,`last_prolong`,`accepted`,`hold_transaction_id`)
		VALUES ('%s','%d','%d','%d','%s','%s','%d','%d','%d',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),'%d',0,0,'')",
		$adv_id,
		$current_user->user_id,
		$data["cat_id"],
		$data["subcat_id"],
		$data["title"],
		$data["descr"],
		$data["portfolio_id"],
		$data["prolong_limit"],
		$data["prolong_days"],
		$status_id
		);

		try {
			$adv_cost = $db->getValue("settings","param_value","adv_cost",Array("param_name"=>"adv_cost"));
			$new_transaction = Array (
				"reference_id"=>"",
				"type"=>"HOLD",
				"amount"=>intval($adv_cost),
				"descr"=>"Удержание за размещение объявления",
				"for_project_id"=>0,
				"for_adv_id"=>$adv_id,
				"commit"=>false
			);
			$current_user->init_wallet();
			if ( $current_user->wallet->balance < intval($adv_cost) )
			{
				$response["message"] = "Недостаточно средств";
				return $response;
			}
			if ( $current_user->wallet->create_transaction($new_transaction) === false )
			{
				$response["message"] = "Не удалось создать транзакцию по удержанию средств";
				return $response;
			}
			$db->query($sql);
			$response["result"] = "true";
			$response["adv_id"] = $adv_id;
			$response["message"] = "Объявление успешно создано";
			$db->commit();
			// $this->adv_id = $adv_id;
		}
		catch ( Exception $e )
		{
			$response["message"] = ( $e->getCode() == 1062 ) ? "Такое объявление уже существует" : "Ошибка создания объявления";
			$response["error"] = $e->getMessage();
		}
		return $response;
	}
	
	public function update($data)
	{
		global $db;
		global $current_user;
		$response["result"] = "false";
		if ( $current_user->user_id <= 0 )
		{
			$response["message"] = "Доступ запрещен";
			return $response;
		}
		$str = Array();
		foreach ( $data as $f => &$v )
		{
			if ( $f == "as_draft" )
			{
				$f = "status_id";
				$v = ( $v == "0" ) ? 2 : 3;
				$data[$f] = $v;
			}
			$str[] = sprintf("`%s` = '%s'",$f,$v);
		}
		if ( $current_user->template_id != 2 && in_array($data["status_id"], Array("1","5")) )
		{
			$response["message"] = "Доступ запрещён";
			return $response;
		}
		$sql = sprintf("UPDATE `adv` SET %s WHERE `adv_id` = '%s' AND `user_id` = '%d'",implode(",",$str),$this->adv_id,$this->user_id);
		$db->autocommit(false);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Обновлено";
			}
			$adv_user = new User($this->user_id);
			$adv_user->init_wallet();
			if ( isset($data["status_id"]) && $data["status_id"] == "1" )
			{
				$sql = sprintf("UPDATE `adv` SET `accepted` = UNIX_TIMESTAMP() WHERE `adv_id` = '%s' AND `user_id` = '%d'",$this->adv_id,$this->user_id);
				if ( $db->query($sql) )
				{
					$response["result"] = "true";
					$response["message"] = "Обновлено";
				}
				if ( $this->status_id == 2 )
				{
					
					$find_transaction = Array (
						"for_adv_id" => $this->adv_id,
						"type" => "HOLD",
						"descr" => "Удержание за размещение объявления"
					);
					$hold_transaction = $adv_user->wallet->find_transaction($find_transaction);
					$hold_transaction->commit = "false";
					if ( isset($hold_transaction->transaction_id) )
					{
						if ( $adv_user->wallet->confirm_holded_transaction((array)$hold_transaction) !== true )
						{
							$response["result"] = "false";
							$response["message"] = sprintf("Не удалось подтвердить транзакцию: %s",$hold_transaction->transaction_id);
							return $response;
						}
					}
				}
			}
			// return to user hold transaction
			else if ( isset($data["status_id"]) && $data["status_id"] == "5" && $this->status_id == 2 )
			{
				$find_transaction = Array (
					"for_adv_id" => $this->adv_id,
					"type" => "HOLD",
					"descr" => "Удержание за размещение объявления"
				);
				$hold_transaction = $adv_user->wallet->find_transaction($find_transaction);
				if ( isset($hold_transaction->transaction_id) )
				{
					$hold_transaction->commit = "false";
					if ( $adv_user->wallet->cancel_holded_transaction((array)$hold_transaction) !== true )
					{
						$response["result"] = "false";
						$response["message"] = sprintf("Не отменить транзакцию: %s",$hold_transaction->transaction_id);
						return $response;
					}
				}
			}
			// if user update canceled adv - create new hold transaction
			else if ( isset($data["status_id"]) && $data["status_id"] == "2" && $this->status_id == 5 )
			{
				$adv_cost = $db->getValue("settings","param_value","adv_cost",Array("param_name"=>"adv_cost"));
				$new_transaction = Array (
					"reference_id"=>"",
					"type"=>"HOLD",
					"amount"=>intval($adv_cost),
					"descr"=>"Удержание за размещение объявления",
					"for_project_id"=>0,
					"for_adv_id"=>$this->adv_id,
					"commit"=>false
				);
				$adv_user->init_wallet();
				if ( $adv_user->wallet->balance < intval($adv_cost) )
				{
					$response["message"] = "Недостаточно средств";
					return $response;
				}
				if ( $adv_user->wallet->create_transaction($new_transaction) === false )
				{
					$response["message"] = "Не удалось создать транзакцию по удержанию средств";
					return $response;
				}

			}
			$db->commit();
		}
		catch ( Exception $e )
		{
			$response["message"] = "Ошибка обновления объявления";
			$response["_error"] = $e->getMessage();
		}
		return $response;
	}

	public static function load_user_advs($status_id)
	{
		global $db;
		global $current_user;
		$response["result"] = "false";
		if ( $current_user->user_id <= 0 )
		{
			$response["message"] = "Доступ запрещен";
			return $response;
		}
		$sql = sprintf("SELECT * FROM `adv` WHERE `user_id` = '%d' AND `status_id` = '%d'",$current_user->user_id,$status_id);
		try {
			$response = $db->queryRows($sql);
		}
		catch ( Exception $e )
		{
			$response["message"] = "Произошла ошибка";
		}
		return $response;
	}

	public static function get_list($limit = 3, $status_id = 1, $order = "last_prolong", $dir = "DESC", $subcats = "", $random = "false")
	{
		global $db;
		$subcatsSql = "";
		if ( $subcats != "" )
		{
			$subcats = explode(",",$subcats);
			$subcatsSql = sprintf(" AND `subcat_id` IN ('%s')",implode("','",$subcats));
		}
		$sql = sprintf("SELECT * FROM `adv` WHERE `status_id` = '%d' %s ORDER BY `%s` %s LIMIT 0,%d",$status_id,$subcatsSql,$order,$dir,$limit);
		// echo $sql;
		$list = Array();
		try {
			$list = $db->queryRows($sql);
			foreach ( $list as $adv )
			{
				$adv->link = ( $adv->portfolio_id == 0 ) ? sprintf(HOST.'/profile/id%d',$adv->user_id) : sprintf('/profile/id%d#portfolio%d',$adv->user_id,$adv->portfolio_id);
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}
		if ( $random == "true" ) shuffle($list);
		return $list;
	}

	public static function promote($data)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Произошла ошибка"
		);
		if ( $current_user->user_id <= 0 ) return $response;
		if ( !isset($data["adv_id"]) || strlen($data["adv_id"]) != 32 ) return $response;
		$sql = sprintf("SELECT * FROM `adv` WHERE `user_id` = '%d' AND `status_id` = '1' AND `adv_id` = '%s'",$current_user->user_id,$data["adv_id"]);
		$found_adv = $db->queryRow($sql);
		if ( !isset($found_adv->adv_id) ) return $response;
		$find_transaction = Array (
			"for_project_id" => 0,
			"type" => "HOLD",
			"descr" => "Удержание средств за поднятие объявления"
		);
		$transaction_found = $current_user->wallet->find_transaction($find_transaction);
		if ( isset($transaction_found->timestamp) && $transaction_found->timestamp > $found_adv->last_prolong && strlen($found_adv->hold_transaction_id) == 32 )
		{
			// hold transaction already exists
			$transaction_hold_id_promote = $transaction_found->transaction_id;
		}
		else
		{
			$adv_promote_cost = $db->getValue("settings","param_value","param_value",Array("param_name"=>"adv_promote_cost"));
			$db->autocommit(false);
			$new_transaction = Array (
				"reference_id"=>"",
				"type"=>"HOLD",
				"amount"=>intval($adv_promote_cost),
				"descr"=>"Удержание средств за поднятие объявления",
				"for_project_id"=>"",
				"commit"=>false
			);
			$current_user->init_wallet();
			if ( $current_user->wallet->balance < intval($new_transaction["amount"]) )
			{
				$response["message"] = "Недостаточно средств";
				return $response;
			}
			if ( ($transaction_hold_id_promote = $current_user->wallet->create_transaction($new_transaction)) === false )
			{
				$response["message"] = "Не удалось создать транзакцию по удержанию средств";
				return $response;
			}
		}

		$sql = sprintf("UPDATE `adv` 
		SET `status_id` = 2, 
				`transaction_hold_id` = '%s'
				-- `cat_id` = '%d',
				-- `subcat_id` = '%d',
				-- `portfolio_id` = '%d',
				-- `title` = '%s',

		WHERE `adv_id` = '%s' 
			AND `user_id` = '%s'",
		$transaction_hold_id_promote, $current_user->user_id);
		if ( $db->query($sql) && $db->rows_affected > 0 )
		{
			$db->commit();
			$response["result"] = "true";
			$response["message"] = "Отправлено на модерацию";
		}
		return $response;
	}
}