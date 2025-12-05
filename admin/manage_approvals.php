<?php
session_start();
require '../connection.php';
$conn = Connect();

// Fetch pending listings
$query = "SELECT * FROM upload WHERE status='pending'";
$result = $conn->query($query);
?>

<h2>Pending Listings</h2>
<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>User ID</th>
    <th>Title</th>
    <th>Category</th>
    <th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['user_id'] ?></td>
    <td><?= $row['title'] ?></td>
    <td><?= $row['category'] ?></td>
    <td>
        <a href="approve.php?id=<?= $row['id'] ?>" style="color:green;">Approve</a> |
        <a href="reject.php?id=<?= $row['id'] ?>" style="color:red;">Reject</a>
    </td>
</tr>
<?php } ?>
</table>
