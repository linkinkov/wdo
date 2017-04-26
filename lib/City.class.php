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
			if ( isset($info->city_name) )
			{
				$this->id = $id;
				$this->city_name = $info->city_name;
			}
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

	public static function get_list($search = false,$limit = 30)
	{
		global $db;
		$where = ( $search ) ? " WHERE `city_name` LIKE '%".$search."%'" : "";
		$sql = sprintf("SELECT `id`,`city_name` FROM `cities` %s LIMIT %d",$where,$limit);
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