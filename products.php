<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add Product
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $name, $description, $price, $stock);
        $stmt->execute();
    }

    // Delete Product
    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];
        $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
    }

    // Update Product
    if (isset($_POST['update_product'])) {
        $product_id = $_POST['product_id'];
        $stock = $_POST['stock'];
        $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE product_id = ?");
        $stmt->bind_param("ii", $stock, $product_id);
        $stmt->execute();
    }
}

$products = $conn->query("SELECT * FROM products");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="header">
    <a href="admin_dashboard.php" class="go-back-button">&#8592; Go Back</a>
    <h1>Manage Products</h1>
</div>

    <!-- Add Product Form -->
    <form method="POST">
        <h3>Add New Product</h3>
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Product Description"></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <h3>Products</h3>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td>
                        <!-- Edit Product Stock -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="number" name="stock" value="<?php echo $product['stock']; ?>">
                            <button type="submit" name="update_product">Update Stock</button>
                        </form>
                        <!-- Delete Product -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <button type="submit" name="delete_product">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
