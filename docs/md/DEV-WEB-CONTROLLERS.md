# Web Controllers

A step-by-step guide to building web controllers in the SO Backend Framework. Web controllers handle incoming HTTP requests from the browser, process form submissions, interact with models, and return rendered views or redirects.

## Table of Contents

1. [Overview](#overview)
2. [Creating a Controller](#creating-a-controller)
3. [Returning Views](#returning-views)
4. [Accessing Request Data](#accessing-request-data)
5. [Redirects & Flash Messages](#redirects--flash-messages)
6. [Reading Flash Data in Views](#reading-flash-data-in-views)
7. [Working with the Authenticated User](#working-with-the-authenticated-user)
8. [Using Services in Web Controllers](#using-services-in-web-controllers)
9. [Complete Example](#complete-example)

---

## Overview

A web controller is a plain PHP class that lives in `app/Controllers/`. Each public method handles a specific route and receives the current `Request` object as its first parameter, followed by any route parameters. The method returns a `Response` -- either a rendered view or a redirect.

The framework does **not** require controllers to extend a base class. Any class can serve as a controller as long as its methods accept `Request` and return `Response`.

A typical controller method will:

1. Read input from the `Request`.
2. Validate the input (optionally).
3. Perform business logic (query a model, save data, etc.).
4. Return a view with data **or** redirect with a flash message.

---

## Creating a Controller

### File Location

Place controller files in the `app/Controllers/` directory. Subdirectories are allowed for organization.

```
app/
  Controllers/
    ProfileController.php          <-- top-level controller
    Api/
      V1/
        UserController.php         <-- nested controller
```

### Namespace

The namespace mirrors the directory path:

```php
<?php

namespace App\Controllers;
```

For a file in `app/Controllers/Api/V1/`:

```php
<?php

namespace App\Controllers\Api\V1;
```

### Basic Structure

```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class ProfileController
{
    /**
     * Show the user profile page.
     */
    public function show(Request $request): Response
    {
        return Response::view('profile/show', [
            'title' => 'My Profile',
        ]);
    }
}
```

Key points:

- Import `Core\Http\Request` and `Core\Http\Response`.
- Each method receives `Request $request` as its first parameter.
- Route parameters (e.g., `{id}`) are passed as additional parameters after `$request`.
- Return type is `Response` (which includes `RedirectResponse` since it extends `Response`).

### Wiring the Controller to a Route

Register the controller in a route file under `routes/`:

```php
use Core\Routing\Router;
use App\Controllers\ProfileController;
use App\Middleware\AuthMiddleware;

Router::group(['middleware' => [AuthMiddleware::class]], function () {
    Router::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Router::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
```

---

## Returning Views

### Response::view()

`Response::view()` renders a PHP template from the `resources/views/` directory and wraps it in a `Response` object.

```php
Response::view('folder/file', ['key' => $value]);
```

- The first argument is the view path **relative to** `resources/views/`, without the `.php` extension.
- The second argument is an associative array of data. Each key is extracted into a local variable inside the view.

### Examples

**Render a simple page:**

```php
public function index(Request $request): Response
{
    return Response::view('welcome');
    // Loads resources/views/welcome.php
}
```

**Pass data to the view:**

```php
public function show(Request $request, int $id): Response
{
    $user = User::find($id);

    return Response::view('dashboard/edit', [
        'title'    => 'Edit User - ' . config('app.name'),
        'editUser' => $user,
        'errors'   => session('errors', []),
        'old'      => session('_old_input', []),
    ]);
}
```

Inside the view file `resources/views/dashboard/edit.php`, the variables `$title`, `$editUser`, `$errors`, and `$old` are available directly:

```php
<!-- resources/views/dashboard/edit.php -->
<h1><?= e($title) ?></h1>
<p>Editing: <?= e($editUser->name) ?></p>
```

### Setting a Status Code

`Response::view()` returns a `Response` instance, so you can chain `setStatusCode()`:

```php
public function notFound(Request $request): Response
{
    return Response::view('errors/404', [
        'title' => 'Page Not Found',
    ])->setStatusCode(404);
}
```

### Setting Response Headers

```php
public function show(Request $request): Response
{
    return Response::view('profile/show', ['user' => $user])
        ->header('X-Custom-Header', 'value')
        ->header('Cache-Control', 'no-cache');
}
```

---

## Accessing Request Data

The `Request` object provides methods to read query strings, form fields, uploaded files, headers, and more.

### Reading Input

```php
// Single field (checks POST body first, then query string)
$name = $request->input('name');

// With a default value
$page = $request->input('page', 1);

// All input merged (query + body)
$all = $request->all();

// Only specific fields
$credentials = $request->only(['email', 'password']);

// All fields except certain ones
$safe = $request->except(['password', 'password_confirmation']);

// Check if a field exists
if ($request->has('email')) {
    // ...
}
```

### File Uploads

```php
$file = $request->file('avatar');

if ($file && $file->isValid()) {
    $originalName = $file->getClientOriginalName();
    $size         = $file->getSize();
    $mime         = $file->getMimeType();
    $extension    = $file->getExtension();

    // Move to a permanent location
    $file->move(storage_path('uploads'), 'avatar_123.' . $extension);
}
```

### Headers

```php
// Read a specific header
$contentType = $request->header('Content-Type');

// Bearer token from Authorization header
$token = $request->bearerToken();

// User agent
$ua = $request->userAgent();

// Client IP address
$ip = $request->ip();
```

### Request Method & URL

```php
// Current HTTP method (GET, POST, PUT, DELETE, etc.)
$method = $request->method();

// Check if the method matches
if ($request->isMethod('POST')) {
    // ...
}

// Current URI path
$uri = $request->uri();

// Full URL (including query string)
$full = $request->fullUrl();
```

> **Note:** The framework supports HTTP method spoofing. A hidden `_method` field in a POST form will override the method to PUT, PATCH, or DELETE.

### JSON Requests

```php
// Parse the raw body as JSON
$data = $request->json();

// Check if the request expects a JSON response
if ($request->expectsJson()) {
    return Response::json(['error' => 'Not found'], 404);
}

// Check if it is an AJAX request
if ($request->ajax()) {
    // ...
}
```

---

## Redirects & Flash Messages

### Basic Redirect

Use the `redirect()` helper with `url()` to generate a full URL:

```php
return redirect(url('/dashboard'));
```

This returns a `RedirectResponse` (which extends `Response`) with a `302` status code and a `Location` header.

### Redirect with a Flash Message

Chain `->with()` to flash a key/value pair to the session. The data is available on the **next** request only (single-use).

```php
return redirect(url('/dashboard'))
    ->with('success', 'User created successfully!');
```

You can flash multiple values:

```php
return redirect(url('/dashboard'))
    ->with('success', 'Profile updated.')
    ->with('tab', 'settings');
```

### Redirect with Validation Errors

When validation fails, redirect back to the form with errors and the user's previous input:

```php
$validator = Validator::make($request->all(), [
    'name'  => 'required|min:2|max:255',
    'email' => 'required|email|unique:users,email',
]);

if ($validator->fails()) {
    return redirect(url('/register'))
        ->withErrors($validator->errors())
        ->withInput($request->except(['password', 'password_confirmation']));
}
```

- `withErrors(array $errors)` flashes the errors array under the `errors` session key.
- `withInput(array $input)` flashes the submitted data under the `_old_input` session key.
- If you call `withInput()` with no arguments, it flashes `$request->all()` automatically.

### Redirect Back

Use the `back()` helper to redirect to the previous page (reads the `Referer` header):

```php
return back()->withErrors($validator->errors());
```

### Custom Status Code

```php
// 301 permanent redirect
return redirect(url('/new-location'), 301);
```

### Full Redirect Flow (Pattern)

Here is the standard pattern for a form handler:

```php
public function store(Request $request): Response
{
    // 1. Validate
    $validator = Validator::make($request->all(), [
        'name'     => 'required|min:2|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect(url('/dashboard/users/create'))
            ->withErrors($validator->errors())
            ->withInput($request->except(['password', 'password_confirmation']));
    }

    // 2. Perform action
    User::create([
        'name'     => $request->input('name'),
        'email'    => $request->input('email'),
        'password' => $request->input('password'),
    ]);

    // 3. Redirect with success
    return redirect(url('/dashboard'))
        ->with('success', 'User created successfully!');
}
```

---

## Reading Flash Data in Views

Flash data set by `->with()`, `->withErrors()`, and `->withInput()` is available in the **next** request via the `session()` helper and the `old()` helper.

### Success and Error Messages

In the controller, pass flash data into the view's data array:

```php
public function index(Request $request): Response
{
    return Response::view('dashboard/index', [
        'title'   => 'Dashboard',
        'success' => session('success'),
        'error'   => session('error'),
    ]);
}
```

In the view, display them conditionally:

```php
<?php if ($success): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>
```

### Validation Errors

Pass errors into the view:

```php
return Response::view('auth/register', [
    'errors' => session('errors', []),
    'old'    => session('_old_input', []),
]);
```

Display per-field errors in the view:

```php
<div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" value="<?= e(old('email', '')) ?>" required>
    <?php if (isset($errors['email'])): ?>
        <div class="error"><?= e($errors['email'][0]) ?></div>
    <?php endif; ?>
</div>
```

### Old Input

The `old()` helper reads from the `_old_input` flash data. Use it to re-populate form fields after a validation failure:

```php
<input type="text" name="name" value="<?= e(old('name', '')) ?>">
```

The second argument is the default value when no old input exists.

### Calling session() Directly in Views

You can also call `session()` directly inside view files without passing the data through the controller:

```php
<?php if (session('success')): ?>
    <div class="alert alert-success"><?= e(session('success')) ?></div>
<?php endif; ?>
```

This works because `session()` is a global helper available everywhere. However, the recommended pattern is to read flash data in the controller and pass it into the view explicitly, keeping view logic minimal.

---

## Working with the Authenticated User

### How Authentication Works

The `AuthMiddleware` checks session-based authentication (and JWT for API routes). When a user is authenticated, the middleware sets the user on the request:

```php
$request->set('user', auth()->user());
```

This makes the user available via `$request->user()` in any controller method behind the `AuthMiddleware`.

### $request->user()

```php
public function show(Request $request): Response
{
    $user = $request->user();

    return Response::view('profile/show', [
        'user' => $user,
    ]);
}
```

### auth() Helper

The global `auth()` helper returns the `Auth` service. You can use it anywhere -- in controllers, middleware, or views:

```php
// Check if a user is logged in
if (auth()->check()) {
    // authenticated
}

// Check if the visitor is a guest
if (auth()->guest()) {
    // not authenticated
}

// Get the authenticated user
$user = auth()->user();

// Get the authenticated user's ID
$userId = auth()->id();
```

### Using auth() in the Controller

```php
public function index(Request $request): Response
{
    return Response::view('dashboard/index', [
        'user'  => auth()->user(),
        'users' => User::all(),
    ]);
}
```

### Protecting Routes

Apply `AuthMiddleware` at the route level to ensure only authenticated users reach the controller:

```php
use App\Middleware\AuthMiddleware;

Router::group(['middleware' => [AuthMiddleware::class]], function () {
    Router::get('/profile', [ProfileController::class, 'show']);
    Router::post('/profile', [ProfileController::class, 'update']);
});
```

If an unauthenticated user hits a protected route, the middleware redirects them to the login page with a flash message:

```php
return redirect(url($loginUrl))
    ->with('error', 'Please login to access this page.');
```

### Authorization Checks Inside a Controller

Sometimes you need to verify the user has permission to perform a specific action:

```php
public function destroy(Request $request, int $id): Response
{
    $user = User::find($id);

    if (!$user) {
        return redirect(url('/dashboard'))
            ->with('error', 'User not found.');
    }

    // Prevent deleting yourself
    if ($user->id === auth()->id()) {
        return redirect(url('/dashboard'))
            ->with('error', 'You cannot delete your own account.');
    }

    $userName = $user->name;
    $user->delete();

    return redirect(url('/dashboard'))
        ->with('success', 'User "' . $userName . '" deleted successfully.');
}
```

---

## Using Services in Web Controllers

The SO Framework uses the **Service Layer pattern** to keep controllers thin and focused on HTTP concerns. Business logic, data transformations, and complex operations live in service classes instead of controllers.

### Why Use Services?

**Benefits:**
- **Thin Controllers** - Controllers only handle HTTP (validation, views, redirects)
- **Reusable Logic** - Share code between web controllers, API controllers, CLI commands
- **Easier Testing** - Test business logic without HTTP mocking
- **Better Organization** - Group related operations by domain
- **Separation of Concerns** - Business rules don't leak into controllers

### Service-Based Controller Example

**Service:**
```php
<?php

namespace App\Services\User;

use App\Models\User;

class UserService
{
    /**
     * Get user by ID
     */
    public function getUser(int $id): ?array
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

        return $user->toArray();
    }

    /**
     * Update user profile
     */
    public function updateProfile(int $id, array $data): array
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception('User not found');
        }

        // Business logic: normalize email
        if (isset($data['email'])) {
            $data['email'] = strtolower(trim($data['email']));
        }

        // Business logic: check email uniqueness
        if (isset($data['email']) && $this->emailExists($data['email'], $id)) {
            throw new \Exception('Email already in use');
        }

        $user->update($data);

        return $user->toArray();
    }

    /**
     * Delete user
     */
    public function deleteUser(int $id): bool
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception('User not found');
        }

        return $user->delete();
    }

    /**
     * Check if email exists (excluding current user)
     */
    private function emailExists(string $email, ?int $excludeId = null): bool
    {
        $query = User::query()->where('email', '=', $email);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return count($query->get()) > 0;
    }
}
```

**Controller:**
```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;
use App\Services\User\UserService;

class ProfileController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Show user profile
     */
    public function show(Request $request): Response
    {
        try {
            $user = $this->userService->getUser(auth()->id());

            return Response::view('profile/show', [
                'title' => 'My Profile',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return redirect(url('/dashboard'))
                ->with('error', 'Unable to load profile');
        }
    }

    /**
     * Update user profile
     */
    public function update(Request $request): Response
    {
        // Validate (HTTP concern - stays in controller)
        $validator = new Validator($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
        ]);

        if (!$validator->passes()) {
            return redirect(url('/profile'))
                ->withErrors($validator->errors())
                ->withInput();
        }

        try {
            // Delegate to service (business logic)
            $this->userService->updateProfile(
                auth()->id(),
                $validator->validated()
            );

            return redirect(url('/profile'))
                ->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return redirect(url('/profile'))
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}
```

### Benefits in Action

**Without Services (Fat Controller):**
```php
public function update(Request $request): Response
{
    // Validation
    // Email normalization logic
    // Email uniqueness check
    // Update user
    // Handle errors
    // Return response
    // All in one method!
}
```

**With Services (Thin Controller):**
```php
public function update(Request $request): Response
{
    // Validate
    // Call service
    // Return response
    // Clean and focused!
}
```

### When to Use Services

**Use Services When:**
- [ ] Business logic involves multiple models
- [ ] Complex calculations or data transformations
- [ ] Logic needs to be shared (web + API + CLI)
- [ ] External API calls or integrations
- [ ] Domain rules that don't belong in controllers

**Use Direct Models When:**
- [ ] Simple CRUD with no business logic
- [ ] Prototyping quickly
- [ ] Display-only pages (no mutations)

### Built-in Services

The framework includes production-ready services:

- **UserService** - User management and profile updates
- **AuthService** - Login, logout, registration
- **PasswordResetService** - Password reset flow

**See Also:** [Service Layer Guide](SERVICE-LAYER.md)

---

## Complete Example

Below is a full `ProfileController` with two actions: showing the profile page and handling a profile update form.

### Routes

```php
// routes/web/profile.php
<?php

use Core\Routing\Router;
use App\Controllers\ProfileController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

Router::group(['middleware' => [CsrfMiddleware::class, AuthMiddleware::class]], function () {
    Router::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Router::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
```

### Controller

```php
// app/Controllers/ProfileController.php
<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * Profile Controller
 *
 * Handles viewing and updating the authenticated user's profile.
 */
class ProfileController
{
    /**
     * Show the profile page.
     */
    public function show(Request $request): Response
    {
        return Response::view('profile/show', [
            'title'   => 'My Profile - ' . config('app.name'),
            'user'    => auth()->user(),
            'success' => session('success'),
            'error'   => session('error'),
            'errors'  => session('errors', []),
            'old'     => session('_old_input', []),
        ]);
    }

    /**
     * Update the profile.
     */
    public function update(Request $request): Response
    {
        $user = auth()->user();

        // Build validation rules
        $rules = [
            'name'  => 'required|min:2|max:255',
            'email' => 'required|email',
        ];

        // Only validate password if the user supplied one
        if ($request->input('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(url('/profile'))
                ->withErrors($validator->errors())
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // Update fields
        $user->name  = $request->input('name');
        $user->email = $request->input('email');

        if ($request->input('password')) {
            $user->password = $request->input('password');
        }

        $user->save();

        return redirect(url('/profile'))
            ->with('success', 'Profile updated successfully!');
    }
}
```

### View

```php
<!-- resources/views/profile/show.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($title) ?></title>
</head>
<body>
    <h1>My Profile</h1>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= e($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= url('/profile') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name"
                   value="<?= e(old('name', $user->name)) ?>" required>
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?= e($errors['name'][0]) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="<?= e(old('email', $user->email)) ?>" required>
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?= e($errors['email'][0]) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">New Password (leave blank to keep current)</label>
            <input type="password" id="password" name="password">
            <?php if (isset($errors['password'])): ?>
                <div class="error"><?= e($errors['password'][0]) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

    <p><a href="<?= url('/dashboard') ?>">Back to Dashboard</a></p>
</body>
</html>
```

### How It All Fits Together

1. The user visits `/profile`. The router matches `GET /profile` and calls `ProfileController::show()`.
2. `AuthMiddleware` runs first. It checks `auth()->check()`, sets `$request->user`, and allows the request to proceed.
3. `CsrfMiddleware` is also in the group but only validates on POST/PUT/DELETE, so it passes through for GET.
4. `show()` calls `auth()->user()` to get the logged-in user, reads any flash data from the session, and returns `Response::view()` with the data array.
5. The view file renders the form. `old()` pre-fills fields with either previous input (after a validation failure) or the current user data.
6. The user submits the form. The router matches `POST /profile` and calls `ProfileController::update()`.
7. `CsrfMiddleware` validates the `_token` field. If it is missing or invalid, the request is rejected.
8. `update()` validates the input. If validation fails, it redirects back to `/profile` with `->withErrors()` and `->withInput()`.
9. On the redirected GET request, `show()` reads the flash data via `session('errors')` and `session('_old_input')`, and the view displays the errors with the old input values filled in.
10. If validation passes, the user model is updated and saved, and the controller redirects to `/profile` with a success flash message.

---

## Quick Reference

| Task | Code |
|------|------|
| Render a view | `Response::view('folder/file', ['key' => $val])` |
| Redirect | `redirect(url('/path'))` |
| Flash a success message | `redirect(url('/path'))->with('success', 'Done!')` |
| Flash validation errors | `redirect(url('/path'))->withErrors($validator->errors())` |
| Flash old input | `redirect(url('/path'))->withInput($request->all())` |
| Redirect back | `back()->withErrors($errors)` |
| Read single input | `$request->input('field', $default)` |
| Read all input | `$request->all()` |
| Read specific fields | `$request->only(['email', 'name'])` |
| Exclude fields | `$request->except(['password'])` |
| Check field exists | `$request->has('field')` |
| File upload | `$request->file('avatar')` |
| Read a header | `$request->header('Content-Type')` |
| HTTP method | `$request->method()` |
| Current URI | `$request->uri()` |
| Authenticated user | `$request->user()` or `auth()->user()` |
| Check if logged in | `auth()->check()` |
| Read flash data | `session('key', $default)` |
| Read old input | `old('field', $default)` |
| Escape output in views | `e($value)` |
| CSRF hidden field | `csrf_field()` |
| Generate URL | `url('/path')` |

---

## See Also

- **[Service Layer](SERVICE-LAYER.md)** - Complete guide to service pattern and domain organization
- **[API Controllers](DEV-API-CONTROLLERS.md)** - Building RESTful API controllers
- **[View Templates](VIEW-TEMPLATES.md)** - Template syntax and helpers
- **[Validation System](VALIDATION-SYSTEM.md)** - Validation rules and error handling
- **[Forms & Validation](DEV-FORMS-VALIDATION.md)** - Building and validating forms
- **[Authentication](DEV-AUTH.md)** - Login, logout, and user authentication
- **[Routing System](ROUTING-SYSTEM.md)** - Defining routes and route groups
- **[Helper Functions](DEV-HELPERS.md)** - `redirect()`, `session()`, `old()` helpers

---

**Last Updated**: 2026-02-01
**Framework Version**: 1.0
