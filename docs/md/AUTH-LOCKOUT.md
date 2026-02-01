# Auth Account Lockout

## Overview

The SO Backend Framework includes **automatic account lockout protection** to prevent brute force attacks on user accounts. After a configurable number of failed login attempts, the system temporarily locks out the account, preventing further login attempts from the same IP address and email combination.

## Features

- **Brute Force Protection** - Locks accounts after too many failed login attempts
- **IP + Email Tracking** - Tracks attempts per unique IP/email combination
- **Configurable Thresholds** - Customize max attempts and lockout duration
- **Automatic Expiry** - Lockout automatically expires after decay period
- **Success Reset** - Successful login clears all failed attempts
- **Cache-Based** - Fast lookups with minimal database overhead
- **Case Insensitive** - Email addresses normalized (user@example.com = USER@EXAMPLE.COM)

## How It Works

### Failed Login Tracking

1. User attempts to login with email and password
2. System generates throttle key: `sha1(ip_address|email)`
3. If credentials are invalid:
   - Increment failed attempt counter in cache
   - Store with TTL = decay_minutes
4. If max_attempts reached:
   - Throw `AuthenticationException` with 429 status code
   - User sees "Too many login attempts. Please try again in X minutes."

### Successful Login Reset

When a user successfully logs in:
- All failed attempt counters for that IP/email combination are cleared
- User can immediately use the account normally

### Lockout Expiry

Lockouts automatically expire after the configured decay period:
- Failed attempts stored in cache with TTL
- After TTL expires, cache entries deleted automatically
- User can attempt login again

## Setup

### Step 1: Ensure Cache is Configured

The auth lockout system requires cache to be working. Verify your cache configuration:

```bash
# Check cache driver in .env
CACHE_DRIVER=database  # or file, redis, memcached
```

### Step 2: Configure Lockout Settings

Add to your `.env` file:

```ini
# Enable auth account lockout (default: true)
AUTH_THROTTLE_ENABLED=true

# Max failed attempts before lockout (default: 5)
AUTH_THROTTLE_MAX_ATTEMPTS=5

# Lockout duration in minutes (default: 15)
AUTH_THROTTLE_DECAY_MINUTES=15
```

### Step 3: Restart Application

Restart your web server or PHP-FPM to apply the changes:

```bash
sudo systemctl restart php8.2-fpm
# OR
sudo systemctl restart apache2
```

## Verification

### Test Lockout is Working

```bash
# Run auth lockout tests
php sixorbit test auth-lockout
```

Expected output:
```
ALL TESTS PASSED

Auth Account Lockout Status:
- LoginThrottle: Attempt tracking working
- Lockout: Account locks after max attempts
- Clear: Successful login clears attempts
- Separation: Different IP/email combinations tracked separately
- Auth Integration: LoginThrottle wired into Auth class

Production Ready: YES
```

### Manual Testing

Try logging in with incorrect credentials multiple times:

```php
use Core\Auth\Auth;

$auth = app('auth');

// Attempt 1-4: Should fail but allow retry
try {
    $auth->attempt(['email' => 'user@example.com', 'password' => 'wrong']);
} catch (\Core\Exceptions\AuthenticationException $e) {
    echo $e->getMessage(); // "Invalid credentials"
}

// Attempt 5: Should lock out
try {
    $auth->attempt(['email' => 'user@example.com', 'password' => 'wrong']);
} catch (\Core\Exceptions\AuthenticationException $e) {
    echo $e->getMessage(); // "Too many login attempts. Please try again in 15 minutes."
    echo $e->getCode();    // 429 (Too Many Requests)
}
```

## Usage

The lockout system works transparently with the existing Auth class:

```php
use Core\Auth\Auth;

$auth = app('auth');

try {
    // Standard login attempt - lockout handled automatically
    $success = $auth->attempt([
        'email' => $request->input('email'),
        'password' => $request->input('password')
    ], $remember = true);

    if ($success) {
        // Login successful - failed attempts cleared
        redirect('/dashboard');
    } else {
        // Invalid credentials - attempt counter incremented
        redirect('/login')->withError('Invalid credentials');
    }

} catch (\Core\Exceptions\AuthenticationException $e) {
    // Account locked (429 status code)
    if ($e->getCode() === 429) {
        redirect('/login')->withError($e->getMessage());
    }
}
```

### Controller Example

```php
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember');

        try {
            $auth = app('auth');

            if ($auth->attempt(compact('email', 'password'), $remember)) {
                return redirect('/dashboard');
            }

            // Invalid credentials
            return back()->withError('Invalid email or password');

        } catch (\Core\Exceptions\AuthenticationException $e) {
            // Account locked (too many attempts)
            return back()->withError($e->getMessage());
        }
    }
}
```

## Configuration Options

| Setting | Environment Variable | Default | Description |
|---------|---------------------|---------|-------------|
| Enabled | `AUTH_THROTTLE_ENABLED` | `true` | Enable/disable lockout protection |
| Max Attempts | `AUTH_THROTTLE_MAX_ATTEMPTS` | `5` | Failed attempts before lockout |
| Decay Minutes | `AUTH_THROTTLE_DECAY_MINUTES` | `15` | Lockout duration in minutes |

### Recommended Settings

**High Security (Banking, Healthcare)**
```ini
AUTH_THROTTLE_ENABLED=true
AUTH_THROTTLE_MAX_ATTEMPTS=3
AUTH_THROTTLE_DECAY_MINUTES=30
```

**Balanced (E-commerce, SaaS)**
```ini
AUTH_THROTTLE_ENABLED=true
AUTH_THROTTLE_MAX_ATTEMPTS=5
AUTH_THROTTLE_DECAY_MINUTES=15
```

**Lenient (Internal Tools)**
```ini
AUTH_THROTTLE_ENABLED=true
AUTH_THROTTLE_MAX_ATTEMPTS=10
AUTH_THROTTLE_DECAY_MINUTES=5
```

## Security Considerations

### Protection Against

**Brute Force Attacks** - Limits password guessing attempts
**Credential Stuffing** - Slows down automated attacks
**Distributed Attacks** - Each IP tracked separately
**Account Enumeration** - Same error message for valid/invalid emails

### Tracking Method

The system tracks attempts by **IP + Email combination**:

```
Throttle Key = sha1(ip_address|lowercase_email)

Examples:
- 192.168.1.1 + user@example.com = Key A
- 192.168.1.1 + admin@example.com = Key B (different email)
- 192.168.1.2 + user@example.com = Key C (different IP)
```

This means:
- Same user from different IPs: tracked separately
- Different users from same IP: tracked separately
- Same user, same IP: tracked together

### Bypass Scenarios

The lockout can be bypassed in these cases:
- **Distributed attack from multiple IPs** - Each IP has separate counter
- **Mitigation:** Use rate limiting middleware for IP-based protection

### Performance Impact

Auth lockout adds minimal overhead:
- **Check lockout:** ~0.1ms (cache lookup)
- **Record attempt:** ~0.2ms (cache write)
- **Total:** <1ms per login attempt

## Troubleshooting

### Lockout Not Working

**Check configuration:**
```bash
php -r "
require 'vendor/autoload.php';
require 'bootstrap/app.php';
\$config = config('auth.login_throttle');
echo 'Enabled: ' . (\$config['enabled'] ? 'Yes' : 'No') . PHP_EOL;
echo 'Max Attempts: ' . \$config['max_attempts'] . PHP_EOL;
echo 'Decay Minutes: ' . \$config['decay_minutes'] . PHP_EOL;
"
```

**Check cache is working:**
```bash
php sixorbit test cache
```

### User Locked Out Permanently

**Cause:** Cache TTL not expiring properly

**Solution:** Clear cache manually
```php
use Core\Auth\LoginThrottle;

$cache = app('cache');
$throttle = new LoginThrottle($cache, config('auth.login_throttle'));

$ip = '192.168.1.100'; // User's IP
$email = 'user@example.com';

$key = LoginThrottle::key($ip, $email);
$throttle->clear($key);

echo "Lockout cleared for {$email} from {$ip}\n";
```

### Legitimate User Locked Out

**Scenario:** User forgot password, tried multiple times

**Solution 1:** Wait for decay period (15 minutes by default)

**Solution 2:** Admin clears lockout manually
```bash
php -r "
require 'vendor/autoload.php';
require 'bootstrap/app.php';

\$cache = app('cache');
\$throttle = new \Core\Auth\LoginThrottle(\$cache, config('auth.login_throttle'));

\$ip = '192.168.1.100';
\$email = 'user@example.com';
\$key = \Core\Auth\LoginThrottle::key(\$ip, \$email);

\$throttle->clear(\$key);
echo 'Lockout cleared\n';
"
```

**Solution 3:** Implement "Forgot Password" flow
- Bypasses login lockout
- Sends password reset email
- User creates new password

## Advanced Usage

### Check Lockout Status Programmatically

```php
use Core\Auth\LoginThrottle;

$cache = app('cache');
$throttle = new LoginThrottle($cache, config('auth.login_throttle'));

$ip = $_SERVER['REMOTE_ADDR'];
$email = 'user@example.com';

$key = LoginThrottle::key($ip, $email);

// Check if locked out
if ($throttle->tooManyAttempts($key)) {
    $seconds = $throttle->lockoutSeconds($key);
    $minutes = ceil($seconds / 60);
    echo "Account locked for {$minutes} more minutes\n";
}

// Get attempt info
$attempts = $throttle->attempts($key);
$remaining = $throttle->attemptsLeft($key);
echo "Attempts: {$attempts}/{$throttle->getMaxAttempts()}\n";
echo "Remaining: {$remaining}\n";
```

### Custom Throttle Logic

```php
use Core\Auth\LoginThrottle;

class CustomLoginController
{
    protected LoginThrottle $throttle;

    public function __construct()
    {
        $cache = app('cache');
        $config = [
            'enabled' => true,
            'max_attempts' => 3,  // More strict
            'decay_minutes' => 60, // Longer lockout
        ];

        $this->throttle = new LoginThrottle($cache, $config);
    }

    public function login($email, $password)
    {
        $key = LoginThrottle::key($_SERVER['REMOTE_ADDR'], $email);

        // Show attempts remaining
        if ($this->throttle->isAvailable()) {
            $remaining = $this->throttle->attemptsLeft($key);
            if ($remaining < 3) {
                echo "Warning: {$remaining} attempts remaining\n";
            }
        }

        // ... rest of login logic
    }
}
```

### Disable for Testing

For automated tests or development:

```ini
# .env.testing
AUTH_THROTTLE_ENABLED=false
```

Or programmatically:

```php
// In test setup
config()->set('auth.login_throttle.enabled', false);
```

## Implementation Details

### Files

| File | Purpose |
|------|---------|
| `core/Auth/LoginThrottle.php` | Core throttle logic (attempt tracking, lockout detection) |
| `core/Auth/Auth.php` | Integration point (checks lockout in `attempt()` method) |
| `core/Exceptions/AuthenticationException.php` | Exception with `accountLocked()` factory method |
| `config/auth.php` | Configuration for throttle settings |
| `bootstrap/app.php` | Service registration (injects throttle into Auth) |

### Cache Keys

Throttle data stored in cache with these keys:

```
login_throttle:{sha1_hash}
```

Example:
```
login_throttle:a94a8fe5ccb19ba61c4c0873d391e987982fbbd3
```

### Throttle Key Generation

```php
public static function key(string $ip, string $username): string
{
    return 'login_throttle:' . sha1(
        $ip . '|' . mb_strtolower($username)
    );
}
```

### Cache Data Structure

```php
[
    'attempts' => 3,                    // Number of failed attempts
    'expires_at' => 1706800000,         // Unix timestamp when lockout expires
]
```

## Testing

Run the complete auth lockout test suite:

```bash
# Run auth lockout tests
php tests/Integration/security/auth-lockout.test.php

# Run all security tests (includes auth lockout)
php sixorbit test security

# Run all tests
php sixorbit test
```

## References

- [OWASP Authentication Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html)
- [CWE-307: Improper Restriction of Excessive Authentication Attempts](https://cwe.mitre.org/data/definitions/307.html)
- [NIST SP 800-63B: Digital Identity Guidelines](https://pages.nist.gov/800-63-3/sp800-63b.html)

---

**Framework Version:** 2.0
**Last Updated:** 2026-01-31
**Status:** Production Ready
