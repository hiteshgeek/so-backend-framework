<?php
/**
 * JavaScript UiEngine Component Test
 * Testing Card component - PHP vs JS comparison
 */

$pageTitle = 'JS UiEngine - Card Test';
$pageDescription = 'Testing Card component rendering with JavaScript UiEngine';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';

// Load UI Engine CSS
echo '<link rel="stylesheet" href="' . so_asset('css', 'ui-engine') . '">';
?>

<main class="so-main-content">
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">JavaScript UiEngine - Card Component</h1>
            <p class="so-page-subtitle">Client-side rendering using JavaScript UiEngine</p>
        </div>
    </div>

    <div class="so-page-body">

        <!-- Simple Cards -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h5 class="so-mb-0">Simple Cards</h5>
            </div>
            <div class="so-card-body">
                <div class="so-row">
                    <div class="so-col-md-6" id="card1"></div>
                    <div class="so-col-md-6" id="card2"></div>
                </div>
            </div>
        </div>

        <!-- Complex Card -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h5 class="so-mb-0">Complex Card</h5>
            </div>
            <div class="so-card-body" id="card3"></div>
        </div>

        <!-- HTML Source -->
        <div class="so-card">
            <div class="so-card-header">
                <h5 class="so-mb-0">Generated HTML (JavaScript)</h5>
            </div>
            <div class="so-card-body">
                <pre class="so-bg-light so-p-3 so-rounded" style="overflow-x: auto;"><code id="htmlSource"></code></pre>
            </div>
        </div>

    </div>
</main>

<?php require_once '../includes/footer.php'; ?>

<script type="module">
import('/frontend/dist/js/ui-engine.js').then(module => {
    const UiEngine = module.default;
    window.UiEngine = UiEngine;

    // Card 1: Simple card
    const card1 = UiEngine.card()
        .header('Card Header')
        .title('Card Title')
        .text('This is a card created using JavaScript UiEngine.')
        .footer('Card Footer');
    document.getElementById('card1').appendChild(card1.render());

    // Card 2: Card with image
    const card2 = UiEngine.card()
        .image('https://via.placeholder.com/300x200', 'Card image')
        .title('Card with Image')
        .text('This card includes an image.');

    // Add button to card
    card2.add(
        UiEngine.button('Learn More')
            .href('#')
            .variant('primary')
    );

    document.getElementById('card2').appendChild(card2.render());

    // Card 3: Complex card
    const card3 = UiEngine.card()
        .variant('primary')
        .header('Featured Card')
        .title('Complex Example')
        .subtitle('With subtitle')
        .text('Card with multiple features.')
        .footer('Last updated 3 mins ago');
    document.getElementById('card3').appendChild(card3.render());

    // HTML Source
    const sourceCard = UiEngine.card()
        .header('Card Header')
        .title('Card Title')
        .text('Sample text.')
        .footer('Card Footer');
    document.getElementById('htmlSource').textContent = sourceCard.toHtml();
}).catch(error => {
    console.error('Failed to load UiEngine:', error);
});
</script>
