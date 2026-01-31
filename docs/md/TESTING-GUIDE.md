# SO Backend Framework - Test Suite

Comprehensive test suite for the SO Backend Framework, organized by functional category.

## Quick Start

Show help and list all available tests:
```bash
php sixorbit test
php sixorbit test --list
```

Run all tests (requires --all flag):
```bash
php sixorbit test --all
```

Run a specific category:
```bash
php sixorbit test security           # Security tests only
php sixorbit test infrastructure     # Infrastructure tests only
php sixorbit test application        # Application tests only
```

Run a specific test:
```bash
php sixorbit test sanitizer          # Sanitizer bypass test
php sixorbit test csrf               # CSRF protection test
```

Run individual test file directly:
```bash
php tests/Integration/security/sanitizer-bypass.test.php
```

## Test Organization

Tests are organized into **Integration** and **Unit** test categories:

### Integration Tests (`tests/Integration/`)

Integration tests verify how multiple framework components work together. Organized into three contextual folders:

- **`tests/Integration/security/`** - Security-related integration tests
- **`tests/Integration/infrastructure/`** - Core system integration tests
- **`tests/Integration/application/`** - Application layer integration tests

### Unit Tests (`tests/Unit/`)

Unit tests focus on testing individual classes/methods in isolation (coming soon).

### Examples (`tests/examples/`)

Demo files showing practical usage of framework features. These are **not automated tests** but educational examples:

| Demo File | Description | Purpose |
|-----------|-------------|---------|
| `validation-demo.php` | Validation system examples | Shows 8 real-world validation scenarios with custom rules |

Run examples directly:
```bash
php tests/examples/validation-demo.php
```

### Security Tests (`tests/Integration/security/`)

Tests for authentication, authorization, and protection mechanisms.

| Test File | Description | Tests |
|-----------|-------------|-------|
| `csrf-protection.test.php` | CSRF token generation, validation, and middleware | Token lifecycle, persistence, helpers |
| `jwt-auth.test.php` | JWT encoding/decoding, expiration, signatures | Token creation, validation, security |
| `rate-limit.test.php` | API rate limiting and throttling | Per-key limits, windows, cleanup |
| `xss-prevention.test.php` | XSS attack prevention mechanisms | Input sanitization, output escaping |
| `sanitizer-bypass.test.php` | Sanitizer bypass prevention with DOMDocument | Nested tags, malformed HTML, event handlers |
| `auth-lockout.test.php` | Brute force protection and account lockout | Attempt tracking, lockout logic, IP+email separation |

### Core Infrastructure Tests (`tests/Integration/infrastructure/`)

Tests for core system components and services.

| Test File | Description | Tests |
|-----------|-------------|-------|
| `cache-sessions.test.php` | Cache drivers and session management | DB cache, session CRUD, expiration |
| `queue.test.php` | Background job queueing and processing | Job dispatch, serialization, workers |
| `notifications.test.php` | Notification channels and delivery | DB notifications, mail integration |
| `activity-logging.test.php` | User activity tracking and audit logs | Activity creation, metadata, pruning |
| `session-encryption.test.php` | AES-256-CBC session encryption and HMAC | Encryption/decryption, tamper detection, key validation |

### Application Layer Tests (`tests/Integration/application/`)

Tests for application-level features and APIs.

| Test File | Description | Tests |
|-----------|-------------|-------|
| `validation.test.php` | Input validation rules and error handling | 27+ rules, nested arrays, custom validators |
| `middleware.test.php` | Middleware pipeline and execution | Groups, aliases, parameter passing |
| `api-layer.test.php` | Internal API endpoints and responses | CRUD operations, JSON responses |
| `model-relations.test.php` | ORM features and relationships | HasOne, HasMany, BelongsTo, eager loading |

## SixOrbit Test Command

The `php sixorbit test` command provides a unified interface for running all framework tests.

### Features

- **List all available tests** with categories
- **Run all tests** or filter by category
- **Run specific individual tests**
- **Grouped results** by category (Security, Infrastructure, Application)
- **Per-test and per-category statistics**
- **Overall summary** with pass rate and duration
- **Colorful ANSI output** with green for passing tests and red for failures
- **Clean, formatted output** with progress indicators

### Usage

**List all tests:**
```bash
php sixorbit test --list
# Shows all categories and tests with short names
```

**Run all tests:**
```bash
php sixorbit test
# Runs all 13 test suites across 3 categories
```

**Run by category:**
```bash
php sixorbit test security           # All security tests (5 suites)
php sixorbit test infrastructure     # All infrastructure tests (4 suites)
php sixorbit test application        # All application tests (4 suites)
```

**Run specific test:**
```bash
php sixorbit test csrf               # CSRF Protection only
php sixorbit test sanitizer          # Sanitizer Bypass Prevention only
php sixorbit test validation         # Validation System only
```

### Output Example

```
╔═══════════════════════════════════════════════════════════════╗
║  Security                                                     ║
╚═══════════════════════════════════════════════════════════════╝

Running: Sanitizer Bypass Prevention
───────────────────────────────────────────────────────────────
  Result: 15/15 passed (100%) OK

Category Summary: 60/61 passed (98.4%) OK

╔═══════════════════════════════════════════════════════════════╗
║                      OVERALL SUMMARY                          ║
╚═══════════════════════════════════════════════════════════════╝

Results by Category:
───────────────────────────────────────────────────────────────
  Security:                  60/ 61 passed ( 98.4%) FAIL
  Infrastructure:            30/ 30 passed (100.0%) OK
  Application:               77/ 77 passed (100.0%) OK
```

## Test Statistics

| Category | Test Suites | Coverage |
|----------|-------------|----------|
| Security | 5 | CSRF, JWT, Rate Limiting, XSS, Sanitizer |
| Core Infrastructure | 4 | Cache, Sessions, Queue, Notifications, Activity |
| Application Layer | 4 | Validation, Middleware, API, Models |
| **Total** | **13** | **Comprehensive framework coverage** |

## Writing New Tests

### Test File Template

Test files should follow the `.test.php` naming convention and use hyphens for multi-word names.

```php
#!/usr/bin/env php
<?php

require_once __DIR__ . '/../../vendor/autoload.php';

echo "=== Your Test Name ===\n\n";

// Test 1
echo "Test 1: Description\n";
if ($condition) {
    echo "OK PASS: Test passed\n";
} else {
    echo "FAIL FAIL: Test failed\n";
}

// Final summary
echo "\n=== Test Complete ===\n";
exit($failedCount > 0 ? 1 : 0);
```

### Adding to Test Runner

Edit `core/Console/Commands/TestCommand.php` and add your test to the appropriate category in the `$testSuites` array:

```php
'security' => [
    'your-test' => [
        'name' => 'Your Test Name',
        'file' => 'Integration/security/your-test.test.php'
    ],
    // ... other tests
],
```

**File naming convention:**
- Use `.test.php` extension
- Use hyphens for multi-word names (e.g., `csrf-protection.test.php`)
- Place in appropriate category folder (`Integration/security/`, `Integration/infrastructure/`, or `Integration/application/`)
- For unit tests, use `Unit/` folder (coming soon)

## CI/CD Integration

The test suite is designed for CI/CD pipelines:

```bash
# Run all tests (exit code 0 = success, 1 = failure)
php sixorbit test

# Run security tests only
php sixorbit test security

# Run infrastructure tests only
php sixorbit test infrastructure

# Run application tests only
php sixorbit test application
```

## Maintenance

### Updating Tests

When framework features change:
1. Update relevant test file in its category folder
2. Run test to verify: `php sixorbit test <test-name>`
3. Run full suite: `php sixorbit test`
4. Update this guide if test coverage changes

### Test Coverage Goals

- [x] Security Integration: 100% coverage of authentication, authorization, XSS prevention
- [x] Core Infrastructure Integration: All major services (cache, queue, sessions, notifications)
- [x] Application Layer Integration: Validation, middleware, API, ORM relationships
- [ ] Unit Tests: Coming soon (individual class/method testing in isolation)

## Recent Updates

### 2026-01-30
- [x] Reorganized tests into `Integration/` and `Unit/` folders for proper test categorization
- [x] Organized integration test files into contextual folders (`security/`, `infrastructure/`, `application/`)
- [x] Renamed all test files to modern `.test.php` convention with hyphens
- [x] Added colorful ANSI output to `sixorbit test` command (green/red/cyan)
- [x] Added `sanitizer-bypass.test.php` - DOMDocument-based sanitizer testing
- [x] Created comprehensive test runner with category grouping
- [x] Updated security test suite to include sanitizer tests

---

**Framework Version:** 2.0
**Test Suite Version:** 2.0
**Last Updated:** 2026-01-30
