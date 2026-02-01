# Caching - Developer Guide

**SO Framework** | **Using Cache Effectively** | **Version 1.0**

A practical guide to using caching to improve application performance by storing frequently accessed data.

---

## Table of Contents

1. [Overview](#overview)
2. [Basic Cache Operations](#basic-cache-operations)
3. [Cache Drivers](#cache-drivers)
4. [Caching Strategies](#caching-strategies)
5. [Common Patterns](#common-patterns)
6. [Best Practices](#best-practices)
7. [When to Use Each Cache Driver](#when-to-use-each-cache-driver)

---

## Overview

Caching stores frequently accessed data in fast storage to reduce database queries, external API calls, and expensive computations.

### When to Use Cache

**Good candidates for caching:**
- Database query results that don't change often
- External API responses
- Computed values (aggregations, statistics)
- Configuration data
- User session data

**Bad candidates for caching:**
- Frequently changing data
- User-specific sensitive data
- Real-time data

### Accessing Cache

Use the `cache()` helper function:

```php
// Store a value
cache()->put('key', 'value', 3600); // 3600 seconds = 1 hour

// Retrieve a value
$value = cache()->get('key');

// Remember pattern (fetch from cache or execute callback)
$users = cache()->remember('users', 3600, function() {
    return User::all();
});
```

---

## Basic Cache Operations

### Store and Retrieve

```php
// Store for 1 hour (3600 seconds)
cache()->put('user_count', 1250, 3600);

// Retrieve
$count = cache()->get('user_count');

// Retrieve with default if not found
$count = cache()->get('user_count', 0);
```

### Store Forever

```php
// Store indefinitely (until manually deleted)
cache()->forever('site_settings', [
    'site_name' => 'My App',
    'maintenance_mode' => false,
]);

// Retrieve
$settings = cache()->get('site_settings');
```

### Check if Exists

```php
if (cache()->has('user_count')) {
    $count = cache()->get('user_count');
} else {
    // Fetch from database
}
```

### Delete from Cache

```php
// Delete a specific key
cache()->forget('user_count');

// Delete multiple keys
cache()->forget('user_count');
cache()->forget('post_count');
```

### Clear All Cache

```php
// Clear entire cache
cache()->flush();
```

---

## Cache Drivers

The framework supports three cache drivers:

### 1. Database Driver (Default)

Stores cache in the `cache` table:

```php
// config/cache.php
return [
    'default' => 'database',
    'stores' => [
        'database' => [
            'driver' => 'database',
            'table' => 'cache',
        ],
    ],
];
```

**Pros:** Persistent, supports multiple servers
**Cons:** Slower than file/array cache

### 2. File Driver

Stores cache in files:

```php
return [
    'default' => 'file',
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => storage_path('cache'),
        ],
    ],
];
```

**Pros:** Fast, persistent
**Cons:** File system overhead

### 3. Array Driver

Stores cache in memory (current request only):

```php
return [
    'default' => 'array',
    'stores' => [
        'array' => [
            'driver' => 'array',
        ],
    ],
];
```

**Pros:** Extremely fast
**Cons:** Lost after request ends, not shared between requests

### Using Specific Stores

```php
// Use database store
cache()->store('database')->put('key', 'value', 3600);

// Use file store
cache()->store('file')->put('key', 'value', 3600);

// Use array store (request-scoped)
cache()->store('array')->put('key', 'value', 3600);
```

---

## Caching Strategies

### 1. Remember Pattern

Most common pattern - fetch from cache or execute callback:

```php
use App\Models\User;

public function index(): Response
{
    // Try cache first, execute query if not cached
    $users = cache()->remember('users.all', 3600, function() {
        return User::all();
    });

    return Response::view('users/index', ['users' => $users]);
}
```

**How it works:**
1. Check if `users.all` exists in cache
2. If yes, return cached value
3. If no, execute the callback (database query)
4. Store result in cache for 1 hour
5. Return result

### 2. Remember Forever Pattern

```php
$settings = cache()->rememberForever('app.settings', function() {
    return db()->table('settings')->get();
});
```

Cache never expires unless manually deleted.

### 3. Cache Invalidation

Invalidate cache when data changes:

```php
use App\Models\Post;

public function store(Request $request): Response
{
    $post = Post::create($request->all());

    // Invalidate cached posts list
    cache()->forget('posts.all');
    cache()->forget('posts.latest');

    return redirect('/posts');
}

public function update(Request $request, int $id): Response
{
    $post = Post::find($id);
    $post->update($request->all());

    // Invalidate specific post cache
    cache()->forget("posts.{$id}");
    cache()->forget('posts.all');

    return redirect("/posts/{$id}");
}
```

### 4. Cache Tags (Manual Implementation)

Group related cache keys for bulk invalidation:

```php
// Helper function to generate tagged keys
function cacheKey(string $tag, string $key): string
{
    return "{$tag}.{$key}";
}

// Store with tag prefix
cache()->put(cacheKey('users', 'all'), $users, 3600);
cache()->put(cacheKey('users', 'count'), $count, 3600);

// Clear all user-related cache
function clearUserCache(): void
{
    cache()->forget('users.all');
    cache()->forget('users.count');
    cache()->forget('users.active');
    // ... etc
}
```

---

## Common Patterns

### Caching Database Queries

```php
// Single record
public function show(int $id): Response
{
    $post = cache()->remember("posts.{$id}", 3600, function() use ($id) {
        return Post::find($id);
    });

    return Response::view('posts/show', ['post' => $post]);
}

// Collection
public function index(): Response
{
    $posts = cache()->remember('posts.all', 3600, function() {
        return Post::where('published', true)->orderBy('created_at', 'desc')->get();
    });

    return Response::view('posts/index', ['posts' => $posts]);
}
```

### Caching Aggregations

```php
public function dashboard(): Response
{
    $stats = cache()->remember('dashboard.stats', 3600, function() {
        return [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'active_users' => User::where('last_login_at', '>', now()->subDays(7))->count(),
        ];
    });

    return Response::view('dashboard', ['stats' => $stats]);
}
```

### Caching External API Calls

```php
use Core\Http\Client;

public function weather(string $city): Response
{
    $weather = cache()->remember("weather.{$city}", 1800, function() use ($city) {
        $response = Client::get("https://api.weather.com/v1/weather?city={$city}");
        return json_decode($response, true);
    });

    return Response::json($weather);
}
```

### Caching Computed Values

```php
public function statistics(): Response
{
    $stats = cache()->remember('reports.monthly', 86400, function() {
        // Expensive calculation
        $data = db()->table('orders')
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->where('created_at', '>=', now()->subMonth())
            ->groupBy('date')
            ->get();

        return $this->processStatistics($data);
    });

    return Response::view('reports/monthly', ['stats' => $stats]);
}
```

### Counter Caching

```php
// Increment page views
public function show(int $id): Response
{
    $post = Post::find($id);

    // Increment view counter in cache
    $views = cache()->increment("posts.{$id}.views");

    // Persist to database every 10 views
    if ($views % 10 === 0) {
        $post->update(['views' => $views]);
    }

    return Response::view('posts/show', ['post' => $post, 'views' => $views]);
}

// Get current views
$views = cache()->get("posts.{$id}.views", $post->views);
```

### Cache Warming

Pre-populate cache during deployment or scheduled tasks:

```php
// Console command or deployment script
public function warmCache(): void
{
    // Cache homepage data
    cache()->remember('homepage.featured_posts', 3600, function() {
        return Post::where('featured', true)->limit(5)->get();
    });

    // Cache navigation menu
    cache()->remember('nav.menu', 86400, function() {
        return Category::all();
    });

    // Cache user counts
    cache()->remember('stats.user_count', 3600, function() {
        return User::count();
    });
}
```

---

## Best Practices

### 1. Use Descriptive Cache Keys

```php
// Bad - unclear what this is
cache()->remember('u1', 3600, fn() => User::find(1));

// Good - clear and namespaced
cache()->remember('users.1', 3600, fn() => User::find(1));
cache()->remember('posts.latest.10', 3600, fn() => Post::latest()->limit(10)->get());
```

### 2. Choose Appropriate TTL (Time To Live)

```php
// Short TTL for frequently changing data
cache()->remember('cart.items', 300, fn() => $this->getCartItems()); // 5 minutes

// Medium TTL for semi-static data
cache()->remember('posts.all', 3600, fn() => Post::all()); // 1 hour

// Long TTL for rarely changing data
cache()->remember('categories', 86400, fn() => Category::all()); // 24 hours

// Forever for truly static data
cache()->rememberForever('site.config', fn() => Config::all());
```

### 3. Always Invalidate on Updates

```php
public function updatePost(Request $request, int $id): Response
{
    $post = Post::find($id);
    $post->update($request->all());

    // Invalidate all related cache
    cache()->forget("posts.{$id}");
    cache()->forget('posts.all');
    cache()->forget('posts.latest.10');

    return redirect("/posts/{$id}");
}
```

### 4. Cache Serializable Data Only

```php
// Bad - caching objects
cache()->put('user', $userObject, 3600); // Might fail on retrieval

// Good - cache arrays
cache()->put('user', $user->toArray(), 3600);

// Good - cache primitives
cache()->put('user_id', $user->id, 3600);
cache()->put('user_count', 150, 3600);
```

### 5. Handle Cache Failures Gracefully

```php
public function getUsers(): array
{
    try {
        return cache()->remember('users.all', 3600, function() {
            return User::all();
        });
    } catch (\Exception $e) {
        // Log error
        logger()->error('Cache failed, falling back to database', ['error' => $e->getMessage()]);

        // Fallback to direct query
        return User::all();
    }
}
```

### 6. Use Cache Locks for Expensive Operations

Prevent duplicate expensive operations (cache stampede):

```php
use Core\Cache\Lock;

public function report(): array
{
    // Try to get from cache
    $report = cache()->get('reports.daily');
    if ($report) {
        return $report;
    }

    // Acquire lock to prevent multiple processes from generating report
    $lock = cache()->lock('reports.daily.lock', 10);

    if ($lock->get()) {
        try {
            // Double-check cache (another process might have just populated it)
            $report = cache()->get('reports.daily');
            if ($report) {
                return $report;
            }

            // Generate expensive report
            $report = $this->generateDailyReport();

            // Cache result
            cache()->put('reports.daily', $report, 86400);

            return $report;
        } finally {
            $lock->release();
        }
    }

    // Couldn't get lock, wait and retry
    sleep(1);
    return cache()->get('reports.daily', []);
}
```

### 7. Monitor Cache Hit Rates

Track cache effectiveness:

```php
public function getWithMetrics(string $key, callable $callback)
{
    $start = microtime(true);

    if (cache()->has($key)) {
        $value = cache()->get($key);
        logger()->info('Cache hit', ['key' => $key, 'time' => microtime(true) - $start]);
        return $value;
    }

    $value = $callback();
    cache()->put($key, $value, 3600);
    logger()->info('Cache miss', ['key' => $key, 'time' => microtime(true) - $start]);

    return $value;
}
```

### 8. Clear Cache in CLI

```bash
# Clear all cache
./sixorbit cache:clear

# Clear specific keys in code
cache()->forget('key1');
cache()->forget('key2');
```

---

## Complete Example: Blog with Caching

```php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use App\Models\Post;

class BlogController
{
    /**
     * List all published posts (cached)
     */
    public function index(): Response
    {
        $posts = cache()->remember('blog.posts.published', 3600, function() {
            return Post::where('published', true)
                ->orderBy('published_at', 'desc')
                ->limit(20)
                ->get();
        });

        return Response::view('blog/index', ['posts' => $posts]);
    }

    /**
     * Show single post (cached)
     */
    public function show(int $id): Response
    {
        $post = cache()->remember("blog.posts.{$id}", 3600, function() use ($id) {
            return Post::find($id);
        });

        if (!$post) {
            return Response::view('errors/404', [], 404);
        }

        // Increment view counter
        cache()->increment("blog.posts.{$id}.views");

        return Response::view('blog/show', ['post' => $post]);
    }

    /**
     * Create new post (invalidates cache)
     */
    public function store(Request $request): Response
    {
        $post = Post::create($request->all());

        // Invalidate cached post lists
        cache()->forget('blog.posts.published');
        cache()->forget('blog.posts.latest');

        return redirect("/blog/{$post->id}");
    }

    /**
     * Update post (invalidates cache)
     */
    public function update(Request $request, int $id): Response
    {
        $post = Post::find($id);
        $post->update($request->all());

        // Invalidate specific post and lists
        cache()->forget("blog.posts.{$id}");
        cache()->forget('blog.posts.published');
        cache()->forget('blog.posts.latest');

        return redirect("/blog/{$id}");
    }

    /**
     * Delete post (invalidates cache)
     */
    public function destroy(int $id): Response
    {
        $post = Post::find($id);
        $post->delete();

        // Invalidate caches
        cache()->forget("blog.posts.{$id}");
        cache()->forget("blog.posts.{$id}.views");
        cache()->forget('blog.posts.published');

        return redirect('/blog');
    }
}
```

---

## When to Use Each Cache Driver

Choosing the right cache driver depends on your application's requirements, infrastructure, and performance needs.

### Decision Matrix

| Factor | Database | File | Array |
|--------|----------|------|-------|
| **Performance** | Moderate (SQL overhead) | Fast (file I/O) | Fastest (RAM only) |
| **Persistence** | ✅ Survives restarts | ✅ Survives restarts | ❌ Request-scoped only |
| **Multi-Server** | ✅ Shared cache | ⚠️ Server-specific | ❌ Not shared |
| **Setup Required** | Database + migration | File permissions | None |
| **Best For** | Shared hosting, clusters | Single server apps | Testing, request-scoped |
| **Scalability** | ✅ Scales with DB | ⚠️ Limited by disk I/O | ❌ Not scalable |
| **Cache Size** | Large (depends on DB) | Large (depends on disk) | Small (RAM limited) |

### Use Database Cache When:

✅ **Running on multiple servers** - Database cache is shared across all servers
✅ **Using shared hosting** - Most shared hosts don't allow file writes outside certain dirs
✅ **Need transactional consistency** - Cache updates can be part of DB transactions
✅ **Don't have Redis/Memcached** - Database is universally available

❌ **Avoid When:**
- Performance is critical (sub-10ms response times)
- Caching high-frequency data (1000s of reads/sec)
- Limited database connections

**Example Use Cases:**
- User session data in load-balanced environments
- Application settings shared across servers
- API rate limiting counters

**Configuration:**
```php
// config/cache.php
return [
    'default' => 'database',
    'stores' => [
        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => 'mysql',  // Use specific DB connection
        ],
    ],
];
```

### Use File Cache When:

✅ **Single server deployment** - No need for shared cache
✅ **Better performance than database** - Faster file I/O vs SQL queries
✅ **Large cache sizes** - Disk space cheaper than RAM
✅ **Simple setup** - No database migrations needed

❌ **Avoid When:**
- Multiple web servers (cache not shared)
- Containerized deployments (ephemeral filesystems)
- Limited disk I/O (slow disks, high traffic)

**Example Use Cases:**
- Rendered HTML fragments
- Compiled view templates
- API response caching on single server
- Development/staging environments

**Configuration:**
```php
// config/cache.php
return [
    'default' => 'file',
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => storage_path('cache'),
            'permissions' => 0755,  // Directory permissions
        ],
    ],
];
```

**File Structure:**
```
storage/cache/
├── 1a/2b/1a2b3c4d5e6f... (hashed keys)
├── 5f/8a/5f8a9b0c1d2e...
└── cache.index (optional index file)
```

### Use Array Cache When:

✅ **Testing** - Fast, isolated cache per test
✅ **Request-scoped data** - Data only needed within single request
✅ **Development** - No persistence needed
✅ **Temporary calculations** - Avoid recalculating within same request

❌ **Avoid When:**
- Need persistence beyond request
- Sharing data between requests
- Production caching

**Example Use Cases:**
- Caching computed values during single request
- Memoization within request lifecycle
- Unit/integration testing
- Avoiding duplicate API calls in same request

**Configuration:**
```php
// config/cache.php
return [
    'default' => 'array',
    'stores' => [
        'array' => [
            'driver' => 'array',
            'serialize' => false,  // Skip serialization for speed
        ],
    ],
];
```

**Usage Example:**
```php
// Avoid duplicate API calls in same request
public function getUserProfile(int $userId)
{
    return cache()->store('array')->remember("user.{$userId}", 3600, function() use ($userId) {
        return $this->apiClient->fetchUser($userId);
    });
}

// First call: hits API
// Second call in same request: returns from array cache
// Next request: fresh API call
```

### Hybrid Approach: Multiple Stores

Use different stores for different purposes:

```php
// config/cache.php
return [
    'default' => 'file',  // General caching
    'stores' => [
        'file' => ['driver' => 'file', 'path' => storage_path('cache')],
        'database' => ['driver' => 'database', 'table' => 'cache'],
        'array' => ['driver' => 'array'],
    ],
];
```

```php
// Use file cache for view rendering
cache()->store('file')->remember('homepage.rendered', 3600, function() {
    return view('home/index');
});

// Use database cache for rate limiting (shared across servers)
cache()->store('database')->remember('rate_limit:' . $ip, 60, function() {
    return ['count' => 0, 'expires' => time() + 60];
});

// Use array cache for request-scoped memoization
cache()->store('array')->remember('expensive_calc:' . $id, 3600, function() use ($id) {
    return $this->performExpensiveCalculation($id);
});
```

### Migration Path

**Starting Small:**
1. Start with `file` cache (simple, fast setup)
2. Monitor performance and cache hit rates
3. Migrate to `database` when scaling to multiple servers
4. Consider Redis/Memcached for high-traffic production

**Switching Drivers:**
```bash
# Flush old cache before switching
php sixorbit cache:clear

# Update config/cache.php
# Change 'default' => 'database'

# Run migration if using database driver
php sixorbit migrate
```

---

## See Also

- **[Cache System](CACHE-SYSTEM.md)** - Technical cache architecture
- **[File Cache](FILE-CACHE.md)** - File-based caching deep dive
- **[Models](DEV-MODELS.md)** - Caching query results
- **[CLI Commands](CONSOLE-COMMANDS.md)** - `cache:clear`, `cache:forget` commands
- **[Helper Functions](DEV-HELPERS.md)** - `cache()` helper usage
- **[Session System](SESSION-SYSTEM.md)** - Session caching strategies

---

**Last Updated**: 2026-02-01
**Framework Version**: 1.0
