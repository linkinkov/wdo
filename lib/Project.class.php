<?php

class Project
{
	public function __construct($id = false)
	{
		global $db;
		$this->error = true;
		if ( intval($id) == 0 )
		{
			return;
		}
		$sql = sprintf("SELECT `title`, `descr`, `user_id`, `created`, `status_id`,`cost`,`start_date`,`end_date`,`cat_name`,`subcat_name`,`safe_deal`,`vip`
		FROM `project`
		LEFT JOIN `cats` ON `cats`.`id` = `project`.`cat_id`
		LEFT JOIN `subcats` ON `subcats`.`id` = `project`.`subcat_id`
		WHERE `project_id` = '%d'",$id);
		try {
			$prj = $db->queryRow($sql);
			if ( sizeof($prj) )
			{
				foreach ( $prj as $p => $v ) $this->$p = htmlentities($v);
			}
			else
			{
				return;
			}
			$this->project_id = $id;
			$filter = Array("title","descr","cost");
			foreach ( $filter as $field )
			{
				if ( isset($this->$field) ) $this->$field = ( mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $this->$field) );
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
	
}

?>