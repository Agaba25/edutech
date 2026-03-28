<?php
// Test script to verify login credentials

require_once 'config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';

// Load configuration
Config::load();

echo "<h1>Login Credential Test</h1>";

try {
    // Get database instance
    $db = Database::getInstance();
    
    // Select the database
    $db->execute("USE `" . Config::get('DB_NAME') . "`");
    
    // Check if admin user exists
    echo "<p>Checking for admin user...</p>";
    $adminUser = $db->fetchOne("SELECT * FROM users WHERE email = ?", ['admin@edutech.local']);
    
    if ($adminUser) {
        echo "<p style='color: green;'>✓ Admin user found:</p>";
        echo "<ul>";
        echo "<li>ID: " . $adminUser['id'] . "</li>";
        echo "<li>Name: " . $adminUser['name'] . "</li>";
        echo "<li>Email: " . $adminUser['email'] . "</li>";
        echo "<li>Role: " . $adminUser['role'] . "</li>";
        echo "</ul>";
        
        // Test password verification
        $testPassword = "admin123";
        if (password_verify($testPassword, $adminUser['password_hash'])) {
            echo "<p style='color: green;'>✓ Password verification successful!</p>";
        } else {
            echo "<p style='color: red;'>✗ Password verification failed!</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Admin user not found!</p>";
    }
    
    echo "<h2>Login Credentials:</h2>";
    echo "<p><strong>Email:</strong> admin@edutech.local</p>";
    echo "<p><strong>Password:</strong> admin123</p>";
    echo "<p><a href='admin/login.php'>Go to Admin Login</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>