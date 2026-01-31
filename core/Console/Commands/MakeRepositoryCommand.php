<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Repository Command
 *
 * Generates a new repository class file.
 *
 * Usage:
 *   php sixorbit make:repository UserRepository
 *   php sixorbit make:repository Product/ProductRepository
 *   php sixorbit make:repository UserRepository --force
 *   php sixorbit make:repository UserRepository --dry-run
 */
class MakeRepositoryCommand extends Command
{
    protected string $signature = 'make:repository {name} {--force} {--dry-run}';

    protected string $description = 'Create a new repository class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Repository name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Product/ProductRepository)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Repository already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildRepository($className, $namespace);

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
            $this->error("Failed to create repository: {$relativePath}");
            return 1;
        }

        $this->info("Repository created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Product/ProductRepository
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Repositories';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Repositories';
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
     * Build a repository class with CRUD methods
     */
    protected function buildRepository(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

/**
 * {$className}
 *
 * Repository for data access layer
 */
class {$className}
{
    /**
     * Find a resource by ID
     *
     * @param int \$id
     * @return mixed|null
     */
    public function find(int \$id): mixed
    {
        // Implement find logic
        // Example: return DB::table('table_name')->where('id', \$id)->first();
        return null;
    }

    /**
     * Get all resources
     *
     * @param array \$filters
     * @param int \$limit
     * @param int \$offset
     * @return array
     */
    public function all(array \$filters = [], int \$limit = 100, int \$offset = 0): array
    {
        // Implement fetch all logic with filters, pagination
        // Example: return DB::table('table_name')->limit(\$limit)->offset(\$offset)->get();
        return [];
    }

    /**
     * Create a new resource
     *
     * @param array \$data
     * @return mixed
     */
    public function create(array \$data): mixed
    {
        // Implement create logic
        // Example: return DB::table('table_name')->insert(\$data);
        return null;
    }

    /**
     * Update an existing resource
     *
     * @param int \$id
     * @param array \$data
     * @return bool
     */
    public function update(int \$id, array \$data): bool
    {
        // Implement update logic
        // Example: return DB::table('table_name')->where('id', \$id)->update(\$data);
        return false;
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
        // Example: return DB::table('table_name')->where('id', \$id)->delete();
        return false;
    }

    /**
     * Find resources by specific criteria
     *
     * @param array \$criteria
     * @return array
     */
    public function findBy(array \$criteria): array
    {
        // Implement custom find logic
        // Example: return DB::table('table_name')->where(\$criteria)->get();
        return [];
    }

    /**
     * Count resources matching criteria
     *
     * @param array \$criteria
     * @return int
     */
    public function count(array \$criteria = []): int
    {
        // Implement count logic
        // Example: return DB::table('table_name')->where(\$criteria)->count();
        return 0;
    }
}
PHP;
    }
}
