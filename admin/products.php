<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once 'includes/header.php';

$db = new Database();
$conn = $db->getConnection();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Delete product
        $id = $conn->real_escape_string($_POST['id']);
        $sql = "DELETE FROM products WHERE product_id = $id";
        $conn->query($sql);
        $_SESSION['message'] = 'Product deleted successfully';
    } else {
        // Add/Edit product
        $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : null;
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $price = $conn->real_escape_string($_POST['price']);
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $image_url = $conn->real_escape_string($_POST['image_url']);
        
        if ($id) {
            // Update existing product
            $sql = "UPDATE products SET 
                    name = '$name', 
                    description = '$description', 
                    price = $price, 
                    category_id = $category_id, 
                    image_url = '$image_url' 
                    WHERE product_id = $id";
        } else {
            // Insert new product
            $sql = "INSERT INTO products (name, description, price, category_id, image_url) 
                    VALUES ('$name', '$description', $price, $category_id, '$image_url')";
        }
        
        $conn->query($sql);
        $_SESSION['message'] = 'Product saved successfully';
    }
    
    header('Location: products.php');
    exit;
}

// Get all products
$products = [];
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id 
        ORDER BY p.product_id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Get all categories for dropdown
$categories = [];
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Check if we're editing a product
$editProduct = null;
if (isset($_GET['edit'])) {
    $id = $conn->real_escape_string($_GET['edit']);
    $sql = "SELECT * FROM products WHERE product_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows === 1) {
        $editProduct = $result->fetch_assoc();
    }
}
?>

<!-- Display success/error message -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header">
        <h4><?= $editProduct ? 'Edit Product' : 'Add New Product' ?></h4>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $editProduct ? $editProduct['product_id'] : '' ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?= $editProduct ? $editProduct['name'] : '' ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= $editProduct ? $editProduct['description'] : '' ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" 
                       value="<?= $editProduct ? $editProduct['price'] : '' ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>" 
                            <?= ($editProduct && $editProduct['category_id'] == $category['category_id']) ? 'selected' : '' ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url" 
                       value="<?= $editProduct ? $editProduct['image_url'] : '' ?>" required>
                <?php if ($editProduct && $editProduct['image_url']): ?>
                    <img src="../<?= $editProduct['image_url'] ?>" alt="Product Image" class="img-thumbnail mt-2" style="max-width: 200px;">
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Product</button>
            <?php if ($editProduct): ?>
                <a href="products.php" class="btn btn-secondary">Cancel</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Product List</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['product_id'] ?></td>
                            <td>
                                <img src="../<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>" style="max-width: 50px;">
                            </td>
                            <td><?= $product['name'] ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><?= $product['category_name'] ?></td>
                            <td>
                                <a href="products.php?edit=<?= $product['product_id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="id" value="<?= $product['product_id'] ?>">
                                    <input type="hidden" name="delete" value="1">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>