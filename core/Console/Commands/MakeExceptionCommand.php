<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Exception Command
 *
 * Generates a new exception class file.
 *
 * Usage:
 *   php sixorbit make:exception PaymentFailedException
 *   php sixorbit make:exception PaymentFailedException --http
 *   php sixorbit make:exception Payment/PaymentFailedException
 *   php sixorbit make:exception PaymentFailedException --force
 *   php sixorbit make:exception PaymentFailedException --dry-run
 */
class MakeExceptionCommand extends Command
{
    protected string $signature = 'make:exception {name} {--http} {--force} {--dry-run}';

    protected string $description = 'Create a new exception class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Exception name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Payment/PaymentFailedException)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Exception already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $isHttp = $this->option('http', false);
        $content = $isHttp
            ? $this->buildHttpException($className, $namespace)
            : $this->buildBasicException($className, $namespace);

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
            $this->error("Failed to create exception: {$relativePath}");
            return 1;
        }

        $this->info("Exception created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Payment/PaymentFailedException
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Exceptions';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Exceptions';
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
     * Build a basic exception extending \Exception
     */
    protected function buildBasicException(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Exception;

/**
 * {$className}
 */
class {$className} extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string \$message = '', int \$code = 0, ?\\Throwable \$previous = null)
    {
        parent::__construct(\$message, \$code, \$previous);
    }
}
PHP;
    }

    /**
     * Build an HTTP exception extending Core\Exceptions\HttpException
     */
    protected function buildHttpException(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Core\Exceptions\HttpException;

/**
 * {$className}
 */
class {$className} extends HttpException
{
    /**
     * Create a new HTTP exception instance.
     */
    public function __construct(string \$message = '', int \$code = 500, ?\\Exception \$previous = null)
    {
        parent::__construct(\$message, \$code, \$previous);
    }
}
PHP;
    }
}
