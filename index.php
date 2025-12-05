<?php
$pageTitle = "College Resource Rental System | Student Marketplace";
$pageDescription = "Rent or sell academic resources including books, electronics, and study materials within your college community.";
require_once 'header.php';
?>

<?php
require_once 'connection.php';
$conn = Connect();

// Fetch latest 4 featured items from DB
$sql = "SELECT * FROM upload WHERE status='approved' 
        ORDER BY created_at DESC LIMIT 4";
$result = $conn->query($sql);
$listings = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagePath = "uploads/" . $row['image'];
        if (!empty($row['image']) && file_exists($imagePath)) {
            $row['image'] = $imagePath;
        } else {
            $row['image'] = "assets/no-image.png";
        }
        $listings[] = $row;
    }
}

$categories = ['all', 'textbooks', 'electronics', 'notes', 'lab', 'other'];
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>College Resource Rental System | Student Marketplace</title>
  <meta name="description" content="Rent or sell academic resources including books, electronics, and study materials within your college community.">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    :root {
      --primary-color: #003366;
      --secondary-color: #006699;
      --accent-color: #FF6B6B;
      --success-color: #28a745;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --white: #ffffff;
      --gray-light: #e9ecef;
      --gray-medium: #6c757d;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      --shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.15);
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      --border-radius: 12px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
      background-color: var(--light-color);
      color: var(--dark-color);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Enhanced Header */
    header {
      background: linear-gradient(135deg, var(--primary-color), #002244);
      color: var(--white);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .logo i {
      font-size: 1.75rem;
      color: var(--accent-color);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.1); }
    }

    .logo h1 {
      font-size: 1.5rem;
      font-weight: 700;
      background: linear-gradient(45deg, var(--white), #e0f7ff);
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Professional Slideshow */
    .slideshow-section {
      position: relative;
      margin-bottom: 0;
    }

    .slideshow {
      position: relative;
      width: 100%;
      height: 600px;
      overflow: hidden;
      border-radius: 0;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .slideshow-container {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
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
      transform: scale(1.05);
    }

    .slide-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(0, 51, 102, 0.85), rgba(0, 102, 153, 0.75));
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .slide-content {
      text-align: center;
      color: var(--white);
      max-width: 800px;
      padding: 0 2rem;
      z-index: 2;
    }

    .slide-content h2 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      line-height: 1.2;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .slide-content p {
      font-size: 1.3rem;
      margin-bottom: 2rem;
      opacity: 0.95;
      font-weight: 300;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .slide-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.75rem;
      padding: 1rem 2rem;
      background: var(--accent-color);
      color: var(--white);
      text-decoration: none;
      border-radius: 50px;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    }

    .slide-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
      background: #e05555;
      color: var(--white);
    }

    .slideshow-nav {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      padding: 0 2rem;
      z-index: 3;
    }

    .slideshow-nav button {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255, 255, 255, 0.3);
      color: var(--white);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }

    .slideshow-nav button:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: scale(1.1);
      border-color: rgba(255, 255, 255, 0.5);
    }

    .slideshow-dots {
      position: absolute;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 0.75rem;
      z-index: 3;
    }

    .slideshow-dots button {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      border: none;
      background: rgba(255, 255, 255, 0.4);
      cursor: pointer;
      transition: var(--transition);
    }

    .slideshow-dots button.active {
      background: var(--accent-color);
      transform: scale(1.2);
    }

    .slideshow-progress {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: rgba(255, 255, 255, 0.2);
      z-index: 3;
    }

    .progress-bar {
      height: 100%;
      background: var(--accent-color);
      width: 0%;
      transition: width 0.1s linear;
    }

    /* Enhanced Hero Section */
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
      background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIzMCIgaGVpZ2h0PSIzMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA0KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    .hero h2 {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      line-height: 1.2;
    }

    .hero p {
      font-size: 1.25rem;
      margin-bottom: 2.5rem;
      opacity: 0.95;
      font-weight: 300;
    }

    .search-bar {
      max-width: 600px;
      margin: 0 auto;
      display: flex;
      background: var(--white);
      border-radius: 50px;
      overflow: hidden;
      box-shadow: var(--shadow-hover);
      border: 2px solid transparent;
      transition: var(--transition);
    }

    .search-bar:focus-within {
      border-color: var(--accent-color);
      transform: translateY(-2px);
    }

    .search-bar input {
      flex: 1;
      padding: 1.25rem 1.5rem;
      border: none;
      font-size: 1rem;
      background: transparent;
    }

    .search-bar input:focus {
      outline: none;
    }

    .search-bar button {
      padding: 0 2rem;
      background: var(--accent-color);
      color: var(--white);
      border: none;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 600;
    }

    .search-bar button:hover {
      background: #e05555;
      transform: scale(1.05);
    }

    /* Enhanced Container & Sections */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .section-title {
      text-align: center;
      margin-bottom: 4rem;
    }

    .section-title h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      position: relative;
      display: inline-block;
    }

    .section-title h2::after {
      content: '';
      position: absolute;
      width: 80px;
      height: 4px;
      background: linear-gradient(45deg, var(--accent-color), var(--secondary-color));
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 2px;
    }

    .section-title p {
      font-size: 1.1rem;
      color: var(--gray-medium);
      max-width: 600px;
      margin: 0 auto;
    }

    /* Enhanced Categories */
    .categories {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 3rem;
    }

    .category {
      padding: 0.875rem 1.75rem;
      background: var(--white);
      border-radius: 50px;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 600;
      box-shadow: var(--shadow);
      border: 2px solid transparent;
      position: relative;
      overflow: hidden;
    }

    .category::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s;
    }

    .category:hover::before {
      left: 100%;
    }

    .category:hover, .category.active {
      background: var(--primary-color);
      color: var(--white);
      transform: translateY(-3px);
      box-shadow: var(--shadow-hover);
      border-color: var(--primary-color);
    }

    /* Enhanced Items Grid */
    .items {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .item {
      background: var(--white);
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
      position: relative;
      border: 1px solid var(--gray-light);
    }

    .item:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: var(--shadow-hover);
    }

    .item-badge {
      position: absolute;
      top: 12px;
      right: 12px;
      background: var(--accent-color);
      color: var(--white);
      padding: 0.375rem 1rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 700;
      z-index: 2;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .item-img-container {
      position: relative;
      overflow: hidden;
      height: 220px;
    }

    .item-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .item:hover .item-img {
      transform: scale(1.1);
    }

    .item-content {
      padding: 1.5rem;
    }

    .item h3 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.75rem;
      line-height: 1.4;
    }

    .item-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }

    .item-category {
      background: var(--light-color);
      padding: 0.25rem 0.75rem;
      border-radius: 15px;
      font-weight: 500;
      color: var(--gray-medium);
    }

    .item-rating {
      color: #FFC107;
      font-weight: 600;
    }

    .item-price {
      font-weight: 700;
      color: var(--secondary-color);
      font-size: 1.4rem;
      margin-bottom: 1rem;
    }

    .item-desc {
      color: var(--gray-medium);
      margin-bottom: 1.5rem;
      line-height: 1.5;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .item-actions {
      display: flex;
      gap: 0.75rem;
    }

    /* Enhanced Buttons */
    .btn {
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      border: 2px solid transparent;
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn-primary {
      background: var(--accent-color);
      color: var(--white);
    }

    .btn-primary:hover {
      background: #e05555;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
    }

    .btn-secondary {
      background: var(--secondary-color);
      color: var(--white);
    }

    .btn-secondary:hover {
      background: #005580;
      transform: translateY(-2px);
    }

    .btn-outline {
      background: transparent;
      color: var(--secondary-color);
      border-color: var(--secondary-color);
    }

    .btn-outline:hover {
      background: var(--secondary-color);
      color: var(--white);
      transform: translateY(-2px);
    }

    .btn-sm {
      padding: 0.625rem 1.25rem;
      font-size: 0.9rem;
    }

    /* Enhanced Stats Section */
    .stats {
      background: linear-gradient(135deg, var(--primary-color), #002244);
      color: var(--white);
      padding: 5rem 2rem;
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
      background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyNSIgaGVpZ2h0PSIyNSIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 3rem;
      position: relative;
      z-index: 1;
    }

    .stat-item {
      text-align: center;
      padding: 1.5rem;
    }
    .stat-number {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
      background: linear-gradient(45deg, var(--accent-color), #ff8e8e);
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .stat-label {
      font-size: 1.1rem;
      opacity: 0.9;
      font-weight: 500;
    }

    /* Enhanced Features Section */
    .features {
      background: var(--white);
      padding: 5rem 2rem;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2.5rem;
    }

    .feature {
      background: var(--light-color);
      padding: 2.5rem 2rem;
      border-radius: var(--border-radius);
      text-align: center;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      border: 1px solid transparent;
    }

    .feature::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(45deg, var(--accent-color), var(--secondary-color));
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.5s ease;
    }

    .feature:hover::before {
      transform: scaleX(1);
    }

    .feature:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
      border-color: var(--gray-light);
    }

    .feature-icon {
      font-size: 3rem;
      color: var(--accent-color);
      margin-bottom: 1.5rem;
      transition: var(--transition);
    }

    .feature:hover .feature-icon {
      transform: scale(1.1) rotate(5deg);
    }

    .feature h3 {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .feature p {
      color: var(--gray-medium);
      line-height: 1.6;
    }

    /* Enhanced CTA Section */
    .cta {
      background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
      color: var(--white);
      padding: 4rem 2rem;
      text-align: center;
      border-radius: var(--border-radius);
      margin: 4rem 0;
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
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 1;
    }

    .cta p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      opacity: 0.9;
      position: relative;
      z-index: 1;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    .cta-buttons {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      position: relative;
      z-index: 1;
    }

    /* Enhanced Animations */
    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
    }

    .float {
      animation: float 4s ease-in-out infinite;
    }

    /* Enhanced Notification */
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 1rem 1.5rem;
      background: var(--success-color);
      color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-hover);
      z-index: 10000;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      animation: slideInRight 0.3s ease;
      border-left: 4px solid rgba(255,255,255,0.3);
    }

    .notification.info {
      background: var(--secondary-color);
    }

    .notification button {
      background: none;
      border: none;
      color: white;
      font-size: 1.2rem;
      cursor: pointer;
      padding: 0;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: var(--transition);
    }

    .notification button:hover {
      background: rgba(255,255,255,0.2);
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(100%);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .slideshow {
        height: 400px;
      }

      .slide-content h2 {
        font-size: 2.5rem;
      }

      .slide-content p {
        font-size: 1.1rem;
      }

      .hero h2 {
        font-size: 2.2rem;
      }
      
      .hero p {
        font-size: 1.1rem;
      }
      
      .section-title h2 {
        font-size: 2rem;
      }
      
      .items {
        grid-template-columns: 1fr;
      }
      
      .cta-buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
      }
      
      .stat-number {
        font-size: 2.2rem;
      }
    }

    @media (max-width: 480px) {
      .slideshow {
        height: 350px;
      }

      .slide-content h2 {
        font-size: 2rem;
      }

      .slide-content p {
        font-size: 1rem;
      }

      .slideshow-nav {
        padding: 0 1rem;
      }

      .slideshow-nav button {
        width: 40px;
        height: 40px;
      }

      .container {
        padding: 1rem;
      }
      
      .hero {
        padding: 3rem 1rem;
      }
      
      .stats-grid {
        grid-template-columns: 1fr;
      }
      
      .features-grid {
        grid-template-columns: 1fr;
      }
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
  </style>
</head>
<body>
  <!-- Professional Slideshow Section -->
  <section class="slideshow-section">
    <div class="slideshow">
      <div class="slideshow-container" id="slideshow-container">
        <!-- Slides will be dynamically inserted here -->
      </div>
      
      <div class="slideshow-nav">
        <button id="prev-slide">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button id="next-slide">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
      
      <div class="slideshow-dots" id="slideshow-dots">
        <!-- Dots will be dynamically inserted here -->
      </div>
      
      <div class="slideshow-progress">
        <div class="progress-bar" id="progress-bar"></div>
      </div>
    </div>
  </section>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h2>Share Resources, Save Money</h2>
      <p>Rent or sell textbooks, electronics, and study materials within your college community at affordable prices. Join thousands of students saving money together.</p>
      <form action="listing.php" method="GET" class="search-bar">
        <input type="text" name="search" id="search-input" placeholder="Search for books, notes, calculators...">
        <button type="submit"><i class="fas fa-search"></i> Search</button>
      </form>
      <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
        <span><i class="fas fa-check-circle"></i> Verified Students</span>
        <span><i class="fas fa-shield-alt"></i> Secure Transactions</span>
        <span><i class="fas fa-headset"></i> 24/7 Support</span>
      </div>
    </div>
  </section>

  <!-- Featured Items Section -->
  <div class="container">
    <div class="section-title fade-in">
      <h2>Featured Resources</h2>
      <p>Discover popular academic resources available in your college community</p>
    </div>

    <div class="categories" id="category-filter">
      <?php foreach ($categories as $category): ?>
        <div class="category <?php echo $category === 'all' ? 'active' : ''; ?>" data-category="<?php echo $category; ?>">
          <i class="fas fa-<?php echo getCategoryIcon($category); ?>"></i>
          <?php echo ucfirst($category); ?>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="bulk-actions">
      <button id="add-all-to-cart" class="btn btn-primary">
        <i class="fas fa-cart-plus"></i> Add All Visible Items to Cart
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
            $imageSrc = !empty($listing['image']) ? htmlspecialchars($listing['image']) : "assets/no-image.png";
          ?>
          <div class="item fade-in" data-category="<?php echo htmlspecialchars($category); ?>">
            <div class="item-badge">Featured</div>
            <div class="item-img-container">
              <a href="details.php?id=<?php echo $listing['id']; ?>">
                <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>" class="item-img" onerror="this.src='assets/no-image.png'">
              </a>
            </div>
            <div class="item-content">
              <h3><?php echo htmlspecialchars($listing['title']); ?></h3>
              <div class="item-meta">
                <span class="item-category"><?php echo ucfirst($category); ?></span>
                <span class="item-rating">
                  <i class="fas fa-star"></i> 4.8
                </span>
              </div>
              <div class="item-price"><?php echo $priceDisplay; ?></div>
              <p class="item-desc"><?php echo substr(htmlspecialchars($listing['description']), 0, 120) . '...'; ?></p>
              <div class="item-actions">
                <button class="btn btn-primary btn-sm"
                  data-id="<?php echo $listing['id']; ?>"
                  data-name="<?php echo htmlspecialchars($listing['title']); ?>"
                  data-price="<?php echo $priceValue; ?>"
                  onclick="buyNow(
                    '<?php echo $listing['id']; ?>',
                    '<?php echo htmlspecialchars($listing['title']); ?>',
                    '<?php echo $priceValue; ?>',
                    '<?php echo htmlspecialchars($listing['description']); ?>',
                    1
                  )">
                  <i class="fas fa-shopping-cart"></i> <?php echo $buttonText; ?>
                </button>

                <a href="details.php?id=<?php echo $listing['id']; ?>" class="btn btn-outline btn-sm">
                  <i class="fas fa-eye"></i> Details
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
          <i class="fas fa-box-open" style="font-size: 4rem; color: #ccc; margin-bottom: 1.5rem;"></i>
          <h3 style="margin-bottom: 1rem; color: var(--gray-medium);">No items available yet</h3>
          <p style="margin-bottom: 2rem; color: var(--gray-medium);">Be the first to list an item for rent or sale!</p>
          <a href="create_listing.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> List an Item
          </a>
        </div>
      <?php endif; ?>
    </div>

    <div class="text-center" style="margin-top: 3rem;">
      <a href="listing.php" class="btn btn-primary float">
        <i class="fas fa-th-list"></i> View All Resources
      </a>
    </div>
  </div>

  <!-- Stats Section -->
  <section class="stats">
    <div class="container">
      <div class="section-title">
        <h2 style="color: var(--white);">Platform Impact</h2>
        <p style="color: rgba(255,255,255,0.8);">Join our growing community of students</p>
      </div>
      <div class="stats-grid">
        <div class="stat-item fade-in">
          <div class="stat-number" id="stat-students">0</div>
          <div class="stat-label">Students Connected</div>
        </div>
        <div class="stat-item fade-in">
          <div class="stat-number" id="stat-savings">₹0</div>
          <div class="stat-label">Total Savings</div>
        </div>
        <div class="stat-item fade-in">
          <div class="stat-number" id="stat-colleges">0</div>
          <div class="stat-label">Colleges Active</div>
        </div>
        <div class="stat-item fade-in">
          <div class="stat-number" id="stat-rating">0</div>
          <div class="stat-label">Average Rating</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <div class="container">
      <div class="section-title fade-in">
        <h2>Why Choose Our Platform?</h2>
        <p>Experience the benefits of collaborative resource sharing</p>
      </div>
      <div class="features-grid">
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-hand-holding-usd"></i>
          </div>
          <h3>Cost Effective</h3>
          <p>Access premium resources at affordable prices. Students save 60-80% compared to retail by renting through our platform.</p>
        </div>
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3>Verified Community</h3>
          <p>All users are authenticated college students. Our rating system ensures safe and reliable transactions.</p>
        </div>
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-leaf"></i>
          </div>
          <h3>Eco-Friendly</h3>
          <p>Reduce environmental impact by sharing resources. Each rental saves approximately 7kg of CO2 emissions.</p>
        </div>
        <div class="feature fade-in">
          <div class="feature-icon">
            <i class="fas fa-money-bill-wave"></i>
          </div>
          <h3>Earn Income</h3>
          <p>Generate revenue from unused resources. Active lenders earn ₹3000-5000 per semester on average.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <div class="container">
    <div class="cta fade-in">
      <h2>Start Sharing Today</h2>
      <p>Join thousands of students already benefiting from our platform. Whether you need resources or want to earn from your unused items, we make it simple and secure.</p>
      <div class="cta-buttons">
        <a href="listing.php" class="btn btn-outline">
          <i class="fas fa-search"></i> Browse Resources
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="upload.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> List Your Item
          </a>
        <?php else: ?>
          <a href="register.php" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Join Now
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script>
    // Slideshow data
    const slideshowData = [
      {
        title: "Textbook Sharing Made Easy",
        description: "Connect with seniors who have the books you need for your courses at affordable rental prices. Average savings of ₹2000 per semester on textbooks alone.",
        image: "https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
        buttonText: "Browse Textbooks",
        buttonLink: "listing.php?category=textbooks"
      },
      {
        title: "Quality Study Materials",
        description: "Access verified notes, lab manuals, and reference materials from top students in your college. Digital downloads available instantly after purchase.",
        image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
        buttonText: "Find Study Materials",
        buttonLink: "listing.php?category=notes"
      },
      {
        title: "Tech Equipment Rentals",
        description: "Need a laptop or calculator for a semester? Rent from trusted students on campus. All devices are verified to be in working condition before listing.",
        image: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
        buttonText: "Explore Electronics",
        buttonLink: "listing.php?category=electronics"
      },
      {
        title: "Sustainable Campus Living",
        description: "Reduce waste and save money by sharing resources with fellow students. Join our eco-friendly community making education more accessible.",
        image: "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80",
        buttonText: "Join Now",
        buttonLink: "register.php"
      }
    ];

    // Stats data
    const statsData = {
      students: 12500,
      savings: 7500000,
      colleges: 65,
      rating: 4.8
    };

    // Category icons mapping
    const categoryIcons = {
      all: 'th-large',
      textbooks: 'book',
      electronics: 'laptop',
      notes: 'file-alt',
      lab: 'flask',
      other: 'cube'
    };

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
      initializeSlideshow();
      initializePage();
      setupEventListeners();
      setupScrollAnimations();
      updateCartCount();
    });

    function initializeSlideshow() {
      const slideshowContainer = document.getElementById('slideshow-container');
      const slideshowDots = document.getElementById('slideshow-dots');
      
      // Create slides and dots
      slideshowData.forEach((slide, index) => {
        // Create slide
        const slideElement = document.createElement('div');
        slideElement.className = 'slide';
        slideElement.innerHTML = `
          <img src="${slide.image}" alt="${slide.title}">
          <div class="slide-overlay">
            <div class="slide-content">
              <h2>${slide.title}</h2>
              <p>${slide.description}</p>
              <a href="${slide.buttonLink}" class="slide-btn">
                <i class="fas fa-arrow-right"></i> ${slide.buttonText}
              </a>
            </div>
          </div>
        `;
        slideshowContainer.appendChild(slideElement);
        
        // Create dot
        const dot = document.createElement('button');
        dot.dataset.index = index;
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        slideshowDots.appendChild(dot);
      });
      
      // Initialize slideshow functionality
      let currentSlide = 0;
      const slides = document.querySelectorAll('.slide');
      const dots = document.querySelectorAll('.slideshow-dots button');
      const progressBar = document.getElementById('progress-bar');
      let slideInterval;
      
      function updateSlideshow() {
        slideshowContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        dots.forEach((dot, i) => {
          dot.classList.toggle('active', i === currentSlide);
        });
        
        progressBar.style.width = '0%';
        setTimeout(() => {
          progressBar.style.width = '100%';
        }, 10);
      }
      
      function goToSlide(index) {
        currentSlide = index;
        updateSlideshow();
        resetAutoAdvance();
      }
      
      function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlideshow();
      }
      
      function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlideshow();
      }
      
      function resetAutoAdvance() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
      }
      
      // Auto-advance slides
      slideInterval = setInterval(nextSlide, 5000);
      
      // Pause on hover
      const slideshow = document.querySelector('.slideshow');
      slideshow.addEventListener('mouseenter', () => clearInterval(slideInterval));
      slideshow.addEventListener('mouseleave', resetAutoAdvance);
      
      // Navigation buttons
      document.getElementById('next-slide').addEventListener('click', () => {
        nextSlide();
        resetAutoAdvance();
      });
      
      document.getElementById('prev-slide').addEventListener('click', () => {
        prevSlide();
        resetAutoAdvance();
      });
      
      // Keyboard navigation
      document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
          prevSlide();
          resetAutoAdvance();
        } else if (e.key === 'ArrowRight') {
          nextSlide();
          resetAutoAdvance();
        }
      });
      
      // Initialize progress bar
      progressBar.style.width = '100%';
    }

    function initializePage() {
      // Add category icons
      document.querySelectorAll('.category').forEach(category => {
        const categoryName = category.dataset.category;
        if (categoryIcons[categoryName]) {
          const icon = document.createElement('i');
          icon.className = `fas fa-${categoryIcons[categoryName]}`;
          category.prepend(icon);
        }
      });
    }

    function setupEventListeners() {
      // Category filter
      document.querySelectorAll('.category').forEach(button => {
        button.addEventListener('click', function() {
          document.querySelectorAll('.category').forEach(btn => btn.classList.remove('active'));
          this.classList.add('active');
          filterListings();
        });
      });

      // Search functionality
      document.getElementById('search-input').addEventListener('input', filterListings);

      // Add to cart buttons
      document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', addToCartHandler);
      });

      // Add all to cart
      document.getElementById('add-all-to-cart').addEventListener('click', addAllToCart);
    }

    function setupScrollAnimations() {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            
            if (entry.target.classList.contains('stat-item')) {
              animateStats();
            }
          }
        });
      }, { threshold: 0.1 });

      document.querySelectorAll('.fade-in, .stat-item').forEach(el => {
        observer.observe(el);
      });
    }

    function animateStats() {
      if (document.querySelector('.stats').dataset.animated) return;
      document.querySelector('.stats').dataset.animated = true;

      animateCounter('stat-students', 0, statsData.students, 2000);
      animateCounter('stat-savings', 0, statsData.savings, 2000, '₹');
      animateCounter('stat-colleges', 0, statsData.colleges, 2000);
      animateCounter('stat-rating', 0, statsData.rating, 2000, '', 1);
    }

    function animateCounter(elementId, start, end, duration, prefix = '', decimals = 0) {
      const element = document.getElementById(elementId);
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

    function filterListings() {
      const searchTerm = document.getElementById('search-input').value.toLowerCase();
      const activeCategory = document.querySelector('.category.active').dataset.category;
      
      document.querySelectorAll('.item').forEach(item => {
        const title = item.querySelector('h3').textContent.toLowerCase();
        const desc = item.querySelector('.item-desc').textContent.toLowerCase();
        const category = item.dataset.category;
        
        const matchesSearch = title.includes(searchTerm) || desc.includes(searchTerm);
        const matchesCategory = activeCategory === 'all' || category === activeCategory;
        
        item.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
      });
    }

    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

    function addToCartHandler(event) {
      if (!isLoggedIn) {
        showNotification('Please log in to add items to your cart', 'info');
        setTimeout(() => window.location.href = "login.php", 1500);
        return;
      }

      const button = event.currentTarget;
      const itemId = button.dataset.id;
      const itemName = button.dataset.name;
      const itemPrice = parseFloat(button.dataset.price);

      addToCartUnified(itemId, itemName, itemPrice, listingDescription, 1);


      // Visual feedback
      button.innerHTML = '<i class="fas fa-check"></i> Added';
      button.style.background = 'var(--success-color)';
      button.disabled = true;
      
      setTimeout(() => {
        button.innerHTML = `<i class="fas fa-shopping-cart"></i> ${button.dataset.originalText || 'Add to Cart'}`;
        button.style.background = '';
        button.disabled = false;
      }, 2000);
    }

    function addToCart(itemId, itemName, itemPrice) {
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
      
      localStorage.setItem('cart', JSON.stringify(cart));
      updateCartCount();
      showNotification(`"${itemName}" added to cart!`);
    }

    function addAllToCart() {
      if (!isLoggedIn) {
        showNotification('Please log in to add items to your cart', 'info');
        setTimeout(() => window.location.href = "login.php", 1500);
        return;
      }
      
      const visibleItems = Array.from(document.querySelectorAll('.item'))
        .filter(item => item.style.display !== 'none');
      
      let addedCount = 0;
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      
      visibleItems.forEach(item => {
        const button = item.querySelector('.add-to-cart');
        if (button) {
          const itemId = button.dataset.id;
          const existingItemIndex = cart.findIndex(item => item.id === itemId);
          
          if (existingItemIndex >= 0) {
            cart[existingItemIndex].quantity += 1;
          } else {
            cart.push({ 
              id: itemId, 
              name: button.dataset.name, 
              price: parseFloat(button.dataset.price),
              quantity: 1
            });
          }
          addedCount++;
        }
      });
      
      localStorage.setItem('cart', JSON.stringify(cart));
      updateCartCount();
      
      if (addedCount > 0) {
        showNotification(`${addedCount} item(s) added to cart!`);
      } else {
        showNotification('No new items to add', 'info');
      }
    }

    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const cartCountElement = document.getElementById('cart-count');
      if (cartCountElement) {
        cartCountElement.textContent = cart.reduce((total, item) => total + item.quantity, 0);
      }
    }

    function showNotification(message, type = 'success') {
      const existingNotification = document.querySelector('.notification');
      if (existingNotification) {
        existingNotification.remove();
      }
      
      const notification = document.createElement('div');
      notification.className = `notification ${type}`;
      notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
      `;
      
      document.body.appendChild(notification);
      
      setTimeout(() => {
        if (notification.parentElement) {
          notification.remove();
        }
      }, 4000);
    }






    /*  Buy Now Functionality */
    function buyNow(itemId, itemName, itemPrice, itemDescription = "", quantity = 1) {

  if (!isLoggedIn) {
    showNotification('Please log in to buy this item', 'info');
    setTimeout(() => window.location.href = "login.php", 1500);
    return;
  }

  // 1️⃣ Save to LocalStorage (optional)
  let cart = JSON.parse(localStorage.getItem("cartItems")) || [];

  const item = {
    id: itemId,
    name: itemName,
    description: itemDescription,
    price: itemPrice,
    quantity: quantity
  };

  cart.push(item);
  localStorage.setItem("cartItems", JSON.stringify(cart));

  // 2️⃣ Save to database (cartt table)
  fetch("add_to_cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      id: itemId,
      name: itemName,
      description: itemDescription,
      price: itemPrice,
      quantity: quantity
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      
      // 3️⃣ Update navbar cart count
      document.getElementById("cart-count").textContent = data.cart_count;

      // 4️⃣ Show success message
      showNotification("Item added to cart!", "success");

      // ❌ NO REDIRECT
    } 
    else {
      showNotification(data.message, "error");
    }
  })
  .catch(err => console.error("Error:", err));
}


function addToCartUnified(itemId, itemName, itemPrice, itemDescription = "", quantity = 1) {
    let cart = JSON.parse(localStorage.getItem("cartItems")) || [];

    const existing = cart.find(item => item.id == itemId);

    if (existing) {
        existing.quantity += quantity;
    } else {
        cart.push({
            id: itemId,
            name: itemName,
            description: itemDescription,
            price: itemPrice,
            quantity: quantity
        });
    }



    function updateCartCountUnified() {
    const cart = JSON.parse(localStorage.getItem("cartItems")) || [];
    const total = cart.reduce((sum, item) => sum + item.quantity, 0);

    let cartCount = document.getElementById("cart-count");
    if (cartCount) cartCount.textContent = total;
}


    localStorage.setItem("cartItems", JSON.stringify(cart));
    updateCartCountUnified();
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
      }, 2000);
    }




  </script>
</body>
</html>

<?php
function getCategoryIcon($category) {
  $icons = [
    'all' => 'th-large',
    'textbooks' => 'book',
    'electronics' => 'laptop',
    'notes' => 'file-alt',
    'lab' => 'flask',
    'other' => 'cube'
  ];
  return $icons[$category] ?? 'cube';
}
?>

<?php require_once 'footer.php'; ?>