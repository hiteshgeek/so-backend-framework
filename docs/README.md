# SO Framework

A production-ready PHP framework with Laravel-style routing, comprehensive security features, and an API-first architecture.

> **📚 Full Documentation:** See [INDEX.md](INDEX.md) for complete navigation.

## Features

- ✅ **Advanced Routing** - Laravel-style routing with groups, named routes, middleware support
- ✅ **MVC Architecture** - Clean separation of Models, Views, Controllers
- ✅ **API-First Design** - Unified internal API layer for web, mobile, cron, and external APIs
- ✅ **Security** - CSRF protection, XSS prevention, SQL injection prevention, JWT auth, rate limiting
- ✅ **Database Layer** - Query builder with prepared statements, migrations, relationships
- ✅ **Middleware System** - Flexible middleware pipeline for request processing
- ✅ **Session Management** - Multiple drivers (file, database, Redis)
- ✅ **Validation** - Comprehensive input validation system
- ✅ **Dependency Injection** - Auto-resolving DI container
- ✅ **Modern PHP** - Built for PHP 8.3+ with typed properties and modern features
- ✅ **Configurable** - Change framework name in one place, affects everywhere

## Requirements

- PHP 8.3 or higher
- MySQL 5.7+ or PostgreSQL 10+
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

**📖 Detailed Instructions:** See [SETUP.md](SETUP.md)

## Architecture

### API-First Design

All interfaces route through a unified internal API layer:

```
Web Interface (Session Auth) ──┐
Mobile Apps (JWT Auth) ────────├──> Internal API Layer ──> Services ──> Models ──> Database
Cron Jobs (Signature Auth) ────┤
External APIs (API Key+JWT) ───┘
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

**📖 Learn More:**
- [CONFIGURATION.md](CONFIGURATION.md) - Complete config guide
- [QUICK-START.md](QUICK-START.md) - Fast reference

## Directory Structure

```
├── app/                 # Application code
│   ├── Controllers/     # HTTP controllers
│   ├── Models/          # Database models
│   ├── Middleware/      # Application middleware
│   └── Services/        # Business logic
├── core/                # Framework core
│   ├── Database/        # Query builder, connections
│   ├── Http/            # Request, Response, Session
│   ├── Routing/         # Router implementation
│   └── Security/        # CSRF, JWT, hashing
├── config/              # Configuration files
├── routes/              # Route definitions
├── public/              # Web root
├── docs/                # 📚 Complete documentation
└── storage/             # Logs, cache, sessions
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

**📖 Detailed Guides:**
- [RENAME-PROCESS.md](RENAME-PROCESS.md) - Step-by-step manual process
- [FRAMEWORK-BRANDING.md](FRAMEWORK-BRANDING.md) - Complete file reference

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

**📚 Complete Documentation Available in this folder:**

### Quick Links

| Document | Description |
|----------|-------------|
| **[INDEX.md](INDEX.md)** | 📚 Complete documentation navigation |
| **[SETUP.md](SETUP.md)** | 🚀 Installation and setup guide |
| **[CONFIGURATION.md](CONFIGURATION.md)** | ⚙️ Configuration system guide |
| **[QUICK-START.md](QUICK-START.md)** | ⚡ Fast reference guide |
| **[RENAME-PROCESS.md](RENAME-PROCESS.md)** | 📝 Step-by-step rename guide |
| **[FRAMEWORK-BRANDING.md](FRAMEWORK-BRANDING.md)** | 🎨 Complete branding reference |

**Start here:** [INDEX.md](INDEX.md)

## Implementation Status

**Current:** ~40% complete - Functional MVC framework with core features

**Implemented:**
- ✅ Routing, Database, Models, Controllers
- ✅ Request/Response handling
- ✅ Basic session management
- ✅ Configuration system
- ✅ Subdirectory deployment support

**Planned:** (See `~/.claude/plans/` for details)
- ⏳ Security layer (CSRF, JWT, Rate limiting)
- ⏳ Internal API architecture
- ⏳ Validation system
- ⏳ Middleware implementations
- ⏳ Caching and CLI tools

## Contributing

Contributions are welcome! Please submit pull requests with tests and documentation.

## License

MIT License

## Support

- **Documentation:** This folder
- **Setup Issues:** [SETUP.md](SETUP.md)
- **Configuration:** [CONFIGURATION.md](CONFIGURATION.md)
- **Implementation Plan:** `~/.claude/plans/hashed-launching-umbrella.md`

---

**Built with PHP 8.3+ | Modern Architecture | Security First | API Ready**
