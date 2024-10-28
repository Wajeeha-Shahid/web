<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['index'])) {
    $index = $_POST['index'];

    // Remove the product from the cart
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        
        // Reindex the array to maintain consistency
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    // Redirect back to the checkout page
    header("Location: checkout.php");
    exit();
} else {
    // Redirect to some error page if the form data is not submitted correctly
    header("Location: error.php");
    exit();
}
?>