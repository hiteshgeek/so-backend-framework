# Encrypter - AES-256-CBC Encryption

**File:** `core/Security/Encrypter.php`
**Purpose:** Secure encryption and decryption of sensitive data using AES-256-CBC with HMAC validation

---

## Table of Contents
- [Overview](#overview)
- [Configuration](#configuration)
- [Basic Usage](#basic-usage)
- [Advanced Features](#advanced-features)
- [Security Best Practices](#security-best-practices)
- [Use Cases](#use-cases)
- [Troubleshooting](#troubleshooting)

---

## Overview

The SO Framework includes a production-ready Encrypter class that provides:

**Features:**
- ✅ AES-256-CBC encryption (industry standard)
- ✅ HMAC-SHA256 authentication for tamper detection
- ✅ Automatic IV generation for each encryption
- ✅ Base64 encoding for safe storage/transmission
- ✅ Automatic key derivation from APP_KEY
- ✅ Payload integrity validation

**When to Use:**
- Storing sensitive data in database (credit cards, SSNs, API keys)
- Encrypting session payloads (see [SESSION-ENCRYPTION.md](/docs/session-encryption))
- Protecting user PII (Personally Identifiable Information)
- Securing API tokens in cache/database
- GDPR/HIPAA compliance requirements

**Architecture:**
```
┌─────────────────────────────────────────────────────────┐
│               ENCRYPTION FLOW                            │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Plain Text                                              │
│      │                                                   │
│      ▼                                                   │
│  Generate IV (random 16 bytes)                           │
│      │                                                   │
│      ▼                                                   │
│  AES-256-CBC Encrypt (key + IV)                          │
│      │                                                   │
│      ▼                                                   │
│  HMAC-SHA256 Sign (key + ciphertext + IV)                │
│      │                                                   │
│      ▼                                                   │
│  JSON Payload {iv, value, mac}                           │
│      │                                                   │
│      ▼                                                   │
│  Base64 Encode                                           │
│      │                                                   │
│      ▼                                                   │
│  Encrypted String (safe for storage)                     │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## Configuration

### 1. Generate Encryption Key

The Encrypter requires a 32-byte (256-bit) encryption key. Generate one using:

```bash
php artisan key:generate
```

**Output:**
```
Application key [base64:xyz...] set successfully.
```

**What it does:**
1. Generates a cryptographically secure random 32-byte key
2. Base64 encodes it
3. Writes it to `.env` file as `APP_KEY`

### 2. Environment Configuration

**.env:**
```env
# Encryption Key (NEVER commit this to Git!)
APP_KEY=base64:abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGH==

# Application Environment
APP_ENV=production
APP_DEBUG=false
```

**⚠️ SECURITY WARNING:**
- **NEVER** commit `.env` to version control
- **NEVER** share APP_KEY publicly
- **ROTATE** keys after security incidents
- **USE** different keys per environment (dev, staging, production)

### 3. Configuration File

**config/app.php:**
```php
<?php

return [
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC', // Default cipher
];
```

---

## Basic Usage

### 1. Encrypting Data

**Example: Encrypt sensitive user data**

```php
<?php

use Core\Security\Encrypter;

// Get encrypter instance
$encrypter = new Encrypter(config('app.key'));

// Encrypt string
$plainText = 'Sensitive data: Credit Card 1234-5678-9012-3456';
$encrypted = $encrypter->encrypt($plainText);

// Result: Encrypted, base64-encoded string
// Example: "eyJpdiI6IjJRV0h..."
echo $encrypted;
```

### 2. Decrypting Data

**Example: Decrypt encrypted data**

```php
<?php

use Core\Security\Encrypter;

$encrypter = new Encrypter(config('app.key'));

// Decrypt
$decrypted = $encrypter->decrypt($encrypted);

echo $decrypted; // "Sensitive data: Credit Card 1234-5678-9012-3456"
```

### 3. Handling Decryption Failures

**Example: Safe decryption with exception handling**

```php
<?php

use Core\Security\Encrypter;

$encrypter = new Encrypter(config('app.key'));

try {
    $decrypted = $encrypter->decrypt($tampered Data);
} catch (\Exception $e) {
    // Decryption failed (tampered data, wrong key, corrupted payload)
    logger()->error('Decryption failed: ' . $e->getMessage());
    $decrypted = null;
}

if ($decrypted === null) {
    // Handle failure (return error, use default value, etc.)
    abort(403, 'Invalid or tampered data');
}
```

---

## Advanced Features

### 1. Encrypting Arrays and Objects

**Example: Encrypt structured data**

```php
<?php

$encrypter = new Encrypter(config('app.key'));

// Encrypt array
$userData = [
    'ssn' => '123-45-6789',
    'credit_card' => '1234-5678-9012-3456',
    'api_key' => 'sk_live_abc123'
];

$encrypted = $encrypter->encrypt(json_encode($userData));

// Store in database
$db->insert('sensitive_data', [
    'user_id' => $userId,
    'encrypted_payload' => $encrypted
]);

// Later: Decrypt and decode
$row = $db->select('sensitive_data')->where('user_id', $userId)->first();
$decrypted = $encrypter->decrypt($row['encrypted_payload']);
$userData = json_decode($decrypted, true);
```

### 2. Model Attribute Encryption

**Example: Automatically encrypt/decrypt model attributes**

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Security\Encrypter;

class User extends Model
{
    protected static string $table = 'users';

    protected array $fillable = [
        'name', 'email', 'ssn_encrypted', 'credit_card_encrypted'
    ];

    /**
     * Set SSN (encrypt before storing)
     */
    public function setSsn(string $ssn): void
    {
        $encrypter = new Encrypter(config('app.key'));
        $this->ssn_encrypted = $encrypter->encrypt($ssn);
    }

    /**
     * Get SSN (decrypt when retrieving)
     */
    public function getSsn(): ?string
    {
        if (empty($this->ssn_encrypted)) {
            return null;
        }

        $encrypter = new Encrypter(config('app.key'));
        try {
            return $encrypter->decrypt($this->ssn_encrypted);
        } catch (\Exception $e) {
            logger()->error('Failed to decrypt SSN for user ' . $this->id);
            return null;
        }
    }
}

// Usage
$user = User::find(1);
$user->setSsn('123-45-6789');
$user->save();

// Later
$ssn = $user->getSsn(); // "123-45-6789"
```

### 3. Cache Encryption

**Example: Encrypt sensitive cache values**

```php
<?php

use Core\Security\Encrypter;

$encrypter = new Encrypter(config('app.key'));

// Encrypt before caching
$apiToken = 'sk_live_abc123xyz';
$encrypted = $encrypter->encrypt($apiToken);
cache()->put('user_' . $userId . '_api_token', $encrypted, 3600);

// Decrypt when retrieving
$encrypted = cache()->get('user_' . $userId . '_api_token');
$apiToken = $encrypter->decrypt($encrypted);
```

### 4. Session Payload Encryption

**Example: Encrypt entire session payloads**

See [SESSION-ENCRYPTION.md](/docs/session-encryption) for complete guide on encrypting session data.

```php
<?php

// In SessionServiceProvider.php

$encrypter = new Encrypter(config('app.key'));
$session = new Session($config, $encrypter); // Pass encrypter to enable encryption
```

---

## Security Best Practices

### 1. Key Management

**✅ DO:**
- Generate strong keys with `php artisan key:generate`
- Store keys in environment variables (`.env`)
- Use different keys per environment (dev, staging, production)
- Rotate keys after security incidents
- Back up keys securely (encrypted password manager)

**❌ DON'T:**
- Hardcode keys in source code
- Commit `.env` to Git
- Share keys via email/chat
- Reuse keys across applications
- Use weak or guessable keys

### 2. Key Rotation Strategy

**When to rotate:**
- After a security breach
- Periodically (every 90-180 days for high-security apps)
- When an employee with key access leaves
- After suspected key exposure

**How to rotate:**

```php
<?php

/**
 * Key Rotation Script
 *
 * 1. Generate new key: php artisan key:generate --show
 * 2. Run this script to re-encrypt all data
 */

use Core\Security\Encrypter;

$oldKey = 'base64:OLD_KEY_HERE';
$newKey = config('app.key'); // New key from .env

$oldEncrypter = new Encrypter($oldKey);
$newEncrypter = new Encrypter($newKey);

// Re-encrypt all sensitive data
$users = User::all();
foreach ($users as $user) {
    if (!empty($user->ssn_encrypted)) {
        try {
            // Decrypt with old key
            $plainText = $oldEncrypter->decrypt($user->ssn_encrypted);

            // Re-encrypt with new key
            $user->ssn_encrypted = $newEncrypter->encrypt($plainText);
            $user->save();

            echo "✓ Re-encrypted user {$user->id}\n";
        } catch (\Exception $e) {
            echo "✗ Failed to re-encrypt user {$user->id}: {$e->getMessage()}\n";
        }
    }
}

echo "Key rotation complete!\n";
```

### 3. NEVER Encrypt These

**Don't encrypt:**
- Usernames (needed for login lookups)
- Email addresses (needed for uniqueness checks, password resets)
- Hashed passwords (already secure, encryption adds no value)
- Non-sensitive data (performance overhead)
- Foreign keys (breaks database relationships)

**Instead:**
- Use hashing for passwords (`password_hash()`)
- Use HTTPS for transmission security
- Encrypt only PII and sensitive data

### 4. Compliance Guidelines

**GDPR (EU):**
- Encrypt all PII (names, addresses, IDs)
- Implement "right to be forgotten" (decrypt → delete)
- Log all encryption/decryption operations

**HIPAA (Healthcare):**
- Encrypt all PHI (Protected Health Information)
- Use AES-256 or stronger
- Maintain encryption key audit logs

**PCI DSS (Payment Cards):**
- Encrypt credit card numbers (PAN)
- Never store CVV/CV2 (even encrypted)
- Implement key rotation every 12 months

---

## Use Cases

### Use Case 1: Storing API Credentials

**Problem:** Need to store third-party API keys securely in database

**Solution:**

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Security\Encrypter;

class Integration extends Model
{
    protected static string $table = 'integrations';

    protected array $fillable = ['name', 'api_key_encrypted'];

    public function setApiKey(string $apiKey): void
    {
        $encrypter = new Encrypter(config('app.key'));
        $this->api_key_encrypted = $encrypter->encrypt($apiKey);
    }

    public function getApiKey(): ?string
    {
        $encrypter = new Encrypter(config('app.key'));
        return $encrypter->decrypt($this->api_key_encrypted);
    }
}

// Usage
$stripe = Integration::create(['name' => 'Stripe']);
$stripe->setApiKey('sk_live_abc123xyz');
$stripe->save();

// Later: Use API key
$apiKey = $stripe->getApiKey();
$stripeClient = new \Stripe\StripeClient($apiKey);
```

### Use Case 2: Encrypted JWT Tokens

**Problem:** Store refresh tokens securely in cache/database

**Solution:**

```php
<?php

use Core\Security\JWT;
use Core\Security\Encrypter;

$jwt = JWT::fromConfig();
$encrypter = new Encrypter(config('app.key'));

// Generate refresh token
$refreshToken = $jwt->encode(['user_id' => $userId, 'type' => 'refresh']);

// Encrypt before storing
$encrypted = $encrypter->encrypt($refreshToken);
cache()->put('refresh_token_' . $userId, $encrypted, 86400 * 30); // 30 days

// Later: Decrypt and verify
$encrypted = cache()->get('refresh_token_' . $userId);
$refreshToken = $encrypter->decrypt($encrypted);
$payload = $jwt->decode($refreshToken);
```

### Use Case 3: Encrypted File Storage

**Problem:** Upload sensitive documents that must be encrypted at rest

**Solution:**

```php
<?php

use Core\Security\Encrypter;

class DocumentController
{
    public function upload(Request $request)
    {
        $file = $request->file('document');
        $encrypter = new Encrypter(config('app.key'));

        // Read file contents
        $plainText = file_get_contents($file->getPathname());

        // Encrypt
        $encrypted = $encrypter->encrypt($plainText);

        // Store encrypted version
        $filename = 'encrypted_' . uniqid() . '.enc';
        file_put_contents(storage_path('documents/' . $filename), $encrypted);

        // Save metadata to database
        Document::create([
            'user_id' => auth()->id(),
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
        ]);

        return json(['message' => 'Document encrypted and stored']);
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        $encrypter = new Encrypter(config('app.key'));

        // Read encrypted file
        $encrypted = file_get_contents(storage_path('documents/' . $document->filename));

        // Decrypt
        $plainText = $encrypter->decrypt($encrypted);

        // Return decrypted file
        return response($plainText, 200, [
            'Content-Type' => $document->mime_type,
            'Content-Disposition' => 'attachment; filename="' . $document->original_name . '"'
        ]);
    }
}
```

---

## Troubleshooting

### Error: "The only supported ciphers are AES-128-CBC and AES-256-CBC"

**Cause:** Unsupported cipher in `config/app.php`

**Solution:**
```php
// config/app.php
return [
    'cipher' => 'AES-256-CBC', // Must be AES-128-CBC or AES-256-CBC
];
```

### Error: "The payload is invalid"

**Causes:**
1. Data was tampered with (HMAC verification failed)
2. Wrong decryption key used
3. Corrupted data in storage

**Solution:**
```php
try {
    $decrypted = $encrypter->decrypt($encrypted);
} catch (\Exception $e) {
    // Log error
    logger()->error('Decryption failed: ' . $e->getMessage(), [
        'encrypted' => substr($encrypted, 0, 50) . '...',
        'user_id' => auth()->id()
    ]);

    // Handle gracefully
    return json(['error' => 'Data integrity check failed'], 403);
}
```

### Error: "The MAC is invalid"

**Cause:** HMAC authentication failed (data tampered with)

**Solution:**
This is a **security feature** - the data has been modified. Do NOT proceed.

```php
// Log the incident
logger()->warning('HMAC verification failed - possible tampering', [
    'user_id' => auth()->id(),
    'ip' => request()->ip(),
    'encrypted_data' => substr($encrypted, 0, 100)
]);

// Reject the request
abort(403, 'Data integrity verification failed');
```

### Performance Issues

**Problem:** Encryption/decryption is slow for large datasets

**Solutions:**

1. **Encrypt only sensitive fields** (not entire records)
   ```php
   // ❌ DON'T: Encrypt entire user record
   $encrypted = $encrypter->encrypt(json_encode($user));

   // ✅ DO: Encrypt only sensitive fields
   $user->ssn_encrypted = $encrypter->encrypt($user->ssn);
   ```

2. **Use caching** for frequently accessed encrypted data
   ```php
   $cacheKey = 'decrypted_api_key_' . $integrationId;
   $apiKey = cache()->remember($cacheKey, 3600, function() use ($integration, $encrypter) {
       return $encrypter->decrypt($integration->api_key_encrypted);
   });
   ```

3. **Batch operations** for key rotation
   ```php
   // Process in chunks
   User::chunk(100, function($users) use ($oldEncrypter, $newEncrypter) {
       foreach ($users as $user) {
           // Re-encrypt
       }
   });
   ```

---

## See Also

- **[SESSION-ENCRYPTION.md](/docs/session-encryption)** - Session payload encryption
- **[SECURITY-LAYER.md](/docs/security-layer)** - Complete security overview
- **[API-AUTH.md](/docs/dev-api-auth)** - JWT token encryption
- **[GDPR Compliance Guide]** - Data protection regulations
- **[Key Management Best Practices]** - Industry standards

---

**Version:** 2.0.0
**Last Updated:** 2026-02-01
**Tested:** Production-ready, AES-256-CBC with HMAC-SHA256
