<?php
// Start session to check login status
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

$pageTitle = "Upload Resource | CampusShare";
$pageDescription = "Upload your academic resources for rent or sale to the college community.";
require_once 'header.php';
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo "
    <div style='
        padding:12px 20px;
        background-color:#d4edda;
        color:#155724;
        border:1px solid #c3e6cb;
        border-radius:6px;
        margin:15px 0;
        font-weight:500;
    '>
        ✅ Listing uploaded successfully!
    </div>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Resource | CampusShare</title>
  <meta name="description" content="Upload your academic resources for rent or sale to the college community.">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Consistent with homepage styles */
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

    h1, h2, h3, h4 {
      font-weight: 600;
      color: var(--primary-color);
    }

    /* Header - Consistent with homepage */
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

    /* Main Content */
    .container {
      max-width: 1200px;
      margin: 3rem auto;
      padding: 0 2rem;
    }

    .page-header {
      text-align: center;
      margin-bottom: 3rem;
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

    /* Upload Form */
    .upload-container {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 2rem;
    }

    .upload-form {
      background-color: var(--white);
      padding: 2.5rem;
      border-radius: 12px;
      box-shadow: var(--shadow);
    }

    .form-group {
      margin-bottom: 1.8rem;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.6rem;
      font-weight: 600;
      color: var(--primary-color);
    }

    .form-control {
      width: 100%;
      padding: 0.9rem 1.2rem;
      border: 2px solid var(--gray-light);
      border-radius: 8px;
      font-size: 1rem;
      transition: var(--transition);
      font-family: inherit;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 3px rgba(0, 102, 153, 0.1);
    }

    textarea.form-control {
      min-height: 120px;
      resize: vertical;
      line-height: 1.5;
    }

    .file-upload {
      position: relative;
      margin-bottom: 1.8rem;
    }

    .file-upload-input {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }

    .file-upload-label {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2.5rem;
      border: 2px dashed var(--gray-light);
      border-radius: 8px;
      text-align: center;
      transition: var(--transition);
      background-color: #fafafa;
    }

    .file-upload-label:hover {
      border-color: var(--secondary-color);
      background-color: #f5f9ff;
    }

    .file-upload-label.dragover {
      border-color: var(--secondary-color);
      background-color: #e6f2ff;
    }

    .file-upload-label i {
      font-size: 2.5rem;
      color: var(--secondary-color);
      margin-bottom: 1rem;
    }

    .file-upload-label span {
      color: #666;
      margin-bottom: 0.5rem;
    }

    .file-upload-label small {
      color: #999;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 2.5rem;
    }

    .btn-submit {
      background: linear-gradient(135deg, var(--secondary-color), #0088cc);
      color: var(--white);
      border: none;
      padding: 0.9rem 2rem;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 600;
      box-shadow: 0 4px 8px rgba(0, 102, 153, 0.3);
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 102, 153, 0.4);
    }

    .btn-submit:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .btn-cancel {
      background-color: transparent;
      color: var(--secondary-color);
      border: 2px solid var(--secondary-color);
      padding: 0.9rem 2rem;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 600;
    }

    .btn-cancel:hover {
      background-color: var(--gray-light);
    }

    /* Form Tips */
    .form-tips {
      background-color: var(--white);
      padding: 2.5rem;
      border-radius: 12px;
      box-shadow: var(--shadow);
      height: fit-content;
      position: sticky;
      top: 20px;
    }

    .form-tips h3 {
      margin-bottom: 1.8rem;
      color: var(--primary-color);
      display: flex;
      align-items: center;
      gap: 0.8rem;
      font-size: 1.3rem;
    }

    .form-tips h3 i {
      color: var(--accent-color);
    }

    .form-tips ul {
      padding-left: 1.5rem;
    }

    .form-tips li {
      margin-bottom: 1.2rem;
      color: #666;
      position: relative;
      line-height: 1.5;
    }

    .form-tips li::before {
      content: '';
      position: absolute;
      left: -1.5rem;
      top: 0.5rem;
      width: 8px;
      height: 8px;
      background-color: var(--accent-color);
      border-radius: 50%;
    }

    /* Pricing Options */
    .pricing-options {
      margin-top: 1.8rem;
      border-top: 1px solid var(--gray-light);
      padding-top: 1.8rem;
    }

    .pricing-options h4 {
      margin-bottom: 1.2rem;
      color: var(--primary-color);
      font-size: 1.1rem;
    }

    .price-type-selector {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.2rem;
    }

    .price-type-btn {
      flex: 1;
      padding: 1rem;
      border: 2px solid var(--gray-light);
      border-radius: 8px;
      text-align: center;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 500;
    }

    .price-type-btn.active {
      border-color: var(--secondary-color);
      background-color: rgba(0, 102, 153, 0.1);
      color: var(--secondary-color);
    }

    /* Rental-specific fields */
    .rental-fields {
      display: block;
      margin-top: 1.2rem;
      animation: fadeIn 0.3s ease;
    }

    /* Image preview styles */
    .preview-container {
      display: none;
      margin-top: 1.5rem;
    }

    .image-previews {
      display: flex;
      gap: 0.8rem;
      flex-wrap: wrap;
      margin-top: 0.8rem;
    }

    .image-preview {
      width: 100px;
      height: 100px;
      border-radius: 8px;
      overflow: hidden;
      position: relative;
      box-shadow: var(--shadow);
    }

    .image-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .remove-image {
      position: absolute;
      top: 5px;
      right: 5px;
      background-color: rgba(255, 107, 107, 0.8);
      color: white;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 0.8rem;
      transition: var(--transition);
    }

    .remove-image:hover {
      background-color: var(--accent-color);
      transform: scale(1.1);
    }

    /* Progress bar */
    .progress-bar {
      height: 6px;
      background-color: var(--gray-light);
      border-radius: 3px;
      margin-top: 1rem;
      overflow: hidden;
      display: none;
    }

    .progress {
      height: 100%;
      background: linear-gradient(to right, var(--secondary-color), var(--accent-color));
      width: 0%;
      transition: width 0.3s ease;
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
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes modalFadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    /* Form validation styles */
    .form-control.error {
      border-color: #dc3545;
    }

    .error-message {
      color: #dc3545;
      font-size: 0.85rem;
      margin-top: 0.5rem;
      display: none;
    }

    .form-group.has-error .error-message {
      display: block;
    }

    .char-count {
      font-size: 0.85rem;
      color: #999;
      text-align: right;
      margin-top: 0.5rem;
    }

    .char-count.near-limit {
      color: #ffc107;
    }

    .char-count.over-limit {
      color: #dc3545;
    }

    /* Responsive Adjustments */
    @media (max-width: 968px) {
      .upload-container {
        grid-template-columns: 1fr;
      }
      
      .upload-form {
        padding: 2rem;
      }
      
      .form-tips {
        position: static;
      }
    }

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
      
      .upload-form {
        padding: 1.5rem;
      }
      
      .form-actions {
        flex-direction: column;
      }
      
      .btn-submit, .btn-cancel {
        width: 100%;
      }
      
      .price-type-selector {
        flex-direction: column;
      }
      
      .page-header h2 {
        font-size: 2rem;
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
    /* Success message style */
    .alert-success {
  padding: 10px 15px;
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
  border-radius: 5px;
  margin-bottom: 15px;
  font-weight: bold;
}

  </style>
</head>
<body>

  <div class="container">
    <div class="page-header">
      <h2>Share Your Resources</h2>
      <p>List your textbooks, notes, or equipment for rent or sale to help fellow students while earning some extra money.</p>
    </div>

    <div class="upload-container">
      <form class="upload-form" action="upload_thankyou.php" method="post" enctype="multipart/form-data" id="resourceForm">
        <input type="hidden" id="listing_type" name="listing_type" value="rent">
        
        <div class="form-group">
          <label for="title">Resource Title*</label>
          <input type="text" id="title" name="title" class="form-control" placeholder="e.g. Python Programming Textbook (3rd Edition)" required maxlength="100">
          <div class="char-count" id="title-char-count">0/100</div>
          <div class="error-message" id="title-error">Please enter a descriptive title (5-100 characters)</div>
        </div>

        <div class="form-group">
          <label for="category">Category*</label>
          <select id="category" name="category" class="form-control" required>
            <option value="" disabled selected>Select a category</option>
            <option value="textbooks">Textbooks</option>
            <option value="electronics">Electronics</option>
            <option value="notes">Study Notes</option>
            <option value="lab_equipment">Lab Equipment</option>
            <option value="sports">Sports Gear</option>
            <option value="other">Other Resources</option>
          </select>
          <div class="error-message" id="category-error">Please select a category</div>
        </div>

        <div class="form-group">
          <label for="description">Description*</label>
          <textarea id="description" name="description" class="form-control" placeholder="Provide details about condition, edition, specifications, etc. Be as detailed as possible to attract more interest." required maxlength="500"></textarea>
          <div class="char-count" id="desc-char-count">0/500</div>
          <div class="error-message" id="desc-error">Please provide a detailed description (20-500 characters)</div>
        </div>

        <div class="pricing-options">
          <h4>Pricing Options</h4>
          <div class="price-type-selector">
            <div class="price-type-btn active" data-type="rent">
              <i class="fas fa-calendar-alt"></i> For Rent
            </div>
            <div class="price-type-btn" data-type="sale">
              <i class="fas fa-tag"></i> For Sale
            </div>
          </div>
          
          <div class="form-group">
            <label for="price">Price (₹)*</label>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
              <input type="number" id="price" name="price" class="form-control" placeholder="e.g. 180" min="0" step="1" required>
              <span id="price-period">/week</span>
            </div>
            <div class="error-message" id="price-error">Please enter a valid price</div>
          </div>
          
          <div class="rental-fields" id="rental-fields">
            <div class="form-group">
              <label for="min_rental_period">Minimum Rental Period (weeks)*</label>
              <input type="number" id="min_rental_period" name="min_rental_period" class="form-control" placeholder="e.g. 2" min="1" value="1" required>
              <div class="error-message" id="rental-period-error">Please enter a valid rental period</div>
            </div>
            
            <div class="form-group">
              <label for="deposit">Security Deposit (₹)</label>
              <input type="number" id="deposit" name="deposit" class="form-control" placeholder="e.g. 500" min="0">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Upload Images* (Max 5)</label>
          <div class="file-upload">
            <input type="file" id="image" name="image[]" class="file-upload-input" accept="image/*" multiple required>
            <label for="image" class="file-upload-label" id="file-upload-label">
              <i class="fas fa-cloud-upload-alt"></i>
              <span>Click to upload or drag and drop</span>
              <small>JPEG or PNG, max 5MB each</small>
            </label>
          </div>
          <div class="progress-bar" id="progress-bar">
            <div class="progress" id="progress"></div>
          </div>
          <div class="preview-container" id="preview-container">
            <div class="image-previews" id="image-previews"></div>
          </div>
          <div class="error-message" id="image-error">Please upload at least one image (max 5)</div>
        </div>

        <div class="form-group">
          <label for="contact">Contact Information*</label>
          <input type="text" id="contact" name="contact" class="form-control" placeholder="Email or phone number" required>
          <div class="error-message" id="contact-error">Please provide valid contact information</div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn-cancel">Cancel</button>
          <button type="submit" class="btn-submit" id="submit-btn">
            <i class="fas fa-paper-plane"></i> Submit Listing
          </button>
        </div>
      </form>

      <div class="form-tips">
        <h3><i class="fas fa-lightbulb"></i> Listing Tips</h3>
        <ul>
          <li><strong>Clear titles work best</strong> - Include key details like subject, edition, or model number</li>
          <li><strong>High-quality photos</strong> - Show the actual item from multiple angles in good lighting</li>
          <li><strong>Honest condition reports</strong> - Note any wear and tear to avoid disputes later</li>
          <li><strong>Competitive pricing</strong> - Check similar listings to set a fair price</li>
          <li><strong>Detailed descriptions</strong> - Include pickup location, availability, and any included accessories</li>
          <li><strong>Fast response</strong> - Students often contact multiple sellers - reply quickly to secure the deal</li>
        </ul>
        
        <div style="margin-top: 2rem; padding: 1.2rem; background-color: var(--light-color); border-radius: 8px;">
          <h4 style="margin-bottom: 0.8rem; color: var(--primary-color); display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-chart-line"></i> Why list on CampusShare?
          </h4>
          <p style="color: #666; font-size: 0.9rem; line-height: 1.5;">
            Our platform connects you directly with verified students in your college, ensuring safe and convenient transactions. 
            On average, sellers earn ₹2000-5000 per semester by renting out their unused resources.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="notification" id="notification">
    <i class="fas fa-info-circle"></i>
    <span id="notification-text"></span>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // DOM Elements
      const form = document.getElementById('resourceForm');
      const notification = document.getElementById('notification');
      const notificationText = document.getElementById('notification-text');
      const fileUploadLabel = document.getElementById('file-upload-label');
      const previewContainer = document.getElementById('preview-container');
      const imagePreviews = document.getElementById('image-previews');
      const progressBar = document.getElementById('progress-bar');
      const progress = document.getElementById('progress');
      const submitBtn = document.getElementById('submit-btn');
      
      // Check if user is logged in (using PHP session)
      function isLoggedIn() {
        return <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
      }

      // Show notification
      function showNotification(message, type) {
        notification.className = `notification ${type} show`;
        notificationText.textContent = message;
        
        setTimeout(() => {
          notification.classList.remove('show');
        }, 5000);
      }

      // Show login modal
      function showLoginModal() {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
          <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3 class="modal-title">Login Required</h3>
            <p>You need to be logged in to submit a listing. Please login or register to continue.</p>
            <div class="modal-buttons">
              <a href="login.php" class="btn btn-primary">Login</a>
              <a href="register.php" class="btn btn-outline">Register</a>
            </div>
          </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = 'flex';
        
        modal.querySelector('.close-modal').addEventListener('click', () => {
          modal.style.display = 'none';
          setTimeout(() => modal.remove(), 300);
        });
      }

      // Update submit button state based on login status
      function updateSubmitButton() {
        if (!isLoggedIn()) {
          submitBtn.disabled = true;
          submitBtn.title = 'Please login to submit a listing';
        } else {
          submitBtn.disabled = false;
          submitBtn.title = '';
        }
      }

      // Initialize the page
      updateSubmitButton();
      initCharacterCounters();
      initFormValidation();
      
      // Add click handler to show login modal when button is disabled
      submitBtn.addEventListener('click', function(e) {
        if (!isLoggedIn()) {
          e.preventDefault();
          showLoginModal();
          showNotification('Please login to submit a listing', 'warning');
        }
      });

      // Price type toggle
      const priceTypeBtns = document.querySelectorAll('.price-type-btn');
      const pricePeriod = document.getElementById('price-period');
      const rentalFields = document.getElementById('rental-fields');
      const listingTypeInput = document.getElementById('listing_type');
      const priceInput = document.getElementById('price');
      const minRentalPeriod = document.getElementById('min_rental_period');
      const depositInput = document.getElementById('deposit');
      
      priceTypeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          priceTypeBtns.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          
          if (btn.dataset.type === 'rent') {
            // Switch to rent mode
            listingTypeInput.value = 'rent';
            pricePeriod.textContent = '/week';
            priceInput.placeholder = 'e.g. 180';
            rentalFields.style.display = 'block';
            minRentalPeriod.required = true;
          } else {
            // Switch to sale mode
            listingTypeInput.value = 'sale';
            pricePeriod.textContent = '';
            priceInput.placeholder = 'e.g. 1200';
            rentalFields.style.display = 'none';
            minRentalPeriod.required = false;
          }
        });
      });

      // Image upload functionality with drag and drop
      const fileInput = document.getElementById('image');
      
      // Drag and drop events
      fileUploadLabel.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
      });
      
      fileUploadLabel.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
      });
      
      fileUploadLabel.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        if (e.dataTransfer.files.length > 0) {
          fileInput.files = e.dataTransfer.files;
          handleFileSelection();
        }
      });
      
      fileInput.addEventListener('change', handleFileSelection);
      
      function handleFileSelection() {
        previewContainer.style.display = 'block';
        imagePreviews.innerHTML = '';
        
        if (fileInput.files && fileInput.files.length > 0) {
          // Limit to 5 files
          const files = Array.from(fileInput.files).slice(0, 5);
          
          // Simulate upload progress
          simulateUploadProgress();
          
          files.forEach((file, index) => {
            // Check file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
              showNotification(`File ${file.name} exceeds 5MB limit`, 'error');
              return;
            }
            
            // Check file type
            if (!file.type.match('image.*')) {
              showNotification(`File ${file.name} is not an image`, 'error');
              return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
              const preview = document.createElement('div');
              preview.className = 'image-preview';
              
              const img = document.createElement('img');
              img.src = e.target.result;
              
              const removeBtn = document.createElement('div');
              removeBtn.className = 'remove-image';
              removeBtn.innerHTML = '<i class="fas fa-times"></i>';
              removeBtn.addEventListener('click', function() {
                preview.remove();
                // Remove file from input
                const newFiles = Array.from(fileInput.files).filter((f, i) => i !== index);
                const dataTransfer = new DataTransfer();
                newFiles.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;
                
                if (fileInput.files.length === 0) {
                  previewContainer.style.display = 'none';
                }
              });
              
              preview.appendChild(img);
              preview.appendChild(removeBtn);
              imagePreviews.appendChild(preview);
            }
            
            reader.readAsDataURL(file);
          });
        }
      }
      
      function simulateUploadProgress() {
        progressBar.style.display = 'block';
        let width = 0;
        
        const interval = setInterval(() => {
          if (width >= 100) {
            clearInterval(interval);
            setTimeout(() => {
              progressBar.style.display = 'none';
            }, 500);
          } else {
            width += 5;
            progress.style.width = width + '%';
          }
        }, 100);
      }

      // Cancel button functionality
      document.querySelector('.btn-cancel').addEventListener('click', function() {
        if (confirm('Are you sure you want to cancel? All unsaved changes will be lost.')) {
          window.location.href = 'index.php';
        }
      });

      // Character counters
      function initCharacterCounters() {
        const titleInput = document.getElementById('title');
        const titleCharCount = document.getElementById('title-char-count');
        const descInput = document.getElementById('description');
        const descCharCount = document.getElementById('desc-char-count');
        
        titleInput.addEventListener('input', function() {
          const length = this.value.length;
          titleCharCount.textContent = `${length}/100`;
          
          if (length > 90) {
            titleCharCount.className = 'char-count near-limit';
          } else {
            titleCharCount.className = 'char-count';
          }
        });
        
        descInput.addEventListener('input', function() {
          const length = this.value.length;
          descCharCount.textContent = `${length}/500`;
          
          if (length > 450) {
            descCharCount.className = 'char-count near-limit';
          } else if (length > 500) {
            descCharCount.className = 'char-count over-limit';
          } else {
            descCharCount.className = 'char-count';
          }
        });
      }
      
      // Form validation
      function initFormValidation() {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
          input.addEventListener('blur', function() {
            validateField(this);
          });
          
          input.addEventListener('input', function() {
            clearFieldError(this);
          });
        });
      }
      
      function validateField(field) {
        clearFieldError(field);
        
        let isValid = true;
        let errorMessage = '';
        
        switch(field.id) {
          case 'title':
            if (field.value.trim().length < 5) {
              isValid = false;
              errorMessage = 'Title must be at least 5 characters long';
            }
            break;
            
          case 'category':
            if (!field.value) {
              isValid = false;
              errorMessage = 'Please select a category';
            }
            break;
            
          case 'description':
            if (field.value.trim().length < 20) {
              isValid = false;
              errorMessage = 'Description must be at least 20 characters long';
            }
            break;
            
          case 'price':
            if (!field.value || isNaN(field.value) || parseFloat(field.value) <= 0) {
              isValid = false;
              errorMessage = 'Please enter a valid price';
            }
            break;
            
          case 'min_rental_period':
            if (listingTypeInput.value === 'rent' && (!field.value || isNaN(field.value) || parseInt(field.value) <= 0)) {
              isValid = false;
              errorMessage = 'Please enter a valid rental period';
            }
            break;
            
          case 'image':
            if (field.files.length === 0) {
              isValid = false;
              errorMessage = 'Please upload at least one image';
            } else if (field.files.length > 5) {
              isValid = false;
              errorMessage = 'Maximum 5 images allowed';
            }
            break;
            
          case 'contact':
            if (field.value.trim().length < 3) {
              isValid = false;
              errorMessage = 'Please provide valid contact information';
            }
            break;
        }
        
        if (!isValid) {
          showFieldError(field, errorMessage);
        }
        
        return isValid;
      }
      
      function showFieldError(field, message) {
        const formGroup = field.closest('.form-group');
        formGroup.classList.add('has-error');
        
        const errorElement = document.getElementById(`${field.id}-error`);
        if (errorElement) {
          errorElement.textContent = message;
          errorElement.style.display = 'block';
        }
        
        field.classList.add('error');
      }
      
      function clearFieldError(field) {
        const formGroup = field.closest('.form-group');
        formGroup.classList.remove('has-error');
        
        const errorElement = document.getElementById(`${field.id}-error`);
        if (errorElement) {
          errorElement.style.display = 'none';
        }
        
        field.classList.remove('error');
      }
      
      function validateForm() {
        let isValid = true;
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
          if (!validateField(input)) {
            isValid = false;
          }
        });
        
        return isValid;
      }
      
      // Form submission
      form.addEventListener('submit', function(e) {
        if (!isLoggedIn()) {
          e.preventDefault();
          showLoginModal();
          showNotification('Please login to submit a listing', 'warning');
          return;
        }
        
        if (!validateForm()) {
          e.preventDefault();
          showNotification('Please fix the errors in the form', 'error');
          // Scroll to first error
          const firstError = form.querySelector('.has-error');
          if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
          return;
        }
        
        // If all validations pass, show success message and allow submission
        showNotification('Your listing is being submitted...', 'success');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
      });
    });
  </script>
</body>
</html>
<?php require_once 'footer.php'; ?>