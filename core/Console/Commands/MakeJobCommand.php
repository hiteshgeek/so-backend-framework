<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Job Command
 *
 * Generates a new queue job class file.
 *
 * Usage:
 *   php sixorbit make:job ProcessPayment
 *   php sixorbit make:job Email/SendWelcomeEmail
 *   php sixorbit make:job ProcessPayment --force
 *   php sixorbit make:job ProcessPayment --dry-run
 */
class MakeJobCommand extends Command
{
    protected string $signature = 'make:job {name} {--force} {--dry-run}';

    protected string $description = 'Create a new job class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Job name is required.');
            return 1;
        }

        // Parse nested paths (e.g., Email/SendWelcomeEmail)
        $parsedName = $this->parseName($name);
        $className = $parsedName['class'];
        $namespace = $parsedName['namespace'];
        $relativePath = $parsedName['path'];

        $basePath = getcwd();
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Job already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildJob($className, $namespace);

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
            $this->error("Failed to create job: {$relativePath}");
            return 1;
        }

        $this->info("Job created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Parse the name to extract class name, namespace, and file path
     * Supports nested paths like Email/SendWelcomeEmail
     */
    protected function parseName(string $name): array
    {
        // Remove .php extension if provided
        $name = str_replace('.php', '', $name);

        // Split by forward slash for nested paths
        $parts = explode('/', $name);
        $className = array_pop($parts);

        // Build namespace
        $namespace = 'App\\Jobs';
        if (!empty($parts)) {
            $namespace .= '\\' . implode('\\', $parts);
        }

        // Build file path
        $path = 'app/Jobs';
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
     * Build a job class extending Core\Queue\Job
     */
    protected function buildJob(string $className, string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Core\Queue\Job;

/**
 * {$className}
 *
 * Queue job for background processing
 */
class {$className} extends Job
{
    /**
     * Number of times the job may be attempted
     */
    public int \$tries = 3;

    /**
     * Number of seconds the job can run before timing out
     */
    public int \$timeout = 60;

    /**
     * The name of the queue the job should be sent to
     */
    public string \$queue = 'default';

    /**
     * Create a new job instance
     */
    public function __construct()
    {
        // Initialize job properties
    }

    /**
     * Execute the job
     *
     * @return void
     */
    public function handle(): void
    {
        // Implement job logic here
    }

    /**
     * Handle a job failure
     *
     * @param \\Exception \$exception
     * @return void
     */
    public function failed(\\Exception \$exception): void
    {
        // Handle job failure
        // Log error, send notification, etc.
    }
}
PHP;
    }
}
