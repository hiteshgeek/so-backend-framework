# Building a CRUD Module

This tutorial walks you through building a complete **Articles** module with Create, Read, Update, and Delete functionality using the SO Backend Framework.

## Table of Contents

1. [Overview](#overview)
2. [Step 1: Create the Model](#step-1-create-the-model)
3. [Step 2: Define Routes](#step-2-define-routes)
4. [Step 3: Create the Controller](#step-3-create-the-controller)
5. [Step 4: Create Views](#step-4-create-views)
6. [Step 5: Add CSRF Protection and Validation](#step-5-add-csrf-protection-and-validation)
7. [Step 6: Test the Module](#step-6-test-the-module)
8. [Summary](#summary)

---

## Overview

By the end of this tutorial you will have a fully working Articles module with:

- **List page** -- Display all articles in a table with edit and delete actions
- **Create page** -- A form to add a new article
- **Edit page** -- A form to update an existing article
- **Delete action** -- Remove an article with a confirmation prompt
- **Validation** -- Server-side input validation on all form submissions
- **CSRF protection** -- Secure all POST/PUT/DELETE requests against cross-site request forgery
- **Flash messages** -- Success and error feedback after every action

### Files You Will Create

| File                                    | Purpose                      |
| --------------------------------------- | ---------------------------- |
| `app/Models/Article.php`                | Article model                |
| `routes/web/articles.php`               | Route definitions            |
| `app/Controllers/ArticleController.php` | Controller with CRUD methods |
| `resources/views/articles/index.php`    | List view                    |
| `resources/views/articles/create.php`   | Create form view             |
| `resources/views/articles/edit.php`     | Edit form view               |

### Database Table

Before starting, create the `articles` table in your database:

```sql
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## Step 1: Create the Model

Create `app/Models/Article.php`. The model extends `Core\Model\Model`, declares the table name, and lists which columns are mass-assignable via the `$fillable` array.

```php
<?php

namespace App\Models;

use Core\Model\Model;

class Article extends Model
{
    protected static string $table = 'articles';

    protected array $fillable = [
        'title',
        'slug',
        'body',
        'status',
    ];

    /**
     * Scope: only published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', '=', 'published');
    }

    /**
     * Scope: only drafts
     */
    public function scopeDraft($query)
    {
        return $query->where('status', '=', 'draft');
    }
}
```

### Key Points

- `$table` -- tells the framework which database table this model maps to.
- `$fillable` -- only these columns can be set through `Article::create()` or `$article->fill()`. Everything else is ignored for safety.
- **Scopes** -- reusable query filters. Call them as `Article::published()->get()` or `Article::draft()->get()`.

---

## Step 2: Define Routes

Create `routes/web/articles.php`. The framework auto-loads every file inside `routes/web/`, so simply creating this file is enough to register the routes.

### Option A: Resource Routes (Recommended)

The quickest approach. A single `Router::resource()` call generates all seven standard CRUD routes at once:

```php
<?php

use Core\Routing\Router;
use App\Controllers\ArticleController;
use App\Middleware\CsrfMiddleware;

Router::group(['middleware' => [CsrfMiddleware::class]], function () {
    Router::resource('articles', ArticleController::class);
});
```

This one line generates:

| Method | URI                   | Controller Method | Purpose             |
| ------ | --------------------- | ----------------- | ------------------- |
| GET    | `/articles`           | `index`           | List all articles   |
| GET    | `/articles/create`    | `create`          | Show create form    |
| POST   | `/articles`           | `store`           | Save new article    |
| GET    | `/articles/{id}`      | `show`            | Show single article |
| GET    | `/articles/{id}/edit` | `edit`            | Show edit form      |
| PUT    | `/articles/{id}`      | `update`          | Update article      |
| DELETE | `/articles/{id}`      | `destroy`         | Delete article      |

### Option B: Manual Routes

If you need more control -- for example to add named routes, apply middleware to individual routes, or skip certain routes -- define them explicitly:

```php
<?php

use Core\Routing\Router;
use App\Controllers\ArticleController;
use App\Middleware\CsrfMiddleware;
use App\Middleware\AuthMiddleware;

Router::group(['prefix' => 'articles', 'middleware' => [CsrfMiddleware::class]], function () {

    // Public routes
    Router::get('/', [ArticleController::class, 'index'])
        ->name('articles.index');

    Router::get('/create', [ArticleController::class, 'create'])
        ->name('articles.create');

    Router::post('/', [ArticleController::class, 'store'])
        ->name('articles.store');

    Router::get('/{id}/edit', [ArticleController::class, 'edit'])
        ->name('articles.edit')
        ->whereNumber('id');

    Router::put('/{id}', [ArticleController::class, 'update'])
        ->name('articles.update')
        ->whereNumber('id');

    Router::delete('/{id}', [ArticleController::class, 'destroy'])
        ->name('articles.destroy')
        ->whereNumber('id');
});
```

### Which Approach Should I Use?

- Use **resource routes** when you want the standard CRUD pattern with minimal code.
- Use **manual routes** when you need named routes, per-route middleware, parameter constraints, or want to omit certain actions (for example, skip `show` if you do not need a detail page).

---

## Step 3: Create the Controller

Create `app/Controllers/ArticleController.php`. This controller contains six methods: `index`, `create`, `store`, `edit`, `update`, and `destroy`.

```php
<?php

namespace App\Controllers;

use App\Models\Article;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

class ArticleController
{
    /**
     * Display a list of all articles.
     */
    public function index(Request $request): Response
    {
        $articles = Article::all();

        return Response::view('articles/index', [
            'title'    => 'Articles - ' . config('app.name'),
            'articles' => $articles,
            'success'  => session('success'),
            'error'    => session('error'),
        ]);
    }

    /**
     * Show the form to create a new article.
     */
    public function create(Request $request): Response
    {
        return Response::view('articles/create', [
            'title'  => 'New Article - ' . config('app.name'),
            'errors' => session('errors', []),
            'old'    => session('_old_input', []),
        ]);
    }

    /**
     * Validate input and store a new article.
     */
    public function store(Request $request): Response
    {
        // --- Validation ---
        $validator = Validator::make($request->all(), [
            'title'  => 'required|string|min:3|max:255',
            'slug'   => 'required|alpha_dash|max:255|unique:articles,slug',
            'body'   => 'required|string|min:10',
            'status' => 'required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return redirect(url('/articles/create'))
                ->withErrors($validator->errors())
                ->withInput($request->all());
        }

        // --- Create ---
        Article::create([
            'title'  => $request->input('title'),
            'slug'   => $request->input('slug'),
            'body'   => $request->input('body'),
            'status' => $request->input('status'),
        ]);

        return redirect(url('/articles'))
            ->with('success', 'Article created successfully!');
    }

    /**
     * Show the form to edit an existing article.
     */
    public function edit(Request $request, int $id): Response
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect(url('/articles'))
                ->with('error', 'Article not found.');
        }

        return Response::view('articles/edit', [
            'title'   => 'Edit Article - ' . config('app.name'),
            'article' => $article,
            'errors'  => session('errors', []),
            'old'     => session('_old_input', []),
        ]);
    }

    /**
     * Validate input and update an existing article.
     */
    public function update(Request $request, int $id): Response
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect(url('/articles'))
                ->with('error', 'Article not found.');
        }

        // --- Validation ---
        $validator = Validator::make($request->all(), [
            'title'  => 'required|string|min:3|max:255',
            'slug'   => 'required|alpha_dash|max:255|unique:articles,slug,' . $id,
            'body'   => 'required|string|min:10',
            'status' => 'required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return redirect(url('/articles/' . $id . '/edit'))
                ->withErrors($validator->errors())
                ->withInput($request->all());
        }

        // --- Update ---
        $article->title  = $request->input('title');
        $article->slug   = $request->input('slug');
        $article->body   = $request->input('body');
        $article->status = $request->input('status');
        $article->save();

        return redirect(url('/articles'))
            ->with('success', 'Article updated successfully!');
    }

    /**
     * Delete an article.
     */
    public function destroy(Request $request, int $id): Response
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect(url('/articles'))
                ->with('error', 'Article not found.');
        }

        $articleTitle = $article->title;
        $article->delete();

        return redirect(url('/articles'))
            ->with('success', 'Article "' . $articleTitle . '" deleted successfully.');
    }
}
```

### Explanation

| Method    | HTTP   | What It Does                                                                                                                                                   |
| --------- | ------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `index`   | GET    | Fetches all articles with `Article::all()` and passes them to the list view.                                                                                   |
| `create`  | GET    | Renders the create form. Passes `errors` and `old` from the session so the form can re-populate after a validation failure.                                    |
| `store`   | POST   | Validates the request. On failure, redirects back with errors and old input. On success, creates the article and redirects to the list with a success message. |
| `edit`    | GET    | Finds the article by ID. If not found, redirects with an error. Otherwise renders the edit form with the article data.                                         |
| `update`  | PUT    | Validates the request (note `unique:articles,slug,' . $id` to exclude the current record). Updates each field and calls `$article->save()`.                    |
| `destroy` | DELETE | Finds the article, stores its title for the flash message, calls `$article->delete()`, and redirects.                                                          |

---

## Step 4: Create Views

### 4.1 -- List View

Create `resources/views/articles/index.php`. This view displays all articles in a table with links to create, edit, and delete.

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Articles') ?></title>
    <?php
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', 'css', 'head', 5);
    assets()->css('css/base.css', 'head', 8);
    ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Articles</h1>
        </div>
    </div>

    <div class="container">

        <?php if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <div style="margin-bottom: 1rem;">
            <a href="<?= url('/articles/create') ?>" class="btn btn-primary">+ New Article</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($articles)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No articles found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= e($article->id) ?></td>
                            <td><?= e($article->title) ?></td>
                            <td><?= e($article->slug) ?></td>
                            <td><?= e($article->status) ?></td>
                            <td><?= e($article->created_at) ?></td>
                            <td>
                                <a href="<?= url('/articles/' . $article->id . '/edit') ?>" class="btn btn-edit">Edit</a>

                                <form method="POST" action="<?= url('/articles/' . $article->id) ?>" class="inline-form" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <?= render_assets('body_end') ?>
</body>
</html>
```

### 4.2 -- Create Form View

Create `resources/views/articles/create.php`. The form POSTs to `/articles`. Notice how `old()` re-populates fields and `$errors` displays validation messages.

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'New Article') ?></title>
    <?php
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', 'css', 'head', 5);
    assets()->css('css/base.css', 'head', 8);
    ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>New Article</h1>
        </div>
    </div>

    <div class="container">
        <div class="form-card">
            <h2>Article Details</h2>

            <form method="POST" action="<?= url('/articles') ?>">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title"
                           value="<?= e(old('title', '')) ?>" required autofocus>
                    <?php if (isset($errors['title'])): ?>
                        <div class="error"><?= e($errors['title'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug"
                           value="<?= e(old('slug', '')) ?>" required>
                    <?php if (isset($errors['slug'])): ?>
                        <div class="error"><?= e($errors['slug'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea id="body" name="body" rows="8" required><?= e(old('body', '')) ?></textarea>
                    <?php if (isset($errors['body'])): ?>
                        <div class="error"><?= e($errors['body'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="draft" <?= old('status', 'draft') === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= old('status') === 'published' ? 'selected' : '' ?>>Published</option>
                    </select>
                    <?php if (isset($errors['status'])): ?>
                        <div class="error"><?= e($errors['status'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Create Article</button>
                    <a href="<?= url('/articles') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?= render_assets('body_end') ?>
</body>
</html>
```

### 4.3 -- Edit Form View

Create `resources/views/articles/edit.php`. This is nearly identical to the create form but pre-fills fields with the existing article data and uses a hidden `_method` field set to `PUT`.

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Edit Article') ?></title>
    <?php
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', 'css', 'head', 5);
    assets()->css('css/base.css', 'head', 8);
    ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Edit Article</h1>
        </div>
    </div>

    <div class="container">
        <div class="form-card">
            <h2>Edit: <?= e($article->title) ?></h2>

            <form method="POST" action="<?= url('/articles/' . $article->id) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title"
                           value="<?= e(old('title', $article->title)) ?>" required autofocus>
                    <?php if (isset($errors['title'])): ?>
                        <div class="error"><?= e($errors['title'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug"
                           value="<?= e(old('slug', $article->slug)) ?>" required>
                    <?php if (isset($errors['slug'])): ?>
                        <div class="error"><?= e($errors['slug'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea id="body" name="body" rows="8" required><?= e(old('body', $article->body)) ?></textarea>
                    <?php if (isset($errors['body'])): ?>
                        <div class="error"><?= e($errors['body'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <?php $currentStatus = old('status', $article->status); ?>
                    <select id="status" name="status">
                        <option value="draft" <?= $currentStatus === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= $currentStatus === 'published' ? 'selected' : '' ?>>Published</option>
                    </select>
                    <?php if (isset($errors['status'])): ?>
                        <div class="error"><?= e($errors['status'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Update Article</button>
                    <a href="<?= url('/articles') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?= render_assets('body_end') ?>
</body>
</html>
```

---

## Step 5: Add CSRF Protection and Validation

CSRF protection and validation are already built into the code above. This section explains how each piece works so you can apply the same patterns in any module you build.

### 5.1 -- CSRF Protection

**In routes** -- wrap your routes with `CsrfMiddleware`:

```php
Router::group(['middleware' => [CsrfMiddleware::class]], function () {
    // All routes inside this group are CSRF-protected
});
```

**In forms** -- add `csrf_field()` inside every `<form>` tag:

```html
<form method="POST" action="<?= url('/articles') ?>">
  <?= csrf_field() ?>
  <!-- form fields -->
</form>
```

`csrf_field()` outputs a hidden input like:

```html
<input type="hidden" name="_token" value="a1b2c3d4e5..." />
```

The `CsrfMiddleware` automatically verifies this token on every POST, PUT, and DELETE request. If the token is missing or invalid, the request is rejected with a 419 error.

### 5.2 -- Method Spoofing (PUT / DELETE)

HTML forms only support GET and POST. To send PUT or DELETE requests, add a hidden `_method` field:

```html
<!-- For UPDATE (PUT) -->
<form method="POST" action="<?= url('/articles/' . $article->id) ?>">
  <?= csrf_field() ?>
  <input type="hidden" name="_method" value="PUT" />
  <!-- form fields -->
</form>

<!-- For DELETE -->
<form method="POST" action="<?= url('/articles/' . $article->id) ?>">
  <?= csrf_field() ?>
  <input type="hidden" name="_method" value="DELETE" />
  <button type="submit">Delete</button>
</form>
```

### 5.3 -- Validation

Use `Validator::make()` in your controller to validate the request data:

```php
use Core\Validation\Validator;

$validator = Validator::make($request->all(), [
    'title'  => 'required|string|min:3|max:255',
    'slug'   => 'required|alpha_dash|max:255|unique:articles,slug',
    'body'   => 'required|string|min:10',
    'status' => 'required|in:draft,published',
]);
```

**Check for failures and redirect with errors:**

```php
if ($validator->fails()) {
    return redirect(url('/articles/create'))
        ->withErrors($validator->errors())   // flash errors to session
        ->withInput($request->all());        // flash old input to session
}
```

**Display errors in views:**

```php
<?php if (isset($errors['title'])): ?>
    <div class="error"><?= e($errors['title'][0]) ?></div>
<?php endif; ?>
```

**Re-populate form fields with old input:**

```php
<input type="text" name="title" value="<?= e(old('title', '')) ?>">
```

### 5.4 -- Unique Validation on Update

When updating a record, exclude the current record from the unique check by appending the record's ID:

```php
// On create -- no exception
'slug' => 'required|alpha_dash|unique:articles,slug'

// On update -- exclude current article
'slug' => 'required|alpha_dash|unique:articles,slug,' . $id
```

Without the exclusion, updating an article without changing its slug would fail validation because the slug already exists (on the same record).

### 5.5 -- Flash Messages

Set flash messages when redirecting:

```php
return redirect(url('/articles'))
    ->with('success', 'Article created successfully!');
```

Read them in the view:

```php
<?php if ($success): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>
```

Flash messages are automatically cleared after one request, so they only appear once.

---

## Step 6: Test the Module

### 6.1 -- Verify the List Page

Open your browser and navigate to:

```
http://your-site.com/articles
```

You should see an empty table with a "New Article" button. If you get a 404, verify that `routes/web/articles.php` exists and contains valid route definitions.

### 6.2 -- Create an Article

1. Click **"+ New Article"** to go to `/articles/create`.
2. Fill in the form:
   - Title: `My First Article`
   - Slug: `my-first-article`
   - Body: `This is the body of my first article in the system.`
   - Status: `Published`
3. Click **"Create Article"**.
4. You should be redirected to `/articles` with the message "Article created successfully!" and the new article in the table.

### 6.3 -- Test Validation

1. Go to `/articles/create`.
2. Leave all fields empty and click **"Create Article"**.
3. You should be redirected back to the form with error messages under each field.
4. Fill in a title with fewer than 3 characters. Confirm the min-length error appears.
5. Try a slug that already exists. Confirm the unique error appears.

### 6.4 -- Edit an Article

1. On the list page, click **"Edit"** next to an article.
2. Change the title and body.
3. Click **"Update Article"**.
4. Confirm the redirect back to the list with "Article updated successfully!".

### 6.5 -- Delete an Article

1. On the list page, click **"Delete"** next to an article.
2. Confirm the browser dialog.
3. The article should be removed and a success message displayed.

### 6.6 -- Test With cURL

You can also test from the command line. Note that CSRF protection requires a valid token, so these commands are primarily useful for verifying routing:

```bash
# List articles (GET -- no CSRF needed)
curl -s http://your-site.com/articles

# Verify the create form loads (GET -- no CSRF needed)
curl -s http://your-site.com/articles/create

# Verify the edit form loads (GET -- no CSRF needed)
curl -s http://your-site.com/articles/1/edit
```

---

## Summary

### Complete File List

```
app/
  Controllers/
    ArticleController.php      # index, create, store, edit, update, destroy
  Models/
    Article.php                 # Model with $table, $fillable, scopes

routes/
  web/
    articles.php               # Route definitions (resource or manual)

resources/
  views/
    articles/
      index.php                # List all articles
      create.php               # Create form
      edit.php                  # Edit form
```

### Pattern Recap

| Concept              | How It Works                                                            |
| -------------------- | ----------------------------------------------------------------------- |
| **Model**            | Extend `Core\Model\Model`, set `$table` and `$fillable`                 |
| **Routes**           | Use `Router::resource()` or define each route manually in `routes/web/` |
| **Controller**       | Return `Response::view()` for pages, `redirect()` for actions           |
| **Views**            | PHP files in `resources/views/`, use `e()` for output escaping          |
| **Validation**       | `Validator::make($request->all(), [...])`, check `$validator->fails()`  |
| **CSRF**             | `CsrfMiddleware` on route group, `csrf_field()` in every form           |
| **Method Spoofing**  | `<input type="hidden" name="_method" value="PUT">` for PUT/DELETE       |
| **Flash Messages**   | `redirect()->with('success', '...')` and `session('success')` in views  |
| **Old Input**        | `redirect()->withInput()` and `old('field', $default)` in views         |
| **Unique on Update** | `'unique:table,column,' . $id` to exclude the current record            |

### Adapting This Pattern

To build another module (for example, Categories or Tags), follow the same six steps:

1. Create a model in `app/Models/`.
2. Add a route file in `routes/web/`.
3. Create a controller in `app/Controllers/`.
4. Build your views in `resources/views/your-module/`.
5. Add CSRF and validation.
6. Test.

Every CRUD module in this framework follows the same structure, so once you have built one, the rest are straightforward.

---

**Documentation Version**: 1.0
**Last Updated**: 2026-01-30
**Maintained By**: SO Backend Framework Team
