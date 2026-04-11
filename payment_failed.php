<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger text-center">
            <h3>Payment Failed!</h3>
            <p>Something went wrong with your payment. Please try again.</p>
            <a href="index.php" class="btn btn-primary">Try Again</a>
        </div>
    </div>
</body>
</html>