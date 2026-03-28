<?php
require_once 'config.php';
require_once 'includes/Database.php';

try {
    $db = Database::getInstance();
    
    // Use the database
    $db->execute("USE educareer_db");
    
    // Check existing institutions and their IDs
    echo "Existing institutions and their IDs:\n";
    $institutions = $db->fetchAll("SELECT id, name FROM institutions ORDER BY id");
    foreach ($institutions as $institution) {
        echo "- ID: " . $institution['id'] . ", Name: " . $institution['name'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>