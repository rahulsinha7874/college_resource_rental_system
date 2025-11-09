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
  <title>Login | CampusShare</title>
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

    .auth-form input {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--gray-light);
      border-radius: 4px;
      font-size: 1rem;
      transition: var(--transition);
    }

    .auth-form input:focus {
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

    .remember-forgot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .remember-me {
      display: flex;
      align-items: center;
    }

    .remember-me input {
      width: auto;
      margin-right: 0.5rem;
      margin-top: 0.25rem;
    }

    .forgot-password {
      color: var(--secondary-color);
      text-decoration: none;
      font-size: 0.9rem;
    }

    .forgot-password:hover {
      text-decoration: underline;
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

    /* Success and error message styling */
    .success-message {
      background-color: #e8f5e9;
      color: #2e7d32;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 15px;
      text-align: center;
    }

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
      <h2>Welcome Back!</h2>
      <p>Login to access your CampusShare account</p>
    </div>

    <?php if (isset($_GET['success'])): ?>
      <div class="success-message">
        <?php echo htmlspecialchars(urldecode($_GET['success'])); ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
      <div class="error-message">
        <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
      </div>
    <?php endif; ?>

    <form class="auth-form" action="login_thankyou.php" method="POST">
      <div class="form-group">
        <label for="email">Email Address</label>
        <div class="input-with-icon">
          <input type="email" id="email" name="email" placeholder="Enter your college email" required>
          <i class="fas fa-envelope"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-with-icon">
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-lock"></i>
        </div>
      </div>

      <div class="remember-forgot">
        <div class="remember-me">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember">Remember me</label>
        </div>
        <a href="forgot-password.php" class="forgot-password">Forgot password?</a>
      </div>

      <button type="submit" class="btn btn-primary">Login</button>

      <div class="divider">or continue with</div>

      <div class="social-login">
        <button type="button" class="social-btn google">
          <i class="fab fa-google"></i> Google
        </button>
        <button type="button" class="social-btn facebook">
          <i class="fab fa-facebook-f"></i> Facebook
        </button>
      </div>

      <div class="auth-footer">
        Don't have an account? <a href="register.php">Sign up</a>
      </div>
    </form>
  </div>
</body>
</html>
<?php require_once 'footer.php'; ?>