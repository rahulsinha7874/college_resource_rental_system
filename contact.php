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
  <title>Contact Us | CampusShare</title>
  <meta name="description" content="Get in touch with CampusShare for support, questions, or feedback about our college resource sharing platform.">
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

    /* Hero Section - Matching index page */
    .hero {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: var(--white);
      padding: 4rem 2rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    .hero h1 {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
      color: var(--white);
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      opacity: 0.9;
    }

    /* Main Content */
    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 2rem;
    }

    .contact-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 3rem;
      margin-top: 3rem;
    }

    /* Contact Info Section */
    .contact-info {
      background-color: var(--white);
      padding: 2rem;
      border-radius: 8px;
      box-shadow: var(--shadow);
    }

    .section-title {
      position: relative;
      margin-bottom: 2rem;
      padding-bottom: 0.75rem;
    }

    .section-title h2 {
      font-size: 1.8rem;
      color: var(--primary-color);
    }

    .section-title h2::after {
      content: '';
      position: absolute;
      width: 60px;
      height: 3px;
      background-color: var(--accent-color);
      bottom: 0;
      left: 0;
    }

    .contact-method {
      display: flex;
      align-items: flex-start;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .contact-icon {
      font-size: 1.5rem;
      color: var(--accent-color);
      margin-top: 0.25rem;
    }

    .contact-details h3 {
      margin-bottom: 0.5rem;
      color: var(--primary-color);
    }

    .contact-details p, .contact-details a {
      color: var(--dark-color);
      text-decoration: none;
    }

    .contact-details a:hover {
      color: var(--accent-color);
      text-decoration: underline;
    }

    /* Contact Form */
    .contact-form {
      background-color: var(--white);
      padding: 2rem;
      border-radius: 8px;
      box-shadow: var(--shadow);
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: var(--primary-color);
    }

    .form-control {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--gray-light);
      border-radius: 4px;
      font-size: 1rem;
      transition: var(--transition);
    }

    .form-control:focus {
      outline: none;
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 3px rgba(0, 102, 153, 0.1);
    }

    textarea.form-control {
      min-height: 150px;
      resize: vertical;
    }

    .submit-btn {
      background-color: var(--secondary-color);
      color: var(--white);
      border: none;
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      border-radius: 4px;
      cursor: pointer;
      transition: var(--transition);
      width: 100%;
    }

    .submit-btn:hover {
      background-color: #005580;
    }

    /* Map Section */
    .map-container {
      grid-column: 1 / -1;
      margin-top: 2rem;
    }

    .map-container iframe {
      width: 100%;
      height: 400px;
      border: none;
      border-radius: 8px;
      box-shadow: var(--shadow);
    }

    /* FAQ Section */
    .faq-section {
      grid-column: 1 / -1;
      margin-top: 3rem;
    }

    .faq-section .section-title h2 {
      text-align: center;
    }

    .faq-section .section-title h2::after {
      left: 50%;
      transform: translateX(-50%);
    }

    .faq-item {
      background-color: var(--white);
      margin-bottom: 1rem;
      border-radius: 8px;
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    .faq-question {
      padding: 1.5rem;
      background-color: var(--primary-color);
      color: var(--white);
      font-weight: 600;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .faq-question::after {
      content: '+';
      font-size: 1.5rem;
    }

    .faq-question.active::after {
      content: '-';
    }

    .faq-answer {
      padding: 0;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }

    .faq-answer.show {
      padding: 1.5rem;
      max-height: 500px;
    }

    /* Footer - Consistent with homepage */
    footer {
      background-color: var(--primary-color);
      color: var(--white);
      padding: 3rem 2rem 1.5rem;
      margin-top: 3rem;
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

    .footer-bottom {
      text-align: center;
      padding-top: 2rem;
      margin-top: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      font-size: 0.9rem;
      opacity: 0.8;
    }

    /* Responsive Adjustments */
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
      
      .hero h1 {
        font-size: 2rem;
      }
      
      .contact-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  

  <section class="hero">
    <div class="hero-content">
      <h1>Contact CampusShare</h1>
      <p>Have questions or feedback? We're here to help! Reach out to our team anytime.</p>
    </div>
  </section>

  <div class="container">
    <div class="contact-container">
      <div class="contact-info">
        <div class="section-title">
          <h2>Get In Touch</h2>
        </div>
        <p>Our team is available to assist you with any questions about our platform, partnerships, or your account.</p>
        
        <div class="contact-method">
          <div class="contact-icon">
            <i class="fas fa-envelope"></i>
          </div>
          <div class="contact-details">
            <h3>Email Us</h3>
            <a href="mailto:support@campusshare.edu">support@campusshare.edu</a>
            <p>Typically responds within 24 hours</p>
          </div>
        </div>
        
        <div class="contact-method">
          <div class="contact-icon">
            <i class="fas fa-phone-alt"></i>
          </div>
          <div class="contact-details">
            <h3>Call Us</h3>
            <a href="tel:+18005551234">+1 (800) 555-1234</a>
            <p>Mon-Fri: 9am-5pm EST</p>
          </div>
        </div>
        
        <div class="contact-method">
          <div class="contact-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <div class="contact-details">
            <h3>Visit Us</h3>
            <p>123 University Avenue<br>Campus Town, CT 06510</p>
          </div>
        </div>
        
        <div class="contact-method">
          <div class="contact-icon">
            <i class="fas fa-comments"></i>
          </div>
          <div class="contact-details">
            <h3>Live Chat</h3>
            <p>Available 24/7 through our mobile app</p>
            <a href="#" style="color: var(--accent-color);">Download the app</a>
          </div>
        </div>
      </div>
      
      <div class="contact-form">
        <div class="section-title">
          <h2>Send Us a Message</h2>
        </div>
        <form action="contact_thankyou.php" method="post">
          <div class="form-group">
            <label for="name">Your Name*</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
          </div>
          
          <div class="form-group">
            <label for="email">Email Address*</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
          </div>
          
          <div class="form-group">
            <label for="subject">Subject*</label>
            <select id="subject" name="subject" class="form-control" required>
              <option value="" disabled selected>Select a topic</option>
              <option value="general">General Inquiry</option>
              <option value="technical">Technical Support</option>
              <option value="feedback">Feedback/Suggestions</option>
              <option value="partnership">Partnership Opportunities</option>
              <option value="other">Other</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="message">Your Message*</label>
            <textarea id="message" name="message" class="form-control" placeholder="How can we help you?" required></textarea>
          </div>
          
          <button type="submit" class="submit-btn">
            <i class="fas fa-paper-plane"></i> Send Message
          </button>
        </form>
      </div>
      
      <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215662132365!2d-73.98784468459382!3d40.748440179327925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1629999999999!5m2!1sen!2sus" allowfullscreen="" loading="lazy"></iframe>
      </div>
      
      <div class="faq-section">
        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
        </div>
        
        <div class="faq-item">
          <div class="faq-question">How do I report an issue with a rental?</div>
          <div class="faq-answer">
            <p>If you encounter any issues with a rental, please contact us immediately through our support email or live chat. Be sure to include details about the issue and any relevant photos. Our team will work to resolve the matter promptly, typically within 24-48 hours.</p>
          </div>
        </div>
        
        <div class="faq-item">
          <div class="faq-question">What are your business hours?</div>
          <div class="faq-answer">
            <p>Our customer support team is available Monday through Friday from 9am to 5pm EST. However, you can submit inquiries through our contact form or email at any time, and we'll respond as quickly as possible. For urgent matters outside business hours, use our live chat feature in the mobile app.</p>
          </div>
        </div>
        
        <div class="faq-item">
          <div class="faq-question">How can I become a campus ambassador?</div>
          <div class="faq-answer">
            <p>We're always looking for enthusiastic students to represent CampusShare on their campuses! Send us an email with your resume and a brief explanation of why you'd be a great ambassador to <a href="mailto:ambassadors@campusshare.edu" style="color: var(--accent-color);">ambassadors@campusshare.edu</a>. Our partnerships team reviews applications monthly.</p>
          </div>
        </div>
        
        <div class="faq-item">
          <div class="faq-question">Where can I find your privacy policy?</div>
          <div class="faq-answer">
            <p>Our privacy policy is available in the footer of every page on our website. You can also <a href="privacy.php" style="color: var(--accent-color);">click here</a> to view it directly. We take your privacy seriously and are fully compliant with all student data protection regulations.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  

  <script>
    // FAQ toggle functionality
    document.querySelectorAll('.faq-question').forEach(question => {
      question.addEventListener('click', () => {
        const isActive = question.classList.contains('active');
        
        // Close all other FAQs
        document.querySelectorAll('.faq-question').forEach(q => {
          q.classList.remove('active');
          q.nextElementSibling.classList.remove('show');
        });
        
        // Toggle current FAQ if it wasn't active
        if (!isActive) {
          question.classList.add('active');
          question.nextElementSibling.classList.add('show');
        }
      });
    });

    // Form validation
    const contactForm = document.querySelector('.contact-form form');
    contactForm.addEventListener('submit', function(e) {
      // Simple validation example
      const email = document.getElementById('email').value;
      if (!email.includes('@')) {
        e.preventDefault();
        alert('Please enter a valid email address');
      }
      // Add more validation as needed
    });
  </script>
  
</body>
</html>
<?php require_once 'footer.php'; ?>