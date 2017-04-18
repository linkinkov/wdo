<?php

class ProjectRespond
{
	public function __construct($id = false)
	{
		global $db;
		$this->error = true;
		if ( intval($id) == 0 )
		{
			return;
		}
		$sql = sprintf("SELECT `respond_id`, `for_project_id`, `user_id`, `created`, `descr`, `cost`, `status_id`
		FROM `project_responds`
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
				if ( isset($this->$field) ) $this->$field = ( mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $this->$field) );
			}
			$this->attaches = $this->get_attach_list();
			$this->error = false;
		}
		catch (Exception $e)
		{
			return;
		}
	}

	public function get_attach_list()
	{
		global $db;
		$sql = sprintf("SELECT `attach_id`,`attach_type`,`url` FROM `attaches` WHERE `for_respond_id` = '%d' ORDER BY `attach_type`, `attach_id` ASC",$this->respond_id);
		try {
			$list = $db->queryRows($sql);
			$idx = 0;
			foreach ( $list as $row )
			{
				if ( $row->attach_type == 'video' )
				{
					if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $row->url, $match)) {
						$row->youtube_id = $match[1];
					}
					else
					{
						unset($list[$idx]);
					}
				}
				else
				{
					unset($row->url);
				}
				$idx++;
			}
			return $list;
		}
		catch (Exception $e)
		{
			return Array();
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
		if ( $project_author_id != $current_user->user_id || $project_status_id != 1 )
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
		$sql = sprintf("UPDATE `project_responds` SET `%s` = '%s' WHERE `respond_id` = '%d'",$field,$value,$this->respond_id);
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Обновлено";
		}
		catch (Exception $e)
		{
			$response["error"] = $e->getMessage();
		}
		return $response;
	}
}

?>