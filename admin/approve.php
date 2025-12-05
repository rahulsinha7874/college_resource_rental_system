<?php
require '../connection.php';
$conn = Connect();

$id = $_GET['id'];

$conn->query("UPDATE upload SET status='approved' WHERE id=$id");
header("Location: dashboard.php?msg=approved");
?>
