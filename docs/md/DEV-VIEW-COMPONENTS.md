# DEV: View Components Implementation Guide

A practical guide to implementing components, composers, and advanced view features in your application.

## Table of Contents

- [Building Your First Component](#building-your-first-component)
- [Form Components](#form-components)
- [Layout Components](#layout-components)
- [Data Table Component](#data-table-component)
- [Setting Up View Composers](#setting-up-view-composers)
- [Using Loop Helper](#using-loop-helper)
- [Asset Stack Patterns](#asset-stack-patterns)
- [Error Handling](#error-handling)
- [Testing Components](#testing-components)

---

## Building Your First Component

Let's create a reusable badge component step by step.

### Step 1: Create the Component File

**File:** `resources/views/components/badge.php`

```php
<?php
/**
 * Badge Component
 *
 * A small label for status, counts, or categories.
 *
 * Props:
 *   - variant: string (primary|secondary|success|danger|warning|info), default: 'primary'
 *   - size: string (sm|md|lg), default: 'md'
 *   - pill: bool - Rounded badge, default: false
 *   - dot: bool - Show as dot indicator, default: false
 *
 * Usage:
 *   <?= component('badge', ['variant' => 'success'], 'Active') ?>
 *   <?= component('badge', ['variant' => 'danger', 'pill' => true], '5') ?>
 */

$variant = $variant ?? 'primary';
$size = $size ?? 'md';
$pill = $pill ?? false;
$dot = $dot ?? false;

// Build CSS classes
$classes = class_list([
    'badge',
    "badge-{$variant}",
    "badge-{$size}" => $size !== 'md',
    'badge-pill' => $pill,
    'badge-dot' => $dot,
]);
?>

<span class="<?= $classes ?>">
    <?php if (!$dot): ?>
        <?= $__slot ?>
    <?php endif; ?>
</span>
```

### Step 2: Use the Component

```php
<!-- In your view -->
<h1>
    Users
    <?= component('badge', ['variant' => 'info'], $userCount) ?>
</h1>

<table>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= e($user->name) ?></td>
            <td>
                <?= component('badge', [
                    'variant' => $user->is_active ? 'success' : 'danger',
                    'pill' => true
                ], $user->is_active ? 'Active' : 'Inactive') ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
```

---

## Form Components

### Complete Form Input with Validation

**File:** `resources/views/components/form/field.php`

```php
<?php
/**
 * Form Field Component
 *
 * Complete form field with label, input, help text, and error display.
 *
 * Props:
 *   - name: string (required)
 *   - type: string (text|email|password|number|textarea|select)
 *   - label: string
 *   - value: mixed
 *   - placeholder: string
 *   - required: bool
 *   - disabled: bool
 *   - error: string|null
 *   - help: string|null
 *   - options: array (for select type)
 */

$name = $name ?? '';
$type = $type ?? 'text';
$label = $label ?? null;
$value = $value ?? old($name, '');
$placeholder = $placeholder ?? '';
$required = $required ?? false;
$disabled = $disabled ?? false;
$error = $error ?? null;
$help = $help ?? null;
$options = $options ?? [];
$id = $id ?? $name;

$inputClass = class_list([
    'form-control',
    'is-invalid' => $error,
    'form-control-lg' => ($size ?? null) === 'lg',
    'form-control-sm' => ($size ?? null) === 'sm',
]);

$wrapperClass = class_list([
    'form-group',
    'mb-3',
    'has-error' => $error,
]);
?>

<div class="<?= $wrapperClass ?>">
    <?php if ($label): ?>
        <label for="<?= e($id) ?>" class="form-label">
            <?= e($label) ?>
            <?php if ($required): ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <?php if ($type === 'textarea'): ?>
        <textarea
            name="<?= e($name) ?>"
            id="<?= e($id) ?>"
            class="<?= $inputClass ?>"
            placeholder="<?= e($placeholder) ?>"
            <?= $required ? 'required' : '' ?>
            <?= $disabled ? 'disabled' : '' ?>
            rows="<?= $rows ?? 3 ?>"
        ><?= e($value) ?></textarea>

    <?php elseif ($type === 'select'): ?>
        <select
            name="<?= e($name) ?>"
            id="<?= e($id) ?>"
            class="<?= $inputClass ?>"
            <?= $required ? 'required' : '' ?>
            <?= $disabled ? 'disabled' : '' ?>
        >
            <?php if ($placeholder): ?>
                <option value=""><?= e($placeholder) ?></option>
            <?php endif; ?>
            <?php foreach ($options as $optValue => $optLabel): ?>
                <option value="<?= e($optValue) ?>" <?= selected($optValue, $value) ?>>
                    <?= e($optLabel) ?>
                </option>
            <?php endforeach; ?>
        </select>

    <?php else: ?>
        <input
            type="<?= e($type) ?>"
            name="<?= e($name) ?>"
            id="<?= e($id) ?>"
            class="<?= $inputClass ?>"
            value="<?= e($value) ?>"
            placeholder="<?= e($placeholder) ?>"
            <?= $required ? 'required' : '' ?>
            <?= $disabled ? 'disabled' : '' ?>
        >
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="invalid-feedback"><?= e($error) ?></div>
    <?php elseif ($help): ?>
        <small class="form-text text-muted"><?= e($help) ?></small>
    <?php endif; ?>
</div>
```

### Using the Form Field Component

```php
<form method="POST" action="/users">
    <?= csrf_field() ?>

    <?= component('form.field', [
        'name' => 'name',
        'label' => 'Full Name',
        'required' => true,
        'error' => $errors['name'] ?? null
    ]) ?>

    <?= component('form.field', [
        'name' => 'email',
        'type' => 'email',
        'label' => 'Email Address',
        'required' => true,
        'help' => 'We will never share your email.',
        'error' => $errors['email'] ?? null
    ]) ?>

    <?= component('form.field', [
        'name' => 'role',
        'type' => 'select',
        'label' => 'Role',
        'placeholder' => 'Select a role...',
        'options' => [
            'user' => 'User',
            'admin' => 'Administrator',
            'editor' => 'Editor'
        ],
        'error' => $errors['role'] ?? null
    ]) ?>

    <?= component('form.field', [
        'name' => 'bio',
        'type' => 'textarea',
        'label' => 'Biography',
        'placeholder' => 'Tell us about yourself...',
        'rows' => 5
    ]) ?>

    <?= component('button', ['type' => 'submit', 'variant' => 'primary'], 'Create User') ?>
</form>
```

---

## Layout Components

### Page Header Component

**File:** `resources/views/components/page-header.php`

```php
<?php
/**
 * Page Header Component
 *
 * Consistent page header with title, breadcrumbs, and actions.
 *
 * Props:
 *   - title: string (required)
 *   - subtitle: string|null
 *   - breadcrumbs: array [['label' => 'Home', 'url' => '/'], ...]
 *
 * Slots:
 *   - actions: Right-side action buttons
 */

$title = $title ?? 'Page Title';
$subtitle = $subtitle ?? null;
$breadcrumbs = $breadcrumbs ?? [];
?>

<div class="page-header">
    <?php if (!empty($breadcrumbs)): ?>
        <nav class="breadcrumb">
            <?php foreach ($breadcrumbs as $index => $crumb): ?>
                <?php if ($index > 0): ?>
                    <span class="breadcrumb-separator">/</span>
                <?php endif; ?>

                <?php if (isset($crumb['url'])): ?>
                    <a href="<?= e($crumb['url']) ?>"><?= e($crumb['label']) ?></a>
                <?php else: ?>
                    <span class="breadcrumb-current"><?= e($crumb['label']) ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>

    <div class="page-header-content">
        <div class="page-header-title">
            <h1><?= e($title) ?></h1>
            <?php if ($subtitle): ?>
                <p class="page-subtitle"><?= e($subtitle) ?></p>
            <?php endif; ?>
        </div>

        <?php if ($__slot->has('actions')): ?>
            <div class="page-header-actions">
                <?= $__slot->get('actions') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
```

### Using Page Header

```php
<?= component('page-header', [
    'title' => 'Users',
    'subtitle' => 'Manage user accounts',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => '/dashboard'],
        ['label' => 'Users']
    ]
], null, [
    'actions' => '
        <a href="/users/create" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add User
        </a>
    '
]) ?>
```

---

## Data Table Component

### Sortable Table with Pagination

**File:** `resources/views/components/data-table.php`

```php
<?php
/**
 * Data Table Component
 *
 * Sortable, paginated data table.
 *
 * Props:
 *   - columns: array [['key' => 'name', 'label' => 'Name', 'sortable' => true], ...]
 *   - data: array|Collection
 *   - sortBy: string (current sort column)
 *   - sortDir: string (asc|desc)
 *   - baseUrl: string (for sort links)
 *   - emptyMessage: string
 *
 * Slots:
 *   - row: Custom row template (receives $item and $loop)
 *   - footer: Table footer content
 */

$columns = $columns ?? [];
$data = $data ?? [];
$sortBy = $sortBy ?? null;
$sortDir = $sortDir ?? 'asc';
$baseUrl = $baseUrl ?? request()->path();
$emptyMessage = $emptyMessage ?? 'No records found.';

function sortUrl($column, $currentSort, $currentDir, $baseUrl) {
    $newDir = ($column === $currentSort && $currentDir === 'asc') ? 'desc' : 'asc';
    $params = array_merge($_GET, ['sort' => $column, 'dir' => $newDir]);
    return $baseUrl . '?' . http_build_query($params);
}

function sortIcon($column, $currentSort, $currentDir) {
    if ($column !== $currentSort) {
        return '<i class="fa fa-sort text-muted"></i>';
    }
    return $currentDir === 'asc'
        ? '<i class="fa fa-sort-up"></i>'
        : '<i class="fa fa-sort-down"></i>';
}
?>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <?php foreach ($columns as $col): ?>
                    <th>
                        <?php if ($col['sortable'] ?? false): ?>
                            <a href="<?= sortUrl($col['key'], $sortBy, $sortDir, $baseUrl) ?>"
                               class="sort-link">
                                <?= e($col['label']) ?>
                                <?= sortIcon($col['key'], $sortBy, $sortDir) ?>
                            </a>
                        <?php else: ?>
                            <?= e($col['label']) ?>
                        <?php endif; ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="<?= count($columns) ?>" class="text-center text-muted py-4">
                        <?= e($emptyMessage) ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach (loop($data) as $item => $loop): ?>
                    <?php if ($__slot->has('row')): ?>
                        <?= $__slot->get('row') ?>
                    <?php else: ?>
                        <tr>
                            <?php foreach ($columns as $col): ?>
                                <td>
                                    <?php
                                    $value = is_array($item)
                                        ? ($item[$col['key']] ?? '')
                                        : ($item->{$col['key']} ?? '');

                                    if (isset($col['format'])) {
                                        echo $col['format']($value, $item);
                                    } else {
                                        echo e($value);
                                    }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <?php if ($__slot->has('footer')): ?>
            <tfoot>
                <?= $__slot->get('footer') ?>
            </tfoot>
        <?php endif; ?>
    </table>
</div>
```

### Using the Data Table

```php
<?= component('data-table', [
    'columns' => [
        ['key' => 'id', 'label' => 'ID', 'sortable' => true],
        ['key' => 'name', 'label' => 'Name', 'sortable' => true],
        ['key' => 'email', 'label' => 'Email', 'sortable' => true],
        [
            'key' => 'created_at',
            'label' => 'Created',
            'sortable' => true,
            'format' => fn($val) => date('M j, Y', strtotime($val))
        ],
        [
            'key' => 'actions',
            'label' => 'Actions',
            'format' => fn($val, $item) => '
                <a href="/users/' . $item->id . '/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(' . $item->id . ')">Delete</button>
            '
        ]
    ],
    'data' => $users,
    'sortBy' => request()->get('sort', 'name'),
    'sortDir' => request()->get('dir', 'asc'),
    'emptyMessage' => 'No users found. Create your first user!'
]) ?>
```

---

## Setting Up View Composers

### Step 1: Create a Composer Class

**File:** `app/ViewComposers/NavigationComposer.php`

```php
<?php

namespace App\ViewComposers;

use Core\View\Contracts\ViewComposer;

class NavigationComposer implements ViewComposer
{
    public function compose(string $viewName, array $data): array
    {
        return [
            'mainNavigation' => $this->getMainNavigation(),
            'userNavigation' => $this->getUserNavigation(),
            'notifications' => $this->getNotifications(),
        ];
    }

    private function getMainNavigation(): array
    {
        $nav = [
            ['label' => 'Dashboard', 'url' => '/dashboard', 'icon' => 'fa-home'],
            ['label' => 'Users', 'url' => '/users', 'icon' => 'fa-users'],
            ['label' => 'Settings', 'url' => '/settings', 'icon' => 'fa-cog'],
        ];

        // Mark current page
        $currentPath = request()->path();
        foreach ($nav as &$item) {
            $item['active'] = str_starts_with($currentPath, ltrim($item['url'], '/'));
        }

        return $nav;
    }

    private function getUserNavigation(): array
    {
        if (!is_auth()) {
            return [];
        }

        return [
            ['label' => 'Profile', 'url' => '/profile'],
            ['label' => 'Logout', 'url' => '/logout'],
        ];
    }

    private function getNotifications(): array
    {
        if (!is_auth()) {
            return [];
        }

        return user()->unreadNotifications()->limit(5)->get()->toArray();
    }
}
```

### Step 2: Register the Composer

**File:** `app/Providers/ViewServiceProvider.php`

```php
<?php

namespace App\Providers;

use Core\Application;
use Core\Providers\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $composers = $this->app->make('view.composers');

        // Register navigation for all layout views
        $composers->composer('layouts.*', \App\ViewComposers\NavigationComposer::class);

        // Register admin-specific data
        $composers->composer('admin.**', \App\ViewComposers\AdminComposer::class);

        // Quick closure composer for specific view
        $composers->composer('dashboard.index', function ($view, $data) {
            return [
                'stats' => $this->getDashboardStats(),
                'recentActivity' => $this->getRecentActivity(),
            ];
        });
    }

    private function getDashboardStats(): array
    {
        return [
            'users' => \App\Models\User::count(),
            'orders' => \App\Models\Order::whereDate('created_at', today())->count(),
            'revenue' => \App\Models\Order::whereMonth('created_at', now()->month)->sum('total'),
        ];
    }

    private function getRecentActivity(): array
    {
        return \App\Models\Activity::latest()->limit(10)->get()->toArray();
    }
}
```

### Step 3: Add to Config

**File:** `config/app.php`

```php
'providers' => [
    // ... other providers
    App\Providers\ViewServiceProvider::class,
],
```

---

## Using Loop Helper

### Basic Iteration with Styling

```php
<ul class="item-list">
    <?php foreach (loop($items) as $item => $loop): ?>
        <li class="<?= class_list([
            'item',
            'item-first' => $loop->first,
            'item-last' => $loop->last,
            'item-even' => $loop->even,
            'item-odd' => $loop->odd,
        ]) ?>">
            <span class="item-number"><?= $loop->iteration ?></span>
            <span class="item-content"><?= e($item->name) ?></span>
            <span class="item-remaining"><?= $loop->remaining ?> more</span>
        </li>
    <?php endforeach; ?>
</ul>
```

### Progress Indicator

```php
<div class="progress-steps">
    <?php foreach (loop($steps) as $step => $loop): ?>
        <div class="step <?= $loop->iteration <= $currentStep ? 'completed' : '' ?>">
            <div class="step-indicator">
                <?= $loop->iteration ?>
            </div>
            <div class="step-label"><?= e($step->title) ?></div>

            <!-- Progress bar between steps -->
            <?php if (!$loop->last): ?>
                <div class="step-connector">
                    <div class="step-progress" style="width: <?= $loop->progress() ?>%"></div>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
```

### Nested Loops with Parent Access

```php
<div class="category-grid">
    <?php foreach (loop($categories) as $category => $catLoop): ?>
        <div class="category">
            <h3>
                <?= $catLoop->iteration ?>. <?= e($category->name) ?>
                <small>(<?= count($category->products) ?> products)</small>
            </h3>

            <div class="products">
                <?php foreach (loop($category->products) as $product => $prodLoop): ?>
                    <div class="product <?= $prodLoop->last ? 'product-last' : '' ?>">
                        <!-- Show category number and product number -->
                        <span class="product-code">
                            <?= $prodLoop->parent->iteration ?>.<?= $prodLoop->iteration ?>
                        </span>

                        <span class="product-name"><?= e($product->name) ?></span>

                        <!-- Nested depth indicator -->
                        <small class="depth-indicator">
                            Depth: <?= $prodLoop->depth ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
```

---

## Asset Stack Patterns

### Preventing Duplicate Libraries

```php
<!-- In a modal component that might be included multiple times -->
<?php push_once('scripts', '<script src="/js/modal.js"></script>', 'modal-js'); ?>
<?php push_once('styles', '<link rel="stylesheet" href="/css/modal.css">', 'modal-css'); ?>

<div class="modal">
    <!-- Modal content -->
</div>
```

### Critical CSS Pattern

```php
<!-- In layout, add critical CSS first -->
<?php prepend_stack('styles', '<style>
    body { margin: 0; font-family: system-ui; }
    .header { background: #fff; border-bottom: 1px solid #eee; }
    .main { max-width: 1200px; margin: 0 auto; padding: 20px; }
</style>'); ?>

<!-- Regular styles pushed by components -->
<?= render_stack('styles') ?>
```

### Conditional Script Loading

```php
<!-- Chart component -->
<?php if (!assets()->hasPushedOnce('chartjs')): ?>
    <?php push_once('scripts', '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>', 'chartjs'); ?>
<?php endif; ?>

<?php assets()->startPush('scripts'); ?>
<script>
    new Chart(document.getElementById('<?= $id ?>'), <?= json_encode($config) ?>);
</script>
<?php assets()->endPush(); ?>

<canvas id="<?= $id ?>"></canvas>
```

---

## Error Handling

### Graceful Component Errors

```php
<?php
// In your component, handle potential errors gracefully
try {
    $userData = fetchUserData($userId);
} catch (\Exception $e) {
    if (config('app.debug')) {
        throw $e; // Re-throw in debug mode
    }
    // In production, show fallback
    $userData = null;
}
?>

<?php if ($userData): ?>
    <div class="user-card">
        <h4><?= e($userData->name) ?></h4>
        <p><?= e($userData->email) ?></p>
    </div>
<?php else: ?>
    <div class="user-card user-card-error">
        <p>Unable to load user data</p>
    </div>
<?php endif; ?>
```

### Debug Output in Development

```php
<!-- At the end of a page during development -->
<?php if (config('app.debug')): ?>
    <div class="debug-panel">
        <h4>View Debug Info</h4>

        <h5>Current Template</h5>
        <pre><?= app('view.debugger')->currentTemplate() ?></pre>

        <h5>View Variables</h5>
        <?= view_debug(get_defined_vars()) ?>
    </div>
<?php endif; ?>
```

---

## Testing Components

### Component Rendering Test

```php
<?php

namespace Tests\Unit\Components;

use PHPUnit\Framework\TestCase;

class AlertComponentTest extends TestCase
{
    public function test_renders_success_alert()
    {
        $output = component('alert', [
            'type' => 'success',
            'title' => 'Success!'
        ], 'Operation completed.');

        $this->assertStringContainsString('alert-success', $output);
        $this->assertStringContainsString('Success!', $output);
        $this->assertStringContainsString('Operation completed.', $output);
    }

    public function test_renders_dismissible_alert()
    {
        $output = component('alert', [
            'type' => 'warning',
            'dismissible' => true
        ], 'Warning message');

        $this->assertStringContainsString('alert-dismissible', $output);
        $this->assertStringContainsString('alert-close', $output);
    }

    public function test_escapes_html_in_content()
    {
        $output = component('alert', [
            'type' => 'info'
        ], '<script>alert("xss")</script>');

        $this->assertStringNotContainsString('<script>', $output);
        $this->assertStringContainsString('&lt;script&gt;', $output);
    }
}
```

### Composer Test

```php
<?php

namespace Tests\Unit\ViewComposers;

use PHPUnit\Framework\TestCase;
use App\ViewComposers\NavigationComposer;

class NavigationComposerTest extends TestCase
{
    public function test_provides_main_navigation()
    {
        $composer = new NavigationComposer();
        $data = $composer->compose('layouts.app', []);

        $this->assertArrayHasKey('mainNavigation', $data);
        $this->assertIsArray($data['mainNavigation']);
    }

    public function test_marks_active_navigation_item()
    {
        // Mock the request path
        request()->setPath('/users');

        $composer = new NavigationComposer();
        $data = $composer->compose('layouts.app', []);

        $usersNav = collect($data['mainNavigation'])
            ->firstWhere('url', '/users');

        $this->assertTrue($usersNav['active']);
    }
}
```

---

## Best Practices Summary

1. **Component Organization**
   - Group related components in subdirectories (`form/`, `layout/`, `ui/`)
   - Use consistent naming conventions
   - Document props in PHPDoc header

2. **Props & Defaults**
   - Always provide sensible defaults
   - Validate critical props
   - Use null coalescing operator (`??`)

3. **Security**
   - Always escape output with `e()`
   - Never trust slot content blindly
   - Sanitize URLs and attributes

4. **Performance**
   - Use `push_once()` for shared assets
   - Keep components lightweight
   - Avoid database queries in components

5. **Reusability**
   - Design for flexibility with slots
   - Avoid hardcoded values
   - Support common use cases with props

---

## See Also

- [View Components Reference](view-components) - Complete component API
- [View Templates](view-templates) - Basic templating
- [Asset Management](asset-management) - CSS/JS handling
- [DEV: Helpers](dev-helpers) - Available helper functions
