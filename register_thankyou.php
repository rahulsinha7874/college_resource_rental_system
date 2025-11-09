<?php
require 'connection.php';
$conn = Connect();

// Get form data
$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$email = $conn->real_escape_string($_POST['email']);
$password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
$college = $conn->real_escape_string($_POST['college']);
$department = $conn->real_escape_string($_POST['department']);

// Check if email already exists
$check_query = "SELECT id FROM users WHERE email = '$email'";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    header("Location: register.php?error=Email+already+exists.+Please+try+another+email.");
    exit();
}

// Insert new user
$query = "INSERT INTO users (first_name, last_name, email, password, college, department) 
          VALUES('$first_name', '$last_name', '$email', '$password', '$college', '$department')";
$success = $conn->query($query);

if (!$success) {
    header("Location: register.php?error=Registration+failed.+Please+try+again.");
    exit();
}

// Redirect to login page with success message
$conn->close();
header("Location: login.php?success=Registration+successful!+Please+login+with+your+credentials.");
exit();
?>