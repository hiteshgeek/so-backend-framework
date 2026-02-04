<?php
/**
 * SixOrbit UI Engine - Container Element Demo
 */

$pageTitle = 'Container - UI Engine';
$pageDescription = 'Responsive fixed-width and fluid-width containers';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Container</h1>
            <p class="so-page-subtitle">Responsive containers for wrapping and centering page content with automatic padding.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Container -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Container</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-container so-bg-primary so-text-white so-p-3 so-rounded so-mb-4">
                    Default container - centers content with responsive max-width
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-container', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$container = UiEngine::container()
    ->content('Your page content here');

echo \$container->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const container = UiEngine.container()
    .content('Your page content here');

document.body.innerHTML = container.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-container">
    Your page content here
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Container Types -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Container Types</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-container so-bg-info so-text-white so-p-2 so-mb-2 so-rounded">.so-container (responsive max-width)</div>
                <div class="so-container-fluid so-bg-success so-text-white so-p-2 so-mb-2 so-rounded">.so-container-fluid (100% width)</div>
                <div class="so-container-sm so-bg-warning so-text-dark so-p-2 so-mb-2 so-rounded">.so-container-sm (100% until sm)</div>
                <div class="so-container-md so-bg-danger so-text-white so-p-2 so-mb-2 so-rounded">.so-container-md (100% until md)</div>
                <div class="so-container-lg so-bg-primary so-text-white so-p-2 so-mb-2 so-rounded">.so-container-lg (100% until lg)</div>
                <div class="so-container-xl so-bg-secondary so-text-white so-p-2 so-mb-4 so-rounded">.so-container-xl (100% until xl)</div>

                <!-- Code Tabs -->
                <?= so_code_tabs('container-types', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Default responsive container
UiEngine::container()
    ->content('...');

// Fluid container (full width)
UiEngine::container()
    ->fluid()
    ->content('...');

// Responsive breakpoint containers
UiEngine::container()
    ->breakpoint('sm')  // 100% width until small breakpoint
    ->content('...');

UiEngine::container()
    ->breakpoint('md')  // 100% width until medium breakpoint
    ->content('...');

UiEngine::container()
    ->breakpoint('lg')  // 100% width until large breakpoint
    ->content('...');

UiEngine::container()
    ->breakpoint('xl')  // 100% width until extra large breakpoint
    ->content('...');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Default responsive container
UiEngine.container()
    .content('...');

// Fluid container (full width)
UiEngine.container()
    .fluid()
    .content('...');

// Responsive breakpoint containers
UiEngine.container()
    .breakpoint('sm')
    .content('...');

UiEngine.container()
    .breakpoint('md')
    .content('...');

UiEngine.container()
    .breakpoint('lg')
    .content('...');

UiEngine.container()
    .breakpoint('xl')
    .content('...');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Container Max Widths -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Container Max Widths</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive so-mb-4">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Extra Small<br><small>&lt;576px</small></th>
                                <th>Small<br><small>≥576px</small></th>
                                <th>Medium<br><small>≥768px</small></th>
                                <th>Large<br><small>≥992px</small></th>
                                <th>X-Large<br><small>≥1200px</small></th>
                                <th>XX-Large<br><small>≥1400px</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-container</code></td>
                                <td>100%</td>
                                <td>540px</td>
                                <td>720px</td>
                                <td>960px</td>
                                <td>1140px</td>
                                <td>1320px</td>
                            </tr>
                            <tr>
                                <td><code>.so-container-sm</code></td>
                                <td>100%</td>
                                <td>540px</td>
                                <td>720px</td>
                                <td>960px</td>
                                <td>1140px</td>
                                <td>1320px</td>
                            </tr>
                            <tr>
                                <td><code>.so-container-md</code></td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>720px</td>
                                <td>960px</td>
                                <td>1140px</td>
                                <td>1320px</td>
                            </tr>
                            <tr>
                                <td><code>.so-container-lg</code></td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>960px</td>
                                <td>1140px</td>
                                <td>1320px</td>
                            </tr>
                            <tr>
                                <td><code>.so-container-xl</code></td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>1140px</td>
                                <td>1320px</td>
                            </tr>
                            <tr>
                                <td><code>.so-container-xxl</code></td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>1320px</td>
                            </tr>
                            <tr>
                                <td><code>.so-container-fluid</code></td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                                <td>100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Nested Containers -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Row and Columns</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-container so-bg-light so-p-3 so-rounded so-mb-4">
                    <div class="so-row so-g-3">
                        <div class="so-col-4">
                            <div class="so-card">
                                <div class="so-card-body">Column 1</div>
                            </div>
                        </div>
                        <div class="so-col-4">
                            <div class="so-card">
                                <div class="so-card-body">Column 2</div>
                            </div>
                        </div>
                        <div class="so-col-4">
                            <div class="so-card">
                                <div class="so-card-body">Column 3</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('container-grid', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$page = UiEngine::container()
    ->content(
        UiEngine::row()
            ->col(UiEngine::card()->body('Column 1'), 4)
            ->col(UiEngine::card()->body('Column 2'), 4)
            ->col(UiEngine::card()->body('Column 3'), 4)
            ->render()
    );

echo \$page->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const page = UiEngine.container()
    .content(
        UiEngine.row()
            .col(UiEngine.card().body('Column 1'), 4)
            .col(UiEngine.card().body('Column 2'), 4)
            .col(UiEngine.card().body('Column 3'), 4)
            .toHtml()
    );

document.body.innerHTML = page.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Custom Padding -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Custom Padding</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <p class="so-text-muted so-mb-2">No horizontal padding (so-px-0):</p>
                    <div class="so-container so-px-0 so-bg-primary so-text-white so-py-2 so-rounded so-mb-3">
                        Container with no horizontal padding
                    </div>

                    <p class="so-text-muted so-mb-2">Extra padding (so-p-5):</p>
                    <div class="so-container so-p-5 so-bg-success so-text-white so-rounded so-mb-3">
                        Container with extra padding
                    </div>

                    <p class="so-text-muted so-mb-2">Custom padding (so-px-4 so-py-5):</p>
                    <div class="so-container so-px-4 so-py-5 so-bg-info so-text-white so-rounded">
                        Container with custom horizontal and vertical padding
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('container-padding', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Remove horizontal padding
UiEngine::container()
    ->class('so-px-0')
    ->content('No horizontal padding');

// Extra padding
UiEngine::container()
    ->padding(5)  // p-5 class
    ->content('Extra padding');

// Custom padding on each side
UiEngine::container()
    ->paddingX(4)
    ->paddingY(5)
    ->content('Custom padding');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Remove horizontal padding
UiEngine.container()
    .addClass('so-px-0')
    .content('No horizontal padding');

// Extra padding
UiEngine.container()
    .padding(5)
    .content('Extra padding');

// Custom padding on each side
UiEngine.container()
    .paddingX(4)
    .paddingY(5)
    .content('Custom padding');"
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
                                <td><code>content()</code></td>
                                <td><code>string $html</code></td>
                                <td>Set container content</td>
                            </tr>
                            <tr>
                                <td><code>fluid()</code></td>
                                <td>-</td>
                                <td>Make container full width</td>
                            </tr>
                            <tr>
                                <td><code>breakpoint()</code></td>
                                <td><code>string $bp</code></td>
                                <td>Set responsive breakpoint: sm, md, lg, xl, xxl</td>
                            </tr>
                            <tr>
                                <td><code>padding()</code></td>
                                <td><code>int $size</code></td>
                                <td>Set padding (0-5)</td>
                            </tr>
                            <tr>
                                <td><code>paddingX()</code></td>
                                <td><code>int $size</code></td>
                                <td>Set horizontal padding</td>
                            </tr>
                            <tr>
                                <td><code>paddingY()</code></td>
                                <td><code>int $size</code></td>
                                <td>Set vertical padding</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
