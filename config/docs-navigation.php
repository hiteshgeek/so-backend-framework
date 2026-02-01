<?php
/**
 * Documentation Navigation Configuration
 *
 * Defines the order and navigation links for all documentation pages.
 * This order matches the card layout in the documentation index.
 */

return [
    // ===== FRAMEWORK DOCS TAB =====

    // Getting Started
    ['key' => 'readme', 'title' => 'README', 'url' => '/docs/readme'],
    ['key' => 'setup', 'title' => 'Setup Guide', 'url' => '/docs/setup'],
    ['key' => 'configuration', 'title' => 'Configuration', 'url' => '/docs/configuration'],
    ['key' => 'env-configuration', 'title' => 'Environment Variables', 'url' => '/docs/env-configuration'],
    ['key' => 'quick-start', 'title' => 'Quick Start', 'url' => '/docs/quick-start'],

    // Essential
    ['key' => 'request-flow', 'title' => 'Request Flow', 'url' => '/docs/request-flow'],
    ['key' => 'framework-features', 'title' => 'Framework Features', 'url' => '/docs/framework-features'],

    // Core Concepts
    ['key' => 'view-templates', 'title' => 'View Templates', 'url' => '/docs/view-templates'],
    ['key' => 'asset-management', 'title' => 'Asset Management', 'url' => '/docs/asset-management'],

    // Security & Authentication
    ['key' => 'auth-system', 'title' => 'Authentication System', 'url' => '/docs/auth-system'],
    ['key' => 'password-reset', 'title' => 'Password Reset', 'url' => '/docs/password-reset'],
    ['key' => 'security-layer', 'title' => 'Security Layer', 'url' => '/docs/security-layer'],
    ['key' => 'encrypter', 'title' => 'Encrypter (AES-256)', 'url' => '/docs/encrypter'],
    ['key' => 'auth-lockout', 'title' => 'Auth Account Lockout', 'url' => '/docs/auth-lockout'],
    ['key' => 'validation-system', 'title' => 'Validation System', 'url' => '/docs/validation-system'],
    ['key' => 'api-versioning', 'title' => 'API Versioning', 'url' => '/docs/api-versioning'],
    ['key' => 'context-permissions', 'title' => 'Context-Based Permissions', 'url' => '/docs/context-permissions'],
    ['key' => 'service-layer', 'title' => 'Service Layer', 'url' => '/docs/service-layer'],

    // Enterprise Features
    ['key' => 'session-system', 'title' => 'Session System', 'url' => '/docs/session-system'],
    ['key' => 'session-encryption', 'title' => 'Session Encryption', 'url' => '/docs/session-encryption'],
    ['key' => 'cache-system', 'title' => 'Cache System', 'url' => '/docs/cache-system'],
    ['key' => 'file-cache', 'title' => 'File Cache Driver', 'url' => '/docs/file-cache'],
    ['key' => 'queue-system', 'title' => 'Queue System', 'url' => '/docs/queue-system'],
    ['key' => 'notification-system', 'title' => 'Notification System', 'url' => '/docs/notification-system'],
    ['key' => 'activity-logging', 'title' => 'Activity Logging', 'url' => '/docs/activity-logging'],

    // Technical Documentation
    ['key' => 'console-commands', 'title' => 'Console Commands', 'url' => '/docs/console-commands'],
    ['key' => 'profiler', 'title' => 'Profiler & Debugging', 'url' => '/docs/profiler'],
    ['key' => 'test-documentation', 'title' => 'Test Documentation', 'url' => '/docs/test-documentation'],
    ['key' => 'testing-guide', 'title' => 'Testing Guide', 'url' => '/docs/testing-guide'],
    ['key' => 'rename', 'title' => 'Rename Process', 'url' => '/docs/rename'],
    ['key' => 'branding', 'title' => 'Framework Branding', 'url' => '/docs/branding'],

    // ===== DEVELOPER DOCS TAB =====

    // Quickstart
    ['key' => 'dev-first-page', 'title' => 'Your First Page', 'url' => '/docs/dev-first-page'],
    ['key' => 'dev-crud-module', 'title' => 'CRUD Module', 'url' => '/docs/dev-crud-module'],

    // Routing & Controllers
    ['key' => 'dev-routes', 'title' => 'Routes', 'url' => '/docs/dev-routes'],
    ['key' => 'dev-route-params', 'title' => 'Route Parameters', 'url' => '/docs/dev-route-params'],

    // Web Development
    ['key' => 'dev-web-controllers', 'title' => 'Web Controllers', 'url' => '/docs/dev-web-controllers'],
    ['key' => 'dev-api-controllers', 'title' => 'API Controllers', 'url' => '/docs/dev-api-controllers'],
    ['key' => 'dev-forms-validation', 'title' => 'Forms & Validation', 'url' => '/docs/dev-forms-validation'],
    ['key' => 'dev-file-uploads', 'title' => 'File Uploads', 'url' => '/docs/dev-file-uploads'],
    ['key' => 'dev-pagination', 'title' => 'Pagination', 'url' => '/docs/dev-pagination'],

    // Frontend
    ['key' => 'dev-assets', 'title' => 'Assets', 'url' => '/docs/dev-assets'],

    // Authentication & Security
    ['key' => 'dev-auth', 'title' => 'Authentication', 'url' => '/docs/dev-auth'],
    ['key' => 'dev-api-auth', 'title' => 'JWT & API Authentication', 'url' => '/docs/dev-api-auth'],
    ['key' => 'dev-security', 'title' => 'Security', 'url' => '/docs/dev-security'],
    ['key' => 'dev-error-handling', 'title' => 'Error Handling', 'url' => '/docs/dev-error-handling'],
    ['key' => 'dev-custom-middleware', 'title' => 'Custom Middleware', 'url' => '/docs/dev-custom-middleware'],

    // Database & Models
    ['key' => 'schema-builder', 'title' => 'Schema Builder', 'url' => '/docs/schema-builder'],
    ['key' => 'dev-models', 'title' => 'Models', 'url' => '/docs/dev-models'],
    ['key' => 'dev-model-advanced', 'title' => 'Advanced Models', 'url' => '/docs/dev-model-advanced'],
    ['key' => 'model-observers', 'title' => 'Model Observers', 'url' => '/docs/model-observers'],
    ['key' => 'multi-database', 'title' => 'Multi-Database Support', 'url' => '/docs/multi-database'],
    ['key' => 'dev-migrations', 'title' => 'Migrations', 'url' => '/docs/dev-migrations'],
    ['key' => 'dev-seeders', 'title' => 'Database Seeders', 'url' => '/docs/dev-seeders'],

    // Advanced Patterns
    ['key' => 'dev-services-repositories', 'title' => 'Services & Repositories', 'url' => '/docs/dev-services-repositories'],
    ['key' => 'dev-events', 'title' => 'Events & Listeners', 'url' => '/docs/dev-events'],

    // Background Processing
    ['key' => 'dev-queues', 'title' => 'Queue System', 'url' => '/docs/dev-queues'],
    ['key' => 'dev-mail', 'title' => 'Mail System', 'url' => '/docs/dev-mail'],

    // CLI Tools
    ['key' => 'dev-cli-commands', 'title' => 'CLI Commands', 'url' => '/docs/dev-cli-commands'],

    // Performance & Caching
    ['key' => 'dev-caching', 'title' => 'Caching', 'url' => '/docs/dev-caching'],

    // Observability
    ['key' => 'dev-logging', 'title' => 'Logging', 'url' => '/docs/dev-logging'],
    ['key' => 'profiler', 'title' => 'Profiler & Debugging', 'url' => '/docs/profiler'],

    // Testing
    ['key' => 'dev-testing', 'title' => 'Testing', 'url' => '/docs/dev-testing'],

    // Utilities & Reference
    ['key' => 'dev-helpers', 'title' => 'Helper Functions', 'url' => '/docs/dev-helpers'],
];
