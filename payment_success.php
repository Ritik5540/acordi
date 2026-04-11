<?php
session_start();
include "config.php";
require "mail-send.php";

// Validate input
if (!isset($_GET['payment_id'], $_GET['order_id'])) {
    header("Location: payment_failed.php");
    exit;
}

$payment_id = trim($_GET['payment_id']);
$order_id   = trim($_GET['order_id']);

// ================= UPDATE PAYMENT ================= //
$updateStmt = $conn->prepare("
    UPDATE donations 
    SET payment_status = 'success', 
        transaction_id = ?, 
        payment_date = NOW(),
        razorpay_payment_id = ?
    WHERE order_id = ? AND payment_status = 'pending'
");

$updateStmt->bind_param("sss", $payment_id, $payment_id, $order_id);
$updateStmt->execute();

if ($updateStmt->affected_rows <= 0) {
    header("Location: payment_failed.php");
    exit;
}

// Clear session
unset($_SESSION['donation_data'], $_SESSION['razorpay_order_id']);

// ================= FETCH DATA ================= //
$fetchStmt = $conn->prepare("
    SELECT d.*, dn.name, dn.email, dn.phone, dc.title AS campaign_title
    FROM donations d 
    JOIN donors dn ON d.donor_id = dn.id
    JOIN donation_categories dc ON d.category_id = dc.id 
    WHERE d.transaction_id = ?
    LIMIT 1
");

$fetchStmt->bind_param("s", $payment_id);
$fetchStmt->execute();
$result = $fetchStmt->get_result();
$donation = $result->fetch_assoc();

if (!$donation) {
    header("Location: payment_failed.php");
    exit;
}

// ================= SEND MAIL ================= //
$website_url = 'https://acordi.in';

sendDonationThankYouMail(
    $donation['email'],
    $donation['name'],
    $donation['amount'],
    $donation['donation_no'],
    $donation['campaign_title'],
    $donation['razorpay_payment_id'],
    $website_url
);

$status = "Success";
?>

<?php include "header.php"; ?>

<div class="container py-5 text-center">

    <svg width="120" height="120" fill="#1a685b" viewBox="0 0 24 24">
        <path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 
        12-5.37 12-12S18.63 0 12 0zm-2 17l-5-5 
        1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
    </svg>

    <h2 class="mt-4">Thank You For Your Contribution</h2>
    <p>Your donation helps support important causes and improve lives.</p>
    <p>Donation No: <strong><?= htmlspecialchars($donation['donation_no']) ?></strong></p>
</div>

<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>Order ID</th>
            <td><?= htmlspecialchars($donation['order_id']) ?></td>
        </tr>
        <tr>
            <th>Transaction ID</th>
            <td><?= htmlspecialchars($donation['razorpay_payment_id']) ?></td>
        </tr>
        <tr>
            <th>Payment Status</th>
            <td style="color: green; background-color: #d4edda;">
                <?= $status ?>
            </td>
        </tr>
        <tr>
            <th>Amount</th>
            <td><?= htmlspecialchars($donation['amount']) ?></td>
        </tr>
        <tr>
            <th>Campaign</th>
            <td><?= htmlspecialchars($donation['campaign_title']) ?></td>
        </tr>
        <tr>
            <th>Donor Name</th>
            <td><?= htmlspecialchars($donation['name']) ?></td>
        </tr>
        <tr>
            <th>Donor Email</th>
            <td><?= htmlspecialchars($donation['email']) ?></td>
        </tr>
        <tr>
            <th>Donor Phone</th>
            <td><?= htmlspecialchars($donation['phone']) ?></td>
        </tr>
        <tr>
            <th>Donation No</th>
            <td><?= htmlspecialchars($donation['donation_no']) ?></td>
        </tr>
    </table>

    <a href="/" class="btn btn-primary mt-3">Back to Home</a>
</div>

<br>

<?php include "footer.php"; ?>