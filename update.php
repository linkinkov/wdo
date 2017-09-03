<?php
/*
$field = "password";
$value = "1234567";
$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
$value = hash('sha512', hash('sha512',$value) . $random_salt);
$sql = sprintf("UPDATE `users` SET `%s` = '%s', `salt` = '%s' WHERE `user_id` = '%d'",$field,$value,$random_salt,15);
echo $sql;
exit;

*/




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
