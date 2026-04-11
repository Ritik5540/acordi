<?php
require('../vendor/autoload.php');

use Razorpay\Api\Api;

$keyId = "rzp_test_SYhOqsVk99ss1T";
$keySecret = "ianNLapirXP9dr5oz14Q8ATY";

$api = new Api($keyId, $keySecret);

$orderData = [
    'receipt'         => 'order_rcptid_11',
    'amount'          => 50000, // 500 INR = 50000 paise
    'currency'        => 'INR'
];

$order = $api->order->create($orderData);

echo json_encode([
    'order_id' => $order['id']
]);