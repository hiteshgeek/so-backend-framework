<?php

namespace Core\Database;

/**
 * Migration Base Class
 *
 * Base class for all database migrations.
 * Migrations should implement up() and down() methods.
 */
abstract class Migration
{
    /**
     * Run the migration.
     */
    abstract public function up(): void;

    /**
     * Reverse the migration.
     */
    abstract public function down(): void;

    /**
     * Get the migration connection.
     */
    protected function getConnection(): \PDO
    {
        return app('db')->connection->getPdo();
    }

    /**
     * Execute a raw SQL query.
     */
    protected function execute(string $sql): bool
    {
        try {
            return $this->getConnection()->exec($sql) !== false;
        } catch (\PDOException $e) {
            throw new \RuntimeException("Migration failed: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Execute multiple SQL statements.
     */
    protected function executeMultiple(array $statements): bool
    {
        foreach ($statements as $sql) {
            if (!$this->execute($sql)) {
                return false;
            }
        }
        return true;
    }
}
