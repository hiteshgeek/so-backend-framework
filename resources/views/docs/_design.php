<?php

/**
 * SO Framework Documentation Design System
 *
 * DESIGN PHILOSOPHY:
 * ==================
 * 1. CLARITY - Content is king, design should not distract
 * 2. CONSISTENCY - Same patterns everywhere builds trust
 * 3. HIERARCHY - Clear visual hierarchy guides the eye
 * 4. BREATHING ROOM - Generous whitespace improves readability
 *
 * GRID SYSTEM: 8px base unit
 * - Spacing: 8, 16, 24, 32, 48, 64px
 * - Border radius: 8px (standard), 4px (small)
 *
 * COLOR PALETTE:
 * - Primary: #2563eb (Blue 600)
 * - Primary Dark: #1d4ed8 (Blue 700)
 * - Success: #10b981 (Emerald 500)
 * - Surface: #ffffff
 * - Background: #f8fafc (Slate 50)
 * - Text: #1e293b (Slate 800)
 * - Text Secondary: #64748b (Slate 500)
 * - Border: #e2e8f0 (Slate 200)
 * - Code Background: #0f172a (Slate 900)
 *
 * TYPOGRAPHY:
 * - Font: Inter (headings & body), JetBrains Mono (code)
 * - Base size: 15px
 * - Line height: 1.6 (body), 1.3 (headings)
 */
?>
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
    :root {
        /* Colors */
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --primary-light: #3b82f6;
        --primary-bg: #eff6ff;
        --success: #10b981;
        --success-bg: #d1fae5;
        --surface: #ffffff;
        --background: #f8fafc;
        --text: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border: #e2e8f0;
        --border-light: #f1f5f9;
        --code-bg: #0f172a;
        --code-text: #e2e8f0;

        /* Shadows */
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);

        /* Spacing */
        --space-1: 8px;
        --space-2: 16px;
        --space-3: 24px;
        --space-4: 32px;
        --space-5: 48px;
        --space-6: 64px;

        /* Radius */
        --radius: 8px;
        --radius-sm: 4px;
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

    /* ===== HEADER ===== */
    .docs-header {
        background: var(--primary);
        color: white;
        height: 64px;
        padding: 0 var(--space-3);
        display: flex;
        align-items: center;
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
        margin-left: var(--space-2);
        font-weight: 400;
    }

    .docs-nav-link {
        color: white;
        text-decoration: none;
        padding: var(--space-1) var(--space-2);
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

    /* ===== LAYOUT ===== */
    .docs-layout {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--space-3);
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: var(--space-3);
    }

    /* ===== SIDEBAR ===== */
    .docs-sidebar {
        position: sticky;
        top: 88px;
        height: fit-content;
        max-height: calc(100vh - 112px);
        overflow-y: auto;
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
    }

    .docs-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .docs-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .docs-sidebar::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 3px;
    }

    .docs-sidebar::-webkit-scrollbar-thumb:hover {
        background: var(--text-muted);
    }

    .docs-sidebar h3 {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-muted);
        padding: 12px 14px 10px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
        border-bottom: 1px solid var(--border-light);
        background: linear-gradient(180deg, var(--background) 0%, var(--surface) 100%);
    }

    .docs-sidebar h3 .mdi {
        font-size: 14px;
        color: var(--primary);
    }

    .docs-sidebar ul {
        list-style: none;
        padding: 4px 0;
        margin: 0;
    }

    .docs-sidebar li {
        margin: 0;
    }

    .docs-sidebar a {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        padding: 5px 14px;
        color: var(--text);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        line-height: 1.4;
        border-left: 3px solid transparent;
        border-radius: 0 6px 6px 0;
        transition: all 0.2s ease;
        position: relative;
    }

    .docs-sidebar a .mdi {
        font-size: 16px;
        color: var(--primary-light);
        flex-shrink: 0;
        margin-top: 1px;
        opacity: 0.85;
    }

    .docs-sidebar a:hover {
        background: linear-gradient(90deg, var(--primary-bg), transparent);
        color: var(--primary-dark);
        border-left-color: var(--primary-light);
    }

    .docs-sidebar a:hover .mdi {
        color: var(--primary);
        opacity: 1;
        transform: translateX(2px);
        transition: transform 0.2s ease;
    }

    .docs-sidebar a.active {
        background: linear-gradient(90deg, var(--primary-bg), rgba(37, 99, 235, 0.05));
        color: var(--primary-dark);
        border-left-color: var(--primary);
        font-weight: 600;
    }

    .docs-sidebar a.active .mdi {
        color: var(--primary);
        opacity: 1;
    }

    /* Level 2 TOC items (main sections) */
    .docs-sidebar .toc-h2 {
        font-weight: 600;
        color: var(--text);
        padding: 6px 14px;
        margin-top: 2px;
    }

    .docs-sidebar .toc-h2 .mdi {
        color: var(--primary);
    }

    /* Level 3 TOC items (subsections) */
    .docs-sidebar .toc-h3 {
        padding-left: 32px;
        font-size: 12px;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .docs-sidebar .toc-h3 .mdi {
        font-size: 14px;
        color: var(--text-muted);
    }

    .docs-sidebar .toc-h3:hover {
        color: var(--primary-dark);
        background: var(--border-light);
    }

    .docs-sidebar .toc-h3:hover .mdi {
        color: var(--primary-light);
    }

    .docs-sidebar .toc-h3.active {
        color: var(--primary);
        background: var(--primary-bg);
        font-weight: 600;
    }

    /* ===== CONTENT ===== */
    .docs-content {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        padding: var(--space-4) var(--space-5);
        min-width: 0;
    }

    /* ===== HEADINGS ===== */
    .heading {
        scroll-margin-top: 88px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .heading-icon {
        flex-shrink: 0;
    }

    .heading-1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: var(--space-3);
        padding-bottom: var(--space-2);
        border-bottom: 2px solid var(--primary);
    }

    .heading-1 .heading-icon {
        font-size: 36px;
        color: var(--primary);
    }

    .heading-2 {
        font-size: 22px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-top: var(--space-4);
        margin-bottom: var(--space-2);
    }

    .heading-2:first-child,
    .paragraph+.heading-2,
    .docs-content>.heading-2:first-of-type {
        margin-top: 0;
    }

    .heading-2 .heading-icon {
        font-size: 24px;
    }

    .heading-3 {
        font-size: 18px;
        font-weight: 600;
        margin-top: 0;
        margin-bottom: 12px;
        padding-left: 14px;
        border-left: 3px solid var(--primary);
        color: var(--text);
    }

    .heading-3 .heading-icon {
        display: none;
    }

    .heading-4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-top: 0;
        margin-bottom: var(--space-1);
        padding-left: 12px;
        border-left: 2px solid var(--text-secondary);
    }

    .heading-4 .heading-icon {
        display: none;
    }

    /* ===== PARAGRAPH ===== */
    .paragraph {
        line-height: 1.8;
        color: #475569;
        margin-bottom: var(--space-2);
    }

    /* ===== LISTS ===== */
    .numbered-list,
    .bullet-list {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .list-item {
        display: flex;
        gap: 10px;
        line-height: 0.7;
        padding: 4px 0;
        align-items: center;
    }

    .item-number {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        font-size: 13px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .bullet-icon {
        color: var(--primary);
        font-size: 24px;
        flex-shrink: 0;
        margin-top: -2px;
    }

    .item-content {
        flex: 1;
        color: #475569;
    }

    /* ===== CHECKBOXES ===== */
    .checkbox-item .checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
        background: var(--surface);
    }

    .checkbox-item.checked .checkbox {
        background: var(--success);
        border-color: var(--success);
        color: white;
    }

    .checkbox-item .checkbox .mdi {
        font-size: 14px;
    }

    /* ===== INLINE CHECKBOXES ===== */
    .checkbox-inline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
        margin: 0 2px;
    }

    .checkbox-inline .mdi {
        font-size: 18px;
        color: var(--text-muted);
    }

    .checkbox-inline.checked .mdi {
        color: var(--success);
    }

    /* ===== CODE ===== */
    .inline-code {
        background: var(--border-light);
        padding: 2px 6px;
        border-radius: var(--radius-sm);
        font-family: 'JetBrains Mono', monospace;
        font-size: 13px;
        color: #e11d48;
    }

    .code-container {
        margin: var(--space-2) 0 var(--space-3);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .code-header {
        background: #1e293b;
        padding: var(--space-1) var(--space-2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .code-lang {
        font-size: 11px;
        font-weight: 500;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .code-copy {
        background: transparent;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 4px;
        border-radius: var(--radius-sm);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .code-copy:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .code-copy .mdi {
        font-size: 16px;
    }

    .code-block {
        background: var(--code-bg);
        padding: var(--space-2) var(--space-3);
        overflow-x: auto;
        margin: 0;
    }

    .code-block code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 14px;
        line-height: 1.6;
        color: var(--code-text);
    }

    /* ===== TABLES ===== */
    .table-container {
        margin: var(--space-2) 0 var(--space-3);
        overflow-x: auto;
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: var(--primary);
        color: white;
        padding: 12px var(--space-2);
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .data-table td {
        padding: 12px var(--space-2);
        border-bottom: 1px solid var(--border);
        font-size: 14px;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover td {
        background: var(--border-light);
    }

    /* ===== BLOCKQUOTE ===== */
    .quote-block {
        margin: var(--space-2) 0 var(--space-3);
        padding: var(--space-2);
        background: var(--primary-bg);
        border-left: 4px solid var(--primary);
        border-radius: 0 var(--radius) var(--radius) 0;
        display: flex;
        gap: 12px;
    }

    .quote-icon {
        color: var(--primary);
        font-size: 24px;
        flex-shrink: 0;
    }

    .quote-content {
        flex: 1;
    }

    .quote-content p {
        margin: 0;
        color: var(--primary-dark);
    }

    /* ===== DIVIDER ===== */
    .divider {
        border: none;
        height: 1px;
        background: var(--border);
        margin: var(--space-1) 0;
    }

    /* ===== IMAGES ===== */
    .inline-image {
        max-width: 100%;
        height: auto;
        border-radius: var(--radius);
        margin: var(--space-2) 0;
        box-shadow: var(--shadow-sm);
    }

    /* ===== LINKS ===== */
    .link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .link:hover {
        text-decoration: underline;
    }

    /* ===== FLOWCHART DIAGRAM ===== */
    .flowchart-container {
        margin: var(--space-3) 0;
        padding: var(--space-3);
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f0fdf4 100%);
        border-radius: var(--radius);
        border: 1px solid var(--border);
    }

    .flowchart-step {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .flowchart-connector {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: var(--space-1) 0;
        color: var(--primary);
    }

    .flowchart-connector .mdi {
        font-size: 28px;
        animation: flowPulse 2s ease-in-out infinite;
    }

    @keyframes flowPulse {

        0%,
        100% {
            opacity: 0.5;
        }

        50% {
            opacity: 1;
        }
    }

    .flowchart-box {
        background: var(--surface);
        border: 2px solid var(--primary);
        border-radius: var(--radius);
        padding: var(--space-2) var(--space-3);
        width: 100%;
        max-width: 600px;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }

    .flowchart-box:hover {
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-dark);
    }

    .flowchart-box-start {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border-color: var(--primary-dark);
    }

    .flowchart-box-start .flowchart-title,
    .flowchart-box-start .flowchart-subtitle {
        color: white;
    }

    .flowchart-box-end {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-color: #059669;
    }

    .flowchart-box-end .flowchart-title,
    .flowchart-box-end .flowchart-subtitle {
        color: white;
    }

    .flowchart-box-end .flowchart-number {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .flowchart-box-header {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .flowchart-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .flowchart-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text);
    }

    .flowchart-subtitle {
        font-size: 13px;
        color: var(--text-secondary);
        font-weight: 500;
        background: var(--border-light);
        padding: 2px 10px;
        border-radius: 12px;
    }

    .flowchart-box-start .flowchart-subtitle,
    .flowchart-box-end .flowchart-subtitle {
        background: rgba(255, 255, 255, 0.2);
    }

    .flowchart-items {
        list-style: none;
        margin: var(--space-1) 0 0;
        padding: 0;
        border-top: 1px solid var(--border-light);
        padding-top: var(--space-1);
    }

    .flowchart-box-start .flowchart-items,
    .flowchart-box-end .flowchart-items {
        border-top-color: rgba(255, 255, 255, 0.2);
    }

    .flowchart-items li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 6px 0;
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .flowchart-box-start .flowchart-items li,
    .flowchart-box-end .flowchart-items li {
        color: rgba(255, 255, 255, 0.9);
    }

    .flowchart-items li .mdi {
        font-size: 18px;
        color: var(--primary);
        flex-shrink: 0;
        margin-top: 1px;
    }

    .flowchart-box-start .flowchart-items li .mdi,
    .flowchart-box-end .flowchart-items li .mdi {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Alternative flow styles for horizontal diagrams */
    .flowchart-horizontal {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-2);
        justify-content: center;
        align-items: flex-start;
    }

    .flowchart-horizontal .flowchart-step {
        flex-direction: row;
    }

    .flowchart-horizontal .flowchart-connector {
        padding: 0 var(--space-1);
    }

    .flowchart-horizontal .flowchart-connector .mdi {
        transform: rotate(-90deg);
    }

    /* Mobile responsive */
    @media (max-width: 600px) {
        .flowchart-box {
            padding: var(--space-2);
        }

        .flowchart-box-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .flowchart-title {
            font-size: 14px;
        }

        .flowchart-items li {
            font-size: 12px;
        }
    }

    /* ===== CALLOUT BOXES ===== */
    .callout {
        margin: var(--space-2) 0 var(--space-3);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius);
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .callout-icon {
        font-size: 22px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .callout-content {
        flex: 1;
    }

    .callout-title {
        font-weight: 600;
        margin-bottom: 4px;
        font-size: 14px;
    }

    .callout-text {
        font-size: 14px;
        line-height: 1.6;
    }

    .callout-text p {
        margin: 0;
    }

    /* Info Callout (Blue) */
    .callout-info {
        background: var(--primary-bg);
        border-left: 4px solid var(--primary);
    }

    .callout-info .callout-icon {
        color: var(--primary);
    }

    .callout-info .callout-title {
        color: var(--primary-dark);
    }

    .callout-info .callout-text {
        color: #1e40af;
    }

    /* Warning Callout (Amber) */
    .callout-warning {
        background: #fffbeb;
        border-left: 4px solid #f59e0b;
    }

    .callout-warning .callout-icon {
        color: #d97706;
    }

    .callout-warning .callout-title {
        color: #b45309;
    }

    .callout-warning .callout-text {
        color: #92400e;
    }

    /* Danger Callout (Red) */
    .callout-danger {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
    }

    .callout-danger .callout-icon {
        color: #dc2626;
    }

    .callout-danger .callout-title {
        color: #b91c1c;
    }

    .callout-danger .callout-text {
        color: #991b1b;
    }

    /* Success Callout (Green) */
    .callout-success {
        background: var(--success-bg);
        border-left: 4px solid var(--success);
    }

    .callout-success .callout-icon {
        color: var(--success);
    }

    .callout-success .callout-title {
        color: #059669;
    }

    .callout-success .callout-text {
        color: #065f46;
    }

    /* Tip Callout (Purple) */
    .callout-tip {
        background: #f5f3ff;
        border-left: 4px solid #8b5cf6;
    }

    .callout-tip .callout-icon {
        color: #7c3aed;
    }

    .callout-tip .callout-title {
        color: #6d28d9;
    }

    .callout-tip .callout-text {
        color: #5b21b6;
    }

    /* Note Callout (Gray) */
    .callout-note {
        background: #f8fafc;
        border-left: 4px solid #64748b;
    }

    .callout-note .callout-icon {
        color: #475569;
    }

    .callout-note .callout-title {
        color: #334155;
    }

    .callout-note .callout-text {
        color: #475569;
    }

    /* ===== API ENDPOINTS ===== */
    .api-endpoint {
        margin: var(--space-2) 0;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }

    .api-endpoint-header {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-2);
        background: var(--background);
        border-bottom: 1px solid var(--border);
    }

    .api-method {
        padding: 4px 10px;
        border-radius: var(--radius-sm);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-family: 'JetBrains Mono', monospace;
    }

    .api-method-get {
        background: #d1fae5;
        color: #065f46;
    }

    .api-method-post {
        background: #dbeafe;
        color: #1e40af;
    }

    .api-method-put {
        background: #fef3c7;
        color: #92400e;
    }

    .api-method-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .api-method-patch {
        background: #e0e7ff;
        color: #3730a3;
    }

    .api-path {
        font-family: 'JetBrains Mono', monospace;
        font-size: 14px;
        color: var(--text);
    }

    .api-path-param {
        color: var(--primary);
        font-weight: 600;
    }

    .api-endpoint-body {
        padding: var(--space-2);
        background: var(--surface);
    }

    .api-description {
        font-size: 14px;
        color: var(--text-secondary);
        margin-bottom: var(--space-1);
        line-height: 1.6;
    }

    .api-params {
        margin-top: var(--space-2);
    }

    .api-param {
        display: flex;
        gap: var(--space-2);
        padding: var(--space-1) 0;
        border-bottom: 1px solid var(--border-light);
        font-size: 13px;
    }

    .api-param:last-child {
        border-bottom: none;
    }

    .api-param-name {
        font-family: 'JetBrains Mono', monospace;
        color: var(--primary);
        font-weight: 500;
        min-width: 120px;
    }

    .api-param-type {
        color: var(--text-muted);
        min-width: 80px;
    }

    .api-param-desc {
        color: var(--text-secondary);
        flex: 1;
    }

    /* ===== KEYBOARD SHORTCUTS ===== */
    .kbd {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        padding: 2px 8px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
        font-weight: 500;
        color: var(--text);
        background: linear-gradient(180deg, var(--surface) 0%, var(--background) 100%);
        border: 1px solid var(--border);
        border-bottom-width: 2px;
        border-radius: var(--radius-sm);
        box-shadow: var(--shadow-sm);
    }

    .kbd-combo {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .kbd-separator {
        color: var(--text-muted);
        font-size: 10px;
        font-weight: 600;
    }

    /* ===== FILE PATHS ===== */
    .file-path {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: var(--border-light);
        border-radius: var(--radius-sm);
        font-family: 'JetBrains Mono', monospace;
        font-size: 13px;
        color: var(--text);
    }

    .file-path .mdi {
        font-size: 16px;
        color: var(--primary);
    }

    .file-path-segment {
        color: var(--text-secondary);
    }

    .file-path-separator {
        color: var(--text-muted);
    }

    .file-path-name {
        color: var(--text);
        font-weight: 500;
    }

    /* ===== METHOD SIGNATURES ===== */
    .method-signature {
        margin: var(--space-2) 0;
        padding: var(--space-2) var(--space-3);
        background: var(--border-light);
        border-radius: var(--radius);
        border-left: 4px solid var(--primary);
        font-family: 'JetBrains Mono', monospace;
        font-size: 14px;
        overflow-x: auto;
        white-space: nowrap;
    }

    .method-visibility {
        color: #c678dd;
    }

    .method-static {
        color: #c678dd;
        font-style: italic;
    }

    .method-name {
        color: #61afef;
        font-weight: 600;
    }

    .method-param {
        color: #e5c07b;
    }

    .method-type {
        color: #98c379;
    }

    .method-return {
        color: #56b6c2;
    }

    .method-punctuation {
        color: var(--text-secondary);
    }

    /* ===== FEATURE CARDS ===== */
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-2);
        margin: var(--space-3) 0;
    }

    .feature-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: var(--space-3);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: all 0.2s ease;
    }

    .feature-card:hover {
        box-shadow: var(--shadow);
        border-color: var(--primary-light);
    }

    .feature-card-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius);
        background: var(--primary-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: var(--space-2);
    }

    .feature-card-icon .mdi {
        font-size: 24px;
        color: var(--primary);
    }

    .feature-card-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: var(--space-1);
    }

    .feature-card-description {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* ===== TABS ===== */
    .tabs-container {
        margin: var(--space-2) 0 var(--space-3);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }

    .tabs-header {
        display: flex;
        background: var(--background);
        border-bottom: 1px solid var(--border);
        overflow-x: auto;
    }

    .tab-button {
        padding: var(--space-1) var(--space-2);
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
        background: transparent;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: inherit;
    }

    .tab-button:hover {
        color: var(--text);
        background: var(--surface);
    }

    .tab-button.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
        background: var(--surface);
    }

    .tab-button .mdi {
        font-size: 16px;
    }

    .tab-content {
        display: none;
        background: var(--surface);
    }

    .tab-content.active {
        display: block;
    }

    .tab-content .code-container {
        margin: 0;
        border-radius: 0;
        box-shadow: none;
        border: none;
    }

    /* ===== EXTENDED BADGES ===== */
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

    .badge-sm {
        padding: 2px 6px;
        font-size: 10px;
    }

    .badge-lg {
        padding: 6px 14px;
        font-size: 13px;
    }

    /* Status Badges */
    .badge-stable {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-beta {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-deprecated {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-experimental {
        background: #e0e7ff;
        color: #3730a3;
    }

    .badge-new {
        background: #ecfdf5;
        color: #059669;
    }

    /* HTTP Method Badges */
    .badge-get {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-post {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-put {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-patch {
        background: #e0e7ff;
        color: #3730a3;
    }

    /* Version Badge */
    .badge-version {
        background: var(--code-bg);
        color: var(--code-text);
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
    }

    /* ===== BREADCRUMBS ===== */
    .breadcrumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: var(--space-1) 0;
        font-size: 13px;
        margin-bottom: var(--space-2);
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-item:hover {
        color: var(--primary);
    }

    .breadcrumb-item .mdi {
        font-size: 16px;
    }

    .breadcrumb-separator {
        color: var(--text-muted);
        font-size: 16px;
    }

    .breadcrumb-current {
        color: var(--text);
        font-weight: 500;
    }

    /* ===== FOOTER NAVIGATION ===== */
    .docs-footer-nav {
        display: flex;
        justify-content: space-between;
        padding: var(--space-4) 0;
        margin-top: var(--space-5);
        border-top: 1px solid var(--border);
        gap: var(--space-2);
    }

    .footer-nav-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
        text-decoration: none;
        padding: var(--space-2);
        border-radius: var(--radius);
        transition: all 0.2s;
        max-width: 45%;
        border: 1px solid var(--border);
        background: var(--surface);
    }

    .footer-nav-item:hover {
        background: var(--primary-bg);
        border-color: var(--primary-light);
    }

    .footer-nav-label {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }

    .footer-nav-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-nav-title .mdi {
        font-size: 18px;
    }

    .footer-nav-prev {
        text-align: left;
    }

    .footer-nav-next {
        text-align: right;
        margin-left: auto;
    }

    .footer-nav-next .footer-nav-title {
        justify-content: flex-end;
    }

    /* ===== EXTENDED TYPOGRAPHY ===== */
    .heading-5 {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-top: var(--space-2);
        margin-bottom: var(--space-1);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .heading-6 {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        margin-top: var(--space-2);
        margin-bottom: var(--space-1);
    }

    .text-lead {
        font-size: 18px;
        line-height: 1.7;
        color: var(--text-secondary);
        margin-bottom: var(--space-3);
    }

    .text-small {
        font-size: 13px;
        line-height: 1.5;
    }

    .text-caption {
        font-size: 11px;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        font-weight: 600;
        color: var(--text-muted);
    }

    .text-muted {
        color: var(--text-muted);
    }

    .text-secondary {
        color: var(--text-secondary);
    }

    .text-primary {
        color: var(--primary);
    }

    .text-success {
        color: var(--success);
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    /* ===== SYNTAX HIGHLIGHTING ===== */
    .token-keyword {
        color: #c678dd;
    }

    .token-string {
        color: #98c379;
    }

    .token-number {
        color: #d19a66;
    }

    .token-comment {
        color: #5c6370;
        font-style: italic;
    }

    .token-function {
        color: #61afef;
    }

    .token-class {
        color: #e5c07b;
    }

    .token-variable {
        color: #e06c75;
    }

    .token-operator {
        color: #56b6c2;
    }

    .token-property {
        color: #abb2bf;
    }

    .token-punctuation {
        color: #abb2bf;
    }

    /* Code with line numbers */
    .code-block-numbered {
        counter-reset: line;
    }

    .code-block-numbered .code-line {
        display: block;
        padding-left: 48px;
        position: relative;
    }

    .code-block-numbered .code-line::before {
        counter-increment: line;
        content: counter(line);
        position: absolute;
        left: 0;
        width: 32px;
        text-align: right;
        color: var(--text-muted);
        font-size: 12px;
        border-right: 1px solid #334155;
        padding-right: 8px;
        margin-right: 16px;
    }

    /* Code diff */
    .code-line-added {
        background: rgba(16, 185, 129, 0.15);
        border-left: 3px solid var(--success);
        margin-left: -16px;
        padding-left: 13px;
    }

    .code-line-removed {
        background: rgba(239, 68, 68, 0.15);
        border-left: 3px solid #ef4444;
        margin-left: -16px;
        padding-left: 13px;
    }

    /* ===== UTILITY CLASSES ===== */
    .mt-0 {
        margin-top: 0;
    }

    .mt-1 {
        margin-top: var(--space-1);
    }

    .mt-2 {
        margin-top: var(--space-2);
    }

    .mt-3 {
        margin-top: var(--space-3);
    }

    .mt-4 {
        margin-top: var(--space-4);
    }

    .mt-5 {
        margin-top: var(--space-5);
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .mb-1 {
        margin-bottom: var(--space-1);
    }

    .mb-2 {
        margin-bottom: var(--space-2);
    }

    .mb-3 {
        margin-bottom: var(--space-3);
    }

    .mb-4 {
        margin-bottom: var(--space-4);
    }

    .mb-5 {
        margin-bottom: var(--space-5);
    }

    .pt-0 {
        padding-top: 0;
    }

    .pt-1 {
        padding-top: var(--space-1);
    }

    .pt-2 {
        padding-top: var(--space-2);
    }

    .pt-3 {
        padding-top: var(--space-3);
    }

    .pb-0 {
        padding-bottom: 0;
    }

    .pb-1 {
        padding-bottom: var(--space-1);
    }

    .pb-2 {
        padding-bottom: var(--space-2);
    }

    .pb-3 {
        padding-bottom: var(--space-3);
    }

    .gap-1 {
        gap: var(--space-1);
    }

    .gap-2 {
        gap: var(--space-2);
    }

    .gap-3 {
        gap: var(--space-3);
    }

    .flex {
        display: flex;
    }

    .flex-col {
        flex-direction: column;
    }

    .items-center {
        align-items: center;
    }

    .justify-between {
        justify-content: space-between;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .grid {
        display: grid;
    }

    .grid-cols-1 {
        grid-template-columns: repeat(1, 1fr);
    }

    .grid-cols-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    .grid-cols-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .grid-cols-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    .hidden {
        display: none;
    }

    .block {
        display: block;
    }

    /* ===== SCROLL PROGRESS ===== */
    .scroll-progress {
        position: fixed;
        top: 64px;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        z-index: 99;
        transition: width 0.1s linear;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .docs-layout {
            grid-template-columns: 1fr;
        }

        .docs-sidebar {
            position: relative;
            top: 0;
            max-height: 300px;
            order: -1;
        }

        .docs-content {
            padding: var(--space-3);
        }

        .docs-header-inner {
            flex-direction: column;
            gap: var(--space-1);
        }

        .docs-header {
            height: auto;
            padding: var(--space-2);
        }

        .feature-grid {
            grid-template-columns: 1fr;
        }

        .docs-footer-nav {
            flex-direction: column;
        }

        .footer-nav-item {
            max-width: 100%;
        }

        .footer-nav-next {
            margin-left: 0;
        }

        .grid-cols-2,
        .grid-cols-3,
        .grid-cols-4 {
            grid-template-columns: 1fr;
        }

        .api-endpoint-header {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 600px) {
        .breadcrumbs {
            font-size: 12px;
            flex-wrap: wrap;
        }

        .kbd {
            font-size: 11px;
            padding: 2px 6px;
        }

        .method-signature {
            font-size: 12px;
            padding: var(--space-2);
        }
    }

    /* ===== IN-CONTENT TABLE OF CONTENTS ===== */
    .toc-box {
        margin: var(--space-3) 0;
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .toc-box-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: var(--space-2) var(--space-3);
        margin: 0;
        background: linear-gradient(180deg, var(--primary-bg) 0%, var(--surface) 100%);
        border-bottom: 1px solid var(--border);
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-dark);
    }

    .toc-box-header .mdi {
        font-size: 22px;
        color: var(--primary);
    }

    .toc-box-list {
        list-style: none;
        padding: var(--space-2) var(--space-3);
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
    }

    .toc-box-item {
        margin: 0;
    }

    .toc-box-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius-sm);
        text-decoration: none;
        color: var(--text);
        transition: all 0.2s ease;
    }

    .toc-box-link:hover {
        background: var(--primary-bg);
        color: var(--primary-dark);
    }

    .toc-box-link:hover .toc-box-number {
        background: var(--primary-dark);
        transform: scale(1.05);
    }

    .toc-box-number {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        font-size: 13px;
        font-weight: 600;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .toc-box-title {
        font-size: 14px;
        font-weight: 500;
    }

    /* Responsive: Stack on mobile */
    @media (max-width: 600px) {
        .toc-box-list {
            gap: var(--space-1);
        }

        .toc-box-link {
            padding: 6px var(--space-1);
        }

        .toc-box-number {
            min-width: 24px;
            height: 24px;
            font-size: 12px;
        }

        .toc-box-title {
            font-size: 13px;
        }
    }
</style>
<script>
    function copyCode(btn) {
        const code = btn.closest('.code-container').querySelector('code').textContent;
        const icon = btn.querySelector('.mdi');

        // Try clipboard API first, fallback to execCommand
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(code).then(function() {
                showCopySuccess(icon);
            }).catch(function() {
                fallbackCopy(code, icon);
            });
        } else {
            fallbackCopy(code, icon);
        }
    }

    function fallbackCopy(text, icon) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            showCopySuccess(icon);
        } catch (e) {
            console.error('Copy failed', e);
        }
        document.body.removeChild(textarea);
    }

    function showCopySuccess(icon) {
        icon.classList.remove('mdi-content-copy');
        icon.classList.add('mdi-check');
        setTimeout(function() {
            icon.classList.remove('mdi-check');
            icon.classList.add('mdi-content-copy');
        }, 2000);
    }
</script>