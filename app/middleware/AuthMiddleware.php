<?php
// Authentication Middleware

class AuthMiddleware {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    /**
     * Check if user is authenticated
     */
    public function isAuthenticated() {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        // Optionally verify user still exists in database
        $stmt = $this->connection->prepare("SELECT id FROM users WHERE id = ? AND is_active = 1");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    
    /**
     * Check if user has admin privileges
     */
    public function isAdmin() {
        return $this->isAuthenticated() && 
               isset($_SESSION['role']) && 
               in_array($_SESSION['role'], ['admin', 'super_admin']);
    }
    
    /**
     * Check if user has super admin privileges
     */
    public function isSuperAdmin() {
        return $this->isAuthenticated() && 
               isset($_SESSION['role']) && 
               $_SESSION['role'] === 'super_admin';
    }
    
    /**
     * Redirect to login if not authenticated
     */
    public function requireAuth($redirect = '/user/login') {
        if (!$this->isAuthenticated()) {
            header("Location: " . BASE_URL . $redirect);
            exit();
        }
    }
    
    /**
     * Redirect to login if not admin
     */
    public function requireAdmin($redirect = '/user/login') {
        if (!$this->isAdmin()) {
            header("Location: " . BASE_URL . $redirect);
            exit();
        }
    }
}