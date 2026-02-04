<?php
/**
 * SixOrbit UI Engine - List Group Element Demo
 *
 * Comprehensive demonstration of the ListGroup element with:
 * - Basic usage examples
 * - UiEngine PHP and JavaScript API
 * - Complete API reference
 * - Validation patterns
 * - Error handling
 * - Configuration passing
 */

$pageTitle = 'List Group - UI Engine';
$pageDescription = 'Flexible list component for content display';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">List Group</h1>
            <p class="so-page-subtitle">Flexible component for displaying a series of content with optional actions, badges, and icons.</p>
        </div>
    </div>

    <div class="so-page-body">

        <!-- Quick Links -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Quick Navigation</h3>
            </div>
            <div class="so-card-body">
                <div class="so-d-flex so-flex-wrap so-gap-2">
                    <a href="#basic" class="so-btn so-btn-sm so-btn-outline-primary">Basic Usage</a>
                    <a href="#uiengine" class="so-btn so-btn-sm so-btn-outline-primary">UiEngine API</a>
                    <a href="#api-reference" class="so-btn so-btn-sm so-btn-outline-primary">API Reference</a>
                    <a href="#validation" class="so-btn so-btn-sm so-btn-outline-primary">Validation</a>
                    <a href="#error-handling" class="so-btn so-btn-sm so-btn-outline-primary">Error Handling</a>
                    <a href="#demo-link" class="so-btn so-btn-sm so-btn-success">Full CSS Demo</a>
                </div>
            </div>
        </div>

        <!-- Basic List Group -->
        <div class="so-card so-mb-4" id="basic">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic List Group</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">A simple list group with static items.</p>

                <!-- Live Demo -->
                <ul class="so-list-group so-mb-4" style="max-width:400px;">
                    <li class="so-list-group-item">First item</li>
                    <li class="so-list-group-item">Second item</li>
                    <li class="so-list-group-item">Third item</li>
                    <li class="so-list-group-item">Fourth item</li>
                </ul>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-list', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Create basic list group
\$list = UiEngine::listGroup()
    ->item('First item')
    ->item('Second item')
    ->item('Third item')
    ->item('Fourth item');

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { UiEngine } from './ui-engine/UiEngine.js';

// Create basic list group
const list = UiEngine.listGroup()
    .item('First item')
    .item('Second item')
    .item('Third item')
    .item('Fourth item');

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ul class="so-list-group">
    <li class="so-list-group-item" data-so-index="0">First item</li>
    <li class="so-list-group-item" data-so-index="1">Second item</li>
    <li class="so-list-group-item" data-so-index="2">Third item</li>
    <li class="so-list-group-item" data-so-index="3">Fourth item</li>
</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Active and Disabled States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Active and Disabled States</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Items can be marked as active or disabled to indicate their state.</p>

                <!-- Live Demo -->
                <ul class="so-list-group so-mb-4" style="max-width:400px;">
                    <li class="so-list-group-item so-active">Active item</li>
                    <li class="so-list-group-item">Regular item</li>
                    <li class="so-list-group-item so-disabled">Disabled item</li>
                    <li class="so-list-group-item">Another item</li>
                </ul>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$list = UiEngine::listGroup()
    ->item('Active item', ['active' => true])
    ->item('Regular item')
    ->item('Disabled item', ['disabled' => true])
    ->item('Another item');

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const list = UiEngine.listGroup()
    .item('Active item', {active: true})
    .item('Regular item')
    .item('Disabled item', {disabled: true})
    .item('Another item');

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ul class="so-list-group">
    <li class="so-list-group-item so-active" aria-current="true" data-so-index="0">Active item</li>
    <li class="so-list-group-item" data-so-index="1">Regular item</li>
    <li class="so-list-group-item disabled" aria-disabled="true" data-so-index="2">Disabled item</li>
    <li class="so-list-group-item" data-so-index="3">Another item</li>
</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Actionable Items (Links) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Actionable Items (Links/Buttons)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Items with URLs automatically render as links with hover states.</p>

                <!-- Live Demo -->
                <div class="so-list-group so-mb-4" style="max-width:400px;">
                    <a href="#" class="so-list-group-item so-list-group-item-action so-active">
                        Active link item
                    </a>
                    <a href="#" class="so-list-group-item so-list-group-item-action">
                        Link item
                    </a>
                    <a href="#" class="so-list-group-item so-list-group-item-action">
                        Another link
                    </a>
                    <a href="#" class="so-list-group-item so-list-group-item-action so-disabled">
                        Disabled link
                    </a>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-links', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$list = UiEngine::listGroup()
    ->item('Active link item', ['url' => '#', 'active' => true])
    ->item('Link item', ['url' => '/page'])
    ->item('Another link', ['url' => '/another'])
    ->item('Disabled link', ['url' => '#', 'disabled' => true]);

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const list = UiEngine.listGroup()
    .item('Active link item', {url: '#', active: true})
    .item('Link item', {url: '/page'})
    .item('Another link', {url: '/another'})
    .item('Disabled link', {url: '#', disabled: true});

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ul class="so-list-group">
    <a href="#" class="so-list-group-item so-list-group-item-action so-active" aria-current="true" data-so-index="0">
        Active link item
    </a>
    <a href="/page" class="so-list-group-item so-list-group-item-action" data-so-index="1">
        Link item
    </a>
    <a href="#" class="so-list-group-item so-list-group-item-action disabled" aria-disabled="true" tabindex="-1" data-so-index="3">
        Disabled link
    </a>
</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Badges -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Badges</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add badges to display counts or notifications.</p>

                <!-- Live Demo -->
                <ul class="so-list-group so-mb-4" style="max-width:400px;">
                    <li class="so-list-group-item so-d-flex so-justify-content-between so-align-items-center">
                        <span>Inbox</span>
                        <span class="so-badge so-badge-primary so-badge-pill">14</span>
                    </li>
                    <li class="so-list-group-item so-d-flex so-justify-content-between so-align-items-center">
                        <span>Drafts</span>
                        <span class="so-badge so-badge-secondary so-badge-pill">3</span>
                    </li>
                    <li class="so-list-group-item so-d-flex so-justify-content-between so-align-items-center">
                        <span>Sent</span>
                        <span class="so-badge so-badge-success so-badge-pill">99+</span>
                    </li>
                </ul>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-badges', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$list = UiEngine::listGroup()
    ->item('Inbox', ['badge' => 14, 'badgeVariant' => 'primary'])
    ->item('Drafts', ['badge' => 3, 'badgeVariant' => 'secondary'])
    ->item('Sent', ['badge' => '99+', 'badgeVariant' => 'success']);

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const list = UiEngine.listGroup()
    .item('Inbox', {badge: 14, badgeVariant: 'primary'})
    .item('Drafts', {badge: 3, badgeVariant: 'secondary'})
    .item('Sent', {badge: '99+', badgeVariant: 'success'});

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ul class="so-list-group">
    <li class="so-list-group-item" data-so-index="0">
        <div class="so-d-flex so-justify-content-between so-align-items-center">
            <span>Inbox</span>
            <span class="so-badge so-badge-primary so-badge-pill">14</span>
        </div>
    </li>
</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Icons</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add Material Icons to enhance visual clarity.</p>

                <!-- Live Demo -->
                <div class="so-list-group so-mb-4" style="max-width:400px;">
                    <a href="#" class="so-list-group-item so-list-group-item-action so-d-flex so-align-items-center">
                        <span class="material-icons so-me-3 so-text-primary">home</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="so-list-group-item so-list-group-item-action so-d-flex so-align-items-center">
                        <span class="material-icons so-me-3 so-text-primary">person</span>
                        <span>Profile</span>
                    </a>
                    <a href="#" class="so-list-group-item so-list-group-item-action so-d-flex so-align-items-center">
                        <span class="material-icons so-me-3 so-text-primary">settings</span>
                        <span>Settings</span>
                    </a>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$list = UiEngine::listGroup()
    ->item('Dashboard', ['icon' => 'home', 'url' => '/dashboard'])
    ->item('Profile', ['icon' => 'person', 'url' => '/profile'])
    ->item('Settings', ['icon' => 'settings', 'url' => '/settings']);

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const list = UiEngine.listGroup()
    .item('Dashboard', {icon: 'home', url: '/dashboard'})
    .item('Profile', {icon: 'person', url: '/profile'})
    .item('Settings', {icon: 'settings', url: '/settings'});

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ul class="so-list-group">
    <a href="/dashboard" class="so-list-group-item so-list-group-item-action" data-so-index="0">
        <div class="so-d-flex so-justify-content-between so-align-items-center">
            <div class="so-d-flex so-align-items-center">
                <span class="material-icons so-me-3 so-text-primary">home</span>
                <span>Dashboard</span>
            </div>
        </div>
    </a>
</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Flush Style -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Flush Style (No Borders)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Remove borders and rounded corners for seamless integration.</p>

                <!-- Live Demo -->
                <ul class="so-list-group so-list-group-flush so-mb-4" style="max-width:400px;">
                    <li class="so-list-group-item">First item</li>
                    <li class="so-list-group-item">Second item</li>
                    <li class="so-list-group-item">Third item</li>
                </ul>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-flush', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$list = UiEngine::listGroup()
    ->flush()  // Remove borders and rounded corners
    ->item('First item')
    ->item('Second item')
    ->item('Third item');

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const list = UiEngine.listGroup()
    .flush()
    .item('First item')
    .item('Second item')
    .item('Third item');

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ul class="so-list-group so-list-group-flush">
    <li class="so-list-group-item" data-so-index="0">First item</li>
    <li class="so-list-group-item" data-so-index="1">Second item</li>
    <li class="so-list-group-item" data-so-index="2">Third item</li>
</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Numbered List -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Numbered List</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Automatically numbered items for sequential content.</p>

                <!-- Live Demo -->
                <ol class="so-list-group so-list-group-numbered so-mb-4" style="max-width:400px;">
                    <li class="so-list-group-item">Install the package</li>
                    <li class="so-list-group-item">Import the styles</li>
                    <li class="so-list-group-item">Configure settings</li>
                </ol>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-numbered', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$list = UiEngine::listGroup()
    ->numbered()  // Automatically numbered
    ->item('Install the package')
    ->item('Import the styles')
    ->item('Configure settings');

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const list = UiEngine.listGroup()
    .numbered()
    .item('Install the package')
    .item('Import the styles')
    .item('Configure settings');

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ol class="so-list-group so-list-group-numbered">
    <li class="so-list-group-item" data-so-index="0">Install the package</li>
    <li class="so-list-group-item" data-so-index="1">Import the styles</li>
    <li class="so-list-group-item" data-so-index="2">Configure settings</li>
</ol>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Horizontal Layout -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Horizontal Layout</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display items horizontally, with responsive breakpoint support.</p>

                <!-- Live Demo -->
                <ul class="so-list-group so-list-group-horizontal so-mb-4">
                    <li class="so-list-group-item">First</li>
                    <li class="so-list-group-item">Second</li>
                    <li class="so-list-group-item">Third</li>
                </ul>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-horizontal', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Always horizontal
\$list = UiEngine::listGroup()
    ->horizontal()
    ->item('First')
    ->item('Second')
    ->item('Third');

// Horizontal on medium screens and up
\$list = UiEngine::listGroup()
    ->horizontal('md')  // sm, md, lg, xl
    ->item('First')
    ->item('Second')
    ->item('Third');

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Always horizontal
const list = UiEngine.listGroup()
    .horizontal()
    .item('First')
    .item('Second')
    .item('Third');

// Horizontal on medium screens and up
const list = UiEngine.listGroup()
    .horizontal('md')
    .item('First')
    .item('Second')
    .item('Third');

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Always horizontal -->
<ul class="so-list-group so-list-group-horizontal">
    <li class="so-list-group-item" data-so-index="0">First</li>
    <li class="so-list-group-item" data-so-index="1">Second</li>
    <li class="so-list-group-item" data-so-index="2">Third</li>
</ul>

<!-- Responsive horizontal -->
<ul class="so-list-group so-list-group-horizontal-md">...</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Small and large size options.</p>

                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-6">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Small</label>
                        <ul class="so-list-group so-list-group-sm">
                            <li class="so-list-group-item">Small item 1</li>
                            <li class="so-list-group-item">Small item 2</li>
                        </ul>
                    </div>
                    <div class="so-col-md-6">
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Large</label>
                        <ul class="so-list-group so-list-group-lg">
                            <li class="so-list-group-item">Large item 1</li>
                            <li class="so-list-group-item">Large item 2</li>
                        </ul>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small size
\$list = UiEngine::listGroup()
    ->small()  // or ->size('sm')
    ->item('Small item 1')
    ->item('Small item 2');

// Large size
\$list = UiEngine::listGroup()
    ->large()  // or ->size('lg')
    ->item('Large item 1')
    ->item('Large item 2');

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small size
const list = UiEngine.listGroup()
    .small()
    .item('Small item 1')
    .item('Small item 2');

// Large size
const list = UiEngine.listGroup()
    .large()
    .item('Large item 1')
    .item('Large item 2');

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ul class="so-list-group so-list-group-sm">
    <li class="so-list-group-item" data-so-index="0">Small item 1</li>
</ul>

<ul class="so-list-group so-list-group-lg">
    <li class="so-list-group-item" data-so-index="0">Large item 1</li>
</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Contextual Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Contextual Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Apply contextual colors to individual items.</p>

                <!-- Live Demo -->
                <ul class="so-list-group so-mb-4" style="max-width:400px;">
                    <li class="so-list-group-item so-list-group-item-primary">Primary item</li>
                    <li class="so-list-group-item so-list-group-item-success">Success item</li>
                    <li class="so-list-group-item so-list-group-item-danger">Danger item</li>
                    <li class="so-list-group-item so-list-group-item-warning">Warning item</li>
                    <li class="so-list-group-item so-list-group-item-info">Info item</li>
                </ul>

                <!-- Code Tabs -->
                <?= so_code_tabs('list-variants', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$list = UiEngine::listGroup()
    ->item('Primary item', ['variant' => 'primary'])
    ->item('Success item', ['variant' => 'success'])
    ->item('Danger item', ['variant' => 'danger'])
    ->item('Warning item', ['variant' => 'warning'])
    ->item('Info item', ['variant' => 'info']);

echo \$list;"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const list = UiEngine.listGroup()
    .item('Primary item', {variant: 'primary'})
    .item('Success item', {variant: 'success'})
    .item('Danger item', {variant: 'danger'})
    .item('Warning item', {variant: 'warning'})
    .item('Info item', {variant: 'info'});

document.getElementById('container').innerHTML = list.render();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<ul class="so-list-group">
    <li class="so-list-group-item so-list-group-item-primary" data-so-index="0">Primary item</li>
    <li class="so-list-group-item so-list-group-item-success" data-so-index="1">Success item</li>
    <li class="so-list-group-item so-list-group-item-danger" data-so-index="2">Danger item</li>
</ul>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- UiEngine Usage -->
        <div class="so-card so-mb-4" id="uiengine">
            <div class="so-card-header">
                <h3 class="so-card-title">UiEngine Usage</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    The UiEngine provides identical PHP and JavaScript APIs for server-side and client-side rendering.
                </p>

                <?php
                $phpContent = so_code_block('<?php
use Core\UiEngine\UiEngine;

// Basic list
$list = UiEngine::listGroup()
    ->item(\'Home\')
    ->item(\'About\')
    ->item(\'Contact\');

echo $list;

// Advanced list with all features
$menu = UiEngine::listGroup()
    ->flush()
    ->small()
    ->item(\'Dashboard\', [
        \'icon\' => \'home\',
        \'url\' => \'/dashboard\',
        \'badge\' => 5,
        \'badgeVariant\' => \'primary\',
        \'active\' => true
    ])
    ->item(\'Messages\', [
        \'icon\' => \'mail\',
        \'url\' => \'/messages\',
        \'badge\' => 12,
        \'badgeVariant\' => \'danger\'
    ])
    ->item(\'Settings\', [
        \'icon\' => \'settings\',
        \'url\' => \'/settings\'
    ]);

echo $menu;

// Dynamic item management
$list->updateItem(0, [\'active\' => false]);
$list->removeItem(2);
$list->clearItems();

// Getters
$itemCount = $list->getItemCount();
$firstItem = $list->getItem(0);
$allItems = $list->getItems();', 'php');

                $jsContent = so_code_block('import { UiEngine } from \'./ui-engine/UiEngine.js\';

// Basic list
const list = UiEngine.listGroup()
    .item(\'Home\')
    .item(\'About\')
    .item(\'Contact\');

document.getElementById(\'container\').innerHTML = list.render();

// Advanced list with all features
const menu = UiEngine.listGroup()
    .flush()
    .small()
    .item(\'Dashboard\', {
        icon: \'home\',
        url: \'/dashboard\',
        badge: 5,
        badgeVariant: \'primary\',
        active: true
    })
    .item(\'Messages\', {
        icon: \'mail\',
        url: \'/messages\',
        badge: 12,
        badgeVariant: \'danger\'
    })
    .item(\'Settings\', {
        icon: \'settings\',
        url: \'/settings\'
    });

document.getElementById(\'menu\').innerHTML = menu.render();

// Dynamic updates
menu.updateItem(0, {active: false, badge: 0});
menu.removeItem(2);
menu.toggleActive(1);

// Event handling
menu.onItemClick((e) => {
    console.log(\'Clicked item:\', e.detail.index, e.detail.item);
});

// Getters
const itemCount = menu.getItemCount();
const firstItem = menu.getItem(0);
const allItems = menu.getItems();', 'javascript');

                $configContent = so_code_block('// Configuration array format (works in both PHP and JS)
const config = {
    type: \'list-group\',
    flush: true,
    numbered: false,
    horizontal: false,  // or \'sm\', \'md\', \'lg\', \'xl\'
    size: \'sm\',  // or \'lg\'
    items: [
        {
            content: \'Dashboard\',
            icon: \'home\',
            url: \'/dashboard\',
            badge: 5,
            badgeVariant: \'primary\',
            active: true,
            disabled: false,
            variant: null
        },
        {
            content: \'Messages\',
            icon: \'mail\',
            url: \'/messages\',
            badge: 12,
            badgeVariant: \'danger\'
        }
    ]
};

// PHP: Create from config
$list = UiEngine::fromConfig($config);

// JavaScript: Create from config
const list = UiEngine.fromConfig(config);

// Export to config
const exportedConfig = list.toConfig();  // JS
$exportedConfig = $list->toArray();      // PHP', 'javascript');

                echo so_tabs('uiengine-tabs', [
                    [
                        'id' => 'php-usage',
                        'label' => 'PHP (Server-side)',
                        'active' => true,
                        'content' => $phpContent
                    ],
                    [
                        'id' => 'js-usage',
                        'label' => 'JavaScript (Client-side)',
                        'content' => $jsContent
                    ],
                    [
                        'id' => 'config-usage',
                        'label' => 'Configuration',
                        'content' => $configContent
                    ]
                ]);
                ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4" id="api-reference">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Complete API reference for all ListGroup methods. All methods support chaining and are available in both PHP and JavaScript.</p>

                <!-- Tab Navigation -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-content-methods" aria-selected="true" aria-controls="api-content-methods">Content Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-styling-methods" aria-selected="false" aria-controls="api-styling-methods">Styling Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-state-methods" aria-selected="false" aria-controls="api-state-methods">State Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-event-methods" aria-selected="false" aria-controls="api-event-methods">Event Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-inherited-methods" aria-selected="false" aria-controls="api-inherited-methods">Inherited Methods</button>
                </div>

                <div class="so-tab-content">
                <!-- Content Methods -->
                <div class="so-tab-pane so-fade so-show so-active" id="api-content-methods" role="tabpanel">
                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>items(array $items)</code></td>
                                    <td>Set all items at once. Replaces existing items.</td>
                                </tr>
                                <tr>
                                    <td><code>item(string $content, array $options)</code></td>
                                    <td>Add single item with options: <code>{icon, url, badge, badgeVariant, variant, active, disabled}</code></td>
                                </tr>
                                <tr>
                                    <td><code>addItem(...)</code></td>
                                    <td>Add item with full parameters: <code>(content, badge, variant, active, disabled, url, icon, badgeVariant)</code></td>
                                </tr>
                                <tr>
                                    <td><code>updateItem(int $index, array $updates)</code></td>
                                    <td>Update item at index. Merges updates with existing item data.</td>
                                </tr>
                                <tr>
                                    <td><code>removeItem(int $index)</code></td>
                                    <td>Remove item at specified index.</td>
                                </tr>
                                <tr>
                                    <td><code>clearItems()</code></td>
                                    <td>Remove all items from the list.</td>
                                </tr>
                                <tr>
                                    <td><code>getItem(int $index)</code></td>
                                    <td>Get item data at index. Returns <code>null</code> if not found.</td>
                                </tr>
                                <tr>
                                    <td><code>getItems()</code></td>
                                    <td>Get all items as array.</td>
                                </tr>
                                <tr>
                                    <td><code>getItemCount()</code></td>
                                    <td>Get total number of items.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP
$list = UiEngine::listGroup()
    ->item(\'Home\', [\'icon\' => \'home\', \'url\' => \'/\'])
    ->item(\'About\', [\'url\' => \'/about\'])
    ->updateItem(0, [\'active\' => true, \'badge\' => 5])
    ->removeItem(1);

$count = $list->getItemCount();  // 1
$item = $list->getItem(0);       // [\'content\' => \'Home\', ...]

// JavaScript
const list = UiEngine.listGroup()
    .item(\'Home\', {icon: \'home\', url: \'/\'})
    .item(\'About\', {url: \'/about\'})
    .updateItem(0, {active: true, badge: 5})
    .removeItem(1);

const count = list.getItemCount();  // 1
const item = list.getItem(0);       // {content: \'Home\', ...}', 'php') ?>
                </div>

                <!-- Styling Methods -->
                <div class="so-tab-pane so-fade" id="api-styling-methods" role="tabpanel">
                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>flush(bool $flush = true)</code></td>
                                    <td>Remove borders and rounded corners. Adds <code>.so-list-group-flush</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>numbered(bool $numbered = true)</code></td>
                                    <td>Automatically number items. Changes tag to <code>&lt;ol&gt;</code> and adds <code>.so-list-group-numbered</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>horizontal(bool|string $bp = true)</code></td>
                                    <td>Display items horizontally. Pass <code>'sm'</code>, <code>'md'</code>, <code>'lg'</code>, <code>'xl'</code> for responsive breakpoint.</td>
                                </tr>
                                <tr>
                                    <td><code>size(string $size)</code></td>
                                    <td>Set size variant: <code>'sm'</code> or <code>'lg'</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>small()</code></td>
                                    <td>Small size shortcut. Adds <code>.so-list-group-sm</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>large()</code></td>
                                    <td>Large size shortcut. Adds <code>.so-list-group-lg</code> class.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP
$list = UiEngine::listGroup()
    ->flush()         // No borders
    ->small()         // Small size
    ->item(\'Item 1\')
    ->item(\'Item 2\');

$numbered = UiEngine::listGroup()
    ->numbered()      // Auto-numbered
    ->item(\'Step 1\')
    ->item(\'Step 2\');

$horizontal = UiEngine::listGroup()
    ->horizontal(\'md\')  // Horizontal on medium screens and up
    ->item(\'Tab 1\')
    ->item(\'Tab 2\');

// JavaScript
const list = UiEngine.listGroup()
    .flush()
    .small()
    .item(\'Item 1\')
    .item(\'Item 2\');', 'php') ?>
                </div>

                <!-- State Methods -->
                <div class="so-tab-pane so-fade" id="api-state-methods" role="tabpanel">
                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>setActive(int $index, bool $active = true)</code></td>
                                    <td>Set active state on item at index. Active items get <code>.so-active</code> class.</td>
                                </tr>
                                <tr>
                                    <td><code>setDisabled(int $index, bool $disabled = true)</code></td>
                                    <td>Set disabled state on item. Disabled items get <code>.disabled</code> class and <code>aria-disabled</code> attribute.</td>
                                </tr>
                                <tr>
                                    <td><code>toggleActive(int $index)</code></td>
                                    <td><strong>JavaScript only:</strong> Toggle active state on item. Fires <code>so:item:toggled</code> event.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP
$list = UiEngine::listGroup()
    ->item(\'Item 1\')
    ->item(\'Item 2\')
    ->item(\'Item 3\')
    ->setActive(0, true)      // Make first item active
    ->setDisabled(2, true);   // Make third item disabled

// JavaScript
const list = UiEngine.listGroup()
    .item(\'Item 1\')
    .item(\'Item 2\')
    .item(\'Item 3\')
    .setActive(0, true)
    .setDisabled(2, true);

// Toggle active state (JS only)
list.toggleActive(1);  // Toggle second item', 'php') ?>
                </div>

                <!-- Event Methods -->
                <div class="so-tab-pane so-fade" id="api-event-methods" role="tabpanel">
                    <p class="so-text-muted so-mb-3"><strong>JavaScript Only:</strong> Event handling methods for client-side interactivity.</p>

                    <div class="so-table-responsive so-mb-4">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>onClick(callback)</code></td>
                                    <td>Listen for clicks on the list group container.</td>
                                </tr>
                                <tr>
                                    <td><code>onItemClick(callback)</code></td>
                                    <td>Listen for clicks on individual items. Receives event with <code>detail: {index, item, element, originalEvent}</code>.</td>
                                </tr>
                                <tr>
                                    <td><code>on(eventName, callback)</code></td>
                                    <td>Generic event listener (inherited from Element).</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="so-mb-3">Custom Events (so: prefixed)</h5>
                    <div class="so-table-responsive so-mb-4">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Event</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>so:item:click</code></td>
                                    <td>Fired when an item is clicked. <code>detail: {index, item, element, originalEvent}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:item:updated</code></td>
                                    <td>Fired when an item is updated. <code>detail: {index, item}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:item:removed</code></td>
                                    <td>Fired when an item is removed. <code>detail: {index, item}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:item:toggled</code></td>
                                    <td>Fired when an item's active state is toggled. <code>detail: {index, active}</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:items:cleared</code></td>
                                    <td>Fired when all items are cleared. <code>detail: {}</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// JavaScript event handling
const list = UiEngine.listGroup()
    .item(\'Home\', {url: \'/\'})
    .item(\'About\', {url: \'/about\'})
    .item(\'Contact\', {url: \'/contact\'});

// Listen for item clicks
list.onItemClick((e) => {
    console.log(\'Clicked:\', e.detail.item.content);
    console.log(\'Index:\', e.detail.index);

    // Prevent navigation
    e.detail.originalEvent.preventDefault();

    // Update item
    list.updateItem(e.detail.index, {active: true});
});

// Listen for updates
list.on(\'so:item:updated\', (e) => {
    console.log(\'Item updated:\', e.detail.item);
});

// Listen for removals
list.on(\'so:item:removed\', (e) => {
    console.log(\'Item removed:\', e.detail.item);
});

// Render and attach events
document.getElementById(\'menu\').innerHTML = list.render();', 'javascript') ?>
                </div>

                <!-- Inherited Methods -->
                <div class="so-tab-pane so-fade" id="api-inherited-methods" role="tabpanel">
                    <p class="so-text-muted so-mb-3">ListGroup inherits these methods from the base Element class:</p>

                    <div class="so-table-responsive">
                        <table class="so-table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Method</th>
                                    <th style="width: 70%;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>id(string $id)</code></td>
                                    <td>Set element ID attribute.</td>
                                </tr>
                                <tr>
                                    <td><code>addClass(string $class)</code></td>
                                    <td>Add CSS class(es). Space-separated for multiple.</td>
                                </tr>
                                <tr>
                                    <td><code>attr(string $name, mixed $value)</code></td>
                                    <td>Set HTML attribute.</td>
                                </tr>
                                <tr>
                                    <td><code>data(string $key, mixed $value)</code></td>
                                    <td>Set data attribute (auto-prefixes with <code>data-so-</code>).</td>
                                </tr>
                                <tr>
                                    <td><code>style(string $property, string $value)</code></td>
                                    <td>Set inline CSS style property.</td>
                                </tr>
                                <tr>
                                    <td><code>render()</code></td>
                                    <td><strong>JavaScript:</strong> Return rendered HTML string.</td>
                                </tr>
                                <tr>
                                    <td><code>__toString()</code></td>
                                    <td><strong>PHP:</strong> Automatically called when echoing.</td>
                                </tr>
                                <tr>
                                    <td><code>toArray() / toConfig()</code></td>
                                    <td>Export element configuration.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block('// PHP - Using inherited methods
$list = UiEngine::listGroup()
    ->item(\'Home\')
    ->item(\'About\')
    ->id(\'main-menu\')
    ->addClass(\'custom-menu highlight\')
    ->attr(\'role\', \'navigation\')
    ->attr(\'aria-label\', \'Main navigation\')
    ->data(\'section\', \'header\')
    ->style(\'margin-top\', \'1rem\');

echo $list;  // Calls __toString()

// JavaScript - Using inherited methods
const list = UiEngine.listGroup()
    .item(\'Home\')
    .item(\'About\')
    .id(\'main-menu\')
    .addClass(\'custom-menu highlight\')
    .attr(\'role\', \'navigation\')
    .attr(\'aria-label\', \'Main navigation\')
    .data(\'section\', \'header\')
    .style(\'margin-top\', \'1rem\');

const html = list.render();
document.getElementById(\'container\').innerHTML = html;', 'php') ?>
                </div>
                </div>
            </div>
        </div>

        <!-- Validation -->
        <div class="so-card so-mb-4" id="validation">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    ListGroup is a display-only component that doesn't require validation. However, if you're dynamically
                    generating list items from user input or form data, you should validate that data before creating the list.
                </p>

                <div class="so-alert so-alert-info so-mb-4">
                    <div class="so-alert-icon">
                        <span class="material-icons">info</span>
                    </div>
                    <div class="so-alert-content">
                        <strong>Note:</strong> List groups are for display purposes. For interactive forms with validation,
                        use form elements like checkboxes, radio buttons, or selects within a form component.
                    </div>
                </div>

                <h5 class="so-mb-3">Validating Item Data</h5>
                <?= so_code_block('<?php
use Core\Validation\Validator;
use Core\UiEngine\UiEngine;

// Validate item data before creating list
function createValidatedList(array $items): ?string
{
    foreach ($items as $item) {
        $validator = new Validator($item, [
            \'content\' => \'required|string|max:255\',
            \'url\' => \'nullable|url\',
            \'badge\' => \'nullable|integer|min:0\',
            \'variant\' => \'nullable|in:primary,secondary,success,danger,warning,info\',
        ]);

        if ($validator->fails()) {
            return null;  // or handle error
        }
    }

    $list = UiEngine::listGroup();
    foreach ($items as $item) {
        $list->item($item[\'content\'], $item);
    }

    return (string) $list;
}

// Usage
$items = [
    [\'content\' => \'Home\', \'url\' => \'/\'],
    [\'content\' => \'Messages\', \'url\' => \'/messages\', \'badge\' => 5],
];

$html = createValidatedList($items);', 'php') ?>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="so-card so-mb-4" id="error-handling">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Handling</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Common error scenarios and how to handle them when working with ListGroup.
                </p>

                <h5 class="so-mb-3">Common Scenarios</h5>
                <div class="so-table-responsive so-mb-4">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Scenario</th>
                                <th style="width: 35%;">Issue</th>
                                <th style="width: 40%;">Solution</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Empty list</td>
                                <td>No items to display</td>
                                <td>Show empty state message</td>
                            </tr>
                            <tr>
                                <td>Invalid item data</td>
                                <td>Missing required fields</td>
                                <td>Validate before adding items</td>
                            </tr>
                            <tr>
                                <td>Index out of bounds</td>
                                <td><code>getItem(999)</code> on small list</td>
                                <td>Check <code>getItemCount()</code> first</td>
                            </tr>
                            <tr>
                                <td>Invalid variant</td>
                                <td>Typo in variant name</td>
                                <td>Use constants or validation</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mb-3">Error Handling Examples</h5>
                <?= so_code_block('<?php
// PHP - Handle empty lists
function renderList(array $items): string
{
    if (empty($items)) {
        return UiEngine::emptyState()
            ->icon(\'inbox\')
            ->title(\'No items\')
            ->description(\'Add items to get started.\')
            ->render();
    }

    $list = UiEngine::listGroup();
    foreach ($items as $item) {
        if (isset($item[\'content\'])) {
            $list->item($item[\'content\'], $item);
        }
    }

    return (string) $list;
}

// Safe item access
$list = UiEngine::listGroup()
    ->item(\'Item 1\')
    ->item(\'Item 2\');

// Check bounds before accessing
if ($index < $list->getItemCount()) {
    $item = $list->getItem($index);
}

// Or handle null return
$item = $list->getItem($index);
if ($item === null) {
    // Handle missing item
}', 'php') ?>

                <hr class="so-my-4">

                <?= so_code_block('// JavaScript - Error handling
const list = UiEngine.listGroup();

// Handle empty lists
function renderList(items) {
    if (!items || items.length === 0) {
        return UiEngine.emptyState()
            .icon(\'inbox\')
            .title(\'No items\')
            .description(\'Add items to get started.\')
            .render();
    }

    const list = UiEngine.listGroup();
    items.forEach(item => {
        if (item.content) {
            list.item(item.content, item);
        }
    });

    return list.render();
}

// Safe item access
const index = 5;
if (index < list.getItemCount()) {
    const item = list.getItem(index);
}

// Validate variant
const validVariants = [\'primary\', \'secondary\', \'success\', \'danger\', \'warning\', \'info\'];
const variant = userInput;

if (validVariants.includes(variant)) {
    list.item(\'Item\', {variant});
}', 'javascript') ?>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    Pass ListGroup configuration from PHP to JavaScript for client-side hydration and interactivity.
                </p>

                <h5 class="so-mb-3">Method 1: Data Attributes</h5>
                <?= so_code_block('<?php
// PHP - Export config to data attribute
$list = UiEngine::listGroup()
    ->flush()
    ->small()
    ->item(\'Home\', [\'icon\' => \'home\', \'url\' => \'/\'])
    ->item(\'About\', [\'icon\' => \'info\', \'url\' => \'/about\']);

$config = $list->toArray();
?>

<div id="menu-container" data-list-config=\'<?= json_encode($config) ?>\'></div>

<script type="module">
import { UiEngine } from \'./ui-engine/UiEngine.js\';

// JavaScript - Hydrate from config
const container = document.getElementById(\'menu-container\');
const config = JSON.parse(container.dataset.listConfig);

const list = UiEngine.fromConfig(config);
container.innerHTML = list.render();

// Add interactivity
list.onItemClick((e) => {
    console.log(\'Clicked:\', e.detail.item.content);
});
</script>', 'php') ?>

                <hr class="so-my-4">

                <h5 class="so-mb-3">Method 2: Inline Script</h5>
                <?= so_code_block('<?php
$list = UiEngine::listGroup()
    ->item(\'Dashboard\', [\'icon\' => \'home\', \'badge\' => 5])
    ->item(\'Messages\', [\'icon\' => \'mail\', \'badge\' => 12]);

$config = $list->toArray();
?>

<div id="menu"></div>

<script type="module">
import { UiEngine } from \'./ui-engine/UiEngine.js\';

const config = <?= json_encode($config) ?>;
const list = UiEngine.fromConfig(config);

document.getElementById(\'menu\').innerHTML = list.render();
</script>', 'php') ?>

                <hr class="so-my-4">

                <h5 class="so-mb-3">Method 3: API Endpoint</h5>
                <?= so_code_block('// PHP - API endpoint returning config
Route::get(\'/api/menu\', function() {
    $list = UiEngine::listGroup()
        ->item(\'Dashboard\', [\'url\' => \'/dashboard\', \'icon\' => \'home\'])
        ->item(\'Settings\', [\'url\' => \'/settings\', \'icon\' => \'settings\']);

    return response()->json([
        \'config\' => $list->toArray()
    ]);
});', 'php') ?>

                <?= so_code_block('// JavaScript - Fetch and render
import { UiEngine } from \'./ui-engine/UiEngine.js\';

async function loadMenu() {
    const response = await fetch(\'/api/menu\');
    const data = await response.json();

    const list = UiEngine.fromConfig(data.config);
    document.getElementById(\'menu\').innerHTML = list.render();

    // Add interactivity
    list.onItemClick((e) => {
        // Handle click
    });
}

loadMenu();', 'javascript') ?>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Complete reference of CSS classes used by ListGroup.</p>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 35%;">Class</th>
                                <th style="width: 65%;">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-list-group</code></td>
                                <td>Base list group container</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-item</code></td>
                                <td>Individual list item</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-item-action</code></td>
                                <td>Clickable item with hover state</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-flush</code></td>
                                <td>Remove borders and rounded corners</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-numbered</code></td>
                                <td>Auto-numbered items</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-horizontal</code></td>
                                <td>Horizontal layout (always)</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-horizontal-sm</code></td>
                                <td>Horizontal on small screens and up</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-horizontal-md</code></td>
                                <td>Horizontal on medium screens and up</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-horizontal-lg</code></td>
                                <td>Horizontal on large screens and up</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-horizontal-xl</code></td>
                                <td>Horizontal on extra large screens and up</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-sm</code></td>
                                <td>Small size variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-lg</code></td>
                                <td>Large size variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-item-primary</code></td>
                                <td>Primary color variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-item-secondary</code></td>
                                <td>Secondary color variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-item-success</code></td>
                                <td>Success color variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-item-danger</code></td>
                                <td>Danger color variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-item-warning</code></td>
                                <td>Warning color variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-list-group-item-info</code></td>
                                <td>Info color variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-active</code></td>
                                <td>Active state</td>
                            </tr>
                            <tr>
                                <td><code>.disabled</code></td>
                                <td>Disabled state</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Demo Link -->
        <div class="so-card so-mb-4" id="demo-link">
            <div class="so-card-header">
                <h3 class="so-card-title">Additional Examples</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">
                    For more CSS-based examples without UiEngine, visit the full demo page:
                </p>
                <a href="/demo/elements/list-group" class="so-btn so-btn-primary">
                    <span class="material-icons so-me-2">open_in_new</span>
                    View Full CSS Demo
                </a>
            </div>
        </div>

    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
