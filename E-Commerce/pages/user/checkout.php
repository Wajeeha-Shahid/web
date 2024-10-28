<?php
session_start(); // Start session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/styles.css"> 
    <link rel="stylesheet" href="../../assets/css/navbar.css"> 
    <link rel="stylesheet" href="../../assets/css/checkout.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>CheckOut</title>
</head>
<body>
<?php include '../../includes/navbar.php'; ?> <!-- Include the navbar -->
    <div class="checkout-container">
        <h2 class="text-danger">Checkout</h2>
        <table>
        <thead>
    <tr>
        <th>Product Name</th>
        <th>Product Type</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Cancel</th>
    </tr>
</thead>
            <tbody>
                <?php
                // Check if cart is not empty
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $index => $product) {
                        echo "<tr>";
                        echo "<td>{$product['prod_name']}</td>";
                        echo "<td>{$product['prod_type']}</td>";
                        echo "<td>Rs {$product['prod_price']}</td>";
                        echo "<td>{$product['quantity']}</td>";
                        echo "<td>Rs {$product['total_price']}</td>"; // Show total price
                        echo "<td>
                                <form method='post' action='delete_from_cart.php'>
                                    <input type='hidden' name='index' value='{$index}'>
                                    <button type='submit' class='delete-btn'>❌</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                }else {
                    echo "<tr><td colspan='7'>Your cart is empty</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        // Display place order button only if cart is not empty
        if (isset($_SESSION['username']) && !empty($_SESSION['cart'])) {
            echo "<button class='place-order-btn bg-danger' onclick='redirectToCheckout()'>Place Order</button>";
        } elseif (empty($_SESSION['cart'])) {
            echo "<p style='color: red; font-weight: bold;'>Cart can't be empty to place an order</p>";
        } else {
            echo "<button class='place-order-btn bg-danger' onclick='redirectToLogin()'>Login to Place Order</button>";
        }
        ?>
    </div>
</body>
<script>
    // checkout 
function redirectToCheckout() {
    window.location.href = 'place_order.php';
}
function redirectToLogin() {
    window.location.href = 'login.php';
}
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="../../assets/js/script.js"></script>
</html>