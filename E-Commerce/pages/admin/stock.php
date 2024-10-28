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

// Handle quantity update
if (isset($_POST['update_quantity'])) {
    $prod_id = $_POST['prod_id'];
    $new_quantity = $_POST['new_quantity'];

    $update_query = "UPDATE products SET prod_total_quantity = '$new_quantity' WHERE prod_id = '$prod_id'";
    mysqli_query($conn, $update_query);
}

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $prod_id = $_POST['prod_id'];

    // Delete from productsizes first to maintain referential integrity
    $delete_sizes_query = "DELETE FROM productsizes WHERE prod_id = '$prod_id'";
    mysqli_query($conn, $delete_sizes_query);

    // Delete from products table
    $delete_product_query = "DELETE FROM products WHERE prod_id = '$prod_id'";
    mysqli_query($conn, $delete_product_query);
}

// Fetch products with their sizes and prices
$query = "
    SELECT p.prod_id, p.prod_name, p.prod_img, p.prod_type, p.prod_total_quantity, ps.prod_price 
    FROM products p 
    JOIN productsizes ps ON p.prod_id = ps.prod_id
"; // Join products with productsizes
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Admin Panel - Product Stocks</title>
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 50px; }
        .table { background-color: white; border-radius: 8px; }
        .table th { background-color: #007bff; color: white; }
        h2 { margin-bottom: 20px; }
        .navbar-toggler { border: none; }
        .navbar-toggler:focus { outline: none; box-shadow: none; }
        .edit-quantity-form { display: none; } /* Hide by default */
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="admin_panel.php">Pending Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="completed_orders.php">Completed Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="stock.php">Stock</a></li>
                <li class="nav-item"><a class="nav-link" href="addproducts.php">Add Products</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main content -->
<div class="container">
    <h2>Product Stocks</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Image</th>
                <th>Product Type</th>
                <th>Total Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['prod_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['prod_name']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['prod_img']); ?>" alt="<?php echo htmlspecialchars($row['prod_name']); ?>" width="50"></td>
                    <td><?php echo htmlspecialchars($row['prod_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['prod_total_quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['prod_price']); ?></td>
                    <td>
                        <!-- Edit Quantity Button -->
                        <button class="btn btn-primary btn-sm" onclick="showEditForm(<?php echo $row['prod_id']; ?>)">Update Quantity</button>
                        
                        <!-- Hidden Edit Form -->
                        <form method="POST" class="edit-quantity-form" id="editForm-<?php echo $row['prod_id']; ?>">
                            <input type="hidden" name="prod_id" value="<?php echo $row['prod_id']; ?>">
                            <input type="number" name="new_quantity" placeholder="Enter new quantity" required>
                            <button type="submit" name="update_quantity" class="btn btn-success btn-sm">Update</button>
                        </form>
                        
                        <!-- Delete Button -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="prod_id" value="<?php echo $row['prod_id']; ?>">
                            <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

<script>
    function showEditForm(prodId) {
        // Hide all edit forms
        document.querySelectorAll('.edit-quantity-form').forEach(form => form.style.display = 'none');
        
        // Show the selected form
        document.getElementById('editForm-' + prodId).style.display = 'inline-block';
    }
</script>

</body>
</html>
