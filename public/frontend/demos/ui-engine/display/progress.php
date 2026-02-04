<?php
/**
 * SixOrbit UI Engine - Progress Element Demo
 * Comprehensive demonstration of linear and circular progress indicators
 */

$pageTitle = 'Progress - UI Engine';
$pageDescription = 'Progress indicators for displaying completion status, loading states, and workflow steps';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Progress</h1>
            <p class="so-page-subtitle">Progress indicators for displaying completion status, loading states, and workflow steps.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Linear Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Linear Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Simple linear progress bars showing completion percentage.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div id="demo-basic-progress-1" class="so-mb-3"></div>
                    <div id="demo-basic-progress-2" class="so-mb-3"></div>
                    <div id="demo-basic-progress-3" class="so-mb-3"></div>
                    <div id="demo-basic-progress-4"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-progress', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "use Core\UiEngine\UiEngine;

echo UiEngine::progress(25)->primary();
echo UiEngine::progress(50)->primary();
echo UiEngine::progress(75)->primary();
echo UiEngine::progress(100)->primary();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().value(25).primary().toHtml();
Progress.make().value(50).primary().toHtml();
Progress.make().value(75).primary().toHtml();
Progress.make().value(100).primary().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-primary" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
    <div class="so-progress-bar" style="width: 25%"></div>
</div>
<div class="so-progress so-progress-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="so-progress-bar" style="width: 50%"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Eight color variants to match your design system and indicate different states.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-progress so-progress-primary so-mb-2">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="so-progress so-progress-secondary so-mb-2">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="so-progress so-progress-success so-mb-2">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="so-progress so-progress-danger so-mb-2">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="so-progress so-progress-warning so-mb-2">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="so-progress so-progress-info so-mb-2">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="so-progress so-progress-light so-mb-2">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="so-progress so-progress-dark">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress(70)->primary();
UiEngine::progress(70)->secondary();
UiEngine::progress(70)->success();
UiEngine::progress(70)->danger();
UiEngine::progress(70)->warning();
UiEngine::progress(70)->info();
UiEngine::progress(70)->light();
UiEngine::progress(70)->dark();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().value(70).primary().toHtml();
Progress.make().value(70).secondary().toHtml();
Progress.make().value(70).success().toHtml();
Progress.make().value(70).danger().toHtml();
Progress.make().value(70).warning().toHtml();
Progress.make().value(70).info().toHtml();
Progress.make().value(70).light().toHtml();
Progress.make().value(70).dark().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-primary">
    <div class="so-progress-bar" style="width: 70%"></div>
</div>
<div class="so-progress so-progress-secondary">
    <div class="so-progress-bar" style="width: 70%"></div>
</div>
<div class="so-progress so-progress-success">
    <div class="so-progress-bar" style="width: 70%"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Progress bars in five sizes: extra small (4px), small (8px), default (12px), large (16px), and extra large (20px).</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Extra Small (4px)</label>
                        <div class="so-progress so-progress-xs so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>
                    <div class="so-mb-3">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Small (8px)</label>
                        <div class="so-progress so-progress-sm so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>
                    <div class="so-mb-3">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Default (12px)</label>
                        <div class="so-progress so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>
                    <div class="so-mb-3">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Large (16px)</label>
                        <div class="so-progress so-progress-lg so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Extra Large (20px)</label>
                        <div class="so-progress so-progress-xl so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress(60)->primary()->extraSmall();  // or ->size('xs')
UiEngine::progress(60)->primary()->small();       // or ->size('sm')
UiEngine::progress(60)->primary();                // Default (no size)
UiEngine::progress(60)->primary()->large();       // or ->size('lg')
UiEngine::progress(60)->primary()->extraLarge();  // or ->size('xl')"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().value(60).primary().extraSmall().toHtml();
Progress.make().value(60).primary().small().toHtml();
Progress.make().value(60).primary().toHtml();
Progress.make().value(60).primary().large().toHtml();
Progress.make().value(60).primary().extraLarge().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-xs so-progress-primary">...</div>
<div class="so-progress so-progress-sm so-progress-primary">...</div>
<div class="so-progress so-progress-primary">...</div>
<div class="so-progress so-progress-lg so-progress-primary">...</div>
<div class="so-progress so-progress-xl so-progress-primary">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Progress with Labels -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Progress with Labels</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display percentage or custom text inside the progress bar.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-progress so-progress-lg so-progress-primary so-mb-3">
                        <div class="so-progress-bar" style="width: 25%">
                            <span class="so-progress-label">25%</span>
                        </div>
                    </div>
                    <div class="so-progress so-progress-lg so-progress-success so-mb-3">
                        <div class="so-progress-bar" style="width: 50%">
                            <span class="so-progress-label">50%</span>
                        </div>
                    </div>
                    <div class="so-progress so-progress-lg so-progress-info so-mb-3">
                        <div class="so-progress-bar" style="width: 75%">
                            <span class="so-progress-label">75%</span>
                        </div>
                    </div>
                    <div class="so-progress so-progress-lg so-progress-danger">
                        <div class="so-progress-bar" style="width: 100%">
                            <span class="so-progress-label">Complete!</span>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-labels', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Show percentage label
UiEngine::progress(25)->primary()->large()->showLabel();

// Custom label text
UiEngine::progress(100)->danger()->large()->showLabel(true, 'Complete!');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Show percentage label
Progress.make().value(25).primary().large().showLabel().toHtml();

// Custom label text
Progress.make().value(100).danger().large().showLabel(true, 'Complete!').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-lg so-progress-primary">
    <div class="so-progress-bar" style="width: 25%">
        <span class="so-progress-label">25%</span>
    </div>
</div>
<div class="so-progress so-progress-lg so-progress-danger">
    <div class="so-progress-bar" style="width: 100%">
        <span class="so-progress-label">Complete!</span>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Striped Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Striped Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add diagonal stripes to the progress bar for visual interest.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-progress so-progress-striped so-progress-primary so-mb-3">
                        <div class="so-progress-bar" style="width: 60%"></div>
                    </div>
                    <div class="so-progress so-progress-striped so-progress-success so-mb-3">
                        <div class="so-progress-bar" style="width: 50%"></div>
                    </div>
                    <div class="so-progress so-progress-striped so-progress-warning so-mb-3">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="so-progress so-progress-striped so-progress-danger">
                        <div class="so-progress-bar" style="width: 40%"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-striped', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress(60)->primary()->striped();
UiEngine::progress(50)->success()->striped();
UiEngine::progress(70)->warning()->striped();
UiEngine::progress(40)->danger()->striped();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().value(60).primary().striped().toHtml();
Progress.make().value(50).success().striped().toHtml();
Progress.make().value(70).warning().striped().toHtml();
Progress.make().value(40).danger().striped().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-striped so-progress-primary">
    <div class="so-progress-bar" style="width: 60%"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Animated Stripes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Animated Stripes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Animate the stripes for an active loading effect. Animation automatically enables stripes.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-progress so-progress-striped so-progress-animated so-progress-primary so-mb-3">
                        <div class="so-progress-bar" style="width: 75%"></div>
                    </div>
                    <div class="so-progress so-progress-striped so-progress-animated so-progress-success so-mb-3">
                        <div class="so-progress-bar" style="width: 60%"></div>
                    </div>
                    <div class="so-progress so-progress-striped so-progress-animated so-progress-info">
                        <div class="so-progress-bar" style="width: 85%"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-animated', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// animated() automatically enables striped
UiEngine::progress(75)->primary()->animated();
UiEngine::progress(60)->success()->animated();
UiEngine::progress(85)->info()->animated();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// animated() automatically enables striped
Progress.make().value(75).primary().animated().toHtml();
Progress.make().value(60).success().animated().toHtml();
Progress.make().value(85).info().animated().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-striped so-progress-animated so-progress-primary">
    <div class="so-progress-bar" style="width: 75%"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Indeterminate Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Indeterminate Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Use when you cannot estimate how long an operation will take.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-progress so-progress-indeterminate so-progress-primary so-mb-3">
                        <div class="so-progress-bar" style="width: 0%"></div>
                    </div>
                    <div class="so-progress so-progress-indeterminate so-progress-success so-mb-3">
                        <div class="so-progress-bar" style="width: 0%"></div>
                    </div>
                    <div class="so-progress so-progress-indeterminate so-progress-warning">
                        <div class="so-progress-bar" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-indeterminate', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress()->indeterminate()->primary();
UiEngine::progress()->indeterminate()->success();
UiEngine::progress()->indeterminate()->warning();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().indeterminate().primary().toHtml();
Progress.make().indeterminate().success().toHtml();
Progress.make().indeterminate().warning().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-indeterminate so-progress-primary">
    <div class="so-progress-bar" style="width: 0%"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Buffer Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Buffer Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Show both loaded and buffered values, commonly used for video/audio playback.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-progress so-progress-buffer so-progress-primary so-mb-3">
                        <div class="so-progress-bar" style="width: 35%"></div>
                        <div class="so-progress-buffer-bar" style="width: 65%"></div>
                    </div>
                    <div class="so-progress so-progress-buffer so-progress-success so-mb-3">
                        <div class="so-progress-bar" style="width: 50%"></div>
                        <div class="so-progress-buffer-bar" style="width: 80%"></div>
                    </div>
                    <div class="so-progress so-progress-buffer so-progress-info">
                        <div class="so-progress-bar" style="width: 25%"></div>
                        <div class="so-progress-buffer-bar" style="width: 55%"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-buffer', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// value() = loaded, buffer() = buffered
UiEngine::progress(35)->buffer(65)->primary();
UiEngine::progress(50)->buffer(80)->success();
UiEngine::progress(25)->buffer(55)->info();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// value() = loaded, buffer() = buffered
Progress.make().value(35).buffer(65).primary().toHtml();
Progress.make().value(50).buffer(80).success().toHtml();
Progress.make().value(25).buffer(55).info().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-buffer so-progress-primary">
    <div class="so-progress-bar" style="width: 35%"></div>
    <div class="so-progress-buffer-bar" style="width: 65%"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Stacked Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Stacked Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Stack multiple progress segments to show distributed data or multiple metrics.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Disk Usage Distribution</label>
                    <div class="so-progress so-progress-stacked so-mb-2">
                        <div class="so-progress so-progress-success" style="width: 25%">
                            <div class="so-progress-bar" style="width: 100%">
                                <span class="so-progress-label">Documents</span>
                            </div>
                        </div>
                        <div class="so-progress so-progress-warning" style="width: 35%">
                            <div class="so-progress-bar" style="width: 100%">
                                <span class="so-progress-label">Media</span>
                            </div>
                        </div>
                        <div class="so-progress so-progress-danger" style="width: 15%">
                            <div class="so-progress-bar" style="width: 100%">
                                <span class="so-progress-label">System</span>
                            </div>
                        </div>
                    </div>
                    <div class="so-d-flex so-gap-4 so-text-sm">
                        <span><span class="so-badge so-badge-success so-me-1"></span> Documents (25%)</span>
                        <span><span class="so-badge so-badge-warning so-me-1"></span> Media (35%)</span>
                        <span><span class="so-badge so-badge-danger so-me-1"></span> System (15%)</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-stacked', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$progress = UiEngine::progress()
    ->segment(25, 'success', 'Documents')
    ->segment(35, 'warning', 'Media')
    ->segment(15, 'danger', 'System');

echo \$progress->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const progress = Progress.make()
    .segment(25, 'success', 'Documents')
    .segment(35, 'warning', 'Media')
    .segment(15, 'danger', 'System');

document.getElementById('container').innerHTML = progress.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-stacked">
    <div class="so-progress so-progress-success" style="width: 25%">
        <div class="so-progress-bar" style="width: 100%">
            <span class="so-progress-label">Documents</span>
        </div>
    </div>
    <div class="so-progress so-progress-warning" style="width: 35%">
        <div class="so-progress-bar" style="width: 100%">
            <span class="so-progress-label">Media</span>
        </div>
    </div>
    <div class="so-progress so-progress-danger" style="width: 15%">
        <div class="so-progress-bar" style="width: 100%">
            <span class="so-progress-label">System</span>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Stepped Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Stepped Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Discrete steps for multi-stage processes with optional partial completion.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">4-Step Process (Step 3 Active, 60% Complete)</label>
                    <div class="so-progress so-progress-stepped so-mb-3">
                        <div class="so-progress-step so-active">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step so-active">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step so-active partial" style="--step-progress: 60%">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step">
                            <div class="so-progress-step-fill"></div>
                        </div>
                    </div>

                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">5-Step Workflow (3 of 5 Complete)</label>
                    <div class="so-progress so-progress-stepped">
                        <div class="so-progress-step so-active">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step so-active">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step so-active">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step">
                            <div class="so-progress-step-fill"></div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-stepped', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// step(active, partial)
\$progress = UiEngine::progress()
    ->step(true)      // Complete
    ->step(true)      // Complete
    ->step(true, 60)  // Partial (60%)
    ->step(false);    // Inactive

echo \$progress->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// step(active, partial)
const progress = Progress.make()
    .step(true)      // Complete
    .step(true)      // Complete
    .step(true, 60)  // Partial (60%)
    .step(false);    // Inactive

document.getElementById('container').innerHTML = progress.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-stepped">
    <div class="so-progress-step so-active">
        <div class="so-progress-step-fill"></div>
    </div>
    <div class="so-progress-step so-active">
        <div class="so-progress-step-fill"></div>
    </div>
    <div class="so-progress-step so-active partial" style="--step-progress: 60%">
        <div class="so-progress-step-fill"></div>
    </div>
    <div class="so-progress-step">
        <div class="so-progress-step-fill"></div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Gradient Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Gradient Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Apply gradient effects to progress bars for modern, vibrant designs.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-progress so-progress-gradient so-mb-3">
                        <div class="so-progress-bar" style="width: 65%"></div>
                    </div>
                    <div class="so-progress so-progress-gradient so-progress-striped so-mb-3">
                        <div class="so-progress-bar" style="width: 75%"></div>
                    </div>
                    <div class="so-progress so-progress-gradient so-progress-striped so-progress-animated">
                        <div class="so-progress-bar" style="width: 85%"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-gradient', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress(65)->gradient();
UiEngine::progress(75)->gradient()->striped();
UiEngine::progress(85)->gradient()->animated();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().value(65).gradient().toHtml();
Progress.make().value(75).gradient().striped().toHtml();
Progress.make().value(85).gradient().animated().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress so-progress-gradient">
    <div class="so-progress-bar" style="width: 65%"></div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Progress with External Label -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Progress with External Label</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display title and value information above the progress bar.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-progress-wrapper so-mb-4">
                        <div class="so-progress-header">
                            <span class="so-progress-title">Uploading file...</span>
                            <span class="so-progress-value">68%</span>
                        </div>
                        <div class="so-progress so-progress-primary">
                            <div class="so-progress-bar" style="width: 68%"></div>
                        </div>
                    </div>
                    <div class="so-progress-wrapper">
                        <div class="so-progress-header">
                            <span class="so-progress-title">Storage Used</span>
                            <span class="so-progress-value">7.5 GB / 10 GB</span>
                        </div>
                        <div class="so-progress so-progress-warning">
                            <div class="so-progress-bar" style="width: 75%"></div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-external-label', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress(68)
    ->primary()
    ->externalLabel('Uploading file...', '68%');

UiEngine::progress(75)
    ->warning()
    ->externalLabel('Storage Used', '7.5 GB / 10 GB');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().value(68)
    .primary()
    .externalLabel('Uploading file...', '68%')
    .toHtml();

Progress.make().value(75)
    .warning()
    .externalLabel('Storage Used', '7.5 GB / 10 GB')
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress-wrapper">
    <div class="so-progress-header">
        <span class="so-progress-title">Uploading file...</span>
        <span class="so-progress-value">68%</span>
    </div>
    <div class="so-progress so-progress-primary">
        <div class="so-progress-bar" style="width: 68%"></div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Circular Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Circular Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Circular progress indicators with determinate and indeterminate variants.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap">
                        <div class="so-progress-circular so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="94.25"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-success">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="62.83"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-warning">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="31.42"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-danger">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="0"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-circular', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress(25)->circular()->primary();
UiEngine::progress(50)->circular()->success();
UiEngine::progress(75)->circular()->warning();
UiEngine::progress(100)->circular()->danger();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().value(25).circular().primary().toHtml();
Progress.make().value(50).circular().success().toHtml();
Progress.make().value(75).circular().warning().toHtml();
Progress.make().value(100).circular().danger().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress-circular so-progress-circular-primary">
    <svg class="so-progress-ring" viewBox="0 0 48 48">
        <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
        <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                stroke-dasharray="125.66" stroke-dashoffset="94.25"></circle>
    </svg>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Circular Progress with Label -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Circular Progress with Label</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display percentage or custom text in the center of circular progress.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap">
                        <div class="so-progress-circular so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="81.64"></circle>
                            </svg>
                            <span class="so-progress-text">35%</span>
                        </div>
                        <div class="so-progress-circular so-progress-circular-success">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="43.98"></circle>
                            </svg>
                            <span class="so-progress-text">65%</span>
                        </div>
                        <div class="so-progress-circular so-progress-circular-info">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="18.85"></circle>
                            </svg>
                            <span class="so-progress-text">85%</span>
                        </div>
                        <div class="so-progress-circular so-progress-circular-danger">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="0"></circle>
                            </svg>
                            <span class="so-progress-text">✓</span>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-circular-label', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Show percentage
UiEngine::progress(35)->circular()->primary()->showLabel();

// Custom label
UiEngine::progress(100)->circular()->danger()->showLabel(true, '✓');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Show percentage
Progress.make().value(35).circular().primary().showLabel().toHtml();

// Custom label
Progress.make().value(100).circular().danger().showLabel(true, '✓').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress-circular so-progress-circular-primary">
    <svg class="so-progress-ring" viewBox="0 0 48 48">
        <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
        <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
    </svg>
    <span class="so-progress-text">35%</span>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Circular Progress Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Circular Progress Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Five sizes for circular progress: extra small (32px), small (40px), default (48px), large (64px), and extra large (80px).</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap">
                        <div class="so-progress-circular so-progress-circular-xs so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 32 32">
                                <circle class="so-progress-ring-bg" cx="16" cy="16" r="13" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="16" cy="16" r="13" fill="none" stroke-dasharray="81.68" stroke-dashoffset="28.59"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-sm so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 40 40">
                                <circle class="so-progress-ring-bg" cx="20" cy="20" r="17" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="20" cy="20" r="17" fill="none" stroke-dasharray="106.81" stroke-dashoffset="37.38"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none" stroke-dasharray="125.66" stroke-dashoffset="43.98"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-lg so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 64 64">
                                <circle class="so-progress-ring-bg" cx="32" cy="32" r="27" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="32" cy="32" r="27" fill="none" stroke-dasharray="169.65" stroke-dashoffset="59.38"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-xl so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 80 80">
                                <circle class="so-progress-ring-bg" cx="40" cy="40" r="34" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="40" cy="40" r="34" fill="none" stroke-dasharray="213.63" stroke-dashoffset="74.77"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-circular-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress(65)->circular()->primary()->extraSmall();  // 32px
UiEngine::progress(65)->circular()->primary()->small();       // 40px
UiEngine::progress(65)->circular()->primary();                // 48px
UiEngine::progress(65)->circular()->primary()->large();       // 64px
UiEngine::progress(65)->circular()->primary()->extraLarge();  // 80px"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().value(65).circular().primary().extraSmall().toHtml();
Progress.make().value(65).circular().primary().small().toHtml();
Progress.make().value(65).circular().primary().toHtml();
Progress.make().value(65).circular().primary().large().toHtml();
Progress.make().value(65).circular().primary().extraLarge().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress-circular so-progress-circular-xs so-progress-circular-primary">
    <svg class="so-progress-ring" viewBox="0 0 32 32">...</svg>
</div>
<div class="so-progress-circular so-progress-circular-sm so-progress-circular-primary">
    <svg class="so-progress-ring" viewBox="0 0 40 40">...</svg>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Circular Progress Spinner (Indeterminate) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Circular Progress Spinner</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Indeterminate circular progress for loading states.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-d-flex so-gap-4 so-align-items-center so-flex-wrap">
                        <div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-success">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-warning">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
                            </svg>
                        </div>
                        <div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-danger">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-circular-spinner', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::progress()->circular()->indeterminate()->primary();
UiEngine::progress()->circular()->indeterminate()->success();
UiEngine::progress()->circular()->indeterminate()->warning();
UiEngine::progress()->circular()->indeterminate()->danger();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "Progress.make().circular().indeterminate().primary().toHtml();
Progress.make().circular().indeterminate().success().toHtml();
Progress.make().circular().indeterminate().warning().toHtml();
Progress.make().circular().indeterminate().danger().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-primary">
    <svg class="so-progress-ring" viewBox="0 0 48 48">
        <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
        <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
    </svg>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Interactive Demo -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Interactive Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control progress dynamically with JavaScript methods.</p>

                <!-- Controls -->
                <div class="so-mb-4">
                    <div class="so-d-flex so-gap-2 so-mb-3 so-flex-wrap">
                        <button id="progress-set-25" class="so-btn so-btn-sm so-btn-outline-primary">Set 25%</button>
                        <button id="progress-set-50" class="so-btn so-btn-sm so-btn-outline-primary">Set 50%</button>
                        <button id="progress-set-75" class="so-btn so-btn-sm so-btn-outline-primary">Set 75%</button>
                        <button id="progress-set-100" class="so-btn so-btn-sm so-btn-outline-primary">Set 100%</button>
                        <button id="progress-animate" class="so-btn so-btn-sm so-btn-primary">Animate to 100%</button>
                        <button id="progress-reset" class="so-btn so-btn-sm so-btn-outline-secondary">Reset</button>
                    </div>

                    <!-- Progress Bars -->
                    <div class="so-mb-3">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Linear Progress</label>
                        <div id="demo-progress-linear-container"></div>
                    </div>

                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Circular Progress</label>
                        <div id="demo-progress-circular-container"></div>
                    </div>
                </div>

                <!-- Event Log -->
                <div>
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Event Log</label>
                    <div id="progress-event-log" class="so-bg-light so-p-3 so-rounded" style="max-height: 200px; overflow-y: auto; font-family: monospace; font-size: 0.875rem;"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('progress-interactive', [
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Progress } from './ui-engine/elements/display/Progress.js';

// Get Progress instance
const linearProgress = Progress.getInstance('#demo-progress-linear');
const circularProgress = Progress.getInstance('#demo-progress-circular');

// Set value
linearProgress.setValue(50);
circularProgress.setValue(50);

// Get current values
console.log(linearProgress.getValue());    // 50
console.log(linearProgress.getPercent());  // 50

// Animate from current value to target
linearProgress.animate(0, 100, 1500);  // (from, to, duration)

// Listen to progress changes
document.getElementById('demo-progress-linear')
    .addEventListener('so:progress:change', (e) => {
        console.log('Progress changed:', e.detail);
        // detail: { oldValue, newValue, percent }
    });"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Configuration Passing -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Configuration Passing: PHP to JavaScript</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Three methods to pass configuration from PHP-generated elements to JavaScript.</p>

                <h5 class="so-mb-3">Method 1: Data Attributes (Recommended)</h5>
                <p class="so-text-muted so-mb-3">Use data attributes for simple configuration. Progress automatically reads <code>data-so-value</code>, <code>data-so-max</code>, and <code>data-so-min</code>.</p>

                <?= so_code_tabs('config-data-attrs', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Elements with data-so-progress are auto-initialized
echo UiEngine::progress(75)->primary()->attr('id', 'my-progress');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Auto-initialization happens on DOM ready
// Get instance and interact
const progress = Progress.getInstance('#my-progress');
progress.setValue(90);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div id="my-progress" class="so-progress so-progress-primary"
     data-so-progress role="progressbar" aria-valuenow="75"
     aria-valuemin="0" aria-valuemax="100">
    <div class="so-progress-bar" style="width: 75%"></div>
</div>'
                    ],
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Method 2: JSON Configuration</h5>
                <p class="so-text-muted so-mb-3">For complex configurations, use <code>toArray()</code> to export configuration as JSON.</p>

                <?= so_code_tabs('config-json', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$progress = UiEngine::progress(60)
    ->primary()
    ->large()
    ->showLabel();

// Export configuration
\$config = \$progress->toArray();
echo '<script>window.progressConfig = ' . json_encode(\$config) . ';</script>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Create from config
const progress = new Progress(window.progressConfig);
document.getElementById('container').innerHTML = progress.toHtml();"
                    ],
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Method 3: Direct Rendering</h5>
                <p class="so-text-muted so-mb-3">Render on server, interact on client using <code>getInstance()</code>.</p>

                <?= so_code_tabs('config-direct', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Render with unique ID
echo UiEngine::progress(45)
    ->success()
    ->attr('id', 'upload-progress');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Get existing instance by ID
const progress = Progress.getInstance('#upload-progress');

// Update dynamically
function updateProgress(loaded, total) {
    const percent = (loaded / total) * 100;
    progress.setValue(percent);
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <?= so_tabs('progress-api-reference', [
                    [
                        'id' => 'api-php',
                        'label' => 'PHP API',
                        'active' => true,
                        'content' => '
                            <h5 class="so-mb-3">Configuration Methods</h5>
                            <div class="so-table-responsive so-mb-4">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 25%">Method</th>
                                            <th style="width: 30%">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>linear()</code></td>
                                            <td>-</td>
                                            <td>Set progress type to linear (default)</td>
                                        </tr>
                                        <tr>
                                            <td><code>circular()</code></td>
                                            <td>-</td>
                                            <td>Set progress type to circular</td>
                                        </tr>
                                        <tr>
                                            <td><code>value()</code></td>
                                            <td><code>int|float $value</code></td>
                                            <td>Set current progress value</td>
                                        </tr>
                                        <tr>
                                            <td><code>min()</code></td>
                                            <td><code>int|float $min</code></td>
                                            <td>Set minimum value (default: 0)</td>
                                        </tr>
                                        <tr>
                                            <td><code>max()</code></td>
                                            <td><code>int|float $max</code></td>
                                            <td>Set maximum value (default: 100)</td>
                                        </tr>
                                        <tr>
                                            <td><code>color()</code></td>
                                            <td><code>string $color</code></td>
                                            <td>Set color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>primary()</code></td>
                                            <td>-</td>
                                            <td>Primary color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>secondary()</code></td>
                                            <td>-</td>
                                            <td>Secondary color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>success()</code></td>
                                            <td>-</td>
                                            <td>Success color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>danger()</code></td>
                                            <td>-</td>
                                            <td>Danger color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>warning()</code></td>
                                            <td>-</td>
                                            <td>Warning color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>info()</code></td>
                                            <td>-</td>
                                            <td>Info color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>light()</code></td>
                                            <td>-</td>
                                            <td>Light color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>dark()</code></td>
                                            <td>-</td>
                                            <td>Dark color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>size()</code></td>
                                            <td><code>string $size</code></td>
                                            <td>Set size: xs, sm, lg, xl</td>
                                        </tr>
                                        <tr>
                                            <td><code>extraSmall()</code></td>
                                            <td>-</td>
                                            <td>Extra small size</td>
                                        </tr>
                                        <tr>
                                            <td><code>small()</code></td>
                                            <td>-</td>
                                            <td>Small size</td>
                                        </tr>
                                        <tr>
                                            <td><code>large()</code></td>
                                            <td>-</td>
                                            <td>Large size</td>
                                        </tr>
                                        <tr>
                                            <td><code>extraLarge()</code></td>
                                            <td>-</td>
                                            <td>Extra large size</td>
                                        </tr>
                                        <tr>
                                            <td><code>showLabel()</code></td>
                                            <td><code>bool $show, ?string $text</code></td>
                                            <td>Show label inside progress bar</td>
                                        </tr>
                                        <tr>
                                            <td><code>striped()</code></td>
                                            <td><code>bool $striped</code></td>
                                            <td>Enable striped pattern</td>
                                        </tr>
                                        <tr>
                                            <td><code>animated()</code></td>
                                            <td><code>bool $animated</code></td>
                                            <td>Animate stripes (auto-enables striped)</td>
                                        </tr>
                                        <tr>
                                            <td><code>indeterminate()</code></td>
                                            <td><code>bool $indeterminate</code></td>
                                            <td>Enable indeterminate mode</td>
                                        </tr>
                                        <tr>
                                            <td><code>buffer()</code></td>
                                            <td><code>float $bufferValue</code></td>
                                            <td>Add buffer indicator</td>
                                        </tr>
                                        <tr>
                                            <td><code>gradient()</code></td>
                                            <td><code>?string $variant</code></td>
                                            <td>Enable gradient effect</td>
                                        </tr>
                                        <tr>
                                            <td><code>segment()</code></td>
                                            <td><code>float $value, string $color, ?string $label</code></td>
                                            <td>Add segment for stacked progress</td>
                                        </tr>
                                        <tr>
                                            <td><code>step()</code></td>
                                            <td><code>bool $active, ?float $partial</code></td>
                                            <td>Add step for stepped progress</td>
                                        </tr>
                                        <tr>
                                            <td><code>externalLabel()</code></td>
                                            <td><code>string $title, string $value</code></td>
                                            <td>Add external label wrapper</td>
                                        </tr>
                                        <tr>
                                            <td><code>toArray()</code></td>
                                            <td>-</td>
                                            <td>Export configuration as array</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'api-js',
                        'label' => 'JavaScript API',
                        'content' => '
                            <h5 class="so-mb-3">Configuration Methods</h5>
                            <p class="so-text-muted so-mb-3">Same fluent API as PHP for building progress indicators.</p>
                            <div class="so-table-responsive so-mb-4">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 25%">Method</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>linear()</code></td>
                                            <td>Set progress type to linear</td>
                                        </tr>
                                        <tr>
                                            <td><code>circular()</code></td>
                                            <td>Set progress type to circular</td>
                                        </tr>
                                        <tr>
                                            <td><code>value(v)</code></td>
                                            <td>Set progress value</td>
                                        </tr>
                                        <tr>
                                            <td><code>min(m)</code>, <code>max(m)</code></td>
                                            <td>Set min/max values</td>
                                        </tr>
                                        <tr>
                                            <td><code>primary()</code>, <code>success()</code>, etc.</td>
                                            <td>Color variant shortcuts</td>
                                        </tr>
                                        <tr>
                                            <td><code>showLabel(show, text)</code></td>
                                            <td>Show label with optional custom text</td>
                                        </tr>
                                        <tr>
                                            <td><code>striped()</code>, <code>animated()</code></td>
                                            <td>Enable stripes and animation</td>
                                        </tr>
                                        <tr>
                                            <td><code>segment(value, color, label)</code></td>
                                            <td>Add stacked segment</td>
                                        </tr>
                                        <tr>
                                            <td><code>step(active, partial)</code></td>
                                            <td>Add stepped progress step</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mb-3">Interactive Methods</h5>
                            <div class="so-table-responsive so-mb-4">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 30%">Method</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>setValue(value)</code></td>
                                            <td>Update progress value and DOM</td>
                                        </tr>
                                        <tr>
                                            <td><code>getValue()</code></td>
                                            <td>Get current progress value</td>
                                        </tr>
                                        <tr>
                                            <td><code>getPercent()</code></td>
                                            <td>Get current progress as percentage</td>
                                        </tr>
                                        <tr>
                                            <td><code>animate(from, to, duration)</code></td>
                                            <td>Animate progress with easing (duration in ms)</td>
                                        </tr>
                                        <tr>
                                            <td><code>onProgress(callback)</code></td>
                                            <td>Set callback for progress changes</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mb-3">Static Methods</h5>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 35%">Method</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>Progress.getInstance(element)</code></td>
                                            <td>Get Progress instance for element (selector or element)</td>
                                        </tr>
                                        <tr>
                                            <td><code>Progress.initAll()</code></td>
                                            <td>Initialize all progress elements with <code>data-so-progress</code></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'api-html',
                        'label' => 'HTML Structure',
                        'content' => '
                            <h5 class="so-mb-3">Linear Progress Structure</h5>
                            <pre class="so-code-block"><code class="language-html">&lt;div class="so-progress so-progress-primary" role="progressbar"
     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"&gt;
    &lt;div class="so-progress-bar" style="width: 50%"&gt;
        &lt;span class="so-progress-label"&gt;50%&lt;/span&gt;  &lt;!-- Optional --&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>

                            <h5 class="so-mb-3 so-mt-4">Circular Progress Structure</h5>
                            <pre class="so-code-block"><code class="language-html">&lt;div class="so-progress-circular so-progress-circular-primary"&gt;
    &lt;svg class="so-progress-ring" viewBox="0 0 48 48"&gt;
        &lt;circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"&gt;&lt;/circle&gt;
        &lt;circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                stroke-dasharray="125.66" stroke-dashoffset="62.83"&gt;&lt;/circle&gt;
    &lt;/svg&gt;
    &lt;span class="so-progress-text"&gt;50%&lt;/span&gt;  &lt;!-- Optional --&gt;
&lt;/div&gt;</code></pre>

                            <h5 class="so-mb-3 so-mt-4">External Label Structure</h5>
                            <pre class="so-code-block"><code class="language-html">&lt;div class="so-progress-wrapper"&gt;
    &lt;div class="so-progress-header"&gt;
        &lt;span class="so-progress-title"&gt;Loading...&lt;/span&gt;
        &lt;span class="so-progress-value"&gt;50%&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class="so-progress so-progress-primary"&gt;
        &lt;div class="so-progress-bar" style="width: 50%"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        '
                    ],
                    [
                        'id' => 'api-css',
                        'label' => 'CSS Classes',
                        'content' => '
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 35%">Class</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>.so-progress</code></td>
                                            <td>Base linear progress container</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-bar</code></td>
                                            <td>Progress indicator bar</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-label</code></td>
                                            <td>Label inside progress bar</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-{color}</code></td>
                                            <td>Color variants: primary, secondary, success, danger, warning, info, light, dark</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-xs/sm/lg/xl</code></td>
                                            <td>Size variants for linear</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-striped</code></td>
                                            <td>Striped pattern</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-animated</code></td>
                                            <td>Animated stripes</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-indeterminate</code></td>
                                            <td>Indeterminate loading state</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-buffer</code></td>
                                            <td>Buffer mode container</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-buffer-bar</code></td>
                                            <td>Buffer indicator bar</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-stacked</code></td>
                                            <td>Container for stacked segments</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-stepped</code></td>
                                            <td>Stepped progress container</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-step</code></td>
                                            <td>Individual step</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-step-fill</code></td>
                                            <td>Step fill indicator</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-gradient</code></td>
                                            <td>Gradient effect</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-wrapper</code></td>
                                            <td>External label wrapper</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-header</code></td>
                                            <td>External label header row</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-title</code></td>
                                            <td>External label title</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-value</code></td>
                                            <td>External label value</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-circular</code></td>
                                            <td>Circular progress container</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-circular-{color}</code></td>
                                            <td>Circular color variants</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-circular-xs/sm/lg/xl</code></td>
                                            <td>Circular size variants</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-circular-indeterminate</code></td>
                                            <td>Circular spinner (indeterminate)</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-ring</code></td>
                                            <td>SVG ring container</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-ring-bg</code></td>
                                            <td>Background circle</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-ring-fill</code></td>
                                            <td>Progress fill circle</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-progress-text</code></td>
                                            <td>Center text for circular</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'api-data',
                        'label' => 'Data Attributes',
                        'content' => '
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 35%">Attribute</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>data-so-progress</code></td>
                                            <td>Marks element for auto-initialization</td>
                                        </tr>
                                        <tr>
                                            <td><code>data-so-value</code></td>
                                            <td>Initial progress value</td>
                                        </tr>
                                        <tr>
                                            <td><code>data-so-min</code></td>
                                            <td>Minimum value (default: 0)</td>
                                        </tr>
                                        <tr>
                                            <td><code>data-so-max</code></td>
                                            <td>Maximum value (default: 100)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mb-3 so-mt-4">ARIA Attributes</h5>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 35%">Attribute</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>role="progressbar"</code></td>
                                            <td>ARIA role for linear progress (not for indeterminate)</td>
                                        </tr>
                                        <tr>
                                            <td><code>aria-valuenow</code></td>
                                            <td>Current progress value</td>
                                        </tr>
                                        <tr>
                                            <td><code>aria-valuemin</code></td>
                                            <td>Minimum value</td>
                                        </tr>
                                        <tr>
                                            <td><code>aria-valuemax</code></td>
                                            <td>Maximum value</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'api-events',
                        'label' => 'Events',
                        'content' => '
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 30%">Event</th>
                                            <th style="width: 35%">Detail Properties</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>so:progress:change</code></td>
                                            <td>
                                                <code>oldValue</code><br>
                                                <code>newValue</code><br>
                                                <code>percent</code>
                                            </td>
                                            <td>Fired when progress value changes via <code>setValue()</code></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mb-3 so-mt-4">Event Usage Example</h5>
                            <pre class="so-code-block"><code class="language-javascript">import { Progress } from \'./ui-engine/elements/display/Progress.js\';

const progressEl = document.getElementById(\'my-progress\');

// Listen to progress changes
progressEl.addEventListener(\'so:progress:change\', (event) => {
    const { oldValue, newValue, percent } = event.detail;
    console.log(`Progress changed from ${oldValue} to ${newValue} (${percent}%)`);

    // Update external UI
    document.getElementById(\'status\').textContent = `${Math.round(percent)}% complete`;
});

// Trigger change
const progress = Progress.getInstance(progressEl);
progress.setValue(75);  // Fires so:progress:change event</code></pre>
                        '
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
                <h5 class="so-mb-3">When to Use Progress</h5>
                <ul class="so-mb-4">
                    <li><strong>Linear Progress:</strong> For operations with known duration or completion percentage (file uploads, downloads, form completion)</li>
                    <li><strong>Circular Progress:</strong> For compact spaces, loading states, or when emphasizing completion percentage</li>
                    <li><strong>Indeterminate:</strong> When operation duration is unknown (processing, waiting for server response)</li>
                    <li><strong>Buffer Mode:</strong> For media playback showing both loaded and played portions</li>
                    <li><strong>Stacked:</strong> For showing distribution of multiple categories or metrics</li>
                    <li><strong>Stepped:</strong> For multi-stage workflows and processes</li>
                </ul>

                <h5 class="so-mb-3">Best Practices</h5>
                <ul class="so-mb-4">
                    <li>Use appropriate colors: success for complete, warning for approaching limits, danger for errors</li>
                    <li>Provide labels or external labels for context on what is progressing</li>
                    <li>Use indeterminate mode when you truly don\'t know duration (don\'t fake determinate progress)</li>
                    <li>Consider animation sparingly - animated stripes draw attention but can be distracting</li>
                    <li>Ensure progress updates reflect actual completion, not time elapsed</li>
                    <li>For long operations, combine with estimated time remaining or status text</li>
                </ul>

                <h5 class="so-mb-3">Accessibility</h5>
                <ul class="so-mb-4">
                    <li>Linear progress automatically includes <code>role="progressbar"</code> and ARIA attributes</li>
                    <li>Indeterminate progress omits role and value attributes as per ARIA spec</li>
                    <li>Ensure external labels are associated with progress bars (use wrappers)</li>
                    <li>Circular progress is primarily visual; provide text alternatives for screen readers</li>
                    <li>Update ARIA attributes when dynamically changing progress values</li>
                </ul>

                <h5 class="so-mb-3">Performance Considerations</h5>
                <ul>
                    <li>Avoid updating progress too frequently (throttle to 100-200ms intervals)</li>
                    <li>Use CSS animations (striped, indeterminate) which are GPU-accelerated</li>
                    <li>For circular progress, SVG rendering is efficient but avoid excessive redraws</li>
                    <li>The <code>animate()</code> method uses requestAnimationFrame for smooth transitions</li>
                    <li>Buffer mode requires two width calculations but has minimal performance impact</li>
                </ul>
            </div>
        </div>
    </div>
</main>

<script type="module">
import { Progress } from '/src/js/ui-engine/elements/display/Progress.js';

document.addEventListener('DOMContentLoaded', function() {
    // Basic Linear Progress
    document.getElementById('demo-basic-progress-1').innerHTML =
        Progress.make().value(25).primary().toHtml();

    document.getElementById('demo-basic-progress-2').innerHTML =
        Progress.make().value(50).primary().toHtml();

    document.getElementById('demo-basic-progress-3').innerHTML =
        Progress.make().value(75).primary().toHtml();

    document.getElementById('demo-basic-progress-4').innerHTML =
        Progress.make().value(100).primary().toHtml();

    // Interactive Demo Progress Bars
    document.getElementById('demo-progress-linear-container').innerHTML =
        Progress.make().value(0).primary().id('demo-progress-linear').toHtml();

    document.getElementById('demo-progress-circular-container').innerHTML =
        Progress.make().value(0).primary().circular().id('demo-progress-circular').toHtml();

    // Initialize all Progress instances (after a short delay to ensure DOM is ready)
    setTimeout(function() {
        Progress.initAll();

        // Interactive Demo Controls
        setupInteractiveDemo();
    }, 100);
});

function setupInteractiveDemo() {
    const linearProgress = Progress.getInstance('#demo-progress-linear');
    const circularProgress = Progress.getInstance('#demo-progress-circular');
    const eventLog = document.getElementById('progress-event-log');

    if (!linearProgress || !circularProgress || !eventLog) {
        console.error('Interactive demo elements not found');
        return;
    }

    function logEvent(message) {
        const timestamp = new Date().toLocaleTimeString();
        const entry = document.createElement('div');
        entry.textContent = `[${timestamp}] ${message}`;
        eventLog.insertBefore(entry, eventLog.firstChild);
    }

    // Button handlers
    document.getElementById('progress-set-25').addEventListener('click', () => {
        linearProgress.setValue(25);
        circularProgress.setValue(25);
        logEvent('Set progress to 25%');
    });

    document.getElementById('progress-set-50').addEventListener('click', () => {
        linearProgress.setValue(50);
        circularProgress.setValue(50);
        logEvent('Set progress to 50%');
    });

    document.getElementById('progress-set-75').addEventListener('click', () => {
        linearProgress.setValue(75);
        circularProgress.setValue(75);
        logEvent('Set progress to 75%');
    });

    document.getElementById('progress-set-100').addEventListener('click', () => {
        linearProgress.setValue(100);
        circularProgress.setValue(100);
        logEvent('Set progress to 100%');
    });

    document.getElementById('progress-animate').addEventListener('click', () => {
        linearProgress.animate(linearProgress.getValue(), 100, 2000);
        circularProgress.animate(circularProgress.getValue(), 100, 2000);
        logEvent('Animating to 100% over 2 seconds');
    });

    document.getElementById('progress-reset').addEventListener('click', () => {
        linearProgress.setValue(0);
        circularProgress.setValue(0);
        logEvent('Progress reset to 0%');
    });

    // Event listeners
    document.getElementById('demo-progress-linear').addEventListener('so:progress:change', (e) => {
        logEvent(`Linear progress changed: ${e.detail.oldValue}% → ${e.detail.newValue}%`);
    });

    document.getElementById('demo-progress-circular').addEventListener('so:progress:change', (e) => {
        logEvent(`Circular progress changed: ${e.detail.oldValue}% → ${e.detail.newValue}%`);
    });

    logEvent('Interactive demo ready');
}
</script>

<?php require_once '../../includes/footer.php'; ?>
