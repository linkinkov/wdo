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

	public static function add($parent_cat_id,$subcat_name)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Доступ запрещён"
		);
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 ) return $response;
		if ( trim($subcat_name) == "" )
		{
			$response["message"] = "Введите имя";
			return $response;
		}
		if ( intval($parent_cat_id) <= 0 )
		{
			$response["message"] = "Выберите категорию";
			return $response;
		}
		$exists = $db->getValue("subcats","id","id",Array("disabled"=>0,"parent_cat_id"=>intval($parent_cat_id),"subcat_name"=>trim($subcat_name)));
		if ( $exists && intval($exists) > 0 )
		{
			$response["message"] = "Такая категория уже существует";
			return $response;
		}
		$subcat_name_translated = strtolower(r2t($subcat_name));
		$sql = sprintf("INSERT INTO `subcats` (`parent_cat_id`,`subcat_name`,`translated`) VALUES ('%d','%s','%s')",intval($parent_cat_id),$subcat_name,$subcat_name_translated);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Подкатегория добавлена";
				$response["subcat_id"] = $db->insert_id;
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

	public function disable($id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Доступ запрещён"
		);
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 ) return $response;
		if ( !$id || intval($id) <= 0 ) return;
		$sql = sprintf("UPDATE `subcats` SET `disabled` = '1' WHERE `id` = '%d'",$id);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Подкатегория отключена";
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

	public function enable($id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Доступ запрещён"
		);
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 ) return $response;
		if ( !$id || intval($id) <= 0 ) return;
		$sql = sprintf("UPDATE `subcats` SET `disabled` = '0' WHERE `id` = '%d'",$id);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Подкатегория включена";
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

	public function delete($id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Доступ запрещён"
		);
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 ) return $response;
		if ( !$id || intval($id) <= 0 ) return;

		// check projects,subcats,portfolio counters
		$sql = "SELECT
			(SELECT COUNT(`project_id`) FROM `project` WHERE `subcat_id` = '$id') as `projects_counter`,
			(SELECT COUNT(`portfolio_id`) FROM `portfolio` WHERE `subcat_id` = '$id') as `portfolio_counter`
		";
		if ( $res = $db->queryRow($sql) )
		{
			if ( $res->projects_counter > 0 )
			{
				$response["message"] = "В данной подкатегории есть проекты";
				return $response;
			}
			if ( $res->portfolio_counter > 0 )
			{
				$response["message"] = "В данной подкатегории есть портфолио";
				return $response;
			}
		}
		else
		{
			$response["message"] = "Ошибка определения счётчиков вхождения в данную подкатегорию";
			return $response;
		}
		$sql = sprintf("DELETE FROM `subcats` WHERE `id` = '%d'",$id);
		$db->autocommit(false);
		try {
			if ( $db->query($sql) )
			{
				$db->commit();
				$response["result"] = "true";
				$response["message"] = "Подкатегория удалена";
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

	public static function get_name($subcat_id)
	{
		global $db;
		$subcat_id = (is_array($subcat_id)) ? $subcat_id : intval($subcat_id);
		if ( is_array($subcat_id) )
		{
			if ( sizeof($subcat_id) == 0 ) return Array();
			$res = $db->queryRows(sprintf("SELECT `id` as `subcat_id`,`subcat_name` FROM `subcats` WHERE `id` IN (%s)",implode(",",$subcat_id)));
			return $res;
		}
		else
		{
			if ( !$subcat_id ) return "";
			$name = $db->getValue("subcats","subcat_name","subcat_name",Array("id"=>$subcat_id));
			return $name;
		}
	}

	public static function get_list($parent_id = false, $search=false, $order = false, $show_disabled = false )
	{
		global $db;
		if ( intval($parent_id) == 0 )
		{
			return false;
		}
		// $show_disabled = ( $show_disabled == true ) ? 1 : 0;
		$where = sprintf(" WHERE `parent_cat_id` = '%d'",$parent_id);
		$where .= ( $show_disabled == true ) ? '' : ' AND `disabled` = "0"';
		$where .= ( $search ) ? " AND `subcat_name` LIKE '%".$search."%'" : "";
		$order = ( $order ) ? sprintf("ORDER BY %s %s",$order["col"],$order["dir"]) : "";
		$sql = sprintf("SELECT `id`, `parent_cat_id`, `subcat_name` FROM `subcats` $where $order");
		try {
			$list = $db->queryRows($sql);
			return $list;
		}
		catch (Exception $e)
		{
			return Array();
		}
	}

	public function update($name,$value)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Доступ запрещён"
		);
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 ) return $response;
		$sql = sprintf("UPDATE `subcats` SET `%s` = '%s' WHERE `id` = '%d'",$name,$value,$this->id);
		try {
			if ( $db->query($sql) )
			{
				return true;
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

}