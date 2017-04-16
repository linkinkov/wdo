<?php

class User
{
	public function __construct($user_id = false, $username = false)
	{
		global $db;
		if ( isset($_COOKIE["city_id"]) && isset($_COOKIE["city_name"]) )
		{
			$this->city_id = intval($_COOKIE["city_id"]);
			$this->city_name = trim($_COOKIE["city_name"]);
		}
		else
		{
			$this->city_id = 1;
			$this->city_name = "Москва";
		}
		if ( intval($user_id) == 0 && $username == false )
		{
			$this->user_id = 0;
			return;
		}
		$where = (intval($user_id) > 0) ? sprintf("`user_id` = '%d'",$user_id) : sprintf("`username` = '%s'",$username);
		$sql = "SELECT `user_id`,`username`, `last_name`, `first_name`, `company_name`, `type_id`, `registered`, `last_login`, `as_performer`, `state_id`, `rating` FROM `users` WHERE $where";
		try {
			$info = $db->queryRow($sql);
			if ( sizeof($info) ) foreach ( $info as $p => $v ) $this->$p = htmlentities($v); else $this->error = true;
			$filter = Array("username","last_name","first_name","company_name","phone","skype","birthday");
			foreach ( $filter as $field )
			{
				if ( isset($this->$field) ) $this->$field = ( mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $this->$field) );
			}
			$this->realUserName = ( $info->type_id ==  1 ) ? trim(implode(" ",Array($info->last_name,$info->first_name))) : $info->company_name;
			if ( $this->user_id != $_SESSION["user_id"] ) unset($this->username);
		}
		catch (Exception $e)
		{
			$this->user_id = 0;
			return false;
		}
	}

	public function getPrivateInfo()
	{
		global $db;
		$allowed_params = Array("username","first_name","last_name");
		foreach ( $this as $param )
		{
			echo $param;
		}
	}

	public function getRespondsCounters()
	{
		global $db;
		$this->responds = new stdClass();
		try {
			$this->responds->good_counter = $db->getValue("user_responds","COUNT(`id`)","good",Array("user_id"=>$this->user_id,"grade"=>">=5"));
			$this->responds->bad_counter = $db->getValue("user_responds","COUNT(`id`)","bad",Array("user_id"=>$this->user_id,"grade"=>"<5"));
			$this->responds->total_counter = $this->responds->good_counter + $this->responds->bad_counter;
		}
		catch ( Exception $e )
		{
			// return $e->getMessage();
		}
	}

	public function update($field,$value)
	{
		global $db;
		global $lang;
		global $user;
		$value = htmlentities(addslashes($value));
		$min_pass_length = 4;
		$response = Array(
			"result" => "false",
			"message" => $lang["error_occured"]
		);

		$sql = sprintf("UPDATE `users` SET `%s` = '%s' WHERE `user_id` = '%d'",$field,$value,$this->user_id);
		if ( $field == "password" )
		{
			if ( strlen($value) < $min_pass_length )
			{
				$response["message"] = sprintf($lang["password_too_short"],$min_pass_length);
				return $response;
			}
			$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
			$value = hash('sha512', hash('sha512',$value) . $random_salt);
			$sql = sprintf("UPDATE `users` SET `%s` = '%s', `salt` = '%s' WHERE `user_id` = '%d'",$field,$value,$random_salt,$this->user_id);
		}
		else if ( $field == "username" )
		{
			if ( strlen($value) < 3 )
			{
				$response["message"] = sprintf($lang["username_too_short"],3);
				return $response;
			}
			else if ( preg_match("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/",$value) )
			{
				$response["message"] = $lang["invalid_chars"];
				return $response;
			}
		}
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = $lang["saved"];
		}
		catch (Exception $e)
		{
			$response["result"] = "false";
			$response["message"] = ( $e->getCode() == 1062 ) ? "Такой пользователь уже существует" : $e->getMessage();
			return $response;
		}
	}
	
	public static function delete($user_id)
	{
		global $db;
		global $lang;
		global $user;
		$sql = sprintf("UPDATE `users` SET `username` = CONCAT(`username`,'-',UNIX_TIMESTAMP()), `deleted` = 1 WHERE `user_id` = '%d'",$user_id);
		$target_user = new User($user_id);
		if ( intval($user_id) && $db->query($sql) )
		{
			$response["result"] = "true";
			$response["message"] = $lang["user_deleted"];
			$user->log_activity("users",Array("action"=>"delete","descr"=>sprintf("%s",$target_user->username)));
		}
		else
		{
			$response["result"] = "true";
			$response["message"] = $lang["error_occured"];
		}
		return $response;
	}
	
	public static function getRealUserName($user_id)
	{
		global $db;
		global $user;
		global $lang;
		$response = Array(
			"result" => "false",
			"message" => $lang["error_occured"]." user_id"
		);
		$realUserName = "";
		if ( intval($user_id) <= 0 ) return $response;
		try {
			$sql = sprintf("SELECT `username`, `last_name`, `first_name`,`company_name`,`type_id` FROM `users` WHERE `user_id` = '%d'",intval($user_id));
			$info = $db->queryRow($sql);
			if ( isset($info->username) )
			{
				$info->last_name = mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $info->last_name);
				$info->first_name = mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $info->first_name);
				$info->company_name = mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $info->company_name);
				$realUserName = ( $info->type_id ==  1 ) ? trim(implode(" ",Array($info->last_name,$info->first_name))) : $info->company_name;
			}
			return $realUserName;
		}
		catch (Exception $e)
		{
			$response["message"] = $e->getMessage();
			return $response;
		}
	}

	public static function getList($start = 0,$limit = 20,$state_id = false)
	{
		global $db;
		global $user;
		global $lang;
		$response = Array(
			"result" => "false",
			"message" => $lang["error_occured"]
		);
		$where["state"] = ( intval($state_id) > 0 ) ? sprintf("`state_id` = '%d'",$state_id) : "1";
		try {
			return $db->queryRows(sprintf("SELECT `user_id` FROM `users` WHERE %s LIMIT %d, %d",implode("AND",$where),$start,$limit));
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}

?>