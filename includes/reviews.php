<?php
// Reviews System for YBT Digital

// Include database connection
require_once 'db.php';

/**
 * Get all reviews for a specific product
 */
function getProductReviews($product_id) {
    global $connection;
    
    $stmt = $connection->prepare("
        SELECT r.*, u.name as user_name 
        FROM reviews r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.product_id = ? 
        ORDER BY r.created_at DESC
    ");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Get average rating for a product
 */
function getProductAverageRating($product_id) {
    global $connection;
    
    $stmt = $connection->prepare("SELECT AVG(rating) as average, COUNT(*) as count FROM reviews WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

/**
 * Display star rating HTML
 */
function displayStarRating($rating) {
    $rating = (float)$rating;
    $full_stars = floor($rating);
    $half_star = ($rating - $full_stars) >= 0.5 ? 1 : 0;
    $empty_stars = 5 - $full_stars - $half_star;
    
    $html = '<div class="star-rating-display">';
    
    // Full stars
    for ($i = 0; $i < $full_stars; $i++) {
        $html .= '<span class="star full">★</span>';
    }
    
    // Half star
    if ($half_star) {
        $html .= '<span class="star half">★</span>';
    }
    
    // Empty stars
    for ($i = 0; $i < $empty_stars; $i++) {
        $html .= '<span class="star empty">☆</span>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Add a new review
 */
function addReview($user_id, $product_id, $rating, $comment) {
    global $connection;
    
    $stmt = $connection->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $product_id, $rating, $comment);
    
    return $stmt->execute();
}
?>