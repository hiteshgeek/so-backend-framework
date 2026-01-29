#!/usr/bin/env php
<?php

/**
 * Create a test user with known credentials
 *
 * This script creates a test user you can use to login
 * Email: admin@test.com
 * Password: password123
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Core\Support\Env;
use Core\Database\Connection;

// Load .env file
Env::load(__DIR__ . '/../../.env');

// Get database configuration
$config = [
    'host' => Env::get('DB_HOST', 'localhost'),
    'port' => Env::get('DB_PORT', '3306'),
    'database' => Env::get('DB_DATABASE', 'framework'),
    'username' => Env::get('DB_USERNAME', 'root'),
    'password' => Env::get('DB_PASSWORD', ''),
];

try {
    // Create connection
    $connection = new Connection($config);
    $pdo = $connection->getPdo();

    // Test credentials
    $email = 'admin@test.com';
    $password = 'password123';
    $name = 'Admin User';

    // Hash password using Argon2ID (same as User model)
    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

    // Check if user already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Update existing user
        $stmt = $pdo->prepare("UPDATE users SET password = ?, name = ?, updated_at = NOW() WHERE email = ?");
        $stmt->execute([$hashedPassword, $name, $email]);
        echo "✅ Updated existing test user\n";
    } else {
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        $stmt->execute([$name, $email, $hashedPassword]);
        echo "✅ Created new test user\n";
    }

    echo "\n";
    echo "═══════════════════════════════════════\n";
    echo "  Test User Credentials\n";
    echo "═══════════════════════════════════════\n";
    echo "  Email:    {$email}\n";
    echo "  Password: {$password}\n";
    echo "═══════════════════════════════════════\n";
    echo "\n";
    echo "You can now login at: " . Env::get('APP_URL', 'http://localhost') . "/login\n";
    echo "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
