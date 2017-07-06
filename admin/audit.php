<?php
opcache_reset();
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');
check_access($db,true);

$type = get_var("type","string",false);
$id = get_var("id","int",false);
$recipient_id = get_var("recipient_id","int",false);
if ( !$type || !$id || !$recipient_id ) die("no data");

switch ( $type )
{
	case "project":
		$response = Project::block($id,$real_user_name,$password);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;