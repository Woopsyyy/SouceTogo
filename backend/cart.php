<?php
// Cart actions controller
session_start();
require_once __DIR__ . '/../config/db.php';

// Guest check: All cart actions require a logged-in user session
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = "Please login or register to add sauces to your cart.";
    header("Location: ../index.php?page=login");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Determine the action (GET or POST)
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// 1. ADD ITEM TO CART (GET Action - Quick Add from Shop)
if ($action === 'add') {
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
    
    if ($product_id <= 0) {
        $_SESSION['cart_error'] = "Invalid product selection.";
        header("Location: ../index.php?page=order");
        exit();
    }
    
    // Check if product exists
    $prod_check = mysqli_query($conn, "SELECT id, name FROM products WHERE id = $product_id");
    if (!$prod_check || mysqli_num_rows($prod_check) === 0) {
        $_SESSION['cart_error'] = "Product does not exist.";
        header("Location: ../index.php?page=order");
        exit();
    }
    $product = mysqli_fetch_assoc($prod_check);
    $prod_name = $product['name'];

    // Check if product is already in this user's cart
    $cart_check = mysqli_query($conn, "SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    
    if ($cart_check && mysqli_num_rows($cart_check) > 0) {
        $cart_item = mysqli_fetch_assoc($cart_check);
        $new_qty = $cart_item['quantity'] + 1;
        $cart_id = $cart_item['id'];
        mysqli_query($conn, "UPDATE cart SET quantity = $new_qty WHERE id = $cart_id");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
    }
    
    $_SESSION['cart_message'] = "Added $prod_name to your cart!";
    header("Location: ../index.php?page=order");
    exit();
}

// 2. ADD ITEM WITH QUANTITY (POST Action - Product Details)
if ($action === 'add_quantity') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if ($product_id <= 0 || $quantity <= 0) {
        $_SESSION['cart_error'] = "Invalid product selection or quantity.";
        header("Location: ../index.php?page=order");
        exit();
    }
    
    // Check if product exists
    $prod_check = mysqli_query($conn, "SELECT id, name FROM products WHERE id = $product_id");
    if (!$prod_check || mysqli_num_rows($prod_check) === 0) {
        $_SESSION['cart_error'] = "Product does not exist.";
        header("Location: ../index.php?page=order");
        exit();
    }
    $product = mysqli_fetch_assoc($prod_check);
    $prod_name = $product['name'];

    // Check if in cart
    $cart_check = mysqli_query($conn, "SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    
    if ($cart_check && mysqli_num_rows($cart_check) > 0) {
        $cart_item = mysqli_fetch_assoc($cart_check);
        $new_qty = $cart_item['quantity'] + $quantity;
        $cart_id = $cart_item['id'];
        mysqli_query($conn, "UPDATE cart SET quantity = $new_qty WHERE id = $cart_id");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)");
    }
    
    $_SESSION['cart_message'] = "Successfully added $quantity bottle(s) of $prod_name!";
    header("Location: ../index.php?page=cart");
    exit();
}

// 3. UPDATE QUANTITY (GET Action - Cart Plus/Minus Buttons)
if ($action === 'update') {
    $cart_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $new_qty = isset($_GET['qty']) ? intval($_GET['qty']) : 0;
    
    if ($cart_id <= 0) {
        header("Location: ../index.php?page=cart");
        exit();
    }
    
    // Check that cart item belongs to this user
    $cart_owner_check = mysqli_query($conn, "SELECT id FROM cart WHERE id = $cart_id AND user_id = $user_id");
    if (!$cart_owner_check || mysqli_num_rows($cart_owner_check) === 0) {
        header("Location: ../index.php?page=cart");
        exit();
    }
    
    if ($new_qty <= 0) {
        // Remove item if quantity falls to zero
        mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id");
        $_SESSION['cart_message'] = "Item removed from cart.";
    } else {
        mysqli_query($conn, "UPDATE cart SET quantity = $new_qty WHERE id = $cart_id");
    }
    
    header("Location: ../index.php?page=cart");
    exit();
}

// 4. REMOVE ITEM (GET Action - Trash Can click)
if ($action === 'remove') {
    $cart_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($cart_id <= 0) {
        header("Location: ../index.php?page=cart");
        exit();
    }
    
    // Check that cart item belongs to this user
    $cart_owner_check = mysqli_query($conn, "SELECT id FROM cart WHERE id = $cart_id AND user_id = $user_id");
    if ($cart_owner_check && mysqli_num_rows($cart_owner_check) > 0) {
        mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id");
        $_SESSION['cart_message'] = "Item removed from cart.";
    }
    
    header("Location: ../index.php?page=cart");
    exit();
}

header("Location: ../index.php?page=cart");
exit();
?>
