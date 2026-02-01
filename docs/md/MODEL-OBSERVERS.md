# Model Observers - Lifecycle Event Hooks

**Pattern:** Observer Pattern for Model Events
**Purpose:** Execute code automatically when models are created, updated, or deleted

---

## Table of Contents
- [Overview](#overview)
- [Available Lifecycle Events](#available-lifecycle-events)
- [Creating an Observer](#creating-an-observer)
- [Registering Observers](#registering-observers)
- [Complete Examples](#complete-examples)
- [Use Cases](#use-cases)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)

---

## Overview

Model Observers allow you to hook into model lifecycle events (create, update, delete) and execute custom logic automatically.

**Why Use Observers?**

Instead of scattering logic across controllers:
```php
// ❌ DON'T: Logic scattered everywhere
$user = new User($data);
$user->save();

// Send welcome email (duplicated in every controller)
Mail::send($user, 'Welcome!');

// Log activity (forgotten in some places)
activity()->log("User {$user->id} created");

// Update cache (inconsistent)
cache()->forget('users_list');
```

**Use Observers for centralized, automatic execution:**
```php
// ✅ DO: Observer handles all post-creation logic
$user = User::create($data);
// Welcome email sent automatically
// Activity logged automatically
// Cache cleared automatically
```

**Benefits:**
- ✅ Centralized logic (DRY principle)
- ✅ Automatic execution (can't forget)
- ✅ Consistent behavior across app
- ✅ Separation of concerns
- ✅ Easy testing

**Architecture:**
```
┌─────────────────────────────────────────────────────────┐
│              MODEL OBSERVER PATTERN                      │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Controller calls:                                       │
│  User::create($data)                                     │
│         │                                                │
│         ▼                                                │
│  ┌─────────────────────┐                                │
│  │   creating event    │  Before save to database       │
│  └─────────────────────┘                                │
│         │                                                │
│         ├─→ Observer::creating()                         │
│         │   - Validate data                              │
│         │   - Set defaults                               │
│         │   - Generate slugs                             │
│         │                                                │
│         ▼                                                │
│  ┌─────────────────────┐                                │
│  │   Save to DB        │                                │
│  └─────────────────────┘                                │
│         │                                                │
│         ▼                                                │
│  ┌─────────────────────┐                                │
│  │   created event     │  After save to database        │
│  └─────────────────────┘                                │
│         │                                                │
│         ├─→ Observer::created()                          │
│         │   - Send welcome email                         │
│         │   - Log activity                               │
│         │   - Clear cache                                │
│         │   - Trigger webhooks                           │
│         │                                                │
│         ▼                                                │
│  Return $user object                                     │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## Available Lifecycle Events

### Creation Events

**creating** - Before model is saved to database
- Use for: Validation, setting defaults, generating slugs
- Can prevent save by returning `false`

**created** - After model is saved to database
- Use for: Sending emails, logging, cache clearing
- Cannot prevent save (already happened)

### Update Events

**updating** - Before model changes are saved
- Use for: Validation, tracking changes
- Can prevent update by returning `false`

**updated** - After changes are saved
- Use for: Notifications, logging, cache invalidation

### Deletion Events

**deleting** - Before model is deleted
- Use for: Validation, cascade deletes
- Can prevent deletion by returning `false`

**deleted** - After model is deleted
- Use for: Cleanup, logging, cache clearing

---

## Creating an Observer

### Basic Observer Class

**File:** `app/Observers/UserObserver.php`

```php
<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "creating" event
     *
     * Called BEFORE user is saved to database
     *
     * @param User $user
     * @return bool|null Return false to cancel save
     */
    public function creating(User $user): ?bool
    {
        // Generate slug from name
        if (empty($user->slug)) {
            $user->slug = $this->generateSlug($user->name);
        }

        // Set default values
        if (empty($user->status)) {
            $user->status = 'active';
        }

        // Set registration date
        if (empty($user->registered_at)) {
            $user->registered_at = now()->format('Y-m-d H:i:s');
        }

        return true; // Allow save to proceed
    }

    /**
     * Handle the User "created" event
     *
     * Called AFTER user is saved to database
     *
     * @param User $user
     */
    public function created(User $user): void
    {
        // Send welcome email
        $this->sendWelcomeEmail($user);

        // Log activity
        activity('users')
            ->causedBy($user)
            ->log("New user registered: {$user->email}");

        // Clear user list cache
        cache()->forget('users_list');
        cache()->forget('users_count');

        // Trigger webhook for external systems
        $this->triggerWebhook('user.created', $user);
    }

    /**
     * Handle the User "updating" event
     *
     * Called BEFORE user changes are saved
     *
     * @param User $user
     * @return bool|null
     */
    public function updating(User $user): ?bool
    {
        // Prevent email changes without verification
        if ($user->isDirty('email') && !$user->email_verified_at) {
            logger()->warning("Attempted to change unverified email for user {$user->id}");
            return false; // Cancel update
        }

        // Update slug if name changed
        if ($user->isDirty('name')) {
            $user->slug = $this->generateSlug($user->name);
        }

        return true;
    }

    /**
     * Handle the User "updated" event
     *
     * Called AFTER user changes are saved
     *
     * @param User $user
     */
    public function updated(User $user): void
    {
        // Log changes
        $changes = $user->getDirty();
        activity('users')
            ->causedBy(auth()->user())
            ->withProperties(['changes' => $changes])
            ->log("User {$user->id} updated");

        // Clear user cache
        cache()->forget("user_{$user->id}");

        // Send notification if email changed
        if ($user->wasChanged('email')) {
            $this->sendEmailChangedNotification($user);
        }
    }

    /**
     * Handle the User "deleting" event
     *
     * Called BEFORE user is deleted
     *
     * @param User $user
     * @return bool|null
     */
    public function deleting(User $user): ?bool
    {
        // Prevent deletion of admin users
        if ($user->role === 'admin') {
            logger()->warning("Attempted to delete admin user {$user->id}");
            return false; // Cancel deletion
        }

        // Cascade delete related records
        $user->posts()->delete();
        $user->comments()->delete();

        return true;
    }

    /**
     * Handle the User "deleted" event
     *
     * Called AFTER user is deleted
     *
     * @param User $user
     */
    public function deleted(User $user): void
    {
        // Log deletion
        activity('users')
            ->causedBy(auth()->user())
            ->log("User {$user->email} deleted");

        // Clear cache
        cache()->forget("user_{$user->id}");
        cache()->forget('users_list');

        // Send deletion confirmation email
        $this->sendDeletionConfirmation($user);
    }

    /**
     * Generate URL-friendly slug
     */
    protected function generateSlug(string $name): string
    {
        return strtolower(str_replace(' ', '-', $name));
    }

    /**
     * Send welcome email to new user
     */
    protected function sendWelcomeEmail(User $user): void
    {
        dispatch(new \App\Jobs\SendWelcomeEmail($user));
    }

    /**
     * Send email changed notification
     */
    protected function sendEmailChangedNotification(User $user): void
    {
        // Implementation
    }

    /**
     * Send deletion confirmation
     */
    protected function sendDeletionConfirmation(User $user): void
    {
        // Implementation
    }

    /**
     * Trigger webhook for external integrations
     */
    protected function triggerWebhook(string $event, User $user): void
    {
        // Implementation
    }
}
```

---

## Registering Observers

### Method 1: In Model's boot() Method

**Recommended for model-specific observers**

```php
<?php

namespace App\Models;

use Core\Model\Model;
use App\Observers\UserObserver;

class User extends Model
{
    protected static string $table = 'users';

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        // Register observer
        static::observe(UserObserver::class);
    }
}
```

### Method 2: In Service Provider

**Recommended for multiple observers or application-wide setup**

**File:** `app/Providers/ObserverServiceProvider.php`

```php
<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Observers\UserObserver;
use App\Observers\ProductObserver;
use App\Observers\OrderObserver;

class ObserverServiceProvider
{
    /**
     * Register model observers
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Product::observe(ProductObserver::class);
        Order::observe(OrderObserver::class);
    }
}
```

**Register in bootstrap/app.php:**

```php
<?php

// Register observer service provider
$serviceProvider = new \App\Providers\ObserverServiceProvider();
$serviceProvider->boot();
```

---

## Complete Examples

### Example 1: Product Observer with Stock Tracking

```php
<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function creating(Product $product): ?bool
    {
        // Generate SKU if not provided
        if (empty($product->sku)) {
            $product->sku = $this->generateSKU($product);
        }

        // Set default stock quantity
        if (!isset($product->stock_quantity)) {
            $product->stock_quantity = 0;
        }

        return true;
    }

    public function created(Product $product): void
    {
        // Log product creation
        activity('products')
            ->causedBy(auth()->user())
            ->withProperties(['product' => $product->toArray()])
            ->log("New product created: {$product->name}");

        // Clear product cache
        cache()->tags(['products'])->flush();

        // Send notification to warehouse
        dispatch(new \App\Jobs\NotifyWarehouse('new_product', $product));
    }

    public function updating(Product $product): ?bool
    {
        // Track stock changes
        if ($product->isDirty('stock_quantity')) {
            $oldStock = $product->getOriginal('stock_quantity');
            $newStock = $product->stock_quantity;
            $difference = $newStock - $oldStock;

            // Log stock change
            activity('inventory')
                ->causedBy(auth()->user())
                ->withProperties([
                    'product_id' => $product->id,
                    'old_stock' => $oldStock,
                    'new_stock' => $newStock,
                    'difference' => $difference,
                ])
                ->log("Stock updated for product {$product->id}");

            // Check for low stock
            if ($newStock < 10 && $oldStock >= 10) {
                $this->sendLowStockAlert($product);
            }
        }

        return true;
    }

    public function updated(Product $product): void
    {
        // Clear product cache
        cache()->forget("product_{$product->id}");
        cache()->tags(['products'])->flush();
    }

    protected function generateSKU(Product $product): string
    {
        return 'PRD-' . strtoupper(substr($product->name, 0, 3)) . '-' . uniqid();
    }

    protected function sendLowStockAlert(Product $product): void
    {
        // Send email to warehouse manager
        dispatch(new \App\Jobs\SendLowStockAlert($product));
    }
}
```

### Example 2: Order Observer with Status Transitions

```php
<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function creating(Order $order): ?bool
    {
        // Generate order number
        if (empty($order->order_number)) {
            $order->order_number = $this->generateOrderNumber();
        }

        // Set default status
        if (empty($order->status)) {
            $order->status = 'pending';
        }

        // Calculate total
        $order->total = $this->calculateTotal($order);

        return true;
    }

    public function created(Order $order): void
    {
        // Send order confirmation email
        dispatch(new \App\Jobs\SendOrderConfirmation($order));

        // Log order creation
        activity('orders')
            ->causedBy($order->user_id)
            ->withProperties(['order' => $order->toArray()])
            ->log("Order {$order->order_number} created");

        // Update customer's order count
        $this->updateCustomerStats($order->user_id);
    }

    public function updating(Order $order): ?bool
    {
        // Track status changes
        if ($order->isDirty('status')) {
            $oldStatus = $order->getOriginal('status');
            $newStatus = $order->status;

            // Validate status transition
            if (!$this->isValidTransition($oldStatus, $newStatus)) {
                logger()->warning("Invalid status transition for order {$order->id}: {$oldStatus} -> {$newStatus}");
                return false; // Cancel update
            }

            // Set timestamp for status change
            switch ($newStatus) {
                case 'shipped':
                    $order->shipped_at = now()->format('Y-m-d H:i:s');
                    break;
                case 'delivered':
                    $order->delivered_at = now()->format('Y-m-d H:i:s');
                    break;
            }
        }

        return true;
    }

    public function updated(Order $order): void
    {
        // Check for status change
        if ($order->wasChanged('status')) {
            $oldStatus = $order->getOriginal('status');
            $newStatus = $order->status;

            // Log status change
            activity('orders')
                ->causedBy(auth()->id())
                ->withProperties([
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ])
                ->log("Order {$order->order_number} status changed: {$oldStatus} -> {$newStatus}");

            // Send status update email
            dispatch(new \App\Jobs\SendOrderStatusUpdate($order, $oldStatus, $newStatus));

            // If delivered, send feedback request
            if ($newStatus === 'delivered') {
                dispatch(new \App\Jobs\SendFeedbackRequest($order));
            }
        }

        // Clear order cache
        cache()->forget("order_{$order->id}");
    }

    protected function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    protected function calculateTotal(Order $order): float
    {
        // Calculate from order items (implementation depends on your structure)
        return $order->subtotal + $order->tax + $order->shipping;
    }

    protected function isValidTransition(string $from, string $to): bool
    {
        $validTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered', 'returned'],
            'delivered' => ['returned'],
        ];

        return in_array($to, $validTransitions[$from] ?? [], true);
    }

    protected function updateCustomerStats(int $userId): void
    {
        // Update customer statistics
    }
}
```

---

## Use Cases

### Use Case 1: Automatic Slug Generation

```php
public function creating(Product $product): ?bool
{
    if (empty($product->slug)) {
        $product->slug = $this->generateSlug($product->name);

        // Ensure uniqueness
        $count = 1;
        while (Product::where('slug', $product->slug)->exists()) {
            $product->slug = $this->generateSlug($product->name) . '-' . $count++;
        }
    }
    return true;
}
```

### Use Case 2: Cascade Deletes

```php
public function deleting(User $user): ?bool
{
    // Delete related records
    $user->posts()->delete();
    $user->comments()->delete();
    $user->orders()->update(['user_id' => null]);

    return true;
}
```

### Use Case 3: Cache Invalidation

```php
public function updated(Product $product): void
{
    // Clear specific product cache
    cache()->forget("product_{$product->id}");

    // Clear category cache if category changed
    if ($product->wasChanged('category_id')) {
        cache()->forget("category_{$product->category_id}_products");
        cache()->forget("category_{$product->getOriginal('category_id')}_products");
    }

    // Clear all products cache
    cache()->tags(['products'])->flush();
}
```

### Use Case 4: Audit Logging

```php
public function updated(User $user): void
{
    $changes = $user->getDirty();
    $original = $user->getOriginal();

    activity('audit')
        ->causedBy(auth()->user())
        ->performedOn($user)
        ->withProperties([
            'old' => array_intersect_key($original, $changes),
            'new' => $changes,
        ])
        ->log('User profile updated');
}
```

---

## Best Practices

### 1. Keep Observers Focused

**✅ DO:**
```php
class UserObserver
{
    public function created(User $user): void
    {
        $this->sendWelcomeEmail($user);
        $this->logCreation($user);
        $this->clearCache();
    }

    protected function sendWelcomeEmail(User $user): void { /* ... */ }
    protected function logCreation(User $user): void { /* ... */ }
    protected function clearCache(): void { /* ... */ }
}
```

**❌ DON'T:**
```php
public function created(User $user): void
{
    // 200 lines of mixed logic here
}
```

### 2. Use Queues for Slow Operations

**✅ DO:**
```php
public function created(User $user): void
{
    // Fast operations (sync)
    cache()->forget('users_count');

    // Slow operations (async)
    dispatch(new SendWelcomeEmail($user));
}
```

### 3. Handle Failures Gracefully

**✅ DO:**
```php
public function created(User $user): void
{
    try {
        $this->sendWelcomeEmail($user);
    } catch (\Exception $e) {
        logger()->error("Failed to send welcome email for user {$user->id}: {$e->getMessage()}");
        // Don't throw - allow model creation to succeed
    }
}
```

### 4. Avoid Circular Triggers

**❌ DON'T:**
```php
// UserObserver
public function updated(User $user): void
{
    $user->last_activity = now();
    $user->save(); // Triggers updated() again! Infinite loop!
}
```

**✅ DO:**
```php
public function updated(User $user): void
{
    if (!$user->isDirty('last_activity')) {
        $user->last_activity = now();
        $user->saveQuietly(); // Skip observer events
    }
}
```

---

## Troubleshooting

### Observer Not Firing

**Check:**
1. Observer is registered (`observe()` called)
2. Method names match event names (`creating`, `created`, etc.)
3. Model is using `Model` base class

**Debug:**
```php
public function created(User $user): void
{
    logger()->debug("UserObserver::created fired for user {$user->id}");
}
```

### Save Blocked by Observer

**Check return value of `creating`/`updating`/`deleting` methods:**
```php
public function creating(User $user): ?bool
{
    if (some_condition) {
        logger()->info("User creation blocked by observer");
        return false; // This blocks save
    }
    return true; // Allow save
}
```

---

## See Also

- **[DEV-MODELS.md](/docs/dev-models)** - Model basics and ORM
- **[DEV-MODEL-ADVANCED.md](/docs/dev-model-advanced)** - Advanced model features
- **[ACTIVITY-LOGGING.md](/docs/activity-logging)** - Audit trail logging
- **[DEV-EVENTS.md](/docs/dev-events)** - Event system overview

---

**Version:** 2.0.0
**Last Updated:** 2026-02-01
**Pattern:** Observer Pattern (Gang of Four)
