<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();
check_access($db,false);
$current_user = new User($_SESSION["user_id"]);

if ( $current_user->user_id == 0 )
{
	header($_SERVER["SERVER_PROTOCOL"]." 401 Not authorized", true, 404);
	$error = 401;
	include(PD.'/errors/error.php');
	exit;
}

$job = isset($_GET["job"]) ? trim($_GET["job"]) : false;
if ( !$job ) die("no data");

switch ( $job )
{
	case "getDialogId":
		$recipient_id = get_var("recipient_id","int",0);
		$response = Dialog::get_dialog_id($recipient_id);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "getDialogs":
		$response = Dialog::get_dialogs();
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "getMessages":
		$dialog_id = get_var("dialog_id","string",false);
		$timestamp = get_var("timestamp","int",false);
		$limit = get_var("limit","int",50);
		$start = get_var("start","int",0);
		$wait = get_var("wait","int",0);
		$response = Dialog::get_messages($dialog_id,$start,$limit,$timestamp,$wait);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "sendMessage":
		$dialog_id = get_var("dialog_id","string",false);
		$message_text = get_var("message_text","string","");
		$response = Dialog::send_message($dialog_id,$message_text);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
}