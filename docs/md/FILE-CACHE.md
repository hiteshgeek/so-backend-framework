# File Cache Driver

## Overview

The File Cache Driver provides filesystem-based cache storage for the SO Backend Framework. It offers a lightweight, fast caching solution ideal for single-server applications, development environments, and scenarios where database overhead is unnecessary.

## Features

- **File-based storage** with automatic subdirectory sharding
- **TTL-based expiration** for automatic cache invalidation
- **Atomic writes** using temp file + rename pattern
- **Garbage collection** for cleaning expired entries
- **Same interface** as database cache driver
- **Supports all PHP data types** via serialization
- **Zero configuration** - works out of the box

## Installation & Configuration

### 1. Configure Cache Driver

Edit `config/cache.php` or set environment variables:

```php
// In .env
CACHE_DRIVER=file
CACHE_FILE_PATH=/path/to/cache  // Optional, defaults to storage/cache
```

### 2. Verify Storage Directory

The cache directory is created automatically at:
```
storage/cache/
├── ab/
│   ├── ab12cd34ef56...789.cache
│   └── ab98cd76ef54...321.cache
├── cd/
│   └── cd12ef34ab56...789.cache
└── ...
```

### 3. Use Cache

```php
// Put (with TTL in seconds)
cache()->put('key', 'value', 3600);

// Get
$value = cache()->get('key');

// Forever (no expiration)
cache()->forever('permanent_key', 'permanent_value');

// Forget (delete)
cache()->forget('key');

// Increment/Decrement
cache()->increment('counter');
cache()->decrement('countdown', 5);

// Flush all cache
cache()->flush();
```

## Storage Format

### File Structure

Each cache entry is stored as:
- **Directory**: `storage/cache/{hash[0-1]}/`
- **Filename**: `{hash}.cache`
- **Content**: Serialized PHP array

Example:
```
storage/cache/ab/ab123456789...def.cache
```

### File Content

```php
[
    'value' => mixed,           // The cached value
    'expiration' => int|null    // Unix timestamp or null for forever
]
```

## Subdirectory Sharding

The file cache uses subdirectory sharding to prevent filesystem bottlenecks:

```php
// Key: "user_profile_123"
// Hash: "ab123456..."
// Stored in: storage/cache/ab/ab123456....cache
```

**Benefits:**
- Prevents too many files in one directory
- Improves filesystem performance
- Better I/O distribution

## Garbage Collection

Expired cache entries are automatically removed when accessed, but you can manually trigger garbage collection:

```php
use Core\Cache\Drivers\FileCache;

$cache = new FileCache();
$deletedCount = $cache->garbageCollect();

echo "Deleted {$deletedCount} expired cache files";
```

**Recommended:** Run garbage collection via cron job:

```bash
# Daily cleanup at 2 AM
0 2 * * * cd /path/to/app && php -r "require 'vendor/autoload.php'; require 'bootstrap/app.php'; (new \Core\Cache\Drivers\FileCache())->garbageCollect();"
```

## Performance Characteristics

### Read Performance
- **Fast**: Direct file read with unserialize
- **No database overhead**
- **No network latency**

### Write Performance
- **Atomic writes** prevent corruption
- **Temp file + rename** pattern
- **Minimal locking**

### Storage
- **File size**: ~100-500 bytes per entry (depends on value size)
- **Subdirectory sharding**: ~256 subdirectories (first 2 hex chars)
- **Automatic cleanup**: Expired files deleted on access or GC

## Use Cases

### Recommended For

1. **Single-server applications**
   - No need for shared cache across servers
   - Simple deployment

2. **Development/Testing**
   - No database setup required
   - Fast iteration

3. **View/Asset Caching**
   - Compiled templates
   - Rendered views
   - Minified assets

4. **Temporary Data**
   - Rate limiting counters (single server)
   - Session data (with session handler)
   - Short-lived computations

### Not Recommended For

1. **Multi-server deployments**
   - Cache not shared across servers
   - Use database cache instead

2. **High-frequency writes**
   - File I/O overhead
   - Use in-memory cache (Redis) for hot data

3. **Large datasets**
   - Filesystem limits
   - Use database cache for large values

## Comparison with Other Drivers

| Feature | File Cache | Database Cache | Redis/Memcached |
|---------|-----------|---------------|-----------------|
| **Speed** | Fast | Medium | Very Fast |
| **Setup** | None | DB required | Server required |
| **Shared** | No | Yes | Yes |
| **Persistence** | Yes | Yes | Optional |
| **Best For** | Single server | Multi-server | High performance |

## Advanced Usage

### Direct Driver Usage

```php
use Core\Cache\Drivers\FileCache;

// Custom cache directory
$cache = new FileCache('/custom/cache/path');

// Store with TTL
$cache->put('key', 'value', 3600);

// Get value
$value = $cache->get('key');

// Garbage collection
$cache->garbageCollect();

// Get cache directory
$dir = $cache->getDirectory();
```

### Via Cache Manager

```php
// Get file cache specifically
$fileCache = cache()->store('file');

// Use like normal cache
$fileCache->put('key', 'value', 3600);
$value = $fileCache->get('key');
```

### Mixed Strategy

Use different drivers for different purposes:

```php
// File cache for views
$viewCache = app('cache')->driver('file');
$viewCache->put('compiled_view', $html, 3600);

// Database cache for shared data
$sharedCache = app('cache')->driver('database');
$sharedCache->put('global_settings', $settings, 3600);
```

## Atomic Writes

The file cache uses atomic writes to prevent corruption:

```php
// 1. Write to temporary file
$tempPath = $directory . '/tmp_' . uniqid();
file_put_contents($tempPath, serialize($data));

// 2. Atomic rename (single filesystem operation)
rename($tempPath, $finalPath);

// Result: Either complete write or nothing (no partial data)
```

## Troubleshooting

### Permission Issues

```bash
# Fix permissions
chmod 755 storage/cache
chown -R www-data:www-data storage/cache
```

### Disk Space

```bash
# Check cache size
du -sh storage/cache

# Manual cleanup
rm -rf storage/cache/*/
```

### Performance Issues

```php
// Run garbage collection
(new \Core\Cache\Drivers\FileCache())->garbageCollect();

// Or flush all
cache()->flush();
```

## Testing

Run file cache tests:

```bash
php sixorbit test file-cache
```

## API Reference

### Methods

#### `put(string $key, mixed $value, int $seconds): bool`
Store an item in the cache with TTL.

#### `get(string $key): mixed`
Retrieve an item from the cache (returns null if not found/expired).

#### `forever(string $key, mixed $value): bool`
Store an item indefinitely (no expiration).

#### `forget(string $key): bool`
Remove an item from the cache.

#### `flush(): bool`
Remove all items from the cache.

#### `increment(string $key, int $value = 1): int`
Increment a numeric value.

#### `decrement(string $key, int $value = 1): int`
Decrement a numeric value.

#### `garbageCollect(): int`
Remove expired cache entries (returns count of deleted files).

#### `getDirectory(): string`
Get the cache storage directory path.

## Related Documentation

- [Cache System](CACHE.md)
- [Configuration](CONFIGURATION.md)
- [Performance Optimization](PERFORMANCE.md)

## Support

For issues or questions:
- GitHub: https://github.com/sixorbit/backend-framework
- Documentation: `/docs`
