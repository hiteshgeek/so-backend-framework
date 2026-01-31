<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Seeder Command
 *
 * Generates a new seeder class file.
 *
 * Usage:
 *   php sixorbit make:seeder UserSeeder
 *   php sixorbit make:seeder ProductSeeder --force
 *   php sixorbit make:seeder UserSeeder --dry-run
 */
class MakeSeederCommand extends Command
{
    protected string $signature = 'make:seeder {name} {--force} {--dry-run}';

    protected string $description = 'Create a new seeder class';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Seeder name is required.');
            return 1;
        }

        // Ensure name ends with "Seeder"
        if (!str_ends_with($name, 'Seeder')) {
            $name .= 'Seeder';
        }

        $basePath = getcwd();
        $relativePath = 'database/seeders/' . $name . '.php';
        $filePath = $basePath . '/' . $relativePath;

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Seeder already exists: {$relativePath}");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        $content = $this->buildSeeder($name);

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
            $this->error("Failed to create seeder: {$relativePath}");
            return 1;
        }

        $this->info("Seeder created successfully: {$relativePath}");
        return 0;
    }

    /**
     * Build the seeder class content.
     */
    protected function buildSeeder(string $name): string
    {
        return <<<PHP
<?php

namespace Database\Seeders;

use Core\Database\Seeder;

/**
 * {$name}
 */
class {$name} extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data here
        // Example:
        // \$this->insert('users', [
        //     ['name' => 'John Doe', 'email' => 'john@example.com'],
        //     ['name' => 'Jane Doe', 'email' => 'jane@example.com'],
        // ]);
    }
}
PHP;
    }
}
