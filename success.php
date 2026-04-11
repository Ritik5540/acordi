<?php
session_start();
require "config.php";
require "mail-send.php";

$SALT = PAYU_MERCHANT_SALT;
$MERCHANT_KEY  = PAYU_MERCHANT_KEY;

// ================= LOG FILE ================= //
$file = (__DIR__ . (($_SERVER['HTTP_HOST'] == 'localhost')
    ? '/payment-completed.txt'
    : '/payu-payment-completed.txt'));

$data = "-----------------------------\n";
$data .= "Date: " . date("Y-m-d H:i:s") . "\n";
$data .= print_r($_POST, true);
$data .= "\n-----------------------------\n\n";

file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// die();

// ================= VALIDATE POST ================= //
if (empty($_POST)) {
    die("Invalid Request");
}

// ================= FETCH DATA ================= //
$status        = $_POST["status"] ?? '';
$txnid         = $_POST["txnid"] ?? '';
$amount = $_POST["amount"]; // EXACT same use karo
$phone         = trim($_POST["phone"] ?? '');
$email       = trim($_POST["email"]);
$firstname   = trim($_POST["firstname"]);
$productinfo = trim($_POST["productinfo"]);
$payment_id    = $_POST['mihpayid'] ?? '';
$udf1   = $_POST['udf1'] ?? '';
$udf2 = $_POST['udf2'] ?? '';
$posted_hash = $_POST["hash"];
$campaign_title = $productinfo;
$website_url   = 'https://acordi.in';
$udf1 = $_POST['udf1'] ?? '';
$udf2 = $_POST['udf2'] ?? '';
$udf3 = $_POST['udf3'] ?? '';
$udf4 = $_POST['udf4'] ?? '';
$udf5 = $_POST['udf5'] ?? '';

// ================= HASH VERIFY ================= //
// HASH VERIFY
$hashSeq = $SALT . '|' . $status . '|||||||||' .
    $udf2 . '|' . $udf1 . '|' .
    $email . '|' . $firstname . '|' . $productinfo . '|' .
    $amount . '|' . $txnid . '|' . $MERCHANT_KEY;

$calculated_hash = hash("sha512", $hashSeq);

if ($calculated_hash !== $posted_hash) {
    die("Invalid Transaction (Hash Mismatch)");
}

// ================= PAYMENT STATUS ================= //
if ($status !== 'success') {
    header("Location: failure.php");
    exit;
}

// ================= UPDATE DB ================= //
$stmt = $conn->prepare("
    UPDATE donations 
    SET payment_status = 'success', 
        transaction_id = ?, 
        payment_date = NOW(),
        payu_payment_id = ?,
        order_id = ?
    WHERE txn_id = ? AND payment_status = 'pending'
");

$stmt->bind_param("ssss", $payment_id, $payment_id, $udf2, $txnid);
$stmt->execute();


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($stmt->affected_rows <= 0) {
    header("Location: failure.php");
    exit;
}

unset($_SESSION['donation_data']);

// ================= FETCH UPDATED DATA ================= //
$stmt = $conn->prepare("SELECT * FROM donations WHERE txn_id = ? LIMIT 1");
$stmt->bind_param("s", $txnid);
$stmt->execute();

$result = $stmt->get_result();
$donation = $result->fetch_assoc();

if (!$donation) {
    header("Location: failure.php");
    exit;
}

$donation_no = $donation['donation_no'];

// ================= SEND MAIL ================= //
sendDonationThankYouMail(
    $email,
    $firstname,
    $amount,
    $donation_no,
    $campaign_title,
    $payment_id,
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
            <th>Order ID</th>
            <td><?php echo $udf2; ?></td>
        </tr>
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