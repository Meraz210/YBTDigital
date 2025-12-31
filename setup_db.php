<?php
require_once 'config/config.php';

// Create connection directly
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS);

// Check connection
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Create database if it doesn't exist
$createDbQuery = 'CREATE DATABASE IF NOT EXISTS ' . DB_NAME;
if ($connection->query($createDbQuery) === TRUE) {
    echo 'Database ' . DB_NAME . ' created successfully or already exists' . PHP_EOL;
} else {
    echo 'Error creating database: ' . $connection->error . PHP_EOL;
}

// Select the database
$connection->select_db(DB_NAME);

// Read and execute the schema
$schema = file_get_contents('database/schema.sql');
if ($schema !== false) {
    // Split by semicolons and execute each statement
    $statements = array_filter(array_map('trim', explode(';', $schema)));
    foreach ($statements as $stmt) {
        $stmt = trim($stmt);
        if (!empty($stmt)) {
            if ($connection->query($stmt) === FALSE) {
                echo 'Error executing statement: ' . $connection->error . PHP_EOL;
                echo 'Statement: ' . $stmt . PHP_EOL;
            }
        }
    }
    echo 'Schema imported successfully' . PHP_EOL;
} else {
    echo 'Could not read schema file' . PHP_EOL;
}

// Close connection
$connection->close();
?>