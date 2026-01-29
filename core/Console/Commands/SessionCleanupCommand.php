<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Session Cleanup Command
 *
 * Removes expired sessions from the database
 */
class SessionCleanupCommand extends Command
{
    protected string $signature = 'session:cleanup';
    protected string $description = 'Remove expired sessions';

    public function handle(): int
    {
        try {
            $lifetime = config('session.lifetime', 120) * 60;
            $expiration = time() - $lifetime;

            $db = app('db');
            $deleted = $db->execute(
                "DELETE FROM sessions WHERE last_activity < ?",
                [$expiration]
            );

            $this->info("Removed {$deleted} expired sessions.");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error cleaning up sessions: " . $e->getMessage());
            return 1;
        }
    }
}
