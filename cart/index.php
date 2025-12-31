<?php
session_start();
<<<<<<< HEAD
define('BASE_URL', '/YBTDigital');

/* =========================
   Helper function
========================= */
function build_image_url($img) {
    return $img; // Image URLs are already properly formatted with BASE_URL
}

=======
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
require_once '../includes/db.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle remove from cart
if (isset($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
    header('Location: index.php');
    exit;
}

// Sample products data
$products = [
    1 => [
        'id' => 1,
        'name' => 'Premium Web Template',
        'price' => 49.99,
<<<<<<< HEAD
        'image' => BASE_URL . '/assets/images/web-template.jpg'
=======
        'image' => 'https://via.placeholder.com/100x100/4361ee/ffffff?text=Web+Template'
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    ],
    2 => [
        'id' => 2,
        'name' => 'Mobile UI Kit',
        'price' => 39.99,
<<<<<<< HEAD
        'image' => BASE_URL . '/assets/images/mobile-ui.jpg'
=======
        'image' => 'https://via.placeholder.com/100x100/3f37c9/ffffff?text=Mobile+UI'
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    ],
    3 => [
        'id' => 3,
        'name' => 'Icon Pack',
        'price' => 29.99,
<<<<<<< HEAD
        'image' => BASE_URL . '/assets/images/icon-pack.jpg'
=======
        'image' => 'https://via.placeholder.com/100x100/4cc9f0/ffffff?text=Icon+Pack'
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    ],
    4 => [
        'id' => 4,
        'name' => 'Development Tool',
        'price' => 59.99,
<<<<<<< HEAD
        'image' => BASE_URL . '/assets/images/dev-tool.jpg'
=======
        'image' => 'https://via.placeholder.com/100x100/f72585/ffffff?text=Dev+Tool'
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    ]
];

// Calculate cart total
$cart_total = 0;
$cart_items = [];
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['id'];
        if (isset($products[$product_id])) {
            $product = $products[$product_id];
            $item_total = $product['price'] * $item['quantity'];
            $cart_total += $item_total;
            
            $cart_items[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'total' => $item_total
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - YBT Digital</title>
    <!-- MDB Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<<<<<<< HEAD
    <link href="<?php echo BASE_URL; ?>/assets/css/theme.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/assets/css/mobile.css" rel="stylesheet">
=======
    <link href="../assets/css/theme.css" rel="stylesheet">
    <link href="../assets/css/mobile.css" rel="stylesheet">
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
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
        
        .cart-container {
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .cart-card {
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .cart-item {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .cart-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
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
            
            .cart-summary {
                margin-top: 20px;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-bottom-nav {
                display: none;
            }
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            border: none;
            cursor: pointer;
        }
        
        .quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid #ced4da;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light desktop-nav">
        <div class="container">
<<<<<<< HEAD
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">
=======
            <a class="navbar-brand" href="../index.php">
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                <i class="fas fa-store me-2"></i>YBT Digital
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
<<<<<<< HEAD
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
=======
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../products/index.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
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
<<<<<<< HEAD
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/orders.php">My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/logout.php">Logout</a></li>
=======
                                <li><a class="dropdown-item" href="../user/profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="../user/orders.php">My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../user/logout.php">Logout</a></li>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
<<<<<<< HEAD
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/user/login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/user/signup.php"><i class="fas fa-user-plus me-1"></i>Sign Up</a>
=======
                            <a class="nav-link" href="../user/login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../user/signup.php"><i class="fas fa-user-plus me-1"></i>Sign Up</a>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
<<<<<<< HEAD
        <a href="<?php echo BASE_URL; ?>/index.php" class="mobile-bottom-nav-item">
            <i class="fas fa-home mobile-bottom-nav-icon"></i>
            <span>Home</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/products/index.php" class="mobile-bottom-nav-item">
=======
        <a href="../index.php" class="mobile-bottom-nav-item">
            <i class="fas fa-home mobile-bottom-nav-icon"></i>
            <span>Home</span>
        </a>
        <a href="../products/index.php" class="mobile-bottom-nav-item">
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
            <i class="fas fa-shopping-bag mobile-bottom-nav-icon"></i>
            <span>Products</span>
        </a>
        <a href="index.php" class="mobile-bottom-nav-item active">
            <i class="fas fa-shopping-cart mobile-bottom-nav-icon"></i>
            <span>Cart</span>
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
<<<<<<< HEAD
            <a href="<?php echo BASE_URL; ?>/user/profile.php" class="mobile-bottom-nav-item">
=======
            <a href="../user/profile.php" class="mobile-bottom-nav-item">
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                <i class="fas fa-user mobile-bottom-nav-icon"></i>
                <span>Profile</span>
            </a>
        <?php else: ?>
<<<<<<< HEAD
            <a href="<?php echo BASE_URL; ?>/user/login.php" class="mobile-bottom-nav-item">
=======
            <a href="../user/login.php" class="mobile-bottom-nav-item">
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                <i class="fas fa-user mobile-bottom-nav-icon"></i>
                <span>Login</span>
            </a>
        <?php endif; ?>
    </div>

    <div class="cart-container">
        <div class="container">
            <h2><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h2>
            
            <?php if (empty($cart_items)): ?>
                <div class="card cart-card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Your cart is empty</h5>
                        <p class="text-muted">Add some products to your cart</p>
<<<<<<< HEAD
                        <a href="<?php echo BASE_URL; ?>/products/index.php" class="btn btn-primary">Browse Products</a>
=======
                        <a href="../products/index.php" class="btn btn-primary">Browse Products</a>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card cart-card">
                            <div class="card-body">
                                <?php foreach ($cart_items as $item): ?>
                                    <div class="cart-item">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
<<<<<<< HEAD
                                                <img src="<?php echo htmlspecialchars(build_image_url($item['product']['image'])); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($item['product']['name']); ?>">
=======
                                                <img src="<?php echo $item['product']['image']; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($item['product']['name']); ?>">
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                                            </div>
                                            <div class="col-md-4">
                                                <h5><?php echo htmlspecialchars($item['product']['name']); ?></h5>
                                                <p class="text-primary mb-0">$<?php echo number_format($item['product']['price'], 2); ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="quantity-control">
                                                    <button class="quantity-btn minus-btn" data-id="<?php echo $item['product']['id']; ?>">-</button>
                                                    <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1" data-id="<?php echo $item['product']['id']; ?>">
                                                    <button class="quantity-btn plus-btn" data-id="<?php echo $item['product']['id']; ?>">+</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="mb-0">$<?php echo number_format($item['total'], 2); ?></p>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="?remove=<?php echo $item['product']['id']; ?>" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card cart-card cart-summary">
                            <div class="card-body">
                                <h4 class="card-title">Order Summary</h4>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>$<?php echo number_format($cart_total, 2); ?></span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (10%):</span>
                                    <span>$<?php echo number_format($cart_total * 0.1, 2); ?></span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-4">
                                    <strong>Total:</strong>
                                    <strong>$<?php echo number_format($cart_total * 1.1, 2); ?></strong>
                                </div>
                                
<<<<<<< HEAD
                                <a href="<?php echo BASE_URL; ?>/checkout/index.php" class="btn btn-success w-100 mb-2">
                                    <i class="fas fa-lock me-2"></i>Proceed to Checkout
                                </a>
                                
                                <a href="<?php echo BASE_URL; ?>/products/index.php" class="btn btn-outline-primary w-100">
=======
                                <a href="../checkout/index.php" class="btn btn-success w-100 mb-2">
                                    <i class="fas fa-lock me-2"></i>Proceed to Checkout
                                </a>
                                
                                <a href="../products/index.php" class="btn btn-outline-primary w-100">
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                        
                        <div class="card mt-4">
                            <div class="card-body">
                                <h5><i class="fas fa-gift me-2"></i>Apply Coupon</h5>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Enter coupon code">
                                    <button class="btn btn-outline-secondary" type="button">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
<<<<<<< HEAD
                        <li><a href="<?php echo BASE_URL; ?>/index.php" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/products/index.php" class="text-light text-decoration-none">Products</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/about.php" class="text-light text-decoration-none">About</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/contact.php" class="text-light text-decoration-none">Contact</a></li>
=======
                        <li><a href="../index.php" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="../products/index.php" class="text-light text-decoration-none">Products</a></li>
                        <li><a href="#" class="text-light text-decoration-none">About</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Account</h5>
                    <ul class="list-unstyled">
                        <?php if (isset($_SESSION['user_id'])): ?>
<<<<<<< HEAD
                            <li><a href="<?php echo BASE_URL; ?>/user/profile.php" class="text-light text-decoration-none">Profile</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/user/orders.php" class="text-light text-decoration-none">Orders</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/user/logout.php" class="text-light text-decoration-none">Logout</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/user/login.php" class="text-light text-decoration-none">Login</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/user/signup.php" class="text-light text-decoration-none">Sign Up</a></li>
=======
                            <li><a href="../user/profile.php" class="text-light text-decoration-none">Profile</a></li>
                            <li><a href="../user/orders.php" class="text-light text-decoration-none">Orders</a></li>
                            <li><a href="../user/logout.php" class="text-light text-decoration-none">Logout</a></li>
                        <?php else: ?>
                            <li><a href="../user/login.php" class="text-light text-decoration-none">Login</a></li>
                            <li><a href="../user/signup.php" class="text-light text-decoration-none">Sign Up</a></li>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
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
        // Cart quantity controls
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                let quantity = parseInt(input.value);
                
                if (this.classList.contains('plus-btn')) {
                    quantity++;
                } else if (this.classList.contains('minus-btn') && quantity > 1) {
                    quantity--;
                }
                
                input.value = quantity;
                
                // Update cart via AJAX (in a real implementation)
                // For now, we'll just reload the page to simulate the update
                window.location.href = `update.php?product_id=${productId}&quantity=${quantity}`;
            });
        });
        
        // Quantity input change
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.getAttribute('data-id');
                let quantity = parseInt(this.value);
                
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                }
                
                this.value = quantity;
                
                // Update cart via AJAX (in a real implementation)
                // For now, we'll just reload the page to simulate the update
                window.location.href = `update.php?product_id=${productId}&quantity=${quantity}`;
            });
        });
        
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