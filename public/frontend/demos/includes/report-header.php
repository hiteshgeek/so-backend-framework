<?php
/**
 * SixOrbit UI Demo - Report Page Header
 * Shared header for finance report pages
 */
?>
<!-- Page Header Card -->
<div class="so-page-header-card">
    <nav class="so-breadcrumb">
        <a href="index.php" class="so-breadcrumb-item">
            <span class="material-icons" style="font-size: 14px;">home</span>
        </a>
        <span class="so-breadcrumb-separator">
            <span class="material-icons">chevron_right</span>
        </span>
        <a href="#" class="so-breadcrumb-item">Finance</a>
        <span class="so-breadcrumb-separator">
            <span class="material-icons">chevron_right</span>
        </span>
        <span class="so-breadcrumb-item so-active"><?= $reportTitle ?? 'Report' ?></span>
    </nav>
    <div class="so-page-header-row">
        <h1 class="so-page-title">
            <span class="so-page-title-icon">
                <span class="material-icons"><?= $reportIcon ?? 'assessment' ?></span>
            </span>
            <?= $reportTitle ?? 'Report' ?>
        </h1>
    </div>
</div>

<!-- Panel with Report Container -->
<div class="so-panel">
    <div class="so-panel-header">
        <div class="so-panel-header-left">
            <div class="so-panel-icon">
                <span class="material-icons"><?= $reportIcon ?? 'assessment' ?></span>
            </div>
            <div>
                <h3 class="so-panel-title"><?= $reportTitle ?? 'Report' ?></h3>
                <p class="so-panel-subtitle"><?= $reportSubtitle ?? '' ?></p>
            </div>
        </div>
        <div class="so-panel-header-right">
            <div class="so-panel-date-range" style="position: relative;" onclick="this.classList.toggle('open')">
                <span class="material-icons">calendar_today</span>
                <span class="so-panel-date-range-text">Apr 1, 2025 - Jan 25, 2026</span>
                <span class="material-icons so-panel-date-range-arrow">expand_more</span>
                <div class="so-panel-date-dropdown" onclick="event.stopPropagation()">
                    <div class="so-panel-date-presets">
                        <div class="so-panel-date-preset"><span class="material-icons">today</span>Today</div>
                        <div class="so-panel-date-preset"><span class="material-icons">calendar_view_week</span>Last 7 Days</div>
                        <div class="so-panel-date-preset"><span class="material-icons">calendar_month</span>Last 30 Days</div>
                        <div class="so-panel-date-preset"><span class="material-icons">calendar_view_month</span>This Month</div>
                        <div class="so-panel-date-preset so-active"><span class="material-icons">event</span>This Financial Year</div>
                    </div>
                    <div class="so-panel-date-custom">
                        <div class="so-panel-date-custom-label">Custom Range</div>
                        <div class="so-panel-date-inputs">
                            <input type="date" class="so-panel-date-input" value="2025-04-01">
                            <span>to</span>
                            <input type="date" class="so-panel-date-input" value="2026-01-25">
                        </div>
                        <button class="so-panel-date-apply">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="so-panel-body" style="padding: 0;">
