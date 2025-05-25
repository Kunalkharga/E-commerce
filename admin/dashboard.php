<?php
require_once '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Determine which section to display
$section = isset($_GET['section']) ? $_GET['section'] : 'overview';

// Fetch categories for product management
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

// Handle product creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : null;
    $rating = $_POST['rating'];
    $badge = trim($_POST['badge']);
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];

    // Handle image upload
    $target_dir = "../assets/images/product-images/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, description, price, old_price, image, rating, badge, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$category_id, $name, $description, $price, $old_price, $image, $rating, $badge, $stock]);
    header("Location: dashboard.php?section=manage-products");
    exit;
}

// Fetch products for product list
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll();

// Fetch product summary stats
$stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
$total_products = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as out_of_stock FROM products WHERE stock = 0");
$out_of_stock = $stmt->fetch()['out_of_stock'];

// Fetch orders for manage orders
$stmt = $pdo->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id = u.id");
$orders = $stmt->fetchAll();

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);
    header("Location: dashboard.php?section=manage-orders");
    exit;
}

// Fetch order summary stats
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

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #F9942A;
        }

        .btn-submit {
            background: #F9942A;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background: #e07e2c;
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

        td a {
            color: #F9942A;
            text-decoration: none;
            margin-right: 10px;
        }

        td a:hover {
            text-decoration: underline;
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
                <li><a href="dashboard.php?section=overview" class="<?php echo $section == 'overview' ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="dashboard.php?section=manage-products" class="<?php echo $section == 'manage-products' ? 'active' : ''; ?>"><i class="fas fa-boxes"></i> Manage Products</a></li>
                <li><a href="dashboard.php?section=product-list" class="<?php echo $section == 'product-list' ? 'active' : ''; ?>"><i class="fas fa-list"></i> Product List</a></li>
                <li><a href="dashboard.php?section=manage-orders" class="<?php echo $section == 'manage-orders' ? 'active' : ''; ?>"><i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h2>
                    <?php
                    if ($section == 'overview') echo 'Admin Dashboard';
                    elseif ($section == 'manage-products') echo 'Manage Products';
                    elseif ($section == 'product-list') echo 'Product List';
                    elseif ($section == 'manage-orders') echo 'Manage Orders';
                    ?>
                </h2>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="content-area">
                <?php if ($section == 'overview'): ?>
                    <h3>Welcome, Admin!</h3>
                    <p>Manage your Doggy E-commerce store efficiently with the following options:</p>
                    <div class="summary-boxes">
                        <div class="summary-box">
                            <h4>Total Products</h4>
                            <p><?php echo $total_products; ?></p>
                        </div>
                        <div class="summary-box">
                            <h4>Total Orders</h4>
                            <p><?php echo $total_orders; ?></p>
                        </div>
                    </div>
                    <p>Use the sidebar to navigate between managing products, viewing the product list, and managing orders.</p>

                <?php elseif ($section == 'manage-products'): ?>
                    <h3>Add New Product</h3>
                    <div class="summary-boxes">
                        <div class="summary-box">
                            <h4>Total Products</h4>
                            <p><?php echo $total_products; ?></p>
                        </div>
                        <div class="summary-box">
                            <h4>Out of Stock</h4>
                            <p><?php echo $out_of_stock; ?></p>
                        </div>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="old_price">Old Price (optional)</label>
                            <input type="number" step="0.01" name="old_price">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" required>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating (0-5)</label>
                            <input type="number" name="rating" min="0" max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="badge">Badge (e.g., Hot, New, Sale)</label>
                            <input type="text" name="badge">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" required>
                        </div>
                        <button type="submit" name="add_product" class="btn-submit">Add Product</button>
                    </form>

                <?php elseif ($section == 'product-list'): ?>
                    <h3>Product List</h3>
                    <div class="summary-boxes">
                        <div class="summary-box">
                            <h4>Total Products</h4>
                            <p><?php echo $total_products; ?></p>
                        </div>
                        <div class="summary-box">
                            <h4>Out of Stock</h4>
                            <p><?php echo $out_of_stock; ?></p>
                        </div>
                    </div>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php elseif ($section == 'manage-orders'): ?>
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
                                <td>$<?php echo number_format($order['total'], 2); ?></td>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>