<?php
/**
 * PHP UiEngine Component Test
 * Testing Card component - PHP vs JS comparison
 */

$pageTitle = 'PHP UiEngine - Card Test';
$pageDescription = 'Testing Card component rendering with PHP UiEngine';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';

// Load UI Engine CSS
echo '<link rel="stylesheet" href="' . so_asset('css', 'ui-engine') . '">';

// Load backend autoloader for UiEngine
require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
use Core\UiEngine\UiEngine;
?>

<main class="so-main-content">
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">PHP UiEngine - Card Component</h1>
            <p class="so-page-subtitle">Server-side rendering using PHP UiEngine</p>
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
                    <div class="so-col-md-6">
                        <?php
                        echo UiEngine::card()
                            ->header('Card Header')
                            ->title('Card Title')
                            ->bodyText('This is a card created using PHP UiEngine.')
                            ->footer('Card Footer')
                            ->render();
                        ?>
                    </div>
                    <div class="so-col-md-6">
                        <?php
                        $card = UiEngine::card()
                            ->image('https://via.placeholder.com/300x200', 'Card image')
                            ->title('Card with Image')
                            ->bodyText('This card includes an image.');

                        // Add button to card body
                        $card->add(
                            UiEngine::button('Learn More')
                                ->href('#')
                                ->variant('primary')
                        );

                        echo $card->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complex Card -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h5 class="so-mb-0">Complex Card</h5>
            </div>
            <div class="so-card-body">
                <?php
                echo UiEngine::card()
                    ->variant('primary')
                    ->header('Featured Card')
                    ->title('Complex Example')
                    ->subtitle('With subtitle')
                    ->bodyText('Card with multiple features.')
                    ->footer('Last updated 3 mins ago')
                    ->render();
                ?>
            </div>
        </div>

        <!-- HTML Source -->
        <div class="so-card">
            <div class="so-card-header">
                <h5 class="so-mb-0">Generated HTML (PHP)</h5>
            </div>
            <div class="so-card-body">
                <pre class="so-bg-light so-p-3 so-rounded" style="overflow-x: auto;"><code><?php
                $card = UiEngine::card()
                    ->header('Card Header')
                    ->title('Card Title')
                    ->bodyText('Sample text.')
                    ->footer('Card Footer');
                echo htmlspecialchars($card->render());
                ?></code></pre>
            </div>
        </div>

    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
