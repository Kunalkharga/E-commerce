<?php
require_once '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Doggy E-commerce</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #004080;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }

        .sidebar h3 {
            text-align: center;
            padding: 10px;
            background: #F9942A;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            padding: 15px 20px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .sidebar ul li a:hover {
            background-color: #F9942A;
            padding-left: 25px;
            transition: padding-left 0.3s ease;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .header {
            background-color: #004080;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 5px solid #F9942A;
        }

        .header h2 {
            font-size: 24px;
        }

        .header .logout-btn {
            background: #F9942A;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .header .logout-btn:hover {
            background: #e07e2c;
        }

        .content-area {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .content-area h3 {
            color: #004080;
            margin-bottom: 15px;
        }

        .content-area ul {
            list-style: none;
        }

        .content-area ul li {
            margin: 10px 0;
        }

        .content-area ul li a {
            color: #004080;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
        }

        .content-area ul li a:hover {
            color: #F9942A;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
            .header h2 {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 10px;
            }
            .header {
                flex-direction: column;
                gap: 10px;
            }
            .header h2 {
                font-size: 18px;
            }
            .content-area {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="products.php"><i class="fas fa-boxes"></i> Manage Products</a></li>
                <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h2>Admin Dashboard</h2>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content-area">
                <h3>Welcome, Admin!</h3>
                <p>Manage your e-commerce store efficiently with the following options:</p>
                <ul>
                    <li><a href="products.php">Manage Products</a></li>
                    <li><a href="orders.php">Manage Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>