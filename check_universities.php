<?php
require_once 'config.php';
require_once 'includes/Database.php';

try {
    $db = Database::getInstance();
    
    // Use the database
    $db->execute("USE educareer_db");
    
    // Check existing institutions
    echo "Existing institutions:\n";
    $institutions = $db->fetchAll("SELECT id, name, short_name FROM institutions ORDER BY id");
    foreach ($institutions as $institution) {
        echo "- " . $institution['id'] . ": " . $institution['name'] . " (" . $institution['short_name'] . ")\n";
    }
    
    // Check if specific universities exist
    $missing_universities = [
        'Gulu University',
        'Busitema University', 
        'Muni University',
        'Kabale University',
        'Lira University',
        'Soroti University',
        'Mountains of the Moon University'
    ];
    
    echo "\nChecking for missing universities:\n";
    foreach ($missing_universities as $uni_name) {
        $exists = $db->fetchOne("SELECT id FROM institutions WHERE name = ?", [$uni_name]);
        if ($exists) {
            echo "- ✓ $uni_name (exists)\n";
        } else {
            echo "- ✗ $uni_name (missing)\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>