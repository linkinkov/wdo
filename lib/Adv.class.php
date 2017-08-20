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
		if ( is_array($adv_id) && isset($adv_id["adv_id"]) ) $adv_id = $adv_id["adv_id"];
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
		$required_fields = Array("cat_id","subcat_id","title","descr","portfolio_id","prolong_limit","prolong_days");
		foreach ( $required_fields as $field )
		{
			if ( !isset($data[$field]) )
			{
				$response["message"] = "Некорректные данные";
				$response["field"] = $field;
				return $response;
			}
		}
		$status_id = ( $data["as_draft"] == 0 ) ? 2 : 3;
		$adv_id = md5($current_user->user_id.time());
		$sql = sprintf("INSERT INTO `adv` (`adv_id`,`user_id`,`cat_id`,`subcat_id`,`title`,`descr`,`portfolio_id`,`prolong_limit`,`prolong_days`,`created`,`modified`,`status_id`)
		VALUES ('%s','%d','%d','%d','%s','%s','%d','%d','%d',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),'%d')",
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
		// echo $sql;
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["adv_id"] = $adv_id;
			$response["message"] = "Создано объявление";
			// $this->adv_id = $adv_id;
		}
		catch ( Exception $e )
		{
			$response["message"] = "Ошибка создания объявления";
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
		foreach ( $data as $f=>$v )
		{
			if ( $f == "as_draft" )
			{
				$f = "status_id";
				$v = ( $v == "0" ) ? 2 : 3;
			}
			$str[] = sprintf("`%s` = '%s'",$f,$v);
		}
		$sql = sprintf("UPDATE `adv` SET %s WHERE `adv_id` = '%s' AND `user_id` = '%d'",implode(",",$str),$this->adv_id,$current_user->user_id);
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Обновлено";
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
			$response["message"] = "Ошибка обновления объявления";
		}
		return $response;
	}

	public static function get_list($limit = 3)
	{
		global $db;
		$sql = "SELECT * FROM `adv` WHERE `status_id` = '1'";
		$list = Array();
		try {
			$list = $db->queryRows($sql);
			foreach ( $list as $adv )
			{
				$adv->link = ( $adv->portfolio_id == 0 ) ? sprintf(HOST.'/profile/id%d',$adv->user_id) : sprintf('/profile/id%d?pfid=%d#portfolio',$adv->user_id,$adv->portfolio_id);
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}
		return $list;
	}
}