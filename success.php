<?php
require "config.php";
require 'mail-send.php';

$SALT = PAYU_MERCHANT_SALT;
$key = PAYU_MERCHANT_KEY;

// File path
$file = __DIR__ . '/payment-completed.txt';

// Data ko readable format me convert karo
$data = "-----------------------------\n";
$data .= "Date: " . date("Y-m-d H:i:s") . "\n";
$data .= print_r($_POST, true); // array to string
$data .= "\n-----------------------------\n\n";

// Append mode me save karo
file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

// ================= VERIFY ================= //
$status = $_POST["status"];
$txnid = $_POST["txnid"];
$amount = $_POST["amount"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$firstname = $_POST["firstname"];
$productinfo = $_POST["productinfo"];
$posted_hash = $_POST["hash"];
$campaign_title = $productinfo; // for mail purpose
$website_url = 'https://acordi.in'; // hardcoded for security

// HASH VERIFY
$hashSeq = $SALT . "|" . $status . "|||||||||||" . $email . "|" . $firstname . "|" . $productinfo . "|" . $amount . "|" . $txnid . "|" . $key;
$hash = strtolower(hash("sha512", $hashSeq));

if ($hash != $posted_hash) {
    die("Invalid Transaction");
}

// ================= UPDATE DB ================= //
$stmt = $conn->prepare("
UPDATE donations 
SET payment_status='success' 
WHERE txn_id=?
");

$stmt->bind_param("s", $txnid);
$stmt->execute();

$sql = "SELECT * FROM donations WHERE txn_id='$txnid' and payment_status='success' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $donation = $result->fetch_assoc();
    $donation_no = $donation['donation_no'];
} else {
    header("Location: failure.php");
    exit;
}

// ================= SEND MAIL ================= //
sendDonationThankYouMail(
    $email,
    $firstname,
    $amount,
    $donation_no,
    $campaign_title,
    $txnid,
    $website_url
);

?>
<?php include "header.php"; ?>
<div class="container py-5 text-center">

    <svg width="120" height="120" fill="#1a685b" viewBox="0 0 24 24">
        <path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 
        12-5.37 12-12S18.63 0 12 0zm-2 17l-5-5 
        1.41-1.41L10 14.17l7.59-7.59L19 
        8l-9 9z" />
    </svg>

    <h2 class="mt-4">Thank You For Your Contribution</h2>
    <p>Your donation helps support important causes and improve lives.</p>
    <p>Donation No: <strong><?php echo $donation_no; ?></strong></p>
</div>
<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>Transaction ID</th>
            <td><?php echo $txnid; ?></td>
        </tr>
        <tr>
            <th>Payment Status</th>
            <td style="color: green; background-color: #d4edda; border-color: #c3e6cb;"><?php echo $status; ?></td>
        </tr>
        <tr>
            <th>Amount</th>
            <td><?php echo $amount; ?></td>
        </tr>
        <tr>
            <th>Campaign</th>
            <td><?php echo $productinfo; ?></td>
        </tr>
        <tr>
            <th>Donar Name</th>
            <td><?php echo $firstname; ?></td>
        </tr>
        <tr>
            <th>Donar Email</th>
            <td><?php echo $email; ?></td>
        </tr>
        <tr>
            <th>Donar Phone</th>
            <td><?php echo $phone; ?></td>
        </tr>
        <tr>
            <th>Donation No</th>
            <td><?php echo $donation_no; ?></td>
        </tr>
    </table>
    <a href="/" class="btn btn-primary mt-3 text-center">Back to Home</a>
</div>
<br>
<?php include "footer.php"; ?>