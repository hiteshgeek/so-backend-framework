<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Event Command
 *
 * Generates a new event class file.
 *
 * Usage:
 *   php sixorbit make:event UserRegistered
 */
class MakeEventCommand extends Command
{
    protected string $signature = 'make:event {name}';

    protected string $description = 'Create a new event class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Event name is required.');
            return 1;
        }

        $basePath = getcwd();
        $relativePath = 'app/Events/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        if (file_exists($filePath)) {
            $this->error("Event already exists: {$relativePath}");
            return 1;
        }

        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $content = $this->buildEvent($name);

        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create event: {$relativePath}");
            return 1;
        }

        $this->info("Event created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build the event class content
     */
    protected function buildEvent(string $name): string
    {
        return <<<PHP
<?php

namespace App\Events;

use Core\Events\Event;

/**
 * {$name} Event
 */
class {$name} extends Event
{
    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }
}
PHP;
    }
}
