<?php
// Coupon Model

require_once __DIR__ . '/../../config/database.php';

class Coupon {
    private $connection;
    
    public function __construct() {
        global $connection;
        $this->connection = $connection;
    }
    
    /**
     * Create a new coupon
     * @param array $data Coupon data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->connection->prepare("INSERT INTO coupons (code, type, value, min_amount, usage_limit, expires_at, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdidds", 
            $data['code'], 
            $data['type'], 
            $data['value'], 
            $data['min_amount'], 
            $data['usage_limit'], 
            $data['expires_at'], 
            $data['is_active']
        );
        
        return $stmt->execute();
    }
    
    /**
     * Find coupon by code
     * @param string $code
     * @return array|null
     */
    public function findByCode($code) {
        $stmt = $this->connection->prepare("SELECT * FROM coupons WHERE code = ? AND is_active = 1 AND (expires_at IS NULL OR expires_at > NOW()) AND (usage_limit IS NULL OR used_count < usage_limit) LIMIT 1");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Update coupon usage count
     * @param string $code
     * @return bool
     */
    public function incrementUsage($code) {
        $stmt = $this->connection->prepare("UPDATE coupons SET used_count = used_count + 1, updated_at = CURRENT_TIMESTAMP WHERE code = ?");
        $stmt->bind_param("s", $code);
        
        return $stmt->execute();
    }
    
    /**
     * Get all coupons with pagination
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll($limit = 10, $offset = 0) {
        $stmt = $this->connection->prepare("SELECT * FROM coupons ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get coupon by ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM coupons WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Update a coupon
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->connection->prepare("UPDATE coupons SET code = ?, type = ?, value = ?, min_amount = ?, usage_limit = ?, expires_at = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->bind_param("ssdiddii", 
            $data['code'], 
            $data['type'], 
            $data['value'], 
            $data['min_amount'], 
            $data['usage_limit'], 
            $data['expires_at'], 
            $data['is_active'], 
            $id
        );
        
        return $stmt->execute();
    }
    
    /**
     * Delete a coupon
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM coupons WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Get total count of coupons
     * @return int
     */
    public function getTotalCount() {
        $result = $this->connection->query("SELECT COUNT(*) as count FROM coupons");
        $row = $result->fetch_assoc();
        
        return $row['count'];
    }
    
    /**
     * Validate a coupon code for usage
     * @param string $code
     * @param float $orderAmount
     * @return array
     */
    public function validateForUsage($code, $orderAmount) {
        $coupon = $this->findByCode($code);
        
        if (!$coupon) {
            return [
                'valid' => false,
                'message' => 'Invalid or expired coupon code'
            ];
        }
        
        if ($coupon['min_amount'] > $orderAmount) {
            return [
                'valid' => false,
                'message' => 'Order amount is less than required minimum amount for this coupon'
            ];
        }
        
        return [
            'valid' => true,
            'coupon' => $coupon
        ];
    }
    
    /**
     * Calculate discount amount
     * @param array $coupon
     * @param float $orderAmount
     * @return float
     */
    public function calculateDiscount($coupon, $orderAmount) {
        if ($coupon['type'] === 'percentage') {
            return min(($coupon['value'] / 100) * $orderAmount, $orderAmount);
        } else { // fixed
            return min($coupon['value'], $orderAmount);
        }
    }
}