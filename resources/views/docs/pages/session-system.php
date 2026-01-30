<?php
/**
 * Session System Documentation Page
 *
 * Database-backed sessions for horizontal scaling.
 */

$pageTitle = 'Session System';
$pageIcon = 'account-box';
$toc = [
    ['id' => 'introduction', 'title' => 'Introduction', 'level' => 2],
    ['id' => 'quick-start', 'title' => 'Quick Start', 'level' => 2],
    ['id' => 'operations', 'title' => 'Session Operations', 'level' => 2],
    ['id' => 'security', 'title' => 'Session Security', 'level' => 2],
    ['id' => 'configuration', 'title' => 'Configuration', 'level' => 2],
    ['id' => 'erp-use-cases', 'title' => 'ERP Use Cases', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
];
$breadcrumbs = [['label' => 'Session System']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="session-system" class="heading heading-1">
    <span class="mdi mdi-account-box heading-icon"></span>
    <span class="heading-text">Session System</span>
</h1>

<p class="text-lead">
    Database-backed session storage for horizontal scaling across multiple servers with load balancers.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-stable">Production Ready</span>
    <span class="badge badge-info">Database Sessions</span>
</div>

<!-- Introduction -->
<h2 id="introduction" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Introduction</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Why Database Sessions?</span>
</h3>

<?= dataTable(
    ['Approach', 'Scaling', 'Use Case'],
    [
        ['<span class="badge badge-danger">File Sessions</span>', 'Tied to single server (session affinity required)', 'Single server only'],
        ['<span class="badge badge-success">Database Sessions</span>', 'Shared across all servers (no affinity needed)', 'Multi-server, load balanced'],
    ]
) ?>

<?= featureGrid([
    ['icon' => 'server-network', 'title' => 'Shared Storage', 'description' => 'All servers access the same session database'],
    ['icon' => 'shuffle-variant', 'title' => 'No Session Affinity', 'description' => 'Users can hit any server'],
    ['icon' => 'eye', 'title' => 'Tracking', 'description' => 'Monitor active users, IPs, devices'],
    ['icon' => 'logout-variant', 'title' => 'Force Logout', 'description' => 'Invalidate sessions from database'],
], 4) ?>

<!-- Quick Start -->
<h2 id="quick-start" class="heading heading-2">
    <span class="mdi mdi-rocket-launch heading-icon"></span>
    <span class="heading-text">Quick Start</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Step 1: Enable Database Sessions</span>
</h3>

<?= codeBlock('env', 'SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_COOKIE=so_session', '.env') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Step 2: Use Sessions (Same API)</span>
</h3>

<?= codeBlock('php', '// Store data
session()->put(\'user_id\', 42);
session()->put(\'cart\', [\'item1\', \'item2\']);

// Retrieve data
$userId = session()->get(\'user_id\');
$cart = session()->get(\'cart\', []);

// Check existence
if (session()->has(\'user_id\')) {
    // User is logged in
}

// Remove data
session()->forget(\'temp_data\');

// Clear all
session()->flush();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Step 3: Monitor Active Sessions</span>
</h3>

<?= codeBlock('sql', '-- View active sessions
SELECT id, user_id, ip_address, user_agent, last_activity
FROM sessions
WHERE last_activity > UNIX_TIMESTAMP() - 7200
ORDER BY last_activity DESC;') ?>

<!-- Session Operations -->
<h2 id="operations" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Session Operations</span>
</h2>

<?= codeTabs([
    ['label' => 'Store', 'lang' => 'php', 'code' => '// Single value
session()->put(\'username\', \'john_doe\');

// Array
session()->put(\'preferences\', [
    \'theme\' => \'dark\',
    \'language\' => \'en\'
]);

// Nested
session()->put(\'cart.items\', [\'product1\', \'product2\']);
session()->put(\'cart.total\', 150.00);'],
    ['label' => 'Retrieve', 'lang' => 'php', 'code' => '// Get value
$username = session()->get(\'username\');

// Get with default
$theme = session()->get(\'preferences.theme\', \'light\');

// Get all
$all = session()->all();'],
    ['label' => 'Flash Data', 'lang' => 'php', 'code' => '// Store flash data (next request only)
session()->flash(\'message\', \'Profile updated!\');

// Redirect
return Response::redirect(\'/profile\');

// Next page
$message = session()->get(\'message\'); // "Profile updated!"
// Third page
$message = session()->get(\'message\'); // null (expired)'],
    ['label' => 'Remove', 'lang' => 'php', 'code' => '// Remove single item
session()->forget(\'temp_data\');

// Remove multiple
session()->forget([\'key1\', \'key2\']);

// Clear all (keep session ID)
session()->flush();'],
]) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Regenerate Session ID</span>
</h3>

<?= callout('warning', 'Always regenerate the session ID after login to prevent session fixation attacks.') ?>

<?= codeBlock('php', 'public function login(Request $request)
{
    $user = authenticate($request);

    // Regenerate session ID (security)
    session()->regenerate();

    // Store user info
    session()->put(\'user_id\', $user->id);
    session()->put(\'user_name\', $user->name);

    return Response::redirect(\'/dashboard\');
}') ?>

<!-- Session Security -->
<h2 id="security" class="heading heading-2">
    <span class="mdi mdi-shield-lock heading-icon"></span>
    <span class="heading-text">Session Security</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Secure Cookie Parameters</span>
</h3>

<?= codeBlockWithFile('php', '<?php

return [
    // HTTPS only (production)
    \'secure\' => env(\'SESSION_SECURE_COOKIE\', false),

    // JavaScript cannot access (XSS protection)
    \'http_only\' => true,

    // CSRF protection
    \'same_site\' => \'lax\',  // or \'strict\'

    // Cookie name
    \'cookie\' => env(\'SESSION_COOKIE\', \'so_session\'),

    // Session lifetime (minutes)
    \'lifetime\' => env(\'SESSION_LIFETIME\', 120),
];', 'config/session.php') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Force Logout from All Devices</span>
</h3>

<?= codeBlock('php', '// Security breach or password change
public function forceLogoutAllDevices($userId)
{
    // Delete all sessions for user
    DB::table(\'sessions\')->where(\'user_id\', $userId)->delete();

    // User must login again on all devices
}') ?>

<!-- Configuration -->
<h2 id="configuration" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Configuration</span>
</h2>

<?= dataTable(
    ['Variable', 'Default', 'Description'],
    [
        ['<code class="code-inline">SESSION_DRIVER</code>', 'database', 'Session storage driver'],
        ['<code class="code-inline">SESSION_LIFETIME</code>', '120', 'Session lifetime (minutes)'],
        ['<code class="code-inline">SESSION_COOKIE</code>', 'so_session', 'Cookie name'],
        ['<code class="code-inline">SESSION_SECURE_COOKIE</code>', 'false', 'HTTPS only'],
    ]
) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Database Schema</span>
</h3>

<?= codeBlock('sql', 'CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload LONGTEXT NOT NULL,
    last_activity INT UNSIGNED NOT NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
);') ?>

<!-- ERP Use Cases -->
<h2 id="erp-use-cases" class="heading heading-2">
    <span class="mdi mdi-office-building heading-icon"></span>
    <span class="heading-text">ERP Use Cases</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Multi-Server Deployment</span>
</h3>

<?= codeBlock('text', '+-------------+
| Load        |
| Balancer    |
+------+------+
       |
       +-------------+-------------+
       |             |             |
 +-----v----+  +-----v----+  +-----v----+
 | Server 1 |  | Server 2 |  | Server 3 |
 +-----+----+  +-----+----+  +-----+----+
       |             |             |
       +-------------+-------------+
                     |
              +------v------+
              |   Database  |
              |  (Sessions) |
              +-------------+') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Active User Monitoring</span>
</h3>

<?= codeBlock('php', 'function getActiveUsers($minutes = 15)
{
    $cutoff = time() - ($minutes * 60);

    $sessions = DB::table(\'sessions\')
        ->where(\'last_activity\', \'>=\', $cutoff)
        ->whereNotNull(\'user_id\')
        ->get();

    $activeUsers = [];
    foreach ($sessions as $session) {
        $activeUsers[] = [
            \'user_id\' => $session[\'user_id\'],
            \'ip\' => $session[\'ip_address\'],
            \'last_seen\' => date(\'Y-m-d H:i:s\', $session[\'last_activity\'])
        ];
    }

    return $activeUsers;
}') ?>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<div class="space-y-3">
    <?= callout('success', '<strong>Set Appropriate Lifetime</strong><br>High security: 30 min | Standard: 2 hours | Convenience: 8 hours') ?>
    <?= callout('success', '<strong>Regular Cleanup</strong><br>Cron job: <code class="code-inline">0 2 * * * php sixorbit session:cleanup</code>') ?>
    <?= callout('success', '<strong>Use HTTPS in Production</strong><br>Set <code class="code-inline">SESSION_SECURE_COOKIE=true</code>') ?>
    <?= callout('warning', '<strong>Limit Session Data</strong><br>Store IDs only, not large objects') ?>
    <?= callout('success', '<strong>Regenerate After Privilege Change</strong><br>Always call <code class="code-inline">session()->regenerate()</code> after login') ?>
</div>

<?php include __DIR__ . '/../_layout-end.php'; ?>
