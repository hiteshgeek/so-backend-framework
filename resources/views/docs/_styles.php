<?php

/**
 * SO Framework Documentation - Index Page Styles
 *
 * DESIGN PHILOSOPHY (Same as _design.php):
 * - Clean, minimal design with focus on readability
 * - Consistent spacing using 8px grid system
 * - Blue primary color (#2563eb) for interactive elements
 * - Inter font for modern, clean typography
 */
?>
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
    :root {
        /* Colors - Same as _design.php */
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --primary-light: #3b82f6;
        --primary-bg: #eff6ff;
        --success: #10b981;
        --surface: #ffffff;
        --background: #f8fafc;
        --text: #1e293b;
        --text-secondary: #64748b;
        --border: #e2e8f0;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --radius: 8px;
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
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        font-size: 15px;
        line-height: 1.6;
        color: var(--text);
        background: var(--background);
        -webkit-font-smoothing: antialiased;
    }

    /* Header */
    .docs-header {
        background: var(--primary);
        color: white;
        height: 64px;
        display: flex;
        align-items: center;
        padding: 0 24px;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: var(--shadow);
    }

    .docs-header-inner {
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .docs-header h1 {
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .docs-header h1 .mdi {
        font-size: 24px;
    }

    .docs-header .subtitle {
        font-size: 14px;
        opacity: 0.8;
        margin-left: 16px;
        font-weight: 400;
    }

    .docs-nav-link {
        color: white;
        text-decoration: none;
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: var(--radius);
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }

    .docs-nav-link:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    /* Container */
    .docs-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 24px 48px;
    }

    /* Stats Cards */
    .docs-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 40px;
    }

    .docs-stat-card {
        background: var(--surface);
        padding: 24px;
        border-radius: var(--radius);
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: all 0.2s;
    }

    .docs-stat-card:hover {
        box-shadow: var(--shadow);
    }

    .docs-stat-card .stat-icon {
        font-size: 32px;
        color: var(--primary-light);
        margin-bottom: 8px;
        display: block;
    }

    .docs-stat-card h3 {
        font-size: 36px;
        color: var(--primary);
        font-weight: 700;
    }

    .docs-stat-card p {
        font-size: 11px;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 4px;
    }

    /* Section */
    .docs-section {
        margin-bottom: 32px;
    }

    .docs-section-title {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-secondary);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .docs-section-title .mdi {
        font-size: 18px;
        color: var(--primary);
    }

    /* Card Grid */
    .docs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }

    .docs-grid-featured {
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }

    /* Card */
    .doc-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 20px 24px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }

    .doc-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary);
        transform: scaleX(0);
        transition: transform 0.2s;
    }

    .doc-card:hover {
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-light);
    }

    .doc-card:hover::before {
        transform: scaleX(1);
    }

    .doc-card h3 {
        color: var(--text);
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .doc-card h3 .mdi {
        font-size: 22px;
        color: var(--primary);
    }

    .doc-card-body {
        flex: 1;
    }

    .doc-card p {
        color: var(--text-secondary);
        font-size: 14px;
        line-height: 1.5;
    }

    .doc-card .badge {
        margin-top: 12px;
        align-self: flex-start;
    }

    /* Featured Cards */
    .doc-card.featured {
        background: linear-gradient(135deg, var(--primary-bg) 0%, #dbeafe 100%);
        border-color: var(--primary-light);
    }

    .doc-card.featured::before {
        background: var(--primary-dark);
        transform: scaleX(1);
    }

    .doc-card.featured h3 {
        color: var(--primary-dark);
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .badge .mdi {
        font-size: 12px;
    }

    .badge-essential {
        background: #fef2f2;
        color: #dc2626;
    }

    .badge-new {
        background: #ecfdf5;
        color: #059669;
    }

    .badge-default {
        background: var(--primary-bg);
        color: var(--primary);
    }

    .badge-enterprise {
        background: #faf5ff;
        color: #7c3aed;
    }

    .badge-technical {
        background: #f1f5f9;
        color: #475569;
    }

    .badge-featured {
        background: var(--primary);
        color: white;
    }

    /* Footer */
    .docs-footer {
        background: var(--surface);
        padding: 32px 24px;
        text-align: center;
        border-top: 1px solid var(--border);
        margin-top: 48px;
    }

    .docs-footer p {
        color: var(--text-secondary);
        font-size: 14px;
        margin-bottom: 8px;
    }

    .docs-footer p .mdi {
        vertical-align: middle;
        margin-right: 4px;
    }

    .docs-footer a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .docs-footer a:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .docs-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .docs-grid,
        .docs-grid-featured {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .docs-header {
            height: auto;
            padding: 16px;
        }

        .docs-header-inner {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }

        .docs-container {
            padding: 24px 16px;
        }
    }
</style>