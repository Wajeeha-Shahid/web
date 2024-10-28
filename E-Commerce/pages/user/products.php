<?php
session_start(); // Start session
// Connection to the server
$conn = mysqli_connect("localhost", "root", "", "e_commerce");

// Check if prod_type is set in the URL
$prod_type = isset($_GET['prod_type']) ? $_GET['prod_type'] : null;

// If no prod_type is set, redirect back to index or show an error
if (!$prod_type) {
    echo "Product category not specified.";
    exit;
}

// Fetch products based on prod_type
$sql = "SELECT * FROM products WHERE prod_type = '$prod_type'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title><?php echo ucfirst($prod_type); ?> Products</title>
</head>
<body>
<?php include '../../includes/navbar.php'; ?>

<div class="products-list container">
    <?php
    if ($result->num_rows > 0) {
        echo '<div class="row">'; // Start a row for cards
        while ($product = $result->fetch_assoc()) {
            // Fetch price from productsizes table based on prod_id
            $prod_id = $product['prod_id'];
            $sql_price = "SELECT * FROM productsizes WHERE prod_id = $prod_id";
            $result_price = $conn->query($sql_price);
            $price = $result_price->fetch_assoc()['prod_price'];

            // Display the product details
            echo "<div class='product-item col-lg-3 col-md-4 col-sm-6 mb-4 mt-5' style='height:350px;width:320px'>";
            echo '    <div class="card h-100 border-1">'; // Use h-100 to maintain card height
            
            echo "<img src='" . $product['prod_img'] . "' alt='Product Image' style='height:200px'>";
            echo '            <div class="card-body">';
            echo "<h5 class='product-name'>" . $product['prod_name'] . "</h5>";
            echo "<p class='product-price'>Price: Rs " . $price . "</p>";
            echo "<a href='product_detail.php?prod_id=" . $product['prod_id'] . "' class='btn w-100 bg-dark text-white'>View Details</a>";
            echo "</div>";
            
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No products available in this category.</p>";
    }
    ?>

</div>

 <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../../assets/js/script.js"></script>  
    <script src="script.js"></script>  
</body>
</html>
