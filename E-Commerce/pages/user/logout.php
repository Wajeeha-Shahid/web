<?php
session_start(); // Start session
session_destroy(); // Destroy the session
header("Location: ../../index.php"); // Redirect to the homepage
exit();
?>
