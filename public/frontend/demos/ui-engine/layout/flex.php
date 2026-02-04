<?php
/**
 * SixOrbit UI Engine - Flex Element Demo
 */

$pageTitle = 'Flex - UI Engine';
$pageDescription = 'Flexbox-based layout utilities';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Flex</h1>
            <p class="so-page-subtitle">Flexible box layout for one-dimensional layouts with powerful alignment control.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Flex -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Flex Container</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-3 so-mb-4">
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 1</div>
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 2</div>
                    <div class="so-bg-primary so-text-white so-p-3 so-rounded">Item 3</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-flex', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$flex = UiEngine::flex()
    ->gap(3);

// Add children with add()
\$flex->add('<div>Item 1</div>');
\$flex->add('<div>Item 2</div>');
\$flex->add('<div>Item 3</div>');

echo \$flex->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const flex = UiEngine.flex()
    .gap(3);

// Add children with add()
flex.add('<div>Item 1</div>');
flex.add('<div>Item 2</div>');
flex.add('<div>Item 3</div>');

document.getElementById('container').innerHTML = flex.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-d-flex so-gap-3">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Flex Direction -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Flex Direction</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <p class="so-text-muted so-small">Row (default):</p>
                <div class="so-d-flex so-flex-row so-gap-2 so-mb-4">
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded">3</div>
                </div>
                <p class="so-text-muted so-small">Column:</p>
                <div class="so-d-flex so-flex-column so-gap-2 so-mb-4">
                    <div class="so-bg-success so-text-white so-p-2 so-rounded">1</div>
                    <div class="so-bg-success so-text-white so-p-2 so-rounded">2</div>
                    <div class="so-bg-success so-text-white so-p-2 so-rounded">3</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('flex-direction', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Horizontal row (default)
\$flex = UiEngine::flex()->direction('row');
\$flex->add('<div>1</div>')->add('<div>2</div>')->add('<div>3</div>');

// Or use shorthand methods
UiEngine::flex()->row();      // Same as direction('row')
UiEngine::flex()->rowReverse();

// Vertical column
UiEngine::flex()->column();   // Same as direction('column')
UiEngine::flex()->columnReverse();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Horizontal row (default)
const flex = UiEngine.flex().direction('row');
flex.add('<div>1</div>').add('<div>2</div>').add('<div>3</div>');

// Or use shorthand methods
UiEngine.flex().row();
UiEngine.flex().rowReverse();

// Vertical column
UiEngine.flex().column();
UiEngine.flex().columnReverse();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Justify Content -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Justify Content (Main Axis)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <p class="so-text-muted so-small">Start:</p>
                <div class="so-d-flex so-justify-content-start so-gap-2 so-mb-3 so-bg-light so-p-2 so-rounded">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">A</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">B</div>
                </div>
                <p class="so-text-muted so-small">Center:</p>
                <div class="so-d-flex so-justify-content-center so-gap-2 so-mb-3 so-bg-light so-p-2 so-rounded">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">A</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">B</div>
                </div>
                <p class="so-text-muted so-small">End:</p>
                <div class="so-d-flex so-justify-content-end so-gap-2 so-mb-3 so-bg-light so-p-2 so-rounded">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">A</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">B</div>
                </div>
                <p class="so-text-muted so-small">Space Between:</p>
                <div class="so-d-flex so-justify-content-between so-mb-3 so-bg-light so-p-2 so-rounded">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">A</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">B</div>
                </div>
                <p class="so-text-muted so-small">Space Around:</p>
                <div class="so-d-flex so-justify-content-around so-bg-light so-p-2 so-rounded so-mb-4">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">A</div>
                    <div class="so-bg-info so-text-white so-p-2 so-rounded">B</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('flex-justify', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Justify content options
UiEngine::flex()->justify('start');    // Align to start (left)
UiEngine::flex()->justify('center');   // Align to center
UiEngine::flex()->justify('end');      // Align to end (right)
UiEngine::flex()->justify('between');  // Space between items
UiEngine::flex()->justify('around');   // Space around items
UiEngine::flex()->justify('evenly');   // Space evenly

// Shorthand methods
UiEngine::flex()->justifyStart();
UiEngine::flex()->justifyCenter();
UiEngine::flex()->justifyEnd();
UiEngine::flex()->justifyBetween();
UiEngine::flex()->justifyAround();
UiEngine::flex()->justifyEvenly();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Justify content options
UiEngine.flex().justify('start');
UiEngine.flex().justify('center');
UiEngine.flex().justify('end');
UiEngine.flex().justify('between');
UiEngine.flex().justify('around');
UiEngine.flex().justify('evenly');

// Shorthand methods
UiEngine.flex().justifyStart();
UiEngine.flex().justifyCenter();
UiEngine.flex().justifyBetween();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Align Items -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Align Items (Cross Axis)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-gap-3 so-mb-4">
                    <div>
                        <p class="so-text-muted so-small">Start:</p>
                        <div class="so-d-flex so-align-items-start so-gap-2 so-bg-light so-p-2 so-rounded" style="height:100px;">
                            <div class="so-bg-warning so-text-dark so-p-2 so-rounded">A</div>
                            <div class="so-bg-warning so-text-dark so-p-2 so-rounded" style="padding:1.5rem!important;">B</div>
                        </div>
                    </div>
                    <div>
                        <p class="so-text-muted so-small">Center:</p>
                        <div class="so-d-flex so-align-items-center so-gap-2 so-bg-light so-p-2 so-rounded" style="height:100px;">
                            <div class="so-bg-warning so-text-dark so-p-2 so-rounded">A</div>
                            <div class="so-bg-warning so-text-dark so-p-2 so-rounded" style="padding:1.5rem!important;">B</div>
                        </div>
                    </div>
                    <div>
                        <p class="so-text-muted so-small">End:</p>
                        <div class="so-d-flex so-align-items-end so-gap-2 so-bg-light so-p-2 so-rounded" style="height:100px;">
                            <div class="so-bg-warning so-text-dark so-p-2 so-rounded">A</div>
                            <div class="so-bg-warning so-text-dark so-p-2 so-rounded" style="padding:1.5rem!important;">B</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('flex-align', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Align items options (cross axis)
UiEngine::flex()->align('start');     // Align to top
UiEngine::flex()->align('center');    // Align to center
UiEngine::flex()->align('end');       // Align to bottom
UiEngine::flex()->align('stretch');   // Stretch to fill (default)
UiEngine::flex()->align('baseline');  // Align to baseline

// Shorthand methods
UiEngine::flex()->alignStart();
UiEngine::flex()->alignCenter();
UiEngine::flex()->alignEnd();
UiEngine::flex()->alignStretch();
UiEngine::flex()->alignBaseline();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Align items options (cross axis)
UiEngine.flex().align('start');
UiEngine.flex().align('center');
UiEngine.flex().align('end');
UiEngine.flex().align('stretch');
UiEngine.flex().align('baseline');

// Shorthand methods
UiEngine.flex().alignStart();
UiEngine.flex().alignCenter();
UiEngine.flex().alignEnd();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Flex Wrap -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Flex Wrap</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4" style="width:300px;">
                    <div class="so-bg-danger so-text-white so-p-3 so-rounded" style="width:100px;">1</div>
                    <div class="so-bg-danger so-text-white so-p-3 so-rounded" style="width:100px;">2</div>
                    <div class="so-bg-danger so-text-white so-p-3 so-rounded" style="width:100px;">3</div>
                    <div class="so-bg-danger so-text-white so-p-3 so-rounded" style="width:100px;">4</div>
                    <div class="so-bg-danger so-text-white so-p-3 so-rounded" style="width:100px;">5</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('flex-wrap', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Wrap options
UiEngine::flex()->wrap('nowrap');       // No wrap (default) - items shrink
UiEngine::flex()->wrap('wrap');         // Wrap to next line
UiEngine::flex()->wrap('wrap-reverse'); // Wrap reverse

// Shorthand methods
UiEngine::flex()->nowrap();
UiEngine::flex()->wrap();        // Defaults to 'wrap'
UiEngine::flex()->wrapReverse();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Wrap options
UiEngine.flex().wrap('nowrap');
UiEngine.flex().wrap('wrap');
UiEngine.flex().wrap('wrap-reverse');

// Shorthand methods
UiEngine.flex().nowrap();
UiEngine.flex().wrap();
UiEngine.flex().wrapReverse();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Flex Item Properties -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Flex Item Properties</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <p class="so-text-muted so-small">Flex grow:</p>
                <div class="so-d-flex so-gap-2 so-mb-4">
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded" style="flex-grow:0;">No grow</div>
                    <div class="so-bg-success so-text-white so-p-2 so-rounded" style="flex-grow:1;">Grow</div>
                    <div class="so-bg-primary so-text-white so-p-2 so-rounded" style="flex-grow:0;">No grow</div>
                </div>
                <p class="so-text-muted so-small">Flex shrink:</p>
                <div class="so-d-flex so-gap-2 so-mb-4" style="width:250px;">
                    <div class="so-bg-info so-text-white so-p-2 so-rounded" style="flex-shrink:0;width:100px;">No shrink</div>
                    <div class="so-bg-warning so-text-dark so-p-2 so-rounded" style="flex-shrink:1;width:200px;">Shrinks</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('flex-items', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Flex item properties are applied via inline styles
\$flex = UiEngine::flex()->gap(2);

// Add items with flex grow/shrink/basis via style
\$flex->add('<div>Fixed</div>');
\$flex->add('<div style=\"flex-grow: 1\">Grows</div>');
\$flex->add('<div>Fixed</div>');

// Flex shrink
\$flex2 = UiEngine::flex();
\$flex2->add('<div style=\"flex-shrink: 0; width: 100px\">No shrink</div>');
\$flex2->add('<div style=\"flex-shrink: 1\">Can shrink</div>');

// Flex basis
\$flex3 = UiEngine::flex();
\$flex3->add('<div style=\"flex-basis: 200px\">200px base</div>');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Flex item properties are applied via inline styles
const flex = UiEngine.flex().gap(2);

flex.add('<div>Fixed</div>');
flex.add('<div style=\"flex-grow: 1\">Grows</div>');
flex.add('<div>Fixed</div>');

// Flex shrink
const flex2 = UiEngine.flex();
flex2.add('<div style=\"flex-shrink: 0; width: 100px\">No shrink</div>');
flex2.add('<div style=\"flex-shrink: 1\">Can shrink</div>');

// Flex basis
const flex3 = UiEngine.flex();
flex3.add('<div style=\"flex-basis: 200px\">200px base</div>');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Centering Content -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Centering Content</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-justify-content-center so-align-items-center so-bg-light so-rounded so-mb-4" style="height:150px;">
                    <div class="so-bg-primary so-text-white so-p-4 so-rounded">Perfectly Centered</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('flex-center', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Center both horizontally and vertically
\$flex = UiEngine::flex()
    ->justify('center')
    ->align('center')
    ->class('so-bg-light')  // Add custom classes
    ->style('height: 150px');  // Add custom styles

\$flex->add('<div>Perfectly Centered</div>');

echo \$flex->render();

// Shorthand for centering
\$flex2 = UiEngine::flex()
    ->center();  // Same as justify('center')->align('center')

\$flex2->add('<div>Centered</div>');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Center both horizontally and vertically
const flex = UiEngine.flex()
    .justify('center')
    .align('center')
    .addClass('so-bg-light')
    .style('height: 150px');

flex.add('<div>Perfectly Centered</div>');

// Shorthand
const flex2 = UiEngine.flex().center();
flex2.add('<div>Centered</div>');"
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
                                <td><code>direction()</code></td>
                                <td><code>string $dir</code></td>
                                <td>Set direction: row, row-reverse, column, column-reverse</td>
                            </tr>
                            <tr>
                                <td><code>justify()</code></td>
                                <td><code>string $justify</code></td>
                                <td>Main axis: start, center, end, between, around, evenly</td>
                            </tr>
                            <tr>
                                <td><code>align()</code></td>
                                <td><code>string $align</code></td>
                                <td>Cross axis: start, center, end, stretch, baseline</td>
                            </tr>
                            <tr>
                                <td><code>wrap()</code></td>
                                <td><code>string $wrap</code></td>
                                <td>Wrap behavior: nowrap, wrap, wrap-reverse</td>
                            </tr>
                            <tr>
                                <td><code>gap()</code></td>
                                <td><code>int $size</code></td>
                                <td>Set gap between items (0-5)</td>
                            </tr>
                            <tr>
                                <td><code>add()</code></td>
                                <td><code>mixed $content</code></td>
                                <td>Add child element to the flex container</td>
                            </tr>
                            <tr>
                                <td><code>alignContent()</code></td>
                                <td><code>string $align</code></td>
                                <td>Multi-line alignment: start, center, end, stretch</td>
                            </tr>
                            <tr>
                                <td><code>center()</code></td>
                                <td>-</td>
                                <td>Shorthand for centering both axes</td>
                            </tr>
                            <tr>
                                <td><code>inline()</code></td>
                                <td>-</td>
                                <td>Make inline-flex instead of flex</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
