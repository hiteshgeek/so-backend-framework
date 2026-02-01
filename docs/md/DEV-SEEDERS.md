# Database Seeders - Developer Guide

**SO Framework** | **Test Data & Database Seeding** | **Version 1.0**

A comprehensive guide to populating your database with test data, sample records, and initial application data using the SO Framework's seeding system.

---

## Table of Contents

1. [Overview](#overview)
2. [Creating Seeders](#creating-seeders)
3. [Running Seeders](#running-seeders)
4. [Seeder Structure](#seeder-structure)
5. [Seeding Strategies](#seeding-strategies)
6. [Best Practices](#best-practices)

---

## Overview

Database seeders populate your database with data for testing, development, or initial application setup. They help you:

- **Develop Faster** -- Work with realistic data without manual entry
- **Test Thoroughly** -- Create consistent test scenarios
- **Onboard Easily** -- New team members get a working database instantly
- **Demo Confidently** -- Showcase features with sample data
- **Deploy Safely** -- Seed production databases with initial required data

### When to Use Seeders

| Use Case | Example |
|----------|---------|
| **Development** | Generate 100 sample products to test pagination |
| **Testing** | Create known user accounts for automated tests |
| **Staging** | Populate demo environment with realistic data |
| **Production** | Insert initial admin account, default settings, or lookup tables |

### How Seeders Work

1. **Create** -- Generate seeder classes with `./sixorbit make:seeder`
2. **Define** -- Write data insertion logic in the `run()` method
3. **Execute** -- Run seeders with `./sixorbit db:seed`
4. **Repeat** -- Seeders can call other seeders for organization

```
Developer                    Database
    |                            |
    | make:seeder ProductSeeder  |
    |                            |
    | Edit run() method          |
    |                            |
    | ./sixorbit db:seed         |
    |------------------------->  |  Execute run() method
    |                            |  Insert sample data
    |<-------------------------|  |
    |                            |
```

---

## Creating Seeders

### Generate a Seeder Class

Use the `make:seeder` command:

```bash
./sixorbit make:seeder ProductSeeder
```

Creates `database/seeders/ProductSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Seed data here
    }
}
```

### Seeder File Location

All seeders live in `database/seeders/`. The framework includes a `DatabaseSeeder.php` file by default, which serves as the main entry point.

```
database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php     (main seeder)
    ├── UserSeeder.php
    ├── ProductSeeder.php
    └── CategorySeeder.php
```

### Naming Convention

Use singular noun + `Seeder` suffix:

**Good:**
- `UserSeeder`
- `ProductSeeder`
- `CategorySeeder`
- `OrderSeeder`

**Bad:**
- `UsersSeeder` (plural)
- `SeedUsers` (wrong order)
- `user_seeder` (snake_case)

---

## Running Seeders

### Run the Main Seeder

Execute `DatabaseSeeder` (runs all seeders it calls):

```bash
./sixorbit db:seed
```

### Run a Specific Seeder

Use the `--class` option:

```bash
./sixorbit db:seed --class=ProductSeeder
```

### Run After Migrations

Combine migration and seeding in development:

```bash
./sixorbit migrate && ./sixorbit db:seed
```

Or refresh everything (rollback + migrate + seed):

```bash
./sixorbit migrate:refresh && ./sixorbit db:seed
```

---

## Seeder Structure

### The run() Method

Every seeder must implement a `run()` method that inserts data:

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
            'price' => 999.99,
            'stock' => 50,
        ]);

        Product::create([
            'name' => 'Mouse',
            'price' => 29.99,
            'stock' => 200,
        ]);
    }
}
```

### Calling Other Seeders

Use the `call()` method to run other seeders:

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
```

Seeders run in the order they appear in the array. Users must exist before products can reference them via foreign keys.

---

## Seeding Strategies

### Strategy 1: Using Models

**Best for:** Simple, readable code with validation and events.

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'secret123',
            'role' => 'user',
        ]);
    }
}
```

**Pros:**
- Model validation runs automatically
- Model events fire (useful for logging, cache clearing)
- Clean, readable syntax

**Cons:**
- Slower for large datasets (one query per record)

### Strategy 2: Bulk Insert with Query Builder

**Best for:** Large datasets where speed matters.

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use Core\Database\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Laptop',
                'price' => 999.99,
                'stock' => 50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mouse',
                'price' => 29.99,
                'stock' => 200,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // ... 1000 more products
        ]);
    }
}
```

**Pros:**
- One query for all records (fast)
- Good for seeding 100+ records

**Cons:**
- No model validation
- No model events
- Must manually set timestamps

### Strategy 3: Loop for Dynamic Data

**Best for:** Generating varied sample data.

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Electronics', 'Clothing', 'Home', 'Sports'];

        for ($i = 1; $i <= 100; $i++) {
            Product::create([
                'name' => "Product {$i}",
                'category' => $categories[array_rand($categories)],
                'price' => rand(10, 1000) + (rand(0, 99) / 100),
                'stock' => rand(0, 500),
                'featured' => rand(0, 1) === 1,
            ]);
        }
    }
}
```

### Strategy 4: Faker Library (Realistic Data)

**Best for:** Generating realistic names, emails, addresses, etc.

First, install Faker:

```bash
composer require fakerphp/faker --dev
```

Then use it in seeders:

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => 'password',
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'bio' => $faker->paragraph,
            ]);
        }
    }
}
```

**Faker provides:**
- `$faker->name` -- "John Doe"
- `$faker->email` -- "john@example.com"
- `$faker->address` -- "123 Main St, Springfield"
- `$faker->paragraph` -- Random paragraph of text
- `$faker->date()` -- Random date
- `$faker->imageUrl()` -- Random image URL

### Strategy 5: Conditional Seeding (Environment-Aware)

**Best for:** Different data for development vs. production.

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (env('APP_ENV') === 'production') {
            // Production: Only create admin
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => env('ADMIN_PASSWORD'),
                'role' => 'admin',
            ]);
        } else {
            // Development: Create admin + test users
            User::create([
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => 'password',
                'role' => 'admin',
            ]);

            for ($i = 1; $i <= 20; $i++) {
                User::create([
                    'name' => "Test User {$i}",
                    'email' => "user{$i}@test.com",
                    'password' => 'password',
                    'role' => 'user',
                ]);
            }
        }
    }
}
```

### Strategy 6: Truncate Before Seeding

**Best for:** Ensuring clean state (removes old data first).

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use Core\Database\DB;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('products')->truncate();

        // Insert fresh data
        Product::create([
            'name' => 'Laptop',
            'price' => 999.99,
        ]);
    }
}
```

**Warning:** `truncate()` deletes all rows and resets auto-increment. Use with caution, especially with foreign keys.

To disable foreign key checks temporarily:

```php
public function run(): void
{
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('products')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // Insert data...
}
```

---

## Complete Examples

### Example 1: E-Commerce Seed Data

**database/seeders/DatabaseSeeder.php:**

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
```

**database/seeders/UserSeeder.php:**

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        // Regular users
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Customer {$i}",
                'email' => "customer{$i}@example.com",
                'password' => 'password',
                'role' => 'customer',
            ]);
        }
    }
}
```

**database/seeders/CategorySeeder.php:**

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Home & Garden',
            'Sports & Outdoors',
            'Books',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
            ]);
        }
    }
}
```

**database/seeders/ProductSeeder.php:**

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            ['name' => 'Laptop', 'price' => 999.99, 'category' => 'Electronics'],
            ['name' => 'T-Shirt', 'price' => 19.99, 'category' => 'Clothing'],
            ['name' => 'Garden Hose', 'price' => 29.99, 'category' => 'Home & Garden'],
            ['name' => 'Basketball', 'price' => 24.99, 'category' => 'Sports & Outdoors'],
            ['name' => 'Novel', 'price' => 14.99, 'category' => 'Books'],
        ];

        foreach ($products as $productData) {
            $category = $categories->firstWhere('name', $productData['category']);

            Product::create([
                'name' => $productData['name'],
                'category_id' => $category->id,
                'price' => $productData['price'],
                'stock' => rand(10, 100),
                'description' => "High quality {$productData['name']}",
            ]);
        }
    }
}
```

### Example 2: Blog Seed Data with Faker

```php
<?php

namespace Database\Seeders;

use Core\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Faker\Factory as Faker;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create 5 authors
        for ($i = 0; $i < 5; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => 'password',
                'role' => 'author',
            ]);

            // Each author writes 10 posts
            for ($j = 0; $j < 10; $j++) {
                $title = $faker->sentence;

                Post::create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'slug' => strtolower(str_replace(' ', '-', trim($title, '.'))),
                    'body' => $faker->paragraphs(5, true),
                    'status' => $faker->randomElement(['draft', 'published']),
                    'published_at' => $faker->dateTimeBetween('-1 year', 'now'),
                ]);
            }
        }
    }
}
```

---

## Best Practices

### 1. Keep Seeders Idempotent

Seeders should be safe to run multiple times. Use `truncate()` or check for existing records:

```php
public function run(): void
{
    // Check before creating
    if (User::where('email', 'admin@example.com')->exists()) {
        return; // Admin already exists
    }

    User::create([
        'email' => 'admin@example.com',
        // ...
    ]);
}
```

### 2. Order Matters for Foreign Keys

Seed parent tables before child tables:

**Right Order:**
```php
$this->call([
    UserSeeder::class,      // Parent (users)
    PostSeeder::class,      // Child (posts.user_id references users.id)
]);
```

**Wrong Order:**
```php
$this->call([
    PostSeeder::class,      // Error: user_id references non-existent users
    UserSeeder::class,
]);
```

### 3. Use Transactions for Safety

Wrap seeding in a transaction so failures rollback:

```php
public function run(): void
{
    $pdo = app('db')->connection->getPdo();

    $pdo->beginTransaction();

    try {
        // Seed data
        User::create(['name' => 'Admin', 'email' => 'admin@test.com']);
        Product::create(['name' => 'Laptop', 'price' => 999]);

        $pdo->commit();
    } catch (\Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
```

### 4. Separate Production and Development Seeders

Use environment checks or separate seeder classes:

```php
// database/seeders/ProductionSeeder.php
public function run(): void
{
    // Only essential data (admin, settings, lookup tables)
}

// database/seeders/DevelopmentSeeder.php
public function run(): void
{
    // Test data, sample products, fake users
}
```

### 5. Don't Seed Sensitive Data

Never commit real passwords, API keys, or personal data to seeders:

**Bad:**
```php
User::create([
    'email' => 'admin@example.com',
    'password' => 'MyRealPassword123!', // NEVER do this
]);
```

**Good:**
```php
User::create([
    'email' => 'admin@example.com',
    'password' => env('SEED_ADMIN_PASSWORD', 'change-me'),
]);
```

### 6. Document Expected Data

Add comments explaining what each seeder creates:

```php
/**
 * UserSeeder
 *
 * Creates:
 * - 1 admin user (admin@example.com / password)
 * - 10 customer users (customer1-10@example.com / password)
 * - 5 moderator users (mod1-5@example.com / password)
 */
class UserSeeder extends Seeder
{
    // ...
}
```

### 7. Use Constants for Shared Data

Define common values as class constants:

```php
class UserSeeder extends Seeder
{
    const ADMIN_EMAIL = 'admin@example.com';
    const DEFAULT_PASSWORD = 'password';
    const CUSTOMER_COUNT = 10;

    public function run(): void
    {
        User::create([
            'email' => self::ADMIN_EMAIL,
            'password' => self::DEFAULT_PASSWORD,
        ]);

        for ($i = 1; $i <= self::CUSTOMER_COUNT; $i++) {
            // ...
        }
    }
}
```

### 8. Clear Caches After Seeding

If your app caches database data, clear caches after seeding:

```php
public function run(): void
{
    // Seed data
    Product::create(['name' => 'Laptop']);

    // Clear cache
    cache()->flush();
}
```

---

## Quick Reference

### Common Seeding Commands

```bash
# Run all seeders (DatabaseSeeder)
./sixorbit db:seed

# Run specific seeder
./sixorbit db:seed --class=UserSeeder

# Migrate and seed
./sixorbit migrate && ./sixorbit db:seed

# Reset, migrate, and seed
./sixorbit migrate:refresh && ./sixorbit db:seed
```

### Seeder Methods

| Method | Purpose |
|--------|---------|
| `run()` | Main seeding logic (required) |
| `call([...])` | Run other seeders |
| `Model::create([...])` | Insert one record with model |
| `DB::table('x')->insert([...])` | Bulk insert without model |
| `DB::table('x')->truncate()` | Delete all records |

---

**Related Documentation:**
- [CLI Commands](/docs/dev/cli-commands) - Database seeding commands
- [Migrations](/docs/dev/migrations) - Creating database schema
- [Models](/docs/dev/models) - Working with models
- [Query Builder](/docs/query-builder) - Database queries

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
