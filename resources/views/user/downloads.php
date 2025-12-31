<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">My Downloads</h1>
    </div>
</div>

<!-- Downloads Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Account Menu</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/user/profile">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/user/change-password">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/orders">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo BASE_URL; ?>/orders/downloads">Downloads</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <?php if (!empty($orders)): ?>
                    <div class="row">
                        <?php foreach ($orders as $order): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($order['product_name']); ?></h5>
                                        <p class="card-text">Order ID: <?php echo e($order['transaction_id']); ?></p>
                                        <p class="card-text">Purchased: <?php echo date('M j, Y', strtotime($order['created_at'])); ?></p>
                                        <a href="<?php echo BASE_URL; ?>/orders/download/<?php echo $order['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-download fa-5x text-muted mb-3"></i>
                        <h4>No downloads available</h4>
                        <p class="text-muted">You haven't purchased any products yet.</p>
                        <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary">Start Shopping</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>