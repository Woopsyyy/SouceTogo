<?php
// Reusable page footer
$active_page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
    <!-- Footer Section -->
    <footer class="footer-section">
        <div class="section-content">
            <p class="copyright-text">© <?php echo date("Y"); ?> SauceToGo. All rights reserved.</p>

            <div class="social-link-list">
                <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
            </div>
            
            <p class="policy-text">
                <a href="#" class="policy-link">Privacy Policy</a>
                <span class="separator">●</span>
                <a href="#" class="policy-link">Refund Policy</a>
            </p>
        </div>
    </footer>

    <!-- Swiper and Custom JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Page Specific Script Imports -->
    <?php if ($active_page === 'login'): ?>
        <script src="assets/js/login.js"></script>
    <?php endif; ?>
</body>
</html>
