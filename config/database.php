<?php
/**
 * Database Configuration
 * 
 * Supports PostgreSQL (Supabase/Render) and MySQL (local development)
 * Uses Env::get() for production-safe environment variable access
 */

require_once __DIR__ . '/../core/Env.php';

// Try to load .env file (will silently skip if not found in production)
Env::load(__DIR__ . '/../.env');

try {
    // Get database configuration using Env::get() for production compatibility
    $driver = Env::get('DB_DRIVER', 'pgsql');
    $host = Env::get('DB_HOST', 'localhost');
    $port = Env::get('DB_PORT', '5432');  // Supabase Transaction Pooler uses 6543
    $db = Env::get('DB_DATABASE', 'web_final_project');
    $user = Env::get('DB_USERNAME', 'postgres');
    $pass = Env::get('DB_PASSWORD', '');
    $sslmode = Env::get('DB_SSLMODE', 'require');  // Supabase requires SSL

    // Build DSN based on driver
    if ($driver === 'pgsql') {
        // PostgreSQL connection (Supabase / Render)
        // Include port explicitly and sslmode for Supabase compatibility
        $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=$sslmode";
    } else {
        // MySQL connection (local development with Laragon)
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    }

    // PDO options
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 30,  // Connection timeout
    ];

    // Create PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (\PDOException $e) {
    // In production, log error instead of displaying
    error_log("Database connection failed: " . $e->getMessage());
    error_log("DSN attempted: pgsql:host=$host;port=$port;dbname=$db");

    if (Env::get('APP_DEBUG', 'false') === 'true') {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    } else {
        die("Database connection failed. Please try again later.");
    }
}