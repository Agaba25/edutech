<?php
require_once 'config.php';
require_once 'includes/Database.php';

try {
    $db = Database::getInstance();
    echo "Database connection successful!\n";
    
    // Use the database
    $db->execute("USE educareer_db");
    
    // Show tables
    $tables = $db->fetchAll("SHOW TABLES");
    echo "Tables in database:\n";
    foreach ($tables as $table) {
        echo "- " . reset($table) . "\n";
    }
    
    // Check institutions table
    echo "\nInstitutions table structure:\n";
    $columns = $db->fetchAll("DESCRIBE institutions");
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
    
    // Check programs table
    echo "\nPrograms table structure:\n";
    $columns = $db->fetchAll("DESCRIBE programs");
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
    
    // Check courses table
    echo "\nCourses table structure:\n";
    $columns = $db->fetchAll("DESCRIBE courses");
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
    
    // Check existing institutions
    echo "\nExisting institutions:\n";
    $institutions = $db->fetchAll("SELECT id, name FROM institutions ORDER BY id");
    foreach ($institutions as $institution) {
        echo "- " . $institution['id'] . ": " . $institution['name'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>