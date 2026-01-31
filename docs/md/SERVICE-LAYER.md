# Service Layer Pattern

**Reading Time:** 25 minutes

The Service Layer is an architectural pattern that separates business logic from HTTP handling, making your code cleaner, more maintainable, and reusable.

---

## Table of Contents

1. [What is a Service Layer?](#what-is-a-service-layer)
2. [Why Use Services?](#why-use-services)
3. [Framework Architecture](#framework-architecture)
4. [Available Services](#available-services)
5. [Using Services in Controllers](#using-services-in-controllers)
6. [Creating Custom Services](#creating-custom-services)
7. [Best Practices](#best-practices)
8. [Real-World Examples](#real-world-examples)

---

## What is a Service Layer?

A **Service** is a class that contains **business logic** - the rules and operations that define what your application does. Services sit between your controllers and models, creating a clear separation of concerns.

### The Three-Layer Architecture

```
┌──────────────┐
│  Controller  │  ← Handles HTTP (requests, responses, redirects)
└──────┬───────┘
       │
       ▼
┌──────────────┐
│   Service    │  ← Contains business logic (what the app does)
└──────┬───────┘
       │
       ▼
┌──────────────┐
│    Model     │  ← Accesses data (database operations)
└──────────────┘
```

### Example: Password Reset

**Without Service (Bad):**
```php
// PasswordController.php
public function sendResetLink(Request $request): Response
{
    $email = $request->input('email');

    // Business logic mixed with HTTP handling
    $token = bin2hex(random_bytes(32));
    $hashedToken = hash('sha256', $token);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

    app('db')->table('password_resets')->insert([
        'email' => $email,
        'token' => $hashedToken,
        'expires_at' => $expiresAt,
    ]);

    return redirect('/password/forgot')
        ->with('success', 'Link sent!');
}
```

**With Service (Good):**
```php
// PasswordController.php
public function sendResetLink(Request $request): Response
{
    $email = $request->input('email');

    // Business logic delegated to service
    $token = $this->passwordResetService->createResetToken($email);

    // Controller only handles HTTP response
    return redirect('/password/forgot')
        ->with('success', 'Link sent!');
}

// PasswordResetService.php
public function createResetToken(string $email): string
{
    $token = bin2hex(random_bytes(32));
    $hashedToken = hash('sha256', $token);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

    app('db')->table('password_resets')
        ->where('email', '=', $email)
        ->delete();

    app('db')->table('password_resets')->insert([
        'email' => $email,
        'token' => $hashedToken,
        'created_at' => date('Y-m-d H:i:s'),
        'expires_at' => $expiresAt,
    ]);

    return $token;
}
```

---

## Why Use Services?

### 1. **Eliminates Code Duplication**

**Problem:** Same business logic in multiple controllers

```php
// PasswordController.php - Web interface
$token = bin2hex(random_bytes(32));
$hashedToken = hash('sha256', $token);
// ... 15 more lines of token logic

// PasswordApiController.php - API interface
$token = bin2hex(random_bytes(32));  // DUPLICATE
$hashedToken = hash('sha256', $token);  // DUPLICATE
// ... Same 15 lines duplicated
```

**Solution:** Business logic in one place

```php
// Both controllers use the same service
$token = $this->passwordResetService->createResetToken($email);
```

**Benefit:** Fix bugs once, update logic once

---

### 2. **Prevents Security Issues from Spreading**

**Problem:** IDOR vulnerability in multiple controllers

```php
// UserApiController.php
public function show(int $id) {
    $user = User::find($id);  // ❌ No authorization check
    return JsonResponse::success(['user' => $user]);
}

// Api/V1/UserController.php
public function show(int $id) {
    $user = User::find($id);  // ❌ Same vulnerability
    return JsonResponse::success(['user' => $user]);
}
```

**Solution:** Authorization in service layer

```php
// UserService.php
public function canAccessUser(int $targetUserId, int $requestingUserId): bool
{
    // Users can only access their own data
    return $targetUserId === $requestingUserId;
}

// Both controllers use the service
public function show(int $id) {
    if (!$this->userService->canAccessUser($id, auth()->id())) {
        return JsonResponse::error('Forbidden', 403);
    }

    $user = $this->userService->findOrFail($id);
    return JsonResponse::success(['user' => $user]);
}
```

**Benefit:** Security fix affects all endpoints automatically

---

### 3. **Makes Code Easier to Test**

**Problem:** Can't test business logic without HTTP request

```php
// Hard to test - requires full HTTP stack
public function testPasswordReset()
{
    $response = $this->post('/password/forgot', ['email' => 'test@example.com']);
    // Can't easily verify token generation logic
}
```

**Solution:** Test services directly

```php
// Easy to test - pure PHP
public function testPasswordResetTokenGeneration()
{
    $service = new PasswordResetService();
    $token = $service->createResetToken('test@example.com');

    $this->assertNotEmpty($token);
    $this->assertEquals(64, strlen($token)); // 32 bytes = 64 hex chars
}
```

**Benefit:** Fast unit tests for business logic

---

### 4. **Enables Code Reuse**

**Problem:** Business logic locked in controllers

```php
// Can't send password reset from CLI command
// Can't send password reset from scheduled job
// Can only send from web/API controllers
```

**Solution:** Services work anywhere

```php
// Use in controller
class PasswordController {
    public function sendResetLink(Request $request) {
        $token = $this->passwordResetService->createResetToken($email);
    }
}

// Use in console command
class SendPasswordResetCommand {
    public function handle() {
        $token = $this->passwordResetService->createResetToken($email);
    }
}

// Use in scheduled job
class CleanupExpiredTokensJob {
    public function run() {
        $this->passwordResetService->deleteExpiredTokens();
    }
}
```

**Benefit:** Business logic available in controllers, commands, jobs, tests

---

### 5. **Keeps Controllers Thin**

**Problem:** Fat controllers (100+ lines)

```php
class UserController
{
    public function update(Request $request, int $id): Response
    {
        // 20 lines of validation
        // 15 lines of authorization checks
        // 30 lines of business logic
        // 10 lines of database operations
        // 15 lines of response formatting
        // 10 lines of error handling
        // = 100+ lines, hard to read
    }
}
```

**Solution:** Thin controllers (20-30 lines)

```php
class UserController
{
    public function update(Request $request, int $id): Response
    {
        // Validation (5 lines)
        $validator = Validator::make($request->all(), UserValidationRules::update());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        // Business logic delegated to service (1 line)
        $user = $this->userService->updateUser($id, $request->all());

        // HTTP response (3 lines)
        return redirect('/users/' . $id)
            ->with('success', 'User updated!');
    }
}
```

**Benefit:** Controllers are easy to understand and maintain

---

## Framework Architecture

### Directory Structure

```
app/
├── Controllers/          ← HTTP request/response handling
│   ├── AuthController.php
│   ├── UserApiController.php
│   └── PasswordController.php
│
├── Services/             ← Business logic layer
│   ├── User/
│   │   └── UserService.php
│   └── Auth/
│       ├── AuthenticationService.php
│       └── PasswordResetService.php
│
├── Models/               ← Database access layer
│   └── User.php
│
└── Validation/           ← Validation rules
    ├── UserValidationRules.php
    └── PasswordValidationRules.php
```

### Request Flow

```
Browser/API Client
       ↓
┌──────────────────┐
│   Controller     │  1. Receive HTTP request
│                  │  2. Validate input (using ValidationRules)
│                  │  3. Call Service method
│                  │  4. Return HTTP response
└────────┬─────────┘
         ↓
┌──────────────────┐
│    Service       │  1. Execute business logic
│                  │  2. Check authorization
│                  │  3. Call Model methods
│                  │  4. Return data
└────────┬─────────┘
         ↓
┌──────────────────┐
│     Model        │  1. Query database
│                  │  2. Transform data
│                  │  3. Return results
└──────────────────┘
```

---

## Available Services

The framework includes three core services:

### 1. UserService

**Location:** `app/Services/User/UserService.php`

**Purpose:** User CRUD operations and authorization

**Methods:**
- `getAllUsers()` - Get all users
- `getUserById(int $id)` - Get user by ID
- `findOrFail(int $id)` - Get user or throw 404
- `createUser(array $data)` - Create new user
- `updateUser(int $id, array $data)` - Update user
- `deleteUser(int $id)` - Delete user
- `canAccessUser(int $targetUserId, int $requestingUserId)` - Authorization check
- `canModifyUser(int $targetUserId, int $requestingUserId)` - Can modify check
- `canDeleteUser(int $targetUserId, int $requestingUserId)` - Can delete check
- `toArray(User $user)` - Transform user to array

**Example:**
```php
// In controller
use App\Services\User\UserService;

class UserApiController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function show(Request $request, int $id): JsonResponse
    {
        // Authorization check
        if (!$this->userService->canAccessUser($id, auth()->id())) {
            return JsonResponse::error('Forbidden', 403);
        }

        // Get user via service
        $user = $this->userService->findOrFail($id);

        return JsonResponse::success([
            'user' => $this->userService->toArray($user)
        ]);
    }
}
```

---

### 2. AuthenticationService

**Location:** `app/Services/Auth/AuthenticationService.php`

**Purpose:** User authentication (login, register, logout)

**Methods:**
- `register(array $data)` - Create new user account
- `login(string $email, string $password, bool $remember)` - Authenticate user
- `logout()` - Log out current user
- `getCurrentUser()` - Get authenticated user
- `isAuthenticated()` - Check if user is logged in
- `userToArray(User $user)` - Transform user for API response

**Example:**
```php
// In controller
use App\Services\Auth\AuthenticationService;

class AuthController
{
    private AuthenticationService $authService;

    public function __construct()
    {
        $this->authService = new AuthenticationService();
    }

    public function login(Request $request): Response
    {
        // Validate credentials
        $validator = Validator::make($request->all(), UserValidationRules::login());
        if ($validator->fails()) {
            return redirect('/login')->withErrors($validator->errors());
        }

        // Attempt login via service
        if ($this->authService->login(
            $request->input('email'),
            $request->input('password'),
            $request->input('remember') === '1'
        )) {
            $user = $this->authService->getCurrentUser();
            return redirect('/dashboard')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return redirect('/login')->with('error', 'Invalid credentials');
    }
}
```

---

### 3. PasswordResetService

**Location:** `app/Services/Auth/PasswordResetService.php`

**Purpose:** Password reset token management

**Methods:**
- `createResetToken(string $email)` - Generate and store reset token
- `verifyToken(string $token, string $email)` - Verify token is valid
- `resetPassword(string $token, string $email, string $newPassword)` - Reset password
- `deleteToken(string $email)` - Delete used token
- `userExists(string $email)` - Check if user exists
- `buildResetUrl(string $token)` - Build reset URL

**Example:**
```php
// In controller
use App\Services\Auth\PasswordResetService;

class PasswordController
{
    private PasswordResetService $passwordResetService;

    public function __construct()
    {
        $this->passwordResetService = new PasswordResetService();
    }

    public function sendResetLink(Request $request): Response
    {
        $email = $request->input('email');

        // Check if user exists
        if (!$this->passwordResetService->userExists($email)) {
            // Don't reveal if user exists (security)
            return redirect('/password/forgot')
                ->with('success', 'If that email exists, a link has been sent.');
        }

        // Generate token via service
        $token = $this->passwordResetService->createResetToken($email);

        // Build reset URL
        $resetUrl = $this->passwordResetService->buildResetUrl($token);

        // In production: send email with $resetUrl
        // For demo: display the URL
        return redirect('/password/forgot')
            ->with('success', 'Reset link: ' . $resetUrl);
    }

    public function reset(Request $request): Response
    {
        // Reset password via service
        $success = $this->passwordResetService->resetPassword(
            $request->input('token'),
            $request->input('email'),
            $request->input('password')
        );

        if (!$success) {
            return redirect('/password/forgot')
                ->with('error', 'Invalid or expired token');
        }

        return redirect('/login')
            ->with('success', 'Password reset successfully!');
    }
}
```

---

## Using Services in Controllers

### Step 1: Import the Service

```php
use App\Services\User\UserService;
use App\Services\Auth\AuthenticationService;
use App\Services\Auth\PasswordResetService;
```

### Step 2: Initialize in Constructor

```php
class YourController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
}
```

### Step 3: Use Service Methods

```php
public function index(Request $request): JsonResponse
{
    // Get data from service
    $users = $this->userService->getAllUsers();

    // Return HTTP response
    return JsonResponse::success([
        'users' => array_map(fn($user) => $this->userService->toArray($user), $users)
    ]);
}
```

---

## Creating Custom Services

### When to Create a Service

Create a service when you have:
- ✅ Business logic that's used in multiple places
- ✅ Complex operations that don't belong in controllers
- ✅ Logic that needs to be tested independently
- ✅ Authorization checks or calculations
- ✅ Third-party API integrations

### Service Template

```php
<?php

namespace App\Services\YourModule;

use App\Models\YourModel;

/**
 * YourService
 *
 * Description of what this service does
 */
class YourService
{
    /**
     * Your business logic method
     *
     * @param mixed $param Description
     * @return mixed Description
     */
    public function yourMethod($param)
    {
        // Business logic here

        // Example: database operations
        $data = YourModel::where('column', '=', $param)->first();

        // Example: calculations
        $result = $this->calculateSomething($data);

        // Return data
        return $result;
    }

    /**
     * Private helper methods
     */
    private function calculateSomething($data)
    {
        // Helper logic
        return $data;
    }
}
```

### Example: Creating an OrderService

**Step 1: Create the service file**

```bash
touch app/Services/Order/OrderService.php
```

**Step 2: Implement the service**

```php
<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\User;

class OrderService
{
    /**
     * Create new order for user
     */
    public function createOrder(int $userId, array $items): Order
    {
        // Validate user exists
        $user = User::find($userId);
        if (!$user) {
            throw new \RuntimeException('User not found', 404);
        }

        // Calculate total
        $total = $this->calculateTotal($items);

        // Apply discount if applicable
        if ($user->hasDiscount()) {
            $total = $this->applyDiscount($total, $user->getDiscountPercent());
        }

        // Create order
        $order = Order::create([
            'user_id' => $userId,
            'total' => $total,
            'status' => 'pending',
        ]);

        // Attach items
        foreach ($items as $item) {
            $order->items()->attach($item['product_id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return $order;
    }

    /**
     * Calculate order total
     */
    private function calculateTotal(array $items): float
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Apply discount to total
     */
    private function applyDiscount(float $total, float $discountPercent): float
    {
        return $total * (1 - $discountPercent / 100);
    }
}
```

**Step 3: Use in controller**

```php
use App\Services\Order\OrderService;

class OrderController
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function store(Request $request): JsonResponse
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422);
        }

        // Create order via service
        $order = $this->orderService->createOrder(
            auth()->id(),
            $request->input('items')
        );

        // Return response
        return JsonResponse::success([
            'message' => 'Order created successfully',
            'order' => $order->toArray(),
        ], 201);
    }
}
```

---

## Best Practices

### 1. **One Service Per Domain**

✅ **Good:**
```
Services/
├── User/UserService.php
├── Order/OrderService.php
├── Product/ProductService.php
└── Auth/
    ├── AuthenticationService.php
    └── PasswordResetService.php
```

❌ **Bad:**
```
Services/
└── MainService.php  ← Everything in one file
```

---

### 2. **Services Don't Handle HTTP**

✅ **Good:**
```php
// Service returns data
public function createUser(array $data): User
{
    return User::create($data);
}

// Controller handles HTTP response
public function store(Request $request): JsonResponse
{
    $user = $this->userService->createUser($request->all());
    return JsonResponse::success(['user' => $user], 201);
}
```

❌ **Bad:**
```php
// Service returns HTTP response (wrong!)
public function createUser(array $data): JsonResponse
{
    $user = User::create($data);
    return JsonResponse::success(['user' => $user], 201);
}
```

---

### 3. **Services Don't Do Validation**

✅ **Good:**
```php
// Controller validates
$validator = Validator::make($request->all(), UserValidationRules::registration());
if ($validator->fails()) {
    return JsonResponse::error('Validation failed', 422);
}

// Service receives validated data
$user = $this->userService->createUser($request->all());
```

❌ **Bad:**
```php
// Service validates (mixing concerns)
public function createUser(array $data): User
{
    $validator = Validator::make($data, [...]); // Wrong!
    // ...
}
```

**Reason:** Validation belongs in controllers or FormRequest classes. Services assume data is already validated.

---

### 4. **Use Descriptive Method Names**

✅ **Good:**
```php
$user = $userService->createUser($data);
$token = $passwordResetService->createResetToken($email);
$canAccess = $userService->canAccessUser($userId, $requesterId);
```

❌ **Bad:**
```php
$user = $userService->create($data);  // Create what?
$token = $passwordResetService->generate($email);  // Generate what?
$canAccess = $userService->check($userId, $requesterId);  // Check what?
```

---

### 5. **Return Data, Not Views**

✅ **Good:**
```php
// Service returns data
public function getUserProfile(int $id): array
{
    $user = User::find($id);
    return [
        'name' => $user->name,
        'email' => $user->email,
        'stats' => $this->calculateUserStats($user),
    ];
}

// Controller renders view
public function show(int $id): Response
{
    $profile = $this->userService->getUserProfile($id);
    return Response::view('users/profile', ['profile' => $profile]);
}
```

❌ **Bad:**
```php
// Service renders view (wrong!)
public function getUserProfile(int $id): Response
{
    $user = User::find($id);
    return Response::view('users/profile', ['user' => $user]);
}
```

---

### 6. **Don't Inject Request Objects**

✅ **Good:**
```php
// Controller extracts data from request
public function store(Request $request): JsonResponse
{
    $user = $this->userService->createUser([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
    ]);
}

// Service receives plain data
public function createUser(array $data): User
{
    return User::create($data);
}
```

❌ **Bad:**
```php
// Service receives Request object (wrong!)
public function createUser(Request $request): User
{
    return User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
    ]);
}
```

**Reason:** Services should be framework-agnostic and reusable. They shouldn't depend on HTTP Request objects.

---

## Real-World Examples

### Example 1: User Registration with Email Verification

**UserService.php:**
```php
public function registerWithEmailVerification(array $data): User
{
    // Create user
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'email_verified_at' => null,
    ]);

    // Generate verification token
    $token = bin2hex(random_bytes(32));

    // Store token
    app('db')->table('email_verifications')->insert([
        'user_id' => $user->id,
        'token' => hash('sha256', $token),
        'created_at' => date('Y-m-d H:i:s'),
        'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours')),
    ]);

    // Return user and token
    return [
        'user' => $user,
        'verification_token' => $token,
    ];
}
```

**Controller:**
```php
public function register(Request $request): Response
{
    $validator = Validator::make($request->all(), UserValidationRules::registration());
    if ($validator->fails()) {
        return redirect('/register')->withErrors($validator->errors());
    }

    // Register via service
    $result = $this->userService->registerWithEmailVerification($request->all());

    // Send verification email
    $verificationUrl = url('/verify-email/' . $result['verification_token']);
    // mail($result['user']->email, 'Verify Email', $verificationUrl);

    return redirect('/login')
        ->with('success', 'Account created! Check your email to verify.');
}
```

---

### Example 2: Order Processing with Inventory Check

**OrderService.php:**
```php
public function processOrder(int $userId, array $items): array
{
    // Check inventory
    foreach ($items as $item) {
        if (!$this->hasInventory($item['product_id'], $item['quantity'])) {
            throw new \RuntimeException('Insufficient inventory for product ' . $item['product_id']);
        }
    }

    // Calculate total
    $total = $this->calculateTotal($items);

    // Create order
    $order = Order::create([
        'user_id' => $userId,
        'total' => $total,
        'status' => 'pending',
    ]);

    // Attach items and reduce inventory
    foreach ($items as $item) {
        $order->items()->attach($item['product_id'], [
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);

        $this->reduceInventory($item['product_id'], $item['quantity']);
    }

    return [
        'order' => $order,
        'total' => $total,
    ];
}

private function hasInventory(int $productId, int $quantity): bool
{
    $product = Product::find($productId);
    return $product && $product->stock >= $quantity;
}

private function reduceInventory(int $productId, int $quantity): void
{
    Product::where('id', '=', $productId)
        ->decrement('stock', $quantity);
}
```

---

### Example 3: Report Generation

**ReportService.php:**
```php
public function generateSalesReport(string $startDate, string $endDate): array
{
    // Get orders in date range
    $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();

    // Calculate metrics
    $totalSales = 0;
    $totalOrders = count($orders);
    $productsSold = [];

    foreach ($orders as $order) {
        $totalSales += $order->total;

        foreach ($order->items as $item) {
            $productId = $item->product_id;
            if (!isset($productsSold[$productId])) {
                $productsSold[$productId] = [
                    'name' => $item->product->name,
                    'quantity' => 0,
                    'revenue' => 0,
                ];
            }
            $productsSold[$productId]['quantity'] += $item->quantity;
            $productsSold[$productId]['revenue'] += $item->price * $item->quantity;
        }
    }

    // Sort by revenue
    uasort($productsSold, fn($a, $b) => $b['revenue'] <=> $a['revenue']);

    return [
        'period' => [
            'start' => $startDate,
            'end' => $endDate,
        ],
        'summary' => [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'average_order_value' => $totalOrders > 0 ? $totalSales / $totalOrders : 0,
        ],
        'top_products' => array_slice($productsSold, 0, 10),
    ];
}
```

**Controller:**
```php
public function salesReport(Request $request): Response
{
    $startDate = $request->input('start_date', date('Y-m-01'));
    $endDate = $request->input('end_date', date('Y-m-d'));

    // Generate report via service
    $report = $this->reportService->generateSalesReport($startDate, $endDate);

    return Response::view('reports/sales', ['report' => $report]);
}
```

---

## Summary

### Key Takeaways

1. **Services contain business logic** - Controllers handle HTTP, Services handle what the app does
2. **Services eliminate duplication** - Write logic once, use everywhere
3. **Services fix security issues** - Authorization in one place affects all endpoints
4. **Services are testable** - Test business logic without HTTP stack
5. **Services are reusable** - Use in controllers, commands, jobs, tests

### When to Use Services

✅ Create a service when you have:
- Business logic used in multiple places
- Complex operations
- Authorization checks
- Calculations or transformations
- Third-party integrations

❌ Don't create a service for:
- Simple CRUD (use models directly)
- One-time operations
- HTTP-specific logic (keep in controllers)

### Framework Services

- **UserService** - User CRUD + Authorization
- **AuthenticationService** - Login/Register/Logout
- **PasswordResetService** - Token management

---

## Related Documentation

- [Auth System](/docs/auth-system) - Authentication workflows
- [Validation System](/docs/validation-system) - ValidationRules classes
- [Security Layer](/docs/security-layer) - Security best practices
- [Testing Guide](/docs/testing-guide) - Testing services

---

**Next:** [Internal API Layer](/docs/internal-api) →
