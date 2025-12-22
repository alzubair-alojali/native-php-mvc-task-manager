<?php
/**
 * Database Configuration
 * Supports both PostgreSQL (Render.com) and MySQL (local development)
 */

require_once __DIR__ . '/../core/Env.php';

Env::load(__DIR__ . '/../.env');

try {
    // Get database configuration from environment
    $driver = $_ENV['DB_DRIVER'] ?? 'pgsql';  // Default to PostgreSQL for Render
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $port = $_ENV['DB_PORT'] ?? ($driver === 'pgsql' ? '5432' : '3306');
    $db = $_ENV['DB_DATABASE'] ?? 'web_final_project';
    $user = $_ENV['DB_USERNAME'] ?? 'postgres';
    $pass = $_ENV['DB_PASSWORD'] ?? '';
    $charset = 'utf8';

    // Build DSN based on driver
    if ($driver === 'pgsql') {
        // PostgreSQL connection (Render.com)
        $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    } else {
        // MySQL connection (local development with Laragon)
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    }

    // PDO options
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    // Create PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (\PDOException $e) {
    // In production, log error instead of displaying
    error_log("Database connection failed: " . $e->getMessage());

    if (($_ENV['APP_DEBUG'] ?? 'false') === 'true') {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    } else {
        die("Database connection failed. Please try again later.");
    }
}