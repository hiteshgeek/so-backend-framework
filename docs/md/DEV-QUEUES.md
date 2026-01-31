# Queue System - Developer Guide

**SO Framework** | **Background Jobs & Queues** | **Version 1.0**

A comprehensive guide to processing background jobs, handling asynchronous tasks, and managing queue workers in the SO Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Creating Jobs](#creating-jobs)
3. [Dispatching Jobs](#dispatching-jobs)
4. [Running Queue Workers](#running-queue-workers)
5. [Job Lifecycle](#job-lifecycle)
6. [Best Practices](#best-practices)

---

## Overview

The queue system allows you to defer time-consuming tasks (sending emails, processing images, generating reports) to background workers, keeping your web requests fast.

### Benefits

- **Faster Responses** -- Return responses immediately, process work later
- **Better UX** -- Users don't wait for slow operations
- **Retry Logic** -- Automatically retry failed jobs
- **Scalability** -- Add more workers to handle increased load

### How Queues Work

```
User Request                Queue Worker
     |                           |
     |  Dispatch Job             |
     |---------------------->    |
     |  (Job stored in DB)       |
     |                           |
     |  Response (instant)       |
     |<----------------------    |
     |                           |
                                 |  Fetch Job from DB
                                 |  Execute Job
                                 |  Mark as Complete
```

Jobs are stored in the `jobs` table and processed by background workers started with `./sixorbit queue:work`.

---

## Creating Jobs

### Generate a Job Class

```bash
./sixorbit make:job SendWelcomeEmail
```

Creates `app/Jobs/SendWelcomeEmail.php`:

```php
<?php

namespace App\Jobs;

use Core\Queue\Job;

class SendWelcomeEmail extends Job
{
    public function __construct(
        protected int $userId
    ) {}

    public function handle(): void
    {
        // Job logic here
    }
}
```

### Job Class Structure

- **Constructor** -- Accept data needed for the job
- **handle()** -- Execute the job logic
- **$tries** -- Number of retry attempts (default: 3)
- **$timeout** -- Maximum execution time in seconds

### Complete Job Example

```php
<?php

namespace App\Jobs;

use Core\Queue\Job;
use App\Models\User;
use App\Mail\WelcomeEmail;
use Core\Mail\Mail;

class SendWelcomeEmail extends Job
{
    public int $tries = 3;
    public int $timeout = 30;

    public function __construct(
        protected int $userId
    ) {}

    public function handle(): void
    {
        $user = User::find($this->userId);

        if (!$user) {
            // User was deleted, no need to retry
            return;
        }

        Mail::to($user->email)->send(new WelcomeEmail($user->toArray()));
    }

    public function failed(\Exception $exception): void
    {
        // Log the failure
        logger()->error('Failed to send welcome email', [
            'user_id' => $this->userId,
            'error' => $exception->getMessage(),
        ]);

        // Notify admin, etc.
    }
}
```

---

## Dispatching Jobs

### Basic Dispatch

```php
use App\Jobs\SendWelcomeEmail;

public function register(Request $request): Response
{
    $user = User::create($request->all());

    // Dispatch job to queue
    dispatch(new SendWelcomeEmail($user->id));

    return redirect('/dashboard');
}
```

### Dispatch with Delay

```php
// Run 5 minutes from now
dispatch(new SendWelcomeEmail($user->id))->delay(300);

// Run at specific time
$runAt = now()->addHours(2);
dispatch(new SendReminderEmail($user->id))->delay($runAt);
```

### Dispatch to Specific Queue

Organize jobs by priority:

```php
// High priority queue
dispatch(new ProcessPayment($order->id))->onQueue('high');

// Low priority queue
dispatch(new GenerateReport())->onQueue('low');

// Default queue
dispatch(new SendEmail($user->id));
```

Run workers for specific queues:

```bash
# Process high priority jobs
./sixorbit queue:work --queue=high

# Process default queue
./sixorbit queue:work
```

---

## Running Queue Workers

### Start a Worker

```bash
./sixorbit queue:work
```

The worker polls the `jobs` table and processes pending jobs continuously.

### Worker Options

```bash
# Limit number of jobs
./sixorbit queue:work --max-jobs=100

# Set timeout
./sixorbit queue:work --timeout=3600

# Process specific queue
./sixorbit queue:work --queue=emails

# Verbose output
./sixorbit queue:work --verbose
```

### Running Workers in Production

Use a process manager like **Supervisor** to keep workers running:

**supervisor/sixorbit-worker.conf:**

```ini
[program:sixorbit-worker]
process_name=%(program_name)s_%(process_num)02d
command=/var/www/html/so-backend-framework/sixorbit queue:work --timeout=3600
autostart=true
autorestart=true
user=www-data
numprocs=3
redirect_stderr=true
stdout_logfile=/var/log/sixorbit-worker.log
```

Start workers:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start sixorbit-worker:*
```

### Restart Workers After Code Changes

Workers cache application code. After deployment, restart them:

```bash
# Using supervisor
sudo supervisorctl restart sixorbit-worker:*

# Manual restart
pkill -f "queue:work"
./sixorbit queue:work &
```

---

## Job Lifecycle

### 1. Job Created and Dispatched

```php
dispatch(new ProcessImage($imageId));
```

Inserted into `jobs` table with `status = 'pending'`.

### 2. Worker Picks Up Job

Worker fetches the oldest pending job:

```sql
SELECT * FROM jobs WHERE status = 'pending' ORDER BY created_at ASC LIMIT 1
```

### 3. Job Execution

Worker calls `handle()` method:

```php
$job->handle();
```

### 4. Job Completion

**Success:**
- Job deleted from `jobs` table
- Worker moves to next job

**Failure:**
- `attempts` incremented
- If `attempts < $tries`, job retried
- If `attempts >= $tries`, job marked as failed
- `failed()` method called if defined

### Failed Jobs

Failed jobs (exceeded retry attempts) are moved to `failed_jobs` table.

View failed jobs:

```bash
./sixorbit queue:failed
```

Retry failed job:

```bash
./sixorbit queue:retry 123
```

Retry all failed jobs:

```bash
./sixorbit queue:retry all
```

---

## Best Practices

### 1. Keep Jobs Small and Focused

Each job should do one thing:

```php
// Bad - too many responsibilities
class ProcessOrder extends Job
{
    public function handle()
    {
        $this->chargePayment();
        $this->sendConfirmationEmail();
        $this->updateInventory();
        $this->notifyWarehouse();
    }
}

// Good - separate jobs
dispatch(new ChargePayment($orderId));
dispatch(new SendOrderConfirmation($orderId));
dispatch(new UpdateInventory($orderId));
dispatch(new NotifyWarehouse($orderId));
```

### 2. Pass IDs, Not Objects

Serialize IDs instead of full models:

```php
// Bad - serializes entire user object
public function __construct(protected User $user) {}

// Good - serialize only ID, fetch fresh data
public function __construct(protected int $userId) {}

public function handle()
{
    $user = User::find($this->userId);
}
```

**Why?** The user data might change between dispatch and execution.

### 3. Make Jobs Idempotent

Jobs should be safe to run multiple times:

```php
public function handle()
{
    $user = User::find($this->userId);

    // Check if already processed
    if ($user->welcome_email_sent) {
        return; // Already sent, don't send again
    }

    Mail::to($user->email)->send(new WelcomeEmail($user));

    $user->update(['welcome_email_sent' => true]);
}
```

### 4. Set Appropriate Retry Limits

```php
// Quick operations - retry more
public int $tries = 5;

// External API calls - retry less (may be down for hours)
public int $tries = 2;

// Critical operations - don't retry (manual intervention needed)
public int $tries = 1;
```

### 5. Handle Job Failures

Always implement `failed()` to log errors:

```php
public function failed(\Exception $exception): void
{
    logger()->error('Job failed', [
        'job' => static::class,
        'data' => $this->userId,
        'error' => $exception->getMessage(),
        'trace' => $exception->getTraceAsString(),
    ]);

    // Notify admin for critical jobs
    if ($this->isCritical) {
        Mail::to('admin@example.com')->send(new JobFailedEmail($exception));
    }
}
```

### 6. Monitor Queue Size

Large queue backlogs indicate workers can't keep up:

```php
$pendingJobs = db()->table('jobs')->where('status', 'pending')->count();

if ($pendingJobs > 1000) {
    // Alert: Add more workers
}
```

### 7. Use Timeouts

Prevent jobs from running forever:

```php
public int $timeout = 60; // Kill job after 60 seconds
```

---

## Common Patterns

### Chain Jobs

Run jobs sequentially:

```php
dispatch(new ProcessOrder($orderId))
    ->chain([
        new ChargePayment($orderId),
        new SendConfirmation($orderId),
    ]);
```

### Batch Jobs

Process multiple items:

```php
$users = User::where('newsletter_subscribed', true)->get();

foreach ($users as $user) {
    dispatch(new SendNewsletter($user->id));
}
```

### Scheduled Jobs (Cron)

Run jobs on a schedule:

```bash
# Crontab entry
* * * * * cd /var/www/html/so-backend-framework && ./sixorbit schedule:run
```

---

**Related Documentation:**
- [CLI Commands](/docs/dev/cli-commands) - Queue command reference
- [Mail System](/docs/dev/mail) - Sending emails asynchronously
- [Events](/docs/dev/events) - Event-driven job dispatching

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
