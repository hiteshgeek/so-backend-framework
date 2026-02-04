<?php
/**
 * SixOrbit UI Demo - Pagination
 */
$pageTitle = 'Pagination';
$pageDescription = 'Pagination component for navigation';

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
            <h1 class="so-page-title">Pagination</h1>
            <p class="so-page-subtitle">Pagination component for navigation</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Basic Pagination -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Basic Pagination</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Simple pagination with page numbers and prev/next buttons.</p>

                                <nav class="so-pagination" aria-label="Basic pagination">
                                    <ul class="so-pagination-nav">
                                        <li class="so-page-item so-disabled">
                                            <a class="so-page-link" href="#" aria-disabled="true">
                                                <span class="material-icons">chevron_left</span>
                                            </a>
                                        </li>
                                        <li class="so-page-item so-active">
                                            <a class="so-page-link" href="#" aria-current="page">1</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">2</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">3</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">4</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">5</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">
                                                <span class="material-icons">chevron_right</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>

                        <?= so_code_block('<nav class="so-pagination">
    <ul class="so-pagination-nav">
        <li class="so-page-item so-disabled">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
        </li>
        <li class="so-page-item so-active">
            <a class="so-page-link" href="#">1</a>
        </li>
        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
        </li>
    </ul>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- With First/Last Buttons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">With First & Last Buttons</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Include first and last page navigation buttons with ellipsis for large page ranges.</p>

                                <nav class="so-pagination" aria-label="Pagination with first/last">
                                    <ul class="so-pagination-nav">
                                        <li class="so-page-item so-disabled">
                                            <a class="so-page-link" href="#">
                                                <span class="material-icons">first_page</span>
                                            </a>
                                        </li>
                                        <li class="so-page-item so-disabled">
                                            <a class="so-page-link" href="#">
                                                <span class="material-icons">chevron_left</span>
                                            </a>
                                        </li>
                                        <li class="so-page-item so-active">
                                            <a class="so-page-link" href="#">1</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">2</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">3</a>
                                        </li>
                                        <li class="so-page-ellipsis">...</li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">10</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">
                                                <span class="material-icons">chevron_right</span>
                                            </a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">
                                                <span class="material-icons">last_page</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>

                        <?= so_code_block('<nav class="so-pagination">
    <ul class="so-pagination-nav">
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">first_page</span></a>
        </li>
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
        </li>
        <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
        <li class="so-page-ellipsis">...</li>
        <li class="so-page-item"><a class="so-page-link" href="#">10</a></li>
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
        </li>
        <li class="so-page-item">
            <a class="so-page-link" href="#"><span class="material-icons">last_page</span></a>
        </li>
    </ul>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Size Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Size Variants</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Use <code>.so-pagination-sm</code> or <code>.so-pagination-lg</code> for different sizes.</p>

                                <div class="so-d-flex so-flex-column so-gap-4">
                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Small</h4>
                                        <nav class="so-pagination so-pagination-sm">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Default</h4>
                                        <nav class="so-pagination">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Large</h4>
                                        <nav class="so-pagination so-pagination-lg">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                        <?= so_code_block('<nav class="so-pagination so-pagination-sm">...</nav>
<nav class="so-pagination">...</nav>
<nav class="so-pagination so-pagination-lg">...</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Style Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Style Variants</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Different visual styles for pagination.</p>

                                <div class="so-d-flex so-flex-column so-gap-4">
                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Default (bordered)</h4>
                                        <nav class="so-pagination">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Rounded (pill)</h4>
                                        <nav class="so-pagination so-pagination-rounded">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Outlined</h4>
                                        <nav class="so-pagination so-pagination-outlined">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Minimal (no borders)</h4>
                                        <nav class="so-pagination so-pagination-minimal">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                        <?= so_code_block('<nav class="so-pagination">...</nav>
<nav class="so-pagination so-pagination-rounded">...</nav>
<nav class="so-pagination so-pagination-outlined">...</nav>
<nav class="so-pagination so-pagination-minimal">...</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Alignment -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Alignment</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Use <code>.so-pagination-center</code> or <code>.so-pagination-end</code> for alignment.</p>

                                <div class="so-d-flex so-flex-column so-gap-4">
                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Start (default)</h4>
                                        <nav class="so-pagination">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Center</h4>
                                        <nav class="so-pagination so-pagination-center">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">End</h4>
                                        <nav class="so-pagination so-pagination-end">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                        <?= so_code_block('<nav class="so-pagination">...</nav>
<nav class="so-pagination so-pagination-center">...</nav>
<nav class="so-pagination so-pagination-end">...</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Contextual Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Contextual Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Use <code>.so-pagination-{color}</code> for different color schemes.</p>

                                <div class="so-d-flex so-flex-column so-gap-4">
                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Primary</h4>
                                        <nav class="so-pagination so-pagination-primary">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Success</h4>
                                        <nav class="so-pagination so-pagination-success">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div>
                                        <h4 class="so-text-sm so-font-semibold so-mb-2">Danger</h4>
                                        <nav class="so-pagination so-pagination-danger">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                                <h4 class="so-text-sm so-font-semibold so-mb-2 so-mt-4">Light Variants</h4>
                                <div class="so-d-flex so-flex-column so-gap-4">
                                    <div>
                                        <h5 class="so-text-xs so-text-muted so-mb-2">Light Primary</h5>
                                        <nav class="so-pagination so-pagination-light-primary">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div>
                                        <h5 class="so-text-xs so-text-muted so-mb-2">Light Success</h5>
                                        <nav class="so-pagination so-pagination-light-success">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div>
                                        <h5 class="so-text-xs so-text-muted so-mb-2">Light Danger</h5>
                                        <nav class="so-pagination so-pagination-light-danger">
                                            <ul class="so-pagination-nav">
                                                <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                                <li class="so-page-item so-active"><a class="so-page-link" href="#">2</a></li>
                                                <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                        <?= so_code_block('<!-- Solid colors -->
<nav class="so-pagination so-pagination-primary">...</nav>
<nav class="so-pagination so-pagination-success">...</nav>

<!-- Light variants -->
<nav class="so-pagination so-pagination-light-primary">...</nav>
<nav class="so-pagination so-pagination-light-success">...</nav>
<nav class="so-pagination so-pagination-light-danger">...</nav>', 'html') ?>
                    </div>
                </div>

                <!-- With Page Info -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">With Page Info</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add <code>.so-pagination-info</code> to show item range.</p>

                                <nav class="so-pagination so-pagination-between">
                                    <span class="so-pagination-info">Showing <strong>1-10</strong> of <strong>97</strong> results</span>
                                    <ul class="so-pagination-nav">
                                        <li class="so-page-item so-disabled">
                                            <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
                                        </li>
                                        <li class="so-page-item so-active"><a class="so-page-link" href="#">1</a></li>
                                        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                        <li class="so-page-item"><a class="so-page-link" href="#">3</a></li>
                                        <li class="so-page-ellipsis">...</li>
                                        <li class="so-page-item"><a class="so-page-link" href="#">10</a></li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
                                        </li>
                                    </ul>
                                </nav>

                        <?= so_code_block('<nav class="so-pagination so-pagination-between">
    <span class="so-pagination-info">Showing <strong>1-10</strong> of <strong>97</strong> results</span>
    <ul class="so-pagination-nav">...</ul>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- With Items Per Page Selector -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">With Items Per Page Selector</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Include a selector to change the number of items per page.</p>

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
                                    <span class="so-pagination-info">1-10 of 97</span>
                                    <ul class="so-pagination-nav">
                                        <li class="so-page-item so-disabled">
                                            <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
                                        </li>
                                    </ul>
                                </nav>

                        <?= so_code_block('<nav class="so-pagination so-pagination-between">
    <div class="so-pagination-per-page">
        <span class="so-pagination-label">Rows per page:</span>
        <select class="so-pagination-select">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>
    <span class="so-pagination-info">1-10 of 97</span>
    <ul class="so-pagination-nav">...</ul>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- With Jump to Page -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">With Jump to Page</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add an input to jump directly to a specific page.</p>

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
                                        <li class="so-page-item so-active"><a class="so-page-link" href="#">3</a></li>
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

                        <?= so_code_block('<nav class="so-pagination so-pagination-between">
    <ul class="so-pagination-nav">...</ul>
    <div class="so-pagination-jump">
        <span class="so-pagination-jump-label">Go to page:</span>
        <input type="number" class="so-pagination-jump-input" min="1" max="20">
        <button class="so-pagination-jump-btn">Go</button>
    </div>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Interactive Pagination -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Interactive Pagination</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Dynamic pagination with JavaScript. Add <code>data-so-pagination</code> for auto-initialization.</p>

                                <nav class="so-pagination so-pagination-between"
                                     id="demo-pagination"
                                     data-so-pagination
                                     data-so-total-items="97"
                                     data-so-items-per-page="10"
                                     data-so-show-page-info="true"
                                     data-so-show-first-last="true">
                                    <span class="so-pagination-info">Showing 1-10 of 97</span>
                                    <ul class="so-pagination-nav">
                                        <!-- Will be populated by JavaScript -->
                                    </ul>
                                </nav>

                                <div class="so-mt-4 so-p-4 so-border so-rounded-lg" style="background: var(--so-bg-tertiary, var(--so-card-bg));">
                                    <h4 class="so-text-sm so-font-semibold so-mb-3">JavaScript API</h4>
                                    <div class="so-d-flex so-gap-2 so-flex-wrap">
                                        <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="demoPaginationFirst()">First</button>
                                        <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="demoPaginationPrev()">Prev</button>
                                        <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="demoPaginationNext()">Next</button>
                                        <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="demoPaginationLast()">Last</button>
                                        <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="demoPaginationGoTo(5)">Go to Page 5</button>
                                        <button class="so-btn so-btn-sm so-btn-outline-info" onclick="demoPaginationGetInfo()">Get Info</button>
                                    </div>
                                </div>

                        <?= so_code_block('// Get pagination instance
const pagination = SOPagination.getInstance(\'#demo-pagination\');

// Navigate
pagination.goToPage(5);
pagination.nextPage();
pagination.prevPage();
pagination.firstPage();
pagination.lastPage();

// Get info
pagination.getCurrentPage();    // Current page number
pagination.getTotalPages();     // Total page count
pagination.getPageRange();      // { start, end, total }

// Listen to events
element.addEventListener(\'so:pagination:change\', (e) => {
    console.log(\'Page changed to:\', e.detail.page);
});', 'javascript') ?>
                    </div>
                </div>

                <!-- Full Featured Example -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Full Featured Example</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Complete pagination with all controls: info, per-page selector, navigation, and jump to page.</p>

                                <nav class="so-pagination so-pagination-between" style="flex-wrap: wrap; gap: 16px;">
                                    <div class="so-pagination-per-page">
                                        <span class="so-pagination-label">Rows per page:</span>
                                        <select class="so-pagination-select">
                                            <option value="10" selected>10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>

                                    <span class="so-pagination-info">Showing <strong>21-30</strong> of <strong>256</strong> results</span>

                                    <ul class="so-pagination-nav">
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#"><span class="material-icons">first_page</span></a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#"><span class="material-icons">chevron_left</span></a>
                                        </li>
                                        <li class="so-page-item"><a class="so-page-link" href="#">1</a></li>
                                        <li class="so-page-item"><a class="so-page-link" href="#">2</a></li>
                                        <li class="so-page-item so-active"><a class="so-page-link" href="#">3</a></li>
                                        <li class="so-page-item"><a class="so-page-link" href="#">4</a></li>
                                        <li class="so-page-ellipsis">...</li>
                                        <li class="so-page-item"><a class="so-page-link" href="#">26</a></li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#"><span class="material-icons">chevron_right</span></a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#"><span class="material-icons">last_page</span></a>
                                        </li>
                                    </ul>

                                    <div class="so-pagination-jump">
                                        <span class="so-pagination-jump-label">Go to:</span>
                                        <input type="number" class="so-pagination-jump-input" min="1" max="26" value="3">
                                        <button class="so-pagination-jump-btn">Go</button>
                                    </div>
                                </nav>

                        <?= so_code_block('<nav class="so-pagination so-pagination-between">
    <div class="so-pagination-per-page">
        <span class="so-pagination-label">Rows per page:</span>
        <select class="so-pagination-select">...</select>
    </div>
    <span class="so-pagination-info">Showing 21-30 of 256</span>
    <ul class="so-pagination-nav">...</ul>
    <div class="so-pagination-jump">
        <span class="so-pagination-jump-label">Go to:</span>
        <input type="number" class="so-pagination-jump-input">
        <button class="so-pagination-jump-btn">Go</button>
    </div>
</nav>', 'html') ?>
                    </div>
                </div>

                <!-- Disabled States -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Disabled States</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Add <code>.so-disabled</code> to page items to disable them.</p>

                                <nav class="so-pagination">
                                    <ul class="so-pagination-nav">
                                        <li class="so-page-item so-disabled">
                                            <a class="so-page-link" href="#" tabindex="-1" aria-disabled="true">
                                                <span class="material-icons">chevron_left</span>
                                            </a>
                                        </li>
                                        <li class="so-page-item so-active">
                                            <a class="so-page-link" href="#">1</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">2</a>
                                        </li>
                                        <li class="so-page-item so-disabled">
                                            <a class="so-page-link" href="#" tabindex="-1" aria-disabled="true">3</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">4</a>
                                        </li>
                                        <li class="so-page-item">
                                            <a class="so-page-link" href="#">
                                                <span class="material-icons">chevron_right</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>

                        <?= so_code_block('<li class="so-page-item so-disabled">
    <a class="so-page-link" href="#" tabindex="-1" aria-disabled="true">
        <span class="material-icons">chevron_left</span>
    </a>
</li>', 'html') ?>
                    </div>
                </div>

<script>
// Pagination demo functions
function demoPaginationFirst() {
    const pagination = SOPagination.getInstance(document.querySelector('#demo-pagination'));
    if (pagination) pagination.firstPage();
}

function demoPaginationPrev() {
    const pagination = SOPagination.getInstance(document.querySelector('#demo-pagination'));
    if (pagination) pagination.prevPage();
}

function demoPaginationNext() {
    const pagination = SOPagination.getInstance(document.querySelector('#demo-pagination'));
    if (pagination) pagination.nextPage();
}

function demoPaginationLast() {
    const pagination = SOPagination.getInstance(document.querySelector('#demo-pagination'));
    if (pagination) pagination.lastPage();
}

function demoPaginationGoTo(page) {
    const pagination = SOPagination.getInstance(document.querySelector('#demo-pagination'));
    if (pagination) pagination.goToPage(page);
}

function demoPaginationGetInfo() {
    const pagination = SOPagination.getInstance(document.querySelector('#demo-pagination'));
    if (pagination) {
        const range = pagination.getPageRange();
        const info = `Current Page: ${pagination.getCurrentPage()}\nTotal Pages: ${pagination.getTotalPages()}\nShowing: ${range.start}-${range.end} of ${range.total}`;
        alert(info);
    }
}
</script>

    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
