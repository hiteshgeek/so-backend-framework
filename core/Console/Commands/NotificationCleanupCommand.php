<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Notification Cleanup Command
 *
 * Deletes read notifications older than specified days
 *
 * Usage:
 *   php sixorbit notification:cleanup
 *   php sixorbit notification:cleanup --days=60
 *   php sixorbit notification:cleanup --dry-run
 *   php sixorbit notification:cleanup --verbose
 *   php sixorbit notification:cleanup --force (skip confirmation)
 */
class NotificationCleanupCommand extends Command
{
    protected string $signature = 'notification:cleanup {--days=30} {--dry-run} {--verbose} {--v} {--force}';
    protected string $description = 'Delete read notifications older than X days';

    public function handle(): int
    {
        $days = $this->option('days') ?? 30;
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
                "SELECT COUNT(*) as count FROM notifications WHERE read_at IS NOT NULL AND read_at < ?",
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
                $this->comment("Would delete read notifications older than {$days} days (before {$cutoff})");
                $this->comment("Would delete {$count} notification records");
                return 0;
            }

            // Confirmation prompt (unless --force is used)
            if (!$this->option('force', false)) {
                $message = "Are you sure you want to delete {$count} read notification(s) older than {$days} days?";
                if (!$this->confirm($message)) {
                    $this->comment("Operation cancelled.");
                    return 0;
                }
            }

            // Delete old notifications
            if ($verbose) {
                $this->info("Deleting old notifications...");
            }

            $deleted = $db->execute(
                "DELETE FROM notifications WHERE read_at IS NOT NULL AND read_at < ?",
                [$cutoff]
            );

            $this->info("Deleted {$deleted} read notification records older than {$days} days.");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error cleaning up notifications: " . $e->getMessage());
            if ($verbose) {
                $this->error($e->getTraceAsString());
            }
            return 1;
        }
    }
}
