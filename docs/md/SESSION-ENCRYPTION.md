# Session Encryption

## Overview

The SO Backend Framework supports **optional session payload encryption** with AES-256-CBC and HMAC-SHA256 tamper detection. When enabled, all session data is encrypted before being stored in the database, protecting sensitive information at rest.

## Features

- **AES-256-CBC Encryption** - Industry-standard encryption algorithm
- **HMAC-SHA256 Authentication** - Detects tampering attempts
- **Encrypt-then-MAC** - Secure composition pattern
- **Automatic Tamper Detection** - Sessions are destroyed if HMAC verification fails
- **Configurable** - Enable/disable via environment variables
- **Zero Code Changes** - Works transparently with existing session usage

## How It Works

### Encryption Process (Write)

1. Session data is serialized by PHP
2. Data is encrypted with AES-256-CBC using a random IV
3. HMAC-SHA256 is computed over IV + ciphertext
4. JSON envelope `{iv, value, mac}` is base64-encoded
5. Encrypted payload is stored in database

### Decryption Process (Read)

1. Encrypted payload is retrieved from database
2. Base64-decoded to extract `{iv, value, mac}`
3. HMAC is verified (if mismatch, session destroyed)
4. Ciphertext is decrypted with AES-256-CBC
5. Decrypted data is returned to PHP

### Tamper Detection

If the HMAC verification fails (indicating the session was tampered with), the framework automatically:
- Destroys the compromised session
- Returns an empty session (forces fresh session creation)
- Logs the tamper attempt (if logging is enabled)

## Setup

### Prerequisites

- PHP with OpenSSL extension (enabled by default)
- Database session storage configured
- App encryption key configured

### Step 1: Generate Encryption Key

Generate a secure 32-byte encryption key:

```bash
# Generate random 32-byte key
php -r "echo 'APP_KEY=base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

### Step 2: Configure Environment

Add to your `.env` file:

```ini
# Application encryption key (required for session encryption)
APP_KEY=base64:YourBase64EncodedKeyHere==

# Enable session encryption
SESSION_ENCRYPT=true

# Session driver must be 'database'
SESSION_DRIVER=database
```

### Step 3: Restart Application

Restart your web server or PHP-FPM to apply the changes:

```bash
sudo systemctl restart php8.2-fpm
# OR
sudo systemctl restart apache2
```

## Verification

### Test Encryption is Working

```bash
# Run session encryption tests
php sixorbit test session-encryption
```

Expected output:
```
ALL TESTS PASSED

Session Encryption Status:
- Encrypter: AES-256-CBC working
- HMAC: SHA256 tamper detection working
- Session Handler: Encryption/decryption working
- Key Validation: Minimum length enforced
- Tamper Detection: HMAC verification working
```

### Check Database

With encryption enabled, session payloads in the database will look like:

```
eyJpdiI6IkFCQ0QxMjM0Li4uIiwidmFsdWUiOiJlbmNyeXB0ZWRkYXRhIiwibWFjIjoiYWJjZDEyMzQifQ==
```

Without encryption, they look like:

```
user_id|i:123;username|s:4:"john";
```

## Usage

Session encryption works **transparently** - no code changes required:

```php
// Works the same with or without encryption
$_SESSION['user_id'] = 123;
$_SESSION['sensitive_data'] = 'secret information';

// Read session data
$userId = $_SESSION['user_id'];
```

Using the Session facade:

```php
use Core\Http\Session;

$session = app('session');

// Store data (automatically encrypted if enabled)
$session->set('api_token', 'secret-token');

// Retrieve data (automatically decrypted)
$token = $session->get('api_token');
```

## Security Considerations

### When to Enable

**Enable session encryption if:**
- You store sensitive user data in sessions (PII, financial data)
- Compliance requirements mandate encryption at rest (GDPR, HIPAA)
- You have admin/elevated privilege sessions
- Sessions contain API keys or access tokens

**You can skip encryption if:**
- Sessions only contain non-sensitive data (user ID, preferences)
- Performance is critical and sessions are already protected by DB access controls
- You're in a trusted environment with encrypted database volumes

### Performance Impact

Session encryption adds minimal overhead:
- **Encryption:** ~0.1-0.3ms per session write
- **Decryption:** ~0.1-0.3ms per session read
- **Total:** Negligible for most applications (<1ms per request)

### Key Management

**Important Security Practices:**

1. **Never commit APP_KEY to version control**
   - Add `.env` to `.gitignore`
   - Store keys in secure environment variables or secret managers

2. **Use different keys per environment**
   ```ini
   # Production
   APP_KEY=base64:ProductionKeyHere==

   # Staging
   APP_KEY=base64:StagingKeyHere==

   # Development
   APP_KEY=base64:DevelopmentKeyHere==
   ```

3. **Key rotation** (advanced)
   - Generate new key
   - Keep old key temporarily for existing sessions
   - Gradually migrate sessions to new key
   - Remove old key after session lifetime expires

## Troubleshooting

### "APP_KEY not set" Error

**Problem:** Missing or invalid `APP_KEY` in `.env`

**Solution:**
```bash
# Generate new key
php -r "echo 'APP_KEY=base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"

# Add to .env
echo "APP_KEY=base64:YourGeneratedKeyHere==" >> .env
```

### Sessions Not Encrypting

**Check configuration:**
```bash
php -r "
require 'vendor/autoload.php';
require 'bootstrap/app.php';
echo 'Session Encrypt: ' . config('session.encrypt', 'false') . PHP_EOL;
echo 'Session Driver: ' . config('session.driver') . PHP_EOL;
echo 'APP_KEY Set: ' . (config('app.key') ? 'Yes' : 'No') . PHP_EOL;
"
```

### Existing Sessions Not Working After Enabling Encryption

**Cause:** Old unencrypted sessions can't be decrypted

**Solution:** Clear existing sessions:
```sql
-- Clear all sessions (users will need to re-login)
TRUNCATE TABLE sessions;
```

Or update session IDs:
```php
// Force all users to get new encrypted sessions on next login
session_regenerate_id(true);
```

## Testing

Run the complete session encryption test suite:

```bash
# Run session encryption tests
php tests/Integration/infrastructure/session-encryption.test.php

# Run all infrastructure tests (includes session encryption)
php sixorbit test infrastructure

# Run all tests
php sixorbit test
```

## Implementation Details

### Files

| File | Purpose |
|------|---------|
| `core/Security/Encrypter.php` | AES-256-CBC + HMAC-SHA256 implementation |
| `core/Session/DatabaseSessionHandler.php` | Session handler with encryption support |
| `app/Providers/SessionServiceProvider.php` | Wires up encryption to session handler |
| `config/session.php` | Session configuration including `encrypt` flag |

### Payload Format

Encrypted payloads use a JSON envelope:

```json
{
  "iv": "<base64-encoded-initialization-vector>",
  "value": "<base64-encoded-ciphertext>",
  "mac": "<hex-hmac-sha256-signature>"
}
```

The entire envelope is then base64-encoded for storage.

### Encryption Algorithm Details

- **Cipher:** `aes-256-cbc`
- **Key Length:** 32 bytes (256 bits)
- **IV Length:** 16 bytes (automatically generated per encryption)
- **MAC Algorithm:** `HMAC-SHA256`
- **Mode:** Encrypt-then-MAC (industry best practice)

## References

- [OWASP Session Management Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html)
- [NIST SP 800-38A (AES Modes)](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
- [RFC 2104 (HMAC)](https://www.rfc-editor.org/rfc/rfc2104)

---

**Framework Version:** 2.0
**Last Updated:** 2026-01-31
**Status:** Production Ready
