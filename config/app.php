<?php
// Prevent direct access
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}
// Load .env file
$envFile = APP_ROOT . '/.env';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        $line = trim($line);
        if (empty($line) || $line[0] === '#') {
            continue;
        }

        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value);

            // Remove surrounding quotes
            if (preg_match('/^"(.*)"$/', $value, $matches)) {
                $value = $matches[1];
            } elseif (preg_match("/^'(.*)'$/", $value, $matches)) {
                $value = $matches[1];
            }

            // Set in environment
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}
// Application Settings
define('APP_NAME',  $_ENV['APP_NAME']  ?? 'KCSC - KUET Cyber Security Club');
define('APP_URL',   $_ENV['APP_URL']   ?? 'http://localhost');
define('APP_DEBUG', filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN));
// Error Handling Configuration
if (APP_DEBUG) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}

// Log errors to storage/logs/
ini_set('log_errors', '1');
ini_set('error_log', APP_ROOT . '/storage/logs/error.log');
// Session Configuration
if (session_status() === PHP_SESSION_NONE) {
    // Harden session cookie
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}
// Timezone
date_default_timezone_set('Asia/Dhaka');
