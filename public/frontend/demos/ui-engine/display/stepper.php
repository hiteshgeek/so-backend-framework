<?php
/**
 * SixOrbit UI Engine - Stepper Element Demo
 */

$pageTitle = 'Stepper - UI Engine';
$pageDescription = 'Multi-step progress indicator';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Stepper</h1>
            <p class="so-page-subtitle">Multi-step progress indicator for wizards and multi-page forms.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Horizontal Stepper -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Horizontal Stepper</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-stepper so-stepper-horizontal so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Account</div>
                            <div class="so-step-subtitle">Create your account</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Profile</div>
                            <div class="so-step-subtitle">Complete your profile</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Payment</div>
                            <div class="so-step-subtitle">Add payment method</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">4</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Confirm</div>
                            <div class="so-step-subtitle">Review and confirm</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-stepper', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$stepper = UiEngine::stepper()
    ->horizontal()
    ->step('Account', 'Create your account')
    ->step('Profile', 'Complete your profile')
    ->step('Payment', 'Add payment method')
    ->step('Confirm', 'Review and confirm')
    ->current(2);  // Current step (0-indexed)

echo \$stepper->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const stepper = UiEngine.stepper()
    .horizontal()
    .step('Account', 'Create your account')
    .step('Profile', 'Complete your profile')
    .step('Payment', 'Add payment method')
    .step('Confirm', 'Review and confirm')
    .current(2);

document.getElementById('container').innerHTML = stepper.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-stepper so-stepper-horizontal">
    <div class="so-step so-step-completed">
        <div class="so-step-icon">
            <span class="material-icons">check</span>
        </div>
        <div class="so-step-content">
            <div class="so-step-title">Account</div>
            <div class="so-step-subtitle">Create your account</div>
        </div>
        <div class="so-step-connector"></div>
    </div>
    <div class="so-step so-step-active">
        <div class="so-step-icon">2</div>
        <div class="so-step-content">
            <div class="so-step-title">Profile</div>
            <div class="so-step-subtitle">Complete your profile</div>
        </div>
        <div class="so-step-connector"></div>
    </div>
    <!-- More steps... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Stepper with Icons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-stepper so-stepper-horizontal so-stepper-icons so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">shopping_cart</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Cart</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">local_shipping</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Shipping</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">
                            <span class="material-icons">payment</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Payment</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">
                            <span class="material-icons">verified</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Done</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('stepper-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$stepper = UiEngine::stepper()
    ->horizontal()
    ->icons()
    ->step('Cart', null, 'shopping_cart')
    ->step('Shipping', null, 'local_shipping')
    ->step('Payment', null, 'payment')
    ->step('Done', null, 'verified')
    ->current(2);

echo \$stepper->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const stepper = UiEngine.stepper()
    .horizontal()
    .icons()
    .step('Cart', null, 'shopping_cart')
    .step('Shipping', null, 'local_shipping')
    .step('Payment', null, 'payment')
    .step('Done', null, 'verified')
    .current(2);

document.getElementById('container').innerHTML = stepper.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-stepper so-stepper-horizontal so-stepper-icons">
    <div class="so-step so-step-completed">
        <div class="so-step-icon">
            <span class="material-icons">shopping_cart</span>
        </div>
        <div class="so-step-content">
            <div class="so-step-title">Cart</div>
        </div>
        <div class="so-step-connector"></div>
    </div>
    <div class="so-step so-step-active">
        <div class="so-step-icon">
            <span class="material-icons">payment</span>
        </div>
        <div class="so-step-content">
            <div class="so-step-title">Payment</div>
        </div>
        <div class="so-step-connector"></div>
    </div>
    <!-- More steps... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Vertical Stepper -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Vertical Stepper</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-stepper so-stepper-vertical so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-connector"></div>
                        <div class="so-step-content">
                            <div class="so-step-title">Personal Info</div>
                            <div class="so-step-subtitle">Enter your name and email</div>
                            <div class="so-step-body">
                                <p class="so-text-muted">Your information has been saved.</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">2</div>
                        <div class="so-step-connector"></div>
                        <div class="so-step-content">
                            <div class="so-step-title">Address</div>
                            <div class="so-step-subtitle">Provide your shipping address</div>
                            <div class="so-step-body">
                                <div class="so-form-group">
                                    <label class="so-form-label">Street Address</label>
                                    <input type="text" class="so-form-control" placeholder="Enter address">
                                </div>
                                <div class="so-d-flex so-gap-2 so-mt-3">
                                    <button class="so-btn so-btn-primary so-btn-sm">Continue</button>
                                    <button class="so-btn so-btn-outline so-btn-sm">Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Payment</div>
                            <div class="so-step-subtitle">Choose payment method</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('stepper-vertical', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$stepper = UiEngine::stepper()
    ->vertical()
    ->step('Personal Info', 'Enter your name and email', null, 'Your info has been saved.')
    ->step('Address', 'Provide your shipping address', null, UiEngine::form()...)
    ->step('Payment', 'Choose payment method')
    ->current(1);

echo \$stepper->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const stepper = UiEngine.stepper()
    .vertical()
    .step('Personal Info', 'Enter your name and email')
    .step('Address', 'Provide your shipping address')
    .step('Payment', 'Choose payment method')
    .current(1);

document.getElementById('container').innerHTML = stepper.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-stepper so-stepper-vertical">
    <div class="so-step so-step-completed">
        <div class="so-step-icon">
            <span class="material-icons">check</span>
        </div>
        <div class="so-step-connector"></div>
        <div class="so-step-content">
            <div class="so-step-title">Personal Info</div>
            <div class="so-step-subtitle">Enter your name and email</div>
            <div class="so-step-body">
                <!-- Step content here -->
            </div>
        </div>
    </div>
    <div class="so-step so-step-active">
        <div class="so-step-icon">2</div>
        <div class="so-step-connector"></div>
        <div class="so-step-content">...</div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Step States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Step States</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-stepper so-stepper-horizontal so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Completed</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">2</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Active</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Pending</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-error">
                        <div class="so-step-icon">
                            <span class="material-icons">priority_high</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Error</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-disabled">
                        <div class="so-step-icon">5</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Disabled</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('stepper-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Step states are applied based on current position
// or can be set manually per step

\$stepper = UiEngine::stepper()
    ->horizontal()
    ->step('Completed')->state('completed')
    ->step('Active')->state('active')
    ->step('Pending')  // Default state
    ->step('Error')->state('error')
    ->step('Disabled')->state('disabled');

echo \$stepper->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const stepper = UiEngine.stepper()
    .horizontal()
    .step('Completed').state('completed')
    .step('Active').state('active')
    .step('Pending')
    .step('Error').state('error')
    .step('Disabled').state('disabled');

document.getElementById('container').innerHTML = stepper.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Step state classes -->
<div class="so-step so-step-completed">...</div>
<div class="so-step so-step-active">...</div>
<div class="so-step">...</div>  <!-- Pending (default) -->
<div class="so-step so-step-error">...</div>
<div class="so-step so-step-disabled">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo - Small -->
                <p class="so-text-muted so-small so-mb-2">Small:</p>
                <div class="so-stepper so-stepper-horizontal so-stepper-sm so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon"><span class="material-icons">check</span></div>
                        <div class="so-step-content"><div class="so-step-title">Step 1</div></div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">2</div>
                        <div class="so-step-content"><div class="so-step-title">Step 2</div></div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-content"><div class="so-step-title">Step 3</div></div>
                    </div>
                </div>

                <!-- Live Demo - Large -->
                <p class="so-text-muted so-small so-mb-2">Large:</p>
                <div class="so-stepper so-stepper-horizontal so-stepper-lg so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon"><span class="material-icons">check</span></div>
                        <div class="so-step-content"><div class="so-step-title">Step 1</div></div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">2</div>
                        <div class="so-step-content"><div class="so-step-title">Step 2</div></div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-content"><div class="so-step-title">Step 3</div></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('stepper-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small stepper
UiEngine::stepper()->horizontal()->size('sm');

// Default size
UiEngine::stepper()->horizontal();

// Large stepper
UiEngine::stepper()->horizontal()->size('lg');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small stepper
UiEngine.stepper().horizontal().size('sm').toHtml();

// Large stepper
UiEngine.stepper().horizontal().size('lg').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small stepper -->
<div class="so-stepper so-stepper-horizontal so-stepper-sm">...</div>

<!-- Large stepper -->
<div class="so-stepper so-stepper-horizontal so-stepper-lg">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Color Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo - Success -->
                <p class="so-text-muted so-small so-mb-2">Success:</p>
                <div class="so-stepper so-stepper-horizontal so-stepper-success so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon"><span class="material-icons">check</span></div>
                        <div class="so-step-content"><div class="so-step-title">Step 1</div></div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">2</div>
                        <div class="so-step-content"><div class="so-step-title">Step 2</div></div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-content"><div class="so-step-title">Step 3</div></div>
                    </div>
                </div>

                <!-- Live Demo - Warning Outline -->
                <p class="so-text-muted so-small so-mb-2">Warning (Outline):</p>
                <div class="so-stepper so-stepper-horizontal so-stepper-warning so-stepper-outline so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon"><span class="material-icons">check</span></div>
                        <div class="so-step-content"><div class="so-step-title">Step 1</div></div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">2</div>
                        <div class="so-step-content"><div class="so-step-title">Step 2</div></div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-content"><div class="so-step-title">Step 3</div></div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('stepper-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Color variants
UiEngine::stepper()->variant('primary');
UiEngine::stepper()->variant('success');
UiEngine::stepper()->variant('warning');
UiEngine::stepper()->variant('danger');
UiEngine::stepper()->variant('info');

// Combined with outline
UiEngine::stepper()->variant('warning')->outline();

// Combined with light (soft background)
UiEngine::stepper()->variant('danger')->light();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Color variants
UiEngine.stepper().variant('success').toHtml();
UiEngine.stepper().variant('warning').outline().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Color variants -->
<div class="so-stepper so-stepper-horizontal so-stepper-primary">...</div>
<div class="so-stepper so-stepper-horizontal so-stepper-success">...</div>
<div class="so-stepper so-stepper-horizontal so-stepper-warning">...</div>

<!-- Combined with outline/light -->
<div class="so-stepper so-stepper-horizontal so-stepper-info so-stepper-outline">...</div>
<div class="so-stepper so-stepper-horizontal so-stepper-danger so-stepper-light">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Progress Stepper (Compact) -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Compact Stepper</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">A minimal stepper showing only icons, useful for progress tracking.</p>

                <!-- Live Demo -->
                <div class="so-stepper so-stepper-horizontal so-stepper-compact so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">4</div>
                    </div>
                </div>

                <!-- With thicker progress line -->
                <p class="so-text-muted so-small so-mb-2">With progress connector (thicker line):</p>
                <div class="so-stepper so-stepper-horizontal so-stepper-progress so-mb-4">
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Placed</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-completed">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Processing</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active">
                        <div class="so-step-icon">
                            <span class="material-icons">local_shipping</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Shipped</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step">
                        <div class="so-step-icon">
                            <span class="material-icons">home</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Delivered</div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('stepper-compact', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Compact stepper (icons only, no text)
UiEngine::stepper()
    ->horizontal()
    ->compact()
    ->step(null, null, 'check')
    ->step(null, null, 'check')
    ->step(null, null, '3')
    ->step(null, null, '4')
    ->current(2);

// Progress stepper (thicker connector line)
UiEngine::stepper()
    ->horizontal()
    ->progress()
    ->step('Placed', null, 'check')
    ->step('Processing', null, 'check')
    ->step('Shipped', null, 'local_shipping')
    ->step('Delivered', null, 'home')
    ->current(2);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Compact stepper
UiEngine.stepper()
    .horizontal()
    .compact()
    .current(2)
    .toHtml();

// Progress stepper
UiEngine.stepper()
    .horizontal()
    .progress()
    .step('Placed')
    .step('Processing')
    .step('Shipped')
    .step('Delivered')
    .current(2)
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Compact stepper (icons only) -->
<div class="so-stepper so-stepper-horizontal so-stepper-compact">
    <div class="so-step so-step-completed">
        <div class="so-step-icon"><span class="material-icons">check</span></div>
        <div class="so-step-connector"></div>
    </div>
    <div class="so-step so-step-active">
        <div class="so-step-icon">2</div>
        <div class="so-step-connector"></div>
    </div>
    <!-- More steps... -->
</div>

<!-- Progress stepper (thicker connector) -->
<div class="so-stepper so-stepper-horizontal so-stepper-progress">
    <div class="so-step so-step-completed">
        <div class="so-step-icon"><span class="material-icons">check</span></div>
        <div class="so-step-content"><div class="so-step-title">Placed</div></div>
        <div class="so-step-connector"></div>
    </div>
    <!-- More steps... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Interactive Stepper -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Interactive Stepper</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Allow users to navigate between steps by clicking on them.</p>

                <!-- Live Demo -->
                <div class="so-stepper so-stepper-horizontal so-stepper-clickable so-mb-4" id="interactive-stepper-demo">
                    <div class="so-step so-step-completed" data-step="0">
                        <div class="so-step-icon">
                            <span class="material-icons">check</span>
                        </div>
                        <div class="so-step-content">
                            <div class="so-step-title">Cart</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step so-step-active" data-step="1">
                        <div class="so-step-icon">2</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Shipping</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step" data-step="2">
                        <div class="so-step-icon">3</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Payment</div>
                        </div>
                        <div class="so-step-connector"></div>
                    </div>
                    <div class="so-step" data-step="3">
                        <div class="so-step-icon">4</div>
                        <div class="so-step-content">
                            <div class="so-step-title">Complete</div>
                        </div>
                    </div>
                </div>

                <div class="so-btn-group so-mb-4">
                    <button class="so-btn so-btn-outline so-btn-sm" onclick="stepperPrev()">
                        <span class="material-icons" style="font-size:16px;">chevron_left</span> Previous
                    </button>
                    <button class="so-btn so-btn-primary so-btn-sm" onclick="stepperNext()">
                        Next <span class="material-icons" style="font-size:16px;">chevron_right</span>
                    </button>
                </div>

                <script>
                (function() {
                    const stepper = document.getElementById('interactive-stepper-demo');
                    if (!stepper) return;

                    const items = stepper.querySelectorAll('.so-step');
                    let currentStep = 1;

                    function updateStepper(step) {
                        items.forEach((item, index) => {
                            item.classList.remove('so-step-completed', 'so-step-active');
                            const indicator = item.querySelector('.so-step-icon');

                            if (index < step) {
                                item.classList.add('so-step-completed');
                                indicator.innerHTML = '<span class="material-icons">check</span>';
                            } else if (index === step) {
                                item.classList.add('so-step-active');
                                indicator.innerHTML = (index + 1).toString();
                            } else {
                                indicator.innerHTML = (index + 1).toString();
                            }
                        });
                        currentStep = step;
                    }

                    items.forEach((item, index) => {
                        item.addEventListener('click', () => updateStepper(index));
                    });

                    window.stepperNext = function() {
                        if (currentStep < items.length - 1) updateStepper(currentStep + 1);
                    };

                    window.stepperPrev = function() {
                        if (currentStep > 0) updateStepper(currentStep - 1);
                    };
                })();
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('stepper-interactive', [
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const stepper = UiEngine.stepper('checkout-stepper')
    .horizontal()
    .clickable()
    .step('Cart')
    .step('Shipping')
    .step('Payment')
    .step('Complete')
    .current(0);

// Navigation methods
stepper.next();     // Go to next step
stepper.prev();     // Go to previous step
stepper.goTo(2);    // Go to specific step

// Event listener
stepper.on('change', (step, direction) => {
    console.log('Step changed to', step);
});"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-stepper so-stepper-horizontal so-stepper-clickable" id="checkout-stepper">
    <div class="so-step so-step-completed" data-step="0">
        <div class="so-step-icon">
            <span class="material-icons">check</span>
        </div>
        <div class="so-step-content">
            <div class="so-step-title">Cart</div>
        </div>
        <div class="so-step-connector"></div>
    </div>
    <div class="so-step so-step-active" data-step="1">
        <div class="so-step-icon">2</div>
        <div class="so-step-content">
            <div class="so-step-title">Shipping</div>
        </div>
        <div class="so-step-connector"></div>
    </div>
    <!-- More steps... -->
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
                                <td><code>step()</code></td>
                                <td><code>string $title, string $subtitle, string $icon, mixed $content</code></td>
                                <td>Add a step</td>
                            </tr>
                            <tr>
                                <td><code>current()</code></td>
                                <td><code>int $index</code></td>
                                <td>Set current step (0-indexed)</td>
                            </tr>
                            <tr>
                                <td><code>horizontal()</code></td>
                                <td>-</td>
                                <td>Use horizontal layout (default)</td>
                            </tr>
                            <tr>
                                <td><code>vertical()</code></td>
                                <td>-</td>
                                <td>Use vertical layout</td>
                            </tr>
                            <tr>
                                <td><code>progress()</code></td>
                                <td>-</td>
                                <td>Use minimal progress-style layout</td>
                            </tr>
                            <tr>
                                <td><code>icons()</code></td>
                                <td>-</td>
                                <td>Use custom icons instead of numbers</td>
                            </tr>
                            <tr>
                                <td><code>clickable()</code></td>
                                <td>-</td>
                                <td>Allow clicking on steps to navigate</td>
                            </tr>
                            <tr>
                                <td><code>size()</code></td>
                                <td><code>string $size</code></td>
                                <td>Size variant: sm, lg</td>
                            </tr>
                            <tr>
                                <td><code>variant()</code></td>
                                <td><code>string $color</code></td>
                                <td>Color: primary, success, warning, danger, info</td>
                            </tr>
                            <tr>
                                <td><code>outline()</code></td>
                                <td>-</td>
                                <td>Use outlined step icons</td>
                            </tr>
                            <tr>
                                <td><code>light()</code></td>
                                <td>-</td>
                                <td>Use soft background step icons</td>
                            </tr>
                            <tr>
                                <td><code>next()</code></td>
                                <td>-</td>
                                <td>Go to next step (JS)</td>
                            </tr>
                            <tr>
                                <td><code>prev()</code></td>
                                <td>-</td>
                                <td>Go to previous step (JS)</td>
                            </tr>
                            <tr>
                                <td><code>goTo()</code></td>
                                <td><code>int $step</code></td>
                                <td>Go to specific step (JS)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
