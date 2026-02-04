<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * View Clear Command
 *
 * Clears all compiled view templates from the cache
 *
 * Usage:
 *   php sixorbit view:clear
 *   php sixorbit view:clear --verbose
 */
class ViewClearCommand extends Command
{
    protected string $signature = 'view:clear {--verbose} {--v}';
    protected string $description = 'Clear all compiled view templates';

    public function handle(): int
    {
        $verbose = $this->option('verbose', false) || $this->option('v', false);

        try {
            // Get the SOTemplate engine
            $view = app('view');
            $sotEngine = $view->getSOTemplateEngine();

            if ($sotEngine === null) {
                $this->error("SOTemplate engine is not configured.");
                return 1;
            }

            // Get stats before clearing
            if ($verbose) {
                $stats = $sotEngine->getCacheStats();
                $this->info("Cache directory: " . config('view.compiled', storage_path('views/compiled')));
                $this->info("Files to clear: {$stats['files']}");
                $this->info("Total size: " . $this->formatBytes($stats['size']));
            }

            // Clear the cache
            $this->info("Clearing compiled views...");
            $count = $sotEngine->clearCache();

            if ($count > 0) {
                $this->info("Cleared {$count} compiled view(s) successfully.");
            } else {
                $this->comment("No compiled views to clear.");
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("Error clearing compiled views: " . $e->getMessage());
            if ($verbose) {
                $this->error($e->getTraceAsString());
            }
            return 1;
        }
    }

    /**
     * Format bytes to human-readable format
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 2) . ' ' . $units[$index];
    }
}
