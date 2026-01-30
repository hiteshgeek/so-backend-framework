# Advanced Model Features

**A step-by-step guide to query scopes, soft deletes, activity logging, and relationships in the SO Backend Framework.**

This guide covers the advanced traits and patterns available on the base `Core\Model\Model` class. By the end, you will know how to filter records with reusable scopes, soft-delete and restore rows, automatically audit every change, and wire up one-to-many and many-to-many relationships -- all without any ORM magic.

---

## Table of Contents

1. [Overview](#overview)
2. [Query Scopes](#query-scopes)
3. [Soft Deletes](#soft-deletes)
4. [Activity Logging](#activity-logging)
5. [Relationships](#relationships)
6. [Many-to-Many Relationships](#many-to-many-relationships)
7. [Complete Example](#complete-example)

---

## Overview

Every model in the framework extends `Core\Model\Model`. The base class gives you attribute management, CRUD operations, a query builder, and an observer system. On top of that foundation, three optional traits unlock additional behavior:

| Trait | Namespace | Purpose |
|-------|-----------|---------|
| `SoftDeletes` | `Core\Model\SoftDeletes` | Mark records as deleted without removing them from the database |
| `LogsActivity` | `Core\ActivityLog\LogsActivity` | Automatically log create, update, and delete events for audit trails |
| `Notifiable` | `Core\Notifications\Notifiable` | Allow a model to receive notifications via `$model->notify()` |

Relationships are defined as plain PHP methods that use the query builder to fetch related records. There is no Eloquent-style relationship magic -- you write the queries yourself, which keeps things explicit and easy to debug.

---

## Query Scopes

Query scopes let you encapsulate common `WHERE` conditions into reusable methods on your model. Instead of repeating the same filters everywhere, you define the filter once and call it by name.

### Defining a Scope

A scope is a method on your model whose name starts with `scope`. It receives the `QueryBuilder` as its first argument and returns it after adding conditions:

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Database\QueryBuilder;

class User extends Model
{
    protected static string $table = 'users';

    protected array $fillable = ['name', 'email', 'status', 'role'];

    /**
     * Scope: only active users
     */
    public function scopeActive(QueryBuilder $query): QueryBuilder
    {
        return $query->where('status', '=', 'active');
    }

    /**
     * Scope: only admin users
     */
    public function scopeAdmins(QueryBuilder $query): QueryBuilder
    {
        return $query->where('role', '=', 'admin');
    }
}
```

### Using Scopes

Call the scope by its short name (without the `scope` prefix) on the model's query chain. The framework's `__callStatic` handler resolves the full method name automatically:

```php
// Get all active users
$activeUsers = User::query()->where('status', '=', 'active')->get();

// Same thing, but using the scope
$activeUsers = User::active()->get();

// Chain multiple scopes
$activeAdmins = User::active()->where('role', '=', 'admin')->get();

// Or use the explicit scope() helper
$activeUsers = User::scope('active')->get();
```

### Parameterized Scopes

Scopes can accept additional parameters after the `QueryBuilder`. Pass them when you call the scope:

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Database\QueryBuilder;

class Order extends Model
{
    protected static string $table = 'orders';

    protected array $fillable = ['user_id', 'status', 'total', 'created_at'];

    /**
     * Scope: filter by status
     */
    public function scopeStatus(QueryBuilder $query, string $status): QueryBuilder
    {
        return $query->where('status', '=', $status);
    }

    /**
     * Scope: orders above a minimum total
     */
    public function scopeMinTotal(QueryBuilder $query, float $amount): QueryBuilder
    {
        return $query->where('total', '>=', $amount);
    }

    /**
     * Scope: orders created within a date range
     */
    public function scopeCreatedBetween(QueryBuilder $query, string $from, string $to): QueryBuilder
    {
        return $query->whereBetween('created_at', $from, $to);
    }
}
```

Usage:

```php
// Pending orders over $100
$bigPending = Order::status('pending')->where('total', '>=', 100)->get();

// Or combine parameterized scopes
$results = Order::scope('status', 'completed')
    ->where('total', '>=', 500)
    ->orderBy('created_at', 'DESC')
    ->get();

// Orders in a date range
$janOrders = Order::scope('createdBetween', '2025-01-01', '2025-01-31')->get();
```

### Scope Best Practices

| Guideline | Reason |
|-----------|--------|
| Always return the `QueryBuilder` | Allows the caller to keep chaining methods |
| Keep scopes focused on a single concern | Easier to compose when each scope does one thing |
| Prefer scopes over raw `where()` calls for conditions you reuse | Gives the filter a name, making code self-documenting |

---

## Soft Deletes

Soft deleting means setting a `deleted_at` timestamp instead of removing the row from the database. This is essential for audit trails and for allowing administrators to recover accidentally deleted records.

### Setting Up Soft Deletes

1. Add a `deleted_at` column to your table (nullable `TIMESTAMP` or `DATETIME`).
2. Use the `SoftDeletes` trait in your model.

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Model\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected static string $table = 'articles';

    protected array $fillable = ['title', 'body', 'author_id', 'status'];
}
```

The trait looks for a `deleted_at` column by default. If your column has a different name, define a `DELETED_AT` constant:

```php
class Article extends Model
{
    use SoftDeletes;

    /**
     * Override the default deleted_at column name
     */
    const DELETED_AT = 'removed_at';

    // ...
}
```

### Deleting, Restoring, and Force-Deleting

```php
// Find an article
$article = Article::find(1);

// Soft delete -- sets deleted_at to the current timestamp
$article->delete();

// Check if the record is soft-deleted
if ($article->trashed()) {
    echo 'This article has been soft-deleted.';
}

// Restore the record -- clears the deleted_at timestamp
$article->restore();

// Permanently remove the record from the database
$article->forceDelete();
```

### Querying Soft-Deleted Records

By default, normal queries exclude soft-deleted rows (the trait adds a `WHERE deleted_at IS NULL` scope). Use the static helpers to include or isolate them:

```php
// Default behavior: only non-deleted articles
$articles = Article::all();

// Include soft-deleted articles
$allArticles = Article::withTrashed();

// Only soft-deleted articles
$trashedArticles = Article::onlyTrashed();
```

### Soft Delete Summary

| Method | What It Does |
|--------|--------------|
| `$model->delete()` | Sets `deleted_at` to the current timestamp |
| `$model->restore()` | Clears the `deleted_at` timestamp |
| `$model->forceDelete()` | Permanently removes the row from the database |
| `$model->trashed()` | Returns `true` if the record has a non-null `deleted_at` |
| `Model::withTrashed()` | Returns all records, including soft-deleted ones |
| `Model::onlyTrashed()` | Returns only soft-deleted records |
| `$model->getDeletedAtColumn()` | Returns the column name (default `deleted_at`) |

---

## Activity Logging

The `LogsActivity` trait automatically records model changes to the `activity_log` table. Every create, update, and delete fires an observer that captures who made the change, what changed, and when.

### Setting Up Activity Logging

Use the `LogsActivity` trait and configure it with static properties:

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\ActivityLog\LogsActivity;

class User extends Model
{
    use LogsActivity;

    protected static string $table = 'users';

    protected array $fillable = ['name', 'email', 'role', 'status'];

    /**
     * Enable activity logging (default: true)
     */
    protected static bool $logsActivity = true;

    /**
     * Which attributes to include in the log.
     * Use ['*'] to log all attributes.
     */
    protected static array $logAttributes = ['name', 'email', 'role'];

    /**
     * Only log attributes that actually changed (default: true)
     */
    protected static bool $logOnlyDirty = true;

    /**
     * Custom log name for grouping (default: 'default')
     */
    protected static string $logName = 'user';
}
```

### Configuration Options

| Property | Type | Default | Purpose |
|----------|------|---------|---------|
| `$logsActivity` | `bool` | `true` | Master switch to enable/disable logging on this model |
| `$logAttributes` | `array` | `['*']` | List of attributes to record; `['*']` means all |
| `$logOnlyDirty` | `bool` | `true` | When `true`, update logs only include changed attributes |
| `$logName` | `string` | `'default'` | Groups log entries under a named category |

### What Gets Logged Automatically

When activity logging is enabled, the framework records the following events without any extra code:

```php
// Creating a user logs a "created" event
$user = User::create([
    'name'  => 'Alice',
    'email' => 'alice@example.com',
    'role'  => 'editor',
]);
// Activity log entry:
//   description: "User created"
//   event: "created"
//   properties: {"attributes": {"name": "Alice", "email": "alice@example.com", "role": "editor"}}

// Updating the user logs an "updated" event
$user->name = 'Alice Smith';
$user->save();
// Activity log entry:
//   description: "User updated"
//   event: "updated"
//   properties: {"attributes": {"name": "Alice Smith"}, "old": {"name": "Alice"}}

// Deleting the user logs a "deleted" event
$user->delete();
// Activity log entry:
//   description: "User deleted"
//   event: "deleted"
```

### Retrieving Activity Logs for a Model

The trait adds helper methods to every model instance:

```php
$user = User::find(1);

// Get all activity for this user (newest first)
$activities = $user->activities();

// Get the most recent activity
$latest = $user->latestActivity();

// Each activity entry has these fields:
// - log_name, description, event
// - subject_type, subject_id
// - causer_type, causer_id
// - properties (JSON with "attributes" and "old" keys)
// - created_at
```

### Manual Logging with the activity() Helper

For events that are not tied to a model lifecycle (e.g., a user login, a report export), use the global `activity()` helper to log manually:

```php
// Simple log entry
activity()
    ->log('User exported the monthly report')
    ->save();

// Log with a subject and causer
activity()
    ->performedOn($report)
    ->causedBy($user)
    ->withProperties(['format' => 'pdf', 'rows' => 1500])
    ->event('exported')
    ->log('Monthly report exported')
    ->save();

// Log under a specific log name
activity('security')
    ->causedBy($user)
    ->withProperties(['ip' => $request->ip()])
    ->event('login')
    ->log('User logged in')
    ->save();
```

The `activity()` helper returns an `ActivityLogger` instance with the following fluent methods:

| Method | Purpose |
|--------|---------|
| `->log(string $description)` | Set the log description |
| `->performedOn(Model $model)` | Set the subject model |
| `->causedBy(Model $user)` | Set the user who caused the activity |
| `->withProperties(array $props)` | Attach arbitrary data to the log entry |
| `->event(string $event)` | Set the event name |
| `->inLog(string $logName)` | Set the log group name |
| `->withBatch(string $uuid)` | Group related activities under a batch UUID |
| `->save()` | Persist the log entry to the database |

### Temporarily Disabling Activity Logging

You can turn logging off and on at runtime -- useful for bulk imports or seeding:

```php
// Disable logging
User::disableActivityLogging();

// Bulk import without cluttering the audit log
foreach ($csvRows as $row) {
    User::create($row);
}

// Re-enable logging
User::enableActivityLogging();
```

---

## Relationships

The SO Backend Framework does not provide Eloquent-style relationship declarations (`hasMany`, `belongsTo`, etc.). Instead, you define plain PHP methods on your model that use the query builder to fetch related records. This approach is explicit, easy to understand, and gives you full control over the generated SQL.

### One-to-Many (Parent Has Many Children)

A user has many posts. Define a method on the `User` model that queries the `posts` table:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class User extends Model
{
    protected static string $table = 'users';

    protected array $fillable = ['name', 'email'];

    /**
     * Get all posts written by this user
     */
    public function posts(): array
    {
        return Post::query()
            ->where('user_id', '=', $this->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Get only published posts by this user
     */
    public function publishedPosts(): array
    {
        return Post::query()
            ->where('user_id', '=', $this->id)
            ->where('status', '=', 'published')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Count this user's posts
     */
    public function postCount(): int
    {
        return Post::query()
            ->where('user_id', '=', $this->id)
            ->count();
    }
}
```

Usage:

```php
$user = User::find(1);

// Get all posts
$posts = $user->posts();

// Get published posts only
$published = $user->publishedPosts();

// Get the count
$count = $user->postCount();
```

### Many-to-One (Child Belongs to Parent)

A post belongs to a user. Define a method on the `Post` model that fetches the owning user:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Post extends Model
{
    protected static string $table = 'posts';

    protected array $fillable = ['user_id', 'category_id', 'title', 'body', 'status'];

    /**
     * Get the user who wrote this post
     */
    public function user(): ?array
    {
        return User::query()
            ->where('id', '=', $this->user_id)
            ->first();
    }

    /**
     * Get the category this post belongs to
     */
    public function category(): ?array
    {
        return Category::query()
            ->where('id', '=', $this->category_id)
            ->first();
    }
}
```

Usage:

```php
$post = Post::find(42);

// Get the author
$author = $post->user();
echo $author['name'];

// Get the category
$category = $post->category();
echo $category['name'];
```

### Returning Model Instances Instead of Arrays

If you prefer working with model objects rather than raw arrays, wrap the results:

```php
/**
 * Get the author as a User model instance
 */
public function author(): ?User
{
    return User::find($this->user_id);
}

/**
 * Get posts as an array of Post model instances
 */
public function posts(): array
{
    $rows = Post::query()
        ->where('user_id', '=', $this->id)
        ->get();

    return array_map(fn($row) => new Post($row), $rows);
}
```

---

## Many-to-Many Relationships

Many-to-many relationships use a pivot table that holds foreign keys for both related models. For example, a `Product` can belong to many `Tag` records, and each `Tag` can apply to many `Product` records. The pivot table `product_tag` connects them.

### Database Schema

```
products         product_tag           tags
--------         -----------           ------
id               product_id            id
name             tag_id                name
price
```

### Querying with Joins

Use the query builder's `join()` method (via `app('db')->table()`) to query through the pivot table:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Product extends Model
{
    protected static string $table = 'products';

    protected array $fillable = ['name', 'price', 'category_id'];

    /**
     * Get all tags for this product
     */
    public function tags(): array
    {
        return app('db')->table('tags')
            ->select('tags.*')
            ->join('product_tag', 'tags.id', '=', 'product_tag.tag_id')
            ->where('product_tag.product_id', '=', $this->id)
            ->get();
    }

    /**
     * Check if this product has a specific tag
     */
    public function hasTag(int $tagId): bool
    {
        return app('db')->table('product_tag')
            ->where('product_id', '=', $this->id)
            ->where('tag_id', '=', $tagId)
            ->exists();
    }

    /**
     * Attach a tag to this product
     */
    public function attachTag(int $tagId): bool
    {
        // Avoid duplicates
        if ($this->hasTag($tagId)) {
            return false;
        }

        return app('db')->table('product_tag')->insert([
            'product_id' => $this->id,
            'tag_id'     => $tagId,
        ]);
    }

    /**
     * Detach a tag from this product
     */
    public function detachTag(int $tagId): bool
    {
        return app('db')->table('product_tag')
            ->where('product_id', '=', $this->id)
            ->where('tag_id', '=', $tagId)
            ->delete();
    }

    /**
     * Sync tags: replace all current tags with a new set
     */
    public function syncTags(array $tagIds): void
    {
        // Remove all existing tags
        app('db')->table('product_tag')
            ->where('product_id', '=', $this->id)
            ->delete();

        // Attach the new set
        foreach ($tagIds as $tagId) {
            app('db')->table('product_tag')->insert([
                'product_id' => $this->id,
                'tag_id'     => $tagId,
            ]);
        }
    }
}
```

The inverse side on the `Tag` model:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Tag extends Model
{
    protected static string $table = 'tags';

    protected array $fillable = ['name'];

    /**
     * Get all products that have this tag
     */
    public function products(): array
    {
        return app('db')->table('products')
            ->select('products.*')
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->where('product_tag.tag_id', '=', $this->id)
            ->get();
    }
}
```

Usage:

```php
$product = Product::find(1);

// Get tags
$tags = $product->tags();

// Attach a tag
$product->attachTag(5);

// Detach a tag
$product->detachTag(3);

// Replace all tags with a new set
$product->syncTags([1, 4, 7]);

// Check for a specific tag
if ($product->hasTag(4)) {
    echo 'Product is tagged.';
}

// From the tag side
$tag = Tag::find(1);
$taggedProducts = $tag->products();
```

### Pivot Tables with Extra Columns

If your pivot table has extra columns (e.g., `quantity`, `added_at`), select them in the join:

```php
/**
 * Get tags with the pivot timestamp
 */
public function tagsWithTimestamp(): array
{
    return app('db')->table('tags')
        ->select('tags.*', 'product_tag.added_at')
        ->join('product_tag', 'tags.id', '=', 'product_tag.tag_id')
        ->where('product_tag.product_id', '=', $this->id)
        ->orderBy('product_tag.added_at', 'DESC')
        ->get();
}
```

---

## Complete Example

Below is a full `Product` model that combines query scopes, soft deletes, activity logging, and relationships. This is the pattern to follow when building real application models.

### The Product Model

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Model\SoftDeletes;
use Core\ActivityLog\LogsActivity;
use Core\Database\QueryBuilder;

class Product extends Model
{
    use SoftDeletes;
    use LogsActivity;

    // -----------------------------------------------------------------
    // Table & Keys
    // -----------------------------------------------------------------

    protected static string $table = 'products';

    protected array $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'category_id',
        'is_active',
    ];

    protected array $guarded = ['id'];

    // -----------------------------------------------------------------
    // Activity Logging Configuration
    // -----------------------------------------------------------------

    protected static bool $logsActivity   = true;
    protected static array $logAttributes = ['name', 'price', 'stock', 'is_active'];
    protected static bool $logOnlyDirty   = true;
    protected static string $logName      = 'product';

    // -----------------------------------------------------------------
    // Query Scopes
    // -----------------------------------------------------------------

    /**
     * Scope: only active (published) products
     */
    public function scopeActive(QueryBuilder $query): QueryBuilder
    {
        return $query->where('is_active', '=', 1);
    }

    /**
     * Scope: only products that are in stock
     */
    public function scopeInStock(QueryBuilder $query): QueryBuilder
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope: products within a price range
     */
    public function scopePriceBetween(QueryBuilder $query, float $min, float $max): QueryBuilder
    {
        return $query->whereBetween('price', $min, $max);
    }

    /**
     * Scope: products in a specific category
     */
    public function scopeInCategory(QueryBuilder $query, int $categoryId): QueryBuilder
    {
        return $query->where('category_id', '=', $categoryId);
    }

    /**
     * Scope: cheap products (under a given price, default $25)
     */
    public function scopeCheap(QueryBuilder $query, float $maxPrice = 25.00): QueryBuilder
    {
        return $query->where('price', '<', $maxPrice);
    }

    // -----------------------------------------------------------------
    // Relationships
    // -----------------------------------------------------------------

    /**
     * Get the category this product belongs to
     */
    public function category(): ?array
    {
        return Category::query()
            ->where('id', '=', $this->category_id)
            ->first();
    }

    /**
     * Get all tags for this product (many-to-many)
     */
    public function tags(): array
    {
        return app('db')->table('tags')
            ->select('tags.*')
            ->join('product_tag', 'tags.id', '=', 'product_tag.tag_id')
            ->where('product_tag.product_id', '=', $this->id)
            ->get();
    }

    /**
     * Attach a tag to this product
     */
    public function attachTag(int $tagId): bool
    {
        if ($this->hasTag($tagId)) {
            return false;
        }

        return app('db')->table('product_tag')->insert([
            'product_id' => $this->id,
            'tag_id'     => $tagId,
        ]);
    }

    /**
     * Detach a tag from this product
     */
    public function detachTag(int $tagId): bool
    {
        return app('db')->table('product_tag')
            ->where('product_id', '=', $this->id)
            ->where('tag_id', '=', $tagId)
            ->delete();
    }

    /**
     * Check if this product has a specific tag
     */
    public function hasTag(int $tagId): bool
    {
        return app('db')->table('product_tag')
            ->where('product_id', '=', $this->id)
            ->where('tag_id', '=', $tagId)
            ->exists();
    }
}
```

### Using the Product Model

```php
// -----------------------------------------------------------------
// Creating a product (activity log: "Product created")
// -----------------------------------------------------------------

$product = Product::create([
    'name'        => 'Wireless Keyboard',
    'slug'        => 'wireless-keyboard',
    'description' => 'Ergonomic wireless keyboard with backlight.',
    'price'       => 79.99,
    'stock'       => 150,
    'category_id' => 3,
    'is_active'   => 1,
]);

// -----------------------------------------------------------------
// Query scopes
// -----------------------------------------------------------------

// Active products in stock, sorted by price
$available = Product::active()
    ->where('stock', '>', 0)
    ->orderBy('price', 'ASC')
    ->get();

// Products between $50 and $100 in category 3
$filtered = Product::scope('priceBetween', 50.00, 100.00)
    ->where('category_id', '=', 3)
    ->get();

// Cheap products (under $25)
$bargains = Product::cheap()->get();

// In-stock products in a specific category
$inStock = Product::scope('inCategory', 3)
    ->where('stock', '>', 0)
    ->paginate(20, 1);

// -----------------------------------------------------------------
// Updating (activity log: "Product updated" with old/new values)
// -----------------------------------------------------------------

$product->price = 69.99;
$product->stock = 140;
$product->save();

// -----------------------------------------------------------------
// Relationships
// -----------------------------------------------------------------

// Get the category
$category = $product->category();

// Manage tags (many-to-many)
$product->attachTag(1);
$product->attachTag(5);
$tags = $product->tags();
$product->detachTag(5);

// -----------------------------------------------------------------
// Soft deletes
// -----------------------------------------------------------------

// Soft delete the product
$product->delete();

// Check status
$product->trashed();   // true

// Retrieve soft-deleted products
$trashed = Product::onlyTrashed();

// Retrieve all products, including soft-deleted ones
$all = Product::withTrashed();

// Restore
$product->restore();
$product->trashed();   // false

// Permanently remove
$product->forceDelete();

// -----------------------------------------------------------------
// Activity log review
// -----------------------------------------------------------------

$product = Product::find(1);

// Get full audit history
$history = $product->activities();

// Get the last change
$lastChange = $product->latestActivity();

// Manual log entry
activity('product')
    ->performedOn($product)
    ->causedBy(auth()->user())
    ->withProperties(['reason' => 'price adjustment'])
    ->event('price_updated')
    ->log('Product price manually adjusted')
    ->save();
```

### The Category Model (for Reference)

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Category extends Model
{
    protected static string $table = 'categories';

    protected array $fillable = ['name', 'slug', 'parent_id'];

    /**
     * Get all products in this category
     */
    public function products(): array
    {
        return Product::query()
            ->where('category_id', '=', $this->id)
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * Get only active products in this category
     */
    public function activeProducts(): array
    {
        return Product::query()
            ->where('category_id', '=', $this->id)
            ->where('is_active', '=', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * Get the parent category (self-referencing relationship)
     */
    public function parent(): ?array
    {
        if (!$this->parent_id) {
            return null;
        }

        return self::query()
            ->where('id', '=', $this->parent_id)
            ->first();
    }

    /**
     * Get child categories
     */
    public function children(): array
    {
        return self::query()
            ->where('parent_id', '=', $this->id)
            ->orderBy('name', 'ASC')
            ->get();
    }
}
```
