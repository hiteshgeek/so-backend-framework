<?php
/**
 * SixOrbit UI Engine - Color Input Element Demo
 */

$pageTitle = 'Color Input - UI Engine';
$pageDescription = 'Color picker input with various formats and presets';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Color Input</h1>
            <p class="so-page-subtitle">Color picker input with hex, RGB, and HSL format support, preset colors, and alpha channel.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Color Input -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Color Input</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">A simple color picker using the native HTML5 color input.</p>

                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label" for="demo-color">Choose Color</label>
                    <input type="color" class="so-form-control so-form-control-color" id="demo-color" name="color" value="#3b82f6">
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-color', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$color = UiEngine::color('theme_color')
    ->label('Choose Color')
    ->value('#3b82f6');

echo \$color->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const color = UiEngine.color('theme_color')
    .label('Choose Color')
    .value('#3b82f6');

document.getElementById('container').innerHTML = color.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label" for="theme_color">Choose Color</label>
    <div class="so-color-input-wrapper">
        <input type="color" class="so-form-control so-form-control-color"
               id="theme_color" name="theme_color" value="#3b82f6"
               data-so-ui-init="color-input">
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Preset Colors -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Preset Colors</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Provide quick color selection with preset swatches.</p>

                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Brand Color</label>
                    <div class="so-color-presets so-d-flex so-gap-2 so-mb-2">
                        <button type="button" class="so-color-preset-btn" style="width:32px;height:32px;background:#ef4444;border-radius:4px;border:2px solid transparent;cursor:pointer;" onclick="document.getElementById('demo-preset').value='#ef4444'" title="#ef4444"></button>
                        <button type="button" class="so-color-preset-btn" style="width:32px;height:32px;background:#f97316;border-radius:4px;border:2px solid transparent;cursor:pointer;" onclick="document.getElementById('demo-preset').value='#f97316'" title="#f97316"></button>
                        <button type="button" class="so-color-preset-btn" style="width:32px;height:32px;background:#eab308;border-radius:4px;border:2px solid transparent;cursor:pointer;" onclick="document.getElementById('demo-preset').value='#eab308'" title="#eab308"></button>
                        <button type="button" class="so-color-preset-btn" style="width:32px;height:32px;background:#22c55e;border-radius:4px;border:2px solid transparent;cursor:pointer;" onclick="document.getElementById('demo-preset').value='#22c55e'" title="#22c55e"></button>
                        <button type="button" class="so-color-preset-btn" style="width:32px;height:32px;background:#3b82f6;border-radius:4px;border:2px solid transparent;cursor:pointer;" onclick="document.getElementById('demo-preset').value='#3b82f6'" title="#3b82f6"></button>
                        <button type="button" class="so-color-preset-btn" style="width:32px;height:32px;background:#8b5cf6;border-radius:4px;border:2px solid transparent;cursor:pointer;" onclick="document.getElementById('demo-preset').value='#8b5cf6'" title="#8b5cf6"></button>
                    </div>
                    <input type="color" class="so-form-control so-form-control-color" id="demo-preset" value="#3b82f6">
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-presets', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Custom preset colors
\$color = UiEngine::color('brand_color')
    ->label('Brand Color')
    ->presets([
        '#ef4444', // Red
        '#f97316', // Orange
        '#eab308', // Yellow
        '#22c55e', // Green
        '#3b82f6', // Blue
        '#8b5cf6', // Purple
    ])
    ->value('#3b82f6');

// Bootstrap color presets
\$bootstrap = UiEngine::color('theme_color')
    ->label('Theme Color')
    ->bootstrapPresets()
    ->value('#0d6efd');

// Add preset dynamically
\$dynamic = UiEngine::color('accent_color')
    ->label('Accent Color')
    ->addPreset('#ff0000')
    ->addPreset('#00ff00')
    ->addPreset('#0000ff');

echo \$color->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Custom preset colors
const color = UiEngine.color('brand_color')
    .label('Brand Color')
    .presets([
        '#ef4444', '#f97316', '#eab308',
        '#22c55e', '#3b82f6', '#8b5cf6'
    ])
    .value('#3b82f6');

// Bootstrap color presets
const bootstrap = UiEngine.color('theme_color')
    .label('Theme Color')
    .bootstrapPresets()
    .value('#0d6efd');

// Add preset dynamically
const dynamic = UiEngine.color('accent_color')
    .label('Accent Color')
    .addPreset('#ff0000')
    .addPreset('#00ff00')
    .addPreset('#0000ff');

document.getElementById('container').innerHTML = color.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label">Brand Color</label>
    <div class="so-color-input-wrapper">
        <input type="color" class="so-form-control so-form-control-color"
               name="brand_color" value="#3b82f6"
               data-so-ui-init="color-input"
               data-so-ui-config=\'{"presets":["#ef4444","#f97316"]}\'>
    </div>
    <div class="so-color-presets">
        <button type="button" class="so-color-preset-btn" style="background:#ef4444" data-so-color="#ef4444"></button>
        <button type="button" class="so-color-preset-btn" style="background:#f97316" data-so-color="#f97316"></button>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Color Formats -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Formats</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Support for different color formats: hex, RGB, HSL, and with alpha channel.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-formats', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Hex format (default)
\$hex = UiEngine::color('hex_color')
    ->label('Hex Color')
    ->hex()  // or ->format('hex')
    ->value('#3b82f6');

// RGB format
\$rgb = UiEngine::color('rgb_color')
    ->label('RGB Color')
    ->rgb()  // or ->format('rgb')
    ->value('rgb(59, 130, 246)');

// HSL format
\$hsl = UiEngine::color('hsl_color')
    ->label('HSL Color')
    ->hsl()  // or ->format('hsl')
    ->value('hsl(217, 91%, 60%)');

// With alpha channel (RGBA/HSLA)
\$rgba = UiEngine::color('rgba_color')
    ->label('Color with Opacity')
    ->rgb()
    ->alpha()  // Enable alpha channel
    ->value('rgba(59, 130, 246, 0.8)');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Hex format (default)
const hex = UiEngine.color('hex_color')
    .label('Hex Color')
    .hex()  // or .format('hex')
    .value('#3b82f6');

// RGB format
const rgb = UiEngine.color('rgb_color')
    .label('RGB Color')
    .rgb()  // or .format('rgb')
    .value('rgb(59, 130, 246)');

// HSL format
const hsl = UiEngine.color('hsl_color')
    .label('HSL Color')
    .hsl()  // or .format('hsl')
    .value('hsl(217, 91%, 60%)');

// With alpha channel
const rgba = UiEngine.color('rgba_color')
    .label('Color with Opacity')
    .rgb()
    .alpha()  // Enable alpha channel
    .value('rgba(59, 130, 246, 0.8)');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Text Input -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Text Input</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Show a text input alongside the color picker for manual hex entry.</p>

                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Background Color</label>
                    <div class="so-color-input-wrapper so-d-flex so-gap-2">
                        <input type="color" class="so-form-control so-form-control-color" id="demo-combined" value="#3b82f6" style="width:50px;">
                        <input type="text" class="so-form-control so-color-input-text" id="demo-combined-text" value="#3b82f6" placeholder="#000000" pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                </div>

                <script>
                    document.getElementById('demo-combined').addEventListener('input', function(e) {
                        document.getElementById('demo-combined-text').value = e.target.value;
                    });
                    document.getElementById('demo-combined-text').addEventListener('input', function(e) {
                        if (/^#[0-9A-Fa-f]{6}$/.test(e.target.value)) {
                            document.getElementById('demo-combined').value = e.target.value;
                        }
                    });
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-text', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Show text input (default is true)
\$color = UiEngine::color('bg_color')
    ->label('Background Color')
    ->showInput()  // Show text input for manual entry
    ->value('#3b82f6');

// Hide text input (color picker only)
\$pickerOnly = UiEngine::color('accent')
    ->label('Accent Color')
    ->hideInput()  // or ->showInput(false)
    ->value('#ef4444');

echo \$color->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Show text input
const color = UiEngine.color('bg_color')
    .label('Background Color')
    .showInput()  // Show text input for manual entry
    .value('#3b82f6');

// Hide text input
const pickerOnly = UiEngine.color('accent')
    .label('Accent Color')
    .hideInput()  // or .showInput(false)
    .value('#ef4444');

document.getElementById('container').innerHTML = color.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label">Background Color</label>
    <div class="so-color-input-wrapper">
        <input type="color" class="so-form-control so-form-control-color"
               name="bg_color" value="#3b82f6">
        <input type="text" class="so-form-control so-color-input-text"
               value="#3b82f6" pattern="^#[0-9A-Fa-f]{6}$">
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">States</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Color input with disabled and readonly states.</p>

                <!-- Live Demo -->
                <div class="so-row so-g-3">
                    <div class="so-col-md-4">
                        <label class="so-form-label">Normal</label>
                        <input type="color" class="so-form-control so-form-control-color" value="#3b82f6">
                    </div>
                    <div class="so-col-md-4">
                        <label class="so-form-label">Disabled</label>
                        <input type="color" class="so-form-control so-form-control-color" value="#9ca3af" disabled>
                    </div>
                    <div class="so-col-md-4">
                        <label class="so-form-label">Readonly</label>
                        <input type="color" class="so-form-control so-form-control-color" value="#22c55e" readonly>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Disabled state
\$disabled = UiEngine::color('locked_color')
    ->label('Locked Color')
    ->value('#9ca3af')
    ->disabled();

// Readonly state
\$readonly = UiEngine::color('fixed_color')
    ->label('Fixed Color')
    ->value('#22c55e')
    ->readonly();

// Required field
\$required = UiEngine::color('brand_color')
    ->label('Brand Color')
    ->required()
    ->value('#3b82f6');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Disabled state
const disabled = UiEngine.color('locked_color')
    .label('Locked Color')
    .value('#9ca3af')
    .setDisabled();

// Readonly state
const readonly = UiEngine.color('fixed_color')
    .label('Fixed Color')
    .value('#22c55e')
    .setReadonly();

// Required field
const required = UiEngine.color('brand_color')
    .label('Brand Color')
    .setRequired()
    .value('#3b82f6');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Color input in different sizes.</p>

                <!-- Live Demo -->
                <div class="so-d-flex so-align-items-end so-gap-3">
                    <div>
                        <label class="so-form-label">Small</label>
                        <input type="color" class="so-form-control so-form-control-color so-form-control-sm" value="#ef4444">
                    </div>
                    <div>
                        <label class="so-form-label">Default</label>
                        <input type="color" class="so-form-control so-form-control-color" value="#3b82f6">
                    </div>
                    <div>
                        <label class="so-form-label">Large</label>
                        <input type="color" class="so-form-control so-form-control-color so-form-control-lg" value="#22c55e">
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small size
\$small = UiEngine::color('small_color')
    ->label('Small')
    ->small()  // or ->size('sm')
    ->value('#ef4444');

// Default (medium) size
\$default = UiEngine::color('default_color')
    ->label('Default')
    ->value('#3b82f6');

// Large size
\$large = UiEngine::color('large_color')
    ->label('Large')
    ->large()  // or ->size('lg')
    ->value('#22c55e');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Size variants via addClass
const small = UiEngine.color('small_color')
    .label('Small')
    .addClass('so-form-control-sm')
    .value('#ef4444');

const large = UiEngine.color('large_color')
    .label('Large')
    .addClass('so-form-control-lg')
    .value('#22c55e');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Error State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Error State</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Display validation errors on color input.</p>

                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Primary Color <span class="so-text-danger">*</span></label>
                    <input type="color" class="so-form-control so-form-control-color so-is-invalid" id="demo-error" value="#000000">
                    <div class="so-invalid-feedback so-d-block">Please select a color other than black.</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-error', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Set error message
\$color = UiEngine::color('primary_color')
    ->label('Primary Color')
    ->required()
    ->value('#000000')
    ->error('Please select a color other than black.');

echo \$color->renderGroup();

// Check for errors
if (\$color->hasError()) {
    \$errorMessage = \$color->getError();
}"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Set error message
const color = UiEngine.color('primary_color')
    .label('Primary Color')
    .setRequired()
    .value('#000000')
    .setError('Please select a color other than black.');

// Check for errors
if (color.hasError()) {
    console.log(color.getError());
}

// Clear error
color.clearError();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label">Primary Color <span class="so-text-danger">*</span></label>
    <div class="so-color-input-wrapper">
        <input type="color" class="so-form-control so-form-control-color so-is-invalid"
               name="primary_color" value="#000000" required>
    </div>
    <div class="so-invalid-feedback">Please select a color other than black.</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Help Text -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Help Text</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Link Color</label>
                    <input type="color" class="so-form-control so-form-control-color" value="#3b82f6">
                    <div class="so-form-text">Choose a color that meets WCAG contrast requirements.</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-help', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$color = UiEngine::color('link_color')
    ->label('Link Color')
    ->value('#3b82f6')
    ->help('Choose a color that meets WCAG contrast requirements.');

echo \$color->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const color = UiEngine.color('link_color')
    .label('Link Color')
    .value('#3b82f6')
    .setHelp('Choose a color that meets WCAG contrast requirements.');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- JavaScript Interactivity -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript Interactivity</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Color inputs use native DOM events. Interact with the demo below.</p>

                <!-- Live Demo -->
                <div class="so-mb-3">
                    <label class="so-form-label" for="demo-js-color">Interactive Color</label>
                    <input type="color" class="so-form-control so-form-control-color" id="demo-js-color" value="#3b82f6">
                </div>
                <div class="so-d-flex so-gap-2 so-mb-3">
                    <button class="so-btn so-btn-primary so-btn-sm" onclick="document.getElementById('demo-js-color').value = '#ef4444'">Set Red</button>
                    <button class="so-btn so-btn-success so-btn-sm" onclick="document.getElementById('demo-js-color').value = '#22c55e'">Set Green</button>
                    <button class="so-btn so-btn-info so-btn-sm" onclick="document.getElementById('demo-js-color').value = '#3b82f6'">Set Blue</button>
                    <button class="so-btn so-btn-outline-secondary so-btn-sm" onclick="document.getElementById('demo-js-color').disabled = !document.getElementById('demo-js-color').disabled">Toggle Disabled</button>
                </div>
                <div id="color-event-output" class="so-alert so-alert-info">Select a color to see events.</div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const colorInput = document.getElementById('demo-js-color');
                        const output = document.getElementById('color-event-output');

                        colorInput.addEventListener('input', function(e) {
                            output.innerHTML = '<strong>input</strong> event: ' + e.target.value;
                            output.style.backgroundColor = e.target.value;
                            output.style.color = getContrastColor(e.target.value);
                        });

                        colorInput.addEventListener('change', function(e) {
                            output.innerHTML = '<strong>change</strong> event (picker closed): ' + e.target.value;
                        });

                        function getContrastColor(hex) {
                            const r = parseInt(hex.slice(1, 3), 16);
                            const g = parseInt(hex.slice(3, 5), 16);
                            const b = parseInt(hex.slice(5, 7), 16);
                            const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
                            return luminance > 0.5 ? '#000000' : '#ffffff';
                        }
                    });
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-js-interactivity', [
                    [
                        'label' => 'Getting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Get the color input element
const colorInput = document.querySelector('input[name=\"theme_color\"]');

// Get current value (hex format)
const currentColor = colorInput.value;  // '#3b82f6'

// Check if disabled
const isDisabled = colorInput.disabled;  // true or false

// Check if required
const isRequired = colorInput.required;  // true or false"
                    ],
                    [
                        'label' => 'Setting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const colorInput = document.querySelector('input[name=\"theme_color\"]');

// Set color value (must be 7-character hex)
colorInput.value = '#ef4444';

// Enable/disable
colorInput.disabled = true;
colorInput.disabled = false;

// Set required
colorInput.required = true;

// Programmatically trigger change
colorInput.dispatchEvent(new Event('change', { bubbles: true }));"
                    ],
                    [
                        'label' => 'Event Handling',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const colorInput = document.querySelector('input[name=\"theme_color\"]');

// input event - fires continuously while selecting
colorInput.addEventListener('input', function(e) {
    console.log('Color changing:', e.target.value);
    // Update preview in real-time
    document.querySelector('.preview').style.backgroundColor = e.target.value;
});

// change event - fires when picker is closed
colorInput.addEventListener('change', function(e) {
    console.log('Color selected:', e.target.value);
});

// Event delegation for multiple color inputs
document.addEventListener('input', function(e) {
    if (e.target.matches('.so-form-control-color')) {
        console.log('Color changed:', e.target.name, e.target.value);
    }
});"
                    ],
                    [
                        'label' => 'DOM Manipulation',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const colorInput = document.querySelector('input[name=\"theme_color\"]');

// Add/remove classes
colorInput.classList.add('so-is-invalid');
colorInput.classList.remove('so-is-invalid');

// Add error state
function showColorError(input, message) {
    input.classList.add('so-is-invalid');
    const wrapper = input.closest('.so-form-group');
    let errorEl = wrapper.querySelector('.so-invalid-feedback');
    if (!errorEl) {
        errorEl = document.createElement('div');
        errorEl.className = 'so-invalid-feedback so-d-block';
        wrapper.appendChild(errorEl);
    }
    errorEl.textContent = message;
}

// Clear error state
function clearColorError(input) {
    input.classList.remove('so-is-invalid');
    const errorEl = input.closest('.so-form-group').querySelector('.so-invalid-feedback');
    if (errorEl) errorEl.remove();
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- PHP Event Handlers -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP Event Handlers</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Set JavaScript event handlers from PHP using the HasEvents trait.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-php-events', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Set individual event handlers
\$color = UiEngine::color('theme_color')
    ->label('Theme Color')
    ->value('#3b82f6')
    ->onChange('handleColorChange(this)')
    ->onInput('previewColor(this.value)')
    ->onFocus('colorPickerOpened(this)')
    ->onBlur('colorPickerClosed(this)');

// Multiple events at once
\$color2 = UiEngine::color('brand_color')
    ->label('Brand Color')
    ->onMany([
        'change' => 'saveBrandColor(this.value)',
        'input' => 'updateBrandPreview(this.value)',
    ]);

// Generic event handler
\$color3 = UiEngine::color('accent_color')
    ->label('Accent Color')
    ->on('change', 'trackColorChange(event)');

echo \$color->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript Handlers',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Define the handler functions referenced in PHP
function handleColorChange(input) {
    console.log('Color changed to:', input.value);
    document.documentElement.style.setProperty('--theme-color', input.value);
}

function previewColor(value) {
    document.querySelector('.color-preview').style.backgroundColor = value;
}

function saveBrandColor(value) {
    fetch('/api/settings/brand-color', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ color: value })
    });
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Validation -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Color input validation using the HasValidation trait.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-validation', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Required validation
\$color = UiEngine::color('primary_color')
    ->label('Primary Color')
    ->required('Please select a primary color');

// Using rules() method
\$theme = UiEngine::color('theme_color')
    ->label('Theme Color')
    ->rules('required');

// Custom validation messages
\$accent = UiEngine::color('accent_color')
    ->label('Accent Color')
    ->required()
    ->messages([
        'required' => 'An accent color is required for your theme.',
    ]);

// Export validation for JavaScript
\$validation = \$color->exportValidation();
// Returns: ['rules' => ['required' => true], 'messages' => [...]]"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Client-side color validation
function validateColorInput(input) {
    const value = input.value;
    const wrapper = input.closest('.so-form-group');

    // Clear previous error
    input.classList.remove('so-is-invalid');
    const existingError = wrapper.querySelector('.so-invalid-feedback');
    if (existingError) existingError.remove();

    // Check required
    if (input.hasAttribute('required') && !value) {
        showError(input, 'Please select a color');
        return false;
    }

    // Check valid hex format
    if (!/^#[0-9A-Fa-f]{6}\$/.test(value)) {
        showError(input, 'Invalid color format');
        return false;
    }

    return true;
}

function showError(input, message) {
    input.classList.add('so-is-invalid');
    const error = document.createElement('div');
    error.className = 'so-invalid-feedback so-d-block';
    error.textContent = message;
    input.closest('.so-form-group').appendChild(error);
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Handling</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Handle and display validation errors for color inputs.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-error-handling', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Server-side validation
\$color = request()->input('brand_color');

// Validate hex format
if (!preg_match('/^#[0-9A-Fa-f]{6}\$/', \$color)) {
    \$errors['brand_color'] = 'Invalid color format. Use hex (#RRGGBB).';
}

// Create element with error
\$colorInput = UiEngine::color('brand_color')
    ->label('Brand Color')
    ->value(\$color ?? '#000000')
    ->required();

// Apply error from validation
if (isset(\$errors['brand_color'])) {
    \$colorInput->error(\$errors['brand_color']);
}

echo \$colorInput->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Display error on color input
function showColorError(input, message) {
    const wrapper = input.closest('.so-form-group');
    input.classList.add('so-is-invalid');

    const existing = wrapper.querySelector('.so-invalid-feedback');
    if (existing) existing.remove();

    const error = document.createElement('div');
    error.className = 'so-invalid-feedback so-d-block';
    error.textContent = message;
    wrapper.appendChild(error);
}

// Clear error
function clearColorError(input) {
    const wrapper = input.closest('.so-form-group');
    input.classList.remove('so-is-invalid');
    const error = wrapper.querySelector('.so-invalid-feedback');
    if (error) error.remove();
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Export color input configuration from PHP for JavaScript.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('color-php-js', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Create color input with full configuration
\$color = UiEngine::color('brand_color')
    ->id('brand-color-picker')
    ->label('Brand Color')
    ->value('#3b82f6')
    ->presets(['#ef4444', '#f97316', '#3b82f6'])
    ->format('hex')
    ->showInput()
    ->required();

// Export to array for JSON
\$config = \$color->toArray();

// Pass to JavaScript
echo '<script>window.colorConfig = ' . json_encode(\$config) . ';</script>';

// Export validation separately
\$validation = \$color->exportValidation();
echo '<script>window.colorValidation = ' . json_encode(\$validation) . ';</script>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Access configuration from window
const config = window.colorConfig;
console.log(config.name);     // 'brand_color'
console.log(config.value);    // '#3b82f6'
console.log(config.presets);  // ['#ef4444', ...]

// Initialize color input from config
function initColorFromConfig(config, targetEl) {
    const input = targetEl.querySelector('input[type=\"color\"]');
    if (!input) return;

    if (config.value) input.value = config.value;
    if (config.disabled) input.disabled = true;
    if (config.required) input.required = true;
}

// Get validation rules
const validation = window.colorValidation;
// { rules: { required: true }, messages: {...} }"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
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
                                <td><code>so-form-control</code></td>
                                <td>Base form control class. Applied to all form inputs.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-control-color</code></td>
                                <td>Color input specific styling.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-control-sm</code></td>
                                <td>Small size variant.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-control-lg</code></td>
                                <td>Large size variant.</td>
                            </tr>
                            <tr>
                                <td><code>so-color-input-wrapper</code></td>
                                <td>Wrapper for color picker and text input.</td>
                            </tr>
                            <tr>
                                <td><code>so-color-input-text</code></td>
                                <td>Text input for manual hex entry.</td>
                            </tr>
                            <tr>
                                <td><code>so-color-presets</code></td>
                                <td>Container for preset color swatches.</td>
                            </tr>
                            <tr>
                                <td><code>so-color-preset-btn</code></td>
                                <td>Individual preset color button.</td>
                            </tr>
                            <tr>
                                <td><code>so-is-invalid</code></td>
                                <td>Error state class.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-group</code></td>
                                <td>Wrapper for form field with label, help, error.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-label</code></td>
                                <td>Label styling.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-text</code></td>
                                <td>Help text styling.</td>
                            </tr>
                            <tr>
                                <td><code>so-invalid-feedback</code></td>
                                <td>Error message styling.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <!-- Tabs Navigation -->
                <div class="so-tabs so-mb-3" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#color-methods">ColorInput Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#color-form-methods">Form Element</button>
                    <button class="so-tab" role="tab" data-so-target="#color-validation-methods">Validation</button>
                    <button class="so-tab" role="tab" data-so-target="#color-event-methods">Events</button>
                    <button class="so-tab" role="tab" data-so-target="#color-base-methods">Base Element</button>
                </div>

                <!-- Tab Panes -->
                <div class="so-tab-content">
                    <!-- ColorInput Methods -->
                    <div class="so-tab-pane so-fade so-show so-active" id="color-methods">
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
                                        <td><code>presets()</code></td>
                                        <td><code>array $colors</code></td>
                                        <td>Set preset color swatches</td>
                                    </tr>
                                    <tr>
                                        <td><code>addPreset()</code></td>
                                        <td><code>string $color</code></td>
                                        <td>Add a single preset color</td>
                                    </tr>
                                    <tr>
                                        <td><code>bootstrapPresets()</code></td>
                                        <td>-</td>
                                        <td>Use Bootstrap default color palette</td>
                                    </tr>
                                    <tr>
                                        <td><code>showInput()</code></td>
                                        <td><code>bool $show = true</code></td>
                                        <td>Show text input for manual entry</td>
                                    </tr>
                                    <tr>
                                        <td><code>hideInput()</code></td>
                                        <td>-</td>
                                        <td>Hide the text input</td>
                                    </tr>
                                    <tr>
                                        <td><code>format()</code></td>
                                        <td><code>string $format</code></td>
                                        <td>Set format: 'hex', 'rgb', 'hsl'</td>
                                    </tr>
                                    <tr>
                                        <td><code>hex()</code></td>
                                        <td>-</td>
                                        <td>Set hex format (default)</td>
                                    </tr>
                                    <tr>
                                        <td><code>rgb()</code></td>
                                        <td>-</td>
                                        <td>Set RGB format</td>
                                    </tr>
                                    <tr>
                                        <td><code>hsl()</code></td>
                                        <td>-</td>
                                        <td>Set HSL format</td>
                                    </tr>
                                    <tr>
                                        <td><code>alpha()</code></td>
                                        <td><code>bool $alpha = true</code></td>
                                        <td>Enable alpha/opacity channel</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Form Element Methods -->
                    <div class="so-tab-pane so-fade" id="color-form-methods">
                        <p class="so-text-muted so-mb-2">Inherited from <code>FormElement</code> class:</p>
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
                                    <tr><td><code>name()</code></td><td><code>string $name</code></td><td>Set the field name</td></tr>
                                    <tr><td><code>label()</code></td><td><code>string $label</code></td><td>Set the label text</td></tr>
                                    <tr><td><code>value()</code></td><td><code>mixed $value</code></td><td>Set the color value (#RRGGBB)</td></tr>
                                    <tr><td><code>placeholder()</code></td><td><code>string $text</code></td><td>Set placeholder text</td></tr>
                                    <tr><td><code>help()</code></td><td><code>string $help</code></td><td>Set help text</td></tr>
                                    <tr><td><code>disabled()</code></td><td><code>bool $disabled = true</code></td><td>Disable the input</td></tr>
                                    <tr><td><code>readonly()</code></td><td><code>bool $readonly = true</code></td><td>Set readonly state</td></tr>
                                    <tr><td><code>error()</code></td><td><code>?string $error</code></td><td>Set error message</td></tr>
                                    <tr><td><code>hasError()</code></td><td>-</td><td>Check if has error</td></tr>
                                    <tr><td><code>getError()</code></td><td>-</td><td>Get error message</td></tr>
                                    <tr><td><code>size()</code></td><td><code>string $size</code></td><td>Set size (sm, md, lg)</td></tr>
                                    <tr><td><code>small()</code></td><td>-</td><td>Set small size</td></tr>
                                    <tr><td><code>large()</code></td><td>-</td><td>Set large size</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Validation Methods -->
                    <div class="so-tab-pane so-fade" id="color-validation-methods">
                        <p class="so-text-muted so-mb-2">From <code>HasValidation</code> trait:</p>
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
                                    <tr><td><code>rules()</code></td><td><code>string|array $rules</code></td><td>Set validation rules</td></tr>
                                    <tr><td><code>addRule()</code></td><td><code>string $rule, mixed $params = true</code></td><td>Add a validation rule</td></tr>
                                    <tr><td><code>removeRule()</code></td><td><code>string $rule</code></td><td>Remove a rule</td></tr>
                                    <tr><td><code>hasRule()</code></td><td><code>string $rule</code></td><td>Check if rule exists</td></tr>
                                    <tr><td><code>getRules()</code></td><td>-</td><td>Get all rules</td></tr>
                                    <tr><td><code>messages()</code></td><td><code>array $messages</code></td><td>Set custom messages</td></tr>
                                    <tr><td><code>required()</code></td><td><code>?string $message = null</code></td><td>Add required rule</td></tr>
                                    <tr><td><code>exportValidation()</code></td><td>-</td><td>Export for JavaScript</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Event Methods -->
                    <div class="so-tab-pane so-fade" id="color-event-methods">
                        <p class="so-text-muted so-mb-2">From <code>HasEvents</code> trait:</p>
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
                                    <tr><td><code>on()</code></td><td><code>string $event, string $handler</code></td><td>Set event handler</td></tr>
                                    <tr><td><code>onMany()</code></td><td><code>array $events</code></td><td>Set multiple handlers</td></tr>
                                    <tr><td><code>off()</code></td><td><code>string $event</code></td><td>Remove handler</td></tr>
                                    <tr><td><code>onChange()</code></td><td><code>string $handler</code></td><td>Set change handler</td></tr>
                                    <tr><td><code>onInput()</code></td><td><code>string $handler</code></td><td>Set input handler</td></tr>
                                    <tr><td><code>onFocus()</code></td><td><code>string $handler</code></td><td>Set focus handler</td></tr>
                                    <tr><td><code>onBlur()</code></td><td><code>string $handler</code></td><td>Set blur handler</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Native DOM Events</h6>
                        <p class="so-text-muted so-mb-2">Color inputs use standard DOM events:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>When Fired</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td><code>input</code></td><td>Continuously while selecting color</td></tr>
                                    <tr><td><code>change</code></td><td>When picker is closed</td></tr>
                                    <tr><td><code>focus</code></td><td>When input receives focus</td></tr>
                                    <tr><td><code>blur</code></td><td>When input loses focus</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Base Element Methods -->
                    <div class="so-tab-pane so-fade" id="color-base-methods">
                        <p class="so-text-muted so-mb-2">Inherited from <code>Element</code> base class:</p>
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
                                    <tr><td><code>id()</code></td><td><code>string $id</code></td><td>Set element ID</td></tr>
                                    <tr><td><code>getId()</code></td><td>-</td><td>Get element ID</td></tr>
                                    <tr><td><code>class()</code></td><td><code>string $class</code></td><td>Add CSS class(es)</td></tr>
                                    <tr><td><code>addClass()</code></td><td><code>string $class</code></td><td>Add a CSS class</td></tr>
                                    <tr><td><code>removeClass()</code></td><td><code>string $class</code></td><td>Remove a CSS class</td></tr>
                                    <tr><td><code>attr()</code></td><td><code>string $name, mixed $value</code></td><td>Set an attribute</td></tr>
                                    <tr><td><code>data()</code></td><td><code>string $key, mixed $value</code></td><td>Set data attribute</td></tr>
                                    <tr><td><code>when()</code></td><td><code>bool $condition, callable $callback</code></td><td>Conditional chaining</td></tr>
                                    <tr><td><code>render()</code></td><td>-</td><td>Render element HTML</td></tr>
                                    <tr><td><code>renderGroup()</code></td><td>-</td><td>Render with wrapper</td></tr>
                                    <tr><td><code>toArray()</code></td><td>-</td><td>Export configuration</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
