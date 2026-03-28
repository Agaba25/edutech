<?php
require_once 'config.php';
require_once 'includes/Database.php';

try {
    $db = Database::getInstance();
    echo "Database connection successful!\n";
    
    // Check if educareer_db exists
    $databases = $db->fetchAll("SHOW DATABASES LIKE 'educareer_db'");
    if (count($databases) > 0) {
        echo "Database 'educareer_db' exists.\n";
        
        // Use the database
        $db->execute("USE educareer_db");
        
        // Show tables
        $tables = $db->fetchAll("SHOW TABLES");
        echo "Tables in database:\n";
        foreach ($tables as $table) {
            echo "- " . reset($table) . "\n";
        }
    } else {
        echo "Database 'educareer_db' does not exist.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>