<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/auth_check.php');
include('includes/db_connect.php');
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Users</title>
  <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<div class="sidebar">
  <ul>
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="manage_users.php" class="active">Manage Users</a></li>
    <li><a href="manage_listings.php">Manage Listings</a></li>
    <li><a href="manage_messages.php">View Messages</a></li>
  </ul>
</div>
<div class="main">
  <h2>All Registered Users</h2>
  <table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>College</th><th>Department</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['first_name'].' '.$row['last_name'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= $row['college'] ?></td>
      <td><?= $row['department'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
