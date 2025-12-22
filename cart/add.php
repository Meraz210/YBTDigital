<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    
    // Check if product is already in cart
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            $_SESSION['cart'][$key]['quantity']++;
            $found = true;
            break;
        }
    }
    
    // If not found, add new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'quantity' => 1
        ];
    }
    
    // Redirect back to cart
    header('Location: index.php');
    exit;
}
?>