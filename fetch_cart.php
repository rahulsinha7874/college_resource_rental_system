<?php
session_start();
require 'connection.php';

$conn = Connect();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Not logged in"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT * FROM cartt WHERE user_id=? ORDER BY id DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$cartItems = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $total += $row['price'] * $row['quantity'];
}

echo json_encode([
    "status" => "success",
    "items" => $cartItems,
    "total" => $total,
    "count" => count($cartItems)
]);
?>
