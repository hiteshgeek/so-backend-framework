<?php
/**
 * SixOrbit UI Demo - Progress
 */
$pageTitle = 'Progress';
$pageDescription = 'Progress bar components';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Progress</h1>
            <p class="so-page-subtitle">Progress bar components</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<div class="so-grid so-grid-cols-1 so-gap-6">

        <!-- Basic Progress Bar -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Progress Bar</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">A simple linear progress bar with default styling.</p>

                <div class="so-mb-4">
                    <div class="so-progress so-progress-primary">
                        <div class="so-progress-bar" style="width: 60%"></div>
                    </div>
                </div>

                <div class="so-mb-6">
                    <div class="so-progress so-progress-success">
                        <div class="so-progress-bar" style="width: 40%"></div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-primary">
    <div class="so-progress-bar" style="width: 60%"></div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Progress with Labels -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Progress with Labels</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add labels inside the progress bar to display percentage or custom text.</p>

                <div class="so-grid so-grid-cols-1 so-gap-4 so-mb-6">
                    <div class="so-progress so-progress-lg so-progress-primary">
                        <div class="so-progress-bar" style="width: 25%">
                            <span class="so-progress-label">25%</span>
                        </div>
                    </div>

                    <div class="so-progress so-progress-lg so-progress-success">
                        <div class="so-progress-bar" style="width: 50%">
                            <span class="so-progress-label">50%</span>
                        </div>
                    </div>

                    <div class="so-progress so-progress-lg so-progress-info">
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

                <?= so_code_block('<div class="so-progress so-progress-lg so-progress-primary">
    <div class="so-progress-bar" style="width: 50%">
        <span class="so-progress-label">50%</span>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Progress with External Label -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Progress with External Label</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display progress information outside the bar using wrapper and header elements.</p>

                <div class="so-progress-wrapper so-mb-4">
                    <div class="so-progress-header">
                        <span class="so-progress-title">Uploading file...</span>
                        <span class="so-progress-value">68%</span>
                    </div>
                    <div class="so-progress so-progress-primary">
                        <div class="so-progress-bar" style="width: 68%"></div>
                    </div>
                </div>

                <div class="so-progress-wrapper so-mb-6">
                    <div class="so-progress-header">
                        <span class="so-progress-title">Storage Used</span>
                        <span class="so-progress-value">7.5 GB / 10 GB</span>
                    </div>
                    <div class="so-progress so-progress-warning">
                        <div class="so-progress-bar" style="width: 75%"></div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress-wrapper">
    <div class="so-progress-header">
        <span class="so-progress-title">Uploading file...</span>
        <span class="so-progress-value">68%</span>
    </div>
    <div class="so-progress so-progress-primary">
        <div class="so-progress-bar" style="width: 68%"></div>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Progress bars come in five sizes: extra small, small, default, large, and extra large.</p>

                <div class="so-grid so-grid-cols-1 so-gap-4 so-mb-6">
                    <div>
                        <label class="so-d-block so-mb-1 so-text-sm so-font-medium">Extra Small (4px)</label>
                        <div class="so-progress so-progress-xs so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>

                    <div>
                        <label class="so-d-block so-mb-1 so-text-sm so-font-medium">Small (8px)</label>
                        <div class="so-progress so-progress-sm so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>

                    <div>
                        <label class="so-d-block so-mb-1 so-text-sm so-font-medium">Default (12px)</label>
                        <div class="so-progress so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>

                    <div>
                        <label class="so-d-block so-mb-1 so-text-sm so-font-medium">Large (16px)</label>
                        <div class="so-progress so-progress-lg so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>

                    <div>
                        <label class="so-d-block so-mb-1 so-text-sm so-font-medium">Extra Large (20px)</label>
                        <div class="so-progress so-progress-xl so-progress-primary">
                            <div class="so-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-xs">...</div>
<div class="so-progress so-progress-sm">...</div>
<div class="so-progress">...</div>
<div class="so-progress so-progress-lg">...</div>
<div class="so-progress so-progress-xl">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Eight color variants are available to match your design system.</p>

                <div class="so-grid so-grid-cols-1 so-gap-3 so-mb-6">
                    <div class="so-progress so-progress-primary">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-secondary">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-success">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-danger">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-warning">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-info">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-light">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-dark">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-primary">...</div>
<div class="so-progress so-progress-secondary">...</div>
<div class="so-progress so-progress-success">...</div>
<div class="so-progress so-progress-danger">...</div>
<div class="so-progress so-progress-warning">...</div>
<div class="so-progress so-progress-info">...</div>
<div class="so-progress so-progress-light">...</div>
<div class="so-progress so-progress-dark">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Striped Progress -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Striped Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add stripes to give the progress bar a visual pattern.</p>

                <div class="so-grid so-grid-cols-1 so-gap-3 so-mb-6">
                    <div class="so-progress so-progress-striped so-progress-primary">
                        <div class="so-progress-bar" style="width: 60%"></div>
                    </div>

                    <div class="so-progress so-progress-striped so-progress-success">
                        <div class="so-progress-bar" style="width: 50%"></div>
                    </div>

                    <div class="so-progress so-progress-striped so-progress-warning">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-striped so-progress-danger">
                        <div class="so-progress-bar" style="width: 40%"></div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-striped so-progress-primary">
    <div class="so-progress-bar" style="width: 60%"></div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Animated Stripes -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Animated Stripes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Animate the stripes for an active loading effect.</p>

                <div class="so-grid so-grid-cols-1 so-gap-3 so-mb-6">
                    <div class="so-progress so-progress-striped so-progress-animated so-progress-primary">
                        <div class="so-progress-bar" style="width: 75%"></div>
                    </div>

                    <div class="so-progress so-progress-striped so-progress-animated so-progress-success">
                        <div class="so-progress-bar" style="width: 60%"></div>
                    </div>

                    <div class="so-progress so-progress-striped so-progress-animated so-progress-info">
                        <div class="so-progress-bar" style="width: 85%"></div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-striped so-progress-animated so-progress-primary">
    <div class="so-progress-bar" style="width: 75%"></div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Indeterminate Progress -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Indeterminate Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Use indeterminate progress when the completion time is unknown.</p>

                <div class="so-grid so-grid-cols-1 so-gap-4 so-mb-6">
                    <div class="so-progress so-progress-indeterminate so-progress-primary">
                        <div class="so-progress-bar"></div>
                    </div>

                    <div class="so-progress so-progress-indeterminate so-progress-success">
                        <div class="so-progress-bar"></div>
                        <div class="so-progress-bar so-progress-bar-secondary"></div>
                    </div>

                    <div class="so-progress so-progress-indeterminate so-progress-info">
                        <div class="so-progress-bar"></div>
                        <div class="so-progress-bar so-progress-bar-secondary"></div>
                    </div>
                </div>

                <?= so_code_block('<!-- Single bar indeterminate -->
<div class="so-progress so-progress-indeterminate so-progress-primary">
    <div class="so-progress-bar"></div>
</div>

<!-- Dual bar indeterminate (Material Design style) -->
<div class="so-progress so-progress-indeterminate so-progress-success">
    <div class="so-progress-bar"></div>
    <div class="so-progress-bar so-progress-bar-secondary"></div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Buffer Progress -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Buffer Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Buffer progress shows both current progress and buffered content (like video players).</p>

                <div class="so-grid so-grid-cols-1 so-gap-4 so-mb-6">
                    <div class="so-progress so-progress-buffer so-progress-primary">
                        <div class="so-progress-bar" style="width: 45%"></div>
                        <div class="so-progress-buffer-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-buffer so-progress-info">
                        <div class="so-progress-bar" style="width: 30%"></div>
                        <div class="so-progress-buffer-bar" style="width: 60%"></div>
                    </div>

                    <div class="so-progress so-progress-buffer so-progress-success">
                        <div class="so-progress-bar" style="width: 55%"></div>
                        <div class="so-progress-buffer-bar" style="width: 80%"></div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-buffer so-progress-primary">
    <div class="so-progress-bar" style="width: 45%"></div>
    <div class="so-progress-buffer-bar" style="width: 70%"></div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Stacked/Multiple Progress -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Stacked Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Stack multiple progress bars to show segmented data.</p>

                <div class="so-mb-4">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Disk Usage</label>
                    <div class="so-progress so-progress-stacked">
                        <div class="so-progress so-progress-success" style="width: 25%">
                            <div class="so-progress-bar" style="width: 100%"></div>
                        </div>
                        <div class="so-progress so-progress-warning" style="width: 35%">
                            <div class="so-progress-bar" style="width: 100%"></div>
                        </div>
                        <div class="so-progress so-progress-danger" style="width: 15%">
                            <div class="so-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="so-d-flex so-gap-4 so-mt-2 so-text-sm">
                        <span><span class="so-badge so-badge-success"></span> Documents (25%)</span>
                        <span><span class="so-badge so-badge-warning"></span> Media (35%)</span>
                        <span><span class="so-badge so-badge-danger"></span> System (15%)</span>
                    </div>
                </div>

                <div class="so-mb-6">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Project Tasks</label>
                    <div class="so-progress so-progress-stacked so-progress-lg">
                        <div class="so-progress so-progress-primary" style="width: 40%">
                            <div class="so-progress-bar" style="width: 100%"></div>
                        </div>
                        <div class="so-progress so-progress-info" style="width: 30%">
                            <div class="so-progress-bar" style="width: 100%"></div>
                        </div>
                        <div class="so-progress so-progress-secondary" style="width: 20%">
                            <div class="so-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-stacked">
    <div class="so-progress so-progress-success" style="width: 25%">
        <div class="so-progress-bar" style="width: 100%"></div>
    </div>
    <div class="so-progress so-progress-warning" style="width: 35%">
        <div class="so-progress-bar" style="width: 100%"></div>
    </div>
    <div class="so-progress so-progress-danger" style="width: 15%">
        <div class="so-progress-bar" style="width: 100%"></div>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Gradient Progress -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Gradient Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Use gradient variants for a more vibrant appearance.</p>

                <div class="so-grid so-grid-cols-1 so-gap-3 so-mb-6">
                    <div class="so-progress so-progress-gradient">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>

                    <div class="so-progress so-progress-gradient-success">
                        <div class="so-progress-bar" style="width: 60%"></div>
                    </div>

                    <div class="so-progress so-progress-gradient-danger">
                        <div class="so-progress-bar" style="width: 50%"></div>
                    </div>

                    <div class="so-progress so-progress-gradient-rainbow">
                        <div class="so-progress-bar" style="width: 80%"></div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-gradient">...</div>
<div class="so-progress so-progress-gradient-success">...</div>
<div class="so-progress so-progress-gradient-danger">...</div>
<div class="so-progress so-progress-gradient-rainbow">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Stepped Progress -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Stepped/Segmented Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display progress as discrete steps.</p>

                <div class="so-mb-4">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Order Status (Step 3 of 5)</label>
                    <div class="so-progress so-progress-stepped so-progress-primary">
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

                <div class="so-mb-6">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Password Strength (Partial Step)</label>
                    <div class="so-progress so-progress-stepped so-progress-success">
                        <div class="so-progress-step so-active">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step so-active">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step partial" style="--step-progress: 60%">
                            <div class="so-progress-step-fill"></div>
                        </div>
                        <div class="so-progress-step">
                            <div class="so-progress-step-fill"></div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress so-progress-stepped so-progress-primary">
    <div class="so-progress-step so-active">
        <div class="so-progress-step-fill"></div>
    </div>
    <div class="so-progress-step so-active">
        <div class="so-progress-step-fill"></div>
    </div>
    <div class="so-progress-step">
        <div class="so-progress-step-fill"></div>
    </div>
</div>

<!-- Partial step -->
<div class="so-progress-step partial" style="--step-progress: 60%">
    <div class="so-progress-step-fill"></div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Circular Progress (Determinate) -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Circular Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Circular progress indicators for a compact visual representation.</p>

                <div class="so-d-flex so-flex-wrap so-gap-6 so-mb-6">
                    <!-- 25% -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                                        stroke-dasharray="125.6" stroke-dashoffset="94.2"></circle>
                            </svg>
                            <span class="so-progress-text">25%</span>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">25%</small>
                    </div>

                    <!-- 50% -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-success">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                                        stroke-dasharray="125.6" stroke-dashoffset="62.8"></circle>
                            </svg>
                            <span class="so-progress-text">50%</span>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">50%</small>
                    </div>

                    <!-- 75% -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-warning">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                                        stroke-dasharray="125.6" stroke-dashoffset="31.4"></circle>
                            </svg>
                            <span class="so-progress-text">75%</span>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">75%</small>
                    </div>

                    <!-- 100% -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-danger">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                                        stroke-dasharray="125.6" stroke-dashoffset="0"></circle>
                            </svg>
                            <span class="so-progress-text">100%</span>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">100%</small>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress-circular so-progress-circular-primary">
    <svg class="so-progress-ring" viewBox="0 0 48 48">
        <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
        <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                stroke-dasharray="125.6" stroke-dashoffset="31.4"></circle>
    </svg>
    <span class="so-progress-text">75%</span>
</div>

<!-- Formula: stroke-dashoffset = circumference * (1 - progress) -->
<!-- circumference = 2 * PI * r = 2 * 3.14 * 20 = 125.6 -->
<!-- For 75%: 125.6 * (1 - 0.75) = 31.4 -->', 'html') ?>
            </div>
        </div>

        <!-- Circular Progress Sizes -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Circular Progress Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Circular progress comes in five sizes.</p>

                <div class="so-d-flex so-flex-wrap so-align-items-end so-gap-6 so-mb-6">
                    <!-- Extra Small -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-xs so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 32 32">
                                <circle class="so-progress-ring-bg" cx="16" cy="16" r="13" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="16" cy="16" r="13" fill="none"
                                        stroke-dasharray="81.68" stroke-dashoffset="20.42"></circle>
                            </svg>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">XS (32px)</small>
                    </div>

                    <!-- Small -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-sm so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 40 40">
                                <circle class="so-progress-ring-bg" cx="20" cy="20" r="17" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="20" cy="20" r="17" fill="none"
                                        stroke-dasharray="106.8" stroke-dashoffset="26.7"></circle>
                            </svg>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">SM (40px)</small>
                    </div>

                    <!-- Default -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                                        stroke-dasharray="125.6" stroke-dashoffset="31.4"></circle>
                            </svg>
                            <span class="so-progress-text">75%</span>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">Default (48px)</small>
                    </div>

                    <!-- Large -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-lg so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 64 64">
                                <circle class="so-progress-ring-bg" cx="32" cy="32" r="27" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="32" cy="32" r="27" fill="none"
                                        stroke-dasharray="169.6" stroke-dashoffset="42.4"></circle>
                            </svg>
                            <span class="so-progress-text">75%</span>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">LG (64px)</small>
                    </div>

                    <!-- Extra Large -->
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-xl so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 80 80">
                                <circle class="so-progress-ring-bg" cx="40" cy="40" r="34" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="40" cy="40" r="34" fill="none"
                                        stroke-dasharray="213.6" stroke-dashoffset="53.4"></circle>
                            </svg>
                            <span class="so-progress-text">75%</span>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">XL (80px)</small>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress-circular so-progress-circular-xs">...</div>
<div class="so-progress-circular so-progress-circular-sm">...</div>
<div class="so-progress-circular">...</div>
<div class="so-progress-circular so-progress-circular-lg">...</div>
<div class="so-progress-circular so-progress-circular-xl">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Circular Progress Colors -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Circular Progress Colors</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">All eight color variants are available for circular progress.</p>

                <div class="so-d-flex so-flex-wrap so-gap-4 so-mb-6">
                    <?php
                    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
                    foreach ($colors as $color):
                    ?>
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-<?php echo $color; ?>">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"
                                        stroke-dasharray="125.6" stroke-dashoffset="31.4"></circle>
                            </svg>
                            <span class="so-progress-text">75%</span>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block"><?php echo ucfirst($color); ?></small>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?= so_code_block('<div class="so-progress-circular so-progress-circular-primary">...</div>
<div class="so-progress-circular so-progress-circular-secondary">...</div>
<div class="so-progress-circular so-progress-circular-success">...</div>
<div class="so-progress-circular so-progress-circular-danger">...</div>
<div class="so-progress-circular so-progress-circular-warning">...</div>
<div class="so-progress-circular so-progress-circular-info">...</div>
<div class="so-progress-circular so-progress-circular-light">...</div>
<div class="so-progress-circular so-progress-circular-dark">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Circular Progress Indeterminate -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Circular Progress Indeterminate (Spinner)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Indeterminate circular progress for loading states.</p>

                <div class="so-d-flex so-flex-wrap so-gap-6 so-mb-6">
                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-primary">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
                            </svg>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">Primary</small>
                    </div>

                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-success">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
                            </svg>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">Success</small>
                    </div>

                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-danger">
                            <svg class="so-progress-ring" viewBox="0 0 48 48">
                                <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
                            </svg>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">Danger</small>
                    </div>

                    <div class="so-text-center">
                        <div class="so-progress-circular so-progress-circular-lg so-progress-circular-indeterminate so-progress-circular-info">
                            <svg class="so-progress-ring" viewBox="0 0 64 64">
                                <circle class="so-progress-ring-bg" cx="32" cy="32" r="27" fill="none"></circle>
                                <circle class="so-progress-ring-fill" cx="32" cy="32" r="27" fill="none"></circle>
                            </svg>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">Large Info</small>
                    </div>
                </div>

                <?= so_code_block('<div class="so-progress-circular so-progress-circular-indeterminate so-progress-circular-primary">
    <svg class="so-progress-ring" viewBox="0 0 48 48">
        <circle class="so-progress-ring-bg" cx="24" cy="24" r="20" fill="none"></circle>
        <circle class="so-progress-ring-fill" cx="24" cy="24" r="20" fill="none"></circle>
    </svg>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Programmatic API -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Programmatic API</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control progress bars programmatically via JavaScript.</p>

                <div class="so-mb-4">
                    <label class="so-d-block so-mb-2 so-text-sm so-font-medium">API Demo Progress: <span id="api-progress-value">0%</span></label>
                    <div class="so-progress so-progress-lg so-progress-primary" id="api-demo-progress">
                        <div class="so-progress-bar" style="width: 0%">
                            <span class="so-progress-label">0%</span>
                        </div>
                    </div>
                </div>

                <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-6">
                    <button class="so-btn so-btn-sm so-btn-primary" onclick="setProgress(0)">0%</button>
                    <button class="so-btn so-btn-sm so-btn-primary" onclick="setProgress(25)">25%</button>
                    <button class="so-btn so-btn-sm so-btn-primary" onclick="setProgress(50)">50%</button>
                    <button class="so-btn so-btn-sm so-btn-primary" onclick="setProgress(75)">75%</button>
                    <button class="so-btn so-btn-sm so-btn-primary" onclick="setProgress(100)">100%</button>
                    <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="animateProgress()">Animate</button>
                </div>

                <?= so_code_block('// Set progress value
function setProgress(element, percentage) {
    const bar = element.querySelector(\'.so-progress-bar\');
    const label = element.querySelector(\'.so-progress-label\');

    bar.style.width = percentage + \'%\';
    if (label) label.textContent = percentage + \'%\';
}

// Animate progress
function animateProgress(element, from, to, duration) {
    const start = performance.now();

    function update(currentTime) {
        const elapsed = currentTime - start;
        const progress = Math.min(elapsed / duration, 1);
        const value = from + (to - from) * progress;

        setProgress(element, Math.round(value));

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    requestAnimationFrame(update);
}

// Circular progress
function setCircularProgress(element, percentage) {
    const fill = element.querySelector(\'.so-progress-ring-fill\');
    const text = element.querySelector(\'.so-progress-text\');
    const r = parseFloat(fill.getAttribute(\'r\'));
    const circumference = 2 * Math.PI * r;
    const offset = circumference * (1 - percentage / 100);

    fill.setAttribute(\'stroke-dasharray\', circumference);
    fill.setAttribute(\'stroke-dashoffset\', offset);
    if (text) text.textContent = percentage + \'%\';
}', 'javascript') ?>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <h5 class="so-mb-3">Linear Progress</h5>
                <div class="so-table-responsive so-mb-6">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-progress</code></td>
                                <td>Base progress container</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-bar</code></td>
                                <td>Progress indicator</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-label</code></td>
                                <td>Label inside progress bar</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-xs/sm/lg/xl</code></td>
                                <td>Size variants</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-{color}</code></td>
                                <td>Color variants (primary, secondary, success, etc.)</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-striped</code></td>
                                <td>Striped pattern</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-animated</code></td>
                                <td>Animated stripes (use with striped)</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-indeterminate</code></td>
                                <td>Indeterminate loading animation</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-buffer</code></td>
                                <td>Buffer progress variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-stacked</code></td>
                                <td>Container for multiple stacked bars</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-gradient</code></td>
                                <td>Primary-secondary gradient</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-stepped</code></td>
                                <td>Segmented step progress</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mb-3">Circular Progress</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-progress-circular</code></td>
                                <td>Base circular container</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-ring</code></td>
                                <td>SVG element</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-ring-bg</code></td>
                                <td>Background circle</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-ring-fill</code></td>
                                <td>Progress circle</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-text</code></td>
                                <td>Center text element</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-circular-xs/sm/lg/xl</code></td>
                                <td>Size variants</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-circular-{color}</code></td>
                                <td>Color variants</td>
                            </tr>
                            <tr>
                                <td><code>.so-progress-circular-indeterminate</code></td>
                                <td>Spinner animation</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

<script>
// Progress API demo functions
function setProgress(percentage) {
    const progress = document.getElementById('api-demo-progress');
    const bar = progress.querySelector('.so-progress-bar');
    const label = progress.querySelector('.so-progress-label');
    const valueDisplay = document.getElementById('api-progress-value');

    bar.style.width = percentage + '%';
    label.textContent = percentage + '%';
    valueDisplay.textContent = percentage + '%';
}

function animateProgress() {
    let current = 0;
    const target = 100;
    const duration = 2000; // 2 seconds
    const start = performance.now();

    function update(currentTime) {
        const elapsed = currentTime - start;
        const progress = Math.min(elapsed / duration, 1);
        const easeProgress = 1 - Math.pow(1 - progress, 3); // Ease out cubic
        const value = Math.round(easeProgress * target);

        setProgress(value);

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    // Reset first
    setProgress(0);
    setTimeout(() => requestAnimationFrame(update), 100);
}
</script>

    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
