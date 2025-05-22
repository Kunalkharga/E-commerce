<?php
require_once '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$product_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : null;
    $rating = $_POST['rating'];
    $badge = trim($_POST['badge']);
    $stock = $_POST['stock'];
    $image = $product['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "../assets/images/product-images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    $stmt = $pdo->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, old_price = ?, image = ?, rating = ?, badge = ?, stock = ? WHERE id = ?");
    $stmt->execute([$category_id, $name, $description, $price, $old_price, $image, $rating, $badge, $stock, $product_id]);
    header("Location: products.php");
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data" class="contact-form">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
        </div>
        <div class="form-group">
            <label for="old_price">Old Price (optional)</label>
            <input type="number" step="0.01" name="old_price" class="form-control" value="<?php echo $product['old_price']; ?>">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            <p>Current: <?php echo $product['image']; ?></p>
        </div>
        <div class="form-group">
            <label for="rating">Rating (0-5)</label>
            <input type="number" name="rating" class="form-control" min="0" max="5" value="<?php echo $product['rating']; ?>" required>
        </div>
        <div class="form-group">
            <label for="badge">Badge (e.g., Hot, New, Sale)</label>
            <input type="text" name="badge" class="form-control" value="<?php echo htmlspecialchars($product['badge']); ?>">
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" class="form-control" value="<?php echo $product['stock']; ?>" required>
        </div>
        <button type="submit" class="btn-submit">Update Product</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>