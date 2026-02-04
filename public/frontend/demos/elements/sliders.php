<?php

/**
 * SixOrbit UI Demo - Sliders
 */
$pageTitle = 'Sliders';
$pageDescription = 'Range slider input components';

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
            <h1 class="so-page-title">Sliders</h1>
            <p class="so-page-subtitle">Range slider input components</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <div class="so-grid so-grid-cols-1 so-gap-6">

            <!-- Basic Slider -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Basic Slider</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">A simple range slider with default styling. All sliders are fully interactive.</p>

                    <div class="so-mb-6">
                        <div class="so-slider so-slider-primary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="50">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <?= so_code_block('<div class="so-slider so-slider-primary" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="50">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb"></div>
    </div>
</div>', 'html') ?>
                </div>
            </div>

            <!-- Slider Sizes -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Slider Sizes</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Sliders come in four sizes: extra small, small, default, and large.</p>

                    <div class="so-grid so-grid-cols-1 so-gap-6">
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

                    <?= so_code_block('<!-- Extra Small -->
<div class="so-slider so-slider-xs so-slider-primary" data-so-slider>...</div>

<!-- Small -->
<div class="so-slider so-slider-sm so-slider-primary" data-so-slider>...</div>

<!-- Default -->
<div class="so-slider so-slider-primary" data-so-slider>...</div>

<!-- Large -->
<div class="so-slider so-slider-lg so-slider-primary" data-so-slider>...</div>', 'html') ?>
                </div>
            </div>

            <!-- Color Variants -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Color Variants</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Eight color variants are available to match your design system.</p>

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

                        <!-- Light -->
                        <div>
                            <label class="so-slider-label">Light</label>
                            <div class="so-slider so-slider-light" data-so-slider>
                                <input type="range" class="so-slider-input" min="0" max="100" value="60">
                                <div class="so-slider-track">
                                    <div class="so-slider-fill"></div>
                                    <div class="so-slider-thumb"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Dark -->
                        <div>
                            <label class="so-slider-label">Dark</label>
                            <div class="so-slider so-slider-dark" data-so-slider>
                                <input type="range" class="so-slider-input" min="0" max="100" value="60">
                                <div class="so-slider-track">
                                    <div class="so-slider-fill"></div>
                                    <div class="so-slider-thumb"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= so_code_block('<div class="so-slider so-slider-primary" data-so-slider>...</div>
<div class="so-slider so-slider-secondary" data-so-slider>...</div>
<div class="so-slider so-slider-success" data-so-slider>...</div>
<div class="so-slider so-slider-danger" data-so-slider>...</div>
<div class="so-slider so-slider-warning" data-so-slider>...</div>
<div class="so-slider so-slider-info" data-so-slider>...</div>
<div class="so-slider so-slider-light" data-so-slider>...</div>
<div class="so-slider so-slider-dark" data-so-slider>...</div>', 'html') ?>
                </div>
            </div>

            <!-- Discrete Slider with Ticks -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Discrete Slider with Ticks</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Discrete sliders display tick marks at defined intervals. Use <code>step</code> attribute to define intervals.</p>

                    <div class="so-slider-wrapper so-mb-6">
                        <label class="so-slider-label">Select Volume (0-100, step 10)</label>
                        <div class="so-slider so-slider-discrete so-slider-primary" data-so-slider data-so-ticks="11">
                            <input type="range" class="so-slider-input" min="0" max="100" value="40" step="10">
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

                    <?= so_code_block('<div class="so-slider so-slider-discrete so-slider-primary" data-so-slider data-so-ticks="11">
    <input type="range" class="so-slider-input" min="0" max="100" value="40" step="10">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb"></div>
        <div class="so-slider-ticks"></div>
    </div>
</div>', 'html') ?>
                </div>
            </div>

            <!-- Slider with Tooltip -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Slider with Tooltip</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Shows a tooltip above the thumb displaying the current value on hover/focus.</p>

                    <div class="so-mb-6">
                        <div class="so-slider so-slider-labeled so-slider-primary" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="65">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb">
                                    <span class="so-slider-tooltip">65</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= so_code_block('<div class="so-slider so-slider-labeled so-slider-primary" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="65">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb">
            <span class="so-slider-tooltip">65</span>
        </div>
    </div>
</div>', 'html') ?>
                </div>
            </div>

            <!-- Slider with External Value Display -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Slider with External Value</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Display the slider value outside the slider using inline layout.</p>

                    <div class="so-slider-inline so-mb-6" id="inline-slider-demo">
                        <div class="so-slider so-slider-primary" data-so-slider data-so-output="#inline-value">
                            <input type="range" class="so-slider-input" min="0" max="100" value="70">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                        <span class="so-slider-value" id="inline-value">70</span>
                    </div>

                    <div class="so-slider-inline so-mb-6">
                        <span class="so-slider-value so-text-left" style="min-width: 60px;" id="price-min">$250</span>
                        <div class="so-slider so-slider-success" data-so-slider data-so-output="#price-min" data-so-prefix="$">
                            <input type="range" class="so-slider-input" min="0" max="1000" value="250">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                        <span class="so-slider-value">$1000</span>
                    </div>

                    <?= so_code_block('<div class="so-slider-inline">
    <div class="so-slider so-slider-primary" data-so-slider data-so-output="#my-value">
        <input type="range" class="so-slider-input" min="0" max="100" value="70">
        <div class="so-slider-track">
            <div class="so-slider-fill"></div>
            <div class="so-slider-thumb"></div>
        </div>
    </div>
    <span class="so-slider-value" id="my-value">70</span>
</div>', 'html') ?>
                </div>
            </div>

            <!-- Vertical Slider -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Vertical Slider</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Vertical sliders are useful for volume controls or similar interfaces.</p>

                    <div class="so-d-flex so-gap-8 so-mb-6">
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

                    <?= so_code_block('<div class="so-slider so-slider-vertical so-slider-primary" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="60">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb"></div>
    </div>
</div>', 'html') ?>
                </div>
            </div>

            <!-- Range Slider (Dual Thumb) -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Range Slider (Dual Thumb)</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Range sliders allow selecting a range between two values.</p>

                    <div class="so-slider-wrapper so-mb-6">
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

                    <?= so_code_block('<div class="so-slider so-slider-range so-slider-primary" data-so-slider-range>
    <input type="range" class="so-slider-input so-slider-input-min" min="0" max="1000" value="200">
    <input type="range" class="so-slider-input so-slider-input-max" min="0" max="1000" value="800">
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb so-slider-thumb-min"></div>
        <div class="so-slider-thumb so-slider-thumb-max"></div>
    </div>
</div>', 'html') ?>
                </div>
            </div>

            <!-- Disabled State -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Disabled State</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Disabled sliders cannot be interacted with.</p>

                    <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4 so-mb-6">
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

                    <?= so_code_block('<div class="so-slider so-slider-primary so-disabled" data-so-slider>
    <input type="range" class="so-slider-input" min="0" max="100" value="40" disabled>
    <div class="so-slider-track">
        <div class="so-slider-fill"></div>
        <div class="so-slider-thumb"></div>
    </div>
</div>', 'html') ?>
                </div>
            </div>

            <!-- Programmatic Controls -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Programmatic Controls</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Control sliders via JavaScript API. Try the controls below:</p>

                    <div class="so-mb-4">
                        <label class="so-slider-label">API Demo Slider: <span id="api-slider-value">50</span></label>
                        <div class="so-slider so-slider-primary" id="api-demo-slider" data-so-slider data-so-output="#api-slider-value">
                            <input type="range" class="so-slider-input" min="0" max="100" value="50">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-6">
                        <button class="so-btn so-btn-sm so-btn-primary" onclick="demoSlider.setValue(0)">Set to 0</button>
                        <button class="so-btn so-btn-sm so-btn-primary" onclick="demoSlider.setValue(25)">Set to 25</button>
                        <button class="so-btn so-btn-sm so-btn-primary" onclick="demoSlider.setValue(50)">Set to 50</button>
                        <button class="so-btn so-btn-sm so-btn-primary" onclick="demoSlider.setValue(75)">Set to 75</button>
                        <button class="so-btn so-btn-sm so-btn-primary" onclick="demoSlider.setValue(100)">Set to 100</button>
                        <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="demoSlider.disable()">Disable</button>
                        <button class="so-btn so-btn-sm so-btn-outline-success" onclick="demoSlider.enable()">Enable</button>
                        <button class="so-btn so-btn-sm so-btn-outline-info" onclick="alert('Value: ' + demoSlider.getValue())">Get Value</button>
                    </div>

                    <?= so_code_block("// Get slider instance
const slider = SOSlider.getInstance(document.getElementById('my-slider'));

// Set value programmatically
slider.setValue(75);

// Get current value
const value = slider.getValue();

// Enable/disable
slider.disable();
slider.enable();

// Listen to events
slider.on('change', (value) => {
    console.log('Value changed:', value);
});

// Destroy instance
slider.destroy();", 'javascript') ?>
                </div>
            </div>

            <!-- Events -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Events</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Sliders emit events that you can listen to. Try dragging the slider below and watch the console.</p>

                    <div class="so-mb-4">
                        <label class="so-slider-label">Event Demo Slider</label>
                        <div class="so-slider so-slider-info" id="events-demo-slider" data-so-slider>
                            <input type="range" class="so-slider-input" min="0" max="100" value="50">
                            <div class="so-slider-track">
                                <div class="so-slider-fill"></div>
                                <div class="so-slider-thumb"></div>
                            </div>
                        </div>
                    </div>

                    <div class="so-alert so-alert-info so-mb-4" id="event-log">
                        <span class="material-icons">info</span>
                        <span>Event log will appear here. Drag the slider above.</span>
                    </div>

                    <?= so_code_block("const sliderEl = document.getElementById('my-slider');

// Native input event (fires continuously while dragging)
sliderEl.addEventListener('so:slider:input', (e) => {
    console.log('Input:', e.detail.value);
});

// Native change event (fires when drag ends)
sliderEl.addEventListener('so:slider:change', (e) => {
    console.log('Change:', e.detail.value);
});

// Start dragging
sliderEl.addEventListener('so:slider:start', (e) => {
    console.log('Started dragging at:', e.detail.value);
});

// Stop dragging
sliderEl.addEventListener('so:slider:end', (e) => {
    console.log('Stopped dragging at:', e.detail.value);
});", 'javascript') ?>

                    <h5 class="so-mt-6 so-mb-3">Available Events</h5>
                    <div class="so-table-responsive">
                        <table class="so-table so-table-bordered">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Description</th>
                                    <th>Detail Properties</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>so:slider:input</code></td>
                                    <td>Fires continuously while dragging</td>
                                    <td><code>{ value, percentage }</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:slider:change</code></td>
                                    <td>Fires when value changes and drag ends</td>
                                    <td><code>{ value, percentage, oldValue }</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:slider:start</code></td>
                                    <td>Fires when user starts dragging</td>
                                    <td><code>{ value }</code></td>
                                </tr>
                                <tr>
                                    <td><code>so:slider:end</code></td>
                                    <td>Fires when user stops dragging</td>
                                    <td><code>{ value }</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="so-card">
                <div class="so-card-header">
                    <h3 class="so-card-title">Options</h3>
                </div>
                <div class="so-card-body">
                    <p class="so-text-muted so-mb-4">Configure sliders using data attributes or JavaScript options.</p>

                    <div class="so-table-responsive">
                        <table class="so-table so-table-bordered">
                            <thead>
                                <tr>
                                    <th>Option</th>
                                    <th>Data Attribute</th>
                                    <th>Type</th>
                                    <th>Default</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>output</code></td>
                                    <td><code>data-so-output</code></td>
                                    <td>string</td>
                                    <td><code>null</code></td>
                                    <td>CSS selector for external value display element</td>
                                </tr>
                                <tr>
                                    <td><code>prefix</code></td>
                                    <td><code>data-so-prefix</code></td>
                                    <td>string</td>
                                    <td><code>''</code></td>
                                    <td>Prefix for displayed value (e.g., '$')</td>
                                </tr>
                                <tr>
                                    <td><code>suffix</code></td>
                                    <td><code>data-so-suffix</code></td>
                                    <td>string</td>
                                    <td><code>''</code></td>
                                    <td>Suffix for displayed value (e.g., '%')</td>
                                </tr>
                                <tr>
                                    <td><code>ticks</code></td>
                                    <td><code>data-so-ticks</code></td>
                                    <td>number</td>
                                    <td><code>0</code></td>
                                    <td>Number of tick marks to display</td>
                                </tr>
                                <tr>
                                    <td><code>separator</code></td>
                                    <td><code>data-so-separator</code></td>
                                    <td>string</td>
                                    <td><code>' - '</code></td>
                                    <td>Separator for range slider output</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= so_code_block("// Initialize with options
const slider = new SOSlider(element, {
    output: '#value-display',
    prefix: '\$',
    suffix: '',
    ticks: 11
});

// Or use data attributes
<div class=\"so-slider so-slider-primary\"
     data-so-slider
     data-so-output=\"#value-display\"
     data-so-prefix=\"\$\">
    ...
</div>", 'javascript') ?>
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
                                    <td><code>.so-slider-xs</code></td>
                                    <td>Extra small size variant</td>
                                </tr>
                                <tr>
                                    <td><code>.so-slider-sm</code></td>
                                    <td>Small size variant</td>
                                </tr>
                                <tr>
                                    <td><code>.so-slider-lg</code></td>
                                    <td>Large size variant</td>
                                </tr>
                                <tr>
                                    <td><code>.so-slider-{color}</code></td>
                                    <td>Color variants (primary, secondary, success, danger, warning, info, light, dark)</td>
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
                                    <td><code>.disabled</code></td>
                                    <td>Disabled state</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

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
                this.element.classList.remove('disabled');
            }

            disable() {
                this.input.disabled = true;
                this.element.classList.add('disabled');
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

                // If click is between thumbs, choose based on direction
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
                // Snap to step
                value = Math.round(value / step) * step;
                value = Math.max(min, Math.min(max, value));

                const minVal = parseFloat(this.inputMin.value);
                const maxVal = parseFloat(this.inputMax.value);

                if (this.activeThumb === 'min') {
                    // Don't let min exceed max
                    if (value <= maxVal) {
                        this.inputMin.value = value;
                    } else {
                        this.inputMin.value = maxVal;
                    }
                } else if (this.activeThumb === 'max') {
                    // Don't let max go below min
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

            // API Demo slider reference
            window.demoSlider = SOSlider.getInstance(document.getElementById('api-demo-slider'));

            // Events demo
            const eventsSlider = document.getElementById('events-demo-slider');
            const eventLog = document.getElementById('event-log');

            if (eventsSlider && eventLog) {
                eventsSlider.addEventListener('so:slider:input', (e) => {
                    eventLog.innerHTML = '<span class="material-icons">sync</span><span><strong>input:</strong> value=' + e.detail.value + ', percentage=' + e.detail.percentage.toFixed(1) + '%</span>';
                });

                eventsSlider.addEventListener('so:slider:change', (e) => {
                    eventLog.innerHTML = '<span class="material-icons">check_circle</span><span><strong>change:</strong> value=' + e.detail.value + ', oldValue=' + e.detail.oldValue + '</span>';
                });

                eventsSlider.addEventListener('so:slider:start', (e) => {
                    eventLog.innerHTML = '<span class="material-icons">play_arrow</span><span><strong>start:</strong> began dragging at value=' + e.detail.value + '</span>';
                });

                eventsSlider.addEventListener('so:slider:end', (e) => {
                    eventLog.innerHTML = '<span class="material-icons">stop</span><span><strong>end:</strong> stopped dragging at value=' + e.detail.value + '</span>';
                });
            }
        });
    </script>

</main>

<?php
require_once '../includes/footer.php';
?>