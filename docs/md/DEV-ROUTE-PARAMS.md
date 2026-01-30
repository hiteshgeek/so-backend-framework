# Route Parameters & Model Binding

A step-by-step developer guide to defining route parameters, applying constraints, and leveraging automatic model binding in the SO Backend Framework.

## Table of Contents

1. [Overview](#overview)
2. [Required Parameters](#required-parameters)
3. [Optional Parameters](#optional-parameters)
4. [Parameter Constraints](#parameter-constraints)
5. [Multiple Parameters](#multiple-parameters)
6. [Route Model Binding](#route-model-binding)
7. [Combining Constraints with Model Binding](#combining-constraints-with-model-binding)

---

## Overview

Route parameters let you capture dynamic segments from the URL and pass them to your controller or closure handler. The SO Framework supports:

- **Required parameters** -- segments that must be present in the URL.
- **Optional parameters** -- segments that may be omitted (a default value is used instead).
- **Parameter constraints** -- rules that restrict a parameter to a specific format (digits, letters, UUIDs, etc.).
- **Route model binding** -- automatic resolution of a Model instance from a route parameter value, so you receive a fully-loaded model object instead of a raw ID.

All route definitions live in `routes/web.php` (web routes) or `routes/api.php` (API routes).

---

## Required Parameters

Wrap a parameter name in curly braces to make it required. The matched value is passed to your controller method (or closure) as a function argument whose name matches the parameter.

### Basic Example

```php
use Core\Routing\Router;
use App\Controllers\UserController;

// Define the route with a required {id} parameter
Router::get('/users/{id}', [UserController::class, 'show']);
```

```php
// app/Controllers/UserController.php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class UserController
{
    public function show(Request $request, $id): Response
    {
        // $id contains whatever appeared in the URL segment
        // e.g. GET /users/42  -->  $id = "42"
        return json(['user_id' => $id]);
    }
}
```

### Closure Example

```php
Router::get('/users/{id}', function ($id) {
    return json(['user_id' => $id]);
});
```

If a user visits `/users/42`, the framework matches `{id}` to `42` and injects it as `$id`.

> **Note:** Without a constraint, the parameter accepts any non-empty string that does not contain a forward slash. Add a constraint (see below) to restrict the format.

---

## Optional Parameters

Append a `?` after the parameter name to make it optional. Always provide a default value in the function signature.

```php
Router::get('/posts/{slug?}', function ($slug = null) {
    if ($slug) {
        // Fetch and return the specific post
        return json(['slug' => $slug]);
    }

    // No slug provided -- return all posts
    return json(['posts' => 'listing all posts']);
});
```

```php
// Another example with a meaningful default
Router::get('/greet/{name?}', function ($name = 'Guest') {
    return response("Hello, {$name}!");
});
```

| URL | `$name` value |
|-----|---------------|
| `/greet` | `"Guest"` (default) |
| `/greet/Alice` | `"Alice"` |

### Optional Parameters in Controllers

```php
Router::get('/archive/{year?}', [ArchiveController::class, 'index']);
```

```php
class ArchiveController
{
    public function index(Request $request, $year = null): Response
    {
        $year = $year ?? date('Y'); // Default to current year
        return json(['year' => $year]);
    }
}
```

---

## Parameter Constraints

Constraints validate the format of a route parameter **before** the route is matched. If the value does not satisfy the constraint, the route is skipped entirely and the router continues looking for other matches.

### whereNumber -- Digits Only

Accepts one or more digits (`[0-9]+`).

```php
Router::get('/users/{id}', [UserController::class, 'show'])
    ->whereNumber('id');
```

- `/users/42` -- matches
- `/users/abc` -- does **not** match (route is skipped)

### whereAlpha -- Letters Only

Accepts uppercase and lowercase letters (`[a-zA-Z]+`).

```php
Router::get('/categories/{name}', [CategoryController::class, 'show'])
    ->whereAlpha('name');
```

- `/categories/electronics` -- matches
- `/categories/item-5` -- does **not** match (contains a dash and digit)

### whereAlphaNumeric -- Letters and Digits

Accepts alphanumeric characters (`[a-zA-Z0-9]+`).

```php
Router::get('/products/{code}', [ProductController::class, 'show'])
    ->whereAlphaNumeric('code');
```

- `/products/ABC123` -- matches
- `/products/abc-123` -- does **not** match (contains a dash)

### whereSlug -- Letters, Numbers, and Dashes

Accepts alphanumeric characters and dashes (`[a-zA-Z0-9-]+`). Ideal for URL-friendly slugs.

```php
Router::get('/posts/{slug}', [PostController::class, 'show'])
    ->whereSlug('slug');
```

- `/posts/my-first-post` -- matches
- `/posts/hello_world` -- does **not** match (contains an underscore)

### whereUuid -- UUID Format

Accepts standard UUID strings (`xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx`).

```php
Router::get('/orders/{uuid}', [OrderController::class, 'show'])
    ->whereUuid('uuid');
```

- `/orders/550e8400-e29b-41d4-a716-446655440000` -- matches
- `/orders/12345` -- does **not** match

### whereIn -- Specific Allowed Values

Restricts the parameter to one of an explicit set of values.

```php
Router::get('/status/{status}', [StatusController::class, 'show'])
    ->whereIn('status', ['active', 'inactive']);
```

- `/status/active` -- matches
- `/status/inactive` -- matches
- `/status/banned` -- does **not** match

### where -- Custom Regex

For patterns not covered by the built-in helpers, pass a raw regular expression.

```php
Router::get('/archive/{year}', [ArchiveController::class, 'show'])
    ->where('year', '[0-9]{4}');
```

- `/archive/2025` -- matches
- `/archive/25` -- does **not** match (not exactly four digits)

You can also constrain multiple parameters at once using an array:

```php
Router::get('/archive/{year}/{month}', [ArchiveController::class, 'show'])
    ->where([
        'year'  => '[0-9]{4}',
        'month' => '(0[1-9]|1[0-2])',
    ]);
```

---

## Multiple Parameters

Routes can contain more than one parameter. Each parameter name must be unique within the route and will be mapped to the corresponding function argument by name.

```php
Router::get('/users/{id}/posts/{slug}', [UserPostController::class, 'show'])
    ->whereNumber('id')
    ->whereSlug('slug');
```

```php
class UserPostController
{
    public function show(Request $request, $id, $slug): Response
    {
        // $id  = numeric user ID from the URL
        // $slug = post slug from the URL
        return json([
            'user_id'   => $id,
            'post_slug' => $slug,
        ]);
    }
}
```

### Applying the Same Constraint to Multiple Parameters

The `whereNumber`, `whereAlpha`, `whereAlphaNumeric`, `whereSlug`, and `whereUuid` methods accept variadic arguments, so you can constrain several parameters in one call:

```php
Router::get('/users/{user}/posts/{post}', [UserPostController::class, 'show'])
    ->whereNumber('user', 'post');
```

### Chaining Different Constraints

```php
Router::get('/teams/{team}/members/{name}', [TeamController::class, 'member'])
    ->whereNumber('team')
    ->whereAlpha('name');
```

---

## Route Model Binding

Route model binding eliminates manual `Model::find()` calls. Instead of receiving a raw ID string, you type-hint a Model class in your controller method and the framework resolves it automatically.

### How It Works

1. The framework inspects the controller method's type hints using PHP reflection.
2. If a parameter is type-hinted with a class that extends `Core\Model\Model`, the framework calls `Model::find()` with the route parameter value.
3. If `find()` returns `null`, a `Core\Exceptions\NotFoundException` is thrown, which results in a **404** HTTP response.

This logic lives in the `Route::resolveModelBindings()` method.

### Basic Example

```php
// Route definition
Router::get('/posts/{id}', [PostController::class, 'show']);
```

```php
// app/Controllers/PostController.php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use App\Models\Post;

class PostController
{
    public function show(Request $request, Post $id): Response
    {
        // $id is automatically resolved via Post::find($id)
        // If no post is found, a NotFoundException is thrown (404)
        return json([
            'id'    => $id->id,
            'title' => $id->title,
            'body'  => $id->body,
        ]);
    }
}
```

When a request hits `GET /posts/7`, the framework:

1. Extracts `7` from the `{id}` segment.
2. Sees that `$id` is type-hinted as `Post` (a `Model` subclass).
3. Calls `Post::find(7)`.
4. If a post with ID 7 exists, it is injected as `$id`.
5. If no post exists, a `NotFoundException` is thrown and a 404 response is returned.

### Closure Routes with Model Binding

Model binding also works with closure routes via `Route::resolveClosureBindings()`:

```php
Router::get('/users/{id}', function (Request $request, \App\Models\User $id) {
    return json($id->toArray());
});
```

### Without Model Binding (Manual Approach)

For comparison, here is the equivalent code without model binding:

```php
use Core\Exceptions\NotFoundException;

class PostController
{
    public function show(Request $request, $id): Response
    {
        $post = Post::find((int) $id);

        if (!$post) {
            throw new NotFoundException('Post not found');
        }

        return json([
            'id'    => $post->id,
            'title' => $post->title,
            'body'  => $post->body,
        ]);
    }
}
```

Model binding removes this boilerplate entirely.

### Multiple Model Bindings

You can bind more than one model in a single route:

```php
Router::get('/users/{user}/posts/{post}', [UserPostController::class, 'show']);
```

```php
use App\Models\User;
use App\Models\Post;

class UserPostController
{
    public function show(Request $request, User $user, Post $post): Response
    {
        return json([
            'user' => $user->toArray(),
            'post' => $post->toArray(),
        ]);
    }
}
```

Both `$user` and `$post` are resolved automatically. If either is not found, a 404 is returned.

---

## Combining Constraints with Model Binding

Constraints and model binding work together. The constraint validates the parameter format **first** (at the routing level), and model binding resolves the model **second** (at the controller level). This means invalid formats never reach the database.

### Example: Numeric Constraint + Model Binding

```php
Router::get('/posts/{id}', [PostController::class, 'show'])
    ->whereNumber('id')
    ->name('posts.show');
```

```php
class PostController
{
    public function show(Request $request, Post $id): Response
    {
        // 1. whereNumber('id') ensures only digit strings reach this method.
        //    Requests like /posts/abc are rejected before the controller runs.
        // 2. Model binding calls Post::find($id) automatically.
        // 3. If no post exists, a 404 is returned.
        return json($id->toArray());
    }
}
```

### Example: UUID Constraint + Model Binding

```php
Router::get('/orders/{uuid}', [OrderController::class, 'show'])
    ->whereUuid('uuid');
```

```php
use App\Models\Order;

class OrderController
{
    public function show(Request $request, Order $uuid): Response
    {
        return json($uuid->toArray());
    }
}
```

### Example: Full CRUD with Constraints and Binding

```php
use Core\Routing\Router;
use App\Controllers\ArticleController;

// List all articles
Router::get('/articles', [ArticleController::class, 'index'])
    ->name('articles.index');

// Show create form
Router::get('/articles/create', [ArticleController::class, 'create'])
    ->name('articles.create');

// Store a new article
Router::post('/articles', [ArticleController::class, 'store'])
    ->name('articles.store');

// Show a single article (constrained + model-bound)
Router::get('/articles/{id}', [ArticleController::class, 'show'])
    ->whereNumber('id')
    ->name('articles.show');

// Update an article
Router::put('/articles/{id}', [ArticleController::class, 'update'])
    ->whereNumber('id')
    ->name('articles.update');

// Delete an article
Router::delete('/articles/{id}', [ArticleController::class, 'destroy'])
    ->whereNumber('id')
    ->name('articles.destroy');
```

```php
use App\Models\Article;

class ArticleController
{
    public function index(Request $request): Response
    {
        $articles = Article::all();
        return json($articles);
    }

    public function show(Request $request, Article $id): Response
    {
        return json($id->toArray());
    }

    public function update(Request $request, Article $id): Response
    {
        $id->update($request->only(['title', 'body']));
        return json($id->toArray());
    }

    public function destroy(Request $request, Article $id): Response
    {
        $id->delete();
        return json(['message' => 'Article deleted']);
    }
}
```

### Example: Nested Resources with Mixed Constraints

```php
Router::get('/teams/{team}/projects/{project}/tasks/{task}', [TaskController::class, 'show'])
    ->whereNumber('team')
    ->whereAlphaNumeric('project')
    ->whereNumber('task');
```

```php
use App\Models\Team;
use App\Models\Task;

class TaskController
{
    public function show(Request $request, Team $team, $project, Task $task): Response
    {
        // $team  -- model-bound (Team::find() called automatically)
        // $project -- raw string, not model-bound (no Model type hint)
        // $task  -- model-bound (Task::find() called automatically)

        return json([
            'team'    => $team->toArray(),
            'project' => $project,
            'task'    => $task->toArray(),
        ]);
    }
}
```

---

## Quick Reference

| Feature | Syntax | Regex Applied |
|---------|--------|---------------|
| Required param | `{id}` | `[^/]+` |
| Optional param | `{slug?}` | `[^/]*` |
| Digits only | `->whereNumber('id')` | `[0-9]+` |
| Letters only | `->whereAlpha('name')` | `[a-zA-Z]+` |
| Alphanumeric | `->whereAlphaNumeric('code')` | `[a-zA-Z0-9]+` |
| Slug format | `->whereSlug('slug')` | `[a-zA-Z0-9-]+` |
| UUID format | `->whereUuid('uuid')` | `[0-9a-fA-F]{8}-...-[0-9a-fA-F]{12}` |
| Specific values | `->whereIn('status', [...])` | Values joined with `\|` |
| Custom regex | `->where('year', '[0-9]{4}')` | Your pattern |
| Model binding | Type-hint a `Model` subclass | N/A |

---

## See Also

- [Routing System](ROUTING-SYSTEM.md) -- Full routing reference (groups, middleware, named routes, resource routes)
- [Validation System](VALIDATION-SYSTEM.md) -- Validating request body data after the route matches
- [Security Layer](SECURITY-LAYER.md) -- Middleware-based authentication and authorization
