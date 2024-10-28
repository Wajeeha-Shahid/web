<?php
session_start();

// Define admin credentials
$admin_username = 'admin'; // Set your admin username here
$admin_password = 'password123'; // Set your admin password here

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_username'] = $username; // Set session variable
        header('Location: admin_panel.php'); // Redirect to the admin panel
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Login</title>
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
        h2 {
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
        .alert-danger {
            color: #e60000; /* Red text color for error messages */
            background-color: #f8d7da; /* Light red background */
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
