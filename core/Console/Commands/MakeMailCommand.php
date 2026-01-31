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
 *   php sixorbit make:mail Notifications/WelcomeEmail
 *   php sixorbit make:mail WelcomeEmail --force
 *   php sixorbit make:mail WelcomeEmail --dry-run
 */
class MakeMailCommand extends Command
{
    protected string $signature = 'make:mail {name} {--force} {--dry-run}';

    protected string $description = 'Create a new mailable class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Mailable name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Notifications/WelcomeEmail)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Mailable already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildMailable($className, $namespace);

        // Dry run - show what would be created
        if ($this->option('dry-run', false)) {
            $this->comment("Would create: {$relativePath}");
            $this->info("\n" . $content);
            return 0;
        }

        // Create directory if it doesn't exist
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Write file
        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create mailable: {$relativePath}");
            return 1;
        }

        $this->info("Mailable created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Notifications/WelcomeEmail
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Mail';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Mail';
        if (!empty($parts)) {
            $path .= '/' . implode('/', $parts);
        }
        $path .= '/' . $className . '.php';

        return [
            'class' => $className,
            'namespace' => $namespace,
            'path' => $path,
        ];
    }

    /**
     * Build the mailable class content
     */
    protected function buildMailable(string $className, string $namespace): string
    {
        $viewName = $this->toViewName($className);

        return <<<PHP
<?php

namespace {$namespace};

use Core\Mail\Mailable;

/**
 * {$className}
 */
class {$className} extends Mailable
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
            ->subject('{$this->toSubject($className)}')
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
