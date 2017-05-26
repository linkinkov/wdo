<?php

class Scenario
{

	public static function create_event($title,$budget,$timestamp_start,$timestamp_end,$scenario_id,$subcats)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id <= 0 ) return $response;
		if ( $title == "" || $budge <= 0 || !is_timestamp($timestamp_start) || !is_timestamp($timestamp_end) || $scenario_id <= 0 || sizeof($subcats) == 0 )
		{
			$response["message"] = "Некорректные данные";
			return $response;
		}
		try {
			$event_id = md5($current_user->user_id.$scenario_id.$title.$budget.$timestamp_start.$timestamp_end);
			$sql = sprintf("INSERT INTO `user_scenarios` (`event_id`,`user_id`,`scenario_id`,`title`,`budget`,`timestamp_start`,`timestamp_end`,`subcats`)
						VALUES ('%s','%d','%d','%s','%d','%d','%d','%s')",
						$event_id,$current_user->user_id,$scenario_id,$title,$budget,$timestamp_start,$timestamp_end,implode(",",$subcats));
			if ( $db->query($sql) && $db->affected_rows > 0 )
			{
				$response["result"] = "true";
				$response["event_id"] = $event_id;
				$response["message"] = "Событие создано";
			}
			else
			{
				$response["message"] = "Произошла ошибка создания";
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

	public static function get_list()
	{
		global $db;
		$list = Array();
		$sql = sprintf("SELECT `scenario_id`,`scenario_name`,`scenario_subcats`
		FROM `scenario_templates`");
		try {
			$list = $db->queryRows($sql);
			if ( sizeof($list) )
			{
				foreach ( $list as $row )
				{
					$subcat_ids = explode(",",$row->scenario_subcats);
					$row->scenario_subcats = SubCategory::get_name($subcat_ids);
				}
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}

		return $list;
	}
}