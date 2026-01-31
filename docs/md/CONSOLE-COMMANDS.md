# Console Commands Reference

**SO Framework** | **SixOrbit CLI** | **Version {{APP_VERSION}}**

Complete reference for all command-line interface (CLI) commands available in the SO Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Getting Started](#getting-started)
3. [Command Categories](#command-categories)
4. [Generator Commands](#generator-commands)
5. [Migration Commands](#migration-commands)
6. [Seeder Commands](#seeder-commands)
7. [Queue Commands](#queue-commands)
8. [Cache Commands](#cache-commands)
9. [Session Commands](#session-commands)
10. [Activity Log Commands](#activity-log-commands)
11. [Notification Commands](#notification-commands)
12. [Route Commands](#route-commands)
13. [Security Commands](#security-commands)
14. [Creating Custom Commands](#creating-custom-commands)
15. [Command Options](#command-options)
16. [Running Commands](#running-commands)
17. [Best Practices](#best-practices)
18. [Complete Cron Schedule Example](#complete-cron-schedule-example)
19. [Deployment Script Example](#deployment-script-example)
20. [Troubleshooting](#troubleshooting)
21. [Summary](#summary)

---

## Overview

The SO Framework includes a **SixOrbit** command-line interface that provides helpful commands for managing your application. All commands are executed through the `sixorbit` script in the root directory.

### Features

- [x] Laravel-style command syntax
- [x] 31 built-in commands
- [x] Code generation scaffolding
- [x] Database migrations
- [x] Database seeders
- [x] Maintenance and cleanup commands
- [x] Support for custom commands
- [x] Argument and option parsing
- [x] Interactive prompts
- [x] Color-coded output
- [x] Nested namespace support
- [x] Dry-run mode for safety
- [x] Force overwrite protection

---

## Getting Started

### Running SixOrbit

Execute sixorbit from the command line:

```bash
php sixorbit <command> [options] [arguments]
```

### List All Commands

```bash
php sixorbit
```

### Get Help for a Command

```bash
php sixorbit help <command>
```

---

## Command Categories

### Complete Command Summary

| Command | Description | Category |
|---------|-------------|----------|
| **Generator Commands** |
| `make:controller` | Create a new controller class | Generator |
| `make:model` | Create a new model class | Generator |
| `make:middleware` | Create a new middleware class | Generator |
| `make:mail` | Create a new mail class | Generator |
| `make:event` | Create a new event class | Generator |
| `make:listener` | Create a new listener class | Generator |
| `make:provider` | Create a new service provider class | Generator |
| `make:exception` | Create a new exception class | Generator |
| `make:service` | Create a new service class | Generator |
| `make:request` | Create a new form request class | Generator |
| `make:job` | Create a new queueable job class | Generator |
| `make:repository` | Create a new repository class | Generator |
| **Migration Commands** |
| `make:migration` | Create a new migration file | Migration |
| `migrate` | Run pending database migrations | Migration |
| `migrate:rollback` | Rollback the last database migration | Migration |
| `migrate:status` | Show the status of each migration | Migration |
| **Seeder Commands** |
| `make:seeder` | Create a new seeder class | Seeder |
| `db:seed` | Seed the database with records | Seeder |
| **Queue Commands** |
| `queue:work` | Process jobs from the queue | Queue |
| **Cache Commands** |
| `cache:clear` | Clear all cache entries | Cache |
| `cache:gc` | Run cache garbage collection | Cache |
| **Session Commands** |
| `session:cleanup` | Clean expired sessions | Session |
| **Activity Log Commands** |
| `activity:prune` | Archive old activity logs | Activity Log |
| **Notification Commands** |
| `notification:cleanup` | Delete old notifications | Notifications |
| **Route Commands** |
| `route:list` | List all registered routes | Routes |
| `route:cache` | Create a route cache file | Routes |
| **Security Commands** |
| `key:generate` | Generate a new application key | Security |
| `jwt:secret` | Generate a new JWT secret | Security |

**Total Commands: 31**

---

## Generator Commands

All generator commands support **nested paths**, **--force** (overwrite), and **--dry-run** (preview) options.

### Common Features

#### Nested Paths
Create files in subdirectories with automatic namespace resolution:

```bash
php sixorbit make:controller Admin/UserController
# Creates: app/Controllers/Admin/UserController.php
# Namespace: App\Controllers\Admin
```

#### Force Overwrite
Overwrite existing files without error:

```bash
php sixorbit make:controller UserController --force
```

#### Dry Run
Preview what would be created without actually creating files:

```bash
php sixorbit make:controller UserController --dry-run
```

---

### `make:controller`

Create a new controller class.

#### Syntax

```bash
php sixorbit make:controller <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--api` | Create an API controller with REST methods |
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Controller**
```bash
php sixorbit make:controller UserController
```

**API Controller**
```bash
php sixorbit make:controller Api/UserController --api
```

**Nested Structure**
```bash
php sixorbit make:controller Admin/Dashboard/AnalyticsController
# Creates: app/Controllers/Admin/Dashboard/AnalyticsController.php
```

**Preview Before Creating**
```bash
php sixorbit make:controller ProductController --dry-run
```

#### Output Location

- **Default**: `app/Controllers/`
- **Nested**: `app/Controllers/{NestedPath}/`

---

### `make:model`

Create a new model class.

#### Syntax

```bash
php sixorbit make:model <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--soft-deletes` | Include soft delete functionality |
| `--migration`, `-m` | Create migration file along with model |
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Model**
```bash
php sixorbit make:model Product
```

**Model with Soft Deletes**
```bash
php sixorbit make:model User --soft-deletes
```

**Model with Migration**
```bash
php sixorbit make:model Product --migration
# Creates both:
# - app/Models/Product.php
# - database/migrations/2024_01_31_123456_create_products_table.php
```

**Nested Model**
```bash
php sixorbit make:model Inventory/Product
```

#### Output Location

- **Default**: `app/Models/`
- **Nested**: `app/Models/{NestedPath}/`

---

### `make:middleware`

Create a new middleware class.

#### Syntax

```bash
php sixorbit make:middleware <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Middleware**
```bash
php sixorbit make:middleware CheckAge
```

**Nested Middleware**
```bash
php sixorbit make:middleware Auth/CheckRole
```

#### Output Location

- **Default**: `app/Middleware/`

---

### `make:mail`

Create a new mail class for email notifications.

#### Syntax

```bash
php sixorbit make:mail <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Mail**
```bash
php sixorbit make:mail WelcomeEmail
```

**Nested Mail**
```bash
php sixorbit make:mail Notifications/OrderConfirmation
```

#### Output Location

- **Default**: `app/Mail/`

---

### `make:event`

Create a new event class.

#### Syntax

```bash
php sixorbit make:event <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Event**
```bash
php sixorbit make:event UserRegistered
```

**Nested Event**
```bash
php sixorbit make:event Order/OrderPlaced
```

#### Output Location

- **Default**: `app/Events/`

---

### `make:listener`

Create a new event listener class.

#### Syntax

```bash
php sixorbit make:listener <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Listener**
```bash
php sixorbit make:listener SendWelcomeEmail
```

**Nested Listener**
```bash
php sixorbit make:listener Order/SendOrderConfirmation
```

#### Output Location

- **Default**: `app/Listeners/`

---

### `make:provider`

Create a new service provider class.

#### Syntax

```bash
php sixorbit make:provider <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Provider**
```bash
php sixorbit make:provider PaymentServiceProvider
```

#### Output Location

- **Default**: `app/Providers/`

---

### `make:exception`

Create a new exception class.

#### Syntax

```bash
php sixorbit make:exception <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Exception**
```bash
php sixorbit make:exception PaymentFailedException
```

**Nested Exception**
```bash
php sixorbit make:exception Payment/InvalidCardException
```

#### Output Location

- **Default**: `app/Exceptions/`

---

### `make:service`

Create a new service class for business logic.

#### Syntax

```bash
php sixorbit make:service <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Service**
```bash
php sixorbit make:service ProductService
```

**Nested Service**
```bash
php sixorbit make:service Payment/StripeService
```

#### Generated Template

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

#### Output Location

- **Default**: `app/Services/`

---

### `make:request`

Create a new form request validation class.

#### Syntax

```bash
php sixorbit make:request <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Request**
```bash
php sixorbit make:request CreateProductRequest
```

**Nested Request**
```bash
php sixorbit make:request User/UpdateProfileRequest
```

#### Generated Template

```php
<?php

namespace App\Requests;

use Core\Http\Request;

class CreateProductRequest
{
    /**
     * Get validation rules
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Validate the request
     */
    public static function validate(Request $request): array
    {
        return validator($request->all(), (new static)->rules())->validate();
    }
}
```

#### Output Location

- **Default**: `app/Requests/`

---

### `make:job`

Create a new queueable job class.

#### Syntax

```bash
php sixorbit make:job <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Job**
```bash
php sixorbit make:job SendEmailJob
```

**Nested Job**
```bash
php sixorbit make:job Email/SendWelcomeEmail
```

#### Generated Template

```php
<?php

namespace App\Jobs;

use Core\Queue\Job;

class SendEmailJob extends Job
{
    public function __construct(
        protected string $email,
        protected string $subject
    ) {}

    public function handle(): void
    {
        // Job logic here
    }
}
```

#### Output Location

- **Default**: `app/Jobs/`

---

### `make:repository`

Create a new repository class for data access layer.

#### Syntax

```bash
php sixorbit make:repository <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Repository**
```bash
php sixorbit make:repository UserRepository
```

**Nested Repository**
```bash
php sixorbit make:repository Product/ProductRepository
```

#### Generated Template

```php
<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function all(): array
    {
        return User::all();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);
        return $user ? $user->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        return $user ? $user->delete() : false;
    }
}
```

#### Output Location

- **Default**: `app/Repositories/`

---

## Migration Commands

Database migration commands for version control of your database schema.

### `make:migration`

Generate a new migration file.

#### Syntax

```bash
php sixorbit make:migration <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--create=<table>` | The table to be created |
| `--table=<table>` | The table to migrate |
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Create Table Migration**
```bash
php sixorbit make:migration create_products_table
# Or explicitly:
php sixorbit make:migration create_products --create=products
```

**Modify Table Migration**
```bash
php sixorbit make:migration add_status_to_products_table
# Or explicitly:
php sixorbit make:migration add_status_column --table=products
```

#### Generated Template (Create Table)

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
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

#### Output Location

- **Default**: `database/migrations/`
- **Format**: `{timestamp}_{name}.php`
- **Example**: `2024_01_31_123456_create_products_table.php`

---

### `migrate`

Run all pending migrations.

#### Syntax

```bash
php sixorbit migrate [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--step=<number>` | Run a specific number of migrations |
| `--pretend` | Show SQL without executing |
| `--force` | Force migrations in production |

#### Examples

**Run All Pending**
```bash
php sixorbit migrate
```

**Run One Migration**
```bash
php sixorbit migrate --step=1
```

**Preview SQL**
```bash
php sixorbit migrate --pretend
```

**Force in Production**
```bash
php sixorbit migrate --force
```

#### Output Example

```
Running migrations...
Migrating: 2024_01_31_123456_create_products_table
Migrated:  2024_01_31_123456_create_products_table (45.2ms)
Migrating: 2024_01_31_123457_create_orders_table
Migrated:  2024_01_31_123457_create_orders_table (32.1ms)
Migration completed successfully.
```

---

### `migrate:rollback`

Rollback the last batch of migrations.

#### Syntax

```bash
php sixorbit migrate:rollback [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--step=<number>` | Rollback a specific number of batches |
| `--pretend` | Show SQL without executing |

#### Examples

**Rollback Last Batch**
```bash
php sixorbit migrate:rollback
```

**Rollback Multiple Batches**
```bash
php sixorbit migrate:rollback --step=2
```

**Preview Rollback SQL**
```bash
php sixorbit migrate:rollback --pretend
```

#### Output Example

```
Rolling back migrations...
Rolling back: 2024_01_31_123457_create_orders_table
Rolled back: 2024_01_31_123457_create_orders_table (12.3ms)
Rollback completed successfully.
```

---

### `migrate:status`

Show the status of each migration.

#### Syntax

```bash
php sixorbit migrate:status
```

#### Output Example

```
+------+------------------------------------------------+---------+
| Ran? | Migration                                      | Batch   |
+------+------------------------------------------------+---------+
| Yes  | 2024_01_31_000000_create_users_table          | 1       |
| Yes  | 2024_01_31_000001_create_products_table       | 1       |
| Yes  | 2024_01_31_123456_add_status_to_products      | 2       |
| No   | 2024_01_31_123457_create_orders_table         | Pending |
+------+------------------------------------------------+---------+
```

---

## Seeder Commands

Database seeding commands for populating your database with test data.

### `make:seeder`

Create a new seeder class.

#### Syntax

```bash
php sixorbit make:seeder <name> [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing file |
| `--dry-run` | Show what would be created |

#### Examples

**Basic Seeder**
```bash
php sixorbit make:seeder ProductSeeder
```

**Auto-append "Seeder"**
```bash
php sixorbit make:seeder User
# Creates: UserSeeder
```

#### Generated Template

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data here
        // Example:
        // $this->insert('products', [
        //     ['name' => 'Product 1', 'price' => 99.99],
        //     ['name' => 'Product 2', 'price' => 149.99],
        // ]);
    }
}
```

#### Output Location

- **Default**: `database/seeders/`

---

### `db:seed`

Run database seeders.

#### Syntax

```bash
php sixorbit db:seed [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--class=<name>` | Specific seeder class to run |
| `--force` | Force seeding in production |

#### Examples

**Run DatabaseSeeder**
```bash
php sixorbit db:seed
```

**Run Specific Seeder**
```bash
php sixorbit db:seed --class=ProductSeeder
# Or with full namespace:
php sixorbit db:seed --class=Database\\Seeders\\ProductSeeder
```

**Force in Production**
```bash
php sixorbit db:seed --force
```

#### Output Example

```
Seeding database...
Seeding: Database\Seeders\ProductSeeder
Seeding: Database\Seeders\UserSeeder

Database seeding completed successfully.
```

#### DatabaseSeeder Example

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call other seeders
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
```

---

## Queue Commands

### `queue:work`

Process jobs from the queue. Runs as a daemon and continuously processes jobs.

#### Syntax

```bash
php sixorbit queue:work [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--queue` | `default` | The queue to process jobs from |
| `--sleep` | `3` | Seconds to sleep when no jobs are available |
| `--tries` | `3` | Maximum number of retry attempts |
| `--timeout` | `60` | Maximum seconds a job can run |
| `--once` | `false` | Process one job and exit |
| `--verbose` | `false` | Show detailed job processing info |
| `--quiet` | `false` | Suppress all output except errors |

#### Examples

**Basic Usage (Daemon Mode)**
```bash
php sixorbit queue:work
```

**Process Specific Queue**
```bash
php sixorbit queue:work --queue=emails
```

**Process One Job and Exit**
```bash
php sixorbit queue:work --once
```

**Verbose Mode**
```bash
php sixorbit queue:work --verbose
```

**Custom Configuration**
```bash
php sixorbit queue:work --queue=high-priority --sleep=1 --tries=5 --timeout=120
```

#### Production Deployment

**Using Supervisor (Recommended)**

```ini
[program:so-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/so-backend-framework/sixorbit queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/html/so-backend-framework/storage/logs/worker.log
```

---

## Cache Commands

### `cache:clear`

Clear all cache entries from the specified cache store.

#### Syntax

```bash
php sixorbit cache:clear [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--store` | `database` | The cache store to clear (database, array, redis) |
| `--dry-run` | `false` | Show what would be cleared |
| `--verbose` | `false` | Show detailed output |
| `--force` | `false` | Skip confirmation prompt |

#### Examples

**Clear Database Cache (with confirmation)**
```bash
php sixorbit cache:clear
# Prompts: Are you sure you want to delete all cache entries?
```

**Clear Without Confirmation**
```bash
php sixorbit cache:clear --force
```

**Dry Run**
```bash
php sixorbit cache:clear --dry-run
# Output: Would delete 1,234 cache entries
```

**Verbose Mode**
```bash
php sixorbit cache:clear --verbose
```

---

### `cache:gc`

Run garbage collection on the cache store to remove expired entries.

#### Syntax

```bash
php sixorbit cache:gc [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--store` | `database` | The cache store to clean |
| `--dry-run` | `false` | Show what would be deleted |
| `--verbose` | `false` | Show detailed output |

#### Examples

**Run Garbage Collection**
```bash
php sixorbit cache:gc
```

**Dry Run**
```bash
php sixorbit cache:gc --dry-run
# Output: Would delete 345 expired cache entries
```

#### Cron Schedule

```bash
# Run cache garbage collection daily at 2 AM
0 2 * * * php /var/www/html/so-backend-framework/sixorbit cache:gc
```

---

## Session Commands

### `session:cleanup`

Clean up expired sessions from the database.

#### Syntax

```bash
php sixorbit session:cleanup [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--dry-run` | `false` | Show what would be deleted |
| `--verbose` | `false` | Show detailed output |
| `--force` | `false` | Skip confirmation prompt |

#### Examples

**Clean Expired Sessions (with confirmation)**
```bash
php sixorbit session:cleanup
# Prompts: Are you sure you want to delete all expired sessions?
```

**Dry Run**
```bash
php sixorbit session:cleanup --dry-run
# Output: Would delete 157 expired sessions
```

**Force Without Confirmation**
```bash
php sixorbit session:cleanup --force
```

#### Cron Schedule

```bash
# Clean sessions every hour
0 * * * * php /var/www/html/so-backend-framework/sixorbit session:cleanup --force
```

---

## Activity Log Commands

### `activity:prune`

Archive or delete old activity log entries to maintain database performance.

#### Syntax

```bash
php sixorbit activity:prune [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--days` | `90` | Delete logs older than X days |
| `--archive` | `false` | Archive logs instead of deleting |
| `--batch` | `1000` | Number of records to process per batch |
| `--dry-run` | `false` | Show what would be deleted |
| `--verbose` | `false` | Show detailed output |
| `--force` | `false` | Skip confirmation prompt |

#### Examples

**Delete Logs Older Than 90 Days (with confirmation)**
```bash
php sixorbit activity:prune
```

**Archive Instead of Deleting**
```bash
php sixorbit activity:prune --days=180 --archive
```

**Dry Run**
```bash
php sixorbit activity:prune --dry-run
# Output: Would delete 2,847 activity log entries older than 90 days
```

**Custom Batch Size**
```bash
php sixorbit activity:prune --days=30 --batch=5000 --force
```

#### Cron Schedule

```bash
# Prune activity logs monthly
0 0 1 * * php /var/www/html/so-backend-framework/sixorbit activity:prune --days=90 --force
```

---

## Notification Commands

### `notification:cleanup`

Delete old read notifications to keep the notifications table clean.

#### Syntax

```bash
php sixorbit notification:cleanup [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--days` | `30` | Delete notifications older than X days |
| `--read-only` | `true` | Only delete read notifications |
| `--batch` | `1000` | Number of records to process per batch |
| `--dry-run` | `false` | Show what would be deleted |
| `--verbose` | `false` | Show detailed output |
| `--force` | `false` | Skip confirmation prompt |

#### Examples

**Delete Read Notifications Older Than 30 Days (with confirmation)**
```bash
php sixorbit notification:cleanup
```

**Delete All Notifications (Read and Unread)**
```bash
php sixorbit notification:cleanup --days=60 --read-only=false --force
```

**Dry Run**
```bash
php sixorbit notification:cleanup --dry-run
# Output: Would delete 1,234 notifications older than 30 days
```

#### Cron Schedule

```bash
# Clean notifications weekly
0 3 * * 0 php /var/www/html/so-backend-framework/sixorbit notification:cleanup --force
```

---

## Route Commands

### `route:list`

Display all registered routes in a formatted table.

#### Syntax

```bash
php sixorbit route:list [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--method=<GET|POST|PUT|DELETE>` | Filter by HTTP method |
| `--name=<pattern>` | Filter by route name pattern |

#### Examples

**List All Routes**
```bash
php sixorbit route:list
```

**Filter by Method**
```bash
php sixorbit route:list --method=GET
php sixorbit route:list --method=POST
```

**Filter by Name**
```bash
php sixorbit route:list --name=api
php sixorbit route:list --name=admin
```

#### Output Example

```
+--------+---------------------------+------+--------------------------------+
| Method | URI                       | Name | Action                         |
+--------+---------------------------+------+--------------------------------+
| GET    | /                         | home | WelcomeController@index        |
| GET    | /api/v1/users             |      | UserController@index           |
| POST   | /api/v1/users             |      | UserController@store           |
| GET    | /api/v1/users/{id}        |      | UserController@show            |
| PUT    | /api/v1/users/{id}        |      | UserController@update          |
| DELETE | /api/v1/users/{id}        |      | UserController@destroy         |
+--------+---------------------------+------+--------------------------------+
```

---

### `route:cache`

Create a route cache file for faster route loading in production.

#### Syntax

```bash
php sixorbit route:cache
```

#### Examples

**Cache Routes**
```bash
php sixorbit route:cache
```

**Clear Route Cache**
```bash
rm storage/framework/routes.php
```

#### Output Example

```
Routes cached successfully!
Cache file: storage/framework/routes.php
```

#### Use Case

Cache routes in production to improve performance:

```bash
# In deployment script
php sixorbit route:cache
```

---

## Security Commands

### `key:generate`

Generate a new application encryption key.

#### Syntax

```bash
php sixorbit key:generate [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--show` | Display key without updating .env |
| `--force` | Force key generation in production |

#### Examples

**Generate and Update .env**
```bash
php sixorbit key:generate
```

**Show Key Without Updating**
```bash
php sixorbit key:generate --show
```

**Force in Production**
```bash
php sixorbit key:generate --force
```

#### Output Example

```
Application key set successfully.
APP_KEY=base64:Xw8h3k9f2j4d8s6g1n5m7p0q2r4t6u8v
```

#### How It Works

1. Generates a secure 32-byte random key
2. Base64 encodes the key
3. Updates `APP_KEY` in `.env` file
4. Prefixes with `base64:` for proper decoding

#### Security Warning

**Changing the key will invalidate:**
- All encrypted data
- All signed cookies
- All session data

Only run this during initial setup or when explicitly needed.

---

### `jwt:secret`

Generate a new JWT secret for token authentication.

#### Syntax

```bash
php sixorbit jwt:secret [options]
```

#### Options

| Option | Description |
|--------|-------------|
| `--show` | Display secret without updating .env |
| `--force` | Force secret generation in production |

#### Examples

**Generate and Update .env**
```bash
php sixorbit jwt:secret
```

**Show Secret Without Updating**
```bash
php sixorbit jwt:secret --show
```

#### Output Example

```
JWT secret set successfully.
JWT_SECRET=base64:Y3n8k2m5p7r9t1u4w6x8y0z2a4b6c8d0
```

#### Security Warning

**Changing the JWT secret will invalidate:**
- All existing JWT tokens
- All active user sessions using JWT

Only run this during initial setup or when rotating secrets.

---

## Creating Custom Commands

### Step 1: Create Command Class

Create a new command class in `app/Console/Commands/`:

```php
<?php

namespace App\Console\Commands;

use Core\Console\Command;

class SendEmailReportCommand extends Command
{
    protected string $signature = 'report:email {recipient} {--type=daily} {--format=pdf}';

    protected string $description = 'Send email report to recipient';

    public function handle(): int
    {
        // Get arguments
        $recipient = $this->argument(0);

        // Get options
        $type = $this->option('type', 'daily');
        $format = $this->option('format', 'pdf');

        // Your command logic here
        $this->info("Sending {$type} report to {$recipient} in {$format} format...");

        // Perform work
        try {
            // Send report logic
            $this->info("Report sent successfully!");
            return 0; // Success
        } catch (\Exception $e) {
            $this->error("Failed to send report: " . $e->getMessage());
            return 1; // Failure
        }
    }
}
```

### Step 2: Register Command

Register your command in `sixorbit`:

```php
$kernel->registerCommands([
    \Core\Console\Commands\QueueWorkCommand::class,
    \Core\Console\Commands\CacheClearCommand::class,
    // ... other commands
    \App\Console\Commands\SendEmailReportCommand::class, // Your command
]);
```

### Step 3: Use Your Command

```bash
php sixorbit report:email user@example.com --type=monthly --format=excel
```

### Command Signature Syntax

```
command:name {argument} {argument2?} {--option} {--option2=default}
```

- `{argument}` - Required argument
- `{argument?}` - Optional argument
- `{--option}` - Boolean option (true/false)
- `{--option=default}` - Option with default value

---

## Command Options

### Available Methods

Commands extend the `Core\Console\Command` base class, which provides:

#### Input Methods

```php
// Get argument by index
$arg = $this->argument(0);
$arg = $this->argument(1, 'default value');

// Get option by name
$option = $this->option('queue');
$option = $this->option('timeout', 60);
```

#### Output Methods

```php
// Info message (standard output)
$this->info('Operation completed successfully');

// Error message (stderr)
$this->error('Something went wrong');

// Comment message
$this->comment('This is a comment');
```

#### Interactive Methods

```php
// Ask a question
$name = $this->ask('What is your name?');
$name = $this->ask('What is your name?', 'John'); // with default

// Confirmation
$confirmed = $this->confirm('Are you sure?'); // default: false
$confirmed = $this->confirm('Continue?', true); // default: true
```

---

## Running Commands

### Development

Run commands directly during development:

```bash
php sixorbit cache:clear
php sixorbit queue:work --once
php sixorbit migrate
php sixorbit db:seed
```

### Production via Cron

Schedule commands to run automatically:

```bash
# Edit crontab
crontab -e

# Add commands
0 2 * * * php /var/www/html/so-backend-framework/sixorbit cache:gc --force
0 * * * * php /var/www/html/so-backend-framework/sixorbit session:cleanup --force
0 3 * * 0 php /var/www/html/so-backend-framework/sixorbit notification:cleanup --force
0 0 1 * * php /var/www/html/so-backend-framework/sixorbit activity:prune --days=90 --force
```

### Background Execution

Run commands in the background:

```bash
# Background with output to log
php sixorbit queue:work > storage/logs/queue.log 2>&1 &

# Background with nohup
nohup php sixorbit queue:work &
```

---

## Best Practices

### 1. Error Handling

Always wrap commands in try-catch blocks:

```php
public function handle(): int
{
    try {
        // Command logic
        $this->info('Success!');
        return 0;
    } catch (\Exception $e) {
        $this->error($e->getMessage());
        return 1;
    }
}
```

### 2. Use Dry Run for Destructive Operations

Always provide `--dry-run` option for commands that delete or modify data:

```php
if ($this->option('dry-run', false)) {
    $this->comment("Would delete {$count} records");
    return 0;
}
```

### 3. Confirmation Prompts

Add confirmation for destructive operations:

```php
if (!$this->option('force', false)) {
    if (!$this->confirm('Are you sure you want to delete all records?')) {
        $this->comment('Operation cancelled.');
        return 0;
    }
}
```

### 4. Progress Feedback

Provide feedback for long-running commands:

```php
$this->info('Starting process...');
// Do work
$this->info('Step 1 complete');
// More work
$this->info('Step 2 complete');
$this->info('Process finished!');
```

### 5. Batch Processing

Process large datasets in batches:

```php
$batchSize = 1000;
$total = Model::count();
$batches = ceil($total / $batchSize);

for ($i = 0; $i < $batches; $i++) {
    $this->info("Processing batch " . ($i + 1) . " of {$batches}");
    // Process batch
}
```

---

## Complete Cron Schedule Example

```bash
# SO Framework Maintenance Commands
# Edit with: crontab -e

# Cache maintenance (daily at 2 AM)
0 2 * * * php /var/www/html/so-backend-framework/sixorbit cache:gc --force

# Clear all cache (daily at 3 AM)
0 3 * * * php /var/www/html/so-backend-framework/sixorbit cache:clear --force

# Session cleanup (hourly)
0 * * * * php /var/www/html/so-backend-framework/sixorbit session:cleanup --force

# Notification cleanup (weekly, Sunday at 3 AM)
0 3 * * 0 php /var/www/html/so-backend-framework/sixorbit notification:cleanup --days=30 --force

# Activity log pruning (monthly, 1st of month at midnight)
0 0 1 * * php /var/www/html/so-backend-framework/sixorbit activity:prune --days=90 --force
```

---

## Deployment Script Example

```bash
#!/bin/bash
# deploy.sh

echo "Starting deployment..."

# Stop queue workers
sudo supervisorctl stop so-queue-worker:*

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear cache
php sixorbit cache:clear --force

# Run database migrations
php sixorbit migrate --force

# Cache routes
php sixorbit route:cache

# Restart queue workers
sudo supervisorctl start so-queue-worker:*

echo "Deployment complete!"
```

---

## Troubleshooting

### Command Not Found

**Problem**: `Command not found: my:command`

**Solution**: Ensure command is registered in `sixorbit` file

### Permission Denied

**Problem**: `Permission denied` when running sixorbit

**Solution**:
```bash
chmod +x sixorbit
```

### Memory Limit

**Problem**: Queue worker runs out of memory

**Solution**:
```bash
php -d memory_limit=512M sixorbit queue:work
```

Or update `php.ini`:
```ini
memory_limit = 512M
```

---

## Summary

The SO Framework CLI provides **31 powerful commands** organized into categories:

### Generator Commands (12)
- [x] `make:controller` - Create controllers
- [x] `make:model` - Create models (with `--migration` support)
- [x] `make:middleware` - Create middleware
- [x] `make:mail` - Create mail classes
- [x] `make:event` - Create events
- [x] `make:listener` - Create listeners
- [x] `make:provider` - Create service providers
- [x] `make:exception` - Create exceptions
- [x] `make:service` - Create service classes
- [x] `make:request` - Create form request validators
- [x] `make:job` - Create queueable jobs
- [x] `make:repository` - Create repositories

### Migration Commands (4)
- [x] `make:migration` - Generate migrations
- [x] `migrate` - Run migrations
- [x] `migrate:rollback` - Rollback migrations
- [x] `migrate:status` - Show migration status

### Seeder Commands (2)
- [x] `make:seeder` - Create seeders
- [x] `db:seed` - Run seeders

### Maintenance Commands (5)
- [x] `queue:work` - Process queue jobs
- [x] `cache:clear` - Clear cache
- [x] `cache:gc` - Cache garbage collection
- [x] `session:cleanup` - Clean sessions
- [x] `activity:prune` - Prune activity logs
- [x] `notification:cleanup` - Clean notifications

### Route Commands (2)
- [x] `route:list` - List all routes
- [x] `route:cache` - Cache routes

### Security Commands (2)
- [x] `key:generate` - Generate APP_KEY
- [x] `jwt:secret` - Generate JWT_SECRET

### Key Features
- [x] Nested namespace support (`Admin/UserController`)
- [x] Safety flags (`--force`, `--dry-run`, `--verbose`)
- [x] Confirmation prompts for destructive operations
- [x] Batch processing for large datasets
- [x] Production-ready with proper error handling

---

**Next Steps:**
- [Migration System Documentation](#migration-commands)
- [Queue System Documentation](/docs/queue-system)
- [Cache System Documentation](/docs/cache-system)

---

**Last Updated**: 2026-01-31
**Framework Version**: {{APP_VERSION}}
**Total Commands**: 31
