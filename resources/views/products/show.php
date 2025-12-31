<?php
// Include the layout
ob_start();

// Include necessary models
require_once __DIR__ . '/../../../app/models/Review.php';

$reviewModel = new Review();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/products">Products</a></li>
                <li class="breadcrumb-item active"><?php echo e($product['name']); ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Product Detail Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?php echo build_image_url($product['image']); ?>" class="img-fluid rounded" alt="<?php echo e($product['name']); ?>">
                <?php else: ?>
                    <img src="<?php echo BASE_URL; ?>/assets/images/placeholder.jpg" class="img-fluid rounded" alt="<?php echo e($product['name']); ?>">
                <?php endif; ?>
                
                <!-- Additional Screenshots -->
                <?php if (!empty($product['screenshots'])): ?>
                    <?php $screenshots = json_decode($product['screenshots'], true); ?>
                    <?php if (!empty($screenshots)): ?>
                        <div class="mt-3">
                            <h5>Screenshots</h5>
                            <div class="row">
                                <?php foreach ($screenshots as $screenshot): ?>
                                    <div class="col-4 mb-2">
                                        <img src="<?php echo build_image_url($screenshot); ?>" class="img-fluid rounded" alt="Screenshot">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <!-- Product Info -->
            <div class="col-md-6">
                <h1><?php echo e($product['name']); ?></h1>
                
                <!-- Rating Display -->
                <div class="mb-2">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $product['avg_rating']): ?>
                            <i class="fas fa-star text-warning"></i>
                        <?php else: ?>
                            <i class="far fa-star text-warning"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <span class="ms-2 text-muted"><?php echo $product['avg_rating']; ?> (<?php echo $product['total_reviews']; ?> reviews)</span>
                </div>
                
                <div class="my-4">
                    <h3 class="text-primary">$<?php echo number_format($product['price'], 2); ?></h3>
                </div>
                
                <p class="lead"><?php echo e($product['description']); ?></p>
                
                <div class="mb-4">
                    <p><strong>Category:</strong> <?php echo e($product['category_name']); ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-<?php echo $product['status'] === 'active' ? 'success' : 'secondary'; ?>">
                            <?php echo ucfirst($product['status']); ?>
                        </span>
                    </p>
                </div>
                
                <!-- Add to Cart Form -->
                <form method="POST" action="<?php echo BASE_URL; ?>/cart/add">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="10">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </form>
                
                <!-- Or Buy Now Button -->
                <form method="POST" action="<?php echo BASE_URL; ?>/cart/add" class="mt-2">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-bolt"></i> Buy Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-4 bg-light">
    <div class="container">
        <h2>Customer Reviews</h2>
        
        <!-- Average Rating Summary -->
        <div class="row mb-4">
            <div class="col-md-4 text-center">
                <h3 class="text-primary"><?php echo number_format($product['avg_rating'], 1); ?>/5</h3>
                <div class="mb-2">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $product['avg_rating']): ?>
                            <i class="fas fa-star text-warning"></i>
                        <?php else: ?>
                            <i class="far fa-star text-warning"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <p class="text-muted"><?php echo $product['total_reviews']; ?> reviews</p>
            </div>
            <div class="col-md-8">
                <!-- Rating distribution bars would go here -->
            </div>
        </div>
        
        <!-- Review Form -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (!$userHasReviewed): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Write a Review</h5>
                    </div>
                    <div class="card-body">
                        <form id="reviewForm" method="POST" action="<?php echo BASE_URL; ?>/api/submit_review">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="star-rating-container" data-rating="0">
                                    <span class="star" data-value="1">★</span>
                                    <span class="star" data-value="2">★</span>
                                    <span class="star" data-value="3">★</span>
                                    <span class="star" data-value="4">★</span>
                                    <span class="star" data-value="5">★</span>
                                    <input type="hidden" name="rating" id="ratingInput" value="0" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="reviewText" class="form-label">Your Review</label>
                                <textarea class="form-control" id="reviewText" name="review_text" rows="4" placeholder="Share your experience with this product..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <p>You have already reviewed this product.</p>
                    <?php if ($userReview): ?>
                        <p><strong>Your Rating:</strong> 
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $userReview['rating']): ?>
                                    <i class="fas fa-star text-warning"></i>
                                <?php else: ?>
                                    <i class="far fa-star text-warning"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </p>
                        <p><strong>Your Review:</strong> <?php echo e($userReview['review_text']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">
                <p>Please <a href="<?php echo BASE_URL; ?>/user/login">login</a> to leave a review.</p>
            </div>
        <?php endif; ?>
        
        <!-- Reviews List -->
        <?php if (!empty($reviews)): ?>
            <div class="reviews-list">
                <?php foreach ($reviews as $review): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo e($review['user_name']); ?></h6>
                                <div>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review['rating']): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-warning"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="card-text"><?php echo e($review['review_text']); ?></p>
                            <small class="text-muted"><?php echo date('F j, Y', strtotime($review['created_at'])); ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
        <?php endif; ?>
    </div>
</section>

<!-- Related Products -->
<?php if (!empty($relatedProducts)): ?>
    <section class="py-4">
        <div class="container">
            <h2>Related Products</h2>
            <div class="row">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <?php if (!empty($relatedProduct['image'])): ?>
                                <img src="<?php echo build_image_url($relatedProduct['image']); ?>" class="card-img-top" alt="<?php echo e($relatedProduct['name']); ?>" style="height: 150px; object-fit: cover;">
                            <?php else: ?>
                                <img src="<?php echo BASE_URL; ?>/assets/images/placeholder.jpg" class="card-img-top" alt="<?php echo e($relatedProduct['name']); ?>" style="height: 150px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?php echo e($relatedProduct['name']); ?></h6>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-primary">$<?php echo number_format($relatedProduct['price'], 2); ?></span>
                                        <a href="<?php echo BASE_URL; ?>/products/<?php echo $relatedProduct['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>