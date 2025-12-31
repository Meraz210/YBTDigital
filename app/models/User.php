<?php
// User Model

require_once __DIR__ . '/../../config/database.php';

class User {
    private $connection;
    
    public function __construct() {
        global $connection;
        $this->connection = $connection;
    }
    
    /**
     * Create a new user
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $email_verification_token
     * @return bool
     */
    public function create($name, $email, $password, $email_verification_token = null) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->connection->prepare("INSERT INTO users (name, email, password, email_verification_token) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $email_verification_token);
        
        return $stmt->execute();
    }
    
    /**
     * Find user by ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->connection->prepare("SELECT id, name, email, role, is_active, email_verified FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Find user by email
     * @param string $email
     * @return array|null
     */
    public function findByEmail($email) {
        $stmt = $this->connection->prepare("SELECT id, name, email, password, role, is_active, email_verified FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Verify user password
     * @param string $email
     * @param string $password
     * @return array|bool User data if valid, false otherwise
     */
    public function verifyCredentials($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Remove password from result
            return $user;
        }
        
        return false;
    }
    
    /**
     * Update user profile
     * @param int $id
     * @param string $name
     * @param string $email
     * @return bool
     */
    public function updateProfile($id, $name, $email) {
        $stmt = $this->connection->prepare("UPDATE users SET name = ?, email = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Update user password
     * @param int $id
     * @param string $new_password
     * @return bool
     */
    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $stmt = $this->connection->prepare("UPDATE users SET password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Verify user email
     * @param string $token
     * @return bool
     */
    public function verifyEmail($token) {
        $stmt = $this->connection->prepare("UPDATE users SET email_verified = 1, email_verification_token = NULL WHERE email_verification_token = ?");
        $stmt->bind_param("s", $token);
        
        return $stmt->execute();
    }
    
    /**
     * Set password reset token
     * @param string $email
     * @param string $token
     * @param string $expires
     * @return bool
     */
    public function setPasswordResetToken($email, $token, $expires) {
        $stmt = $this->connection->prepare("UPDATE users SET reset_password_token = ?, reset_password_expires = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expires, $email);
        
        return $stmt->execute();
    }
    
    /**
     * Reset password using token
     * @param string $token
     * @param string $new_password
     * @return bool
     */
    public function resetPassword($token, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $stmt = $this->connection->prepare("UPDATE users SET password = ?, reset_password_token = NULL, reset_password_expires = NULL WHERE reset_password_token = ? AND reset_password_expires > NOW()");
        $stmt->bind_param("ss", $hashed_password, $token);
        
        return $stmt->execute();
    }
    
    /**
     * Get all users (for admin panel)
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll($limit = 10, $offset = 0) {
        $stmt = $this->connection->prepare("SELECT id, name, email, role, is_active, email_verified, created_at FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get total count of users
     * @return int
     */
    public function getTotalCount() {
        $result = $this->connection->query("SELECT COUNT(*) as count FROM users");
        $row = $result->fetch_assoc();
        
        return $row['count'];
    }
    
    /**
     * Toggle user active status
     * @param int $id
     * @param bool $status
     * @return bool
     */
    public function toggleActiveStatus($id, $status) {
        $stmt = $this->connection->prepare("UPDATE users SET is_active = ? WHERE id = ?");
        $status = (int)$status;
        $stmt->bind_param("ii", $status, $id);
        
        return $stmt->execute();
    }
}