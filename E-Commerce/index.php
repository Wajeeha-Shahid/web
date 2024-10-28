<?php
session_start(); // Start session

// Connect to MySQL server
$conn = mysqli_connect("localhost", "root", "");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the e_commerce database if it doesn't exist
$dbName = "e_commerce";
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if (mysqli_query($conn, $sql)) {
    // If the database was successfully created or already exists, connect to it
    mysqli_select_db($conn, $dbName);
} else {
    die("Error creating database: " . mysqli_error($conn));
}

// Now you can proceed to connect to the tables within the database
// Example logic to check if login form was submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example logic to check if credentials are valid
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'"; // Use prepared statements to prevent SQL injection
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username; // Set session variable for username
        
        // Check if redirect URL is set
        if (isset($_SESSION['redirect_after_login'])) {
            $redirectUrl = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']); // Clear the redirect URL
            header("Location: $redirectUrl"); // Redirect to the set URL
        } else {
            header("Location: index.php"); // Default redirection to index
        }
        exit();
    } else {
        echo "Invalid username or password."; // You can replace this with a more user-friendly message
    }
}

// Check if the user was redirected to login from the checkout
if (isset($_GET['redirect']) && $_GET['redirect'] == 'checkout') {
    $_SESSION['redirect_after_login'] = 'place_order.php'; // Set redirect to place_order.php after login
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="./assets/css/navbar.css">
     <link rel="stylesheet" href="./assets/css/footer.css">
     <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>E-Commerce-Website</title>
</head>
<body>
   
    <header>

        <?php include './includes/navbar.php'; ?> <!-- Include the navbar -->
        <!-- nav 3 end -->
        <!-- feature start -->
        <section >
        <div  id="carouselExampleDark" class="carousel carousel-dark slide " >
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
      <img src="https://t3.ftcdn.net/jpg/02/70/87/46/360_F_270874621_FtM3ZXcixJ9SAJ28lIaEwVsPB7f1kr7q.webp"   style="height:80vh" class="d-block w-100" alt="...">
     
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="https://t4.ftcdn.net/jpg/02/21/34/43/240_F_221344370_divU4PPEj49VhfthdlnAxA3rD3TAzuZT.jpg" class="d-block w-100" alt="..." style="height:80vh">
     
    </div>
    <div class="carousel-item">
      <img src="https://t3.ftcdn.net/jpg/01/78/38/80/240_F_178388074_v7Fi8wj1K9AydlUh59bjpSIRJR62nGMY.jpg" class="d-block w-100" alt="..." style="height:80vh">
     
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
        </section>
        <!-- feature end -->
    </header>

    <!-- latest start -->
    <section class="latest" >
        <div style="margin-top: 4rem;" class="product-intro">
            <h1>New  <span> Arrival </span></h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab optio, iure vitae doloribus veritatis neque perspiciatis quam quas esse id sunt porro consectetur, ipsum officia laborum voluptas doloremque! Voluptatem, cupiditate.</p>
        </div>        
        <!-- php code -->
        <?php include './pages/user/card.php'; ?>
        <!-- php end -->
    </section>
    <!-- latest end -->
    <?php include './includes/footer.php'; ?> <!-- Include the footer -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/script.js"></script>  
    <script src="script.js"></script>  

</body>
</html>
