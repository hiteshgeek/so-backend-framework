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
 */
class MakeExceptionCommand extends Command
{
    protected string $signature = 'make:exception {name} {--http}';

    protected string $description = 'Create a new exception class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Exception name is required.');
            return 1;
        }

        $basePath = getcwd();
        $relativePath = 'app/Exceptions/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        if (file_exists($filePath)) {
            $this->error("Exception already exists: {$relativePath}");
            return 1;
        }

        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $isHttp = $this->option('http', false);
        $content = $isHttp
            ? $this->buildHttpException($name)
            : $this->buildBasicException($name);

        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create exception: {$relativePath}");
            return 1;
        }

        $this->info("Exception created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build a basic exception extending \Exception
     */
    protected function buildBasicException(string $name): string
    {
        return <<<PHP
<?php

namespace App\Exceptions;

use Exception;

/**
 * {$name}
 */
class {$name} extends Exception
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
    protected function buildHttpException(string $name): string
    {
        return <<<PHP
<?php

namespace App\Exceptions;

use Core\Exceptions\HttpException;

/**
 * {$name}
 */
class {$name} extends HttpException
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
