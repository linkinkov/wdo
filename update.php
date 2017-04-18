<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();
$current_user = new User($_SESSION["user_id"]);
$type = get_var("type","string",false);
if ( !$type ) die("no data");

switch ( $type )
{
	case "project-respond":
		$respond_id = get_var("respond_id","int",0);
		$field = get_var("field","string",false);
		$value = get_var("value","string",false);
		if ( !$respond_id || !$field || !$value ) break;
		$respond = new ProjectRespond($respond_id);
		$response = $respond->update($field,$value);
		header('Content-Type: application/json');
		echo json_encode($response);
		break;
}
