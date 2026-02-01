# CLI Commands - Developer Guide

**SO Framework** | **Command Line Interface** | **Version 1.0**

A practical guide to using the `sixorbit` CLI tool for rapid development, code generation, database management, and application maintenance.

---

## Table of Contents

1. [Overview](#overview)
2. [Getting Started](#getting-started)
3. [Code Generation Commands](#code-generation-commands)
4. [Database Commands](#database-commands)
5. [Maintenance Commands](#maintenance-commands)
6. [Queue Commands](#queue-commands)
7. [Development Workflow Examples](#development-workflow-examples)
8. [Creating Custom Commands](#creating-custom-commands)

---

## Overview

The SO Framework includes a powerful command-line interface called `sixorbit` that helps you generate boilerplate code, manage databases, run background jobs, and perform maintenance tasks without writing repetitive code.

### Why Use CLI Commands?

- **Save Time** -- Generate controllers, models, and migrations in seconds instead of copying templates
- **Consistency** -- All generated code follows framework conventions and best practices
- **Automation** -- Schedule cleanup tasks, queue workers, and maintenance operations
- **Development Speed** -- Focus on business logic instead of boilerplate setup

### Available Commands

The framework includes 31 commands organized into five categories:

| Category | Commands | Purpose |
|----------|----------|---------|
| **Generators** | make:controller, make:model, make:middleware, etc. | Create new files from templates |
| **Database** | migrate, migrate:rollback, migrate:status, db:seed | Manage database schema and data |
| **Maintenance** | cache:clear, session:cleanup, activity:prune | Clean up application data |
| **Queue** | queue:work, queue:retry | Process background jobs |
| **Utilities** | key:generate, route:list, route:cache | Application management |

To see all available commands, run:

```bash
./sixorbit list
```

For help on a specific command:

```bash
./sixorbit help make:controller
./sixorbit make:controller --help
```

---

## Getting Started

### Running Your First Command

Navigate to your project root (where the `sixorbit` file is located) and run:

```bash
./sixorbit make:controller WelcomeController
```

Output:
```
Controller created successfully: app/Controllers/WelcomeController.php
```

The framework created a new file at `app/Controllers/WelcomeController.php` with this content:

```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class WelcomeController
{
    public function index(Request $request): Response
    {
        return Response::view('welcome');
    }
}
```

### Command Syntax

All commands follow this pattern:

```bash
./sixorbit <command> [arguments] [options]
```

- **command** -- The action to perform (e.g., `make:controller`)
- **arguments** -- Required values (e.g., controller name)
- **options** -- Optional flags that modify behavior (e.g., `--api`, `--force`)

**Examples:**

```bash
# Basic usage
./sixorbit make:model Product

# With options
./sixorbit make:controller ProductController --api --force

# With nested paths
./sixorbit make:controller Admin/UserController
```

---

## Code Generation Commands

Code generators create new files from templates, saving you time and ensuring consistency.

### make:controller

Generate a new controller class.

**Basic Usage:**

```bash
./sixorbit make:controller ProductController
```

Creates `app/Controllers/ProductController.php`:

```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class ProductController
{
    public function index(Request $request): Response
    {
        return Response::view('products.index');
    }
}
```

**API Controller:**

Add `--api` flag to generate a controller with JSON responses:

```bash
./sixorbit make:controller ProductController --api
```

Creates:

```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class ProductController
{
    public function index(Request $request): Response
    {
        return json(['message' => 'Product listing']);
    }

    public function store(Request $request): Response
    {
        return json(['message' => 'Product created'], 201);
    }

    public function show(Request $request, $id): Response
    {
        return json(['id' => $id]);
    }

    public function update(Request $request, $id): Response
    {
        return json(['message' => 'Product updated']);
    }

    public function destroy(Request $request, $id): Response
    {
        return json(['message' => 'Product deleted']);
    }
}
```

**Nested Controllers:**

Organize controllers in subdirectories:

```bash
./sixorbit make:controller Admin/UserController
./sixorbit make:controller API/V1/ProductController
```

Creates:
- `app/Controllers/Admin/UserController.php` (namespace: `App\Controllers\Admin`)
- `app/Controllers/API/V1/ProductController.php` (namespace: `App\Controllers\API\V1`)

**Force Overwrite:**

Replace an existing controller:

```bash
./sixorbit make:controller ProductController --force
```

### make:model

Generate a new model class.

**Basic Usage:**

```bash
./sixorbit make:model Product
```

Creates `app/Models/Product.php`:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Product extends Model
{
    protected string $table = 'products';
    protected string $primaryKey = 'id';
    protected array $fillable = [];
}
```

**With Migration:**

Generate a model and a migration file:

```bash
./sixorbit make:model Product --migration
```

Creates:
- `app/Models/Product.php`
- `database/migrations/2026_01_31_123456_create_products_table.php`

**With Soft Deletes:**

Add soft delete support:

```bash
./sixorbit make:model Product --soft-deletes
```

Adds `use SoftDeletes;` trait to the model.

**Nested Models:**

```bash
./sixorbit make:model Catalog/Product
```

Creates `app/Models/Catalog/Product.php`.

### make:middleware

Generate a new middleware class.

**Usage:**

```bash
./sixorbit make:middleware AdminOnly
```

Creates `app/Middleware/AdminOnly.php`:

```php
<?php

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Closure;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        // Add your middleware logic here

        return $next($request);
    }
}
```

**Register Middleware:**

After creation, register it in `bootstrap/app.php`:

```php
$app->middleware->register('admin', \App\Middleware\AdminOnly::class);
```

Use in routes:

```php
Router::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware('admin');
```

### make:migration

Generate a new database migration.

**Create Table:**

```bash
./sixorbit make:migration create_products_table
```

Creates `database/migrations/2026_01_31_123456_create_products_table.php`:

```php
<?php

use Core\Database\Migration;
use Core\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function($table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

**Modify Table:**

```bash
./sixorbit make:migration add_price_to_products_table --table=products
```

The `--table` option generates an ALTER TABLE template instead of CREATE TABLE.

### make:service

Generate a service class for business logic.

**Usage:**

```bash
./sixorbit make:service ProductService
```

Creates `app/Services/ProductService.php`:

```php
<?php

namespace App\Services;

class ProductService
{
    /**
     * Get all products
     */
    public function getAll(): array
    {
        // Implementation
        return [];
    }

    /**
     * Create a new product
     */
    public function create(array $data): array
    {
        // Validation
        // Creation logic
        return [];
    }
}
```

**Use in Controllers:**

```php
class ProductController
{
    protected ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index(Request $request): Response
    {
        $products = $this->productService->getAll();
        return json($products);
    }
}
```

### Other Generators

**make:mail** -- Generate an email class:

```bash
./sixorbit make:mail WelcomeEmail
```

**make:event** -- Generate an event class:

```bash
./sixorbit make:event UserRegistered
```

**make:listener** -- Generate an event listener:

```bash
./sixorbit make:listener SendWelcomeEmail
```

**make:exception** -- Generate a custom exception:

```bash
./sixorbit make:exception PaymentFailedException
```

**make:provider** -- Generate a service provider:

```bash
./sixorbit make:provider PaymentProvider
```

---

## Database Commands

Database commands help you manage schema changes and populate data.

### migrate

Run all pending migrations.

**Basic Usage:**

```bash
./sixorbit migrate
```

Output:
```
Migrating: 2026_01_31_000000_create_users_table
Migrated:  2026_01_31_000000_create_users_table (45ms)
Migrating: 2026_01_31_000001_create_products_table
Migrated:  2026_01_31_000001_create_products_table (32ms)
```

The framework:
1. Checks the `migrations` table for already-run migrations
2. Finds new migration files in `database/migrations/`
3. Executes each `up()` method in chronological order
4. Records the migration in the `migrations` table

**Step-by-Step Migration:**

Run one migration at a time:

```bash
./sixorbit migrate --step=1
```

**Preview SQL:**

See what SQL will be executed without running it:

```bash
./sixorbit migrate --pretend
```

### migrate:rollback

Undo the last batch of migrations.

**Basic Usage:**

```bash
./sixorbit migrate:rollback
```

Executes the `down()` method of the most recent batch of migrations.

**Rollback Multiple Batches:**

```bash
./sixorbit migrate:rollback --step=2
```

**Warning:** Rollback operations can delete data. Always back up your database first.

### migrate:status

View the status of all migrations.

**Usage:**

```bash
./sixorbit migrate:status
```

Output:
```
Migration Status:
+------+------------------------------------------------+---------+
| Ran? | Migration                                      | Batch   |
+------+------------------------------------------------+---------+
| Yes  | 2026_01_31_000000_create_users_table          | 1       |
| Yes  | 2026_01_31_000001_create_products_table       | 1       |
| No   | 2026_01_31_123456_add_status_to_products      | Pending |
+------+------------------------------------------------+---------+
```

This helps you see which migrations have run and which are pending.

### db:seed

Populate the database with test data.

**Basic Usage:**

```bash
./sixorbit db:seed
```

Runs `database/seeders/DatabaseSeeder.php` by default.

**Run Specific Seeder:**

```bash
./sixorbit db:seed --class=ProductSeeder
```

**Create a Seeder:**

```bash
./sixorbit make:seeder ProductSeeder
```

Creates `database/seeders/ProductSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Sample Product',
            'price' => 99.99,
            'description' => 'This is a sample product',
        ]);
    }
}
```

---

## Maintenance Commands

Maintenance commands clean up application data and optimize performance.

### cache:clear

Clear all cached data.

**Usage:**

```bash
./sixorbit cache:clear
```

Deletes all entries from the `cache` table. Use this when:
- Cache data becomes stale
- You change configuration files
- You deploy new code

**Production Tip:** Run this as part of your deployment script.

### session:cleanup

Delete expired session data.

**Usage:**

```bash
./sixorbit session:cleanup
```

Removes session records older than the configured session lifetime (default: 2 hours).

**Schedule It:**

Add to your cron jobs:

```bash
0 2 * * * cd /var/www/html/so-backend-framework && ./sixorbit session:cleanup
```

### activity:prune

Delete old activity log entries.

**Delete Entries Older Than 90 Days:**

```bash
./sixorbit activity:prune --days=90
```

**Preview Before Deleting:**

```bash
./sixorbit activity:prune --days=90 --dry-run
```

**Verbose Output:**

```bash
./sixorbit activity:prune --days=90 --verbose
```

### notification:cleanup

Delete old notification records.

**Usage:**

```bash
./sixorbit notification:cleanup --days=30
```

---

## Queue Commands

Queue commands process background jobs.

### queue:work

Start a queue worker to process jobs.

**Basic Usage:**

```bash
./sixorbit queue:work
```

The worker continuously polls the `jobs` table and processes pending jobs.

**Limit Number of Jobs:**

Process 10 jobs then exit:

```bash
./sixorbit queue:work --max-jobs=10
```

**Set Maximum Execution Time:**

Stop after 3600 seconds (1 hour):

```bash
./sixorbit queue:work --timeout=3600
```

**Run in Background:**

Use a process manager like `supervisor` to keep the worker running:

```ini
[program:sixorbit-worker]
command=/var/www/html/so-backend-framework/sixorbit queue:work --timeout=3600
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/sixorbit-worker.log
```

### queue:retry

Retry failed jobs.

**Retry All Failed Jobs:**

```bash
./sixorbit queue:retry all
```

**Retry Specific Job:**

```bash
./sixorbit queue:retry 42
```

---

## Development Workflow Examples

### Example 1: Creating a CRUD Module

Build a complete product management system.

**Step 1 -- Generate Model and Migration:**

```bash
./sixorbit make:model Product --migration
```

**Step 2 -- Edit Migration:**

Edit `database/migrations/YYYY_MM_DD_HHMMSS_create_products_table.php`:

```php
public function up(): void
{
    Schema::create('products', function($table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->integer('stock')->default(0);
        $table->timestamps();
    });
}
```

**Step 3 -- Run Migration:**

```bash
./sixorbit migrate
```

**Step 4 -- Generate Controller:**

```bash
./sixorbit make:controller ProductController --api
```

**Step 5 -- Generate Service:**

```bash
./sixorbit make:service ProductService
```

**Step 6 -- Test with Seeder:**

```bash
./sixorbit make:seeder ProductSeeder
```

Edit the seeder, then run:

```bash
./sixorbit db:seed --class=ProductSeeder
```

### Example 2: Adding a Feature to Existing Module

Add a "featured" flag to products.

**Step 1 -- Generate Migration:**

```bash
./sixorbit make:migration add_featured_to_products_table --table=products
```

**Step 2 -- Edit Migration:**

```php
public function up(): void
{
    Schema::table('products', function($table) {
        $table->boolean('featured')->default(false);
    });
}

public function down(): void
{
    Schema::table('products', function($table) {
        $table->dropColumn('featured');
    });
}
```

**Step 3 -- Run Migration:**

```bash
./sixorbit migrate
```

**Step 4 -- Update Model:**

Add `'featured'` to `$fillable` array in `app/Models/Product.php`.

### Example 3: Background Job Processing

Send welcome emails asynchronously.

**Step 1 -- Generate Job:**

```bash
./sixorbit make:job SendWelcomeEmail
```

**Step 2 -- Implement Job:**

```php
<?php

namespace App\Jobs;

use Core\Queue\Job;
use App\Models\User;

class SendWelcomeEmail extends Job
{
    public function __construct(
        protected int $userId
    ) {}

    public function handle(): void
    {
        $user = User::find($this->userId);
        // Send email logic here
    }
}
```

**Step 3 -- Dispatch Job in Controller:**

```php
public function register(Request $request): Response
{
    $user = User::create($request->only(['name', 'email', 'password']));

    // Queue the welcome email
    dispatch(new SendWelcomeEmail($user->id));

    return redirect('/dashboard');
}
```

**Step 4 -- Start Worker:**

```bash
./sixorbit queue:work
```

---

## Creating Custom Commands

You can create your own CLI commands for project-specific tasks.

### Step 1 -- Generate Command Class

```bash
./sixorbit make:command GenerateReportCommand
```

Creates `app/Console/Commands/GenerateReportCommand.php`:

```php
<?php

namespace App\Console\Commands;

use Core\Console\Command;

class GenerateReportCommand extends Command
{
    protected string $signature = 'report:generate';
    protected string $description = 'Generate monthly sales report';

    public function handle(): int
    {
        $this->info('Generating report...');

        // Your logic here

        $this->success('Report generated successfully!');
        return 0;
    }
}
```

### Step 2 -- Register Command

Add it to `sixorbit` file:

```php
$console->register(\App\Console\Commands\GenerateReportCommand::class);
```

### Step 3 -- Run Command

```bash
./sixorbit report:generate
```

### Command Features

**Arguments:**

```php
protected string $signature = 'report:generate {month} {year}';

public function handle(): int
{
    $month = $this->argument('month');
    $year = $this->argument('year');

    $this->info("Generating report for {$month}/{$year}");
    return 0;
}
```

Usage:
```bash
./sixorbit report:generate 01 2026
```

**Options:**

```php
protected string $signature = 'report:generate {--format=pdf}';

public function handle(): int
{
    $format = $this->option('format', 'pdf');

    $this->info("Format: {$format}");
    return 0;
}
```

Usage:
```bash
./sixorbit report:generate --format=csv
```

**Interactive Prompts:**

```php
public function handle(): int
{
    $name = $this->ask('What is your name?');

    if ($this->confirm('Do you want to continue?')) {
        $this->info("Hello, {$name}!");
    }

    return 0;
}
```

**Progress Bars:**

```php
public function handle(): int
{
    $items = range(1, 100);

    $this->info('Processing items...');

    foreach ($items as $item) {
        // Process item
        $this->progress($item, count($items));
        usleep(50000); // Simulate work
    }

    $this->success('All items processed!');
    return 0;
}
```

---

**Related Documentation:**
- [Console Commands Reference](/docs/console-commands) - Complete command reference
- [Database Migrations](/docs/dev/migrations) - Detailed migration guide
- [Queue System](/docs/queues) - Background job processing
- [Models](/docs/dev/models) - Working with models

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
