<?php
// Security Helper Functions

class SecurityHelper {
    
    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token
     */
    public static function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Hash password using PHP's password_hash
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verify password using PHP's password_verify
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Sanitize user input
     */
    public static function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeInput'], $input);
        }
        
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $input;
    }
    
    /**
     * Validate email address
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate URL
     */
    public static function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
    
    /**
     * Escape output for XSS prevention
     */
    public static function escapeOutput($output) {
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Generate random string
     */
    public static function generateRandomString($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Rate limiting check
     */
    public static function checkRateLimit($key, $maxRequests = 10, $timeWindow = 300) { // 5 minutes
        $cacheKey = "rate_limit_{$key}";
        
        if (!isset($_SESSION[$cacheKey])) {
            $_SESSION[$cacheKey] = ['count' => 0, 'timestamp' => time()];
        }
        
        $data = $_SESSION[$cacheKey];
        
        if (time() - $data['timestamp'] > $timeWindow) {
            // Reset counter after time window
            $_SESSION[$cacheKey] = ['count' => 1, 'timestamp' => time()];
            return false;
        }
        
        if ($data['count'] >= $maxRequests) {
            return true; // Rate limit exceeded
        }
        
        $_SESSION[$cacheKey]['count']++;
        return false; // Within limit
    }
}