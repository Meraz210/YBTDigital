<?php
// API endpoint for submitting reviews

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models\Review.php';

// Set content type to JSON
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

// Get form data
$productId = (int)($_POST['product_id'] ?? 0);
$rating = (int)($_POST['rating'] ?? 0);
$reviewText = trim($_POST['review_text'] ?? '');

// Validation
if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

if ($rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Rating must be between 1 and 5']);
    exit;
}

// Initialize Review model
$reviewModel = new Review();

// Check if user has already reviewed this product
$userId = $_SESSION['user_id'];
if ($reviewModel->hasUserReviewedProduct($userId, $productId)) {
    echo json_encode(['success' => false, 'message' => 'You have already reviewed this product']);
    exit;
}

// Prepare review data
$reviewData = [
    'product_id' => $productId,
    'user_id' => $userId,
    'rating' => $rating,
    'review_text' => $reviewText
];

// Attempt to create the review
if ($reviewModel->create($reviewData)) {
    echo json_encode(['success' => true, 'message' => 'Review submitted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit review']);
}