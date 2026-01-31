<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Event Command
 *
 * Generates a new event class file.
 *
 * Usage:
 *   php sixorbit make:event UserRegistered
 *   php sixorbit make:event Auth/UserRegistered
 *   php sixorbit make:event UserRegistered --force
 *   php sixorbit make:event UserRegistered --dry-run
 */
class MakeEventCommand extends Command
{
    protected string $signature = 'make:event {name} {--force} {--dry-run}';

    protected string $description = 'Create a new event class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Event name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Auth/UserRegistered)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Event already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildEvent($className, $namespace);

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
            $this->error("Failed to create event: {$relativePath}");
            return 1;
        }

        $this->info("Event created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Auth/UserRegistered
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Events';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Events';
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
     * Build the event class content
     */
    protected function buildEvent(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Core\Events\Event;

/**
 * {$className} Event
 */
class {$className} extends Event
{
    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }
}
PHP;
    }
}
