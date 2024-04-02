<?php
session_start(); // Start the session to access session variables

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple E-commerce Site</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome to Our Simple E-commerce Site</h1>
<?php if (!$loggedIn): ?>
    <!-- Show login and signup buttons if user is not logged in -->
    <div id="navigation">
        <button onclick="window.location.href='login.html';">Login</button>
        <button onclick="window.location.href='signup.html';">Sign Up</button>
    </div>
<?php else: ?>
    <p>Welcome back! <a href="php/logout.php">Log out</a></p>
<?php endif; ?>

    <h2>Product Catalog</h2>
    <div id="product-container">
        <!-- Products will be dynamically added here -->
    </div>
    
    <div id="cart-counter" onclick="showCart()">Cart (0)</div>

    <script src="js/script.js"></script>

</body>
</html>

