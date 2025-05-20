<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 12;
$offset = ($page - 1) * $perPage;

// Get products
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name 
                      FROM products p 
                      JOIN categories c ON p.category_id = c.id 
                      WHERE p.is_active = 1 
                      ORDER BY p.created_at DESC 
                      LIMIT :offset, :perPage");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();

// Get total count for pagination
$total = $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1")->fetchColumn();
$totalPages = ceil($total / $perPage);

$pageTitle = "All Products";
include '../includes/header.php';
?>

<div class="container main-content">
    <div class="sidebar">
        <h3 class="sidebar-title">Categories</h3>
        <ul class="category-list">
            <?php
            $categories = $pdo->query("SELECT * FROM categories")->fetchAll();
            foreach ($categories as $category):
            ?>
                <li>
                    <a href="/products/<?php echo htmlspecialchars($category['slug']); ?>.php">
                        <i class="<?php echo htmlspecialchars($category['icon_class']); ?>"></i> 
                        <?php echo htmlspecialchars($category['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <section class="products-section">
        <h2 class="section-title">All Products</h2>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if ($product['old_price']): ?>
                        <div class="product-badge">Sale</div>
                    <?php endif; ?>
                    
                    <img src="/assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                    
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(24)</span>
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
                        <input type="number" value="1" min="1" max="99" class="quantity-input" readonly>
                        <button class="quantity-btn plus"><i class="fas fa-plus"></i></button>
                    </div>

                    <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($i === $page) echo 'class="active"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>