<?php
/**
 * SixOrbit UI Engine - Divider Element Demo
 */

$pageTitle = 'Divider - UI Engine';
$pageDescription = 'Horizontal and vertical content separators';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Divider</h1>
            <p class="so-page-subtitle">Horizontal and vertical separators to divide content into sections.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Divider -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Divider</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <p>Content above the divider</p>
                <hr class="so-my-4">
                <p class="so-mb-4">Content below the divider</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-divider', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

echo '<p>Content above the divider</p>';
echo UiEngine::divider()->render();
echo '<p>Content below the divider</p>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const divider = UiEngine.divider();

document.getElementById('container').innerHTML =
    '<p>Content above</p>' +
    divider.toHtml() +
    '<p>Content below</p>';"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<p>Content above the divider</p>
<hr class="so-my-4">
<p>Content below the divider</p>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Divider with Text -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Divider with Text</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-align-items-center so-my-4">
                    <hr class="so-flex-grow-1">
                    <span class="so-px-3 so-text-muted">OR</span>
                    <hr class="so-flex-grow-1">
                </div>
                <div class="so-d-flex so-align-items-center so-my-4 so-mb-4">
                    <hr class="so-flex-grow-1">
                    <span class="so-px-3 so-text-muted">Continue with</span>
                    <hr class="so-flex-grow-1">
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('divider-text', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Divider with centered text
echo UiEngine::divider()
    ->text('OR')
    ->render();

// With custom text
echo UiEngine::divider()
    ->text('Continue with')
    ->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Divider with centered text
const divider = UiEngine.divider()
    .text('OR');

// With custom text
const divider2 = UiEngine.divider()
    .text('Continue with');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Text Alignment -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Text Alignment</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-align-items-center so-my-4">
                    <span class="so-pe-3 so-text-muted">Left aligned</span>
                    <hr class="so-flex-grow-1">
                </div>
                <div class="so-d-flex so-align-items-center so-my-4">
                    <hr class="so-flex-grow-1">
                    <span class="so-px-3 so-text-muted">Center aligned</span>
                    <hr class="so-flex-grow-1">
                </div>
                <div class="so-d-flex so-align-items-center so-my-4 so-mb-4">
                    <hr class="so-flex-grow-1">
                    <span class="so-ps-3 so-text-muted">Right aligned</span>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('divider-align', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Left aligned text
UiEngine::divider()
    ->text('Left aligned')
    ->textPosition('left');

// Center aligned (default)
UiEngine::divider()
    ->text('Center aligned')
    ->textPosition('center');

// Right aligned
UiEngine::divider()
    ->text('Right aligned')
    ->textPosition('right');

// Shorthand methods
UiEngine::divider()->text('...')->textLeft();
UiEngine::divider()->text('...')->textCenter();
UiEngine::divider()->text('...')->textRight();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Left aligned text
UiEngine.divider()
    .text('Left aligned')
    .textPosition('left');

// Center aligned (default)
UiEngine.divider()
    .text('Center aligned')
    .textPosition('center');

// Right aligned
UiEngine.divider()
    .text('Right aligned')
    .textPosition('right');

// Shorthand methods
UiEngine.divider().text('...').textLeft();
UiEngine.divider().text('...').textRight();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Divider Styles -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Divider Styles</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <p class="so-text-muted so-small">Solid (default):</p>
                <hr class="so-my-2">
                <p class="so-text-muted so-small so-mt-4">Dashed:</p>
                <hr class="so-my-2" style="border-style:dashed;">
                <p class="so-text-muted so-small so-mt-4">Dotted:</p>
                <hr class="so-my-2" style="border-style:dotted;">
                <p class="so-text-muted so-small so-mt-4">Thick:</p>
                <hr class="so-my-2 so-mb-4" style="border-width:3px;">

                <!-- Code Tabs -->
                <?= so_code_tabs('divider-styles', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Solid line (default variant)
UiEngine::divider()
    ->variant('line');

// Dashed line
UiEngine::divider()
    ->variant('dashed');

// Dotted line
UiEngine::divider()
    ->variant('dotted');

// Shorthand methods
UiEngine::divider()->dashed();
UiEngine::divider()->dotted();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Solid line (default variant)
UiEngine.divider()
    .variant('line');

// Dashed line
UiEngine.divider()
    .variant('dashed');

// Dotted line
UiEngine.divider()
    .variant('dotted');

// Shorthand methods
UiEngine.divider().dashed();
UiEngine.divider().dotted();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Colored Dividers -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Colored Dividers</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <hr class="so-my-3 so-border-primary" style="border-color:var(--so-primary)!important;opacity:1;">
                <hr class="so-my-3" style="border-color:var(--so-success)!important;opacity:1;">
                <hr class="so-my-3" style="border-color:var(--so-danger)!important;opacity:1;">
                <hr class="so-my-3 so-mb-4" style="border-color:var(--so-warning)!important;opacity:1;">

                <!-- Code Tabs -->
                <?= so_code_tabs('divider-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Colored dividers use custom classes or inline styles
// The Divider element doesn't have a color method

// Add custom class for border color
UiEngine::divider()
    ->addClass('so-border-primary');

// Or use inline style
UiEngine::divider()
    ->style('border-color: var(--so-success) !important; opacity: 1');

// For custom hex colors
UiEngine::divider()
    ->style('border-color: #ff5722 !important; opacity: 1');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Colored dividers use custom classes or inline styles

// Add custom class for border color
UiEngine.divider()
    .addClass('so-border-primary');

// Or use inline style
UiEngine.divider()
    .style('border-color: var(--so-success) !important; opacity: 1');

// For custom hex colors
UiEngine.divider()
    .style('border-color: #ff5722 !important; opacity: 1');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Vertical Divider -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Vertical Divider</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-align-items-center so-mb-4" style="height:100px;">
                    <div class="so-p-3">Left content</div>
                    <div class="so-vr so-mx-3"></div>
                    <div class="so-p-3">Right content</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('divider-vertical', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Vertical dividers use the so-vr CSS class
// The UiEngine divider is horizontal by default

// For vertical dividers, use raw HTML with the so-vr class
echo '<div class=\"so-d-flex so-align-items-center\" style=\"height:100px\">';
echo '<div>Left content</div>';
echo '<div class=\"so-vr so-mx-3\"></div>';
echo '<div>Right content</div>';
echo '</div>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Vertical dividers use the so-vr CSS class
// The UiEngine divider is horizontal by default

// For vertical dividers, use raw HTML with the so-vr class
container.innerHTML = `
    <div class='so-d-flex so-align-items-center' style='height:100px'>
        <div>Left content</div>
        <div class='so-vr so-mx-3'></div>
        <div>Right content</div>
    </div>
`;"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Spacing -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Spacing</h3>
            </div>
            <div class="so-card-body">
                <!-- Code Tabs -->
                <?= so_code_tabs('divider-spacing', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small spacing
UiEngine::divider()
    ->spacing('sm');

// Medium spacing (default)
UiEngine::divider()
    ->spacing('md');

// Large spacing
UiEngine::divider()
    ->spacing('lg');

// Extra large spacing
UiEngine::divider()
    ->spacing('xl');

// Shorthand methods
UiEngine::divider()->small();       // spacing('sm')
UiEngine::divider()->large();       // spacing('lg')
UiEngine::divider()->extraLarge();  // spacing('xl')"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small spacing
UiEngine.divider()
    .spacing('sm');

// Medium spacing (default)
UiEngine.divider()
    .spacing('md');

// Large spacing
UiEngine.divider()
    .spacing('lg');

// Extra large spacing
UiEngine.divider()
    .spacing('xl');

// Shorthand methods
UiEngine.divider().small();
UiEngine.divider().large();
UiEngine.divider().extraLarge();"
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
                                <td><code>text()</code></td>
                                <td><code>string $text</code></td>
                                <td>Add text label to divider</td>
                            </tr>
                            <tr>
                                <td><code>textPosition()</code></td>
                                <td><code>string $position</code></td>
                                <td>Text position: left, center, right</td>
                            </tr>
                            <tr>
                                <td><code>textLeft()</code>, <code>textCenter()</code>, <code>textRight()</code></td>
                                <td>-</td>
                                <td>Shorthand for text position</td>
                            </tr>
                            <tr>
                                <td><code>variant()</code></td>
                                <td><code>string $variant</code></td>
                                <td>Line style: line, dashed, dotted</td>
                            </tr>
                            <tr>
                                <td><code>dashed()</code>, <code>dotted()</code></td>
                                <td>-</td>
                                <td>Shorthand for variant</td>
                            </tr>
                            <tr>
                                <td><code>spacing()</code></td>
                                <td><code>string $size</code></td>
                                <td>Vertical margin: sm, md, lg, xl</td>
                            </tr>
                            <tr>
                                <td><code>small()</code>, <code>large()</code>, <code>extraLarge()</code></td>
                                <td>-</td>
                                <td>Shorthand for spacing size</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
