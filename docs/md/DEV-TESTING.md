# Writing Tests - Developer Guide

**SO Framework** | **PHPUnit Testing** | **Version 1.0**

A practical guide to writing unit and integration tests for your application using PHPUnit.

---

## Table of Contents

1. [Overview](#overview)
2. [Running Tests](#running-tests)
3. [Test Structure](#test-structure)
4. [Unit Tests](#unit-tests)
5. [Integration Tests](#integration-tests)
6. [Testing Controllers](#testing-controllers)
7. [Testing Models](#testing-models)
8. [Testing Services](#testing-services)
9. [Common Assertions](#common-assertions)
10. [Test Patterns](#test-patterns)
11. [Best Practices](#best-practices)

---

## Overview

Testing ensures your application works as expected and prevents regressions when adding new features.

### Testing Framework

- **PHPUnit** - Industry-standard PHP testing framework
- **Test Location** - `tests/` directory
- **Test Files** - Named `*.test.php`

### Types of Tests

- **Unit Tests** - Test individual classes/methods in isolation
- **Integration Tests** - Test how components work together
- **Feature Tests** - Test complete features end-to-end

---

## Running Tests

### Run All Tests

```bash
# Using the framework CLI
./sixorbit test

# Or directly with PHPUnit
./vendor/bin/phpunit
```

### Run Specific Test File

```bash
# Run single test file
./sixorbit test tests/Integration/security/jwt-auth.test.php

# Or with PHPUnit
./vendor/bin/phpunit tests/Integration/security/jwt-auth.test.php
```

### Run Tests by Pattern

```bash
# Run all security tests
./vendor/bin/phpunit tests/Integration/security/

# Run tests matching a pattern
./vendor/bin/phpunit --filter jwt
```

### Verbose Output

```bash
# Show detailed test output
./vendor/bin/phpunit --verbose

# Show test progress
./vendor/bin/phpunit --testdox
```

---

## Test Structure

### Basic Test File

```php
<?php

/**
 * Example Test
 *
 * Tests the Example class functionality
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        // Run before each test
        parent::setUp();
    }

    protected function tearDown(): void
    {
        // Run after each test
        parent::tearDown();
    }

    public function testBasicAssertion(): void
    {
        $this->assertTrue(true);
    }
}
```

### Test Naming Conventions

```php
// Test method names should describe what they test
public function testUserCanLogin(): void
{
    // Test code
}

public function testLoginFailsWithInvalidPassword(): void
{
    // Test code
}

public function testOrderCalculatesTotalCorrectly(): void
{
    // Test code
}
```

### AAA Pattern

Structure tests using Arrange-Act-Assert:

```php
public function testUserCreation(): void
{
    // Arrange - Set up test data
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    // Act - Perform the action
    $user = User::create($userData);

    // Assert - Verify the result
    $this->assertEquals('John Doe', $user->name);
    $this->assertEquals('john@example.com', $user->email);
}
```

---

## Unit Tests

Unit tests verify individual classes or methods work correctly in isolation.

### Testing a Service Class

```php
<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap/app.php';

use PHPUnit\Framework\TestCase;
use App\Services\OrderCalculator;

class OrderCalculatorTest extends TestCase
{
    protected OrderCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new OrderCalculator();
    }

    public function testCalculatesSubtotal(): void
    {
        $items = [
            ['price' => 10.00, 'quantity' => 2],
            ['price' => 15.00, 'quantity' => 1],
        ];

        $subtotal = $this->calculator->calculateSubtotal($items);

        $this->assertEquals(35.00, $subtotal);
    }

    public function testCalculatesTax(): void
    {
        $subtotal = 100.00;
        $taxRate = 0.08; // 8%

        $tax = $this->calculator->calculateTax($subtotal, $taxRate);

        $this->assertEquals(8.00, $tax);
    }

    public function testCalculatesTotal(): void
    {
        $items = [
            ['price' => 100.00, 'quantity' => 1],
        ];

        $total = $this->calculator->calculateTotal($items, 0.08);

        $this->assertEquals(108.00, $total);
    }
}
```

### Testing a Helper Function

```php
public function testHelperEscapesHtml(): void
{
    $input = '<script>alert("xss")</script>';
    $output = e($input);

    $this->assertEquals('&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;', $output);
}

public function testUrlHelper(): void
{
    $url = url('/api/users');

    $this->assertStringContainsString('/api/users', $url);
}
```

---

## Integration Tests

Integration tests verify that multiple components work together correctly.

### Testing Database Operations

```php
<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap/app.php';

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserDatabaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Clean up test data before each test
        db()->table('users')->where('email', 'LIKE', '%@test.com')->delete();
    }

    public function testCreateUser(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
        ]);

        $this->assertNotNull($user->id);
        $this->assertEquals('Test User', $user->name);

        // Verify database
        $found = User::find($user->id);
        $this->assertNotNull($found);
        $this->assertEquals('test@test.com', $found->email);
    }

    public function testUpdateUser(): void
    {
        $user = User::create([
            'name' => 'Original Name',
            'email' => 'original@test.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
        ]);

        $user->update(['name' => 'Updated Name']);

        $updated = User::find($user->id);
        $this->assertEquals('Updated Name', $updated->name);
    }

    protected function tearDown(): void
    {
        // Clean up after each test
        db()->table('users')->where('email', 'LIKE', '%@test.com')->delete();
        parent::tearDown();
    }
}
```

### Testing Cache Integration

```php
public function testCacheStoreAndRetrieve(): void
{
    $key = 'test_key_' . time();
    $value = ['name' => 'John Doe', 'age' => 30];

    // Store in cache
    cache()->put($key, $value, 3600);

    // Retrieve from cache
    $cached = cache()->get($key);

    $this->assertEquals($value, $cached);

    // Clean up
    cache()->forget($key);
}
```

---

## Testing Controllers

### Testing API Controllers

```php
<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap/app.php';

use PHPUnit\Framework\TestCase;
use Core\Http\Request;
use App\Controllers\Api\UserController;

class UserControllerTest extends TestCase
{
    protected UserController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new UserController();
    }

    public function testIndexReturnsJsonResponse(): void
    {
        $request = new Request();
        $response = $this->controller->index($request);

        $this->assertInstanceOf(\Core\Http\JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreCreatesUser(): void
    {
        $request = new Request();
        $request->_data = [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password123',
        ];

        $response = $this->controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());

        // Clean up
        $data = $response->getData();
        if (isset($data['user']['id'])) {
            User::find($data['user']['id'])->delete();
        }
    }
}
```

### Testing Web Controllers

```php
public function testShowReturnsView(): void
{
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
    ]);

    $request = new Request();
    $controller = new UserController();
    $response = $controller->show($request, $user->id);

    $this->assertInstanceOf(\Core\Http\Response::class, $response);
    $this->assertEquals(200, $response->getStatusCode());

    // Clean up
    $user->delete();
}
```

---

## Testing Models

### Testing Model Methods

```php
use App\Models\Order;

public function testOrderCalculatesTotal(): void
{
    $order = new Order();
    $order->subtotal = 100.00;
    $order->tax = 8.00;
    $order->shipping = 5.00;

    $total = $order->calculateTotal();

    $this->assertEquals(113.00, $total);
}

public function testOrderIsPending(): void
{
    $order = new Order(['status' => 'pending']);

    $this->assertTrue($order->isPending());
    $this->assertFalse($order->isCompleted());
}
```

### Testing Relationships

```php
public function testUserHasOrders(): void
{
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'total' => 100.00,
        'status' => 'pending',
    ]);

    $userOrders = $user->orders();

    $this->assertCount(1, $userOrders);
    $this->assertEquals($order->id, $userOrders[0]->id);

    // Clean up
    $order->delete();
    $user->delete();
}
```

---

## Testing Services

### Testing Service with Dependencies

```php
<?php

use PHPUnit\Framework\TestCase;
use App\Services\EmailService;
use App\Services\UserService;

class UserServiceTest extends TestCase
{
    public function testUserRegistrationSendsEmail(): void
    {
        // Mock the email service
        $emailService = $this->createMock(EmailService::class);

        // Expect send method to be called once
        $emailService->expects($this->once())
            ->method('send')
            ->with($this->stringContains('@test.com'));

        // Create service with mocked dependency
        $userService = new UserService($emailService);

        // Test registration
        $user = $userService->register([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password123',
        ]);

        $this->assertNotNull($user);

        // Clean up
        if ($user) {
            User::find($user->id)->delete();
        }
    }
}
```

---

## Common Assertions

### Equality Assertions

```php
// Equal values
$this->assertEquals(expected, actual);
$this->assertNotEquals(expected, actual);

// Same instance (strict equality)
$this->assertSame(expected, actual);
$this->assertNotSame(expected, actual);
```

### Boolean Assertions

```php
$this->assertTrue(condition);
$this->assertFalse(condition);
```

### Null Assertions

```php
$this->assertNull(value);
$this->assertNotNull(value);
```

### String Assertions

```php
$this->assertStringContainsString('needle', 'haystack');
$this->assertStringStartsWith('prefix', 'prefixAndMore');
$this->assertStringEndsWith('suffix', 'moreAndSuffix');
```

### Array Assertions

```php
$this->assertArrayHasKey('key', $array);
$this->assertContains('value', $array);
$this->assertCount(3, $array);
$this->assertEmpty($array);
$this->assertNotEmpty($array);
```

### Type Assertions

```php
$this->assertIsArray($value);
$this->assertIsString($value);
$this->assertIsInt($value);
$this->assertIsBool($value);
$this->assertInstanceOf(ClassName::class, $object);
```

### Exception Assertions

```php
$this->expectException(ExceptionClass::class);
$this->expectExceptionMessage('error message');

// Code that should throw exception
someFunctionThatThrows();
```

---

## Test Patterns

### Testing Exceptions

```php
public function testThrowsExceptionWhenInvalid(): void
{
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Email is required');

    $user = User::create(['name' => 'Test']); // Missing email
}
```

### Testing with Data Providers

```php
/**
 * @dataProvider emailProvider
 */
public function testEmailValidation(string $email, bool $expected): void
{
    $result = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($expected) {
        $this->assertNotFalse($result);
    } else {
        $this->assertFalse($result);
    }
}

public function emailProvider(): array
{
    return [
        ['valid@example.com', true],
        ['invalid', false],
        ['test@test', false],
        ['user@domain.co.uk', true],
    ];
}
```

### Testing Private Methods

```php
public function testPrivateMethod(): void
{
    $class = new MyClass();

    // Use reflection to access private method
    $method = new \ReflectionMethod(MyClass::class, 'privateMethod');
    $method->setAccessible(true);

    $result = $method->invoke($class, 'argument');

    $this->assertEquals('expected', $result);
}
```

### Mocking Dependencies

```php
public function testWithMock(): void
{
    // Create mock
    $mock = $this->createMock(DependencyClass::class);

    // Configure mock
    $mock->method('getData')
        ->willReturn(['id' => 1, 'name' => 'Test']);

    // Use mock
    $service = new ServiceClass($mock);
    $result = $service->process();

    $this->assertEquals('processed', $result);
}
```

---

## Best Practices

### 1. One Assert Per Test (Preferably)

```php
// Good - focused test
public function testUserNameIsSet(): void
{
    $user = new User(['name' => 'John']);
    $this->assertEquals('John', $user->name);
}

public function testUserEmailIsSet(): void
{
    $user = new User(['email' => 'john@example.com']);
    $this->assertEquals('john@example.com', $user->email);
}
```

### 2. Use Descriptive Test Names

```php
// Bad
public function testUser(): void { }

// Good
public function testUserCanBeCreatedWithValidData(): void { }
public function testUserCreationFailsWithoutEmail(): void { }
```

### 3. Clean Up Test Data

```php
protected function tearDown(): void
{
    // Delete test records
    db()->table('users')->where('email', 'LIKE', '%@test.com')->delete();
    cache()->flush();

    parent::tearDown();
}
```

### 4. Use setUp for Common Initialization

```php
protected function setUp(): void
{
    parent::setUp();

    // Common test data
    $this->testUser = User::create([
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
    ]);
}
```

### 5. Test Edge Cases

```php
public function testWithEmptyArray(): void
{
    $result = calculateTotal([]);
    $this->assertEquals(0, $result);
}

public function testWithNullValue(): void
{
    $result = formatName(null);
    $this->assertEquals('', $result);
}

public function testWithLargeNumber(): void
{
    $result = process(PHP_INT_MAX);
    $this->assertIsInt($result);
}
```

### 6. Don't Test Framework Code

```php
// Bad - testing framework functionality
public function testArrayPush(): void
{
    $array = [];
    array_push($array, 'item');
    $this->assertCount(1, $array);
}

// Good - testing your application logic
public function testOrderAddItem(): void
{
    $order = new Order();
    $order->addItem(['name' => 'Product', 'price' => 10.00]);
    $this->assertCount(1, $order->items);
}
```

### 7. Keep Tests Fast

```php
// Avoid unnecessary database operations
public function testCalculation(): void
{
    // Good - no database needed
    $calculator = new Calculator();
    $result = $calculator->add(2, 3);
    $this->assertEquals(5, $result);
}
```

### 8. Use Test Doubles for External Services

```php
public function testExternalApiCall(): void
{
    // Mock external API
    $apiClient = $this->createMock(ApiClient::class);
    $apiClient->method('get')->willReturn(['status' => 'success']);

    $service = new PaymentService($apiClient);
    $result = $service->processPayment(100.00);

    $this->assertTrue($result);
}
```

---

## Complete Test Example

```php
<?php

/**
 * Order Service Test
 *
 * Tests order creation, calculation, and processing
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap/app.php';

use PHPUnit\Framework\TestCase;
use App\Services\OrderService;
use App\Models\User;
use App\Models\Order;

class OrderServiceTest extends TestCase
{
    protected OrderService $orderService;
    protected User $testUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderService = new OrderService();

        // Create test user
        $this->testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
        ]);
    }

    public function testCreateOrderWithItems(): void
    {
        $items = [
            ['product_id' => 1, 'quantity' => 2, 'price' => 10.00],
            ['product_id' => 2, 'quantity' => 1, 'price' => 15.00],
        ];

        $order = $this->orderService->createOrder($this->testUser->id, $items);

        $this->assertNotNull($order->id);
        $this->assertEquals($this->testUser->id, $order->user_id);
        $this->assertEquals(35.00, $order->subtotal);
    }

    public function testCalculateTaxCorrectly(): void
    {
        $subtotal = 100.00;
        $tax = $this->orderService->calculateTax($subtotal);

        $this->assertEquals(8.00, $tax); // Assuming 8% tax rate
    }

    public function testProcessOrderUpdatesStatus(): void
    {
        $order = Order::create([
            'user_id' => $this->testUser->id,
            'subtotal' => 100.00,
            'tax' => 8.00,
            'total' => 108.00,
            'status' => 'pending',
        ]);

        $this->orderService->processOrder($order->id);

        $processedOrder = Order::find($order->id);
        $this->assertEquals('processing', $processedOrder->status);
    }

    protected function tearDown(): void
    {
        // Clean up test data
        Order::where('user_id', $this->testUser->id)->delete();
        $this->testUser->delete();

        parent::tearDown();
    }
}
```

---

**Related Documentation:**
- [CLI Commands](/docs/dev/cli-commands) - Running test commands
- [Models](/docs/dev/models) - Testing database models
- [API Controllers](/docs/dev/api-controllers) - Testing API endpoints

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
