<?php
session_start();

// Check if order details are in session
if (!isset($_SESSION['last_order'])) {
    header('Location: ../index.php');
    exit;
}

$order = $_SESSION['last_order'];
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
            --success-color: #28a745;
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
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .order-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }
    </style>
</head>
<body>
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
            </div>
        </div>
    </div>

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>