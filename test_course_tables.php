<?php
// Test script to check if course tables exist and have data

require_once 'config.php';
require_once 'includes/Database.php';

Config::load();

echo "<h1>Course Tables Test</h1>";

try {
    $db = Database::getInstance();
    
    // Select the database
    $db->execute("USE `" . Config::get('DB_NAME') . "`");
    
    // Check if courses table exists
    echo "<h2>Checking courses table...</h2>";
    $courses = $db->fetchAll("SHOW TABLES LIKE 'courses'");
    
    if (empty($courses)) {
        echo "<p style='color: red;'>❌ courses table does not exist!</p>";
    } else {
        echo "<p style='color: green;'>✅ courses table exists</p>";
        
        // Check if courses table has data
        $courseCount = $db->fetchAll("SELECT COUNT(*) as count FROM courses");
        if ($courseCount[0]['count'] > 0) {
            echo "<p style='color: green;'>✅ courses table has " . $courseCount[0]['count'] . " records</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ courses table is empty</p>";
        }
    }
    
    // Check if course_universities table exists
    echo "<h2>Checking course_universities table...</h2>";
    $courseUniversities = $db->fetchAll("SHOW TABLES LIKE 'course_universities'");
    
    if (empty($courseUniversities)) {
        echo "<p style='color: red;'>❌ course_universities table does not exist!</p>";
    } else {
        echo "<p style='color: green;'>✅ course_universities table exists</p>";
        
        // Check if course_universities table has data
        $cuCount = $db->fetchAll("SELECT COUNT(*) as count FROM course_universities");
        if ($cuCount[0]['count'] > 0) {
            echo "<p style='color: green;'>✅ course_universities table has " . $cuCount[0]['count'] . " records</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ course_universities table is empty</p>";
        }
    }
    
    // Check if institutions table exists
    echo "<h2>Checking institutions table...</h2>";
    $institutions = $db->fetchAll("SHOW TABLES LIKE 'institutions'");
    
    if (empty($institutions)) {
        echo "<p style='color: red;'>❌ institutions table does not exist!</p>";
    } else {
        echo "<p style='color: green;'>✅ institutions table exists</p>";
        
        // Check if institutions table has data
        $instCount = $db->fetchAll("SELECT COUNT(*) as count FROM institutions");
        if ($instCount[0]['count'] > 0) {
            echo "<p style='color: green;'>✅ institutions table has " . $instCount[0]['count'] . " records</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ institutions table is empty</p>";
        }
    }
    
    echo "<h2>Suggested Solution:</h2>";
    echo "<p>To fix the course finder error, you need to import the course database structure:</p>";
    echo "<ol>";
    echo "<li>Open phpMyAdmin at <a href='http://localhost/phpmyadmin'>http://localhost/phpmyadmin</a></li>";
    echo "<li>Select the '" . Config::get('DB_NAME') . "' database</li>";
    echo "<li>Click 'Import' tab</li>";
    echo "<li>Browse and select the 'database_courses_enhanced.sql' file from your project folder</li>";
    echo "<li>Click 'Go' to import</li>";
    echo "</ol>";
    echo "<p>Alternatively, you can run the complete setup script at <a href='complete_setup.php'>complete_setup.php</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>