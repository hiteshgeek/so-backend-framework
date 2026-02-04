<?php
/**
 * SixOrbit UI Demo - Tags & Avatars
 */
$pageTitle = 'Tags & Avatars';
$pageDescription = 'Tag and avatar components';

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
            <h1 class="so-page-title">Tags &amp; Avatars</h1>
            <p class="so-page-subtitle">Tag and avatar components</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- ============================================ -->
                <!-- SECTION 1: BADGES -->
                <!-- ============================================ -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Badges</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Small count and labeling components for notifications and status indicators.</p>

                        <h5 class="so-mb-3">Solid Badges</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-badge so-badge-primary">Primary</span>
                            <span class="so-badge so-badge-secondary">Secondary</span>
                            <span class="so-badge so-badge-success">Success</span>
                            <span class="so-badge so-badge-danger">Danger</span>
                            <span class="so-badge so-badge-warning">Warning</span>
                            <span class="so-badge so-badge-info">Info</span>
                            <span class="so-badge so-badge-light">Light</span>
                            <span class="so-badge so-badge-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Soft Badges</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-badge so-badge-soft-primary">Primary</span>
                            <span class="so-badge so-badge-soft-secondary">Secondary</span>
                            <span class="so-badge so-badge-soft-success">Success</span>
                            <span class="so-badge so-badge-soft-danger">Danger</span>
                            <span class="so-badge so-badge-soft-warning">Warning</span>
                            <span class="so-badge so-badge-soft-info">Info</span>
                            <span class="so-badge so-badge-soft-light">Light</span>
                            <span class="so-badge so-badge-soft-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Outline Badges</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-badge so-badge-outline-primary">Primary</span>
                            <span class="so-badge so-badge-outline-secondary">Secondary</span>
                            <span class="so-badge so-badge-outline-success">Success</span>
                            <span class="so-badge so-badge-outline-danger">Danger</span>
                            <span class="so-badge so-badge-outline-warning">Warning</span>
                            <span class="so-badge so-badge-outline-info">Info</span>
                            <span class="so-badge so-badge-outline-light">Light</span>
                            <span class="so-badge so-badge-outline-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Badge Sizes</h5>
                        <div class="so-flex so-gap-2 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-badge so-badge-primary so-badge-sm">Small</span>
                            <span class="so-badge so-badge-primary">Default</span>
                            <span class="so-badge so-badge-primary so-badge-lg">Large</span>
                        </div>

                        <h5 class="so-mb-3">Badges with Icons</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-badge so-badge-primary">
                                <span class="material-icons">check</span>
                                Approved
                            </span>
                            <span class="so-badge so-badge-danger">
                                <span class="material-icons">error</span>
                                Error
                            </span>
                            <span class="so-badge so-badge-soft-success">
                                <span class="material-icons">done_all</span>
                                Complete
                            </span>
                            <span class="so-badge so-badge-outline-info">
                                <span class="material-icons">info</span>
                                Info
                            </span>
                        </div>

                        <h5 class="so-mb-3">Dot Badges</h5>
                        <div class="so-flex so-gap-3 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-badge-dot so-badge-primary"></span>
                            <span class="so-badge-dot so-badge-secondary"></span>
                            <span class="so-badge-dot so-badge-success"></span>
                            <span class="so-badge-dot so-badge-danger"></span>
                            <span class="so-badge-dot so-badge-warning"></span>
                            <span class="so-badge-dot so-badge-info"></span>
                            <span class="so-badge-dot so-badge-light"></span>
                            <span class="so-badge-dot so-badge-dark"></span>
                        </div>

                        <h5 class="so-mb-3">Pulse Animation</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-badge-dot so-badge-danger so-badge-pulse"></span>
                            <span class="so-badge-dot so-badge-success so-badge-pulse"></span>
                            <span class="so-badge so-badge-danger so-badge-pulse">Live</span>
                        </div>

                        <h5 class="so-mb-3">Count Badge Colors</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-light so-btn-icon">
                                    <span class="material-icons">notifications</span>
                                </button>
                                <span class="so-badge-count so-badge-primary">3</span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-light so-btn-icon">
                                    <span class="material-icons">mail</span>
                                </button>
                                <span class="so-badge-count so-badge-success">5</span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-light so-btn-icon">
                                    <span class="material-icons">shopping_cart</span>
                                </button>
                                <span class="so-badge-count so-badge-warning">2</span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-light so-btn-icon">
                                    <span class="material-icons">favorite</span>
                                </button>
                                <span class="so-badge-count so-badge-info">7</span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-light so-btn-icon">
                                    <span class="material-icons">chat</span>
                                </button>
                                <span class="so-badge-count so-badge-secondary">4</span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-light so-btn-icon">
                                    <span class="material-icons">folder</span>
                                </button>
                                <span class="so-badge-count so-badge-dark">9</span>
                            </span>
                        </div>

                        <h5 class="so-mb-3">Hint Badges (Dot on Buttons)</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-primary">Profile</button>
                                <span class="so-badge-dot so-badge-danger"></span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-outline-primary">
                                    <span class="material-icons">settings</span>
                                    Settings
                                </button>
                                <span class="so-badge-dot so-badge-success"></span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-light so-btn-icon">
                                    <span class="material-icons">notifications</span>
                                </button>
                                <span class="so-badge-dot so-badge-danger so-badge-pulse"></span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-ghost so-btn-icon">
                                    <span class="material-icons">mail</span>
                                </button>
                                <span class="so-badge-dot so-badge-primary"></span>
                            </span>
                        </div>

                        <h5 class="so-mb-3">Hint Badge Positions</h5>
                        <div class="so-flex so-gap-6 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-text-center">
                                <span class="so-badge-wrapper so-badge-top-left">
                                    <button class="so-btn so-btn-primary so-btn-icon">
                                        <span class="material-icons">person</span>
                                    </button>
                                    <span class="so-badge-dot so-badge-success"></span>
                                </span>
                                <p class="so-text-muted so-text-xs so-mt-2">Top Left</p>
                            </div>
                            <div class="so-text-center">
                                <span class="so-badge-wrapper so-badge-top-right">
                                    <button class="so-btn so-btn-success so-btn-icon">
                                        <span class="material-icons">person</span>
                                    </button>
                                    <span class="so-badge-dot so-badge-danger"></span>
                                </span>
                                <p class="so-text-muted so-text-xs so-mt-2">Top Right</p>
                            </div>
                            <div class="so-text-center">
                                <span class="so-badge-wrapper so-badge-bottom-left">
                                    <button class="so-btn so-btn-warning so-btn-icon">
                                        <span class="material-icons">person</span>
                                    </button>
                                    <span class="so-badge-dot so-badge-info"></span>
                                </span>
                                <p class="so-text-muted so-text-xs so-mt-2">Bottom Left</p>
                            </div>
                            <div class="so-text-center">
                                <span class="so-badge-wrapper so-badge-bottom-right">
                                    <button class="so-btn so-btn-danger so-btn-icon">
                                        <span class="material-icons">person</span>
                                    </button>
                                    <span class="so-badge-dot so-badge-warning"></span>
                                </span>
                                <p class="so-text-muted so-text-xs so-mt-2">Bottom Right</p>
                            </div>
                        </div>

                        <h5 class="so-mb-3">Positioned Count Badges</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-primary">
                                    <span class="material-icons">notifications</span>
                                </button>
                                <span class="so-badge-count">5</span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-outline-primary">
                                    <span class="material-icons">mail</span>
                                </button>
                                <span class="so-badge-count so-badge-success">12</span>
                            </span>
                            <span class="so-badge-wrapper">
                                <button class="so-btn so-btn-light">
                                    <span class="material-icons">shopping_cart</span>
                                </button>
                                <span class="so-badge-count so-badge-sm">99+</span>
                            </span>
                        </div>

                        <h5 class="so-mb-3">Badge Position Variants</h5>
                        <div class="so-flex so-gap-6 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-text-center">
                                <span class="so-badge-wrapper so-badge-top-left">
                                    <button class="so-btn so-btn-primary so-btn-icon">
                                        <span class="material-icons">notifications</span>
                                    </button>
                                    <span class="so-badge-count">3</span>
                                </span>
                                <p class="so-text-muted so-text-xs so-mt-2">Top Left</p>
                            </div>
                            <div class="so-text-center">
                                <span class="so-badge-wrapper so-badge-top-right">
                                    <button class="so-btn so-btn-success so-btn-icon">
                                        <span class="material-icons">mail</span>
                                    </button>
                                    <span class="so-badge-count">7</span>
                                </span>
                                <p class="so-text-muted so-text-xs so-mt-2">Top Right</p>
                            </div>
                            <div class="so-text-center">
                                <span class="so-badge-wrapper so-badge-bottom-left">
                                    <button class="so-btn so-btn-warning so-btn-icon">
                                        <span class="material-icons">shopping_cart</span>
                                    </button>
                                    <span class="so-badge-count">2</span>
                                </span>
                                <p class="so-text-muted so-text-xs so-mt-2">Bottom Left</p>
                            </div>
                            <div class="so-text-center">
                                <span class="so-badge-wrapper so-badge-bottom-right">
                                    <button class="so-btn so-btn-danger so-btn-icon">
                                        <span class="material-icons">favorite</span>
                                    </button>
                                    <span class="so-badge-count">9</span>
                                </span>
                                <p class="so-text-muted so-text-xs so-mt-2">Bottom Right</p>
                            </div>
                        </div>

<?= so_code_block('<!-- Solid badges (8 colors) -->
<span class="so-badge so-badge-primary">Primary</span>
<span class="so-badge so-badge-secondary">Secondary</span>

<!-- Soft badges -->
<span class="so-badge so-badge-soft-primary">Primary</span>

<!-- Outline badges -->
<span class="so-badge so-badge-outline-primary">Primary</span>

<!-- Sizes -->
<span class="so-badge so-badge-primary so-badge-sm">Small</span>
<span class="so-badge so-badge-primary so-badge-lg">Large</span>

<!-- With icon -->
<span class="so-badge so-badge-success">
    <span class="material-icons">check</span>
    Approved
</span>

<!-- Dot badges -->
<span class="so-badge-dot so-badge-success"></span>

<!-- Pulse animation -->
<span class="so-badge-dot so-badge-danger so-badge-pulse"></span>

<!-- Positioned badge (notification) -->
<span class="so-badge-wrapper">
    <button class="so-btn so-btn-primary">
        <span class="material-icons">notifications</span>
    </button>
    <span class="so-badge-count">5</span>
</span>

<!-- Count badge with contextual colors -->
<span class="so-badge-wrapper">
    <button class="so-btn so-btn-light so-btn-icon">
        <span class="material-icons">mail</span>
    </button>
    <span class="so-badge-count so-badge-success">5</span>
</span>

<!-- Hint badge (dot on button) -->
<span class="so-badge-wrapper">
    <button class="so-btn so-btn-primary">Profile</button>
    <span class="so-badge-dot so-badge-danger"></span>
</span>

<!-- Hint badge with position -->
<span class="so-badge-wrapper so-badge-top-left">
    <button class="so-btn so-btn-primary so-btn-icon">
        <span class="material-icons">person</span>
    </button>
    <span class="so-badge-dot so-badge-success"></span>
</span>

<!-- Position variants: so-badge-top-left, so-badge-top-right, so-badge-bottom-left, so-badge-bottom-right -->', 'html') ?>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECTION 2: PILLS -->
                <!-- ============================================ -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Pills</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Fully rounded tag variants for categories, tags, and filters.</p>

                        <h5 class="so-mb-3">Solid Pills</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-pill so-pill-primary">Primary</span>
                            <span class="so-pill so-pill-secondary">Secondary</span>
                            <span class="so-pill so-pill-success">Success</span>
                            <span class="so-pill so-pill-danger">Danger</span>
                            <span class="so-pill so-pill-warning">Warning</span>
                            <span class="so-pill so-pill-info">Info</span>
                            <span class="so-pill so-pill-light">Light</span>
                            <span class="so-pill so-pill-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Soft Pills</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-pill so-pill-soft-primary">Primary</span>
                            <span class="so-pill so-pill-soft-secondary">Secondary</span>
                            <span class="so-pill so-pill-soft-success">Success</span>
                            <span class="so-pill so-pill-soft-danger">Danger</span>
                            <span class="so-pill so-pill-soft-warning">Warning</span>
                            <span class="so-pill so-pill-soft-info">Info</span>
                            <span class="so-pill so-pill-soft-light">Light</span>
                            <span class="so-pill so-pill-soft-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Outline Pills</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-pill so-pill-outline-primary">Primary</span>
                            <span class="so-pill so-pill-outline-secondary">Secondary</span>
                            <span class="so-pill so-pill-outline-success">Success</span>
                            <span class="so-pill so-pill-outline-danger">Danger</span>
                            <span class="so-pill so-pill-outline-warning">Warning</span>
                            <span class="so-pill so-pill-outline-info">Info</span>
                            <span class="so-pill so-pill-outline-light">Light</span>
                            <span class="so-pill so-pill-outline-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Pill Sizes</h5>
                        <div class="so-flex so-gap-2 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-pill so-pill-primary so-pill-sm">Small</span>
                            <span class="so-pill so-pill-primary">Default</span>
                            <span class="so-pill so-pill-primary so-pill-lg">Large</span>
                        </div>

                        <h5 class="so-mb-3">Pills with Icons</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-pill so-pill-primary">
                                <span class="material-icons">star</span>
                                Featured
                            </span>
                            <span class="so-pill so-pill-soft-success">
                                <span class="material-icons">check_circle</span>
                                Verified
                            </span>
                            <span class="so-pill so-pill-outline-danger">
                                <span class="material-icons">priority_high</span>
                                Urgent
                            </span>
                        </div>

                        <h5 class="so-mb-3">Closable Pills</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-pill so-pill-primary" data-so-chip data-so-chip-closable>
                                JavaScript
                                <button class="so-pill-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-pill so-pill-soft-success" data-so-chip data-so-chip-closable>
                                React
                                <button class="so-pill-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-pill so-pill-outline-info" data-so-chip data-so-chip-closable>
                                Vue.js
                                <button class="so-pill-close"><span class="material-icons">close</span></button>
                            </span>
                        </div>

<?= so_code_block('<!-- Solid pills (8 colors) -->
<span class="so-pill so-pill-primary">Primary</span>

<!-- Soft pills -->
<span class="so-pill so-pill-soft-primary">Primary</span>

<!-- Outline pills -->
<span class="so-pill so-pill-outline-primary">Primary</span>

<!-- Sizes -->
<span class="so-pill so-pill-primary so-pill-sm">Small</span>
<span class="so-pill so-pill-primary so-pill-lg">Large</span>

<!-- With icon -->
<span class="so-pill so-pill-primary">
    <span class="material-icons">star</span>
    Featured
</span>

<!-- Closable pill -->
<span class="so-pill so-pill-primary" data-so-chip data-so-chip-closable>
    Tag Name
    <button class="so-pill-close"><span class="material-icons">close</span></button>
</span>', 'html') ?>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECTION 3: LABELS -->
                <!-- ============================================ -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Labels</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Square-cornered text labels with uppercase styling for categorization.</p>

                        <h5 class="so-mb-3">Solid Labels</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-label so-label-primary">Primary</span>
                            <span class="so-label so-label-secondary">Secondary</span>
                            <span class="so-label so-label-success">Success</span>
                            <span class="so-label so-label-danger">Danger</span>
                            <span class="so-label so-label-warning">Warning</span>
                            <span class="so-label so-label-info">Info</span>
                            <span class="so-label so-label-light">Light</span>
                            <span class="so-label so-label-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Soft Labels</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-label so-label-soft-primary">Primary</span>
                            <span class="so-label so-label-soft-secondary">Secondary</span>
                            <span class="so-label so-label-soft-success">Success</span>
                            <span class="so-label so-label-soft-danger">Danger</span>
                            <span class="so-label so-label-soft-warning">Warning</span>
                            <span class="so-label so-label-soft-info">Info</span>
                            <span class="so-label so-label-soft-light">Light</span>
                            <span class="so-label so-label-soft-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Label Sizes</h5>
                        <div class="so-flex so-gap-2 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-label so-label-primary so-label-sm">Small</span>
                            <span class="so-label so-label-primary">Default</span>
                            <span class="so-label so-label-primary so-label-lg">Large</span>
                        </div>

                        <h5 class="so-mb-3">Labels with Icons</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-label so-label-success">
                                <span class="material-icons">new_releases</span>
                                New
                            </span>
                            <span class="so-label so-label-soft-warning">
                                <span class="material-icons">science</span>
                                Beta
                            </span>
                            <span class="so-label so-label-danger">
                                <span class="material-icons">priority_high</span>
                                Urgent
                            </span>
                            <span class="so-label so-label-soft-info">
                                <span class="material-icons">update</span>
                                Updated
                            </span>
                        </div>

<?= so_code_block('<!-- Solid labels (8 colors) -->
<span class="so-label so-label-primary">Primary</span>

<!-- Soft labels -->
<span class="so-label so-label-soft-primary">Primary</span>

<!-- Sizes -->
<span class="so-label so-label-primary so-label-sm">Small</span>
<span class="so-label so-label-primary so-label-lg">Large</span>

<!-- With icon -->
<span class="so-label so-label-success">
    <span class="material-icons">new_releases</span>
    New
</span>', 'html') ?>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECTION 4: CHIPS -->
                <!-- ============================================ -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Chips</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Interactive tag elements with close and select functionality.</p>

                        <h5 class="so-mb-3">Basic Chips</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-chip">Default</span>
                            <span class="so-chip so-chip-primary">Primary</span>
                            <span class="so-chip so-chip-secondary">Secondary</span>
                            <span class="so-chip so-chip-success">Success</span>
                            <span class="so-chip so-chip-danger">Danger</span>
                            <span class="so-chip so-chip-warning">Warning</span>
                            <span class="so-chip so-chip-info">Info</span>
                            <span class="so-chip so-chip-light">Light</span>
                            <span class="so-chip so-chip-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Soft Chips</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-chip so-chip-soft-primary">Primary</span>
                            <span class="so-chip so-chip-soft-secondary">Secondary</span>
                            <span class="so-chip so-chip-soft-success">Success</span>
                            <span class="so-chip so-chip-soft-danger">Danger</span>
                            <span class="so-chip so-chip-soft-warning">Warning</span>
                            <span class="so-chip so-chip-soft-info">Info</span>
                            <span class="so-chip so-chip-soft-light">Light</span>
                            <span class="so-chip so-chip-soft-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Outline Chips</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-chip so-chip-outline-primary">Primary</span>
                            <span class="so-chip so-chip-outline-secondary">Secondary</span>
                            <span class="so-chip so-chip-outline-success">Success</span>
                            <span class="so-chip so-chip-outline-danger">Danger</span>
                            <span class="so-chip so-chip-outline-warning">Warning</span>
                            <span class="so-chip so-chip-outline-info">Info</span>
                            <span class="so-chip so-chip-outline-light">Light</span>
                            <span class="so-chip so-chip-outline-dark">Dark</span>
                        </div>

                        <h5 class="so-mb-3">Chip Sizes</h5>
                        <div class="so-flex so-gap-2 so-items-center so-flex-wrap so-mb-4">
                            <span class="so-chip so-chip-primary so-chip-sm">Small</span>
                            <span class="so-chip so-chip-primary">Default</span>
                            <span class="so-chip so-chip-primary so-chip-lg">Large</span>
                        </div>

                        <h5 class="so-mb-3">Chips with Icons</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-chip so-chip-soft-primary">
                                <span class="material-icons">code</span>
                                JavaScript
                            </span>
                            <span class="so-chip so-chip-soft-success">
                                <span class="material-icons">check_circle</span>
                                Verified
                            </span>
                            <span class="so-chip so-chip-soft-danger">
                                <span class="material-icons">error</span>
                                Error
                            </span>
                        </div>

                        <h5 class="so-mb-3">Chips with Avatars</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-chip so-chip-soft-primary">
                                <img src="https://i.pravatar.cc/100?img=1" class="so-chip-avatar" alt="">
                                John Doe
                            </span>
                            <span class="so-chip so-chip-soft-success">
                                <img src="https://i.pravatar.cc/100?img=2" class="so-chip-avatar" alt="">
                                Jane Smith
                            </span>
                            <span class="so-chip so-chip-soft-info">
                                <img src="https://i.pravatar.cc/100?img=3" class="so-chip-avatar" alt="">
                                Bob Wilson
                            </span>
                        </div>

                        <h5 class="so-mb-3">Closable Chips (Click X to remove)</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4" id="closable-chips-demo">
                            <span class="so-chip so-chip-primary" data-so-chip data-so-chip-closable data-value="react">
                                React
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-chip so-chip-soft-success" data-so-chip data-so-chip-closable data-value="vue">
                                Vue.js
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-chip so-chip-outline-info" data-so-chip data-so-chip-closable data-value="angular">
                                Angular
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-chip so-chip-soft-warning" data-so-chip data-so-chip-closable data-value="svelte">
                                <img src="https://i.pravatar.cc/100?img=4" class="so-chip-avatar" alt="">
                                Svelte Dev
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                        </div>

                        <h5 class="so-mb-3">Selectable/Filter Chips (Click to toggle)</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4" id="filter-chips-demo">
                            <span class="so-chip so-chip-outline-primary so-chip-selectable" data-so-chip data-so-chip-selectable data-value="all">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                All
                            </span>
                            <span class="so-chip so-chip-outline-primary so-chip-selectable so-chip-selected" data-so-chip data-so-chip-selectable data-value="active">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                Active
                            </span>
                            <span class="so-chip so-chip-outline-primary so-chip-selectable" data-so-chip data-so-chip-selectable data-value="pending">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                Pending
                            </span>
                            <span class="so-chip so-chip-outline-primary so-chip-selectable" data-so-chip data-so-chip-selectable data-value="completed">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                Completed
                            </span>
                        </div>

                        <h5 class="so-mb-3">Disabled Chips</h5>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-chip so-chip-primary so-chip-disabled">Disabled</span>
                            <span class="so-chip so-chip-soft-success so-chip-disabled">Disabled Soft</span>
                            <span class="so-chip so-chip-outline-danger so-chip-disabled">Disabled Outline</span>
                        </div>

                        <h5 class="so-mb-3">Interactive Demo</h5>
                        <p class="so-text-muted so-mb-3">Try adding, removing, and selecting chips. Choose style and size options below.</p>

                        <!-- Add Chip Input with Style Options -->
                        <div class="so-row so-mb-3">
                            <div class="so-col-12 so-col-md-4 so-mb-2 so-mb-md-0">
                                <label class="so-form-label so-text-xs so-mb-1">Tag Name</label>
                                <input type="text" class="so-form-control" id="chip-input" placeholder="Type a tag name...">
                            </div>
                            <div class="so-col-6 so-col-md-3 so-mb-2 so-mb-md-0">
                                <label class="so-form-label so-text-xs so-mb-1">Style</label>
                                <select class="so-form-select" id="chip-style-select">
                                    <optgroup label="Solid">
                                        <option value="so-chip-primary">Primary</option>
                                        <option value="so-chip-secondary">Secondary</option>
                                        <option value="so-chip-success">Success</option>
                                        <option value="so-chip-danger">Danger</option>
                                        <option value="so-chip-warning">Warning</option>
                                        <option value="so-chip-info">Info</option>
                                        <option value="so-chip-light">Light</option>
                                        <option value="so-chip-dark">Dark</option>
                                    </optgroup>
                                    <optgroup label="Soft">
                                        <option value="so-chip-soft-primary" selected>Soft Primary</option>
                                        <option value="so-chip-soft-secondary">Soft Secondary</option>
                                        <option value="so-chip-soft-success">Soft Success</option>
                                        <option value="so-chip-soft-danger">Soft Danger</option>
                                        <option value="so-chip-soft-warning">Soft Warning</option>
                                        <option value="so-chip-soft-info">Soft Info</option>
                                        <option value="so-chip-soft-light">Soft Light</option>
                                        <option value="so-chip-soft-dark">Soft Dark</option>
                                    </optgroup>
                                    <optgroup label="Outline">
                                        <option value="so-chip-outline-primary">Outline Primary</option>
                                        <option value="so-chip-outline-secondary">Outline Secondary</option>
                                        <option value="so-chip-outline-success">Outline Success</option>
                                        <option value="so-chip-outline-danger">Outline Danger</option>
                                        <option value="so-chip-outline-warning">Outline Warning</option>
                                        <option value="so-chip-outline-info">Outline Info</option>
                                        <option value="so-chip-outline-light">Outline Light</option>
                                        <option value="so-chip-outline-dark">Outline Dark</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="so-col-6 so-col-md-2 so-mb-2 so-mb-md-0">
                                <label class="so-form-label so-text-xs so-mb-1">Size</label>
                                <select class="so-form-select" id="chip-size-select">
                                    <option value="so-chip-sm">Small</option>
                                    <option value="" selected>Default</option>
                                    <option value="so-chip-lg">Large</option>
                                </select>
                            </div>
                            <div class="so-col-12 so-col-md-3 so-d-flex so-items-end">
                                <button class="so-btn so-btn-primary so-w-100" id="add-chip-btn">
                                    <span class="material-icons">add</span>
                                    Add Chip
                                </button>
                            </div>
                        </div>

                        <!-- Style Preview -->
                        <div class="so-mb-3">
                            <label class="so-form-label so-text-xs so-mb-1">Preview</label>
                            <div class="so-p-3 so-rounded" style="background: var(--so-grey-100);">
                                <span class="so-chip so-chip-soft-primary" id="chip-preview">
                                    Sample Chip
                                    <button class="so-chip-close"><span class="material-icons">close</span></button>
                                </span>
                            </div>
                        </div>

                        <!-- Dynamic Chips Container -->
                        <label class="so-form-label so-text-xs so-mb-1">Added Chips</label>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4 so-p-3 so-rounded" id="interactive-chips-container" style="background: var(--so-grey-100); min-height: 50px;">
                            <span class="so-chip so-chip-primary" data-so-chip data-so-chip-closable data-value="HTML">
                                HTML
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-chip so-chip-soft-success" data-so-chip data-so-chip-closable data-value="CSS">
                                CSS
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-chip so-chip-outline-warning" data-so-chip data-so-chip-closable data-value="JavaScript">
                                JavaScript
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-chip so-chip-soft-info so-chip-sm" data-so-chip data-so-chip-closable data-value="React">
                                React
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                            <span class="so-chip so-chip-danger so-chip-lg" data-so-chip data-so-chip-closable data-value="Vue">
                                Vue
                                <button class="so-chip-close"><span class="material-icons">close</span></button>
                            </span>
                        </div>

                        <!-- Event Log -->
                        <div class="so-card so-card-secondary so-mb-4">
                            <div class="so-card-header so-py-2">
                                <h6 class="so-card-title so-mb-0">Event Log</h6>
                                <button class="so-btn so-btn-xs so-btn-ghost" id="clear-log-btn">Clear</button>
                            </div>
                            <div class="so-card-body so-py-2" style="max-height: 120px; overflow-y: auto;">
                                <div id="chip-event-log" class="so-text-sm so-font-mono">
                                    <div class="so-text-muted">Events will appear here...</div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Chips Demo -->
                        <h6 class="so-mb-2">Filter by Category</h6>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-3" id="category-filter-chips">
                            <span class="so-chip so-chip-outline-primary so-chip-selectable so-chip-selected" data-so-chip data-so-chip-selectable data-value="all">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                All
                            </span>
                            <span class="so-chip so-chip-outline-success so-chip-selectable" data-so-chip data-so-chip-selectable data-value="frontend">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                Frontend
                            </span>
                            <span class="so-chip so-chip-outline-info so-chip-selectable" data-so-chip data-so-chip-selectable data-value="backend">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                Backend
                            </span>
                            <span class="so-chip so-chip-outline-warning so-chip-selectable" data-so-chip data-so-chip-selectable data-value="database">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                Database
                            </span>
                            <span class="so-chip so-chip-outline-danger so-chip-selectable" data-so-chip data-so-chip-selectable data-value="devops">
                                <span class="so-chip-check"><span class="material-icons">check</span></span>
                                DevOps
                            </span>
                        </div>
                        <div class="so-mb-4">
                            <span class="so-text-muted so-text-sm">Selected filters: </span>
                            <span id="selected-filters" class="so-text-sm so-font-semibold">All</span>
                        </div>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const container = document.getElementById('interactive-chips-container');
                            const input = document.getElementById('chip-input');
                            const addBtn = document.getElementById('add-chip-btn');
                            const styleSelect = document.getElementById('chip-style-select');
                            const sizeSelect = document.getElementById('chip-size-select');
                            const preview = document.getElementById('chip-preview');
                            const eventLog = document.getElementById('chip-event-log');
                            const clearLogBtn = document.getElementById('clear-log-btn');
                            const filterContainer = document.getElementById('category-filter-chips');
                            const selectedFiltersEl = document.getElementById('selected-filters');

                            // Update preview chip when options change
                            function updatePreview() {
                                const style = styleSelect.value;
                                const size = sizeSelect.value;
                                const text = input.value.trim() || 'Sample Chip';

                                // Remove all chip style/size classes
                                preview.className = 'so-chip';

                                // Add selected style
                                if (style) {
                                    preview.classList.add(style);
                                }

                                // Add selected size
                                if (size) {
                                    preview.classList.add(size);
                                }

                                // Update text (keep close button)
                                preview.innerHTML = text + '<button class="so-chip-close"><span class="material-icons">close</span></button>';
                            }

                            // Listen for changes
                            styleSelect.addEventListener('change', updatePreview);
                            sizeSelect.addEventListener('change', updatePreview);
                            input.addEventListener('input', updatePreview);

                            // Log events
                            function logEvent(type, value, details) {
                                const time = new Date().toLocaleTimeString();
                                const entry = document.createElement('div');
                                entry.className = type.includes('close') ? 'so-text-danger' :
                                                  type.includes('select') ? 'so-text-success' :
                                                  type.includes('deselect') ? 'so-text-warning' : 'so-text-info';
                                let text = '[' + time + '] ' + type + ': "' + value + '"';
                                if (details) {
                                    text += ' <span class="so-text-muted">(' + details + ')</span>';
                                }
                                entry.innerHTML = text;

                                // Remove placeholder if exists
                                const placeholder = eventLog.querySelector('.so-text-muted:not(span)');
                                if (placeholder && placeholder.parentNode === eventLog) placeholder.remove();

                                eventLog.insertBefore(entry, eventLog.firstChild);
                            }

                            // Add chip with selected style and size
                            function addChip() {
                                const value = input.value.trim();
                                if (!value) return;

                                const style = styleSelect.value;
                                const size = sizeSelect.value;

                                const chip = document.createElement('span');
                                chip.className = 'so-chip';
                                if (style) chip.classList.add(style);
                                if (size) chip.classList.add(size);
                                chip.setAttribute('data-so-chip', '');
                                chip.setAttribute('data-so-chip-closable', '');
                                chip.setAttribute('data-value', value);
                                chip.innerHTML = value + '<button class="so-chip-close"><span class="material-icons">close</span></button>';

                                container.appendChild(chip);
                                input.value = '';

                                // Get human-readable style/size info
                                const styleText = styleSelect.options[styleSelect.selectedIndex].text;
                                const sizeText = sizeSelect.options[sizeSelect.selectedIndex].text;
                                logEvent('chip:added', value, styleText + ', ' + sizeText);

                                // Reset preview
                                updatePreview();

                                // Bind close event
                                chip.querySelector('.so-chip-close').addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    const chipValue = chip.getAttribute('data-value');
                                    chip.style.opacity = '0';
                                    chip.style.transform = 'scale(0.8)';
                                    chip.style.transition = 'all 0.15s ease';
                                    setTimeout(function() {
                                        chip.remove();
                                    }, 150);
                                    logEvent('chip:close', chipValue);
                                });
                            }

                            // Add chip on button click
                            addBtn.addEventListener('click', addChip);

                            // Add chip on Enter key
                            input.addEventListener('keypress', function(e) {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    addChip();
                                }
                            });

                            // Clear log
                            clearLogBtn.addEventListener('click', function() {
                                eventLog.innerHTML = '<div class="so-text-muted">Events will appear here...</div>';
                            });

                            // Listen for chip close events from existing chips
                            container.addEventListener('click', function(e) {
                                if (e.target.closest('.so-chip-close')) {
                                    const chip = e.target.closest('[data-so-chip]');
                                    if (chip) {
                                        const value = chip.getAttribute('data-value');
                                        chip.style.transition = 'all 0.15s ease';
                                        chip.style.opacity = '0';
                                        chip.style.transform = 'scale(0.8)';
                                        setTimeout(function() {
                                            chip.remove();
                                        }, 150);
                                        logEvent('chip:close', value);
                                    }
                                }
                            });

                            // Filter chips - track selection
                            function updateSelectedFilters() {
                                const selected = filterContainer.querySelectorAll('.so-chip-selected');
                                const values = Array.from(selected).map(function(chip) {
                                    return chip.getAttribute('data-value');
                                });
                                selectedFiltersEl.textContent = values.length > 0 ? values.join(', ') : 'None';
                            }

                            // Filter chip click handling
                            filterContainer.addEventListener('click', function(e) {
                                const chip = e.target.closest('[data-so-chip-selectable]');
                                if (chip) {
                                    const isSelected = chip.classList.toggle('so-chip-selected');
                                    const value = chip.getAttribute('data-value');
                                    logEvent(isSelected ? 'chip:select' : 'chip:deselect', value);
                                    updateSelectedFilters();
                                }
                            });
                        });
                        </script>

<?= so_code_block('<!-- Basic chip -->
<span class="so-chip so-chip-primary">Primary</span>

<!-- Soft chip -->
<span class="so-chip so-chip-soft-primary">Primary</span>

<!-- Outline chip -->
<span class="so-chip so-chip-outline-primary">Primary</span>

<!-- Chip with icon -->
<span class="so-chip so-chip-soft-primary">
    <span class="material-icons">code</span>
    JavaScript
</span>

<!-- Chip with avatar -->
<span class="so-chip so-chip-soft-primary">
    <img src="user.jpg" class="so-chip-avatar" alt="">
    John Doe
</span>

<!-- Closable chip -->
<span class="so-chip so-chip-primary" data-so-chip data-so-chip-closable data-value="tag1">
    Tag Name
    <button class="so-chip-close"><span class="material-icons">close</span></button>
</span>

<!-- Selectable/filter chip -->
<span class="so-chip so-chip-outline-primary so-chip-selectable" data-so-chip data-so-chip-selectable data-value="filter1">
    <span class="so-chip-check"><span class="material-icons">check</span></span>
    Filter Option
</span>

<!-- Disabled chip -->
<span class="so-chip so-chip-primary so-chip-disabled">Disabled</span>

<!-- JavaScript events -->
<script>
// Listen for chip close
document.addEventListener(\'so-chip:close\', (e) => {
    console.log(\'Chip closed:\', e.detail.value);
});

// Listen for chip selection
document.addEventListener(\'so-chip:select\', (e) => {
    console.log(\'Chip selected:\', e.detail.value);
});

document.addEventListener(\'so-chip:deselect\', (e) => {
    console.log(\'Chip deselected:\', e.detail.value);
});

// Get selected chips
const selected = SOChips.getSelectedValues(container);
</script>', 'html') ?>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECTION 5: AVATARS -->
                <!-- ============================================ -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Avatars</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">User representation with images, initials, or icons.</p>

                        <h5 class="so-mb-3">Image Avatars</h5>
                        <div class="so-flex so-gap-3 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar so-avatar-xs"><img src="https://i.pravatar.cc/100?img=1" alt=""></div>
                            <div class="so-avatar so-avatar-sm"><img src="https://i.pravatar.cc/100?img=2" alt=""></div>
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=3" alt=""></div>
                            <div class="so-avatar so-avatar-lg"><img src="https://i.pravatar.cc/100?img=4" alt=""></div>
                            <div class="so-avatar so-avatar-xl"><img src="https://i.pravatar.cc/100?img=5" alt=""></div>
                            <div class="so-avatar so-avatar-2xl"><img src="https://i.pravatar.cc/100?img=6" alt=""></div>
                        </div>

                        <h5 class="so-mb-3">Initial Avatars (8 Colors)</h5>
                        <div class="so-flex so-gap-3 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar so-avatar-primary"><span>JD</span></div>
                            <div class="so-avatar so-avatar-secondary"><span>AB</span></div>
                            <div class="so-avatar so-avatar-success"><span>CD</span></div>
                            <div class="so-avatar so-avatar-danger"><span>EF</span></div>
                            <div class="so-avatar so-avatar-warning"><span>GH</span></div>
                            <div class="so-avatar so-avatar-info"><span>IJ</span></div>
                            <div class="so-avatar so-avatar-light"><span>KL</span></div>
                            <div class="so-avatar so-avatar-dark"><span>MN</span></div>
                        </div>

                        <h5 class="so-mb-3">Icon Avatars</h5>
                        <div class="so-flex so-gap-3 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar"><span class="material-icons">person</span></div>
                            <div class="so-avatar so-avatar-primary"><span class="material-icons">person</span></div>
                            <div class="so-avatar so-avatar-success"><span class="material-icons">check</span></div>
                            <div class="so-avatar so-avatar-danger"><span class="material-icons">close</span></div>
                            <div class="so-avatar so-avatar-info"><span class="material-icons">info</span></div>
                        </div>

                        <h5 class="so-mb-3">Avatar Sizes</h5>
                        <div class="so-flex so-gap-3 so-items-end so-flex-wrap so-mb-4">
                            <div>
                                <div class="so-avatar so-avatar-xs so-avatar-primary"><span>XS</span></div>
                                <p class="so-text-muted so-text-xs so-text-center so-mt-1">24px</p>
                            </div>
                            <div>
                                <div class="so-avatar so-avatar-sm so-avatar-primary"><span>SM</span></div>
                                <p class="so-text-muted so-text-xs so-text-center so-mt-1">32px</p>
                            </div>
                            <div>
                                <div class="so-avatar so-avatar-primary"><span>MD</span></div>
                                <p class="so-text-muted so-text-xs so-text-center so-mt-1">40px</p>
                            </div>
                            <div>
                                <div class="so-avatar so-avatar-lg so-avatar-primary"><span>LG</span></div>
                                <p class="so-text-muted so-text-xs so-text-center so-mt-1">48px</p>
                            </div>
                            <div>
                                <div class="so-avatar so-avatar-xl so-avatar-primary"><span>XL</span></div>
                                <p class="so-text-muted so-text-xs so-text-center so-mt-1">64px</p>
                            </div>
                            <div>
                                <div class="so-avatar so-avatar-2xl so-avatar-primary"><span>2XL</span></div>
                                <p class="so-text-muted so-text-xs so-text-center so-mt-1">80px</p>
                            </div>
                        </div>

                        <h5 class="so-mb-3">Square Avatars</h5>
                        <div class="so-flex so-gap-3 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar so-avatar-square"><img src="https://i.pravatar.cc/100?img=10" alt=""></div>
                            <div class="so-avatar so-avatar-square so-avatar-primary"><span>JD</span></div>
                            <div class="so-avatar so-avatar-square so-avatar-lg so-avatar-success"><span class="material-icons">business</span></div>
                        </div>

                        <h5 class="so-mb-3">Avatars with Ring/Border</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar so-avatar-ring"><img src="https://i.pravatar.cc/100?img=11" alt=""></div>
                            <div class="so-avatar so-avatar-ring-primary"><img src="https://i.pravatar.cc/100?img=12" alt=""></div>
                            <div class="so-avatar so-avatar-ring-secondary"><img src="https://i.pravatar.cc/100?img=13" alt=""></div>
                            <div class="so-avatar so-avatar-ring-success"><img src="https://i.pravatar.cc/100?img=14" alt=""></div>
                            <div class="so-avatar so-avatar-ring-danger"><img src="https://i.pravatar.cc/100?img=15" alt=""></div>
                            <div class="so-avatar so-avatar-ring-warning"><img src="https://i.pravatar.cc/100?img=16" alt=""></div>
                            <div class="so-avatar so-avatar-ring-info"><img src="https://i.pravatar.cc/100?img=17" alt=""></div>
                            <div class="so-avatar so-avatar-ring-light so-avatar-dark"><span>LT</span></div>
                            <div class="so-avatar so-avatar-ring-dark so-avatar-light"><span>DK</span></div>
                        </div>

                        <h5 class="so-mb-3">Avatars with Status (Semantic)</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=20" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-away"><img src="https://i.pravatar.cc/100?img=21" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-busy"><img src="https://i.pravatar.cc/100?img=22" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-offline"><img src="https://i.pravatar.cc/100?img=23" alt=""></div>
                        </div>

                        <h5 class="so-mb-3">Avatars with Status (All Contextual Colors)</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar so-avatar-status so-avatar-status-primary"><img src="https://i.pravatar.cc/100?img=30" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-secondary"><img src="https://i.pravatar.cc/100?img=31" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-success"><img src="https://i.pravatar.cc/100?img=32" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-danger"><img src="https://i.pravatar.cc/100?img=33" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-warning"><img src="https://i.pravatar.cc/100?img=34" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-info"><img src="https://i.pravatar.cc/100?img=35" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-light so-avatar-dark"><span>LT</span></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-dark so-avatar-light"><span>DK</span></div>
                        </div>

                        <h5 class="so-mb-3">Square Avatars with Status</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar so-avatar-square so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=40" alt=""></div>
                            <div class="so-avatar so-avatar-square so-avatar-status so-avatar-status-away"><img src="https://i.pravatar.cc/100?img=41" alt=""></div>
                            <div class="so-avatar so-avatar-square so-avatar-status so-avatar-status-busy"><img src="https://i.pravatar.cc/100?img=42" alt=""></div>
                            <div class="so-avatar so-avatar-square so-avatar-status so-avatar-status-offline"><img src="https://i.pravatar.cc/100?img=43" alt=""></div>
                            <div class="so-avatar so-avatar-square so-avatar-status so-avatar-status-primary so-avatar-primary"><span>AB</span></div>
                            <div class="so-avatar so-avatar-square so-avatar-status so-avatar-status-success so-avatar-success"><span>CD</span></div>
                        </div>

                        <h5 class="so-mb-3">Status with Different Sizes</h5>
                        <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar so-avatar-xs so-avatar-status so-avatar-status-online so-avatar-primary"><span>XS</span></div>
                            <div class="so-avatar so-avatar-sm so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=24" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=25" alt=""></div>
                            <div class="so-avatar so-avatar-lg so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=26" alt=""></div>
                            <div class="so-avatar so-avatar-xl so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=27" alt=""></div>
                        </div>

                        <h5 class="so-mb-3">Status Position Variants</h5>
                        <div class="so-flex so-gap-6 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-text-center">
                                <div class="so-avatar so-avatar-lg so-avatar-status so-avatar-status-online so-avatar-status-top-left"><img src="https://i.pravatar.cc/100?img=50" alt=""></div>
                                <p class="so-text-muted so-text-xs so-mt-2">Top Left</p>
                            </div>
                            <div class="so-text-center">
                                <div class="so-avatar so-avatar-lg so-avatar-status so-avatar-status-success so-avatar-status-top-right"><img src="https://i.pravatar.cc/100?img=51" alt=""></div>
                                <p class="so-text-muted so-text-xs so-mt-2">Top Right</p>
                            </div>
                            <div class="so-text-center">
                                <div class="so-avatar so-avatar-lg so-avatar-status so-avatar-status-warning so-avatar-status-bottom-left"><img src="https://i.pravatar.cc/100?img=52" alt=""></div>
                                <p class="so-text-muted so-text-xs so-mt-2">Bottom Left</p>
                            </div>
                            <div class="so-text-center">
                                <div class="so-avatar so-avatar-lg so-avatar-status so-avatar-status-danger so-avatar-status-bottom-right"><img src="https://i.pravatar.cc/100?img=53" alt=""></div>
                                <p class="so-text-muted so-text-xs so-mt-2">Bottom Right</p>
                            </div>
                        </div>

                        <h5 class="so-mb-3">Square Avatars with Status Positions</h5>
                        <div class="so-flex so-gap-6 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-text-center">
                                <div class="so-avatar so-avatar-lg so-avatar-square so-avatar-status so-avatar-status-primary so-avatar-status-top-left so-avatar-primary"><span>TL</span></div>
                                <p class="so-text-muted so-text-xs so-mt-2">Top Left</p>
                            </div>
                            <div class="so-text-center">
                                <div class="so-avatar so-avatar-lg so-avatar-square so-avatar-status so-avatar-status-success so-avatar-status-top-right"><img src="https://i.pravatar.cc/100?img=54" alt=""></div>
                                <p class="so-text-muted so-text-xs so-mt-2">Top Right</p>
                            </div>
                            <div class="so-text-center">
                                <div class="so-avatar so-avatar-lg so-avatar-square so-avatar-status so-avatar-status-info so-avatar-status-bottom-left"><img src="https://i.pravatar.cc/100?img=55" alt=""></div>
                                <p class="so-text-muted so-text-xs so-mt-2">Bottom Left</p>
                            </div>
                            <div class="so-text-center">
                                <div class="so-avatar so-avatar-lg so-avatar-square so-avatar-status so-avatar-status-danger so-avatar-status-bottom-right so-avatar-danger"><span>BR</span></div>
                                <p class="so-text-muted so-text-xs so-mt-2">Bottom Right</p>
                            </div>
                        </div>

<?= so_code_block('<!-- Image avatar -->
<div class="so-avatar">
    <img src="user.jpg" alt="">
</div>

<!-- Initial avatar with color -->
<div class="so-avatar so-avatar-primary">
    <span>JD</span>
</div>

<!-- Icon avatar -->
<div class="so-avatar so-avatar-secondary">
    <span class="material-icons">person</span>
</div>

<!-- Sizes: xs, sm, (default), lg, xl, 2xl -->
<div class="so-avatar so-avatar-xs">...</div>
<div class="so-avatar so-avatar-sm">...</div>
<div class="so-avatar">...</div>
<div class="so-avatar so-avatar-lg">...</div>
<div class="so-avatar so-avatar-xl">...</div>
<div class="so-avatar so-avatar-2xl">...</div>

<!-- Square avatar -->
<div class="so-avatar so-avatar-square">...</div>

<!-- Avatar with ring -->
<div class="so-avatar so-avatar-ring">...</div>
<div class="so-avatar so-avatar-ring-primary">...</div>

<!-- Avatar with status -->
<div class="so-avatar so-avatar-status so-avatar-status-online">...</div>
<div class="so-avatar so-avatar-status so-avatar-status-away">...</div>
<div class="so-avatar so-avatar-status so-avatar-status-busy">...</div>
<div class="so-avatar so-avatar-status so-avatar-status-offline">...</div>', 'html') ?>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECTION 6: AVATAR GROUPS -->
                <!-- ============================================ -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Avatar Groups</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Multiple avatar layouts: stacked, vertical, and grid.</p>

                        <h5 class="so-mb-3">Stacked (Horizontal Overlapping)</h5>
                        <div class="so-flex so-gap-6 so-items-center so-flex-wrap so-mb-4">
                            <div class="so-avatar-group so-avatar-group-stacked">
                                <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=30" alt=""></div>
                                <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=31" alt=""></div>
                                <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=32" alt=""></div>
                                <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=33" alt=""></div>
                                <div class="so-avatar so-avatar-more so-avatar-secondary"><span>+5</span></div>
                            </div>

                            <div class="so-avatar-group so-avatar-group-stacked so-avatar-group-sm">
                                <div class="so-avatar so-avatar-sm"><img src="https://i.pravatar.cc/100?img=34" alt=""></div>
                                <div class="so-avatar so-avatar-sm"><img src="https://i.pravatar.cc/100?img=35" alt=""></div>
                                <div class="so-avatar so-avatar-sm"><img src="https://i.pravatar.cc/100?img=36" alt=""></div>
                                <div class="so-avatar so-avatar-sm so-avatar-more so-avatar-primary"><span>+3</span></div>
                            </div>

                            <div class="so-avatar-group so-avatar-group-stacked so-avatar-group-lg">
                                <div class="so-avatar so-avatar-lg"><img src="https://i.pravatar.cc/100?img=37" alt=""></div>
                                <div class="so-avatar so-avatar-lg"><img src="https://i.pravatar.cc/100?img=38" alt=""></div>
                                <div class="so-avatar so-avatar-lg so-avatar-primary"><span>AB</span></div>
                            </div>
                        </div>

                        <h5 class="so-mb-3">Stacked with Status</h5>
                        <div class="so-avatar-group so-avatar-group-stacked so-mb-4">
                            <div class="so-avatar so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=40" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=41" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-away"><img src="https://i.pravatar.cc/100?img=42" alt=""></div>
                            <div class="so-avatar so-avatar-status so-avatar-status-offline"><img src="https://i.pravatar.cc/100?img=43" alt=""></div>
                        </div>

                        <h5 class="so-mb-3">Vertical List</h5>
                        <div class="so-flex so-gap-6 so-mb-4">
                            <div class="so-avatar-group so-avatar-group-vertical">
                                <div class="so-avatar so-avatar-status so-avatar-status-online"><img src="https://i.pravatar.cc/100?img=50" alt=""></div>
                                <div class="so-avatar so-avatar-status so-avatar-status-away"><img src="https://i.pravatar.cc/100?img=51" alt=""></div>
                                <div class="so-avatar so-avatar-status so-avatar-status-busy"><img src="https://i.pravatar.cc/100?img=52" alt=""></div>
                                <div class="so-avatar so-avatar-status so-avatar-status-offline"><img src="https://i.pravatar.cc/100?img=53" alt=""></div>
                            </div>

                            <div class="so-avatar-group so-avatar-group-vertical">
                                <div class="so-avatar so-avatar-primary"><span>JD</span></div>
                                <div class="so-avatar so-avatar-success"><span>AB</span></div>
                                <div class="so-avatar so-avatar-info"><span>CD</span></div>
                            </div>
                        </div>

                        <h5 class="so-mb-3">Grid Layout</h5>
                        <div class="so-avatar-group so-avatar-group-grid so-mb-4" style="max-width: 200px;">
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=60" alt=""></div>
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=61" alt=""></div>
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=62" alt=""></div>
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=63" alt=""></div>
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=64" alt=""></div>
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=65" alt=""></div>
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=66" alt=""></div>
                            <div class="so-avatar"><img src="https://i.pravatar.cc/100?img=67" alt=""></div>
                            <div class="so-avatar so-avatar-more so-avatar-secondary"><span>+12</span></div>
                        </div>

<?= so_code_block('<!-- Stacked (overlapping horizontal) -->
<div class="so-avatar-group so-avatar-group-stacked">
    <div class="so-avatar"><img src="user1.jpg" alt=""></div>
    <div class="so-avatar"><img src="user2.jpg" alt=""></div>
    <div class="so-avatar"><img src="user3.jpg" alt=""></div>
    <div class="so-avatar so-avatar-more so-avatar-secondary"><span>+5</span></div>
</div>

<!-- Stacked with size modifier -->
<div class="so-avatar-group so-avatar-group-stacked so-avatar-group-sm">...</div>
<div class="so-avatar-group so-avatar-group-stacked so-avatar-group-lg">...</div>

<!-- Vertical list -->
<div class="so-avatar-group so-avatar-group-vertical">
    <div class="so-avatar so-avatar-status so-avatar-status-online">...</div>
    <div class="so-avatar so-avatar-status so-avatar-status-away">...</div>
    <div class="so-avatar so-avatar-status so-avatar-status-offline">...</div>
</div>

<!-- Grid layout -->
<div class="so-avatar-group so-avatar-group-grid">
    <div class="so-avatar">...</div>
    <div class="so-avatar">...</div>
    <div class="so-avatar">...</div>
    <div class="so-avatar so-avatar-more so-avatar-secondary"><span>+12</span></div>
</div>', 'html') ?>
                    </div>
                </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
