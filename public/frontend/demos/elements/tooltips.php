<?php
/**
 * SixOrbit UI Demo - Tooltips
 */
$pageTitle = 'Tooltips';
$pageDescription = 'Tooltip components for hover hints';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Tooltips</h1>
            <p class="so-page-subtitle">Tooltip components for hover hints</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Basic Tooltips -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Basic Tooltips</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            JavaScript-powered tooltips with automatic positioning and animations.
                        </p>
                                                        <div class="so-flex so-gap-3 so-flex-wrap">
                                    <button class="so-btn so-btn-primary" data-so-tooltip="Tooltip on top">Top</button>
                                    <button class="so-btn so-btn-primary" data-so-tooltip="Tooltip on bottom" data-so-tooltip-position="bottom">Bottom</button>
                                    <button class="so-btn so-btn-primary" data-so-tooltip="Tooltip on left" data-so-tooltip-position="left">Left</button>
                                    <button class="so-btn so-btn-primary" data-so-tooltip="Tooltip on right" data-so-tooltip-position="right">Right</button>
                                </div>
                        <?= so_code_block('<button data-so-tooltip="Tooltip on top">Top</button>
<button data-so-tooltip="Tooltip on bottom" data-so-tooltip-position="bottom">Bottom</button>
<button data-so-tooltip="Tooltip on left" data-so-tooltip-position="left">Left</button>
<button data-so-tooltip="Tooltip on right" data-so-tooltip-position="right">Right</button>', 'html') ?>
                    </div>
                </div>

                <!-- Keyboard Shortcuts -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Keyboard Shortcuts</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Display keyboard shortcuts alongside tooltip text. Automatically adapts for Mac (⌘) and Windows (Ctrl).
                        </p>
                                                        <div class="so-flex so-gap-3 so-flex-wrap">
                                    <button class="so-btn so-btn-secondary" data-so-tooltip="Copy" data-so-shortcut="Ctrl+C">
                                        <span class="material-icons" class="so-tooltip-demo-icon">content_copy</span>
                                        Copy
                                    </button>
                                    <button class="so-btn so-btn-secondary" data-so-tooltip="Paste" data-so-shortcut="Ctrl+V">
                                        <span class="material-icons" class="so-tooltip-demo-icon">content_paste</span>
                                        Paste
                                    </button>
                                    <button class="so-btn so-btn-secondary" data-so-tooltip="Save" data-so-shortcut="Ctrl+S">
                                        <span class="material-icons" class="so-tooltip-demo-icon">save</span>
                                        Save
                                    </button>
                                    <button class="so-btn so-btn-secondary" data-so-tooltip="Undo" data-so-shortcut="Ctrl+Z">
                                        <span class="material-icons" class="so-tooltip-demo-icon">undo</span>
                                        Undo
                                    </button>
                                    <button class="so-btn so-btn-secondary" data-so-tooltip="Command Palette" data-so-shortcut="Ctrl+Shift+P">
                                        <span class="material-icons" class="so-tooltip-demo-icon">terminal</span>
                                        Commands
                                    </button>
                                </div>
                        <?= so_code_block('<button data-so-tooltip="Copy" data-so-shortcut="Ctrl+C">Copy</button>
<button data-so-tooltip="Paste" data-so-shortcut="Ctrl+V">Paste</button>
<button data-so-tooltip="Save" data-so-shortcut="Ctrl+S">Save</button>
<button data-so-tooltip="Undo" data-so-shortcut="Ctrl+Z">Undo</button>
<button data-so-tooltip="Command Palette" data-so-shortcut="Ctrl+Shift+P">Commands</button>', 'html') ?>

                        <!-- Shortcut-only tooltip -->
                        <h4 class="so-demo-section-heading-spaced">Shortcut Only</h4>
                                                        <div class="so-flex so-gap-3 so-flex-wrap">
                                    <button class="so-btn so-btn-ghost" data-so-shortcut="Escape">
                                        <span class="material-icons" class="so-tooltip-demo-icon">close</span>
                                    </button>
                                    <button class="so-btn so-btn-ghost" data-so-shortcut="Enter">
                                        <span class="material-icons" class="so-tooltip-demo-icon">check</span>
                                    </button>
                                    <button class="so-btn so-btn-ghost" data-so-shortcut="Tab">
                                        <span class="material-icons" class="so-tooltip-demo-icon">keyboard_tab</span>
                                    </button>
                                </div>
                        <?= so_code_block('<!-- Shortcut only (no text) -->
<button data-so-shortcut="Escape">...</button>
<button data-so-shortcut="Enter">...</button>
<button data-so-shortcut="Tab">...</button>', 'html') ?>
                    </div>
                </div>

                <!-- Color Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Color Variants</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Three tooltip styles available: <strong>Solid</strong> (filled background), <strong>Outline</strong> (bordered), and <strong>Soft</strong> (pastel background).
                        </p>

                        <!-- Solid Tooltips -->
                        <h4 class="so-demo-section-heading-spaced">Solid (Filled)</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-primary" data-so-tooltip="Primary tooltip" data-so-tooltip-color="primary">Primary</button>
                            <button class="so-btn so-btn-success" data-so-tooltip="Success tooltip" data-so-tooltip-color="success">Success</button>
                            <button class="so-btn so-btn-danger" data-so-tooltip="Danger tooltip" data-so-tooltip-color="danger">Danger</button>
                            <button class="so-btn so-btn-warning" data-so-tooltip="Warning tooltip" data-so-tooltip-color="warning">Warning</button>
                            <button class="so-btn so-btn-info" data-so-tooltip="Info tooltip" data-so-tooltip-color="info">Info</button>
                            <button class="so-btn so-btn-secondary" data-so-tooltip="Secondary tooltip" data-so-tooltip-color="secondary">Secondary</button>
                        </div>

                        <!-- Outline Tooltips -->
                        <h4 class="so-demo-section-heading-spaced">Outline (Bordered)</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline-primary" data-so-tooltip="Primary outline" data-so-tooltip-color="outline-primary">Primary</button>
                            <button class="so-btn so-btn-outline-success" data-so-tooltip="Success outline" data-so-tooltip-color="outline-success">Success</button>
                            <button class="so-btn so-btn-outline-danger" data-so-tooltip="Danger outline" data-so-tooltip-color="outline-danger">Danger</button>
                            <button class="so-btn so-btn-outline-warning" data-so-tooltip="Warning outline" data-so-tooltip-color="outline-warning">Warning</button>
                            <button class="so-btn so-btn-outline-info" data-so-tooltip="Info outline" data-so-tooltip-color="outline-info">Info</button>
                            <button class="so-btn so-btn-outline-secondary" data-so-tooltip="Secondary outline" data-so-tooltip-color="outline-secondary">Secondary</button>
                        </div>

                        <!-- Soft Tooltips -->
                        <h4 class="so-demo-section-heading-spaced">Soft (Pastel)</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-soft-primary" data-so-tooltip="Primary soft" data-so-tooltip-color="soft-primary">Primary</button>
                            <button class="so-btn so-btn-soft-success" data-so-tooltip="Success soft" data-so-tooltip-color="soft-success">Success</button>
                            <button class="so-btn so-btn-soft-danger" data-so-tooltip="Danger soft" data-so-tooltip-color="soft-danger">Danger</button>
                            <button class="so-btn so-btn-soft-warning" data-so-tooltip="Warning soft" data-so-tooltip-color="soft-warning">Warning</button>
                            <button class="so-btn so-btn-soft-info" data-so-tooltip="Info soft" data-so-tooltip-color="soft-info">Info</button>
                            <button class="so-btn so-btn-soft-secondary" data-so-tooltip="Secondary soft" data-so-tooltip-color="soft-secondary">Secondary</button>
                        </div>

                        <!-- Additional Colors -->
                        <h4 class="so-demo-section-heading-spaced">Additional Options</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap">
                            <button class="so-btn so-btn-outline" data-so-tooltip="Default dark tooltip">Default</button>
                            <button class="so-btn so-btn-light" data-so-tooltip="Light theme tooltip" data-so-tooltip-color="light">Light Theme</button>
                            <button class="so-btn so-btn-dark" data-so-tooltip="Dark tooltip" data-so-tooltip-color="dark">Dark</button>
                        </div>

                        <?= so_code_block('<!-- Solid (filled background) -->
<button data-so-tooltip="Primary" data-so-tooltip-color="primary">Primary</button>
<button data-so-tooltip="Success" data-so-tooltip-color="success">Success</button>
<button data-so-tooltip="Danger" data-so-tooltip-color="danger">Danger</button>
<button data-so-tooltip="Warning" data-so-tooltip-color="warning">Warning</button>
<button data-so-tooltip="Info" data-so-tooltip-color="info">Info</button>

<!-- Outline (bordered) -->
<button data-so-tooltip="Primary" data-so-tooltip-color="outline-primary">Outline</button>
<button data-so-tooltip="Success" data-so-tooltip-color="outline-success">Outline</button>
<button data-so-tooltip="Danger" data-so-tooltip-color="outline-danger">Outline</button>

<!-- Soft (pastel background) -->
<button data-so-tooltip="Primary" data-so-tooltip-color="soft-primary">Soft</button>
<button data-so-tooltip="Success" data-so-tooltip-color="soft-success">Soft</button>
<button data-so-tooltip="Danger" data-so-tooltip-color="soft-danger">Soft</button>

<!-- Other options -->
<button data-so-tooltip="Light theme" data-so-tooltip-color="light">Light</button>
<button data-so-tooltip="Dark theme" data-so-tooltip-color="dark">Dark</button>', 'html') ?>
                    </div>
                </div>

                <!-- Size Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Size Variants</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-flex so-gap-3 so-flex-wrap so-items-center">
                                    <button class="so-btn so-btn-secondary so-btn-sm" data-so-tooltip="Small tooltip" data-so-tooltip-size="sm">Small</button>
                                    <button class="so-btn so-btn-secondary" data-so-tooltip="Default tooltip size">Default</button>
                                    <button class="so-btn so-btn-secondary so-btn-lg" data-so-tooltip="Large tooltip" data-so-tooltip-size="lg">Large</button>
                                </div>
                        <?= so_code_block('<button data-so-tooltip="Small tooltip" data-so-tooltip-size="sm">Small</button>
<button data-so-tooltip="Default tooltip size">Default</button>
<button data-so-tooltip="Large tooltip" data-so-tooltip-size="lg">Large</button>', 'html') ?>
                    </div>
                </div>

                <!-- Light Theme -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Light Theme</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Light themed tooltips that adapt to light/dark mode.
                        </p>
                                                        <div class="so-flex so-gap-3 so-flex-wrap">
                                    <button class="so-btn so-btn-light" data-so-tooltip="Light themed tooltip" data-so-tooltip-theme="light">Light Theme</button>
                                    <button class="so-btn so-btn-light" data-so-tooltip="With shortcut" data-so-shortcut="Ctrl+L" data-so-tooltip-theme="light">Light + Shortcut</button>
                                </div>
                        <?= so_code_block('<button data-so-tooltip="Light themed tooltip" data-so-tooltip-theme="light">Light Theme</button>
<button data-so-tooltip="With shortcut" data-so-shortcut="Ctrl+L" data-so-tooltip-theme="light">Light + Shortcut</button>', 'html') ?>
                    </div>
                </div>

                <!-- Animation Variants -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Animation Variants</h3>
                    </div>
                    <div class="so-card-body">
                                                        <div class="so-flex so-gap-3 so-flex-wrap">
                                    <button class="so-btn so-btn-outline" data-so-tooltip="Fade animation" data-so-tooltip-animation="fade">Fade</button>
                                    <button class="so-btn so-btn-outline" data-so-tooltip="Scale animation (default)" data-so-tooltip-animation="scale">Scale</button>
                                    <button class="so-btn so-btn-outline" data-so-tooltip="Slide animation" data-so-tooltip-animation="slide">Slide</button>
                                </div>
                        <?= so_code_block('<button data-so-tooltip="Fade animation" data-so-tooltip-animation="fade">Fade</button>
<button data-so-tooltip="Scale animation (default)" data-so-tooltip-animation="scale">Scale</button>
<button data-so-tooltip="Slide animation" data-so-tooltip-animation="slide">Slide</button>', 'html') ?>
                    </div>
                </div>

                <!-- HTML Content Tooltips -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">HTML Content Tooltips</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Enable rich HTML content in tooltips using <code>data-so-tooltip-html="true"</code>. Perfect for formatted text, icons, lists, and more.
                        </p>

                        <!-- Basic HTML -->
                        <h4 class="so-demo-section-heading-spaced">Rich Text Formatting</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-primary"
                                data-so-tooltip="<strong>Bold</strong> and <em>italic</em> text"
                                data-so-tooltip-html="true">
                                Bold & Italic
                            </button>
                            <button class="so-btn so-btn-success"
                                data-so-tooltip="Status: <span style='color: #22c55e;'>● Online</span>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="light">
                                With Status
                            </button>
                            <button class="so-btn so-btn-info"
                                data-so-tooltip="<span class='material-icons' style='font-size:14px;vertical-align:middle;margin-right:4px;'>info</span> Helpful information"
                                data-so-tooltip-html="true">
                                With Icon
                            </button>
                        </div>

                        <!-- User Info Card -->
                        <h4 class="so-demo-section-heading-spaced">User Info Card</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline"
                                data-so-tooltip="<div style='display:flex;align-items:center;gap:8px;'><img src='https://ui-avatars.com/api/?name=John+Doe&size=32&background=6366f1&color=fff' style='width:32px;height:32px;border-radius:50%;'><div><div style='font-weight:600;'>John Doe</div><div style='font-size:11px;opacity:0.8;'>Product Designer</div></div></div>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="light"
                                data-so-tooltip-size="lg">
                                <span class="material-icons">person</span>
                                Hover for Profile
                            </button>
                            <button class="so-btn so-btn-outline"
                                data-so-tooltip="<div style='text-align:center;'><div style='font-size:24px;margin-bottom:4px;'>⭐⭐⭐⭐⭐</div><div style='font-weight:600;'>5.0 Rating</div><div style='font-size:11px;opacity:0.8;'>Based on 128 reviews</div></div>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="soft-warning"
                                data-so-tooltip-size="lg">
                                <span class="material-icons">star</span>
                                Rating Info
                            </button>
                        </div>

                        <!-- Feature List -->
                        <h4 class="so-demo-section-heading-spaced">Feature Lists & Details</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-secondary"
                                data-so-tooltip="<div style='text-align:left;'><div style='font-weight:600;margin-bottom:6px;'>Features Included:</div><div style='font-size:12px;'>✓ Unlimited projects<br>✓ Priority support<br>✓ Advanced analytics<br>✓ Custom branding</div></div>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="light"
                                data-so-tooltip-size="lg">
                                <span class="material-icons">checklist</span>
                                Feature List
                            </button>
                            <button class="so-btn so-btn-danger"
                                data-so-tooltip="<div style='text-align:left;'><div style='font-weight:600;margin-bottom:4px;'>⚠️ Warning</div><div style='font-size:12px;'>This action cannot be undone.<br>All data will be permanently deleted.</div></div>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="soft-danger"
                                data-so-tooltip-size="lg">
                                <span class="material-icons">delete</span>
                                Delete Warning
                            </button>
                            <button class="so-btn so-btn-warning"
                                data-so-tooltip="<div style='text-align:left;'><div style='font-weight:600;margin-bottom:4px;'>📦 Package Info</div><div style='font-size:12px;'><strong>Size:</strong> 2.4 MB<br><strong>Version:</strong> 3.2.1<br><strong>License:</strong> MIT</div></div>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="light"
                                data-so-tooltip-size="lg">
                                <span class="material-icons">inventory_2</span>
                                Package Details
                            </button>
                        </div>

                        <!-- Statistics -->
                        <h4 class="so-demo-section-heading-spaced">Statistics & Metrics</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline-success"
                                data-so-tooltip="<div style='text-align:center;'><div style='font-size:20px;font-weight:700;color:#22c55e;'>+24.5%</div><div style='font-size:11px;'>vs last month</div></div>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="soft-success">
                                <span class="material-icons">trending_up</span>
                                Growth Stats
                            </button>
                            <button class="so-btn so-btn-outline-info"
                                data-so-tooltip="<div style='display:flex;gap:12px;'><div style='text-align:center;'><div style='font-size:16px;font-weight:700;'>1.2K</div><div style='font-size:10px;opacity:0.8;'>Views</div></div><div style='text-align:center;'><div style='font-size:16px;font-weight:700;'>348</div><div style='font-size:10px;opacity:0.8;'>Clicks</div></div><div style='text-align:center;'><div style='font-size:16px;font-weight:700;'>29%</div><div style='font-size:10px;opacity:0.8;'>CTR</div></div></div>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="light"
                                data-so-tooltip-size="lg">
                                <span class="material-icons">analytics</span>
                                Quick Stats
                            </button>
                            <button class="so-btn so-btn-outline-primary"
                                data-so-tooltip="<div style='width:120px;'><div style='display:flex;justify-content:space-between;margin-bottom:4px;'><span style='font-size:11px;'>Progress</span><span style='font-size:11px;font-weight:600;'>75%</span></div><div style='height:6px;background:rgba(99,102,241,0.2);border-radius:3px;overflow:hidden;'><div style='width:75%;height:100%;background:#6366f1;border-radius:3px;'></div></div></div>"
                                data-so-tooltip-html="true"
                                data-so-tooltip-color="light"
                                data-so-tooltip-size="lg">
                                <span class="material-icons">donut_large</span>
                                Progress Bar
                            </button>
                        </div>

                        <?= so_code_block('<!-- Basic rich text -->
<button
    data-so-tooltip="<strong>Bold</strong> and <em>italic</em> text"
    data-so-tooltip-html="true">
    Rich Text
</button>

<!-- With icon -->
<button
    data-so-tooltip="<span class=\'material-icons\' style=\'font-size:14px;vertical-align:middle;margin-right:4px;\'>info</span> Helpful info"
    data-so-tooltip-html="true">
    With Icon
</button>

<!-- User profile card -->
<button
    data-so-tooltip="<div style=\'display:flex;align-items:center;gap:8px;\'>
        <img src=\'avatar.jpg\' style=\'width:32px;height:32px;border-radius:50%;\'>
        <div>
            <div style=\'font-weight:600;\'>John Doe</div>
            <div style=\'font-size:11px;opacity:0.8;\'>Product Designer</div>
        </div>
    </div>"
    data-so-tooltip-html="true"
    data-so-tooltip-color="light"
    data-so-tooltip-size="lg">
    User Card
</button>

<!-- Feature list -->
<button
    data-so-tooltip="<div style=\'text-align:left;\'>
        <div style=\'font-weight:600;margin-bottom:6px;\'>Features:</div>
        <div style=\'font-size:12px;\'>
            ✓ Unlimited projects<br>
            ✓ Priority support<br>
            ✓ Advanced analytics
        </div>
    </div>"
    data-so-tooltip-html="true"
    data-so-tooltip-color="light"
    data-so-tooltip-size="lg">
    Features
</button>

<!-- Statistics with mini progress bar -->
<button
    data-so-tooltip="<div style=\'width:120px;\'>
        <div style=\'display:flex;justify-content:space-between;margin-bottom:4px;\'>
            <span style=\'font-size:11px;\'>Progress</span>
            <span style=\'font-size:11px;font-weight:600;\'>75%</span>
        </div>
        <div style=\'height:6px;background:rgba(99,102,241,0.2);border-radius:3px;\'>
            <div style=\'width:75%;height:100%;background:#6366f1;border-radius:3px;\'></div>
        </div>
    </div>"
    data-so-tooltip-html="true"
    data-so-tooltip-color="light"
    data-so-tooltip-size="lg">
    Progress
</button>', 'html') ?>
                    </div>
                </div>

                <!-- JavaScript API -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">JavaScript API</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Use the JavaScript API for programmatic control and temporary feedback tooltips.
                        </p>
                        <div class="so-flex so-gap-3 so-flex-wrap">
                            <button class="so-btn so-btn-primary" id="tooltip-api-demo" onclick="showApiTooltip(this)">
                                <span class="material-icons">mouse</span>
                                Click for Tooltip
                            </button>
                            <button class="so-btn so-btn-success" onclick="showSuccessTooltip(this)">
                                <span class="material-icons">check</span>
                                Show Success
                            </button>
                            <button class="so-btn so-btn-danger" onclick="showErrorTooltip(this)">
                                <span class="material-icons">error</span>
                                Show Error
                            </button>
                        </div>
                        <?= so_code_block('// Get or create tooltip instance
const tooltip = SOTooltip.getInstance(element, {
    content: \'Tooltip text\',
    shortcut: \'Ctrl+S\',
    position: \'top\',
    color: \'primary\',
    size: \'sm\',
    theme: \'light\',
    animation: \'scale\',
    trigger: \'hover\'
});

// Manual show/hide
tooltip.show();
tooltip.hide();
tooltip.toggle();

// Update content dynamically
tooltip.setContent(\'New content\');
tooltip.setShortcut(\'Ctrl+N\');
tooltip.setColor(\'success\');
tooltip.setPosition(\'bottom\');

// Enable/disable
tooltip.enable();
tooltip.disable();

// Show temporary feedback tooltip (auto-hides)
SOTooltip.showTemporary(button, {
    content: \'Copied!\',
    color: \'success\',
    position: \'top\',
    autoHide: 2000
});

// Events
element.addEventListener(\'so:tooltip:show\', (e) => {
    console.log(\'Showing via:\', e.detail.trigger);
    // e.preventDefault(); // Cancel show
});

element.addEventListener(\'so:tooltip:shown\', (e) => {
    console.log(\'Tooltip visible:\', e.detail.tooltipEl);
});

element.addEventListener(\'so:tooltip:hide\', (e) => {
    console.log(\'Hiding via:\', e.detail.trigger);
});

element.addEventListener(\'so:tooltip:hidden\', (e) => {
    console.log(\'Tooltip hidden\');
});', 'javascript') ?>

                    </div>
                </div>

                <!-- Interactive Demo - All Actions -->
                <div class="so-card">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Interactive Demo - All Tooltip Actions</h3>
                    </div>
                    <div class="so-card-body">
                        <p class="so-demo-desc">
                            Try all tooltip methods interactively. The target button shows the tooltip, use the control buttons to manipulate it.
                        </p>

                        <!-- Target Element -->
                        <h4 class="so-demo-section-heading-spaced">Target Element</h4>
                        <div class="so-flex so-gap-3 so-flex-wrap so-items-center so-mb-4">
                            <button class="so-btn so-btn-primary so-btn-lg" id="demo-tooltip-target" data-so-tooltip="Hello! I am a tooltip" data-so-shortcut="Ctrl+T">
                                <span class="material-icons">smart_button</span>
                                Hover or Control Me
                            </button>
                            <span class="so-text-muted">← This button has a tooltip attached</span>
                        </div>

                        <!-- Show/Hide/Toggle -->
                        <h4 class="so-demo-section-heading-spaced">Show / Hide / Toggle</h4>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.show()">
                                <span class="material-icons">visibility</span>
                                show()
                            </button>
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.hide()">
                                <span class="material-icons">visibility_off</span>
                                hide()
                            </button>
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.toggle()">
                                <span class="material-icons">swap_horiz</span>
                                toggle()
                            </button>
                        </div>

                        <!-- Update Content -->
                        <h4 class="so-demo-section-heading-spaced">Update Content Dynamically</h4>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setContent('Content changed!')">
                                <span class="material-icons">edit</span>
                                setContent('Content changed!')
                            </button>
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setContent('Hello! I am a tooltip')">
                                <span class="material-icons">restore</span>
                                Reset Content
                            </button>
                        </div>

                        <!-- Update Shortcut -->
                        <h4 class="so-demo-section-heading-spaced">Update Shortcut</h4>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setShortcut('Ctrl+Shift+T')">
                                <span class="material-icons">keyboard</span>
                                setShortcut('Ctrl+Shift+T')
                            </button>
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setShortcut('Alt+S')">
                                <span class="material-icons">keyboard</span>
                                setShortcut('Alt+S')
                            </button>
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setShortcut('Ctrl+T')">
                                <span class="material-icons">restore</span>
                                Reset Shortcut
                            </button>
                        </div>

                        <!-- Change Position -->
                        <h4 class="so-demo-section-heading-spaced">Change Position</h4>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setPosition('top')">
                                <span class="material-icons">arrow_upward</span>
                                setPosition('top')
                            </button>
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setPosition('bottom')">
                                <span class="material-icons">arrow_downward</span>
                                setPosition('bottom')
                            </button>
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setPosition('left')">
                                <span class="material-icons">arrow_back</span>
                                setPosition('left')
                            </button>
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setPosition('right')">
                                <span class="material-icons">arrow_forward</span>
                                setPosition('right')
                            </button>
                        </div>

                        <!-- Change Color -->
                        <h4 class="so-demo-section-heading-spaced">Change Color</h4>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline" onclick="demoTooltip.setColor('default')">
                                Default
                            </button>
                            <button class="so-btn so-btn-outline-primary" onclick="demoTooltip.setColor('primary')">
                                setColor('primary')
                            </button>
                            <button class="so-btn so-btn-outline-success" onclick="demoTooltip.setColor('success')">
                                setColor('success')
                            </button>
                            <button class="so-btn so-btn-outline-danger" onclick="demoTooltip.setColor('danger')">
                                setColor('danger')
                            </button>
                            <button class="so-btn so-btn-outline-warning" onclick="demoTooltip.setColor('warning')">
                                setColor('warning')
                            </button>
                            <button class="so-btn so-btn-outline-info" onclick="demoTooltip.setColor('info')">
                                setColor('info')
                            </button>
                        </div>

                        <!-- Enable/Disable -->
                        <h4 class="so-demo-section-heading-spaced">Enable / Disable</h4>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-outline-success" onclick="demoTooltip.enable()">
                                <span class="material-icons">check_circle</span>
                                enable()
                            </button>
                            <button class="so-btn so-btn-outline-danger" onclick="demoTooltip.disable()">
                                <span class="material-icons">block</span>
                                disable()
                            </button>
                        </div>

                        <!-- Temporary Tooltips -->
                        <h4 class="so-demo-section-heading-spaced">Temporary Feedback Tooltips</h4>
                        <p class="so-text-muted so-mb-3">Show temporary tooltips that auto-hide (great for feedback messages)</p>
                        <div class="so-flex so-gap-2 so-flex-wrap so-mb-4">
                            <button class="so-btn so-btn-primary" onclick="showTempDefault(this)">
                                <span class="material-icons">info</span>
                                Default (2s)
                            </button>
                            <button class="so-btn so-btn-success" onclick="showTempSuccess(this)">
                                <span class="material-icons">check</span>
                                Success
                            </button>
                            <button class="so-btn so-btn-danger" onclick="showTempDanger(this)">
                                <span class="material-icons">error</span>
                                Error
                            </button>
                            <button class="so-btn so-btn-warning" onclick="showTempWarning(this)">
                                <span class="material-icons">warning</span>
                                Warning
                            </button>
                            <button class="so-btn so-btn-info" onclick="showTempInfo(this)">
                                <span class="material-icons">lightbulb</span>
                                Info
                            </button>
                        </div>

                        <!-- Event Log -->
                        <h4 class="so-demo-section-heading-spaced">Event Log</h4>
                        <p class="so-text-muted so-mb-3">Events fired by the target tooltip (hover over target to see events)</p>
                        <div id="tooltip-event-log" class="so-p-3 so-bg-light so-rounded" style="max-height: 150px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                            <div class="so-text-muted">Waiting for events...</div>
                        </div>
                        <button class="so-btn so-btn-outline so-btn-sm so-mt-2" onclick="clearEventLog()">
                            <span class="material-icons">delete</span>
                            Clear Log
                        </button>

                        <?= so_code_block('// Get tooltip instance
const tooltip = SOTooltip.getInstance(element);

// Show/Hide/Toggle
tooltip.show();
tooltip.hide();
tooltip.toggle();

// Update content dynamically
tooltip.setContent(\'New content\');
tooltip.setShortcut(\'Ctrl+N\');
tooltip.setPosition(\'bottom\');  // top, bottom, left, right
tooltip.setColor(\'success\');    // default, primary, success, danger, warning, info

// Enable/Disable
tooltip.enable();
tooltip.disable();

// Show temporary feedback tooltip
SOTooltip.showTemporary(element, {
    content: \'Saved!\',
    color: \'success\',
    position: \'top\',
    autoHide: 2000  // milliseconds
});

// Listen to events
element.addEventListener(\'so:tooltip:show\', (e) => {});
element.addEventListener(\'so:tooltip:shown\', (e) => {});
element.addEventListener(\'so:tooltip:hide\', (e) => {});
element.addEventListener(\'so:tooltip:hidden\', (e) => {});', 'javascript') ?>

                        <script>
                        // Initialize demo tooltip
                        let demoTooltip;
                        let eventListenersAdded = false;

                        function initDemoTooltip() {
                            const target = document.getElementById('demo-tooltip-target');
                            if (!target) return;

                            // Add event listeners only once
                            if (!eventListenersAdded) {
                                target.addEventListener('so:tooltip:show', (e) => logEvent('so:tooltip:show', 'About to show tooltip'));
                                target.addEventListener('so:tooltip:shown', (e) => logEvent('so:tooltip:shown', 'Tooltip is now visible'));
                                target.addEventListener('so:tooltip:hide', (e) => logEvent('so:tooltip:hide', 'About to hide tooltip'));
                                target.addEventListener('so:tooltip:hidden', (e) => logEvent('so:tooltip:hidden', 'Tooltip is now hidden'));
                                eventListenersAdded = true;
                            }

                            // Initialize tooltip instance when SOTooltip is available
                            if (typeof SOTooltip !== 'undefined' && !demoTooltip) {
                                demoTooltip = SOTooltip.getInstance(target);
                            }
                        }

                        // Initialize when DOM is ready
                        if (document.readyState === 'loading') {
                            document.addEventListener('DOMContentLoaded', initDemoTooltip);
                        } else {
                            initDemoTooltip();
                        }

                        // Also try again after window load (ensures JS bundle is loaded)
                        window.addEventListener('load', initDemoTooltip);

                        function logEvent(eventName, message) {
                            const log = document.getElementById('tooltip-event-log');
                            const time = new Date().toLocaleTimeString();
                            const color = eventName.includes('show') ? '#22c55e' : '#ef4444';
                            log.innerHTML = `<div><span style="color: #666">[${time}]</span> <span style="color: ${color}">${eventName}</span> - ${message}</div>` + log.innerHTML;
                        }

                        function clearEventLog() {
                            document.getElementById('tooltip-event-log').innerHTML = '<div class="so-text-muted">Waiting for events...</div>';
                        }

                        // Temporary tooltip functions
                        function showApiTooltip(btn) {
                            SOTooltip.showTemporary(btn, { content: 'Tooltip shown via API!', position: 'top', autoHide: 2000 });
                        }
                        function showSuccessTooltip(btn) {
                            SOTooltip.showTemporary(btn, { content: 'Success! Action completed.', color: 'success', position: 'top', autoHide: 2000 });
                        }
                        function showErrorTooltip(btn) {
                            SOTooltip.showTemporary(btn, { content: 'Error! Something went wrong.', color: 'danger', position: 'top', autoHide: 2000 });
                        }
                        function showTempDefault(btn) {
                            SOTooltip.showTemporary(btn, { content: 'Default temporary tooltip', position: 'top', autoHide: 2000 });
                        }
                        function showTempSuccess(btn) {
                            SOTooltip.showTemporary(btn, { content: 'Saved successfully!', color: 'success', position: 'top', autoHide: 2000 });
                        }
                        function showTempDanger(btn) {
                            SOTooltip.showTemporary(btn, { content: 'Operation failed!', color: 'danger', position: 'top', autoHide: 2000 });
                        }
                        function showTempWarning(btn) {
                            SOTooltip.showTemporary(btn, { content: 'Please review before continuing', color: 'warning', position: 'top', autoHide: 2000 });
                        }
                        function showTempInfo(btn) {
                            SOTooltip.showTemporary(btn, { content: 'Tip: You can also use keyboard shortcuts', color: 'info', position: 'top', autoHide: 2500 });
                        }
                        </script>
                    </div>
                </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
