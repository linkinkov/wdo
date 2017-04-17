<?php

class Project
{
	public function __construct($id = false)
	{
		global $db;
		global $project_statuses;
		$this->error = true;
		if ( intval($id) == 0 )
		{
			return;
		}
		$sql = sprintf("SELECT `title`,`descr`,`user_id`,`created`,`status_id`,`cost`,`accept_till`,`start_date`,`end_date`,`cat_name`,`subcat_name`,`safe_deal`,`vip`,`views`
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
			$this->status_name = $db->getValue("project_statuses","status_name","status_name",Array("id"=>$this->status_id));
			$this->error = false;
		}
		catch (Exception $e)
		{
			return;
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

	public function update($field,$value)
	{
		global $db;
		global $lang;
		$value = htmlentities(addslashes($value));
		$response = Array(
			"result" => "false",
			"message" => $lang["error_occured"]
		);

		$sql = sprintf("UPDATE `project` SET `%s` = '%s' WHERE `project_id` = '%d'",$field,$value,$this->project_id);

		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = $lang["saved"];
			$this->$field = $value;
		}
		catch (Exception $e)
		{
			$response["result"] = "false";
			$response["message"] = ( $e->getCode() == 1062 ) ? "Такой пользователь уже существует" : $e->getMessage();
		}
		return $response;
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