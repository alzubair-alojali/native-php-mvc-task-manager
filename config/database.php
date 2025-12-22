<?php
/**
 * Database Configuration
 * 
 * Supports both PostgreSQL (Render.com) and MySQL (local development)
 * Uses Env::get() for production-safe environment variable access
 */

require_once __DIR__ . '/../core/Env.php';

// Try to load .env file (will silently skip if not found in production)
Env::load(__DIR__ . '/../.env');

try {
    // Get database configuration using Env::get() for production compatibility
    $driver = Env::get('DB_DRIVER', 'pgsql');
    $host = Env::get('DB_HOST', 'localhost');
    $port = Env::get('DB_PORT', $driver === 'pgsql' ? '5432' : '3306');
    $db = Env::get('DB_DATABASE', 'web_final_project');
    $user = Env::get('DB_USERNAME', 'postgres');
    $pass = Env::get('DB_PASSWORD', '');
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

    if (Env::get('APP_DEBUG', 'false') === 'true') {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    } else {
        die("Database connection failed. Please try again later.");
    }
}