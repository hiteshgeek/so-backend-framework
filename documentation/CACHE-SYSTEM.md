# Cache System

**Performance Optimization and Load Reduction**

The Cache System provides high-performance caching with multiple drivers, cache locks, and advanced features to reduce database load by 60-80% and significantly improve application response times.

---

## Table of Contents

1. [Introduction](#introduction)
2. [Quick Start](#quick-start)
3. [Architecture](#architecture)
4. [Basic Operations](#basic-operations)
5. [Cache Locks](#cache-locks)
6. [Advanced Usage](#advanced-usage)
7. [Configuration](#configuration)
8. [ERP Use Cases](#erp-use-cases)
9. [Best Practices](#best-practices)

---

## Introduction

### What is Caching?

Caching stores frequently accessed data in fast storage (memory or database) to avoid expensive operations:
- **Database queries** - Cache query results instead of querying every time
- **API responses** - Cache external API data
- **Computed values** - Cache expensive calculations
- **Templates** - Cache rendered views/reports

### Why Critical for ERP?

**Performance Impact**:
- 60-80% reduction in database load
- 10x faster response times for cached data
- Reduced server resource consumption
- Better scalability

**ERP Benefits**:
- Product catalogs load instantly
- Pricing calculations cached
- User permissions cached
- Reports cached for 1 hour

---

## Quick Start

### Step 1: Basic Cache Operations

```php
// Store value for 1 hour (3600 seconds)
cache()->put('products.featured', $products, 3600);

// Retrieve value
$products = cache()->get('products.featured');

// Check if exists
if (cache()->has('products.featured')) {
    $products = cache()->get('products.featured');
} else {
    $products = Product::where('featured', true)->get();
    cache()->put('products.featured', $products, 3600);
}
```

### Step 2: Remember Pattern

The remember pattern automatically caches if not present:

```php
// Compute once, cache result
$users = cache()->remember('users.active', 3600, function() {
    return User::where('status', 'active')->get();
});

// First call: Executes query and caches result
// Subsequent calls: Returns cached value (no query)
```

### Step 3: Clear Cache

```php
// Remove specific item
cache()->forget('products.featured');

// Clear all cache
cache()->flush();

// Or use artisan command
php artisan cache:clear
```

---

## Architecture

### Components

**1. Repository** (`core/Cache/Repository.php`)
- Main cache interface
- Methods: get, put, remember, forget, flush, increment, decrement
- Unified API for all cache drivers

**2. CacheManager** (`core/Cache/CacheManager.php`)
- Manages multiple cache stores
- Resolves cache drivers (database, array)
- Provides `cache()` helper

**3. DatabaseCache Driver** (`core/Cache/Drivers/DatabaseCache.php`)
- Stores cache in database (`cache` table)
- JSON serialization
- TTL (time-to-live) management
- Sharable across servers

**4. ArrayCache Driver** (`core/Cache/Drivers/ArrayCache.php`)
- In-memory cache (request-level)
- Fastest but not persistent
- Useful for single-request caching

**5. Lock** (`core/Cache/Lock.php`)
- Prevents race conditions
- Uses `cache_locks` table
- Ensures only one process does expensive work

### Database Schema

**cache table**:
```sql
CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT UNSIGNED NOT NULL,
    INDEX idx_expiration (expiration)
);
```

**cache_locks table**:
```sql
CREATE TABLE cache_locks (
    `key` VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT UNSIGNED,
    INDEX idx_expiration (expiration)
);
```

---

## Basic Operations

### Store (Put)

```php
// Store for 1 hour
cache()->put('key', 'value', 3600);

// Store with prefix (from config)
cache()->put('user:1:profile', $profile, 7200);

// Store complex data (auto-serialized)
cache()->put('user:1:data', [
    'name' => 'John',
    'email' => 'john@example.com',
    'permissions' => ['read', 'write']
], 3600);
```

### Store Forever

```php
// Store permanently (actually 10 years)
cache()->forever('site.settings', $settings);
```

### Retrieve (Get)

```php
// Get value
$value = cache()->get('key');

// Get with default if not exists
$value = cache()->get('key', 'default_value');

// Get with callback default
$value = cache()->get('key', function() {
    return 'computed_default';
});
```

### Check Existence

```php
if (cache()->has('products.list')) {
    $products = cache()->get('products.list');
}
```

### Remove (Forget)

```php
// Remove single key
cache()->forget('key');

// Clear all cache
cache()->flush();
```

### Remember Pattern

**Best practice** - Automatically cache if not exists:

```php
$products = cache()->remember('products.all', 3600, function() {
    // This only runs if cache miss
    return Product::all();
});
```

### Increment / Decrement

**Atomic counters**:

```php
// Initialize counter
cache()->put('page.views', 0, 3600);

// Increment by 1
$views = cache()->increment('page.views');

// Increment by custom value
$views = cache()->increment('page.views', 5);

// Decrement
$stock = cache()->decrement('product:123:stock', 1);
```

---

## Cache Locks

### Why Locks?

Prevent multiple processes from doing the same expensive work:

```php
// [X] Without lock: 10 requests hit at same time
// All 10 generate the report (wasteful)
$report = generateExpensiveReport();

// [x] With lock: Only 1 generates, others wait
$lock = cache()->lock('report-generation', 60);

if ($lock->acquire()) {
    $report = generateExpensiveReport();
    cache()->put('report', $report, 3600);
    $lock->release();
}
```

### Basic Lock Usage

```php
$lock = cache()->lock('expensive-operation', 60); // 60 second timeout

if ($lock->acquire()) {
    try {
        // Do expensive work
        $result = performExpensiveOperation();

        // Cache result
        cache()->put('result', $result, 3600);
    } finally {
        // Always release
        $lock->release();
    }
} else {
    // Another process is working, wait for cache
    sleep(1);
    $result = cache()->get('result');
}
```

### Lock with Timeout

```php
$lock = cache()->lock('process-import', 300); // 5 minute timeout

if ($lock->acquire()) {
    // Process large import
    // Lock auto-expires after 300 seconds if not released
    processImport();
    $lock->release();
}
```

### Check Lock Status

```php
$lock = cache()->lock('report-generation');

if ($lock->isAcquired()) {
    echo "Another process is generating the report\n";
}
```

### Force Release (Admin)

```php
// Force release lock (use carefully!)
$lock = cache()->lock('stuck-process');
$lock->forceRelease();
```

---

## Advanced Usage

### Cache Tags (Manual Implementation)

Group related cache items:

```php
// Store with tag prefix
cache()->put('product:123', $product, 3600);
cache()->put('product:456', $product2, 3600);

// Clear all product cache
$prefix = config('cache.prefix', '') . 'product:';
DB::table('cache')->where('key', 'LIKE', $prefix . '%')->delete();
```

### Conditional Caching

```php
// Only cache successful results
function getUser($id) {
    return cache()->remember("user:{$id}", 3600, function() use ($id) {
        $user = User::find($id);

        if (!$user) {
            // Don't cache null results
            cache()->forget("user:{$id}");
            return null;
        }

        return $user;
    });
}
```

### Bulk Operations

```php
// Store multiple items
$data = [
    'key1' => 'value1',
    'key2' => 'value2',
    'key3' => 'value3'
];

foreach ($data as $key => $value) {
    cache()->put($key, $value, 3600);
}

// Retrieve multiple items
$keys = ['key1', 'key2', 'key3'];
$values = [];

foreach ($keys as $key) {
    $values[$key] = cache()->get($key);
}
```

---

## Configuration

### config/cache.php

```php
<?php

return [
    // Default cache store
    'default' => env('CACHE_DRIVER', 'database'),

    // Available stores
    'stores' => [
        'database' => [
            'driver' => 'database',
            'table' => 'cache',
        ],

        'array' => [
            'driver' => 'array',
        ],
    ],

    // Cache key prefix (useful for multi-tenant)
    'prefix' => env('CACHE_PREFIX', 'so_cache'),
];
```

### Environment Variables

```env
CACHE_DRIVER=database
CACHE_PREFIX=so_cache
```

### Multiple Stores

```php
// Use different store
$arrayCache = cache()->store('array');
$arrayCache->put('temp', 'value', 60);

// Default store
cache()->put('perm', 'value', 3600);
```

---

## ERP Use Cases

### 1. Product Catalog

**Problem**: 50,000 products queried on every page load.

**Solution**:
```php
$products = cache()->remember('products.catalog', 3600, function() {
    return Product::with('category', 'images')
        ->where('status', 'active')
        ->get();
});

// Invalidate on product update
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $product->update($request->all());

    // Clear cache
    cache()->forget('products.catalog');
}
```

### 2. Pricing Rules

**Problem**: Complex pricing calculations on every cart view.

**Solution**:
```php
function calculatePrice($productId, $userId) {
    $cacheKey = "price:{$productId}:{$userId}";

    return cache()->remember($cacheKey, 1800, function() use ($productId, $userId) {
        $product = Product::find($productId);
        $user = User::find($userId);

        // Complex calculation
        $basePrice = $product->price;
        $discount = calculateDiscount($user, $product);
        $tax = calculateTax($product, $user->region);

        return $basePrice - $discount + $tax;
    });
}
```

### 3. User Permissions

**Problem**: Permission check on every request queries database.

**Solution**:
```php
function userHasPermission($userId, $permission) {
    $cacheKey = "permissions:{$userId}";

    $permissions = cache()->remember($cacheKey, 3600, function() use ($userId) {
        return DB::table('user_permissions')
            ->where('user_id', $userId)
            ->pluck('permission')
            ->toArray();
    });

    return in_array($permission, $permissions);
}

// Clear on permission change
public function updatePermissions($userId, $permissions)
{
    // Update database
    DB::table('user_permissions')->where('user_id', $userId)->delete();
    // ... insert new permissions

    // Clear cache
    cache()->forget("permissions:{$userId}");
}
```

### 4. Report Results

**Problem**: Complex report takes 5 minutes to generate.

**Solution**:
```php
$lock = cache()->lock('monthly-report', 600);

if ($lock->acquire()) {
    try {
        $report = cache()->remember('report:sales:2026-01', 3600, function() {
            // 5-minute expensive operation
            return generateSalesReport('2026-01');
        });

        $lock->release();
    } catch (\Exception $e) {
        $lock->release();
        throw $e;
    }
}

return $report;
```

### 5. Configuration Settings

**Problem**: System settings queried from database on every request.

**Solution**:
```php
function getSetting($key, $default = null) {
    $settings = cache()->rememberForever('system.settings', function() {
        return DB::table('settings')->pluck('value', 'key')->toArray();
    });

    return $settings[$key] ?? $default;
}

// Clear on settings update
public function updateSetting($key, $value)
{
    DB::table('settings')->updateOrInsert(['key' => $key], ['value' => $value]);
    cache()->forget('system.settings');
}
```

---

## Best Practices

### 1. Cache Key Naming Convention

```php
// [x] Good: Clear, hierarchical
'products:123'
'user:456:profile'
'report:sales:2026-01'
'permissions:user:789'

// [X] Bad: Unclear, flat
'p123'
'data'
'result'
```

### 2. Appropriate TTL Selection

```php
// Very stable data: 1 day
cache()->put('system.settings', $settings, 86400);

// Moderately stable: 1 hour
cache()->put('products.catalog', $products, 3600);

// Frequently changing: 5 minutes
cache()->put('stock.levels', $stock, 300);

// Request-level: Use array driver
cache()->store('array')->put('temp', $data, 60);
```

### 3. Cache Invalidation Strategy

```php
class ProductController
{
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        // Invalidate related cache
        cache()->forget("product:{$id}");
        cache()->forget('products.catalog');
        cache()->forget("category:{$product->category_id}:products");
    }
}
```

### 4. Use Remember Pattern

```php
// [X] Manual caching (verbose, error-prone)
$users = cache()->get('users');
if (!$users) {
    $users = User::all();
    cache()->put('users', $users, 3600);
}

// [x] Remember pattern (clean, safe)
$users = cache()->remember('users', 3600, function() {
    return User::all();
});
```

### 5. Avoid Cache Stampede

Use locks to prevent stampede:

```php
function getExpensiveData() {
    // Check cache first
    $data = cache()->get('expensive.data');
    if ($data) return $data;

    // Acquire lock
    $lock = cache()->lock('expensive.data.lock', 60);

    if ($lock->acquire()) {
        try {
            // Double-check cache (another process may have computed it)
            $data = cache()->get('expensive.data');
            if ($data) {
                $lock->release();
                return $data;
            }

            // Compute and cache
            $data = computeExpensiveData();
            cache()->put('expensive.data', $data, 3600);

            $lock->release();
            return $data;
        } catch (\Exception $e) {
            $lock->release();
            throw $e;
        }
    }

    // Lock held by another process, wait and retry
    sleep(1);
    return cache()->get('expensive.data');
}
```

### 6. Monitor Cache Size

```sql
-- Check cache table size
SELECT COUNT(*) as total_keys,
       SUM(LENGTH(value)) as total_bytes
FROM cache;

-- Check expired entries
SELECT COUNT(*) FROM cache WHERE expiration < UNIX_TIMESTAMP();
```

### 7. Regular Garbage Collection

```bash
# Cron job (hourly)
0 * * * * php artisan cache:gc
```

---

## Troubleshooting

### Cache Not Working

**1. Check driver configuration**:
```php
var_dump(config('cache.default')); // Should be 'database'
```

**2. Verify table exists**:
```sql
SHOW TABLES LIKE 'cache';
```

**3. Check permissions**:
```sql
SELECT * FROM cache LIMIT 1;
INSERT INTO cache (`key`, value, expiration) VALUES ('test', 'value', 999999999);
```

### Stale Cache Data

**Symptom**: Old data still showing after update.

**Solutions**:
1. Clear cache after updates: `cache()->forget($key)`
2. Reduce TTL
3. Implement cache tagging
4. Use cache versioning

```php
// Cache versioning
$version = cache()->get('cache.version', 1);
$key = "products:{$version}";

// Invalidate all by bumping version
cache()->increment('cache.version');
```

### Performance Issues

**Problem**: Cache lookups slow.

**Solutions**:
1. Ensure index on expiration column
2. Regular garbage collection
3. Consider partitioning cache table
4. Use shorter TTLs

---

## Summary

The Cache System provides:

[x] **Database driver** - Share cache across servers
[x] **Remember pattern** - Automatic caching
[x] **Cache locks** - Prevent race conditions and stampedes
[x] **TTL management** - Automatic expiration
[x] **Increment/decrement** - Atomic counters
[x] **Multiple stores** - Database, array (request-level)

**Essential for ERP performance**:
- 60-80% reduction in database load
- 10x faster response for cached data
- Product catalogs, pricing, permissions
- Report caching
- Configuration settings

**Start caching today for dramatic performance improvements.**

---

**Next Steps**:
- Identify frequently accessed data
- Implement remember pattern for expensive queries
- Set up `cache:gc` cron job
- Monitor cache hit rates
- Review [FRAMEWORK-FEATURES.md](FRAMEWORK-FEATURES.md) for overview

**Version**: 2.0.0 | **Last Updated**: 2026-01-29
