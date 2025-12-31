<?php
// Database Connection Configuration

require_once __DIR__ . '/config.php';

class Database {
    private static $instance = null;
    public $connection;

    private function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        
        // Set charset to prevent SQL injection
        $this->connection->set_charset("utf8");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserialization
    public function __wakeup() {}
}

// Create global connection instance
$database = Database::getInstance();
$connection = $database->connection;