<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add Order
    if (isset($_POST['add_order'])) {
        $user_id = $_POST['user_id'];
        $total_amount = $_POST['total_amount'];
        $address = $_POST['address'];
        $order_status = $_POST['order_status'];

        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, address, order_status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $user_id, $total_amount, $address, $order_status);
        $stmt->execute();
    }

    // Delete Order
    if (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
    }

    // Update Order
    if (isset($_POST['update_order'])) {
        $order_id = $_POST['order_id'];
        $order_status = $_POST['order_status'];
        $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $order_status, $order_id);
        $stmt->execute();
    }
}

$orders = $conn->query("SELECT * FROM orders");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="header">
    <a href="admin_dashboard.php" class="go-back-button">&#8592; Go Back</a>
    <h1>Manage Orders</h1>
</div>

  
    
    <!-- Add Order Form -->
    <form method="POST">
        <h3>Add New Order</h3>
        <input type="number" name="user_id" placeholder="User ID" required>
        <input type="number" step="0.01" name="total_amount" placeholder="Total Amount" required>
        <input type="text" name="address" placeholder="Address" required>
        <select name="order_status">
            <option value="Pending">Pending</option>
            <option value="Shipped">Shipped</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
        </select>
        <button type="submit" name="add_order">Add Order</button>
    </form>

    <h3>Orders</h3>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Amount</th>
                <th>Address</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['total_amount']; ?></td>
                    <td><?php echo $order['address']; ?></td>
                    <td><?php echo $order['order_status']; ?></td>
                    <td>
                        <!-- Edit Order Status -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <select name="order_status">
                                <option value="Pending" <?php echo $order['order_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Shipped" <?php echo $order['order_status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo $order['order_status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo $order['order_status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_order">Update</button>
                        </form>
                        <!-- Delete Order -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <button type="submit" name="delete_order">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
