<?php
/**
 * SixOrbit UI Engine - Grid Element Demo
 */

$pageTitle = 'Grid - UI Engine';
$pageDescription = 'CSS Grid-based layout system';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Grid</h1>
            <p class="so-page-subtitle">CSS Grid-based layout system for complex two-dimensional layouts.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Grid -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Grid</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-gap-3 so-mb-4">
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 1</div>
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 2</div>
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 3</div>
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 4</div>
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 5</div>
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 6</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-grid', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Grid uses CSS Grid layout - add children as HTML content
\$grid = UiEngine::grid()
    ->columns(3)     // 3 equal columns
    ->gap('1rem');   // Gap between items

// Add child elements
\$grid->add('<div>Item 1</div>');
\$grid->add('<div>Item 2</div>');
\$grid->add('<div>Item 3</div>');

echo \$grid->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const grid = UiEngine.grid()
    .columns(3)
    .gap('1rem');

// Add child elements
grid.add('<div>Item 1</div>');
grid.add('<div>Item 2</div>');
grid.add('<div>Item 3</div>');

document.getElementById('container').innerHTML = grid.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-grid" style="grid-template-columns:repeat(3,1fr);gap:var(--so-gap-4);">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
    <div>Item 4</div>
    <div>Item 5</div>
    <div>Item 6</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Responsive Columns -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Responsive Columns</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-1 so-grid-cols-sm-2 so-grid-cols-md-3 so-grid-cols-lg-4 so-gap-3 so-mb-4">
                    <div class="so-bg-success so-text-white so-p-3 so-rounded">1</div>
                    <div class="so-bg-success so-text-white so-p-3 so-rounded">2</div>
                    <div class="so-bg-success so-text-white so-p-3 so-rounded">3</div>
                    <div class="so-bg-success so-text-white so-p-3 so-rounded">4</div>
                    <div class="so-bg-success so-text-white so-p-3 so-rounded">5</div>
                    <div class="so-bg-success so-text-white so-p-3 so-rounded">6</div>
                    <div class="so-bg-success so-text-white so-p-3 so-rounded">7</div>
                    <div class="so-bg-success so-text-white so-p-3 so-rounded">8</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('grid-responsive', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// For responsive grids, use CSS utility classes
// The Grid element uses inline styles, so for responsive
// behavior, use class-based approach with so-grid-cols-*

\$html = '<div class=\"so-grid so-grid-cols-1 so-grid-cols-sm-2 so-grid-cols-md-3 so-grid-cols-lg-4 so-gap-3\">';
\$html .= '<div>Item 1</div>';
\$html .= '<div>Item 2</div>';
// ... more items
\$html .= '</div>';

echo \$html;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// For responsive grids, use CSS utility classes
const html = `
<div class=\"so-grid so-grid-cols-1 so-grid-cols-sm-2 so-grid-cols-md-3 so-grid-cols-lg-4 so-gap-3\">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
    <div>Item 4</div>
</div>
`;

document.getElementById('container').innerHTML = html;"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Auto-fit Columns -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Auto-fit Columns</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-gap-3 so-mb-4" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr));">
                    <div class="so-bg-info so-text-white so-p-3 so-rounded">Auto</div>
                    <div class="so-bg-info so-text-white so-p-3 so-rounded">Auto</div>
                    <div class="so-bg-info so-text-white so-p-3 so-rounded">Auto</div>
                    <div class="so-bg-info so-text-white so-p-3 so-rounded">Auto</div>
                    <div class="so-bg-info so-text-white so-p-3 so-rounded">Auto</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('grid-autofit', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Auto-fit: use columns() with CSS grid template string
\$grid = UiEngine::grid()
    ->columns('repeat(auto-fit, minmax(150px, 1fr))')
    ->gap('1rem');

// Auto-fill: creates empty columns if space allows
\$grid2 = UiEngine::grid()
    ->columns('repeat(auto-fill, minmax(200px, 1fr))')
    ->gap('1rem');

// Add children
\$grid->add('<div>Card 1</div>');
\$grid->add('<div>Card 2</div>');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Auto-fit: use columns() with CSS grid template string
const grid = UiEngine.grid()
    .columns('repeat(auto-fit, minmax(150px, 1fr))')
    .gap('1rem');

// Auto-fill: creates empty columns if space allows
const grid2 = UiEngine.grid()
    .columns('repeat(auto-fill, minmax(200px, 1fr))')
    .gap('1rem');

// Add children
grid.add('<div>Card 1</div>');
grid.add('<div>Card 2</div>');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Custom Column Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Custom Column Sizes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-gap-3 so-mb-4" style="grid-template-columns:200px 1fr 100px;">
                    <div class="so-bg-warning so-text-dark so-p-3 so-rounded">200px</div>
                    <div class="so-bg-warning so-text-dark so-p-3 so-rounded">1fr (flexible)</div>
                    <div class="so-bg-warning so-text-dark so-p-3 so-rounded">100px</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('grid-custom', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Custom column template - pass string to columns()
\$grid = UiEngine::grid()
    ->columns('200px 1fr 100px')  // Sidebar - Main - Aside
    ->gap('1rem');

\$grid->add('<div>Sidebar</div>');
\$grid->add('<div>Main Content</div>');
\$grid->add('<div>Aside</div>');

// Using fractions
\$grid2 = UiEngine::grid()
    ->columns('1fr 2fr 1fr')  // 1:2:1 ratio
    ->gap('1rem');

// Mix of units
\$grid3 = UiEngine::grid()
    ->columns('auto 1fr minmax(100px, 300px)')
    ->gap('1rem');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Custom column template - pass string to columns()
const grid = UiEngine.grid()
    .columns('200px 1fr 100px')
    .gap('1rem');

grid.add('<div>Sidebar</div>');
grid.add('<div>Main Content</div>');
grid.add('<div>Aside</div>');

// Using fractions
const grid2 = UiEngine.grid()
    .columns('1fr 2fr 1fr')
    .gap('1rem');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Grid with Rows -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Grid with Row Template</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-2 so-gap-3 so-mb-4" style="grid-template-rows:auto 1fr auto;height:250px;">
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded" style="grid-column:span 2;">Header</div>
                    <div class="so-bg-secondary so-text-white so-p-2 so-rounded">Sidebar</div>
                    <div class="so-bg-success so-text-white so-p-2 so-rounded">Main</div>
                    <div class="so-bg-dark so-text-white so-p-2 so-rounded" style="grid-column:span 2;">Footer</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('grid-rows', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$grid = UiEngine::grid()
    ->columns('1fr 1fr')
    ->rows('auto 1fr auto')  // Header, Content, Footer
    ->gap('1rem');

// Add children with inline styles for spanning
\$grid->add('<div style=\"grid-column: span 2\">Header</div>');
\$grid->add('<div>Sidebar</div>');
\$grid->add('<div>Main Content</div>');
\$grid->add('<div style=\"grid-column: span 2\">Footer</div>');

echo \$grid->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const grid = UiEngine.grid()
    .columns('1fr 1fr')
    .rows('auto 1fr auto')
    .gap('1rem');

// Add children with inline styles for spanning
grid.add('<div style=\"grid-column: span 2\">Header</div>');
grid.add('<div>Sidebar</div>');
grid.add('<div>Main Content</div>');
grid.add('<div style=\"grid-column: span 2\">Footer</div>');

document.getElementById('container').innerHTML = grid.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Grid Item Span -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Grid Item Spanning</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-4 so-gap-3 so-mb-4" style="grid-auto-rows:100px;">
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded so-d-flex so-align-items-center so-justify-content-center" style="grid-column:span 2;">Span 2 cols</div>
                    <div class="so-bg-success so-text-white so-p-2 so-rounded so-d-flex so-align-items-center so-justify-content-center">1</div>
                    <div class="so-bg-success so-text-white so-p-2 so-rounded so-d-flex so-align-items-center so-justify-content-center" style="grid-row:span 2;">Span 2 rows</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded so-d-flex so-align-items-center so-justify-content-center">2</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded so-d-flex so-align-items-center so-justify-content-center">3</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded so-d-flex so-align-items-center so-justify-content-center">4</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('grid-span', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$grid = UiEngine::grid()
    ->columns(4)
    ->gap('1rem');

// Add children with inline styles for spanning
\$grid->add('<div style=\"grid-column: span 2\">Wide item</div>');
\$grid->add('<div>Normal</div>');
\$grid->add('<div style=\"grid-row: span 2\">Tall item</div>');
\$grid->add('<div>Item 2</div>');
\$grid->add('<div>Item 3</div>');
\$grid->add('<div>Item 4</div>');

// Both column and row span
\$grid->add('<div style=\"grid-column: span 2; grid-row: span 2\">Large</div>');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const grid = UiEngine.grid()
    .columns(4)
    .gap('1rem');

// Add children with inline styles for spanning
grid.add('<div style=\"grid-column: span 2\">Wide item</div>');
grid.add('<div>Normal</div>');
grid.add('<div style=\"grid-row: span 2\">Tall item</div>');
grid.add('<div>Item 2</div>');
grid.add('<div>Item 3</div>');
grid.add('<div>Item 4</div>');

// Both column and row span
grid.add('<div style=\"grid-column: span 2; grid-row: span 2\">Large</div>');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Grid Alignment -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Grid Alignment</h3>
            </div>
            <div class="so-card-body">
                <!-- Code Tabs -->
                <?= so_code_tabs('grid-align', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Align all items
\$grid = UiEngine::grid()
    ->columns(3)
    ->justifyItems('center')   // Horizontal: start, center, end, stretch
    ->alignItems('center');    // Vertical: start, center, end, stretch

\$grid->add('<div>A</div>');
\$grid->add('<div>B</div>');
\$grid->add('<div>C</div>');

// Per-item alignment (use inline styles)
\$grid->add('<div style=\"justify-self: center; align-self: center\">Centered</div>');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Align all items
const grid = UiEngine.grid()
    .columns(3)
    .justifyItems('center')
    .alignItems('center');

grid.add('<div>A</div>');
grid.add('<div>B</div>');
grid.add('<div>C</div>');

// Per-item alignment (use inline styles)
grid.add('<div style=\"justify-self: center; align-self: center\">Centered</div>');"
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
                                <td><code>columns()</code></td>
                                <td><code>int|string $columns</code></td>
                                <td>Set columns (number or CSS template string)</td>
                            </tr>
                            <tr>
                                <td><code>rows()</code></td>
                                <td><code>int|string $rows</code></td>
                                <td>Set rows (number or CSS template string)</td>
                            </tr>
                            <tr>
                                <td><code>gap()</code></td>
                                <td><code>string $gap</code></td>
                                <td>Set gap between items (e.g., '1rem')</td>
                            </tr>
                            <tr>
                                <td><code>rowGap()</code></td>
                                <td><code>string $gap</code></td>
                                <td>Set row gap</td>
                            </tr>
                            <tr>
                                <td><code>columnGap()</code></td>
                                <td><code>string $gap</code></td>
                                <td>Set column gap</td>
                            </tr>
                            <tr>
                                <td><code>justifyItems()</code></td>
                                <td><code>string $value</code></td>
                                <td>Align items horizontally: start, center, end, stretch</td>
                            </tr>
                            <tr>
                                <td><code>alignItems()</code></td>
                                <td><code>string $value</code></td>
                                <td>Align items vertically: start, center, end, stretch</td>
                            </tr>
                            <tr>
                                <td><code>areas()</code></td>
                                <td><code>array $areas</code></td>
                                <td>Set named grid areas</td>
                            </tr>
                            <tr>
                                <td><code>autoFlow()</code></td>
                                <td><code>string $flow</code></td>
                                <td>Set auto flow: row, column, dense</td>
                            </tr>
                            <tr>
                                <td><code>add()</code></td>
                                <td><code>mixed $content</code></td>
                                <td>Add child element to the grid</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
