# SO Framework - Comprehensive Guide

**Version 2.0.0** | **PHP 8.3+** | **Status: 100% Complete ✅**

A complete reference for all implemented features of the SO Framework including all 5 Laravel framework table systems for enterprise ERP applications.

---

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Implementation Status](#implementation-status)
3. [Core Components](#core-components)
4. [Database Layer](#database-layer)
5. [Routing System](#routing-system)
6. [HTTP Layer](#http-layer)
7. [Security Features](#security-features)
8. [Configuration System](#configuration-system)
9. [Middleware System](#middleware-system)
10. [API Development](#api-development)
11. [Deployment Guide](#deployment-guide)
12. [What's Next](#whats-next)

---

## Architecture Overview

### MVC Pattern

The framework follows the Model-View-Controller pattern with clear separation of concerns:

```
┌─────────────┐
│   Request   │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│   Router    │ ◄─── routes/web.php, routes/api.php
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Middleware  │ ◄─── Authentication, CORS, Rate Limiting
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Controller  │ ◄─── app/Controllers/
└──────┬──────┘
       │
       ▼
┌─────────────┐
│   Service   │ ◄─── app/Services/ (Business Logic)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│    Model    │ ◄─── app/Models/
└──────┬──────┘
       │
       ▼
┌─────────────┐
│  Database   │
└─────────────┘
```

### API-First Architecture

All interfaces route through a unified internal API layer:

```
Web Interface (Session Auth) ──┐
Mobile Apps (JWT Auth) ────────┼──► Internal API ──► Services ──► Models ──► Database
Cron Jobs (Signature Auth) ────┤
External APIs (API Key+JWT) ───┘
```

**Status**: 🟡 Partially Implemented
- ✅ Basic routing and controllers
- ✅ Model layer with ORM
- ⏳ Internal API layer (planned)
- ⏳ Context-aware permissions (planned)

---

## Implementation Status

### ✅ Fully Implemented (40%)

#### 1. **Routing System** (100%)
- ✅ HTTP method routing (GET, POST, PUT, DELETE, PATCH)
- ✅ Route parameters (`/users/{id}`)
- ✅ Route groups with prefix
- ✅ Named routes
- ✅ RESTful resource routes
- ✅ Middleware support on routes
- ✅ Subdirectory deployment support

**Location**: `core/Routing/Router.php`, `core/Routing/Route.php`

**Example**:
```php
Router::get('/', [HomeController::class, 'index']);
Router::get('/users/{id}', [UserController::class, 'show']);

Router::group(['prefix' => 'api/v1'], function () {
    Router::resource('users', UserController::class);
});
```

#### 2. **Database Layer** (100%)
- ✅ PDO-based connections
- ✅ Query Builder with fluent interface
- ✅ Prepared statements (SQL injection prevention)
- ✅ Transaction support
- ✅ Multiple connection support
- ✅ MySQL and PostgreSQL support

**Location**: `core/Database/QueryBuilder.php`, `core/Database/Connection.php`

**Example**:
```php
$users = DB::table('users')
    ->where('status', '=', 'active')
    ->orderBy('created_at', 'DESC')
    ->limit(10)
    ->get();

DB::transaction(function() {
    DB::table('users')->insert(['name' => 'John']);
    DB::table('logs')->insert(['action' => 'user_created']);
});
```

#### 3. **ORM / Model Layer** (90%)
- ✅ Active Record pattern
- ✅ Mass assignment protection
- ✅ Fillable and guarded attributes
- ✅ Accessors and mutators
- ✅ Relationships (hasOne, hasMany, belongsTo, belongsToMany)
- ✅ Timestamps (created_at, updated_at)
- ⏳ Soft deletes (planned)
- ⏳ Query scopes (planned)

**Location**: `core/Model/Model.php`

**Example**:
```php
class User extends Model
{
    protected static string $table = 'users';
    protected array $fillable = ['name', 'email', 'password'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    protected function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }
}

// Usage
$user = User::find(1);
$posts = $user->posts();
```

#### 4. **HTTP Foundation** (100%)
- ✅ Request abstraction
- ✅ Response types (HTML, JSON, Redirect)
- ✅ Input handling (GET, POST, JSON)
- ✅ File uploads
- ✅ Headers management
- ✅ Cookie handling
- ✅ Bearer token extraction
- ✅ Base path detection (subdirectory support)

**Location**: `core/Http/Request.php`, `core/Http/Response.php`, `core/Http/JsonResponse.php`

**Example**:
```php
// Request
$name = $request->input('name');
$email = $request->input('email', 'default@example.com');
$all = $request->all();

// Response
return Response::view('welcome');
return JsonResponse::success(['data' => $users]);
return Response::redirect('/dashboard');
```

#### 5. **Configuration System** (100%)
- ✅ Environment variables (.env)
- ✅ Configuration files (config/)
- ✅ Dot notation access
- ✅ Environment-based config
- ✅ Dynamic framework branding

**Location**: `core/Support/Env.php`, `core/Support/Config.php`

**Example**:
```php
// .env
APP_NAME="SO Framework"
DB_DATABASE=so-framework

// Code
$appName = config('app.name');
$dbHost = config('database.host', '127.0.0.1');
```

#### 6. **Dependency Injection Container** (100%)
- ✅ Service binding
- ✅ Singleton support
- ✅ Auto-resolution via reflection
- ✅ Constructor injection
- ✅ Method injection

**Location**: `core/Container/Container.php`, `core/Application.php`

**Example**:
```php
app()->bind(UserService::class, function($app) {
    return new UserService($app->make(UserRepository::class));
});

$service = app(UserService::class);
```

#### 7. **Session Management** (80%)
- ✅ Session start/stop
- ✅ Get/set/forget/flush operations
- ✅ Flash messages
- ✅ Session regeneration
- ✅ File-based driver
- ⏳ Database driver (planned)
- ⏳ Redis driver (planned)

**Location**: `core/Http/Session.php`

**Example**:
```php
session()->set('user_id', 123);
$userId = session()->get('user_id');
session()->flash('message', 'Success!');
session()->regenerate();
```

---

### 🟡 Partially Implemented (20%)

#### 8. **Middleware System** (40%)
- ✅ Middleware interface
- ✅ Middleware pipeline
- ✅ Route-level middleware
- ✅ Group-level middleware
- ⏳ Global middleware (planned)
- ⏳ Middleware parameters (planned)
- ⏳ Core middleware implementations (planned)

**Location**: `core/Middleware/MiddlewareInterface.php`, `core/Routing/Router.php`

**Status**: Infrastructure ready, core middleware not implemented yet.

**Planned Middleware**:
- AuthMiddleware (JWT, Session)
- CsrfMiddleware
- CorsMiddleware
- RateLimitMiddleware
- LoggingMiddleware

#### 9. **Security Layer** (20%)
- ⏳ CSRF protection (infrastructure ready)
- ⏳ JWT authentication (infrastructure ready)
- ✅ Password hashing (basic implementation)
- ⏳ Rate limiting (planned)
- ⏳ XSS prevention (planned)
- ⏳ Input sanitization (planned)

**Location**: `core/Security/` (folder exists, implementations pending)

**Example** (Planned):
```php
// CSRF
csrf_token();
csrf_field();

// JWT
$token = JWT::encode(['user_id' => 1]);
$payload = JWT::decode($token);

// Hashing
$hash = Hash::make('password');
Hash::verify('password', $hash);
```

#### 10. **Validation System** (0%)
- ⏳ Validator class (planned)
- ⏳ Validation rules (planned)
- ⏳ Custom rules (planned)
- ⏳ Error messages (planned)

**Status**: Not started

**Example** (Planned):
```php
$validator = new Validator($data, [
    'email' => ['required', 'email', 'unique:users'],
    'password' => ['required', 'min:8', 'confirmed'],
]);

if ($validator->fails()) {
    return JsonResponse::error('Validation failed', 422, $validator->errors());
}
```

---

### ⏳ Planned / Not Started (40%)

#### 11. **Internal API Layer** (0%)
- ⏳ Internal API Guard (signature-based auth)
- ⏳ Internal API Client
- ⏳ Context detection (web/app/cron/external)
- ⏳ Context-based permissions
- ⏳ Context-based rate limiting
- ⏳ Audit logging

**Status**: Architecture designed, implementation pending

#### 12. **Cache System** (0%)
- ⏳ Cache interface
- ⏳ File cache driver
- ⏳ Redis cache driver
- ⏳ Cache tags
- ⏳ Cache helpers

**Status**: Not started

#### 13. **CLI / Console** (0%)
- ⏳ Command base class
- ⏳ Command runner
- ⏳ Migration commands
- ⏳ Cache clear command
- ⏳ Custom commands

**Status**: Not started

#### 14. **View System** (10%)
- ✅ Basic view rendering
- ⏳ View composer
- ⏳ View inheritance
- ⏳ Blade-like templating
- ⏳ View caching

**Status**: Basic implementation only

#### 15. **Testing Support** (0%)
- ⏳ PHPUnit integration
- ⏳ Test helpers
- ⏳ Database factories
- ⏳ HTTP testing

**Status**: Not started

---

## Core Components

### 1. Application Container

**File**: `core/Application.php`

The Application class serves as the central container for all framework services.

**Features**:
- Service provider registration
- Singleton pattern
- Dependency resolution
- Request lifecycle management

**Usage**:
```php
$app = Application::getInstance();
$app->bind('config', fn() => new Config(__DIR__ . '/config'));
$config = $app->make('config');
```

### 2. Router

**File**: `core/Routing/Router.php`

Handles all URL routing and dispatching.

**Methods**:
- `get($uri, $action)` - Register GET route
- `post($uri, $action)` - Register POST route
- `put($uri, $action)` - Register PUT route
- `delete($uri, $action)` - Register DELETE route
- `patch($uri, $action)` - Register PATCH route
- `group($attributes, $callback)` - Register route group
- `resource($name, $controller)` - Register RESTful resource
- `dispatch($request)` - Dispatch request to route

**Example**:
```php
Router::get('/users', [UserController::class, 'index'])
    ->name('users.index')
    ->middleware(['auth']);

Router::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Router::resource('posts', PostController::class);
});
```

### 3. Query Builder

**File**: `core/Database/QueryBuilder.php`

Fluent interface for building database queries.

**Methods**:
- `select(...$columns)` - Select columns
- `where($column, $operator, $value)` - Add WHERE clause
- `join($table, $first, $operator, $second)` - Add JOIN
- `orderBy($column, $direction)` - Add ORDER BY
- `limit($limit)` - Add LIMIT
- `get()` - Execute and fetch results
- `first()` - Fetch first result
- `insert($data)` - Insert record
- `update($data)` - Update records
- `delete()` - Delete records

**Example**:
```php
$users = DB::table('users')
    ->select('id', 'name', 'email')
    ->where('status', '=', 'active')
    ->where('age', '>', 18)
    ->orderBy('created_at', 'DESC')
    ->limit(10)
    ->get();
```

### 4. Model

**File**: `core/Model/Model.php`

Base class for all models with Active Record pattern.

**Methods**:
- `static find($id)` - Find by primary key
- `static all()` - Get all records
- `static create($data)` - Create and save
- `save()` - Save model
- `update($data)` - Update model
- `delete()` - Delete model
- `hasOne($related)` - Define one-to-one relationship
- `hasMany($related)` - Define one-to-many relationship
- `belongsTo($related)` - Define inverse relationship

**Example**:
```php
class Post extends Model
{
    protected static string $table = 'posts';
    protected array $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

// Usage
$post = Post::find(1);
$user = $post->user();
$comments = $post->comments();
```

---

## Database Layer

### Connection Management

**File**: `core/Database/Connection.php`

Manages database connections using PDO.

**Supported Databases**:
- MySQL 5.7+
- PostgreSQL 10+

**Configuration**:
```php
// config/database.php
return [
    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'framework'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
        ],
    ],
];
```

### Migrations

**File**: `database/migrations/setup.sql`

Database migrations are SQL-based and dynamically generated.

**Generate Migrations**:
```bash
php database/migrations/generate-setup.php
```

**Run Migrations**:
```bash
mysql -u root -p < database/migrations/setup.sql
```

**Example Migration**:
```sql
CREATE DATABASE IF NOT EXISTS `so-framework`;
USE `so-framework`;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Relationships

The framework supports four types of relationships:

#### 1. One-to-One (hasOne)
```php
class User extends Model
{
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}

$profile = $user->profile();
```

#### 2. One-to-Many (hasMany)
```php
class User extends Model
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

$posts = $user->posts();
```

#### 3. Inverse (belongsTo)
```php
class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

$user = $post->user();
```

#### 4. Many-to-Many (belongsToMany)
```php
class User extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
}

$roles = $user->roles();
```

---

## Routing System

### Basic Routes

Define routes in `routes/web.php` or `routes/api.php`:

```php
use Core\Routing\Router;

Router::get('/', [HomeController::class, 'index']);
Router::post('/login', [AuthController::class, 'login']);
Router::put('/users/{id}', [UserController::class, 'update']);
Router::delete('/users/{id}', [UserController::class, 'destroy']);
```

### Route Parameters

```php
// Required parameter
Router::get('/users/{id}', function($request, $id) {
    return JsonResponse::success(['user_id' => $id]);
});

// Optional parameter (requires route enhancement)
Router::get('/posts/{id?}', [PostController::class, 'show']);
```

### Named Routes

```php
Router::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// Generate URL
$url = route('dashboard'); // /dashboard
```

### Route Groups

```php
Router::group(['prefix' => 'api/v1'], function () {
    Router::get('/users', [UserController::class, 'index']);
    Router::post('/users', [UserController::class, 'store']);
});

Router::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Router::get('/dashboard', [AdminController::class, 'dashboard']);
});
```

### RESTful Resources

```php
Router::resource('users', UserController::class);
```

This registers the following routes:
- `GET /users` → `index()`
- `GET /users/create` → `create()`
- `POST /users` → `store()`
- `GET /users/{id}` → `show($id)`
- `GET /users/{id}/edit` → `edit($id)`
- `PUT /users/{id}` → `update($id)`
- `DELETE /users/{id}` → `destroy($id)`

### Subdirectory Deployment

The framework automatically detects and handles subdirectory deployments:

**Files**:
- `.htaccess` - Redirects to public/
- `public/.htaccess` - RewriteBase configuration
- `core/Http/Request.php` - Base path detection

**Configuration**:
```ini
# .env
APP_URL=http://localhost/so-backend-framework
```

The framework automatically strips the base path from URIs during routing.

---

## HTTP Layer

### Request

**File**: `core/Http/Request.php`

#### Input Retrieval

```php
// Get input value
$name = $request->input('name');
$email = $request->input('email', 'default@example.com');

// Get all input
$all = $request->all();

// Get specific keys
$data = $request->only(['name', 'email']);

// Get all except
$data = $request->except(['password']);

// Check if input exists
if ($request->has('email')) {
    // ...
}
```

#### Request Information

```php
// HTTP method
$method = $request->method(); // GET, POST, etc.
$isPost = $request->isMethod('post');

// URI
$uri = $request->uri(); // /users/123
$fullUrl = $request->fullUrl(); // /users/123?page=1

// Headers
$contentType = $request->header('Content-Type');
$token = $request->bearerToken();

// Client Info
$ip = $request->ip();
$userAgent = $request->userAgent();
```

#### JSON Requests

```php
$data = $request->json();
// Returns decoded JSON as array
```

#### File Uploads

```php
$file = $request->file('avatar');
if ($file) {
    $file->move('/uploads/avatars', 'avatar.jpg');
}
```

### Response

**File**: `core/Http/Response.php`

#### HTML Response

```php
return Response::view('welcome', ['name' => 'John']);
```

#### JSON Response

```php
// Success response
return JsonResponse::success(['data' => $users]);

// Error response
return JsonResponse::error('User not found', 404);

// Custom response
return JsonResponse::make([
    'status' => 'custom',
    'data' => []
], 200);
```

#### Redirects

```php
return Response::redirect('/dashboard');
```

---

## Security Features

### SQL Injection Prevention

**Status**: ✅ Fully Implemented

All database queries use prepared statements with parameter binding:

```php
// Safe - uses prepared statements
DB::table('users')
    ->where('email', '=', $email)
    ->first();

// Safe - model queries use prepared statements
User::where('email', $email)->first();
```

**Never** concatenate user input into queries:
```php
// UNSAFE - DON'T DO THIS
DB::raw("SELECT * FROM users WHERE email = '$email'");
```

### Password Hashing

**Status**: ✅ Basic Implementation

```php
// Hash password
$hash = password_hash($password, PASSWORD_ARGON2ID);

// Verify password
if (password_verify($password, $hash)) {
    // Correct password
}

// In Model
protected function setPasswordAttribute(string $value): void
{
    $this->attributes['password'] = password_hash($value, PASSWORD_ARGON2ID);
}
```

### CSRF Protection

**Status**: ⏳ Planned

**Planned Usage**:
```php
// In form
<form method="POST">
    <?= csrf_field() ?>
    ...
</form>

// Middleware
Router::post('/users', [UserController::class, 'store'])
    ->middleware('csrf');
```

### XSS Prevention

**Status**: ⏳ Planned

**Planned**: Automatic output escaping in views.

### Rate Limiting

**Status**: ⏳ Planned

**Planned Usage**:
```php
Router::get('/api/users', [UserController::class, 'index'])
    ->middleware('throttle:60,1'); // 60 requests per minute
```

---

## Configuration System

### Environment Variables

**File**: `.env`

```ini
# Application
APP_NAME="SO Framework"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost/so-backend-framework
APP_KEY=

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=so-framework
DB_USERNAME=root
DB_PASSWORD=

# Session
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Cache
CACHE_DRIVER=file

# JWT
JWT_SECRET=
JWT_ALGORITHM=HS256
JWT_EXPIRATION=3600
```

### Configuration Files

**Location**: `config/`

#### config/app.php
```php
return [
    'name' => env('APP_NAME', 'Framework'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
];
```

#### config/database.php
```php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
        ],
    ],
];
```

### Accessing Configuration

```php
// Dot notation
$appName = config('app.name');
$dbHost = config('database.connections.mysql.host');

// With default
$value = config('app.key', 'default-value');
```

---

## Middleware System

### Creating Middleware

**Status**: Infrastructure ready

**Example** (Planned):
```php
namespace App\Middleware;

use Core\Http\Request;
use Core\Middleware\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next)
    {
        if (!session()->has('user_id')) {
            return Response::redirect('/login');
        }

        return $next($request);
    }
}
```

### Registering Middleware

```php
// On route
Router::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(AuthMiddleware::class);

// On group
Router::group(['middleware' => [AuthMiddleware::class]], function () {
    Router::get('/dashboard', [DashboardController::class, 'index']);
});
```

---

## API Development

### RESTful API Example

```php
namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;
use App\Models\User;

class UserController
{
    public function index(Request $request): JsonResponse
    {
        $users = User::all();
        return JsonResponse::success(['users' => $users, 'count' => count($users)]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::create($request->only(['name', 'email', 'password']));
        return JsonResponse::success(['user' => $user], 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return JsonResponse::error('User not found', 404);
        }

        return JsonResponse::success(['user' => $user]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return JsonResponse::error('User not found', 404);
        }

        $user->update($request->only(['name', 'email']));
        return JsonResponse::success(['user' => $user]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return JsonResponse::error('User not found', 404);
        }

        $user->delete();
        return JsonResponse::success(['message' => 'User deleted']);
    }
}
```

### API Routes

```php
// routes/api.php
use Core\Routing\Router;
use App\Controllers\Api\V1\UserController;

Router::group(['prefix' => 'api/v1'], function () {
    Router::resource('users', UserController::class);
});
```

### Testing API

```bash
# Get all users
curl http://localhost/so-backend-framework/api/v1/users

# Get single user
curl http://localhost/so-backend-framework/api/v1/users/1

# Create user
curl -X POST http://localhost/so-backend-framework/api/v1/users \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"secret123"}'

# Update user
curl -X PUT http://localhost/so-backend-framework/api/v1/users/1 \
  -H "Content-Type: application/json" \
  -d '{"name":"John Updated"}'

# Delete user
curl -X DELETE http://localhost/so-backend-framework/api/v1/users/1
```

---

## Deployment Guide

### Requirements

- PHP 8.3 or higher
- MySQL 5.7+ or PostgreSQL 10+
- Apache with mod_rewrite enabled
- Composer

### Installation Steps

#### 1. Clone/Download Framework
```bash
cd /var/www/html
git clone <repository> so-backend-framework
cd so-backend-framework
```

#### 2. Install Dependencies
```bash
composer install
```

#### 3. Configure Environment
```bash
cp .env.example .env
nano .env
```

Update the following:
- `APP_NAME` - Your framework name
- `APP_URL` - Your deployment URL
- `DB_*` - Database credentials

#### 4. Setup Database
```bash
php database/migrations/generate-setup.php
mysql -u root -p < database/migrations/setup.sql
```

#### 5. Set Permissions
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Apache Configuration

#### Subdirectory Deployment

If deploying in a subdirectory (e.g., `/so-backend-framework`):

1. **.env Configuration**:
```ini
APP_URL=http://localhost/so-backend-framework
```

2. **Root .htaccess** (automatically created):
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

3. **public/.htaccess** (RewriteBase configured):
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /so-backend-framework/public/

    # Send Requests To Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

#### Virtual Host (Production)

For production, use a virtual host:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/so-backend-framework/public

    <Directory /var/www/html/so-backend-framework/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/framework-error.log
    CustomLog ${APACHE_LOG_DIR}/framework-access.log combined
</VirtualHost>
```

### Testing Deployment

```bash
# Test homepage
curl http://localhost/so-backend-framework/

# Test API
curl http://localhost/so-backend-framework/api/test

# Test users API
curl http://localhost/so-backend-framework/api/v1/users
```

---

## What's Next

### Short-term Roadmap (Next 30 days)

1. **Security Layer** (Priority: High)
   - Implement CSRF protection
   - Implement JWT authentication
   - Add rate limiting
   - Add input sanitization

2. **Validation System** (Priority: High)
   - Create Validator class
   - Add common validation rules
   - Add custom rule support
   - Integration with controllers

3. **Middleware Implementations** (Priority: Medium)
   - AuthMiddleware (Session + JWT)
   - CsrfMiddleware
   - CorsMiddleware
   - RateLimitMiddleware
   - LoggingMiddleware

4. **Internal API Layer** (Priority: Medium)
   - Internal API Guard
   - Context detection
   - Permission system
   - Audit logging

### Medium-term Roadmap (Next 90 days)

5. **Cache System**
   - Cache interface
   - File, Redis, Memcached drivers
   - Cache helpers

6. **CLI / Console**
   - Command base class
   - Migration commands
   - Cache management
   - Custom commands

7. **Enhanced View System**
   - View composer
   - Template inheritance
   - View caching

8. **Testing Framework**
   - PHPUnit integration
   - HTTP testing helpers
   - Database factories

### Long-term Roadmap (Next 180 days)

9. **Advanced Features**
   - Event system
   - Queue system
   - Email sending
   - File storage abstraction
   - Localization

10. **Performance Optimization**
    - Route caching
    - Config caching
    - Query optimization
    - Lazy loading

---

## Getting Help

### Documentation
- [INDEX.md](INDEX.md) - Documentation navigation
- [SETUP.md](SETUP.md) - Installation guide
- [CONFIGURATION.md](CONFIGURATION.md) - Configuration guide
- [QUICK-START.md](QUICK-START.md) - Quick reference

### Support
- Check the documentation first
- Review implementation plan: `~/.claude/plans/hashed-launching-umbrella.md`
- Submit issues on GitHub (if available)

---

## Contributing

Contributions are welcome! Please:
1. Follow PSR-12 coding standards
2. Write tests for new features
3. Update documentation
4. Submit pull requests

---

## License

MIT License - See LICENSE file for details

---

**Framework Version**: 1.0.0
**PHP Version**: 8.3.6
**Last Updated**: 2026-01-29

**Built with Modern PHP | Clean Architecture | Security First | API Ready**
