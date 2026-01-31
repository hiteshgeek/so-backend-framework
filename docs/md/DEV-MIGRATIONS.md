# Database Migrations - Developer Guide

**SO Framework** | **Database Schema Management** | **Version 1.0**

A comprehensive guide to creating, managing, and deploying database schema changes using the SO Framework's migration system.

---

## Table of Contents

1. [Overview](#overview)
2. [Creating Migrations](#creating-migrations)
3. [Migration Structure](#migration-structure)
4. [Schema Builder Reference](#schema-builder-reference)
5. [Running Migrations](#running-migrations)
6. [Rolling Back Migrations](#rolling-back-migrations)
7. [Migration Strategies](#migration-strategies)
8. [Best Practices](#best-practices)

---

## Overview

Database migrations are version control for your database schema. They allow you to:

- **Define schema changes in code** -- No more manual SQL scripts or ALTER TABLE statements
- **Track schema versions** -- Know exactly which changes have been applied to each environment
- **Collaborate safely** -- Team members can apply the same schema changes automatically
- **Roll back changes** -- Undo migrations if something goes wrong
- **Deploy with confidence** -- Migrations run automatically during deployment

### How Migrations Work

1. **Create** -- Generate a new migration file using `./sixorbit make:migration`
2. **Define** -- Write the schema changes in the `up()` method
3. **Run** -- Execute migrations with `./sixorbit migrate`
4. **Track** -- The framework records each migration in the `migrations` table
5. **Rollback** -- If needed, undo changes with `./sixorbit migrate:rollback`

```
Developer                    Database
    |                            |
    | make:migration             |
    |------------------------->  |
    | Edit migration file        |
    |                            |
    | ./sixorbit migrate         |
    |------------------------->  |  Execute up() method
    |                            |  Record in migrations table
    |<-------------------------|  |
    |                            |
```

### Migration Files Location

All migrations live in `database/migrations/` and follow this naming convention:

```
YYYY_MM_DD_HHMMSS_description.php
```

Example:
```
2026_01_31_143022_create_products_table.php
2026_01_31_143155_add_price_to_products_table.php
```

The timestamp prefix ensures migrations run in chronological order.

---

## Creating Migrations

### Generate a New Migration

Use the `make:migration` command:

```bash
./sixorbit make:migration create_products_table
```

This creates `database/migrations/2026_01_31_HHMMSS_create_products_table.php`:

```php
<?php

use Core\Database\Migration;
use Core\Database\Schema;

return new class extends Migration
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Schema::create('products', function($table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

### Migration Naming Conventions

**Creating Tables:**

Use `create_<table>_table` format:

```bash
./sixorbit make:migration create_users_table
./sixorbit make:migration create_orders_table
```

**Modifying Tables:**

Use `add_<column>_to_<table>_table` or `modify_<table>_table` format:

```bash
./sixorbit make:migration add_status_to_products_table
./sixorbit make:migration add_indexes_to_users_table
./sixorbit make:migration modify_orders_table_for_shipping
```

**Removing Columns:**

Use `remove_<column>_from_<table>_table` format:

```bash
./sixorbit make:migration remove_deprecated_from_users_table
```

### Specify Table Name with --table Option

When modifying an existing table, use `--table` to generate an appropriate template:

```bash
./sixorbit make:migration add_price_to_products_table --table=products
```

This generates a migration with `Schema::table()` instead of `Schema::create()`.

---

## Migration Structure

Every migration must implement two methods:

### up() Method

Defines the forward schema change. This runs when you execute `./sixorbit migrate`.

```php
public function up(): void
{
    Schema::create('products', function($table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });
}
```

### down() Method

Defines how to undo the change. This runs when you execute `./sixorbit migrate:rollback`.

```php
public function down(): void
{
    Schema::dropIfExists('products');
}
```

The `down()` method should exactly reverse what `up()` does:

| up() | down() |
|------|--------|
| `Schema::create('products', ...)` | `Schema::dropIfExists('products')` |
| `$table->string('status')` | `$table->dropColumn('status')` |
| `$table->addIndex('email')` | `$table->dropIndex('email')` |

---

## Schema Builder Reference

The Schema builder provides a fluent interface for defining database tables and columns.

### Creating Tables

Use `Schema::create()` to create a new table:

```php
Schema::create('products', function($table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->decimal('price', 10, 2);
    $table->integer('stock')->default(0);
    $table->timestamps();
});
```

### Modifying Tables

Use `Schema::table()` to add columns to an existing table:

```php
Schema::table('products', function($table) {
    $table->boolean('featured')->default(false);
    $table->string('sku', 50)->nullable();
});
```

### Dropping Tables

```php
// Drop table if it exists (safe)
Schema::dropIfExists('products');

// Drop table (throws error if table doesn't exist)
Schema::drop('products');
```

### Checking Table Existence

```php
if (Schema::hasTable('products')) {
    // Table exists
}
```

### Renaming Tables

```php
Schema::rename('old_products', 'products');
```

---

## Column Types

### Numeric Columns

```php
$table->id();                           // Auto-incrementing BIGINT UNSIGNED PRIMARY KEY
$table->bigInteger('user_id');          // BIGINT
$table->integer('count');               // INT
$table->unsignedBigInteger('post_id');  // BIGINT UNSIGNED (for foreign keys)
$table->decimal('price', 10, 2);        // DECIMAL(10, 2) for currency
$table->boolean('is_active');           // TINYINT(1)
```

### String Columns

```php
$table->string('name');                 // VARCHAR(255)
$table->string('code', 50);             // VARCHAR(50)
$table->text('description');            // TEXT
```

### Date and Time Columns

```php
$table->date('birth_date');             // DATE
$table->dateTime('published_at');       // DATETIME
$table->timestamp('verified_at');       // TIMESTAMP
$table->timestamps();                   // created_at and updated_at TIMESTAMP columns
```

### Special Columns

```php
$table->softDeletes();                  // deleted_at TIMESTAMP NULL (for soft deletes)
$table->softDeletes('removed_at');      // Custom soft delete column name
```

---

## Column Modifiers

Modifiers change the behavior or constraints of a column.

### nullable()

Allow NULL values:

```php
$table->string('middle_name')->nullable();
$table->integer('age')->nullable();
```

### default()

Set a default value:

```php
$table->boolean('is_active')->default(true);
$table->integer('views')->default(0);
$table->string('status')->default('pending');
```

### unsigned()

Make numeric columns unsigned:

```php
$table->integer('quantity')->unsigned();
```

> **Note:** `unsignedBigInteger()` already includes unsigned, so you don't need to chain `->unsigned()`.

---

## Indexes and Constraints

### Primary Key

```php
$table->id();                           // Auto-incrementing primary key named 'id'
$table->id('product_id');               // Custom primary key column name
```

### Unique Index

```php
$table->string('email')->unique();
```

Or add separately:

```php
$table->string('email');
$table->unique('email');
```

### Regular Index

```php
$table->string('slug');
$table->index('slug');
```

---

## Foreign Keys

Define relationships between tables using foreign key constraints.

### Basic Foreign Key

```php
Schema::create('posts', function($table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->string('title');
    $table->text('body');
    $table->timestamps();

    // Define foreign key
    $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('CASCADE')
        ->onUpdate('CASCADE');
});
```

### Foreign Key Actions

**onDelete Actions:**

| Action | Behavior |
|--------|----------|
| `CASCADE` | Delete child rows when parent is deleted |
| `SET NULL` | Set foreign key to NULL when parent is deleted |
| `RESTRICT` | Prevent deletion of parent if children exist |
| `NO ACTION` | Same as RESTRICT |

**onUpdate Actions:**

Same options as onDelete. Usually set to `CASCADE` so child rows update when parent primary key changes.

### Shorthand for Foreign Keys

When the column name follows the convention `<table>_id`, you can use this shorthand:

```php
$table->unsignedBigInteger('user_id');
$table->foreign('user_id')->references('id')->on('users');
```

---

## Complete Migration Examples

### Example 1: Users Table

```php
<?php

use Core\Database\Migration;
use Core\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

### Example 2: Posts Table with Foreign Key

```php
<?php

use Core\Database\Migration;
use Core\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function($table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->string('status')->default('draft');
            $table->integer('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->index('slug');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

### Example 3: Adding Columns to Existing Table

```php
<?php

use Core\Database\Migration;
use Core\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function($table) {
            $table->boolean('featured')->default(false);
            $table->string('sku', 50)->nullable()->unique();
            $table->integer('discount_percentage')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('products', function($table) {
            // Note: In a real implementation, you'd use dropColumn()
            // For now, this is a placeholder
        });
    }
};
```

### Example 4: Junction Table for Many-to-Many

```php
<?php

use Core\Database\Migration;
use Core\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_tag', function($table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('CASCADE');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('CASCADE');

            // Composite primary key
            $table->primary(['post_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
```

---

## Running Migrations

### Run All Pending Migrations

```bash
./sixorbit migrate
```

Output:
```
Migrating: 2026_01_31_000000_create_users_table
Migrated:  2026_01_31_000000_create_users_table (45ms)
Migrating: 2026_01_31_000001_create_posts_table
Migrated:  2026_01_31_000001_create_posts_table (32ms)
```

### Check Migration Status

See which migrations have run:

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
| Yes  | 2026_01_31_000001_create_posts_table          | 1       |
| No   | 2026_01_31_123456_add_featured_to_products    | Pending |
+------+------------------------------------------------+---------+
```

### Run Migrations Step-by-Step

Run one migration at a time:

```bash
./sixorbit migrate --step=1
```

### Preview Migration SQL

See the SQL that will be executed without running it:

```bash
./sixorbit migrate --pretend
```

---

## Rolling Back Migrations

### Rollback Last Batch

Undo the most recent batch of migrations:

```bash
./sixorbit migrate:rollback
```

This executes the `down()` method of all migrations in the last batch.

### Rollback Multiple Batches

```bash
./sixorbit migrate:rollback --step=2
```

### Reset All Migrations

Rollback all migrations (WARNING: destroys all data):

```bash
./sixorbit migrate:reset
```

### Refresh Migrations

Rollback all and re-run (useful during development):

```bash
./sixorbit migrate:refresh
```

---

## Migration Strategies

### Strategy 1: Modify Table in Place

**Use When:** Adding nullable columns or columns with defaults to a small table.

```php
public function up(): void
{
    Schema::table('users', function($table) {
        $table->string('phone', 20)->nullable();
    });
}
```

**Pros:** Simple, fast
**Cons:** Can lock table during ALTER TABLE on large tables

### Strategy 2: Create New Table + Data Migration

**Use When:** Major schema restructuring or renaming columns.

```php
public function up(): void
{
    // 1. Create new table
    Schema::create('users_new', function($table) {
        // New schema
    });

    // 2. Copy data
    $users = db()->table('users')->get();
    foreach ($users as $user) {
        db()->table('users_new')->insert([
            'id' => $user['id'],
            'full_name' => $user['first_name'] . ' ' . $user['last_name'],
            // ... map old columns to new
        ]);
    }

    // 3. Drop old table
    Schema::drop('users');

    // 4. Rename new table
    Schema::rename('users_new', 'users');
}
```

**Pros:** No downtime, can transform data
**Cons:** Complex, requires more disk space temporarily

### Strategy 3: Backward-Compatible Migrations

**Use When:** Deploying to production with zero downtime.

**Phase 1 -- Add new column:**
```php
public function up(): void
{
    Schema::table('products', function($table) {
        $table->string('new_price_field')->nullable();
    });
}
```

**Phase 2 -- Backfill data:**
```php
db()->table('products')->update(['new_price_field' => db()->raw('old_price_field')]);
```

**Phase 3 -- Switch application code** to use `new_price_field`.

**Phase 4 -- Drop old column:**
```php
Schema::table('products', function($table) {
    // dropColumn() would go here
});
```

---

## Best Practices

### 1. Never Edit Existing Migrations

Once a migration has been committed and deployed, **never edit it**. Instead, create a new migration:

**Wrong:**
```php
// Editing existing migration after deployment
$table->string('email'); // Changed from string(100) to string(255)
```

**Right:**
```bash
./sixorbit make:migration increase_email_length_in_users_table
```

```php
// New migration
Schema::table('users', function($table) {
    // Modify column to increase length
});
```

### 2. Always Write down() Methods

Every `up()` must have a corresponding `down()` that reverses the change:

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
        // dropColumn('featured') would go here
    });
}
```

### 3. Use Descriptive Migration Names

**Good:**
- `create_products_table`
- `add_featured_flag_to_products_table`
- `add_indexes_to_posts_table`

**Bad:**
- `update_products`
- `migration1`
- `fix_database`

### 4. One Logical Change Per Migration

Don't combine unrelated changes:

**Wrong:**
```php
public function up(): void
{
    Schema::create('products', function($table) { /* ... */ });
    Schema::create('categories', function($table) { /* ... */ });
    Schema::create('orders', function($table) { /* ... */ });
}
```

**Right:**
```bash
./sixorbit make:migration create_products_table
./sixorbit make:migration create_categories_table
./sixorbit make:migration create_orders_table
```

### 5. Order Foreign Key Migrations Correctly

Create parent tables before child tables:

**Right Order:**
1. `create_users_table` (parent)
2. `create_posts_table` (child with user_id foreign key)

**Wrong Order:**
1. `create_posts_table` (references users table that doesn't exist yet)
2. `create_users_table`

### 6. Use Soft Deletes for User Data

For tables containing user-generated content, use soft deletes instead of hard deletes:

```php
$table->softDeletes();
```

This adds a `deleted_at` column. Records are "deleted" by setting this timestamp instead of removing the row.

### 7. Add Indexes for Foreign Keys and Frequent Queries

```php
$table->index('user_id');      // Foreign key
$table->index('created_at');   // Date range queries
$table->index('status');       // Filtering
```

### 8. Test Migrations in Development First

Before deploying:

```bash
# Run migration
./sixorbit migrate

# Test rollback
./sixorbit migrate:rollback

# Re-run migration
./sixorbit migrate

# Verify data integrity
```

### 9. Back Up Production Before Migrating

Always create a database backup before running migrations in production:

```bash
# Backup first
mysqldump -u root -p database_name > backup_before_migration.sql

# Then migrate
./sixorbit migrate
```

### 10. Use Transactions for Data Migrations

When migrating data inside a migration, wrap it in a transaction:

```php
public function up(): void
{
    $pdo = app('db')->connection->getPdo();

    $pdo->beginTransaction();

    try {
        // Schema changes
        Schema::table('users', function($table) {
            $table->string('full_name');
        });

        // Data migration
        $users = db()->table('users')->get();
        foreach ($users as $user) {
            db()->table('users')
                ->where('id', $user['id'])
                ->update([
                    'full_name' => $user['first_name'] . ' ' . $user['last_name']
                ]);
        }

        $pdo->commit();
    } catch (\Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
```

---

**Related Documentation:**
- [CLI Commands](/docs/dev/cli-commands) - Using migration commands
- [Models](/docs/dev/models) - Working with database models
- [Query Builder](/docs/query-builder) - Building database queries
- [Seeders](/docs/dev/seeders) - Populating test data

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
