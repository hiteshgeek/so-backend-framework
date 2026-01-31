# Build Your First Page

**A step-by-step tutorial for creating a new page in the SO Backend Framework.**

This guide walks you through building a complete "Contact Us" page from scratch. By the end, you will have a working route, controller, view, and styled assets -- the same pattern used by every page in the framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Step 1: Define a Route](#step-1-define-a-route)
3. [Step 2: Create a Controller](#step-2-create-a-controller)
4. [Step 3: Create the View](#step-3-create-the-view)
5. [Step 4: Create CSS & JS Assets](#step-4-create-css--js-assets)
6. [Step 5: Test It](#step-5-test-it)
7. [Summary](#summary)

---

## Overview

You are going to build a **Contact Us** page that:

- Lives at the URL `/contact`
- Has its own route file, controller, and view
- Uses the framework's asset management system for CSS and JS
- Includes a contact form with name, email, and message fields
- Follows the exact same conventions as the existing dashboard, auth, and docs pages

### Architecture at a Glance

```
Request: GET /contact
    -> routes/web/contact.php      (route definition)
    -> ContactController::show()   (controller method)
    -> resources/views/contact/index.php  (view template)
    -> public/assets/css/contact/contact.css  (page styles)
    -> public/assets/js/contact/contact.js    (page scripts)
```

---

## Step 1: Define a Route

Routes are organized into module files inside `routes/web/`. Each module gets its own file, and all module files are loaded by `routes/web.php`.

### 1a. Create the route file

Create the file `routes/web/contact.php`:

```php
<?php

/**
 * Contact Routes
 *
 * Public contact page
 */

use Core\Routing\Router;
use App\Controllers\ContactController;
use App\Middleware\CsrfMiddleware;

// Display the contact form
Router::get('/contact', [ContactController::class, 'show'])->name('contact');

// Handle form submission (with CSRF protection)
Router::group(['middleware' => [CsrfMiddleware::class]], function () {
    Router::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
});
```

**What this does:**

- `Router::get('/contact', ...)` maps `GET /contact` to the controller's `show` method.
- `Router::post('/contact', ...)` maps `POST /contact` to the `submit` method, wrapped in CSRF middleware so the form is protected against cross-site request forgery.
- `->name('contact')` gives the route a name you can reference with `route('contact')`.

### 1b. Register the route file

Open `routes/web.php` and add a `require` line for your new module. Place it in the section marked for additional routes:

```php
// ==========================================
// Load Route Modules
// ==========================================

// Authentication routes (login, register, password reset)
require __DIR__ . '/web/auth.php';

// Dashboard routes (protected admin area)
require __DIR__ . '/web/dashboard.php';

// Documentation routes
require __DIR__ . '/web/docs.php';

// ==========================================
// Add more route modules here:
// ==========================================
require __DIR__ . '/web/contact.php';       // <-- ADD THIS LINE
```

---

## Step 2: Create a Controller

Controllers live in `app/Controllers/`. Each controller is a plain PHP class in the `App\Controllers` namespace.

Create the file `app/Controllers/ContactController.php`:

```php
<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * Contact Controller
 *
 * Handles displaying and processing the Contact Us form
 */
class ContactController
{
    /**
     * Show the contact form
     */
    public function show(Request $request): Response
    {
        return Response::view('contact/index', [
            'title'   => 'Contact Us - ' . config('app.name'),
            'success' => session('success'),
            'errors'  => session('errors', []),
            'old'     => session('_old_input', []),
        ]);
    }

    /**
     * Process the contact form submission
     */
    public function submit(Request $request): Response
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:2|max:255',
            'email'   => 'required|email',
            'message' => 'required|min:10|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect(url('/contact'))
                ->withErrors($validator->errors())
                ->withInput($request->all());
        }

        // ---------------------------------------------------------
        // Process the message here.
        // For example: save to database, send an email, log it, etc.
        //
        //   Mail::send('contact@example.com', $request->input('message'));
        //   ContactMessage::create($request->only(['name', 'email', 'message']));
        //
        // ---------------------------------------------------------

        return redirect(url('/contact'))
            ->with('success', 'Thank you! Your message has been sent.');
    }
}
```

**Key patterns used here:**

| Pattern | Purpose |
|---------|---------|
| `Response::view('contact/index', [...])` | Renders `resources/views/contact/index.php` and passes data to it |
| `session('errors', [])` | Retrieves flashed validation errors (empty array as default) |
| `session('_old_input', [])` | Retrieves old form input so fields can be repopulated on error |
| `redirect(url('/contact'))->withErrors(...)` | Redirects back with errors and old input flashed to the session |
| `redirect(url('/contact'))->with('success', ...)` | Redirects back with a success flash message |

---

## Step 3: Create the View

Views are PHP files in `resources/views/`. The controller call `Response::view('contact/index', ...)` maps to the file `resources/views/contact/index.php`.

Create the file `resources/views/contact/index.php`:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= htmlspecialchars($title ?? 'Contact Us') ?></title>
    <?php
    // -------------------------------------------------------
    // Register assets (order matters by priority, not by line)
    // -------------------------------------------------------

    // Priority 5: CDN dependencies (fonts, icons) load first
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', 'css', 'head', 5);

    // Priority 8: Shared base stylesheet (variables, reset, dark mode)
    assets()->css('css/base.css', 'head', 8);

    // Priority 10: Page-specific CSS
    assets()->css('css/contact/contact.css', 'head', 10);

    // Priority 10: Page-specific JS (loads before </body>)
    assets()->js('js/contact/contact.js', 'body_end', 10);

    // Theme toggle script
    assets()->js('js/theme.js', 'body_end', 10);
    ?>
    <script>
        (function(){
            var t = localStorage.getItem("theme");
            if (!t && window.matchMedia("(prefers-color-scheme:dark)").matches) t = "dark";
            if (t) document.documentElement.setAttribute("data-theme", t);
        })()
    </script>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="contact-container">
        <h1>Contact Us</h1>
        <p class="contact-subtitle">Have a question or feedback? Send us a message.</p>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= url('/contact') ?>" id="contactForm">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Your Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= e(old('name', '')) ?>"
                    required
                    autofocus
                >
                <?php if (isset($errors['name'])): ?>
                    <div class="error"><?= e($errors['name'][0]) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= e(old('email', '')) ?>"
                    required
                >
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?= e($errors['email'][0]) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea
                    id="message"
                    name="message"
                    rows="6"
                    required
                ><?= e(old('message', '')) ?></textarea>
                <?php if (isset($errors['message'])): ?>
                    <div class="error"><?= e($errors['message'][0]) ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn">Send Message</button>
        </form>

        <div class="links">
            <a href="<?= url('/') ?>">Back to Home</a>
        </div>
    </div>

    <?= render_assets('body_end') ?>
</body>
</html>
```

### How the Asset Pipeline Works in This View

The view registers assets **before** calling `render_assets()`. Here is the loading order:

```
render_assets('head') outputs (sorted by priority):
  1. Google Fonts CSS        (priority 5 - CDN)
  2. css/base.css            (priority 8 - shared styles)
  3. css/contact/contact.css (priority 10 - page styles)

render_assets('body_end') outputs (sorted by priority):
  1. js/contact/contact.js   (priority 10 - page scripts)
  2. js/theme.js             (priority 10 - theme toggle)
```

### Template Conventions

| Convention | Example | Purpose |
|-----------|---------|---------|
| Escape output | `<?= e($success) ?>` or `<?= htmlspecialchars($title) ?>` | Prevent XSS attacks |
| CSRF token | `<?= csrf_field() ?>` | Hidden input with the CSRF token for form protection |
| Old input | `<?= e(old('name', '')) ?>` | Repopulate form fields after validation failure |
| URL helper | `<?= url('/contact') ?>` | Generate absolute URLs using the configured `APP_URL` |

---

## Step 4: Create CSS & JS Assets

Assets are organized by module inside `public/assets/css/` and `public/assets/js/`. Each page or feature gets its own subfolder.

### 4a. Create the CSS file

Create the file `public/assets/css/contact/contact.css`:

```css
/* =========================================
   Contact Page Styles
   ========================================= */

.contact-container {
    max-width: 600px;
    margin: 60px auto;
    padding: 40px 30px;
    background: var(--color-surface, #ffffff);
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.contact-container h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--color-text, #1a1a2e);
    margin-bottom: 8px;
    text-align: center;
}

.contact-subtitle {
    text-align: center;
    color: var(--color-text-secondary, #6b7280);
    margin-bottom: 32px;
}

/* ---------- Form ---------- */

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 6px;
    color: var(--color-text, #1a1a2e);
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--color-border, #d1d5db);
    border-radius: 8px;
    font-size: 0.95rem;
    font-family: inherit;
    background: var(--color-input-bg, #f9fafb);
    color: var(--color-text, #1a1a2e);
    transition: border-color 0.2s;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--color-primary, #6366f1);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

/* ---------- Validation Errors ---------- */

.error {
    color: var(--color-danger, #ef4444);
    font-size: 0.85rem;
    margin-top: 4px;
}

/* ---------- Alerts ---------- */

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    font-size: 0.9rem;
}

.alert-success {
    background: var(--color-success-bg, #ecfdf5);
    color: var(--color-success, #059669);
    border: 1px solid var(--color-success-border, #a7f3d0);
}

/* ---------- Button ---------- */

.btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.btn:hover {
    background: var(--color-primary-hover, #4f46e5);
}

/* ---------- Links ---------- */

.links {
    text-align: center;
    margin-top: 24px;
}

.links a {
    color: var(--color-primary, #6366f1);
    text-decoration: none;
    font-size: 0.9rem;
}

.links a:hover {
    text-decoration: underline;
}
```

**Note:** The CSS uses `var(--color-*)` custom properties defined in `base.css`. This ensures your page automatically supports both light and dark themes.

### 4b. Create the JS file

Create the file `public/assets/js/contact/contact.js`:

```js
/**
 * Contact Page Scripts
 */
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('contactForm');
    if (!form) return;

    // Basic client-side validation before submission
    form.addEventListener('submit', function (e) {
        const name    = form.querySelector('#name');
        const email   = form.querySelector('#email');
        const message = form.querySelector('#message');

        // Clear previous errors
        form.querySelectorAll('.error').forEach(function (el) {
            el.remove();
        });

        let isValid = true;

        if (name.value.trim().length < 2) {
            showError(name, 'Name must be at least 2 characters.');
            isValid = false;
        }

        if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            showError(email, 'Please enter a valid email address.');
            isValid = false;
        }

        if (message.value.trim().length < 10) {
            showError(message, 'Message must be at least 10 characters.');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    /**
     * Display an error message below a form field.
     */
    function showError(input, text) {
        const div       = document.createElement('div');
        div.className   = 'error';
        div.textContent = text;
        input.parentNode.appendChild(div);
    }
});
```

### Directory Structure After This Step

```
public/assets/
├── css/
│   ├── base.css                 ← Shared (variables, reset, dark mode)
│   ├── auth/
│   │   └── auth.css
│   ├── contact/                 ← NEW
│   │   └── contact.css          ← NEW
│   ├── dashboard/
│   │   ├── dashboard.css
│   │   └── dashboard-form.css
│   └── pages/
│       └── welcome.css
├── js/
│   ├── theme.js                 ← Dark/light toggle
│   ├── contact/                 ← NEW
│   │   └── contact.js           ← NEW
│   └── dashboard/
│       └── dashboard.js
```

---

## Step 5: Test It

### Start your server (if not already running)

```bash
# If using PHP's built-in server
php -S localhost:8000 -t public

# Or if Apache is configured, just open the URL
```

### Visit the page

Open your browser and go to:

```
http://localhost:8000/contact
```

You should see the styled contact form. Test the following:

1. **Empty submission** -- Submit the form without filling in any fields. You should be redirected back with validation error messages, and the fields remain empty.

2. **Partial input** -- Fill in only the name and submit. The email and message fields should show errors. The name field should retain its value (old input).

3. **Valid submission** -- Fill in all three fields with valid data (name at least 2 characters, a valid email, message at least 10 characters). You should see the green success alert: "Thank you! Your message has been sent."

### Troubleshooting

| Problem | Solution |
|---------|----------|
| **404 Not Found** | Verify you added `require __DIR__ . '/web/contact.php';` in `routes/web.php` |
| **Class not found** | Check the namespace: `App\Controllers\ContactController` must match the file path `app/Controllers/ContactController.php` |
| **CSS not loading** | Confirm the file exists at `public/assets/css/contact/contact.css` and the path in `assets()->css()` is `'css/contact/contact.css'` (relative to `public/assets/`) |
| **CSRF token mismatch** | Make sure `<?= csrf_field() ?>` is inside the `<form>` tag |
| **Styles look wrong** | Check that `base.css` is loaded at priority 8 (before your page CSS at priority 10) |

---

## Summary

Building a new page requires exactly **5 files** (plus one small edit):

### File Checklist

| # | File | Purpose |
|---|------|---------|
| 1 | `routes/web/contact.php` | Route definitions (GET and POST) |
| 2 | `routes/web.php` | Add `require` line (one-line edit) |
| 3 | `app/Controllers/ContactController.php` | Controller with `show()` and `submit()` methods |
| 4 | `resources/views/contact/index.php` | HTML view with asset registration and form markup |
| 5 | `public/assets/css/contact/contact.css` | Page-specific styles |
| 6 | `public/assets/js/contact/contact.js` | Page-specific JavaScript |

### The Pattern

Every page in the framework follows this same flow:

```
Route File           ->  Controller          ->  View                ->  Assets
routes/web/X.php        app/Controllers/       resources/views/       public/assets/css/X/
                        XController.php        X/index.php            public/assets/js/X/
```

### Asset Priority Reference

| Priority | What | Example |
|----------|------|---------|
| **5** | CDN dependencies | Google Fonts, icon libraries |
| **8** | Shared base styles | `css/base.css` |
| **10** | Page-specific assets | `css/contact/contact.css`, `js/contact/contact.js` |

### Quick Recap of Key Functions

```php
// In the controller
Response::view('contact/index', ['title' => 'Contact Us']);

// In the view -- register assets
assets()->css('css/contact/contact.css', 'head', 10);
assets()->js('js/contact/contact.js', 'body_end', 10);

// In the view -- render assets
<?= render_assets('head') ?>       // In <head>
<?= render_assets('body_end') ?>   // Before </body>

// In the view -- security and forms
<?= csrf_field() ?>                // CSRF hidden input
<?= e($variable) ?>               // Escape output (XSS protection)
<?= url('/contact') ?>             // Generate full URL
<?= e(old('name', '')) ?>          // Repopulate input after validation error
```
