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
		global $current_user;
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
			$portfolio->is_owner = ( isset($current_user->user_id) && $current_user->user_id > 0 && $current_user->user_id == $portfolio->user_id ) ? true : false;
			$response["portfolio"] = $portfolio;
			if ( !in_array($portfolio->portfolio_id,$_SESSION["viewed_portfolio"]) )
			{
				$_SESSION["viewed_portfolio"][] = $portfolio->portfolio_id;
				Portfolio::incr_views($portfolio->portfolio_id,$portfolio->views+1);
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}

		return $response;
	}

	private static function incr_views($portfolio_id)
	{
		global $db;
		$sql = sprintf("UPDATE `portfolio` SET `views` = `views` + 1 WHERE `portfolio_id` = '%d'",$portfolio_id);
		try {
			$db->query($sql);
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}
	}

	public static function update_cover($portfolio_id,$action,$attach_id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( $current_user->user_id == 0 ) {$response["message"] = "Ошибка доступа"; return $response;};
		if ( !isset($portfolio_id) || intval($portfolio_id) <= 0 ) return $response;
		$portfolio_user_id = $db->getValue("portfolio","user_id","user_id",Array("portfolio_id" => $portfolio_id));
		if ( $portfolio_user_id != $current_user->user_id ) {$response["message"] = "Ошибка доступа"; return $response;};
		if ( $action == "delete-cover" ) $attach_id = '';
		$sql = sprintf("UPDATE `portfolio` SET `cover_id` = '%s' WHERE `portfolio_id` = '%s' AND `user_id` = '%d'",$attach_id,$portfolio_id,$current_user->user_id);
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

	public static function update($data = false)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( $current_user->user_id == 0 ) {$response["message"] = "Ошибка доступа"; return $response;};
		if ( !isset($data["portfolio_id"]) || intval($data["portfolio_id"]) <= 0 ) return $response;

		$portfolio_user_id = $db->getValue("portfolio","user_id","user_id",Array("portfolio_id" => $data["portfolio_id"]));
		if ( $portfolio_user_id != $current_user->user_id ) {$response["message"] = "Ошибка доступа"; return $response;};
		if ( !isset($data["youtube_links"]) || !is_array($data["youtube_links"]) ) $data["youtube_links"] = Array();
		$sql = sprintf("UPDATE `portfolio` 
		SET `cat_id` = '%d',
		`subcat_id` = '%d',
		`title` = '%s',
		`descr` = '%s'
		WHERE `portfolio_id` = '%d' AND `user_id` = '%d'",$data["cat_id"],$data["subcat_id"],$data["title"],$data["descr"],$data["portfolio_id"],$current_user->user_id);
		$db->autocommit(false);
		try {
			if ( Attach::save_from_user_upload_dir('for_portfolio_id',$data["portfolio_id"],$data["youtube_links"]) )
			{
				$db->query($sql);
				$response["result"] = "true";
				$response["message"] = "Обновлено";
				$db->commit();
			}
			else
			{
				$response["error"] = "Не удалось прикрепить файлы к портфолио";
			}
		}
		catch ( Exception $e )
		{
			// $response["error"] = $e->getMessage();
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

	public static function delete($portfolio_id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( $current_user->user_id == 0 ) {$response["message"] = "Ошибка доступа"; return $response;};
		if ( !isset($portfolio_id) || intval($portfolio_id) <= 0 ) return $response;
		$sql = sprintf("DELETE FROM `portfolio` WHERE `portfolio_id` = '%d' AND `user_id` = '%d'",$portfolio_id,$current_user->user_id);
		$attaches = $db->queryRows(sprintf("SELECT `attach_id`,`attach_type` FROM `attaches` WHERE `for_portfolio_id` = '%d' AND `user_id` = '%d'",$portfolio_id,$current_user->user_id));
		try {
			$files = Array();
			foreach ( $attaches as $f )
			{
				Attach::delete($f->attach_id,$f->attach_type);
			}
			$db->query($sql);
			$db->commit();
			$response["result"] = "true";
			$response["message"] = "Удалено";
		}
		catch ( Exception $e )
		{
			// $response["message"] = $e->getMessage();
		}
		return $response;
	}

}