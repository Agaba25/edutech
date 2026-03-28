<?php
// Complete setup script for the EduTech application
// This script will create the database, tables, and admin user

require_once 'config.php';
require_once 'includes/Database.php';

// Load configuration
Config::load();

echo "<h1>EduTech Application Setup</h1>";

try {
    // Get database instance
    $db = Database::getInstance();
    
    // Create database if it doesn't exist
    echo "<p>Creating database: " . Config::get('DB_NAME') . "...</p>";
    $db->execute("CREATE DATABASE IF NOT EXISTS `" . Config::get('DB_NAME') . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    
    // Select the database
    echo "<p>Selecting database...</p>";
    $db->execute("USE `" . Config::get('DB_NAME') . "`");
    
    // Create users table
    echo "<p>Creating users table...</p>";
    $db->execute("
        CREATE TABLE IF NOT EXISTS `users` (
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
    
    // Create institutions table
    echo "<p>Creating institutions table...</p>";
    $db->execute("
        CREATE TABLE IF NOT EXISTS `institutions` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `name` VARCHAR(150) NOT NULL,
          `short_description` TEXT,
          `address` VARCHAR(255),
          `region` VARCHAR(100),
          `logo_path` VARCHAR(255),
          `contact_email` VARCHAR(100),
          `phone` VARCHAR(20),
          `website` VARCHAR(255),
          `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          INDEX `idx_region` (`region`),
          INDEX `idx_name` (`name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
    
    // Create programs table
    echo "<p>Creating programs table...</p>";
    $db->execute("
        CREATE TABLE IF NOT EXISTS `programs` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `institution_id` INT NOT NULL,
          `level` ENUM('Certificate', 'Diploma') NOT NULL,
          `name` VARCHAR(150) NOT NULL,
          `duration` VARCHAR(50),
          `fee_estimate` VARCHAR(100),
          `cutoff_info` TEXT COMMENT 'Entry-level cut-off points (sample data - verify with institution)',
          `description` TEXT,
          `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          FOREIGN KEY (`institution_id`) REFERENCES `institutions`(`id`) ON DELETE CASCADE,
          INDEX `idx_institution` (`institution_id`),
          INDEX `idx_level` (`level`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
    
    // Create contact_messages table
    echo "<p>Creating contact_messages table...</p>";
    $db->execute("
        CREATE TABLE IF NOT EXISTS `contact_messages` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `name` VARCHAR(100) NOT NULL,
          `email` VARCHAR(100) NOT NULL,
          `subject` VARCHAR(200),
          `message` TEXT NOT NULL,
          `status` ENUM('new', 'read', 'replied') DEFAULT 'new',
          `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          INDEX `idx_email` (`email`),
          INDEX `idx_status` (`status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
    
    // Create courses table (for course finder)
    echo "<p>Creating courses table...</p>";
    $db->execute("
        CREATE TABLE IF NOT EXISTS `courses` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `name` VARCHAR(255) NOT NULL,
          `description` TEXT,
          `essential_subjects` TEXT COMMENT 'JSON array of required subjects (x3 weight)',
          `relevant_subjects` TEXT COMMENT 'JSON array of relevant subjects (x2 weight)',
          `desirable_subjects` TEXT COMMENT 'JSON array of desirable subjects (x1 weight)',
          `minimum_points` INT DEFAULT 15,
          `duration` VARCHAR(50),
          `career_fields` TEXT COMMENT 'JSON array of career fields',
          `career_opportunities` TEXT COMMENT 'JSON array of career opportunities',
          `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          INDEX `idx_minimum_points` (`minimum_points`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
    
    // Create course_universities table
    echo "<p>Creating course_universities table...</p>";
    $db->execute("
        CREATE TABLE IF NOT EXISTS `course_universities` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `course_id` INT NOT NULL,
          `institution_id` INT NOT NULL,
          `application_link` VARCHAR(255),
          `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
          FOREIGN KEY (`institution_id`) REFERENCES `institutions`(`id`) ON DELETE CASCADE,
          INDEX `idx_course` (`course_id`),
          INDEX `idx_institution` (`institution_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
    
    // Create course_scholarships table
    echo "<p>Creating course_scholarships table...</p>";
    $db->execute("
        CREATE TABLE IF NOT EXISTS `course_scholarships` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `course_id` INT NOT NULL,
          `scholarship_name` VARCHAR(255) NOT NULL,
          `scholarship_link` VARCHAR(255),
          `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
          INDEX `idx_course` (`course_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
    
    // Check if admin user exists
    echo "<p>Checking for admin user...</p>";
    $adminUser = $db->fetchOne("SELECT * FROM users WHERE email = ?", ['admin@edutech.local']);
    
    if (!$adminUser) {
        // Create admin user with password "admin123"
        echo "<p>Creating admin user...</p>";
        $passwordHash = '$2y$10$YIjlrPNoS0E9IeaVrcemCOYvxijrQWXVVmMvqIYeNLsN8/LewKope';
        $db->execute(
            "INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)",
            ['Admin User', 'admin@edutech.local', $passwordHash, 'admin']
        );
        echo "<p>Admin user created successfully!</p>";
    } else {
        echo "<p>Admin user already exists.</p>";
    }
    
    // Insert sample institutions if none exist
    echo "<p>Checking for sample institutions...</p>";
    $institutions = $db->fetchAll("SELECT COUNT(*) as count FROM institutions");
    if ($institutions[0]['count'] == 0) {
        echo "<p>Inserting sample institutions...</p>";
        $db->execute("
            INSERT INTO `institutions` (`name`, `short_description`, `address`, `region`, `contact_email`, `phone`, `website`) VALUES
            ('Kampala International University (KIU)', 'Leading private university offering diverse academic programs', 'Kansanga, Kampala', 'Central', 'admissions@kiu.ac.ug', '+256-414-267-100', 'www.kiu.ac.ug'),
            ('Makerere University Business School (MUBS)', 'Premier business education institution', 'Kampala', 'Central', 'admissions@mubs.ac.ug', '+256-414-531-000', 'www.mubs.ac.ug'),
            ('Kyambogo University', 'Public university specializing in education and technology', 'Kyambogo, Kampala', 'Central', 'admissions@kyambogo.ac.ug', '+256-414-286-000', 'www.kyambogo.ac.ug')
        ");
        echo "<p>Sample institutions inserted successfully!</p>";
    } else {
        echo "<p>Sample institutions already exist.</p>";
    }
    
    // Insert sample programs if none exist
    echo "<p>Checking for sample programs...</p>";
    $programs = $db->fetchAll("SELECT COUNT(*) as count FROM programs");
    if ($programs[0]['count'] == 0) {
        echo "<p>Inserting sample programs...</p>";
        $db->execute("
            INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
            (1, 'Certificate', 'Certificate in Information Technology', '1 year', '2,500,000 UGX', 'Minimum: 5 O-levels (Grade 5 or better)', 'Foundational IT skills including hardware, software, and basic networking'),
            (1, 'Diploma', 'Diploma in Computer Science', '2 years', '5,000,000 UGX', 'Minimum: 2 A-levels or equivalent', 'Advanced programming, database design, and software development'),
            (2, 'Diploma', 'Diploma in Accounting', '2 years', '6,000,000 UGX', 'Minimum: 2 A-levels (including Math)', 'Professional accounting standards, financial reporting, and auditing')
        ");
        echo "<p>Sample programs inserted successfully!</p>";
    } else {
        echo "<p>Sample programs already exist.</p>";
    }
    
    // Insert sample courses if none exist
    echo "<p>Checking for sample courses...</p>";
    $courses = $db->fetchAll("SELECT COUNT(*) as count FROM courses");
    if ($courses[0]['count'] == 0) {
        echo "<p>Inserting sample courses...</p>";
        $db->execute("
            INSERT INTO `courses` (`name`, `description`, `essential_subjects`, `relevant_subjects`, `desirable_subjects`, `minimum_points`, `duration`, `career_fields`, `career_opportunities`) VALUES
            ('Bachelor of Medicine and Surgery', 'A comprehensive 5-year medical program providing theoretical knowledge and clinical training. Graduates are equipped to diagnose, treat, and prevent diseases, becoming licensed medical doctors.', '[\"Biology\", \"Chemistry\"]', '[\"Mathematics\", \"Physics\"]', '[\"General Paper\", \"Sub Maths\", \"Computer Studies\"]', 45, '5 years', '[\"Medicine & Health Sciences\"]', '[\"Medical Doctor\", \"Surgeon\", \"Medical Researcher\", \"Public Health Officer\", \"Hospital Administrator\"]'),
            ('Bachelor of Computer Science', 'A 3-year program focusing on software development, algorithms, data structures, and computer systems. Prepares students for careers in technology and software engineering.', '[\"Mathematics\"]', '[\"Physics\", \"Economics\", \"Chemistry\", \"Biology\"]', '[\"General Paper\", \"Computer Studies\"]', 40, '3 years', '[\"Computing & IT\", \"Science & Technology\"]', '[\"Software Developer\", \"Data Analyst\", \"Systems Administrator\", \"IT Consultant\", \"App Developer\"]'),
            ('Bachelor of Science in Electrical Engineering', 'A 4-year engineering program covering electrical systems, power generation, electronics, and telecommunications. Combines theoretical knowledge with practical applications.', '[\"Mathematics\", \"Physics\"]', '[\"Economics\", \"Chemistry\", \"Geography\"]', '[\"General Paper\", \"Computer Studies\"]', 42, '4 years', '[\"Engineering\", \"Science & Technology\"]', '[\"Electrical Engineer\", \"Power Systems Engineer\", \"Telecommunications Engineer\", \"Electronics Engineer\", \"Project Manager\"]')
        ");
        echo "<p>Sample courses inserted successfully!</p>";
        
        // Insert course-university associations
        echo "<p>Inserting course-university associations...</p>";
        $db->execute("
            INSERT INTO `course_universities` (`course_id`, `institution_id`, `application_link`) VALUES
            (1, 1, 'https://mak.ac.ug/admissions'),
            (2, 1, 'https://mak.ac.ug/admissions'),
            (3, 1, 'https://mak.ac.ug/admissions')
        ");
        echo "<p>Course-university associations inserted successfully!</p>";
    } else {
        echo "<p>Sample courses already exist.</p>";
    }
    
    echo "<h2>Setup completed successfully!</h2>";
    echo "<p>You can now login to the admin panel with the following credentials:</p>";
    echo "<p><strong>Email:</strong> admin@edutech.local</p>";
    echo "<p><strong>Password:</strong> admin123</p>";
    echo "<p><a href='admin/login.php'>Go to Admin Login</a></p>";
    echo "<p><a href='course-finder.php'>Test Course Finder</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>