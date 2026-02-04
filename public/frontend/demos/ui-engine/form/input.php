<?php
/**
 * SixOrbit UI Engine - Input Element Demo
 */

$pageTitle = 'Input - UI Engine';
$pageDescription = 'Text input with various types and configurations';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Input</h1>
            <p class="so-page-subtitle">Text input element with various types, validation, and styling options. Supports all HTML5 input types.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Input -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Input</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label" for="demo-username">Username</label>
                    <input type="text" class="so-form-control" id="demo-username" name="username" placeholder="Enter your username">
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-input', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$input = UiEngine::input('username')
    ->label('Username')
    ->placeholder('Enter your username');

echo \$input->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const input = UiEngine.input('username')
    .setLabel('Username')
    .setPlaceholder('Enter your username');

document.getElementById('container').appendChild(input.renderGroup());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label" for="username">Username</label>
    <input type="text" class="so-form-control" id="username" name="username" placeholder="Enter your username">
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Input Types -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input Types</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">The Input element supports all HTML5 input types with convenient shortcut methods.</p>

                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Email</label>
                            <input type="email" class="so-form-control" placeholder="you@example.com">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Password</label>
                            <input type="password" class="so-form-control" placeholder="Enter password">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Number</label>
                            <input type="number" class="so-form-control" placeholder="0" min="0" max="100">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Telephone</label>
                            <input type="tel" class="so-form-control" placeholder="+1 (555) 000-0000">
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Date</label>
                            <input type="date" class="so-form-control">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Time</label>
                            <input type="time" class="so-form-control">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">URL</label>
                            <input type="url" class="so-form-control" placeholder="https://example.com">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Search</label>
                            <input type="search" class="so-form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-types', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Using convenience factory methods
UiEngine::email('email')->label('Email')->placeholder('you@example.com');
UiEngine::password('password')->label('Password');
UiEngine::number('quantity')->label('Quantity')->min(0)->max(100);
UiEngine::tel('phone')->label('Phone');
UiEngine::date('birthdate')->label('Date');
UiEngine::time('time')->label('Time');
UiEngine::url('website')->label('URL');
UiEngine::search('search')->label('Search');

// Using inputType() method
UiEngine::input('field')
    ->inputType('datetime-local')
    ->label('DateTime');

// All supported types:
// text, email, password, number, tel, url, search,
// date, time, datetime-local, month, week, color, range"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Using convenience factory methods
UiEngine.email('email').setLabel('Email').setPlaceholder('you@example.com');
UiEngine.password('password').setLabel('Password');
UiEngine.number('quantity').setLabel('Quantity').min(0).max(100);
UiEngine.tel('phone').setLabel('Phone');
UiEngine.date('birthdate').setLabel('Date');
UiEngine.time('time').setLabel('Time');
UiEngine.url('website').setLabel('URL');
UiEngine.search('search').setLabel('Search');

// Using inputType() method
UiEngine.input('field')
    .inputType('datetime-local')
    .setLabel('DateTime');

// Shortcut type methods on input instance:
UiEngine.input('field').email();     // Changes to email type
UiEngine.input('field').password();  // Changes to password type
UiEngine.input('field').number();    // Changes to number type"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<input type="email" class="so-form-control" name="email" placeholder="you@example.com">
<input type="password" class="so-form-control" name="password">
<input type="number" class="so-form-control" name="quantity" min="0" max="100">
<input type="tel" class="so-form-control" name="phone">
<input type="date" class="so-form-control" name="birthdate">
<input type="time" class="so-form-control" name="time">
<input type="url" class="so-form-control" name="website">
<input type="search" class="so-form-control" name="search">'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Input Constraints -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input Constraints</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Add HTML5 validation constraints like min/max values, length limits, and patterns.</p>

                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Age (0-120)</label>
                            <input type="number" class="so-form-control" min="0" max="120" step="1" placeholder="Enter age">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Price (step 0.01)</label>
                            <input type="number" class="so-form-control" min="0" step="0.01" placeholder="0.00">
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Username (3-20 chars)</label>
                            <input type="text" class="so-form-control" minlength="3" maxlength="20" placeholder="3-20 characters">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Code (pattern: ABC-123)</label>
                            <input type="text" class="so-form-control" pattern="[A-Z]{3}-[0-9]{3}" placeholder="ABC-123">
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-constraints', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Number constraints
UiEngine::number('age')
    ->label('Age')
    ->min(0)
    ->max(120)
    ->step(1);

// Price with decimal step
UiEngine::number('price')
    ->label('Price')
    ->min(0)
    ->step(0.01);

// Character length constraints
UiEngine::input('username')
    ->label('Username')
    ->minlength(3)
    ->maxlength(20);

// Pattern validation (regex)
UiEngine::input('code')
    ->label('Code')
    ->pattern('[A-Z]{3}-[0-9]{3}')
    ->placeholder('ABC-123');

// Date constraints
UiEngine::date('appointment')
    ->label('Appointment Date')
    ->min(date('Y-m-d'))
    ->max(date('Y-m-d', strtotime('+30 days')));"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Number constraints
UiEngine.number('age')
    .setLabel('Age')
    .min(0)
    .max(120)
    .step(1);

// Price with decimal step
UiEngine.number('price')
    .setLabel('Price')
    .min(0)
    .step(0.01);

// Character length constraints
UiEngine.input('username')
    .setLabel('Username')
    .minlength(3)
    .maxlength(20);

// Pattern validation (regex)
UiEngine.input('code')
    .setLabel('Code')
    .pattern('[A-Z]{3}-[0-9]{3}')
    .setPlaceholder('ABC-123');

// Date constraints
const today = new Date().toISOString().split('T')[0];
const maxDate = new Date(Date.now() + 30*24*60*60*1000).toISOString().split('T')[0];
UiEngine.date('appointment')
    .setLabel('Appointment Date')
    .min(today)
    .max(maxDate);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Number with min/max/step -->
<input type="number" class="so-form-control" name="age" min="0" max="120" step="1">

<!-- Character length limits -->
<input type="text" class="so-form-control" name="username" minlength="3" maxlength="20">

<!-- Pattern validation -->
<input type="text" class="so-form-control" name="code" pattern="[A-Z]{3}-[0-9]{3}">'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Input Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input Sizes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Small</label>
                            <input type="text" class="so-form-control so-form-control-sm" placeholder="Small input">
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Default</label>
                            <input type="text" class="so-form-control" placeholder="Default input">
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Large</label>
                            <input type="text" class="so-form-control so-form-control-lg" placeholder="Large input">
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small input
UiEngine::input('small')
    ->label('Small')
    ->size('sm')
    ->placeholder('Small input');

// Or use shortcut
UiEngine::input('small')->small();

// Default (no size needed)
UiEngine::input('default')
    ->label('Default')
    ->placeholder('Default input');

// Large input
UiEngine::input('large')
    ->label('Large')
    ->size('lg')
    ->placeholder('Large input');

// Or use shortcut
UiEngine::input('large')->large();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small input
UiEngine.input('small')
    .setLabel('Small')
    .size('sm')
    .setPlaceholder('Small input');

// Default
UiEngine.input('default')
    .setLabel('Default')
    .setPlaceholder('Default input');

// Large input
UiEngine.input('large')
    .setLabel('Large')
    .size('lg')
    .setPlaceholder('Large input');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small -->
<input type="text" class="so-form-control so-form-control-sm" placeholder="Small input">

<!-- Default -->
<input type="text" class="so-form-control" placeholder="Default input">

<!-- Large -->
<input type="text" class="so-form-control so-form-control-lg" placeholder="Large input">'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Input with Prefix/Suffix -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input with Prefix/Suffix</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Add text or icon addons before or after the input using input groups.</p>

                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Price</label>
                            <div class="so-input-group">
                                <span class="so-input-group-text">$</span>
                                <input type="number" class="so-form-control" placeholder="0.00" step="0.01">
                            </div>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Website</label>
                            <div class="so-input-group">
                                <span class="so-input-group-text">https://</span>
                                <input type="text" class="so-form-control" placeholder="example.com">
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Email</label>
                            <div class="so-input-group">
                                <input type="text" class="so-form-control" placeholder="username">
                                <span class="so-input-group-text">@company.com</span>
                            </div>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Both</label>
                            <div class="so-input-group">
                                <span class="so-input-group-text">$</span>
                                <input type="number" class="so-form-control" placeholder="0.00">
                                <span class="so-input-group-text">.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-addons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Input with prefix
UiEngine::number('price')
    ->label('Price')
    ->prefix('\$')
    ->placeholder('0.00')
    ->step(0.01);

// Input with suffix
UiEngine::input('email')
    ->label('Email')
    ->suffix('@company.com')
    ->placeholder('username');

// Input with both prefix and suffix
UiEngine::number('amount')
    ->label('Amount')
    ->prefix('\$')
    ->suffix('.00')
    ->placeholder('0');

// Website with prefix
UiEngine::input('website')
    ->label('Website')
    ->prefix('https://')
    ->placeholder('example.com');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Input with prefix
UiEngine.number('price')
    .setLabel('Price')
    .prefix('\$')
    .setPlaceholder('0.00')
    .step(0.01);

// Input with suffix
UiEngine.input('email')
    .setLabel('Email')
    .suffix('@company.com')
    .setPlaceholder('username');

// Input with both
UiEngine.number('amount')
    .setLabel('Amount')
    .prefix('\$')
    .suffix('.00')
    .setPlaceholder('0');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Input with prefix -->
<div class="so-input-group">
    <span class="so-input-group-text">$</span>
    <input type="number" class="so-form-control" name="price" placeholder="0.00" step="0.01">
</div>

<!-- Input with suffix -->
<div class="so-input-group">
    <input type="text" class="so-form-control" name="email" placeholder="username">
    <span class="so-input-group-text">@company.com</span>
</div>

<!-- Both prefix and suffix -->
<div class="so-input-group">
    <span class="so-input-group-text">$</span>
    <input type="number" class="so-form-control" name="amount" placeholder="0">
    <span class="so-input-group-text">.00</span>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input States</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Normal</label>
                            <input type="text" class="so-form-control" value="Normal input">
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Disabled</label>
                            <input type="text" class="so-form-control" value="Disabled input" disabled>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Readonly</label>
                            <input type="text" class="so-form-control" value="Readonly input" readonly>
                        </div>
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Required <span class="so-text-danger">*</span></label>
                            <input type="text" class="so-form-control" placeholder="Required field" required>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Disabled input
UiEngine::input('disabled_field')
    ->label('Disabled')
    ->value('Disabled input')
    ->disabled();

// Readonly input
UiEngine::input('readonly_field')
    ->label('Readonly')
    ->value('Readonly input')
    ->readonly();

// Required input
UiEngine::input('required_field')
    ->label('Required')
    ->required()
    ->placeholder('Required field');

// Autofocus
UiEngine::input('focused_field')
    ->label('Auto-focused')
    ->attr('autofocus', true);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Disabled input
UiEngine.input('disabled_field')
    .setLabel('Disabled')
    .setValue('Disabled input')
    .setDisabled(true);

// Readonly input
UiEngine.input('readonly_field')
    .setLabel('Readonly')
    .setValue('Readonly input')
    .setReadonly(true);

// Required input
UiEngine.input('required_field')
    .setLabel('Required')
    .setRequired(true)
    .setPlaceholder('Required field');

// Toggle states dynamically
const input = UiEngine.input('dynamic');
input.setDisabled(true);   // Disable
input.setDisabled(false);  // Enable
input.setReadonly(true);   // Make readonly
input.setRequired(true);   // Make required"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Disabled -->
<input type="text" class="so-form-control" value="Disabled input" disabled>

<!-- Readonly -->
<input type="text" class="so-form-control" value="Readonly input" readonly>

<!-- Required -->
<input type="text" class="so-form-control" placeholder="Required field" required>'
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
                <p class="so-text-muted so-mb-3">Input elements support full interactivity through native DOM events and UiEngine methods.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-form-group so-mb-3">
                        <label class="so-form-label">Interactive Input</label>
                        <input type="text" class="so-form-control" id="demo-interactive" placeholder="Type something...">
                    </div>
                    <div class="so-d-flex so-gap-2 so-mb-3">
                        <button class="so-btn so-btn-primary so-btn-sm" onclick="document.getElementById('demo-interactive').value = 'Hello World!'">Set Value</button>
                        <button class="so-btn so-btn-secondary so-btn-sm" onclick="document.getElementById('demo-interactive').value = ''">Clear</button>
                        <button class="so-btn so-btn-outline-primary so-btn-sm" onclick="document.getElementById('demo-interactive').disabled = !document.getElementById('demo-interactive').disabled">Toggle Disabled</button>
                        <button class="so-btn so-btn-outline-secondary so-btn-sm" onclick="document.getElementById('demo-interactive').readOnly = !document.getElementById('demo-interactive').readOnly">Toggle Readonly</button>
                    </div>
                    <div id="input-event-output" class="so-alert so-alert-info">Interact with the input to see events.</div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const input = document.getElementById('demo-interactive');
                    const output = document.getElementById('input-event-output');

                    input.addEventListener('input', function(e) {
                        output.textContent = `input event: value = "${e.target.value}"`;
                    });

                    input.addEventListener('change', function(e) {
                        output.textContent = `change event: final value = "${e.target.value}"`;
                    });

                    input.addEventListener('focus', function() {
                        output.textContent = 'focus event: input focused';
                    });

                    input.addEventListener('blur', function() {
                        output.textContent = 'blur event: input lost focus';
                    });
                });
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-js-interactivity', [
                    [
                        'label' => 'Getting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Get input by name
const input = document.querySelector('input[name=\"username\"]');
const value = input.value;

// Get input by ID
const inputById = document.getElementById('email-input');
const email = inputById.value;

// Using UiEngine instance
const uiInput = UiEngine.input('field').setValue('initial');
document.body.appendChild(uiInput.render());
console.log(uiInput.getValue()); // 'initial'

// Get various input properties
const inputEl = document.querySelector('input[name=\"age\"]');
console.log(inputEl.value);       // Current value
console.log(inputEl.type);        // 'number'
console.log(inputEl.disabled);    // true/false
console.log(inputEl.readOnly);    // true/false
console.log(inputEl.required);    // true/false
console.log(inputEl.validity.valid); // HTML5 validation state"
                    ],
                    [
                        'label' => 'Setting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Set value directly
const input = document.querySelector('input[name=\"username\"]');
input.value = 'newValue';

// Using UiEngine instance (updates DOM automatically if rendered)
const uiInput = UiEngine.input('field');
uiInput.setValue('Hello World');

// Clear input
input.value = '';

// Set placeholder dynamically
input.placeholder = 'New placeholder';

// Set attributes
input.setAttribute('maxlength', '50');
input.setAttribute('pattern', '[A-Za-z]+');

// Update multiple inputs
document.querySelectorAll('.user-input').forEach(input => {
    input.value = '';
});

// Trigger change event after programmatic update
input.dispatchEvent(new Event('change', { bubbles: true }));"
                    ],
                    [
                        'label' => 'Event Handling',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const input = document.querySelector('input[name=\"search\"]');

// Input event (fires on every keystroke)
input.addEventListener('input', function(e) {
    console.log('Current value:', e.target.value);
    // Good for live search, real-time validation
});

// Change event (fires when value changes and input loses focus)
input.addEventListener('change', function(e) {
    console.log('Final value:', e.target.value);
    // Good for form submissions, API calls
});

// Focus event
input.addEventListener('focus', function(e) {
    console.log('Input focused');
    e.target.select(); // Select all text on focus
});

// Blur event
input.addEventListener('blur', function(e) {
    console.log('Input blurred');
    validateInput(e.target); // Validate on blur
});

// Keydown/keyup events
input.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        submitForm();
    }
    if (e.key === 'Escape') {
        e.target.value = '';
    }
});

// Event delegation for dynamic inputs
document.addEventListener('input', function(e) {
    if (e.target.matches('.so-form-control')) {
        console.log('Input changed:', e.target.name, e.target.value);
    }
});"
                    ],
                    [
                        'label' => 'States & Classes',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const input = document.querySelector('input[name=\"email\"]');

// Enable/disable
input.disabled = true;   // Disable
input.disabled = false;  // Enable

// Readonly
input.readOnly = true;
input.readOnly = false;

// Required
input.required = true;
input.required = false;

// Add/remove classes
input.classList.add('so-is-invalid');
input.classList.remove('so-is-invalid');
input.classList.add('so-is-valid');

// Add error state with message
function showError(input, message) {
    input.classList.add('so-is-invalid');
    const wrapper = input.closest('.so-form-group');
    let errorEl = wrapper.querySelector('.so-invalid-feedback');
    if (!errorEl) {
        errorEl = document.createElement('div');
        errorEl.className = 'so-invalid-feedback';
        wrapper.appendChild(errorEl);
    }
    errorEl.textContent = message;
    errorEl.style.display = 'block';
}

// Clear error state
function clearError(input) {
    input.classList.remove('so-is-invalid');
    const wrapper = input.closest('.so-form-group');
    const errorEl = wrapper.querySelector('.so-invalid-feedback');
    if (errorEl) errorEl.style.display = 'none';
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
                <p class="so-text-muted so-mb-3">Input elements support both HTML5 browser validation and custom validation rules that can be exported to JavaScript.</p>

                <!-- Live Demo -->
                <form id="demo-validation-form" novalidate class="so-mb-4">
                    <div class="so-row">
                        <div class="so-col-md-6">
                            <div class="so-form-group so-mb-3">
                                <label class="so-form-label">Email <span class="so-text-danger">*</span></label>
                                <input type="email" class="so-form-control" id="val-email" name="email" required placeholder="you@example.com">
                                <div class="so-invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                        <div class="so-col-md-6">
                            <div class="so-form-group so-mb-3">
                                <label class="so-form-label">Password <span class="so-text-danger">*</span></label>
                                <input type="password" class="so-form-control" id="val-password" name="password" required minlength="8" placeholder="Min 8 characters">
                                <div class="so-invalid-feedback">Password must be at least 8 characters.</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="so-btn so-btn-primary">Validate Form</button>
                </form>

                <script>
                document.getElementById('demo-validation-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    let isValid = true;

                    form.querySelectorAll('.so-form-control').forEach(input => {
                        input.classList.remove('so-is-invalid', 'so-is-valid');
                        if (!input.checkValidity()) {
                            input.classList.add('so-is-invalid');
                            isValid = false;
                        } else {
                            input.classList.add('so-is-valid');
                        }
                    });

                    if (isValid) {
                        alert('Form is valid!');
                    }
                });
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-validation', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Using validation rules (Laravel-style)
\$email = UiEngine::email('email')
    ->label('Email')
    ->required()
    ->rules('required|email|max:255')
    ->messages([
        'required' => 'Email address is required',
        'email' => 'Please enter a valid email address',
        'max' => 'Email cannot exceed 255 characters',
    ]);

// Using individual validation methods
\$password = UiEngine::password('password')
    ->label('Password')
    ->required('Password is required')
    ->min(8, 'Password must be at least 8 characters')
    ->max(100)
    ->pattern('[A-Za-z0-9]+', 'Only letters and numbers allowed');

// Export validation for JavaScript
\$validation = \$email->exportValidation();
/*
Returns:
[
    'rules' => ['required' => true, 'email' => true, 'max' => 255],
    'messages' => ['required' => 'Email address is required', ...]
]
*/

// Render form with validation script
\$form = UiEngine::form('/submit')
    ->add(\$email)
    ->add(\$password);
echo \$form->renderWithValidation();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Set validation rules on UiEngine input
const email = UiEngine.email('email')
    .setLabel('Email')
    .setRequired(true)
    .setRules('required|email|max:255')
    .setMessages({
        required: 'Email address is required',
        email: 'Please enter a valid email address'
    });

// Add individual rules
const password = UiEngine.password('password')
    .setLabel('Password')
    .addRule('required', true)
    .addRule('min', 8)
    .addRule('max', 100);

// Using convenience methods (from FormElement)
const username = UiEngine.input('username')
    .required()
    .min(3)
    .max(20);

// Export validation config
const validation = email.exportValidation();
// { rules: {...}, messages: {...} }

// Check if input has rules
if (email.hasRules()) {
    console.log(email.getRules());
}"
                    ],
                    [
                        'label' => 'Client Validation',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// HTML5 Constraint Validation API
function validateInput(input) {
    // Check validity using browser's built-in validation
    if (input.checkValidity()) {
        input.classList.remove('so-is-invalid');
        input.classList.add('so-is-valid');
        return true;
    } else {
        input.classList.remove('so-is-valid');
        input.classList.add('so-is-invalid');

        // Get specific validation error
        const validity = input.validity;
        let message = '';

        if (validity.valueMissing) {
            message = 'This field is required';
        } else if (validity.typeMismatch) {
            message = 'Please enter a valid ' + input.type;
        } else if (validity.tooShort) {
            message = `Minimum ${input.minLength} characters required`;
        } else if (validity.tooLong) {
            message = `Maximum ${input.maxLength} characters allowed`;
        } else if (validity.rangeUnderflow) {
            message = `Value must be at least ${input.min}`;
        } else if (validity.rangeOverflow) {
            message = `Value must be at most ${input.max}`;
        } else if (validity.patternMismatch) {
            message = input.title || 'Please match the required format';
        }

        showErrorMessage(input, message);
        return false;
    }
}

// Validate on blur
document.querySelectorAll('.so-form-control').forEach(input => {
    input.addEventListener('blur', () => validateInput(input));
});

// Validate entire form
function validateForm(form) {
    let isValid = true;
    form.querySelectorAll('.so-form-control').forEach(input => {
        if (!validateInput(input)) isValid = false;
    });
    return isValid;
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
                <p class="so-text-muted so-mb-3">Display validation errors from server-side or client-side validation.</p>

                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Valid Input</label>
                            <input type="text" class="so-form-control so-is-valid" value="Valid value">
                            <div class="so-valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group so-mb-3">
                            <label class="so-form-label">Invalid Input</label>
                            <input type="text" class="so-form-control so-is-invalid" value="Invalid">
                            <div class="so-invalid-feedback" style="display:block;">This field has an error.</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-errors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Set error message from server validation
\$email = UiEngine::email('email')
    ->label('Email')
    ->value(\$oldInput['email'] ?? '')
    ->error(\$errors['email'] ?? null);  // null clears error

// Check for errors
if (\$email->hasError()) {
    \$errorMessage = \$email->getError();
}

// Set from Laravel validator
\$input = UiEngine::input('username')
    ->label('Username')
    ->error(\$errors->first('username'));

// Clear error
\$input->error(null);

// Render with error styling
echo \$email->renderGroup();
// Outputs input with so-is-invalid class and error message"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Set error using UiEngine
const input = UiEngine.input('email');
input.setError('Please enter a valid email address');

// Clear error
input.clearError();  // or input.setError(null);

// Check for errors
if (input.hasError()) {
    console.log(input.getError());
}

// Set error on DOM element directly
function showInputError(inputEl, message) {
    // Add error class
    inputEl.classList.add('so-is-invalid');
    inputEl.classList.remove('so-is-valid');

    // Find or create error element
    const wrapper = inputEl.closest('.so-form-group');
    let errorEl = wrapper.querySelector('.so-invalid-feedback');

    if (!errorEl) {
        errorEl = document.createElement('div');
        errorEl.className = 'so-invalid-feedback';
        wrapper.appendChild(errorEl);
    }

    errorEl.textContent = message;
    errorEl.style.display = 'block';
}

// Clear error
function clearInputError(inputEl) {
    inputEl.classList.remove('so-is-invalid');
    const wrapper = inputEl.closest('.so-form-group');
    const errorEl = wrapper.querySelector('.so-invalid-feedback');
    if (errorEl) {
        errorEl.style.display = 'none';
    }
}

// Handle server-side errors from AJAX
async function submitForm(form) {
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        });

        if (!response.ok) {
            const data = await response.json();

            // Display errors
            Object.entries(data.errors || {}).forEach(([field, messages]) => {
                const input = form.querySelector(\`[name=\"\${field}\"]\`);
                if (input) {
                    showInputError(input, messages[0]);
                }
            });
        }
    } catch (error) {
        console.error('Submission failed:', error);
    }
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
                <p class="so-text-muted so-mb-3">Export input configuration from PHP to JavaScript for dynamic form generation.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-php-js', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Create input with full configuration
\$input = UiEngine::email('contact_email')
    ->id('contact-email')
    ->label('Contact Email')
    ->placeholder('you@example.com')
    ->value(\$user->email ?? '')
    ->required()
    ->maxlength(255)
    ->rules('required|email|max:255')
    ->messages([
        'required' => 'Email is required',
        'email' => 'Please enter a valid email',
    ])
    ->data('validate', 'true')
    ->data('group', 'contact');

// Export to array
\$config = \$input->toArray();
/*
Returns:
[
    'type' => 'input',
    'inputType' => 'email',
    'name' => 'contact_email',
    'id' => 'contact-email',
    'label' => 'Contact Email',
    'placeholder' => 'you@example.com',
    'value' => 'user@example.com',
    'required' => true,
    'maxlength' => 255,
    'rules' => [...],
    'messages' => [...]
]
*/

// Pass to JavaScript
echo '<script>window.inputConfig = ' . json_encode(\$config) . ';</script>';

// Export validation separately
\$validation = \$input->exportValidation();
echo '<script>window.inputValidation = ' . json_encode(\$validation) . ';</script>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Access PHP configuration
const config = window.inputConfig;

// Recreate input from config
const input = UiEngine.fromConfig(config);
document.getElementById('form').appendChild(input.renderGroup());

// Or build manually from config
const email = UiEngine.input(config.name);
if (config.inputType) email.inputType(config.inputType);
if (config.label) email.setLabel(config.label);
if (config.placeholder) email.setPlaceholder(config.placeholder);
if (config.value) email.setValue(config.value);
if (config.required) email.setRequired(true);
if (config.maxlength) email.maxlength(config.maxlength);
if (config.rules) email.setRules(config.rules);
if (config.messages) email.setMessages(config.messages);

// Apply validation from PHP
const validation = window.inputValidation;
if (validation) {
    email.setRules(validation.rules);
    email.setMessages(validation.messages);
}

// Dynamic form generation from server config
async function loadFormFields(formId) {
    const response = await fetch('/api/form-fields/' + formId);
    const fields = await response.json();

    const form = document.getElementById('dynamic-form');
    fields.forEach(fieldConfig => {
        const element = UiEngine.fromConfig(fieldConfig);
        form.appendChild(element.renderGroup());
    });
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Events -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Events</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Input elements use standard DOM events. Event handlers can be set from PHP or JavaScript.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('input-events', [
                    [
                        'label' => 'PHP Event Handlers',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Set event handlers from PHP
\$input = UiEngine::input('username')
    ->label('Username')
    ->onChange('handleUsernameChange(this)')
    ->onBlur('validateUsername(this)')
    ->onFocus('clearUsernameError(this)')
    ->onInput('liveSearchUsername(this.value)');

// Set multiple events
\$input = UiEngine::input('search')
    ->onMany([
        'input' => 'handleSearch(this)',
        'focus' => 'showSuggestions()',
        'blur' => 'hideSuggestions()',
        'keydown' => 'handleKeyNav(event)',
    ]);

// Use inline events (onclick=) vs data attributes
\$input = UiEngine::input('field')
    ->useInlineEvents(true)  // Renders as onchange=\"...\"
    ->onChange('doSomething()');

// Available event methods (from HasEvents trait):
// ->on('event', 'handler')
// ->onClick('handler')
// ->onChange('handler')
// ->onFocus('handler')
// ->onBlur('handler')
// ->onInput('handler')
// ->onKeyUp('handler')
// ->onKeyDown('handler')"
                    ],
                    [
                        'label' => 'JavaScript Events',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Using UiEngine event methods
const input = UiEngine.input('username')
    .setLabel('Username')
    .onChange(function(e) {
        console.log('Changed:', e.target.value);
    })
    .onBlur(function(e) {
        validateField(e.target);
    })
    .onInput(function(e) {
        liveValidate(e.target);
    });

// Standard DOM event listeners
const inputEl = document.querySelector('input[name=\"search\"]');

inputEl.addEventListener('input', handleInput);
inputEl.addEventListener('change', handleChange);
inputEl.addEventListener('focus', handleFocus);
inputEl.addEventListener('blur', handleBlur);
inputEl.addEventListener('keydown', handleKeydown);
inputEl.addEventListener('keyup', handleKeyup);

// Remove event listener
inputEl.removeEventListener('input', handleInput);

// Event delegation (recommended for dynamic inputs)
document.addEventListener('input', function(e) {
    if (e.target.matches('.so-form-control')) {
        console.log('Input changed:', e.target.name);
    }
});

// Custom events for input tracking
inputEl.addEventListener('input', function(e) {
    this.dispatchEvent(new CustomEvent('so:input:change', {
        bubbles: true,
        detail: { value: e.target.value, name: e.target.name }
    }));
});"
                    ],
                ]) ?>

                <h6 class="so-mt-4">Standard DOM Events</h6>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>input</code></td>
                                <td>Fires on every value change (keystrokes, paste, etc.)</td>
                            </tr>
                            <tr>
                                <td><code>change</code></td>
                                <td>Fires when value changes and element loses focus</td>
                            </tr>
                            <tr>
                                <td><code>focus</code></td>
                                <td>Fires when input receives focus</td>
                            </tr>
                            <tr>
                                <td><code>blur</code></td>
                                <td>Fires when input loses focus</td>
                            </tr>
                            <tr>
                                <td><code>keydown</code></td>
                                <td>Fires when a key is pressed down</td>
                            </tr>
                            <tr>
                                <td><code>keyup</code></td>
                                <td>Fires when a key is released</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                                <td>Base class for input elements. Applied automatically.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-control-sm</code></td>
                                <td>Small input size variant</td>
                            </tr>
                            <tr>
                                <td><code>so-form-control-lg</code></td>
                                <td>Large input size variant</td>
                            </tr>
                            <tr>
                                <td><code>so-is-invalid</code></td>
                                <td>Error state styling (red border)</td>
                            </tr>
                            <tr>
                                <td><code>so-is-valid</code></td>
                                <td>Valid state styling (green border)</td>
                            </tr>
                            <tr>
                                <td><code>so-form-group</code></td>
                                <td>Wrapper for label + input + help/error</td>
                            </tr>
                            <tr>
                                <td><code>so-form-label</code></td>
                                <td>Label element styling</td>
                            </tr>
                            <tr>
                                <td><code>so-form-text</code></td>
                                <td>Help text styling</td>
                            </tr>
                            <tr>
                                <td><code>so-invalid-feedback</code></td>
                                <td>Error message styling</td>
                            </tr>
                            <tr>
                                <td><code>so-valid-feedback</code></td>
                                <td>Success message styling</td>
                            </tr>
                            <tr>
                                <td><code>so-input-group</code></td>
                                <td>Wrapper for input with prefix/suffix</td>
                            </tr>
                            <tr>
                                <td><code>so-input-group-text</code></td>
                                <td>Text addon in input group</td>
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
                    <button class="so-tab so-active" role="tab" data-so-target="#input-methods">Input Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#input-form-methods">Form Element</button>
                    <button class="so-tab" role="tab" data-so-target="#input-validation-methods">Validation</button>
                    <button class="so-tab" role="tab" data-so-target="#input-event-methods">Events</button>
                    <button class="so-tab" role="tab" data-so-target="#input-base-methods">Base Element</button>
                </div>

                <!-- Tab Panes -->
                <div class="so-tab-content">
                    <!-- Input Methods -->
                    <div class="so-tab-pane so-fade so-show so-active" id="input-methods">
                        <p class="so-text-muted so-mb-2">PHP: <code>Core\UiEngine\Elements\Form\Input</code> | JS: <code>Input</code> class</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:25%">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>inputType()</code></td>
                                        <td><code>string $type</code></td>
                                        <td>Set input type (text, email, password, etc.)</td>
                                    </tr>
                                    <tr>
                                        <td><code>email()</code></td>
                                        <td>-</td>
                                        <td>Set as email type</td>
                                    </tr>
                                    <tr>
                                        <td><code>password()</code></td>
                                        <td>-</td>
                                        <td>Set as password type</td>
                                    </tr>
                                    <tr>
                                        <td><code>number()</code></td>
                                        <td>-</td>
                                        <td>Set as number type</td>
                                    </tr>
                                    <tr>
                                        <td><code>tel()</code></td>
                                        <td>-</td>
                                        <td>Set as telephone type</td>
                                    </tr>
                                    <tr>
                                        <td><code>url()</code></td>
                                        <td>-</td>
                                        <td>Set as URL type</td>
                                    </tr>
                                    <tr>
                                        <td><code>search()</code></td>
                                        <td>-</td>
                                        <td>Set as search type</td>
                                    </tr>
                                    <tr>
                                        <td><code>date()</code></td>
                                        <td>-</td>
                                        <td>Set as date type</td>
                                    </tr>
                                    <tr>
                                        <td><code>time()</code></td>
                                        <td>-</td>
                                        <td>Set as time type</td>
                                    </tr>
                                    <tr>
                                        <td><code>datetime()</code></td>
                                        <td>-</td>
                                        <td>Set as datetime-local type</td>
                                    </tr>
                                    <tr>
                                        <td><code>month()</code></td>
                                        <td>-</td>
                                        <td>Set as month type</td>
                                    </tr>
                                    <tr>
                                        <td><code>week()</code></td>
                                        <td>-</td>
                                        <td>Set as week type</td>
                                    </tr>
                                    <tr>
                                        <td><code>color()</code></td>
                                        <td>-</td>
                                        <td>Set as color type</td>
                                    </tr>
                                    <tr>
                                        <td><code>range()</code></td>
                                        <td>-</td>
                                        <td>Set as range type</td>
                                    </tr>
                                    <tr>
                                        <td><code>min()</code></td>
                                        <td><code>mixed $min</code></td>
                                        <td>Set minimum value (number, date)</td>
                                    </tr>
                                    <tr>
                                        <td><code>max()</code></td>
                                        <td><code>mixed $max</code></td>
                                        <td>Set maximum value</td>
                                    </tr>
                                    <tr>
                                        <td><code>step()</code></td>
                                        <td><code>mixed $step</code></td>
                                        <td>Set step increment</td>
                                    </tr>
                                    <tr>
                                        <td><code>minlength()</code></td>
                                        <td><code>int $length</code></td>
                                        <td>Set minimum character length</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxlength()</code></td>
                                        <td><code>int $length</code></td>
                                        <td>Set maximum character length</td>
                                    </tr>
                                    <tr>
                                        <td><code>pattern()</code></td>
                                        <td><code>string $regex</code></td>
                                        <td>Set regex validation pattern</td>
                                    </tr>
                                    <tr>
                                        <td><code>autocomplete()</code></td>
                                        <td><code>string $value</code></td>
                                        <td>Set autocomplete attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>noAutocomplete()</code></td>
                                        <td>-</td>
                                        <td>Disable autocomplete</td>
                                    </tr>
                                    <tr>
                                        <td><code>prefix()</code></td>
                                        <td><code>string $text</code></td>
                                        <td>Add input group prefix</td>
                                    </tr>
                                    <tr>
                                        <td><code>suffix()</code></td>
                                        <td><code>string $text</code></td>
                                        <td>Add input group suffix</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Form Element Methods -->
                    <div class="so-tab-pane so-fade" id="input-form-methods">
                        <p class="so-text-muted so-mb-2">Inherited from <code>FormElement</code> base class:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:25%">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>name()</code> / <code>setName()</code></td>
                                        <td><code>string $name</code></td>
                                        <td>Set field name attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>getName()</code></td>
                                        <td>-</td>
                                        <td>Get field name</td>
                                    </tr>
                                    <tr>
                                        <td><code>label()</code> / <code>setLabel()</code></td>
                                        <td><code>string $label</code></td>
                                        <td>Set label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>getLabel()</code></td>
                                        <td>-</td>
                                        <td>Get label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>value()</code> / <code>setValue()</code></td>
                                        <td><code>mixed $value</code></td>
                                        <td>Set field value</td>
                                    </tr>
                                    <tr>
                                        <td><code>getValue()</code></td>
                                        <td>-</td>
                                        <td>Get field value</td>
                                    </tr>
                                    <tr>
                                        <td><code>placeholder()</code> / <code>setPlaceholder()</code></td>
                                        <td><code>string $text</code></td>
                                        <td>Set placeholder text</td>
                                    </tr>
                                    <tr>
                                        <td><code>help()</code> / <code>setHelp()</code></td>
                                        <td><code>string $text</code></td>
                                        <td>Set help text</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code> / <code>setDisabled()</code></td>
                                        <td><code>bool $disabled = true</code></td>
                                        <td>Set disabled state</td>
                                    </tr>
                                    <tr>
                                        <td><code>isDisabled()</code></td>
                                        <td>-</td>
                                        <td>Check if disabled</td>
                                    </tr>
                                    <tr>
                                        <td><code>readonly()</code> / <code>setReadonly()</code></td>
                                        <td><code>bool $readonly = true</code></td>
                                        <td>Set readonly state</td>
                                    </tr>
                                    <tr>
                                        <td><code>isReadonly()</code></td>
                                        <td>-</td>
                                        <td>Check if readonly</td>
                                    </tr>
                                    <tr>
                                        <td><code>size()</code></td>
                                        <td><code>string $size</code></td>
                                        <td>Set size (sm, md, lg)</td>
                                    </tr>
                                    <tr>
                                        <td><code>small()</code></td>
                                        <td>-</td>
                                        <td>Set small size</td>
                                    </tr>
                                    <tr>
                                        <td><code>large()</code></td>
                                        <td>-</td>
                                        <td>Set large size</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>-</td>
                                        <td>Render input element only</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderGroup()</code></td>
                                        <td>-</td>
                                        <td>Render with label, help, error</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray()</code> / <code>toConfig()</code></td>
                                        <td>-</td>
                                        <td>Export configuration</td>
                                    </tr>
                                    <tr>
                                        <td><code>toHtml()</code></td>
                                        <td>-</td>
                                        <td>Get HTML string (JS only)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Validation Methods -->
                    <div class="so-tab-pane so-fade" id="input-validation-methods">
                        <p class="so-text-muted so-mb-2">From <code>HasValidation</code> trait:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:25%">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>rules()</code> / <code>setRules()</code></td>
                                        <td><code>string|array $rules</code></td>
                                        <td>Set validation rules</td>
                                    </tr>
                                    <tr>
                                        <td><code>getRules()</code></td>
                                        <td>-</td>
                                        <td>Get all validation rules</td>
                                    </tr>
                                    <tr>
                                        <td><code>addRule()</code></td>
                                        <td><code>string $rule, mixed $params = true</code></td>
                                        <td>Add a single rule</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeRule()</code></td>
                                        <td><code>string $rule</code></td>
                                        <td>Remove a rule</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasRule()</code></td>
                                        <td><code>string $rule</code></td>
                                        <td>Check if rule exists</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasRules()</code></td>
                                        <td>-</td>
                                        <td>Check if any rules set</td>
                                    </tr>
                                    <tr>
                                        <td><code>clearRules()</code></td>
                                        <td>-</td>
                                        <td>Clear all rules</td>
                                    </tr>
                                    <tr>
                                        <td><code>messages()</code> / <code>setMessages()</code></td>
                                        <td><code>array $messages</code></td>
                                        <td>Set custom error messages</td>
                                    </tr>
                                    <tr>
                                        <td><code>message()</code></td>
                                        <td><code>string $rule, string $message</code></td>
                                        <td>Set single message</td>
                                    </tr>
                                    <tr>
                                        <td><code>required()</code> / <code>setRequired()</code></td>
                                        <td><code>?string $message = null</code></td>
                                        <td>Add required rule</td>
                                    </tr>
                                    <tr>
                                        <td><code>isRequired()</code></td>
                                        <td>-</td>
                                        <td>Check if required</td>
                                    </tr>
                                    <tr>
                                        <td><code>error()</code> / <code>setError()</code></td>
                                        <td><code>?string $error</code></td>
                                        <td>Set error message</td>
                                    </tr>
                                    <tr>
                                        <td><code>getError()</code></td>
                                        <td>-</td>
                                        <td>Get error message</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasError()</code></td>
                                        <td>-</td>
                                        <td>Check if has error</td>
                                    </tr>
                                    <tr>
                                        <td><code>clearError()</code></td>
                                        <td>-</td>
                                        <td>Clear error</td>
                                    </tr>
                                    <tr>
                                        <td><code>exportValidation()</code></td>
                                        <td>-</td>
                                        <td>Export rules/messages for JS</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Event Methods -->
                    <div class="so-tab-pane so-fade" id="input-event-methods">
                        <p class="so-text-muted so-mb-2">From <code>HasEvents</code> trait:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:25%">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>on()</code> / <code>onEvent()</code></td>
                                        <td><code>string $event, string|Function $handler</code></td>
                                        <td>Set event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onMany()</code></td>
                                        <td><code>array $events</code></td>
                                        <td>Set multiple handlers</td>
                                    </tr>
                                    <tr>
                                        <td><code>off()</code></td>
                                        <td><code>string $event</code></td>
                                        <td>Remove event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onClick()</code></td>
                                        <td><code>string|Function $handler</code></td>
                                        <td>Set click handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onChange()</code></td>
                                        <td><code>string|Function $handler</code></td>
                                        <td>Set change handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onInput()</code></td>
                                        <td><code>string|Function $handler</code></td>
                                        <td>Set input handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onFocus()</code></td>
                                        <td><code>string|Function $handler</code></td>
                                        <td>Set focus handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onBlur()</code></td>
                                        <td><code>string|Function $handler</code></td>
                                        <td>Set blur handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onKeyUp()</code></td>
                                        <td><code>string|Function $handler</code></td>
                                        <td>Set keyup handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onKeyDown()</code></td>
                                        <td><code>string|Function $handler</code></td>
                                        <td>Set keydown handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>useInlineEvents()</code></td>
                                        <td><code>bool $inline = true</code></td>
                                        <td>Use inline handlers (PHP)</td>
                                    </tr>
                                    <tr>
                                        <td><code>clearEvents()</code></td>
                                        <td>-</td>
                                        <td>Clear all handlers</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Base Element Methods -->
                    <div class="so-tab-pane so-fade" id="input-base-methods">
                        <p class="so-text-muted so-mb-2">Inherited from <code>Element</code> base class:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:25%">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>id()</code> / <code>setId()</code></td>
                                        <td><code>string $id</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>getId()</code></td>
                                        <td>-</td>
                                        <td>Get element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>addClass()</code></td>
                                        <td><code>string $class</code></td>
                                        <td>Add CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeClass()</code></td>
                                        <td><code>string $class</code></td>
                                        <td>Remove CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr()</code> / <code>setAttr()</code></td>
                                        <td><code>string $name, mixed $value</code></td>
                                        <td>Set HTML attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>setAttributes()</code></td>
                                        <td><code>array $attrs</code></td>
                                        <td>Set multiple attributes</td>
                                    </tr>
                                    <tr>
                                        <td><code>data()</code> / <code>setData()</code></td>
                                        <td><code>string $key, mixed $value</code></td>
                                        <td>Set data-* attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>setDataAttributes()</code></td>
                                        <td><code>array $data</code></td>
                                        <td>Set multiple data attributes</td>
                                    </tr>
                                    <tr>
                                        <td><code>when()</code></td>
                                        <td><code>bool $condition, callable $callback</code></td>
                                        <td>Conditional method chaining</td>
                                    </tr>
                                    <tr>
                                        <td><code>unless()</code></td>
                                        <td><code>bool $condition, callable $callback</code></td>
                                        <td>Inverse conditional</td>
                                    </tr>
                                    <tr>
                                        <td><code>getType()</code></td>
                                        <td>-</td>
                                        <td>Get element type</td>
                                    </tr>
                                    <tr>
                                        <td><code>getElement()</code></td>
                                        <td>-</td>
                                        <td>Get DOM element (JS)</td>
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
