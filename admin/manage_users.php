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
  <h2>All Registered Users</h2>
  <table>
    <tr>
  <th>ID</th>
  <th>Name</th>
  <th>Email</th>
  <th>College</th>
  <th>Department</th>
  <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
 <tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['first_name'].' '.$row['last_name'] ?></td>
  <td><?= $row['email'] ?></td>
  <td><?= $row['college'] ?></td>
  <td><?= $row['department'] ?></td>
  <td>
    <a href="delete_user.php?id=<?= $row['id'] ?>" 
       class="delete-btn"
       onclick="return confirm('Are you sure you want to delete this user?');">
       Delete
    </a>
  </td>
 </tr>
   <?php endwhile; ?>
  </table>
</div>
</body>
</html>
