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
            <a href="/" class="docs-nav-link"><span class="mdi mdi-home"></span> Back to Home</a>
        </div>
    </div>

    <div class="docs-container">
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
                    <a href="/docs/readme" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-rocket-launch"></span> README</h3>
                            <p>Framework overview and quick introduction.</p>
                        </div>
                        <span class="badge badge-essential">Essential</span>
                    </a>
                    <a href="/docs/setup" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-cog"></span> Setup Guide</h3>
                            <p>Installation and setup instructions.</p>
                        </div>
                        <span class="badge badge-essential">Essential</span>
                    </a>
                    <a href="/docs/configuration" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-wrench"></span> Configuration</h3>
                            <p>Configuration system and environment setup.</p>
                        </div>
                        <span class="badge badge-essential">Essential</span>
                    </a>
                    <a href="/docs/env-configuration" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-file-settings"></span> Environment Variables</h3>
                            <p>Complete reference for all .env configuration keys.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-essential">Essential</span>
                        </div>
                    </a>
                    <a href="/docs/quick-start" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-flash"></span> Quick Start</h3>
                            <p>Build your first route, controller, and view.</p>
                        </div>
                        <span class="badge badge-essential">Essential</span>
                    </a>
                    <a href="/docs/project-structure" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-folder-open"></span> Project Structure</h3>
                            <p>Detailed explanation of folders and files.</p>
                        </div>
                        <span class="badge badge-essential">Essential</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-cube-outline"></span> Core Architecture</div>
                <div class="docs-grid">
                    <a href="/docs/request-flow" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-transit-connection-variant"></span> Request Flow Diagram</h3>
                            <p>Visual walkthrough of the HTTP request lifecycle.</p>
                        </div>
                        <span class="badge badge-new">New</span>
                    </a>
                    <a href="/docs/framework-features" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-office-building"></span> Framework Features</h3>
                            <p>Overview of all systems and capabilities.</p>
                        </div>
                        <span class="badge badge-default">Overview</span>
                    </a>
                    <a href="/docs/view-templates" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-image-multiple"></span> View Templates</h3>
                            <p>PHP native view templating and layouts.</p>
                        </div>
                        <span class="badge badge-default">Core</span>
                    </a>
                    <a href="/docs/asset-management" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-package-variant-closed"></span> Asset Management</h3>
                            <p>CSS/JS loading, cache busting, CDN support.</p>
                        </div>
                        <span class="badge badge-default">Core</span>
                    </a>
                    <a href="/docs/auth-system" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-shield-lock"></span> Authentication System</h3>
                            <p>Session auth, JWT, remember me.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-default">Core</span>
                            <span class="badge badge-security">Security</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/password-reset" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-key-variant"></span> Password Reset</h3>
                            <p>Secure password recovery with tokens and email.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-security">Security</span>
                            <span class="badge badge-owasp">OWASP</span>
                        </div>
                    </a>
                    <a href="/docs/security-layer" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-lock"></span> Security Layer</h3>
                            <p>CSRF, JWT, Rate Limiting, XSS Prevention.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-essential">Essential</span>
                            <span class="badge badge-security">Security</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/encrypter" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-lock-outline"></span> Encrypter (AES-256)</h3>
                            <p>AES-256-CBC encryption for sensitive data.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-security">Security</span>
                            <span class="badge badge-compliance">Compliance</span>
                        </div>
                    </a>
                    <a href="/docs/auth-lockout" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-shield-alert"></span> Auth Account Lockout</h3>
                            <p>Brute force protection and account lockout.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-security">Security</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/validation-system" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-check-decagram"></span> Validation System</h3>
                            <p>27+ validation rules, custom rules.</p>
                        </div>
                        <span class="badge badge-essential">Essential</span>
                    </a>
                    <a href="/docs/api-versioning" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-code-tags"></span> API Versioning</h3>
                            <p>URL/header-based API version management.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-api">API</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/context-permissions" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-account-multiple-check"></span> Context-Based Permissions</h3>
                            <p>Multi-tenant access control: web, mobile, cron, external.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-enterprise">Enterprise</span>
                            <span class="badge badge-unique">Unique</span>
                        </div>
                    </a>
                    <a href="/docs/service-layer" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-layers"></span> Service Layer</h3>
                            <p>Business logic separation, eliminating code duplication.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-architecture">Architecture</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/status-field-trait" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-table-cog"></span> HasStatusField Trait</h3>
                            <p>Flexible status field handling for non-standard tables.</p>
                        </div>
                        <span class="badge badge-new">New</span>
                    </a>
                    <a href="/docs/routing-system" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-routes"></span> Routing System</h3>
                            <p>URL routing, route parameters, and middleware.</p>
                        </div>
                        <span class="badge badge-default">Core</span>
                    </a>
                    <a href="/docs/middleware" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-filter"></span> Middleware Guide</h3>
                            <p>Auth, CORS, Logging, Global middleware.</p>
                        </div>
                        <span class="badge badge-default">Core</span>
                    </a>
                    <a href="/docs/internal-api" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-api"></span> Internal API Layer</h3>
                            <p>Context detection, permissions, API client.</p>
                        </div>
                        <span class="badge badge-default">Core</span>
                    </a>
                    <a href="/docs/model-enhancements" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-database-cog"></span> Model Enhancements</h3>
                            <p>Soft Deletes, Query Scopes.</p>
                        </div>
                        <span class="badge badge-default">Core</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-domain"></span> Enterprise Features</div>
                <div class="docs-grid">
                    <a href="/docs/session-system" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-key"></span> Session System</h3>
                            <p>Database-driven sessions for horizontal scaling.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-enterprise">Enterprise</span>
                            <span class="badge badge-production">Production</span>
                            <span class="badge badge-scaling">Scaling</span>
                        </div>
                    </a>
                    <a href="/docs/session-encryption" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-lock-outline"></span> Session Encryption</h3>
                            <p>AES-256-CBC encryption with HMAC tamper detection.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-security">Security</span>
                            <span class="badge badge-compliance">Compliance</span>
                        </div>
                    </a>
                    <a href="/docs/cache-system" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-database"></span> Cache System</h3>
                            <p>Database and in-memory caching.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-enterprise">Enterprise</span>
                            <span class="badge badge-performance">Performance</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/file-cache" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-file-multiple"></span> File Cache Driver</h3>
                            <p>Filesystem-based cache with subdirectory sharding.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-performance">Performance</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/queue-system" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-tray-full"></span> Queue System</h3>
                            <p>Background job processing.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-enterprise">Enterprise</span>
                            <span class="badge badge-async">Async</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/notification-system" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-bell"></span> Notification System</h3>
                            <p>Multi-channel notifications.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-enterprise">Enterprise</span>
                            <span class="badge badge-multi-channel">Multi-Channel</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/activity-logging" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-clipboard-text-clock"></span> Activity Logging</h3>
                            <p>Audit trail and compliance.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-enterprise">Enterprise</span>
                            <span class="badge badge-compliance">Compliance</span>
                            <span class="badge badge-erp">ERP-Ready</span>
                        </div>
                    </a>
                    <a href="/docs/localization" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-earth"></span> Internationalization (i18n)</h3>
                            <p>Multi-language, multi-currency, multi-timezone support for global ERP deployments.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-enterprise">Enterprise</span>
                            <span class="badge badge-erp">ERP-Ready</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-wrench"></span> Developer Tools</div>
                <div class="docs-grid">
                    <a href="/docs/console-commands" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-console"></span> Console Commands</h3>
                            <p>CLI reference for scaffolding and tasks.</p>
                        </div>
                        <span class="badge badge-default">Tools</span>
                    </a>
                    <a href="/docs/profiler" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-speedometer"></span> Profiler & Debugging</h3>
                            <p>Performance profiling, database query tracking, execution timeline, and memory monitoring.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-core">Core</span>
                            <span class="badge badge-performance">Performance</span>
                        </div>
                    </a>
                    <a href="/docs/test-documentation" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-test-tube"></span> Test Documentation</h3>
                            <p>Test suite overview, categories, and usage.</p>
                        </div>
                        <span class="badge badge-new">New</span>
                    </a>
                    <a href="/docs/testing-guide" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-clipboard-check-outline"></span> Testing Guide</h3>
                            <p>Complete testing guide with examples.</p>
                        </div>
                        <span class="badge badge-new">New</span>
                    </a>
                    <a href="/docs/rename" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-pencil"></span> Rename Process</h3>
                            <p>Rename and customize framework branding.</p>
                        </div>
                        <span class="badge badge-default">Tools</span>
                    </a>
                    <a href="/docs/branding" class="doc-card">
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
                    <a href="/docs/comprehensive-security" class="doc-card featured">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-shield-lock-outline"></span> Comprehensive Security Guide</h3>
                            <p>Master security documentation covering authentication, sessions, JWT, CSRF, encryption, and OWASP Top 10 protection.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-featured">Complete</span>
                            <span class="badge badge-security">Security</span>
                            <span class="badge badge-owasp">OWASP</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- ==================== DEVELOPMENT TAB ==================== -->
        <div class="docs-tab-panel" id="dev-panel">
            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-play-circle"></span> Getting Started</div>
                <div class="docs-grid">
                    <a href="/docs/dev-first-page" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-puzzle"></span> Build Your First Page</h3>
                            <p>Route, controller, view, and assets — end to end.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-crud-module" class="doc-card">
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
                    <a href="/docs/dev-routes" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-sign-direction"></span> Routes & Groups</h3>
                            <p>Define GET, POST, PUT, DELETE routes with groups and prefixes.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-route-params" class="doc-card">
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
                    <a href="/docs/dev-web-controllers" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-monitor"></span> Web Controllers & Views</h3>
                            <p>Return views, pass data, use redirects and flash messages.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-api-controllers" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-api"></span> API Controllers & JSON</h3>
                            <p>JSON responses, status codes, filtering, and pagination.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-forms-validation" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-form-textbox"></span> Form Handling & Validation</h3>
                            <p>Forms with CSRF, validation rules, and error display.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-file-uploads" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-file-upload"></span> File Uploads</h3>
                            <p>Handle file uploads, validation, storage, and security.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-pagination" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-page-layout-header"></span> Pagination</h3>
                            <p>Paginate database queries and display page links.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-palette"></span> Assets</div>
                <div class="docs-grid">
                    <a href="/docs/dev-assets" class="doc-card">
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
                    <a href="/docs/dev-auth" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-shield-lock"></span> Authentication & Authorization</h3>
                            <p>Auth middleware, session and JWT, protecting routes.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-api-auth" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-key-chain"></span> API Authentication (JWT)</h3>
                            <p>JWT tokens, API authentication, and token management.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-security" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-speedometer"></span> CSRF, Rate Limiting & CORS</h3>
                            <p>Security middleware configuration and usage.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-error-handling" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-alert-circle"></span> Error Handling</h3>
                            <p>Exception handling, custom error pages, and logging.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-custom-middleware" class="doc-card">
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
                    <a href="/docs/schema-builder" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-table-cog"></span> Schema Builder</h3>
                            <p>Fluent API for creating database tables with migrations.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-database">Database</span>
                            <span class="badge badge-production">Production</span>
                        </div>
                    </a>
                    <a href="/docs/dev-models" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-database-plus"></span> Creating Models & Queries</h3>
                            <p>Model class, table mapping, CRUD, and query builder.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-guide">Guide</span>
                            <span class="badge badge-database">Database</span>
                            <span class="badge badge-core">Core</span>
                        </div>
                    </a>
                    <a href="/docs/dev-model-advanced" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-filter-variant"></span> Scopes, Relations & Soft Deletes</h3>
                            <p>Query scopes, relationships, and soft delete trait.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-guide">Guide</span>
                            <span class="badge badge-database">Database</span>
                            <span class="badge badge-advanced">Advanced</span>
                        </div>
                    </a>
                    <a href="/docs/model-observers" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-eye-outline"></span> Model Observers</h3>
                            <p>Lifecycle event hooks: creating, created, updating, updated, deleting, deleted.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-architecture">Architecture</span>
                            <span class="badge badge-patterns">Patterns</span>
                        </div>
                    </a>
                    <a href="/docs/multi-database" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-database-sync"></span> Multi-Database Support</h3>
                            <p>Dual database architecture for ERP: Main + Essentials pattern.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-enterprise">Enterprise</span>
                            <span class="badge badge-erp">ERP-Ready</span>
                        </div>
                    </a>
                    <a href="/docs/dev-migrations" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-database-arrow-right"></span> Database Migrations</h3>
                            <p>Schema builder, creating tables, and migration strategies.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-guide">Guide</span>
                            <span class="badge badge-database">Database</span>
                            <span class="badge badge-core">Core</span>
                        </div>
                    </a>
                    <a href="/docs/dev-seeders" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-database-import"></span> Database Seeders</h3>
                            <p>Populate database with test data and sample records.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-layers-triple"></span> Architecture & Patterns</div>
                <div class="docs-grid">
                    <a href="/docs/dev-services-repositories" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-cube-outline"></span> Service Layer & Repository Pattern</h3>
                            <p>Clean architecture, business logic separation, and testability.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-events" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-bell-ring"></span> Events & Listeners</h3>
                            <p>Event-driven architecture and decoupled application logic.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-cog-outline"></span> Background Processing</div>
                <div class="docs-grid">
                    <a href="/docs/dev-queues" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-tray-full"></span> Queue System</h3>
                            <p>Background jobs, async tasks, and queue workers.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-mail" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-email"></span> Mail System</h3>
                            <p>Sending emails, templates, and attachments.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-console-line"></span> CLI Tools</div>
                <div class="docs-grid">
                    <a href="/docs/dev-cli-commands" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-console"></span> CLI Commands</h3>
                            <p>Code generation, migrations, seeders, and development workflows.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-speedometer"></span> Performance & Caching</div>
                <div class="docs-grid">
                    <a href="/docs/dev-caching" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-lightning-bolt"></span> Caching Strategies</h3>
                            <p>Cache queries, API calls, and computed values for better performance.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-bug"></span> Debugging & Monitoring</div>
                <div class="docs-grid">
                    <a href="/docs/dev-logging" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-file-document-outline"></span> Logging & Debugging</h3>
                            <p>Application logging, log levels, channels, and debugging tips.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/profiler" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-speedometer"></span> Profiler & Debugging</h3>
                            <p>Performance profiling, query tracking, execution timeline, and optimization.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-guide">Guide</span>
                            <span class="badge badge-performance">Performance</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-test-tube"></span> Testing & Quality</div>
                <div class="docs-grid">
                    <a href="/docs/dev-testing" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-checkbox-marked-circle"></span> Writing Tests</h3>
                            <p>PHPUnit tests, unit tests, integration tests, and test patterns.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                </div>
            </div>

            <div class="docs-section">
                <div class="docs-section-title"><span class="mdi mdi-hammer-wrench"></span> Utilities & Reference</div>
                <div class="docs-grid">
                    <a href="/docs/dev-helpers" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-function-variant"></span> Helper Functions</h3>
                            <p>Complete reference of available helper functions and utilities.</p>
                        </div>
                        <span class="badge badge-guide">Guide</span>
                    </a>
                    <a href="/docs/dev-localization" class="doc-card">
                        <div class="doc-card-body">
                            <h3><span class="mdi mdi-earth"></span> Localization Implementation</h3>
                            <p>Step-by-step guide to implementing multi-language, multi-currency, and multi-timezone support.</p>
                        </div>
                        <div class="doc-card-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-guide">Guide</span>
                            <span class="badge badge-enterprise">Enterprise</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="docs-footer">
        <p><strong><span class="mdi mdi-cube"></span> <?= htmlspecialchars(config('app.name', 'SO Framework')) ?> v<?= htmlspecialchars(config('app.version', '2.0.0')) ?></strong></p>
        <p><span class="mdi mdi-language-php"></span> Built with PHP 8.3+ | <span class="mdi mdi-application-brackets"></span> Modern Architecture | <span class="mdi mdi-shield-check"></span> Security First</p>
        <p style="margin-top: 8px;">
            <a href="/docs/readme"><span class="mdi mdi-play-circle"></span> Start Here</a> |
            <a href="/docs/index"><span class="mdi mdi-view-list"></span> Full Index</a> |
            <a href="/docs/comprehensive-security"><span class="mdi mdi-shield-lock-outline"></span> Security Guide</a>
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
        var tabId = button.getAttribute('data-tab');
        window.history.replaceState(null, '', '#' + tabId);
        // Save active tab to localStorage
        localStorage.setItem('docs-active-tab', tabId);
    }

    // Track last visited card (store only the card we're coming back from)
    function trackCardVisit(url) {
        localStorage.setItem('docs-last-visited-card', url);
    }

    // Mark only the last visited card and restore active tab
    (function() {
        // Restore active tab from localStorage or hash
        var savedTab = localStorage.getItem('docs-active-tab');
        var hash = window.location.hash.replace('#', '');
        var tabToActivate = hash || savedTab;

        if (tabToActivate) {
            var btn = document.querySelector('.docs-tab-button[data-tab="' + tabToActivate + '"]');
            if (btn) switchDocsTab(btn);
        }

        // Mark only the last visited card
        var lastVisited = localStorage.getItem('docs-last-visited-card');
        var visitedCard = null;

        // Normalize URL for comparison (remove trailing slash, hash, query params)
        function normalizeUrl(url) {
            if (!url) return '';
            try {
                var urlObj = new URL(url, window.location.origin);
                return urlObj.origin + urlObj.pathname.replace(/\/$/, '');
            } catch (e) {
                return url.replace(/\/$/, '').split('#')[0].split('?')[0];
            }
        }

        var normalizedLastVisited = normalizeUrl(lastVisited);

        var matchFound = false;
        document.querySelectorAll('.doc-card').forEach(function(card) {
            var href = card.getAttribute('href');
            var normalizedHref = normalizeUrl(href);

            // Mark only if this is the last visited card
            if (normalizedHref && normalizedHref === normalizedLastVisited) {
                card.classList.add('visited');
                visitedCard = card;
                matchFound = true;
            }

            // Track visit when clicking cards
            card.addEventListener('click', function() {
                trackCardVisit(href);
            });
        });

        // Auto-scroll to visited card
        if (visitedCard) {
            setTimeout(function() {
                visitedCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'nearest'
                });
            }, 300);
        }
    })();
    </script>
<?= render_assets('body_end') ?>
</body>
</html>
