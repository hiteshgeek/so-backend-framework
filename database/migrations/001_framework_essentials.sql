-- ============================================
-- SO Framework - Essential Tables Migration
-- ============================================
-- This migration creates all ESSENTIAL framework tables
-- These tables should be in a separate 'so_essentials' database
-- Run with: mysql -u root -p < 001_framework_essentials.sql
--
-- Table Constants Reference: App\Constants\DatabaseTables
-- Database Connection: app('db-essentials')
-- ============================================

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS so_essentials
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Use the database
USE so_essentials;

-- ============================================

-- ============================================
-- OPTIONAL TABLES (Comment out if using existing tables)
-- ============================================
-- If you have existing user/session tables in your application database,
-- you can skip these tables and configure the framework to use your existing tables.
-- See DatabaseTables.php for configuration with existing tables.
-- ============================================

-- 1. Users Table (Authentication) - OPTIONAL
-- Constant: DatabaseTables::USERS
-- Skip this if you have existing user table (e.g., 'auser')
/*
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_remember_token (remember_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
*/

-- 2. Password Resets Table (Authentication) - OPTIONAL
-- Constant: DatabaseTables::PASSWORD_RESETS
-- Skip this if you handle password resets differently
/*
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    INDEX idx_email (email),
    INDEX idx_token (token),
    INDEX idx_expires_at (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
*/

-- 3. Sessions Table (Database-driven sessions) - OPTIONAL
-- Constant: DatabaseTables::SESSIONS
-- Skip this if you have existing session table (e.g., 'auser_session')
/*
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
*/

-- ============================================
-- REQUIRED FRAMEWORK TABLES
-- ============================================

-- 4. Jobs Table (Queue system)
-- Constant: DatabaseTables::JOBS
CREATE TABLE IF NOT EXISTS jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Failed Jobs Table (Queue system)
-- Constant: DatabaseTables::FAILED_JOBS
CREATE TABLE IF NOT EXISTS failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX failed_jobs_uuid_index (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Job Batches Table (Queue system)
-- Constant: DatabaseTables::JOB_BATCHES
CREATE TABLE IF NOT EXISTS job_batches (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Notifications Table (Notification system)
-- Constant: DatabaseTables::NOTIFICATIONS
CREATE TABLE IF NOT EXISTS notifications (
    id CHAR(36) NOT NULL PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    data TEXT NOT NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX notifications_notifiable_type_notifiable_id_index (notifiable_type, notifiable_id),
    INDEX notifications_read_at_index (read_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Activity Log Table (Audit trail)
-- Constant: DatabaseTables::ACTIVITY_LOG
CREATE TABLE IF NOT EXISTS activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    log_name VARCHAR(255) NULL,
    description TEXT NOT NULL,
    subject_type VARCHAR(255) NULL,
    subject_id BIGINT UNSIGNED NULL,
    event VARCHAR(255) NULL,
    causer_type VARCHAR(255) NULL,
    causer_id BIGINT UNSIGNED NULL,
    properties JSON NULL,
    batch_uuid CHAR(36) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX subject (subject_type, subject_id),
    INDEX causer (causer_type, causer_id),
    INDEX log_name (log_name),
    INDEX created_at_index (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Cache Table (Cache system)
-- Constant: DatabaseTables::CACHE
CREATE TABLE IF NOT EXISTS cache (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL,
    INDEX cache_expiration_index (expiration)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Cache Locks Table (Cache system)
-- Constant: DatabaseTables::CACHE_LOCKS
CREATE TABLE IF NOT EXISTS cache_locks (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Personal Access Tokens Table (API authentication)
-- Constant: DatabaseTables::PERSONAL_ACCESS_TOKENS
CREATE TABLE IF NOT EXISTS personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id),
    INDEX personal_access_tokens_token_index (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Migrations Table (Track migrations)
-- Constant: DatabaseTables::MIGRATIONS
CREATE TABLE IF NOT EXISTS migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- MEDIA SYSTEM TABLES
-- ============================================

-- 13. Media Table (File uploads tracking)
-- Constant: DatabaseTables::MEDIA
CREATE TABLE IF NOT EXISTS media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    path VARCHAR(500) NOT NULL COMMENT 'Relative path from storage root',
    disk VARCHAR(50) DEFAULT 'media',
    mime_type VARCHAR(100) NOT NULL,
    size BIGINT UNSIGNED NOT NULL,
    width INT UNSIGNED NULL COMMENT 'Image width in pixels',
    height INT UNSIGNED NULL COMMENT 'Image height in pixels',
    parent_id BIGINT UNSIGNED NULL COMMENT 'Parent media ID for variants',
    metadata JSON NULL COMMENT 'EXIF, variants, watermark info, etc.',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_filename (filename),
    INDEX idx_path (path(191)),
    INDEX idx_disk (disk),
    INDEX idx_mime_type (mime_type),
    INDEX idx_parent_id (parent_id),
    INDEX idx_created_at (created_at),

    FOREIGN KEY (parent_id) REFERENCES media(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Attachments Table (Polymorphic relationships)
-- Constant: DatabaseTables::ATTACHMENTS
CREATE TABLE IF NOT EXISTS attachments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    media_id BIGINT UNSIGNED NOT NULL,
    attachable_type VARCHAR(255) NOT NULL COMMENT 'Model class name',
    attachable_id BIGINT UNSIGNED NOT NULL COMMENT 'Model ID',
    collection VARCHAR(100) DEFAULT 'default' COMMENT 'Collection name: images, documents, etc.',
    position INT UNSIGNED DEFAULT 0 COMMENT 'For ordering',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_attachable (attachable_type, attachable_id),
    INDEX idx_media (media_id),
    INDEX idx_collection (collection),
    INDEX idx_position (position),

    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Upload Chunks Table (Chunked/resumable uploads)
-- Constant: DatabaseTables::UPLOAD_CHUNKS
CREATE TABLE IF NOT EXISTS upload_chunks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    upload_id VARCHAR(64) NOT NULL UNIQUE COMMENT 'Unique upload session ID',
    filename VARCHAR(255) NOT NULL,
    total_chunks INT UNSIGNED NOT NULL,
    uploaded_chunks INT UNSIGNED DEFAULT 0,
    total_size BIGINT UNSIGNED NOT NULL COMMENT 'Total file size in bytes',
    chunk_size INT UNSIGNED NOT NULL COMMENT 'Size of each chunk',
    mime_type VARCHAR(100) NULL,
    user_id BIGINT UNSIGNED NULL COMMENT 'User who initiated the upload',
    metadata JSON NULL COMMENT 'Additional upload metadata',
    temp_path VARCHAR(500) NULL COMMENT 'Path to temporary chunks directory',
    status ENUM('pending', 'uploading', 'processing', 'completed', 'failed', 'expired') DEFAULT 'pending',
    error_message TEXT NULL COMMENT 'Error message if failed',
    expires_at TIMESTAMP NOT NULL COMMENT 'When upload session expires',
    completed_at TIMESTAMP NULL COMMENT 'When upload was completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_upload_id (upload_id),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_expires_at (expires_at),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- END OF ESSENTIAL TABLES
-- ============================================
-- Total Required Tables: 12 (queue, cache, notifications, activity_log, tokens, migrations, media, attachments, upload_chunks)
-- Total Optional Tables: 3 (users, password_resets, sessions)
-- Database: so_essentials
-- Access: app('db-essentials')->table(DatabaseTables::CONSTANT_NAME)
--
-- NOTE: If you skipped optional tables, configure your existing tables in:
-- - app/Constants/DatabaseTables.php
-- - Custom Auth/Session handlers as needed
-- ============================================
