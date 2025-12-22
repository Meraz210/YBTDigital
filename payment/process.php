<?php
// Mock payment processing for YBT Digital
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit;
}

require_once '../includes/db.php';
require_once '../config.php';

// Process payment (mock implementation)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'] ?? 0;
    $amount = floatval($_POST['amount']);
    $payment_method = $_POST['payment_method'] ?? 'stripe';
    
    // In a real implementation, you would process the payment with a payment gateway
    // For this mock implementation, we'll simulate a successful payment
    
    // Generate a mock transaction ID
    $transaction_id = 'txn_' . time() . '_' . rand(1000, 9999);
    
    // Insert order into database
    $stmt = $connection->prepare("INSERT INTO orders (user_id, product_id, total_amount, status, transaction_id) VALUES (?, ?, ?, 'completed', ?)");
    $stmt->bind_param("iids", $user_id, $product_id, $amount, $transaction_id);
    
    if ($stmt->execute()) {
        // Clear cart
        $_SESSION['cart'] = [];
        
        // Redirect to success page
        header('Location: ../checkout/success.php');
        exit;
    } else {
        // Handle error
        $error = "Payment processing failed. Please try again.";
    }
}

// If not POST request, redirect to cart
header('Location: ../cart/index.php');
exit;
?>