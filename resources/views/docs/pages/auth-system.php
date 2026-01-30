<?php
/**
 * Authentication System Documentation Page
 *
 * Complete guide to user authentication and authorization.
 */

$pageTitle = 'Authentication System';
$pageIcon = 'shield-account';
$toc = [
    ['id' => 'overview', 'title' => 'Overview', 'level' => 2],
    ['id' => 'quick-start', 'title' => 'Quick Start', 'level' => 2],
    ['id' => 'auth-methods', 'title' => 'Authentication Methods', 'level' => 2],
    ['id' => 'session-auth', 'title' => 'Session-Based Auth', 'level' => 2],
    ['id' => 'jwt-auth', 'title' => 'JWT Authentication', 'level' => 2],
    ['id' => 'remember-me', 'title' => 'Remember Me', 'level' => 2],
    ['id' => 'middleware', 'title' => 'Auth Middleware', 'level' => 2],
    ['id' => 'password-management', 'title' => 'Password Management', 'level' => 2],
    ['id' => 'authorization', 'title' => 'Authorization & Roles', 'level' => 2],
    ['id' => 'security-best-practices', 'title' => 'Security Best Practices', 'level' => 2],
];
$breadcrumbs = [['label' => 'Authentication']];
$lastUpdated = '2026-01-30';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="authentication-system" class="heading heading-1">
    <span class="mdi mdi-shield-account heading-icon"></span>
    <span class="heading-text">Authentication System</span>
</h1>

<p class="text-lead">
    Complete guide to user authentication and authorization in the SO Framework.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-stable">Session-Based Auth</span>
    <span class="badge badge-stable">JWT Support</span>
    <span class="badge badge-stable">Version <?= htmlspecialchars(config('app.version')) ?></span>
</div>

<!-- Overview -->
<h2 id="overview" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Overview</span>
</h2>

<?= featureGrid([
    ['icon' => 'account-key', 'title' => 'Session Auth', 'description' => 'Traditional web authentication with sessions'],
    ['icon' => 'key-variant', 'title' => 'JWT Tokens', 'description' => 'Stateless token-based auth for APIs'],
    ['icon' => 'cookie', 'title' => 'Remember Me', 'description' => 'Persistent authentication via secure cookies'],
    ['icon' => 'shield-lock', 'title' => 'Password Hashing', 'description' => 'Secure Argon2ID hashing'],
    ['icon' => 'speedometer', 'title' => 'Rate Limiting', 'description' => 'Protection against brute force'],
    ['icon' => 'account-check', 'title' => 'CSRF Protection', 'description' => 'Built-in CSRF token validation'],
], 3) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Auth Components</span>
</h3>

<?= dataTable(
    ['Component', 'Purpose', 'File'],
    [
        ['<strong>Auth Service</strong>', 'Core authentication logic', filePath('core/Auth/Auth.php')],
        ['<strong>JWT Service</strong>', 'Token generation/validation', filePath('core/Security/JWT.php')],
        ['<strong>Session</strong>', 'Session management', filePath('core/Http/Session.php')],
        ['<strong>AuthMiddleware</strong>', 'Route protection', filePath('app/Middleware/AuthMiddleware.php')],
        ['<strong>User Model</strong>', 'User data access', filePath('app/Models/User.php')],
    ]
) ?>

<!-- Quick Start -->
<h2 id="quick-start" class="heading heading-2">
    <span class="mdi mdi-rocket-launch heading-icon"></span>
    <span class="heading-text">Quick Start</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">1. Login Controller</span>
</h3>

<?= codeBlockWithFile('php', '<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\RedirectResponse;

class AuthController
{
    public function login(Request $request)
    {
        $credentials = [
            \'email\' => $request->input(\'email\'),
            \'password\' => $request->input(\'password\'),
        ];

        $remember = $request->input(\'remember\', false);

        if (auth()->attempt($credentials, $remember)) {
            return redirect(\'/dashboard\');
        }

        return back()->with(\'error\', \'Invalid credentials\');
    }

    public function logout()
    {
        auth()->logout();
        return redirect(\'/login\');
    }
}', 'app/Controllers/AuthController.php') ?>

<h3 class="heading heading-3">
    <span class="heading-text">2. Login Form</span>
</h3>

<?= codeBlock('php', '<form method="POST" action="/login">
    <?= csrf_field() ?>

    <div>
        <label>Email</label>
        <input type="email" name="email" required>
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>
            <input type="checkbox" name="remember" value="1">
            Remember Me
        </label>
    </div>

    <button type="submit">Login</button>
</form>') ?>

<h3 class="heading heading-3">
    <span class="heading-text">3. Protect Routes</span>
</h3>

<?= codeBlockWithFile('php', '// Public routes
Router::get(\'/login\', [AuthController::class, \'showLogin\']);
Router::post(\'/login\', [AuthController::class, \'login\']);

// Protected routes
Router::group([\'middleware\' => \'auth\'], function () {
    Router::get(\'/dashboard\', [DashboardController::class, \'index\']);
    Router::get(\'/profile\', [ProfileController::class, \'show\']);
    Router::post(\'/logout\', [AuthController::class, \'logout\']);
});', 'routes/web.php') ?>

<!-- Authentication Methods -->
<h2 id="auth-methods" class="heading heading-2">
    <span class="mdi mdi-function heading-icon"></span>
    <span class="heading-text">Authentication Methods</span>
</h2>

<?= codeBlock('php', '// Check if user is authenticated
auth()->check();  // Returns bool

// Check if user is a guest (not authenticated)
auth()->guest();  // Returns bool

// Get authenticated user
$user = auth()->user();  // Returns User|null

// Get authenticated user ID
$userId = auth()->id();  // Returns int|null

// Attempt authentication
auth()->attempt([
    \'email\' => \'user@example.com\',
    \'password\' => \'password123\'
], $remember = false);

// Manual login
auth()->login($user, $remember = false);

// Logout
auth()->logout();') ?>

<!-- Session-Based Auth -->
<h2 id="session-auth" class="heading heading-2">
    <span class="mdi mdi-account-key heading-icon"></span>
    <span class="heading-text">Session-Based Authentication</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">How It Works</span>
</h3>

<ol class="list">
    <li>User submits credentials via login form</li>
    <li>Server validates credentials</li>
    <li>On success, user ID stored in session</li>
    <li>Session cookie sent to browser</li>
    <li>Subsequent requests include session cookie</li>
    <li>Middleware checks session for authentication</li>
</ol>

<h3 class="heading heading-3">
    <span class="heading-text">Configuration</span>
</h3>

<?= codeBlock('ini', 'SESSION_DRIVER=database
SESSION_LIFETIME=120  # minutes
SESSION_COOKIE=so_session
SESSION_SECURE=false  # Set to true with HTTPS
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax', '.env') ?>

<!-- JWT Authentication -->
<h2 id="jwt-auth" class="heading heading-2">
    <span class="mdi mdi-key-variant heading-icon"></span>
    <span class="heading-text">JWT Authentication</span>
</h2>

<p>JWT (JSON Web Token) is stateless and ideal for APIs. Tokens are signed and verified using a secret key.</p>

<h3 class="heading heading-3">
    <span class="heading-text">Configuration</span>
</h3>

<?= codeBlock('ini', 'JWT_SECRET=your-secret-key-here
JWT_ALGORITHM=HS256
JWT_EXPIRATION=3600  # 1 hour', '.env') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Generating Tokens</span>
</h3>

<?= codeBlock('php', 'public function login(Request $request): JsonResponse
{
    $credentials = $request->only([\'email\', \'password\']);

    if (!auth()->attempt($credentials)) {
        return JsonResponse::error(\'Invalid credentials\', 401);
    }

    $user = auth()->user();

    // Generate JWT token
    $token = jwt()->encode([
        \'user_id\' => $user->id,
        \'email\' => $user->email,
        \'role\' => $user->role,
    ], 3600); // 1 hour expiration

    return JsonResponse::success([
        \'token\' => $token,
        \'user\' => $user->toArray(),
        \'expires_in\' => 3600,
    ]);
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">API Usage</span>
</h3>

<?= codeTabs([
    ['label' => 'Login', 'lang' => 'bash', 'code' => 'curl -X POST http://localhost/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d \'{"email":"user@example.com","password":"password123"}\''],
    ['label' => 'Use Token', 'lang' => 'bash', 'code' => 'curl http://localhost/api/v1/users \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1Qi..."'],
]) ?>

<!-- Remember Me -->
<h2 id="remember-me" class="heading heading-2">
    <span class="mdi mdi-cookie heading-icon"></span>
    <span class="heading-text">Remember Me Functionality</span>
</h2>

<ol class="list">
    <li>User checks "Remember Me" on login</li>
    <li>Server generates secure 64-character token</li>
    <li>Token stored in database (<code class="code-inline">users.remember_token</code>)</li>
    <li>Token set as HTTP-only cookie (30-day expiration)</li>
    <li>On future visits, token validated and user logged in</li>
</ol>

<?= codeBlock('php', '// Automatic usage
auth()->attempt($credentials, $remember = true);

// Manual validation on each request
if (auth()->guest()) {
    auth()->loginViaRememberToken();
}') ?>

<?= callout('warning', 'Security: Token regenerated on each login, HTTP-only cookie, old tokens invalidated.') ?>

<!-- Auth Middleware -->
<h2 id="middleware" class="heading heading-2">
    <span class="mdi mdi-filter heading-icon"></span>
    <span class="heading-text">Authentication Middleware</span>
</h2>

<?= codeTabs([
    ['label' => 'Auth Middleware', 'lang' => 'php', 'code' => 'class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Try remember me authentication
        if (auth()->guest()) {
            auth()->loginViaRememberToken();
        }

        if (auth()->guest()) {
            session()->put(\'url.intended\', $request->fullUrl());
            return new RedirectResponse(\'/login\');
        }

        return $next($request);
    }
}'],
    ['label' => 'Guest Middleware', 'lang' => 'php', 'code' => 'class GuestMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if (auth()->check()) {
            return new RedirectResponse(\'/dashboard\');
        }

        return $next($request);
    }
}'],
]) ?>

<!-- Password Management -->
<h2 id="password-management" class="heading heading-2">
    <span class="mdi mdi-lock heading-icon"></span>
    <span class="heading-text">Password Management</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Automatic Password Hashing</span>
</h3>

<?= codeBlockWithFile('php', 'class User extends Model
{
    protected array $fillable = [\'name\', \'email\', \'password\'];

    // Automatically hash passwords
    protected function setPasswordAttribute(string $value): void
    {
        $this->attributes[\'password\'] = password_hash($value, PASSWORD_ARGON2ID);
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}', 'app/Models/User.php') ?>

<?= callout('info', 'Argon2ID is the recommended hashing algorithm for passwords. It provides resistance against side-channel and brute-force attacks.') ?>

<!-- Authorization -->
<h2 id="authorization" class="heading heading-2">
    <span class="mdi mdi-account-group heading-icon"></span>
    <span class="heading-text">Authorization & Roles</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">User Model with Roles</span>
</h3>

<?= codeBlock('php', 'class User extends Model
{
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function isAdmin(): bool
    {
        return $this->role === \'admin\';
    }
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Role Middleware</span>
</h3>

<?= codeBlock('php', 'class RoleMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next, string $role = null): Response
    {
        if (!auth()->check()) {
            return JsonResponse::error(\'Authentication required\', 401);
        }

        if ($role && !auth()->user()->hasRole($role)) {
            return JsonResponse::error(\'Insufficient permissions\', 403);
        }

        return $next($request);
    }
}

// Usage in routes
Router::group([\'middleware\' => [\'auth\', \'role:admin\']], function () {
    Router::get(\'/admin/users\', [AdminController::class, \'users\']);
});') ?>

<!-- Security Best Practices -->
<h2 id="security-best-practices" class="heading heading-2">
    <span class="mdi mdi-shield-check heading-icon"></span>
    <span class="heading-text">Security Best Practices</span>
</h2>

<div class="grid grid-2 gap-3">
    <?= callout('success', '<strong>Use HTTPS</strong><br><code class="code-inline">SESSION_SECURE=true</code> in production', null, 'lock') ?>
    <?= callout('success', '<strong>Rate Limiting</strong><br>Limit login attempts to prevent brute force', null, 'speedometer') ?>
    <?= callout('success', '<strong>CSRF Protection</strong><br>Include <code class="code-inline"><?= csrf_field() ?></code> in forms', null, 'shield') ?>
    <?= callout('success', '<strong>Session Regeneration</strong><br>Call <code class="code-inline">session()->regenerate()</code> on login', null, 'refresh') ?>
</div>

<?= codeBlock('php', '// Complete secure login example
public function login(Request $request)
{
    // Rate limiting
    $limiter = app(\'rate.limiter\');
    $key = \'login:\' . $request->ip();

    if ($limiter->tooManyAttempts($key, 5, 60)) {
        return back()->with(\'error\', \'Too many attempts. Try again later.\');
    }

    if (auth()->attempt($request->only([\'email\', \'password\']))) {
        // Regenerate session
        session()->regenerate();

        // Log successful login
        activity()->causedBy(auth()->user())->log(\'User logged in\')->save();

        return redirect()->intended(\'/dashboard\');
    }

    // Increment failed attempts
    $limiter->hit($key, 60);

    return back()->with(\'error\', \'Invalid credentials\');
}') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
