<?php
// Order placement action handler
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?page=login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php?page=cart");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$fullname = trim(mysqli_real_escape_string($conn, $_POST['fullname'] ?? ''));
$phone = trim(mysqli_real_escape_string($conn, $_POST['phone'] ?? ''));
$address = trim(mysqli_real_escape_string($conn, $_POST['address'] ?? ''));

if (empty($fullname) || empty($phone) || empty($address)) {
    $_SESSION['cart_error'] = "All checkout fields are required.";
    header("Location: ../index.php?page=checkout");
    exit();
}

// 1. Fetch current cart items for the user
$cart_query = "SELECT c.quantity, p.id AS p_id, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);

if (!$cart_result || mysqli_num_rows($cart_result) === 0) {
    $_SESSION['cart_error'] = "Your cart is empty! Cannot checkout.";
    header("Location: ../index.php?page=cart");
    exit();
}

// Calculate grand total and cache items
$grand_total = 0;
$items = [];
while ($row = mysqli_fetch_assoc($cart_result)) {
    $qty = intval($row['quantity']);
    $price = floatval($row['price']);
    $grand_total += ($price * $qty);
    $items[] = $row;
}

// 2. Begin transaction manually (for safety)
mysqli_begin_transaction($conn);

try {
    // 3. Create invoice entry in the `orders` table
    $order_query = "INSERT INTO orders (user_id, fullname, phone, address, total_price) VALUES ($user_id, '$fullname', '$phone', '$address', $grand_total)";
    if (!mysqli_query($conn, $order_query)) {
        throw new Exception("Failed to insert order: " . mysqli_error($conn));
    }
    
    $order_id = mysqli_insert_id($conn);
    
    // 4. Create individual order items records
    foreach ($items as $item) {
        $p_id = intval($item['p_id']);
        $qty = intval($item['quantity']);
        $price = floatval($item['price']);
        
        $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $p_id, $qty, $price)";
        if (!mysqli_query($conn, $item_query)) {
            throw new Exception("Failed to insert order item: " . mysqli_error($conn));
        }
    }
    
    // 5. Clear shopping cart
    $clear_cart_query = "DELETE FROM cart WHERE user_id = $user_id";
    if (!mysqli_query($conn, $clear_cart_query)) {
        throw new Exception("Failed to clear shopping cart: " . mysqli_error($conn));
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    // Trigger successful status messaging
    $_SESSION['order_success'] = "Congratulations! Your order #STG-" . str_pad($order_id, 5, '0', STR_PAD_LEFT) . " has been placed successfully. Payment will be collected on Cash on Delivery!";
    header("Location: ../index.php?page=my-orders");
    exit();
    
} catch (Exception $e) {
    // Rollback changes on errors
    mysqli_rollback($conn);
    $_SESSION['cart_error'] = "Checkout pipeline error: " . $e->getMessage();
    header("Location: ../index.php?page=checkout");
    exit();
}
?>
