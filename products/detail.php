<?php
/* =========================
   DEFINE BASE URL (CRITICAL)
========================= */
define('BASE_URL', '/YBTDigital');

/* =========================
   Include Reviews System
========================= */
require_once '../includes/reviews.php';

// Get product ID from URL
$product_id = (int)$_GET['id'] ?? 1;

// Sample products data
$products = [
    1 => [
        'id' => 1,
        'name' => 'Premium Web Template',
        'description' => 'A professional web template with responsive design, modern UI components, and clean code structure. Perfect for businesses, portfolios, and landing pages.',
        'price' => 49.99,
        'image' => 'web-template.jpg',
        'features' => [
            'Responsive Design',
            'Modern UI Components',
            'Clean Code Structure',
            'Cross-browser Compatibility',
            'Easy Customization'
        ],
        'category' => 'Web Templates',
        'file_path' => 'premium-web-template.zip'
    ],
    2 => [
        'id' => 2,
        'name' => 'Mobile UI Kit',
        'description' => 'A comprehensive UI kit for mobile applications with pre-designed screens, components, and interactive elements.',
        'price' => 39.99,
        'image' => 'mobile-ui.jpg',
        'features' => [
            '50+ Screen Templates',
            'Interactive Components',
            'Design Guidelines',
            'Source Files Included',
            'Regular Updates'
        ],
        'category' => 'UI Kits',
        'file_path' => 'mobile-ui-kit.zip'
    ],
    3 => [
        'id' => 3,
        'name' => 'Icon Pack',
        'description' => 'A collection of 500+ high-quality icons in multiple formats and styles, perfect for websites and applications.',
        'price' => 29.99,
        'image' => 'icon-pack.jpg',
        'features' => [
            '500+ Unique Icons',
            'Multiple Formats (SVG, PNG, AI)',
            'Multiple Sizes',
            'Vector Source Files',
            'Lifetime Updates'
        ],
        'category' => 'Graphics',
        'file_path' => 'icon-pack.zip'
    ],
    4 => [
        'id' => 4,
        'name' => 'Development Tool',
        'description' => 'A powerful development tool that helps streamline your workflow and boost productivity.',
        'price' => 59.99,
        'image' => 'dev-tool.jpg',
        'features' => [
            'Code Optimization',
            'Performance Analysis',
            'Debugging Tools',
            'Integration Support',
            'Regular Updates'
        ],
        'category' => 'Tools',
        'file_path' => 'development-tool.zip'
    ]
];

// Get product details
$product = $products[$product_id] ?? $products[1];

// Get reviews for this product
$reviews = getProductReviews($product['id']);
$avg_rating = getProductAverageRating($product['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - YBT Digital</title>
    <!-- MDB Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/assets/css/star-rating.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --text-light: #ffffff;
            --text-dark: #212529;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }
        
        .product-container {
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .product-card {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .feature-list {
            list-style-type: none;
            padding-left: 0;
        }
        
        .feature-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .feature-list li:last-child {
            border-bottom: none;
        }
        
        .feature-list li i {
            color: var(--primary-color);
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">
                <i class="fas fa-store me-2"></i>YBT Digital
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/products/index.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/contact.php">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link theme-toggle" id="themeToggle" href="#"><i class="fas fa-moon me-1"></i></a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/orders.php">My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/user/login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/user/signup.php"><i class="fas fa-user-plus me-1"></i>Sign Up</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="product-container">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card product-card">
                        <img src="<?php echo BASE_URL; ?>/assets/images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height: 400px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            
                            <!-- Display average rating -->
                            <div class="mb-3">
                                <?php echo displayStarRating($avg_rating['average']); ?>
                                <span class="ms-2">(<?php echo $avg_rating['count']; ?> reviews)</span>
                            </div>
                            
                            <div class="d-grid">
                                <a href="<?php echo BASE_URL; ?>/cart/add.php?product_id=<?php echo $product['id']; ?>&redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="btn btn-primary btn-lg">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart - $<?php echo $product['price']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card product-card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Product Details</h5>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                            <p><strong>Price:</strong> $<?php echo $product['price']; ?></p>
                            
                            <h6 class="mt-4">Features:</h6>
                            <ul class="feature-list">
                                <?php foreach ($product['features'] as $feature): ?>
                                    <li><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Reviews Section -->
                    <div class="card product-card">
                        <div class="card-body">
                            <h5 class="card-title">Customer Reviews</h5>
                            
                            <!-- Display existing reviews -->
                            <?php if (!empty($reviews)): ?>
                                <?php foreach ($reviews as $review): ?>
                                    <div class="border-bottom pb-3 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <h6><?php echo htmlspecialchars($review['user_name']); ?></h6>
                                            <div>
                                                <?php echo displayStarRating($review['rating']); ?>
                                            </div>
                                        </div>
                                        <p class="text-muted"><?php echo htmlspecialchars($review['comment']); ?></p>
                                        <small class="text-muted"><?php echo date('M j, Y', strtotime($review['created_at'])); ?></small>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                            <?php endif; ?>
                            
                            <!-- Add Review Form -->
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <hr>
                                <h6>Add Your Review</h6>
                                <form id="reviewForm" method="POST" action="<?php echo BASE_URL; ?>/api/submit_review.php">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <div class="star-rating">
                                            <input type="radio" id="star5" name="rating" value="5" />
                                            <label for="star5" title="5 stars">★</label>
                                            <input type="radio" id="star4" name="rating" value="4" />
                                            <label for="star4" title="4 stars">★</label>
                                            <input type="radio" id="star3" name="rating" value="3" />
                                            <label for="star3" title="3 stars">★</label>
                                            <input type="radio" id="star2" name="rating" value="2" />
                                            <label for="star2" title="2 stars">★</label>
                                            <input type="radio" id="star1" name="rating" value="1" />
                                            <label for="star1" title="1 star">★</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Your Review</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                            <?php else: ?>
                                <p class="text-muted">Please <a href="<?php echo BASE_URL; ?>/user/login.php">login</a> to leave a review.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-store me-2"></i>YBT Digital</h5>
                    <p>Your trusted source for premium digital products.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/index.php" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/products/index.php" class="text-light text-decoration-none">Products</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/about.php" class="text-light text-decoration-none">About</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/contact.php" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Account</h5>
                    <ul class="list-unstyled">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="<?php echo BASE_URL; ?>/user/profile.php" class="text-light text-decoration-none">Profile</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/user/orders.php" class="text-light text-decoration-none">Orders</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/user/logout.php" class="text-light text-decoration-none">Logout</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/user/login.php" class="text-light text-decoration-none">Login</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/user/signup.php" class="text-light text-decoration-none">Sign Up</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> support@ybtdigital.com</li>
                        <li><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 YBT Digital. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
    
    <script src="<?php echo BASE_URL; ?>/assets/js/star-rating.js"></script>
    
    <script>
        // Dark mode toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle.querySelector('i');
        
        // Check for saved theme preference or respect OS preference
        const savedTheme = localStorage.getItem('theme');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Set the initial theme
        if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme.matches)) {
            document.body.classList.add('dark-mode');
            document.body.classList.remove('light-mode');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            document.body.classList.add('light-mode');
            document.body.classList.remove('dark-mode');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
        
        // Toggle theme function
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('dark-mode');
            document.body.classList.toggle('light-mode');
            
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        });
    </script>
</body>
</html>