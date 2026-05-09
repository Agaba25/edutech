<?php
/**
 * Configuration loader: optional .env file, getenv(), sensible defaults.
 */

class Config {
    private static $config = [];

    /**
     * Load key=value pairs from a .env file (no external dependency).
     * Does not override variables already present in the environment.
     */
    private static function loadEnvFile($path) {
        if (!is_readable($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }
            if (strpos($line, '=') === false) {
                continue;
            }
            [$name, $value] = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            if ($name === '') {
                continue;
            }
            if (
                (strlen($value) >= 2 && $value[0] === '"' && substr($value, -1) === '"')
                || (strlen($value) >= 2 && $value[0] === "'" && substr($value, -1) === "'")
            ) {
                $value = substr($value, 1, -1);
            }
            if (getenv($name) === false) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
            }
        }
    }

    private static function envString($key, $default) {
        $v = getenv($key);
        if ($v === false || $v === '') {
            return $default;
        }
        return $v;
    }

    /**
     * Detect public base URL when APP_URL is not set (web requests only).
     */
    private static function detectAppUrl() {
        if (PHP_SAPI === 'cli' || empty($_SERVER['HTTP_HOST'])) {
            return 'http://localhost/edutech';
        }
        $https = false;
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            $https = true;
        }
        if (($proto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') !== '') {
            $https = strtolower($proto) === 'https';
        }
        $scheme = $https ? 'https' : 'http';
        $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        $scriptDir = str_replace('\\', '/', $scriptDir);
        $scriptDir = rtrim($scriptDir, '/');
        if ($scriptDir === '' || $scriptDir === '.') {
            return $scheme . '://' . $_SERVER['HTTP_HOST'];
        }
        return $scheme . '://' . $_SERVER['HTTP_HOST'] . $scriptDir;
    }

    public static function load() {
        $root = dirname(__DIR__);
        self::loadEnvFile($root . DIRECTORY_SEPARATOR . '.env');

        $defaultUrl = self::detectAppUrl();

        self::$config = [
            'APP_NAME' => 'Edu_Career Guide Students Web',
            'APP_URL' => $defaultUrl,
            'APP_ENV' => 'development',
            'DB_HOST' => 'localhost',
            'DB_PORT' => '3306',
            'DB_USER' => 'root',
            'DB_PASS' => '',
            'DB_NAME' => 'educareer_db',
            'SESSION_TIMEOUT' => 3600,
            'PASSWORD_MIN_LENGTH' => 6,
            'API_RATE_LIMIT' => 100,
            'API_CACHE_TIME' => 300,
        ];

        foreach (array_keys(self::$config) as $key) {
            $envVal = getenv($key);
            if ($envVal !== false && $envVal !== '') {
                self::$config[$key] = $envVal;
            }
        }

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
        return strtolower((string) self::get('APP_ENV', 'development')) === 'production';
    }

    public static function isDevelopment() {
        return !self::isProduction();
    }
}
