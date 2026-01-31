# Database Tables Constants - Usage Guide

This directory contains constants for database table names used throughout the application.

## Why Use Constants?

Using constants instead of hard-coded table names provides:
- **Centralized management** - Change table name in one place
- **IDE autocomplete** - Better developer experience
- **Type safety** - Catch typos at development time
- **Refactoring support** - Easy to find all usages
- **Documentation** - Self-documenting code

## DatabaseTables Class

The `DatabaseTables` class contains constants for all framework and application tables.

### Structure

```
DatabaseTables
├── Essentials Tables (Framework) - Use with app('db-essentials')
│   ├── USERS
│   ├── SESSIONS
│   ├── CACHE
│   └── ... (12 total)
└── Application Tables - Use with app('db')
    ├── POSTS
    ├── PRODUCTS
    └── ... (your custom tables)
```

## Usage Examples

### In Controllers

```php
<?php

namespace App\Controllers;

use App\Constants\DatabaseTables;

class UserController
{
    public function index()
    {
        // Query users from essentials database
        $users = app('db-essentials')
            ->table(DatabaseTables::USERS)
            ->where('email', 'LIKE', '%@example.com')
            ->get();

        return response()->json($users);
    }

    public function getUserPosts($userId)
    {
        // Query posts from application database
        $posts = app('db')
            ->table(DatabaseTables::POSTS)
            ->where('user_id', $userId)
            ->get();

        return response()->json($posts);
    }
}
```

### In Models

```php
<?php

namespace App\Models;

use App\Constants\DatabaseTables;

class User
{
    protected static string $table = DatabaseTables::USERS;
    protected static string $connection = 'db-essentials';

    public static function find(int $id): ?array
    {
        return app(self::$connection)
            ->table(self::$table)
            ->where('id', $id)
            ->first();
    }

    public static function all(): array
    {
        return app(self::$connection)
            ->table(self::$table)
            ->get();
    }
}
```

### In Repositories

```php
<?php

namespace App\Repositories;

use App\Constants\DatabaseTables;

class ProductRepository
{
    public function getActiveProducts(): array
    {
        return app('db')
            ->table(DatabaseTables::PRODUCTS)
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->get();
    }

    public function getProductWithCategory(int $productId): ?array
    {
        $product = app('db')
            ->table(DatabaseTables::PRODUCTS)
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return null;
        }

        $category = app('db')
            ->table(DatabaseTables::CATEGORIES)
            ->where('id', $product['category_id'])
            ->first();

        $product['category'] = $category;
        return $product;
    }
}
```

### In Services

```php
<?php

namespace App\Services;

use App\Constants\DatabaseTables;

class SessionService
{
    public function cleanExpiredSessions(): int
    {
        $cutoff = time() - (60 * 120); // 2 hours ago

        return app('db-essentials')
            ->table(DatabaseTables::SESSIONS)
            ->where('last_activity', '<', $cutoff)
            ->delete();
    }

    public function getUserSessions(int $userId): array
    {
        return app('db-essentials')
            ->table(DatabaseTables::SESSIONS)
            ->where('user_id', $userId)
            ->get();
    }
}
```

### In Middleware

```php
<?php

namespace App\Middleware;

use App\Constants\DatabaseTables;

class ActivityLogger
{
    public function handle($request, $next)
    {
        $response = $next($request);

        // Log activity to essentials database
        app('db-essentials')
            ->table(DatabaseTables::ACTIVITY_LOG)
            ->insert([
                'log_name' => 'request',
                'description' => $request->method() . ' ' . $request->path(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

        return $response;
    }
}
```

### Cross-Database Queries

```php
<?php

namespace App\Services;

use App\Constants\DatabaseTables;

class ReviewService
{
    public function getReviewsWithUserInfo(int $productId): array
    {
        // Get reviews from app database
        $reviews = app('db')
            ->table(DatabaseTables::REVIEWS)
            ->where('product_id', $productId)
            ->where('is_approved', 1)
            ->get();

        // Enrich with user data from essentials database
        foreach ($reviews as &$review) {
            $user = app('db-essentials')
                ->table(DatabaseTables::USERS)
                ->where('id', $review['user_id'])
                ->first();

            $review['user_name'] = $user['name'] ?? 'Anonymous';
            $review['user_email'] = $user['email'] ?? null;
        }

        return $reviews;
    }
}
```

## Helper Methods

The `DatabaseTables` class provides helper methods:

### Get All Essential Tables
```php
$essentialTables = DatabaseTables::getEssentialTables();
// Returns: ['users', 'sessions', 'cache', ...]
```

### Get All Application Tables
```php
$appTables = DatabaseTables::getApplicationTables();
// Returns: ['posts', 'categories', 'products', ...]
```

### Check Table Location
```php
if (DatabaseTables::isEssentialTable('users')) {
    // Use db-essentials connection
    $db = app('db-essentials');
} else {
    // Use regular db connection
    $db = app('db');
}
```

## Adding Your Own Tables

When you add new tables to your application, add them to `DatabaseTables.php`:

```php
<?php

namespace App\Constants;

class DatabaseTables
{
    // ... existing constants ...

    // Your Application Tables
    const ORDERS = 'orders';
    const ORDER_ITEMS = 'order_items';
    const CUSTOMERS = 'customers';
    const INVOICES = 'invoices';

    // Don't forget to update getApplicationTables() method
    public static function getApplicationTables(): array
    {
        return [
            // ... existing tables ...
            self::ORDERS,
            self::ORDER_ITEMS,
            self::CUSTOMERS,
            self::INVOICES,
        ];
    }
}
```

## Best Practices

### ✅ DO

- Use constants for ALL table names
- Group related constants with comments
- Update helper methods when adding new constants
- Use meaningful constant names (singular or plural as appropriate)

### ❌ DON'T

- Don't hard-code table names in queries
- Don't use string concatenation for table names
- Don't bypass constants "just this once"

### Example - Good vs Bad

```php
// ❌ BAD - Hard-coded table name
$users = app('db-essentials')->table('users')->get();

// ✅ GOOD - Using constant
use App\Constants\DatabaseTables;
$users = app('db-essentials')->table(DatabaseTables::USERS)->get();
```

## Migration Reference

Each migration file includes comments linking table definitions to their constants:

**001_framework_essentials.sql:**
```sql
-- 1. Users Table (Authentication)
-- Constant: DatabaseTables::USERS
CREATE TABLE IF NOT EXISTS users (...)
```

**002_demo_tables.sql:**
```sql
-- 1. Posts Table (Demo content)
-- Constant: DatabaseTables::POSTS
CREATE TABLE IF NOT EXISTS posts (...)
```

## Integration with Existing Projects

If you're integrating this framework into an existing project with custom table names:

```php
<?php

namespace App\Constants;

class DatabaseTables
{
    // Framework essentials (standard names)
    const USERS = 'users';
    const SESSIONS = 'sessions';

    // Your existing tables (custom names)
    const LEGACY_USER = 'auser';
    const LEGACY_SESSION = 'auser_session';
    const LEGACY_CUSTOMER = 'customer';

    // Tables in different databases (using dot notation)
    const STATIC_USER_STATUS = 'rapidkart_factory_static.auser_status';
    const STATIC_PERMISSIONS = 'rapidkart_factory_static.apermission';
}
```

Then create custom models/handlers to work with these tables as documented in the dual database setup guide.
