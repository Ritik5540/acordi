<?php

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'acordi'; // your database name

    define('MODE', 'TEST'); // Change to 'LIVE' for production
    define('GATEWAY', 'PAYU');
    define('PAYU_MERCHANT_KEY', 'o2qRKy');
    define('PAYU_MERCHANT_SALT', 'uK6BdtbsbFsa9EIEyXFbP54wMd4uAo3t');
    define('PAYU_BASE_URL', 'https://test.payu.in/_payment'); // For sandbox
    define('PAYU_SUCCESS_URL', 'http://localhost/acordi/success.php');
    define('PAYU_FAILURE_URL', 'http://localhost/acordi/failure.php');

} else {
    $host = "localhost";
    $user = "u409719797_acordi";
    $pass = "X5807?xfpg+";
    $db   = "u409719797_acordi"; // your database name

    define('MODE', 'LIVE');
    define('GATEWAY', 'PAYU');
    define('PAYU_MERCHANT_KEY', 'cD2Omq');
    define('PAYU_MERCHANT_SALT', 'ujPjz13oePBUqEKKQle16XyM98jeb4E7');
    define('PAYU_BASE_URL', 'https://secure.payu.in/_payment'); // For production
    define('PAYU_SUCCESS_URL', 'https://acordi.in/success.php');
    define('PAYU_FAILURE_URL', 'https://acordi.in/failure.php');
}

$conn = new mysqli($host, $user, $pass, $db);
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);


if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional but recommended
$conn->set_charset("utf8mb4");
    