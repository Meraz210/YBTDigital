<?php
session_start();

<<<<<<< HEAD
// Check if order details are in session
if (!isset($_SESSION['last_order'])) {
    header('Location: ../index.php');
    exit;
}

$order = $_SESSION['last_order'];
=======
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit;
}

require_once '../includes/db.php';
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - YBT Digital</title>
    <!-- MDB Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
<<<<<<< HEAD
            --success-color: #28a745;
=======
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
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
        
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        
        .success-card {
<<<<<<< HEAD
            max-width: 600px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--success-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
=======
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
<<<<<<< HEAD
        .order-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
=======
        .success-icon {
            width: 100px;
            height: 100px;
            background-color: #d4edda;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .success-icon i {
            font-size: 3rem;
            color: #28a745;
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
        }
    </style>
</head>
<body>
<<<<<<< HEAD
    <div class="success-container">
        <div class="card success-card">
            <div class="card-body text-center p-5">
                <div class="success-icon">
                    <i class="fas fa-check text-white" style="font-size: 2rem;"></i>
                </div>
                
                <h2 class="text-success mb-3">Order Successful!</h2>
                <p class="lead mb-4">Thank you for your purchase. Your order has been placed successfully.</p>
                
                <div class="order-details mb-4">
                    <h5>Order Details</h5>
                    <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
                    <p><strong>Order Date:</strong> <?php echo date('M j, Y', strtotime($order['date'])); ?></p>
                    <p><strong>Total Amount:</strong> $<?php echo number_format($order['amount'], 2); ?></p>
                    <p><strong>Status:</strong> <span class="badge bg-success"><?php echo ucfirst($order['status']); ?></span></p>
                </div>
                
                <div class="d-flex justify-content-center gap-3">
                    <a href="../products/index.php" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                    </a>
                    <a href="../user/orders.php" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>View Orders
                    </a>
                </div>
=======
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                        <a class="nav-link" href="../products/index.php">Products</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
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
                </ul>
            </div>
        </div>
    </nav>

    <div class="success-container">
        <div class="card success-card">
            <div class="card-body p-5">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                
                <h2 class="card-title">Order Successful!</h2>
                <p class="card-text">Thank you for your purchase. Your order has been processed successfully.</p>
                
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    Your order confirmation has been sent to <?php echo htmlspecialchars($_SESSION['user_email']); ?>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-receipt text-primary me-2"></i>Order ID</h5>
                                <p class="card-text">#<?php echo rand(100000, 999999); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-calendar-alt text-primary me-2"></i>Date</h5>
                                <p class="card-text"><?php echo date('M j, Y'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="../user/orders.php" class="btn btn-primary me-2">
                    <i class="fas fa-shopping-bag me-2"></i>View Orders
                </a>
                <a href="../products/index.php" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-cart me-2"></i>Continue Shopping
                </a>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
            </div>
        </div>
    </div>

<<<<<<< HEAD
=======
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
                        <li><a href="../products/index.php" class="text-light text-decoration-none">Products</a></li>
                        <li><a href="#" class="text-light text-decoration-none">About</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Account</h5>
                    <ul class="list-unstyled">
                        <li><a href="../user/profile.php" class="text-light text-decoration-none">Profile</a></li>
                        <li><a href="../user/orders.php" class="text-light text-decoration-none">Orders</a></li>
                        <li><a href="../user/logout.php" class="text-light text-decoration-none">Logout</a></li>
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

>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>