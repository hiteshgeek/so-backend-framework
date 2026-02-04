<?php
/**
 * SixOrbit UI Engine - Table Element Demo
 */

$pageTitle = 'Table - UI Engine';
$pageDescription = 'Data table with sorting, pagination, and actions';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Table</h1>
            <p class="so-page-subtitle">Data table element with sorting, pagination, search, and row actions.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Table -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Table</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <table class="so-table so-mb-4">
                    <thead>
                        <tr>
                            <th>#</th>
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
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>jane@example.com</td>
                            <td>Editor</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Bob Wilson</td>
                            <td>bob@example.com</td>
                            <td>User</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-table', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$table = UiEngine::table()
    ->columns(['#', 'Name', 'Email', 'Role'])
    ->rows([
        [1, 'John Doe', 'john@example.com', 'Admin'],
        [2, 'Jane Smith', 'jane@example.com', 'Editor'],
        [3, 'Bob Wilson', 'bob@example.com', 'User'],
    ]);

echo \$table->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const table = UiEngine.table()
    .columns(['#', 'Name', 'Email', 'Role'])
    .rows([
        [1, 'John Doe', 'john@example.com', 'Admin'],
        [2, 'Jane Smith', 'jane@example.com', 'Editor'],
        [3, 'Bob Wilson', 'bob@example.com', 'User'],
    ]);

document.getElementById('container').innerHTML = table.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<table class="so-table">
    <thead>
        <tr>
            <th>#</th>
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
        ...
    </tbody>
</table>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Table Styles -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Table Styles</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Different style variations for tables.</p>

                <!-- Live Demo - Striped -->
                <h5 class="so-mb-3">Striped Rows</h5>
                <table class="so-table so-table-striped so-mb-4">
                    <thead>
                        <tr><th>#</th><th>Name</th><th>Email</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>1</td><td>John Doe</td><td>john@example.com</td></tr>
                        <tr><td>2</td><td>Jane Smith</td><td>jane@example.com</td></tr>
                        <tr><td>3</td><td>Bob Wilson</td><td>bob@example.com</td></tr>
                        <tr><td>4</td><td>Alice Brown</td><td>alice@example.com</td></tr>
                    </tbody>
                </table>

                <!-- Live Demo - Bordered + Hover -->
                <h5 class="so-mb-3">Bordered with Hover</h5>
                <table class="so-table so-table-bordered so-table-hover so-mb-4">
                    <thead>
                        <tr><th>#</th><th>Name</th><th>Email</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>1</td><td>John Doe</td><td>john@example.com</td></tr>
                        <tr><td>2</td><td>Jane Smith</td><td>jane@example.com</td></tr>
                        <tr><td>3</td><td>Bob Wilson</td><td>bob@example.com</td></tr>
                    </tbody>
                </table>

                <!-- Live Demo - Small -->
                <h5 class="so-mb-3">Compact/Small Table</h5>
                <table class="so-table so-table-sm so-table-bordered so-mb-4">
                    <thead>
                        <tr><th>#</th><th>Name</th><th>Email</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>1</td><td>John Doe</td><td>john@example.com</td></tr>
                        <tr><td>2</td><td>Jane Smith</td><td>jane@example.com</td></tr>
                        <tr><td>3</td><td>Bob Wilson</td><td>bob@example.com</td></tr>
                    </tbody>
                </table>

                <!-- Code Tabs -->
                <?= so_code_tabs('table-styles', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Striped rows
UiEngine::table()->striped()->columns([...])->rows([...]);

// Bordered table
UiEngine::table()->bordered()->columns([...])->rows([...]);

// Hover effect on rows
UiEngine::table()->hover()->columns([...])->rows([...]);

// Small/compact table
UiEngine::table()->small()->columns([...])->rows([...]);

// Dark theme
UiEngine::table()->dark()->columns([...])->rows([...]);

// Responsive wrapper
UiEngine::table()->responsive()->columns([...])->rows([...]);

// Combined styles
UiEngine::table()
    ->striped()
    ->hover()
    ->bordered()
    ->responsive()
    ->columns([...])
    ->rows([...]);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Striped rows
UiEngine.table().striped().columns([...]).rows([...]);

// Bordered table
UiEngine.table().bordered().columns([...]).rows([...]);

// Hover effect on rows
UiEngine.table().hover().columns([...]).rows([...]);

// Combined styles
UiEngine.table()
    .striped()
    .hover()
    .bordered()
    .responsive()
    .columns([...])
    .rows([...]);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Striped table -->
<table class="so-table so-table-striped">...</table>

<!-- Bordered table -->
<table class="so-table so-table-bordered">...</table>

<!-- Hover table -->
<table class="so-table so-table-hover">...</table>

<!-- Small/compact table -->
<table class="so-table so-table-sm">...</table>

<!-- Responsive wrapper -->
<div class="so-table-responsive">
    <table class="so-table">...</table>
</div>

<!-- Combined -->
<div class="so-table-responsive">
    <table class="so-table so-table-striped so-table-hover so-table-bordered">...</table>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Data Keys -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Data Objects</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Tables can be populated using data objects with column key mappings.</p>

                <!-- Live Demo -->
                <div class="so-table-responsive so-mb-4">
                    <table class="so-table so-table-striped so-table-hover">
                        <thead class="so-table-light">
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td><span class="so-badge so-badge-success">Active</span></td>
                                <td>Jan 15, 2026</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td><span class="so-badge so-badge-warning">Pending</span></td>
                                <td>Jan 18, 2026</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Bob Wilson</td>
                                <td>bob@example.com</td>
                                <td><span class="so-badge so-badge-success">Active</span></td>
                                <td>Jan 20, 2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('table-data', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Define columns with data keys
\$table = UiEngine::table()
    ->columns([
        ['key' => 'id', 'label' => 'ID', 'width' => '60px'],
        ['key' => 'name', 'label' => 'Name', 'sortable' => true],
        ['key' => 'email', 'label' => 'Email', 'sortable' => true],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'created_at', 'label' => 'Created', 'format' => 'date'],
    ])
    ->data(\$users); // Array of objects/arrays

echo \$table->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const table = UiEngine.table()
    .columns([
        {key: 'id', label: 'ID', width: '60px'},
        {key: 'name', label: 'Name', sortable: true},
        {key: 'email', label: 'Email', sortable: true},
        {key: 'status', label: 'Status'},
        {key: 'created_at', label: 'Created', format: 'date'},
    ])
    .data(users);

document.getElementById('container').innerHTML = table.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-table-responsive">
    <table class="so-table so-table-striped so-table-hover">
        <thead class="so-table-light">
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td><span class="so-badge so-badge-success">Active</span></td>
                <td>Jan 15, 2026</td>
            </tr>
            <!-- More rows... -->
        </tbody>
    </table>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Actions -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Row Actions</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add action buttons to each row for view, edit, delete operations.</p>

                <!-- Live Demo -->
                <div class="so-table-responsive so-mb-4">
                    <table class="so-table so-table-hover">
                        <thead class="so-table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="so-text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td class="so-text-end">
                                    <div class="so-btn-group so-btn-group-sm">
                                        <button class="so-btn so-btn-info so-btn-sm" title="View"><span class="material-icons">visibility</span></button>
                                        <button class="so-btn so-btn-primary so-btn-sm" title="Edit"><span class="material-icons">edit</span></button>
                                        <button class="so-btn so-btn-danger so-btn-sm" title="Delete"><span class="material-icons">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td class="so-text-end">
                                    <div class="so-btn-group so-btn-group-sm">
                                        <button class="so-btn so-btn-info so-btn-sm" title="View"><span class="material-icons">visibility</span></button>
                                        <button class="so-btn so-btn-primary so-btn-sm" title="Edit"><span class="material-icons">edit</span></button>
                                        <button class="so-btn so-btn-danger so-btn-sm" title="Delete"><span class="material-icons">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Bob Wilson</td>
                                <td>bob@example.com</td>
                                <td class="so-text-end">
                                    <div class="so-btn-group so-btn-group-sm">
                                        <button class="so-btn so-btn-info so-btn-sm" title="View"><span class="material-icons">visibility</span></button>
                                        <button class="so-btn so-btn-primary so-btn-sm" title="Edit"><span class="material-icons">edit</span></button>
                                        <button class="so-btn so-btn-danger so-btn-sm" title="Delete"><span class="material-icons">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('table-actions', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$table = UiEngine::table()
    ->columns(['ID', 'Name', 'Email', 'Actions'])
    ->actions([
        UiEngine::button()->icon('visibility')->variant('info')->size('sm')
            ->attr('data-action', 'view'),
        UiEngine::button()->icon('edit')->variant('primary')->size('sm')
            ->attr('data-action', 'edit'),
        UiEngine::button()->icon('delete')->variant('danger')->size('sm')
            ->attr('data-action', 'delete'),
    ])
    ->data(\$users);

echo \$table->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const table = UiEngine.table()
    .columns(['ID', 'Name', 'Email', 'Actions'])
    .actions([
        {icon: 'visibility', variant: 'info', onClick: (row) => viewUser(row)},
        {icon: 'edit', variant: 'primary', onClick: (row) => editUser(row)},
        {icon: 'delete', variant: 'danger', onClick: (row) => deleteUser(row)},
    ])
    .data(users);

document.getElementById('container').innerHTML = table.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-table-responsive">
    <table class="so-table so-table-hover">
        <thead class="so-table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th class="so-text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td class="so-text-end">
                    <div class="so-btn-group so-btn-group-sm">
                        <button class="so-btn so-btn-info so-btn-sm" title="View">
                            <span class="material-icons">visibility</span>
                        </button>
                        <button class="so-btn so-btn-primary so-btn-sm" title="Edit">
                            <span class="material-icons">edit</span>
                        </button>
                        <button class="so-btn so-btn-danger so-btn-sm" title="Delete">
                            <span class="material-icons">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
            <!-- More rows... -->
        </tbody>
    </table>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Pagination -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Pagination</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add pagination controls for large datasets.</p>

                <!-- Live Demo -->
                <div class="so-table-responsive so-mb-4">
                    <table class="so-table so-table-striped">
                        <thead class="so-table-light">
                            <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>John Doe</td><td>john@example.com</td><td>Admin</td></tr>
                            <tr><td>2</td><td>Jane Smith</td><td>jane@example.com</td><td>Editor</td></tr>
                            <tr><td>3</td><td>Bob Wilson</td><td>bob@example.com</td><td>User</td></tr>
                            <tr><td>4</td><td>Alice Brown</td><td>alice@example.com</td><td>User</td></tr>
                            <tr><td>5</td><td>Charlie Davis</td><td>charlie@example.com</td><td>Editor</td></tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-4">
                    <span class="so-text-muted">Showing 1-5 of 150 entries</span>
                    <nav class="so-pagination">
                        <ul class="so-pagination-nav">
                            <li class="so-page-item so-disabled">
                                <a class="so-page-link" href="#" aria-disabled="true">
                                    <span class="material-icons">chevron_left</span>
                                </a>
                            </li>
                            <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">1</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            <li class="so-page-item so-disabled"><a class="so-page-link" href="#">...</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">15</a></li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#">
                                    <span class="material-icons">chevron_right</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('table-pagination', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$table = UiEngine::table()
    ->columns([...])
    ->data(\$users)
    ->pagination([
        'total' => 150,
        'perPage' => 10,
        'currentPage' => 1,
    ]);

// Or with Laravel pagination
\$table = UiEngine::table()
    ->columns([...])
    ->paginate(\$users); // LengthAwarePaginator

echo \$table->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const table = UiEngine.table()
    .columns([...])
    .data(users)
    .pagination({
        total: 150,
        perPage: 10,
        currentPage: 1,
    })
    .onPageChange((page) => {
        fetchData(page);
    });

document.getElementById('container').innerHTML = table.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-table-responsive">
    <table class="so-table so-table-striped">
        <thead class="so-table-light">
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>
        </thead>
        <tbody>
            <!-- Table rows -->
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="so-d-flex so-justify-content-between so-align-items-center">
    <span class="so-text-muted">Showing 1-10 of 150 entries</span>
    <nav class="so-pagination">
        <ul class="so-pagination-nav">
            <li class="so-page-item so-disabled">
                <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
            </li>
            <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
            <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
            <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
            <li class="so-page-item">
                <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
            </li>
        </ul>
    </nav>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Sortable and Searchable -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Sortable and Searchable</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Enable column sorting and global search functionality.</p>

                <!-- Live Demo -->
                <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-3">
                    <div class="so-d-flex so-align-items-center so-gap-2">
                        <label class="so-text-muted so-mb-0">Show</label>
                        <select class="so-form-control" data-so-select data-so-size="sm" style="width: 80px;" id="demo-perpage">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <label class="so-text-muted so-mb-0">entries</label>
                    </div>
                    <div class="so-input-group so-input-group-sm" style="width: 250px;">
                        <span class="so-input-addon"><span class="material-icons">search</span></span>
                        <input type="text" class="so-form-control so-form-control-sm" placeholder="Search..." id="demo-search">
                    </div>
                </div>
                <div class="so-table-responsive so-mb-4">
                    <table class="so-table so-table-hover" id="demo-sortable-table">
                        <thead class="so-table-light">
                            <tr>
                                <th style="cursor: pointer;" data-sort="name" data-direction="asc" class="sortable sorted">
                                    Name <span class="material-icons sort-icon" style="font-size: 16px; vertical-align: middle;">arrow_upward</span>
                                </th>
                                <th style="cursor: pointer;" data-sort="email" class="sortable">
                                    Email <span class="material-icons sort-icon" style="font-size: 16px; vertical-align: middle; opacity: 0.3;">unfold_more</span>
                                </th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-name="Alice Brown" data-email="alice@example.com"><td>Alice Brown</td><td>alice@example.com</td><td>User</td><td><span class="so-badge so-badge-success">Active</span></td></tr>
                            <tr data-name="Bob Wilson" data-email="bob@example.com"><td>Bob Wilson</td><td>bob@example.com</td><td>User</td><td><span class="so-badge so-badge-success">Active</span></td></tr>
                            <tr data-name="Charlie Davis" data-email="charlie@example.com"><td>Charlie Davis</td><td>charlie@example.com</td><td>Editor</td><td><span class="so-badge so-badge-warning">Pending</span></td></tr>
                            <tr data-name="Jane Smith" data-email="jane@example.com"><td>Jane Smith</td><td>jane@example.com</td><td>Editor</td><td><span class="so-badge so-badge-success">Active</span></td></tr>
                            <tr data-name="John Doe" data-email="john@example.com"><td>John Doe</td><td>john@example.com</td><td>Admin</td><td><span class="so-badge so-badge-success">Active</span></td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('table-features', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$table = UiEngine::table()
    ->columns([
        ['key' => 'name', 'label' => 'Name', 'sortable' => true],
        ['key' => 'email', 'label' => 'Email', 'sortable' => true, 'searchable' => true],
        ['key' => 'role', 'label' => 'Role', 'filterable' => true],
    ])
    ->data(\$users)
    ->searchable()           // Enable global search
    ->sortBy('name', 'asc')  // Default sort
    ->perPageOptions([10, 25, 50, 100]);

echo \$table->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const table = UiEngine.table()
    .columns([
        {key: 'name', label: 'Name', sortable: true},
        {key: 'email', label: 'Email', sortable: true, searchable: true},
        {key: 'role', label: 'Role', filterable: true},
    ])
    .data(users)
    .searchable()
    .sortBy('name', 'asc')
    .onSort((column, direction) => {
        fetchSorted(column, direction);
    })
    .onSearch((query) => {
        fetchFiltered(query);
    });

document.getElementById('container').innerHTML = table.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Search and Per-Page Controls -->
<div class="so-d-flex so-justify-content-between so-align-items-center so-mb-3">
    <div class="so-d-flex so-align-items-center so-gap-2">
        <label class="so-text-muted">Show</label>
        <select class="so-form-control so-form-control-sm" data-so-select>
            <option>10</option>
            <option>25</option>
            <option>50</option>
        </select>
        <label class="so-text-muted">entries</label>
    </div>
    <div class="so-input-group" style="width: 250px;">
        <span class="so-input-addon"><span class="material-icons">search</span></span>
        <input type="text" class="so-form-control so-form-control-sm" placeholder="Search...">
    </div>
</div>

<!-- Sortable Table -->
<table class="so-table so-table-hover">
    <thead class="so-table-light">
        <tr>
            <th style="cursor: pointer;">
                Name <span class="material-icons">arrow_upward</span>
            </th>
            <th style="cursor: pointer;">
                Email <span class="material-icons" style="opacity: 0.3;">unfold_more</span>
            </th>
            <th>Role</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Alice Brown</td><td>alice@example.com</td><td>User</td><td>...</td></tr>
        <!-- More rows -->
    </tbody>
</table>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Method</th>
                                <th>Parameters</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>columns()</code></td>
                                <td><code>array $columns</code></td>
                                <td>Define table columns</td>
                            </tr>
                            <tr>
                                <td><code>data()</code></td>
                                <td><code>array $data</code></td>
                                <td>Set table data</td>
                            </tr>
                            <tr>
                                <td><code>rows()</code></td>
                                <td><code>array $rows</code></td>
                                <td>Set rows directly</td>
                            </tr>
                            <tr>
                                <td><code>striped()</code></td>
                                <td>-</td>
                                <td>Add striped rows</td>
                            </tr>
                            <tr>
                                <td><code>bordered()</code></td>
                                <td>-</td>
                                <td>Add borders</td>
                            </tr>
                            <tr>
                                <td><code>hover()</code></td>
                                <td>-</td>
                                <td>Add hover effect</td>
                            </tr>
                            <tr>
                                <td><code>actions()</code></td>
                                <td><code>array $actions</code></td>
                                <td>Add row action buttons</td>
                            </tr>
                            <tr>
                                <td><code>pagination()</code></td>
                                <td><code>array $config</code></td>
                                <td>Enable pagination</td>
                            </tr>
                            <tr>
                                <td><code>searchable()</code></td>
                                <td>-</td>
                                <td>Enable search</td>
                            </tr>
                            <tr>
                                <td><code>sortBy()</code></td>
                                <td><code>string $column, string $direction</code></td>
                                <td>Set default sort</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Sortable and Searchable Table Demo
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('demo-sortable-table');
    const searchInput = document.getElementById('demo-search');
    const perPageSelect = document.getElementById('demo-perpage');

    if (!table || !searchInput) return;

    const tbody = table.querySelector('tbody');
    const headers = table.querySelectorAll('th.sortable');

    // Get all rows as array for manipulation
    function getRows() {
        return Array.from(tbody.querySelectorAll('tr'));
    }

    // Sort functionality
    headers.forEach(header => {
        header.addEventListener('click', function() {
            const sortKey = this.dataset.sort;
            let direction = this.dataset.direction || 'asc';

            // Toggle direction if clicking same column
            if (this.classList.contains('sorted')) {
                direction = direction === 'asc' ? 'desc' : 'asc';
            }

            // Update header states
            headers.forEach(h => {
                h.classList.remove('sorted');
                h.dataset.direction = '';
                const icon = h.querySelector('.sort-icon');
                if (icon) {
                    icon.textContent = 'unfold_more';
                    icon.style.opacity = '0.3';
                }
            });

            this.classList.add('sorted');
            this.dataset.direction = direction;
            const icon = this.querySelector('.sort-icon');
            if (icon) {
                icon.textContent = direction === 'asc' ? 'arrow_upward' : 'arrow_downward';
                icon.style.opacity = '1';
            }

            // Sort rows
            const rows = getRows();
            rows.sort((a, b) => {
                const aVal = a.dataset[sortKey] || '';
                const bVal = b.dataset[sortKey] || '';
                const comparison = aVal.localeCompare(bVal);
                return direction === 'asc' ? comparison : -comparison;
            });

            // Re-append rows in sorted order
            rows.forEach(row => tbody.appendChild(row));
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const rows = getRows();

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

    // Per-page functionality (demo - just shows message)
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            const perPage = this.value;
            // In a real app, this would paginate the data
            console.log('Per page changed to:', perPage);
        });
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>
