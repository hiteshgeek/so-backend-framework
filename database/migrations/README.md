# SO Framework - Dual Database Setup

## Overview

The SO Framework uses a **dual database architecture** that separates essential framework tables from your application tables:

1. **`so-essentials`** database - Contains framework-specific tables (users, sessions, cache, queue, etc.)
2. **Your application database** - Contains your custom application tables (posts, products, etc.)

This separation allows you to:
- Use the framework in existing projects without table conflicts
- Keep framework data isolated and portable
- Easily upgrade the framework without affecting your app data
- Share authentication/sessions across multiple applications

---

## Database Structure

### Essentials Database (`so_essentials`)
**Contains 12 essential framework tables:**

| Table | Purpose |
|-------|---------|
| `users` | User authentication |
| `password_resets` | Password reset tokens |
| `sessions` | Database-driven sessions |
| `jobs` | Queue system jobs |
| `failed_jobs` | Failed queue jobs |
| `job_batches` | Batch job tracking |
| `notifications` | Database notifications |
| `activity_log` | Audit trail |
| `cache` | Database cache driver |
| `cache_locks` | Cache locking mechanism |
| `personal_access_tokens` | API authentication tokens |
| `migrations` | Migration tracking |

### Application Database (`your_app_database`)
**Contains your custom tables:**
- Demo tables: `posts`, `categories`, `products`, `tags`, `product_tags`, `reviews`
- Your custom application tables

---

## Setup Instructions

### Step 1: Run Migrations

The migration files will automatically create the databases if they don't exist.

```bash
# 1. Run essentials migration (creates so_essentials database + tables)
mysql -u root -p < database/migrations/001_framework_essentials.sql

# 2. Run demo tables migration (creates so_framework database + demo tables)
# Edit the SQL file first to change 'so_framework' to your app database name
mysql -u root -p < database/migrations/002_demo_tables.sql
```

### Step 2: Configure Environment

Add these settings to your `.env` file:

```ini
# Application Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=so_framework
DB_USERNAME=root
DB_PASSWORD=your_password

# Essentials Database (Framework Tables)
DB_ESSENTIALS_CONNECTION=mysql
DB_ESSENTIALS_HOST=127.0.0.1
DB_ESSENTIALS_PORT=3306
DB_ESSENTIALS_DATABASE=so_essentials
DB_ESSENTIALS_USERNAME=root
DB_ESSENTIALS_PASSWORD=your_password
```

### Step 3: Verify Installation

```bash
# Check essentials database tables
mysql -u root -p so_essentials -e "SHOW TABLES;"

# Check application database tables
mysql -u root -p so_framework -e "SHOW TABLES;"
```

---

## Usage in Code

### Accessing Essentials Database

```php
// Query users table (in essentials database)
$users = app('db-essentials')->table('users')
    ->where('email', 'user@example.com')
    ->first();

// Create session record
app('db-essentials')->table('sessions')->insert([
    'id' => $sessionId,
    'user_id' => $userId,
    'payload' => $data,
    'last_activity' => time()
]);

// Clear cache
app('db-essentials')->table('cache')
    ->where('expiration', '<', time())
    ->delete();
```

### Accessing Application Database

```php
// Query your application tables
$products = app('db')->table('products')
    ->where('status', 'active')
    ->get();

// Create post
app('db')->table('posts')->insert([
    'user_id' => $userId,
    'title' => 'My Post',
    'content' => 'Content here'
]);
```

### Helper Function (Recommended)

Create a helper for easier access:

```php
// In your helpers file
function db_essentials() {
    return app('db-essentials');
}

// Usage
$users = db_essentials()->table('users')->get();
```

---

## Framework Components Using Essentials Database

The following framework components automatically use the essentials database:

### 1. Authentication
```php
// Auth system queries users/password_resets in essentials DB
$auth = app('auth');
$user = $auth->user(); // Queries so_essentials.users
```

### 2. Sessions
```php
// Session handler queries sessions table in essentials DB
$_SESSION['key'] = 'value'; // Stored in so_essentials.sessions
```

### 3. Cache
```php
// Cache driver uses cache table in essentials DB
cache()->set('key', 'value', 3600); // Stored in so_essentials.cache
```

### 4. Queue
```php
// Queue system uses jobs tables in essentials DB
Queue::push(new SendEmailJob($user));
```

### 5. Notifications
```php
// Notifications stored in essentials DB
Notification::send($user, new WelcomeNotification());
```

### 6. Activity Log
```php
// Activity log stored in essentials DB
activity()->log('User logged in');
```

---

## Updating Framework Services

If you need to configure framework services to use the essentials database:

### Example: Custom Session Handler

```php
use Core\Session\DatabaseSessionHandler;

$handler = new DatabaseSessionHandler(
    app('db-essentials'), // Use essentials connection
    config('session.lifetime')
);
```

### Example: Custom Cache Driver

```php
use Core\Cache\DatabaseCacheDriver;

$cache = new DatabaseCacheDriver(
    app('db-essentials') // Use essentials connection
);
```

---

## Best Practices

### 1. Always Use Essentials DB for Framework Tables
```php
// ✓ GOOD
app('db-essentials')->table('users')->find($id);

// ✗ BAD
app('db')->table('users')->find($id); // Wrong database!
```

### 2. Keep Application Logic Separate
```php
// ✓ GOOD - User authentication (essentials)
$user = app('db-essentials')->table('users')
    ->where('email', $email)
    ->first();

// ✓ GOOD - User posts (application)
$posts = app('db')->table('posts')
    ->where('user_id', $user['id'])
    ->get();
```

### 3. Cross-Database Foreign Keys
Note: Foreign keys between databases are **not supported**. Use application-level relationships:

```php
// posts table has user_id field
// But no FK constraint to so_essentials.users

// Validate user exists in application code
$user = app('db-essentials')->table('users')->find($userId);
if (!$user) {
    throw new Exception('User not found');
}

app('db')->table('posts')->insert([
    'user_id' => $userId, // Validated above
    'title' => 'Post Title'
]);
```

---

## Using in Existing Projects

To integrate SO Framework into an existing project:

1. **Create the essentials database** - Fresh database for framework tables
2. **Keep your existing database** - No changes needed to your app tables
3. **Run framework migrations** - Only to the essentials database
4. **Update your models** - Point framework-related models to essentials DB

```php
// In your existing User model
class User extends Model
{
    protected $connection = 'essentials'; // Use essentials DB
    protected $table = 'users';
}
```

---

## Backup & Maintenance

### Backup Both Databases

```bash
# Backup essentials database
mysqldump -u root -p so_essentials > backup_essentials_$(date +%Y%m%d).sql

# Backup application database
mysqldump -u root -p your_app_name > backup_app_$(date +%Y%m%d).sql
```

### Restore

```bash
# Restore essentials
mysql -u root -p so_essentials < backup_essentials_20240131.sql

# Restore application
mysql -u root -p your_app_name < backup_app_20240131.sql
```

### Prune Old Data

```php
// Clean old sessions (essentials)
app('db-essentials')->table('sessions')
    ->where('last_activity', '<', time() - 7200)
    ->delete();

// Clean old cache (essentials)
app('db-essentials')->table('cache')
    ->where('expiration', '<', time())
    ->delete();

// Clean old activity logs (essentials)
app('db-essentials')->table('activity_log')
    ->where('created_at', '<', date('Y-m-d H:i:s', strtotime('-30 days')))
    ->delete();
```

---

## Troubleshooting

### Issue: "Database connection failed"

**Solution:** Verify credentials in `.env`:
```bash
# Test essentials database
mysql -u root -p -e "USE so_essentials; SELECT 1;"

# Test application database
mysql -u root -p -e "USE your_app_name; SELECT 1;"
```

### Issue: "Table doesn't exist"

**Solution:** Ensure migrations ran on correct database:
```bash
# Check essentials tables
mysql -u root -p so_essentials -e "SHOW TABLES;"

# Check app tables
mysql -u root -p your_app_name -e "SHOW TABLES;"
```

### Issue: "Wrong database for query"

**Solution:** Use correct connection:
```php
// Framework tables
app('db-essentials')->table('users') // ✓

// App tables
app('db')->table('products') // ✓
```

---

## Migration Path from Single Database

If you're currently using a single database setup:

### Step 1: Export Framework Tables
```bash
mysqldump -u root -p old_database \
  users password_resets sessions jobs failed_jobs job_batches \
  notifications activity_log cache cache_locks personal_access_tokens migrations \
  > framework_tables.sql
```

### Step 2: Create Essentials Database
```bash
mysql -u root -p -e "CREATE DATABASE so_essentials;"
```

### Step 3: Import Framework Tables
```bash
mysql -u root -p so_essentials < framework_tables.sql
```

### Step 4: Update Configuration
Update `.env` with essentials database credentials.

### Step 5: Drop Framework Tables from Old Database (Optional)
```bash
mysql -u root -p old_database << EOF
DROP TABLE IF EXISTS users, password_resets, sessions, jobs, failed_jobs,
job_batches, notifications, activity_log, cache, cache_locks,
personal_access_tokens, migrations;
EOF
```

---

**Framework Version:** 2.0
**Last Updated:** 2026-02-01
**Author:** SO Framework Team
