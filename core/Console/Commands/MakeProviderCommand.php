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
 */
class MakeProviderCommand extends Command
{
    protected string $signature = 'make:provider {name}';

    protected string $description = 'Create a new service provider class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Provider name is required.');
            return 1;
        }

        $basePath = getcwd();
        $relativePath = 'app/Providers/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        if (file_exists($filePath)) {
            $this->error("Provider already exists: {$relativePath}");
            return 1;
        }

        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $content = $this->buildProvider($name);

        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create provider: {$relativePath}");
            return 1;
        }

        $this->info("Provider created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build the service provider class content
     */
    protected function buildProvider(string $name): string
    {
        return <<<PHP
<?php

namespace App\Providers;

use Core\Container\Container;

/**
 * {$name}
 */
class {$name}
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
