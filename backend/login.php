<?php
// Login action handler
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php?page=login");
    exit();
}

$username = trim(mysqli_real_escape_string($conn, $_POST['username'] ?? ''));
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Username and password are required.";
    header("Location: ../index.php?page=login");
    exit();
}

// Check database for user by username or email
$query = "SELECT * FROM users WHERE username = '$username' OR email = '$username' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    // Verify password hash
    if (password_verify($password, $user['password'])) {
        // Create session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect to homepage or previous state
        header("Location: ../index.php?page=home");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid username or password.";
    }
} else {
    $_SESSION['login_error'] = "Invalid username or password.";
}

header("Location: ../index.php?page=login");
exit();
?>
