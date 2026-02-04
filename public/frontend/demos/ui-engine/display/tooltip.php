<?php
/**
 * SixOrbit UI Engine - Tooltip Element Demo
 */

$pageTitle = 'Tooltip - UI Engine';
$pageDescription = 'Contextual hints on hover or focus';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Tooltip</h1>
            <p class="so-page-subtitle">Contextual hints that appear on hover or focus to provide additional information.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Tooltip -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Tooltip</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="This is a tooltip">
                        Hover over me
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-tooltip', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$button = UiEngine::button('Hover over me')
    ->tooltip('This is a tooltip');

echo \$button->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const button = UiEngine.button('Hover over me')
    .tooltip('This is a tooltip');

document.getElementById('container').innerHTML = button.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-secondary" data-so-tooltip="This is a tooltip">
    Hover over me
</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Tooltip Positions -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Tooltip Positions</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Tooltip on top">
                        Top
                    </button>
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Tooltip on right" data-so-tooltip-position="right">
                        Right
                    </button>
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Tooltip on bottom" data-so-tooltip-position="bottom">
                        Bottom
                    </button>
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Tooltip on left" data-so-tooltip-position="left">
                        Left
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tooltip-positions', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::button('Top')->tooltip('Tooltip on top');
UiEngine::button('Right')->tooltip('Tooltip on right', 'right');
UiEngine::button('Bottom')->tooltip('Tooltip on bottom', 'bottom');
UiEngine::button('Left')->tooltip('Tooltip on left', 'left');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.button('Top').tooltip('Tooltip on top');
UiEngine.button('Right').tooltip('Tooltip on right', 'right');
UiEngine.button('Bottom').tooltip('Tooltip on bottom', 'bottom');
UiEngine.button('Left').tooltip('Tooltip on left', 'left');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button data-so-tooltip="Tooltip on top">Top</button>
<button data-so-tooltip="Tooltip on right" data-so-tooltip-position="right">Right</button>
<button data-so-tooltip="Tooltip on bottom" data-so-tooltip-position="bottom">Bottom</button>
<button data-so-tooltip="Tooltip on left" data-so-tooltip-position="left">Left</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Tooltip with Keyboard Shortcuts -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Keyboard Shortcuts</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display keyboard shortcuts alongside tooltip text. Automatically adapts for Mac (⌘) and Windows (Ctrl).</p>

                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Copy" data-so-shortcut="Ctrl+C">
                        <span class="material-icons">content_copy</span> Copy
                    </button>
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Paste" data-so-shortcut="Ctrl+V">
                        <span class="material-icons">content_paste</span> Paste
                    </button>
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Save" data-so-shortcut="Ctrl+S">
                        <span class="material-icons">save</span> Save
                    </button>
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Undo" data-so-shortcut="Ctrl+Z">
                        <span class="material-icons">undo</span> Undo
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tooltip-shortcuts', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::button('Copy')
    ->icon('content_copy')
    ->tooltip('Copy')
    ->shortcut('Ctrl+C');

UiEngine::button('Save')
    ->icon('save')
    ->tooltip('Save')
    ->shortcut('Ctrl+S');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.button('Copy')
    .icon('content_copy')
    .tooltip('Copy')
    .shortcut('Ctrl+C');

UiEngine.button('Save')
    .icon('save')
    .tooltip('Save')
    .shortcut('Ctrl+S');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button data-so-tooltip="Copy" data-so-shortcut="Ctrl+C">Copy</button>
<button data-so-tooltip="Paste" data-so-shortcut="Ctrl+V">Paste</button>
<button data-so-tooltip="Save" data-so-shortcut="Ctrl+S">Save</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Tooltip on Various Elements -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">On Various Elements</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <p class="so-mb-4">
                    You can add tooltips to
                    <a href="#" data-so-tooltip="This is a link with tooltip">links</a>,
                    <span data-so-tooltip="This is a span with tooltip" class="so-text-decoration-underline" style="cursor: help;">inline text</span>,
                    and
                    <span class="so-badge so-badge-primary" data-so-tooltip="Badge tooltip">badges</span>.
                </p>

                <!-- Code Tabs -->
                <?= so_code_tabs('tooltip-elements', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// On a link
UiEngine::link('links', '#')->tooltip('This is a link with tooltip');

// On a badge
UiEngine::badge('badges')->variant('primary')->tooltip('Badge tooltip');

// Using the tooltip wrapper
UiEngine::tooltip('Hover text goes here')
    ->content('This is a span with tooltip')
    ->tag('span');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// On a link
UiEngine.link('links', '#').tooltip('This is a link with tooltip');

// On a badge
UiEngine.badge('badges').variant('primary').tooltip('Badge tooltip');

// Using the tooltip wrapper
UiEngine.tooltip('Hover text goes here')
    .content('This is a span with tooltip')
    .tag('span');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<a href="#" data-so-tooltip="This is a link with tooltip">links</a>
<span data-so-tooltip="This is a span with tooltip">inline text</span>
<span class="so-badge so-badge-primary" data-so-tooltip="Badge tooltip">badges</span>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Tooltip Themes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Tooltip Themes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Tooltips can have different color themes.</p>

                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-secondary" data-so-tooltip="Default tooltip">
                        Default
                    </button>
                    <button type="button" class="so-btn so-btn-primary" data-so-tooltip="Primary themed tooltip" data-so-tooltip-theme="primary">
                        Primary
                    </button>
                    <button type="button" class="so-btn so-btn-success" data-so-tooltip="Success themed tooltip" data-so-tooltip-theme="success">
                        Success
                    </button>
                    <button type="button" class="so-btn so-btn-danger" data-so-tooltip="Danger themed tooltip" data-so-tooltip-theme="danger">
                        Danger
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('tooltip-themes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::button('Primary')->primary()
    ->tooltip('Primary themed tooltip')
    ->tooltipTheme('primary');

UiEngine::button('Success')->success()
    ->tooltip('Success themed tooltip')
    ->tooltipTheme('success');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.button('Primary').primary()
    .tooltip('Primary themed tooltip')
    .tooltipTheme('primary');

UiEngine.button('Success').success()
    .tooltip('Success themed tooltip')
    .tooltipTheme('success');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button data-so-tooltip="Primary themed tooltip" data-so-tooltip-theme="primary">Primary</button>
<button data-so-tooltip="Success themed tooltip" data-so-tooltip-theme="success">Success</button>
<button data-so-tooltip="Danger themed tooltip" data-so-tooltip-theme="danger">Danger</button>'
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
                                <td><code>tooltip()</code></td>
                                <td><code>string $text, string $position</code></td>
                                <td>Add tooltip to element</td>
                            </tr>
                            <tr>
                                <td><code>tooltipPosition()</code></td>
                                <td><code>string $position</code></td>
                                <td>Set position: top, right, bottom, left</td>
                            </tr>
                            <tr>
                                <td><code>tooltipTheme()</code></td>
                                <td><code>string $theme</code></td>
                                <td>Set theme: primary, success, danger, warning, info</td>
                            </tr>
                            <tr>
                                <td><code>shortcut()</code></td>
                                <td><code>string $shortcut</code></td>
                                <td>Add keyboard shortcut display (e.g., "Ctrl+S")</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">HTML Attributes</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Attribute</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>data-so-tooltip</code></td>
                                <td>Tooltip text content</td>
                            </tr>
                            <tr>
                                <td><code>data-so-tooltip-position</code></td>
                                <td>Position: top (default), right, bottom, left</td>
                            </tr>
                            <tr>
                                <td><code>data-so-tooltip-theme</code></td>
                                <td>Color theme: primary, success, danger, warning, info</td>
                            </tr>
                            <tr>
                                <td><code>data-so-shortcut</code></td>
                                <td>Keyboard shortcut (e.g., "Ctrl+C", "Ctrl+Shift+P")</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
