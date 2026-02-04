<?php
/**
 * SixOrbit UI Engine - Skeleton Element Demo
 */

$pageTitle = 'Skeleton - UI Engine';
$pageDescription = 'Placeholder loading states for content';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Skeleton</h1>
            <p class="so-page-subtitle">Placeholder loading states that mimic the structure of content being loaded.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Skeleton -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Skeleton</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                    <div class="so-skeleton so-skeleton-text so-mb-2" style="width: 80%"></div>
                    <div class="so-skeleton so-skeleton-text" style="width: 60%"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-skeleton', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Basic text skeleton
echo UiEngine::skeleton()->lines(3);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Basic text skeleton
UiEngine.skeleton().lines(3).toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-skeleton so-skeleton-text so-mb-2"></div>
<div class="so-skeleton so-skeleton-text so-mb-2" style="width: 80%"></div>
<div class="so-skeleton so-skeleton-text" style="width: 60%"></div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Skeleton Shapes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Skeleton Shapes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-4 so-align-items-start so-mb-4">
                    <div>
                        <p class="so-text-muted so-small so-mb-2">Circle (Avatar)</p>
                        <div class="so-skeleton so-skeleton-circle" style="width:64px;height:64px;"></div>
                    </div>
                    <div>
                        <p class="so-text-muted so-small so-mb-2">Rectangle (Image)</p>
                        <div class="so-skeleton so-skeleton-rect" style="width:150px;height:100px;"></div>
                    </div>
                    <div>
                        <p class="so-text-muted so-small so-mb-2">Rounded (Button)</p>
                        <div class="so-skeleton so-skeleton-rounded" style="width:100px;height:36px;"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('skeleton-shapes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Circle (avatar)
UiEngine::skeleton()->circle(64); // 64px diameter

// Rectangle (image)
UiEngine::skeleton()->rectangle(150, 100); // width, height

// Rounded (button)
UiEngine::skeleton()->rounded(100, 36);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Circle (avatar)
UiEngine.skeleton().circle(64).toHtml();

// Rectangle (image)
UiEngine.skeleton().rectangle(150, 100).toHtml();

// Rounded (button)
UiEngine.skeleton().rounded(100, 36).toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Circle -->
<div class="so-skeleton so-skeleton-circle" style="width:64px;height:64px;"></div>

<!-- Rectangle -->
<div class="so-skeleton so-skeleton-rect" style="width:150px;height:100px;"></div>

<!-- Rounded -->
<div class="so-skeleton so-skeleton-rounded" style="width:100px;height:36px;"></div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Animation Types -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Animation Types</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-g-4 so-mb-4">
                    <div class="so-col-md-4">
                        <p class="so-small so-text-muted so-mb-2">Wave Animation (Default)</p>
                        <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-text" style="width: 80%"></div>
                    </div>
                    <div class="so-col-md-4">
                        <p class="so-small so-text-muted so-mb-2">Pulse Animation</p>
                        <div class="so-skeleton so-skeleton-pulse so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-pulse so-skeleton-text" style="width: 80%"></div>
                    </div>
                    <div class="so-col-md-4">
                        <p class="so-small so-text-muted so-mb-2">No Animation</p>
                        <div class="so-skeleton so-skeleton-static so-skeleton-text so-mb-2"></div>
                        <div class="so-skeleton so-skeleton-static so-skeleton-text" style="width: 80%"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('skeleton-animation', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Wave animation (default)
UiEngine::skeleton()->animation('wave')->lines(2);

// Pulse animation
UiEngine::skeleton()->animation('pulse')->lines(2);

// No animation (static)
UiEngine::skeleton()->animation('none')->lines(2);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Wave animation (default)
UiEngine.skeleton().animation('wave').lines(2).toHtml();

// Pulse animation
UiEngine.skeleton().animation('pulse').lines(2).toHtml();

// No animation (static)
UiEngine.skeleton().animation('none').lines(2).toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Wave animation (default) -->
<div class="so-skeleton so-skeleton-text"></div>

<!-- Pulse animation -->
<div class="so-skeleton so-skeleton-pulse so-skeleton-text"></div>

<!-- No animation (static) -->
<div class="so-skeleton so-skeleton-static so-skeleton-text"></div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Card Skeleton -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Card Skeleton</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-g-4 so-mb-4">
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-skeleton so-skeleton-rect" style="height:150px;"></div>
                            <div class="so-card-body">
                                <div class="so-skeleton so-skeleton-text so-mb-2" style="width:70%;"></div>
                                <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                                <div class="so-skeleton so-skeleton-text" style="width:50%;"></div>
                                <div class="so-skeleton so-skeleton-rounded so-mt-3" style="width:100px;height:36px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-skeleton so-skeleton-rect" style="height:150px;"></div>
                            <div class="so-card-body">
                                <div class="so-skeleton so-skeleton-text so-mb-2" style="width:70%;"></div>
                                <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                                <div class="so-skeleton so-skeleton-text" style="width:50%;"></div>
                                <div class="so-skeleton so-skeleton-rounded so-mt-3" style="width:100px;height:36px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-card so-card-bordered">
                            <div class="so-skeleton so-skeleton-rect" style="height:150px;"></div>
                            <div class="so-card-body">
                                <div class="so-skeleton so-skeleton-text so-mb-2" style="width:70%;"></div>
                                <div class="so-skeleton so-skeleton-text so-mb-2"></div>
                                <div class="so-skeleton so-skeleton-text" style="width:50%;"></div>
                                <div class="so-skeleton so-skeleton-rounded so-mt-3" style="width:100px;height:36px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('skeleton-card', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Pre-built card skeleton
UiEngine::skeleton()->card([
    'image' => true,        // Include image placeholder
    'imageHeight' => 150,
    'title' => true,
    'lines' => 2,
    'button' => true,
]);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Pre-built card skeleton
UiEngine.skeleton().card({
    image: true,
    imageHeight: 150,
    title: true,
    lines: 2,
    button: true,
}).toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-card so-card-bordered">
    <div class="so-skeleton so-skeleton-rect" style="height:150px;"></div>
    <div class="so-card-body">
        <div class="so-skeleton so-skeleton-text so-mb-2" style="width:70%;"></div>
        <div class="so-skeleton so-skeleton-text so-mb-2"></div>
        <div class="so-skeleton so-skeleton-text" style="width:50%;"></div>
        <div class="so-skeleton so-skeleton-rounded so-mt-3" style="width:100px;height:36px;"></div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- List Skeleton -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">List Skeleton</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-list-group so-mb-4" style="max-width:400px;">
                    <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="so-list-group-item">
                        <div class="so-d-flex so-align-items-center so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width:40px;height:40px;"></div>
                            <div class="so-flex-grow-1">
                                <div class="so-skeleton so-skeleton-text so-mb-1" style="width:40%;"></div>
                                <div class="so-skeleton so-skeleton-text" style="width:70%;height:12px;"></div>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('skeleton-list', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Pre-built list skeleton
UiEngine::skeleton()->list([
    'items' => 3,
    'avatar' => true,
    'lines' => 2,
]);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Pre-built list skeleton
UiEngine.skeleton().list({
    items: 3,
    avatar: true,
    lines: 2,
}).toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-list-group">
    <div class="so-list-group-item">
        <div class="so-d-flex so-align-items-center so-gap-3">
            <div class="so-skeleton so-skeleton-circle" style="width:40px;height:40px;"></div>
            <div class="so-flex-grow-1">
                <div class="so-skeleton so-skeleton-text so-mb-1" style="width:40%;"></div>
                <div class="so-skeleton so-skeleton-text" style="width:70%;height:12px;"></div>
            </div>
        </div>
    </div>
    <!-- More items... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Profile Skeleton -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Profile Skeleton</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-g-4 so-mb-4">
                    <div class="so-col-md-6">
                        <div class="so-d-flex so-align-items-center so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width:64px;height:64px;"></div>
                            <div class="so-flex-grow-1">
                                <div class="so-skeleton so-skeleton-text so-mb-2" style="width:50%;"></div>
                                <div class="so-skeleton so-skeleton-text" style="width:30%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-d-flex so-align-items-center so-gap-3">
                            <div class="so-skeleton so-skeleton-circle" style="width:48px;height:48px;"></div>
                            <div class="so-flex-grow-1">
                                <div class="so-skeleton so-skeleton-text so-mb-1" style="width:40%;height:14px;"></div>
                                <div class="so-skeleton so-skeleton-text" style="width:60%;height:12px;"></div>
                            </div>
                            <div class="so-skeleton so-skeleton-rounded" style="width:80px;height:32px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('skeleton-profile', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Profile skeleton
UiEngine::skeleton()->profile([
    'avatar' => 64,
    'lines' => 2,
    'button' => true,
]);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Profile skeleton
UiEngine.skeleton().profile({
    avatar: 64,
    lines: 2,
    button: true,
}).toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-d-flex so-align-items-center so-gap-3">
    <div class="so-skeleton so-skeleton-circle" style="width:64px;height:64px;"></div>
    <div class="so-flex-grow-1">
        <div class="so-skeleton so-skeleton-text so-mb-2" style="width:50%;"></div>
        <div class="so-skeleton so-skeleton-text" style="width:30%;"></div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Avatar Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Avatar Sizes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-align-items-end so-gap-3 so-mb-4">
                    <div class="so-text-center">
                        <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-xs"></div>
                        <small class="so-text-muted so-d-block so-mt-1">XS</small>
                    </div>
                    <div class="so-text-center">
                        <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-sm"></div>
                        <small class="so-text-muted so-d-block so-mt-1">SM</small>
                    </div>
                    <div class="so-text-center">
                        <div class="so-skeleton so-skeleton-avatar"></div>
                        <small class="so-text-muted so-d-block so-mt-1">Default</small>
                    </div>
                    <div class="so-text-center">
                        <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-lg"></div>
                        <small class="so-text-muted so-d-block so-mt-1">LG</small>
                    </div>
                    <div class="so-text-center">
                        <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-xl"></div>
                        <small class="so-text-muted so-d-block so-mt-1">XL</small>
                    </div>
                    <div class="so-text-center">
                        <div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-2xl"></div>
                        <small class="so-text-muted so-d-block so-mt-1">2XL</small>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('skeleton-avatars', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Avatar skeleton sizes
UiEngine::skeleton()->avatar('xs');
UiEngine::skeleton()->avatar('sm');
UiEngine::skeleton()->avatar();      // Default
UiEngine::skeleton()->avatar('lg');
UiEngine::skeleton()->avatar('xl');
UiEngine::skeleton()->avatar('2xl');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Avatar skeleton sizes
UiEngine.skeleton().avatar('xs').toHtml();
UiEngine.skeleton().avatar('sm').toHtml();
UiEngine.skeleton().avatar().toHtml();      // Default
UiEngine.skeleton().avatar('lg').toHtml();
UiEngine.skeleton().avatar('xl').toHtml();
UiEngine.skeleton().avatar('2xl').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Avatar sizes -->
<div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-xs"></div>
<div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-sm"></div>
<div class="so-skeleton so-skeleton-avatar"></div>
<div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-lg"></div>
<div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-xl"></div>
<div class="so-skeleton so-skeleton-avatar so-skeleton-avatar-2xl"></div>'
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
                                <td><code>lines()</code></td>
                                <td><code>int $count</code></td>
                                <td>Create text line placeholders</td>
                            </tr>
                            <tr>
                                <td><code>circle()</code></td>
                                <td><code>int $size</code></td>
                                <td>Create circular placeholder</td>
                            </tr>
                            <tr>
                                <td><code>rectangle()</code></td>
                                <td><code>int $width, int $height</code></td>
                                <td>Create rectangular placeholder</td>
                            </tr>
                            <tr>
                                <td><code>rounded()</code></td>
                                <td><code>int $width, int $height</code></td>
                                <td>Create rounded placeholder</td>
                            </tr>
                            <tr>
                                <td><code>avatar()</code></td>
                                <td><code>string $size</code></td>
                                <td>Create avatar placeholder: xs, sm, lg, xl, 2xl</td>
                            </tr>
                            <tr>
                                <td><code>animation()</code></td>
                                <td><code>string $type</code></td>
                                <td>Set animation: wave, pulse, none</td>
                            </tr>
                            <tr>
                                <td><code>card()</code></td>
                                <td><code>array $options</code></td>
                                <td>Create card skeleton template</td>
                            </tr>
                            <tr>
                                <td><code>list()</code></td>
                                <td><code>array $options</code></td>
                                <td>Create list skeleton template</td>
                            </tr>
                            <tr>
                                <td><code>profile()</code></td>
                                <td><code>array $options</code></td>
                                <td>Create profile skeleton template</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">CSS Classes</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><code>.so-skeleton</code></td><td>Base skeleton class (required)</td></tr>
                            <tr><td><code>.so-skeleton-text</code></td><td>Text line placeholder</td></tr>
                            <tr><td><code>.so-skeleton-circle</code></td><td>Circular shape</td></tr>
                            <tr><td><code>.so-skeleton-rect</code></td><td>Rectangular shape</td></tr>
                            <tr><td><code>.so-skeleton-rounded</code></td><td>Rounded rectangle</td></tr>
                            <tr><td><code>.so-skeleton-avatar</code></td><td>Avatar placeholder</td></tr>
                            <tr><td><code>.so-skeleton-pulse</code></td><td>Pulse animation</td></tr>
                            <tr><td><code>.so-skeleton-static</code></td><td>No animation</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
