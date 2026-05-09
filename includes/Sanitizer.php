<?php
/**
 * Input Sanitization and Output Escaping
 */

class Sanitizer {
    // Sanitize input
    public static function sanitize($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitize'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    // Escape output
    public static function escape($output) {
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }

    // Validate email
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Validate URL
    public static function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /** Prefix scheme when institutions store bare domains (e.g. www.example.ac.ug). */
    public static function formatWebsiteUrl($url) {
        $url = trim((string) $url);
        if ($url === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }
        return 'https://' . $url;
    }

    // Remove special characters
    public static function removeSpecialChars($input) {
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $input);
    }
}
?>
