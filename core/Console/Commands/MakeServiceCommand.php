<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Service Command
 *
 * Generates a new service class file.
 *
 * Usage:
 *   php sixorbit make:service UserService
 *   php sixorbit make:service Payment/StripeService
 *   php sixorbit make:service UserService --force
 *   php sixorbit make:service UserService --dry-run
 */
class MakeServiceCommand extends Command
{
    protected string $signature = 'make:service {name} {--force} {--dry-run}';

    protected string $description = 'Create a new service class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Service name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Payment/StripeService)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Service already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildService($className, $namespace);

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
            $this->error("Failed to create service: {$relativePath}");
            return 1;
        }

        $this->info("Service created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Payment/StripeService
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Services';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Services';
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
     * Build a service class with basic CRUD methods
     */
    protected function buildService(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

/**
 * {$className}
 *
 * Service layer for business logic
 */
class {$className}
{
    /**
     * Create a new resource
     *
     * @param array \$data
     * @return mixed
     */
    public function create(array \$data): mixed
    {
        // Implement create logic
    }

    /**
     * Find a resource by ID
     *
     * @param int \$id
     * @return mixed
     */
    public function find(int \$id): mixed
    {
        // Implement find logic
    }

    /**
     * Get all resources
     *
     * @param array \$filters
     * @return array
     */
    public function all(array \$filters = []): array
    {
        // Implement list logic
    }

    /**
     * Update a resource
     *
     * @param int \$id
     * @param array \$data
     * @return mixed
     */
    public function update(int \$id, array \$data): mixed
    {
        // Implement update logic
    }

    /**
     * Delete a resource
     *
     * @param int \$id
     * @return bool
     */
    public function delete(int \$id): bool
    {
        // Implement delete logic
        return true;
    }
}
PHP;
    }
}
