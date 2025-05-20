<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

if (!isAdmin()) {
    header('Location: /user/login.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $old_price = $_POST['old_price'] ?: null;
    $stock = $_POST['stock'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../assets/images/products/';
        $image = uploadImage($_FILES['image'], $uploadDir);
    }
    
    $slug = createSlug($name);
    
    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, description, price, old_price, image, stock, is_featured) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$category_id, $name, $slug, $description, $price, $old_price, $image, $stock, $is_featured]);
    
    header('Location: list.php');
    exit;
}

$pageTitle = "Add New Product";
include '../../includes/admin_header.php';
?>

<div class="admin-container">
    <h1>Add New Product</h1>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" required>
        </div>
        
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="5" required></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" name="price" step="0.01" min="0" required>
            </div>
            
            <div class="form-group">
                <label>Old Price ($) - Optional</label>
                <input type="number" name="old_price" step="0.01" min="0">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" min="0" required>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_featured"> Featured Product
                </label>
            </div>
        </div>
        
        <div class="form-group">
            <label>Product Image</label>
            <input type="file" name="image" accept="image/*" required>
        </div>
        
        <button type="submit" class="btn">Add Product</button>
    </form>
</div>

<?php include '../../includes/admin_footer.php'; ?>