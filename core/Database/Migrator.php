<?php

namespace Core\Database;

/**
 * Migrator
 *
 * Handles running and rolling back database migrations.
 */
class Migrator
{
    protected string $migrationsPath;
    protected string $migrationsTable = 'migrations';

    public function __construct(string $migrationsPath = 'database/migrations')
    {
        $this->migrationsPath = $migrationsPath;
        $this->ensureMigrationsTableExists();
    }

    /**
     * Ensure the migrations table exists.
     */
    protected function ensureMigrationsTableExists(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->migrationsTable}` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `migration` VARCHAR(255) NOT NULL,
            `batch` INT NOT NULL,
            `executed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        app('db')->connection->execute($sql);
    }

    /**
     * Run all pending migrations.
     */
    public function run(int $step = 0): array
    {
        $ran = [];
        $files = $this->getMigrationFiles();
        $executed = $this->getExecutedMigrations();
        $batch = $this->getNextBatchNumber();

        $pending = array_diff($files, $executed);

        if (empty($pending)) {
            return [];
        }

        // Limit by step if specified
        if ($step > 0) {
            $pending = array_slice($pending, 0, $step);
        }

        app('db')->connection->getPdo()->beginTransaction();

        try {
            foreach ($pending as $file) {
                $this->runMigration($file, $batch);
                $ran[] = $file;
            }

            app('db')->connection->getPdo()->commit();
        } catch (\Exception $e) {
            app('db')->connection->getPdo()->rollBack();
            throw $e;
        }

        return $ran;
    }

    /**
     * Run a single migration file.
     */
    protected function runMigration(string $file, int $batch): void
    {
        $migration = $this->resolveMigration($file);

        // Run the up() method
        $migration->up();

        // Record in migrations table
        app('db')->table($this->migrationsTable)->insert([
            'migration' => $file,
            'batch' => $batch,
        ]);
    }

    /**
     * Rollback the last batch of migrations.
     */
    public function rollback(int $step = 0): array
    {
        $rolledBack = [];
        $migrations = $this->getLastBatchMigrations($step);

        if (empty($migrations)) {
            return [];
        }

        app('db')->connection->getPdo()->beginTransaction();

        try {
            foreach (array_reverse($migrations) as $migration) {
                $this->rollbackMigration($migration);
                $rolledBack[] = $migration['migration'];
            }

            app('db')->connection->getPdo()->commit();
        } catch (\Exception $e) {
            app('db')->connection->getPdo()->rollBack();
            throw $e;
        }

        return $rolledBack;
    }

    /**
     * Rollback a single migration.
     */
    protected function rollbackMigration(array $migrationRecord): void
    {
        $file = $migrationRecord['migration'];
        $migration = $this->resolveMigration($file);

        // Run the down() method
        $migration->down();

        // Remove from migrations table
        app('db')->table($this->migrationsTable)
            ->where('migration', '=', $file)
            ->delete();
    }

    /**
     * Get all migration files.
     */
    public function getMigrationFiles(): array
    {
        $path = getcwd() . '/' . $this->migrationsPath;

        if (!is_dir($path)) {
            return [];
        }

        $files = scandir($path);
        $migrations = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $migrations[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }

        sort($migrations);
        return $migrations;
    }

    /**
     * Get executed migrations from database.
     */
    protected function getExecutedMigrations(): array
    {
        $results = app('db')->table($this->migrationsTable)
            ->orderBy('migration')
            ->get();

        return array_column($results, 'migration');
    }

    /**
     * Get the last batch of migrations.
     */
    protected function getLastBatchMigrations(int $step = 0): array
    {
        $lastBatch = $this->getLastBatchNumber();

        if ($lastBatch === 0) {
            return [];
        }

        $query = app('db')->table($this->migrationsTable);

        if ($step > 0) {
            // Get migrations from last N batches
            $batches = app('db')->table($this->migrationsTable)
                ->select(['batch'])
                ->distinct()
                ->orderBy('batch', 'DESC')
                ->limit($step)
                ->get();

            $batchNumbers = array_column($batches, 'batch');
            $query->whereIn('batch', $batchNumbers);
        } else {
            // Get migrations from last batch only
            $query->where('batch', '=', $lastBatch);
        }

        return $query->orderBy('migration', 'DESC')->get();
    }

    /**
     * Get the next batch number.
     */
    protected function getNextBatchNumber(): int
    {
        return $this->getLastBatchNumber() + 1;
    }

    /**
     * Get the last batch number.
     */
    protected function getLastBatchNumber(): int
    {
        $result = app('db')->table($this->migrationsTable)
            ->max('batch');

        return (int)($result ?? 0);
    }

    /**
     * Get migration status (all migrations with their run status).
     */
    public function getStatus(): array
    {
        $files = $this->getMigrationFiles();
        $executed = app('db')->table($this->migrationsTable)
            ->orderBy('migration')
            ->get();

        $executedMap = [];
        foreach ($executed as $migration) {
            $executedMap[$migration['migration']] = $migration;
        }

        $status = [];
        foreach ($files as $file) {
            $status[] = [
                'migration' => $file,
                'ran' => isset($executedMap[$file]),
                'batch' => $executedMap[$file]['batch'] ?? null,
            ];
        }

        return $status;
    }

    /**
     * Resolve a migration instance from file.
     */
    protected function resolveMigration(string $file): Migration
    {
        $path = getcwd() . '/' . $this->migrationsPath . '/' . $file . '.php';

        if (!file_exists($path)) {
            throw new \RuntimeException("Migration file not found: {$path}");
        }

        $migration = require $path;

        if (!$migration instanceof Migration) {
            throw new \RuntimeException("Migration file must return an instance of Migration: {$file}");
        }

        return $migration;
    }

    /**
     * Reset all migrations (rollback all and re-run).
     */
    public function reset(): array
    {
        $rolledBack = [];

        while (true) {
            $batch = $this->rollback();
            if (empty($batch)) {
                break;
            }
            $rolledBack = array_merge($rolledBack, $batch);
        }

        return $rolledBack;
    }
}
