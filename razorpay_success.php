<?php
session_start();
include "config.php";

$payment_id = $_GET['payment_id'];
$order_id = $_GET['order_id'];

// Update donation record
$stmt = $conn->prepare("
    UPDATE donations 
    SET payment_status = 'success', 
        transaction_id = ?, 
        payment_date = NOW(),
        razorpay_payment_id = ?
    WHERE order_id = ? AND payment_status = 'pending'
");

$stmt->bind_param("sss", $payment_id, $payment_id, $order_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Clear session data
    unset($_SESSION['donation_data']);
    unset($_SESSION['razorpay_order_id']);
    
    // Redirect to thank you page
    header("Location: payment_success.php?payment_id=" . $payment_id);
} else {
    header("Location: payment_failed.php");
}
?>