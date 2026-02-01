<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use Core\Database\Migrator;

/**
 * Migrate Command
 *
 * Run pending database migrations.
 *
 * Usage:
 *   php sixorbit migrate
 *   php sixorbit migrate --step=5
 *   php sixorbit migrate --pretend
 *   php sixorbit migrate --force
 */
class MigrateCommand extends Command
{
    protected string $signature = 'migrate {--step=} {--pretend} {--force}';

    protected string $description = 'Run database migrations';

    public function handle(): int
    {
        try {
            $migrator = new Migrator();

            // Check if we're in production and need confirmation
            if ($this->isProduction() && !$this->option('force', false)) {
                if (!$this->confirm('You are in production. Do you want to continue?', false)) {
                    $this->comment('Migration cancelled.');
                    return 0;
                }
            }

            $step = $this->option('step', null);
            $pretend = $this->option('pretend', false);

            if ($step !== null) {
                $step = (int)$step;
                if ($step <= 0) {
                    $this->error('Step must be a positive integer.');
                    return 1;
                }
            }

            // Get pending migrations
            $allFiles = $migrator->getMigrationFiles();
            $executed = $this->getExecutedMigrations($migrator);
            $pending = array_diff($allFiles, $executed);

            if (empty($pending)) {
                $this->info('Nothing to migrate.');
                return 0;
            }

            // Limit by step if specified
            $toRun = $pending;
            if ($step > 0) {
                $toRun = array_slice($pending, 0, $step);
            }

            if ($pretend) {
                $this->comment('The following migrations would be run:');
                foreach ($toRun as $migration) {
                    $this->info("  - {$migration}");
                }
                return 0;
            }

            // Show migrations to be run
            $this->comment('Running migrations:');
            foreach ($toRun as $migration) {
                $this->info("  - {$migration}");
            }
            echo "\n";

            // Run migrations
            $ran = $migrator->run($step ?? 0);

            if (empty($ran)) {
                $this->info('Nothing to migrate.');
                return 0;
            }

            // Show success message
            $count = count($ran);
            $this->info("Successfully migrated {$count} migration(s).");
            return 0;

        } catch (\Exception $e) {
            $this->error('Migration failed: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Get executed migrations from the migrator.
     */
    protected function getExecutedMigrations(Migrator $migrator): array
    {
        try {
            // Use reflection to access protected method
            $reflection = new \ReflectionClass($migrator);
            $method = $reflection->getMethod('getExecutedMigrations');
            $method->setAccessible(true);
            return $method->invoke($migrator);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Check if we're in production environment.
     */
    protected function isProduction(): bool
    {
        $env = getenv('APP_ENV') ?: 'production';
        return in_array(strtolower($env), ['production', 'prod']);
    }
}
