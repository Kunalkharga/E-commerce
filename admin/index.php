<?php
require_once __DIR__ . '../config.php';
require_once '../admin/includes/db.php';

$db = new Database();
$conn = $db->getConnection();

// Get all products
$products = [];
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id 
        ORDER BY p.product_id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing head content -->
</head>
<body>
    <!-- Your existing navbar -->

    <!-- Products Section -->
    <section class="container">
        <h2 class="section-title">Our Products</h2>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if ($product['is_featured']): ?>
                        <div class="product-badge">Hot</div>
                    <?php endif; ?>
                    <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                    <div class="product-rating">
                        <!-- Rating stars would go here -->
                    </div>
                    <h3 class="product-name"><?= $product['name'] ?></h3>
                    <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
                    <div class="quantity-selector">
                        <!-- Quantity selector would go here -->
                    </div>
                    <button class="add-to-cart">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Your existing footer -->
</body>
</html>