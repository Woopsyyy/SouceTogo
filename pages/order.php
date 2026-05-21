<?php
// Direct-access protection
if (!defined('SECURE_ACCESS')) {
    header("Location: ../index.php");
    exit();
}
// Order grid catalog page
?>
<main>
    <section class="section-p1" id="product1">
        <div class="product-content">
            <img src="assets/images/saucetogologo.png" alt="SauceToGo Branding" class="logo">
            
            <?php
            // Show session alerts if any
            if (isset($_SESSION['cart_message'])) {
                echo "<div class='alert alert-success'><i class='fa-solid fa-check-circle'></i> " . htmlspecialchars($_SESSION['cart_message']) . "</div>";
                unset($_SESSION['cart_message']);
            }
            if (isset($_SESSION['cart_error'])) {
                echo "<div class='alert alert-danger'><i class='fa-solid fa-exclamation-circle'></i> " . htmlspecialchars($_SESSION['cart_error']) . "</div>";
                unset($_SESSION['cart_error']);
            }
            ?>

            <!-- ================= SPICY SAUCES GRID ================= -->
            <h3 class="spicy">Signature Spicy Sauces</h3>
            <p class="poppins-font" style="color: #ddd; margin-bottom: 20px;">Carefully crafted with hot peppers and rich, fiery spices to kickstart your taste buds.</p>
            
            <div class="product-cont">
                <?php
                $spicy_query = "SELECT * FROM products WHERE category = 'spicy' ORDER BY id ASC";
                $spicy_result = mysqli_query($conn, $spicy_query);
                
                if ($spicy_result && mysqli_num_rows($spicy_result) > 0) {
                    while ($product = mysqli_fetch_assoc($spicy_result)) {
                        $p_id = $product['id'];
                        $p_name = htmlspecialchars($product['name']);
                        $p_price = number_format($product['price'], 2);
                        $p_image = htmlspecialchars($product['image']);
                        ?>
                        <div class="product1">
                            <img src="assets/images/<?php echo $p_image; ?>" alt="<?php echo $p_name; ?>">
                            <div class="des poppins-font">
                                <h5><?php echo $p_name; ?></h5>
                                <div class="star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <h4>₱<?php echo $p_price; ?></h4>
                            </div>
                            
                            <div class="action-wrapper poppins-font">
                                <a href="backend/cart.php?action=add&product_id=<?php echo $p_id; ?>" class="cart-btn" style="text-align: center; display: block;"><i class="fa-solid fa-cart-plus"></i> Add To Cart</a>
                                <a href="index.php?page=details&id=<?php echo $p_id; ?>" class="view-btn" title="View Details"><i class="fa-solid fa-eye"></i></a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p style='color: white;'>No products found in database.</p>";
                }
                ?>
            </div>
            
            <br><br><br>

            <!-- ================= NON-SPICY SAUCES GRID ================= -->
            <h3 class="spicy">Savory Non-Spicy Sauces</h3>
            <p class="poppins-font" style="color: #ddd; margin-bottom: 20px;">Rich, robust sauces focusing entirely on flavor profile, sweet notes, and gourmet marinades without any heat.</p>
            
            <div class="product-cont">
                <?php
                $non_spicy_query = "SELECT * FROM products WHERE category = 'non-spicy' ORDER BY id ASC";
                $non_spicy_result = mysqli_query($conn, $non_spicy_query);
                
                if ($non_spicy_result && mysqli_num_rows($non_spicy_result) > 0) {
                    while ($product = mysqli_fetch_assoc($non_spicy_result)) {
                        $p_id = $product['id'];
                        $p_name = htmlspecialchars($product['name']);
                        $p_price = number_format($product['price'], 2);
                        $p_image = htmlspecialchars($product['image']);
                        ?>
                        <div class="product1">
                            <img src="assets/images/<?php echo $p_image; ?>" alt="<?php echo $p_name; ?>">
                            <div class="des poppins-font">
                                <h5><?php echo $p_name; ?></h5>
                                <div class="star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-o"></i>
                                </div>
                                <h4>₱<?php echo $p_price; ?></h4>
                            </div>
                            
                            <div class="action-wrapper poppins-font">
                                <a href="backend/cart.php?action=add&product_id=<?php echo $p_id; ?>" class="cart-btn" style="text-align: center; display: block;"><i class="fa-solid fa-cart-plus"></i> Add To Cart</a>
                                <a href="index.php?page=details&id=<?php echo $p_id; ?>" class="view-btn" title="View Details"><i class="fa-solid fa-eye"></i></a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p style='color: white;'>No products found in database.</p>";
                }
                ?>
            </div>
            
        </div>
    </section>
</main>
