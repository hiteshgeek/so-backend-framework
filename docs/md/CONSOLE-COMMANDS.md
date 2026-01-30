# Console Commands Reference

**SO Framework** | **SixOrbit CLI** | **Version 2.0.0**

Complete reference for all command-line interface (CLI) commands available in the SO Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Getting Started](#getting-started)
3. [Available Commands](#available-commands)
4. [Queue Commands](#queue-commands)
5. [Cache Commands](#cache-commands)
6. [Session Commands](#session-commands)
7. [Activity Log Commands](#activity-log-commands)
8. [Notification Commands](#notification-commands)
9. [Creating Custom Commands](#creating-custom-commands)
10. [Command Options](#command-options)
11. [Running Commands](#running-commands)

---

## Overview

The SO Framework includes an **SixOrbit** command-line interface that provides helpful commands for managing your application. All commands are executed through the `sixorbit` script in the root directory.

### Features

- [x] Laravel-style command syntax
- [x] Built-in maintenance commands
- [x] Support for custom commands
- [x] Argument and option parsing
- [x] Interactive prompts
- [x] Color-coded output

---

## Getting Started

### Running SixOrbit

Execute sixorbit from the command line:

```bash
php sixorbit <command> [options] [arguments]
```

### List All Commands

```bash
php sixorbit
```

### Get Help for a Command

```bash
php sixorbit help <command>
```

---

## Available Commands

### Command Summary

| Command | Description | Category |
|---------|-------------|----------|
| `queue:work` | Process jobs from the queue | Queue |
| `cache:clear` | Clear all cache entries | Cache |
| `cache:gc` | Run cache garbage collection | Cache |
| `session:cleanup` | Clean expired sessions | Session |
| `activity:prune` | Archive old activity logs | Activity Log |
| `notification:cleanup` | Delete old notifications | Notifications |

---

## Queue Commands

### `queue:work`

Process jobs from the queue. Runs as a daemon and continuously processes jobs.

#### Syntax

```bash
php sixorbit queue:work [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--queue` | `default` | The queue to process jobs from |
| `--sleep` | `3` | Seconds to sleep when no jobs are available |
| `--tries` | `3` | Maximum number of retry attempts |
| `--timeout` | `60` | Maximum seconds a job can run |
| `--once` | `false` | Process one job and exit |

#### Examples

**Basic Usage (Daemon Mode)**
```bash
php sixorbit queue:work
```

**Process Specific Queue**
```bash
php sixorbit queue:work --queue=emails
```

**Process One Job and Exit**
```bash
php sixorbit queue:work --once
```

**Custom Configuration**
```bash
php sixorbit queue:work --queue=high-priority --sleep=1 --tries=5 --timeout=120
```

#### Use Cases

1. **Development**: Use `--once` to process jobs manually
2. **Production**: Run in daemon mode with supervisord/systemd
3. **Testing**: Process specific queues with custom timeouts

#### Production Deployment

**Using Supervisor (Recommended)**

```ini
[program:so-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/so-backend-framework/sixorbit queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/html/so-backend-framework/storage/logs/worker.log
```

**Using Systemd**

```ini
[Unit]
Description=SO Framework Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/html/so-backend-framework
ExecStart=/usr/bin/php sixorbit queue:work --sleep=3 --tries=3
Restart=always

[Install]
WantedBy=multi-user.target
```

#### Exit Codes

- `0` - Success
- `1` - No jobs processed (with `--once` option)

---

## Cache Commands

### `cache:clear`

Clear all cache entries from the specified cache store.

#### Syntax

```bash
php sixorbit cache:clear [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--store` | `database` | The cache store to clear (database, array, redis) |

#### Examples

**Clear Database Cache**
```bash
php sixorbit cache:clear
```

**Clear Specific Store**
```bash
php sixorbit cache:clear --store=redis
```

#### Use Cases

1. **After Deployments**: Clear cache to ensure fresh data
2. **Configuration Changes**: Clear config cache
3. **Debugging**: Remove cached data that might be stale
4. **Maintenance**: Regular cache cleanup

#### Exit Codes

- `0` - Cache cleared successfully
- `1` - Failed to clear cache

#### Output Examples

**Success:**
```
Cache store [database] cleared successfully.
```

**Error:**
```
Error: Failed to clear cache store [database].
```

---

### `cache:gc`

Run garbage collection on the cache store to remove expired entries.

#### Syntax

```bash
php sixorbit cache:gc [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--store` | `database` | The cache store to clean |

#### Examples

**Run Garbage Collection**
```bash
php sixorbit cache:gc
```

**Specific Store**
```bash
php sixorbit cache:gc --store=database
```

#### Use Cases

1. **Scheduled Maintenance**: Run via cron to keep cache clean
2. **Disk Space Management**: Remove expired cache entries
3. **Performance**: Keep cache tables/stores optimized

#### Cron Schedule

```bash
# Run cache garbage collection daily at 2 AM
0 2 * * * php /var/www/html/so-backend-framework/sixorbit cache:gc
```

---

## Session Commands

### `session:cleanup`

Clean up expired sessions from the database.

#### Syntax

```bash
php sixorbit session:cleanup
```

#### Options

None

#### Examples

**Clean Expired Sessions**
```bash
php sixorbit session:cleanup
```

#### Use Cases

1. **Database Maintenance**: Remove old session records
2. **Privacy Compliance**: Clean up user session data
3. **Performance**: Keep session table optimized

#### How It Works

- Deletes sessions where `last_activity` is older than configured lifetime
- Default session lifetime: 120 minutes (configurable in `.env`)

#### Cron Schedule

```bash
# Clean sessions every hour
0 * * * * php /var/www/html/so-backend-framework/sixorbit session:cleanup
```

#### Output Example

```
Cleaned up 157 expired sessions.
```

#### Configuration

Session lifetime is configured in `.env`:

```ini
SESSION_LIFETIME=120  # minutes
```

---

## Activity Log Commands

### `activity:prune`

Archive or delete old activity log entries to maintain database performance.

#### Syntax

```bash
php sixorbit activity:prune [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--days` | `90` | Delete logs older than X days |
| `--archive` | `false` | Archive logs instead of deleting |
| `--batch` | `1000` | Number of records to process per batch |

#### Examples

**Delete Logs Older Than 90 Days**
```bash
php sixorbit activity:prune
```

**Archive Logs Instead of Deleting**
```bash
php sixorbit activity:prune --days=180 --archive
```

**Custom Batch Size**
```bash
php sixorbit activity:prune --days=30 --batch=5000
```

#### Use Cases

1. **Compliance**: Maintain audit logs for required period (GDPR, SOX)
2. **Performance**: Keep activity_logs table size manageable
3. **Archival**: Move old logs to cold storage
4. **Disk Space**: Free up database storage

#### How Archival Works

When `--archive` is specified:
1. Old records are exported to CSV files
2. Files are stored in `storage/archives/activity-logs/`
3. Original records are deleted after successful export

#### Cron Schedule

```bash
# Prune activity logs monthly
0 0 1 * * php /var/www/html/so-backend-framework/sixorbit activity:prune --days=90
```

#### Output Example

```
Processing batch 1 of 3...
Processing batch 2 of 3...
Processing batch 3 of 3...
Pruned 2,847 activity log entries older than 90 days.
```

---

## Notification Commands

### `notification:cleanup`

Delete old read notifications to keep the notifications table clean.

#### Syntax

```bash
php sixorbit notification:cleanup [options]
```

#### Options

| Option | Default | Description |
|--------|---------|-------------|
| `--days` | `30` | Delete notifications older than X days |
| `--read-only` | `true` | Only delete read notifications |
| `--batch` | `1000` | Number of records to process per batch |

#### Examples

**Delete Read Notifications Older Than 30 Days**
```bash
php sixorbit notification:cleanup
```

**Delete All Notifications (Read and Unread)**
```bash
php sixorbit notification:cleanup --days=60 --read-only=false
```

**Custom Batch Processing**
```bash
php sixorbit notification:cleanup --days=7 --batch=5000
```

#### Use Cases

1. **User Experience**: Keep notification lists manageable
2. **Performance**: Optimize notifications table
3. **Database Size**: Control table growth
4. **Privacy**: Remove old notification data

#### Cron Schedule

```bash
# Clean notifications weekly
0 3 * * 0 php /var/www/html/so-backend-framework/sixorbit notification:cleanup --days=30
```

#### Output Example

```
Processing batch 1 of 2...
Processing batch 2 of 2...
Deleted 1,234 notifications older than 30 days.
```

---

## Creating Custom Commands

### Step 1: Create Command Class

Create a new command class in `app/Console/Commands/`:

```php
<?php

namespace App\Console\Commands;

use Core\Console\Command;

class SendEmailReportCommand extends Command
{
    protected string $signature = 'report:email {recipient} {--type=daily} {--format=pdf}';

    protected string $description = 'Send email report to recipient';

    public function handle(): int
    {
        // Get arguments
        $recipient = $this->argument(0);

        // Get options
        $type = $this->option('type', 'daily');
        $format = $this->option('format', 'pdf');

        // Your command logic here
        $this->info("Sending {$type} report to {$recipient} in {$format} format...");

        // Perform work
        try {
            // Send report logic
            $this->info("Report sent successfully!");
            return 0; // Success
        } catch (\Exception $e) {
            $this->error("Failed to send report: " . $e->getMessage());
            return 1; // Failure
        }
    }
}
```

### Step 2: Register Command

Register your command in `sixorbit`:

```php
$kernel->registerCommands([
    \Core\Console\Commands\QueueWorkCommand::class,
    \Core\Console\Commands\CacheClearCommand::class,
    // ... other commands
    \App\Console\Commands\SendEmailReportCommand::class, // Your command
]);
```

### Step 3: Use Your Command

```bash
php sixorbit report:email user@example.com --type=monthly --format=excel
```

### Command Signature Syntax

```
command:name {argument} {argument2?} {--option} {--option2=default}
```

- `{argument}` - Required argument
- `{argument?}` - Optional argument
- `{--option}` - Boolean option (true/false)
- `{--option=default}` - Option with default value

---

## Command Options

### Available Methods

Commands extend the `Core\Console\Command` base class, which provides:

#### Input Methods

```php
// Get argument by index
$arg = $this->argument(0);
$arg = $this->argument(1, 'default value');

// Get option by name
$option = $this->option('queue');
$option = $this->option('timeout', 60);
```

#### Output Methods

```php
// Info message (standard output)
$this->info('Operation completed successfully');

// Error message (stderr)
$this->error('Something went wrong');

// Comment message
$this->comment('This is a comment');
```

#### Interactive Methods

```php
// Ask a question
$name = $this->ask('What is your name?');
$name = $this->ask('What is your name?', 'John'); // with default

// Confirmation
$confirmed = $this->confirm('Are you sure?'); // default: false
$confirmed = $this->confirm('Continue?', true); // default: true
```

---

## Running Commands

### Development

Run commands directly during development:

```bash
php sixorbit cache:clear
php sixorbit queue:work --once
```

### Production via Cron

Schedule commands to run automatically:

```bash
# Edit crontab
crontab -e

# Add commands
0 2 * * * php /var/www/html/so-backend-framework/sixorbit cache:gc
0 * * * * php /var/www/html/so-backend-framework/sixorbit session:cleanup
0 3 * * 0 php /var/www/html/so-backend-framework/sixorbit notification:cleanup
0 0 1 * * php /var/www/html/so-backend-framework/sixorbit activity:prune --days=90
```

### Background Execution

Run commands in the background:

```bash
# Background with output to log
php sixorbit queue:work > storage/logs/queue.log 2>&1 &

# Background with nohup
nohup php sixorbit queue:work &
```

### Process Management

**Check Running Queue Workers**
```bash
ps aux | grep "sixorbit queue:work"
```

**Stop Queue Worker**
```bash
kill -SIGTERM <process-id>
```

**Restart Queue Worker**
```bash
kill -SIGTERM <process-id>
php sixorbit queue:work &
```

---

## Command Exit Codes

All commands return exit codes:

- `0` - Success
- `1` - Failure/Error

**Check Exit Code in Shell**
```bash
php sixorbit cache:clear
echo $?  # Prints 0 for success, 1 for failure
```

**Use in Scripts**
```bash
if php sixorbit cache:clear; then
    echo "Cache cleared"
else
    echo "Failed to clear cache"
fi
```

---

## Best Practices

### 1. Error Handling

Always wrap commands in try-catch blocks:

```php
public function handle(): int
{
    try {
        // Command logic
        $this->info('Success!');
        return 0;
    } catch (\Exception $e) {
        $this->error($e->getMessage());
        return 1;
    }
}
```

### 2. Progress Feedback

Provide feedback for long-running commands:

```php
$this->info('Starting process...');
// Do work
$this->info('Step 1 complete');
// More work
$this->info('Step 2 complete');
$this->info('Process finished!');
```

### 3. Logging

Log command execution to files:

```php
$this->info('Starting...');
activity()
    ->log('Command executed: ' . $this->getName())
    ->save();
```

### 4. Resource Management

Be mindful of memory and time limits:

```php
// Process in batches
$batchSize = 1000;
$total = Model::count();
$batches = ceil($total / $batchSize);

for ($i = 0; $i < $batches; $i++) {
    $this->info("Processing batch " . ($i + 1) . " of {$batches}");
    // Process batch
}
```

### 5. Configuration

Use configuration files for command settings:

```php
// config/commands.php
return [
    'queue' => [
        'default_queue' => 'default',
        'default_sleep' => 3,
        'default_tries' => 3,
    ],
];

// In command
$queue = $this->option('queue') ?? config('commands.queue.default_queue');
```

---

## Troubleshooting

### Command Not Found

**Problem**: `Command not found: my:command`

**Solution**: Ensure command is registered in `sixorbit` file

### Permission Denied

**Problem**: `Permission denied` when running sixorbit

**Solution**:
```bash
chmod +x sixorbit
```

### Memory Limit

**Problem**: Queue worker runs out of memory

**Solution**:
```bash
php -d memory_limit=512M sixorbit queue:work
```

Or update `php.ini`:
```ini
memory_limit = 512M
```

### Command Hangs

**Problem**: Command doesn't exit

**Solution**: Check for infinite loops, add timeouts:

```php
set_time_limit(300); // 5 minutes
```

---

## Examples

### Complete Cron Schedule

```bash
# SO Framework Maintenance Commands
# Edit with: crontab -e

# Queue worker (should use supervisord instead)
# * * * * * php /var/www/html/so-backend-framework/sixorbit queue:work --once

# Cache maintenance (daily at 2 AM)
0 2 * * * php /var/www/html/so-backend-framework/sixorbit cache:gc

# Session cleanup (hourly)
0 * * * * php /var/www/html/so-backend-framework/sixorbit session:cleanup

# Notification cleanup (weekly, Sunday at 3 AM)
0 3 * * 0 php /var/www/html/so-backend-framework/sixorbit notification:cleanup --days=30

# Activity log pruning (monthly, 1st of month at midnight)
0 0 1 * * php /var/www/html/so-backend-framework/sixorbit activity:prune --days=90

# Clear cache (daily at 3 AM)
0 3 * * * php /var/www/html/so-backend-framework/sixorbit cache:clear
```

### Deployment Script

```bash
#!/bin/bash
# deploy.sh

echo "Starting deployment..."

# Stop queue workers
sudo supervisorctl stop so-queue-worker:*

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear cache
php sixorbit cache:clear

# Run database migrations (when implemented)
# php sixorbit migrate --force

# Restart queue workers
sudo supervisorctl start so-queue-worker:*

echo "Deployment complete!"
```

---

## Summary

The SO Framework console provides powerful commands for:

- [x] **Queue Management**: Process background jobs
- [x] **Cache Control**: Clear and maintain cache stores
- [x] **Session Cleanup**: Remove expired sessions
- [x] **Activity Logs**: Prune old audit trail data
- [x] **Notifications**: Clean up old notifications
- [x] **Custom Commands**: Build your own CLI tools

All commands follow Laravel conventions and can be scheduled with cron or process managers like Supervisor.

---

**Next Steps:**
- [Queue System Documentation](/docs/queue-system)
- [Cache System Documentation](/docs/cache-system)
- [Activity Logging Documentation](/docs/activity-logging)

---

**Last Updated**: 2026-01-29
**Framework Version**: 2.0.0
