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

<<<<<<< HEAD
// Get all orders with user and product information
$stmt = $connection->prepare("SELECT o.*, u.name as user_name, u.email as user_email, p.name as product_name FROM orders o JOIN users u ON o.user_id = u.id JOIN products p ON o.product_id = p.id ORDER BY o.order_date DESC");
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
=======
// Sample orders data
$orders = [
    [
        'id' => 1001,
        'user_name' => 'John Doe',
        'user_email' => 'john@example.com',
        'product_name' => 'Premium Web Template',
        'amount' => 49.99,
        'status' => 'completed',
        'date' => '2023-12-01 10:30:00',
        'transaction_id' => 'txn_123456789'
    ],
    [
        'id' => 1002,
        'user_name' => 'Jane Smith',
        'user_email' => 'jane@example.com',
        'product_name' => 'Mobile UI Kit',
        'amount' => 39.99,
        'status' => 'pending',
        'date' => '2023-12-02 14:20:00',
        'transaction_id' => 'txn_987654321'
    ],
    [
        'id' => 1003,
        'user_name' => 'Robert Johnson',
        'user_email' => 'robert@example.com',
        'product_name' => 'Icon Pack',
        'amount' => 29.99,
        'status' => 'completed',
        'date' => '2023-12-03 09:15:00',
        'transaction_id' => 'txn_456789123'
    ],
    [
        'id' => 1004,
        'user_name' => 'Emily Davis',
        'user_email' => 'emily@example.com',
        'product_name' => 'Development Tool',
        'amount' => 59.99,
        'status' => 'cancelled',
        'date' => '2023-12-04 16:45:00',
        'transaction_id' => 'txn_321654987'
    ]
];
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Manage Orders - YBT Digital Admin</title>
=======
    <title>Orders Management - YBT Digital Admin</title>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
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
=======
        .dashboard-container {
            min-height: 100vh;
            padding-top: 20px;
        }
        
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
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
        }
        
        .sidebar a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: rgba(255,255,255,0.8);
            transition: all 0.3s;
        }
        
        .sidebar a:hover, .sidebar a.active {
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
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
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
<<<<<<< HEAD
        
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
=======
    </style>
</head>
<body>
    <div class="admin-logo">
        <i class="fas fa-store"></i> YBT Digital Admin
    </div>
    
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="products.php"><i class="fas fa-box"></i> Products</a>
        <a href="orders.php" class="active"><i class="fas fa-shopping-bag"></i> Orders</a>
        <a href="users.php"><i class="fas fa-users"></i> Users</a>
        <a href="coupons.php"><i class="fas fa-gift"></i> Coupons</a>
        <a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <h4 class="mb-0">Orders Management</h4>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-shopping-bag me-2"></i>Orders</h3>
                <div class="d-flex">
                    <input type="text" class="form-control me-2" placeholder="Search orders...">
                    <button class="btn btn-outline-secondary">Filter</button>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Transaction ID</th>
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
                                        <td>$<?php echo number_format($order['amount'], 2); ?></td>
                                        <td><?php echo date('M j, Y g:i A', strtotime($order['date'])); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $order['status']; ?>">
                                                <?php echo ucfirst($order['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $order['transaction_id']; ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-mdb-toggle="modal" data-mdb-target="#viewOrderModal<?php echo $order['id']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" data-mdb-toggle="modal" data-mdb-target="#updateOrderModal<?php echo $order['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
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
    
    <!-- View Order Modal -->
    <?php foreach ($orders as $order): ?>
        <div class="modal fade" id="viewOrderModal<?php echo $order['id']; ?>" tabindex="-1" aria-labelledby="viewOrderModalLabel<?php echo $order['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewOrderModalLabel<?php echo $order['id']; ?>">Order Details #<?php echo $order['id']; ?></h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Customer Information</h6>
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($order['user_name']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['user_email']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Order Information</h6>
                                <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
                                <p><strong>Date:</strong> <?php echo date('M j, Y g:i A', strtotime($order['date'])); ?></p>
                                <p><strong>Status:</strong> <span class="status-badge status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Product Information</h6>
                                <p><strong>Product:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
                                <p><strong>Amount:</strong> $<?php echo number_format($order['amount'], 2); ?></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Payment Information</h6>
                                <p><strong>Transaction ID:</strong> <?php echo $order['transaction_id']; ?></p>
                                <p><strong>Payment Status:</strong> Paid</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Download Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    
    <!-- Update Order Modal -->
    <?php foreach ($orders as $order): ?>
        <div class="modal fade" id="updateOrderModal<?php echo $order['id']; ?>" tabindex="-1" aria-labelledby="updateOrderModalLabel<?php echo $order['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateOrderModalLabel<?php echo $order['id']; ?>">Update Order #<?php echo $order['id']; ?></h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="status_<?php echo $order['id']; ?>" class="form-label">Order Status</label>
                                <select class="form-control" id="status_<?php echo $order['id']; ?>" name="status">
                                    <option value="pending" <?php echo ($order['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="completed" <?php echo ($order['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                                    <option value="cancelled" <?php echo ($order['status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Update Order</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>