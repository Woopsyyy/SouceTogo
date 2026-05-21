<?php
// Logout action handler
session_start();
session_unset();
session_destroy();

header("Location: ../index.php?page=home");
exit();
?>
