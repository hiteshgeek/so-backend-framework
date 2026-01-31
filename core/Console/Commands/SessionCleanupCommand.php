<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Session Cleanup Command
 *
 * Removes expired sessions from the database
 *
 * Usage:
 *   php sixorbit session:cleanup
 *   php sixorbit session:cleanup --dry-run
 *   php sixorbit session:cleanup --verbose
 *   php sixorbit session:cleanup --force (skip confirmation)
 */
class SessionCleanupCommand extends Command
{
    protected string $signature = 'session:cleanup {--dry-run} {--verbose} {--v} {--force}';
    protected string $description = 'Remove expired sessions';

    public function handle(): int
    {
        $verbose = $this->option('verbose', false) || $this->option('v', false);

        try {
            $lifetime = config('session.lifetime', 120) * 60;
            $expiration = time() - $lifetime;
            $cutoffDate = date('Y-m-d H:i:s', $expiration);

            $db = app('db');

            // Get count before deleting
            $result = $db->query(
                "SELECT COUNT(*) as count FROM sessions WHERE last_activity < ?",
                [$expiration]
            )->fetchAll(\PDO::FETCH_ASSOC);
            $count = (int)($result[0]['count'] ?? 0);

            if ($verbose) {
                $this->info("Session lifetime: " . config('session.lifetime', 120) . " minutes");
                $this->info("Cutoff date: {$cutoffDate}");
                $this->info("Entries to delete: {$count}");
            }

            // Dry run - show what would happen
            if ($this->option('dry-run', false)) {
                $this->comment("Would delete expired sessions older than {$cutoffDate}");
                $this->comment("Would delete {$count} session records");
                return 0;
            }

            // Confirmation prompt (unless --force is used)
            if (!$this->option('force', false)) {
                $message = "Are you sure you want to delete {$count} expired session(s)?";
                if (!$this->confirm($message)) {
                    $this->comment("Operation cancelled.");
                    return 0;
                }
            }

            // Delete expired sessions
            if ($verbose) {
                $this->info("Deleting expired sessions...");
            }

            $deleted = $db->execute(
                "DELETE FROM sessions WHERE last_activity < ?",
                [$expiration]
            );

            $this->info("Deleted {$deleted} expired session records.");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error cleaning up sessions: " . $e->getMessage());
            if ($verbose) {
                $this->error($e->getTraceAsString());
            }
            return 1;
        }
    }
}
