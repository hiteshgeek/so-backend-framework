# Pagination - Developer Guide

**SO Framework** | **Implementing Pagination** | **Version 1.0**

A practical guide to implementing pagination for database queries and displaying paginated results in views.

---

## Table of Contents

1. [Overview](#overview)
2. [Basic Pagination](#basic-pagination)
3. [Displaying Pagination](#displaying-pagination)
4. [Customizing Pagination](#customizing-pagination)
5. [Complete Examples](#complete-examples)

---

## Overview

Pagination divides large datasets into smaller pages, improving performance and user experience.

### Benefits

- **Better Performance** -- Load only records needed for current page
- **Improved UX** -- Easier navigation through large datasets
- **Reduced Memory** -- Prevents loading thousands of records at once

### Pagination Data Structure

The `paginate()` method returns an array with:

```php
[
    'data' => [...],        // Current page records
    'total' => 150,         // Total records
    'per_page' => 15,       // Records per page
    'current_page' => 1,    // Current page number
    'last_page' => 10,      // Total pages
    'from' => 1,            // First record number on page
    'to' => 15,             // Last record number on page
]
```

---

## Basic Pagination

### Query Builder Pagination

```php
use Core\Database\DB;

public function index(Request $request): Response
{
    $page = (int) $request->input('page', 1);

    $users = DB::table('users')->paginate(15, $page);

    return Response::view('users/index', ['users' => $users]);
}
```

### Model Pagination

```php
use App\Models\Post;

public function index(Request $request): Response
{
    $page = (int) $request->input('page', 1);

    $posts = Post::query()->paginate(15, $page);

    return Response::view('posts/index', ['posts' => $posts]);
}
```

### With Where Clauses

```php
$posts = Post::where('published', true)
    ->orderBy('created_at', 'desc')
    ->paginate(20, $page);
```

### Custom Per Page

```php
// 10 records per page
$users = User::query()->paginate(10, $page);

// 50 records per page
$posts = Post::query()->paginate(50, $page);

// Let user choose page size
$perPage = (int) $request->input('per_page', 15);
$perPage = max(10, min(100, $perPage)); // Limit between 10-100
$results = Post::query()->paginate($perPage, $page);
```

---

## Displaying Pagination

### View Template

**resources/views/posts/index.php:**

```php
<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <style>
        .pagination {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }
        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
        }
        .pagination .active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .pagination .disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <h1>Posts</h1>

    <!-- Display posts -->
    <?php foreach ($posts['data'] as $post): ?>
        <article>
            <h2><?= e($post['title']) ?></h2>
            <p><?= e($post['excerpt']) ?></p>
        </article>
    <?php endforeach; ?>

    <!-- Pagination info -->
    <p>
        Showing <?= $posts['from'] ?> to <?= $posts['to'] ?> of <?= $posts['total'] ?> results
    </p>

    <!-- Pagination links -->
    <div class="pagination">
        <!-- Previous button -->
        <?php if ($posts['current_page'] > 1): ?>
            <a href="?page=<?= $posts['current_page'] - 1 ?>">Previous</a>
        <?php else: ?>
            <span class="disabled">Previous</span>
        <?php endif; ?>

        <!-- Page numbers -->
        <?php for ($i = 1; $i <= $posts['last_page']; $i++): ?>
            <?php if ($i === $posts['current_page']): ?>
                <span class="active"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <!-- Next button -->
        <?php if ($posts['current_page'] < $posts['last_page']): ?>
            <a href="?page=<?= $posts['current_page'] + 1 ?>">Next</a>
        <?php else: ?>
            <span class="disabled">Next</span>
        <?php endif; ?>
    </div>
</body>
</html>
```

### Reusable Pagination Component

Create a reusable component:

**resources/views/partials/pagination.php:**

```php
<?php if ($pagination['last_page'] > 1): ?>
    <div class="pagination">
        <!-- Previous -->
        <?php if ($pagination['current_page'] > 1): ?>
            <a href="?page=<?= $pagination['current_page'] - 1 ?>" class="pagination-link">
                « Previous
            </a>
        <?php else: ?>
            <span class="pagination-link disabled">« Previous</span>
        <?php endif; ?>

        <!-- Page numbers -->
        <?php
        $start = max(1, $pagination['current_page'] - 2);
        $end = min($pagination['last_page'], $pagination['current_page'] + 2);
        ?>

        <?php if ($start > 1): ?>
            <a href="?page=1" class="pagination-link">1</a>
            <?php if ($start > 2): ?>
                <span class="pagination-dots">...</span>
            <?php endif; ?>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <?php if ($i === $pagination['current_page']): ?>
                <span class="pagination-link active"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>" class="pagination-link"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($end < $pagination['last_page']): ?>
            <?php if ($end < $pagination['last_page'] - 1): ?>
                <span class="pagination-dots">...</span>
            <?php endif; ?>
            <a href="?page=<?= $pagination['last_page'] ?>" class="pagination-link">
                <?= $pagination['last_page'] ?>
            </a>
        <?php endif; ?>

        <!-- Next -->
        <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
            <a href="?page=<?= $pagination['current_page'] + 1 ?>" class="pagination-link">
                Next »
            </a>
        <?php else: ?>
            <span class="pagination-link disabled">Next »</span>
        <?php endif; ?>
    </div>

    <p class="pagination-info">
        Showing <?= $pagination['from'] ?> to <?= $pagination['to'] ?> of <?= $pagination['total'] ?> results
    </p>
<?php endif; ?>
```

**Usage in views:**

```php
<!-- Display data -->
<?php foreach ($posts['data'] as $post): ?>
    <!-- ... post content ... -->
<?php endforeach; ?>

<!-- Include pagination -->
<?php include __DIR__ . '/../partials/pagination.php'; $pagination = $posts; ?>
```

---

## Customizing Pagination

### Preserve Query Parameters

Maintain other query parameters (search, filters) when paginating:

```php
// Controller
public function index(Request $request): Response
{
    $page = (int) $request->input('page', 1);
    $search = $request->input('search', '');
    $status = $request->input('status', '');

    $query = Post::query();

    if ($search) {
        $query->where('title', 'LIKE', "%{$search}%");
    }

    if ($status) {
        $query->where('status', $status);
    }

    $posts = $query->paginate(15, $page);

    return Response::view('posts/index', [
        'posts' => $posts,
        'search' => $search,
        'status' => $status,
    ]);
}
```

**View:**

```php
<?php
function buildPaginationUrl($page, $params = []) {
    $query = array_merge($params, ['page' => $page]);
    return '?' . http_build_query($query);
}

$queryParams = [
    'search' => $search ?? '',
    'status' => $status ?? '',
];
?>

<a href="<?= buildPaginationUrl(1, $queryParams) ?>">First</a>
<a href="<?= buildPaginationUrl($posts['current_page'] + 1, $queryParams) ?>">Next</a>
```

### AJAX Pagination

Load pages without full page reload:

**View:**

```php
<div id="posts-container">
    <!-- Posts will be loaded here -->
</div>

<div id="pagination-container">
    <!-- Pagination links will be loaded here -->
</div>

<script>
function loadPage(page) {
    fetch(`/api/posts?page=${page}`)
        .then(response => response.json())
        .then(data => {
            // Render posts
            const postsHtml = data.data.map(post => `
                <article>
                    <h2>${post.title}</h2>
                    <p>${post.excerpt}</p>
                </article>
            `).join('');

            document.getElementById('posts-container').innerHTML = postsHtml;

            // Render pagination
            renderPagination(data);
        });
}

function renderPagination(pagination) {
    let html = '';

    // Previous button
    if (pagination.current_page > 1) {
        html += `<button onclick="loadPage(${pagination.current_page - 1})">Previous</button>`;
    }

    // Page numbers
    for (let i = 1; i <= pagination.last_page; i++) {
        if (i === pagination.current_page) {
            html += `<span class="active">${i}</span>`;
        } else {
            html += `<button onclick="loadPage(${i})">${i}</button>`;
        }
    }

    // Next button
    if (pagination.current_page < pagination.last_page) {
        html += `<button onclick="loadPage(${pagination.current_page + 1})">Next</button>`;
    }

    document.getElementById('pagination-container').innerHTML = html;
}

// Load first page on init
loadPage(1);
</script>
```

**Controller:**

```php
public function apiIndex(Request $request): Response
{
    $page = (int) $request->input('page', 1);
    $posts = Post::query()->paginate(15, $page);

    return Response::json($posts);
}
```

### Infinite Scroll Pagination

```html
<div id="posts-container"></div>
<div id="loading" style="display: none;">Loading...</div>

<script>
let currentPage = 1;
let loading = false;
let hasMore = true;

function loadMorePosts() {
    if (loading || !hasMore) return;

    loading = true;
    document.getElementById('loading').style.display = 'block';

    fetch(`/api/posts?page=${currentPage}`)
        .then(response => response.json())
        .then(data => {
            // Append posts
            const postsHtml = data.data.map(post => `
                <article>
                    <h2>${post.title}</h2>
                    <p>${post.excerpt}</p>
                </article>
            `).join('');

            document.getElementById('posts-container').insertAdjacentHTML('beforeend', postsHtml);

            // Update state
            currentPage++;
            hasMore = data.current_page < data.last_page;
            loading = false;
            document.getElementById('loading').style.display = 'none';
        });
}

// Load first page
loadMorePosts();

// Load more on scroll
window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
        loadMorePosts();
    }
});
</script>
```

---

## Complete Examples

### Example 1: User List with Pagination

**Controller:**

```php
namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;
use App\Models\User;

class UserController
{
    public function index(Request $request): Response
    {
        $page = max(1, (int) $request->input('page', 1));
        $search = $request->input('search', '');

        $query = User::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20, $page);

        return Response::view('users/index', [
            'users' => $users,
            'search' => $search,
        ]);
    }
}
```

**View:**

```php
<h1>Users</h1>

<form method="GET" action="/users">
    <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search users...">
    <button type="submit">Search</button>
</form>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Joined</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users['data'] as $user): ?>
            <tr>
                <td><?= e($user['name']) ?></td>
                <td><?= e($user['email']) ?></td>
                <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p>Showing <?= $users['from'] ?> to <?= $users['to'] ?> of <?= $users['total'] ?> users</p>

<?php include __DIR__ . '/../partials/pagination.php'; $pagination = $users; ?>
```

### Example 2: API Pagination with Caching

```php
use Core\Database\DB;

public function apiPosts(Request $request): Response
{
    $page = max(1, (int) $request->input('page', 1));
    $perPage = max(10, min(100, (int) $request->input('per_page', 15)));

    // Cache pagination results
    $cacheKey = "posts.page.{$page}.{$perPage}";

    $posts = cache()->remember($cacheKey, 300, function() use ($page, $perPage) {
        return Post::where('published', true)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, $page);
    });

    return Response::json($posts);
}
```

---

**Related Documentation:**
- [Models](/docs/dev/models) - Database models
- [API Controllers](/docs/dev/api-controllers) - API development
- [Caching](/docs/dev/caching) - Cache pagination results

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
