<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Checkout</h1>
    </div>
</div>

<!-- Checkout Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- Billing Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Billing Information</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-select" id="state" required>
                                        <option value="">Choose...</option>
                                        <option>CA</option>
                                        <option>NY</option>
                                        <option>TX</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="zip" class="form-label">Zip</label>
                                    <input type="text" class="form-control" id="zip" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo BASE_URL; ?>/checkout/process">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_gateway" id="stripe" value="stripe" checked>
                                        <label class="form-check-label" for="stripe">
                                            <i class="fab fa-cc-stripe"></i> Stripe
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_gateway" id="razorpay" value="razorpay">
                                        <label class="form-check-label" for="razorpay">
                                            <i class="fas fa-credit-card"></i> Razorpay
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_gateway" id="paypal" value="paypal">
                                        <label class="form-check-label" for="paypal">
                                            <i class="fab fa-paypal"></i> PayPal
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Coupon Form -->
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="coupon_code" placeholder="Enter coupon code" value="<?php echo e($couponCode); ?>">
                                        <button class="btn btn-outline-secondary" type="submit" formaction="<?php echo BASE_URL; ?>/orders/apply-coupon">Apply</button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-lock"></i> Place Order Securely
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?php echo e($item['product']['name']); ?> x<?php echo $item['quantity']; ?></span>
                                <span>$<?php echo number_format($item['total'], 2); ?></span>
                            </div>
                        <?php endforeach; ?>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>$<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        
                        <?php if ($discount > 0): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Discount:</span>
                                <span>-$<?php echo number_format($discount, 2); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (<?php echo (TAX_RATE * 100); ?>%):</span>
                            <span>$<?php echo number_format($tax, 2); ?></span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong>$<?php echo number_format($total, 2); ?></strong>
                        </div>
                        
                        <?php if (!empty($couponCode)): ?>
                            <div class="alert alert-info">
                                <small>Coupon <strong><?php echo e($couponCode); ?></strong> applied</small>
                                <a href="<?php echo BASE_URL; ?>/orders/remove-coupon" class="float-end">Remove</a>
                            </div>
                        <?php endif; ?>
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