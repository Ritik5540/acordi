<?php
include 'config.php';
include 'mail-send.php';


if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Process the form data (e.g., save to database, send email, etc.)
    // Example: Save to database
    $stmt = "INSERT INTO contact_enquiries (name, email, phone_no, subject, message) VALUES ('$name', '$email', '$phone', '$subject', '$message')";
    $conn->query($stmt);

    // Mail sending logic can be added here if needed
    sendContactMessage('kfs211124@gmail.com', $name, $email, $phone, $subject, $message);

    // Redirect back to contact page with success parameter
    header("Location: contact.php?success=true");
    exit();
}
