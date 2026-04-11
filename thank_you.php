<?php
session_start();
include "config.php";

$payment_id = $_GET['payment_id'];

// Fetch donation details
$stmt = $conn->prepare("
    SELECT d.*, dn.name, dn.email, dn.phone 
    FROM donations d 
    JOIN donors dn ON d.donor_id = dn.id 
    WHERE d.transaction_id = ? OR d.razorpay_payment_id = ? OR d.payu_payment_id = ?
");
$stmt->bind_param("sss", $payment_id, $payment_id, $payment_id);
$stmt->execute();
$result = $stmt->get_result();
$donation = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You for Your Donation!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h3>Thank You for Your Donation!</h3>
            <p>Your donation has been successfully processed.</p>
            <hr>
            <p><strong>Donation ID:</strong> <?php echo $donation['donation_no']; ?></p>
            <p><strong>Amount:</strong> ₹<?php echo number_format($donation['amount'], 2); ?></p>
            <p><strong>Transaction ID:</strong> <?php echo $donation['transaction_id'] ?? $donation['razorpay_payment_id'] ?? $donation['payu_payment_id']; ?></p>
            <p><strong>Payment Status:</strong> <?php echo ucfirst($donation['payment_status']); ?></p>
            <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>