<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();
// print_r($db);

$job = isset($_GET["job"]) ? trim($_GET["job"]) : false;
if ( !$job ) die("no data");

switch ( $job )
{
	case "UserAvatar":
		$user_id = (isset($_GET["user_id"])) ? intval($_GET["user_id"]) : 0;
		$w = (isset($_GET["w"]) && intval($_GET["w"]) >= 10 ) ? intval($_GET["w"]) : 35;
		$h = (isset($_GET["h"]) && intval($_GET["h"]) >= 10 ) ? intval($_GET["h"]) : 35;
		Avatar::getByUserID($user_id,$w,$h);
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
		echo json_encode($cities);
		break;
}