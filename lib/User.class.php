<?php

class User
{
	public function __construct($user_id = false, $username = false, $login = false)
	{
		global $db;
		if ( $login == true )
		{
			if ( !isset($_SESSION["viewed_projects"]) )
			{
				$_SESSION["viewed_projects"] = Array();
			}
		}
		if ( isset($_COOKIE["city_id"]) && isset($_COOKIE["city_name"]) )
		{
			$this->city_id = intval($_COOKIE["city_id"]);
			$this->city_name = trim($_COOKIE["city_name"]);
		}
		else
		{
			$this->city_id = 1;
			$this->city_name = "Москва";
		}
		if ( intval($user_id) == 0 && $username == false )
		{
			$this->user_id = 0;
			return;
		}
		$where = (intval($user_id) > 0) ? sprintf("`user_id` = '%d'",$user_id) : sprintf("`username` = '%s'",$username);
		$public_fields = Array("user_id","username","real_user_name","last_name","first_name","company_name","type_id","city_id","registered","last_login","as_performer","state_id","rating","phone","skype","site","gps","signature");
		array_walk($public_fields,'sqlize_array');
		$sql = sprintf("SELECT %s FROM `users` WHERE %s",implode(",",$public_fields),$where);
		try {
			$info = $db->queryRow($sql);
			if ( sizeof($info) ) foreach ( $info as $p => $v ) $this->$p = htmlentities($v); else $this->error = true;
			$filter = Array("username","last_name","first_name","company_name","phone","skype","signature","rezume");
			foreach ( $filter as $field )
			{
				if ( isset($this->$field) ) $this->$field = filter_string($this->$field,'out');
			}
			$this->city_name = City::get_name($this->city_id);
			// $this->realUserName = ( $info->type_id == 2 ) ? trim(implode(" ",Array($info->last_name,$info->first_name))) : $info->company_name;
			$this->avatar_path = HOST.'/user.getAvatar?user_id='.$this->user_id;
			if ( $this->user_id != $_SESSION["user_id"] && $login == false ) unset($this->username);
			if ( $this->user_id == $_SESSION["user_id"] )
			{
				$this->ts_project_responds = $db->getValue("users","ts_project_responds","last_visit",Array("user_id"=>$this->user_id));
			}
		}
		catch (Exception $e)
		{
			$this->user_id = 0;
			return false;
		}
	}

	public function update_profile_info($data)
	{
		global $db;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( $this->user_id == 0 ) return $response;
		$public_fields = Array("last_name","first_name","company_name","type_id","country_id","city_id","as_performer","phone","skype","site","gps","signature","rezume","birthday","rek_last_name","rek_first_name","rek_second_name","rek_inn","rek_ogrnip","rek_ras_schet","rek_kor_schet","rek_bik","ts_project_responds");
		$set = Array();
		foreach ( $data as $key=>$value )
		{
			if ( in_array($key,$public_fields) )
			{
				$value = filter_string($value,'in');
				$set[] = sprintf('`%s` = "%s"',$key,$value);
			}
		}
		// array_walk($public_fields,'sqlize_array');
		$sql = sprintf("UPDATE `users` SET %s WHERE `user_id` = '%d'",implode(",",$set),$this->user_id);
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Сохранено";
		}
		catch ( Exception $e )
		{
			// $response["error"] = $e->getMessage();
		}
		return $response;
	}

	public static function get_profile_info($user_id = false)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( !$user_id ) return $response;
		if ( $current_user->user_id != $user_id ) return $response;
		$public_fields = Array("user_id","last_name","first_name","company_name","type_id","country_id","city_id","as_performer","phone","skype","site","gps","signature","rezume","birthday");
		array_walk($public_fields,'sqlize_array');
		$sql = sprintf("SELECT %s FROM `users` WHERE `user_id` = '%d'",implode(",",$public_fields),$user_id);
		try {
			$info = $db->queryRow($sql);
			$info->avatar_path = HOST.'/user.getAvatar?user_id='.$user_id;
			$info->city_name = City::get_name($info->city_id);
			if ( sizeof($info) )
			{
				if ( $info->type_id == 1 )
				{
					$rek_fields = Array("rek_last_name","rek_first_name","rek_second_name","rek_inn","rek_ogrnip","rek_ras_schet","rek_kor_schet","rek_bik");
					array_walk($rek_fields,'sqlize_array');
					$sql = sprintf("SELECT %s FROM `users` WHERE `user_id` = '%d'",implode(",",$rek_fields),$user_id);
					$rek = $db->queryRow($sql);
					$info->rekvizity = $rek;
				}
				$response["user"] = $info;
				$response["result"] = "true";
				unset($response["message"]);
			}
		}
		catch (Exception $e)
		{
			// $response["error"] = $e->getMessage();
		}
		return $response;

	}

	public function set_city_auto()
	{
		if ( $this->user_id == 0 && (!isset($_COOKIE["city_id"]) || !isset($_COOKIE["city_name"]) || intval($_COOKIE["city_id"]) <= 0) )
		{
			determine_user_city();
		}
		else if ( isset($_COOKIE["city_id"]) && isset($_COOKIE["city_name"]) && intval($_COOKIE["city_id"]) > 0 )
		{

		}
		else
		{
			setcookie("city_id",$this->city_id);
			setcookie("city_name",$this->city_name);
			$_COOKIE["city_id"] = $this->city_id;
			$_COOKIE["city_name"] = $this->city_name;
		}
	}

	public function get_top_categories()
	{
		global $db;
		$cats = Array();
		try {
			$sql = sprintf("SELECT
					`cat_id`
			FROM
					`project`
			WHERE
					`project_id` IN(
					SELECT
							`for_project_id`
					FROM
							`project_responds`
					WHERE
							`user_id` = '%d'
					GROUP BY
							`for_project_id`
					ORDER BY
							COUNT(`for_project_id`)
					DESC
			)
			GROUP BY
					`cat_id`
			ORDER BY
					COUNT(`cat_id`)
			DESC
			",$this->user_id);
			$ids = $db->queryRows($sql);
			$cats = Array();
			if ( sizeof($ids) )
			{
				foreach ( $ids as $cat )
				{
					$cats[] = Category::get_name($cat->cat_id);
				}
			}
		}
		catch ( Exception $e )
		{
			$cats = Array();
		}
		return $cats;
	}

	public function get_counters()
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
		);
		if ( $this->user_id <= 0 ) return $response;
		$this->counters = new stdClass();
		$this->counters->projects = new stdClass();
		$this->counters->project_responds = new stdClass();
		$this->counters->responds = new stdClass();
		$this->counters->portfolio = new stdClass();
		try {
			$this->counters->projects->created = intval($db->getValue("project","COUNT(`project_id`)","counter",Array("user_id"=>$this->user_id)));
			$this->counters->project_responds->created = intval($db->getValue("project_responds","COUNT(`respond_id`)","counter",Array("user_id"=>$this->user_id)));
			if ( $current_user->user_id == $this->user_id )
			{
				$this->counters->messages = intval($db->getValue("messages","COUNT(`message_id`)","counter",Array("user_id_to"=>$this->user_id,"readed"=>0)));
				$this->counters->project_responds->unreaded = intval($db->getValue("project_responds","COUNT(`respond_id`)","counter",Array("user_id"=>$this->user_id,"modify_timestamp"=>">".$this->ts_project_responds)));
				$this->counters->project_responds->won = intval($db->getValue("project_responds","COUNT(`respond_id`)","counter",Array("user_id"=>$this->user_id,"status_id"=>3)));
				$this->counters->project_responds->won_sum = intval($db->getValue("project_responds","SUM(`cost`)","counter",Array("user_id"=>$this->user_id,"status_id"=>3),"AND","user_id"));
			}
			$this->counters->responds->good = intval($db->getValue("user_responds","COUNT(`id`)","counter",Array("user_id"=>$this->user_id,"grade"=>">=5")));
			$this->counters->responds->bad = intval($db->getValue("user_responds","COUNT(`id`)","counter",Array("user_id"=>$this->user_id,"grade"=>"<5")));
			$this->counters->warnings = intval($db->getValue("user_warnings","COUNT(`warning_id`)","counter",Array("for_user_id"=>$this->user_id)));
			$this->counters->portfolio->created = intval($db->getValue("portfolio","COUNT(`portfolio_id`)","counter",Array("user_id"=>$this->user_id)));
			$response["result"] = "true";
			$response["counters"] = $this->counters;
		}
		catch ( Exception $e )
		{
			// return $e->getMessage();
		}
		return $response;
	}
	public static function get_real_user_name($user_id)
	{
		global $db;
		global $lang;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		$real_user_name = "";
		if ( intval($user_id) <= 0 ) return $response;
		try {
			$real_user_name = $db->getValue("users","real_user_name","real_user_name",Array("user_id"=>$user_id));
		}
		catch (Exception $e)
		{
			// $response["error"] = $e->getMessage();
		}
		return (string)$real_user_name;
	}

	public static function get_user_note($user_id)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( intval($user_id) <= 0 || $current_user->user_id == 0 ) return $response;
		try {
			$response["result"] = "true";
			unset($response["message"]);
			$response["userNote"] = $db->getValue("user_notes","note_text","note_text",Array("user_id"=>$current_user->user_id,"for_user_id"=>$user_id));
			if ( $response["userNote"] == false ) $response["userNote"] = "";
		}
		catch (Exception $e)
		{
			// $response["error"] = $e->getMessage();
		}
		return $response;
	}

	public static function send_message($user_id,$message_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
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
		return $response;
	}

	public static function save_note($user_id,$note_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 ) return $response;
		// if ( trim($note_text) == "" ) {$response["message"] = "Введите текст"; return $response;}
		$note_text = filter_string($note_text,'in');
		$sql = sprintf("REPLACE INTO `user_notes` (`note_text`,`user_id`,`for_user_id`,`timestamp`) 
		VALUES ('%s','%d','%d',UNIX_TIMESTAMP())",
		$note_text,
		$current_user->user_id,
		$user_id);
		try {
			$db->query($sql);
			$response["result"] = "true";
			$response["message"] = "Заметка сохранена";
		}
		catch ( Exception $e )
		{
			$response["error"] = $e->getMessage();
		}
		return $response;
	}

	public function get_balance()
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $this->user_id != $current_user->user_id ) return $response;
		$this->balance = 100500;
		return $this->balance;
	}

	public static function get_list($search="",$city_id=false,$limit = 5)
	{
		global $db;
		global $current_user;
		$search = filter_string($search,'in');
		$list = Array();
		if ( !$city_id ) $city_id = $_COOKIE["city_id"];
		$sql = sprintf("SELECT `user_id`,`real_user_name`,`rating` FROM `users` WHERE `city_id` = '%d' AND `user_id` > 0 AND `user_id` != '%d' AND `real_user_name` LIKE '%%%s%%' LIMIT %d",$city_id,$current_user->user_id,$search,$limit);
		try {
			$rows = $db->queryRows($sql);
			if ( $rows )
				foreach ( $rows as $row )
				{
					$list[] = Array(
						"user_id"=>$row->user_id,
						"user_link"=>HOST.'/profile/id'.$row->user_id,
						"real_user_name"=>$row->real_user_name,
						"rating"=>$row->rating,
						"avatar_path"=>HOST.'/user.getAvatar?user_id='.$row->user_id
					);
				}
		}
		catch ( Exception $e )
		{
			// $list = $e->getMessage();
		}
		return $list;
	}

	public static function calendar($user_id,$action,$dates,$editable=1)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $user_id == 0 )
		{
			$response["error"] = "true";
			return $response;
		}
		try {
			if ( $action == "get" )
			{
				$dates = $db->queryRows(sprintf("SELECT `timestamp`,`editable` FROM `user_calendar` WHERE `user_id` = '%d'",$user_id));
				$response["dates"] = $dates;
				unset($response["message"]);
			}
			else if ( $action == "set" )
			{
				if ( is_array($dates) )
				{
					$db->autocommit(false);
					$reset = sprintf("DELETE FROM `user_calendar` WHERE `user_id` = '%d' AND `editable` = '%d'",$user_id,$editable);
					$db->query($reset);
					foreach ( $dates as $timestamp )
					{
						$insert = sprintf("INSERT INTO `user_calendar` (`user_id`,`timestamp`,`editable`) VALUES ('%d','%d','%d')",$user_id,$timestamp,$editable);
						$db->query($insert);
					}
					$db->commit();
					$db->autocommit(true);
				}
				$response["message"] = "Сохранено";
			}
			$response["result"] = "true";
		}
		catch ( Exception $e )
		{

			$response["error"] = $e->getMessage();
		}
		return $response;
	}

	public function avatar_update()
	{
		global $current_user;
		require_once(PD.'/upload/UploadHandler.php');
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 ) return $response;
		$opts = array(
			'user_dirs' => true,
			'param_name' => 'avatar',
			'access_control_allow_credentials' => true,
			'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
			'max_file_size' => 6000000,
			'print_response' => false,
			'min_width' => 150,
			'min_height' => 150,
			'max_width' => 1500,
			'max_height' => 1500,
			'correct_image_extensions' => true
		);
		$response = Array("result"=>"false");
		$upload_handler = new UploadHandler($opts);
		if ( is_array($upload_handler->response) && sizeof($upload_handler->response["avatar"]) && !isset($upload_handler->response["avatar"][0]->error) )
		{
			$session = session_id();
			// $user_id = $_SESSION["user_id"];
			$user_id = $current_user->user_id;
			$filename = $upload_handler->response["avatar"][0]->name;
			$file_path = PD.'/upload/files/'.$session.'/'.$filename;
			$exten = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
			$target_path = PD.'/users/avatars/'.$user_id.'.'.$exten;
			if ( @rename($file_path,$target_path) )
			{
				array_map('unlink', array_values( preg_grep( '/^((?!'.$exten.').)*$/', glob(PD."/users/avatars/$user_id.*",GLOB_BRACE) ) ));
				array_map('unlink', glob(PD."/users/avatars/cache/$user_id-*.{jpg,jpeg,png,gif}",GLOB_BRACE));
				$response = Array("result" => "true","avatar_path"=>HOST.'/user.getAvatar?user_id='.$user_id.'&w=150&h=150&'.time());
			}
			else
			{
				$response["message"] = "Невозможно записать файл";
			}
			delTree(PD."/upload/files/$session");
		}
		else
		{
			if ( isset($upload_handler->response["avatar"][0]->error) )
				$response["message"] = $upload_handler->response["avatar"][0]->error;
			else
				$response["message"] = "Непредвиденная ошибка";
		}
		return $response;
	}

	public function delete_avatar()
	{
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 ) return $response;
	}

	public function get_dialogs()
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
		$sql = sprintf("SELECT `dialog_id`,`dialog_users` FROM `dialogs` WHERE find_in_set('%d',`dialog_users`) <> 0",$current_user->user_id);
		// echo $sql;
		try {
			$rows = $db->queryRows($sql);
			if ( sizeof($rows) )
			{
				foreach ( $rows as $r )
				{

					// $user_id = $r->conv_user_id;
					// $last_message = $db->queryRow(sprintf("SELECT `message_text`,`timestamp` FROM `messages` WHERE (`user_id_from` = '%d' AND `user_id_to` = '%d') OR (`user_id_from` = '%d' AND `user_id_to` = '%d') ORDER BY `timestamp` DESC LIMIT 1",$user_id,$current_user->user_id,$current_user->user_id,$user_id));
					// $unreaded = $db->queryRow(sprintf("SELECT COUNT(`message_id`) as counter FROM `messages` WHERE (`user_id_from` = '%d' AND `user_id_to` = '%d') OR (`user_id_from` = '%d' AND `user_id_to` = '%d') AND `readed` = 0",$user_id,$current_user->user_id,$current_user->user_id,$user_id));
					// $total = $db->queryRow(sprintf("SELECT COUNT(`message_id`) as counter FROM `messages` WHERE (`user_id_from` = '%d' AND `user_id_to` = '%d') OR (`user_id_from` = '%d' AND `user_id_to` = '%d')",$user_id,$current_user->user_id,$current_user->user_id,$user_id));

					$users_in_dialog = explode(",",$r->dialog_users);
					unset($users_in_dialog[array_search($current_user->user_id,$users_in_dialog)]);
					$users_in_dialog = array_values($users_in_dialog);
					if ( sizeof($users_in_dialog) == 1 )
					{
						$recipient_id = $users_in_dialog[0];
						$last_message = $db->queryRow(sprintf("SELECT `message_text`,`timestamp` FROM `messages` WHERE `dialog_id` = '%s' ORDER BY `timestamp` LIMIT 1",$r->dialog_id));
						$unreaded = $db->queryRow(sprintf("SELECT COUNT(`message_id`) as counter FROM `messages` WHERE `dialog_id` = '%s' AND `user_id_to` = '%d'",$r->dialog_id,$current_user->user_id));
						$total = $db->queryRow(sprintf("SELECT COUNT(`message_id`) as counter FROM `messages` WHERE `dialog_id` = '%s'",$r->dialog_id));
						$dialog = Array(
							"user_id"=>$recipient_id,
							"real_user_name"=>User::get_real_user_name($recipient_id),
							"last_message_text"=>$last_message->message_text,
							"timestamp"=>$last_message->timestamp,
							"unreaded"=>$unreaded->counter,
							"total_messages"=>$total->counter
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

	public function get_conversation($user_id,$start=50,$limit=50)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 || $user_id == 0 ) return $response;
		$users = Array(
			$current_user->user_id => $current_user->real_user_name,
			$user_id => User::get_real_user_name($user_id)
		);
		$sql = sprintf("SELECT `message_text`,`timestamp`,`user_id_from`,`user_id_to`,`readed`
			FROM `messages`
			WHERE (`user_id_from` = '%d' AND `user_id_to` = '%d') OR (`user_id_from` = '%d' AND `user_id_to` = '%d')
			ORDER BY `timestamp` DESC 
			LIMIT $start,$limit",
		$current_user->user_id,$user_id,$user_id,$current_user->user_id);
		try {
			$rows = $db->queryRows($sql);
			if ( sizeof($rows) )
			{
				foreach ( $rows as $r )
				{
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
			}
			$response["result"] = "true";
			unset($response["message"]);
			$response["messages"] = $messages;
		}
		catch ( Exception $e )
		{

		}
		return $response;
	}
}

?>