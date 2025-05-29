<?php
session_start();
require_once 'includes/db_connect.php';
define('BASE_URL', 'http://localhost/doggy-ecommerce/');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';

    if ($product_id > 0 && $name && $price > 0 && $quantity > 0) {
        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if product already in cart
        $item_index = array_search($product_id, array_column($_SESSION['cart'], 'product_id'));
        if ($item_index !== false) {
            // Update quantity
            $_SESSION['cart'][$item_index]['quantity'] += $quantity;
        } else {
            // Add new item
            $_SESSION['cart'][] = [
                'product_id' => $product_id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $image
            ];
        }

        // Calculate total items
        $cart_count = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cart_count += $item['quantity'];
        }

        echo json_encode([
            'success' => true,
            'cart_count' => $cart_count,
            'message' => 'Product added to cart!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid product details.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>