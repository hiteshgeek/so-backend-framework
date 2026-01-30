<?php
/**
 * Cache System Documentation Page
 *
 * High-performance caching with multiple drivers and cache locks.
 */

$pageTitle = 'Cache System';
$pageIcon = 'cached';
$toc = [
    ['id' => 'introduction', 'title' => 'Introduction', 'level' => 2],
    ['id' => 'quick-start', 'title' => 'Quick Start', 'level' => 2],
    ['id' => 'basic-operations', 'title' => 'Basic Operations', 'level' => 2],
    ['id' => 'cache-locks', 'title' => 'Cache Locks', 'level' => 2],
    ['id' => 'configuration', 'title' => 'Configuration', 'level' => 2],
    ['id' => 'erp-use-cases', 'title' => 'ERP Use Cases', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
];
$prevPage = ['url' => '/docs/session-system', 'title' => 'Session System'];
$nextPage = ['url' => '/docs/queue-system', 'title' => 'Queue System'];
$breadcrumbs = [['label' => 'Cache System']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="cache-system" class="heading heading-1">
    <span class="mdi mdi-cached heading-icon"></span>
    <span class="heading-text">Cache System</span>
</h1>

<p class="text-lead">
    High-performance caching to reduce database load by 60-80% and dramatically improve response times.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-stable">Production Ready</span>
    <span class="badge badge-success">Database & Array Drivers</span>
</div>

<!-- Introduction -->
<h2 id="introduction" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Introduction</span>
</h2>

<h4 class="heading heading-4">What Gets Cached?</h4>

<?= featureGrid([
    ['icon' => 'database', 'title' => 'Database Queries', 'description' => 'Cache query results instead of querying every time'],
    ['icon' => 'api', 'title' => 'API Responses', 'description' => 'Cache external API data'],
    ['icon' => 'calculator', 'title' => 'Computed Values', 'description' => 'Cache expensive calculations'],
    ['icon' => 'file-document', 'title' => 'Templates', 'description' => 'Cache rendered views/reports'],
], 4) ?>

<h4 class="heading heading-4 mt-4">Performance Impact</h4>

<?= dataTable(
    ['Metric', 'Improvement'],
    [
        ['Database Load', '<span class="text-success">60-80% reduction</span>'],
        ['Response Time', '<span class="text-success">10x faster</span> for cached data'],
        ['Server Resources', '<span class="text-success">Reduced</span> consumption'],
        ['Scalability', '<span class="text-success">Better</span> scalability'],
    ]
) ?>

<!-- Quick Start -->
<h2 id="quick-start" class="heading heading-2">
    <span class="mdi mdi-rocket-launch heading-icon"></span>
    <span class="heading-text">Quick Start</span>
</h2>

<?= codeTabs([
    ['label' => 'Basic', 'lang' => 'php', 'code' => '// Store value for 1 hour (3600 seconds)
cache()->put(\'products.featured\', $products, 3600);

// Retrieve value
$products = cache()->get(\'products.featured\');

// Check if exists
if (cache()->has(\'products.featured\')) {
    $products = cache()->get(\'products.featured\');
} else {
    $products = Product::where(\'featured\', true)->get();
    cache()->put(\'products.featured\', $products, 3600);
}'],
    ['label' => 'Remember Pattern', 'lang' => 'php', 'code' => '// Compute once, cache result - RECOMMENDED
$users = cache()->remember(\'users.active\', 3600, function() {
    return User::where(\'status\', \'active\')->get();
});

// First call: Executes query and caches result
// Subsequent calls: Returns cached value (no query)'],
    ['label' => 'Clear Cache', 'lang' => 'php', 'code' => '// Remove specific item
cache()->forget(\'products.featured\');

// Clear all cache
cache()->flush();

// CLI command
php sixorbit cache:clear'],
]) ?>

<!-- Basic Operations -->
<h2 id="basic-operations" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Basic Operations</span>
</h2>

<?= dataTable(
    ['Method', 'Description', 'Example'],
    [
        ['<code class="code-inline">put()</code>', 'Store for duration', '<code class="code-inline">cache()->put(\'key\', \'value\', 3600)</code>'],
        ['<code class="code-inline">forever()</code>', 'Store permanently', '<code class="code-inline">cache()->forever(\'settings\', $data)</code>'],
        ['<code class="code-inline">get()</code>', 'Retrieve value', '<code class="code-inline">cache()->get(\'key\', \'default\')</code>'],
        ['<code class="code-inline">has()</code>', 'Check existence', '<code class="code-inline">cache()->has(\'key\')</code>'],
        ['<code class="code-inline">forget()</code>', 'Remove item', '<code class="code-inline">cache()->forget(\'key\')</code>'],
        ['<code class="code-inline">flush()</code>', 'Clear all', '<code class="code-inline">cache()->flush()</code>'],
        ['<code class="code-inline">remember()</code>', 'Get or compute', '<code class="code-inline">cache()->remember(\'key\', 3600, fn)</code>'],
        ['<code class="code-inline">increment()</code>', 'Atomic counter', '<code class="code-inline">cache()->increment(\'views\')</code>'],
        ['<code class="code-inline">decrement()</code>', 'Atomic counter', '<code class="code-inline">cache()->decrement(\'stock\')</code>'],
    ]
) ?>

<?= codeBlock('php', '// Store complex data (auto-serialized)
cache()->put(\'user:1:data\', [
    \'name\' => \'John\',
    \'email\' => \'john@example.com\',
    \'permissions\' => [\'read\', \'write\']
], 3600);

// Atomic counters
cache()->put(\'page.views\', 0, 3600);
$views = cache()->increment(\'page.views\');     // +1
$views = cache()->increment(\'page.views\', 5);  // +5') ?>

<!-- Cache Locks -->
<h2 id="cache-locks" class="heading heading-2">
    <span class="mdi mdi-lock heading-icon"></span>
    <span class="heading-text">Cache Locks</span>
</h2>

<p>Prevent multiple processes from doing the same expensive work:</p>

<?= callout('danger', '<strong>Without Lock:</strong> 10 requests hit at same time → All 10 generate the report (wasteful)', null, 'close-circle') ?>

<?= callout('success', '<strong>With Lock:</strong> Only 1 generates, others wait → Efficient resource usage', null, 'check-circle') ?>

<?= codeBlock('php', '$lock = cache()->lock(\'expensive-operation\', 60); // 60 second timeout

if ($lock->acquire()) {
    try {
        // Do expensive work
        $result = performExpensiveOperation();

        // Cache result
        cache()->put(\'result\', $result, 3600);
    } finally {
        // Always release
        $lock->release();
    }
} else {
    // Another process is working, wait for cache
    sleep(1);
    $result = cache()->get(\'result\');
}') ?>

<!-- Configuration -->
<h2 id="configuration" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Configuration</span>
</h2>

<?= codeTabs([
    ['label' => '.env', 'lang' => 'ini', 'code' => 'CACHE_DRIVER=database
CACHE_PREFIX=so_cache'],
    ['label' => 'config/cache.php', 'lang' => 'php', 'code' => '<?php

return [
    // Default cache store
    \'default\' => env(\'CACHE_DRIVER\', \'database\'),

    // Available stores
    \'stores\' => [
        \'database\' => [
            \'driver\' => \'database\',
            \'table\' => \'cache\',
        ],

        \'array\' => [
            \'driver\' => \'array\',
        ],
    ],

    // Cache key prefix
    \'prefix\' => env(\'CACHE_PREFIX\', \'so_cache\'),
];'],
]) ?>

<h4 class="heading heading-4 mt-4">Database Schema</h4>

<?= codeBlock('sql', 'CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT UNSIGNED NOT NULL,
    INDEX idx_expiration (expiration)
);

CREATE TABLE cache_locks (
    `key` VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT UNSIGNED,
    INDEX idx_expiration (expiration)
);') ?>

<!-- ERP Use Cases -->
<h2 id="erp-use-cases" class="heading heading-2">
    <span class="mdi mdi-office-building heading-icon"></span>
    <span class="heading-text">ERP Use Cases</span>
</h2>

<div class="space-y-4">
    <div>
        <h4 class="heading heading-4">Product Catalog</h4>
        <p class="text-muted">Problem: 50,000 products queried on every page load</p>
        <?= codeBlock('php', '$products = cache()->remember(\'products.catalog\', 3600, function() {
    return Product::with(\'category\', \'images\')
        ->where(\'status\', \'active\')
        ->get();
});

// Invalidate on product update
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $product->update($request->all());
    cache()->forget(\'products.catalog\');
}') ?>
    </div>

    <div>
        <h4 class="heading heading-4">User Permissions</h4>
        <p class="text-muted">Problem: Permission check on every request queries database</p>
        <?= codeBlock('php', 'function userHasPermission($userId, $permission) {
    $permissions = cache()->remember("permissions:{$userId}", 3600, function() use ($userId) {
        return DB::table(\'user_permissions\')
            ->where(\'user_id\', $userId)
            ->pluck(\'permission\')
            ->toArray();
    });

    return in_array($permission, $permissions);
}') ?>
    </div>

    <div>
        <h4 class="heading heading-4">Expensive Reports</h4>
        <p class="text-muted">Problem: Complex report takes 5 minutes to generate</p>
        <?= codeBlock('php', '$lock = cache()->lock(\'monthly-report\', 600);

if ($lock->acquire()) {
    try {
        $report = cache()->remember(\'report:sales:2026-01\', 3600, function() {
            return generateSalesReport(\'2026-01\');
        });
        $lock->release();
    } catch (\Exception $e) {
        $lock->release();
        throw $e;
    }
}') ?>
    </div>
</div>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<h4 class="heading heading-4">Cache Key Naming</h4>

<?= codeTabs([
    ['label' => 'Good', 'lang' => 'php', 'code' => '// Clear, hierarchical
\'products:123\'
\'user:456:profile\'
\'report:sales:2026-01\'
\'permissions:user:789\''],
    ['label' => 'Bad', 'lang' => 'php', 'code' => '// Unclear, flat
\'p123\'
\'data\'
\'result\''],
]) ?>

<h4 class="heading heading-4 mt-4">TTL Selection</h4>

<?= dataTable(
    ['Data Type', 'TTL', 'Example'],
    [
        ['Very stable (settings)', '1 day (86400)', '<code class="code-inline">cache()->put(\'settings\', $data, 86400)</code>'],
        ['Moderately stable (catalog)', '1 hour (3600)', '<code class="code-inline">cache()->put(\'products\', $data, 3600)</code>'],
        ['Frequently changing (stock)', '5 min (300)', '<code class="code-inline">cache()->put(\'stock\', $data, 300)</code>'],
        ['Request-level', 'Array driver', '<code class="code-inline">cache()->store(\'array\')</code>'],
    ]
) ?>

<div class="space-y-3 mt-4">
    <?= callout('success', '<strong>Use Remember Pattern</strong><br>Clean, safe, automatic caching') ?>
    <?= callout('success', '<strong>Regular Garbage Collection</strong><br>Cron: <code class="code-inline">0 * * * * php sixorbit cache:gc</code>') ?>
    <?= callout('success', '<strong>Use Locks for Expensive Operations</strong><br>Prevents cache stampede') ?>
    <?= callout('warning', '<strong>Invalidate After Updates</strong><br>Always <code class="code-inline">cache()->forget()</code> after data changes') ?>
</div>

<?php include __DIR__ . '/../_layout-end.php'; ?>
