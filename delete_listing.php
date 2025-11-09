<?php
session_start();
require 'connection.php';
$conn = Connect();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['id'])) {
    $listing_id = intval($_POST['id']); // Ensure it's an integer
    $user_id = $_SESSION['user_id'];

    // Verify the listing belongs to the user
    $check_query = $conn->prepare("SELECT id FROM upload WHERE id = ? AND user_id = ?");
    $check_query->bind_param("ii", $listing_id, $user_id);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows > 0) {
        // Delete listing
        $delete_query = $conn->prepare("DELETE FROM upload WHERE id = ?");
        $delete_query->bind_param("i", $listing_id);

        if ($delete_query->execute()) {
            header("Location: my_listings.php?success=Listing+deleted+successfully");
        } else {
            header("Location: my_listings.php?error=Error+deleting+listing");
        }
    } else {
        header("Location: my_listings.php?error=You+don%27t+have+permission+to+delete+this+listing");
    }
} else {
    header("Location: my_listings.php");
}

$conn->close();
exit();
?>