<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'connection.php';
$conn = Connect();

// Fetch all resources
$result = $conn->query("SELECT * FROM upload ORDER BY created_at DESC");

$listings = [];
while ($row = $result->fetch_assoc()) {
    $listings[] = $row;
}

$pageTitle = "Available Listings | CampusShare";
$pageDescription = "Browse available academic resources including books, electronics, and study materials shared by students in your college community.";
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <meta name="description" content="<?php echo $pageDescription; ?>">
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
      --shadow-hover: 0 10px 20px rgba(0, 0, 0, 0.15);
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

    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 2rem;
      min-height: 65vh;
    }

    .page-header {
      text-align: center;
      margin-bottom: 3rem;
      position: relative;
    }

    .page-header h2 {
      font-size: 2.5rem;
      color: var(--primary-color);
      margin-bottom: 1rem;
      position: relative;
      display: inline-block;
      font-weight: 700;
    }

    .page-header h2::after {
      content: '';
      position: absolute;
      width: 80px;
      height: 4px;
      background: linear-gradient(to right, var(--primary-color), var(--accent-color));
      bottom: -15px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 2px;
    }

    .page-header p {
      max-width: 700px;
      margin: 2rem auto 0;
      color: #666;
      font-size: 1.1rem;
    }

    .filters-container {
      background-color: var(--white);
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: var(--shadow);
      margin-bottom: 2rem;
    }

    .filters {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .search-filter {
      flex: 1;
      min-width: 300px;
      position: relative;
    }

    .search-filter input {
      width: 100%;
      padding: 0.9rem 1rem 0.9rem 45px;
      border: 2px solid var(--gray-light);
      border-radius: 8px;
      font-size: 1rem;
      transition: var(--transition);
    }

    .search-filter input:focus {
      border-color: var(--secondary-color);
      outline: none;
      box-shadow: 0 0 0 3px rgba(0, 102, 153, 0.1);
    }

    .search-filter i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
    }

    .category-filter {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .filter-btn {
      padding: 0.6rem 1.2rem;
      background-color: var(--white);
      border: 2px solid var(--gray-light);
      border-radius: 6px;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 500;
    }

    .filter-btn:hover, .filter-btn.active {
      background-color: var(--primary-color);
      color: var(--white);
      border-color: var(--primary-color);
      transform: translateY(-2px);
    }

    .bulk-actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin: 1.5rem 0;
    }

    .btn {
      padding: 0.7rem 1.5rem;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      border: none;
      font-size: 0.95rem;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--accent-color), #e05555);
      color: var(--white);
      box-shadow: 0 4px 8px rgba(255, 107, 107, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(255, 107, 107, 0.4);
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

    .listing-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .listing {
      background-color: var(--white);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
      position: relative;
    }

    .listing:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-hover);
    }

    .listing-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: var(--accent-color);
      color: white;
      padding: 0.3rem 0.8rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      z-index: 2;
    }

    .listing-image {
      height: 200px;
      overflow: hidden;
      background: linear-gradient(45deg, #f2f6fa, #e9ecef);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .listing-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .listing:hover .listing-image img {
      transform: scale(1.08);
    }

    .listing-content {
      padding: 1.5rem;
    }

    .listing-content h3 {
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
      color: var(--primary-color);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-weight: 600;
    }

    .listing-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.8rem;
      font-size: 0.9rem;
      color: #666;
    }

    .listing-category {
      background-color: var(--light-color);
      padding: 0.3rem 0.7rem;
      border-radius: 4px;
      font-weight: 500;
    }

    .listing-price {
      font-weight: 700;
      color: var(--secondary-color);
      font-size: 1.3rem;
      margin: 0.8rem 0;
    }

    .listing-desc {
      font-size: 0.95rem;
      color: #666;
      margin: 0.8rem 0;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      line-height: 1.5;
    }

    .listing-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 1.2rem;
      padding-top: 1rem;
      border-top: 1px solid var(--gray-light);
    }

    .listing-date {
      font-size: 0.85rem;
      color: #888;
    }

    .listing-actions {
      display: flex;
      gap: 0.8rem;
    }

    .btn-sm {
      padding: 0.6rem 1rem;
      font-size: 0.9rem;
    }

    .btn-secondary {
      background: linear-gradient(135deg, var(--secondary-color), #0088cc);
      color: var(--white);
      box-shadow: 0 3px 6px rgba(0, 102, 153, 0.2);
    }

    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0, 102, 153, 0.3);
    }

    .btn-outline-secondary {
      background-color: transparent;
      color: var(--secondary-color);
      border: 2px solid var(--secondary-color);
    }

    .btn-outline-secondary:hover {
      background-color: var(--secondary-color);
      color: var(--white);
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 3rem;
      gap: 0.5rem;
    }

    .pagination a {
      padding: 0.7rem 1.1rem;
      border: 1px solid var(--gray-light);
      border-radius: 6px;
      text-decoration: none;
      color: var(--dark-color);
      transition: var(--transition);
      font-weight: 500;
    }

    .pagination a:hover, .pagination a.active {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: var(--white);
      border-color: transparent;
      transform: translateY(-2px);
    }

    .no-results {
      text-align: center;
      grid-column: 1 / -1;
      padding: 3rem;
      color: #666;
      font-size: 1.2rem;
      background-color: var(--white);
      border-radius: 12px;
      box-shadow: var(--shadow);
    }

    .no-image {
      color: #ccc;
      font-size: 3.5rem;
    }

    .cart-notification {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #4CAF50;
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      display: flex;
      align-items: center;
      gap: 0.8rem;
      z-index: 1000;
      transform: translateX(150%);
      transition: transform 0.5s ease;
    }

    .cart-notification.show {
      transform: translateX(0);
    }

    @media (max-width: 768px) {
      .filters {
        flex-direction: column;
        align-items: stretch;
      }
      
      .search-filter {
        min-width: 100%;
      }
      
      .category-filter {
        justify-content: center;
      }
      
      .bulk-actions {
        justify-content: center;
      }
      
      .listing-grid {
        grid-template-columns: 1fr;
      }
      
      .page-header h2 {
        font-size: 2rem;
      }
    }

    /* Loading animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .listing {
      animation: fadeIn 0.5s ease-out;
    }

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
    <div class="page-header">
      <h2>Available Resources</h2>
      <p>Browse through hundreds of academic resources shared by students in your college community. Rent what you need or sell what you don't.</p>
    </div>

    <div class="filters-container">
      <div class="filters">
        <div class="search-filter">
          <i class="fas fa-search"></i>
          <input type="text" id="search-input" placeholder="Search for books, notes, calculators...">
        </div>
        <div class="category-filter" id="category-filter">
          <button class="filter-btn active" data-category="all">All</button>
          <button class="filter-btn" data-category="textbooks">Textbooks</button>
          <button class="filter-btn" data-category="electronics">Electronics</button>
          <button class="filter-btn" data-category="notes">Notes</button>
          <button class="filter-btn" data-category="lab">Lab Equipment</button>
          <button class="filter-btn" data-category="other">Other</button>
        </div>
      </div>
    </div>

    <div class="bulk-actions">
      <button id="add-all-to-cart" class="btn btn-primary">
        <i class="fas fa-cart-plus"></i> Add All Visible to Cart
      </button>
    </div>

    <div class="listing-grid" id="listing-grid">
      <?php if (count($listings) > 0): ?>
        <?php foreach ($listings as $index => $listing): ?>
          <?php
          $priceValue = floatval($listing['price']);
          $priceDisplay = ($priceValue > 500) ? '₹' . $priceValue . '/month' : (($priceValue > 0) ? '₹' . $priceValue : 'Free');
          $buttonText = ($priceValue > 500) ? 'Rent Now' : (($priceValue > 0) ? 'Buy Now' : 'Get Now');
          $category = !empty($listing['category']) ? $listing['category'] : 'other';
          
          // Check if image exists in database
          $hasImage = !empty($listing['image']);
          $imageContent = '';
          
          if ($hasImage) {
            // Use get_image.php to retrieve image from database
            $imageContent = 'get_image.php?id=' . $listing['id'];
          }
          
          // Format date
          $date = !empty($listing['created_at']) ? date('M j, Y', strtotime($listing['created_at'])) : 'Recent';
          ?>
          <div class="listing" data-category="<?php echo htmlspecialchars($category); ?>" style="animation-delay: <?php echo $index * 0.05; ?>s">
            <?php if ($priceValue == 0): ?>
              <div class="listing-badge">FREE</div>
            <?php endif; ?>
            <div class="listing-image">
              <?php if ($hasImage): ?>
                <img src="<?php echo $imageContent; ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>">
              <?php else: ?>
                <div class="no-image">
                  <i class="fas fa-image"></i>
                </div>
              <?php endif; ?>
            </div>
            <div class="listing-content">
              <h3><?php echo htmlspecialchars($listing['title']); ?></h3>
              <div class="listing-meta">
                <span class="listing-category"><?php echo htmlspecialchars(ucfirst($category)); ?></span>
              </div>
              <div class="listing-price"><?php echo $priceDisplay; ?></div>
              <div class="listing-desc"><?php echo htmlspecialchars(!empty($listing['description']) ? $listing['description'] : 'No description available.'); ?></div>
              <div class="listing-footer">
                <div class="listing-date">
                  <i class="far fa-clock"></i> <?php echo $date; ?>
                </div>
                <div class="listing-actions">
                  <button class="btn btn-secondary btn-sm add-to-cart" 
                    data-id="<?php echo $listing['id']; ?>" 
                    data-name="<?php echo htmlspecialchars($listing['title']); ?>" 
                    data-price="<?php echo $priceValue; ?>">
                    <i class="fas fa-shopping-cart"></i> <?php echo $buttonText; ?>
                  </button>
                  <a href="details.php?id=<?php echo $listing['id']; ?>" class="btn btn-outline-secondary btn-sm">Details</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-results">
          <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
          <h3>No listings available</h3>
          <p>Check back later or add your own listing to get started!</p>
        </div>
      <?php endif; ?>
    </div>

    <div class="pagination">
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">4</a>
      <a href="#">5</a>
      <a href="#"><i class="fas fa-chevron-right"></i></a>
    </div>
  </div>

  <div class="cart-notification" id="cart-notification">
    <i class="fas fa-check-circle"></i>
    <span id="notification-text">Item added to cart!</span>
  </div>

  <script>
    // DOM Elements
    const listingGrid = document.getElementById('listing-grid');
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const addAllToCartBtn = document.getElementById('add-all-to-cart');
    const cartCount = document.getElementById('cart-count');
    const listings = document.querySelectorAll('.listing');
    const cartNotification = document.getElementById('cart-notification');
    const notificationText = document.getElementById('notification-text');

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
      updateCartCount();
      setupEventListeners();
    });

    // Setup event listeners
    function setupEventListeners() {
      // Search functionality
      searchInput.addEventListener('input', filterListings);
      
      // Category filter
      categoryFilter.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function() {
          categoryFilter.querySelector('.active').classList.remove('active');
          this.classList.add('active');
          filterListings();
        });
      });
      
      // Add all to cart
      addAllToCartBtn.addEventListener('click', addAllToCart);
      
      // Add to cart buttons
      document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', addToCartHandler);
      });
    }

    // Filter listings based on search and category
    function filterListings() {
      const searchTerm = searchInput.value.trim().toLowerCase();
      const activeCategory = categoryFilter.querySelector('.active').dataset.category;
      let visibleCount = 0;
      
      listings.forEach(listing => {
        const title = listing.querySelector('h3').textContent.toLowerCase();
        const description = listing.querySelector('.listing-desc').textContent.toLowerCase();
        const category = listing.dataset.category;
        
        const matchesSearch = 
          title.includes(searchTerm) ||
          description.includes(searchTerm);
        
        const matchesCategory = 
          activeCategory === 'all' || 
          category === activeCategory;
        
        if (matchesSearch && matchesCategory) {
          listing.style.display = 'block';
          visibleCount++;
        } else {
          listing.style.display = 'none';
        }
      });
      
      // Update "Add All" button text
      addAllToCartBtn.innerHTML = `<i class="fas fa-cart-plus"></i> Add All (${visibleCount}) to Cart`;
    }

    // Add to cart handler
    function addToCartHandler(event) {
      const button = event.currentTarget;
      const itemId = button.dataset.id;
      const itemName = button.dataset.name;
      const itemPrice = parseFloat(button.dataset.price);
      
      addToCart(itemId, itemName, itemPrice);
      
      // Visual feedback
      const originalText = button.innerHTML;
      button.innerHTML = '<i class="fas fa-check"></i> Added';
      button.style.background = '#4CAF50';
      setTimeout(() => {
        button.innerHTML = originalText;
        button.style.background = '';
      }, 2000);
      
      // Show notification
      showNotification(`"${itemName}" added to cart!`);
    }

    // Add item to cart
    function addToCart(itemId, itemName, itemPrice) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      
      // Check if item already exists in cart
      const existingItem = cart.find(item => item.id == itemId);
      
      if (!existingItem) {
        cart.push({ 
          id: itemId, 
          name: itemName, 
          price: itemPrice,
          quantity: 1
        });
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
      }
    }

    // Add all visible items to cart
    function addAllToCart() {
      const visibleItems = document.querySelectorAll('.listing');
      let addedCount = 0;
      
      visibleItems.forEach(listing => {
        if (listing.style.display !== 'none') {
          const button = listing.querySelector('.add-to-cart');
          if (button) {
            const itemId = button.dataset.id;
            const itemName = button.dataset.name;
            const itemPrice = parseFloat(button.dataset.price);
            
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItem = cart.find(item => item.id == itemId);
            
            if (!existingItem) {
              cart.push({ 
                id: itemId, 
                name: itemName, 
                price: itemPrice,
                quantity: 1
              });
              addedCount++;
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
          }
        }
      });
      
      updateCartCount();
      
      if (addedCount > 0) {
        showNotification(`${addedCount} item(s) added to your cart!`);
      } else {
        showNotification('All visible items are already in your cart!', 'info');
      }
    }

    // Update cart count display
    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      if (cartCount) {
        cartCount.textContent = cart.length;
        cartCount.classList.add('pulse');
        setTimeout(() => {
          cartCount.classList.remove('pulse');
        }, 500);
      }
    }

    // Show notification
    function showNotification(message, type = 'success') {
      notificationText.textContent = message;
      
      if (type === 'success') {
        cartNotification.style.backgroundColor = '#4CAF50';
      } else {
        cartNotification.style.backgroundColor = '#2196F3';
      }
      
      cartNotification.classList.add('show');
      
      setTimeout(() => {
        cartNotification.classList.remove('show');
      }, 3000);
    }

    // Initialize filter on page load
    filterListings();
  </script>
</body>
</html>
<?php
  // Include footer
  require_once 'footer.php';
?>