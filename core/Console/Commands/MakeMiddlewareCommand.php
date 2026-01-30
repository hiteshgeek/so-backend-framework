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
 */
class MakeMiddlewareCommand extends Command
{
    protected string $signature = 'make:middleware {name}';

    protected string $description = 'Create a new middleware class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Middleware name is required.');
            return 1;
        }

        $basePath = getcwd();
        $relativePath = 'app/Middleware/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        if (file_exists($filePath)) {
            $this->error("Middleware already exists: {$relativePath}");
            return 1;
        }

        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $content = $this->buildMiddleware($name);

        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create middleware: {$relativePath}");
            return 1;
        }

        $this->info("Middleware created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build the middleware class content
     */
    protected function buildMiddleware(string $name): string
    {
        return <<<PHP
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * {$name}
 */
class {$name} implements MiddlewareInterface
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
