<?php

$input = '{"type":"notification","event":"payment.waiting_for_capture","object":{"id":"2276a845-000f-5000-a000-172bd5b5821a","status":"waiting_for_capture","paid":true,"amount":{"value":"15.00","currency":"RUB"},"created_at":"2018-04-28T15:34:44.675Z","expires_at":"2018-05-05T15:34:46.334Z","metadata":{"user_id":"3"},"payment_method":{"type":"bank_card","id":"2276a845-000f-5000-a000-172bd5b5821a","saved":false,"card":{"first6":"111111","last4":"1026","expiry_month":"08","expiry_year":"2021","card_type":"Unknown"},"title":"Bank card *1026"},"recipient":{"account_id":"505373","gateway_id":"1513357"},"test":true}}';
$input = '{"type":"notification","event":"payment.succeeded","object":{"id":"2276a845-000f-5000-a000-172bd5b5821a","status":"succeeded","paid":true,"amount":{"value":"15.00","currency":"RUB"},"captured_at":"2018-04-28T15:41:49.784Z","created_at":"2018-04-28T15:34:44.675Z","metadata":{"user_id":"3"},"payment_method":{"type":"bank_card","id":"2276a845-000f-5000-a000-172bd5b5821a","saved":false,"card":{"first6":"111111","last4":"1026","expiry_month":"08","expiry_year":"2021","card_type":"Unknown"},"title":"Bank card *1026"},"recipient":{"account_id":"505373","gateway_id":"1513357"},"refunded_amount":{"value":"0.00","currency":"RUB"},"test":true}}';
$ch = curl_init('https://193.169.110.85:91/kassa/notify');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $input );
$result = curl_exec($ch);
echo $result;

exit;


$transactions = Array(
	"confirm_transaction_hold" => false,
	"confirm_transaction_hold_comission" => false,
	"confirm_transaction_overcost_comission" => false
);
$transactions["confirm_transaction_hold"] = Array (
	"transaction_id"=>"123123213juidh293t41923",
	"commit"=>false
);
$transactions["confirm_transaction_hold_comission"] = Array (
	"transaction_id"=>"1231ij389yd19gd9ad0af9f8e",
	"commit"=>false
);

foreach ( $transactions as $name => $transaction )
{
	if ( !is_array($transaction) ) continue;
	if ( strstr($name,"comission") !== false )
	{
		echo "$name: comission!\n";
	}
}

exit;

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