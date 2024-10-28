<?php
// Database connection parameters
$servername = "localhost"; // Change if necessary
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "e_commerce";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create tables if they do not exist
function createTables($conn) {
    // Create products table
    $create_products_table = "CREATE TABLE IF NOT EXISTS products (
        prod_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        prod_name VARCHAR(255) NOT NULL,
        prod_brand VARCHAR(255) NOT NULL,
        prod_img VARCHAR(255) NOT NULL,
        prod_type VARCHAR(50) NOT NULL,
        prod_total_quantity INT(11) NOT NULL
    )";

    // Create productsizes table
    $create_productsizes_table = "CREATE TABLE IF NOT EXISTS productsizes (
        size_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        prod_id INT(11) NOT NULL,
        prod_price DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (prod_id) REFERENCES products(prod_id) ON DELETE CASCADE
    )";

    // Execute the table creation queries
    if ($conn->query($create_products_table) === TRUE) {
        // Table products created successfully
    } else {
        echo "Error creating products table: " . $conn->error;
    }

    if ($conn->query($create_productsizes_table) === TRUE) {
        // Table productsizes created successfully
    } else {
        echo "Error creating productsizes table: " . $conn->error;
    }
}

// Create the tables
createTables($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prod_name = $_POST['prod_name'];
    $prod_brand = $_POST['prod_brand'];
    $prod_img = $_POST['prod_img'];
    $prod_type = $_POST['prod_type'];
    $prod_total_quantity = $_POST['prod_total_quantity'];
    $prod_price = $_POST['prod_price']; // Get product price

    // Prepare and bind for inserting into products
    $stmt = $conn->prepare("INSERT INTO products (prod_name, prod_brand, prod_img, prod_type, prod_total_quantity) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $prod_name, $prod_brand, $prod_img, $prod_type, $prod_total_quantity);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the last inserted product ID
        $prod_id = $conn->insert_id;

        // Prepare and bind for inserting into productsizes
        $stmt_price = $conn->prepare("INSERT INTO productsizes (prod_id, prod_price) VALUES (?, ?)");
        $stmt_price->bind_param("id", $prod_id, $prod_price);

        // Execute the statement for product price
        if ($stmt_price->execute()) {
            echo "New product and price added successfully";
        } else {
            echo "Error adding price: " . $stmt_price->error;
        }

        // Close the statement for productsizes
        $stmt_price->close();
    } else {
        echo "Error adding product: " . $stmt->error;
    }

    // Close the statement for products
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css"> <!-- Link to your custom CSS file -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
</head>
<body>

    <!-- Responsive Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="admin_panel.php">Pending Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="completed_orders.php">Completed Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stock.php">Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="addproducts.php">Add Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="admin_logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Add New Product</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="prod_name">Product Name:</label>
                <input type="text" id="prod_name" name="prod_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prod_brand">Product Brand:</label>
                <input type="text" id="prod_brand" name="prod_brand" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prod_img">Product Image URL:</label>
                <input type="text" id="prod_img" name="prod_img" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prod_type">Product Type:</label>
                <select id="prod_type" name="prod_type" class="form-control" required>
                    <option value="">Select Product Type</option>
                    <option value="Pesticides">Pesticides</option>
                    <option value="Fertilizers">Fertilizers</option>
                    <option value="Seeds">Seeds</option>
                </select>
            </div>

            <div class="form-group">
                <label for="prod_total_quantity">Total Quantity:</label>
                <input type="number" id="prod_total_quantity" name="prod_total_quantity" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prod_price">Product Price:</label>
                <input type="number" id="prod_price" name="prod_price" class="form-control" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Add Product</button>
        </form>
    </div>
    <!-- Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
</body>
</html>
