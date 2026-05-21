<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';

// Determine the active page
$active_page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Get Cart Items Count & User details
$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    
    // Fetch cart count
    $cart_query = "SELECT SUM(quantity) AS total_qty FROM cart WHERE user_id = $user_id";
    $cart_result = mysqli_query($conn, $cart_query);
    if ($cart_result) {
        $cart_row = mysqli_fetch_assoc($cart_result);
        $cart_count = $cart_row['total_qty'] ?? 0;
    }
    
    // Ensure username is populated in session if missing
    if (!isset($_SESSION['username'])) {
        $user_query = "SELECT username FROM users WHERE id = $user_id LIMIT 1";
        $user_result = mysqli_query($conn, $user_query);
        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user_row = mysqli_fetch_assoc($user_result);
            $_SESSION['username'] = $user_row['username'];
        } else {
            $_SESSION['username'] = 'User';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAUCETOGO | Premium Craft Sauces</title>
    
    <!-- Third-Party CSS Stylesheet Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Global CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Conditional CSS based on routing -->
    <?php if ($active_page === 'login'): ?>
        <link rel="stylesheet" href="assets/css/login.css">
    <?php elseif ($active_page === 'details'): ?>
        <link rel="stylesheet" href="assets/css/details.css">
    <?php endif; ?>
</head>
<body class="<?php echo $active_page === 'login' ? 'login-page' : ''; ?>">
    <header>
        <nav class="navbar section-content">
            <div class="nav-logo">
                <a href="index.php?page=home" class="logo-text">
                    <img src="assets/images/saucetogologo.png" alt="SauceToGo Logo" class="logo-img">
                </a>
            </div>
            
            <ul class="nav-menu">
                <button id="menu-close-button" class="fas fa-times"></button>
                
                <li class="nav-item">
                    <a href="index.php?page=home" class="nav-link">HOME</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=home#menu" class="nav-link">MENU</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=order" class="nav-link">ORDER ONLINE</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=home#about" class="nav-link">ABOUT</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=home#contact" class="nav-link">CONTACT US</a>
                </li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a href="index.php?page=my-orders" class="nav-link">MY ORDERS</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=cart" class="nav-link">
                            <i class="fa-solid fa-cart-shopping"></i> CART 
                            <span class="cart-badge"><?php echo $cart_count; ?></span>
                        </a>
                    </li>
                    <li class="nav-item poppins-font">
                        <span class="nav-user"><i class="fa-regular fa-user"></i> <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                    </li>
                    <li class="nav-item">
                        <a href="backend/logout.php" class="nav-link" style="color: var(--primary-color); background: var(--white-color); font-weight: bold;">LOGOUT</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="index.php?page=login" class="nav-link" style="color: var(--primary-color); background: var(--secondary-color); font-weight: bold;">LOGIN</a>
                    </li>
                <?php endif; ?>
            </ul>
            
            <button id="menu-open-button" class="fas fa-bars"></button>
        </nav>
    </header>
