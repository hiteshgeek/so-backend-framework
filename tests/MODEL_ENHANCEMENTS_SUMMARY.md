# Model Enhancements Summary

## Overview

This document summarizes the model enhancements and advanced features available in the framework's ORM.

## Query Scopes

Define reusable query constraints:

```php
class User extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}

// Usage
$activeUsers = User::active()->get();
$recentUsers = User::recent(30)->get();
```

## Soft Deletes

Soft delete functionality marks records as deleted without removing them:

```php
use Core\Database\Traits\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
}

// Soft delete
$post->delete(); // Sets deleted_at timestamp

// Query with soft deletes
$posts = Post::withTrashed()->get();
$deletedOnly = Post::onlyTrashed()->get();
```

## Relationships

Support for all major relationship types:
- One-to-One
- One-to-Many
- Many-to-Many
- Has-Many-Through

## Timestamps & Userstamps

Automatic tracking of creation and modification:

```php
use Core\Database\Traits\HasTimestamps;
use Core\Database\Traits\HasUserstamps;

class Article extends Model
{
    use HasTimestamps;
    use HasUserstamps;
}
```

## Status Field Handling

Flexible status field support with custom column names.

## Testing

Model enhancement tests are in `tests/Unit/Models/` directory.

## Related Documentation

- [Advanced Models](/docs/dev-model-advanced)
- [Model Observers](/docs/model-observers)
- [Timestamps & Userstamps](/docs/timestamps-userstamps)
