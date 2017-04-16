<?php
define('PD',DIRNAME(__FILE__));
ini_set("display_errors","1");

// Main required classes
require_once(PD.'/_version.php');
require_once(PD.'/lib/mysqli.class.php');
require_once(PD.'/includes/functions.php');
$db = db::getInstance();
sec_session_start(false);
if ( !isset($_COOKIE["LANG"]) )
{
	$cur_lang = $db->getValue("server_settings","paramValue","paramValue",Array("paramName"=>'lang'));
}
else
{
	$cur_lang = $_COOKIE["LANG"];
}
if ( $cur_lang && in_array($cur_lang,Array("russian","english")) )
{
	if ( file_exists(PD.'/lang/'.$cur_lang.'.php') )
	{
		define('LANG',$cur_lang);
	}
	else
	{
		define('LANG',"russian");
	}
}
else
{
	define('LANG',"russian");
}

require_once(PD.'/lang/'.LANG.'.php');
define('LANG_SHORT',mb_strimwidth(LANG,0,2));

define('HOST','https://'.$_SERVER["HTTP_HOST"]);
$distribute_classes = Array(
	"User",
	"Project",
	"ProjectRespond",
	"Category",
	"SubCategory",
	"City",

);
