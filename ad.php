<?php
require_once('_global.php');
include_once('_includes.php');
require_once('lib/Resize.class.php');
require_once('lib/Avatar.class.php');
require_once('lib/Attach.class.php');
$db = db::getInstance();

check_access($db,false);
$current_user = new User($_SESSION["user_id"]);
$job = isset($_GET["job"]) ? trim($_GET["job"]) : false;
if ( !$job ) die("no data");

switch ( $job )
{
	case "create":
		$data = get_var("data","array","");
		if ( isset($data["adv_id"]) && strlen($data["adv_id"]) == 32 )
		{
			$adv = new Adv($data["adv_id"]);
			$response = $adv->update($data);
		}
		else
		{
			$response = Adv::create($data);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "load":
		$adv_id = get_var("data","array","");
		$adv = new Adv($adv_id);
		header('Content-Type: application/json');
		echo json_encode($adv);
		break;
	case "load_user_advs":
		$status_id = get_var("data","int","");
		$list = Adv::load_user_advs($status_id);
		header('Content-Type: application/json');
		echo json_encode($list);
		break;
}