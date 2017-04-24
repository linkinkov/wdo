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
	case "getName":
		$user_id = get_var("user_id","int",0);
		$username = User::get_real_user_name($user_id);
		header('Content-Type: application/json');
		$response = is_array($username) ? $username : Array("result"=>"true","userName"=>$username);
		echo json_encode($response);
		break;
	case "getNote":
		$user_id = get_var("user_id","int",0);
		$note = User::get_user_note($user_id);
		header('Content-Type: application/json');
		$response = is_array($note) ? $note : Array("result"=>"true","userNote"=>$note);
		echo json_encode($response);
		break;
	case "sendMessage":
		$user_id = get_var("user_id","int",0);
		$message_text = get_var("message_text","string","");
		$response = User::send_message($user_id,$message_text);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "saveNote":
		$user_id = get_var("user_id","int",0);
		$note_text = get_var("note_text","string","");
		$response = User::save_note($user_id,$note_text);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "getProfileCounters":
		$response = $current_user->get_counters();
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "getProfileInfo":
		$user_id = get_var("user_id","int",0);
		$response = User::get_profile_info($user_id);
		header('Content-Type: application/json');
		$response = is_array($response) ? $response : Array("result"=>"false");
		echo json_encode($response);
		break;
	case "updateProfileInfo":
		$data = get_var("data","array",Array());
		$response = $current_user->update_profile_info($data);
		header('Content-Type: application/json');
		$response = is_array($response) ? $response : Array("result"=>"false","message"=>"error");
		echo json_encode($response);
		break;
	case "calendar":
		$action = get_var("action","string","get");
		$dates = get_var("dates","array",Array());
		$response = $current_user->calendar($action,$dates);
		header('Content-Type: application/json');
		$response = is_array($response) ? $response : Array("result"=>"false");
		echo json_encode($response);
		break;
}