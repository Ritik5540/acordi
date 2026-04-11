<?php
session_start();
include "config.php";

if (!isset($_SESSION['donation_data'])) {
    header("Location: index.php");
    exit();
}

$donation_data = $_SESSION['donation_data'];

// Cashfree API Keys (Replace with your actual keys)
$cashfree_app_id = "YOUR_CASHFREE_APP_ID";
$cashfree_secret_key = "YOUR_CASHFREE_SECRET_KEY";

// Create order ID
$order_id = $_SESSION['order_id'];

// Cashfree API URL (Test mode)
$cashfree_url = "https://test.cashfree.com/api/v2/checkout/orders";

$post_data = [
    "order_id" => $order_id,
    "order_amount" => $donation_data['amount'],
    "order_currency" => "INR",
    "order_note" => "Donation for " . $donation_data['campaign_title'],
    "customer_details" => [
        "customer_id" => "cust_" . $donation_data['donor_id'],
        "customer_name" => $donation_data['name'],
        "customer_email" => $donation_data['email'],
        "customer_phone" => $donation_data['phone']
    ],
    "order_meta" => [
        "return_url" => "http://" . $_SERVER['HTTP_HOST'] . "/payment_success.php?gateway=cashfree&order_id=" . $order_id
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $cashfree_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Client-Id: ' . $cashfree_app_id,
    'X-Client-Secret: ' . $cashfree_secret_key
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (isset($result['payment_link'])) {
    header("Location: " . $result['payment_link']);
} else {
    echo "Error creating Cashfree order: " . $response;
}
exit();
?>