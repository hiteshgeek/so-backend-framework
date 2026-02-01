# Environment Configuration Guide

Complete reference for all `.env` configuration variables in the SO Backend Framework.

---

## Table of Contents

1. [Getting Started](#getting-started)
2. [Application Configuration](#application-configuration)
3. [Database Configuration](#database-configuration)
4. [Session Configuration](#session-configuration)
5. [Cache Configuration](#cache-configuration)
6. [Authentication & Security](#authentication--security)
7. [Activity Logging](#activity-logging)
8. [Queue System](#queue-system)
9. [Notifications](#notifications)
10. [Mail Configuration](#mail-configuration)
11. [API Configuration](#api-configuration)
12. [Logging Configuration](#logging-configuration)
13. [Profiler & Debugging](#profiler--debugging)
14. [Required vs Optional Keys](#required-vs-optional-keys)
15. [Environment-Specific Settings](#environment-specific-settings)

---

## Getting Started

### Initial Setup

1. Copy the example environment file:
```bash
cp .env.example .env
```

2. Generate application key:
```bash
php sixorbit key:generate
```

3. Configure database credentials

4. Set environment to `local` for development:
```env
APP_ENV=local
APP_DEBUG=true
```

### File Location

The `.env` file must be in the project root directory:
```
/var/www/html/so-backend-framework/
├── .env              <- Your environment file
├── .env.example      <- Template
├── config/           <- Configuration files
└── ...
```

---

## Application Configuration

### APP_NAME
- **Type**: String
- **Default**: `"SO Backend Framework"`
- **Description**: Application name displayed in logs, emails, and UI
- **Example**:
```env
APP_NAME="My Application"
```

### APP_VERSION
- **Type**: String
- **Default**: `1.0.0`
- **Description**: Application version for tracking and asset versioning
- **Example**:
```env
APP_VERSION=2.1.3
```

### APP_ENV
- **Type**: String
- **Default**: `production`
- **Values**: `local`, `development`, `staging`, `production`
- **Description**: Current application environment
- **Example**:
```env
APP_ENV=local
```

### APP_DEBUG
- **Type**: Boolean
- **Default**: `false`
- **Description**: Enable detailed error messages and stack traces
- **Warning**: Never enable in production!
- **Example**:
```env
APP_DEBUG=true  # Local/Development only
APP_DEBUG=false # Production
```

### APP_URL
- **Type**: URL
- **Default**: `http://localhost`
- **Description**: Base URL of your application
- **Example**:
```env
APP_URL=https://myapp.com
```

### APP_KEY
- **Type**: String (32 characters)
- **Default**: None (must be generated)
- **Description**: Encryption key for sessions, cookies, and encrypted data
- **Generate**:
```bash
php sixorbit key:generate
```
- **Example**:
```env
APP_KEY=base64:abcdefghijklmnopqrstuvwxyz123456
```

### ASSET_URL
- **Type**: URL
- **Default**: Empty (uses APP_URL)
- **Description**: CDN URL for static assets
- **Example**:
```env
ASSET_URL=https://cdn.myapp.com
```

### ASSET_VERSIONING
- **Type**: Boolean
- **Default**: `true`
- **Description**: Enable cache busting via file modification timestamps
- **Example**:
```env
ASSET_VERSIONING=true
```

---

## Database Configuration

### Application Database

Your primary database for application data.

#### DB_CONNECTION
- **Type**: String
- **Default**: `mysql`
- **Values**: `mysql`, `pgsql`, `sqlite`
- **Description**: Database driver
- **Example**:
```env
DB_CONNECTION=mysql
```

#### DB_HOST
- **Type**: String
- **Default**: `127.0.0.1`
- **Description**: Database server hostname or IP
- **Example**:
```env
DB_HOST=127.0.0.1
DB_HOST=db.example.com
```

#### DB_PORT
- **Type**: Integer
- **Default**: `3306` (MySQL), `5432` (PostgreSQL)
- **Description**: Database server port
- **Example**:
```env
DB_PORT=3306
```

#### DB_DATABASE
- **Type**: String
- **Default**: `so_framework`
- **Description**: Database name
- **Example**:
```env
DB_DATABASE=my_application
```

#### DB_USERNAME
- **Type**: String
- **Default**: `root` (MySQL), `postgres` (PostgreSQL)
- **Description**: Database username
- **Example**:
```env
DB_USERNAME=app_user
```

#### DB_PASSWORD
- **Type**: String
- **Default**: Empty
- **Description**: Database password
- **Example**:
```env
DB_PASSWORD=secure_password_here
```

### Essentials Database

Separate database for framework tables (sessions, cache, queue, activity logs).

**Why separate?**
- Isolate framework data from application data
- Easier to manage and backup separately
- Different scaling/replication strategies

#### DB_ESSENTIALS_CONNECTION
- **Type**: String
- **Default**: `mysql`
- **Example**:
```env
DB_ESSENTIALS_CONNECTION=mysql
```

#### DB_ESSENTIALS_HOST
- **Type**: String
- **Default**: `127.0.0.1`
- **Example**:
```env
DB_ESSENTIALS_HOST=127.0.0.1
```

#### DB_ESSENTIALS_PORT
- **Type**: Integer
- **Default**: `3306`
- **Example**:
```env
DB_ESSENTIALS_PORT=3306
```

#### DB_ESSENTIALS_DATABASE
- **Type**: String
- **Default**: `so_essentials`
- **Example**:
```env
DB_ESSENTIALS_DATABASE=my_app_essentials
```

#### DB_ESSENTIALS_USERNAME
- **Type**: String
- **Default**: `root`
- **Example**:
```env
DB_ESSENTIALS_USERNAME=essentials_user
```

#### DB_ESSENTIALS_PASSWORD
- **Type**: String
- **Default**: Empty
- **Example**:
```env
DB_ESSENTIALS_PASSWORD=secure_password_here
```

---

## Session Configuration

### SESSION_DRIVER
- **Type**: String
- **Default**: `database`
- **Values**: `database`, `file`, `cookie`
- **Description**: Where to store session data
- **Example**:
```env
SESSION_DRIVER=database  # Recommended for production
SESSION_DRIVER=file      # Local development
```

### SESSION_LIFETIME
- **Type**: Integer
- **Default**: `120`
- **Description**: Session lifetime in minutes
- **Example**:
```env
SESSION_LIFETIME=120  # 2 hours
SESSION_LIFETIME=480  # 8 hours
```

### SESSION_COOKIE
- **Type**: String
- **Default**: `so_session`
- **Description**: Name of the session cookie
- **Example**:
```env
SESSION_COOKIE=my_app_session
```

### SESSION_SECURE_COOKIE
- **Type**: Boolean
- **Default**: `false`
- **Description**: Only send cookie over HTTPS
- **Example**:
```env
SESSION_SECURE_COOKIE=false  # HTTP (local)
SESSION_SECURE_COOKIE=true   # HTTPS (production)
```

### SESSION_ENCRYPT
- **Type**: Boolean
- **Default**: `false`
- **Description**: Encrypt session payload with AES-256-CBC
- **Example**:
```env
SESSION_ENCRYPT=false  # Better performance
SESSION_ENCRYPT=true   # Enhanced security
```

---

## Cache Configuration

### CACHE_DRIVER
- **Type**: String
- **Default**: `database`
- **Values**: `database`, `file`
- **Description**: Cache storage driver
- **Example**:
```env
CACHE_DRIVER=database  # Recommended
CACHE_DRIVER=file      # Filesystem cache
```

### CACHE_FILE_PATH
- **Type**: String
- **Default**: `storage/cache`
- **Description**: File cache directory (only used when CACHE_DRIVER=file)
- **Example**:
```env
CACHE_FILE_PATH=storage/cache
```

### CACHE_PREFIX
- **Type**: String
- **Default**: `so_cache`
- **Description**: Prefix for all cache keys to avoid collisions
- **Example**:
```env
CACHE_PREFIX=myapp_cache
```

---

## Authentication & Security

### Login Throttling

#### AUTH_THROTTLE_ENABLED
- **Type**: Boolean
- **Default**: `true`
- **Description**: Enable login attempt throttling
- **Example**:
```env
AUTH_THROTTLE_ENABLED=true
```

#### AUTH_THROTTLE_MAX_ATTEMPTS
- **Type**: Integer
- **Default**: `5`
- **Description**: Maximum failed login attempts before lockout
- **Example**:
```env
AUTH_THROTTLE_MAX_ATTEMPTS=5
```

#### AUTH_THROTTLE_DECAY_MINUTES
- **Type**: Integer
- **Default**: `15`
- **Description**: Lockout duration in minutes
- **Example**:
```env
AUTH_THROTTLE_DECAY_MINUTES=15
```

### Remember Me

#### AUTH_REMEMBER_DURATION
- **Type**: Integer
- **Default**: `2592000` (30 days)
- **Description**: "Remember me" cookie duration in seconds
- **Example**:
```env
AUTH_REMEMBER_DURATION=2592000   # 30 days
AUTH_REMEMBER_DURATION=604800    # 7 days
```

### CSRF Protection

#### CSRF_ENABLED
- **Type**: Boolean
- **Default**: `true`
- **Description**: Enable CSRF protection globally
- **Warning**: Do not disable in production!
- **Example**:
```env
CSRF_ENABLED=true
```

### JWT Configuration

#### JWT_SECRET
- **Type**: String
- **Default**: None (must be set)
- **Description**: Secret key for signing JWT tokens
- **Generate**: Use a strong random string (32+ characters)
- **Example**:
```env
JWT_SECRET=your-very-secure-secret-key-here-32chars
```

#### JWT_ALGORITHM
- **Type**: String
- **Default**: `HS256`
- **Values**: `HS256`, `HS384`, `HS512`, `RS256`
- **Description**: Algorithm for signing JWT tokens
- **Example**:
```env
JWT_ALGORITHM=HS256
```

#### JWT_TTL
- **Type**: Integer
- **Default**: `3600` (1 hour)
- **Description**: Token time-to-live in seconds
- **Example**:
```env
JWT_TTL=3600    # 1 hour
JWT_TTL=86400   # 24 hours
```

#### JWT_BLACKLIST_ENABLED
- **Type**: Boolean
- **Default**: `true`
- **Description**: Enable token blacklist for logout/revocation
- **Example**:
```env
JWT_BLACKLIST_ENABLED=true
```

#### JWT_BLACKLIST_GRACE_PERIOD
- **Type**: Integer
- **Default**: `30`
- **Description**: Grace period in seconds after token blacklisting
- **Example**:
```env
JWT_BLACKLIST_GRACE_PERIOD=30
```

### Rate Limiting

#### RATE_LIMIT_ENABLED
- **Type**: Boolean
- **Default**: `true`
- **Description**: Enable rate limiting globally
- **Example**:
```env
RATE_LIMIT_ENABLED=true
```

#### RATE_LIMIT_DEFAULT
- **Type**: String (format: `requests,minutes`)
- **Default**: `60,1`
- **Description**: Default rate limit: "60 requests per 1 minute"
- **Example**:
```env
RATE_LIMIT_DEFAULT=60,1      # 60 requests per minute
RATE_LIMIT_DEFAULT=1000,60   # 1000 requests per hour
```

### Login Lockout

#### LOGIN_LOCKOUT_ENABLED
- **Type**: Boolean
- **Default**: `true`
- **Description**: Enable login lockout after failed attempts
- **Example**:
```env
LOGIN_LOCKOUT_ENABLED=true
```

#### LOGIN_MAX_ATTEMPTS
- **Type**: Integer
- **Default**: `5`
- **Description**: Maximum failed login attempts before lockout
- **Example**:
```env
LOGIN_MAX_ATTEMPTS=5
```

#### LOGIN_DECAY_MINUTES
- **Type**: Integer
- **Default**: `15`
- **Description**: Lockout duration in minutes
- **Example**:
```env
LOGIN_DECAY_MINUTES=15
```

---

## Activity Logging

### ACTIVITY_LOG_ENABLED
- **Type**: Boolean
- **Default**: `true`
- **Description**: Enable activity logging globally
- **Example**:
```env
ACTIVITY_LOG_ENABLED=true
```

### ACTIVITY_LOG_NAME
- **Type**: String
- **Default**: `default`
- **Description**: Default log name when none is specified
- **Example**:
```env
ACTIVITY_LOG_NAME=application
```

### ACTIVITY_LOG_RETENTION_DAYS
- **Type**: Integer
- **Default**: `365`
- **Description**: Automatically delete logs older than this many days
- **Example**:
```env
ACTIVITY_LOG_RETENTION_DAYS=365  # 1 year
ACTIVITY_LOG_RETENTION_DAYS=90   # 3 months
```

### ACTIVITY_LOG_BATCH_TRACKING
- **Type**: Boolean
- **Default**: `false`
- **Description**: Enable automatic batch UUID generation for grouping related activities
- **Example**:
```env
ACTIVITY_LOG_BATCH_TRACKING=false
```

---

## Queue System

### QUEUE_CONNECTION
- **Type**: String
- **Default**: `database`
- **Values**: `database`, `sync`
- **Description**: Default queue driver
- **Example**:
```env
QUEUE_CONNECTION=database  # Asynchronous processing
QUEUE_CONNECTION=sync      # Synchronous (no queue)
```

---

## Notifications

### NOTIFICATION_CHANNEL
- **Type**: String
- **Default**: `database`
- **Values**: `database`, `mail`
- **Description**: Default notification channel
- **Example**:
```env
NOTIFICATION_CHANNEL=database
```

### QUEUE_NOTIFICATIONS
- **Type**: Boolean
- **Default**: `false`
- **Description**: Should notifications be queued by default
- **Example**:
```env
QUEUE_NOTIFICATIONS=false  # Send immediately
QUEUE_NOTIFICATIONS=true   # Queue for background processing
```

### NOTIFICATION_PRUNE_DAYS
- **Type**: Integer
- **Default**: `30`
- **Description**: Automatically delete read notifications older than X days
- **Example**:
```env
NOTIFICATION_PRUNE_DAYS=30
```

---

## Mail Configuration

### MAIL_MAILER
- **Type**: String
- **Default**: `smtp`
- **Values**: `smtp`, `sendmail`, `log`
- **Description**: Mail driver to use
- **Example**:
```env
MAIL_MAILER=smtp     # Use SMTP server
MAIL_MAILER=log      # Log emails (testing)
```

### MAIL_FROM_ADDRESS
- **Type**: Email
- **Default**: `noreply@example.com`
- **Description**: Default from email address
- **Example**:
```env
MAIL_FROM_ADDRESS=noreply@myapp.com
```

### MAIL_FROM_NAME
- **Type**: String
- **Default**: `${APP_NAME}`
- **Description**: Default from name (uses APP_NAME if not set)
- **Example**:
```env
MAIL_FROM_NAME="My Application"
```

### SMTP Settings

#### MAIL_HOST
- **Type**: String
- **Default**: `smtp.gmail.com`
- **Description**: SMTP server hostname
- **Example**:
```env
MAIL_HOST=smtp.gmail.com
MAIL_HOST=smtp.sendgrid.net
MAIL_HOST=smtp.mailgun.org
```

#### MAIL_PORT
- **Type**: Integer
- **Default**: `587`
- **Description**: SMTP server port
- **Example**:
```env
MAIL_PORT=587   # TLS
MAIL_PORT=465   # SSL
MAIL_PORT=25    # Unencrypted (not recommended)
```

#### MAIL_ENCRYPTION
- **Type**: String
- **Default**: `tls`
- **Values**: `tls`, `ssl`, `null`
- **Description**: SMTP encryption method
- **Example**:
```env
MAIL_ENCRYPTION=tls
```

#### MAIL_USERNAME
- **Type**: String
- **Default**: Empty
- **Description**: SMTP username
- **Example**:
```env
MAIL_USERNAME=your-email@gmail.com
```

#### MAIL_PASSWORD
- **Type**: String
- **Default**: Empty
- **Description**: SMTP password
- **Example**:
```env
MAIL_PASSWORD=your-app-specific-password
```

---

## API Configuration

### API_DEFAULT_VERSION
- **Type**: String
- **Default**: `v1`
- **Description**: Default API version when none is specified
- **Example**:
```env
API_DEFAULT_VERSION=v1
```

### API_PREFIX
- **Type**: String
- **Default**: `api`
- **Description**: API route prefix
- **Example**:
```env
API_PREFIX=api  # Routes: /api/v1/users
```

### API_CLIENT_TIMEOUT
- **Type**: Integer
- **Default**: `30`
- **Description**: Default timeout for API calls in seconds
- **Example**:
```env
API_CLIENT_TIMEOUT=30
```

### API_CLIENT_RETRY
- **Type**: Integer
- **Default**: `3`
- **Description**: Number of retry attempts for failed API requests
- **Example**:
```env
API_CLIENT_RETRY=3
```

### Internal API (Signature Authentication)

#### INTERNAL_API_SIGNATURE_KEY
- **Type**: String
- **Default**: None (must be set)
- **Description**: Secret key for signature-based authentication
- **Generate**: Use a strong random string (32+ characters)
- **Example**:
```env
INTERNAL_API_SIGNATURE_KEY=your-very-secure-signature-key-here
```

#### INTERNAL_API_SIGNATURE_MAX_AGE
- **Type**: Integer
- **Default**: `300` (5 minutes)
- **Description**: Maximum age of signature timestamp in seconds
- **Example**:
```env
INTERNAL_API_SIGNATURE_MAX_AGE=300
```

---

## Logging Configuration

### LOG_CHANNEL
- **Type**: String
- **Default**: `daily`
- **Values**: `single`, `daily`, `syslog`, `stderr`
- **Description**: Default log channel
- **Example**:
```env
LOG_CHANNEL=daily    # Daily rotating logs
LOG_CHANNEL=single   # Single log file
```

### LOG_LEVEL
- **Type**: String
- **Default**: `info`
- **Values**: `debug`, `info`, `notice`, `warning`, `error`, `critical`, `alert`, `emergency`
- **Description**: Minimum log level to record
- **Example**:
```env
LOG_LEVEL=debug    # Development (all logs)
LOG_LEVEL=warning  # Production (warnings and above)
```

---

## Profiler & Debugging

### PROFILER_TOOLBAR
- **Type**: Boolean
- **Default**: `true`
- **Description**: Display the profiler toolbar
- **Example**:
```env
PROFILER_TOOLBAR=true   # Show toolbar when APP_DEBUG=true
PROFILER_TOOLBAR=false  # Hide toolbar
```

### PROFILER_SLOW_QUERY
- **Type**: Integer
- **Default**: `100`
- **Description**: Slow query threshold in milliseconds
- **Example**:
```env
PROFILER_SLOW_QUERY=100   # Flag queries over 100ms
```

### PROFILER_QUERY_WARNING
- **Type**: Integer
- **Default**: `20`
- **Description**: Query count warning threshold
- **Example**:
```env
PROFILER_QUERY_WARNING=20  # Warn if more than 20 queries
```

### PROFILER_MEMORY_WARNING
- **Type**: Integer
- **Default**: `80`
- **Description**: Memory usage warning percentage
- **Example**:
```env
PROFILER_MEMORY_WARNING=80  # Warn at 80% memory usage
```

---

## Required vs Optional Keys

### Required Keys (Must Be Set)

These keys **must** be configured in your `.env` file:

| Key | Purpose | How to Generate |
|-----|---------|-----------------|
| `APP_KEY` | Encryption | `php sixorbit key:generate` |
| `JWT_SECRET` | JWT signing | Strong random string (32+ chars) |
| `INTERNAL_API_SIGNATURE_KEY` | API authentication | Strong random string (32+ chars) |
| `DB_DATABASE` | Database name | Create database first |
| `DB_USERNAME` | Database user | Database credentials |
| `DB_PASSWORD` | Database password | Database credentials |

### Optional Keys (Have Defaults)

All other keys have sensible defaults and are optional. Customize as needed for your environment.

---

## Environment-Specific Settings

### Local Development

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Simplified settings for development
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Verbose logging
LOG_LEVEL=debug
PROFILER_TOOLBAR=true

# No security restrictions
SESSION_SECURE_COOKIE=false
```

### Staging Environment

```env
APP_ENV=staging
APP_DEBUG=true
APP_URL=https://staging.myapp.com

# Production-like settings
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Moderate logging
LOG_LEVEL=info
PROFILER_TOOLBAR=true

# HTTPS enforced
SESSION_SECURE_COOKIE=true
```

### Production Environment

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://myapp.com

# Optimized for performance
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Error logging only
LOG_LEVEL=error
PROFILER_TOOLBAR=false

# Maximum security
SESSION_SECURE_COOKIE=true
SESSION_ENCRYPT=true
CSRF_ENABLED=true
RATE_LIMIT_ENABLED=true
```

---

## Best Practices

### Security

1. **Never commit `.env` to version control**
   - Add `.env` to `.gitignore`
   - Only commit `.env.example`

2. **Use strong random keys**
```bash
# Generate APP_KEY
php sixorbit key:generate

# Generate other secrets
openssl rand -base64 32
```

3. **Rotate secrets regularly**
   - Change `JWT_SECRET` periodically
   - Update `INTERNAL_API_SIGNATURE_KEY`

4. **Enable security features in production**
```env
APP_DEBUG=false
CSRF_ENABLED=true
RATE_LIMIT_ENABLED=true
SESSION_SECURE_COOKIE=true
```

### Performance

1. **Use database cache in production**
```env
CACHE_DRIVER=database
```

2. **Enable asset versioning**
```env
ASSET_VERSIONING=true
```

3. **Use CDN for assets**
```env
ASSET_URL=https://cdn.myapp.com
```

4. **Configure proper session lifetime**
```env
SESSION_LIFETIME=120  # 2 hours
```

### Logging

1. **Use appropriate log levels**
   - `debug`: Development only
   - `info`: Staging
   - `warning` or `error`: Production

2. **Use daily logs in production**
```env
LOG_CHANNEL=daily
```

3. **Monitor log file sizes**
   - Implement log rotation
   - Archive old logs

---

## Troubleshooting

### "APP_KEY is not set"

**Problem**: Encryption key is missing

**Solution**:
```bash
php sixorbit key:generate
```

### "Database connection refused"

**Problem**: Incorrect database credentials or server not running

**Solution**:
1. Verify database server is running
2. Check `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD`
3. Ensure database exists:
```sql
CREATE DATABASE so_framework;
CREATE DATABASE so_essentials;
```

### "Session driver not found"

**Problem**: Invalid `SESSION_DRIVER` value

**Solution**:
```env
SESSION_DRIVER=database  # Valid values: database, file, cookie
```

### "SMTP connection failed"

**Problem**: Incorrect mail configuration

**Solution**:
1. Verify SMTP credentials
2. Check firewall/network settings
3. Test with `MAIL_MAILER=log` first:
```env
MAIL_MAILER=log  # Logs emails instead of sending
```

---

## See Also

- **[Installation Guide](/docs/installation)** - Initial setup steps
- **[Configuration System](/docs/configuration)** - How config files work
- **[Security Guide](/docs/security)** - Security best practices
- **[Deployment Guide](/docs/deployment)** - Production deployment
- **[Caching System](/docs/caching)** - Cache configuration
- **[Session System](/docs/session-system)** - Session management
