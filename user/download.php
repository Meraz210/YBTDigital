<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit;
}

require_once '../includes/db.php';

$user_id = $_SESSION['user_id'];
$order_id = (int)$_GET['order_id'];

// Verify that the order belongs to the logged-in user
$stmt = $connection->prepare("SELECT o.id, o.status, p.file_path FROM orders o JOIN products p ON o.product_id = p.id WHERE o.id = ? AND o.user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // Order doesn't exist or doesn't belong to user
    header('Location: ../user/orders.php');
    exit;
}

$order = $result->fetch_assoc();

// Check if order is completed
if ($order['status'] !== 'completed') {
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

exit;
?>