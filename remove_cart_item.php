<?php
session_start();
require 'connection.php';
$conn = Connect();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_POST['item_id']);

$stmt = $conn->prepare("DELETE FROM cartt WHERE user_id=? AND item_id=?");
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();

echo json_encode(["status" => "success"]);
?>
