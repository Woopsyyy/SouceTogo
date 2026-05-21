<?php
// Direct-access protection
if (!defined('SECURE_ACCESS')) {
    header("Location: ../index.php");
    exit();
}
// Customer orders log page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Fetch orders with item descriptions
$orders_query = "SELECT o.id, o.total_price, o.status, o.created_at, GROUP_CONCAT(CONCAT(p.name, ' x', oi.quantity) SEPARATOR ', ') AS items_summary FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = $user_id GROUP BY o.id ORDER BY o.id DESC";
$orders_result = mysqli_query($conn, $orders_query);
?>
<main class="cart-section">
    <div class="cart-card" style="max-width: 1100px;">
        <h2 style='font-family:"Bebas Neue",sans-serif; font-size:2.5rem; color:var(--white-color); margin-bottom:20px; text-align:center; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom:15px;'>My Order History</h2>
        
        <?php
        if (isset($_SESSION['order_success'])) {
            echo "<div class='alert alert-success'><i class='fa-solid fa-check-circle'></i> " . htmlspecialchars($_SESSION['order_success']) . "</div>";
            unset($_SESSION['order_success']);
        }
        
        if ($orders_result && mysqli_num_rows($orders_result) > 0):
            ?>
            <div class="cart-table-wrapper">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date & Time</th>
                            <th>Products Purchased</th>
                            <th>Total Cost</th>
                            <th>Delivery Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($order = mysqli_fetch_assoc($orders_result)):
                            $o_id = $order['id'];
                            $o_date = date("M d, Y - h:i A", strtotime($order['created_at']));
                            $o_items = htmlspecialchars($order['items_summary']);
                            $o_total = number_format(floatval($order['total_price']), 2);
                            $o_status = htmlspecialchars($order['status']);
                            
                            // Determine status badge class
                            $status_class = 'status-pending';
                            if (strtolower($o_status) === 'preparing') {
                                $status_class = 'status-preparing';
                            } elseif (strtolower($o_status) === 'out for delivery') {
                                $status_class = 'status-out-for-delivery';
                            } elseif (strtolower($o_status) === 'delivered') {
                                $status_class = 'status-delivered';
                            }
                            ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--secondary-color);">#STG-<?php echo str_pad($o_id, 5, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo $o_date; ?></td>
                                <td style="font-size: 0.95rem; line-height: 1.4; max-width: 350px;"><?php echo $o_items; ?></td>
                                <td style="font-weight: 600;">₱<?php echo $o_total; ?></td>
                                <td>
                                    <span class="status-badge <?php echo $status_class; ?>"><?php echo $o_status; ?></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div style="text-align: center; margin-top: 30px;" class="poppins-font">
                <a href="index.php?page=order" class="btn-primary" style="display:inline-block; text-decoration:none; font-family:'Bebas Neue',sans-serif; font-size:1.3rem;">Explore More Sauces</a>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px 0;" class="poppins-font">
                <i class="fa-solid fa-receipt" style="font-size: 4rem; color: rgba(255,255,255,0.2); margin-bottom: 20px; display: block;"></i>
                <p style="font-size: 1.2rem; color: #ddd; margin-bottom: 20px;">You have not placed any orders yet.</p>
                <a href="index.php?page=order" class="btn-primary" style="display:inline-block; text-decoration:none; font-family:'Bebas Neue',sans-serif; font-size:1.3rem;">Browse Our Catalog</a>
            </div>
        <?php endif; ?>
    </div>
</main>
