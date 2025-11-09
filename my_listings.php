<?php
$pageTitle = "My Listings | CampusShare";
$pageDescription = "Manage your academic resource listings on CampusShare";
require_once 'header.php';

require 'connection.php';
$conn = Connect();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user's listings
$query = "SELECT * FROM upload WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error . "<br>SQL: " . $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings | CampusShare</title>
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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
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
        }

        .page-header {
            margin-bottom: 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .page-header h2 {
            font-size: 2.2rem;
            color: var(--primary-color);
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .page-header h2::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            bottom: -10px;
            left: 0;
            border-radius: 2px;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
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

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary-color), #0088cc);
            color: var(--white);
            box-shadow: 0 4px 8px rgba(0, 102, 153, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 102, 153, 0.4);
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 1.2rem;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-icon.primary {
            background-color: rgba(0, 102, 153, 0.1);
            color: var(--secondary-color);
        }

        .stat-icon.success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .stat-icon.warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .stat-info p {
            color: #666;
            font-size: 0.9rem;
        }

        .listings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .listing-card {
            background-color: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }

        .listing-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .listing-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .status-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .status-sold {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        .listing-image {
            height: 200px;
            overflow: hidden;
            background: linear-gradient(45deg, #f2f6fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .listing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .listing-card:hover .listing-image img {
            transform: scale(1.05);
        }

        .no-image {
            color: #ccc;
            font-size: 3rem;
        }

        .listing-content {
            padding: 1.5rem;
        }

        .listing-content h3 {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: var(--primary-color);
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
            -webkit-line-clamp: 2;
            line-clamp: 2;
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

        .btn-edit {
            background: linear-gradient(135deg, var(--secondary-color), #0088cc);
            color: var(--white);
            box-shadow: 0 3px 6px rgba(0, 102, 153, 0.2);
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 102, 153, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--danger-color), #c82333);
            color: var(--white);
            box-shadow: 0 3px 6px rgba(220, 53, 69, 0.2);
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(220, 53, 69, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
            grid-column: 1 / -1;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: #ccc;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transform: translateX(120%);
            transition: transform 0.3s ease;
            z-index: 1000;
            max-width: 350px;
            box-shadow: var(--shadow-hover);
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .notification.error {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
        }

        .notification.warning {
            background: linear-gradient(135deg, #ffc107, #ff922b);
            color: #212529;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            padding: 2.5rem;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            position: relative;
            box-shadow: var(--shadow-hover);
            animation: modalFadeIn 0.3s ease;
        }

        .close-modal {
            position: absolute;
            top: 1.2rem;
            right: 1.2rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--accent-color);
        }

        .modal-title {
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: flex-end;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-actions {
                width: 100%;
                justify-content: center;
            }
            
            .stats-cards {
                grid-template-columns: 1fr;
            }
            
            .listings-grid {
                grid-template-columns: 1fr;
            }
            
            .listing-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .btn-sm {
                width: 100%;
                text-align: center;
            }
        }

        /* Footer */
    footer {
      background-color: var(--primary-color);
      color: var(--white);
      padding: 2rem 1rem 1rem;
      position: relative;
    }

    .footer-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer-column h3 {
      color: var(--white);
      margin-bottom: 1rem;
      font-size: 1.1rem;
    }

    .footer-links {
      list-style: none;
    }

    .footer-links li {
      margin-bottom: 0.5rem;
    }

    .footer-links a {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: var(--transition);
      font-size: 0.9rem;
    }

    .footer-links a:hover {
      color: var(--accent-color);
      padding-left: 5px;
    }

    .social-links {
      display: flex;
      gap: 0.8rem;
      margin-top: 1rem;
    }

    .social-links a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 35px;
      height: 35px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      color: var(--white);
      transition: var(--transition);
      font-size: 0.9rem;
    }

    .social-links a:hover {
      background-color: var(--accent-color);
      transform: translateY(-3px);
    }

    .newsletter-form {
      display: flex;
      margin-top: 1rem;
    }

    .newsletter-form input {
      flex: 1;
      padding: 0.6rem;
      border: none;
      border-radius: 4px 0 0 4px;
      font-size: 0.9rem;
    }

    .newsletter-form button {
      padding: 0 0.8rem;
      background-color: var(--accent-color);
      color: var(--white);
      border: none;
      border-radius: 0 4px 4px 0;
      cursor: pointer;
      transition: var(--transition);
      font-size: 0.9rem;
    }

    .newsletter-form button:hover {
      background-color: #e05555;
    }

    .footer-bottom {
      text-align: center;
      padding-top: 1.5rem;
      margin-top: 1.5rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      font-size: 0.8rem;
      opacity: 0.8;
    }
    </style>
</head>
<body> 
    <div class="container">
        <div class="page-header">
            <h2>My Listings</h2>
            <div class="header-actions">
                <a href="upload.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Listing
                </a>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        </div>

        <?php 
        $totalListings = $result->num_rows;
        $activeListings = $totalListings; // You can add status field to your database
        $soldListings = 0; // You can add sold status to your database
        ?>
        
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalListings; ?></h3>
                    <p>Total Listings</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $activeListings; ?></h3>
                    <p>Active Listings</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $soldListings; ?></h3>
                    <p>Items Sold/Rented</p>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="notification success show" id="success-notification">
                <i class="fas fa-check-circle"></i>
                <span><?php echo htmlspecialchars(urldecode($_GET['success'])); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="notification error show" id="error-notification">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <div class="listings-grid">
                <?php while ($listing = $result->fetch_assoc()): 
                    // Determine status (you can add this field to your database)
                    $status = 'active';
                    $statusClass = 'status-active';
                    $statusText = 'Active';
                    
                    // Get image if available
                    $hasImage = !empty($listing['image']);
                    $imageContent = $hasImage ? 'get_image.php?id=' . $listing['id'] : '';
                    
                    // Format price
                    $price = '₹' . $listing['price'];
                    if ($listing['price'] == 0) {
                        $price = 'Free';
                    }
                ?>
                    <div class="listing-card" data-id="<?php echo $listing['id']; ?>">
                        <div class="listing-status <?php echo $statusClass; ?>">
                            <?php echo $statusText; ?>
                        </div>
                        
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
                                <span class="listing-category"><?php echo ucfirst(str_replace('_', ' ', $listing['category'])); ?></span>
                                <span class="listing-date"><?php echo date('M j, Y', strtotime($listing['created_at'])); ?></span>
                            </div>
                            
                            <div class="listing-price"><?php echo $price; ?></div>
                            
                            <div class="listing-desc">
                                <?php 
                                $description = !empty($listing['description']) ? $listing['description'] : 'No description available.';
                                echo htmlspecialchars($description);
                                ?>
                            </div>
                            
                            <div class="listing-footer">
                                <div class="listing-actions">
                                    <a href="edit_listing.php?id=<?php echo $listing['id']; ?>" class="btn btn-edit btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="delete_listing.php" method="POST" class="delete-form">
                                        <input type="hidden" name="id" value="<?php echo $listing['id']; ?>">
                                        <button type="button" class="btn btn-delete btn-sm delete-btn">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No Listings Yet</h3>
                <p>You haven't created any listings yet. Start sharing your resources with the campus community!</p>
                <a href="upload.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Your First Listing
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="delete-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3 class="modal-title">Confirm Deletion</h3>
            <p>Are you sure you want to delete this listing? This action cannot be undone.</p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" id="cancel-delete">Cancel</button>
                <button class="btn btn-delete" id="confirm-delete">Delete Listing</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide notifications after 5 seconds
            setTimeout(() => {
                const notifications = document.querySelectorAll('.notification.show');
                notifications.forEach(notification => {
                    notification.classList.remove('show');
                    setTimeout(() => notification.remove(), 300);
                });
            }, 5000);
            
            // Delete confirmation modal
            const deleteModal = document.getElementById('delete-modal');
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const cancelDelete = document.getElementById('cancel-delete');
            const confirmDelete = document.getElementById('confirm-delete');
            let currentForm = null;
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    currentForm = this.closest('.delete-form');
                    deleteModal.style.display = 'flex';
                });
            });
            
            cancelDelete.addEventListener('click', function() {
                deleteModal.style.display = 'none';
                currentForm = null;
            });
            
            confirmDelete.addEventListener('click', function() {
                if (currentForm) {
                    currentForm.submit();
                }
            });
            
            // Close modal when clicking on X
            document.querySelector('.close-modal').addEventListener('click', function() {
                deleteModal.style.display = 'none';
                currentForm = null;
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === deleteModal) {
                    deleteModal.style.display = 'none';
                    currentForm = null;
                }
            });
            
            // Add animation to listing cards
            const listingCards = document.querySelectorAll('.listing-card');
            listingCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.style.animation = 'fadeIn 0.5s ease forwards';
            });
        });
    </script>
</body>
</html>

<?php require_once 'footer.php'; ?>