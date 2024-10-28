<?php
session_start(); // Start session
// Connection to the server
$conn = mysqli_connect("localhost", "root", "", "e_commerce");

$product_id = isset($_GET['prod_id']) ? $_GET['prod_id'] : 1; // Default to 1 if no ID is provided

// Fetch product details
$sql_product = "SELECT * FROM products WHERE prod_id = $product_id";
$result_product = $conn->query($sql_product);

if ($result_product->num_rows > 0) {
    $product = $result_product->fetch_assoc();
} else {
    echo "Product not found.";
    exit;
}

// Check product quantity
$current_quantity = $product['prod_total_quantity']; // Assuming this is the column for total quantity

// Fetch product prices
$sql_sizes = "SELECT * FROM productsizes WHERE prod_id = $product_id";
$result_sizes = $conn->query($sql_sizes);
$sizes = [];
while ($row = $result_sizes->fetch_assoc()) {
    $sizes[] = $row;
}

// Use the first product image as default
$default_image = $product['prod_img'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/product_detail.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Product-Detail</title>
    <style>
        #prod_price {
            font-size: 20px;
            color: #333;
        }
        .out-of-stock {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include '../../includes/navbar.php'; ?> <!-- Include the navbar -->
    <div class="product-detail">
        <img src="<?php echo $default_image; ?>" alt="Product Image">
        <div class="product-name"><?php echo $product['prod_name']; ?></div>
        <div class="prices">
            <label>Price: </label>
            <span id="prod_price">Rs <?php echo $sizes[0]['prod_price']; ?></span>
        </div>
        <div class="quantity">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $current_quantity; ?>" value="1" onchange="updatePrice()">
        </div>

        <?php if ($current_quantity > 0): ?>
            <form method="post" action="cart.php">
                <input type="hidden" name="prod_id" value="<?php echo $product['prod_id']; ?>">
                <input type="hidden" name="prod_type" value="<?php echo $product['prod_type']; ?>">
                <input type="hidden" name="prod_name" value="<?php echo $product['prod_name']; ?>">
                <input type="hidden" name="prod_price" value="<?php echo $sizes[0]['prod_price']; ?>">
                <input type="hidden" name="prod_img" value="<?php echo $default_image; ?>">
                <input type="hidden" name="quantity" value="1" id="hidden_quantity">
                <input type="hidden" name="total_price" value="" id="hidden_total_price">
                <button type="submit" name="add_to_cart" class="add-to-cart bg-dark" onclick="selectionValidate(event)">Add to Cart</button>
            </form>
        <?php else: ?>
            <div class="out-of-stock">This product is out of stock.</div>
            <button class="add-to-cart" disabled>Add to Cart</button>
        <?php endif; ?>
    </div>
    <script>
      
    function updatePrice() {
        var quantity = document.getElementById('quantity').value;
        var price = <?php echo $sizes[0]['prod_price']; ?>;
        var totalPrice = price * quantity;

        // Update the display
        document.getElementById('prod_price').innerText = "Rs " + totalPrice;

        // Set hidden input fields for form submission
        document.getElementById('hidden_quantity').value = quantity;
        document.getElementById('hidden_total_price').value = totalPrice;
    }

    // Function to validate the customer selection
    function selectionValidate(event) {
        var quantity = document.getElementById('quantity').value;
        var availableQuantity = <?php echo $current_quantity; ?>; // Get available quantity from PHP

        if (quantity < 1) {
            // If quantity is less than 1, display an error message
            alert("Please select a valid quantity before adding to cart.");
            event.preventDefault(); // Prevent the form submission
        } else if (quantity > availableQuantity) {
            // If quantity exceeds available stock, show an error
            alert("The requested quantity exceeds available stock. Please select a quantity of " + availableQuantity + " or less.");
            event.preventDefault(); // Prevent the form submission
        }
    }
</script>
<script  src="../../assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
</body>
</html>
