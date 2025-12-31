<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Server Error</h1>
    </div>
</div>

<!-- Error Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <i class="fas fa-exclamation-circle fa-10x text-danger mb-4"></i>
                <h2 class="text-danger">500 - Internal Server Error</h2>
                <p class="lead">Something went wrong on our end. Please try again later.</p>
                <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">Go to Homepage</a>
                <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-outline-primary">Contact Support</a>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>