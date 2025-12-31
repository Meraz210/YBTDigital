<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Our Products</h1>
    </div>
</div>

<!-- Products Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Filters</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?php echo BASE_URL; ?>/products">
                            <div class="mb-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search" value="<?php echo e($_GET['search'] ?? ''); ?>" placeholder="Search products...">
                            </div>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">All Categories</option>
                                    <option value="1" <?php echo ($_GET['category'] ?? '') == '1' ? 'selected' : ''; ?>>Web Templates</option>
                                    <option value="2" <?php echo ($_GET['category'] ?? '') == '2' ? 'selected' : ''; ?>>UI Kits</option>
                                    <option value="3" <?php echo ($_GET['category'] ?? '') == '3' ? 'selected' : ''; ?>>Graphics</option>
                                    <option value="4" <?php echo ($_GET['category'] ?? '') == '4' ? 'selected' : ''; ?>>Tools</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0">
                        Showing <?php echo count($products); ?> of <?php echo $totalProducts; ?> products
                    </p>
                    <div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm">Newest</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm">Popular</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm">Price</button>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 product-card">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?php echo build_image_url($product['image']); ?>" class="card-img-top" alt="<?php echo e($product['name']); ?>" style="height: 200px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?php echo BASE_URL; ?>/assets/images/placeholder.jpg" class="card-img-top" alt="<?php echo e($product['name']); ?>" style="height: 200px; object-fit: cover;">
                                    <?php endif; ?>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo e($product['name']); ?></h5>
                                        <p class="card-text flex-grow-1"><?php echo e(substr($product['description'], 0, 100)); ?>...</p>
                                        
                                        <!-- Rating Display -->
                                        <div class="mb-2">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $product['avg_rating']): ?>
                                                    <i class="fas fa-star text-warning"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star text-warning"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <small class="text-muted">(<?php echo $product['total_reviews']; ?> reviews)</small>
                                        </div>
                                        
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="h5 text-primary">$<?php echo number_format($product['price'], 2); ?></span>
                                                <a href="<?php echo BASE_URL; ?>/products/<?php echo $product['id']; ?>" class="btn btn-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center">No products found matching your criteria.</p>
                        </div>
                    <?php endif; ?>
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
include __DIR__ . '/../layout.php';
?>