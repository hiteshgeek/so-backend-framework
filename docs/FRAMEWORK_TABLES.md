# Framework Database Tables for ERP Systems

## Overview
Laravel and similar frameworks use dedicated database tables to manage system-level functionality. For a large ERP system, these are essential for scalability, monitoring, and compliance.

---

## Essential Tables for ERP

### 1. **sessions** (Critical for ERP)
**Purpose**: Store user sessions in database instead of files

**Why Essential for ERP:**
- Load balancing across multiple servers
- Track active users in real-time
- Session analytics and monitoring
- Better security and management
- Can forcefully logout users from all devices

**Schema:**
```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);
```

**Use Cases:**
- Monitor who's currently logged in
- End sessions when user is deactivated
- Audit which IPs users logged in from
- Prevent concurrent logins

---

### 2. **jobs** (Critical for ERP)
**Purpose**: Queue system for background tasks

**Why Essential for ERP:**
- Generate large reports asynchronously
- Process bulk imports/exports
- Send emails without blocking requests
- Handle long-running calculations
- Process payroll, invoices, etc.

**Schema:**
```sql
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
);
```

**Use Cases:**
- Generate monthly financial reports
- Export 100,000+ records to Excel
- Send bulk emails/notifications
- Process inventory updates
- Calculate commission/bonuses

---

### 3. **failed_jobs** (Critical for ERP)
**Purpose**: Track jobs that failed for retry and debugging

**Why Essential for ERP:**
- Identify issues in data processing
- Retry failed operations
- Audit trail of system errors
- Alert administrators

**Schema:**
```sql
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

### 4. **notifications** (Important for ERP)
**Purpose**: Store in-app notifications

**Why Essential for ERP:**
- Approval workflows (purchase orders, leave requests)
- Task assignments
- System alerts
- Document sharing notifications
- Deadline reminders

**Schema:**
```sql
CREATE TABLE notifications (
    id CHAR(36) PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    data TEXT NOT NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX notifications_notifiable_type_notifiable_id_index (notifiable_type, notifiable_id)
);
```

**Use Cases:**
- "Your leave request was approved"
- "New purchase order requires your approval"
- "Invoice #12345 is overdue"
- "Stock alert: Item XYZ is low"

---

### 5. **activity_log** (Critical for ERP - Compliance)
**Purpose**: Audit trail of user actions

**Why Essential for ERP:**
- Regulatory compliance (SOX, GDPR, etc.)
- Track who changed what and when
- Investigate data discrepancies
- Security audits
- Dispute resolution

**Schema:**
```sql
CREATE TABLE activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    log_name VARCHAR(255) NULL,
    description TEXT NOT NULL,
    subject_type VARCHAR(255) NULL,
    subject_id BIGINT UNSIGNED NULL,
    causer_type VARCHAR(255) NULL,
    causer_id BIGINT UNSIGNED NULL,
    properties JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX subject (subject_type, subject_id),
    INDEX causer (causer_type, causer_id)
);
```

**Use Cases:**
- "Who deleted customer record #123?"
- "Who changed the price of this item?"
- "Who approved this invoice?"
- "Track all changes to financial records"

---

### 6. **cache** (Performance)
**Purpose**: Store cached data in database

**Why Useful for ERP:**
- Cache complex queries (product catalogs, pricing)
- Reduce database load
- Share cache across servers
- TTL (Time To Live) management

**Schema:**
```sql
CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL
);

CREATE TABLE cache_locks (
    `key` VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
);
```

---

### 7. **password_resets** (Already Implemented)
**Purpose**: Secure password reset tokens

**Schema:**
```sql
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    INDEX idx_email (email),
    INDEX idx_token (token)
);
```

---

### 8. **personal_access_tokens** (For API Access)
**Purpose**: API authentication tokens

**Why Useful for ERP:**
- Mobile app authentication
- Third-party integrations
- API access for external systems
- Single Sign-On (SSO)

**Schema:**
```sql
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) UNIQUE NOT NULL,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)
);
```

---

### 9. **migrations** (Development)
**Purpose**: Track which migrations have run

**Schema:**
```sql
CREATE TABLE migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
);
```

---

### 10. **job_batches** (Advanced Queue Management)
**Purpose**: Batch multiple jobs together

**Why Useful for ERP:**
- Batch process 1000s of invoices
- Track overall progress
- Success/failure rates
- Cancel entire batch if one fails

**Schema:**
```sql
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
);
```

---

## Recommended Priority for ERP Implementation

### Phase 1 (Essential - Implement Now):
1. **activity_log** - Audit trail (compliance requirement)
2. **jobs** + **failed_jobs** - Background processing
3. **notifications** - User communication

### Phase 2 (Important - Next Sprint):
4. **sessions** (database driver) - Better session management
5. **cache** - Performance optimization

### Phase 3 (Nice to Have):
6. **personal_access_tokens** - Mobile/API access
7. **job_batches** - Advanced queue features

---

## Configuration

### Queue Configuration (config/queue.php)
```php
return [
    'default' => env('QUEUE_CONNECTION', 'database'),

    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],
    ],

    'failed' => [
        'driver' => 'database',
        'table' => 'failed_jobs',
    ],
];
```

### Session Configuration (config/session.php)
```php
return [
    'driver' => env('SESSION_DRIVER', 'database'),
    'lifetime' => 120, // minutes
    'table' => 'sessions',
    'lottery' => [2, 100], // Clean up old sessions
];
```

---

## ERP-Specific Benefits

### For Large Teams:
- Track concurrent users
- Monitor system usage
- Audit trail for compliance

### For Performance:
- Offload heavy tasks to queues
- Cache frequently accessed data
- Distribute load across servers

### For Compliance:
- Complete audit trail
- Session tracking
- API access logs

### For Reliability:
- Retry failed operations
- Monitor job success rates
- Alert on failures

---

## Best Practices

1. **Activity Log Everything Important**
   - Price changes
   - Permission changes
   - Financial transactions
   - Customer data modifications

2. **Use Jobs for Heavy Operations**
   - Reports > 10 seconds
   - Bulk operations > 100 records
   - Email sending
   - File processing

3. **Monitor Failed Jobs**
   - Set up alerts
   - Review daily
   - Investigate patterns

4. **Session Security**
   - Force logout on password change
   - Limit concurrent sessions
   - Track suspicious IPs

5. **Cache Strategy**
   - Cache read-heavy data (product catalogs)
   - Invalidate on updates
   - Use appropriate TTL

---

## Summary

For your ERP system, **prioritize these tables**:

**Must Have:**
- ✅ activity_log (audit trail)
- ✅ jobs + failed_jobs (background processing)
- ✅ notifications (user communication)

**Should Have:**
- ✅ sessions (database driver)
- ✅ cache (performance)

**Nice to Have:**
- ✅ personal_access_tokens (API)
- ✅ job_batches (advanced queues)

These tables transform your framework from a simple app into an enterprise-grade ERP platform.
