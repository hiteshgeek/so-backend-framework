<?php

/**
 * Documentation Index
 *
 * Static PHP documentation portal linking to PHP doc files
 * Uses Google Material Design styling and Material Design Icons
 */
$baseUrl = getenv('APP_URL') ?: 'http://sixorbit.local';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SO Framework Documentation</title>
    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Material Design Color Palette */
            --md-primary: #1976d2;
            --md-primary-dark: #1565c0;
            --md-primary-light: #42a5f5;
            --md-secondary: #7c4dff;
            --md-surface: #ffffff;
            --md-background: #fafafa;
            --md-error: #d32f2f;
            --md-success: #388e3c;
            --md-warning: #f57c00;
            --md-info: #0288d1;
            --md-on-primary: #ffffff;
            --md-on-surface: #212121;
            --md-on-surface-medium: #666666;
            --md-on-surface-disabled: #9e9e9e;
            --md-divider: #e0e0e0;
            --md-elevation-1: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            --md-elevation-2: 0 3px 6px rgba(0, 0, 0, 0.15), 0 2px 4px rgba(0, 0, 0, 0.12);
            --md-elevation-3: 0 10px 20px rgba(0, 0, 0, 0.15), 0 3px 6px rgba(0, 0, 0, 0.10);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--md-on-surface);
            background: var(--md-background);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Material App Bar */
        .header {
            background: var(--md-primary);
            color: var(--md-on-primary);
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            box-shadow: var(--md-elevation-2);
        }

        .header-inner {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header h1 .mdi {
            font-size: 28px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.87;
            margin-left: 16px;
            font-weight: 400;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px 20px 40px;
        }

        /* Stats Cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--md-surface);
            padding: 24px 16px;
            border-radius: 8px;
            text-align: center;
            box-shadow: var(--md-elevation-1);
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .stat-card:hover {
            box-shadow: var(--md-elevation-2);
        }

        .stat-card .stat-icon {
            font-size: 32px;
            color: var(--md-primary-light);
            margin-bottom: 8px;
            display: block;
        }

        .stat-card h3 {
            font-size: 32px;
            color: var(--md-primary);
            font-weight: 500;
            margin-bottom: 4px;
        }

        .stat-card p {
            font-size: 11px;
            color: var(--md-on-surface-medium);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Reading Order Note */
        .reading-order-note {
            background: #e3f2fd;
            border: 1px solid var(--md-primary-light);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: var(--md-primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .reading-order-note .mdi {
            font-size: 20px;
        }

        /* Section */
        .section {
            margin-bottom: 28px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--md-on-surface-medium);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title .mdi {
            font-size: 18px;
            color: var(--md-primary);
        }

        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 12px;
        }

        .grid-featured {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        /* Material Card */
        .card {
            background: var(--md-surface);
            border-radius: 8px;
            padding: 16px 18px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            box-shadow: var(--md-elevation-1);
            transition: box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .card-body {
            flex: 1;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--md-primary);
            transform: scaleX(0);
            transition: transform 0.2s;
        }

        .card:hover {
            box-shadow: var(--md-elevation-3);
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card h3 {
            color: var(--md-on-surface);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card h3 .mdi {
            font-size: 20px;
            color: var(--md-primary);
        }

        .card p {
            color: var(--md-on-surface-medium);
            font-size: 12px;
            line-height: 1.5;
        }

        .card .badge {
            margin-top: 10px;
            align-self: flex-start;
        }

        /* Featured Card */
        .card.featured {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 1px solid var(--md-primary-light);
            padding: 18px 20px;
        }

        .card.featured::before {
            background: var(--md-primary-dark);
            transform: scaleX(1);
        }

        .card.featured h3 {
            color: var(--md-primary-dark);
            font-size: 15px;
        }

        .card.featured p {
            font-size: 13px;
            color: #455a64;
        }

        .card.featured:hover {
            box-shadow: 0 6px 20px rgba(25, 118, 210, 0.25);
        }

        /* Reading Order Number */
        .card-number {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 24px;
            height: 24px;
            background: var(--md-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .card.featured .card-number {
            background: var(--md-primary-dark);
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        /* Material Chips */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .badge .mdi {
            font-size: 12px;
        }

        .badge-essential {
            background: #ffebee;
            color: #c62828;
        }

        .badge-new {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-default {
            background: #e3f2fd;
            color: #1565c0;
        }

        .badge-enterprise {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-technical {
            background: #eceff1;
            color: #546e7a;
        }

        .badge-featured {
            background: var(--md-primary);
            color: white;
        }

        /* Footer */
        footer {
            background: var(--md-surface);
            padding: 24px;
            text-align: center;
            border-top: 1px solid var(--md-divider);
            margin-top: 32px;
        }

        footer p {
            color: var(--md-on-surface-medium);
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        footer p .mdi {
            font-size: 16px;
        }

        footer a {
            color: var(--md-primary);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        footer a .mdi {
            font-size: 14px;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid,
            .grid-featured {
                grid-template-columns: 1fr;
            }

            .header {
                height: auto;
                padding: 16px;
            }

            .header h1 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-inner">
            <h1><span class="mdi mdi-book-open-page-variant"></span> SO Framework Documentation</h1>
            <p><span class="mdi mdi-tag"></span> Version 2.0.0</p>
        </div>
    </div>

    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <span class="mdi mdi-check-circle stat-icon"></span>
                <h3>100%</h3>
                <p>Documentation Coverage</p>
            </div>
            <div class="stat-card">
                <span class="mdi mdi-cube-outline stat-icon"></span>
                <h3>20</h3>
                <p>Core Modules</p>
            </div>
            <div class="stat-card">
                <span class="mdi mdi-file-document-multiple stat-icon"></span>
                <h3>23</h3>
                <p>Guide Documents</p>
            </div>
            <div class="stat-card">
                <span class="mdi mdi-rocket-launch stat-icon"></span>
                <h3>100%</h3>
                <p>Production Ready</p>
            </div>
        </div>

        <div class="reading-order-note">
            <span class="mdi mdi-information"></span>
            <strong>Reading Order:</strong> Follow the numbered sequence (1-23) for optimal learning. Start with README (#1) and work through each document in order.
        </div>

        <div class="section">
            <div class="section-title"><span class="mdi mdi-numeric"></span> Complete Documentation (1-23)</div>
            <div class="grid">
                <!-- 1. README -->
                <a href="/docs/readme" class="card">
                    <span class="card-number">1</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-rocket-launch"></span> README</h3>
                        <p>Framework overview and quick install guide</p>
                    </div>
                    <span class="badge badge-essential"><span class="mdi mdi-alert-circle"></span> Essential</span>
                </a>
                <!-- 2. Setup Guide -->
                <a href="/docs/setup" class="card">
                    <span class="card-number">2</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-cog"></span> Setup Guide</h3>
                        <p>Installation and configuration</p>
                    </div>
                    <span class="badge badge-essential"><span class="mdi mdi-alert-circle"></span> Essential</span>
                </a>
                <!-- 3. Configuration -->
                <a href="/docs/configuration" class="card">
                    <span class="card-number">3</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-wrench"></span> Configuration</h3>
                        <p>.env and config file guide</p>
                    </div>
                    <span class="badge badge-default"><span class="mdi mdi-tune"></span> Config</span>
                </a>
                <!-- 4. Quick Start -->
                <a href="/docs/quick-start" class="card">
                    <span class="card-number">4</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-flash"></span> Quick Start</h3>
                        <p>Fast reference for common tasks</p>
                    </div>
                    <span class="badge badge-default"><span class="mdi mdi-timer"></span> Quick</span>
                </a>
                <!-- 5. Security Layer -->
                <a href="/docs/security-layer" class="card">
                    <span class="card-number">5</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-lock"></span> Security Layer</h3>
                        <p>CSRF, JWT, Rate Limiting, XSS Prevention</p>
                    </div>
                    <span class="badge badge-essential"><span class="mdi mdi-alert-circle"></span> Essential</span>
                </a>
                <!-- 6. Validation System -->
                <a href="/docs/validation-system" class="card">
                    <span class="card-number">6</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-check-decagram"></span> Validation System</h3>
                        <p>27+ validation rules, custom rules</p>
                    </div>
                    <span class="badge badge-essential"><span class="mdi mdi-alert-circle"></span> Essential</span>
                </a>
                <!-- 7. Framework Features -->
                <a href="/docs/framework-features" class="card">
                    <span class="card-number">7</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-office-building"></span> Framework Features</h3>
                        <p>Overview of all table systems</p>
                    </div>
                    <span class="badge badge-enterprise"><span class="mdi mdi-view-dashboard"></span> Overview</span>
                </a>
                <!-- 8. Activity Logging -->
                <a href="/docs/activity-logging" class="card">
                    <span class="card-number">8</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-clipboard-text-clock"></span> Activity Logging</h3>
                        <p>Audit trail and compliance</p>
                    </div>
                    <span class="badge badge-enterprise"><span class="mdi mdi-star"></span> Enterprise</span>
                </a>
                <!-- 9. Queue System -->
                <a href="/docs/queue-system" class="card">
                    <span class="card-number">9</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-tray-full"></span> Queue System</h3>
                        <p>Background job processing</p>
                    </div>
                    <span class="badge badge-enterprise"><span class="mdi mdi-star"></span> Enterprise</span>
                </a>
                <!-- 10. Notification System -->
                <a href="/docs/notification-system" class="card">
                    <span class="card-number">10</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-bell"></span> Notification System</h3>
                        <p>Multi-channel notifications</p>
                    </div>
                    <span class="badge badge-enterprise"><span class="mdi mdi-star"></span> Enterprise</span>
                </a>
                <!-- 11. Cache System -->
                <a href="/docs/cache-system" class="card">
                    <span class="card-number">11</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-database"></span> Cache System</h3>
                        <p>Database and in-memory caching</p>
                    </div>
                    <span class="badge badge-enterprise"><span class="mdi mdi-speedometer"></span> Performance</span>
                </a>
                <!-- 12. Session System -->
                <a href="/docs/session-system" class="card">
                    <span class="card-number">12</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-key"></span> Session System</h3>
                        <p>Database-driven sessions</p>
                    </div>
                    <span class="badge badge-enterprise"><span class="mdi mdi-arrow-expand-all"></span> Scalability</span>
                </a>
                <!-- 13. Authentication System -->
                <a href="/docs/auth-system" class="card">
                    <span class="card-number">13</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-shield-lock"></span> Authentication System</h3>
                        <p>Session auth, JWT, remember me</p>
                    </div>
                    <span class="badge badge-new"><span class="mdi mdi-new-box"></span> New</span>
                </a>
                <!-- 14. Console Commands -->
                <a href="/docs/console-commands" class="card">
                    <span class="card-number">14</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-console"></span> Console Commands</h3>
                        <p>CLI reference for commands</p>
                    </div>
                    <span class="badge badge-new"><span class="mdi mdi-new-box"></span> New</span>
                </a>
                <!-- 15. View Templates -->
                <a href="/docs/view-templates" class="card">
                    <span class="card-number">15</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-image-multiple"></span> View Templates</h3>
                        <p>PHP native view templating guide</p>
                    </div>
                    <span class="badge badge-new"><span class="mdi mdi-new-box"></span> New</span>
                </a>
                <!-- 16. Routing System -->
                <a href="/docs/routing-system" class="card">
                    <span class="card-number">16</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-routes"></span> Routing System</h3>
                        <p>Routes, parameters, constraints, model binding</p>
                    </div>
                    <span class="badge badge-new"><span class="mdi mdi-new-box"></span> New</span>
                </a>
                <!-- 17. Project Structure -->
                <a href="/docs/project-structure" class="card">
                    <span class="card-number">17</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-folder-multiple"></span> Project Structure</h3>
                        <p>Every folder and file explained in detail</p>
                    </div>
                    <span class="badge badge-new"><span class="mdi mdi-new-box"></span> New</span>
                </a>
                <!-- 18. Middleware -->
                <a href="/docs/middleware" class="card">
                    <span class="card-number">18</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-filter"></span> Middleware</h3>
                        <p>Request pipeline and middleware</p>
                    </div>
                    <span class="badge badge-technical"><span class="mdi mdi-cogs"></span> Technical</span>
                </a>
                <!-- 19. Documentation Review -->
                <a href="/docs/documentation-review" class="card">
                    <span class="card-number">19</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-clipboard-check"></span> Documentation Review</h3>
                        <p>Coverage analysis of all modules</p>
                    </div>
                    <span class="badge badge-technical"><span class="mdi mdi-information"></span> Meta</span>
                </a>
                <!-- 20. Documentation Structure -->
                <a href="/docs/documentation-structure" class="card">
                    <span class="card-number">20</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-sitemap"></span> Documentation Structure</h3>
                        <p>How documentation is organized</p>
                    </div>
                    <span class="badge badge-technical"><span class="mdi mdi-information"></span> Meta</span>
                </a>
                <!-- 21. Rename Process -->
                <a href="/docs/rename" class="card">
                    <span class="card-number">21</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-pencil"></span> Rename Process</h3>
                        <p>Step-by-step rename guide</p>
                    </div>
                    <span class="badge badge-default"><span class="mdi mdi-book-outline"></span> Guide</span>
                </a>
                <!-- 22. Framework Branding -->
                <a href="/docs/branding" class="card">
                    <span class="card-number">22</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-brush"></span> Framework Branding</h3>
                        <p>File reference for renaming</p>
                    </div>
                    <span class="badge badge-default"><span class="mdi mdi-bookmark"></span> Reference</span>
                </a>
                <!-- 23. Comprehensive Guide -->
                <a href="/docs/comprehensive" class="card featured">
                    <span class="card-number">23</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-book-open-variant"></span> Comprehensive Guide</h3>
                        <p>Complete framework reference with all features and examples</p>
                    </div>
                    <span class="badge badge-featured"><span class="mdi mdi-check"></span> Complete</span>
                </a>
            </div>
        </div>

        <div class="section">
            <div class="section-title"><span class="mdi mdi-star"></span> Quick Access</div>
            <div class="grid grid-featured">
                <a href="/docs/index" class="card featured">
                    <span class="card-number">★</span>
                    <div class="card-body">
                        <h3><span class="mdi mdi-folder-table"></span> Documentation Index</h3>
                        <p>Navigation hub with request flow diagrams and reading order tables.</p>
                    </div>
                    <span class="badge badge-featured"><span class="mdi mdi-arrow-right"></span> Start Here</span>
                </a>
            </div>
        </div>
    </div>

    <footer>
        <p><strong><span class="mdi mdi-cube"></span> <?= htmlspecialchars(config('app.name', 'SO Framework')) ?> v<?= htmlspecialchars(config('app.version', '1.0.0')) ?></strong></p>
        <p><span class="mdi mdi-language-php"></span> Built with PHP 8.3+ | <span class="mdi mdi-application-brackets"></span> Modern Architecture | <span class="mdi mdi-shield-check"></span> Security First</p>
        <p style="margin-top: 12px;">
            <a href="/docs/readme"><span class="mdi mdi-play-circle"></span> Start Here</a> |
            <a href="/docs/index"><span class="mdi mdi-view-list"></span> Full Index</a> |
            <a href="/docs/comprehensive"><span class="mdi mdi-book-open-variant"></span> Complete Guide</a>
        </p>
    </footer>
</body>

</html>