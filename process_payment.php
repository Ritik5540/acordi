<?php
session_start();
include "config.php";

if (!isset($_SESSION['donation_data'])) {
    header("Location: index.php");
    exit;
}

$donation = $_SESSION['donation_data'];
$gateway = $_POST['gateway'];

// Update payment method in database
$stmt = $conn->prepare("UPDATE donations SET payment_method = ? WHERE id = ?");
$stmt->bind_param("si", $gateway, $donation['donation_id']);
$stmt->execute();

if ($gateway == 'razorpay') {
    // Redirect to Razorpay payment
    header("Location: razorpay_payment.php");
} elseif ($gateway == 'payu') {
    // Redirect to PayU payment
    header("Location: payu_payment.php");
} else {
    die("Invalid payment gateway");
}
?>