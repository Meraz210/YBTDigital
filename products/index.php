<?php
session_start();
require_once '../includes/db.php';

// Get products from database (for now, we'll use sample data)
$products = [
    [
        'id' => 1,
        'name' => 'Premium Web Template',
        'description' => 'Modern responsive web template with multiple page layouts',
        'price' => 49.99,
        'category' => 'Web Templates',
        'image' => 'https://via.placeholder.com/300x200/4361ee/ffffff?text=Web+Template',
        'rating' => 4.8,
        'sales' => 125
    ],
    [
        'id' => 2,
        'name' => 'Mobile UI Kit',
        'description' => 'Complete UI kit for mobile app development',
        'price' => 39.99,
        'category' => 'UI Kits',
        'image' => 'https://via.placeholder.com/300x200/3f37c9/ffffff?text=Mobile+UI',
        'rating' => 4.7,
        'sales' => 98
    ],
    [
        'id' => 3,
        'name' => 'Icon Pack',
        'description' => 'Set of 500+ vector icons for your projects',
        'price' => 29.99,
        'category' => 'Graphics',
        'image' => 'https://via.placeholder.com/300x200/4cc9f0/ffffff?text=Icon+Pack',
        'rating' => 4.9,
        'sales' => 210
    ],
    [
        'id' => 4,
        'name' => 'Development Tool',
        'description' => 'Essential tools for web developers',
        'price' => 59.99,
        'category' => 'Tools',
        'image' => 'https://via.placeholder.com/300x200/f72585/ffffff?text=Dev+Tool',
        'rating' => 4.6,
        'sales' => 76
    ],
    [
        'id' => 5,
        'name' => 'Business Dashboard',
        'description' => 'Professional dashboard template for business applications',
        'price' => 69.99,
        'category' => 'Web Templates',
        'image' => 'https://via.placeholder.com/300x200/7209b7/ffffff?text=Dashboard',
        'rating' => 4.9,
        'sales' => 89
    ],
    [
        'id' => 6,
        'name' => 'E-commerce UI Kit',
        'description' => 'Complete UI kit for e-commerce applications',
        'price' => 44.99,
        'category' => 'UI Kits',
        'image' => 'https://via.placeholder.com/300x200/3a0ca3/ffffff?text=E-commerce',
        'rating' => 4.7,
        'sales' => 156
    ]
];

// Handle filtering
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$price_filter = isset($_GET['price']) ? $_GET['price'] : '';
$sort_filter = isset($_GET['sort']) ? $_GET['sort'] : 'featured';

// Filter products based on category
if ($category_filter) {
    $filtered_products = [];
    foreach ($products as $product) {
        if (strtolower($product['category']) === strtolower($category_filter)) {
            $filtered_products[] = $product;
        }
    }
    $products = $filtered_products;
}

// Sort products
switch ($sort_filter) {
    case 'price_low':
        usort($products, function($a, $b) {
            return $a['price'] - $b['price'];
        });
        break;
    case 'price_high':
        usort($products, function($a, $b) {
            return $b['price'] - $a['price'];
        });
        break;
    case 'popular':
        usort($products, function($a, $b) {
            return $b['sales'] - $a['sales'];
        });
        break;
    case 'rating':
        usort($products, function($a, $b) {
            return $b['rating'] - $a['rating'];
        });
        break;
    default:
        // Featured (no sorting)
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - YBT Digital</title>
    <!-- MDB Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/theme.css" rel="stylesheet">
    <link href="../assets/css/mobile.css" rel="stylesheet">
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
        
        .products-container {
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
            background-color: white;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .product-image {
            height: 200px;
            object-fit: cover;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .filter-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
            padding: 20px;
        }
        
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--primary-color);
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .mobile-bottom-nav-item {
            flex: 1;
            text-align: center;
            padding: 8px 0;
            color: white;
        }
        
        .mobile-bottom-nav-item.active {
            font-weight: bold;
        }
        
        .mobile-bottom-nav-icon {
            display: block;
            font-size: 1.2rem;
            margin-bottom: 4px;
        }
        
        @media (max-width: 768px) {
            .desktop-nav {
                display: none;
            }
            
            .mobile-bottom-nav {
                display: flex;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-bottom-nav {
                display: none;
            }
        }
        
        .category-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            background-color: #e9ecef;
            color: #495057;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        .category-badge.active {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light desktop-nav">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-store me-2"></i>YBT Digital
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../user/profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="../user/orders.php">My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../user/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../user/login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../user/signup.php"><i class="fas fa-user-plus me-1"></i>Sign Up</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
        <a href="../index.php" class="mobile-bottom-nav-item">
            <i class="fas fa-home mobile-bottom-nav-icon"></i>
            <span>Home</span>
        </a>
        <a href="index.php" class="mobile-bottom-nav-item active">
            <i class="fas fa-shopping-bag mobile-bottom-nav-icon"></i>
            <span>Products</span>
        </a>
        <a href="../cart/index.php" class="mobile-bottom-nav-item">
            <i class="fas fa-shopping-cart mobile-bottom-nav-icon"></i>
            <span>Cart</span>
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../user/profile.php" class="mobile-bottom-nav-item">
                <i class="fas fa-user mobile-bottom-nav-icon"></i>
                <span>Profile</span>
            </a>
        <?php else: ?>
            <a href="../user/login.php" class="mobile-bottom-nav-item">
                <i class="fas fa-user mobile-bottom-nav-icon"></i>
                <span>Login</span>
            </a>
        <?php endif; ?>
    </div>

    <div class="products-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="filter-section">
                        <h5><i class="fas fa-filter me-2"></i>Filters</h5>
                        
                        <div class="mb-4">
                            <h6>Categories</h6>
                            <a href="?category=Web Templates" class="category-badge <?php echo ($category_filter === 'Web Templates') ? 'active' : ''; ?>">Web Templates</a>
                            <a href="?category=UI Kits" class="category-badge <?php echo ($category_filter === 'UI Kits') ? 'active' : ''; ?>">UI Kits</a>
                            <a href="?category=Graphics" class="category-badge <?php echo ($category_filter === 'Graphics') ? 'active' : ''; ?>">Graphics</a>
                            <a href="?category=Tools" class="category-badge <?php echo ($category_filter === 'Tools') ? 'active' : ''; ?>">Tools</a>
                            <a href="?" class="category-badge <?php echo empty($category_filter) ? 'active' : ''; ?>">All</a>
                        </div>
                        
                        <div class="mb-4">
                            <h6>Sort By</h6>
                            <select class="form-select" id="sortSelect" onchange="location = this.value;">
                                <option value="?category=<?php echo $category_filter; ?>&sort=featured" <?php echo ($sort_filter === 'featured') ? 'selected' : ''; ?>>Featured</option>
                                <option value="?category=<?php echo $category_filter; ?>&sort=price_low" <?php echo ($sort_filter === 'price_low') ? 'selected' : ''; ?>>Price: Low to High</option>
                                <option value="?category=<?php echo $category_filter; ?>&sort=price_high" <?php echo ($sort_filter === 'price_high') ? 'selected' : ''; ?>>Price: High to Low</option>
                                <option value="?category=<?php echo $category_filter; ?>&sort=popular" <?php echo ($sort_filter === 'popular') ? 'selected' : ''; ?>>Most Popular</option>
                                <option value="?category=<?php echo $category_filter; ?>&sort=rating" <?php echo ($sort_filter === 'rating') ? 'selected' : ''; ?>>Highest Rated</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>All Products</h3>
                        <p class="text-muted"><?php echo count($products); ?> products found</p>
                    </div>
                    
                    <div class="row" id="productsContainer">
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="product-card card h-100">
                                    <img src="<?php echo $product['image']; ?>" class="card-img-top product-image" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <div class="card-body d-flex flex-column">
                                        <span class="badge bg-primary mb-2" style="width: fit-content;"><?php echo htmlspecialchars($product['category']); ?></span>
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text flex-grow-1"><?php echo htmlspecialchars($product['description']); ?></p>
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="h5 text-primary mb-0">$<?php echo number_format($product['price'], 2); ?></span>
                                                    <div class="mt-1">
                                                        <small class="text-muted">
                                                            <i class="fas fa-star text-warning"></i> <?php echo $product['rating']; ?>
                                                            <span class="mx-1">•</span>
                                                            <i class="fas fa-shopping-cart text-success"></i> <?php echo $product['sales']; ?> sales
                                                        </small>
                                                    </div>
                                                </div>
                                                <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                        <li><a href="../index.php" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="index.php" class="text-light text-decoration-none">Products</a></li>
                        <li><a href="#" class="text-light text-decoration-none">About</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Account</h5>
                    <ul class="list-unstyled">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="../user/profile.php" class="text-light text-decoration-none">Profile</a></li>
                            <li><a href="../user/orders.php" class="text-light text-decoration-none">Orders</a></li>
                            <li><a href="../user/logout.php" class="text-light text-decoration-none">Logout</a></li>
                        <?php else: ?>
                            <li><a href="../user/login.php" class="text-light text-decoration-none">Login</a></li>
                            <li><a href="../user/signup.php" class="text-light text-decoration-none">Sign Up</a></li>
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