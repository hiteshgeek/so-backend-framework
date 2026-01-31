# Integrating SO Framework with Existing Tables

This guide explains how to use the SO Framework with your existing database tables instead of creating new ones.

## Overview

If you have an existing application with user and session tables, you **don't need** to create duplicate tables in the essentials database. The framework can be configured to use your existing tables.

## Tables That Are Optional

The following tables in `001_framework_essentials.sql` are **commented out by default** because you may already have them:

1. **users** - If you have `auser` table
2. **sessions** - If you have `auser_session` table
3. **password_resets** - If you handle password resets differently

## Tables That Are Required

These framework tables are **required** and will be created in the `so_essentials` database:

- `cache` / `cache_locks` - Cache system
- `jobs` / `failed_jobs` / `job_batches` - Queue system
- `notifications` - Notification system
- `activity_log` - Activity logging
- `personal_access_tokens` - API tokens
- `migrations` - Migration tracking

## Setup for Existing Projects

### Step 1: Run Only Required Tables

The migration file `001_framework_essentials.sql` already has the optional tables commented out. Just run it as-is:

```bash
# This will create the so_essentials database and tables automatically
mysql -u root -p < database/migrations/001_framework_essentials.sql
```

This will:
- Create `so_essentials` database (if it doesn't exist)
- Create only the 9 required framework tables
- Skip users, sessions, and password_resets (they're commented out)

### Step 2: Configure Your Existing Tables

Your existing tables are already configured in `DatabaseTables.php`:

```php
// Existing User Management Tables
const AUSER = 'auser';
const AUSER_SESSION = 'auser_session';
```

### Step 3: Use Your Existing Tables

#### Query Your Existing User Table

```php
use App\Constants\DatabaseTables;

// Query auser table from your application database
$user = app('db')  // or app('db-staging')
    ->table(DatabaseTables::AUSER)
    ->where('user_id', $userId)
    ->first();
```

#### Query Your Existing Session Table

```php
use App\Constants\DatabaseTables;

// Query auser_session table
$session = app('db')
    ->table(DatabaseTables::AUSER_SESSION)
    ->where('session_id', $sessionId)
    ->first();
```

## Database Connections

### Your Application Database

Use `app('db')` for your main application tables:

```php
app('db')->table(DatabaseTables::AUSER)->get();
app('db')->table(DatabaseTables::AUSER_SESSION)->get();
app('db')->table(DatabaseTables::POSTS)->get();
```

### Staging Database

If you need to access staging/reference tables, use `app('db-staging')`:

```php
// Tables like: rapidkart_factory_static.auser_status
$statuses = app('db-staging')
    ->query('SELECT * FROM rapidkart_factory_static.auser_status')
    ->fetchAll();
```

Or use the full table name with dot notation:

```php
use App\Constants\DatabaseTables;

// DatabaseTables::AUSER_STATUS = 'rapidkart_factory_static.auser_status'
$statuses = app('db-staging')
    ->query('SELECT * FROM ' . DatabaseTables::AUSER_STATUS)
    ->fetchAll();
```

### Essentials Database

Use `app('db-essentials')` for framework tables:

```php
app('db-essentials')->table(DatabaseTables::CACHE)->get();
app('db-essentials')->table(DatabaseTables::JOBS)->get();
app('db-essentials')->table(DatabaseTables::ACTIVITY_LOG)->get();
```

## Custom Auth Integration

If you want to use framework's Auth system with your existing `auser` table, create a custom User model:

### Create Custom User Model

**File: `app/Models/CustomUser.php`**

```php
<?php

namespace App\Models;

use App\Constants\DatabaseTables;

class CustomUser
{
    /**
     * Get user by ID from existing auser table
     */
    public static function find(int $userId): ?array
    {
        return app('db')
            ->table(DatabaseTables::AUSER)
            ->where('user_id', $userId)  // Your column name
            ->first();
    }

    /**
     * Get user by email
     */
    public static function findByEmail(string $email): ?array
    {
        return app('db')
            ->table(DatabaseTables::AUSER)
            ->where('user_email', $email)  // Your column name
            ->first();
    }

    /**
     * Verify password
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        // Adapt to your hashing method
        return password_verify($password, $hash);
    }
}
```

## Custom Session Integration

If you want to use your existing `auser_session` table:

### Create Custom Session Handler

**File: `app/Services/CustomSessionHandler.php`**

```php
<?php

namespace App\Services;

use App\Constants\DatabaseTables;

class CustomSessionHandler implements \SessionHandlerInterface
{
    private $db;

    public function __construct()
    {
        $this->db = app('db');
    }

    public function read(string $id): string|false
    {
        $session = $this->db
            ->table(DatabaseTables::AUSER_SESSION)
            ->where('session_id', $id)
            ->first();

        return $session['session_data'] ?? '';
    }

    public function write(string $id, string $data): bool
    {
        $exists = $this->db
            ->table(DatabaseTables::AUSER_SESSION)
            ->where('session_id', $id)
            ->first();

        if ($exists) {
            return $this->db
                ->table(DatabaseTables::AUSER_SESSION)
                ->where('session_id', $id)
                ->update([
                    'session_data' => $data,
                    'last_activity' => time()
                ]) > 0;
        }

        return $this->db
            ->table(DatabaseTables::AUSER_SESSION)
            ->insert([
                'session_id' => $id,
                'session_data' => $data,
                'last_activity' => time()
            ]) > 0;
    }

    public function destroy(string $id): bool
    {
        return $this->db
            ->table(DatabaseTables::AUSER_SESSION)
            ->where('session_id', $id)
            ->delete() > 0;
    }

    // Implement other SessionHandlerInterface methods...
}
```

### Register Custom Handler

In `bootstrap/app.php`, register your custom session handler:

```php
// Register custom session handler for existing auser_session table
$app->singleton('session.handler', function ($app) {
    return new \App\Services\CustomSessionHandler();
});
```

## Complete Example: User Login

Here's how to implement login using your existing `auser` table:

```php
<?php

namespace App\Controllers;

use App\Constants\DatabaseTables;
use App\Models\CustomUser;

class AuthController
{
    public function login($request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Find user in existing auser table
        $user = app('db')
            ->table(DatabaseTables::AUSER)
            ->where('user_email', $email)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Verify password (adapt to your hashing)
        if (!password_verify($password, $user['user_password'])) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Create session in existing auser_session table
        $sessionId = bin2hex(random_bytes(16));

        app('db')
            ->table(DatabaseTables::AUSER_SESSION)
            ->insert([
                'session_id' => $sessionId,
                'user_id' => $user['user_id'],
                'session_data' => json_encode(['user_id' => $user['user_id']]),
                'last_activity' => time(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

        // Log activity in framework's activity_log (essentials DB)
        app('db-essentials')
            ->table(DatabaseTables::ACTIVITY_LOG)
            ->insert([
                'log_name' => 'auth',
                'description' => 'User logged in',
                'causer_id' => $user['user_id'],
                'created_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'success' => true,
            'session_id' => $sessionId,
            'user' => $user
        ]);
    }
}
```

## Summary

### What You Need in so_essentials Database:
- ✅ cache / cache_locks
- ✅ jobs / failed_jobs / job_batches
- ✅ notifications
- ✅ activity_log
- ✅ personal_access_tokens
- ✅ migrations

### What You Already Have (skip in migration):
- ❌ users → use your `auser` table
- ❌ sessions → use your `auser_session` table
- ❌ password_resets → use your existing password reset system

### Database Connection Map:
- `app('db')` → Your application database (auser, auser_session, etc.)
- `app('db-staging')` → Staging/reference database (static tables)
- `app('db-essentials')` → Framework tables (cache, queue, logs, etc.)

This setup gives you the best of both worlds: framework features without duplicating your existing user/session infrastructure!
