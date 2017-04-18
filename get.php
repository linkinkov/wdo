<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();

$job = isset($_GET["job"]) ? trim($_GET["job"]) : false;
if ( !$job ) die("no data");

switch ( $job )
{
	case "UserAvatar":
		$user_id = get_var("user_id","int",0);
		$w = get_var("w","int",35);
		$h = get_var("h","int",35);
		Avatar::getByUserID($user_id,$w,$h);
		break;
	case "getUserName":
		$user_id = get_var("user_id","int",0);
		$username = User::get_real_user_name($user_id);
		header('Content-Type: application/json');
		$response = is_array($username) ? $username : Array("result"=>"true","userName"=>$username);
		echo json_encode($response);
		break;
	case "Attach":
		$attach_id = get_var("attach_id","int",0);
		$w = get_var("w","int",35);
		$h = get_var("h","int",35);
		Attach::getByID($attach_id,$w,$h);
		break;
	case "cityList":
		$search = get_var("search","string");
		$cities = City::getList($search);
		header('Content-Type: application/json');
		echo json_encode($cities);
		break;
}