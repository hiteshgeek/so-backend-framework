<?php
/**
 * UiEngine Tables Guide
 *
 * Step-by-step guide to building data tables with UiEngine.
 */

$pageTitle = 'UiEngine Tables Guide';
$pageIcon = 'table';
$toc = [
    ['id' => 'introduction', 'title' => 'Introduction', 'level' => 2],
    ['id' => 'step-1-basic-table', 'title' => 'Step 1: Basic Table', 'level' => 2],
    ['id' => 'step-2-styling', 'title' => 'Step 2: Table Styling', 'level' => 2],
    ['id' => 'step-3-actions', 'title' => 'Step 3: Row Actions', 'level' => 2],
    ['id' => 'step-4-pagination', 'title' => 'Step 4: Pagination', 'level' => 2],
    ['id' => 'step-5-sorting', 'title' => 'Step 5: Sorting', 'level' => 2],
    ['id' => 'step-6-server-data', 'title' => 'Step 6: Server-Side Data', 'level' => 2],
    ['id' => 'step-7-complete-crud', 'title' => 'Step 7: Complete CRUD Table', 'level' => 2],
    ['id' => 'common-patterns', 'title' => 'Common Patterns', 'level' => 2],
    ['id' => 'troubleshooting', 'title' => 'Troubleshooting', 'level' => 2],
];
$breadcrumbs = [['label' => 'Development', 'url' => '/docs#dev-panel'], ['label' => 'UiEngine Tables Guide']];
$lastUpdated = '2026-02-03';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="dev-ui-engine-tables" class="heading heading-1">
    <span class="mdi mdi-table heading-icon"></span>
    <span class="heading-text">UiEngine Tables Guide</span>
</h1>

<p class="text-lead">
    Step-by-step guide to building data tables with UiEngine. From basic tables to fully-featured CRUD tables with pagination, sorting, and actions.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-guide">Guide</span>
    <span class="badge badge-new">New</span>
    <span class="badge badge-step-by-step">Step-by-Step</span>
</div>

<!-- Introduction -->
<h2 id="introduction" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Introduction</span>
</h2>

<p>
    UiEngine's <code>Table</code> element provides a powerful way to display tabular data with consistent styling, responsive behavior, and interactive features.
</p>

<?= callout('info', '
    <strong>Table Features:</strong>
    <ul class="so-mb-0">
        <li>Responsive design with horizontal scrolling on mobile</li>
        <li>Striped, bordered, and hoverable variants</li>
        <li>Built-in pagination component</li>
        <li>Sortable columns</li>
        <li>Row actions with dropdowns</li>
        <li>Status badges and formatting helpers</li>
    </ul>
') ?>

<!-- Step 1: Basic Table -->
<h2 id="step-1-basic-table" class="heading heading-2">
    <span class="mdi mdi-numeric-1-circle heading-icon"></span>
    <span class="heading-text">Step 1: Basic Table</span>
</h2>

<p>
    Create a simple table with headers and rows.
</p>

<?= codeTabs('step1', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Basic table with array of headers and rows
$table = UiEngine::table([\'ID\', \'Name\', \'Email\', \'Role\'])
    ->rows([
        [1, \'John Doe\', \'john@example.com\', \'Admin\'],
        [2, \'Jane Smith\', \'jane@example.com\', \'User\'],
        [3, \'Bob Wilson\', \'bob@example.com\', \'Editor\'],
    ]);

echo $table->render();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => '// Same API in JavaScript
const table = UiEngine.table([\'ID\', \'Name\', \'Email\', \'Role\'])
    .rows([
        [1, \'John Doe\', \'john@example.com\', \'Admin\'],
        [2, \'Jane Smith\', \'jane@example.com\', \'User\'],
        [3, \'Bob Wilson\', \'bob@example.com\', \'Editor\'],
    ]);

document.getElementById(\'container\').innerHTML = table.toHtml();'
    ],
    [
        'label' => 'HTML Output',
        'language' => 'html',
        'code' => '<div class="so-table-responsive">
    <table class="so-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>Admin</td>
            </tr>
            <!-- more rows... -->
        </tbody>
    </table>
</div>'
    ],
]) ?>

<!-- Step 2: Styling -->
<h2 id="step-2-styling" class="heading heading-2">
    <span class="mdi mdi-numeric-2-circle heading-icon"></span>
    <span class="heading-text">Step 2: Table Styling</span>
</h2>

<p>
    Apply different visual styles to the table.
</p>

<?= codeTabs('step2', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Striped rows
$table = UiEngine::table([\'ID\', \'Name\', \'Email\'])
    ->rows($users)
    ->striped();

// Bordered table
$table = UiEngine::table([\'ID\', \'Name\', \'Email\'])
    ->rows($users)
    ->bordered();

// Hover effect on rows
$table = UiEngine::table([\'ID\', \'Name\', \'Email\'])
    ->rows($users)
    ->hover();

// Combine multiple styles
$table = UiEngine::table([\'ID\', \'Name\', \'Email\'])
    ->rows($users)
    ->striped()
    ->bordered()
    ->hover();

// Small/compact table
$table = UiEngine::table([\'ID\', \'Name\', \'Email\'])
    ->rows($users)
    ->small();

// Dark header
$table = UiEngine::table([\'ID\', \'Name\', \'Email\'])
    ->rows($users)
    ->darkHeader();'
    ],
    [
        'label' => 'Table in Card',
        'language' => 'php',
        'code' => '<?php
// Table inside a card (common pattern)
echo UiEngine::card()
    ->header(\'<h5 class="so-mb-0">Users</h5>\')
    ->noPadding()  // Remove card padding for full-width table
    ->add(
        UiEngine::table([\'ID\', \'Name\', \'Email\', \'Role\'])
            ->rows($users)
            ->striped()
            ->hover()
    )
    ->render();'
    ],
]) ?>

<!-- Step 3: Actions -->
<h2 id="step-3-actions" class="heading heading-2">
    <span class="mdi mdi-numeric-3-circle heading-icon"></span>
    <span class="heading-text">Step 3: Row Actions</span>
</h2>

<p>
    Add action buttons or dropdowns to each row.
</p>

<?= codeTabs('step3', [
    [
        'label' => 'Basic Actions',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Simple action links
$rows = [];
foreach ($users as $user) {
    $rows[] = [
        $user->id,
        $user->name,
        $user->email,
        \'<a href="/users/\' . $user->id . \'/edit" class="so-btn so-btn-sm so-btn-primary">Edit</a>
         <a href="/users/\' . $user->id . \'" class="so-btn so-btn-sm so-btn-danger"
            onclick="return confirm(\'Delete this user?\')" data-method="DELETE">Delete</a>\'
    ];
}

echo UiEngine::table([\'ID\', \'Name\', \'Email\', \'Actions\'])
    ->rows($rows)
    ->striped()
    ->hover()
    ->render();'
    ],
    [
        'label' => 'Dropdown Actions',
        'language' => 'php',
        'code' => '<?php
// Action dropdown menu
function actionDropdown(int $id): string
{
    return UiEngine::dropdown()
        ->trigger(
            UiEngine::button(\'Actions\')
                ->secondary()
                ->small()
                ->icon(\'dots-vertical\')
        )
        ->item(\'View\', "/users/{$id}", \'eye\')
        ->item(\'Edit\', "/users/{$id}/edit", \'pencil\')
        ->divider()
        ->item(\'Delete\', "/users/{$id}", \'delete\', \'danger\')
            ->attr(\'data-method\', \'DELETE\')
            ->attr(\'data-confirm\', \'Are you sure?\')
        ->render();
}

$rows = [];
foreach ($users as $user) {
    $rows[] = [
        $user->id,
        $user->name,
        $user->email,
        actionDropdown($user->id)
    ];
}

echo UiEngine::table([\'ID\', \'Name\', \'Email\', \'Actions\'])
    ->rows($rows)
    ->render();'
    ],
]) ?>

<!-- Step 4: Pagination -->
<h2 id="step-4-pagination" class="heading heading-2">
    <span class="mdi mdi-numeric-4-circle heading-icon"></span>
    <span class="heading-text">Step 4: Pagination</span>
</h2>

<p>
    Add pagination for large datasets.
</p>

<?= codeTabs('step4', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// In your controller
$page = (int) ($_GET[\'page\'] ?? 1);
$perPage = 10;
$total = User::count();
$users = User::limit($perPage)->offset(($page - 1) * $perPage)->get();

// Build table
$table = UiEngine::table([\'ID\', \'Name\', \'Email\', \'Role\'])
    ->rows(array_map(fn($u) => [$u->id, $u->name, $u->email, $u->role], $users))
    ->striped()
    ->hover();

// Build pagination
$pagination = UiEngine::pagination()
    ->total($total)
    ->perPage($perPage)
    ->current($page)
    ->url(\'/users?page={page}\');

// Render table and pagination
echo UiEngine::card()
    ->header(\'
        <div class="so-d-flex so-justify-content-between so-align-items-center">
            <h5 class="so-mb-0">Users</h5>
            <span class="so-badge so-bg-secondary">\' . $total . \' total</span>
        </div>
    \')
    ->noPadding()
    ->add($table)
    ->footer($pagination->render())
    ->render();'
    ],
    [
        'label' => 'Pagination Options',
        'language' => 'php',
        'code' => '<?php
// Pagination with options
$pagination = UiEngine::pagination()
    ->total(100)
    ->perPage(10)
    ->current(3)
    ->url(\'/users?page={page}\')
    ->showInfo()           // Show "Showing 21-30 of 100"
    ->showFirstLast()      // Show first/last page buttons
    ->maxLinks(5);         // Max page links to show

// Simple prev/next pagination
$pagination = UiEngine::pagination()
    ->total(100)
    ->perPage(10)
    ->current(3)
    ->url(\'/users?page={page}\')
    ->simple();  // Only prev/next buttons

// Pagination with size selector
echo \'<div class="so-d-flex so-justify-content-between so-align-items-center">\';
echo $pagination->render();
echo UiEngine::select(\'per_page\')
    ->options([10 => \'10\', 25 => \'25\', 50 => \'50\', 100 => \'100\'])
    ->value($perPage)
    ->attr(\'onchange\', \'window.location.href="?per_page=" + this.value\')
    ->addClass(\'so-form-select-sm\')
    ->style(\'width: auto\')
    ->render();
echo \'</div>\';'
    ],
]) ?>

<!-- Step 5: Sorting -->
<h2 id="step-5-sorting" class="heading heading-2">
    <span class="mdi mdi-numeric-5-circle heading-icon"></span>
    <span class="heading-text">Step 5: Sorting</span>
</h2>

<p>
    Enable column sorting with visual indicators.
</p>

<?= codeTabs('step5', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Get sort parameters
$sortBy = $_GET[\'sort\'] ?? \'id\';
$sortDir = $_GET[\'dir\'] ?? \'asc\';

// Build sortable header
function sortableHeader(string $column, string $label, string $currentSort, string $currentDir): string
{
    $isActive = $currentSort === $column;
    $nextDir = ($isActive && $currentDir === \'asc\') ? \'desc\' : \'asc\';
    $icon = $isActive ? ($currentDir === \'asc\' ? \'arrow-up\' : \'arrow-down\') : \'swap-vertical\';

    return "<a href=\"?sort={$column}&dir={$nextDir}\" class=\"so-text-decoration-none\">
        {$label} <span class=\"mdi mdi-{$icon}\"></span>
    </a>";
}

// Query with sorting
$users = User::orderBy($sortBy, $sortDir)->get();

// Build table with sortable headers
$headers = [
    sortableHeader(\'id\', \'ID\', $sortBy, $sortDir),
    sortableHeader(\'name\', \'Name\', $sortBy, $sortDir),
    sortableHeader(\'email\', \'Email\', $sortBy, $sortDir),
    \'Role\',
    \'Actions\'
];

echo UiEngine::table($headers)
    ->rows($rows)
    ->striped()
    ->hover()
    ->render();'
    ],
    [
        'label' => 'Built-in Sorting',
        'language' => 'php',
        'code' => '<?php
// Using table\'s built-in sorting support
$table = UiEngine::table()
    ->columns([
        [\'key\' => \'id\', \'label\' => \'ID\', \'sortable\' => true],
        [\'key\' => \'name\', \'label\' => \'Name\', \'sortable\' => true],
        [\'key\' => \'email\', \'label\' => \'Email\', \'sortable\' => true],
        [\'key\' => \'role\', \'label\' => \'Role\'],
        [\'key\' => \'actions\', \'label\' => \'Actions\'],
    ])
    ->sortBy($sortBy)
    ->sortDir($sortDir)
    ->sortUrl(\'/users?sort={column}&dir={direction}\')
    ->rows($rows);

echo $table->render();'
    ],
]) ?>

<!-- Step 6: Server Data -->
<h2 id="step-6-server-data" class="heading heading-2">
    <span class="mdi mdi-numeric-6-circle heading-icon"></span>
    <span class="heading-text">Step 6: Server-Side Data</span>
</h2>

<p>
    Build tables from database queries with formatting helpers.
</p>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

class UserController
{
    public function index()
    {
        // Get query parameters
        $page = (int) ($_GET[\'page\'] ?? 1);
        $perPage = (int) ($_GET[\'per_page\'] ?? 10);
        $sortBy = $_GET[\'sort\'] ?? \'created_at\';
        $sortDir = $_GET[\'dir\'] ?? \'desc\';
        $search = $_GET[\'search\'] ?? \'\';

        // Build query
        $query = User::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where(\'name\', \'LIKE\', "%{$search}%")
                  ->orWhere(\'email\', \'LIKE\', "%{$search}%");
            });
        }

        $total = $query->count();
        $users = $query
            ->orderBy($sortBy, $sortDir)
            ->limit($perPage)
            ->offset(($page - 1) * $perPage)
            ->get();

        // Format rows with helpers
        $rows = [];
        foreach ($users as $user) {
            $rows[] = [
                $user->id,
                \'<div class="so-d-flex so-align-items-center">
                    <img src="\' . ($user->avatar ?: \'/images/default-avatar.png\') . \'"
                         class="so-rounded-circle so-me-2" width="32" height="32">
                    <div>
                        <div>\' . e($user->name) . \'</div>
                        <small class="so-text-muted">\' . e($user->email) . \'</small>
                    </div>
                </div>\',
                $this->formatRole($user->role),
                $this->formatStatus($user->active),
                $user->created_at->format(\'M j, Y\'),
                $this->actionButtons($user->id),
            ];
        }

        // Build the complete table view
        return view(\'users.index\', [
            \'table\' => UiEngine::table([\'ID\', \'User\', \'Role\', \'Status\', \'Joined\', \'Actions\'])
                ->rows($rows)
                ->striped()
                ->hover(),
            \'pagination\' => UiEngine::pagination()
                ->total($total)
                ->perPage($perPage)
                ->current($page)
                ->url($this->buildUrl($search, $sortBy, $sortDir)),
            \'search\' => $search,
            \'total\' => $total,
        ]);
    }

    private function formatRole(string $role): string
    {
        $colors = [
            \'admin\' => \'danger\',
            \'manager\' => \'warning\',
            \'user\' => \'secondary\',
        ];
        return \'<span class="so-badge so-bg-\' . ($colors[$role] ?? \'secondary\') . \'">\'
             . ucfirst($role) . \'</span>\';
    }

    private function formatStatus(bool $active): string
    {
        return $active
            ? \'<span class="so-badge so-bg-success">Active</span>\'
            : \'<span class="so-badge so-bg-danger">Inactive</span>\';
    }

    private function actionButtons(int $id): string
    {
        return \'<div class="so-btn-group so-btn-group-sm">
            <a href="/users/\' . $id . \'" class="so-btn so-btn-outline-secondary" title="View">
                <span class="mdi mdi-eye"></span>
            </a>
            <a href="/users/\' . $id . \'/edit" class="so-btn so-btn-outline-primary" title="Edit">
                <span class="mdi mdi-pencil"></span>
            </a>
            <button type="button" class="so-btn so-btn-outline-danger" title="Delete"
                    onclick="deleteUser(\' . $id . \')">
                <span class="mdi mdi-delete"></span>
            </button>
        </div>\';
    }
}') ?>

<!-- Step 7: Complete CRUD -->
<h2 id="step-7-complete-crud" class="heading heading-2">
    <span class="mdi mdi-numeric-7-circle heading-icon"></span>
    <span class="heading-text">Step 7: Complete CRUD Table</span>
</h2>

<p>
    A complete example combining search, sorting, pagination, and actions.
</p>

<?= codeBlock('php', '<?php
// resources/views/users/index.php
use Core\UiEngine\UiEngine;
?>

<div class="so-container-fluid so-py-4">
    <!-- Page Header -->
    <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-4">
        <h1 class="so-h3 so-mb-0">Users</h1>
        <a href="/users/create" class="so-btn so-btn-primary">
            <span class="mdi mdi-plus"></span> Add User
        </a>
    </div>

    <!-- Search & Filters Card -->
    <?= UiEngine::card()
        ->addClass(\'so-mb-4\')
        ->body(
            UiEngine::form(\'\')
                ->method(\'GET\')
                ->inline()
                ->add(
                    UiEngine::input(\'search\')
                        ->placeholder(\'Search users...\')
                        ->value($search ?? \'\')
                        ->addClass(\'so-me-2\')
                        ->style(\'width: 300px\')
                )
                ->add(
                    UiEngine::select(\'role\')
                        ->placeholder(\'All Roles\')
                        ->options([
                            \'admin\' => \'Admin\',
                            \'manager\' => \'Manager\',
                            \'user\' => \'User\',
                        ])
                        ->value($filterRole ?? \'\')
                        ->addClass(\'so-me-2\')
                )
                ->add(
                    UiEngine::submit(\'Search\')
                        ->icon(\'magnify\')
                )
                ->render()
        )
        ->render()
    ?>

    <!-- Data Table Card -->
    <?= UiEngine::card()
        ->header(\'
            <div class="so-d-flex so-justify-content-between so-align-items-center">
                <h5 class="so-mb-0">All Users</h5>
                <span class="so-badge so-bg-secondary">\' . number_format($total) . \' users</span>
            </div>
        \')
        ->noPadding()
        ->add($table)
        ->footer(\'
            <div class="so-d-flex so-justify-content-between so-align-items-center">
                <div class="so-text-muted so-small">
                    Showing \' . (($page - 1) * $perPage + 1) . \'-\' . min($page * $perPage, $total) . \' of \' . $total . \'
                </div>
                \' . $pagination->render() . \'
            </div>
        \')
        ->render()
    ?>
</div>

<!-- Delete Confirmation Modal -->
<?= UiEngine::modal(\'delete-modal\')
    ->title(\'Confirm Delete\')
    ->body(\'<p>Are you sure you want to delete this user? This action cannot be undone.</p>\')
    ->footer(\'
        <button type="button" class="so-btn so-btn-secondary" data-so-dismiss="modal">Cancel</button>
        <form id="delete-form" method="POST" style="display: inline">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="\' . csrf_token() . \'">
            <button type="submit" class="so-btn so-btn-danger">Delete</button>
        </form>
    \')
    ->render()
?>

<script>
function deleteUser(id) {
    document.getElementById(\'delete-form\').action = \'/users/\' + id;
    new SOModal(document.getElementById(\'delete-modal\')).show();
}
</script>') ?>

<!-- Common Patterns -->
<h2 id="common-patterns" class="heading heading-2">
    <span class="mdi mdi-puzzle heading-icon"></span>
    <span class="heading-text">Common Patterns</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">List Group Alternative</span>
</h3>

<?= codeBlock('php', '// For simpler lists, use ListGroup
echo UiEngine::listGroup()
    ->item(\'Item 1\', \'/item/1\')
    ->item(\'Item 2\', \'/item/2\', true)  // Active
    ->item(\'Item 3\', \'/item/3\')
    ->flush()
    ->render();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Status Badges Helper</span>
</h3>

<?= codeBlock('php', '// Reusable status badge function
function statusBadge(string $status): string
{
    $config = [
        \'active\'    => [\'bg-success\', \'Active\'],
        \'inactive\'  => [\'bg-secondary\', \'Inactive\'],
        \'pending\'   => [\'bg-warning\', \'Pending\'],
        \'approved\'  => [\'bg-success\', \'Approved\'],
        \'rejected\'  => [\'bg-danger\', \'Rejected\'],
        \'draft\'     => [\'bg-info\', \'Draft\'],
        \'published\' => [\'bg-primary\', \'Published\'],
    ];

    $class = $config[$status][0] ?? \'bg-secondary\';
    $label = $config[$status][1] ?? ucfirst($status);

    return "<span class=\"so-badge so-{$class}\">{$label}</span>";
}') ?>

<!-- Troubleshooting -->
<h2 id="troubleshooting" class="heading heading-2">
    <span class="mdi mdi-help-circle heading-icon"></span>
    <span class="heading-text">Troubleshooting</span>
</h2>

<?= callout('warning', '
    <strong>Table Overflows Container</strong><br>
    Tables are responsive by default. If content overflows, ensure the table is wrapped:
    <pre class="so-mb-0"><code>// Tables automatically wrap in so-table-responsive
// If manually building, add:
&lt;div class="so-table-responsive"&gt;
    &lt;table class="so-table"&gt;...&lt;/table&gt;
&lt;/div&gt;</code></pre>
') ?>

<?= callout('warning', '
    <strong>HTML in Cells Not Rendering</strong><br>
    By default, cell content is escaped. To render HTML:
    <pre class="so-mb-0"><code>// Cell content is rendered as-is (HTML allowed)
// Ensure you escape user-generated content with e():
$rows[] = [e($user->name), statusBadge($user->status)];</code></pre>
') ?>

<?= callout('info', '
    <strong>See Also:</strong>
    <ul class="so-mb-0">
        <li><a href="/docs/dev-ui-engine">UiEngine Developer Guide</a></li>
        <li><a href="/docs/dev-ui-engine-elements">Element Reference</a></li>
        <li><a href="/docs/dev-pagination">Pagination Guide</a></li>
    </ul>
') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
