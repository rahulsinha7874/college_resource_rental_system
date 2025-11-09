<?php
$pageTitle = "College Resource Rental System | Student Marketplace";
$pageDescription = "Rent or sell academic resources including books, electronics, and study materials within your college community.";
require_once 'header.php';

// If user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | CampusShare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Your existing CSS styles here */
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

    /* Auth Container */
    .auth-container {
      max-width: 500px;
      margin: 3rem auto;
      padding: 2rem;
      background-color: var(--white);
      border-radius: 8px;
      box-shadow: var(--shadow);
    }

    .auth-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .auth-header h2 {
      color: var(--primary-color);
      margin-bottom: 0.5rem;
    }

    .auth-header p {
      color: #666;
    }

    .auth-form .form-group {
      margin-bottom: 1.5rem;
    }

    .auth-form label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--dark-color);
    }

    .auth-form input, .auth-form select {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--gray-light);
      border-radius: 4px;
      font-size: 1rem;
      transition: var(--transition);
    }

    .auth-form input:focus, .auth-form select:focus {
      outline: none;
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 3px rgba(0, 102, 153, 0.1);
    }

    .input-with-icon {
      position: relative;
    }

    .input-with-icon i {
      position: absolute;
      top: 50%;
      right: 1rem;
      transform: translateY(-50%);
      color: #999;
    }

    .name-fields {
      display: flex;
      gap: 1rem;
    }

    .name-fields .form-group {
      flex: 1;
    }

    .btn {
      padding: 0.75rem 1.5rem;
      border-radius: 4px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      text-decoration: none;
      display: inline-block;
      width: 100%;
      text-align: center;
      font-size: 1rem;
    }

    .btn-primary {
      background-color: var(--accent-color);
      color: var(--white);
      border: 2px solid var(--accent-color);
    }

    .btn-primary:hover {
      background-color: #e05555;
      border-color: #e05555;
    }

    .terms {
      display: flex;
      align-items: flex-start;
      margin-bottom: 1.5rem;
    }

    .terms input {
      width: auto;
      margin-right: 0.75rem;
      margin-top: 0.25rem;
    }

    .terms label {
      font-size: 0.9rem;
      color: #666;
    }

    .terms a {
      color: var(--secondary-color);
      text-decoration: none;
    }

    .terms a:hover {
      text-decoration: underline;
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 1.5rem 0;
      color: #999;
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid var(--gray-light);
    }

    .divider::before {
      margin-right: 1rem;
    }

    .divider::after {
      margin-left: 1rem;
    }

    .social-login {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .social-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0.75rem;
      border-radius: 4px;
      font-weight: 500;
      transition: var(--transition);
      border: 1px solid var(--gray-light);
      background-color: var(--white);
      color: var(--dark-color);
    }

    .social-btn i {
      margin-right: 0.75rem;
      font-size: 1.2rem;
    }

    .social-btn.google {
      color: #DB4437;
    }

    .social-btn.facebook {
      color: #4267B2;
    }

    .social-btn:hover {
      background-color: var(--light-color);
    }

    .auth-footer {
      text-align: center;
      margin-top: 1.5rem;
      color: #666;
    }

    .auth-footer a {
      color: var(--secondary-color);
      text-decoration: none;
      font-weight: 500;
    }

    .auth-footer a:hover {
      text-decoration: underline;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .auth-container {
        margin: 2rem 1rem;
        padding: 1.5rem;
      }
      
      header {
        flex-direction: column;
        padding: 1rem;
      }
      
      .logo {
        margin-bottom: 1rem;
      }
      
      .name-fields {
        flex-direction: column;
        gap: 0;
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

    /* Error message styling */
    .error-message {
      background-color: #ffebee;
      color: #c62828;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-header">
      <h2>Create Your Account</h2>
      <p>Join the CampusShare community today</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
      <div class="error-message">
        <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
      </div>
    <?php endif; ?>

    <form class="auth-form" action="register_thankyou.php" method="POST" onsubmit="return validateForm()">
      <div class="name-fields">
        <div class="form-group">
          <label for="first-name">First Name</label>
          <input type="text" id="first-name" name="first_name" placeholder="First name" required>
        </div>
        <div class="form-group">
          <label for="last-name">Last Name</label>
          <input type="text" id="last-name" name="last_name" placeholder="Last name" required>
        </div>
      </div>

      <div class="form-group">
        <label for="email">College Email</label>
        <div class="input-with-icon">
          <input type="email" id="email" name="email" placeholder="your.name@college.edu" required>
          <i class="fas fa-envelope"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Create Password</label>
        <div class="input-with-icon">
          <input type="password" id="password" name="password" placeholder="At least 8 characters" required minlength="8">
          <i class="fas fa-lock"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <div class="input-with-icon">
          <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your password" required>
          <i class="fas fa-lock"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="college">College/University</label>
        <select id="college" name="college" required>
          <option value="" disabled selected>Select your institution</option>
          <option value="Indian Institute of Technology">Indian Institute of Technology</option>
          <option value="National Institute of Technology">National Institute of Technology</option>
          <option value="Delhi University">Delhi University</option>
          <option value="Mumbai University">Mumbai University</option>
          <option value="Other Institution">Other Institution</option>
        </select>
      </div>

      <div class="form-group">
        <label for="department">Department</label>
        <select id="department" name="department" required>
          <option value="" disabled selected>Select your department</option>
          <option value="Computer Science">Computer Science</option>
          <option value="Mechanical Engineering">Mechanical Engineering</option>
          <option value="Electrical Engineering">Electrical Engineering</option>
          <option value="Civil Engineering">Civil Engineering</option>
          <option value="Commerce">Commerce</option>
          <option value="Arts">Arts</option>
          <option value="Science">Science</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="terms">
        <input type="checkbox" id="terms" required>
        <label for="terms">I agree to the <a href="terms.php">Terms of Service</a> and <a href="privacy.php">Privacy Policy</a></label>
      </div>

      <button type="submit" class="btn btn-primary">Create Account</button>

      <div class="divider">or sign up with</div>

      <div class="social-login">
        <button type="button" class="social-btn google">
          <i class="fab fa-google"></i> Google
        </button>
        <button type="button" class="social-btn facebook">
          <i class="fab fa-facebook-f"></i> Facebook
        </button>
      </div>

      <div class="auth-footer">
        Already have an account? <a href="login.php">Log in</a>
      </div>
    </form>
  </div>

  <script>
    function validateForm() {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
      
      if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return false;
      }
      
      return true;
    }
  </script>
</body>
</html>
<?php require_once 'footer.php'; ?>