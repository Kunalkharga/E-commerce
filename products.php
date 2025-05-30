<?php
require_once 'includes/db_connect.php';
session_start();

// Fetch categories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

// Fetch products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll();
?>

<?php include 'includes/header.php'; ?>
<div class="main-content">
    <div class="sidebar">
        <h3 class="sidebar-title">Categories</h3>
        <ul class="category-list">
            <?php foreach ($categories as $category): 
                // Custom mapping for category URLs to match exact filenames
                $category_name = $category['name'];
                $category_url = strtolower(str_replace(' ', '-', $category_name)); // Basic transformation
                // Specific fixes for your filenames
                if ($category_name == 'Food & Nutrition') $category_url = 'food-nutrition';
                elseif ($category_name == 'Dog Health') $category_url = 'doghealth';
                ?>
                <li><a href="<?php echo $category_url . '.php'; ?>">
                        <i class="fas fa-paw"></i> <?php echo htmlspecialchars($category['name']); ?>
                    </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="products-section">
        <h2 class="section-title">All Products</h2>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card" data-product-id="<?php echo $product['id']; ?>">
                    <?php if ($product['badge']): ?>
                        <span class="product-badge"><?php echo htmlspecialchars($product['badge']); ?></span>
                    <?php endif; ?>
                    <img src="<?php echo BASE_URL; ?>assets/images/product-images/<?php echo $product['image']; ?>"
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
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>