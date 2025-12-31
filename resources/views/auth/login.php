<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Login</h1>
    </div>
</div>

<!-- Login Section -->
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Sign In to Your Account</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo BASE_URL; ?>/user/login">
                            <input type="hidden" name="redirect" value="<?php echo e($_GET['redirect'] ?? '/dashboard'); ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? SecurityHelper::generateCSRFToken(); ?>">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/user/signup">Sign up here</a></p>
                            <p><a href="<?php echo BASE_URL; ?>/user/forgot-password">Forgot your password?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>