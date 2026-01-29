# Notification System

**User Communication and Workflow Alerts**

The Notification System provides in-app notifications for workflow events, task assignments, alerts, and system announcements. Essential for keeping users informed and engaged.

---

## Table of Contents

1. [Introduction](#introduction)
2. [Quick Start](#quick-start)
3. [Architecture](#architecture)
4. [Creating Notifications](#creating-notifications)
5. [Sending Notifications](#sending-notifications)
6. [Managing Notifications](#managing-notifications)
7. [Configuration](#configuration)
8. [ERP Use Cases](#erp-use-cases)
9. [Best Practices](#best-practices)

---

## Introduction

### What are Notifications?

Notifications are messages sent to users about:
- Workflow events (approvals, assignments)
- System alerts (low inventory, payment due)
- Task updates (order shipped, report ready)
- Announcements (maintenance, new features)

### Why Important for ERP?

**User Experience**:
- Keep users informed of important events
- Reduce email clutter with in-app notifications
- Real-time updates on workflow status
- Centralized notification center

**Workflow Efficiency**:
- Immediate task assignments
- Approval request notifications
- Status change alerts
- Deadline reminders

---

## Quick Start

### Step 1: Add Notifiable Trait to Model

```php
<?php

namespace App\Models;

use Core\Model\Model;
use Core\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'email'];
}
```

### Step 2: Create Notification Class

Create a notification in `app/Notifications/`:

```php
<?php

namespace App\Notifications;

use Core\Notifications\Notification;

class OrderShipped extends Notification
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
        $this->id = uniqid('notif_', true);
    }

    public function via(): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Order Shipped',
            'message' => "Your order #{$this->order['id']} has been shipped",
            'url' => "/orders/{$this->order['id']}",
            'order_id' => $this->order['id']
        ];
    }
}
```

### Step 3: Send Notification

```php
// Send to single user
$user = User::find(1);
$user->notify(new OrderShipped($order));

// Send to multiple users
$users = User::where('role', 'manager')->get();
foreach ($users as $user) {
    $user->notify(new ApprovalRequired($document));
}
```

### Step 4: Display Notifications

```php
// Get unread notifications
$notifications = $user->unreadNotifications;

foreach ($notifications as $notification) {
    $data = json_decode($notification['data'], true);
    echo "[{$data['title']}] {$data['message']}\n";
}
```

---

## Architecture

### Components

**1. Notification Class** (`core/Notifications/Notification.php`)
- Abstract base class for all notifications
- Defines channels (database, mail, sms)
- Formats notification data

**2. Notifiable Trait** (`core/Notifications/Notifiable.php`)
- Added to models that receive notifications
- Provides `notify()` method
- Accesses `notifications()` and `unreadNotifications()`

**3. DatabaseChannel** (`core/Notifications/DatabaseChannel.php`)
- Stores notifications in database
- Implements polymorphic relationships
- Tracks read/unread status

**4. NotificationManager** (`core/Notifications/NotificationManager.php`)
- Dispatches notifications to channels
- Manages multiple notification channels

### Database Schema

```sql
CREATE TABLE notifications (
    id CHAR(36) PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    data TEXT NOT NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_notifiable (notifiable_type, notifiable_id),
    INDEX idx_read_at (read_at)
);
```

---

## Creating Notifications

### Basic Notification

```php
<?php

namespace App\Notifications;

use Core\Notifications\Notification;

class WelcomeNotification extends Notification
{
    public function __construct()
    {
        $this->id = uniqid('notif_', true);
    }

    public function via(): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Welcome!',
            'message' => "Welcome to our ERP system, {$notifiable->name}!",
            'url' => '/dashboard'
        ];
    }
}
```

### Notification with Data

```php
class InvoicePaid extends Notification
{
    protected $invoice;
    protected $payment;

    public function __construct($invoice, $payment)
    {
        $this->invoice = $invoice;
        $this->payment = $payment;
        $this->id = uniqid('notif_', true);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Invoice Paid',
            'message' => "Invoice #{$this->invoice['number']} has been paid",
            'amount' => $this->payment['amount'],
            'invoice_id' => $this->invoice['id'],
            'payment_method' => $this->payment['method'],
            'url' => "/invoices/{$this->invoice['id']}"
        ];
    }
}
```

### Multi-Channel Notification

```php
class UrgentAlert extends Notification
{
    protected $message;

    public function via(): array
    {
        // Send via multiple channels
        return ['database', 'mail'];  // Future: 'sms', 'slack'
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Urgent Alert',
            'message' => $this->message,
            'priority' => 'high'
        ];
    }

    public function toMail($notifiable): array
    {
        // Email format (future feature)
        return [
            'subject' => 'Urgent Alert',
            'body' => $this->message
        ];
    }
}
```

---

## Sending Notifications

### Send to Single User

```php
$user = User::find($userId);
$user->notify(new TaskAssigned($task));
```

### Send to Multiple Users

```php
// Get all managers
$managers = User::where('role', 'manager')->get();

// Send to each
foreach ($managers as $manager) {
    $manager->notify(new ApprovalRequired($document));
}
```

### Conditional Sending

```php
if ($order->total > 10000) {
    // High-value orders: notify finance team
    $financeTeam = User::where('department', 'finance')->get();
    foreach ($financeTeam as $user) {
        $user->notify(new HighValueOrder($order));
    }
}
```

### Queue Notifications

For bulk notifications, use queue system:

```php
class NotifyAllUsers extends Job
{
    protected $notification;

    public function handle(): void
    {
        $users = User::where('status', 'active')->get();

        foreach ($users as $user) {
            $user->notify($this->notification);
        }
    }
}

// Dispatch job
dispatch(new NotifyAllUsers(new MaintenanceScheduled()));
```

---

## Managing Notifications

### Retrieve Notifications

**All notifications**:
```php
$notifications = $user->notifications;
```

**Unread only**:
```php
$unread = $user->unreadNotifications;
```

**Custom query**:
```php
$recent = DB::table('notifications')
    ->where('notifiable_type', 'App\\Models\\User')
    ->where('notifiable_id', $userId)
    ->where('created_at', '>=', date('Y-m-d', strtotime('-7 days')))
    ->orderBy('created_at', 'DESC')
    ->get();
```

### Mark as Read

**Single notification**:
```php
$channel = app('notification.channel');
$channel->markAsRead($notificationId);
```

**All notifications**:
```php
$channel = app('notification.channel');
$channel->markAllAsRead('App\\Models\\User', $userId);
```

### Delete Notifications

```php
$channel = app('notification.channel');
$channel->delete($notificationId);
```

### Get Unread Count

```php
$count = DB::table('notifications')
    ->where('notifiable_type', 'App\\Models\\User')
    ->where('notifiable_id', $userId)
    ->whereNull('read_at')
    ->count();
```

---

## Configuration

### config/notifications.php

```php
<?php

return [
    // Default channel
    'default' => env('NOTIFICATION_CHANNEL', 'database'),

    // Available channels
    'channels' => [
        'database' => [
            'driver' => 'database',
            'table' => 'notifications',
        ],
    ],

    // Queue notifications?
    'queue_notifications' => env('QUEUE_NOTIFICATIONS', false),

    // Auto-delete read notifications older than X days
    'prune_read_after_days' => env('NOTIFICATION_PRUNE_DAYS', 30),
];
```

### Environment Variables

```env
NOTIFICATION_CHANNEL=database
QUEUE_NOTIFICATIONS=false
NOTIFICATION_PRUNE_DAYS=30
```

### Cleanup Old Notifications

```bash
# Delete read notifications older than 30 days
php sixorbit notification:cleanup --days=30
```

---

## ERP Use Cases

### 1. Approval Workflows

```php
class PurchaseOrderApprovalRequest extends Notification
{
    protected $po;

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Approval Required',
            'message' => "Purchase Order #{$this->po['number']} awaits your approval",
            'amount' => $this->po['total'],
            'vendor' => $this->po['vendor_name'],
            'url' => "/purchase-orders/{$this->po['id']}/approve",
            'actions' => [
                ['label' => 'Approve', 'url' => "/api/po/{$this->po['id']}/approve"],
                ['label' => 'Reject', 'url' => "/api/po/{$this->po['id']}/reject"]
            ]
        ];
    }
}

// Send to approvers
$approvers = User::where('can_approve_po', true)->get();
foreach ($approvers as $approver) {
    $approver->notify(new PurchaseOrderApprovalRequest($po));
}
```

### 2. Task Assignments

```php
class TaskAssigned extends Notification
{
    protected $task;

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'New Task Assigned',
            'message' => "You have been assigned: {$this->task['title']}",
            'due_date' => $this->task['due_date'],
            'priority' => $this->task['priority'],
            'url' => "/tasks/{$this->task['id']}"
        ];
    }
}
```

### 3. Inventory Alerts

```php
class LowStockAlert extends Notification
{
    protected $product;

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Low Stock Alert',
            'message' => "{$this->product['name']} stock is low ({$this->product['quantity']} remaining)",
            'product_id' => $this->product['id'],
            'current_stock' => $this->product['quantity'],
            'reorder_level' => $this->product['reorder_level'],
            'url' => "/products/{$this->product['id']}/reorder"
        ];
    }
}
```

### 4. Order Status Updates

```php
class OrderStatusChanged extends Notification
{
    protected $order;
    protected $oldStatus;
    protected $newStatus;

    public function toDatabase($notifiable): array
    {
        $statusMessages = [
            'pending' => 'Your order is being processed',
            'confirmed' => 'Your order has been confirmed',
            'shipped' => 'Your order has been shipped',
            'delivered' => 'Your order has been delivered'
        ];

        return [
            'title' => 'Order Status Update',
            'message' => $statusMessages[$this->newStatus] ?? 'Order status changed',
            'order_number' => $this->order['number'],
            'status' => $this->newStatus,
            'url' => "/orders/{$this->order['id']}"
        ];
    }
}
```

### 5. Payment Reminders

```php
class PaymentDueReminder extends Notification
{
    protected $invoice;
    protected $daysUntilDue;

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Payment Reminder',
            'message' => "Invoice #{$this->invoice['number']} is due in {$this->daysUntilDue} days",
            'amount' => $this->invoice['total'],
            'due_date' => $this->invoice['due_date'],
            'url' => "/invoices/{$this->invoice['id']}/pay"
        ];
    }
}
```

---

## Best Practices

### 1. Meaningful Titles and Messages

```php
// [X] Bad
'title' => 'Update'
'message' => 'Something changed'

// [x] Good
'title' => 'Order Shipped'
'message' => "Your order #12345 has been shipped and will arrive on Jan 30"
```

### 2. Include Action URLs

Always provide a URL to relevant page:

```php
public function toDatabase($notifiable): array
{
    return [
        'title' => 'New Comment',
        'message' => "{$this->commenter} commented on your post",
        'url' => "/posts/{$this->postId}#comment-{$this->commentId}"  // [x] Direct link
    ];
}
```

### 3. Add Structured Data

Include structured data for frontend parsing:

```php
return [
    'title' => 'Invoice Paid',
    'message' => "Invoice #INV-001 paid",
    // Structured data
    'invoice_id' => 123,
    'amount' => 1000.00,
    'currency' => 'USD',
    'payment_method' => 'credit_card',
    'paid_at' => '2026-01-29 10:00:00'
];
```

### 4. Use Priority Levels

```php
return [
    'title' => 'System Alert',
    'message' => 'Critical error detected',
    'priority' => 'critical',  // critical, high, normal, low
    'requires_action' => true
];
```

### 5. Regular Cleanup

```bash
# Cron job (daily at 4 AM)
0 4 * * * php sixorbit notification:cleanup --days=30
```

### 6. Batch Notifications

Use queue system for bulk notifications:

```php
// [X] Bad: Blocks request
foreach ($users as $user) {
    $user->notify(new Announcement($text));
}

// [x] Good: Queue it
dispatch(new SendBulkNotifications($users, new Announcement($text)));
```

---

## Troubleshooting

### Notifications Not Appearing

**1. Check Notifiable trait**:
```php
class User extends Model {
    use Notifiable; // ← Make sure this is present
}
```

**2. Verify database record**:
```sql
SELECT * FROM notifications WHERE notifiable_id = 1 ORDER BY created_at DESC;
```

**3. Check channel configuration**:
```php
var_dump(config('notifications.channels.database'));
```

### Notification ID Conflicts

Ensure unique IDs:

```php
public function __construct()
{
    $this->id = uniqid('notif_', true); // ← Always generate unique ID
}
```

---

## Summary

The Notification System provides:

[x] **In-app notifications** - Keep users informed
[x] **Workflow alerts** - Approvals, assignments, status changes
[x] **Read/unread tracking** - User sees what's new
[x] **Flexible data** - Store any JSON data
[x] **Multiple channels** - Database (future: email, SMS, Slack)

**Essential for ERP:**
- Approval workflow notifications
- Task assignments and reminders
- Order and shipment updates
- Inventory and stock alerts
- Payment reminders

**Start notifying users today for better engagement and workflow efficiency.**

---

**Next Steps**:
- Create notification classes in `app/Notifications/`
- Set up `notification:cleanup` cron job
- Build notification center UI
- Review [Framework Features](/docs/framework-features) for overview

**Version**: 2.0.0 | **Last Updated**: 2026-01-29
