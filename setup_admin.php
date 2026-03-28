<?php
// Script to ensure the database and admin user are properly set up

require_once 'config.php';
require_once 'includes/Database.php';

// Load configuration
Config::load();

try {
    // Get database instance
    $db = Database::getInstance();
    
    // Select the database
    $db->execute("USE `" . Config::get('DB_NAME') . "`");
    
    // Check if users table exists
    $tables = $db->fetchAll("SHOW TABLES LIKE 'users'");
    
    if (empty($tables)) {
        // Create users table
        $db->execute("
            CREATE TABLE `users` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `name` VARCHAR(100) NOT NULL,
              `email` VARCHAR(100) UNIQUE NOT NULL,
              `password_hash` VARCHAR(255) NOT NULL,
              `role` ENUM('admin', 'user') DEFAULT 'user',
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              INDEX `idx_email` (`email`),
              INDEX `idx_role` (`role`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");
    }
    
    // Check if admin user exists
    $adminUser = $db->fetchOne("SELECT * FROM users WHERE email = ?", ['admin@edutech.local']);
    
    if (!$adminUser) {
        // Create admin user with password "admin123"
        $passwordHash = '$2y$10$YIjlrPNoS0E9IeaVrcemCOYvxijrQWXVVmMvqIYeNLsN8/LewKope';
        $db->execute(
            "INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)",
            ['Admin User', 'admin@edutech.local', $passwordHash, 'admin']
        );
    }
    
    echo "Setup completed successfully!";
    echo "<br>Login credentials:";
    echo "<br>Email: admin@edutech.local";
    echo "<br>Password: admin123";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>