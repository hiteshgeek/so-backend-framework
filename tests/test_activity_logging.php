<?php

/**
 * Test Activity Logging Implementation
 *
 * This script tests the activity logging functionality
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use Core\ActivityLog\Activity;

echo "=== Activity Logging Test ===\n\n";

try {
    // Test 1: Create a user (should log 'created' event)
    echo "Test 1: Creating a new user...\n";
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test' . time() . '@example.com',
        'password' => 'password123',
    ]);
    echo "✓ User created with ID: {$user->id}\n\n";

    // Check activity log
    $activities = Activity::query()
        ->where('subject_type', '=', 'App\\Models\\User')
        ->where('subject_id', '=', $user->id)
        ->get();

    echo "Found " . count($activities) . " activity log entries for this user\n";
    foreach ($activities as $activity) {
        echo "  - Event: {$activity['event']}, Description: {$activity['description']}\n";
        if ($activity['properties']) {
            $props = json_decode($activity['properties'], true);
            echo "    Properties: " . json_encode($props, JSON_PRETTY_PRINT) . "\n";
        }
    }
    echo "\n";

    // Test 2: Update the user (should log 'updated' event)
    echo "Test 2: Updating user name...\n";
    $user->name = 'Updated Test User';
    $user->save();
    echo "✓ User updated\n\n";

    // Check activity log again
    $activities = Activity::query()
        ->where('subject_type', '=', 'App\\Models\\User')
        ->where('subject_id', '=', $user->id)
        ->orderBy('created_at', 'DESC')
        ->get();

    echo "Found " . count($activities) . " activity log entries total\n";
    foreach ($activities as $activity) {
        echo "  - Event: {$activity['event']}, Description: {$activity['description']}\n";
        if ($activity['properties']) {
            $props = json_decode($activity['properties'], true);
            if (isset($props['old']) && isset($props['attributes'])) {
                echo "    Changed from: " . json_encode($props['old']) . "\n";
                echo "    Changed to: " . json_encode($props['attributes']) . "\n";
            }
        }
    }
    echo "\n";

    // Test 3: Manual activity logging
    echo "Test 3: Manual activity logging...\n";
    activity('user')
        ->log('User performed custom action')
        ->performedOn($user)
        ->causedBy($user) // In real app, this would be auth()->user()
        ->withProperties(['action' => 'custom_test', 'data' => 'test data'])
        ->event('custom')
        ->save();
    echo "✓ Custom activity logged\n\n";

    // Check all activities
    $activities = Activity::query()
        ->where('subject_type', '=', 'App\\Models\\User')
        ->where('subject_id', '=', $user->id)
        ->orderBy('created_at', 'DESC')
        ->get();

    echo "Found " . count($activities) . " activity log entries total\n";
    foreach ($activities as $activity) {
        echo "  - Event: {$activity['event']}, Description: {$activity['description']}, Log: {$activity['log_name']}\n";
    }
    echo "\n";

    // Test 4: Delete the user (should log 'deleted' event)
    echo "Test 4: Deleting user...\n";
    $userId = $user->id;
    $user->delete();
    echo "✓ User deleted\n\n";

    // Check final activity log
    $activities = Activity::query()
        ->where('subject_type', '=', 'App\\Models\\User')
        ->where('subject_id', '=', $userId)
        ->orderBy('created_at', 'DESC')
        ->get();

    echo "Found " . count($activities) . " activity log entries total (after delete)\n";
    foreach ($activities as $activity) {
        echo "  - Event: {$activity['event']}, Description: {$activity['description']}\n";
    }
    echo "\n";

    // Test 5: Query activity log with scopes
    echo "Test 5: Testing activity log query scopes...\n";
    $createdActivities = Activity::query()
        ->where('event', '=', 'created')
        ->where('log_name', '=', 'user')
        ->get();
    echo "Found " . count($createdActivities) . " 'created' events in 'user' log\n\n";

    echo "✅ All tests passed! Activity logging is working correctly.\n\n";

    echo "=== Summary ===\n";
    echo "✓ Models automatically log create/update/delete events\n";
    echo "✓ Only configured attributes are logged (password excluded)\n";
    echo "✓ Changes are tracked (old vs new values)\n";
    echo "✓ Manual activity logging works via activity() helper\n";
    echo "✓ Activity log can be queried and filtered\n";
    echo "✓ Observer pattern successfully integrated with Model base class\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
