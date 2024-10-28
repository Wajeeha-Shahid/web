<?php
session_start();

$host = 'localhost'; // Database host
$dbname = 'e_commerce'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header('Location: admin_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];

    // Update order status to completed
    $query = "UPDATE orders SET order_status = 'completed' WHERE id = '$orderId'";
    mysqli_query($conn, $query);

    // Redirect back to admin panel
    header('Location: admin_panel.php');
    exit;
}
?>
