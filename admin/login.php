<?php
<<<<<<< HEAD
define('BASE_URL', '/YBTDigital');
=======
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
<<<<<<< HEAD
    header('Location: ' . BASE_URL . '/admin/dashboard.php');
=======
    header('Location: dashboard.php');
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
    exit;
}

require_once '../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if (empty($email) || empty($password)) {
        $message = 'Email and password are required.';
    } else {
<<<<<<< HEAD
        // Check if admin exists (in this example, we'll check for admin role)
        $stmt = $connection->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Check if user has admin role
                if ($user['role'] == 'admin' || $user['role'] == 'super_admin') {
                    // Set session variables
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_name'] = $user['name'];
                    $_SESSION['admin_email'] = $user['email'];
                    $_SESSION['admin_role'] = $user['role'];
                    
                    // Redirect to admin dashboard
                    header('Location: ' . BASE_URL . '/admin/dashboard.php');
                    exit;
                } else {
                    $message = 'Access denied. You do not have admin privileges.';
                }
            } else {
                $message = 'Invalid password.';
            }
        } else {
            $message = 'No admin account found with that email.';
=======
        // Check if admin exists (for now, we'll use a sample admin account)
        // In a real implementation, you would have an admins table in the database
        if ($email === 'admin@ybtdigital.com' && $password === 'admin123') {
            // Set session variables
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_name'] = 'Admin User';
            $_SESSION['admin_email'] = $email;
            
            // Redirect to admin dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $message = 'Invalid admin credentials.';
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - YBT Digital</title>
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
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-card {
            width: 100%;
            max-width: 450px;
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
        
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .logo h2 {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="card-body p-5">
                <div class="logo">
<<<<<<< HEAD
                    <i class="fas fa-store"></i>
                    <h2>YBT Digital Admin</h2>
=======
                    <i class="fas fa-lock"></i>
                    <h2>YBT Digital</h2>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                    <h4>Admin Login</h4>
                </div>
                
                <?php if ($message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="email" class="form-label">Admin Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
<<<<<<< HEAD
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login to Admin Panel</button>
=======
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    
                    <div class="text-center">
                        <a href="../index.php">← Back to Store</a>
                    </div>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                </form>
            </div>
        </div>
    </div>

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>