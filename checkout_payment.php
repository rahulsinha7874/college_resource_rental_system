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
    /* Footer */
    footer {
      background-color: var(--primary-color);
      color: var(--white);
      padding: 3rem 2rem 1.5rem;
      margin-top: 4rem;
    }

    .footer-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer-column h3 {
      color: var(--white);
      margin-bottom: 1.5rem;
      font-size: 1.2rem;
    }

    .footer-links {
      list-style: none;
    }

    .footer-links li {
      margin-bottom: 0.75rem;
    }

    .footer-links a {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: var(--transition);
    }

    .footer-links a:hover {
      color: var(--accent-color);
      padding-left: 5px;
    }

    .social-links {
      display: flex;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .social-links a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      color: var(--white);
      transition: var(--transition);
    }

    .social-links a:hover {
      background-color: var(--accent-color);
      transform: translateY(-3px);
    }

    .newsletter-form {
      display: flex;
      margin-top: 1.5rem;
    }

    .newsletter-form input {
      flex: 1;
      padding: 0.75rem;
      border: none;
      border-radius: 4px 0 0 4px;
    }

    .newsletter-form button {
      padding: 0 1rem;
      background-color: var(--accent-color);
      color: var(--white);
      border: none;
      border-radius: 0 4px 4px 0;
      cursor: pointer;
      transition: var(--transition);
    }

    .newsletter-form button:hover {
      background-color: #e05555;
    }

    .footer-bottom {
      text-align: center;
      padding-top: 2rem;
      margin-top: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      font-size: 0.9rem;
      opacity: 0.8;
    }
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
