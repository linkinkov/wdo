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
	case "sendMessage":
		$user_id = get_var("user_id","int",0);
		$message_text = get_var("message_text","string","");
		sleep(3);
		header('Content-Type: application/json');
		echo json_encode(Array("result"=>"true"));
		break;
		User::sendMessage($user_id,$message_text);
		break;
}