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
				if ( isset($this->$field) ) $this->$field = filter_string($this->$field,'out');
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
	
	public static function publish($data)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Проверьте данные"
		);
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
		$status_id = 1;
		if ( $data["safe_deal"] == "true" )$data["safe_deal"] = 1;
		if ( $data["vip"] == "true" )
		{
			$data["vip"] = 1;
			$status_id = 6;
		}
		$sql = sprintf("INSERT INTO `project` (`title`,`descr`,`cost`,`created`,`status_id`,`user_id`,`accept_till`,`start_date`,`end_date`,`cat_id`,`subcat_id`,`city_id`,`safe_deal`,`vip`,`views`,`for_user_id`,`for_event_id`)
		VALUES ('%s','%s','%d',UNIX_TIMESTAMP(),'%d','%d','%d','%d','%d','%d','%d','%d','%d','%d',0,'%d','%s')",
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
		try {
			$db->autocommit(false);
			if ( $db->query($sql) && $db->insert_id > 0 )
			{
				$project_id = $db->insert_id;
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
		}
		catch ( Exception $e )
		{
			// $response["error"] = $e->getMessage();
		}
		return $response;
	}
}

?>