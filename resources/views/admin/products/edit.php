<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Edit Product</h1>
    </div>
</div>

<!-- Edit Product Section -->
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo BASE_URL; ?>/admin/products/edit/<?php echo $product['id']; ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo e($product['name']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price ($)</label>
                                        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select a category</option>
                                            <option value="1" <?php echo $product['category_id'] == 1 ? 'selected' : ''; ?>>Web Templates</option>
                                            <option value="2" <?php echo $product['category_id'] == 2 ? 'selected' : ''; ?>>UI Kits</option>
                                            <option value="3" <?php echo $product['category_id'] == 3 ? 'selected' : ''; ?>>Graphics</option>
                                            <option value="4" <?php echo $product['category_id'] == 4 ? 'selected' : ''; ?>>Tools</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="draft" <?php echo $product['status'] == 'draft' ? 'selected' : ''; ?>>Draft</option>
                                            <option value="active" <?php echo $product['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                            <option value="inactive" <?php echo $product['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="download_limit" class="form-label">Download Limit</label>
                                        <input type="number" class="form-control" id="download_limit" name="download_limit" value="<?php echo $product['download_limit']; ?>" min="1">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <div class="form-text">Upload a new image (or leave blank to keep current)</div>
                                        <?php if (!empty($product['image'])): ?>
                                            <div class="mt-2">
                                                <img src="<?php echo build_image_url($product['image']); ?>" alt="<?php echo e($product['name']); ?>" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                <small class="text-muted">Current image</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Product File</label>
                                        <input type="file" class="form-control" id="file" name="file">
                                        <div class="form-text">Upload a new file (or leave blank to keep current)</div>
                                        <?php if (!empty($product['file_path'])): ?>
                                            <div class="mt-2">
                                                <small class="text-muted">Current file: <?php echo e(basename($product['file_path'])); ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="screenshots" class="form-label">Screenshots</label>
                                        <input type="file" class="form-control" id="screenshots" name="screenshots[]" multiple accept="image/*">
                                        <div class="form-text">Upload new screenshots (or leave blank to keep current)</div>
                                        <?php if (!empty($product['screenshots'])): ?>
                                            <?php $screenshots = json_decode($product['screenshots'], true); ?>
                                            <?php if (!empty($screenshots)): ?>
                                                <div class="mt-2">
                                                    <small class="text-muted">Current screenshots:</small>
                                                    <div class="row mt-1">
                                                        <?php foreach ($screenshots as $screenshot): ?>
                                                            <div class="col-3">
                                                                <img src="<?php echo build_image_url($screenshot); ?>" alt="Screenshot" class="img-thumbnail" style="width: 100%; height: 60px; object-fit: cover;">
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" required><?php echo e($product['description']); ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <a href="<?php echo BASE_URL; ?>/admin/products" class="btn btn-secondary">Cancel</a>
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