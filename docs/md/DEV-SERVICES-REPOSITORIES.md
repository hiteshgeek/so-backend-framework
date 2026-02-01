# Service Layer & Repository Pattern - Developer Guide

**SO Framework** | **Clean Architecture** | **Version 1.0**

A comprehensive guide to organizing business logic using the Service Layer pattern and data access using the Repository pattern for maintainable, testable applications.

---

## Table of Contents

1. [Overview](#overview)
2. [Service Layer](#service-layer)
3. [Repository Pattern](#repository-pattern)
4. [Dependency Injection](#dependency-injection)
5. [Complete Example](#complete-example)
6. [Best Practices](#best-practices)

---

## Overview

As applications grow, controllers become bloated with business logic and database queries. The Service Layer and Repository patterns solve this by separating concerns:

- **Controllers** -- Handle HTTP requests/responses only
- **Services** -- Contain business logic and orchestration
- **Repositories** -- Handle database queries and data access
- **Models** -- Represent database tables

```
Request -> Controller -> Service -> Repository -> Database
                          |
                          v
                       Events
                       Mail
                       Queue
```

### Benefits

- **Testability** -- Test business logic without HTTP or database
- **Reusability** -- Use same service in web, API, CLI contexts
- **Maintainability** -- Each class has one responsibility
- **Flexibility** -- Swap implementations (e.g., different databases)

---

## Service Layer

Services contain business logic: validation, calculations, orchestration of multiple operations, and side effects like sending emails.

### Creating a Service

```bash
./sixorbit make:service ProductService
```

Creates `app/Services/ProductService.php`:

```php
<?php

namespace App\Services;

class ProductService
{
    /**
     * Get all products
     */
    public function getAll(): array
    {
        // Implementation
        return [];
    }

    /**
     * Create a new product
     */
    public function create(array $data): array
    {
        // Validation
        // Creation logic
        return [];
    }
}
```

### Service Example

```php
<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Events\ProductCreated;
use Core\Validation\Validator;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    /**
     * Get all products
     */
    public function getAll(): array
    {
        return $this->productRepository->all();
    }

    /**
     * Create a product
     */
    public function create(array $data): Product
    {
        // 1. Validate
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException('Validation failed');
        }

        // 2. Create product
        $product = $this->productRepository->create($data);

        // 3. Fire event
        event(new ProductCreated($product->id));

        // 4. Clear cache
        cache()->forget('products.all');

        return $product;
    }

    /**
     * Calculate discounted price
     */
    public function calculateDiscount(Product $product, int $percentage): float
    {
        if ($percentage < 0 || $percentage > 100) {
            throw new \InvalidArgumentException('Invalid discount percentage');
        }

        return $product->price * (1 - $percentage / 100);
    }

    /**
     * Check if product is low stock
     */
    public function isLowStock(Product $product): bool
    {
        return $product->stock < 10;
    }

    /**
     * Bulk update prices
     */
    public function updatePrices(int $categoryId, float $multiplier): int
    {
        return $this->productRepository->updatePricesByCategory($categoryId, $multiplier);
    }
}
```

### Using Services in Controllers

```php
<?php

namespace App\Controllers;

use App\Services\ProductService;
use Core\Http\Request;
use Core\Http\Response;

class ProductController
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(Request $request): Response
    {
        $products = $this->productService->getAll();

        return json($products);
    }

    public function store(Request $request): Response
    {
        try {
            $product = $this->productService->create($request->all());

            return json($product, 201);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 422);
        }
    }
}
```

---

## Repository Pattern

Repositories handle all database queries for a specific model. They provide a clean API for data access.

### Creating a Repository

```bash
./sixorbit make:repository ProductRepository
```

Creates `app/Repositories/ProductRepository.php`:

```php
<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function all(): array
    {
        return Product::all();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $product = $this->find($id);
        return $product ? $product->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);
        return $product ? $product->delete() : false;
    }
}
```

### Complete Repository Example

```php
<?php

namespace App\Repositories;

use App\Models\Product;
use Core\Database\DB;

class ProductRepository
{
    /**
     * Find product by ID
     */
    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Get all products
     */
    public function all(): array
    {
        return Product::all();
    }

    /**
     * Get paginated products
     */
    public function paginate(int $perPage = 15, int $page = 1): array
    {
        return Product::paginate($perPage, $page);
    }

    /**
     * Find by category
     */
    public function findByCategory(int $categoryId): array
    {
        return Product::where('category_id', $categoryId)->get();
    }

    /**
     * Search products
     */
    public function search(string $query): array
    {
        $escaped = str_replace(['%', '_'], ['\%', '\_'], $query);

        return DB::table('products')
            ->where('name', 'LIKE', "%{$escaped}%")
            ->orWhere('description', 'LIKE', "%{$escaped}%")
            ->get();
    }

    /**
     * Get low stock products
     */
    public function getLowStock(int $threshold = 10): array
    {
        return Product::where('stock', '<', $threshold)->get();
    }

    /**
     * Create product
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Update product
     */
    public function update(int $id, array $data): bool
    {
        $product = $this->find($id);

        if (!$product) {
            return false;
        }

        return $product->update($data);
    }

    /**
     * Delete product
     */
    public function delete(int $id): bool
    {
        $product = $this->find($id);

        if (!$product) {
            return false;
        }

        return $product->delete();
    }

    /**
     * Update prices by category
     */
    public function updatePricesByCategory(int $categoryId, float $multiplier): int
    {
        return DB::table('products')
            ->where('category_id', $categoryId)
            ->update([
                'price' => DB::raw("price * {$multiplier}")
            ]);
    }

    /**
     * Get featured products
     */
    public function getFeatured(int $limit = 10): array
    {
        return Product::where('featured', true)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }
}
```

---

## Dependency Injection

Inject repositories into services, and services into controllers.

### Manual Injection

```php
class ProductController
{
    protected ProductService $productService;

    public function __construct()
    {
        $productRepository = new ProductRepository();
        $this->productService = new ProductService($productRepository);
    }
}
```

### Service Container (Recommended)

Register in `bootstrap/app.php`:

```php
// Bind repositories
$app->singleton(\App\Repositories\ProductRepository::class, function() {
    return new \App\Repositories\ProductRepository();
});

// Bind services
$app->singleton(\App\Services\ProductService::class, function($app) {
    return new \App\Services\ProductService(
        $app->make(\App\Repositories\ProductRepository::class)
    );
});
```

Then use in controllers:

```php
class ProductController
{
    public function __construct(
        protected ProductService $productService
    ) {}
}
```

---

## Complete Example

### Scenario: Order Management System

**Repository:**

```php
<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function find(int $id): ?Order
    {
        return Order::find($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function findByUser(int $userId): array
    {
        return Order::where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $order = $this->find($id);
        return $order ? $order->update(['status' => $status]) : false;
    }

    public function getTotalRevenue(): float
    {
        return DB::table('orders')
            ->where('status', 'completed')
            ->sum('total');
    }
}
```

**Service:**

```php
<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Events\OrderPlaced;
use Core\Validation\Validator;

class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected ProductRepository $productRepository
    ) {}

    public function create(int $userId, array $items): Order
    {
        // 1. Validate items
        $total = 0;
        foreach ($items as $item) {
            $product = $this->productRepository->find($item['product_id']);

            if (!$product) {
                throw new \InvalidArgumentException("Product {$item['product_id']} not found");
            }

            if ($product->stock < $item['quantity']) {
                throw new \InvalidArgumentException("Insufficient stock for {$product->name}");
            }

            $total += $product->price * $item['quantity'];
        }

        // 2. Create order
        $order = $this->orderRepository->create([
            'user_id' => $userId,
            'total' => $total,
            'status' => 'pending',
        ]);

        // 3. Attach items
        foreach ($items as $item) {
            DB::table('order_items')->insert([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        // 4. Update inventory
        foreach ($items as $item) {
            $product = $this->productRepository->find($item['product_id']);
            $product->update(['stock' => $product->stock - $item['quantity']]);
        }

        // 5. Fire event
        event(new OrderPlaced($order->id));

        return $order;
    }

    public function cancel(int $orderId): bool
    {
        $order = $this->orderRepository->find($orderId);

        if (!$order) {
            throw new \InvalidArgumentException('Order not found');
        }

        if ($order->status !== 'pending') {
            throw new \InvalidArgumentException('Only pending orders can be cancelled');
        }

        return $this->orderRepository->updateStatus($orderId, 'cancelled');
    }
}
```

**Controller:**

```php
<?php

namespace App\Controllers;

use App\Services\OrderService;
use Core\Http\Request;
use Core\Http\Response;

class OrderController
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function store(Request $request): Response
    {
        try {
            $order = $this->orderService->create(
                auth()->id(),
                $request->input('items')
            );

            return json($order, 201);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 422);
        }
    }

    public function cancel(Request $request, int $id): Response
    {
        try {
            $this->orderService->cancel($id);
            return json(['message' => 'Order cancelled']);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 422);
        }
    }
}
```

---

## Best Practices

### 1. Keep Controllers Thin

Controllers should only handle HTTP:

```php
// Bad - business logic in controller
public function store(Request $request): Response
{
    $validator = Validator::make($request->all(), [...]);
    if ($validator->fails()) { ... }

    $product = Product::create($request->all());
    event(new ProductCreated($product->id));
    cache()->forget('products');

    return json($product);
}

// Good - delegate to service
public function store(Request $request): Response
{
    $product = $this->productService->create($request->all());
    return json($product);
}
```

### 2. Keep Services Focused

One service per entity or domain:

```php
// Good
ProductService
OrderService
UserService

// Bad
ShopService // Too broad - handles products, orders, users?
```

### 3. Repositories Return Models, Services Return Business Objects

```php
// Repository - returns models
public function find(int $id): ?Product { ... }

// Service - may return DTOs, formatted data, or models
public function getProductDetails(int $id): array
{
    $product = $this->productRepository->find($id);
    return [
        'id' => $product->id,
        'name' => $product->name,
        'discounted_price' => $this->calculateDiscount($product),
        'is_low_stock' => $this->isLowStock($product),
    ];
}
```

### 4. Don't Skip Repositories

Always use repositories, even for simple queries:

```php
// Bad - controller queries database directly
public function index()
{
    $products = Product::all();
}

// Good - uses repository
public function index()
{
    $products = $this->productService->getAll();
}
```

### 5. Use Interface for Flexibility

Define repository interfaces for easier testing and swapping:

```php
interface ProductRepositoryInterface
{
    public function find(int $id): ?Product;
    public function all(): array;
    public function create(array $data): Product;
}

class ProductRepository implements ProductRepositoryInterface
{
    // Implementation
}

class CachedProductRepository implements ProductRepositoryInterface
{
    // Cached implementation
}
```

---

## Quick Reference

### Architecture Layers

| Layer | Responsibility | Example |
|-------|---------------|---------|
| **Controller** | HTTP handling | Parse request, return response |
| **Service** | Business logic | Validation, calculations, orchestration |
| **Repository** | Data access | Database queries |
| **Model** | Data representation | Table structure, relationships |

### When to Use Each

| Pattern | Use When |
|---------|----------|
| **Service** | Business logic, multiple operations, complex workflows |
| **Repository** | Database queries, data access abstraction |
| **Direct Model** | Simple CRUD in prototypes (not recommended for production) |

---

**Related Documentation:**
- [Models](/docs/dev/models) - Working with models
- [Validation](/docs/validation) - Validating input
- [Events](/docs/dev/events) - Triggering side effects
- [Dependency Injection](/docs/di) - Service container

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
