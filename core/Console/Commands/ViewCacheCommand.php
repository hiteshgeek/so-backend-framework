<?php

namespace Core\Console\Commands;

use Core\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * View Cache Command
 *
 * Pre-compiles all SOTemplate views to warm the cache
 *
 * Usage:
 *   php sixorbit view:cache
 *   php sixorbit view:cache --verbose
 *   php sixorbit view:cache --force
 */
class ViewCacheCommand extends Command
{
    protected string $signature = 'view:cache {--verbose} {--v} {--force}';
    protected string $description = 'Pre-compile all SOTemplate views';

    public function handle(): int
    {
        $verbose = $this->option('verbose', false) || $this->option('v', false);
        $force = $this->option('force', false);

        try {
            // Get the SOTemplate engine
            $view = app('view');
            $sotEngine = $view->getSOTemplateEngine();

            if ($sotEngine === null) {
                $this->error("SOTemplate engine is not configured.");
                return 1;
            }

            $viewConfig = config('view', []);
            $viewPath = $viewConfig['paths'][0] ?? base_path('resources/views');
            $extension = $viewConfig['extension'] ?? '.sot.php';

            // Clear cache first if --force is used
            if ($force) {
                $this->info("Clearing existing cache...");
                $sotEngine->clearCache();
            }

            // Find all SOTemplate files
            $this->info("Scanning for SOTemplate files ({$extension})...");

            $files = $this->findTemplateFiles($viewPath, $extension);
            $totalFiles = count($files);

            if ($totalFiles === 0) {
                $this->comment("No SOTemplate files found.");
                return 0;
            }

            $this->info("Found {$totalFiles} template(s) to compile.");

            $compiled = 0;
            $errors = 0;

            foreach ($files as $file) {
                $relativePath = str_replace($viewPath . DIRECTORY_SEPARATOR, '', $file);
                // Convert to dot notation
                $templateName = str_replace(
                    [DIRECTORY_SEPARATOR, $extension],
                    ['.', ''],
                    $relativePath
                );

                if ($verbose) {
                    $this->comment("Compiling: {$templateName}");
                }

                try {
                    // Render the template (this triggers compilation)
                    // We use a special method to just compile without rendering
                    $this->compileTemplate($sotEngine, $templateName, $file);
                    $compiled++;
                } catch (\Exception $e) {
                    $errors++;
                    $this->error("Error compiling {$templateName}: " . $e->getMessage());
                    if ($verbose) {
                        $this->error("  File: {$file}");
                    }
                }
            }

            // Show summary
            $this->newLine();
            $this->info("Compilation complete:");
            $this->info("  Total: {$totalFiles}");
            $this->info("  Compiled: {$compiled}");

            if ($errors > 0) {
                $this->error("  Errors: {$errors}");
                return 1;
            }

            // Show cache stats
            if ($verbose) {
                $stats = $sotEngine->getCacheStats();
                $this->newLine();
                $this->info("Cache statistics:");
                $this->info("  Files: {$stats['files']}");
                $this->info("  Size: " . $this->formatBytes($stats['size']));
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            if ($verbose) {
                $this->error($e->getTraceAsString());
            }
            return 1;
        }
    }

    /**
     * Find all template files with the given extension
     *
     * @param string $path Base path
     * @param string $extension File extension
     * @return array List of file paths
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

        sort($files);
        return $files;
    }

    /**
     * Compile a single template
     *
     * @param object $engine SOTemplateEngine instance
     * @param string $templateName Template name (dot notation)
     * @param string $filePath Full file path
     */
    protected function compileTemplate($engine, string $templateName, string $filePath): void
    {
        // Get the compiler and cache from the engine
        $compiler = $engine->getCompiler();
        $cache = $engine->getCache();

        // Read the template content
        $content = file_get_contents($filePath);

        // Compile the template
        $compiled = $compiler->compile($content);

        // Store in cache
        $compiledPath = $cache->getCompiledPath($filePath);
        $cache->put($compiledPath, $compiled);
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
