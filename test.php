<?php
ini_set("display_errors",1);
define('PD',DIRNAME(__FILE__));
$db = new mysqli("localhost","root","290233","wdo");
$db->query("set names utf8");

require_once('lib/mysqli.class.php');
$db = db::getInstance();
$db->autocommit(false);

$cached = "/var/www/html/wdo/attaches/1/cache/18fa0602qh3.png";
echo dirname($cached);

exit;
// get dialog_id
// SELECT `dialog_id` FROM `dialogs` WHERE find_in_set('2',`dialog_members`) <> 0

// get messages for dialog
// SELECT `username` FROM `users` WHERE find_in_set(`user_id`,(SELECT `dialog_members` FROM `dialogs` WHERE `dialog_id` = 'c87954eaea3ed578ea5606c103e21aeb')) <> 0
$uid = md5(time()."1");
echo $uid."\n";
exit;
$users = Array(1,2,3);
for ( $i=0; $i<=200; $i++ )
{
	shuffle($users);
	$user_id_from = reset($users);
	shuffle($users);
	$user_id_to = reset($users);
	$uid = md5(time().$user_id_from.$i);
	$text = "$i: from $user_id_from to $user_id_to $uid";
	$sql = sprintf("INSERT INTO `messages` (`message_id`,`message_text`,`user_id_from`,`user_id_to`,`timestamp`,`readed`)
	VALUES ('%s','%s','%d','%d',UNIX_TIMESTAMP(),0)",$uid,$text,$user_id_from,$user_id_to);
	$db->query($sql);
}
$db->commit();

/*

SELECT DISTINCT `user_id_from` FROM `messages` WHERE `user_id_to` = 1
UNION 
SELECT DISTINCT `user_id_to` FROM `messages` WHERE `user_id_from` = 1

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