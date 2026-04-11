<?php
session_start();
include "config.php";

// Check if donation data exists
if (!isset($_SESSION['donation_data'])) {
    header("Location: index.php");
    exit;
}

$donation = $_SESSION['donation_data'];
?>

<?php include "header.php"; ?>

<style>
:root {
    --primary-yellow: #FFD700;
    --secondary-green: #32CD32;
    --accent-green: #1E6B2E;
    --light-bg: #F9FFE3;
    --card-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    --border-radius: 20px;
}

body {
    background: linear-gradient(180deg, #F9FFE3 0%, #FFF9D9 55%, #F7F3E9 100%);
    font-family: 'Open Sans', sans-serif;
}

.payment-container {
    max-width: 980px;
    margin: 1.5rem auto;
    padding: 0 1rem 2rem;
}

.page-header-card {
    background: #FFFFFF;
    border-radius: var(--border-radius);
    border: 1px solid rgba(50, 205, 50, 0.18);
    box-shadow: var(--card-shadow);
    padding: 1.5rem 1.5rem 1.2rem;
    margin-bottom: 1.5rem;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 1rem;
    align-items: center;
}

.page-header-card h1 {
    margin: 0;
    font-size: 1.75rem;
    color: var(--accent-green);
    line-height: 1.2;
}

.page-header-card .page-note {
    color: #5A5A5A;
    font-size: 0.96rem;
    max-width: 620px;
}

.summary-pill {
    background: linear-gradient(135deg, var(--primary-yellow), var(--secondary-green));
    color: #fff;
    border-radius: 999px;
    padding: 0.85rem 1.3rem;
    font-weight: 700;
    font-size: 1rem;
    box-shadow: 0 10px 20px rgba(50, 205, 50, 0.18);
}

.donation-summary-card {
    background: linear-gradient(180deg, rgba(255,255,255,0.95) 0%, #F7FFE8 100%);
    border: 1px solid rgba(50, 205, 50, 0.22);
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.donation-summary-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 70px;
    height: 5px;
    background: linear-gradient(90deg, var(--primary-yellow), var(--secondary-green));
    border-radius: 999px;
}

.summary-title {
    color: var(--accent-green);
    font-weight: 700;
    margin-bottom: 1.2rem;
    font-size: 1.5rem;
    text-align: center;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.9rem 1.5rem;
}

.summary-item {
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid rgba(50, 205, 50, 0.14);
    border-radius: 14px;
    padding: 0.95rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
}

.summary-label {
    font-weight: 600;
    color: #3B5F3A;
    font-size: 0.95rem;
}

.summary-value {
    color: var(--accent-green);
    font-weight: 700;
    text-align: right;
    font-size: 0.95rem;
}

.gateway-section {
    text-align: center;
    margin-bottom: 1rem;
}

.gateway-title {
    color: var(--accent-green);
    font-size: 1.7rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.gateway-subtitle {
    color: #5A5A5A;
    margin-bottom: 1.8rem;
    font-size: 0.98rem;
}

.payment-gateways {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1rem;
    margin-bottom: 1.75rem;
}

.payment-card {
    background: #fff;
    border: 1px solid rgba(50, 205, 50, 0.16);
    border-radius: 18px;
    padding: 1.4rem 1.2rem;
    text-align: left;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.06);
    position: relative;
}

.payment-card.selected {
    border-color: var(--primary-yellow);
    box-shadow: 0 12px 30px rgba(50, 205, 50, 0.18);
    transform: translateY(-2px);
    background: #0dcaf040;
}

.payment-card:hover {
    transform: translateY(-2px);
    border-color: rgba(50, 205, 50, 0.5);
}

.payment-card .payment-icon {
    font-size: 2.4rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: rgba(50, 205, 50, 0.08);
    margin-bottom: 1rem;
}

.payment-card h4 {
    color: var(--accent-green);
    font-weight: 700;
    margin-bottom: 0.45rem;
    font-size: 1.2rem;
}

.payment-card p {
    color: #5A5A5A;
    margin-bottom: 1rem;
    font-size: 0.95rem;
    line-height: 1.4;
}

.gateway-logo {
    max-height: 36px;
    opacity: 0.88;
    transition: opacity 0.25s ease;
}

.payment-card:hover .gateway-logo {
    opacity: 1;
}

.pay-button {
    background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--secondary-green) 100%);
    border: none;
    border-radius: 999px;
    padding: 0.95rem 2.3rem;
    font-size: 1.05rem;
    font-weight: 700;
    color: white;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    box-shadow: 0 10px 20px rgba(50, 205, 50, 0.25);
    width: min(100%, 320px);
}

.pay-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(50, 205, 50, 0.28);
}

.pay-button:disabled {
    background: #CEC8B8;
    cursor: not-allowed;
    box-shadow: none;
}

@media (max-width: 768px) {
    .page-header-card {
        flex-direction: column;
        align-items: flex-start;
    }
    .summary-grid {
        grid-template-columns: 1fr;
    }
    .payment-gateways {
        grid-template-columns: 1fr;
    }
    .donation-summary-card {
        padding: 1.2rem;
    }
}

@media (max-width: 520px) {
    .payment-container {
        padding: 0 0.75rem 1.5rem;
    }
    .page-header-card h1 {
        font-size: 1.5rem;
    }
    .gateway-title {
        font-size: 1.45rem;
    }
    .gateway-subtitle {
        font-size: 0.94rem;
    }
    .payment-card {
        padding: 1rem;
    }
    .pay-button {
        width: 100%;
    }
}
</style>

<div class="payment-container">
    <div class="page-header-card">
        <div>
            <p class="eyebrow" style="margin:0; color: #3E6C35; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; font-size:0.8rem;">Donation Checkout</p>
            <h1>Confirm your donation and pay securely</h1>
            <p class="page-note">Choose the gateway you trust, then continue to complete your donation with a fast and secure payment flow.</p>
        </div>
        <div class="summary-pill">₹<?= number_format($donation['amount'], 2) ?> Total</div>
    </div>

    <div class="donation-summary-card">
        <h2 class="summary-title">Donation Summary</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="summary-label">Donation No</span>
                <span class="summary-value"><?= htmlspecialchars($donation['donation_no']) ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Order ID</span>
                <span class="summary-value"><?= htmlspecialchars($donation['order_id']) ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Campaign</span>
                <span class="summary-value"><?= htmlspecialchars($donation['campaign_title']) ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Amount</span>
                <span class="summary-value">₹<?= number_format($donation['amount'], 2) ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Name</span>
                <span class="summary-value"><?= htmlspecialchars($donation['name']) ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Email</span>
                <span class="summary-value"><?= htmlspecialchars($donation['email']) ?></span>
            </div>
        </div>
    </div>

    <div class="gateway-section">
        <h2 class="gateway-title">Select Your Payment Gateway</h2>
        <p class="gateway-subtitle">Tap a gateway below and continue with the payment method of your choice.</p>
        <form method="POST" action="process_payment.php" id="paymentForm">
            <input type="hidden" name="gateway" id="selectedGateway">
            <div class="payment-gateways">
                <div class="payment-card" data-gateway="razorpay">
                    <span class="payment-icon">💳</span>
                    <h4>Razorpay</h4>
                    <p>Credit/Debit Card, UPI, NetBanking and Wallet payments.</p>
                    <img src="https://razorpay.com/assets/razorpay-glyph.svg" alt="Razorpay" class="gateway-logo">
                </div>
                <div class="payment-card" data-gateway="payu">
                    <span class="payment-icon">🏦</span>
                    <h4>PayU</h4>
                    <p>Trusted payments through cards, UPI and net banking.</p>
                    <img src="https://devguide.payu.in/website-assets/uploads/2021/12/new-payu-logo.svg" alt="PayU" class="gateway-logo">
                </div>
            </div>
            <button type="submit" class="pay-button" id="payNowBtn" disabled>Proceed to Pay</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.payment-card');
    const payBtn = document.getElementById('payNowBtn');
    const gatewayInput = document.getElementById('selectedGateway');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            cards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            gatewayInput.value = this.getAttribute('data-gateway');
            payBtn.disabled = false;
            payBtn.style.animation = 'pulse 0.45s ease-in-out';
            setTimeout(() => payBtn.style.animation = '', 500);
        });
    });

    const style = document.createElement('style');
    style.textContent = `@keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.04); } 100% { transform: scale(1); } }`;
    document.head.appendChild(style);
});
</script>

<?php include "footer.php"; ?>