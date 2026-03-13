<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require  'vendor/autoload.php';

function sendDonationThankYouMail($recipientEmail, $name, $amount, $donation_no, $campaign_title, $website_url)
{

    $mailAddress = 'support@acordi.in';
    $mailPassword = 'D:2xmalVPf';

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.hostinger.in';
        $mail->SMTPAuth = true;
        $mail->Username = $mailAddress;
        $mail->Password = $mailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($mailAddress, 'ACORDI Donation');
        $mail->addAddress($recipientEmail, $name);

        $mail->isHTML(true);
        $mail->Subject = "Thank You For Your Donation";

        $amount = number_format($amount, 2);

        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset='UTF-8'>
        </head>

        <body style='margin:0;background:#f4f7f6;font-family:Arial'>

        <div style='max-width:900px;margin:auto;background:#fff;border-radius:10px;overflow:hidden'>

        <div style='background:linear-gradient(135deg,#1a685b,#051311);color:#fff;padding:30px;text-align:center'>
        <h2 style='margin:0'>Thank You For Your Contribution</h2>
        </div>

        <div style='padding:35px'>

        <p style='font-size:16px'>Dear <strong>{$name}</strong>,</p>

        <p>
        Thank you for supporting our mission. Your generous donation helps us continue helping people and communities in need.
        </p>

        <div style='text-align:center;margin:30px 0'>

        <div style='display:inline-block;padding:18px 40px;
        font-size:24px;
        font-weight:bold;
        background:#fff7e5;
        color:#1a685b;
        border:3px dashed #ffac00;
        border-radius:8px'>

        ₹ {$amount}

        </div>

        </div>

        <div style='background:#f8f9fa;padding:20px;border-radius:6px'>

        <b>Donation Details</b><br><br>

        Donation ID : {$donation_no}<br>
        Campaign : {$campaign_title}<br>
        Date : " . date('d M Y') . "

        </div>

        <p style='margin-top:25px'>
        Your contribution makes a real difference.  
        Thank you for being part of this meaningful journey.
        </p>

        <center>

        <a href='{$website_url}'
        style='display:inline-block;
        margin-top:20px;
        padding:14px 28px;
        background:#1a685b;
        color:#fff;
        text-decoration:none;
        border-radius:6px'>

        Visit Website

        </a>

        </center>

        </div>

        <div style='text-align:center;padding:20px;font-size:12px;background:#f9f9f9;color:#777'>

        © " . date('Y') . " ACORDI Donation Program<br>
        This is an automated message.

        </div>

        </div>

        </body>
        </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {

        return false;
    }
}

function sendContactMessage($recipientEmail, $name, $email, $phone, $subject, $message)
{

    $mailAddress = 'support@acordi.in';
    $mailPassword = 'D:2xmalVPf';

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.hostinger.in';
        $mail->SMTPAuth = true;
        $mail->Username = $mailAddress;
        $mail->Password = $mailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($mailAddress, 'ACORDI Contact');
        $mail->addAddress($recipientEmail, $name);

        $mail->isHTML(true);
        $mail->Subject = "New Contact Message: {$subject}";

        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset='UTF-8'>
        </head>

        <body style='margin:0;background:#f4f7f6;font-family:Arial'>

        <div style='max-width:900px;margin:auto;background:#fff;border-radius:10px;overflow:hidden'>

        <div style='background:linear-gradient(135deg,#1a685b,#051311);color:#fff;padding:30px;text-align:center'>
        <h2 style='margin:0'>New Contact Message</h2>
        </div>

        <div style='padding:35px'>

        <p style='font-size:16px'>Dear <strong>{$name}</strong>,</p>

        <p>
        You have received a new contact message.
        </p>

        <div style='background:#f8f9fa;padding:20px;border-radius:6px'>

        <b>Message Details</b><br><br>

        Name : {$name}<br>
        Email : {$email}<br>
        Phone : {$phone}<br>
        Subject : {$subject}<br>
        Message : {$message}<br>

        </div>

        </div>

        <div style='text-align:center;padding:20px;font-size:12px;background:#f9f9f9;color:#777'>

        © " . date('Y') . " ACORDI Contact Program<br>
        This is an automated message.

        </div>

        </div>

        </body>
        </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
