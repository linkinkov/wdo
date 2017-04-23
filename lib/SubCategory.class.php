<?php

class SubCategory
{
	public function __construct($id = false)
	{
		global $db;
		if ( intval($id) == 0 )
		{
			return false;
		}
		$sql = sprintf("SELECT `subcat_name` FROM `subcats` WHERE `id` = '%d'",$id);
		try {
			$info = $db->queryRow($sql);
			$this->id = $id;
			if ( isset($this->subcat_name) ) $this->subcat_name = ( mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $this->subcat_name) );
		}
		catch (Exception $e)
		{
			$this->id = 0;
			return false;
		}
	}

	public static function get_list($parent_id = false)
	{
		global $db;
		if ( intval($parent_id) == 0 )
		{
			return false;
		}
		$sql = sprintf("SELECT `id`, `parent_cat_id`, `subcat_name` FROM `subcats` WHERE `parent_cat_id` = '%d'",$parent_id);
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