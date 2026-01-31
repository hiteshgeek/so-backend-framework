# Events & Listeners - Developer Guide

**SO Framework** | **Event-Driven Architecture** | **Version 1.0**

A comprehensive guide to using events and listeners to decouple application logic and create extensible, maintainable code.

---

## Table of Contents

1. [Overview](#overview)
2. [Creating Events](#creating-events)
3. [Creating Listeners](#creating-listeners)
4. [Registering Events](#registering-events)
5. [Dispatching Events](#dispatching-events)
6. [Best Practices](#best-practices)

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

### Register in Event Service Provider

Edit `app/Providers/EventServiceProvider.php`:

```php
<?php

namespace App\Providers;

use Core\Events\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected array $listen = [
        \App\Events\UserRegistered::class => [
            \App\Listeners\SendWelcomeEmail::class,
            \App\Listeners\LogUserRegistration::class,
            \App\Listeners\UpdateAnalytics::class,
        ],

        \App\Events\OrderPlaced::class => [
            \App\Listeners\SendOrderConfirmation::class,
            \App\Listeners\UpdateInventory::class,
            \App\Listeners\NotifyWarehouse::class,
        ],

        \App\Events\PaymentFailed::class => [
            \App\Listeners\NotifyAdmin::class,
            \App\Listeners\LogPaymentFailure::class,
        ],
    ];
}
```

### Register Provider in bootstrap/app.php

Ensure the provider is registered:

```php
$app->register(\App\Providers\EventServiceProvider::class);
```

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

Listeners execute synchronously by default. Queue slow operations:

```php
<?php

namespace App\Listeners;

use Core\Events\Listener;
use Core\Queue\ShouldQueue;

class SendWelcomeEmail implements Listener, ShouldQueue
{
    public function handle($event): void
    {
        // This runs in a background queue
        Mail::to($event->user['email'])->send(new WelcomeEmail($event->user));
    }
}
```

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
class SendWelcomeEmail implements Listener, ShouldQueue
{
    public function handle(UserRegistered $event): void
    {
        $user = User::find($event->userId);
        Mail::to($user->email)->send(new WelcomeEmail($user->toArray()));
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
// app/Providers/EventServiceProvider.php
protected array $listen = [
    UserRegistered::class => [
        SendWelcomeEmail::class,
        CreateDefaultSettings::class,
        TrackRegistration::class,
    ],
];
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

**Related Documentation:**
- [Queue System](/docs/dev/queues) - Queueing listeners
- [Mail System](/docs/dev/mail) - Sending emails from listeners
- [CLI Commands](/docs/dev/cli-commands) - Event command reference

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
