# Setup Guide - SO Backend Framework

## Quick Start

### 1. Configure Environment

Edit the `.env` file with your database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2. Create Database

Create your database:

```bash
mysql -u root -p
CREATE DATABASE framework CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

### 3. Import Database Schema

Import the sample schema:

```bash
mysql -u root -p framework < database/migrations/setup.sql
```

### 4. Test the Framework

#### Option A: PHP Built-in Server

```bash
php -S localhost:8000 -t public
```

Then visit:
- Homepage: http://localhost:8000
- API Test: http://localhost:8000/api/test
- User by ID: http://localhost:8000/users/1

#### Option B: Apache/Nginx

Configure your web server to point to the `public` directory as the document root.

## Testing API Endpoints

### Get All Users
```bash
curl http://localhost:8000/api/v1/users
```

### Get Single User
```bash
curl http://localhost:8000/api/v1/users/1
```

### Create User
```bash
curl -X POST http://localhost:8000/api/v1/users \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "securepassword123"
  }'
```

### Update User
```bash
curl -X PUT http://localhost:8000/api/v1/users/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Name"
  }'
```

### Delete User
```bash
curl -X DELETE http://localhost:8000/api/v1/users/1
```

## Framework Structure

### Core Components

- **Application.php** - DI container and application lifecycle
- **Router** - Laravel-style routing with groups and middleware
- **QueryBuilder** - Fluent query builder with prepared statements
- **Model** - Active Record ORM with relationships
- **Request/Response** - HTTP abstractions
- **Session** - Session management

### Creating a New Model

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Product extends Model
{
    protected static string $table = 'products';

    protected array $fillable = [
        'name',
        'price',
        'description',
    ];

    // Mutator - automatically hash price
    protected function setPriceAttribute(float $value): void
    {
        $this->attributes['price'] = round($value, 2);
    }

    // Accessor - format name
    protected function getNameAttribute(?string $value): string
    {
        return $value ? strtoupper($value) : '';
    }
}
```

### Creating a New Controller

```php
<?php

namespace App\Controllers\Api\V1;

use Core\Http\Request;
use Core\Http\JsonResponse;
use App\Models\Product;

class ProductController
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::all();
        return JsonResponse::success([
            'products' => array_map(fn($p) => $p->toArray(), $products)
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return JsonResponse::error('Product not found', 404);
        }

        return JsonResponse::success($product->toArray());
    }
}
```

### Defining Routes

Edit `routes/web.php`:

```php
<?php

use Core\Routing\Router;
use App\Controllers\Api\V1\ProductController;

// Basic routes
Router::get('/products', [ProductController::class, 'index']);
Router::get('/products/{id}', [ProductController::class, 'show']);

// Route groups
Router::group(['prefix' => 'api/v1'], function () {
    Router::get('/products', [ProductController::class, 'index']);
    Router::post('/products', [ProductController::class, 'store']);
});

// RESTful resource (creates all 7 routes)
Router::resource('products', ProductController::class);
```

## Security Features

### SQL Injection Prevention
All queries use prepared statements automatically:

```php
// This is SAFE - uses prepared statements
User::where('email', '=', $email)->first();

// Query builder also uses prepared statements
app('db')->table('users')
    ->where('email', '=', $email)
    ->first();
```

### Password Hashing
Passwords are automatically hashed in the User model:

```php
protected function setPasswordAttribute(string $value): void
{
    $this->attributes['password'] = password_hash($value, PASSWORD_ARGON2ID);
}
```

### XSS Prevention
Always escape output in views:

```php
<!-- Using the helper function -->
<h1><?= e($title) ?></h1>

<!-- Or PHP's htmlspecialchars -->
<p><?= htmlspecialchars($content, ENT_QUOTES, 'UTF-8') ?></p>
```

## Next Steps

### Implement Missing Features

The framework has a solid foundation. You can now add:

1. **CSRF Protection** - Implement `core/Security/Csrf.php`
2. **JWT Authentication** - Implement `core/Security/Jwt.php`
3. **Rate Limiting** - Implement `core/Security/RateLimiter.php`
4. **Validation** - Implement `core/Validation/Validator.php`
5. **Internal API Layer** - Implement as described in the plan
6. **Middleware** - Create authentication and authorization middleware
7. **Caching** - Implement cache drivers
8. **Console Commands** - Add CLI commands for migrations, cache, etc.

### Follow the Plan

The comprehensive implementation plan is located at:
`~/.claude/plans/hashed-launching-umbrella.md`

This plan includes detailed specifications for:
- Internal API architecture
- Security features
- Middleware system
- Validation
- Caching
- CLI commands
- And much more

## Troubleshooting

### Database Connection Errors

1. Check your `.env` file has correct credentials
2. Ensure the database exists
3. Verify MySQL/MariaDB is running:
   ```bash
   sudo systemctl status mysql
   ```

### 404 Errors

1. Ensure Apache mod_rewrite is enabled:
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

2. Check `.htaccess` exists in the `public` directory

### Permission Errors

```bash
# Fix permissions
chmod -R 755 /var/www/html/so-backend-framework
chmod -R 775 storage
```

## Support

For issues and questions, refer to:
- Implementation plan: `~/.claude/plans/hashed-launching-umbrella.md`
- README.md for overview
- Source code comments for documentation

## License

MIT License
