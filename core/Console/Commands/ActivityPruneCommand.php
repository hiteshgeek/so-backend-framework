<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Activity Log Prune Command
 *
 * Deletes old activity log entries to keep the table size manageable
 *
 * Usage:
 *   php sixorbit activity:prune
 *   php sixorbit activity:prune --days=180
 *   php sixorbit activity:prune --dry-run
 *   php sixorbit activity:prune --verbose
 *   php sixorbit activity:prune --force (skip confirmation)
 */
class ActivityPruneCommand extends Command
{
    protected string $signature = 'activity:prune {--days=365} {--dry-run} {--verbose} {--v} {--force}';
    protected string $description = 'Delete old activity log entries';

    public function handle(): int
    {
        $days = $this->option('days') ?? 365;
        $verbose = $this->option('verbose', false) || $this->option('v', false);

        if (!is_numeric($days) || $days < 1) {
            $this->error("Days must be a positive number.");
            return 1;
        }

        try {
            $cutoff = date('Y-m-d H:i:s', strtotime("-{$days} days"));

            $db = app('db');

            // Get count before deleting
            $result = $db->query(
                "SELECT COUNT(*) as count FROM activity_log WHERE created_at < ?",
                [$cutoff]
            )->fetchAll(\PDO::FETCH_ASSOC);
            $count = (int)($result[0]['count'] ?? 0);

            if ($verbose) {
                $this->info("Retention period: {$days} days");
                $this->info("Cutoff date: {$cutoff}");
                $this->info("Entries to delete: {$count}");
            }

            // Dry run - show what would happen
            if ($this->option('dry-run', false)) {
                $this->comment("Would delete activity log entries older than {$days} days (before {$cutoff})");
                $this->comment("Would delete {$count} activity log records");
                return 0;
            }

            // Confirmation prompt (unless --force is used)
            if (!$this->option('force', false)) {
                $message = "Are you sure you want to delete {$count} activity log entrie(s) older than {$days} days?";
                if (!$this->confirm($message)) {
                    $this->comment("Operation cancelled.");
                    return 0;
                }
            }

            // Delete old activity log entries
            if ($verbose) {
                $this->info("Deleting old activity log entries...");
            }

            $deleted = $db->execute(
                "DELETE FROM activity_log WHERE created_at < ?",
                [$cutoff]
            );

            $this->info("Deleted {$deleted} activity log records older than {$days} days.");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error pruning activity log: " . $e->getMessage());
            if ($verbose) {
                $this->error($e->getTraceAsString());
            }
            return 1;
        }
    }
}
