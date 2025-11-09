<?php
// ✅ Start session only if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'connection.php';
$conn = Connect();

// ✅ Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to upload a listing. <a href='login.php'>Login</a>");
}

$user_id     = $_SESSION['user_id'];
$title       = $conn->real_escape_string($_POST['title']);
$category    = $conn->real_escape_string($_POST['category']);
$description = $conn->real_escape_string($_POST['description']);
$price       = $conn->real_escape_string($_POST['price']);
$image       = $_FILES['image']['name'];
$contact     = $conn->real_escape_string($_POST['contact']);

// ✅ Insert into database
$query = "INSERT INTO upload (title, category, description, price, image, contact, user_id) 
          VALUES ('$title', '$category', '$description', '$price', '$image', '$contact', '$user_id')";

$success = $conn->query($query);

if (!$success) {
    die("Couldn't enter data: " . $conn->error);
}

// ✅ Close the connection before redirect
$conn->close();

// ✅ Redirect to upload page with a success flag
header("Location: upload.php?status=success");
exit(); // 🔑 Stop further script execution
?>
