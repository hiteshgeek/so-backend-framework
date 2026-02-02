# Timestamps & Userstamps System

## Overview

The framework provides a flexible system for handling **timestamps** (when records are created/updated) and **userstamps** (who created/updated records). This system adapts to any database schema, regardless of column naming conventions.

### Problem It Solves

In real-world databases, timestamp and user tracking columns vary widely:

| Standard Names | Legacy/Custom Names |
|----------------|---------------------|
| `created_at` | `created_ts`, `date_created`, `create_time` |
| `updated_at` | `updated_ts`, `date_modified`, `modify_time` |
| `created_by` | `created_uid`, `creator_id`, `author_id` |
| `updated_by` | `updated_uid`, `modifier_id`, `editor_id` |

The framework solves this by:
- **Mapping constants** to actual database column names
- **Optional timestamps** - enable/disable per model
- **Optional userstamps** - track who made changes
- **Unified accessor methods** - access values regardless of column names

---

## Quick Start

### Basic Configuration

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Product extends Model
{
    protected static string $table = 'products';

    // Enable/disable features
    protected bool $timestamps = true;   // Auto-set created_at/updated_at
    protected bool $userstamps = false;  // Don't track user IDs

    // Map to actual column names (if different from defaults)
    const CREATED_AT = 'created_at';  // Default
    const UPDATED_AT = 'updated_at';  // Default
}
```

### Custom Column Names

```php
class User extends Model
{
    protected static string $table = 'auser';

    // Enable both features
    protected bool $timestamps = true;
    protected bool $userstamps = true;

    // Map to legacy column names
    const CREATED_AT = 'created_ts';
    const UPDATED_AT = 'updated_ts';
    const CREATED_BY = 'created_uid';
    const UPDATED_BY = 'updated_uid';
}
```

### Disable Specific Columns

```php
class AuditLog extends Model
{
    protected bool $timestamps = true;

    // Only track creation, not updates
    const CREATED_AT = 'logged_at';
    const UPDATED_AT = null;  // Disable updated timestamp
}
```

---

## Configuration Options

### `$timestamps` (bool)

Controls whether the model automatically sets timestamp columns on create/update.

| Value | Behavior |
|-------|----------|
| `true` (default) | Auto-set `CREATED_AT` on create, `UPDATED_AT` on create/update |
| `false` | No automatic timestamp handling |

```php
// Disable timestamps entirely
protected bool $timestamps = false;
```

---

### `$userstamps` (bool)

Controls whether the model tracks which user created/updated records.

| Value | Behavior |
|-------|----------|
| `false` (default) | No user tracking |
| `true` | Auto-set `CREATED_BY` on create, `UPDATED_BY` on create/update |

```php
// Enable user tracking
protected bool $userstamps = true;
```

**Note:** Requires an authenticated user. Uses `auth()->id()` to get the current user ID.

---

### `CREATED_AT` (const)

The database column name for creation timestamp.

| Value | Behavior |
|-------|----------|
| `'created_at'` (default) | Standard column name |
| `'your_column'` | Custom column name |
| `null` | Disable created timestamp (keep updated) |

```php
const CREATED_AT = 'date_created';  // Custom name
const CREATED_AT = null;            // Disable
```

---

### `UPDATED_AT` (const)

The database column name for update timestamp.

| Value | Behavior |
|-------|----------|
| `'updated_at'` (default) | Standard column name |
| `'your_column'` | Custom column name |
| `null` | Disable updated timestamp (keep created) |

```php
const UPDATED_AT = 'modified_at';  // Custom name
const UPDATED_AT = null;           // Disable
```

---

### `CREATED_BY` (const)

The database column name for creator user ID.

| Value | Behavior |
|-------|----------|
| `'created_by'` (default) | Standard column name |
| `'your_column'` | Custom column name |
| `null` | Disable created_by tracking |

```php
const CREATED_BY = 'author_id';  // Custom name
const CREATED_BY = null;         // Disable
```

---

### `UPDATED_BY` (const)

The database column name for updater user ID.

| Value | Behavior |
|-------|----------|
| `'updated_by'` (default) | Standard column name |
| `'your_column'` | Custom column name |
| `null` | Disable updated_by tracking |

```php
const UPDATED_BY = 'editor_id';  // Custom name
const UPDATED_BY = null;         // Disable
```

---

## Accessor Methods

Use these methods to access timestamp/userstamp values regardless of actual column names:

### `getCreatedAt()` : ?string

Get the creation timestamp.

```php
$user = User::find(1);
echo $user->getCreatedAt();  // "2024-01-15 10:30:00"
```

---

### `getUpdatedAt()` : ?string

Get the last update timestamp.

```php
$user = User::find(1);
echo $user->getUpdatedAt();  // "2024-01-20 14:45:00"
```

---

### `getCreatedBy()` : ?int

Get the ID of the user who created this record.

```php
$post = Post::find(1);
$authorId = $post->getCreatedBy();  // 42

// Get the actual user
$author = User::find($authorId);
echo "Created by: " . $author->name;
```

---

### `getUpdatedBy()` : ?int

Get the ID of the user who last updated this record.

```php
$post = Post::find(1);
$editorId = $post->getUpdatedBy();  // 55

// Get the actual user
$editor = User::find($editorId);
echo "Last edited by: " . $editor->name;
```

---

## Independent Column Configuration

> **Important:** All 4 columns (CREATED_AT, UPDATED_AT, CREATED_BY, UPDATED_BY) are **independently configurable**. You can enable or disable any combination based on your table structure.

Each constant can be:
- A **string** → Maps to that column name
- **null** → Disables that specific column

This means you can have any of these configurations:

| CREATED_AT | UPDATED_AT | CREATED_BY | UPDATED_BY | Use Case |
|------------|------------|------------|------------|----------|
| ✓ | ✓ | ✓ | ✓ | Full audit trail |
| ✓ | ✓ | ✗ | ✗ | Timestamps only |
| ✓ | ✗ | ✓ | ✗ | Creation tracking only |
| ✗ | ✓ | ✗ | ✓ | Update tracking only |
| ✓ | ✗ | ✗ | ✗ | Created time only |
| ✗ | ✓ | ✗ | ✗ | Last modified only |
| ✗ | ✗ | ✓ | ✓ | User tracking only |
| ✓ | ✓ | ✗ | ✓ | Mixed - times + updater |

**Example: Track creation time and updater only**
```php
class Document extends Model
{
    protected bool $timestamps = true;
    protected bool $userstamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;      // No update timestamp
    const CREATED_BY = null;      // No creator tracking
    const UPDATED_BY = 'last_editor_id';  // Only track who edited
}
```

---

## Configuration Scenarios

### Scenario 1: Standard Table (New Project)

```php
class Post extends Model
{
    protected static string $table = 'posts';

    // Use defaults - no configuration needed
    // Columns: created_at, updated_at
}
```

---

### Scenario 2: Legacy Table with Custom Names

```php
class User extends Model
{
    protected static string $table = 'auser';

    protected bool $timestamps = true;
    protected bool $userstamps = true;

    const CREATED_AT = 'created_ts';
    const UPDATED_AT = 'updated_ts';
    const CREATED_BY = 'created_uid';
    const UPDATED_BY = 'updated_uid';
}
```

---

### Scenario 3: No Timestamps

```php
class Setting extends Model
{
    protected static string $table = 'settings';

    // Disable all automatic timestamps
    protected bool $timestamps = false;
}
```

---

### Scenario 4: Only Creation Tracking

```php
class AuditLog extends Model
{
    protected static string $table = 'audit_logs';

    protected bool $timestamps = true;
    protected bool $userstamps = true;

    // Only track creation, not updates
    const CREATED_AT = 'logged_at';
    const UPDATED_AT = null;
    const CREATED_BY = 'user_id';
    const UPDATED_BY = null;
}
```

---

### Scenario 5: Only Update Tracking

```php
class CacheEntry extends Model
{
    protected static string $table = 'cache';

    protected bool $timestamps = true;

    // Only track last access, not creation
    const CREATED_AT = null;
    const UPDATED_AT = 'last_accessed';
}
```

---

### Scenario 6: Timestamps Only (No User Tracking)

```php
class Product extends Model
{
    protected static string $table = 'products';

    protected bool $timestamps = true;
    protected bool $userstamps = false;  // Default

    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_modified';
}
```

---

## API Response Integration

When building API responses, use the accessor methods for consistency:

```php
class UserService
{
    public function toArray(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            // Use accessor methods - works regardless of column names
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
            'created_by' => $user->getCreatedBy(),
            'updated_by' => $user->getUpdatedBy(),
        ];
    }
}
```

---

## Date Format

The default timestamp format is `Y-m-d H:i:s`. Override in your model:

```php
class Order extends Model
{
    // Custom date format
    protected string $dateFormat = 'Y-m-d H:i:s.u';  // With microseconds
}
```

---

## Automatic Behavior

### On Create (Insert)

When a new record is created:

| Column | Value |
|--------|-------|
| `CREATED_AT` | Current timestamp |
| `UPDATED_AT` | Current timestamp |
| `CREATED_BY` | `auth()->id()` (if authenticated) |
| `UPDATED_BY` | `auth()->id()` (if authenticated) |

```php
$product = Product::create([
    'name' => 'New Product',
    'price' => 99.99,
]);
// created_at, updated_at, created_by, updated_by are auto-set
```

---

### On Update

When an existing record is updated:

| Column | Value |
|--------|-------|
| `CREATED_AT` | **Not changed** |
| `UPDATED_AT` | Current timestamp |
| `CREATED_BY` | **Not changed** |
| `UPDATED_BY` | `auth()->id()` (if authenticated) |

```php
$product = Product::find(1);
$product->price = 89.99;
$product->save();
// Only updated_at and updated_by change
```

---

## Touch Method

Update only the `updated_at` timestamp without changing other attributes:

```php
$product = Product::find(1);
$product->touch();  // Updates updated_at to now
```

---

## Best Practices

### 1. Always Use Accessor Methods in Services

```php
// GOOD - Portable across models
$data['created_at'] = $user->getCreatedAt();

// BAD - Assumes column name
$data['created_at'] = $user->created_ts;
```

### 2. Document Your Column Mappings

```php
class User extends Model
{
    /**
     * Timestamp columns mapped to auser table structure
     * - created_ts: When the user was created
     * - updated_ts: When the user was last modified
     */
    const CREATED_AT = 'created_ts';
    const UPDATED_AT = 'updated_ts';
}
```

### 3. Use Null for Intentionally Disabled Columns

```php
// GOOD - Explicit that this is intentional
const UPDATED_AT = null;

// BAD - Might look like a mistake
// const UPDATED_AT = 'updated_at'; // commented out
```

### 4. Test Your Configuration

```php
// Quick test in tinker or test file
$user = new User();
echo "CREATED_AT column: " . User::CREATED_AT;  // 'created_ts'
echo "UPDATED_AT column: " . User::UPDATED_AT;  // 'updated_ts'
```

---

## Migration Guide

### From Manual Timestamps

**Before:**
```php
class User extends Model
{
    public function save(): bool
    {
        if (!$this->exists) {
            $this->attributes['created_ts'] = date('Y-m-d H:i:s');
        }
        $this->attributes['updated_ts'] = date('Y-m-d H:i:s');
        return parent::save();
    }
}
```

**After:**
```php
class User extends Model
{
    protected bool $timestamps = true;
    const CREATED_AT = 'created_ts';
    const UPDATED_AT = 'updated_ts';
    // Automatic handling - no manual code needed!
}
```

---

## Summary

| Feature | Property/Constant | Default | Purpose |
|---------|-------------------|---------|---------|
| Enable timestamps | `$timestamps` | `true` | Auto-set time columns |
| Enable userstamps | `$userstamps` | `false` | Auto-set user ID columns |
| Created time column | `CREATED_AT` | `'created_at'` | Column name mapping |
| Updated time column | `UPDATED_AT` | `'updated_at'` | Column name mapping |
| Created by column | `CREATED_BY` | `'created_by'` | Column name mapping |
| Updated by column | `UPDATED_BY` | `'updated_by'` | Column name mapping |

**Accessor Methods:**
- `getCreatedAt()` - Get creation timestamp
- `getUpdatedAt()` - Get update timestamp
- `getCreatedBy()` - Get creator user ID
- `getUpdatedBy()` - Get updater user ID

---

**See Also:**
- [Model Development Guide](/docs/dev-models) - Creating and configuring models
- [Model Advanced Features](/docs/dev-model-advanced) - Scopes, relations, soft deletes
- [HasStatusField Trait](/docs/status-field-trait) - Flexible status field handling
