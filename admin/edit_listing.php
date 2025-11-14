<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/auth_check.php');
include('includes/db_connect.php');

// ====== GET LISTING DATA ======
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Listing ID");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM upload WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$listing = $result->fetch_assoc();

if (!$listing) {
    die("Listing not found");
}

// ====== UPDATE LISTING ======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Update without image first
    $stmt = $conn->prepare("UPDATE upload SET title=?, category=?, price=?, description=? WHERE id=?");
    $stmt->bind_param("ssdsi", $title, $category, $price, $description, $id);
    $stmt->execute();

    // If admin uploads a new image
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $newImage = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $newImage;

        // Upload image
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // Delete old image
        if (!empty($listing['image'])) {
            $oldImagePath = "../uploads/" . $listing['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Save new image in DB
        $stmt = $conn->prepare("UPDATE upload SET image=? WHERE id=?");
        $stmt->bind_param("si", $newImage, $id);
        $stmt->execute();
    }

    header("Location: manage_listings.php?msg=Listing+updated+successfully");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Listing</title>
  <link rel="stylesheet" href="css/admin_style.css">
  <style>
    /* ====== COMMON LAYOUT ====== */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f5f5f5;
}

/* ====== SIDEBAR ====== */
.sidebar {
    width: 220px;
    height: 100vh;
    background: #1e1e2d;
    padding-top: 20px;
    position: fixed;
    left: 0;
    top: 0;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li a {
    display: block;
    color: #ddd;
    padding: 12px 20px;
    margin: 5px 0;
    text-decoration: none;
    font-size: 16px;
    transition: 0.3s;
}

.sidebar ul li a:hover,
.sidebar ul li a.active {
    background: #3e3e57;
    color: #fff;
}

/* ====== MAIN SECTION ====== */
.main {
    margin-left: 240px;
    padding: 25px;
}

h2 {
    margin-top: 0;
    color: #333;
}

/* ====== TABLE STYLE ====== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

table th {
    background: #4b4b72;
    color: #fff;
    padding: 12px;
    text-align: left;
}

table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

table tr:hover {
    background: #f0f0f0;
}

/* Action buttons */
a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Delete Button */
.delete-btn {
    color: red;
    font-weight: bold;
}

/* ====== FORM STYLE (edit_listing.php) ====== */
form {
    background: #fff;
    padding: 20px;
    width: 480px;
    border-radius: 8px;
    box-shadow: 0 0 10px #ccc;
}

label {
    display: block;
    font-weight: bold;
    margin-top: 12px;
}

input[type="text"],
input[type="number"],
textarea,
select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border: 1px solid #aaa;
    border-radius: 5px;
    outline: none;
}

textarea {
    height: 100px;
    resize: vertical;
}

button {
    margin-top: 15px;
    padding: 10px 18px;
    background: #4b4b72;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #33335a;
}

/* Image preview */
img {
    border-radius: 5px;
    margin-top: 10px;
}
    </style>
</head>
<body>

<div class="main">
  <h2>Edit Listing</h2>

  <form method="post" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" value="<?= $listing['title'] ?>" required><br><br>

    <label>Category:</label>
    <input type="text" name="category" value="<?= $listing['category'] ?>" required><br><br>

    <label>Price:</label>
    <input type="number" name="price" value="<?= $listing['price'] ?>" required><br><br>

    <label>Description:</label>
    <textarea name="description" required><?= $listing['description'] ?></textarea><br><br>

    <label>Current Image:</label><br>
    <img src="../uploads/<?= $listing['image'] ?>" width="150"><br><br>

    <label>Upload New Image:</label>
    <input type="file" name="image"><br><br>

    <button type="submit">Update Listing</button>
  </form>

</div>

</body>
</html>
