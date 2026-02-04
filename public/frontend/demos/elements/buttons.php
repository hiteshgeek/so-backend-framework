<?php
/**
 * SixOrbit UI Demo - Buttons
 */
$pageTitle = 'Buttons';
$pageDescription = 'Button components, variants, sizes, and states';

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
            <h1 class="so-page-title">Buttons</h1>
            <p class="so-page-subtitle">Button components, variants, sizes, and states</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

                <!-- Section 1: Button Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Button Variants</h3>
                    </div>
                    <div class="so-card-body">
                                <div class="so-flex so-gap-2 so-flex-wrap">
                                    <button class="so-btn so-btn-primary">Primary</button>
                                    <button class="so-btn so-btn-secondary">Secondary</button>
                                    <button class="so-btn so-btn-success">Success</button>
                                    <button class="so-btn so-btn-danger">Danger</button>
                                    <button class="so-btn so-btn-warning">Warning</button>
                                    <button class="so-btn so-btn-info">Info</button>
                                    <button class="so-btn so-btn-light">Light</button>
                                    <button class="so-btn so-btn-dark">Dark</button>
                                </div>
                        <?= so_code_block('<button class="so-btn so-btn-primary">Primary</button>
<button class="so-btn so-btn-secondary">Secondary</button>
<button class="so-btn so-btn-success">Success</button>
<button class="so-btn so-btn-danger">Danger</button>
<button class="so-btn so-btn-warning">Warning</button>
<button class="so-btn so-btn-info">Info</button>
<button class="so-btn so-btn-light">Light</button>
<button class="so-btn so-btn-dark">Dark</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 2: Outline Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Outline Buttons</h3>
                    </div>
                    <div class="so-card-body">
                                <div class="so-flex so-gap-2 so-flex-wrap">
                                    <button class="so-btn so-btn-outline-primary">Primary</button>
                                    <button class="so-btn so-btn-outline-secondary">Secondary</button>
                                    <button class="so-btn so-btn-outline-success">Success</button>
                                    <button class="so-btn so-btn-outline-danger">Danger</button>
                                    <button class="so-btn so-btn-outline-warning">Warning</button>
                                    <button class="so-btn so-btn-outline-info">Info</button>
                                    <button class="so-btn so-btn-outline-light">Light</button>
                                    <button class="so-btn so-btn-outline-dark">Dark</button>
                                </div>
                        <?= so_code_block('<button class="so-btn so-btn-outline-primary">Primary</button>
<button class="so-btn so-btn-outline-secondary">Secondary</button>
<button class="so-btn so-btn-outline-success">Success</button>
<button class="so-btn so-btn-outline-danger">Danger</button>
<button class="so-btn so-btn-outline-warning">Warning</button>
<button class="so-btn so-btn-outline-info">Info</button>
<button class="so-btn so-btn-outline-light">Light</button>
<button class="so-btn so-btn-outline-dark">Dark</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 3: Light Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Light Buttons (Soft Background)</h3>
                    </div>
                    <div class="so-card-body">
                                <div class="so-flex so-gap-2 so-flex-wrap">
                                    <button class="so-btn so-btn-light-primary">Primary</button>
                                    <button class="so-btn so-btn-light-secondary">Secondary</button>
                                    <button class="so-btn so-btn-light-success">Success</button>
                                    <button class="so-btn so-btn-light-danger">Danger</button>
                                    <button class="so-btn so-btn-light-warning">Warning</button>
                                    <button class="so-btn so-btn-light-info">Info</button>
                                    <button class="so-btn so-btn-light-light">Light</button>
                                    <button class="so-btn so-btn-light-dark">Dark</button>
                                </div>
                        <?= so_code_block('<button class="so-btn so-btn-light-primary">Primary</button>
<button class="so-btn so-btn-light-secondary">Secondary</button>
<button class="so-btn so-btn-light-success">Success</button>
<button class="so-btn so-btn-light-danger">Danger</button>
<button class="so-btn so-btn-light-warning">Warning</button>
<button class="so-btn so-btn-light-info">Info</button>
<button class="so-btn so-btn-light-light">Light</button>
<button class="so-btn so-btn-light-dark">Dark</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 4: Ghost Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Ghost Buttons</h3>
                    </div>
                    <div class="so-card-body">
                                <div class="so-flex so-gap-2 so-flex-wrap">
                                    <button class="so-btn so-btn-ghost so-btn-primary">Primary</button>
                                    <button class="so-btn so-btn-ghost so-btn-secondary">Secondary</button>
                                    <button class="so-btn so-btn-ghost so-btn-success">Success</button>
                                    <button class="so-btn so-btn-ghost so-btn-danger">Danger</button>
                                    <button class="so-btn so-btn-ghost so-btn-warning">Warning</button>
                                    <button class="so-btn so-btn-ghost so-btn-info">Info</button>
                                    <button class="so-btn so-btn-ghost so-btn-light">Light</button>
                                    <button class="so-btn so-btn-ghost so-btn-dark">Dark</button>
                                </div>
                        <?= so_code_block('<button class="so-btn so-btn-ghost so-btn-primary">Primary</button>
<button class="so-btn so-btn-ghost so-btn-secondary">Secondary</button>
<button class="so-btn so-btn-ghost so-btn-success">Success</button>
<button class="so-btn so-btn-ghost so-btn-danger">Danger</button>
<button class="so-btn so-btn-ghost so-btn-warning">Warning</button>
<button class="so-btn so-btn-ghost so-btn-info">Info</button>
<button class="so-btn so-btn-ghost so-btn-light">Light</button>
<button class="so-btn so-btn-ghost so-btn-dark">Dark</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 4b: Link Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Link Buttons</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-3">Link buttons look like text links but behave like buttons. Use text color helper classes for contextual colors.</p>
                                <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-link">Default Link</button>
                                    <button class="so-btn so-btn-link so-text-primary">Primary</button>
                                    <button class="so-btn so-btn-link so-text-secondary">Secondary</button>
                                    <button class="so-btn so-btn-link so-text-success">Success</button>
                                    <button class="so-btn so-btn-link so-text-danger">Danger</button>
                                    <button class="so-btn so-btn-link so-text-warning">Warning</button>
                                    <button class="so-btn so-btn-link so-text-info">Info</button>
                                    <button class="so-btn so-btn-link so-text-dark">Dark</button>
                                </div>

                                <h5 class="so-mb-3">Link Buttons with Icons</h5>
                                <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-link so-text-primary">
                                        <span class="material-icons">edit</span>
                                        Edit
                                    </button>
                                    <button class="so-btn so-btn-link so-text-danger">
                                        <span class="material-icons">delete</span>
                                        Delete
                                    </button>
                                    <button class="so-btn so-btn-link so-text-success">
                                        <span class="material-icons">add</span>
                                        Add New
                                    </button>
                                    <button class="so-btn so-btn-link so-text-info">
                                        <span class="material-icons">visibility</span>
                                        View
                                    </button>
                                </div>

                                <h5 class="so-mb-3">Link Button Sizes</h5>
                                <div class="so-flex so-gap-4 so-items-center so-flex-wrap">
                                    <button class="so-btn so-btn-link so-btn-xs so-text-primary">Extra Small</button>
                                    <button class="so-btn so-btn-link so-btn-sm so-text-primary">Small</button>
                                    <button class="so-btn so-btn-link so-text-primary">Default</button>
                                    <button class="so-btn so-btn-link so-btn-lg so-text-primary">Large</button>
                                </div>
                        <?= so_code_block('<!-- Default Link Button -->
<button class="so-btn so-btn-link">Default Link</button>

<!-- Contextual Colors (use text helper classes) -->
<button class="so-btn so-btn-link so-text-primary">Primary</button>
<button class="so-btn so-btn-link so-text-secondary">Secondary</button>
<button class="so-btn so-btn-link so-text-success">Success</button>
<button class="so-btn so-btn-link so-text-danger">Danger</button>
<button class="so-btn so-btn-link so-text-warning">Warning</button>
<button class="so-btn so-btn-link so-text-info">Info</button>
<button class="so-btn so-btn-link so-text-light">Light</button>
<button class="so-btn so-btn-link so-text-dark">Dark</button>

<!-- With Icon -->
<button class="so-btn so-btn-link so-text-danger">
    <span class="material-icons">delete</span>
    Delete
</button>

<!-- Sizes -->
<button class="so-btn so-btn-link so-btn-xs">Extra Small</button>
<button class="so-btn so-btn-link so-btn-sm">Small</button>
<button class="so-btn so-btn-link">Default</button>
<button class="so-btn so-btn-link so-btn-lg">Large</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 5: Button Sizes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Button Sizes</h3>
                    </div>
                    <div class="so-card-body">
                                <div class="so-flex so-gap-2 so-items-center so-flex-wrap">
                                    <button class="so-btn so-btn-primary so-btn-xs">Extra Small</button>
                                    <button class="so-btn so-btn-primary so-btn-sm">Small</button>
                                    <button class="so-btn so-btn-primary">Default</button>
                                    <button class="so-btn so-btn-primary so-btn-lg">Large</button>
                                </div>
                        <?= so_code_block('<button class="so-btn so-btn-primary so-btn-xs">Extra Small</button>
<button class="so-btn so-btn-primary so-btn-sm">Small</button>
<button class="so-btn so-btn-primary">Default</button>
<button class="so-btn so-btn-primary so-btn-lg">Large</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 6: Buttons with Icons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Buttons with Icons</h3>
                    </div>
                    <div class="so-card-body">
                                <div class="so-flex so-gap-2 so-flex-wrap">
                                    <button class="so-btn so-btn-primary">
                                        <span class="material-icons">add</span>
                                        Add New
                                    </button>
                                    <button class="so-btn so-btn-success">
                                        <span class="material-icons">save</span>
                                        Save
                                    </button>
                                    <button class="so-btn so-btn-danger">
                                        <span class="material-icons">delete</span>
                                        Delete
                                    </button>
                                    <button class="so-btn so-btn-outline">
                                        <span class="material-icons">download</span>
                                        Export
                                    </button>
                                </div>
                        <?= so_code_block('<button class="so-btn so-btn-primary">
    <span class="material-icons">add</span>
    Add New
</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 7: Icon-Only Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Icon-Only Buttons</h3>
                    </div>
                    <div class="so-card-body">
                                <div class="so-flex so-gap-2 so-flex-wrap so-items-center">
                                    <button class="so-btn so-btn-icon so-btn-primary">
                                        <span class="material-icons">add</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-success">
                                        <span class="material-icons">check</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-danger">
                                        <span class="material-icons">delete</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-outline">
                                        <span class="material-icons">edit</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-ghost">
                                        <span class="material-icons">more_vert</span>
                                    </button>
                                </div>
                        <?= so_code_block('<button class="so-btn so-btn-icon so-btn-primary">
    <span class="material-icons">add</span>
</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 8: Circular Icon Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Circular Icon Buttons</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-3">Add <code>.so-btn-circle</code> to icon buttons to make them circular. Works with all color variants and sizes.</p>

                                <!-- Default/Toolbar Style -->
                                <h5 class="so-mb-3">Default (Toolbar Style)</h5>
                                <p class="so-text-muted so-mb-3">Simple neutral buttons for toolbars and action bars - no color class needed.</p>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-icon so-btn-circle">
                                        <span class="material-icons">grid_view</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle">
                                        <span class="material-icons">settings</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle">
                                        <span class="material-icons">more_vert</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle">
                                        <span class="material-icons">search</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle">
                                        <span class="material-icons">filter_list</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle">
                                        <span class="material-icons">refresh</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle">
                                        <span class="material-icons">download</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle">
                                        <span class="material-icons">print</span>
                                    </button>
                                </div>

                                <!-- Ghost Default -->
                                <h5 class="so-mb-3">Ghost Default (Toolbar Style)</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost">
                                        <span class="material-icons">grid_view</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost">
                                        <span class="material-icons">settings</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost">
                                        <span class="material-icons">more_vert</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost">
                                        <span class="material-icons">search</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost">
                                        <span class="material-icons">filter_list</span>
                                    </button>
                                </div>

                                <!-- Solid Circular -->
                                <h5 class="so-mb-3">Solid Circular</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-primary">
                                        <span class="material-icons">add</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-secondary">
                                        <span class="material-icons">edit</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-success">
                                        <span class="material-icons">check</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-danger">
                                        <span class="material-icons">delete</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-warning">
                                        <span class="material-icons">warning</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-info">
                                        <span class="material-icons">info</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light">
                                        <span class="material-icons">light_mode</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-dark">
                                        <span class="material-icons">dark_mode</span>
                                    </button>
                                </div>

                                <!-- Outline Circular -->
                                <h5 class="so-mb-3">Outline Circular</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-outline-primary">
                                        <span class="material-icons">favorite</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-outline-secondary">
                                        <span class="material-icons">bookmark</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-outline-success">
                                        <span class="material-icons">thumb_up</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-outline-danger">
                                        <span class="material-icons">close</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-outline-warning">
                                        <span class="material-icons">star</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-outline-info">
                                        <span class="material-icons">lightbulb</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-outline-light">
                                        <span class="material-icons">visibility</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-outline-dark">
                                        <span class="material-icons">settings</span>
                                    </button>
                                </div>

                                <!-- Light (Soft) Circular -->
                                <h5 class="so-mb-3">Light (Soft) Circular</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light-primary">
                                        <span class="material-icons">share</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light-secondary">
                                        <span class="material-icons">link</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light-success">
                                        <span class="material-icons">download</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light-danger">
                                        <span class="material-icons">delete_outline</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light-warning">
                                        <span class="material-icons">notifications</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light-info">
                                        <span class="material-icons">help</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light-light">
                                        <span class="material-icons">refresh</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-light-dark">
                                        <span class="material-icons">more_horiz</span>
                                    </button>
                                </div>

                                <!-- Ghost Circular -->
                                <h5 class="so-mb-3">Ghost Circular</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost so-btn-primary">
                                        <span class="material-icons">more_vert</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost so-btn-secondary">
                                        <span class="material-icons">tune</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost so-btn-success">
                                        <span class="material-icons">check_circle</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost so-btn-danger">
                                        <span class="material-icons">cancel</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost so-btn-warning">
                                        <span class="material-icons">error</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-ghost so-btn-info">
                                        <span class="material-icons">info</span>
                                    </button>
                                </div>

                                <!-- Size Variants -->
                                <h5 class="so-mb-3">Size Variants</h5>
                                <div class="so-flex so-gap-2 so-items-center so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-primary so-btn-xs">
                                        <span class="material-icons" style="font-size: 14px;">add</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-primary so-btn-sm">
                                        <span class="material-icons" style="font-size: 16px;">add</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-primary">
                                        <span class="material-icons">add</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-primary so-btn-lg">
                                        <span class="material-icons" style="font-size: 24px;">add</span>
                                    </button>
                                </div>

                                <!-- FAB Style -->
                                <h5 class="so-mb-3">FAB Style (Material Design Floating Action Button)</h5>
                                <p class="so-text-muted so-mb-3">Combine circular buttons with <code>.so-shadow</code> or <code>.so-shadow-lg</code> for Material Design FAB style.</p>
                                <div class="so-flex so-gap-3 so-items-center so-flex-wrap">
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-primary so-btn-lg so-shadow-lg">
                                        <span class="material-icons" style="font-size: 24px;">add</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-success so-btn-lg so-shadow-lg">
                                        <span class="material-icons" style="font-size: 24px;">edit</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-danger so-btn-lg so-shadow-lg">
                                        <span class="material-icons" style="font-size: 24px;">delete</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-info so-btn-lg so-shadow-lg">
                                        <span class="material-icons" style="font-size: 24px;">chat</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-circle so-btn-warning so-btn-lg so-shadow">
                                        <span class="material-icons" style="font-size: 24px;">support</span>
                                    </button>
                                </div>

                        <?= so_code_block('<!-- Default/Toolbar Style (subtle background + border) -->
<button class="so-btn so-btn-icon so-btn-circle">
    <span class="material-icons">settings</span>
</button>

<!-- Ghost Style (transparent, no border) -->
<button class="so-btn so-btn-icon so-btn-circle so-btn-ghost">
    <span class="material-icons">more_vert</span>
</button>

<!-- Solid Circular with Color -->
<button class="so-btn so-btn-icon so-btn-circle so-btn-primary">
    <span class="material-icons">add</span>
</button>

<!-- Outline Circular with Color -->
<button class="so-btn so-btn-icon so-btn-circle so-btn-outline-primary">
    <span class="material-icons">favorite</span>
</button>

<!-- Size Variants -->
<button class="so-btn so-btn-icon so-btn-circle so-btn-xs">...</button>
<button class="so-btn so-btn-icon so-btn-circle so-btn-sm">...</button>
<button class="so-btn so-btn-icon so-btn-circle">...</button>
<button class="so-btn so-btn-icon so-btn-circle so-btn-lg">...</button>

<!-- FAB Style (with shadow) -->
<button class="so-btn so-btn-icon so-btn-circle so-btn-primary so-btn-lg so-shadow-lg">
    <span class="material-icons">add</span>
</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 8b: Avatar Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Avatar Buttons (Text/Initials)</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-3">Circular buttons with text or initials using <code>.so-btn-avatar</code>. Works with all color variants.</p>

                                <!-- Default Avatar Buttons -->
                                <h5 class="so-mb-3">Solid Avatar Buttons</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-avatar so-btn-primary">R</button>
                                    <button class="so-btn so-btn-avatar so-btn-secondary">AB</button>
                                    <button class="so-btn so-btn-avatar so-btn-success">JD</button>
                                    <button class="so-btn so-btn-avatar so-btn-danger">K</button>
                                    <button class="so-btn so-btn-avatar so-btn-warning">M</button>
                                    <button class="so-btn so-btn-avatar so-btn-info">P</button>
                                    <button class="so-btn so-btn-avatar so-btn-dark">S</button>
                                </div>

                                <!-- Outline Avatar Buttons -->
                                <h5 class="so-mb-3">Outline Avatar Buttons</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-avatar so-btn-outline-primary">R</button>
                                    <button class="so-btn so-btn-avatar so-btn-outline-secondary">AB</button>
                                    <button class="so-btn so-btn-avatar so-btn-outline-success">JD</button>
                                    <button class="so-btn so-btn-avatar so-btn-outline-danger">K</button>
                                    <button class="so-btn so-btn-avatar so-btn-outline-warning">M</button>
                                    <button class="so-btn so-btn-avatar so-btn-outline-info">P</button>
                                    <button class="so-btn so-btn-avatar so-btn-outline-dark">S</button>
                                </div>

                                <!-- Light/Soft Avatar Buttons -->
                                <h5 class="so-mb-3">Light (Soft) Avatar Buttons</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-avatar so-btn-light-primary">R</button>
                                    <button class="so-btn so-btn-avatar so-btn-light-secondary">AB</button>
                                    <button class="so-btn so-btn-avatar so-btn-light-success">JD</button>
                                    <button class="so-btn so-btn-avatar so-btn-light-danger">K</button>
                                    <button class="so-btn so-btn-avatar so-btn-light-warning">M</button>
                                    <button class="so-btn so-btn-avatar so-btn-light-info">P</button>
                                    <button class="so-btn so-btn-avatar so-btn-light-dark">S</button>
                                </div>

                                <!-- Size Variants -->
                                <h5 class="so-mb-3">Size Variants</h5>
                                <div class="so-flex so-gap-2 so-items-center so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-avatar so-btn-primary so-btn-xs">R</button>
                                    <button class="so-btn so-btn-avatar so-btn-primary so-btn-sm">R</button>
                                    <button class="so-btn so-btn-avatar so-btn-primary">R</button>
                                    <button class="so-btn so-btn-avatar so-btn-primary so-btn-lg">R</button>
                                    <button class="so-btn so-btn-avatar so-btn-primary so-btn-xl">R</button>
                                </div>

                        <?= so_code_block('<!-- Avatar Button with single initial -->
<button class="so-btn so-btn-avatar so-btn-primary">R</button>

<!-- Avatar Button with two initials -->
<button class="so-btn so-btn-avatar so-btn-success">JD</button>

<!-- Outline variant -->
<button class="so-btn so-btn-avatar so-btn-outline-primary">R</button>

<!-- Light/Soft variant -->
<button class="so-btn so-btn-avatar so-btn-light-primary">R</button>

<!-- Size variants -->
<button class="so-btn so-btn-avatar so-btn-primary so-btn-xs">R</button>
<button class="so-btn so-btn-avatar so-btn-primary so-btn-sm">R</button>
<button class="so-btn so-btn-avatar so-btn-primary">R</button>
<button class="so-btn so-btn-avatar so-btn-primary so-btn-lg">R</button>
<button class="so-btn so-btn-avatar so-btn-primary so-btn-xl">R</button>', 'html') ?>
                    </div>
                </div>

                <!-- Section 9: Hover Style Modifiers -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Hover Style Modifiers</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-hint">Combine any button variant with a hover modifier to customize hover behavior</p>
                                <!-- Soft Hover -->
                                <h5 class="so-demo-section-title-sm">.btn-hover-soft (Light tinted background)</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-3">
                                    <button class="so-btn so-btn-outline-primary btn-hover-soft">Outline + Soft</button>
                                    <button class="so-btn so-btn-outline-success btn-hover-soft">Outline + Soft</button>
                                    <button class="so-btn so-btn-outline-danger btn-hover-soft">Outline + Soft</button>
                                    <button class="so-btn so-btn-light-primary btn-hover-soft">Light + Soft</button>
                                    <button class="so-btn so-btn-ghost so-btn-primary btn-hover-soft">Ghost + Soft</button>
                                </div>

                                <!-- Solid Hover -->
                                <h5 class="so-demo-section-title-sm">.btn-hover-solid (Fill with solid color)</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-3">
                                    <button class="so-btn so-btn-ghost so-btn-primary btn-hover-solid">Ghost + Solid</button>
                                    <button class="so-btn so-btn-ghost so-btn-success btn-hover-solid">Ghost + Solid</button>
                                    <button class="so-btn so-btn-ghost so-btn-danger btn-hover-solid">Ghost + Solid</button>
                                    <button class="so-btn so-btn-light-info btn-hover-solid">Light + Solid</button>
                                </div>

                                <!-- Darken Hover -->
                                <h5 class="so-demo-section-title-sm">.btn-hover-darken (Subtle darkening)</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-3">
                                    <button class="so-btn so-btn-light-primary btn-hover-darken">Light + Darken</button>
                                    <button class="so-btn so-btn-light-success btn-hover-darken">Light + Darken</button>
                                    <button class="so-btn so-btn-light-danger btn-hover-darken">Light + Darken</button>
                                    <button class="so-btn so-btn-outline-primary btn-hover-darken">Outline + Darken</button>
                                    <button class="so-btn so-btn-ghost btn-hover-darken">Ghost + Darken</button>
                                </div>

                                <!-- Effect Hovers -->
                                <h5 class="so-demo-section-title-sm">Effect Modifiers (.btn-hover-lift, .btn-hover-scale, .btn-hover-none)</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-3">
                                    <button class="so-btn so-btn-primary btn-hover-lift">Lift Effect</button>
                                    <button class="so-btn so-btn-success btn-hover-scale">Scale Effect</button>
                                    <button class="so-btn so-btn-outline-danger btn-hover-lift">Outline + Lift</button>
                                    <button class="so-btn so-btn-light-info btn-hover-none">No Hover</button>
                                </div>
                        <?= so_code_block('<!-- Soft Hover: Light tinted background on hover -->
<button class="so-btn so-btn-outline-primary btn-hover-soft">Outline + Soft</button>
<button class="so-btn so-btn-light-primary btn-hover-soft">Light + Soft</button>
<button class="so-btn so-btn-ghost so-btn-primary btn-hover-soft">Ghost + Soft</button>

<!-- Solid Hover: Fill with solid color on hover -->
<button class="so-btn so-btn-ghost so-btn-primary btn-hover-solid">Ghost + Solid</button>
<button class="so-btn so-btn-light-info btn-hover-solid">Light + Solid</button>

<!-- Darken Hover: Subtle darkening on hover -->
<button class="so-btn so-btn-light-primary btn-hover-darken">Light + Darken</button>
<button class="so-btn so-btn-outline-primary btn-hover-darken">Outline + Darken</button>

<!-- Effect Modifiers -->
<button class="so-btn so-btn-primary btn-hover-lift">Lift Effect</button>
<button class="so-btn so-btn-success btn-hover-scale">Scale Effect</button>
<button class="so-btn so-btn-light-info btn-hover-none">No Hover</button>

<!-- Available hover modifiers:
  .btn-hover-soft   - Light tinted background (like ghost)
  .btn-hover-solid  - Fill with solid color (like outline default)
  .btn-hover-darken - Slightly darker shade
  .btn-hover-lift   - Elevate with shadow
  .btn-hover-scale  - Slight scale up
  .btn-hover-none   - Disable hover effects
-->', 'html') ?>
                    </div>
                </div>

                <!-- Section 10: Loading Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Loading Buttons</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-3">Add the <code>.so-loading</code> class to show a spinner and disable interaction. Works with all button variants.</p>
                                <h5 class="so-mb-3">Solid Variants</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-primary so-loading">Primary</button>
                                    <button class="so-btn so-btn-secondary so-loading">Secondary</button>
                                    <button class="so-btn so-btn-success so-loading">Success</button>
                                    <button class="so-btn so-btn-danger so-loading">Danger</button>
                                    <button class="so-btn so-btn-warning so-loading">Warning</button>
                                    <button class="so-btn so-btn-info so-loading">Info</button>
                                    <button class="so-btn so-btn-light so-loading">Light</button>
                                    <button class="so-btn so-btn-dark so-loading">Dark</button>
                                </div>

                                <h5 class="so-mb-3">Outline Variants</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-outline-primary so-loading">Primary</button>
                                    <button class="so-btn so-btn-outline-secondary so-loading">Secondary</button>
                                    <button class="so-btn so-btn-outline-success so-loading">Success</button>
                                    <button class="so-btn so-btn-outline-danger so-loading">Danger</button>
                                    <button class="so-btn so-btn-outline-warning so-loading">Warning</button>
                                    <button class="so-btn so-btn-outline-info so-loading">Info</button>
                                    <button class="so-btn so-btn-outline-light so-loading">Light</button>
                                    <button class="so-btn so-btn-outline-dark so-loading">Dark</button>
                                </div>

                                <h5 class="so-mb-3">Light (Soft) Variants</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-light-primary so-loading">Primary</button>
                                    <button class="so-btn so-btn-light-secondary so-loading">Secondary</button>
                                    <button class="so-btn so-btn-light-success so-loading">Success</button>
                                    <button class="so-btn so-btn-light-danger so-loading">Danger</button>
                                    <button class="so-btn so-btn-light-warning so-loading">Warning</button>
                                    <button class="so-btn so-btn-light-info so-loading">Info</button>
                                    <button class="so-btn so-btn-light-light so-loading">Light</button>
                                    <button class="so-btn so-btn-light-dark so-loading">Dark</button>
                                </div>

                                <h5 class="so-mb-3">Ghost & Link Variants</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-ghost so-btn-primary so-loading">Ghost Primary</button>
                                    <button class="so-btn so-btn-ghost so-btn-success so-loading">Ghost Success</button>
                                    <button class="so-btn so-btn-ghost so-btn-danger so-loading">Ghost Danger</button>
                                    <button class="so-btn so-btn-link so-loading">Link Button</button>
                                </div>

                                <h5 class="so-mb-3">Size Variants</h5>
                                <div class="so-flex so-gap-2 so-items-center so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-primary so-btn-xs so-loading">Extra Small</button>
                                    <button class="so-btn so-btn-primary so-btn-sm so-loading">Small</button>
                                    <button class="so-btn so-btn-primary so-loading">Default</button>
                                    <button class="so-btn so-btn-primary so-btn-lg so-loading">Large</button>
                                </div>

                                <h5 class="so-mb-3">Icon Buttons</h5>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-icon so-btn-primary so-loading">
                                        <span class="material-icons">add</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-success so-loading">
                                        <span class="material-icons">check</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-outline-danger so-loading">
                                        <span class="material-icons">delete</span>
                                    </button>
                                    <button class="so-btn so-btn-icon so-btn-ghost so-loading">
                                        <span class="material-icons">more_vert</span>
                                    </button>
                                </div>

                                <h5 class="so-mb-3">Interactive Demo</h5>
                                <p class="so-text-muted so-mb-3">Click buttons to toggle loading state</p>
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                                    <button class="so-btn so-btn-primary" onclick="this.classList.toggle('so-loading')">
                                        <span class="material-icons">save</span>
                                        Save Changes
                                    </button>
                                    <button class="so-btn so-btn-success" onclick="this.classList.toggle('so-loading')">
                                        <span class="material-icons">send</span>
                                        Submit
                                    </button>
                                    <button class="so-btn so-btn-outline-primary" onclick="this.classList.toggle('so-loading')">
                                        <span class="material-icons">refresh</span>
                                        Refresh
                                    </button>
                                    <button class="so-btn so-btn-light-danger" onclick="this.classList.toggle('so-loading')">
                                        <span class="material-icons">delete</span>
                                        Delete
                                    </button>
                                </div>
                        <?= so_code_tabs('loading-btn', [
                            ['language' => 'html', 'code' => '<!-- Add .so-loading class to show spinner -->
<button class="so-btn so-btn-primary so-loading">Loading...</button>

<!-- Works with all variants (8 contextual colors) -->
<button class="so-btn so-btn-primary so-loading">Primary</button>
<button class="so-btn so-btn-secondary so-loading">Secondary</button>
<button class="so-btn so-btn-success so-loading">Success</button>
<button class="so-btn so-btn-danger so-loading">Danger</button>
<button class="so-btn so-btn-warning so-loading">Warning</button>
<button class="so-btn so-btn-info so-loading">Info</button>
<button class="so-btn so-btn-light so-loading">Light</button>
<button class="so-btn so-btn-dark so-loading">Dark</button>

<!-- Outline variants -->
<button class="so-btn so-btn-outline-primary so-loading">Outline</button>

<!-- Light (soft) variants -->
<button class="so-btn so-btn-light-primary so-loading">Light</button>

<!-- Ghost variants -->
<button class="so-btn so-btn-ghost so-btn-primary so-loading">Ghost</button>

<!-- Link button -->
<button class="so-btn so-btn-link so-loading">Link</button>

<!-- Icon button -->
<button class="so-btn so-btn-icon so-btn-primary so-loading">
    <span class="material-icons">add</span>
</button>

<!-- Button with icon and text -->
<button class="so-btn so-btn-primary so-loading">
    <span class="material-icons">save</span>
    Save Changes
</button>'],
                            ['language' => 'javascript', 'code' => '// Get button element
const btn = document.querySelector(\'.so-btn\');

// Start loading
btn.classList.add(\'so-loading\');

// Stop loading
btn.classList.remove(\'so-loading\');

// Toggle loading
btn.classList.toggle(\'so-loading\');

// Example: Form submission with loading state
const submitBtn = document.querySelector(\'#submit-btn\');
const form = document.querySelector(\'#my-form\');

form.addEventListener(\'submit\', async (e) => {
    e.preventDefault();

    // Show loading state
    submitBtn.classList.add(\'so-loading\');
    submitBtn.disabled = true;

    try {
        // Simulate API call
        await fetch(\'/api/submit\', {
            method: \'POST\',
            body: new FormData(form)
        });

        // Success handling
        console.log(\'Form submitted!\');
    } catch (error) {
        console.error(\'Error:\', error);
    } finally {
        // Remove loading state
        submitBtn.classList.remove(\'so-loading\');
        submitBtn.disabled = false;
    }
});

// Example: Toggle loading on click
document.querySelector(\'.toggle-btn\').addEventListener(\'click\', function() {
    this.classList.toggle(\'so-loading\');
});']
                        ]) ?>
                    </div>
                </div>

                <!-- Section 10b: Data Loading Attribute -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Data Loading Attribute</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-3">Alternative to <code>.so-loading</code> class - use the <code>data-loading</code> attribute for declarative loading states.</p>

                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-4">
                                    <button class="so-btn so-btn-primary" data-loading>Loading Button</button>
                                    <button class="so-btn so-btn-success" data-loading="true">Processing</button>
                                    <button class="so-btn so-btn-outline-primary" data-loading>Outline Loading</button>
                                    <button class="so-btn so-btn-light-danger" data-loading>Light Loading</button>
                                </div>

                                <h5 class="so-demo-section-title">Interactive Example</h5>
                                <p class="so-text-muted so-mb-3">Click buttons to toggle data-loading attribute via JavaScript</p>
                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-4">
                                    <button class="so-btn so-btn-primary" onclick="this.toggleAttribute('data-loading')">
                                        <span class="material-icons">save</span>
                                        Save
                                    </button>
                                    <button class="so-btn so-btn-success" onclick="this.toggleAttribute('data-loading')">
                                        <span class="material-icons">check</span>
                                        Submit
                                    </button>
                                    <button class="so-btn so-btn-outline-primary" onclick="this.toggleAttribute('data-loading')">
                                        <span class="material-icons">refresh</span>
                                        Refresh
                                    </button>
                                </div>

                        <?= so_code_tabs('data-loading-btn', [
                            ['language' => 'html', 'code' => '<!-- Use data-loading attribute -->
<button class="so-btn so-btn-primary" data-loading>Loading...</button>

<!-- Explicit true value -->
<button class="so-btn so-btn-success" data-loading="true">Processing</button>

<!-- Works with all button variants -->
<button class="so-btn so-btn-outline-primary" data-loading>Outline</button>
<button class="so-btn so-btn-light-danger" data-loading>Light</button>
<button class="so-btn so-btn-ghost so-btn-primary" data-loading>Ghost</button>'],
                            ['language' => 'javascript', 'code' => 'const btn = document.querySelector(\'.so-btn\');

// Start loading
btn.setAttribute(\'data-loading\', \'\');
// or
btn.dataset.loading = \'true\';

// Stop loading
btn.removeAttribute(\'data-loading\');
// or
btn.dataset.loading = \'false\';

// Toggle loading
btn.toggleAttribute(\'data-loading\');

// Example: Form submission
async function handleSubmit(btn) {
    btn.dataset.loading = \'true\';
    try {
        await submitForm();
    } finally {
        delete btn.dataset.loading;
    }
}']
                        ]) ?>
                    </div>
                </div>

                <!-- Section 11: Progress Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Progress Buttons</h3>
                    </div>
                    <div class="so-card-body">
                                <!-- Solid Variants -->
                                <h5 class="so-demo-section-title">Solid Variants</h5>
                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-4">
                                    <button class="so-btn so-btn-primary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Primary</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Done</span>
                                    </button>
                                    <button class="so-btn so-btn-secondary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Secondary</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-success so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Success</span>
                                        <span class="so-btn-done"><span class="material-icons">check_circle</span></span>
                                    </button>
                                    <button class="so-btn so-btn-danger so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Danger</span>
                                        <span class="so-btn-done"><span class="material-icons">close</span></span>
                                    </button>
                                    <button class="so-btn so-btn-warning so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Warning</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-info so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Info</span>
                                        <span class="so-btn-done">Synced!</span>
                                    </button>
                                </div>

                                <!-- Outline Variants -->
                                <h5 class="so-demo-section-title">Outline Variants</h5>
                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-4">
                                    <button class="so-btn so-btn-outline-primary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Primary</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-outline-success so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Success</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-outline-danger so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Danger</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-outline-warning so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Warning</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-outline-info so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Info</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                </div>

                                <!-- Light Variants -->
                                <h5 class="so-demo-section-title">Light (Soft) Variants</h5>
                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-4">
                                    <button class="so-btn so-btn-light-primary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Primary</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-light-success so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Success</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-light-danger so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Danger</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-light-warning so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Warning</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-light-info so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Info</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                </div>

                                <!-- Size Variants -->
                                <h5 class="so-demo-section-title">Size Variants</h5>
                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-4">
                                    <button class="so-btn so-btn-primary so-btn-xs so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Extra Small</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-primary so-btn-sm so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Small</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-primary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Default</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <button class="so-btn so-btn-primary so-btn-lg so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Large</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                </div>

                                <!-- Content Variants: Text Only, Icon Only, Text + Icon -->
                                <h5 class="so-demo-section-title">Content Variants</h5>
                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-3">
                                    <!-- Text Only -->
                                    <button class="so-btn so-btn-primary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Text Only</span>
                                        <span class="so-btn-done">Done!</span>
                                    </button>
                                    <!-- Icon Only -->
                                    <button class="so-btn so-btn-primary so-btn-icon so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text"><span class="material-icons">cloud_upload</span></span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                    <!-- Icon + Label -->
                                    <button class="so-btn so-btn-success so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text"><span class="material-icons">save</span> Save</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Saved</span>
                                    </button>
                                    <!-- Label + Icon -->
                                    <button class="so-btn so-btn-info so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Sync <span class="material-icons">sync</span></span>
                                        <span class="so-btn-done"><span class="material-icons">cloud_done</span></span>
                                    </button>
                                </div>

                                <!-- Start Content - Different content shown only during progress -->
                                <h5 class="so-demo-section-title">Start Content (Progress-Only)</h5>
                                <p class="so-demo-hint">Use <code>.so-btn-start</code> for content that appears <strong>only during progress</strong> - hidden by default, visible while progressing, hidden on complete. Can be icon, text, or any combination.</p>
                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-3">
                                    <!-- Start Icon + Progress Text -->
                                    <button class="so-btn so-btn-primary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-start"><span class="material-icons">cloud_upload</span></span>
                                        <span class="so-btn-text">Uploading...</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Uploaded</span>
                                    </button>
                                    <!-- Start Label + Progress Text -->
                                    <button class="so-btn so-btn-success so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-start">File:</span>
                                        <span class="so-btn-text">Processing...</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Complete</span>
                                    </button>
                                    <!-- Start Icon + Label + Progress -->
                                    <button class="so-btn so-btn-outline-primary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-start"><span class="material-icons">folder</span> docs/</span>
                                        <span class="so-btn-text">Syncing...</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Synced</span>
                                    </button>
                                    <!-- Download with filename -->
                                    <button class="so-btn so-btn-light-info so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-start"><span class="material-icons">download</span></span>
                                        <span class="so-btn-text">report.pdf</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span></span>
                                    </button>
                                </div>
                                <p class="so-demo-progress-hint">Click buttons to see progress animation</p>

                                <!-- Done State Color Modifiers -->
                                <h5 class="so-demo-done-state-title">Done State Color Control</h5>
                                <p class="so-demo-hint">Override the completed state color with <code>.so-btn-done-{color}</code> or keep parent color with <code>.so-btn-done-match</code></p>

                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-3">
                                    <!-- Default: Primary -> Success -->
                                    <button class="so-btn so-btn-primary so-btn-progress" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Default (-> Success)</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Done</span>
                                    </button>
                                    <!-- Match Parent Color -->
                                    <button class="so-btn so-btn-primary so-btn-progress so-btn-done-match" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Match Parent</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Done</span>
                                    </button>
                                    <!-- Force Danger -->
                                    <button class="so-btn so-btn-primary so-btn-progress so-btn-done-danger" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Force Danger</span>
                                        <span class="so-btn-done"><span class="material-icons">warning</span> Error</span>
                                    </button>
                                    <!-- Force Info -->
                                    <button class="so-btn so-btn-warning so-btn-progress so-btn-done-info" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Warning -> Info</span>
                                        <span class="so-btn-done"><span class="material-icons">info</span> Complete</span>
                                    </button>
                                </div>
                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-3">
                                    <!-- Outline with Match -->
                                    <button class="so-btn so-btn-outline-danger so-btn-progress so-btn-done-match" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Outline Match</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Done</span>
                                    </button>
                                    <!-- Outline Force Success -->
                                    <button class="so-btn so-btn-outline-secondary so-btn-progress so-btn-done-success" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Secondary -> Success</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Done</span>
                                    </button>
                                    <!-- Light with Match -->
                                    <button class="so-btn so-btn-light-info so-btn-progress so-btn-done-match" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Light Match</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Done</span>
                                    </button>
                                    <!-- Light Force Primary -->
                                    <button class="so-btn so-btn-light-danger so-btn-progress so-btn-done-primary" onclick="simulateProgress(this)">
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-text">Light -> Primary</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Done</span>
                                    </button>
                                </div>

                                <!-- Programmatic Control -->
                                <h5 class="so-demo-done-state-title">Programmatic Control (SOProgressButton)</h5>
                                <p class="so-demo-hint">Use <code>SOProgressButton</code> class to control progress buttons programmatically with events and API methods.</p>

                                <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-3">
                                    <!-- Demo button with API -->
                                    <button id="demo-progress-btn" class="so-btn so-btn-primary so-btn-progress" data-so-progress>
                                        <span class="so-btn-progress-bar"></span>
                                        <span class="so-btn-start"><span class="material-icons">cloud_upload</span></span>
                                        <span class="so-btn-text">Upload File</span>
                                        <span class="so-btn-done"><span class="material-icons">check</span> Uploaded</span>
                                    </button>
                                </div>

                                <!-- Control buttons -->
                                <div class="so-flex so-gap-2 so-flex-wrap so-mb-3">
                                    <button class="so-btn so-btn-sm so-btn-outline" onclick="demoProgressBtn.start()">start()</button>
                                    <button class="so-btn so-btn-sm so-btn-outline" onclick="demoProgressBtn.setProgress(25)">setProgress(25)</button>
                                    <button class="so-btn so-btn-sm so-btn-outline" onclick="demoProgressBtn.setProgress(50)">setProgress(50)</button>
                                    <button class="so-btn so-btn-sm so-btn-outline" onclick="demoProgressBtn.setProgress(75)">setProgress(75)</button>
                                    <button class="so-btn so-btn-sm so-btn-outline" onclick="demoProgressBtn.complete()">complete()</button>
                                    <button class="so-btn so-btn-sm so-btn-outline" onclick="demoProgressBtn.reset()">reset()</button>
                                    <button class="so-btn so-btn-sm so-btn-outline-success" onclick="demoProgressBtn.simulate()">simulate()</button>
                                </div>

                                <!-- Event output -->
                                <div class="so-card so-card-bordered so-mb-3">
                                    <div class="so-card-body so-p-3">
                                        <p class="so-demo-desc-sm so-mb-2"><strong>Events:</strong></p>
                                        <div id="progress-event-output" class="so-demo-output so-bg-body-secondary so-rounded" style="min-height: 60px; font-size: 12px;">
                                            Click a control button to see events...
                                        </div>
                                    </div>
                                </div>

                                <script>
                                // Initialize progress button
                                let demoProgressBtn;
                                document.addEventListener('DOMContentLoaded', function() {
                                    const btn = document.getElementById('demo-progress-btn');
                                    demoProgressBtn = SOProgressButton.getInstance(btn);
                                    const output = document.getElementById('progress-event-output');

                                    // Listen to events
                                    btn.addEventListener('so:progress:start', (e) => {
                                        output.innerHTML = `<span class="so-text-primary">start</span> - progress: ${e.detail.progress.toFixed(0)}%, state: ${e.detail.state}`;
                                    });
                                    btn.addEventListener('so:progress:update', (e) => {
                                        output.innerHTML = `<span class="so-text-info">update</span> - progress: ${e.detail.progress.toFixed(0)}%, prev: ${e.detail.previousProgress.toFixed(0)}%`;
                                    });
                                    btn.addEventListener('so:progress:complete', (e) => {
                                        output.innerHTML = `<span class="so-text-success">complete</span> - progress: ${e.detail.progress}%, state: ${e.detail.state}`;
                                    });
                                    btn.addEventListener('so:progress:reset', (e) => {
                                        output.innerHTML = `<span class="so-text-secondary">reset</span> - progress: ${e.detail.progress}%, state: ${e.detail.state}`;
                                    });
                                });
                                </script>
                        <?= so_code_tabs('progress-btn', [
                            ['language' => 'html', 'code' => '<!-- Text Only -->
<button class="so-btn so-btn-primary so-btn-progress">
    <span class="so-btn-progress-bar"></span>
    <span class="so-btn-text">Upload File</span>
    <span class="so-btn-done">Done!</span>
</button>

<!-- Icon Only -->
<button class="so-btn so-btn-primary so-btn-icon so-btn-progress">
    <span class="so-btn-progress-bar"></span>
    <span class="so-btn-text"><span class="material-icons">cloud_upload</span></span>
    <span class="so-btn-done"><span class="material-icons">check</span></span>
</button>

<!-- Icon + Label -->
<button class="so-btn so-btn-success so-btn-progress">
    <span class="so-btn-progress-bar"></span>
    <span class="so-btn-text"><span class="material-icons">save</span> Save</span>
    <span class="so-btn-done"><span class="material-icons">check</span> Saved</span>
</button>

<!-- Start Content (hidden by default, appears only during progress) -->
<button class="so-btn so-btn-primary so-btn-progress">
    <span class="so-btn-progress-bar"></span>
    <span class="so-btn-start"><span class="material-icons">cloud_upload</span></span>
    <span class="so-btn-text">Uploading...</span>
    <span class="so-btn-done"><span class="material-icons">check</span> Uploaded</span>
</button>

<!-- Done State Color Modifiers -->
<button class="so-btn so-btn-primary so-btn-progress so-btn-done-match">...</button>
<button class="so-btn so-btn-primary so-btn-progress so-btn-done-danger">...</button>

<!-- Programmatic Control -->
<button id="my-btn" class="so-btn so-btn-primary so-btn-progress" data-so-progress>
    <span class="so-btn-progress-bar"></span>
    <span class="so-btn-text">Upload</span>
    <span class="so-btn-done">Done</span>
</button>'],
                            ['language' => 'javascript', 'code' => '// Get instance
const btn = SOProgressButton.getInstance(\'#my-btn\');

// API Methods
btn.start();              // Start progress (enters progressing state)
btn.start(25);            // Start at specific progress
btn.setProgress(50);      // Set progress to 50%
btn.increment(10);        // Add 10% to current progress
btn.complete();           // Complete (100% + completed state)
btn.reset();              // Reset to initial state
btn.simulate();           // Auto-simulate progress animation

// Getters
btn.getProgress();        // Returns current progress (0-100)
btn.getState();           // Returns \'idle\', \'progressing\', or \'completed\'
btn.isProgressing();      // Returns true if in progress
btn.isCompleted();        // Returns true if completed
btn.isIdle();             // Returns true if idle

// Content manipulation
btn.setText(\'<span class="material-icons">save</span> Save\');
btn.setStartContent(\'<span class="material-icons">sync</span>\');
btn.setDoneContent(\'<span class="material-icons">check</span> Saved\');

// Events
btn.element.addEventListener(\'so:progress:start\', (e) => {
    console.log(\'Started:\', e.detail.progress, e.detail.state);
});
btn.element.addEventListener(\'so:progress:update\', (e) => {
    console.log(\'Progress:\', e.detail.progress, e.detail.previousProgress);
});
btn.element.addEventListener(\'so:progress:complete\', (e) => {
    console.log(\'Completed:\', e.detail.state);
});
btn.element.addEventListener(\'so:progress:reset\', (e) => {
    console.log(\'Reset:\', e.detail.state);
});

// Options (via data attributes)
// data-auto-disable="true"     - Disable button during progress (default: true)
// data-auto-reset="3000"       - Auto reset after complete (ms, 0 = disabled)
// data-simulate-on-click="true" - Auto-simulate on click']
                        ]) ?>
                    </div>
                </div>

<script>
// Progress button demo helper function
function simulateProgress(btn) {
    // Reset if already completed
    if (btn.classList.contains('so-completed')) {
        btn.classList.remove('so-completed');
        btn.style.setProperty('--progress', '0%');
        return;
    }

    let progress = 0;
    btn.disabled = true;
    btn.classList.add('so-progressing');

    const interval = setInterval(() => {
        progress += Math.random() * 15 + 5;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
            btn.style.setProperty('--progress', '100%');

            // Add completed class after a brief moment
            setTimeout(() => {
                btn.classList.remove('so-progressing');
                btn.classList.add('so-completed');
                btn.disabled = false;
            }, 200);
        } else {
            btn.style.setProperty('--progress', progress + '%');
        }
    }, 150);
}
</script>

    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
