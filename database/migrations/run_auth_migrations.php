#!/usr/bin/env php
<?php

/**
 * Run Authentication Migrations
 *
 * Creates the password_resets table for password reset functionality
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap/app.php';

try {
    echo "Running authentication migrations...\n";

    $db = app('db')->connection;

    // Read and execute SQL file
    $sql = file_get_contents(__DIR__ . '/create_password_resets_table.sql');
    $db->getPdo()->exec($sql);

    echo "✓ password_resets table created successfully\n";
    echo "\nMigration completed!\n";

    exit(0);
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
