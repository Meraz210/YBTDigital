<?php
// Category Model

require_once __DIR__ . '/../../config/database.php';

class Category {
    private $connection;
    
    public function __construct() {
        global $connection;
        $this->connection = $connection;
    }
    
    /**
     * Get all categories
     * @return array
     */
    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Find category by ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Find category by slug
     * @param string $slug
     * @return array|null
     */
    public function findBySlug($slug) {
        $stmt = $this->connection->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Create a new category
     * @param array $data Category data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->connection->prepare("INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['name'], $data['slug'], $data['description']);
        
        return $stmt->execute();
    }
    
    /**
     * Update a category
     * @param int $id Category ID
     * @param array $data Category data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->connection->prepare("UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sssi", $data['name'], $data['slug'], $data['description'], $id);
        
        return $stmt->execute();
    }
    
    /**
     * Delete a category
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Get category count
     * @return int
     */
    public function getTotalCount() {
        $result = $this->connection->query("SELECT COUNT(*) as count FROM categories");
        $row = $result->fetch_assoc();
        
        return $row['count'];
    }
}