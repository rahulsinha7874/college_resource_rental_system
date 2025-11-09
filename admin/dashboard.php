<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/auth_check.php');
include('includes/db_connect.php');

$users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$listings = $conn->query("SELECT COUNT(*) AS total FROM listings")->fetch_assoc()['total'];
$messages = $conn->query("SELECT COUNT(*) AS total FROM contact_us")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
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
    <h1>Welcome to CampusShare Admin Dashboard</h1>
    <div class="stats">
      <div class="card">Total Users: <b><?= $users ?></b></div>
      <div class="card">Total Listings: <b><?= $listings ?></b></div>
      <div class="card">Messages: <b><?= $messages ?></b></div>
    </div>
  </div>
</body>
</html>
