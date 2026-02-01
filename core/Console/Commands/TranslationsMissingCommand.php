<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * TranslationsMissingCommand
 *
 * Finds missing translations across locales by comparing against a base locale.
 *
 * Usage:
 *   php sixorbit translations:missing
 *   php sixorbit translations:missing --locale=fr
 *   php sixorbit translations:missing --group=messages --export=missing.json
 */
class TranslationsMissingCommand extends Command
{
    /**
     * Command name
     */
    protected string $name = 'translations:missing';

    /**
     * Command description
     */
    protected string $description = 'Find missing translations across locales';

    /**
     * Command signature
     */
    protected string $signature = 'translations:missing {--locale= : Target locale to check} {--group= : Specific group to check} {--base=en : Base locale to compare against} {--export= : Export results to JSON file}';

    /**
     * Execute the command
     *
     * @return int Exit code
     */
    public function handle(): int
    {
        $baseLocale = $this->option('base', config('localization.fallback_locale', 'en'));
        $targetLocale = $this->option('locale');
        $targetGroup = $this->option('group');
        $exportPath = $this->option('export');

        $langPath = base_path('resources/lang');

        // Get all available locales
        $locales = $this->getAvailableLocales($langPath);

        if (empty($locales)) {
            $this->error('No translation files found in resources/lang/');
            return 1;
        }

        if (!in_array($baseLocale, $locales)) {
            $this->error("Base locale '{$baseLocale}' not found.");
            return 1;
        }

        // Filter target locales
        if ($targetLocale) {
            if (!in_array($targetLocale, $locales)) {
                $this->error("Target locale '{$targetLocale}' not found.");
                return 1;
            }
            $locales = [$targetLocale];
        } else {
            $locales = array_diff($locales, [$baseLocale]);
        }

        // Get groups to check
        $groups = $targetGroup ? [$targetGroup] : $this->getGroups($langPath, $baseLocale);

        $this->info("Comparing against base locale: {$baseLocale}");
        $this->line('');

        $missing = [];
        $totalMissing = 0;

        foreach ($locales as $locale) {
            $localeMissing = [];

            foreach ($groups as $group) {
                $baseKeys = $this->getTranslationKeys($langPath, $baseLocale, $group);
                $targetKeys = $this->getTranslationKeys($langPath, $locale, $group);

                $missingKeys = array_diff($baseKeys, $targetKeys);

                if (!empty($missingKeys)) {
                    $localeMissing[$group] = array_values($missingKeys);
                    $totalMissing += count($missingKeys);
                }
            }

            if (!empty($localeMissing)) {
                $missing[$locale] = $localeMissing;
            }
        }

        // Output results
        if (empty($missing)) {
            $this->success('No missing translations found!');
            return 0;
        }

        foreach ($missing as $locale => $groups) {
            $this->comment("\n[{$locale}]");

            foreach ($groups as $group => $keys) {
                $this->line("  {$group}:");
                foreach ($keys as $key) {
                    $this->line("    - {$key}");
                }
            }
        }

        $this->line('');
        $this->info("Total missing: {$totalMissing} key(s)");

        // Export if requested
        if ($exportPath) {
            $exportData = [
                'base_locale' => $baseLocale,
                'generated_at' => date('Y-m-d H:i:s'),
                'total_missing' => $totalMissing,
                'missing' => $missing,
            ];

            if (file_put_contents($exportPath, json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                $this->success("Exported to: {$exportPath}");
            } else {
                $this->error("Failed to export to: {$exportPath}");
            }
        }

        return 0;
    }

    /**
     * Get available locales
     *
     * @param string $langPath Base language path
     * @return array Locale codes
     */
    protected function getAvailableLocales(string $langPath): array
    {
        $locales = [];

        if (!is_dir($langPath)) {
            return $locales;
        }

        foreach (scandir($langPath) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $itemPath = $langPath . '/' . $item;
            if (is_dir($itemPath)) {
                $locales[] = $item;
            }
        }

        return $locales;
    }

    /**
     * Get translation groups for a locale
     *
     * @param string $langPath Base language path
     * @param string $locale Locale code
     * @return array Group names
     */
    protected function getGroups(string $langPath, string $locale): array
    {
        $groups = [];
        $localePath = $langPath . '/' . $locale;

        if (!is_dir($localePath)) {
            return $groups;
        }

        foreach (scandir($localePath) as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $groups[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }

        return $groups;
    }

    /**
     * Get all translation keys for a group
     *
     * @param string $langPath Base language path
     * @param string $locale Locale code
     * @param string $group Group name
     * @return array Flattened key names
     */
    protected function getTranslationKeys(string $langPath, string $locale, string $group): array
    {
        $filePath = $langPath . '/' . $locale . '/' . $group . '.php';

        if (!file_exists($filePath)) {
            return [];
        }

        $translations = require $filePath;

        if (!is_array($translations)) {
            return [];
        }

        return $this->flattenKeys($translations);
    }

    /**
     * Flatten nested translation keys
     *
     * @param array $array Translations array
     * @param string $prefix Key prefix
     * @return array Flattened keys
     */
    protected function flattenKeys(array $array, string $prefix = ''): array
    {
        $keys = [];

        foreach ($array as $key => $value) {
            $fullKey = $prefix ? $prefix . '.' . $key : $key;

            if (is_array($value)) {
                $keys = array_merge($keys, $this->flattenKeys($value, $fullKey));
            } else {
                $keys[] = $fullKey;
            }
        }

        return $keys;
    }
}
