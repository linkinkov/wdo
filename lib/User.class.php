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
		$public_fields = Array("user_id","username","last_name","first_name","company_name","type_id","registered","last_login","as_performer","state_id","rating","phone","skype");
		array_walk($public_fields,'sqlize_array');
		$sql = sprintf("SELECT %s FROM `users` WHERE %s",implode(",",$public_fields),$where);
		// $sql = "SELECT `user_id`,`username`, `last_name`, `first_name`, `company_name`, `type_id`, `registered`, `last_login`, `as_performer`, `state_id`, `rating` FROM `users` WHERE $where";
		try {
			$info = $db->queryRow($sql);
			if ( sizeof($info) ) foreach ( $info as $p => $v ) $this->$p = htmlentities($v); else $this->error = true;
			$filter = Array("username","last_name","first_name","company_name","phone","skype","birthday","skype");
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
	public function get_top_categories()
	{
		global $db;
		$cats = Array();
		try {
			$sql = sprintf("SELECT
					`cat_id`
			FROM
					`project`
			WHERE
					`project_id` IN(
					SELECT
							`for_project_id`
					FROM
							`project_responds`
					WHERE
							`user_id` = '%d'
					GROUP BY
							`for_project_id`
					ORDER BY
							COUNT(`for_project_id`)
					DESC
			)
			GROUP BY
					`cat_id`
			ORDER BY
					COUNT(`cat_id`)
			DESC
			",$this->user_id);
			$ids = $db->queryRows($sql);
			$cats = Array();
			// print_r($ids);
			if ( sizeof($ids) )
			{
				foreach ( $ids as $cat )
				{
					$cats[] = Category::get_name($cat->cat_id);
				}
			}
		}
		catch ( Exception $e )
		{
			$cats = Array();
		}
		return $cats;
	}

	public function get_counters()
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
		);
		if ( $this->user_id <= 0 ) return $response;
		$this->counters = new stdClass();
		$this->counters->projects = new stdClass();
		$this->counters->project_responds = new stdClass();
		$this->counters->responds = new stdClass();
		$this->counters->portfolio = new stdClass();
		try {
			$this->counters->projects->created = intval($db->getValue("project","COUNT(`project_id`)","counter",Array("user_id"=>$this->user_id)));
			$this->counters->project_responds->created = intval($db->getValue("project_responds","COUNT(`respond_id`)","counter",Array("user_id"=>$this->user_id)));
			if ( $current_user->user_id == $this->user_id )
			{
				$this->counters->messages = intval($db->getValue("messages","COUNT(`message_id`)","counter",Array("user_id_to"=>$this->user_id,"readed"=>0)));
				$this->counters->project_responds->won = intval($db->getValue("project_responds","COUNT(`respond_id`)","counter",Array("user_id"=>$this->user_id,"status_id"=>3)));
				$this->counters->project_responds->won_sum = intval($db->getValue("project_responds","SUM(`cost`)","counter",Array("user_id"=>$this->user_id,"status_id"=>3),"AND","user_id"));
			}
			$this->counters->responds->good = intval($db->getValue("user_responds","COUNT(`id`)","counter",Array("user_id"=>$this->user_id,"grade"=>">=5")));
			$this->counters->responds->bad = intval($db->getValue("user_responds","COUNT(`id`)","counter",Array("user_id"=>$this->user_id,"grade"=>"<5")));
			$this->counters->warnings = intval($db->getValue("user_warnings","COUNT(`warning_id`)","counter",Array("for_user_id"=>$this->user_id)));
			$this->counters->portfolio->created = intval($db->getValue("portfolio","COUNT(`portfolio_id`)","counter",Array("user_id"=>$this->user_id)));
			$response["result"] = "true";
			$response["counters"] = $this->counters;
		}
		catch ( Exception $e )
		{
			// return $e->getMessage();
		}
		return $response;
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

	public static function send_message($user_id,$message_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( trim($message_text) == "" ) {$response["message"] = "Введите текст"; return $response;}
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

	public static function save_note($user_id,$note_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 ) return $response;
		// if ( trim($note_text) == "" ) {$response["message"] = "Введите текст"; return $response;}
		$sql = sprintf("REPLACE INTO `user_notes` (`note_text`,`user_id`,`for_user_id`,`timestamp`) 
		VALUES ('%s','%d','%d',UNIX_TIMESTAMP())",
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
			$response["error"] = $e->getMessage();
		}
		return $response;
	}

	public function get_balance()
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $this->user_id != $current_user->user_id ) return $response;
		$this->balance = 100500;
		return $this->balance;
	}
}

?>