# Activity Logging System

**Complete Audit Trail for Compliance and Security**

The Activity Logging system provides comprehensive tracking of all model changes and user actions in your ERP application. Essential for GDPR, SOX, HIPAA compliance and dispute resolution.

---

## Table of Contents

1. [Introduction](#introduction)
2. [Quick Start](#quick-start)
3. [Architecture](#architecture)
4. [Automatic Logging](#automatic-logging)
5. [Manual Logging](#manual-logging)
6. [Retrieving Activity](#retrieving-activity)
7. [Configuration](#configuration)
8. [Advanced Topics](#advanced-topics)
9. [ERP Use Cases](#erp-use-cases)
10. [Best Practices](#best-practices)

---

## Introduction

### What is Activity Logging?

Activity logging creates an immutable audit trail of:
- **WHO** performed an action (user identification)
- **WHAT** changed (model and attributes)
- **WHEN** it happened (timestamp)
- **WHERE** (IP address, context)
- **Before/After values** (complete change history)

### Why Critical for ERP?

**Compliance Requirements**:
- GDPR: Track all personal data access and modifications
- SOX: Financial transaction audit trail
- HIPAA: Healthcare data access logging
- ISO 27001: Security audit requirements

**Business Benefits**:
- Dispute resolution with complete history
- Security audits and breach investigation
- User accountability and transparency
- Change tracking for critical data

---

## Quick Start

### Step 1: Enable Logging on Model

Add the `LogsActivity` trait to any model you want to track:

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\ActivityLog\LogsActivity;

class User extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'email', 'status'];
}
```

That's it! All create, update, and delete operations are now automatically logged.

### Step 2: View Activity Logs

```php
// Get all activity for a user
$activities = DB::table('activity_log')
    ->where('subject_type', 'App\\Models\\User')
    ->where('subject_id', 1)
    ->orderBy('created_at', 'DESC')
    ->get();

foreach ($activities as $activity) {
    echo "{$activity['description']} at {$activity['created_at']}\n";
    echo "Changes: " . $activity['properties'] . "\n";
}
```

### Step 3: Manual Logging (Optional)

Log custom actions using the fluent API:

```php
activity()
    ->performedOn($invoice)
    ->causedBy($user)
    ->withProperties(['amount' => 1000, 'payment_method' => 'credit_card'])
    ->log('Invoice paid');
```

---

## Architecture

### Components

**1. ActivityLogger** (`core/ActivityLog/ActivityLogger.php`)
- Main logging service with fluent API
- Handles both automatic and manual logging
- Stores logs in `activity_log` table

**2. LogsActivity Trait** (`core/ActivityLog/LogsActivity.php`)
- Added to models for automatic logging
- Hooks into model events (created, updated, deleted)
- Configurable attributes to log

**3. ActivityLogObserver** (`core/ActivityLog/ActivityLogObserver.php`)
- Observer that monitors model events
- Captures before/after values
- Triggers logging automatically

**4. Activity Model** (`core/ActivityLog/Activity.php`)
- Represents a single activity log entry
- Provides helper methods for retrieving logs

### Database Schema

```sql
CREATE TABLE activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    log_name VARCHAR(255),
    description TEXT NOT NULL,
    subject_type VARCHAR(255),
    subject_id BIGINT UNSIGNED,
    causer_type VARCHAR(255),
    causer_id BIGINT UNSIGNED,
    properties JSON,
    event VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_subject (subject_type, subject_id),
    INDEX idx_causer (causer_type, causer_id),
    INDEX idx_log_name (log_name),
    INDEX idx_created_at (created_at)
);
```

---

## Automatic Logging

### Basic Configuration

```php
class Order extends Model
{
    use LogsActivity;

    protected $fillable = ['customer_id', 'total', 'status'];
}
```

**What gets logged automatically**:
- [x] `created` - New record created
- [x] `updated` - Record updated (before/after values)
- [x] `deleted` - Record deleted

### Customize Logged Attributes

**Log all attributes** (default):
```php
protected static array $logAttributes = ['*'];
```

**Log specific attributes only**:
```php
protected static array $logAttributes = ['name', 'email', 'status'];
```

**Log only changed attributes**:
```php
protected static bool $logOnlyDirty = true;
```

### Custom Log Names

Organize logs by module or context:

```php
class Invoice extends Model
{
    use LogsActivity;

    protected static string $logName = 'financial';
}

class InventoryItem extends Model
{
    use LogsActivity;

    protected static string $logName = 'inventory';
}
```

### Example: Automatic Logging Output

```php
// Create new user
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'status' => 'active'
]);

// Logged automatically:
// {
//     "description": "created",
//     "subject_type": "App\\Models\\User",
//     "subject_id": 42,
//     "causer_type": "App\\Models\\User",
//     "causer_id": 1,
//     "properties": {
//         "attributes": {
//             "name": "John Doe",
//             "email": "john@example.com",
//             "status": "active"
//         }
//     },
//     "event": "created"
// }

// Update user
$user->update(['status' => 'inactive']);

// Logged automatically with before/after:
// {
//     "description": "updated",
//     "properties": {
//         "old": {"status": "active"},
//         "attributes": {"status": "inactive"}
//     }
// }
```

---

## Manual Logging

### Fluent API

The activity logger provides a fluent, chainable API:

```php
activity()
    ->performedOn($model)        // The subject (what changed)
    ->causedBy($user)             // The actor (who did it)
    ->withProperties($array)      // Custom data
    ->inLog($logName)             // Log channel
    ->log($description);          // Save
```

### Examples

**1. Simple Action Log**:
```php
activity()->log('User logged in from mobile app');
```

**2. Log with Subject**:
```php
activity()
    ->performedOn($order)
    ->log('Order shipped');
```

**3. Log with Causer and Subject**:
```php
activity()
    ->performedOn($invoice)
    ->causedBy($approver)
    ->log('Invoice approved');
```

**4. Log with Custom Properties**:
```php
activity()
    ->performedOn($product)
    ->causedBy($user)
    ->withProperties([
        'old_price' => 99.99,
        'new_price' => 89.99,
        'discount_reason' => 'seasonal sale'
    ])
    ->log('Product price updated');
```

**5. Log to Specific Channel**:
```php
activity()
    ->performedOn($user)
    ->causedBy($admin)
    ->inLog('security')
    ->log('User permissions modified');
```

### Controller Integration

```php
class OrderController
{
    public function approve(Request $request, int $id)
    {
        $order = Order::findOrFail($id);
        $user = $request->user();

        // Update order
        $order->update(['status' => 'approved']);

        // Log approval action
        activity()
            ->performedOn($order)
            ->causedBy($user)
            ->withProperties([
                'approver_notes' => $request->input('notes'),
                'approval_date' => now()
            ])
            ->inLog('orders')
            ->log('Order approved for processing');

        return JsonResponse::success(['order' => $order]);
    }
}
```

---

## Retrieving Activity

### Query Activity Logs

**Get all activity for a model**:
```php
$activities = DB::table('activity_log')
    ->where('subject_type', 'App\\Models\\Order')
    ->where('subject_id', 123)
    ->orderBy('created_at', 'DESC')
    ->get();
```

**Get activity by causer (user)**:
```php
$userActions = DB::table('activity_log')
    ->where('causer_type', 'App\\Models\\User')
    ->where('causer_id', 42)
    ->whereDate('created_at', '2026-01-29')
    ->get();
```

**Get activity by log name**:
```php
$financialActivity = DB::table('activity_log')
    ->where('log_name', 'financial')
    ->where('created_at', '>=', now()->subDays(30))
    ->get();
```

### Parse Properties

Properties are stored as JSON:

```php
foreach ($activities as $activity) {
    $properties = json_decode($activity['properties'], true);

    if (isset($properties['old'], $properties['attributes'])) {
        // This is an update with before/after values
        $changes = array_diff($properties['attributes'], $properties['old']);
        echo "Changed fields: " . implode(', ', array_keys($changes)) . "\n";
    }
}
```

### Display Activity Timeline

```php
function displayActivityTimeline($subjectType, $subjectId)
{
    $activities = DB::table('activity_log')
        ->where('subject_type', $subjectType)
        ->where('subject_id', $subjectId)
        ->orderBy('created_at', 'DESC')
        ->get();

    foreach ($activities as $activity) {
        $causer = $activity['causer_id']
            ? "User #{$activity['causer_id']}"
            : "System";

        $date = date('Y-m-d H:i:s', strtotime($activity['created_at']));

        echo "[{$date}] {$causer}: {$activity['description']}\n";

        // Show changes if available
        $properties = json_decode($activity['properties'], true);
        if (isset($properties['old'], $properties['attributes'])) {
            foreach ($properties['attributes'] as $key => $newValue) {
                $oldValue = $properties['old'][$key] ?? null;
                if ($oldValue != $newValue) {
                    echo "  - {$key}: {$oldValue} → {$newValue}\n";
                }
            }
        }
    }
}
```

---

## Configuration

### config/activity.php

```php
<?php

return [
    // Enable/disable activity logging globally
    'enabled' => env('ACTIVITY_LOG_ENABLED', true),

    // Default log name
    'log_name' => 'default',

    // Automatically delete old logs (days)
    'delete_records_older_than_days' => 365,
];
```

### Environment Variables

```env
# Activity Logging
ACTIVITY_LOG_ENABLED=true
```

### Disable Logging Temporarily

```php
// Disable logging for specific operation
config(['activity.enabled' => false]);

// Perform operation without logging
$user->update(['last_login' => now()]);

// Re-enable logging
config(['activity.enabled' => true]);
```

---

## Advanced Topics

### Custom Log Descriptions

Override the default description for model events:

```php
class Order extends Model
{
    use LogsActivity;

    public function getDescriptionForEvent(string $event): string
    {
        return match($event) {
            'created' => 'Order placed',
            'updated' => 'Order details updated',
            'deleted' => 'Order cancelled',
            default => $event
        };
    }
}
```

### Exclude Attributes from Logging

```php
class User extends Model
{
    use LogsActivity;

    // Log all except these
    protected static array $logAttributesExcept = [
        'password',
        'remember_token',
        'last_login'
    ];
}
```

### Log Additional Data

```php
class Product extends Model
{
    use LogsActivity;

    public function getAdditionalLogProperties(): array
    {
        return [
            'category' => $this->category->name,
            'stock_level' => $this->stock,
            'warehouse' => $this->warehouse->code
        ];
    }
}
```

---

## ERP Use Cases

### 1. Financial Transactions

**Requirement**: Track all changes to invoices, payments, and financial records.

```php
class Invoice extends Model
{
    use LogsActivity;

    protected static string $logName = 'financial';
    protected static array $logAttributes = ['*'];
    protected static bool $logOnlyDirty = true;
}

// Every change is automatically logged
$invoice->update(['status' => 'paid', 'paid_at' => now()]);

// Query financial audit trail
$audit = DB::table('activity_log')
    ->where('log_name', 'financial')
    ->where('created_at', '>=', '2026-01-01')
    ->get();
```

### 2. Inventory Management

**Requirement**: Track stock adjustments for accountability.

```php
activity()
    ->performedOn($item)
    ->causedBy($user)
    ->withProperties([
        'old_quantity' => 100,
        'new_quantity' => 75,
        'adjustment_reason' => 'Physical count correction',
        'warehouse' => 'WH-001'
    ])
    ->inLog('inventory')
    ->log('Inventory adjusted');
```

### 3. User Permission Changes

**Requirement**: Security audit trail for permission modifications.

```php
activity()
    ->performedOn($user)
    ->causedBy($admin)
    ->withProperties([
        'old_roles' => ['user'],
        'new_roles' => ['user', 'manager'],
        'ip_address' => $request->ip()
    ])
    ->inLog('security')
    ->log('User roles updated');
```

### 4. Order Workflow

**Requirement**: Complete order history from creation to delivery.

```php
// Order created
activity()->performedOn($order)->log('Order placed');

// Order approved
activity()
    ->performedOn($order)
    ->causedBy($manager)
    ->log('Order approved');

// Order shipped
activity()
    ->performedOn($order)
    ->withProperties(['tracking_number' => 'TRK123456'])
    ->log('Order shipped');
```

---

## Best Practices

### 1. Use Log Names for Organization

Group related activity by log name:

```php
'financial'  // Invoices, payments, transactions
'inventory'  // Stock movements, adjustments
'security'   // Logins, permissions, access
'orders'     // Order lifecycle
'users'      // User management
```

### 2. Log Meaningful Descriptions

```php
// [X] Bad
activity()->log('updated');

// [x] Good
activity()->log('Product price updated for seasonal sale');
```

### 3. Include Context in Properties

```php
activity()
    ->performedOn($order)
    ->withProperties([
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'context' => 'web_admin_panel',
        'reason' => $request->input('reason')
    ])
    ->log('Order cancelled');
```

### 4. Regular Pruning

Set up automatic pruning to prevent table growth:

```bash
# Cron job (daily at 3 AM)
0 3 * * * php artisan activity:prune --days=365
```

### 5. Index Critical Columns

Ensure indexes on frequently queried columns:

```sql
CREATE INDEX idx_subject ON activity_log(subject_type, subject_id);
CREATE INDEX idx_causer ON activity_log(causer_type, causer_id);
CREATE INDEX idx_created_at ON activity_log(created_at);
CREATE INDEX idx_log_name ON activity_log(log_name);
```

### 6. Exclude Sensitive Data

Never log passwords or sensitive information:

```php
protected static array $logAttributesExcept = [
    'password',
    'api_key',
    'secret_token',
    'credit_card_number'
];
```

---

## Troubleshooting

### Activity Not Logging

**1. Check if logging is enabled**:
```php
var_dump(config('activity.enabled')); // Should be true
```

**2. Verify trait is added**:
```php
class User extends Model
{
    use LogsActivity; // ← Make sure this is present
}
```

**3. Check observer registration**:
The observer is registered automatically when the trait is used.

### Performance Concerns

**Problem**: Large activity_log table affecting performance.

**Solutions**:
1. Regular pruning (keep only last 365 days)
2. Partition table by date (MySQL 8.0+)
3. Archive old logs to separate table/database
4. Use `$logOnlyDirty = true` to reduce log volume

---

## Summary

The Activity Logging system provides:

[x] **Automatic logging** - Add trait, get complete audit trail
[x] **Manual logging** - Fluent API for custom actions
[x] **Complete history** - Before/after values for all changes
[x] **Compliance ready** - GDPR, SOX, HIPAA support
[x] **Flexible** - Log names, custom properties, configurable attributes
[x] **Production tested** - Used in large-scale ERP systems

**Start logging today for complete visibility into your application.**

---

**Next Steps**:
- Add `LogsActivity` trait to your important models
- Set up `activity:prune` cron job
- Review [FRAMEWORK-FEATURES.md](FRAMEWORK-FEATURES.md) for complete system overview
- Explore other systems: [Queue](QUEUE-SYSTEM.md), [Cache](CACHE-SYSTEM.md), [Notifications](NOTIFICATION-SYSTEM.md)

**Version**: 2.0.0 | **Last Updated**: 2026-01-29
