<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity < 1) {
        $quantity = 1;
    }
    
    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Check if product is already in cart
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            $_SESSION['cart'][$key]['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    
    // If product is not in cart, add it
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'quantity' => $quantity
        ];
    }
    
    // Redirect back to previous page or cart
    $redirect = $_POST['redirect'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit;
} else {
    // If not POST request, redirect to cart
    header('Location: index.php');
    exit;
}
?>