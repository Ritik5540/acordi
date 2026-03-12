<?php
// logout.php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
require_once '../config.php'; // Your database configuration

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Function to log logout activity
function logLogoutActivity($conn, $user_id, $user_email = '')
{
    if ($user_id) {
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        // Get user email if not provided
        if (empty($user_email)) {
            $sql = "SELECT email FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $row = $result->fetch_assoc()) {
                $user_email = $row['email'];
            }
            $stmt->close();
        }

        // Insert into login_logs
        $sql = "INSERT INTO login_logs (user_id, email, action, ip_address, user_agent, status, details) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $action = "LOGOUT";
        $status = "success";
        $details = "User logged out successfully";
        $stmt->bind_param("issssss", $user_id, $user_email, $action, $ip_address, $user_agent, $status, $details);
        $stmt->execute();
        $stmt->close();
    }
}

// Get user information before destroying session
$user_id = $_SESSION['user_id'] ?? null;
$user_email = $_SESSION['user_email'] ?? '';
$user_name = $_SESSION['user_name'] ?? '';

// Log the logout activity
if (isset($conn) && $user_id) {
    logLogoutActivity($conn, $user_id, $user_email);

    // Update last_logout time if you have that column
    if (isset($_SESSION['login_time'])) {
        $logout_time = time();
        $session_duration = $logout_time - $_SESSION['login_time'];

        // Optional: Update session duration in database
        $sql = "UPDATE users SET last_logout = NOW(), session_duration = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $session_duration, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Clear remember token if exists
if (isset($_COOKIE['remember_token']) && $user_id) {
    $sql = "UPDATE users SET remember_token = NULL WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Clear the cookie
    setcookie('remember_token', '', time() - 3600, '/');
}

// Store session data for post-logout message if needed
$logout_message = "You have been successfully logged out, " . htmlspecialchars($user_name) . "!";

// Clear all session variables
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Clear any other cookies
setcookie('PHPSESSID', '', time() - 3600, '/');

// Check if there's a redirect parameter
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '/acordi/admin';
$timeout = isset($_GET['timeout']) ? true : false;

// If logout was due to timeout, add a message
if ($timeout) {
    $redirect .= '?timeout=1';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - CMS Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(145deg, #1a685b 0%, #0f3d36 45%, #ffac00fa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .logout-container {
            max-width: 500px;
            width: 100%;
            background: #ffffff;
            border-radius: 10px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 25px 50px -8px rgba(5, 19, 17, 0.5), 0 10px 20px -5px rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.5s ease;
            border: 1px solid rgba(255, 172, 0, 0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logout-icon {
            font-size: 80px;
            color: #ffac00;
            /* primary accent */
            margin-bottom: 24px;
            animation: spin 0.8s ease;
            filter: drop-shadow(0 8px 12px rgba(255, 172, 0, 0.3));
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg) scale(0.9);
                opacity: 0.6;
            }

            100% {
                transform: rotate(360deg) scale(1);
                opacity: 1;
            }
        }

        .logout-message {
            margin-bottom: 30px;
        }

        .logout-message h1 {
            font-size: 32px;
            color: #1a685b;
            /* deep teal from palette */
            margin-bottom: 15px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .logout-message p {
            color: #2f4f4b;
            /* soft dark teal (inspired by #051311 but lighter for text) */
            font-size: 16px;
            line-height: 1.6;
            font-weight: 400;
        }

        .logout-info {
            background: #f2f7f6;
            /* very light mint (near #1a685b tint) */
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
            border-left: 5px solid #ffac00;
            box-shadow: inset 0 1px 4px rgba(26, 104, 91, 0.1);
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #cbdad6;
            /* soft border using #1a685b tint */
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #1a685b;
            /* brand teal */
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-value {
            color: #051311;
            /* almost black (darkest) */
            font-size: 15px;
            font-weight: 700;
            background: #fff6e5;
            /* light touch of accent */
            padding: 4px 12px;
            border-radius: 40px;
            border: 1px solid #ffac0066;
        }

        .progress-bar {
            height: 6px;
            background: #d9e5e2;
            /* neutral with hint of teal */
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: inset 0 1px 3px #0000001a;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1a685b 0%, #ffac00 90%, #ffac00 100%);
            width: 0%;
            animation: progress 3s linear forwards;
            border-radius: 12px;
        }

        @keyframes progress {
            from {
                width: 0%;
            }

            to {
                width: 100%;
            }
        }

        .redirect-message {
            color: #1a685b;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 20px;
            background: rgba(255, 172, 0, 0.08);
            padding: 10px 16px;
            border-radius: 60px;
            display: inline-block;
        }

        .countdown {
            font-weight: 700;
            color: #ffac00;
            background: #051311;
            padding: 3px 12px;
            border-radius: 40px;
            margin-left: 6px;
            font-size: 16px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 28px;
        }

        .btn {
            flex: 1;
            padding: 14px 8px;
            border-radius: 60px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s ease;
            border: 2px solid transparent;
            letter-spacing: 0.3px;
        }

        .btn-primary {
            background: #1a685b;
            /* solid teal */
            color: #ffffff;
            border: none;
            box-shadow: 0 8px 18px -8px #1a685b;
        }

        .btn-primary i {
            color: #ffac00;
            /* accent icon pop */
        }

        .btn-primary:hover {
            background: #0f4f44;
            /* darker teal */
            transform: translateY(-3px);
            box-shadow: 0 18px 25px -10px #1a685b;
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid #ffac00;
            color: #051311;
        }

        .btn-secondary i {
            color: #1a685b;
        }

        .btn-secondary:hover {
            background: #ffac00;
            color: #051311;
            border-color: #ffac00;
            transform: translateY(-2px);
            box-shadow: 0 12px 22px -12px #ffac00;
        }

        .btn-secondary:hover i {
            color: #051311;
        }

        .security-tips {
            margin-top: 32px;
            padding: 18px 16px;
            background: #eef6f4;
            /* very light teal base */
            border-radius: 24px;
            border: 1px solid #ffac00;
            text-align: left;
            box-shadow: 0 6px 0 #0513110d;
        }

        .security-tips h4 {
            color: #1a685b;
            /* teal heading */
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
        }

        .security-tips h4 i {
            color: #ffac00;
            font-size: 18px;
        }

        .security-tips ul {
            list-style: none;
            padding-left: 4px;
        }

        .security-tips li {
            color: #051311;
            /* darkest for contrast */
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.8);
            padding: 6px 12px;
            border-radius: 40px;
        }

        .security-tips li i {
            font-size: 12px;
            color: #ffac00;
            background: #1a685b;
            border-radius: 50%;
            padding: 4px;
        }

        /* extra micro brand touches */
        .info-value i,
        .info-label i {
            margin-right: 4px;
            color: #ffac00;
        }

        .logout-icon i {
            text-shadow: 0 2px 10px #ffac00;
        }

        @media (max-width: 576px) {
            .logout-container {
                padding: 30px 18px;
            }

            .logout-icon {
                font-size: 62px;
            }

            .logout-message h1 {
                font-size: 26px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .info-value {
                font-size: 13px;
                padding: 4px 10px;
            }
        }
    </style>
</head>

<body>
    <div class="logout-container">
        <div class="logout-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>

        <div class="logout-message">
            <h1>Logging Out</h1>
            <p><?php echo $logout_message; ?></p>
            <?php if ($timeout): ?>
                <p style="color: #e74c3c; margin-top: 10px;">
                    <i class="fas fa-clock"></i> Session expired due to inactivity
                </p>
            <?php endif; ?>
        </div>

        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>

        <div class="redirect-message">
            You will be redirected to login page in <span class="countdown" id="countdown">3</span> seconds...
        </div>

        <div class="action-buttons">
            <a href="/acordi/admin" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Login Again
            </a>

            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-home"></i>
                Go to Homepage
            </a>
        </div>

        <div class="security-tips">
            <h4><i class="fas fa-shield-alt"></i> Security Tips</h4>
            <ul>
                <li><i class="fas fa-circle"></i> Always log out from public computers</li>
                <li><i class="fas fa-circle"></i> Keep your password confidential</li>
                <li><i class="fas fa-circle"></i> Enable two-factor authentication</li>
            </ul>
        </div>
    </div>

    <script>
        // Countdown timer
        let countdown = 3;
        const countdownElement = document.getElementById('countdown');
        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                // Redirect to login page
                window.location.href = '<?php echo htmlspecialchars($redirect); ?>';
            }
        }, 1000);

        // Auto-redirect after 3 seconds
        setTimeout(() => {
            window.location.href = '<?php echo htmlspecialchars($redirect); ?>';
        }, 3000);

        // Add click event to login button to cancel auto-redirect
        document.querySelector('.btn-primary').addEventListener('click', function(e) {
            clearInterval(countdownInterval);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Escape key to stay on page
            if (e.key === 'Escape') {
                clearInterval(countdownInterval);
                countdownElement.textContent = 'Cancelled';
                document.querySelector('.redirect-message').innerHTML =
                    '<i class="fas fa-info-circle"></i> Auto-redirect cancelled. Click Login to continue.';
            }

            // Enter key to login immediately
            if (e.key === 'Enter') {
                e.preventDefault();
                window.location.href = '/admin';
            }
        });

        // Add some visual effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate security tips
            const tips = document.querySelectorAll('.security-tips li');
            tips.forEach((tip, index) => {
                tip.style.opacity = '0';
                tip.style.transform = 'translateX(-10px)';

                setTimeout(() => {
                    tip.style.transition = 'all 0.5s ease';
                    tip.style.opacity = '1';
                    tip.style.transform = 'translateX(0)';
                }, 100 * index);
            });
        });
    </script>
</body>

</html>