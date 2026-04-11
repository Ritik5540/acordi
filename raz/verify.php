<?php
require('../vendor/autoload.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// $keyId = "rzp_live_SYg7jo16MkgoSC";
$keyId = "rzp_test_SYhOqsVk99ss1T";
$keySecret = "ianNLapirXP9dr5oz14Q8ATY";

$api = new Api($keyId, $keySecret);

$data = json_decode(file_get_contents("php://input"), true);

$attributes = [
    'razorpay_order_id' => $data['razorpay_order_id'],
    'razorpay_payment_id' => $data['razorpay_payment_id'],
    'razorpay_signature' => $data['razorpay_signature']
];

try {
    $api->utility->verifyPaymentSignature($attributes);
    echo "Payment Successful ✅";
} catch(SignatureVerificationError $e) {
    echo "Payment Failed ❌";
}