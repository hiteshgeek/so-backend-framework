<?php

namespace App\Constants;

/**
 * Database Table Name Constants
 *
 * Centralized location for all database table names used throughout the application.
 * Use these constants instead of hard-coded table names for better maintainability.
 *
 * Usage Examples:
 * - app('db-essentials')->table(DatabaseTables::USERS)->get();
 * - app('db')->table(DatabaseTables::PRODUCTS)->where('status', 'active')->get();
 */
class DatabaseTables
{
    // ============================================
    // ESSENTIALS DATABASE TABLES (so_essentials)
    // Use: app('db-essentials')->table(...)
    // ============================================

    /**
     * User Management Tables (Framework Standard - Optional)
     * Note: These are commented out in migration if using existing tables
     */
    const USERS = 'users';
    const PASSWORD_RESETS = 'password_resets';
    const PERSONAL_ACCESS_TOKENS = 'personal_access_tokens';

    /**
     * Session Management (Framework Standard - Optional)
     * Note: This is commented out in migration if using existing table
     */
    const SESSIONS = 'sessions';

    /**
     * Cache System
     */
    const CACHE = 'cache';
    const CACHE_LOCKS = 'cache_locks';

    /**
     * Queue System
     */
    const JOBS = 'jobs';
    const FAILED_JOBS = 'failed_jobs';
    const JOB_BATCHES = 'job_batches';

    /**
     * Notifications & Logging
     */
    const NOTIFICATIONS = 'notifications';
    const ACTIVITY_LOG = 'activity_log';

    /**
     * System Tables
     */
    const MIGRATIONS = 'migrations';

    // ============================================
    // APPLICATION DATABASE TABLES
    // Use: app('db')->table(...)
    // ============================================

    /**
     * Demo Tables (Can be removed in production)
     */
    const POSTS = 'posts';
    const CATEGORIES = 'categories';
    const PRODUCTS = 'products';
    const TAGS = 'tags';
    const PRODUCT_TAGS = 'product_tags';
    const REVIEWS = 'reviews';

    // ============================================
    // EXISTING APPLICATION TABLES
    // Use: app('db')->table(...) or app('db-staging')->table(...)
    // ============================================

    /**
     * Existing User Management Tables
     * Use these if you're integrating into an existing project
     */
    const AUSER = 'auser';
    const AUSER_SESSION = 'auser_session';

    /**
     * Static/Reference Tables (from staging database)
     * Access via: rapidkart_factory_static.table_name
     */
    const AUSER_STATUS = 'rapidkart_factory_static.auser_status';
    const APERMISSION = 'rapidkart_factory_static.apermission';

    // ============================================
    // ADD YOUR APPLICATION TABLES HERE
    // ============================================

    // Example:
    // const ORDERS = 'orders';
    // const ORDER_ITEMS = 'order_items';
    // const CUSTOMERS = 'customers';

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Get all essentials database table names (required tables only)
     * Excludes optional tables (users, sessions, password_resets)
     */
    public static function getEssentialTables(): array
    {
        return [
            // Optional tables (if not using existing tables)
            // self::USERS,
            // self::PASSWORD_RESETS,
            // self::SESSIONS,

            // Required framework tables
            self::PERSONAL_ACCESS_TOKENS,
            self::CACHE,
            self::CACHE_LOCKS,
            self::JOBS,
            self::FAILED_JOBS,
            self::JOB_BATCHES,
            self::NOTIFICATIONS,
            self::ACTIVITY_LOG,
            self::MIGRATIONS,
        ];
    }

    /**
     * Get existing application table names (for integration projects)
     */
    public static function getExistingTables(): array
    {
        return [
            self::AUSER,
            self::AUSER_SESSION,
        ];
    }

    /**
     * Get all application database table names
     */
    public static function getApplicationTables(): array
    {
        return [
            self::POSTS,
            self::CATEGORIES,
            self::PRODUCTS,
            self::TAGS,
            self::PRODUCT_TAGS,
            self::REVIEWS,
        ];
    }

    /**
     * Check if a table is in essentials database
     */
    public static function isEssentialTable(string $tableName): bool
    {
        return in_array($tableName, self::getEssentialTables());
    }

    /**
     * Check if a table is in application database
     */
    public static function isApplicationTable(string $tableName): bool
    {
        return in_array($tableName, self::getApplicationTables());
    }
}
