<?php
require '../connection.php';
$conn = Connect();

$id = $_GET['id'];

$conn->query("UPDATE upload SET status='rejected' WHERE id=$id");
header("Location: dashboard.php?msg=rejected");
?>
