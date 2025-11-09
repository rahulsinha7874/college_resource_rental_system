<?php
// Start output buffering to prevent headers already sent error
ob_start();

$pageTitle = "College Resource Rental System | Student Marketplace";
$pageDescription = "Rent or sell academic resources including books, electronics, and study materials within your college community.";

// Database connection
require 'connection.php';
$conn = Connect();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Clear output buffer and redirect
    ob_end_clean();
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle profile update request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $college = $conn->real_escape_string($_POST['college']);
    $department = $conn->real_escape_string($_POST['department']);
    
    $query = "UPDATE users SET first_name='$first_name', last_name='$last_name', 
              college='$college', department='$department' WHERE id=$user_id";
    
    if ($conn->query($query)) {
        $_SESSION['user_name'] = $first_name . ' ' . $last_name;
        $_SESSION['user_college'] = $college;
        $_SESSION['user_department'] = $department;
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

// Handle password change request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verify current password
    $query = "SELECT password FROM users WHERE id=$user_id";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
    
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password='$hashed_password' WHERE id=$user_id";
            
            if ($conn->query($update_query)) {
                $message = "Password changed successfully!";
            } else {
                $message = "Error changing password: " . $conn->error;
            }
        } else {
            $message = "New passwords do not match!";
        }
    } else {
        $message = "Current password is incorrect!";
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    // Verify password before deletion
    $password = $_POST['delete_password'];
    
    $query = "SELECT password FROM users WHERE id=$user_id";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $query = "DELETE FROM users WHERE id=$user_id";
        
        if ($conn->query($query)) {
            session_destroy();
            // Clear output buffer and redirect
            ob_end_clean();
            header("Location: index.php?message=Account+deleted+successfully");
            exit();
        } else {
            $message = "Error deleting account: " . $conn->error;
        }
    } else {
        $message = "Incorrect password. Account deletion failed.";
    }
}

// Get current user data
$query = "SELECT * FROM users WHERE id=$user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Get user's listings count
$listings_query = "SELECT COUNT(*) as count FROM upload WHERE user_id=$user_id";
$listings_result = $conn->query($listings_query);
$listings_count = $listings_result->fetch_assoc()['count'];

$conn->close();

// Now we can include the header and output content
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | CampusShare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Header Styles - Matching Index Page */
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
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --gray: #6c757d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        /* Profile Page Specific Styles */
        .profile-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .profile-card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: var(--shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .profile-card h3 {
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-group input:disabled {
            background-color: #f8f9fa;
            color: var(--gray);
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: #00264d;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            color: var(--white);
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .profile-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        .message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            font-weight: 500;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .delete-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .delete-modal-content {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 8px;
            max-width: 500px;
            width: 100%;
        }
        
        .delete-modal h3 {
            margin-bottom: 1rem;
            color: var(--danger-color);
        }
        
        .delete-modal p {
            margin-bottom: 1.5rem;
        }
        
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
        
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .profile-actions {
                flex-direction: column;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
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
    
    <div class="profile-container">
        <div class="profile-header">
            <h2>Your Profile</h2>
            <a href="index.php" class="btn btn-outline">Back to Home</a>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'Error') !== false || strpos($message, 'incorrect') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number"><?php echo $listings_count; ?></div>
                <div class="stat-label">Active Listings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Items Rented</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Items Sold</div>
            </div>
        </div>
        
        <div class="profile-card">
            <h3>Personal Information</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                    <small>Email cannot be changed</small>
                </div>
                
                <div class="form-group">
                    <label for="college">College</label>
                    <input type="text" id="college" name="college" value="<?php echo htmlspecialchars($user['college']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($user['department']); ?>" required>
                </div>
                
                <div class="profile-actions">
                    <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
                    <a href="my_listings.php" class="btn btn-outline">View My Listings</a>
                </div>
            </form>
        </div>
        
        <div class="profile-card">
            <h3>Change Password</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <div class="profile-actions">
                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
        
        <div class="profile-card">
            <h3>Account Management</h3>
            <p>Once you delete your account, there is no going back. Please be certain.</p>
            
            <div class="profile-actions">
                <button type="button" id="deleteAccountBtn" class="btn btn-danger">Delete Account</button>
            </div>
        </div>
    </div>
    
    <div class="delete-modal" id="deleteModal">
        <div class="delete-modal-content">
            <h3>Confirm Account Deletion</h3>
            <p>This action cannot be undone. This will permanently delete your account and remove all your data from our servers.</p>
            <p>To confirm, please enter your password:</p>
            
            <form method="POST" id="deleteForm">
                <div class="form-group">
                    <input type="password" name="delete_password" placeholder="Enter your password" required>
                </div>
                
                <div class="modal-actions">
                    <button type="button" id="cancelDelete" class="btn btn-outline">Cancel</button>
                    <button type="submit" name="delete" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Delete account modal functionality
        const deleteModal = document.getElementById('deleteModal');
        const deleteAccountBtn = document.getElementById('deleteAccountBtn');
        const cancelDelete = document.getElementById('cancelDelete');
        const deleteForm = document.getElementById('deleteForm');
        
        deleteAccountBtn.addEventListener('click', () => {
            deleteModal.style.display = 'flex';
        });
        
        cancelDelete.addEventListener('click', () => {
            deleteModal.style.display = 'none';
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === deleteModal) {
                deleteModal.style.display = 'none';
            }
        });
        
        // Form validation
        deleteForm.addEventListener('submit', (e) => {
            const passwordInput = deleteForm.querySelector('input[name="delete_password"]');
            if (!passwordInput.value) {
                e.preventDefault();
                alert('Please enter your password to confirm account deletion.');
            }
        });
    </script>
</body>
</html>
<?php 
// End output buffering and flush content
ob_end_flush();
require_once 'footer.php'; 
?>