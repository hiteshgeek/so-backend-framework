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
        gap: 8px;
        padding: 8px 14px;
        color: var(--text);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        line-height: 1.5;
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
        padding: 10px 14px;
        margin-top: 4px;
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
        margin-top: var(--space-4);
        /* margin-bottom: 12px; */
    }

    .heading-3 .heading-icon {
        font-size: 22px;
        color: var(--primary);
    }

    .heading-4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-top: var(--space-3);
        margin-bottom: var(--space-1);
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
        margin: var(--space-2) 0;
        padding: 0;
        list-style: none;
    }

    .list-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        /* margin-bottom: 12px; */
        line-height: 1.3;
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
            transform: translateY(0);
        }

        50% {
            opacity: 1;
            transform: translateY(4px);
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
        transform: translateY(-2px);
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
    }
</style>