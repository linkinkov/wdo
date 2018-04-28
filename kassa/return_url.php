return_url
<?php
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
$orderId = isset($_REQUEST['orderId']) ? $_REQUEST['orderId'] : '';
// 2273fb89-000f-5000-a000-13c56f845670
// if ( !isset($user_id) || intval($user_id) <= 0 ) exit('No user_id');
?>
<a href="https://193.169.110.85:91/profile/#wallet_refill">Refill again</a>
<pre>
<?php
highlight_file('index.php');
?>
</pre>
<pre>
<?php
require __DIR__ . '/vendor/autoload.php';
use YandexCheckout\Client;
$client = new Client();
$client->setAuth('505373', 'test_Y_EciqrTJVZntUSs_xA2DSk0KT6M9SB0uc6zjaQNbDM');

echo "You came from: ".$_SERVER['HTTP_REFERER']."\n";
if ( $orderId == '' ) {
    $p = parse_url($_SERVER['HTTP_REFERER']);
    parse_str($p['query'],$query);
    $orderId = $query['orderId'];
}
echo "orderId: ".$orderId."\n";
echo "\n".'$payment = $client->getPaymentInfo($orderId);'."\n";
echo "\n".'echo json_encode($payment,JSON_PRETTY_PRINT);'."\n\n";
try {
    $payment = $client->getPaymentInfo($orderId);
    echo json_encode($payment,JSON_PRETTY_PRINT);
} catch ( Exception $e ) {
    echo 'Error: '.$e->getMessage()."\n".$e->getCode()."\n";
}
?>
</pre>