<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use Core\Database\Migrator;

/**
 * Migrate Status Command
 *
 * Display the status of each migration.
 *
 * Usage:
 *   php sixorbit migrate:status
 */
class MigrateStatusCommand extends Command
{
    protected string $signature = 'migrate:status';

    protected string $description = 'Show the status of each migration';

    public function handle(): int
    {
        try {
            $migrator = new Migrator();
            $status = $migrator->getStatus();

            if (empty($status)) {
                $this->info('No migrations found.');
                return 0;
            }

            // Display header
            $this->comment('Migration Status:');
            echo "\n";

            // Display formatted table
            $this->displayStatusTable($status);

            // Summary
            $total = count($status);
            $ran = count(array_filter($status, fn($item) => $item['ran']));
            $pending = $total - $ran;

            echo "\n";
            $this->info("Total: {$total} migration(s)");
            $this->info("Ran: {$ran} migration(s)");
            if ($pending > 0) {
                $this->comment("Pending: {$pending} migration(s)");
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('Failed to get migration status: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Display the status table in a formatted way.
     */
    protected function displayStatusTable(array $status): void
    {
        // Calculate column widths
        $maxMigrationLength = max(array_map(fn($item) => strlen($item['migration']), $status));
        $migrationWidth = max($maxMigrationLength, 20);
        $ranWidth = 6;
        $batchWidth = 15;

        // Display header row
        $this->displayRow('Ran', 'Migration', 'Batch', $ranWidth, $migrationWidth, $batchWidth);
        $this->displaySeparator($ranWidth, $migrationWidth, $batchWidth);

        // Display each migration
        foreach ($status as $item) {
            $ran = $item['ran'] ? 'Yes' : 'No';
            $batch = $item['batch'] !== null ? "Batch {$item['batch']}" : 'Pending';

            $this->displayRow($ran, $item['migration'], $batch, $ranWidth, $migrationWidth, $batchWidth);
        }
    }

    /**
     * Display a table row.
     */
    protected function displayRow(string $ran, string $migration, string $batch, int $ranWidth, int $migrationWidth, int $batchWidth): void
    {
        $ranFormatted = str_pad($ran, $ranWidth);
        $migrationFormatted = str_pad($migration, $migrationWidth);
        $batchFormatted = str_pad($batch, $batchWidth);

        echo "  {$ranFormatted} | {$migrationFormatted} | {$batchFormatted}\n";
    }

    /**
     * Display separator line.
     */
    protected function displaySeparator(int $ranWidth, int $migrationWidth, int $batchWidth): void
    {
        $separator = str_repeat('-', $ranWidth) . '-+-' .
                     str_repeat('-', $migrationWidth) . '-+-' .
                     str_repeat('-', $batchWidth);
        echo "  {$separator}\n";
    }
}
