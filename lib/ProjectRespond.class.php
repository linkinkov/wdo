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
			$filter = Array("descr","cost");
			foreach ( $filter as $field )
			{
				if ( isset($this->$field) ) $this->$field = filter_string($this->$field,'out');
			}
			$this->attaches = $this->get_attach_list();
			$project_author_id = $db->getValue("project","user_id","user_id",Array("project_id"=>$this->for_project_id));
			if ( $current_user->user_id != $this->user_id && $current_user->user_id != $project_author_id )
			{
				unset($this->cost);
				unset($this->status_id);
				unset($this->modify_timestamp);
			}
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
		if ( $field == "status_id" )
		{
			$sql = sprintf("UPDATE `project_responds` SET `%s` = '%s', `modify_timestamp` = UNIX_TIMESTAMP() WHERE `respond_id` = '%d'",$field,$value,$this->respond_id);
		}
		else
		{
			$sql = sprintf("UPDATE `project_responds` SET `%s` = '%s' WHERE `respond_id` = '%d'",$field,$value,$this->respond_id);
		}
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

	public static function publish($data)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( $current_user->user_id == 0 ) return $response;
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
		$data["descr"] = filter_string($data["descr"]);
		$sql = sprintf("INSERT INTO `project_responds` (`for_project_id`,`user_id`,`created`,`descr`,`cost`,`status_id`)
		VALUES ('%d','%d',UNIX_TIMESTAMP(),'%s','%d',1)",
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
			// $response["error"] = $e->getMessage();
		}
		return $response;
	}
}

?>