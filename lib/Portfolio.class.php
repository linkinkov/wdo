<?php

class Portfolio
{

	public static function get_list($user_id)
	{
		global $db;
		$list = Array();
		if ( $user_id == 0 ) return $list;

		$sql = sprintf("SELECT `portfolio_id`,`title`,`user_id`,`cover_id`,`views`,
		`cats`.`cat_name`,
		`cats`.`translated` as `cat_name_translated`,
		`subcats`.`subcat_name`,
		`subcats`.`translated` as `subcat_name_translated`
		FROM `portfolio` 
		LEFT JOIN `cats` ON `cats`.`id` = `portfolio`.`cat_id`
		LEFT JOIN `subcats` ON `subcats`.`id` = `portfolio`.`subcat_id`
		WHERE `user_id` = '%d'
		ORDER BY `created` DESC
		",$user_id);
		try {
			$list = $db->queryRows($sql);
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}

		return $list;
	}

	public static function get_portfolio($portfolio_id = 0)
	{
		global $db;
		if ( $portfolio_id == 0 ) return;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		$sql = sprintf("SELECT `portfolio_id`,`title`,`user_id`,`cover_id`,`views`,`descr`,`portfolio`.`cat_id`,`portfolio`.`subcat_id`,
		`cats`.`cat_name`,
		`cats`.`translated` as `cat_name_translated`,
		`subcats`.`subcat_name`,
		`subcats`.`translated` as `subcat_name_translated`
		FROM `portfolio` 
		LEFT JOIN `cats` ON `cats`.`id` = `portfolio`.`cat_id`
		LEFT JOIN `subcats` ON `subcats`.`id` = `portfolio`.`subcat_id`
		WHERE `portfolio_id` = '%d'
		ORDER BY `created` DESC
		",$portfolio_id);
		try {

			$portfolio = $db->queryRow($sql);
			if ( isset($portfolio->portfolio_id) && $portfolio->portfolio_id > 0 )
			{
				$portfolio->attaches = Attach::get_by_for_type("for_portfolio_id",$portfolio->portfolio_id);
			}
			$response["result"] = "true";
			unset($response["message"]);
			$response["portfolio"] = $portfolio;
			if ( !in_array($portfolio->portfolio_id,$_SESSION["viewed_portfolio"]) )
			{
				$_SESSION["viewed_portfolio"][] = $portfolio->portfolio_id;
				Portfolio::update($portfolio->portfolio_id,"views",$portfolio->views+1);
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}

		return $response;
	}

	public static function update($portfolio_id = 0, $field = false, $value = false)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( $current_user->user_id == 0 ) {$response["message"] = "Ошибка доступа"; return $response;};
		if ( $portfolio_id == 0 ) return $response;
		if ( !in_array($field,Array("title","descr","views","cover_id")) ) return $response;
		$value = filter_string($value,"in");
		if ( $field == "views" )
		{
			if ( intval($value) == 0 ) return $response;
			$sql = sprintf("UPDATE `portfolio` SET `%s` = '%d' WHERE `portfolio_id` = '%d'",$field,$value,$portfolio_id);
		}
		else
		{
			if ( $current_user->user_id == 0 ) return $response;
			$sql = sprintf("UPDATE `portfolio` SET `%s` = '%s' WHERE `portfolio_id` = '%d' AND `user_id` = '%d'",$field,$value,$portfolio_id,$current_user->user_id);
		}
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Обновлено";
		}
		catch ( Exception $e )
		{
			$response["error"] = $e->getMessage();
		}
		return $response;
	}
	

	public static function publish($data)
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id == 0 ) {$response["message"] = "Ошибка доступа"; return $response;};
		$response = Array(
			"result" => "false",
			"message" => "Проверьте данные"
		);
		$all_fields = Array("title","descr","cat_id","subcat_id","youtube_links");
		$req_fields = Array("title","cat_id","subcat_id");
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
		$sql = sprintf("INSERT INTO `portfolio` (`cat_id`,`subcat_id`,`title`,`descr`,`created`,`user_id`)
		VALUES ('%d','%d','%s','%s',UNIX_TIMESTAMP(),'%d')",
			intval($data["cat_id"]),
			intval($data["subcat_id"]),
			filter_string($data["title"],'in'),
			filter_string($data["descr"],'in'),
			intval($current_user->user_id)
		);
		try {
			$db->autocommit(false);
			if ( $db->query($sql) && $db->insert_id > 0 )
			{
				$portfolio_id = $db->insert_id;
				if ( Attach::save_from_user_upload_dir('for_portfolio_id',$portfolio_id,$data["youtube_links"]) )
				{
					$db->commit();
					$response["result"] = "true";
					$response["message"] = "Портфолио опубликовано";
					$db->autocommit(true);
				}
				else
				{
					$response["error"] = "Не удалось прикрепить файлы к портфолио";
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