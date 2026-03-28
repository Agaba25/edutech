<?php
// Test script to verify course finder functionality

require_once 'config.php';
require_once 'includes/Database.php';

Config::load();

echo "<h1>Course Finder Test</h1>";

try {
    $db = Database::getInstance();
    
    // Select the database
    $db->execute("USE `" . Config::get('DB_NAME') . "`");
    
    // Test if we can connect and query the courses table
    echo "<h2>Testing Database Connection...</h2>";
    
    $result = $db->fetchAll("SELECT COUNT(*) as count FROM courses");
    if ($result) {
        $count = $result[0]['count'];
        echo "<p style='color: green;'>✅ Successfully connected to courses table</p>";
        echo "<p>Found {$count} courses in the database</p>";
        
        if ($count > 0) {
            // Get a sample course
            $sampleCourse = $db->fetchOne("SELECT * FROM courses LIMIT 1");
            if ($sampleCourse) {
                echo "<p style='color: green;'>✅ Successfully retrieved course data</p>";
                echo "<p>Sample course: " . $sampleCourse['name'] . "</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠️ Courses table is empty</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Failed to query courses table</p>";
    }
    
    // Test institutions table
    echo "<h2>Testing Institutions Table...</h2>";
    $instResult = $db->fetchAll("SELECT COUNT(*) as count FROM institutions");
    if ($instResult) {
        $instCount = $instResult[0]['count'];
        echo "<p style='color: green;'>✅ Successfully connected to institutions table</p>";
        echo "<p>Found {$instCount} institutions in the database</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to query institutions table</p>";
    }
    
    // Test course_universities table
    echo "<h2>Testing Course-University Associations...</h2>";
    $cuResult = $db->fetchAll("SELECT COUNT(*) as count FROM course_universities");
    if ($cuResult) {
        $cuCount = $cuResult[0]['count'];
        echo "<p style='color: green;'>✅ Successfully connected to course_universities table</p>";
        echo "<p>Found {$cuCount} course-university associations in the database</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to query course_universities table</p>";
    }
    
    echo "<h2>API Endpoint Test</h2>";
    echo "<p>To test the course matching API directly:</p>";
    echo "<ol>";
    echo "<li>Open your browser's developer tools (F12)</li>";
    echo "<li>Go to the Network tab</li>";
    echo "<li>Navigate to <a href='course-finder.php'>course-finder.php</a></li>";
    echo "<li>Fill in the form with sample data and submit</li>";
    echo "<li>Look for the POST request to api/course-matching.php</li>";
    echo "<li>Check the response - it should contain course data, not an error</li>";
    echo "</ol>";
    
    echo "<h2>Next Steps</h2>";
    echo "<p>If all tests above are passing:</p>";
    echo "<ol>";
    echo "<li>Go to <a href='course-finder.php'>Course Finder</a></li>";
    echo "<li>Fill in the form with sample data:</li>";
    echo "<ul>";
    echo "<li>Principal Subject 1: Biology, Grade A</li>";
    echo "<li>Principal Subject 2: Chemistry, Grade A</li>";
    echo "<li>Principal Subject 3: Physics, Grade B</li>";
    echo "<li>General Paper: Pass</li>";
    echo "<li>Subsidiary: Pass</li>";
    echo "<li>Interest: Medicine & Health Sciences</li>";
    echo "</ul>";
    echo "<li>Click 'Find My Courses'</li>";
    echo "<li>You should see course recommendations instead of an error</li>";
    echo "</ol>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>