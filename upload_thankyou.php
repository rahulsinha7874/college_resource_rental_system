<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'connection.php';
$conn = Connect();

// ✅ Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to upload a listing. <a href='login.php'>Login</a>");
}

$user_id     = $_SESSION['user_id'];
$title       = $conn->real_escape_string($_POST['title']);
$category    = $conn->real_escape_string($_POST['category']);
$description = $conn->real_escape_string($_POST['description']);
$price       = $conn->real_escape_string($_POST['price']);
$contact     = $conn->real_escape_string($_POST['contact']);

// ✅ Folder for uploads
$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$imageNames = []; // store image filenames

// ✅ Loop through all uploaded images
if (!empty($_FILES['image']['name'][0])) {
    foreach ($_FILES['image']['name'] as $key => $fileName) {
        $tmpName = $_FILES['image']['tmp_name'][$key];
        $fileSize = $_FILES['image']['size'][$key];
        $fileError = $_FILES['image']['error'][$key];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if ($fileError === 0 && in_array($fileExt, $allowedTypes)) {
            if ($fileSize <= 5 * 1024 * 1024) { // max 5MB
                $newFileName = time() . "_" . uniqid() . "." . $fileExt;
                $targetPath = $uploadDir . $newFileName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $imageNames[] = $newFileName;
                }
            }
        }
    }
}

// ✅ Convert array to comma-separated string for DB
$imageList = implode(',', $imageNames);

// ✅ Insert into DB
$sql = "INSERT INTO upload (user_id, title, category, description, price, image, contact)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssdss", $user_id, $title, $category, $description, $price, $imageList, $contact);

if ($stmt->execute()) {
    echo "<script>alert('✅ Listing uploaded successfully!'); window.location.href='upload.php';</script>";
} else {
    echo "❌ Database Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
