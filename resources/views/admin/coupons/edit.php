<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Edit Coupon</h1>
    </div>
</div>

<!-- Edit Coupon Section -->
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Coupon Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo BASE_URL; ?>/admin/coupons/edit/<?php echo $coupon['id']; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Coupon Code</label>
                                        <input type="text" class="form-control" id="code" name="code" value="<?php echo e($coupon['code']); ?>" required>
                                        <div class="form-text">Enter a unique coupon code (e.g., SAVE10)</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Coupon Type</label>
                                        <select class="form-select" id="type" name="type" required>
                                            <option value="percentage" <?php echo $coupon['type'] === 'percentage' ? 'selected' : ''; ?>>Percentage Discount</option>
                                            <option value="fixed" <?php echo $coupon['type'] === 'fixed' ? 'selected' : ''; ?>>Fixed Amount Discount</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="value" class="form-label">Discount Value</label>
                                        <input type="number" class="form-control" id="value" name="value" step="0.01" min="0" value="<?php echo $coupon['value']; ?>" required>
                                        <div class="form-text">For percentage: 10 = 10% off; For fixed: 5.00 = $5.00 off</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="min_amount" class="form-label">Minimum Order Amount</label>
                                        <input type="number" class="form-control" id="min_amount" name="min_amount" step="0.01" min="0" value="<?php echo $coupon['min_amount']; ?>">
                                        <div class="form-text">Minimum order amount required to use this coupon</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="usage_limit" class="form-label">Usage Limit</label>
                                        <input type="number" class="form-control" id="usage_limit" name="usage_limit" min="0" value="<?php echo $coupon['usage_limit']; ?>">
                                        <div class="form-text">Number of times this coupon can be used (0 for unlimited)</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="expires_at" class="form-label">Expiry Date</label>
                                        <input type="date" class="form-control" id="expires_at" name="expires_at" value="<?php echo $coupon['expires_at'] ? date('Y-m-d', strtotime($coupon['expires_at'])) : ''; ?>">
                                        <div class="form-text">Leave blank for no expiry date</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="is_active" class="form-label">Status</label>
                                        <select class="form-select" id="is_active" name="is_active">
                                            <option value="1" <?php echo $coupon['is_active'] ? 'selected' : ''; ?>>Active</option>
                                            <option value="0" <?php echo !$coupon['is_active'] ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Coupon</button>
                            <a href="<?php echo BASE_URL; ?>/admin/coupons" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout.php';
?>