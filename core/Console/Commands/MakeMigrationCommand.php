<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Make Migration Command
 *
 * Generates a new migration file with timestamp prefix.
 *
 * Usage:
 *   php sixorbit make:migration create_users_table
 *   php sixorbit make:migration create_users_table --create=users
 *   php sixorbit make:migration add_status_to_users_table --table=users
 *   php sixorbit make:migration create_posts_table --force
 *   php sixorbit make:migration create_comments_table --dry-run
 */
class MakeMigrationCommand extends Command
{
    protected string $signature = 'make:migration {name} {--create=} {--table=} {--force} {--dry-run}';

    protected string $description = 'Create a new migration file';

    public function handle(): int
    {
        $name = $this->argument(0);

        if (!$name) {
            $this->error('Migration name is required.');
            return 1;
        }

        // Parse options
        $create = $this->option('create', null);
        $table = $this->option('table', null);

        // Auto-detect table name and operation from migration name if not specified
        if (!$create && !$table) {
            $detected = $this->detectMigrationIntent($name);
            $create = $detected['create'];
            $table = $detected['table'];
        }

        // Generate timestamp prefix (Y_m_d_His format)
        $timestamp = date('Y_m_d_His');
        $fileName = "{$timestamp}_{$name}";

        $basePath = getcwd();
        $migrationsPath = $basePath . '/database/migrations';
        $filePath = $migrationsPath . '/' . $fileName . '.php';

        // Check if file exists
        if (file_exists($filePath) && !$this->option('force', false)) {
            $this->error("Migration already exists: database/migrations/{$fileName}.php");
            $this->comment("Use --force to overwrite");
            return 1;
        }

        // Build migration content
        $content = $this->buildMigration($name, $create, $table);

        // Dry run - show what would be created
        if ($this->option('dry-run', false)) {
            $this->comment("Would create: database/migrations/{$fileName}.php");
            $this->info("\n" . $content);
            return 0;
        }

        // Create directory if it doesn't exist
        if (!is_dir($migrationsPath)) {
            mkdir($migrationsPath, 0755, true);
        }

        // Write file
        if (file_put_contents($filePath, $content) === false) {
            $this->error("Failed to create migration: database/migrations/{$fileName}.php");
            return 1;
        }

        $this->info("Migration created successfully: database/migrations/{$fileName}.php");
        return 0;
    }

    /**
     * Detect migration intent from the migration name.
     * Attempts to auto-detect if it's a create or modify table migration.
     */
    protected function detectMigrationIntent(string $name): array
    {
        $create = null;
        $table = null;

        // Check for "create_xxx_table" pattern
        if (preg_match('/^create_(\w+)_table$/i', $name, $matches)) {
            $create = $matches[1];
        }
        // Check for "add_xxx_to_yyy_table" pattern
        elseif (preg_match('/^add_\w+_to_(\w+)_table$/i', $name, $matches)) {
            $table = $matches[1];
        }
        // Check for "remove_xxx_from_yyy_table" pattern
        elseif (preg_match('/^remove_\w+_from_(\w+)_table$/i', $name, $matches)) {
            $table = $matches[1];
        }
        // Check for "update_xxx_table" pattern
        elseif (preg_match('/^update_(\w+)_table$/i', $name, $matches)) {
            $table = $matches[1];
        }
        // Check for "modify_xxx_table" pattern
        elseif (preg_match('/^modify_(\w+)_table$/i', $name, $matches)) {
            $table = $matches[1];
        }

        return [
            'create' => $create,
            'table' => $table,
        ];
    }

    /**
     * Build the migration file content.
     */
    protected function buildMigration(string $name, ?string $create, ?string $table): string
    {
        if ($create) {
            return $this->buildCreateMigration($create);
        } elseif ($table) {
            return $this->buildModifyMigration($table);
        } else {
            return $this->buildBlankMigration();
        }
    }

    /**
     * Build a create table migration.
     */
    protected function buildCreateMigration(string $tableName): string
    {
        return <<<PHP
<?php

use Core\Database\Migration;
use Core\Database\Schema;
use Core\Database\Blueprint;

return new class extends Migration
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Schema::create('{$tableName}', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$tableName}');
    }
};
PHP;
    }

    /**
     * Build a modify table migration.
     */
    protected function buildModifyMigration(string $tableName): string
    {
        return <<<PHP
<?php

use Core\Database\Migration;
use Core\Database\Schema;
use Core\Database\Blueprint;

return new class extends Migration
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Schema::table('{$tableName}', function (Blueprint \$table) {
            // Add your columns here
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('{$tableName}', function (Blueprint \$table) {
            // Reverse your changes here
        });
    }
};
PHP;
    }

    /**
     * Build a blank migration.
     */
    protected function buildBlankMigration(): string
    {
        return <<<'PHP'
<?php

use Core\Database\Migration;
use Core\Database\Schema;
use Core\Database\Blueprint;

return new class extends Migration
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        // Add your migration code here
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        // Add your rollback code here
    }
};
PHP;
    }
}
