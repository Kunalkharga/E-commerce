<?php
require_once 'includes/db_connect.php';
session_start();

// Fetch products for Dog Health category
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE c.name = ?");
$stmt->execute(['Dog Health']);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>
<div class="main-content">
    <div class="products-section">
        <h2 class="section-title">Dog Health</h2>
        <div class="products-grid">
            <?php if (empty($products)): ?>
                <p>No products found in this category.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card" data-product-id="<?php echo $product['id']; ?>">
                        <?php if ($product['badge']): ?>
                            <span class="product-badge"><?php echo htmlspecialchars($product['badge']); ?></span>
                        <?php endif; ?>
                        <img src="<?php echo BASE_URL; ?>assets/images/product-images/<?php echo htmlspecialchars($product['image']); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                        <div class="product-rating">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star <?php echo $i < $product['rating'] ? '' : 'far'; ?>"></i>
                            <?php endfor; ?>
                            <span>(<?php echo $product['rating']; ?>)</span>
                        </div>
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="product-price">
                            $<?php echo number_format($product['price'], 2); ?>
                            <?php if ($product['old_price']): ?>
                                <span class="old-price">$<?php echo number_format($product['old_price'], 2); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="quantity-selector">
                            <button class="quantity-btn minus"><i class="fas fa-minus"></i></button>
                            <input type="number" value="1" min="1" max="10" class="quantity-input">
                            <button class="quantity-btn plus"><i class="fas fa-plus"></i></button>
                        </div>
                        <button class="add-to-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>