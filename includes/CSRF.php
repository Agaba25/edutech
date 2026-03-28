<?php
/**
 * CSRF Protection Class
 * Generates and validates CSRF tokens
 */

class CSRF {
    private static $token_name = 'csrf_token';
    
    // Generate CSRF token
    public static function generateToken() {
        if (!isset($_SESSION[self::$token_name])) {
            $_SESSION[self::$token_name] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::$token_name];
    }
    
    // Get CSRF token
    public static function getToken() {
        return $_SESSION[self::$token_name] ?? null;
    }
    
    // Validate CSRF token
    public static function validateToken($token) {
        if (!isset($_SESSION[self::$token_name])) {
            return false;
        }
        return hash_equals($_SESSION[self::$token_name], $token);
    }
    
    // Generate hidden input field
    public static function getHiddenInput() {
        $token = self::generateToken();
        return '<input type="hidden" name="' . self::$token_name . '" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
    
    // Require valid CSRF token (for POST requests)
    public static function requireValidToken() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST[self::$token_name] ?? '';
            if (!self::validateToken($token)) {
                http_response_code(403);
                die('CSRF token validation failed');
            }
        }
    }
}
?>
