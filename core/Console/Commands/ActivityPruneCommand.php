<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Activity Log Prune Command
 *
 * Deletes old activity log entries to keep the table size manageable
 */
class ActivityPruneCommand extends Command
{
    protected string $signature = 'activity:prune {--days=365}';
    protected string $description = 'Delete old activity log entries';

    public function handle(): int
    {
        $days = $this->option('days') ?? 365;

        if (!is_numeric($days) || $days < 1) {
            $this->error("Days must be a positive number.");
            return 1;
        }

        try {
            $cutoff = date('Y-m-d H:i:s', strtotime("-{$days} days"));

            $db = app('db');
            $deleted = $db->execute(
                "DELETE FROM activity_log WHERE created_at < ?",
                [$cutoff]
            );

            $this->info("Removed {$deleted} activity log entries older than {$days} days.");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error pruning activity log: " . $e->getMessage());
            return 1;
        }
    }
}
