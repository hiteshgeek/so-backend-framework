<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Model Command
 *
 * Generates a new model class file.
 *
 * Usage:
 *   php sixorbit make:model User
 *   php sixorbit make:model Post --soft-deletes
 *   php sixorbit make:model Product --force
 *   php sixorbit make:model User --dry-run
 *   php sixorbit make:model Product --migration (or -m)
 */
class MakeModelCommand extends Command
{
    protected string $signature = 'make:model {name} {--soft-deletes} {--m|migration} {--force} {--dry-run}';

    protected string $description = 'Create a new model class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Model name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Blog/Post)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Model already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $useSoftDeletes = $this->option('soft-deletes', false);
        $tableName = $this->toTableName($className);
        $content = $this->buildModel($className, $namespace, $tableName, $useSoftDeletes);

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
            $this->error("Failed to create model: {$relativePath}");
            return 1;
        }

        $this->info("Model created successfully: {$relativePath}");

        // Create migration if --migration flag is set
        if ($this->option('migration', false) || $this->option('m', false)) {
            $this->createMigration($className, $tableName);
        }

        return 0;
    }

    /**
     * Create a migration for the model.
     */
    protected function createMigration(string $className, string $tableName): void
    {
        $migrationName = "create_{$tableName}_table";

        $this->comment("\nCreating migration for {$className}...");

        // Use passthru to run the make:migration command
        $command = "php sixorbit make:migration {$migrationName} --create={$tableName}";
        passthru($command, $returnCode);

        if ($returnCode === 0) {
            $this->info("Migration created successfully.");
        }
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Models';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Models';
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
     * Build the model class content
     */
    protected function buildModel(string $className, string $namespace, string $tableName, bool $useSoftDeletes): string
    {
        $useStatements = "use Core\\Model\\Model;\n";
        $traitUse = '';

        if ($useSoftDeletes) {
            $useStatements .= "use Core\\Model\\SoftDeletes;\n";
            $traitUse = "\n    use SoftDeletes;\n";
        }

        return <<<PHP
<?php

namespace {$namespace};

{$useStatements}
/**
 * {$className} Model
 */
class {$className} extends Model
{{$traitUse}
    protected static string \$table = '{$tableName}';

    protected array \$fillable = [];

    protected array \$guarded = [];
}
PHP;
    }

    /**
     * Convert a model name to a snake_case plural table name
     * e.g., "User" -> "users", "BlogPost" -> "blog_posts", "Category" -> "categories"
     */
    protected function toTableName(string $name): string
    {
        // Convert PascalCase to snake_case
        $snake = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name));

        // Simple pluralization
        if (str_ends_with($snake, 'y') && !str_ends_with($snake, 'ey') && !str_ends_with($snake, 'oy') && !str_ends_with($snake, 'ay')) {
            return substr($snake, 0, -1) . 'ies';
        }

        if (str_ends_with($snake, 's') || str_ends_with($snake, 'sh') || str_ends_with($snake, 'ch') || str_ends_with($snake, 'x') || str_ends_with($snake, 'z')) {
            return $snake . 'es';
        }

        return $snake . 's';
    }
}
