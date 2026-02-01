# Application Profiler & Debugging - Developer Guide

**SO Framework** | **Performance Profiling** | **Version 1.0**

A comprehensive guide to using the built-in profiler for debugging, performance monitoring, and optimization.

---

## Table of Contents

1. [Overview](#overview)
2. [Quick Start](#quick-start)
3. [Database Query Profiling](#database-query-profiling)
4. [Execution Timeline](#execution-timeline)
5. [Custom Metrics](#custom-metrics)
6. [Profiler Toolbar](#profiler-toolbar)
7. [Performance Optimization](#performance-optimization)
8. [Configuration](#configuration)
9. [Best Practices](#best-practices)

---

## Overview

The Profiler is a powerful debugging tool that helps you understand application performance, identify bottlenecks, and optimize your code.

### Key Features

- [x] **Database Query Tracking** - See all queries, execution times, and bindings
- [x] **Execution Timeline** - Track when events occur during request processing
- [x] **Memory Monitoring** - Track memory usage and detect memory leaks
- [x] **Custom Timers** - Measure execution time of specific code sections
- [x] **Visual Toolbar** - On-screen display of performance metrics
- [x] **Auto-Enable in Debug Mode** - Automatically enabled when `APP_DEBUG=true`

### When to Use

- 🐛 **Debugging** - Identify slow queries and performance issues
- ⚡ **Optimization** - Find bottlenecks and improve response times
- 🔍 **N+1 Detection** - Spot excessive database queries
- 📊 **Monitoring** - Track memory usage and execution patterns
- 🎯 **Development** - Understand application behavior during development

---

## Quick Start

### Enable Profiling

The profiler is automatically enabled in debug mode:

**.env:**
```bash
APP_DEBUG=true  # Enables profiler
```

### Basic Usage

Access the profiler anywhere in your code:

```php
// Get profiler instance
$profiler = profiler();

// Check if profiling is enabled
if ($profiler->isEnabled()) {
    // Profiling is active
}

// Get execution summary
$summary = $profiler->getSummary();
// Returns: ['execution_time' => 42.5, 'memory_usage' => '2.5 MB', ...]
```

### Automatic Profiling

The framework automatically profiles:

- ✅ All database queries
- ✅ Request execution time
- ✅ Memory usage (current and peak)
- ✅ Framework boot events

**No configuration needed** - just enable debug mode and the profiler starts tracking!

---

## Database Query Profiling

The profiler automatically tracks every database query executed.

### View All Queries

```php
$profiler = profiler();

// Get all queries
$queries = $profiler->getQueries();

foreach ($queries as $query) {
    echo "SQL: " . $query['sql'] . "\n";
    echo "Time: " . ($query['time'] * 1000) . "ms\n";
    echo "Bindings: " . json_encode($query['bindings']) . "\n\n";
}

// Get query count
echo "Total Queries: " . $profiler->getQueryCount();

// Get total query time
echo "Total Time: " . ($profiler->getTotalQueryTime() * 1000) . "ms";
```

### Identify Slow Queries

```php
$profiler = profiler();
$slowQueries = [];

foreach ($profiler->getQueries() as $query) {
    // Flag queries slower than 100ms
    if ($query['time'] > 0.1) {
        $slowQueries[] = $query;
    }
}

if (!empty($slowQueries)) {
    logger()->warning('Slow queries detected', [
        'count' => count($slowQueries),
        'queries' => $slowQueries,
    ]);
}
```

### Detect N+1 Problems

```php
$profiler = profiler();

// If query count is excessive for a list view
if ($profiler->getQueryCount() > 20) {
    logger()->warning('Possible N+1 query problem', [
        'query_count' => $profiler->getQueryCount(),
        'route' => current_route(),
    ]);
}
```

**Example N+1 Problem:**

```php
// BAD - N+1 queries
$users = User::all(); // 1 query
foreach ($users as $user) {
    echo $user->profile()->name; // N queries (one per user)
}
// Result: 1 + 100 = 101 queries for 100 users

// GOOD - Eager loading
$users = User::with('profile')->all(); // 2 queries total
foreach ($users as $user) {
    echo $user->profile->name; // No additional queries
}
// Result: 2 queries for 100 users
```

---

## Execution Timeline

Track when events occur during request processing.

### Add Timeline Events

```php
profiler()->addEvent('User authentication started', 'auth');
// ... authentication logic ...
profiler()->addEvent('User authentication completed', 'auth');

profiler()->addEvent('Database migration check', 'database');
profiler()->addEvent('Cache warming started', 'cache');
```

### View Timeline

```php
$timeline = profiler()->getTimeline();

foreach ($timeline as $event) {
    $elapsed = ($event['time'] - profiler()->startTime) * 1000;
    echo "[{$elapsed}ms] {$event['category']}: {$event['name']}\n";
    echo "Memory: " . profiler()->formatBytes($event['memory']) . "\n\n";
}
```

**Output:**
```
[0ms] bootstrap: Application boot started
[5.2ms] routing: Route matched
[12.8ms] auth: User authentication started
[45.3ms] auth: User authentication completed
[50.1ms] database: Query executed
[102.5ms] view: Template rendered
```

### Common Event Categories

| Category | Use Case |
|----------|----------|
| `bootstrap` | Application initialization |
| `routing` | Route matching and dispatching |
| `auth` | Authentication and authorization |
| `database` | Database operations |
| `cache` | Cache hits/misses |
| `api` | External API calls |
| `email` | Email sending |
| `queue` | Queue job processing |
| `view` | Template rendering |

---

## Custom Metrics

Track custom performance metrics for specific operations.

### Timers

Measure execution time of code blocks:

```php
// Start a timer
profiler()->startTimer('image_processing');

// ... image processing code ...
processImage($file);

// Stop the timer
$duration = profiler()->stopTimer('image_processing');

echo "Image processing took {$duration}s";

// Get timer value later
$time = profiler()->getTimer('image_processing');
```

### Custom Metrics

Store arbitrary metrics:

```php
// Add custom metrics
profiler()->addMetric('users_processed', 150);
profiler()->addMetric('cache_hit_rate', 0.85);
profiler()->addMetric('api_calls', 12);

// Retrieve metrics
$metrics = profiler()->getMetrics();
echo "Cache Hit Rate: " . ($metrics['cache_hit_rate'] * 100) . "%";
```

### Controller Example

```php
class OrderController
{
    public function index()
    {
        profiler()->startTimer('fetch_orders');

        $orders = Order::with('user', 'items')
            ->where('status', 'active')
            ->limit(50)
            ->get();

        $fetchTime = profiler()->stopTimer('fetch_orders');

        profiler()->addMetric('orders_fetched', count($orders));
        profiler()->addMetric('fetch_time_ms', $fetchTime * 1000);

        return view('orders/index', ['orders' => $orders]);
    }
}
```

---

## Profiler Toolbar

The profiler toolbar displays real-time performance metrics at the bottom of your pages.

### Visual Toolbar

When enabled, you'll see a toolbar showing:

```
Time: 42.5ms | Memory: 2.5MB / 3.2MB | Queries: 8 (12.3ms) | Events: 15 [Toggle Details]
```

**Color Coding:**
- 🟢 **Green** - Normal performance
- 🟠 **Orange** - Warning (slow queries, high memory)
- 🔴 **Red** - Critical (very slow, memory issues)

### Toolbar Features

- **Execution Time** - Total request processing time
- **Memory Usage** - Current / Peak memory usage
- **Query Count** - Number of database queries (with total time)
- **Events** - Timeline event count
- **Toggle Details** - Expand to see all queries and timeline

### Enable/Disable Toolbar

**config/profiler.php:**
```php
'show_toolbar' => env('PROFILER_TOOLBAR', true),
```

**.env:**
```bash
PROFILER_TOOLBAR=true   # Show toolbar
PROFILER_TOOLBAR=false  # Hide toolbar (but still collect data)
```

### Rendering the Toolbar

In your layout template:

```php
<!-- resources/views/layouts/app.php -->
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'My App' ?></title>
</head>
<body>
    <?= $content ?>

    <!-- Render profiler toolbar (only shows in debug mode) -->
    <?php if (config('app.debug')): ?>
        <?= profiler()->render() ?>
    <?php endif; ?>
</body>
</html>
```

---

## Performance Optimization

Use the profiler to identify and fix performance issues.

### 1. Identify Slow Queries

```php
// Profile slow endpoints
$profiler = profiler();

// After request completes
$slowQueries = array_filter($profiler->getQueries(), function($q) {
    return $q['time'] > 0.1; // Slower than 100ms
});

if (!empty($slowQueries)) {
    // Log for review
    logger()->warning('Slow queries detected', [
        'url' => $_SERVER['REQUEST_URI'],
        'queries' => $slowQueries,
    ]);
}
```

### 2. Optimize Query Count

```php
// Before optimization
$users = User::all(); // 1 query
foreach ($users as $user) {
    $orders = $user->orders()->get(); // 100 queries
}
// Total: 101 queries

// After optimization
$users = User::with('orders')->all(); // 2 queries
foreach ($users as $user) {
    $orders = $user->orders; // No additional queries
}
// Total: 2 queries (50x faster!)
```

### 3. Monitor Memory Usage

```php
profiler()->addEvent('Before data processing');

$data = fetchLargeDataset(); // Process large dataset

profiler()->addEvent('After data processing');

// Check memory impact
$memoryUsed = profiler()->getMemoryUsage();
if ($memoryUsed > 50 * 1024 * 1024) { // 50MB
    logger()->warning('High memory usage', [
        'memory' => profiler()->formatBytes($memoryUsed),
        'operation' => 'data_processing',
    ]);
}
```

### 4. Benchmark Code Improvements

```php
// Test different implementations
profiler()->startTimer('implementation_v1');
$result1 = processDataV1($data);
$time1 = profiler()->stopTimer('implementation_v1');

profiler()->startTimer('implementation_v2');
$result2 = processDataV2($data);
$time2 = profiler()->stopTimer('implementation_v2');

echo "V1: {$time1}s, V2: {$time2}s\n";
echo "Improvement: " . (($time1 - $time2) / $time1 * 100) . "%\n";
```

### Performance Targets

| Metric | Target | Warning | Critical |
|--------|--------|---------|----------|
| Response Time | < 200ms | > 500ms | > 1000ms |
| Query Count | < 10 | > 20 | > 50 |
| Query Time | < 50ms | > 100ms | > 500ms |
| Memory Usage | < 16MB | > 32MB | > 64MB |

---

## Configuration

Customize profiler behavior in `config/profiler.php`.

### Configuration Options

```php
return [
    // Enable profiler (auto-enabled with APP_DEBUG=true)
    'enabled' => env('APP_DEBUG', false),

    // Show visual toolbar
    'show_toolbar' => env('PROFILER_TOOLBAR', true),

    // Highlight queries slower than this (ms)
    'slow_query_threshold' => env('PROFILER_SLOW_QUERY', 100),

    // Warn if query count exceeds this
    'query_count_warning' => env('PROFILER_QUERY_WARNING', 20),

    // Warn if memory usage exceeds this % of limit
    'memory_warning_percent' => env('PROFILER_MEMORY_WARNING', 80),

    // Paths to exclude from profiling
    'exclude_paths' => [
        '/profiler',
        '/debug',
        '/_healthcheck',
    ],

    // Track framework events automatically
    'track_events' => true,

    // What data to collect
    'collect' => [
        'queries' => true,
        'timeline' => true,
        'memory' => true,
        'route' => true,
        'session' => true,
        'request' => true,
    ],
];
```

### Environment Variables

**.env:**
```bash
# Enable profiling
APP_DEBUG=true

# Profiler settings
PROFILER_TOOLBAR=true
PROFILER_SLOW_QUERY=100
PROFILER_QUERY_WARNING=20
PROFILER_MEMORY_WARNING=80
```

---

## Best Practices

### 1. Only Enable in Development

```php
// Production .env
APP_DEBUG=false
PROFILER_TOOLBAR=false

// Development .env
APP_DEBUG=true
PROFILER_TOOLBAR=true
```

### 2. Profile Specific Sections

```php
// Profile a specific operation
profiler()->startTimer('complex_operation');

// ... complex code ...

$duration = profiler()->stopTimer('complex_operation');

if ($duration > 1.0) {
    logger()->warning('Complex operation is slow', [
        'duration' => $duration,
    ]);
}
```

### 3. Use Events for Key Milestones

```php
profiler()->addEvent('Request received', 'http');
profiler()->addEvent('Authentication completed', 'auth');
profiler()->addEvent('Data fetched', 'database');
profiler()->addEvent('Template rendered', 'view');
profiler()->addEvent('Response sent', 'http');
```

### 4. Log Performance Data

```php
// At end of request
if (profiler()->isEnabled()) {
    logger()->debug('Request profiling', profiler()->getSummary());
}
```

### 5. Monitor Production with Sampling

```php
// In production, randomly profile 1% of requests
if (!config('app.debug') && rand(1, 100) === 1) {
    profiler()->enable();
}

// At end of request
if (profiler()->isEnabled()) {
    logger()->info('Production profiling sample', profiler()->getReport());
}
```

### 6. Set Performance Budgets

```php
// Define performance budget
$budget = [
    'max_queries' => 10,
    'max_time_ms' => 200,
    'max_memory_mb' => 16,
];

// Check budget
$summary = profiler()->getSummary();

if ($summary['query_count'] > $budget['max_queries']) {
    logger()->warning('Query budget exceeded', $summary);
}

if ($summary['execution_time'] > $budget['max_time_ms']) {
    logger()->warning('Time budget exceeded', $summary);
}
```

### 7. Clean Up After Use

```php
// Disable profiling for specific sections
profiler()->disable();

// ... code you don't want to profile ...

profiler()->enable();
```

---

## Common Use Cases

### 1. Debugging Slow Endpoints

```php
public function slowEndpoint()
{
    profiler()->addEvent('Endpoint started');

    // Operation 1
    profiler()->startTimer('operation_1');
    $data1 = fetchData1();
    profiler()->stopTimer('operation_1');

    // Operation 2
    profiler()->startTimer('operation_2');
    $data2 = processData($data1);
    profiler()->stopTimer('operation_2');

    profiler()->addEvent('Endpoint completed');

    // Check what's slow
    $timers = profiler()->getMetrics();
    logger()->debug('Endpoint timers', $timers);

    return view('result', ['data' => $data2]);
}
```

### 2. API Performance Monitoring

```php
public function apiCall()
{
    profiler()->startTimer('api_request');

    $response = $this->httpClient->get('/external-api');

    $duration = profiler()->stopTimer('api_request');

    profiler()->addMetric('api_response_time_ms', $duration * 1000);
    profiler()->addMetric('api_response_size', strlen($response));

    return json(['data' => $response]);
}
```

### 3. Database Query Optimization

```php
// Before
profiler()->addEvent('Query optimization test START');
$users = User::all();
foreach ($users as $user) {
    echo $user->profile()->name;
}
profiler()->addEvent('Query optimization test END');
echo "Queries: " . profiler()->getQueryCount();

// After
profiler()->addEvent('Optimized query test START');
$users = User::with('profile')->all();
foreach ($users as $user) {
    echo $user->profile->name;
}
profiler()->addEvent('Optimized query test END');
echo "Queries: " . profiler()->getQueryCount();
```

---

## Troubleshooting

### Profiler Not Showing

```php
// Check if enabled
var_dump(profiler()->isEnabled()); // Should be true

// Check debug mode
var_dump(config('app.debug')); // Should be true

// Check .env
APP_DEBUG=true
```

### Toolbar Not Rendering

```php
// Make sure you're calling render()
<?php if (config('app.debug')): ?>
    <?= profiler()->render() ?>
<?php endif; ?>

// Check toolbar config
var_dump(config('profiler.show_toolbar')); // Should be true
```

### Memory Issues

```php
// Disable profiling if memory is critical
if (memory_get_usage() > 100 * 1024 * 1024) {
    profiler()->disable();
}
```

---

## See Also

- **[DEV-LOGGING.md](/docs/dev-logging)** - Application logging
- **[DEV-ERROR-HANDLING.md](/docs/dev-error-handling)** - Error handling
- **[DEV-TESTING.md](/docs/dev-testing)** - Testing guide
- **[DEV-CACHING.md](/docs/dev-caching)** - Performance optimization with caching

---

**Framework Version:** 2.0.0
**Last Updated:** 2026-02-01
**Status:** Production Ready
