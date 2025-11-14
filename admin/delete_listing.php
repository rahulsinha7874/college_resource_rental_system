<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/auth_check.php');
include('includes/db_connect.php');

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_listings.php?msg=Invalid+ID");
    exit();
}

$id = intval($_GET['id']);

// Get Image Path
$stmt = $conn->prepare("SELECT image FROM upload WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();

// Delete DB record
$stmt = $conn->prepare("DELETE FROM upload WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Delete image file
if (!empty($image)) {
    $file = "../uploads/" . $image;
    if (file_exists($file)) {
        unlink($file);
    }
}

header("Location: manage_listings.php?msg=Listing+deleted+successfully");
exit();
?>
