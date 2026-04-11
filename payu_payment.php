<?php
session_start();
include "config.php";

if (!isset($_SESSION['donation_data'])) {
    header("Location: index.php");
    exit;
}

$donation = $_SESSION['donation_data'];
// echo "<pre>";
// print_r($donation);
// echo "</pre>";
// die();
// PayU credentials
$MERCHANT_KEY = PAYU_MERCHANT_KEY;
$SALT = PAYU_MERCHANT_SALT;
$PAYU_BASE_URL = PAYU_BASE_URL; // Use live URL for production

// Generate PayU hash
$txnid = $donation['txnid'];
$amount = $donation['amount'];
$productinfo = $donation['campaign_title'];
$firstname = $donation['name'];
$email = $donation['email'];
$phone = $donation['phone'];
// Success & Failure URLs
$surl = PAYU_SUCCESS_URL;
$furl = PAYU_FAILURE_URL;
$udf1 = $donation['donation_id']; // Pass donation ID for reference
$udf2 = $donation['order_id']; // Pass order ID for reference
$udf3 = '';
$udf4 = '';
$udf5 = '';

// Hash generation
$hash = hash('sha512', $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '||||||' . $SALT);

// PayU Test URL
$payu_url = PAYU_BASE_URL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayU Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            cursor: pointer;
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
        <div class="loader-badge">Redirecting to PayU</div>
        <div class="spinner-ring" aria-hidden="true"></div>
        <h1>Please wait while we connect you to payment gateway</h1>
        <p>We are preparing a secure payment page for your donation to <strong><?= htmlspecialchars($donation['campaign_title']) ?></strong>.</p>
        <p>If the payment page does not open automatically, click the button below.</p>
        <button class="fallback-button" id="submitPayUForm">Open PayU</button>
    </div>

    <form action="<?php echo $PAYU_BASE_URL; ?>" method="post" name="payuForm" style="display: none;">
        <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY; ?>" />
        <input type="hidden" name="txnid" value="<?php echo $txnid; ?>" />
        <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
        <input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>" />
        <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
        <input type="hidden" name="email" value="<?php echo $email; ?>" />
        <input type="hidden" name="phone" value="<?php echo $phone; ?>" />
        <input type="hidden" name="surl" value="<?php echo $surl; ?>" />
        <input type="hidden" name="furl" value="<?php echo $furl; ?>" />
        <input type="hidden" name="hash" value="<?php echo $hash; ?>" />
        <input type="hidden" name="udf1" value="<?php echo $donation['donation_id']; ?>" />
        <input type="hidden" name="udf2" value="<?php echo $donation['order_id']; ?>" />
        <input type="hidden" name="udf3" value="<?php echo $udf3; ?>" />
        <input type="hidden" name="udf4" value="<?php echo $udf4; ?>" />
        <input type="hidden" name="udf5" value="<?php echo $udf5; ?>" />
    </form>

    <script>
        function submitPayUForm() {
            try {
                document.payuForm.submit();
            } catch (err) {
                console.error(err);
            }
        }

        document.getElementById('submitPayUForm').addEventListener('click', function(event) {
            event.preventDefault();
            submitPayUForm();
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(submitPayUForm, 600);
        });
    </script>
</body>
</html>