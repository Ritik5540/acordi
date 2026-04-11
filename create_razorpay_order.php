<?php
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$razorpay_key_id = "YOUR_RAZORPAY_KEY_ID";
$razorpay_key_secret = "YOUR_RAZORPAY_KEY_SECRET";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'amount' => $input['amount'],
    'currency' => $input['currency'],
    'receipt' => 'receipt_' . time()
]));
curl_setopt($ch, CURLOPT_USERPWD, $razorpay_key_id . ':' . $razorpay_key_secret);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>