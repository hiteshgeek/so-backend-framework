<?php

/**
 * SixOrbit UI Engine - Slider Element Demo
 */

$pageTitle = 'Slider - UI Engine';
$pageDescription = 'Range slider for numeric value selection';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Slider</h1>
            <p class="so-page-subtitle">Range slider element for numeric value selection with min/max bounds and step increments.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Slider -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Slider</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-slider-label" for="demo-volume">Volume</label>
                    <div class="so-slider so-slider-primary" data-so-slider>
                        <input type="range" class="so-slider-input" id="demo-volume" name="volume" min="0" max="100" value="50">
                        <div class="so-slider-track">
                            <div class="so-slider-fill"></div>
                            <div class="so-slider-thumb"></div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-slider', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$slider = UiEngine::slider('volume')
    ->label('Volume')
    ->range(0, 100)    // minValue, maxValue, step
    ->value(50);

echo \$slider->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const slider = UiEngine.slider('volume')
    .label('Volume')
    .range(0, 100)    // minValue, maxValue, step
    .value(50);

document.getElementById('container').innerHTML = slider.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-slider-label" for="volume">Volume</label>
    <div class="so-slider so-slider-primary" data-so-slider>
        <input type="range" class="so-slider-input" id="volume" name="volume" min="0" max="100" value="50">
        <div class="so-slider-track">
            <div class="so-slider-fill"></div>
            <div class="so-slider-thumb"></div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Slider Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Slider Sizes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-1 so-gap-4">
                    <!-- Extra Small -->
                    <div>
                        <label class="so-slider-label">Extra Small (.so-slider-xs)</label>
                        <div class="so-slider so-slider-xs so-slider-primary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="25">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Small -->
                    <div>
                        <label class="so-slider-label">Small (.so-slider-sm)</label>
                        <div class="so-slider so-slider-sm so-slider-primary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="50">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Default -->
                    <div>
                        <label class="so-slider-label">Default</label>
                        <div class="so-slider so-slider-primary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="75">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Large -->
                    <div>
                        <label class="so-slider-label">Large (.so-slider-lg)</label>
                        <div class="so-slider so-slider-lg so-slider-primary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="60">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('slider-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Extra Small
UiEngine::slider('xs')->size('xs')->value(25);

// Small
UiEngine::slider('sm')->size('sm')->value(50);

// Default
UiEngine::slider('default')->value(75);

// Large
UiEngine::slider('lg')->size('lg')->value(60);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Extra Small
UiEngine.slider('xs').size('xs').value(25);

// Small
UiEngine.slider('sm').size('sm').value(50);

// Default
UiEngine.slider('default').value(75);

// Large
UiEngine.slider('lg').size('lg').value(60);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Extra Small -->
<div class="so-slider so-slider-xs so-slider-primary" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="25">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb"></div>
    </div>
</div>

<!-- Small -->
<div class="so-slider so-slider-sm so-slider-primary" data-so-slider>...</div>

<!-- Default -->
<div class="so-slider so-slider-primary" data-so-slider>...</div>

<!-- Large -->
<div class="so-slider so-slider-lg so-slider-primary" data-so-slider>...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Step -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Discrete Slider with Ticks</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-slider-wrapper so-mb-4">
                    <label class="so-slider-label">Volume (0-100, step 10)</label>
                    <div class="so-slider so-slider-discrete so-slider-primary" data-so-slider data-so-ticks="11">
                        <input type="range" class="so-slider-input" min="0" max="100" step="10" value="50">
                        <div class="so-slider-track">
                            <div class="so-slider-fill"></div>
                            <div class="so-slider-thumb"></div>
                            <div class="so-slider-ticks"></div>
                        </div>
                    </div>
                    <div class="so-slider-labels">
                        <span>0</span>
                        <span>50</span>
                        <span>100</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('slider-step', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Discrete slider with tick marks
\$slider = UiEngine::slider('volume')
    ->label('Volume')
    ->range(0, 100, 10)       // min, max, step
    ->value(50)
    ->ticks(11);              // 11 tick marks (0,10,20...100)

echo \$slider->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Discrete slider with tick marks
const slider = UiEngine.slider('volume')
    .label('Volume')
    .range(0, 100, 10)        // min, max, step
    .value(50)
    .ticks(11);

document.getElementById('container').innerHTML = slider.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-slider-wrapper">
    <label class="so-slider-label">Volume (0-100, step 10)</label>
    <div class="so-slider so-slider-discrete so-slider-primary" data-so-slider data-so-ticks="11">
        <input type="range" class="so-slider-input" min="0" max="100" step="10" value="50">
        <div class="so-slider-track">
            <div class="so-slider-fill"></div>
            <div class="so-slider-thumb"></div>
            <div class="so-slider-ticks"></div>
        </div>
    </div>
    <div class="so-slider-labels">
        <span>0</span>
        <span>50</span>
        <span>100</span>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Tooltip -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Slider with Tooltip</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-slider so-slider-labeled so-slider-primary" data-so-slider>
                        <input type="range" class="so-slider-input" id="demo-brightness" min="0" max="100" value="65">
                        <div class="so-slider-track">
                            <div class="so-slider-fill"></div>
                            <div class="so-slider-thumb">
                                <span class="so-slider-tooltip">65</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('slider-tooltip', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$slider = UiEngine::slider('brightness')
    ->label('Brightness')
    ->range(0, 100)
    ->value(65)
    ->showTooltip();          // Show tooltip on hover/drag

echo \$slider->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const slider = UiEngine.slider('brightness')
    .label('Brightness')
    .range(0, 100)
    .value(65)
    .showTooltip();

document.getElementById('container').innerHTML = slider.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-slider so-slider-labeled so-slider-primary" data-so-slider>
    <input type="range" class="so-slider-input" id="brightness" min="0" max="100" value="65">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb">
            <span class="so-slider-tooltip">65</span>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With External Value Display -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Slider with External Value</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-slider-inline so-mb-4">
                    <div class="so-slider so-slider-primary" data-so-slider data-so-output="#inline-value">
                        <input type="range" class="so-slider-input" min="0" max="100" value="70">
                        <div class="so-slider-track">
                            <div class="so-slider-fill"></div>
                            <div class="so-slider-thumb"></div>
                        </div>
                    </div>
                    <span class="so-slider-value" id="inline-value">70</span>
                </div>

                <div class="so-slider-inline so-mb-4">
                    <span class="so-slider-value so-text-left" style="min-width: 60px;" id="price-value">$250</span>
                    <div class="so-slider so-slider-success" data-so-slider data-so-output="#price-value" data-so-prefix="$">
                        <input type="range" class="so-slider-input" min="0" max="1000" value="250">
                        <div class="so-slider-track">
                            <div class="so-slider-fill"></div>
                            <div class="so-slider-thumb"></div>
                        </div>
                    </div>
                    <span class="so-slider-value">$1000</span>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('slider-display', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$slider = UiEngine::slider('value')
    ->range(0, 100)
    ->value(70)
    ->output('#inline-value');    // External value display

\$priceSlider = UiEngine::slider('price')
    ->range(0, 1000)
    ->value(250)
    ->variant('success')
    ->output('#price-value')
    ->prefix('\$');

echo \$slider->render();
echo \$priceSlider->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const slider = UiEngine.slider('value')
    .range(0, 100)
    .value(70)
    .output('#inline-value');

const priceSlider = UiEngine.slider('price')
    .range(0, 1000)
    .value(250)
    .success()                 // or .variant('success')
    .output('#price-value')
    .prefix('\$');

document.getElementById('container').innerHTML = slider.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-slider-inline">
    <div class="so-slider so-slider-primary" data-so-slider data-so-output="#inline-value">
        <input type="range" class="so-slider-input" min="0" max="100" value="70">
        <div class="so-slider-track">
            <div class="so-slider-fill"></div>
            <div class="so-slider-thumb"></div>
        </div>
    </div>
    <span class="so-slider-value" id="inline-value">70</span>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Range Slider (Dual Handles) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Range Slider (Dual Thumb)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-slider-wrapper so-mb-4">
                    <label class="so-slider-label">Price Range: <span id="range-display">$200 - $800</span></label>
                    <div class="so-slider so-slider-range so-slider-primary" data-so-slider-range data-so-output="#range-display" data-so-prefix="$" data-so-separator=" - ">
                        <input type="range" class="so-slider-input so-slider-input-min" min="0" max="1000" value="200">
                        <input type="range" class="so-slider-input so-slider-input-max" min="0" max="1000" value="800">
                        <div class="so-slider-track">
                            <div class="so-slider-fill"></div>
                            <div class="so-slider-thumb so-slider-thumb-min"></div>
                            <div class="so-slider-thumb so-slider-thumb-max"></div>
                        </div>
                    </div>
                    <div class="so-slider-labels">
                        <span>$0</span>
                        <span>$500</span>
                        <span>$1000</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('slider-range', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Price range slider with dual thumbs
\$priceRange = UiEngine::slider('price')
    ->label('Price Range')
    ->range(0, 1000)
    ->value(200)            // Start value
    ->valueEnd(800)         // End value (enables dual range)
    ->prefix('\$')
    ->output('#range-display')
    ->separator(' - ');

echo \$priceRange->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Price range slider with dual thumbs
const priceRange = UiEngine.slider('price')
    .label('Price Range')
    .range(0, 1000)
    .value(200)             // Start value
    .valueEnd(800)          // End value (enables dual range)
    .prefix('\$')
    .output('#range-display')
    .separator(' - ');

document.getElementById('container').innerHTML = priceRange.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-slider-wrapper">
    <label class="so-slider-label">Price Range: <span id="range-display">$200 - $800</span></label>
    <div class="so-slider so-slider-range so-slider-primary" data-so-slider-range data-so-output="#range-display" data-so-prefix="$" data-so-separator=" - ">
        <input type="range" class="so-slider-input so-slider-input-min" min="0" max="1000" value="200">
        <input type="range" class="so-slider-input so-slider-input-max" min="0" max="1000" value="800">
        <div class="so-slider-track">
            <div class="so-slider-fill"></div>
            <div class="so-slider-thumb so-slider-thumb-min"></div>
            <div class="so-slider-thumb so-slider-thumb-max"></div>
        </div>
    </div>
    <div class="so-slider-labels">
        <span>$0</span>
        <span>$500</span>
        <span>$1000</span>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Vertical Slider -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Vertical Slider</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-8 so-mb-4">
                    <!-- Basic Vertical -->
                    <div class="so-text-center">
                        <div class="so-slider so-slider-vertical so-slider-primary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="60">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">Primary</small>
                    </div>

                    <!-- Success Vertical -->
                    <div class="so-text-center">
                        <div class="so-slider so-slider-vertical so-slider-success" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="80">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">Success</small>
                    </div>

                    <!-- Warning Vertical with Tooltip -->
                    <div class="so-text-center">
                        <div class="so-slider so-slider-vertical so-slider-labeled so-slider-warning" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="45">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb">
                                    <span class="so-slider-tooltip">45</span>
                                </div>
                            </div>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">With Tooltip</small>
                    </div>

                    <!-- Danger Vertical -->
                    <div class="so-text-center">
                        <div class="so-slider so-slider-vertical so-slider-danger" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="30">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                        <small class="so-text-muted so-mt-2 so-d-block">Danger</small>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('slider-vertical', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Vertical slider
\$slider = UiEngine::slider('volume')
    ->vertical()
    ->primary()               // or ->variant('primary')
    ->value(60);

// Vertical with tooltip
\$tooltipSlider = UiEngine::slider('level')
    ->vertical()
    ->showTooltip()
    ->warning()               // or ->variant('warning')
    ->value(45);

echo \$slider->render();
echo \$tooltipSlider->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Vertical slider
const slider = UiEngine.slider('volume')
    .vertical()
    .primary()                // or .variant('primary')
    .value(60);

// Vertical with tooltip
const tooltipSlider = UiEngine.slider('level')
    .vertical()
    .showTooltip()
    .warning()                // or .variant('warning')
    .value(45);

document.getElementById('container').innerHTML = slider.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Vertical slider -->
<div class="so-slider so-slider-vertical so-slider-primary" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="60">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb"></div>
    </div>
</div>

<!-- Vertical with tooltip -->
<div class="so-slider so-slider-vertical so-slider-labeled so-slider-warning" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="45">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb">
            <span class="so-slider-tooltip">45</span>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Slider Colors -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4">
                    <!-- Primary -->
                    <div>
                        <label class="so-slider-label">Primary</label>
                        <div class="so-slider so-slider-primary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="60">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary -->
                    <div>
                        <label class="so-slider-label">Secondary</label>
                        <div class="so-slider so-slider-secondary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="60">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Success -->
                    <div>
                        <label class="so-slider-label">Success</label>
                        <div class="so-slider so-slider-success" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="60">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Warning -->
                    <div>
                        <label class="so-slider-label">Warning</label>
                        <div class="so-slider so-slider-warning" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="60">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Danger -->
                    <div>
                        <label class="so-slider-label">Danger</label>
                        <div class="so-slider so-slider-danger" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="60">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div>
                        <label class="so-slider-label">Info</label>
                        <div class="so-slider so-slider-info" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="60">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('slider-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Primary (default)
UiEngine::slider('primary')->primary()->value(60);

// Secondary
UiEngine::slider('secondary')->secondary()->value(60);

// Success
UiEngine::slider('success')->success()->value(60);

// Warning
UiEngine::slider('warning')->warning()->value(60);

// Danger
UiEngine::slider('danger')->danger()->value(60);

// Info
UiEngine::slider('info')->info()->value(60);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Primary (default)
UiEngine.slider('primary').primary().value(60);

// Secondary
UiEngine.slider('secondary').secondary().value(60);

// Success
UiEngine.slider('success').success().value(60);

// Warning
UiEngine.slider('warning').warning().value(60);

// Danger
UiEngine.slider('danger').danger().value(60);

// Info
UiEngine.slider('info').info().value(60);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Primary -->
<div class="so-slider so-slider-primary" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="60">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb"></div>
    </div>
</div>

<!-- Secondary -->
<div class="so-slider so-slider-secondary" data-so-slider>...</div>

<!-- Success -->
<div class="so-slider so-slider-success" data-so-slider>...</div>

<!-- Warning -->
<div class="so-slider so-slider-warning" data-so-slider>...</div>

<!-- Danger -->
<div class="so-slider so-slider-danger" data-so-slider>...</div>

<!-- Info -->
<div class="so-slider so-slider-info" data-so-slider>...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Disabled State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Disabled State</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4 so-mb-4">
                    <div>
                        <label class="so-slider-label">Disabled Primary</label>
                        <div class="so-slider so-slider-primary so-disabled" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="40" disabled>
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="so-slider-label">Disabled Success</label>
                        <div class="so-slider so-slider-success so-disabled" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="75" disabled>
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('slider-disabled', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Disabled slider
\$slider = UiEngine::slider('disabled')
    ->primary()
    ->value(40)
    ->disabled();

echo \$slider->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Disabled slider
const slider = UiEngine.slider('disabled')
    .primary()
    .value(40)
    .disabled();

document.getElementById('container').innerHTML = slider.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-slider so-slider-primary so-disabled" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="40" disabled>
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb"></div>
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
                <!-- API Tabs -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-php">PHP Class</button>
                    <button class="so-tab" role="tab" data-so-target="#api-js">JS UiEngine</button>
                </div>

                <div class="so-tab-content">
                    <!-- PHP Class Reference -->
                    <div class="so-tab-pane so-fade so-show so-active" id="api-php" role="tabpanel">
                        <h5 class="so-mt-3">Core\\UiEngine\\Elements\\Form\\Slider</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine::slider(string $name)</code></td>
                                        <td>Create slider with name</td>
                                    </tr>
                                    <tr>
                                        <td><code>UiEngine::rangeSlider(string $name)</code></td>
                                        <td>Create dual-thumb range slider</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Range Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>minValue(int|float $value)</code></td>
                                        <td>Set minimum slider value</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxValue(int|float $value)</code></td>
                                        <td>Set maximum slider value</td>
                                    </tr>
                                    <tr>
                                        <td><code>range($min, $max, $step = 1)</code></td>
                                        <td>Set min, max, and step in one call</td>
                                    </tr>
                                    <tr>
                                        <td><code>step(int|float $step)</code></td>
                                        <td>Set step increment</td>
                                    </tr>
                                    <tr>
                                        <td><code>value(int|float $value)</code></td>
                                        <td>Set current value</td>
                                    </tr>
                                    <tr>
                                        <td><code>valueEnd(int|float $value)</code></td>
                                        <td>Set end value for range slider</td>
                                    </tr>
                                    <tr>
                                        <td><code>dualRange(bool $enabled = true)</code></td>
                                        <td>Enable dual-thumb range slider</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Display Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>showTooltip(bool $show = true)</code></td>
                                        <td>Show tooltip on hover/drag</td>
                                    </tr>
                                    <tr>
                                        <td><code>labeled()</code></td>
                                        <td>Alias for showTooltip(true)</td>
                                    </tr>
                                    <tr>
                                        <td><code>ticks(int $count)</code></td>
                                        <td>Number of tick marks to display</td>
                                    </tr>
                                    <tr>
                                        <td><code>output(string $selector)</code></td>
                                        <td>CSS selector for external value display</td>
                                    </tr>
                                    <tr>
                                        <td><code>prefix(string $prefix)</code></td>
                                        <td>Add prefix to value display (e.g., '$')</td>
                                    </tr>
                                    <tr>
                                        <td><code>suffix(string $suffix)</code></td>
                                        <td>Add suffix to value display (e.g., '%')</td>
                                    </tr>
                                    <tr>
                                        <td><code>separator(string $sep)</code></td>
                                        <td>Separator for range display (default: ' - ')</td>
                                    </tr>
                                    <tr>
                                        <td><code>vertical(bool $vertical = true)</code></td>
                                        <td>Vertical orientation</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Variant Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>variant(string $variant)</code></td>
                                        <td>Set color variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>primary() / secondary() / success() / danger() / warning() / info()</code></td>
                                        <td>Shortcut color methods</td>
                                    </tr>
                                    <tr>
                                        <td><code>size(string $size)</code></td>
                                        <td>Set size (xs, sm, lg)</td>
                                    </tr>
                                    <tr>
                                        <td><code>xs() / sm() / lg()</code></td>
                                        <td>Shortcut size methods</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Inherited Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>name(string $name)</code></td>
                                        <td>Set input name</td>
                                    </tr>
                                    <tr>
                                        <td><code>id(string $id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>label(string $label)</code></td>
                                        <td>Set label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code></td>
                                        <td>Disable the slider</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>Render slider HTML</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderGroup()</code></td>
                                        <td>Render with wrapper and label</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderInline()</code></td>
                                        <td>Render inline with external value</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray()</code></td>
                                        <td>Export configuration array</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JS UiEngine Reference -->
                    <div class="so-tab-pane so-fade" id="api-js" role="tabpanel">
                        <h5 class="so-mt-3">UiEngine.slider()</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine.slider(name)</code></td>
                                        <td>Create slider with name</td>
                                    </tr>
                                    <tr>
                                        <td><code>UiEngine.rangeSlider(name)</code></td>
                                        <td>Create dual-thumb range slider</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Range Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>minValue(value)</code></td>
                                        <td>Set minimum slider value</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxValue(value)</code></td>
                                        <td>Set maximum slider value</td>
                                    </tr>
                                    <tr>
                                        <td><code>range(min, max, step = 1)</code></td>
                                        <td>Set min, max, and step in one call</td>
                                    </tr>
                                    <tr>
                                        <td><code>step(step)</code></td>
                                        <td>Set step increment</td>
                                    </tr>
                                    <tr>
                                        <td><code>value(value)</code></td>
                                        <td>Set current value</td>
                                    </tr>
                                    <tr>
                                        <td><code>valueEnd(value)</code></td>
                                        <td>Set end value for range slider</td>
                                    </tr>
                                    <tr>
                                        <td><code>dualRange(enabled = true)</code></td>
                                        <td>Enable dual-thumb range slider</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Display Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>showTooltip(show = true)</code></td>
                                        <td>Show tooltip on hover/drag</td>
                                    </tr>
                                    <tr>
                                        <td><code>labeled()</code></td>
                                        <td>Alias for showTooltip(true)</td>
                                    </tr>
                                    <tr>
                                        <td><code>ticks(count)</code></td>
                                        <td>Number of tick marks to display</td>
                                    </tr>
                                    <tr>
                                        <td><code>output(selector)</code></td>
                                        <td>CSS selector for external value display</td>
                                    </tr>
                                    <tr>
                                        <td><code>prefix(prefix)</code></td>
                                        <td>Add prefix to value display</td>
                                    </tr>
                                    <tr>
                                        <td><code>suffix(suffix)</code></td>
                                        <td>Add suffix to value display</td>
                                    </tr>
                                    <tr>
                                        <td><code>separator(sep)</code></td>
                                        <td>Separator for range display</td>
                                    </tr>
                                    <tr>
                                        <td><code>vertical(val = true)</code></td>
                                        <td>Vertical orientation</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Variant Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>variant(variant)</code></td>
                                        <td>Set color variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>primary() / secondary() / success() / danger() / warning() / info()</code></td>
                                        <td>Shortcut color methods</td>
                                    </tr>
                                    <tr>
                                        <td><code>size(size)</code></td>
                                        <td>Set size variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>xs() / sm() / lg()</code></td>
                                        <td>Shortcut size methods</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Inherited Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>name(name)</code></td>
                                        <td>Set input name</td>
                                    </tr>
                                    <tr>
                                        <td><code>id(id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>label(label)</code></td>
                                        <td>Set label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code></td>
                                        <td>Disable the slider</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr(name, value)</code></td>
                                        <td>Set custom attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>data(key, value)</code></td>
                                        <td>Set data-* attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>toHtml()</code></td>
                                        <td>Get HTML string</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>Render to DOM element</td>
                                    </tr>
                                    <tr>
                                        <td><code>toConfig()</code></td>
                                        <td>Export configuration object</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Runtime Methods (SOSlider)</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>SOSlider.getInstance(el)</code></td>
                                        <td>Get SOSlider instance from element</td>
                                    </tr>
                                    <tr>
                                        <td><code>getValue()</code></td>
                                        <td>Get current value</td>
                                    </tr>
                                    <tr>
                                        <td><code>setValue(value)</code></td>
                                        <td>Set slider value programmatically</td>
                                    </tr>
                                    <tr>
                                        <td><code>enable()</code></td>
                                        <td>Enable the slider</td>
                                    </tr>
                                    <tr>
                                        <td><code>disable()</code></td>
                                        <td>Disable the slider</td>
                                    </tr>
                                    <tr>
                                        <td><code>on(event, callback)</code></td>
                                        <td>Subscribe to slider events</td>
                                    </tr>
                                    <tr>
                                        <td><code>destroy()</code></td>
                                        <td>Destroy the slider instance</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Runtime Methods (SORangeSlider)</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>SORangeSlider.getInstance(el)</code></td>
                                        <td>Get SORangeSlider instance</td>
                                    </tr>
                                    <tr>
                                        <td><code>getValues()</code></td>
                                        <td>Get {min, max} values</td>
                                    </tr>
                                    <tr>
                                        <td><code>setValues(min, max)</code></td>
                                        <td>Set both min and max values</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Events</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Event</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so:slider:input</code></td>
                                        <td>Fires during drag (value, percentage)</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:slider:change</code></td>
                                        <td>Fires on value change (value, percentage, oldValue)</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:slider:start</code></td>
                                        <td>Fires when drag starts</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:slider:end</code></td>
                                        <td>Fires when drag ends</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <h5 class="so-mt-6 so-mb-3">CSS Classes Reference</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr>
                                <th style="width:40%">Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-slider</code></td>
                                <td>Base slider wrapper</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-input</code></td>
                                <td>Hidden native range input</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-track</code></td>
                                <td>Track background element</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-fill</code></td>
                                <td>Filled portion of track</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-thumb</code></td>
                                <td>Draggable handle</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-tooltip</code></td>
                                <td>Tooltip inside thumb</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-{size}</code></td>
                                <td>Size variants (xs, sm, lg)</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-{color}</code></td>
                                <td>Color variants (primary, secondary, success, danger, warning, info)</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-discrete</code></td>
                                <td>Shows tick marks</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-labeled</code></td>
                                <td>Shows tooltip on hover/focus</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-vertical</code></td>
                                <td>Vertical orientation</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-range</code></td>
                                <td>Dual thumb range slider</td>
                            </tr>
                            <tr>
                                <td><code>.so-slider-inline</code></td>
                                <td>Wrapper for slider with external value</td>
                            </tr>
                            <tr>
                                <td><code>.so-disabled</code></td>
                                <td>Disabled state</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // SOSlider Class
    class SOSlider {
        static instances = new Map();

        constructor(element, options = {}) {
            if (!(element instanceof HTMLElement)) return;

            this.element = element;
            this.input = element.querySelector('.so-slider-input');
            this.fill = element.querySelector('.so-slider-fill');
            this.thumb = element.querySelector('.so-slider-thumb');
            this.tooltip = element.querySelector('.so-slider-tooltip');
            this.ticks = element.querySelector('.so-slider-ticks');

            this.options = {
                output: element.dataset.soOutput || options.output || null,
                prefix: element.dataset.soPrefix || options.prefix || '',
                suffix: element.dataset.soSuffix || options.suffix || '',
                ticks: parseInt(element.dataset.soTicks) || options.ticks || 0,
                separator: element.dataset.soSeparator || options.separator || ' - '
            };

            this.isVertical = element.classList.contains('so-slider-vertical');
            this.isDragging = false;
            this.oldValue = parseFloat(this.input.value);

            this._init();
            SOSlider.instances.set(element, this);
        }

        static getInstance(element) {
            return SOSlider.instances.get(element);
        }

        static initAll() {
            document.querySelectorAll('[data-so-slider]').forEach(el => {
                if (!SOSlider.instances.has(el)) {
                    new SOSlider(el);
                }
            });
            // Initialize range sliders
            document.querySelectorAll('[data-so-slider-range]').forEach(el => {
                if (!SORangeSlider.instances.has(el)) {
                    new SORangeSlider(el);
                }
            });
        }

        _init() {
            this._updateUI();
            this._generateTicks();
            this._bindEvents();
        }

        _bindEvents() {
            this.input.addEventListener('input', (e) => this._onInput(e));
            this.input.addEventListener('change', (e) => this._onChange(e));
            this.input.addEventListener('mousedown', () => this._onStart());
            this.input.addEventListener('touchstart', () => this._onStart());
            this.input.addEventListener('mouseup', () => this._onEnd());
            this.input.addEventListener('touchend', () => this._onEnd());
        }

        _onInput(e) {
            this._updateUI();
            this._emit('so:slider:input', {
                value: this.getValue(),
                percentage: this._getPercentage()
            });
        }

        _onChange(e) {
            const newValue = this.getValue();
            this._emit('so:slider:change', {
                value: newValue,
                percentage: this._getPercentage(),
                oldValue: this.oldValue
            });
            this.oldValue = newValue;
        }

        _onStart() {
            this.isDragging = true;
            this.element.classList.add('dragging');
            this._emit('so:slider:start', {
                value: this.getValue()
            });
        }

        _onEnd() {
            this.isDragging = false;
            this.element.classList.remove('dragging');
            this._emit('so:slider:end', {
                value: this.getValue()
            });
        }

        _updateUI() {
            const percentage = this._getPercentage();

            if (this.isVertical) {
                this.fill.style.height = percentage + '%';
                this.thumb.style.bottom = percentage + '%';
            } else {
                this.fill.style.width = percentage + '%';
                this.thumb.style.left = percentage + '%';
            }

            // Update tooltip
            if (this.tooltip) {
                this.tooltip.textContent = this._formatValue(this.getValue());
            }

            // Update external output
            if (this.options.output) {
                const outputEl = document.querySelector(this.options.output);
                if (outputEl) {
                    outputEl.textContent = this._formatValue(this.getValue());
                }
            }

            // Update tick marks active state
            this._updateTicks();
        }

        _getPercentage() {
            const min = parseFloat(this.input.min) || 0;
            const max = parseFloat(this.input.max) || 100;
            const value = parseFloat(this.input.value);
            return ((value - min) / (max - min)) * 100;
        }

        _formatValue(value) {
            return this.options.prefix + value + this.options.suffix;
        }

        _generateTicks() {
            if (!this.ticks || this.options.ticks <= 0) return;

            this.ticks.innerHTML = '';
            for (let i = 0; i < this.options.ticks; i++) {
                const tick = document.createElement('span');
                tick.className = 'so-slider-tick';
                this.ticks.appendChild(tick);
            }
            this._updateTicks();
        }

        _updateTicks() {
            if (!this.ticks) return;

            const percentage = this._getPercentage();
            const ticks = this.ticks.querySelectorAll('.so-slider-tick');
            const tickCount = ticks.length;

            ticks.forEach((tick, index) => {
                const tickPercentage = (index / (tickCount - 1)) * 100;
                if (tickPercentage <= percentage) {
                    tick.classList.add('active');
                } else {
                    tick.classList.remove('active');
                }
            });
        }

        _emit(eventName, detail) {
            const event = new CustomEvent(eventName, {
                detail,
                bubbles: true
            });
            this.element.dispatchEvent(event);
        }

        // Public API
        getValue() {
            return parseFloat(this.input.value);
        }

        setValue(value) {
            const min = parseFloat(this.input.min) || 0;
            const max = parseFloat(this.input.max) || 100;
            this.input.value = Math.min(max, Math.max(min, value));
            this._updateUI();
            this._emit('so:slider:change', {
                value: this.getValue(),
                percentage: this._getPercentage(),
                oldValue: this.oldValue
            });
            this.oldValue = this.getValue();
        }

        enable() {
            this.input.disabled = false;
            this.element.classList.remove('so-disabled');
        }

        disable() {
            this.input.disabled = true;
            this.element.classList.add('so-disabled');
        }

        on(eventName, callback) {
            this.element.addEventListener('so:slider:' + eventName, (e) => callback(e.detail));
        }

        destroy() {
            SOSlider.instances.delete(this.element);
        }
    }

    // SORangeSlider Class for dual-thumb sliders
    class SORangeSlider {
        static instances = new Map();

        constructor(element, options = {}) {
            if (!(element instanceof HTMLElement)) return;

            this.element = element;
            this.inputMin = element.querySelector('.so-slider-input-min');
            this.inputMax = element.querySelector('.so-slider-input-max');
            this.track = element.querySelector('.so-slider-track');
            this.fill = element.querySelector('.so-slider-fill');
            this.thumbMin = element.querySelector('.so-slider-thumb-min');
            this.thumbMax = element.querySelector('.so-slider-thumb-max');

            this.options = {
                output: element.dataset.soOutput || options.output || null,
                prefix: element.dataset.soPrefix || options.prefix || '',
                suffix: element.dataset.soSuffix || options.suffix || '',
                separator: element.dataset.soSeparator || options.separator || ' - '
            };

            this.activeThumb = null;
            this.isDragging = false;

            this._init();
            SORangeSlider.instances.set(element, this);
        }

        static getInstance(element) {
            return SORangeSlider.instances.get(element);
        }

        _init() {
            this._updateUI();
            this._bindEvents();
        }

        _bindEvents() {
            // Native input events for keyboard accessibility
            this.inputMin.addEventListener('input', () => this._onInput('min'));
            this.inputMax.addEventListener('input', () => this._onInput('max'));

            // Custom drag handling for mouse/touch
            this.element.addEventListener('mousedown', (e) => this._onMouseDown(e));
            this.element.addEventListener('touchstart', (e) => this._onTouchStart(e), {
                passive: false
            });

            // Document-level handlers for drag
            document.addEventListener('mousemove', (e) => this._onMouseMove(e));
            document.addEventListener('mouseup', () => this._onMouseUp());
            document.addEventListener('touchmove', (e) => this._onTouchMove(e), {
                passive: false
            });
            document.addEventListener('touchend', () => this._onMouseUp());
        }

        _onMouseDown(e) {
            if (e.target.closest('.so-slider-track') || e.target.closest('.so-slider-input')) {
                e.preventDefault();
                this._startDrag(e.clientX);
            }
        }

        _onTouchStart(e) {
            if (e.target.closest('.so-slider-track') || e.target.closest('.so-slider-input')) {
                e.preventDefault();
                this._startDrag(e.touches[0].clientX);
            }
        }

        _startDrag(clientX) {
            const rect = this.track.getBoundingClientRect();
            const clickPercent = ((clientX - rect.left) / rect.width) * 100;

            const min = parseFloat(this.inputMin.min) || 0;
            const max = parseFloat(this.inputMin.max) || 100;
            const minVal = parseFloat(this.inputMin.value);
            const maxVal = parseFloat(this.inputMax.value);

            const minPercent = ((minVal - min) / (max - min)) * 100;
            const maxPercent = ((maxVal - min) / (max - min)) * 100;

            // Determine which thumb is closer
            const distToMin = Math.abs(clickPercent - minPercent);
            const distToMax = Math.abs(clickPercent - maxPercent);

            if (distToMin < distToMax) {
                this.activeThumb = 'min';
                this.inputMin.focus();
            } else {
                this.activeThumb = 'max';
                this.inputMax.focus();
            }

            this.isDragging = true;
            this.element.classList.add('dragging');
            this._updateFromPosition(clientX);
        }

        _onMouseMove(e) {
            if (!this.isDragging) return;
            e.preventDefault();
            this._updateFromPosition(e.clientX);
        }

        _onTouchMove(e) {
            if (!this.isDragging) return;
            e.preventDefault();
            this._updateFromPosition(e.touches[0].clientX);
        }

        _onMouseUp() {
            if (!this.isDragging) return;
            this.isDragging = false;
            this.activeThumb = null;
            this.element.classList.remove('dragging');
            this._emit('so:slider:change', this.getValues());
        }

        _updateFromPosition(clientX) {
            const rect = this.track.getBoundingClientRect();
            let percent = ((clientX - rect.left) / rect.width) * 100;
            percent = Math.max(0, Math.min(100, percent));

            const min = parseFloat(this.inputMin.min) || 0;
            const max = parseFloat(this.inputMin.max) || 100;
            const step = parseFloat(this.inputMin.step) || 1;

            let value = min + (percent / 100) * (max - min);
            value = Math.round(value / step) * step;
            value = Math.max(min, Math.min(max, value));

            const minVal = parseFloat(this.inputMin.value);
            const maxVal = parseFloat(this.inputMax.value);

            if (this.activeThumb === 'min') {
                if (value <= maxVal) {
                    this.inputMin.value = value;
                } else {
                    this.inputMin.value = maxVal;
                }
            } else if (this.activeThumb === 'max') {
                if (value >= minVal) {
                    this.inputMax.value = value;
                } else {
                    this.inputMax.value = minVal;
                }
            }

            this._updateUI();
            this._emit('so:slider:input', this.getValues());
        }

        _onInput(which) {
            let minVal = parseFloat(this.inputMin.value);
            let maxVal = parseFloat(this.inputMax.value);

            // Prevent crossing
            if (which === 'min' && minVal > maxVal) {
                this.inputMin.value = maxVal;
            } else if (which === 'max' && maxVal < minVal) {
                this.inputMax.value = minVal;
            }

            this._updateUI();
            this._emit('so:slider:input', this.getValues());
        }

        _updateUI() {
            const min = parseFloat(this.inputMin.min) || 0;
            const max = parseFloat(this.inputMin.max) || 100;
            const minVal = parseFloat(this.inputMin.value);
            const maxVal = parseFloat(this.inputMax.value);

            const minPercent = ((minVal - min) / (max - min)) * 100;
            const maxPercent = ((maxVal - min) / (max - min)) * 100;

            this.fill.style.left = minPercent + '%';
            this.fill.style.width = (maxPercent - minPercent) + '%';
            this.thumbMin.style.left = minPercent + '%';
            this.thumbMax.style.left = maxPercent + '%';

            // Update external output
            if (this.options.output) {
                const outputEl = document.querySelector(this.options.output);
                if (outputEl) {
                    outputEl.textContent = this._formatValue(minVal) + this.options.separator + this._formatValue(maxVal);
                }
            }
        }

        _formatValue(value) {
            return this.options.prefix + value + this.options.suffix;
        }

        _emit(eventName, detail) {
            const event = new CustomEvent(eventName, {
                detail,
                bubbles: true
            });
            this.element.dispatchEvent(event);
        }

        // Public API
        getValues() {
            return {
                min: parseFloat(this.inputMin.value),
                max: parseFloat(this.inputMax.value)
            };
        }

        setValues(minVal, maxVal) {
            this.inputMin.value = minVal;
            this.inputMax.value = maxVal;
            this._updateUI();
        }
    }

    // Initialize all sliders when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        SOSlider.initAll();
    });
</script>

<?php require_once '../../includes/footer.php'; ?>