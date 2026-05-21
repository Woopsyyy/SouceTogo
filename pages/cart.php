<?php
// Direct-access protection
if (!defined('SECURE_ACCESS')) {
    header("Location: ../index.php");
    exit();
}
// Cart view page
if (!isset($_SESSION['user_id'])) {
    echo "<main class='cart-section'><div class='cart-card poppins-font' style='text-align:center;'>
        <h2 style='font-family:\"Bebas Neue\",sans-serif;font-size:2.5rem;color:var(--secondary-color);margin-bottom:15px;'>Access Denied</h2>
        <p style='margin-bottom:25px;'>Please login to view your shopping cart and place orders!</p>
        <a href='index.php?page=login' class='btn' style='display:inline-block;padding:12px 30px;max-width:200px;margin:0 auto;text-align:center;'>Login / Register</a>
    </div></main>";
    return;
}

$user_id = intval($_SESSION['user_id']);

// Fetch cart items
$cart_query = "SELECT c.id AS cart_id, c.quantity, p.id AS p_id, p.name, p.price, p.image FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $user_id ORDER BY c.id DESC";
$cart_result = mysqli_query($conn, $cart_query);
?>
<main class="cart-section">
    <div class="cart-card">
        <h2 style='font-family:"Bebas Neue",sans-serif; font-size:2.5rem; color:var(--white-color); margin-bottom:20px; text-align:center; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom:15px;'>Your Shopping Cart</h2>
        
        <?php
        if (isset($_SESSION['cart_message'])) {
            echo "<div class='alert alert-success'><i class='fa-solid fa-check-circle'></i> " . htmlspecialchars($_SESSION['cart_message']) . "</div>";
            unset($_SESSION['cart_message']);
        }
        if (isset($_SESSION['cart_error'])) {
            echo "<div class='alert alert-danger'><i class='fa-solid fa-exclamation-circle'></i> " . htmlspecialchars($_SESSION['cart_error']) . "</div>";
            unset($_SESSION['cart_error']);
        }
        
        if ($cart_result && mysqli_num_rows($cart_result) > 0):
            $grand_total = 0;
            ?>
            <div class="cart-table-wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th style="text-align: center;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($item = mysqli_fetch_assoc($cart_result)):
                            $c_id = $item['cart_id'];
                            $p_id = $item['p_id'];
                            $p_name = htmlspecialchars($item['name']);
                            $p_price = floatval($item['price']);
                            $qty = intval($item['quantity']);
                            $subtotal = $p_price * $qty;
                            $grand_total += $subtotal;
                            $p_image = htmlspecialchars($item['image']);
                            ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="assets/images/<?php echo $p_image; ?>" alt="<?php echo $p_name; ?>" class="cart-product-img">
                                        <div>
                                            <a href="index.php?page=details&id=<?php echo $p_id; ?>" style="color: #fff; font-weight: 600; font-size: 1.1rem;"><?php echo $p_name; ?></a>
                                        </div>
                                    </div>
                                </td>
                                <td>₱<?php echo number_format($p_price, 2); ?></td>
                                <td>
                                    <div class="qty-control">
                                        <a href="backend/cart.php?action=update&id=<?php echo $c_id; ?>&qty=<?php echo $qty - 1; ?>" class="qty-btn">-</a>
                                        <input type="text" readonly class="qty-input" value="<?php echo $qty; ?>">
                                        <a href="backend/cart.php?action=update&id=<?php echo $c_id; ?>&qty=<?php echo $qty + 1; ?>" class="qty-btn">+</a>
                                    </div>
                                </td>
                                <td style="font-weight: 600; color: var(--secondary-color);">₱<?php echo number_format($subtotal, 2); ?></td>
                                <td style="text-align: center;">
                                    <a href="backend/cart.php?action=remove&id=<?php echo $c_id; ?>" class="remove-btn" onclick="return confirm('Remove <?php echo $p_name; ?> from cart?');">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="cart-summary poppins-font">
                <span style="font-weight: 500; font-size: 1.4rem;">Estimated Total:</span>
                <span class="total-val" style="font-family:'Bebas Neue',sans-serif; font-size: 2.5rem;">₱<?php echo number_format($grand_total, 2); ?></span>
            </div>
            
            <div class="cart-actions poppins-font">
                <a href="index.php?page=order" class="btn-secondary">Continue Shopping</a>
                <a href="index.php?page=checkout" class="btn-primary">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px 0;" class="poppins-font">
                <i class="fa-solid fa-cart-shopping" style="font-size: 4rem; color: rgba(255,255,255,0.2); margin-bottom: 20px; display: block;"></i>
                <p style="font-size: 1.2rem; color: #ddd; margin-bottom: 20px;">Your shopping cart is currently empty.</p>
                <a href="index.php?page=order" class="btn-primary" style="display:inline-block; text-decoration:none; font-family:'Bebas Neue',sans-serif; font-size:1.3rem;">Order Sauces Now!</a>
            </div>
        <?php endif; ?>
    </div>
</main>
