<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Request Command
 *
 * Generates a new request validation class file.
 *
 * Usage:
 *   php sixorbit make:request CreateUserRequest
 *   php sixorbit make:request Auth/LoginRequest
 *   php sixorbit make:request CreateUserRequest --force
 *   php sixorbit make:request CreateUserRequest --dry-run
 */
class MakeRequestCommand extends Command
{
    protected string $signature = 'make:request {name} {--force} {--dry-run}';

    protected string $description = 'Create a new request validation class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Request name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Auth/LoginRequest)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Request already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildRequest($className, $namespace);

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
            $this->error("Failed to create request: {$relativePath}");
            return 1;
        }

        $this->info("Request created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Auth/LoginRequest
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Requests';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Requests';
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
     * Build a request validation class with rules method
     */
    protected function buildRequest(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Core\Http\Request;

/**
 * {$className}
 *
 * Request validation class
 */
class {$className}
{
    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // Example validation rules:
            // 'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|min:8|confirmed',
            // 'age' => 'integer|min:18|max:100',
            // 'status' => 'in:active,inactive,pending',
        ];
    }

    /**
     * Static helper to validate request data
     *
     * @param Request \$request
     * @return array Validated data
     * @throws \\Exception If validation fails
     */
    public static function validate(Request \$request): array
    {
        \$instance = new static();
        \$rules = \$instance->rules();
        \$data = \$request->all();

        // TODO: Implement actual validation logic
        // This is a placeholder - integrate with your validation system

        return \$data;
    }

    /**
     * Get custom error messages for validation rules
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            // Example custom messages:
            // 'name.required' => 'The name field is required.',
            // 'email.email' => 'Please provide a valid email address.',
        ];
    }

    /**
     * Get custom attribute names for validation
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            // Example custom attribute names:
            // 'email' => 'email address',
            // 'password' => 'password',
        ];
    }
}
PHP;
    }
}
