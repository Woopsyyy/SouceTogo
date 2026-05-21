<?php
// Contact us message handler (JSON API endpoint)
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$name = trim(mysqli_real_escape_string($conn, $_POST['name'] ?? ''));
$email = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
$message = trim(mysqli_real_escape_string($conn, $_POST['message'] ?? ''));

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit();
}

// Simple email format validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address format.']);
    exit();
}

// Insert into contact messages
$query = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Thank you! Your message has been sent successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save message. Please try again later.']);
}
exit();
?>
