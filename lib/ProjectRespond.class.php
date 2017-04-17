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
		$sql = sprintf("SELECT `attach_id`,`attach_type` FROM `attaches` WHERE `for_respond_id` = '%d'",$this->respond_id);
		try {
			$list = $db->queryRows($sql);
			return $list;
		}
		catch (Exception $e)
		{
			return Array();
		}
	}

}

?>