# Password Migration Guide

This guide explains how the framework handles password migration from the legacy system to secure modern hashing.

## Overview

The framework supports a seamless transition from legacy SHA1 passwords to modern Argon2ID hashing, allowing both old and new systems to work simultaneously during migration.

### Password Storage

| Column | Format | Purpose |
|--------|--------|---------|
| `password` | SHA1 (40 chars) | Legacy format for old framework |
| `password_hash` | Argon2ID | Modern secure format |

---

## How It Works

### Authentication Flow

```
┌─────────────────────────────────────────────────────────────┐
│                    User Login Attempt                        │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
              ┌───────────────────────────────┐
              │  password_hash exists and     │
              │  is modern format?            │
              └───────────────────────────────┘
                    │                │
                   YES              NO
                    │                │
                    ▼                ▼
         ┌──────────────┐  ┌──────────────────┐
         │ Verify with  │  │ Verify with      │
         │ password_    │  │ legacy hash      │
         │ verify()     │  │ (SHA1)           │
         └──────────────┘  └──────────────────┘
                │                    │
                │              ┌─────┴─────┐
                │              │ Success?  │
                │              └─────┬─────┘
                │                    │
                │                   YES
                │                    │
                │                    ▼
                │          ┌─────────────────────┐
                │          │ AUTO-UPGRADE:       │
                │          │ Store Argon2ID hash │
                │          │ in password_hash    │
                │          └─────────────────────┘
                │                    │
                └────────┬───────────┘
                         │
                         ▼
                  ┌─────────────┐
                  │   SUCCESS   │
                  └─────────────┘
```

---

## Step 1: Database Setup

Add the new password column to your user table:

```sql
ALTER TABLE auser ADD COLUMN password_hash VARCHAR(255) NULL AFTER password;
```

---

## Step 2: Model Configuration

The User model handles dual password verification automatically:

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Security\LegacyPasswordHasher;

class User extends Model
{
    protected array $fillable = [
        'password',
        'password_hash',  // New secure field
        // ... other fields
    ];

    /**
     * Set password - stores BOTH formats during migration
     */
    protected function setPasswordAttribute(string $value): void
    {
        // Skip if already hashed
        if (LegacyPasswordHasher::isModernHash($value)) {
            $this->attributes['password_hash'] = $value;
            return;
        }

        if (LegacyPasswordHasher::isLegacyHash($value)) {
            $this->attributes['password'] = $value;
            return;
        }

        // Plain text: hash in BOTH formats
        $this->attributes['password'] = LegacyPasswordHasher::hash($value);
        $this->attributes['password_hash'] = password_hash($value, PASSWORD_ARGON2ID);
    }

    /**
     * Verify with automatic upgrade
     */
    public function verifyPassword(string $password): bool
    {
        // Try modern hash first
        if ($this->attributes['password_hash'] ?? null) {
            return password_verify($password, $this->attributes['password_hash']);
        }

        // Fall back to legacy, upgrade on success
        if (LegacyPasswordHasher::verify($password, $this->attributes['password'])) {
            $this->upgradePassword($password);
            return true;
        }

        return false;
    }
}
```

---

## Step 3: Using the LegacyPasswordHasher

The `LegacyPasswordHasher` class handles verification of old passwords:

```php
use Core\Security\LegacyPasswordHasher;

// Check hash format
LegacyPasswordHasher::isLegacyHash($hash);  // SHA1 (40 hex chars)
LegacyPasswordHasher::isModernHash($hash);  // Starts with $2y$ or $argon2

// Verify legacy password
LegacyPasswordHasher::verify($password, $legacyHash);

// Create legacy hash (for compatibility only)
LegacyPasswordHasher::hash($password);
```

---

## Migration Scenarios

### Scenario 1: User Logs In (New Framework)

```php
// User has only legacy password (password_hash is null)
$user = User::findByEmail('user@example.com');

if ($user->verifyPassword('their_password')) {
    // 1. Legacy password verified
    // 2. Auto-upgraded to Argon2ID
    // 3. password_hash now contains modern hash
    // 4. Old framework still works (password column unchanged)
}
```

### Scenario 2: Password Change (New Framework)

```php
$user = User::find(1);
$user->password = 'new_secure_password';
$user->save();

// Both columns updated:
// - password: SHA1 hash (for old framework)
// - password_hash: Argon2ID hash (for new framework)
```

### Scenario 3: User Logs In (Old Framework)

The old framework continues to use the `password` column with SHA1 verification. No changes needed.

### Scenario 4: Post-Migration Cleanup

After all users have migrated (logged in at least once via new framework):

```php
// Check migration status
$unmigrated = DB::query(
    "SELECT COUNT(*) FROM auser WHERE password_hash IS NULL"
)->fetchColumn();

echo "Users pending migration: $unmigrated";
```

---

## Security Comparison

| Aspect | Legacy (SHA1) | Modern (Argon2ID) |
|--------|---------------|-------------------|
| Algorithm | SHA1 | Argon2ID |
| Salt | Static (shared) | Per-password (random) |
| Iterations | 1 | Configurable |
| Memory | None | Memory-hard |
| GPU Resistance | None | High |
| Time to Crack | Hours | Years |

### Why Argon2ID?

1. **Memory-hard**: Resistant to GPU/ASIC attacks
2. **Time-cost**: Configurable iterations
3. **Modern standard**: PHC winner (2015)
4. **PHP native**: `password_hash()` with `PASSWORD_ARGON2ID`

---

## Configuration

### Environment Variables

```env
# Password hashing algorithm (default: argon2id)
PASSWORD_ALGO=argon2id

# Argon2 options (optional, uses PHP defaults)
PASSWORD_MEMORY_COST=65536
PASSWORD_TIME_COST=4
PASSWORD_THREADS=3
```

---

## Monitoring Migration Progress

### SQL Query

```sql
-- Migration status
SELECT
    COUNT(*) as total_users,
    SUM(CASE WHEN password_hash IS NOT NULL THEN 1 ELSE 0 END) as migrated,
    SUM(CASE WHEN password_hash IS NULL THEN 1 ELSE 0 END) as pending
FROM auser
WHERE ustatusid NOT IN (2, 3);  -- Exclude deleted users
```

### Dashboard Widget

```php
public function getMigrationStatus(): array
{
    $result = DB::query("
        SELECT
            COUNT(*) as total,
            SUM(CASE WHEN password_hash IS NOT NULL THEN 1 ELSE 0 END) as migrated
        FROM auser WHERE ustatusid NOT IN (2, 3)
    ")->fetch();

    return [
        'total' => $result['total'],
        'migrated' => $result['migrated'],
        'pending' => $result['total'] - $result['migrated'],
        'percentage' => round(($result['migrated'] / $result['total']) * 100, 1),
    ];
}
```

---

## Post-Migration Steps

Once all users have migrated (100% have `password_hash`):

### 1. Update User Model

```php
// Remove dual-hash storage
protected function setPasswordAttribute(string $value): void
{
    $this->attributes['password_hash'] = password_hash($value, PASSWORD_ARGON2ID);
    // Optionally clear legacy: $this->attributes['password'] = null;
}

// Simplify verification
public function verifyPassword(string $password): bool
{
    return password_verify($password, $this->attributes['password_hash']);
}
```

### 2. Remove Legacy Support

```php
// Delete LegacyPasswordHasher usage from codebase
// Remove the class after all references removed
```

### 3. Database Cleanup (Optional)

```sql
-- After confirming all users migrated
-- ALTER TABLE auser DROP COLUMN password;  -- DANGER: Backup first!
```

---

## Troubleshooting

### User Can't Login

1. Check if `password_hash` is set:
   ```sql
   SELECT email, password, password_hash FROM auser WHERE email = 'user@example.com';
   ```

2. Test legacy verification:
   ```php
   $hash = LegacyPasswordHasher::hash('their_password');
   echo $hash === $user->password ? 'Legacy OK' : 'Legacy FAIL';
   ```

3. Test modern verification:
   ```php
   echo password_verify('their_password', $user->password_hash) ? 'Modern OK' : 'Modern FAIL';
   ```

### Password Not Upgrading

Ensure the `upgradePassword()` method is being called. Check error logs for:
```
Password upgraded to modern hash for user: user@example.com
```

---

## See Also

- [Authentication System](/docs/authentication) - Full auth documentation
- [Security Best Practices](/docs/security) - Security guidelines
- [User Model](/docs/dev-models) - Model configuration
