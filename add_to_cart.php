<?php
session_start();
require 'connection.php';  // DB connection

$conn = Connect();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login required']);
    exit();
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_POST['id']);
$name = trim($_POST['name']);
$description = $_POST['description'] ?? '';
$price = floatval($_POST['price']);
$quantity = intval($_POST['quantity'] ?? 1);

// Check if item already exists
$stmt = $conn->prepare("SELECT quantity FROM cartt WHERE user_id=? AND item_id=?");
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Item exists -> update qty
    $update = $conn->prepare("UPDATE cartt SET quantity = quantity + ?, updated_at = NOW() WHERE user_id=? AND item_id=?");
    $update->bind_param("iii", $quantity, $user_id, $item_id);
    $update->execute();
} else {
    // Insert new row
    $insert = $conn->prepare("INSERT INTO cartt (user_id, item_id, name, description, price, quantity) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("iissdi", $user_id, $item_id, $name, $description, $price, $quantity);
    $insert->execute();
}

// Get updated cart count
$countQuery = $conn->prepare("SELECT COUNT(*) AS total FROM cartt WHERE user_id=?");
$countQuery->bind_param("i", $user_id);
$countQuery->execute();
$countResult = $countQuery->get_result();
$countRow = $countResult->fetch_assoc();
$cartCount = $countRow['total'];

// Update navbar count in session
$_SESSION['cart_count'] = $cartCount;

// Return success + updated count
echo json_encode([
    'status' => 'success',
    'message' => 'Added to cart',
    'cart_count' => $cartCount
]);

?>
