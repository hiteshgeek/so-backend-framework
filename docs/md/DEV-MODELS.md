# Models & Query Builder

**A step-by-step guide to creating models and using the query builder in the SO Backend Framework.**

This guide walks you through defining a model class, performing CRUD operations, building queries, paginating results, and using attribute mutators. By the end, you will be able to interact with any database table through an expressive, object-oriented API.

---

## Table of Contents

1. [Overview](#overview)
2. [Step 1: Create a Model Class](#step-1-create-a-model-class)
3. [Step 2: Basic CRUD](#step-2-basic-crud)
4. [Step 3: Query Builder](#step-3-query-builder)
5. [Step 4: Advanced Queries](#step-4-advanced-queries)
6. [Step 5: Pagination](#step-5-pagination)
7. [Attribute Mutators](#attribute-mutators)
8. [Complete Example](#complete-example)

---

## Overview

Every database table in the framework is represented by a **Model** class. Models live in `app/Models/` and extend `Core\Model\Model`. Each model maps to a single table and provides:

- **CRUD methods** -- `create()`, `find()`, `update()`, `delete()`
- **A query builder** -- fluent interface for `WHERE`, `JOIN`, `ORDER BY`, `GROUP BY`, and more
- **Attribute mutators** -- automatically transform values when getting or setting fields
- **Pagination** -- built-in `paginate()` and `simplePaginate()` methods

### How It Fits Together

```
Controller
    |
    v
Model (app/Models/Category.php)
    |
    v
QueryBuilder (Core\Database\QueryBuilder)
    |
    v
Database Connection (Core\Database\Connection)
    |
    v
MySQL / MariaDB / SQLite
```

The model is the primary way your controllers and services interact with the database. You never write raw SQL unless you explicitly choose to.

---

## Step 1: Create a Model Class

Each model needs three things: a file in `app/Models/`, a `$table` property, and a `$fillable` array.

### 1a. Create the file

Create the file `app/Models/Category.php`:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Category extends Model
{
    /**
     * The database table this model maps to.
     */
    protected static string $table = 'categories';

    /**
     * Columns that can be mass-assigned via create() or fill().
     */
    protected array $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'is_active',
    ];
}
```

### 1b. Understanding the properties

| Property | Type | Purpose |
|----------|------|---------|
| `$table` | `static string` | The database table name. Must match exactly. |
| `$fillable` | `array` | Columns allowed in mass-assignment (`create()`, `fill()`). Any column not listed here is silently ignored when using mass-assignment methods. |
| `$guarded` | `array` | Columns blocked from mass-assignment. Defaults to `['id']`. If you set `$guarded = []`, all columns become fillable (use with caution). |
| `$primaryKey` | `static string` | The primary key column. Defaults to `'id'`. Override if your table uses a different column name. |

### 1c. Namespace convention

All models use the `App\Models` namespace, which maps to the `app/Models/` directory. The class name must match the file name:

```
App\Models\Category   -->  app/Models/Category.php
App\Models\Product    -->  app/Models/Product.php
App\Models\User       -->  app/Models/User.php
```

---

## Step 2: Basic CRUD

Once your model exists, you can create, read, update, and delete records immediately.

### Create a record

`Model::create()` accepts an associative array, inserts a row, and returns the new model instance with its `id` set:

```php
<?php

use App\Models\Category;

$category = Category::create([
    'name'        => 'Electronics',
    'slug'        => 'electronics',
    'description' => 'Phones, laptops, and accessories',
    'is_active'   => 1,
]);

// The new ID is available immediately
echo $category->id; // e.g. 1
```

### Find a record by ID

`Model::find()` returns a model instance or `null` if no row matches:

```php
<?php

$category = Category::find(1);

if ($category) {
    echo $category->name;        // "Electronics"
    echo $category->description; // "Phones, laptops, and accessories"
}
```

### Find a record by a specific column

Use `where()` and `first()` to look up a record by any column:

```php
<?php

$result = Category::query()
    ->where('slug', '=', 'electronics')
    ->first();

// $result is an associative array (not a model instance)
// e.g. ['id' => 1, 'name' => 'Electronics', 'slug' => 'electronics', ...]
```

You can also define a dedicated finder method on the model (see the [Complete Example](#complete-example) section).

### Fetch all records

`Model::all()` returns an array of model instances:

```php
<?php

$categories = Category::all();

foreach ($categories as $category) {
    echo $category->name . "\n";
}
```

### Update a record

Fetch the model, change its attributes, then call `save()`:

```php
<?php

$category = Category::find(1);

$category->name = 'Consumer Electronics';
$category->description = 'Updated description';
$category->save();
```

Alternatively, use `setAttribute()`:

```php
<?php

$category = Category::find(1);
$category->setAttribute('name', 'Consumer Electronics');
$category->save();
```

### Delete a record

Call `delete()` on a fetched model instance:

```php
<?php

$category = Category::find(1);

if ($category) {
    $category->delete(); // Row is removed from the database
}
```

### Convert to array or JSON

```php
<?php

$category = Category::find(1);

$array = $category->toArray();
// ['id' => 1, 'name' => 'Electronics', 'slug' => 'electronics', ...]

$json = $category->toJson();
// '{"id":1,"name":"Electronics","slug":"electronics",...}'
```

---

## Step 3: Query Builder

Every model provides a query builder through `Model::query()`. The query builder lets you construct SQL queries using a fluent, chainable API. All values are parameterized automatically, preventing SQL injection.

### Getting the query builder

```php
<?php

// Returns a QueryBuilder instance bound to the "categories" table
$query = Category::query();
```

### Where clauses

#### Basic where

```php
<?php

// WHERE is_active = 1
$rows = Category::query()
    ->where('is_active', '=', 1)
    ->get();
```

#### Multiple where clauses (AND)

Chain multiple `where()` calls. They are joined with `AND`:

```php
<?php

// WHERE is_active = 1 AND parent_id = 5
$rows = Category::query()
    ->where('is_active', '=', 1)
    ->where('parent_id', '=', 5)
    ->get();
```

#### Or where

Use `orWhere()` to add an `OR` condition:

```php
<?php

// WHERE is_active = 1 OR parent_id IS NULL
$rows = Category::query()
    ->where('is_active', '=', 1)
    ->orWhere('parent_id', '=', null)
    ->get();
```

#### Where In / Where Not In

```php
<?php

// WHERE id IN (1, 2, 3)
$rows = Category::query()
    ->whereIn('id', [1, 2, 3])
    ->get();

// WHERE id NOT IN (4, 5)
$rows = Category::query()
    ->whereNotIn('id', [4, 5])
    ->get();
```

#### Where Null / Where Not Null

```php
<?php

// WHERE parent_id IS NULL  (top-level categories)
$rows = Category::query()
    ->whereNull('parent_id')
    ->get();

// WHERE description IS NOT NULL
$rows = Category::query()
    ->whereNotNull('description')
    ->get();
```

#### Where Between

```php
<?php

// WHERE created_at BETWEEN '2025-01-01' AND '2025-12-31'
$rows = Category::query()
    ->whereBetween('created_at', '2025-01-01', '2025-12-31')
    ->get();
```

### Ordering results

```php
<?php

// ORDER BY name ASC
$rows = Category::query()
    ->orderBy('name', 'ASC')
    ->get();

// ORDER BY created_at DESC, name ASC
$rows = Category::query()
    ->orderBy('created_at', 'DESC')
    ->orderBy('name', 'ASC')
    ->get();
```

### Limiting and offsetting

```php
<?php

// Get the first 10 rows
$rows = Category::query()
    ->limit(10)
    ->get();

// Skip the first 20, then get 10 (useful for manual pagination)
$rows = Category::query()
    ->limit(10)
    ->offset(20)
    ->get();
```

### Selecting specific columns

By default, all columns (`*`) are selected. Use `select()` to pick specific ones:

```php
<?php

// SELECT id, name, slug FROM categories
$rows = Category::query()
    ->select('id', 'name', 'slug')
    ->get();
```

### Fetching a single row

Use `first()` to get the first matching row as an associative array (or `null`):

```php
<?php

$row = Category::query()
    ->where('slug', '=', 'electronics')
    ->first();

if ($row) {
    echo $row['name']; // "Electronics"
}
```

---

## Step 4: Advanced Queries

### Joins

The query builder supports `INNER`, `LEFT`, and `RIGHT` joins:

```php
<?php

// INNER JOIN: Get products with their category names
$rows = Category::query()
    ->select('categories.name as category_name', 'products.name as product_name', 'products.price')
    ->join('products', 'categories.id', '=', 'products.category_id')
    ->get();
```

#### Left Join

```php
<?php

// LEFT JOIN: Get all categories, even those without products
$rows = Category::query()
    ->select('categories.name', 'products.name as product_name')
    ->leftJoin('products', 'categories.id', '=', 'products.category_id')
    ->get();
```

#### Right Join

```php
<?php

// RIGHT JOIN
$rows = Category::query()
    ->select('categories.name', 'products.name as product_name')
    ->rightJoin('products', 'categories.id', '=', 'products.category_id')
    ->get();
```

### Group By and Having

```php
<?php

// Count products per category
$rows = Category::query()
    ->select('categories.name', 'COUNT(products.id) as product_count')
    ->join('products', 'categories.id', '=', 'products.category_id')
    ->groupBy('categories.id', 'categories.name')
    ->get();
```

Use `having()` to filter grouped results:

```php
<?php

// Only categories with more than 5 products
$rows = Category::query()
    ->select('categories.name', 'COUNT(products.id) as product_count')
    ->join('products', 'categories.id', '=', 'products.category_id')
    ->groupBy('categories.id', 'categories.name')
    ->having('product_count', '>', 5)
    ->get();
```

### Raw Where Clauses

When you need a condition that the builder does not cover directly, use `whereRaw()`:

```php
<?php

// Custom SQL condition with parameter binding
$rows = Category::query()
    ->whereRaw('YEAR(created_at) = ?', [2025])
    ->get();

// Multiple raw conditions
$rows = Category::query()
    ->where('is_active', '=', 1)
    ->whereRaw('LENGTH(name) > ?', [3])
    ->get();
```

**Important:** Always pass user input through the bindings array (the second argument). Never concatenate values directly into the SQL string.

### Aggregate Functions

The query builder provides several aggregate methods:

```php
<?php

// Count all categories
$total = Category::query()->count();

// Count with a condition
$activeCount = Category::query()
    ->where('is_active', '=', 1)
    ->count();

// Sum, average, min, max (useful on numeric columns)
$totalPrice = Category::query()
    ->join('products', 'categories.id', '=', 'products.category_id')
    ->where('categories.slug', '=', 'electronics')
    ->sum('products.price');

$avgPrice = Category::query()
    ->join('products', 'categories.id', '=', 'products.category_id')
    ->avg('products.price');

$maxPrice = Category::query()
    ->join('products', 'categories.id', '=', 'products.category_id')
    ->max('products.price');

$minPrice = Category::query()
    ->join('products', 'categories.id', '=', 'products.category_id')
    ->min('products.price');
```

### Existence Checks

```php
<?php

// Check if any active categories exist
$hasActive = Category::query()
    ->where('is_active', '=', 1)
    ->exists(); // true or false

$noInactive = Category::query()
    ->where('is_active', '=', 0)
    ->doesntExist(); // true or false
```

### Transactions

Wrap multiple operations in a transaction to ensure atomicity:

```php
<?php

Category::query()->transaction(function ($query) {
    Category::create([
        'name' => 'Books',
        'slug' => 'books',
        'is_active' => 1,
    ]);

    Category::create([
        'name' => 'Fiction',
        'slug' => 'fiction',
        'parent_id' => 1,
        'is_active' => 1,
    ]);

    // If any operation throws an exception, both inserts are rolled back
});
```

---

## Step 5: Pagination

The query builder includes two pagination methods so you never have to calculate offsets manually.

### Full pagination with paginate()

`paginate()` runs a `COUNT(*)` query to determine the total number of rows, then fetches the correct slice:

```php
<?php

$perPage = 15;
$page    = 2;

$result = Category::query()
    ->where('is_active', '=', 1)
    ->orderBy('name', 'ASC')
    ->paginate($perPage, $page);
```

The return value is an associative array:

```php
[
    'data'         => [ /* array of row arrays */ ],
    'total'        => 47,    // total matching rows across all pages
    'per_page'     => 15,    // items per page (as requested)
    'current_page' => 2,     // the page you requested
    'last_page'    => 4,     // total number of pages
    'from'         => 16,    // index of the first item on this page
    'to'           => 30,    // index of the last item on this page
    'has_more'     => true,  // whether there are more pages after this one
]
```

### Working with paginated results

```php
<?php

$result = Category::query()
    ->where('is_active', '=', 1)
    ->orderBy('name', 'ASC')
    ->paginate(10, 1);

// Loop through the data
foreach ($result['data'] as $row) {
    echo $row['name'] . "\n";
}

// Display pagination info
echo "Showing {$result['from']} to {$result['to']} of {$result['total']} results\n";
echo "Page {$result['current_page']} of {$result['last_page']}\n";

// Check if there is a next page
if ($result['has_more']) {
    echo "Next page available\n";
}
```

### Simple pagination with simplePaginate()

If you do not need the total count (which avoids an extra `COUNT(*)` query), use `simplePaginate()`:

```php
<?php

$result = Category::query()
    ->orderBy('name', 'ASC')
    ->simplePaginate(10, 1);
```

The return value is a lighter array:

```php
[
    'data'         => [ /* array of row arrays */ ],
    'per_page'     => 10,
    'current_page' => 1,
    'has_more'     => true,  // whether there is at least one more page
]
```

Use `simplePaginate()` for "Load More" buttons or infinite scrolling where the total count is not needed.

### Pagination in a controller

A typical controller action that paginates results from a request:

```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use App\Models\Category;

class CategoryController
{
    public function index(Request $request): Response
    {
        $page    = (int) ($request->input('page') ?? 1);
        $perPage = 15;

        $result = Category::query()
            ->where('is_active', '=', 1)
            ->orderBy('name', 'ASC')
            ->paginate($perPage, $page);

        return Response::json($result);
    }
}
```

---

## Attribute Mutators

Mutators let you automatically transform attribute values when they are set on or retrieved from a model. This is useful for hashing passwords, formatting names, or sanitizing input.

### Set mutator (setter)

A set mutator is called automatically whenever you assign a value to the corresponding attribute. The method name follows the pattern `set{Field}Attribute`, where `{Field}` is the column name in PascalCase:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class User extends Model
{
    protected static string $table = 'users';

    protected array $fillable = ['name', 'email', 'password'];

    /**
     * Automatically hash the password when it is set.
     * Column name "password" becomes setPasswordAttribute().
     */
    protected function setPasswordAttribute(string $value): void
    {
        if (str_starts_with($value, '$2y$') || str_starts_with($value, '$argon2')) {
            // Already hashed, store as-is
            $this->attributes['password'] = $value;
        } else {
            // Hash the plain-text password
            $this->attributes['password'] = password_hash($value, PASSWORD_ARGON2ID);
        }
    }
}
```

Now every time you set the password, it is hashed automatically:

```php
<?php

$user = User::create([
    'name'     => 'alice',
    'email'    => 'alice@example.com',
    'password' => 'secret123', // Stored as an Argon2ID hash
]);

// Also works with direct assignment
$user->password = 'newpassword'; // Automatically hashed
$user->save();
```

### Get mutator (accessor)

A get mutator is called automatically whenever you read the attribute. The method name follows the pattern `get{Field}Attribute`:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class User extends Model
{
    protected static string $table = 'users';

    protected array $fillable = ['name', 'email', 'password'];

    /**
     * Always return the name with the first letter of each word capitalized.
     * Column name "name" becomes getNameAttribute().
     */
    protected function getNameAttribute(?string $value): string
    {
        return $value ? ucwords($value) : '';
    }
}
```

Now reading the name always returns a properly capitalized string:

```php
<?php

$user = User::find(1);
echo $user->name; // "Alice Johnson" (even if stored as "alice johnson")
```

### Naming convention for multi-word columns

For column names with underscores, remove the underscores and capitalize each word:

| Column Name | Set Mutator | Get Mutator |
|-------------|-------------|-------------|
| `name` | `setNameAttribute()` | `getNameAttribute()` |
| `password` | `setPasswordAttribute()` | `getPasswordAttribute()` |
| `first_name` | `setFirstNameAttribute()` | `getFirstNameAttribute()` |
| `is_active` | `setIsActiveAttribute()` | `getIsActiveAttribute()` |
| `created_at` | `setCreatedAtAttribute()` | `getCreatedAtAttribute()` |

### Combining set and get mutators

You can define both on the same field:

```php
<?php

class Category extends Model
{
    protected static string $table = 'categories';

    protected array $fillable = ['name', 'slug', 'description', 'parent_id', 'is_active'];

    /**
     * Always store the slug in lowercase with dashes.
     */
    protected function setSlugAttribute(string $value): void
    {
        $this->attributes['slug'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value), '-'));
    }

    /**
     * Always return the name with the first letter capitalized.
     */
    protected function getNameAttribute(?string $value): string
    {
        return $value ? ucfirst($value) : '';
    }
}
```

---

## Complete Example

Below is a complete `Category` model with CRUD, custom finders, query scopes, and attribute mutators, followed by usage examples for every operation covered in this guide.

### The model

Create the file `app/Models/Category.php`:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Category extends Model
{
    protected static string $table = 'categories';

    protected array $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'is_active',
    ];

    // ---------------------------------------------------------
    // Attribute Mutators
    // ---------------------------------------------------------

    /**
     * Auto-generate a URL-safe slug when setting the slug.
     */
    protected function setSlugAttribute(string $value): void
    {
        $this->attributes['slug'] = strtolower(
            trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value), '-')
        );
    }

    /**
     * Always return the name with the first letter capitalized.
     */
    protected function getNameAttribute(?string $value): string
    {
        return $value ? ucfirst($value) : '';
    }

    // ---------------------------------------------------------
    // Custom Finder Methods
    // ---------------------------------------------------------

    /**
     * Find a category by its slug.
     */
    public static function findBySlug(string $slug): ?static
    {
        $result = static::query()
            ->where('slug', '=', $slug)
            ->first();

        if ($result) {
            $instance = new static($result);
            $instance->exists = true;
            $instance->original = $result;
            return $instance;
        }

        return null;
    }

    // ---------------------------------------------------------
    // Relationships (manual)
    // ---------------------------------------------------------

    /**
     * Get all products in this category.
     */
    public function products(): array
    {
        return Product::where('category_id', '=', $this->getAttribute('id'))->get();
    }

    /**
     * Get child categories.
     */
    public function children(): array
    {
        return self::where('parent_id', '=', $this->getAttribute('id'))->get();
    }

    /**
     * Get the parent category.
     */
    public function parent(): ?array
    {
        $parentId = $this->getAttribute('parent_id');
        if (!$parentId) return null;
        $parent = self::find($parentId);
        return $parent ? $parent->toArray() : null;
    }

    // ---------------------------------------------------------
    // Query Scopes
    // ---------------------------------------------------------

    /**
     * Scope: only active categories.
     * Usage: Category::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    /**
     * Scope: only top-level (parent) categories.
     * Usage: Category::parents()->get()
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}
```

### Usage examples

```php
<?php

use App\Models\Category;

// ---------------------------------------------------------
// CREATE
// ---------------------------------------------------------

$electronics = Category::create([
    'name'        => 'Electronics',
    'slug'        => 'Electronics',       // mutator converts to "electronics"
    'description' => 'Phones, laptops, and accessories',
    'is_active'   => 1,
]);
echo $electronics->id; // new auto-increment ID

$phones = Category::create([
    'name'        => 'Phones',
    'slug'        => 'Phones & Tablets',  // mutator converts to "phones-tablets"
    'description' => 'Smartphones and feature phones',
    'parent_id'   => $electronics->id,
    'is_active'   => 1,
]);

// ---------------------------------------------------------
// READ
// ---------------------------------------------------------

// Find by primary key
$cat = Category::find(1);
echo $cat->name; // "Electronics" (accessor capitalizes first letter)

// Find by slug (custom finder)
$cat = Category::findBySlug('electronics');

// All records
$all = Category::all();
foreach ($all as $c) {
    echo $c->name . " - " . $c->slug . "\n";
}

// ---------------------------------------------------------
// UPDATE
// ---------------------------------------------------------

$cat = Category::find(1);
$cat->description = 'Updated description for electronics';
$cat->save();

// ---------------------------------------------------------
// DELETE
// ---------------------------------------------------------

$cat = Category::find(99);
if ($cat) {
    $cat->delete();
}

// ---------------------------------------------------------
// QUERY BUILDER -- Where Clauses
// ---------------------------------------------------------

// Simple where
$active = Category::query()
    ->where('is_active', '=', 1)
    ->get();

// Multiple conditions (AND)
$activeChildren = Category::query()
    ->where('is_active', '=', 1)
    ->where('parent_id', '=', $electronics->id)
    ->get();

// OR condition
$mixed = Category::query()
    ->where('is_active', '=', 1)
    ->orWhere('name', '=', 'Archived')
    ->get();

// IN / NOT IN
$specific = Category::query()
    ->whereIn('id', [1, 2, 3])
    ->get();

$excluded = Category::query()
    ->whereNotIn('id', [4, 5])
    ->get();

// NULL checks
$topLevel = Category::query()
    ->whereNull('parent_id')
    ->get();

$withParent = Category::query()
    ->whereNotNull('parent_id')
    ->get();

// BETWEEN
$recent = Category::query()
    ->whereBetween('created_at', '2025-01-01', '2025-12-31')
    ->get();

// Raw condition
$longNames = Category::query()
    ->whereRaw('LENGTH(name) > ?', [10])
    ->get();

// ---------------------------------------------------------
// QUERY BUILDER -- Ordering, Limiting, Selecting
// ---------------------------------------------------------

$sorted = Category::query()
    ->select('id', 'name', 'slug')
    ->where('is_active', '=', 1)
    ->orderBy('name', 'ASC')
    ->limit(10)
    ->get();

// Get first matching row
$first = Category::query()
    ->where('is_active', '=', 1)
    ->orderBy('name', 'ASC')
    ->first();

// ---------------------------------------------------------
// ADVANCED -- Joins
// ---------------------------------------------------------

$categoriesWithProducts = Category::query()
    ->select('categories.name as category', 'products.name as product', 'products.price')
    ->join('products', 'categories.id', '=', 'products.category_id')
    ->where('categories.is_active', '=', 1)
    ->orderBy('products.price', 'DESC')
    ->get();

// Left join (include categories with no products)
$allCategories = Category::query()
    ->select('categories.name', 'COUNT(products.id) as product_count')
    ->leftJoin('products', 'categories.id', '=', 'products.category_id')
    ->groupBy('categories.id', 'categories.name')
    ->orderBy('product_count', 'DESC')
    ->get();

// ---------------------------------------------------------
// ADVANCED -- Aggregates
// ---------------------------------------------------------

$totalCategories = Category::query()->count();

$activeCount = Category::query()
    ->where('is_active', '=', 1)
    ->count();

$exists = Category::query()
    ->where('slug', '=', 'electronics')
    ->exists(); // true

// ---------------------------------------------------------
// ADVANCED -- Query Scopes
// ---------------------------------------------------------

// Scopes are called as static methods and return a QueryBuilder
$active = Category::active()->get();
$parents = Category::parents()->orderBy('name', 'ASC')->get();

// Scopes can be chained with other query builder methods
$activeParents = Category::active()
    ->whereNull('parent_id')
    ->orderBy('name', 'ASC')
    ->get();

// ---------------------------------------------------------
// PAGINATION
// ---------------------------------------------------------

// Full pagination (includes total count)
$page1 = Category::query()
    ->where('is_active', '=', 1)
    ->orderBy('name', 'ASC')
    ->paginate(10, 1);

foreach ($page1['data'] as $row) {
    echo $row['name'] . "\n";
}
echo "Page {$page1['current_page']} of {$page1['last_page']}\n";
echo "Total: {$page1['total']}\n";

// Simple pagination (no total count, lighter query)
$page1Simple = Category::query()
    ->orderBy('name', 'ASC')
    ->simplePaginate(10, 1);

if ($page1Simple['has_more']) {
    echo "Load more available\n";
}

// ---------------------------------------------------------
// CONVERT TO ARRAY / JSON
// ---------------------------------------------------------

$cat = Category::find(1);
$array = $cat->toArray();   // associative array of all attributes
$json  = $cat->toJson();    // JSON string

// getAttribute / setAttribute
echo $cat->getAttribute('slug');               // "electronics"
$cat->setAttribute('description', 'New desc');
$cat->save();

// ---------------------------------------------------------
// RELATIONSHIPS (manual)
// ---------------------------------------------------------

$cat = Category::find(1);
$products = $cat->products();    // array of product rows
$children = $cat->children();    // array of child category rows
$parent   = $cat->parent();      // parent category array or null
```

### Quick Reference

| Operation | Code |
|-----------|------|
| Create | `Category::create([...])` |
| Find by ID | `Category::find($id)` |
| Find by column | `Category::query()->where('col', '=', $val)->first()` |
| All records | `Category::all()` |
| Update | `$model->name = 'New'; $model->save()` |
| Delete | `$model->delete()` |
| Count | `Category::query()->count()` |
| Exists | `Category::query()->where(...)->exists()` |
| Paginate | `Category::query()->paginate($perPage, $page)` |
| Simple paginate | `Category::query()->simplePaginate($perPage, $page)` |
| Order | `->orderBy('col', 'ASC')` |
| Limit | `->limit(10)->offset(20)` |
| Select | `->select('col1', 'col2')` |
| Join | `->join('table', 'a.id', '=', 'b.a_id')` |
| Left Join | `->leftJoin('table', 'a.id', '=', 'b.a_id')` |
| Group By | `->groupBy('col')` |
| Having | `->having('col', '>', $val)` |
| Where In | `->whereIn('col', [1, 2, 3])` |
| Where Null | `->whereNull('col')` |
| Where Between | `->whereBetween('col', $min, $max)` |
| Where Raw | `->whereRaw('SQL', [$binding])` |
| Transaction | `->transaction(function ($q) { ... })` |
| Set mutator | `setFieldAttribute($value)` |
| Get mutator | `getFieldAttribute($value)` |
| To array | `$model->toArray()` |
| To JSON | `$model->toJson()` |
