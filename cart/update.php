<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity < 1) {
        $quantity = 1;
    }
    
    // Update cart item
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $product_id) {
                $_SESSION['cart'][$key]['quantity'] = $quantity;
                break;
            }
        }
    }
    
    // Redirect back to cart
    header('Location: index.php');
    exit;
} else {
    // If not POST request, redirect to cart
    header('Location: index.php');
    exit;
}
?>