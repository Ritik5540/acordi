<?php
include "config.php";
require 'mail-send.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$amount = isset($_POST['preset']) ? (float)$_POST['preset'] : (isset($_POST['amount']) ? (float)$_POST['amount'] : 0);
$category = $_POST['category_id'];
$message = $_POST['message'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$campaign_title = $_POST['campaign_title'];
$website_url = $_POST['website_url'];

$donation_no = "DON" . time();


$stmt = $conn->prepare("
INSERT INTO donors(name,email,phone,city,state,country,address)
VALUES (?,?,?,?,?,?,?)
");

$stmt->bind_param(
    "sssssss",
    $name,
    $email,
    $phone,
    $city,
    $state,
    $country,
    $address
);

$stmt->execute();

$donor_id = $stmt->insert_id;


$stmt2 = $conn->prepare("INSERT INTO donations
(donation_no,donor_id,category_id,amount,payment_status,message,donated_at)
VALUES (?,?,?,?, 'success', ?, NOW())");

$stmt2->bind_param("siids", $donation_no, $donor_id, $category, $amount, $message);
$stmt2->execute();

$donation_id = $stmt2->insert_id;

sendDonationThankYouMail(
    $email,
    $name,
    $amount,
    $donation_no,
    $campaign_title,
    $website_url
);

header("Location: thank-you.php?donation=" . $donation_id);
exit;
