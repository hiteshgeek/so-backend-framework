<?php
/**
 * SixOrbit UI Demo - Empty States
 */
$pageTitle = 'Empty States';
$pageDescription = 'Placeholder components to display when content is empty, missing, or an action is needed.';

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
            <h1 class="so-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="so-page-subtitle"><?= htmlspecialchars($pageDescription) ?></p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

<!-- Basic Empty State -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Basic Empty State</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Simple empty state with icon, title, and description.</p>

                <div class="so-empty-state">
                    <div class="so-empty-state-icon">
                        <span class="material-icons">inbox</span>
                    </div>
                    <h3 class="so-empty-state-title">No messages yet</h3>
                    <p class="so-empty-state-text">Your inbox is empty. When you receive new messages, they'll appear here.</p>
                </div>
        <?= so_code_block('<div class="so-empty-state">
    <div class="so-empty-state-icon">
        <span class="material-icons">inbox</span>
    </div>
    <h3 class="so-empty-state-title">No messages yet</h3>
    <p class="so-empty-state-text">Your inbox is empty.</p>
</div>', 'html') ?>
    </div>
</div>

<!-- Empty State with Action -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Empty State with Action</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Include a call-to-action button to guide users.</p>

                <div class="so-empty-state">
                    <div class="so-empty-state-icon">
                        <span class="material-icons">folder_open</span>
                    </div>
                    <h3 class="so-empty-state-title">No projects found</h3>
                    <p class="so-empty-state-text">Get started by creating your first project. It only takes a minute.</p>
                    <div class="so-empty-state-actions">
                        <button class="so-btn so-btn-primary">
                            <span class="material-icons">add</span>
                            Create Project
                        </button>
                    </div>
                </div>
        <?= so_code_block('<div class="so-empty-state">
    <div class="so-empty-state-icon">
        <span class="material-icons">folder_open</span>
    </div>
    <h3 class="so-empty-state-title">No projects found</h3>
    <p class="so-empty-state-text">Get started by creating your first project.</p>
    <div class="so-empty-state-actions">
        <button class="so-btn so-btn-primary">
            <span class="material-icons">add</span>
            Create Project
        </button>
    </div>
</div>', 'html') ?>
    </div>
</div>

<!-- Search Empty State -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Search Empty State</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Show when search returns no results.</p>

                <div class="so-empty-state">
                    <div class="so-empty-state-icon">
                        <span class="material-icons">search_off</span>
                    </div>
                    <h3 class="so-empty-state-title">No results found</h3>
                    <p class="so-empty-state-text">We couldn't find anything matching "design system". Try different keywords or check for typos.</p>
                    <div class="so-empty-state-actions">
                        <button class="so-btn so-btn-outline">Clear Search</button>
                    </div>
                </div>
        <?= so_code_block('<div class="so-empty-state">
    <div class="so-empty-state-icon">
        <span class="material-icons">search_off</span>
    </div>
    <h3 class="so-empty-state-title">No results found</h3>
    <p class="so-empty-state-text">We couldn\'t find anything matching...</p>
    <div class="so-empty-state-actions">
        <button class="so-btn so-btn-outline">Clear Search</button>
    </div>
</div>', 'html') ?>
    </div>
</div>

<!-- Error State -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Error State</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Display when something goes wrong.</p>

                <div class="so-empty-state so-empty-state-danger">
                    <div class="so-empty-state-icon">
                        <span class="material-icons">error_outline</span>
                    </div>
                    <h3 class="so-empty-state-title">Something went wrong</h3>
                    <p class="so-empty-state-text">We're having trouble loading your data. Please try again or contact support if the problem persists.</p>
                    <div class="so-empty-state-actions">
                        <button class="so-btn so-btn-danger">
                            <span class="material-icons">refresh</span>
                            Try Again
                        </button>
                        <button class="so-btn so-btn-outline">Contact Support</button>
                    </div>
                </div>
        <?= so_code_block('<div class="so-empty-state so-empty-state-danger">
    <div class="so-empty-state-icon">
        <span class="material-icons">error_outline</span>
    </div>
    <h3 class="so-empty-state-title">Something went wrong</h3>
    <p class="so-empty-state-text">We\'re having trouble loading your data.</p>
    <div class="so-empty-state-actions">
        <button class="so-btn so-btn-danger">Try Again</button>
        <button class="so-btn so-btn-outline">Contact Support</button>
    </div>
</div>', 'html') ?>
    </div>
</div>

<!-- Success State -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Success State</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Celebrate successful completions.</p>

                <div class="so-empty-state so-empty-state-success">
                    <div class="so-empty-state-icon">
                        <span class="material-icons">check_circle</span>
                    </div>
                    <h3 class="so-empty-state-title">All caught up!</h3>
                    <p class="so-empty-state-text">You've completed all your tasks for today. Great work!</p>
                    <div class="so-empty-state-actions">
                        <button class="so-btn so-btn-success">View Completed Tasks</button>
                    </div>
                </div>
        <?= so_code_block('<div class="so-empty-state so-empty-state-success">
    <div class="so-empty-state-icon">
        <span class="material-icons">check_circle</span>
    </div>
    <h3 class="so-empty-state-title">All caught up!</h3>
    <p class="so-empty-state-text">You\'ve completed all your tasks.</p>
    <div class="so-empty-state-actions">
        <button class="so-btn so-btn-success">View Completed Tasks</button>
    </div>
</div>', 'html') ?>
    </div>
</div>

<!-- No Permission State -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">No Permission State</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Display when user lacks access to content.</p>

                <div class="so-empty-state so-empty-state-no-permission">
                    <div class="so-empty-state-icon">
                        <span class="material-icons">lock</span>
                    </div>
                    <h3 class="so-empty-state-title">Access Denied</h3>
                    <p class="so-empty-state-text">You don't have permission to view this content. Contact your administrator to request access.</p>
                    <div class="so-empty-state-actions">
                        <button class="so-btn so-btn-secondary">Request Access</button>
                        <button class="so-btn so-btn-outline">Go Back</button>
                    </div>
                </div>
        <?= so_code_block('<div class="so-empty-state so-empty-state-no-permission">
    <div class="so-empty-state-icon">
        <span class="material-icons">lock</span>
    </div>
    <h3 class="so-empty-state-title">Access Denied</h3>
    <p class="so-empty-state-text">You don\'t have permission to view this content.</p>
    <div class="so-empty-state-actions">
        <button class="so-btn so-btn-secondary">Request Access</button>
        <button class="so-btn so-btn-outline">Go Back</button>
    </div>
</div>', 'html') ?>
    </div>
</div>

<!-- Contextual Presets -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Contextual Presets</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Pre-styled variants for common scenarios. Each preset includes colored icon backgrounds.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-empty-state so-empty-state-sm so-empty-state-search">
                                <div class="so-empty-state-icon">
                                    <span class="material-icons">search</span>
                                </div>
                                <h4 class="so-empty-state-title">.so-empty-state-search</h4>
                                <p class="so-empty-state-text">For search results</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-empty-state so-empty-state-sm so-empty-state-error">
                                <div class="so-empty-state-icon">
                                    <span class="material-icons">error</span>
                                </div>
                                <h4 class="so-empty-state-title">.so-empty-state-error</h4>
                                <p class="so-empty-state-text">For error states</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-empty-state so-empty-state-sm so-empty-state-success">
                                <div class="so-empty-state-icon">
                                    <span class="material-icons">check_circle</span>
                                </div>
                                <h4 class="so-empty-state-title">.so-empty-state-success</h4>
                                <p class="so-empty-state-text">For success states</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-empty-state so-empty-state-sm so-empty-state-warning">
                                <div class="so-empty-state-icon">
                                    <span class="material-icons">warning</span>
                                </div>
                                <h4 class="so-empty-state-title">.so-empty-state-warning</h4>
                                <p class="so-empty-state-text">For warning states</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-empty-state so-empty-state-sm so-empty-state-info">
                                <div class="so-empty-state-icon">
                                    <span class="material-icons">info</span>
                                </div>
                                <h4 class="so-empty-state-title">.so-empty-state-info</h4>
                                <p class="so-empty-state-text">For info states</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-empty-state so-empty-state-sm so-empty-state-no-permission">
                                <div class="so-empty-state-icon">
                                    <span class="material-icons">lock</span>
                                </div>
                                <h4 class="so-empty-state-title">.so-empty-state-no-permission</h4>
                                <p class="so-empty-state-text">For access denied</p>
                            </div>
                        </div>
                    </div>
                </div>
        <?= so_code_block('<!-- Contextual preset classes -->
<div class="so-empty-state so-empty-state-search">...</div>
<div class="so-empty-state so-empty-state-error">...</div>
<div class="so-empty-state so-empty-state-success">...</div>
<div class="so-empty-state so-empty-state-warning">...</div>
<div class="so-empty-state so-empty-state-info">...</div>
<div class="so-empty-state so-empty-state-no-permission">...</div>

<!-- Alternative class names -->
<div class="so-empty-state so-empty-state-danger">...</div>
<div class="so-empty-state so-empty-state-forbidden">...</div>', 'html') ?>
    </div>
</div>

<!-- Size Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Size Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Different sizes for various contexts.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-body">
                                <h6 class="so-text-muted so-mb-3">Small</h6>
                                <div class="so-empty-state so-empty-state-sm">
                                    <div class="so-empty-state-icon">
                                        <span class="material-icons">notifications_none</span>
                                    </div>
                                    <h4 class="so-empty-state-title">No notifications</h4>
                                    <p class="so-empty-state-text">You're all caught up.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-body">
                                <h6 class="so-text-muted so-mb-3">Default</h6>
                                <div class="so-empty-state">
                                    <div class="so-empty-state-icon">
                                        <span class="material-icons">notifications_none</span>
                                    </div>
                                    <h4 class="so-empty-state-title">No notifications</h4>
                                    <p class="so-empty-state-text">When there's activity, you'll see it here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-body">
                                <h6 class="so-text-muted so-mb-3">Large</h6>
                                <div class="so-empty-state so-empty-state-lg">
                                    <div class="so-empty-state-icon">
                                        <span class="material-icons">notifications_none</span>
                                    </div>
                                    <h4 class="so-empty-state-title">No notifications</h4>
                                    <p class="so-empty-state-text">When there's activity, you'll see it here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?= so_code_block('<!-- Small -->
<div class="so-empty-state so-empty-state-sm">...</div>

<!-- Default -->
<div class="so-empty-state">...</div>

<!-- Large -->
<div class="so-empty-state so-empty-state-lg">...</div>', 'html') ?>
    </div>
</div>

<!-- Compact Empty State -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Compact Empty State</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Minimal empty state for inline use.</p>

                <div class="so-empty-state so-empty-state-compact">
                    <span class="material-icons">inventory_2</span>
                    <span>No items in cart</span>
                    <a href="#" class="so-link">Start shopping</a>
                </div>

                <div class="so-empty-state so-empty-state-compact so-mt-3">
                    <span class="material-icons">schedule</span>
                    <span>No recent activity</span>
                </div>
        <?= so_code_block('<div class="so-empty-state so-empty-state-compact">
    <span class="material-icons">inventory_2</span>
    <span>No items in cart</span>
    <a href="#" class="so-link">Start shopping</a>
</div>

<div class="so-empty-state so-empty-state-compact">
    <span class="material-icons">schedule</span>
    <span>No recent activity</span>
</div>', 'html') ?>
    </div>
</div>

<!-- Empty State with Card Styling -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Empty State with Card</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Empty state wrapped in a card for standalone use.</p>

                <div class="so-empty-state so-empty-state-card">
                    <div class="so-empty-state-icon">
                        <span class="material-icons">photo_library</span>
                    </div>
                    <h3 class="so-empty-state-title">No photos uploaded</h3>
                    <p class="so-empty-state-text">Drag and drop photos here or click to browse your files.</p>
                    <div class="so-empty-state-actions">
                        <button class="so-btn so-btn-primary">
                            <span class="material-icons">cloud_upload</span>
                            Upload Photos
                        </button>
                    </div>
                </div>
        <?= so_code_block('<div class="so-empty-state so-empty-state-card">
    <div class="so-empty-state-icon">
        <span class="material-icons">photo_library</span>
    </div>
    <h3 class="so-empty-state-title">No photos uploaded</h3>
    <p class="so-empty-state-text">Drag and drop photos here...</p>
    <div class="so-empty-state-actions">
        <button class="so-btn so-btn-primary">Upload Photos</button>
    </div>
</div>', 'html') ?>
    </div>
</div>

<!-- Different Icon Styles -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Different Icon Styles</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Various icon presentation styles.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-empty-state">
                            <div class="so-empty-state-icon so-empty-state-icon-circle">
                                <span class="material-icons">people</span>
                            </div>
                            <h4 class="so-empty-state-title">No team members</h4>
                            <p class="so-empty-state-text">Invite others to collaborate on this project.</p>
                            <div class="so-empty-state-actions">
                                <button class="so-btn so-btn-outline so-btn-sm">Invite Members</button>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-empty-state">
                            <div class="so-empty-state-icon so-empty-state-icon-gradient">
                                <span class="material-icons">rocket_launch</span>
                            </div>
                            <h4 class="so-empty-state-title">Ready to launch?</h4>
                            <p class="so-empty-state-text">Your project is complete. Take it live with one click.</p>
                            <div class="so-empty-state-actions">
                                <button class="so-btn so-btn-primary so-btn-sm">Launch Project</button>
                            </div>
                        </div>
                    </div>
                </div>
        <?= so_code_block('<!-- Circle icon style -->
<div class="so-empty-state">
    <div class="so-empty-state-icon so-empty-state-icon-circle">
        <span class="material-icons">people</span>
    </div>
    ...
</div>

<!-- Gradient icon style -->
<div class="so-empty-state">
    <div class="so-empty-state-icon so-empty-state-icon-gradient">
        <span class="material-icons">rocket_launch</span>
    </div>
    ...
</div>', 'html') ?>
    </div>
</div>

<!-- Real World Examples -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Real World Examples</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Common empty state scenarios.</p>

                <div class="so-row so-g-4">
                    <!-- No orders -->
                    <div class="so-col-md-6">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-header">
                                <h5 class="so-card-title">Recent Orders</h5>
                            </div>
                            <div class="so-card-body">
                                <div class="so-empty-state so-empty-state-sm">
                                    <div class="so-empty-state-icon">
                                        <span class="material-icons">shopping_bag</span>
                                    </div>
                                    <h4 class="so-empty-state-title">No orders yet</h4>
                                    <p class="so-empty-state-text">Your orders will appear here after your first purchase.</p>
                                    <div class="so-empty-state-actions">
                                        <button class="so-btn so-btn-primary so-btn-sm">Browse Products</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- No favorites -->
                    <div class="so-col-md-6">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-header">
                                <h5 class="so-card-title">Favorites</h5>
                            </div>
                            <div class="so-card-body">
                                <div class="so-empty-state so-empty-state-sm">
                                    <div class="so-empty-state-icon">
                                        <span class="material-icons">favorite_border</span>
                                    </div>
                                    <h4 class="so-empty-state-title">No favorites saved</h4>
                                    <p class="so-empty-state-text">Items you favorite will be saved here for quick access.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- No data available -->
                    <div class="so-col-md-6">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-header">
                                <h5 class="so-card-title">Analytics</h5>
                            </div>
                            <div class="so-card-body">
                                <div class="so-empty-state so-empty-state-sm">
                                    <div class="so-empty-state-icon">
                                        <span class="material-icons">insights</span>
                                    </div>
                                    <h4 class="so-empty-state-title">No data available</h4>
                                    <p class="so-empty-state-text">Analytics will appear once there's enough data to display.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection error -->
                    <div class="so-col-md-6">
                        <div class="so-card so-card-bordered">
                            <div class="so-card-header">
                                <h5 class="so-card-title">Live Feed</h5>
                            </div>
                            <div class="so-card-body">
                                <div class="so-empty-state so-empty-state-sm so-empty-state-warning">
                                    <div class="so-empty-state-icon">
                                        <span class="material-icons">wifi_off</span>
                                    </div>
                                    <h4 class="so-empty-state-title">Connection lost</h4>
                                    <p class="so-empty-state-text">Please check your internet connection and try again.</p>
                                    <div class="so-empty-state-actions">
                                        <button class="so-btn so-btn-warning so-btn-sm">Reconnect</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?= so_code_block('<!-- Warning state for connection errors -->
<div class="so-empty-state so-empty-state-sm so-empty-state-warning">
    <div class="so-empty-state-icon">
        <span class="material-icons">wifi_off</span>
    </div>
    <h4 class="so-empty-state-title">Connection lost</h4>
    <p class="so-empty-state-text">Please check your connection.</p>
    <div class="so-empty-state-actions">
        <button class="so-btn so-btn-warning so-btn-sm">Reconnect</button>
    </div>
</div>', 'html') ?>
    </div>
</div>

<!-- UiEngine Usage -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">UiEngine Usage</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">
            The UiEngine provides a fluent PHP API for server-side rendering and a JavaScript API for client-side rendering of empty states.
            Both APIs produce identical HTML output and share the same configuration structure.
        </p>

        <div class="so-tabs so-mb-3" role="tablist" data-so-tabs>
            <button class="so-tab so-active" data-so-target="#uiengine-php">
                <span class="material-icons">data_object</span> PHP (Server-side)
            </button>
            <button class="so-tab" data-so-target="#uiengine-js">
                <span class="material-icons">javascript</span> JavaScript (Client-side)
            </button>
            <button class="so-tab" data-so-target="#uiengine-html">
                <span class="material-icons">code</span> Rendered HTML
            </button>
        </div>

        <!-- PHP Tab Content -->
        <div class="so-tab-pane so-fade so-show so-active" id="uiengine-php" role="tabpanel">
            <?= so_code_block('// PHP - Server-side rendering
use Core\UiEngine\UiEngine;

// Basic empty state
$emptyState = UiEngine::emptyState()
    ->icon(\'inbox\')
    ->title(\'No messages yet\')
    ->description(\'Your inbox is empty. When you receive new messages, they\'ll appear here.\');

echo $emptyState;

// Empty state with action
$emptyState = UiEngine::emptyState()
    ->icon(\'folder_open\')
    ->title(\'No projects found\')
    ->description(\'Get started by creating your first project.\')
    ->addAction(\'Create Project\', \'/projects/new\', \'primary\');

echo $emptyState;

// Contextual variants
$searchState = UiEngine::emptyState()
    ->search()
    ->icon(\'search_off\')
    ->title(\'No results found\')
    ->description(\'Try different keywords or check for typos.\')
    ->addAction(\'Clear Search\', null, \'outline\');

$errorState = UiEngine::emptyState()
    ->error()
    ->icon(\'error_outline\')
    ->title(\'Something went wrong\')
    ->description(\'Please try again or contact support.\')
    ->addAction(\'Try Again\', null, \'danger\')
    ->addAction(\'Contact Support\', \'/support\', \'outline\');

$successState = UiEngine::emptyState()
    ->success()
    ->icon(\'check_circle\')
    ->title(\'All caught up!\')
    ->description(\'You\'ve completed all your tasks.\')
    ->addAction(\'View Completed\', \'/tasks/completed\', \'success\');

// Size variants
$smallState = UiEngine::emptyState()
    ->small()
    ->icon(\'notifications_none\')
    ->title(\'No notifications\')
    ->description(\'You\'re all caught up.\');

$largeState = UiEngine::emptyState()
    ->large()
    ->icon(\'folder_open\')
    ->title(\'No files uploaded\')
    ->description(\'Drag and drop files here to get started.\');

// Icon styling
$circleIcon = UiEngine::emptyState()
    ->iconCircle()
    ->icon(\'people\')
    ->title(\'No team members\')
    ->description(\'Invite others to collaborate.\');

$gradientIcon = UiEngine::emptyState()
    ->iconGradient()
    ->icon(\'rocket_launch\')
    ->title(\'Ready to launch?\')
    ->description(\'Take your project live with one click.\');

// Layout variants
$compactState = UiEngine::emptyState()
    ->compact()
    ->icon(\'inventory_2\')
    ->description(\'No items in cart\')
    ->addAction(\'Start shopping\', \'/shop\', \'link\');

$cardState = UiEngine::emptyState()
    ->card()
    ->icon(\'photo_library\')
    ->title(\'No photos uploaded\')
    ->description(\'Drag and drop photos here.\')
    ->addAction(\'Upload Photos\', null, \'primary\');

// Method chaining with multiple options
$complexState = UiEngine::emptyState()
    ->small()
    ->warning()
    ->iconCircle()
    ->icon(\'wifi_off\')
    ->title(\'Connection lost\')
    ->description(\'Check your internet connection.\')
    ->addAction(\'Reconnect\', null, \'warning\')
    ->addAction(\'Dismiss\', null, \'outline\')
    ->addClass(\'custom-class\')
    ->id(\'connection-error\');

echo $complexState;', 'php') ?>
        </div>

        <!-- JavaScript Tab Content -->
        <div class="so-tab-pane so-fade" id="uiengine-js" role="tabpanel">
            <?= so_code_block('import { UiEngine } from \'./ui-engine/UiEngine.js\';

// Basic empty state
const emptyState = UiEngine.emptyState()
    .icon(\'inbox\')
    .title(\'No messages yet\')
    .description(\'Your inbox is empty. When you receive new messages, they\'ll appear here.\');

document.getElementById(\'container\').innerHTML = emptyState.render();

// Empty state with action
const emptyState = UiEngine.emptyState()
    .icon(\'folder_open\')
    .title(\'No projects found\')
    .description(\'Get started by creating your first project.\')
    .addAction(\'Create Project\', \'/projects/new\', \'primary\');

document.getElementById(\'container\').innerHTML = emptyState.render();

// Contextual variants
const searchState = UiEngine.emptyState()
    .search()
    .icon(\'search_off\')
    .title(\'No results found\')
    .description(\'Try different keywords or check for typos.\')
    .addAction(\'Clear Search\', null, \'outline\');

const errorState = UiEngine.emptyState()
    .error()
    .icon(\'error_outline\')
    .title(\'Something went wrong\')
    .description(\'Please try again or contact support.\')
    .addAction(\'Try Again\', null, \'danger\')
    .addAction(\'Contact Support\', \'/support\', \'outline\');

const successState = UiEngine.emptyState()
    .success()
    .icon(\'check_circle\')
    .title(\'All caught up!\')
    .description(\'You\'ve completed all your tasks.\')
    .addAction(\'View Completed\', \'/tasks/completed\', \'success\');

// Size variants
const smallState = UiEngine.emptyState()
    .small()
    .icon(\'notifications_none\')
    .title(\'No notifications\')
    .description(\'You\'re all caught up.\');

const largeState = UiEngine.emptyState()
    .large()
    .icon(\'folder_open\')
    .title(\'No files uploaded\')
    .description(\'Drag and drop files here to get started.\');

// Icon styling
const circleIcon = UiEngine.emptyState()
    .iconCircle()
    .icon(\'people\')
    .title(\'No team members\')
    .description(\'Invite others to collaborate.\');

const gradientIcon = UiEngine.emptyState()
    .iconGradient()
    .icon(\'rocket_launch\')
    .title(\'Ready to launch?\')
    .description(\'Take your project live with one click.\');

// Layout variants
const compactState = UiEngine.emptyState()
    .compact()
    .icon(\'inventory_2\')
    .description(\'No items in cart\')
    .addAction(\'Start shopping\', \'/shop\', \'link\');

const cardState = UiEngine.emptyState()
    .card()
    .icon(\'photo_library\')
    .title(\'No photos uploaded\')
    .description(\'Drag and drop photos here.\')
    .addAction(\'Upload Photos\', null, \'primary\');

// Method chaining with multiple options
const complexState = UiEngine.emptyState()
    .small()
    .warning()
    .iconCircle()
    .icon(\'wifi_off\')
    .title(\'Connection lost\')
    .description(\'Check your internet connection.\')
    .addAction(\'Reconnect\', null, \'warning\')
    .addAction(\'Dismiss\', null, \'outline\')
    .addClass(\'custom-class\')
    .id(\'connection-error\');

document.getElementById(\'container\').innerHTML = complexState.render();

// From JSON configuration
const config = {
    type: \'empty-state\',
    variant: \'error\',
    size: \'sm\',
    icon: \'error\',
    title: \'Upload failed\',
    description: \'Please try again.\',
    actions: [
        { text: \'Retry\', url: null, variant: \'danger\' },
        { text: \'Cancel\', url: null, variant: \'outline\' }
    ]
};

const fromConfig = UiEngine.fromConfig(config);
document.getElementById(\'container\').innerHTML = fromConfig.render();', 'javascript') ?>
        </div>

        <!-- HTML Tab Content -->
        <div class="so-tab-pane so-fade" id="uiengine-html" role="tabpanel">
            <?= so_code_block('<!-- Basic empty state -->
<div class="so-empty-state">
    <div class="so-empty-state-icon">
        <span class="material-icons">inbox</span>
    </div>
    <h3 class="so-empty-state-title">No messages yet</h3>
    <p class="so-empty-state-text">Your inbox is empty. When you receive new messages, they\'ll appear here.</p>
</div>

<!-- Empty state with multiple actions -->
<div class="so-empty-state so-empty-state-error">
    <div class="so-empty-state-icon">
        <span class="material-icons">error_outline</span>
    </div>
    <h3 class="so-empty-state-title">Something went wrong</h3>
    <p class="so-empty-state-text">Please try again or contact support.</p>
    <div class="so-empty-state-actions">
        <button type="button" class="so-btn so-btn-danger">Try Again</button>
        <a href="/support" class="so-btn so-btn-outline">Contact Support</a>
    </div>
</div>

<!-- Small size with success variant and circle icon -->
<div class="so-empty-state so-empty-state-sm so-empty-state-success">
    <div class="so-empty-state-icon so-empty-state-icon-circle">
        <span class="material-icons">check_circle</span>
    </div>
    <h3 class="so-empty-state-title">All caught up!</h3>
    <p class="so-empty-state-text">You\'ve completed all your tasks.</p>
</div>

<!-- Compact layout -->
<div class="so-empty-state so-empty-state-compact">
    <span class="material-icons">inventory_2</span>
    <span>No items in cart</span>
    <a href="/shop" class="so-link">Start shopping</a>
</div>

<!-- Card styling -->
<div class="so-empty-state so-empty-state-card">
    <div class="so-empty-state-icon">
        <span class="material-icons">photo_library</span>
    </div>
    <h3 class="so-empty-state-title">No photos uploaded</h3>
    <p class="so-empty-state-text">Drag and drop photos here.</p>
    <div class="so-empty-state-actions">
        <button type="button" class="so-btn so-btn-primary">Upload Photos</button>
    </div>
</div>', 'html') ?>
        </div>
    </div>
</div>

<!-- API Reference -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">API Reference</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Complete API reference for the EmptyState element. All methods support chaining and are available in both PHP and JavaScript.</p>

        <div class="so-tabs so-mb-3" role="tablist" data-so-tabs>
            <button class="so-tab so-active" data-so-target="#api-content">Content Methods</button>
            <button class="so-tab" data-so-target="#api-variants">Contextual Variants</button>
            <button class="so-tab" data-so-target="#api-styling">Size & Icon Styling</button>
            <button class="so-tab" data-so-target="#api-layout">Layout Variants</button>
            <button class="so-tab" data-so-target="#api-actions">Action Methods</button>
            <button class="so-tab" data-so-target="#api-inherited">Inherited Methods</button>
        </div>

        <!-- Content Methods -->
        <div class="so-tab-pane so-fade so-show so-active" id="api-content" role="tabpanel">
            <div class="so-table-responsive">
                <table class="so-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Method</th>
                            <th style="width: 70%;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title(string $title)</code></td>
                            <td>Set the title text. Uses <code>&lt;h3&gt;</code> by default.</td>
                        </tr>
                        <tr>
                            <td><code>description(string $description)</code></td>
                            <td>Set the description text. Rendered as a paragraph.</td>
                        </tr>
                        <tr>
                            <td><code>icon(string $icon)</code></td>
                            <td>Set Material Icons name for the icon. Example: <code>'inbox'</code>, <code>'search_off'</code>.</td>
                        </tr>
                        <tr>
                            <td><code>image(string $url)</code></td>
                            <td>Use an image instead of an icon. Provide full image URL.</td>
                        </tr>
                        <tr>
                            <td><code>headingLevel(string $level)</code></td>
                            <td>Set heading level for title. Options: <code>'h3'</code>, <code>'h4'</code>, <code>'h5'</code>. Default: <code>'h3'</code>.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?= so_code_block('// PHP
$state = UiEngine::emptyState()
    ->icon(\'folder_open\')
    ->title(\'No files found\')
    ->description(\'Upload files to get started.\')
    ->headingLevel(\'h4\');

// JavaScript
const state = UiEngine.emptyState()
    .icon(\'folder_open\')
    .title(\'No files found\')
    .description(\'Upload files to get started.\')
    .headingLevel(\'h4\');', 'php') ?>
        </div>

        <!-- Contextual Variants -->
        <div class="so-tab-pane so-fade" id="api-variants" role="tabpanel">
            <div class="so-table-responsive">
                <table class="so-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Method</th>
                            <th style="width: 70%;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>variant(string $variant)</code></td>
                            <td>Set contextual variant. Options: <code>'search'</code>, <code>'error'</code>, <code>'success'</code>, <code>'warning'</code>, <code>'info'</code>, <code>'no-permission'</code>, <code>'danger'</code>, <code>'forbidden'</code>.</td>
                        </tr>
                        <tr>
                            <td><code>search()</code></td>
                            <td>Apply search results variant. Adds <code>.so-empty-state-search</code> class.</td>
                        </tr>
                        <tr>
                            <td><code>error()</code></td>
                            <td>Apply error variant. Adds <code>.so-empty-state-error</code> class.</td>
                        </tr>
                        <tr>
                            <td><code>danger()</code></td>
                            <td>Alias for <code>error()</code>. Adds <code>.so-empty-state-danger</code> class.</td>
                        </tr>
                        <tr>
                            <td><code>success()</code></td>
                            <td>Apply success variant. Adds <code>.so-empty-state-success</code> class.</td>
                        </tr>
                        <tr>
                            <td><code>warning()</code></td>
                            <td>Apply warning variant. Adds <code>.so-empty-state-warning</code> class.</td>
                        </tr>
                        <tr>
                            <td><code>info()</code></td>
                            <td>Apply info variant. Adds <code>.so-empty-state-info</code> class.</td>
                        </tr>
                        <tr>
                            <td><code>noPermission()</code></td>
                            <td>Apply no-permission variant. Adds <code>.so-empty-state-no-permission</code> class.</td>
                        </tr>
                        <tr>
                            <td><code>forbidden()</code></td>
                            <td>Alias for <code>noPermission()</code>. Adds <code>.so-empty-state-forbidden</code> class.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?= so_code_block('// PHP - Contextual variants
$searchState = UiEngine::emptyState()
    ->search()
    ->icon(\'search_off\')
    ->title(\'No results\');

$errorState = UiEngine::emptyState()
    ->error()
    ->icon(\'error_outline\')
    ->title(\'Failed to load\');

$successState = UiEngine::emptyState()
    ->success()
    ->icon(\'check_circle\')
    ->title(\'All done!\');

$warningState = UiEngine::emptyState()
    ->warning()
    ->icon(\'warning\')
    ->title(\'Connection lost\');

$infoState = UiEngine::emptyState()
    ->info()
    ->icon(\'info\')
    ->title(\'Getting started\');

$noPermState = UiEngine::emptyState()
    ->noPermission()
    ->icon(\'lock\')
    ->title(\'Access denied\');

// JavaScript - Same methods
const searchState = UiEngine.emptyState()
    .search()
    .icon(\'search_off\')
    .title(\'No results\');', 'php') ?>
        </div>

        <!-- Size & Icon Styling -->
        <div class="so-tab-pane so-fade" id="api-styling" role="tabpanel">
            <div class="so-table-responsive">
                <table class="so-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Method</th>
                            <th style="width: 70%;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"><strong>Size Variants</strong></td>
                        </tr>
                        <tr>
                            <td><code>size(string $size)</code></td>
                            <td>Set size variant. Options: <code>'sm'</code>, <code>'lg'</code>.</td>
                        </tr>
                        <tr>
                            <td><code>small()</code></td>
                            <td>Apply small size. Adds <code>.so-empty-state-sm</code> class. Good for sidebars and compact areas.</td>
                        </tr>
                        <tr>
                            <td><code>large()</code></td>
                            <td>Apply large size. Adds <code>.so-empty-state-lg</code> class. Good for hero sections and full-page empties.</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Icon Styling</strong></td>
                        </tr>
                        <tr>
                            <td><code>iconStyle(string $style)</code></td>
                            <td>Set icon style. Options: <code>'circle'</code>, <code>'gradient'</code>.</td>
                        </tr>
                        <tr>
                            <td><code>iconCircle()</code></td>
                            <td>Add circular background to icon. Adds <code>.so-empty-state-icon-circle</code> class.</td>
                        </tr>
                        <tr>
                            <td><code>iconGradient()</code></td>
                            <td>Add gradient background to icon. Adds <code>.so-empty-state-icon-gradient</code> class.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?= so_code_block('// PHP - Size variants
$smallState = UiEngine::emptyState()
    ->small()
    ->icon(\'notifications_none\')
    ->title(\'No notifications\');

$largeState = UiEngine::emptyState()
    ->large()
    ->icon(\'folder_open\')
    ->title(\'No files\');

// Icon styling
$circleIcon = UiEngine::emptyState()
    ->iconCircle()
    ->icon(\'people\')
    ->title(\'No members\');

$gradientIcon = UiEngine::emptyState()
    ->iconGradient()
    ->icon(\'rocket_launch\')
    ->title(\'Ready to launch?\');

// Combine size and icon styling
$combined = UiEngine::emptyState()
    ->small()
    ->success()
    ->iconCircle()
    ->icon(\'check_circle\')
    ->title(\'All set!\');

// JavaScript - Same methods
const smallState = UiEngine.emptyState()
    .small()
    .iconCircle()
    .icon(\'notifications_none\')
    .title(\'No notifications\');', 'php') ?>
        </div>

        <!-- Layout Variants -->
        <div class="so-tab-pane so-fade" id="api-layout" role="tabpanel">
            <div class="so-table-responsive">
                <table class="so-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Method</th>
                            <th style="width: 70%;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>compact(bool $compact = true)</code></td>
                            <td>Enable compact/inline layout. Changes from vertical stack to horizontal inline. Adds <code>.so-empty-state-compact</code> class. Good for table empty rows, inline messages.</td>
                        </tr>
                        <tr>
                            <td><code>card(bool $card = true)</code></td>
                            <td>Add card styling wrapper. Includes border, padding, background. Adds <code>.so-empty-state-card</code> class. Good for standalone empty states on pages.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?= so_code_block('// PHP - Compact layout
$compactState = UiEngine::emptyState()
    ->compact()
    ->icon(\'inventory_2\')
    ->description(\'No items in cart\')
    ->addAction(\'Start shopping\', \'/shop\', \'link\');

// Card styling
$cardState = UiEngine::emptyState()
    ->card()
    ->icon(\'photo_library\')
    ->title(\'No photos uploaded\')
    ->description(\'Drag and drop photos here.\')
    ->addAction(\'Upload Photos\', null, \'primary\');

// Combine layouts with other options
$combined = UiEngine::emptyState()
    ->compact()
    ->warning()
    ->icon(\'wifi_off\')
    ->description(\'Connection lost\');

// JavaScript - Same methods
const compactState = UiEngine.emptyState()
    .compact()
    .icon(\'inventory_2\')
    .description(\'No items in cart\');', 'php') ?>
        </div>

        <!-- Action Methods -->
        <div class="so-tab-pane so-fade" id="api-actions" role="tabpanel">
            <div class="so-table-responsive">
                <table class="so-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Method</th>
                            <th style="width: 70%;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>addAction(string $text, ?string $url, string $variant)</code></td>
                            <td>Add an action button. If URL is provided, renders as <code>&lt;a&gt;</code>, otherwise as <code>&lt;button&gt;</code>. Variant options: <code>'primary'</code>, <code>'secondary'</code>, <code>'success'</code>, <code>'danger'</code>, <code>'warning'</code>, <code>'info'</code>, <code>'outline'</code>, <code>'link'</code>.</td>
                        </tr>
                        <tr>
                            <td><code>action(string $text, ?string $url, string $variant)</code></td>
                            <td>Set a single action button (replaces all existing actions). Same parameters as <code>addAction()</code>.</td>
                        </tr>
                        <tr>
                            <td><code>actions(array $actions)</code></td>
                            <td>Set multiple actions at once. Each action should be an array with keys: <code>text</code>, <code>url</code> (optional), <code>variant</code> (optional).</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?= so_code_block('// PHP - Single action
$state = UiEngine::emptyState()
    ->icon(\'folder_open\')
    ->title(\'No files\')
    ->addAction(\'Upload Files\', \'/upload\', \'primary\');

// Multiple actions
$state = UiEngine::emptyState()
    ->icon(\'error_outline\')
    ->title(\'Upload failed\')
    ->addAction(\'Try Again\', null, \'danger\')
    ->addAction(\'Cancel\', null, \'outline\')
    ->addAction(\'Help\', \'/help\', \'link\');

// Set all actions at once
$state = UiEngine::emptyState()
    ->icon(\'search_off\')
    ->title(\'No results\')
    ->actions([
        [\'text\' => \'Clear Search\', \'url\' => null, \'variant\' => \'outline\'],
        [\'text\' => \'Browse All\', \'url\' => \'/browse\', \'variant\' => \'primary\']
    ]);

// JavaScript - Same methods
const state = UiEngine.emptyState()
    .icon(\'error_outline\')
    .title(\'Upload failed\')
    .addAction(\'Try Again\', null, \'danger\')
    .addAction(\'Cancel\', null, \'outline\');

// Actions without URLs render as buttons
// Actions with URLs render as links
const withButton = UiEngine.emptyState()
    .addAction(\'Click Me\', null, \'primary\'); // <button>

const withLink = UiEngine.emptyState()
    .addAction(\'Go Here\', \'/page\', \'primary\'); // <a href="/page">', 'php') ?>
        </div>

        <!-- Inherited Methods -->
        <div class="so-tab-pane so-fade" id="api-inherited" role="tabpanel">
            <p class="so-text-muted so-mb-3">EmptyState inherits these methods from the base Element class:</p>
            <div class="so-table-responsive">
                <table class="so-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Method</th>
                            <th style="width: 70%;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>id(string $id)</code></td>
                            <td>Set element ID attribute</td>
                        </tr>
                        <tr>
                            <td><code>addClass(string $class)</code></td>
                            <td>Add CSS class(es). Space-separated for multiple classes</td>
                        </tr>
                        <tr>
                            <td><code>attr(string $name, mixed $value)</code></td>
                            <td>Set HTML attribute</td>
                        </tr>
                        <tr>
                            <td><code>data(string $key, mixed $value)</code></td>
                            <td>Set data attribute (auto-prefixes with <code>data-so-</code>)</td>
                        </tr>
                        <tr>
                            <td><code>style(string $property, string $value)</code></td>
                            <td>Set inline CSS style property</td>
                        </tr>
                        <tr>
                            <td><code>render()</code> (JS only)</td>
                            <td>JavaScript: Return rendered HTML string</td>
                        </tr>
                        <tr>
                            <td><code>__toString()</code> (PHP only)</td>
                            <td>PHP: Automatically called when echoing the element</td>
                        </tr>
                        <tr>
                            <td><code>toArray()</code> / <code>toConfig()</code></td>
                            <td>Export element configuration as array/object</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?= so_code_block('// PHP - Using inherited methods
$state = UiEngine::emptyState()
    ->icon(\'inbox\')
    ->title(\'No messages\')
    ->id(\'messages-empty\')
    ->addClass(\'custom-empty-state highlight\')
    ->attr(\'role\', \'status\')
    ->attr(\'aria-live\', \'polite\')
    ->data(\'section\', \'messages\')
    ->style(\'margin-top\', \'2rem\');

echo $state; // Calls __toString()

// Export configuration
$config = $state->toArray();
// [
//     \'type\' => \'empty-state\',
//     \'icon\' => \'inbox\',
//     \'title\' => \'No messages\',
//     \'id\' => \'messages-empty\',
//     \'class\' => \'custom-empty-state highlight\',
//     ...
// ]

// JavaScript - Using inherited methods
const state = UiEngine.emptyState()
    .icon(\'inbox\')
    .title(\'No messages\')
    .id(\'messages-empty\')
    .addClass(\'custom-empty-state highlight\')
    .attr(\'role\', \'status\')
    .attr(\'aria-live\', \'polite\')
    .data(\'section\', \'messages\')
    .style(\'margin-top\', \'2rem\');

const html = state.render();
document.getElementById(\'container\').innerHTML = html;

// Export configuration
const config = state.toConfig();', 'php') ?>
        </div>
    </div>
</div>

<!-- Validation -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Validation</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">
            Empty states are display-only components that don't require validation. They present static content
            and don't collect or process user input. However, action buttons within empty states may trigger
            forms or operations that require validation.
        </p>

        <div class="so-alert so-alert-info">
            <div class="so-alert-icon">
                <span class="material-icons">info</span>
            </div>
            <div class="so-alert-content">
                <strong>Note:</strong> If your empty state includes action buttons that open forms or trigger
                data operations, implement validation on those target forms/operations separately.
            </div>
        </div>

        <?= so_code_block('// PHP - Empty state with action that leads to a validated form
$emptyState = UiEngine::emptyState()
    ->icon(\'folder_open\')
    ->title(\'No projects found\')
    ->description(\'Create your first project to get started.\')
    ->addAction(\'Create Project\', \'/projects/create\', \'primary\');
    // The /projects/create page will have its own form with validation

// JavaScript - Empty state with button that opens a validated modal
const emptyState = UiEngine.emptyState()
    .icon(\'person_add\')
    .title(\'No team members\')
    .description(\'Invite people to join your team.\')
    .addAction(\'Invite Member\', null, \'primary\')
    .id(\'invite-empty-state\');

// Add click handler for validation
document.getElementById(\'invite-empty-state\')
    .querySelector(\'.so-btn-primary\')
    .addEventListener(\'click\', () => {
        // Open modal with form that has validation
        openInviteMemberModal();
    });', 'php') ?>
    </div>
</div>

<!-- Error Handling -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Error Handling</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">
            Empty states are often used to handle and display error scenarios. Use contextual variants to
            communicate different error types and provide actionable next steps.
        </p>

        <div class="so-table-responsive so-mb-4">
            <table class="so-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Scenario</th>
                        <th style="width: 25%;">Variant</th>
                        <th style="width: 50%;">Recommended Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Search returns no results</td>
                        <td><code>.search()</code></td>
                        <td>Clear search, adjust filters, browse all items</td>
                    </tr>
                    <tr>
                        <td>Data load failure</td>
                        <td><code>.error()</code></td>
                        <td>Try again, refresh page, contact support</td>
                    </tr>
                    <tr>
                        <td>Connection lost</td>
                        <td><code>.warning()</code></td>
                        <td>Reconnect, check connection, reload page</td>
                    </tr>
                    <tr>
                        <td>Permission denied</td>
                        <td><code>.noPermission()</code></td>
                        <td>Request access, go back, contact admin</td>
                    </tr>
                    <tr>
                        <td>Operation completed</td>
                        <td><code>.success()</code></td>
                        <td>View results, continue, start new task</td>
                    </tr>
                    <tr>
                        <td>First-time use</td>
                        <td><code>.info()</code></td>
                        <td>Get started, view tutorial, create first item</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <?= so_code_block('// PHP - Error handling patterns

// 1. Search with no results
function handleSearchResults($results, $query) {
    if (empty($results)) {
        return UiEngine::emptyState()
            ->search()
            ->icon(\'search_off\')
            ->title(\'No results found\')
            ->description("We couldn\'t find anything matching \\"$query\\". Try different keywords.")
            ->addAction(\'Clear Search\', \'?clear=1\', \'outline\')
            ->addAction(\'Browse All\', \'/browse\', \'link\');
    }
    return renderResults($results);
}

// 2. Data load error with retry
function handleDataLoad($data, $error) {
    if ($error) {
        return UiEngine::emptyState()
            ->error()
            ->icon(\'error_outline\')
            ->title(\'Failed to load data\')
            ->description(\'We\'re having trouble loading your data. Please try again.\')
            ->addAction(\'Try Again\', null, \'danger\')
            ->addAction(\'Contact Support\', \'/support\', \'outline\')
            ->id(\'load-error\')
            ->data(\'retry-endpoint\', \'/api/reload\');
    }
    return renderData($data);
}

// 3. Connection error with auto-retry
function handleConnectionError($retryCount = 0) {
    return UiEngine::emptyState()
        ->warning()
        ->small()
        ->iconCircle()
        ->icon(\'wifi_off\')
        ->title(\'Connection lost\')
        ->description(\'Attempting to reconnect...\')
        ->compact()
        ->id(\'connection-error\')
        ->data(\'retry-count\', $retryCount);
}

// 4. Permission denied
function handlePermissionDenied($resource) {
    return UiEngine::emptyState()
        ->noPermission()
        ->icon(\'lock\')
        ->title(\'Access Denied\')
        ->description("You don\'t have permission to view $resource. Contact your administrator.")
        ->addAction(\'Request Access\', \'/request-access\', \'secondary\')
        ->addAction(\'Go Back\', \'javascript:history.back()\', \'outline\');
}

// 5. Successful completion
function handleTaskCompletion() {
    return UiEngine::emptyState()
        ->success()
        ->iconGradient()
        ->icon(\'check_circle\')
        ->title(\'All tasks completed!\')
        ->description(\'Great work! You\'ve finished everything on your list.\')
        ->addAction(\'View Completed\', \'/tasks/completed\', \'success\')
        ->addAction(\'Create New Task\', \'/tasks/new\', \'outline\');
}

// JavaScript - Error handling with dynamic updates
class DataLoadHandler {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.retryCount = 0;
        this.maxRetries = 3;
    }

    async loadData(endpoint) {
        try {
            const response = await fetch(endpoint);
            if (!response.ok) throw new Error(\'Load failed\');
            const data = await response.json();
            this.renderData(data);
        } catch (error) {
            this.handleError(error, endpoint);
        }
    }

    handleError(error, endpoint) {
        const emptyState = UiEngine.emptyState()
            .error()
            .icon(\'error_outline\')
            .title(\'Failed to load data\')
            .description(\'We\\\'re having trouble loading your data.\')
            .id(\'error-state\');

        if (this.retryCount < this.maxRetries) {
            emptyState
                .addAction(\'Try Again\', null, \'danger\')
                .addAction(\'Cancel\', null, \'outline\');

            this.container.innerHTML = emptyState.render();

            // Add retry handler
            document.getElementById(\'error-state\')
                .querySelector(\'.so-btn-danger\')
                .addEventListener(\'click\', () => {
                    this.retryCount++;
                    this.loadData(endpoint);
                });
        } else {
            emptyState
                .description(\'Multiple attempts failed. Please contact support.\')
                .addAction(\'Contact Support\', \'/support\', \'danger\')
                .addAction(\'Go Back\', \'javascript:history.back()\', \'outline\');

            this.container.innerHTML = emptyState.render();
        }
    }

    renderData(data) {
        this.retryCount = 0; // Reset on success
        // Render actual data...
    }
}

// Usage
const handler = new DataLoadHandler(\'data-container\');
handler.loadData(\'/api/data\');', 'php') ?>
    </div>
</div>

    </div>
</main>

<script>
function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const code = codeBlock.querySelector('.so-code-content code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        button.innerHTML = '<span class="material-icons">check</span>';
        setTimeout(() => {
            button.innerHTML = '<span class="material-icons">content_copy</span>';
        }, 2000);
    });
}
</script>

<?php require_once '../includes/footer.php'; ?>
