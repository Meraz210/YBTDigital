<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Manage Coupons</h1>
    </div>
</div>

<!-- Coupons Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Admin Menu</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/dashboard">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/products">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/orders">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/users">Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo BASE_URL; ?>/admin/coupons">Coupons</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/settings">Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="<?php echo BASE_URL; ?>/admin/coupons/add" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Coupon
                    </a>
                    
                    <div>
                        Showing <?php echo $currentPage; ?> of <?php echo $totalPages; ?> pages
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Min Amount</th>
                                <th>Usage Limit</th>
                                <th>Used Count</th>
                                <th>Expiry</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($coupons)): ?>
                                <?php foreach ($coupons as $coupon): ?>
                                    <tr>
                                        <td><strong><?php echo e($coupon['code']); ?></strong></td>
                                        <td>
                                            <span class="badge bg-<?php echo $coupon['type'] === 'percentage' ? 'primary' : 'success'; ?>">
                                                <?php echo ucfirst($coupon['type']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($coupon['type'] === 'percentage'): ?>
                                                <?php echo $coupon['value']; ?>%
                                            <?php else: ?>
                                                $<?php echo number_format($coupon['value'], 2); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>$<?php echo number_format($coupon['min_amount'], 2); ?></td>
                                        <td><?php echo $coupon['usage_limit'] ?: 'Unlimited'; ?></td>
                                        <td><?php echo $coupon['used_count']; ?></td>
                                        <td>
                                            <?php if ($coupon['expires_at']): ?>
                                                <?php echo date('M j, Y', strtotime($coupon['expires_at'])); ?>
                                            <?php else: ?>
                                                Never
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo $coupon['is_active'] ? 'success' : 'secondary'; ?>">
                                                <?php echo $coupon['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/admin/coupons/edit/<?php echo $coupon['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/admin/coupons/delete/<?php echo $coupon['id']; ?>" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No coupons found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Coupons pagination">
                        <ul class="pagination justify-content-center">
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout.php';
?>