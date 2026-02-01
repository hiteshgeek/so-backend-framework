<?php
/**
 * Developer Guide: Core Framework Enhancements
 *
 * Implementation guide for Phase 6 features.
 */

$pageTitle = 'Core Enhancements Implementation';
$pageIcon = 'code-braces';
$toc = [
    ['id' => 'overview', 'title' => 'Overview', 'level' => 2],
    ['id' => 'str-usage', 'title' => 'Using Str Class', 'level' => 2],
    ['id' => 'array-helpers', 'title' => 'Array Helper Patterns', 'level' => 2],
    ['id' => 'validation-impl', 'title' => 'Custom Validation', 'level' => 2],
    ['id' => 'subqueries', 'title' => 'Subquery Patterns', 'level' => 2],
    ['id' => 'eager-loading', 'title' => 'Eager Loading Patterns', 'level' => 2],
    ['id' => 'contextual-di', 'title' => 'Contextual DI Setup', 'level' => 2],
    ['id' => 'terminable-middleware', 'title' => 'Terminable Middleware', 'level' => 2],
    ['id' => 'session-security', 'title' => 'Session Security Setup', 'level' => 2],
    ['id' => 'two-factor', 'title' => '2FA Implementation', 'level' => 2],
    ['id' => 'refresh-tokens', 'title' => 'Refresh Token Flow', 'level' => 2],
];
$breadcrumbs = [['label' => 'Development'], ['label' => 'Core Enhancements']];
$lastUpdated = '2026-02-01';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="dev-core-enhancements" class="heading heading-1">
    <span class="mdi mdi-code-braces heading-icon"></span>
    <span class="heading-text">Core Enhancements Implementation Guide</span>
</h1>

<p class="text-lead">
    Step-by-step implementation guide for Phase 6 core features with real-world examples and best practices.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-guide">Developer Guide</span>
    <span class="badge badge-new">Phase 6</span>
</div>

<!-- Overview -->
<h2 id="overview" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Overview</span>
</h2>

<p>
    This guide covers practical implementation patterns for the 8 core systems completed in Phase 6.
</p>

<?= dataTable(
    ['Feature', 'File Location', 'Use Case'],
    [
        ['Str Class', filePath('core/Support/Str.php'), 'String manipulation, slugs, UUIDs'],
        ['Array Helpers', filePath('core/Support/Helpers.php'), 'Nested data access, configuration'],
        ['Validation Rules', filePath('core/Validation/Validator.php'), 'Form validation, API input'],
        ['Subqueries', filePath('core/Database/QueryBuilder.php'), 'Complex database queries'],
        ['Eager Loading', filePath('core/Model/ModelQueryBuilder.php'), 'Relationship optimization'],
        ['Contextual DI', filePath('core/Container/Container.php'), 'Service configuration'],
        ['Terminable Middleware', filePath('core/Middleware/TerminableMiddleware.php'), 'Post-response tasks'],
        ['Session Security', filePath('core/Http/Session.php'), 'Hijacking prevention'],
        ['2FA TOTP', filePath('core/Auth/TwoFactor/TotpAuthenticator.php'), 'Two-factor authentication'],
        ['Refresh Tokens', filePath('core/Auth/RefreshTokenManager.php'), 'API token management'],
    ]
) ?>

<!-- Str Usage -->
<h2 id="str-usage" class="heading heading-2">
    <span class="mdi mdi-text-box heading-icon"></span>
    <span class="heading-text">Using the Str Class</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Creating URL Slugs</span>
</h3>

<?= codeBlock('php', 'use Core\Support\Str;

class PostController
{
    public function store(Request $request)
    {
        $title = $request->input(\'title\');

        $post = new Post();
        $post->title = $title;
        $post->slug = Str::slug($title);  // "My Blog Post" -> "my-blog-post"

        // Ensure unique slug
        $baseSlug = $post->slug;
        $counter = 1;
        while (Post::where(\'slug\', \'=\', $post->slug)->exists()) {
            $post->slug = $baseSlug . \'-\' . $counter++;
        }

        $post->save();
        return redirect("/posts/{$post->slug}");
    }
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Generating Unique Identifiers</span>
</h3>

<?= codeBlock('php', '// Generate UUID for public-facing IDs
$order = new Order();
$order->public_id = Str::uuid();  // "550e8400-e29b-41d4-a716-446655440000"

// Generate random tokens
$token = Str::random(32);  // For password reset tokens
$apiKey = \'sk_\' . Str::random(24);  // For API keys') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Converting Between Cases</span>
</h3>

<?= codeBlock('php', '// Model class from table name
$tableName = \'user_profiles\';
$className = Str::studly($tableName);  // "UserProfiles"

// Table name from class
$className = \'UserProfile\';
$tableName = Str::snake($className);  // "user_profile"

// Method name from event
$eventName = \'order-placed\';
$methodName = \'handle\' . Str::studly($eventName);  // "handleOrderPlaced"') ?>

<!-- Array Helpers -->
<h2 id="array-helpers" class="heading heading-2">
    <span class="mdi mdi-code-array heading-icon"></span>
    <span class="heading-text">Array Helper Patterns</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Working with Configuration</span>
</h3>

<?= codeBlock('php', '// Deep configuration access
$config = [
    \'database\' => [
        \'connections\' => [
            \'mysql\' => [
                \'host\' => \'localhost\',
                \'port\' => 3306,
            ]
        ]
    ]
];

$host = array_get($config, \'database.connections.mysql.host\');
$port = array_get($config, \'database.connections.mysql.port\', 3306);

// Dynamic configuration
array_set($config, \'database.connections.mysql.charset\', \'utf8mb4\');

// Check before use
if (array_has($config, \'database.connections.pgsql\')) {
    // PostgreSQL is configured
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Processing API Responses</span>
</h3>

<?= codeBlock('php', '// Flatten nested API response
$response = [
    \'user\' => [
        \'id\' => 1,
        \'profile\' => [
            \'name\' => \'John\',
            \'email\' => \'john@example.com\'
        ]
    ]
];

$flat = array_dot($response);
// [\'user.id\' => 1, \'user.profile.name\' => \'John\', \'user.profile.email\' => \'john@example.com\']

// Filter sensitive data
$safe = array_except($response[\'user\'], [\'password\', \'api_key\']);

// Pick only needed fields
$minimal = array_only($response[\'user\'][\'profile\'], [\'name\', \'email\']);') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Finding in Collections</span>
</h3>

<?= codeBlock('php', '$users = [
    [\'id\' => 1, \'name\' => \'John\', \'active\' => true],
    [\'id\' => 2, \'name\' => \'Jane\', \'active\' => false],
    [\'id\' => 3, \'name\' => \'Bob\', \'active\' => true],
];

// Find first active user
$firstActive = array_first($users, fn($u) => $u[\'active\'] === true);
// [\'id\' => 1, \'name\' => \'John\', \'active\' => true]

// Find last active user
$lastActive = array_last($users, fn($u) => $u[\'active\'] === true);
// [\'id\' => 3, \'name\' => \'Bob\', \'active\' => true]

// With default
$admin = array_first($users, fn($u) => $u[\'role\'] ?? null === \'admin\', [\'name\' => \'No Admin\']);') ?>

<!-- Validation Implementation -->
<h2 id="validation-impl" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Custom Validation Patterns</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">File Upload Validation</span>
</h3>

<?= codeBlock('php', 'class MediaController
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            \'file\' => [
                \'required\',
                \'file\',
                \'max_file_size:10240\',  // 10MB max
            ],
            \'avatar\' => [
                \'nullable\',
                \'image\',
                \'mimes:jpg,png,webp\',
                \'max_file_size:2048\',  // 2MB max
            ],
            \'document\' => [
                \'nullable\',
                \'file\',
                \'mimes:pdf,doc,docx,xls,xlsx\',
                \'max_file_size:20480\',  // 20MB max
            ],
        ], [
            \'file.max_file_size\' => \'File must be less than 10MB\',
            \'avatar.image\' => \'Avatar must be a valid image\',
        ]);

        if ($validator->fails()) {
            return response()->json([\'errors\' => $validator->errors()], 422);
        }

        // Process upload...
    }
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Conditional Validation</span>
</h3>

<?= codeBlock('php', 'class OrderController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            \'delivery_method\' => [\'required\', \'in:pickup,delivery\'],

            // Address required only for delivery
            \'address\' => [\'required_if:delivery_method,delivery\'],
            \'city\' => [\'required_if:delivery_method,delivery\'],
            \'postal_code\' => [\'required_if:delivery_method,delivery\'],

            // Pickup location required only for pickup
            \'pickup_location\' => [\'required_if:delivery_method,pickup\'],

            // Either phone or email required
            \'phone\' => [\'required_without:email\'],
            \'email\' => [\'required_without:phone\', \'email\'],

            // Price range validation
            \'min_price\' => [\'nullable\', \'numeric\', \'min:0\'],
            \'max_price\' => [\'nullable\', \'numeric\', \'gt:min_price\'],
        ]);

        // ...
    }
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">UUID and JSON Validation</span>
</h3>

<?= codeBlock('php', 'class WebhookController
{
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            \'event_id\' => [\'required\', \'uuid\'],
            \'payload\' => [\'required\', \'json\'],
            \'timestamp\' => [\'required\', \'date\'],
            \'signature\' => [\'required\', \'regex:/^[a-f0-9]{64}$/\'],
        ]);

        if ($validator->fails()) {
            return response()->json([\'error\' => \'Invalid webhook\'], 400);
        }

        $payload = json_decode($request->input(\'payload\'), true);
        // Process webhook...
    }
}') ?>

<!-- Subqueries -->
<h2 id="subqueries" class="heading heading-2">
    <span class="mdi mdi-database-search heading-icon"></span>
    <span class="heading-text">Subquery Patterns</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Finding Related Records</span>
</h3>

<?= codeBlock('php', '// Users who have placed orders
$activeCustomers = DB::table(\'users\')
    ->whereInSub(\'id\', function($query) {
        $query->select(\'user_id\')
            ->from(\'orders\')
            ->where(\'status\', \'=\', \'completed\');
    })
    ->get();

// Users who have NOT placed orders
$inactiveCustomers = DB::table(\'users\')
    ->whereNotInSub(\'id\', function($query) {
        $query->select(\'user_id\')->from(\'orders\');
    })
    ->get();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Existence Checks</span>
</h3>

<?= codeBlock('php', '// Products that have been ordered
$popularProducts = DB::table(\'products\')
    ->whereExists(function($query) {
        $query->from(\'order_items\')
            ->whereRaw(\'order_items.product_id = products.id\');
    })
    ->get();

// Products with no orders
$unpopularProducts = DB::table(\'products\')
    ->whereNotExists(function($query) {
        $query->from(\'order_items\')
            ->whereRaw(\'order_items.product_id = products.id\');
    })
    ->get();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Aggregates in Select</span>
</h3>

<?= codeBlock('php', '// Users with order count
$usersWithStats = DB::table(\'users\')
    ->select(\'users.*\')
    ->selectSub(function($query) {
        $query->from(\'orders\')
            ->selectRaw(\'COUNT(*)\')
            ->whereRaw(\'orders.user_id = users.id\');
    }, \'order_count\')
    ->selectSub(function($query) {
        $query->from(\'orders\')
            ->selectRaw(\'COALESCE(SUM(total), 0)\')
            ->whereRaw(\'orders.user_id = users.id\');
    }, \'total_spent\')
    ->orderBy(\'total_spent\', \'DESC\')
    ->get();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Processing Large Datasets</span>
</h3>

<?= codeBlock('php', '// Export millions of records without memory issues
DB::table(\'transactions\')
    ->where(\'year\', \'=\', 2025)
    ->chunk(5000, function($transactions) {
        foreach ($transactions as $tx) {
            // Write to CSV or process
            fputcsv($file, (array) $tx);
        }
    });

// Generator for streaming responses
public function exportCsv()
{
    return response()->stream(function() {
        $output = fopen(\'php://output\', \'w\');
        fputcsv($output, [\'ID\', \'Amount\', \'Date\']);

        foreach (DB::table(\'orders\')->cursor() as $order) {
            fputcsv($output, [$order->id, $order->amount, $order->created_at]);
        }

        fclose($output);
    }, 200, [\'Content-Type\' => \'text/csv\']);
}') ?>

<!-- Eager Loading -->
<h2 id="eager-loading" class="heading heading-2">
    <span class="mdi mdi-relation-many-to-many heading-icon"></span>
    <span class="heading-text">Eager Loading Patterns</span>
</h2>

<?= callout('warning', 'Without eager loading, accessing relationships in a loop causes N+1 queries. For 100 users with posts, that\'s 101 queries instead of 2.') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Basic Eager Loading</span>
</h3>

<?= codeBlock('php', '// BAD: N+1 queries
$users = User::all();
foreach ($users as $user) {
    echo $user->profile->name;  // Query per user!
}

// GOOD: 2 queries total
$users = User::with(\'profile\')->get();
foreach ($users as $user) {
    echo $user->profile->name;  // No additional query
}

// Multiple relationships
$users = User::with(\'profile\', \'posts\', \'orders\')->get();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Constrained Eager Loading</span>
</h3>

<?= codeBlock('php', '// Load only published posts, ordered by date
$users = User::with([
    \'posts\' => function($query) {
        $query->where(\'status\', \'=\', \'published\')
              ->orderBy(\'created_at\', \'DESC\')
              ->limit(5);
    }
])->get();

// Nested relationships with constraints
$orders = Order::with([
    \'user\' => function($query) {
        $query->select(\'id\', \'name\', \'email\');  // Only needed fields
    },
    \'items.product\' => function($query) {
        $query->where(\'active\', \'=\', true);
    }
])->get();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Lazy Eager Loading</span>
</h3>

<?= codeBlock('php', '// When you already have models
$user = User::find(1);

// Need to load relationships later
$user->load(\'posts\', \'comments\');

// Only load if not already loaded
$user->loadMissing(\'profile\');

// Conditional loading
if ($includeDetails) {
    $user->load(\'orders.items\');
}') ?>

<!-- Contextual DI -->
<h2 id="contextual-di" class="heading heading-2">
    <span class="mdi mdi-needle heading-icon"></span>
    <span class="heading-text">Contextual Dependency Injection</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Service Provider Setup</span>
</h3>

<?= codeBlock('php', '// In app/Providers/AppServiceProvider.php

public function register(): void
{
    // Different payment gateways per environment
    app()->when(PaymentService::class)
        ->needs(PaymentGatewayInterface::class)
        ->give(function($container) {
            return config(\'app.env\') === \'production\'
                ? new StripeGateway(config(\'services.stripe.key\'))
                : new FakeGateway();
        });

    // Different loggers per service type
    app()->when(ApiController::class)
        ->needs(LoggerInterface::class)
        ->give(JsonLogger::class);

    app()->when(ReportService::class)
        ->needs(LoggerInterface::class)
        ->give(FileLogger::class);

    // Multiple classes with same binding
    app()->when([OrderService::class, InvoiceService::class])
        ->needs(TaxCalculatorInterface::class)
        ->give(function($container) {
            return new TaxCalculator(config(\'tax.default_rate\'));
        });
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Testing with Contextual Bindings</span>
</h3>

<?= codeBlock('php', '// In tests, override bindings
public function testOrderProcessing()
{
    // Use mock payment gateway for this test
    app()->when(PaymentService::class)
        ->needs(PaymentGatewayInterface::class)
        ->give(fn() => new MockPaymentGateway());

    $service = app(PaymentService::class);
    $result = $service->charge(100);

    $this->assertTrue($result->success);
}') ?>

<!-- Terminable Middleware -->
<h2 id="terminable-middleware" class="heading heading-2">
    <span class="mdi mdi-filter heading-icon"></span>
    <span class="heading-text">Creating Terminable Middleware</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Request Timing Middleware</span>
</h3>

<?= codeBlockWithFile('php', '<?php
// app/Middleware/RequestTimingMiddleware.php

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\TerminableMiddleware;

class RequestTimingMiddleware implements TerminableMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        // Store start time
        $request->attributes[\'request_started\'] = microtime(true);
        $request->attributes[\'memory_start\'] = memory_get_usage();

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        // This runs AFTER response is sent to client
        $duration = microtime(true) - $request->attributes[\'request_started\'];
        $memoryUsed = memory_get_usage() - $request->attributes[\'memory_start\'];

        logger()->info(\'Request completed\', [
            \'uri\' => $request->uri(),
            \'method\' => $request->method(),
            \'status\' => $response->getStatusCode(),
            \'duration_ms\' => round($duration * 1000, 2),
            \'memory_kb\' => round($memoryUsed / 1024, 2),
        ]);

        // Save to analytics
        Analytics::record([
            \'endpoint\' => $request->uri(),
            \'response_time\' => $duration,
        ]);
    }
}', 'app/Middleware/RequestTimingMiddleware.php') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Registering with Priority</span>
</h3>

<?= codeBlock('php', '// In bootstrap or service provider

Router::globalMiddleware([
    RequestTimingMiddleware::class,
    CorsMiddleware::class,
    // ...
]);

// Ensure timing runs first
Router::middlewarePriority([
    RequestTimingMiddleware::class,  // First to start timer
    CorsMiddleware::class,
    ThrottleMiddleware::class,
    AuthMiddleware::class,
]);') ?>

<!-- Session Security -->
<h2 id="session-security" class="heading heading-2">
    <span class="mdi mdi-shield-lock heading-icon"></span>
    <span class="heading-text">Session Security Setup</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Configuration</span>
</h3>

<?= codeBlock('php', '// In bootstrap/app.php or service provider

$session = app(\'session\');

$session->configure([
    // Validate client hasn\'t changed IP
    \'validate_ip\' => true,

    // Validate User-Agent hasn\'t changed
    \'validate_user_agent\' => true,

    // Regenerate session ID every 5 minutes
    \'regenerate_interval\' => 300,

    // Maximum sessions per user (requires database sessions)
    \'max_concurrent_sessions\' => 5,
]);') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Handling Hijacking Detection</span>
</h3>

<?= codeBlock('php', 'class AuthController
{
    public function checkSession(Request $request)
    {
        $session = app(\'session\');

        if (!$session->validateSession()) {
            // Possible hijacking - log the attempt
            logger()->warning(\'Session hijacking attempt detected\', [
                \'session_id\' => $session->getId(),
                \'stored_ip\' => $session->getSecurityMetadata()[\'ip\'],
                \'current_ip\' => $request->ip(),
            ]);

            // Destroy the session
            $session->invalidate();

            // Redirect to login
            return redirect(\'/login\')->with(\'error\', \'Session expired. Please login again.\');
        }

        // Session is valid
        return $next($request);
    }
}') ?>

<!-- Two-Factor -->
<h2 id="two-factor" class="heading heading-2">
    <span class="mdi mdi-two-factor-authentication heading-icon"></span>
    <span class="heading-text">2FA Implementation</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Setup Flow</span>
</h3>

<?= codeBlock('php', 'class TwoFactorController
{
    public function setup(Request $request)
    {
        $totp = new TotpAuthenticator();
        $user = auth()->user();

        // Generate secret
        $secret = $totp->generateSecret();

        // Store temporarily (not enabled yet)
        $user->two_factor_secret = encrypt($secret);
        $user->save();

        // Generate QR code URL
        $qrUrl = $totp->getQrCodeUrl(
            $secret,
            $user->email,
            config(\'app.name\')
        );

        // Generate backup codes
        $backupCodes = $totp->generateBackupCodes(8);

        // Store hashed backup codes
        $user->two_factor_backup_codes = json_encode(
            $totp->hashBackupCodes($backupCodes)
        );
        $user->save();

        return view(\'auth.two-factor-setup\', [
            \'qrUrl\' => $qrUrl,
            \'secret\' => $secret,  // For manual entry
            \'backupCodes\' => $backupCodes,  // Show once!
        ]);
    }

    public function confirm(Request $request)
    {
        $totp = new TotpAuthenticator();
        $user = auth()->user();

        $secret = decrypt($user->two_factor_secret);

        if (!$totp->verify($secret, $request->input(\'code\'))) {
            return back()->withErrors([\'code\' => \'Invalid code\']);
        }

        // Enable 2FA
        $user->two_factor_enabled = true;
        $user->save();

        return redirect(\'/settings\')->with(\'success\', \'2FA enabled!\');
    }
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Login Flow</span>
</h3>

<?= codeBlock('php', 'class LoginController
{
    public function login(Request $request)
    {
        $credentials = $request->only(\'email\', \'password\');

        if (!auth()->validate($credentials)) {
            return back()->withErrors([\'email\' => \'Invalid credentials\']);
        }

        $user = User::where(\'email\', \'=\', $credentials[\'email\'])->first();

        // Check if 2FA enabled
        if ($user->two_factor_enabled) {
            // Store user ID in session for 2FA step
            session()->set(\'2fa_user_id\', $user->id);
            return redirect(\'/login/2fa\');
        }

        // No 2FA, complete login
        auth()->login($user);
        return redirect(\'/dashboard\');
    }

    public function verify2fa(Request $request)
    {
        $userId = session()->get(\'2fa_user_id\');
        if (!$userId) {
            return redirect(\'/login\');
        }

        $user = User::find($userId);
        $totp = new TotpAuthenticator();
        $code = $request->input(\'code\');

        // Try TOTP code
        $secret = decrypt($user->two_factor_secret);
        if ($totp->verify($secret, $code)) {
            session()->forget(\'2fa_user_id\');
            auth()->login($user);
            return redirect(\'/dashboard\');
        }

        // Try backup code
        $backupCodes = json_decode($user->two_factor_backup_codes, true);
        $index = $totp->verifyBackupCode($code, $backupCodes);

        if ($index !== false) {
            // Remove used backup code
            unset($backupCodes[$index]);
            $user->two_factor_backup_codes = json_encode(array_values($backupCodes));
            $user->save();

            session()->forget(\'2fa_user_id\');
            auth()->login($user);

            return redirect(\'/dashboard\')
                ->with(\'warning\', \'Backup code used. Consider regenerating codes.\');
        }

        return back()->withErrors([\'code\' => \'Invalid code\']);
    }
}') ?>

<!-- Refresh Tokens -->
<h2 id="refresh-tokens" class="heading heading-2">
    <span class="mdi mdi-key-chain heading-icon"></span>
    <span class="heading-text">Refresh Token Flow</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">API Authentication Flow</span>
</h3>

<?= codeBlock('php', 'class ApiAuthController
{
    protected RefreshTokenManager $refreshManager;

    public function __construct()
    {
        $this->refreshManager = new RefreshTokenManager();
        $this->refreshManager->configure([
            \'ttl\' => 604800,  // 7 days
            \'use_database\' => true,
            \'max_tokens_per_user\' => 5,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(\'email\', \'password\');

        if (!auth()->attempt($credentials)) {
            return response()->json([\'error\' => \'Invalid credentials\'], 401);
        }

        $user = auth()->user();

        // Generate short-lived access token (15 mins)
        $accessToken = JWT::encode([
            \'sub\' => $user->id,
            \'exp\' => time() + 900,
        ]);

        // Generate long-lived refresh token (7 days)
        $refreshToken = $this->refreshManager->create($user->id, [
            \'device\' => $request->header(\'X-Device-Name\', \'Unknown\'),
            \'ip\' => $request->ip(),
        ]);

        return response()->json([
            \'access_token\' => $accessToken,
            \'refresh_token\' => $refreshToken,
            \'expires_in\' => 900,
        ]);
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->input(\'refresh_token\');

        // Validate and rotate
        $data = $this->refreshManager->refresh($refreshToken);

        if (!$data) {
            return response()->json([\'error\' => \'Invalid refresh token\'], 401);
        }

        // Generate new access token
        $accessToken = JWT::encode([
            \'sub\' => $data[\'user_id\'],
            \'exp\' => time() + 900,
        ]);

        return response()->json([
            \'access_token\' => $accessToken,
            \'refresh_token\' => $data[\'refresh_token\'],
            \'expires_in\' => 900,
        ]);
    }

    public function logout(Request $request)
    {
        $refreshToken = $request->input(\'refresh_token\');
        $this->refreshManager->revoke($refreshToken);

        return response()->json([\'message\' => \'Logged out\']);
    }

    public function logoutAll(Request $request)
    {
        $user = auth()->user();
        $count = $this->refreshManager->revokeAllForUser($user->id);

        return response()->json([
            \'message\' => "Logged out from {$count} devices"
        ]);
    }

    public function sessions(Request $request)
    {
        $user = auth()->user();
        $tokens = $this->refreshManager->getTokensForUser($user->id);

        return response()->json([
            \'sessions\' => array_map(fn($t) => [
                \'id\' => $t[\'id\'],
                \'device\' => $t[\'metadata\'][\'device\'] ?? \'Unknown\',
                \'ip\' => $t[\'ip_address\'],
                \'last_used\' => $t[\'created_at\'],
            ], $tokens)
        ]);
    }
}') ?>

<?= callout('tip', 'Set up a cron job to run <code>$refreshManager->cleanup()</code> daily to remove expired tokens from the database.') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
