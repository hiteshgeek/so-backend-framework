<?php
/**
 * SixOrbit UI Demo - Drag & Drop
 * Comprehensive demo of the SODragDrop component
 */

$pageTitle = 'Drag & Drop';
$pageDescription = 'Reorderable drag-drop component for lists, cards, and any elements';

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
            <h1 class="so-page-title">Drag & Drop</h1>
            <p class="so-page-subtitle">Reorderable drag-drop component for lists, cards, and any elements</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

        <!-- Introduction -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Introduction</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    SODragDrop is a lightweight, plug-and-play drag-drop component that works with any HTML elements.
                    It uses the native HTML5 Drag & Drop API and provides features like live reordering, persistence,
                    custom styling, and cross-container dragging.
                </p>

                <div class="so-alert so-alert-info so-mb-4">
                    <span class="material-icons">info</span>
                    <div>
                        <strong>Standalone Bundle Available</strong><br>
                        You can use SODragDrop independently without loading the full SixOrbit library.
                        Just include <code>so-dragdrop.js</code> and <code>so-dragdrop.css</code>.
                    </div>
                </div>

                <?= so_code_block('<!-- Standalone usage -->
<link rel="stylesheet" href="/frontend/dist/css/so-dragdrop.css">
<script src="/frontend/dist/js/so-dragdrop.js"></script>

<!-- Or with full SixOrbit bundle (includes SODragDrop) -->
<link rel="stylesheet" href="/frontend/dist/css/sixorbit-full.css">
<script src="/frontend/dist/js/sixorbit-full.js"></script>', 'html') ?>
            </div>
        </div>

        <!-- Basic Usage -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Usage</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    The simplest usage - initialize SODragDrop on a container and all direct children become draggable.
                </p>

                <div id="basic-demo" class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-3 so-mb-4">
                    <div class="so-card so-card-compact">
                        <div class="so-card-body so-text-center">Item 1</div>
                    </div>
                    <div class="so-card so-card-compact">
                        <div class="so-card-body so-text-center">Item 2</div>
                    </div>
                    <div class="so-card so-card-compact">
                        <div class="so-card-body so-text-center">Item 3</div>
                    </div>
                    <div class="so-card so-card-compact">
                        <div class="so-card-body so-text-center">Item 4</div>
                    </div>
                </div>

                <?= so_code_block('// JavaScript initialization
const container = document.getElementById(\'my-container\');
SODragDrop.getInstance(container);

// Or with data attribute (auto-initialized)
<div data-so-dragdrop>
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
</div>', 'javascript') ?>
            </div>
        </div>

        <!-- Handle Option -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Handle Option</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Restrict dragging to a specific element (handle) within each item. Only the drag icon is draggable - the rest of the card is interactive.
                </p>

                <div id="handle-demo" class="so-grid so-grid-cols-3 so-grid-cols-sm-1 so-gap-3 so-mb-4">
                    <div class="so-card">
                        <div class="so-card-header">
                            <span class="material-icons drag-handle so-text-muted">drag_indicator</span>
                            <span class="so-fw-medium">Card 1</span>
                        </div>
                        <div class="so-card-body">
                            <p>Only drag by the icon. Header text and body are not draggable.</p>
                            <button class="so-btn so-btn-primary so-btn-sm">Click Me</button>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-header">
                            <span class="material-icons drag-handle so-text-muted">drag_indicator</span>
                            <span class="so-fw-medium">Card 2</span>
                        </div>
                        <div class="so-card-body">
                            <p>Only drag by the icon. Header text and body are not draggable.</p>
                            <button class="so-btn so-btn-secondary so-btn-sm">Click Me</button>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-header">
                            <span class="material-icons drag-handle so-text-muted">drag_indicator</span>
                            <span class="so-fw-medium">Card 3</span>
                        </div>
                        <div class="so-card-body">
                            <p>Only drag by the icon. Header text and body are not draggable.</p>
                            <button class="so-btn so-btn-success so-btn-sm">Click Me</button>
                        </div>
                    </div>
                </div>

                <?= so_code_block('SODragDrop.getInstance(container, {
    items: \'.so-card\',
    handle: \'.drag-handle\'  // Only drag by the icon
});', 'javascript') ?>
            </div>
        </div>

        <!-- Live Reorder vs Drop-Only -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Live Reorder vs Drop-Only</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Choose between live reordering (elements move as you drag) or drop-only (elements move only when dropped).
                </p>

                <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-4 so-mb-4">
                    <!-- Live Reorder -->
                    <div>
                        <h5 class="so-mb-3"><span class="so-badge so-badge-success">liveReorder: true</span> Live Reorder</h5>
                        <div id="live-reorder-demo" class="so-d-flex so-flex-column so-gap-2">
                            <div class="so-card so-card-compact so-card-border-success">
                                <div class="so-card-body">Live Item 1</div>
                            </div>
                            <div class="so-card so-card-compact so-card-border-success">
                                <div class="so-card-body">Live Item 2</div>
                            </div>
                            <div class="so-card so-card-compact so-card-border-success">
                                <div class="so-card-body">Live Item 3</div>
                            </div>
                        </div>
                    </div>

                    <!-- Drop-Only -->
                    <div>
                        <h5 class="so-mb-3"><span class="so-badge so-badge-info">liveReorder: false</span> Drop-Only</h5>
                        <div id="drop-only-demo" class="so-d-flex so-flex-column so-gap-2">
                            <div class="so-card so-card-compact so-card-border-info">
                                <div class="so-card-body">Drop Item 1</div>
                            </div>
                            <div class="so-card so-card-compact so-card-border-info">
                                <div class="so-card-body">Drop Item 2</div>
                            </div>
                            <div class="so-card so-card-compact so-card-border-info">
                                <div class="so-card-body">Drop Item 3</div>
                            </div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('// Live reorder - elements move as you drag
SODragDrop.getInstance(container, {
    liveReorder: true
});

// Drop-only - elements move only when dropped
SODragDrop.getInstance(container, {
    liveReorder: false  // default
});', 'javascript') ?>
            </div>
        </div>

        <!-- Storage Persistence -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Storage Persistence</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Automatically save and restore the order using localStorage or sessionStorage. The order persists across page reloads.
                </p>

                <div id="storage-demo" class="so-grid so-grid-cols-5 so-grid-cols-md-3 so-grid-cols-sm-2 so-gap-3 so-mb-4">
                    <div class="so-card so-card-compact" id="persist-1">
                        <div class="so-card-body so-text-center">
                            <span class="material-icons so-text-primary">looks_one</span>
                        </div>
                    </div>
                    <div class="so-card so-card-compact" id="persist-2">
                        <div class="so-card-body so-text-center">
                            <span class="material-icons so-text-success">looks_two</span>
                        </div>
                    </div>
                    <div class="so-card so-card-compact" id="persist-3">
                        <div class="so-card-body so-text-center">
                            <span class="material-icons so-text-warning">looks_3</span>
                        </div>
                    </div>
                    <div class="so-card so-card-compact" id="persist-4">
                        <div class="so-card-body so-text-center">
                            <span class="material-icons so-text-danger">looks_4</span>
                        </div>
                    </div>
                    <div class="so-card so-card-compact" id="persist-5">
                        <div class="so-card-body so-text-center">
                            <span class="material-icons so-text-info">looks_5</span>
                        </div>
                    </div>
                </div>

                <button class="so-btn so-btn-secondary so-btn-sm" onclick="localStorage.removeItem('storage-demo-order'); location.reload();">
                    <span class="material-icons">refresh</span> Reset Order
                </button>

                <?= so_code_block('SODragDrop.getInstance(container, {
    storage: \'localStorage\',        // or \'sessionStorage\'
    storageKey: \'my-unique-key\'     // unique key for this list
});', 'javascript') ?>
            </div>
        </div>

        <!-- Disabled State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Disabled State</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Enable or disable dragging dynamically using the API or configuration.
                </p>

                <div class="so-mb-3">
                    <button class="so-btn so-btn-primary so-btn-sm" id="toggle-disabled-btn">
                        <span class="material-icons">toggle_on</span> Toggle Disabled
                    </button>
                    <span id="disabled-status" class="so-badge so-badge-success so-ms-2">Enabled</span>
                </div>

                <div id="disabled-demo" class="so-grid so-grid-cols-4 so-grid-cols-sm-2 so-gap-3 so-mb-4">
                    <div class="so-card so-card-compact">
                        <div class="so-card-body so-text-center">A</div>
                    </div>
                    <div class="so-card so-card-compact">
                        <div class="so-card-body so-text-center">B</div>
                    </div>
                    <div class="so-card so-card-compact">
                        <div class="so-card-body so-text-center">C</div>
                    </div>
                    <div class="so-card so-card-compact">
                        <div class="so-card-body so-text-center">D</div>
                    </div>
                </div>

                <?= so_code_block('const dragdrop = SODragDrop.getInstance(container);

// Disable
dragdrop.disable();

// Enable
dragdrop.enable();

// Or via config
SODragDrop.getInstance(container, {
    disabled: true
});', 'javascript') ?>
            </div>
        </div>

        <!-- Callbacks -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Callbacks</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Use callbacks to respond to drag events. Perfect for updating server state or triggering animations.
                </p>

                <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-4">
                    <div>
                        <div id="callbacks-demo" class="so-d-flex so-flex-column so-gap-2 so-mb-3">
                            <div class="so-card so-card-compact">
                                <div class="so-card-body">Task 1</div>
                            </div>
                            <div class="so-card so-card-compact">
                                <div class="so-card-body">Task 2</div>
                            </div>
                            <div class="so-card so-card-compact">
                                <div class="so-card-body">Task 3</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6 class="so-mb-2">Event Log:</h6>
                        <div id="callback-log" class="so-p-3 so-bg-dark so-text-light so-rounded" style="height: 200px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                            <div class="so-text-muted">Drag items to see events...</div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('SODragDrop.getInstance(container, {
    onStart: (e, element) => {
        console.log(\'Drag started\', element);
    },
    onMove: (moveEvent) => {
        console.log(\'Moving over\', moveEvent.target);
        // return false to cancel the move
    },
    onReorder: (oldIndex, newIndex) => {
        console.log(`Moved from ${oldIndex} to ${newIndex}`);
        // Save to server here
    },
    onEnd: (e, element) => {
        console.log(\'Drag ended\', element);
    }
});', 'javascript') ?>
            </div>
        </div>

        <!-- Events -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Custom Events</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    SODragDrop emits custom events that you can listen to on the container element.
                </p>

                <div class="so-table-responsive so-mb-4">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                                <th>Detail Properties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>dragdrop:start</code></td>
                                <td>Fired when drag begins</td>
                                <td><code>element</code>, <code>index</code></td>
                            </tr>
                            <tr>
                                <td><code>dragdrop:move</code></td>
                                <td>Fired when element moves position (live mode)</td>
                                <td><code>element</code>, <code>target</code>, <code>fromIndex</code>, <code>toIndex</code></td>
                            </tr>
                            <tr>
                                <td><code>dragdrop:reorder</code></td>
                                <td>Fired when order changes (on drop)</td>
                                <td><code>element</code>, <code>oldIndex</code>, <code>newIndex</code>, <code>order</code></td>
                            </tr>
                            <tr>
                                <td><code>dragdrop:end</code></td>
                                <td>Fired when drag ends</td>
                                <td><code>element</code>, <code>oldIndex</code>, <code>newIndex</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?= so_code_block('container.addEventListener(\'dragdrop:reorder\', (e) => {
    const { element, oldIndex, newIndex, order } = e.detail;
    console.log(`Element moved from ${oldIndex} to ${newIndex}`);

    // Send to server
    fetch(\'/api/update-order\', {
        method: \'POST\',
        body: JSON.stringify({ order: order.map(item => item.id) })
    });
});', 'javascript') ?>
            </div>
        </div>

        <!-- API Methods -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Methods</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Control the drag-drop instance programmatically with these methods.
                </p>

                <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-4 so-mb-4">
                    <div>
                        <div id="api-demo" class="so-d-flex so-flex-column so-gap-2 so-mb-3">
                            <div class="so-card so-card-compact" id="api-item-1">
                                <div class="so-card-body">Alpha</div>
                            </div>
                            <div class="so-card so-card-compact" id="api-item-2">
                                <div class="so-card-body">Beta</div>
                            </div>
                            <div class="so-card so-card-compact" id="api-item-3">
                                <div class="so-card-body">Gamma</div>
                            </div>
                            <div class="so-card so-card-compact" id="api-item-4">
                                <div class="so-card-body">Delta</div>
                            </div>
                        </div>

                        <div class="so-btn-group so-btn-group-sm">
                            <button class="so-btn so-btn-secondary" onclick="getOrderDemo()">getOrder()</button>
                            <button class="so-btn so-btn-secondary" onclick="reverseOrderDemo()">Reverse</button>
                            <button class="so-btn so-btn-secondary" onclick="refreshDemo()">refresh()</button>
                        </div>
                    </div>
                    <div>
                        <h6 class="so-mb-2">Output:</h6>
                        <pre id="api-output" class="so-p-3 so-bg-dark so-text-light so-rounded" style="font-size: 12px; max-height: 200px; overflow-y: auto;">Click a button to see output...</pre>
                    </div>
                </div>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>Description</th>
                                <th>Returns</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>getOrder()</code></td>
                                <td>Get current order of items</td>
                                <td><code>Array&lt;{index, id, element}&gt;</code></td>
                            </tr>
                            <tr>
                                <td><code>setOrder(order)</code></td>
                                <td>Set order by array of IDs or indices</td>
                                <td><code>this</code></td>
                            </tr>
                            <tr>
                                <td><code>enable()</code></td>
                                <td>Enable dragging</td>
                                <td><code>this</code></td>
                            </tr>
                            <tr>
                                <td><code>disable()</code></td>
                                <td>Disable dragging</td>
                                <td><code>this</code></td>
                            </tr>
                            <tr>
                                <td><code>refresh()</code></td>
                                <td>Re-scan for draggable items</td>
                                <td><code>this</code></td>
                            </tr>
                            <tr>
                                <td><code>destroy()</code></td>
                                <td>Remove drag-drop functionality</td>
                                <td><code>void</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- List Items -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Different Element Types</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    SODragDrop works with any HTML elements - not just cards. Here are examples with list items and custom elements.
                </p>

                <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-4">
                    <!-- List Group -->
                    <div>
                        <h5 class="so-mb-3">List Group</h5>
                        <ul id="list-demo" class="so-list-group">
                            <li class="so-list-group-item so-d-flex so-align-items-center so-gap-2">
                                <span class="material-icons so-text-muted" style="cursor: grab;">drag_indicator</span>
                                First item
                            </li>
                            <li class="so-list-group-item so-d-flex so-align-items-center so-gap-2">
                                <span class="material-icons so-text-muted" style="cursor: grab;">drag_indicator</span>
                                Second item
                            </li>
                            <li class="so-list-group-item so-d-flex so-align-items-center so-gap-2">
                                <span class="material-icons so-text-muted" style="cursor: grab;">drag_indicator</span>
                                Third item
                            </li>
                            <li class="so-list-group-item so-d-flex so-align-items-center so-gap-2">
                                <span class="material-icons so-text-muted" style="cursor: grab;">drag_indicator</span>
                                Fourth item
                            </li>
                        </ul>
                    </div>

                    <!-- Custom Elements -->
                    <div>
                        <h5 class="so-mb-3">Custom Elements (Badges)</h5>
                        <div id="badge-demo" class="so-d-flex so-flex-wrap so-gap-2">
                            <span class="so-badge so-badge-lg so-badge-primary" style="cursor: grab;">Primary</span>
                            <span class="so-badge so-badge-lg so-badge-success" style="cursor: grab;">Success</span>
                            <span class="so-badge so-badge-lg so-badge-warning" style="cursor: grab;">Warning</span>
                            <span class="so-badge so-badge-lg so-badge-danger" style="cursor: grab;">Danger</span>
                            <span class="so-badge so-badge-lg so-badge-info" style="cursor: grab;">Info</span>
                        </div>
                    </div>
                </div>

                <?= so_code_block('// List group
SODragDrop.getInstance(listElement, {
    items: \'.so-list-group-item\'
});

// Badge container
SODragDrop.getInstance(badgeContainer, {
    items: \'.so-badge\'
});', 'javascript') ?>
            </div>
        </div>

        <!-- Configuration Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Configuration Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Complete list of configuration options.</p>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-striped">
                        <thead>
                            <tr>
                                <th>Option</th>
                                <th>Type</th>
                                <th>Default</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>items</code></td>
                                <td>string|null</td>
                                <td><code>null</code></td>
                                <td>Selector for draggable items. If null, uses direct children.</td>
                            </tr>
                            <tr>
                                <td><code>handle</code></td>
                                <td>string|null</td>
                                <td><code>null</code></td>
                                <td>Selector for drag handle element within each item.</td>
                            </tr>
                            <tr>
                                <td><code>liveReorder</code></td>
                                <td>boolean</td>
                                <td><code>false</code></td>
                                <td>If true, elements reorder while dragging. If false, only on drop.</td>
                            </tr>
                            <tr>
                                <td><code>storage</code></td>
                                <td>string|null</td>
                                <td><code>null</code></td>
                                <td>'localStorage' or 'sessionStorage' for persistence.</td>
                            </tr>
                            <tr>
                                <td><code>storageKey</code></td>
                                <td>string|null</td>
                                <td><code>null</code></td>
                                <td>Unique key for storage.</td>
                            </tr>
                            <tr>
                                <td><code>disabled</code></td>
                                <td>boolean</td>
                                <td><code>false</code></td>
                                <td>Disable dragging.</td>
                            </tr>
                            <tr>
                                <td><code>ghostClass</code></td>
                                <td>string</td>
                                <td><code>'so-ghost'</code></td>
                                <td>CSS class for ghost/placeholder element.</td>
                            </tr>
                            <tr>
                                <td><code>dragClass</code></td>
                                <td>string</td>
                                <td><code>'so-dragging'</code></td>
                                <td>CSS class applied while dragging.</td>
                            </tr>
                            <tr>
                                <td><code>chosenClass</code></td>
                                <td>string</td>
                                <td><code>'so-chosen'</code></td>
                                <td>CSS class for chosen/picked element.</td>
                            </tr>
                            <tr>
                                <td><code>dragRotation</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Apply rotation effect to drag ghost.</td>
                            </tr>
                            <tr>
                                <td><code>group</code></td>
                                <td>string|null</td>
                                <td><code>null</code></td>
                                <td>Group name for cross-container dragging.</td>
                            </tr>
                            <tr>
                                <td><code>accept</code></td>
                                <td>function|string|null</td>
                                <td><code>null</code></td>
                                <td>Filter function or selector for accepted drops.</td>
                            </tr>
                            <tr>
                                <td><code>onStart</code></td>
                                <td>function|null</td>
                                <td><code>null</code></td>
                                <td>Callback when drag starts.</td>
                            </tr>
                            <tr>
                                <td><code>onMove</code></td>
                                <td>function|null</td>
                                <td><code>null</code></td>
                                <td>Callback during move. Return false to cancel.</td>
                            </tr>
                            <tr>
                                <td><code>onReorder</code></td>
                                <td>function|null</td>
                                <td><code>null</code></td>
                                <td>Callback when order changes.</td>
                            </tr>
                            <tr>
                                <td><code>onEnd</code></td>
                                <td>function|null</td>
                                <td><code>null</code></td>
                                <td>Callback when drag ends.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Attributes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Data Attributes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Configure SODragDrop using data attributes for zero-JavaScript setup.
                </p>

                <?= so_code_block('<div data-so-dragdrop
     data-so-items=".item"
     data-so-handle=".handle"
     data-so-live-reorder="true"
     data-so-storage="localStorage"
     data-so-storage-key="my-list"
     data-so-disabled="false">

    <div class="item">
        <span class="handle">Drag</span>
        Content 1
    </div>
    <div class="item">
        <span class="handle">Drag</span>
        Content 2
    </div>
</div>', 'html') ?>

                <div class="so-table-responsive so-mt-4">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Maps to</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><code>data-so-dragdrop</code></td><td>Enables auto-initialization</td></tr>
                            <tr><td><code>data-so-items</code></td><td><code>items</code></td></tr>
                            <tr><td><code>data-so-handle</code></td><td><code>handle</code></td></tr>
                            <tr><td><code>data-so-group</code></td><td><code>group</code></td></tr>
                            <tr><td><code>data-so-live-reorder</code></td><td><code>liveReorder</code></td></tr>
                            <tr><td><code>data-so-storage</code></td><td><code>storage</code></td></tr>
                            <tr><td><code>data-so-storage-key</code></td><td><code>storageKey</code></td></tr>
                            <tr><td><code>data-so-disabled</code></td><td><code>disabled</code></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<style>
.drag-handle {
    cursor: grab;
    padding: 4px;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}
.drag-handle:hover {
    background-color: rgba(0, 0, 0, 0.05);
}
.drag-handle:active {
    cursor: grabbing;
}
[data-theme="dark"] .drag-handle:hover {
    background-color: rgba(255, 255, 255, 0.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Basic demo
    const basicDemo = document.getElementById('basic-demo');
    if (basicDemo) {
        SODragDrop.getInstance(basicDemo, {
            items: '.so-card',
            liveReorder: true
        });
    }

    // Handle demo
    const handleDemo = document.getElementById('handle-demo');
    if (handleDemo) {
        SODragDrop.getInstance(handleDemo, {
            items: '.so-card',
            handle: '.drag-handle',
            liveReorder: true
        });
    }

    // Live reorder demo
    const liveReorderDemo = document.getElementById('live-reorder-demo');
    if (liveReorderDemo) {
        SODragDrop.getInstance(liveReorderDemo, {
            items: '.so-card',
            liveReorder: true
        });
    }

    // Drop-only demo
    const dropOnlyDemo = document.getElementById('drop-only-demo');
    if (dropOnlyDemo) {
        SODragDrop.getInstance(dropOnlyDemo, {
            items: '.so-card',
            liveReorder: false
        });
    }

    // Storage demo
    const storageDemo = document.getElementById('storage-demo');
    if (storageDemo) {
        SODragDrop.getInstance(storageDemo, {
            items: '.so-card',
            liveReorder: true,
            storage: 'localStorage',
            storageKey: 'storage-demo-order'
        });
    }

    // Disabled demo
    const disabledDemo = document.getElementById('disabled-demo');
    let disabledInstance = null;
    if (disabledDemo) {
        disabledInstance = SODragDrop.getInstance(disabledDemo, {
            items: '.so-card',
            liveReorder: true
        });
    }

    const toggleBtn = document.getElementById('toggle-disabled-btn');
    const statusBadge = document.getElementById('disabled-status');
    if (toggleBtn && disabledInstance) {
        let isDisabled = false;
        toggleBtn.addEventListener('click', function() {
            isDisabled = !isDisabled;
            if (isDisabled) {
                disabledInstance.disable();
                statusBadge.textContent = 'Disabled';
                statusBadge.className = 'so-badge so-badge-danger so-ms-2';
            } else {
                disabledInstance.enable();
                statusBadge.textContent = 'Enabled';
                statusBadge.className = 'so-badge so-badge-success so-ms-2';
            }
        });
    }

    // Callbacks demo
    const callbacksDemo = document.getElementById('callbacks-demo');
    const callbackLog = document.getElementById('callback-log');
    if (callbacksDemo && callbackLog) {
        const logEvent = (msg, type = 'info') => {
            const colors = { start: '#4caf50', move: '#ff9800', reorder: '#2196f3', end: '#9c27b0' };
            const time = new Date().toLocaleTimeString();
            callbackLog.innerHTML += `<div style="color: ${colors[type] || '#fff'}">[${time}] ${msg}</div>`;
            callbackLog.scrollTop = callbackLog.scrollHeight;
        };

        SODragDrop.getInstance(callbacksDemo, {
            items: '.so-card',
            liveReorder: true,
            onStart: (e, el) => logEvent('onStart: ' + el.textContent.trim(), 'start'),
            onMove: (moveEvent) => logEvent('onMove: over ' + moveEvent.target.textContent.trim(), 'move'),
            onReorder: (oldIdx, newIdx) => logEvent(`onReorder: ${oldIdx} -> ${newIdx}`, 'reorder'),
            onEnd: (e, el) => logEvent('onEnd: ' + el.textContent.trim(), 'end')
        });
    }

    // API demo
    const apiDemo = document.getElementById('api-demo');
    window.apiInstance = null;
    if (apiDemo) {
        window.apiInstance = SODragDrop.getInstance(apiDemo, {
            items: '.so-card',
            liveReorder: true
        });
    }

    // List demo
    const listDemo = document.getElementById('list-demo');
    if (listDemo) {
        SODragDrop.getInstance(listDemo, {
            items: '.so-list-group-item',
            liveReorder: true
        });
    }

    // Badge demo
    const badgeDemo = document.getElementById('badge-demo');
    if (badgeDemo) {
        SODragDrop.getInstance(badgeDemo, {
            items: '.so-badge',
            liveReorder: true
        });
    }
});

// API demo functions
function getOrderDemo() {
    const output = document.getElementById('api-output');
    if (window.apiInstance) {
        const order = window.apiInstance.getOrder();
        output.textContent = JSON.stringify(order.map(item => ({
            index: item.index,
            id: item.id
        })), null, 2);
    }
}

function reverseOrderDemo() {
    const output = document.getElementById('api-output');
    if (window.apiInstance) {
        const order = window.apiInstance.getOrder();
        const reversed = order.map(item => item.id).reverse();
        window.apiInstance.setOrder(reversed);
        output.textContent = 'Order reversed: ' + JSON.stringify(reversed);
    }
}

function refreshDemo() {
    const output = document.getElementById('api-output');
    if (window.apiInstance) {
        window.apiInstance.refresh();
        output.textContent = 'refresh() called - items re-scanned';
    }
}
</script>

<?php require_once '../includes/footer.php'; ?>
