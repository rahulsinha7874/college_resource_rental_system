<?php
session_start();

// Redirect if address not set
if (!isset($_SESSION['checkout_address'])) {
    header("Location: checkout_address.php");
    exit;
}

// Handle payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['checkout_payment'] = $_POST['payment_method'];
    header("Location: order_confirmation.php");
    exit;
}

// Include header AFTER all header() calls
require_once 'header.php';

// Get saved address
$address = $_SESSION['checkout_address'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Payment | CampusShare</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f4f6f9;margin:0;padding:0}
    .container{max-width:700px;margin:50px auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 6px 12px rgba(0,0,0,0.05)}
    h2{color:#003366;text-align:center;margin-bottom:20px;}
    .address-box{border:1px solid #ccc;border-radius:5px;padding:15px;margin-bottom:20px;background:#fafafa;}
    .address-box p{margin:5px 0;}
    .method{border:1px solid #ccc;border-radius:5px;padding:10px;margin-bottom:10px}
    button{background:#006699;color:#fff;padding:10px 15px;border:0;border-radius:5px;cursor:pointer;width:100%;font-size:1rem;transition:0.3s}
    button:hover{background:#005580}
  </style>
</head>
<body>
  <div class="container">
    <h2>Confirm Shipping Address & Select Payment</h2>

    <div class="address-box">
      <h3>Shipping Address</h3>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($address['fullname']); ?></p>
      <p><strong>Phone:</strong> <?php echo htmlspecialchars($address['phone']); ?></p>
      <p><strong>Address:</strong> <?php echo htmlspecialchars($address['address']); ?></p>
      <p><strong>City:</strong> <?php echo htmlspecialchars($address['city']); ?></p>
      <p><strong>State:</strong> <?php echo htmlspecialchars($address['state']); ?></p>
      <p><strong>PIN Code:</strong> <?php echo htmlspecialchars($address['pincode']); ?></p>
      <p><a href="checkout_address.php">Edit Address</a></p>
    </div>

    <form method="POST">
      <div class="method">
        <label><input type="radio" name="payment_method" value="Google Pay" required> Google Pay (UPI)</label>
      </div>
      <div class="method">
        <label><input type="radio" name="payment_method" value="PhonePe"> PhonePe</label>
      </div>
      <div class="method">
        <label><input type="radio" name="payment_method" value="Cash on Delivery"> Cash on Delivery</label>
      </div>
      <button type="submit">Confirm Order</button>
    </form>
  </div>
</body>
</html>
<?php require_once 'footer.php'; ?>
