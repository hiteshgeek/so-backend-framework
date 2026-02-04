<?php
/**
 * SixOrbit UI Demo - Grid System
 */
$pageTitle = 'Grid System';
$pageDescription = 'SixOrbit UI Grid System - 12-column responsive layout';

require_once 'includes/config.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
require_once 'includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Grid System</h1>
            <p class="so-page-subtitle">Powerful 12-column responsive grid with flexbox and CSS Grid options</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <!-- Vertical Tabs Container -->
        <div class="so-tabs-container so-tabs-container-vertical">
            <!-- Tabbed Navigation (Vertical Left) -->
            <div class="so-tabs so-tabs-vertical so-tabs-pills so-tabs-sticky" role="tablist" data-so-tabs>
                <button class="so-tab so-active" role="tab" aria-selected="true" data-so-target="#pane-breakpoints">
                    <span class="material-icons">devices</span>
                    Breakpoints
                </button>
                <button class="so-tab" role="tab" aria-selected="false" data-so-target="#pane-containers">
                    <span class="material-icons">crop_free</span>
                    Containers
                </button>
                <button class="so-tab" role="tab" aria-selected="false" data-so-target="#pane-grid">
                    <span class="material-icons">grid_view</span>
                    Grid
                </button>
                <button class="so-tab" role="tab" aria-selected="false" data-so-target="#pane-columns">
                    <span class="material-icons">view_column</span>
                    Columns
                </button>
                <button class="so-tab" role="tab" aria-selected="false" data-so-target="#pane-gutters">
                    <span class="material-icons">space_bar</span>
                    Gutters
                </button>
                <button class="so-tab" role="tab" aria-selected="false" data-so-target="#pane-utilities">
                    <span class="material-icons">tune</span>
                    Utilities
                </button>
                <button class="so-tab" role="tab" aria-selected="false" data-so-target="#pane-css-grid">
                    <span class="material-icons">grid_on</span>
                    CSS Grid
                </button>
                <button class="so-tab" role="tab" aria-selected="false" data-so-target="#pane-layouts">
                    <span class="material-icons">dashboard</span>
                    Layouts
                </button>
                <button class="so-tab" role="tab" aria-selected="false" data-so-target="#pane-z-index">
                    <span class="material-icons">layers</span>
                    Z-index
                </button>
            </div>

            <!-- Tab Content -->
            <div class="so-tab-content">
                <?php include 'includes/grid/breakpoints.php'; ?>
                <?php include 'includes/grid/containers.php'; ?>
                <?php include 'includes/grid/grid.php'; ?>
                <?php include 'includes/grid/columns.php'; ?>
                <?php include 'includes/grid/gutters.php'; ?>
                <?php include 'includes/grid/utilities.php'; ?>
                <?php include 'includes/grid/css-grid.php'; ?>
                <?php include 'includes/grid/layouts.php'; ?>
                <?php include 'includes/grid/z-index.php'; ?>
            </div>
        </div>
    </div>
</main>

<?php
require_once 'includes/footer.php';
?>
