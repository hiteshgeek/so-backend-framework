# HasStatusField Trait Documentation

## Overview

The `HasStatusField` trait provides a flexible, reusable way to handle status fields across different models with non-standardized column names and status values.

### Problem It Solves

In many legacy databases, status fields are inconsistent:
- Different table names: `status`, `psid`, `ustatusid`, `order_status_id`
- Different "active" criteria: some use `status = 1`, others `status != 3`, etc.
- No standard way to query or check status across models

The `HasStatusField` trait solves this by providing:
- Configurable status field names per model
- Configurable active/inactive values per model
- Consistent query scopes across all models
- Helper methods for status checks and updates
- Type-safe, IDE-friendly API

---

## Installation

The trait is located at:
```
core/Model/Traits/HasStatusField.php
```

No additional installation required - it's ready to use!

---

## Basic Usage

### Step 1: Add Trait to Your Model

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Model\Traits\HasStatusField;

class Product extends Model
{
    use HasStatusField;  // Add this line

    protected static string $table = 'products';
}
```

### Step 2: Configure Status Field Settings

```php
class Product extends Model
{
    use HasStatusField;

    protected static string $table = 'products';

    // Configure the status field
    protected string $statusField = 'psid';            // Your status column name
    protected array $activeStatusValues = [1];         // What values mean "active"
    protected array $inactiveStatusValues = [2, 3];    // What values mean "inactive"
}
```

### Step 3: Use Status Methods

```php
// Query scopes
$activeProducts = Product::active()->get();
$inactiveProducts = Product::inactive()->get();
$specificStatus = Product::withStatus(1)->get();

// Instance methods
if ($product->isActive()) {
    echo "Product is available!";
}

$product->markAsInactive();
$product->save();
```

---

## Configuration Options

### `$statusField` (string)

The name of your status column in the database.

- **Default:** `'status'`

- **Examples:**
```php
protected string $statusField = 'psid';              // Product status ID
protected string $statusField = 'ustatusid';         // User status ID
protected string $statusField = 'order_status_id';   // Order status ID
protected string $statusField = 'status';            // Generic status
```

---

### `$activeStatusValues` (array)

An array of values that represent "active" status.

- **Default:** `[1]`

- **Examples:**
```php
// Single active value
protected array $activeStatusValues = [1];

// Multiple active values (e.g., orders in progress)
protected array $activeStatusValues = [1, 2, 3, 4];  // Pending, Processing, Shipped, Delivered

// Only one specific value
protected array $activeStatusValues = [10];
```

---

### `$inactiveStatusValues` (array)

An array of values that represent "inactive" status.

- **Default:** `[0]`

- **Examples:**
```php
// Single inactive value
protected array $inactiveStatusValues = [0];

// Multiple inactive values (e.g., deleted or suspended)
protected array $inactiveStatusValues = [2, 3];  // Suspended, Deleted

// Cancelled/Refunded orders
protected array $inactiveStatusValues = [5, 6];
```

---

### `$autoFilterInactive` (bool)

Whether to automatically exclude inactive records from ALL queries (similar to soft deletes).

- **Default:** `false`

- **Example:**
```php
// Don't auto-filter (default behavior)
protected bool $autoFilterInactive = false;

// Auto-filter inactive records (like soft deletes)
protected bool $autoFilterInactive = true;
```

- **Note:** Global scope auto-filtering is not yet implemented. Currently, you must explicitly use `active()` scope.

---

## Query Scopes

### `active()`

Get only active records.

```php
// Get all active users
$activeUsers = User::active()->get();

// Chain with other conditions
$admins = User::active()
    ->where('is_admin', '=', 1)
    ->get();

// Count active products
$count = Product::active()->count();
```

---

### `inactive()`

Get only inactive records.

```php
// Get all inactive users (suspended or deleted)
$inactiveUsers = User::inactive()->get();

// Get discontinued products
$discontinued = Product::inactive()->get();
```

---

### `withStatus($values)`

Get records with specific status value(s).

```php
// Single value
$pending = Order::withStatus(1)->get();

// Multiple values
$inProgress = Order::withStatus([1, 2, 3])->get();  // Pending, Processing, Shipped

// Chain with other conditions
$recentPending = Order::withStatus(1)
    ->where('created_at', '>', '2024-01-01')
    ->get();
```

---

### `withoutStatus($values)`

Get records excluding specific status value(s).

```php
// Exclude cancelled orders
$orders = Order::withoutStatus(5)->get();

// Exclude multiple statuses
$orders = Order::withoutStatus([5, 6])->get();  // Exclude cancelled and refunded
```

---

### `withInactive()`

Include inactive records when auto-filtering is enabled.

```php
// When autoFilterInactive = true
$allUsers = User::withInactive()->get();  // Includes suspended/deleted users
```

- **Note:** Currently has no effect since global scopes are not implemented.

---

### `onlyInactive()`

Get only inactive records (alias for `inactive()`).

```php
$inactiveUsers = User::onlyInactive()->get();
```

---

## Instance Methods

### `isActive()` : bool

Check if the record is active.

```php
$user = User::find(1);

if ($user->isActive()) {
    echo "User is active!";
} else {
    echo "User is inactive (suspended or deleted)";
}
```

---

### `isInactive()` : bool

Check if the record is inactive.

```php
$product = Product::find(123);

if ($product->isInactive()) {
    echo "Product is discontinued or out of stock";
}
```

---

### `markAsActive()` : self

Mark the record as active (sets to first active value).

- **Important:** You must call `save()` to persist the change!

```php
$user = User::find(1);
$user->markAsActive();
$user->save();  // Don't forget this!

// Or chain it
$user->markAsActive()->save();
```

---

### `markAsInactive()` : self

Mark the record as inactive (sets to first inactive value).

- **Important:** You must call `save()` to persist the change!

```php
$product = Product::find(123);
$product->markAsInactive();
$product->save();

// Or chain it
$product->markAsInactive()->save();
```

---

### `getStatusValue()` : mixed

Get the current status value.

```php
$user = User::find(1);
$statusValue = $user->getStatusValue();  // Returns 1, 2, 3, etc.

echo "User status ID: " . $statusValue;
```

---

### `setStatus($value)` : self

Set the status to a specific value.

- **Important:** You must call `save()` to persist the change!

```php
$order = Order::find(456);
$order->setStatus(3);  // Set to "Shipped"
$order->save();

// Or chain it
$order->setStatus(4)->save();  // Set to "Delivered"
```

---

### `getStatusName()` : string

Get a human-readable status name.

- **Default behavior:** Returns 'Active', 'Inactive', or 'Unknown'

- **Override in your model for custom labels:**

```php
class Order extends Model
{
    use HasStatusField;

    public function getStatusName(): string
    {
        return match ($this->getStatusValue()) {
            1 => 'Pending',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Refunded',
            default => 'Unknown',
        };
    }
}

// Usage
$order = Order::find(1);
echo $order->getStatusName();  // "Pending"
```

---

## Real-World Examples

### Example 1: User Model (auser table)

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Model\Traits\HasStatusField;

class User extends Model
{
    use HasStatusField;

    protected static string $table = 'auser';
    protected static string $primaryKey = 'uid';

    // Status configuration
    protected string $statusField = 'ustatusid';
    protected array $activeStatusValues = [1];         // Active
    protected array $inactiveStatusValues = [2, 3];    // Suspended, Deleted

    // Usage examples:
    // User::active()->get()              → WHERE ustatusid = 1
    // User::inactive()->get()            → WHERE ustatusid IN (2, 3)
    // $user->isActive()                  → Check if ustatusid = 1
    // $user->markAsInactive()->save()    → Set ustatusid = 2
}
```

- **Query Examples:**
```php
// Get all active users
$activeUsers = User::active()->get();

// Get all admins who are active
$activeAdmins = User::active()
    ->where('is_admin', '=', 1)
    ->get();

// Check if user is active
$user = User::find(123);
if ($user->isActive()) {
    // Allow login
} else {
    // Deny access (suspended or deleted)
}

// Suspend a user
$user->setStatus(2)->save();  // Set to suspended

// Reactivate a user
$user->markAsActive()->save();
```

---

### Example 2: Product Model (products table)

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Model\Traits\HasStatusField;

class Product extends Model
{
    use HasStatusField;

    protected static string $table = 'products';
    protected static string $primaryKey = 'pid';

    // Status configuration
    protected string $statusField = 'psid';
    protected array $activeStatusValues = [1];         // Active/Available
    protected array $inactiveStatusValues = [2, 3];    // Out of stock, Discontinued

    /**
     * Custom status names
     */
    public function getStatusName(): string
    {
        return match ($this->getStatusValue()) {
            1 => 'Active',
            2 => 'Out of Stock',
            3 => 'Discontinued',
            default => 'Unknown',
        };
    }

    /**
     * Custom scope combining status and stock
     */
    public function scopeAvailableForSale($query)
    {
        return $query->active()
            ->where('stock_quantity', '>', 0);
    }
}
```

- **Query Examples:**
```php
// Get all active products
$activeProducts = Product::active()->get();

// Get products available for sale (active AND in stock)
$available = Product::availableForSale()->get();

// Mark product as discontinued
$product = Product::find(456);
$product->setStatus(3)->save();

// Display status to user
echo $product->getStatusName();  // "Discontinued"
```

---

### Example 3: Order Model (orders table)

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Model\Traits\HasStatusField;

class Order extends Model
{
    use HasStatusField;

    protected static string $table = 'orders';
    protected static string $primaryKey = 'order_id';

    // Status configuration
    protected string $statusField = 'order_status_id';
    protected array $activeStatusValues = [1, 2, 3, 4];  // In progress
    protected array $inactiveStatusValues = [5, 6];      // Cancelled/Refunded

    /**
     * Custom status names
     */
    public function getStatusName(): string
    {
        return match ($this->getStatusValue()) {
            1 => 'Pending',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Refunded',
            default => 'Unknown',
        };
    }

    /**
     * Custom scopes for specific order states
     */
    public function scopePendingShipment($query)
    {
        return $query->withStatus([1, 2]);  // Pending or Processing
    }

    public function scopeShipped($query)
    {
        return $query->withStatus([3, 4]);  // Shipped or Delivered
    }
}
```

- **Query Examples:**
```php
// Get all active orders (in progress)
$activeOrders = Order::active()->get();

// Get orders pending shipment
$pendingShipment = Order::pendingShipment()->get();

// Get cancelled orders
$cancelled = Order::withStatus([5, 6])->get();

// Update order status to shipped
$order = Order::find(789);
$order->setStatus(3)->save();

// Check if order is still active
if ($order->isActive()) {
    echo "Order is still being processed";
}
```

---

## Combining with Other Scopes

The status scopes work seamlessly with your existing query builder methods:

```php
// Combine with where clauses
$recentActiveUsers = User::active()
    ->where('created_at', '>', '2024-01-01')
    ->get();

// Combine with joins
$activeUsersWithOrders = User::active()
    ->join('orders', 'users.uid', '=', 'orders.customer_id')
    ->get();

// Combine with ordering and limiting
$topActiveProducts = Product::active()
    ->orderBy('sales_count', 'DESC')
    ->limit(10)
    ->get();

// Combine multiple status conditions
$ordersInTransit = Order::withStatus([2, 3])  // Processing or Shipped
    ->where('created_at', '>', date('Y-m-d', strtotime('-7 days')))
    ->get();
```

---

## Best Practices

### 1. Always Define Status Configuration

```php
// **GOOD - Explicit configuration
protected string $statusField = 'ustatusid';
protected array $activeStatusValues = [1];
protected array $inactiveStatusValues = [2, 3];

// **BAD - Relying on defaults (may not match your table)
// (no configuration - uses 'status' field with values [1] and [0])
```

---

### 2. Use Scopes for Queries

```php
// **GOOD - Using scopes
$activeUsers = User::active()->get();

// **BAD - Manual where clauses
$activeUsers = User::where('ustatusid', '=', 1)->get();
```

- Why?** Scopes are:
- More readable
- Reusable across your codebase
- Easier to maintain (change status logic in one place)
- Type-safe and IDE-friendly

---

### 3. Remember to Call save()

```php
// **GOOD - Save after marking
$user->markAsInactive();
$user->save();

// **BAD - Forgetting to save
$user->markAsInactive();  // Change not persisted!
```

---

### 4. Override getStatusName() for Better UX

```php
// **GOOD - Custom status names
public function getStatusName(): string
{
    return match ($this->getStatusValue()) {
        1 => 'Pending Payment',
        2 => 'Processing Order',
        3 => 'Shipped',
        4 => 'Delivered',
        5 => 'Cancelled by Customer',
        6 => 'Refunded',
        default => 'Unknown Status',
    };
}

// **BAD - Using default generic names
// Returns only: 'Active', 'Inactive', or 'Unknown'
```

---

### 5. Create Custom Scopes for Business Logic

```php
class Order extends Model
{
    use HasStatusField;

    // **GOOD - Business logic in scopes
    public function scopeRequiresAction($query)
    {
        return $query->withStatus([1, 2])  // Pending or Processing
            ->where('created_at', '<', date('Y-m-d', strtotime('-3 days')));
    }

    public function scopeCompletedThisMonth($query)
    {
        return $query->withStatus(4)  // Delivered
            ->where('created_at', '>=', date('Y-m-01'));
    }
}

// Usage
$ordersNeedingAttention = Order::requiresAction()->get();
```

---

## Troubleshooting

### Issue: "No active status values defined"

- **Error:**
```
RuntimeException: No active status values defined for App\Models\User
```

- **Solution:**
Define `$activeStatusValues` in your model:

```php
protected array $activeStatusValues = [1];
```

---

### Issue: Scope not working

- **Problem:**
```php
$users = User::active()->get();  // Returns all users, not just active
```

- **Check:**
  - Is the trait imported?
```php
use Core\Model\Traits\HasStatusField;
```
  - Is the trait used in the class?
```php
class User extends Model
{
    use HasStatusField;  // Add this
}
```
  - Is `$statusField` configured correctly?
```php
protected string $statusField = 'ustatusid';  // Match your database column
```

---

### Issue: markAsActive() not persisting

- **Problem:**
```php
$user->markAsActive();
// Status not saved to database
```

- **Solution:**
Always call `save()` after marking:

```php
$user->markAsActive();
$user->save();  // ← Don't forget this!

// Or chain it
$user->markAsActive()->save();
```

---

## Advanced Usage

### Conditional Status Filtering

```php
// Apply status filter based on user input
$showInactive = $request->input('show_inactive', false);

$products = Product::query()
    ->when(!$showInactive, function ($query) {
        return $query->active();
    })
    ->get();
```

---

### Status Transitions with Validation

```php
class Order extends Model
{
    use HasStatusField;

    /**
     * Validate and perform status transition
     */
    public function transitionTo(int $newStatus): bool
    {
        $currentStatus = $this->getStatusValue();

        // Define allowed transitions
        $allowedTransitions = [
            1 => [2],        // Pending → Processing
            2 => [3, 5],     // Processing → Shipped or Cancelled
            3 => [4, 6],     // Shipped → Delivered or Refunded
        ];

        if (!isset($allowedTransitions[$currentStatus])) {
            return false;
        }

        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return false;
        }

        $this->setStatus($newStatus);
        return $this->save();
    }
}

// Usage
$order = Order::find(1);
if ($order->transitionTo(3)) {  // Transition to Shipped
    echo "Order status updated!";
} else {
    echo "Invalid status transition!";
}
```

---

## When to Use This Trait

Deciding whether to use `HasStatusField` depends on your database structure and requirements.

### Use HasStatusField When:

✅ **Legacy Database with Non-Standard Column Names**
- Your status column isn't named `status` (e.g., `psid`, `ustatusid`, `order_status_id`)
- Different tables use different column names for similar concepts
- You're integrating with an existing database schema you can't change

✅ **Complex Status Logic**
- Multiple values represent "active" (e.g., both `1` and `2` mean active)
- Multiple values represent "inactive" (e.g., `3`, `4`, `5` all mean inactive)
- Status logic is business-domain specific

✅ **Need Consistent API Across Models**
- Want `User::active()`, `Product::active()`, `Order::active()` to all work the same way
- Different models have different status columns but similar logic
- Team needs consistent patterns

✅ **Frequent Status Queries**
- You query by status often throughout your codebase
- Want to avoid repeating `where('status_column', '=', value)` everywhere
- Need DRY (Don't Repeat Yourself) compliance

**Example Scenario:**
```php
// Legacy database with inconsistent status columns
class User extends Model
{
    use HasStatusField;
    protected string $statusField = 'ustatusid';       // User table: ustatusid
    protected array $activeStatusValues = [1];
}

class Product extends Model
{
    use HasStatusField;
    protected string $statusField = 'psid';            // Product table: psid
    protected array $activeStatusValues = [1, 2, 3];   // Active has multiple values
}

// Now both work the same way
$users = User::active()->get();
$products = Product::active()->get();
```

### DON'T Use HasStatusField When:

❌ **Simple Standard Status Column**
- Your column is named `status`
- Active = `1` or `'active'`, Inactive = `0` or `'inactive'`
- Simple boolean-like logic

**Alternative: Use direct queries**
```php
// Simpler without trait for standard cases
$active = Product::where('status', '=', 'active')->get();
$inactive = Product::where('status', '=', 'inactive')->get();
```

❌ **Single Model Usage**
- Only one model needs status filtering
- No other models will use similar logic
- Trait adds unnecessary abstraction

**Alternative: Add methods directly to the model**
```php
class Product extends Model
{
    public static function active()
    {
        return static::where('status', '=', 'active');
    }
}
```

❌ **State Machine Requirements**
- Need complex state transitions (draft → pending → approved → published)
- Need validation for allowed transitions
- Need callbacks on state changes

**Alternative: Use a dedicated state machine library**
```php
// For complex workflows, use state machine pattern
class Order extends Model
{
    protected $stateMachine = [
        'pending' => ['processing', 'cancelled'],
        'processing' => ['shipped', 'cancelled'],
        'shipped' => ['delivered'],
        // ...
    ];
}
```

❌ **Enum-Based Status (PHP 8.1+)**
- Using modern PHP enums for type safety
- Want IDE autocomplete for status values
- Need compile-time validation

**Alternative: Use PHP Enums**
```php
enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
}

class Order extends Model
{
    protected $casts = ['status' => OrderStatus::class];
}
```

### Comparison Matrix

| Scenario | HasStatusField Trait | Manual Where Clauses | Enums | State Machine |
|----------|---------------------|---------------------|-------|---------------|
| **Legacy non-standard columns** | ✅ Perfect fit | ⚠️ Repetitive | ❌ Still need column mapping | ⚠️ Overkill |
| **Standard `status` column** | ⚠️ Unnecessary | ✅ Simple & direct | ✅ Type-safe | ❌ Overkill |
| **Multiple models same logic** | ✅ DRY & consistent | ❌ Copy-paste | ⚠️ Per-model enums | ⚠️ Per-model machines |
| **Complex state transitions** | ❌ Too simple | ❌ Too simple | ❌ Too simple | ✅ Designed for this |
| **Active/Inactive only** | ✅ Perfect fit | ✅ Works fine | ⚠️ Overkill | ❌ Overkill |
| **Many status values (10+)** | ✅ Handles well | ❌ Messy queries | ✅ Type-safe | ✅ Organized |

### Real-World Example: Choosing the Right Approach

**Scenario 1: E-commerce with Legacy DB**
```php
// ✅ USE TRAIT: Non-standard columns, multiple models
class Product extends Model
{
    use HasStatusField;
    protected string $statusField = 'psid';
    protected array $activeStatusValues = [1, 2, 3];  // active, featured, sale
    protected array $inactiveStatusValues = [4, 5];    // out_of_stock, discontinued
}
```

**Scenario 2: New Application with Standard Schema**
```php
// ✅ DON'T USE TRAIT: Simple standard column
class Post extends Model
{
    // Just use direct queries
    public static function published()
    {
        return static::where('status', '=', 'published');
    }
}
```

**Scenario 3: Complex Order Workflow**
```php
// ✅ DON'T USE TRAIT: Need state machine
class Order extends Model
{
    // Use state machine library for complex transitions
    protected $states = [
        'draft' => ['pending'],
        'pending' => ['processing', 'cancelled'],
        'processing' => ['packed', 'cancelled'],
        'packed' => ['shipped'],
        'shipped' => ['in_transit', 'returned'],
        'in_transit' => ['delivered', 'returned'],
        // ...
    ];
}
```

### Best Practices

**DO:**
- Configure all three properties (`$statusField`, `$activeStatusValues`, `$inactiveStatusValues`)
- Use descriptive variable names for status values
- Document what each status value means in model comments
- Test status queries thoroughly

**DON'T:**
- Mix trait scopes with manual `where` clauses for the same field
- Change status configuration without updating existing data
- Use trait for simple boolean fields (use standard columns instead)
- Forget to set `$autoFilterInactive = false` if you need inactive records by default

---

## Migration Guide

### Migrating from Manual Where Clauses

- **Before:**
```php
// Old code
$activeUsers = User::where('ustatusid', '=', 1)->get();
$inactiveUsers = User::whereIn('ustatusid', [2, 3])->get();

// Check status manually
if ($user->ustatusid == 1) {
    // User is active
}
```

- **After:**
```php
// New code with trait
$activeUsers = User::active()->get();
$inactiveUsers = User::inactive()->get();

// Check status with helper
if ($user->isActive()) {
    // User is active
}
```

- **Steps:**
  1. Add `use HasStatusField` trait to model
  2. Configure `$statusField`, `$activeStatusValues`, `$inactiveStatusValues`
  3. Replace manual where clauses with scopes
  4. Replace manual status checks with `isActive()` / `isInactive()`

---

## Summary

The `HasStatusField` trait provides:

- **Flexible Configuration** - Each model defines its own status field and values
- **Consistent API** - Same methods work across all models
- **Readable Code** - `User::active()` is clearer than `User::where('ustatusid', '=', 1)`
- **Maintainable** - Change status logic in one place
- **Type-Safe** - IDE autocomplete and type hints
- **Battle-Tested** - Based on proven patterns from Laravel and other frameworks

- **Get Started:**
  1. Add `use HasStatusField` to your model
  2. Configure `$statusField`, `$activeStatusValues`, `$inactiveStatusValues`
  3. Start using `::active()`, `::inactive()`, and other methods!

---

**Questions or Issues?**
Check the trait source code at `core/Model/Traits/HasStatusField.php` for implementation details.
