<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">System Settings</h1>
    </div>
</div>

<!-- Settings Section -->
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
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/coupons">Coupons</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo BASE_URL; ?>/admin/settings">Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">General Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Site Name</label>
                                        <input type="text" class="form-control" id="site_name" name="site_name" value="<?php echo e(SITE_NAME); ?>">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="site_url" class="form-label">Site URL</label>
                                        <input type="text" class="form-control" id="site_url" name="site_url" value="<?php echo e(SITE_URL); ?>">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="currency" class="form-label">Currency</label>
                                        <select class="form-select" id="currency" name="currency">
                                            <option value="USD" selected>USD - US Dollar</option>
                                            <option value="EUR">EUR - Euro</option>
                                            <option value="GBP">GBP - British Pound</option>
                                            <option value="JPY">JPY - Japanese Yen</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                                        <input type="number" class="form-control" id="tax_rate" name="tax_rate" step="0.01" min="0" max="100" value="<?php echo TAX_RATE * 100; ?>">
                                        <div class="form-text">Tax rate applied to all orders</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="max_file_size" class="form-label">Max File Size (MB)</label>
                                        <input type="number" class="form-control" id="max_file_size" name="max_file_size" min="1" value="50">
                                        <div class="form-text">Maximum file size for product uploads</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="download_limit" class="form-label">Default Download Limit</label>
                                        <input type="number" class="form-control" id="download_limit" name="download_limit" min="1" value="5">
                                        <div class="form-text">Default number of downloads allowed per purchase</div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Payment Gateways</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Configure your payment gateway settings here. For security reasons, API keys are not displayed after saving.
                        </div>
                        
                        <div class="d-grid gap-3">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Stripe</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo BASE_URL; ?>/admin/settings/payment-gateways">
                                        <input type="hidden" name="gateway_name" value="stripe">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="stripe_publishable_key" class="form-label">Publishable Key</label>
                                                    <input type="password" class="form-control" id="stripe_publishable_key" name="config[publishable_key]" placeholder="pk_...">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="stripe_secret_key" class="form-label">Secret Key</label>
                                                    <input type="password" class="form-control" id="stripe_secret_key" name="config[secret_key]" placeholder="sk_...">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" class="form-check-input" id="stripe_active" name="is_active" value="1">
                                                    <label class="form-check-label" for="stripe_active">Enable Stripe</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Stripe Settings</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Razorpay</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo BASE_URL; ?>/admin/settings/payment-gateways">
                                        <input type="hidden" name="gateway_name" value="razorpay">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="razorpay_key_id" class="form-label">Key ID</label>
                                                    <input type="password" class="form-control" id="razorpay_key_id" name="config[key_id]" placeholder="rzp_...">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="razorpay_key_secret" class="form-label">Key Secret</label>
                                                    <input type="password" class="form-control" id="razorpay_key_secret" name="config[key_secret]" placeholder="...">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" class="form-check-input" id="razorpay_active" name="is_active" value="1">
                                                    <label class="form-check-label" for="razorpay_active">Enable Razorpay</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Razorpay Settings</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">PayPal</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo BASE_URL; ?>/admin/settings/payment-gateways">
                                        <input type="hidden" name="gateway_name" value="paypal">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="paypal_client_id" class="form-label">Client ID</label>
                                                    <input type="password" class="form-control" id="paypal_client_id" name="config[client_id]" placeholder="...">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="paypal_client_secret" class="form-label">Client Secret</label>
                                                    <input type="password" class="form-control" id="paypal_client_secret" name="config[client_secret]" placeholder="...">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" class="form-check-input" id="paypal_active" name="is_active" value="1">
                                                    <label class="form-check-label" for="paypal_active">Enable PayPal</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save PayPal Settings</button>
                                    </form>
                                </div>
                            </div>
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