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
  <title>Your Cart | CampusShare</title>
  <meta name="description" content="View and manage your rental cart items on CampusShare">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
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

    /* Header Styles */
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

    .btn-secondary {
      background-color: var(--secondary-color);
      color: var(--white);
      border: 2px solid var(--secondary-color);
    }

    .btn-secondary:hover {
      background-color: transparent;
      color: var(--secondary-color);
    }

    .btn-sm {
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
    }

    /* Cart Specific Styles */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .section-title {
      text-align: center;
      margin-bottom: 2rem;
      position: relative;
    }

    .section-title h2 {
      font-size: 2rem;
      display: inline-block;
      padding-bottom: 0.5rem;
    }

    .section-title h2::after {
      content: '';
      position: absolute;
      width: 60px;
      height: 3px;
      background-color: var(--accent-color);
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
    }

    .cart-container {
      background-color: var(--white);
      border-radius: 8px;
      box-shadow: var(--shadow);
      padding: 2rem;
      margin-top: 2rem;
    }

    .cart-items {
      margin-bottom: 2rem;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem;
      border-bottom: 1px solid var(--gray-light);
      transition: var(--transition);
    }

    .cart-item:hover {
      background-color: rgba(0, 0, 0, 0.02);
    }

    .cart-item-info {
      flex: 1;
    }

    .cart-item-info h4 {
      font-size: 1.1rem;
      color: var(--primary-color);
      margin-bottom: 0.5rem;
    }

    .cart-item-price {
      font-weight: 700;
      color: var(--secondary-color);
      font-size: 1.1rem;
      margin-right: 2rem;
    }

    .remove-item {
      background-color: transparent;
      color: var(--accent-color);
      border: 1px solid var(--accent-color);
      padding: 0.5rem 1rem;
      border-radius: 4px;
      cursor: pointer;
      transition: var(--transition);
    }

    .remove-item:hover {
      background-color: var(--accent-color);
      color: var(--white);
    }

    .empty-cart-message {
      text-align: center;
      padding: 3rem;
      color: #666;
      font-size: 1.1rem;
    }

    .cart-summary {
      background-color: var(--light-color);
      padding: 1.5rem;
      border-radius: 8px;
      margin-top: 2rem;
    }

    .cart-summary h3 {
      margin-bottom: 1.5rem;
      color: var(--primary-color);
    }

    .cart-total {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      font-size: 1.2rem;
    }

    .cart-total span {
      font-weight: 700;
      color: var(--secondary-color);
      font-size: 1.4rem;
    }

    .checkout-btn {
      width: 100%;
      background-color: var(--accent-color);
      color: var(--white);
      padding: 1rem;
      border: none;
      border-radius: 4px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .checkout-btn:hover {
      background-color: #e05555;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .checkout-btn:disabled {
      background-color: #ccc;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        padding: 1rem;
      }
      
      .logo {
        margin-bottom: 1rem;
      }
      
      nav {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
      }
      
      .auth-buttons {
        margin-top: 1rem;
        width: 100%;
        justify-content: center;
      }
      
      .cart-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }
      
      .cart-item-price {
        margin-right: 0;
        margin-bottom: 0.5rem;
      }
    }
    
    /* Notification styles */
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: var(--accent-color);
      color: white;
      padding: 15px 25px;
      border-radius: 5px;
      box-shadow: var(--shadow);
      z-index: 1001;
      display: flex;
      align-items: center;
      gap: 10px;
      transform: translateX(120%);
      transition: transform 0.3s ease;
    }

    .notification.show {
      transform: translateX(0);
    }

    .notification.success {
      background-color: #4CAF50;
    }

    .notification.warning {
      background-color: #FF9800;
    }

    .notification.error {
      background-color: #F44336;
    }

    .notification i {
      font-size: 1.2rem;
    }

    /* Login modal styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1002;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: white;
      padding: 2rem;
      border-radius: 8px;
      width: 90%;
      max-width: 400px;
      box-shadow: var(--shadow);
      position: relative;
    }

    .close-modal {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--dark-color);
    }

    .modal-title {
      margin-bottom: 1.5rem;
      color: var(--primary-color);
      text-align: center;
    }

    .modal-buttons {
      display: flex;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .modal-buttons .btn {
      flex: 1;
      text-align: center;
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

    .user-info {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--white);
    }

    .user-info img {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
    }

  </style>
</head>
<body>

  <!-- Notification element -->
  <div class="notification" id="notification">
    <i class="fas fa-check-circle"></i>
    <span id="notification-message">Item added to cart!</span>
  </div>

  <!-- Login Required Modal -->
  <div class="modal" id="loginModal">
    <div class="modal-content">
      <span class="close-modal" id="closeModal">&times;</span>
      <h3 class="modal-title">Login Required</h3>
      <p>You need to login to proceed to checkout.</p>
      <p>If you don't have an account, you can register now.</p>
      <div class="modal-buttons">
        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="register.php" class="btn btn-secondary">Register</a>
      </div>
    </div>
  </div>



  <div class="container">
    <div class="section-title">
      <h2>Your Cart</h2>
      <p>Review and manage your selected items</p>
    </div>

    <div class="cart-container">
      <div class="cart-items" id="cart-items">
        <!-- Cart items will be dynamically added here -->
        <div class="cart-item">
          <div class="cart-item-info">
            <h4>Casio Calculator FX-991EX</h4>
            <p>Scientific calculator with 552 functions, suitable for engineering students</p>
          </div>
          <div class="cart-item-price">₹300</div>
          <button class="remove-item" data-id="1">
            <i class="fas fa-trash-alt"></i> Remove
          </button>
        </div>
      </div>
      
      <div class="cart-summary">
        <h3>Order Summary</h3>
        <div class="cart-total">
          <span>Total Amount:</span>
          <span id="cart-total">₹300</span>
        </div>
        <a href="checkout_address.php" id="checkout-btn" class="btn btn-primary">
         <i class="fas fa-lock"></i> Proceed to Checkout
        </a>

      </div>
    </div>
  </div>


  <script>

// Load cart from backend when page loads
document.addEventListener("DOMContentLoaded", function() {
    loadCartFromBackend();
});

// ===============================================
// 1️⃣ FETCH CART DATA FROM BACKEND
// ===============================================
function loadCartFromBackend() {
    fetch("fetch_cart.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);

        if (data.status === "success") {
            renderCartItems(data.items);
            updateCartTotal(data.total);
            updateNavbarCartCount(data.count);
        } else {
            renderEmptyCart();
        }
    })
    .catch(err => console.error("Cart Load Error:", err));
}

// ===============================================
// 2️⃣ RENDER CART ITEMS ON PAGE
// ===============================================
function renderCartItems(items) {
    const container = document.getElementById("cart-items");
    container.innerHTML = "";

    if (items.length === 0) {
        renderEmptyCart();
        return;
    }

    items.forEach(item => {
        container.innerHTML += `
        <div class="cart-item">
            <div class="cart-item-info">
                <h4>${item.name}</h4>
                <p>${item.description || ""}</p>
            </div>

            <div class="cart-item-price">₹${item.price}</div>

            <button class="remove-item" onclick="removeCartItem(${item.item_id})">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
        `;
    });
}

// ===============================================
// 3️⃣ SHOW EMPTY CART MESSAGE
// ===============================================
function renderEmptyCart() {
    document.getElementById("cart-items").innerHTML = `
        <p class="empty-cart-message">
            Your cart is empty. <a href="listing.php" style="color: var(--accent-color);">Browse items</a>
        </p>
    `;
    updateCartTotal(0);
    disableCheckoutBtn();
}

// ===============================================
// 4️⃣ UPDATE CART TOTAL
// ===============================================
function updateCartTotal(total) {
    document.getElementById("cart-total").textContent = "₹" + total;
}

// ===============================================
// 5️⃣ UPDATE NAVBAR CART COUNT
// ===============================================
function updateNavbarCartCount(count) {
    const navCount = document.getElementById("cart-count");
    if (navCount) {
        navCount.textContent = count;
    }
}

// ===============================================
// 6️⃣ DISABLE CHECKOUT IF CART EMPTY
// ===============================================
function disableCheckoutBtn() {
    const btn = document.getElementById("checkout-btn");
    if (btn) {
        btn.disabled = true;
        btn.style.opacity = "0.6";
        btn.style.cursor = "not-allowed";
    }
}

// ===============================================
// 7️⃣ REMOVE ITEM FROM CART (BACKEND)
// ===============================================
function removeCartItem(itemId) {
    fetch("remove_cart_item.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ item_id: itemId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showNotification("Item removed", "success");
            loadCartFromBackend(); // refresh cart after delete
        }
    })
    .catch(err => console.error("Remove Item Error:", err));
}

// ===============================================
// 8️⃣ NOTIFICATION POPUP
// ===============================================
function showNotification(message, type = "success") {
    const notification = document.getElementById("notification");
    const messageEl = document.getElementById("notification-message");

    notification.className = `notification ${type} show`;
    messageEl.textContent = message;

    setTimeout(() => {
        notification.classList.remove("show");
    }, 3000);
}

</script>

</body>
</html>
<?php require_once 'footer.php'; ?>