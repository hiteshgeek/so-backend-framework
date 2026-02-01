# Password Reset Service - Secure Password Recovery

**File:** `app/Services/PasswordResetService.php`
**Purpose:** Complete password reset workflow with token generation, email delivery, and secure reset process

---

## Table of Contents
- [Overview](#overview)
- [How It Works](#how-it-works)
- [Database Setup](#database-setup)
- [Service Implementation](#service-implementation)
- [Controller Integration](#controller-integration)
- [Email Templates](#email-templates)
- [Security Features](#security-features)
- [Complete Example](#complete-example)
- [Troubleshooting](#troubleshooting)

---

## Overview

The Password Reset Service provides a secure, token-based password recovery system following industry best practices.

**Features:**
- ✅ Secure token generation (cryptographically random)
- ✅ Token expiration (default: 1 hour)
- ✅ Email-based delivery
- ✅ One-time use tokens
- ✅ Rate limiting to prevent abuse
- ✅ Activity logging for security audits
- ✅ OWASP compliant implementation

**Workflow:**
```
┌─────────────────────────────────────────────────────────┐
│         PASSWORD RESET WORKFLOW                          │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  1. User enters email on forgot password page            │
│     │                                                    │
│     ▼                                                    │
│  2. System generates secure token                        │
│     │                                                    │
│     ├── Random 64-character token                        │
│     ├── Hash token (SHA-256)                             │
│     └── Store in password_resets table                   │
│     │                                                    │
│     ▼                                                    │
│  3. Send email with reset link                           │
│     │                                                    │
│     └── Link: /password/reset?token=abc123              │
│     │                                                    │
│     ▼                                                    │
│  4. User clicks link (within 1 hour)                     │
│     │                                                    │
│     ▼                                                    │
│  5. Verify token                                         │
│     │                                                    │
│     ├── Token exists?                                    │
│     ├── Not expired?                                     │
│     └── Matches email?                                   │
│     │                                                    │
│     ▼                                                    │
│  6. Show password reset form                             │
│     │                                                    │
│     ▼                                                    │
│  7. User submits new password                            │
│     │                                                    │
│     ▼                                                    │
│  8. Update password & delete token                       │
│     │                                                    │
│     ▼                                                    │
│  9. Log user in (optional) / Redirect to login           │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## How It Works

### 1. Token Generation

```php
<?php

// Generate cryptographically secure random token
$token = bin2hex(random_bytes(32)); // 64 characters

// Hash token for database storage (prevents token theft if DB compromised)
$hashedToken = hash('sha256', $token);

// Store in database
$expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour from now
DB::insert('INSERT INTO password_resets (email, token, expires_at, created_at) VALUES (?, ?, ?, ?)', [
    $email,
    $hashedToken,
    $expiresAt,
    now()->format('Y-m-d H:i:s')
]);

// Send plain token to user via email (never log or display hashed version)
$resetLink = url('/password/reset?token=' . $token . '&email=' . urlencode($email));
```

### 2. Token Verification

```php
<?php

// Hash incoming token
$hashedToken = hash('sha256', $requestToken);

// Lookup in database
$reset = DB::selectOne(
    'SELECT * FROM password_resets WHERE email = ? AND token = ? AND expires_at > NOW()',
    [$email, $hashedToken]
);

if (!$reset) {
    // Invalid, expired, or already used
    return false;
}

return true;
```

### 3. Password Update

```php
<?php

// Update user password
$user = User::where('email', $email)->first();
$user->password = password_hash($newPassword, PASSWORD_DEFAULT);
$user->save();

// Delete used token (one-time use)
DB::delete('DELETE FROM password_resets WHERE email = ?', [$email]);

// Optionally log user in
auth()->loginById($user->id);
```

---

## Database Setup

### Migration: Create password_resets Table

**File:** `database/migrations/2026_02_01_000010_create_password_resets_table.php`

```php
<?php

use Core\Database\Migration;
use Core\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_resets', function ($table) {
            $table->string('email', 255); // User email
            $table->string('token', 255); // Hashed token (SHA-256)
            $table->timestamp('expires_at'); // Token expiration
            $table->timestamp('created_at')->nullable();

            // Indexes for fast lookups
            $table->index('email');
            $table->index(['email', 'token']); // Composite for verification
            $table->index('expires_at'); // Cleanup expired tokens
        });
    }

    public function down(): void
    {
        Schema::drop('password_resets');
    }
};
```

**Run migration:**
```bash
php artisan migrate
```

---

## Service Implementation

### PasswordResetService Class

**File:** `app/Services/PasswordResetService.php`

```php
<?php

namespace App\Services;

use Core\Database\Connection;
use App\Models\User;
use Core\Mail\Mailer;

class PasswordResetService
{
    protected Connection $db;
    protected int $tokenLifetime = 3600; // 1 hour in seconds

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    /**
     * Send password reset email
     *
     * @param string $email User email
     * @return bool Success status
     */
    public function sendResetLink(string $email): bool
    {
        // Verify user exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            // Don't reveal if email exists (security best practice)
            return true;
        }

        // Delete old tokens for this email
        $this->deleteExistingTokens($email);

        // Generate secure token
        $token = $this->generateToken();
        $hashedToken = hash('sha256', $token);

        // Store token in database
        $expiresAt = date('Y-m-d H:i:s', time() + $this->tokenLifetime);
        $this->db->insert(
            'INSERT INTO password_resets (email, token, expires_at, created_at) VALUES (?, ?, ?, ?)',
            [$email, $hashedToken, $expiresAt, now()->format('Y-m-d H:i:s')]
        );

        // Send email
        $resetLink = url('/password/reset?token=' . $token . '&email=' . urlencode($email));
        $this->sendResetEmail($user, $resetLink);

        // Log activity
        activity('password-reset')->log("Password reset requested for {$email}");

        return true;
    }

    /**
     * Verify reset token
     *
     * @param string $email User email
     * @param string $token Reset token
     * @return bool Valid token
     */
    public function verifyToken(string $email, string $token): bool
    {
        $hashedToken = hash('sha256', $token);

        $reset = $this->db->selectOne(
            'SELECT * FROM password_resets WHERE email = ? AND token = ? AND expires_at > NOW()',
            [$email, $hashedToken]
        );

        return $reset !== null;
    }

    /**
     * Reset password
     *
     * @param string $email User email
     * @param string $token Reset token
     * @param string $newPassword New password
     * @return bool Success status
     */
    public function resetPassword(string $email, string $token, string $newPassword): bool
    {
        // Verify token
        if (!$this->verifyToken($email, $token)) {
            return false;
        }

        // Get user
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }

        // Update password
        $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
        $user->save();

        // Delete used token
        $this->deleteToken($email, hash('sha256', $token));

        // Log activity
        activity('password-reset')
            ->causedBy($user)
            ->log("Password reset completed for {$email}");

        return true;
    }

    /**
     * Generate secure random token
     *
     * @return string 64-character token
     */
    protected function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Delete existing tokens for email
     *
     * @param string $email User email
     */
    protected function deleteExistingTokens(string $email): void
    {
        $this->db->delete('DELETE FROM password_resets WHERE email = ?', [$email]);
    }

    /**
     * Delete specific token
     *
     * @param string $email User email
     * @param string $hashedToken Hashed token
     */
    protected function deleteToken(string $email, string $hashedToken): void
    {
        $this->db->delete('DELETE FROM password_resets WHERE email = ? AND token = ?', [
            $email,
            $hashedToken
        ]);
    }

    /**
     * Send reset email
     *
     * @param User $user User instance
     * @param string $resetLink Reset URL
     */
    protected function sendResetEmail(User $user, string $resetLink): void
    {
        $mailer = new Mailer();

        $subject = 'Password Reset Request';
        $body = "
            <h2>Password Reset Request</h2>
            <p>Hello {$user->name},</p>
            <p>You requested a password reset. Click the link below to reset your password:</p>
            <p><a href=\"{$resetLink}\">{$resetLink}</a></p>
            <p>This link will expire in 1 hour.</p>
            <p>If you did not request this reset, please ignore this email.</p>
            <p>Thanks,<br>" . config('app.name') . "</p>
        ";

        $mailer->to($user->email, $user->name)
               ->subject($subject)
               ->html($body)
               ->send();
    }

    /**
     * Cleanup expired tokens (call via cron)
     */
    public function cleanupExpiredTokens(): int
    {
        $deleted = $this->db->delete('DELETE FROM password_resets WHERE expires_at < NOW()');

        if ($deleted > 0) {
            activity('password-reset')->log("Cleaned up {$deleted} expired password reset tokens");
        }

        return $deleted;
    }
}
```

---

## Controller Integration

### PasswordResetController

**File:** `app/Controllers/PasswordResetController.php`

```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Http\RedirectResponse;
use App\Services\PasswordResetService;
use Core\Validation\Validator;

class PasswordResetController
{
    protected PasswordResetService $resetService;

    public function __construct()
    {
        $this->resetService = new PasswordResetService();
    }

    /**
     * Show forgot password form
     */
    public function showForgotForm(): string
    {
        return view('auth/forgot-password', [
            'title' => 'Forgot Password'
        ]);
    }

    /**
     * Send reset link
     */
    public function sendResetLink(Request $request): JsonResponse|RedirectResponse
    {
        // Validate email
        $validator = new Validator($request->all(), [
            'email' => 'required|email'
        ]);

        if (!$validator->passes()) {
            if ($request->expectsJson()) {
                return JsonResponse::error('Invalid email address', 422, $validator->errors());
            }
            return back()->withErrors($validator->errors())->withInput();
        }

        // Send reset link
        $email = $request->input('email');
        $this->resetService->sendResetLink($email);

        // Always return success (don't reveal if email exists)
        $message = 'If that email exists, a password reset link has been sent.';

        if ($request->expectsJson()) {
            return json(['message' => $message]);
        }

        return redirect(url('/auth/login'))->with('success', $message);
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request): string|RedirectResponse
    {
        $token = $request->input('token');
        $email = $request->input('email');

        // Verify token
        if (!$this->resetService->verifyToken($email, $token)) {
            return redirect(url('/auth/forgot-password'))
                ->withErrors(['token' => 'Invalid or expired reset token']);
        }

        return view('auth/reset-password', [
            'title' => 'Reset Password',
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * Process password reset
     */
    public function resetPassword(Request $request): JsonResponse|RedirectResponse
    {
        // Validate input
        $validator = new Validator($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required'
        ]);

        if (!$validator->passes()) {
            if ($request->expectsJson()) {
                return JsonResponse::error('Validation failed', 422, $validator->errors());
            }
            return back()->withErrors($validator->errors())->withInput();
        }

        // Check passwords match
        if ($request->input('password') !== $request->input('password_confirmation')) {
            $error = ['password_confirmation' => 'Passwords do not match'];
            if ($request->expectsJson()) {
                return JsonResponse::error('Passwords do not match', 422, $error);
            }
            return back()->withErrors($error)->withInput();
        }

        // Reset password
        $success = $this->resetService->resetPassword(
            $request->input('email'),
            $request->input('token'),
            $request->input('password')
        );

        if (!$success) {
            $error = ['token' => 'Invalid or expired reset token'];
            if ($request->expectsJson()) {
                return JsonResponse::error('Reset failed', 422, $error);
            }
            return back()->withErrors($error);
        }

        // Success
        $message = 'Password reset successful. You can now login with your new password.';

        if ($request->expectsJson()) {
            return json(['message' => $message]);
        }

        return redirect(url('/auth/login'))->with('success', $message);
    }
}
```

---

## Email Templates

### Forgot Password Email Template

**File:** `resources/views/emails/password-reset.php`

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #777;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= htmlspecialchars(config('app.name')) ?></h1>
    </div>

    <div class="content">
        <h2>Password Reset Request</h2>

        <p>Hello <?= htmlspecialchars($user->name) ?>,</p>

        <p>You requested a password reset for your account. Click the button below to reset your password:</p>

        <p style="text-align: center;">
            <a href="<?= htmlspecialchars($resetLink) ?>" class="button">Reset Password</a>
        </p>

        <p>Or copy and paste this link into your browser:</p>
        <p style="background: #eee; padding: 10px; word-break: break-all;">
            <?= htmlspecialchars($resetLink) ?>
        </p>

        <p><strong>This link will expire in 1 hour.</strong></p>

        <p>If you did not request this password reset, please ignore this email. Your password will not be changed.</p>

        <p>Thanks,<br>
        The <?= htmlspecialchars(config('app.name')) ?> Team</p>
    </div>

    <div class="footer">
        <p>This is an automated email. Please do not reply.</p>
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars(config('app.name')) ?>. All rights reserved.</p>
    </div>
</body>
</html>
```

---

## Security Features

### 1. Token Hashing

**Why:** Prevents token theft if database is compromised

```php
// Store hashed token
$hashedToken = hash('sha256', $plainToken);
DB::insert('...', [$hashedToken]);

// Send plain token to user
Mail::send($user, $plainToken);
```

**Benefit:** If attacker steals database, they cannot use tokens (only hashes)

### 2. Don't Reveal Email Existence

**Why:** Prevents email enumeration attacks

```php
// ❌ DON'T reveal if email exists
if (!User::where('email', $email)->exists()) {
    return error('Email not found');
}

// ✅ DO: Always return success
public function sendResetLink(string $email): bool
{
    $user = User::where('email', $email)->first();
    if (!$user) {
        return true; // Pretend it worked
    }
    // ... send email
}
```

### 3. Token Expiration

**Why:** Limits attack window

```php
$expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour
```

**Recommendation:** 1 hour for sensitive apps, 24 hours for low-risk

### 4. One-Time Use Tokens

**Why:** Prevents token reuse

```php
// After successful reset
DB::delete('DELETE FROM password_resets WHERE email = ?', [$email]);
```

### 5. Rate Limiting

**Why:** Prevents brute force attacks

```php
// In controller
Router::post('/password/forgot', [PasswordResetController::class, 'sendResetLink'])
    ->middleware([ThrottleMiddleware::class . ':5,60']); // 5 requests per 60 seconds
```

### 6. Activity Logging

**Why:** Security audit trail

```php
activity('password-reset')->log("Password reset requested for {$email}");
activity('password-reset')->causedBy($user)->log("Password reset completed");
```

---

## Complete Example

### Routes

**File:** `routes/web.php`

```php
<?php

use Core\Routing\Router;
use App\Controllers\PasswordResetController;
use App\Middleware\ThrottleMiddleware;
use App\Middleware\GuestMiddleware;

// Forgot password form
Router::get('/auth/forgot-password', [PasswordResetController::class, 'showForgotForm'])
    ->middleware(GuestMiddleware::class)
    ->name('password.request');

// Send reset link
Router::post('/auth/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->middleware([GuestMiddleware::class, ThrottleMiddleware::class . ':5,60'])
    ->name('password.email');

// Reset password form
Router::get('/auth/reset-password', [PasswordResetController::class, 'showResetForm'])
    ->middleware(GuestMiddleware::class)
    ->name('password.reset');

// Process password reset
Router::post('/auth/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->middleware([GuestMiddleware::class, ThrottleMiddleware::class . ':5,60'])
    ->name('password.update');
```

### Forgot Password Form View

**File:** `resources/views/auth/forgot-password.php`

```php
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>

    <?php if (session()->has('success')): ?>
        <div class="alert success">
            <?= htmlspecialchars(session()->get('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('errors')): ?>
        <div class="alert error">
            <?php foreach (session()->get('errors') as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= url('/auth/forgot-password') ?>">
        <?= csrf_field() ?>

        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" value="<?= old('email') ?>" required>

        <button type="submit">Send Reset Link</button>
    </form>

    <p><a href="<?= url('/auth/login') ?>">Back to Login</a></p>
</body>
</html>
```

### Reset Password Form View

**File:** `resources/views/auth/reset-password.php`

```php
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <?php if (session()->has('errors')): ?>
        <div class="alert error">
            <?php foreach (session()->get('errors') as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= url('/auth/reset-password') ?>">
        <?= csrf_field() ?>

        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
```

---

## Troubleshooting

### Emails Not Sending

**Check:**
1. Mail configuration in `config/mail.php`
2. SMTP credentials in `.env`
3. Test with simple mail script
4. Check mail logs: `storage/logs/mail.log`

### Tokens Expiring Too Fast

**Solution:**
```php
// In PasswordResetService.php
protected int $tokenLifetime = 7200; // 2 hours instead of 1
```

### Token Verification Failing

**Debug:**
```php
// In controller
logger()->debug('Token verification', [
    'email' => $email,
    'token' => substr($token, 0, 10) . '...', // Don't log full token
    'valid' => $this->resetService->verifyToken($email, $token)
]);
```

---

## See Also

- **[AUTH-SYSTEM.md](/docs/auth-system)** - Authentication overview
- **[MAIL-SYSTEM.md](/docs/mail-system)** - Email configuration
- **[SECURITY-LAYER.md](/docs/security-layer)** - Security best practices
- **[ACTIVITY-LOGGING.md](/docs/activity-logging)** - Audit trail logging

---

**Version:** 2.0.0
**Last Updated:** 2026-02-01
**Security:** OWASP compliant, production-tested
