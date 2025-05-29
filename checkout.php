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
            // Start transaction
            $pdo->beginTransaction();

            // Calculate total and prepare order data
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Insert into orders table
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$user_id, $total, 'pending']);
            $order_id = $pdo->lastInsertId();

            // Insert into order_items table
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cart as $item) {
                // $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
            }

            // Clear cart
            unset($_SESSION['cart']);

            // Commit transaction
            $pdo->commit();

            $success = "Order placed successfully! Order ID: $order_id";
            header("Refresh: 3; URL=index.php"); // Redirect to home after 3 seconds
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
<div class="main-content">
    <div class="checkout-section">
        <h2 class="section-title">Checkout</h2>

        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <p>Your cart is empty. <a href="index.php">Continue shopping</a></p>
        <?php else: ?>
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <table class="cart-table">
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
                                <td>
                                    <div class="quantity-selector">
                                        <button class="quantity-btn minus"><i class="fas fa-minus"></i></button>
                                        <input type="number" value="<?php echo $item['quantity']; ?>" min="1" max="10" class="quantity-input" readonly>
                                        <button class="quantity-btn plus"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
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
            </div>

            <div class="checkout-form">
                <h3>Shipping Information</h3>
                <form method="POST" action="checkout.php">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    <button type="submit" name="place_order" class="btn">Place Order</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>

<script>
document.querySelectorAll('.cart-table .quantity-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const input = this.parentElement.querySelector('.quantity-input');
        let value = parseInt(input.value);
        if (this.classList.contains('minus')) {
            value = value > 1 ? value - 1 : 1;
        } else if (this.classList.contains('plus')) {
            value = value < 10 ? value + 1 : 10;
        }
        input.value = value;
        // Update subtotal dynamically (client-side only, not persisted)
        const row = this.closest('tr');
        const price = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('$', ''));
        row.querySelector('td:nth-child(4)').textContent = '$' + (price * value).toFixed(2);
        // Update total
        updateTotal();
    });
});

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.cart-table tbody tr').forEach(row => {
        const price = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('$', ''));
        const quantity = parseInt(row.querySelector('.quantity-input').value);
        total += price * quantity;
    });
    document.querySelector('.cart-table tfoot td:nth-child(2)').textContent = '$' + total.toFixed(2);
}

// Initialize total on page load
if (document.querySelector('.cart-table')) {
    updateTotal();
}
</script>

<style>
.checkout-section {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.cart-summary, .checkout-form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.cart-table th,
.cart-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.cart-table th {
    background: #f5f5f5;
}

.cart-table tfoot td {
    font-weight: bold;
}

.quantity-selector {
    display: flex;
    align-items: center;
}

.quantity-input {
    width: 60px;
    height: 36px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin: 0 5px;
    -webkit-appearance: none;
    -moz-appearance: textfield;
}

.quantity-btn {
    width: 36px;
    height: 36px;
    background: #f9942a;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
}

.quantity-btn:hover {
    background: #e68a23;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn {
    background: #f9942a;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn:hover {
    background: #e68a23;
}

.success-message {
    color: #2ecc71;
    background: #e8f8f0;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
}

.error-message {
    color: #e74c3c;
    background: #fdecea;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
}
</style>