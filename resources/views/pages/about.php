<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">About Us</h1>
    </div>
</div>

<!-- About Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">About YBT Digital</h2>
                        <p class="card-text">YBT Digital is a premier marketplace for high-quality digital products, including web templates, UI kits, graphics, and development tools. We are dedicated to providing creators and developers with the resources they need to bring their projects to life.</p>
                        
                        <h3>Our Mission</h3>
                        <p>Our mission is to empower creators by offering premium digital assets that save time and enhance productivity. We believe in the power of great design and aim to make it accessible to everyone.</p>
                        
                        <h3>Our Values</h3>
                        <ul>
                            <li><strong>Quality:</strong> We curate only the finest digital products that meet our high standards.</li>
                            <li><strong>Innovation:</strong> We continuously seek out cutting-edge solutions and design trends.</li>
                            <li><strong>Customer Focus:</strong> We prioritize our customers' needs and strive to exceed expectations.</li>
                            <li><strong>Integrity:</strong> We maintain transparency and honesty in all our dealings.</li>
                        </ul>
                        
                        <h3>Why Choose Us?</h3>
                        <p>At YBT Digital, we offer:</p>
                        <ul>
                            <li>A carefully curated selection of premium digital products</li>
                            <li>Regular updates with the latest design trends and tools</li>
                            <li>Secure and instant download after purchase</li>
                            <li>Responsive customer support</li>
                            <li>Money-back guarantee on all purchases</li>
                        </ul>
                        
                        <div class="text-center mt-4">
                            <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary">Browse Products</a>
                            <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-outline-primary">Contact Us</a>
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