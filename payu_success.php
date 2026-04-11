<?php
session_start();
include "config.php";

$txnid = $_POST['txnid'];
$amount = $_POST['amount'];
$payment_id = $_POST['mihpayid'];
$status = $_POST['status'];
$donation_id = $_POST['udf1'];

if ($status == 'success') {
    // Update donation record
    $stmt = $conn->prepare("
        UPDATE donations 
        SET payment_status = 'success', 
            transaction_id = ?, 
            payment_date = NOW(),
            payu_payment_id = ?
        WHERE txn_id = ? AND payment_status = 'pending'
    ");

    $stmt->bind_param("sss", $payment_id, $payment_id, $txnid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        unset($_SESSION['donation_data']);
        header("Location: success.php");
    } else {
        header("Location: payment_failed.php");
    }
} else {
    header("Location: payment_failed.php");
}
