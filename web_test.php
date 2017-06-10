<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
{
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	// header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect, true, 301);
	exit();
}
require_once('_global.php');
include_once('_includes.php');

$uniq_id = md5($current_user->user_id.time());
echo "uniq: ".$uniq_id."<br />";
// print_r($current_user);
$user = new User($current_user->user_id);
// $current_user->wallet = new Wallet();
// $current_user->wallet->get_transactions();
$user->init_wallet();

echo '<pre>';
print_r($user);
echo '</pre>'



?>