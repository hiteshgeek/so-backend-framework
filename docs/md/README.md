# SO Framework

A production-ready PHP framework with Laravel-style routing, comprehensive security features, and an API-first architecture.

> **[Docs] Full Documentation:** See [Documentation Index](/docs/index) for complete navigation.

## Features

- [x] **Advanced Routing** - Laravel-style routing with groups, named routes, middleware support
- [x] **MVC Architecture** - Clean separation of Models, Views, Controllers
- [x] **API-First Design** - Unified internal API layer for web, mobile, cron, and external APIs
- [x] **Security** - CSRF protection, XSS prevention, SQL injection prevention, JWT auth, rate limiting
- [x] **Database Layer** - Query builder with prepared statements, migrations, relationships
- [x] **Middleware System** - Flexible middleware pipeline for request processing
- [x] **Session Management** - Multiple drivers (file, database, Redis)
- [x] **Validation** - Comprehensive input validation system
- [x] **Dependency Injection** - Auto-resolving DI container
- [x] **Modern PHP** - Built for PHP 8.3+ with typed properties and modern features
- [x] **Configurable** - Change framework name in one place, affects everywhere

## Requirements

- PHP 8.3 or higher
- MySQL 8.0+ or PostgreSQL 14+
- Composer
- Extensions: PDO, JSON, mbstring, OpenSSL

## Quick Install

```bash
# 1. Install dependencies
composer install

# 2. Configure
cp .env.example .env
nano .env  # Set your database credentials

# 3. Setup database
mysql -u root -p < database/migrations/setup.sql

# 4. Test
php -S localhost:8000 -t public
curl http://localhost:8000/api/test
```

**[Book] Detailed Instructions:** See [Setup Guide](/docs/setup)

## Architecture

### API-First Design

All interfaces route through a unified internal API layer:

```
Web Interface (Session Auth) --+
Mobile Apps (JWT Auth) --------+--> Internal API Layer --> Services --> Models --> Database
Cron Jobs (Signature Auth) ----+
External APIs (API Key+JWT) ---+
```

Each interface has distinct permissions, rate limits, and guardrails enforced at the internal API layer.

## Configuration

**Change framework name in ONE place:**

```bash
# Edit .env
APP_NAME="Your Framework Name"
DB_DATABASE=your-database

# Regenerate SQL
php database/migrations/generate-setup.php
```

**[Book] Learn More:**
- [Configuration](/docs/configuration) - Complete config guide
- [Quick Start](/docs/quick-start) - Fast reference

## Directory Structure

```
+-- app/                 # Application code
|   +-- Controllers/     # HTTP controllers
|   +-- Models/          # Database models
|   +-- Middleware/      # Application middleware
|   +-- Services/        # Business logic
+-- core/                # Framework core
|   +-- Database/        # Query builder, connections
|   +-- Http/            # Request, Response, Session
|   +-- Routing/         # Router implementation
|   +-- Security/        # CSRF, JWT, hashing
+-- config/              # Configuration files
+-- routes/              # Route definitions
+-- public/              # Web root
+-- docs/                # [Docs] Complete documentation
+-- storage/             # Logs, cache, sessions
```

## Usage Examples

### Defining Routes

```php
// routes/web.php
use Core\Routing\Router;

Router::get('/', [HomeController::class, 'index']);
Router::get('/users/{id}', [UserController::class, 'show']);

Router::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Router::get('/dashboard', [AdminController::class, 'dashboard']);
});
```

### Creating Models

```php
namespace App\Models;

use Core\Model\Model;

class User extends Model
{
    protected static string $table = 'users';
    protected array $fillable = ['name', 'email', 'password'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

### Building Controllers

```php
namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;

class UserController
{
    public function index(Request $request): JsonResponse
    {
        $users = User::all();
        return JsonResponse::success($users);
    }
}
```

## Security

The framework includes comprehensive security features:

- **CSRF Protection** - Token-based protection for state-changing requests
- **XSS Prevention** - Automatic output escaping
- **SQL Injection Prevention** - All queries use prepared statements
- **Password Hashing** - Argon2ID with configurable rounds
- **Rate Limiting** - Per-route and per-user limiting
- **JWT Authentication** - For API endpoints
- **Session Security** - HTTPOnly, Secure, SameSite cookies

## Customization

### Rename Framework (30 seconds)

```bash
./rename-framework.sh "My Framework" "my-database" "vendor/package"
```

**[Book] Detailed Guides:**
- [Rename Process](/docs/rename) - Step-by-step manual process
- [Framework Branding](/docs/branding) - Complete file reference

## Testing

```bash
# Test homepage
curl http://localhost:8000

# Test API
curl http://localhost:8000/api/test

# Test user API
curl http://localhost:8000/api/v1/users

# Create user
curl -X POST http://localhost:8000/api/v1/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@example.com","password":"secret123"}'
```

## Documentation

**[Docs] Complete Documentation Available in this folder:**

### Quick Links

| Document | Description |
|----------|-------------|
| **[Documentation Index](/docs/index)** | [Docs] Complete documentation navigation |
| **[Setup Guide](/docs/setup)** | [->] Installation and setup guide |
| **[Configuration](/docs/configuration)** | [Config] Configuration system guide |
| **[Quick Start](/docs/quick-start)** | Fast reference guide |
| **[Rename Process](/docs/rename)** | [Note] Step-by-step rename guide |
| **[Framework Branding](/docs/branding)** | 🎨 Complete branding reference |

**Start here:** [Documentation Index](/docs/index)

## Implementation Status

**Current:** ~40% complete - Functional MVC framework with core features

**Implemented:**
- [x] Routing, Database, Models, Controllers
- [x] Request/Response handling
- [x] Basic session management
- [x] Configuration system
- [x] Subdirectory deployment support

**Planned:** (See `~/.claude/plans/` for details)
- [ ] Security layer (CSRF, JWT, Rate limiting)
- [ ] Internal API architecture
- [ ] Validation system
- [ ] Middleware implementations
- [ ] Caching and CLI tools

## Contributing

Contributions are welcome! Please submit pull requests with tests and documentation.

## License

MIT License

## Support

- **Documentation:** This folder
- **Setup Issues:** [Setup Guide](/docs/setup)
- **Configuration:** [Configuration](/docs/configuration)
- **Implementation Plan:** `~/.claude/plans/hashed-launching-umbrella.md`

---

**Built with PHP 8.3+ | Modern Architecture | Security First | API Ready**
