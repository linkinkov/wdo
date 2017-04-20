<?php
class City
{
	public function __construct($id = false)
	{
		global $db;
		if ( intval($id) == 0 )
		{
			return false;
		}
		$sql = sprintf("SELECT `city_name` FROM `cities` WHERE `id` = '%d'",$id);
		try {
			$info = $db->queryRow($sql);
			$this->id = $id;
			if ( isset($this->city_name) ) $this->city_name = ( mb_ereg_replace("/[^a-zA-Zа-яА-Я0-9_@\.\-]+/", "", $this->city_name) );
		}
		catch (Exception $e)
		{
			$this->id = 0;
			return false;
		}
	}

	public static function get_name($id = false)
	{
		global $db;
		if ( !$id ) return "";
		try {
			$city_name = $db->getvalue("cities","city_name","city_name",Array("id"=>$id));
			return $city_name;
		}
		catch (Exception $e)
		{
			return "";
		}
	}

	public static function getList($search = false)
	{
		global $db;
		$where = ( $search ) ? " WHERE `city_name` LIKE '%".$search."%'" : "";
		$sql = sprintf("SELECT `id`,`city_name` FROM `cities` %s",$where);
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