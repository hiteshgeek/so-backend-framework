<?php
/**
 * SixOrbit UI Engine - Pagination Element Demo
 *
 * Comprehensive demonstration of the Pagination element with:
 * - Basic usage examples
 * - UiEngine PHP and JavaScript API
 * - Complete API reference
 * - Interactive demos
 * - Configuration passing
 */

$pageTitle = 'Pagination - UI Engine';
$pageDescription = 'Page navigation component with customizable appearance and interactive controls';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Pagination</h1>
            <p class="so-page-subtitle">Page navigation component with customizable appearance, multiple styles, interactive controls, and comprehensive JavaScript API for dynamic pagination.</p>
        </div>
    </div>

    <div class="so-page-body">

        <!-- Quick Links -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Quick Navigation</h3>
            </div>
            <div class="so-card-body">
                <div class="so-d-flex so-flex-wrap so-gap-2">
                    <a href="#basic" class="so-btn so-btn-sm so-btn-outline-primary">Basic Pagination</a>
                    <a href="#first-last" class="so-btn so-btn-sm so-btn-outline-primary">First/Last Buttons</a>
                    <a href="#sizes" class="so-btn so-btn-sm so-btn-outline-primary">Sizes</a>
                    <a href="#styles" class="so-btn so-btn-sm so-btn-outline-primary">Style Variants</a>
                    <a href="#colors" class="so-btn so-btn-sm so-btn-outline-primary">Colors</a>
                    <a href="#alignment" class="so-btn so-btn-sm so-btn-outline-primary">Alignment</a>
                    <a href="#page-info" class="so-btn so-btn-sm so-btn-outline-primary">Page Info</a>
                    <a href="#per-page" class="so-btn so-btn-sm so-btn-outline-primary">Per-Page Selector</a>
                    <a href="#jump" class="so-btn so-btn-sm so-btn-outline-primary">Jump to Page</a>
                    <a href="#interactive" class="so-btn so-btn-sm so-btn-outline-primary">Interactive Demo</a>
                    <a href="#api-reference" class="so-btn so-btn-sm so-btn-outline-primary">API Reference</a>
                    <a href="#config-passing" class="so-btn so-btn-sm so-btn-outline-primary">Config Passing</a>
                </div>
            </div>
        </div>

        <!-- Basic Pagination -->
        <div class="so-card so-mb-4" id="basic">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Pagination Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Simple pagination with page numbers and prev/next buttons using Material Icons.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <nav class="so-pagination">
                        <ul class="so-pagination-nav">
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
                            </li>
                            <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                            <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">3</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">4</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">5</a></li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-pagination', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "use Core\\UiEngine\\UiEngine;

\$pagination = UiEngine::pagination()
    ->fromTotal(150, 10)    // Total items, items per page
    ->currentPage(3)
    ->baseUrl('?page=');

echo \$pagination;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const pagination = UiEngine.pagination()
    .fromTotal(150, 10)
    .currentPage(3)
    .baseUrl('?page=');

document.body.insertAdjacentHTML('beforeend', pagination.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav class="so-pagination" aria-label="Page navigation">
    <ul class="so-pagination-nav">
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
        </li>
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">3</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">4</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">5</a></li>
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
        </li>
    </ul>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With First/Last Buttons -->
        <div class="so-card so-mb-4" id="first-last">
            <div class="so-card-header">
                <h3 class="so-card-title">With First & Last Buttons Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add first and last page buttons with ellipsis for large page ranges.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <nav class="so-pagination">
                        <ul class="so-pagination-nav">
                            <li class="so-page-item">
                                <a class="so-page-link" href="#" aria-label="First">
                                    <span class="material-icons">first_page</span>
                                </a>
                            </li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#" aria-label="Previous">
                                    <span class="material-icons">chevron_left</span>
                                </a>
                            </li>
                            <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                            <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">3</a></li>
                            <li class="so-page-ellipsis">...</li>
                            <li class="so-page-item"><a class="so-page-link" href="#">20</a></li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#" aria-label="Next">
                                    <span class="material-icons">chevron_right</span>
                                </a>
                            </li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#" aria-label="Last">
                                    <span class="material-icons">last_page</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-first-last', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$pagination = UiEngine::pagination()
    ->fromTotal(200, 10)
    ->currentPage(3)
    ->showFirstLast()       // Show first/last buttons
    ->maxVisible(5);        // Max visible page numbers

echo \$pagination;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const pagination = UiEngine.pagination()
    .fromTotal(200, 10)
    .currentPage(3)
    .showFirstLast()
    .maxVisible(5);

document.body.insertAdjacentHTML('beforeend', pagination.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav class="so-pagination" aria-label="Page navigation">
    <ul class="so-pagination-nav">
        <li class="so-page-item">
            <a class="so-page-link" href="#" aria-label="First">
                <span class="material-icons">first_page</span>
            </a>
        </li>
        <li class="so-page-item">
            <a class="so-page-link" href="#" aria-label="Previous">
                <span class="material-icons">chevron_left</span>
            </a>
        </li>
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">3</a></li>
        <li class="so-page-ellipsis">...</li>
        <li class="so-page-item"><a class="so-page-link" href="#">20</a></li>
        <li class="so-page-item">
            <a class="so-page-link" href="#" aria-label="Next">
                <span class="material-icons">chevron_right</span>
            </a>
        </li>
        <li class="so-page-item">
            <a class="so-page-link" href="#" aria-label="Last">
                <span class="material-icons">last_page</span>
            </a>
        </li>
    </ul>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Pagination Sizes -->
        <div class="so-card so-mb-4" id="sizes">
            <div class="so-card-header">
                <h3 class="so-card-title">Pagination Sizes Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Available sizes: small, default, and large.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Small</p>
                        <nav class="so-pagination so-pagination-sm">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Default</p>
                        <nav class="so-pagination">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div>
                        <p class="so-text-muted so-mb-2">Large</p>
                        <nav class="so-pagination so-pagination-lg">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small
\$small = UiEngine::pagination()
    ->totalPages(10)
    ->small();   // or ->size('sm')

// Default (no size method needed)
\$default = UiEngine::pagination()->totalPages(10);

// Large
\$large = UiEngine::pagination()
    ->totalPages(10)
    ->large();   // or ->size('lg')"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small
const small = UiEngine.pagination()
    .totalPages(10)
    .small();   // or .size('sm')

// Default
const defaultPagination = UiEngine.pagination().totalPages(10);

// Large
const large = UiEngine.pagination()
    .totalPages(10)
    .large();   // or .size('lg')"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small -->
<nav class="so-pagination so-pagination-sm">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Default -->
<nav class="so-pagination">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Large -->
<nav class="so-pagination so-pagination-lg">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Style Variants -->
        <div class="so-card so-mb-4" id="styles">
            <div class="so-card-header">
                <h3 class="so-card-title">Style Variants Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Different visual styles: default (bordered), rounded, outlined, and minimal.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Default (Bordered)</p>
                        <nav class="so-pagination">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Rounded (Pill)</p>
                        <nav class="so-pagination so-pagination-rounded">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Outlined</p>
                        <nav class="so-pagination so-pagination-outlined">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div>
                        <p class="so-text-muted so-mb-2">Minimal (No Borders)</p>
                        <nav class="so-pagination so-pagination-minimal">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-styles', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Rounded
\$rounded = UiEngine::pagination()
    ->totalPages(10)
    ->rounded();  // or ->variant('rounded')

// Outlined
\$outlined = UiEngine::pagination()
    ->totalPages(10)
    ->outlined();  // or ->variant('outlined')

// Minimal
\$minimal = UiEngine::pagination()
    ->totalPages(10)
    ->minimal();  // or ->variant('minimal')"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Rounded
const rounded = UiEngine.pagination()
    .totalPages(10)
    .rounded();  // or .variant('rounded')

// Outlined
const outlined = UiEngine.pagination()
    .totalPages(10)
    .outlined();  // or .variant('outlined')

// Minimal
const minimal = UiEngine.pagination()
    .totalPages(10)
    .minimal();  // or .variant('minimal')"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Default (Bordered) -->
<nav class="so-pagination">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Rounded -->
<nav class="so-pagination so-pagination-rounded">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Outlined -->
<nav class="so-pagination so-pagination-outlined">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Minimal -->
<nav class="so-pagination so-pagination-minimal">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card so-mb-4" id="colors">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Different color schemes for pagination.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Primary</p>
                        <nav class="so-pagination so-pagination-primary">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Success</p>
                        <nav class="so-pagination so-pagination-success">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Danger</p>
                        <nav class="so-pagination so-pagination-danger">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Light Primary</p>
                        <nav class="so-pagination so-pagination-light-primary">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Primary
\$primary = UiEngine::pagination()
    ->totalPages(10)
    ->primary();  // or ->color('primary')

// Success
\$success = UiEngine::pagination()
    ->totalPages(10)
    ->success();  // or ->color('success')

// Danger
\$danger = UiEngine::pagination()
    ->totalPages(10)
    ->danger();  // or ->color('danger')

// Light variants
\$lightPrimary = UiEngine::pagination()
    ->totalPages(10)
    ->color('light-primary');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Primary
const primary = UiEngine.pagination()
    .totalPages(10)
    .primary();  // or .color('primary')

// Success
const success = UiEngine.pagination()
    .totalPages(10)
    .success();  // or .color('success')

// Danger
const danger = UiEngine.pagination()
    .totalPages(10)
    .danger();  // or .color('danger')

// Light variants
const lightPrimary = UiEngine.pagination()
    .totalPages(10)
    .color('light-primary');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Primary -->
<nav class="so-pagination so-pagination-primary">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Success -->
<nav class="so-pagination so-pagination-success">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Danger -->
<nav class="so-pagination so-pagination-danger">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Light Primary -->
<nav class="so-pagination so-pagination-light-primary">
    <ul class="so-pagination-nav">
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Alignment -->
        <div class="so-card so-mb-4" id="alignment">
            <div class="so-card-header">
                <h3 class="so-card-title">Alignment Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Align pagination: start (default), center, end, or between.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Start (Default)</p>
                        <nav class="so-pagination">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">1</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="so-mb-3">
                        <p class="so-text-muted so-mb-2">Center</p>
                        <nav class="so-pagination so-pagination-center">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">1</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div>
                        <p class="so-text-muted so-mb-2">End</p>
                        <nav class="so-pagination so-pagination-end">
                            <ul class="so-pagination-nav">
                                <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">1</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-alignment', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Center
\$center = UiEngine::pagination()
    ->totalPages(10)
    ->center();  // or ->alignment('center')

// End
\$end = UiEngine::pagination()
    ->totalPages(10)
    ->end();  // or ->alignment('end')"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Center
const center = UiEngine.pagination()
    .totalPages(10)
    .center();  // or .alignment('center')

// End
const endAlign = UiEngine.pagination()
    .totalPages(10)
    .end();  // or .alignment('end')"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Start (Default) -->
<nav class="so-pagination">
    <ul class="so-pagination-nav">
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">1</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- Center -->
<nav class="so-pagination so-pagination-center">
    <ul class="so-pagination-nav">
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">1</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>

<!-- End -->
<nav class="so-pagination so-pagination-end">
    <ul class="so-pagination-nav">
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">1</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
    </ul>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Page Info -->
        <div class="so-card so-mb-4" id="page-info">
            <div class="so-card-header">
                <h3 class="so-card-title">With Page Info Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display current range and total items information.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <nav class="so-pagination so-pagination-between">
                        <span class="so-pagination-info">Showing <strong>41-50</strong> of <strong>256</strong> results</span>
                        <ul class="so-pagination-nav">
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
                            </li>
                            <li class="so-page-item"><a class="so-page-link" href="#">4</a></li>
                            <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">5</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">6</a></li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-info', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$pagination = UiEngine::pagination()
    ->fromTotal(256, 10)
    ->currentPage(5)
    ->between()             // Use 'between' layout
    ->showInfo();           // Show page info

// Custom info template
\$customInfo = UiEngine::pagination()
    ->fromTotal(256, 10)
    ->currentPage(5)
    ->between()
    ->showInfo(true, 'Items {start} to {end} of {total}');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const pagination = UiEngine.pagination()
    .fromTotal(256, 10)
    .currentPage(5)
    .between()
    .showInfo();

// Custom info template
const customInfo = UiEngine.pagination()
    .fromTotal(256, 10)
    .currentPage(5)
    .between()
    .showInfo(true, 'Items {start} to {end} of {total}');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav class="so-pagination so-pagination-between" aria-label="Page navigation">
    <span class="so-pagination-info">Showing <strong>41-50</strong> of <strong>256</strong> results</span>
    <ul class="so-pagination-nav">
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
        </li>
        <li class="so-page-item"><a class="so-page-link" href="#">4</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">5</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">6</a></li>
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
        </li>
    </ul>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Per-Page Selector -->
        <div class="so-card so-mb-4" id="per-page">
            <div class="so-card-header">
                <h3 class="so-card-title">Per-Page Selector Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Allow users to change items per page.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <nav class="so-pagination so-pagination-between">
                        <div class="so-pagination-per-page">
                            <span class="so-pagination-label">Rows per page:</span>
                            <select class="so-pagination-select">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <span class="so-pagination-info">1-10 of 256</span>
                        <ul class="so-pagination-nav">
                            <li class="so-page-item so-disabled">
                                <a class="so-page-link" href="#" aria-disabled="true" tabindex="-1">
                                    <span class="material-icons">chevron_left</span>
                                </a>
                            </li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-per-page', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$pagination = UiEngine::pagination()
    ->fromTotal(256, 10)
    ->between()
    ->showInfo()
    ->showPerPageSelector();

// Custom options
\$customOptions = UiEngine::pagination()
    ->fromTotal(256, 10)
    ->between()
    ->showInfo()
    ->showPerPageSelector(true, [5, 10, 20, 50]);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const pagination = UiEngine.pagination()
    .fromTotal(256, 10)
    .between()
    .showInfo()
    .showPerPageSelector()
    .onPerPageChange((perPage) => {
        console.log('Changed to', perPage, 'items per page');
        // Reload data with new per-page value
    });

// Custom options
const customOptions = UiEngine.pagination()
    .fromTotal(256, 10)
    .between()
    .showInfo()
    .showPerPageSelector(true, [5, 10, 20, 50]);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav class="so-pagination so-pagination-between" aria-label="Page navigation">
    <div class="so-pagination-per-page">
        <span class="so-pagination-label">Rows per page:</span>
        <select class="so-pagination-select">
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <span class="so-pagination-info">1-10 of 256</span>
    <ul class="so-pagination-nav">
        <li class="so-page-item so-disabled">
            <a class="so-page-link" href="#" aria-disabled="true" tabindex="-1">
                <span class="material-icons">chevron_left</span>
            </a>
        </li>
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
        </li>
    </ul>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Jump to Page -->
        <div class="so-card so-mb-4" id="jump">
            <div class="so-card-header">
                <h3 class="so-card-title">Jump to Page Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Allow users to jump directly to a specific page.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <nav class="so-pagination so-pagination-between">
                        <ul class="so-pagination-nav">
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">first_page</span></a>
                            </li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
                            </li>
                            <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                            <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">3</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">4</a></li>
                            <li class="so-page-item"><a class="so-page-link" href="#">5</a></li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
                            </li>
                            <li class="so-page-item">
                                <a class="so-page-link" href="#"><span class="material-icons">last_page</span></a>
                            </li>
                        </ul>
                        <div class="so-pagination-jump">
                            <span class="so-pagination-jump-label">Go to page:</span>
                            <input type="number" class="so-pagination-jump-input" min="1" max="20" value="3">
                            <button class="so-pagination-jump-btn">Go</button>
                        </div>
                    </nav>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-jump', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$pagination = UiEngine::pagination()
    ->totalPages(20)
    ->currentPage(3)
    ->between()
    ->showFirstLast()
    ->showJumpToPage();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const pagination = UiEngine.pagination()
    .totalPages(20)
    .currentPage(3)
    .between()
    .showFirstLast()
    .showJumpToPage();

document.body.insertAdjacentHTML('beforeend', pagination.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav class="so-pagination so-pagination-between" aria-label="Page navigation">
    <ul class="so-pagination-nav">
        <li class="so-page-item">
            <a class="so-page-link" href="#" aria-label="First">
                <span class="material-icons">first_page</span>
            </a>
        </li>
        <li class="so-page-item">
            <a class="so-page-link" href="#" aria-label="Previous">
                <span class="material-icons">chevron_left</span>
            </a>
        </li>
        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#" aria-current="page">3</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">4</a></li>
        <li class="so-page-item"><a class="so-page-link" href="#">5</a></li>
        <li class="so-page-item">
            <a class="so-page-link" href="#" aria-label="Next">
                <span class="material-icons">chevron_right</span>
            </a>
        </li>
        <li class="so-page-item">
            <a class="so-page-link" href="#" aria-label="Last">
                <span class="material-icons">last_page</span>
            </a>
        </li>
    </ul>
    <div class="so-pagination-jump">
        <span class="so-pagination-jump-label">Go to page:</span>
        <input type="number" class="so-pagination-jump-input" min="1" max="20" value="3">
        <button class="so-pagination-jump-btn">Go</button>
    </div>
</nav>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Interactive Pagination -->
        <div class="so-card so-mb-4" id="interactive">
            <div class="so-card-header">
                <h3 class="so-card-title">Interactive Pagination Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Fully interactive pagination with JavaScript API. Try the controls below:</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <nav class="so-pagination so-pagination-between"
                         id="interactive-pagination"
                         data-so-pagination
                         data-so-total-items="256"
                         data-so-items-per-page="10"
                         data-so-current-page="1"
                         data-so-show-page-info="true"
                         data-so-show-first-last="true">
                        <span class="so-pagination-info">Showing 1-10 of 256</span>
                        <ul class="so-pagination-nav">
                            <!-- Will be populated by JavaScript -->
                        </ul>
                    </nav>

                    <div class="so-mt-4 so-p-4 so-border so-rounded-lg" style="background: var(--so-bg-tertiary);">
                        <h4 class="so-text-sm so-font-semibold so-mb-3">Interactive Controls</h4>
                        <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-3">
                            <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="interactivePaginationFirst()">First</button>
                            <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="interactivePaginationPrev()">Prev</button>
                            <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="interactivePaginationNext()">Next</button>
                            <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="interactivePaginationLast()">Last</button>
                            <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="interactivePaginationGoTo(10)">Go to Page 10</button>
                            <button class="so-btn so-btn-sm so-btn-outline-info" onclick="interactivePaginationGetInfo()">Get Info</button>
                        </div>
                        <div id="pagination-events" class="so-text-xs so-text-muted">
                            Events will appear here...
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('pagination-interactive', [
                    [
                        'label' => 'JavaScript API',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Get pagination instance
const pagination = SOPagination.getInstance('#interactive-pagination');

// Navigation methods
pagination.goToPage(5);      // Go to specific page
pagination.nextPage();        // Go to next page
pagination.prevPage();        // Go to previous page
pagination.firstPage();       // Go to first page
pagination.lastPage();        // Go to last page

// Query methods
const current = pagination.getCurrentPage();     // Get current page
const total = pagination.getTotalPages();        // Get total pages
const range = pagination.getPageRange();         // Get { start, end, total }
const hasNext = pagination.hasNextPage();        // Check if has next
const hasPrev = pagination.hasPrevPage();        // Check if has previous

// Per-page control
pagination.setPerPage(25);                       // Change items per page

// Dynamic updates
pagination.updateSize('lg');                     // Change size
pagination.updateVariant('rounded');             // Change variant
pagination.updateColor('primary');               // Change color
pagination.updateAlignment('center');            // Change alignment

// Listen to events
const elem = document.getElementById('interactive-pagination');
elem.addEventListener('so:pagination:change', (e) => {
    console.log('Page changed:', e.detail);
    console.log('New page:', e.detail.page);
    console.log('Range:', e.detail.range);
});

elem.addEventListener('so:pagination:perpage:change', (e) => {
    console.log('Per-page changed:', e.detail);
    console.log('New per-page:', e.detail.perPage);
});"
                    ],
                    [
                        'label' => 'Programmatic Creation',
                        'language' => 'javascript',
                        'icon' => 'code',
                        'code' => "// Create pagination programmatically
const pagination = UiEngine.pagination()
    .fromTotal(256, 10)
    .currentPage(1)
    .between()
    .showInfo()
    .showFirstLast()
    .onPageChange((page, detail) => {
        console.log('Page changed to:', page);
        // Load data for new page
        loadData(page);
    })
    .onPerPageChange((perPage, detail) => {
        console.log('Per-page changed to:', perPage);
        // Reload data with new per-page
        loadData(1, perPage);
    });

// Render to DOM
document.getElementById('container').innerHTML = pagination.render();

// Later, interact with it
pagination.goToPage(5);
pagination.setPerPage(25);"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4" id="api-reference">
            <div class="so-card-header">
                <h3 class="so-card-title">Complete API Reference</h3>
            </div>
            <div class="so-card-body">
                <?= so_tabs('pagination-api-tabs', [
                    [
                        'id' => 'php-api',
                        'label' => 'PHP API',
                        'active' => true,
                        'content' => '<h5 class="so-mb-3">PHP Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 200px;">Method</th>
                                        <th style="width: 200px;">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>currentPage()</code></td>
                                        <td><code>int $page</code></td>
                                        <td>Set current page number</td>
                                    </tr>
                                    <tr>
                                        <td><code>totalPages()</code></td>
                                        <td><code>int $pages</code></td>
                                        <td>Set total number of pages</td>
                                    </tr>
                                    <tr>
                                        <td><code>fromTotal()</code></td>
                                        <td><code>int $totalItems, int $perPage</code></td>
                                        <td>Calculate pages from total items and items per page</td>
                                    </tr>
                                    <tr>
                                        <td><code>itemsPerPage()</code></td>
                                        <td><code>int $items</code></td>
                                        <td>Set items per page</td>
                                    </tr>
                                    <tr>
                                        <td><code>baseUrl()</code></td>
                                        <td><code>string $url</code></td>
                                        <td>Set base URL for page links</td>
                                    </tr>
                                    <tr>
                                        <td><code>showPrevNext()</code></td>
                                        <td><code>bool $show</code></td>
                                        <td>Show/hide previous and next buttons</td>
                                    </tr>
                                    <tr>
                                        <td><code>showFirstLast()</code></td>
                                        <td><code>bool $show</code></td>
                                        <td>Show/hide first and last buttons</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxVisible()</code></td>
                                        <td><code>int $max</code></td>
                                        <td>Set maximum visible page numbers</td>
                                    </tr>
                                    <tr>
                                        <td><code>size()</code></td>
                                        <td><code>string $size</code></td>
                                        <td>Set size: sm, lg</td>
                                    </tr>
                                    <tr>
                                        <td><code>small()</code></td>
                                        <td>-</td>
                                        <td>Set small size</td>
                                    </tr>
                                    <tr>
                                        <td><code>large()</code></td>
                                        <td>-</td>
                                        <td>Set large size</td>
                                    </tr>
                                    <tr>
                                        <td><code>variant()</code></td>
                                        <td><code>string $variant</code></td>
                                        <td>Set style variant: rounded, outlined, minimal</td>
                                    </tr>
                                    <tr>
                                        <td><code>rounded()</code></td>
                                        <td>-</td>
                                        <td>Set rounded (pill) style</td>
                                    </tr>
                                    <tr>
                                        <td><code>outlined()</code></td>
                                        <td>-</td>
                                        <td>Set outlined style</td>
                                    </tr>
                                    <tr>
                                        <td><code>minimal()</code></td>
                                        <td>-</td>
                                        <td>Set minimal style (no borders)</td>
                                    </tr>
                                    <tr>
                                        <td><code>color()</code></td>
                                        <td><code>string $color</code></td>
                                        <td>Set color: primary, success, danger, light-primary, etc</td>
                                    </tr>
                                    <tr>
                                        <td><code>primary()</code></td>
                                        <td>-</td>
                                        <td>Set primary color</td>
                                    </tr>
                                    <tr>
                                        <td><code>success()</code></td>
                                        <td>-</td>
                                        <td>Set success color</td>
                                    </tr>
                                    <tr>
                                        <td><code>danger()</code></td>
                                        <td>-</td>
                                        <td>Set danger color</td>
                                    </tr>
                                    <tr>
                                        <td><code>alignment()</code></td>
                                        <td><code>string $alignment</code></td>
                                        <td>Set alignment: start, center, end, between</td>
                                    </tr>
                                    <tr>
                                        <td><code>center()</code></td>
                                        <td>-</td>
                                        <td>Center align pagination</td>
                                    </tr>
                                    <tr>
                                        <td><code>end()</code></td>
                                        <td>-</td>
                                        <td>Right align pagination</td>
                                    </tr>
                                    <tr>
                                        <td><code>between()</code></td>
                                        <td>-</td>
                                        <td>Space between layout (for complex layouts)</td>
                                    </tr>
                                    <tr>
                                        <td><code>showInfo()</code></td>
                                        <td><code>bool $show, ?string $template</code></td>
                                        <td>Show page info text (e.g., "Showing 1-10 of 100")</td>
                                    </tr>
                                    <tr>
                                        <td><code>showPerPageSelector()</code></td>
                                        <td><code>bool $show, ?array $options</code></td>
                                        <td>Show items per page selector dropdown</td>
                                    </tr>
                                    <tr>
                                        <td><code>showJumpToPage()</code></td>
                                        <td><code>bool $show</code></td>
                                        <td>Show jump to page input and button</td>
                                    </tr>
                                    <tr>
                                        <td><code>simple()</code></td>
                                        <td><code>bool $simple</code></td>
                                        <td>Simple mode (prev/next only, no page numbers)</td>
                                    </tr>
                                    <tr>
                                        <td><code>useIcons()</code></td>
                                        <td><code>bool $use</code></td>
                                        <td>Use Material Icons for navigation buttons</td>
                                    </tr>
                                    <tr>
                                        <td><code>labels()</code></td>
                                        <td><code>array $labels</code></td>
                                        <td>Set custom labels for buttons</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>'
                    ],
                    [
                        'id' => 'js-api',
                        'label' => 'JavaScript API',
                        'content' => '<h5 class="so-mb-3">Configuration Methods</h5>
                        <div class="so-table-responsive so-mb-4">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 200px;">Method</th>
                                        <th style="width: 200px;">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>currentPage()</code></td>
                                        <td><code>page</code></td>
                                        <td>Set current page number</td>
                                    </tr>
                                    <tr>
                                        <td><code>totalPages()</code></td>
                                        <td><code>pages</code></td>
                                        <td>Set total number of pages</td>
                                    </tr>
                                    <tr>
                                        <td><code>fromTotal()</code></td>
                                        <td><code>totalItems, itemsPerPage</code></td>
                                        <td>Calculate pages from total items</td>
                                    </tr>
                                    <tr>
                                        <td><code>size()</code></td>
                                        <td><code>size</code></td>
                                        <td>Set size: sm, lg</td>
                                    </tr>
                                    <tr>
                                        <td><code>small()</code></td>
                                        <td>-</td>
                                        <td>Set small size</td>
                                    </tr>
                                    <tr>
                                        <td><code>large()</code></td>
                                        <td>-</td>
                                        <td>Set large size</td>
                                    </tr>
                                    <tr>
                                        <td><code>variant()</code></td>
                                        <td><code>variant</code></td>
                                        <td>Set style variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>color()</code></td>
                                        <td><code>color</code></td>
                                        <td>Set color scheme</td>
                                    </tr>
                                    <tr>
                                        <td><code>alignment()</code></td>
                                        <td><code>alignment</code></td>
                                        <td>Set alignment</td>
                                    </tr>
                                    <tr>
                                        <td><code>showInfo()</code></td>
                                        <td><code>show, template</code></td>
                                        <td>Show page info</td>
                                    </tr>
                                    <tr>
                                        <td><code>showPerPageSelector()</code></td>
                                        <td><code>show, options</code></td>
                                        <td>Show per-page selector</td>
                                    </tr>
                                    <tr>
                                        <td><code>showJumpToPage()</code></td>
                                        <td><code>show</code></td>
                                        <td>Show jump to page</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mb-3">Navigation Methods</h5>
                        <div class="so-table-responsive so-mb-4">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 200px;">Method</th>
                                        <th style="width: 200px;">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>goToPage()</code></td>
                                        <td><code>page</code></td>
                                        <td>Navigate to specific page</td>
                                    </tr>
                                    <tr>
                                        <td><code>nextPage()</code></td>
                                        <td>-</td>
                                        <td>Go to next page</td>
                                    </tr>
                                    <tr>
                                        <td><code>prevPage()</code></td>
                                        <td>-</td>
                                        <td>Go to previous page</td>
                                    </tr>
                                    <tr>
                                        <td><code>firstPage()</code></td>
                                        <td>-</td>
                                        <td>Go to first page</td>
                                    </tr>
                                    <tr>
                                        <td><code>lastPage()</code></td>
                                        <td>-</td>
                                        <td>Go to last page</td>
                                    </tr>
                                    <tr>
                                        <td><code>setPerPage()</code></td>
                                        <td><code>perPage</code></td>
                                        <td>Change items per page</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mb-3">Query Methods</h5>
                        <div class="so-table-responsive so-mb-4">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 200px;">Method</th>
                                        <th style="width: 200px;">Returns</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>getCurrentPage()</code></td>
                                        <td><code>number</code></td>
                                        <td>Get current page number</td>
                                    </tr>
                                    <tr>
                                        <td><code>getTotalPages()</code></td>
                                        <td><code>number</code></td>
                                        <td>Get total number of pages</td>
                                    </tr>
                                    <tr>
                                        <td><code>getItemsPerPage()</code></td>
                                        <td><code>number</code></td>
                                        <td>Get items per page</td>
                                    </tr>
                                    <tr>
                                        <td><code>getPageRange()</code></td>
                                        <td><code>{start, end, total}</code></td>
                                        <td>Get current page range information</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasNextPage()</code></td>
                                        <td><code>boolean</code></td>
                                        <td>Check if has next page</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasPrevPage()</code></td>
                                        <td><code>boolean</code></td>
                                        <td>Check if has previous page</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mb-3">Dynamic Update Methods</h5>
                        <div class="so-table-responsive so-mb-4">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 200px;">Method</th>
                                        <th style="width: 200px;">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>updateSize()</code></td>
                                        <td><code>size</code></td>
                                        <td>Update size dynamically (changes DOM)</td>
                                    </tr>
                                    <tr>
                                        <td><code>updateVariant()</code></td>
                                        <td><code>variant</code></td>
                                        <td>Update variant dynamically</td>
                                    </tr>
                                    <tr>
                                        <td><code>updateColor()</code></td>
                                        <td><code>color</code></td>
                                        <td>Update color dynamically</td>
                                    </tr>
                                    <tr>
                                        <td><code>updateAlignment()</code></td>
                                        <td><code>alignment</code></td>
                                        <td>Update alignment dynamically</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mb-3">Event Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 200px;">Method</th>
                                        <th style="width: 200px;">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>onPageChange()</code></td>
                                        <td><code>callback</code></td>
                                        <td>Set page change callback</td>
                                    </tr>
                                    <tr>
                                        <td><code>onPerPageChange()</code></td>
                                        <td><code>callback</code></td>
                                        <td>Set per-page change callback</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>'
                    ],
                    [
                        'id' => 'html-structure',
                        'label' => 'HTML Structure',
                        'content' => '<h5 class="so-mb-3">HTML Elements</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 150px;">Element</th>
                                        <th style="width: 200px;">Class</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>&lt;nav&gt;</code></td>
                                        <td><code>so-pagination</code></td>
                                        <td>Main container element</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;ul&gt;</code></td>
                                        <td><code>so-pagination-nav</code></td>
                                        <td>Navigation list container</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;li&gt;</code></td>
                                        <td><code>so-page-item</code></td>
                                        <td>Individual page item wrapper</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;a&gt;</code></td>
                                        <td><code>so-page-link</code></td>
                                        <td>Clickable page link</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;li&gt;</code></td>
                                        <td><code>so-page-ellipsis</code></td>
                                        <td>Ellipsis indicator (...)</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;span&gt;</code></td>
                                        <td><code>so-pagination-info</code></td>
                                        <td>Page information text</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;div&gt;</code></td>
                                        <td><code>so-pagination-per-page</code></td>
                                        <td>Per-page selector container</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;span&gt;</code></td>
                                        <td><code>so-pagination-label</code></td>
                                        <td>Label for per-page selector</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;select&gt;</code></td>
                                        <td><code>so-pagination-select</code></td>
                                        <td>Per-page selector dropdown</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;div&gt;</code></td>
                                        <td><code>so-pagination-jump</code></td>
                                        <td>Jump to page container</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;span&gt;</code></td>
                                        <td><code>so-pagination-jump-label</code></td>
                                        <td>Label for jump input</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;input&gt;</code></td>
                                        <td><code>so-pagination-jump-input</code></td>
                                        <td>Jump to page number input</td>
                                    </tr>
                                    <tr>
                                        <td><code>&lt;button&gt;</code></td>
                                        <td><code>so-pagination-jump-btn</code></td>
                                        <td>Jump to page button</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>'
                    ],
                    [
                        'id' => 'css-classes',
                        'label' => 'CSS Classes',
                        'content' => '<h5 class="so-mb-3">Base Classes</h5>
                        <div class="so-table-responsive so-mb-4">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 250px;">Class</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so-pagination</code></td>
                                        <td>Main pagination container class</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-nav</code></td>
                                        <td>Navigation list</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-page-item</code></td>
                                        <td>Page item wrapper</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-page-link</code></td>
                                        <td>Page link</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-page-ellipsis</code></td>
                                        <td>Ellipsis item</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-active</code></td>
                                        <td>Active/current page state</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-disabled</code></td>
                                        <td>Disabled state</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mb-3">Size Modifiers</h5>
                        <div class="so-table-responsive so-mb-4">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 250px;">Class</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so-pagination-sm</code></td>
                                        <td>Small size pagination</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-lg</code></td>
                                        <td>Large size pagination</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mb-3">Style Variants</h5>
                        <div class="so-table-responsive so-mb-4">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 250px;">Class</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so-pagination-rounded</code></td>
                                        <td>Rounded (pill) style</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-outlined</code></td>
                                        <td>Outlined style</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-minimal</code></td>
                                        <td>Minimal style (no borders)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mb-3">Color Variants</h5>
                        <div class="so-table-responsive so-mb-4">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 250px;">Class</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so-pagination-primary</code></td>
                                        <td>Primary color scheme</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-success</code></td>
                                        <td>Success color scheme</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-danger</code></td>
                                        <td>Danger color scheme</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-warning</code></td>
                                        <td>Warning color scheme</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-info</code></td>
                                        <td>Info color scheme</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-light-primary</code></td>
                                        <td>Light primary color scheme</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-light-success</code></td>
                                        <td>Light success color scheme</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-light-danger</code></td>
                                        <td>Light danger color scheme</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mb-3">Alignment Modifiers</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 250px;">Class</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so-pagination-center</code></td>
                                        <td>Center align pagination</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-end</code></td>
                                        <td>Right align pagination</td>
                                    </tr>
                                    <tr>
                                        <td><code>so-pagination-between</code></td>
                                        <td>Space between layout (for complex layouts with info/selectors)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>'
                    ],
                    [
                        'id' => 'data-attributes',
                        'label' => 'Data Attributes',
                        'content' => '<h5 class="so-mb-3">Configuration Attributes</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 250px;">Attribute</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>data-so-pagination</code></td>
                                        <td>Enable auto-initialization for this pagination element</td>
                                    </tr>
                                    <tr>
                                        <td><code>data-so-current-page</code></td>
                                        <td>Set current page number</td>
                                    </tr>
                                    <tr>
                                        <td><code>data-so-total-pages</code></td>
                                        <td>Set total number of pages</td>
                                    </tr>
                                    <tr>
                                        <td><code>data-so-total-items</code></td>
                                        <td>Set total number of items (for calculating pages)</td>
                                    </tr>
                                    <tr>
                                        <td><code>data-so-items-per-page</code></td>
                                        <td>Set items per page</td>
                                    </tr>
                                    <tr>
                                        <td><code>data-so-show-page-info</code></td>
                                        <td>Show page information text (value: "true")</td>
                                    </tr>
                                    <tr>
                                        <td><code>data-so-show-first-last</code></td>
                                        <td>Show first/last buttons (value: "true")</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <p class="so-mt-3 so-text-muted">Example:</p>
                        <pre class="so-bg-dark so-text-light so-p-3 so-rounded"><code>&lt;nav class="so-pagination"
     data-so-pagination
     data-so-total-items="256"
     data-so-items-per-page="10"
     data-so-current-page="1"
     data-so-show-page-info="true"
     data-so-show-first-last="true"&gt;
&lt;/nav&gt;</code></pre>'
                    ],
                    [
                        'id' => 'events',
                        'label' => 'Events',
                        'content' => '<h5 class="so-mb-3">Custom Events</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width: 250px;">Event Name</th>
                                        <th style="width: 150px;">Event Detail</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so:pagination:change</code></td>
                                        <td><code>{oldPage, newPage, page, totalPages, range}</code></td>
                                        <td>Fired when page changes. <code>range</code> contains {start, end, total}</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:pagination:perpage:change</code></td>
                                        <td><code>{oldPerPage, newPerPage, perPage, currentPage}</code></td>
                                        <td>Fired when items per page changes</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Event Listening</h5>
                        <pre class="so-bg-dark so-text-light so-p-3 so-rounded"><code>// Listen for page changes
const paginationElement = document.getElementById(\'my-pagination\');

paginationElement.addEventListener(\'so:pagination:change\', (e) => {
    console.log(\'Page changed:\', e.detail);
    console.log(\'New page:\', e.detail.page);
    console.log(\'Old page:\', e.detail.oldPage);
    console.log(\'Range:\', e.detail.range);

    // Load data for new page
    loadData(e.detail.page);
});

// Listen for per-page changes
paginationElement.addEventListener(\'so:pagination:perpage:change\', (e) => {
    console.log(\'Per-page changed:\', e.detail);
    console.log(\'New per-page:\', e.detail.perPage);
    console.log(\'Old per-page:\', e.detail.oldPerPage);

    // Reload data with new per-page value
    loadData(1, e.detail.perPage);
});</code></pre>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Configuration Passing -->
        <div class="so-card so-mb-4" id="config-passing">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Pass configuration from PHP to JavaScript for interactive pagination.</p>

                <h5 class="so-mb-3">Method 1: Data Attributes (Recommended)</h5>
                <p class="so-text-muted so-mb-3">PHP automatically adds data attributes that JavaScript can read:</p>

                <?= so_code_tabs('config-data-attributes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// PHP generates element with data attributes
\$pagination = UiEngine::pagination()
    ->fromTotal(256, 10)
    ->currentPage(5)
    ->showInfo()
    ->showFirstLast();

echo \$pagination;  // Outputs data-so-* attributes automatically"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<nav class="so-pagination"
     data-so-pagination
     data-so-total-items="256"
     data-so-items-per-page="10"
     data-so-current-page="5"
     data-so-total-pages="26"
     data-so-show-page-info="true"
     data-so-show-first-last="true">
    <!-- pagination content -->
</nav>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// JavaScript auto-initializes from data attributes
const pagination = SOPagination.getInstance('#my-pagination');

// Now you can interact with it
pagination.goToPage(10);
console.log(pagination.getCurrentPage());"
                    ],
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Method 2: JSON Configuration</h5>
                <p class="so-text-muted so-mb-3">Export PHP configuration to JavaScript via JSON:</p>

                <?= so_code_tabs('config-json', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$pagination = UiEngine::pagination()
    ->fromTotal(256, 10)
    ->currentPage(5)
    ->primary()
    ->rounded();

// Export configuration as JSON
\$config = \$pagination->toArray();
\$jsonConfig = json_encode(\$config);"
                    ],
                    [
                        'label' => 'PHP + JavaScript',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- In your view -->
<div id="pagination-container"></div>

<script>
const config = <?= $jsonConfig ?>;

const pagination = UiEngine.pagination(config);
document.getElementById("pagination-container").innerHTML = pagination.render();

// Add event listeners
pagination.onPageChange((page) => {
    loadData(page);
});
</script>'
                    ],
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Method 3: Direct Rendering with Interactive Features</h5>
                <?= so_code_tabs('config-direct', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Render in PHP
\$pagination = UiEngine::pagination()
    ->id('my-pagination')
    ->fromTotal(256, 10)
    ->currentPage(5);

echo \$pagination;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Later, get instance and add interactivity
const pagination = SOPagination.getInstance('#my-pagination');

// Add event listeners
document.getElementById('my-pagination')
    .addEventListener('so:pagination:change', (e) => {
        // Handle page change
        loadData(e.detail.page);
    });"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Usage Notes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Usage Notes</h3>
            </div>
            <div class="so-card-body">
                <h5 class="so-mb-3">Structure Requirements</h5>
                <ul class="so-mb-4">
                    <li>Main container must be <code>&lt;nav&gt;</code> with class <code>so-pagination</code></li>
                    <li>Navigation list must be <code>&lt;ul&gt;</code> with class <code>so-pagination-nav</code></li>
                    <li>Each page item must be <code>&lt;li&gt;</code> with class <code>so-page-item</code></li>
                    <li>Links must be <code>&lt;a&gt;</code> with class <code>so-page-link</code></li>
                    <li>Active page gets <code>so-active</code> class</li>
                    <li>Disabled items get <code>so-disabled</code> class</li>
                    <li>Ellipsis uses <code>&lt;li class="so-page-ellipsis"&gt;...&lt;/li&gt;</code></li>
                </ul>

                <h5 class="so-mb-3">Accessibility</h5>
                <ul class="so-mb-4">
                    <li>Use <code>aria-label="Page navigation"</code> on the <code>&lt;nav&gt;</code> element</li>
                    <li>Active page link should have <code>aria-current="page"</code></li>
                    <li>Disabled links should have <code>aria-disabled="true"</code> and <code>tabindex="-1"</code></li>
                    <li>Navigation buttons should have descriptive <code>aria-label</code> attributes</li>
                </ul>

                <h5 class="so-mb-3">Best Practices</h5>
                <ul class="so-mb-4">
                    <li>Use <code>fromTotal()</code> instead of manually calculating <code>totalPages</code></li>
                    <li>Always set a sensible <code>maxVisible</code> value (default is 5)</li>
                    <li>Use Material Icons for navigation buttons for better UX</li>
                    <li>Show first/last buttons for large page ranges</li>
                    <li>Use <code>between</code> alignment when combining multiple pagination features</li>
                    <li>Provide page info to help users understand their current position</li>
                    <li>Allow per-page selection for better user control</li>
                    <li>Listen to <code>so:pagination:change</code> event for AJAX page loading</li>
                </ul>

                <h5 class="so-mb-3">Performance Tips</h5>
                <ul>
                    <li>Use event delegation for page link clicks to avoid attaching too many listeners</li>
                    <li>Debounce per-page selector changes if loading data immediately</li>
                    <li>Cache pagination instances using <code>getInstance()</code> instead of creating new ones</li>
                    <li>For large datasets, consider server-side pagination with AJAX updates</li>
                </ul>
            </div>
        </div>

    </div>
</main>

<script>
// Interactive pagination demo functions
function interactivePaginationFirst() {
    const pagination = SOPagination.getInstance(document.getElementById('interactive-pagination'));
    if (pagination) {
        pagination.firstPage();
        logPaginationEvent('First button clicked');
    }
}

function interactivePaginationPrev() {
    const pagination = SOPagination.getInstance(document.getElementById('interactive-pagination'));
    if (pagination) {
        pagination.prevPage();
        logPaginationEvent('Previous button clicked');
    }
}

function interactivePaginationNext() {
    const pagination = SOPagination.getInstance(document.getElementById('interactive-pagination'));
    if (pagination) {
        pagination.nextPage();
        logPaginationEvent('Next button clicked');
    }
}

function interactivePaginationLast() {
    const pagination = SOPagination.getInstance(document.getElementById('interactive-pagination'));
    if (pagination) {
        pagination.lastPage();
        logPaginationEvent('Last button clicked');
    }
}

function interactivePaginationGoTo(page) {
    const pagination = SOPagination.getInstance(document.getElementById('interactive-pagination'));
    if (pagination) {
        pagination.goToPage(page);
        logPaginationEvent(`Jumped to page ${page}`);
    }
}

function interactivePaginationGetInfo() {
    const pagination = SOPagination.getInstance(document.getElementById('interactive-pagination'));
    if (pagination) {
        const range = pagination.getPageRange();
        const info = `Current Page: ${pagination.getCurrentPage()}\n` +
                    `Total Pages: ${pagination.getTotalPages()}\n` +
                    `Showing: ${range.start}-${range.end} of ${range.total}`;
        alert(info);
        logPaginationEvent('Get info clicked');
    }
}

function logPaginationEvent(message) {
    const eventLog = document.getElementById('pagination-events');
    const timestamp = new Date().toLocaleTimeString();
    const newLog = `[${timestamp}] ${message}\n`;
    eventLog.textContent = newLog + eventLog.textContent;
}

// Listen to pagination events
document.getElementById('interactive-pagination')?.addEventListener('so:pagination:change', (e) => {
    logPaginationEvent(`Page changed from ${e.detail.oldPage} to ${e.detail.newPage}`);
});

// Initialize interactive pagination with event rendering
document.addEventListener('DOMContentLoaded', () => {
    const interactivePagination = SOPagination.getInstance(document.getElementById('interactive-pagination'));
    if (interactivePagination) {
        logPaginationEvent('Pagination initialized');
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>
