<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * MakeTranslationCommand
 *
 * Creates a new translation file for a specified locale and group.
 *
 * Usage:
 *   php sixorbit make:translation messages --locale=fr
 *   php sixorbit make:translation validation --locale=de --force
 */
class MakeTranslationCommand extends Command
{
    /**
     * Command name
     */
    protected string $name = 'make:translation';

    /**
     * Command description
     */
    protected string $description = 'Create a new translation file';

    /**
     * Command signature with arguments and options
     */
    protected string $signature = 'make:translation {group : Translation group name} {--locale=en : Locale code} {--force : Overwrite existing file}';

    /**
     * Execute the command
     *
     * @return int Exit code
     */
    public function handle(): int
    {
        $group = $this->argument(0);
        $locale = $this->option('locale', 'en');
        $force = $this->option('force', false);

        if (!$group) {
            $this->error('Translation group name is required.');
            $this->line('Usage: php sixorbit make:translation {group} --locale=en');
            return 1;
        }

        // Validate group name
        if (!preg_match('/^[a-z][a-z0-9_-]*$/i', $group)) {
            $this->error('Invalid group name. Use only letters, numbers, underscores, and hyphens.');
            return 1;
        }

        // Build file path
        $basePath = base_path('resources/lang');
        $localePath = $basePath . '/' . $locale;
        $filePath = $localePath . '/' . $group . '.php';

        // Check if file exists
        if (file_exists($filePath) && !$force) {
            $this->error("Translation file already exists: {$filePath}");
            $this->line('Use --force to overwrite.');
            return 1;
        }

        // Create locale directory if needed
        if (!is_dir($localePath)) {
            if (!mkdir($localePath, 0755, true)) {
                $this->error("Failed to create directory: {$localePath}");
                return 1;
            }
            $this->info("Created locale directory: {$locale}");
        }

        // Generate file content
        $content = $this->buildTemplate($group, $locale);

        // Write file
        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to write file: {$filePath}");
            return 1;
        }

        $this->success("Created translation file: {$filePath}");

        // Show next steps
        $this->line('');
        $this->line('Next steps:');
        $this->line("  1. Add your translations to {$group}.php");
        $this->line("  2. Use in code: __(\"{$group}.key_name\")");

        return 0;
    }

    /**
     * Build translation file template
     *
     * @param string $group Group name
     * @param string $locale Locale code
     * @return string File content
     */
    protected function buildTemplate(string $group, string $locale): string
    {
        $groupTitle = ucfirst(str_replace(['_', '-'], ' ', $group));
        $date = date('Y-m-d');

        return <<<PHP
<?php

/**
 * {$groupTitle} Translations
 *
 * Locale: {$locale}
 * Created: {$date}
 *
 * Usage:
 *   __("{$group}.key_name")
 *   __("{$group}.greeting", ["name" => "John"])
 *   trans_choice("{$group}.items", 5)
 */

return [
    // Add your translations here
    // 'key' => 'Translation text',

    // Example simple translation
    // 'welcome' => 'Welcome to our application',

    // Example with placeholder
    // 'greeting' => 'Hello, :name!',

    // Example plural forms (pipe-separated)
    // 'items' => ':count item|:count items',

    // Example CLDR plural forms
    // 'messages' => '{one} :count message|{other} :count messages',
];

PHP;
    }
}
