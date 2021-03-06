<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();
check_access($db,false);
$current_user = new User($_SESSION["user_id"]);

$job = isset($_GET["job"]) ? trim($_GET["job"]) : false;
if ( !$job ) die("no data");

switch ( $job )
{
	case "register":
		$username = get_var("username","string","");
		$password = get_var("password","string","");
		$real_user_name = get_var("real_user_name","string","");
		$response = User::register($username,$real_user_name,$password);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "activate":
		$key = get_var("key","string","");
		$response = User::activate($key);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "getAvatar":
		$user_id = get_var("user_id","int",0);
		$w = get_var("w","int",35);
		$h = get_var("h","int",35);
		$force_resize = get_var("force_resize","string","false");
		$method = get_var("method","string","auto");
		Avatar::getByUserID($user_id,$w,$h,$force_resize,$method);
		break;
	case "getNote":
		$user_id = get_var("user_id","int",0);
		$note = User::get_user_note($user_id);
		header('Content-Type: application/json');
		$response = is_array($note) ? $note : Array("result"=>"true","userNote"=>$note);
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
		$user_id = get_var("user_id","int",$current_user->user_id);
		if ( $action == "set" ) $response = $current_user->calendar($current_user->user_id,$action,$dates);
		else if ( $action == "get" ) $response = User::calendar($user_id,$action,$dates);
		header('Content-Type: application/json');
		$response = is_array($response) ? $response : Array("result"=>"false");
		echo json_encode($response);
		break;
	case "deleteAvatar":
		header('Content-Type: application/json');
		$response = $current_user->delete_avatar();
		$response = is_array($response) ? $response : Array("result"=>"false");
		echo json_encode($response);
		break;
	case "balanceRefill":
	/*
		header('Content-Type: application/json');
		$amount = get_var("amount","int","post");
		$response = Array(
			"result" => "true",
			"message" => sprintf("Ваш баланс пополнен на сумму %d",$amount)
		);
		$current_user->init_wallet();
		$db->autocommit(false);
		$new_transaction = Array (
			"reference_id"=>"",
			"for_project_id" => 0,
			"type"=>"PAYMENT",
			"amount"=>intval($amount),
			"descr"=>"Пополнение кошелька",
			"commit"=>false
		);
		if ( ($transaction_id = $current_user->wallet->create_transaction($new_transaction)) === false )
		{
			$response["message"] = "Ошибка зачисления средств";
			$response["result"] = "false";
			echo json_encode($response);
			break;
		}
		$db->commit();
		echo json_encode($response);
		*/
		break;

}