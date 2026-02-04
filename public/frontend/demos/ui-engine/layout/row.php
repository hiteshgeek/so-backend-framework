<?php
/**
 * SixOrbit UI Engine - Row Element Demo
 */

$pageTitle = 'Row - UI Engine';
$pageDescription = 'Horizontal row wrapper for grid columns';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Row</h1>
            <p class="so-page-subtitle">Horizontal wrapper for columns in the 12-column grid system.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Row -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Row with Columns</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col so-bg-primary so-text-white so-p-3 so-border">Column 1</div>
                    <div class="so-col so-bg-primary so-text-white so-p-3 so-border">Column 2</div>
                    <div class="so-col so-bg-primary so-text-white so-p-3 so-border">Column 3</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-row', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$row = UiEngine::row()
    ->col('Column 1')
    ->col('Column 2')
    ->col('Column 3');

echo \$row->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const row = UiEngine.row()
    .col('Column 1')
    .col('Column 2')
    .col('Column 3');

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

        <!-- Column Widths -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Column Widths</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-3">
                    <div class="so-col-6 so-bg-info so-text-white so-p-2 so-border">col-6</div>
                    <div class="so-col-6 so-bg-info so-text-white so-p-2 so-border">col-6</div>
                </div>
                <div class="so-row so-mb-3">
                    <div class="so-col-4 so-bg-success so-text-white so-p-2 so-border">col-4</div>
                    <div class="so-col-8 so-bg-success so-text-white so-p-2 so-border">col-8</div>
                </div>
                <div class="so-row so-mb-4">
                    <div class="so-col-3 so-bg-warning so-text-dark so-p-2 so-border">col-3</div>
                    <div class="so-col-6 so-bg-warning so-text-dark so-p-2 so-border">col-6</div>
                    <div class="so-col-3 so-bg-warning so-text-dark so-p-2 so-border">col-3</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('row-widths', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Equal halves
UiEngine::row()
    ->col('Half', 6)
    ->col('Half', 6);

// Unequal columns
UiEngine::row()
    ->col('Narrow', 4)
    ->col('Wide', 8);

// Multiple columns
UiEngine::row()
    ->col('Left', 3)
    ->col('Center', 6)
    ->col('Right', 3);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Equal halves
UiEngine.row()
    .col('Half', 6)
    .col('Half', 6);

// Unequal columns
UiEngine.row()
    .col('Narrow', 4)
    .col('Wide', 8);

// Multiple columns
UiEngine.row()
    .col('Left', 3)
    .col('Center', 6)
    .col('Right', 3);"
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
                <div class="so-row so-mb-4">
                    <div class="so-col-12 so-col-md-6 so-col-lg-4 so-bg-primary so-text-white so-p-2 so-border so-mb-2 so-mb-lg-0">
                        Full → Half → Third
                    </div>
                    <div class="so-col-12 so-col-md-6 so-col-lg-4 so-bg-primary so-text-white so-p-2 so-border so-mb-2 so-mb-lg-0">
                        Full → Half → Third
                    </div>
                    <div class="so-col-12 so-col-md-12 so-col-lg-4 so-bg-primary so-text-white so-p-2 so-border">
                        Full → Full → Third
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('row-responsive', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$row = UiEngine::row()
    ->col('Card 1', [
        'cols' => 12,      // Full width on mobile
        'md' => 6,         // Half on medium
        'lg' => 4,         // Third on large
    ])
    ->col('Card 2', [
        'cols' => 12,
        'md' => 6,
        'lg' => 4,
    ])
    ->col('Card 3', [
        'cols' => 12,
        'md' => 12,
        'lg' => 4,
    ]);

echo \$row->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const row = UiEngine.row()
    .col('Card 1', {
        cols: 12,
        md: 6,
        lg: 4,
    })
    .col('Card 2', {
        cols: 12,
        md: 6,
        lg: 4,
    })
    .col('Card 3', {
        cols: 12,
        md: 12,
        lg: 4,
    });

document.getElementById('container').innerHTML = row.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Row Gutters -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Row Gutters (Spacing)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <p class="so-text-muted so-mb-2">No gutters (g-0):</p>
                <div class="so-row so-g-0 so-mb-4">
                    <div class="so-col-4"><div class="so-bg-info so-text-white so-p-2">Col</div></div>
                    <div class="so-col-4"><div class="so-bg-success so-text-white so-p-2">Col</div></div>
                    <div class="so-col-4"><div class="so-bg-warning so-text-dark so-p-2">Col</div></div>
                </div>
                <p class="so-text-muted so-mb-2">Large gutters (g-4):</p>
                <div class="so-row so-g-4 so-mb-4">
                    <div class="so-col-4"><div class="so-bg-info so-text-white so-p-2">Col</div></div>
                    <div class="so-col-4"><div class="so-bg-success so-text-white so-p-2">Col</div></div>
                    <div class="so-col-4"><div class="so-bg-warning so-text-dark so-p-2">Col</div></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('row-gutters', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// No gutters
UiEngine::row()
    ->gutter(0)
    ->col('A', 4)
    ->col('B', 4)
    ->col('C', 4);

// Large gutters
UiEngine::row()
    ->gutter(4)
    ->col('A', 4)
    ->col('B', 4)
    ->col('C', 4);

// No gutters
UiEngine::row()
    ->noGutter()
    ->col('A', 6)
    ->col('B', 6)
    ->col('C', 6)
    ->col('D', 6);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// No gutters
UiEngine.row()
    .gutter(0)
    .col('A', 4)
    .col('B', 4)
    .col('C', 4);

// Large gutters
UiEngine.row()
    .gutter(4)
    .col('A', 4)
    .col('B', 4)
    .col('C', 4);

// No gutters
UiEngine.row()
    .noGutter()
    .col('A', 6)
    .col('B', 6)
    .col('C', 6)
    .col('D', 6);"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Vertical Alignment -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Vertical Alignment</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-align-items-center so-bg-light so-mb-4" style="height:100px;">
                    <div class="so-col so-bg-primary so-text-white so-p-2">Centered</div>
                    <div class="so-col so-bg-success so-text-white so-p-2">Centered</div>
                    <div class="so-col so-bg-info so-text-white so-p-2">Centered</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('row-align', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Align items to start (top)
UiEngine::row()
    ->alignItems('start')
    ->col('Top aligned');

// Align items to center
UiEngine::row()
    ->alignItems('center')
    ->col('Center aligned');

// Align items to end (bottom)
UiEngine::row()
    ->alignItems('end')
    ->col('Bottom aligned');

// Shorthand methods
UiEngine::row()->alignStart();   // Same as alignItems('start')
UiEngine::row()->alignCenter();  // Same as alignItems('center')
UiEngine::row()->alignEnd();     // Same as alignItems('end')"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Align items to start (top)
UiEngine.row()
    .alignItems('start')
    .col('Top aligned');

// Align items to center
UiEngine.row()
    .alignItems('center')
    .col('Center aligned');

// Align items to end (bottom)
UiEngine.row()
    .alignItems('end')
    .col('Bottom aligned');

// Shorthand methods
UiEngine.row().alignStart();
UiEngine.row().alignCenter();
UiEngine.row().alignEnd();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Horizontal Alignment -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Horizontal Alignment</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-justify-content-center so-mb-3">
                    <div class="so-col-3 so-bg-primary so-text-white so-p-2">Centered</div>
                    <div class="so-col-3 so-bg-primary so-text-white so-p-2">Centered</div>
                </div>
                <div class="so-row so-justify-content-between so-mb-4">
                    <div class="so-col-3 so-bg-success so-text-white so-p-2">Left</div>
                    <div class="so-col-3 so-bg-success so-text-white so-p-2">Right</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('row-justify', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Justify to start (left)
UiEngine::row()
    ->justifyContent('start')
    ->col('A', 3)
    ->col('B', 3);

// Justify to center
UiEngine::row()
    ->justifyContent('center')
    ->col('A', 3)
    ->col('B', 3);

// Justify to end (right)
UiEngine::row()
    ->justifyContent('end')
    ->col('A', 3)
    ->col('B', 3);

// Shorthand methods
UiEngine::row()->justifyStart();    // start
UiEngine::row()->justifyCenter();   // center
UiEngine::row()->justifyEnd();      // end
UiEngine::row()->justifyBetween();  // space-between
UiEngine::row()->justifyAround();   // space-around"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Justify to start (left)
UiEngine.row()
    .justifyContent('start')
    .col('A', 3)
    .col('B', 3);

// Justify to center
UiEngine.row()
    .justifyContent('center')
    .col('A', 3)
    .col('B', 3);

// Shorthand methods
UiEngine.row().justifyStart();
UiEngine.row().justifyCenter();
UiEngine.row().justifyBetween();"
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
                                <td><code>col()</code></td>
                                <td><code>mixed $content, int|array $width</code></td>
                                <td>Add column with content and optional width</td>
                            </tr>
                            <tr>
                                <td><code>cols()</code></td>
                                <td><code>array $columns</code></td>
                                <td>Add multiple columns at once</td>
                            </tr>
                            <tr>
                                <td><code>gutter()</code></td>
                                <td><code>int $size</code></td>
                                <td>Set gutter spacing (0-5)</td>
                            </tr>
                                                        <tr>
                                <td><code>alignItems()</code></td>
                                <td><code>string $alignment</code></td>
                                <td>Vertical align: start, center, end, stretch, baseline</td>
                            </tr>
                            <tr>
                                <td><code>justifyContent()</code></td>
                                <td><code>string $justify</code></td>
                                <td>Horizontal: start, center, end, between, around</td>
                            </tr>
                            <tr>
                                <td><code>noGutter()</code></td>
                                <td>-</td>
                                <td>Remove gutter spacing</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
