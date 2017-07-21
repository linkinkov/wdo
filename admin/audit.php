<?php
opcache_reset();
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');
check_access($db,true);

// print_r($current_user);
// exit;

if ( $current_user->user_id <= 0 ) exit("Access denied");

$type = get_var("type","string",false);
$message_text = get_var("message_text","string",false);
$id = get_var("id","int",false);
$recipient_id = get_var("recipient_id","int",false);
if ( !$type || !$id || !$recipient_id || !$message_text ) die("no data");

switch ( $type )
{
	case "project":
		$response = Project::block($id,$recipient_id,$message_text);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
	case "user":
		$response = User::block($id,$recipient_id,$message_text);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
}