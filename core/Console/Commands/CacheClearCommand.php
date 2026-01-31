<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Cache Clear Command
 *
 * Clears all cache entries from the cache store
 *
 * Usage:
 *   php sixorbit cache:clear
 *   php sixorbit cache:clear --store=file
 *   php sixorbit cache:clear --dry-run
 *   php sixorbit cache:clear --verbose
 *   php sixorbit cache:clear --force (skip confirmation)
 */
class CacheClearCommand extends Command
{
    protected string $signature = 'cache:clear {--store=database} {--dry-run} {--verbose} {--v} {--force}';
    protected string $description = 'Clear all cache entries';

    public function handle(): int
    {
        $store = $this->option('store') ?? 'database';
        $verbose = $this->option('verbose', false) || $this->option('v', false);

        try {
            $cache = cache()->store($store);

            // Get count before clearing (if possible)
            $count = null;
            if (method_exists($cache, 'count')) {
                try {
                    $count = $cache->count();
                } catch (\Exception $e) {
                    // Count not supported, continue
                }
            }

            if ($verbose) {
                $this->info("Cache store: {$store}");
                if ($count !== null) {
                    $this->info("Entries to clear: {$count}");
                }
            }

            // Dry run - show what would happen
            if ($this->option('dry-run', false)) {
                $this->comment("Would clear cache store [{$store}]");
                if ($count !== null) {
                    $this->comment("Would delete {$count} cache entries");
                }
                return 0;
            }

            // Confirmation prompt (unless --force is used)
            if (!$this->option('force', false)) {
                $message = "Are you sure you want to clear all cache entries in store [{$store}]?";
                if (!$this->confirm($message)) {
                    $this->comment("Operation cancelled.");
                    return 0;
                }
            }

            // Clear cache
            if ($verbose) {
                $this->info("Clearing cache...");
            }

            if ($cache->flush()) {
                if ($count !== null) {
                    $this->info("Cache store [{$store}] cleared successfully. ({$count} entries removed)");
                } else {
                    $this->info("Cache store [{$store}] cleared successfully.");
                }
                return 0;
            }

            $this->error("Failed to clear cache store [{$store}].");
            return 1;
        } catch (\Exception $e) {
            $this->error("Error clearing cache: " . $e->getMessage());
            if ($verbose) {
                $this->error($e->getTraceAsString());
            }
            return 1;
        }
    }
}
