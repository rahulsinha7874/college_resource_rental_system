<?php
 
require 'connection.php';
$conn    = Connect();
$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$subject = $conn->real_escape_string($_POST['subject']);
$message = $conn->real_escape_string($_POST['message']);
$query   = "INSERT into contact_us (name, email, subject, message) VALUES('" . $name . "','" . $email . "','" . $subject . "','" . $message . "')";
$success = $conn->query($query);
 
if (!$success) {
    die("Couldn't enter data: ".$conn->error);
 
}
 
 echo "Thank You For Contacting Us <br>";
 echo "<a href='index.php'>Go to Home Page</a><br>";
$conn->close();
 
?>
