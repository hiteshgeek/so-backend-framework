# Developer Guide: Error Reporter

Complete technical documentation for implementing, customizing, and extending the ErrorReporter component.

## Table of Contents

- [Architecture](#architecture)
- [Class Structure](#class-structure)
- [API Reference](#api-reference)
- [Events](#events)
- [Customization](#customization)
- [Advanced Usage](#advanced-usage)
- [Implementation Guide](#implementation-guide)
- [Testing](#testing)

---

## Architecture

### Component Overview

The ErrorReporter is a singleton-per-form component that manages validation error display. It integrates with ValidationEngine but can also be used standalone.

```
┌─────────────────────────────────────────────┐
│           ValidationEngine                  │
│  - Validates form data                      │
│  - Triggers validation events               │
└──────────────┬──────────────────────────────┘
               │
               │ Creates & Manages
               ▼
┌─────────────────────────────────────────────┐
│           ErrorReporter                     │
│  - Displays errors in UI                    │
│  - Handles user interactions                │
│  - Manages responsive behavior              │
└──────────────┬──────────────────────────────┘
               │
               │ Renders to
               ▼
┌─────────────────────────────────────────────┐
│              DOM                            │
│  Desktop: Floating panel or badge           │
│  Mobile: Badge + Modal                      │
└─────────────────────────────────────────────┘
```

### File Structure

```
frontend/src/js/ui-engine/validation/
├── ErrorReporter.js          # Main ErrorReporter class
├── ValidationEngine.js       # Integration point
└── Validator.js              # Validation logic

frontend/src/scss/ui-engine/
└── _error-reporter.scss      # Component styles
```

---

## Class Structure

### ErrorReporter Class

```javascript
class ErrorReporter extends EventEmitter {
    constructor(element, options = {})
    static getInstance(element)
    static destroyInstance(element)

    // Public Methods
    setErrors(errors)
    addError(field, messages)
    clearError(field)
    clearAllErrors()
    hasErrors()
    getErrorCount()
    setPosition(position)
    expand()
    collapse()
    toggle()
    destroy()

    // Events
    on(event, handler)
    off(event, handler)
    emit(event, data)
}
```

### Constructor Options

```javascript
{
    // Enable/disable the error reporter
    enabled: true,

    // Size variant: 'default' | 'sm' | 'xs'
    size: 'default',

    // Position: 'top-right' | 'top-left' | 'top-center' |
    //           'bottom-right' | 'bottom-left' | 'bottom-center'
    position: 'top-right',

    // Enable click-to-focus on error items
    showFieldLinks: true,

    // Start in collapsed state
    collapsed: false,

    // Custom CSS class
    className: '',

    // Mobile breakpoint (px)
    mobileBreakpoint: 768
}
```

---

## API Reference

### Static Methods

#### `getInstance(element)`

Get the ErrorReporter instance for a form element.

```javascript
const form = document.querySelector('#myForm');
const reporter = SixOrbit.ErrorReporter.getInstance(form);

if (reporter) {
    console.log('Error count:', reporter.getErrorCount());
}
```

**Parameters:**
- `element` (HTMLElement) - Form element

**Returns:**
- `ErrorReporter | null` - Instance or null if not found

---

#### `destroyInstance(element)`

Destroy the ErrorReporter instance for a form element.

```javascript
const form = document.querySelector('#myForm');
SixOrbit.ErrorReporter.destroyInstance(form);
```

**Parameters:**
- `element` (HTMLElement) - Form element

**Returns:**
- `void`

---

### Instance Methods

#### `setErrors(errors)`

Set all errors at once, replacing any existing errors.

```javascript
reporter.setErrors({
    email: ['This field is required', 'Invalid email format'],
    password: ['Password must be at least 8 characters'],
    age: ['Must be 18 or older']
});
```

**Parameters:**
- `errors` (Object) - Object where keys are field names and values are arrays of error messages

**Returns:**
- `this` - For method chaining

**Events:**
- Emits `shown` when errors are displayed
- Emits `cleared` when errors are removed

---

#### `addError(field, messages)`

Add error(s) to a specific field without affecting other fields.

```javascript
// Add single error
reporter.addError('username', 'Username is already taken');

// Add multiple errors
reporter.addError('password', [
    'Too short',
    'Must contain a number'
]);
```

**Parameters:**
- `field` (string) - Field name
- `messages` (string|Array<string>) - Error message(s)

**Returns:**
- `this` - For method chaining

---

#### `clearError(field)`

Remove all errors for a specific field.

```javascript
// User fixed the email field
reporter.clearError('email');
```

**Parameters:**
- `field` (string) - Field name

**Returns:**
- `this` - For method chaining

**Events:**
- Emits `cleared` if no errors remain after clearing

---

#### `clearAllErrors()`

Remove all errors from all fields.

```javascript
// Form submitted successfully
reporter.clearAllErrors();
```

**Returns:**
- `this` - For method chaining

**Events:**
- Emits `cleared`

---

#### `hasErrors()`

Check if there are any errors.

```javascript
if (reporter.hasErrors()) {
    console.log('Form has errors');
} else {
    console.log('Form is valid');
}
```

**Returns:**
- `boolean` - True if errors exist

---

#### `getErrorCount()`

Get the total number of error messages across all fields.

```javascript
const count = reporter.getErrorCount();
console.log(`${count} errors found`);
```

**Returns:**
- `number` - Total error message count

---

#### `setPosition(position)`

Change the Error Reporter position.

```javascript
reporter.setPosition('bottom-left');
```

**Parameters:**
- `position` (string) - One of: `top-right`, `top-left`, `top-center`, `bottom-right`, `bottom-left`, `bottom-center`

**Returns:**
- `this` - For method chaining

**Events:**
- Emits `position-changed` with `{ position }`

---

#### `expand()`

Expand the error reporter (show full error list).

```javascript
reporter.expand();
```

**Returns:**
- `this` - For method chaining

**Events:**
- Emits `expanded`

---

#### `collapse()`

Collapse the error reporter (show only badge with count).

```javascript
reporter.collapse();
```

**Returns:**
- `this` - For method chaining

**Events:**
- Emits `collapsed`

---

#### `toggle()`

Toggle between expanded and collapsed states.

```javascript
reporter.toggle();
```

**Returns:**
- `this` - For method chaining

---

#### `destroy()`

Destroy the ErrorReporter instance and clean up event listeners.

```javascript
reporter.destroy();
```

**Returns:**
- `void`

**Events:**
- Emits `destroyed`

---

## Events

The ErrorReporter extends EventEmitter and emits the following events:

### `shown`

Fired when errors are displayed.

```javascript
reporter.on('shown', (data) => {
    console.log('Errors shown:', data.errors);
    console.log('Total count:', data.count);
});
```

**Event Data:**
```javascript
{
    errors: Object,  // All errors
    count: number    // Total error count
}
```

---

### `cleared`

Fired when all errors are cleared.

```javascript
reporter.on('cleared', () => {
    console.log('All errors cleared');
});
```

**Event Data:** None

---

### `expanded`

Fired when error reporter is expanded.

```javascript
reporter.on('expanded', () => {
    console.log('Error reporter expanded');
});
```

**Event Data:** None

---

### `collapsed`

Fired when error reporter is collapsed.

```javascript
reporter.on('collapsed', () => {
    console.log('Error reporter collapsed');
});
```

**Event Data:** None

---

### `position-changed`

Fired when position is changed.

```javascript
reporter.on('position-changed', (data) => {
    console.log('Position changed to:', data.position);
});
```

**Event Data:**
```javascript
{
    position: string  // New position
}
```

---

### `field-focused`

Fired when a field is focused via error click.

```javascript
reporter.on('field-focused', (data) => {
    console.log('Focused field:', data.field);
});
```

**Event Data:**
```javascript
{
    field: string  // Field name
}
```

---

### `destroyed`

Fired when ErrorReporter is destroyed.

```javascript
reporter.on('destroyed', () => {
    console.log('Error reporter destroyed');
});
```

**Event Data:** None

---

## Customization

### Custom Styling

Override default styles using CSS:

```css
/* Change error reporter background */
.so-error-reporter-content {
    background: #fff3cd;
    border-color: #ffc107;
}

/* Change error text color */
.so-error-message {
    color: #856404;
}

/* Custom badge styling */
.so-error-reporter-badge-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Adjust positioning offset */
.so-error-reporter-top-right {
    top: 80px;  /* Below fixed header */
    right: 20px;
}
```

### Custom Error Templates

Extend the ErrorReporter class to customize rendering:

```javascript
class CustomErrorReporter extends SixOrbit.ErrorReporter {
    _renderErrors() {
        // Custom error list rendering
        const items = [];

        for (const [field, messages] of Object.entries(this._errors)) {
            const fieldLabel = this._getFieldLabel(field);

            messages.forEach(message => {
                items.push(`
                    <li class="custom-error-item" data-field="${field}">
                        <span class="error-icon">⚠️</span>
                        <div class="error-content">
                            <strong>${fieldLabel}</strong>
                            <p>${message}</p>
                        </div>
                    </li>
                `);
            });
        }

        return items.join('');
    }

    _getFieldLabel(field) {
        // Try to find label for field
        const input = this.element.querySelector(`[name="${field}"]`);
        const label = input?.labels?.[0];
        return label?.textContent || field;
    }
}

// Use custom reporter
SixOrbit.ValidationEngine.attachTo('#form', {
    errorReporter: {
        class: CustomErrorReporter
    }
});
```

---

## Advanced Usage

### Integration with Custom Validation

```javascript
class CustomValidator {
    constructor(form) {
        this.form = form;
        this.reporter = new SixOrbit.ErrorReporter(form, {
            position: 'top-right',
            showFieldLinks: true
        });
    }

    async validate(data) {
        const errors = {};

        // Custom validation logic
        if (!data.email) {
            errors.email = ['Email is required'];
        } else if (!this.isValidEmail(data.email)) {
            errors.email = ['Invalid email format'];
        }

        // API validation
        try {
            const response = await fetch('/api/validate', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.errors) {
                Object.assign(errors, result.errors);
            }
        } catch (err) {
            errors._form = ['Validation request failed'];
        }

        // Update error reporter
        if (Object.keys(errors).length > 0) {
            this.reporter.setErrors(errors);
            return false;
        } else {
            this.reporter.clearAllErrors();
            return true;
        }
    }

    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
}
```

### Real-time Validation with Debouncing

```javascript
const reporter = new SixOrbit.ErrorReporter(form);

// Debounce helper
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Real-time validation on input
form.querySelectorAll('input, textarea, select').forEach(input => {
    input.addEventListener('input', debounce(async (e) => {
        const field = e.target.name;
        const value = e.target.value;

        // Validate single field
        const errors = await validateField(field, value);

        if (errors && errors.length > 0) {
            reporter.addError(field, errors);
        } else {
            reporter.clearError(field);
        }
    }, 500));
});

async function validateField(field, value) {
    // Your validation logic here
    const response = await fetch(`/api/validate/${field}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ value })
    });

    const result = await response.json();
    return result.errors || [];
}
```

### Multi-step Form with Persistent Errors

```javascript
class MultiStepFormValidator {
    constructor(form, steps) {
        this.form = form;
        this.steps = steps;
        this.currentStep = 0;
        this.allErrors = {};

        this.reporter = new SixOrbit.ErrorReporter(form, {
            position: 'top-right'
        });
    }

    async validateStep(stepIndex) {
        const step = this.steps[stepIndex];
        const fields = step.querySelectorAll('[name]');
        const stepErrors = {};

        // Validate all fields in current step
        for (const field of fields) {
            const errors = await this.validateField(field);
            if (errors.length > 0) {
                stepErrors[field.name] = errors;
            }
        }

        // Update all errors
        Object.assign(this.allErrors, stepErrors);

        // Show only current step errors
        this.reporter.setErrors(stepErrors);

        return Object.keys(stepErrors).length === 0;
    }

    async nextStep() {
        const isValid = await this.validateStep(this.currentStep);

        if (isValid) {
            this.currentStep++;
            this.reporter.clearAllErrors();
            return true;
        }

        return false;
    }

    async validateField(field) {
        // Your validation logic
        return [];
    }
}
```

---

## Implementation Guide

### Creating a Standalone ErrorReporter

```javascript
// 1. Create container for error reporter
const form = document.querySelector('#myForm');

// 2. Initialize ErrorReporter
const reporter = new SixOrbit.ErrorReporter(form, {
    size: 'default',
    position: 'top-right',
    showFieldLinks: true,
    collapsed: false
});

// 3. Add errors programmatically
reporter.setErrors({
    username: ['Username is required'],
    email: ['Invalid email format'],
    password: ['Password too short']
});

// 4. Listen to events
reporter.on('shown', ({ count }) => {
    console.log(`Showing ${count} errors`);
});

reporter.on('field-focused', ({ field }) => {
    console.log(`User clicked on ${field} error`);
});

// 5. Clean up when done
reporter.destroy();
```

### Integration with ValidationEngine

ValidationEngine automatically creates and manages ErrorReporter:

```javascript
const engine = SixOrbit.ValidationEngine.attachTo('#form', {
    rules: {
        email: 'required|email',
        password: 'required|min:8'
    },
    errorReporter: {
        enabled: true,
        size: 'default',
        position: 'top-right'
    },
    onValidationFail: (errors) => {
        // ErrorReporter is automatically updated
        console.log('Validation failed:', errors);
    }
});

// Access the error reporter
const reporter = SixOrbit.ErrorReporter.getInstance(form);
```

### Custom Error Reporter Component

Create a custom component extending ErrorReporter:

```javascript
class AnimatedErrorReporter extends SixOrbit.ErrorReporter {
    constructor(element, options) {
        super(element, {
            ...options,
            className: 'animated-error-reporter'
        });
    }

    _render() {
        super._render();

        // Add custom animations
        this.element.style.animation = 'slideInRight 0.3s ease-out';
    }

    setErrors(errors) {
        // Play sound on error
        this._playErrorSound();

        return super.setErrors(errors);
    }

    clearAllErrors() {
        // Play success sound
        this._playSuccessSound();

        return super.clearAllErrors();
    }

    _playErrorSound() {
        const audio = new Audio('/assets/sounds/error.mp3');
        audio.volume = 0.3;
        audio.play();
    }

    _playSuccessSound() {
        const audio = new Audio('/assets/sounds/success.mp3');
        audio.volume = 0.3;
        audio.play();
    }
}

// Register custom component
SixOrbit.ErrorReporter = AnimatedErrorReporter;
```

---

## Testing

### Unit Tests

```javascript
describe('ErrorReporter', () => {
    let form, reporter;

    beforeEach(() => {
        form = document.createElement('form');
        document.body.appendChild(form);

        reporter = new SixOrbit.ErrorReporter(form);
    });

    afterEach(() => {
        reporter.destroy();
        document.body.removeChild(form);
    });

    it('should set errors', () => {
        reporter.setErrors({
            email: ['Required'],
            password: ['Too short']
        });

        expect(reporter.hasErrors()).toBe(true);
        expect(reporter.getErrorCount()).toBe(2);
    });

    it('should clear specific error', () => {
        reporter.setErrors({
            email: ['Required'],
            password: ['Too short']
        });

        reporter.clearError('email');

        expect(reporter.getErrorCount()).toBe(1);
    });

    it('should emit shown event', (done) => {
        reporter.on('shown', ({ count }) => {
            expect(count).toBe(2);
            done();
        });

        reporter.setErrors({
            email: ['Required'],
            password: ['Too short']
        });
    });

    it('should change position', () => {
        reporter.setPosition('bottom-left');

        expect(reporter.element.classList.contains('so-error-reporter-bottom-left')).toBe(true);
    });
});
```

### Integration Tests

```javascript
describe('ErrorReporter Integration', () => {
    it('should work with ValidationEngine', async () => {
        const form = document.createElement('form');
        form.innerHTML = `
            <input type="email" name="email" required>
            <button type="submit">Submit</button>
        `;
        document.body.appendChild(form);

        const engine = SixOrbit.ValidationEngine.attachTo(form, {
            rules: {
                email: 'required|email'
            }
        });

        // Submit form without filling
        form.dispatchEvent(new Event('submit'));

        // Wait for validation
        await new Promise(resolve => setTimeout(resolve, 100));

        const reporter = SixOrbit.ErrorReporter.getInstance(form);
        expect(reporter.hasErrors()).toBe(true);

        // Clean up
        engine.destroy();
        document.body.removeChild(form);
    });
});
```

---

## Performance Considerations

### Debouncing Updates

For real-time validation, debounce error updates:

```javascript
const debouncedSetErrors = debounce((errors) => {
    reporter.setErrors(errors);
}, 300);

input.addEventListener('input', () => {
    const errors = validateInput(input.value);
    debouncedSetErrors(errors);
});
```

### Lazy Rendering

Only render when errors exist:

```javascript
class LazyErrorReporter extends SixOrbit.ErrorReporter {
    _render() {
        if (!this.hasErrors()) {
            this._clearDisplay();
            return;
        }

        super._render();
    }
}
```

### Memory Management

Always destroy ErrorReporter when form is removed:

```javascript
// Before removing form from DOM
const reporter = SixOrbit.ErrorReporter.getInstance(form);
if (reporter) {
    reporter.destroy();
}

form.remove();
```

---

## Troubleshooting

### Common Issues

**Issue:** ErrorReporter not appearing

**Solution:**
```javascript
// Check if instance exists
const reporter = SixOrbit.ErrorReporter.getInstance(form);
console.log('Reporter:', reporter);

// Verify errors are set
console.log('Has errors:', reporter?.hasErrors());

// Check if enabled
console.log('Enabled:', reporter?._opts?.enabled);
```

**Issue:** Errors not clearing

**Solution:**
```javascript
// Ensure you're using the correct field name
reporter.clearError('email'); // Not 'Email' or 'user_email'

// Check errors object
console.log('Current errors:', reporter._errors);
```

**Issue:** Position not changing

**Solution:**
```javascript
// Force position update
reporter.setPosition('bottom-left');
reporter._render(); // Force re-render
```

---

## Related Documentation

- [Error Reporter Guide](/docs/error-reporter) - User-facing documentation
- [Validation System](/docs/validation-system) - Complete validation reference
- [Forms & Validation](/docs/dev-forms-validation) - Form validation development
- [UI Engine](/docs/ui-engine) - UI component system overview

---

**Last Updated**: 2026-02-06
**Framework Version**: 1.0
