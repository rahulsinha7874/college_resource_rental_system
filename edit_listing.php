<?php
session_start();
require 'connection.php';
$conn = Connect();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: my_listings.php");
    exit();
}

$listing_id = intval($_GET['id']);

// Verify ownership
$check_query = $conn->prepare("SELECT * FROM upload WHERE id = ? AND user_id = ?");
$check_query->bind_param("ii", $listing_id, $user_id);
$check_query->execute();
$result = $check_query->get_result();

if ($result->num_rows === 0) {
    header("Location: my_listings.php?error=Not+authorized");
    exit();
}

$listing = $result->fetch_assoc();
$message = "";

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $contact = trim($_POST['contact']);

    $query = $conn->prepare("UPDATE upload 
                             SET title=?, category=?, description=?, price=?, contact=? 
                             WHERE id=?");
    $query->bind_param("ssssdi", $title, $category, $description, $price, $contact, $listing_id);

    if ($query->execute()) {
        header("Location: my_listings.php?success=Listing+updated");
        exit();
    } else {
        $message = "Error updating listing: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing | CampusShare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

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

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .edit-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn-cancel {
            padding: 0.75rem 1.5rem;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .btn-submit {
            padding: 0.75rem 1.5rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-submit:hover {
            background-color: #0069d9;
        }
        
        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
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
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="edit-container">
        <h2>Edit Listing</h2>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="title">Resource Title*</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($listing['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="category">Category*</label>
                <select id="category" name="category" required>
                    <option value="textbooks" <?php echo $listing['category'] == 'textbooks' ? 'selected' : ''; ?>>Textbooks</option>
                    <option value="electronics" <?php echo $listing['category'] == 'electronics' ? 'selected' : ''; ?>>Electronics</option>
                    <option value="notes" <?php echo $listing['category'] == 'notes' ? 'selected' : ''; ?>>Study Notes</option>
                    <option value="lab_equipment" <?php echo $listing['category'] == 'lab_equipment' ? 'selected' : ''; ?>>Lab Equipment</option>
                    <option value="sports" <?php echo $listing['category'] == 'sports' ? 'selected' : ''; ?>>Sports Gear</option>
                    <option value="other" <?php echo $listing['category'] == 'other' ? 'selected' : ''; ?>>Other Resources</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description*</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($listing['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price (₹)*</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($listing['price']); ?>" min="0" step="1" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact Information*</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($listing['contact']); ?>" required>
            </div>

            <div class="form-actions">
                <a href="my_listings.php" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Update Listing</button>
            </div>
        </form>
    </div>
    
    <?php include 'footer.php'; ?>
    
</body>
</html>