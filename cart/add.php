<?php
session_start();

<<<<<<< HEAD
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
=======
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    
    // Check if product is already in cart
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
<<<<<<< HEAD
            $_SESSION['cart'][$key]['quantity'] += $quantity;
=======
            $_SESSION['cart'][$key]['quantity']++;
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
            $found = true;
            break;
        }
    }
    
<<<<<<< HEAD
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
=======
    // If not found, add new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'quantity' => 1
        ];
    }
    
    // Redirect back to cart
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    header('Location: index.php');
    exit;
}
?>