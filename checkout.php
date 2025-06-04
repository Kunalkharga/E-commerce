<?php
require_once 'includes/db_connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $user_id = $_SESSION['user_id'];
    $total = 0;
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    if (empty($cart)) {
        $error = "Your cart is empty.";
    } else {
        try {
            $pdo->beginTransaction();
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$user_id, $total, 'pending']);
            $order_id = $pdo->lastInsertId();
            unset($_SESSION['cart']);
            $pdo->commit();
            $success = "Order placed successfully! Order ID: $order_id";
            header("Refresh: 3; URL=index.php");
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Error placing order: " . $e->getMessage();
        }
    }
}

// Fetch cart for display
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<?php include 'includes/header.php'; ?>
<div class="checkout-main-content">
    <div class="checkout-grid">
        <div class="checkout-order-summary">
            <h2 class="checkout-section-title">Order Summary</h2>
            <?php if (isset($success)): ?>
                <div class="checkout-success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php elseif (isset($error)): ?>
                <div class="checkout-error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (empty($cart)): ?>
                <p>Your cart is empty. <a href="index.php">Continue shopping</a></p>
            <?php else: ?>
                <table class="checkout-cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
        </div>
        <div class="checkout-shipping-info">
            <h2 class="checkout-section-title">Shipping Information</h2>
            <?php if (!empty($cart)): ?>
                <form method="POST" action="checkout.php">
                    <div class="checkout-form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="checkout-form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="checkout-form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="checkout-form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    <button type="submit" name="place_order" class="checkout-btn">Place Order</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>