# Test Colors Guide

Guide for using the TestHelper class to create colorful, readable test output.

## Setup

Include the TestHelper at the top of your test file:

```php
#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/TestHelper.php';
```

## Color Scheme

All colors are centrally controlled in `TestHelper.php`:

- **Cyan** (`header`) - Headers and section titles
- **Green** (`success`) - Passing tests, success messages
- **Red** (`error`) - Failing tests, errors
- **Yellow** (`warning`) - Warnings, informational failures
- **Blue** (`info`) - Test numbers, informational text
- **Bold** (`bold`) - Bold text

## Available Methods

### Headers

```php
TestHelper::header('Test Name');
// Output: === Test Name === (in cyan)
```

### Test Numbers/Sections

```php
TestHelper::test('Test 1: Token Generation');
// Output: Test 1: Token Generation (in blue, with newline before)
```

### Success Messages

```php
TestHelper::success('Token generated successfully');
// Output: ✓ Token generated successfully (in green)
```

### Error Messages

```php
TestHelper::error('FAIL: Invalid token');
// Output: ✗ FAIL: Invalid token (in red)
```

### Warning Messages

```php
TestHelper::warning('Deprecated method used');
// Output: ⚠ Deprecated method used (in yellow)
```

### Info Messages

```php
TestHelper::info('Running 10 tests...');
// Output: Running 10 tests... (in blue)
```

### Yes/No Values

For pass/fail scenarios (Yes=green, No=red):

```php
echo TestHelper::yesNo('Token valid: ', true) . "\n";
// Output: Token valid: Yes (Yes in green)

echo TestHelper::yesNo('Security enabled: ', false) . "\n";
// Output: Security enabled: No (No in red)
```

For informational scenarios (Yes=green, No=yellow):

```php
echo TestHelper::yesNoInfo('Feature enabled: ', true) . "\n";
// Output: Feature enabled: Yes (Yes in green)

echo TestHelper::yesNoInfo('Debug mode: ', false) . "\n";
// Output: Debug mode: No (No in yellow)
```

### Test Complete

```php
TestHelper::complete('CSRF Protection Test');
// Output: === CSRF Protection Test Complete === (in cyan)
```

### Summary

```php
TestHelper::summary($passed, $failed);
// Prints formatted summary with:
// - Header in cyan
// - Passed count in green
// - Failed count in red (if > 0)
// - Status message (ALL TESTS PASSED or SOME TESTS FAILED)
```

### Custom Colorization

```php
echo TestHelper::colorize('Custom text', 'success') . "\n";
// Available colors: header, success, error, warning, info, bold
```

## Complete Example

```php
#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/TestHelper.php';

TestHelper::header('My Test Suite');
echo "\n";

$passed = 0;
$failed = 0;

// Test 1
TestHelper::test('Test 1: Basic Functionality');
if ($result === $expected) {
    TestHelper::success('PASS: Function returns correct value');
    $passed++;
} else {
    TestHelper::error('FAIL: Expected ' . $expected . ', got ' . $result);
    $failed++;
}

// Test 2
TestHelper::test('Test 2: Configuration');
echo TestHelper::yesNoInfo('Feature enabled: ', $config['feature']) . "\n";
echo TestHelper::yesNo('Valid setup: ', $isValid) . "\n";

// Summary
TestHelper::complete('My Test Suite');
TestHelper::summary($passed, $failed);

exit($failed > 0 ? 1 : 0);
```

## Output Example

When run, the above produces colorful output like:

```
=== My Test Suite === (cyan)

Test 1: Basic Functionality (blue)
✓ PASS: Function returns correct value (green)

Test 2: Configuration (blue)
Feature enabled: Yes (Yes in green)
Valid setup: No (No in red)

=== My Test Suite Complete === (cyan)

=== Test Summary === (cyan)
Passed: 1 (green)
Failed: 1 (red)

✗ SOME TESTS FAILED (red)
```

## Centralized Color Control

All colors are defined in the `TestHelper::$colors` array:

```php
protected static array $colors = [
    'header' => "\033[1;36m",      // Bright cyan
    'success' => "\033[1;32m",     // Bright green
    'error' => "\033[1;31m",       // Bright red
    'warning' => "\033[1;33m",     // Bright yellow
    'info' => "\033[1;34m",        // Bright blue
    'bold' => "\033[1m",           // Bold
    'reset' => "\033[0m",          // Reset
];
```

To change colors across all tests, simply modify these values in `TestHelper.php`.

## Best Practices

1. **Always use TestHelper for colors** - Don't hardcode ANSI codes in test files
2. **Use semantic methods** - Use `success()` for passes, `error()` for failures
3. **Consistent structure** - Header → Tests → Complete → Summary
4. **Exit codes** - Return 0 for success, 1 for any failures
5. **Yes/No context** - Use `yesNo()` for pass/fail, `yesNoInfo()` for status

---

**See also:**
- [TESTING-GUIDE.md](../docs/md/TESTING-GUIDE.md) - Complete testing guide
- [TEST-DOCUMENTATION.md](../docs/md/TEST-DOCUMENTATION.md) - Test suite overview
