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
			if ( isset($info->subcat_name) )
			{
				$this->id = $id;
				$this->subcat_name = filter_string($info->subcat_name,'out');
			}
			else
			{
				$this->id = 0;
				return false;
			}
		}
		catch (Exception $e)
		{
			$this->id = 0;
			return false;
		}
	}

	public static function get_name($subcat_id)
	{
		global $db;
		$subcat_id = intval($subcat_id);
		if ( !$subcat_id ) return "";
		$name = $db->getValue("subcats","subcat_name","subcat_name",Array("id"=>$subcat_id));
		return $name;
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