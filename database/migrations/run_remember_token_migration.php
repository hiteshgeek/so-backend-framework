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

    echo "Connected to database successfully.\n";

    // Read and execute migration
    $sql = file_get_contents(__DIR__ . '/add_remember_token_to_users.sql');

    $pdo->exec($sql);

    echo "Migration executed successfully!\n";
    echo "Added remember_token column to users table.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
