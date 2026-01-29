<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Cache Clear Command
 *
 * Clears all cache entries from the cache store
 */
class CacheClearCommand extends Command
{
    protected string $signature = 'cache:clear {--store=database}';
    protected string $description = 'Clear all cache entries';

    public function handle(): int
    {
        $store = $this->option('store') ?? 'database';

        try {
            $cache = cache()->store($store);

            if ($cache->flush()) {
                $this->info("Cache store [{$store}] cleared successfully.");
                return 0;
            }

            $this->error("Failed to clear cache store [{$store}].");
            return 1;
        } catch (\Exception $e) {
            $this->error("Error clearing cache: " . $e->getMessage());
            return 1;
        }
    }
}
