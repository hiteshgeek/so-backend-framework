<?php

namespace Core\Localization;

/**
 * TranslationLoader
 *
 * Loads translation files from disk with namespace support.
 * Supports PHP array files and caching for performance.
 */
class TranslationLoader
{
    /**
     * Registered namespaces and their paths
     */
    protected array $namespaces = [];

    /**
     * Constructor
     *
     * @param string|null $basePath Base path to resources/lang (for testing)
     */
    public function __construct(?string $basePath = null)
    {
        // Use provided path or default to base_path() helper
        if ($basePath !== null) {
            $this->namespaces['*'] = $basePath;
        } else {
            $this->namespaces['*'] = base_path('resources/lang');
        }
    }

    /**
     * Load translation group for locale
     *
     * @param string $locale Locale code (e.g., 'en', 'fr')
     * @param string $group Group name (e.g., 'validation', 'auth')
     * @param string|null $namespace Namespace (default: '*')
     * @return array Translation array
     */
    public function load(string $locale, string $group, ?string $namespace = null): array
    {
        $namespace = $namespace ?? '*';

        // Get namespace path
        if (!isset($this->namespaces[$namespace])) {
            return [];
        }

        $path = $this->namespaces[$namespace];

        // Build file path: resources/lang/en/validation.php
        $filePath = $path . '/' . $locale . '/' . $group . '.php';

        // Load file if exists
        if (file_exists($filePath)) {
            return $this->loadFile($filePath);
        }

        // Try JSON file as fallback: resources/lang/en/validation.json
        $jsonPath = $path . '/' . $locale . '/' . $group . '.json';
        if (file_exists($jsonPath)) {
            return $this->loadJsonFile($jsonPath);
        }

        return [];
    }

    /**
     * Add namespace for translations
     *
     * @param string $namespace Namespace identifier
     * @param string $path Path to translation files
     * @return void
     */
    public function addNamespace(string $namespace, string $path): void
    {
        $this->namespaces[$namespace] = $path;
    }

    /**
     * Get registered namespaces
     *
     * @return array
     */
    public function namespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * Load PHP translation file
     *
     * @param string $filePath Full path to translation file
     * @return array
     */
    protected function loadFile(string $filePath): array
    {
        try {
            $translations = require $filePath;

            // Ensure it returns an array
            if (!is_array($translations)) {
                return [];
            }

            return $translations;
        } catch (\Throwable $e) {
            // Log error if logging is available
            if (function_exists('error_log')) {
                error_log("Translation file error: {$filePath} - {$e->getMessage()}");
            }

            return [];
        }
    }

    /**
     * Load JSON translation file
     *
     * @param string $filePath Full path to JSON file
     * @return array
     */
    protected function loadJsonFile(string $filePath): array
    {
        try {
            $content = file_get_contents($filePath);

            if ($content === false) {
                return [];
            }

            $translations = json_decode($content, true);

            // Ensure valid JSON and array result
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($translations)) {
                return [];
            }

            return $translations;
        } catch (\Throwable $e) {
            // Log error if logging is available
            if (function_exists('error_log')) {
                error_log("Translation JSON error: {$filePath} - {$e->getMessage()}");
            }

            return [];
        }
    }

    /**
     * Check if translation file exists
     *
     * @param string $locale Locale code
     * @param string $group Group name
     * @param string|null $namespace Namespace
     * @return bool
     */
    public function exists(string $locale, string $group, ?string $namespace = null): bool
    {
        $namespace = $namespace ?? '*';

        if (!isset($this->namespaces[$namespace])) {
            return false;
        }

        $path = $this->namespaces[$namespace];
        $filePath = $path . '/' . $locale . '/' . $group . '.php';
        $jsonPath = $path . '/' . $locale . '/' . $group . '.json';

        return file_exists($filePath) || file_exists($jsonPath);
    }

    /**
     * Get available locales
     *
     * Scans the translation directory to find available locales
     *
     * @param string|null $namespace Namespace (default: '*')
     * @return array Array of locale codes
     */
    public function getAvailableLocales(?string $namespace = null): array
    {
        $namespace = $namespace ?? '*';

        if (!isset($this->namespaces[$namespace])) {
            return [];
        }

        $path = $this->namespaces[$namespace];

        if (!is_dir($path)) {
            return [];
        }

        $locales = [];
        $directories = scandir($path);

        foreach ($directories as $dir) {
            // Skip hidden and parent directories
            if ($dir === '.' || $dir === '..' || str_starts_with($dir, '.')) {
                continue;
            }

            $fullPath = $path . '/' . $dir;

            // Check if it's a directory
            if (is_dir($fullPath)) {
                $locales[] = $dir;
            }
        }

        return $locales;
    }

    /**
     * Get available groups for a locale
     *
     * @param string $locale Locale code
     * @param string|null $namespace Namespace
     * @return array Array of group names
     */
    public function getAvailableGroups(string $locale, ?string $namespace = null): array
    {
        $namespace = $namespace ?? '*';

        if (!isset($this->namespaces[$namespace])) {
            return [];
        }

        $path = $this->namespaces[$namespace] . '/' . $locale;

        if (!is_dir($path)) {
            return [];
        }

        $groups = [];
        $files = scandir($path);

        foreach ($files as $file) {
            // Skip hidden files and parent directories
            if ($file === '.' || $file === '..' || str_starts_with($file, '.')) {
                continue;
            }

            // Get file extension
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            // Only accept .php and .json files
            if (in_array($ext, ['php', 'json'])) {
                $groups[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }

        return array_unique($groups);
    }
}
