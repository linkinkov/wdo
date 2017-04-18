<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();
$current_user = new User($_SESSION["user_id"]);

$job = isset($_GET["job"]) ? trim($_GET["job"]) : false;
if ( !$job ) die("no data");

switch ( $job )
{
	case "getAvatar":
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
	case "getUserNote":
		$user_id = get_var("user_id","int",0);
		$note = User::get_user_note($user_id);
		header('Content-Type: application/json');
		$response = is_array($note) ? $note : Array("result"=>"true","userNote"=>$note);
		echo json_encode($response);
		break;
	case "sendMessage":
		$user_id = get_var("user_id","int",0);
		$message_text = get_var("message_text","string","");
		$response = User::sendMessage($user_id,$message_text);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "addNote":
		$user_id = get_var("user_id","int",0);
		$note_text = get_var("note_text","string","");
		$response = User::addNote($user_id,$note_text);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
}