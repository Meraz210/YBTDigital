<?php
// Include the layout
ob_start();
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">Contact Us</h1>
    </div>
</div>

<!-- Contact Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Get In Touch</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                                <h6>Address</h6>
                                <p class="mb-0">123 Digital Street<br>Web City, WC 12345</p>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <i class="fas fa-phone-alt fa-2x text-primary mb-2"></i>
                                <h6>Phone</h6>
                                <p class="mb-0">+1 (555) 123-4567</p>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                <h6>Email</h6>
                                <p class="mb-0">support@ybtdigital.com</p>
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