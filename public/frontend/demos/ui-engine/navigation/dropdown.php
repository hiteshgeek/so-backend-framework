<?php
/**
 * SixOrbit UI Engine - Dropdown Element Demo
 */

$pageTitle = 'Dropdown - UI Engine';
$pageDescription = 'Toggle contextual overlays for displaying links and actions';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Dropdown</h1>
            <p class="so-page-subtitle">Toggle contextual overlays for displaying lists of links and actions.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Dropdown -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Dropdown</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-dropdown" data-so-dropdown>
                    <button type="button" class="so-btn so-btn-primary so-dropdown-trigger">
                        <span class="so-dropdown-selected">Dropdown Button</span>
                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                    </button>
                    <div class="so-dropdown-menu">
                        <div class="so-dropdown-item" data-value="action">Action</div>
                        <div class="so-dropdown-item" data-value="another">Another action</div>
                        <div class="so-dropdown-item" data-value="else">Something else</div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-dropdown', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$dropdown = UiEngine::dropdown('Actions')
    ->item('Action', 'action')
    ->item('Another action', 'another')
    ->item('Something else', 'else');

echo \$dropdown->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropdown = UiEngine.dropdown('Actions')
    .item('Action', 'action')
    .item('Another action', 'another')
    .item('Something else', 'else');

document.getElementById('container').innerHTML = dropdown.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-dropdown" data-so-dropdown>
    <button type="button" class="so-btn so-btn-primary so-dropdown-trigger">
        <span class="so-dropdown-selected">Actions</span>
        <span class="material-icons so-dropdown-arrow">expand_more</span>
    </button>
    <div class="so-dropdown-menu">
        <div class="so-dropdown-item" data-value="action">Action</div>
        <div class="so-dropdown-item" data-value="another">Another action</div>
        <div class="so-dropdown-item" data-value="else">Something else</div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Dropdown Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Dropdown Variants</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap">
                    <div class="so-dropdown" data-so-dropdown>
                        <button type="button" class="so-btn so-btn-primary so-dropdown-trigger">
                            <span class="so-dropdown-selected">Primary</span>
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu">
                            <div class="so-dropdown-item">Action</div>
                        </div>
                    </div>
                    <div class="so-dropdown" data-so-dropdown>
                        <button type="button" class="so-btn so-btn-secondary so-dropdown-trigger">
                            <span class="so-dropdown-selected">Secondary</span>
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu">
                            <div class="so-dropdown-item">Action</div>
                        </div>
                    </div>
                    <div class="so-dropdown" data-so-dropdown>
                        <button type="button" class="so-btn so-btn-success so-dropdown-trigger">
                            <span class="so-dropdown-selected">Success</span>
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu">
                            <div class="so-dropdown-item">Action</div>
                        </div>
                    </div>
                    <div class="so-dropdown" data-so-dropdown>
                        <button type="button" class="so-btn so-btn-danger so-dropdown-trigger">
                            <span class="so-dropdown-selected">Danger</span>
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu">
                            <div class="so-dropdown-item">Action</div>
                        </div>
                    </div>
                    <div class="so-dropdown" data-so-dropdown>
                        <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                            <span class="so-dropdown-selected">Light</span>
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu">
                            <div class="so-dropdown-item">Action</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropdown-variants', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Primary (default)
UiEngine::dropdown('Primary')
    ->variant('primary')
    ->item('Action', 'action');

// Secondary
UiEngine::dropdown('Secondary')
    ->variant('secondary')
    ->item('Action', 'action');

// Success
UiEngine::dropdown('Success')
    ->variant('success')
    ->item('Action', 'action');

// Danger
UiEngine::dropdown('Danger')
    ->variant('danger')
    ->item('Action', 'action');

// Light
UiEngine::dropdown('Light')
    ->variant('light')
    ->item('Action', 'action');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Primary (default)
UiEngine.dropdown('Primary')
    .variant('primary')
    .item('Action', 'action');

// Secondary
UiEngine.dropdown('Secondary')
    .variant('secondary')
    .item('Action', 'action');

// Success
UiEngine.dropdown('Success')
    .variant('success')
    .item('Action', 'action');

// Danger
UiEngine.dropdown('Danger')
    .variant('danger')
    .item('Action', 'action');

// Light
UiEngine.dropdown('Light')
    .variant('light')
    .item('Action', 'action');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Searchable Dropdown -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Searchable Dropdown</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-dropdown so-dropdown-searchable" data-so-dropdown>
                    <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                        <span class="so-dropdown-selected">Search & Select</span>
                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                    </button>
                    <div class="so-dropdown-menu">
                        <div class="so-dropdown-search">
                            <input type="text" class="so-dropdown-search-input" placeholder="Search...">
                        </div>
                        <div class="so-dropdown-items">
                            <div class="so-dropdown-item" data-value="apple">Apple</div>
                            <div class="so-dropdown-item" data-value="banana">Banana</div>
                            <div class="so-dropdown-item" data-value="cherry">Cherry</div>
                            <div class="so-dropdown-item" data-value="date">Date</div>
                            <div class="so-dropdown-item" data-value="elderberry">Elderberry</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropdown-searchable', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$dropdown = UiEngine::dropdown('Search & Select')
    ->searchable()
    ->variant('light')
    ->item('Apple', 'apple')
    ->item('Banana', 'banana')
    ->item('Cherry', 'cherry')
    ->item('Date', 'date')
    ->item('Elderberry', 'elderberry');

echo \$dropdown->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropdown = UiEngine.dropdown('Search & Select')
    .searchable()
    .variant('light')
    .item('Apple', 'apple')
    .item('Banana', 'banana')
    .item('Cherry', 'cherry')
    .item('Date', 'date')
    .item('Elderberry', 'elderberry');

document.getElementById('container').innerHTML = dropdown.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Dividers and Headers -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Dividers and Headers</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-dropdown" data-so-dropdown>
                    <button type="button" class="so-btn so-btn-primary so-dropdown-trigger">
                        <span class="so-dropdown-selected">Actions</span>
                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                    </button>
                    <div class="so-dropdown-menu">
                        <div class="so-dropdown-header">Actions</div>
                        <div class="so-dropdown-item" data-action="edit">Edit</div>
                        <div class="so-dropdown-item" data-action="duplicate">Duplicate</div>
                        <div class="so-dropdown-divider"></div>
                        <div class="so-dropdown-header">Danger Zone</div>
                        <div class="so-dropdown-item so-dropdown-item-danger" data-action="delete">Delete</div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropdown-dividers', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$dropdown = UiEngine::dropdown('Actions')
    ->header('Actions')
    ->item('Edit', 'edit')
    ->item('Duplicate', 'duplicate')
    ->divider()
    ->header('Danger Zone')
    ->item('Delete', 'delete', ['danger' => true]);

echo \$dropdown->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropdown = UiEngine.dropdown('Actions')
    .header('Actions')
    .item('Edit', 'edit')
    .item('Duplicate', 'duplicate')
    .divider()
    .header('Danger Zone')
    .item('Delete', 'delete', {danger: true});

document.getElementById('container').innerHTML = dropdown.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Icons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-dropdown" data-so-dropdown>
                    <button type="button" class="so-btn so-btn-primary so-dropdown-trigger">
                        <span class="material-icons so-me-1">settings</span>
                        <span class="so-dropdown-selected">Settings</span>
                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                    </button>
                    <div class="so-dropdown-menu">
                        <div class="so-dropdown-item" data-action="profile">
                            <span class="material-icons">person</span>
                            <span>Profile</span>
                        </div>
                        <div class="so-dropdown-item" data-action="settings">
                            <span class="material-icons">settings</span>
                            <span>Settings</span>
                        </div>
                        <div class="so-dropdown-divider"></div>
                        <div class="so-dropdown-item" data-action="logout">
                            <span class="material-icons">logout</span>
                            <span>Logout</span>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropdown-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$dropdown = UiEngine::dropdown('Settings')
    ->icon('settings')
    ->item('Profile', 'profile', ['icon' => 'person'])
    ->item('Settings', 'settings', ['icon' => 'settings'])
    ->divider()
    ->item('Logout', 'logout', ['icon' => 'logout']);

echo \$dropdown->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropdown = UiEngine.dropdown('Settings')
    .icon('settings')
    .item('Profile', 'profile', {icon: 'person'})
    .item('Settings', 'settings', {icon: 'settings'})
    .divider()
    .item('Logout', 'logout', {icon: 'logout'});

document.getElementById('container').innerHTML = dropdown.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Options/Action Dropdown -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Options/Action Dropdown</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-dropdown" data-so-dropdown>
                    <button type="button" class="so-btn so-btn-light so-btn-icon so-dropdown-trigger">
                        <span class="material-icons">more_vert</span>
                    </button>
                    <div class="so-dropdown-menu so-dropdown-menu-end">
                        <div class="so-dropdown-item" data-action="edit">
                            <span class="material-icons">edit</span>
                            <span>Edit</span>
                        </div>
                        <div class="so-dropdown-item" data-action="duplicate">
                            <span class="material-icons">content_copy</span>
                            <span>Duplicate</span>
                        </div>
                        <div class="so-dropdown-divider"></div>
                        <div class="so-dropdown-item so-dropdown-item-danger" data-action="delete">
                            <span class="material-icons">delete</span>
                            <span>Delete</span>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropdown-options', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Icon-only options dropdown
\$dropdown = UiEngine::dropdown()
    ->iconOnly('more_vert')
    ->variant('light')
    ->align('end')
    ->item('Edit', 'edit', ['icon' => 'edit'])
    ->item('Duplicate', 'duplicate', ['icon' => 'content_copy'])
    ->divider()
    ->item('Delete', 'delete', ['icon' => 'delete', 'danger' => true]);

echo \$dropdown->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Icon-only options dropdown
const dropdown = UiEngine.dropdown()
    .iconOnly('more_vert')
    .variant('light')
    .align('end')
    .item('Edit', 'edit', {icon: 'edit'})
    .item('Duplicate', 'duplicate', {icon: 'content_copy'})
    .divider()
    .item('Delete', 'delete', {icon: 'delete', danger: true});

document.getElementById('container').innerHTML = dropdown.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Menu Alignment -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Menu Alignment</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4">
                    <div class="so-dropdown" data-so-dropdown>
                        <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                            <span class="so-dropdown-selected">Left Aligned</span>
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu">
                            <div class="so-dropdown-item">Action 1</div>
                            <div class="so-dropdown-item">Action 2</div>
                        </div>
                    </div>
                    <div class="so-dropdown" data-so-dropdown>
                        <button type="button" class="so-btn so-btn-light so-dropdown-trigger">
                            <span class="so-dropdown-selected">Right Aligned</span>
                            <span class="material-icons so-dropdown-arrow">expand_more</span>
                        </button>
                        <div class="so-dropdown-menu so-dropdown-menu-end">
                            <div class="so-dropdown-item">Action 1</div>
                            <div class="so-dropdown-item">Action 2</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropdown-align', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Left aligned (default)
UiEngine::dropdown('Left Aligned')
    ->align('start')
    ->item('Action 1', 'action1')
    ->item('Action 2', 'action2');

// Right aligned
UiEngine::dropdown('Right Aligned')
    ->align('end')
    ->item('Action 1', 'action1')
    ->item('Action 2', 'action2');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Left aligned (default)
UiEngine.dropdown('Left Aligned')
    .align('start')
    .item('Action 1', 'action1')
    .item('Action 2', 'action2');

// Right aligned
UiEngine.dropdown('Right Aligned')
    .align('end')
    .item('Action 1', 'action1')
    .item('Action 2', 'action2');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Disabled Items -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Disabled Items</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-dropdown" data-so-dropdown>
                    <button type="button" class="so-btn so-btn-primary so-dropdown-trigger">
                        <span class="so-dropdown-selected">Actions</span>
                        <span class="material-icons so-dropdown-arrow">expand_more</span>
                    </button>
                    <div class="so-dropdown-menu">
                        <div class="so-dropdown-item">Active item</div>
                        <div class="so-dropdown-item so-dropdown-item-disabled">Disabled item</div>
                        <div class="so-dropdown-item">Another active item</div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('dropdown-disabled', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$dropdown = UiEngine::dropdown('Actions')
    ->item('Active item', 'active')
    ->item('Disabled item', 'disabled', ['disabled' => true])
    ->item('Another active item', 'another');

echo \$dropdown->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const dropdown = UiEngine.dropdown('Actions')
    .item('Active item', 'active')
    .item('Disabled item', 'disabled', {disabled: true})
    .item('Another active item', 'another');

document.getElementById('container').innerHTML = dropdown.toHtml();"
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
                                <td><code>item()</code></td>
                                <td><code>string $label, string $value, array $options</code></td>
                                <td>Add dropdown item</td>
                            </tr>
                            <tr>
                                <td><code>items()</code></td>
                                <td><code>array $items</code></td>
                                <td>Add multiple items at once</td>
                            </tr>
                            <tr>
                                <td><code>divider()</code></td>
                                <td>-</td>
                                <td>Add horizontal divider</td>
                            </tr>
                            <tr>
                                <td><code>header()</code></td>
                                <td><code>string $text</code></td>
                                <td>Add section header</td>
                            </tr>
                            <tr>
                                <td><code>variant()</code></td>
                                <td><code>string $variant</code></td>
                                <td>Button variant: primary, secondary, success, danger, light</td>
                            </tr>
                            <tr>
                                <td><code>align()</code></td>
                                <td><code>string $alignment</code></td>
                                <td>Menu alignment: start (default), end</td>
                            </tr>
                            <tr>
                                <td><code>searchable()</code></td>
                                <td>-</td>
                                <td>Make dropdown searchable</td>
                            </tr>
                            <tr>
                                <td><code>icon()</code></td>
                                <td><code>string $icon</code></td>
                                <td>Add icon to toggle button</td>
                            </tr>
                            <tr>
                                <td><code>iconOnly()</code></td>
                                <td><code>string $icon</code></td>
                                <td>Create icon-only trigger button</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
