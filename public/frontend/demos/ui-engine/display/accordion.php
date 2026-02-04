<?php
/**
 * SixOrbit UI Engine - Accordion Element Demo
 */

$pageTitle = 'Accordion - UI Engine';
$pageDescription = 'Collapsible content panels for organizing information';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Accordion</h1>
            <p class="so-page-subtitle">Collapsible content panels for organizing and presenting information in a compact format.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Accordion -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Accordion</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-accordion so-mb-4" id="demo-accordion" data-so-accordion>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="demo-accordion-header-0">
                            <button class="so-accordion-button" type="button" data-so-toggle="collapse" data-so-target="#demo-one" aria-expanded="true" aria-controls="demo-one">
                                What is UiEngine?
                            </button>
                        </h2>
                        <div id="demo-one" class="so-accordion-collapse so-collapse so-show" aria-labelledby="demo-accordion-header-0" data-so-parent="#demo-accordion">
                            <div class="so-accordion-body">
                                UiEngine is a programmatic UI generation system that provides symmetric PHP and JavaScript APIs for building user interfaces.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="demo-accordion-header-1">
                            <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#demo-two" aria-expanded="false" aria-controls="demo-two">
                                How does it work?
                            </button>
                        </h2>
                        <div id="demo-two" class="so-accordion-collapse so-collapse" aria-labelledby="demo-accordion-header-1" data-so-parent="#demo-accordion">
                            <div class="so-accordion-body">
                                You create elements using a fluent API, configure them with methods, and render them to HTML. The same code patterns work in both PHP and JavaScript.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="demo-accordion-header-2">
                            <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#demo-three" aria-expanded="false" aria-controls="demo-three">
                                Why use it?
                            </button>
                        </h2>
                        <div id="demo-three" class="so-accordion-collapse so-collapse" aria-labelledby="demo-accordion-header-2" data-so-parent="#demo-accordion">
                            <div class="so-accordion-body">
                                UiEngine provides consistency between server and client rendering, reduces boilerplate code, and offers built-in validation integration.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-accordion', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$accordion = UiEngine::accordion('faq')
    ->item('What is UiEngine?', 'UiEngine is a programmatic UI generation system...', true)
    ->item('How does it work?', 'You create elements using a fluent API...')
    ->item('Why use it?', 'UiEngine provides consistency between server and client...');

echo \$accordion->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const accordion = UiEngine.accordion('faq')
    .item('What is UiEngine?', 'UiEngine is a programmatic UI generation system...', true)
    .item('How does it work?', 'You create elements using a fluent API...')
    .item('Why use it?', 'UiEngine provides consistency between server and client...');

document.getElementById('container').innerHTML = accordion.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-accordion" id="faq">
    <div class="so-accordion-item">
        <h2 class="so-accordion-header" id="faq-header-0">
            <button class="so-accordion-button" type="button"
                data-so-toggle="collapse" data-so-target="#faq-collapse-0"
                aria-expanded="true" aria-controls="faq-collapse-0">
                What is UiEngine?
            </button>
        </h2>
        <div id="faq-collapse-0" class="so-accordion-collapse so-collapse so-show"
            aria-labelledby="faq-header-0" data-so-parent="#faq">
            <div class="so-accordion-body">
                UiEngine is a programmatic UI generation system...
            </div>
        </div>
    </div>
    <!-- More items... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Always Open -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Always Open (Multiple Expanded)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <p class="so-text-muted so-mb-3">Click multiple panels - they stay open (no <code>data-so-parent</code> attribute):</p>
                <div class="so-accordion so-mb-4" id="demo-always-open" data-so-accordion>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="open-header-0">
                            <button class="so-accordion-button" type="button" data-so-toggle="collapse" data-so-target="#open-one" aria-expanded="true" aria-controls="open-one">
                                Feature 1
                            </button>
                        </h2>
                        <div id="open-one" class="so-accordion-collapse so-collapse so-show" aria-labelledby="open-header-0">
                            <div class="so-accordion-body">
                                Description of feature 1. Click other panels - this one stays open!
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="open-header-1">
                            <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#open-two" aria-expanded="false" aria-controls="open-two">
                                Feature 2
                            </button>
                        </h2>
                        <div id="open-two" class="so-accordion-collapse so-collapse" aria-labelledby="open-header-1">
                            <div class="so-accordion-body">
                                Description of feature 2. Multiple panels can be open simultaneously.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="open-header-2">
                            <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#open-three" aria-expanded="false" aria-controls="open-three">
                                Feature 3
                            </button>
                        </h2>
                        <div id="open-three" class="so-accordion-collapse so-collapse" aria-labelledby="open-header-2">
                            <div class="so-accordion-body">
                                Description of feature 3.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('accordion-open', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// alwaysOpen() allows multiple panels to stay open when clicked
// Note: Only one panel can be initially expanded via item()
\$accordion = UiEngine::accordion('features')
    ->alwaysOpen()
    ->item('Feature 1', 'Description of feature 1', true)  // Initially open
    ->item('Feature 2', 'Description of feature 2')
    ->item('Feature 3', 'Description of feature 3');

echo \$accordion->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// alwaysOpen() allows multiple panels to stay open when clicked
const accordion = UiEngine.accordion('features')
    .alwaysOpen()
    .item('Feature 1', 'Description of feature 1', true)
    .item('Feature 2', 'Description of feature 2')
    .item('Feature 3', 'Description of feature 3');

document.getElementById('container').innerHTML = accordion.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- No data-so-parent attribute allows multiple open -->
<div class="so-accordion" id="features" data-so-accordion>
    <div class="so-accordion-item">
        <h2 class="so-accordion-header">
            <button class="so-accordion-button" data-so-toggle="collapse"
                data-so-target="#features-0" aria-expanded="true">
                Feature 1
            </button>
        </h2>
        <div id="features-0" class="so-accordion-collapse so-collapse so-show">
            <div class="so-accordion-body">Description of feature 1</div>
        </div>
    </div>
    <!-- More items without data-so-parent... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Icons (Custom HTML)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Icons require custom HTML since <code>item()</code> escapes the title:</p>
                <!-- Live Demo -->
                <div class="so-accordion so-mb-4" id="demo-icons" data-so-accordion>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="icon-header-0">
                            <button class="so-accordion-button" type="button" data-so-toggle="collapse" data-so-target="#icon-one" aria-expanded="true" aria-controls="icon-one">
                                <span class="material-icons so-me-2">person</span> Account Settings
                            </button>
                        </h2>
                        <div id="icon-one" class="so-accordion-collapse so-collapse so-show" aria-labelledby="icon-header-0" data-so-parent="#demo-icons">
                            <div class="so-accordion-body">
                                Manage your account preferences, profile information, and security settings.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="icon-header-1">
                            <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#icon-two" aria-expanded="false" aria-controls="icon-two">
                                <span class="material-icons so-me-2">lock</span> Privacy Settings
                            </button>
                        </h2>
                        <div id="icon-two" class="so-accordion-collapse so-collapse" aria-labelledby="icon-header-1" data-so-parent="#demo-icons">
                            <div class="so-accordion-body">
                                Control your privacy preferences and data sharing options.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="icon-header-2">
                            <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#icon-three" aria-expanded="false" aria-controls="icon-three">
                                <span class="material-icons so-me-2">notifications</span> Notifications
                            </button>
                        </h2>
                        <div id="icon-three" class="so-accordion-collapse so-collapse" aria-labelledby="icon-header-2" data-so-parent="#demo-icons">
                            <div class="so-accordion-body">
                                Configure how and when you receive notifications.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('accordion-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Icons can be included in the title using HTML
// The title is escaped, so use raw HTML approach for icons
\$accordion = UiEngine::accordion('settings');

// For icons, build items with HTML directly or extend the class
// The default item() method escapes title text
echo '<div class=\"so-accordion\" id=\"settings\">';

// Item with icon in title (manual approach)
echo '<div class=\"so-accordion-item\">';
echo '<h2 class=\"so-accordion-header\">';
echo '<button class=\"so-accordion-button\" data-so-toggle=\"collapse\" data-so-target=\"#settings-1\">';
echo '<span class=\"material-icons so-me-2\">person</span> Account Settings';
echo '</button></h2>';
echo '<div id=\"settings-1\" class=\"so-accordion-collapse so-collapse so-show\" data-so-parent=\"#settings\">';
echo '<div class=\"so-accordion-body\">Manage your account...</div>';
echo '</div></div>';

echo '</div>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Icons require custom HTML since item() escapes the title
// Build accordion structure manually for icon support

const html = `
<div class=\"so-accordion\" id=\"settings\" data-so-accordion>
    <div class=\"so-accordion-item\">
        <h2 class=\"so-accordion-header\">
            <button class=\"so-accordion-button\" data-so-toggle=\"collapse\" data-so-target=\"#settings-1\">
                <span class=\"material-icons so-me-2\">person</span> Account Settings
            </button>
        </h2>
        <div id=\"settings-1\" class=\"so-accordion-collapse so-show\" data-so-parent=\"#settings\">
            <div class=\"so-accordion-body\">Manage your account...</div>
        </div>
    </div>
</div>`;

document.getElementById('container').innerHTML = html;"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-accordion" id="settings" data-so-accordion>
    <div class="so-accordion-item">
        <h2 class="so-accordion-header">
            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#settings-1">
                <span class="material-icons so-me-2">person</span> Account Settings
            </button>
        </h2>
        <div id="settings-1" class="so-accordion-collapse so-collapse so-show" data-so-parent="#settings">
            <div class="so-accordion-body">Manage your account...</div>
        </div>
    </div>
    <div class="so-accordion-item">
        <h2 class="so-accordion-header">
            <button class="so-accordion-button so-collapsed" data-so-toggle="collapse" data-so-target="#settings-2">
                <span class="material-icons so-me-2">lock</span> Privacy Settings
            </button>
        </h2>
        <div id="settings-2" class="so-accordion-collapse so-collapse" data-so-parent="#settings">
            <div class="so-accordion-body">Control your privacy...</div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Flush Style -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Flush Style (Borderless)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-accordion so-accordion-flush so-mb-4" id="demo-flush" data-so-accordion>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="flush-header-0">
                            <button class="so-accordion-button" type="button" data-so-toggle="collapse" data-so-target="#flush-one" aria-expanded="true" aria-controls="flush-one">
                                Section 1
                            </button>
                        </h2>
                        <div id="flush-one" class="so-accordion-collapse so-collapse so-show" aria-labelledby="flush-header-0" data-so-parent="#demo-flush">
                            <div class="so-accordion-body">
                                Content for section 1. The flush style removes borders and rounded corners for a cleaner look.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="flush-header-1">
                            <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#flush-two" aria-expanded="false" aria-controls="flush-two">
                                Section 2
                            </button>
                        </h2>
                        <div id="flush-two" class="so-accordion-collapse so-collapse" aria-labelledby="flush-header-1" data-so-parent="#demo-flush">
                            <div class="so-accordion-body">
                                Content for section 2.
                            </div>
                        </div>
                    </div>
                    <div class="so-accordion-item">
                        <h2 class="so-accordion-header" id="flush-header-2">
                            <button class="so-accordion-button so-collapsed" type="button" data-so-toggle="collapse" data-so-target="#flush-three" aria-expanded="false" aria-controls="flush-three">
                                Section 3
                            </button>
                        </h2>
                        <div id="flush-three" class="so-accordion-collapse so-collapse" aria-labelledby="flush-header-2" data-so-parent="#demo-flush">
                            <div class="so-accordion-body">
                                Content for section 3.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('accordion-flush', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$accordion = UiEngine::accordion('flush-demo')
    ->flush()  // Remove borders and rounded corners
    ->item('Section 1', 'Content for section 1')
    ->item('Section 2', 'Content for section 2')
    ->item('Section 3', 'Content for section 3');

echo \$accordion->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const accordion = UiEngine.accordion('flush-demo')
    .flush()
    .item('Section 1', 'Content for section 1')
    .item('Section 2', 'Content for section 2')
    .item('Section 3', 'Content for section 3');

document.getElementById('container').innerHTML = accordion.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- so-accordion-flush removes borders and rounded corners -->
<div class="so-accordion so-accordion-flush" id="flush-demo" data-so-accordion>
    <div class="so-accordion-item">
        <h2 class="so-accordion-header">
            <button class="so-accordion-button" data-so-toggle="collapse" data-so-target="#flush-1">
                Section 1
            </button>
        </h2>
        <div id="flush-1" class="so-accordion-collapse so-collapse so-show" data-so-parent="#flush-demo">
            <div class="so-accordion-body">Content for section 1</div>
        </div>
    </div>
    <!-- More items... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <?= so_tabs('accordion-api-tabs', [
                    [
                        'id' => 'configuration-methods',
                        'label' => 'Configuration Methods',
                        'icon' => 'settings',
                        'active' => true,
                        'content' => '<div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>item()</code></td>
                                        <td><code>string $title, string|Element $content, bool $open = false</code></td>
                                        <td>Add an accordion item (title is escaped)</td>
                                    </tr>
                                    <tr>
                                        <td><code>activeItem()</code></td>
                                        <td><code>int $index</code></td>
                                        <td>Set which item is expanded (0-based index)</td>
                                    </tr>
                                    <tr>
                                        <td><code>collapsed()</code></td>
                                        <td>-</td>
                                        <td>Start with all panels collapsed</td>
                                    </tr>
                                    <tr>
                                        <td><code>alwaysOpen()</code></td>
                                        <td><code>bool $alwaysOpen = true</code></td>
                                        <td>Allow multiple panels to stay open</td>
                                    </tr>
                                    <tr>
                                        <td><code>flush()</code></td>
                                        <td><code>bool $flush = true</code></td>
                                        <td>Remove borders and rounded corners</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>'
                    ],
                    [
                        'id' => 'interactivity-methods',
                        'label' => 'Interactivity Methods',
                        'icon' => 'touch_app',
                        'content' => '<p class="so-text-muted so-mb-3">These methods are available in JavaScript for runtime manipulation:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Returns</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>expand()</code></td>
                                        <td><code>index: number</code></td>
                                        <td><code>this</code></td>
                                        <td>Expand item by index</td>
                                    </tr>
                                    <tr>
                                        <td><code>collapse()</code></td>
                                        <td><code>index: number</code></td>
                                        <td><code>this</code></td>
                                        <td>Collapse item by index</td>
                                    </tr>
                                    <tr>
                                        <td><code>toggle()</code></td>
                                        <td><code>index: number</code></td>
                                        <td><code>this</code></td>
                                        <td>Toggle item expand/collapse state</td>
                                    </tr>
                                    <tr>
                                        <td><code>expandAll()</code></td>
                                        <td>-</td>
                                        <td><code>this</code></td>
                                        <td>Expand all items</td>
                                    </tr>
                                    <tr>
                                        <td><code>collapseAll()</code></td>
                                        <td>-</td>
                                        <td><code>this</code></td>
                                        <td>Collapse all items</td>
                                    </tr>
                                    <tr>
                                        <td><code>isExpanded()</code></td>
                                        <td><code>index: number</code></td>
                                        <td><code>boolean</code></td>
                                        <td>Check if item is expanded</td>
                                    </tr>
                                    <tr>
                                        <td><code>getItemCount()</code></td>
                                        <td>-</td>
                                        <td><code>number</code></td>
                                        <td>Get total number of items</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        ' . so_code_tabs('accordion-interactivity', [
                            [
                                'label' => 'JavaScript',
                                'language' => 'javascript',
                                'icon' => 'javascript',
                                'code' => "// Create accordion and render
const accordion = UiEngine.accordion('faq')
    .item('Question 1', 'Answer 1')
    .item('Question 2', 'Answer 2')
    .item('Question 3', 'Answer 3');

document.getElementById('container').appendChild(accordion.render());

// Runtime manipulation
accordion.expand(1);           // Expand second item
accordion.collapse(0);         // Collapse first item
accordion.toggle(2);           // Toggle third item

// Check state
if (accordion.isExpanded(1)) {
    console.log('Item 2 is expanded');
}

// Expand/collapse all
accordion.expandAll();
accordion.collapseAll();"
                            ],
                        ])
                    ],
                    [
                        'id' => 'events',
                        'label' => 'Events',
                        'icon' => 'event',
                        'content' => '<p class="so-text-muted so-mb-3">Accordion dispatches custom events with the <code>so:</code> prefix:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>Detail Properties</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so:accordion:show</code></td>
                                        <td><code>{ index, collapseEl }</code></td>
                                        <td>Fired before an item starts expanding (cancelable)</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:accordion:shown</code></td>
                                        <td><code>{ index, collapseEl }</code></td>
                                        <td>Fired after an item has expanded</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:accordion:hide</code></td>
                                        <td><code>{ index, collapseEl }</code></td>
                                        <td>Fired before an item starts collapsing (cancelable)</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:accordion:hidden</code></td>
                                        <td><code>{ index, collapseEl }</code></td>
                                        <td>Fired after an item has collapsed</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Event Listener Methods (JS)</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>onShow()</code></td>
                                        <td><code>callback: Function</code></td>
                                        <td>Listen to show events</td>
                                    </tr>
                                    <tr>
                                        <td><code>onShown()</code></td>
                                        <td><code>callback: Function</code></td>
                                        <td>Listen to shown events</td>
                                    </tr>
                                    <tr>
                                        <td><code>onHide()</code></td>
                                        <td><code>callback: Function</code></td>
                                        <td>Listen to hide events</td>
                                    </tr>
                                    <tr>
                                        <td><code>onHidden()</code></td>
                                        <td><code>callback: Function</code></td>
                                        <td>Listen to hidden events</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        ' . so_code_tabs('accordion-events', [
                            [
                                'label' => 'JavaScript',
                                'language' => 'javascript',
                                'icon' => 'javascript',
                                'code' => "const accordion = UiEngine.accordion('faq')
    .item('Section 1', 'Content 1')
    .item('Section 2', 'Content 2')
    .onShow((e) => {
        console.log('About to show item', e.detail.index);
        // Return false or call e.preventDefault() to cancel
    })
    .onShown((e) => {
        console.log('Item shown:', e.detail.index);
    })
    .onHide((e) => {
        console.log('About to hide item', e.detail.index);
    })
    .onHidden((e) => {
        console.log('Item hidden:', e.detail.index);
    });

// Or listen via standard addEventListener
accordion.element.addEventListener('so:accordion:show', (e) => {
    console.log('Show event:', e.detail);
});"
                            ],
                        ])
                    ]
                ]) ?>
            </div>
        </div>

        <!-- DOM Structure Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">DOM Structure Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">The accordion generates the following HTML structure:</p>
                <?= so_code_tabs('accordion-dom', [
                    [
                        'label' => 'HTML Structure',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-accordion" id="myAccordion" data-so-accordion>
    <div class="so-accordion-item">
        <h2 class="so-accordion-header" id="myAccordion-header-0">
            <button class="so-accordion-button" type="button"
                data-so-toggle="collapse"
                data-so-target="#myAccordion-collapse-0"
                aria-expanded="true"
                aria-controls="myAccordion-collapse-0">
                Item Title
            </button>
        </h2>
        <div id="myAccordion-collapse-0"
            class="so-accordion-collapse so-collapse so-show"
            aria-labelledby="myAccordion-header-0"
            data-so-parent="#myAccordion">
            <div class="so-accordion-body">
                Item content...
            </div>
        </div>
    </div>
    <!-- More items... -->
</div>'
                    ],
                    [
                        'label' => 'CSS Classes',
                        'language' => 'text',
                        'icon' => 'style',
                        'code' => 'so-accordion           - Main container
so-accordion-flush     - Removes borders (optional)
so-accordion-item      - Individual item wrapper
so-accordion-header    - Header wrapper (h2)
so-accordion-button    - Clickable toggle button
so-accordion-collapse  - Collapsible content wrapper
so-collapse            - Collapse state class
so-show                - Visible/expanded state
so-collapsed           - Button collapsed state
so-accordion-body      - Content container'
                    ],
                    [
                        'label' => 'Data Attributes',
                        'language' => 'text',
                        'icon' => 'data_object',
                        'code' => 'data-so-accordion    - Root element marker for JS init
data-so-toggle       - Toggle action ("collapse")
data-so-target       - Target collapse element ID
data-so-parent       - Parent accordion ID (for single-open mode)'
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</main>

<script>
// SOAccordion Class for handling accordion interactions
class SOAccordion {
    static init() {
        document.querySelectorAll('[data-so-accordion]').forEach(accordion => {
            accordion.querySelectorAll('[data-so-toggle="collapse"]').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(button.dataset.soTarget);
                    if (target) {
                        SOAccordion.toggle(target);
                    }
                });
            });
        });
    }

    static toggle(element) {
        if (element.classList.contains('so-show')) {
            SOAccordion.hide(element);
        } else {
            SOAccordion.show(element);
        }
    }

    static show(element) {
        const parent = element.dataset.soParent ? document.querySelector(element.dataset.soParent) : null;
        const button = document.querySelector(`[data-so-target="#${element.id}"]`);

        // Close siblings if parent exists
        if (parent) {
            parent.querySelectorAll('.so-accordion-collapse.so-show').forEach(sibling => {
                if (sibling !== element) {
                    SOAccordion.hide(sibling);
                }
            });
        }

        // Show element
        element.classList.add('so-collapsing');
        element.classList.remove('so-show');
        element.style.display = 'block';
        const height = element.scrollHeight;
        element.style.height = '0px';

        // Force reflow
        element.offsetHeight;

        element.style.height = height + 'px';

        if (button) {
            button.classList.remove('so-collapsed');
            button.setAttribute('aria-expanded', 'true');
        }

        setTimeout(() => {
            element.classList.remove('so-collapsing');
            element.classList.add('so-show');
            element.style.height = '';
        }, 350);
    }

    static hide(element) {
        const button = document.querySelector(`[data-so-target="#${element.id}"]`);

        element.style.height = element.scrollHeight + 'px';
        element.offsetHeight; // Force reflow
        element.classList.add('so-collapsing');
        element.classList.remove('so-show');
        element.style.height = '0px';

        if (button) {
            button.classList.add('so-collapsed');
            button.setAttribute('aria-expanded', 'false');
        }

        setTimeout(() => {
            element.classList.remove('so-collapsing');
            element.style.display = '';
            element.style.height = '';
        }, 350);
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    SOAccordion.init();
});
</script>

<?php require_once '../../includes/footer.php'; ?>
