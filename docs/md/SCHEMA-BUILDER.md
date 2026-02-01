# Schema Builder - Database Table Management

**Files:** `core/Database/Schema.php`, `core/Database/Blueprint.php`
**Purpose:** Fluent API for creating, modifying, and managing database tables

---

## Table of Contents
- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Column Types](#column-types)
- [Modifiers](#modifiers)
- [Indexes](#indexes)
- [Complete Examples](#complete-examples)
- [Migration Integration](#migration-integration)
- [Best Practices](#best-practices)

---

## Overview

The SO Framework Schema Builder provides a database-agnostic way to create and modify database tables using PHP code instead of raw SQL.

**Features:**
- ✅ Fluent, chainable API
- ✅ Database-agnostic (MySQL, PostgreSQL)
- ✅ 15+ column types
- ✅ Primary keys, indexes, foreign keys
- ✅ Column modifiers (nullable, default, unique)
- ✅ Table existence checks
- ✅ Integration with migration system

**Benefits:**
- Write once, run on any supported database
- Type-safe column definitions
- Readable, maintainable table schemas
- Version control friendly (no SQL dumps)
- Automatic migration rollback support

**Architecture:**
```
┌─────────────────────────────────────────────────────────┐
│              SCHEMA BUILDER FLOW                         │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Schema::create('users', function($table) {             │
│      $table->id();                                       │
│      $table->string('email')->unique();                 │
│  })                                                      │
│      │                                                   │
│      ▼                                                   │
│  Blueprint Class                                         │
│      │                                                   │
│      ├── Collect column definitions                      │
│      ├── Collect indexes                                 │
│      └── Collect constraints                             │
│      │                                                   │
│      ▼                                                   │
│  Generate SQL                                            │
│      │                                                   │
│      ├── CREATE TABLE users (                            │
│      │       id INT AUTO_INCREMENT PRIMARY KEY,          │
│      │       email VARCHAR(255) UNIQUE                   │
│      │   )                                               │
│      │                                                   │
│      ▼                                                   │
│  Execute on Database                                     │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## Basic Usage

### 1. Create a Table

**Example: Create a simple users table**

```php
<?php

use Core\Database\Schema;

Schema::create('users', function ($table) {
    $table->id(); // Auto-increment primary key
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps(); // created_at, updated_at
});
```

**Generated SQL (MySQL):**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
)
```

### 2. Drop a Table

**Example: Drop existing table**

```php
<?php

use Core\Database\Schema;

Schema::drop('users');
```

**Generated SQL:**
```sql
DROP TABLE IF EXISTS users
```

### 3. Check if Table Exists

**Example: Conditional table creation**

```php
<?php

use Core\Database\Schema;

if (!Schema::hasTable('users')) {
    Schema::create('users', function ($table) {
        $table->id();
        $table->string('name');
    });
}
```

### 4. Get All Tables

**Example: List all database tables**

```php
<?php

use Core\Database\Schema;

$tables = Schema::getAllTables();

foreach ($tables as $table) {
    echo "Table: {$table}\n";
}

// Output:
// Table: users
// Table: products
// Table: orders
```

---

## Column Types

The Blueprint class provides 15+ column type methods:

### Integer Types

```php
<?php

$table->id();                    // Auto-increment primary key (alias for increments)
$table->increments('id');         // Auto-increment INT
$table->integer('votes');         // INT
$table->tinyInteger('status');    // TINYINT
$table->smallInteger('count');    // SMALLINT
$table->bigInteger('population'); // BIGINT
```

### String Types

```php
<?php

$table->string('name');               // VARCHAR(255)
$table->string('code', 10);           // VARCHAR(10) - custom length
$table->text('description');          // TEXT
$table->char('type', 1);              // CHAR(1) - fixed length
```

### Date and Time Types

```php
<?php

$table->date('birth_date');           // DATE
$table->datetime('appointment_time'); // DATETIME
$table->timestamp('created_at');      // TIMESTAMP
$table->timestamps();                 // created_at + updated_at TIMESTAMP columns
```

### Boolean Type

```php
<?php

$table->boolean('is_active');         // BOOLEAN (TINYINT(1) in MySQL)
```

### Decimal Types

```php
<?php

$table->decimal('price', 8, 2);       // DECIMAL(8,2) - total 8 digits, 2 decimals
$table->float('rating');              // FLOAT
$table->double('latitude');           // DOUBLE
```

### Binary Types

```php
<?php

$table->binary('data');               // BLOB
```

### JSON Type

```php
<?php

$table->json('settings');             // JSON (MySQL 5.7+, PostgreSQL)
```

---

## Modifiers

Chain modifiers to customize column behavior:

### nullable()

**Allow NULL values**

```php
<?php

$table->string('middle_name')->nullable();
// VARCHAR(255) NULL
```

### default()

**Set default value**

```php
<?php

$table->integer('votes')->default(0);
// INT DEFAULT 0

$table->boolean('is_active')->default(true);
// BOOLEAN DEFAULT 1

$table->string('status')->default('pending');
// VARCHAR(255) DEFAULT 'pending'
```

### unique()

**Create unique constraint**

```php
<?php

$table->string('email')->unique();
// VARCHAR(255) UNIQUE
```

### primary()

**Set as primary key**

```php
<?php

$table->string('code', 10)->primary();
// VARCHAR(10) PRIMARY KEY
```

**Note:** Use `$table->id()` instead for auto-increment primary keys.

### Combining Modifiers

```php
<?php

$table->string('username', 50)->unique()->nullable()->default(null);
// VARCHAR(50) UNIQUE NULL DEFAULT NULL
```

---

## Indexes

### Single Column Index

```php
<?php

$table->string('email');
$table->index('email'); // Creates index on email column
```

### Multi-Column Index

```php
<?php

$table->index(['user_id', 'created_at']); // Composite index
```

### Unique Index

```php
<?php

$table->unique('username'); // UNIQUE constraint
$table->unique(['company_id', 'employee_number']); // Composite unique
```

### Named Indexes

```php
<?php

$table->index('email', 'idx_user_email'); // Custom index name
```

---

## Complete Examples

### Example 1: Users Table with Authentication

```php
<?php

use Core\Database\Schema;

Schema::create('users', function ($table) {
    // Primary key
    $table->id();

    // Authentication fields
    $table->string('email', 100)->unique();
    $table->string('password');
    $table->string('remember_token', 100)->nullable();

    // Profile fields
    $table->string('name');
    $table->string('phone', 20)->nullable();
    $table->text('bio')->nullable();

    // Status and roles
    $table->boolean('is_active')->default(true);
    $table->string('role', 20)->default('user');

    // Email verification
    $table->timestamp('email_verified_at')->nullable();

    // Timestamps
    $table->timestamps();

    // Indexes
    $table->index('email'); // Fast login lookups
    $table->index(['role', 'is_active']); // Admin queries
});
```

**Generated SQL:**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    bio TEXT NULL,
    is_active BOOLEAN DEFAULT 1,
    role VARCHAR(20) DEFAULT 'user',
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_users_email (email),
    INDEX idx_users_role_is_active (role, is_active)
)
```

### Example 2: Products Table for E-Commerce

```php
<?php

use Core\Database\Schema;

Schema::create('products', function ($table) {
    $table->id();

    // Product details
    $table->string('sku', 50)->unique();
    $table->string('name');
    $table->text('description')->nullable();

    // Pricing
    $table->decimal('price', 10, 2);
    $table->decimal('sale_price', 10, 2)->nullable();
    $table->integer('stock_quantity')->default(0);

    // Categories and organization
    $table->integer('category_id');
    $table->string('brand', 100)->nullable();

    // Metadata
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_active')->default(true);
    $table->json('attributes')->nullable(); // {"color": "red", "size": "L"}

    // SEO
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();

    // Timestamps
    $table->timestamps();

    // Soft deletes
    $table->timestamp('deleted_at')->nullable();

    // Indexes for performance
    $table->index('sku');
    $table->index('category_id');
    $table->index(['is_active', 'is_featured']);
    $table->index('deleted_at'); // For soft delete queries
});
```

### Example 3: Orders Table with Foreign Keys

```php
<?php

use Core\Database\Schema;

Schema::create('orders', function ($table) {
    $table->id();

    // Customer information
    $table->integer('user_id');
    $table->string('customer_name');
    $table->string('customer_email');
    $table->string('customer_phone', 20);

    // Order details
    $table->string('order_number', 20)->unique();
    $table->decimal('subtotal', 10, 2);
    $table->decimal('tax', 10, 2)->default(0);
    $table->decimal('shipping', 10, 2)->default(0);
    $table->decimal('total', 10, 2);

    // Status tracking
    $table->string('status', 20)->default('pending'); // pending, processing, shipped, delivered, cancelled
    $table->string('payment_status', 20)->default('unpaid'); // unpaid, paid, refunded
    $table->string('payment_method', 50)->nullable();

    // Shipping information
    $table->text('shipping_address');
    $table->string('tracking_number', 100)->nullable();
    $table->timestamp('shipped_at')->nullable();
    $table->timestamp('delivered_at')->nullable();

    // Timestamps
    $table->timestamps();

    // Indexes
    $table->index('user_id');
    $table->index('order_number');
    $table->index(['status', 'created_at']); // Admin dashboard queries
    $table->index('payment_status');
});
```

### Example 4: Activity Log Table (Audit Trail)

```php
<?php

use Core\Database\Schema;

Schema::create('activity_log', function ($table) {
    $table->id();

    // Log metadata
    $table->string('log_name')->nullable();
    $table->text('description');
    $table->integer('causer_id')->nullable(); // Who performed the action
    $table->string('causer_type')->nullable(); // User::class
    $table->json('properties')->nullable(); // Old/new values

    // Subject (what was changed)
    $table->integer('subject_id')->nullable();
    $table->string('subject_type')->nullable(); // Product::class, Order::class

    // Batch tracking (group related operations)
    $table->string('batch_uuid', 36)->nullable();

    // Timestamp
    $table->timestamps();

    // Indexes for fast lookups
    $table->index(['causer_type', 'causer_id']);
    $table->index(['subject_type', 'subject_id']);
    $table->index('log_name');
    $table->index('batch_uuid');
    $table->index('created_at'); // Pruning old logs
});
```

### Example 5: Sessions Table (Database Sessions)

```php
<?php

use Core\Database\Schema;

Schema::create('sessions', function ($table) {
    $table->string('id', 255)->primary(); // Session ID
    $table->integer('user_id')->nullable();
    $table->string('ip_address', 45)->nullable(); // IPv6 support
    $table->text('user_agent')->nullable();
    $table->text('payload');
    $table->integer('last_activity');

    // Indexes
    $table->index('user_id');
    $table->index('last_activity'); // Cleanup expired sessions
});
```

---

## Migration Integration

The Schema Builder is designed to work with the migration system.

### Migration Example

**File:** `database/migrations/2026_02_01_000001_create_users_table.php`

```php
<?php

use Core\Database\Migration;
use Core\Database\Schema;

return new class extends Migration
{
    /**
     * Run the migration
     */
    public function up(): void
    {
        Schema::create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration
     */
    public function down(): void
    {
        Schema::drop('users');
    }
};
```

### Run Migration

```bash
php artisan migrate
```

**Output:**
```
Migrating: 2026_02_01_000001_create_users_table
Migrated:  2026_02_01_000001_create_users_table (0.05 seconds)
```

### Rollback Migration

```bash
php artisan migrate:rollback
```

**Output:**
```
Rolling back: 2026_02_01_000001_create_users_table
Rolled back:  2026_02_01_000001_create_users_table (0.03 seconds)
```

---

## Best Practices

### 1. Always Use Migrations

**✅ DO:**
```php
// In migration file
Schema::create('users', function ($table) {
    $table->id();
});
```

**❌ DON'T:**
```php
// Direct Schema usage in controllers
Schema::create('users', ...); // Wrong! Use migrations
```

### 2. Name Tables Plural

**✅ DO:**
```php
Schema::create('users', ...);
Schema::create('products', ...);
Schema::create('order_items', ...);
```

**❌ DON'T:**
```php
Schema::create('user', ...); // Singular
```

### 3. Use id() for Primary Keys

**✅ DO:**
```php
$table->id(); // Auto-increment INT primary key
```

**❌ DON'T:**
```php
$table->integer('id')->primary(); // Less readable
```

### 4. Add Indexes for Foreign Keys

**✅ DO:**
```php
$table->integer('user_id');
$table->index('user_id'); // Fast JOIN queries
```

### 5. Use timestamps()

**✅ DO:**
```php
$table->timestamps(); // created_at, updated_at
```

**Benefit:** Automatic change tracking with Model timestamps.

### 6. Document Complex Schemas

**✅ DO:**
```php
Schema::create('orders', function ($table) {
    // Customer information
    $table->integer('user_id');
    $table->string('customer_name');

    // Order details
    $table->string('order_number')->unique();
    $table->decimal('total', 10, 2);

    // Status tracking
    $table->string('status')->default('pending'); // pending, processing, shipped, delivered
});
```

### 7. Use Descriptive Column Names

**✅ DO:**
```php
$table->timestamp('email_verified_at');
$table->timestamp('shipped_at');
$table->boolean('is_active');
```

**❌ DON'T:**
```php
$table->timestamp('verified'); // Ambiguous
$table->boolean('active'); // Not obviously boolean
```

---

## See Also

- **[DEV-MIGRATIONS.md](/docs/dev-migrations)** - Database migrations guide
- **[DEV-MODELS.md](/docs/dev-models)** - Model ORM and relationships
- **[MULTI-DATABASE.md](/docs/multi-database)** - Multi-database setup
- **[DATABASE-SYSTEM.md](/docs/database-system)** - Database configuration

---

**Version:** 2.0.0
**Last Updated:** 2026-02-01
**Tested:** MySQL 8.0+, PostgreSQL 13+
