<?php
/**
 * SixOrbit UI Engine - Column Element Demo
 */

$pageTitle = 'Column - UI Engine';
$pageDescription = 'Flexible column element for grid layouts';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Column</h1>
            <p class="so-page-subtitle">Flexible column element with responsive width control in the 12-column grid system.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Column -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Column</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col so-bg-primary so-text-white so-p-3 so-border">Auto column</div>
                    <div class="so-col so-bg-primary so-text-white so-p-3 so-border">Auto column</div>
                    <div class="so-col so-bg-primary so-text-white so-p-3 so-border">Auto column</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-column', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Auto-width columns (equal width)
\$col = UiEngine::column()
    ->content('Auto column');

// Or use within a row
\$row = UiEngine::row()
    ->col(UiEngine::column()->content('Column 1'))
    ->col(UiEngine::column()->content('Column 2'))
    ->col(UiEngine::column()->content('Column 3'));

echo \$row->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Auto-width columns
const col = UiEngine.column()
    .content('Auto column');

// Or use within a row
const row = UiEngine.row()
    .col(UiEngine.column().content('Column 1'))
    .col(UiEngine.column().content('Column 2'))
    .col(UiEngine.column().content('Column 3'));

document.getElementById('container').innerHTML = row.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-row">
    <div class="so-col">Column 1</div>
    <div class="so-col">Column 2</div>
    <div class="so-col">Column 3</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Fixed Width Columns -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Fixed Width Columns</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-2">
                    <div class="so-col-1 so-bg-info so-text-white so-p-1 so-text-center so-border">1</div>
                    <div class="so-col-2 so-bg-info so-text-white so-p-1 so-text-center so-border">2</div>
                    <div class="so-col-3 so-bg-info so-text-white so-p-1 so-text-center so-border">3</div>
                    <div class="so-col-6 so-bg-info so-text-white so-p-1 so-text-center so-border">6</div>
                </div>
                <div class="so-row so-mb-4">
                    <div class="so-col-4 so-bg-success so-text-white so-p-1 so-text-center so-border">4</div>
                    <div class="so-col-4 so-bg-success so-text-white so-p-1 so-text-center so-border">4</div>
                    <div class="so-col-4 so-bg-success so-text-white so-p-1 so-text-center so-border">4</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('column-widths', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Column spanning 1-12 grid units
UiEngine::column()
    ->size(6)  // Half width (6 of 12)
    ->content('Half width column');

UiEngine::column()
    ->size(4)  // One third (4 of 12)
    ->content('One third column');

UiEngine::column()
    ->size(3)  // One quarter (3 of 12)
    ->content('Quarter column');

// Mixed widths in a row
UiEngine::row()
    ->col('Sidebar', 3)
    ->col('Main content', 9);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Column spanning 1-12 grid units
UiEngine.column()
    .size(6)
    .content('Half width column');

UiEngine.column()
    .size(4)
    .content('One third column');

UiEngine.column()
    .size(3)
    .content('Quarter column');

// Mixed widths in a row
UiEngine.row()
    .col('Sidebar', 3)
    .col('Main content', 9);"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Responsive Widths -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Responsive Widths</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-12 so-col-sm-6 so-col-md-4 so-col-lg-3 so-bg-primary so-text-white so-p-2 so-border so-mb-2">
                        12 → 6 → 4 → 3
                    </div>
                    <div class="so-col-12 so-col-sm-6 so-col-md-4 so-col-lg-3 so-bg-primary so-text-white so-p-2 so-border so-mb-2">
                        12 → 6 → 4 → 3
                    </div>
                    <div class="so-col-12 so-col-sm-6 so-col-md-4 so-col-lg-3 so-bg-primary so-text-white so-p-2 so-border so-mb-2">
                        12 → 6 → 4 → 3
                    </div>
                    <div class="so-col-12 so-col-sm-6 so-col-md-12 so-col-lg-3 so-bg-primary so-text-white so-p-2 so-border so-mb-2">
                        12 → 6 → 12 → 3
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('column-responsive', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Responsive column widths
UiEngine::column()
    ->size(12)      // Full width on extra small
    ->sm(6)         // Half on small
    ->md(4)         // Third on medium
    ->lg(3)         // Quarter on large
    ->content('Responsive column');

// All responsive breakpoints
UiEngine::column()
    ->size(12)      // Base size (xs)
    ->sm(6)         // Small screens
    ->md(4)         // Medium screens
    ->lg(3)         // Large screens
    ->xl(2)         // Extra large screens
    ->xxl(1)        // Extra extra large screens
    ->content('...');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Responsive column widths
UiEngine.column()
    .size(12)
    .sm(6)
    .md(4)
    .lg(3)
    .content('Responsive column');

// All responsive breakpoints
UiEngine.column()
    .size(12)
    .sm(6)
    .md(4)
    .lg(3)
    .xl(2)
    .xxl(1)
    .content('...');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Auto Width -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Auto Width Columns</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-3">
                    <div class="so-col-auto so-bg-warning so-text-dark so-p-2 so-border">Auto (content width)</div>
                    <div class="so-col so-bg-success so-text-white so-p-2 so-border">Fill remaining</div>
                </div>
                <div class="so-row so-mb-4">
                    <div class="so-col so-bg-info so-text-white so-p-2 so-border">Equal</div>
                    <div class="so-col-auto so-bg-warning so-text-dark so-p-2 so-border">Content width column</div>
                    <div class="so-col so-bg-info so-text-white so-p-2 so-border">Equal</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('column-auto', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Auto width based on content
UiEngine::column()
    ->auto()
    ->content('Sized to content');

// Flexible column that fills remaining space
UiEngine::column()
    ->content('Fills remaining space');

// Mixed auto and flexible
UiEngine::row()
    ->col(UiEngine::column()->auto()->content('Auto'))
    ->col(UiEngine::column()->content('Flexible'));"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Auto width based on content
UiEngine.column()
    .auto()
    .content('Sized to content');

// Flexible column that fills remaining space
UiEngine.column()
    .content('Fills remaining space');

// Mixed auto and flexible
UiEngine.row()
    .col(UiEngine.column().auto().content('Auto'))
    .col(UiEngine.column().content('Flexible'));"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Column Offset -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Column Offset</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-2">
                    <div class="so-col-4 so-offset-4 so-bg-primary so-text-white so-p-2 so-text-center">offset-4</div>
                </div>
                <div class="so-row so-mb-2">
                    <div class="so-col-3 so-bg-success so-text-white so-p-2 so-text-center">col-3</div>
                    <div class="so-col-3 so-offset-3 so-bg-success so-text-white so-p-2 so-text-center">offset-3</div>
                </div>
                <div class="so-row so-mb-4">
                    <div class="so-col-6 so-offset-3 so-bg-info so-text-white so-p-2 so-text-center">Centered with offset</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('column-offset', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Offset by 4 columns
UiEngine::column()
    ->size(4)
    ->offset(4)
    ->content('Centered');

// Responsive offset
UiEngine::column()
    ->size(6)
    ->offset(3)
    ->offsetAt('md', 0)  // No offset on medium+
    ->content('...');

// Center a column with offset
UiEngine::row()
    ->col(UiEngine::column()
        ->size(6)
        ->offset(3)
        ->content('Centered content')
    );"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Offset by 4 columns
UiEngine.column()
    .size(4)
    .offset(4)
    .content('Centered');

// Responsive offset
UiEngine.column()
    .size(6)
    .offset(3)
    .offsetAt('md', 0)
    .content('...');

// Center a column with offset
UiEngine.row()
    .col(UiEngine.column()
        .size(6)
        .offset(3)
        .content('Centered content')
    );"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Column Order -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Column Order</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col so-order-3 so-bg-primary so-text-white so-p-2 so-border">First in DOM, displayed third</div>
                    <div class="so-col so-order-1 so-bg-success so-text-white so-p-2 so-border">Second in DOM, displayed first</div>
                    <div class="so-col so-order-2 so-bg-warning so-text-dark so-p-2 so-border">Third in DOM, displayed second</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('column-order', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Reorder columns visually
UiEngine::row()
    ->col(UiEngine::column()->order(3)->content('Third'))
    ->col(UiEngine::column()->order(1)->content('First'))
    ->col(UiEngine::column()->order(2)->content('Second'));

// Order using numeric values (1-5)
UiEngine::column()
    ->order(2)
    ->content('...');

// Special order values
UiEngine::column()->first();   // Display first (order: first)
UiEngine::column()->last();    // Display last (order: last)"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Reorder columns visually
UiEngine.row()
    .col(UiEngine.column().order(3).content('Third'))
    .col(UiEngine.column().order(1).content('First'))
    .col(UiEngine.column().order(2).content('Second'));

// Order using numeric values (1-5)
UiEngine.column()
    .order(2)
    .content('...');

// Special order values
UiEngine.column().first();   // Display first
UiEngine.column().last();    // Display last"
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
                                <td>Set column content</td>
                            </tr>
                            <tr>
                                <td><code>size()</code></td>
                                <td><code>int|string $size</code></td>
                                <td>Set width (1-12 columns or 'auto')</td>
                            </tr>
                            <tr>
                                <td><code>sm()</code>, <code>md()</code>, <code>lg()</code>, <code>xl()</code>, <code>xxl()</code></td>
                                <td><code>int|string $size</code></td>
                                <td>Set responsive width at breakpoint</td>
                            </tr>
                            <tr>
                                <td><code>auto()</code></td>
                                <td>-</td>
                                <td>Size to content</td>
                            </tr>
                            <tr>
                                <td><code>offset()</code></td>
                                <td><code>int $cols</code></td>
                                <td>Set column offset (0-11)</td>
                            </tr>
                            <tr>
                                <td><code>offsetAt()</code></td>
                                <td><code>string $breakpoint, int $offset</code></td>
                                <td>Set responsive offset at breakpoint</td>
                            </tr>
                            <tr>
                                <td><code>order()</code></td>
                                <td><code>int|string $order</code></td>
                                <td>Set visual order (1-5 or 'first'/'last')</td>
                            </tr>
                            <tr>
                                <td><code>first()</code></td>
                                <td>-</td>
                                <td>Display first</td>
                            </tr>
                            <tr>
                                <td><code>last()</code></td>
                                <td>-</td>
                                <td>Display last</td>
                            </tr>
                            <tr>
                                <td><code>alignSelf()</code></td>
                                <td><code>string $alignment</code></td>
                                <td>Self alignment: start, center, end, stretch, baseline</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
