<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "e_commerce");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user['id']; // Assuming there's an 'id' field in the users table

        // Set the redirect URL based on the referrer
        $referer = isset($_SERVER['HTTP_REFERER']) ? basename($_SERVER['HTTP_REFERER']) : 'index.php';

        // Redirect based on the referring page
        if ($referer === 'index.php') {
            header("Location: ../../index.php"); // Redirect to index.php
        } elseif ($referer === 'checkout.php') {
            header("Location: place_order.php"); // Redirect to place_order.php
        } else {
            header("Location: ../../index.php"); // Default redirect
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Login</title>
    <style>
        body {
            background-color: #fff; /* White background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background-color: #fff; /* White background for the card */
            padding: 30px; /* Increased padding */
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px; /* Increased maximum width */
        }
        h1 {
            color: #e60000; /* Red color for the heading */
            text-align: center;
            margin-bottom: 25px; /* Added space below the heading */
        }
        .btn-success {
            background-color: #e60000; /* Red button background */
            border-color: #e60000; /* Red border for the button */
        }
        .btn-success:hover {
            background-color: #cc0000; /* Darker red on hover */
            border-color: #cc0000;
        }
        .form-label {
            color: #000; /* Black color for labels */
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Login</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" id="exampleInputEmail1" name="username" required placeholder="Username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" required placeholder="Password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-success p-1 w-100">Login</button>
        </form>
        <p class="text-center mt-3 "><a href="register.php" class="text-danger">Doesn't have account? register here</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



