<?php
$pageTitle = "About CampusShare | College Resource Rental System";
$pageDescription = "Learn about CampusShare - the student marketplace for sharing academic resources within your college community.";
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About CampusShare | College Resource Rental System</title>
  <meta name="description" content="Learn about CampusShare - the student marketplace for sharing academic resources within your college community.">
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
      padding: 5rem 2rem;
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
      animation: fadeInUp 1s ease-out;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      opacity: 0.9;
      animation: fadeInUp 1s ease-out 0.2s forwards;
      opacity: 0;
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

    /* About Content */
    .about-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      align-items: center;
      margin-bottom: 4rem;
    }

    .about-text h3 {
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .about-text p {
      margin-bottom: 1.5rem;
    }

    .about-image {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
      position: relative;
    }

    .about-image:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .about-image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(0,51,102,0.1), rgba(255,107,107,0.1));
      z-index: 1;
      opacity: 0;
      transition: var(--transition);
    }

    .about-image:hover::before {
      opacity: 1;
    }

    .about-image img {
      width: 100%;
      height: auto;
      display: block;
      transition: var(--transition);
    }

    .about-image:hover img {
      transform: scale(1.05);
    }

    /* Mission & Vision Cards */
    .mission-vision {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-bottom: 4rem;
    }

    .mission-card, .vision-card {
      background-color: var(--white);
      padding: 2rem;
      border-radius: 8px;
      box-shadow: var(--shadow);
      text-align: center;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .mission-card::before, .vision-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 5px;
      height: 100%;
      background-color: var(--accent-color);
      transition: var(--transition);
    }

    .mission-card:hover::before, .vision-card:hover::before {
      width: 100%;
      opacity: 0.1;
    }

    .mission-card:hover, .vision-card:hover {
      transform: translateY(-5px);
    }

    .mission-card i, .vision-card i {
      font-size: 2.5rem;
      color: var(--accent-color);
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 2;
    }

    .mission-card h3, .vision-card h3 {
      position: relative;
      z-index: 2;
    }

    .mission-card p, .vision-card p {
      position: relative;
      z-index: 2;
    }

    /* Stats Section - Matching index page */
    .stats {
      background-color: var(--primary-color);
      color: var(--white);
      padding: 4rem 2rem;
      text-align: center;
      margin: 3rem 0;
      border-radius: 8px;
      position: relative;
      overflow: hidden;
    }

    .stats::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      transform: rotate(30deg);
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
      position: relative;
    }

    .stat-item {
      padding: 1.5rem;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      backdrop-filter: blur(5px);
      transition: var(--transition);
    }

    .stat-item:hover {
      transform: translateY(-5px);
      background-color: rgba(255, 255, 255, 0.15);
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

    /* Team Section */
    .team-section {
      background-color: var(--white);
      padding: 4rem 2rem;
      margin: 3rem 0;
      border-radius: 8px;
      box-shadow: var(--shadow);
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }

    .team-member {
      background-color: var(--light-color);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
      text-align: center;
      position: relative;
    }

    .team-member::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to bottom, transparent 0%, transparent 70%, rgba(0,0,0,0.1) 100%);
      opacity: 0;
      transition: var(--transition);
    }

    .team-member:hover::before {
      opacity: 1;
    }

    .team-member:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .member-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
      transition: var(--transition);
    }

    .team-member:hover .member-image {
      transform: scale(1.05);
    }

    .member-info {
      padding: 1.5rem;
      position: relative;
    }

    .member-info h3 {
      margin-bottom: 0.5rem;
    }

    .member-info p.position {
      color: var(--secondary-color);
      font-weight: 500;
      margin-bottom: 0.5rem;
    }

    .member-info p.bio {
      color: #666;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .member-social {
      display: flex;
      justify-content: center;
      gap: 1rem;
    }

    .member-social a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      background-color: var(--white);
      border-radius: 50%;
      color: var(--primary-color);
      transition: var(--transition);
      transform: translateY(10px);
      opacity: 0;
    }

    .team-member:hover .member-social a {
      transform: translateY(0);
      opacity: 1;
    }

    .member-social a:nth-child(1) {
      transition-delay: 0.1s;
    }
    .member-social a:nth-child(2) {
      transition-delay: 0.2s;
    }
    .member-social a:nth-child(3) {
      transition-delay: 0.3s;
    }

    .member-social a:hover {
      background-color: var(--accent-color);
      color: var(--white);
      transform: translateY(-3px) !important;
    }

    /* CTA Section - Matching index page */
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
    }

    .cta h2 {
      color: var(--white);
      margin-bottom: 1.5rem;
      position: relative;
    }

    .cta p {
      position: relative;
    }

    .cta-buttons {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      margin-top: 2rem;
      position: relative;
    }

    /* Footer - Consistent with homepage */
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

    .footer-bottom {
      text-align: center;
      padding-top: 2rem;
      margin-top: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      font-size: 0.9rem;
      opacity: 0.8;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes countUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animated-number {
      animation: countUp 1s ease-out forwards;
      opacity: 0;
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
      
      .about-content {
        grid-template-columns: 1fr;
      }
      
      .about-image {
        order: -1;
      }
      
      .cta-buttons {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>

  <section class="hero">
    <div class="hero-content">
      <h1>About CampusShare</h1>
      <p>Connecting students to share resources and build sustainable campus communities</p>
    </div>
  </section>

  <div class="container">
    <div class="about-content">
      <div class="about-text">
        <h3>Our Story</h3>
        <p>CampusShare was founded in 2025 by a group of BCA students frustrated with the high costs of textbooks and academic resources. What started as a simple campus notice board has grown into a trusted platform serving thousands of students across 50+ colleges.</p>
        <p>We recognized that students were spending thousands each year on books and equipment they only used for a semester, while others struggled to afford these essential resources. CampusShare was created to solve this problem through sharing.</p>
        <p>Today, we're proud to have helped students save over ₹25 lakhs while reducing waste and building stronger campus communities.</p>
      </div>
      <div class="about-image">
        <img src="https://thumbs.dreamstime.com/z/book-crossing-swap-concept-friends-exchanging-literature-sharing-recommending-fiction-reading-men-readers-students-293908611.jpg" alt="Students sharing books on campus">
      </div>
    </div>

    <div class="section-title">
      <h2>Our Mission & Vision</h2>
    </div>

    <div class="mission-vision">
      <div class="mission-card">
        <i class="fas fa-bullseye"></i>
        <h3>Our Mission</h3>
        <p>To create an affordable, sustainable ecosystem where students can easily share academic resources, reducing financial barriers to education and promoting environmental responsibility.</p>
      </div>
      <div class="vision-card">
        <i class="fas fa-eye"></i>
        <h3>Our Vision</h3>
        <p>To transform how students access learning materials by building the leading resource-sharing platform in every college, fostering collaboration and community.</p>
      </div>
    </div>

    <section class="stats">
      <div class="container">
        <div class="section-title">
          <h2 style="color: var(--white);">By The Numbers</h2>
        </div>
        <div class="stats-grid">
          <div class="stat-item">
            <div class="stat-number" id="colleges-count">0</div>
            <div class="stat-label">Colleges</div>
          </div>
          <div class="stat-item">
            <div class="stat-number" id="students-count">0</div>
            <div class="stat-label">Students</div>
          </div>
          <div class="stat-item">
            <div class="stat-number" id="savings-count">₹0</div>
            <div class="stat-label">Saved</div>
          </div>
          <div class="stat-item">
            <div class="stat-number" id="resources-count">0</div>
            <div class="stat-label">Resources</div>
          </div>
        </div>
      </div>
    </section>

    <section class="team-section">
      <div class="container">
        <div class="section-title">
          <h2>Meet Our Team</h2>
          <p>The passionate students behind CampusShare</p>
        </div>
        <div class="team-grid">
          <div class="team-member">
            <img src="https://tse2.mm.bing.net/th/id/OIP.5F3SyVGz57QTefASUtBtpgHaHa?pid=Api&P=0&h=180" alt="Rahul Sharma" class="member-image">
            <div class="member-info">
              <h3>Rahul Sharma</h3>
              <p class="position">Founder & CEO</p>
              <p class="bio">Final year Computer Science student passionate about sustainable education solutions.</p>
              <div class="member-social">
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fas fa-envelope"></i></a>
              </div>
            </div>
          </div>
          <div class="team-member">
            <img src="https://tse4.mm.bing.net/th/id/OIP.k3nSYd_TnVgrDclqCfijJAHaHa?pid=Api&P=0&h=180" alt="Priya Patel" class="member-image">
            <div class="member-info">
              <h3>Priya Patel</h3>
              <p class="position">CTO</p>
              <p class="bio">Tech enthusiast with a vision for building community-driven platforms.</p>
              <div class="member-social">
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
                <a href="#"><i class="fas fa-envelope"></i></a>
              </div>
            </div>
          </div>
          <div class="team-member">
            <img src="https://tse3.mm.bing.net/th/id/OIP.iV-pgB8fG1uHbm-GqREZuwHaFj?pid=Api&P=0&h=180" alt="Ananya Gupta" class="member-image">
            <div class="member-info">
              <h3>Ananya Gupta</h3>
              <p class="position">Marketing Lead</p>
              <p class="bio">Creative mind behind our brand and community engagement.</p>
              <div class="member-social">
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fas fa-envelope"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="cta">
      <h2>Ready to Join the Movement?</h2>
      <p>Become part of our growing community of students sharing resources and supporting each other.</p>
      <div class="cta-buttons">
        <a href="listing.php" class="btn btn-outline">Browse Resources</a>
      </div>
    </div>
  </div>

  <script>
    // Function to animate counting numbers
    function animateCounter(elementId, finalValue, duration, prefix = '') {
      const element = document.getElementById(elementId);
      const startTime = performance.now();
      const startValue = 0;
      
      function updateCounter(currentTime) {
        const elapsedTime = currentTime - startTime;
        if (elapsedTime > duration) {
          element.textContent = prefix + finalValue.toLocaleString();
          return;
        }
        
        const progress = elapsedTime / duration;
        const currentValue = Math.floor(progress * finalValue);
        element.textContent = prefix + currentValue.toLocaleString();
        
        requestAnimationFrame(updateCounter);
      }
      
      requestAnimationFrame(updateCounter);
    }

    // Function to check if element is in viewport
    function isInViewport(element) {
      const rect = element.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    }

    // Initialize counters when stats section comes into view
    let countersAnimated = false;
    
    function checkCounters() {
      const statsSection = document.querySelector('.stats');
      if (statsSection && !countersAnimated && isInViewport(statsSection)) {
        animateCounter('colleges-count', 50, 2000);
        animateCounter('students-count', 10000, 2000);
        animateCounter('savings-count', 2500000, 2000, '₹');
        animateCounter('resources-count', 5000, 2000);
        countersAnimated = true;
      }
    }

    // Add scroll event listener to trigger counters
    window.addEventListener('scroll', checkCounters);
    
    // Also check on page load
    document.addEventListener('DOMContentLoaded', checkCounters);
  </script>
</body>
</html>
<?php require_once 'footer.php'; ?>