# SOTemplate Engine

SOTemplate is the framework's high-performance template engine with Blade-like syntax. It provides template compilation, caching, and all modern template features for building enterprise applications.

## Table of Contents

- [Overview](#overview)
- [Template Syntax](#template-syntax)
- [Echo Statements](#echo-statements)
- [Control Structures](#control-structures)
- [Loops](#loops)
- [Layout & Inheritance](#layout--inheritance)
- [Components](#components)
- [Stacks](#stacks)
- [Forms](#forms)
- [Authentication Directives](#authentication-directives)
- [Other Directives](#other-directives)
- [CLI Commands](#cli-commands)
- [Configuration](#configuration)
- [Performance](#performance)

---

## Overview

SOTemplate compiles templates to optimized PHP code, cached for subsequent requests. This provides 3-5x performance improvement over interpreted templates.

### Key Features

| Feature | Description |
|---------|-------------|
| **Template Compilation** | Templates compiled to optimized PHP |
| **Automatic Caching** | Compiled templates cached to disk |
| **Auto-Reload** | Development mode recompiles on change |
| **Blade-Like Syntax** | Familiar `@if`, `@foreach`, `{{ }}` syntax |
| **Component Tags** | `<x-component>` syntax with slots |
| **$attributes Bag** | Forward HTML attributes to components |
| **$loop Variable** | Iteration info in loops |
| **IDE Support** | VS Code syntax highlighting |

### File Extension

SOTemplate files use the `.sot.php` extension:

```
resources/views/
├── layouts/
│   └── app.sot.php
├── components/
│   ├── alert.sot.php
│   └── button.sot.php
├── dashboard/
│   └── index.sot.php
└── welcome.sot.php
```

### Quick Example

**File:** `resources/views/welcome.sot.php`

```blade
@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <h1>{{ $title }}</h1>

    @if($users->count() > 0)
        <ul>
            @foreach($users as $user)
                <li class="{{ $loop->even ? 'even' : 'odd' }}">
                    {{ $loop->iteration }}. {{ $user->name }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No users found.</p>
    @endif

    <x-alert type="success" message="Welcome to the app!" />
@endsection
```

---

## Template Syntax

### Comments

```blade
{{-- This is a comment - not rendered in HTML output --}}

{{--
    Multi-line comments
    are also supported
--}}
```

### Escaping Blade Syntax

To output literal blade syntax, use `@`:

```blade
@{{ This will not be processed }}

@@if  {{-- Outputs: @if --}}
```

---

## Echo Statements

### Escaped Output (XSS Safe)

Double curly braces escape HTML entities:

```blade
{{ $variable }}
{{ $user->name }}
{{ config('app.name') }}
{{ $items['key'] ?? 'default' }}
```

**Output:** `<script>` becomes `&lt;script&gt;`

### Raw Output (Unescaped)

For trusted HTML content:

```blade
{!! $htmlContent !!}
{!! $user->bio !!}
{!! markdown($post->body) !!}
```

**Warning:** Only use `{!! !!}` with trusted data to prevent XSS attacks.

### Ternary Expressions

```blade
{{ $isAdmin ? 'Administrator' : 'User' }}
{{ $name ?? 'Guest' }}
{{ $user?->profile?->avatar ?? '/images/default.png' }}
```

---

## Control Structures

### If Statements

```blade
@if($condition)
    Condition is true
@endif

@if($user->isAdmin())
    Admin content
@elseif($user->isModerator())
    Moderator content
@else
    Regular user content
@endif
```

### Unless (Inverse If)

```blade
@unless($user->isVerified())
    <p>Please verify your email.</p>
@endunless
```

### Isset and Empty

```blade
@isset($variable)
    Variable is defined and not null
@endisset

@empty($collection)
    Collection is empty
@endempty
```

### Switch Statements

```blade
@switch($role)
    @case('admin')
        <span class="badge badge-danger">Admin</span>
        @break

    @case('editor')
        <span class="badge badge-warning">Editor</span>
        @break

    @default
        <span class="badge badge-secondary">User</span>
@endswitch
```

---

## Loops

### Foreach Loop

```blade
@foreach($users as $user)
    <p>{{ $user->name }}</p>
@endforeach

@foreach($items as $key => $value)
    <p>{{ $key }}: {{ $value }}</p>
@endforeach
```

### Forelse (With Empty State)

```blade
@forelse($posts as $post)
    <article>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->excerpt }}</p>
    </article>
@empty
    <p>No posts have been published yet.</p>
@endforelse
```

### For Loop

```blade
@for($i = 0; $i < 10; $i++)
    <p>Item {{ $i }}</p>
@endfor
```

### While Loop

```blade
@while($condition)
    <p>Processing...</p>
@endwhile
```

### The $loop Variable

Inside any loop, access iteration info via `$loop`:

```blade
@foreach($users as $user)
    @if($loop->first)
        <p class="first">First user</p>
    @endif

    <div class="{{ $loop->even ? 'bg-gray' : 'bg-white' }}">
        {{ $loop->iteration }}. {{ $user->name }}
        ({{ $loop->remaining }} remaining)
    </div>

    @if($loop->last)
        <p class="last">Last user</p>
    @endif
@endforeach
```

#### $loop Properties

| Property | Type | Description |
|----------|------|-------------|
| `$loop->index` | int | Zero-based index (0, 1, 2...) |
| `$loop->iteration` | int | One-based count (1, 2, 3...) |
| `$loop->first` | bool | First iteration? |
| `$loop->last` | bool | Last iteration? |
| `$loop->even` | bool | Even iteration? |
| `$loop->odd` | bool | Odd iteration? |
| `$loop->count` | int | Total items |
| `$loop->remaining` | int | Items remaining |
| `$loop->depth` | int | Nesting level (1, 2...) |
| `$loop->parent` | object | Parent loop reference |

### Nested Loops

```blade
@foreach($categories as $category)
    <h3>{{ $category->name }}</h3>

    @foreach($category->products as $product)
        <p>
            Category {{ $loop->parent->iteration }},
            Product {{ $loop->iteration }}:
            {{ $product->name }}
        </p>
    @endforeach
@endforeach
```

---

## Layout & Inheritance

### Defining a Layout

**File:** `resources/views/layouts/app.sot.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Default Title') - {{ config('app.name') }}</title>
    @stack('styles')
</head>
<body>
    <nav>
        @include('partials.navigation')
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('partials.footer')
    </footer>

    @stack('scripts')
</body>
</html>
```

### Extending a Layout

```blade
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Welcome to your Dashboard</h1>
    <p>Content goes here...</p>
@endsection

@push('scripts')
    <script src="/js/dashboard.js"></script>
@endpush
```

### Section with Show

Render a section immediately while allowing extension:

```blade
@section('sidebar')
    <p>Default sidebar content</p>
@show
```

### Parent Content

Append to parent section content:

```blade
@section('sidebar')
    @parent
    <p>Additional sidebar content</p>
@endsection
```

### Including Partials

```blade
{{-- Simple include --}}
@include('partials.header')

{{-- Include with data --}}
@include('partials.user-card', ['user' => $user])

{{-- Include if exists --}}
@includeIf('partials.optional')

{{-- Include when condition is true --}}
@includeWhen($showSidebar, 'partials.sidebar')

{{-- Include first existing template --}}
@includeFirst(['custom.header', 'default.header'])
```

---

## Components

### Component Tag Syntax

SOTemplate supports Blade-like component tags:

```blade
{{-- Self-closing component --}}
<x-alert type="success" message="Saved!" />

{{-- Component with slot --}}
<x-card title="Users">
    <p>Card content here</p>
</x-card>

{{-- Component with named slots --}}
<x-modal title="Confirm">
    <p>Are you sure?</p>

    <x-slot:footer>
        <button class="btn btn-danger">Delete</button>
        <button class="btn btn-secondary">Cancel</button>
    </x-slot:footer>
</x-modal>
```

### Props

Pass data to components:

```blade
{{-- Static prop --}}
<x-button type="submit">Save</x-button>

{{-- Dynamic prop (PHP expression) --}}
<x-alert :type="$alertType" :message="$message" />

{{-- Boolean props --}}
<x-input name="email" required disabled />
```

### The $attributes Bag

Components receive an `$attributes` bag for forwarding extra HTML attributes:

**Component:** `resources/views/components/button.sot.php`

```blade
@props(['type' => 'button', 'variant' => 'primary'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-' . $variant]) }}>
    {{ $slot }}
</button>
```

**Usage:**

```blade
<x-button type="submit" class="btn-lg" id="save-btn" wire:click="save">
    Save Changes
</x-button>
```

**Output:**

```html
<button type="submit" class="btn btn-primary btn-lg" id="save-btn" wire:click="save">
    Save Changes
</button>
```

### $attributes Methods

| Method | Description |
|--------|-------------|
| `$attributes->merge(['class' => 'default'])` | Merge with defaults |
| `$attributes->class(['btn', 'active' => $isActive])` | Conditional classes |
| `$attributes->except(['type', 'size'])` | Exclude attributes |
| `$attributes->only(['id', 'class'])` | Include only |
| `$attributes->whereStartsWith('wire:')` | Filter by prefix |
| `$attributes->first('href', 'data-url')` | Get first matching |

### Dynamic Components

```blade
<x-dynamic-component :component="$componentName" :$data />
```

### Directive Syntax

Traditional directive syntax also works:

```blade
@component('alert', ['type' => 'success'])
    @slot('title')
        Success!
    @endslot

    Your changes have been saved.
@endcomponent
```

---

## Stacks

Stacks allow pushing content from child views to the layout.

### Defining Stacks in Layout

```blade
<head>
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
```

### Pushing to Stacks

```blade
@push('scripts')
    <script src="/js/chart.js"></script>
@endpush

{{-- Prepend (add to beginning) --}}
@prepend('styles')
    <style>/* Critical CSS */</style>
@endprepend
```

### Push Once (Prevent Duplicates)

```blade
@pushOnce('scripts')
    <script src="/js/tooltip.js"></script>
@endPushOnce
```

---

## Forms

### CSRF Protection

```blade
<form method="POST" action="/users">
    @csrf
    <!-- form fields -->
</form>
```

### Method Spoofing

```blade
<form method="POST" action="/users/1">
    @csrf
    @method('PUT')
    <!-- form fields -->
</form>
```

### Error Handling

```blade
<input type="text" name="email" value="{{ old('email') }}">

@error('email')
    <span class="error">{{ $message }}</span>
@enderror
```

### Form Attribute Helpers

```blade
<select name="role">
    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
    <option value="user" @selected(old('role') === 'user')>User</option>
</select>

<input type="checkbox" name="active" @checked(old('active', $user->active))>

<input type="text" name="title" @readonly($user->isLocked())>

<input type="email" name="email" @disabled(!$canEdit)>

<input type="text" name="name" @required($isRequired)>
```

### Conditional Classes

```blade
<button @class([
    'btn',
    'btn-primary' => $isPrimary,
    'btn-secondary' => !$isPrimary,
    'btn-lg' => $size === 'large',
    'disabled' => $isDisabled,
])>
    Submit
</button>
```

---

## Authentication Directives

### @auth and @guest

```blade
@auth
    <p>Welcome back, {{ auth()->user()->name }}!</p>
    <a href="/logout">Logout</a>
@endauth

@guest
    <a href="/login">Login</a>
    <a href="/register">Register</a>
@endguest
```

### @can and @cannot

```blade
@can('edit', $post)
    <a href="/posts/{{ $post->id }}/edit">Edit</a>
@endcan

@cannot('delete', $post)
    <p>You do not have permission to delete this post.</p>
@endcannot
```

---

## Other Directives

### Raw PHP

```blade
@php
    $counter = 0;
    $total = $items->sum('price');
@endphp

<p>Total: {{ number_format($total, 2) }}</p>
```

### JSON Output

```blade
<script>
    var config = @json($config);
    var users = @json($users, JSON_PRETTY_PRINT);
</script>
```

### Verbatim (No Processing)

For JavaScript frameworks that use `{{ }}`:

```blade
@verbatim
    <div id="vue-app">
        {{ message }}
    </div>
@endverbatim
```

### Once (Render Once Per Request)

```blade
@once
    <script src="/js/library.js"></script>
@endonce
```

---

## CLI Commands

### Clear Compiled Views

```bash
php sixorbit view:clear
php sixorbit view:clear --verbose
```

### Pre-compile All Views

```bash
php sixorbit view:cache
php sixorbit view:cache --force  # Clear first, then compile
php sixorbit view:cache --verbose
```

### View Cache Status

```bash
php sixorbit view:status
php sixorbit view:status --verbose
```

**Example Output:**

```
SOTemplate Configuration:
  View path: /var/www/html/resources/views
  Cache path: /var/www/html/storage/views/compiled
  Extension: .sot.php
  Auto-reload: enabled

Templates:
  SOTemplate files (.sot.php): 45
  PHP files (.php): 23

Cache Statistics:
  Compiled files: 38
  Total size: 156.7 KB
  Oldest: 2024-01-15 10:30:00
  Newest: 2024-01-20 14:45:22
```

---

## Configuration

**File:** `config/view.php`

```php
return [
    // Template paths
    'paths' => [
        resource_path('views'),
    ],

    // Compiled template cache
    'compiled' => storage_path('views/compiled'),

    // Auto-recompile when source changes (disable in production)
    'auto_reload' => env('APP_DEBUG', false),

    // File extension for SOTemplate files
    'extension' => '.sot.php',

    // Component configuration
    'components' => [
        'namespace' => 'App\\Components',
        'paths' => [
            resource_path('views/components'),
        ],
    ],

    // Custom directives
    'directives' => [
        'datetime' => function ($expression) {
            return "<?php echo date('Y-m-d H:i:s', strtotime($expression)); ?>";
        },
    ],
];
```

---

## Performance

### Compilation Flow

```
Template Request
      ↓
Check if compiled exists
      ↓
   ┌──┴──┐
  Yes    No
   ↓      ↓
Check  Compile
mtime  template
   ↓      ↓
Changed? Save to
   ↓   cache
  Yes    ↓
   ↓   Include
Recompile compiled
   ↓
Include
compiled
```

### Best Practices

1. **Production:** Disable `auto_reload` for best performance
2. **Deployment:** Run `php sixorbit view:cache` to pre-compile all views
3. **OPcache:** Ensure PHP OPcache is enabled for compiled templates
4. **Clear on Deploy:** Run `php sixorbit view:clear` before `view:cache`

### Performance Comparison

| Method | First Request | Subsequent |
|--------|---------------|------------|
| Plain PHP | ~1x | ~1x |
| SOTemplate (cold) | ~1.2x | ~0.3x |
| SOTemplate (warm) | ~0.3x | ~0.3x |

Compiled templates run 3-5x faster than interpreted templates.

---

## IDE Support

### VS Code Configuration

The framework includes VS Code configuration for `.sot.php` files:

**File:** `.vscode/settings.json`

```json
{
    "files.associations": {
        "*.sot.php": "blade"
    },
    "emmet.includeLanguages": {
        "blade": "html"
    }
}
```

### Recommended Extensions

Install from `.vscode/extensions.json`:

- Laravel Blade Snippets
- Laravel Blade Formatter
- PHP Intelephense

---

## See Also

- [DEV: SOTemplate Implementation Guide](dev-sotemplate) - Practical examples
- [View Components](view-components) - Component system details
- [View Templates](view-templates) - Traditional PHP templates
- [Asset Management](asset-management) - CSS/JS handling
