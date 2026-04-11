<?php
session_start();
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get form data
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
    // Generate unique transaction IDs
    $donation_no = "DON" . time() . rand(100, 999);
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    $order_id = "ACRORD" . time() . rand(100, 999);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // ================= INSERT DONOR ================= //
        $stmt = $conn->prepare("
            INSERT INTO donors(name, email, phone, city, state, country, address)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssssss", $name, $email, $phone, $city, $state, $country, $address);
        $stmt->execute();
        $donor_id = $stmt->insert_id;
        
        // ================= INSERT DONATION (PENDING) ================= //
        $stmt2 = $conn->prepare("
            INSERT INTO donations
            (donation_no, donor_id, category_id, amount, payment_status, message, txn_id, donated_at)
            VALUES (?, ?, ?, ?, 'pending', ?, ?, NOW())
        ");
        $stmt2->bind_param("siidss", $donation_no, $donor_id, $category, $amount, $message, $txnid);
        $stmt2->execute();
        $donation_id = $stmt2->insert_id;
        
        // Store data in session for payment processing
        $_SESSION['donation_data'] = [
            'donation_id' => $donation_id,
            'donation_no' => $donation_no,
            'donor_id' => $donor_id,
            'order_id' => $order_id,
            'amount' => $amount,
            'txnid' => $txnid,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'category_id' => $category,
            'campaign_title' => $campaign_title,
            'message' => $message
        ];
        
        $conn->commit();
        
        // Redirect to payment page
        header("Location: payment.php");
        exit;
        
    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}
?>