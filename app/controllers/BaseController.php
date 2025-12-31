<?php
// Base Controller - All controllers should extend this class

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../helpers/SecurityHelper.php';

class BaseController {
    
    protected $connection;
    protected $auth;
    
    public function __construct() {
        global $connection;
        $this->connection = $connection;
        $this->auth = new AuthMiddleware($this->connection);
    }
    
    /**
     * Render a view file
     * @param string $view The view file name (without .php extension)
     * @param array $data Data to pass to the view
     */
    protected function view($view, $data = []) {
        $viewPath = __DIR__ . "/../../resources/views/{$view}.php";
        
        if (file_exists($viewPath)) {
            extract($data);
            include $viewPath;
        } else {
            throw new Exception("View file does not exist: {$viewPath}");
        }
    }
    
    /**
     * Redirect to a specific route
     * @param string $path The path to redirect to
     */
    protected function redirect($path) {
        header("Location: " . BASE_URL . $path);
        exit();
    }
    
    /**
     * Check if user is logged in
     * @return bool
     */
    protected function isLoggedIn() {
        return $this->auth->isAuthenticated();
    }
    
    /**
     * Check if user is admin
     * @return bool
     */
    protected function isAdmin() {
        return $this->auth->isAdmin();
    }
    
    /**
     * Check if user is super admin
     * @return bool
     */
    protected function isSuperAdmin() {
        return $this->auth->isSuperAdmin();
    }
    
    /**
     * Get current user ID
     * @return int|null
     */
    protected function getCurrentUserId() {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }
    
    /**
     * Sanitize input data
     * @param string $data
     * @return string
     */
    protected function sanitize($data) {
        return SecurityHelper::sanitizeInput($data);
    }
    
    /**
     * Validate email
     * @param string $email
     * @return bool
     */
    protected function validateEmail($email) {
        return SecurityHelper::validateEmail($email);
    }
    
    /**
     * Generate a random string
     * @param int $length
     * @return string
     */
    protected function generateRandomString($length = 32) {
        return SecurityHelper::generateRandomString($length);
    }
    
    /**
     * Set flash message
     * @param string $type Type of message (success, error, info, warning)
     * @param string $message The message content
     */
    protected function setFlashMessage($type, $message) {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    /**
     * Get and clear flash message
     * @return array|null
     */
    protected function getFlashMessage() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }
    
    /**
     * Generate CSRF token
     * @return string
     */
    protected function generateCSRFToken() {
        return SecurityHelper::generateCSRFToken();
    }
    
    /**
     * Validate CSRF token
     * @param string $token
     * @return bool
     */
    protected function validateCSRFToken($token) {
        return SecurityHelper::validateCSRFToken($token);
    }
    
    /**
     * Get current user data
     * @return array|null
     */
    protected function getCurrentUser() {
        if ($this->isLoggedIn()) {
            $stmt = $this->connection->prepare("SELECT id, name, email, role, is_active, email_verified FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }
}