<?php

namespace Core\Localization;

/**
 * MissingTranslationHandler
 *
 * Tracks and logs missing translations for development and translation management.
 *
 * Features:
 * - Records missing translation keys with context
 * - Logs to file or custom channel
 * - Exports missing keys for translation
 * - Debug mode display with markers
 *
 * Usage:
 * ```php
 * $handler = new MissingTranslationHandler();
 *
 * // Record missing translation
 * $handler->record('messages.welcome', 'fr');
 *
 * // Get all missing translations
 * $missing = $handler->getMissing();
 *
 * // Export to JSON file
 * $handler->export('/path/to/missing.json');
 * ```
 */
class MissingTranslationHandler
{
    /**
     * Missing translations storage
     * Format: [locale => [key => info]]
     */
    protected array $missing = [];

    /**
     * Whether logging is enabled
     */
    protected bool $logEnabled;

    /**
     * Log channel name
     */
    protected string $logChannel;

    /**
     * Debug mode (shows markers on missing keys)
     */
    protected bool $debugMode;

    /**
     * Marker format for missing keys
     */
    protected string $markerFormat;

    /**
     * Maximum entries to keep in memory
     */
    protected int $maxEntries;

    /**
     * File path for persistent logging
     */
    protected ?string $logFile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->logEnabled = config('localization.log_missing', true);
        $this->logChannel = config('localization.missing_log_channel', 'translations');
        $this->debugMode = config('app.debug', false);
        $this->markerFormat = config('localization.missing_marker', '[[%s]]');
        $this->maxEntries = config('localization.missing_max_entries', 1000);
        $this->logFile = config('localization.missing_log_file', null);
    }

    /**
     * Record a missing translation
     *
     * @param string $key Translation key
     * @param string $locale Locale that's missing the key
     * @param string|null $fallback Fallback value used (if any)
     * @param array $context Additional context (file, line, etc.)
     */
    public function record(string $key, string $locale, ?string $fallback = null, array $context = []): void
    {
        // Check if already recorded (avoid duplicates)
        if (isset($this->missing[$locale][$key])) {
            $this->missing[$locale][$key]['count']++;
            return;
        }

        // Enforce max entries limit
        if ($this->countTotal() >= $this->maxEntries) {
            $this->pruneOldest();
        }

        // Record the missing translation
        $entry = [
            'key' => $key,
            'locale' => $locale,
            'fallback' => $fallback,
            'timestamp' => date('Y-m-d H:i:s'),
            'count' => 1,
            'context' => $context,
        ];

        $this->missing[$locale][$key] = $entry;

        // Log if enabled
        if ($this->logEnabled) {
            $this->log($entry);
        }

        // Write to file if configured
        if ($this->logFile) {
            $this->appendToFile($entry);
        }
    }

    /**
     * Log missing translation
     *
     * @param array $entry Entry data
     */
    protected function log(array $entry): void
    {
        if (!function_exists('logger')) {
            return;
        }

        $message = sprintf(
            'Missing translation: %s [locale: %s]',
            $entry['key'],
            $entry['locale']
        );

        logger()->channel($this->logChannel)->warning($message, [
            'key' => $entry['key'],
            'locale' => $entry['locale'],
            'fallback' => $entry['fallback'],
            'context' => $entry['context'],
        ]);
    }

    /**
     * Append entry to log file
     *
     * @param array $entry Entry data
     */
    protected function appendToFile(array $entry): void
    {
        try {
            $line = json_encode($entry) . "\n";
            file_put_contents($this->logFile, $line, FILE_APPEND | LOCK_EX);
        } catch (\Exception $e) {
            // Silently fail if can't write to file
        }
    }

    /**
     * Get all missing translations
     *
     * @param string|null $locale Filter by locale (null = all)
     * @return array Missing translations
     */
    public function getMissing(?string $locale = null): array
    {
        if ($locale !== null) {
            return $this->missing[$locale] ?? [];
        }

        return $this->missing;
    }

    /**
     * Get missing keys only
     *
     * @param string|null $locale Filter by locale
     * @return array Array of missing keys
     */
    public function getMissingKeys(?string $locale = null): array
    {
        if ($locale !== null) {
            return array_keys($this->missing[$locale] ?? []);
        }

        $keys = [];
        foreach ($this->missing as $localeData) {
            $keys = array_merge($keys, array_keys($localeData));
        }

        return array_unique($keys);
    }

    /**
     * Check if key is missing for locale
     *
     * @param string $key Translation key
     * @param string $locale Locale
     * @return bool
     */
    public function isMissing(string $key, string $locale): bool
    {
        return isset($this->missing[$locale][$key]);
    }

    /**
     * Get count of missing translations
     *
     * @param string|null $locale Filter by locale
     * @return int Count
     */
    public function count(?string $locale = null): int
    {
        if ($locale !== null) {
            return count($this->missing[$locale] ?? []);
        }

        return $this->countTotal();
    }

    /**
     * Count total missing entries
     *
     * @return int
     */
    protected function countTotal(): int
    {
        $total = 0;
        foreach ($this->missing as $localeData) {
            $total += count($localeData);
        }
        return $total;
    }

    /**
     * Prune oldest entries when limit exceeded
     */
    protected function pruneOldest(): void
    {
        // Flatten all entries with timestamps
        $allEntries = [];
        foreach ($this->missing as $locale => $keys) {
            foreach ($keys as $key => $entry) {
                $allEntries[] = [
                    'locale' => $locale,
                    'key' => $key,
                    'timestamp' => $entry['timestamp'],
                ];
            }
        }

        // Sort by timestamp (oldest first)
        usort($allEntries, function ($a, $b) {
            return strcmp($a['timestamp'], $b['timestamp']);
        });

        // Remove oldest 10%
        $removeCount = (int) ($this->maxEntries * 0.1);
        for ($i = 0; $i < $removeCount && $i < count($allEntries); $i++) {
            $entry = $allEntries[$i];
            unset($this->missing[$entry['locale']][$entry['key']]);
        }
    }

    /**
     * Export missing translations to JSON file
     *
     * @param string $path Export file path
     * @param bool $grouped Group by locale (default) or flat
     * @return bool Success
     */
    public function export(string $path, bool $grouped = true): bool
    {
        try {
            $data = $grouped ? $this->missing : $this->flatten();

            $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            return file_put_contents($path, $json) !== false;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Flatten missing translations into simple array
     *
     * @return array Flat array of missing entries
     */
    protected function flatten(): array
    {
        $flat = [];

        foreach ($this->missing as $locale => $keys) {
            foreach ($keys as $key => $entry) {
                $flat[] = array_merge($entry, ['locale' => $locale, 'key' => $key]);
            }
        }

        return $flat;
    }

    /**
     * Export to translation file format
     *
     * Creates a PHP translation file with empty values for missing keys.
     *
     * @param string $locale Locale to export
     * @param string $group Translation group
     * @param string $path Output file path
     * @return bool Success
     */
    public function exportAsTranslationFile(string $locale, string $group, string $path): bool
    {
        $missingForLocale = $this->missing[$locale] ?? [];

        // Filter by group prefix
        $prefix = $group . '.';
        $translations = [];

        foreach ($missingForLocale as $key => $entry) {
            if (str_starts_with($key, $prefix)) {
                $shortKey = substr($key, strlen($prefix));
                $translations[$shortKey] = ''; // Empty for translation
            }
        }

        if (empty($translations)) {
            return false;
        }

        $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";

        return file_put_contents($path, $content) !== false;
    }

    /**
     * Clear all recorded missing translations
     *
     * @param string|null $locale Clear only specific locale
     */
    public function clear(?string $locale = null): void
    {
        if ($locale !== null) {
            unset($this->missing[$locale]);
        } else {
            $this->missing = [];
        }
    }

    /**
     * Format missing key for display in debug mode
     *
     * @param string $key Translation key
     * @return string Formatted key
     */
    public function formatForDebug(string $key): string
    {
        if (!$this->debugMode) {
            return $key;
        }

        return sprintf($this->markerFormat, $key);
    }

    /**
     * Get display value for missing translation
     *
     * @param string $key Translation key
     * @param string|null $fallback Fallback value
     * @return string Display value
     */
    public function getDisplayValue(string $key, ?string $fallback = null): string
    {
        // If we have a fallback, use it
        if ($fallback !== null) {
            return $fallback;
        }

        // In debug mode, show marked key
        if ($this->debugMode) {
            return $this->formatForDebug($key);
        }

        // In production, just return the key
        return $key;
    }

    /**
     * Load missing translations from file
     *
     * @param string $path File path
     * @return bool Success
     */
    public function loadFromFile(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }

        try {
            $content = file_get_contents($path);
            $data = json_decode($content, true);

            if (is_array($data)) {
                $this->missing = array_merge($this->missing, $data);
                return true;
            }

        } catch (\Exception $e) {
            // Silently fail
        }

        return false;
    }

    /**
     * Get statistics about missing translations
     *
     * @return array Statistics
     */
    public function getStatistics(): array
    {
        $stats = [
            'total' => $this->countTotal(),
            'by_locale' => [],
            'by_group' => [],
            'most_missing' => [],
        ];

        foreach ($this->missing as $locale => $keys) {
            $stats['by_locale'][$locale] = count($keys);

            foreach ($keys as $key => $entry) {
                // Extract group from key
                $parts = explode('.', $key);
                $group = $parts[0];

                if (!isset($stats['by_group'][$group])) {
                    $stats['by_group'][$group] = 0;
                }
                $stats['by_group'][$group]++;
            }
        }

        // Sort by count descending
        arsort($stats['by_locale']);
        arsort($stats['by_group']);

        return $stats;
    }

    /**
     * Check if debug mode is enabled
     *
     * @return bool
     */
    public function isDebugMode(): bool
    {
        return $this->debugMode;
    }

    /**
     * Check if there are any missing translations
     *
     * @param string|null $locale Filter by locale
     * @return bool
     */
    public function hasMissing(?string $locale = null): bool
    {
        if ($locale !== null) {
            return !empty($this->missing[$locale]);
        }

        return !empty($this->missing);
    }

    /**
     * Check if missing translation logging is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->logEnabled;
    }

    /**
     * Enable or disable logging
     *
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->logEnabled = $enabled;
    }

    /**
     * Enable/disable debug mode
     *
     * @param bool $enabled
     */
    public function setDebugMode(bool $enabled): void
    {
        $this->debugMode = $enabled;
    }
}
