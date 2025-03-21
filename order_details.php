<?php
// Including database connection
include('db_connection.php');

// Fetch all orders along with related user and product details
$query = "
    SELECT 
        o.order_id, o.user_id, o.total_amount, o.address, o.order_status, o.created_at,
        COALESCE(u.username, 'Unknown') AS username,
        COALESCE(u.email, 'Unknown') AS email,
        p.name AS product_name, od.quantity, od.price
    FROM orders o
    LEFT JOIN orderdetails od ON o.order_id = od.order_id
    LEFT JOIN users u ON o.user_id = u.user_id
    LEFT JOIN products p ON od.product_id = p.product_id
    ORDER BY o.order_id DESC;
";

$orders = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="header">
    <a href="admin_dashboard.php" class="go-back-button">&#8592; Go Back</a>
    <h1>Order Details</h1>
</div>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Amount</th>
                <th>Address</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Username</th>
                <th>Email</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($orders->num_rows > 0) {
                // Display the data for each order
                while ($order = $orders->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $order['order_id'] . "</td>";
                    echo "<td>" . (isset($order['user_id']) ? $order['user_id'] : 'N/A') . "</td>";
                    echo "<td>" . $order['total_amount'] . "</td>";
                    echo "<td>" . $order['address'] . "</td>";
                    echo "<td>" . $order['order_status'] . "</td>";
                    echo "<td>" . $order['created_at'] . "</td>";
                    echo "<td>" . $order['username'] . "</td>";
                    echo "<td>" . $order['email'] . "</td>";
                    echo "<td>" . $order['product_name'] . "</td>";
                    echo "<td>" . $order['quantity'] . "</td>";
                    echo "<td>" . $order['price'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No orders found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
