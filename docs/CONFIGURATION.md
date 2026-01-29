# Configuration Guide

## Overview

The framework uses a centralized configuration system where **all names and settings can be changed in one place** (`.env` file) and automatically affect the entire application.

## Quick Configuration

### 1. Framework Name

**Change in one place:** [.env](.env)

```bash
APP_NAME="Your Framework Name"
```

This will automatically update:
- ✅ Page titles
- ✅ Welcome page heading
- ✅ Error pages
- ✅ Logs and debugging output
- ✅ Any place that uses `config('app.name')`

**Usage in code:**
```php
// In PHP
$name = config('app.name');

// In views
<title><?= htmlspecialchars(config('app.name')) ?></title>
<h1><?= e(config('app.name')) ?></h1>
```

### 2. Database Name

**Change in one place:** [.env](.env)

```bash
DB_DATABASE=your-database-name
```

This affects:
- ✅ Database connections
- ✅ Generated SQL setup files
- ✅ All database operations

**After changing, regenerate setup.sql:**
```bash
php database/migrations/generate-setup.php
```

This creates a new `setup.sql` with your configured database name.

### 3. Application URL

```bash
APP_URL=https://yourdomain.com
```

This affects:
- ✅ URL generation via `url()` helper
- ✅ Asset URLs
- ✅ API base URLs
- ✅ Redirects

## Environment Variables Reference

### Application Settings

| Variable | Default | Description |
|----------|---------|-------------|
| `APP_NAME` | "SO Framework" | Framework display name |
| `APP_ENV` | production | Environment (development/production/testing) |
| `APP_DEBUG` | false | Enable debug mode |
| `APP_URL` | http://localhost | Base URL |
| `APP_KEY` | (empty) | Application encryption key |

### Database Settings

| Variable | Default | Description |
|----------|---------|-------------|
| `DB_CONNECTION` | mysql | Database driver (mysql/pgsql) |
| `DB_HOST` | 127.0.0.1 | Database host |
| `DB_PORT` | 3306 | Database port |
| `DB_DATABASE` | so-framework | **Database name** |
| `DB_USERNAME` | root | Database username |
| `DB_PASSWORD` | (empty) | Database password |

### Session Settings

| Variable | Default | Description |
|----------|---------|-------------|
| `SESSION_DRIVER` | file | Session storage driver |
| `SESSION_LIFETIME` | 120 | Session lifetime (minutes) |
| `SESSION_SECURE` | false | HTTPS only |
| `SESSION_HTTPONLY` | true | HTTP only (no JavaScript) |
| `SESSION_SAMESITE` | strict | SameSite cookie attribute |

## Using Configuration in Your Code

### Reading Configuration

```php
// Get app name
$name = config('app.name');

// Get database name
$database = config('database.connections.mysql.database');

// With default value
$timezone = config('app.timezone', 'UTC');

// Check if exists
if (config()->has('app.debug')) {
    // ...
}
```

### Reading Environment Variables Directly

```php
// Direct access
$debug = env('APP_DEBUG', false);

// Via helper
$name = env('APP_NAME');
```

### In Views

```php
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars(config('app.name')) ?></title>
</head>
<body>
    <h1>Welcome to <?= e(config('app.name')) ?></h1>

    <?php if (config('app.debug')): ?>
        <div class="debug-info">Debug Mode Active</div>
    <?php endif; ?>
</body>
</html>
```

### In Controllers

```php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class HomeController
{
    public function index(Request $request): Response
    {
        return Response::view('home', [
            'title' => config('app.name'),
            'version' => app()->version(),
        ]);
    }
}
```

## Configuration Files

The framework loads configuration from `config/` directory:

### [config/app.php](config/app.php)
```php
return [
    'name' => env('APP_NAME', 'Framework'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    // ...
];
```

### [config/database.php](config/database.php)
```php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'host' => env('DB_HOST', '127.0.0.1'),
            'database' => env('DB_DATABASE', 'framework'),
            // ...
        ],
    ],
];
```

## How to Rename Your Framework

### Step 1: Update Environment

Edit [.env](.env):
```bash
APP_NAME="My Awesome Framework"
DB_DATABASE=my-awesome-framework
```

### Step 2: Regenerate Database Setup

```bash
php database/migrations/generate-setup.php
```

This creates `setup.sql` with your new database name.

### Step 3: Update Composer (Optional)

Edit [composer.json](composer.json):
```json
{
    "name": "vendor/my-awesome-framework",
    "description": "Your custom description"
}
```

Then run:
```bash
composer dump-autoload
```

### Step 4: Test Changes

```bash
# Test homepage shows new name
curl http://localhost:8000

# Test API
curl http://localhost:8000/api/test
```

## Dynamic SQL Generation

The framework includes a SQL generator that reads your `.env` configuration:

### Generate setup.sql

```bash
php database/migrations/generate-setup.php
```

This creates `database/migrations/setup.sql` with:
- ✅ Your configured database name
- ✅ Proper character encoding
- ✅ All table definitions
- ✅ Sample data

### Import Generated SQL

```bash
mysql -u root -p < database/migrations/setup.sql
```

## Best Practices

### 1. Never Commit .env

The `.env` file is in `.gitignore` by default. Never commit it to version control.

### 2. Use .env.example

Keep `.env.example` updated with all required variables:

```bash
# Copy for new installations
cp .env.example .env
```

### 3. Use config() in Code

Always use `config()` instead of `env()` in application code:

```php
// ✅ Good - Cached and optimized
$name = config('app.name');

// ❌ Bad - Direct env() in code
$name = env('APP_NAME');
```

### 4. Type Cast Environment Values

Environment variables are always strings. Use proper type casting:

```php
// config/app.php
return [
    'debug' => (bool) env('APP_DEBUG', false),
    'timeout' => (int) env('APP_TIMEOUT', 30),
];
```

### 5. Document Your Variables

Add comments to `.env.example` explaining each variable:

```bash
# Your application name (shown in UI)
APP_NAME="SO Framework"

# Database name (must match generated SQL)
DB_DATABASE=so-framework
```

## Environment-Specific Configuration

### Development (.env)
```bash
APP_ENV=development
APP_DEBUG=true
LOG_LEVEL=debug
```

### Production (.env.production)
```bash
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
SESSION_SECURE=true
```

### Testing (.env.testing)
```bash
APP_ENV=testing
APP_DEBUG=true
DB_DATABASE=framework_test
```

## Helper Functions

The framework provides these helpers for configuration:

```php
// Get configuration value
config('app.name')

// Get environment variable
env('APP_DEBUG')

// Get application instance
app()

// Get from container
app('db')

// Base path
base_path('storage/logs')

// Config path
config_path('database.php')
```

## Summary

✅ **Single Source of Truth**: Change `APP_NAME` in `.env` → affects everywhere

✅ **Dynamic SQL**: Run generator → creates SQL with your database name

✅ **Easy Deployment**: Copy `.env.example` → customize → deploy

✅ **Type Safe**: Configuration files cast types properly

✅ **Fast**: Configuration is cached and optimized

Change the framework name in **one place** (`.env`), and it propagates everywhere automatically! 🎉
