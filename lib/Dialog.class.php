<?php

class Dialog
{

	public static function get_dialog_id($recipient_id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 || $recipient_id == 0 ) return $response;
		$sql = sprintf("SELECT `dialog_id` FROM `dialogs` WHERE `dialog_users` ")
	}
	
	private static function get_dialog_users($dialog_id)
	{
		global $db;
		if ( !$dialog_id ) return false;
		$info = $db->getValue("dialogs","dialog_users","dialog_users",Array("dialog_id"=>$dialog_id));
		$users_in_dialog = Array();
		if ( $info != "" )
		{
			$ids = explode(",",$info);
			if ( sizeof($ids) )
			{
				foreach ( $ids as $user_id )
				{
					$users_in_dialog[$user_id] = User::get_real_user_name($user_id);
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
		// $sql = sprintf("SELECT DISTINCT `user_id_from` as conv_user_id FROM `messages` WHERE `user_id_to` = '%d' UNION SELECT DISTINCT `user_id_to` FROM `messages` WHERE `user_id_from` = '%d'",$current_user->user_id,$current_user->user_id);
		// echo $sql;
		$sql = sprintf("SELECT `dialog_id` FROM `dialogs` WHERE find_in_set('%d',`dialog_users`) <> 0",$current_user->user_id);
		// echo $sql;
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
						// print_r($users_in_dialog);
						// $users_in_dialog = array_values($users_in_dialog);

						$recipient_id = array_keys($users_in_dialog);
						$last_message = $db->queryRow(sprintf("SELECT `message_text`,`timestamp` FROM `messages` WHERE `dialog_id` = '%s' ORDER BY `timestamp` LIMIT 1",$r->dialog_id));
						$unreaded = $db->queryRow(sprintf("SELECT COUNT(`message_id`) as counter FROM `messages` WHERE `dialog_id` = '%s' AND `user_id_to` = '%d' AND `readed` = 0",$r->dialog_id,$current_user->user_id));
						// $total = $db->queryRow(sprintf("SELECT COUNT(`message_id`) as counter FROM `messages` WHERE `dialog_id` = '%s'",$r->dialog_id));
						$dialog = Array(
							// "user_id"=>$recipient_id,
							"dialog_avatar_path" => HOST.'/user.getAvatar?user_id='.$recipient_id[0],
							"dialog_id"=>$r->dialog_id,
							"real_user_name"=>User::get_real_user_name($recipient_id[0]),
							"last_message_text"=>$last_message->message_text,
							"timestamp"=>$last_message->timestamp,
							"unreaded"=>$unreaded->counter,
							// "total_messages"=>$total->counter
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

		}
		return $response;
	}


	public static function get_dialog_messages($dialog_id = false, $start=50, $limit=50)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 || strlen($dialog_id) != 32 ) return $response;

		$users = Dialog::get_dialog_users($dialog_id);
		if ( sizeof($users) == 0 ) return $response;
		$sql = sprintf("SELECT `message_id`,`message_text`,`timestamp`,`user_id_from`,`user_id_to`,`readed`
			FROM `messages`
			WHERE `dialog_id` = '%s'
			ORDER BY `timestamp` DESC 
			LIMIT $start,$limit",$dialog_id);
		try {
			$messages = Array();
			$mark_as_readed = Array();
			$rows = $db->queryRows($sql);
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
				// $response["messages_hash"] = md5(json_encode($messages));
				$response["result"] = "true";
				if ( sizeof($mark_as_readed) )
				{
					$sql = sprintf("UPDATE `messages` SET `readed` = 1 
					WHERE `dialog_id` = '%s' 
						AND `user_id_to` = '%d' 
						AND `message_id` IN (%s)",
					$dialog_id,$current_user->user_id,implode(",",$mark_as_readed)
					);
				}
			}
			else
			{

			}
			$response["messages"] = $messages;
			unset($response["message"]);
		}
		catch ( Exception $e )
		{

		}
		return $response;
	}

	public static function send_message($dialog_id,$message_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
/*
		if ( trim($message_text) == "" ) {$response["message"] = "Введите текст"; return $response;}
		if ( $current_user->user_id == 0 ) return $response;
		$message_text = filter_string($message_text,'in');
		$uniq_id = md5(time().$message_text.$user_id);
		$sql = sprintf("INSERT INTO `messages` (`message_id`,`message_text`,`user_id_from`,`user_id_to`,`timestamp`) 
		VALUES ('%s','%s','%d','%d',UNIX_TIMESTAMP())",
		$uniq_id,
		$message_text,
		$current_user->user_id,
		$user_id);
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Сообщение отправлено";
		}
		catch ( Exception $e )
		{
		}
*/
		return $response;
	}

}