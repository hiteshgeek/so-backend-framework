<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use Core\Database\Migrator;

/**
 * Migrate Rollback Command
 *
 * Rollback the last batch of database migrations.
 *
 * Usage:
 *   php sixorbit migrate:rollback
 *   php sixorbit migrate:rollback --step=2
 *   php sixorbit migrate:rollback --pretend
 *   php sixorbit migrate:rollback --force
 */
class MigrateRollbackCommand extends Command
{
    protected string $signature = 'migrate:rollback {--step=1} {--pretend} {--force}';

    protected string $description = 'Rollback the last database migration';

    public function handle(): int
    {
        try {
            $migrator = new Migrator();

            $step = $this->option('step', 1);
            $pretend = $this->option('pretend', false);
            $force = $this->option('force', false);

            // Validate step
            $step = (int)$step;
            if ($step <= 0) {
                $this->error('Step must be a positive integer.');
                return 1;
            }

            // Get migrations to rollback
            $toRollback = $this->getMigrationsToRollback($migrator, $step);

            if (empty($toRollback)) {
                $this->info('Nothing to rollback.');
                return 0;
            }

            if ($pretend) {
                $this->comment('The following migrations would be rolled back:');
                foreach ($toRollback as $migration) {
                    $this->info("  - {$migration['migration']}");
                }
                return 0;
            }

            // Show what will be rolled back
            $this->comment('The following migrations will be rolled back:');
            foreach ($toRollback as $migration) {
                $this->info("  - {$migration['migration']}");
            }
            echo "\n";

            // Confirm before rollback
            if (!$force) {
                if (!$this->confirm('Are you sure you want to rollback these migrations?', false)) {
                    $this->comment('Rollback cancelled.');
                    return 0;
                }
            }

            // Perform rollback
            $rolledBack = $migrator->rollback($step);

            if (empty($rolledBack)) {
                $this->info('Nothing to rollback.');
                return 0;
            }

            // Show rolled back migrations
            $count = count($rolledBack);
            $this->info("Successfully rolled back {$count} migration(s):");
            foreach ($rolledBack as $migration) {
                $this->info("  - {$migration}");
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('Rollback failed: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Get migrations that would be rolled back.
     */
    protected function getMigrationsToRollback(Migrator $migrator, int $step): array
    {
        try {
            // Use reflection to access protected method
            $reflection = new \ReflectionClass($migrator);
            $method = $reflection->getMethod('getLastBatchMigrations');
            $method->setAccessible(true);
            return $method->invoke($migrator, $step);
        } catch (\Exception $e) {
            return [];
        }
    }
}
