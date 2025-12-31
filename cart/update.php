<?php
session_start();

<<<<<<< HEAD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
=======
if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = (int)$_GET['product_id'];
    $quantity = (int)$_GET['quantity'];
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    
    if ($quantity < 1) {
        $quantity = 1;
    }
    
<<<<<<< HEAD
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
=======
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
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
?>