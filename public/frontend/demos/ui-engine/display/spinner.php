<?php
/**
 * SixOrbit UI Engine - Spinner Element Demo
 */

$pageTitle = 'Spinner - UI Engine';
$pageDescription = 'Loading indicators for async operations';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Spinner</h1>
            <p class="so-page-subtitle">Loading indicators for async operations and content loading states.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Border Spinner -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Border Spinner</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-align-items-center so-mb-4">
                    <div class="so-spinner"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-spinner', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Basic border spinner (default)
echo UiEngine::spinner()->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Basic border spinner (default)
const spinner = UiEngine.spinner();
document.body.innerHTML = spinner.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-spinner"></div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Spinner Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Spinner Sizes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-align-items-center so-mb-4">
                    <div class="so-spinner so-spinner-xs"></div>
                    <div class="so-spinner so-spinner-sm"></div>
                    <div class="so-spinner so-spinner-md"></div>
                    <div class="so-spinner so-spinner-lg"></div>
                    <div class="so-spinner so-spinner-xl"></div>
                </div>
                <p class="so-text-muted so-small so-mb-4">Sizes: xs (1rem), sm (1.5rem), md (2rem), lg (3rem), xl (4rem)</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::spinner()->size('xs');
UiEngine::spinner()->size('sm');
UiEngine::spinner()->size('md');
UiEngine::spinner()->size('lg');
UiEngine::spinner()->size('xl');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.spinner().size('xs').toHtml();
UiEngine.spinner().size('sm').toHtml();
UiEngine.spinner().size('md').toHtml();
UiEngine.spinner().size('lg').toHtml();
UiEngine.spinner().size('xl').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-spinner so-spinner-xs"></div>
<div class="so-spinner so-spinner-sm"></div>
<div class="so-spinner so-spinner-md"></div>
<div class="so-spinner so-spinner-lg"></div>
<div class="so-spinner so-spinner-xl"></div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Spinner Colors -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Spinner Colors</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-3 so-flex-wrap so-align-items-center so-mb-4">
                    <div class="so-spinner so-spinner-primary"></div>
                    <div class="so-spinner so-spinner-secondary"></div>
                    <div class="so-spinner so-spinner-success"></div>
                    <div class="so-spinner so-spinner-danger"></div>
                    <div class="so-spinner so-spinner-warning"></div>
                    <div class="so-spinner so-spinner-info"></div>
                    <div style="background: var(--so-grey-800); padding: 12px; border-radius: 8px;">
                        <div class="so-spinner so-spinner-light"></div>
                    </div>
                    <div class="so-spinner so-spinner-dark"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::spinner()->variant('primary');
UiEngine::spinner()->variant('secondary');
UiEngine::spinner()->variant('success');
UiEngine::spinner()->variant('danger');
UiEngine::spinner()->variant('warning');
UiEngine::spinner()->variant('info');
UiEngine::spinner()->variant('light');
UiEngine::spinner()->variant('dark');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.spinner().variant('primary').toHtml();
UiEngine.spinner().variant('secondary').toHtml();
UiEngine.spinner().variant('success').toHtml();
UiEngine.spinner().variant('danger').toHtml();
UiEngine.spinner().variant('warning').toHtml();
UiEngine.spinner().variant('info').toHtml();
UiEngine.spinner().variant('light').toHtml();
UiEngine.spinner().variant('dark').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-spinner so-spinner-primary"></div>
<div class="so-spinner so-spinner-secondary"></div>
<div class="so-spinner so-spinner-success"></div>
<div class="so-spinner so-spinner-danger"></div>
<div class="so-spinner so-spinner-warning"></div>
<div class="so-spinner so-spinner-info"></div>
<div class="so-spinner so-spinner-light"></div>
<div class="so-spinner so-spinner-dark"></div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Growing Spinner -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Growing Spinner</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap so-mb-4">
                    <div class="so-spinner-grow"></div>
                    <div class="so-spinner-grow so-spinner-sm"></div>
                    <div class="so-spinner-grow so-spinner-lg"></div>
                    <div class="so-spinner-grow so-spinner-primary"></div>
                    <div class="so-spinner-grow so-spinner-success"></div>
                    <div class="so-spinner-grow so-spinner-danger"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-grow', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Growing spinner
UiEngine::spinner()->grow();

// With sizes
UiEngine::spinner()->grow()->size('sm');
UiEngine::spinner()->grow()->size('lg');

// With colors
UiEngine::spinner()->grow()->variant('primary');
UiEngine::spinner()->grow()->variant('success');
UiEngine::spinner()->grow()->variant('danger');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Growing spinner
UiEngine.spinner().grow().toHtml();

// With sizes
UiEngine.spinner().grow().size('sm').toHtml();
UiEngine.spinner().grow().size('lg').toHtml();

// With colors
UiEngine.spinner().grow().variant('primary').toHtml();
UiEngine.spinner().grow().variant('success').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-spinner-grow"></div>
<div class="so-spinner-grow so-spinner-sm"></div>
<div class="so-spinner-grow so-spinner-lg"></div>
<div class="so-spinner-grow so-spinner-primary"></div>
<div class="so-spinner-grow so-spinner-success"></div>
<div class="so-spinner-grow so-spinner-danger"></div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Dots Spinner -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Dots Spinner</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap so-mb-4">
                    <div class="so-spinner-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="so-spinner-dots so-spinner-dots-sm">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="so-spinner-dots so-spinner-dots-lg">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="so-spinner-dots so-spinner-dots-success">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="so-spinner-dots so-spinner-dots-danger">
                        <span></span><span></span><span></span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-dots', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Dots spinner
UiEngine::spinner()->dots();

// With sizes (uses so-spinner-dots-sm, so-spinner-dots-lg)
UiEngine::spinner()->dots()->size('sm');
UiEngine::spinner()->dots()->size('lg');

// With colors (uses so-spinner-dots-success, etc.)
UiEngine::spinner()->dots()->variant('success');
UiEngine::spinner()->dots()->variant('danger');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Dots spinner
UiEngine.spinner().dots().toHtml();

// With sizes
UiEngine.spinner().dots().size('sm').toHtml();
UiEngine.spinner().dots().size('lg').toHtml();

// With colors
UiEngine.spinner().dots().variant('success').toHtml();
UiEngine.spinner().dots().variant('danger').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-spinner-dots">
    <span></span><span></span><span></span>
</div>

<div class="so-spinner-dots so-spinner-dots-sm">
    <span></span><span></span><span></span>
</div>

<div class="so-spinner-dots so-spinner-dots-lg">
    <span></span><span></span><span></span>
</div>

<div class="so-spinner-dots so-spinner-dots-success">
    <span></span><span></span><span></span>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Bars Spinner -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Bars Spinner</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap so-mb-4">
                    <div class="so-spinner-bars">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                    <div class="so-spinner-bars so-spinner-bars-sm">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                    <div class="so-spinner-bars so-spinner-bars-lg">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                    <div class="so-spinner-bars so-spinner-bars-primary">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                    <div class="so-spinner-bars so-spinner-bars-success">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-bars', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Bars spinner
UiEngine::spinner()->bars();

// With sizes (uses so-spinner-bars-sm, so-spinner-bars-lg)
UiEngine::spinner()->bars()->size('sm');
UiEngine::spinner()->bars()->size('lg');

// With colors (uses so-spinner-bars-primary, etc.)
UiEngine::spinner()->bars()->variant('primary');
UiEngine::spinner()->bars()->variant('success');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Bars spinner
UiEngine.spinner().bars().toHtml();

// With sizes
UiEngine.spinner().bars().size('sm').toHtml();
UiEngine.spinner().bars().size('lg').toHtml();

// With colors
UiEngine.spinner().bars().variant('primary').toHtml();
UiEngine.spinner().bars().variant('success').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-spinner-bars">
    <span></span><span></span><span></span><span></span><span></span>
</div>

<div class="so-spinner-bars so-spinner-bars-sm">
    <span></span><span></span><span></span><span></span><span></span>
</div>

<div class="so-spinner-bars so-spinner-bars-lg">
    <span></span><span></span><span></span><span></span><span></span>
</div>

<div class="so-spinner-bars so-spinner-bars-primary">
    <span></span><span></span><span></span><span></span><span></span>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Pulse Spinner -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Pulse Spinner</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap so-mb-4">
                    <div class="so-spinner-pulse"></div>
                    <div class="so-spinner-pulse so-spinner-sm"></div>
                    <div class="so-spinner-pulse so-spinner-lg"></div>
                    <div class="so-spinner-pulse so-spinner-primary"></div>
                    <div class="so-spinner-pulse so-spinner-success"></div>
                    <div class="so-spinner-pulse so-spinner-danger"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-pulse', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Pulse spinner
UiEngine::spinner()->pulse();

// With sizes
UiEngine::spinner()->pulse()->size('sm');
UiEngine::spinner()->pulse()->size('lg');

// With colors
UiEngine::spinner()->pulse()->variant('primary');
UiEngine::spinner()->pulse()->variant('success');
UiEngine::spinner()->pulse()->variant('danger');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Pulse spinner
UiEngine.spinner().pulse().toHtml();

// With sizes
UiEngine.spinner().pulse().size('sm').toHtml();
UiEngine.spinner().pulse().size('lg').toHtml();

// With colors
UiEngine.spinner().pulse().variant('primary').toHtml();
UiEngine.spinner().pulse().variant('success').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-spinner-pulse"></div>
<div class="so-spinner-pulse so-spinner-sm"></div>
<div class="so-spinner-pulse so-spinner-lg"></div>
<div class="so-spinner-pulse so-spinner-primary"></div>
<div class="so-spinner-pulse so-spinner-success"></div>
<div class="so-spinner-pulse so-spinner-danger"></div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Spinner with Text -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Spinner with Text</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap so-mb-4">
                    <div class="so-spinner-inline">
                        <div class="so-spinner so-spinner-sm"></div>
                        <span>Loading...</span>
                    </div>
                    <div class="so-spinner-inline">
                        <div class="so-spinner-dots so-spinner-dots-sm">
                            <span></span><span></span><span></span>
                        </div>
                        <span>Please wait</span>
                    </div>
                    <div class="so-spinner-inline">
                        <div class="so-spinner so-spinner-sm so-spinner-success"></div>
                        <span>Saving changes...</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-text', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Spinner with inline label
UiEngine::spinner()
    ->size('sm')
    ->label('Loading...');

// Dots spinner with label
UiEngine::spinner()
    ->dots()
    ->size('sm')
    ->label('Please wait');

// Colored spinner with label
UiEngine::spinner()
    ->size('sm')
    ->variant('success')
    ->label('Saving changes...');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Spinner with inline label
UiEngine.spinner()
    .size('sm')
    .label('Loading...')
    .toHtml();

// Dots spinner with label
UiEngine.spinner()
    .dots()
    .size('sm')
    .label('Please wait')
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-spinner-inline">
    <div class="so-spinner so-spinner-sm"></div>
    <span>Loading...</span>
</div>

<div class="so-spinner-inline">
    <div class="so-spinner-dots so-spinner-dots-sm">
        <span></span><span></span><span></span>
    </div>
    <span>Please wait</span>
</div>

<div class="so-spinner-inline">
    <div class="so-spinner so-spinner-sm so-spinner-success"></div>
    <span>Saving changes...</span>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Button Loading States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Loading States</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                    <button class="so-btn so-btn-primary" type="button" disabled>
                        <div class="so-spinner so-spinner-xs so-spinner-light"></div>
                        Loading...
                    </button>
                    <button class="so-btn so-btn-success" type="button" disabled>
                        <div class="so-spinner so-spinner-xs so-spinner-light"></div>
                        Saving
                    </button>
                    <button class="so-btn so-btn-secondary" type="button" disabled>
                        <div class="so-spinner-dots so-spinner-dots-sm so-spinner-dots-dark">
                            <span></span><span></span><span></span>
                        </div>
                    </button>
                    <button class="so-btn so-btn-outline-primary" type="button" disabled>
                        <div class="so-spinner so-spinner-xs so-spinner-primary"></div>
                        Processing
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-button', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Button with loading state
UiEngine::button('Loading...')
    ->variant('primary')
    ->loading();

// Button with dots spinner
UiEngine::button('')
    ->variant('secondary')
    ->prepend(UiEngine::spinner()->dots()->size('sm'))
    ->disabled();

// Outline button with spinner
UiEngine::button('Processing')
    ->variant('outline-primary')
    ->prepend(UiEngine::spinner()->size('xs')->variant('primary'))
    ->disabled();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Toggle loading state
const btn = UiEngine.button('Submit').variant('primary');
btn.loading(true);  // Show spinner
btn.loading(false); // Hide spinner

// Create button with spinner manually
UiEngine.button('Processing')
    .variant('outline-primary')
    .prepend(UiEngine.spinner().size('xs').variant('primary'))
    .disabled()
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button class="so-btn so-btn-primary" disabled>
    <div class="so-spinner so-spinner-xs so-spinner-light"></div>
    Loading...
</button>

<button class="so-btn so-btn-success" disabled>
    <div class="so-spinner so-spinner-xs so-spinner-light"></div>
    Saving
</button>

<button class="so-btn so-btn-secondary" disabled>
    <div class="so-spinner-dots so-spinner-dots-sm so-spinner-dots-dark">
        <span></span><span></span><span></span>
    </div>
</button>

<button class="so-btn so-btn-outline-primary" disabled>
    <div class="so-spinner so-spinner-xs so-spinner-primary"></div>
    Processing
</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Loading Overlay</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-flex-wrap so-mb-4">
                    <!-- Contained overlay -->
                    <div style="position: relative; height: 150px; width: 280px; border: 1px solid var(--so-border-color); border-radius: 8px; overflow: hidden;">
                        <div class="so-p-3">
                            <p class="so-mb-2">Card content here</p>
                            <p class="so-text-muted so-small">This content is loading...</p>
                        </div>
                        <div class="so-spinner-overlay so-spinner-overlay-contained">
                            <div class="so-spinner-overlay-content">
                                <div class="so-spinner so-spinner-lg"></div>
                                <div class="so-spinner-overlay-text">Loading content...</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="so-mb-4">
                    <button class="so-btn so-btn-primary" onclick="showFullOverlay()">
                        <span class="material-icons">fullscreen</span>
                        Show Full-screen Overlay (2s)
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('spinner-overlay', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Contained loading overlay (for cards, sections)
UiEngine::spinner()
    ->overlay()
    ->contained()
    ->size('lg')
    ->label('Loading content...');

// Full page overlay
UiEngine::spinner()
    ->overlay()
    ->size('xl')
    ->label('Loading application...');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Show contained overlay
const overlay = UiEngine.spinner()
    .overlay()
    .contained()
    .size('lg')
    .label('Loading...');

container.insertAdjacentHTML('beforeend', overlay.toHtml());

// Hide overlay
container.querySelector('.so-spinner-overlay').remove();

// Full page overlay
UiEngine.spinner()
    .overlay()
    .size('xl')
    .label('Loading application...')
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Contained overlay (parent needs position: relative) -->
<div style="position: relative;">
    <!-- Card content -->
    <div class="so-spinner-overlay so-spinner-overlay-contained">
        <div class="so-spinner-overlay-content">
            <div class="so-spinner so-spinner-lg"></div>
            <div class="so-spinner-overlay-text">Loading content...</div>
        </div>
    </div>
</div>

<!-- Full-screen overlay -->
<div class="so-spinner-overlay">
    <div class="so-spinner-overlay-content">
        <div class="so-spinner so-spinner-xl"></div>
        <div class="so-spinner-overlay-text">Loading...</div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
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
                                <td><code>grow()</code></td>
                                <td>-</td>
                                <td>Use growing/pulsing animation (so-spinner-grow)</td>
                            </tr>
                            <tr>
                                <td><code>dots()</code></td>
                                <td>-</td>
                                <td>Use three bouncing dots (so-spinner-dots)</td>
                            </tr>
                            <tr>
                                <td><code>bars()</code></td>
                                <td>-</td>
                                <td>Use animated equalizer bars (so-spinner-bars)</td>
                            </tr>
                            <tr>
                                <td><code>pulse()</code></td>
                                <td>-</td>
                                <td>Use expanding rings animation (so-spinner-pulse)</td>
                            </tr>
                            <tr>
                                <td><code>variant()</code></td>
                                <td><code>string $variant</code></td>
                                <td>Color: primary, secondary, success, danger, warning, info, light, dark</td>
                            </tr>
                            <tr>
                                <td><code>size()</code></td>
                                <td><code>string $size</code></td>
                                <td>Size: xs, sm, md, lg, xl</td>
                            </tr>
                            <tr>
                                <td><code>label()</code></td>
                                <td><code>string $text</code></td>
                                <td>Add visible loading text (uses so-spinner-inline wrapper)</td>
                            </tr>
                            <tr>
                                <td><code>overlay()</code></td>
                                <td>-</td>
                                <td>Create loading overlay (so-spinner-overlay)</td>
                            </tr>
                            <tr>
                                <td><code>contained()</code></td>
                                <td>-</td>
                                <td>Make overlay contained within parent (so-spinner-overlay-contained)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Full-screen overlay for demo -->
<div class="so-spinner-overlay" id="fullOverlay" style="display: none;">
    <div class="so-spinner-overlay-content">
        <div class="so-spinner so-spinner-xl"></div>
        <div class="so-spinner-overlay-text">Loading application...</div>
    </div>
</div>

<script>
function showFullOverlay() {
    const overlay = document.getElementById('fullOverlay');
    overlay.style.display = 'flex';
    setTimeout(() => {
        overlay.style.display = 'none';
    }, 2000);
}
</script>

<?php require_once '../../includes/footer.php'; ?>
