<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
<<<<<<< HEAD
    header('Location: ../user/login.php');
=======
    header('Location: login.php');
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    exit;
}

require_once '../includes/db.php';

<<<<<<< HEAD
$user_id = $_SESSION['user_id'];
$order_id = (int)$_GET['order_id'];

// Verify that the order belongs to the logged-in user
$stmt = $connection->prepare("SELECT o.id, o.status, p.file_path FROM orders o JOIN products p ON o.product_id = p.id WHERE o.id = ? AND o.user_id = ?");
=======
// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    header('Location: orders.php');
    exit;
}

$order_id = (int)$_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Verify that the order belongs to the current user
$stmt = $connection->prepare("SELECT o.id, o.product_id, o.order_date, o.status, p.name as product_name, p.file_url FROM orders o JOIN products p ON o.product_id = p.id WHERE o.id = ? AND o.user_id = ?");
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // Order doesn't exist or doesn't belong to user
<<<<<<< HEAD
    header('Location: ../user/orders.php');
=======
    header('Location: orders.php');
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    exit;
}

$order = $result->fetch_assoc();

// Check if order is completed
if ($order['status'] !== 'completed') {
<<<<<<< HEAD
    // Order is not completed, user can't download
    header('Location: ../user/orders.php');
    exit;
}

// Check if file exists
$file_path = __DIR__ . '/../uploads/' . $order['file_path'];

if (!file_exists($file_path)) {
    // File doesn't exist
    header('Location: ../user/orders.php');
    exit;
}

// Set headers for file download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
header('Content-Length: ' . filesize($file_path));

// Output file content
readfile($file_path);

=======
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
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
exit;
?>