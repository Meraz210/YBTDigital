<?php
define('BASE_URL', '/YBTDigital');
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/login.php');
    exit;
}

require_once '../includes/db.php';

// Get all orders with user and product information
$stmt = $connection->prepare("SELECT o.*, u.name as user_name, u.email as user_email, p.name as product_name FROM orders o JOIN users u ON o.user_id = u.id JOIN products p ON o.product_id = p.id ORDER BY o.order_date DESC");
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - YBT Digital Admin</title>
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
                        <a href="<?php echo BASE_URL; ?>/admin/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="<?php echo BASE_URL; ?>/admin/products.php"><i class="fas fa-box me-2"></i>Products</a>
                        <a href="<?php echo BASE_URL; ?>/admin/orders.php" class="active"><i class="fas fa-shopping-cart me-2"></i>Orders</a>
                        <a href="<?php echo BASE_URL; ?>/admin/users.php"><i class="fas fa-users me-2"></i>Users</a>
                        <a href="<?php echo BASE_URL; ?>/admin/coupons.php"><i class="fas fa-tags me-2"></i>Coupons</a>
                        <a href="<?php echo BASE_URL; ?>/admin/settings.php"><i class="fas fa-cog me-2"></i>Settings</a>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="fas fa-shopping-cart me-2"></i>Manage Orders</h3>
                    </div>
                    
                    <?php if (empty($orders)): ?>
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No orders found</h5>
                                <p class="text-muted">Orders will appear here when users make purchases</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?php echo $order['id']; ?></td>
                                            <td>
                                                <div><?php echo htmlspecialchars($order['user_name']); ?></div>
                                                <small class="text-muted"><?php echo htmlspecialchars($order['user_email']); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                                    <?php echo ucfirst($order['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/admin/orders/view.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/admin/orders/edit.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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