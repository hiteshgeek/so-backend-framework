<?php

/**
 * SixOrbit UI Demo - Header Include
 * Include this at the top of each page
 */

if (!defined('SO_VERSION')) {
    require_once __DIR__ . '/config.php';
}

$pageTitle = $pageTitle ?? 'SixOrbit UI';
$pageDescription = $pageDescription ?? 'SixOrbit UI Framework Demo';
$includeSearch = $includeSearch ?? true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - SixOrbit UI</title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">

    <!-- Prevent sidebar blink on page load -->
    <script>
        (function() {
            try {
                var state = localStorage.getItem('so-sidebar-state');
                if (state === 'pinned') {
                    document.documentElement.classList.add('sidebar-ready', 'sidebar-pinned');
                } else {
                    document.documentElement.classList.add('sidebar-ready', 'sidebar-collapsed');
                }
            } catch (e) {
                document.documentElement.classList.add('sidebar-ready', 'sidebar-collapsed');
            }
        })();
    </script>

    <!-- Prevent theme flash on page load -->
    <script>
        (function() {
            try {
                var theme = localStorage.getItem('so-theme-preference') || 'sidebar-dark';
                var effectiveTheme = theme;

                if (theme === 'sidebar-dark') {
                    effectiveTheme = 'light';
                    document.addEventListener('DOMContentLoaded', function() {
                        var sidebar = document.querySelector('.so-sidebar');
                        if (sidebar) sidebar.classList.add('sidebar-dark');
                    });
                } else if (theme === 'system') {
                    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        effectiveTheme = 'dark';
                    } else {
                        effectiveTheme = 'light';
                    }
                }

                document.documentElement.setAttribute('data-theme', effectiveTheme);

                var fontsize = localStorage.getItem('so-fontsize-preference');
                if (fontsize && fontsize !== 'default') {
                    document.documentElement.setAttribute('data-fontsize', fontsize);
                }
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'light');
                document.addEventListener('DOMContentLoaded', function() {
                    var sidebar = document.querySelector('.so-sidebar');
                    if (sidebar) sidebar.classList.add('sidebar-dark');
                });
            }
        })();
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Google+Sans+Text:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Prism.js for Syntax Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup-templating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>

    <!-- SixOrbit UI CSS -->
    <link rel="stylesheet" href="<?= so_asset('css', 'sixorbit-full') ?>">

    <!-- Global Page CSS (Navbar & Search) -->
    <?php $globalCss = so_page_asset('global', 'css'); ?>
    <?php if ($globalCss): ?>
        <link rel="stylesheet" href="<?= htmlspecialchars($globalCss) ?>">
    <?php endif; ?>

    <?php if (!empty($additionalCss)): ?>
        <?php foreach ($additionalCss as $css): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <style>
        /* Page-specific loading prevention */
        html:not(.sidebar-ready) .so-sidebar,
        html:not(.sidebar-ready) .so-main-content {
            visibility: hidden;
        }

        /* Report Table Styles */
        .so-report-table-wrapper {
            overflow-x: auto;
        }

        .so-report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .so-report-table th {
            background: var(--so-card-hover-bg);
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: var(--so-text-heading);
            border-bottom: 2px solid var(--so-border-color);
        }

        .so-report-table td {
            padding: 10px 16px;
            border-bottom: 1px solid var(--so-border-color);
            color: var(--so-text-primary);
        }

        .so-report-section-header td {
            background: var(--so-card-hover-bg);
            font-weight: 600;
            color: var(--so-text-heading);
            padding: 12px 16px;
        }

        .so-report-section-header .material-icons {
            font-size: 18px;
            vertical-align: middle;
            margin-right: 8px;
        }

        .so-report-group td {
            font-weight: 500;
        }

        .so-report-item td {
            color: var(--so-text-secondary);
        }

        .so-report-total td {
            background: rgba(26, 115, 232, 0.05);
            font-weight: 600;
        }

        .so-report-grand-total td {
            background: var(--so-accent-primary);
            color: white !important;
            font-weight: 600;
        }

        .so-report-grand-total .so-amount {
            color: white !important;
        }

        .so-report-indent {
            display: inline-block;
            width: 20px;
        }

        .so-amount {
            text-align: right;
            font-family: 'Roboto Mono', monospace;
        }

        .so-amount.positive {
            color: var(--so-accent-success);
        }

        .so-amount.negative {
            color: var(--so-accent-danger);
        }

        /* Page Header Card */
        .so-page-header-card {
            background: var(--so-card-bg);
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 16px;
            border: 1px solid var(--so-card-border);
        }

        .so-page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
        }

        .so-page-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 600;
            color: var(--so-text-heading);
            margin: 0;
        }

        .so-page-title-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: rgba(26, 115, 232, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--so-accent-primary);
        }

        /* Breadcrumb - Component styles are in SCSS */

        /* LMS Styles */
        .so-lms-header {
            background: linear-gradient(135deg, var(--so-accent-primary) 0%, #0d47a1 100%);
            border-radius: 12px;
            padding: 32px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .so-lms-header-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .so-lms-header-subtitle {
            opacity: 0.9;
            margin: 0;
        }

        .so-lms-header-stats {
            display: flex;
            gap: 32px;
        }

        .so-lms-stat {
            text-align: center;
        }

        .so-lms-stat-value {
            display: block;
            font-size: 32px;
            font-weight: 700;
        }

        .so-lms-stat-label {
            font-size: 13px;
            opacity: 0.8;
        }

        .so-lms-categories {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .so-lms-category-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: 1px solid var(--so-border-color);
            border-radius: 20px;
            background: var(--so-card-bg);
            color: var(--so-text-secondary);
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .so-lms-category-btn:hover {
            border-color: var(--so-accent-primary);
            color: var(--so-accent-primary);
        }

        .so-lms-category-btn.active {
            background: var(--so-accent-primary);
            border-color: var(--so-accent-primary);
            color: white;
        }

        .so-lms-category-btn .material-icons {
            font-size: 18px;
        }

        .so-lms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .so-lms-card {
            background: var(--so-card-bg);
            border: 1px solid var(--so-card-border);
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
        }

        .so-lms-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .so-lms-card-thumbnail {
            position: relative;
            aspect-ratio: 16/9;
            background: var(--so-card-hover-bg);
        }

        .so-lms-card-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .so-lms-card-play {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 56px;
            height: 56px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .so-lms-card:hover .so-lms-card-play {
            opacity: 1;
        }

        .so-lms-card-play .material-icons {
            font-size: 32px;
        }

        .so-lms-card-duration {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
        }

        .so-lms-card-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .so-lms-card-badge.completed {
            background: var(--so-accent-success);
            color: white;
        }

        .so-lms-card-badge .material-icons {
            font-size: 14px;
        }

        .so-lms-card-content {
            padding: 16px;
        }

        .so-lms-card-category {
            font-size: 11px;
            font-weight: 600;
            color: var(--so-accent-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .so-lms-card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--so-text-heading);
            margin: 8px 0;
        }

        .so-lms-card-desc {
            font-size: 13px;
            color: var(--so-text-secondary);
            margin: 0 0 12px 0;
        }

        .so-lms-card-progress {
            height: 4px;
            background: var(--so-border-color);
            border-radius: 2px;
            overflow: hidden;
        }

        .so-lms-card-progress-bar {
            height: 100%;
            background: var(--so-accent-primary);
            border-radius: 2px;
            transition: width 0.3s;
        }

        /* Breadcrumb Bar */
        .so-breadcrumb-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: var(--so-card-bg);
            border-bottom: 1px solid var(--so-border-color);
            font-size: 13px;
        }

        .so-breadcrumb-bar-home {
            color: var(--so-text-secondary);
            display: flex;
        }

        .so-breadcrumb-bar-home:hover {
            color: var(--so-accent-primary);
        }

        .so-breadcrumb-bar-separator {
            color: var(--so-text-muted);
        }

        .so-breadcrumb-bar-separator .material-icons {
            font-size: 16px;
        }

        .so-breadcrumb-bar-item {
            color: var(--so-text-secondary);
        }

        .so-breadcrumb-bar-item.active {
            color: var(--so-text-primary);
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .so-lms-header {
                flex-direction: column;
                text-align: center;
                gap: 24px;
            }

            .so-lms-header-stats {
                width: 100%;
                justify-content: space-around;
            }
        }

        /* Example Block Styles - Container for preview + code */
        .so-example-block {
            border: 1px solid var(--so-border-color);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .so-example-preview {
            padding: 24px;
            background: var(--so-card-bg);
        }

        .so-example-block .so-code-block {
            border: none;
            border-radius: 0;
            border-top: 1px solid var(--so-border-color);
        }

        /* Code Block Styles */
        .so-code-block {
            background: #f8f9fa;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid var(--so-border-color);
        }

        .so-code-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-bottom: 1px solid var(--so-border-color);
            background: var(--so-card-bg);
        }

        .so-code-label {
            display: flex;
            align-items: center;
            font-size: 12px;
            font-weight: 600;
            color: var(--so-text-secondary);
        }

        .so-code-label .material-icons {
            font-size: 14px;
            margin-right: 4px;
        }

        /* Demo Section Utilities */
        .so-demo-section-title {
            margin-bottom: 12px;
            font-size: 13px;
            color: var(--so-text-secondary);
        }

        .so-demo-section-title-sm {
            margin-bottom: 8px;
            font-size: 12px;
            color: var(--so-text-secondary);
        }

        .so-demo-section-heading {
            margin-bottom: 16px;
            font-size: 14px;
            font-weight: 600;
        }

        .so-demo-hint {
            font-size: 12px;
            color: var(--so-text-muted);
            margin-bottom: 12px;
        }

        .so-demo-small-note {
            display: block;
            margin-top: 8px;
            color: var(--so-text-muted);
        }

        .so-demo-output {
            padding: 12px;
            font-family: monospace;
            font-size: 13px;
        }

        .so-demo-grid-gap {
            gap: 24px;
        }

        .so-demo-grid-gap-sm {
            gap: 16px;
        }

        .so-demo-icon-sm {
            font-size: 18px;
            margin-right: 8px;
        }

        .so-demo-icon-inline {
            font-size: 16px;
            vertical-align: middle;
            margin-right: 4px;
        }

        /* Sticky sidebar tabs */
        .so-tabs-sticky {
            position: sticky;
            top: calc(var(--so-navbar-height) + 16px);
            align-self: flex-start;
        }

        /* Tab content margin */
        .so-tab-content-spaced {
            margin-top: 16px;
        }

        /* Tabbed Code Block */
        .so-code-block-tabbed .so-code-header {
            padding: 0 12px 0 0;
        }

        .so-code-tabs {
            display: flex;
            gap: 0;
            flex: 1;
        }

        .so-code-tab {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 10px 16px;
            border: none;
            background: transparent;
            color: var(--so-text-secondary);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            border-bottom: 2px solid transparent;
        }

        .so-code-tab:hover {
            color: var(--so-text-primary);
            background: var(--so-card-hover-bg);
        }

        .so-code-tab.so-active {
            color: var(--so-accent-primary);
            border-bottom-color: var(--so-accent-primary);
        }

        .so-code-tab .material-icons {
            font-size: 14px;
        }

        .so-code-body {
            position: relative;
        }

        .so-code-pane {
            display: none;
        }

        .so-code-pane.so-active {
            display: block;
        }

        /* Dropdown item danger color */
        .so-dropdown-item-danger {
            color: var(--so-accent-danger);
        }

        /* Selection style icons */
        .so-selection-icon-success {
            color: var(--so-accent-success);
        }

        .so-selection-icon-warning {
            color: var(--so-accent-warning);
        }

        .so-selection-icon-danger {
            color: var(--so-accent-danger);
        }

        /* Tooltip demo icons */
        .so-tooltip-demo-icon {
            font-size: 18px;
        }

        /* Description text */
        .so-demo-desc {
            margin-bottom: 16px;
            color: var(--so-text-secondary);
            font-size: 14px;
        }

        .so-demo-desc-sm {
            font-size: 12px;
            color: var(--so-text-secondary);
            margin: 0;
        }

        .so-demo-note {
            margin-top: 12px;
            font-size: 12px;
            color: var(--so-text-secondary);
        }

        /* Section heading with margin */
        .so-demo-section-heading-spaced {
            margin: 24px 0 16px 0;
            font-size: 14px;
            font-weight: 600;
        }

        /* Card simple text */
        .so-demo-card-title {
            margin-bottom: 8px;
        }

        .so-demo-card-text {
            color: var(--so-text-secondary);
        }

        /* Terminal icon inline */
        .so-demo-terminal-icon {
            font-size: 16px;
            vertical-align: middle;
            margin-right: 4px;
        }

        /* Event output panel */
        .so-demo-event-output {
            flex: 1;
            padding: 12px;
            font-size: 13px;
            color: var(--so-text-secondary);
        }

        /* h4 badge section title */
        .so-demo-badge-title {
            margin-bottom: 12px;
            font-size: 14px;
            color: var(--so-text-secondary);
        }

        /* h5 settings title */
        .so-demo-settings-title {
            margin-bottom: 8px;
        }

        /* Button progress hint */
        .so-demo-progress-hint {
            font-size: 12px;
            color: var(--so-text-secondary);
            margin: 0;
        }

        /* Done state title */
        .so-demo-done-state-title {
            margin-top: 24px;
            margin-bottom: 12px;
            font-size: 13px;
            color: var(--so-text-secondary);
        }

        .so-code-copy {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            padding: 0;
            border: none;
            background: transparent;
            color: var(--so-text-secondary);
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .so-code-copy:hover {
            background: var(--so-card-hover-bg);
            color: var(--so-accent-primary);
        }

        .so-code-copy .material-icons {
            font-size: 18px;
        }

        .so-code-copy.copied {
            color: var(--so-accent-success);
        }

        .so-code-content {
            margin: 0;
            padding: 16px;
            overflow-x: auto;
            font-size: 13px;
            line-height: 1.7;
            background: #f8f9fa;
        }

        .so-code-content code {
            background: transparent !important;
            padding: 0 !important;
            font-size: 13px;
            font-family: 'Roboto Mono', 'SF Mono', 'Monaco', 'Consolas', monospace;
            white-space: pre;
        }

        /* Prism overrides for light mode */
        .so-code-content code[class*="language-"],
        .so-code-content pre[class*="language-"] {
            background: transparent;
            font-size: 13px;
            text-shadow: none;
        }

        /* Dark mode syntax highlighting */
        [data-theme="dark"] .so-code-block {
            background: #1e1e2e;
        }

        [data-theme="dark"] .so-code-content {
            background: #1e1e2e;
        }

        [data-theme="dark"] .so-code-content code {
            color: #cdd6f4;
        }

        [data-theme="dark"] .so-code-content .token.tag {
            color: #89b4fa;
        }

        [data-theme="dark"] .so-code-content .token.attr-name {
            color: #f9e2af;
        }

        [data-theme="dark"] .so-code-content .token.attr-value {
            color: #a6e3a1;
        }

        [data-theme="dark"] .so-code-content .token.punctuation {
            color: #9399b2;
        }

        [data-theme="dark"] .so-code-content .token.comment {
            color: #6c7086;
        }

        [data-theme="dark"] .so-code-content .token.string {
            color: #a6e3a1;
        }

        /* ==============================================
           PROJECT-SPECIFIC: Outlet Selector Dropdown
           ============================================== */
        #outletSelector .so-dropdown-menu {
            min-width: 200px;
            border-radius: 12px !important;
            overflow: hidden;
        }

        #outletSelector .so-dropdown-item {
            white-space: nowrap;
        }

        /* ==============================================
           PROJECT-SPECIFIC: User Status Selector
           ============================================== */
        #userStatusSelector .so-dropdown-trigger {
            border-radius: 999px !important;
        }

        #userStatusSelector .so-dropdown-menu {
            min-width: 260px;
            border-radius: 12px !important;
            overflow: hidden;
        }

        #userStatusSelector .so-dropdown-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--so-text-muted);
            border-radius: 12px 12px 0 0;
            border-bottom: 1px solid var(--so-border-color);
        }

        #userStatusSelector .so-dropdown-header .material-icons {
            font-size: 16px;
        }

        #userStatusSelector .so-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
        }

        /* Status indicator dot - aligned with title */
        #userStatusSelector .so-dropdown-item .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-indicator.available {
            background-color: #34a853;
        }

        .status-indicator.with-customer {
            background-color: #1a73e8;
        }

        .status-indicator.in-meeting {
            background-color: #9c27b0;
        }

        .status-indicator.on-call {
            background-color: #ff9800;
        }

        .status-indicator.on-leave {
            background-color: #757575;
        }

        .status-indicator.away {
            background-color: #ea4335;
        }

        /* Status option content */
        .status-option-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 0;
        }

        .status-option-title {
            font-weight: 500;
            font-size: 14px;
            color: var(--so-text-primary);
            line-height: 1.4;
        }

        .status-option-desc {
            font-size: 11px;
            color: var(--so-text-muted);
            margin-top: 2px;
            line-height: 1.2;
        }

        /* Adjust check icon position */
        #userStatusSelector .so-dropdown-check {
            margin-left: auto;
            color: var(--so-accent-primary);
        }

        /* ==============================================
           PROJECT-SPECIFIC: Navbar Dropdown Triggers
           ============================================== */
        /* Remove focus/hover outline on these specific dropdowns */
        #outletSelector .so-dropdown-trigger:hover,
        #outletSelector .so-dropdown-trigger:focus,
        #userStatusSelector .so-dropdown-trigger:hover,
        #userStatusSelector .so-dropdown-trigger:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Status indicator in trigger */
        #userStatusSelector .so-dropdown-trigger .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
    </style>

    <script>
        function copyCode(button) {
            var codeBlock = button.closest('.so-code-block');
            var code;

            // Check if tabbed code block
            if (codeBlock.classList.contains('so-code-block-tabbed')) {
                // Get active pane's code
                var activePane = codeBlock.querySelector('.so-code-pane.so-active');
                code = activePane ? activePane.querySelector('code').innerText : '';
            } else {
                // Standard code block
                code = codeBlock.querySelector('code').innerText;
            }

            // Function to show success feedback
            function showSuccess() {
                button.classList.add('copied');
                button.querySelector('.material-icons').textContent = 'check';

                if (typeof SOTooltip !== 'undefined') {
                    SOTooltip.showTemporary(button, {
                        content: 'Copied!',
                        color: 'success',
                        position: 'top',
                        autoHide: 2000
                    });
                }

                setTimeout(function() {
                    button.classList.remove('copied');
                    button.querySelector('.material-icons').textContent = 'content_copy';
                }, 2000);
            }

            // Function to show error feedback
            function showError() {
                if (typeof SOTooltip !== 'undefined') {
                    SOTooltip.showTemporary(button, {
                        content: 'Copy failed',
                        color: 'danger',
                        position: 'top',
                        autoHide: 2000
                    });
                }
            }

            // Try modern Clipboard API first (requires secure context)
            if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
                navigator.clipboard.writeText(code).then(showSuccess).catch(function(err) {
                    console.error('Clipboard API failed:', err);
                    // Try fallback
                    if (fallbackCopy(code)) {
                        showSuccess();
                    } else {
                        showError();
                    }
                });
            } else {
                // Fallback for non-secure contexts (HTTP)
                if (fallbackCopy(code)) {
                    showSuccess();
                } else {
                    showError();
                }
            }
        }

        // Fallback copy method using textarea and execCommand
        function fallbackCopy(text) {
            var textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            textarea.style.top = '0';
            textarea.setAttribute('readonly', '');
            document.body.appendChild(textarea);

            try {
                textarea.select();
                textarea.setSelectionRange(0, textarea.value.length);
                var success = document.execCommand('copy');
                document.body.removeChild(textarea);
                return success;
            } catch (err) {
                console.error('Fallback copy failed:', err);
                document.body.removeChild(textarea);
                return false;
            }
        }

        // Initialize code block tabs
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.so-code-tabs').forEach(function(tabsContainer) {
                tabsContainer.querySelectorAll('.so-code-tab').forEach(function(tab) {
                    tab.addEventListener('click', function() {
                        var codeBlock = this.closest('.so-code-block');
                        var targetId = this.getAttribute('data-so-target');

                        // Update active tab
                        tabsContainer.querySelectorAll('.so-code-tab').forEach(function(t) {
                            t.classList.remove('so-active');
                        });
                        this.classList.add('so-active');

                        // Update active pane
                        codeBlock.querySelectorAll('.so-code-pane').forEach(function(pane) {
                            pane.classList.remove('so-active');
                        });
                        codeBlock.querySelector(targetId).classList.add('so-active');
                    });
                });
            });
        });
    </script>
</head>

<body>