<?php
exit;
require __DIR__ . '/vendor/autoload.php';
use YandexCheckout\Client;
$client = new Client();
$client->setAuth('505373', 'test_Y_EciqrTJVZntUSs_xA2DSk0KT6M9SB0uc6zjaQNbDM');
$amount = (isset($_REQUEST['amount'])) ? intval($_REQUEST['amount']) : 125;
try {
    $idempotenceKey = uniqid('', true);
    $payment = $client->createPayment(
        array(
            'amount' => [
                'value' => $amount,
                'currency' => 'RUB'
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => 'https://193.169.110.85:91/kassa/return_url?user_id='.$current_user->user_id.'&amount='.$amount,
            ],
        ),$idempotenceKey
    );
    header('Location: '.$payment->confirmation->confirmation_url,true,302);
} catch ( Exception $e ) {
    echo 'Error: '.$e->getMessage()."\n".$e->getCode()."\n";
}

?>
