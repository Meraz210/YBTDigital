<?php
define('BASE_URL', '/YBTDigital');
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/login.php');
    exit;
}

require_once '../includes/db.php';

// Get statistics
$stmt = $connection->prepare("SELECT COUNT(*) as total_users FROM users");
$stmt->execute();
$result = $stmt->get_result();
$total_users = $result->fetch_assoc()['total_users'];

$stmt = $connection->prepare("SELECT COUNT(*) as total_products FROM products");
$stmt->execute();
$result = $stmt->get_result();
$total_products = $result->fetch_assoc()['total_products'];

$stmt = $connection->prepare("SELECT COUNT(*) as total_orders FROM orders");
$stmt->execute();
$result = $stmt->get_result();
$total_orders = $result->fetch_assoc()['total_orders'];

$stmt = $connection->prepare("SELECT COALESCE(SUM(total_amount), 0) as total_revenue FROM orders WHERE status = 'completed'");
$stmt->execute();
$result = $stmt->get_result();
$total_revenue = $result->fetch_assoc()['total_revenue'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YBT Digital</title>
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
        
        .admin-container {
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .stat-card {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: none;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
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
                <i class="fas fa-store me-2"></i>YBT Digital Admin
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/dashboard.php"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['admin_name']); ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/settings.php">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 mb-4">
                    <div class="sidebar p-3">
                        <h5>Admin Panel</h5>
                        <a href="<?php echo BASE_URL; ?>/admin/dashboard.php" class="active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="<?php echo BASE_URL; ?>/admin/products.php"><i class="fas fa-box me-2"></i>Products</a>
                        <a href="<?php echo BASE_URL; ?>/admin/orders.php"><i class="fas fa-shopping-cart me-2"></i>Orders</a>
                        <a href="<?php echo BASE_URL; ?>/admin/users.php"><i class="fas fa-users me-2"></i>Users</a>
                        <a href="<?php echo BASE_URL; ?>/admin/coupons.php"><i class="fas fa-tags me-2"></i>Coupons</a>
                        <a href="<?php echo BASE_URL; ?>/admin/settings.php"><i class="fas fa-cog me-2"></i>Settings</a>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-md-9">
                    <h3><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card">
                                <div class="card-body text-center">
                                    <div class="stat-icon bg-primary text-white mx-auto mb-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h4><?php echo $total_users; ?></h4>
                                    <p class="text-muted mb-0">Total Users</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card">
                                <div class="card-body text-center">
                                    <div class="stat-icon bg-success text-white mx-auto mb-3">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <h4><?php echo $total_products; ?></h4>
                                    <p class="text-muted mb-0">Products</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card">
                                <div class="card-body text-center">
                                    <div class="stat-icon bg-info text-white mx-auto mb-3">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <h4><?php echo $total_orders; ?></h4>
                                    <p class="text-muted mb-0">Total Orders</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card">
                                <div class="card-body text-center">
                                    <div class="stat-icon bg-warning text-white mx-auto mb-3">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <h4>$<?php echo number_format($total_revenue, 2); ?></h4>
                                    <p class="text-muted mb-0">Total Revenue</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-chart-bar me-2"></i>Recent Activity</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Recent orders, user registrations, and system activity will be displayed here.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-bell me-2"></i>System Notifications</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Important system notifications and alerts will appear here.</p>
                                </div>
                            </div>
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
                    <h5><i class="fas fa-store me-2"></i>YBT Digital Admin</h5>
                    <p>Admin panel for managing the digital product store.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/products.php" class="text-light text-decoration-none">Products</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/orders.php" class="text-light text-decoration-none">Orders</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/users.php" class="text-light text-decoration-none">Users</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Resources</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/admin/settings.php" class="text-light text-decoration-none">Settings</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/admin/logout.php" class="text-light text-decoration-none">Logout</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact Support</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> admin@ybtdigital.com</li>
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
</body>
</html>