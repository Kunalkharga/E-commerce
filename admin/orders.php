<?php
require_once '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id = u.id");
$orders = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);
    header("Location: orders.php");
    exit;
}

// Fetch summary stats
$stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
$total_orders = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as pending FROM orders WHERE status = 'pending'");
$pending_orders = $stmt->fetch()['pending'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Doggy E-commerce</title>
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

        .summary-boxes {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .summary-box {
            flex: 1;
            background: #004080;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .summary-box h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .summary-box p {
            font-size: 24px;
            font-weight: bold;
            color: #F9942A;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #004080;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-submit {
            background: #F9942A;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background: #e07e2c;
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
            .summary-boxes {
                flex-direction: column;
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
            table, th, td {
                font-size: 14px;
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
                <h2>Manage Orders</h2>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content-area">
                <h3>Order Overview</h3>
                <div class="summary-boxes">
                    <div class="summary-box">
                        <h4>Total Orders</h4>
                        <p><?php echo $total_orders; ?></p>
                    </div>
                    <div class="summary-box">
                        <h4>Pending Orders</h4>
                        <p><?php echo $pending_orders; ?></p>
                    </div>
                </div>

                <h3>Order List</h3>
                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['username']); ?></td>
                            <td>Rs.<?php echo number_format($order['total'], ); ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status">
                                        <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="shipped" <?php echo $order['status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn-submit">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>