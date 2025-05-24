<?php
require_once 'includes/db_connect.php';
session_start();

// Fetch products for best sellers
$stmt = $pdo->query("SELECT * FROM products WHERE badge = 'Hot' OR badge = 'Popular' LIMIT 8");
$products = $stmt->fetchAll();
?>

<?php include 'includes/header.php'; ?>
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Everything Your Dog Deserves – Delivered to Your Door!</h1>
            <p>Discover the finest selection of pet food and accessories for your furry friends. Quality products at
                affordable prices with fast delivery.</p>
            <a href="products.php" class="btn">Shop Now</a>
        </div>
        <div class="hero-image">
            <img src="assets/images/hero-dog.png" alt="Happy Dog">
        </div>
    </div>
</section>
<!-- Categories Section -->
<section class="container">
    <h2 class="section-title">Top Categories</h2>
    <div class="categories">
        <div class="category-card">
            <div class="category-icon">
                <i class="fas fa-bone"></i>
            </div>
            <h3>Food & Nutrition</h3>
            <p>Premium nutrition for your canine companion</p>
            <a href="food&nutritions.html" class="btn">Shop Now</a>
        </div>


        <div class="category-card">
            <div class="category-icon">
                <i class="fas fa-paw"></i>
            </div>
            <h3>Dog Accessories</h3>
            <p>Everything your pet needs for a happy life</p>
            <a href="dog-aaccessories.html" class="btn">Shop Now</a>
        </div>

        <div class="category-card">
            <div class="category-icon">
                <i class="fas fa-pills"></i>
            </div>
            <h3>Dog Health</h3>
            <p>Keep your pet healthy and happy</p>
            <a href="doghealth.html" class="btn">Shop Now</a>
        </div>

    </div>
</section>

<section class="container">
    <h2 class="section-title">Best Sellers</h2>
    <!-- <div class="container"> -->
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
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
    <!-- </div> -->
</section>
<!-- Features Section -->
<section class="container">
    <div class="features">
        <div class="feature">
            <i class="fas fa-truck"></i>
            <h3>Instant Delivery</h3>
            <p>In Mirpur and Surrounding Areas From 10am-8pm</p>
        </div>

        <div class="feature">
            <i class="fas fa-tag"></i>
            <h3>Best Price</h3>
            <p>PetPapa offers best possible pricing in market.</p>
        </div>

        <div class="feature">
            <i class="fas fa-lock"></i>
            <h3>Secure Payment</h3>
            <p>Your payment is 100% secure with PetPapa most locations.</p>
        </div>

        <div class="feature">
            <i class="fas fa-headset"></i>
            <h3>24/7 Support</h3>
            <p>Our dedicated support team is available 7 days a week!</p>
        </div>
    </div>
</section>

<!-- Popular Brands Section -->
<section class="popular-brands">
    <div class="container-full">
        <h2 class="section-title">
            <span class="popular-text">Popular</span> <span class="brands-text">Brands</span>
        </h2>
        <div class="brands-grid">
            <div class="brand-item">
                <img src="assets/images/brand2.png" alt="drools">
            </div>
            <div class="brand-item">
                <img src="assets/images/brand6.webp" alt="jungle">
            </div>
            <div class="brand-item">
                <img src="assets/images/brand1.webp" alt="Gerry pet">
            </div>
            <div class="brand-item">
                <img src="assets/images/brand3.png" alt="Ckaniva">
            </div>
            <div class="brand-item">
                <img src="assets/images/brand4.png" alt="Bonacibo">
            </div>
            <div class="brand-item">
                <img src="assets/images/brand5.webp" alt="haseinper">
            </div>
        </div>
    </div>
</section>


<?php include 'includes/footer.php'; ?>