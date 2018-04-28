<?php
ini_set('display_errors',1);
require __DIR__ . '/vendor/autoload.php';
use YandexCheckout\Client;
use YandexCheckout\Model\Notification\NotificationSucceeded;
use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
use YandexCheckout\Model\NotificationEventType;
use YandexCheckout\Model\NotificationType;

$client = new Client();
$client->setAuth('505373', 'test_Y_EciqrTJVZntUSs_xA2DSk0KT6M9SB0uc6zjaQNbDM');

$log = __DIR__ . '/log';
$prefix = '[' . date('Y/m/d H:i:s') . ']['.$_SERVER['REMOTE_ADDR'].']';
$input = file_get_contents('php://input');
file_put_contents($log,$prefix.' input: ' . $input."\n",FILE_APPEND);
try {
    if ( ($json = json_decode(file_get_contents('php://input'),true)) === false ) {
        throw new Exception('Not JSON format',1);
    }
    if ( $json['event'] == NotificationEventType::PAYMENT_SUCCEEDED ) {
        $notification = new NotificationSucceeded($json);
        $payment = $notification->getObject();
        if ( $payment->paid == true ) {
            if ( intval($payment->metadata['user_id']) <= 0 ) exit('wrong user_id');
            include './../lib/User.class.php';
            include './../lib/Wallet.class.php';
            include './../_global.php';
            $db = db::getInstance();
            $db->autocommit(false);
            $current_user = new User($payment->metadata['user_id']);
            $current_user->init_wallet();

            $new_transaction = Array (
                "reference_id"=>$payment->id,
                "for_project_id" => 0,
                "type"=>"PAYMENT",
                "amount"=>$payment->amount->jsonSerialize()['value'],
                "descr"=>"Пополнение кошелька",
                "commit"=>false
            );
            $tx = $current_user->wallet->find_transaction([
                'wallet_id' => $current_user->wallet->get_wallet_id(),
                'reference_id' => $payment->id,
                'type' => 'PAYMENT'
            ]);
            if ( isset($tx->transaction_id) ) exit('Exists');
            if ( ($transaction_id = $current_user->wallet->create_transaction($new_transaction)) === false )
            {
                // Error create new payment
                file_put_contents($log,$prefix.' error creating txid'."\n");
            } else {
                file_put_contents($log,$prefix.' created txid = '.$transaction_id."\n");
                $db->commit();
                $db->close();
            }
        }
    } else if ( $json['event'] == NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE ) {
        $notification = new NotificationWaitingForCapture($json);
        $payment = $notification->getObject();
        if ( $payment['paid'] !== true ) {
            throw new Exception('Not paid. Delete transaction or something...?');
        } else {
            $payment = $notification->getObject();
            if ( intval($payment->metadata['user_id']) <= 0 ) exit('wrong user_id');
            $client->capturePayment(
                array(
                    'amount' => $payment->amount,
                ),
                $payment->id,
                uniqid('', true)
            );
        }
        // file_put_contents($log,$prefix.' saving data: '.json_encode($json)."\n");
        // echo $prefix.' saving data:'.json_encode($json)."\n";
    } else {
        throw new Exception('Unknown event');
    }
} catch ( Exception $e ) {
    // if ( get_class($e) == 'EmptyPropertyValueException' ) {
    // }
    file_put_contents($log,$prefix . ' error: ' . get_class($e) . ': ' . $e->getMessage()."\n",FILE_APPEND);
    // echo $prefix . ' error: ' . get_class($e) . ': ' . $e->getMessage()."\n";
}
?>
