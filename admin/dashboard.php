<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/auth_check.php');
include('includes/db_connect.php');

// Users count
$users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];

// Listings count (upload table)
$total_listings = $conn->query("SELECT COUNT(*) AS total FROM upload")->fetch_assoc()['total'];

// Listing status counts
$approved_listings = $conn->query("SELECT COUNT(*) AS total FROM upload WHERE status='approved'")->fetch_assoc()['total'];
$pending_listings  = $conn->query("SELECT COUNT(*) AS total FROM upload WHERE status='pending'")->fetch_assoc()['total'];
$rejected_listings = $conn->query("SELECT COUNT(*) AS total FROM upload WHERE status='rejected'")->fetch_assoc()['total'];

// Pending listings data
$pending = $conn->query("SELECT * FROM upload WHERE status='pending' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard | CampusShare</title>
  <link rel="stylesheet" href="css/admin_style.css">
  <style>

    /* Dashboard Card Style */
    .stats, .status-boxes {
      display: flex;
      gap: 20px;
      padding: 20px;
    }

    .card {
      background: #fff;
      padding: 25px;
      font-size: 20px;
      border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      flex: 1;
      text-align: center;
    }

    .status-card {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 6px;
      flex: 1;
      font-size: 18px;
      text-align: center;
      border-left: 6px solid #007bff;
    }

    .approved { border-color: green; }
    .pending { border-color: orange; }
    .rejected { border-color: red; }

    /* Pending Table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
    }

    table th {
      background: #f1f1f1;
      padding: 12px;
      font-size: 16px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }

    table td {
      padding: 10px;
      font-size: 15px;
      border-bottom: 1px solid #eee;
    }

    a.btn-approve, a.btn-reject {
      padding: 6px 12px;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
      font-size: 14px;
    }

    .btn-approve { background: green; }
    .btn-reject { background: red; }

  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
      <li><a href="dashboard.php" class="active">Dashboard</a></li>
      <li><a href="manage_users.php">Manage Users</a></li>
      <li><a href="manage_listings.php">Manage Listings</a></li>
      <li><a href="manage_messages.php">View Messages</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>

  <div class="main">
    <h1>Welcome to CampusShare Admin Dashboard</h1>

    <!-- TOP NUMBERS -->
    <div class="stats">
      <div class="card">👥 Users<br><b><?= $users ?></b></div>
      <div class="card">📦 Total Listings<br><b><?= $total_listings ?></b></div>
      <div class="card">✉ Messages<br><b><?= $messages ?? 0 ?></b></div>
    </div>

    <!-- STATUS OVERVIEW -->
    <h2 style="margin-left:20px;">Listing Status Overview</h2>
    <div class="status-boxes">
      <div class="status-card approved">Approved Listings: <br><b><?= $approved_listings ?></b></div>
      <div class="status-card pending">Pending Approval: <br><b><?= $pending_listings ?></b></div>
      <div class="status-card rejected">Rejected Listings: <br><b><?= $rejected_listings ?></b></div>
    </div>

    <!-- PENDING LISTINGS WITH APPROVE/REJECT BUTTONS -->
    <h2 style="margin-left:20px; margin-top:30px;">Pending Listings (Action Required)</h2>

    <div style="padding:20px;">
      <?php if ($pending->num_rows > 0): ?>

        <table>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>User ID</th>
            <th>Action</th>
          </tr>

          <?php while ($row = $pending->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['title'] ?></td>
              <td><?= $row['category'] ?></td>
              <td><?= $row['user_id'] ?></td>
              <td>
                <a class="btn-approve" href="approve.php?id=<?= $row['id'] ?>">Approve</a>
                <a class="btn-reject" href="reject.php?id=<?= $row['id'] ?>">Reject</a>
              </td>
            </tr>
          <?php endwhile; ?>

        </table>

      <?php else: ?>
        <p style="color:gray; font-size:16px;">No pending listings — you're all caught up! 🎉</p>
      <?php endif; ?>
    </div>

  </div>

</body>
</html>
