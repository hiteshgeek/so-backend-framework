<?php
/**
 * UiEngine Card Component Demo
 * Demonstrating PHP and JavaScript implementations
 */

// Load config to access helper functions
require_once '../includes/config.php';

// Page configuration
$pageTitle = 'UiEngine - Card';
$pageSubtitle = 'Card component with dual architecture support';

// Load backend autoloader for UiEngine
require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
use Core\UiEngine\UiEngine;

// Get UI Engine JS path for scripts
$uiEngineJs = so_asset('js', 'ui-engine');

// Page scripts for JavaScript demos
$pageScripts = <<<SCRIPT
<script src="{$uiEngineJs}" type="module"></script>
<script>
const renderedDemos = new Set();

function renderDemo(containerId, cardConfig) {
    if (renderedDemos.has(containerId)) {
        return;
    }

    if (window.UiEngine) {
        const container = document.getElementById(containerId);
        if (container) {
            container.innerHTML = '';
            const cards = cardConfig(window.UiEngine);
            if (Array.isArray(cards)) {
                cards.forEach(card => container.appendChild(card));
            } else {
                container.appendChild(cards);
            }
            renderedDemos.add(containerId);
        }
    } else {
        setTimeout(() => renderDemo(containerId, cardConfig), 50);
    }
}

// Listen for tab activation
document.addEventListener('click', function(e) {
    const tabButton = e.target.closest('.so-tab');
    if (!tabButton) return;

    const targetId = tabButton.getAttribute('data-so-target');

    // Check if it's a JS tab
    if (targetId && targetId.startsWith('#js-')) {
        // Remove # and add -container
        const containerId = targetId.substring(1) + '-container';
        const configFn = window.cardConfigs[containerId];
        if (configFn) {
            setTimeout(() => renderDemo(containerId, configFn), 200);
        }
    }
});

// Initialize configs storage (preserve any already registered)
window.cardConfigs = window.cardConfigs || {};
</script>
SCRIPT;

// Start layout
require_once '../includes/layout-start.php';
?>

<!-- 1. Basic Cards -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">1. Basic Cards</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Simple card container with optional header, body, and footer. All sections accept nested elements using renderMixed() for flexible layouts.</p>
        <?php
        $phpCards = '<div class="so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-3 so-gap-4">';

        // Card 1: Card with title and button in header
        $phpCards .= UiEngine::card()
            ->header([
                UiEngine::html()->tag('h3')->addClass('so-card-title')->text('Card Title'),
                UiEngine::button()->iconOnly('more_vert')->variant('ghost')
            ])
            ->body(UiEngine::html()->tag('p')->text('This is a basic card with header and body sections.'))
            ->render();

        // Card 2: Simple card with body content and footer buttons
        $phpCards .= UiEngine::card()
            ->body([
                UiEngine::html()->tag('h4')->addClass('so-mb-2')->text('Simple Card'),
                UiEngine::html()->tag('p')->addClass('so-text-muted')->text('A card without the header section.')
            ])
            ->footer([
                UiEngine::button()->text('Cancel')->outline()->small(),
                UiEngine::button()->text('Save')->primary()->small()
            ])
            ->render();

        // Card 3: Card with title and badge in header
        $phpCards .= UiEngine::card()
            ->header([
                UiEngine::html()->tag('h3')->addClass('so-card-title')->text('With Badge'),
                UiEngine::badge()->text('New')->soft()->primary()
            ])
            ->body(UiEngine::html()->tag('p')->text('Card header with a badge indicator.'))
            ->render();

        $phpCards .= '</div>';

        $phpCode = <<<'PHP'
// Card with title and button in header
UiEngine::card()
    ->header([
        UiEngine::html()->tag('h3')->addClass('so-card-title')->text('Card Title'),
        UiEngine::button()->iconOnly('more_vert')->variant('ghost')
    ])
    ->body(UiEngine::html()->tag('p')->text('This is a basic card with header and body sections.'))
    ->render();

// Simple card with body and footer
UiEngine::card()
    ->body([
        UiEngine::html()->tag('h4')->addClass('so-mb-2')->text('Simple Card'),
        UiEngine::html()->tag('p')->addClass('so-text-muted')->text('A card without the header section.')
    ])
    ->footer([
        UiEngine::button()->text('Cancel')->outline()->small(),
        UiEngine::button()->text('Save')->primary()->small()
    ])
    ->render();

// Card with title and badge
UiEngine::card()
    ->header([
        UiEngine::html()->tag('h3')->addClass('so-card-title')->text('With Badge'),
        UiEngine::badge()->text('New')->soft()->primary()
    ])
    ->body(UiEngine::html()->tag('p')->text('Card header with a badge indicator.'))
    ->render();
PHP;

        $jsCode = <<<'JS'
// Card with title and button in header
UiEngine.card()
    .header([
        UiEngine.html().tag('h3').addClass('so-card-title').text('Card Title'),
        UiEngine.button().iconOnly('more_vert').variant('ghost')
    ])
    .body(UiEngine.html().tag('p').text('This is a basic card with header and body sections.'))
    .render();

// Simple card with body and footer
UiEngine.card()
    .body([
        UiEngine.html().tag('h4').addClass('so-mb-2').text('Simple Card'),
        UiEngine.html().tag('p').addClass('so-text-muted').text('A card without the header section.')
    ])
    .footer([
        UiEngine.button().text('Cancel').outline().small(),
        UiEngine.button().text('Save').primary().small()
    ])
    .render();

// Card with title and badge
UiEngine.card()
    .header([
        UiEngine.html().tag('h3').addClass('so-card-title').text('With Badge'),
        UiEngine.badge().text('New').soft().primary()
    ])
    .body(UiEngine.html().tag('p').text('Card header with a badge indicator.'))
    .render();
JS;

        $htmlOutput = <<<'HTML'
<div class="so-card">
    <div class="so-card-header">
        <h3 class="so-card-title">Card Title</h3>
        <button class="so-btn so-btn-icon so-btn-ghost">
            <span class="material-icons">more_vert</span>
        </button>
    </div>
    <div class="so-card-body">
        <p>This is a basic card with header and body sections.</p>
    </div>
</div>

<div class="so-card">
    <div class="so-card-body">
        <h4 class="so-mb-2">Simple Card</h4>
        <p class="so-text-muted">A card without the header section.</p>
    </div>
    <div class="so-card-footer">
        <button class="so-btn so-btn-outline so-btn-sm">Cancel</button>
        <button class="so-btn so-btn-primary so-btn-sm">Save</button>
    </div>
</div>

<div class="so-card">
    <div class="so-card-header">
        <h3 class="so-card-title">With Badge</h3>
        <span class="so-badge so-badge-soft-primary">New</span>
    </div>
    <div class="so-card-body">
        <p>Card header with a badge indicator.</p>
    </div>
</div>
HTML;

        // Generate PHP Config cards - matching exact structure of fluent API cards
        $phpConfigCards = '<div class="so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-3 so-gap-4">';

        // Card 1: Card with title and button in header (using fromConfig for child elements)
        $phpConfigCards .= UiEngine::card()
            ->header([
                UiEngine::fromConfig(['type' => 'html', 'tag' => 'h3', 'class' => 'so-card-title', 'textContent' => 'Card Title']),
                UiEngine::button()->iconOnly('more_vert')->variant('ghost')
            ])
            ->body(UiEngine::fromConfig(['type' => 'html', 'tag' => 'p', 'textContent' => 'This is a basic card with header and body sections.']))
            ->render();

        // Card 2: Simple card with body content and footer buttons
        $phpConfigCards .= UiEngine::card()
            ->body([
                UiEngine::fromConfig(['type' => 'html', 'tag' => 'h4', 'class' => 'so-mb-2', 'textContent' => 'Simple Card']),
                UiEngine::fromConfig(['type' => 'html', 'tag' => 'p', 'class' => 'so-text-muted', 'textContent' => 'A card without the header section.'])
            ])
            ->footer([
                UiEngine::button()->text('Cancel')->outline()->small(),
                UiEngine::button()->text('Save')->primary()->small()
            ])
            ->render();

        // Card 3: Card with title and badge in header
        $phpConfigCards .= UiEngine::card()
            ->header([
                UiEngine::fromConfig(['type' => 'html', 'tag' => 'h3', 'class' => 'so-card-title', 'textContent' => 'With Badge']),
                UiEngine::badge()->text('New')->soft()->primary()
            ])
            ->body(UiEngine::fromConfig(['type' => 'html', 'tag' => 'p', 'textContent' => 'Card header with a badge indicator.']))
            ->render();

        $phpConfigCards .= '</div>';

        $phpConfigCode = <<<'PHP'
// Card 1: Hybrid approach - card structure with config-based children
UiEngine::card()
    ->header([
        UiEngine::fromConfig(['type' => 'html', 'tag' => 'h3', 'class' => 'so-card-title', 'textContent' => 'Card Title']),
        UiEngine::button()->iconOnly('more_vert')->variant('ghost')
    ])
    ->body(UiEngine::fromConfig(['type' => 'html', 'tag' => 'p', 'textContent' => 'This is a basic card with header and body sections.']))
    ->render();

// Card 2: Body with config-based elements
UiEngine::card()
    ->body([
        UiEngine::fromConfig(['type' => 'html', 'tag' => 'h4', 'class' => 'so-mb-2', 'textContent' => 'Simple Card']),
        UiEngine::fromConfig(['type' => 'html', 'tag' => 'p', 'class' => 'so-text-muted', 'textContent' => 'A card without the header section.'])
    ])
    ->footer([
        UiEngine::button()->text('Cancel')->outline()->small(),
        UiEngine::button()->text('Save')->primary()->small()
    ])
    ->render();

// Card 3: Header with badge from config
UiEngine::card()
    ->header([
        UiEngine::fromConfig(['type' => 'html', 'tag' => 'h3', 'class' => 'so-card-title', 'textContent' => 'With Badge']),
        UiEngine::badge()->text('New')->soft()->primary()
    ])
    ->body(UiEngine::fromConfig(['type' => 'html', 'tag' => 'p', 'textContent' => 'Card header with a badge indicator.']))
    ->render();
PHP;

        $jsConfigCode = <<<'JS'
// Card with title and button in header (config-based)
const config1 = {
    type: 'card',
    header: [
        {type: 'html', tag: 'h3', class: 'so-card-title', textContent: 'Card Title'},
        {type: 'button', iconOnly: 'more_vert', variant: 'ghost'}
    ],
    body: {type: 'html', tag: 'p', textContent: 'This is a basic card with header and body sections.'}
};

// Simple card with body and footer (config-based)
const config2 = {
    type: 'card',
    body: [
        {type: 'html', tag: 'h4', class: 'so-mb-2', textContent: 'Simple Card'},
        {type: 'html', tag: 'p', class: 'so-text-muted', textContent: 'A card without the header section.'}
    ],
    footer: [
        {type: 'button', text: 'Cancel', outline: true, small: true},
        {type: 'button', text: 'Save', variant: 'primary', small: true}
    ]
};

// Card with title and badge (config-based)
const config3 = {
    type: 'card',
    header: [
        {type: 'html', tag: 'h3', class: 'so-card-title', textContent: 'With Badge'},
        {type: 'badge', text: 'New', soft: true, variant: 'primary'}
    ],
    body: {type: 'html', tag: 'p', textContent: 'Card header with a badge indicator.'}
};

// Render to container
const container = document.getElementById('container');
container.appendChild(UiEngine.fromConfig(config1).render());
container.appendChild(UiEngine.fromConfig(config2).render());
container.appendChild(UiEngine.fromConfig(config3).render());
JS;

        $phpContent = $phpCards . '<div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';
        $phpConfigContent = $phpConfigCards . '<div class="so-mt-4">' . so_code_block($phpConfigCode, 'php') . '</div>';
        $jsContent = '<div class="so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-3 so-gap-4" id="js-basic-container"></div><div class="so-mt-4">' . so_code_block($jsCode, 'javascript') . '</div>';
        $jsConfigContent = '<div class="so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-3 so-gap-4" id="js-config-basic-container"></div><div class="so-mt-4">' . so_code_block($jsConfigCode, 'javascript') . '</div>';
        $htmlContent = so_code_block($htmlOutput, 'html');

        echo so_tabs('basic-card', [
            ['id' => 'php-basic', 'label' => 'PHP', 'icon' => 'data_object', 'active' => true, 'content' => $phpContent],
            ['id' => 'php-config-basic', 'label' => 'PHP Config', 'icon' => 'settings', 'active' => false, 'content' => $phpConfigContent],
            ['id' => 'js-basic', 'label' => 'JavaScript', 'icon' => 'javascript', 'active' => false, 'content' => $jsContent],
            ['id' => 'js-config-basic', 'label' => 'JS Config', 'icon' => 'settings', 'active' => false, 'content' => $jsConfigContent],
            ['id' => 'html-basic', 'label' => 'HTML Output', 'icon' => 'code', 'active' => false, 'content' => $htmlContent]
        ]);
        ?>
        <script>
        window.cardConfigs = window.cardConfigs || {};
        window.cardConfigs['js-basic-container'] = (UiEngine) => {
            // Card 1: Card with title and button in header
            const card1 = UiEngine.card()
                .header([
                    UiEngine.html().tag('h3').addClass('so-card-title').text('Card Title'),
                    UiEngine.button().iconOnly('more_vert').variant('ghost')
                ])
                .body(UiEngine.html().tag('p').text('This is a basic card with header and body sections.'))
                .render();

            // Card 2: Simple card with body and footer
            const card2 = UiEngine.card()
                .body([
                    UiEngine.html().tag('h4').addClass('so-mb-2').text('Simple Card'),
                    UiEngine.html().tag('p').addClass('so-text-muted').text('A card without the header section.')
                ])
                .footer([
                    UiEngine.button().text('Cancel').outline().small(),
                    UiEngine.button().text('Save').primary().small()
                ])
                .render();

            // Card 3: Card with title and badge
            const card3 = UiEngine.card()
                .header([
                    UiEngine.html().tag('h3').addClass('so-card-title').text('With Badge'),
                    UiEngine.badge().text('New').soft().primary()
                ])
                .body(UiEngine.html().tag('p').text('Card header with a badge indicator.'))
                .render();

            return [card1, card2, card3];
        };

        // JS Config Basic Cards
        window.cardConfigs['js-config-basic-container'] = function(UiEngine) {
            // Card 1: Config-based card with header and button
            const config1 = {
                type: 'card',
                header: [
                    {type: 'html', tag: 'h3', class: 'so-card-title', textContent: 'Card Title'},
                    {type: 'button', iconOnly: 'more_vert', variant: 'ghost'}
                ],
                body: {type: 'html', tag: 'p', textContent: 'This is a basic card with header and body sections.'}
            };

            // Card 2: Config-based card with body and footer
            const config2 = {
                type: 'card',
                body: [
                    {type: 'html', tag: 'h4', class: 'so-mb-2', textContent: 'Simple Card'},
                    {type: 'html', tag: 'p', class: 'so-text-muted', textContent: 'A card without the header section.'}
                ],
                footer: [
                    {type: 'button', text: 'Cancel', outline: true, small: true},
                    {type: 'button', text: 'Save', variant: 'primary', small: true}
                ]
            };

            // Card 3: Config-based card with badge
            const config3 = {
                type: 'card',
                header: [
                    {type: 'html', tag: 'h3', class: 'so-card-title', textContent: 'With Badge'},
                    {type: 'badge', text: 'New', soft: true, variant: 'primary'}
                ],
                body: {type: 'html', tag: 'p', textContent: 'Card header with a badge indicator.'}
            };

            return [
                UiEngine.fromConfig(config1).render(),
                UiEngine.fromConfig(config2).render(),
                UiEngine.fromConfig(config3).render()
            ];
        };
        </script>
    </div>
</div>

<!-- 2. Stats Cards -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">2. Stats Cards</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Dashboard-style stats cards built with nested UiEngine components. Perfect for KPI displays and metrics.</p>
        <?php
        // Helper function to create a stats card
        function createStatsCard($label, $value, $trend, $trendText, $icon, $iconColor) {
            return UiEngine::card()
                ->addClass('so-card-padded')
                // Header row: Label + Icon badge
                ->add(
                    UiEngine::html()->tag('div')
                        ->addClass('so-d-flex so-justify-content-between so-align-items-center so-mb-2')
                        ->add(
                            UiEngine::html()->tag('span')
                                ->addClass('so-text-muted so-fs-xs so-text-uppercase so-fw-medium')
                                ->text($label)
                        )
                        ->add(
                            UiEngine::html()->tag('span')
                                ->addClass('so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-' . $iconColor . '-subtle so-w-8 so-h-8')
                                ->add(
                                    UiEngine::html()->tag('span')
                                        ->addClass('material-icons so-text-' . $iconColor . ' so-fs-lg')
                                        ->text($icon)
                                )
                        )
                )
                // Value
                ->add(
                    UiEngine::html()->tag('div')
                        ->addClass('so-fs-2xl so-fw-medium so-mb-1')
                        ->text($value)
                )
                // Trend
                ->add(
                    UiEngine::html()->tag('div')
                        ->addClass('so-d-flex so-align-items-center so-gap-1')
                        ->add(
                            UiEngine::html()->tag('span')
                                ->addClass('material-icons so-text-' . $trend . ' so-fs-base')
                                ->text($trend === 'success' ? 'arrow_upward' : 'arrow_downward')
                        )
                        ->add(
                            UiEngine::html()->tag('span')
                                ->addClass('so-text-' . $trend . ' so-fs-xs so-fw-medium')
                                ->text($trendText)
                        )
                );
        }

        $phpStats = UiEngine::html()->tag('div')
            ->addClass('so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-4 so-gap-3')
            ->add(createStatsCard('Total Sales', '₹12,45,890', 'success', '12.5% from last month', 'trending_up', 'info'))
            ->add(createStatsCard('Total Purchase', '₹8,34,560', 'danger', '3.2% from last month', 'shopping_cart', 'danger'))
            ->add(createStatsCard('Pending Orders', '47', 'success', '8 new today', 'pending_actions', 'warning'))
            ->add(createStatsCard('Active Customers', '1,284', 'success', '24 new this week', 'people', 'success'))
            ->render();

        // PHP Code Example
        $phpCode = <<<'PHP'
// Helper function to create stats cards
function createStatsCard($label, $value, $trend, $trendText, $icon, $iconColor) {
    return UiEngine::card()
        ->addClass('so-card-padded')
        // Header: Label + Icon
        ->add(
            UiEngine::html()->tag('div')
                ->addClass('so-d-flex so-justify-content-between so-align-items-center so-mb-2')
                ->add(
                    UiEngine::html()->tag('span')
                        ->addClass('so-text-muted so-fs-xs so-text-uppercase so-fw-medium')
                        ->text($label)
                )
                ->add(
                    UiEngine::html()->tag('span')
                        ->addClass('so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-' . $iconColor . '-subtle so-w-8 so-h-8')
                        ->add(
                            UiEngine::html()->tag('span')
                                ->addClass('material-icons so-text-' . $iconColor . ' so-fs-lg')
                                ->text($icon)
                        )
                )
        )
        // Value
        ->add(
            UiEngine::html()->tag('div')
                ->addClass('so-fs-2xl so-fw-medium so-mb-1')
                ->text($value)
        )
        // Trend
        ->add(
            UiEngine::html()->tag('div')
                ->addClass('so-d-flex so-align-items-center so-gap-1')
                ->add(
                    UiEngine::html()->tag('span')
                        ->addClass('material-icons so-text-' . $trend . ' so-fs-base')
                        ->text($trend === 'success' ? 'arrow_upward' : 'arrow_downward')
                )
                ->add(
                    UiEngine::html()->tag('span')
                        ->addClass('so-text-' . $trend . ' so-fs-xs so-fw-medium')
                        ->text($trendText)
                )
        );
}

// Create stats cards grid
$stats = UiEngine::html()->tag('div')
    ->addClass('so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-4 so-gap-3')
    ->add(createStatsCard('Total Sales', '₹12,45,890', 'success', '12.5% from last month', 'trending_up', 'info'))
    ->add(createStatsCard('Total Purchase', '₹8,34,560', 'danger', '3.2% from last month', 'shopping_cart', 'danger'))
    ->add(createStatsCard('Pending Orders', '47', 'success', '8 new today', 'pending_actions', 'warning'))
    ->add(createStatsCard('Active Customers', '1,284', 'success', '24 new this week', 'people', 'success'))
    ->render();

echo $stats;
PHP;

        // JavaScript Code Example
        $jsCode = <<<'JAVASCRIPT'
// Helper function to create stats cards
function createStatsCard(label, value, trend, trendText, icon, iconColor) {
    return UiEngine.card()
        .addClass('so-card-padded')
        // Header: Label + Icon
        .add(
            UiEngine.html().tag('div')
                .addClass('so-d-flex so-justify-content-between so-align-items-center so-mb-2')
                .add(
                    UiEngine.html().tag('span')
                        .addClass('so-text-muted so-fs-xs so-text-uppercase so-fw-medium')
                        .text(label)
                )
                .add(
                    UiEngine.html().tag('span')
                        .addClass('so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-' + iconColor + '-subtle so-w-8 so-h-8')
                        .add(
                            UiEngine.html().tag('span')
                                .addClass('material-icons so-text-' + iconColor + ' so-fs-lg')
                                .text(icon)
                        )
                )
        )
        // Value
        .add(
            UiEngine.html().tag('div')
                .addClass('so-fs-2xl so-fw-medium so-mb-1')
                .text(value)
        )
        // Trend
        .add(
            UiEngine.html().tag('div')
                .addClass('so-d-flex so-align-items-center so-gap-1')
                .add(
                    UiEngine.html().tag('span')
                        .addClass('material-icons so-text-' + trend + ' so-fs-base')
                        .text(trend === 'success' ? 'arrow_upward' : 'arrow_downward')
                )
                .add(
                    UiEngine.html().tag('span')
                        .addClass('so-text-' + trend + ' so-fs-xs so-fw-medium')
                        .text(trendText)
                )
        );
}

// Create stats cards
const stats = [
    createStatsCard('Total Sales', '₹12,45,890', 'success', '12.5% from last month', 'trending_up', 'info'),
    createStatsCard('Total Purchase', '₹8,34,560', 'danger', '3.2% from last month', 'shopping_cart', 'danger'),
    createStatsCard('Pending Orders', '47', 'success', '8 new today', 'pending_actions', 'warning'),
    createStatsCard('Active Customers', '1,284', 'success', '24 new this week', 'people', 'success')
];
JAVASCRIPT;

        // HTML Output Example
        $htmlOutput = <<<'HTML'
<div class="so-card so-card-padded">
    <div class="so-d-flex so-justify-content-between so-align-items-center so-mb-2">
        <span class="so-text-muted so-fs-xs so-text-uppercase so-fw-medium">Total Sales</span>
        <span class="so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-info-subtle so-w-8 so-h-8">
            <span class="material-icons so-text-info so-fs-lg">trending_up</span>
        </span>
    </div>
    <div class="so-fs-2xl so-fw-medium so-mb-1">₹12,45,890</div>
    <div class="so-d-flex so-align-items-center so-gap-1">
        <span class="material-icons so-text-success so-fs-base">arrow_upward</span>
        <span class="so-text-success so-fs-xs so-fw-medium">12.5% from last month</span>
    </div>
</div>

<!-- Utility Classes Used:
     Card: so-card-padded (compact padding)
     Label: so-fs-xs, so-text-uppercase, so-fw-medium, so-text-muted
     Icon Container: so-w-8 so-h-8 (32px), so-rounded-full, so-bg-{color}-subtle
     Value: so-fs-2xl (24px), so-fw-medium
     Trend: so-fs-xs, so-fw-medium, so-text-{success|danger}
-->
HTML;

        $phpContent = $phpStats . '<div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';
        $jsContent = '<div class="so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-4 so-gap-3" id="js-stats-container"></div><div class="so-mt-4">' . so_code_block($jsCode, 'javascript') . '</div>';
        $htmlContent = so_code_block($htmlOutput, 'html');

        echo so_tabs('stats-card', [
            ['id' => 'php-stats', 'label' => 'PHP', 'icon' => 'data_object', 'active' => true, 'content' => $phpContent],
            ['id' => 'js-stats', 'label' => 'JavaScript', 'icon' => 'javascript', 'active' => false, 'content' => $jsContent],
            ['id' => 'html-stats', 'label' => 'HTML Output', 'icon' => 'code', 'active' => false, 'content' => $htmlContent]
        ]);
        ?>
        <script>
        window.cardConfigs['js-stats-container'] = (UiEngine) => {
            // Helper function to create stats cards
            function createStatsCard(label, value, trend, trendText, icon, iconColor) {
                return UiEngine.card()
                    .addClass('so-card-padded')
                    // Header: Label + Icon
                    .add(
                        UiEngine.html().tag('div')
                            .addClass('so-d-flex so-justify-content-between so-align-items-center so-mb-2')
                            .add(
                                UiEngine.html().tag('span')
                                    .addClass('so-text-muted so-fs-xs so-text-uppercase so-fw-medium')
                                    .text(label)
                            )
                            .add(
                                UiEngine.html().tag('span')
                                    .addClass('so-d-flex so-align-items-center so-justify-content-center so-rounded-full so-bg-' + iconColor + '-subtle so-w-8 so-h-8')
                                    .add(
                                        UiEngine.html().tag('span')
                                            .addClass('material-icons so-text-' + iconColor + ' so-fs-lg')
                                            .text(icon)
                                    )
                            )
                    )
                    // Value
                    .add(
                        UiEngine.html().tag('div')
                            .addClass('so-fs-2xl so-fw-medium so-mb-1')
                            .text(value)
                    )
                    // Trend
                    .add(
                        UiEngine.html().tag('div')
                            .addClass('so-d-flex so-align-items-center so-gap-1')
                            .add(
                                UiEngine.html().tag('span')
                                    .addClass('material-icons so-text-' + trend + ' so-fs-base')
                                    .text(trend === 'success' ? 'arrow_upward' : 'arrow_downward')
                            )
                            .add(
                                UiEngine.html().tag('span')
                                    .addClass('so-text-' + trend + ' so-fs-xs so-fw-medium')
                                    .text(trendText)
                            )
                    ).render();
            }

            // Create stats cards
            return [
                createStatsCard('Total Sales', '₹12,45,890', 'success', '12.5% from last month', 'trending_up', 'info'),
                createStatsCard('Total Purchase', '₹8,34,560', 'danger', '3.2% from last month', 'shopping_cart', 'danger'),
                createStatsCard('Pending Orders', '47', 'success', '8 new today', 'pending_actions', 'warning'),
                createStatsCard('Active Customers', '1,284', 'success', '24 new this week', 'people', 'success')
            ];
        };
        </script>
    </div>
</div>

<?php require_once '../includes/layout-end.php'; ?>
