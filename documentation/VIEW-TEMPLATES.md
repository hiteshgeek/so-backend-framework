# View Templates Guide

**SO Framework** | **Twig Template Engine** | **Version 2.0.0**

Complete guide to the view and templating system in the SO Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Quick Start](#quick-start)
3. [Creating Views](#creating-views)
4. [Template Syntax](#template-syntax)
5. [Passing Data to Views](#passing-data-to-views)
6. [Template Inheritance](#template-inheritance)
7. [Including Partials](#including-partials)
8. [Control Structures](#control-structures)
9. [Helper Functions](#helper-functions)
10. [Form Handling](#form-handling)
11. [Asset Management](#asset-management)
12. [XSS Protection](#xss-protection)
13. [Template Caching](#template-caching)
14. [Best Practices](#best-practices)

---

## Overview

The SO Framework uses **Twig** as its template engine, providing a powerful and secure way to build views.

### Features

- Clean, readable syntax
- Template inheritance (layouts)
- Template includes (partials)
- Automatic XSS protection via autoescaping
- Template caching for performance
- Built-in helper functions
- Debug mode support
- Strict variables mode (development)

### Why Twig?

- **Security**: Automatic output escaping prevents XSS
- **Performance**: Compiled templates cached
- **Maintainability**: Clear separation of logic and presentation
- **Familiar**: Similar to Blade (Laravel) and Jinja (Python)

---

## Quick Start

### Creating Your First View

**1. Create Template File**

```twig
{# resources/views/welcome.twig #}

<!DOCTYPE html>
<html>
<head>
    <title>{{ title }}</title>
</head>
<body>
    <h1>Welcome to {{ app_name }}!</h1>
    <p>Hello, {{ name }}!</p>
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
        return view('welcome', [
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
    |   +-- app.twig         # Main layout
    +-- partials/
    |   +-- header.twig      # Reusable header
    |   +-- footer.twig      # Reusable footer
    |   +-- nav.twig         # Navigation
    +-- auth/
    |   +-- login.twig       # Login page
    |   +-- register.twig    # Registration page
    +-- dashboard/
    |   +-- index.twig       # Dashboard
    +-- welcome.twig         # Welcome page
```

### Naming Conventions

- Use lowercase with underscores: `user_profile.twig`
- Group related views in folders: `auth/login.twig`
- Use `.twig` extension for all templates

### View Helper

```php
// Render a view
return view('welcome');

// With data
return view('users.profile', ['user' => $user]);

// Dot notation for nested folders
return view('auth.login');  // resources/views/auth/login.twig
```

---

## Template Syntax

### Variables

**Output Variables:**

```twig
{# Escaped output (safe from XSS) #}
{{ name }}
{{ user.email }}
{{ product.price }}

{# Raw output (use with caution!) #}
{{ html_content|raw }}
```

**Variable Types:**

```twig
{# String #}
{{ "Hello World" }}

{# Number #}
{{ 42 }}
{{ 3.14 }}

{# Boolean #}
{{ true }}
{{ false }}

{# Array #}
{{ ['apple', 'banana', 'orange'] }}

{# Object properties #}
{{ user.name }}
{{ user.email }}

{# Array access #}
{{ users[0] }}
{{ data['key'] }}
```

### Comments

```twig
{# This is a single-line comment #}

{#
   This is a
   multi-line comment
#}
```

---

## Passing Data to Views

### From Controllers

```php
public function show(Request $request, int $id): Response
{
    $user = User::find($id);
    $posts = $user->posts();

    return view('users.show', [
        'user' => $user,
        'posts' => $posts,
        'title' => "Profile: {$user->name}",
    ]);
}
```

### View Composers (Global Data)

Add data to all views:

```php
// In a service provider or bootstrap file

$view = app('view');

$view->addGlobal('app_name', config('app.name'));
$view->addGlobal('current_year', date('Y'));
$view->addGlobal('authenticated', auth()->check());

if (auth()->check()) {
    $view->addGlobal('current_user', auth()->user());
}
```

---

## Template Inheritance

### Creating a Layout

```twig
{# resources/views/layouts/app.twig #}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{% block title %}{{ config('app.name') }}{% endblock %}</title>

    {# CSS #}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {% block styles %}{% endblock %}
</head>
<body>
    {# Navigation #}
    {% include 'partials/nav.twig' %}

    {# Flash messages #}
    {% include 'partials/flash.twig' %}

    {# Main content #}
    <main>
        {% block content %}{% endblock %}
    </main>

    {# Footer #}
    {% include 'partials/footer.twig' %}

    {# JavaScript #}
    <script src="{{ asset('js/app.js') }}"></script>

    {% block scripts %}{% endblock %}
</body>
</html>
```

### Extending a Layout

```twig
{# resources/views/dashboard/index.twig #}

{% extends 'layouts/app.twig' %}

{% block title %}Dashboard - {{ parent() }}{% endblock %}

{% block styles %}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
{% endblock %}

{% block content %}
    <div class="container">
        <h1>Dashboard</h1>

        <div class="stats">
            <div class="stat-card">
                <h3>{{ user_count }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card">
                <h3>{{ post_count }}</h3>
                <p>Total Posts</p>
            </div>
        </div>
    </div>
{% endblock %}

{% block scripts %}
    <script src="{{ asset('js/dashboard.js') }}"></script>
{% endblock %}
```

### Block Features

```twig
{# Define a block #}
{% block content %}
    Default content
{% endblock %}

{# Override a block #}
{% block content %}
    New content
{% endblock %}

{# Append to parent block #}
{% block scripts %}
    {{ parent() }}
    <script src="additional.js"></script>
{% endblock %}

{# Check if block is defined #}
{% if block('sidebar') is defined %}
    <div class="with-sidebar">
        {% block sidebar %}{% endblock %}
    </div>
{% endif %}
```

---

## Including Partials

### Basic Include

```twig
{# resources/views/partials/nav.twig #}

<nav>
    <ul>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/about') }}">About</a></li>
        {% if auth().check() %}
            <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li><a href="{{ url('/logout') }}">Logout</a></li>
        {% else %}
            <li><a href="{{ url('/login') }}">Login</a></li>
        {% endif %}
    </ul>
</nav>
```

### Using Partials

```twig
{# Include a partial #}
{% include 'partials/nav.twig' %}

{# Include with variables #}
{% include 'partials/user_card.twig' with {'user': current_user} %}

{# Include only specific variables #}
{% include 'partials/alert.twig' with {'message': error_message} only %}

{# Conditional include #}
{% if show_sidebar %}
    {% include 'partials/sidebar.twig' %}
{% endif %}
```

### Flash Messages Partial

```twig
{# resources/views/partials/flash.twig #}

{% if session('success') %}
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
{% endif %}

{% if session('error') %}
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
{% endif %}

{% if session('warning') %}
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
{% endif %}
```

---

## Control Structures

### If Statements

```twig
{% if user %}
    <p>Welcome, {{ user.name }}!</p>
{% endif %}

{% if age >= 18 %}
    <p>You are an adult</p>
{% else %}
    <p>You are a minor</p>
{% endif %}

{% if role == 'admin' %}
    <a href="/admin">Admin Panel</a>
{% elseif role == 'moderator' %}
    <a href="/moderate">Moderate</a>
{% else %}
    <p>Regular user</p>
{% endif %}
```

### Logical Operators

```twig
{% if user and user.is_active %}
    User is active
{% endif %}

{% if is_admin or is_moderator %}
    Show admin features
{% endif %}

{% if not is_banned %}
    Welcome!
{% endif %}

{% if (age >= 18) and (country == 'US') %}
    Show US adult content
{% endif %}
```

### For Loops

```twig
{% for user in users %}
    <div class="user-card">
        <h3>{{ user.name }}</h3>
        <p>{{ user.email }}</p>
    </div>
{% endfor %}

{# Loop with else #}
{% for post in posts %}
    <article>
        <h2>{{ post.title }}</h2>
        <p>{{ post.content }}</p>
    </article>
{% else %}
    <p>No posts found.</p>
{% endfor %}

{# Loop variables #}
{% for user in users %}
    <tr class="{{ loop.index % 2 == 0 ? 'even' : 'odd' }}">
        <td>{{ loop.index }}</td>
        <td>{{ user.name }}</td>
        {% if loop.first %}<td>First!</td>{% endif %}
        {% if loop.last %}<td>Last!</td>{% endif %}
    </tr>
{% endfor %}
```

### Loop Variables

| Variable | Description |
|----------|-------------|
| `loop.index` | Current iteration (1-indexed) |
| `loop.index0` | Current iteration (0-indexed) |
| `loop.revindex` | Iterations left (1-indexed) |
| `loop.revindex0` | Iterations left (0-indexed) |
| `loop.first` | True on first iteration |
| `loop.last` | True on last iteration |
| `loop.length` | Total number of items |
| `loop.parent` | Parent context |

---

## Helper Functions

### Built-in Framework Helpers

```twig
{# URL helper #}
<a href="{{ url('/dashboard') }}">Dashboard</a>

{# Named route #}
<a href="{{ route('user.profile', {'id': user.id}) }}">Profile</a>

{# CSRF token #}
<form method="POST">
    {{ csrf_field() }}
    ...
</form>

{# CSRF token value #}
<meta name="csrf-token" content="{{ csrf_token() }}">

{# Old input (after validation error) #}
<input type="email" name="email" value="{{ old('email') }}">

{# Session data #}
<p>{{ session('success') }}</p>

{# Config value #}
<title>{{ config('app.name') }}</title>

{# Auth check #}
{% if auth().check() %}
    <p>Welcome, {{ auth().user().name }}!</p>
{% endif %}

{# Asset helper #}
<img src="{{ asset('images/logo.png') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>
```

---

## Form Handling

### Login Form Example

```twig
{# resources/views/auth/login.twig #}

{% extends 'layouts/app.twig' %}

{% block title %}Login{% endblock %}

{% block content %}
<div class="container">
    <div class="login-form">
        <h1>Login</h1>

        <form method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
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

        <p>Don't have an account? <a href="{{ url('/register') }}">Register</a></p>
    </div>
</div>
{% endblock %}
```

### Registration Form

```twig
{# resources/views/auth/register.twig #}

{% extends 'layouts/app.twig' %}

{% block title %}Register{% endblock %}

{% block content %}
<div class="container">
    <div class="register-form">
        <h1>Create Account</h1>

        <form method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
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

        <p>Already have an account? <a href="{{ url('/login') }}">Login</a></p>
    </div>
</div>
{% endblock %}
```

---

## Asset Management

### Static Assets

```twig
{# Images #}
<img src="{{ asset('images/logo.png') }}" alt="Logo">
<img src="{{ asset('images/banner.jpg') }}" alt="Banner">

{# CSS #}
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

{# JavaScript #}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/charts.js') }}"></script>

{# Fonts #}
<link rel="stylesheet" href="{{ asset('fonts/custom-font.css') }}">
```

### Versioned Assets (Cache Busting)

```twig
{# With version parameter #}
<link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ app_version }}">
<script src="{{ asset('js/app.js') }}?v={{ app_version }}"></script>

{# With file modification time #}
<script src="{{ asset('js/app.js') }}?t={{ "now"|date('U') }}"></script>
```

---

## XSS Protection

### Automatic Escaping

By default, all output is automatically escaped:

```twig
{# Automatically escaped (safe) #}
<p>{{ user.name }}</p>
<p>{{ comment.text }}</p>

{# This is SAFE - HTML entities are escaped #}
{% set malicious = '<script>alert("XSS")</script>' %}
{{ malicious }}
{# Output: &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt; #}
```

### Raw Output (Use with Caution)

```twig
{# Raw output - NO escaping #}
{{ html_content|raw }}

{# ONLY use |raw for trusted content #}
{{ article.body|raw }}  {# OK if article.body is from trusted admin #}
{{ user.bio|raw }}      {# DANGEROUS if user input! #}
```

### Escaping Filters

```twig
{# Force HTML escaping #}
{{ user_input|e }}
{{ user_input|escape }}

{# Escape for JavaScript #}
<script>
var userName = "{{ user.name|e('js') }}";
</script>

{# Escape for URL #}
<a href="/search?q={{ query|url_encode }}">Search</a>
```

---

## Template Caching

### Configuration

```php
// core/View/View.php

$this->twig = new Environment($loader, [
    'cache' => $debug ? false : $cachePath,  // Cache path or false
    'debug' => $debug,
    'auto_reload' => $debug,  // Reload on template change
]);
```

### Cache Storage

Compiled templates cached in:
```
storage/
+-- cache/
    +-- views/
        +-- 4a/
        |   +-- 4a8e5c...php
        +-- 7b/
            +-- 7b3f2d...php
```

### Clear Cache

```bash
# Clear all cache including views
php artisan cache:clear

# Manual deletion
rm -rf storage/cache/views/*
```

---

## Best Practices

### 1. Use Layouts for Consistency

```twig
{# Good - consistent structure #}
{% extends 'layouts/app.twig' %}

{% block content %}
    ...
{% endblock %}
```

### 2. Extract Reusable Components

```twig
{# Good - reusable user card #}
{% include 'partials/user_card.twig' with {'user': user} %}

{# Avoid - duplicating markup everywhere #}
```

### 3. Keep Logic Minimal

```twig
{# Good - simple display logic #}
{% if user.is_admin %}
    <a href="/admin">Admin</a>
{% endif %}

{# Bad - complex business logic in template #}
{% set total = 0 %}
{% for item in items %}
    {% set total = total + item.price * item.quantity * (1 - item.discount) %}
{% endfor %}
{# Move this to controller! #}
```

### 4. Use Descriptive Variable Names

```twig
{# Good #}
{{ user.name }}
{{ order.total_price }}
{{ product.is_available }}

{# Bad #}
{{ u.n }}
{{ o.tp }}
{{ p.avail }}
```

### 5. Never Output Raw User Input

```twig
{# Good - escaped automatically #}
{{ comment.text }}

{# Bad - XSS vulnerability! #}
{{ comment.text|raw }}
```

### 6. Use URL Helpers

```twig
{# Good - portable #}
<a href="{{ url('/users/' ~ user.id) }}">Profile</a>
<a href="{{ route('user.profile', {'id': user.id}) }}">Profile</a>

{# Bad - hardcoded #}
<a href="/so-backend-framework/users/123">Profile</a>
```

---

## Complete Example

### Full Application Layout

```twig
{# resources/views/layouts/app.twig #}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{% block title %}{{ config('app.name') }}{% endblock %}</title>

    {# CSS #}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {% block styles %}{% endblock %}
</head>
<body class="{% block body_class %}{% endblock %}">
    {# Header #}
    <header>
        <div class="container">
            <div class="logo">
                <a href="{{ url('/') }}">{{ config('app.name') }}</a>
            </div>

            {% include 'partials/nav.twig' %}
        </div>
    </header>

    {# Flash Messages #}
    {% include 'partials/flash.twig' %}

    {# Main Content #}
    <main>
        <div class="container">
            {% block content %}{% endblock %}
        </div>
    </main>

    {# Footer #}
    <footer>
        <div class="container">
            <p>&copy; {{ "now"|date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

    {# JavaScript #}
    <script src="{{ asset('js/app.js') }}"></script>
    {% block scripts %}{% endblock %}
</body>
</html>
```

---

## Summary

The SO Framework view system powered by Twig provides:

- Clean, maintainable template syntax
- Template inheritance for consistent layouts
- Automatic XSS protection
- Template caching for performance
- Built-in framework helpers
- Easy form handling
- Asset management

Twig makes building secure, performant views straightforward while keeping your templates readable and maintainable.

---

**Related Documentation:**
- [Comprehensive Guide](COMPREHENSIVE-GUIDE.md) - Complete framework reference
- [Security Layer](SECURITY-LAYER.md) - XSS prevention details
- [Authentication](AUTH-SYSTEM.md) - Auth in templates

---

**Twig Documentation**: https://twig.symfony.com/doc/3.x/

---

**Last Updated**: 2026-01-29
**Framework Version**: 2.0.0
