# Error Reporter

A floating, interactive error display component that provides real-time validation feedback with customizable positioning and responsive mobile support.

## Overview

The Error Reporter is a UI component that displays validation errors in a non-intrusive floating panel. It automatically collects and displays errors from form validation, providing users with clear feedback about what needs to be corrected.

### Key Features

- [x] **Floating Display** - Non-blocking overlay that doesn't disrupt form layout
- [x] **6 Position Options** - Top/bottom × left/center/right positioning
- [x] **Responsive Design** - Desktop expansion, mobile modal view
- [x] **Interactive Navigation** - Click errors to focus on problem fields
- [x] **Collapse/Expand** - Minimize to badge showing error count
- [x] **Size Variants** - Default, small (SM), and extra-small (XS) sizes
- [x] **Auto-Detection** - Works seamlessly with ValidationEngine
- [x] **Real-time Updates** - Errors update as validation occurs

---

## Visual Preview

### Desktop View (Expanded)

```
┌─────────────────────────────────────┐
│ ⚠️  3 errors found    📍  ▼        │
├─────────────────────────────────────┤
│ • Email: This field is required     │
│ • Password: Minimum 8 characters    │
│ • Age: Must be at least 18          │
└─────────────────────────────────────┘
```

### Desktop View (Collapsed)

```
┌────┐
│ ⚠️ │
│ 3  │
└────┘
```

### Mobile View (Modal)

```
╔═══════════════════════════════════╗
║ Errors (3)                    ✕   ║
╠═══════════════════════════════════╣
║ • Email: This field is required   ║
║ • Password: Minimum 8 characters  ║
║ • Age: Must be at least 18        ║
╠═══════════════════════════════════╣
║ [📍 Position: Top Right    ▼]     ║
╚═══════════════════════════════════╝
```

---

## Quick Start

### Automatic Setup

The Error Reporter is **automatically initialized** when using `ValidationEngine.attachTo()` or `ValidationEngine.attachLiveValidation()`:

```html
<form id="myForm" class="so-needs-validation">
    <input type="email" name="email" class="so-form-control" required>
    <input type="password" name="password" class="so-form-control" required>
    <button type="submit">Submit</button>
</form>

<script>
// Error Reporter is automatically created and managed
SixOrbit.ValidationEngine.attachTo('#myForm');
</script>
```

That's it! The Error Reporter will automatically:
- Appear when validation errors occur
- Update in real-time as users fix errors
- Disappear when all errors are resolved

### Manual Control

For advanced use cases, you can manually control the Error Reporter:

```javascript
// Get the error reporter instance
const form = document.querySelector('#myForm');
const errorReporter = SixOrbit.ErrorReporter.getInstance(form);

// Manually add errors
errorReporter.setErrors({
    email: ['Invalid email format'],
    password: ['Password too short']
});

// Clear specific error
errorReporter.clearError('email');

// Clear all errors
errorReporter.clearAllErrors();

// Change position
errorReporter.setPosition('bottom-left');

// Expand/collapse
errorReporter.expand();
errorReporter.collapse();
```

---

## Position Options

The Error Reporter can be positioned in **6 locations** on the screen:

| Position | Description | Best For |
|----------|-------------|----------|
| `top-right` | Top right corner (default) | Most forms |
| `top-left` | Top left corner | RTL layouts |
| `top-center` | Top center | Wide forms |
| `bottom-right` | Bottom right corner | Long forms |
| `bottom-left` | Bottom left corner | Alternative placement |
| `bottom-center` | Bottom center | Modal forms |

### Changing Position

**Desktop:** Click the 📍 (position) button and select from the dropdown.

**Mobile:** Open the error modal, then use the position selector in the footer.

The position preference is saved and persists across page refreshes.

---

## Size Variants

Choose the size that fits your design:

### Default Size
```javascript
SixOrbit.ValidationEngine.attachTo('#form', {
    errorReporter: { size: 'default' }
});
```
- **Width:** 400px max
- **Use case:** Standard forms, detailed error messages

### Small (SM)
```javascript
SixOrbit.ValidationEngine.attachTo('#form', {
    errorReporter: { size: 'sm' }
});
```
- **Width:** 320px max
- **Use case:** Compact forms, sidebars

### Extra Small (XS)
```javascript
SixOrbit.ValidationEngine.attachTo('#form', {
    errorReporter: { size: 'xs' }
});
```
- **Width:** 280px max
- **Use case:** Minimal forms, tight spaces

---

## Responsive Behavior

### Desktop (≥768px)
- Full expanded panel with error list
- Position selector dropdown in header
- Toggle button to collapse/expand
- Collapsed state shows circular badge with count

### Mobile & Tablet (<768px)
- Always shows circular badge only
- Badge click opens full-screen modal
- Modal contains complete error list
- Position selector in modal footer
- Swipe or tap close button to dismiss

---

## Interactive Features

### Click to Focus Field

Click any error in the list to automatically:
1. Scroll to the problematic field
2. Focus the input element
3. Highlight the field with validation styles

```html
<!-- Clicking "Email: Invalid format" in the error list -->
<!-- will focus this field: -->
<input type="email" name="email" class="so-form-control">
```

### Real-time Error Updates

Errors update immediately as validation occurs:

```javascript
// Initial state: 3 errors
errorReporter.setErrors({
    email: ['Required'],
    password: ['Required'],
    age: ['Required']
});

// User fixes email → automatically updates to 2 errors
errorReporter.clearError('email');
```

---

## Configuration Options

When using `ValidationEngine.attachTo()`, customize the Error Reporter:

```javascript
SixOrbit.ValidationEngine.attachTo('#form', {
    errorReporter: {
        // Enable/disable error reporter
        enabled: true,

        // Size variant
        size: 'default', // 'default' | 'sm' | 'xs'

        // Initial position
        position: 'top-right', // See position options above

        // Enable field links (click to focus)
        showFieldLinks: true,

        // Start collapsed
        collapsed: false,

        // Custom class for styling
        className: 'my-custom-error-reporter'
    }
});
```

---

## Best Practices

### ✅ Do

- **Use for multi-field forms** - Most effective with 2+ fields
- **Let users click errors** - Enables quick navigation to problems
- **Choose appropriate size** - Match your form's design scale
- **Position thoughtfully** - Avoid covering important UI elements
- **Keep default settings** - Auto-initialization works for 90% of cases

### ❌ Don't

- **Don't use for single-field forms** - Inline errors are sufficient
- **Don't override all errors manually** - Let ValidationEngine handle it
- **Don't hide on mobile** - Users need error feedback on all devices
- **Don't place over submit buttons** - Choose positions that don't obstruct actions

---

## Accessibility

The Error Reporter is built with accessibility in mind:

- **ARIA Labels** - All interactive elements have descriptive labels
- **Keyboard Navigation** - Tab through errors, Enter to focus field
- **Screen Reader Support** - Error count and messages are announced
- **Focus Management** - Clicking errors properly focuses inputs
- **High Contrast** - Error colors meet WCAG AAA standards

---

## Browser Support

| Browser | Version | Support |
|---------|---------|---------|
| Chrome | 90+ | ✅ Full |
| Firefox | 88+ | ✅ Full |
| Safari | 14+ | ✅ Full |
| Edge | 90+ | ✅ Full |
| Mobile Safari | iOS 14+ | ✅ Full |
| Chrome Mobile | Android 90+ | ✅ Full |

---

## Examples

### Basic Form with Error Reporter

```html
<form id="registrationForm" class="so-needs-validation">
    <div class="so-form-group">
        <label>Email</label>
        <input type="email" name="email" class="so-form-control" required>
    </div>

    <div class="so-form-group">
        <label>Password</label>
        <input type="password" name="password" class="so-form-control" required>
    </div>

    <button type="submit" class="so-btn so-btn-primary">Register</button>
</form>

<script>
SixOrbit.ValidationEngine.attachTo('#registrationForm', {
    rules: {
        email: 'required|email',
        password: 'required|min:8'
    }
});
// Error Reporter automatically appears on validation errors!
</script>
```

### Compact Form (Small Size)

```javascript
SixOrbit.ValidationEngine.attachTo('#compactForm', {
    errorReporter: {
        size: 'sm',
        position: 'top-right',
        collapsed: true // Start minimized
    },
    rules: {
        username: 'required|alpha_num',
        email: 'required|email'
    }
});
```

### Custom Position for Long Form

```javascript
// For long forms, bottom position keeps errors visible
SixOrbit.ValidationEngine.attachTo('#longForm', {
    errorReporter: {
        position: 'bottom-right'
    }
});
```

---

## Troubleshooting

### Error Reporter Not Appearing

**Problem:** Error Reporter doesn't show when validation fails.

**Solution:**
1. Verify ValidationEngine is initialized: `SixOrbit.ValidationEngine.attachTo('#form')`
2. Check if errors are actually occurring: `console.log(validator.errors())`
3. Ensure `errorReporter.enabled` is not set to `false`

### Errors Not Updating

**Problem:** Error list doesn't update when fixing fields.

**Solution:**
- Use `clearError('fieldName')` when field is corrected
- Or let ValidationEngine handle it automatically with live validation

### Position Not Changing

**Problem:** Position dropdown doesn't change Error Reporter location.

**Solution:**
1. Hard refresh browser to clear cached JavaScript
2. Check console for JavaScript errors
3. Verify dropdown event listeners are attached

### Mobile Modal Not Opening

**Problem:** Badge click doesn't open modal on mobile.

**Solution:**
- Verify screen width is <768px (responsive breakpoint)
- Check if modal styles are loaded
- Ensure no JavaScript errors in console

---

## API Reference

See [Developer Guide - Error Reporter](/docs/dev-error-reporter) for complete API documentation, events, and advanced customization.

---

## Related Documentation

- [Forms & Validation](/docs/dev-forms-validation) - Form validation setup and rules
- [Validation System](/docs/validation-system) - Backend and frontend validation
- [UI Engine](/docs/ui-engine) - Complete UI component library
- [Developer Guide](/docs/dev-error-reporter) - Advanced ErrorReporter development

---

**Last Updated**: 2026-02-06
**Framework Version**: 1.0
