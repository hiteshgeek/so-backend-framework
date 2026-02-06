# Forms & Validation - Developer Guide

**SO Framework** | **Step-by-Step Form Handling** | **Version 1.0**

A practical, step-by-step guide to building forms, protecting them with CSRF tokens, validating user input on the server side, and displaying errors back to the user.

---

## Table of Contents

1. [Overview](#overview)
2. [Creating an HTML Form](#creating-an-html-form)
3. [Method Spoofing](#method-spoofing)
4. [CSRF Protection](#csrf-protection)
5. [Server-Side Validation](#server-side-validation)
6. [Displaying Errors in Views](#displaying-errors-in-views)
7. [Preserving Old Input](#preserving-old-input)
8. [Common Validation Rules](#common-validation-rules)
9. [Complete Example](#complete-example)

---

## Overview

Every web application needs to collect data from users and make sure that data is safe and correct before processing it. The SO Framework provides a streamlined workflow for this:

1. **Render a form** with a CSRF token to prevent cross-site request forgery.
2. **Submit the form** via POST (or PUT/DELETE with method spoofing).
3. **Validate the data** on the server using `Validator::make()`.
4. **Redirect back with errors** if validation fails, preserving the user's input.
5. **Process the data** if validation passes.

```
Browser                            Server
  |                                  |
  |  GET /register                   |
  |--------------------------------->|  Controller renders form
  |  <form> with csrf_field()        |  with CSRF token
  |<---------------------------------|
  |                                  |
  |  POST /register                  |
  |  _token + form fields            |
  |--------------------------------->|  CsrfMiddleware checks _token
  |                                  |  Validator::make() checks rules
  |                                  |
  |       [validation fails]         |  redirect()->withErrors()->withInput()
  |<---------------------------------|
  |  Re-render form with errors      |
  |                                  |
  |  POST /register (corrected)      |
  |--------------------------------->|  Validation passes
  |                                  |  Process data, redirect to dashboard
  |<---------------------------------|
```

### Key Functions at a Glance

| Function | Purpose |
|----------|---------|
| `csrf_field()` | Outputs a hidden `<input>` containing the CSRF token |
| `csrf_token()` | Returns the raw CSRF token string |
| `Validator::make($data, $rules)` | Creates a validator instance |
| `$validator->fails()` | Returns `true` if any rule was violated |
| `$validator->errors()` | Returns an array of `field => [error messages]` |
| `redirect()->withErrors()` | Flashes errors into the session |
| `redirect()->withInput()` | Flashes submitted values into the session |
| `session('errors')` | Reads flashed errors in the next request |
| `old('field')` | Reads a previously submitted value for a field |

---

## Creating an HTML Form

Forms are standard HTML with a few framework helpers added. Every form that sends data (POST, PUT, DELETE) must include a CSRF token.

### Basic Form Structure

```html
<form method="POST" action="<?= url('/register') ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="">
    </div>

    <button type="submit">Submit</button>
</form>
```

The `csrf_field()` helper outputs the following hidden input:

```html
<input type="hidden" name="_token" value="a1b2c3d4e5f6...">
```

### Form Action URLs

Always use the `url()` or `route()` helpers to generate action URLs so they remain portable across environments.

```php
<!-- Using url() helper -->
<form method="POST" action="<?= url('/users') ?>">

<!-- Using named route -->
<form method="POST" action="<?= route('users.store') ?>">
```

### Pointing at a Controller

Define a route in `routes/web.php` that maps to your controller method:

```php
use Core\Routing\Router;
use App\Controllers\UserController;

Router::get('/register', [UserController::class, 'showRegister'])->name('register');
Router::post('/register', [UserController::class, 'register'])->name('register.submit');
```

---

## Method Spoofing

HTML forms only support `GET` and `POST`. To send `PUT`, `PATCH`, or `DELETE` requests, add a hidden `_method` field alongside the CSRF token.

### PUT Request (Update)

```html
<form method="POST" action="<?= url('/users/' . $user->id) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= e($user->name) ?>">
    </div>

    <button type="submit">Update Profile</button>
</form>
```

### DELETE Request

```html
<form method="POST" action="<?= url('/users/' . $user->id) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">

    <button type="submit" onclick="return confirm('Are you sure?')">
        Delete Account
    </button>
</form>
```

### Corresponding Routes

```php
Router::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Router::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
```

The framework reads the `_method` field and dispatches the request to the correct route even though the browser sends a `POST`.

---

## CSRF Protection

### What is CSRF?

Cross-Site Request Forgery is an attack where a malicious website tricks a user's browser into submitting a request to your application while the user is logged in. Because the browser automatically sends session cookies, the request appears legitimate.

### How the Framework Prevents It

1. When a user visits your page, `csrf_token()` generates a unique random token and stores it in the session.
2. You embed the token in your form with `csrf_field()`.
3. When the form is submitted, `CsrfMiddleware` compares the `_token` field (or the `X-CSRF-TOKEN` header) against the session value.
4. If they match, the request proceeds. If they do not match, the framework returns a **419** status code.

### Where to Add csrf_field()

Add `csrf_field()` inside every `<form>` that uses `POST`, `PUT`, `PATCH`, or `DELETE`:

```html
<form method="POST" action="<?= url('/contact') ?>">
    <?= csrf_field() ?>
    <!-- form fields here -->
</form>
```

### For AJAX Requests

If you submit data via JavaScript instead of a form, include the token in a request header:

```html
<meta name="csrf-token" content="<?= csrf_token() ?>">
```

```php
<script>
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

fetch('<?= url('/api/data') ?>', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': token,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ name: 'Example' })
});
</script>
```

### Routes Excluded from CSRF

API routes (prefixed with `api/`) and webhook routes are typically excluded from CSRF verification. This is configured in `config/security.php`:

```php
'csrf' => [
    'enabled' => env('CSRF_ENABLED', true),
    'except' => [
        'api/*',
        'webhooks/*',
    ],
],
```

---

## Server-Side Validation

After a form is submitted and the CSRF token is verified, you validate the data in your controller.

### Step 1 -- Create a Validator

Use `Validator::make()` to create a validator with the submitted data and a set of rules:

```php
use Core\Validation\Validator;

public function register(Request $request): Response
{
    $validator = Validator::make($request->all(), [
        'name'     => 'required|string|min:2|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);
```

Each key in the rules array corresponds to a form field name. Rules for a single field are separated by the pipe `|` character.

### Step 2 -- Check for Failures

Call `$validator->fails()` to see whether any rule was violated:

```php
    if ($validator->fails()) {
        return redirect(url('/register'))
            ->withErrors($validator->errors())
            ->withInput($request->only(['name', 'email']));
    }
```

- `withErrors()` stores the error array in the session so the next request can read it.
- `withInput()` stores the submitted values so form fields can be repopulated. Always exclude sensitive fields like `password`.

### Step 3 -- Process Valid Data

If validation passes, proceed with your business logic:

```php
    // Validation passed -- create the user
    $user = User::create([
        'name'     => $request->input('name'),
        'email'    => $request->input('email'),
        'password' => $request->input('password'),
    ]);

    auth()->login($user);

    return redirect(url('/dashboard'))
        ->with('success', 'Account created successfully!');
}
```

### Custom Error Messages

Pass a third argument to override the default messages for specific field/rule combinations:

```php
$validator = Validator::make($request->all(), [
    'email'    => 'required|email',
    'password' => 'required|min:8',
], [
    'email.required'  => 'We need your email address to create an account.',
    'email.email'     => 'That does not look like a valid email.',
    'password.min'    => 'Your password should be at least 8 characters long.',
]);
```

---

## Displaying Errors in Views

When `withErrors()` flashes errors into the session, they are available in the next request as `session('errors')`. Your controller should pass them to the view.

### Controller Setup

```php
public function showRegister(Request $request): Response
{
    return Response::view('auth/register', [
        'title'  => 'Register - ' . config('app.name'),
        'errors' => session('errors', []),
        'old'    => session('_old_input', []),
    ]);
}
```

### Displaying All Errors at the Top

Show a summary block above the form:

```html
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>
        <ul>
            <?php foreach ($errors as $field => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    <li><?= e($message) ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
```

### Displaying Errors per Field

Show each error next to its respective field for a better user experience:

```html
<div class="form-group">
    <label for="email">Email</label>
    <input
        type="email"
        id="email"
        name="email"
        value="<?= e(old('email')) ?>"
        class="<?= isset($errors['email']) ? 'input-error' : '' ?>"
    >
    <?php if (isset($errors['email'])): ?>
        <span class="error-text"><?= e($errors['email'][0]) ?></span>
    <?php endif; ?>
</div>
```

### Displaying All Errors for One Field

If a field can have multiple errors (for example, `required` and `email` both failing), you can loop through them:

```html
<?php if (isset($errors['password'])): ?>
    <ul class="error-list">
        <?php foreach ($errors['password'] as $message): ?>
            <li><?= e($message) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
```

### Suggested CSS

```html
<style>
    .alert-danger {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 12px 16px;
        border-radius: 4px;
        margin-bottom: 16px;
    }
    .input-error {
        border-color: #dc3545;
    }
    .error-text {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 4px;
        display: block;
    }
</style>
```

---

## Preserving Old Input

When validation fails the user should not have to re-type everything. The `withInput()` method flashes the submitted values into the session, and the `old()` helper retrieves them.

### Flashing Input in the Controller

```php
if ($validator->fails()) {
    return redirect(url('/register'))
        ->withErrors($validator->errors())
        ->withInput($request->only(['name', 'email']));
        // Never flash passwords!
}
```

`$request->only(['name', 'email'])` returns only those fields. You can also use `$request->except(['password', 'password_confirmation'])` to exclude sensitive fields.

### Reading Old Values in the View

Use the `old()` helper to populate form fields:

```html
<input type="text" name="name" value="<?= e(old('name')) ?>">
<input type="email" name="email" value="<?= e(old('email')) ?>">
```

If no old value exists (first visit), `old()` returns `null`, and `e(null)` outputs an empty string, so the field starts blank.

### Providing a Default Value

You can pass a second argument to `old()` as a fallback:

```php
<input type="text" name="name" value="<?= e(old('name', $user->name ?? '')) ?>">
```

This is useful on edit forms where you want to display the existing database value when there is no old input.

### Checkboxes and Selects

```html
<!-- Checkbox -->
<input
    type="checkbox"
    name="terms"
    value="1"
    <?= old('terms') === '1' ? 'checked' : '' ?>
>

<!-- Select -->
<select name="role">
    <option value="">-- Select Role --</option>
    <option value="user" <?= old('role') === 'user' ? 'selected' : '' ?>>User</option>
    <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
</select>
```

### Textarea

```html
<textarea name="bio"><?= e(old('bio')) ?></textarea>
```

---

## Available Validation Rules

The framework includes **66+ built-in validation rules**. Rules can be combined with the pipe `|` character, for example `'required|email|max:255'`.

For complete documentation with examples, see [Validation System Guide](/docs/validation-system).

### Required Rules

| Rule | Description | Example |
|------|-------------|---------|
| `required` | Field must be present and not empty | `'name' => 'required'` |
| `required_if:field,value` | Required when another field equals a value | `'billing' => 'required_if:payment,card'` |
| `required_with:field` | Required when another field is present | `'confirm' => 'required_with:password'` |
| `required_with_all:field1,field2` | Required when ALL other fields are present | `'signature' => 'required_with_all:terms,privacy'` |
| `required_without:field` | Required when another field is absent | `'email' => 'required_without:phone'` |
| `required_without_all:field1,field2` | Required when ALL other fields are absent | `'contact' => 'required_without_all:email,phone'` |
| `required_unless:field,val1,val2` | Required unless another field has specified values | `'tax_id' => 'required_unless:type,personal'` |

### Type Rules

| Rule | Description | Example |
|------|-------------|---------|
| `string` | Field must be a string | `'name' => 'required|string'` |
| `integer` | Field must be an integer | `'age' => 'required|integer'` |
| `numeric` | Field must be a number (int or float) | `'price' => 'required|numeric'` |
| `boolean` | Field must be boolean (`true`, `false`, `1`, `0`, `'1'`, `'0'`) | `'active' => 'boolean'` |
| `array` | Field must be an array | `'tags' => 'array'` |
| `email` | Field must be a valid email address | `'email' => 'required|email'` |
| `url` | Field must be a valid URL | `'website' => 'url'` |
| `ip` | Must be a valid IP address (IPv4 or IPv6) | `'server_ip' => 'ip'` |
| `uuid` | Must be a valid UUID (versions 1-5) | `'user_id' => 'uuid'` |
| `ulid` | Must be a valid ULID | `'order_id' => 'ulid'` |
| `json` | Must be valid JSON string | `'metadata' => 'json'` |
| `timezone` | Must be a valid timezone identifier | `'timezone' => 'timezone'` |
| `mac_address` | Must be a valid MAC address | `'device_mac' => 'mac_address'` |

### String Rules

| Rule | Description | Example |
|------|-------------|---------|
| `alpha` | Only alphabetic characters (a-z, A-Z) | `'code' => 'alpha'` |
| `alpha_num` | Only letters and numbers | `'username' => 'alpha_num'` |
| `alpha_dash` | Letters, numbers, dashes, and underscores | `'slug' => 'alpha_dash'` |
| `lowercase` | Value must be all lowercase | `'username' => 'lowercase'` |
| `uppercase` | Value must be all uppercase | `'country_code' => 'uppercase'` |
| `starts_with:val1,val2` | String must start with one of the values | `'phone' => 'starts_with:+1,+44'` |
| `ends_with:val1,val2` | String must end with one of the values | `'email' => 'ends_with:@company.com'` |
| `doesnt_start_with:val1,val2` | String must NOT start with values | `'username' => 'doesnt_start_with:admin,root'` |
| `doesnt_end_with:val1,val2` | String must NOT end with values | `'file' => 'doesnt_end_with:.exe,.bat'` |

### Numeric Rules

| Rule | Description | Example |
|------|-------------|---------|
| `min:N` | Minimum value (numbers) or length (strings) | `'password' => 'required|min:8'` |
| `max:N` | Maximum value (numbers) or length (strings) | `'name' => 'required|max:255'` |
| `between:min,max` | Value/length between min and max (inclusive) | `'age' => 'integer|between:18,120'` |
| `digits:N` | Must have exactly N digits | `'pin' => 'digits:4'` |
| `digits_between:min,max` | Must have between min and max digits | `'phone' => 'digits_between:10,15'` |
| `decimal:min,max` | Decimal with specified precision | `'price' => 'decimal:2'` |
| `multiple_of:value` | Must be a multiple of value | `'quantity' => 'multiple_of:5'` |

### Comparison Rules

| Rule | Description | Example |
|------|-------------|---------|
| `same:field` | Must match the value of another field | `'confirm_email' => 'same:email'` |
| `different:field` | Must differ from another field | `'new_pass' => 'different:old_pass'` |
| `confirmed` | A matching `{field}_confirmation` field must exist | `'password' => 'required|confirmed'` |
| `gt:field` | Must be greater than another field | `'end_date' => 'gt:start_date'` |
| `gte:field` | Must be greater than or equal to another field | `'end_date' => 'gte:start_date'` |
| `lt:field` | Must be less than another field | `'discount' => 'lt:price'` |
| `lte:field` | Must be less than or equal to another field | `'down_payment' => 'lte:total'` |
| `in:val1,val2,...` | Field must be one of the listed values | `'status' => 'in:draft,published'` |
| `not_in:val1,val2` | Field must NOT be one of the listed values | `'role' => 'not_in:admin,superadmin'` |

### Date Rules

| Rule | Description | Example |
|------|-------------|---------|
| `date` | Must be a parseable date string | `'dob' => 'required|date'` |
| `date_format:format` | Must match specific date format | `'dob' => 'date_format:Y-m-d'` |
| `before:date` | Must be before the given date | `'start' => 'date|before:2026-12-31'` |
| `before_or_equal:date` | Must be before or equal to date | `'registration' => 'before_or_equal:today'` |
| `after:date` | Must be after the given date | `'end' => 'date|after:2026-01-01'` |
| `after_or_equal:date` | Must be after or equal to date | `'start' => 'after_or_equal:today'` |

### Database Rules

| Rule | Description | Example |
|------|-------------|---------|
| `unique:table,column` | Value must not exist in database table | `'email' => 'unique:users,email'` |
| `unique:table,column,except` | Same as `unique` but ignores a row by ID | `'email' => 'unique:users,email,' . $id` |
| `exists:table,column` | Value must exist in the database table | `'category_id' => 'exists:categories,id'` |

### File Validation Rules

| Rule | Description | Example |
|------|-------------|---------|
| `file` | Field must be a valid uploaded file | `'document' => 'required|file'` |
| `image` | Must be a valid image (GIF, JPEG, PNG, BMP, WEBP) | `'avatar' => 'required|image'` |
| `mimes:ext1,ext2` | File extension must match allowed types | `'avatar' => 'mimes:jpg,png,gif'` |
| `max_file_size:kb` | Maximum file size in kilobytes | `'upload' => 'max_file_size:2048'` |
| `min_file_size:kb` | Minimum file size in kilobytes | `'document' => 'min_file_size:10'` |
| `dimensions:constraints` | Image dimension constraints | `'avatar' => 'dimensions:min_width=100,max_width=1000'` |

**Dimension Constraints**: `min_width`, `max_width`, `min_height`, `max_height`, `width`, `height`, `ratio`

### Pattern Matching Rules

| Rule | Description | Example |
|------|-------------|---------|
| `regex:pattern` | Value must match regular expression | `'code' => 'regex:/^[A-Z]{3}\d{3}$/'` |
| `not_regex:pattern` | Value must NOT match regular expression | `'username' => 'not_regex:/[<>]/'` |

### Conditional Rules

| Rule | Description | Example |
|------|-------------|---------|
| `nullable` | Allows the field to be null | `'middle_name' => 'nullable|string'` |
| `sometimes` | Only validate if field is present | `'bio' => 'sometimes|string|max:500'` |
| `bail` | Stop validation after first failure | `'email' => 'bail|required|email|unique:users'` |
| `exclude_if:field,value` | Exclude field if condition is met | `'discount' => 'exclude_if:type,free'` |
| `exclude_unless:field,value` | Exclude field unless condition is met | `'vat' => 'exclude_unless:country,EU'` |

### Array Syntax for Rules

When a field needs closure-based or custom rule objects, use array syntax instead of the pipe string:

```php
'discount' => [
    'required',
    'numeric',
    function ($value) {
        if ($value > 50) {
            return 'Discount cannot exceed 50%.';
        }
        return null; // passes
    },
],
```

---

## Complete Example

Below is a full registration flow: route definitions, controller, and view template. It demonstrates CSRF protection, server-side validation, error display, and old input preservation.

### Routes

```php
// routes/web.php

use Core\Routing\Router;
use App\Controllers\RegisterController;

Router::get('/register', [RegisterController::class, 'showForm'])->name('register');
Router::post('/register', [RegisterController::class, 'submit'])->name('register.submit');
```

### Controller

```php
<?php
// app/Controllers/RegisterController.php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

class RegisterController
{
    /**
     * Show the registration form
     */
    public function showForm(Request $request): Response
    {
        return Response::view('auth/register', [
            'title'  => 'Register - ' . config('app.name'),
            'errors' => session('errors', []),
            'old'    => session('_old_input', []),
        ]);
    }

    /**
     * Handle form submission
     */
    public function submit(Request $request): Response
    {
        // 1. Build the validator
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:2|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'     => 'Please enter your full name.',
            'email.required'    => 'An email address is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already registered.',
            'password.required' => 'Please choose a password.',
            'password.min'      => 'Your password must be at least 8 characters.',
            'password.confirmed'=> 'The passwords do not match.',
        ]);

        // 2. Check for failures
        if ($validator->fails()) {
            return redirect(url('/register'))
                ->withErrors($validator->errors())
                ->withInput($request->only(['name', 'email']));
        }

        // 3. Validation passed -- create user
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        // 4. Log the user in and redirect
        auth()->login($user);

        return redirect(url('/dashboard'))
            ->with('success', 'Welcome, ' . $user->name . '! Your account is ready.');
    }
}
```

### View Template

```php
<?php
// resources/views/auth/register.php

$title = $title ?? 'Register';

ob_start();
?>

<div class="container">
    <div class="register-form">
        <h1>Create an Account</h1>

        <!-- Global error summary -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach ($errors as $field => $messages): ?>
                        <?php foreach ($messages as $message): ?>
                            <li><?= e($message) ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= url('/register') ?>">
            <?= csrf_field() ?>

            <!-- Name -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= e(old('name')) ?>"
                    class="<?= isset($errors['name']) ? 'input-error' : '' ?>"
                    required
                >
                <?php if (isset($errors['name'])): ?>
                    <span class="error-text"><?= e($errors['name'][0]) ?></span>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= e(old('email')) ?>"
                    class="<?= isset($errors['email']) ? 'input-error' : '' ?>"
                    required
                >
                <?php if (isset($errors['email'])): ?>
                    <span class="error-text"><?= e($errors['email'][0]) ?></span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="<?= isset($errors['password']) ? 'input-error' : '' ?>"
                    required
                >
                <small>Minimum 8 characters</small>
                <?php if (isset($errors['password'])): ?>
                    <span class="error-text"><?= e($errors['password'][0]) ?></span>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                >
            </div>

            <button type="submit">Create Account</button>
        </form>

        <p>Already have an account? <a href="<?= url('/login') ?>">Log in</a></p>
    </div>
</div>

<?php
$content = ob_get_clean();
include base_path('resources/views/layouts/app.php');
?>
```

### How It All Fits Together

1. The user visits `GET /register`. The `showForm` method renders the template with empty `$errors` and `$old` arrays.
2. The user fills in the form and submits. The browser sends a `POST /register` with the CSRF token and form fields.
3. `CsrfMiddleware` checks the `_token` field against the session. If it does not match, a **419** response is returned.
4. The `submit` method creates a `Validator` with the submitted data and the rule set.
5. If `$validator->fails()` returns `true`, the controller redirects back to `/register` with the errors and old input flashed into the session.
6. The form is re-rendered. `session('errors')` now contains the error array, and `old('name')` / `old('email')` return the previously submitted values so the user does not lose their work.
7. The user corrects the mistakes and resubmits. This time validation passes, the user is created, and the controller redirects to the dashboard with a success flash message.

---

**Related Documentation:**
- [Validation System](/docs/validation-system) - Full validation rule reference and custom rules
- [Security Layer](/docs/security-layer) - CSRF, JWT, rate limiting, and XSS prevention
- [View Templates](/docs/view-templates) - Template layouts, partials, and helpers
- [Routing System](/docs/routing-system) - Route definitions and middleware

---

**Last Updated**: 2026-01-30
**Framework Version**: 1.0
