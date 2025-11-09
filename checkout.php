<?php
$pageTitle = "College Resource Rental System | Student Marketplace";
$pageDescription = "Rent or sell academic resources including books, electronics, and study materials within your college community.";
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation | CampusShare</title>
  <meta name="description" content="Your order confirmation for academic resources on CampusShare">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Consistent with your existing styles */
    :root {
      --primary-color: #003366;
      --secondary-color: #006699;
      --accent-color: #FF6B6B;
      --light-color: #f2f6fa;
      --dark-color: #333;
      --white: #ffffff;
      --gray-light: #e9ecef;
      --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light-color);
      color: var(--dark-color);
      line-height: 1.6;
    }

    /* Header Styles - Consistent with main site */
    header {
      background-color: var(--primary-color);
      color: var(--white);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: var(--shadow);
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .logo i {
      font-size: 1.5rem;
      color: var(--accent-color);
    }

    .logo h1 {
      font-size: 1.5rem;
      margin: 0;
      color: var(--white);
    }

    nav {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    nav a {
      color: var(--white);
      text-decoration: none;
      font-weight: 500;
      padding: 0.5rem 0;
      position: relative;
      transition: var(--transition);
    }

    nav a:hover {
      color: var(--accent-color);
    }

    nav a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: var(--accent-color);
      transition: var(--transition);
    }

    nav a:hover::after {
      width: 100%;
    }

    .auth-buttons {
      display: flex;
      gap: 1rem;
    }

    .btn {
      padding: 0.5rem 1.25rem;
      border-radius: 4px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      text-decoration: none;
      display: inline-block;
    }

    .btn-primary {
      background-color: var(--accent-color);
      color: var(--white);
      border: 2px solid var(--accent-color);
    }

    .btn-primary:hover {
      background-color: transparent;
      color: var(--accent-color);
    }

    .btn-outline {
      background-color: transparent;
      color: var(--white);
      border: 2px solid var(--white);
    }

    .btn-outline:hover {
      background-color: var(--white);
      color: var(--primary-color);
    }

    /* Confirmation Section */
    .confirmation-container {
      max-width: 800px;
      margin: 3rem auto;
      padding: 0 1rem;
    }

    .confirmation-card {
      background-color: var(--white);
      border-radius: 8px;
      padding: 3rem;
      box-shadow: var(--shadow);
      text-align: center;
    }

    .confirmation-icon {
      font-size: 4rem;
      color: #4CAF50;
      margin-bottom: 1.5rem;
    }

    .confirmation-card h2 {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--primary-color);
    }

    .confirmation-card p {
      font-size: 1.1rem;
      margin-bottom: 2rem;
      color: #666;
    }

    .order-details {
      background-color: var(--light-color);
      border-radius: 8px;
      padding: 2rem;
      margin: 2rem 0;
      text-align: left;
    }

    .order-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--gray-light);
    }

    .order-row:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .order-row strong {
      color: var(--dark-color);
    }

    .order-number {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .order-date {
      color: #666;
      margin-bottom: 1.5rem;
    }

    .order-items {
      margin-top: 1.5rem;
    }

    .order-item {
      display: flex;
      gap: 1rem;
      margin-bottom: 1rem;
      align-items: center;
    }

    .order-item-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
    }

    .order-item-details {
      flex: 1;
    }

    .order-item-title {
      font-weight: 600;
    }

    .order-item-price {
      color: var(--secondary-color);
      font-weight: 500;
    }

    .order-total {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--primary-color);
      margin-top: 1rem;
    }

    .confirmation-actions {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 2rem;
    }

    .btn-large {
      padding: 0.75rem 1.5rem;
      font-size: 1.1rem;
    }

    .btn-secondary {
      background-color: var(--secondary-color);
      color: var(--white);
      border: 2px solid var(--secondary-color);
    }

    .btn-secondary:hover {
      background-color: transparent;
      color: var(--secondary-color);
    }


    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .confirmation-card {
        padding: 2rem 1.5rem;
      }
      
      .confirmation-actions {
        flex-direction: column;
      }
      
      .btn {
        width: 100%;
      }
    }

    @media (max-width: 576px) {
      header {
        flex-direction: column;
        padding: 1rem;
      }
      
      nav {
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 1rem;
      }
      
      .auth-buttons {
        width: 100%;
        justify-content: center;
        margin-top: 1rem;
      }
      
      .order-row {
        flex-direction: column;
        gap: 0.5rem;
      }
    }

    /* Footer */
    footer {
      background-color: var(--primary-color);
      color: var(--white);
      padding: 3rem 2rem 1.5rem;
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

  <main class="confirmation-container">
    <div class="confirmation-card">
      <div class="confirmation-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <h2>Order Confirmed!</h2>
      <p>Thank you for your purchase. Your order has been successfully placed.</p>
      
      <div class="order-details">
        <div class="order-number">Order #CS-2023-05642</div>
        <div class="order-date">Placed on October 15, 2023 at 2:30 PM</div>
        
        <div class="order-items">
          <div class="order-item">
            <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Engineering Notes" class="order-item-img">
            <div class="order-item-details">
              <div class="order-item-title">Complete Engineering Semester Notes</div>
              <div class="order-item-price">₹100 (Digital Download)</div>
            </div>
          </div>
        </div>
        
        <div class="order-row">
          <span>Payment Method:</span>
          <strong>Google Pay</strong>
        </div>
        <div class="order-row">
          <span>Delivery Method:</span>
          <strong>Instant Digital Download</strong>
        </div>
        <div class="order-total">
          Total Paid: ₹100
        </div>
      </div>
      
      <div class="confirmation-actions">
        <a href="listing.php" class="btn btn-primary btn-large">Continue Shopping</a>
        <a href="order-details.php" class="btn btn-secondary btn-large">View Order Details</a>
      </div>
      
      <div style="margin-top: 2rem; font-size: 0.9rem; color: #666;">
        <p>An email confirmation has been sent to your registered email address.</p>
        <p>Need help? <a href="contact.php" style="color: var(--accent-color);">Contact our support team</a></p>
      </div>
    </div>
  </main>

  <script>
    // In a real application, you would fetch the order details from your backend
    document.addEventListener('DOMContentLoaded', function() {
      // Update cart count in header
      document.querySelector('nav a[href="cart.php"]').textContent = 'Cart (0)';

      // You might also store the order confirmation in localStorage
      localStorage.setItem('cart', JSON.stringify([]));
    });
  </script>
</body>
</html>
<?php require_once 'footer.php'; ?>