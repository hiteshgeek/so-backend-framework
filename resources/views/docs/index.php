<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Documentation') ?></title>
    <?php include __DIR__ . '/_styles.php'; ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="docs-header">
        <div class="docs-header-inner">
            <div>
                <h1><span class="mdi mdi-book-open-page-variant"></span> <?= htmlspecialchars(config('app.name')) ?> Documentation</h1>
                <p class="subtitle">Complete guide to building applications</p>
            </div>
            <a href="<?= htmlspecialchars(config('app.url')) ?>/" class="docs-nav-link"><span class="mdi mdi-home"></span> Back to Home</a>
        </div>
    </div>

    <div class="docs-container">
        <div class="docs-stats">
            <div class="docs-stat-card">
                <span class="mdi mdi-check-circle stat-icon"></span>
                <h3>100%</h3>
                <p>Documentation Coverage</p>
            </div>
            <div class="docs-stat-card">
                <span class="mdi mdi-cube-outline stat-icon"></span>
                <h3>20</h3>
                <p>Core Modules</p>
            </div>
            <div class="docs-stat-card">
                <span class="mdi mdi-file-document-multiple stat-icon"></span>
                <h3>21</h3>
                <p>Guide Documents</p>
            </div>
            <div class="docs-stat-card">
                <span class="mdi mdi-rocket-launch stat-icon"></span>
                <h3>100%</h3>
                <p>Production Ready</p>
            </div>
        </div>

        <div class="docs-section">
            <div class="docs-section-title"><span class="mdi mdi-play-circle"></span> Getting Started</div>
            <div class="docs-grid">
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/readme" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-rocket-launch"></span> README</h3>
                        <p>Framework overview and quick introduction.</p>
                    </div>
                    <span class="badge badge-essential">Essential</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/setup" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-cog"></span> Setup Guide</h3>
                        <p>Installation and setup instructions.</p>
                    </div>
                    <span class="badge badge-essential">Essential</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/configuration" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-wrench"></span> Configuration</h3>
                        <p>Configuration system and environment setup.</p>
                    </div>
                    <span class="badge badge-essential">Essential</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/quick-start" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-flash"></span> Quick Start</h3>
                        <p>Build your first route, controller, and view.</p>
                    </div>
                    <span class="badge badge-essential">Essential</span>
                </a>
            </div>
        </div>

        <div class="docs-section">
            <div class="docs-section-title"><span class="mdi mdi-cube-outline"></span> Core Architecture</div>
            <div class="docs-grid">
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/framework-features" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-office-building"></span> Framework Features</h3>
                        <p>Overview of all systems and capabilities.</p>
                    </div>
                    <span class="badge badge-default">Overview</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/view-templates" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-image-multiple"></span> View Templates</h3>
                        <p>PHP native view templating and layouts.</p>
                    </div>
                    <span class="badge badge-default">Core</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/asset-management" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-package-variant-closed"></span> Asset Management</h3>
                        <p>CSS/JS loading, cache busting, CDN support.</p>
                    </div>
                    <span class="badge badge-default">Core</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/auth-system" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-shield-lock"></span> Authentication System</h3>
                        <p>Session auth, JWT, remember me.</p>
                    </div>
                    <span class="badge badge-default">Core</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/security-layer" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-lock"></span> Security Layer</h3>
                        <p>CSRF, JWT, Rate Limiting, XSS Prevention.</p>
                    </div>
                    <span class="badge badge-essential">Essential</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/validation-system" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-check-decagram"></span> Validation System</h3>
                        <p>27+ validation rules, custom rules.</p>
                    </div>
                    <span class="badge badge-essential">Essential</span>
                </a>
            </div>
        </div>

        <div class="docs-section">
            <div class="docs-section-title"><span class="mdi mdi-domain"></span> Enterprise Features</div>
            <div class="docs-grid">
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/session-system" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-key"></span> Session System</h3>
                        <p>Database-driven sessions for horizontal scaling.</p>
                    </div>
                    <span class="badge badge-enterprise">Enterprise</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/cache-system" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-database"></span> Cache System</h3>
                        <p>Database and in-memory caching.</p>
                    </div>
                    <span class="badge badge-enterprise">Enterprise</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/queue-system" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-tray-full"></span> Queue System</h3>
                        <p>Background job processing.</p>
                    </div>
                    <span class="badge badge-enterprise">Enterprise</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/notification-system" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-bell"></span> Notification System</h3>
                        <p>Multi-channel notifications.</p>
                    </div>
                    <span class="badge badge-enterprise">Enterprise</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/activity-logging" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-clipboard-text-clock"></span> Activity Logging</h3>
                        <p>Audit trail and compliance.</p>
                    </div>
                    <span class="badge badge-enterprise">Enterprise</span>
                </a>
            </div>
        </div>

        <div class="docs-section">
            <div class="docs-section-title"><span class="mdi mdi-wrench"></span> Developer Tools</div>
            <div class="docs-grid">
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/console-commands" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-console"></span> Console Commands</h3>
                        <p>CLI reference for scaffolding and tasks.</p>
                    </div>
                    <span class="badge badge-default">Tools</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/rename" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-pencil"></span> Rename Process</h3>
                        <p>Rename and customize framework branding.</p>
                    </div>
                    <span class="badge badge-default">Tools</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/branding" class="doc-card">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-brush"></span> Framework Branding</h3>
                        <p>Framework name and branding reference.</p>
                    </div>
                    <span class="badge badge-default">Reference</span>
                </a>
            </div>
        </div>

        <div class="docs-section">
            <div class="docs-section-title"><span class="mdi mdi-star"></span> Complete References</div>
            <div class="docs-grid docs-grid-featured">
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/comprehensive" class="doc-card featured">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-book-open-variant"></span> Comprehensive Guide</h3>
                        <p>Full documentation covering all features with examples and best practices.</p>
                    </div>
                    <span class="badge badge-featured">Complete</span>
                </a>
                <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/documentation-review" class="doc-card featured">
                    <div class="doc-card-body">
                        <h3><span class="mdi mdi-clipboard-check"></span> Documentation Review</h3>
                        <p>Coverage analysis of all modules.</p>
                    </div>
                    <span class="badge badge-featured">Meta</span>
                </a>
            </div>
        </div>
    </div>

    <footer class="docs-footer">
        <p><strong><span class="mdi mdi-cube"></span> SO Framework v2.0.0</strong></p>
        <p><span class="mdi mdi-language-php"></span> Built with PHP 8.3+ | <span class="mdi mdi-application-brackets"></span> Modern Architecture | <span class="mdi mdi-shield-check"></span> Security First</p>
        <p style="margin-top: 8px;">
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/readme"><span class="mdi mdi-play-circle"></span> Start Here</a> |
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/index"><span class="mdi mdi-view-list"></span> Full Index</a> |
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/comprehensive"><span class="mdi mdi-book-open-variant"></span> Complete Guide</a>
        </p>
    </footer>
</body>
</html>
