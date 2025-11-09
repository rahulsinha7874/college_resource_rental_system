<?php
session_start();

// Handle address form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['checkout_address'] = [
        'fullname' => $_POST['fullname'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'pincode' => $_POST['pincode']
    ];

    header("Location: checkout_payment.php");
    exit;
}

// Include header AFTER handling POST
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shipping Address | College Resource Rental System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #f2f6fa; color: #333; }
    .container { max-width: 600px; margin: 3rem auto; padding: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    h2 { text-align: center; margin-bottom: 1.5rem; color: #003366; }
    form label { display: block; margin-top: 1rem; font-weight: 500; }
    form input, form textarea { width: 100%; padding: 0.6rem; margin-top: 0.3rem; border: 1px solid #ccc; border-radius: 4px; }
    form button { margin-top: 1.5rem; padding: 0.7rem 1.2rem; background: #FF6B6B; color: #fff; border: none; border-radius: 4px; cursor: pointer; transition: 0.3s; width: 100%; font-size: 1rem; }
    form button:hover { background: #e05555; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Shipping Address</h2>
    <form method="POST" action="">
      <label>Full Name</label>
      <input type="text" name="fullname" required>

      <label>Phone Number</label>
      <input type="text" name="phone" required>

      <label>Address</label>
      <textarea name="address" rows="3" required></textarea>

      <label>City</label>
      <input type="text" name="city" required>

      <label>State</label>
      <input type="text" name="state" required>

      <label>PIN Code</label>
      <input type="text" name="pincode" required>

      <button type="submit">Continue to Payment</button>
    </form>
  </div>
</body>
</html>

<?php require_once 'footer.php'; ?>
