<?php
<<<<<<< HEAD
define('BASE_URL', '/YBTDigital');
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/login.php');
=======
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    exit;
}

require_once '../includes/db.php';

// Get statistics
<<<<<<< HEAD
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
=======
$stmt = $connection->prepare("SELECT COUNT(*) as count FROM users");
$stmt->execute();
$users_count = $stmt->get_result()->fetch_assoc()['count'];

$stmt = $connection->prepare("SELECT COUNT(*) as count FROM products");
$stmt->execute();
$products_count = $stmt->get_result()->fetch_assoc()['count'];

$stmt = $connection->prepare("SELECT COUNT(*) as count FROM orders");
$stmt->execute();
$orders_count = $stmt->get_result()->fetch_assoc()['count'];

// Get recent orders
$stmt = $connection->prepare("SELECT o.id, o.order_date, o.total_amount, o.status, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC LIMIT 5");
$stmt->execute();
$recent_orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get recent users
$stmt = $connection->prepare("SELECT id, name, email, created_at FROM users ORDER BY created_at DESC LIMIT 5");
$stmt->execute();
$recent_users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
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
        
<<<<<<< HEAD
        .admin-container {
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .stat-card {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: none;
=======
        .dashboard-container {
            min-height: 100vh;
            padding-top: 20px;
        }
        
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
<<<<<<< HEAD
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
=======
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding-top: 80px;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
        }
        
        .sidebar a {
            display: block;
<<<<<<< HEAD
            padding: 12px 15px;
            text-decoration: none;
            color: #495057;
            border-radius: 5px;
            margin-bottom: 5px;
=======
            padding: 12px 20px;
            text-decoration: none;
            color: rgba(255,255,255,0.8);
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
            transition: all 0.3s;
        }
        
        .sidebar a:hover, .sidebar a.active {
<<<<<<< HEAD
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
=======
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 999;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-logo {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 60px;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            z-index: 1001;
        }
        
        .admin-logo i {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="admin-logo">
        <i class="fas fa-store"></i> YBT Digital Admin
    </div>
    
    <div class="sidebar">
        <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="products.php"><i class="fas fa-box"></i> Products</a>
        <a href="orders.php"><i class="fas fa-shopping-bag"></i> Orders</a>
        <a href="users.php"><i class="fas fa-users"></i> Users</a>
        <a href="coupons.php"><i class="fas fa-gift"></i> Coupons</a>
        <a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <h4 class="mb-0">Dashboard</h4>
            </div>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($_SESSION['admin_name']); ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo $users_count; ?></h3>
                                    <p class="mb-0">Total Users</p>
                                </div>
                                <div class="stat-icon bg-white text-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo $products_count; ?></h3>
                                    <p class="mb-0">Total Products</p>
                                </div>
                                <div class="stat-icon bg-white text-success">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3><?php echo $orders_count; ?></h3>
                                    <p class="mb-0">Total Orders</p>
                                </div>
                                <div class="stat-icon bg-white text-info">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-shopping-bag me-2"></i>Recent Orders</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_orders as $order): ?>
                                            <tr>
                                                <td>#<?php echo $order['id']; ?></td>
                                                <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                                                <td><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                                                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $order['status'] === 'completed' ? 'success' : ($order['status'] === 'pending' ? 'warning' : 'danger'); ?>">
                                                        <?php echo ucfirst($order['status']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($recent_orders)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No recent orders</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-users me-2"></i>Recent Users</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($recent_users as $user): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($user['name']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($user['email']); ?></small>
                                    </div>
                                    <small><?php echo date('M j', strtotime($user['created_at'])); ?></small>
                                </div>
                            <?php endforeach; ?>
                            <?php if (empty($recent_users)): ?>
                                <p class="text-center text-muted">No recent users</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-line me-2"></i>Sales Overview</h5>
                        </div>
                        <div class="card-body text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Sales chart would appear here</p>
                            <p class="text-muted">Connect to your analytics service to view detailed reports</p>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
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

=======
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>