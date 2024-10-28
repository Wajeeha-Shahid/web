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

// Create the orders table if it doesn't exist
$tableCreationQuery = "
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    payment_method ENUM('easy_paisa', 'jazz_cash') NOT NULL,
    transaction_id VARCHAR(255) NOT NULL,
    order_status ENUM('pending', 'completed') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $tableCreationQuery)) {
    die("Error creating table: " . mysqli_error($conn));
}

// Check if user is logged in and cart is not empty
if (!isset($_SESSION['username']) || empty($_SESSION['cart'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the order
    $address = $_POST['address'];
    $paymentMethod = $_POST['payment_method'];
    $transactionId = $_POST['transaction_id']; // Manually entered transaction ID

    // Validate payment info
    if (empty($transactionId)) {
        $error = "Transaction ID is required for payment verification.";
    } else {
        $username = $_SESSION['username']; // Assuming username is stored in session
        $orderStatus = 'pending';

        // Flag to check if the order can be placed
        $canPlaceOrder = true;

        // Insert each product in the cart into the orders table
        foreach ($_SESSION['cart'] as $product) {
            $prodName = $product['prod_name'];
            $prodPrice = $product['prod_price'];
            $quantity = $product['quantity'];
            $totalPrice = $product['total_price'];

            // Check if the product is available in the products table
            $query = "SELECT * FROM products WHERE prod_name = '$prodName'";
            $result = mysqli_query($conn, $query);
            $productData = mysqli_fetch_assoc($result);

            if ($productData) {
                // If quantity is less than the ordered quantity, set flag to false
                if ($productData['prod_total_quantity'] < $quantity) {
                    $error = "Not enough quantity for {$prodName}. Available: {$productData['prod_total_quantity']}.";
                    $canPlaceOrder = false;
                    break;
                }
            } else {
                $error = "Product {$prodName} not found.";
                $canPlaceOrder = false;
                break;
            }
        }

        // If we can place the order, proceed
        if ($canPlaceOrder) {
            foreach ($_SESSION['cart'] as $product) {
                $prodName = $product['prod_name'];
                $prodPrice = $product['prod_price'];
                $quantity = $product['quantity'];
                $totalPrice = $product['total_price'];

                // Insert order into the orders table
                $query = "INSERT INTO orders (username, address, product_name, price, quantity, total_price, payment_method, transaction_id, order_status) 
                          VALUES ('$username', '$address', '$prodName', '$prodPrice', '$quantity', '$totalPrice', '$paymentMethod', '$transactionId', '$orderStatus')";
                mysqli_query($conn, $query);

                // Update the product quantity in the products table
                $query = "UPDATE products SET prod_total_quantity = prod_total_quantity - $quantity WHERE prod_name = '$prodName'";
                mysqli_query($conn, $query);
            }

            // Clear the cart after order placement
            unset($_SESSION['cart']);

            // Redirect to order confirmation page
            header('Location: order_confirmation.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/place_order.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Place Order</title>
    
</head>
<body>
    <?php include '../../includes/navbar.php'; ?> <!-- Include the navbar -->

    <div class="container">
        <div class="place-order-container">
            <h2>Place Your Order</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="place_order.php">
                <div class="mb-3">
                    <label for="address" class="form-label">Delivery Address</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter your address" required>
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select id="payment_method" name="payment_method" class="form-select" required>
                        <option value="easy_paisa">Easy Paisa</option>
                        <option value="jazz_cash">JazzCash</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="transaction_id" class="form-label">Transaction ID</label>
                    <input type="text" id="transaction_id" name="transaction_id" class="form-control" placeholder="Enter your transaction ID" required>
                </div>
                <button type="submit" class="btn btn-danger w-100 mt-3">Confirm Order</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>  
</body>
</html>
                