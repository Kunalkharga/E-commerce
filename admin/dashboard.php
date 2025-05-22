<?php
require_once '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Admin Dashboard</h2>
    <ul>
        <li><a href="products.php">Manage Products</a></li>
        <li><a href="orders.php">Manage Orders</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
<?php include '../includes/footer.php'; ?>