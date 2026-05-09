<?php
/**
 * Application bootstrap: configuration, error reporting, session, includes.
 */

require_once __DIR__ . '/includes/Config.php';
Config::load();

if (Config::isDevelopment()) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    ini_set('log_errors', '1');
}

if (session_status() === PHP_SESSION_NONE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_secure', $secure ? '1' : '0');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_samesite', 'Lax');

    session_start();
}

require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Sanitizer.php';
require_once __DIR__ . '/includes/CSRF.php';
require_once __DIR__ . '/includes/Institution.php';
require_once __DIR__ . '/includes/Program.php';
require_once __DIR__ . '/includes/Contact.php';
require_once __DIR__ . '/includes/Auth.php';
require_once __DIR__ . '/includes/scholarship.php';
