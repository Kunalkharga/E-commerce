<?php 
session_start();
include 'header.php'; 

// Get cart items from session
$cart = $_SESSION['cart'] ?? [];
?>

<div class="container">
  <h1>Shopping Cart</h1>
  
  <?php if(empty($cart)): ?>
    <p>Your cart is empty</p>
  <?php else: ?>
    <div class="cart-items">
      <?php foreach($cart as $item): ?>
      <div class="cart-item">
        <img src="images/<?= $item['image'] ?>">
        <div class="item-details">
          <h3><?= $item['name'] ?></h3>
          <input type="number" value="<?= $item['quantity'] ?>" min="1">
          <p>Rs.<?= $item['price'] * $item['quantity'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    
    <div class="cart-totals">
      <p>Total: Rs.<?= array_sum(array_column($cart, 'total')) ?></p>
      <a href="checkout.php" class="btn">Checkout</a>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>