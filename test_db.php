<?php
// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load configuration
require_once 'config.php';

echo "Testing database connection...\n";

try {
    echo "Configuration loaded successfully\n";
    echo "DB Host: " . Config::get('DB_HOST') . "\n";
    echo "DB User: " . Config::get('DB_USER') . "\n";
    echo "DB Name: " . Config::get('DB_NAME') . "\n";
    
    $db = Database::getInstance();
    echo "Database connection successful!\n";
    
    // Check if the users table exists
    $result = $db->fetchAll("SHOW TABLES LIKE 'users'");
    if ($result) {
        echo "Users table exists\n";
        
        // Check if the admin user exists
        $users = $db->fetchAll("SELECT * FROM users");
        if ($users) {
            echo "Found " . count($users) . " users in the database:\n";
            foreach ($users as $user) {
                echo "- ID: " . $user['id'] . ", Email: " . $user['email'] . ", Role: " . $user['role'] . "\n";
            }
        } else {
            echo "No users found in the database.\n";
        }
    } else {
        echo "Users table does not exist\n";
        
        // Check all tables
        echo "Checking all tables:\n";
        $tables = $db->fetchAll("SHOW TABLES");
        foreach ($tables as $table) {
            print_r($table);
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>