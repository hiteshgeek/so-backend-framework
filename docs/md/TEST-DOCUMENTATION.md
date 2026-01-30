# Test Suite Documentation

Comprehensive testing framework for the SO Backend Framework with organized test suites, colorful output, and category-based organization.

## Overview

The SO Backend Framework includes a robust test suite with 15 comprehensive test files organized into three contextual categories:

- **Security** (6 tests) - Authentication, authorization, CSRF, XSS, sanitization, account lockout
- **Infrastructure** (5 tests) - Cache, sessions, queue, notifications, activity logging, session encryption
- **Application** (4 tests) - Validation, middleware, API layer, model relationships

## Quick Start

```bash
# Show help and list all available tests
php sixorbit test
php sixorbit test --list

# Run all tests (requires --all flag)
php sixorbit test --all

# Run specific category
php sixorbit test security

# Run specific test
php sixorbit test csrf
```

## Test Organization

Tests are organized into contextual folders for better manageability:

```
tests/
├── security/              # Security-related tests
│   ├── csrf-protection.test.php
│   ├── jwt-auth.test.php
│   ├── rate-limit.test.php
│   ├── xss-prevention.test.php
│   ├── sanitizer-bypass.test.php
│   └── auth-lockout.test.php
├── infrastructure/        # Core system tests
│   ├── cache-sessions.test.php
│   ├── queue.test.php
│   ├── notifications.test.php
│   ├── activity-logging.test.php
│   └── session-encryption.test.php
└── application/          # Application layer tests
    ├── validation.test.php
    ├── middleware.test.php
    ├── api-layer.test.php
    └── model-relations.test.php
```

## Features

### Colorful ANSI Output

The test command provides colorful terminal output for better readability:

- **Green** - Passing tests and success indicators
- **Red** - Failing tests and error indicators
- **Cyan** - Category headers and titles
- **Yellow** - Warnings and mixed results

Colors are configurable in `TestCommand.php` via the `$colors` array.

### Category-Based Execution

Run tests by functional category:

```bash
php sixorbit test security       # All security tests
php sixorbit test infrastructure # All infrastructure tests
php sixorbit test application    # All application tests
```

### Individual Test Execution

Run specific tests by their short name:

```bash
php sixorbit test csrf        # CSRF Protection
php sixorbit test validation  # Validation System
php sixorbit test queue       # Queue System
```

### Comprehensive Statistics

Each test run provides:

- Individual test pass/fail counts
- Per-category summaries
- Overall pass rate
- Execution duration
- Color-coded results

## Test Categories

### Security Tests

| Test | Description |
|------|-------------|
| `csrf` | CSRF token generation, validation, and middleware |
| `jwt` | JWT encoding/decoding, expiration, signatures |
| `rate-limit` | API rate limiting and throttling |
| `xss` | XSS attack prevention mechanisms |
| `sanitizer` | Sanitizer bypass prevention with DOMDocument |
| `auth-lockout` | Brute force protection and account lockout |

### Infrastructure Tests

| Test | Description |
|------|-------------|
| `cache` | Cache drivers and session management |
| `queue` | Background job queueing and processing |
| `notifications` | Notification channels and delivery |
| `activity` | User activity tracking and audit logs |
| `session-encryption` | AES-256-CBC session encryption and HMAC tamper detection |

### Application Tests

| Test | Description |
|------|-------------|
| `validation` | Input validation rules and error handling (27+ rules) |
| `middleware` | Middleware pipeline and execution |
| `api` | Internal API endpoints and responses |
| `models` | ORM features and relationships (HasOne, HasMany, BelongsTo) |

## Writing New Tests

### Naming Convention

- Use `.test.php` extension
- Use hyphens for multi-word names (e.g., `csrf-protection.test.php`)
- Place in appropriate category folder

### Test File Structure

```php
#!/usr/bin/env php
<?php

require_once __DIR__ . '/../../vendor/autoload.php';

echo "=== Your Test Name ===\n\n";

$passed = 0;
$failed = 0;

// Test case
echo "Test 1: Description\n";
if ($condition) {
    echo "✓ PASS: Test passed\n";
    $passed++;
} else {
    echo "✗ FAIL: Test failed\n";
    $failed++;
}

echo "\n=== Test Complete: {$passed} passed, {$failed} failed ===\n";
exit($failed > 0 ? 1 : 0);
```

### Registering New Tests

Add to `core/Console/Commands/TestCommand.php` in the `$testSuites` array:

```php
'security' => [
    'your-test' => [
        'name' => 'Your Test Name',
        'file' => 'security/your-test.test.php'
    ],
],
```

## CI/CD Integration

The test suite integrates seamlessly with CI/CD pipelines:

```bash
# Run all tests (exit code 0 = success, 1 = failure)
php sixorbit test --all

# Run specific category
php sixorbit test security

# Exit codes:
#   0 = All tests passed
#   1 = One or more tests failed
```

## Test Coverage

- **Security**: 100% coverage of authentication, authorization, XSS prevention
- **Infrastructure**: All major services (cache, queue, sessions, notifications)
- **Application**: Validation, middleware, API, ORM relationships
- **Total**: 13 comprehensive test suites

## Further Reading

For detailed information about the test suite, including test descriptions, output examples, and maintenance guidelines, see:

**[TESTING-GUIDE.md](TESTING-GUIDE.md)** - Complete testing guide with examples and best practices

---

**Test Suite Version:** 2.0
**Framework Version:** 2.0
**Last Updated:** 2026-01-30
