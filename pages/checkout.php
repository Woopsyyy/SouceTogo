<?php
// Direct-access protection
if (!defined('SECURE_ACCESS')) {
    header("Location: ../index.php");
    exit();
}
// Checkout page view
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Fetch cart items
$cart_query = "SELECT c.quantity, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);

if (!$cart_result || mysqli_num_rows($cart_result) === 0) {
    header("Location: index.php?page=cart");
    exit();
}

$grand_total = 0;
$items_list = [];
while ($row = mysqli_fetch_assoc($cart_result)) {
    $price = floatval($row['price']);
    $qty = intval($row['quantity']);
    $subtotal = $price * $qty;
    $grand_total += $subtotal;
    $items_list[] = $row;
}
?>
<main class="cart-section">
    <div class="checkout-grid poppins-font">
        <!-- Billing Details Form -->
        <div class="checkout-card">
            <h2 style='font-family:"Bebas Neue",sans-serif; font-size:2.3rem; color:var(--white-color); margin-bottom:20px; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom:10px;'>Billing & Delivery</h2>
            
            <form action="backend/order.php" method="POST">
                <div class="form-group">
                    <label for="fullname">Full Name *</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" required placeholder="e.g. John Doe">
                </div>
                <div class="form-group">
                    <label for="phone">Contact Number *</label>
                    <input type="tel" name="phone" id="phone" class="form-control" required placeholder="e.g. 09123456789">
                </div>
                <div class="form-group">
                    <label for="address">Complete Delivery Address *</label>
                    <textarea name="address" id="address" class="form-control" required placeholder="Street Name, Barangay, City, Province, ZIP Code"></textarea>
                </div>
                
                <div style="margin-top: 30px;">
                    <p style="font-size: 0.85rem; color: #ccc; margin-bottom: 15px;">* Payments are processed via Cash on Delivery (COD) only.</p>
                    <button type="submit" class="btn-primary" style="width: 100%; border: none; font-family:'Bebas Neue',sans-serif; font-size: 1.4rem; cursor: pointer;">Place Order (Cash On Delivery)</button>
                </div>
            </form>
        </div>
        
        <!-- Order Summary side panel -->
        <div class="summary-card">
            <h3 style='font-family:"Bebas Neue",sans-serif; font-size:1.8rem; color:var(--secondary-color); margin-bottom:15px;'>Order Summary</h3>
            
            <div class="summary-list">
                <?php foreach ($items_list as $item): 
                    $price = floatval($item['price']);
                    $qty = intval($item['quantity']);
                    $subtotal = $price * $qty;
                    ?>
                    <div class="summary-item">
                        <span><?php echo htmlspecialchars($item['name']); ?> <strong>x<?php echo $qty; ?></strong></span>
                        <span>₱<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                <?php endforeach; ?>
                
                <div class="summary-item" style="border-bottom: none; padding-top: 15px;">
                    <span>Delivery Option</span>
                    <span style="color: #2ecc71; font-weight: 500;">FREE SHIPPING (COD)</span>
                </div>
            </div>
            
            <div class="summary-total">
                <span style="font-family:'Bebas Neue',sans-serif; font-size: 1.3rem; color: #fff;">Total:</span>
                <span style="font-family:'Bebas Neue',sans-serif; font-size: 2.2rem; color: var(--secondary-color);">₱<?php echo number_format($grand_total, 2); ?></span>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="index.php?page=cart" style="color: #aaa; text-decoration: underline; font-size: 0.9rem;">Back to Shopping Cart</a>
            </div>
        </div>
    </div>
</main>
