<?php
require 'connection.php';
session_start();
$conn = Connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $contact = $_POST['contact'];
    $user_id = $_SESSION['user_id']; // assuming user is logged in

    // Folder to store images
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Check if file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Validate file type
        if (in_array($fileExt, $allowedTypes)) {
            // Create unique name to avoid collisions
            $newFileName = time() . "_" . $fileName;
            $targetPath = $uploadDir . $newFileName;

            // Move file to uploads folder
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Save to database
                $sql = "INSERT INTO upload (user_id, title, category, description, price, image, contact)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isssdss", $user_id, $title, $category, $description, $price, $targetPath, $contact);

                if ($stmt->execute()) {
                    echo "<script>alert('Listing uploaded successfully!'); window.location.href='my_listings.php';</script>";
                } else {
                    echo "❌ Database error: " . $conn->error;
                }
                $stmt->close();
            } else {
                echo "❌ Error moving uploaded file.";
            }
        } else {
            echo "❌ Invalid file type. Only JPG, JPEG, PNG, GIF, WEBP are allowed.";
        }
    } else {
        echo "❌ Please select an image file to upload.";
    }
}
?>
