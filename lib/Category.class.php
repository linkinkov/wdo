<?php

class Category
{
	public function __construct($id = false)
	{
		global $db;
		if ( intval($id) == 0 )
		{
			return false;
		}
		$sql = sprintf("SELECT `cat_name` FROM `cats` WHERE `id` = '%d'",$id);
		try {
			$info = $db->queryRow($sql);
			$this->id = $id;
			if ( isset($this->cat_name) ) $this->cat_name = ( mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $this->cat_name) );
		}
		catch (Exception $e)
		{
			$this->id = 0;
			return false;
		}
	}

	public static function get_name($cat_id)
	{
		global $db;
		$cat_id = intval($cat_id);
		if ( !$cat_id ) return "";
		$name = $db->getValue("cats","cat_name","cat_name",Array("id"=>$cat_id));
		return $name;
	}

	public static function getList($search = false)
	{
		global $db;
		$where = ( $search ) ? " WHERE `cat_name` LIKE '%".$search."%'" : "";
		$sql = sprintf("SELECT `id`,`cat_name` FROM `cats` $where");
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