<?php

class User
{
	public function __construct($user_id = false, $username = false, $login = false)
	{
		global $db;
		if ( $login == true )
		{
			if ( !isset($_SESSION["viewed_projects"]) )
			{
				$_SESSION["viewed_projects"] = Array();
			}
		}
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
			$this->avatar_path = HOST.'/user.getAvatar?user_id='.$this->user_id;
			if ( $this->user_id != $_SESSION["user_id"] && $login == false ) unset($this->username);
		}
		catch (Exception $e)
		{
			$this->user_id = 0;
			return false;
		}
	}

	public function get_responds_counters()
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

	public static function get_real_user_name($user_id)
	{
		global $db;
		global $lang;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
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
			// $response["error"] = $e->getMessage();
		}
		return $response;
	}

	public static function get_user_note($user_id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( intval($user_id) <= 0 || $current_user->user_id == 0 ) return $response;
		try {
			$response["result"] = "true";
			unset($response["message"]);
			$response["userNote"] = $db->getValue("user_notes","note_text","note_text",Array("user_id"=>$current_user->user_id,"for_user_id"=>$user_id));
			if ( $response["userNote"] == false ) $response["userNote"] = "";
		}
		catch (Exception $e)
		{
			// $response["error"] = $e->getMessage();
		}
		return $response;
	}

	public static function sendMessage($user_id,$message_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( trim($message_text) == "" ) return $response;
		if ( $current_user->user_id == 0 ) return $response;
		$uniq_id = md5(time().$message_text.$user_id);
		$sql = sprintf("INSERT INTO `messages` (`message_id`,`message_text`,`user_id_from`,`user_id_to`,`timestamp`) 
		VALUES ('%s','%s','%d','%d',UNIX_TIMESTAMP())",
		$uniq_id,
		$message_text,
		$current_user->user_id,
		$user_id);
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Сообщение отправлено";
		}
		catch ( Exception $e )
		{
		}
		return $response;
	}

	public static function addNote($user_id,$note_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( trim($note_text) == "" ) return $response;
		if ( $current_user->user_id == 0 ) return $response;
		$uniq_id = md5(time().$note_text.$user_id);
		$sql = sprintf("INSERT INTO `messages` (`note_id`,`note_text`,`user_id`,`user_id_to`,`timestamp`) 
		VALUES ('%s','%s','%d','%d',UNIX_TIMESTAMP())",
		$uniq_id,
		$note_text,
		$current_user->user_id,
		$user_id);
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Заметка сохранена";
		}
		catch ( Exception $e )
		{
		}
		return $response;
	}
}

?>