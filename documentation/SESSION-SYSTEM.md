# Session System

**Database Sessions for Horizontal Scaling**

The Session System provides database-backed session storage enabling horizontal scaling across multiple servers with load balancers. Essential for production ERP deployments with high availability requirements.

---

## Table of Contents

1. [Introduction](#introduction)
2. [Quick Start](#quick-start)
3. [Architecture](#architecture)
4. [Session Operations](#session-operations)
5. [Session Security](#session-security)
6. [Configuration](#configuration)
7. [ERP Use Cases](#erp-use-cases)
8. [Best Practices](#best-practices)

---

## Introduction

### What are Database Sessions?

Database sessions store session data in the `sessions` table instead of files:
- **Shared storage** - All servers access the same session database
- **No session affinity** - Users can hit any server
- **Tracking** - Monitor active users, IP addresses, user agents
- **Force logout** - Invalidate sessions from database

### Why Database Sessions for ERP?

**Horizontal Scaling**:
- [X] **File sessions**: Tied to single server (session affinity required)
- [x] **Database sessions**: Shared across all servers (no affinity needed)

**Security & Monitoring**:
- Track active sessions in real-time
- Monitor user activity (WHO, WHEN, WHERE)
- Force logout from all devices
- Detect suspicious activity (multiple IPs)

**High Availability**:
- Server restart doesn't lose sessions
- Load balancer can route to any server
- No session replication needed

---

## Quick Start

### Step 1: Enable Database Sessions

Already configured in `.env`:

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_COOKIE=so_session
```

### Step 2: Use Sessions

**Sessions work exactly the same** - no code changes needed:

```php
// Store data
session()->put('user_id', 42);
session()->put('cart', ['item1', 'item2']);

// Retrieve data
$userId = session()->get('user_id');
$cart = session()->get('cart', []);

// Check existence
if (session()->has('user_id')) {
    // User is logged in
}

// Remove data
session()->forget('temp_data');

// Clear all
session()->flush();
```

### Step 3: Monitor Active Sessions

```sql
-- View active sessions
SELECT id, user_id, ip_address, user_agent, last_activity
FROM sessions
WHERE last_activity > UNIX_TIMESTAMP() - 7200
ORDER BY last_activity DESC;
```

That's it! Your sessions are now database-backed and scalable.

---

## Architecture

### Components

**1. DatabaseSessionHandler** (`core/Session/DatabaseSessionHandler.php`)
- Implements PHP's `SessionHandlerInterface`
- Stores sessions in `sessions` table
- Tracks user_id, IP address, user agent

**2. SessionServiceProvider** (`app/Providers/SessionServiceProvider.php`)
- Registers database session handler
- Configures cookie parameters
- Sets session name

**3. Session Configuration** (`config/session.php`)
- Driver, lifetime, cookie settings
- Security options (secure, httponly, samesite)

### Database Schema

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

**Columns**:
- `id` - Session identifier (cookie value)
- `user_id` - Authenticated user (NULL if guest)
- `ip_address` - Client IP (IPv4/IPv6)
- `user_agent` - Browser/device information
- `payload` - Serialized session data
- `last_activity` - Unix timestamp of last activity

---

## Session Operations

### Store Data

```php
// Single value
session()->put('username', 'john_doe');

// Array
session()->put('preferences', [
    'theme' => 'dark',
    'language' => 'en'
]);

// Nested
session()->put('cart.items', ['product1', 'product2']);
session()->put('cart.total', 150.00);
```

### Retrieve Data

```php
// Get value
$username = session()->get('username');

// Get with default
$theme = session()->get('preferences.theme', 'light');

// Get all
$all = session()->all();
```

### Check Existence

```php
if (session()->has('user_id')) {
    // Authenticated
    $userId = session()->get('user_id');
}
```

### Flash Data

**Temporary data** (available for next request only):

```php
// Store flash data
session()->flash('message', 'Profile updated successfully!');

// Redirect
return Response::redirect('/profile');

// Next page
$message = session()->get('message'); // "Profile updated successfully!"
// Third page
$message = session()->get('message'); // null (expired)
```

### Remove Data

```php
// Remove single item
session()->forget('temp_data');

// Remove multiple
session()->forget(['key1', 'key2']);

// Clear all (keep session ID)
session()->flush();
```

### Regenerate ID

**Prevent session fixation**:

```php
// After login
public function login(Request $request)
{
    $user = authenticate($request);

    // Regenerate session ID (security)
    session()->regenerate();

    // Store user info
    session()->put('user_id', $user->id);
    session()->put('user_name', $user->name);

    return Response::redirect('/dashboard');
}
```

---

## Session Security

### Secure Cookie Parameters

Configured in `config/session.php`:

```php
return [
    // HTTPS only (production)
    'secure' => env('SESSION_SECURE_COOKIE', false),

    // JavaScript cannot access (XSS protection)
    'http_only' => true,

    // CSRF protection
    'same_site' => 'lax',  // or 'strict'

    // Cookie name
    'cookie' => env('SESSION_COOKIE', 'so_session'),

    // Session lifetime (minutes)
    'lifetime' => env('SESSION_LIFETIME', 120),
];
```

### Session Hijacking Prevention

**1. Regenerate after login**:
```php
session()->regenerate();
```

**2. Validate IP address** (optional, strict):
```php
// Store IP on login
session()->put('ip_address', $request->ip());

// Validate on each request
if (session()->get('ip_address') !== $request->ip()) {
    // Suspicious activity - force logout
    session()->flush();
    return Response::redirect('/login');
}
```

**3. Validate User Agent** (optional, loose):
```php
session()->put('user_agent', $request->userAgent());

if (session()->get('user_agent') !== $request->userAgent()) {
    // Log suspicious activity
    logger()->warning('User agent mismatch', [
        'user_id' => session()->get('user_id'),
        'ip' => $request->ip()
    ]);
}
```

### Force Logout from All Devices

```php
// Security breach or password change
public function forceLogoutAllDevices($userId)
{
    // Delete all sessions for user
    DB::table('sessions')->where('user_id', $userId)->delete();

    // User must login again on all devices
}
```

### Session Timeout

**Automatic expiration** after inactivity:

```php
// config/session.php
'lifetime' => 120,  // 120 minutes (2 hours)

// Expired sessions removed by garbage collection
php artisan session:cleanup
```

---

## Configuration

### config/session.php

```php
<?php

return [
    // Session driver
    'driver' => env('SESSION_DRIVER', 'database'),

    // Session lifetime (minutes)
    'lifetime' => env('SESSION_LIFETIME', 120),

    // Sessions table
    'table' => 'sessions',

    // Garbage collection probability [chance, total]
    // [2, 100] = 2% chance on each request
    'lottery' => [2, 100],

    // Cookie configuration
    'cookie' => env('SESSION_COOKIE', 'so_session'),
    'secure' => env('SESSION_SECURE_COOKIE', false),
    'http_only' => true,
    'same_site' => 'lax',
];
```

### Environment Variables

```env
# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_COOKIE=so_session
SESSION_SECURE_COOKIE=true  # HTTPS only
```

### Cookie Security Levels

**Strict** (most secure, may break some functionality):
```php
'same_site' => 'strict',
```

**Lax** (balanced, recommended):
```php
'same_site' => 'lax',
```

**None** (least secure, requires HTTPS):
```php
'same_site' => 'none',
'secure' => true,  // Required with 'none'
```

---

## ERP Use Cases

### 1. Multi-Server Deployment

**Architecture**:
```
+-------------+
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
              +-------------+
```

**Benefits**:
- User can hit any server (no session affinity)
- Easy to add/remove servers
- Rolling deployments without session loss

### 2. Active User Monitoring

```php
// Real-time active users
function getActiveUsers($minutes = 15)
{
    $cutoff = time() - ($minutes * 60);

    $sessions = DB::table('sessions')
        ->where('last_activity', '>=', $cutoff)
        ->whereNotNull('user_id')
        ->get();

    $activeUsers = [];
    foreach ($sessions as $session) {
        $activeUsers[] = [
            'user_id' => $session['user_id'],
            'ip' => $session['ip_address'],
            'last_seen' => date('Y-m-d H:i:s', $session['last_activity'])
        ];
    }

    return $activeUsers;
}

// Count concurrent users
$count = DB::table('sessions')
    ->where('last_activity', '>=', time() - 900)
    ->whereNotNull('user_id')
    ->distinct('user_id')
    ->count();
```

### 3. Security Audit

```php
// Detect multiple locations
function detectSuspiciousActivity($userId)
{
    $sessions = DB::table('sessions')
        ->where('user_id', $userId)
        ->where('last_activity', '>=', time() - 3600)
        ->get();

    $ips = array_unique(array_column($sessions->toArray(), 'ip_address'));

    if (count($ips) > 1) {
        // Alert: User logged in from multiple IPs
        notifySecurityTeam($userId, $ips);
    }
}
```

### 4. Session Analytics

```php
// Peak usage times
$hourlyStats = DB::select("
    SELECT HOUR(FROM_UNIXTIME(last_activity)) as hour,
           COUNT(DISTINCT user_id) as unique_users,
           COUNT(*) as total_sessions
    FROM sessions
    WHERE last_activity >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 24 HOUR))
    GROUP BY hour
    ORDER BY hour
");

// Average session duration
$avgDuration = DB::select("
    SELECT AVG(last_activity - created_at) as avg_seconds
    FROM sessions
    WHERE created_at >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY))
")[0]['avg_seconds'];
```

### 5. Force Logout (Security)

```php
// Password change: logout all devices
public function changePassword(Request $request)
{
    $user = $request->user();

    // Update password
    $user->update(['password' => bcrypt($request->input('new_password'))]);

    // Get current session ID
    $currentSessionId = session()->getId();

    // Delete ALL sessions except current
    DB::table('sessions')
        ->where('user_id', $user->id)
        ->where('id', '!=', $currentSessionId)
        ->delete();

    return JsonResponse::success([
        'message' => 'Password changed. Logged out from other devices.'
    ]);
}
```

---

## Best Practices

### 1. Set Appropriate Lifetime

```php
// Short-lived (high security)
'lifetime' => 30,  // 30 minutes

// Standard (balanced)
'lifetime' => 120,  // 2 hours

// Long-lived (convenience)
'lifetime' => 480,  // 8 hours
```

### 2. Regular Cleanup

```bash
# Cron job (daily at 2 AM)
0 2 * * * php artisan session:cleanup
```

### 3. Monitor Table Size

```sql
-- Check sessions table
SELECT COUNT(*) as total_sessions,
       SUM(LENGTH(payload)) as total_bytes
FROM sessions;

-- Check old sessions
SELECT COUNT(*) FROM sessions
WHERE last_activity < UNIX_TIMESTAMP() - 7200;
```

### 4. Use HTTPS in Production

```env
SESSION_SECURE_COOKIE=true  # Only send over HTTPS
```

### 5. Limit Session Data

```php
// [X] Bad: Store large objects
session()->put('products', Product::all());  // 10 MB!

// [x] Good: Store IDs only
session()->put('product_ids', [1, 2, 3]);
```

### 6. Regenerate After Privilege Change

```php
// After login or role change
session()->regenerate();
```

---

## Troubleshooting

### Sessions Not Persisting

**1. Check database table**:
```sql
SELECT * FROM sessions LIMIT 10;
```

**2. Verify driver configuration**:
```php
var_dump(config('session.driver')); // Should be 'database'
```

**3. Check cookie settings**:
- Ensure domain matches
- Check HTTPS requirement (secure cookie)
- Verify browser accepts cookies

### Session Data Lost After Deployment

**Solution**: Use rolling deployment:

```bash
# Server 1: Deploy new code
# Server 2: Still serving (old code)
# Load balancer: Routes traffic to Server 2
# Wait for sessions to drain from Server 1
# Switch traffic to Server 1
# Deploy to Server 2
```

### Performance Issues

**Problem**: Large sessions table.

**Solutions**:
1. Regular cleanup: `php artisan session:cleanup`
2. Partition table by last_activity
3. Archive old sessions
4. Reduce session lifetime

---

## Summary

The Session System provides:

[x] **Database storage** - Shared across all servers
[x] **Horizontal scaling** - No session affinity required
[x] **Security tracking** - Monitor WHO, WHEN, WHERE
[x] **Force logout** - Invalidate from database
[x] **High availability** - Server restart doesn't lose sessions

**Essential for ERP deployments**:
- Multi-server load balancing
- Security monitoring and auditing
- Active user tracking
- Session analytics
- Force logout capabilities

**Enable database sessions today for scalable, secure ERP deployments.**

---

**Next Steps**:
- Ensure `SESSION_DRIVER=database` in `.env`
- Set up `session:cleanup` cron job
- Configure secure cookies for production
- Monitor session table size
- Review [FRAMEWORK-FEATURES.md](FRAMEWORK-FEATURES.md) for overview

**Version**: 2.0.0 | **Last Updated**: 2026-01-29
