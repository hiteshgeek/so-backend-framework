<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Middleware Command
 *
 * Generates a new middleware class file.
 *
 * Usage:
 *   php sixorbit make:middleware RateLimitMiddleware
 *   php sixorbit make:middleware Auth/AdminMiddleware
 *   php sixorbit make:middleware RateLimitMiddleware --force
 *   php sixorbit make:middleware RateLimitMiddleware --dry-run
 */
class MakeMiddlewareCommand extends Command
{
    protected string $signature = 'make:middleware {name} {--force} {--dry-run}';

    protected string $description = 'Create a new middleware class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Middleware name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Auth/AdminMiddleware)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Middleware already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildMiddleware($className, $namespace);

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
            $this->error("Failed to create middleware: {$relativePath}");
            return 1;
        }

        $this->info("Middleware created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Auth/AdminMiddleware
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Middleware';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Middleware';
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
     * Build the middleware class content
     */
    protected function buildMiddleware(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * {$className}
 */
class {$className} implements MiddlewareInterface
{
    /**
     * Handle the incoming request.
     */
    public function handle(Request \$request, callable \$next): Response
    {
        // Perform action before request is handled...

        \$response = \$next(\$request);

        // Perform action after request is handled...

        return \$response;
    }
}
PHP;
    }
}
