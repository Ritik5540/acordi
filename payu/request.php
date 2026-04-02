<?php
require "../config.php"; // path adjust
require '../mail-send.php';

// PayU Test Credentials
$MERCHANT_KEY = PAYU_MERCHANT_KEY;
$SALT = PAYU_MERCHANT_SALT;

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$amount = isset($_POST['preset']) ? (float)$_POST['preset'] : (float)$_POST['amount'];
$category = $_POST['category_id'];
$message = $_POST['message'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$campaign_title = $_POST['campaign_title'];
$website_url = $_POST['website_url'];

// Payment Details
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$amount = $amount; // test amount
$productinfo = $campaign_title;
$firstname = $name;
$email = $email;

$donation_no = "DON" . time();
// ================= INSERT DONOR ================= //
$stmt = $conn->prepare("
INSERT INTO donors(name,email,phone,city,state,country,address)
VALUES (?,?,?,?,?,?,?)
");

$stmt->bind_param("sssssss", $name, $email, $phone, $city, $state, $country, $address);
$stmt->execute();

$donor_id = $stmt->insert_id;

// ================= INSERT DONATION (PENDING) ================= //
$stmt2 = $conn->prepare("
INSERT INTO donations
(donation_no, donor_id, category_id, amount, payment_status, message, txn_id, donated_at)
VALUES (?,?,?,?, 'pending', ?, ?, NOW())
");

$stmt2->bind_param("siidss", $donation_no, $donor_id, $category, $amount, $message, $txnid);
$stmt2->execute();

// Success & Failure URLs
$surl = PAYU_SUCCESS_URL;
$furl = PAYU_FAILURE_URL;

// Hash generation
$hash_string = $MERCHANT_KEY . "|" . $txnid . "|" . $amount . "|" . $productinfo . "|" . $firstname . "|" . $email . "|||||||||||" . $SALT;

$hash = strtolower(hash('sha512', $hash_string));

// PayU Test URL
$payu_url = PAYU_BASE_URL;

?>

<!DOCTYPE html>
<html>
<head>
    <title>PayU Test Payment</title>
</head>
<body>

<h2>Redirecting to PayU...</h2>

<form action="<?php echo $payu_url; ?>" method="post" name="payuForm">
    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY; ?>" />
    <input type="hidden" name="txnid" value="<?php echo $txnid; ?>" />
    <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>" />
    <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
    <input type="hidden" name="email" value="<?php echo $email; ?>" />
    <input type="hidden" name="phone" value="9999999999" />

    <input type="hidden" name="surl" value="<?php echo $surl; ?>" />
    <input type="hidden" name="furl" value="<?php echo $furl; ?>" />

    <input type="hidden" name="hash" value="<?php echo $hash; ?>" />

    <!-- Optional Fields -->
    <input type="hidden" name="udf1" value="" />
    <input type="hidden" name="udf2" value="" />
    <input type="hidden" name="udf3" value="" />
    <input type="hidden" name="udf4" value="" />
    <input type="hidden" name="udf5" value="" />

</form>

<script>
    document.payuForm.submit();
</script>

</body>
</html>