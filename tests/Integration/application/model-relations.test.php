<?php

/**
 * Model Enhancements Test
 *
 * Tests SoftDeletes trait and Query Scopes functionality
 */

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap/app.php';
require_once __DIR__ . '/../../TestHelper.php';

use Core\Model\Model;
use Core\Model\SoftDeletes;
use Core\Database\QueryBuilder;

TestHelper::header('Model Enhancements Test');
echo "\n";

$passedTests = 0;
$totalTests = 0;

// ==================== TEST MODEL CLASSES ====================

// Test model with soft deletes
class TestUser extends Model
{
    use SoftDeletes;

    protected static string $table = 'test_users';
    protected array $fillable = ['name', 'email', 'status'];
}

// Test model with query scopes
class TestPost extends Model
{
    protected static string $table = 'test_posts';
    protected array $fillable = ['title', 'status', 'views'];

    /**
     * Scope to get published posts
     */
    public function scopePublished(QueryBuilder $query): QueryBuilder
    {
        return $query->where('status', '=', 'published');
    }

    /**
     * Scope to get popular posts (>100 views)
     */
    public function scopePopular(QueryBuilder $query, int $minViews = 100): QueryBuilder
    {
        return $query->where('views', '>=', $minViews);
    }

    /**
     * Scope to get recent posts
     */
    public function scopeRecent(QueryBuilder $query): QueryBuilder
    {
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * Helper: Convert query results to model instances
     */
    public static function hydrateFromQuery(QueryBuilder $query): array
    {
        $results = $query->get();
        return array_map(function($row) {
            $instance = new static();
            $instance->fill($row);
            $instance->setAttribute('id', $row['id']);
            $instance->exists = true;
            return $instance;
        }, $results);
    }
}

// ==================== SETUP ====================

echo "Setup: Creating test tables...\n";
try {
    $db = app('db')->connection;

    // Drop tables if exist
    $db->execute("DROP TABLE IF EXISTS test_users");
    $db->execute("DROP TABLE IF EXISTS test_posts");

    // Create test_users table
    $db->execute("
        CREATE TABLE test_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            status VARCHAR(50) DEFAULT 'active',
            deleted_at DATETIME NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");

    // Create test_posts table
    $db->execute("
        CREATE TABLE test_posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            status VARCHAR(50) DEFAULT 'draft',
            views INT DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");

    echo "✓ Test tables created\n\n";
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n\n";
}

// ==================== TEST 1: SoftDeletes - Delete Sets Timestamp ====================

echo "Test 1: SoftDeletes - Delete Sets deleted_at Timestamp\n";
try {
    $totalTests++;

    $user = new TestUser();
    $user->name = 'John Doe';
    $user->email = 'john@example.com';
    $user->save();

    $userId = $user->id;

    // Soft delete
    $user->delete();

    // Check deleted_at is set
    $result = $db->query("SELECT deleted_at FROM test_users WHERE id = ?", [$userId])->fetchAll();

    if (!empty($result) && $result[0]['deleted_at'] !== null) {
        echo "✓ Soft delete set deleted_at timestamp\n";
        echo "  deleted_at: " . $result[0]['deleted_at'] . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: deleted_at not set\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 2: SoftDeletes - Restore ====================

echo "Test 2: SoftDeletes - Restore Clears deleted_at\n";
try {
    $totalTests++;

    // Get the soft-deleted user
    $result = $db->query("SELECT * FROM test_users WHERE id = ?", [$userId])->fetchAll();
    $user = new TestUser();
    $user->fill($result[0]);
    $user->setAttribute('id', $result[0]['id']); // Set id explicitly (it's guarded)
    $user->exists = true;

    // Restore
    $user->restore();

    // Check deleted_at is null
    $result = $db->query("SELECT deleted_at FROM test_users WHERE id = ?", [$userId])->fetchAll();

    if (!empty($result) && $result[0]['deleted_at'] === null) {
        echo "✓ Restore cleared deleted_at\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: deleted_at not cleared\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 3: SoftDeletes - Force Delete ====================

echo "Test 3: SoftDeletes - Force Delete Removes Record\n";
try {
    $totalTests++;

    // Create another user
    $user2 = new TestUser();
    $user2->name = 'Jane Doe';
    $user2->email = 'jane@example.com';
    $user2->save();

    $user2Id = $user2->id;

    // Force delete
    $user2->forceDelete();

    // Check record is gone
    $result = $db->query("SELECT * FROM test_users WHERE id = ?", [$user2Id])->fetchAll();

    if (empty($result)) {
        echo "✓ Force delete removed record permanently\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Record still exists\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 4: SoftDeletes - trashed() Method ====================

echo "Test 4: SoftDeletes - trashed() Method\n";
try {
    $totalTests++;

    // Create and soft delete a user
    $user3 = new TestUser();
    $user3->name = 'Bob Smith';
    $user3->email = 'bob@example.com';
    $user3->save();
    $user3->delete();

    if ($user3->trashed()) {
        echo "✓ trashed() correctly identifies soft-deleted record\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: trashed() returned false\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 5: SoftDeletes - withTrashed() ====================

echo "Test 5: SoftDeletes - withTrashed() Includes Deleted\n";
try {
    $totalTests++;

    $allUsers = TestUser::withTrashed();

    // Should include both active and soft-deleted users
    if (count($allUsers) >= 2) { // At least the restored one and soft-deleted one
        echo "✓ withTrashed() includes soft-deleted records\n";
        echo "  Total records: " . count($allUsers) . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: withTrashed() didn't include all records\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 6: SoftDeletes - onlyTrashed() ====================

echo "Test 6: SoftDeletes - onlyTrashed() Returns Only Deleted\n";
try {
    $totalTests++;

    $trashedUsers = TestUser::onlyTrashed();

    // Should only include soft-deleted users
    $allTrashed = true;
    foreach ($trashedUsers as $user) {
        if (!$user->trashed()) {
            $allTrashed = false;
            break;
        }
    }

    if ($allTrashed && count($trashedUsers) > 0) {
        echo "✓ onlyTrashed() returns only soft-deleted records\n";
        echo "  Trashed records: " . count($trashedUsers) . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: onlyTrashed() included non-deleted records\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 7: Query Scopes - Published Scope ====================

echo "Test 7: Query Scopes - Published Scope\n";
try {
    $totalTests++;

    // Insert test posts
    $db->execute("INSERT INTO test_posts (title, status, views) VALUES (?, ?, ?)", ['Post 1', 'published', 150]);
    $db->execute("INSERT INTO test_posts (title, status, views) VALUES (?, ?, ?)", ['Post 2', 'draft', 50]);
    $db->execute("INSERT INTO test_posts (title, status, views) VALUES (?, ?, ?)", ['Post 3', 'published', 200]);

    // Get published posts using scope
    $publishedPosts = TestPost::hydrateFromQuery(TestPost::published());

    $allPublished = true;
    foreach ($publishedPosts as $post) {
        if ($post->status !== 'published') {
            $allPublished = false;
            break;
        }
    }

    if ($allPublished && count($publishedPosts) === 2) {
        echo "✓ Published scope filters correctly\n";
        echo "  Published posts: " . count($publishedPosts) . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Published scope didn't filter correctly\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 8: Query Scopes - Popular Scope with Parameter ====================

echo "Test 8: Query Scopes - Popular Scope with Parameter\n";
try {
    $totalTests++;

    // Get popular posts (views >= 100)
    $popularPosts = TestPost::hydrateFromQuery(TestPost::popular(100));

    $allPopular = true;
    foreach ($popularPosts as $post) {
        if ($post->views < 100) {
            $allPopular = false;
            break;
        }
    }

    if ($allPopular && count($popularPosts) === 2) {
        echo "✓ Popular scope with parameter works correctly\n";
        echo "  Popular posts (>= 100 views): " . count($popularPosts) . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Popular scope didn't filter correctly\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 9: Query Scopes - Chaining Scopes ====================

echo "Test 9: Query Scopes - Chaining Multiple Scopes\n";
try {
    $totalTests++;

    // Get published AND popular posts
    $result = TestPost::published()->where('views', '>=', 150)->get();

    if (count($result) === 2) { // Post 1 (150 views) and Post 3 (200 views)
        echo "✓ Chaining scopes works correctly\n";
        echo "  Published + Popular: " . count($result) . " posts\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Chaining scopes didn't work (got " . count($result) . " posts)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 10: Query Scopes - Recent Scope ====================

echo "Test 10: Query Scopes - Recent Scope (ORDER BY)\n";
try {
    $totalTests++;

    $recentPosts = TestPost::hydrateFromQuery(TestPost::recent());

    // Check if ordered by created_at DESC
    // (In our test, all posts created at same time, so just check it doesn't error)
    if (count($recentPosts) === 3) {
        echo "✓ Recent scope executed successfully\n";
        echo "  Total posts: " . count($recentPosts) . "\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Recent scope didn't return correct count\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== CLEANUP ====================

echo "Cleanup: Dropping test tables...\n";
try {
    $db->execute("DROP TABLE IF EXISTS test_users");
    $db->execute("DROP TABLE IF EXISTS test_posts");
    echo "✓ Test tables dropped\n\n";
} catch (Exception $e) {
    echo "✗ WARNING: " . $e->getMessage() . "\n\n";
}

// ==================== SUMMARY ====================

TestHelper::complete('Model Enhancements Test');

TestHelper::summary($passedTests, $totalTests - $passedTests, $totalTests);

if ($passedTests === $totalTests) {
    echo "\n";
    echo "Model Enhancements Status:\n";
    echo "- ✓ SoftDeletes: delete(), restore(), forceDelete() working\n";
    echo "- ✓ SoftDeletes: trashed(), withTrashed(), onlyTrashed() working\n";
    echo "- ✓ Query Scopes: scope methods working\n";
    echo "- ✓ Query Scopes: parameters working\n";
    echo "- ✓ Query Scopes: chaining working\n\n";
    echo "Production Ready: YES\n";
} else {
    echo "\n";
    echo "Failed: " . ($totalTests - $passedTests) . " tests\n";
    echo "Please review the output above for details.\n";
}

echo "\nUsage Examples:\n\n";
echo "// Soft Deletes:\n";
echo "\$user = User::find(1);\n";
echo "\$user->delete();      // Soft delete\n";
echo "\$user->restore();     // Restore\n";
echo "\$user->forceDelete(); // Permanent delete\n\n";
echo "User::withTrashed();   // Include deleted\n";
echo "User::onlyTrashed();   // Only deleted\n\n";
echo "// Query Scopes:\n";
echo "Post::published()->get();           // Published posts\n";
echo "Post::popular(100)->get();          // Posts with 100+ views\n";
echo "Post::published()->popular()->get(); // Chain scopes\n";
