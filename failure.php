<?php
include "config.php";

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // File path
    $file = __DIR__ . '/payment-completed.txt';
} else {
    // File path
    $file = __DIR__ . '/payu-payment-completed.txt';
}

// Data convert
$data = "-----------------------------\n";
$data .= "Date: " . date("Y-m-d H:i:s") . "\n";
$data .= print_r($_POST, true);
$data .= "\n-----------------------------\n\n";

// ✅ SAVE HERE
file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

$txnid = $_POST['txnid'];

$stmt = $conn->prepare("
UPDATE donations 
SET payment_status='failed' 
WHERE txn_id=?
");

$stmt->bind_param("s", $txnid);
$stmt->execute();

$status = $_POST["status"];
$txnid = $_POST["txnid"];
$amount = $_POST["amount"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$firstname = $_POST["firstname"];
$productinfo = $_POST["productinfo"];

$sql = "SELECT * FROM donations WHERE txn_id='$txnid' and payment_status='success' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $donation = $result->fetch_assoc();
    $donation_no = $donation['donation_no'];
}

?>
<?php include "header.php"; ?>
<div class="container py-5 text-center">

    <svg width="120" height="120" fill="#dc3545" viewBox="0 0 24 24">
        <path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm1 17h-2v-2h2v2zm0-4h-2V7h2v6z" />
    </svg>

    <h2 class="mt-4">Payment Failed</h2>
</div>
<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>Transaction ID</th>
            <td><?php echo $txnid; ?></td>
        </tr>
        <tr>
            <th>Payment Status</th>
            <td style="color: #dc3545; background-color: #f8d7da; border-color: #f5c6cb;"><?php echo $status; ?></td>
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