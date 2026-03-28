<?php
/**
 * EduTech Configuration File
 * Database and application settings
 */

// Load configuration
require_once __DIR__ . '/includes/Config.php';
Config::load();

// Error Reporting (disable in production)
if (Config::isDevelopment()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    // Configure secure session settings
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Lax');
    
    session_start();
}

// Include required class files
require_once __DIR__ . '/includes/Institution.php';
require_once __DIR__ . '/includes/Program.php';
require_once __DIR__ . '/includes/Contact.php';
require_once __DIR__ . '/includes/Auth.php';
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Sanitizer.php';
require_once __DIR__ . '/includes/CSRF.php';
require_once __DIR__ . '/includes/course.php';
require_once __DIR__ . '/includes/scholarship.php';
?>
