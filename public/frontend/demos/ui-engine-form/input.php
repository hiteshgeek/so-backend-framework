<?php

/**
 * UiEngine Input Component Demo
 * Demonstrating PHP and JavaScript implementations
 */

// Load config to access helper functions
require_once '../includes/config.php';

// Page configuration
$pageTitle = 'UiEngine - Input';
$pageSubtitle = 'Form input components with dual architecture support';

// Load backend autoloader for UiEngine
require_once dirname(__DIR__, 4) . '/vendor/autoload.php';

use Core\UiEngine\UiEngine;

// Get UI Engine JS path for scripts
$uiEngineJs = so_asset('js', 'ui-engine');

// Page scripts for JavaScript demos
$pageScripts = <<<SCRIPT
<script src="{$uiEngineJs}" type="module"></script>
<script>
const renderedDemos = new Set();

function renderDemo(containerId, demoConfig) {
    if (renderedDemos.has(containerId)) {
        return;
    }

    if (window.UiEngine) {
        const container = document.getElementById(containerId);
        if (container) {
            container.innerHTML = '';
            const elements = demoConfig(window.UiEngine);
            if (Array.isArray(elements)) {
                elements.forEach(el => container.appendChild(el));
            } else {
                container.appendChild(elements);
            }
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
        const configFn = window.formDemos[containerId];
        if (configFn) {
            setTimeout(() => renderDemo(containerId, configFn), 200);
        }
    }
});

// Initialize demos storage (preserve any already registered)
window.formDemos = window.formDemos || {};
</script>
SCRIPT;

// Start layout
require_once '../includes/layout-start.php';
?>

<!-- 1. Basic Form with Input -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">1. Basic Form with Input</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">A simple form with a text input and submit button. Demonstrates form creation using fluent API and config-based approaches.</p>
        <?php
        // PHP Fluent API - Create form with input and button
        $phpForm = UiEngine::form()
            ->action('/submit')
            ->method('POST')
            ->add(
                UiEngine::input()
                    ->inputType('text')
                    ->name('username')
                    ->label('Username')
                    ->placeholder('Enter your username')
                    ->required()
            )
            ->add(
                UiEngine::button()
                    ->buttonType('submit')
                    ->text('Submit')
                    ->variant('primary')
            )
            ->render();

        // PHP Config - Create form using config arrays
        $phpConfigForm = UiEngine::fromConfig([
            'type' => 'form',
            'action' => '/submit',
            'method' => 'POST',
            'children' => [
                [
                    'type' => 'input',
                    'inputType' => 'text',
                    'name' => 'username',
                    'label' => 'Username',
                    'placeholder' => 'Enter your username',
                    'required' => true
                ],
                [
                    'type' => 'button',
                    'buttonType' => 'submit',
                    'text' => 'Submit',
                    'variant' => 'primary'
                ]
            ]
        ])->render();

        // PHP Code for display
        $phpCode = <<<'PHP'
<?php
use Core\UiEngine\UiEngine;

$form = UiEngine::form()
    ->action('/submit')
    ->method('POST')
    ->add(
        UiEngine::input()
            ->inputType('text')
            ->name('username')
            ->label('Username')
            ->placeholder('Enter your username')
            ->required()
    )
    ->add(
        UiEngine::button()
            ->buttonType('submit')
            ->text('Submit')
            ->variant('primary')
    );

echo $form->render();
PHP;

        // PHP Config Code for display
        $phpConfigCode = <<<'PHP'
<?php
use Core\UiEngine\UiEngine;

$config = [
    'type' => 'form',
    'action' => '/submit',
    'method' => 'POST',
    'children' => [
        [
            'type' => 'input',
            'inputType' => 'text',
            'name' => 'username',
            'label' => 'Username',
            'placeholder' => 'Enter your username',
            'required' => true
        ],
        [
            'type' => 'button',
            'buttonType' => 'submit',
            'text' => 'Submit',
            'variant' => 'primary'
        ]
    ]
];

echo UiEngine::fromConfig($config)->render();
PHP;

        // JavaScript Code for display
        $jsCode = <<<'JS'
const form = UiEngine.form()
    .action('/submit')
    .method('POST')
    .add(
        UiEngine.input()
            .inputType('text')
            .name('username')
            .label('Username')
            .placeholder('Enter your username')
            .required()
    )
    .add(
        UiEngine.button()
            .buttonType('submit')
            .text('Submit')
            .variant('primary')
    );

document.getElementById('js-basic-container').appendChild(form.render());
JS;

        // JavaScript Config Code for display
        $jsConfigCode = <<<'JS'
const config = {
    type: 'form',
    action: '/submit',
    method: 'POST',
    children: [
        {
            type: 'input',
            inputType: 'text',
            name: 'username',
            label: 'Username',
            placeholder: 'Enter your username',
            required: true
        },
        {
            type: 'button',
            buttonType: 'submit',
            text: 'Submit',
            variant: 'primary'
        }
    ]
};

const form = UiEngine.fromConfig(config);
document.getElementById('js-config-basic-container').appendChild(form.render());
JS;

        // HTML Output
        $htmlOutput = <<<'HTML'
<form action="/submit" method="POST" class="so-form">
    <div class="so-form-group">
        <label for="username" class="so-form-label">
            Username
            <span class="so-text-danger">*</span>
        </label>
        <input
            type="text"
            id="username"
            name="username"
            class="so-form-control"
            placeholder="Enter your username"
            required
        >
    </div>
    <button type="submit" class="so-btn so-btn-primary">
        Submit
    </button>
</form>
HTML;

        // Tab content
        $phpContent = $phpForm . '<div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';
        $phpConfigContent = $phpConfigForm . '<div class="so-mt-4">' . so_code_block($phpConfigCode, 'php') . '</div>';
        $jsContent = '<div id="js-basic-container"></div><div class="so-mt-4">' . so_code_block($jsCode, 'javascript') . '</div>';
        $jsConfigContent = '<div id="js-config-basic-container"></div><div class="so-mt-4">' . so_code_block($jsConfigCode, 'javascript') . '</div>';
        $htmlContent = so_code_block($htmlOutput, 'html');

        echo so_tabs('basic-form', [
            ['id' => 'php-basic', 'label' => 'PHP', 'icon' => 'data_object', 'active' => true, 'content' => $phpContent],
            ['id' => 'php-config-basic', 'label' => 'PHP Config', 'icon' => 'settings', 'active' => false, 'content' => $phpConfigContent],
            ['id' => 'js-basic', 'label' => 'JavaScript', 'icon' => 'javascript', 'active' => false, 'content' => $jsContent],
            ['id' => 'js-config-basic', 'label' => 'JS Config', 'icon' => 'settings', 'active' => false, 'content' => $jsConfigContent],
            ['id' => 'html-basic', 'label' => 'HTML Output', 'icon' => 'code', 'active' => false, 'content' => $htmlContent]
        ]);
        ?>
        <script>
            window.formDemos = window.formDemos || {};

            // JS Basic Form
            window.formDemos['js-basic-container'] = (UiEngine) => {
                const form = UiEngine.form()
                    .action('/submit')
                    .method('POST')
                    .add(
                        UiEngine.input()
                        .inputType('text')
                        .name('username')
                        .label('Username')
                        .placeholder('Enter your username')
                        .required()
                    )
                    .add(
                        UiEngine.button()
                        .buttonType('submit')
                        .text('Submit')
                        .variant('primary')
                    );

                return [form.render()];
            };

            // JS Config Basic Form
            window.formDemos['js-config-basic-container'] = function(UiEngine) {
                const config = {
                    type: 'form',
                    action: '/submit',
                    method: 'POST',
                    children: [{
                            type: 'input',
                            inputType: 'text',
                            name: 'username',
                            label: 'Username',
                            placeholder: 'Enter your username',
                            required: true
                        },
                        {
                            type: 'button',
                            buttonType: 'submit',
                            text: 'Submit',
                            variant: 'primary'
                        }
                    ]
                };

                return [UiEngine.fromConfig(config).render()];
            };
        </script>
    </div>
</div>

<!-- 2. Size Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">2. Size Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Input elements support three size variants: small (sm), medium (md - default), and large (lg).</p>
        <?php
        // PHP Fluent API - Size variants
        $phpSizes = UiEngine::form()
            ->add(UiEngine::input()->name('small')->label('Small Input')->size('sm')->placeholder('Small input'))
            ->add(UiEngine::input()->name('medium')->label('Medium Input')->size('md')->placeholder('Medium input (default)'))
            ->add(UiEngine::input()->name('large')->label('Large Input')->size('lg')->placeholder('Large input'))
            ->render();

        // PHP Config
        $phpConfigSizes = UiEngine::fromConfig([
            'type' => 'form',
            'children' => [
                ['type' => 'input', 'name' => 'small', 'label' => 'Small Input', 'size' => 'sm', 'placeholder' => 'Small input'],
                ['type' => 'input', 'name' => 'medium', 'label' => 'Medium Input', 'size' => 'md', 'placeholder' => 'Medium input (default)'],
                ['type' => 'input', 'name' => 'large', 'label' => 'Large Input', 'size' => 'lg', 'placeholder' => 'Large input']
            ]
        ])->render();

        $phpCode = <<<'PHP'
UiEngine::form()
    ->add(UiEngine::input()->name('small')->label('Small Input')->size('sm'))
    ->add(UiEngine::input()->name('medium')->label('Medium Input')->size('md'))
    ->add(UiEngine::input()->name('large')->label('Large Input')->size('lg'))
PHP;

        $phpConfigCode = <<<'PHP'
UiEngine::fromConfig([
    'type' => 'form',
    'children' => [
        ['type' => 'input', 'name' => 'small', 'size' => 'sm', 'label' => 'Small'],
        ['type' => 'input', 'name' => 'medium', 'size' => 'md', 'label' => 'Medium'],
        ['type' => 'input', 'name' => 'large', 'size' => 'lg', 'label' => 'Large']
    ]
])
PHP;

        $jsCode = <<<'JS'
UiEngine.form()
    .add(UiEngine.input().name('small').label('Small Input').size('sm'))
    .add(UiEngine.input().name('medium').label('Medium Input').size('md'))
    .add(UiEngine.input().name('large').label('Large Input').size('lg'))
JS;

        $jsConfigCode = <<<'JS'
UiEngine.fromConfig({
    type: 'form',
    children: [
        {type: 'input', name: 'small', size: 'sm', label: 'Small'},
        {type: 'input', name: 'medium', size: 'md', label: 'Medium'},
        {type: 'input', name: 'large', size: 'lg', label: 'Large'}
    ]
})
JS;

        // HTML Output
        $htmlOutput = <<<'HTML'
<form action="/submit" method="POST" class="so-form">
    <div class="so-form-group">
        <label for="small" class="so-form-label">Small Input</label>
        <input id="small" class="so-form-control so-form-control-sm" name="small" placeholder="Small input" type="text">
    </div>
    <div class="so-form-group">
        <label for="medium" class="so-form-label">Medium Input</label>
        <input id="medium" class="so-form-control" name="medium" placeholder="Medium input (default)" type="text">
    </div>
    <div class="so-form-group">
        <label for="large" class="so-form-label">Large Input</label>
        <input id="large" class="so-form-control so-form-control-lg" name="large" placeholder="Large input" type="text">
    </div>
</form>
HTML;

        $phpContent = $phpSizes . '<div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';
        $phpConfigContent = $phpConfigSizes . '<div class="so-mt-4">' . so_code_block($phpConfigCode, 'php') . '</div>';
        $jsContent = '<div id="js-sizes-container"></div><div class="so-mt-4">' . so_code_block($jsCode, 'javascript') . '</div>';
        $jsConfigContent = '<div id="js-config-sizes-container"></div><div class="so-mt-4">' . so_code_block($jsConfigCode, 'javascript') . '</div>';
        $htmlContent = so_code_block($htmlOutput, 'html');

        echo so_tabs('sizes', [
            ['id' => 'php-sizes', 'label' => 'PHP', 'icon' => 'data_object', 'active' => true, 'content' => $phpContent],
            ['id' => 'php-config-sizes', 'label' => 'PHP Config', 'icon' => 'settings', 'active' => false, 'content' => $phpConfigContent],
            ['id' => 'js-sizes', 'label' => 'JavaScript', 'icon' => 'javascript', 'active' => false, 'content' => $jsContent],
            ['id' => 'js-config-sizes', 'label' => 'JS Config', 'icon' => 'settings', 'active' => false, 'content' => $jsConfigContent],
            ['id' => 'html-sizes', 'label' => 'HTML Output', 'icon' => 'code', 'active' => false, 'content' => $htmlContent]
        ]);
        ?>
        <script>
            window.formDemos['js-sizes-container'] = (UiEngine) => {
                return [UiEngine.form()
                    .add(UiEngine.input().name('small').label('Small Input').size('sm').placeholder('Small input'))
                    .add(UiEngine.input().name('medium').label('Medium Input').size('md').placeholder('Medium input (default)'))
                    .add(UiEngine.input().name('large').label('Large Input').size('lg').placeholder('Large input'))
                    .render()
                ];
            };

            window.formDemos['js-config-sizes-container'] = (UiEngine) => {
                return [UiEngine.fromConfig({
                    type: 'form',
                    children: [{
                            type: 'input',
                            name: 'small',
                            label: 'Small Input',
                            size: 'sm',
                            placeholder: 'Small input'
                        },
                        {
                            type: 'input',
                            name: 'medium',
                            label: 'Medium Input',
                            size: 'md',
                            placeholder: 'Medium input (default)'
                        },
                        {
                            type: 'input',
                            name: 'large',
                            label: 'Large Input',
                            size: 'lg',
                            placeholder: 'Large input'
                        }
                    ]
                }).render()];
            };
        </script>
    </div>
</div>

<!-- 3. Color Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">3. Color Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Input elements support contextual color variants for different states and purposes.</p>
        <?php
        // PHP Fluent API - Color variants
        $phpVariants = UiEngine::form()
            ->add(UiEngine::input()->name('primary')->label('Primary')->variant('primary')->placeholder('Primary variant'))
            ->add(UiEngine::input()->name('success')->label('Success')->variant('success')->placeholder('Success variant'))
            ->add(UiEngine::input()->name('danger')->label('Danger')->variant('danger')->placeholder('Danger variant'))
            ->add(UiEngine::input()->name('warning')->label('Warning')->variant('warning')->placeholder('Warning variant'))
            ->render();

        // PHP Config
        $phpConfigVariants = UiEngine::fromConfig([
            'type' => 'form',
            'children' => [
                ['type' => 'input', 'name' => 'primary', 'label' => 'Primary', 'variant' => 'primary', 'placeholder' => 'Primary variant'],
                ['type' => 'input', 'name' => 'success', 'label' => 'Success', 'variant' => 'success', 'placeholder' => 'Success variant'],
                ['type' => 'input', 'name' => 'danger', 'label' => 'Danger', 'variant' => 'danger', 'placeholder' => 'Danger variant'],
                ['type' => 'input', 'name' => 'warning', 'label' => 'Warning', 'variant' => 'warning', 'placeholder' => 'Warning variant']
            ]
        ])->render();

        $phpCode = <<<'PHP'
UiEngine::form()
    ->add(UiEngine::input()->variant('primary')->label('Primary'))
    ->add(UiEngine::input()->variant('success')->label('Success'))
    ->add(UiEngine::input()->variant('danger')->label('Danger'))
    ->add(UiEngine::input()->variant('warning')->label('Warning'))
PHP;

        $phpConfigCode = <<<'PHP'
UiEngine::fromConfig([
    'type' => 'form',
    'children' => [
        ['type' => 'input', 'variant' => 'primary', 'label' => 'Primary'],
        ['type' => 'input', 'variant' => 'success', 'label' => 'Success'],
        ['type' => 'input', 'variant' => 'danger', 'label' => 'Danger'],
        ['type' => 'input', 'variant' => 'warning', 'label' => 'Warning']
    ]
])
PHP;

        $jsCode = <<<'JS'
UiEngine.form()
    .add(UiEngine.input().variant('primary').label('Primary'))
    .add(UiEngine.input().variant('success').label('Success'))
    .add(UiEngine.input().variant('danger').label('Danger'))
    .add(UiEngine.input().variant('warning').label('Warning'))
JS;

        $jsConfigCode = <<<'JS'
UiEngine.fromConfig({
    type: 'form',
    children: [
        {type: 'input', variant: 'primary', label: 'Primary'},
        {type: 'input', variant: 'success', label: 'Success'},
        {type: 'input', variant: 'danger', label: 'Danger'},
        {type: 'input', variant: 'warning', label: 'Warning'}
    ]
})
JS;

        // HTML Output
        $htmlOutput = <<<'HTML'
<form action="/submit" method="POST" class="so-form">
    <div class="so-form-group">
        <label for="primary" class="so-form-label">Primary</label>
        <input id="primary" class="so-form-control so-form-control-primary" name="primary" placeholder="Primary variant" type="text">
    </div>
    <div class="so-form-group">
        <label for="success" class="so-form-label">Success</label>
        <input id="success" class="so-form-control so-form-control-success" name="success" placeholder="Success variant" type="text">
    </div>
    <div class="so-form-group">
        <label for="danger" class="so-form-label">Danger</label>
        <input id="danger" class="so-form-control so-form-control-danger" name="danger" placeholder="Danger variant" type="text">
    </div>
    <div class="so-form-group">
        <label for="warning" class="so-form-label">Warning</label>
        <input id="warning" class="so-form-control so-form-control-warning" name="warning" placeholder="Warning variant" type="text">
    </div>
</form>
HTML;

        $phpContent = $phpVariants . '<div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';
        $phpConfigContent = $phpConfigVariants . '<div class="so-mt-4">' . so_code_block($phpConfigCode, 'php') . '</div>';
        $jsContent = '<div id="js-variants-container"></div><div class="so-mt-4">' . so_code_block($jsCode, 'javascript') . '</div>';
        $jsConfigContent = '<div id="js-config-variants-container"></div><div class="so-mt-4">' . so_code_block($jsConfigCode, 'javascript') . '</div>';
        $htmlContent = so_code_block($htmlOutput, 'html');

        echo so_tabs('variants', [
            ['id' => 'php-variants', 'label' => 'PHP', 'icon' => 'data_object', 'active' => true, 'content' => $phpContent],
            ['id' => 'php-config-variants', 'label' => 'PHP Config', 'icon' => 'settings', 'active' => false, 'content' => $phpConfigContent],
            ['id' => 'js-variants', 'label' => 'JavaScript', 'icon' => 'javascript', 'active' => false, 'content' => $jsContent],
            ['id' => 'js-config-variants', 'label' => 'JS Config', 'icon' => 'settings', 'active' => false, 'content' => $jsConfigContent],
            ['id' => 'html-variants', 'label' => 'HTML Output', 'icon' => 'code', 'active' => false, 'content' => $htmlContent]
        ]);
        ?>
        <script>
            window.formDemos['js-variants-container'] = (UiEngine) => {
                return [UiEngine.form()
                    .add(UiEngine.input().name('primary').label('Primary').variant('primary').placeholder('Primary variant'))
                    .add(UiEngine.input().name('success').label('Success').variant('success').placeholder('Success variant'))
                    .add(UiEngine.input().name('danger').label('Danger').variant('danger').placeholder('Danger variant'))
                    .add(UiEngine.input().name('warning').label('Warning').variant('warning').placeholder('Warning variant'))
                    .render()
                ];
            };

            window.formDemos['js-config-variants-container'] = (UiEngine) => {
                return [UiEngine.fromConfig({
                    type: 'form',
                    children: [{
                            type: 'input',
                            name: 'primary',
                            label: 'Primary',
                            variant: 'primary',
                            placeholder: 'Primary variant'
                        },
                        {
                            type: 'input',
                            name: 'success',
                            label: 'Success',
                            variant: 'success',
                            placeholder: 'Success variant'
                        },
                        {
                            type: 'input',
                            name: 'danger',
                            label: 'Danger',
                            variant: 'danger',
                            placeholder: 'Danger variant'
                        },
                        {
                            type: 'input',
                            name: 'warning',
                            label: 'Warning',
                            variant: 'warning',
                            placeholder: 'Warning variant'
                        }
                    ]
                }).render()];
            };
        </script>
    </div>
</div>

<!-- 4. Icon Support -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">4. Icon Support</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Add Material Icons as prefix, suffix, or clickable action buttons to enhance input functionality.</p>
        <?php
        // PHP Fluent API - Icons
        $phpIcons = UiEngine::form()
            ->add(UiEngine::input()->name('search')->label('Search')->prefixIcon('search')->placeholder('Search...'))
            ->add(UiEngine::input()->name('email')->label('Email')->prefixIcon('email')->suffixIcon('check_circle')->placeholder('your@email.com'))
            ->add(UiEngine::input()->name('website')->label('Website')->prefixIcon('link')->suffixIcon('open_in_new')->placeholder('https://example.com'))
            ->add(UiEngine::input()->inputType('password')->name('password')->label('Password')->prefixIcon('lock')->suffixAction('visibility', 'togglePassword(this)'))
            ->render();

        // PHP Config
        $phpConfigIcons = UiEngine::fromConfig([
            'type' => 'form',
            'children' => [
                ['type' => 'input', 'name' => 'search', 'label' => 'Search', 'prefixIcon' => 'search', 'placeholder' => 'Search...'],
                ['type' => 'input', 'name' => 'email', 'label' => 'Email', 'prefixIcon' => 'email', 'suffixIcon' => 'check_circle', 'placeholder' => 'your@email.com'],
                ['type' => 'input', 'name' => 'website', 'label' => 'Website', 'prefixIcon' => 'link', 'suffixIcon' => 'open_in_new', 'placeholder' => 'https://example.com'],
                ['type' => 'input', 'inputType' => 'password', 'name' => 'password', 'label' => 'Password', 'prefixIcon' => 'lock', 'suffixAction' => ['icon' => 'visibility', 'action' => 'togglePassword(this)']]
            ]
        ])->render();

        $phpCode = <<<'PHP'
UiEngine::form()
    // Prefix icon only
    ->add(UiEngine::input()->prefixIcon('search')->placeholder('Search...'))
    // Two icons: prefix + suffix
    ->add(UiEngine::input()->prefixIcon('email')->suffixIcon('check_circle'))
    ->add(UiEngine::input()->prefixIcon('link')->suffixIcon('open_in_new'))
    // Prefix icon + action button
    ->add(UiEngine::input()
        ->inputType('password')
        ->prefixIcon('lock')
        ->suffixAction('visibility', 'togglePassword(this)'))
PHP;

        $phpConfigCode = <<<'PHP'
UiEngine::fromConfig([
    'type' => 'form',
    'children' => [
        // Prefix icon only
        ['type' => 'input', 'prefixIcon' => 'search'],
        // Two icons: prefix + suffix
        ['type' => 'input', 'prefixIcon' => 'email', 'suffixIcon' => 'check_circle'],
        ['type' => 'input', 'prefixIcon' => 'link', 'suffixIcon' => 'open_in_new'],
        // Prefix icon + action button
        ['type' => 'input', 'inputType' => 'password', 'prefixIcon' => 'lock',
         'suffixAction' => ['icon' => 'visibility', 'action' => 'togglePassword(this)']]
    ]
])
PHP;

        $jsCode = <<<'JS'
UiEngine.form()
    // Prefix icon only
    .add(UiEngine.input().prefixIcon('search').placeholder('Search...'))
    // Two icons: prefix + suffix
    .add(UiEngine.input().prefixIcon('email').suffixIcon('check_circle'))
    .add(UiEngine.input().prefixIcon('link').suffixIcon('open_in_new'))
    // Prefix icon + action button
    .add(UiEngine.input()
        .inputType('password')
        .prefixIcon('lock')
        .suffixAction('visibility', 'togglePassword(this)'))
JS;

        $jsConfigCode = <<<'JS'
UiEngine.fromConfig({
    type: 'form',
    children: [
        // Prefix icon only
        {type: 'input', prefixIcon: 'search'},
        // Two icons: prefix + suffix
        {type: 'input', prefixIcon: 'email', suffixIcon: 'check_circle'},
        {type: 'input', prefixIcon: 'link', suffixIcon: 'open_in_new'},
        // Prefix icon + action button
        {type: 'input', inputType: 'password', prefixIcon: 'lock',
         suffixAction: {icon: 'visibility', action: 'togglePassword(this)'}}
    ]
})
JS;

        // HTML Output
        $htmlOutput = <<<'HTML'
<form action="/submit" method="POST" class="so-form">
    <!-- Prefix icon only -->
    <div class="so-form-group">
        <label for="search" class="so-form-label">Search</label>
        <div class="so-input-wrapper">
            <span class="so-input-icon"><span class="material-icons">search</span></span>
            <input id="search" class="so-form-control" name="search" placeholder="Search..." type="text">
        </div>
    </div>

    <!-- Two icons: prefix + suffix -->
    <div class="so-form-group">
        <label for="email" class="so-form-label">Email</label>
        <div class="so-input-wrapper">
            <span class="so-input-icon"><span class="material-icons">email</span></span>
            <input id="email" class="so-form-control" name="email" placeholder="your@email.com" type="text">
            <span class="so-input-icon"><span class="material-icons">check_circle</span></span>
        </div>
    </div>

    <div class="so-form-group">
        <label for="website" class="so-form-label">Website</label>
        <div class="so-input-wrapper">
            <span class="so-input-icon"><span class="material-icons">link</span></span>
            <input id="website" class="so-form-control" name="website" placeholder="https://example.com" type="text">
            <span class="so-input-icon"><span class="material-icons">open_in_new</span></span>
        </div>
    </div>

    <!-- Prefix icon + action button -->
    <div class="so-form-group">
        <label for="password" class="so-form-label">Password</label>
        <div class="so-input-wrapper">
            <span class="so-input-icon"><span class="material-icons">lock</span></span>
            <input id="password" class="so-form-control" name="password" type="password">
            <button type="button" class="so-input-action" onclick="togglePassword(this)" aria-label="Action">
                <span class="material-icons">visibility</span>
            </button>
        </div>
    </div>
</form>
HTML;

        $phpContent = $phpIcons . '<div class="so-mt-4">' . so_code_block($phpCode, 'php') . '</div>';
        $phpConfigContent = $phpConfigIcons . '<div class="so-mt-4">' . so_code_block($phpConfigCode, 'php') . '</div>';
        $jsContent = '<div id="js-icons-container"></div><div class="so-mt-4">' . so_code_block($jsCode, 'javascript') . '</div>';
        $jsConfigContent = '<div id="js-config-icons-container"></div><div class="so-mt-4">' . so_code_block($jsConfigCode, 'javascript') . '</div>';
        $htmlContent = so_code_block($htmlOutput, 'html');

        echo so_tabs('icons', [
            ['id' => 'php-icons', 'label' => 'PHP', 'icon' => 'data_object', 'active' => true, 'content' => $phpContent],
            ['id' => 'php-config-icons', 'label' => 'PHP Config', 'icon' => 'settings', 'active' => false, 'content' => $phpConfigContent],
            ['id' => 'js-icons', 'label' => 'JavaScript', 'icon' => 'javascript', 'active' => false, 'content' => $jsContent],
            ['id' => 'js-config-icons', 'label' => 'JS Config', 'icon' => 'settings', 'active' => false, 'content' => $jsConfigContent],
            ['id' => 'html-icons', 'label' => 'HTML Output', 'icon' => 'code', 'active' => false, 'content' => $htmlContent]
        ]);
        ?>
        <script>
            window.formDemos['js-icons-container'] = (UiEngine) => {
                return [UiEngine.form()
                    .add(UiEngine.input().name('search').label('Search').prefixIcon('search').placeholder('Search...'))
                    .add(UiEngine.input().name('email').label('Email').prefixIcon('email').suffixIcon('check_circle').placeholder('your@email.com'))
                    .add(UiEngine.input().name('website').label('Website').prefixIcon('link').suffixIcon('open_in_new').placeholder('https://example.com'))
                    .add(UiEngine.input().inputType('password').name('password').label('Password').prefixIcon('lock').suffixAction('visibility', 'togglePassword(this)'))
                    .render()
                ];
            };

            window.formDemos['js-config-icons-container'] = (UiEngine) => {
                return [UiEngine.fromConfig({
                    type: 'form',
                    children: [{
                            type: 'input',
                            name: 'search',
                            label: 'Search',
                            prefixIcon: 'search',
                            placeholder: 'Search...'
                        },
                        {
                            type: 'input',
                            name: 'email',
                            label: 'Email',
                            prefixIcon: 'email',
                            suffixIcon: 'check_circle',
                            placeholder: 'your@email.com'
                        },
                        {
                            type: 'input',
                            name: 'website',
                            label: 'Website',
                            prefixIcon: 'link',
                            suffixIcon: 'open_in_new',
                            placeholder: 'https://example.com'
                        },
                        {
                            type: 'input',
                            inputType: 'password',
                            name: 'password',
                            label: 'Password',
                            prefixIcon: 'lock',
                            suffixAction: {
                                icon: 'visibility',
                                action: 'togglePassword(this)'
                            }
                        }
                    ]
                }).render()];
            };
        </script>
    </div>
</div>

<?php require_once '../includes/layout-end.php'; ?>