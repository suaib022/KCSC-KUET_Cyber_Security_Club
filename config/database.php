<?php
// Ensure app config is loaded first (which parses .env)
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

/**
 * Get a PDO database connection.
 *
 * @return PDO
 * @throws RuntimeException If connection fails in production
 */
function getDBConnection(): PDO
{
    static $pdo = null;

    // Return existing connection (singleton pattern)
    if ($pdo !== null) {
        return $pdo;
    }

    $host    = $_ENV['DB_HOST']    ?? 'localhost';
    $port    = $_ENV['DB_PORT']    ?? '3306';
    $dbName  = $_ENV['DB_NAME']    ?? 'kcsc_db';
    $user    = $_ENV['DB_USER']    ?? 'root';
    $pass    = $_ENV['DB_PASS']    ?? '';
    $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

    $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset={$charset}";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,    // Use real prepared statements
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$charset}'",
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Log the actual error
        error_log('Database Connection Error: ' . $e->getMessage());

        // Show details only in debug mode
        if (defined('APP_DEBUG') && APP_DEBUG) {
            throw new RuntimeException('Database Connection Failed: ' . $e->getMessage());
        }

        // Generic message in production
        throw new RuntimeException('A database error occurred. Please try again later.');
    }
}
