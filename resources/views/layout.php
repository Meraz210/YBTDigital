<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    
    <!-- MDB UI Kit CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo BASE_URL; ?>/assets/css/theme.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/assets/css/star-rating.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/assets/images/favicon.ico">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/">
                <i class="fas fa-store"></i> <?php echo SITE_NAME; ?>
            </a>
            
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/contact">Contact</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> <?php echo e($_SESSION['user_name']); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/profile"><i class="fas fa-user-circle"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/change-password"><i class="fas fa-key"></i> Change Password</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/orders"><i class="fas fa-shopping-cart"></i> My Orders</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/orders/downloads"><i class="fas fa-download"></i> Downloads</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/user/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/user/signup">Sign Up</a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/cart">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                                <span class="badge rounded-pill badge-notification bg-danger"><?php echo count($_SESSION['cart']); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    
                    <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'super_admin'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/dashboard">Admin</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <?php 
    $flashMessage = null;
    if (isset($_SESSION['flash_message'])) {
        $flashMessage = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
    }
    if ($flashMessage): 
    ?>
        <div class="container mt-3">
            <div class="alert alert-<?php echo e($flashMessage['type']); ?> alert-dismissible fade show" role="alert">
                <?php echo $flashMessage['message']; ?>
                <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main>
        <?php echo $content; ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-dark text-light mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><?php echo SITE_NAME; ?></h5>
                    <p>Your trusted source for premium digital products and resources.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/" class="text-light">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/products" class="text-light">Products</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/about" class="text-light">About</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/contact" class="text-light">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contact Us</h5>
                    <p><i class="fas fa-envelope"></i> support@ybtdigital.com</p>
                    <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- MDB UI Kit JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo BASE_URL; ?>/assets/js/star-rating.js"></script>
    <script>
        // Initialize star ratings
        document.addEventListener('DOMContentLoaded', function() {
            const starContainers = document.querySelectorAll('.star-rating-container');
            starContainers.forEach(container => {
                initializeStarRating(container);
            });
        });
    </script>
</body>
</html>