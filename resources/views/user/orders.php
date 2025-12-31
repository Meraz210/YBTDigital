<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">My Orders</h1>
    </div>
</div>

<!-- Orders Section -->
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
                                <a class="nav-link active" href="<?php echo BASE_URL; ?>/orders">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/orders/downloads">Downloads</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <?php if (!empty($orders)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo e($order['transaction_id']); ?></td>
                                        <td><?php echo e($order['product_name']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $order['status'] === 'completed' ? 'success' : ($order['status'] === 'pending' ? 'warning' : 'danger'); ?>">
                                                <?php echo ucfirst($order['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($order['status'] === 'completed'): ?>
                                                <a href="<?php echo BASE_URL; ?>/orders/downloads" class="btn btn-sm btn-primary">Download</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-bag fa-5x text-muted mb-3"></i>
                        <h4>No orders found</h4>
                        <p class="text-muted">You haven't placed any orders yet.</p>
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