<?php

/**
 * SO Framework Documentation Design System
 *
 * Registers the documentation CSS and JS assets via AssetManager.
 * The actual CSS is in public/assets/css/docs.css
 * The JS (copyCode) is in public/assets/js/docs.js
 *
 * DESIGN PHILOSOPHY:
 * - CLARITY - Content is king, design should not distract
 * - CONSISTENCY - Same patterns everywhere builds trust
 * - HIERARCHY - Clear visual hierarchy guides the eye
 * - BREATHING ROOM - Generous whitespace improves readability
 *
 * COLOR PALETTE: Primary #2563eb, Success #10b981, Background #f8fafc
 * TYPOGRAPHY: Inter (body), JetBrains Mono (code)
 * GRID: 8px base unit
 */

// CDN dependencies (priority 5 = load first)
assets()->cdn('https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css', 'css', 'head', 5);
assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap', 'css', 'head', 5);

// Syntax highlighting (Highlight.js - GitHub theme)
assets()->cdn('https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github-dark.min.css', 'css', 'head', 6);
assets()->cdn('https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js', 'js', 'body_end', 5);

// Shared base CSS (priority 8 = after CDN, before page-specific)
assets()->css('css/docs-base.css', 'head', 8);

// Content page CSS (priority 10 = after base)
assets()->css('css/docs.css', 'head', 10);

// Code copy functionality JS + highlight init
assets()->js('js/docs.js', 'body_end', 10);
