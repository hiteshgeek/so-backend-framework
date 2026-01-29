<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Notification Cleanup Command
 *
 * Deletes read notifications older than specified days
 */
class NotificationCleanupCommand extends Command
{
    protected string $signature = 'notification:cleanup {--days=30}';
    protected string $description = 'Delete read notifications older than X days';

    public function handle(): int
    {
        $days = $this->option('days') ?? 30;

        if (!is_numeric($days) || $days < 1) {
            $this->error("Days must be a positive number.");
            return 1;
        }

        try {
            $cutoff = date('Y-m-d H:i:s', strtotime("-{$days} days"));

            $db = app('db');
            $deleted = $db->execute(
                "DELETE FROM notifications WHERE read_at IS NOT NULL AND read_at < ?",
                [$cutoff]
            );

            $this->info("Removed {$deleted} read notifications older than {$days} days.");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error cleaning up notifications: " . $e->getMessage());
            return 1;
        }
    }
}
