<?php
/**
 * Authentication Class
 * Handles user login, logout, and session management
 */

class Auth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Check if user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
    }

    // Check if user is admin
    public static function isAdmin() {
        return self::isLoggedIn() && $_SESSION['user_role'] === 'admin';
    }

    // Get current user ID
    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    // Get current user role
    public static function getUserRole() {
        return $_SESSION['user_role'] ?? null;
    }

    // Login user
    public function login($email, $password) {
        $email = trim($email);
        
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Email and password are required'];
        }

        $user = $this->db->fetchOne(
            'SELECT id, name, email, password_hash, role FROM users WHERE email = ?',
            [$email]
        );

        if (!$user) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['login_time'] = time();

        return ['success' => true, 'message' => 'Login successful'];
    }

    // Logout user
    public static function logout() {
        session_destroy();
        return true;
    }

    // Require admin access
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: ' . APP_URL . '/admin/login.php');
            exit;
        }
    }

    // Require login
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . APP_URL . '/admin/login.php');
            exit;
        }
    }

    // Hash password
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    // Verify password
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}
?>