<?php
// Include the layout
ob_start();

// Data is passed from the router
// Variables available: $featuredProducts, $popularProducts, $totalProducts, $categories

// The e() function is already defined in config.php
?>

<!-- Hero Section -->
<section class="bg-white text-dark py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3 text-primary">Premium Digital Products</h1>
                <p class="lead mb-4 text-primary">Discover high-quality digital products crafted by professionals for your next project.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary btn-lg px-4 py-2 mb-2 mb-md-0 rounded-pill">Explore Products</a>
                    <a href="<?php echo BASE_URL; ?>/user/signup" class="btn btn-outline-primary btn-lg px-4 py-2 mb-2 mb-md-0 rounded-pill">Join Free</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 d-flex justify-content-center">
                <div class="hero-image position-relative">
                    <div class="hero-shape bg-primary rounded-circle position-absolute top-0 start-50 translate-middle" style="width: 200px; height: 200px; opacity: 0.05;"></div>
                    <div class="hero-content position-relative">
                        <i class="fas fa-laptop-code fa-8x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item h-100 bg-white rounded-3 shadow-sm p-4 border-0">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-box-open fa-3x text-primary"></i>
                    </div>
                    <h3 class="display-5 fw-bold mb-1 text-primary"><?php echo $totalProducts; ?></h3>
                    <p class="mb-0 text-muted fw-semibold">Products</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item h-100 bg-white rounded-3 shadow-sm p-4 border-0">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-tags fa-3x text-primary"></i>
                    </div>
                    <h3 class="display-5 fw-bold mb-1 text-primary"><?php echo count($categories); ?></h3>
                    <p class="mb-0 text-muted fw-semibold">Categories</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item h-100 bg-white rounded-3 shadow-sm p-4 border-0">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-smile fa-3x text-primary"></i>
                    </div>
                    <h3 class="display-5 fw-bold mb-1 text-primary">100%</h3>
                    <p class="mb-0 text-muted fw-semibold">Satisfaction</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item h-100 bg-white rounded-3 shadow-sm p-4 border-0">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-headset fa-3x text-primary"></i>
                    </div>
                    <h3 class="display-5 fw-bold mb-1 text-primary">24/7</h3>
                    <p class="mb-0 text-muted fw-semibold">Support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
            <p class="text-muted mb-4">Handpicked products for your next project</p>
            <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary btn-lg px-4 py-2 rounded-pill">View All Products</a>
        </div>
        <div class="row g-4">
            <?php if (!empty($featuredProducts)): ?>
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 product-card border-0 shadow-sm rounded-3">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?php echo build_image_url($product['image']); ?>" class="card-img-top rounded-top-3" alt="<?php echo e($product['name']); ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <img src="<?php echo BASE_URL; ?>/assets/images/placeholder.jpg" class="card-img-top rounded-top-3" alt="<?php echo e($product['name']); ?>" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold mb-2"><?php echo e($product['name']); ?></h5>
                                <p class="card-text text-muted flex-grow-1"><?php echo e(substr($product['description'], 0, 100)); ?>...</p>
                                
                                <!-- Rating Display -->
                                <div class="mb-3">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $product['avg_rating']): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-warning"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <small class="text-muted ms-2"><?php echo $product['total_reviews']; ?> reviews</small>
                                </div>
                                
                                <div class="mt-auto pt-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary fw-bold mb-0">$<?php echo number_format($product['price'], 2); ?></span>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo BASE_URL; ?>/products/<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-sm px-3 rounded-pill">Details</a>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/cart/add" class="d-inline">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm px-3 rounded-pill">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center fs-5 text-muted">No featured products available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Popular Products -->
<?php if (!empty($popularProducts)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Most Popular</h2>
            <p class="text-muted mb-4">Trending products this week</p>
        </div>
        <div class="row g-4">
            <?php foreach ($popularProducts as $product): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 product-card border-0 shadow-sm rounded-3">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?php echo build_image_url($product['image']); ?>" class="card-img-top rounded-top-3" alt="<?php echo e($product['name']); ?>" style="height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <img src="<?php echo BASE_URL; ?>/assets/images/placeholder.jpg" class="card-img-top rounded-top-3" alt="<?php echo e($product['name']); ?>" style="height: 150px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column p-4">
                            <h6 class="card-title fw-bold mb-2"><?php echo e($product['name']); ?></h6>
                            <div class="mb-3">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $product['avg_rating']): ?>
                                        <i class="fas fa-star text-warning"></i>
                                    <?php else: ?>
                                        <i class="far fa-star text-warning"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="mt-auto pt-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h6 text-primary fw-bold mb-0">$<?php echo number_format($product['price'], 2); ?></span>
                                    <a href="<?php echo BASE_URL; ?>/products/<?php echo $product['id']; ?>" class="btn btn-primary btn-sm px-3 rounded-pill">View</a>
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

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Browse by Category</h2>
            <p class="text-muted mb-4">Find products in your preferred category</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($categories as $category): ?>
                <div class="col-lg-2 col-md-3 col-6">
                    <a href="<?php echo BASE_URL; ?>/products?category=<?php echo e($category['slug']); ?>" class="btn btn-outline-primary w-100 h-100 d-flex align-items-center justify-content-center p-4 rounded-3">
                        <div class="text-center">
                            <div class="category-icon mb-3">
                                <i class="fas fa-folder-open fa-2x text-primary"></i>
                            </div>
                            <div class="btn-text fw-semibold"><?php echo e($category['name']); ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">What Our Customers Say</h2>
            <p class="text-muted mb-4">Trusted by thousands of satisfied customers worldwide</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card h-100 bg-white rounded-3 p-4 shadow-sm border-0">
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-quote-left text-primary fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-4 text-muted">"The digital products I purchased here exceeded my expectations. The quality is top-notch and the support is excellent!"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <span class="text-white fw-bold">JD</span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 fw-bold">John Doe</h6>
                            <small class="text-muted">Web Developer</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card h-100 bg-white rounded-3 p-4 shadow-sm border-0">
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-quote-left text-primary fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-4 text-muted">"I've been using their products for my projects and they've saved me countless hours. Highly recommended!"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <span class="text-white fw-bold">JS</span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 fw-bold">Jane Smith</h6>
                            <small class="text-muted">Designer</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card h-100 bg-white rounded-3 p-4 shadow-sm border-0">
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-quote-left text-primary fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-4 text-muted">"The download process was seamless and the product quality is outstanding. Will definitely purchase again!"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <span class="text-white fw-bold">MJ</span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 fw-bold">Mike Johnson</h6>
                            <small class="text-muted">Entrepreneur</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="text-white mb-3">Ready to Get Started?</h2>
                <p class="lead text-white mb-4">Join thousands of satisfied customers and discover amazing digital products.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="<?php echo BASE_URL; ?>/products" class="btn btn-light btn-lg px-4 py-2 mb-2 mb-md-0 rounded-pill">Shop Now</a>
                    <a href="<?php echo BASE_URL; ?>/user/signup" class="btn btn-outline-light btn-lg px-4 py-2 mb-2 mb-md-0 rounded-pill">Join Free</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Frequently Asked Questions</h2>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqOne">
                            <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                How do I download my purchased products?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-mdb-parent="#faqAccordion">
                            <div class="accordion-body">
                                After completing your purchase, you can download your products from the "My Downloads" section in your account dashboard.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqTwo">
                            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                What is the refund policy?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-mdb-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer a 30-day money-back guarantee on all our digital products. If you're not satisfied, contact us within 30 days for a full refund.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqThree">
                            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Are the products compatible with all software?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree" data-mdb-parent="#faqAccordion">
                            <div class="accordion-body">
                                Compatibility information is provided in each product's description. Please check the requirements before purchasing.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqFour">
                            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                How do I get support for my purchases?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="faqFour" data-mdb-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can contact our support team through the contact page or reach out directly to the product author if applicable.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>