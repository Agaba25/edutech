<?php
require_once 'config.php';
require_once 'includes/Database.php';

try {
    $db = Database::getInstance();
    
    // Use the database
    $db->execute("USE educareer_db");
    
    // Check courses table structure
    echo "Courses table structure:\n";
    $columns = $db->fetchAll("DESCRIBE courses");
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
    
    // Check existing courses
    echo "\nExisting courses:\n";
    $courses = $db->fetchAll("SELECT id, name FROM courses ORDER BY id");
    foreach ($courses as $course) {
        echo "- " . $course['id'] . ": " . $course['name'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>