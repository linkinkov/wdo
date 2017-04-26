<?php
ini_set("display_errors",1);
define('PD',DIRNAME(__FILE__));
$db = new mysqli("localhost","root","290233","wdo");
$db->query("set names utf8");

require_once('lib/mysqli.class.php');
$db = db::getInstance();

$user_id = 1;
$session = "j610kltmug32mursiag47fdqs3";
$arr = glob(PD."/users/avatars/cache/$user_id-*.{jpg,jpeg,png,gif}",GLOB_BRACE);
print_r($arr);


/*
$username = "manager";
$new_pass = "manager";

$passwordSalt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
$password = hash('sha512', hash('sha512',$new_pass) . $passwordSalt);

echo $passwordSalt."\n".$password."\n";
*/
exit;
for($i=131; $i<=200; $i++)
{
	$cost = rand(500,5000);
	$title = "project ".$i;
	$descr = "project $i descr";
	$created = time()-(86400*$i);
	$start_date = $created + (86400+rand(3,14)*$i);
	$end_date = $start_date;
	$cat_id = rand(1,2);
	$city_id = rand(1,4);
	if ( $i%3 == 0 ) $end_date = $start_date + (86400+rand(1,3)*$i);
	$str = sprintf("INSERT INTO `project` (`project_id`,`title`, `descr`, `cost`, `created`, `status_id`, `user_id`, `start_date`, `end_date`,`cat_id`,`city_id`)
	VALUES ($i, '%s', '%s', %d, %d, 1, 1, %d, %d, %d, %d);",$title,$descr,$cost,$created,$start_date,$end_date,$cat_id,$city_id);
	echo $str."\n";
	// $sql = sprintf("UPDATE `projects` SET `created` = '%d',`start_date` = '%d',`end_date` = '%d' WHERE `project_id` = '%d'",$created,$start_date,$end_date,$i);
	$db->query($str);
}