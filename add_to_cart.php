<?php
session_start();
require 'connection.php';  // your DB connection

$conn = Connect();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login required']);
    exit();
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_POST['id']);
$name = $_POST['name'];
$description = $_POST['description'] ?? '';
$price = floatval($_POST['price']);
$quantity = intval($_POST['quantity'] ?? 1);

// check if item already in cartt
$stmt = $conn->prepare("SELECT * FROM cartt WHERE user_id=? AND item_id=?");
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // update qty
    $update = $conn->prepare("UPDATE cartt SET quantity = quantity + ? WHERE user_id=? AND item_id=?");
    $update->bind_param("iii", $quantity, $user_id, $item_id);
    $update->execute();
} else {
    // insert new row
    $insert = $conn->prepare("INSERT INTO cartt (user_id, item_id, name, description, price, quantity) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("iissdi", $user_id, $item_id, $name, $description, $price, $quantity);
    $insert->execute();
}

echo json_encode(['status' => 'success']);
