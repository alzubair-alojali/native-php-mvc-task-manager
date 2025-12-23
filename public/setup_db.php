<?php
/**
 * Database Setup Script
 * Initializes the database schema for PostgreSQL or MySQL
 * 
 * Usage: php public/setup_db.php
 * Or visit: /setup_db.php
 */

// Load database connection
require_once __DIR__ . '/../config/database.php';

$isCLI = php_sapi_name() === 'cli';

function output($message, $isCLI)
{
    if ($isCLI) {
        echo $message . "\n";
    } else {
        echo "<p>$message</p>";
    }
}

if (!$isCLI) {
    echo "<!DOCTYPE html><html><head><title>Database Setup</title></head><body>";
    echo "<h1>🗄️ Database Setup</h1>";
}

try {
    $driver = $_ENV['DB_DRIVER'] ?? 'pgsql';
    output("📊 Database Driver: " . strtoupper($driver), $isCLI);
    output("🔗 Connecting to database...", $isCLI);

    // Read and execute schema
    $schemaFile = __DIR__ . '/../database/schema.sql';

    if (!file_exists($schemaFile)) {
        throw new Exception("Schema file not found: $schemaFile");
    }

    $schema = file_get_contents($schemaFile);

    if ($driver === 'pgsql') {
        // PostgreSQL: Execute entire schema
        output("🐘 Executing PostgreSQL schema...", $isCLI);
        $pdo->exec($schema);
    } else {
        // MySQL: Execute statements one by one
        output("🐬 Executing MySQL schema...", $isCLI);

        // Split by semicolon (simple approach for MySQL)
        $statements = array_filter(
            array_map('trim', explode(';', $schema)),
            fn($s) => !empty($s)
        );

        foreach ($statements as $statement) {
            $pdo->exec($statement);
        }
    }

    output("✅ Schema created successfully!", $isCLI);

    // Verify tables exist
    if ($driver === 'pgsql') {
        $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    } else {
        $stmt = $pdo->query("SHOW TABLES");
    }

    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    output("", $isCLI);
    output("📋 Tables created:", $isCLI);
    foreach ($tables as $table) {
        output("   ✓ $table", $isCLI);
    }

    output("", $isCLI);
    output("🎉 Database setup complete!", $isCLI);
    output("", $isCLI);
    output("Next steps:", $isCLI);
    output("1. Run the seeder: php database/seed_libyan.php", $isCLI);
    output("2. Access the app at /", $isCLI);

} catch (PDOException $e) {
    output("❌ Database Error: " . $e->getMessage(), $isCLI);
    exit(1);
} catch (Exception $e) {
    output("❌ Error: " . $e->getMessage(), $isCLI);
    exit(1);
}

if (!$isCLI) {
    echo "</body></html>";
}