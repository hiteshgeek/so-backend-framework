<?php

/**
 * Helper function to render badges
 */
function renderBadges($badges)
{
    if (empty($badges)) return '';

    if (is_string($badges)) {
        return '<span class="badge badge-' . htmlspecialchars($badges) . '">' . ucfirst($badges) . '</span>';
    }

    if (count($badges) === 1) {
        $badge = $badges[0];
        return '<span class="badge badge-' . htmlspecialchars($badge) . '">' . ucfirst($badge) . '</span>';
    }

    $html = '<div class="doc-card-badges">';
    foreach ($badges as $badge) {
        $html .= '<span class="badge badge-' . htmlspecialchars($badge) . '">' . ucfirst($badge) . '</span>';
    }
    $html .= '</div>';
    return $html;
}

/**
 * Helper function to render a documentation card
 */
function renderCard($url, $icon, $title, $description, $badges = [])
{
    $html = '<a href="' . htmlspecialchars($url) . '" class="doc-card">';
    $html .= '<div class="doc-card-body">';
    $html .= '<h3><span class="mdi mdi-' . htmlspecialchars($icon) . '"></span> ' . htmlspecialchars($title) . '</h3>';
    $html .= '<p>' . htmlspecialchars($description) . '</p>';
    $html .= '</div>';
    $html .= renderBadges($badges);
    $html .= '</a>';
    return $html;
}

/**
 * Helper function to render a featured card
 */
function renderFeaturedCard($url, $icon, $title, $description, $badges = [])
{
    $html = '<a href="' . htmlspecialchars($url) . '" class="doc-card featured">';
    $html .= '<div class="doc-card-body">';
    $html .= '<h3><span class="mdi mdi-' . htmlspecialchars($icon) . '"></span> ' . htmlspecialchars($title) . '</h3>';
    $html .= '<p>' . htmlspecialchars($description) . '</p>';
    $html .= '</div>';
    $html .= renderBadges($badges);
    $html .= '</a>';
    return $html;
}

/**
 * Helper function to render a documentation section
 */
function renderSection($icon, $title, $cards, $gridClass = 'docs-grid')
{
    $html = '<div class="docs-section">';
    $html .= '<div class="docs-section-title"><span class="mdi mdi-' . htmlspecialchars($icon) . '"></span> ' . htmlspecialchars($title) . '</div>';
    $html .= '<div class="' . htmlspecialchars($gridClass) . '">';
    $html .= implode("\n", $cards);
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Documentation') ?></title>
    <?php include __DIR__ . '/_styles.php'; ?>
    <script>
        (function() {
            var t = localStorage.getItem("theme");
            if (!t && window.matchMedia("(prefers-color-scheme:dark)").matches) t = "dark";
            if (t) document.documentElement.setAttribute("data-theme", t);
        })()
    </script>
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
        <div class="docs-tabs" id="docs-tabs">
            <button class="docs-tab-button active" data-tab="docs-panel" onclick="switchDocsTab(this)">
                <span class="mdi mdi-book-open-page-variant"></span> Docs
            </button>
            <button class="docs-tab-button" data-tab="dev-panel" onclick="switchDocsTab(this)">
                <span class="mdi mdi-code-braces"></span> Development
            </button>
            <div class="docs-search-wrapper">
                <div class="docs-search-box">
                    <span class="mdi mdi-magnify"></span>
                    <input type="text" id="docs-search-input" placeholder="Search documentation..." autocomplete="off">
                    <span class="docs-search-hint"><kbd>/</kbd></span>
                </div>
                <div class="docs-search-results" id="docs-search-results"></div>
            </div>
        </div>

        <!-- ==================== DOCS TAB ==================== -->
        <div class="docs-tab-panel active" id="docs-panel">

            <?= renderSection('play-circle', 'Getting Started', [
                renderCard('/docs/readme', 'rocket-launch', 'README', 'Framework overview and quick introduction.', 'essential'),
                renderCard('/docs/setup', 'cog', 'Setup Guide', 'Installation and setup instructions.', 'essential'),
                renderCard('/docs/configuration', 'wrench', 'Configuration', 'Configuration system and environment setup.', 'essential'),
                renderCard('/docs/env-configuration', 'file-settings', 'Environment Variables', 'Complete reference for all .env configuration keys.', ['new', 'essential']),
                renderCard('/docs/quick-start', 'flash', 'Quick Start', 'Build your first route, controller, and view.', 'essential'),
                renderCard('/docs/project-structure', 'folder-open', 'Project Structure', 'Detailed explanation of folders and files.', 'essential'),
            ]) ?>

            <?= renderSection('cube-outline', 'Core Architecture', [
                renderCard('/docs/request-flow', 'transit-connection-variant', 'Request Flow Diagram', 'Visual walkthrough of the HTTP request lifecycle.', 'new'),
                renderCard('/docs/ui-engine', 'view-dashboard', 'UiEngine System', 'Programmatic UI generation with symmetric PHP/JS API - 49 elements across 4 categories.', ['new', 'production', 'unique']),
                renderCard('/docs/framework-features', 'office-building', 'Framework Features', 'Overview of all systems and capabilities.', 'default'),
                renderCard('/docs/core-enhancements', 'rocket-launch-outline', 'Core Enhancements', 'Phase 6 features: Str class, validation, subqueries, eager loading, 2FA, and more.', ['new', 'production']),
                renderCard('/docs/view-templates', 'image-multiple', 'View Templates', 'PHP native view templating and layouts.', 'default'),
                renderCard('/docs/sotemplate', 'code-braces-box', 'SOTemplate Engine', 'Blade-like template engine with compilation, caching, and 3-5x performance boost.', ['new', 'performance', 'production']),

                renderCard('/docs/auth-system', 'shield-lock', 'Authentication System', 'Session auth, JWT, remember me.', ['default', 'security', 'production']),
                renderCard('/docs/password-reset', 'key-variant', 'Password Reset', 'Secure password recovery with tokens and email.', ['new', 'security', 'owasp']),
                renderCard('/docs/dev-password-migration', 'key-change', 'Password Migration', 'Migrate legacy SHA1 to Argon2ID with automatic upgrade on login.', ['new', 'security']),
                renderCard('/docs/security-layer', 'lock', 'Security Layer', 'CSRF, JWT, Rate Limiting, XSS Prevention.', ['essential', 'security', 'production']),
                renderCard('/docs/encrypter', 'lock-outline', 'Encrypter (AES-256)', 'AES-256-CBC encryption for sensitive data.', ['new', 'security', 'compliance']),
                renderCard('/docs/auth-lockout', 'shield-alert', 'Auth Account Lockout', 'Brute force protection and account lockout.', ['new', 'security', 'production']),
                renderCard('/docs/validation-system', 'check-decagram', 'Validation System', '27+ validation rules, custom rules.', 'essential'),
                renderCard('/docs/api-versioning', 'code-tags', 'API Versioning', 'URL/header-based API version management.', ['new', 'api', 'production']),
                renderCard('/docs/context-permissions', 'account-multiple-check', 'Context-Based Permissions', 'Multi-tenant access control: web, mobile, cron, external.', ['new', 'enterprise', 'unique']),
                renderCard('/docs/service-layer', 'layers', 'Service Layer', 'Business logic separation, eliminating code duplication.', ['new', 'architecture', 'production']),
                renderCard('/docs/status-field-trait', 'table-cog', 'HasStatusField Trait', 'Flexible status field handling for non-standard tables.', 'new'),
                renderCard('/docs/timestamps-userstamps', 'clock-outline', 'Timestamps & Userstamps', 'Flexible timestamp and user tracking with custom column name support.', ['new', 'database']),
                renderCard('/docs/routing-system', 'routes', 'Routing System', 'URL routing, route parameters, and middleware.', 'default'),
                renderCard('/docs/middleware', 'filter', 'Middleware Guide', 'Auth, CORS, Logging, Global middleware.', 'default'),
                renderCard('/docs/internal-api', 'api', 'Internal API Layer', 'Context detection, permissions, API client.', 'default'),
                renderCard('/docs/model-enhancements', 'database-cog', 'Model Enhancements', 'Soft Deletes, Query Scopes.', 'default'),
            ]) ?>

            <?= renderSection('domain', 'Enterprise Features', [
                renderCard('/docs/session-system', 'key', 'Session System', 'Database-driven sessions for horizontal scaling.', ['enterprise', 'production', 'scaling']),
                renderCard('/docs/session-encryption', 'lock-outline', 'Session Encryption', 'AES-256-CBC encryption with HMAC tamper detection.', ['new', 'security', 'compliance']),
                renderCard('/docs/cache-system', 'database', 'Cache System', 'Database and in-memory caching.', ['enterprise', 'performance', 'production']),
                renderCard('/docs/file-cache', 'file-multiple', 'File Cache Driver', 'Filesystem-based cache with subdirectory sharding.', ['new', 'performance', 'production']),
                renderCard('/docs/queue-system', 'tray-full', 'Queue System', 'Background job processing.', ['enterprise', 'async', 'production']),
                renderCard('/docs/notification-system', 'bell', 'Notification System', 'Multi-channel notifications.', ['enterprise', 'multi-channel', 'production']),
                renderCard('/docs/activity-logging', 'clipboard-text-clock', 'Activity Logging', 'Audit trail and compliance.', ['enterprise', 'compliance', 'erp']),
                renderCard('/docs/localization', 'earth', 'Internationalization (i18n)', 'Multi-language, multi-currency, multi-timezone support for global ERP deployments.', ['enterprise', 'erp']),
                renderCard('/docs/pluralization', 'format-list-numbered', 'CLDR Pluralization', 'Complex plural forms for 6 language families: Slavic, Arabic, Asian, and more.', ['new', 'i18n', 'enterprise']),
                renderCard('/docs/rtl-support', 'format-textbox', 'RTL Language Support', 'Right-to-left text direction for Arabic, Hebrew, Persian, and Urdu.', ['new', 'i18n', 'accessibility']),
                renderCard('/docs/icu-messageformat', 'translate', 'ICU MessageFormat', 'Advanced message formatting with select, plural, and number patterns.', ['new', 'i18n', 'enterprise']),
            ]) ?>

            <?= renderSection('file-image', 'Media & Files', [
                renderCard('/docs/features/file-uploads', 'cloud-upload', 'File Uploads & Image Processing', 'Complete media system: uploads, thumbnails, variants, watermarks, and queue processing.', ['essential', 'production']),
                renderCard('/docs/chunked-uploads', 'upload-multiple', 'Chunked Uploads', 'Resumable large file uploads with progress tracking and auto-cleanup.', ['new', 'enterprise', 'production']),
                renderCard('/docs/webp-conversion', 'image-auto-adjust', 'WebP Auto-Conversion', 'Automatic WebP variant generation for optimized image delivery.', ['new', 'performance']),
                renderCard('/docs/video-processing', 'video-image', 'Video Processing', 'FFmpeg-based thumbnail extraction, metadata, and preview generation.', ['new', 'media', 'production']),
                renderCard('/docs/cdn-integration', 'cloud-sync', 'CDN Integration', 'CloudFront and Cloudflare support with automatic URL rewriting and cache purging.', ['new', 'performance', 'scaling']),
            ]) ?>

            <?= renderSection('wrench', 'Developer Tools', [
                renderCard('/docs/console-commands', 'console', 'Console Commands', 'CLI reference for scaffolding and tasks.', 'default'),
                renderCard('/docs/profiler', 'speedometer', 'Profiler & Debugging', 'Performance profiling, database query tracking, execution timeline, and memory monitoring.', ['new', 'core', 'performance']),
                renderCard('/docs/test-documentation', 'test-tube', 'Test Documentation', 'Test suite overview, categories, and usage.', 'new'),
                renderCard('/docs/testing-guide', 'clipboard-check-outline', 'Testing Guide', 'Complete testing guide with examples.', 'new'),
                renderCard('/docs/rename', 'pencil', 'Rename Process', 'Rename and customize framework branding.', 'default'),
                renderCard('/docs/branding', 'brush', 'Framework Branding', 'Framework name and branding reference.', 'default'),
            ]) ?>

            <?= renderSection('star', 'Complete References', [
                renderFeaturedCard('/docs/comprehensive-security', 'shield-lock-outline', 'Comprehensive Security Guide', 'Master security documentation covering authentication, sessions, JWT, CSRF, encryption, and OWASP Top 10 protection.', ['featured', 'security', 'owasp']),
            ], 'docs-grid docs-grid-featured') ?>

        </div>

        <!-- ==================== DEVELOPMENT TAB ==================== -->
        <div class="docs-tab-panel" id="dev-panel">

            <?= renderSection('play-circle', 'Getting Started', [
                renderCard('/docs/dev-first-page', 'puzzle', 'Build Your First Page', 'Route, controller, view, and assets — end to end.', 'guide'),
                renderCard('/docs/dev-crud-module', 'layers-outline', 'Build a CRUD Module', 'Complete module with create, read, update, and delete.', 'guide'),
            ]) ?>

            <?= renderSection('routes', 'Routing', [
                renderCard('/docs/dev-routes', 'sign-direction', 'Routes & Groups', 'Define GET, POST, PUT, DELETE routes with groups and prefixes.', 'guide'),
                renderCard('/docs/dev-route-params', 'variable', 'Parameters & Model Binding', 'Route parameters, constraints, and automatic model resolution.', 'guide'),
            ]) ?>

            <?= renderSection('application-cog', 'Controllers & Views', [
                renderCard('/docs/dev-web-controllers', 'monitor', 'Web Controllers & Views', 'Return views, pass data, use redirects and flash messages.', 'guide'),
                renderCard('/docs/dev-sotemplate', 'code-braces-box', 'SOTemplate Guide', 'Build templates with Blade-like syntax: @if, @foreach, {{ }}, and <x-component>.', ['new', 'guide', 'performance']),
                renderCard('/docs/dev-view-components', 'puzzle-outline', 'View Components Guide', 'Build reusable UI components, composers, slots, and loop helpers.', ['new', 'guide']),
                renderCard('/docs/dev-ui-engine', 'view-dashboard', 'UiEngine Guide', 'Build forms and layouts with UiEngine fluent API and config arrays.', ['new', 'guide', 'production']),
                renderCard('/docs/dev-ui-engine-forms', 'form-select', 'UiEngine Forms Guide', 'Step-by-step: login forms, registration, CRUD forms, validation, and file uploads.', ['new', 'guide', 'step-by-step']),
                renderCard('/docs/dev-ui-engine-layouts', 'view-dashboard-variant', 'UiEngine Layouts Guide', 'Step-by-step: cards, grids, dashboards, responsive design, and page layouts.', ['new', 'guide', 'step-by-step']),
                renderCard('/docs/dev-ui-engine-tables', 'table', 'UiEngine Tables Guide', 'Step-by-step: data tables, pagination, sorting, actions, and server-side data.', ['new', 'guide', 'step-by-step']),
                renderCard('/docs/dev-ui-engine-elements', 'format-list-bulleted-type', 'UiEngine Element Reference', 'Complete API reference for all 49 form, display, navigation, and layout elements.', ['new', 'reference', 'api']),
                renderCard('/docs/dev-ui-engine-advanced', 'code-tags-check', 'UiEngine Advanced Patterns', 'Custom elements, dynamic forms, JS integration, AJAX, and server-side rendering.', ['new', 'guide', 'advanced']),
                renderCard('/docs/dev-api-controllers', 'api', 'API Controllers & JSON', 'JSON responses, status codes, filtering, and pagination.', 'guide'),
                renderCard('/docs/dev-forms-validation', 'form-textbox', 'Form Handling & Validation', 'Forms with CSRF, validation rules, and error display.', 'guide'),
                renderCard('/docs/dev-file-uploads', 'file-upload', 'File Uploads (Basic)', 'Handle file uploads, validation, storage, and security.', 'guide'),
                renderCard('/docs/features/file-uploads', 'cloud-upload', 'Media System (Complete)', 'File uploads, image processing, thumbnails, variants, and watermarks.', ['guide', 'production']),
                renderCard('/docs/dev-chunked-uploads', 'upload-multiple', 'Chunked Upload Implementation', 'Build resumable upload UI with progress bars and error recovery.', ['new', 'guide', 'production']),
                renderCard('/docs/dev-video-processing', 'video-image', 'Video Processing Guide', 'Extract thumbnails, generate previews, and handle video metadata.', ['new', 'guide', 'media']),
                renderCard('/docs/api/media-api', 'code-braces', 'Media API Reference', 'Complete API documentation for media services, image processing, and watermarks.', ['api', 'reference']),
                renderCard('/docs/dev-pagination', 'page-layout-header', 'Pagination', 'Paginate database queries and display page links.', 'guide'),
            ]) ?>

            <?= renderSection('palette', 'Assets', [
                renderCard('/docs/dev-assets', 'package-variant-closed', 'Managing CSS & JS', 'AssetManager, priorities, CDN, cache busting, and render_assets().', 'guide'),
            ]) ?>

            <?= renderSection('shield-check', 'Security & Middleware', [
                renderCard('/docs/dev-auth', 'shield-lock', 'Authentication & Authorization', 'Auth middleware, session and JWT, protecting routes.', 'guide'),
                renderCard('/docs/dev-api-auth', 'key-chain', 'API Authentication (JWT)', 'JWT tokens, API authentication, and token management.', 'guide'),
                renderCard('/docs/dev-security', 'speedometer', 'CSRF, Rate Limiting & CORS', 'Security middleware configuration and usage.', 'guide'),
                renderCard('/docs/dev-password-migration', 'key-change', 'Password Migration', 'Migrate from legacy SHA1 to Argon2ID with dual-hash support.', ['new', 'security']),
                renderCard('/docs/dev-error-handling', 'alert-circle', 'Error Handling', 'Exception handling, custom error pages, and logging.', 'guide'),
                renderCard('/docs/dev-custom-middleware', 'cog-transfer', 'Creating Custom Middleware', 'Build and register your own middleware step by step.', 'guide'),
            ]) ?>

            <?= renderSection('database', 'Database & Models', [
                renderCard('/docs/schema-builder', 'table-cog', 'Schema Builder', 'Fluent API for creating database tables with migrations.', ['new', 'database', 'production']),
                renderCard('/docs/dev-models', 'database-plus', 'Creating Models & Queries', 'Model class, table mapping, CRUD, and query builder.', ['guide', 'database', 'core']),
                renderCard('/docs/dev-model-advanced', 'filter-variant', 'Scopes, Relations & Soft Deletes', 'Query scopes, relationships, and soft delete trait.', ['guide', 'database', 'advanced']),
                renderCard('/docs/model-observers', 'eye-outline', 'Model Observers', 'Lifecycle event hooks: creating, created, updating, updated, deleting, deleted.', ['new', 'architecture', 'patterns']),
                renderCard('/docs/dev-timestamps', 'clock-check-outline', 'Timestamps & Userstamps', 'Implement automatic created_at, updated_at, created_by, updated_by with custom column names.', ['new', 'guide']),
                renderCard('/docs/multi-database', 'database-sync', 'Multi-Database Support', 'Dual database architecture for ERP: Main + Essentials pattern.', ['new', 'enterprise', 'erp']),
                renderCard('/docs/dev-migrations', 'database-arrow-right', 'Database Migrations', 'Schema builder, creating tables, and migration strategies.', ['guide', 'database', 'core']),
                renderCard('/docs/dev-seeders', 'database-import', 'Database Seeders', 'Populate database with test data and sample records.', 'guide'),
            ]) ?>

            <?= renderSection('layers-triple', 'Architecture & Patterns', [
                renderCard('/docs/dev-services-repositories', 'cube-outline', 'Service Layer & Repository Pattern', 'Clean architecture, business logic separation, and testability.', 'guide'),
                renderCard('/docs/dev-events', 'bell-ring', 'Events & Listeners', 'Event-driven architecture and decoupled application logic.', 'guide'),
            ]) ?>

            <?= renderSection('cog-outline', 'Background Processing', [
                renderCard('/docs/dev-queues', 'tray-full', 'Queue System', 'Background jobs, async tasks, and queue workers.', 'guide'),
                renderCard('/docs/dev-mail', 'email', 'Mail System', 'Sending emails, templates, and attachments.', 'guide'),
            ]) ?>

            <?= renderSection('console-line', 'CLI Tools', [
                renderCard('/docs/dev-cli-commands', 'console', 'CLI Commands', 'Code generation, migrations, seeders, and development workflows.', 'guide'),
                renderCard('/docs/dev-translation-commands', 'translate', 'Translation Commands', 'make:translation, translations:missing, and translations:sync CLI tools.', ['new', 'guide', 'i18n']),
            ]) ?>

            <?= renderSection('speedometer', 'Performance & Caching', [
                renderCard('/docs/dev-caching', 'lightning-bolt', 'Caching Strategies', 'Cache queries, API calls, and computed values for better performance.', 'guide'),
            ]) ?>

            <?= renderSection('bug', 'Debugging & Monitoring', [
                renderCard('/docs/dev-logging', 'file-document-outline', 'Logging & Debugging', 'Application logging, log levels, channels, and debugging tips.', 'guide'),
                renderCard('/docs/profiler', 'speedometer', 'Profiler & Debugging', 'Performance profiling, query tracking, execution timeline, and optimization.', ['new', 'guide', 'performance']),
            ]) ?>

            <?= renderSection('test-tube', 'Testing & Quality', [
                renderCard('/docs/dev-testing', 'checkbox-marked-circle', 'Writing Tests', 'PHPUnit tests, unit tests, integration tests, and test patterns.', 'guide'),
            ]) ?>

            <?= renderSection('hammer-wrench', 'Utilities & Reference', [
                renderCard('/docs/dev-core-enhancements', 'code-braces', 'Core Enhancements Guide', 'Implementation guide for Phase 6: Str class, array helpers, validation, subqueries, eager loading, 2FA.', ['new', 'guide']),
                renderCard('/docs/dev-helpers', 'function-variant', 'Helper Functions', 'Complete reference of available helper functions and utilities.', 'guide'),
                renderCard('/docs/dev-localization', 'earth', 'Localization Implementation', 'Step-by-step guide to implementing multi-language, multi-currency, and multi-timezone support.', ['guide', 'enterprise']),
                renderCard('/docs/dev-locale-validation', 'check-circle', 'Locale Validation Rules', 'Country-specific validation: phone numbers, postal codes, and tax IDs for 40+ countries.', ['new', 'guide', 'enterprise']),
                renderCard('/docs/dev-translation-cli', 'console', 'Translation CLI Commands', 'Create, sync, and audit translations with make:translation, translations:missing, translations:sync.', ['new', 'guide', 'cli']),
                renderCard('/docs/dev-rtl-layouts', 'format-textbox', 'RTL Layout Guide', 'Building layouts that support right-to-left languages with CSS and helpers.', ['new', 'guide', 'i18n']),
            ]) ?>

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
            localStorage.setItem('docs-active-tab', tabId);
        }

        function trackCardVisit(url) {
            localStorage.setItem('docs-last-visited-card', url);
        }

        (function() {
            var savedTab = localStorage.getItem('docs-active-tab');
            var hash = window.location.hash.replace('#', '');
            var tabToActivate = hash || savedTab;

            if (tabToActivate) {
                var btn = document.querySelector('.docs-tab-button[data-tab="' + tabToActivate + '"]');
                if (btn) switchDocsTab(btn);
            }

            var lastVisited = localStorage.getItem('docs-last-visited-card');
            var visitedCard = null;

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

                if (normalizedHref && normalizedHref === normalizedLastVisited) {
                    card.classList.add('visited');
                    visitedCard = card;
                    matchFound = true;
                }

                card.addEventListener('click', function() {
                    trackCardVisit(href);
                });
            });

            if (visitedCard) {
                setTimeout(function() {
                    visitedCard.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest'
                    });
                }, 300);
            }

            // ===== STICKY TABS (below header) =====
            var docsTabs = document.getElementById('docs-tabs');
            var docsHeader = document.querySelector('.docs-header');

            function updateHeaderHeight() {
                if (docsHeader) {
                    var headerHeight = docsHeader.offsetHeight;
                    document.documentElement.style.setProperty('--header-height', headerHeight + 'px');
                }
            }

            if (docsTabs && docsHeader) {
                // Set initial header height
                updateHeaderHeight();

                // Update on resize
                window.addEventListener('resize', updateHeaderHeight);

                // Observe when tabs become stuck
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (!entry.isIntersecting) {
                            docsTabs.classList.add('is-stuck');
                        } else {
                            docsTabs.classList.remove('is-stuck');
                        }
                    });
                }, {
                    threshold: [1],
                    rootMargin: '-' + (docsHeader.offsetHeight + 1) + 'px 0px 0px 0px'
                });

                observer.observe(docsTabs);
            }

            // ===== DOCUMENTATION SEARCH =====
            var searchInput = document.getElementById('docs-search-input');
            var searchResults = document.getElementById('docs-search-results');
            var searchIndex = [];

            // Build search index from all doc cards
            function buildSearchIndex() {
                searchIndex = [];

                document.querySelectorAll('.docs-tab-panel').forEach(function(panel) {
                    var tabId = panel.id;
                    var tabName = tabId === 'docs-panel' ? 'Docs' : 'Development';

                    panel.querySelectorAll('.docs-section').forEach(function(section) {
                        var sectionTitle = section.querySelector('.docs-section-title');
                        var sectionName = sectionTitle ? sectionTitle.textContent.trim() : '';

                        section.querySelectorAll('.doc-card').forEach(function(card) {
                            var title = card.querySelector('h3');
                            var desc = card.querySelector('p');
                            var icon = card.querySelector('h3 .mdi');

                            searchIndex.push({
                                url: card.getAttribute('href'),
                                title: title ? title.textContent.trim() : '',
                                description: desc ? desc.textContent.trim() : '',
                                icon: icon ? icon.className.replace('mdi mdi-', '') : 'file-document',
                                tab: tabName,
                                tabId: tabId,
                                section: sectionName
                            });
                        });
                    });
                });
            }

            // Search function
            function searchDocs(query) {
                if (!query || query.length < 2) return [];

                var lowerQuery = query.toLowerCase();
                var results = [];

                searchIndex.forEach(function(item) {
                    var titleMatch = item.title.toLowerCase().indexOf(lowerQuery) !== -1;
                    var descMatch = item.description.toLowerCase().indexOf(lowerQuery) !== -1;
                    var sectionMatch = item.section.toLowerCase().indexOf(lowerQuery) !== -1;

                    if (titleMatch || descMatch || sectionMatch) {
                        // Calculate relevance score
                        var score = 0;
                        if (item.title.toLowerCase().indexOf(lowerQuery) === 0) score += 100;
                        else if (titleMatch) score += 50;
                        if (descMatch) score += 20;
                        if (sectionMatch) score += 10;

                        results.push({
                            item: item,
                            score: score
                        });
                    }
                });

                // Sort by score descending
                results.sort(function(a, b) {
                    return b.score - a.score;
                });

                return results.slice(0, 10).map(function(r) {
                    return r.item;
                });
            }

            // Highlight matching text
            function highlightText(text, query) {
                if (!query) return text;
                var regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                return text.replace(regex, '<mark>$1</mark>');
            }

            // Render search results
            function renderResults(results, query) {
                if (results.length === 0) {
                    searchResults.innerHTML =
                        '<div class="docs-search-no-results">' +
                        '<span class="mdi mdi-file-search-outline"></span>' +
                        'No results found for "' + query + '"' +
                        '</div>';
                    searchResults.classList.add('active');
                    return;
                }

                var html = '<div class="docs-search-results-header">' + results.length + ' result' + (results.length !== 1 ? 's' : '') + ' found</div>';

                results.forEach(function(item) {
                    html +=
                        '<a href="' + item.url + '" class="docs-search-result" data-tab="' + item.tabId + '">' +
                        '<div class="docs-search-result-title">' +
                        '<span class="mdi mdi-' + item.icon + '"></span>' +
                        highlightText(item.title, query) +
                        '</div>' +
                        '<div class="docs-search-result-desc">' + highlightText(item.description, query) + '</div>' +
                        '<div class="docs-search-result-meta">' +
                        '<span class="docs-search-result-tab">' + item.tab + '</span>' +
                        '<span class="docs-search-result-section">' + item.section + '</span>' +
                        '</div>' +
                        '</a>';
                });

                searchResults.innerHTML = html;
                searchResults.classList.add('active');

                // Add click handlers and keyboard support to results
                searchResults.querySelectorAll('.docs-search-result').forEach(function(result, idx) {
                    result.setAttribute('tabindex', '0');
                    result.setAttribute('data-index', idx);

                    result.addEventListener('click', function(e) {
                        var tabId = this.getAttribute('data-tab');
                        var btn = document.querySelector('.docs-tab-button[data-tab="' + tabId + '"]');
                        if (btn && !btn.classList.contains('active')) {
                            switchDocsTab(btn);
                        }
                        trackCardVisit(this.getAttribute('href'));
                    });

                    // Keyboard navigation within results
                    result.addEventListener('keydown', function(e) {
                        var items = searchResults.querySelectorAll('.docs-search-result');
                        var currentIndex = parseInt(this.getAttribute('data-index'));

                        if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            var nextIndex = (currentIndex + 1) % items.length;
                            items[nextIndex].focus();
                        } else if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            var prevIndex = currentIndex === 0 ? items.length - 1 : currentIndex - 1;
                            items[prevIndex].focus();
                        } else if (e.key === 'Enter') {
                            e.preventDefault();
                            this.click();
                        } else if (e.key === 'Escape') {
                            e.preventDefault();
                            hideResults();
                            searchInput.focus();
                        }
                    });
                });

                // Set initial focus indicator
                if (searchResults.querySelector('.docs-search-result')) {
                    searchResults.querySelector('.docs-search-result').classList.add('keyboard-focus');
                }
            }

            // Hide results
            function hideResults() {
                searchResults.classList.remove('active');
            }

            // Event listeners
            if (searchInput) {
                buildSearchIndex();

                var debounceTimer;
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    var query = this.value.trim();

                    if (query.length < 2) {
                        hideResults();
                        return;
                    }

                    debounceTimer = setTimeout(function() {
                        var results = searchDocs(query);
                        renderResults(results, query);
                    }, 150);
                });

                // Hide on click outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        hideResults();
                    }
                });

                // Show results on focus if there's a query
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length >= 2) {
                        var results = searchDocs(this.value.trim());
                        renderResults(results, this.value.trim());
                    }
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    // "/" to focus search
                    if (e.key === '/' && document.activeElement !== searchInput) {
                        e.preventDefault();
                        searchInput.focus();
                    }

                    // Escape to close results and blur
                    if (e.key === 'Escape' && document.activeElement === searchInput) {
                        hideResults();
                        searchInput.blur();
                    }
                });

                // Arrow navigation from search input to results
                searchInput.addEventListener('keydown', function(e) {
                    var items = searchResults.querySelectorAll('.docs-search-result');
                    if (items.length === 0) return;

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        items[0].focus();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        items[items.length - 1].focus();
                    } else if (e.key === 'Enter' && items.length > 0) {
                        e.preventDefault();
                        items[0].click();
                    }
                });
            }
        })();
    </script>
    <?= render_assets('body_end') ?>
</body>

</html>