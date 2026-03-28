<?php
require_once 'config.php';
require_once 'includes/Database.php';

try {
    $db = Database::getInstance();
    
    // Use the database
    $db->execute("USE educareer_db");
    
    // Check existing courses and their IDs
    echo "Existing courses and their IDs:\n";
    $courses = $db->fetchAll("SELECT id, name FROM courses ORDER BY id");
    foreach ($courses as $course) {
        echo "- ID: " . $course['id'] . ", Name: " . $course['name'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>