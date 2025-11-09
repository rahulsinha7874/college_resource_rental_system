<?php
session_start();
require 'connection.php';
$conn = Connect();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = intval($_GET['id']);

$conn->query("DELETE FROM cartt WHERE id=$id AND user_id=$user_id");
header("Location: cart.php");
exit();
?>
