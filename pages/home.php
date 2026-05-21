<!-- Master Home View -->
<?php
// Direct-access protection
if (!defined('SECURE_ACCESS')) {
    header("Location: ../index.php");
    exit();
}
?>

<main>
    <!-- Intro Hero Section -->
    <section class="hero-section">
        <div class="section-content">
            <div class="hero-details">
                <h2 class="gradient-text">Excellent Sauce</h2>
                <h3 class="subtitle poppins-font">Masarap Kahit Walang Manok</h3>
                <p class="description poppins-font">Welcome to SauceToGo, where every drop of SauceToGo tells a story and every dip sparks joy.</p>
                <div class="buttons">
                    <a href="index.php?page=order" class="button">Order Now!</a>
                </div>
            </div>
            <div class="hero-image-wrapper">
                <img src="assets/images/sauce1.png" alt="SauceToGo Signature Bottle" class="hero-image">
            </div>
        </div>
    </section>

    <!-- Dynamic Menu Section (Using Swiper Carousel) -->
    <section class="menu-section" id="menu">
        <h2 class="section-title">Our Signature Blends</h2>
        
        <div class="menu-container swiper">
            <div class="swiper-wrapper">
                <?php
                // Dynamically fetch featured products from database (spicy category first)
                $menu_query = "SELECT * FROM products ORDER BY category DESC, id ASC";
                $menu_result = mysqli_query($conn, $menu_query);
                
                if ($menu_result && mysqli_num_rows($menu_result) > 0) {
                    while ($product = mysqli_fetch_assoc($menu_result)) {
                        $p_id = $product['id'];
                        $p_name = htmlspecialchars($product['name']);
                        $p_desc = htmlspecialchars($product['description']);
                        $p_image = htmlspecialchars($product['image']);
                        $p_price = number_format($product['price'], 2);
                        $p_cat = htmlspecialchars($product['category']);
                        ?>
                        <div class="swiper-slide">
                            <div class="menu-item">
                                <img src="assets/images/<?php echo $p_image; ?>" alt="<?php echo $p_name; ?>" class="menu-image">
                                <h3 class="name"><?php echo $p_name; ?></h3>
                                <p class="text"><?php echo $p_desc; ?></p>
                                <div style="margin-top: 15px;">
                                    <span style="background: var(--secondary-color); color: var(--primary-color); padding: 4px 10px; border-radius: 12px; font-weight: bold; font-family:'Poppins',sans-serif; font-size: 0.85rem; text-transform: uppercase;"><?php echo $p_cat; ?></span>
                                    <span style="font-size: 1.3rem; margin-left: 10px; font-weight: bold;">₱<?php echo $p_price; ?></span>
                                </div>
                                <a href="index.php?page=details&id=<?php echo $p_id; ?>" class="button poppins-font" style="margin-top: 15px; padding: 6px 20px; font-size: 0.9rem; font-weight: 600;">View Details</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p style='text-align:center;width:100%;'>No dynamic products seeded yet. Please run database.sql in your DB.</p>";
                }
                ?>
            </div>

            <!-- Swiper Control Navigations -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-section" id="about">
        <div class="section-content">
            <div class="about-image-wrapper">
                <img src="assets/images/about us.jpg" alt="About SauceToGo Kitchen" class="about-image">
            </div>
            <div class="about-details">
                <h2 class="section-title">About Us</h2>
                <p class="text poppins-font">Where Every Drop Tells a Story.

                At SauceToGo, we believe that a meal without the right sauce is just... unfinished. Whether you're firing up the grill for a backyard BBQ, looking for that perfect spicy kick for your tacos, or needing a sophisticated glaze for a weeknight dinner, we are here to make sure you never have to settle for "bland" again.

                <strong>Our Flavor Philosophy</strong>
                We didn’t start in a boardroom; we started in a kitchen. Our journey began with a simple obsession: finding the perfect balance between heat, sweetness, and tang. We grew tired of the mass-produced, watery condiments found on supermarket shelves, so we decided to bottle the good stuff ourselves.

                <strong>Why choose us?</strong>
                • Small-Batch Integrity: We craft our sauces in small quantities to ensure that every bottle meets our high standards for flavor and freshness.
                • Bold Ingredients: From sun-ripened habaneros to aged vinegars and secret spice blends, we only use what belongs in a kitchen—never in a chemistry lab.
                • Versatility First: Our sauces are designed to be pantry workhorses. Use them as marinades, dipping sauces, or finishing glazes.</p>
                
                <div class="social-link-list">
                    <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <h2 class="section-title">Contact Us</h2>
        <div class="section-content">
            <ul class="contact-info-list poppins-font">
                <li class="contact-info">
                    <i class="fa-solid fa-location-crosshairs"></i>
                    <p>15 Base St, Talisay, Cebu</p>
                </li>
                <li class="contact-info">
                    <i class="fa-regular fa-envelope"></i>
                    <p>joshuareybasubas09@gmail.com</p>
                </li>
                <li class="contact-info">
                    <i class="fa-solid fa-phone"></i>
                    <p>09939057782</p>
                </li>
                <li class="contact-info">
                    <i class="fa-solid fa-clock"></i>
                    <p>Monday - Friday 9:00AM - 5:00PM <br>
                    Saturday and Sunday Closed</p>
                </li>
            </ul>

            <form action="backend/contact.php" method="POST" id="contactForm" class="contact-form">
                <input type="text" placeholder="Your Name" class="form-input" required>
                <input type="email" placeholder="Your Email" class="form-input" required>
                <textarea placeholder="Your Message" class="form-input" required></textarea>
                <button type="submit" class="submit-button">Submit Message</button>
                <p id="responseMessage" class="success-msg">
                    Thank you! Your message has been sent to our customer care team.
                </p>
            </form>
        </div>
    </section>
</main>
