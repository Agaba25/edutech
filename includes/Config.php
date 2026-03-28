<?php
/**
 * Configuration Loader
 * Loads configuration from environment or defaults
 */

class Config {
    private static $config = [];
    
    public static function load() {
        // Default configuration
        self::$config = [
            'APP_NAME' => 'Edu_Career Guide Students Web',
            'APP_URL' => 'http://localhost/edutech',
            'APP_ENV' => 'development',
            'DB_HOST' => 'localhost',
            'DB_USER' => 'root',
            'DB_PASS' => '',
            'DB_NAME' => 'educareer_db',
            'SESSION_TIMEOUT' => 3600,
            'PASSWORD_MIN_LENGTH' => 6,
            'API_RATE_LIMIT' => 100,
            'API_CACHE_TIME' => 300
        ];
        
        // Load from environment variables if available
        foreach (self::$config as $key => $default) {
            $env_value = getenv($key);
            if ($env_value !== false) {
                self::$config[$key] = $env_value;
            }
        }
        
        // Define constants
        foreach (self::$config as $key => $value) {
            if (!defined($key)) {
                define($key, $value);
            }
        }
    }
    
    public static function get($key, $default = null) {
        return self::$config[$key] ?? $default;
    }
    
    public static function isProduction() {
        return self::get('APP_ENV') === 'production';
    }
    
    public static function isDevelopment() {
        return self::get('APP_ENV') === 'development';
    }
}
?>
