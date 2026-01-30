<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Mail Command
 *
 * Generates a new mailable class file.
 *
 * Usage:
 *   php sixorbit make:mail WelcomeEmail
 */
class MakeMailCommand extends Command
{
    protected string $signature = 'make:mail {name}';

    protected string $description = 'Create a new mailable class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Mailable name is required.');
            return 1;
        }

        $basePath = getcwd();
        $relativePath = 'app/Mail/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        if (file_exists($filePath)) {
            $this->error("Mailable already exists: {$relativePath}");
            return 1;
        }

        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $content = $this->buildMailable($name);

        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create mailable: {$relativePath}");
            return 1;
        }

        $this->info("Mailable created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build the mailable class content
     */
    protected function buildMailable(string $name): string
    {
        $viewName = $this->toViewName($name);

        return <<<PHP
<?php

namespace App\Mail;

use Core\Mail\Mailable;

/**
 * {$name}
 */
class {$name} extends Mailable
{
    /**
     * Create a new mailable instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return \$this
            ->subject('{$this->toSubject($name)}')
            ->view('{$viewName}');
    }
}
PHP;
    }

    /**
     * Convert a mailable name to a view path
     * e.g., "WelcomeEmail" -> "emails.welcome"
     */
    protected function toViewName(string $name): string
    {
        // Remove common suffixes
        $base = preg_replace('/(Email|Mail|Mailable)$/', '', $name);

        if (empty($base)) {
            $base = $name;
        }

        $snake = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $base));

        return 'emails.' . $snake;
    }

    /**
     * Convert a mailable name to a human-readable subject
     * e.g., "WelcomeEmail" -> "Welcome"
     */
    protected function toSubject(string $name): string
    {
        // Remove common suffixes
        $base = preg_replace('/(Email|Mail|Mailable)$/', '', $name);

        if (empty($base)) {
            $base = $name;
        }

        // Convert PascalCase to words
        return trim(preg_replace('/([a-z])([A-Z])/', '$1 $2', $base));
    }
}
