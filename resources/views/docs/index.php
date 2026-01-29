<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Documentation') ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            padding: 30px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        h1 {
            font-size: 1.5em;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
        }

        .subtitle {
            color: #6c757d;
            font-size: 0.9em;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .docs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            margin-top: 28px;
        }

        .doc-card {
            padding: 18px 20px;
            background: #ffffff;
            border-radius: 6px;
            text-decoration: none;
            color: inherit;
            transition: box-shadow 0.25s ease, border-color 0.25s ease;
            border: 1px solid #e0e0e0;
        }

        .doc-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            border-color: #3b82f6;
        }

        .doc-card h3 {
            color: #3b82f6;
            margin-bottom: 6px;
            font-size: 0.95em;
            font-weight: 600;
        }

        .doc-card p {
            color: #6c757d;
            line-height: 1.5;
            font-size: 0.85em;
        }

        .doc-icon {
            font-size: 1.6em;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .back-link {
            display: inline-block;
            margin-top: 24px;
            padding: 8px 20px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.85em;
            transition: box-shadow 0.25s ease;
        }

        .back-link:hover {
            box-shadow: 0 3px 12px rgba(59, 130, 246, 0.3);
        }

        .featured {
            background: #f0f7ff;
            border-color: #3b82f6;
        }

        .featured h3 {
            color: #1e40af;
        }

        .featured p {
            color: #4b5563;
        }

        .featured .doc-icon {
            filter: hue-rotate(-10deg);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 <?= htmlspecialchars(config('app.name')) ?> Documentation</h1>
        <p class="subtitle">Complete guide to building applications with <?= htmlspecialchars(config('app.name')) ?></p>

        <div class="docs-grid">
            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/comprehensive" class="doc-card featured">
                <div class="doc-icon">📖</div>
                <h3>Comprehensive Guide</h3>
                <p>Complete documentation covering all implemented, partial, and planned features with examples and best practices.</p>
            </a>

            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/index" class="doc-card featured">
                <div class="doc-icon">🗂️</div>
                <h3>Documentation Index</h3>
                <p>Navigation hub for all documentation files organized by topic. Start here to find what you need!</p>
            </a>

            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/readme" class="doc-card">
                <div class="doc-icon">🚀</div>
                <h3>README</h3>
                <p>Framework overview, features, and quick introduction to get started.</p>
            </a>

            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/setup" class="doc-card">
                <div class="doc-icon">⚙️</div>
                <h3>Setup Guide</h3>
                <p>Complete installation and setup instructions for development and production.</p>
            </a>

            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/configuration" class="doc-card">
                <div class="doc-icon">🔧</div>
                <h3>Configuration</h3>
                <p>Learn how the configuration system works and how to customize the framework.</p>
            </a>

            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/quick-start" class="doc-card">
                <div class="doc-icon">⚡</div>
                <h3>Quick Start</h3>
                <p>Fast reference guide for common tasks and quick lookups.</p>
            </a>

            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/rename" class="doc-card">
                <div class="doc-icon">✏️</div>
                <h3>Rename Process</h3>
                <p>Step-by-step guide to rename and customize the framework branding.</p>
            </a>

            <a href="<?= htmlspecialchars(config('app.url')) ?>/docs/branding" class="doc-card">
                <div class="doc-icon">🎨</div>
                <h3>Framework Branding</h3>
                <p>Complete reference for all files containing framework name and branding.</p>
            </a>
        </div>

        <a href="<?= htmlspecialchars(config('app.url')) ?>/" class="back-link">← Back to Home</a>
    </div>
</body>
</html>
