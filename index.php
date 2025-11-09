<?php
$pageTitle = "College Resource Rental System | Student Marketplace";
$pageDescription = "Rent or sell academic resources including books, electronics, and study materials within your college community.";
require_once 'header.php';
?>

<?php
require_once 'connection.php';
$conn = Connect(); // Use mysqli connection

// Fetch latest 4 featured items from DB
$sql = "SELECT * FROM upload ORDER BY created_at DESC LIMIT 4";
$result = $conn->query($sql);
$listings = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $listings[] = $row;
    }
}

// Fetch categories for filtering
$categories = ['all', 'textbooks', 'electronics', 'notes', 'lab', 'other'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>College Resource Rental System | Student Marketplace</title>
  <meta name="description" content="Rent or sell academic resources including books, electronics, and study materials within your college community. Save money and earn by sharing resources with fellow students.">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Reset & Base Styles */
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
      overflow-x: hidden;
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
        animation: pulse 2s infinite;
      }

      @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
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
        position: relative;
        overflow: hidden;
      }

      .btn:after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
      }

      .btn:hover:after {
        animation: ripple 1s ease-out;
      }

      @keyframes ripple {
        0% {
          transform: scale(0, 0);
          opacity: 1;
        }
        20% {
          transform: scale(25, 25);
          opacity: 1;
        }
        100% {
          opacity: 0;
          transform: scale(40, 40);
        }
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


    /* Hero Section */
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

    .hero h2 {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
      color: var(--white);
      animation: fadeInDown 1s ease;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      opacity: 0.9;
      animation: fadeInUp 1s ease 0.3s both;
    }

    .search-bar {
      max-width: 600px;
      margin: 0 auto;
      display: flex;
      background-color: var(--white);
      border-radius: 4px;
      overflow: hidden;
      box-shadow: var(--shadow);
      animation: fadeInUp 1s ease 0.6s both;
    }

    .search-bar input {
      flex: 1;
      padding: 1rem;
      border: none;
      font-size: 1rem;
    }

    .search-bar input:focus {
      outline: none;
    }

    .search-bar button {
      padding: 0 1.5rem;
      background-color: var(--accent-color);
      color: var(--white);
      border: none;
      cursor: pointer;
      transition: var(--transition);
    }

    .search-bar button:hover {
      background-color: #e05555;
    }

    /* Main Content */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .section-title {
      text-align: center;
      margin-bottom: 3rem;
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

    /* Categories */
    .categories {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 3rem;
    }

    .category {
      padding: 0.75rem 1.5rem;
      background-color: var(--white);
      border-radius: 30px;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 500;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .category:hover, .category.active {
      background-color: var(--primary-color);
      color: var(--white);
      transform: translateY(-3px);
    }

    /* Items Grid */
    .items {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .item {
      background-color: var(--white);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
      position: relative;
    }

    .item:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .item-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: var(--accent-color);
      color: var(--white);
      padding: 0.25rem 0.75rem;
      border-radius: 30px;
      font-size: 0.75rem;
      font-weight: 600;
      z-index: 1;
    }

    .item-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 1px solid var(--gray-light);
      transition: transform 0.5s ease;
    }

    .item:hover .item-img {
      transform: scale(1.05);
    }

    .item-content {
      padding: 1.25rem;
    }

    .item h3 {
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .item-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
      font-size: 0.9rem;
      color: #666;
    }

    .item-rating {
      color: #FFC107;
    }

    .item-price {
      font-weight: 700;
      color: var(--secondary-color);
      font-size: 1.2rem;
    }

    .item-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 1rem;
    }

    .btn-sm {
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
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

    /* Bulk Actions */
    .bulk-actions {
      display: flex;
      justify-content: center;
      margin: 2rem 0;
    }

    /* Features Section */
    .features {
      background-color: var(--white);
      padding: 4rem 2rem;
      margin: 3rem 0;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .feature {
      text-align: center;
      padding: 2rem;
      border-radius: 8px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .feature::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, var(--accent-color), var(--primary-color));
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.5s ease;
    }

    .feature:hover::before {
      transform: scaleX(1);
    }

    .feature:hover {
      background-color: var(--light-color);
      transform: translateY(-5px);
    }

    .feature-icon {
      font-size: 2.5rem;
      color: var(--accent-color);
      margin-bottom: 1.5rem;
      transition: var(--transition);
      display: inline-block;
    }

    .feature:hover .feature-icon {
      transform: scale(1.2) rotate(5deg);
    }

    .feature h3 {
      margin-bottom: 1rem;
    }

    /* Testimonials */
    .testimonials {
      background-color: var(--gray-light);
      padding: 4rem 2rem;
      text-align: center;
    }

    .testimonial-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }

    .testimonial {
      background-color: var(--white);
      padding: 2rem;
      border-radius: 8px;
      box-shadow: var(--shadow);
      position: relative;
      transition: var(--transition);
    }

    .testimonial:hover {
      transform: translateY(-5px);
    }

    .testimonial::before {
      content: '"';
      font-size: 5rem;
      color: var(--accent-color);
      opacity: 0.1;
      position: absolute;
      top: 10px;
      left: 20px;
      line-height: 1;
    }

    .testimonial-content {
      margin-bottom: 1.5rem;
      font-style: italic;
      position: relative;
      z-index: 1;
    }

    .testimonial-author {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
    }

    .author-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--accent-color);
      transition: var(--transition);
    }

    .testimonial:hover .author-avatar {
      transform: scale(1.1);
    }

    .author-info h4 {
      margin-bottom: 0.25rem;
      text-align: left;
    }

    .author-info p {
      font-size: 0.9rem;
      color: #666;
      text-align: left;
    }

    /* Slideshow Styles */
    .slideshow {
      position: relative;
      max-width: 1200px;
      margin: 0 auto;
      overflow: hidden;
      border-radius: 8px;
      box-shadow: var(--shadow);
      height: 450px;
    }

    .slideshow-container {
      display: flex;
      transition: transform 0.5s ease;
      height: 100%;
    }

    .slide {
      min-width: 100%;
      height: 100%;
      position: relative;
    }

    .slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 10s ease;
    }

    .slide:hover img {
      transform: scale(1.1);
    }

    .slide-content {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
      color: white;
      padding: 2rem;
    }

    .slide-content h3 {
      color: white;
      font-size: 1.8rem;
      margin-bottom: 0.5rem;
    }

    .slide-content p {
      opacity: 0.9;
      max-width: 600px;
    }

    .slideshow-nav {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      padding: 0 1rem;
      z-index: 2;
    }

    .slideshow-nav button {
      background: rgba(255,255,255,0.3);
      border: none;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .slideshow-nav button:hover {
      background: rgba(255,255,255,0.5);
      transform: scale(1.1);
    }

    .slideshow-dots {
      position: absolute;
      bottom: 1rem;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 0.5rem;
      z-index: 2;
    }

    .slideshow-dots button {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      border: none;
      background: rgba(255,255,255,0.5);
      cursor: pointer;
      transition: var(--transition);
    }

    .slideshow-dots button.active {
      background: var(--accent-color);
      transform: scale(1.2);
    }

    /* Stats Section */
    .stats {
      background-color: var(--primary-color);
      color: var(--white);
      padding: 4rem 2rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .stats::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
      position: relative;
      z-index: 1;
    }

    .stat-item {
      padding: 1.5rem;
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 1s ease, transform 1s ease;
    }

    .stat-item.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: var(--accent-color);
    }

    .stat-label {
      font-size: 1.1rem;
      opacity: 0.9;
    }

    /* How It Works Section */
    .how-it-works {
      padding: 4rem 2rem;
      background-color: var(--white);
    }

    .steps {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-top: 3rem;
      position: relative;
    }

    .steps::before {
      content: '';
      position: absolute;
      top: 40px;
      left: 0;
      right: 0;
      height: 3px;
      background-color: var(--gray-light);
      z-index: 1;
    }

    .step {
      flex: 1;
      min-width: 200px;
      text-align: center;
      position: relative;
      z-index: 2;
      padding: 0 1rem;
      margin-bottom: 2rem;
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .step.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .step-number {
      width: 80px;
      height: 80px;
      background-color: var(--accent-color);
      color: var(--white);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: 700;
      margin: 0 auto 1.5rem;
      border: 5px solid var(--white);
      transition: var(--transition);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .step:hover .step-number {
      transform: scale(1.1) rotate(5deg);
      background-color: var(--primary-color);
    }

    .step h3 {
      margin-bottom: 1rem;
    }

    /* CTA Section */
    .cta {
      background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
      color: var(--white);
      padding: 4rem 2rem;
      text-align: center;
      border-radius: 8px;
      margin: 3rem 0;
      position: relative;
      overflow: hidden;
    }

    .cta::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      transform: rotate(30deg);
      animation: shine 8s infinite linear;
    }

    @keyframes shine {
      0% { transform: translateX(-100%) rotate(30deg); }
      100% { transform: translateX(100%) rotate(30deg); }
    }

    .cta h2 {
      color: var(--white);
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 1;
    }

    .cta p {
      position: relative;
      z-index: 1;
    }

    .cta-buttons {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      margin-top: 2rem;
      position: relative;
      z-index: 1;
    }

    /* FAQ Section */
    .faq {
      padding: 4rem 2rem;
      background-color: var(--light-color);
    }

    .faq-container {
      max-width: 800px;
      margin: 0 auto;
    }

    .faq-item {
      background-color: var(--white);
      border-radius: 8px;
      margin-bottom: 1rem;
      box-shadow: var(--shadow);
      overflow: hidden;
      transition: var(--transition);
    }

    .faq-item:hover {
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
      transform: translateY(-3px);
    }

    .faq-question {
      padding: 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      font-weight: 600;
      transition: var(--transition);
    }

    .faq-question:hover {
      background-color: var(--gray-light);
    }

    .faq-question::after {
      content: '+';
      font-size: 1.5rem;
      transition: var(--transition);
    }

    .faq-question.active::after {
      content: '-';
    }

    .faq-answer {
      padding: 0 1.5rem;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }

    .faq-answer.show {
      padding: 0 1.5rem 1.5rem;
      max-height: 500px;
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

    /* Animation Classes */
    .fade-in {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* Animation Keyframes */
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Floating animation */
    @keyframes float {
      0% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-10px);
      }
      100% {
        transform: translateY(0px);
      }
    }

    .float {
      animation: float 5s ease-in-out infinite;
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
      
      .hero h2 {
        font-size: 2rem;
      }
      
      .cta-buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .steps::before {
        display: none;
      }
      
      .step {
        flex: 100%;
        margin-bottom: 2rem;
      }
      
      .bulk-actions {
        flex-direction: column;
        align-items: center;
      }

      .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .social-links {
        justify-content: center;
      }
    }

    /* Notification styles */
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 12px 20px;
      background: #4CAF50;
      color: white;
      border-radius: 4px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      z-index: 10000;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: fadeIn 0.3s ease;
    }
    
    .notification.info {
      background: #2196F3;
    }
    
    .notification button {
      background: none;
      border: none;
      color: white;
      font-size: 1.2rem;
      cursor: pointer;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>  
  <!-- Slideshow Section -->
  <section class="slideshow-section">
    <div class="container">
      <div class="slideshow">
        <div class="slideshow-container" id="slideshow">
          <!-- Slides will be dynamically inserted here -->
        </div>
        <div class="slideshow-nav">
          <button id="prev-slide"><i class="fas fa-chevron-left"></i></button>
          <button id="next-slide"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="slideshow-dots" id="slideshow-dots">
          <!-- Dots will be dynamically inserted here -->
        </div>
      </div>
    </div>
  </section>

  <section class="hero">
    <div class="hero-content">
      <h2>Share Resources, Save Money</h2>
      <p>Rent or sell textbooks, electronics, and study materials within your college community at affordable prices. Join over 10,000 students across 50+ colleges saving money together.</p>
      <form action="listing.php" method="GET" class="search-bar">
        <input type="text" name="search" id="search-input" placeholder="Search for books, notes, calculators...">
        <button type="submit"><i class="fas fa-search"></i></button>
      </form>
      <div style="margin-top: 1.5rem; font-size: 0.9rem;">
        <span style="margin-right: 1rem;"><i class="fas fa-check-circle"></i> Verified Students Only</span>
        <span style="margin-right: 1rem;"><i class="fas fa-shield-alt"></i> Secure Transactions</span>
        <span><i class="fas fa-headset"></i> 24/7 Support</span>
      </div>
    </div>
  </section>

  <div class="container">
    <div class="section-title fade-in">
      <h2>Featured Items</h2>
      <p>Popular resources currently available in your college</p>
    </div>

    <div class="categories" id="category-filter">
      <?php foreach ($categories as $category): ?>
        <div class="category <?php echo $category === 'all' ? 'active' : ''; ?>" data-category="<?php echo $category; ?>">
          <?php echo ucfirst($category); ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Bulk Add to Cart Button -->
    <div class="bulk-actions">
      <button id="add-all-to-cart" class="btn btn-primary">
        <i class="fas fa-cart-plus"></i> Add All Items to Cart
      </button>
    </div>

   <div class="items" id="items-grid">
      <?php if (count($listings) > 0): ?>
        <?php foreach ($listings as $listing): ?>
          <?php
            $priceValue = floatval($listing['price']);
            $priceDisplay = ($priceValue > 500) ? '₹' . $priceValue . '/month' : (($priceValue > 0) ? '₹' . $priceValue : 'Free');
            $buttonText = ($priceValue > 500) ? 'Rent Now' : (($priceValue > 0) ? 'Buy Now' : 'Get Now');
            $category = !empty($listing['category']) ? $listing['category'] : 'other';

            // Image
            $hasImage = !empty($listing['image']);
            $imageSrc = $hasImage ? "get_image.php?id=" . $listing['id'] : "assets/no-image.png";
          ?>
          <div class="item fade-in" data-category="<?php echo htmlspecialchars($category); ?>">
            <a href="details.php?id=<?php echo $listing['id']; ?>">
              <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>" class="item-img" onerror="this.src='https://via.placeholder.com/300x200?text=Image+Not+Found'">
            </a>
            <div class="item-content">
              <h3><?php echo htmlspecialchars($listing['title']); ?></h3>
              <div class="item-meta">
                <span><?php echo ucfirst($category); ?></span>
                <span class="item-rating">
                  <i class="fas fa-star"></i> 4.5
                </span>
              </div>
              <div class="item-price"><?php echo $priceDisplay; ?></div>
              <p class="item-desc"><?php echo substr(htmlspecialchars($listing['description']), 0, 100) . '...'; ?></p>
              <div class="item-actions">
                <button class="btn btn-secondary btn-sm add-to-cart"
                  data-id="<?php echo $listing['id']; ?>"
                  data-name="<?php echo htmlspecialchars($listing['title']); ?>"
                  data-price="<?php echo $priceValue; ?>">
                  <?php echo $buttonText; ?>
                </button>
                <a href="details.php?id=<?php echo $listing['id']; ?>" class="btn btn-outline btn-sm">Details</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 2rem;">
          <i class="fas fa-box-open" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
          <h3>No items available yet</h3>
          <p>Be the first to list an item for rent or sale!</p>
          <a href="create_listing.php" class="btn btn-primary" style="margin-top: 1rem;">List an Item</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="text-center" style="margin-top: 3rem;">
      <a href="listing.php" class="btn btn-primary float">View All Items</a>
    </div>
  </div>

  <!-- Stats Section -->
  <section class="stats">
    <div class="container">
      <div class="section-title">
        <h2 style="color: var(--white);">By The Numbers</h2>
      </div>
      <div class="stats-grid">
        <div class="stat-item">
          <div class="stat-number" id="stat-students">0</div>
          <div class="stat-label">Students Connected</div>
        </div>
        <div class="stat-item">
          <div class="stat-number" id="stat-savings">₹0</div>
          <div class="stat-label">Saved by Students</div>
        </div>
        <div class="stat-item">
          <div class="stat-number" id="stat-colleges">0</div>
          <div class="stat-label">Colleges Active</div>
        </div>
        <div class="stat-item">
          <div class="stat-number" id="stat-rating">0</div>
          <div class="stat-label">Average Rating</div>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works">
    <div class="container">
      <div class="section-title fade-in">
        <h2>How CampusShare Works</h2>
        <p>Get started in just a few simple steps</p>
      </div>
      <div class="steps">
        <div class="step">
          <div class="step-number">1</div>
          <h3>Create Account</h3>
          <p>Register with your college email to verify your student status and get access.</p>
        </div>
        <div class="step">
          <div class="step-number">2</div>
          <h3>Browse or List</h3>
          <p>Search for items you need or list your own resources for rent/sale.</p>
        </div>
        <div class="step">
          <div class="step-number">3</div>
          <h3>Connect</h3>
          <p>Message the owner to arrange pickup/delivery and payment terms.</p>
        </div>
        <div class="step">
          <div class="step-number">4</div>
          <h3>Complete Transaction</h3>
          <p>Meet on campus, exchange items, and leave a review after use.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <div class="container">
      <div class="section-title fade-in">
        <h2>Why Choose CampusShare?</h2>
        <p>Benefits for both renters and lenders</p>
      </div>
      <div class="features-grid">
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-hand-holding-usd"></i>
          </div>
          <h3>Save Money</h3>
          <p>Access resources at a fraction of the cost of buying new. Students save an average of 60-80% compared to retail prices by renting through our platform.</p>
        </div>
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3>Trusted Community</h3>
          <p>All users are verified college students through their .edu email addresses. Our rating system and transaction history ensure safe and reliable exchanges.</p>
        </div>
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-leaf"></i>
          </div>
          <h3>Sustainable</h3>
          <p>Reduce waste by sharing resources. Each textbook rented instead of bought new saves approximately 7kg of CO2 emissions and 300 liters of water.</p>
        </div>
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-money-bill-wave"></i>
          </div>
          <h3>Earn Income</h3>
          <p>Make money from resources you no longer need. Active lenders earn an average of ₹3000-5000 per semester by renting out their materials.</p>
        </div>
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h3>Campus Convenience</h3>
          <p>All transactions happen on campus, making exchanges quick and easy. No shipping costs or waiting periods for local rentals.</p>
        </div>
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <h3>Academic Support</h3>
          <p>Access to materials from top students in your courses, including notes, study guides, and past exams to help you succeed academically.</p>
        </div>
      </div>
    </div>
  </section>
        
  <!-- FAQ Section -->
  <section class="faq">
    <div class="container">
      <div class="section-title fade-in">
        <h2>Frequently Asked Questions</h2>
        <p>Find answers to common questions about CampusShare</p>
      </div>
      <div class="faq-container">
        <div class="faq-item fade-in">
          <div class="faq-question">How do I verify my student status?</div>
          <div class="faq-answer">
            <p>We verify students through their official college email addresses (.edu or college-specific domains). During registration, you'll receive a verification email to confirm your student status. This helps maintain a trusted community of verified college students.</p>
          </div>
        </div>
        <div class="faq-item fade-in">
          <div class="faq-question">What payment methods are accepted?</div>
          <div class="faq-answer">
            <p>We support various payment options including UPI (Google Pay, PhonePe, Paytm), direct bank transfers, and cash payments upon meeting. For digital transactions, we recommend using our secure payment gateway for buyer and seller protection.</p>
          </div>
        </div>
        <div class="faq-item fade-in">
          <div class="faq-question">How are rental prices determined?</div>
          <div class="faq-answer">
            <p>Rental prices are set by the item owners based on factors like item value, condition, and demand. We provide suggested price ranges for common items to help guide your pricing decisions. Typically, rentals cost 10-20% of the item's retail value per month.</p>
          </div>
        </div>
        <div class="faq-item fade-in">
          <div class="faq-question">What happens if an item is damaged?</div>
          <div class="faq-answer">
            <p>All rentals should be documented with photos before exchange. For minor damage, parties typically negotiate a fair compensation. For significant damage, we recommend using our mediation service. We encourage users to purchase items through our protection plan for added security.</p>
          </div>
        </div>
        <div class="faq-item fade-in">
          <div class="faq-question">Can I rent items for just a few days?</div>
          <div class="faq-answer">
            <p>Yes! While many rentals are semester-long, you can specify any rental duration. Short-term rentals (less than a week) typically have higher daily rates. Use the search filters to find items available for your needed time frame.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="testimonials">
    <div class="container">
      <div class="section-title fade-in">
        <h2>What Students Say</h2>
        <p>Hear from students who've used CampusShare</p>
      </div>
      <div class="testimonial-grid">
        <div class="testimonial fade-in">
          <div class="testimonial-content">
            <p>Saved over ₹5000 last semester by renting textbooks instead of buying them. CampusShare made it so easy to connect with seniors! The notes I rented were incredibly helpful for my exams too.</p>
          </div>
          <div class="testimonial-author">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Priyanka Patel" class="author-avatar">
            <div class="author-info">
              <h4>Priyanka Patel.</h4>
              <p>Computer Science, 3rd Year</p>
              <p>Shrinathji College, Daman</p>
            </div>
          </div>
        </div>
        <div class="testimonial fade-in">
          <div class="testimonial-content">
            <p>I was able to earn back most of my textbook costs by renting them out after my semester ended. The platform is so intuitive and the verification system made me feel safe meeting other students.</p>
          </div>
          <div class="testimonial-author">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Hely" class="author-avatar">
            <div class="author-info">
              <h4>Hely .</h4>
              <p>Bachelor of Computer Applications, 3rd Year</p>
              <p>Shrinathji College, Daman</p>
            </div>
          </div>
        </div>
        <div class="testimonial fade-in">
          <div class="testimonial-content">
            <p>The handwritten notes available here are gold! Much better than trying to decipher everything from lectures alone. I rented a graphing calculator for my stats course at 1/10th the price of buying new.</p>
          </div>
          <div class="testimonial-author">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Ananya Thakar" class="author-avatar">
            <div class="author-info">
              <h4>Ananya Thakar.</h4>
              <p>Electrical Engineering, 2nd Year</p>
              <p>BITS Pilani</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container">
    <div class="cta fade-in">
      <h2>Ready to Get Started?</h2>
      <p>Join thousands of students already saving money and sharing resources on our platform. Whether you need to rent or want to earn from your unused items, CampusShare makes it simple and secure.</p>
      <div class="cta-buttons">
        <a href="listing.php" class="btn btn-outline">Browse Items</a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="create_listing.php" class="btn btn-primary">List an Item</a>
        <?php else: ?>
          <a href="register.php" class="btn btn-primary">Sign Up Now</a>
        <?php endif; ?>
      </div>
      <div style="margin-top: 1.5rem; font-size: 0.9rem;">
        <i class="fas fa-lock"></i> All data is securely protected. We never share your information.
      </div>
    </div>
  </div>

  <script>
    // Slideshow data
    const slideshowData = [
      {
        title: "Textbook Sharing Made Easy",
        description: "Connect with seniors who have the books you need for your courses at affordable rental prices. Average savings of ₹2000 per semester on textbooks alone.",
        image: "https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
      },
      {
        title: "Quality Study Materials",
        description: "Access verified notes, lab manuals, and reference materials from top students in your college. Digital downloads available instantly after purchase.",
        image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
      },
      {
        title: "Tech Equipment Rentals",
        description: "Need a laptop or calculator for a semester? Rent from trusted students on campus. All devices are verified to be in working condition before listing.",
        image: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
      }
    ];

    // Stats data
    const statsData = {
      students: 10000,
      savings: 5000000,
      colleges: 50,
      rating: 4.8
    };

    // DOM Elements
    const itemsGrid = document.getElementById('items-grid');
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const addAllToCartBtn = document.getElementById('add-all-to-cart');
    const cartCount = document.getElementById('cart-count');
    const slideshowContainer = document.getElementById('slideshow');
    const slideshowDots = document.getElementById('slideshow-dots');
    const prevSlideBtn = document.getElementById('prev-slide');
    const nextSlideBtn = document.getElementById('next-slide');

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
      setupSlideshow();
      setupEventListeners();
      setupScrollAnimations();
      updateCartCount();
    });

    // Setup slideshow
    function setupSlideshow() {
      slideshowContainer.innerHTML = '';
      slideshowDots.innerHTML = '';
      
      slideshowData.forEach((slide, index) => {
        // Add slide
        const slideElement = document.createElement('div');
        slideElement.className = 'slide';
        slideElement.innerHTML = `
          <img src="${slide.image}" alt="${slide.title}">
          <div class="slide-content">
            <h3>${slide.title}</h3>
            <p>${slide.description}</p>
          </div>
        `;
        slideshowContainer.appendChild(slideElement);
        
        // Add dot
        const dot = document.createElement('button');
        dot.dataset.index = index;
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        slideshowDots.appendChild(dot);
      });
      
      // Initialize slideshow controls
      let currentSlide = 0;
      const slides = document.querySelectorAll('.slide');
      const dots = document.querySelectorAll('.slideshow-dots button');
      
      function updateSlideshow() {
        slideshowContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        dots.forEach((dot, i) => {
          dot.classList.toggle('active', i === currentSlide);
        });
      }
      
      function goToSlide(index) {
        currentSlide = index;
        updateSlideshow();
      }
      
      function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlideshow();
      }
      
      function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlideshow();
      }
      
      // Auto-advance slides
      let slideInterval = setInterval(nextSlide, 5000);
      
      // Pause on hover
      const slideshow = document.querySelector('.slideshow');
      slideshow.addEventListener('mouseenter', () => clearInterval(slideInterval));
      slideshow.addEventListener('mouseleave', () => {
        slideInterval = setInterval(nextSlide, 5000);
      });
      
      // Navigation buttons
      nextSlideBtn.addEventListener('click', () => {
        nextSlide();
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
      });
      
      prevSlideBtn.addEventListener('click', () => {
        prevSlide();
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
      });
    }

    // Setup event listeners
    function setupEventListeners() {
      // Search functionality
      searchInput.addEventListener('input', filterListings);
      
      // Category filter
      categoryFilter.querySelectorAll('.category').forEach(button => {
        button.addEventListener('click', function() {
          categoryFilter.querySelector('.active').classList.remove('active');
          this.classList.add('active');
          filterListings();
        });
      });
      
      // Add all to cart
      addAllToCartBtn.addEventListener('click', addAllToCart);
      
      // Individual add to cart buttons
      document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', addToCartHandler);
      });
      
      // FAQ functionality
      document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
          const answer = question.nextElementSibling;
          const isActive = question.classList.contains('active');
          
          // Close all other FAQs
          document.querySelectorAll('.faq-question').forEach(q => {
            if (q !== question) {
              q.classList.remove('active');
              q.nextElementSibling.classList.remove('show');
            }
          });
          
          // Toggle current FAQ
          question.classList.toggle('active');
          answer.classList.toggle('show');
        });
      });
    }

    // Setup scroll animations
    function setupScrollAnimations() {
      // Observe elements with fade-in class
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            
            // If it's a stat item, animate the numbers
            if (entry.target.classList.contains('stat-item')) {
              animateStats();
            }
            
            // If it's a step, animate them sequentially
            if (entry.target.classList.contains('step')) {
              animateSteps();
            }
          }
        });
      }, { threshold: 0.1 });
      
      // Observe all elements with animation classes
      document.querySelectorAll('.fade-in, .stat-item, .step').forEach(el => {
        observer.observe(el);
      });
    }

    // Animate statistics counters
    function animateStats() {
      const statElements = {
        students: document.getElementById('stat-students'),
        savings: document.getElementById('stat-savings'),
        colleges: document.getElementById('stat-colleges'),
        rating: document.getElementById('stat-rating')
      };
      
      // Mark stats section as animated to prevent re-animation
      if (document.querySelector('.stats').dataset.animated) return;
      document.querySelector('.stats').dataset.animated = true;
      
      // Make stat items visible
      document.querySelectorAll('.stat-item').forEach(item => {
        item.classList.add('visible');
      });
      
      // Animate each counter
      animateCounter(statElements.students, 0, statsData.students, 2000, '');
      animateCounter(statElements.savings, 0, statsData.savings, 2000, '₹');
      animateCounter(statElements.colleges, 0, statsData.colleges, 2000, '');
      animateCounter(statElements.rating, 0, statsData.rating, 2000, '', 1);
    }
    
    // Counter animation function
    function animateCounter(element, start, end, duration, prefix = '', decimals = 0) {
      let startTimestamp = null;
      const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = progress * (end - start) + start;
        element.textContent = prefix + value.toFixed(decimals);
        if (progress < 1) {
          window.requestAnimationFrame(step);
        }
      };
      window.requestAnimationFrame(step);
    }
    
    // Animate steps sequentially
    function animateSteps() {
      const steps = document.querySelectorAll('.step');
      steps.forEach((step, index) => {
        setTimeout(() => {
          step.classList.add('visible');
        }, index * 200);
      });
    }

    // Filter listings based on search and category
    function filterListings() {
      const searchTerm = searchInput.value.trim().toLowerCase();
      const activeCategory = categoryFilter.querySelector('.active').dataset.category;
      
      document.querySelectorAll('.item').forEach(item => {
        const name = item.querySelector('h3').textContent.toLowerCase();
        const desc = item.querySelector('.item-desc').textContent.toLowerCase();
        const category = item.dataset.category;
        
        const matchesSearch = 
          name.includes(searchTerm) ||
          desc.includes(searchTerm);
        
        const matchesCategory = 
          activeCategory === 'all' || 
          category === activeCategory;
        
        if (matchesSearch && matchesCategory) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    }

    // Add to cart handler
    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

    function addToCartHandler(event) {
      if (!isLoggedIn) {
        // Not logged in → redirect to login page
        alert('Please log in to add items to your cart');
        window.location.href = "login.php";
        return;
      }

      const button = event.currentTarget;
      const itemId = button.dataset.id;
      const itemName = button.dataset.name;
      const itemPrice = parseFloat(button.dataset.price);

      addToCart(itemId, itemName, itemPrice);

      // Visual feedback
      const originalText = button.innerHTML;
      button.innerHTML = '<i class="fas fa-check"></i> Added';
      button.style.backgroundColor = '#4CAF50';
      button.style.borderColor = '#4CAF50';
      button.disabled = true;
      
      setTimeout(() => {
        button.innerHTML = originalText;
        button.style.backgroundColor = '';
        button.style.borderColor = '';
        button.disabled = false;
      }, 1500);
    }

    // Add item to cart
    function addToCart(itemId, itemName, itemPrice) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      
      // Check if item already exists in cart
      const existingItemIndex = cart.findIndex(item => item.id === itemId);
      
      if (existingItemIndex >= 0) {
        // Item exists, increase quantity
        cart[existingItemIndex].quantity += 1;
      } else {
        // Add new item
        cart.push({ 
          id: itemId, 
          name: itemName, 
          price: itemPrice,
          quantity: 1
        });
      }
      
      localStorage.setItem('cart', JSON.stringify(cart));
      updateCartCount();
      
      // Show notification
      showNotification(`${itemName} added to cart!`);
    }

    // Add all visible items to cart
    function addAllToCart() {
      if (!isLoggedIn) {
        alert('Please log in to add items to your cart');
        window.location.href = "login.php";
        return;
      }
      
      const visibleItems = document.querySelectorAll('.item');
      let addedCount = 0;
      
      visibleItems.forEach(item => {
        if (item.style.display !== 'none') {
          const button = item.querySelector('.add-to-cart');
          if (button) {
            const itemId = button.dataset.id;
            const itemName = button.dataset.name;
            const itemPrice = parseFloat(button.dataset.price);
            
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItemIndex = cart.findIndex(item => item.id === itemId);
            
            if (existingItemIndex >= 0) {
              cart[existingItemIndex].quantity += 1;
            } else {
              cart.push({ 
                id: itemId, 
                name: itemName, 
                price: itemPrice,
                quantity: 1
              });
            }
            
            addedCount++;
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
      }
    }

    // Show notification
    function showNotification(message, type = 'success') {
      // Remove existing notification if any
      const existingNotification = document.querySelector('.notification');
      if (existingNotification) {
        existingNotification.remove();
      }
      
      // Create new notification
      const notification = document.createElement('div');
      notification.className = `notification ${type}`;
      notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
      `;
      
      document.body.appendChild(notification);
      
      // Auto remove after 3 seconds
      setTimeout(() => {
        if (notification.parentElement) {
          notification.remove();
        }
      }, 3000);
    }
  </script>
</body>
</html>
<?php require_once 'footer.php'; ?>