<?php
/**
 * UiEngine Layouts Guide
 *
 * Step-by-step guide to building layouts with UiEngine.
 */

$pageTitle = 'UiEngine Layouts Guide';
$pageIcon = 'view-dashboard-variant';
$toc = [
    ['id' => 'introduction', 'title' => 'Introduction', 'level' => 2],
    ['id' => 'step-1-grid-basics', 'title' => 'Step 1: Grid Basics', 'level' => 2],
    ['id' => 'step-2-responsive-columns', 'title' => 'Step 2: Responsive Columns', 'level' => 2],
    ['id' => 'step-3-cards', 'title' => 'Step 3: Card Layouts', 'level' => 2],
    ['id' => 'step-4-dashboard', 'title' => 'Step 4: Dashboard Layout', 'level' => 2],
    ['id' => 'step-5-page-layouts', 'title' => 'Step 5: Page Layouts', 'level' => 2],
    ['id' => 'step-6-flexbox', 'title' => 'Step 6: Flexbox Layouts', 'level' => 2],
    ['id' => 'step-7-css-grid', 'title' => 'Step 7: CSS Grid Layouts', 'level' => 2],
    ['id' => 'common-patterns', 'title' => 'Common Patterns', 'level' => 2],
    ['id' => 'troubleshooting', 'title' => 'Troubleshooting', 'level' => 2],
];
$breadcrumbs = [['label' => 'Development', 'url' => '/docs#dev-panel'], ['label' => 'UiEngine Layouts Guide']];
$lastUpdated = '2026-02-03';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="dev-ui-engine-layouts" class="heading heading-1">
    <span class="mdi mdi-view-dashboard-variant heading-icon"></span>
    <span class="heading-text">UiEngine Layouts Guide</span>
</h1>

<p class="text-lead">
    Step-by-step guide to building layouts with UiEngine. From basic grids to complete dashboard pages.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-guide">Guide</span>
    <span class="badge badge-new">New</span>
    <span class="badge badge-step-by-step">Step-by-Step</span>
</div>

<!-- Introduction -->
<h2 id="introduction" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Introduction</span>
</h2>

<p>
    UiEngine provides layout elements for building responsive page structures. This guide covers the grid system, cards, dashboards, and responsive design patterns.
</p>

<?= callout('info', '
    <strong>Layout Elements:</strong>
    <ul class="so-mb-0">
        <li><code>Container</code> - Page content wrapper</li>
        <li><code>Row</code> - Horizontal grouping for columns</li>
        <li><code>Column</code> - Responsive width columns (12-column grid)</li>
        <li><code>Grid</code> - CSS Grid layouts</li>
        <li><code>Flex</code> - Flexbox containers</li>
        <li><code>Divider</code> - Visual separators</li>
    </ul>
') ?>

<!-- Step 1: Grid Basics -->
<h2 id="step-1-grid-basics" class="heading heading-2">
    <span class="mdi mdi-numeric-1-circle heading-icon"></span>
    <span class="heading-text">Step 1: Grid Basics</span>
</h2>

<p>
    The grid system uses a 12-column layout. Use <code>Row</code> and <code>Column</code> to create layouts.
</p>

<?= codeTabs('step1', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Two equal columns (6 + 6 = 12)
echo UiEngine::row()
    ->add(
        UiEngine::col(6)->add(\'<p>Left column content</p>\')
    )
    ->add(
        UiEngine::col(6)->add(\'<p>Right column content</p>\')
    )
    ->render();

// Three equal columns (4 + 4 + 4 = 12)
echo UiEngine::row()
    ->add(UiEngine::col(4)->add(\'Column 1\'))
    ->add(UiEngine::col(4)->add(\'Column 2\'))
    ->add(UiEngine::col(4)->add(\'Column 3\'))
    ->render();

// Unequal columns (main content + sidebar)
echo UiEngine::row()
    ->add(UiEngine::col(8)->add(\'Main content\'))
    ->add(UiEngine::col(4)->add(\'Sidebar\'))
    ->render();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => '// Two equal columns
const row = UiEngine.row()
    .add(
        UiEngine.col(6).add(\'<p>Left column content</p>\')
    )
    .add(
        UiEngine.col(6).add(\'<p>Right column content</p>\')
    );

document.getElementById(\'app\').innerHTML = row.toHtml();'
    ],
    [
        'label' => 'HTML Output',
        'language' => 'html',
        'code' => '<div class="so-row">
    <div class="so-col-6">
        <p>Left column content</p>
    </div>
    <div class="so-col-6">
        <p>Right column content</p>
    </div>
</div>'
    ],
]) ?>

<!-- Step 2: Responsive Columns -->
<h2 id="step-2-responsive-columns" class="heading heading-2">
    <span class="mdi mdi-numeric-2-circle heading-icon"></span>
    <span class="heading-text">Step 2: Responsive Columns</span>
</h2>

<p>
    Set different column widths for different screen sizes using breakpoint methods.
</p>

<?= codeTabs('step2', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Responsive columns: 4 on large, 6 on medium, 12 on small
echo UiEngine::row()
    ->add(
        UiEngine::col()
            ->lg(4)  // 4 columns on large screens (≥992px)
            ->md(6)  // 6 columns on medium screens (≥768px)
            ->sm(12) // Full width on small screens (<768px)
            ->add(UiEngine::card(\'Card 1\'))
    )
    ->add(
        UiEngine::col()
            ->lg(4)
            ->md(6)
            ->sm(12)
            ->add(UiEngine::card(\'Card 2\'))
    )
    ->add(
        UiEngine::col()
            ->lg(4)
            ->md(12) // Full width on medium
            ->sm(12)
            ->add(UiEngine::card(\'Card 3\'))
    )
    ->render();'
    ],
    [
        'label' => 'Breakpoints Reference',
        'language' => 'text',
        'code' => 'Breakpoints:
xs()  → Extra small (<576px)  - default
sm()  → Small (≥576px)
md()  → Medium (≥768px)
lg()  → Large (≥992px)
xl()  → Extra large (≥1200px)
xxl() → Extra extra large (≥1400px)

Example:
col()->xs(12)->sm(6)->md(4)->lg(3)
= Full width on mobile
= Half width on small tablets
= Third width on tablets
= Quarter width on desktop'
    ],
]) ?>

<?= callout('tip', '
    <strong>Mobile-First Design:</strong> Start with the smallest breakpoint and work up. If no breakpoint is specified, columns default to full width on smaller screens.
') ?>

<!-- Step 3: Cards -->
<h2 id="step-3-cards" class="heading heading-2">
    <span class="mdi mdi-numeric-3-circle heading-icon"></span>
    <span class="heading-text">Step 3: Card Layouts</span>
</h2>

<p>
    Cards are versatile containers for content. They can have headers, footers, images, and nested content.
</p>

<?= codeTabs('step3', [
    [
        'label' => 'Basic Cards',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Simple card with title
echo UiEngine::card(\'Card Title\')
    ->body(\'This is the card body content.\')
    ->render();

// Card with header and footer
echo UiEngine::card()
    ->header(\'<h5 class="so-mb-0">Card Header</h5>\')
    ->body(\'Card body content goes here.\')
    ->footer(\'<small class="so-text-muted">Last updated 3 mins ago</small>\')
    ->render();

// Card with image
echo UiEngine::card()
    ->image(\'/images/sample.jpg\', \'Sample image\')
    ->body(\'<h5 class="so-card-title">Card title</h5><p>Card description text.</p>\')
    ->footer(\'<a href="#" class="so-btn so-btn-primary">Go somewhere</a>\')
    ->render();'
    ],
    [
        'label' => 'Card Variants',
        'language' => 'php',
        'code' => '<?php
// Card with shadow
echo UiEngine::card(\'Elevated Card\')
    ->shadow()
    ->body(\'This card has a shadow.\')
    ->render();

// Card with border color
echo UiEngine::card(\'Primary Card\')
    ->border(\'primary\')
    ->body(\'Card with primary border.\')
    ->render();

// Card with background color
echo UiEngine::card(\'Info Card\')
    ->background(\'info\')
    ->textColor(\'white\')
    ->body(\'Card with info background.\')
    ->render();

// Clickable card
echo UiEngine::card(\'Clickable Card\')
    ->clickable()
    ->href(\'/details\')
    ->body(\'Click this card to navigate.\')
    ->render();'
    ],
]) ?>

<h3 class="heading heading-3">
    <span class="heading-text">Card Grid Layout</span>
</h3>

<?= codeBlock('php', '<?php
// Grid of cards
echo UiEngine::row()
    ->addClass(\'so-g-4\') // Gap between cards
    ->add(
        UiEngine::col()->md(6)->lg(4)->add(
            UiEngine::card(\'Feature 1\')
                ->body(\'Description of feature 1.\')
                ->shadow()
        )
    )
    ->add(
        UiEngine::col()->md(6)->lg(4)->add(
            UiEngine::card(\'Feature 2\')
                ->body(\'Description of feature 2.\')
                ->shadow()
        )
    )
    ->add(
        UiEngine::col()->md(6)->lg(4)->add(
            UiEngine::card(\'Feature 3\')
                ->body(\'Description of feature 3.\')
                ->shadow()
        )
    )
    ->render();') ?>

<!-- Step 4: Dashboard -->
<h2 id="step-4-dashboard" class="heading heading-2">
    <span class="mdi mdi-numeric-4-circle heading-icon"></span>
    <span class="heading-text">Step 4: Dashboard Layout</span>
</h2>

<p>
    Build a complete dashboard with stats cards, charts area, and data table.
</p>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

// Dashboard page
$dashboard = UiEngine::container()
    // Page header
    ->add(
        UiEngine::row()->addClass(\'so-mb-4\')
            ->add(
                UiEngine::col(12)->add(\'
                    <div class="so-d-flex so-justify-content-between so-align-items-center">
                        <h1 class="so-h3 so-mb-0">Dashboard</h1>
                        <button class="so-btn so-btn-primary">
                            <span class="mdi mdi-plus"></span> New Report
                        </button>
                    </div>
                \')
            )
    )
    // Stats row
    ->add(
        UiEngine::row()->addClass(\'so-mb-4 so-g-4\')
            ->add(
                UiEngine::col()->sm(6)->lg(3)->add(
                    UiEngine::card()
                        ->addClass(\'so-text-center\')
                        ->body(\'
                            <div class="so-h1 so-text-primary">1,234</div>
                            <div class="so-text-muted">Total Users</div>
                        \')
                )
            )
            ->add(
                UiEngine::col()->sm(6)->lg(3)->add(
                    UiEngine::card()
                        ->addClass(\'so-text-center\')
                        ->body(\'
                            <div class="so-h1 so-text-success">$45,678</div>
                            <div class="so-text-muted">Revenue</div>
                        \')
                )
            )
            ->add(
                UiEngine::col()->sm(6)->lg(3)->add(
                    UiEngine::card()
                        ->addClass(\'so-text-center\')
                        ->body(\'
                            <div class="so-h1 so-text-info">567</div>
                            <div class="so-text-muted">Orders</div>
                        \')
                )
            )
            ->add(
                UiEngine::col()->sm(6)->lg(3)->add(
                    UiEngine::card()
                        ->addClass(\'so-text-center\')
                        ->body(\'
                            <div class="so-h1 so-text-warning">89%</div>
                            <div class="so-text-muted">Satisfaction</div>
                        \')
                )
            )
    )
    // Main content row
    ->add(
        UiEngine::row()->addClass(\'so-g-4\')
            // Chart area (8 columns)
            ->add(
                UiEngine::col()->lg(8)->add(
                    UiEngine::card()
                        ->header(\'<h5 class="so-mb-0">Sales Overview</h5>\')
                        ->body(\'<div id="sales-chart" style="height: 300px;"></div>\')
                )
            )
            // Side widgets (4 columns)
            ->add(
                UiEngine::col()->lg(4)->add(
                    UiEngine::card()
                        ->header(\'<h5 class="so-mb-0">Recent Activity</h5>\')
                        ->body(\'
                            <ul class="so-list-group so-list-group-flush">
                                <li class="so-list-group-item">User John registered</li>
                                <li class="so-list-group-item">Order #1234 completed</li>
                                <li class="so-list-group-item">New comment on post</li>
                            </ul>
                        \')
                )
            )
    )
    // Data table row
    ->add(
        UiEngine::row()->addClass(\'so-mt-4\')
            ->add(
                UiEngine::col(12)->add(
                    UiEngine::card()
                        ->header(\'<h5 class="so-mb-0">Recent Orders</h5>\')
                        ->noPadding()
                        ->add(
                            UiEngine::table([\'ID\', \'Customer\', \'Amount\', \'Status\', \'Actions\'])
                                ->rows([
                                    [\'#1234\', \'John Doe\', \'$123.00\', \'<span class="so-badge so-bg-success">Completed</span>\', \'<a href="#">View</a>\'],
                                    [\'#1235\', \'Jane Smith\', \'$456.00\', \'<span class="so-badge so-bg-warning">Pending</span>\', \'<a href="#">View</a>\'],
                                ])
                                ->striped()
                                ->hover()
                        )
                )
            )
    );

echo $dashboard->render();') ?>

<!-- Step 5: Page Layouts -->
<h2 id="step-5-page-layouts" class="heading heading-2">
    <span class="mdi mdi-numeric-5-circle heading-icon"></span>
    <span class="heading-text">Step 5: Page Layouts</span>
</h2>

<p>
    Common page layout patterns with sidebar, main content, and responsive behavior.
</p>

<?= codeTabs('step5', [
    [
        'label' => 'Two-Column with Sidebar',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Two-column layout: sidebar + main content
echo UiEngine::container()->fluid()
    ->add(
        UiEngine::row()
            // Sidebar (collapses on mobile)
            ->add(
                UiEngine::col()
                    ->md(3)
                    ->lg(2)
                    ->addClass(\'so-bg-light so-min-vh-100 so-d-none so-d-md-block\')
                    ->add(\'
                        <nav class="so-nav so-flex-column so-p-3">
                            <a class="so-nav-link active" href="#">Dashboard</a>
                            <a class="so-nav-link" href="#">Users</a>
                            <a class="so-nav-link" href="#">Settings</a>
                        </nav>
                    \')
            )
            // Main content
            ->add(
                UiEngine::col()
                    ->md(9)
                    ->lg(10)
                    ->addClass(\'so-p-4\')
                    ->add(\'<h1>Page Title</h1><p>Main content area...</p>\')
            )
    )
    ->render();'
    ],
    [
        'label' => 'Holy Grail Layout',
        'language' => 'php',
        'code' => '<?php
// Classic holy grail: header, sidebar, main, sidebar, footer
$layout = UiEngine::container()->fluid()
    // Header
    ->add(
        UiEngine::row()
            ->add(
                UiEngine::col(12)
                    ->addClass(\'so-bg-primary so-text-white so-p-3\')
                    ->add(\'<h1 class="so-mb-0">Site Header</h1>\')
            )
    )
    // Middle section
    ->add(
        UiEngine::row()
            // Left sidebar
            ->add(
                UiEngine::col()->md(2)
                    ->addClass(\'so-bg-light so-p-3 so-d-none so-d-md-block\')
                    ->add(\'<h5>Left Sidebar</h5><p>Navigation links...</p>\')
            )
            // Main content
            ->add(
                UiEngine::col()->md(8)
                    ->addClass(\'so-p-4\')
                    ->add(\'<h2>Main Content</h2><p>Page content goes here...</p>\')
            )
            // Right sidebar
            ->add(
                UiEngine::col()->md(2)
                    ->addClass(\'so-bg-light so-p-3 so-d-none so-d-md-block\')
                    ->add(\'<h5>Right Sidebar</h5><p>Widgets...</p>\')
            )
    )
    // Footer
    ->add(
        UiEngine::row()
            ->add(
                UiEngine::col(12)
                    ->addClass(\'so-bg-dark so-text-white so-p-3 so-text-center\')
                    ->add(\'<p class="so-mb-0">&copy; 2026 Company Name</p>\')
            )
    );

echo $layout->render();'
    ],
]) ?>

<!-- Step 6: Flexbox -->
<h2 id="step-6-flexbox" class="heading heading-2">
    <span class="mdi mdi-numeric-6-circle heading-icon"></span>
    <span class="heading-text">Step 6: Flexbox Layouts</span>
</h2>

<p>
    Use the <code>Flex</code> element for more control over alignment and distribution.
</p>

<?= codeTabs('step6', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Horizontal flex with space between
echo UiEngine::flex()
    ->direction(\'row\')
    ->justify(\'between\')
    ->align(\'center\')
    ->add(\'<span>Left</span>\')
    ->add(\'<span>Center</span>\')
    ->add(\'<span>Right</span>\')
    ->render();

// Vertical flex
echo UiEngine::flex()
    ->direction(\'column\')
    ->gap(3) // Gap between items
    ->add(\'<div>Item 1</div>\')
    ->add(\'<div>Item 2</div>\')
    ->add(\'<div>Item 3</div>\')
    ->render();

// Centered content (perfect centering)
echo UiEngine::flex()
    ->justify(\'center\')
    ->align(\'center\')
    ->style(\'height: 200px\')
    ->add(\'<div>Perfectly Centered</div>\')
    ->render();'
    ],
    [
        'label' => 'Flex Properties',
        'language' => 'text',
        'code' => 'Direction:
direction(\'row\')         → Horizontal (default)
direction(\'row-reverse\') → Horizontal reversed
direction(\'column\')      → Vertical
direction(\'column-reverse\') → Vertical reversed

Justify (main axis):
justify(\'start\')    → Start
justify(\'end\')      → End
justify(\'center\')   → Center
justify(\'between\')  → Space between
justify(\'around\')   → Space around
justify(\'evenly\')   → Space evenly

Align (cross axis):
align(\'start\')      → Start
align(\'end\')        → End
align(\'center\')     → Center
align(\'baseline\')   → Baseline
align(\'stretch\')    → Stretch (default)

Wrap:
wrap()              → Enable wrapping
nowrap()            → Disable wrapping

Gap:
gap(3)              → Gap using spacing scale (0-5)'
    ],
]) ?>

<!-- Step 7: CSS Grid -->
<h2 id="step-7-css-grid" class="heading heading-2">
    <span class="mdi mdi-numeric-7-circle heading-icon"></span>
    <span class="heading-text">Step 7: CSS Grid Layouts</span>
</h2>

<p>
    The <code>Grid</code> element provides CSS Grid support for more complex layouts.
</p>

<?= codeTabs('step7', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Simple grid with 3 columns
echo UiEngine::grid()
    ->cols(3)
    ->gap(4)
    ->add(UiEngine::card(\'Card 1\'))
    ->add(UiEngine::card(\'Card 2\'))
    ->add(UiEngine::card(\'Card 3\'))
    ->add(UiEngine::card(\'Card 4\'))
    ->add(UiEngine::card(\'Card 5\'))
    ->add(UiEngine::card(\'Card 6\'))
    ->render();

// Responsive grid columns
echo UiEngine::grid()
    ->cols(1)          // 1 column on mobile
    ->colsSm(2)        // 2 columns on small
    ->colsMd(3)        // 3 columns on medium
    ->colsLg(4)        // 4 columns on large
    ->gap(3)
    ->add(\'Item 1\')
    ->add(\'Item 2\')
    ->add(\'Item 3\')
    ->add(\'Item 4\')
    ->render();'
    ],
    [
        'label' => 'Advanced Grid',
        'language' => 'php',
        'code' => '<?php
// Grid with custom template
echo UiEngine::grid()
    ->template(\'1fr 2fr 1fr\')  // Custom column widths
    ->rows(\'auto\')
    ->gap(4)
    ->add(\'<div class="so-bg-light so-p-3">Sidebar</div>\')
    ->add(\'<div class="so-bg-white so-p-3">Main Content</div>\')
    ->add(\'<div class="so-bg-light so-p-3">Sidebar</div>\')
    ->render();

// Grid with named areas
echo UiEngine::grid()
    ->areas([
        \'header header header\',
        \'sidebar main main\',
        \'footer footer footer\',
    ])
    ->rows(\'auto 1fr auto\')
    ->style(\'min-height: 100vh\')
    ->add(\'<header style="grid-area: header" class="so-bg-primary so-p-3">Header</header>\')
    ->add(\'<aside style="grid-area: sidebar" class="so-bg-light so-p-3">Sidebar</aside>\')
    ->add(\'<main style="grid-area: main" class="so-p-3">Main Content</main>\')
    ->add(\'<footer style="grid-area: footer" class="so-bg-dark so-text-white so-p-3">Footer</footer>\')
    ->render();'
    ],
]) ?>

<!-- Common Patterns -->
<h2 id="common-patterns" class="heading heading-2">
    <span class="mdi mdi-puzzle heading-icon"></span>
    <span class="heading-text">Common Patterns</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">Media Object</span>
</h3>

<?= codeBlock('php', '// Media object (image + content)
echo UiEngine::mediaObject()
    ->image(\'/images/avatar.jpg\', \'User avatar\')
    ->imageSize(\'64px\')
    ->title(\'John Doe\')
    ->body(\'This is the media object description.\')
    ->render();

// Reversed media object
echo UiEngine::mediaObject()
    ->image(\'/images/avatar.jpg\', \'User avatar\')
    ->title(\'Jane Smith\')
    ->body(\'Description text...\')
    ->reverse()
    ->render();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Empty State</span>
</h3>

<?= codeBlock('php', '// Empty state placeholder
echo UiEngine::emptyState()
    ->icon(\'inbox\')
    ->title(\'No items found\')
    ->description(\'There are no items to display. Create one to get started.\')
    ->action(\'Create Item\', \'/items/create\')
    ->render();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Loading Skeleton</span>
</h3>

<?= codeBlock('php', '// Loading skeleton
echo UiEngine::skeleton()
    ->type(\'card\')
    ->render();

// Text skeleton with multiple lines
echo UiEngine::skeleton()
    ->type(\'text\')
    ->lines(3)
    ->render();

// Avatar skeleton
echo UiEngine::skeleton()
    ->type(\'avatar\')
    ->render();') ?>

<!-- Troubleshooting -->
<h2 id="troubleshooting" class="heading heading-2">
    <span class="mdi mdi-help-circle heading-icon"></span>
    <span class="heading-text">Troubleshooting</span>
</h2>

<?= callout('warning', '
    <strong>Columns Not Aligning</strong><br>
    Ensure column widths add up to 12 in each row:
    <pre class="so-mb-0"><code>// Correct: 4 + 4 + 4 = 12
UiEngine::row()
    ->add(UiEngine::col(4)->add(...))
    ->add(UiEngine::col(4)->add(...))
    ->add(UiEngine::col(4)->add(...))</code></pre>
') ?>

<?= callout('warning', '
    <strong>Content Overflowing</strong><br>
    Use <code>fluid()</code> on containers for full-width layouts:
    <pre class="so-mb-0"><code>UiEngine::container()->fluid()->add(...)</code></pre>
') ?>

<?= callout('info', '
    <strong>See Also:</strong>
    <ul class="so-mb-0">
        <li><a href="/docs/dev-ui-engine">UiEngine Developer Guide</a></li>
        <li><a href="/docs/dev-ui-engine-elements">Element Reference</a></li>
        <li><a href="/docs/grid-system">Grid System Documentation</a></li>
    </ul>
') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
