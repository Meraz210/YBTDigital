<?php
// Application Configuration

// Site Information
define('SITE_NAME', 'YBT Digital');
define('SITE_URL', 'http://localhost/YBT%20Digital');
define('SITE_EMAIL', 'support@ybtdigital.com');

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'ybt_digital');

// Security
define('APP_KEY', getenv('APP_KEY') ?: 'ybtdigital_secret_key_2025'); // Change this to a random string in production
define('SESSION_LIFETIME', 3600); // 1 hour

// File Uploads
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB in bytes
define('ALLOWED_FILE_TYPES', ['zip', 'rar', 'pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'gif']);

// Payment Configuration
define('CURRENCY', 'USD');
define('TAX_RATE', 0.10); // 10% tax

// Paths
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('PRODUCTS_DIR', __DIR__ . '/uploads/products/');

// Create directories if they don't exist
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

if (!is_dir(PRODUCTS_DIR)) {
    mkdir(PRODUCTS_DIR, 0755, true);
}

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set default timezone
date_default_timezone_set('UTC');
?>