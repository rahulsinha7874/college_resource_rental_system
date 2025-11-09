<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // static admin credentials
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
