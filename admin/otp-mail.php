<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendOTPEmail($recipientEmail, $name, $otp)
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
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($mailAddress, 'ACORDI LOGIN');
        $mail->addAddress($recipientEmail);

        $mail->isHTML(true);
        $mail->Subject = "AGRICULTURAL CONSULTANCY & RURAL DEVELOPMENT INSTITUTE LOGIN OTP";

        $mail->Body = '<!DOCTYPE html>
            <html>
            <head>
            <meta charset="UTF-8">
            <title>ACORDI Login OTP</title>

            <style>

            body{
            margin:0;
            padding:0;
            background:#f4f7f6;
            font-family:Arial, Helvetica, sans-serif;
            }

            .wrapper{
            width:100%;
            padding:30px 15px;
            }

            .container{
            max-width:600px;
            margin:auto;
            background:#ffffff;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,0.08);
            }

            .header{
            background: linear-gradient(135deg,#1a685b,#051311);
            color:#ffffff;
            text-align:center;
            padding:28px 20px;
            }

            .header h1{
            margin:0;
            font-size:22px;
            letter-spacing:0.5px;
            }

            .content{
            padding:30px 25px;
            color:#333;
            font-size:15px;
            line-height:1.6;
            }

            .greeting{
            font-size:16px;
            margin-bottom:10px;
            }

            .otp-box{
            text-align:center;
            margin:30px 0;
            }

            .otp{
            display:inline-block;
            padding:16px 32px;
            font-size:30px;
            font-weight:bold;
            letter-spacing:5px;
            background:#fff7e5;
            color:#1a685b;
            border:2px dashed #ffac00;
            border-radius:8px;
            }

            .note{
            background:#fff3cd;
            padding:14px 16px;
            border-radius:6px;
            font-size:13px;
            color:#8a6d3b;
            margin-top:15px;
            }

            .footer{
            text-align:center;
            font-size:12px;
            color:#888;
            padding:20px;
            background:#f9f9f9;
            }

            .footer a{
            color:#1a685b;
            text-decoration:none;
            font-weight:bold;
            }

            </style>
            </head>

            <body>

            <div class="wrapper">
            <div class="container">

            <div class="header">
            <h1>ACORDI Secure Login</h1>
            </div>

            <div class="content">

            <p class="greeting">Hello ' . htmlspecialchars($name) . ',</p>

            <p>
            We received a request to log in to your ACORDI account.  
            Use the One-Time Password (OTP) below to continue:
            </p>

            <div class="otp-box">
            <div class="otp">' . htmlspecialchars($otp) . '</div>
            </div>

            <p>
            This OTP is valid for <strong>5 minutes</strong>.  
            For your security, do not share this code with anyone.
            </p>

            <div class="note">
            If you didn’t try to log in, you can safely ignore this email.  
            Your account remains secure.
            </div>

            <p style="margin-top:25px;">
            Thanks,<br>
            <strong>ACORDI Security Team</strong>
            </p>

            </div>

            <div class="footer">
            © 2026 ACORDI Manufacturing<br>
            This is an automated message, please do not reply.
            </div>

            </div>
            </div>

            </body>
            </html>';

        $mail->send();
    } catch (Exception $e) {
    }
}
