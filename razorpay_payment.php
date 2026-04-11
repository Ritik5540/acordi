<?php
require('vendor/autoload.php');
session_start();
include "config.php";

if (!isset($_SESSION['donation_data'])) {
    header("Location: index.php");
    exit;
}

$donation = $_SESSION['donation_data'];

// Razorpay API credentials
$RAZORPAY_KEY_ID = RAZORPAY_KEY_ID;
$RAZORPAY_KEY_SECRET = RAZORPAY_KEY_SECRET;

// require_once('razorpay-php/Razorpay.php'); // Download Razorpay PHP SDK
use Razorpay\Api\Api;

$api = new Api($RAZORPAY_KEY_ID, $RAZORPAY_KEY_SECRET);

// Create Razorpay Order
$orderData = [
    'receipt' => $donation['donation_no'],
    'amount' => $donation['amount'] * 100, // Amount in paise
    'currency' => 'INR',
    'payment_capture' => 1
];

$razorpayOrder = $api->order->create($orderData);
$razorpayOrderId = $razorpayOrder['id'];

// Update order_id in database
$stmt = $conn->prepare("UPDATE donations SET order_id = ?, razorpay_order_id = ? WHERE id = ?");
$stmt->bind_param("ssi", $razorpayOrderId, $razorpayOrderId, $donation['donation_id']);
$stmt->execute();

$_SESSION['razorpay_order_id'] = $razorpayOrderId;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Razorpay Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        :root {
            --primary-yellow: #FFD700;
            --secondary-green: #32CD32;
            --accent-green: #1D6A2A;
            --bg: #F7FFEB;
            --card: #FFFFFF;
            --radius: 20px;
            --shadow: 0 18px 40px rgba(50, 205, 50, 0.15);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(180deg, #F8FFE4 0%, #FFF8D6 55%, #F5F7E9 100%);
            color: #26481A;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .loader-card {
            width: min(520px, 100%);
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(50, 205, 50, 0.16);
            padding: 2rem 1.8rem;
            text-align: center;
        }

        .loader-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--primary-yellow), var(--secondary-green));
            color: #fff;
            padding: 0.6rem 1rem;
            border-radius: 999px;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        h1 {
            margin: 0;
            font-size: 1.6rem;
            line-height: 1.25;
            margin-bottom: 0.75rem;
        }

        p {
            margin: 0.6rem 0 1.4rem;
            color: #4A5B3E;
            font-size: 0.98rem;
            line-height: 1.6;
        }

        .spinner-ring {
            width: 84px;
            height: 84px;
            border: 10px solid rgba(50, 205, 50, 0.18);
            border-top-color: var(--primary-yellow);
            border-radius: 50%;
            margin: 0 auto 1.2rem;
            animation: spin 1.05s linear infinite;
        }

        .fallback-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.95rem 1.6rem;
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, var(--primary-yellow), var(--secondary-green));
            color: #fff;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 14px 25px rgba(50, 205, 50, 0.2);
            font-size: 0.98rem;
        }

        .fallback-button:hover {
            transform: translateY(-2px);
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            .loader-card {
                padding: 1.6rem 1.2rem;
            }
            h1 {
                font-size: 1.35rem;
            }
            .spinner-ring {
                width: 70px;
                height: 70px;
                border-width: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="loader-card">
        <div class="loader-badge">Redirecting to Razorpay</div>
        <div class="spinner-ring" aria-hidden="true"></div>
        <h1>Please wait while we connect you to payment gateway</h1>
        <p>We are preparing a secure payment page for your donation to <strong><?= htmlspecialchars($donation['campaign_title']) ?></strong>.</p>
        <p>If the payment window does not open automatically, click the button below.</p>
        <a href="#" class="fallback-button" id="openCheckoutBtn">Open Razorpay</a>
    </div>

    <script>
        var options = {
            "key": "<?php echo $RAZORPAY_KEY_ID; ?>",
            "amount": "<?php echo $donation['amount'] * 100; ?>",
            "currency": "INR",
            "name": "Donation Platform",
            "description": "<?php echo addslashes($donation['campaign_title']); ?>",
            "order_id": "<?php echo $razorpayOrderId; ?>",
            "handler": function (response) {
                window.location.href = "payment_success.php?payment_id=" + response.razorpay_payment_id + "&order_id=" + response.razorpay_order_id;
            },
            "prefill": {
                "name": "<?php echo addslashes($donation['name']); ?>",
                "email": "<?php echo addslashes($donation['email']); ?>",
                "contact": "<?php echo addslashes($donation['phone']); ?>"
            },
            "theme": {
                "color": "#1a685b"
            },
            "modal": {
                "ondismiss": function() {
                    window.location.href = "payment.php";
                }
            }
        };

        var rzp = new Razorpay(options);
        function openCheckout() {
            try {
                rzp.open();
            } catch (err) {
                console.error(err);
            }
        }

        document.getElementById('openCheckoutBtn').addEventListener('click', function(event) {
            event.preventDefault();
            openCheckout();
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(openCheckout, 600);
        });
    </script>
</body>
</html>