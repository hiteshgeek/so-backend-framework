<?php
/**
 * SixOrbit UI Demo - Context Menu
 */
$pageTitle = 'Context Menu';
$pageDescription = 'Right-click context menu component';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Context Menu</h1>
            <p class="so-page-subtitle">Right-click context menu component</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<div class="so-card so-card-elevated">
        <div class="so-card-header">
            <h3 class="so-card-title">Context Menu</h3>
            <p class="so-card-subtitle">Right-click contextual menus with headers, separators, submenus, and full JavaScript API</p>
        </div>
        <div class="so-card-body">

            <!-- Basic Context Menu -->
            <section class="demo-section">
                <h4 class="demo-section-title">Basic Context Menu</h4>
                <p class="demo-section-description">Right-click on the demo area to see the context menu.</p>

                <div class="demo-preview">
                    <div id="basic-menu-target" class="context-menu-demo-area" data-so-context-menu="#basic-context-menu">
                        <span class="material-icons">touch_app</span>
                        <span>Right-click here</span>
                    </div>

                    <!-- Basic Context Menu -->
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
                        <div class="so-context-menu-item" data-id="select-all">
                            <span class="so-context-menu-item-icon"><span class="material-icons">select_all</span></span>
                            <span class="so-context-menu-item-text">Select All</span>
                            <span class="so-context-menu-item-shortcut">Ctrl+A</span>
                        </div>
                    </div>
                </div>

                <div class="demo-code">
<pre><code class="language-html">&lt;div data-so-context-menu="#basic-context-menu"&gt;Right-click here&lt;/div&gt;

&lt;div id="basic-context-menu" class="so-context-menu"&gt;
    &lt;div class="so-context-menu-item" data-id="cut"&gt;
        &lt;span class="so-context-menu-item-icon"&gt;&lt;span class="material-icons"&gt;content_cut&lt;/span&gt;&lt;/span&gt;
        &lt;span class="so-context-menu-item-text"&gt;Cut&lt;/span&gt;
        &lt;span class="so-context-menu-item-shortcut"&gt;Ctrl+X&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class="so-context-menu-item" data-id="copy"&gt;...&lt;/div&gt;
    &lt;div class="so-context-menu-divider"&gt;&lt;/div&gt;
    &lt;div class="so-context-menu-item" data-id="select-all"&gt;...&lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </section>

            <!-- Menu with Headers & Separators -->
            <section class="demo-section">
                <h4 class="demo-section-title">Headers & Separators</h4>
                <p class="demo-section-description">Organize menu items with section headers and dividers.</p>

                <div class="demo-preview">
                    <div id="headers-menu-target" class="context-menu-demo-area" data-so-context-menu="#headers-context-menu">
                        <span class="material-icons">touch_app</span>
                        <span>Right-click for grouped menu</span>
                    </div>

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
                        <div class="so-context-menu-item" data-id="fit-screen">
                            <span class="so-context-menu-item-icon"><span class="material-icons">fit_screen</span></span>
                            <span class="so-context-menu-item-text">Fit to Screen</span>
                        </div>
                    </div>
                </div>

                <div class="demo-code">
<pre><code class="language-html">&lt;div id="headers-context-menu" class="so-context-menu"&gt;
    &lt;div class="so-context-menu-header"&gt;Edit&lt;/div&gt;
    &lt;div class="so-context-menu-item"&gt;...&lt;/div&gt;
    &lt;div class="so-context-menu-divider"&gt;&lt;/div&gt;
    &lt;div class="so-context-menu-header"&gt;View&lt;/div&gt;
    &lt;div class="so-context-menu-item"&gt;...&lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </section>

            <!-- Submenus -->
            <section class="demo-section">
                <h4 class="demo-section-title">Submenus</h4>
                <p class="demo-section-description">Context menus support nested submenus up to 2 levels deep.</p>

                <div class="demo-preview">
                    <div id="submenu-target" class="context-menu-demo-area" data-so-context-menu="#submenu-context-menu">
                        <span class="material-icons">touch_app</span>
                        <span>Right-click for submenus</span>
                    </div>

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
                                <div class="so-context-menu-item has-submenu" data-id="template-js">
                                    <span class="so-context-menu-item-icon"><span class="material-icons">javascript</span></span>
                                    <span class="so-context-menu-item-text">JavaScript</span>
                                    <span class="so-context-menu-item-arrow"><span class="material-icons">chevron_right</span></span>
                                    <div class="so-context-menu-submenu">
                                        <div class="so-context-menu-item" data-id="template-js-module">
                                            <span class="so-context-menu-item-text">ES Module</span>
                                        </div>
                                        <div class="so-context-menu-item" data-id="template-js-class">
                                            <span class="so-context-menu-item-text">Class Component</span>
                                        </div>
                                        <div class="so-context-menu-item" data-id="template-js-function">
                                            <span class="so-context-menu-item-text">Function Component</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="so-context-menu-divider"></div>
                                <div class="so-context-menu-item" data-id="template-more">
                                    <span class="so-context-menu-item-icon"><span class="material-icons">more_horiz</span></span>
                                    <span class="so-context-menu-item-text">More Templates...</span>
                                </div>
                            </div>
                        </div>
                        <div class="so-context-menu-divider"></div>
                        <div class="so-context-menu-item" data-id="open">
                            <span class="so-context-menu-item-icon"><span class="material-icons">folder_open</span></span>
                            <span class="so-context-menu-item-text">Open...</span>
                            <span class="so-context-menu-item-shortcut">Ctrl+O</span>
                        </div>
                        <div class="so-context-menu-item has-submenu" data-id="open-recent">
                            <span class="so-context-menu-item-icon"><span class="material-icons">history</span></span>
                            <span class="so-context-menu-item-text">Open Recent</span>
                            <span class="so-context-menu-item-arrow"><span class="material-icons">chevron_right</span></span>
                            <div class="so-context-menu-submenu">
                                <div class="so-context-menu-item" data-id="recent-1">
                                    <span class="so-context-menu-item-text">index.html</span>
                                </div>
                                <div class="so-context-menu-item" data-id="recent-2">
                                    <span class="so-context-menu-item-text">styles.css</span>
                                </div>
                                <div class="so-context-menu-item" data-id="recent-3">
                                    <span class="so-context-menu-item-text">app.js</span>
                                </div>
                                <div class="so-context-menu-divider"></div>
                                <div class="so-context-menu-item" data-id="clear-recent">
                                    <span class="so-context-menu-item-text">Clear Recent Files</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="demo-code">
<pre><code class="language-html">&lt;div class="so-context-menu-item has-submenu"&gt;
    &lt;span class="so-context-menu-item-text"&gt;New from Template&lt;/span&gt;
    &lt;span class="so-context-menu-item-arrow"&gt;
        &lt;span class="material-icons"&gt;chevron_right&lt;/span&gt;
    &lt;/span&gt;
    &lt;div class="so-context-menu-submenu"&gt;
        &lt;div class="so-context-menu-item"&gt;HTML File&lt;/div&gt;
        &lt;div class="so-context-menu-item has-submenu"&gt;
            &lt;span class="so-context-menu-item-text"&gt;JavaScript&lt;/span&gt;
            &lt;span class="so-context-menu-item-arrow"&gt;...&lt;/span&gt;
            &lt;div class="so-context-menu-submenu"&gt;
                &lt;!-- 2nd level submenu items --&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </section>

            <!-- Disabled & Danger States -->
            <section class="demo-section">
                <h4 class="demo-section-title">Disabled & Danger Items</h4>
                <p class="demo-section-description">Items can be disabled or styled as destructive actions.</p>

                <div class="demo-preview">
                    <div id="states-menu-target" class="context-menu-demo-area" data-so-context-menu="#states-context-menu">
                        <span class="material-icons">touch_app</span>
                        <span>Right-click for states demo</span>
                    </div>

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
                        <div class="so-context-menu-item so-disabled" data-id="export">
                            <span class="so-context-menu-item-icon"><span class="material-icons">download</span></span>
                            <span class="so-context-menu-item-text">Export</span>
                        </div>
                        <div class="so-context-menu-divider"></div>
                        <div class="so-context-menu-item" data-id="archive">
                            <span class="so-context-menu-item-icon"><span class="material-icons">archive</span></span>
                            <span class="so-context-menu-item-text">Archive</span>
                        </div>
                        <div class="so-context-menu-item so-danger" data-id="delete">
                            <span class="so-context-menu-item-icon"><span class="material-icons">delete</span></span>
                            <span class="so-context-menu-item-text">Delete</span>
                            <span class="so-context-menu-item-shortcut">Del</span>
                        </div>
                    </div>
                </div>

                <div class="demo-code">
<pre><code class="language-html">&lt;!-- Disabled item --&gt;
&lt;div class="so-context-menu-item so-disabled"&gt;
    &lt;span class="so-context-menu-item-text"&gt;Share&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Danger/Destructive action --&gt;
&lt;div class="so-context-menu-item so-danger"&gt;
    &lt;span class="so-context-menu-item-icon"&gt;
        &lt;span class="material-icons"&gt;delete&lt;/span&gt;
    &lt;/span&gt;
    &lt;span class="so-context-menu-item-text"&gt;Delete&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </section>

            <!-- Size Variants -->
            <section class="demo-section">
                <h4 class="demo-section-title">Size Variants</h4>
                <p class="demo-section-description">Context menus come in small, default, and large sizes.</p>

                <div class="demo-preview">
                    <div class="demo-row">
                        <div id="small-menu-target" class="context-menu-demo-area context-menu-demo-area-sm" data-so-context-menu="#small-context-menu">
                            <span class="material-icons">touch_app</span>
                            <span>Small</span>
                        </div>

                        <div id="default-menu-target" class="context-menu-demo-area context-menu-demo-area-sm" data-so-context-menu="#default-context-menu">
                            <span class="material-icons">touch_app</span>
                            <span>Default</span>
                        </div>

                        <div id="large-menu-target" class="context-menu-demo-area context-menu-demo-area-sm" data-so-context-menu="#large-context-menu">
                            <span class="material-icons">touch_app</span>
                            <span>Large</span>
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
                </div>

                <div class="demo-code">
<pre><code class="language-html">&lt;!-- Small --&gt;
&lt;div class="so-context-menu so-context-menu-sm"&gt;...&lt;/div&gt;

&lt;!-- Default --&gt;
&lt;div class="so-context-menu"&gt;...&lt;/div&gt;

&lt;!-- Large --&gt;
&lt;div class="so-context-menu so-context-menu-lg"&gt;...&lt;/div&gt;</code></pre>
                </div>
            </section>

            <!-- JavaScript API Demo -->
            <section class="demo-section">
                <h4 class="demo-section-title">JavaScript API</h4>
                <p class="demo-section-description">Full programmatic control over context menus.</p>

                <div class="demo-preview">
                    <div class="demo-row" style="margin-bottom: 16px;">
                        <button class="so-btn so-btn-primary" onclick="demoAddItem()">Add Item</button>
                        <button class="so-btn so-btn-outline-primary" onclick="demoAddSeparator()">Add Separator</button>
                        <button class="so-btn so-btn-outline-primary" onclick="demoAddHeader()">Add Header</button>
                        <button class="so-btn so-btn-outline-danger" onclick="demoRemoveItem()">Remove Last</button>
                        <button class="so-btn so-btn-ghost" onclick="demoRemoveAll()">Clear All</button>
                    </div>

                    <div class="demo-row" style="margin-bottom: 16px;">
                        <button class="so-btn so-btn-secondary" onclick="demoEnableMenu()">Enable Menu</button>
                        <button class="so-btn so-btn-outline-secondary" onclick="demoDisableMenu()">Disable Menu</button>
                        <button class="so-btn so-btn-outline-warning" onclick="demoDisableItem()">Disable "Edit"</button>
                        <button class="so-btn so-btn-outline-success" onclick="demoEnableItem()">Enable "Edit"</button>
                    </div>

                    <div id="api-menu-target" class="context-menu-demo-area" data-so-context-menu="#api-context-menu">
                        <span class="material-icons">touch_app</span>
                        <span>Right-click here (API Demo)</span>
                    </div>

                    <div id="api-context-menu" class="so-context-menu">
                        <div class="so-context-menu-header">Actions</div>
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

                    <!-- Event Log -->
                    <div style="margin-top: 16px;">
                        <h5 class="demo-subsection-title">Event Log</h5>
                        <div id="context-menu-event-log" class="demo-event-log">
                            <div class="demo-event-log-item">Waiting for events...</div>
                        </div>
                    </div>
                </div>

                <div class="demo-code">
<pre><code class="language-javascript">// Get instance
const menu = SOContextMenu.getInstance('#api-context-menu');

// Add items
menu.add({ id: 'new', label: 'New Item', icon: 'add' });
menu.add({ id: 'top', label: 'At Top', icon: 'north' }, 'top');
menu.add({ id: 'after', label: 'After Edit' }, { after: 'edit' });

// Add separators and headers
menu.addSeparator();
menu.addHeader('More Options');

// Remove items
menu.remove('new');     // by id
menu.remove(0);         // by index

// Enable/Disable
menu.disable();         // entire menu
menu.enable();
menu.disableItem('edit');
menu.enableItem('edit');
menu.disableGroup('file-actions');

// Attach/Detach
menu.attach('#another-element');
menu.detach();

// Events
document.querySelector('#api-context-menu').addEventListener('so:contextmenu:select', (e) => {
    console.log('Selected:', e.detail.id, e.detail.label);
});</code></pre>
                </div>
            </section>

            <!-- Programmatic Creation -->
            <section class="demo-section">
                <h4 class="demo-section-title">Programmatic Creation</h4>
                <p class="demo-section-description">Create context menus entirely from JavaScript.</p>

                <div class="demo-preview">
                    <div id="programmatic-target" class="context-menu-demo-area">
                        <span class="material-icons">touch_app</span>
                        <span>Right-click (Programmatic Menu)</span>
                    </div>
                </div>

                <div class="demo-code">
<pre><code class="language-javascript">// Create menu programmatically
const menu = SOContextMenu.create({
    target: '#programmatic-target',
    trigger: 'contextmenu',
    items: [
        { type: 'header', label: 'File Operations' },
        { id: 'new', label: 'New', icon: 'add', shortcut: 'Ctrl+N' },
        { id: 'open', label: 'Open', icon: 'folder_open', shortcut: 'Ctrl+O' },
        { id: 'save', label: 'Save', icon: 'save', shortcut: 'Ctrl+S' },
        { type: 'divider' },
        {
            id: 'export',
            label: 'Export As',
            icon: 'download',
            items: [
                { id: 'export-pdf', label: 'PDF Document' },
                { id: 'export-png', label: 'PNG Image' },
                { id: 'export-svg', label: 'SVG Vector' },
            ]
        },
        { type: 'divider' },
        { id: 'delete', label: 'Delete', icon: 'delete', danger: true, shortcut: 'Del' },
    ]
});

// Listen for selection
menu.element.addEventListener('so:contextmenu:select', (e) => {
    console.log('Selected:', e.detail.id);
});</code></pre>
                </div>
            </section>

            <!-- Inline Display -->
            <section class="demo-section">
                <h4 class="demo-section-title">Inline Display</h4>
                <p class="demo-section-description">Display context menus inline for documentation or previews.</p>

                <div class="demo-preview">
                    <div class="demo-row" style="align-items: flex-start; gap: 24px;">
                        <div class="so-context-menu so-context-menu-inline">
                            <div class="so-context-menu-header">File</div>
                            <div class="so-context-menu-item">
                                <span class="so-context-menu-item-icon"><span class="material-icons">add</span></span>
                                <span class="so-context-menu-item-text">New</span>
                                <span class="so-context-menu-item-shortcut">Ctrl+N</span>
                            </div>
                            <div class="so-context-menu-item">
                                <span class="so-context-menu-item-icon"><span class="material-icons">folder_open</span></span>
                                <span class="so-context-menu-item-text">Open</span>
                            </div>
                            <div class="so-context-menu-divider"></div>
                            <div class="so-context-menu-item so-disabled">
                                <span class="so-context-menu-item-icon"><span class="material-icons">save</span></span>
                                <span class="so-context-menu-item-text">Save</span>
                            </div>
                        </div>

                        <div class="so-context-menu so-context-menu-inline so-context-menu-sm">
                            <div class="so-context-menu-item">
                                <span class="so-context-menu-item-text">Option 1</span>
                            </div>
                            <div class="so-context-menu-item">
                                <span class="so-context-menu-item-text">Option 2</span>
                            </div>
                            <div class="so-context-menu-item so-danger">
                                <span class="so-context-menu-item-text">Remove</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="demo-code">
<pre><code class="language-html">&lt;!-- Add so-context-menu-inline for always-visible display --&gt;
&lt;div class="so-context-menu so-context-menu-inline"&gt;
    &lt;div class="so-context-menu-item"&gt;...&lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </section>

            <!-- Class Reference -->
            <section class="demo-section">
                <h4 class="demo-section-title">Class Reference</h4>
                <div class="so-table-responsive">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-context-menu</code></td>
                                <td>Base context menu container</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-sm</code></td>
                                <td>Small size variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-lg</code></td>
                                <td>Large size variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-inline</code></td>
                                <td>Always visible (for documentation)</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-header</code></td>
                                <td>Section header text</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-divider</code></td>
                                <td>Horizontal separator line</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-item</code></td>
                                <td>Clickable menu item</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-item.disabled</code></td>
                                <td>Disabled/unclickable item</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-item.danger</code></td>
                                <td>Destructive action (red)</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-item.has-submenu</code></td>
                                <td>Item with submenu</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-submenu</code></td>
                                <td>Nested submenu container</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-item-icon</code></td>
                                <td>Icon wrapper</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-item-text</code></td>
                                <td>Item label text</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-item-shortcut</code></td>
                                <td>Keyboard shortcut hint</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-item-arrow</code></td>
                                <td>Submenu arrow indicator</td>
                            </tr>
                            <tr>
                                <td><code>.so-context-menu-group</code></td>
                                <td>Group wrapper for batch enable/disable</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>
</div>

<style>
.context-menu-demo-area {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 120px;
    padding: 24px;
    background: var(--so-card-hover-bg);
    border: 2px dashed var(--so-border-color);
    border-radius: 8px;
    color: var(--so-text-secondary);
    font-size: 14px;
    cursor: context-menu;
    transition: all 0.2s ease;
}

.context-menu-demo-area:hover {
    border-color: var(--so-accent-primary);
    background: rgba(var(--so-primary-rgb), 0.05);
}

.context-menu-demo-area .material-icons {
    font-size: 32px;
    opacity: 0.5;
}

.context-menu-demo-area-sm {
    min-height: 80px;
    padding: 16px;
    flex: 1;
}

.demo-event-log {
    max-height: 150px;
    overflow-y: auto;
    padding: 12px;
    background: var(--so-card-hover-bg);
    border-radius: 8px;
    font-family: monospace;
    font-size: 12px;
}

.demo-event-log-item {
    padding: 4px 0;
    color: var(--so-text-secondary);
    border-bottom: 1px solid var(--so-border-color);
}

.demo-event-log-item:last-child {
    border-bottom: none;
}

.demo-event-log-item.success {
    color: var(--so-accent-success);
}

.demo-event-log-item.info {
    color: var(--so-accent-info);
}

.demo-subsection-title {
    margin: 0 0 8px 0;
    font-size: 13px;
    font-weight: 600;
    color: var(--so-text-secondary);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all context menus on the page
    document.querySelectorAll('[data-so-context-menu]').forEach(trigger => {
        const menuSelector = trigger.getAttribute('data-so-context-menu');
        const menu = document.querySelector(menuSelector);
        if (menu) {
            SOContextMenu.getInstance(menu);
        }
    });

    // API Demo Menu
    const apiMenu = document.querySelector('#api-context-menu');
    if (apiMenu) {
        window.apiMenuInstance = SOContextMenu.getInstance(apiMenu);

        // Log events
        const log = document.querySelector('#context-menu-event-log');

        apiMenu.addEventListener('so:contextmenu:show', (e) => {
            addLogEntry(log, `Menu opening at (${e.detail.x}, ${e.detail.y})`, 'info');
        });

        apiMenu.addEventListener('so:contextmenu:shown', () => {
            addLogEntry(log, 'Menu opened', 'success');
        });

        apiMenu.addEventListener('so:contextmenu:hide', () => {
            addLogEntry(log, 'Menu closing', 'info');
        });

        apiMenu.addEventListener('so:contextmenu:hidden', () => {
            addLogEntry(log, 'Menu closed', 'success');
        });

        apiMenu.addEventListener('so:contextmenu:select', (e) => {
            addLogEntry(log, `Selected: ${e.detail.id} - "${e.detail.label}"`, 'success');
        });
    }

    // Programmatic Menu Creation
    const programmaticTarget = document.querySelector('#programmatic-target');
    if (programmaticTarget && typeof SOContextMenu !== 'undefined') {
        window.programmaticMenu = SOContextMenu.create({
            target: programmaticTarget,
            trigger: 'contextmenu',
            items: [
                { type: 'header', label: 'File Operations' },
                { id: 'new', label: 'New', icon: 'add', shortcut: 'Ctrl+N' },
                { id: 'open', label: 'Open', icon: 'folder_open', shortcut: 'Ctrl+O' },
                { id: 'save', label: 'Save', icon: 'save', shortcut: 'Ctrl+S' },
                { type: 'divider' },
                {
                    id: 'export',
                    label: 'Export As',
                    icon: 'download',
                    items: [
                        { id: 'export-pdf', label: 'PDF Document', icon: 'picture_as_pdf' },
                        { id: 'export-png', label: 'PNG Image', icon: 'image' },
                        { id: 'export-svg', label: 'SVG Vector', icon: 'draw' },
                    ]
                },
                { type: 'divider' },
                { id: 'settings', label: 'Settings', icon: 'settings' },
                { id: 'delete', label: 'Delete', icon: 'delete', danger: true, shortcut: 'Del' },
            ]
        });
    }
});

function addLogEntry(log, message, type = '') {
    if (!log) return;

    const entry = document.createElement('div');
    entry.className = 'demo-event-log-item' + (type ? ' ' + type : '');
    entry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;

    // Remove "waiting" message
    const waiting = log.querySelector('.demo-event-log-item:only-child');
    if (waiting && waiting.textContent.includes('Waiting')) {
        waiting.remove();
    }

    log.insertBefore(entry, log.firstChild);

    // Keep only last 20 entries
    while (log.children.length > 20) {
        log.removeChild(log.lastChild);
    }
}

// API Demo functions
let itemCounter = 0;

function demoAddItem() {
    if (!window.apiMenuInstance) return;
    itemCounter++;
    window.apiMenuInstance.add({
        id: `dynamic-${itemCounter}`,
        label: `Dynamic Item ${itemCounter}`,
        icon: 'star',
    });
    addLogEntry(document.querySelector('#context-menu-event-log'), `Added item: Dynamic Item ${itemCounter}`, 'info');
}

function demoAddSeparator() {
    if (!window.apiMenuInstance) return;
    window.apiMenuInstance.addSeparator();
    addLogEntry(document.querySelector('#context-menu-event-log'), 'Added separator', 'info');
}

function demoAddHeader() {
    if (!window.apiMenuInstance) return;
    window.apiMenuInstance.addHeader('New Section');
    addLogEntry(document.querySelector('#context-menu-event-log'), 'Added header: New Section', 'info');
}

function demoRemoveItem() {
    if (!window.apiMenuInstance) return;
    const items = window.apiMenuInstance.getItems();
    if (items.length > 0) {
        const lastItem = items[items.length - 1];
        window.apiMenuInstance.remove(lastItem.id);
        addLogEntry(document.querySelector('#context-menu-event-log'), `Removed item: ${lastItem.id}`, 'info');
    }
}

function demoRemoveAll() {
    if (!window.apiMenuInstance) return;
    window.apiMenuInstance.removeAll();
    addLogEntry(document.querySelector('#context-menu-event-log'), 'Removed all items', 'info');
}

function demoEnableMenu() {
    if (!window.apiMenuInstance) return;
    window.apiMenuInstance.enable();
    addLogEntry(document.querySelector('#context-menu-event-log'), 'Menu enabled', 'success');
}

function demoDisableMenu() {
    if (!window.apiMenuInstance) return;
    window.apiMenuInstance.disable();
    addLogEntry(document.querySelector('#context-menu-event-log'), 'Menu disabled', 'info');
}

function demoDisableItem() {
    if (!window.apiMenuInstance) return;
    window.apiMenuInstance.disableItem('edit');
    addLogEntry(document.querySelector('#context-menu-event-log'), 'Disabled "Edit" item', 'info');
}

function demoEnableItem() {
    if (!window.apiMenuInstance) return;
    window.apiMenuInstance.enableItem('edit');
    addLogEntry(document.querySelector('#context-menu-event-log'), 'Enabled "Edit" item', 'success');
}
</script>

</main>

<?php
require_once '../includes/footer.php';
?>
