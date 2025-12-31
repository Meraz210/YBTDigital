<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Page Not Found</h1>
    </div>
</div>

<!-- Error Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <i class="fas fa-exclamation-triangle fa-10x text-warning mb-4"></i>
                <h2 class="text-warning">404 - Page Not Found</h2>
                <p class="lead">The page you are looking for does not exist or has been moved.</p>
                <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">Go to Homepage</a>
                <a href="<?php echo BASE_URL; ?>/products" class="btn btn-outline-primary">Browse Products</a>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>