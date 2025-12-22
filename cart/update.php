<?php
session_start();

if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = (int)$_GET['product_id'];
    $quantity = (int)$_GET['quantity'];
    
    if ($quantity < 1) {
        $quantity = 1;
    }
    
    // Update quantity in cart
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
?>