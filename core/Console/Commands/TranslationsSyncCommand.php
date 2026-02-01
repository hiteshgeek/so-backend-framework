<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * TranslationsSyncCommand
 *
 * Synchronizes translation keys from a source locale to target locales.
 * Creates missing files and adds missing keys with empty values for translation.
 *
 * Usage:
 *   php sixorbit translations:sync --from=en --to=fr
 *   php sixorbit translations:sync --from=en --to=all
 *   php sixorbit translations:sync --from=en --to=fr --group=messages
 */
class TranslationsSyncCommand extends Command
{
    /**
     * Command name
     */
    protected string $name = 'translations:sync';

    /**
     * Command description
     */
    protected string $description = 'Sync translation keys from source to target locale';

    /**
     * Command signature
     */
    protected string $signature = 'translations:sync {--from=en : Source locale} {--to= : Target locale (or "all")} {--group= : Specific group to sync} {--dry-run : Show what would be done without making changes}';

    /**
     * Execute the command
     *
     * @return int Exit code
     */
    public function handle(): int
    {
        $sourceLocale = $this->option('from', 'en');
        $targetLocale = $this->option('to');
        $targetGroup = $this->option('group');
        $dryRun = $this->option('dry-run', false);

        if (!$targetLocale) {
            $this->error('Target locale is required. Use --to=locale or --to=all');
            return 1;
        }

        $langPath = base_path('resources/lang');
        $sourcePath = $langPath . '/' . $sourceLocale;

        if (!is_dir($sourcePath)) {
            $this->error("Source locale directory not found: {$sourcePath}");
            return 1;
        }

        // Get target locales
        if ($targetLocale === 'all') {
            $targetLocales = $this->getAvailableLocales($langPath);
            $targetLocales = array_diff($targetLocales, [$sourceLocale]);
        } else {
            $targetLocales = [$targetLocale];
        }

        if (empty($targetLocales)) {
            $this->error('No target locales found.');
            return 1;
        }

        // Get groups to sync
        $groups = $targetGroup ? [$targetGroup] : $this->getGroups($langPath, $sourceLocale);

        if (empty($groups)) {
            $this->error('No translation groups found in source locale.');
            return 1;
        }

        if ($dryRun) {
            $this->comment('[DRY RUN] No changes will be made.');
            $this->line('');
        }

        $this->info("Syncing from: {$sourceLocale}");
        $this->info("Target locales: " . implode(', ', $targetLocales));
        $this->line('');

        $stats = [
            'files_created' => 0,
            'files_updated' => 0,
            'keys_added' => 0,
        ];

        foreach ($targetLocales as $locale) {
            $this->comment("[{$locale}]");
            $localePath = $langPath . '/' . $locale;

            // Create locale directory if needed
            if (!is_dir($localePath)) {
                if (!$dryRun) {
                    mkdir($localePath, 0755, true);
                }
                $this->line("  Created directory: {$locale}/");
            }

            foreach ($groups as $group) {
                $sourceFile = $sourcePath . '/' . $group . '.php';
                $targetFile = $localePath . '/' . $group . '.php';

                if (!file_exists($sourceFile)) {
                    continue;
                }

                $sourceTranslations = require $sourceFile;
                $targetTranslations = file_exists($targetFile) ? require $targetFile : [];

                // Find missing keys
                $sourceKeys = $this->flattenKeys($sourceTranslations);
                $targetKeys = $this->flattenKeys($targetTranslations);
                $missingKeys = array_diff($sourceKeys, $targetKeys);

                if (empty($missingKeys)) {
                    continue;
                }

                $fileExists = file_exists($targetFile);

                // Add missing keys with TODO markers
                foreach ($missingKeys as $key) {
                    $value = $this->getNestedValue($sourceTranslations, $key);
                    $targetTranslations = $this->setNestedValue($targetTranslations, $key, 'TODO: ' . $value);
                    $stats['keys_added']++;
                }

                if (!$dryRun) {
                    $this->writeTranslationFile($targetFile, $targetTranslations, $group, $locale);
                }

                if ($fileExists) {
                    $stats['files_updated']++;
                    $this->line("  Updated: {$group}.php (" . count($missingKeys) . " keys)");
                } else {
                    $stats['files_created']++;
                    $this->line("  Created: {$group}.php (" . count($missingKeys) . " keys)");
                }
            }
        }

        $this->line('');
        $this->success("Sync complete!");
        $this->line("  Files created: {$stats['files_created']}");
        $this->line("  Files updated: {$stats['files_updated']}");
        $this->line("  Keys added: {$stats['keys_added']}");

        if ($stats['keys_added'] > 0) {
            $this->line('');
            $this->comment('Note: Added keys are prefixed with "TODO: " for easy identification.');
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

            if (is_dir($langPath . '/' . $item)) {
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

    /**
     * Get nested array value by dot notation key
     *
     * @param array $array Source array
     * @param string $key Dot notation key
     * @return mixed Value
     */
    protected function getNestedValue(array $array, string $key): mixed
    {
        $keys = explode('.', $key);
        $value = $array;

        foreach ($keys as $k) {
            if (!is_array($value) || !isset($value[$k])) {
                return null;
            }
            $value = $value[$k];
        }

        return $value;
    }

    /**
     * Set nested array value by dot notation key
     *
     * @param array $array Target array
     * @param string $key Dot notation key
     * @param mixed $value Value to set
     * @return array Modified array
     */
    protected function setNestedValue(array $array, string $key, mixed $value): array
    {
        $keys = explode('.', $key);
        $current = &$array;

        foreach ($keys as $i => $k) {
            if ($i === count($keys) - 1) {
                $current[$k] = $value;
            } else {
                if (!isset($current[$k]) || !is_array($current[$k])) {
                    $current[$k] = [];
                }
                $current = &$current[$k];
            }
        }

        return $array;
    }

    /**
     * Write translation array to file
     *
     * @param string $path File path
     * @param array $translations Translations array
     * @param string $group Group name
     * @param string $locale Locale code
     * @return bool Success
     */
    protected function writeTranslationFile(string $path, array $translations, string $group, string $locale): bool
    {
        $groupTitle = ucfirst(str_replace(['_', '-'], ' ', $group));
        $date = date('Y-m-d H:i:s');

        $export = var_export($translations, true);

        // Clean up the var_export output
        $export = preg_replace('/^(\s*)array \(/m', '$1[', $export);
        $export = preg_replace('/\)$/m', ']', $export);
        $export = str_replace("=> \n", '=> ', $export);

        $content = <<<PHP
<?php

/**
 * {$groupTitle} Translations
 *
 * Locale: {$locale}
 * Updated: {$date}
 */

return {$export};

PHP;

        return file_put_contents($path, $content) !== false;
    }
}
