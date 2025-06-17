<?php
session_start();
require_once 'includes/db_connect.php';
header('Content-Type: application/json');

try {
    // Validate required fields
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';

    if ($product_id <= 0 || empty($name) || $price <= 0 || $quantity <= 0) {
        throw new Exception('Invalid product details');
    }

    // Initialize cart if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product exists in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // Add new item if not found
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $image
        ];
    }

    // Calculate total items
    $cart_count = array_reduce($_SESSION['cart'], function($carry, $item) {
        return $carry + $item['quantity'];
    }, 0);

    echo json_encode([
        'success' => true,
        'cart_count' => $cart_count,
        'message' => 'Product added to cart!'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>