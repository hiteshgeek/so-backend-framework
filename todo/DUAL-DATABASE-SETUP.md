# Dual Database Setup - Summary

## What Was Changed

The SO Framework now uses a **dual database architecture** to keep framework tables separate from application tables. This allows you to integrate the framework into existing projects without table name conflicts.

---

## File Changes

### 1. New Migration Files

**`database/migrations/001_framework_essentials.sql`**
- Contains 12 essential framework tables
- Tables: users, password_resets, sessions, jobs, failed_jobs, job_batches, notifications, activity_log, cache, cache_locks, personal_access_tokens, migrations
- Should be imported into `so_essentials` database

**`database/migrations/002_demo_tables.sql`**
- Contains demo/testing tables
- Tables: posts, categories, products, tags, product_tags, reviews
- Should be imported into your application database

### 2. Configuration Updates

**`.env.example`** - Added essentials database configuration:
```ini
# Essentials Database Configuration (Framework Tables)
DB_ESSENTIALS_CONNECTION=mysql
DB_ESSENTIALS_HOST=127.0.0.1
DB_ESSENTIALS_PORT=3306
DB_ESSENTIALS_DATABASE=so_essentials
DB_ESSENTIALS_USERNAME=root
DB_ESSENTIALS_PASSWORD=
```

**`config/database.php`** - Added essentials connection:
```php
'essentials' => [
    'driver' => env('DB_ESSENTIALS_CONNECTION', 'mysql'),
    'host' => env('DB_ESSENTIALS_HOST', '127.0.0.1'),
    'port' => env('DB_ESSENTIALS_PORT', 3306),
    'database' => env('DB_ESSENTIALS_DATABASE', 'so_essentials'),
    'username' => env('DB_ESSENTIALS_USERNAME', 'root'),
    'password' => env('DB_ESSENTIALS_PASSWORD', ''),
    // ...
],
```

**`bootstrap/app.php`** - Added essentials database service:
```php
$app->singleton('db-essentials', function ($app) {
    $config = $app->make('config');
    $connectionConfig = $config->get("database.connections.essentials");
    // ... returns query builder for essentials database
});
```

### 3. Documentation

**`database/migrations/README.md`**
- Comprehensive guide on dual database architecture
- Setup instructions
- Usage examples
- Best practices
- Troubleshooting

### 4. Setup Script

**`setup/setup-databases.sh`**
- Automated setup script
- Creates both databases
- Runs migrations
- Updates .env file
- Verifies installation

---

## Quick Start

### Option 1: Automated Setup (Recommended)

```bash
# Run the setup script
bash setup/setup-databases.sh

# Follow the prompts to:
# - Enter MySQL credentials
# - Choose database names
# - Install demo tables (optional)
```

### Option 2: Manual Setup

```bash
# 1. Run migrations (databases will be created automatically)
mysql -u root -p < database/migrations/001_framework_essentials.sql
mysql -u root -p < database/migrations/002_demo_tables.sql

# 2. Update .env file
# Add essentials database credentials (see .env.example)

# Note: The migration files automatically create the databases if they don't exist
```

---

## Usage in Code

### Access Essentials Database (Framework Tables)

```php
// Users table (authentication)
$users = app('db-essentials')->table('users')
    ->where('email', 'user@example.com')
    ->first();

// Sessions
app('db-essentials')->table('sessions')->insert([
    'id' => $sessionId,
    'payload' => $data,
    'last_activity' => time()
]);

// Cache
app('db-essentials')->table('cache')->insert([
    'key' => 'my-key',
    'value' => json_encode($data),
    'expiration' => time() + 3600
]);

// Queue jobs
app('db-essentials')->table('jobs')->insert([
    'queue' => 'default',
    'payload' => json_encode($job),
    'attempts' => 0,
    'available_at' => time(),
    'created_at' => time()
]);
```

### Access Application Database (Your Tables)

```php
// Your custom tables
$products = app('db')->table('products')
    ->where('status', 'active')
    ->get();

$posts = app('db')->table('posts')
    ->where('user_id', $userId)
    ->get();
```

---

## Database Tables

### Essentials Database (`so_essentials`)

| Table | Purpose | Used By |
|-------|---------|---------|
| `users` | User accounts & authentication | Auth system |
| `password_resets` | Password reset tokens | Auth system |
| `sessions` | Database-driven sessions | Session handler |
| `jobs` | Queue jobs | Queue system |
| `failed_jobs` | Failed queue jobs | Queue system |
| `job_batches` | Batch job tracking | Queue system |
| `notifications` | Database notifications | Notification system |
| `activity_log` | Audit trail | Activity logger |
| `cache` | Database cache | Cache driver |
| `cache_locks` | Cache locking | Cache driver |
| `personal_access_tokens` | API tokens | API authentication |
| `migrations` | Migration tracking | Migration system |

### Application Database (`your_app_name`)

| Table | Purpose | Type |
|-------|---------|------|
| `posts` | Blog posts | Demo |
| `categories` | Product categories | Demo |
| `products` | Products catalog | Demo |
| `tags` | Product tags | Demo |
| `product_tags` | Many-to-many pivot | Demo |
| `reviews` | Product reviews | Demo |
| *Your tables* | Your application data | Custom |

---

## Benefits

### 1. **Integration with Existing Projects**
You can now integrate SO Framework into existing projects without worrying about table name conflicts. The framework tables live in their own database.

### 2. **Clean Separation**
Framework infrastructure (auth, sessions, cache) is completely separate from your business logic.

### 3. **Easier Upgrades**
Upgrading the framework only affects the essentials database, your application data remains untouched.

### 4. **Shared Authentication**
Multiple applications can share the same essentials database for unified authentication and sessions.

### 5. **Better Organization**
Clear boundary between framework and application concerns.

---

## Migration from Single Database

If you're currently using the old single-database setup:

1. **Export framework tables** from your current database
2. **Create the essentials database**
3. **Import framework tables** into essentials database
4. **Update .env** with essentials credentials
5. **Optionally drop** framework tables from old database

Detailed instructions in `database/migrations/README.md` under "Migration Path from Single Database".

---

## Important Notes

### ⚠️ Cross-Database Foreign Keys

Foreign keys **cannot** span across databases. If you have relationships between user data (essentials) and your app data, use application-level validation:

```php
// ✗ BAD - Can't create FK between databases
CREATE TABLE posts (
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES so_essentials.users(id)
);

// ✓ GOOD - Validate in application code
$user = app('db-essentials')->table('users')->find($userId);
if (!$user) {
    throw new Exception('User not found');
}

app('db')->table('posts')->insert([
    'user_id' => $userId, // Validated above
    'title' => 'Post Title'
]);
```

### 📝 Always Use Correct Connection

```php
// Framework tables - use db-essentials
app('db-essentials')->table('users')->...
app('db-essentials')->table('sessions')->...
app('db-essentials')->table('cache')->...

// Application tables - use db
app('db')->table('products')->...
app('db')->table('posts')->...
app('db')->table('orders')->...
```

### 🔄 Framework Services Auto-Switch

These framework services automatically use the essentials database (you don't need to do anything):
- Authentication (`app('auth')`)
- Session handler
- Cache driver
- Queue system
- Notification system
- Activity logger

---

## Support & Documentation

- **Full Documentation**: `database/migrations/README.md`
- **Migration Files**: `database/migrations/001_*.sql` and `002_*.sql`
- **Setup Script**: `setup/setup-databases.sh`

---

## Questions?

**Q: Do I have to use two databases?**
A: No, but it's recommended for production and existing project integration. For simple projects, you can continue using a single database.

**Q: Can I use different servers for each database?**
A: Yes! Configure different hosts in the .env file:
```ini
DB_HOST=server1.example.com
DB_ESSENTIALS_HOST=server2.example.com
```

**Q: What about performance?**
A: Minimal impact. Most queries still hit a single database. The separation is logical, not performance-driven.

**Q: Can I share essentials across multiple apps?**
A: Yes! Multiple applications can share the same essentials database for unified authentication.

---

**Framework Version:** 2.0
**Implementation Date:** 2026-02-01
**Status:** Production Ready ✓
