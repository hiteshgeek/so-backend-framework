# RTL Layout Guide

## Overview

This guide shows how to build layouts that support Right-to-Left (RTL) languages like Arabic, Hebrew, Persian, and Urdu.

## Setting Up RTL Support

### 1. HTML Direction Attribute

Always set the `dir` attribute on the `<html>` element:

```html
<html lang="<?= app()->getLocale() ?>" dir="<?= app()->getTextDirection() ?>">
```

This automatically switches between `dir="ltr"` and `dir="rtl"` based on the current locale.

### 2. Include RTL Stylesheet

```html
<!-- app.blade.php or layout.php -->
<link rel="stylesheet" href="/assets/css/app.css">

@rtl
    <link rel="stylesheet" href="/assets/css/rtl.css">
@endrtl
```

## CSS Best Practices

### Use Logical Properties

Instead of directional properties like `left` and `right`, use logical properties that automatically flip:

```css
/* ❌ Don't use directional properties */
.element {
    margin-left: 20px;
    padding-right: 10px;
    float: left;
    text-align: left;
}

/* ✅ Use logical properties */
.element {
    margin-inline-start: 20px;
    padding-inline-end: 10px;
    float: inline-start;
    text-align: start;
}
```

### Logical Property Reference

| Instead of | Use |
|------------|-----|
| `margin-left` | `margin-inline-start` |
| `margin-right` | `margin-inline-end` |
| `padding-left` | `padding-inline-start` |
| `padding-right` | `padding-inline-end` |
| `border-left` | `border-inline-start` |
| `border-right` | `border-inline-end` |
| `left` | `inset-inline-start` |
| `right` | `inset-inline-end` |
| `text-align: left` | `text-align: start` |
| `text-align: right` | `text-align: end` |

### RTL Override Pattern

For properties that don't support logical equivalents:

```css
/* Base (LTR) */
.button {
    background-position: 10px center;
    transform: rotate(45deg);
}

/* RTL override */
[dir="rtl"] .button {
    background-position: calc(100% - 10px) center;
    transform: rotate(-45deg);
}
```

## Common Layout Patterns

### Navigation Bar

```html
<!-- LTR: Logo | Nav Items | User Menu -->
<!-- RTL: User Menu | Nav Items | Logo -->

<nav class="navbar">
    <div class="navbar-brand">Logo</div>
    <div class="navbar-nav">
        <a href="/">Home</a>
        <a href="/about">About</a>
    </div>
    <div class="navbar-user">User</div>
</nav>
```

```css
.navbar {
    display: flex;
    justify-content: space-between;
}

.navbar-brand {
    order: 1;
}

.navbar-nav {
    order: 2;
}

.navbar-user {
    order: 3;
}

/* Automatically flips in RTL */
[dir="rtl"] .navbar {
    /* Flexbox automatically reverses */
}
```

### Sidebar Layout

```html
<div class="layout">
    <aside class="sidebar">Sidebar</aside>
    <main class="content">Content</main>
</div>
```

```css
.layout {
    display: flex;
}

.sidebar {
    width: 250px;
    /* Automatically on left in LTR, right in RTL */
}

.content {
    flex: 1;
}
```

### Form Labels

```html
<div class="form-group">
    <label for="username">Username</label>
    <input type="text" id="username" />
</div>
```

```css
.form-group {
    display: flex;
    align-items: center;
}

.form-group label {
    width: 120px;
    margin-inline-end: 10px;
    /* LTR: margin-right, RTL: margin-left */
}

.form-group input {
    flex: 1;
}
```

### Icons and Arrows

Icons that indicate direction should flip in RTL:

```html
<button class="btn-next">
    Next
    <span class="icon-arrow-right"></span>
</button>
```

```css
/* Flip directional icons */
[dir="rtl"] .icon-arrow-right,
[dir="rtl"] .icon-chevron-right,
[dir="rtl"] .icon-forward {
    transform: scaleX(-1);
}

/* Don't flip non-directional icons */
.icon-search,
.icon-settings,
.icon-user {
    /* No transform needed */
}
```

## UiEngine RTL Support

All UiEngine components automatically handle RTL:

```php
use Core\UiEngine\UiEngine;

// Form automatically flips for RTL
$form = UiEngine::form()
    ->field(
        UiEngine::text('username')
            ->label('Username')
            ->placeholder('Enter username')
    )
    ->field(
        UiEngine::email('email')
            ->label('Email')
            ->placeholder('user@example.com')
    );

echo $form;
```

**LTR Output:**
```
[Label]       [Input field →]
```

**RTL Output:**
```
[← Input field]       [Label]
```

## Blade/SOTemplate Helpers

### @rtl and @ltr Directives

```php
<!-- Show content only in RTL -->
@rtl
    <link rel="stylesheet" href="/assets/css/rtl.css">
@endrtl

<!-- Show content only in LTR -->
@ltr
    <link rel="stylesheet" href="/assets/css/ltr.css">
@endltr

<!-- Conditional class -->
<div class="@rtl('text-right', 'text-left')">
    Content
</div>
```

### Helper Functions

```php
// Check if current locale is RTL
@if(is_rtl())
    <p>Current language is RTL</p>
@endif

// Get text direction
<html dir="<?= get_text_direction() ?>">

// Check specific locale
@if(locale_is_rtl('ar'))
    <p>Arabic is RTL</p>
@endif
```

## Flexbox and Grid

### Flexbox

Flexbox automatically handles RTL when using `flex-direction: row`:

```css
.container {
    display: flex;
    flex-direction: row; /* Automatically reverses in RTL */
}

/* Force LTR even in RTL mode */
.container-ltr {
    display: flex;
    flex-direction: row;
    direction: ltr; /* Override RTL */
}
```

### CSS Grid

Grid also respects RTL:

```css
.grid {
    display: grid;
    grid-template-columns: 200px 1fr 200px;
}

/* LTR: [Sidebar] [Content] [Aside] */
/* RTL: [Aside] [Content] [Sidebar] */
```

## Testing RTL Layouts

### Browser Testing

```php
// Add locale switcher to your app
<div class="locale-switcher">
    <a href="/locale/en">English</a>
    <a href="/locale/ar">العربية</a>
    <a href="/locale/he">עברית</a>
</div>
```

### DevTools Testing

Chrome/Firefox DevTools can simulate RTL:

1. Open DevTools (F12)
2. Open Rendering panel
3. Find "Emulate CSS media feature prefers-color-scheme"
4. Add `dir` attribute manually to `<html>` element

### Automated Testing

```php
// PHPUnit test
public function test_rtl_layout_loads()
{
    app()->setLocale('ar');

    $response = $this->get('/dashboard');

    $response->assertSee('dir="rtl"', false);
}
```

## Common Pitfalls

### ❌ Hardcoded Text Alignment

```css
/* Don't hardcode text alignment */
.heading {
    text-align: left; /* Won't flip */
}
```

```css
/* Use logical alignment */
.heading {
    text-align: start; /* Automatically flips */
}
```

### ❌ Absolute Positioning

```css
/* Problematic in RTL */
.element {
    position: absolute;
    left: 20px;
}
```

```css
/* Use logical properties */
.element {
    position: absolute;
    inset-inline-start: 20px;
}
```

### ❌ Background Images

```css
/* Won't flip */
.icon {
    background-image: url('arrow-right.png');
}
```

```css
/* Solution: Use CSS transform or separate images */
.icon {
    background-image: url('arrow-right.png');
}

[dir="rtl"] .icon {
    transform: scaleX(-1);
}
```

## Complete Example

**Layout Template (resources/views/layouts/app.php)**

```php
<!DOCTYPE html>
<html lang="<?= app()->getLocale() ?>" dir="<?= app()->getTextDirection() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My App' ?></title>

    <link rel="stylesheet" href="/assets/css/app.css">

    @rtl
        <link rel="stylesheet" href="/assets/css/rtl.css">
    @endrtl
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="/">MyApp</a>
        </div>
        <div class="navbar-nav">
            <a href="/"><?= trans('nav.home') ?></a>
            <a href="/about"><?= trans('nav.about') ?></a>
        </div>
        <div class="navbar-user">
            <div class="locale-switcher">
                <a href="/locale/en" class="<?= app()->getLocale() === 'en' ? 'active' : '' ?>">EN</a>
                <a href="/locale/ar" class="<?= app()->getLocale() === 'ar' ? 'active' : '' ?>">عربي</a>
            </div>
        </div>
    </nav>

    <div class="layout">
        <aside class="sidebar">
            <?= $sidebar ?? '' ?>
        </aside>
        <main class="content">
            <?= $content ?>
        </main>
    </div>
</body>
</html>
```

**CSS (public/assets/css/app.css)**

```css
.navbar {
    display: flex;
    padding: 1rem;
    background: #333;
    color: white;
}

.navbar-brand {
    margin-inline-end: auto;
}

.navbar-nav {
    display: flex;
    gap: 1rem;
}

.navbar-user {
    margin-inline-start: auto;
}

.layout {
    display: flex;
    min-height: calc(100vh - 60px);
}

.sidebar {
    width: 250px;
    background: #f5f5f5;
    padding: 1rem;
    border-inline-end: 1px solid #ddd;
}

.content {
    flex: 1;
    padding: 2rem;
}
```

**RTL Overrides (public/assets/css/rtl.css)**

```css
/* Override specific elements that need manual adjustment */

/* Flip directional icons */
[dir="rtl"] .icon-arrow-right,
[dir="rtl"] .icon-chevron-right {
    transform: scaleX(-1);
}

/* Adjust specific components */
[dir="rtl"] .breadcrumb-separator {
    transform: scaleX(-1);
}
```

## Related Documentation

- [RTL Language Support](/docs/rtl-support)
- [Internationalization](/docs/localization)
- [Translation Commands](/docs/dev-translation-commands)

## External Resources

- [MDN: CSS Logical Properties](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Logical_Properties)
- [W3C: Structural Markup and Right-to-Left Text](https://www.w3.org/International/questions/qa-html-dir)
- [Material Design: Bidirectionality](https://m2.material.io/design/usability/bidirectionality.html)
