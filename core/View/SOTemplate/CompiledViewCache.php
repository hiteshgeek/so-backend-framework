<?php

namespace Core\View\SOTemplate;

/**
 * Compiled View Cache Manager
 *
 * Manages the caching of compiled SOTemplate templates for optimal performance.
 * Compiled templates are stored as PHP files that can be opcached.
 */
class CompiledViewCache
{
    /**
     * Path to store compiled templates
     */
    protected string $cachePath;

    /**
     * Whether to auto-reload templates when source changes
     */
    protected bool $autoReload;

    /**
     * Whether caching is enabled
     */
    protected bool $enabled;

    /**
     * Create a new cache manager
     */
    public function __construct(string $cachePath, bool $autoReload = false, bool $enabled = true)
    {
        $this->cachePath = rtrim($cachePath, '/');
        $this->autoReload = $autoReload;
        $this->enabled = $enabled;

        // Ensure cache directory exists
        if ($this->enabled && !is_dir($this->cachePath)) {
            @mkdir($this->cachePath, 0755, true);
        }
    }

    /**
     * Get the compiled path for a template
     */
    public function getCompiledPath(string $templatePath): string
    {
        // Use hash of the full path for uniqueness
        $hash = md5($templatePath);
        return $this->cachePath . '/' . $hash . '.php';
    }

    /**
     * Check if a template needs recompilation
     */
    public function isExpired(string $templatePath, ?string $compiledPath = null): bool
    {
        if (!$this->enabled) {
            return true;
        }

        $compiledPath = $compiledPath ?? $this->getCompiledPath($templatePath);

        // If compiled file doesn't exist, it's expired
        if (!file_exists($compiledPath)) {
            return true;
        }

        // If auto-reload is disabled, always use cache
        if (!$this->autoReload) {
            return false;
        }

        // Check if source is newer than compiled
        return filemtime($templatePath) > filemtime($compiledPath);
    }

    /**
     * Store compiled content
     */
    public function put(string $compiledPath, string $contents): bool
    {
        if (!$this->enabled) {
            return false;
        }

        // Ensure directory exists
        $dir = dirname($compiledPath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        // Write with exclusive lock
        $result = file_put_contents($compiledPath, $contents, LOCK_EX);

        // Invalidate opcache for this file
        if ($result !== false && function_exists('opcache_invalidate')) {
            opcache_invalidate($compiledPath, true);
        }

        return $result !== false;
    }

    /**
     * Get compiled content if it exists and is fresh
     */
    public function get(string $templatePath): ?string
    {
        $compiledPath = $this->getCompiledPath($templatePath);

        if ($this->isExpired($templatePath, $compiledPath)) {
            return null;
        }

        return file_get_contents($compiledPath);
    }

    /**
     * Check if a compiled template exists
     */
    public function exists(string $templatePath): bool
    {
        return file_exists($this->getCompiledPath($templatePath));
    }

    /**
     * Delete a specific compiled template
     */
    public function forget(string $templatePath): bool
    {
        $compiledPath = $this->getCompiledPath($templatePath);

        if (file_exists($compiledPath)) {
            // Invalidate opcache
            if (function_exists('opcache_invalidate')) {
                opcache_invalidate($compiledPath, true);
            }
            return unlink($compiledPath);
        }

        return true;
    }

    /**
     * Clear all compiled templates
     */
    public function clear(): int
    {
        $count = 0;

        if (!is_dir($this->cachePath)) {
            return $count;
        }

        $files = glob($this->cachePath . '/*.php');

        foreach ($files as $file) {
            if (is_file($file)) {
                // Invalidate opcache
                if (function_exists('opcache_invalidate')) {
                    opcache_invalidate($file, true);
                }
                unlink($file);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get cache statistics
     */
    public function stats(): array
    {
        if (!is_dir($this->cachePath)) {
            return [
                'count' => 0,
                'size' => 0,
                'oldest' => null,
                'newest' => null,
            ];
        }

        $files = glob($this->cachePath . '/*.php');
        $count = count($files);
        $size = 0;
        $oldest = null;
        $newest = null;

        foreach ($files as $file) {
            $size += filesize($file);
            $mtime = filemtime($file);

            if ($oldest === null || $mtime < $oldest) {
                $oldest = $mtime;
            }
            if ($newest === null || $mtime > $newest) {
                $newest = $mtime;
            }
        }

        return [
            'count' => $count,
            'size' => $size,
            'size_human' => $this->formatBytes($size),
            'oldest' => $oldest ? date('Y-m-d H:i:s', $oldest) : null,
            'newest' => $newest ? date('Y-m-d H:i:s', $newest) : null,
            'path' => $this->cachePath,
            'auto_reload' => $this->autoReload,
            'enabled' => $this->enabled,
        ];
    }

    /**
     * Format bytes to human readable
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get cache path
     */
    public function getCachePath(): string
    {
        return $this->cachePath;
    }

    /**
     * Check if auto-reload is enabled
     */
    public function isAutoReloadEnabled(): bool
    {
        return $this->autoReload;
    }

    /**
     * Check if caching is enabled
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
