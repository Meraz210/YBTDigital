<?php
session_start();
require_once '../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/user/login.php');
    exit;
}

require_once '../includes/db.php';

$message = '';
$success = false;

// Get user data
$stmt = $connection->prepare("SELECT id, name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header('Location: ' . BASE_URL . '/user/login.php');
    exit;
}

// Determine active tab
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';

if ($active_tab == 'password' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle password change
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate input
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $message = 'New passwords do not match.';
    } elseif (strlen($new_password) < 6) {
        $message = 'New password must be at least 6 characters long.';
    } else {
        // Verify current password
        $stmt = $connection->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();
        
        if (!password_verify($current_password, $user_data['password'])) {
            $message = 'Current password is incorrect.';
        } else {
            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                $message = 'Password updated successfully!';
                $success = true;
            } else {
                $message = 'Failed to update password. Please try again.';
            }
        }
    }
} elseif ($active_tab == 'profile' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle profile update
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    
    if (empty($name) || empty($email)) {
        $message = 'Name and email are required.';
    } else {
        // Check if email already exists for another user
        $stmt = $connection->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $message = 'Another user is already using this email address.';
        } else {
            // Update user information
            $stmt = $connection->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssi", $name, $email, $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                // Update session data
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                
                $message = 'Profile updated successfully!';
                $success = true;
                
                // Refresh user data
                $stmt = $connection->prepare("SELECT id, name, email FROM users WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
            } else {
                $message = 'Failed to update profile. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - YBT Digital</title>
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
        
        .profile-container {
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .profile-card {
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
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
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

    <div class="profile-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 mb-4">
                    <div class="sidebar p-3">
                        <h5>Account Settings</h5>
                        <a href="<?php echo BASE_URL; ?>/user/profile.php" class="active"><i class="fas fa-user me-2"></i>Profile</a>
                        <a href="<?php echo BASE_URL; ?>/user/orders.php"><i class="fas fa-shopping-bag me-2"></i>My Orders</a>
                        <a href="<?php echo BASE_URL; ?>/user/downloads.php"><i class="fas fa-download me-2"></i>Downloads</a>
                        <a href="<?php echo BASE_URL; ?>/user/profile.php?tab=password"><i class="fas fa-cog me-2"></i>Settings</a>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="fas fa-user me-2"></i>My Profile</h3>
                        <a href="<?php echo BASE_URL; ?>/products/index.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                    
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Profile Tab -->
                    <?php if ($active_tab == 'profile'): ?>
                    <div class="card profile-card">
                        <div class="card-body">
                            <h5 class="card-title">Update Profile Information</h5>
                            
                            <form method="POST" action="">
                                <div class="mb-4">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Password Tab -->
                    <?php if ($active_tab == 'password'): ?>
                    <div class="card profile-card">
                        <div class="card-body">
                            <h5 class="card-title">Change Password</h5>
                            
                            <form method="POST" action="?tab=password">
                                <div class="mb-4">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Account Settings</h5>
                            <div class="d-flex gap-2">
                                <a href="<?php echo BASE_URL; ?>/user/profile.php?tab=profile" class="btn btn-outline-primary <?php echo $active_tab == 'profile' ? 'active' : ''; ?>">Profile</a>
                                <a href="<?php echo BASE_URL; ?>/user/profile.php?tab=password" class="btn btn-outline-primary <?php echo $active_tab == 'password' ? 'active' : ''; ?>">Change Password</a>
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
        <a href="<?php echo BASE_URL; ?>/user/orders.php" class="mobile-bottom-nav-item">
            <i class="fas fa-shopping-bag mobile-bottom-nav-icon"></i>
            <span>Orders</span>
        </a>
    </div>

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>