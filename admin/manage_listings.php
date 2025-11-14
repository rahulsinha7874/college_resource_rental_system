<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/auth_check.php');
include('includes/db_connect.php');
$result = $conn->query("SELECT * FROM upload ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Listings</title>
  <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<div class="sidebar">
  <h2>Admin Panel</h2>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="manage_users.php">Manage Users</a></li>
      <li><a href="manage_listings.php">Manage Listings</a></li>
      <li><a href="manage_messages.php">View Messages</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
<div class="main">
  <h2>All Listings</h2>
  <table>
    <tr><th>ID</th><th>Title</th><th>Category</th><th>Price</th><th>Action</th></tr><th>Action</th>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['title'] ?></td>
      <td><?= $row['category'] ?></td>
      <td><?= $row['price'] ?></td>
      <td><a href="edit_listing.php?id=<?= $row['id'] ?>">Edit</a></td>
      <td><a href="delete_listing.php?id=<?= $row['id'] ?>">Delete</a></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
