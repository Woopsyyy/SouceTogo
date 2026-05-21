<?php
// Database connection configuration
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "saucetogodb";
$conn = "";

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
} catch (Exception $e) {
    // Silent fail in production or log error
}

if (!$conn) {
    // Fallback error reporting
    die("<div style='font-family:sans-serif;padding:20px;background:#fde8e8;color:#e53e3e;border:1px solid #f8b4b4;border-radius:8px;max-width:600px;margin:50px auto;'>
        <h3 style='margin-top:0;'>Database Connection Error</h3>
        <p>Could not connect to database <strong>$db_name</strong> on server <strong>$db_server</strong>.</p>
        <p>Please make sure XAMPP (Apache and MySQL) is running and the database <strong>sauce-db.sql</strong> has been imported.</p>
    </div>");
}
?>
