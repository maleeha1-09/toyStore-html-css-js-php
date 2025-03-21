<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add Admin
    if (isset($_POST['add_admin'])) {
        $username = $_POST['username'];
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO admin (username, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password_hash);
        $stmt->execute();
    }

    // Delete Admin
    if (isset($_POST['delete_admin'])) {
        $admin_id = $_POST['admin_id'];
        $stmt = $conn->prepare("DELETE FROM admin WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
    }
}

$admins = $conn->query("SELECT * FROM admin");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="header">
    <a href="admin_dashboard.php" class="go-back-button">&#8592; Go Back</a>
    <h1>Manage Admins</h1>
</div>

    
    <!-- Add Admin Form -->
    <form method="POST">
        <h3>Add New Admin</h3>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="add_admin">Add Admin</button>
    </form>

    <h3>Admins</h3>
    <table>
        <thead>
            <tr>
                <th>Admin ID</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($admin = $admins->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $admin['admin_id']; ?></td>
                    <td><?php echo $admin['username']; ?></td>
                    <td>
                        <!-- Delete Admin -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>">
                            <button type="submit" name="delete_admin">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
