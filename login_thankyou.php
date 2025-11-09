<?php
require 'connection.php';
$conn = Connect();

// Get form data
$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['password']);

// Check if user exists
$query = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    header("Location: login.php?error=Invalid+email+or+password.");
    exit();
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    header("Location: login.php?error=Invalid+email+or+password.");
    exit();
}

// Start session and set session variables
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
$_SESSION['user_college'] = $user['college'];
$_SESSION['user_department'] = $user['department'];

// Redirect to home page
$conn->close();
header("Location: index.php");
exit();
?>