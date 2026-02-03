<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * View Status Command
 *
 * Shows SOTemplate compilation statistics
 *
 * Usage:
 *   php sixorbit view:status
 *   php sixorbit view:status --verbose
 */
class ViewStatusCommand extends Command
{
    protected string $signature = 'view:status {--verbose} {--v}';
    protected string $description = 'Show view cache status and statistics';

    public function handle(): int
    {
        $verbose = $this->option('verbose', false) || $this->option('v', false);

        try {
            // Get configuration
            $viewConfig = config('view', []);
            $viewPath = $viewConfig['paths'][0] ?? base_path('resources/views');
            $cachePath = $viewConfig['compiled'] ?? storage_path('views/compiled');
            $extension = $viewConfig['extension'] ?? '.sot.php';
            $autoReload = $viewConfig['auto_reload'] ?? config('app.debug', false);

            $this->info("SOTemplate Configuration:");
            $this->info("  View path: {$viewPath}");
            $this->info("  Cache path: {$cachePath}");
            $this->info("  Extension: {$extension}");
            $this->info("  Auto-reload: " . ($autoReload ? 'enabled' : 'disabled'));

            $this->newLine();

            // Count template files
            $templateCount = count($this->findTemplateFiles($viewPath, $extension));
            $phpCount = count($this->findTemplateFiles($viewPath, '.php')) - $templateCount;

            $this->info("Templates:");
            $this->info("  SOTemplate files ({$extension}): {$templateCount}");
            $this->info("  PHP files (.php): {$phpCount}");

            $this->newLine();

            // Get cache stats
            $view = app('view');
            $sotEngine = $view->getSOTemplateEngine();

            if ($sotEngine !== null) {
                $stats = $sotEngine->getCacheStats();

                $this->info("Cache Statistics:");
                $this->info("  Compiled files: {$stats['files']}");
                $this->info("  Total size: " . $this->formatBytes($stats['size']));

                if ($stats['oldest'] !== null) {
                    $this->info("  Oldest: " . date('Y-m-d H:i:s', $stats['oldest']));
                }
                if ($stats['newest'] !== null) {
                    $this->info("  Newest: " . date('Y-m-d H:i:s', $stats['newest']));
                }

                // Show detailed list if verbose
                if ($verbose && $stats['files'] > 0) {
                    $this->newLine();
                    $this->info("Compiled Files:");
                    $this->listCompiledFiles($cachePath);
                }
            } else {
                $this->comment("SOTemplate engine is not configured.");
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Find all template files with the given extension
     */
    protected function findTemplateFiles(string $path, string $extension): array
    {
        $files = [];

        if (!is_dir($path)) {
            return $files;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), $extension)) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    /**
     * List compiled files with details
     */
    protected function listCompiledFiles(string $cachePath): void
    {
        if (!is_dir($cachePath)) {
            return;
        }

        $files = glob($cachePath . '/*.php');
        foreach ($files as $file) {
            $basename = basename($file);
            $size = filesize($file);
            $mtime = filemtime($file);

            printf(
                "  %s (%s, %s)\n",
                $basename,
                $this->formatBytes($size),
                date('Y-m-d H:i:s', $mtime)
            );
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

    /**
     * Output a new line
     */
    protected function newLine(): void
    {
        echo "\n";
    }
}
