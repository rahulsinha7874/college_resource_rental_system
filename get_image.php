<?php
require 'connection.php';
$conn = Connect();

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT image FROM listings WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($imageData);
    $stmt->fetch();
    header("Content-Type: image/jpeg"); // you can improve later to detect MIME
    echo $imageData;
} else {
    echo "No image found.";
}
$stmt->close();
?>
