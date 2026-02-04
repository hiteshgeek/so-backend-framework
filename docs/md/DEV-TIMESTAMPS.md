# Implementing Timestamps & Userstamps

This guide covers step-by-step implementation of timestamps and userstamps in your models.

## Step 1: Analyze Your Table Structure

First, identify your table's columns:

```sql
-- Check your table structure
DESCRIBE your_table;
```

Look for columns like:
- `created_at`, `created_ts`, `date_created`, `create_time`
- `updated_at`, `updated_ts`, `date_modified`, `modify_time`
- `created_by`, `created_uid`, `creator_id`, `author_id`
- `updated_by`, `updated_uid`, `modifier_id`, `editor_id`

---

## Step 2: Configure Your Model

### Example 1: Standard Table

If your table uses standard column names:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Post extends Model
{
    protected static string $table = 'posts';

    // Default configuration - no overrides needed
    // Uses: created_at, updated_at
    protected bool $timestamps = true;
}
```

---

### Example 2: Legacy Table with Custom Names

For tables with non-standard column names:

```php
<?php

namespace App\Models;

use Core\Model\Model;

class User extends Model
{
    protected static string $table = 'auser';
    protected static string $primaryKey = 'uid';

    // Enable both features
    protected bool $timestamps = true;
    protected bool $userstamps = true;

    // Map to your actual column names
    const CREATED_AT = 'created_ts';
    const UPDATED_AT = 'updated_ts';
    const CREATED_BY = 'created_uid';
    const UPDATED_BY = 'updated_uid';
}
```

---

### Example 3: Table Without Timestamps

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Setting extends Model
{
    protected static string $table = 'settings';

    // Disable automatic timestamps
    protected bool $timestamps = false;
}
```

---

### Example 4: Partial Configuration (Independent Columns)

> **Important:** All 4 columns are **independently configurable**. Set any to `null` to disable.

```php
<?php

namespace App\Models;

use Core\Model\Model;

class AuditLog extends Model
{
    protected static string $table = 'audit_logs';

    protected bool $timestamps = true;
    protected bool $userstamps = true;

    // Only track creation, not updates
    const CREATED_AT = 'logged_at';
    const UPDATED_AT = null;  // Disabled
    const CREATED_BY = 'user_id';
    const UPDATED_BY = null;  // Disabled
}
```

### Example 5: Mixed Configuration

Track only creation time and last editor:

```php
class Document extends Model
{
    protected bool $timestamps = true;
    protected bool $userstamps = true;

    const CREATED_AT = 'created_at';   // ✓ Track when created
    const UPDATED_AT = null;           // ✗ Don't track update time
    const CREATED_BY = null;           // ✗ Don't track who created
    const UPDATED_BY = 'last_editor';  // ✓ Track who last edited
}
```

**Valid combinations include:**
- All 4 columns enabled
- Only timestamps (no userstamps)
- Only creation columns (CREATED_AT + CREATED_BY)
- Only update columns (UPDATED_AT + UPDATED_BY)
- Any mix of individual columns

---

## Step 3: Create/Update Records

### Creating Records

Timestamps and userstamps are automatically set on create:

```php
// Simple create
$product = Product::create([
    'name' => 'Widget',
    'price' => 29.99,
]);
// created_at, updated_at are auto-set
// created_by, updated_by are auto-set (if userstamps enabled)

// Manual instantiation
$product = new Product();
$product->name = 'Widget';
$product->price = 29.99;
$product->save();
// Same automatic behavior
```

---

### Updating Records

Only update columns are modified:

```php
$product = Product::find(1);
$product->price = 24.99;
$product->save();
// Only updated_at and updated_by change
// created_at and created_by remain unchanged
```

---

### Touch (Update Timestamp Only)

```php
$product = Product::find(1);
$product->touch();
// Updates only updated_at to current time
```

---

## Step 4: Reading Timestamps

### Using Accessor Methods (Recommended)

```php
$user = User::find(1);

// These work regardless of actual column names
$createdAt = $user->getCreatedAt();   // "2024-01-15 10:30:00"
$updatedAt = $user->getUpdatedAt();   // "2024-01-20 14:45:00"
$createdBy = $user->getCreatedBy();   // 42
$updatedBy = $user->getUpdatedBy();   // 55
```

### Direct Column Access

```php
// Only if you know the exact column name
$user = User::find(1);
$createdAt = $user->created_ts;  // Works for auser table
```

---

## Step 5: Building API Responses

### Service Layer Pattern

```php
<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Transform user for API response
     */
    public function toArray(User $user, bool $includeTimestamps = true): array
    {
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        if ($includeTimestamps) {
            // Use accessor methods for portability
            $data['created_at'] = $user->getCreatedAt();
            $data['updated_at'] = $user->getUpdatedAt();
        }

        return $data;
    }

    /**
     * Include audit information
     */
    public function toArrayWithAudit(User $user): array
    {
        $data = $this->toArray($user);

        // Add audit trail
        $data['audit'] = [
            'created_by' => $user->getCreatedBy(),
            'updated_by' => $user->getUpdatedBy(),
        ];

        return $data;
    }
}
```

### Controller Usage

```php
<?php

namespace App\Controllers\Api;

use App\Services\UserService;
use Core\Http\JsonResponse;

class UserController
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index(): JsonResponse
    {
        $users = User::all();

        return JsonResponse::success([
            'users' => array_map(
                fn($user) => $this->userService->toArray($user),
                $users
            ),
        ]);
    }
}
```

---

## Step 6: Display in Views

### Formatting Timestamps

```php
<!-- In your view -->
<p>Created: <?= date('M j, Y g:i A', strtotime($user->getCreatedAt())) ?></p>
<p>Updated: <?= date('M j, Y g:i A', strtotime($user->getUpdatedAt())) ?></p>
```

### With User Information

```php
<?php
$creator = User::find($post->getCreatedBy());
$editor = User::find($post->getUpdatedBy());
?>

<div class="audit-info">
    <p>Created by <?= htmlspecialchars($creator->name) ?>
       on <?= date('M j, Y', strtotime($post->getCreatedAt())) ?></p>

    <?php if ($post->getUpdatedBy() !== $post->getCreatedBy()): ?>
    <p>Last edited by <?= htmlspecialchars($editor->name) ?>
       on <?= date('M j, Y', strtotime($post->getUpdatedAt())) ?></p>
    <?php endif; ?>
</div>
```

---

## Common Patterns

### Pattern 1: Audit Trail Mixin

Create a trait for consistent audit display:

```php
<?php

namespace App\Traits;

use App\Models\User;

trait HasAuditDisplay
{
    public function getCreator(): ?User
    {
        $id = $this->getCreatedBy();
        return $id ? User::find($id) : null;
    }

    public function getEditor(): ?User
    {
        $id = $this->getUpdatedBy();
        return $id ? User::find($id) : null;
    }

    public function getAuditInfo(): array
    {
        return [
            'created_at' => $this->getCreatedAt(),
            'created_by' => $this->getCreator()?->name ?? 'System',
            'updated_at' => $this->getUpdatedAt(),
            'updated_by' => $this->getEditor()?->name ?? 'System',
        ];
    }
}
```

Usage:

```php
class Post extends Model
{
    use HasAuditDisplay;

    protected bool $timestamps = true;
    protected bool $userstamps = true;
}

// In controller/view
$post = Post::find(1);
$audit = $post->getAuditInfo();
```

---

### Pattern 2: Without Touching Timestamps

Sometimes you need to update without changing timestamps:

```php
class Post extends Model
{
    /**
     * Update without touching timestamps
     */
    public function updateQuietly(array $attributes = []): bool
    {
        $this->timestamps = false;

        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        $result = $this->save();
        $this->timestamps = true;

        return $result;
    }
}

// Usage
$post = Post::find(1);
$post->updateQuietly(['view_count' => $post->view_count + 1]);
// updated_at remains unchanged
```

---

### Pattern 3: Custom Date Format

```php
class Order extends Model
{
    // ISO 8601 with timezone
    protected string $dateFormat = 'Y-m-d\TH:i:sP';
}
```

---

### Pattern 4: Formatted Accessors

Add formatted getters to your model:

```php
class Post extends Model
{
    /**
     * Get human-readable created date
     */
    public function getCreatedAtFormatted(): string
    {
        $timestamp = $this->getCreatedAt();
        if (!$timestamp) return 'Unknown';

        return date('F j, Y \a\t g:i A', strtotime($timestamp));
    }

    /**
     * Get relative time (e.g., "2 hours ago")
     */
    public function getCreatedAtRelative(): string
    {
        $timestamp = $this->getCreatedAt();
        if (!$timestamp) return 'Unknown';

        $diff = time() - strtotime($timestamp);

        if ($diff < 60) return 'Just now';
        if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
        if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
        if ($diff < 604800) return floor($diff / 86400) . ' days ago';

        return date('M j, Y', strtotime($timestamp));
    }
}

// Usage
echo $post->getCreatedAtFormatted();  // "January 15, 2024 at 10:30 AM"
echo $post->getCreatedAtRelative();   // "2 hours ago"
```

---

## Testing Your Configuration

### Quick Verification

```php
// Test in a controller or tinker
$model = new \App\Models\User();

echo "Timestamps enabled: " . ($model->timestamps ? 'Yes' : 'No') . "\n";
echo "Userstamps enabled: " . ($model->userstamps ? 'Yes' : 'No') . "\n";
echo "CREATED_AT column: " . (User::CREATED_AT ?? 'disabled') . "\n";
echo "UPDATED_AT column: " . (User::UPDATED_AT ?? 'disabled') . "\n";
echo "CREATED_BY column: " . (User::CREATED_BY ?? 'disabled') . "\n";
echo "UPDATED_BY column: " . (User::UPDATED_BY ?? 'disabled') . "\n";
```

### Integration Test

```php
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTimestampsTest extends TestCase
{
    public function testTimestampsAreSetOnCreate(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret',
        ]);

        $this->assertNotNull($user->getCreatedAt());
        $this->assertNotNull($user->getUpdatedAt());
    }

    public function testUpdatedAtChangesOnUpdate(): void
    {
        $user = User::find(1);
        $originalUpdated = $user->getUpdatedAt();

        sleep(1);  // Ensure time difference

        $user->name = 'Updated Name';
        $user->save();

        $this->assertNotEquals($originalUpdated, $user->getUpdatedAt());
    }

    public function testCreatedAtDoesNotChangeOnUpdate(): void
    {
        $user = User::find(1);
        $originalCreated = $user->getCreatedAt();

        $user->name = 'Updated Name';
        $user->save();

        $this->assertEquals($originalCreated, $user->getCreatedAt());
    }
}
```

---

## Troubleshooting

### Issue: Timestamps Not Being Set

**Check:**
1. Is `$timestamps = true`?
2. Does the column exist in the database?
3. Is the constant mapped correctly?

```php
// Debug
var_dump([
    'timestamps' => $model->timestamps,
    'CREATED_AT' => User::CREATED_AT,
    'UPDATED_AT' => User::UPDATED_AT,
]);
```

---

### Issue: Userstamps Are Null

**Check:**
1. Is `$userstamps = true`?
2. Is there an authenticated user?

```php
// Debug
var_dump([
    'userstamps' => $model->userstamps,
    'auth_check' => auth()->check(),
    'auth_id' => auth()->id(),
]);
```

---

### Issue: Column Not Found Error

**Error:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'created_at'
```

**Solution:**
Map to your actual column name:

```php
const CREATED_AT = 'your_actual_column_name';
// OR disable if column doesn't exist
const CREATED_AT = null;
```

---

## Configuration Reference

| Configuration | Type | Default | Purpose |
|---------------|------|---------|---------|
| `$timestamps` | bool | `true` | Enable/disable timestamp handling |
| `$userstamps` | bool | `false` | Enable/disable user tracking |
| `CREATED_AT` | const | `'created_at'` | Column for creation time |
| `UPDATED_AT` | const | `'updated_at'` | Column for update time |
| `CREATED_BY` | const | `'created_by'` | Column for creator user ID |
| `UPDATED_BY` | const | `'updated_by'` | Column for updater user ID |
| `$dateFormat` | string | `'Y-m-d H:i:s'` | Timestamp format |

---

## See Also

- [Timestamps System Overview](/docs/timestamps-userstamps) - Conceptual documentation
- [Creating Models](/docs/dev-models) - Model basics
- [Model Advanced Features](/docs/dev-model-advanced) - Scopes, relations
- [HasStatusField Trait](/docs/status-field-trait) - Status field handling
