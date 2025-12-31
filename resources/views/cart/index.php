<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Shopping Cart</h1>
    </div>
</div>

<!-- Cart Section -->
<section class="py-4">
    <div class="container">
        <?php if (!empty($cartItems)): ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['product']['image'])): ?>
                                                    <img src="<?php echo build_image_url($item['product']['image']); ?>" alt="<?php echo e($item['product']['name']); ?>" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                <?php else: ?>
                                                    <img src="<?php echo BASE_URL; ?>/assets/images/placeholder.jpg" alt="<?php echo e($item['product']['name']); ?>" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div>
                                                    <h6><?php echo e($item['product']['name']); ?></h6>
                                                    <p class="text-muted mb-0"><?php echo e(substr($item['product']['description'], 0, 50)); ?>...</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>$<?php echo number_format($item['product']['price'], 2); ?></td>
                                        <td>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/cart/update" class="d-inline">
                                                <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                                                <div class="input-group" style="width: 120px;">
                                                    <input type="number" class="form-control" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" onchange="this.form.submit()">
                                                </div>
                                            </form>
                                        </td>
                                        <td>$<?php echo number_format($item['total'], 2); ?></td>
                                        <td>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/cart/remove/<?php echo $item['product']['id']; ?>" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>$<?php echo number_format($total, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (<?php echo (TAX_RATE * 100); ?>%):</span>
                                <span>$<?php echo number_format($total * TAX_RATE, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong>$<?php echo number_format($total + ($total * TAX_RATE), 2); ?></strong>
                            </div>
                            
                            <a href="<?php echo BASE_URL; ?>/checkout" class="btn btn-primary w-100">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12 text-center">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                    <h3>Your cart is empty</h3>
                    <p class="text-muted">Looks like you haven't added anything to your cart yet</p>
                    <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary">Continue Shopping</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>