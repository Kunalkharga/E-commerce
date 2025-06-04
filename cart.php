<?php
require_once 'includes/db_connect.php';
session_start();

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $index => $quantity) {
        $quantity = intval($quantity);
        if ($quantity > 0 && $quantity <= 10) {
            $_SESSION['cart'][$index]['quantity'] = $quantity;
        }
    }
    header("Location: cart.php");
    exit;
}

// Handle remove item
if (isset($_GET['remove'])) {
    $index = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
    }
    header("Location: cart.php");
    exit;
}

// Calculate totals
$total_items = 0;
$total_price = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
        $total_price += $item['price'] * $item['quantity'];
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="cart-main-content">
    <div class="cart-products-section">
        <h2 class="cart-section-title">Shopping Cart</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty. <a href="<?php echo BASE_URL; ?>products.php">Shop now!</a></p>
        <?php else: ?>
            <form method="POST" action="cart.php">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                            <tr>
                                <td>
                                    <div class="cart-item">
                                        <img src="<?php echo BASE_URL; ?>assets/images/product-images/<?php echo htmlspecialchars($item['image']); ?>"
                                            alt="<?php echo htmlspecialchars($item['name']); ?>" class="cart-item-image">
                                        <span><?php echo htmlspecialchars($item['name']); ?></span>
                                    </div>
                                </td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <div class="cart-quantity-selector">
                                        <button type="button" class="cart-quantity-btn cart-minus"><i class="fas fa-minus"></i></button>
                                        <input type="number" name="quantities[<?php echo $index; ?>]" value="<?php echo $item['quantity']; ?>" min="1" max="10" class="cart-quantity-input">
                                        <button type="button" class="cart-quantity-btn cart-plus"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
                                <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $index; ?>" class="cart-remove-item" onclick="return confirm('Remove this item?');">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-actions">
                    <button type="submit" name="update_cart" class="cart-btn-update">Update Cart</button>
                    <a href="checkout.php" class="cart-btn-checkout">Proceed to Checkout</a>
                </div>
            </form>
            <div class="cart-summary">
                <h3>Cart Summary</h3>
                <p>Total Items: <?php echo $total_items; ?></p>
                <p>Total Price: $<?php echo number_format($total_price, 2); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>