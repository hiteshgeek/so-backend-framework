<?php

namespace Core\Database;

/**
 * Seeder Base Class
 *
 * Base class for all database seeders.
 */
abstract class Seeder
{
    /**
     * Run the seeder.
     */
    abstract public function run(): void;

    /**
     * Call another seeder.
     */
    protected function call(string|array $seeders): void
    {
        $seeders = is_array($seeders) ? $seeders : [$seeders];

        foreach ($seeders as $seederClass) {
            $seeder = new $seederClass();

            if (!$seeder instanceof Seeder) {
                throw new \RuntimeException("Seeder must extend Core\Database\Seeder: {$seederClass}");
            }

            echo "Seeding: {$seederClass}\n";
            $seeder->run();
        }
    }

    /**
     * Get database connection.
     */
    protected function db()
    {
        return app('db');
    }

    /**
     * Insert data into a table.
     */
    protected function insert(string $table, array $data): void
    {
        app('db')->table($table)->insert($data);
    }

    /**
     * Truncate a table.
     */
    protected function truncate(string $table): void
    {
        app('db')->connection->execute("TRUNCATE TABLE `{$table}`");
    }

    /**
     * Delete all records from a table.
     */
    protected function delete(string $table): void
    {
        app('db')->table($table)->delete();
    }
}
