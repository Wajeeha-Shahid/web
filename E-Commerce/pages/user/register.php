<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "e_commerce");

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create users table if it does not exist
$create_table_query = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $create_table_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email']; // Get the email from the form
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if username or email already exists
    $check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($result) == 0) {
        // Insert new user
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        mysqli_query($conn, $query);
        header("Location: login.php"); // Redirect to login page after registration
        exit();
    } else {
        echo "Username or email already exists.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff; /* White background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-card {
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
        .btn-primary {
            background-color: #e60000; /* Red button background */
            border-color: #e60000; /* Red border for the button */
        }
        .btn-primary:hover {
            background-color: #cc0000; /* Darker red on hover */
            border-color: #cc0000;
        }
        .form-label {
            color: #000; /* Black color for labels */
        }
        .text-center a {
            color: #e60000; /* Red color for the link */
        }
        .text-center a:hover {
            color: #cc0000; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h1>Register</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required placeholder="Enter username">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary p-1 w-100">Register</button>
        </form>
        <p class="text-center mt-3"><a href="login.php">Already have an account? Login here</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
