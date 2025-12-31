<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Forgot Password</h1>
    </div>
</div>

<!-- Forgot Password Section -->
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Reset Your Password</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Enter your email address and we'll send you a link to reset your password.</p>
                        
                        <form method="POST" action="<?php echo BASE_URL; ?>/user/forgot-password">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p><a href="<?php echo BASE_URL; ?>/user/login">Back to Login</a></p>
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