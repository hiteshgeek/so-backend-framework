<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Cache Garbage Collection Command
 *
 * Removes expired cache entries from the database
 */
class CacheGcCommand extends Command
{
    protected string $signature = 'cache:gc';
    protected string $description = 'Run cache garbage collection';

    public function handle(): int
    {
        try {
            $db = app('db');
            $deleted = $db->execute(
                "DELETE FROM cache WHERE expiration < ?",
                [time()]
            );

            $this->info("Removed {$deleted} expired cache entries.");
            return 0;
        } catch (\Exception $e) {
            $this->error("Error running garbage collection: " . $e->getMessage());
            return 1;
        }
    }
}
