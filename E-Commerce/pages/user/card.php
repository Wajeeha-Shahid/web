

 

 <?php
    // Connection to the server
    $conn = mysqli_connect("localhost", "root", "", "e_commerce");
    
    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Initial SQL query to select data from the Products table
    $sql = "SELECT 
                p.prod_id, 
                p.prod_name, 
                p.prod_brand, 
                p.prod_total_quantity, 
                p.prod_type, 
                p.prod_img,
                (SELECT prod_price FROM productsizes WHERE prod_id = p.prod_id ORDER BY RAND() LIMIT 1) AS prod_price
            FROM 
                products p";

    // Check if the category parameter is set and not empty
    if(isset($_GET['category']) && !empty($_GET['category'])) {
        $category = $_GET['category'];
        // Add WHERE clause to filter products by category
        $sql .= " WHERE p.prod_type = '$category'";
    }

    // Execute SQL query
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Counter to keep track of cards per row
        $counter = 0;

        // Output data of each row as a card
        echo '<div class="row">'; // Start a row for cards
        while ($row = $result->fetch_assoc()) {
            // Output the product card
            echo '<div  style="width:320px;height:350px"  class="col-lg-3 col-md-4 col-sm-6 mb-4">'; // Responsive columns
            echo '    <div class="card h-100 border-1">'; // Use h-100 to maintain card height
            echo '        <a href="pages/user/product_detail.php?prod_id=' . $row["prod_id"] . '" style="text-decoration: none; color: inherit;">';
            echo '            <img class="card-img-top" style="height:200px"  src="' . $row["prod_img"] . '" alt="' . $row["prod_name"] . '">';
            echo '            <div class="card-body">';
            echo '                <h5 class="card-title">' . $row["prod_name"] . '</h5>'; // Use h5 for smaller headings
            echo '                <p>Rs ' . $row["prod_price"] . '</p>';
            echo '                <button class="btn btn-dark  w-100">View</button>'; // Button style for consistency
            echo '            </div>';
            echo '        </a>';
            echo '    </div>';
            echo '</div>';

            // Increment the counter
            $counter++;
        }
        echo '</div>'; // Close the row
    } else {
        echo "There are no such products.";
    }

    // Close the database connection
    $conn->close();
?>
