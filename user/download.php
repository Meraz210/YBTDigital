<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';

// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    header('Location: orders.php');
    exit;
}

$order_id = (int)$_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Verify that the order belongs to the current user
$stmt = $connection->prepare("SELECT o.id, o.product_id, o.order_date, o.status, p.name as product_name, p.file_url FROM orders o JOIN products p ON o.product_id = p.id WHERE o.id = ? AND o.user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // Order doesn't exist or doesn't belong to user
    header('Location: orders.php');
    exit;
}

$order = $result->fetch_assoc();

// Check if order is completed
if ($order['status'] !== 'completed') {
    // Order is not completed, can't download
    $_SESSION['error'] = 'Order must be completed before downloading.';
    header('Location: orders.php');
    exit;
}

// For demo purposes, we'll use a placeholder file
// In a real implementation, you would serve the actual product file
$file_path = $order['file_url'] ?: '../uploads/products/demo_product.zip';

// Check if file exists
if (!file_exists($file_path)) {
    $_SESSION['error'] = 'Product file not found.';
    header('Location: orders.php');
    exit;
}

// Log the download (optional)
// In a real implementation, you might want to log download attempts

// Force download
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
header('Content-Length: ' . filesize($file_path));

readfile($file_path);
exit;
?>