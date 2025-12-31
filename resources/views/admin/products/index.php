<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Manage Products</h1>
    </div>
</div>

<!-- Products Section -->
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
                                <a class="nav-link active" href="<?php echo BASE_URL; ?>/admin/products">Products</a>
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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="<?php echo BASE_URL; ?>/admin/products/add" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                    
                    <div>
                        Showing <?php echo $currentPage; ?> of <?php echo $totalPages; ?> pages
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo $product['id']; ?></td>
                                        <td>
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="<?php echo build_image_url($product['image']); ?>" alt="<?php echo e($product['name']); ?>" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <img src="<?php echo BASE_URL; ?>/assets/images/placeholder.jpg" alt="<?php echo e($product['name']); ?>" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($product['name']); ?></td>
                                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                                        <td><?php echo e($product['category_name']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $product['status'] === 'active' ? 'success' : ($product['status'] === 'inactive' ? 'secondary' : 'warning'); ?>">
                                                <?php echo ucfirst($product['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/admin/products/edit/<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/admin/products/delete/<?php echo $product['id']; ?>" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No products found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Products pagination">
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