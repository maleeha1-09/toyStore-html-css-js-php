<?php
session_start();
include('db_connection.php');

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
        }

        .dashboard-links {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 20px;
        }

        .dashboard-links a {
            text-decoration: none;
            width: 200px;
        }

        .dashboard-links button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .dashboard-links button:hover {
            background-color: #45a049;
        }

        .logout-button {
            margin-top: 30px;
        }

        .logout-button a {
            text-decoration: none;
            width: 200px;
        }

        .logout-button button {
            width: 100%;
            padding: 12px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button button:hover {
            background-color: #d32f2f;


        }
    </style>
</head>
<body>

<h1>Welcome to Admin Dashboard</h1>

<div class="dashboard-container">
    <!-- Navigation Buttons for Admin Management -->
    <div class="dashboard-links">
        <a href="orders.php"><button>Manage Orders</button></a>
        <a href="admins.php"><button>Manage Admins</button></a>
        <a href="products.php"><button>Manage Products</button></a>
        <a href="users.php"><button>Manage Users</button></a>
        <a href="order_details.php"><button>Order Details</button></a>

    </div>

    <!-- Logout Button -->
    <div class="logout-button">
        <a href="logout.php"><button>Logout</button></a>
    </div>
</div>

</body>
</html>
