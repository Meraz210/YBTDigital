<?php
// Product Model

require_once __DIR__ . '/../../config/database.php';

class Product {
    private $connection;
    
    public function __construct() {
        global $connection;
        $this->connection = $connection;
    }
    
    /**
     * Create a new product
     * @param array $data Product data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->connection->prepare("INSERT INTO products (name, description, price, category_id, image, screenshots, file_path, download_limit, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $screenshots_json = json_encode($data['screenshots'] ?? []);
        $stmt->bind_param("ssdissisi", 
            $data['name'], 
            $data['description'], 
            $data['price'], 
            $data['category_id'], 
            $data['image'], 
            $screenshots_json, 
            $data['file_path'], 
            $data['download_limit'], 
            $data['status']
        );
        
        return $stmt->execute();
    }
    
    /**
     * Update a product
     * @param int $id Product ID
     * @param array $data Product data
     * @return bool
     */
    public function update($id, $data) {
        if (isset($data['screenshots'])) {
            $screenshots_json = json_encode($data['screenshots']);
            $stmt = $this->connection->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, image = ?, screenshots = ?, file_path = ?, download_limit = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->bind_param("ssdissisii", 
                $data['name'], 
                $data['description'], 
                $data['price'], 
                $data['category_id'], 
                $data['image'], 
                $screenshots_json, 
                $data['file_path'], 
                $data['download_limit'], 
                $data['status'], 
                $id
            );
        } else {
            $stmt = $this->connection->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, image = ?, file_path = ?, download_limit = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->bind_param("ssdisiiii", 
                $data['name'], 
                $data['description'], 
                $data['price'], 
                $data['category_id'], 
                $data['image'], 
                $data['file_path'], 
                $data['download_limit'], 
                $data['status'], 
                $id
            );
        }
        
        return $stmt->execute();
    }
    
    /**
     * Find product by ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->connection->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get all products with pagination
     * @param int $limit
     * @param int $offset
     * @param string $status
     * @return array
     */
    public function getAll($limit = 10, $offset = 0, $status = 'active') {
        $stmt = $this->connection->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.status = ? ORDER BY p.created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("sii", $status, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get all active products
     * @return array
     */
    public function getAllActive() {
        $stmt = $this->connection->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.status = 'active' ORDER BY p.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get products by category
     * @param int $categoryId
     * @return array
     */
    public function getByCategory($categoryId) {
        $stmt = $this->connection->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = ? AND p.status = 'active' ORDER BY p.created_at DESC");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get products by search term
     * @param string $search
     * @return array
     */
    public function search($search) {
        $searchTerm = "%$search%";
        $stmt = $this->connection->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE (p.name LIKE ? OR p.description LIKE ?) AND p.status = 'active' ORDER BY p.created_at DESC");
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get total count of products
     * @param string $status
     * @return int
     */
    public function getTotalCount($status = 'active') {
        if ($status === 'all') {
            $result = $this->connection->query("SELECT COUNT(*) as count FROM products");
        } else {
            $stmt = $this->connection->prepare("SELECT COUNT(*) as count FROM products WHERE status = ?");
            $stmt->bind_param("s", $status);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        $row = $result->fetch_assoc();
        
        return $row['count'];
    }
    
    /**
     * Delete a product
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Get related products
     * @param int $categoryId
     * @param int $currentProductId
     * @param int $limit
     * @return array
     */
    public function getRelatedProducts($categoryId, $currentProductId, $limit = 4) {
        $stmt = $this->connection->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = ? AND p.id != ? AND p.status = 'active' ORDER BY p.created_at DESC LIMIT ?");
        $stmt->bind_param("iii", $categoryId, $currentProductId, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get products with filters
     * @param array $filters
     * @return array
     */
    public function getWithFilters($filters = []) {
        $whereClauses = ["p.status = 'active'"];
        $params = [];
        $types = "";
        
        if (!empty($filters['category_id'])) {
            $whereClauses[] = "p.category_id = ?";
            $params[] = $filters['category_id'];
            $types .= "i";
        }
        
        if (!empty($filters['min_price'])) {
            $whereClauses[] = "p.price >= ?";
            $params[] = $filters['min_price'];
            $types .= "d";
        }
        
        if (!empty($filters['max_price'])) {
            $whereClauses[] = "p.price <= ?";
            $params[] = $filters['max_price'];
            $types .= "d";
        }
        
        $whereClause = implode(" AND ", $whereClauses);
        $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE $whereClause ORDER BY p.created_at DESC";
        
        $stmt = $this->connection->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get popular products (based on number of orders)
     * @param int $limit
     * @return array
     */
    public function getPopular($limit = 4) {
        $stmt = $this->connection->prepare("SELECT p.*, c.name as category_name, COUNT(o.id) as order_count FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            LEFT JOIN orders o ON p.id = o.product_id 
            WHERE p.status = 'active' 
            GROUP BY p.id 
            ORDER BY order_count DESC, p.created_at DESC 
            LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}