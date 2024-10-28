<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Order Confirmation</title>
    <style>
        body {
            background-color: #f8f9fa; /* Light background for better contrast */
            height: 100vh; /* Full height */
            display: flex; /* Flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            text-align: center; /* Center text */
        }
        .confirmation-card {
            padding: 20px;
            background-color: white; /* White background for card */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Light shadow */
        }
        .btn-custom {
            margin: 10px 5px; /* Space between buttons */
        }
    </style>
</head>
<body>
    <div class="confirmation-card">
        <h1 class="mb-4">Your Order is Placed Successfully!</h1>
        <p>Thank you for your purchase. We appreciate your business!</p>
        <a href="../../index.php" class="btn btn-primary btn-custom">Continue Shopping</a>
        <a href="logout.php" class="btn btn-secondary btn-custom">Logout</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
