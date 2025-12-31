<?php
// Simple header partial with active link detection
$current = basename($_SERVER['PHP_SELF']);
?>
<!-- Desktop Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light desktop-nav">
    <div class="container">
        <?php if (!defined('BASE_URL')) define('BASE_URL', '/YBTDigital'); ?>
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">
            <i class="fas fa-store me-2"></i>YBT Digital
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current === 'index.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($current, 'products') !== false ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/products/index.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current === 'about.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current === 'contact.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/contact.php">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/user/login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/user/signup.php"><i class="fas fa-user-plus me-1"></i>Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link theme-toggle" id="themeToggle" href="#"><i class="fas fa-moon me-1"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>