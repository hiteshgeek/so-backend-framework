# DEV: SOTemplate Implementation Guide

This guide provides practical examples and patterns for working with the SOTemplate engine.

## Table of Contents

- [Getting Started](#getting-started)
- [Creating Your First Template](#creating-your-first-template)
- [Building Layouts](#building-layouts)
- [Creating Components](#creating-components)
- [Working with Data](#working-with-data)
- [Forms and Validation](#forms-and-validation)
- [Building Admin Panels](#building-admin-panels)
- [Advanced Patterns](#advanced-patterns)
- [Custom Directives](#custom-directives)
- [Debugging and Troubleshooting](#debugging-and-troubleshooting)
- [Migration from PHP Templates](#migration-from-php-templates)

---

## Getting Started

### Directory Structure

```
resources/views/
├── layouts/
│   ├── app.sot.php          # Main application layout
│   ├── admin.sot.php        # Admin panel layout
│   └── auth.sot.php         # Authentication pages layout
├── components/
│   ├── alert.sot.php        # Alert component
│   ├── button.sot.php       # Button component
│   ├── card.sot.php         # Card component
│   ├── modal.sot.php        # Modal dialog
│   └── form/
│       ├── input.sot.php    # Form input
│       ├── select.sot.php   # Form select
│       └── textarea.sot.php # Form textarea
├── partials/
│   ├── header.sot.php       # Header partial
│   ├── footer.sot.php       # Footer partial
│   └── navigation.sot.php   # Navigation partial
├── auth/
│   ├── login.sot.php
│   └── register.sot.php
├── dashboard/
│   └── index.sot.php
└── users/
    ├── index.sot.php
    ├── show.sot.php
    ├── create.sot.php
    └── edit.sot.php
```

### Rendering Templates

**In Controller:**

```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class DashboardController
{
    public function index(Request $request): Response
    {
        $users = User::latest()->limit(5)->get();
        $stats = $this->getStats();

        return Response::view('dashboard.index', [
            'title' => 'Dashboard',
            'users' => $users,
            'stats' => $stats,
        ]);
    }
}
```

**Using Helper Function:**

```php
return response(view('dashboard.index', ['title' => 'Dashboard']));
```

---

## Creating Your First Template

### Simple Page

**File:** `resources/views/welcome.sot.php`

```blade
@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="container">
        <h1>Welcome to {{ config('app.name') }}</h1>

        <p>You are logged in as: {{ auth()->user()->name }}</p>

        <div class="stats">
            @foreach($stats as $stat)
                <div class="stat-card">
                    <h3>{{ $stat['label'] }}</h3>
                    <span class="value">{{ number_format($stat['value']) }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 8px; }
    </style>
@endpush
```

---

## Building Layouts

### Master Layout

**File:** `resources/views/layouts/app.sot.php`

```blade
<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ html_dir() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Default') - {{ config('app.name') }}</title>

    {{-- Base Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Page-Specific Styles --}}
    @stack('styles')
</head>
<body class="@yield('body-class', 'default')">
    {{-- Header --}}
    @include('partials.header')

    {{-- Flash Messages --}}
    @if(session()->has('success'))
        <x-alert type="success" :message="session('success')" dismissible />
    @endif

    @if(session()->has('error'))
        <x-alert type="danger" :message="session('error')" dismissible />
    @endif

    {{-- Main Content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Base Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Page-Specific Scripts --}}
    @stack('scripts')
</body>
</html>
```

### Admin Layout

**File:** `resources/views/layouts/admin.sot.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-layout">
    <div class="admin-wrapper">
        {{-- Sidebar --}}
        <aside class="sidebar">
            @include('admin.partials.sidebar')
        </aside>

        {{-- Main Content Area --}}
        <div class="main-area">
            {{-- Top Bar --}}
            <header class="top-bar">
                @include('admin.partials.topbar')
            </header>

            {{-- Page Header --}}
            <div class="page-header">
                <h1>@yield('page-title')</h1>
                <div class="page-actions">
                    @yield('page-actions')
                </div>
            </div>

            {{-- Breadcrumbs --}}
            @hasSection('breadcrumbs')
                <nav class="breadcrumbs">
                    @yield('breadcrumbs')
                </nav>
            @endif

            {{-- Content --}}
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
```

### Auth Layout (Minimal)

**File:** `resources/views/layouts/auth.sot.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-logo">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
        </div>

        <div class="auth-card">
            @yield('content')
        </div>

        <div class="auth-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
```

---

## Creating Components

### Alert Component

**File:** `resources/views/components/alert.sot.php`

```blade
@props([
    'type' => 'info',
    'message' => null,
    'dismissible' => false,
    'icon' => null
])

@php
    $icons = [
        'success' => 'check-circle',
        'danger' => 'x-circle',
        'warning' => 'alert-triangle',
        'info' => 'info'
    ];
    $iconName = $icon ?? ($icons[$type] ?? 'info');
@endphp

<div {{ $attributes->merge(['class' => "alert alert-{$type}"]) }}
     @if($dismissible) data-dismissible @endif>

    <div class="alert-icon">
        <i class="icon icon-{{ $iconName }}"></i>
    </div>

    <div class="alert-content">
        @if($message)
            {{ $message }}
        @else
            {{ $slot }}
        @endif
    </div>

    @if($dismissible)
        <button type="button" class="alert-close" aria-label="Close">
            <i class="icon icon-x"></i>
        </button>
    @endif
</div>
```

### Button Component

**File:** `resources/views/components/button.sot.php`

```blade
@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'outline' => false,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'href' => null
])

@php
    $baseClass = 'btn';
    $variantClass = $outline ? "btn-outline-{$variant}" : "btn-{$variant}";
    $sizeClass = "btn-{$size}";
    $classes = "{$baseClass} {$variantClass} {$sizeClass}";
@endphp

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $classes]) }}
       @if($disabled) aria-disabled="true" @endif>
        @if($icon && $iconPosition === 'left')
            <i class="icon icon-{{ $icon }}"></i>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')
            <i class="icon icon-{{ $icon }}"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => $classes]) }}
            @disabled($disabled || $loading)>
        @if($loading)
            <span class="spinner"></span>
        @elseif($icon && $iconPosition === 'left')
            <i class="icon icon-{{ $icon }}"></i>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right' && !$loading)
            <i class="icon icon-{{ $icon }}"></i>
        @endif
    </button>
@endif
```

### Card Component

**File:** `resources/views/components/card.sot.php`

```blade
@props([
    'title' => null,
    'subtitle' => null,
    'padding' => true,
    'shadow' => true
])

<div {{ $attributes->merge(['class' => 'card' . ($shadow ? ' shadow' : '')]) }}>
    @if($title || isset($header))
        <div class="card-header">
            @if($title)
                <h3 class="card-title">{{ $title }}</h3>
                @if($subtitle)
                    <p class="card-subtitle">{{ $subtitle }}</p>
                @endif
            @endif
            @isset($header)
                {{ $header }}
            @endisset
        </div>
    @endif

    <div class="card-body {{ $padding ? 'p-4' : 'p-0' }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
```

### Form Input Component

**File:** `resources/views/components/form/input.sot.php`

```blade
@props([
    'type' => 'text',
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'error' => null,
    'help' => null,
    'prepend' => null,
    'append' => null
])

@php
    $inputValue = old($name, $value);
    $hasError = $error || (isset($errors) && isset($errors[$name]));
    $errorMessage = $error ?? ($errors[$name] ?? null);
@endphp

<div {{ $attributes->only(['class'])->merge(['class' => 'form-group']) }}>
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="required">*</span>
            @endif
        </label>
    @endif

    <div class="input-wrapper {{ $prepend || $append ? 'input-group' : '' }}">
        @if($prepend)
            <span class="input-prepend">{{ $prepend }}</span>
        @endif

        <input type="{{ $type }}"
               name="{{ $name }}"
               id="{{ $name }}"
               value="{{ $inputValue }}"
               placeholder="{{ $placeholder }}"
               class="form-control {{ $hasError ? 'is-invalid' : '' }}"
               @required($required)
               @readonly($readonly)
               @disabled($disabled)
               {{ $attributes->except(['class']) }}>

        @if($append)
            <span class="input-append">{{ $append }}</span>
        @endif
    </div>

    @if($hasError)
        <span class="invalid-feedback">{{ $errorMessage }}</span>
    @endif

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
</div>
```

### Modal Component

**File:** `resources/views/components/modal.sot.php`

```blade
@props([
    'id',
    'title' => null,
    'size' => 'md',
    'static' => false
])

<div id="{{ $id }}"
     class="modal"
     tabindex="-1"
     @if($static) data-backdrop="static" @endif
     {{ $attributes }}>
    <div class="modal-dialog modal-{{ $size }}">
        <div class="modal-content">
            @if($title)
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="modal-close" data-dismiss="modal">
                        <i class="icon icon-x"></i>
                    </button>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
```

---

## Working with Data

### Table with Pagination

**File:** `resources/views/users/index.sot.php`

```blade
@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'User Management')

@section('page-actions')
    <x-button href="{{ route('users.create') }}" icon="plus">
        Add User
    </x-button>
@endsection

@section('content')
    <x-card>
        {{-- Filters --}}
        <form method="GET" class="filters mb-4">
            <div class="row">
                <div class="col-md-4">
                    <x-form.input name="search"
                                  placeholder="Search users..."
                                  :value="request()->get('search')" />
                </div>
                <div class="col-md-3">
                    <x-form.select name="role" :options="$roles" :value="request()->get('role')">
                        <option value="">All Roles</option>
                    </x-form.select>
                </div>
                <div class="col-md-2">
                    <x-button type="submit" icon="search">Filter</x-button>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="user-info">
                                    <img src="{{ $user->avatar_url }}" class="avatar">
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role_color }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <x-button href="{{ route('users.show', $user) }}"
                                              size="sm" variant="info" icon="eye" />
                                    <x-button href="{{ route('users.edit', $user) }}"
                                              size="sm" variant="warning" icon="edit" />
                                    <x-button type="button" size="sm" variant="danger"
                                              icon="trash" data-confirm="Delete this user?"
                                              data-action="{{ route('users.destroy', $user) }}" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted">No users found.</p>
                                <x-button href="{{ route('users.create') }}" variant="outline-primary">
                                    Create First User
                                </x-button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <x-slot:footer>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}
                        of {{ $users->total() }} results
                    </span>
                    {{ $users->links() }}
                </div>
            </x-slot:footer>
        @endif
    </x-card>
@endsection
```

### Detail View

**File:** `resources/views/users/show.sot.php`

```blade
@extends('layouts.admin')

@section('title', $user->name)
@section('page-title', 'User Details')

@section('breadcrumbs')
    <a href="{{ route('users.index') }}">Users</a>
    <span>/</span>
    <span>{{ $user->name }}</span>
@endsection

@section('page-actions')
    <x-button href="{{ route('users.edit', $user) }}" icon="edit">Edit</x-button>
    <x-button variant="danger" icon="trash"
              data-confirm="Delete {{ $user->name }}?"
              data-action="{{ route('users.destroy', $user) }}">
        Delete
    </x-button>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <x-card title="Profile">
                <div class="text-center mb-4">
                    <img src="{{ $user->avatar_url }}" class="avatar-lg rounded-circle">
                    <h4 class="mt-3">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>

                <dl class="row">
                    <dt class="col-sm-4">Role</dt>
                    <dd class="col-sm-8">
                        <span class="badge badge-{{ $user->role_color }}">
                            {{ $user->role }}
                        </span>
                    </dd>

                    <dt class="col-sm-4">Joined</dt>
                    <dd class="col-sm-8">{{ $user->created_at->format('F d, Y') }}</dd>

                    <dt class="col-sm-4">Last Login</dt>
                    <dd class="col-sm-8">
                        {{ $user->last_login_at?->diffForHumans() ?? 'Never' }}
                    </dd>
                </dl>
            </x-card>
        </div>

        <div class="col-md-8">
            <x-card title="Recent Activity">
                @forelse($user->activities->take(10) as $activity)
                    <div class="activity-item">
                        <span class="activity-time">
                            {{ $activity->created_at->diffForHumans() }}
                        </span>
                        <span class="activity-description">
                            {{ $activity->description }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted text-center py-4">No recent activity.</p>
                @endforelse
            </x-card>
        </div>
    </div>
@endsection
```

---

## Forms and Validation

### Create Form

**File:** `resources/views/users/create.sot.php`

```blade
@extends('layouts.admin')

@section('title', 'Create User')
@section('page-title', 'Create New User')

@section('content')
    <x-card>
        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <x-form.input name="name" label="Full Name" required
                                  placeholder="Enter full name" />
                </div>

                <div class="col-md-6">
                    <x-form.input type="email" name="email" label="Email Address"
                                  required placeholder="user@example.com" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-form.input type="password" name="password" label="Password"
                                  required help="Minimum 8 characters" />
                </div>

                <div class="col-md-6">
                    <x-form.input type="password" name="password_confirmation"
                                  label="Confirm Password" required />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-form.select name="role" label="Role" :options="$roles" required />
                </div>

                <div class="col-md-6">
                    <x-form.select name="department_id" label="Department"
                                   :options="$departments" required />
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <x-form.textarea name="bio" label="Bio" rows="3"
                                     placeholder="Brief description about the user" />
                </div>
            </div>

            <x-slot:footer>
                <div class="d-flex justify-content-between">
                    <x-button href="{{ route('users.index') }}" variant="secondary">
                        Cancel
                    </x-button>
                    <x-button type="submit" icon="save">
                        Create User
                    </x-button>
                </div>
            </x-slot:footer>
        </form>
    </x-card>
@endsection
```

### Edit Form with Existing Data

**File:** `resources/views/users/edit.sot.php`

```blade
@extends('layouts.admin')

@section('title', 'Edit ' . $user->name)
@section('page-title', 'Edit User')

@section('content')
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-8">
                <x-card title="User Information">
                    <x-form.input name="name" label="Full Name"
                                  :value="$user->name" required />

                    <x-form.input type="email" name="email" label="Email"
                                  :value="$user->email" required />

                    <x-form.select name="role" label="Role"
                                   :options="$roles" :value="$user->role" required />

                    <x-form.textarea name="bio" label="Bio"
                                     :value="$user->bio" rows="4" />
                </x-card>
            </div>

            <div class="col-md-4">
                <x-card title="Password">
                    <p class="text-muted small">Leave blank to keep current password.</p>

                    <x-form.input type="password" name="password"
                                  label="New Password" />

                    <x-form.input type="password" name="password_confirmation"
                                  label="Confirm Password" />
                </x-card>

                <x-card title="Settings" class="mt-4">
                    <div class="form-check">
                        <input type="checkbox" name="active" id="active" value="1"
                               class="form-check-input" @checked($user->active)>
                        <label for="active" class="form-check-label">Active</label>
                    </div>

                    <div class="form-check mt-2">
                        <input type="checkbox" name="email_verified" id="email_verified"
                               value="1" class="form-check-input"
                               @checked($user->email_verified_at)>
                        <label for="email_verified" class="form-check-label">
                            Email Verified
                        </label>
                    </div>
                </x-card>
            </div>
        </div>

        <div class="form-actions mt-4">
            <x-button type="submit" icon="save">Update User</x-button>
            <x-button href="{{ route('users.index') }}" variant="secondary">Cancel</x-button>
        </div>
    </form>
@endsection
```

---

## Building Admin Panels

### Dashboard with Stats

**File:** `resources/views/admin/dashboard.sot.php`

```blade
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Stats Cards --}}
    <div class="row mb-4">
        @foreach($stats as $stat)
            <div class="col-md-3">
                <x-card class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-{{ $stat['color'] }}">
                            <i class="icon icon-{{ $stat['icon'] }}"></i>
                        </div>
                        <div class="stat-info ms-3">
                            <h3 class="stat-value">{{ number_format($stat['value']) }}</h3>
                            <p class="stat-label">{{ $stat['label'] }}</p>
                            @if($stat['change'])
                                <span class="stat-change {{ $stat['change'] > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $stat['change'] > 0 ? '+' : '' }}{{ $stat['change'] }}%
                                </span>
                            @endif
                        </div>
                    </div>
                </x-card>
            </div>
        @endforeach
    </div>

    <div class="row">
        {{-- Recent Orders --}}
        <div class="col-md-8">
            <x-card title="Recent Orders">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ format_currency($order->total) }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status_color }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-slot:footer>
                    <a href="{{ route('orders.index') }}">View All Orders &rarr;</a>
                </x-slot:footer>
            </x-card>
        </div>

        {{-- Activity Feed --}}
        <div class="col-md-4">
            <x-card title="Activity">
                <div class="activity-feed">
                    @foreach($activities as $activity)
                        <div class="activity-item">
                            <img src="{{ $activity->causer->avatar_url }}" class="avatar-sm">
                            <div class="activity-content">
                                <strong>{{ $activity->causer->name }}</strong>
                                {{ $activity->description }}
                                <small class="text-muted d-block">
                                    {{ $activity->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/charts.js') }}"></script>
    <script>
        initDashboardCharts(@json($chartData));
    </script>
@endpush
```

---

## Advanced Patterns

### Conditional Sections

```blade
@extends('layouts.app')

@section('content')
    {{-- Only show sidebar if user has permission --}}
    @can('view-sidebar')
        @section('sidebar')
            @include('partials.sidebar')
        @endsection
    @endcan

    <div class="{{ auth()->user()->can('view-sidebar') ? 'with-sidebar' : 'full-width' }}">
        Main content
    </div>
@endsection
```

### Dynamic Components

```blade
@foreach($widgets as $widget)
    <x-dynamic-component :component="'widgets.' . $widget->type"
                         :data="$widget->data"
                         :title="$widget->title" />
@endforeach
```

### Scoped Slots

```blade
<x-data-table :items="$users">
    <x-slot:columns>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </x-slot:columns>

    <x-slot:row>
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td>
            <a href="{{ route('users.edit', $item) }}">Edit</a>
        </td>
    </x-slot:row>
</x-data-table>
```

---

## Custom Directives

### Registering Custom Directives

**File:** `config/view.php`

```php
'directives' => [
    'datetime' => function ($expression) {
        return "<?php echo date('Y-m-d H:i:s', strtotime({$expression})); ?>";
    },

    'money' => function ($expression) {
        return "<?php echo number_format({$expression}, 2); ?>";
    },

    'truncate' => function ($expression) {
        list($string, $length) = explode(',', $expression);
        return "<?php echo \\Core\\Support\\Str::limit({$string}, {$length}); ?>";
    },

    'role' => function ($expression) {
        return "<?php if(auth()->user()?->hasRole({$expression})): ?>";
    },

    'endrole' => function ($expression) {
        return "<?php endif; ?>";
    },
],
```

### Using Custom Directives

```blade
<p>Created: @datetime($user->created_at)</p>

<p>Total: $@money($order->total)</p>

<p>@truncate($post->body, 100)</p>

@role('admin')
    <a href="/admin">Admin Panel</a>
@endrole
```

---

## Debugging and Troubleshooting

### Debug Mode

Enable detailed errors in `.env`:

```env
APP_DEBUG=true
```

### View Variables

```blade
{{-- Show all available variables --}}
@if(config('app.debug'))
    <pre>{{ print_r(get_defined_vars(), true) }}</pre>
@endif

{{-- Or use helper --}}
{{ view_debug(get_defined_vars()) }}
```

### Cache Issues

```bash
# Clear compiled views
php sixorbit view:clear

# Check cache status
php sixorbit view:status
```

### Common Errors

| Error | Cause | Solution |
|-------|-------|----------|
| Template not found | Wrong path | Check `resources/views/` structure |
| Undefined variable | Missing data | Pass variable from controller |
| Syntax error | Invalid directive | Check directive syntax |
| Compilation failed | PHP error in template | Check PHP code in `@php` blocks |

---

## Migration from PHP Templates

### Before (PHP)

```php
<?php foreach ($users as $index => $user): ?>
    <li class="<?= $index % 2 === 0 ? 'even' : 'odd' ?>">
        <?= htmlspecialchars($user->name) ?>
    </li>
<?php endforeach; ?>
```

### After (SOTemplate)

```blade
@foreach($users as $user)
    <li class="{{ $loop->even ? 'even' : 'odd' }}">
        {{ $user->name }}
    </li>
@endforeach
```

### Conversion Checklist

1. Rename file from `.php` to `.sot.php`
2. Replace `<?php if()` with `@if()`
3. Replace `<?php foreach()` with `@foreach()`
4. Replace `<?= e($var) ?>` with `{{ $var }}`
5. Replace `<?= $var ?>` with `{!! $var !!}` (if intentionally raw)
6. Add `@extends()` and `@section()` for layouts
7. Convert includes to `@include()`
8. Test thoroughly

---

## See Also

- [SOTemplate Engine](sotemplate) - Complete reference
- [View Components](view-components) - Component system
- [View Templates](view-templates) - Traditional PHP templates
- [Console Commands](console-commands) - CLI tools
