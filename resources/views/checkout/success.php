<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Order Confirmation</h1>
    </div>
</div>

<!-- Success Section -->
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body py-5">
                        <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                        <h2 class="text-success">Thank You for Your Order!</h2>
                        <p class="lead">Your order has been placed successfully.</p>
                        
                        <div class="alert alert-info">
                            <p><strong>Order ID:</strong> <?php echo e($orderId); ?></p>
                            <p class="mb-0">A confirmation email has been sent to your email address.</p>
                        </div>
                        
                        <p>You can access your purchased products from the <a href="<?php echo BASE_URL; ?>/orders/downloads">Downloads</a> section in your account.</p>
                        
                        <div class="mt-4">
                            <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary me-2">Continue Shopping</a>
                            <a href="<?php echo BASE_URL; ?>/orders/downloads" class="btn btn-success">Access Downloads</a>
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