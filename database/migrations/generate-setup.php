#!/usr/bin/env php
<?php

/**
 * Generate setup.sql with configured database name
 *
 * This script reads your .env configuration and generates
 * a setup.sql file with the correct database name.
 *
 * Usage: php database/migrations/generate-setup.php
 */

// Load environment
require_once __DIR__ . '/../../vendor/autoload.php';

use Core\Support\Env;

// Load .env file
Env::load(__DIR__ . '/../../.env');

// Get database name from config
$dbName = Env::get('DB_DATABASE', 'framework');
$appName = Env::get('APP_NAME', 'Framework');

// Generate SQL
$sql = <<<SQL
-- Auto-generated setup SQL for: {$appName}
-- Database: {$dbName}
-- Generated: {date('Y-m-d H:i:s')}

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `{$dbName}`;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO users (name, email, password) VALUES
    ('John Doe', 'john@example.com', '\$argon2id\$v=19\$m=65536,t=4,p=1\$c29tZXNhbHQ\$ezVhxQ+8Xvq8GwMJqz9xqA'),
    ('Jane Smith', 'jane@example.com', '\$argon2id\$v=19\$m=65536,t=4,p=1\$c29tZXNhbHQ\$ezVhxQ+8Xvq8GwMJqz9xqA');

SQL;

// Write to setup.sql
$outputFile = __DIR__ . '/setup.sql';
file_put_contents($outputFile, $sql);

echo "✅ Generated setup.sql with database: {$dbName}\n";
echo "📁 File: {$outputFile}\n";
echo "\n";
echo "To import:\n";
echo "  mysql -u root -p < {$outputFile}\n";
echo "\n";
