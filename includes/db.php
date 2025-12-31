<?php
<<<<<<< HEAD
// Database Configuration
require_once '../config/config.php';
=======
require_once __DIR__ . '/../config.php';
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d

// Create connection
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
<<<<<<< HEAD
=======

// Set charset to utf8
$connection->set_charset("utf8");
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
?>