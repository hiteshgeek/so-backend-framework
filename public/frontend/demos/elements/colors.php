<?php
/**
 * SixOrbit UI Demo - Colors
 */
$pageTitle = 'Colors';
$pageDescription = 'Color palette and utilities';

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
            <h1 class="so-page-title">Colors</h1>
            <p class="so-page-subtitle">Color palette and utilities</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Text Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Text Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Apply contextual colors to text elements using <code>.so-text-{color}</code> classes.</p>

                        <h4 class="so-demo-section-heading-spaced">8 Contextual Colors</h4>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <span class="so-text-primary so-fw-medium">Primary</span>
                            <span class="so-text-success so-fw-medium">Success</span>
                            <span class="so-text-warning so-fw-medium">Warning</span>
                            <span class="so-text-info so-fw-medium">Info</span>
                            <span class="so-text-danger so-fw-medium">Danger</span>
                            <span class="so-text-secondary so-fw-medium">Secondary</span>
                            <span class="so-text-dark so-fw-medium">Dark</span>
                            <span class="so-text-light so-bg-dark so-p-2 so-rounded so-fw-medium">Light</span>
                        </div>

                        <h4 class="so-demo-section-heading-spaced">Additional Text Colors</h4>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <span class="so-text-white so-bg-dark so-p-2 so-rounded">White</span>
                            <span class="so-text-black">Black</span>
                            <span class="so-text-muted">Muted</span>
                            <span class="so-text-body">Body</span>
                            <span class="so-text-body-secondary">Body Secondary</span>
                            <span class="so-text-body-tertiary">Body Tertiary</span>
                        </div>

                        <?= so_code_block('<span class="so-text-primary">Primary</span>
<span class="so-text-success">Success</span>
<span class="so-text-warning">Warning</span>
<span class="so-text-info">Info</span>
<span class="so-text-danger">Danger</span>
<span class="so-text-secondary">Secondary</span>
<span class="so-text-dark">Dark</span>
<span class="so-text-light">Light</span>

<!-- Additional colors -->
<span class="so-text-white">White</span>
<span class="so-text-black">Black</span>
<span class="so-text-muted">Muted</span>
<span class="so-text-body">Body (theme-aware)</span>', 'html') ?>
                    </div>
                </div>

                <!-- Background Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Background Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Apply contextual background colors using <code>.so-bg-{color}</code> classes.</p>

                        <h4 class="so-demo-section-heading-spaced">8 Contextual Backgrounds</h4>
                        <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-3 so-mb-4">
                            <div class="so-bg-primary so-text-white so-p-3 so-rounded so-text-center">Primary</div>
                            <div class="so-bg-success so-text-white so-p-3 so-rounded so-text-center">Success</div>
                            <div class="so-bg-warning so-text-dark so-p-3 so-rounded so-text-center">Warning</div>
                            <div class="so-bg-info so-text-white so-p-3 so-rounded so-text-center">Info</div>
                            <div class="so-bg-danger so-text-white so-p-3 so-rounded so-text-center">Danger</div>
                            <div class="so-bg-secondary so-text-white so-p-3 so-rounded so-text-center">Secondary</div>
                            <div class="so-bg-dark so-text-white so-p-3 so-rounded so-text-center">Dark</div>
                            <div class="so-bg-light so-text-dark so-p-3 so-rounded so-text-center" style="border: 1px solid var(--so-border-color)">Light</div>
                        </div>

                        <h4 class="so-demo-section-heading-spaced">Additional Backgrounds</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <div class="so-bg-white so-text-dark so-p-3 so-rounded" style="border: 1px solid var(--so-border-color)">White</div>
                            <div class="so-bg-black so-text-white so-p-3 so-rounded">Black</div>
                            <div class="so-bg-transparent so-p-3 so-rounded" style="border: 1px dashed var(--so-border-color)">Transparent</div>
                            <div class="so-bg-body so-p-3 so-rounded" style="border: 1px solid var(--so-border-color)">Body (theme-aware)</div>
                        </div>

                        <?= so_code_block('<div class="so-bg-primary so-text-white">Primary</div>
<div class="so-bg-success so-text-white">Success</div>
<div class="so-bg-warning so-text-dark">Warning</div>
<div class="so-bg-info so-text-white">Info</div>
<div class="so-bg-danger so-text-white">Danger</div>
<div class="so-bg-secondary so-text-white">Secondary</div>
<div class="so-bg-dark so-text-white">Dark</div>
<div class="so-bg-light so-text-dark">Light</div>', 'html') ?>
                    </div>
                </div>

                <!-- Subtle Backgrounds -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Subtle Backgrounds</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Light/pastel background variants using <code>.so-bg-{color}-subtle</code> classes. Great for alerts and highlighted sections.</p>

                        <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-3 so-mb-4">
                            <div class="so-bg-primary-subtle so-text-primary so-p-3 so-rounded so-text-center">Primary Subtle</div>
                            <div class="so-bg-success-subtle so-text-success so-p-3 so-rounded so-text-center">Success Subtle</div>
                            <div class="so-bg-warning-subtle so-text-warning so-p-3 so-rounded so-text-center">Warning Subtle</div>
                            <div class="so-bg-info-subtle so-text-info so-p-3 so-rounded so-text-center">Info Subtle</div>
                            <div class="so-bg-danger-subtle so-text-danger so-p-3 so-rounded so-text-center">Danger Subtle</div>
                            <div class="so-bg-secondary-subtle so-text-secondary so-p-3 so-rounded so-text-center">Secondary Subtle</div>
                            <div class="so-bg-dark-subtle so-text-white so-p-3 so-rounded so-text-center">Dark Subtle</div>
                            <div class="so-bg-light-subtle so-text-dark so-p-3 so-rounded so-text-center" style="border: 1px solid var(--so-border-color)">Light Subtle</div>
                        </div>

                        <?= so_code_block('<div class="so-bg-primary-subtle so-text-primary">Primary Subtle</div>
<div class="so-bg-success-subtle so-text-success">Success Subtle</div>
<div class="so-bg-warning-subtle so-text-warning">Warning Subtle</div>
<div class="so-bg-info-subtle so-text-info">Info Subtle</div>
<div class="so-bg-danger-subtle so-text-danger">Danger Subtle</div>
<div class="so-bg-secondary-subtle so-text-secondary">Secondary Subtle</div>
<div class="so-bg-dark-subtle so-text-white">Dark Subtle</div>
<div class="so-bg-light-subtle so-text-dark">Light Subtle</div>', 'html') ?>
                    </div>
                </div>

                <!-- Background Opacity -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Background Opacity</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Control background transparency using <code>.so-bg-opacity-{value}</code> modifiers. Available values: 10, 25, 50, 75, 100.</p>

                        <h4 class="so-demo-section-heading-spaced">Primary with Opacity</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <div class="so-bg-primary so-bg-opacity-100 so-text-white so-p-3 so-rounded">100%</div>
                            <div class="so-bg-primary so-bg-opacity-75 so-text-white so-p-3 so-rounded">75%</div>
                            <div class="so-bg-primary so-bg-opacity-50 so-p-3 so-rounded">50%</div>
                            <div class="so-bg-primary so-bg-opacity-25 so-p-3 so-rounded">25%</div>
                            <div class="so-bg-primary so-bg-opacity-10 so-p-3 so-rounded">10%</div>
                        </div>

                        <h4 class="so-demo-section-heading-spaced">All Colors at 50% Opacity</h4>
                        <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-3 so-mb-4">
                            <div class="so-bg-primary so-bg-opacity-50 so-p-3 so-rounded so-text-center">Primary 50%</div>
                            <div class="so-bg-success so-bg-opacity-50 so-p-3 so-rounded so-text-center">Success 50%</div>
                            <div class="so-bg-warning so-bg-opacity-50 so-p-3 so-rounded so-text-center">Warning 50%</div>
                            <div class="so-bg-info so-bg-opacity-50 so-p-3 so-rounded so-text-center">Info 50%</div>
                            <div class="so-bg-danger so-bg-opacity-50 so-p-3 so-rounded so-text-center">Danger 50%</div>
                            <div class="so-bg-secondary so-bg-opacity-50 so-p-3 so-rounded so-text-center">Secondary 50%</div>
                            <div class="so-bg-dark so-bg-opacity-50 so-p-3 so-rounded so-text-center">Dark 50%</div>
                            <div class="so-bg-light so-bg-opacity-50 so-p-3 so-rounded so-text-center">Light 50%</div>
                        </div>

                        <?= so_code_block('<div class="so-bg-primary so-bg-opacity-100">100%</div>
<div class="so-bg-primary so-bg-opacity-75">75%</div>
<div class="so-bg-primary so-bg-opacity-50">50%</div>
<div class="so-bg-primary so-bg-opacity-25">25%</div>
<div class="so-bg-primary so-bg-opacity-10">10%</div>', 'html') ?>
                    </div>
                </div>

                <!-- Text Opacity -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Text Opacity</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Control text transparency using <code>.so-text-opacity-{value}</code> modifiers. Available values: 25, 50, 75, 100.</p>

                        <h4 class="so-demo-section-heading-spaced">Primary Text with Opacity</h4>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <span class="so-text-primary so-text-opacity-100 so-fw-bold so-text-lg">100%</span>
                            <span class="so-text-primary so-text-opacity-75 so-fw-bold so-text-lg">75%</span>
                            <span class="so-text-primary so-text-opacity-50 so-fw-bold so-text-lg">50%</span>
                            <span class="so-text-primary so-text-opacity-25 so-fw-bold so-text-lg">25%</span>
                        </div>

                        <h4 class="so-demo-section-heading-spaced">All Colors at 75% Opacity</h4>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <span class="so-text-primary so-text-opacity-75 so-fw-medium">Primary</span>
                            <span class="so-text-success so-text-opacity-75 so-fw-medium">Success</span>
                            <span class="so-text-warning so-text-opacity-75 so-fw-medium">Warning</span>
                            <span class="so-text-info so-text-opacity-75 so-fw-medium">Info</span>
                            <span class="so-text-danger so-text-opacity-75 so-fw-medium">Danger</span>
                            <span class="so-text-secondary so-text-opacity-75 so-fw-medium">Secondary</span>
                            <span class="so-text-dark so-text-opacity-75 so-fw-medium">Dark</span>
                            <span class="so-text-light so-text-opacity-75 so-bg-dark so-p-2 so-rounded so-fw-medium">Light</span>
                        </div>

                        <?= so_code_block('<span class="so-text-primary so-text-opacity-100">100%</span>
<span class="so-text-primary so-text-opacity-75">75%</span>
<span class="so-text-primary so-text-opacity-50">50%</span>
<span class="so-text-primary so-text-opacity-25">25%</span>', 'html') ?>
                    </div>
                </div>

                <!-- Link Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Link Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Style links with contextual colors using <code>.so-link-{color}</code> classes. Includes hover states.</p>

                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <a href="#" class="so-link-primary" onclick="return false;">Primary Link</a>
                            <a href="#" class="so-link-success" onclick="return false;">Success Link</a>
                            <a href="#" class="so-link-warning" onclick="return false;">Warning Link</a>
                            <a href="#" class="so-link-info" onclick="return false;">Info Link</a>
                            <a href="#" class="so-link-danger" onclick="return false;">Danger Link</a>
                            <a href="#" class="so-link-secondary" onclick="return false;">Secondary Link</a>
                            <a href="#" class="so-link-dark" onclick="return false;">Dark Link</a>
                            <span class="so-bg-dark so-p-2 so-rounded">
                                <a href="#" class="so-link-light" onclick="return false;">Light Link</a>
                            </span>
                        </div>

                        <?= so_code_block('<a href="#" class="so-link-primary">Primary Link</a>
<a href="#" class="so-link-success">Success Link</a>
<a href="#" class="so-link-warning">Warning Link</a>
<a href="#" class="so-link-info">Info Link</a>
<a href="#" class="so-link-danger">Danger Link</a>
<a href="#" class="so-link-secondary">Secondary Link</a>
<a href="#" class="so-link-dark">Dark Link</a>
<a href="#" class="so-link-light">Light Link</a>', 'html') ?>
                    </div>
                </div>

                <!-- Focus Rings -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Focus Rings</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add colored focus rings to focusable elements using <code>.so-focus-ring-{color}</code> classes. Click or tab to see the focus state.</p>

                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline so-focus-ring-primary">Primary Focus</button>
                            <button class="so-btn so-btn-outline so-focus-ring-success">Success Focus</button>
                            <button class="so-btn so-btn-outline so-focus-ring-warning">Warning Focus</button>
                            <button class="so-btn so-btn-outline so-focus-ring-info">Info Focus</button>
                            <button class="so-btn so-btn-outline so-focus-ring-danger">Danger Focus</button>
                            <button class="so-btn so-btn-outline so-focus-ring-secondary">Secondary Focus</button>
                            <button class="so-btn so-btn-outline so-focus-ring-dark">Dark Focus</button>
                            <button class="so-btn so-btn-outline so-focus-ring-light">Light Focus</button>
                        </div>

                        <?= so_code_block('<button class="so-btn so-focus-ring-primary">Primary Focus</button>
<button class="so-btn so-focus-ring-success">Success Focus</button>
<button class="so-btn so-focus-ring-warning">Warning Focus</button>
<button class="so-btn so-focus-ring-info">Info Focus</button>
<button class="so-btn so-focus-ring-danger">Danger Focus</button>
<button class="so-btn so-focus-ring-secondary">Secondary Focus</button>
<button class="so-btn so-focus-ring-dark">Dark Focus</button>
<button class="so-btn so-focus-ring-light">Light Focus</button>', 'html') ?>
                    </div>
                </div>

                <!-- Gradients -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Gradients</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Apply gradient backgrounds using <code>.so-bg-gradient-{color}</code> classes.</p>

                        <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-3 so-mb-4">
                            <div class="so-bg-gradient-primary so-text-white so-p-4 so-rounded so-text-center">Primary Gradient</div>
                            <div class="so-bg-gradient-success so-text-white so-p-4 so-rounded so-text-center">Success Gradient</div>
                            <div class="so-bg-gradient-warning so-text-dark so-p-4 so-rounded so-text-center">Warning Gradient</div>
                            <div class="so-bg-gradient-info so-text-white so-p-4 so-rounded so-text-center">Info Gradient</div>
                            <div class="so-bg-gradient-danger so-text-white so-p-4 so-rounded so-text-center">Danger Gradient</div>
                            <div class="so-bg-gradient-secondary so-text-white so-p-4 so-rounded so-text-center">Secondary Gradient</div>
                            <div class="so-bg-gradient-dark so-text-white so-p-4 so-rounded so-text-center">Dark Gradient</div>
                            <div class="so-bg-gradient-light so-text-dark so-p-4 so-rounded so-text-center">Light Gradient</div>
                        </div>

                        <?= so_code_block('<div class="so-bg-gradient-primary so-text-white">Primary Gradient</div>
<div class="so-bg-gradient-success so-text-white">Success Gradient</div>
<div class="so-bg-gradient-warning so-text-dark">Warning Gradient</div>
<div class="so-bg-gradient-info so-text-white">Info Gradient</div>
<div class="so-bg-gradient-danger so-text-white">Danger Gradient</div>
<div class="so-bg-gradient-secondary so-text-white">Secondary Gradient</div>
<div class="so-bg-gradient-dark so-text-white">Dark Gradient</div>
<div class="so-bg-gradient-light so-text-dark">Light Gradient</div>', 'html') ?>
                    </div>
                </div>

                <!-- Combined Examples -->
                <div class="so-card">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Combined Examples</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Real-world usage combining multiple color utilities.</p>

                        <h4 class="so-demo-section-heading-spaced">Alert-style Boxes</h4>
                        <div class="so-flex so-flex-col so-gap-3 so-mb-4">
                            <div class="so-bg-primary-subtle so-text-primary so-p-3 so-rounded so-flex so-items-center so-gap-2">
                                <span class="material-icons">info</span>
                                <span>This is a primary alert message with subtle background.</span>
                            </div>
                            <div class="so-bg-success-subtle so-text-success so-p-3 so-rounded so-flex so-items-center so-gap-2">
                                <span class="material-icons">check_circle</span>
                                <span>Success! Your changes have been saved.</span>
                            </div>
                            <div class="so-bg-warning-subtle so-text-warning so-p-3 so-rounded so-flex so-items-center so-gap-2">
                                <span class="material-icons">warning</span>
                                <span>Warning! Please review before proceeding.</span>
                            </div>
                            <div class="so-bg-danger-subtle so-text-danger so-p-3 so-rounded so-flex so-items-center so-gap-2">
                                <span class="material-icons">error</span>
                                <span>Error! Something went wrong.</span>
                            </div>
                            <div class="so-bg-info-subtle so-text-info so-p-3 so-rounded so-flex so-items-center so-gap-2">
                                <span class="material-icons">lightbulb</span>
                                <span>Tip: You can use keyboard shortcuts for faster navigation.</span>
                            </div>
                            <div class="so-bg-secondary-subtle so-text-secondary so-p-3 so-rounded so-flex so-items-center so-gap-2">
                                <span class="material-icons">chat</span>
                                <span>Note: This is a secondary message.</span>
                            </div>
                            <div class="so-bg-dark-subtle so-text-white so-p-3 so-rounded so-flex so-items-center so-gap-2">
                                <span class="material-icons">dark_mode</span>
                                <span>Dark mode notification style.</span>
                            </div>
                            <div class="so-bg-light-subtle so-text-dark so-p-3 so-rounded so-flex so-items-center so-gap-2" style="border: 1px solid var(--so-border-color)">
                                <span class="material-icons">light_mode</span>
                                <span>Light notification style.</span>
                            </div>
                        </div>

                        <h4 class="so-demo-section-heading-spaced">Status Indicators</h4>
                        <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                            <div class="so-flex so-items-center so-gap-2">
                                <span class="so-bg-success so-rounded" style="width: 10px; height: 10px; display: inline-block;"></span>
                                <span>Online</span>
                            </div>
                            <div class="so-flex so-items-center so-gap-2">
                                <span class="so-bg-warning so-rounded" style="width: 10px; height: 10px; display: inline-block;"></span>
                                <span>Away</span>
                            </div>
                            <div class="so-flex so-items-center so-gap-2">
                                <span class="so-bg-danger so-rounded" style="width: 10px; height: 10px; display: inline-block;"></span>
                                <span>Busy</span>
                            </div>
                            <div class="so-flex so-items-center so-gap-2">
                                <span class="so-bg-secondary so-rounded" style="width: 10px; height: 10px; display: inline-block;"></span>
                                <span>Offline</span>
                            </div>
                        </div>

                        <h4 class="so-demo-section-heading-spaced">Inline Badges with Colors</h4>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <span class="so-bg-primary so-text-white so-px-2 so-py-1 so-rounded so-text-sm">Primary</span>
                            <span class="so-bg-success so-text-white so-px-2 so-py-1 so-rounded so-text-sm">Success</span>
                            <span class="so-bg-warning so-text-dark so-px-2 so-py-1 so-rounded so-text-sm">Warning</span>
                            <span class="so-bg-info so-text-white so-px-2 so-py-1 so-rounded so-text-sm">Info</span>
                            <span class="so-bg-danger so-text-white so-px-2 so-py-1 so-rounded so-text-sm">Danger</span>
                            <span class="so-bg-secondary so-text-white so-px-2 so-py-1 so-rounded so-text-sm">Secondary</span>
                            <span class="so-bg-dark so-text-white so-px-2 so-py-1 so-rounded so-text-sm">Dark</span>
                            <span class="so-bg-light so-text-dark so-px-2 so-py-1 so-rounded so-text-sm" style="border: 1px solid var(--so-border-color)">Light</span>
                        </div>

                        <h4 class="so-demo-section-heading-spaced">Cards with Colored Headers</h4>
                        <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-3">
                            <div class="so-card so-card-bordered">
                                <div class="so-bg-primary so-text-white so-p-3" style="border-radius: 7px 7px 0 0;">
                                    <strong>Primary</strong>
                                </div>
                                <div class="so-p-3">Card content here.</div>
                            </div>
                            <div class="so-card so-card-bordered">
                                <div class="so-bg-success so-text-white so-p-3" style="border-radius: 7px 7px 0 0;">
                                    <strong>Success</strong>
                                </div>
                                <div class="so-p-3">Card content here.</div>
                            </div>
                            <div class="so-card so-card-bordered">
                                <div class="so-bg-danger so-text-white so-p-3" style="border-radius: 7px 7px 0 0;">
                                    <strong>Danger</strong>
                                </div>
                                <div class="so-p-3">Card content here.</div>
                            </div>
                            <div class="so-card so-card-bordered">
                                <div class="so-bg-gradient-info so-text-white so-p-3" style="border-radius: 7px 7px 0 0;">
                                    <strong>Gradient</strong>
                                </div>
                                <div class="so-p-3">Card with gradient header.</div>
                            </div>
                        </div>

                        <?= so_code_block('<!-- Alert box -->
<div class="so-bg-success-subtle so-text-success so-p-3 so-rounded so-flex so-items-center so-gap-2">
    <span class="material-icons">check_circle</span>
    <span>Success! Your changes have been saved.</span>
</div>

<!-- Status indicator -->
<div class="so-flex so-items-center so-gap-2">
    <span class="so-bg-success so-rounded" style="width: 10px; height: 10px;"></span>
    <span>Online</span>
</div>

<!-- Inline badge -->
<span class="so-bg-primary so-text-white so-px-2 so-py-1 so-rounded so-text-sm">Badge</span>

<!-- Card with colored header -->
<div class="so-card so-card-bordered">
    <div class="so-bg-primary so-text-white so-p-3" style="border-radius: 7px 7px 0 0;">
        <strong>Title</strong>
    </div>
    <div class="so-p-3">Content</div>
</div>', 'html') ?>
                    </div>
                </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
