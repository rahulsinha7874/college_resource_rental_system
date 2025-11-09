<footer>
    <div class="footer-content">
        <div class="footer-column">
            <h3>CampusShare</h3>
            <p>The student marketplace for sharing academic resources within your college community.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="footer-column">
            <h3>Quick Links</h3>
            <ul class="footer-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="listing.php">Browse Items</a></li>
                <li><a href="upload.php">Upload Item</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Categories</h3>
            <ul class="footer-links">
                <li><a href="listing.php?category=textbooks">Textbooks</a></li>
                <li><a href="listing.php?category=electronics">Electronics</a></li>
                <li><a href="listing.php?category=notes">Study Notes</a></li>
                <li><a href="listing.php?category=lab_equipment">Lab Equipment</a></li>
                <li><a href="listing.php?category=other">Other Resources</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Support</h3>
            <ul class="footer-links">
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="help.php">Help Center</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
                <li><a href="privacy.php">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 CampusShare. All Rights Reserved. | Designed for Students, By Students</p>
    </div>
</footer>

<script>
// Cart count functionality
document.addEventListener('DOMContentLoaded', function() {
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        document.getElementById('cart-count').textContent = cart.length;
    }
    updateCartCount();
});
</script>
</body>
</html>