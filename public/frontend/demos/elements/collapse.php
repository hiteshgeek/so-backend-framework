<?php
/**
 * SixOrbit UI Demo - Collapse
 */
$pageTitle = 'Collapse';
$pageDescription = 'Collapse component for toggling content visibility';

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
            <h1 class="so-page-title">Collapse</h1>
            <p class="so-page-subtitle">Collapse component for toggling content visibility</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<div class="so-grid so-grid-cols-1 so-gap-6">

        <!-- Basic Collapse -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Collapse</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Toggle visibility of content with a simple button click.</p>

                <button class="so-btn so-btn-primary so-mb-3" type="button" data-so-toggle="collapse" data-so-target="#basicCollapse1">
                    Toggle Content
                </button>

                <div id="basicCollapse1" class="so-collapse so-show">
                    <div class="so-card">
                        <div class="so-card-body">
                            This is some placeholder content for a basic collapse. It can be any element or component. Click the button above to toggle this content.
                        </div>
                    </div>
                </div>
                <?= so_code_block('<button class="so-btn so-btn-primary" data-so-toggle="collapse" data-so-target="#myCollapse">
    Toggle Content
</button>

<div id="myCollapse" class="so-collapse so-show">
    <div class="so-card">
        <div class="so-card-body">
            Collapsible content here...
        </div>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Link vs Button Trigger -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Link vs Button Trigger</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Use either a button or an anchor link as the trigger element.</p>

                <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-3">
                    <a class="so-btn so-btn-primary" href="#linkCollapse" data-so-toggle="collapse" role="button">
                        Link with href
                    </a>
                    <button class="so-btn so-btn-secondary" type="button" data-so-toggle="collapse" data-so-target="#linkCollapse">
                        Button with data-so-target
                    </button>
                </div>

                <div id="linkCollapse" class="so-collapse">
                    <div class="so-card">
                        <div class="so-card-body">
                            Both triggers control the same collapse element. You can use either an anchor link with <code>href</code> or a button with <code>data-so-target</code>.
                        </div>
                    </div>
                </div>
                <?= so_code_block('<!-- Link with href -->
<a class="so-btn so-btn-primary" href="#myCollapse" data-so-toggle="collapse">
    Toggle
</a>

<!-- Button with data-so-target -->
<button class="so-btn so-btn-secondary" data-so-toggle="collapse" data-so-target="#myCollapse">
    Toggle
</button>', 'html') ?>
            </div>
        </div>

        <!-- Horizontal Collapse -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Horizontal Collapse</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Collapse horizontally instead of vertically using <code>.so-collapse-horizontal</code>.</p>

                <button class="so-btn so-btn-primary so-mb-3" type="button" data-so-toggle="collapse" data-so-target="#horizontalCollapse">
                    Toggle Width
                </button>

                <div style="min-height: 120px;">
                    <div id="horizontalCollapse" class="so-collapse so-collapse-horizontal so-show">
                        <div class="so-card so-card-body" style="width: 300px;">
                            This content collapses horizontally. It's useful for sidebars or panels that slide in/out from the side.
                        </div>
                    </div>
                </div>
                <?= so_code_block('<div id="horizontalCollapse" class="so-collapse so-collapse-horizontal so-show">
    <div class="so-card so-card-body" style="width: 300px;">
        Horizontal collapse content...
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Multiple Targets -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Multiple Targets</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Toggle multiple collapse elements at once using a class selector.</p>

                <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-3">
                    <button class="so-btn so-btn-primary" type="button" data-so-toggle="collapse" data-so-target="#multiCollapse1">
                        Toggle First
                    </button>
                    <button class="so-btn so-btn-secondary" type="button" data-so-toggle="collapse" data-so-target="#multiCollapse2">
                        Toggle Second
                    </button>
                    <button class="so-btn so-btn-info" type="button" data-so-toggle="collapse" data-so-target=".multi-collapse">
                        Toggle Both
                    </button>
                </div>

                <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4">
                    <div id="multiCollapse1" class="so-collapse multi-collapse so-show">
                        <div class="so-card">
                            <div class="so-card-body">
                                First collapse element. Toggled individually or together with the "Toggle Both" button.
                            </div>
                        </div>
                    </div>
                    <div id="multiCollapse2" class="so-collapse multi-collapse">
                        <div class="so-card">
                            <div class="so-card-body">
                                Second collapse element. Also toggled individually or together.
                            </div>
                        </div>
                    </div>
                </div>
                <?= so_code_block('<!-- Toggle both using class selector -->
<button data-so-toggle="collapse" data-so-target=".multi-collapse">
    Toggle Both
</button>

<div id="multiCollapse1" class="so-collapse multi-collapse so-show">...</div>
<div id="multiCollapse2" class="so-collapse multi-collapse">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Collapse Container -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Collapse Container</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Styled collapse containers with header, body, and interactive toggle.</p>

                <div class="so-collapse-container so-mb-4">
                    <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#containerCollapse1" aria-expanded="true">
                        <h5 class="so-collapse-title">Section Title</h5>
                        <span class="material-icons so-collapse-icon">expand_more</span>
                    </div>
                    <div id="containerCollapse1" class="so-collapse so-show">
                        <div class="so-collapse-body">
                            This is the body content of a collapse container. It has predefined styling for headers and content areas.
                        </div>
                    </div>
                </div>

                <div class="so-collapse-container">
                    <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#containerCollapse2" aria-expanded="false">
                        <h5 class="so-collapse-title">Another Section</h5>
                        <span class="material-icons so-collapse-icon">expand_more</span>
                    </div>
                    <div id="containerCollapse2" class="so-collapse">
                        <div class="so-collapse-body">
                            More content here. The header acts as the toggle button.
                        </div>
                    </div>
                </div>
                <?= so_code_block('<div class="so-collapse-container">
    <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#myContainer" aria-expanded="true">
        <h5 class="so-collapse-title">Section Title</h5>
        <span class="material-icons so-collapse-icon">expand_more</span>
    </div>
    <div id="myContainer" class="so-collapse so-show">
        <div class="so-collapse-body">
            Content here...
        </div>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Collapse Group -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Collapse Group</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Visually connected collapse containers that form a unified group.</p>

                <div class="so-collapse-group so-mb-4">
                    <div class="so-collapse-container">
                        <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#groupCollapse1" aria-expanded="true">
                            <h5 class="so-collapse-title">First Panel</h5>
                            <span class="material-icons so-collapse-icon">expand_more</span>
                        </div>
                        <div id="groupCollapse1" class="so-collapse so-show">
                            <div class="so-collapse-body">
                                Content for the first panel in the group.
                            </div>
                        </div>
                    </div>
                    <div class="so-collapse-container">
                        <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#groupCollapse2" aria-expanded="false">
                            <h5 class="so-collapse-title">Second Panel</h5>
                            <span class="material-icons so-collapse-icon">expand_more</span>
                        </div>
                        <div id="groupCollapse2" class="so-collapse">
                            <div class="so-collapse-body">
                                Content for the second panel in the group.
                            </div>
                        </div>
                    </div>
                    <div class="so-collapse-container">
                        <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#groupCollapse3" aria-expanded="false">
                            <h5 class="so-collapse-title">Third Panel</h5>
                            <span class="material-icons so-collapse-icon">expand_more</span>
                        </div>
                        <div id="groupCollapse3" class="so-collapse">
                            <div class="so-collapse-body">
                                Content for the third panel in the group.
                            </div>
                        </div>
                    </div>
                </div>
                <?= so_code_block('<div class="so-collapse-group">
    <div class="so-collapse-container">...</div>
    <div class="so-collapse-container">...</div>
    <div class="so-collapse-container">...</div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Animation Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Animation Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Different animation styles for the collapse transition.</p>

                <div class="so-grid so-grid-cols-1 md:so-grid-cols-3 so-gap-4 so-mb-4">
                    <!-- Fade -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Fade Animation</label>
                        <button class="so-btn so-btn-sm so-btn-outline-primary so-mb-2" type="button" data-so-toggle="collapse" data-so-target="#fadeCollapse">
                            Toggle Fade
                        </button>
                        <div id="fadeCollapse" class="so-collapse so-collapse-fade so-show">
                            <div class="so-card so-card-body">
                                Fades in and out with opacity transition.
                            </div>
                        </div>
                    </div>

                    <!-- Slide -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Slide Animation</label>
                        <button class="so-btn so-btn-sm so-btn-outline-secondary so-mb-2" type="button" data-so-toggle="collapse" data-so-target="#slideCollapse">
                            Toggle Slide
                        </button>
                        <div id="slideCollapse" class="so-collapse so-collapse-slide so-show">
                            <div class="so-card so-card-body">
                                Slides in from the left.
                            </div>
                        </div>
                    </div>

                    <!-- Scale -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Scale Animation</label>
                        <button class="so-btn so-btn-sm so-btn-outline-info so-mb-2" type="button" data-so-toggle="collapse" data-so-target="#scaleCollapse">
                            Toggle Scale
                        </button>
                        <div id="scaleCollapse" class="so-collapse so-collapse-scale so-show">
                            <div class="so-card so-card-body">
                                Scales up from small to full size.
                            </div>
                        </div>
                    </div>
                </div>
                <?= so_code_block('<!-- Fade -->
<div class="so-collapse so-collapse-fade">...</div>

<!-- Slide -->
<div class="so-collapse so-collapse-slide">...</div>

<!-- Scale -->
<div class="so-collapse so-collapse-scale">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Small and large collapse containers for different contexts.</p>

                <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4 so-mb-4">
                    <!-- Small -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Small (.so-collapse-sm)</label>
                        <div class="so-collapse-container so-collapse-sm">
                            <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#smCollapse" aria-expanded="true">
                                <h5 class="so-collapse-title">Small Collapse</h5>
                                <span class="material-icons so-collapse-icon">expand_more</span>
                            </div>
                            <div id="smCollapse" class="so-collapse so-show">
                                <div class="so-collapse-body">
                                    Compact content area for small UI elements.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Large -->
                    <div>
                        <label class="so-d-block so-mb-2 so-text-sm so-font-medium">Large (.so-collapse-lg)</label>
                        <div class="so-collapse-container so-collapse-lg">
                            <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#lgCollapse" aria-expanded="true">
                                <h5 class="so-collapse-title">Large Collapse</h5>
                                <span class="material-icons so-collapse-icon">expand_more</span>
                            </div>
                            <div id="lgCollapse" class="so-collapse so-show">
                                <div class="so-collapse-body">
                                    More spacious content area for larger sections.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= so_code_block('<div class="so-collapse-container so-collapse-sm">...</div>
<div class="so-collapse-container so-collapse-lg">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Apply theme colors to collapse containers.</p>

                <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 lg:so-grid-cols-4 so-gap-4 so-mb-4">
                    <div class="so-collapse-container so-collapse-primary">
                        <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#colorPrimary" aria-expanded="true">
                            <h5 class="so-collapse-title">Primary</h5>
                            <span class="material-icons so-collapse-icon">expand_more</span>
                        </div>
                        <div id="colorPrimary" class="so-collapse so-show">
                            <div class="so-collapse-body">Primary color theme.</div>
                        </div>
                    </div>
                    <div class="so-collapse-container so-collapse-success">
                        <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#colorSuccess" aria-expanded="true">
                            <h5 class="so-collapse-title">Success</h5>
                            <span class="material-icons so-collapse-icon">expand_more</span>
                        </div>
                        <div id="colorSuccess" class="so-collapse so-show">
                            <div class="so-collapse-body">Success color theme.</div>
                        </div>
                    </div>
                    <div class="so-collapse-container so-collapse-warning">
                        <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#colorWarning" aria-expanded="true">
                            <h5 class="so-collapse-title">Warning</h5>
                            <span class="material-icons so-collapse-icon">expand_more</span>
                        </div>
                        <div id="colorWarning" class="so-collapse so-show">
                            <div class="so-collapse-body">Warning color theme.</div>
                        </div>
                    </div>
                    <div class="so-collapse-container so-collapse-danger">
                        <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#colorDanger" aria-expanded="true">
                            <h5 class="so-collapse-title">Danger</h5>
                            <span class="material-icons so-collapse-icon">expand_more</span>
                        </div>
                        <div id="colorDanger" class="so-collapse so-show">
                            <div class="so-collapse-body">Danger color theme.</div>
                        </div>
                    </div>
                </div>
                <?= so_code_block('<div class="so-collapse-container so-collapse-primary">...</div>
<div class="so-collapse-container so-collapse-success">...</div>
<div class="so-collapse-container so-collapse-warning">...</div>
<div class="so-collapse-container so-collapse-danger">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Card Collapsible -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Card Collapsible</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Cards with collapsible bodies using the <code>.so-card-collapsible</code> class.</p>

                <div class="so-card so-card-collapsible so-mb-4">
                    <div class="so-card-header" data-so-toggle="collapse" data-so-target="#cardCollapse1" aria-expanded="true">
                        <h5 class="so-mb-0">Collapsible Card</h5>
                        <span class="material-icons so-collapse-icon">expand_more</span>
                    </div>
                    <div id="cardCollapse1" class="so-collapse so-show">
                        <div class="so-card-body">
                            This is a card with a collapsible body. Click the header to toggle the content. The header styling changes when collapsed.
                        </div>
                    </div>
                </div>

                <div class="so-card so-card-collapsible">
                    <div class="so-card-header so-collapsed" data-so-toggle="collapse" data-so-target="#cardCollapse2" aria-expanded="false">
                        <h5 class="so-mb-0">Initially Collapsed Card</h5>
                        <span class="material-icons so-collapse-icon">expand_more</span>
                    </div>
                    <div id="cardCollapse2" class="so-collapse">
                        <div class="so-card-body">
                            This card starts collapsed. Click the header to expand it.
                        </div>
                    </div>
                </div>
                <?= so_code_block('<div class="so-card so-card-collapsible">
    <div class="so-card-header" data-so-toggle="collapse" data-so-target="#cardBody" aria-expanded="true">
        <h5 class="so-mb-0">Card Title</h5>
        <span class="material-icons so-collapse-icon">expand_more</span>
    </div>
    <div id="cardBody" class="so-collapse so-show">
        <div class="so-card-body">
            Card content here...
        </div>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Inline Collapse (Show More/Less) -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Inline Collapse (Show More/Less)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Truncated content with a "Show More" toggle, useful for long text content.</p>

                <div class="so-collapse-inline so-mb-4">
                    <div class="so-collapse-content" id="inlineContent">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <p>Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida.</p>
                    </div>
                    <button class="so-collapse-toggle so-btn so-btn-link" onclick="this.previousElementSibling.classList.toggle('so-show'); this.textContent = this.previousElementSibling.classList.contains('so-show') ? 'Show Less' : 'Show More';">
                        Show More
                    </button>
                </div>
                <?= so_code_block('<div class="so-collapse-inline">
    <div class="so-collapse-content">
        Long content here...
    </div>
    <button class="so-collapse-toggle so-btn so-btn-link">
        Show More
    </button>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Nested Collapse -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Nested Collapse</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Collapse elements inside other collapse elements for hierarchical content.</p>

                <div class="so-collapse-container so-mb-4">
                    <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#nestedParent" aria-expanded="true">
                        <h5 class="so-collapse-title">Parent Section</h5>
                        <span class="material-icons so-collapse-icon">expand_more</span>
                    </div>
                    <div id="nestedParent" class="so-collapse so-show">
                        <div class="so-collapse-body">
                            <p>This is the parent content. It contains nested collapse elements.</p>

                            <div class="so-collapse-nested">
                                <button class="so-collapse-toggle so-btn so-btn-sm so-btn-outline-primary so-mb-2" data-so-toggle="collapse" data-so-target="#nestedChild1">
                                    <span class="material-icons so-collapse-icon">expand_more</span>
                                    Nested Item 1
                                </button>
                                <div id="nestedChild1" class="so-collapse so-show">
                                    <p class="so-text-muted">Content for nested item 1.</p>
                                </div>
                            </div>

                            <div class="so-collapse-nested">
                                <button class="so-collapse-toggle so-btn so-btn-sm so-btn-outline-primary so-mb-2" data-so-toggle="collapse" data-so-target="#nestedChild2">
                                    <span class="material-icons so-collapse-icon">expand_more</span>
                                    Nested Item 2
                                </button>
                                <div id="nestedChild2" class="so-collapse">
                                    <p class="so-text-muted">Content for nested item 2.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= so_code_block('<div class="so-collapse-container">
    <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#parent">
        Parent Section
    </div>
    <div id="parent" class="so-collapse so-show">
        <div class="so-collapse-body">
            Parent content...

            <div class="so-collapse-nested">
                <button class="so-collapse-toggle" data-so-toggle="collapse" data-so-target="#child1">
                    Nested Item
                </button>
                <div id="child1" class="so-collapse">
                    Nested content...
                </div>
            </div>
        </div>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- JavaScript API & Events -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript API & Events</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control collapse elements programmatically and listen to events.</p>

                <div class="so-collapse-container so-mb-4" id="apiCollapseContainer">
                    <div class="so-collapse-header" data-so-toggle="collapse" data-so-target="#apiCollapse" aria-expanded="false">
                        <h5 class="so-collapse-title">API Demo Panel</h5>
                        <span class="material-icons so-collapse-icon">expand_more</span>
                    </div>
                    <div id="apiCollapse" class="so-collapse">
                        <div class="so-collapse-body">
                            This panel can be controlled via JavaScript API. Use the buttons below to interact with it.
                        </div>
                    </div>
                </div>

                <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4">
                    <button class="so-btn so-btn-sm so-btn-primary" onclick="SOCollapse.show(document.getElementById('apiCollapse'))">Show</button>
                    <button class="so-btn so-btn-sm so-btn-secondary" onclick="SOCollapse.hide(document.getElementById('apiCollapse'))">Hide</button>
                    <button class="so-btn so-btn-sm so-btn-outline-primary" onclick="SOCollapse.toggle(document.getElementById('apiCollapse'))">Toggle</button>
                </div>

                <div class="so-alert so-alert-info so-mb-4" id="collapse-event-log">
                    <span class="material-icons">info</span>
                    <span>Event log will appear here. Interact with the collapse above.</span>
                </div>
                <?= so_code_block('// Programmatic control
SOCollapse.show(element);   // Expand collapse
SOCollapse.hide(element);   // Collapse
SOCollapse.toggle(element); // Toggle state

// Events
element.addEventListener(\'so:collapse:show\', (e) => {
    console.log(\'About to expand\');
});

element.addEventListener(\'so:collapse:shown\', (e) => {
    console.log(\'Fully expanded\');
});

element.addEventListener(\'so:collapse:hide\', (e) => {
    console.log(\'About to collapse\');
});

element.addEventListener(\'so:collapse:hidden\', (e) => {
    console.log(\'Fully collapsed\');
});', 'javascript') ?>

                <h5 class="so-mt-6 so-mb-3">Available Events</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so:collapse:show</code></td>
                                <td>Fires immediately when show is called</td>
                            </tr>
                            <tr>
                                <td><code>so:collapse:shown</code></td>
                                <td>Fires when collapse is fully visible</td>
                            </tr>
                            <tr>
                                <td><code>so:collapse:hide</code></td>
                                <td>Fires immediately when hide is called</td>
                            </tr>
                            <tr>
                                <td><code>so:collapse:hidden</code></td>
                                <td>Fires when collapse is fully hidden</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-collapse</code></td>
                                <td>Base collapse element (hidden by default)</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse.so-show</code></td>
                                <td>Visible state</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapsing</code></td>
                                <td>Transitioning state (applied during animation)</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-horizontal</code></td>
                                <td>Horizontal collapse (width instead of height)</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-toggle</code></td>
                                <td>Toggle button styling</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-icon</code></td>
                                <td>Icon with rotation animation</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-container</code></td>
                                <td>Styled collapse wrapper with header/body</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-header</code></td>
                                <td>Container header</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-body</code></td>
                                <td>Container body</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-group</code></td>
                                <td>Connected collapse containers</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-nested</code></td>
                                <td>Nested collapse styling</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-inline</code></td>
                                <td>Show more/less pattern</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-fade</code></td>
                                <td>Fade animation</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-slide</code></td>
                                <td>Slide animation</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-scale</code></td>
                                <td>Scale animation</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-sm / .so-collapse-lg</code></td>
                                <td>Size variants</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-{color}</code></td>
                                <td>Color variants (primary, success, etc.)</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-collapsible</code></td>
                                <td>Card with collapsible body</td>
                            </tr>
                            <tr>
                                <td><code>.so-collapse-mobile</code></td>
                                <td>Only collapses on mobile</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// SOCollapse Class
class SOCollapse {
    static init() {
        document.querySelectorAll('[data-so-toggle="collapse"]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();

                // Get target(s)
                const targetSelector = trigger.dataset.soTarget || trigger.getAttribute('href');
                if (!targetSelector) return;

                const targets = document.querySelectorAll(targetSelector);
                targets.forEach(target => {
                    SOCollapse.toggle(target);
                });
            });
        });
    }

    static toggle(element) {
        if (element.classList.contains('so-show')) {
            SOCollapse.hide(element);
        } else {
            SOCollapse.show(element);
        }
    }

    static show(element) {
        if (element.classList.contains('so-show') || element.classList.contains('so-collapsing')) return;

        const trigger = document.querySelector(`[data-so-target="#${element.id}"], [href="#${element.id}"]`);
        const isHorizontal = element.classList.contains('so-collapse-horizontal');

        // Dispatch show event
        element.dispatchEvent(new CustomEvent('so:collapse:show', { bubbles: true }));

        // Remove hidden state first
        element.classList.remove('so-collapse');
        element.style.display = 'block';

        // Measure target dimensions
        const targetHeight = element.scrollHeight;
        const targetWidth = element.scrollWidth;

        // Set initial dimension to 0
        if (isHorizontal) {
            element.style.width = '0px';
            element.style.overflow = 'hidden';
        } else {
            element.style.height = '0px';
            element.style.overflow = 'hidden';
        }

        // Add collapsing class for transition
        element.classList.add('so-collapsing');

        // Force reflow to apply initial state
        element.offsetHeight;

        // Animate to full size
        if (isHorizontal) {
            element.style.width = targetWidth + 'px';
        } else {
            element.style.height = targetHeight + 'px';
        }

        if (trigger) {
            trigger.classList.remove('so-collapsed');
            trigger.setAttribute('aria-expanded', 'true');
        }

        setTimeout(() => {
            element.classList.remove('so-collapsing');
            element.classList.add('so-collapse', 'so-show');
            element.style.display = '';
            element.style.height = '';
            element.style.width = '';
            element.style.overflow = '';
            element.dispatchEvent(new CustomEvent('so:collapse:shown', { bubbles: true }));
        }, 350);
    }

    static hide(element) {
        if (!element.classList.contains('so-show') || element.classList.contains('so-collapsing')) return;

        const trigger = document.querySelector(`[data-so-target="#${element.id}"], [href="#${element.id}"]`);
        const isHorizontal = element.classList.contains('so-collapse-horizontal');

        // Dispatch hide event
        element.dispatchEvent(new CustomEvent('so:collapse:hide', { bubbles: true }));

        // Set explicit dimensions before animating
        if (isHorizontal) {
            element.style.width = element.scrollWidth + 'px';
        } else {
            element.style.height = element.scrollHeight + 'px';
        }
        element.style.overflow = 'hidden';

        // Force reflow
        element.offsetHeight;

        // Remove show state, add collapsing for transition
        element.classList.remove('so-collapse', 'so-show');
        element.classList.add('so-collapsing');

        // Force reflow before animating to 0
        element.offsetHeight;

        // Animate to 0
        if (isHorizontal) {
            element.style.width = '0px';
        } else {
            element.style.height = '0px';
        }

        if (trigger) {
            trigger.classList.add('so-collapsed');
            trigger.setAttribute('aria-expanded', 'false');
        }

        setTimeout(() => {
            element.classList.remove('so-collapsing');
            element.classList.add('so-collapse');
            element.style.display = '';
            element.style.height = '';
            element.style.width = '';
            element.style.overflow = '';
            element.dispatchEvent(new CustomEvent('so:collapse:hidden', { bubbles: true }));
        }, 350);
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    SOCollapse.init();

    // Event log demo
    const apiCollapse = document.getElementById('apiCollapse');
    const eventLog = document.getElementById('collapse-event-log');

    if (apiCollapse && eventLog) {
        apiCollapse.addEventListener('so:collapse:show', () => {
            eventLog.innerHTML = '<span class="material-icons">play_arrow</span><span><strong>so:collapse:show</strong> - Collapse is about to expand</span>';
        });
        apiCollapse.addEventListener('so:collapse:shown', () => {
            eventLog.innerHTML = '<span class="material-icons">check_circle</span><span><strong>so:collapse:shown</strong> - Collapse is now fully expanded</span>';
        });
        apiCollapse.addEventListener('so:collapse:hide', () => {
            eventLog.innerHTML = '<span class="material-icons">close</span><span><strong>so:collapse:hide</strong> - Collapse is about to collapse</span>';
        });
        apiCollapse.addEventListener('so:collapse:hidden', () => {
            eventLog.innerHTML = '<span class="material-icons">check</span><span><strong>so:collapse:hidden</strong> - Collapse is now fully collapsed</span>';
        });
    }
});

function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const activePane = codeBlock.querySelector('.so-code-pane.so-active') || codeBlock;
    const code = activePane.querySelector('.so-code-content code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        button.innerHTML = '<span class="material-icons">check</span>';
        setTimeout(() => {
            button.innerHTML = '<span class="material-icons">content_copy</span>';
        }, 2000);
    });
}
</script>

</main>

<?php
require_once '../includes/footer.php';
?>
