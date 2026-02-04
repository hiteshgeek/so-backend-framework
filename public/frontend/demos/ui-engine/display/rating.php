<?php
/**
 * SixOrbit UI Engine - Rating Element Demo
 *
 * Comprehensive demonstration of the Rating element with all features,
 * configuration options, validation, and interactive capabilities.
 */

$pageTitle = 'Rating - UI Engine';
$pageDescription = 'Star rating input and display component with interactive features';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header so-mb-4">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Rating</h1>
            <p class="so-page-subtitle">Star-based rating component for input and display with customizable appearance, icons, and interactive features.</p>
        </div>
        <div class="so-page-header-right">
            <a href="#api-reference" class="so-btn so-btn-sm so-btn-outline-primary">API Reference</a>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Rating -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Rating</h3>
                <p class="so-text-muted">Display static star ratings with default styling.</p>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <div id="demo-basic-rating-1"></div>
                    </div>
                    <div class="so-mb-3">
                        <div id="demo-basic-rating-2"></div>
                    </div>
                    <div>
                        <div id="demo-basic-rating-3"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-rating', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "use Core\UiEngine\UiEngine;

// Basic star ratings
echo UiEngine::rating()->value(4);  // 4 out of 5 stars
echo UiEngine::rating()->value(5);  // 5 out of 5 stars
echo UiEngine::rating()->value(0);  // Empty rating"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Rating } from './ui-engine/elements/display/Rating.js';

// Basic star ratings
const rating1 = Rating.make().value(4).toHtml();  // 4 out of 5 stars
const rating2 = Rating.make().value(5).toHtml();  // 5 out of 5 stars
const rating3 = Rating.make().value(0).toHtml();  // Empty rating

document.getElementById('container').innerHTML = rating1;"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-rating so-text-warning">
    <div class="so-rating-stars">
        <span class="so-rating-star"><span class="material-icons">star</span></span>
        <span class="so-rating-star"><span class="material-icons">star</span></span>
        <span class="so-rating-star"><span class="material-icons">star</span></span>
        <span class="so-rating-star"><span class="material-icons">star</span></span>
        <span class="so-rating-star"><span class="material-icons">star_border</span></span>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Interactive Rating -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Interactive Rating</h3>
                <p class="so-text-muted">Enable user input with clickable stars.</p>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-form-label so-mb-2">Rate this product</label>
                    <div id="demo-interactive-rating"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('interactive-rating', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Interactive rating input
echo UiEngine::rating()
    ->value(3)
    ->interactive()
    ->name('product_rating');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Interactive rating input
const rating = Rating.make()
    .value(3)
    .interactive()
    .name('product_rating');

document.getElementById('container').innerHTML = rating.toHtml();

// Listen to changes
document.querySelector('[data-so-ui-init=\"rating\"]')
    .addEventListener('so:rating:change', (e) => {
        console.log('New rating:', e.detail.value);
    });"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-rating so-rating-interactive so-text-warning"
     data-so-ui-init="rating"
     data-so-ui-config=\'{"value":3,"max":5,"half":false,"readonly":false}\'>
    <input type="hidden" name="product_rating" value="3" class="so-rating-value">
    <div class="so-rating-stars">
        <button type="button" class="so-rating-star" data-so-value="1">
            <span class="material-icons">star</span>
        </button>
        <!-- ... more stars ... -->
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Half Stars -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Half Star Ratings</h3>
                <p class="so-text-muted">Display and input decimal ratings with half-star precision.</p>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">3.5 stars</label>
                        <div id="demo-half-rating-1"></div>
                    </div>
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">4.5 stars (interactive)</label>
                        <div id="demo-half-rating-2"></div>
                    </div>
                    <div>
                        <label class="so-form-label so-mb-2">2.5 stars with value display</label>
                        <div id="demo-half-rating-3"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('half-rating', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Half-star ratings
echo UiEngine::rating()->value(3.5)->half();
echo UiEngine::rating()->value(4.5)->half()->interactive()->name('half_rating');
echo UiEngine::rating()->value(2.5)->half()->showValue();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Rating } from './ui-engine/elements/display/Rating.js';

// Half-star ratings
document.getElementById('demo1').innerHTML =
    Rating.make().value(3.5).half().toHtml();

document.getElementById('demo2').innerHTML =
    Rating.make().value(4.5).half().interactive().name('half_rating').toHtml();

document.getElementById('demo3').innerHTML =
    Rating.make().value(2.5).half().showValue().toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
                <p class="so-text-muted">Small and large size options for different contexts.</p>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">Small</label>
                        <div id="demo-size-small"></div>
                    </div>
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">Default</label>
                        <div id="demo-size-default"></div>
                    </div>
                    <div>
                        <label class="so-form-label so-mb-2">Large</label>
                        <div id="demo-size-large"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('size-variants', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Size variants
echo UiEngine::rating()->value(4)->small();
echo UiEngine::rating()->value(4);  // Default size
echo UiEngine::rating()->value(4)->large();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Rating } from './ui-engine/elements/display/Rating.js';

// Size variants
document.getElementById('demo-small').innerHTML =
    Rating.make().value(4).small().toHtml();

document.getElementById('demo-default').innerHTML =
    Rating.make().value(4).toHtml();

document.getElementById('demo-large').innerHTML =
    Rating.make().value(4).large().toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
                <p class="so-text-muted">Different color options to match your design.</p>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">Warning (default)</label>
                        <div id="demo-color-warning"></div>
                    </div>
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">Primary</label>
                        <div id="demo-color-primary"></div>
                    </div>
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">Success</label>
                        <div id="demo-color-success"></div>
                    </div>
                    <div>
                        <label class="so-form-label so-mb-2">Danger</label>
                        <div id="demo-color-danger"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-variants', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Color variants
echo UiEngine::rating()->value(4);  // Default warning (gold)
echo UiEngine::rating()->value(4)->color('primary');
echo UiEngine::rating()->value(4)->color('success');
echo UiEngine::rating()->value(4)->color('danger');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Rating } from './ui-engine/elements/display/Rating.js';

// Color variants
document.getElementById('demo-warning').innerHTML =
    Rating.make().value(4).toHtml();

document.getElementById('demo-primary').innerHTML =
    Rating.make().value(4).color('primary').toHtml();

document.getElementById('demo-success').innerHTML =
    Rating.make().value(4).color('success').toHtml();

document.getElementById('demo-danger').innerHTML =
    Rating.make().value(4).color('danger').toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Custom Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Custom Icons</h3>
                <p class="so-text-muted">Use any Material Icons for filled and empty states.</p>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">Hearts</label>
                        <div id="demo-icon-hearts"></div>
                    </div>
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">Thumbs</label>
                        <div id="demo-icon-thumbs"></div>
                    </div>
                    <div>
                        <label class="so-form-label so-mb-2">Grade</label>
                        <div id="demo-icon-grade"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('custom-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Custom icons
echo UiEngine::rating()
    ->value(3)
    ->icons('favorite', 'favorite_border')
    ->color('danger');

echo UiEngine::rating()
    ->value(4)
    ->icons('thumb_up', 'thumb_up_off_alt')
    ->color('primary');

echo UiEngine::rating()
    ->value(5)
    ->icons('grade', 'grade')
    ->color('success');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Rating } from './ui-engine/elements/display/Rating.js';

// Custom icons
document.getElementById('demo-hearts').innerHTML =
    Rating.make().value(3).icons('favorite', 'favorite_border').color('danger').toHtml();

document.getElementById('demo-thumbs').innerHTML =
    Rating.make().value(4).icons('thumb_up', 'thumb_up_off_alt').color('primary').toHtml();

document.getElementById('demo-grade').innerHTML =
    Rating.make().value(5).icons('grade', 'grade').color('success').toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Custom Maximum -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Custom Maximum</h3>
                <p class="so-text-muted">Change the maximum rating from the default 5.</p>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-mb-3">
                        <label class="so-form-label so-mb-2">3 out of 10</label>
                        <div id="demo-max-10"></div>
                    </div>
                    <div>
                        <label class="so-form-label so-mb-2">2 out of 3</label>
                        <div id="demo-max-3"></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('custom-max', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Custom maximum
echo UiEngine::rating()->value(7)->max(10);
echo UiEngine::rating()->value(2)->max(3);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Rating } from './ui-engine/elements/display/Rating.js';

// Custom maximum
document.getElementById('demo-max-10').innerHTML =
    Rating.make().value(7).max(10).toHtml();

document.getElementById('demo-max-3').innerHTML =
    Rating.make().value(2).max(3).toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Interactive Demo -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Interactive Demo</h3>
                <p class="so-text-muted">Try the interactive rating with controls and event logging.</p>
            </div>
            <div class="so-card-body">
                <div class="so-row">
                    <div class="so-col-md-6">
                        <h5 class="so-mb-3">Rating Control</h5>
                        <div class="so-mb-3">
                            <label class="so-form-label so-mb-2">Click to rate</label>
                            <div id="demo-rating-control"></div>
                            <p class="so-text-muted so-small so-mt-2">Current value: <span id="demo-rating-value">3</span></p>
                        </div>

                        <div class="so-btn-group so-mb-3">
                            <button type="button" class="so-btn so-btn-sm so-btn-outline-primary" id="rating-set-1">Set 1★</button>
                            <button type="button" class="so-btn so-btn-sm so-btn-outline-primary" id="rating-set-3">Set 3★</button>
                            <button type="button" class="so-btn so-btn-sm so-btn-outline-primary" id="rating-set-5">Set 5★</button>
                            <button type="button" class="so-btn so-btn-sm so-btn-outline-secondary" id="rating-reset">Reset</button>
                        </div>
                    </div>

                    <div class="so-col-md-6">
                        <h5 class="so-mb-3">Event Log</h5>
                        <div id="rating-event-log" class="so-p-3 so-border so-rounded so-bg-light" style="height: 200px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                            <div class="so-text-muted"><em>Interact with the rating to see events...</em></div>
                        </div>
                    </div>
                </div>

                <!-- Code Example -->
                <h5 class="so-mt-4 so-mb-3">Code Example</h5>
                <?= so_code_tabs('interactive-demo', [
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Rating } from './ui-engine/elements/display/Rating.js';

// Get rating instance
const ratingEl = document.getElementById('demo-rating-control');
const rating = Rating.getInstance(ratingEl);

// Listen to changes
ratingEl.addEventListener('so:rating:change', (e) => {
    console.log('Rating changed:', e.detail);
    console.log('Old value:', e.detail.oldValue);
    console.log('New value:', e.detail.value);
});

// Programmatically set value
rating.setValue(5);"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Configuration Passing -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Configuration Passing: PHP to JavaScript</h3>
                <p class="so-text-muted">How to pass rating configuration from backend to frontend.</p>
            </div>
            <div class="so-card-body">
                <h5 class="so-mb-3">Method 1: Data Attributes (Recommended)</h5>
                <p class="so-text-muted so-mb-3">Configuration is automatically embedded in data attributes when using interactive mode.</p>
                <?= so_code_tabs('config-data-attrs', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// PHP generates data attributes automatically
echo UiEngine::rating()
    ->value(4)
    ->max(5)
    ->half(true)
    ->interactive()
    ->name('rating_field');

// Outputs: data-so-ui-config='{\"value\":4,\"max\":5,\"half\":true,\"readonly\":false}'"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// JavaScript auto-initializes from data attributes
import { Rating } from './ui-engine/elements/display/Rating.js';

// Auto-initialization happens on DOM ready
Rating.initAll();

// Or manually initialize
const element = document.querySelector('[data-so-ui-init=\"rating\"]');
Rating._initElement(element);"
                    ],
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Method 2: JSON Configuration</h5>
                <p class="so-text-muted so-mb-3">Export configuration as JSON to pass to frontend.</p>
                <?= so_code_tabs('config-json', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Export config as JSON
\$rating = UiEngine::rating()
    ->value(4)
    ->max(5)
    ->half(true);

\$config = \$rating->toArray();
echo '<script>window.ratingConfig = ' . json_encode(\$config) . ';</script>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Use config from window
import { Rating } from './ui-engine/elements/display/Rating.js';

const rating = UiEngine.rating(window.ratingConfig);
document.getElementById('container').innerHTML = rating.toHtml();"
                    ],
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Method 3: Direct Configuration</h5>
                <p class="so-text-muted so-mb-3">Configure directly in JavaScript without PHP.</p>
                <?= so_code_tabs('config-direct', [
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { Rating } from './ui-engine/elements/display/Rating.js';

// Configure directly in JavaScript
const rating = Rating.make()
    .value(4)
    .max(5)
    .allowHalf()
    .interactive()
    .name('rating_field');

document.getElementById('container').innerHTML = rating.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4" id="api-reference">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <?= so_tabs('rating-api-reference', [
                    [
                        'id' => 'api-php',
                        'label' => 'PHP API',
                        'active' => true,
                        'content' => '
                            <h5 class="so-mb-3">Configuration Methods</h5>
                            <div class="so-table-responsive so-mb-4">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 25%">Method</th>
                                            <th style="width: 30%">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>value()</code></td>
                                            <td><code>float $value</code></td>
                                            <td>Set current rating value</td>
                                        </tr>
                                        <tr>
                                            <td><code>max()</code></td>
                                            <td><code>int $max</code></td>
                                            <td>Set maximum rating (default: 5)</td>
                                        </tr>
                                        <tr>
                                            <td><code>half()</code></td>
                                            <td><code>bool $half = true</code></td>
                                            <td>Enable half-star values</td>
                                        </tr>
                                        <tr>
                                            <td><code>interactive()</code></td>
                                            <td><code>bool $interactive = true</code></td>
                                            <td>Enable interactive input mode</td>
                                        </tr>
                                        <tr>
                                            <td><code>readonly()</code></td>
                                            <td><code>bool $readonly = true</code></td>
                                            <td>Set read-only mode</td>
                                        </tr>
                                        <tr>
                                            <td><code>size()</code></td>
                                            <td><code>string $size</code></td>
                                            <td>Set size: sm, lg</td>
                                        </tr>
                                        <tr>
                                            <td><code>small()</code></td>
                                            <td>-</td>
                                            <td>Shortcut for size("sm")</td>
                                        </tr>
                                        <tr>
                                            <td><code>large()</code></td>
                                            <td>-</td>
                                            <td>Shortcut for size("lg")</td>
                                        </tr>
                                        <tr>
                                            <td><code>color()</code></td>
                                            <td><code>string $color</code></td>
                                            <td>Set color: warning, primary, success, danger</td>
                                        </tr>
                                        <tr>
                                            <td><code>showValue()</code></td>
                                            <td><code>bool $show = true</code></td>
                                            <td>Display numeric value text</td>
                                        </tr>
                                        <tr>
                                            <td><code>icons()</code></td>
                                            <td><code>string $filled, string $empty, ?string $half</code></td>
                                            <td>Set custom Material Icons</td>
                                        </tr>
                                        <tr>
                                            <td><code>name()</code></td>
                                            <td><code>string $name</code></td>
                                            <td>Set form field name (auto-enables interactive)</td>
                                        </tr>
                                        <tr>
                                            <td><code>toArray()</code></td>
                                            <td>-</td>
                                            <td>Export configuration as array</td>
                                        </tr>
                                        <tr>
                                            <td><code>render()</code></td>
                                            <td>-</td>
                                            <td>Render HTML output</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'api-js',
                        'label' => 'JavaScript API',
                        'content' => '
                            <h5 class="so-mb-3">Configuration Methods</h5>
                            <p class="so-text-muted so-mb-3">Fluent API matching PHP implementation.</p>
                            <div class="so-table-responsive so-mb-4">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 25%">Method</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>value(v)</code></td>
                                            <td>Set current rating value</td>
                                        </tr>
                                        <tr>
                                            <td><code>setValue(v)</code></td>
                                            <td>Set value (inherited from FormElement)</td>
                                        </tr>
                                        <tr>
                                            <td><code>getValue()</code></td>
                                            <td>Get current value (inherited from FormElement)</td>
                                        </tr>
                                        <tr>
                                            <td><code>maxRating(max)</code></td>
                                            <td>Set maximum rating</td>
                                        </tr>
                                        <tr>
                                            <td><code>max(max)</code></td>
                                            <td>Alias for maxRating()</td>
                                        </tr>
                                        <tr>
                                            <td><code>allowHalf(bool)</code></td>
                                            <td>Enable half-star values</td>
                                        </tr>
                                        <tr>
                                            <td><code>half(bool)</code></td>
                                            <td>Alias for allowHalf()</td>
                                        </tr>
                                        <tr>
                                            <td><code>icon(icon)</code></td>
                                            <td>Set filled icon</td>
                                        </tr>
                                        <tr>
                                            <td><code>emptyIcon(icon)</code></td>
                                            <td>Set empty icon</td>
                                        </tr>
                                        <tr>
                                            <td><code>halfIcon(icon)</code></td>
                                            <td>Set half-filled icon</td>
                                        </tr>
                                        <tr>
                                            <td><code>icons(filled, empty, half)</code></td>
                                            <td>Set all icons at once</td>
                                        </tr>
                                        <tr>
                                            <td><code>color(c)</code></td>
                                            <td>Set color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>size(s)</code></td>
                                            <td>Set size variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>small()</code></td>
                                            <td>Shortcut for size("sm")</td>
                                        </tr>
                                        <tr>
                                            <td><code>large()</code></td>
                                            <td>Shortcut for size("lg")</td>
                                        </tr>
                                        <tr>
                                            <td><code>showValue(bool)</code></td>
                                            <td>Show numeric value text</td>
                                        </tr>
                                        <tr>
                                            <td><code>interactive(bool)</code></td>
                                            <td>Enable interactive mode</td>
                                        </tr>
                                        <tr>
                                            <td><code>editable(bool)</code></td>
                                            <td>Alias for interactive()</td>
                                        </tr>
                                        <tr>
                                            <td><code>setReadonly(bool)</code></td>
                                            <td>Set read-only state (inherited from FormElement)</td>
                                        </tr>
                                        <tr>
                                            <td><code>setName(name)</code></td>
                                            <td>Set form field name (inherited from FormElement)</td>
                                        </tr>
                                        <tr>
                                            <td><code>toHtml()</code></td>
                                            <td>Generate HTML string</td>
                                        </tr>
                                        <tr>
                                            <td><code>toConfig()</code></td>
                                            <td>Export configuration as object</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mb-3">Static Methods</h5>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 30%">Method</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>Rating.getInstance(element)</code></td>
                                            <td>Get Rating instance from DOM element</td>
                                        </tr>
                                        <tr>
                                            <td><code>Rating.initAll()</code></td>
                                            <td>Initialize all ratings with [data-so-ui-init="rating"]</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'api-html',
                        'label' => 'HTML Structure',
                        'content' => '
                            <h5 class="so-mb-3">Read-Only Rating</h5>
                            <pre class="so-code-block"><code class="language-html">&lt;div class=&quot;so-rating so-text-warning&quot;&gt;
    &lt;div class=&quot;so-rating-stars&quot;&gt;
        &lt;span class=&quot;so-rating-star&quot;&gt;
            &lt;span class=&quot;material-icons&quot;&gt;star&lt;/span&gt;
        &lt;/span&gt;
        &lt;span class=&quot;so-rating-star&quot;&gt;
            &lt;span class=&quot;material-icons&quot;&gt;star&lt;/span&gt;
        &lt;/span&gt;
        &lt;span class=&quot;so-rating-star&quot;&gt;
            &lt;span class=&quot;material-icons&quot;&gt;star_border&lt;/span&gt;
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>

                            <h5 class="so-mb-3 so-mt-4">Interactive Rating</h5>
                            <pre class="so-code-block"><code class="language-html">&lt;div class=&quot;so-rating so-rating-interactive so-text-warning&quot;
     data-so-ui-init=&quot;rating&quot;
     data-so-ui-config=&#39;{&quot;value&quot;:3,&quot;max&quot;:5,&quot;half&quot;:false,&quot;readonly&quot;:false}&#39;&gt;
    &lt;input type=&quot;hidden&quot; name=&quot;rating_field&quot; value=&quot;3&quot; class=&quot;so-rating-value&quot;&gt;
    &lt;div class=&quot;so-rating-stars&quot;&gt;
        &lt;button type=&quot;button&quot; class=&quot;so-rating-star&quot; data-so-value=&quot;1&quot;&gt;
            &lt;span class=&quot;material-icons&quot;&gt;star&lt;/span&gt;
        &lt;/button&gt;
        &lt;button type=&quot;button&quot; class=&quot;so-rating-star&quot; data-so-value=&quot;2&quot;&gt;
            &lt;span class=&quot;material-icons&quot;&gt;star&lt;/span&gt;
        &lt;/button&gt;
        &lt;!-- ... more stars ... --&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        '
                    ],
                    [
                        'id' => 'api-css',
                        'label' => 'CSS Classes',
                        'content' => '
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 35%">Class</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>.so-rating</code></td>
                                            <td>Base rating container</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-rating-interactive</code></td>
                                            <td>Interactive/editable mode</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-rating-readonly</code></td>
                                            <td>Read-only mode (no interaction)</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-rating-sm</code></td>
                                            <td>Small size variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-rating-lg</code></td>
                                            <td>Large size variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-rating-stars</code></td>
                                            <td>Container for star elements</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-rating-star</code></td>
                                            <td>Individual star element</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-rating-text</code></td>
                                            <td>Numeric value display text</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-rating-value</code></td>
                                            <td>Hidden input field for form submission</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-text-warning</code></td>
                                            <td>Warning color (default for stars)</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-text-primary</code></td>
                                            <td>Primary color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-text-success</code></td>
                                            <td>Success color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-text-danger</code></td>
                                            <td>Danger color variant</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-active</code></td>
                                            <td>Active/filled star state (JavaScript)</td>
                                        </tr>
                                        <tr>
                                            <td><code>.so-half</code></td>
                                            <td>Half-filled star state (JavaScript)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'api-data',
                        'label' => 'Data Attributes',
                        'content' => '
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 35%">Attribute</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>data-so-ui-init=&quot;rating&quot;</code></td>
                                            <td>Marks element for auto-initialization</td>
                                        </tr>
                                        <tr>
                                            <td><code>data-so-ui-config</code></td>
                                            <td>JSON configuration object</td>
                                        </tr>
                                        <tr>
                                            <td><code>data-so-value</code></td>
                                            <td>Star index value (1-5) for interactive mode</td>
                                        </tr>
                                        <tr>
                                            <td><code>data-so-rating-initialized</code></td>
                                            <td>Flag indicating initialization complete</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mb-3 so-mt-4">Configuration Object Schema</h5>
                            <pre class="so-code-block"><code class="language-json">{
  &quot;value&quot;: 3,           // Current rating value
  &quot;max&quot;: 5,             // Maximum rating (default: 5)
  &quot;half&quot;: false,        // Allow half-star values
  &quot;readonly&quot;: false     // Read-only mode
}</code></pre>
                        '
                    ],
                    [
                        'id' => 'api-events',
                        'label' => 'Events',
                        'content' => '
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead class="so-table-light">
                                        <tr>
                                            <th style="width: 30%">Event</th>
                                            <th style="width: 35%">Detail Properties</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>so:rating:change</code></td>
                                            <td>
                                                <code>value</code> - New rating value<br>
                                                <code>oldValue</code> - Previous value<br>
                                                <code>instance</code> - Rating instance
                                            </td>
                                            <td>Fired when rating value changes via user interaction or setValue()</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mb-3 so-mt-4">Event Usage Example</h5>
                            <pre class="so-code-block"><code class="language-javascript">import { Rating } from \'./ui-engine/elements/display/Rating.js\';

const ratingEl = document.querySelector(\'[data-so-ui-init=&quot;rating&quot;]\');

// Listen to rating changes
ratingEl.addEventListener(\'so:rating:change\', (event) => {
    const { value, oldValue, instance } = event.detail;
    console.log(`Rating changed from ${oldValue} to ${value}`);

    // Update UI
    document.getElementById(\'rating-display\').textContent = `${value} stars`;

    // Submit to server
    fetch(\'/api/ratings\', {
        method: \'POST\',
        body: JSON.stringify({ rating: value })
    });
});

// Programmatically trigger change
const rating = Rating.getInstance(ratingEl);
rating.setValue(5);  // Fires so:rating:change event</code></pre>
                        '
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Usage Notes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Usage Notes</h3>
            </div>
            <div class="so-card-body">
                <h5 class="so-mb-3">When to Use Rating</h5>
                <ul class="so-mb-4">
                    <li><strong>Product Reviews:</strong> Allow customers to rate products on e-commerce sites</li>
                    <li><strong>Service Feedback:</strong> Collect satisfaction ratings for services or support</li>
                    <li><strong>Content Rating:</strong> Display and collect ratings for articles, videos, or other content</li>
                    <li><strong>Skill Assessment:</strong> Show proficiency levels for skills on resumes or profiles</li>
                    <li><strong>Experience Rating:</strong> Gather feedback on user experiences</li>
                </ul>

                <h5 class="so-mb-3">Best Practices</h5>
                <ul class="so-mb-4">
                    <li>Use <strong>warning color</strong> (gold/yellow) for traditional star ratings</li>
                    <li>Use <strong>danger color</strong> (red) for hearts or critical ratings</li>
                    <li>Enable <strong>half-star mode</strong> for more precise ratings (3.5, 4.5, etc.)</li>
                    <li>Show <strong>numeric value</strong> alongside stars for clarity when displaying averages</li>
                    <li>Use <strong>interactive mode</strong> for user input, read-only mode for displaying existing ratings</li>
                    <li>Consider showing <strong>review count</strong> alongside average ratings for context</li>
                    <li>Provide <strong>clear labels</strong> when using ratings as form inputs</li>
                    <li>Use <strong>consistent sizing</strong> throughout your application</li>
                </ul>

                <h5 class="so-mb-3">Accessibility</h5>
                <ul>
                    <li>Interactive ratings use <code>&lt;button&gt;</code> elements for keyboard navigation</li>
                    <li>Stars are focusable and activatable via keyboard (Enter/Space)</li>
                    <li>Consider adding <code>aria-label</code> attributes for screen readers</li>
                    <li>Hidden input field ensures form submission works correctly</li>
                    <li>Color is not the only indicator - icon shapes differ (filled vs. empty)</li>
                </ul>
            </div>
        </div>
    </div>
</main>

<script type="module">
import { Rating } from '/src/js/ui-engine/elements/display/Rating.js';

document.addEventListener('DOMContentLoaded', function() {
    // Basic Ratings
    document.getElementById('demo-basic-rating-1').innerHTML =
        Rating.make().value(4).toHtml();

    document.getElementById('demo-basic-rating-2').innerHTML =
        Rating.make().value(5).toHtml();

    document.getElementById('demo-basic-rating-3').innerHTML =
        Rating.make().value(0).toHtml();

    // Interactive Rating
    document.getElementById('demo-interactive-rating').innerHTML =
        Rating.make().value(3).interactive().name('product_rating').toHtml();

    // Half Star Ratings
    document.getElementById('demo-half-rating-1').innerHTML =
        Rating.make().value(3.5).half().toHtml();

    document.getElementById('demo-half-rating-2').innerHTML =
        Rating.make().value(4.5).half().interactive().name('half_rating').toHtml();

    document.getElementById('demo-half-rating-3').innerHTML =
        Rating.make().value(2.5).half().showValue().toHtml();

    // Size Variants
    document.getElementById('demo-size-small').innerHTML =
        Rating.make().value(4).small().toHtml();

    document.getElementById('demo-size-default').innerHTML =
        Rating.make().value(4).toHtml();

    document.getElementById('demo-size-large').innerHTML =
        Rating.make().value(4).large().toHtml();

    // Color Variants
    document.getElementById('demo-color-warning').innerHTML =
        Rating.make().value(4).toHtml();

    document.getElementById('demo-color-primary').innerHTML =
        Rating.make().value(4).color('primary').toHtml();

    document.getElementById('demo-color-success').innerHTML =
        Rating.make().value(4).color('success').toHtml();

    document.getElementById('demo-color-danger').innerHTML =
        Rating.make().value(4).color('danger').toHtml();

    // Custom Icons
    document.getElementById('demo-icon-hearts').innerHTML =
        Rating.make().value(3).icons('favorite', 'favorite_border').color('danger').toHtml();

    document.getElementById('demo-icon-thumbs').innerHTML =
        Rating.make().value(4).icons('thumb_up', 'thumb_up_off_alt').color('primary').toHtml();

    document.getElementById('demo-icon-grade').innerHTML =
        Rating.make().value(5).icons('grade', 'grade').color('success').toHtml();

    // Custom Maximum
    document.getElementById('demo-max-10').innerHTML =
        Rating.make().value(7).max(10).toHtml();

    document.getElementById('demo-max-3').innerHTML =
        Rating.make().value(2).max(3).toHtml();

    // Interactive Demo Control
    document.getElementById('demo-rating-control').innerHTML =
        Rating.make().value(3).interactive().name('demo_rating').toHtml();

    // Initialize all Rating instances (after a short delay to ensure DOM is ready)
    setTimeout(function() {
        Rating.initAll();
    }, 100);
});
</script>

<script>
// Interactive Demo Controls
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const ratingEl = document.getElementById('demo-rating-control');
        const ratingValueDisplay = document.getElementById('demo-rating-value');
        const eventLog = document.getElementById('rating-event-log');

        if (!ratingEl) return;

        function logEvent(message) {
            const timestamp = new Date().toLocaleTimeString();
            const entry = document.createElement('div');
            entry.textContent = '[' + timestamp + '] ' + message;
            eventLog.insertBefore(entry, eventLog.firstChild);
            while (eventLog.children.length > 10) {
                eventLog.removeChild(eventLog.lastChild);
            }
        }

        // Listen to rating changes
        ratingEl.addEventListener('so:rating:change', function(e) {
            const value = e.detail.value;
            ratingValueDisplay.textContent = value;
            logEvent('Rating changed to ' + value + ' stars');
        });

        // Button handlers
        const btn1 = document.getElementById('rating-set-1');
        const btn3 = document.getElementById('rating-set-3');
        const btn5 = document.getElementById('rating-set-5');
        const btnReset = document.getElementById('rating-reset');

        if (btn1) btn1.addEventListener('click', function() {
            const star = ratingEl.querySelector('[data-so-value="1"]');
            if (star) star.click();
        });

        if (btn3) btn3.addEventListener('click', function() {
            const star = ratingEl.querySelector('[data-so-value="3"]');
            if (star) star.click();
        });

        if (btn5) btn5.addEventListener('click', function() {
            const star = ratingEl.querySelector('[data-so-value="5"]');
            if (star) star.click();
        });

        if (btnReset) btnReset.addEventListener('click', function() {
            const firstStar = ratingEl.querySelector('[data-so-value="1"]');
            if (firstStar) firstStar.click();
            logEvent('Rating reset');
        });

        logEvent('Interactive demo ready');
    }, 1000);
});
</script>

<?php require_once '../../includes/footer.php'; ?>
