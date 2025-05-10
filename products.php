<?php include 'header.php'; ?>

<div class="container">
  <h1>All Products</h1>
  <div class="product-filters">
    <!-- Category/Price Filters -->
  </div>
  
  <div class="product-grid">
    <?php 
    // Fetch products from database
    $stmt = $pdo->query("SELECT * FROM products");
    while($product = $stmt->fetch()):
    ?>
    <div class="product-card">
      <img src="images/<?= $product['image_url'] ?>">
      <h3><?= $product['name'] ?></h3>
      <p>Rs.<?= $product['price'] ?></p>
      <a href="product.php?id=<?= $product['id'] ?>" class="btn">View Product</a>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'footer.php'; ?>