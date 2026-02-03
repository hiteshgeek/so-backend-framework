# View Components & Composers

The framework provides a powerful component system for building reusable UI elements, view composers for automatic data injection, and enhanced loop helpers for template iteration.

## Table of Contents

- [Components Overview](#components-overview)
- [Anonymous Components](#anonymous-components)
- [Class-Based Components](#class-based-components)
- [Props and Slots](#props-and-slots)
- [View Composers](#view-composers)
- [Loop Helper](#loop-helper)
- [Stack Enhancements](#stack-enhancements)
- [Template Debugging](#template-debugging)

---

## Components Overview

Components are reusable UI building blocks that encapsulate HTML, logic, and styling. The framework supports two types:

| Type | Location | Use Case |
|------|----------|----------|
| Anonymous | `resources/views/components/` | Simple UI elements |
| Class-Based | `app/Components/` | Complex logic, validation |

### Quick Example

```php
// Render an alert component
<?= $view->component('alert', ['type' => 'success'], 'Operation completed!') ?>

// Render a card with slots
<?= $view->component('card', ['title' => 'Users'], $content, [
    'footer' => '<button class="btn btn-primary">Save</button>'
]) ?>
```

---

## Anonymous Components

Anonymous components are simple PHP files in `resources/views/components/`. No class needed.

### Creating a Component

**File:** `resources/views/components/alert.php`

```php
<?php
/**
 * Alert Component
 *
 * Props:
 *   - type: string (success|warning|danger|info)
 *   - dismissible: bool
 *   - title: string|null
 */

$type = $type ?? 'info';
$dismissible = $dismissible ?? false;
$title = $title ?? null;

$classes = [
    'success' => 'alert-success',
    'warning' => 'alert-warning',
    'danger' => 'alert-danger',
    'info' => 'alert-info',
];
?>

<div class="alert <?= $classes[$type] ?? 'alert-info' ?>">
    <?php if ($title): ?>
        <strong><?= e($title) ?></strong>
    <?php endif; ?>

    <?= $__slot ?>

    <?php if ($dismissible): ?>
        <button type="button" class="alert-close">&times;</button>
    <?php endif; ?>
</div>
```

### Using the Component

```php
// Simple usage
<?= $view->component('alert', ['type' => 'success'], 'Saved successfully!') ?>

// With title
<?= $view->component('alert', [
    'type' => 'warning',
    'title' => 'Warning',
    'dismissible' => true
], 'Please review your input.') ?>

// Using helper function
<?= component('alert', ['type' => 'danger'], 'An error occurred.') ?>
```

### Nested Components

Components can be organized in subdirectories:

```
resources/views/components/
├── alert.php
├── button.php
├── card.php
└── form/
    ├── input.php
    ├── select.php
    └── textarea.php
```

```php
// Use dot notation for nested components
<?= $view->component('form.input', [
    'name' => 'email',
    'type' => 'email',
    'label' => 'Email Address',
    'required' => true
]) ?>
```

---

## Class-Based Components

For complex components with validation, computed properties, or heavy logic.

### Creating a Class Component

**File:** `app/Components/Modal.php`

```php
<?php

namespace App\Components;

use Core\View\Component;

class Modal extends Component
{
    protected string $template = 'components/modal';

    /**
     * Default prop values
     */
    public function defaults(): array
    {
        return [
            'id' => 'modal',
            'title' => '',
            'size' => 'md',
            'closable' => true,
            'backdrop' => true,
        ];
    }

    /**
     * Called after props are set
     */
    public function mount(): void
    {
        // Validate size
        $validSizes = ['sm', 'md', 'lg', 'xl'];
        if (!in_array($this->prop('size'), $validSizes)) {
            throw new \InvalidArgumentException('Invalid modal size');
        }
    }

    /**
     * Get computed modal classes
     */
    public function modalClasses(): string
    {
        return class_list([
            'modal',
            'modal-' . $this->prop('size'),
            'modal-closable' => $this->prop('closable'),
        ]);
    }
}
```

**Template:** `resources/views/components/modal.php`

```php
<div id="<?= e($id) ?>" class="<?= $component->modalClasses() ?>">
    <div class="modal-dialog">
        <div class="modal-header">
            <h5 class="modal-title"><?= e($title) ?></h5>
            <?php if ($closable): ?>
                <button type="button" class="modal-close">&times;</button>
            <?php endif; ?>
        </div>
        <div class="modal-body">
            <?= $__slot ?>
        </div>
        <?php if ($__slot->has('footer')): ?>
            <div class="modal-footer">
                <?= $__slot->get('footer') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
```

### Registering Class Components

```php
// In a service provider or bootstrap
$components = app('view.components');
$components->register('modal', \App\Components\Modal::class);

// Create an alias
$components->alias('dialog', 'modal');
```

### Using Class Components

```php
<?= $view->component('modal', [
    'id' => 'confirm-delete',
    'title' => 'Confirm Delete',
    'size' => 'sm'
], 'Are you sure you want to delete this item?', [
    'footer' => '<button class="btn btn-danger">Delete</button>'
]) ?>
```

---

## Props and Slots

### Props

Props are data passed to components:

```php
<?= $view->component('button', [
    'variant' => 'primary',    // Style variant
    'size' => 'lg',            // Size
    'disabled' => false,       // State
    'icon' => 'fa fa-save',    // Icon class
], 'Save Changes') ?>
```

Inside the component, access props as variables:

```php
<?php
// Props are extracted as variables
$variant = $variant ?? 'primary';
$size = $size ?? 'md';
$disabled = $disabled ?? false;
?>

<button class="btn btn-<?= e($variant) ?> btn-<?= e($size) ?>"
        <?= $disabled ? 'disabled' : '' ?>>
    <?= $__slot ?>
</button>
```

### Default Slot

The default slot contains the main content:

```php
// The third argument becomes $__slot
<?= $view->component('card', ['title' => 'Users'], '<p>Card body content</p>') ?>

// In the component template
<div class="card-body">
    <?= $__slot ?>  <!-- Outputs: <p>Card body content</p> -->
</div>
```

### Named Slots

Pass additional content via named slots (fourth argument):

```php
<?= $view->component('card',
    ['title' => 'Dashboard'],           // Props
    '<p>Main content here</p>',         // Default slot
    [                                    // Named slots
        'header' => '<span class="badge">New</span>',
        'footer' => '<button>Save</button>',
        'actions' => '<a href="#">Edit</a>'
    ]
) ?>
```

In the component template:

```php
<?php if ($__slot->has('header')): ?>
    <div class="card-header">
        <?= $__slot->get('header') ?>
    </div>
<?php endif; ?>

<div class="card-body">
    <?= $__slot ?>
</div>

<?php if ($__slot->has('footer')): ?>
    <div class="card-footer">
        <?= $__slot->get('footer') ?>
    </div>
<?php endif; ?>
```

### Slot Methods

| Method | Description |
|--------|-------------|
| `$__slot` | Render default slot content |
| `$__slot->has('name')` | Check if named slot exists |
| `$__slot->get('name')` | Get named slot content |
| `$__slot->hasContent()` | Check if default slot has content |
| `$__slot->isEmpty()` | Check if default slot is empty |
| `$__slot->getSlots()` | Get all named slots as array |

---

## View Composers

View composers automatically inject data into views. Perfect for navigation, user data, or shared variables.

### Registering Composers

```php
// In AppServiceProvider or bootstrap
$composers = app('view.composers');

// Closure-based composer
$composers->composer('layouts.app', function ($viewName, $data) {
    return [
        'currentUser' => auth()->user(),
        'notifications' => auth()->user()?->unreadNotifications() ?? [],
    ];
});

// Class-based composer
$composers->composer('admin.*', \App\ViewComposers\AdminComposer::class);
```

### Pattern Matching

| Pattern | Matches |
|---------|---------|
| `'dashboard.index'` | Exact view name |
| `'admin.*'` | `admin.users`, `admin.settings` (one level) |
| `'admin.**'` | `admin.users`, `admin.users.edit` (all levels) |

### Class-Based Composer

```php
<?php

namespace App\ViewComposers;

use Core\View\Contracts\ViewComposer;

class AdminComposer implements ViewComposer
{
    public function compose(string $viewName, array $data): array
    {
        return [
            'adminMenu' => $this->getAdminMenu(),
            'pendingTasks' => $this->getPendingTaskCount(),
            'systemAlerts' => $this->getSystemAlerts(),
        ];
    }

    private function getAdminMenu(): array
    {
        return config('admin.menu', []);
    }

    private function getPendingTaskCount(): int
    {
        return \App\Models\Task::where('status', 'pending')->count();
    }

    private function getSystemAlerts(): array
    {
        return \App\Models\Alert::active()->get();
    }
}
```

### Composer Priority

When multiple composers match, data is merged in order:

```php
// Both will run for 'admin.dashboard'
$composers->composer('admin.*', function ($view, $data) {
    return ['section' => 'admin'];
});

$composers->composer('admin.dashboard', function ($view, $data) {
    return ['page' => 'dashboard'];
});

// View receives: ['section' => 'admin', 'page' => 'dashboard']
```

---

## Loop Helper

The `loop()` helper provides iteration info similar to Blade's `$loop` variable.

### Basic Usage

```php
<?php foreach (loop($users) as $user => $loop): ?>
    <tr class="<?= class_list([
        'first-row' => $loop->first,
        'last-row' => $loop->last,
        'even-row' => $loop->even
    ]) ?>">
        <td><?= $loop->iteration ?></td>
        <td><?= e($user->name) ?></td>
        <td><?= e($user->email) ?></td>
    </tr>
<?php endforeach; ?>
```

### Loop Properties

| Property | Type | Description |
|----------|------|-------------|
| `$loop->index` | int | Zero-based index (0, 1, 2...) |
| `$loop->iteration` | int | One-based iteration (1, 2, 3...) |
| `$loop->first` | bool | Is first iteration? |
| `$loop->last` | bool | Is last iteration? |
| `$loop->even` | bool | Is even iteration? |
| `$loop->odd` | bool | Is odd iteration? |
| `$loop->count` | int | Total items in collection |
| `$loop->remaining` | int | Items remaining after current |
| `$loop->depth` | int | Nesting depth (1 for top level) |
| `$loop->parent` | object|null | Parent loop (for nested loops) |

### Loop Methods

| Method | Description |
|--------|-------------|
| `$loop->isFirst()` | Same as `$loop->first` |
| `$loop->isLast()` | Same as `$loop->last` |
| `$loop->passedFirst()` | Not the first iteration |
| `$loop->beforeLast()` | Not the last iteration |
| `$loop->progress()` | Completion percentage (0-100) |

### Nested Loops

```php
<?php foreach (loop($categories) as $category => $categoryLoop): ?>
    <h3><?= e($category->name) ?></h3>
    <ul>
        <?php foreach (loop($category->items) as $item => $itemLoop): ?>
            <li>
                <!-- Access parent loop -->
                Category <?= $itemLoop->parent->iteration ?>,
                Item <?= $itemLoop->iteration ?>:
                <?= e($item->name) ?>

                <!-- Depth is 2 for nested loop -->
                (Depth: <?= $itemLoop->depth ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
```

---

## Stack Enhancements

### Push Once

Prevent duplicate assets when including partials multiple times:

```php
// In a partial that might be included multiple times
<?php push_once('scripts', '<script src="/js/chart.js"></script>', 'chartjs'); ?>

// Or with capture syntax
<?php assets()->startPushOnce('styles', 'tooltip-css'); ?>
<style>
    .tooltip { /* ... */ }
</style>
<?php assets()->endPushOnce(); ?>
```

### Prepend to Stack

Add content at the beginning of a stack:

```php
// Add critical CSS first
<?php prepend_stack('styles', '<style>:root { --primary: #007bff; }</style>'); ?>

// Or with capture syntax
<?php assets()->startPrepend('styles'); ?>
<style>
    /* Critical above-the-fold CSS */
    body { margin: 0; }
</style>
<?php assets()->endPrepend(); ?>
```

---

## Template Debugging

### View Debug Helper

Display view variables in debug mode:

```php
<!-- Only visible when APP_DEBUG=true -->
<?= view_debug(get_defined_vars()) ?>
```

This outputs a formatted dump of all view variables.

### Template Error Handling

When an error occurs in a template, the framework provides detailed information:

```
View Error: Undefined variable: userName

Template: dashboard.index
File: /resources/views/dashboard/index.php
Line: 42

  40 |     Hello,
  41 |     <?php // error here ?>
> 42 |     <?= e($userName) ?>
  43 | </p>

View Variables:
$title: "Dashboard"
$user: App\Models\User
```

### Programmatic Debugging

```php
// Get the current template being rendered
$template = app('view.debugger')->currentTemplate();

// Check if we're in a specific template
if (str_contains($template, 'admin')) {
    // Admin-specific debugging
}
```

---

## Built-in Components

The framework includes several ready-to-use components:

### Alert Component

```php
<?= component('alert', [
    'type' => 'success',      // success|warning|danger|info
    'dismissible' => true,
    'title' => 'Success!',
    'icon' => 'fa fa-check'
], 'Your changes have been saved.') ?>
```

### Button Component

```php
<?= component('button', [
    'variant' => 'primary',   // primary|secondary|success|danger|warning|info
    'size' => 'lg',           // sm|md|lg
    'outline' => false,
    'disabled' => false,
    'loading' => false,
    'icon' => 'fa fa-save',
    'href' => '/submit'       // Renders as <a> if set
], 'Save Changes') ?>
```

### Card Component

```php
<?= component('card', [
    'title' => 'User Profile',
    'subtitle' => 'Manage your account',
    'shadow' => true,
    'bordered' => true,
    'padding' => true
], $content, [
    'header' => '<span class="badge">Pro</span>',
    'footer' => '<button class="btn">Save</button>',
    'actions' => '<a href="#">Edit</a>'
]) ?>
```

### Form Input Component

```php
<?= component('form.input', [
    'name' => 'email',
    'type' => 'email',
    'label' => 'Email Address',
    'value' => old('email'),
    'placeholder' => 'Enter your email',
    'required' => true,
    'error' => $errors['email'] ?? null,
    'help' => 'We will never share your email.'
]) ?>
```

---

## Helper Functions Reference

| Function | Description |
|----------|-------------|
| `component($name, $props, $slot, $slots)` | Render a component |
| `loop($items)` | Create loop iterator with `$loop` variable |
| `class_list($classes)` | Build conditional CSS classes |
| `push_once($stack, $content, $key)` | Push to stack once |
| `prepend_stack($stack, $content)` | Prepend to stack |
| `view_debug($vars)` | Dump variables in debug mode |
| `selected($value, $current)` | Return 'selected' if match |
| `checked($value)` | Return 'checked' if truthy |
| `disabled($value)` | Return 'disabled' if truthy |
| `readonly($value)` | Return 'readonly' if truthy |
| `required($value)` | Return 'required' if truthy |

---

## Best Practices

1. **Keep components focused** - One component, one purpose
2. **Document props** - Add PHPDoc comments at the top of component files
3. **Use semantic names** - `form.input` not `input-form-field`
4. **Escape output** - Always use `e()` for user data
5. **Set sensible defaults** - Components should work with minimal props
6. **Use slots for flexibility** - Don't hardcode content that might vary
7. **Leverage composers** - Avoid repeating data fetching across views

---

## See Also

- [View Templates](view-templates) - Basic templating features
- [Asset Management](asset-management) - CSS/JS handling
- [DEV: View Components Guide](dev-view-components) - Implementation examples
