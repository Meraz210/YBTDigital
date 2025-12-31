<?php
session_start();
<<<<<<< HEAD
require_once '../config/config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/index.php');
=======

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
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
        // Check if user exists
        $stmt = $connection->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redirect to home page
<<<<<<< HEAD
                header('Location: ' . BASE_URL . '/index.php');
=======
                header('Location: ../index.php');
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                exit;
            } else {
                $message = 'Invalid password.';
            }
        } else {
            $message = 'No account found with that email.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YBT Digital</title>
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
                    <i class="fas fa-store"></i>
                    <h2>YBT Digital</h2>
                    <h4>Login to Your Account</h4>
                </div>
                
                <?php if ($message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
<<<<<<< HEAD
                        <a href="<?php echo BASE_URL; ?>/user/forgot-password">Forgot password?</a>
=======
                        <a href="forgot-password.php">Forgot password?</a>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    
                    <div class="text-center">
<<<<<<< HEAD
                        <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/user/signup.php">Sign up here</a></p>
=======
                        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>