<?php
/**
 * UiEngine Validation Demo
 * Demonstrates form validation with frontend and backend validation
 */

$pageTitle = 'UiEngine - Form Validation';
$pageDescription = 'Demonstrates form validation in both frontend and backend using UiEngine';

require_once '../includes/layout-start.php';

use Core\UiEngine\UiEngine;

// Get UI Engine JS path
$uiEngineJs = so_asset('js', 'ui-engine');

// Page scripts for JavaScript demos
$pageScripts = <<<SCRIPT
<script src="{$uiEngineJs}" type="module"></script>
<script>
console.log('=== VALIDATION DEMO SCRIPT LOADING ===');

// Simulate backend validation
async function simulateBackendValidation(email) {
    // Simulate network delay
    await new Promise(resolve => setTimeout(resolve, 500));

    // Simulate backend validation logic
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!email || email.trim() === '') {
        return {
            success: false,
            message: 'Email is required'
        };
    }

    if (!emailRegex.test(email)) {
        return {
            success: false,
            message: 'Invalid email format'
        };
    }

    // Check against "blocked" emails (simulated)
    const blockedEmails = ['test@blocked.com', 'spam@example.com'];
    if (blockedEmails.includes(email.toLowerCase())) {
        return {
            success: false,
            message: 'This email is not allowed'
        };
    }

    return {
        success: true,
        message: 'Email is valid!'
    };
}

// Handle form submission
window.handleValidationSubmit = async function(event, source) {
    event.preventDefault();

    const form = event.target;
    const emailInput = form.querySelector('input[name="email"]');
    const email = emailInput.value;
    const resultDiv = document.getElementById('validation-result-' + source);

    // Clear previous error states
    const formGroup = emailInput.closest('.so-form-group');
    formGroup.classList.remove('has-error', 'has-success');
    const existingError = formGroup.querySelector('.so-form-error');
    if (existingError) {
        existingError.remove();
    }

    // Show loading state
    resultDiv.className = 'validation-result';
    resultDiv.innerHTML = '<div class="validation-result-message"><span class="material-icons">hourglass_empty</span><span>Validating...</span></div>';
    resultDiv.style.display = 'block';

    try {
        // Frontend validation (HTML5)
        if (!emailInput.checkValidity()) {
            throw new Error('Please enter a valid email address');
        }

        // Backend validation (simulated)
        const result = await simulateBackendValidation(email);

        if (result.success) {
            // Show success
            resultDiv.className = 'validation-result success';
            resultDiv.innerHTML = '<div class="validation-result-message"><span class="material-icons">check_circle</span><span>' + result.message + '</span></div>';

            formGroup.classList.add('has-success');
            emailInput.value = ''; // Clear the input
        } else {
            // Show backend error
            throw new Error(result.message);
        }
    } catch (error) {
        // Show error
        resultDiv.className = 'validation-result error';
        resultDiv.innerHTML = '<div class="validation-result-message"><span class="material-icons">error</span><span>' + error.message + '</span></div>';

        // Add error state to form group
        formGroup.classList.add('has-error');

        // Add error message below input
        const errorDiv = document.createElement('div');
        errorDiv.className = 'so-form-error';
        errorDiv.innerHTML = '<span class="material-icons">error</span><span>' + error.message + '</span>';

        const hint = formGroup.querySelector('.so-form-hint');
        if (hint) {
            hint.insertAdjacentElement('beforebegin', errorDiv);
        } else {
            const inputWrapper = formGroup.querySelector('.so-input-wrapper') || emailInput;
            inputWrapper.insertAdjacentElement('afterend', errorDiv);
        }
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
</style>
SCRIPT;
?>

<!-- ============================================ -->
<!-- SECTION: Email Validation -->
<!-- ============================================ -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Email Validation</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Email input with required field and format validation on both frontend and backend</p>

        <?php
        // PHP Code Example
        $phpCode = <<<'PHP'
// Create form with email validation
echo UiEngine::form()
    ->id('validation-form-php')
    ->addClass('so-form-validation-demo')
    ->onSubmit('return handleValidationSubmit(event, "php")')
    ->addMany([
        UiEngine::input()
            ->inputType('email')
            ->name('email')
            ->label('Email Address')
            ->placeholder('Enter your email')
            ->prefixIcon('email')
            ->required()
            ->help('Enter a valid email address'),

        UiEngine::button()
            ->submit()
            ->text('Validate')
            ->primary()
            ->icon('verified')
    ])
    ->render();
PHP;

        // PHP Output
        $phpOutput = '<div id="validation-result-php" class="validation-result"></div>';
        $phpOutput .= UiEngine::form()
            ->id('validation-form-php')
            ->addClass('so-form-validation-demo')
            ->onSubmit('return handleValidationSubmit(event, "php")')
            ->addMany([
                UiEngine::input()
                    ->inputType('email')
                    ->name('email')
                    ->label('Email Address')
                    ->placeholder('Enter your email')
                    ->prefixIcon('email')
                    ->required()
                    ->help('Enter a valid email address'),

                UiEngine::button()
                    ->submit()
                    ->text('Validate')
                    ->primary()
                    ->icon('verified')
            ])
            ->render();

        $phpContent = '<div class="so-mt-4">' . $phpOutput . '</div><div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';

        // PHP Config Code Example
        $phpConfigCode = <<<'PHP'
$formConfig = [
    'type' => 'form',
    'id' => 'validation-form-php-config',
    'classes' => ['so-form-validation-demo'],
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
<form id="validation-form" class="so-form so-form-validation-demo" onsubmit="return handleValidationSubmit(event, 'demo')">
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
                }).render();
            };
        </script>
    </div>
</div>

<?php require_once '../includes/layout-end.php'; ?>
