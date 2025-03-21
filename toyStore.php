<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kid Palace</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <header>
        <div id="navbar1" class="navbar">
            <h1>KID PALACE</h1>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="javascript:void(0)" id="cart-link" onclick="toggleCart()">Cart</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section id="home" class="full-screen">
    <div class="welcome-text">
        <h1>Welcome to Kid Palace</h1>
        <p>Your one-stop shop for kids' toys!</p>
        <button onclick="scrollToSection('products')">View Products</button>
    </div>
</section>

<section id="products" class="product-section">
    <div id="product-grid" class="product-grid"></div>
</section>

<section id="reviews" class="review-section">
    <div class="review-content">
        <!-- Left Side: Review Form -->
        <div class="review-form-container">
            <h3>Leave Your Precious Review</h3>
            <form id="review-form" class="review-form" method="POST" action="submit_review.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required placeholder="Your Name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Your Email">
                </div>
                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea id="review" name="review" rows="5" required placeholder="Your Review"></textarea>
                </div>
                <button type="submit" class="btn">Submit Review</button>
            </form>
        </div>

        <!-- Right Side: Heading and Lorem Ipsum -->
        <div class="review-info">
            <h2>Give Your Precious Reviews</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam viverra scelerisque libero, sit amet volutpat eros tincidunt id. Integer vitae fringilla felis. Quisque euismod maximus euismod.</p>
        </div>
    </div>
</section>



<footer>
    <div class="footer-content">
        <!-- Left Section: Logo and Description -->
        <div class="footer-logo">
            <h1>Kid Palace</h1>
            <p>Your one-stop shop for kids' toys!</p>
        </div>

        <!-- Middle Section: Useful Links -->
        <div class="footer-links">
            <h4>Useful Links</h4>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>

        <!-- Right Section: Contact Information -->
        <div class="footer-contact">
            <h4>Contact Info</h4>
            <p>Address: 123 Main Street, New York, NY 10001</p>
            <p>Email: support@kidpalace.com</p>
            <p>Phone: +1 (800) 123-4567</p>
        </div>
    </div>

    <!-- Social Media Icons -->
    <div class="footer-social-media">
        <a href="https://www.facebook.com" target="_blank" class="facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank" class="instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://twitter.com" target="_blank" class="twitter">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="https://www.linkedin.com" target="_blank" class="linkedin">
            <i class="fab fa-linkedin-in"></i>
        </a>
        <a href="https://www.youtube.com" target="_blank" class="youtube">
            <i class="fab fa-youtube"></i>
        </a>
    </div>

    <p>&copy; 2024 Kid Palace. All rights reserved.</p>
</footer>


    <!-- Cart Side Panel -->
    <div id="cart-panel" class="cart-panel">
        <h3>Your Cart</h3>
        <ul id="cart-items"></ul>
        <p id="cart-total">Total: $0</p>
        <button onclick="checkout()">Checkout</button>
        <button onclick="toggleCart()">Close</button>
    </div>

    <!-- Popup Modal -->
    <div id="popup-modal" class="popup-modal">
        <div class="popup-content">
            <p id="popup-message"></p>
            <button onclick="closePopup()">Close</button>
        </div>
    </div>

    <script src="toyStore2.js"></script>
</body>
</html>
