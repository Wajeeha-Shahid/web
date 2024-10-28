<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $prod_id = $_POST['prod_id'];
    $prod_type = $_POST['prod_type'];
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; 
    $total_price = $_POST['total_price']; // Get total price

    $product = [
        'prod_id' => $prod_id,
        'prod_type' => $prod_type,
        'prod_name' => $prod_name,
        'prod_price' => $prod_price,
        'quantity' => $quantity, 
        'total_price' => $total_price // Include total price here
    ];

    // Check if the cart session exists
    if (isset($_SESSION['cart'])) {
        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['prod_id'] === $prod_id) {
                $cartItem['quantity'] += $quantity;
                // $cartItem['total_price'] += $total_price; // Update total price
                $cartItem['total_price'] = (float)$cartItem['total_price'] + (float)$total_price;

                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = $product;
        }
    } else {
        $_SESSION['cart'] = [$product];
    }

    // Redirect to checkout page after adding to cart
    header("Location: checkout.php?prod_id=$prod_id");
    exit();
} else {
    // Redirect to some error page if the form data is not submitted correctly
    header("Location: error.php");
    exit();
}
?>
