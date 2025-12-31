<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - YBT Digital</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <link href="assets/css/theme.css" rel="stylesheet">
</head>
<body>
    <?php if (file_exists(__DIR__ . '/partials/header.php')) { include __DIR__ . '/partials/header.php'; } ?>

    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">About YBT Digital</h1>
            <p class="lead">YBT Digital is a trusted provider of premium digital products — templates, UI kits, icons and tools that help businesses and creators ship better products faster.</p>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h3>Our Mission</h3>
                    <p>To empower developers and designers with high-quality, easy-to-integrate digital assets that save time and boost creativity.</p>
                </div>
                <div class="col-md-6">
                    <h3>Our Vision</h3>
                    <p>Become the most reliable marketplace for digital assets by focusing on quality, support and continuous improvement.</p>
                </div>
            </div>

            <hr class="my-4">

            <h3>Meet the Team</h3>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5>Jane Doe</h5>
                        <p class="mb-0 text-muted">Founder &amp; CEO</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5>John Smith</h5>
                        <p class="mb-0 text-muted">Lead Developer</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5>Emily Clark</h5>
                        <p class="mb-0 text-muted">Head of Design</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-light py-5">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> YBT Digital. All rights reserved.</p>
        </div>
    </footer>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>