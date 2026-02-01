# Multi-Database Support - Dual Database Architecture

**File:** `config/database.php`
**Purpose:** Connect to multiple databases within a single application for shared resources and microservices architecture

---

## Table of Contents
- [Overview](#overview)
- [Configuration](#configuration)
- [Model Connection Routing](#model-connection-routing)
- [Use Cases](#use-cases)
- [Query Execution](#query-execution)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)

---

## Overview

The SO Framework supports connecting to multiple databases simultaneously, enabling:

**Features:**
- ✅ Multiple MySQL/PostgreSQL connections
- ✅ Per-model connection configuration
- ✅ Shared resource databases (essentials pattern)
- ✅ Microservices data federation
- ✅ Legacy system integration
- ✅ Read/write splitting (master/replica)

**Common Architectures:**

1. **Main + Essentials (ERP Pattern)**
   - Main DB: Application-specific data (orders, invoices, products)
   - Essentials DB: Shared resources (users, departments, settings)

2. **Microservices Federation**
   - Each service has its own database
   - Application queries across multiple services

3. **Legacy Integration**
   - New application database
   - Legacy system database (read-only)

4. **Read/Write Splitting**
   - Master database (writes)
   - Replica database (reads)

**Architecture Diagram:**
```
┌─────────────────────────────────────────────────────────┐
│            APPLICATION LAYER                             │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌──────────────┐        ┌──────────────┐              │
│  │ Order Model  │        │ User Model   │              │
│  │ connection:  │        │ connection:  │              │
│  │   "db"       │        │ "essentials" │              │
│  └──────┬───────┘        └──────┬───────┘              │
│         │                       │                       │
│         ▼                       ▼                       │
│  ┌─────────────────┐    ┌─────────────────┐           │
│  │ Main Database   │    │ Essentials DB   │           │
│  │ (MySQL)         │    │ (MySQL)         │           │
│  ├─────────────────┤    ├─────────────────┤           │
│  │ orders          │    │ auser           │           │
│  │ products        │    │ departments     │           │
│  │ invoices        │    │ roles           │           │
│  │ inventory       │    │ settings        │           │
│  └─────────────────┘    └─────────────────┘           │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## Configuration

### 1. Database Configuration File

**config/database.php:**

```php
<?php

return [
    // Default connection (used when model doesn't specify)
    'default' => env('DB_CONNECTION', 'db'),

    // Database connections
    'connections' => [
        // Main application database
        'db' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'myapp'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],

        // Shared resources database (essentials)
        'essentials' => [
            'driver' => 'mysql',
            'host' => env('ESSENTIALS_HOST', 'localhost'),
            'port' => env('ESSENTIALS_PORT', '3306'),
            'database' => env('ESSENTIALS_DATABASE', 'essentials'),
            'username' => env('ESSENTIALS_USERNAME', 'root'),
            'password' => env('ESSENTIALS_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],

        // Legacy system database (read-only)
        'legacy' => [
            'driver' => 'mysql',
            'host' => env('LEGACY_HOST', 'legacy-server'),
            'port' => env('LEGACY_PORT', '3306'),
            'database' => env('LEGACY_DATABASE', 'old_system'),
            'username' => env('LEGACY_USERNAME', 'readonly'),
            'password' => env('LEGACY_PASSWORD', ''),
            'charset' => 'latin1', // Legacy charset
            'collation' => 'latin1_swedish_ci',
        ],

        // PostgreSQL example
        'analytics' => [
            'driver' => 'pgsql',
            'host' => env('ANALYTICS_HOST', 'localhost'),
            'port' => env('ANALYTICS_PORT', '5432'),
            'database' => env('ANALYTICS_DATABASE', 'analytics'),
            'username' => env('ANALYTICS_USERNAME', 'postgres'),
            'password' => env('ANALYTICS_PASSWORD', ''),
            'charset' => 'utf8',
            'schema' => 'public',
        ],
    ],
];
```

### 2. Environment Variables

**.env:**

```env
# Main Database
DB_CONNECTION=db
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=myapp
DB_USERNAME=root
DB_PASSWORD=secret

# Essentials Database (Shared Resources)
ESSENTIALS_HOST=localhost
ESSENTIALS_PORT=3306
ESSENTIALS_DATABASE=essentials
ESSENTIALS_USERNAME=root
ESSENTIALS_PASSWORD=secret

# Legacy Database (Read-Only)
LEGACY_HOST=legacy-server.local
LEGACY_PORT=3306
LEGACY_DATABASE=old_system
LEGACY_USERNAME=readonly_user
LEGACY_PASSWORD=readonly_pass

# Analytics Database (PostgreSQL)
ANALYTICS_HOST=analytics.local
ANALYTICS_PORT=5432
ANALYTICS_DATABASE=analytics
ANALYTICS_USERNAME=postgres
ANALYTICS_PASSWORD=analytics_pass
```

---

## Model Connection Routing

### 1. Specifying Model Connection

Each model can specify which database connection to use:

**Example: Order Model (Main Database)**

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Order extends Model
{
    protected static string $table = 'orders';
    protected static string $connection = 'db'; // Main database
    protected static string $primaryKey = 'id';

    protected array $fillable = [
        'user_id', 'order_number', 'total', 'status'
    ];
}
```

**Example: User Model (Essentials Database)**

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\ActivityLog\LogsActivity;
use Core\Notifications\Notifiable;

class User extends Model
{
    use LogsActivity, Notifiable;

    protected static string $table = 'auser';
    protected static string $connection = 'essentials'; // Essentials database
    protected static string $primaryKey = 'uid';

    protected array $fillable = [
        'name', 'email', 'password', 'empid', 'designation'
    ];
}
```

**Example: Legacy Customer Model (Read-Only)**

```php
<?php

namespace App\Models;

use Core\Model\Model;

class LegacyCustomer extends Model
{
    protected static string $table = 'customers';
    protected static string $connection = 'legacy'; // Legacy database
    protected static string $primaryKey = 'customer_id';

    // Read-only model - override save/delete methods
    public function save(): bool
    {
        throw new \Exception('Cannot modify legacy database - read-only');
    }

    public function delete(): bool
    {
        throw new \Exception('Cannot delete from legacy database - read-only');
    }
}
```

### 2. Dynamic Connection Switching

**Example: Switch connection at runtime**

```php
<?php

use Core\Database\Connection;

// Get connection instance
$mainDb = Connection::getInstance('db');
$essentialsDb = Connection::getInstance('essentials');

// Execute queries
$orders = $mainDb->select('SELECT * FROM orders WHERE status = ?', ['pending']);
$users = $essentialsDb->select('SELECT * FROM auser WHERE ustatusid = ?', [1]);
```

---

## Use Cases

### Use Case 1: ERP with Shared User Database

**Scenario:** Multiple applications share the same user/authentication database

**Structure:**
- **Essentials DB:** Users, departments, roles, settings (shared across apps)
- **App 1 DB:** Sales orders, invoices
- **App 2 DB:** Inventory, products
- **App 3 DB:** HR, payroll

**Implementation:**

```php
<?php

// Shared User Model (essentials connection)
namespace App\Models;

use Core\Model\Model;

class User extends Model
{
    protected static string $connection = 'essentials';
    protected static string $table = 'auser';
    protected static string $primaryKey = 'uid';
}

// App-specific Order Model (main connection)
class Order extends Model
{
    protected static string $connection = 'db';
    protected static string $table = 'orders';

    // Relationship to shared User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }
}

// Usage: Join across databases
$order = Order::find(1);
$customer = $order->user(); // Queries essentials database

echo "Order #{$order->id} belongs to {$customer->name}";
```

**Benefits:**
- Single source of truth for users
- Centralized authentication
- Share departments, roles, settings across apps
- Independent application databases

### Use Case 2: Microservices Data Federation

**Scenario:** Query data from multiple microservices

**Structure:**
- **Users Service:** User management
- **Products Service:** Product catalog
- **Orders Service:** Order processing

**Implementation:**

```php
<?php

use Core\Database\Connection;

class OrderReportController
{
    public function generateReport()
    {
        $usersDb = Connection::getInstance('users_service');
        $productsDb = Connection::getInstance('products_service');
        $ordersDb = Connection::getInstance('orders_service');

        // Fetch data from each service
        $users = $usersDb->select('SELECT id, name, email FROM users WHERE active = 1');
        $products = $productsDb->select('SELECT id, name, price FROM products');
        $orders = $ordersDb->select('SELECT * FROM orders WHERE created_at > ?', [
            date('Y-m-d', strtotime('-30 days'))
        ]);

        // Combine data
        $report = [
            'total_users' => count($users),
            'total_products' => count($products),
            'total_orders' => count($orders),
            'revenue' => array_sum(array_column($orders, 'total'))
        ];

        return json($report);
    }
}
```

### Use Case 3: Legacy System Integration

**Scenario:** Migrate from legacy system while maintaining read access to old data

**Structure:**
- **New DB:** Modern application (MySQL 8.0, utf8mb4)
- **Legacy DB:** Old system (MySQL 5.1, latin1, read-only)

**Implementation:**

```php
<?php

namespace App\Models;

use Core\Model\Model;

// New customer model
class Customer extends Model
{
    protected static string $connection = 'db';
    protected static string $table = 'customers';
}

// Legacy customer model (read-only)
class LegacyCustomer extends Model
{
    protected static string $connection = 'legacy';
    protected static string $table = 'customers';

    // Prevent modifications
    public function save(): bool
    {
        throw new \Exception('Legacy database is read-only');
    }
}

// Migration controller
class MigrationController
{
    public function migrateCustomers()
    {
        $legacyCustomers = LegacyCustomer::all();

        foreach ($legacyCustomers as $legacy) {
            // Check if already migrated
            if (!Customer::where('legacy_id', $legacy->id)->exists()) {
                // Create in new database
                Customer::create([
                    'legacy_id' => $legacy->id,
                    'name' => $legacy->name,
                    'email' => $legacy->email,
                    'phone' => $legacy->phone,
                    'migrated_at' => now()->format('Y-m-d H:i:s')
                ]);
            }
        }

        return json(['message' => 'Migration complete']);
    }
}
```

### Use Case 4: Read/Write Splitting (Master/Replica)

**Scenario:** Scale reads by using database replicas

**Structure:**
- **Master DB:** Handles all writes (INSERT, UPDATE, DELETE)
- **Replica DB:** Handles reads (SELECT) - replicates from master

**Implementation:**

```php
<?php

// config/database.php
return [
    'connections' => [
        'master' => [
            'driver' => 'mysql',
            'host' => env('DB_MASTER_HOST', 'master.db.local'),
            'database' => 'myapp',
            // ... credentials
        ],
        'replica' => [
            'driver' => 'mysql',
            'host' => env('DB_REPLICA_HOST', 'replica.db.local'),
            'database' => 'myapp',
            // ... credentials (read-only user)
        ],
    ],
];

// Smart model with read/write splitting
namespace App\Models;

use Core\Model\Model;
use Core\Database\Connection;

class Product extends Model
{
    protected static string $table = 'products';

    // Override to use replica for reads
    public static function all(): array
    {
        $connection = Connection::getInstance('replica');
        return $connection->select('SELECT * FROM ' . static::$table);
    }

    // Writes go to master (default connection)
    protected static string $connection = 'master';
}
```

---

## Query Execution

### 1. Model Queries (Automatic Routing)

```php
<?php

// User model uses 'essentials' connection automatically
$users = User::all(); // Queries essentials database

// Order model uses 'db' connection automatically
$orders = Order::where('status', 'pending')->get(); // Queries main database
```

### 2. Raw Queries with Specific Connection

```php
<?php

use Core\Database\Connection;

// Main database query
$mainDb = Connection::getInstance('db');
$orders = $mainDb->select('SELECT * FROM orders WHERE total > ?', [1000]);

// Essentials database query
$essentialsDb = Connection::getInstance('essentials');
$users = $essentialsDb->select('SELECT * FROM auser WHERE ustatusid = ?', [1]);

// Legacy database query
$legacyDb = Connection::getInstance('legacy');
$oldCustomers = $legacyDb->select('SELECT * FROM customers LIMIT 100');
```

### 3. Transactions Across Connections

**⚠️ IMPORTANT:** Transactions are per-connection, not global.

```php
<?php

use Core\Database\Connection;

$mainDb = Connection::getInstance('db');
$essentialsDb = Connection::getInstance('essentials');

try {
    // Start transaction on main database
    $mainDb->beginTransaction();

    // Insert order
    $mainDb->insert('INSERT INTO orders (user_id, total) VALUES (?, ?)', [1, 500]);

    // Update inventory
    $mainDb->update('UPDATE products SET stock = stock - ? WHERE id = ?', [10, 5]);

    // Commit main database
    $mainDb->commit();

    // NOTE: Cannot rollback essentials DB changes from main DB transaction
    // Each connection has its own transaction scope

} catch (\Exception $e) {
    $mainDb->rollback();
    throw $e;
}
```

**For distributed transactions, use application-level coordination:**

```php
<?php

class DistributedTransaction
{
    public function executeAcrossConnections()
    {
        $mainDb = Connection::getInstance('db');
        $essentialsDb = Connection::getInstance('essentials');

        $mainDb->beginTransaction();
        $essentialsDb->beginTransaction();

        try {
            // Main DB operations
            $mainDb->insert('INSERT INTO orders ...');

            // Essentials DB operations
            $essentialsDb->update('UPDATE auser ...');

            // Commit both
            $mainDb->commit();
            $essentialsDb->commit();

        } catch (\Exception $e) {
            // Rollback both
            $mainDb->rollback();
            $essentialsDb->rollback();
            throw $e;
        }
    }
}
```

---

## Best Practices

### 1. Connection Naming Convention

**✅ DO:**
```php
'connections' => [
    'db',           // Main application database
    'essentials',   // Shared resources
    'legacy',       // Legacy system
    'analytics',    // Analytics/reporting
]
```

**❌ DON'T:**
```php
'connections' => [
    'database1',    // Ambiguous
    'db2',          // Not descriptive
    'temp',         // Unclear purpose
]
```

### 2. Document Connection Purpose

```php
<?php

/**
 * User Model
 *
 * Connects to the essentials database which is shared across all applications.
 * This ensures a single source of truth for user authentication and profiles.
 *
 * Connection: essentials
 * Table: auser
 */
class User extends Model
{
    protected static string $connection = 'essentials';
}
```

### 3. Use Read-Only for Legacy/External Databases

```php
<?php

class LegacyModel extends Model
{
    protected static string $connection = 'legacy';

    // Prevent accidental modifications
    public function save(): bool
    {
        throw new \RuntimeException('Legacy database is read-only');
    }

    public function delete(): bool
    {
        throw new \RuntimeException('Cannot delete from legacy database');
    }

    public static function create(array $data): static
    {
        throw new \RuntimeException('Cannot create in legacy database');
    }
}
```

### 4. Environment-Specific Connections

```php
// .env.production
ESSENTIALS_HOST=essentials-prod.db.local
ESSENTIALS_DATABASE=essentials_prod

// .env.staging
ESSENTIALS_HOST=essentials-staging.db.local
ESSENTIALS_DATABASE=essentials_staging

// .env.development
ESSENTIALS_HOST=localhost
ESSENTIALS_DATABASE=essentials_dev
```

### 5. Connection Pooling

```php
<?php

// Reuse connection instances
$db = Connection::getInstance('db'); // First call creates connection
$sameDb = Connection::getInstance('db'); // Reuses existing connection

// Both $db and $sameDb point to the same PDO instance
```

---

## Troubleshooting

### Error: "Connection [xyz] not configured"

**Cause:** Connection name doesn't exist in `config/database.php`

**Solution:**
```php
// config/database.php
'connections' => [
    'xyz' => [ // Add missing connection
        'driver' => 'mysql',
        'host' => env('XYZ_HOST'),
        // ...
    ],
],
```

### Error: "SQLSTATE[HY000] [1045] Access denied"

**Cause:** Wrong database credentials in `.env`

**Solution:**
```env
# Check credentials match database server
DB_USERNAME=correct_user
DB_PASSWORD=correct_password
```

### Cross-Database Relationships Not Working

**Problem:** Cannot join tables across different database connections

**Solution:** Use application-level joins instead of database JOINs:

```php
<?php

// ❌ DON'T: Database JOIN across connections (won't work)
// $results = DB::select('SELECT * FROM db.orders JOIN essentials.users ...');

// ✅ DO: Application-level join
$order = Order::find(1); // From 'db' connection
$user = User::find($order->user_id); // From 'essentials' connection

$result = [
    'order' => $order,
    'customer' => $user
];
```

### Performance Issues with Multiple Connections

**Problem:** Too many database connections slowing down application

**Solutions:**

1. **Use connection pooling** (already built-in)
2. **Close unused connections:**
   ```php
   Connection::getInstance('legacy')->close();
   ```
3. **Lazy load connections** (only connect when needed)
4. **Use caching for cross-database queries:**
   ```php
   $user = cache()->remember('user_' . $userId, 3600, function() use ($userId) {
       return User::find($userId);
   });
   ```

---

## See Also

- **[DATABASE-SYSTEM.md](/docs/database-system)** - Database configuration guide
- **[DEV-MODELS.md](/docs/dev-models)** - Model ORM and relationships
- **[SCHEMA-BUILDER.md](/docs/schema-builder)** - Table creation across connections
- **[CACHE-SYSTEM.md](/docs/cache-system)** - Caching cross-database queries
- **[MIGRATION-GUIDE.md](/docs/dev-migrations)** - Migrations for multiple databases

---

**Version:** 2.0.0
**Last Updated:** 2026-02-01
**Tested:** MySQL 8.0+, PostgreSQL 13+, Multi-database production environments
