<?php
// Order Model

require_once __DIR__ . '/../../config/database.php';

class Order {
    private $connection;
    
    public function __construct() {
        global $connection;
        $this->connection = $connection;
    }
    
    /**
     * Create a new order
     * @param array $data Order data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->connection->prepare("INSERT INTO orders (user_id, product_id, transaction_id, payment_gateway, amount, tax_amount, total_amount, status, coupon_code, discount_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssddsss", 
            $data['user_id'], 
            $data['product_id'], 
            $data['transaction_id'], 
            $data['payment_gateway'], 
            $data['amount'], 
            $data['tax_amount'], 
            $data['total_amount'], 
            $data['status'], 
            $data['coupon_code'], 
            $data['discount_amount']
        );
        
        return $stmt->execute();
    }
    
    /**
     * Find order by ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->connection->prepare("SELECT o.*, u.name as user_name, u.email as user_email, p.name as product_name, p.file_path as product_file FROM orders o LEFT JOIN users u ON o.user_id = u.id LEFT JOIN products p ON o.product_id = p.id WHERE o.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Find order by transaction ID
     * @param string $transactionId
     * @return array|null
     */
    public function findByTransactionId($transactionId) {
        $stmt = $this->connection->prepare("SELECT o.*, u.name as user_name, u.email as user_email, p.name as product_name, p.file_path as product_file FROM orders o LEFT JOIN users u ON o.user_id = u.id LEFT JOIN products p ON o.product_id = p.id WHERE o.transaction_id = ?");
        $stmt->bind_param("s", $transactionId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get orders by user ID
     * @param int $userId
     * @return array
     */
    public function getByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT o.*, p.name as product_name, p.image as product_image FROM orders o LEFT JOIN products p ON o.product_id = p.id WHERE o.user_id = ? ORDER BY o.created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get all orders with pagination
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll($limit = 10, $offset = 0) {
        $stmt = $this->connection->prepare("SELECT o.*, u.name as user_name, u.email as user_email, p.name as product_name FROM orders o LEFT JOIN users u ON o.user_id = u.id LEFT JOIN products p ON o.product_id = p.id ORDER BY o.created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Update order status
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus($id, $status) {
        $stmt = $this->connection->prepare("UPDATE orders SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Get total count of orders
     * @return int
     */
    public function getTotalCount() {
        $result = $this->connection->query("SELECT COUNT(*) as count FROM orders");
        $row = $result->fetch_assoc();
        
        return $row['count'];
    }
    
    /**
     * Get orders count by status
     * @param string $status
     * @return int
     */
    public function getCountByStatus($status) {
        $stmt = $this->connection->prepare("SELECT COUNT(*) as count FROM orders WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['count'];
    }
    
    /**
     * Get orders for admin dashboard
     * @param int $limit
     * @param int $offset
     * @param string $status
     * @return array
     */
    public function getForAdmin($limit = 10, $offset = 0, $status = null) {
        if ($status) {
            $stmt = $this->connection->prepare("SELECT o.*, u.name as user_name, u.email as user_email, p.name as product_name FROM orders o LEFT JOIN users u ON o.user_id = u.id LEFT JOIN products p ON o.product_id = p.id WHERE o.status = ? ORDER BY o.created_at DESC LIMIT ? OFFSET ?");
            $stmt->bind_param("sii", $status, $limit, $offset);
        } else {
            $stmt = $this->connection->prepare("SELECT o.*, u.name as user_name, u.email as user_email, p.name as product_name FROM orders o LEFT JOIN users u ON o.user_id = u.id LEFT JOIN products p ON o.product_id = p.id ORDER BY o.created_at DESC LIMIT ? OFFSET ?");
            $stmt->bind_param("ii", $limit, $offset);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get sales report for a date range
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getSalesReport($startDate, $endDate) {
        $stmt = $this->connection->prepare("SELECT SUM(total_amount) as total_sales, COUNT(*) as total_orders FROM orders WHERE created_at BETWEEN ? AND ? AND status = 'completed'");
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get monthly sales for the current year
     * @return array
     */
    public function getMonthlySales() {
        $stmt = $this->connection->prepare("SELECT MONTH(created_at) as month, SUM(total_amount) as total_sales, COUNT(*) as total_orders FROM orders WHERE YEAR(created_at) = YEAR(CURDATE()) AND status = 'completed' GROUP BY MONTH(created_at) ORDER BY month");
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get top selling products
     * @param int $limit
     * @return array
     */
    public function getTopSellingProducts($limit = 10) {
        $stmt = $this->connection->prepare("SELECT p.id, p.name, p.image, COUNT(o.id) as order_count, SUM(o.total_amount) as total_revenue FROM products p LEFT JOIN orders o ON p.id = o.product_id WHERE o.status = 'completed' GROUP BY p.id, p.name ORDER BY order_count DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}