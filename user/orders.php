<?php
session_start();
require_once '../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/user/login.php');
    exit;
}

require_once '../includes/db.php';

// Check if database connection is valid
if (!$connection || $connection->connect_error) {
    die('Database connection failed: ' . ($connection ? $connection->connect_error : 'Unknown error'));
}

// Get user orders
$stmt = $connection->prepare("SELECT o.id, o.created_at as order_date, o.total_amount, o.status, p.name as product_name FROM orders o JOIN products p ON o.product_id = p.id WHERE o.user_id = ? ORDER BY o.created_at DESC");

// Check if prepare statement succeeded
if (!$stmt) {
    die('Prepare failed: ' . $connection->error);
}

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - YBT Digital</title>
    <!-- MDB Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        
        .orders-container {
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .order-card {
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
            transition: transform 0.3s;
        }
        
        .order-card:hover {
            transform: translateY(-5px);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .sidebar {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
        }
        
        .sidebar a {
            display: block;
            padding: 12px 15px;
            text-decoration: none;
            color: #495057;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background-color: var(--primary-color);
            color: white;
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
                </ul>
                <ul class="navbar-nav">
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
                </ul>
            </div>
        </div>
    </nav>

    <div class="orders-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 mb-4">
                    <div class="sidebar p-3">
                        <h5>Account Settings</h5>
                        <a href="<?php echo BASE_URL; ?>/user/profile.php"><i class="fas fa-user me-2"></i>Profile</a>
                        <a href="<?php echo BASE_URL; ?>/user/orders.php" class="active"><i class="fas fa-shopping-bag me-2"></i>My Orders</a>
                        <a href="<?php echo BASE_URL; ?>/user/downloads.php"><i class="fas fa-download me-2"></i>Downloads</a>
                        <a href="<?php echo BASE_URL; ?>/user/profile.php?tab=password"><i class="fas fa-cog me-2"></i>Settings</a>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="fas fa-shopping-bag me-2"></i>My Orders</h3>
                        <a href="<?php echo BASE_URL; ?>/products/index.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                    
                    <?php if (empty($orders)): ?>
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No orders yet</h5>
                                <p class="text-muted">You haven't placed any orders yet. Start shopping now!</p>
                                <a href="<?php echo BASE_URL; ?>/products/index.php" class="btn btn-primary">Browse Products</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($orders as $order): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card order-card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h5 class="card-title">Order #<?php echo htmlspecialchars($order['id']); ?></h5>
                                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                                    <?php echo ucfirst($order['status']); ?>
                                                </span>
                                            </div>
                                            
                                            <p class="card-text">
                                                <strong>Product:</strong> <?php echo htmlspecialchars($order['product_name']); ?><br>
                                                <strong>Date:</strong> <?php echo date('M j, Y', strtotime($order['order_date'])); ?><br>
                                                <strong>Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?>
                                            </p>
                                            
                                            <div class="d-flex justify-content-between">
                                                <a href="download.php?order_id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-invoice me-1"></i>Invoice
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
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
                        <li><a href="#" class="text-light text-decoration-none">About</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Account</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/user/profile.php" class="text-light text-decoration-none">Profile</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/user/orders.php" class="text-light text-decoration-none">Orders</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/user/logout.php" class="text-light text-decoration-none">Logout</a></li>
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

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
        <a href="<?php echo BASE_URL; ?>/index.php" class="mobile-bottom-nav-item">
            <i class="fas fa-home mobile-bottom-nav-icon"></i>
            <span>Home</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/products/index.php" class="mobile-bottom-nav-item">
            <i class="fas fa-shopping-bag mobile-bottom-nav-icon"></i>
            <span>Products</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/cart/index.php" class="mobile-bottom-nav-item">
            <i class="fas fa-shopping-cart mobile-bottom-nav-icon"></i>
            <span>Cart</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/user/orders.php" class="mobile-bottom-nav-item active">
            <i class="fas fa-shopping-bag mobile-bottom-nav-icon"></i>
            <span>Orders</span>
        </a>
    </div>

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>