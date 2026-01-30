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
 */
class MakeModelCommand extends Command
{
    protected string $signature = 'make:model {name} {--soft-deletes}';

    protected string $description = 'Create a new model class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Model name is required.');
            return 1;
        }

        $basePath = getcwd();
        $relativePath = 'app/Models/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        if (file_exists($filePath)) {
            $this->error("Model already exists: {$relativePath}");
            return 1;
        }

        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $useSoftDeletes = $this->option('soft-deletes', false);
        $tableName = $this->toTableName($name);
        $content = $this->buildModel($name, $tableName, $useSoftDeletes);

        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create model: {$relativePath}");
            return 1;
        }

        $this->info("Model created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build the model class content
     */
    protected function buildModel(string $name, string $tableName, bool $useSoftDeletes): string
    {
        $useStatements = "use Core\\Model\\Model;\n";
        $traitUse = '';

        if ($useSoftDeletes) {
            $useStatements .= "use Core\\Model\\SoftDeletes;\n";
            $traitUse = "\n    use SoftDeletes;\n";
        }

        return <<<PHP
<?php

namespace App\Models;

{$useStatements}
/**
 * {$name} Model
 */
class {$name} extends Model
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
