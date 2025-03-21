<?php
session_start();
include('db_connection.php'); // Make sure your db_connection.php file is included

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$orderPlaced = false; // Flag to track if the order was placed successfully
$orderDetails = []; // To store order details for the popup

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'];

    // Calculate total amount (this should be based on the cart contents; assuming you calculate it here)
    $total = 100.00; // Placeholder for total amount. Replace this with your actual calculation.

    $query = "INSERT INTO orders (user_id, total_amount, address) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ids", $user_id, $total, $address); // Assuming $total is calculated earlier
    $stmt->execute();
    
    $orderPlaced = true; // Set the flag to true when the order is placed successfully

    // Store order details for the popup
    $orderDetails = [
        'name' => $name,
        'email' => $email,
        'address' => $address,
        'total' => $total
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f7f7f7;
        }

        header {
            background-color: #4a90e2;
            color: #fff;
            width: 100%;
            text-align: center;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 28px;
        }

        .navbar nav ul {
            list-style: none;
            padding: 0;
            margin-top: 10px;
            display: inline-flex;
        }

        .navbar nav ul li {
            margin: 0 15px;
        }

        .navbar nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .navbar nav ul li a:hover {
            color: #ddd;
        }

        .order-form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .order-form-container h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #357ab7;
        }

        footer {
            margin-top: 20px;
            text-align: center;
            width: 100%;
            padding: 10px 0;
            background-color: #333;
            color: #fff;
        }

        /* Popup Modal */
        .popup-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .popup-content p {
            margin-bottom: 20px;
        }

        .popup-content button {
            padding: 10px 20px;
            background-color: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .popup-content button:hover {
            background-color: #357ab7;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>KID PALACE</h1>
            <nav>
                <ul>
                    <li><a href="toyStore.php">Home</a></li>
                    <li><a href="toyStore.php#products">Products</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="order-section">
        <div class="order-form-container">
            <h2>Place Your Order</h2>
            <form method="POST" id="order-form" action="placeOrder.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" placeholder="Enter your address" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Submit Order</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Popup Modal for Order Confirmation -->
    <?php if ($orderPlaced): ?>
        <div id="popupModal" class="popup-modal">
            <div class="popup-content">
                <p>Order placed successfully!</p>
                <p><strong>Order Details:</strong></p>
                <ul>
                    <li>Name: <?php echo htmlspecialchars($orderDetails['name']); ?></li>
                    <li>Email: <?php echo htmlspecialchars($orderDetails['email']); ?></li>
                    <li>Address: <?php echo htmlspecialchars($orderDetails['address']); ?></li>
                    <li>Total Amount: $<?php echo htmlspecialchars($orderDetails['total']); ?></li>
                </ul>
                <button onclick="closePopup()">Close</button>
            </div>
        </div>
        <script>
            // Show the popup modal after the order is placed
            document.getElementById('popupModal').style.display = 'flex';

            // Function to close the popup
            function closePopup() {
                document.getElementById('popupModal').style.display = 'none';
            }
        </script>
    <?php endif; ?>

    <footer>
        <p>&copy; 2024 Kid Palace. All rights reserved.</p>
    </footer>
</body>
</html>
