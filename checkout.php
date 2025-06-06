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
            // Removed the auto-redirect to prevent the message from disappearing
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
    <?php if (isset($success)): ?>
        <div class="checkout-order-container">
            <div class="checkout-order-summary">
                <h2 class="checkout-section-title">Order Summary</h2>
                <div class="checkout-success-message">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Thank You for Your Order!</h3>
                    <p><?php echo htmlspecialchars($success); ?></p>
                    <p>Placed at 05:21 PM +0545 on Friday, June 06, 2025. You’ll receive a confirmation email with tracking details soon.</p>
                    <a href="index.php" class="btn-primary">Continue Shopping</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="checkout-grid">
            <div class="checkout-order-summary">
                <h2 class="checkout-section-title">Order Summary</h2>
                <?php if (isset($error)): ?>
                    <div class="checkout-error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php else: ?>
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
                <?php endif; ?>
            </div>
            <div class="checkout-shipping-info">
                <h2 class="checkout-section-title">Shipping Information</h2>
                <?php if (!empty($cart)): ?>
                    <form method="POST" action="checkout.php">
                        <div class="checkout-form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        <div class="checkout-form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="checkout-form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>
                        <div class="checkout-form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" placeholder="Enter your shipping address" required></textarea>
                        </div>
                        <button type="submit" name="place_order" class="checkout-btn">Place Order</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>