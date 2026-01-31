<?php

namespace Core\Database;

/**
 * Schema Builder
 *
 * Provides static methods for creating and modifying database tables.
 */
class Schema
{
    /**
     * Validate and sanitize table name.
     */
    protected static function validateTableName(string $table): string
    {
        // Only allow alphanumeric characters, underscores, and hyphens
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $table)) {
            throw new \InvalidArgumentException("Invalid table name: {$table}");
        }
        return $table;
    }

    /**
     * Create a new table.
     */
    public static function create(string $table, callable $callback): void
    {
        $table = self::validateTableName($table);
        $blueprint = new Blueprint($table);
        $callback($blueprint);

        $sql = $blueprint->toSql();
        app('db')->connection->execute($sql);
    }

    /**
     * Drop a table if it exists.
     */
    public static function dropIfExists(string $table): void
    {
        $table = self::validateTableName($table);
        $sql = "DROP TABLE IF EXISTS `{$table}`";
        app('db')->connection->execute($sql);
    }

    /**
     * Drop a table.
     */
    public static function drop(string $table): void
    {
        $table = self::validateTableName($table);
        $sql = "DROP TABLE `{$table}`";
        app('db')->connection->execute($sql);
    }

    /**
     * Check if a table exists.
     */
    public static function hasTable(string $table): bool
    {
        $table = self::validateTableName($table);
        $sql = "SHOW TABLES LIKE ?";
        $result = app('db')->connection->query($sql, [$table])->fetch();
        return !empty($result);
    }

    /**
     * Rename a table.
     */
    public static function rename(string $from, string $to): void
    {
        $from = self::validateTableName($from);
        $to = self::validateTableName($to);
        $sql = "RENAME TABLE `{$from}` TO `{$to}`";
        app('db')->connection->execute($sql);
    }

    /**
     * Modify an existing table (simplified - for adding columns).
     */
    public static function table(string $table, callable $callback): void
    {
        $table = self::validateTableName($table);
        $blueprint = new Blueprint($table);
        $callback($blueprint);

        // For ALTER TABLE operations, you would need to enhance Blueprint
        // This is a simplified version for basic operations
        $sql = $blueprint->toSql();
        app('db')->connection->execute($sql);
    }
}
