# Security Hardening TODO

**Date:** 2026-01-31
**Status:** 1 Critical + 6 Medium Priority Items
**Priority:** Address before production deployment

---

## 🚨 CRITICAL - Must Fix Before Production

### 1. Insecure Direct Object Reference (IDOR) in UserApiController

**File:** `app/Controllers/UserApiController.php`
**Lines:** 74-142 (show, update, destroy methods)

**Issue:**
No authorization checks - any authenticated user can view, modify, or delete ANY other user's data.

**Attack Scenario:**
```bash
# User A (ID 10) can access User B (ID 1)
GET /api/users/1        # View admin's data
PUT /api/users/1        # Modify admin's email
DELETE /api/users/1     # Delete admin account
```

**Solution Options:**

**Option A: Self-Access Only** (Recommended for most apps)
```php
public function show(Request $request, int $id): JsonResponse
{
    // Users can only view their own data
    if (auth()->user()->id !== $id) {
        return JsonResponse::error('Forbidden', 403);
    }

    $user = User::find($id);
    // ... rest of code
}
```

**Option B: Role-Based Access Control**
```php
public function show(Request $request, int $id): JsonResponse
{
    // Admins can see all, users only themselves
    if (!auth()->user()->isAdmin() && auth()->user()->id !== $id) {
        return JsonResponse::error('Forbidden', 403);
    }

    $user = User::find($id);
    // ... rest of code
}
```

**Option C: Admin-Only API**
- Add `AdminMiddleware` to route group
- Document that this API is admin-only
- Create separate endpoints for user self-service

**Affected Methods:**
- `show($id)` - Line 74
- `update($id)` - Line 99
- `destroy($id)` - Line 146

**Impact:** **HIGH** - Complete privacy breach, unauthorized data modification

---

## ⚠️ MEDIUM PRIORITY - Hardening Improvements

### 2. Open Redirect Vulnerability

**File:** `core/Support/Helpers.php` (redirect helper)

**Issue:**
The `redirect()` function accepts any URL without validation, allowing attackers to redirect users to malicious sites.

**Attack Scenario:**
```php
// Attacker sends: https://yoursite.com/redirect?url=https://evil.com
redirect($request->input('url'));  // User redirected to evil.com
```

**Solution:**
```php
function redirect(string $url, int $status = 302): \Core\Http\RedirectResponse
{
    // Whitelist internal URLs or validate domain
    $parsedUrl = parse_url($url);
    $allowedHosts = [config('app.url'), $_SERVER['HTTP_HOST']];

    if (isset($parsedUrl['host']) && !in_array($parsedUrl['host'], $allowedHosts)) {
        throw new \InvalidArgumentException('External redirects not allowed');
    }

    return new \Core\Http\RedirectResponse($url, $status);
}
```

---

### 3. Session Cookie Security Flags

**File:** `config/session.php`

**Current State:**
```php
'secure' => env('SESSION_SECURE_COOKIE', false),  // ⚠️ Defaults to false
// 'httponly' => true,  // ⚠️ Not explicitly set
```

**Required Changes:**
```php
'secure' => env('SESSION_SECURE_COOKIE', true),   // ✅ HTTPS-only in production
'httponly' => true,                                // ✅ Prevent XSS cookie theft
'samesite' => 'lax',                              // ✅ CSRF protection
```

**Environment:**
```bash
# .env for production
SESSION_SECURE_COOKIE=true
```

**Impact:** Prevents session hijacking via XSS and man-in-the-middle attacks

---

### 4. Database Error Information Disclosure

**File:** `core/Database/Connection.php`

**Issue:**
Database errors expose full exception messages which may reveal schema details.

**Current Code (Line ~30):**
```php
} catch (PDOException $e) {
    throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
}
```

**Recommended Fix:**
```php
} catch (PDOException $e) {
    // Log full error for debugging
    logger()->error('Database connection failed', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);

    // Show generic message in production
    if (config('app.debug')) {
        throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
    } else {
        throw new \RuntimeException('Database connection failed. Please check logs.');
    }
}
```

**Apply to:**
- Connection errors
- Query execution errors
- Transaction errors

---

### 5. X-Forwarded-For Header Trust

**Files:** Rate limiting and LoginThrottle may trust proxy headers

**Issue:**
Attackers can spoof `X-Forwarded-For` header to bypass rate limiting.

**Current Risk:**
```php
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
```

**Recommended Approach:**
```php
/**
 * Get real client IP, validating proxy headers
 */
function getClientIp(): string
{
    $trustedProxies = config('app.trusted_proxies', []);

    // If behind trusted proxy, check X-Forwarded-For
    if (in_array($_SERVER['REMOTE_ADDR'], $trustedProxies)) {
        $forwardedFor = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
        $ips = array_map('trim', explode(',', $forwardedFor));
        return $ips[0] ?? $_SERVER['REMOTE_ADDR'];
    }

    // Direct connection or untrusted proxy
    return $_SERVER['REMOTE_ADDR'];
}
```

**Config Addition:**
```php
// config/app.php
'trusted_proxies' => env('TRUSTED_PROXIES', ''),
```

---

### 6. User Self-Deletion Protection

**File:** `app/Controllers/UserApiController.php`
**Method:** `destroy()`

**Issue:**
Users can delete their own accounts, which may be unintended.

**Current Code:**
```php
public function destroy(Request $request, int $id): JsonResponse
{
    $user = User::find($id);
    $user->delete();  // ⚠️ Users can delete themselves
}
```

**Recommended Fix:**
```php
public function destroy(Request $request, int $id): JsonResponse
{
    // Prevent self-deletion
    if (auth()->user()->id === $id) {
        return JsonResponse::error('Cannot delete your own account', 403);
    }

    $user = User::find($id);
    // ... rest of code
}
```

---

### 7. Password Reset Token Timing Attack

**File:** `app/Controllers/PasswordApiController.php`

**Current Status:** ✅ Tokens are hashed with SHA256 before storage (secure)

**Verification Needed:**
Ensure token comparison uses constant-time comparison:

```php
// Check if using hash_equals (timing-safe)
$reset = app('db')->table('password_resets')
    ->where('token', '=', hash('sha256', $token))  // ✅ Good
    ->first();
```

**If direct comparison exists:**
```php
// ❌ Vulnerable to timing attacks
if ($storedToken === $providedToken)

// ✅ Timing-safe
if (hash_equals($storedToken, $providedToken))
```

---

## ✅ ALREADY FIXED (During Audit)

### ✓ Mass Assignment Vulnerability - PATCHED
**File:** `app/Models/User.php`
**Fix:** Removed `id`, `remember_token`, timestamps from `$fillable`
**Date:** 2026-01-31

### ✓ LoginThrottle Bug - PATCHED
**File:** `core/Auth/LoginThrottle.php`
**Fix:** Changed `isAvailable()` from protected to public
**Date:** 2026-01-31

---

## 📋 Implementation Checklist

Before production deployment:

- [ ] **Fix IDOR in UserApiController** (choose Option A, B, or C)
- [ ] **Add redirect URL validation**
- [ ] **Set httponly=true in session config**
- [ ] **Set secure=true for production (HTTPS)**
- [ ] **Add database error sanitization in production mode**
- [ ] **Implement trusted proxy validation for X-Forwarded-For**
- [ ] **Add self-deletion protection**
- [ ] **Verify password reset uses timing-safe comparison**

**Recommended Order:**
1. IDOR fix (Critical)
2. Session cookie flags (5 min)
3. Self-deletion protection (2 min)
4. Database error sanitization (10 min)
5. Redirect validation (15 min)
6. Proxy IP validation (20 min)

---

## 🔒 Security Testing After Fixes

Run these tests after implementing fixes:

```bash
# 1. Test IDOR protection
curl -X GET http://localhost/api/users/1 -H "Authorization: Bearer <user2_token>"
# Expected: 403 Forbidden

# 2. Test session cookies have proper flags
curl -I http://localhost/login
# Expected: Set-Cookie with HttpOnly and Secure flags

# 3. Test self-deletion prevention
curl -X DELETE http://localhost/api/users/<own_id> -H "Authorization: Bearer <token>"
# Expected: 403 Forbidden

# 4. Test open redirect prevention
curl -X POST http://localhost/redirect?url=https://evil.com
# Expected: Error or redirect to safe URL only
```

---

## 📚 References

- OWASP Top 10: https://owasp.org/www-project-top-ten/
- OWASP IDOR: https://owasp.org/www-project-web-security-testing-guide/latest/4-Web_Application_Security_Testing/05-Authorization_Testing/04-Testing_for_Insecure_Direct_Object_References
- Session Security: https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html

---

**Audit Completed By:** Claude Code
**Audit Date:** 2026-01-31
**Framework Version:** 1.0 (Production Ready with fixes)
