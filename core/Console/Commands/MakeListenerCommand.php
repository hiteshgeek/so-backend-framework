<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Listener Command
 *
 * Generates a new event listener class file.
 *
 * Usage:
 *   php sixorbit make:listener SendWelcomeEmail
 */
class MakeListenerCommand extends Command
{
    protected string $signature = 'make:listener {name}';

    protected string $description = 'Create a new event listener class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Listener name is required.');
            return 1;
        }

        $basePath = getcwd();
        $relativePath = 'app/Listeners/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        if (file_exists($filePath)) {
            $this->error("Listener already exists: {$relativePath}");
            return 1;
        }

        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $content = $this->buildListener($name);

        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create listener: {$relativePath}");
            return 1;
        }

        $this->info("Listener created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build the listener class content
     */
    protected function buildListener(string $name): string
    {
        return <<<PHP
<?php

namespace App\Listeners;

use Core\Events\Event;

/**
 * {$name}
 */
class {$name}
{
    /**
     * Create a new listener instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Event \$event): void
    {
        //
    }
}
PHP;
    }
}
