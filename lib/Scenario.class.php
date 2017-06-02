<?php

class Scenario
{

	public function __construct($event_id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id <= 0 ) return $response;
		if ( strlen($event_id) != 32 )
		{
			$response["message"] = "Праздник не найден";
			return $response;
		}
		$sql = sprintf("SELECT * FROM `user_scenarios` WHERE `event_id` = '%s' AND `user_id` = '%d'",$event_id,$current_user->user_id);
		try {
			$i = $db->queryRow($sql);
			if ( !isset($i->event_id) )
			{
				throw new Exception("Такой праздник не существует");
			};
			$subcats = explode(",",$i->subcats);
			$this->event_id = $event_id;
			$this->user_id = $i->user_id;
			$this->event = new stdClass();
			$this->progress = new stdClass();
			$this->progress->percent = 0;
			$this->progress->projects_total = sizeof($subcats);
			$this->progress->projects_done = 0;
			$this->event->title = $i->title;
			$this->event->archive = $i->archive;
			$this->event->budget_total = intval($i->budget);
			$this->event->budget_spent = 0;
			$this->event->budget_left = $this->event->budget_total;
			$this->event->timestamp_start = $i->timestamp_start;
			$this->event->timestamp_end = $i->timestamp_end;

			// get created projects for this event_id
			$this->created_projects = Array();
			$projects_done = 0;
			$projects = $db->queryRows(sprintf("SELECT `project_id`,`subcat_id` FROM `project` WHERE `user_id` = '%d' AND `for_event_id` = '%s'",$current_user->user_id,$event_id));
			if ( sizeof($projects) )
			{
				foreach ( $projects as $pid )
				{
					$p = new Project($pid->project_id);
					switch ( $p->status_id )
					{
						case 1:
							$status_class = "text-success";
							break;
						case 2:
							$status_class = "text-info";
							break;
						case 3:
							$status_class = "text-purple";
							break;
						case 4:
							$status_class = "text-warning";
							break;
						case 5:
							$status_class = "text-danger";
							break;
						default:
							$status_class = "text-muted";
							break;
					}
					$p->status_name = sprintf('<text class="%s">%s</text>',$status_class,$p->status_name);
					if ( isset($p->performer->cost) && $p->performer->cost > 0 )
					{
						$p->cost = $p->performer->cost;
					}
					if ( $p->status_id == 3 ) {
						$this->event->budget_spent += $p->cost;
						$this->event->budget_left -= $p->cost;
					}
					$p->cost_formatted = number_format($p->cost,0,","," ");

					$this->created_projects[] = $p;
					if ( $p->status_id == 3 ) $this->progress->projects_done++;
					if ( in_array($pid->subcat_id,$subcats) )
					{
						unset($subcats[array_search($pid->subcat_id,$subcats)]);
					}
				}
			}
			// $this->event->budget_left = 8100;
			$this->progress->percent = intval($this->progress->projects_done / $this->progress->projects_total * 100)+2;
			$this->event->budget_total = Array("value"=>$this->event->budget_total,"format"=>number_format($this->event->budget_total,0,","," "));
			$this->event->budget_spent = Array("value"=>$this->event->budget_spent,"format"=>number_format($this->event->budget_spent,0,","," "));
			$this->event->budget_left = Array("value"=>$this->event->budget_left,"format"=>number_format($this->event->budget_left,0,","," "));
			$this->event->projects_to_create = SubCategory::get_name($subcats);
		}
		catch ( Exception $e )
		{
			return false;
		}
	}

	public static function create_event($title,$budget,$timestamp_start,$timestamp_end,$scenario_id,$subcats)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id <= 0 ) return $response;
		if ( $title == "" || !is_timestamp("$timestamp_start") || !is_timestamp("$timestamp_end") || $scenario_id <= 0 || sizeof($subcats) == 0 )
		{
			$response["message"] = "Некорректные данные";
			return $response;
		}
		$exists = $db->query(sprintf("SELECT `event_id` 
		FROM `user_scenarios` 
		WHERE `title` = '%s' 
			AND `user_id` = '%d' 
			AND `scenario_id` = '%d'
			AND `timestamp_start` = '%d'
			AND `timestamp_end` = '%d'
			AND `subcats` = '%s'",
			$title,$current_user->user_id,$scenario_id,$timestamp_start,$timestamp_end,implode(",",$subcats)));
		try {
			if ( $exists->num_rows > 0 )
			{
				throw new Exception("Такой праздник уже существует");
			}
			$event_id = md5($current_user->user_id.$scenario_id.$title.$budget.$timestamp_start.$timestamp_end);
			$sql = sprintf("INSERT INTO `user_scenarios` (`event_id`,`user_id`,`scenario_id`,`title`,`budget`,`timestamp_start`,`timestamp_end`,`subcats`)
						VALUES ('%s','%d','%d','%s','%d','%d','%d','%s')",
						$event_id,$current_user->user_id,$scenario_id,$title,$budget,$timestamp_start,$timestamp_end,implode(",",$subcats));
			if ( $db->query($sql) && $db->affected_rows > 0 )
			{
				$response["result"] = "true";
				$response["event_id"] = $event_id;
				$response["message"] = "Событие создано";
				$dialog_id = md5($event_id.$current_user->user_id.time());
				$db->query(sprintf("INSERT INTO `dialogs` (`dialog_id`,`dialog_users`,`for_event_id`) VALUES ('%s','%s','%s')",$dialog_id,$current_user->user_id,$event_id));
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

	public function add_to_event_dialog($performer_id = false)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа 1"
		);
		if ( $current_user->user_id <= 0 || $this->user_id != $current_user->user_id ) return $response;
		// check that invited user belong to event project
		$sql = sprintf("SELECT `respond_id` FROM `project_responds` WHERE `user_id` = '%d' AND `for_project_id` IN (SELECT `project_id` FROM `project` WHERE `for_event_id` = '%s' AND `user_id` = '%d')",$performer_id,$this->event_id,$current_user->user_id);
		$respond = $db->query($sql);
		if ( $respond->num_rows > 0 )
		{
			$dialog_id = $db->getValue("dialogs","dialog_id","dialog_id",Array("for_event_id"=>$this->event_id));
			// echo "add_to_event_dialog: $this->event_id, $dialog_id, $performer_id\n";
			// $dialog_users = Dialog::get_dialog_users($dialog_id);
			$response = Dialog::invite_user($dialog_id,$performer_id,$this->event_id);
		}
		return $response;
	}

	public function archive_event()
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id <= 0 || $this->user_id != $current_user->user_id ) return $response;
		$sql = sprintf("UPDATE `user_scenarios` SET `archive` = 1 WHERE `event_id` = '%s' AND `user_id` = '%d'",$this->event_id,$current_user->user_id);
		try {
			// echo "try: ".$sql;
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Сохранено";
			}
		}
		catch ( Exception $e )
		{

		}
		return $response;
	}

	public static function get_templates()
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

	public static function get_list($archive = 0)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id <= 0 ) return $response;
		$list = $db->queryRows(sprintf("SELECT * FROM `user_scenarios` WHERE `archive` = '%d' AND `user_id` = '%d' ORDER BY `timestamp_start` ASC",$archive,$current_user->user_id));
		return $list;
	}
}