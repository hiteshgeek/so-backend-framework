<?php
/**
 * SixOrbit UI Engine - Card Element Demo
 */

$pageTitle = 'Card - UI Engine';
$pageDescription = 'Flexible content container with header, body, and footer';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Card</h1>
            <p class="so-page-subtitle">Flexible content container with optional header, body, footer, and image support.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Card -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Card</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1 so-gap-4 so-mb-4">
                    <div class="so-card">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Card Title</h3>
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
                            <button class="so-btn so-btn-primary so-btn-sm">Save</button>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-card', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$card = UiEngine::card()
    ->header('Card Title')
    ->body('This is a basic card with header and body sections.');

echo \$card->render();

// Card with title and footer
\$card2 = UiEngine::card()
    ->title('Simple Card')
    ->body('A card without the header section.')
    ->footer('Card footer');

echo \$card2->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const card = UiEngine.card()
    .header('Card Title')
    .body('This is a basic card with header and body sections.');

document.getElementById('container').innerHTML = card.toHtml();

// Card with title and footer
const card2 = UiEngine.card()
    .title('Simple Card')
    .body('A card without the header section.')
    .footer('Card footer');

document.getElementById('container').innerHTML += card2.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-card">
    <div class="so-card-header">
        <h3 class="so-card-title">Card Title</h3>
    </div>
    <div class="so-card-body">
        <p>This is a basic card with header and body sections.</p>
    </div>
</div>

<div class="so-card">
    <div class="so-card-body">
        <h5 class="so-card-title">Simple Card</h5>
        <p class="so-card-text">A card without the header section.</p>
    </div>
    <div class="so-card-footer">Card footer</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Card Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Card Styles</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Different visual styles for cards.</p>
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-4 so-mb-4">
                    <div class="so-card">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Default</h3>
                        </div>
                        <div class="so-card-body">
                            <p class="so-text-muted so-text-sm">Standard card with shadow.</p>
                        </div>
                    </div>

                    <div class="so-card so-card-bordered">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Bordered</h3>
                        </div>
                        <div class="so-card-body">
                            <p class="so-text-muted so-text-sm">Card with border, no shadow.</p>
                        </div>
                    </div>

                    <div class="so-card so-card-flat">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Flat</h3>
                        </div>
                        <div class="so-card-body">
                            <p class="so-text-muted so-text-sm">No shadow, no border.</p>
                        </div>
                    </div>

                    <div class="so-card so-card-elevated">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Elevated</h3>
                        </div>
                        <div class="so-card-body">
                            <p class="so-text-muted so-text-sm">Larger shadow for emphasis.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('card-styles', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Default card
UiEngine::card()->title('Default')->body('Standard card with shadow.');

// Bordered card (border, no shadow)
UiEngine::card()->bordered()->title('Bordered')->body('Card with border.');

// Flat card (no shadow, no border)
UiEngine::card()->flat()->title('Flat')->body('No shadow, no border.');

// Elevated card (larger shadow)
UiEngine::card()->elevated()->title('Elevated')->body('Larger shadow.');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Default card
UiEngine.card().title('Default').body('Standard card.').toHtml();

// Bordered card
UiEngine.card().bordered().title('Bordered').body('Card with border.').toHtml();

// Flat card
UiEngine.card().flat().title('Flat').body('No shadow, no border.').toHtml();

// Elevated card
UiEngine.card().elevated().title('Elevated').body('Larger shadow.').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Default -->
<div class="so-card">...</div>

<!-- Bordered -->
<div class="so-card so-card-bordered">...</div>

<!-- Flat -->
<div class="so-card so-card-flat">...</div>

<!-- Elevated -->
<div class="so-card so-card-elevated">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Border Color Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Border Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Apply contextual border colors to cards.</p>
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-4 so-mb-4">
                    <div class="so-card so-card-border-primary">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Primary</h3>
                        </div>
                        <div class="so-card-body">
                            <p class="so-text-sm">Primary border color.</p>
                        </div>
                    </div>
                    <div class="so-card so-card-border-success">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Success</h3>
                        </div>
                        <div class="so-card-body">
                            <p class="so-text-sm">Success border color.</p>
                        </div>
                    </div>
                    <div class="so-card so-card-border-danger">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Danger</h3>
                        </div>
                        <div class="so-card-body">
                            <p class="so-text-sm">Danger border color.</p>
                        </div>
                    </div>
                    <div class="so-card so-card-border-warning">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Warning</h3>
                        </div>
                        <div class="so-card-body">
                            <p class="so-text-sm">Warning border color.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('card-border', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::card()->variant('primary')->title('Primary')->body('Primary border.');
UiEngine::card()->variant('success')->title('Success')->body('Success border.');
UiEngine::card()->variant('danger')->title('Danger')->body('Danger border.');
UiEngine::card()->variant('warning')->title('Warning')->body('Warning border.');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.card().variant('primary').title('Primary').body('Primary border.').toHtml();
UiEngine.card().variant('success').title('Success').body('Success border.').toHtml();
UiEngine.card().variant('danger').title('Danger').body('Danger border.').toHtml();
UiEngine.card().variant('warning').title('Warning').body('Warning border.').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-card so-card-border-primary">...</div>
<div class="so-card so-card-border-success">...</div>
<div class="so-card so-card-border-danger">...</div>
<div class="so-card so-card-border-warning">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Header Color Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Header Color Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Add colored backgrounds to card headers.</p>
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-grid-cols-md-2 so-grid-cols-sm-1 so-gap-4 so-mb-4">
                    <div class="so-card so-card-header-primary">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Primary Header</h3>
                        </div>
                        <div class="so-card-body">
                            <p>Card with primary header.</p>
                        </div>
                    </div>
                    <div class="so-card so-card-header-soft-primary">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Soft Primary</h3>
                        </div>
                        <div class="so-card-body">
                            <p>Card with soft primary header.</p>
                        </div>
                    </div>
                    <div class="so-card so-card-header-success">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Success Header</h3>
                        </div>
                        <div class="so-card-body">
                            <p>Card with success header.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('card-header-color', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Solid header color
UiEngine::card()
    ->headerColor('primary')
    ->header('Primary Header')
    ->body('Card with primary header.');

// Soft header color
UiEngine::card()
    ->headerColor('primary', true)  // true = soft
    ->header('Soft Primary')
    ->body('Card with soft primary header.');

// Success header
UiEngine::card()
    ->headerColor('success')
    ->header('Success Header')
    ->body('Card with success header.');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Solid header color
UiEngine.card()
    .headerColor('primary')
    .header('Primary Header')
    .body('Card with primary header.')
    .toHtml();

// Soft header color
UiEngine.card()
    .headerColor('primary', true)
    .header('Soft Primary')
    .body('Card with soft primary header.')
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Solid header -->
<div class="so-card so-card-header-primary">
    <div class="so-card-header">
        <h3 class="so-card-title">Primary Header</h3>
    </div>
    <div class="so-card-body">...</div>
</div>

<!-- Soft header -->
<div class="so-card so-card-header-soft-primary">
    <div class="so-card-header">
        <h3 class="so-card-title">Soft Primary</h3>
    </div>
    <div class="so-card-body">...</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Spacing Modes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Spacing Modes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Three spacing modes: compact, default, and spacious.</p>
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1 so-gap-4 so-mb-4">
                    <div class="so-card so-card-compact">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Compact</h3>
                        </div>
                        <div class="so-card-body">
                            <p>Minimal padding for dense layouts.</p>
                        </div>
                    </div>
                    <div class="so-card">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Default</h3>
                        </div>
                        <div class="so-card-body">
                            <p>Standard padding for most use cases.</p>
                        </div>
                    </div>
                    <div class="so-card so-card-spacious">
                        <div class="so-card-header">
                            <h3 class="so-card-title">Spacious</h3>
                        </div>
                        <div class="so-card-body">
                            <p>Extra breathing room for featured content.</p>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('card-spacing', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Compact spacing
UiEngine::card()->compact()->title('Compact')->body('Minimal padding.');

// Default spacing (no modifier needed)
UiEngine::card()->title('Default')->body('Standard padding.');

// Spacious spacing
UiEngine::card()->spacious()->title('Spacious')->body('Extra breathing room.');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Compact spacing
UiEngine.card().compact().title('Compact').body('Minimal padding.').toHtml();

// Default spacing
UiEngine.card().title('Default').body('Standard padding.').toHtml();

// Spacious spacing
UiEngine.card().spacious().title('Spacious').body('Extra breathing room.').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Compact -->
<div class="so-card so-card-compact">...</div>

<!-- Default -->
<div class="so-card">...</div>

<!-- Spacious -->
<div class="so-card so-card-spacious">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Horizontal Card -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Horizontal Card</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Cards with side-by-side image and content layout.</p>
                <!-- Live Demo -->
                <div class="so-card so-card-horizontal so-mb-4" style="max-width: 500px;">
                    <img class="so-card-img" src="https://picsum.photos/seed/card1/400/300" alt="Card image">
                    <div class="so-card-content">
                        <div class="so-card-body">
                            <h4 class="so-mb-2">Horizontal Card</h4>
                            <p class="so-text-muted so-text-sm">Content displayed beside the image.</p>
                        </div>
                        <div class="so-card-footer">
                            <button class="so-btn so-btn-primary so-btn-sm">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('card-horizontal', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$card = UiEngine::card()
    ->horizontal()
    ->image('/path/to/image.jpg', 'top', 'Image description')
    ->title('Horizontal Card')
    ->body('Content displayed beside the image.')
    ->footer('Last updated 3 mins ago');

echo \$card->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const card = UiEngine.card()
    .horizontal()
    .image('/path/to/image.jpg')
    .title('Horizontal Card')
    .body('Content displayed beside the image.')
    .footer('Last updated 3 mins ago');

document.getElementById('container').innerHTML = card.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-card so-card-horizontal">
    <img class="so-card-img" src="image.jpg" alt="Card image">
    <div class="so-card-content">
        <div class="so-card-body">
            <h4>Horizontal Card</h4>
            <p>Content displayed beside the image.</p>
        </div>
        <div class="so-card-footer">
            Last updated 3 mins ago
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
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
                                <td><code>header()</code></td>
                                <td><code>string $content</code></td>
                                <td>Set card header content</td>
                            </tr>
                            <tr>
                                <td><code>title()</code></td>
                                <td><code>string $title</code></td>
                                <td>Set card title (in body)</td>
                            </tr>
                            <tr>
                                <td><code>body()</code></td>
                                <td><code>string $content</code></td>
                                <td>Set card body content</td>
                            </tr>
                            <tr>
                                <td><code>footer()</code></td>
                                <td><code>string $content</code></td>
                                <td>Set card footer content</td>
                            </tr>
                            <tr>
                                <td><code>image()</code></td>
                                <td><code>string $src, string $position, string $alt</code></td>
                                <td>Add card image (top or bottom)</td>
                            </tr>
                            <tr>
                                <td><code>variant()</code></td>
                                <td><code>string $variant</code></td>
                                <td>Set border color variant</td>
                            </tr>
                            <tr>
                                <td><code>headerColor()</code></td>
                                <td><code>string $variant, bool $soft</code></td>
                                <td>Set header background color</td>
                            </tr>
                            <tr>
                                <td><code>bordered()</code></td>
                                <td>-</td>
                                <td>Border style, no shadow</td>
                            </tr>
                            <tr>
                                <td><code>flat()</code></td>
                                <td>-</td>
                                <td>No shadow, no border</td>
                            </tr>
                            <tr>
                                <td><code>elevated()</code></td>
                                <td>-</td>
                                <td>Larger shadow</td>
                            </tr>
                            <tr>
                                <td><code>compact()</code></td>
                                <td>-</td>
                                <td>Compact spacing</td>
                            </tr>
                            <tr>
                                <td><code>spacious()</code></td>
                                <td>-</td>
                                <td>Spacious spacing</td>
                            </tr>
                            <tr>
                                <td><code>horizontal()</code></td>
                                <td>-</td>
                                <td>Horizontal layout</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">CSS Classes Reference</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-card</code></td>
                                <td>Base card class</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-header</code>, <code>.so-card-body</code>, <code>.so-card-footer</code></td>
                                <td>Card sections</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-border-{variant}</code></td>
                                <td>Border color (primary, success, danger, etc.)</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-header-{variant}</code></td>
                                <td>Header background color</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-header-soft-{variant}</code></td>
                                <td>Soft header background</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-bordered</code></td>
                                <td>Border style, no shadow</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-flat</code></td>
                                <td>No shadow, no border</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-elevated</code></td>
                                <td>Larger shadow</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-compact</code></td>
                                <td>Compact spacing</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-spacious</code></td>
                                <td>Spacious spacing</td>
                            </tr>
                            <tr>
                                <td><code>.so-card-horizontal</code></td>
                                <td>Horizontal layout</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
