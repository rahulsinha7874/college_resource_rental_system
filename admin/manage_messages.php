<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/auth_check.php');
include('includes/db_connect.php');
$result = $conn->query("SELECT * FROM contact_us ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Messages</title>
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
  <h2>Contact Messages</h2>
  <table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= $row['subject'] ?></td>
      <td><?= $row['message'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
