<?php

/**
 * SO Framework Documentation - Index Page Styles
 *
 * Registers the docs index page CSS via AssetManager.
 * The actual CSS is in public/assets/css/docs-index.css
 */

// CDN dependencies (priority 5 = load first)
assets()->cdn('https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css', 'css', 'head', 5);
assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap', 'css', 'head', 5);

// Shared base CSS (priority 8 = after CDN, before page-specific)
assets()->css('css/docs-base.css', 'head', 8);

// Index page CSS (priority 10 = after base)
assets()->css('css/docs-index.css', 'head', 10);
