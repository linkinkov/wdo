<?php
require_once('../_global.php');
include_once('../_includes.php');
if ( !check_access($db,false) ) {
	header('HTTP/1.0 401 Unauthorized',true,401);
	exit;
}
$current_user = new User($_SESSION["user_id"]);

require __DIR__ . '/vendor/autoload.php';
use YandexCheckout\Client;
$client = new Client();
$client->setAuth('505373', 'test_Y_EciqrTJVZntUSs_xA2DSk0KT6M9SB0uc6zjaQNbDM');

$amount = get_var("amount","int","post");

if ( $amount <= 1 ) exit('Low amount');

try {
    $idempotenceKey = uniqid($current_user->user_id, true);
    $payment = $client->createPayment(
        [
            'amount' => [
                'value' => $amount,
                'currency' => 'RUB'
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => HOST . '/profile/#transactions',
            ],
            'metadata' => [
                'user_id' => $current_user->user_id,
            ]
        ],$idempotenceKey
    );
    header('Location: '.$payment->confirmation->confirmation_url,true,302);
} catch ( Exception $e ) {
    echo 'Error: '.$e->getMessage()."\n".$e->getCode()."\n";
}

?>