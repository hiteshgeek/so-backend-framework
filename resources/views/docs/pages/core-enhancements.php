<?php
/**
 * Core Framework Enhancements Documentation
 *
 * Overview of all Phase 6 core system completions.
 */

$pageTitle = 'Core Framework Enhancements';
$pageIcon = 'rocket-launch-outline';
$toc = [
    ['id' => 'overview', 'title' => 'Overview', 'level' => 2],
    ['id' => 'helpers', 'title' => 'Helper Functions', 'level' => 2],
    ['id' => 'validation', 'title' => 'Validation System', 'level' => 2],
    ['id' => 'database', 'title' => 'Database & QueryBuilder', 'level' => 2],
    ['id' => 'orm', 'title' => 'ORM Enhancements', 'level' => 2],
    ['id' => 'container', 'title' => 'Container & DI', 'level' => 2],
    ['id' => 'middleware', 'title' => 'Middleware System', 'level' => 2],
    ['id' => 'session', 'title' => 'Session Security', 'level' => 2],
    ['id' => 'auth', 'title' => 'Authentication', 'level' => 2],
];
$breadcrumbs = [['label' => 'Core Enhancements']];
$lastUpdated = '2026-02-01';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="core-enhancements" class="heading heading-1">
    <span class="mdi mdi-rocket-launch-outline heading-icon"></span>
    <span class="heading-text">Core Framework Enhancements</span>
</h1>

<p class="text-lead">
    Complete overview of the Phase 6 core system enhancements that bring all major framework components to 100% completion.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-new">Phase 6</span>
    <span class="badge badge-stable">100% Complete</span>
    <span class="badge badge-stable">Version <?= htmlspecialchars(config('app.version')) ?></span>
</div>

<!-- Overview -->
<h2 id="overview" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Overview</span>
</h2>

<p>
    Phase 6 brings 8 core framework systems to 100% completion with enterprise-grade features including advanced validation, eager loading, contextual dependency injection, two-factor authentication, and session hijacking detection.
</p>

<?= featureGrid([
    ['icon' => 'text-box-search', 'title' => 'Str Class', 'description' => '40+ string manipulation methods'],
    ['icon' => 'code-array', 'title' => 'Array Helpers', 'description' => '18 array functions with dot notation'],
    ['icon' => 'check-decagram', 'title' => 'Validation', 'description' => '35+ new validation rules'],
    ['icon' => 'database-search', 'title' => 'Subqueries', 'description' => 'whereInSub, whereExists, unions'],
    ['icon' => 'relation-many-to-many', 'title' => 'Eager Loading', 'description' => 'Prevent N+1 queries with with()'],
    ['icon' => 'needle', 'title' => 'Contextual DI', 'description' => 'when()->needs()->give() bindings'],
    ['icon' => 'shield-lock', 'title' => '2FA TOTP', 'description' => 'Google Authenticator compatible'],
    ['icon' => 'shield-alert', 'title' => 'Session Security', 'description' => 'Hijacking detection'],
], 4) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Completion Summary</span>
</h3>

<?= dataTable(
    ['System', 'Before', 'After', 'Key Features'],
    [
        ['<strong>Helpers</strong>', '90%', '<span class="badge badge-stable">100%</span>', 'Str class, array helpers'],
        ['<strong>Validation</strong>', '95%', '<span class="badge badge-stable">100%</span>', 'File, regex, uuid, json, conditional rules'],
        ['<strong>QueryBuilder</strong>', '85%', '<span class="badge badge-stable">100%</span>', 'Subqueries, unions, chunk, cursor'],
        ['<strong>ORM/Models</strong>', '85%', '<span class="badge badge-stable">100%</span>', 'Eager loading, timestamps'],
        ['<strong>Container</strong>', '85%', '<span class="badge badge-stable">100%</span>', 'Contextual bindings'],
        ['<strong>Middleware</strong>', '95%', '<span class="badge badge-stable">100%</span>', 'Terminate, priority ordering'],
        ['<strong>Session</strong>', '80%', '<span class="badge badge-stable">100%</span>', 'Hijacking detection, IP/UA validation'],
        ['<strong>Auth</strong>', '85%', '<span class="badge badge-stable">100%</span>', '2FA TOTP, refresh tokens'],
    ]
) ?>

<!-- Helpers -->
<h2 id="helpers" class="heading heading-2">
    <span class="mdi mdi-function-variant heading-icon"></span>
    <span class="heading-text">Helper Functions</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Str Utility Class</span>
</h3>

<p>
    The <code>Str</code> class provides 40+ string manipulation methods for common operations.
</p>

<?= codeBlock('php', 'use Core\Support\Str;

// Case conversion
Str::camel(\'hello_world\');      // helloWorld
Str::snake(\'HelloWorld\');       // hello_world
Str::kebab(\'HelloWorld\');       // hello-world
Str::studly(\'hello_world\');     // HelloWorld
Str::title(\'hello world\');      // Hello World

// URL-friendly strings
Str::slug(\'Hello World!\');      // hello-world

// String manipulation
Str::limit(\'Long text here\', 10);    // Long te...
Str::words(\'Many words here\', 2);    // Many words...

// Random & unique strings
Str::random(16);                 // Random alphanumeric
Str::uuid();                     // UUID v4

// Checks
Str::startsWith(\'Hello\', \'He\');      // true
Str::endsWith(\'Hello\', \'lo\');        // true
Str::contains(\'Hello World\', \'Wor\'); // true

// Pluralization
Str::plural(\'item\', 5);         // items
Str::singular(\'items\');         // item') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Array Helpers</span>
</h3>

<p>
    18 array helper functions with dot notation support for nested data access.
</p>

<?= codeBlock('php', '// Dot notation access
$data = [\'user\' => [\'profile\' => [\'name\' => \'John\']]];

array_get($data, \'user.profile.name\');           // \'John\'
array_get($data, \'user.profile.age\', 25);        // 25 (default)

// Setting nested values
array_set($data, \'user.profile.email\', \'john@example.com\');

// Check existence
array_has($data, \'user.profile.name\');           // true

// Remove keys
array_forget($data, \'user.profile.email\');

// Flatten to dot notation
array_dot($data);
// [\'user.profile.name\' => \'John\']

// Filter arrays
array_only($data, [\'user\']);                     // Keep only \'user\'
array_except($data, [\'user\']);                   // Remove \'user\'

// First/Last with callbacks
array_first([1, 2, 3], fn($v) => $v > 1);        // 2
array_last([1, 2, 3], fn($v) => $v < 3);         // 2

// Wrap values
array_wrap(\'value\');                             // [\'value\']
array_wrap([\'already\', \'array\']);               // [\'already\', \'array\']') ?>

<!-- Validation -->
<h2 id="validation" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Validation System</span>
</h2>

<p>
    35+ new validation rules for files, patterns, types, and conditional validation.
</p>

<h3 class="heading heading-3">
    <span class="heading-text">File Validation</span>
</h3>

<?= codeBlock('php', '$validator = Validator::make($request->all(), [
    \'avatar\' => [\'file\', \'image\', \'mimes:jpg,png,gif\', \'max_file_size:2048\'],
    \'document\' => [\'file\', \'mimes:pdf,doc,docx\', \'max_file_size:10240\'],
    \'attachment\' => [\'nullable\', \'file\'],
]);') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Pattern Matching</span>
</h3>

<?= codeBlock('php', '$validator = Validator::make($data, [
    \'username\' => [\'required\', \'regex:/^[a-z0-9_]+$/i\'],
    \'code\' => [\'not_regex:/[<>]/\'],  // Prevent XSS characters
]);') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Type Validation</span>
</h3>

<?= codeBlock('php', '$validator = Validator::make($data, [
    \'uuid\' => [\'required\', \'uuid\'],
    \'config\' => [\'required\', \'json\'],
    \'timezone\' => [\'required\', \'timezone\'],
    \'server_ip\' => [\'required\', \'ip\'],
    \'ipv4_only\' => [\'ipv4\'],
    \'ipv6_only\' => [\'ipv6\'],
]);') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Conditional Rules</span>
</h3>

<?= codeBlock('php', '$validator = Validator::make($data, [
    // Required unless another field has specific value
    \'phone\' => [\'required_unless:contact_method,email\'],

    // Required without another field
    \'company\' => [\'required_without:individual_name\'],

    // Exclude from validated data if condition met
    \'notes\' => [\'exclude_if:type,draft\'],
]);') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Comparison Rules</span>
</h3>

<?= codeBlock('php', '$validator = Validator::make($data, [
    \'min_price\' => [\'required\', \'numeric\'],
    \'max_price\' => [\'required\', \'numeric\', \'gt:min_price\'],

    \'start_date\' => [\'required\', \'date\'],
    \'end_date\' => [\'required\', \'date\', \'after_or_equal:start_date\'],

    \'quantity\' => [\'required\', \'gte:1\', \'lte:100\'],
]);') ?>

<!-- Database -->
<h2 id="database" class="heading heading-2">
    <span class="mdi mdi-database heading-icon"></span>
    <span class="heading-text">Database & QueryBuilder</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Subqueries</span>
</h3>

<?= codeBlock('php', '// whereInSub - Select users who have orders
$users = DB::table(\'users\')
    ->whereInSub(\'id\', function($query) {
        $query->select(\'user_id\')->from(\'orders\');
    })
    ->get();

// whereExists - Check existence
$users = DB::table(\'users\')
    ->whereExists(function($query) {
        $query->from(\'posts\')
            ->whereRaw(\'posts.user_id = users.id\');
    })
    ->get();

// selectSub - Subquery in select
$users = DB::table(\'users\')
    ->selectSub(function($query) {
        $query->from(\'orders\')
            ->selectRaw(\'COUNT(*)\')
            ->whereRaw(\'orders.user_id = users.id\');
    }, \'order_count\')
    ->get();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Union Queries</span>
</h3>

<?= codeBlock('php', '// Combine result sets
$activeUsers = DB::table(\'users\')->where(\'status\', \'=\', \'active\');
$vipUsers = DB::table(\'users\')->where(\'is_vip\', \'=\', true);

$allUsers = $activeUsers->union($vipUsers)->get();

// Union all (keeps duplicates)
$allUsers = $activeUsers->unionAll($vipUsers)->get();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Chunking Large Datasets</span>
</h3>

<?= codeBlock('php', '// Process in chunks to avoid memory issues
DB::table(\'orders\')->chunk(1000, function($orders) {
    foreach ($orders as $order) {
        // Process each order
    }
});

// Generator-based cursor for memory efficiency
foreach (DB::table(\'users\')->cursor() as $user) {
    // Memory-efficient iteration
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Utility Methods</span>
</h3>

<?= codeBlock('php', '// Pluck single column (optionally keyed)
$names = DB::table(\'users\')->pluck(\'name\');
// [\'John\', \'Jane\', \'Bob\']

$names = DB::table(\'users\')->pluck(\'name\', \'id\');
// [1 => \'John\', 2 => \'Jane\', 3 => \'Bob\']

// Get single value
$email = DB::table(\'users\')->where(\'id\', \'=\', 1)->value(\'email\');

// Atomic increment/decrement
DB::table(\'products\')->where(\'id\', \'=\', 1)->increment(\'views\');
DB::table(\'products\')->where(\'id\', \'=\', 1)->decrement(\'stock\', 5);') ?>

<!-- ORM -->
<h2 id="orm" class="heading heading-2">
    <span class="mdi mdi-relation-many-to-many heading-icon"></span>
    <span class="heading-text">ORM Enhancements</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Eager Loading</span>
</h3>

<?= callout('tip', 'Eager loading prevents N+1 query problems by loading relationships in a single query instead of one per record.') ?>

<?= codeBlock('php', '// Load relationships upfront
$users = User::with(\'posts\', \'profile\')->get();

// Constrained eager loading
$users = User::with([
    \'posts\' => function($query) {
        $query->where(\'status\', \'=\', \'published\')
              ->orderBy(\'created_at\', \'DESC\');
    },
    \'comments\' => function($query) {
        $query->limit(5);
    }
])->get();

// Load on existing model
$user = User::find(1);
$user->load(\'posts\', \'comments\');

// Load only if not already loaded
$user->loadMissing(\'profile\');') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Automatic Timestamps</span>
</h3>

<?= codeBlock('php', 'class Post extends Model
{
    // Timestamps enabled by default
    protected bool $timestamps = true;

    // Customize column names if needed
    const CREATED_AT = \'created_at\';
    const UPDATED_AT = \'updated_at\';
}

// Timestamps auto-managed on save
$post = new Post();
$post->title = \'Hello\';
$post->save();  // created_at and updated_at set automatically

// Update timestamp manually
$post->touch();

// Update without touching timestamps
$post->updateQuietly([\'views\' => $post->views + 1]);') ?>

<!-- Container -->
<h2 id="container" class="heading heading-2">
    <span class="mdi mdi-needle heading-icon"></span>
    <span class="heading-text">Container & Dependency Injection</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Contextual Bindings</span>
</h3>

<p>
    Provide different implementations of the same interface based on which class is requesting it.
</p>

<?= codeBlock('php', '// Different loggers for different consumers
app()->when(ReportGenerator::class)
    ->needs(LoggerInterface::class)
    ->give(FileLogger::class);

app()->when(ApiController::class)
    ->needs(LoggerInterface::class)
    ->give(JsonLogger::class);

// With closure for complex construction
app()->when(PaymentService::class)
    ->needs(PaymentGateway::class)
    ->give(function($container) {
        return new StripeGateway(config(\'services.stripe.key\'));
    });

// Multiple classes with same binding
app()->when([ReportGenerator::class, DataExporter::class])
    ->needs(CacheInterface::class)
    ->give(FileCache::class);') ?>

<!-- Middleware -->
<h2 id="middleware" class="heading heading-2">
    <span class="mdi mdi-filter heading-icon"></span>
    <span class="heading-text">Middleware System</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Terminate Phase</span>
</h3>

<p>
    Terminable middleware runs after the response is sent, perfect for logging and cleanup.
</p>

<?= codeBlock('php', 'use Core\Middleware\TerminableMiddleware;

class LoggingMiddleware implements TerminableMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        $request->attributes[\'start_time\'] = microtime(true);
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        // Runs AFTER response sent to client
        $duration = microtime(true) - $request->attributes[\'start_time\'];
        logger()->info("Request completed in {$duration}s");
    }
}

// In application entry point
$response = $router->dispatch($request);
$response->send();
$router->terminate($request, $response);  // Post-response tasks') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Priority Ordering</span>
</h3>

<?= codeBlock('php', '// Define middleware execution order
Router::middlewarePriority([
    CorsMiddleware::class,        // First - handle CORS
    ThrottleMiddleware::class,    // Rate limiting
    AuthMiddleware::class,        // Authentication
    CsrfMiddleware::class,        // CSRF last
]);') ?>

<!-- Session -->
<h2 id="session" class="heading heading-2">
    <span class="mdi mdi-shield-lock heading-icon"></span>
    <span class="heading-text">Session Security</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Hijacking Detection</span>
</h3>

<?= callout('warning', 'Session hijacking detection automatically invalidates sessions when the IP address or User-Agent changes unexpectedly.') ?>

<?= codeBlock('php', '// Configure session security
session()->configure([
    \'validate_ip\' => true,           // Check IP hasn\'t changed
    \'validate_user_agent\' => true,   // Check User-Agent
    \'regenerate_interval\' => 300,    // Regenerate ID every 5 mins
]);

// Validation happens automatically on session start
session()->start();

// Manual validation
if (!session()->validateSession()) {
    // Possible hijacking attempt
    session()->invalidate();
    redirect(\'/login\');
}

// Get security metadata
$meta = session()->getSecurityMetadata();
// [\'ip\' => \'192.168.1.1\', \'user_agent_hash\' => \'...\', ...]') ?>

<!-- Auth -->
<h2 id="auth" class="heading heading-2">
    <span class="mdi mdi-two-factor-authentication heading-icon"></span>
    <span class="heading-text">Authentication Enhancements</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Two-Factor Authentication (TOTP)</span>
</h3>

<?= codeBlock('php', 'use Core\Auth\TwoFactor\TotpAuthenticator;

$totp = new TotpAuthenticator();

// Generate secret for new user
$secret = $totp->generateSecret();
// Store $secret in database (encrypted!)

// Generate QR code URL for authenticator apps
$qrUrl = $totp->getQrCodeUrl($secret, \'user@example.com\', \'MyApp\');
// otpauth://totp/MyApp:user@example.com?secret=...

// Direct image URL for QR code
$imageUrl = $totp->getQrCodeImageUrl($secret, \'user@example.com\', \'MyApp\');

// Verify code from user (checks +/- 1 time window)
if ($totp->verify($secret, $userCode)) {
    // Code is valid - complete login
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Backup Codes</span>
</h3>

<?= codeBlock('php', '// Generate 8 backup codes
$backupCodes = $totp->generateBackupCodes(8);
// [\'A1B2-C3D4\', \'E5F6-G7H8\', ...]

// Hash for secure storage
$hashedCodes = $totp->hashBackupCodes($backupCodes);

// Store $hashedCodes in database

// Verify backup code
$index = $totp->verifyBackupCode($userCode, $hashedCodes);
if ($index !== false) {
    // Valid - remove used code
    unset($hashedCodes[$index]);
    // Update database
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Refresh Token Manager</span>
</h3>

<?= codeBlock('php', 'use Core\Auth\RefreshTokenManager;

$manager = new RefreshTokenManager();

// Configure
$manager->configure([
    \'ttl\' => 604800,              // 7 days
    \'use_database\' => true,       // Store in DB vs cache
    \'table\' => \'refresh_tokens\',
    \'max_tokens_per_user\' => 5,   // Limit active tokens
]);

// Create token for user
$refreshToken = $manager->create($userId, [
    \'device\' => \'iPhone\',
    \'ip\' => $request->ip(),
]);

// Validate token
$data = $manager->validate($refreshToken);
if ($data) {
    $userId = $data[\'user_id\'];
}

// Rotate token (revoke old, issue new)
$newData = $manager->refresh($oldToken);
// [\'refresh_token\' => \'new...\', \'user_id\' => 1, \'expires_at\' => ...]

// Revoke single token
$manager->revoke($refreshToken);

// Revoke all user tokens (logout everywhere)
$manager->revokeAllForUser($userId);

// Get active tokens for user
$tokens = $manager->getTokensForUser($userId);

// Cleanup expired tokens (cron job)
$manager->cleanup();') ?>

<?= callout('success', 'All 8 core systems are now at 100% completion with comprehensive test coverage (324 unit tests + 553 integration tests).') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
