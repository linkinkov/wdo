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
			if ( isset($info->cat_name) )
			{
				$this->id = $id;
				$this->cat_name = $info->cat_name;
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

	public static function add($cat_name)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Доступ запрещён"
		);
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 ) return $response;
		if ( trim($cat_name) == "" )
		{
			$response["message"] = "Введите имя";
			return $response;
		}
		$exists = $db->getValue("cats","id","id",Array("disabled"=>0,"cat_name"=>trim($cat_name)));
		if ( $exists && intval($exists) > 0 )
		{
			$response["message"] = "Такая категория уже существует";
			return $response;
		}
		$cat_name_translated = strtolower(r2t($cat_name));
		$sql = sprintf("INSERT INTO `cats` (`cat_name`,`translated`) VALUES ('%s','%s')",$cat_name,$cat_name_translated);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Категория добавлена";
				$response["cat_id"] = $db->insert_id;
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
		$sql = sprintf("UPDATE `cats` SET `disabled` = '1' WHERE `id` = '%d'",$id);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Категория отключена";
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
		$sql = sprintf("UPDATE `cats` SET `disabled` = '0' WHERE `id` = '%d'",$id);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Категория включена";
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
			(SELECT COUNT(`project_id`) FROM `project` WHERE `cat_id` = '$id') as `projects_counter`,
			(SELECT COUNT(`portfolio_id`) FROM `portfolio` WHERE `cat_id` = '$id') as `portfolio_counter`
		";
		if ( $res = $db->queryRow($sql) )
		{
			if ( $res->projects_counter > 0 )
			{
				$response["message"] = "В данной категории есть проекты";
				return $response;
			}
			if ( $res->portfolio_counter > 0 )
			{
				$response["message"] = "В данной категории есть портфолио";
				return $response;
			}
		}
		else
		{
			$response["message"] = "Ошибка определения счётчиков вхождения в данную категорию";
			return $response;
		}
		$sql = sprintf("DELETE FROM `cats` WHERE `id` = '%d'",$id);
		$db->autocommit(false);
		try {
			if ( $db->query($sql) )
			{
				$sql = sprintf("DELETE FROM `subcats` WHERE `parent_cat_id` = '%d'",$id);
				if ( $db->query($sql) )
				{
					$db->commit();
					$response["result"] = "true";
					$response["message"] = "Категория и подкатегории удалены";
				}
				else
				{
					$response["message"] = "Не удалось удалить подкатегории";
				}
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

	public static function get_name($cat_id)
	{
		global $db;
		$cat_id = intval($cat_id);
		if ( !$cat_id ) return "";
		$name = $db->getValue("cats","cat_name","cat_name",Array("id"=>$cat_id));
		return $name;
	}

	public static function get_list($search = false, $order = false, $show_disabled = false)
	{
		global $db;
		$where = ( $show_disabled == true ) ? 'WHERE 1' : 'WHERE `disabled` = "0"';
		// $where = sprintf(" WHERE `disabled` LIKE '%%%s'",$show_disabled);
		$where .= ( $search ) ? " AND `cat_name` LIKE '%".$search."%'" : "";
		$order = ( $order ) ? sprintf("ORDER BY %s %s",$order["col"],$order["dir"]) : "";
		$sql = sprintf("SELECT `id`,`cat_name` FROM `cats` $where $order");
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
		$cat_name_translated = "";
		if ( $name == "cat_name" )
		{
			$exists = $db->getValue("cats","id","id",Array("disabled"=>0,"cat_name"=>trim($value)));
			if ( $exists && intval($exists) > 0 )
			{
				$response["message"] = "Такая категория уже существует";
				return $response;
			}
			$cat_name_translated = sprintf(", `translated` = '%s'",addslashes(strtolower(r2t($value))));
		}
		$sql = sprintf("UPDATE `cats` SET `%s` = '%s' %s WHERE `id` = '%d'",$name,$value,$cat_name_translated,$this->id);
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