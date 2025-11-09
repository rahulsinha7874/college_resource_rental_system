<?php
session_start();
require_once 'header.php';

if (!isset($_SESSION['checkout_address']) || !isset($_SESSION['checkout_payment'])) {
    header("Location: checkout_address.php");
    exit;
}

$address = $_SESSION['checkout_address'];
$payment = $_SESSION['checkout_payment'];

// Optionally: Insert order details into your database
// $pdo->prepare("INSERT INTO orders (...) VALUES (...)")->execute(...);

// Clear checkout session after order placed
unset($_SESSION['checkout_address']);
unset($_SESSION['checkout_payment']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmation | CampusShare</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f4f6f9;text-align:center;margin:0;padding:0}
    .card{max-width:700px;margin:50px auto;background:#fff;padding:40px;border-radius:8px;box-shadow:0 6px 12px rgba(0,0,0,0.05)}
    .icon{font-size:60px;color:green}
    .btn{background:#003366;color:#fff;padding:10px 15px;text-decoration:none;border-radius:5px}
  </style>
</head>
<body>
  <div class="card">
    <div class="icon"><i class="fas fa-check-circle"></i></div>
    <h2>Order Confirmed!</h2>
    <p>Thank you, <?= htmlspecialchars($address['fullname']) ?>! Your order is successfully placed.</p>
    <h3>Payment Method: <?= htmlspecialchars($payment) ?></h3>
    <h4>Delivery Address:</h4>
    <p><?= htmlspecialchars($address['address']) ?>, <?= htmlspecialchars($address['city']) ?>, <?= htmlspecialchars($address['state']) ?> - <?= htmlspecialchars($address['pincode']) ?></p>
    <br>
    <a href="listing.php" class="btn">Continue Shopping</a>
  </div>
</body>
</html>
<?php require_once 'footer.php'; ?>
