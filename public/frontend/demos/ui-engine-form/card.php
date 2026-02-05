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

        $phpContent = $phpCards . '<div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';
        $jsContent = '<div class="so-grid so-grid-cols-1 so-grid-cols-md-2 so-grid-cols-lg-3 so-gap-4" id="js-basic-container"></div><div class="so-mt-4">' . so_code_block($jsCode, 'javascript') . '</div>';
        $htmlContent = so_code_block($htmlOutput, 'html');

        echo so_tabs('basic-card', [
            ['id' => 'php-basic', 'label' => 'PHP', 'icon' => 'data_object', 'active' => true, 'content' => $phpContent],
            ['id' => 'js-basic', 'label' => 'JavaScript', 'icon' => 'javascript', 'active' => false, 'content' => $jsContent],
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
        </script>
    </div>
</div>

<?php require_once '../includes/layout-end.php'; ?>
