<?php

class User
{
	public function __construct($id = false, $username = false, $login = false)
	{
		global $db;
		global $current_user;
		if ( !isset($_SESSION["viewed_projects"]) )
		{
			$_SESSION["viewed_projects"] = Array();
		}
		if ( !isset($_COOKIE["viewed_project_respond"]) )
		{
			setcookie("viewed_project_respond", json_encode(Array()),0,"/");
		}
		if ( !isset($_SESSION["viewed_portfolio"]) )
		{
			$_SESSION["viewed_portfolio"] = Array();
		}
		if ( intval($id) == 0 && $username == false )
		{
			$this->user_id = 0;
			// $_SESSION["user_id"] = 0;
			return;
		}
		$where = (intval($id) > 0) ? sprintf("`user_id` = '%d'",$id) : sprintf("`username` = '%s'",$username);
		$public_fields = Array("user_id","username","real_user_name","type_id","city_id","registered","last_login","as_performer","status_id","rating","rezume","phone","telegram","site","gps","signature","template_id");
		array_walk($public_fields,'sqlize_array');
		$sql = sprintf("SELECT %s FROM `users` LEFT JOIN `cities` ON `cities`.`id` = `users`.`city_id` WHERE %s",implode(",",$public_fields),$where);
		// echo $sql;
		try {
			$info = $db->queryRow($sql);
			if ( sizeof($info) ) foreach ( $info as $p => $v ) $this->$p = htmlentities($v); else $this->error = true;
			$filter = Array("username","phone","telegram","signature","rezume");
			foreach ( $filter as $field )
			{
				if ( isset($this->$field) ) $this->$field = filter_string($this->$field,'out');
			}
			$this->city_name = City::get_name($this->city_id);
			$this->avatar_path = HOST.'/user.getAvatar?user_id='.$this->user_id;
			if ( $this->user_id != $_SESSION["user_id"] && $login == false ) unset($this->username);
			// if ( $login == false && (!isset($current_user) || $current_user->user_id == 0) )
			if ( $login == false && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == 0) )
			{
				$this->phone = "Скрыт";
				$this->telegram = "Скрыт";
			}
			if ( $login == true )
			{
				setcookie("city_id",$this->city_id,0,"/");
				setcookie("city_name",$this->city_name,0,"/");
				$_COOKIE["city_id"] = $this->city_id;
				$_COOKIE["city_name"] = $this->city_name;
			}
		}
		catch (Exception $e)
		{
			$this->user_id = 0;
			// $_SESSION["user_id"] = 0;
			// echo $e->getMessage();
			return false;
		}
	}

	public static function register($username,$real_user_name,$password)
	{
		global $db;
		$response = Array(
			"result" => "false",
			"message" => "Проверьте данные"
		);
		if ( !isValidEmail($username) || strlen($password) < 128 || trim($real_user_name) == "" ) return $response;
		$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
		$password_hashed = hash('sha512', $password . $random_salt);
		$city_id = (isset($_COOKIE["city_id"]) && intval($_COOKIE["city_id"]) > 0) ? intval($_COOKIE["city_id"]) : 1;

		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			$user_ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$user_ip = $_SERVER['REMOTE_ADDR'];
		}
		$_SESSION["user_ip"] = $user_ip;
		$key = md5($username.$password_hashed.$random_salt);
		$sql = sprintf("INSERT INTO `users` (`username`,`real_user_name`,`password`,`salt`,`city_id`,`last_ip`,`country_id`,`registered`,`type_id`,`status_id`,`template_id`)
			VALUES ('%s','%s','%s','%s','%d','%s','1',UNIX_TIMESTAMP(),'2','2','1')",
			$username,$real_user_name,$password_hashed,$random_salt,$city_id,$_SESSION["user_ip"]);
		$db->autocommit(false);
		try {
			if ( $db->query($sql) )
			{
				if ( send_activation_key($username,$key) === true )
				{
					$response["result"] = "true";
					$response["message"] = "Регистрация прошла успешно! Для активации аккаунта следуйте указаниям в письме.";
					$db->commit();
				}
				else
				{
					$response["message"] = "Не удалось отправить письмо. Попробуйте позже.";
				}
			}
			else
			{
				$response["message"] = "Не удалось пройти регистрацию. Попробуйте позже.";
			}
		}
		catch ( Exception $e )
		{
			// $response["error"] = $e->getMessage();
			$response["message"] = ( $e->getCode() == 1062 ) ? "Такой пользователь уже существует" : "Произошла ошибка";
		}
		return $response;
	}

	public static function activate($key)
	{
		global $db;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( strlen($key) != 32 )
		{
			return $response;
		}
		$sql = sprintf("SELECT `username` FROM `users` WHERE MD5(CONCAT(`username`,`password`,`salt`)) = '%s'",$key);
		try {
			$info = $db->queryRow($sql);
			if ( sizeof($info) > 0 && isset($info->username) )
			{
				$sql = sprintf("UPDATE `users` SET `status_id` = '1' WHERE `username` = '%s' AND `status_id` = '2'",$info->username);
				if ( $db->query($sql) && $db->affected_rows > 0 )
				{
					$response["result"] = "true";
					$response["message"] = 'Активация прошла успешно! <br /><br /><a href="#" class="wdo-link underline" data-toggle="modal" data-target="#login-modal">Авторизуйтесь</a> используя свои данные';
				}
				else
				{
					$response["message"] = "Учетная запись уже активирована";
				}
			}
			else
			{
				$response["message"] = "Пользователь не найден";
			}
		}
		catch ( Exception $e )
		{

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
		$sql = sprintf("UPDATE `users` SET `status_id` = '3' WHERE `user_id` = '%d'",$id);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Пользователь заблокирован";
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
		$sql = sprintf("UPDATE `users` SET `status_id` = '1' WHERE `user_id` = '%d'",$id);
		try {
			if ( $db->query($sql) )
			{
				$response["result"] = "true";
				$response["message"] = "Пользователь разблокирован";
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}


	public function update_profile_info($data)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка"
		);
		if ( $this->user_id == 0 ) return $response;
		$public_fields = Array("password","real_user_name","type_id","country_id","city_id","as_performer","phone","telegram","site","gps","signature","rezume","birthday","rek_last_name","rek_first_name","rek_second_name","rek_inn","rek_ogrnip","rek_ras_schet","rek_kor_schet","rek_bik","ts_project_responds");
		$set = Array();
		foreach ( $data as $key=>$value )
		{
			if ( in_array($key,$public_fields) )
			{
				$value = filter_string($value,'in');
				if ( $key == "gps" )
				{
					$set[] = sprintf('`%s` = "%s"',$key,$value);
					$set[] = sprintf("`gps_point` = GeomFromText('POINT(%s)',0)",str_replace(","," ",$value));
				}
				if ( $key == "password" )
				{
					$salt = $db->getValue("users","salt","salt",Array("user_id"=>$this->user_id));
					$hashed = hash('sha512',$value.$salt);
					$set[] = sprintf('`%s` = "%s"',$key,$hashed);
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					$_SESSION['login_string'] = hash('sha512',$hashed . $user_browser);
				}
				else
				{
					$set[] = sprintf('`%s` = "%s"',$key,$value);
				}
			}
			else
			{
				if ( $key == "template_id" && $current_user->template_id == 2 )
				{
					$set[] = sprintf('`%s` = "%s"',$key,$value);
				}
			}
		}
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
		$public_fields = Array("user_id","real_user_name","type_id","country_id","city_id","as_performer","phone","telegram","site","gps","signature","rezume","birthday");
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
			setcookie("city_id",$this->city_id,0,"/");
			setcookie("city_name",$this->city_name,0,"/");
			// $_COOKIE["city_id"] = $this->city_id;
			// $_COOKIE["city_name"] = $this->city_name;
		}
	}

	public function get_top_categories()
	{
		global $db;
		$cats = Array();
		try {
			$sql = sprintf("SELECT `cat_id` FROM `project`
			WHERE `project_id` IN(SELECT `for_project_id` FROM `project_responds` WHERE `user_id` = '%d' GROUP BY `for_project_id` ORDER BY COUNT(`for_project_id`) DESC)
			GROUP BY `cat_id`
			ORDER BY COUNT(`cat_id`) DESC
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
				$this->counters->messages = Dialog::get_unreaded_counter();
				// get new project responds and modified responds for performer
				$sql = sprintf("SELECT COUNT(`respond_id`) as counter 
				FROM `project_responds` 
				WHERE 1
					AND `respond_id` NOT IN (
						SELECT `id` FROM `user_readed_log` WHERE `type` = 'project_respond' AND `user_id` = '%d'
					)
					AND (
						`for_project_id` IN (
							SELECT `project_id` FROM `project` WHERE `user_id` = '%d' AND status_id NOT IN(4,5,6)
						)
						OR
						`user_id` = '%d'
					)
					",$this->user_id,$this->user_id,$this->user_id);
				$tmp = $db->queryRow($sql);
				$this->counters->project_responds->unreaded = $tmp->counter;
				$this->counters->project_responds->won = intval($db->getValue("project_responds","COUNT(`respond_id`)","counter",Array("user_id"=>$this->user_id,"status_id"=>3)));
				$this->counters->project_responds->won_sum = intval($db->getValue("project_responds","SUM(`cost`)","counter",Array("user_id"=>$this->user_id,"status_id"=>3),"AND","user_id"));
				// get new user responds
				$sql = sprintf("SELECT COUNT(`id`) as counter 
				FROM `user_responds` 
				WHERE 1
					AND `user_id` = '%d' 
					AND `id` NOT IN (
						SELECT `id` FROM `user_readed_log` WHERE `type` = 'user_respond' AND `user_id` = '%d'
					)",$this->user_id,$this->user_id);
				$tmp = $db->queryRow($sql);
				$this->counters->responds->unreaded = $tmp->counter;
			}
			$this->counters->responds->good = intval($db->getValue("user_responds","COUNT(`id`)","counter",Array("user_id"=>$this->user_id,"grade"=>">=5")));
			$this->counters->responds->bad = intval($db->getValue("user_responds","COUNT(`id`)","counter",Array("user_id"=>$this->user_id,"grade"=>"<5")));
			$sql = sprintf("SELECT COUNT(`warning_id`) as counter 
			FROM `warnings` 
			WHERE `for_user_id` = '%d'
				AND `warning_id` NOT IN (
					SELECT `id` FROM `user_readed_log` WHERE `type` = 'warning' AND `user_id` = '%d'
				)
				",$this->user_id,$this->user_id);
			$tmp = $db->queryRow($sql);
			// $this->counters->warnings = intval($db->getValue("warnings","COUNT(`warning_id`)","counter",Array("for_user_id"=>$this->user_id)));
			$this->counters->warnings = new stdClass();
			$this->counters->warnings->unreaded = $tmp->counter;
			$this->counters->warnings->total = intval($db->getValue("warnings","COUNT(`warning_id`)","counter",Array("for_user_id"=>$this->user_id)));
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

	public static function save_note($user_id,$note_text)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 ) return $response;
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
		$this->balance = $db->getValue("project_responds","SUM(`COST`)","total",Array("user_id"=>$current_user->user_id,"status_id"=>5));
		
		return $this->balance;
	}

	public static function get_list($search="",$city_id=false,$limit = 5, $as_performer = "%", $hide_self = true)
	{
		global $db;
		global $current_user;
		$search = filter_string($search,'in');
		$list = Array();
		if ( !$city_id ) $city_id = intval($_COOKIE["city_id"]);
		$where_city_id = ( $city_id != "%" ) ? sprintf("`city_id` = '%d' AND",$city_id) : "";
		if ( $hide_self == true )
		{
			$sql = sprintf("SELECT `user_id`,`real_user_name`,`rating` 
			FROM `users` 
			WHERE %s `user_id` > 0
				AND `user_id` != '%d'
				AND `real_user_name` LIKE '%%%s%%'
				AND `as_performer` LIKE '%s'
			LIMIT %d",$where_city_id,$current_user->user_id,$search,$as_performer,$limit);
		}
		else
		{
			$sql = sprintf("SELECT `user_id`,`real_user_name`,`rating` 
			FROM `users` 
			WHERE %s `user_id` > 0
				AND `real_user_name` LIKE '%%%s%%'
				AND `as_performer` LIKE '%s'
			LIMIT %d",$where_city_id,$search,$as_performer,$limit);
		}
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
			'correct_image_extensions' => true,
		);
		$response = Array("result"=>"false");
		$upload_handler = new UploadHandler($opts);
		if ( is_array($upload_handler->response) && sizeof($upload_handler->response["avatar"]) && !isset($upload_handler->response["avatar"][0]->error) )
		{
			$session = session_id();
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

	public function get_portfolio_list()
	{
		global $db;
		$list = Array();
		if ( $this->user_id == 0 ) return Array();
		$sql = sprintf("SELECT * FROM `portfolio` WHERE `user_id` = '%d'",$this->user_id);
		try {
			$list = $db->queryRows($sql);
		}
		catch ( Exception $e )
		{
			// echo $e->getMesage();
		}
		return $list;
	}

	public function add_readed($type="project_respond",$id = "")
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id == 0 || $id == "" ) return true;
		$counter = $db->getValue("user_readed_log","COUNT(`id`)","counter",Array("user_id"=>$current_user->user_id,"type"=>$type,"id"=>$id));
		if ( isset($counter->counter) && $counter->counter > 0 )
		{

		}
		else
		{
			try {
				$sql = sprintf("INSERT INTO `user_readed_log` (`user_id`,`type`,`id`) VALUES ('%d','%s','%s')",$current_user->user_id,$type,$id);
				if ( $db->query($sql) )
				{
					$_SESSION["viewed_".$type][] = $id;
					setcookie("viewed_".$type,json_encode($_SESSION["viewed_".$type]),0,"/");
				}
			}
			catch (Exception $e)
			{
				//return $e->getMessage();
			}
		}
	}

	public function is_readed($type="project_respond",$id = "")
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id == 0 || $id == "" ) return true;
		$sql = sprintf("SELECT COUNT(`id`) FROM `user_readed_log` WHERE `user_id` = '%d' AND `type` = '%s' AND `id` = '%s'",$current_user->user_id,$type,$id);
		$readed = $db->getValue("user_readed_log","COUNT(`id`)","counter",Array("user_id"=>$current_user->user_id,"type"=>$type,"id"=>$id));
		return ( isset($readed) && intval($readed) > 0 ) ? true : false;
	}

	public function init_wallet()
	{
		if ( $this->user_id > 0 || !isset($this->wallet) || !isset($this->wallet->user_id) )
		{
			$this->wallet = new Wallet($this->user_id);
		}
	}

	public static function block($project_id,$recipient_id,$message)
	{
		global $db;
		global $current_user;
		$response = Array(
			"result" => "false",
			"message" => "Проверьте данные"
		);
		if ( $current_user->user_id <= 0 )
		{
			$response["message"] = "Доступ запрещен";
			return $response;
		}
		$user_status = $db->getValue("users","status_id","status_id",Array("user_id"=>$recipient_id));
		switch ( $user_status )
		{
			case "2":
				$response["message"] = "Пользователь ещё не активирован";
				return $response;
			case "3":
				$response["message"] = "Пользователь уже заблокирован";
				return $response;
			case "4":
				$response["message"] = "Пользователь уже удалён";
				return $response;
		}
		$db->autocommit(false);
		try {
			// update user's status
			$sql = sprintf("UPDATE `users` SET `status_id` = '3' WHERE `user_id` = '%d' AND `status_id` = '1' AND `user_id` != ''",$recipient_id,$current_user->user_id);
			if ( $db->query($sql) && $db->affected_rows > 0 )
			{
				// insert warning for user
				$sql = sprintf("INSERT INTO `warnings` (`for_project_id`,`for_respond_id`,`for_user_id`,`message`,`user_id`,`timestamp`)
				VALUES ('%d',0,'%d','%s','%d',UNIX_TIMESTAMP())",$project_id,$recipient_id,$message,$current_user->user_id);
				if ( $db->query($sql) && $db->affected_rows > 0 )
				{
					$db->commit();
					$response["message"] = "Пользователь заблокирован";
					$response["result"] = "true";
				}
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

	public function update_adv_logo($adv_id = "")
	{
		global $current_user;
		require_once(PD.'/upload/UploadHandler.php');
		$response = Array(
			"result" => "false",
			"message" => "Ошибка доступа"
		);
		if ( $current_user->user_id == 0 ) return $response;
		$session = session_id();
		$upload_dir = sprintf(PD.'/upload/files/%s/',$session);
		delTree($upload_dir);
		$opts = array(
			'user_dirs' => true,
			'param_name' => 'adv_logo',
			'access_control_allow_credentials' => true,
			'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
			'max_file_size' => 6000000,
			'print_response' => false,
			'min_width' => 150,
			'min_height' => 150,
			'max_width' => 1700,
			'max_height' => 1700,
			'correct_image_extensions' => true,
			'image_versions' => Array(
				'thumbnail' => Array(
					'crop' => true
				)
			)
		);
		$response = Array("result"=>"false");
		$upload_handler = new UploadHandler($opts);
		if ( is_array($upload_handler->response) && sizeof($upload_handler->response["adv_logo"]) && !isset($upload_handler->response["adv_logo"][0]->error) )
		{
			$user_id = $current_user->user_id;
			$filename = $upload_handler->response["adv_logo"][0]->name;
			$file_path = sprintf(PD.'/upload/files/%s/%s',$session,$filename);
			$exten = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
			$new_adv = false;
			if ( $adv_id == "" )
			{
				$new_adv = true;
				$adv_id = md5($filename.$user_id.time());
			}
			$target_path = sprintf(PD.'/attaches/%d/current_adv/%s',$user_id,$adv_id.".".$exten);
			
			if ( @rename($file_path,$target_path) )
			{
				// array_map('unlink', array_values( preg_grep( '/^((?!'.$exten.').)*$/', glob(sprintf(PD.'/attaches/%d/current_adv/%s',$user_id,'*'),GLOB_BRACE) ) ));
				// array_map('unlink', glob(PD."/attaches/$user_id/cache/$user_id-*.{jpg,jpeg,png,gif}",GLOB_BRACE));
				// array_map('unlink', glob(sprintf(PD.'/attaches/%d/current_adv/%s')))
				if ( $new_adv )
				{
					$response = Array("result" => "true","logo_path"=>HOST.sprintf('/attaches/%d/current_adv/%s&%d',$user_id,$adv_id.".".$exten,time()));
				}
				else
				{
					$response = Array("result" => "true","logo_path"=>HOST.'/get.advLogo?adv_id='.$adv_id.'&w=80&h=80&'.time());
				}
			}
			else
			{
				$response["message"] = "Невозможно записать файл";
			}
			delTree(PD."/upload/files/$session");
		}
		else
		{
			if ( isset($upload_handler->response["adv_logo"][0]->error) )
				$response["message"] = $upload_handler->response["adv_logo"][0]->error;
			else
				$response["message"] = "Непредвиденная ошибка";
		}
		return $response;
	}

}

?>