<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/auth_check.php');
include('includes/db_connect.php');

// Validate user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_users.php?msg=Invalid+User+ID");
    exit();
}

$user_id = intval($_GET['id']);

// ====== Delete user ======
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: manage_users.php?msg=User+deleted+successfully");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
