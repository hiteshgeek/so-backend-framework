<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Documentation') ?></title>
    <?php include __DIR__ . '/_styles.php'; ?>
    <script>(function(){var t=localStorage.getItem("theme");if(!t&&window.matchMedia("(prefers-color-scheme:dark)").matches)t="dark";if(t)document.documentElement.setAttribute("data-theme",t);})()</script>
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
                <h3>35</h3>
                <p>Guide Documents</p>
            </div>
            <div class="docs-stat-card">
                <span class="mdi mdi-rocket-launch stat-icon"></span>
                <h3>100%</h3>
                <p>Production Ready</p>
            </div>
        </div>

        <div class="docs-tabs">
            <button class="docs-tab-button active" data-tab="docs-panel" onclick="switchDocsTab(this)">
                <span class="mdi mdi-book-open-page-variant"></span> Docs
            </button>
            <button class="docs-tab-button" data-tab="dev-panel" onclick="switchDocsTab(this)">
                <span class="mdi mdi-code-braces"></span> Development
            </button>
        </div>

        <!-- ==================== DOCS TAB ==================== -->
        <div class="docs-tab-panel active" id="docs-panel">
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
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/request-flow" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-transit-connection-variant"></span> Request Flow Diagram</h3>
                            <p>Visual walkthrough of the HTTP request lifecycle.</p>
                        </div>
                        <span class="badge badge-new">New</span>
                    </a>
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

        <!-- ==================== DEVELOPMENT TAB ==================== -->
        <div class="docs-tab-panel" id="dev-panel">
            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-play-circle"></span> Getting Started</div>
                <div class="docs-grid">
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-first-page" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-puzzle"></span> Build Your First Page</h3>
                            <p>Route, controller, view, and assets — end to end.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-crud-module" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-layers-outline"></span> Build a CRUD Module</h3>
                            <p>Complete module with create, read, update, and delete.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-routes"></span> Routing</div>
                <div class="docs-grid">
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-routes" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-sign-direction"></span> Routes & Groups</h3>
                            <p>Define GET, POST, PUT, DELETE routes with groups and prefixes.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-route-params" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-variable"></span> Parameters & Model Binding</h3>
                            <p>Route parameters, constraints, and automatic model resolution.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-application-cog"></span> Controllers & Views</div>
                <div class="docs-grid">
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-web-controllers" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-monitor"></span> Web Controllers & Views</h3>
                            <p>Return views, pass data, use redirects and flash messages.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-api-controllers" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-api"></span> API Controllers & JSON</h3>
                            <p>JSON responses, status codes, filtering, and pagination.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-forms-validation" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-form-textbox"></span> Form Handling & Validation</h3>
                            <p>Forms with CSRF, validation rules, and error display.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-palette"></span> Assets</div>
                <div class="docs-grid">
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-assets" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-package-variant-closed"></span> Managing CSS & JS</h3>
                            <p>AssetManager, priorities, CDN, cache busting, and render_assets().</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-shield-check"></span> Security & Middleware</div>
                <div class="docs-grid">
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-auth" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-shield-lock"></span> Authentication & Authorization</h3>
                            <p>Auth middleware, session and JWT, protecting routes.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-security" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-speedometer"></span> CSRF, Rate Limiting & CORS</h3>
                            <p>Security middleware configuration and usage.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-custom-middleware" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-cog-transfer"></span> Creating Custom Middleware</h3>
                            <p>Build and register your own middleware step by step.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-database"></span> Database & Models</div>
                <div class="docs-grid">
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-models" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-database-plus"></span> Creating Models & Queries</h3>
                            <p>Model class, table mapping, CRUD, and query builder.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/dev-model-advanced" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-filter-variant"></span> Scopes, Relations & Soft Deletes</h3>
                            <p>Query scopes, relationships, and soft delete trait.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="docs-footer">
        <p><strong><span class="mdi mdi-cube"></span> <?= htmlspecialchars(config('app.name', 'SO Framework')) ?> v<?= htmlspecialchars(config('app.version', '2.0.0')) ?></strong></p>
        <p><span class="mdi mdi-language-php"></span> Built with PHP 8.3+ | <span class="mdi mdi-application-brackets"></span> Modern Architecture | <span class="mdi mdi-shield-check"></span> Security First</p>
        <p style="margin-top: 8px;">
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/readme"><span class="mdi mdi-play-circle"></span> Start Here</a> |
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/index"><span class="mdi mdi-view-list"></span> Full Index</a> |
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/comprehensive"><span class="mdi mdi-book-open-variant"></span> Complete Guide</a>
        </p>
    </footer>

    <script>
    function switchDocsTab(button) {
        document.querySelectorAll('.docs-tab-button').forEach(function(btn) {
            btn.classList.remove('active');
        });
        document.querySelectorAll('.docs-tab-panel').forEach(function(panel) {
            panel.classList.remove('active');
        });
        button.classList.add('active');
        var target = document.getElementById(button.getAttribute('data-tab'));
        if (target) target.classList.add('active');
        window.history.replaceState(null, '', '#' + button.getAttribute('data-tab'));
    }
    (function() {
        var hash = window.location.hash.replace('#', '');
        if (hash) {
            var btn = document.querySelector('.docs-tab-button[data-tab="' + hash + '"]');
            if (btn) switchDocsTab(btn);
        }
    })();
    </script>
<?= render_assets('body_end') ?>
</body>
</html>
