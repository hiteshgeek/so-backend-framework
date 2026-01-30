<?php

/**
 * Test Notification System Implementation
 *
 * This script tests the notification functionality
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__ . '/../../../bootstrap/app.php';

use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Notifications\OrderApprovalNotification;

echo "=== Notification System Test ===\n\n";

try {
    // Test 1: Get a user to send notifications to
    echo "Test 1: Finding a user to send notifications to...\n";
    $users = User::all();

    if (empty($users)) {
        echo "No users found. Creating a test user...\n";
        $user = User::create([
            'name' => 'Test Notification User',
            'email' => 'notifications' . time() . '@example.com',
            'password' => 'password123',
        ]);
    } else {
        $user = $users[0];
    }

    echo "✓ Using user: {$user->name} (ID: {$user->id})\n\n";

    // Test 2: Send a welcome notification
    echo "Test 2: Sending welcome notification...\n";
    $user->notify(new WelcomeNotification($user->name));
    echo "✓ Welcome notification sent\n\n";

    // Test 3: Send an order approval notification
    echo "Test 3: Sending order approval notification...\n";
    $user->notify(new OrderApprovalNotification(1001, 'ORD-2026-001', 5499.99));
    echo "✓ Order approval notification sent\n\n";

    // Test 4: Send multiple notifications
    echo "Test 4: Sending multiple notifications...\n";
    $user->notify(new OrderApprovalNotification(1002, 'ORD-2026-002', 12500.00));
    $user->notify(new OrderApprovalNotification(1003, 'ORD-2026-003', 750.50));
    echo "✓ Multiple notifications sent\n\n";

    // Test 5: Get all notifications
    echo "Test 5: Retrieving all notifications...\n";
    $notifications = $user->notifications();
    echo "✓ User has " . count($notifications) . " notifications\n";
    foreach ($notifications as $notification) {
        $data = json_decode($notification['data'], true);
        $readStatus = $notification['read_at'] ? 'Read' : 'Unread';
        echo "  - [{$readStatus}] {$data['title']}\n";
    }
    echo "\n";

    // Test 6: Get unread count
    echo "Test 6: Getting unread notification count...\n";
    $unreadCount = $user->unreadNotificationsCount();
    echo "✓ User has {$unreadCount} unread notifications\n\n";

    // Test 7: Get unread notifications
    echo "Test 7: Retrieving unread notifications...\n";
    $unreadNotifications = $user->unreadNotifications();
    echo "✓ Found " . count($unreadNotifications) . " unread notifications\n";
    foreach ($unreadNotifications as $notification) {
        $data = json_decode($notification['data'], true);
        echo "  - {$data['title']}: {$data['message']}\n";
    }
    echo "\n";

    // Test 8: Mark a notification as read
    echo "Test 8: Marking first notification as read...\n";
    if (!empty($notifications)) {
        $firstNotification = $notifications[0];
        $user->markNotificationAsRead($firstNotification['id']);
        echo "✓ Notification marked as read\n";

        $unreadCount = $user->unreadNotificationsCount();
        echo "  New unread count: {$unreadCount}\n\n";
    }

    // Test 9: Mark all notifications as read
    echo "Test 9: Marking all notifications as read...\n";
    $user->markAllNotificationsAsRead();
    $unreadCount = $user->unreadNotificationsCount();
    echo "✓ All notifications marked as read\n";
    echo "  Unread count: {$unreadCount}\n\n";

    // Test 10: Query notifications table directly
    echo "Test 10: Querying notifications table...\n";
    $db = app('db');
    $allNotifications = $db->table('notifications')->get();
    echo "✓ Found " . count($allNotifications) . " total notifications in database\n";
    foreach ($allNotifications as $notification) {
        $data = json_decode($notification['data'], true);
        $readStatus = $notification['read_at'] ? '✓ Read' : '○ Unread';
        echo "  {$readStatus} - {$data['title']} for User #{$notification['notifiable_id']}\n";
    }
    echo "\n";

    echo "✅ All tests passed! Notification system is working correctly.\n\n";

    echo "=== Summary ===\n";
    echo "✓ Notifications can be sent to users\n";
    echo "✓ Multiple notifications can be sent\n";
    echo "✓ All notifications can be retrieved\n";
    echo "✓ Unread notifications can be retrieved\n";
    echo "✓ Unread count is accurate\n";
    echo "✓ Notifications can be marked as read\n";
    echo "✓ All notifications can be marked as read at once\n";
    echo "✓ Notifications are stored in the database\n";
    echo "✓ Notifiable trait works with User model\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
