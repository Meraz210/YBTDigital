<?php
// Application Configuration

// Site Information
if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'YBT Digital');
}
if (!defined('SITE_URL')) {
    define('SITE_URL', 'http://localhost/YBTDigital');
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/YBTDigital');
}

// Database Configuration
if (!defined('DB_HOST')) {
    define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
}
if (!defined('DB_USER')) {
    define('DB_USER', getenv('DB_USER') ?: 'root');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', getenv('DB_PASS') ?: '');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', getenv('DB_NAME') ?: 'ybt_digital');
}

// Security
if (!defined('APP_KEY')) {
    define('APP_KEY', getenv('APP_KEY') ?: 'ybtdigital_app_key_here'); // Change this to a random string in production
}
if (!defined('SESSION_LIFETIME')) {
    define('SESSION_LIFETIME', 3600); // 1 hour
}

// File Uploads
if (!defined('MAX_FILE_SIZE')) {
    define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB in bytes
}
if (!defined('ALLOWED_FILE_TYPES')) {
    define('ALLOWED_FILE_TYPES', ['zip', 'rar', 'pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'svg']);
}

// Payment Configuration
if (!defined('CURRENCY')) {
    define('CURRENCY', 'USD');
}
if (!defined('TAX_RATE')) {
    define('TAX_RATE', 0.10); // 10% tax
}

// Paths
if (!defined('UPLOAD_DIR')) {
    define('UPLOAD_DIR', __DIR__ . '/../uploads/');
}
if (!defined('PRODUCTS_DIR')) {
    define('PRODUCTS_DIR', __DIR__ . '/../uploads/products/');
}

// Create directories if they don't exist
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

if (!is_dir(PRODUCTS_DIR)) {
    mkdir(PRODUCTS_DIR, 0755, true);
}

// Session Configuration
if (session_status() == PHP_SESSION_NONE) {
    // Apply session settings before starting a session
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

    // Start session
    session_start();
} else {
    // Session is already active - skip ini_set() calls to avoid warnings
}

// Set default timezone
date_default_timezone_set('UTC');

// Image helper: build fully qualified or absolute URLs and encode spaces
if (!function_exists('build_image_url')) {
    function build_image_url($img) {
        if (empty($img)) {
            return BASE_URL . '/assets/images/placeholder.jpg';
        }
        // Absolute URL
        if (preg_match('#^https?://#i', $img)) {
            return str_replace(' ', '%20', $img);
        }
        // Root-relative path (starts with '/')
        if (strpos($img, '/') === 0) {
            return rtrim(BASE_URL, '/') . $img;
        }
        // If image already contains uploads path, just prepend BASE_URL
        if (strpos($img, 'uploads/') === 0 || strpos($img, 'products/') === 0) {
            return rtrim(BASE_URL, '/') . '/' . $img;
        }
        // If it's just a filename, it's likely in the uploads/products directory
        if (strpos($img, '.') !== false && strpos($img, '/') === false) {
            return rtrim(BASE_URL, '/') . '/uploads/products/' . $img;
        }
        // Otherwise, prepend BASE_URL and encode spaces
        return str_replace(' ', '%20', rtrim(BASE_URL, '/') . '/' . ltrim($img, '/'));
    }
}

// Sanitize output
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

// Redirect helper
if (!function_exists('redirect')) {
    function redirect($path) {
        header("Location: " . BASE_URL . $path);
        exit();
    }
}

// Get current URL
if (!function_exists('current_url')) {
    function current_url() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . 
               "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}