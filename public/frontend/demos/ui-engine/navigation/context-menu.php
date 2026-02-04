<?php
/**
 * SixOrbit UI Engine - Context Menu Element Demo
 */

$pageTitle = 'Context Menu - UI Engine';
$pageDescription = 'Right-click contextual menus for elements';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Context Menu</h1>
            <p class="so-page-subtitle">Right-click contextual menus with customizable items, icons, and keyboard shortcuts.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Context Menu -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Context Menu</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-p-5 so-border so-border-dashed so-rounded so-text-center" style="cursor:context-menu;border-color:#dee2e6;background:var(--so-card-hover-bg);" data-so-context-menu="#basic-context-menu">
                    <span class="material-icons so-text-muted so-mb-2" style="font-size:48px;">touch_app</span>
                    <p class="so-mb-0">Right-click anywhere in this area</p>
                </div>

                <!-- Context Menu Element -->
                <div id="basic-context-menu" class="so-context-menu">
                    <div class="so-context-menu-item" data-id="cut">
                        <span class="so-context-menu-item-icon"><span class="material-icons">content_cut</span></span>
                        <span class="so-context-menu-item-text">Cut</span>
                        <span class="so-context-menu-item-shortcut">Ctrl+X</span>
                    </div>
                    <div class="so-context-menu-item" data-id="copy">
                        <span class="so-context-menu-item-icon"><span class="material-icons">content_copy</span></span>
                        <span class="so-context-menu-item-text">Copy</span>
                        <span class="so-context-menu-item-shortcut">Ctrl+C</span>
                    </div>
                    <div class="so-context-menu-item" data-id="paste">
                        <span class="so-context-menu-item-icon"><span class="material-icons">content_paste</span></span>
                        <span class="so-context-menu-item-text">Paste</span>
                        <span class="so-context-menu-item-shortcut">Ctrl+V</span>
                    </div>
                    <div class="so-context-menu-divider"></div>
                    <div class="so-context-menu-item" data-id="delete">
                        <span class="so-context-menu-item-icon"><span class="material-icons">delete</span></span>
                        <span class="so-context-menu-item-text">Delete</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-context', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$contextMenu = UiEngine::contextMenu('basic-menu')
    ->item('Cut', 'cut', ['icon' => 'content_cut', 'shortcut' => 'Ctrl+X'])
    ->item('Copy', 'copy', ['icon' => 'content_copy', 'shortcut' => 'Ctrl+C'])
    ->item('Paste', 'paste', ['icon' => 'content_paste', 'shortcut' => 'Ctrl+V'])
    ->divider()
    ->item('Delete', 'delete', ['icon' => 'delete']);

// Attach to element
\$element = UiEngine::div()
    ->contextMenu(\$contextMenu)
    ->content('Right-click me!');

echo \$element->render();
echo \$contextMenu->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const contextMenu = UiEngine.contextMenu('basic-menu')
    .item('Cut', 'cut', {icon: 'content_cut', shortcut: 'Ctrl+X'})
    .item('Copy', 'copy', {icon: 'content_copy', shortcut: 'Ctrl+C'})
    .item('Paste', 'paste', {icon: 'content_paste', shortcut: 'Ctrl+V'})
    .divider()
    .item('Delete', 'delete', {icon: 'delete'});

// Attach to element
document.getElementById('myElement').setAttribute('data-so-context-menu', '#basic-menu');
document.body.appendChild(contextMenu.toElement());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div data-so-context-menu="#basic-menu">Right-click me!</div>

<div id="basic-menu" class="so-context-menu">
    <div class="so-context-menu-item" data-id="cut">
        <span class="so-context-menu-item-icon"><span class="material-icons">content_cut</span></span>
        <span class="so-context-menu-item-text">Cut</span>
        <span class="so-context-menu-item-shortcut">Ctrl+X</span>
    </div>
    <div class="so-context-menu-item" data-id="copy">...</div>
    <div class="so-context-menu-divider"></div>
    <div class="so-context-menu-item" data-id="delete">...</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Headers and Dividers -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Headers & Dividers</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-p-5 so-border so-border-dashed so-rounded so-text-center" style="cursor:context-menu;border-color:#dee2e6;background:var(--so-card-hover-bg);" data-so-context-menu="#headers-context-menu">
                    <span class="material-icons so-text-muted so-mb-2" style="font-size:48px;">touch_app</span>
                    <p class="so-mb-0">Right-click for grouped menu</p>
                </div>

                <!-- Context Menu Element -->
                <div id="headers-context-menu" class="so-context-menu">
                    <div class="so-context-menu-header">Edit</div>
                    <div class="so-context-menu-item" data-id="undo">
                        <span class="so-context-menu-item-icon"><span class="material-icons">undo</span></span>
                        <span class="so-context-menu-item-text">Undo</span>
                        <span class="so-context-menu-item-shortcut">Ctrl+Z</span>
                    </div>
                    <div class="so-context-menu-item" data-id="redo">
                        <span class="so-context-menu-item-icon"><span class="material-icons">redo</span></span>
                        <span class="so-context-menu-item-text">Redo</span>
                        <span class="so-context-menu-item-shortcut">Ctrl+Y</span>
                    </div>
                    <div class="so-context-menu-divider"></div>
                    <div class="so-context-menu-header">View</div>
                    <div class="so-context-menu-item" data-id="zoom-in">
                        <span class="so-context-menu-item-icon"><span class="material-icons">zoom_in</span></span>
                        <span class="so-context-menu-item-text">Zoom In</span>
                        <span class="so-context-menu-item-shortcut">Ctrl++</span>
                    </div>
                    <div class="so-context-menu-item" data-id="zoom-out">
                        <span class="so-context-menu-item-icon"><span class="material-icons">zoom_out</span></span>
                        <span class="so-context-menu-item-text">Zoom Out</span>
                        <span class="so-context-menu-item-shortcut">Ctrl+-</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('context-headers', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$contextMenu = UiEngine::contextMenu('edit-menu')
    ->header('Edit')
    ->item('Undo', 'undo', ['icon' => 'undo', 'shortcut' => 'Ctrl+Z'])
    ->item('Redo', 'redo', ['icon' => 'redo', 'shortcut' => 'Ctrl+Y'])
    ->divider()
    ->header('View')
    ->item('Zoom In', 'zoom-in', ['icon' => 'zoom_in', 'shortcut' => 'Ctrl++'])
    ->item('Zoom Out', 'zoom-out', ['icon' => 'zoom_out', 'shortcut' => 'Ctrl+-']);

echo \$contextMenu->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const contextMenu = UiEngine.contextMenu('edit-menu')
    .header('Edit')
    .item('Undo', 'undo', {icon: 'undo', shortcut: 'Ctrl+Z'})
    .item('Redo', 'redo', {icon: 'redo', shortcut: 'Ctrl+Y'})
    .divider()
    .header('View')
    .item('Zoom In', 'zoom-in', {icon: 'zoom_in', shortcut: 'Ctrl++'})
    .item('Zoom Out', 'zoom-out', {icon: 'zoom_out', shortcut: 'Ctrl+-'});"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Disabled & Danger States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Disabled & Danger Items</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-p-5 so-border so-border-dashed so-rounded so-text-center" style="cursor:context-menu;border-color:#dee2e6;background:var(--so-card-hover-bg);" data-so-context-menu="#states-context-menu">
                    <span class="material-icons so-text-muted so-mb-2" style="font-size:48px;">touch_app</span>
                    <p class="so-mb-0">Right-click for states demo</p>
                </div>

                <!-- Context Menu Element -->
                <div id="states-context-menu" class="so-context-menu">
                    <div class="so-context-menu-item" data-id="edit">
                        <span class="so-context-menu-item-icon"><span class="material-icons">edit</span></span>
                        <span class="so-context-menu-item-text">Edit</span>
                    </div>
                    <div class="so-context-menu-item" data-id="duplicate">
                        <span class="so-context-menu-item-icon"><span class="material-icons">content_copy</span></span>
                        <span class="so-context-menu-item-text">Duplicate</span>
                    </div>
                    <div class="so-context-menu-item so-disabled" data-id="share">
                        <span class="so-context-menu-item-icon"><span class="material-icons">share</span></span>
                        <span class="so-context-menu-item-text">Share</span>
                        <span class="so-context-menu-item-shortcut">Unavailable</span>
                    </div>
                    <div class="so-context-menu-divider"></div>
                    <div class="so-context-menu-item so-danger" data-id="delete">
                        <span class="so-context-menu-item-icon"><span class="material-icons">delete</span></span>
                        <span class="so-context-menu-item-text">Delete</span>
                        <span class="so-context-menu-item-shortcut">Del</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('context-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$contextMenu = UiEngine::contextMenu('action-menu')
    ->item('Edit', 'edit', ['icon' => 'edit'])
    ->item('Duplicate', 'duplicate', ['icon' => 'content_copy'])
    ->item('Share', 'share', ['icon' => 'share', 'disabled' => true])
    ->divider()
    ->item('Delete', 'delete', [
        'icon' => 'delete',
        'danger' => true,
        'shortcut' => 'Del'
    ]);

echo \$contextMenu->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const contextMenu = UiEngine.contextMenu('action-menu')
    .item('Edit', 'edit', {icon: 'edit'})
    .item('Duplicate', 'duplicate', {icon: 'content_copy'})
    .item('Share', 'share', {icon: 'share', disabled: true})
    .divider()
    .item('Delete', 'delete', {
        icon: 'delete',
        danger: true,
        shortcut: 'Del'
    });

// Enable/disable dynamically
contextMenu.disableItem('share');
contextMenu.enableItem('share');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Submenus -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Submenus</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-p-5 so-border so-border-dashed so-rounded so-text-center" style="cursor:context-menu;border-color:#dee2e6;background:var(--so-card-hover-bg);" data-so-context-menu="#submenu-context-menu">
                    <span class="material-icons so-text-muted so-mb-2" style="font-size:48px;">touch_app</span>
                    <p class="so-mb-0">Right-click for submenus</p>
                </div>

                <!-- Context Menu Element -->
                <div id="submenu-context-menu" class="so-context-menu">
                    <div class="so-context-menu-item" data-id="new-file">
                        <span class="so-context-menu-item-icon"><span class="material-icons">insert_drive_file</span></span>
                        <span class="so-context-menu-item-text">New File</span>
                        <span class="so-context-menu-item-shortcut">Ctrl+N</span>
                    </div>
                    <div class="so-context-menu-item has-submenu" data-id="new-from-template">
                        <span class="so-context-menu-item-icon"><span class="material-icons">note_add</span></span>
                        <span class="so-context-menu-item-text">New from Template</span>
                        <span class="so-context-menu-item-arrow"><span class="material-icons">chevron_right</span></span>
                        <div class="so-context-menu-submenu">
                            <div class="so-context-menu-item" data-id="template-html">
                                <span class="so-context-menu-item-icon"><span class="material-icons">html</span></span>
                                <span class="so-context-menu-item-text">HTML File</span>
                            </div>
                            <div class="so-context-menu-item" data-id="template-css">
                                <span class="so-context-menu-item-icon"><span class="material-icons">css</span></span>
                                <span class="so-context-menu-item-text">CSS Stylesheet</span>
                            </div>
                            <div class="so-context-menu-item" data-id="template-js">
                                <span class="so-context-menu-item-icon"><span class="material-icons">javascript</span></span>
                                <span class="so-context-menu-item-text">JavaScript</span>
                            </div>
                        </div>
                    </div>
                    <div class="so-context-menu-divider"></div>
                    <div class="so-context-menu-item has-submenu" data-id="sort">
                        <span class="so-context-menu-item-icon"><span class="material-icons">sort</span></span>
                        <span class="so-context-menu-item-text">Sort by</span>
                        <span class="so-context-menu-item-arrow"><span class="material-icons">chevron_right</span></span>
                        <div class="so-context-menu-submenu">
                            <div class="so-context-menu-item" data-id="sort-name">
                                <span class="so-context-menu-item-text">Name</span>
                            </div>
                            <div class="so-context-menu-item" data-id="sort-date">
                                <span class="so-context-menu-item-text">Date</span>
                            </div>
                            <div class="so-context-menu-item" data-id="sort-size">
                                <span class="so-context-menu-item-text">Size</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('context-submenu', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$contextMenu = UiEngine::contextMenu('file-menu')
    ->item('New File', 'new-file', ['icon' => 'insert_drive_file', 'shortcut' => 'Ctrl+N'])
    ->submenu('New from Template', [
        ['type' => 'item', 'label' => 'HTML File', 'action' => 'template-html', 'icon' => 'html'],
        ['type' => 'item', 'label' => 'CSS Stylesheet', 'action' => 'template-css', 'icon' => 'css'],
        ['type' => 'item', 'label' => 'JavaScript', 'action' => 'template-js', 'icon' => 'javascript'],
    ], ['icon' => 'note_add'])
    ->divider()
    ->submenu('Sort by', [
        ['type' => 'item', 'label' => 'Name', 'action' => 'sort-name'],
        ['type' => 'item', 'label' => 'Date', 'action' => 'sort-date'],
        ['type' => 'item', 'label' => 'Size', 'action' => 'sort-size'],
    ], ['icon' => 'sort']);

echo \$contextMenu->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const contextMenu = UiEngine.contextMenu('file-menu')
    .item('New File', 'new-file', {icon: 'insert_drive_file', shortcut: 'Ctrl+N'})
    .submenu('New from Template', [
        {type: 'item', label: 'HTML File', action: 'template-html', icon: 'html'},
        {type: 'item', label: 'CSS Stylesheet', action: 'template-css', icon: 'css'},
        {type: 'item', label: 'JavaScript', action: 'template-js', icon: 'javascript'},
    ], {icon: 'note_add'})
    .divider()
    .submenu('Sort by', [
        {type: 'item', label: 'Name', action: 'sort-name'},
        {type: 'item', label: 'Date', action: 'sort-date'},
        {type: 'item', label: 'Size', action: 'sort-size'},
    ], {icon: 'sort'});"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                    <div class="so-p-4 so-border so-border-dashed so-rounded so-text-center" style="cursor:context-menu;border-color:#dee2e6;background:var(--so-card-hover-bg);" data-so-context-menu="#small-context-menu">
                        <span class="material-icons so-text-muted" style="font-size:32px;">touch_app</span>
                        <p class="so-mb-0 so-small">Small</p>
                    </div>
                    <div class="so-p-4 so-border so-border-dashed so-rounded so-text-center" style="cursor:context-menu;border-color:#dee2e6;background:var(--so-card-hover-bg);" data-so-context-menu="#default-context-menu">
                        <span class="material-icons so-text-muted" style="font-size:32px;">touch_app</span>
                        <p class="so-mb-0 so-small">Default</p>
                    </div>
                    <div class="so-p-4 so-border so-border-dashed so-rounded so-text-center" style="cursor:context-menu;border-color:#dee2e6;background:var(--so-card-hover-bg);" data-so-context-menu="#large-context-menu">
                        <span class="material-icons so-text-muted" style="font-size:32px;">touch_app</span>
                        <p class="so-mb-0 so-small">Large</p>
                    </div>
                </div>

                <!-- Small Menu -->
                <div id="small-context-menu" class="so-context-menu so-context-menu-sm">
                    <div class="so-context-menu-item" data-id="view"><span class="so-context-menu-item-text">View</span></div>
                    <div class="so-context-menu-item" data-id="edit"><span class="so-context-menu-item-text">Edit</span></div>
                    <div class="so-context-menu-divider"></div>
                    <div class="so-context-menu-item so-danger" data-id="delete"><span class="so-context-menu-item-text">Delete</span></div>
                </div>

                <!-- Default Menu -->
                <div id="default-context-menu" class="so-context-menu">
                    <div class="so-context-menu-item" data-id="view">
                        <span class="so-context-menu-item-icon"><span class="material-icons">visibility</span></span>
                        <span class="so-context-menu-item-text">View</span>
                    </div>
                    <div class="so-context-menu-item" data-id="edit">
                        <span class="so-context-menu-item-icon"><span class="material-icons">edit</span></span>
                        <span class="so-context-menu-item-text">Edit</span>
                    </div>
                    <div class="so-context-menu-divider"></div>
                    <div class="so-context-menu-item so-danger" data-id="delete">
                        <span class="so-context-menu-item-icon"><span class="material-icons">delete</span></span>
                        <span class="so-context-menu-item-text">Delete</span>
                    </div>
                </div>

                <!-- Large Menu -->
                <div id="large-context-menu" class="so-context-menu so-context-menu-lg">
                    <div class="so-context-menu-item" data-id="view">
                        <span class="so-context-menu-item-icon"><span class="material-icons">visibility</span></span>
                        <span class="so-context-menu-item-text">View Details</span>
                    </div>
                    <div class="so-context-menu-item" data-id="edit">
                        <span class="so-context-menu-item-icon"><span class="material-icons">edit</span></span>
                        <span class="so-context-menu-item-text">Edit Item</span>
                    </div>
                    <div class="so-context-menu-divider"></div>
                    <div class="so-context-menu-item so-danger" data-id="delete">
                        <span class="so-context-menu-item-icon"><span class="material-icons">delete</span></span>
                        <span class="so-context-menu-item-text">Delete Item</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('context-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small size
UiEngine::contextMenu('small-menu')
    ->size('sm')
    ->item('View', 'view')
    ->item('Edit', 'edit');

// Default size
UiEngine::contextMenu('default-menu')
    ->item('View', 'view', ['icon' => 'visibility'])
    ->item('Edit', 'edit', ['icon' => 'edit']);

// Large size
UiEngine::contextMenu('large-menu')
    ->size('lg')
    ->item('View Details', 'view', ['icon' => 'visibility'])
    ->item('Edit Item', 'edit', ['icon' => 'edit']);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small size
UiEngine.contextMenu('small-menu')
    .size('sm')
    .item('View', 'view')
    .item('Edit', 'edit');

// Default size
UiEngine.contextMenu('default-menu')
    .item('View', 'view', {icon: 'visibility'})
    .item('Edit', 'edit', {icon: 'edit'});

// Large size
UiEngine.contextMenu('large-menu')
    .size('lg')
    .item('View Details', 'view', {icon: 'visibility'})
    .item('Edit Item', 'edit', {icon: 'edit'});"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Event Handling -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Event Handling</h3>
            </div>
            <div class="so-card-body">
                <!-- Code Tabs -->
                <?= so_code_tabs('context-events', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Define menu items - events handled by frontend JS
\$contextMenu = UiEngine::contextMenu('file-actions')
    ->item('Open', 'open', ['icon' => 'open_in_new'])
    ->item('Edit', 'edit', ['icon' => 'edit'])
    ->item('Delete', 'delete', ['icon' => 'delete', 'danger' => true]);

echo \$contextMenu->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Listen for item selection
document.querySelector('#my-menu').addEventListener('so:contextmenu:select', (e) => {
    const { id, label } = e.detail;

    switch (id) {
        case 'open':
            openFile(e.target.dataset.fileId);
            break;
        case 'edit':
            editFile(e.target.dataset.fileId);
            break;
        case 'delete':
            if (confirm('Are you sure?')) {
                deleteFile(e.target.dataset.fileId);
            }
            break;
    }
});

// Listen for menu open/close
menu.addEventListener('so:contextmenu:show', (e) => {
    console.log('Menu opened at', e.detail.x, e.detail.y);
});

menu.addEventListener('so:contextmenu:hide', () => {
    console.log('Menu closed');
});"
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
                                <td><code>string $label, string $action, array $options</code></td>
                                <td>Add menu item</td>
                            </tr>
                            <tr>
                                <td><code>header()</code></td>
                                <td><code>string $text</code></td>
                                <td>Add section header</td>
                            </tr>
                            <tr>
                                <td><code>divider()</code></td>
                                <td>-</td>
                                <td>Add horizontal divider</td>
                            </tr>
                            <tr>
                                <td><code>submenu()</code></td>
                                <td><code>string $label, array $items, array $options</code></td>
                                <td>Add nested submenu with items array</td>
                            </tr>
                            <tr>
                                <td><code>size()</code></td>
                                <td><code>string $size</code></td>
                                <td>Set size: 'sm', 'lg'</td>
                            </tr>
                            <tr>
                                <td><code>disableItem()</code></td>
                                <td><code>string $id</code></td>
                                <td>Disable item by ID (JS)</td>
                            </tr>
                            <tr>
                                <td><code>enableItem()</code></td>
                                <td><code>string $id</code></td>
                                <td>Enable item by ID (JS)</td>
                            </tr>
                            <tr>
                                <td><code>show()</code></td>
                                <td><code>int $x, int $y</code></td>
                                <td>Show menu at coordinates (JS)</td>
                            </tr>
                            <tr>
                                <td><code>hide()</code></td>
                                <td>-</td>
                                <td>Hide the menu (JS)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">CSS Classes</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><code>.so-context-menu</code></td><td>Base context menu container</td></tr>
                            <tr><td><code>.so-context-menu-sm</code></td><td>Small size variant</td></tr>
                            <tr><td><code>.so-context-menu-lg</code></td><td>Large size variant</td></tr>
                            <tr><td><code>.so-context-menu-header</code></td><td>Section header text</td></tr>
                            <tr><td><code>.so-context-menu-divider</code></td><td>Horizontal separator</td></tr>
                            <tr><td><code>.so-context-menu-item</code></td><td>Clickable menu item</td></tr>
                            <tr><td><code>.so-context-menu-item.so-disabled</code></td><td>Disabled item</td></tr>
                            <tr><td><code>.so-context-menu-item.so-danger</code></td><td>Destructive action (red)</td></tr>
                            <tr><td><code>.so-context-menu-item.has-submenu</code></td><td>Item with submenu</td></tr>
                            <tr><td><code>.so-context-menu-submenu</code></td><td>Nested submenu container</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all context menus on the page
    document.querySelectorAll('[data-so-context-menu]').forEach(trigger => {
        const menuSelector = trigger.getAttribute('data-so-context-menu');
        const menu = document.querySelector(menuSelector);
        if (menu && typeof SOContextMenu !== 'undefined') {
            SOContextMenu.getInstance(menu);
        }
    });
});
</script>

<?php require_once '../../includes/footer.php'; ?>
