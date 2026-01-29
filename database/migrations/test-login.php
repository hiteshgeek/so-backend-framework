#!/usr/bin/env php
<?php

/**
 * Test login authentication flow
 *
 * This script tests the authentication directly to debug login issues
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Core\Support\Env;
use Core\Database\Connection;
use App\Models\User;

// Load .env file
Env::load(__DIR__ . '/../../.env');

// Bootstrap database
$config = [
    'host' => Env::get('DB_HOST', 'localhost'),
    'port' => Env::get('DB_PORT', '3306'),
    'database' => Env::get('DB_DATABASE', 'framework'),
    'username' => Env::get('DB_USERNAME', 'root'),
    'password' => Env::get('DB_PASSWORD', ''),
];

$connection = new Connection($config);

// Register the connection in the app container
$container = require __DIR__ . '/../../bootstrap/app.php';
$container->singleton('db', fn() => $connection);

echo "═══════════════════════════════════════\n";
echo "  Testing Login Authentication\n";
echo "═══════════════════════════════════════\n\n";

// Test credentials
$email = 'admin@test.com';
$password = 'password123';

echo "1. Testing with credentials:\n";
echo "   Email:    {$email}\n";
echo "   Password: {$password}\n\n";

// Step 1: Find user by email
echo "2. Finding user by email...\n";

// First, test raw query
$pdo = $connection->getPdo();
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$rawResult = $stmt->fetch(PDO::FETCH_ASSOC);
echo "   Raw query result: " . json_encode($rawResult) . "\n\n";

// Test creating user directly from raw result
echo "   Creating User from raw result...\n";
$testUser = new User($rawResult);
echo "   Test User attributes: " . json_encode($testUser->attributes) . "\n";
echo "   Test User toArray(): " . json_encode($testUser->toArray()) . "\n\n";

$user = User::findByEmail($email);

if (!$user) {
    echo "   ❌ User not found!\n";
    echo "\n   Available users:\n";

    $pdo = $connection->getPdo();
    $stmt = $pdo->query("SELECT id, name, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $u) {
        echo "   - ID: {$u['id']}, Email: {$u['email']}, Name: {$u['name']}\n";
    }
    exit(1);
}

echo "   ✅ User found: ID={$user->id}, Name={$user->name}\n";
echo "   Attributes: " . json_encode($user->attributes) . "\n\n";

// Step 2: Get the stored password hash
echo "3. Checking password hash:\n";
$storedHash = $user->attributes['password'] ?? null;
if ($storedHash) {
    echo "   Stored hash: " . substr($storedHash, 0, 50) . "...\n\n";
} else {
    echo "   ❌ Password hash not found in attributes!\n\n";
}

// Step 3: Verify password
echo "4. Verifying password...\n";
$verified = $user->verifyPassword($password);

if ($verified) {
    echo "   ✅ Password verification successful!\n";
} else {
    echo "   ❌ Password verification failed!\n";
    echo "\n   Debugging password verification:\n";
    echo "   - Plain password: {$password}\n";
    echo "   - Stored hash: {$storedHash}\n";
    echo "   - Hash algorithm: " . password_get_info($storedHash)['algoName'] . "\n";

    // Try manual verification
    echo "\n   Testing manual password_verify()...\n";
    $manualVerify = password_verify($password, $storedHash);
    echo "   Result: " . ($manualVerify ? "✅ SUCCESS" : "❌ FAILED") . "\n";
}

echo "\n═══════════════════════════════════════\n";
echo "  Test Complete\n";
echo "═══════════════════════════════════════\n";
