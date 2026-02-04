<?php
/**
 * SixOrbit UI Demo - Offcanvas/Drawer
 */
$pageTitle = 'Offcanvas';
$pageDescription = 'Slide-out drawer panels';

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
            <h1 class="so-page-title">Offcanvas / Drawer</h1>
            <p class="so-page-subtitle">Slide-out drawer panels for side content, forms, and navigation</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <!-- Basic Drawer (Right) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Drawer (Right Side)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">A standard drawer that slides in from the right side of the screen.</p>

                <button type="button" class="so-btn so-btn-primary" onclick="showDrawer('basicDrawer')">
                    Open Right Drawer
                </button>

<?= so_code_block('<div class="so-drawer" id="myDrawer">
    <div class="so-drawer-header">
        <h5 class="so-drawer-title">Drawer Title</h5>
        <button class="so-drawer-close" data-dismiss="drawer">
            <span class="material-icons">close</span>
        </button>
    </div>
    <div class="so-drawer-body">
        Drawer content goes here...
    </div>
    <div class="so-drawer-footer">
        <button class="so-btn so-btn-outline" data-dismiss="drawer">Cancel</button>
        <button class="so-btn so-btn-primary">Save</button>
    </div>
</div>

<script>
const drawer = SODrawer.getInstance(\'#myDrawer\');
drawer.show();
</script>', 'html') ?>
            </div>
        </div>

        <!-- Left Side Drawer -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Left Side Drawer</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Add <code>.so-drawer-left</code> to make the drawer slide from the left.</p>

                <button type="button" class="so-btn so-btn-primary" onclick="showDrawer('leftDrawer')">
                    Open Left Drawer
                </button>

<?= so_code_block('<div class="so-drawer so-drawer-left" id="leftDrawer">
    <!-- Drawer content -->
</div>', 'html') ?>
            </div>
        </div>

        <!-- Drawer Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Drawer Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Drawers come in different sizes: small (320px), default (400px), large (560px), and extra-large (720px).</p>

                <div class="so-btn-group so-flex-wrap">
                    <button type="button" class="so-btn so-btn-outline" onclick="showSizeDrawer('sm')">Small (320px)</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="showSizeDrawer('default')">Default (400px)</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="showSizeDrawer('lg')">Large (560px)</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="showSizeDrawer('xl')">Extra Large (720px)</button>
                </div>

<?= so_code_block('<!-- Small Drawer (320px) -->
<div class="so-drawer so-drawer-sm">...</div>

<!-- Default Drawer (400px) -->
<div class="so-drawer">...</div>

<!-- Large Drawer (560px) -->
<div class="so-drawer so-drawer-lg">...</div>

<!-- Extra Large Drawer (720px) -->
<div class="so-drawer so-drawer-xl">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Static Backdrop -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Static Backdrop (Non-Dismissible)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">A static drawer cannot be closed by clicking the backdrop or pressing Escape. The user must use the action buttons. Clicking the backdrop shows a shake animation.</p>

                <button type="button" class="so-btn so-btn-warning" onclick="showStaticDrawer()">
                    Open Static Drawer
                </button>

<?= so_code_block('<!-- Via class -->
<div class="so-drawer so-drawer-static" id="staticDrawer">
    <!-- No close button shown -->
</div>

<!-- Via data attribute -->
<div class="so-drawer" data-so-static>...</div>

<!-- Via JavaScript -->
<script>
SODrawer.create({
    title: \'Confirm Action\',
    content: \'Please confirm to continue.\',
    static: true,
    footer: \'<button class="so-btn so-btn-primary" data-dismiss="drawer">Confirm</button>\'
}).show();
</script>', 'html') ?>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Scrollable Content</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">When content exceeds the drawer height, the body section becomes scrollable while the header and footer remain fixed.</p>

                <button type="button" class="so-btn so-btn-primary" onclick="showScrollableDrawer()">
                    Open Scrollable Drawer
                </button>

<?= so_code_block('<div class="so-drawer">
    <div class="so-drawer-header">...</div>
    <div class="so-drawer-body">
        <!-- Long scrollable content -->
        <!-- The .so-drawer-body has overflow-y: auto -->
    </div>
    <div class="so-drawer-footer">...</div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Programmatic Creation -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Programmatic Creation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Create drawers dynamically using <code>SODrawer.create()</code>. The drawer is automatically removed from the DOM when closed.</p>

                <button type="button" class="so-btn so-btn-primary" onclick="createDynamicDrawer()">
                    Create Drawer Dynamically
                </button>

<?= so_code_block('const drawer = SODrawer.create({
    title: \'Dynamic Drawer\',
    content: \'<p>This drawer was created dynamically!</p>\',
    position: \'right\',  // \'left\' or \'right\'
    size: \'default\',    // \'sm\', \'default\', \'lg\', \'xl\'
    closable: true,
    static: false,
    footer: `
        <button class="so-btn so-btn-outline" data-dismiss="drawer">Cancel</button>
        <button class="so-btn so-btn-primary">Save</button>
    `
});

drawer.show();

// Listen to events
drawer.element.addEventListener(\'drawer:hidden\', () => {
    console.log(\'Drawer was closed\');
});', 'javascript') ?>
            </div>
        </div>

        <!-- JavaScript API -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript API</h3>
            </div>
            <div class="so-card-body">
                <h5 class="so-mb-3">Methods</h5>
                <div class="so-table-container so-mb-4">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>show()</code></td>
                                <td>Opens the drawer</td>
                            </tr>
                            <tr>
                                <td><code>hide()</code></td>
                                <td>Closes the drawer</td>
                            </tr>
                            <tr>
                                <td><code>toggle()</code></td>
                                <td>Toggles the drawer visibility</td>
                            </tr>
                            <tr>
                                <td><code>isOpen()</code></td>
                                <td>Returns <code>true</code> if the drawer is currently open</td>
                            </tr>
                            <tr>
                                <td><code>setContent(html)</code></td>
                                <td>Sets the drawer body content</td>
                            </tr>
                            <tr>
                                <td><code>setTitle(text)</code></td>
                                <td>Sets the drawer header title</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mb-3">Events</h5>
                <div class="so-table-container so-mb-4">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>drawer:show</code></td>
                                <td>Fired before the drawer is shown (can be prevented)</td>
                            </tr>
                            <tr>
                                <td><code>drawer:shown</code></td>
                                <td>Fired after the drawer is fully shown</td>
                            </tr>
                            <tr>
                                <td><code>drawer:hide</code></td>
                                <td>Fired before the drawer is hidden (can be prevented)</td>
                            </tr>
                            <tr>
                                <td><code>drawer:hidden</code></td>
                                <td>Fired after the drawer is fully hidden</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mb-3">Options</h5>
                <div class="so-table-container">
                    <table class="so-table">
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
                                <td><code>backdrop</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Show backdrop behind drawer</td>
                            </tr>
                            <tr>
                                <td><code>keyboard</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Close drawer when Escape is pressed</td>
                            </tr>
                            <tr>
                                <td><code>scroll</code></td>
                                <td>boolean</td>
                                <td><code>false</code></td>
                                <td>Allow body scroll while drawer is open</td>
                            </tr>
                            <tr>
                                <td><code>static</code></td>
                                <td>boolean</td>
                                <td><code>false</code></td>
                                <td>Non-dismissible mode (must use buttons)</td>
                            </tr>
                            <tr>
                                <td><code>animation</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Animate open/close transitions</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Drawer Templates -->
<!-- Basic Drawer -->
<div class="so-drawer" id="basicDrawer">
    <div class="so-drawer-header">
        <h5 class="so-drawer-title">Basic Drawer</h5>
        <button class="so-drawer-close" data-dismiss="drawer">
            <span class="material-icons">close</span>
        </button>
    </div>
    <div class="so-drawer-body">
        <p>This is a basic drawer that slides in from the right side of the screen.</p>
        <p class="so-mt-3">Drawers are great for:</p>
        <ul class="so-mt-2">
            <li>Side navigation menus</li>
            <li>Form panels</li>
            <li>Detail views</li>
            <li>Settings panels</li>
            <li>Shopping carts</li>
        </ul>
    </div>
    <div class="so-drawer-footer">
        <button class="so-btn so-btn-outline" data-dismiss="drawer">Cancel</button>
        <button class="so-btn so-btn-primary" data-dismiss="drawer">Save Changes</button>
    </div>
</div>

<!-- Left Drawer -->
<div class="so-drawer so-drawer-left" id="leftDrawer">
    <div class="so-drawer-header">
        <h5 class="so-drawer-title">Left Drawer</h5>
        <button class="so-drawer-close" data-dismiss="drawer">
            <span class="material-icons">close</span>
        </button>
    </div>
    <div class="so-drawer-body">
        <p>This drawer slides in from the left side of the screen.</p>
        <p class="so-mt-3">Left-side drawers are commonly used for:</p>
        <ul class="so-mt-2">
            <li>Main navigation menus</li>
            <li>Filter panels</li>
            <li>Table of contents</li>
        </ul>
    </div>
    <div class="so-drawer-footer">
        <button class="so-btn so-btn-primary" data-dismiss="drawer">Close</button>
    </div>
</div>

<!-- Static Drawer -->
<div class="so-drawer so-drawer-static" id="staticDrawer">
    <div class="so-drawer-header">
        <h5 class="so-drawer-title">Confirm Your Action</h5>
    </div>
    <div class="so-drawer-body">
        <div class="so-text-center so-py-4">
            <span class="material-icons so-text-warning" style="font-size: 48px;">warning</span>
            <h4 class="so-mt-3">Are you sure?</h4>
            <p class="so-text-secondary so-mt-2">This drawer cannot be dismissed by clicking outside or pressing Escape. You must use the buttons below.</p>
        </div>
    </div>
    <div class="so-drawer-footer">
        <button class="so-btn so-btn-outline" onclick="hideStaticDrawer()">Cancel</button>
        <button class="so-btn so-btn-warning" onclick="hideStaticDrawer()">Confirm Action</button>
    </div>
</div>

<script>
// Show drawer by ID
function showDrawer(id) {
    const drawer = SODrawer.getInstance(document.getElementById(id));
    drawer.show();
}

// Show size drawer
function showSizeDrawer(size) {
    const sizeClass = size !== 'default' ? `so-drawer-${size}` : '';
    const drawer = SODrawer.create({
        title: `${size.charAt(0).toUpperCase() + size.slice(1)} Drawer`,
        content: `<p>This is a ${size} drawer (${size === 'sm' ? '320px' : size === 'lg' ? '560px' : size === 'xl' ? '720px' : '400px'} wide).</p>`,
        size: size,
        footer: '<button class="so-btn so-btn-primary" data-dismiss="drawer">Close</button>'
    });
    drawer.show();
}

// Show static drawer
function showStaticDrawer() {
    const drawer = SODrawer.getInstance(document.getElementById('staticDrawer'));
    drawer.show();
}

// Hide static drawer (manual close)
function hideStaticDrawer() {
    const drawer = SODrawer.getInstance(document.getElementById('staticDrawer'));
    drawer.hide();
}

// Show scrollable drawer
function showScrollableDrawer() {
    const longContent = `
        <p>This drawer has a lot of content that demonstrates the scrolling behavior.</p>
        ${Array(15).fill().map((_, i) => `
            <div class="so-card so-mb-3">
                <div class="so-card-body">
                    <h5>Item ${i + 1}</h5>
                    <p class="so-text-secondary">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>
            </div>
        `).join('')}
    `;

    const drawer = SODrawer.create({
        title: 'Scrollable Content',
        content: longContent,
        size: 'default',
        footer: '<button class="so-btn so-btn-primary" data-dismiss="drawer">Close</button>'
    });
    drawer.show();
}

// Create dynamic drawer
function createDynamicDrawer() {
    const drawer = SODrawer.create({
        title: 'Dynamic Drawer',
        content: `
            <p>This drawer was created dynamically using <code>SODrawer.create()</code>.</p>
            <p class="so-mt-3">It will be automatically removed from the DOM when closed.</p>
            <div class="so-alert so-alert-info so-mt-4">
                <span class="material-icons">info</span>
                <div>
                    <strong>Tip:</strong> Use dynamic drawers for one-time actions like confirmations or quick forms.
                </div>
            </div>
        `,
        position: 'right',
        size: 'default',
        footer: `
            <button class="so-btn so-btn-outline" data-dismiss="drawer">Cancel</button>
            <button class="so-btn so-btn-primary" data-dismiss="drawer">Confirm</button>
        `
    });

    drawer.element.addEventListener('drawer:shown', () => {
        console.log('Dynamic drawer is now visible');
    });

    drawer.element.addEventListener('drawer:hidden', () => {
        console.log('Dynamic drawer has been closed and removed from DOM');
    });

    drawer.show();
}
</script>

<?php require_once '../includes/footer.php'; ?>
