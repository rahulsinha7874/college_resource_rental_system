<?php
require 'connection.php';
$conn = Connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $user_id = $_SESSION['user_id']; // assuming login
    $status = 'active';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $mimeType = $_FILES['image']['type'];

        $stmt = $conn->prepare("INSERT INTO listings (user_id, title, description, price, category, image, mime, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdssss", $user_id, $title, $description, $price, $category, $null, $mimeType, $status);
        $stmt->send_long_data(5, $imageData);
        $stmt->execute();
        $stmt->close();

        echo "Listing uploaded successfully!";
    } else {
        echo "Error uploading image.";
    }
}
?>
