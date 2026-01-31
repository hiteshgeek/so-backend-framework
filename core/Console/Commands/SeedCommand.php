<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Seed Command
 *
 * Run database seeders to populate the database with test data.
 *
 * Usage:
 *   php sixorbit db:seed
 *   php sixorbit db:seed --class=UserSeeder
 *   php sixorbit db:seed --force
 */
class SeedCommand extends Command
{
    protected string $signature = 'db:seed {--class=} {--force}';

    protected string $description = 'Seed the database with records';

    public function handle(): int
    {
        $class = $this->option('class');
        $force = $this->option('force', false);

        // Default to DatabaseSeeder if no class specified
        if (!$class) {
            $class = 'Database\\Seeders\\DatabaseSeeder';
        } else {
            // If class doesn't include namespace, assume it's in Database\Seeders
            if (!str_contains($class, '\\')) {
                $class = 'Database\\Seeders\\' . $class;
            }
        }

        // Check if running in production
        $env = env('APP_ENV', 'production');
        if ($env === 'production' && !$force) {
            $this->error('Running seeders in production requires --force flag');
            $this->comment('Use: php sixorbit db:seed --force');
            return 1;
        }

        $this->info("Seeding database...");

        try {
            // Load the seeder class
            $seederFile = $this->resolveSeederPath($class);

            if (!file_exists($seederFile)) {
                $this->error("Seeder not found: {$class}");
                $this->comment("Create it with: php sixorbit make:seeder {$this->getClassBasename($class)}");
                return 1;
            }

            require_once $seederFile;

            if (!class_exists($class)) {
                $this->error("Seeder class not found: {$class}");
                return 1;
            }

            $seeder = new $class();

            if (!method_exists($seeder, 'run')) {
                $this->error("Seeder must have a run() method: {$class}");
                return 1;
            }

            // Run the seeder
            $this->comment("Seeding: {$class}");
            $seeder->run();

            $this->info("\nDatabase seeding completed successfully.");
            return 0;

        } catch (\Exception $e) {
            $this->error("Seeding failed: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }

    /**
     * Resolve the seeder file path from class name.
     */
    protected function resolveSeederPath(string $class): string
    {
        $basePath = getcwd();

        // Convert namespace to file path
        // Database\Seeders\UserSeeder -> database/seeders/UserSeeder.php
        $path = str_replace('\\', '/', $class);
        $path = str_replace('Database/Seeders/', 'database/seeders/', $path);
        $path = $basePath . '/' . $path . '.php';

        return $path;
    }

    /**
     * Get the base class name without namespace.
     */
    protected function getClassBasename(string $class): string
    {
        $parts = explode('\\', $class);
        return end($parts);
    }
}
