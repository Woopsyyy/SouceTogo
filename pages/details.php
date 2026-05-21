<?php
// Direct-access protection
if (!defined('SECURE_ACCESS')) {
    header("Location: ../index.php");
    exit();
}
// Product details page view
$p_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($p_id <= 0) {
    header("Location: index.php?page=order");
    exit();
}

$query = "SELECT * FROM products WHERE id = $p_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<main class='details-body'><div class='product-details'><div class='single-pro-details'><h4>Product Not Found</h4><a href='index.php?page=order' class='btn' style='display:inline-block;padding:10px 20px;text-align:center;'>Back to Shop</a></div></div></main>";
    return;
}

$product = mysqli_fetch_assoc($result);
$p_name = htmlspecialchars($product['name']);
$p_desc = htmlspecialchars($product['description']);
$p_price = number_format($product['price'], 2);
$p_image = htmlspecialchars($product['image']);
$p_category = htmlspecialchars($product['category']);
?>
<main class="details-body">
    <section class="product-details section-p1">
        <div class="single-pro-image">
            <img src="assets/images/<?php echo $p_image; ?>" id="MainImg" alt="<?php echo $p_name; ?>">
        </div>
        
        <div class="single-pro-details">
            <div class="breadcrumbs poppins-font">
                <a href="index.php?page=home">Home</a> / <a href="index.php?page=order">Order Now</a> / <?php echo $p_name; ?>
            </div>
            
            <h4><?php echo $p_name; ?></h4>
            <h2>₱<?php echo $p_price; ?></h2>
            
            <div class="poppins-font" style="margin-bottom: 20px;">
                <span style="background: var(--primary-color); border: 1px solid rgba(255,255,255,0.2); color: var(--white-color); padding: 5px 15px; border-radius: 15px; text-transform: uppercase; font-size: 0.9rem; font-weight: 600;">Category: <?php echo $p_category; ?> Sauce</span>
            </div>
            
            <form action="backend/cart.php" method="POST" class="purchase-info poppins-font">
                <input type="hidden" name="action" value="add_quantity">
                <input type="hidden" name="product_id" value="<?php echo $p_id; ?>">
                
                <label for="quantity" style="font-weight: 500; font-size: 1.1rem; color: #eee;">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="99">
                <button type="submit" class="normal">Add To Cart</button>
            </form>
            
            <h5 class="desc-title">Product Description</h5>
            <span class="desc-text"><?php echo $p_desc; ?> SauceToGo is made with 100% natural, premium selected local ingredients. Carefully crafted in micro-batches to guarantee freshness, rich aroma, and premium texture, our formula works flawlessly as a tabletop dipping condiment, gourmet marinade, or grilling basting sauce. No artificial colors or toxic chemical preservatives. Keep refrigerated after opening for optimal flavor conservation.</span>
        </div>
    </section>
</main>
