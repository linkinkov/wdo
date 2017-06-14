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

echo "<pre>";
echo "
orig: 4052a28f3e6dd1985e5a914959366a7c2928c7f24b9eb2735d020bd318de7eaae0f361c3e970c993302a2592ffe4296ff0c4be937b8ac6a40c53a88ffc93f050";
$salt = $db->getValue("users","salt","salt",Array("user_id"=>1));
echo "
salt: ".$salt;

$hashed = hash('sha512',hash('sha512',"290233").$salt);

echo "
hash: ".$hashed;

$uniq_id = md5($current_user->user_id.time());
echo "
uniq: ".$uniq_id;
// print_r($current_user);
$user = new User($current_user->user_id);
// $current_user->wallet = new Wallet();
// $current_user->wallet->get_transactions();
$user->init_wallet();

print_r($user);
echo "</pre>";



?>