<?php
// Direct-access protection
if (!defined('SECURE_ACCESS')) {
    header("Location: ../index.php");
    exit();
}
// Auth template
if (isset($_SESSION['user_id'])) {
    header("Location: index.php?page=home");
    exit();
}
?>
<main class="login-page">
    <div class="login-container">
        <div class="section">
            <!-- Login Form -->
            <div class="form-box login">
                <form action="backend/login.php" method="POST">
                    <h1>Login</h1>
                    
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <p class="backend-msg"><?php echo htmlspecialchars($_SESSION['login_error']); ?></p>
                        <?php unset($_SESSION['login_error']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['register_success'])): ?>
                        <p class="backend-msg" style="color: #2ecc71;"><?php echo htmlspecialchars($_SESSION['register_success']); ?></p>
                        <?php unset($_SESSION['register_success']); ?>
                    <?php endif; ?>
                    
                    <div class="input-box poppins-font">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box poppins-font">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    
                    <button type="submit" class="btn">Login</button>
                    
                    <div class="register-link poppins-font">
                        <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                    </div>
                </form>
            </div>

            <!-- Registration Form -->
            <div class="form-box register">
                <form action="backend/register.php" method="POST">
                    <h1>Registration</h1>
                    
                    <?php if (isset($_SESSION['register_error'])): ?>
                        <p class="backend-msg"><?php echo htmlspecialchars($_SESSION['register_error']); ?></p>
                        <?php unset($_SESSION['register_error']); ?>
                    <?php endif; ?>
                    
                    <div class="input-box poppins-font">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box poppins-font">
                        <input type="email" name="email" placeholder="Email Address" required>
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box poppins-font">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    
                    <button type="submit" class="btn">Register</button>
                    
                    <div class="login-link poppins-font">
                        <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
