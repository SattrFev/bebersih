<?php
require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-CYp6oX8DG5JyD8mpD9NRJFrR';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$raw = file_get_contents("php://input");
$data = json_decode($raw, true); 

$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $data['amount'],
    ),
    'customer_details' => array(
        'first_name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['number'], 
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
echo $snapToken;
?>