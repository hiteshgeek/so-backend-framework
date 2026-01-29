<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Core\Support\Env;

// Load environment variables
Env::load(__DIR__ . '/../../.env');

// Database connection
$host = Env::get('DB_HOST', 'localhost');
$port = Env::get('DB_PORT', '3306');
$database = Env::get('DB_DATABASE');
$username = Env::get('DB_USERNAME');
$password = Env::get('DB_PASSWORD', '');

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    echo "Connected to database successfully.\n\n";

    // Read and execute migration
    $sql = file_get_contents(__DIR__ . '/create_framework_tables.sql');

    // Split by semicolon and execute each statement
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($statements as $statement) {
        if (empty($statement) || str_starts_with($statement, '--')) {
            continue;
        }

        try {
            $pdo->exec($statement);
            echo ".";
        } catch (PDOException $e) {
            // Ignore "table already exists" errors
            if (!str_contains($e->getMessage(), 'already exists')) {
                throw $e;
            }
            echo "S"; // S for Skipped
        }
    }

    echo "\n\n✅ Migration executed successfully!\n\n";
    echo "Created framework tables:\n";
    echo "  ✓ sessions              - Database-driven sessions\n";
    echo "  ✓ jobs                  - Queue system\n";
    echo "  ✓ failed_jobs          - Failed job tracking\n";
    echo "  ✓ notifications        - In-app notifications\n";
    echo "  ✓ activity_log         - Audit trail (compliance)\n";
    echo "  ✓ cache / cache_locks  - Performance caching\n";
    echo "  ✓ personal_access_tokens - API authentication\n";
    echo "  ✓ job_batches          - Batch job processing\n";
    echo "  ✓ migrations           - Migration tracking\n\n";

    echo "🎉 Your framework is now enterprise-ready for ERP!\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
