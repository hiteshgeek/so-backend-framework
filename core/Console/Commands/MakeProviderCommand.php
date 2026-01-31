<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Provider Command
 *
 * Generates a new service provider class file.
 *
 * Usage:
 *   php sixorbit make:provider PaymentServiceProvider
 *   php sixorbit make:provider Services/PaymentServiceProvider
 *   php sixorbit make:provider PaymentServiceProvider --force
 *   php sixorbit make:provider PaymentServiceProvider --dry-run
 */
class MakeProviderCommand extends Command
{
    protected string $signature = 'make:provider {name} {--force} {--dry-run}';

    protected string $description = 'Create a new service provider class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Provider name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Services/PaymentServiceProvider)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Provider already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildProvider($className, $namespace);

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
            $this->error("Failed to create provider: {$relativePath}");
            return 1;
        }

        $this->info("Provider created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Services/PaymentServiceProvider
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Providers';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Providers';
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
     * Build the service provider class content
     */
    protected function buildProvider(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Core\Container\Container;

/**
 * {$className}
 */
class {$className}
{
    protected Container \$app;

    public function __construct(Container \$app)
    {
        \$this->app = \$app;
    }

    /**
     * Register the service in the container.
     */
    public function register(): void
    {
        //
    }

    /**
     * Boot the service.
     */
    public function boot(): void
    {
        //
    }
}
PHP;
    }
}
