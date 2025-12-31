<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Admin Dashboard</h1>
    </div>
</div>

<!-- Dashboard Section -->
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
                                <a class="nav-link active" href="<?php echo BASE_URL; ?>/admin/dashboard">Dashboard</a>
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
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/settings">Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo $totalUsers; ?></h4>
                                        <p class="mb-0">Users</p>
                                    </div>
                                    <div>
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo $totalProducts; ?></h4>
                                        <p class="mb-0">Products</p>
                                    </div>
                                    <div>
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo $totalOrders; ?></h4>
                                        <p class="mb-0">Orders</p>
                                    </div>
                                    <div>
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>$<?php echo number_format($totalRevenue, 2); ?></h4>
                                        <p class="mb-0">Revenue</p>
                                    </div>
                                    <div>
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentOrders)): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>User</th>
                                            <th>Product</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentOrders as $order): ?>
                                            <tr>
                                                <td><?php echo e($order['transaction_id']); ?></td>
                                                <td><?php echo e($order['user_name']); ?></td>
                                                <td><?php echo e($order['product_name']); ?></td>
                                                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $order['status'] === 'completed' ? 'success' : ($order['status'] === 'pending' ? 'warning' : 'danger'); ?>">
                                                        <?php echo ucfirst($order['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No recent orders.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Monthly Sales Chart -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Monthly Sales</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Sales chart would be displayed here.</p>
                        <!-- Chart.js or other chart library would be implemented here -->
                        <?php if (!empty($monthlySales)): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Sales</th>
                                            <th>Orders</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($monthlySales as $sale): ?>
                                            <tr>
                                                <td><?php echo date('F', mktime(0, 0, 0, $sale['month'], 1)); ?></td>
                                                <td>$<?php echo number_format($sale['total_sales'], 2); ?></td>
                                                <td><?php echo $sale['total_orders']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No sales data available.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Top Selling Products -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Top Selling Products</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($topSellingProducts)): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Orders</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($topSellingProducts as $product): ?>
                                            <tr>
                                                <td><?php echo e($product['name']); ?></td>
                                                <td><?php echo $product['order_count']; ?></td>
                                                <td>$<?php echo number_format($product['total_revenue'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No top selling products data available.</p>
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