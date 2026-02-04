<?php
/**
 * SixOrbit UI Engine - Radio Element Demo
 */

$pageTitle = 'Radio - UI Engine';
$pageDescription = 'Radio button for single selection from options';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Radio</h1>
            <p class="so-page-subtitle">Radio button element for selecting a single option from a group of choices.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Radio Group -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Radio Group</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-form-label so-mb-2">Select your gender</label>
                <div class="so-radio-group so-radio-group-vertical">
                    <label class="so-radio">
                        <input type="radio" name="gender" value="male">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Male</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="gender" value="female">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Female</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="gender" value="other">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Other</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-radio', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$radio = UiEngine::radio('gender')
    ->label('Select your gender')
    ->options([
        ['value' => 'male', 'label' => 'Male'],
        ['value' => 'female', 'label' => 'Female'],
        ['value' => 'other', 'label' => 'Other'],
    ]);

echo \$radio->render();

// Or using option() method to add individually
\$radio = UiEngine::radio('gender')
    ->label('Select your gender')
    ->option('male', 'Male')
    ->option('female', 'Female')
    ->option('other', 'Other');

echo \$radio->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const radio = UiEngine.radio('gender')
    .label('Select your gender')
    .options([
        { value: 'male', label: 'Male' },
        { value: 'female', label: 'Female' },
        { value: 'other', label: 'Other' }
    ]);

document.getElementById('container').innerHTML = radio.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label so-mb-2">Select your gender</label>
    <div class="so-radio-group so-radio-group-vertical">
        <label class="so-radio">
            <input type="radio" name="gender" value="male">
            <span class="so-radio-circle"></span>
            <span class="so-radio-label">Male</span>
        </label>
        <label class="so-radio">
            <input type="radio" name="gender" value="female">
            <span class="so-radio-circle"></span>
            <span class="so-radio-label">Female</span>
        </label>
        <label class="so-radio">
            <input type="radio" name="gender" value="other">
            <span class="so-radio-circle"></span>
            <span class="so-radio-label">Other</span>
        </label>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Inline Radio -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Inline Radio Buttons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-form-label so-mb-2">Choose a plan</label>
                <div class="so-radio-group so-radio-group-inline">
                    <label class="so-radio">
                        <input type="radio" name="plan" value="basic">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Basic</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="plan" value="pro">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Pro</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="plan" value="enterprise">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Enterprise</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('radio-inline', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$radio = UiEngine::radio('plan')
    ->label('Choose a plan')
    ->inline()  // Display horizontally
    ->options([
        ['value' => 'basic', 'label' => 'Basic'],
        ['value' => 'pro', 'label' => 'Pro'],
        ['value' => 'enterprise', 'label' => 'Enterprise'],
    ]);

echo \$radio->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const radio = UiEngine.radio('plan')
    .label('Choose a plan')
    .inline()
    .options([
        { value: 'basic', label: 'Basic' },
        { value: 'pro', label: 'Pro' },
        { value: 'enterprise', label: 'Enterprise' }
    ]);

document.getElementById('container').innerHTML = radio.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-radio-group so-radio-group-inline">
    <label class="so-radio">
        <input type="radio" name="plan" value="basic">
        <span class="so-radio-circle"></span>
        <span class="so-radio-label">Basic</span>
    </label>
    <label class="so-radio">
        <input type="radio" name="plan" value="pro">
        <span class="so-radio-circle"></span>
        <span class="so-radio-label">Pro</span>
    </label>
    <label class="so-radio">
        <input type="radio" name="plan" value="enterprise">
        <span class="so-radio-circle"></span>
        <span class="so-radio-label">Enterprise</span>
    </label>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- States (Checked, Disabled) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">States</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-radio-group so-radio-group-vertical">
                    <label class="so-radio">
                        <input type="radio" name="state_demo" value="checked" checked>
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Checked radio</span>
                    </label>
                    <label class="so-radio so-disabled">
                        <input type="radio" name="state_demo" value="disabled" disabled>
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Disabled radio</span>
                    </label>
                    <label class="so-radio so-disabled">
                        <input type="radio" name="disabled_checked" value="both" checked disabled>
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Checked and disabled</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('radio-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Pre-selected value
\$radio = UiEngine::radio('notification')
    ->options([
        ['value' => 'email', 'label' => 'Email'],
        ['value' => 'sms', 'label' => 'SMS'],
    ])
    ->value('email');  // Pre-select 'email'

// Disable single option
\$radio = UiEngine::radio('tier')
    ->options([
        ['value' => 'free', 'label' => 'Free'],
        ['value' => 'premium', 'label' => 'Premium', 'disabled' => true],
    ]);

// Disable entire group
\$radio = UiEngine::radio('locked')
    ->disabled()
    ->options([...]);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Pre-selected value
const radio = UiEngine.radio('notification')
    .options([
        { value: 'email', label: 'Email' },
        { value: 'sms', label: 'SMS' }
    ])
    .value('email');

// With disabled option
const tierRadio = UiEngine.radio('tier')
    .options([
        { value: 'free', label: 'Free' },
        { value: 'premium', label: 'Premium', disabled: true }
    ]);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Checked -->
<label class="so-radio">
    <input type="radio" name="demo" value="checked" checked>
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Checked radio</span>
</label>

<!-- Disabled -->
<label class="so-radio so-disabled">
    <input type="radio" name="demo" value="disabled" disabled>
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Disabled radio</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Value (Pre-selected) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Default Value</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-form-label so-mb-2">Notification preference</label>
                <div class="so-radio-group so-radio-group-vertical">
                    <label class="so-radio">
                        <input type="radio" name="notification" value="email" checked>
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Email</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="notification" value="sms">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">SMS</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="notification" value="push">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Push notification</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('radio-default', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$radio = UiEngine::radio('notification')
    ->label('Notification preference')
    ->options([
        ['value' => 'email', 'label' => 'Email'],
        ['value' => 'sms', 'label' => 'SMS'],
        ['value' => 'push', 'label' => 'Push notification'],
    ])
    ->value('email');  // Pre-select 'email'

echo \$radio->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const radio = UiEngine.radio('notification')
    .label('Notification preference')
    .options([
        { value: 'email', label: 'Email' },
        { value: 'sms', label: 'SMS' },
        { value: 'push', label: 'Push notification' }
    ])
    .value('email');

document.getElementById('container').innerHTML = radio.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-radio">
    <input type="radio" name="notification" value="email" checked>
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Email</span>
</label>
<!-- Other options without checked attribute -->'
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
                <label class="so-form-label so-mb-2">Contact method</label>
                <div class="so-radio-group so-radio-group-vertical">
                    <label class="so-radio">
                        <input type="radio" name="contact" value="phone">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Phone call</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="contact" value="email">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Email</span>
                    </label>
                </div>
                <div class="so-form-text">We'll only contact you during business hours.</div>

                <!-- Code Tabs -->
                <?= so_code_tabs('radio-help', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$radio = UiEngine::radio('contact')
    ->label('Contact method')
    ->options([
        ['value' => 'phone', 'label' => 'Phone call'],
        ['value' => 'email', 'label' => 'Email'],
    ])
    ->help('We\\'ll only contact you during business hours.');

echo \$radio->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const radio = UiEngine.radio('contact')
    .label('Contact method')
    .options([
        { value: 'phone', label: 'Phone call' },
        { value: 'email', label: 'Email' }
    ])
    .help('We\\'ll only contact you during business hours.');

document.getElementById('container').innerHTML = radio.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-radio-group so-radio-group-vertical">
    <!-- Radio options -->
</div>
<div class="so-form-text">We\'ll only contact you during business hours.</div>'
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
                <!-- Live Demo -->
                <label class="so-form-label so-mb-2">Select a plan <span class="so-text-danger">*</span></label>
                <div class="so-radio-group so-radio-group-vertical">
                    <label class="so-radio so-is-invalid">
                        <input type="radio" name="error_plan" value="basic" class="so-is-invalid">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Basic</span>
                    </label>
                    <label class="so-radio so-is-invalid">
                        <input type="radio" name="error_plan" value="pro" class="so-is-invalid">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Pro</span>
                    </label>
                </div>
                <div class="so-invalid-feedback so-d-block">Please select a plan to continue.</div>

                <!-- Code Tabs -->
                <?= so_code_tabs('radio-error', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$radio = UiEngine::radio('plan')
    ->label('Select a plan')
    ->required()
    ->options([
        ['value' => 'basic', 'label' => 'Basic'],
        ['value' => 'pro', 'label' => 'Pro'],
    ])
    ->error('Please select a plan to continue.');

echo \$radio->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const radio = UiEngine.radio('plan')
    .label('Select a plan')
    .required()
    .options([
        { value: 'basic', label: 'Basic' },
        { value: 'pro', label: 'Pro' }
    ])
    .error('Please select a plan to continue.');

document.getElementById('container').innerHTML = radio.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-radio so-is-invalid">
    <input type="radio" name="plan" value="basic" class="so-is-invalid">
    <span class="so-radio-circle"></span>
    <span class="so-radio-label">Basic</span>
</label>
<div class="so-invalid-feedback so-d-block">Please select a plan to continue.</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Button Style -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Style (Toggle Buttons)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-form-label so-mb-2">Select size</label>
                <div class="so-btn-group so-mb-4" role="group">
                    <input type="radio" class="so-btn-check" name="size" id="size_0" value="sm" autocomplete="off">
                    <label class="so-btn so-btn-outline-primary" for="size_0">Small</label>
                    <input type="radio" class="so-btn-check" name="size" id="size_1" value="md" autocomplete="off" checked>
                    <label class="so-btn so-btn-outline-primary" for="size_1">Medium</label>
                    <input type="radio" class="so-btn-check" name="size" id="size_2" value="lg" autocomplete="off">
                    <label class="so-btn so-btn-outline-primary" for="size_2">Large</label>
                </div>

                <label class="so-form-label so-mb-2">Select priority (danger variant)</label>
                <div class="so-btn-group" role="group">
                    <input type="radio" class="so-btn-check" name="priority" id="priority_0" value="low" autocomplete="off">
                    <label class="so-btn so-btn-outline-danger" for="priority_0">Low</label>
                    <input type="radio" class="so-btn-check" name="priority" id="priority_1" value="medium" autocomplete="off">
                    <label class="so-btn so-btn-outline-danger" for="priority_1">Medium</label>
                    <input type="radio" class="so-btn-check" name="priority" id="priority_2" value="high" autocomplete="off" checked>
                    <label class="so-btn so-btn-outline-danger" for="priority_2">High</label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('radio-button', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Button style with default variant (outline-primary)
\$radio = UiEngine::radio('size')
    ->label('Select size')
    ->buttonStyle()
    ->options([
        ['value' => 'sm', 'label' => 'Small'],
        ['value' => 'md', 'label' => 'Medium'],
        ['value' => 'lg', 'label' => 'Large'],
    ])
    ->value('md');

echo \$radio->render();

// Button style with custom variant
\$radio = UiEngine::radio('priority')
    ->label('Select priority')
    ->buttonStyle()
    ->buttonVariant('outline-danger')
    ->options([
        ['value' => 'low', 'label' => 'Low'],
        ['value' => 'medium', 'label' => 'Medium'],
        ['value' => 'high', 'label' => 'High'],
    ])
    ->value('high');

echo \$radio->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Button style
const radio = UiEngine.radio('size')
    .label('Select size')
    .buttonStyle()
    .options([
        { value: 'sm', label: 'Small' },
        { value: 'md', label: 'Medium' },
        { value: 'lg', label: 'Large' }
    ])
    .value('md');

// With custom variant
const priorityRadio = UiEngine.radio('priority')
    .label('Select priority')
    .buttonStyle()
    .buttonVariant('outline-danger')
    .options([
        { value: 'low', label: 'Low' },
        { value: 'medium', label: 'Medium' },
        { value: 'high', label: 'High' }
    ])
    .value('high');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-btn-group" role="group">
    <input type="radio" class="so-btn-check" name="size" id="size_0"
           value="sm" autocomplete="off">
    <label class="so-btn so-btn-outline-primary" for="size_0">Small</label>

    <input type="radio" class="so-btn-check" name="size" id="size_1"
           value="md" autocomplete="off" checked>
    <label class="so-btn so-btn-outline-primary" for="size_1">Medium</label>

    <input type="radio" class="so-btn-check" name="size" id="size_2"
           value="lg" autocomplete="off">
    <label class="so-btn so-btn-outline-primary" for="size_2">Large</label>
</div>'
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
                <p class="so-text-muted so-mb-3">Radios use native DOM events and can be manipulated via standard JavaScript.</p>

                <!-- Live Demo -->
                <div class="so-mb-3">
                    <label class="so-form-label so-mb-2">Interactive demo</label>
                    <div class="so-radio-group so-radio-group-inline" id="interactive-radio-group">
                        <label class="so-radio">
                            <input type="radio" name="interactive" value="option1">
                            <span class="so-radio-circle"></span>
                            <span class="so-radio-label">Option 1</span>
                        </label>
                        <label class="so-radio">
                            <input type="radio" name="interactive" value="option2">
                            <span class="so-radio-circle"></span>
                            <span class="so-radio-label">Option 2</span>
                        </label>
                        <label class="so-radio">
                            <input type="radio" name="interactive" value="option3">
                            <span class="so-radio-circle"></span>
                            <span class="so-radio-label">Option 3</span>
                        </label>
                    </div>
                </div>
                <div class="so-d-flex so-gap-2 so-mb-3">
                    <button class="so-btn so-btn-primary so-btn-sm" onclick="setRadioValue('option2')">Select Option 2</button>
                    <button class="so-btn so-btn-secondary so-btn-sm" onclick="getRadioValue()">Get Value</button>
                    <button class="so-btn so-btn-outline-primary so-btn-sm" onclick="clearRadio()">Clear Selection</button>
                </div>
                <div id="radio-event-output" class="so-alert so-alert-info">Interact with the radio buttons to see events.</div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const radioGroup = document.getElementById('interactive-radio-group');
                        const output = document.getElementById('radio-event-output');

                        radioGroup.addEventListener('change', function(e) {
                            if (e.target.type === 'radio') {
                                output.textContent = `change event: selected = ${e.target.value}`;
                            }
                        });
                    });

                    function setRadioValue(value) {
                        const radio = document.querySelector(`input[name="interactive"][value="${value}"]`);
                        if (radio) {
                            radio.checked = true;
                            radio.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }

                    function getRadioValue() {
                        const selected = document.querySelector('input[name="interactive"]:checked');
                        document.getElementById('radio-event-output').textContent =
                            selected ? `Current value: ${selected.value}` : 'No selection';
                    }

                    function clearRadio() {
                        document.querySelectorAll('input[name="interactive"]').forEach(r => r.checked = false);
                        document.getElementById('radio-event-output').textContent = 'Selection cleared';
                    }
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('radio-js-interactivity', [
                    [
                        'label' => 'Getting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Get selected value from radio group
const selected = document.querySelector('input[name=\"myRadio\"]:checked');
const value = selected ? selected.value : null;
console.log('Selected:', value);

// Check if any option is selected
const hasSelection = !!document.querySelector('input[name=\"myRadio\"]:checked');"
                    ],
                    [
                        'label' => 'Setting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Select a specific option by value
const radio = document.querySelector('input[name=\"myRadio\"][value=\"option2\"]');
if (radio) {
    radio.checked = true;
    radio.dispatchEvent(new Event('change', { bubbles: true }));
}

// Clear selection
document.querySelectorAll('input[name=\"myRadio\"]').forEach(r => {
    r.checked = false;
});"
                    ],
                    [
                        'label' => 'Event Handling',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Event delegation (recommended)
const radioGroup = document.getElementById('myRadioGroup');
radioGroup.addEventListener('change', (e) => {
    if (e.target.type === 'radio') {
        console.log('Selected:', e.target.value);
    }
});

// Individual listeners
document.querySelectorAll('input[name=\"myRadio\"]').forEach(radio => {
    radio.addEventListener('change', (e) => {
        console.log('Changed to:', e.target.value);
    });
});"
                    ],
                    [
                        'label' => 'DOM Manipulation',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Disable/enable
const radio = document.querySelector('input[name=\"myRadio\"]');
const label = radio.closest('.so-radio');

radio.disabled = true;
label.classList.add('so-disabled');

// Add error state
label.classList.add('so-is-invalid');

// Remove error state
label.classList.remove('so-is-invalid');"
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
                <p class="so-text-muted so-mb-3">Radio buttons support required validation through HTML5 and custom validation.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('radio-validation', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Required radio group
\$radio = UiEngine::radio('terms')
    ->label('Accept terms')
    ->required()
    ->options([
        ['value' => 'yes', 'label' => 'I accept'],
        ['value' => 'no', 'label' => 'I decline'],
    ]);

// With validation rules
\$radio = UiEngine::radio('payment')
    ->required()
    ->rules(['required', 'in:card,bank,cash'])
    ->messages([
        'required' => 'Please select a payment method',
    ]);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "function validateRadioGroup(name) {
    const selected = document.querySelector(\`input[name=\"\${name}\"]:checked\`);
    const radios = document.querySelectorAll(\`input[name=\"\${name}\"]\`);
    const labels = document.querySelectorAll(\`.so-radio:has(input[name=\"\${name}\"])\`);

    if (!selected) {
        labels.forEach(l => l.classList.add('so-is-invalid'));
        return false;
    }

    labels.forEach(l => l.classList.remove('so-is-invalid'));
    return true;
}"
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
                                <td><code>so-radio</code></td>
                                <td>Main wrapper class for single radio. Applied to the <code>&lt;label&gt;</code> element.</td>
                            </tr>
                            <tr>
                                <td><code>so-radio-circle</code></td>
                                <td>The visual radio circle indicator.</td>
                            </tr>
                            <tr>
                                <td><code>so-radio-label</code></td>
                                <td>The text label for the radio.</td>
                            </tr>
                            <tr>
                                <td><code>so-radio-group</code></td>
                                <td>Wrapper for multiple radios in a group.</td>
                            </tr>
                            <tr>
                                <td><code>so-radio-group-vertical</code></td>
                                <td>Display radio group items vertically (stacked). Default layout.</td>
                            </tr>
                            <tr>
                                <td><code>so-radio-group-inline</code></td>
                                <td>Display radio group items horizontally (inline).</td>
                            </tr>
                            <tr>
                                <td><code>so-disabled</code></td>
                                <td>Applied to radio label when disabled.</td>
                            </tr>
                            <tr>
                                <td><code>so-is-invalid</code></td>
                                <td>Error state class for validation errors.</td>
                            </tr>
                            <tr>
                                <td><code>so-btn-group</code></td>
                                <td>Container for button-style radios.</td>
                            </tr>
                            <tr>
                                <td><code>so-btn-check</code></td>
                                <td>Hidden radio for button style.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-group</code></td>
                                <td>Wrapper for form field with label, help text, error.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-label</code></td>
                                <td>Group label styling.</td>
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
                    <button class="so-tab so-active" role="tab" data-so-target="#radio-methods">Radio Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#form-methods">Form Element</button>
                    <button class="so-tab" role="tab" data-so-target="#base-methods">Base Element</button>
                    <button class="so-tab" role="tab" data-so-target="#event-methods">Events</button>
                </div>

                <!-- Tab Panes -->
                <div class="so-tab-content">
                    <!-- Radio Methods -->
                    <div class="so-tab-pane so-fade so-show so-active" id="radio-methods">
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
                                        <td><code>options()</code></td>
                                        <td><code>array $options</code></td>
                                        <td>Set radio options array</td>
                                    </tr>
                                    <tr>
                                        <td><code>option()</code></td>
                                        <td><code>$value, $label</code></td>
                                        <td>Add a single option</td>
                                    </tr>
                                    <tr>
                                        <td><code>inline()</code></td>
                                        <td><code>bool $val = true</code></td>
                                        <td>Display options horizontally</td>
                                    </tr>
                                    <tr>
                                        <td><code>buttonStyle()</code></td>
                                        <td><code>bool $val = true</code></td>
                                        <td>Render as toggle buttons</td>
                                    </tr>
                                    <tr>
                                        <td><code>buttonVariant()</code></td>
                                        <td><code>string $variant</code></td>
                                        <td>Set button variant (e.g., 'outline-primary')</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Form Element Methods -->
                    <div class="so-tab-pane so-fade" id="form-methods">
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
                                        <td><code>name()</code></td>
                                        <td><code>string $name</code></td>
                                        <td>Set the field name</td>
                                    </tr>
                                    <tr>
                                        <td><code>label()</code></td>
                                        <td><code>string $label</code></td>
                                        <td>Set the group label</td>
                                    </tr>
                                    <tr>
                                        <td><code>value()</code></td>
                                        <td><code>mixed $value</code></td>
                                        <td>Set selected value</td>
                                    </tr>
                                    <tr>
                                        <td><code>help()</code></td>
                                        <td><code>string $text</code></td>
                                        <td>Set help text</td>
                                    </tr>
                                    <tr>
                                        <td><code>required()</code></td>
                                        <td><code>bool $val = true</code></td>
                                        <td>Mark as required</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code></td>
                                        <td><code>bool $val = true</code></td>
                                        <td>Disable all options</td>
                                    </tr>
                                    <tr>
                                        <td><code>error()</code></td>
                                        <td><code>string $msg</code></td>
                                        <td>Set error message</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Base Element Methods -->
                    <div class="so-tab-pane so-fade" id="base-methods">
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
                                        <td><code>id()</code></td>
                                        <td><code>string $id</code></td>
                                        <td>Set the base element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>addClass()</code></td>
                                        <td><code>string $class</code></td>
                                        <td>Add CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr()</code></td>
                                        <td><code>$name, $value</code></td>
                                        <td>Set HTML attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>data()</code></td>
                                        <td><code>$key, $value</code></td>
                                        <td>Set data-* attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>-</td>
                                        <td>Render HTML string</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray()</code></td>
                                        <td>-</td>
                                        <td>Export configuration</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Events Tab -->
                    <div class="so-tab-pane so-fade" id="event-methods">
                        <p class="so-text-muted so-mb-3">Radio inputs use standard DOM events (no <code>so:</code> prefix).</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>When</th>
                                        <th>Example</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>change</code></td>
                                        <td>Selection changes</td>
                                        <td><code>radio.addEventListener('change', handler)</code></td>
                                    </tr>
                                    <tr>
                                        <td><code>click</code></td>
                                        <td>Radio is clicked</td>
                                        <td><code>radio.addEventListener('click', handler)</code></td>
                                    </tr>
                                    <tr>
                                        <td><code>focus</code></td>
                                        <td>Radio receives focus</td>
                                        <td><code>radio.addEventListener('focus', handler)</code></td>
                                    </tr>
                                    <tr>
                                        <td><code>blur</code></td>
                                        <td>Radio loses focus</td>
                                        <td><code>radio.addEventListener('blur', handler)</code></td>
                                    </tr>
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
