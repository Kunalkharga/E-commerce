<?php
require_once '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch categories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

// Handle product creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : null;
    $rating = $_POST['rating'];
    $badge = trim($_POST['badge']);
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];

    // Handle image upload
    $target_dir = "../assets/images/product-images/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, description, price, old_price, image, rating, badge, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$category_id, $name, $description, $price, $old_price, $image, $rating, $badge, $stock]);
}

// Fetch products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Manage Products</h2>
    <form method="POST" enctype="multipart/form-data" class="contact-form">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="old_price">Old Price (optional)</label>
            <input type="number" step="0.01" name="old_price" class="form-control">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="rating">Rating (0-5)</label>
            <input type="number" name="rating" class="form-control" min="0" max="5" required>
        </div>
        <div class="form-group">
            <label for="badge">Badge (e.g., Hot, New, Sale)</label>
            <input type="text" name="badge" class="form-control">
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <button type="submit" name="add_product" class="btn-submit">Add Product</button>
    </form>

    <h3>Product List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                <td>$<?php echo number_format($product['price'], 2); ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>