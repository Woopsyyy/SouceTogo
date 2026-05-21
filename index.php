<?php
/**
 * SauceToGo - Master Router Entryway (Front Controller)
 * Handles clean modular loading of pages similar to React-Router.
 */
session_start();
define('SECURE_ACCESS', true);

// Whitelist of valid routing pages
$allowed_pages = [
    'home'       => 'pages/home.php',
    'order'      => 'pages/order.php',
    'details'    => 'pages/details.php',
    'login'      => 'pages/login-register.php',
    'cart'       => 'pages/cart.php',
    'checkout'   => 'pages/checkout.php',
    'my-orders'  => 'pages/my-orders.php'
];

// Determine the page to render, default is 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Fallback to 'home' if page is invalid/not whitelisted
if (!array_key_exists($page, $allowed_pages)) {
    $page = 'home';
}

$view_file = $allowed_pages[$page];

// 1. Render Navigation & Layout Header
require_once __DIR__ . '/includes/header.php';

// 2. Render Page View Content
if (file_exists(__DIR__ . '/' . $view_file)) {
    require_once __DIR__ . '/' . $view_file;
} else {
    echo "<main style='padding: 150px 20px; text-align: center; min-height: 80vh;'>
        <h2 style='font-family:sans-serif;'>Page View File Missing</h2>
        <p>The file <strong>$view_file</strong> is missing.</p>
    </main>";
}

// 3. Render Footer & Global Scripts
require_once __DIR__ . '/includes/footer.php';
?>
