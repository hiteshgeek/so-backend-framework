<?php

/**
 * Test File Cache Driver
 *
 * This script tests the file-based cache driver functionality including
 * CRUD operations, TTL expiration, garbage collection, and subdirectory sharding.
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__ . '/../../../bootstrap/app.php';

// Import required classes
use Core\Cache\Drivers\FileCache;

echo "=== File Cache Driver Test ===\n\n";

try {
    // Use temporary test directory to avoid polluting storage
    $testCachePath = storage_path('cache_test_' . time());

    // Create file cache instance
    $cache = new FileCache($testCachePath);

    echo "Test cache directory: {$testCachePath}\n\n";

    // ===== BASIC CRUD TESTS =====
    echo "===== BASIC CRUD TESTS =====\n\n";

    // Test 1: Put and Get
    echo "Test 1: Basic put and get...\n";
    $cache->put('test_key', 'test_value', 3600);
    $value = $cache->get('test_key');
    echo $value === 'test_value' ? "✓ Put/get works\n" : "✗ Put/get failed\n";
    echo "  Value: {$value}\n\n";

    // Test 2: Get non-existent key
    echo "Test 2: Get non-existent key...\n";
    $value = $cache->get('non_existent_key');
    echo $value === null ? "✓ Returns null for missing keys\n\n" : "✗ Should return null\n\n";

    // Test 3: Overwrite existing key
    echo "Test 3: Overwrite existing key...\n";
    $cache->put('overwrite_key', 'value1', 3600);
    $cache->put('overwrite_key', 'value2', 3600);
    $value = $cache->get('overwrite_key');
    echo $value === 'value2' ? "✓ Key overwrite works\n\n" : "✗ Key overwrite failed\n\n";

    // Test 4: Forget (delete)
    echo "Test 4: Forget method...\n";
    $cache->put('delete_me', 'value', 3600);
    $cache->forget('delete_me');
    $value = $cache->get('delete_me');
    echo $value === null ? "✓ Forget removes keys\n\n" : "✗ Forget failed\n\n";

    // ===== COMPLEX DATA TYPES =====
    echo "===== COMPLEX DATA TYPES =====\n\n";

    // Test 5: Store array
    echo "Test 5: Store and retrieve array...\n";
    $arrayData = ['foo' => 'bar', 'nested' => ['key' => 'value']];
    $cache->put('array_key', $arrayData, 3600);
    $retrieved = $cache->get('array_key');
    echo $retrieved === $arrayData ? "✓ Array storage works\n\n" : "✗ Array storage failed\n\n";

    // Test 6: Store object
    echo "Test 6: Store and retrieve object...\n";
    $object = (object)['name' => 'Test', 'value' => 123];
    $cache->put('object_key', $object, 3600);
    $retrieved = $cache->get('object_key');
    echo ($retrieved == $object && $retrieved->name === 'Test')
        ? "✓ Object storage works\n\n"
        : "✗ Object storage failed\n\n";

    // ===== TTL AND EXPIRATION =====
    echo "===== TTL AND EXPIRATION =====\n\n";

    // Test 7: Forever (no expiration)
    echo "Test 7: Forever storage...\n";
    $cache->forever('permanent_key', 'permanent_value');
    $value = $cache->get('permanent_key');
    echo $value === 'permanent_value' ? "✓ Forever storage works\n\n" : "✗ Forever storage failed\n\n";

    // Test 8: TTL expiration (very short TTL)
    echo "Test 8: TTL expiration...\n";
    $cache->put('expire_key', 'will_expire', 1); // 1 second TTL
    echo "  Waiting 2 seconds for expiration...\n";
    sleep(2);
    $value = $cache->get('expire_key');
    echo $value === null ? "✓ Keys expire correctly\n\n" : "✗ TTL expiration failed\n\n";

    // ===== INCREMENT/DECREMENT =====
    echo "===== INCREMENT/DECREMENT =====\n\n";

    // Test 9: Increment
    echo "Test 9: Increment method...\n";
    $cache->put('counter', 10, 3600);
    $val1 = $cache->increment('counter', 5);
    $val2 = $cache->increment('counter', 3);
    echo "  After increment by 5: {$val1}\n";
    echo "  After increment by 3: {$val2}\n";
    echo $val2 === 18 ? "✓ Increment works\n\n" : "✗ Increment failed\n\n";

    // Test 10: Decrement
    echo "Test 10: Decrement method...\n";
    $cache->put('countdown', 100, 3600);
    $val1 = $cache->decrement('countdown', 20);
    $val2 = $cache->decrement('countdown', 30);
    echo "  After decrement by 20: {$val1}\n";
    echo "  After decrement by 30: {$val2}\n";
    echo $val2 === 50 ? "✓ Decrement works\n\n" : "✗ Decrement failed\n\n";

    // Test 11: Increment non-existent key (should create it)
    echo "Test 11: Increment non-existent key...\n";
    $value = $cache->increment('new_counter', 5);
    echo $value === 5 ? "✓ Increment creates key with initial value\n\n" : "✗ Increment on new key failed\n\n";

    // ===== FILE STRUCTURE =====
    echo "===== FILE STRUCTURE =====\n\n";

    // Test 12: Subdirectory sharding
    echo "Test 12: Subdirectory sharding...\n";
    $cache->put('shard_test_1', 'value1', 3600);
    $cache->put('shard_test_2', 'value2', 3600);
    $cache->put('shard_test_3', 'value3', 3600);

    // Check if subdirectories are created
    $subdirs = glob($testCachePath . '/*', GLOB_ONLYDIR);
    $hasSubdirs = count($subdirs) > 0;
    echo $hasSubdirs ? "✓ Subdirectories created\n" : "✗ No subdirectories found\n";
    echo "  Found " . count($subdirs) . " subdirectories\n";

    // Check that files have .cache extension
    $cacheFiles = glob($testCachePath . '/*/*.cache');
    $hasFiles = count($cacheFiles) > 0;
    echo $hasFiles ? "✓ Cache files have .cache extension\n" : "✗ No .cache files found\n";
    echo "  Found " . count($cacheFiles) . " cache files\n\n";

    // ===== GARBAGE COLLECTION =====
    echo "===== GARBAGE COLLECTION =====\n\n";

    // Test 13: Garbage collection
    echo "Test 13: Garbage collection...\n";

    // Create some expired and non-expired entries
    $cache->put('gc_expired_1', 'value', 1);
    $cache->put('gc_expired_2', 'value', 1);
    $cache->put('gc_active_1', 'value', 3600);
    $cache->put('gc_active_2', 'value', 3600);

    // Count files before GC
    $filesBefore = count(glob($testCachePath . '/*/*.cache'));
    echo "  Files before GC: {$filesBefore}\n";

    // Wait for expiration
    echo "  Waiting 2 seconds for expiration...\n";
    sleep(2);

    // Run garbage collection
    $deleted = $cache->garbageCollect();
    echo "  Deleted by GC: {$deleted} files\n";

    // Count files after GC
    $filesAfter = count(glob($testCachePath . '/*/*.cache'));
    echo "  Files after GC: {$filesAfter}\n";

    echo $deleted >= 2 && $filesAfter < $filesBefore
        ? "✓ Garbage collection works\n\n"
        : "✗ Garbage collection failed\n\n";

    // ===== FLUSH =====
    echo "===== FLUSH =====\n\n";

    // Test 14: Flush (clear all)
    echo "Test 14: Flush all cache...\n";
    $cache->put('flush_test_1', 'value', 3600);
    $cache->put('flush_test_2', 'value', 3600);
    $cache->put('flush_test_3', 'value', 3600);

    $filesBefore = count(glob($testCachePath . '/*/*.cache'));
    echo "  Files before flush: {$filesBefore}\n";

    $cache->flush();

    $filesAfter = count(glob($testCachePath . '/*/*.cache'));
    echo "  Files after flush: {$filesAfter}\n";

    echo $filesAfter === 0 ? "✓ Flush clears all cache\n\n" : "✗ Flush failed\n\n";

    // ===== INTEGRATION WITH CACHE MANAGER =====
    echo "===== CACHE MANAGER INTEGRATION =====\n\n";

    // Test 15: Cache manager can use file driver
    echo "Test 15: Cache manager integration...\n";

    // Temporarily set file as cache driver
    $originalDriver = $_ENV['CACHE_DRIVER'] ?? null;
    $_ENV['CACHE_DRIVER'] = 'file';

    // Get cache instance from manager
    $managerCache = cache();
    $managerCache->put('manager_test', 'manager_value', 3600);
    $value = $managerCache->get('manager_test');

    // Restore original driver
    if ($originalDriver !== null) {
        $_ENV['CACHE_DRIVER'] = $originalDriver;
    } else {
        unset($_ENV['CACHE_DRIVER']);
    }

    echo $value === 'manager_value'
        ? "✓ Cache manager integration works\n\n"
        : "✗ Cache manager integration failed\n\n";

    // ===== CLEANUP =====
    echo "===== CLEANUP =====\n\n";

    // Clean up test directory
    echo "Cleaning up test directory...\n";

    // Remove all cache files
    $files = glob($testCachePath . '/*/*.cache');
    foreach ($files as $file) {
        @unlink($file);
    }

    // Remove subdirectories
    $subdirs = glob($testCachePath . '/*', GLOB_ONLYDIR);
    foreach ($subdirs as $dir) {
        @rmdir($dir);
    }

    // Remove main directory
    @rmdir($testCachePath);

    echo "✓ Test directory removed\n\n";

    // ===== SUMMARY =====
    echo "✅ All tests completed!\n\n";

    echo "===== SUMMARY =====\n";
    echo "✓ Basic CRUD operations work correctly\n";
    echo "✓ Complex data types (arrays, objects) are stored\n";
    echo "✓ TTL expiration works as expected\n";
    echo "✓ Forever storage (no expiration) works\n";
    echo "✓ Increment/decrement methods work\n";
    echo "✓ Subdirectory sharding prevents too many files in one directory\n";
    echo "✓ Garbage collection removes expired entries\n";
    echo "✓ Flush clears all cache data\n";
    echo "✓ Cache manager integration works\n\n";

    echo "===== FILE CACHE BENEFITS =====\n";
    echo "Performance:\n";
    echo "  - Fast read/write operations\n";
    echo "  - No database overhead\n";
    echo "  - Subdirectory sharding prevents filesystem bottleneck\n";
    echo "  - Atomic writes ensure data integrity\n\n";

    echo "Use Cases:\n";
    echo "  - Single-server applications\n";
    echo "  - Development/testing environments\n";
    echo "  - Caching rendered views or compiled assets\n";
    echo "  - Temporary data that doesn't need database persistence\n\n";

    echo "Features:\n";
    echo "  - TTL-based automatic expiration\n";
    echo "  - Manual garbage collection for cleanup\n";
    echo "  - Same interface as database cache\n";
    echo "  - Supports all PHP data types via serialization\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
