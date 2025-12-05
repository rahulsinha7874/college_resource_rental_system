<?php
session_start();
require "connection.php";
$conn = Connect();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["count" => 0]);
    exit;
}

$user_id = $_SESSION["user_id"];

$q = $conn->prepare("SELECT COUNT(*) as total FROM cartt WHERE user_id=?");
$q->bind_param("i", $user_id);
$q->execute();
$res = $q->get_result()->fetch_assoc();

echo json_encode(["count" => $res["total"]]);
?>
