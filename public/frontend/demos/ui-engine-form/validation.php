<?php

/**
 * UiEngine Validation Demo
 * Demonstrates form validation with frontend and backend validation
 */

$pageTitle = 'UiEngine - Form Validation';
$pageDescription = 'Demonstrates form validation in both frontend and backend using UiEngine';

require_once '../includes/layout-start.php';

use Core\UiEngine\UiEngine;

// Get UI Engine JS paths
$uiEngineJs = so_asset('js', 'ui-engine');
// Construct validation module paths from base path
$validationEngineJs = str_replace('ui-engine.js', 'ui-engine/validation/ValidationEngine.js', $uiEngineJs);
$errorReporterJs = str_replace('ui-engine.js', 'ui-engine/validation/ErrorReporter.js', $uiEngineJs);

// Page scripts for JavaScript demos
// Add cache-busting parameter to force reload
$cacheBust = time();
$pageScripts = <<<SCRIPT
<script src="{$uiEngineJs}?v={$cacheBust}"></script>
<script>
// Wait for UiEngine to load
document.addEventListener('DOMContentLoaded', function() {
    // Access ValidationEngine and ErrorReporter from global window object
    const ValidationEngine = window.ValidationEngine;
    const ErrorReporter = window.ErrorReporter;

    // Initialize ErrorReporter with bottom-right position
    const errorReporter = ErrorReporter.getInstance({
        position: 'bottom-right',
        autoHide: false,
        maxErrors: 10,
        groupByField: true,
        showFieldLinks: true,
        dismissible: true
    });

    // Make errorReporter global for handleValidationSubmit
    window.errorReporter = errorReporter;
    window.ValidationEngine = ValidationEngine;

    // Simulate backend validation
    async function simulateBackendValidation(email) {
        await new Promise(resolve => setTimeout(resolve, 500));

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email || email.trim() === '') {
            return { success: false, message: 'Email is required' };
        }

        if (!emailRegex.test(email)) {
            return { success: false, message: 'Invalid email format' };
        }

        const blockedEmails = ['test@blocked.com', 'spam@example.com'];
        if (blockedEmails.includes(email.toLowerCase())) {
            return { success: false, message: 'This email is not allowed' };
        }

        return { success: true, message: 'Email is valid!' };
    }

    // Handle form submission with ErrorReporter
    window.handleValidationSubmit = async function(event, source) {
        event.preventDefault();

        // Check if ValidationEngine is ready
        if (!window.ValidationEngine || !window.errorReporter) {
            alert('Validation system is still loading. Please try again.');
            return false;
        }

        const form = event.target;
        const emailInput = form.querySelector('input[name="email"]');
        const email = emailInput.value;

        // Clear previous errors
        window.errorReporter.clearAll();
    const formGroup = emailInput.closest('.so-form-group');
    formGroup.classList.remove('has-error', 'has-success');
    const existingError = formGroup.querySelector('.so-form-error');
    if (existingError) {
        existingError.remove();
    }

    try {
        // Validate using ValidationEngine
        const result = window.ValidationEngine.validateField(emailInput);

        if (!result.valid) {
            // Show errors in ErrorReporter (top-right)
            window.errorReporter.showAll({
                email: result.errors
            });

            // Also show inline error
            formGroup.classList.add('has-error');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'so-form-error';
            errorDiv.innerHTML = '<span class="material-icons">error</span><span>' + result.errors[0] + '</span>';
            const inputWrapper = formGroup.querySelector('.so-input-wrapper') || emailInput;
            inputWrapper.insertAdjacentElement('afterend', errorDiv);

            return false;
        }

        // Backend validation (simulated)
        const backendResult = await simulateBackendValidation(email);

        if (backendResult.success) {
            // Success!
            formGroup.classList.add('has-success');
            alert('✅ ' + backendResult.message);
            emailInput.value = '';
        } else {
            // Backend error
            throw new Error(backendResult.message);
        }
    } catch (error) {
        // Show error in ErrorReporter
        window.errorReporter.showAll({
            email: [error.message]
        });

        // Show inline error
        formGroup.classList.add('has-error');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'so-form-error';
        errorDiv.innerHTML = '<span class="material-icons">error</span><span>' + error.message + '</span>';
        const inputWrapper = formGroup.querySelector('.so-input-wrapper') || emailInput;
        inputWrapper.insertAdjacentElement('afterend', errorDiv);
    }

    return false;
};

const renderedDemos = new Set();

function renderDemo(containerId, demoConfig) {
    if (renderedDemos.has(containerId)) {
        return;
    }

    if (window.UiEngine) {
        const container = document.getElementById(containerId);
        if (container) {
            container.innerHTML = '';
            const form = demoConfig(window.UiEngine);
            container.appendChild(form);
            renderedDemos.add(containerId);
        }
    } else {
        setTimeout(() => renderDemo(containerId, demoConfig), 50);
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
        const configFn = window.validationDemos[containerId];
        if (configFn) {
            setTimeout(() => renderDemo(containerId, configFn), 200);
        }
    }
});

// Initialize demos storage
window.validationDemos = window.validationDemos || {};

// Verify function is registered
}); // Close DOMContentLoaded
</script>

<style>
/* Validation Demo Styles */
.so-form-validation-demo {
    max-width: 500px;
}

.validation-result {
    margin-bottom: 20px;
    padding: 12px 16px;
    border-radius: 6px;
    display: none;
}

.validation-result.success {
    display: block;
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.validation-result.error {
    display: block;
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.validation-result-message {
    display: flex;
    align-items: center;
    gap: 8px;
}

.validation-result-message .material-icons {
    font-size: 20px;
}

/* Strategy button active state */
.strategy-btn.active {
    background-color: var(--so-primary, #0d6efd) !important;
    color: white !important;
    border-color: var(--so-primary, #0d6efd) !important;
}

.strategy-btn.active::before {
    content: '✓ ';
    margin-right: 4px;
}
</style>
SCRIPT;
?>

<!-- ============================================ -->
<!-- SECTION: Email Validation with ErrorReporter -->
<!-- ============================================ -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Email Validation with ErrorReporter</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">
            Email validation using <strong>ValidationEngine</strong> and <strong>ErrorReporter</strong>.
            Try submitting with empty or invalid email - errors will appear in <strong>top-right corner</strong> with click-to-focus functionality.
        </p>
        <div class="so-alert so-alert-info so-mb-3">
            <span class="material-icons">info</span>
            <div>
                <strong>What to Try:</strong>
                <ul class="so-mb-0 so-mt-2">
                    <li>Submit empty field - see "Email is required" error in top-right</li>
                    <li>Enter invalid email like "test" - see validation error</li>
                    <li>Click on error in top-right - watch it jump to the field!</li>
                    <li>Enter valid email and submit - success!</li>
                </ul>
            </div>
        </div>

        <?php
        // PHP Code Example
        $phpCode = <<<'PHP'
// Create form with validation rules and custom error messages
$form = UiEngine::form()
    ->id('validation-form-php')
    ->addClass('so-form-validation-demo')
    ->novalidate() // Disable native HTML5 validation
    ->useInlineEvents() // Enable inline event handlers (onsubmit instead of data-on-submit)
    ->onSubmit('return handleValidationSubmit(event, "php")')
    ->addMany([
        UiEngine::input()
            ->inputType('email')
            ->name('email')
            ->label('Email Address')
            ->placeholder('Enter your email')
            ->prefixIcon('email')
            ->required()
            ->email()
            ->messages([
                'required' => 'Please provide your email address',
                'email' => 'Please enter a valid email format (e.g., name@example.com)'
            ])
            ->help('Enter a valid email address'),

        UiEngine::button()
            ->submit()
            ->text('Validate')
            ->primary()
            ->icon('verified')
    ]);

// Export validation rules for JavaScript ValidationEngine
$validationRules = $form->exportValidation();
echo $form->render();

// Load rules into ValidationEngine (in JavaScript)
// Wait for ValidationEngine to be available before loading rules
echo '<script>';
echo '(function() {';
echo '  function loadRules() {';
echo '    if (window.ValidationEngine) {';
echo '      window.ValidationEngine.loadRules("validation-form-php", ' . json_encode($validationRules) . ');';
echo '    } else { setTimeout(loadRules, 50); }';
echo '  }';
echo '  loadRules();';
echo '})();';
echo '</script>';
PHP;

        // PHP Output - Create form with validation rules
        $form = UiEngine::form()
            ->id('validation-form-php')
            ->addClass('so-form-validation-demo')
            ->novalidate() // Disable native HTML5 validation
            ->useInlineEvents() // Enable inline event handlers (onsubmit instead of data-on-submit)
            ->onSubmit('return handleValidationSubmit(event, "php")')
            ->addMany([
                UiEngine::input()
                    ->inputType('email')
                    ->name('email')
                    ->label('Email Address')
                    ->placeholder('Enter your email')
                    ->prefixIcon('email')
                    ->required()
                    ->email()
                    ->messages([
                        'required' => 'Please provide your email address',
                        'email' => 'Please enter a valid email format (e.g., name@example.com)'
                    ])
                    ->help('Enter a valid email address'),

                UiEngine::button()
                    ->submit()
                    ->text('Validate')
                    ->primary()
                    ->icon('verified')
            ]);

        // Export validation rules for JavaScript
        $validationRules = $form->exportValidation();
        $validationRulesJson = json_encode($validationRules);

        // Render form (ErrorReporter will show errors in top-right)
        $phpOutput = $form->render();

        // Add script to load validation rules (wait for ValidationEngine to be available)
        $phpOutput .= <<<SCRIPT
<script>
(function() {
    function loadRules() {
        if (window.ValidationEngine) {
            const rules = {$validationRulesJson};
            window.ValidationEngine.loadRules("validation-form-php", rules);
        } else {
            setTimeout(loadRules, 50);
        }
    }
    loadRules();
})();
</script>
SCRIPT;

        $phpContent = '<div class="so-mt-4">' . $phpOutput . '</div><div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';

        // PHP Config Code Example
        $phpConfigCode = <<<'PHP'
$formConfig = [
    'type' => 'form',
    'id' => 'validation-form-php-config',
    'classes' => ['so-form-validation-demo'],
    'novalidate' => true, // Disable native HTML5 validation
    'onSubmit' => 'return handleValidationSubmit(event, "php-config")',
    'children' => [
        [
            'type' => 'input',
            'inputType' => 'email',
            'name' => 'email',
            'label' => 'Email Address',
            'placeholder' => 'Enter your email',
            'prefixIcon' => 'email',
            'required' => true,
            'help' => 'Enter a valid email address'
        ],
        [
            'type' => 'button',
            'buttonType' => 'submit',
            'text' => 'Validate',
            'variant' => 'primary',
            'icon' => 'verified'
        ]
    ]
];

echo UiEngine::fromConfig($formConfig)->render();
PHP;

        // PHP Config Output
        $phpConfigOutput = '<div id="validation-result-php-config" class="validation-result"></div>';
        $phpConfigOutput .= UiEngine::fromConfig([
            'type' => 'form',
            'id' => 'validation-form-php-config',
            'classes' => ['so-form-validation-demo'],
            'novalidate' => true,
            'onSubmit' => 'return handleValidationSubmit(event, "php-config")',
            'children' => [
                [
                    'type' => 'input',
                    'inputType' => 'email',
                    'name' => 'email',
                    'label' => 'Email Address',
                    'placeholder' => 'Enter your email',
                    'prefixIcon' => 'email',
                    'required' => true,
                    'help' => 'Enter a valid email address'
                ],
                [
                    'type' => 'button',
                    'buttonType' => 'submit',
                    'text' => 'Validate',
                    'variant' => 'primary',
                    'icon' => 'verified'
                ]
            ]
        ])->render();

        $phpConfigContent = '<div class="so-mt-4">' . $phpConfigOutput . '</div><div class="so-mt-4">' . so_code_block($phpConfigCode, 'php') . '</div>';

        // JavaScript Code Example
        $jsCode = <<<'JS'
// Create form with email validation
const form = UiEngine.form()
    .id('validation-form-js')
    .addClass('so-form-validation-demo')
    .novalidate() // Disable native HTML5 validation
    .onSubmit('return handleValidationSubmit(event, "js")')
    .addMany([
        UiEngine.input()
            .inputType('email')
            .name('email')
            .label('Email Address')
            .placeholder('Enter your email')
            .prefixIcon('email')
            .required()
            .help('Enter a valid email address'),

        UiEngine.button()
            .submit()
            .text('Validate')
            .primary()
            .icon('verified')
    ]);

document.getElementById('js-validation-container').appendChild(form.render());
JS;

        $jsContent = '<div id="validation-result-js" class="validation-result"></div><div id="js-validation-container"></div><div class="so-mt-4">' . so_code_block($jsCode, 'javascript') . '</div>';

        // JavaScript Config Code Example
        $jsConfigCode = <<<'JS'
const formConfig = {
    type: 'form',
    id: 'validation-form-js-config',
    classes: ['so-form-validation-demo'],
    novalidate: true, // Disable native HTML5 validation
    onSubmit: 'return handleValidationSubmit(event, "js-config")',
    children: [
        {
            type: 'input',
            inputType: 'email',
            name: 'email',
            label: 'Email Address',
            placeholder: 'Enter your email',
            prefixIcon: 'email',
            required: true,
            help: 'Enter a valid email address'
        },
        {
            type: 'button',
            buttonType: 'submit',
            text: 'Validate',
            variant: 'primary',
            icon: 'verified'
        }
    ]
};

const form = UiEngine.fromConfig(formConfig);
document.getElementById('js-config-validation-container').appendChild(form.render());
JS;

        $jsConfigContent = '<div id="validation-result-js-config" class="validation-result"></div><div id="js-config-validation-container"></div><div class="so-mt-4">' . so_code_block($jsConfigCode, 'javascript') . '</div>';

        // HTML Output
        $htmlOutput = <<<'HTML'
<form id="validation-form" class="so-form so-form-validation-demo" novalidate onsubmit="return handleValidationSubmit(event, 'demo')">
    <!-- Email Input -->
    <div class="so-form-group">
        <label for="email" class="so-form-label so-required">Email Address</label>
        <div class="so-input-wrapper">
            <span class="so-input-icon">
                <span class="material-icons">email</span>
            </span>
            <input
                type="email"
                id="email"
                name="email"
                class="so-form-control"
                placeholder="Enter your email"
                required
            >
        </div>
        <div class="so-form-hint">Enter a valid email address</div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="so-btn so-btn-primary">
        <span class="so-btn-icon so-btn-icon-prefix">
            <span class="material-icons">verified</span>
        </span>
        <span class="so-btn-label">Validate</span>
    </button>
</form>
HTML;

        $htmlContent = so_code_block($htmlOutput, 'html');

        // Display tabs
        echo so_tabs('validation', [
            ['id' => 'php-validation', 'label' => 'PHP', 'icon' => 'data_object', 'active' => true, 'content' => $phpContent],
            ['id' => 'php-config-validation', 'label' => 'PHP Config', 'icon' => 'settings', 'active' => false, 'content' => $phpConfigContent],
            ['id' => 'js-validation', 'label' => 'JavaScript', 'icon' => 'javascript', 'active' => false, 'content' => $jsContent],
            ['id' => 'js-config-validation', 'label' => 'JS Config', 'icon' => 'settings', 'active' => false, 'content' => $jsConfigContent],
            ['id' => 'html-validation', 'label' => 'HTML Output', 'icon' => 'code', 'active' => false, 'content' => $htmlContent]
        ]);
        ?>

        <script>
            window.validationDemos = window.validationDemos || {};

            // JS Validation Demo
            window.validationDemos['js-validation-container'] = (UiEngine) => {
                return UiEngine.form()
                    .id('validation-form-js')
                    .addClass('so-form-validation-demo')
                    .novalidate()
                    .onSubmit('return handleValidationSubmit(event, "js")')
                    .addMany([
                        UiEngine.input()
                        .inputType('email')
                        .name('email')
                        .label('Email Address')
                        .placeholder('Enter your email')
                        .prefixIcon('email')
                        .required()
                        .help('Enter a valid email address'),

                        UiEngine.button()
                        .submit()
                        .text('Validate')
                        .primary()
                        .icon('verified')
                    ]).render();
            };

            // JS Config Validation Demo
            window.validationDemos['js-config-validation-container'] = (UiEngine) => {
                return UiEngine.fromConfig({
                    type: 'form',
                    id: 'validation-form-js-config',
                    classes: ['so-form-validation-demo'],
                    novalidate: true,
                    onSubmit: 'return handleValidationSubmit(event, "js-config")',
                    children: [{
                            type: 'input',
                            inputType: 'email',
                            name: 'email',
                            label: 'Email Address',
                            placeholder: 'Enter your email',
                            prefixIcon: 'email',
                            required: true,
                            help: 'Enter a valid email address'
                        },
                        {
                            type: 'button',
                            buttonType: 'submit',
                            text: 'Validate',
                            variant: 'primary',
                            icon: 'verified'
                        }
                    ]
                }).render();
            };
        </script>
    </div>
</div>

<!-- ============================================ -->
<!-- SECTION: Live Validation Demo -->
<!-- ============================================ -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Live Validation with attachLiveValidation</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">
            Demonstrates <strong>real-time field validation</strong> using <code>ValidationEngine.attachLiveValidation()</code>.
            Errors appear and clear automatically as you type, with configurable events and debouncing.
        </p>
        <div class="so-alert so-alert-info so-mb-3">
            <span class="material-icons">info</span>
            <div>
                <strong>Features:</strong>
                <ul class="so-mb-0 so-mt-2">
                    <li><strong>Real-time validation</strong> on input/change/blur events</li>
                    <li><strong>Auto-clear errors</strong> when field becomes valid</li>
                    <li><strong>Debouncing</strong> for input events (300ms delay)</li>
                    <li><strong>Inline errors</strong> below fields + ErrorReporter integration</li>
                </ul>
            </div>
        </div>

        <div class="so-alert so-alert-success so-mb-3">
            <span class="material-icons">rule</span>
            <div>
                <strong>Active Validation Rules:</strong>
                <ul class="so-mb-0 so-mt-2">
                    <li><strong>Username:</strong> required, min:3, max:20</li>
                    <li><strong>Email:</strong> required, email format</li>
                    <li><strong>Password:</strong> required, min:8</li>
                </ul>
                <small class="so-text-muted">Try leaving fields empty or entering invalid data to see validation in action.</small>
            </div>
        </div>

        <?php
        // PHP Code Example for Live Validation
        $liveValidationCode = <<<'PHP'
// Create registration form with multiple validation rules
$form = UiEngine::form()
    ->id('live-validation-form')
    ->addClass('so-form-validation-demo')
    ->novalidate()
    ->addMany([
        UiEngine::input()
            ->name('username')
            ->label('Username')
            ->placeholder('Enter username')
            ->prefixIcon('person')
            ->required()
            ->minLength(3)
            ->maxLength(20)
            ->messages([
                'required' => 'Username is required',
                'min' => 'Username must be at least 3 characters',
                'max' => 'Username cannot exceed 20 characters'
            ]),

        UiEngine::input()
            ->inputType('email')
            ->name('reg_email')
            ->label('Email')
            ->placeholder('your@email.com')
            ->prefixIcon('email')
            ->required()
            ->email()
            ->messages([
                'required' => 'Email is required',
                'email' => 'Please enter a valid email address'
            ]),

        UiEngine::input()
            ->inputType('password')
            ->name('password')
            ->label('Password')
            ->placeholder('Enter password')
            ->prefixIcon('lock')
            ->required()
            ->minLength(8)
            ->messages([
                'required' => 'Password is required',
                'min' => 'Password must be at least 8 characters'
            ]),

        UiEngine::button()
            ->submit()
            ->text('Register')
            ->primary()
            ->icon('person_add')
    ]);

echo $form->render();

// JavaScript: Attach live validation with debouncing
echo '<script>';
echo 'if (window.ValidationEngine) {';
echo '  const controller = ValidationEngine.attachLiveValidation("#live-validation-form", {';
echo '    events: { input: true, change: true, blur: true },';
echo '    errorDisplay: {';
echo '      inline: true,';
echo '      reporter: true,';
echo '      reporterPosition: "bottom-right",';
echo '      clearOnValid: true,';
echo '      showOn: "blur"';
echo '    },';
echo '    debounce: { enabled: true, delay: 300, validateOnEnter: true }';
echo '  });';
echo '}';
echo '</script>';
PHP;

        // Render the actual form
        $liveForm = UiEngine::form()
            ->id('live-validation-form')
            ->addClass('so-form-validation-demo')
            ->novalidate()
            ->addMany([
                UiEngine::input()
                    ->name('username')
                    ->label('Username')
                    ->placeholder('Enter username')
                    ->prefixIcon('person')
                    ->required()
                    ->minLength(3)
                    ->maxLength(20)
                    ->messages([
                        'required' => 'Username is required',
                        'min' => 'Username must be at least 3 characters',
                        'max' => 'Username cannot exceed 20 characters'
                    ]),

                UiEngine::input()
                    ->inputType('email')
                    ->name('reg_email')
                    ->label('Email')
                    ->placeholder('your@email.com')
                    ->prefixIcon('email')
                    ->required()
                    ->email()
                    ->messages([
                        'required' => 'Email is required',
                        'email' => 'Please enter a valid email address'
                    ]),

                UiEngine::input()
                    ->inputType('password')
                    ->name('password')
                    ->label('Password')
                    ->placeholder('Enter password')
                    ->prefixIcon('lock')
                    ->required()
                    ->minLength(8)
                    ->messages([
                        'required' => 'Password is required',
                        'min' => 'Password must be at least 8 characters'
                    ]),

                UiEngine::button()
                    ->submit()
                    ->text('Register')
                    ->primary()
                    ->icon('person_add')
            ]);

        $liveValidationRules = $liveForm->exportValidation();
        $liveValidationRulesJson = json_encode($liveValidationRules);
        $liveOutput = $liveForm->render();

        // Add script to attach live validation
        $liveOutput .= <<<SCRIPT
<script>
(function() {
    function attachLive() {
        if (window.ValidationEngine) {
            // Load rules first
            window.ValidationEngine.loadRules("live-validation-form", {$liveValidationRulesJson});

            // Attach live validation
            const controller = window.ValidationEngine.attachLiveValidation("#live-validation-form", {
                events: {
                    input: true,    // Validate as user types
                    change: true,   // Validate on value change
                    blur: true      // Validate when leaving field
                },
                errorDisplay: {
                    inline: true,           // Show errors below fields
                    reporter: true,         // Show in ErrorReporter
                    reporterPosition: 'bottom-right',
                    clearOnValid: true,     // Auto-clear when valid
                    showOn: 'blur'          // Only show errors on blur
                },
                debounce: {
                    enabled: true,          // Enable debouncing
                    delay: 300,             // Wait 300ms after typing stops
                    validateOnEnter: true   // Validate immediately on Enter key
                }
            });

            // Add submit handler
            const form = document.getElementById('live-validation-form');
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    const result = controller.validate();
                    if (result.valid) {
                        alert('✅ Registration successful!');
                        form.reset();
                        controller.clearErrors();
                    }
                });
            }
        } else {
            setTimeout(attachLive, 50);
        }
    }
    attachLive();
})();
</script>
SCRIPT;

        echo '<div class="so-mt-4">' . $liveOutput . '</div>';
        echo '<div class="so-mt-4">' . so_code_block($liveValidationCode, 'php') . '</div>';
        ?>
    </div>
</div>

<!-- ============================================ -->
<!-- SECTION: Central Handler with Presets -->
<!-- ============================================ -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Central Handler with Validation Presets</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">
            Demonstrates <strong>ValidationEngine.attachTo()</strong> - a central handler that manages all validation behaviors.
            Includes validation strategy <strong>presets</strong> for quick setup.
        </p>
        <div class="so-alert so-alert-info so-mb-3">
            <span class="material-icons">info</span>
            <div>
                <strong>Available Presets:</strong>
                <ul class="so-mb-0 so-mt-2">
                    <li><strong>aggressive</strong> - Validate on input + blur + submit (instant feedback)</li>
                    <li><strong>balanced</strong> - Validate on blur + submit (default)</li>
                    <li><strong>lazy</strong> - Validate only on submit, then on blur</li>
                    <li><strong>minimal</strong> - Validate only on submit</li>
                </ul>
            </div>
        </div>

        <div class="so-alert so-alert-success so-mb-3">
            <span class="material-icons">rule</span>
            <div>
                <strong>Active Validation Rules:</strong>
                <ul class="so-mb-0 so-mt-2">
                    <li><strong>Full Name:</strong> required, min:3</li>
                    <li><strong>Email:</strong> required, email format</li>
                </ul>
                <small class="so-text-muted">Switch between strategies to see how validation behavior changes. Try different strategies with valid and invalid data.</small>
            </div>
        </div>

        <!-- Strategy selector -->
        <div class="so-form-group so-mb-4">
            <label class="so-form-label">Choose Validation Strategy:</label>
            <div class="so-btn-group">
                <button type="button" class="so-btn so-btn-sm so-btn-outline-primary strategy-btn active" data-strategy="aggressive">
                    Aggressive
                </button>
                <button type="button" class="so-btn so-btn-sm so-btn-outline-primary strategy-btn" data-strategy="balanced">
                    Balanced
                </button>
                <button type="button" class="so-btn so-btn-sm so-btn-outline-primary strategy-btn" data-strategy="lazy">
                    Lazy
                </button>
                <button type="button" class="so-btn so-btn-sm so-btn-outline-primary strategy-btn" data-strategy="minimal">
                    Minimal
                </button>
            </div>
        </div>

        <?php
        // PHP Code Example for Central Handler
        $centralHandlerCode = <<<'PHP'
// Create contact form
$form = UiEngine::form()
    ->id('preset-validation-form')
    ->addClass('so-form-validation-demo')
    ->novalidate()
    ->addMany([
        UiEngine::input()
            ->name('full_name')
            ->label('Full Name')
            ->placeholder('John Doe')
            ->prefixIcon('person')
            ->required()
            ->minLength(3),

        UiEngine::input()
            ->inputType('email')
            ->name('contact_email')
            ->label('Email')
            ->placeholder('john@example.com')
            ->prefixIcon('email')
            ->required()
            ->email(),

        UiEngine::button()
            ->submit()
            ->text('Submit')
            ->primary()
            ->icon('send')
    ]);

echo $form->render();

// JavaScript: Use attachTo with preset strategy
echo '<script>';
echo 'if (window.ValidationEngine) {';
echo '  const controller = ValidationEngine.attachTo("#preset-validation-form", {';
echo '    strategy: "aggressive",  // or "balanced", "lazy", "minimal"';
echo '    errorDisplay: {';
echo '      inline: true,';
echo '      reporter: true,';
echo '      reporterPosition: "bottom-right"';
echo '    },';
echo '    callbacks: {';
echo '      onValid: (e, form) => alert("Form is valid!")';
echo '    }';
echo '  });';
echo '}';
echo '</script>';
PHP;

        // Render the actual form
        $presetForm = UiEngine::form()
            ->id('preset-validation-form')
            ->addClass('so-form-validation-demo')
            ->novalidate()
            ->addMany([
                UiEngine::input()
                    ->name('full_name')
                    ->label('Full Name')
                    ->placeholder('John Doe')
                    ->prefixIcon('person')
                    ->required()
                    ->minLength(3)
                    ->messages([
                        'required' => 'Full name is required',
                        'min' => 'Name must be at least 3 characters'
                    ]),

                UiEngine::input()
                    ->inputType('email')
                    ->name('contact_email')
                    ->label('Email')
                    ->placeholder('john@example.com')
                    ->prefixIcon('email')
                    ->required()
                    ->email()
                    ->messages([
                        'required' => 'Email is required',
                        'email' => 'Please enter a valid email address'
                    ]),

                UiEngine::button()
                    ->submit()
                    ->text('Submit')
                    ->primary()
                    ->icon('send')
            ]);

        $presetValidationRules = $presetForm->exportValidation();
        $presetValidationRulesJson = json_encode($presetValidationRules);
        $presetOutput = $presetForm->render();

        // Add script to attach central handler with preset
        $presetOutput .= <<<SCRIPT
<script>
(function() {
    let currentController = null;

    function attachPreset(strategy) {
        if (window.ValidationEngine) {
            // Detach previous controller
            if (currentController && currentController.detach) {
                currentController.detach();
            }

            // Clear errors
            window.ValidationEngine.clearFormErrors('#preset-validation-form');
            if (window.ErrorReporter) {
                window.ErrorReporter.getInstance().clearAll();
            }

            // Load rules first
            window.ValidationEngine.loadRules("preset-validation-form", {$presetValidationRulesJson});

            // Attach with preset strategy
            currentController = window.ValidationEngine.attachTo('#preset-validation-form', {
                strategy: strategy,
                errorDisplay: {
                    inline: true,
                    reporter: true,
                    reporterPosition: 'bottom-right'
                },
                submit: {
                    preventDefault: true,
                    focusFirstError: true,
                    scrollToError: true
                },
                callbacks: {
                    onValid: (e, form) => {
                        e.preventDefault();
                        alert('✅ Form is valid! Strategy: ' + strategy);
                    }
                }
            });
        } else {
            setTimeout(() => attachPreset(strategy), 50);
        }
    }

    // Initial attachment with aggressive strategy
    attachPreset('aggressive');

    // Strategy button handlers - use more specific selector
    const strategyButtons = document.querySelectorAll('.strategy-btn');
    strategyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const strategy = this.dataset.strategy;

            // Update active button
            strategyButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Re-attach with new strategy
            attachPreset(strategy);
        });
    });
})();
</script>
SCRIPT;

        echo '<div class="so-mt-4">' . $presetOutput . '</div>';
        echo '<div class="so-mt-4">' . so_code_block($centralHandlerCode, 'php') . '</div>';
        ?>
    </div>
</div>

<?php require_once '../includes/layout-end.php'; ?>