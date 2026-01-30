# View Templates Guide

**SO Framework** | **PHP Native Templates** | **Version 2.0.0**

Complete guide to the view and templating system in the SO Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Quick Start](#quick-start)
3. [Creating Views](#creating-views)
4. [Passing Data to Views](#passing-data-to-views)
5. [Template Layouts](#template-layouts)
6. [Including Partials](#including-partials)
7. [Control Structures](#control-structures)
8. [Helper Functions](#helper-functions)
9. [Form Handling](#form-handling)
10. [Asset Management](#asset-management)
11. [XSS Protection](#xss-protection)
12. [Best Practices](#best-practices)

---

## Overview

The SO Framework uses **PHP native templates** for rendering views, providing a simple and powerful way to build views without additional dependencies.

### Features

- Native PHP syntax - no new template language to learn
- Template includes (partials)
- XSS protection via `e()` helper function
- Built-in helper functions
- Zero dependencies
- Fast performance - no compilation needed
- Full IDE support and debugging

### Why PHP Native Templates?

- **Simplicity**: Use PHP syntax you already know
- **Performance**: No template compilation step
- **Debugging**: Full stack traces with line numbers
- **IDE Support**: Full autocompletion and syntax highlighting
- **Flexibility**: Access all PHP features when needed

---

## Quick Start

### Creating Your First View

**1. Create Template File**

```php
<?php // resources/views/welcome.php ?>

<!DOCTYPE html>
<html>
<head>
    <title><?= e($title) ?></title>
</head>
<body>
    <h1>Welcome to <?= e($app_name) ?>!</h1>
    <p>Hello, <?= e($name) ?>!</p>
</body>
</html>
```

**2. Render from Controller**

```php
// app/Controllers/HomeController.php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class HomeController
{
    public function index(Request $request): Response
    {
        return Response::view('welcome', [
            'title' => 'Home Page',
            'app_name' => config('app.name'),
            'name' => 'Guest',
        ]);
    }
}
```

---

## Creating Views

### File Structure

```
resources/
+-- views/
    +-- layouts/
    |   +-- app.php           # Main layout
    +-- partials/
    |   +-- header.php        # Reusable header
    |   +-- footer.php        # Reusable footer
    |   +-- nav.php           # Navigation
    +-- auth/
    |   +-- login.php         # Login page
    |   +-- register.php      # Registration page
    +-- dashboard/
    |   +-- index.php         # Dashboard
    +-- welcome.php           # Welcome page
```

### Naming Conventions

- Use lowercase with hyphens or underscores: `user-profile.php` or `user_profile.php`
- Group related views in folders: `auth/login.php`
- Use `.php` extension for all templates

### View Helper

```php
// Render a view (returns Response)
return Response::view('welcome');

// With data
return Response::view('users/profile', ['user' => $user]);

// Using forward slash for nested folders
return Response::view('auth/login');  // resources/views/auth/login.php
```

---

## Passing Data to Views

### From Controllers

```php
public function show(Request $request, int $id): Response
{
    $user = User::find($id);
    $posts = $user->posts();

    return Response::view('users/show', [
        'user' => $user,
        'posts' => $posts,
        'title' => "Profile: {$user->name}",
    ]);
}
```

### Accessing Data in Views

All data passed to views is automatically extracted into local variables:

```php
<?php // resources/views/users/show.php ?>

<h1><?= e($user->name) ?></h1>
<p>Email: <?= e($user->email) ?></p>

<h2>Posts</h2>
<?php foreach ($posts as $post): ?>
    <article>
        <h3><?= e($post->title) ?></h3>
    </article>
<?php endforeach; ?>
```

---

## Template Layouts

### Creating a Layout

```php
<?php // resources/views/layouts/app.php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= e($title ?? config('app.name')) ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= url('/assets/css/app.css') ?>">
    <?php if (isset($styles)): ?>
        <?= $styles ?>
    <?php endif; ?>
</head>
<body>
    <!-- Navigation -->
    <?php include base_path('resources/views/partials/nav.php'); ?>

    <!-- Flash messages -->
    <?php include base_path('resources/views/partials/flash.php'); ?>

    <!-- Main content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <?php include base_path('resources/views/partials/footer.php'); ?>

    <!-- JavaScript -->
    <script src="<?= url('/assets/js/app.js') ?>"></script>
    <?php if (isset($scripts)): ?>
        <?= $scripts ?>
    <?php endif; ?>
</body>
</html>
```

### Using Layouts with Output Buffering

```php
<?php // resources/views/dashboard/index.php ?>

<?php
$title = 'Dashboard - ' . config('app.name');

ob_start();
?>
<div class="container">
    <h1>Dashboard</h1>

    <div class="stats">
        <div class="stat-card">
            <h3><?= e($user_count) ?></h3>
            <p>Total Users</p>
        </div>
        <div class="stat-card">
            <h3><?= e($post_count) ?></h3>
            <p>Total Posts</p>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

include base_path('resources/views/layouts/app.php');
?>
```

### Alternative: Simple Includes

For simpler pages, use direct includes:

```php
<?php // resources/views/home.php ?>

<?php include base_path('resources/views/partials/header.php'); ?>

<main>
    <h1>Welcome to <?= e(config('app.name')) ?></h1>
    <p>Your content here</p>
</main>

<?php include base_path('resources/views/partials/footer.php'); ?>
```

---

## Including Partials

### Basic Include

```php
<?php // resources/views/partials/nav.php ?>

<nav>
    <ul>
        <li><a href="<?= url('/') ?>">Home</a></li>
        <li><a href="<?= url('/about') ?>">About</a></li>
        <?php if (auth()->check()): ?>
            <li><a href="<?= url('/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?= url('/logout') ?>">Logout</a></li>
        <?php else: ?>
            <li><a href="<?= url('/login') ?>">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
```

### Using Partials

```php
<!-- Include a partial -->
<?php include base_path('resources/views/partials/nav.php'); ?>

<!-- Include with variables (they're already in scope) -->
<?php include base_path('resources/views/partials/user-card.php'); ?>

<!-- Conditional include -->
<?php if ($show_sidebar): ?>
    <?php include base_path('resources/views/partials/sidebar.php'); ?>
<?php endif; ?>
```

### Flash Messages Partial

```php
<?php // resources/views/partials/flash.php ?>

<?php if (session('success')): ?>
    <div class="alert alert-success">
        <?= e(session('success')) ?>
    </div>
<?php endif; ?>

<?php if (session('error')): ?>
    <div class="alert alert-danger">
        <?= e(session('error')) ?>
    </div>
<?php endif; ?>

<?php if (session('warning')): ?>
    <div class="alert alert-warning">
        <?= e(session('warning')) ?>
    </div>
<?php endif; ?>
```

---

## Control Structures

### If Statements

```php
<?php if ($user): ?>
    <p>Welcome, <?= e($user->name) ?>!</p>
<?php endif; ?>

<?php if ($age >= 18): ?>
    <p>You are an adult</p>
<?php else: ?>
    <p>You are a minor</p>
<?php endif; ?>

<?php if ($role === 'admin'): ?>
    <a href="/admin">Admin Panel</a>
<?php elseif ($role === 'moderator'): ?>
    <a href="/moderate">Moderate</a>
<?php else: ?>
    <p>Regular user</p>
<?php endif; ?>
```

### Logical Operators

```php
<?php if ($user && $user->is_active): ?>
    User is active
<?php endif; ?>

<?php if ($is_admin || $is_moderator): ?>
    Show admin features
<?php endif; ?>

<?php if (!$is_banned): ?>
    Welcome!
<?php endif; ?>
```

### For Loops

```php
<?php foreach ($users as $user): ?>
    <div class="user-card">
        <h3><?= e($user->name) ?></h3>
        <p><?= e($user->email) ?></p>
    </div>
<?php endforeach; ?>

<!-- Loop with empty check -->
<?php if (empty($posts)): ?>
    <p>No posts found.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <article>
            <h2><?= e($post->title) ?></h2>
            <p><?= e($post->content) ?></p>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Loop with index -->
<?php foreach ($users as $index => $user): ?>
    <tr class="<?= $index % 2 === 0 ? 'even' : 'odd' ?>">
        <td><?= $index + 1 ?></td>
        <td><?= e($user->name) ?></td>
    </tr>
<?php endforeach; ?>
```

---

## Helper Functions

### Built-in Framework Helpers

```php
<!-- URL helper -->
<a href="<?= url('/dashboard') ?>">Dashboard</a>

<!-- Named route -->
<a href="<?= route('user.profile', ['id' => $user->id]) ?>">Profile</a>

<!-- CSRF field -->
<form method="POST">
    <?= csrf_field() ?>
    ...
</form>

<!-- CSRF token value -->
<meta name="csrf-token" content="<?= csrf_token() ?>">

<!-- Old input (after validation error) -->
<input type="email" name="email" value="<?= e(old('email')) ?>">

<!-- Session data -->
<p><?= e(session('success')) ?></p>

<!-- Config value -->
<title><?= e(config('app.name')) ?></title>

<!-- Auth check -->
<?php if (auth()->check()): ?>
    <p>Welcome, <?= e(auth()->user()->name) ?>!</p>
<?php endif; ?>

<!-- Base path -->
<?php include base_path('resources/views/partials/nav.php'); ?>
```

---

## Form Handling

### Login Form Example

```php
<?php // resources/views/auth/login.php ?>

<?php $title = 'Login'; ?>

<?php ob_start(); ?>
<div class="container">
    <div class="login-form">
        <h1>Login</h1>

        <form method="POST" action="<?= url('/login') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= e(old('email')) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" value="1">
                    Remember Me
                </label>
            </div>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="<?= url('/register') ?>">Register</a></p>
    </div>
</div>
<?php
$content = ob_get_clean();
include base_path('resources/views/layouts/app.php');
?>
```

### Registration Form

```php
<?php // resources/views/auth/register.php ?>

<?php $title = 'Register'; ?>

<?php ob_start(); ?>
<div class="container">
    <div class="register-form">
        <h1>Create Account</h1>

        <form method="POST" action="<?= url('/register') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= e(old('name')) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= e(old('email')) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
                <small>Minimum 8 characters</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                >
            </div>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="<?= url('/login') ?>">Login</a></p>
    </div>
</div>
<?php
$content = ob_get_clean();
include base_path('resources/views/layouts/app.php');
?>
```

---

## Asset Management

### Static Assets

```php
<!-- Images -->
<img src="<?= url('/assets/images/logo.png') ?>" alt="Logo">
<img src="<?= url('/assets/images/banner.jpg') ?>" alt="Banner">

<!-- CSS -->
<link rel="stylesheet" href="<?= url('/assets/css/app.css') ?>">
<link rel="stylesheet" href="<?= url('/assets/css/dashboard.css') ?>">

<!-- JavaScript -->
<script src="<?= url('/assets/js/app.js') ?>"></script>
<script src="<?= url('/assets/js/charts.js') ?>"></script>

<!-- Fonts -->
<link rel="stylesheet" href="<?= url('/assets/fonts/custom-font.css') ?>">
```

### Versioned Assets (Cache Busting)

```php
<!-- With version parameter -->
<link rel="stylesheet" href="<?= url('/assets/css/app.css') ?>?v=<?= e($app_version) ?>">
<script src="<?= url('/assets/js/app.js') ?>?v=<?= e($app_version) ?>"></script>

<!-- With file modification time -->
<?php $cssPath = public_path('assets/css/app.css'); ?>
<link rel="stylesheet" href="<?= url('/assets/css/app.css') ?>?t=<?= filemtime($cssPath) ?>">
```

---

## XSS Protection

### Always Escape Output

The `e()` helper function escapes HTML entities to prevent XSS attacks:

```php
<!-- Safe - escaped output -->
<p><?= e($user->name) ?></p>
<p><?= e($comment->text) ?></p>

<!-- This is SAFE - HTML entities are escaped -->
<?php $malicious = '<script>alert("XSS")</script>'; ?>
<?= e($malicious) ?>
<!-- Output: &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt; -->
```

### Raw Output (Use with Caution)

```php
<!-- Raw output - NO escaping -->
<?= $html_content ?>

<!-- ONLY use raw output for trusted content -->
<?= $article->body ?>  <!-- OK if article.body is from trusted admin -->
<?= $user->bio ?>      <!-- DANGEROUS if user input! -->
```

### The e() Helper

```php
// The e() function does this:
function e(mixed $value): string
{
    if ($value === null) {
        return '';
    }
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
```

---

## Best Practices

### 1. Always Escape User Data

```php
<!-- Good - escaped -->
<p><?= e($user->name) ?></p>

<!-- Bad - XSS vulnerability! -->
<p><?= $user->name ?></p>
```

### 2. Use Alternative Syntax in Templates

```php
<!-- Good - clear structure -->
<?php if ($user): ?>
    <p>Welcome</p>
<?php endif; ?>

<?php foreach ($items as $item): ?>
    <li><?= e($item->name) ?></li>
<?php endforeach; ?>

<!-- Avoid - less readable in templates -->
<?php if ($user) { ?>
    <p>Welcome</p>
<?php } ?>
```

### 3. Keep Logic Minimal

```php
<!-- Good - simple display logic -->
<?php if ($user->is_admin): ?>
    <a href="/admin">Admin</a>
<?php endif; ?>

<!-- Bad - complex business logic in template -->
<?php
$total = 0;
foreach ($items as $item) {
    $total += $item->price * $item->quantity * (1 - $item->discount);
}
// Move this calculation to the controller!
?>
```

### 4. Use Descriptive Variable Names

```php
<!-- Good -->
<?= e($user->name) ?>
<?= e($order->total_price) ?>
<?= e($product->is_available ? 'Yes' : 'No') ?>

<!-- Bad -->
<?= e($u->n) ?>
<?= e($o->tp) ?>
<?= e($p->avail) ?>
```

### 5. Use URL Helpers

```php
<!-- Good - portable -->
<a href="<?= url('/users/' . $user->id) ?>">Profile</a>
<a href="<?= route('user.profile', ['id' => $user->id]) ?>">Profile</a>

<!-- Bad - hardcoded -->
<a href="/so-backend-framework/users/123">Profile</a>
```

### 6. Organize with Partials

```php
<!-- Good - reusable components -->
<?php include base_path('resources/views/partials/user-card.php'); ?>

<!-- Avoid - duplicating markup everywhere -->
```

---

## Complete Example

### Full Application Layout

```php
<?php // resources/views/layouts/app.php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= e($title ?? config('app.name')) ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= url('/assets/css/app.css') ?>">
    <?php if (isset($styles)): ?>
        <?= $styles ?>
    <?php endif; ?>
</head>
<body class="<?= $body_class ?? '' ?>">
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?= url('/') ?>"><?= e(config('app.name')) ?></a>
            </div>

            <?php include base_path('resources/views/partials/nav.php'); ?>
        </div>
    </header>

    <!-- Flash Messages -->
    <?php include base_path('resources/views/partials/flash.php'); ?>

    <!-- Main Content -->
    <main>
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= e(config('app.name')) ?>. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="<?= url('/assets/js/app.js') ?>"></script>
    <?php if (isset($scripts)): ?>
        <?= $scripts ?>
    <?php endif; ?>
</body>
</html>
```

---

## Summary

The SO Framework view system powered by PHP native templates provides:

- Native PHP syntax - no new language to learn
- Simple template includes for layouts and partials
- XSS protection via the `e()` helper
- Built-in framework helpers
- Easy form handling
- Asset management
- Full IDE support and debugging

PHP native templates keep your views simple, fast, and maintainable while leveraging the full power of PHP.

---

**Related Documentation:**
- [Comprehensive Guide](/docs/comprehensive) - Complete framework reference
- [Security Layer](/docs/security-layer) - XSS prevention details
- [Authentication](/docs/auth-system) - Auth in templates

---

**Last Updated**: 2026-01-30
**Framework Version**: 2.0.0
