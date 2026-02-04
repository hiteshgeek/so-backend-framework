<?php

/**
 * SixOrbit UI Demo - Breadcrumb
 */
$pageTitle = 'Breadcrumb';
$pageDescription = 'Breadcrumb navigation component';

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
            <h1 class="so-page-title">Breadcrumb</h1>
            <p class="so-page-subtitle">Breadcrumb navigation component</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <div class="so-grid so-grid-cols-1 so-gap-4">

            <!-- Basic Breadcrumb -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Basic Breadcrumb</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Simple navigation breadcrumb with default slash divider.</p>

                    <nav aria-label="breadcrumb" class="so-mb-4">
                        <ol class="so-breadcrumb">
                            <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                            <li class="so-breadcrumb-item"><a href="#">Library</a></li>
                            <li class="so-breadcrumb-item so-active" aria-current="page">Data</li>
                        </ol>
                    </nav>

                    <nav aria-label="breadcrumb">
                        <ol class="so-breadcrumb">
                            <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                            <li class="so-breadcrumb-item so-active" aria-current="page">Library</li>
                        </ol>
                    </nav>

                    <?= so_code_block('<nav aria-label="breadcrumb">
    <ol class="so-breadcrumb">
        <li class="so-breadcrumb-item"><a href="#">Home</a></li>
        <li class="so-breadcrumb-item"><a href="#">Library</a></li>
        <li class="so-breadcrumb-item so-active" aria-current="page">Data</li>
    </ol>
</nav>', 'html') ?>
                </div>
            </div>

            <!-- Divider Variants -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Divider Variants</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Different divider styles available.</p>

                    <div class="so-grid so-grid-cols-1 so-gap-4">
                        <div>
                            <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Slash (default)</label>
                            <nav aria-label="breadcrumb">
                                <ol class="so-breadcrumb">
                                    <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                                    <li class="so-breadcrumb-item so-active">Details</li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Chevron (.so-breadcrumb-chevron)</label>
                            <nav aria-label="breadcrumb">
                                <ol class="so-breadcrumb so-breadcrumb-chevron">
                                    <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                                    <li class="so-breadcrumb-item so-active">Details</li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Arrow (.so-breadcrumb-arrow)</label>
                            <nav aria-label="breadcrumb">
                                <ol class="so-breadcrumb so-breadcrumb-arrow">
                                    <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                                    <li class="so-breadcrumb-item so-active">Details</li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Pipe (.so-breadcrumb-pipe)</label>
                            <nav aria-label="breadcrumb">
                                <ol class="so-breadcrumb so-breadcrumb-pipe">
                                    <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                                    <li class="so-breadcrumb-item so-active">Details</li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Dot (.so-breadcrumb-dot)</label>
                            <nav aria-label="breadcrumb">
                                <ol class="so-breadcrumb so-breadcrumb-dot">
                                    <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                                    <li class="so-breadcrumb-item so-active">Details</li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Icon (.so-breadcrumb-icon)</label>
                            <nav aria-label="breadcrumb">
                                <ol class="so-breadcrumb so-breadcrumb-icon">
                                    <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                                    <li class="so-breadcrumb-item so-active">Details</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <?= so_code_block('<ol class="so-breadcrumb so-breadcrumb-chevron">...</ol>
<ol class="so-breadcrumb so-breadcrumb-arrow">...</ol>
<ol class="so-breadcrumb so-breadcrumb-pipe">...</ol>
<ol class="so-breadcrumb so-breadcrumb-dot">...</ol>
<ol class="so-breadcrumb so-breadcrumb-icon">...</ol>', 'html') ?>
                </div>
            </div>

            <!-- With Icons -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">With Icons</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Add Material Icons to breadcrumb items.</p>

                    <nav aria-label="breadcrumb" class="so-mb-4">
                        <ol class="so-breadcrumb so-breadcrumb-chevron">
                            <li class="so-breadcrumb-item">
                                <a href="#"><span class="material-icons">home</span> Home</a>
                            </li>
                            <li class="so-breadcrumb-item">
                                <a href="#"><span class="material-icons">folder</span> Projects</a>
                            </li>
                            <li class="so-breadcrumb-item so-active">
                                <span class="material-icons">description</span> Document
                            </li>
                        </ol>
                    </nav>

                    <nav aria-label="breadcrumb">
                        <ol class="so-breadcrumb so-breadcrumb-arrow">
                            <li class="so-breadcrumb-item">
                                <a href="#"><span class="material-icons">home</span></a>
                            </li>
                            <li class="so-breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="so-breadcrumb-item so-active">Profile</li>
                        </ol>
                    </nav>

                    <?= so_code_block('<li class="so-breadcrumb-item">
    <a href="#"><span class="material-icons">home</span> Home</a>
</li>', 'html') ?>
                </div>
            </div>

            <!-- Filled Background -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Filled Background</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Add a background with <code>.so-breadcrumb-filled</code>.</p>

                    <nav aria-label="breadcrumb">
                        <ol class="so-breadcrumb so-breadcrumb-filled so-breadcrumb-chevron">
                            <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                            <li class="so-breadcrumb-item"><a href="#">Category</a></li>
                            <li class="so-breadcrumb-item so-active">Current Page</li>
                        </ol>
                    </nav>

                    <?= so_code_block('<ol class="so-breadcrumb so-breadcrumb-filled">...</ol>', 'html') ?>
                </div>
            </div>

            <!-- Color Variants -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Color Variants</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Contextual color variants for breadcrumbs.</p>

                    <div class="so-grid so-grid-cols-1 so-gap-3">
                        <nav aria-label="breadcrumb">
                            <ol class="so-breadcrumb so-breadcrumb-primary so-breadcrumb-chevron">
                                <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                <li class="so-breadcrumb-item"><a href="#">Library</a></li>
                                <li class="so-breadcrumb-item so-active">Primary</li>
                            </ol>
                        </nav>

                        <nav aria-label="breadcrumb">
                            <ol class="so-breadcrumb so-breadcrumb-success so-breadcrumb-chevron">
                                <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                <li class="so-breadcrumb-item"><a href="#">Library</a></li>
                                <li class="so-breadcrumb-item so-active">Success</li>
                            </ol>
                        </nav>

                        <nav aria-label="breadcrumb">
                            <ol class="so-breadcrumb so-breadcrumb-danger so-breadcrumb-chevron">
                                <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                <li class="so-breadcrumb-item"><a href="#">Library</a></li>
                                <li class="so-breadcrumb-item so-active">Danger</li>
                            </ol>
                        </nav>
                    </div>

                    <?= so_code_block('<ol class="so-breadcrumb so-breadcrumb-primary">...</ol>
<ol class="so-breadcrumb so-breadcrumb-success">...</ol>
<ol class="so-breadcrumb so-breadcrumb-danger">...</ol>', 'html') ?>
                </div>
            </div>

            <!-- Pill Style -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Pill Style</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Breadcrumb items as pills with <code>.so-breadcrumb-pills</code>.</p>

                    <nav aria-label="breadcrumb">
                        <ol class="so-breadcrumb so-breadcrumb-pills">
                            <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                            <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                            <li class="so-breadcrumb-item"><a href="#">Electronics</a></li>
                            <li class="so-breadcrumb-item so-active">Smartphones</li>
                        </ol>
                    </nav>

                    <?= so_code_block('<ol class="so-breadcrumb so-breadcrumb-pills">
    <li class="so-breadcrumb-item"><a href="#">Home</a></li>
    <li class="so-breadcrumb-item"><a href="#">Products</a></li>
    <li class="so-breadcrumb-item so-active">Current</li>
</ol>', 'html') ?>
                </div>
            </div>

            <!-- Size Variants -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Size Variants</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Small and large breadcrumb sizes.</p>

                    <div class="so-mb-4">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Small (.so-breadcrumb-sm)</label>
                        <nav aria-label="breadcrumb">
                            <ol class="so-breadcrumb so-breadcrumb-sm so-breadcrumb-chevron">
                                <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                                <li class="so-breadcrumb-item so-active">Details</li>
                            </ol>
                        </nav>
                    </div>

                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Large (.so-breadcrumb-lg)</label>
                        <nav aria-label="breadcrumb">
                            <ol class="so-breadcrumb so-breadcrumb-lg so-breadcrumb-chevron">
                                <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                <li class="so-breadcrumb-item"><a href="#">Products</a></li>
                                <li class="so-breadcrumb-item so-active">Details</li>
                            </ol>
                        </nav>
                    </div>

                    <?= so_code_block('<ol class="so-breadcrumb so-breadcrumb-sm">...</ol>
<ol class="so-breadcrumb so-breadcrumb-lg">...</ol>', 'html') ?>
                </div>
            </div>

            <!-- Truncated / Collapsed -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Truncated / Collapsed</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Use <code>.so-breadcrumb-truncate</code> for long paths or <code>.so-breadcrumb-collapse</code> for responsive collapse.</p>

                    <div class="so-mb-4">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Truncate long text</label>
                        <nav aria-label="breadcrumb" style="max-width: 400px;">
                            <ol class="so-breadcrumb so-breadcrumb-truncate so-breadcrumb-chevron">
                                <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                <li class="so-breadcrumb-item"><a href="#">Very Long Category Name That Should Truncate</a></li>
                                <li class="so-breadcrumb-item so-active">Current Page With Long Name</li>
                            </ol>
                        </nav>
                    </div>

                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">With ellipsis (collapsed)</label>
                        <nav aria-label="breadcrumb">
                            <ol class="so-breadcrumb so-breadcrumb-chevron">
                                <li class="so-breadcrumb-item"><a href="#">Home</a></li>
                                <li class="so-breadcrumb-item so-breadcrumb-ellipsis"><a href="#">...</a></li>
                                <li class="so-breadcrumb-item"><a href="#">Parent</a></li>
                                <li class="so-breadcrumb-item so-active">Current</li>
                            </ol>
                        </nav>
                    </div>

                    <?= so_code_block('<!-- Truncate long text -->
<ol class="so-breadcrumb so-breadcrumb-truncate">...</ol>

<!-- With ellipsis -->
<li class="so-breadcrumb-item so-breadcrumb-ellipsis">
    <a href="#">...</a>
</li>', 'html') ?>
                </div>
            </div>

            <!-- CSS Classes Reference -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">CSS Classes Reference</h3>
                </div>
                <div class="so-card-body">
                    <div class="so-table-responsive">
                        <table class="so-table so-table-bordered">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>.so-breadcrumb</code></td>
                                    <td>Base breadcrumb container</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-item</code></td>
                                    <td>Individual breadcrumb item</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-slash</code></td>
                                    <td>Slash divider (default)</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-chevron</code></td>
                                    <td>Chevron divider</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-arrow</code></td>
                                    <td>Arrow divider</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-pipe</code></td>
                                    <td>Pipe divider</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-dot</code></td>
                                    <td>Dot divider</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-icon</code></td>
                                    <td>Material icon divider</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-filled</code></td>
                                    <td>Background and border</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-pills</code></td>
                                    <td>Pill style items</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-{color}</code></td>
                                    <td>Color variants</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-sm / .so-breadcrumb-lg</code></td>
                                    <td>Size variants</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-truncate</code></td>
                                    <td>Truncate long text</td>
                                </tr>
                                <tr>
                                    <td><code>.so-breadcrumb-ellipsis</code></td>
                                    <td>Collapsed middle items</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- UiEngine Usage Examples -->
            <div class="so-card so-mb-4">
                <div class="so-card-header">
                    <h3 class="so-card-title">UiEngine Usage Examples</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Use UiEngine classes to generate breadcrumbs programmatically in PHP or JavaScript.</p>

                    <?= so_code_tabs_multi('breadcrumb-uiengine-examples',
                        '// JavaScript - Client-side rendering
const breadcrumb = UiEngine.breadcrumb()
    .addItem("Home", "/")
    .addItem("Products", "/products")
    .addItem("Details")
    .chevronDivider()
    .filled();

breadcrumb.renderTo(document.body);

// Dynamic updates
breadcrumb.addItem("New Item", "/new");
breadcrumb.updateItem(1, { label: "Updated", url: "/updated" });
breadcrumb.removeItem(2);',
                        '// PHP - Server-side rendering
use Core\\UiEngine\\UiEngine;

$breadcrumb = UiEngine::breadcrumb()
    ->addItem("Home", "/")
    ->addItem("Products", "/products")
    ->addItem("Details")
    ->chevronDivider()
    ->filled();

echo $breadcrumb;',
                        '<nav aria-label="breadcrumb">
    <ol class="so-breadcrumb so-breadcrumb-chevron so-breadcrumb-filled">
        <li class="so-breadcrumb-item"><a href="/">Home</a></li>
        <li class="so-breadcrumb-item"><a href="/products">Products</a></li>
        <li class="so-breadcrumb-item so-active" aria-current="page">Details</li>
    </ol>
</nav>'
                    ) ?>
                </div>
            </div>

            <!-- API Reference -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">API Reference</h3>
                </div>
                <div class="so-card-body">
                    <?= so_tabs('breadcrumb-api-tabs', [
                        [
                            'id' => 'configuration-methods',
                            'label' => 'Configuration Methods',
                            'icon' => 'settings',
                            'active' => true,
                            'content' => '<div class="so-table-responsive">
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
                                            <td><code>items()</code></td>
                                            <td><code>array $items</code></td>
                                            <td>Set all breadcrumb items at once</td>
                                        </tr>
                                        <tr>
                                            <td><code>addItem()</code></td>
                                            <td><code>string $label, ?string $url, ?string $icon</code></td>
                                            <td>Add a single breadcrumb item</td>
                                        </tr>
                                        <tr>
                                            <td><code>divider()</code></td>
                                            <td><code>string $divider</code></td>
                                            <td>Set custom divider character</td>
                                        </tr>
                                        <tr>
                                            <td><code>chevronDivider()</code></td>
                                            <td>-</td>
                                            <td>Use chevron (›) divider</td>
                                        </tr>
                                        <tr>
                                            <td><code>arrowDivider()</code></td>
                                            <td>-</td>
                                            <td>Use arrow (→) divider</td>
                                        </tr>
                                        <tr>
                                            <td><code>slashDivider()</code></td>
                                            <td>-</td>
                                            <td>Use slash (/) divider</td>
                                        </tr>
                                        <tr>
                                            <td><code>pipeDivider()</code></td>
                                            <td>-</td>
                                            <td>Use pipe (|) divider</td>
                                        </tr>
                                        <tr>
                                            <td><code>dotDivider()</code></td>
                                            <td>-</td>
                                            <td>Use dot (•) divider</td>
                                        </tr>
                                        <tr>
                                            <td><code>iconDivider()</code></td>
                                            <td>-</td>
                                            <td>Use Material icon divider</td>
                                        </tr>
                                        <tr>
                                            <td><code>filled()</code></td>
                                            <td>-</td>
                                            <td>Add background and border</td>
                                        </tr>
                                        <tr>
                                            <td><code>pills()</code></td>
                                            <td>-</td>
                                            <td>Use pill style for items</td>
                                        </tr>
                                        <tr>
                                            <td><code>variant()</code></td>
                                            <td><code>string $variant</code></td>
                                            <td>Set color variant (primary, success, danger, etc.)</td>
                                        </tr>
                                        <tr>
                                            <td><code>primary()</code>, <code>success()</code>, <code>danger()</code>, etc.</td>
                                            <td>-</td>
                                            <td>Shorthand methods for color variants</td>
                                        </tr>
                                        <tr>
                                            <td><code>size()</code></td>
                                            <td><code>string $size</code></td>
                                            <td>Set size (sm or lg)</td>
                                        </tr>
                                        <tr>
                                            <td><code>small()</code></td>
                                            <td>-</td>
                                            <td>Use small size</td>
                                        </tr>
                                        <tr>
                                            <td><code>large()</code></td>
                                            <td>-</td>
                                            <td>Use large size</td>
                                        </tr>
                                        <tr>
                                            <td><code>truncate()</code></td>
                                            <td>-</td>
                                            <td>Enable text truncation for long paths</td>
                                        </tr>
                                        <tr>
                                            <td><code>collapse()</code></td>
                                            <td>-</td>
                                            <td>Enable responsive collapse on mobile</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>'
                        ],
                        [
                            'id' => 'interactivity-methods',
                            'label' => 'Interactivity Methods',
                            'icon' => 'touch_app',
                            'content' => '<p class="so-text-muted so-mb-3">JavaScript-only methods for dynamic manipulation after rendering.</p>
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
                                            <td><code>setItems()</code></td>
                                            <td><code>array items</code></td>
                                            <td>Replace all items dynamically</td>
                                        </tr>
                                        <tr>
                                            <td><code>getItems()</code></td>
                                            <td>-</td>
                                            <td>Get current items array</td>
                                        </tr>
                                        <tr>
                                            <td><code>removeItem()</code></td>
                                            <td><code>number index</code></td>
                                            <td>Remove item by index</td>
                                        </tr>
                                        <tr>
                                            <td><code>updateItem()</code></td>
                                            <td><code>number index, object item</code></td>
                                            <td>Update item properties by index</td>
                                        </tr>
                                        <tr>
                                            <td><code>clearItems()</code></td>
                                            <td>-</td>
                                            <td>Remove all items</td>
                                        </tr>
                                        <tr>
                                            <td><code>setDivider()</code></td>
                                            <td><code>string divider</code></td>
                                            <td>Change divider character dynamically</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="so-mt-4">
                                <h6>Example Usage</h6>
                                ' . so_code_block('// Create and render breadcrumb
const breadcrumb = UiEngine.breadcrumb()
    .addItem("Home", "/")
    .addItem("Products", "/products")
    .chevronDivider();

breadcrumb.renderTo(document.body);

// Dynamic updates
breadcrumb.setItems([
    { label: "Home", url: "/" },
    { label: "New Section", url: "/new" },
    { label: "Current" }
]);

// Modify individual items
breadcrumb.updateItem(1, { label: "Updated Section" });
breadcrumb.removeItem(0);

// Change divider
breadcrumb.setDivider("→");', 'javascript') . '
                            </div>'
                        ],
                        [
                            'id' => 'inherited-methods',
                            'label' => 'Inherited Methods',
                            'icon' => 'account_tree',
                            'content' => '<p class="so-text-muted so-mb-3">Breadcrumb inherits these methods from the Element base class.</p>
                            <h6 class="so-mt-3 so-mb-2">Class & Attribute Management</h6>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered so-table-sm">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th>Method</th>
                                            <th>PHP</th>
                                            <th>JS</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>addClass()</code></td>
                                            <td><code>string|array $class</code></td>
                                            <td><code>...string</code></td>
                                            <td>Add one or more CSS classes</td>
                                        </tr>
                                        <tr>
                                            <td><code>removeClass()</code></td>
                                            <td><code>string|array $class</code></td>
                                            <td><code>...string</code></td>
                                            <td>Remove one or more CSS classes</td>
                                        </tr>
                                        <tr>
                                            <td><code>id()</code></td>
                                            <td><code>string $id</code></td>
                                            <td><code>string id</code></td>
                                            <td>Set element ID</td>
                                        </tr>
                                        <tr>
                                            <td><code>setAttribute()</code></td>
                                            <td><code>string $name, $value</code></td>
                                            <td><code>string name, value</code></td>
                                            <td>Set HTML attribute</td>
                                        </tr>
                                        <tr>
                                            <td><code>setDataAttr()</code></td>
                                            <td><code>string $name, $value</code></td>
                                            <td><code>string name, value</code></td>
                                            <td>Set data-* attribute</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h6 class="so-mt-4 so-mb-2">Rendering & State (JavaScript only)</h6>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered so-table-sm">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th>Method</th>
                                            <th>Returns</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>render()</code></td>
                                            <td><code>HTMLElement</code></td>
                                            <td>Create and return DOM element</td>
                                        </tr>
                                        <tr>
                                            <td><code>toHtml()</code></td>
                                            <td><code>string</code></td>
                                            <td>Generate HTML string</td>
                                        </tr>
                                        <tr>
                                            <td><code>renderTo()</code></td>
                                            <td><code>this</code></td>
                                            <td>Render and append to parent element</td>
                                        </tr>
                                        <tr>
                                            <td><code>show()</code></td>
                                            <td><code>this</code></td>
                                            <td>Show element</td>
                                        </tr>
                                        <tr>
                                            <td><code>hide()</code></td>
                                            <td><code>this</code></td>
                                            <td>Hide element</td>
                                        </tr>
                                        <tr>
                                            <td><code>remove()</code></td>
                                            <td><code>void</code></td>
                                            <td>Remove element from DOM</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>'
                        ],
                    ]) ?>
                </div>
            </div>

        </div>
    </div>

</main>

<?php
require_once '../includes/footer.php';
?>