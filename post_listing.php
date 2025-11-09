<?php
session_start();
require 'connection.php';
$conn = Connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO listings (user_id, title, description, price, category, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdss", $user_id, $title, $description, $price, $category, $image);
    $stmt->execute();
}
?>
