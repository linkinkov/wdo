<?php
define('PD',DIRNAME(__FILE__));
ini_set("display_errors","1");

// Main required classes
require_once(PD.'/_version.php');
require_once(PD.'/lib/mysqli.class.php');
require_once(PD.'/includes/functions.php');
$db = db::getInstance();
session_name('wdo_session_id');
if ( session_status() != PHP_SESSION_ACTIVE ) sec_session_start(false);

define('HOST','https://'.$_SERVER["HTTP_HOST"]);
$distribute_classes = Array(
	"City",
	"User",
	"Project",
	"ProjectRespond",
	"Category",
	"SubCategory",
	"Dialog"

);