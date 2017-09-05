<?php
// Application classes defined in _global.php
require_once("_global.php");

foreach ( $distribute_classes as $className )
{
	require_once(sprintf(PD.'/lib/%s.class.php',$className));
}

$db = db::getInstance();
session_name('wdo_session_id');

check_access($db,false);
$_SESSION["LAST_PAGE"] = "";
$current_user = new User($_SESSION["user_id"]);
if ( !isset($_COOKIE["user_id"]) || intval($_COOKIE["user_id"] < 1) ) $current_user->set_city_auto();


?>