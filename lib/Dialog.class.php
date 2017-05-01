<?php

class Dialog
{

	public static function get_unreaded_counter()
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 ) return $response;
		try {
			$sql = sprintf("SELECT COUNT(`message_id`) as `total_messages`
				FROM `dialogs`
				LEFT JOIN `messages` ON `messages`.`dialog_id` = `dialogs`.`dialog_id`
				WHERE find_in_set('%d',`dialog_users`) <> 0 AND `readed` = 0 AND `user_id_from` != '%d' HAVING `total_messages` > 0",$current_user->user_id,$current_user->user_id);
			$dialogs = $db->queryRow($sql);
			if ( sizeof($dialogs) )
			{
				$counter = $dialogs->total_messages;
			}
		}
		catch ( Exception $e )
		{

		}
		return $counter;
	}

	public static function get_dialog_id($recipient_id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 || $recipient_id == 0 ) return $response;
		try {
			$sql = sprintf("SELECT `dialog_id` FROM `dialogs` WHERE `dialog_users` = '%d,%d' OR `dialog_users` = '%d,%d'",$current_user->user_id,$recipient_id,$recipient_id,$current_user->user_id);
			$res = $db->queryRow($sql);
			if ( isset($res->dialog_id) && strlen($res->dialog_id) == 32 )
			{
				$response["result"] = "true";
				$response["dialog_id"] = $res->dialog_id;
				unset($response["message"]);
			}
			else
			{
				$users = Array($current_user->user_id,$recipient_id);
				if ( $new_dialog_id = Dialog::create_dialog($users) )
				{
					$response["result"] = "true";
					$response["dialog_id"] = $new_dialog_id;
					unset($response["message"]);
				}
			}
		}
		catch ( Exception $e )
		{

		}
		return $response;
	}

	private static function create_dialog($users)
	{
		global $db;
		if ( !is_array($users) || sizeof($users) < 2 ) return false;
		$dialog_id = md5(json_encode($users));
		$sql = sprintf("INSERT INTO `dialogs` (`dialog_id`,`dialog_users`) VALUES ('%s','%s')",$dialog_id,implode(",",$users));
		try {
			if ( $db->query($sql) && $db->affected_rows == 1 )
			{
				return $dialog_id;
			}
		}
		catch ( Exception $e )
		{
			// return $e->getMessage();
		}
		return false;
	}

	private static function get_dialog_users($dialog_id)
	{
		global $db;
		global $current_user;
		if ( !$dialog_id ) return false;
		$info = $db->getValue("dialogs","dialog_users","dialog_users",Array("dialog_id"=>$dialog_id));
		$users_in_dialog = Array();
		if ( $info != "" )
		{
			$ids = explode(",",$info);
			if ( sizeof($ids) )
			{
				if ( array_search($current_user->user_id,$ids) === false ) // current user not in dialog
				{
					return $users_in_dialog;
				}
				else
				{
					foreach ( $ids as $user_id )
					{
						$users_in_dialog[$user_id] = User::get_real_user_name($user_id);
					}
				}
			}
		}
		return $users_in_dialog;
	}

	public static function get_dialogs()
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 ) return $response;
		$dialogs = Array();
		$sql = sprintf("SELECT `dialogs`.`dialog_id`, COUNT(`message_id`) as `total_messages`
		FROM `dialogs`
		LEFT JOIN `messages` ON `messages`.`dialog_id` = `dialogs`.`dialog_id`
		WHERE find_in_set('%d',`dialog_users`) <> 0 GROUP BY `dialogs`.`dialog_id` HAVING `total_messages` > 0",$current_user->user_id);
		try {
			$rows = $db->queryRows($sql);
			if ( sizeof($rows) )
			{
				foreach ( $rows as $r )
				{
					$users_in_dialog = Dialog::get_dialog_users($r->dialog_id);
					if ( !is_array($users_in_dialog) || sizeof($users_in_dialog) == 0 ) continue;
					if ( sizeof($users_in_dialog) == 2 )
					{
						unset($users_in_dialog[$current_user->user_id]);
						$recipient_id = array_keys($users_in_dialog);
						$last_message = $db->queryRow(sprintf("SELECT `message_text`,`timestamp` FROM `messages` WHERE `dialog_id` = '%s' ORDER BY `timestamp` DESC LIMIT 1",$r->dialog_id));
						$unreaded = $db->queryRow(sprintf("SELECT COUNT(`message_id`) as counter FROM `messages` WHERE `dialog_id` = '%s' AND `user_id_from` != '%d' AND `readed` = 0",$r->dialog_id,$current_user->user_id));
						$dialog = Array(
							"dialog_avatar_path" => HOST.'/user.getAvatar?user_id='.$recipient_id[0],
							"dialog_id"=>$r->dialog_id,
							"real_user_name"=>$users_in_dialog[$recipient_id[0]],
							"last_message_text"=>$last_message->message_text,
							"timestamp"=>$last_message->timestamp,
							"unreaded"=>$unreaded->counter,
							"total_messages"=>$r->total_messages
						);
						$dialogs[] = $dialog;
					}
				}
			}
			$response["result"] = "true";
			unset($response["message"]);
			$response["dialogs"] = $dialogs;
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}
		return $response;
	}


	public static function get_messages($dialog_id = false, $start=50, $limit=50, $timestamp = false, $wait = 0)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 || strlen($dialog_id) != 32 ) return $response;
		if ( $timestamp )
		{
			if ( !is_numeric($timestamp) ) { $response["message"] = "$timestamp is not timestamp"; return $response; }
			$operand = ( intval($wait) > 0 ) ? '>' : '>=';
			$sql = sprintf("SELECT `message_id`,`message_text`,`timestamp`,`user_id_from`,`readed`
				FROM `messages`
				WHERE `dialog_id` = '%s'
					AND `timestamp` %s '%d'
				ORDER BY `timestamp` DESC ",$dialog_id,$operand,$timestamp);
		}
		else
		{
			$sql = sprintf("SELECT `message_id`,`message_text`,`timestamp`,`user_id_from`,`readed`
				FROM `messages`
				WHERE `dialog_id` = '%s'
				ORDER BY `timestamp` DESC 
				LIMIT %d,%d",$dialog_id,$start,$limit);
			$response["wait"] = 5;
		}

		$users = Dialog::get_dialog_users($dialog_id);
		if ( sizeof($users) == 0 ) return $response;
		// echo $sql;
		try {
			$messages = Array();
			$mark_as_readed = Array();
			if ( $wait > 0 )
			{
				$poll_end = false;
				$pass = 0;
				$sleep = (($wait / 5) >= 1) ? ($wait / 5) : 1;
				while ( !$poll_end )
				{
					$rows = $db->queryRows($sql);
					if ( sizeof($rows) || $pass >= $wait )
					{
						$poll_end = true;
					}
					if ( sizeof($rows) == 0 )
					{
						$response["wait"] = $wait;
					}
					else
					{
						$response["wait"] = 5;
					}
					sleep($sleep);
					$pass++;
				}
			}
			else
			{
				$rows = $db->queryRows($sql);
			}
			if ( sizeof($rows) )
			{
				foreach ( $rows as $r )
				{
					if ( $r->readed == 0 ) $mark_as_readed[] = $r->message_id;
					$message = Array(
						"user" => Array(
							"id"=>$r->user_id_from,
							"real_user_name"=>$users[$r->user_id_from],
							"avatar_path"=>HOST.'/user.getAvatar?user_id='.$r->user_id_from
						),
						"message" => Array(
							"text"=>$r->message_text,
							"timestamp"=>$r->timestamp,
							"readed"=>$r->readed
						)
					);
					$messages[] = $message;
				}
				if ( sizeof($mark_as_readed) )
				{
					$sql = sprintf("UPDATE `messages` SET `readed` = 1 
					WHERE `dialog_id` = '%s' 
						AND `user_id_from` != '%d' 
						AND `message_id` IN ('%s')",
					$dialog_id,$current_user->user_id,implode("','",$mark_as_readed)
					);
					$db->query($sql);
				}
			}
			else
			{
				// $response["error"] = "errror";
			}
			$response["result"] = "true";
			$response["messages"] = $messages;
			unset($response["message"]);
		}
		catch ( Exception $e )
		{
			$response["error"] = $e->getMessage();
		}
		return $response;
	}

/*
	public static function get_messages_after_id($dialog_id,$message_id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 || strlen($dialog_id) != 32 || strlen($message_id) != 32 ) return $response;
		$users = Dialog::get_dialog_users($dialog_id);
		if ( sizeof($users) == 0 ) return $response;
	}
*/

	public static function send_message($dialog_id,$message_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 || strlen($dialog_id) != 32 ) return $response;
		if ( trim($message_text) == "" ) {$response["message"] = "Введите текст"; return $response;}
		$users = Dialog::get_dialog_users($dialog_id);
		if ( sizeof($users) == 0 ) return $response;

		$message_text = filter_string($message_text,'in');
		$message_id = md5(time().$message_text.$dialog_id);
		$timestamp = time();
		$sql = sprintf("INSERT INTO `messages` (`message_id`,`message_text`,`dialog_id`,`user_id_from`,`timestamp`) 
		VALUES ('%s','%s','%s','%d','%d')",
		$message_id,
		$message_text,
		$dialog_id,
		$current_user->user_id,
		$timestamp);
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Сообщение отправлено";
			$response["timestamp"] = $timestamp;
		}
		catch ( Exception $e )
		{
			$response["error"] = $e->getMessage();
		}

		return $response;
	}

}