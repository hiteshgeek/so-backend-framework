# Project Structure

This document provides a detailed explanation of every folder and file in the SO Framework, helping developers understand the codebase organization and purpose of each component.

## Table of Contents

1. [Root Directory](#root-directory)
2. [app/ - Application Code](#app---application-code)
3. [core/ - Framework Core](#core---framework-core)
4. [config/ - Configuration Files](#config---configuration-files)
5. [routes/ - Route Definitions](#routes---route-definitions)
6. [resources/ - Views & Assets](#resources---views--assets)
7. [public/ - Web Root](#public---web-root)
8. [storage/ - File Storage](#storage---file-storage)
9. [database/ - Database Files](#database---database-files)
10. [bootstrap/ - Application Bootstrap](#bootstrap---application-bootstrap)
11. [documentation/ - Documentation](#documentation---documentation)
12. [tests/ - Test Files](#tests---test-files)
13. [vendor/ - Dependencies](#vendor---dependencies)

---

## Root Directory

```
so-backend-framework/
├── .env                    # Environment configuration (secrets, database credentials)
├── .env.example            # Example environment file (template for .env)
├── .gitignore              # Git ignore rules
├── .htaccess               # Apache URL rewriting rules
├── composer.json           # PHP dependencies and autoloading
├── composer.lock           # Locked dependency versions
├── sixorbit                # CLI tool for artisan-like commands
├── sixorbit.local.conf     # Apache virtual host configuration
├── rename-framework.sh     # Script to rename framework to your brand
├── SETUP.md                # Quick setup instructions
├── TODO.md                 # Development todo list
└── debug-login.php         # Debug tool for authentication testing
```

### Key Root Files

| File | Purpose |
|------|---------|
| `.env` | Contains all environment-specific settings (database, app URL, secrets). Never commit this file. |
| `.env.example` | Template showing required environment variables. Commit this file. |
| `composer.json` | Defines PHP dependencies and PSR-4 autoloading namespaces. |
| `sixorbit` | CLI entry point. Run `php sixorbit <command>` for console commands. |
| `rename-framework.sh` | Bash script to rename "SO Framework" to your custom name. |

---

## app/ - Application Code

Your application code lives here. This is where you write controllers, models, middleware, and other business logic.

```
app/
├── Controllers/            # HTTP request handlers
│   ├── Api/
│   │   └── V1/
│   │       └── UserController.php    # API v1 user endpoints
│   ├── AuthController.php            # Login, register, logout
│   ├── DashboardController.php       # Admin dashboard
│   ├── DocsController.php            # Documentation pages
│   ├── PasswordController.php        # Password reset
│   └── UserApiController.php         # User API endpoints
│
├── Jobs/                   # Background job classes
│   └── TestJob.php                   # Example queue job
│
├── Middleware/             # HTTP middleware (request filters)
│   ├── AuthMiddleware.php            # Require authentication
│   ├── CorsMiddleware.php            # Cross-Origin Resource Sharing
│   ├── CsrfMiddleware.php            # CSRF token validation
│   ├── GuestMiddleware.php           # Redirect if authenticated
│   ├── JwtMiddleware.php             # JWT token authentication
│   ├── LogRequestMiddleware.php      # Request logging
│   └── ThrottleMiddleware.php        # Rate limiting
│
├── Models/                 # Database models (Eloquent-style)
│   └── User.php                      # User model with auth methods
│
├── Notifications/          # Notification classes
│   ├── OrderApprovalNotification.php # Order approval notification
│   └── WelcomeNotification.php       # Welcome email notification
│
└── Providers/              # Service providers (boot services)
    ├── ActivityLogServiceProvider.php  # Activity logging setup
    ├── CacheServiceProvider.php        # Cache system setup
    ├── NotificationServiceProvider.php # Notification system setup
    ├── QueueServiceProvider.php        # Queue system setup
    └── SessionServiceProvider.php      # Session system setup
```

### Controllers

Controllers handle HTTP requests and return responses. They should be thin - delegate business logic to services or models.

```php
// app/Controllers/UserController.php
class UserController
{
    public function index(Request $request): Response
    {
        $users = User::all();
        return Response::view('users/index', ['users' => $users]);
    }
}
```

### Models

Models represent database tables and handle data operations.

```php
// app/Models/User.php
class User extends Model
{
    protected string $table = 'users';
    protected array $fillable = ['name', 'email', 'password'];
    protected array $hidden = ['password'];
}
```

### Middleware

Middleware filters HTTP requests before they reach controllers.

```php
// app/Middleware/AuthMiddleware.php
class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        return $next($request);
    }
}
```

### Providers

Service providers bootstrap framework services during application startup.

```php
// app/Providers/CacheServiceProvider.php
class CacheServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('cache', function () {
            return new CacheManager(config('cache'));
        });
    }
}
```

---

## core/ - Framework Core

The framework's internal components. You typically don't modify these files unless extending the framework.

```
core/
├── Application.php         # Main application class, DI container
│
├── ActivityLog/            # Activity/audit logging system
│   ├── Activity.php                  # Activity model
│   ├── ActivityLogger.php            # Logging service
│   ├── ActivityLogObserver.php       # Model observer for auto-logging
│   └── LogsActivity.php              # Trait for models
│
├── Api/                    # Internal API layer
│   ├── ApiClient.php                 # HTTP client wrapper
│   ├── ContextPermissions.php        # Permission definitions
│   ├── InternalApiGuard.php          # API security guard
│   └── RequestContext.php            # Request context handling
│
├── Auth/                   # Authentication system
│   └── Auth.php                      # Auth manager (login, logout, check)
│
├── Cache/                  # Caching system
│   ├── CacheManager.php              # Cache manager (multiple drivers)
│   ├── Repository.php                # Cache repository
│   ├── Lock.php                      # Cache locking
│   └── Drivers/
│       ├── ArrayCache.php            # In-memory cache (testing)
│       └── DatabaseCache.php         # Database-backed cache
│
├── Console/                # CLI console system
│   ├── Command.php                   # Base command class
│   ├── Kernel.php                    # Console kernel
│   └── Commands/
│       ├── ActivityPruneCommand.php  # Prune old activity logs
│       ├── CacheClearCommand.php     # Clear cache
│       ├── CacheGcCommand.php        # Cache garbage collection
│       ├── NotificationCleanupCommand.php  # Clean old notifications
│       ├── QueueWorkCommand.php      # Process queue jobs
│       └── SessionCleanupCommand.php # Clean expired sessions
│
├── Container/              # Dependency injection container
│   ├── Container.php                 # IoC container
│   └── ServiceProvider.php           # Base service provider
│
├── Database/               # Database layer
│   ├── Connection.php                # PDO connection wrapper
│   └── QueryBuilder.php              # Fluent query builder
│
├── Exceptions/             # Exception classes
│   ├── HttpException.php             # HTTP error exceptions
│   └── NotFoundException.php         # 404 exceptions
│
├── Http/                   # HTTP layer
│   ├── Request.php                   # HTTP request wrapper
│   ├── Response.php                  # HTTP response
│   ├── JsonResponse.php              # JSON response
│   ├── RedirectResponse.php          # Redirect response
│   ├── Session.php                   # Session wrapper
│   └── UploadedFile.php              # File upload handling
│
├── Middleware/             # Middleware interface
│   └── MiddlewareInterface.php       # Middleware contract
│
├── Model/                  # ORM base classes
│   ├── Model.php                     # Base model (Active Record)
│   └── SoftDeletes.php               # Soft delete trait
│
├── Notifications/          # Notification system
│   ├── DatabaseChannel.php           # Store notifications in DB
│   ├── Notifiable.php                # Trait for notifiable models
│   ├── Notification.php              # Base notification class
│   └── NotificationManager.php       # Notification dispatcher
│
├── Queue/                  # Job queue system
│   ├── DatabaseQueue.php             # Database queue driver
│   ├── Job.php                       # Base job class
│   ├── QueueManager.php              # Queue manager
│   ├── SyncQueue.php                 # Synchronous queue (no delay)
│   └── Worker.php                    # Queue worker
│
├── Routing/                # Routing system
│   ├── Route.php                     # Route definition
│   └── Router.php                    # Router (dispatch, groups, etc.)
│
├── Security/               # Security components
│   ├── Csrf.php                      # CSRF token generation/validation
│   ├── JWT.php                       # JWT token handling
│   ├── RateLimiter.php               # Rate limiting
│   └── Sanitizer.php                 # Input sanitization
│
├── Session/                # Session handling
│   └── DatabaseSessionHandler.php    # Database session storage
│
├── Support/                # Helper utilities
│   ├── Collection.php                # Collection class
│   ├── Config.php                    # Configuration loader
│   ├── Env.php                       # Environment variable loader
│   └── Helpers.php                   # Global helper functions
│
├── Validation/             # Validation system
│   ├── Rule.php                      # Validation rule builder
│   ├── ValidationException.php       # Validation error exception
│   └── Validator.php                 # Validator class
│
└── View/                   # View rendering
    └── View.php                      # View renderer
```

### Key Core Classes

| Class | Purpose |
|-------|---------|
| `Application.php` | Main app class, boots the framework, manages services |
| `Router.php` | Matches URLs to controllers, handles groups/middleware |
| `Request.php` | Wraps $_GET, $_POST, $_FILES, headers, etc. |
| `Response.php` | Builds HTTP responses (HTML, JSON, redirects) |
| `Model.php` | Active Record ORM base class |
| `QueryBuilder.php` | Fluent SQL query building |
| `Validator.php` | Data validation with 27+ built-in rules |
| `Auth.php` | Authentication (login, logout, check, user) |

---

## config/ - Configuration Files

Application configuration. Values can be overridden by environment variables.

```
config/
├── activity.php            # Activity logging settings
├── api.php                 # API configuration
├── app.php                 # Application settings (name, URL, debug)
├── cache.php               # Cache driver settings
├── database.php            # Database connection settings
├── notifications.php       # Notification settings
├── queue.php               # Queue driver settings
├── security.php            # Security settings (CSRF, rate limits)
└── session.php             # Session configuration
```

### Configuration Files Explained

| File | Key Settings |
|------|--------------|
| `app.php` | `name`, `url`, `debug`, `timezone`, `locale` |
| `database.php` | `driver`, `host`, `database`, `username`, `password` |
| `cache.php` | `default` driver, `ttl`, driver-specific settings |
| `session.php` | `driver`, `lifetime`, `cookie` settings |
| `security.php` | `csrf` enabled, `rate_limit` settings |
| `queue.php` | `default` connection, retry settings |

### Accessing Configuration

```php
// Get single value
$appName = config('app.name');

// Get with default
$debug = config('app.debug', false);

// Get entire file
$dbConfig = config('database');
```

---

## routes/ - Route Definitions

Define your application's URL routes here.

```
routes/
├── web.php                 # Main web routes loader
├── api.php                 # Main API routes loader
├── web/                    # Web route modules
│   ├── auth.php            # Authentication routes (login, register)
│   ├── dashboard.php       # Dashboard/admin routes
│   └── docs.php            # Documentation routes
└── api/                    # API route modules
    ├── users.php           # User API endpoints
    ├── products.php        # Product API (template)
    └── orders.php          # Order API (template)
```

### Route Organization

The main files (`web.php`, `api.php`) load modular route files:

```php
// routes/web.php
require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/dashboard.php';
require __DIR__ . '/web/docs.php';
```

### Adding New Routes

1. Create a new file in `routes/web/` or `routes/api/`
2. Include it in the main route file
3. Define your routes with `Router::get()`, `Router::post()`, etc.

```php
// routes/web/products.php
Router::group(['prefix' => 'products'], function () {
    Router::get('/', [ProductController::class, 'index'])->name('products.index');
    Router::get('/{id}', [ProductController::class, 'show'])->name('products.show');
});
```

---

## resources/ - Views & Assets

Templates and frontend assets.

```
resources/
└── views/                  # PHP view templates
    ├── auth/               # Authentication views
    │   ├── login.php       # Login form
    │   ├── register.php    # Registration form
    │   ├── forgot.php      # Forgot password form
    │   └── reset.php       # Reset password form
    │
    ├── dashboard/          # Dashboard views
    │   ├── index.php       # Dashboard home
    │   ├── create.php      # Create user form
    │   └── edit.php        # Edit user form
    │
    ├── docs/               # Documentation views
    │   ├── index.php       # Docs index page
    │   ├── show.php        # Single doc page
    │   ├── comprehensive.php  # Comprehensive guide
    │   ├── _design.php     # Shared design styles
    │   ├── _markdown.php   # Markdown parser
    │   └── _styles.php     # Shared styles
    │
    └── welcome.php         # Home page
```

### View Rendering

```php
// In controller
return Response::view('dashboard/index', [
    'users' => $users,
    'title' => 'Dashboard'
]);

// In view (resources/views/dashboard/index.php)
<h1><?= e($title) ?></h1>
<?php foreach ($users as $user): ?>
    <p><?= e($user->name) ?></p>
<?php endforeach; ?>
```

---

## public/ - Web Root

The web server's document root. Only this folder is publicly accessible.

```
public/
├── index.php               # Application entry point
├── .htaccess               # Apache rewrite rules
└── assets/                 # Static assets (CSS, JS, images)
    └── ...
```

### index.php Flow

```php
// 1. Load autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// 2. Bootstrap application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Load routes
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

// 4. Handle request
$request = Request::createFromGlobals();
$response = $app->handleWebRequest($request);
$response->send();
```

---

## storage/ - File Storage

Application-generated files. Must be writable by web server.

```
storage/
├── cache/                  # Cache files
├── framework/              # Framework-generated files
│   ├── views/              # Compiled views (if applicable)
│   └── sessions/           # Session files (if using file driver)
├── logs/                   # Application logs
│   └── app.log             # Main log file
└── sessions/               # Session files
```

### Storage Permissions

```bash
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

---

## database/ - Database Files

Database migrations and seeds.

```
database/
└── migrations/             # SQL migration files
    └── 001_initial_setup.sql   # Initial database schema
```

### Running Migrations

```bash
# Import the migration
mysql -u root -p your_database < database/migrations/001_initial_setup.sql
```

---

## bootstrap/ - Application Bootstrap

Application initialization.

```
bootstrap/
└── app.php                 # Creates and configures Application instance
```

### bootstrap/app.php

```php
<?php
// Create application instance
$app = new \Core\Application(dirname(__DIR__));

// Register service providers
$app->register(\App\Providers\SessionServiceProvider::class);
$app->register(\App\Providers\CacheServiceProvider::class);
// ... more providers

// Boot the application
$app->boot();

return $app;
```

---

## documentation/ - Documentation

Framework documentation files.

```
documentation/
├── index.php               # Documentation portal (web UI)
└── md/                     # Markdown documentation files
    ├── README.md           # Framework overview
    ├── SETUP.md            # Installation guide
    ├── CONFIGURATION.md    # Configuration guide
    ├── ROUTING-SYSTEM.md   # Routing documentation
    ├── AUTH-SYSTEM.md      # Authentication guide
    ├── VALIDATION-SYSTEM.md # Validation guide
    ├── SECURITY-LAYER.md   # Security documentation
    ├── COMPREHENSIVE-GUIDE.md # Complete reference
    └── ... (more docs)
```

---

## tests/ - Test Files

Test scripts and documentation.

```
tests/
├── test_validation_system.php      # Validation tests
├── test_csrf_protection.php        # CSRF tests
├── test_jwt_authentication.php     # JWT tests
├── test_rate_limiting.php          # Rate limiting tests
├── test_xss_prevention.php         # XSS prevention tests
├── test_activity_logging.php       # Activity log tests
├── test_cache_and_sessions.php     # Cache/session tests
├── test_queue_system.php           # Queue tests
├── test_notification_system.php    # Notification tests
├── test_middleware_system.php      # Middleware tests
├── test_internal_api_layer.php     # Internal API tests
├── test_model_enhancements.php     # Model tests
├── run_all_security_tests.php      # Run all security tests
└── demo_validation_usage.php       # Validation demo
```

### Running Tests

```bash
php tests/test_validation_system.php
php tests/run_all_security_tests.php
```

---

## vendor/ - Dependencies

Composer-managed PHP dependencies. Never edit files here.

```
vendor/
├── autoload.php            # PSR-4 autoloader
├── composer/               # Composer internals
└── ...                     # Third-party packages
```

---

## Quick Reference: Where to Add What

| What you're adding | Where to put it |
|-------------------|-----------------|
| New controller | `app/Controllers/` |
| New model | `app/Models/` |
| New middleware | `app/Middleware/` |
| New service provider | `app/Providers/` |
| New job | `app/Jobs/` |
| New notification | `app/Notifications/` |
| New route file | `routes/web/` or `routes/api/` |
| New view | `resources/views/` |
| New config file | `config/` |
| New console command | `core/Console/Commands/` |
| New migration | `database/migrations/` |
| Static assets | `public/assets/` |

---

## Naming Conventions

| Type | Convention | Example |
|------|------------|---------|
| Controllers | PascalCase + Controller | `UserController.php` |
| Models | PascalCase (singular) | `User.php` |
| Middleware | PascalCase + Middleware | `AuthMiddleware.php` |
| Providers | PascalCase + ServiceProvider | `CacheServiceProvider.php` |
| Config files | lowercase | `database.php` |
| Route files | lowercase | `users.php` |
| Views | lowercase with folders | `auth/login.php` |
| Migrations | numbered + description | `001_initial_setup.sql` |

---

## Common Tasks

### Adding a New Feature

1. Create Model: `app/Models/Product.php`
2. Create Controller: `app/Controllers/ProductController.php`
3. Create Routes: `routes/web/products.php`
4. Include routes in `routes/web.php`
5. Create Views: `resources/views/products/`

### Adding an API Endpoint

1. Create Controller: `app/Controllers/Api/V1/ProductController.php`
2. Create Routes: `routes/api/products.php`
3. Include routes in `routes/api.php`

### Adding Middleware

1. Create: `app/Middleware/AdminMiddleware.php`
2. Implement `MiddlewareInterface`
3. Apply to routes: `->middleware([AdminMiddleware::class])`

---

**Last Updated**: 2026-01-30
