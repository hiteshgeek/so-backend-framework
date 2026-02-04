<?php
/**
 * SixOrbit UI Demo - Tabs
 */
$pageTitle = 'Tabs';
$pageDescription = 'Tab navigation components';

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
            <h1 class="so-page-title">Tabs</h1>
            <p class="so-page-subtitle">Tab navigation components</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Default (Underline) Tabs -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Default Tabs (Underline)</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-tabs" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-default-1">Home</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-default-2">Profile</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-default-3">Settings</button>
                                    <button class="so-tab so-disabled" role="tab">Disabled</button>
                                </div>
                                <div class="so-tab-content">
                                    <div class="so-tab-pane so-fade so-show so-active" id="demo-default-1" role="tabpanel">
                                        <p>Home tab content. This is the default underline style.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-default-2" role="tabpanel">
                                        <p>Profile tab content with user information.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-default-3" role="tabpanel">
                                        <p>Settings tab content for configuration options.</p>
                                    </div>
                                </div>
<?= so_code_block('<div class="so-tabs" role="tablist" data-so-tabs>
    <button class="so-tab so-active" role="tab" data-so-target="#panel1">Home</button>
    <button class="so-tab" role="tab" data-so-target="#panel2">Profile</button>
    <button class="so-tab" role="tab" data-so-target="#panel3">Settings</button>
    <button class="so-tab so-disabled" role="tab">Disabled</button>
</div>

<div class="so-tab-content">
    <div class="so-tab-pane so-fade so-show so-active" id="panel1" role="tabpanel">
        <p>Home tab content.</p>
    </div>
    <div class="so-tab-pane so-fade" id="panel2" role="tabpanel">
        <p>Profile tab content.</p>
    </div>
    <div class="so-tab-pane so-fade" id="panel3" role="tabpanel">
        <p>Settings tab content.</p>
    </div>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Pills Variant -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Pills Variant</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-pills-1">Overview</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-pills-2">Features</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-pills-3">Pricing</button>
                                </div>
                                <div class="so-tab-content">
                                    <div class="so-tab-pane so-fade so-show so-active" id="demo-pills-1" role="tabpanel">
                                        <p>Pills have a rounded background on the active tab.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-pills-2" role="tabpanel">
                                        <p>Features content goes here.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-pills-3" role="tabpanel">
                                        <p>Pricing information displayed here.</p>
                                    </div>
                                </div>
<?= so_code_block('<div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>
    <button class="so-tab so-active" role="tab" data-so-target="#panel1">Overview</button>
    <button class="so-tab" role="tab" data-so-target="#panel2">Features</button>
    <button class="so-tab" role="tab" data-so-target="#panel3">Pricing</button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Boxed/Segmented Variant -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Boxed/Segmented Variant</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-tabs so-tabs-boxed" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-boxed-1">Day</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-boxed-2">Week</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-boxed-3">Month</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-boxed-4">Year</button>
                                </div>
                                <div class="so-tab-content">
                                    <div class="so-tab-pane so-fade so-show so-active" id="demo-boxed-1" role="tabpanel">
                                        <p>Daily view - Boxed tabs look like a segmented control.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-boxed-2" role="tabpanel">
                                        <p>Weekly view content.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-boxed-3" role="tabpanel">
                                        <p>Monthly view content.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-boxed-4" role="tabpanel">
                                        <p>Yearly view content.</p>
                                    </div>
                                </div>
<?= so_code_block('<div class="so-tabs so-tabs-boxed" role="tablist" data-so-tabs>
    <button class="so-tab so-active" role="tab" data-so-target="#panel1">Day</button>
    <button class="so-tab" role="tab" data-so-target="#panel2">Week</button>
    <button class="so-tab" role="tab" data-so-target="#panel3">Month</button>
    <button class="so-tab" role="tab" data-so-target="#panel4">Year</button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Ghost Variant -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Ghost Variant</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-tabs so-tabs-ghost" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-ghost-1">All</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-ghost-2">Active</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-ghost-3">Completed</button>
                                </div>
                                <div class="so-tab-content">
                                    <div class="so-tab-pane so-fade so-show so-active" id="demo-ghost-1" role="tabpanel">
                                        <p>Ghost tabs have minimal styling with a soft background on active.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-ghost-2" role="tabpanel">
                                        <p>Active items content.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-ghost-3" role="tabpanel">
                                        <p>Completed items content.</p>
                                    </div>
                                </div>
<?= so_code_block('<div class="so-tabs so-tabs-ghost" role="tablist" data-so-tabs>
    <button class="so-tab so-active" role="tab" data-so-target="#panel1">All</button>
    <button class="so-tab" role="tab" data-so-target="#panel2">Active</button>
    <button class="so-tab" role="tab" data-so-target="#panel3">Completed</button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Bordered Variant -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Bordered Variant</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-tabs so-tabs-bordered" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-bordered-1">Details</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-bordered-2">Reviews</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-bordered-3">FAQ</button>
                                </div>
                                <div class="so-tab-content">
                                    <div class="so-tab-pane so-fade so-show so-active" id="demo-bordered-1" role="tabpanel">
                                        <p>Bordered tabs have individual borders around each tab.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-bordered-2" role="tabpanel">
                                        <p>Reviews content goes here.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-bordered-3" role="tabpanel">
                                        <p>Frequently asked questions.</p>
                                    </div>
                                </div>
<?= so_code_block('<div class="so-tabs so-tabs-bordered" role="tablist" data-so-tabs>
    <button class="so-tab so-active" role="tab" data-so-target="#panel1">Details</button>
    <button class="so-tab" role="tab" data-so-target="#panel2">Reviews</button>
    <button class="so-tab" role="tab" data-so-target="#panel3">FAQ</button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Size Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Size Variants</h3>
                    </div>
                    <div class="so-card-body">
                                                        <h5 class="so-demo-section-title">Small Tabs</h5>
                                <div class="so-tabs so-tabs-pills so-tabs-sm so-mb-4" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-sm-1">Tab 1</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-sm-2">Tab 2</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-sm-3">Tab 3</button>
                                </div>

                                <h5 class="so-demo-section-title">Default Tabs</h5>
                                <div class="so-tabs so-tabs-pills so-mb-4" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-def-1">Tab 1</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-def-2">Tab 2</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-def-3">Tab 3</button>
                                </div>

                                <h5 class="so-demo-section-title">Large Tabs</h5>
                                <div class="so-tabs so-tabs-pills so-tabs-lg" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-lg-1">Tab 1</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-lg-2">Tab 2</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-lg-3">Tab 3</button>
                        </div>
<?= so_code_block('<!-- Small -->
<div class="so-tabs so-tabs-pills so-tabs-sm" role="tablist">...</div>

<!-- Default -->
<div class="so-tabs so-tabs-pills" role="tablist">...</div>

<!-- Large -->
<div class="so-tabs so-tabs-pills so-tabs-lg" role="tablist">...</div>', 'html') ?>
                    </div>
                </div>

                <!-- Contextual Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Contextual Colors</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1" class="so-demo-grid-gap">
                                    <div>
                                        <h5 class="so-demo-section-title-sm">Primary</h5>
                                        <div class="so-tabs so-tabs-pills so-tabs-primary so-tabs-sm" role="tablist" data-so-tabs>
                                            <button class="so-tab so-active" role="tab">Active</button>
                                            <button class="so-tab" role="tab">Tab 2</button>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="so-demo-section-title-sm">Success</h5>
                                        <div class="so-tabs so-tabs-pills so-tabs-success so-tabs-sm" role="tablist" data-so-tabs>
                                            <button class="so-tab so-active" role="tab">Active</button>
                                            <button class="so-tab" role="tab">Tab 2</button>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="so-demo-section-title-sm">Danger</h5>
                                        <div class="so-tabs so-tabs-pills so-tabs-danger so-tabs-sm" role="tablist" data-so-tabs>
                                            <button class="so-tab so-active" role="tab">Active</button>
                                            <button class="so-tab" role="tab">Tab 2</button>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="so-demo-section-title-sm">Warning</h5>
                                        <div class="so-tabs so-tabs-pills so-tabs-warning so-tabs-sm" role="tablist" data-so-tabs>
                                            <button class="so-tab so-active" role="tab">Active</button>
                                            <button class="so-tab" role="tab">Tab 2</button>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="so-demo-section-title-sm">Info</h5>
                                        <div class="so-tabs so-tabs-pills so-tabs-info so-tabs-sm" role="tablist" data-so-tabs>
                                            <button class="so-tab so-active" role="tab">Active</button>
                                            <button class="so-tab" role="tab">Tab 2</button>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="so-demo-section-title-sm">Secondary</h5>
                                        <div class="so-tabs so-tabs-pills so-tabs-secondary so-tabs-sm" role="tablist" data-so-tabs>
                                            <button class="so-tab so-active" role="tab">Active</button>
                                            <button class="so-tab" role="tab">Tab 2</button>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="so-demo-section-title-sm">Light</h5>
                                        <div class="so-tabs so-tabs-pills so-tabs-light so-tabs-sm" role="tablist" data-so-tabs>
                                            <button class="so-tab so-active" role="tab">Active</button>
                                            <button class="so-tab" role="tab">Tab 2</button>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="so-demo-section-title-sm">Dark</h5>
                                        <div class="so-tabs so-tabs-pills so-tabs-dark so-tabs-sm" role="tablist" data-so-tabs>
                                            <button class="so-tab so-active" role="tab">Active</button>
                                            <button class="so-tab" role="tab">Tab 2</button>
                                        </div>
                                    </div>
                        </div>
<?= so_code_block('<div class="so-tabs so-tabs-pills so-tabs-primary">...</div>
<div class="so-tabs so-tabs-pills so-tabs-success">...</div>
<div class="so-tabs so-tabs-pills so-tabs-danger">...</div>
<div class="so-tabs so-tabs-pills so-tabs-warning">...</div>
<div class="so-tabs so-tabs-pills so-tabs-info">...</div>
<div class="so-tabs so-tabs-pills so-tabs-secondary">...</div>
<div class="so-tabs so-tabs-pills so-tabs-light">...</div>
<div class="so-tabs so-tabs-pills so-tabs-dark">...</div>', 'html') ?>
                    </div>
                </div>

                <!-- Tabs with Icons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Tabs with Icons</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-icons-1">
                                        <span class="material-icons">home</span>
                                        Home
                                    </button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-icons-2">
                                        <span class="material-icons">person</span>
                                        Profile
                                    </button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-icons-3">
                                        <span class="material-icons">mail</span>
                                        Messages
                                    </button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-icons-4">
                                        <span class="material-icons">settings</span>
                                        Settings
                                    </button>
                                </div>
                                <div class="so-tab-content">
                                    <div class="so-tab-pane so-fade so-show so-active" id="demo-icons-1" role="tabpanel">
                                        <p>Home content with icon in tab.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-icons-2" role="tabpanel">
                                        <p>Profile content.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-icons-3" role="tabpanel">
                                        <p>Messages content.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-icons-4" role="tabpanel">
                                        <p>Settings content.</p>
                                    </div>
                                </div>
<?= so_code_block('<div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>
    <button class="so-tab so-active" role="tab" data-so-target="#panel1">
        <span class="material-icons">home</span>
        Home
    </button>
    <button class="so-tab" role="tab" data-so-target="#panel2">
        <span class="material-icons">person</span>
        Profile
    </button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Vertical Tabs -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Vertical Tabs</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-tabs-container so-tabs-container-vertical">
                                    <div class="so-tabs so-tabs-vertical" role="tablist" data-so-tabs>
                                        <button class="so-tab so-active" role="tab" data-so-target="#demo-vert-1">General</button>
                                        <button class="so-tab" role="tab" data-so-target="#demo-vert-2">Security</button>
                                        <button class="so-tab" role="tab" data-so-target="#demo-vert-3">Notifications</button>
                                        <button class="so-tab" role="tab" data-so-target="#demo-vert-4">Privacy</button>
                                    </div>
                                    <div class="so-tab-content">
                                        <div class="so-tab-pane so-fade so-show so-active" id="demo-vert-1" role="tabpanel">
                                            <h5 class="so-demo-card-title">General Settings</h5>
                                            <p>Configure your general application settings here. Vertical tabs are great for settings pages with many sections.</p>
                                        </div>
                                        <div class="so-tab-pane so-fade" id="demo-vert-2" role="tabpanel">
                                            <h5 class="so-demo-card-title">Security Settings</h5>
                                            <p>Manage your security preferences and two-factor authentication.</p>
                                        </div>
                                        <div class="so-tab-pane so-fade" id="demo-vert-3" role="tabpanel">
                                            <h5 class="so-demo-card-title">Notification Preferences</h5>
                                            <p>Control which notifications you receive and how.</p>
                                        </div>
                                        <div class="so-tab-pane so-fade" id="demo-vert-4" role="tabpanel">
                                            <h5 class="so-demo-card-title">Privacy Settings</h5>
                                            <p>Manage your privacy and data sharing preferences.</p>
                                        </div>
                                    </div>
                                </div>
<?= so_code_block('<div class="so-tabs-container so-tabs-container-vertical">
    <div class="so-tabs so-tabs-vertical" role="tablist" data-so-tabs>
        <button class="so-tab so-active" role="tab" data-so-target="#panel1">General</button>
        <button class="so-tab" role="tab" data-so-target="#panel2">Security</button>
        <button class="so-tab" role="tab" data-so-target="#panel3">Notifications</button>
    </div>
    <div class="so-tab-content">
        <div class="so-tab-pane so-fade so-show so-active" id="panel1">...</div>
        <div class="so-tab-pane so-fade" id="panel2">...</div>
        <div class="so-tab-pane so-fade" id="panel3">...</div>
    </div>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Closable Tabs -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Closable Tabs</h3>
                        <span class="so-badge so-badge-success">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-mb-3">Tabs can include close buttons to allow users to remove them. Use <code>data-so-tabs='{"closable": true}'</code> or add the close button manually.</p>
                        <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs='{"closable": true}' id="demo-closable-tabs">
                            <button class="so-tab so-active" role="tab" data-so-target="#demo-close-1">Dashboard</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-close-2">Reports</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-close-3">Analytics</button>
                            <button class="so-tab so-tab-no-close" role="tab" data-so-target="#demo-close-4">Settings</button>
                        </div>
                        <div class="so-tab-content">
                            <div class="so-tab-pane so-fade so-show so-active" id="demo-close-1" role="tabpanel">
                                <p>Dashboard tab - Try closing other tabs using the X button.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-close-2" role="tabpanel">
                                <p>Reports tab content.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-close-3" role="tabpanel">
                                <p>Analytics tab content.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-close-4" role="tabpanel">
                                <p>Settings tab - This tab cannot be closed (has <code>so-tab-no-close</code> class).</p>
                            </div>
                        </div>
<?= so_code_block('<!-- Enable closable tabs via data attribute -->
<div class="so-tabs" data-so-tabs=\'{"closable": true}\'>
    <button class="so-tab so-active" data-so-target="#panel1">Tab 1</button>
    <button class="so-tab" data-so-target="#panel2">Tab 2</button>
    <!-- Prevent close with so-tab-no-close class -->
    <button class="so-tab so-tab-no-close" data-so-target="#panel3">Permanent</button>
</div>

<!-- Or manually add close buttons -->
<button class="so-tab so-tab-closable">
    Tab Label
    <button class="so-tab-close" aria-label="Close">
        <span class="material-icons">close</span>
    </button>
</button>

// Close tab programmatically
const tabs = SOTabs.getInstance(el);
tabs.closeTab(1); // by index
tabs.closeTab(tabElement); // by element', 'html') ?>
                    </div>
                </div>

                <!-- Tab Badges & Indicators -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Tab Badges & Indicators</h3>
                        <span class="so-badge so-badge-success">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-mb-3">Add badges, counters, and dot indicators to tabs for notifications and status.</p>
                        <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs>
                            <button class="so-tab so-active" role="tab" data-so-target="#demo-badge-1">
                                <span class="material-icons">inbox</span>
                                Inbox
                                <span class="so-badge so-badge-danger">5</span>
                            </button>
                            <button class="so-tab" role="tab" data-so-target="#demo-badge-2">
                                <span class="material-icons">notifications</span>
                                Alerts
                                <span class="so-tab-dot so-tab-dot-pulse"></span>
                            </button>
                            <button class="so-tab" role="tab" data-so-target="#demo-badge-3">
                                <span class="material-icons">forum</span>
                                Messages
                                <span class="so-tab-count">128</span>
                            </button>
                            <button class="so-tab" role="tab" data-so-target="#demo-badge-4">
                                <span class="material-icons">task_alt</span>
                                Tasks
                                <span class="so-tab-dot so-tab-dot-success"></span>
                            </button>
                        </div>
                        <div class="so-tab-content">
                            <div class="so-tab-pane so-fade so-show so-active" id="demo-badge-1" role="tabpanel">
                                <p>Inbox with badge showing unread count.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-badge-2" role="tabpanel">
                                <p>Alerts with animated dot indicator.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-badge-3" role="tabpanel">
                                <p>Messages with counter badge.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-badge-4" role="tabpanel">
                                <p>Tasks with success status dot.</p>
                            </div>
                        </div>
<?= so_code_block('<!-- Badge (number) -->
<button class="so-tab">
    Inbox
    <span class="so-badge so-badge-danger">5</span>
</button>

<!-- Counter badge -->
<button class="so-tab">
    Messages
    <span class="so-tab-count">128</span>
</button>

<!-- Dot indicator with pulse animation -->
<button class="so-tab">
    Alerts
    <span class="so-tab-dot so-tab-dot-pulse"></span>
</button>

<!-- Dot colors: default (danger), success, warning, info, primary -->
<span class="so-tab-dot so-tab-dot-success"></span>
<span class="so-tab-dot so-tab-dot-warning"></span>
<span class="so-tab-dot so-tab-dot-info"></span>
<span class="so-tab-dot so-tab-dot-primary"></span>', 'html') ?>
                    </div>
                </div>

                <!-- Scroll Overflow -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Scroll Overflow (Many Tabs)</h3>
                        <span class="so-badge so-badge-success">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-mb-3">When there are many tabs, scroll buttons appear automatically. Use <code>overflow: 'scroll'</code> option (default).</p>
                        <div class="so-tabs" role="tablist" data-so-tabs='{"overflow": "scroll"}' id="demo-overflow-tabs">
                            <button class="so-tab so-active" role="tab" data-so-target="#demo-scroll-1">January</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-2">February</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-3">March</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-4">April</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-5">May</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-6">June</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-7">July</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-8">August</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-9">September</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-10">October</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-11">November</button>
                            <button class="so-tab" role="tab" data-so-target="#demo-scroll-12">December</button>
                        </div>
                        <div class="so-tab-content">
                            <div class="so-tab-pane so-fade so-show so-active" id="demo-scroll-1" role="tabpanel">
                                <p>January content - Use the scroll arrows to navigate between tabs.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-2" role="tabpanel"><p>February content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-3" role="tabpanel"><p>March content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-4" role="tabpanel"><p>April content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-5" role="tabpanel"><p>May content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-6" role="tabpanel"><p>June content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-7" role="tabpanel"><p>July content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-8" role="tabpanel"><p>August content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-9" role="tabpanel"><p>September content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-10" role="tabpanel"><p>October content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-11" role="tabpanel"><p>November content</p></div>
                            <div class="so-tab-pane so-fade" id="demo-scroll-12" role="tabpanel"><p>December content</p></div>
                        </div>
<?= so_code_block('<!-- Scroll overflow (default behavior) -->
<div class="so-tabs" data-so-tabs=\'{"overflow": "scroll"}\'>
    <button class="so-tab">Tab 1</button>
    <button class="so-tab">Tab 2</button>
    <!-- ... many tabs ... -->
    <button class="so-tab">Tab 12</button>
</div>

<!-- Overflow options: "scroll", "wrap", "none" -->', 'html') ?>
                    </div>
                </div>

                <!-- Draggable Tabs -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Draggable Tabs</h3>
                        <span class="so-badge so-badge-success">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-mb-3">Enable tab reordering by dragging. Use <code>draggable: true</code> option.</p>
                        <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs='{"draggable": true}' id="demo-draggable-tabs">
                            <button class="so-tab so-active" role="tab" data-so-target="#demo-drag-1">
                                <span class="material-icons">folder</span>
                                Documents
                            </button>
                            <button class="so-tab" role="tab" data-so-target="#demo-drag-2">
                                <span class="material-icons">image</span>
                                Images
                            </button>
                            <button class="so-tab" role="tab" data-so-target="#demo-drag-3">
                                <span class="material-icons">movie</span>
                                Videos
                            </button>
                            <button class="so-tab" role="tab" data-so-target="#demo-drag-4">
                                <span class="material-icons">audio_file</span>
                                Music
                            </button>
                        </div>
                        <div class="so-tab-content">
                            <div class="so-tab-pane so-fade so-show so-active" id="demo-drag-1" role="tabpanel">
                                <p>Documents - Drag tabs to reorder them.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-drag-2" role="tabpanel">
                                <p>Images content.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-drag-3" role="tabpanel">
                                <p>Videos content.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-drag-4" role="tabpanel">
                                <p>Music content.</p>
                            </div>
                        </div>
<?= so_code_block('<!-- Enable draggable tabs -->
<div class="so-tabs" data-so-tabs=\'{"draggable": true}\'>
    <button class="so-tab">Tab 1</button>
    <button class="so-tab">Tab 2</button>
    <button class="so-tab">Tab 3</button>
</div>

// Listen for reorder events
tabsEl.addEventListener(\'so:tab:reorder\', (e) => {
    console.log(\'Tab reordered\', e.detail.tabs);
});', 'html') ?>
                    </div>
                </div>

                <!-- Dynamic Tabs -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Dynamic Tabs (Add/Remove)</h3>
                        <span class="so-badge so-badge-success">New</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-mb-3">Add and remove tabs dynamically using JavaScript API. Combine with closable tabs for full dynamic control.</p>
                        <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs='{"closable": true}' id="demo-dynamic-tabs">
                            <button class="so-tab so-active so-tab-no-close" role="tab" data-so-target="#demo-dynamic-1">
                                <span class="material-icons">home</span>
                                Home
                            </button>
                            <button class="so-tab" role="tab" data-so-target="#demo-dynamic-2">Tab 2</button>
                            <button type="button" class="so-tab-add" aria-label="Add new tab">
                                <span class="material-icons">add</span>
                            </button>
                        </div>
                        <div class="so-tab-content" id="demo-dynamic-content">
                            <div class="so-tab-pane so-fade so-show so-active" id="demo-dynamic-1" role="tabpanel">
                                <p>Home tab - Click the + button to add new tabs, or close existing ones.</p>
                            </div>
                            <div class="so-tab-pane so-fade" id="demo-dynamic-2" role="tabpanel">
                                <p>Tab 2 content.</p>
                            </div>
                        </div>
                        <div class="so-mt-3">
                            <button class="so-btn so-btn-primary so-btn-sm" onclick="addDynamicTab()">
                                <span class="material-icons">add</span> Add Tab via JS
                            </button>
                        </div>
<?= so_code_block('// Add tab dynamically
const tabs = SOTabs.getInstance(tabsEl);

tabs.addTab({
    label: \'New Tab\',
    content: \'<p>Tab content here</p>\',
    icon: \'description\',  // Material icon name
    closable: true,       // Can be closed
    activate: true,       // Activate immediately
    position: \'end\'       // \'start\', \'end\', or index
});

// Close tab programmatically
tabs.closeTab(tabElement);
tabs.closeTab(2); // by index

// With confirmation callback
const tabs = new SOTabs(el, {
    closable: true,
    closeConfirm: (tab, pane) => {
        return confirm(\'Close this tab?\');
    }
});

// Events
tabsEl.addEventListener(\'so:tab:close\', (e) => {
    console.log(\'Tab closing\', e.target);
    // e.preventDefault(); // Cancel close
});

tabsEl.addEventListener(\'so:tab:closed\', (e) => {
    console.log(\'Tab closed\', e.detail);
});

tabsEl.addEventListener(\'so:tab:add\', (e) => {
    console.log(\'Tab added\', e.detail.tab);
});', 'javascript') ?>
                    </div>
                </div>

                <!-- Alignment Options -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Alignment Options</h3>
                    </div>
                    <div class="so-card-body">
                                                        <h5 class="so-demo-section-title-sm">Center Aligned</h5>
                                <div class="so-tabs so-tabs-center so-mb-4" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab">Tab 1</button>
                                    <button class="so-tab" role="tab">Tab 2</button>
                                    <button class="so-tab" role="tab">Tab 3</button>
                                </div>

                                <h5 class="so-demo-section-title-sm">Right Aligned</h5>
                                <div class="so-tabs so-tabs-end so-mb-4" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab">Tab 1</button>
                                    <button class="so-tab" role="tab">Tab 2</button>
                                    <button class="so-tab" role="tab">Tab 3</button>
                                </div>

                                <h5 class="so-demo-section-title-sm">Justified (Full Width)</h5>
                                <div class="so-tabs so-tabs-justified" role="tablist" data-so-tabs>
                                    <button class="so-tab so-active" role="tab">Tab 1</button>
                                    <button class="so-tab" role="tab">Tab 2</button>
                                    <button class="so-tab" role="tab">Tab 3</button>
                        </div>
<?= so_code_block('<!-- Center aligned -->
<div class="so-tabs so-tabs-center" role="tablist">...</div>

<!-- Right aligned -->
<div class="so-tabs so-tabs-end" role="tablist">...</div>

<!-- Justified (equal width) -->
<div class="so-tabs so-tabs-justified" role="tablist">...</div>

<!-- Fill (proportional) -->
<div class="so-tabs so-tabs-fill" role="tablist">...</div>', 'html') ?>
                    </div>
                </div>

                <!-- JavaScript Events -->
                <div class="so-card">
                    <div class="so-card-header">
                        <h3 class="so-card-title">JavaScript API & Events</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-tabs so-tabs-pills" role="tablist" data-so-tabs id="demo-events-tabs">
                                    <button class="so-tab so-active" role="tab" data-so-target="#demo-events-1">Tab 1</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-events-2">Tab 2</button>
                                    <button class="so-tab" role="tab" data-so-target="#demo-events-3">Tab 3</button>
                                </div>
                                <div class="so-tab-content">
                                    <div class="so-tab-pane so-fade so-show so-active" id="demo-events-1" role="tabpanel">
                                        <p>Tab 1 content - Check the console to see events firing.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-events-2" role="tabpanel">
                                        <p>Tab 2 content.</p>
                                    </div>
                                    <div class="so-tab-pane so-fade" id="demo-events-3" role="tabpanel">
                                        <p>Tab 3 content.</p>
                                    </div>
                                </div>
                                <div>
                                    <button class="so-btn so-btn-outline so-btn-sm" onclick="demoTabsNext()">Next Tab</button>
                                    <button class="so-btn so-btn-outline so-btn-sm" onclick="demoTabsPrev()">Previous Tab</button>
                                    <button class="so-btn so-btn-outline so-btn-sm" onclick="demoTabsShowById()">Show Tab 3</button>
                                </div>
                                <p class="so-demo-note">Open browser console to see event logs</p>
<?= so_code_block('// Get tabs instance
const tabsEl = document.querySelector(\'#my-tabs\');
const tabs = SOTabs.getInstance(tabsEl);

// Navigation methods
tabs.show(2);           // Show tab by index (0-based)
tabs.showById(\'panel3\'); // Show tab by target ID
tabs.next();            // Go to next tab
tabs.prev();            // Go to previous tab
tabs.getActiveTab();    // Get active tab element
tabs.getActiveIndex();  // Get active tab index
tabs.getTabs();         // Get all tab elements
tabs.refresh();         // Re-scan for tab elements

// Dynamic tabs
tabs.addTab({
    label: \'New Tab\',
    content: \'<p>Content</p>\',
    icon: \'description\',
    closable: true,
    activate: true,
    position: \'end\'
});
tabs.closeTab(2);       // Close by index
tabs.closeTab(tabEl);   // Close by element

// Configuration options
new SOTabs(el, {
    autoActivate: false,  // Activate on focus
    animation: true,      // Fade animation
    keyboard: true,       // Arrow key navigation
    closable: false,      // Enable close buttons
    draggable: false,     // Enable drag reorder
    overflow: \'scroll\',   // \'scroll\', \'wrap\', \'none\'
    scrollStep: 150,      // Scroll amount in pixels
    closeConfirm: null,   // (tab, pane) => boolean
    onAdd: null           // Called when add button clicked
});

// Events (use \'so:\' prefix)
tabsEl.addEventListener(\'so:tab:show\', (e) => {
    console.log(\'About to show:\', e.target);
    // e.preventDefault(); // Cancel tab change
});
tabsEl.addEventListener(\'so:tab:shown\', (e) => { });
tabsEl.addEventListener(\'so:tab:hide\', (e) => { });
tabsEl.addEventListener(\'so:tab:hidden\', (e) => { });
tabsEl.addEventListener(\'so:tab:close\', (e) => { });
tabsEl.addEventListener(\'so:tab:closed\', (e) => { });
tabsEl.addEventListener(\'so:tab:reorder\', (e) => { });
tabsEl.addEventListener(\'so:tab:add\', (e) => { });', 'javascript') ?>
                    </div>
                </div>

    </div>
</main>

<script>
// Demo functions for JavaScript API section
function demoTabsNext() {
    const tabsEl = document.querySelector('#demo-events-tabs');
    if (tabsEl && typeof SOTabs !== 'undefined') {
        const tabs = SOTabs.getInstance(tabsEl);
        if (tabs) tabs.next();
    }
}

function demoTabsPrev() {
    const tabsEl = document.querySelector('#demo-events-tabs');
    if (tabsEl && typeof SOTabs !== 'undefined') {
        const tabs = SOTabs.getInstance(tabsEl);
        if (tabs) tabs.prev();
    }
}

function demoTabsShowById() {
    const tabsEl = document.querySelector('#demo-events-tabs');
    if (tabsEl && typeof SOTabs !== 'undefined') {
        const tabs = SOTabs.getInstance(tabsEl);
        if (tabs) tabs.showById('demo-events-3');
    }
}

// Dynamic tabs counter
let dynamicTabCounter = 3;

// Add dynamic tab function
function addDynamicTab() {
    const tabsEl = document.querySelector('#demo-dynamic-tabs');
    if (tabsEl && typeof SOTabs !== 'undefined') {
        const tabs = SOTabs.getInstance(tabsEl);
        if (tabs) {
            const icons = ['description', 'code', 'analytics', 'settings', 'account_circle', 'shopping_cart'];
            const randomIcon = icons[Math.floor(Math.random() * icons.length)];

            tabs.addTab({
                label: `Tab ${dynamicTabCounter}`,
                content: `<p>This is dynamically added Tab ${dynamicTabCounter}. You can close it using the X button.</p>`,
                icon: randomIcon,
                closable: true,
                activate: true
            });
            dynamicTabCounter++;
        }
    }
}

// Event listeners for demo
document.addEventListener('DOMContentLoaded', function() {
    // JavaScript API demo events
    const tabsEl = document.querySelector('#demo-events-tabs');
    if (tabsEl) {
        tabsEl.addEventListener('so:tab:show', (e) => {
            console.log('so:tab:show - About to show:', e.detail);
        });
        tabsEl.addEventListener('so:tab:shown', (e) => {
            console.log('so:tab:shown - Tab shown:', e.detail);
        });
        tabsEl.addEventListener('so:tab:hide', (e) => {
            console.log('so:tab:hide - About to hide:', e.detail);
        });
        tabsEl.addEventListener('so:tab:hidden', (e) => {
            console.log('so:tab:hidden - Tab hidden:', e.detail);
        });
    }

    // Closable tabs events
    const closableTabsEl = document.querySelector('#demo-closable-tabs');
    if (closableTabsEl) {
        closableTabsEl.addEventListener('so:tab:close', (e) => {
            console.log('so:tab:close - Closing tab:', e.target);
        });
        closableTabsEl.addEventListener('so:tab:closed', (e) => {
            console.log('so:tab:closed - Tab closed, remaining:', e.detail.remainingTabs);
        });
    }

    // Draggable tabs events
    const draggableTabsEl = document.querySelector('#demo-draggable-tabs');
    if (draggableTabsEl) {
        draggableTabsEl.addEventListener('so:tab:reorder', (e) => {
            console.log('so:tab:reorder - Tabs reordered:', e.detail.tabs);
        });
    }

    // Dynamic tabs - handle add button click
    const dynamicTabsEl = document.querySelector('#demo-dynamic-tabs');
    if (dynamicTabsEl) {
        dynamicTabsEl.addEventListener('so:tab:add', (e) => {
            console.log('so:tab:add - Tab added:', e.detail.tab);
        });
        dynamicTabsEl.addEventListener('so:tab:closed', (e) => {
            console.log('so:tab:closed - Dynamic tab closed');
        });

        // Handle the add button
        const addBtn = dynamicTabsEl.querySelector('.so-tab-add');
        if (addBtn) {
            addBtn.addEventListener('click', addDynamicTab);
        }
    }
});
</script>

<?php
require_once '../includes/footer.php';
?>
