<?php

require 'connection.php';
$conn = Connect();

$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$subject = $conn->real_escape_string($_POST['subject']);
$message = $conn->real_escape_string($_POST['message']);

$query = "INSERT INTO contact_us (name, email, subject, message) 
VALUES ('$name', '$email', '$subject', '$message')";

$success = $conn->query($query);

if (!$success) {
    // If error, redirect with error flag
    header("Location: contact.php?error=1");
    exit();
}

// Redirect back to contact page with success message
header("Location: contact.php?success=1");
exit();

?>
