# Events & Listeners - Developer Guide

**SO Framework** | **Event-Driven Architecture** | **Version 1.0**

A comprehensive guide to using events and listeners to decouple application logic and create extensible, maintainable code.

---

## Table of Contents

1. [Overview](#overview)
2. [Roadmap](#roadmap)
3. [Creating Events](#creating-events)
4. [Creating Listeners](#creating-listeners)
5. [Registering Events](#registering-events)
6. [Dispatching Events](#dispatching-events)
7. [Best Practices](#best-practices)
8. [Common Event Patterns](#common-event-patterns)
9. [Complete Example](#complete-example)

---

> **⚠️ Implementation Status**
>
> The event system is **partially implemented**. Core functionality (creating events, listeners, and dispatching) works perfectly. However, some advanced features documented below are **planned but not yet available**:
>
> - **EventServiceProvider** - Centralized event registration (currently manual)
> - **ShouldQueue Interface** - Queued event listeners (use Queue system directly)
> - **Auto-discovery** - Automatic event/listener registration
>
> See the [Roadmap](#roadmap) section for planned features and current workarounds.

---

## Overview

Events provide a way to decouple different parts of your application. When something happens (a user registers, an order is placed), you fire an event. Multiple listeners can respond to that event without the triggering code knowing about them.

### Benefits

- **Decoupling** -- Controllers don't need to know about emails, logging, analytics, etc.
- **Extensibility** -- Add new features by adding listeners, not modifying existing code
- **Testability** -- Test business logic separately from side effects
- **Reusability** -- Same event can trigger multiple actions

### How Events Work

```
Controller                Event System              Listeners
     |                          |                         |
     | Fire Event               |                         |
     |----------------------->  |                         |
     |                          |  Notify Listener 1      |
     |                          |-----------------------> |
     |                          |                         | Send Email
     |                          |                         |
     |                          |  Notify Listener 2      |
     |                          |-----------------------> |
     |                          |                         | Log Activity
     |                          |                         |
     | Continue                 |                         |
     |<---------------------    |                         |
```

---

## Roadmap

### Current Implementation (Available Now)

✅ **Event Classes** - Create custom events extending `Core\Events\Event`
✅ **Listener Classes** - Create listeners implementing `Core\Events\Listener`
✅ **Manual Registration** - Register listeners using `EventDispatcher`
✅ **Event Dispatching** - Fire events with `event()` helper
✅ **Wildcard Listeners** - Listen to multiple events with patterns like `user.*`
✅ **Event Subscribers** - Group related listeners in subscriber classes
✅ **Propagation Control** - Stop event propagation from listeners

### Planned Features (Not Yet Implemented)

🔄 **EventServiceProvider** - Centralized event registration via provider class
🔄 **ShouldQueue Interface** - Automatic queuing of listeners with interface
🔄 **Auto-discovery** - Automatically find and register events/listeners
🔄 **Event Broadcasting** - Broadcast events to WebSockets/Pusher

### Current Workarounds

Until EventServiceProvider is implemented, register events manually in `bootstrap/app.php` or a custom service provider:

```php
<?php
// bootstrap/app.php or custom provider

use Core\Events\EventDispatcher;
use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;

$dispatcher = app('events');

// Register individual listeners
$dispatcher->listen(UserRegistered::class, SendWelcomeEmail::class);

// Or use closures
$dispatcher->listen('user.registered', function($event) {
    logger()->info('User registered', ['user_id' => $event->userId]);
});

// Or use wildcard patterns
$dispatcher->listen('user.*', [AuditLogger::class, 'handle']);
```

For queued listeners, manually queue the work inside the listener:

```php
<?php
class SendWelcomeEmail implements Listener
{
    public function handle(UserRegistered $event): void
    {
        // Queue the email manually
        queue(function() use ($event) {
            $user = User::find($event->userId);
            Mail::to($user->email)->send(new WelcomeEmail($user->toArray()));
        });
    }
}
```

---

## Creating Events

### Generate an Event Class

```bash
./sixorbit make:event UserRegistered
```

Creates `app/Events/UserRegistered.php`:

```php
<?php

namespace App\Events;

use Core\Events\Event;

class UserRegistered extends Event
{
    public function __construct(
        public array $user
    ) {}
}
```

### Event Class Structure

Events are simple data containers. They hold information about what happened:

```php
<?php

namespace App\Events;

use Core\Events\Event;

class OrderPlaced extends Event
{
    public function __construct(
        public int $orderId,
        public int $userId,
        public float $total
    ) {}
}
```

**Best Practices:**
- Use public properties (easier to access in listeners)
- Pass primitive types or arrays (avoid passing full models)
- Name events in past tense: `UserRegistered`, `OrderPlaced`, `PaymentProcessed`

---

## Creating Listeners

### Generate a Listener Class

```bash
./sixorbit make:listener SendWelcomeEmail
```

Creates `app/Listeners/SendWelcomeEmail.php`:

```php
<?php

namespace App\Listeners;

use Core\Events\Listener;
use App\Events\UserRegistered;

class SendWelcomeEmail implements Listener
{
    public function handle($event): void
    {
        // Listener logic here
    }
}
```

### Complete Listener Example

```php
<?php

namespace App\Listeners;

use Core\Events\Listener;
use App\Events\UserRegistered;
use App\Models\User;
use App\Mail\WelcomeEmail;
use Core\Mail\Mail;

class SendWelcomeEmail implements Listener
{
    public function handle(UserRegistered $event): void
    {
        $user = User::find($event->user['id']);

        if (!$user) {
            return;
        }

        Mail::to($user->email)->queue(new WelcomeEmail($user->toArray()));
    }
}
```

### Multiple Listeners for One Event

```php
// app/Listeners/LogUserRegistration.php
class LogUserRegistration implements Listener
{
    public function handle(UserRegistered $event): void
    {
        activity_log('user.registered', $event->user);
    }
}

// app/Listeners/SendWelcomeEmail.php
class SendWelcomeEmail implements Listener
{
    public function handle(UserRegistered $event): void
    {
        Mail::to($event->user['email'])->queue(new WelcomeEmail($event->user));
    }
}

// app/Listeners/UpdateAnalytics.php
class UpdateAnalytics implements Listener
{
    public function handle(UserRegistered $event): void
    {
        analytics()->track('user_registered', [
            'user_id' => $event->user['id'],
            'timestamp' => time(),
        ]);
    }
}
```

All three listeners execute when `UserRegistered` fires.

---

## Registering Events

### Current Implementation: Manual Registration

Since EventServiceProvider is not yet implemented, register event listeners manually using the `EventDispatcher`. You can do this in `bootstrap/app.php` or create a custom service provider.

**Option 1: Register in bootstrap/app.php**

```php
<?php
// bootstrap/app.php

use Core\Events\EventDispatcher;
use App\Events\UserRegistered;
use App\Events\OrderPlaced;
use App\Events\PaymentFailed;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\LogUserRegistration;
use App\Listeners\UpdateAnalytics;

$dispatcher = app('events');

// UserRegistered event
$dispatcher->listen(UserRegistered::class, SendWelcomeEmail::class);
$dispatcher->listen(UserRegistered::class, LogUserRegistration::class);
$dispatcher->listen(UserRegistered::class, UpdateAnalytics::class);

// OrderPlaced event
$dispatcher->listen(OrderPlaced::class, SendOrderConfirmation::class);
$dispatcher->listen(OrderPlaced::class, UpdateInventory::class);
$dispatcher->listen(OrderPlaced::class, NotifyWarehouse::class);

// PaymentFailed event
$dispatcher->listen(PaymentFailed::class, NotifyAdmin::class);
$dispatcher->listen(PaymentFailed::class, LogPaymentFailure::class);
```

**Option 2: Create a Custom Service Provider**

For better organization, create your own provider:

```php
<?php
// app/Providers/AppEventProvider.php

namespace App\Providers;

use Core\Events\EventDispatcher;
use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;

class AppEventProvider
{
    public function register(EventDispatcher $dispatcher): void
    {
        $dispatcher->listen(UserRegistered::class, SendWelcomeEmail::class);
        $dispatcher->listen(UserRegistered::class, LogUserRegistration::class);
        // ... register more events
    }
}
```

Then call it in `bootstrap/app.php`:

```php
$provider = new \App\Providers\AppEventProvider();
$provider->register(app('events'));
```

### Register with Closures

You can also register listeners as closures for simple use cases:

```php
$dispatcher->listen(UserRegistered::class, function($event) {
    logger()->info('User registered', ['user_id' => $event->userId]);
});
```

### Wildcard Event Listeners

Listen to multiple events using wildcard patterns:

```php
// Listen to all user-related events
$dispatcher->listen('user.*', function($event) {
    logger()->info('User event fired', ['event' => get_class($event)]);
});

// Listen to all events
$dispatcher->listen('*', [AuditLogger::class, 'handle']);
```

> **Future:** When EventServiceProvider is implemented, you'll be able to register events in a centralized array like Laravel. This manual approach will still work for custom registration logic.

---

## Dispatching Events

### Fire an Event

Use the `event()` helper or `Event::dispatch()`:

```php
use App\Events\UserRegistered;

public function register(Request $request): Response
{
    $user = User::create($request->all());

    // Fire the event
    event(new UserRegistered($user->toArray()));

    return redirect('/dashboard');
}
```

### Alternative Dispatch Syntax

```php
use Core\Events\Event;
use App\Events\OrderPlaced;

Event::dispatch(new OrderPlaced($order->id, $user->id, $order->total));
```

### Events in Models

Fire events from model methods:

```php
class User extends Model
{
    public static function register(array $data): self
    {
        $user = self::create($data);

        event(new UserRegistered($user->toArray()));

        return $user;
    }
}
```

Usage:

```php
$user = User::register($request->all());
```

---

## Best Practices

### 1. Keep Listeners Independent

Each listener should work independently. Don't rely on execution order:

```php
// Bad - Listener B depends on Listener A's side effect
class ListenerA
{
    public function handle($event)
    {
        cache()->put('user_count', User::count());
    }
}

class ListenerB
{
    public function handle($event)
    {
        $count = cache('user_count'); // Depends on ListenerA running first!
    }
}

// Good - Each listener is self-contained
class ListenerA
{
    public function handle($event)
    {
        cache()->put('user_count', User::count());
    }
}

class ListenerB
{
    public function handle($event)
    {
        $count = User::count(); // Gets data directly
    }
}
```

### 2. Queue Long-Running Listeners

Listeners execute synchronously by default. For slow operations (sending emails, API calls, file processing), manually queue the work to avoid blocking the request.

> **Note:** The `ShouldQueue` interface is planned but not yet implemented. Use manual queuing as shown below.

**Current Approach: Manual Queuing**

```php
<?php

namespace App\Listeners;

use Core\Events\Listener;
use App\Events\UserRegistered;
use App\Models\User;
use App\Mail\WelcomeEmail;
use Core\Mail\Mail;

class SendWelcomeEmail implements Listener
{
    public function handle(UserRegistered $event): void
    {
        // Queue the email manually using queue() helper
        queue(function() use ($event) {
            $user = User::find($event->userId);
            Mail::to($user->email)->send(new WelcomeEmail($user->toArray()));
        });
    }
}
```

**Alternative: Queue via Mail System**

The Mail system has built-in queuing:

```php
class SendWelcomeEmail implements Listener
{
    public function handle(UserRegistered $event): void
    {
        $user = User::find($event->userId);

        // queue() method handles queueing automatically
        Mail::to($user->email)->queue(new WelcomeEmail($user->toArray()));
    }
}
```

> **Future:** When `ShouldQueue` interface is implemented, you'll simply add `implements ShouldQueue` to automatically queue the entire listener.

### 3. Use Events for Side Effects, Not Core Logic

**Good Use Cases:**
- Sending emails
- Logging activity
- Updating analytics
- Clearing caches
- Notifying external services

**Bad Use Cases:**
- Critical business logic (put this in services)
- Data validation (use validators)
- Required database updates (do in transactions)

### 4. Name Events Clearly

Events should describe **what happened**, not **what should happen**:

**Good:**
- `UserRegistered`
- `OrderPlaced`
- `PaymentProcessed`
- `InvoiceCreated`

**Bad:**
- `SendWelcomeEmail` (that's a listener)
- `ProcessOrder` (that's an action)
- `UserEvent` (too vague)

### 5. Pass Minimal Data

Only pass what listeners need:

```php
// Bad - passes entire request
event(new UserRegistered($request->all()));

// Good - passes only user data
event(new UserRegistered($user->toArray()));

// Better - passes only ID (listeners fetch fresh data)
event(new UserRegistered($user->id));
```

### 6. Handle Listener Failures Gracefully

One listener failing shouldn't break others:

```php
public function handle($event): void
{
    try {
        Mail::to($event->user['email'])->send(new WelcomeEmail($event->user));
    } catch (\Exception $e) {
        logger()->error('Failed to send welcome email', [
            'user_id' => $event->user['id'],
            'error' => $e->getMessage(),
        ]);

        // Don't rethrow - let other listeners run
    }
}
```

---

## Common Event Patterns

### 1. Model Events

Fire events on model actions:

```php
class Order extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($order) {
            event(new OrderPlaced($order->id));
        });

        static::updated(function ($order) {
            event(new OrderUpdated($order->id));
        });
    }
}
```

### 2. Conditional Events

Fire events based on conditions:

```php
public function updateStatus(Request $request): Response
{
    $order = Order::find($request->input('id'));
    $oldStatus = $order->status;
    $order->update(['status' => $request->input('status')]);

    if ($oldStatus !== 'shipped' && $order->status === 'shipped') {
        event(new OrderShipped($order->id));
    }

    return json(['message' => 'Status updated']);
}
```

### 3. Event Chaining

One event triggering another:

```php
class ProcessPayment implements Listener
{
    public function handle(OrderPlaced $event): void
    {
        $payment = $this->chargeCard($event->orderId);

        if ($payment->successful) {
            event(new PaymentProcessed($payment->id));
        } else {
            event(new PaymentFailed($payment->id));
        }
    }
}
```

---

## Complete Example

### Scenario: User Registration

**Event:**
```php
// app/Events/UserRegistered.php
namespace App\Events;

use Core\Events\Event;

class UserRegistered extends Event
{
    public function __construct(public int $userId) {}
}
```

**Listeners:**
```php
// app/Listeners/SendWelcomeEmail.php
class SendWelcomeEmail implements Listener
{
    public function handle(UserRegistered $event): void
    {
        $user = User::find($event->userId);

        // Queue email to avoid blocking
        Mail::to($user->email)->queue(new WelcomeEmail($user->toArray()));
    }
}

// app/Listeners/CreateDefaultSettings.php
class CreateDefaultSettings implements Listener
{
    public function handle(UserRegistered $event): void
    {
        UserSettings::create([
            'user_id' => $event->userId,
            'theme' => 'light',
            'notifications' => true,
        ]);
    }
}

// app/Listeners/TrackRegistration.php
class TrackRegistration implements Listener
{
    public function handle(UserRegistered $event): void
    {
        activity_log('user.registered', ['user_id' => $event->userId]);
        analytics()->track('registration', ['user_id' => $event->userId]);
    }
}
```

**Registration:**
```php
// bootstrap/app.php or custom provider
use Core\Events\EventDispatcher;
use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\CreateDefaultSettings;
use App\Listeners\TrackRegistration;

$dispatcher = app('events');

$dispatcher->listen(UserRegistered::class, SendWelcomeEmail::class);
$dispatcher->listen(UserRegistered::class, CreateDefaultSettings::class);
$dispatcher->listen(UserRegistered::class, TrackRegistration::class);
```

**Dispatch:**
```php
// app/Controllers/AuthController.php
public function register(Request $request): Response
{
    $user = User::create($request->all());

    event(new UserRegistered($user->id));

    return redirect('/dashboard');
}
```

---

## See Also

- **[Queue System](DEV-QUEUES.md)** - Queue long-running tasks from listeners
- **[Mail System](DEV-MAIL.md)** - Send emails from event listeners
- **[Activity Logging](ACTIVITY-LOGGING.md)** - Track events automatically with LogsActivity trait
- **[Service Layer](SERVICE-LAYER.md)** - Fire events from service methods
- **[CLI Commands](CONSOLE-COMMANDS.md)** - `make:event` and `make:listener` commands
- **[Model Events](DEV-MODELS.md)** - Fire events on model create/update/delete

---

**Last Updated**: 2026-02-01
**Framework Version**: 1.0
