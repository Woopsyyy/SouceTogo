<?php
// Register action handler
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php?page=login");
    exit();
}

$username = trim(mysqli_real_escape_string($conn, $_POST['username'] ?? ''));
$email = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

if (empty($username) || empty($email) || empty($password)) {
    $_SESSION['register_error'] = "All fields are required.";
    header("Location: ../index.php?page=login");
    exit();
}

// Check username or email duplication
$check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
$check_result = mysqli_query($conn, $check_query);

if ($check_result && mysqli_num_rows($check_result) > 0) {
    $existing = mysqli_fetch_assoc($check_result);
    if ($existing['username'] === $username) {
        $_SESSION['register_error'] = "Username is already taken.";
    } else {
        $_SESSION['register_error'] = "Email address is already registered.";
    }
    header("Location: ../index.php?page=login");
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert into users
$insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

if (mysqli_query($conn, $insert_query)) {
    $new_user_id = mysqli_insert_id($conn);
    
    // Automatically log user in
    $_SESSION['user_id'] = $new_user_id;
    $_SESSION['username'] = $username;
    $_SESSION['register_success'] = "Registration successful! Welcome to SauceToGo.";
    
    header("Location: ../index.php?page=home");
    exit();
} else {
    $_SESSION['register_error'] = "Failed to register. Please try again later.";
    header("Location: ../index.php?page=login");
    exit();
}
?>
