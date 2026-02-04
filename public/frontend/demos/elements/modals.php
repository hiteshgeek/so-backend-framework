<?php
/**
 * SixOrbit UI Demo - Modals
 */
$pageTitle = 'Modals';
$pageDescription = 'Modal dialog components';

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
            <h1 class="so-page-title">Modals</h1>
            <p class="so-page-subtitle">Modal dialog components</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Basic Modal -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Basic Modal</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">A standard modal with header, body, and footer sections.</p>

            <button type="button" class="so-btn so-btn-primary" onclick="document.getElementById('basicModal').classList.add('so-show'); document.querySelector('.so-modal-backdrop')?.classList.add('so-show') || createBackdrop();">
                Launch Basic Modal
            </button>

            <div class="so-mt-4">
                <?= so_code_block('<div class="so-modal" id="myModal">
    <div class="so-modal-dialog">
        <div class="so-modal-header">
            <h5 class="so-modal-title">Modal Title</h5>
            <button class="so-modal-close" data-dismiss="modal">
                <span class="material-icons">close</span>
            </button>
        </div>
        <div class="so-modal-body">
            Modal content goes here...
        </div>
        <div class="so-modal-footer">
            <button class="so-btn so-btn-outline" data-dismiss="modal">Cancel</button>
            <button class="so-btn so-btn-primary">Save Changes</button>
        </div>
    </div>
</div>', 'html') ?>
            </div>
        </div>
    </div>

    <!-- Modal Sizes -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Modal Sizes</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Modals come in different sizes: small (380px), default (500px), large (720px), extra-large (960px), and fullscreen.</p>

            <div class="so-btn-group so-flex-wrap">
                <button type="button" class="so-btn so-btn-outline" onclick="showSizeModal('sm')">Small (380px)</button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSizeModal('default')">Default (500px)</button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSizeModal('lg')">Large (720px)</button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSizeModal('xl')">Extra Large (960px)</button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSizeModal('fullscreen')">Fullscreen</button>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('<!-- Small Modal -->
<div class="so-modal so-modal-sm">...</div>

<!-- Default Modal -->
<div class="so-modal">...</div>

<!-- Large Modal -->
<div class="so-modal so-modal-lg">...</div>

<!-- Extra Large Modal -->
<div class="so-modal so-modal-xl">...</div>

<!-- Fullscreen Modal -->
<div class="so-modal so-modal-fullscreen">...</div>', 'html') ?>
            </div>
        </div>
    </div>

    <!-- Scrollable Modal -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Scrollable Modal</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">When content is longer than the viewport, the modal body becomes scrollable.</p>

            <button type="button" class="so-btn so-btn-primary" onclick="showScrollableModal()">
                Show Scrollable Modal
            </button>

            <div class="so-mt-4">
                <?= so_code_block('<div class="so-modal so-modal-scrollable">
    <div class="so-modal-dialog">
        <div class="so-modal-header">...</div>
        <div class="so-modal-body">
            <!-- Long scrollable content -->
        </div>
        <div class="so-modal-footer">...</div>
    </div>
</div>', 'html') ?>
            </div>
        </div>
    </div>

    <!-- Confirmation Dialogs -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Confirmation Dialogs</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>SOModal.confirm()</code> for confirmation dialogs that return a Promise.</p>

            <h5 class="so-mb-3">Simple Confirm/Cancel</h5>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showConfirmDialog()">
                    Standard Confirm
                </button>
                <button type="button" class="so-btn so-btn-danger" onclick="showDeleteConfirm()">
                    Delete Confirm
                </button>
            </div>

            <h5 class="so-mb-3">Multiple Actions</h5>
            <div class="so-btn-group so-flex-wrap">
                <button type="button" class="so-btn so-btn-secondary" onclick="showMultiActionDialog()">
                    Save Changes Dialog
                </button>
                <button type="button" class="so-btn so-btn-info" onclick="showFileActionDialog()">
                    File Conflict Dialog
                </button>
            </div>

            <div id="confirm-result" class="so-mt-3"></div>

            <div class="so-mt-4">
                <?= so_code_block('// Basic confirmation (returns true/false)
const confirmed = await SOModal.confirm({
    title: \'Confirm Action\',
    message: \'Are you sure you want to proceed?\',
    confirmText: \'Yes, Continue\',
    cancelText: \'Cancel\'
});

if (confirmed) {
    console.log(\'User confirmed\');
} else {
    console.log(\'User cancelled\');
}

// Danger confirmation
const deleted = await SOModal.confirm({
    title: \'Delete Item\',
    message: \'This action cannot be undone.\',
    confirmText: \'Delete\',
    cancelText: \'Cancel\',
    danger: true  // Red confirm button
});

// Multiple actions (returns action id or \'dismiss\')
const action = await SOModal.confirm({
    title: \'Unsaved Changes\',
    message: \'You have unsaved changes. What would you like to do?\',
    actions: [
        { id: \'discard\', text: \'Discard\', class: \'so-btn-outline\' },
        { id: \'save-draft\', text: \'Save Draft\', class: \'so-btn-secondary\' },
        { id: \'save\', text: \'Save & Close\', class: \'so-btn-primary\', primary: true }
    ]
});

switch (action) {
    case \'save\':
        console.log(\'User chose to save\');
        break;
    case \'save-draft\':
        console.log(\'User chose to save as draft\');
        break;
    case \'discard\':
        console.log(\'User chose to discard\');
        break;
    case \'dismiss\':
        console.log(\'User dismissed the dialog\');
        break;
}', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- Centered Confirmation Dialogs -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Centered Confirmation Dialogs</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Enhanced confirmation dialogs with centered icon, title, and customizable button options.</p>

            <h5 class="so-mb-3">Icon Types</h5>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-danger" onclick="showCenteredConfirm('danger')">
                    Danger (Delete)
                </button>
                <button type="button" class="so-btn so-btn-warning" onclick="showCenteredConfirm('warning')">
                    Warning
                </button>
                <button type="button" class="so-btn so-btn-success" onclick="showCenteredConfirm('success')">
                    Success
                </button>
                <button type="button" class="so-btn so-btn-info" onclick="showCenteredConfirm('info')">
                    Info
                </button>
            </div>

            <h5 class="so-mb-3">Button Icon Positions</h5>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-outline" onclick="showIconLeftConfirm()">
                    Icon Left
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showIconRightConfirm()">
                    Icon Right
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showBothIconsConfirm()">
                    Both Buttons with Icons
                </button>
            </div>

            <h5 class="so-mb-3">Button Layouts</h5>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-outline" onclick="showButtonPosition('center')">
                    Center
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showButtonPosition('left')">
                    Left
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showButtonPosition('right')">
                    Right
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showButtonPosition('between')">
                    Space Between
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showStackedButtons()">
                    Stacked (Vertical)
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showReversedButtons()">
                    Reversed Order
                </button>
            </div>

            <h5 class="so-mb-3">With Close Button</h5>
            <div class="so-btn-group so-flex-wrap">
                <button type="button" class="so-btn so-btn-primary" onclick="showWithCloseButton()">
                    Show Close Button (X)
                </button>
            </div>

            <div id="centered-confirm-result" class="so-mt-3"></div>

            <div class="so-mt-4">
                <?= so_code_block('// Flexible button API - icon + text in any order
await SOModal.confirm({
    title: \'Delete Item\',
    message: \'This cannot be undone.\',
    icon: { name: \'delete\', type: \'danger\' },  // Object format
    confirm: [{ icon: \'delete\' }, \'Delete\'],   // Icon then text
    cancel: \'Cancel\',
    danger: true
});

// Icon after text
await SOModal.confirm({
    title: \'Continue?\',
    message: \'Proceed to the next step?\',
    icon: { name: \'arrow_forward\', type: \'info\' },
    confirm: [\'Continue\', { icon: \'arrow_forward\' }],  // Text then icon
    cancel: \'Cancel\'
});

// Multiple icons on button
await SOModal.confirm({
    title: \'Upload & Save\',
    message: \'Ready to upload?\',
    icon: \'cloud_upload\',
    confirm: [{ icon: \'cloud_upload\' }, \'Upload\', { icon: \'check\' }],
    cancel: [{ icon: \'close\' }, \'Cancel\']
});

// With custom class override
await SOModal.confirm({
    title: \'Save Changes?\',
    message: \'Do you want to save?\',
    icon: { name: \'save\', type: \'success\' },
    confirm: {
        content: [{ icon: \'save\' }, \'Save\'],
        class: \'so-btn-success\'
    },
    cancel: \'Discard\',
    buttonPosition: \'between\'
});

// Stacked buttons with full width
await SOModal.confirm({
    title: \'Confirm Action\',
    message: \'Are you sure?\',
    icon: \'help_outline\',
    confirm: [{ icon: \'check\' }, \'Confirm\'],
    cancel: [{ icon: \'close\' }, \'Cancel\'],
    buttonLayout: \'stacked\',
    fullWidthButtons: true
});', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- Alert Modals -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Alert Modals</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Use <code>SOModal.alert()</code> for simple alert dialogs with different types.</p>

            <div class="so-btn-group so-flex-wrap">
                <button type="button" class="so-btn so-btn-info" onclick="SOModal.alert({ title: 'Information', message: 'This is an informational alert.', type: 'info' })">
                    Info Alert
                </button>
                <button type="button" class="so-btn so-btn-success" onclick="SOModal.alert({ title: 'Success!', message: 'Your operation completed successfully.', type: 'success' })">
                    Success Alert
                </button>
                <button type="button" class="so-btn so-btn-warning" onclick="SOModal.alert({ title: 'Warning', message: 'Please review the following issues.', type: 'warning' })">
                    Warning Alert
                </button>
                <button type="button" class="so-btn so-btn-danger" onclick="SOModal.alert({ title: 'Error', message: 'Something went wrong. Please try again.', type: 'danger' })">
                    Error Alert
                </button>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('// Alert returns a Promise that resolves when closed
await SOModal.alert({
    title: \'Success!\',
    message: \'Your file has been uploaded.\',
    type: \'success\', // info, success, warning, danger
    buttonText: \'OK\'
});

console.log(\'Alert was closed\');', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- Contextual Modal Headers -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Contextual Modal Headers</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Modals can have colored headers using contextual classes. Available in solid and light variants for all 8 colors.</p>

            <h5 class="so-mb-3">Solid Headers</h5>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showContextualModal('primary')">Primary</button>
                <button type="button" class="so-btn so-btn-secondary" onclick="showContextualModal('secondary')">Secondary</button>
                <button type="button" class="so-btn so-btn-success" onclick="showContextualModal('success')">Success</button>
                <button type="button" class="so-btn so-btn-danger" onclick="showContextualModal('danger')">Danger</button>
                <button type="button" class="so-btn so-btn-warning" onclick="showContextualModal('warning')">Warning</button>
                <button type="button" class="so-btn so-btn-info" onclick="showContextualModal('info')">Info</button>
                <button type="button" class="so-btn so-btn-light" onclick="showContextualModal('light')">Light</button>
                <button type="button" class="so-btn so-btn-dark" onclick="showContextualModal('dark')">Dark</button>
            </div>

            <h5 class="so-mb-3">Light Headers</h5>
            <div class="so-btn-group so-flex-wrap">
                <button type="button" class="so-btn so-btn-outline so-btn-primary" onclick="showContextualModal('primary-light')">Primary Light</button>
                <button type="button" class="so-btn so-btn-outline so-btn-secondary" onclick="showContextualModal('secondary-light')">Secondary Light</button>
                <button type="button" class="so-btn so-btn-outline so-btn-success" onclick="showContextualModal('success-light')">Success Light</button>
                <button type="button" class="so-btn so-btn-outline so-btn-danger" onclick="showContextualModal('danger-light')">Danger Light</button>
                <button type="button" class="so-btn so-btn-outline so-btn-warning" onclick="showContextualModal('warning-light')">Warning Light</button>
                <button type="button" class="so-btn so-btn-outline so-btn-info" onclick="showContextualModal('info-light')">Info Light</button>
                <button type="button" class="so-btn so-btn-outline" onclick="showContextualModal('dark-light')">Dark Light</button>
            </div>

            <div class="so-mt-4">
                <?= so_code_tabs('contextual-modal', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Solid colored headers -->
<div class="so-modal so-modal-primary">...</div>
<div class="so-modal so-modal-secondary">...</div>
<div class="so-modal so-modal-success">...</div>
<div class="so-modal so-modal-danger">...</div>
<div class="so-modal so-modal-warning">...</div>
<div class="so-modal so-modal-info">...</div>
<div class="so-modal so-modal-light">...</div>
<div class="so-modal so-modal-dark">...</div>

<!-- Light colored headers -->
<div class="so-modal so-modal-primary-light">...</div>
<div class="so-modal so-modal-secondary-light">...</div>
<div class="so-modal so-modal-success-light">...</div>
<div class="so-modal so-modal-danger-light">...</div>
<div class="so-modal so-modal-warning-light">...</div>
<div class="so-modal so-modal-info-light">...</div>
<div class="so-modal so-modal-dark-light">...</div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => '// Create modal with contextual header using className option
const modal = SOModal.create({
    title: \'Success\',
    content: \'<p>Your changes have been saved.</p>\',
    className: \'so-modal-success\', // or \'so-modal-success-light\'
    footer: \'<button class="so-btn so-btn-primary" data-dismiss="modal">OK</button>\'
});
modal.show();'
                    ]
                ]) ?>
            </div>
        </div>
    </div>

    <!-- Programmatic Modal -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Programmatic Modal</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Create modals dynamically using <code>SOModal.create()</code>. Supports flexible footer button configuration.</p>

            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showProgrammaticModal()">
                    Legacy Footer (HTML)
                </button>
                <button type="button" class="so-btn so-btn-secondary" onclick="showFlexibleFooterModal()">
                    Flexible Footer (Array)
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSectionsFooterModal()">
                    Footer Sections (Left/Center/Right)
                </button>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('// Legacy footer (HTML string)
const modal = SOModal.create({
    title: \'Dynamic Modal\',
    content: \'<p>This modal was created with JavaScript.</p>\',
    footer: `
        <button class="so-btn so-btn-outline" data-dismiss="modal">Close</button>
        <button class="so-btn so-btn-primary" data-dismiss="modal">Save</button>
    `
});

// Flexible footer (Array of buttons)
const modal = SOModal.create({
    title: \'Flexible Footer\',
    content: \'<p>Footer buttons using flexible array format.</p>\',
    footer: [
        \'Cancel\',                                    // Simple text
        [{ icon: \'close\' }, \'Discard\'],            // Array with icon
        { content: [{ icon: \'save\' }, \'Save\'], class: \'so-btn-primary\' }
    ],
    footerPosition: \'right\'  // left, center, right, between, around
});

// With onclick handlers
SOModal.create({
    title: \'With Handlers\',
    content: \'<p>Buttons with click handlers.</p>\',
    footer: [
        { content: \'Cancel\', dismiss: true },
        {
            content: [{ icon: \'check\' }, \'Confirm\'],
            class: \'so-btn-success\',
            dismiss: false,  // Don\'t auto-close
            onclick: (e, btn) => {
                console.log(\'Confirmed!\');
                SOModal.getInstance(btn.closest(\'.so-modal\'))?.hide();
            }
        }
    ]
});

// Footer sections - position buttons independently
SOModal.create({
    title: \'Footer Sections\',
    content: \'<p>Buttons can be positioned in left, center, or right sections.</p>\',
    footer: {
        left: [
            { content: [{ icon: \'help\' }, \'Help\'], class: \'so-btn-link\' }
        ],
        center: [
            { content: \'Preview\', class: \'so-btn-outline\' }
        ],
        right: [
            \'Cancel\',
            { content: [{ icon: \'save\' }, \'Save\'], class: \'so-btn-primary\' }
        ]
    }
});', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- Focus Element -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Focus Element</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Control which element receives focus when a modal opens using the <code>focusElement</code> option.</p>

            <h5 class="so-mb-3">Focus Options</h5>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showFocusModal('footer')">
                    Footer Button (Default)
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showFocusModal('close')">
                    Close Button
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showFocusModal('first')">
                    First Focusable
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showFocusModal('#custom-input')">
                    Custom Selector
                </button>
            </div>

            <div id="focus-result" class="so-mt-3"></div>

            <div class="so-mt-4">
                <?= so_code_block('// Focus first footer button (default behavior)
SOModal.create({
    title: \'Focus Footer\',
    content: \'<p>Focus goes to first button in footer.</p>\',
    focusElement: \'footer\',  // Default
    footer: [
        \'Cancel\',
        { content: \'Save\', class: \'so-btn-primary\' }
    ]
});

// Focus close button
SOModal.create({
    title: \'Focus Close\',
    content: \'<p>Focus goes to the X close button.</p>\',
    focusElement: \'close\'
});

// Focus first focusable element (original behavior)
SOModal.create({
    title: \'Focus First\',
    content: \'<p>Focus goes to first focusable element.</p>\',
    focusElement: \'first\'
});

// Focus specific element using CSS selector
SOModal.create({
    title: \'Focus Custom\',
    content: \'<input id="my-input" class="so-form-control" placeholder="Focus here">\',
    focusElement: \'#my-input\'
});

// Also works with SOModal.confirm()
SOModal.confirm({
    title: \'Confirm\',
    message: \'Focus on cancel button instead of confirm.\',
    focusElement: \'[data-modal-action="cancel"]\'
});', 'javascript') ?>
            </div>

            <h5 class="so-mb-3 so-mt-5">DOM Modal with Data Attribute</h5>
            <p class="so-text-secondary so-mb-3">For modals defined in HTML, use the <code>data-so-focus-element</code> attribute.</p>

            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-outline" data-so-toggle="modal" data-so-target="#focusDomModalFooter">
                    Focus Footer
                </button>
                <button type="button" class="so-btn so-btn-outline" data-so-toggle="modal" data-so-target="#focusDomModalClose">
                    Focus Close
                </button>
                <button type="button" class="so-btn so-btn-outline" data-so-toggle="modal" data-so-target="#focusDomModalInput">
                    Focus Input
                </button>
                <button type="button" class="so-btn so-btn-outline" data-so-toggle="modal" data-so-target="#focusDomModalButton">
                    Focus Specific Button
                </button>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('<!-- Focus footer button (default) -->
<div class="so-modal" id="myModal" data-so-focus-element="footer">
    ...
</div>

<!-- Focus close button -->
<div class="so-modal" id="myModal" data-so-focus-element="close">
    ...
</div>

<!-- Focus specific input -->
<div class="so-modal" id="myModal" data-so-focus-element="#email-input">
    ...
    <input id="email-input" class="so-form-control">
    ...
</div>

<!-- Focus specific button by ID -->
<div class="so-modal" id="myModal" data-so-focus-element="#save-btn">
    ...
    <button id="save-btn" class="so-btn so-btn-primary">Save</button>
    ...
</div>

// Initialize via JavaScript
const modal = SOModal.getInstance(\'#myModal\');
modal.show();', 'html') ?>
            </div>
        </div>
    </div>

    <!-- DOM Modals for Focus Demo -->
    <div class="so-modal" id="focusDomModalFooter" data-so-focus-element="footer">
        <div class="so-modal-dialog">
            <div class="so-modal-content">
                <div class="so-modal-header">
                    <h5 class="so-modal-title">DOM Modal - Footer Focus</h5>
                    <button type="button" class="so-modal-close" data-dismiss="modal">
                        <span class="material-icons">close</span>
                    </button>
                </div>
                <div class="so-modal-body">
                    <p>This modal is defined in HTML with <code>data-so-focus-element="footer"</code>.</p>
                    <p>Focus goes to the first button in the footer (Cancel).</p>
                </div>
                <div class="so-modal-footer">
                    <button type="button" class="so-btn so-btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="button" class="so-btn so-btn-primary" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="so-modal" id="focusDomModalClose" data-so-focus-element="close">
        <div class="so-modal-dialog">
            <div class="so-modal-content">
                <div class="so-modal-header">
                    <h5 class="so-modal-title">DOM Modal - Close Focus</h5>
                    <button type="button" class="so-modal-close" data-dismiss="modal">
                        <span class="material-icons">close</span>
                    </button>
                </div>
                <div class="so-modal-body">
                    <p>This modal is defined in HTML with <code>data-so-focus-element="close"</code>.</p>
                    <p>Focus goes to the X close button in the header.</p>
                </div>
                <div class="so-modal-footer">
                    <button type="button" class="so-btn so-btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="button" class="so-btn so-btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="so-modal" id="focusDomModalInput" data-so-focus-element="#dom-focus-input">
        <div class="so-modal-dialog">
            <div class="so-modal-content">
                <div class="so-modal-header">
                    <h5 class="so-modal-title">DOM Modal - Input Focus</h5>
                    <button type="button" class="so-modal-close" data-dismiss="modal">
                        <span class="material-icons">close</span>
                    </button>
                </div>
                <div class="so-modal-body">
                    <p>This modal uses <code>data-so-focus-element="#dom-focus-input"</code>.</p>
                    <div class="so-form-group so-mt-3">
                        <label class="so-form-label">Email Address</label>
                        <input type="email" id="dom-focus-input" class="so-form-control" placeholder="Enter your email">
                    </div>
                </div>
                <div class="so-modal-footer">
                    <button type="button" class="so-btn so-btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="button" class="so-btn so-btn-primary" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="so-modal" id="focusDomModalButton" data-so-focus-element="#dom-save-btn">
        <div class="so-modal-dialog">
            <div class="so-modal-content">
                <div class="so-modal-header">
                    <h5 class="so-modal-title">DOM Modal - Button Focus</h5>
                    <button type="button" class="so-modal-close" data-dismiss="modal">
                        <span class="material-icons">close</span>
                    </button>
                </div>
                <div class="so-modal-body">
                    <p>This modal uses <code>data-so-focus-element="#dom-save-btn"</code>.</p>
                    <p>Focus goes directly to the Save button in the footer, skipping Cancel.</p>
                </div>
                <div class="so-modal-footer">
                    <button type="button" class="so-btn so-btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="button" id="dom-save-btn" class="so-btn so-btn-primary" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form in Modal -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Form in Modal</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Modals work great for forms like login, signup, or data entry.</p>

            <button type="button" class="so-btn so-btn-primary" onclick="showFormModal()">
                Show Login Form
            </button>

            <div class="so-mt-4">
                <?= so_code_block('<div class="so-modal so-modal-sm">
    <div class="so-modal-dialog">
        <div class="so-modal-header">
            <h5 class="so-modal-title">Login</h5>
            <button class="so-modal-close" data-dismiss="modal">...</button>
        </div>
        <div class="so-modal-body">
            <form>
                <div class="so-form-group">
                    <label class="so-form-label">Email</label>
                    <input type="email" class="so-form-control">
                </div>
                <div class="so-form-group">
                    <label class="so-form-label">Password</label>
                    <input type="password" class="so-form-control">
                </div>
            </form>
        </div>
        <div class="so-modal-footer">
            <button class="so-btn so-btn-primary so-w-100">Sign In</button>
        </div>
    </div>
</div>', 'html') ?>
            </div>
        </div>
    </div>

    <!-- Drawers / Side Panels -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Drawers / Side Panels</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Drawers slide in from the side and are great for detailed views or filters.</p>

            <div class="so-btn-group so-flex-wrap so-mb-3">
                <button type="button" class="so-btn so-btn-outline" onclick="showDrawer('right')">
                    Right Drawer
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showDrawer('left')">
                    Left Drawer
                </button>
            </div>

            <h5 class="so-mb-2">Drawer Sizes</h5>
            <div class="so-btn-group so-flex-wrap">
                <button type="button" class="so-btn so-btn-outline" onclick="showDrawer('right', 'sm')">Small (320px)</button>
                <button type="button" class="so-btn so-btn-outline" onclick="showDrawer('right', 'default')">Default (400px)</button>
                <button type="button" class="so-btn so-btn-outline" onclick="showDrawer('right', 'lg')">Large (560px)</button>
                <button type="button" class="so-btn so-btn-outline" onclick="showDrawer('right', 'xl')">Extra Large (720px)</button>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('<!-- Right Drawer (default) -->
<div class="so-drawer">
    <div class="so-drawer-header">
        <h5 class="so-drawer-title">Drawer Title</h5>
        <button class="so-drawer-close">...</button>
    </div>
    <div class="so-drawer-body">Content...</div>
    <div class="so-drawer-footer">Actions...</div>
</div>

<!-- Left Drawer -->
<div class="so-drawer so-drawer-left">...</div>

<!-- Drawer Sizes -->
<div class="so-drawer so-drawer-sm">...</div>
<div class="so-drawer so-drawer-lg">...</div>
<div class="so-drawer so-drawer-xl">...</div>', 'html') ?>
            </div>
        </div>
    </div>

    <!-- Static Modal (Non-Dismissable) -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Static Modal (Non-Dismissable)</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">A static modal cannot be dismissed by clicking the backdrop, pressing Escape, or clicking a close button. The user must interact with footer actions to close it. Use this for mandatory actions like accepting terms, completing required steps, or critical confirmations.</p>

            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showStaticModal()">
                    Static Modal
                </button>
                <button type="button" class="so-btn so-btn-warning" onclick="showStaticModalWithLock()">
                    Static Modal with Lock Icon
                </button>
                <button type="button" class="so-btn so-btn-danger" onclick="showStaticConfirmModal()">
                    Mandatory Confirmation
                </button>
            </div>

            <div class="so-alert so-alert-info so-alert-sm so-mb-4">
                <span class="material-icons">info</span>
                <div>Try clicking outside the modal or pressing Escape - it won't close! A subtle shake animation indicates the modal requires action.</div>
            </div>

            <div class="so-mt-4">
                <?= so_code_tabs('static-modal', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Static Modal - cannot be dismissed except via footer actions -->
<div class="so-modal so-modal-static" data-so-static="true">
    <div class="so-modal-dialog">
        <div class="so-modal-header">
            <h5 class="so-modal-title">Required Action</h5>
            <!-- No close button shown -->
        </div>
        <div class="so-modal-body">
            <p>You must complete this action to continue.</p>
        </div>
        <div class="so-modal-footer">
            <button class="so-btn so-btn-primary" data-dismiss="modal">
                Accept & Continue
            </button>
        </div>
    </div>
</div>

<!-- With lock icon indicator -->
<div class="so-modal so-modal-static so-modal-show-lock" data-so-static="true">
    ...
</div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => '// Create static modal programmatically
const modal = SOModal.create({
    title: \'Terms of Service\',
    content: \'<p>Please accept our terms to continue.</p>\',
    static: true,  // Prevents backdrop/ESC close, hides close button
    footer: `
        <button class="so-btn so-btn-outline" onclick="handleDecline(this)">Decline</button>
        <button class="so-btn so-btn-primary" onclick="handleAccept(this)">Accept</button>
    `
});
modal.show();

// Handler functions - close modal after action
function handleAccept(btn) {
    // Perform your action here (e.g., save to server, update state)
    console.log(\'User accepted\');

    // Close the modal
    const modal = btn.closest(\'.so-modal\');
    SOModal.getInstance(modal)?.hide();
}

function handleDecline(btn) {
    // Perform your action here
    console.log(\'User declined\');

    // Close the modal
    const modal = btn.closest(\'.so-modal\');
    SOModal.getInstance(modal)?.hide();
}

// Static confirmation using SOModal.confirm()
const result = await SOModal.confirm({
    title: \'Delete Account\',
    message: \'This action is permanent and cannot be undone.\',
    static: true,  // Cannot dismiss without clicking a button
    confirmText: \'Delete Account\',
    cancelText: \'Keep Account\',
    danger: true
});

if (result) {
    console.log(\'User confirmed deletion\');
} else {
    console.log(\'User cancelled\');
}'
                    ]
                ]) ?>
            </div>
        </div>
    </div>

    <!-- Singleton Modal -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Singleton Modal</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Compare normal modals (multiple instances allowed) vs singleton modals (only one instance at a time).</p>

            <h5 class="so-mb-3">Normal Modal (Multiple Instances)</h5>
            <p class="so-text-secondary so-text-sm so-mb-3">Each click creates a new modal instance, stacking on top of each other.</p>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-outline" onclick="showNormalModal()">
                    Open Normal Modal
                </button>
            </div>

            <h5 class="so-mb-3">Singleton Modal (Single Instance)</h5>
            <p class="so-text-secondary so-text-sm so-mb-3">Only one instance can exist. Duplicate calls shake the existing modal instead of creating a new one.</p>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showSingletonModal()">
                    Open Singleton Modal
                </button>
            </div>

            <h5 class="so-mb-3 so-mt-4">Duplicate Attempt Feedback</h5>
            <p class="so-text-secondary so-text-sm so-mb-3">When trying to open an already-open singleton modal, it provides visual feedback. Click the button twice to see the effect.</p>
            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-outline" onclick="showSingletonModalWithFeedback('shake')">
                    Shake (Default)
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSingletonModalWithFeedback('pulse')">
                    Pulse
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSingletonModalWithFeedback('bounce')">
                    Bounce
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSingletonModalWithFeedback('headshake')">
                    Head Shake
                </button>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('// Normal modal - allows multiple instances
SOModal.create({
    title: \'Normal Modal\',
    content: \'<p>Each call creates a new instance...</p>\',
    // singleton: false (default)
});

// Singleton modal - only one instance at a time
SOModal.create({
    title: \'Settings\',
    content: \'<p>Your settings content here...</p>\',
    singleton: true,           // Enable singleton mode
    singletonId: \'my-settings\', // Optional: custom ID (defaults to title-based ID)
    footer: [...]
});

// When trying to open the same singleton again:
// - Default behavior: shake animation
// - Can customize with singletonFeedback option

SOModal.create({
    title: \'My Singleton\',
    content: \'...\',
    singleton: true,
    singletonId: \'my-modal\',
    singletonFeedback: \'pulse\'  // \'shake\' (default), \'pulse\', \'bounce\', \'headshake\'
});', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- Draggable Modal -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Draggable Modal</h3>
            <span class="so-badge so-badge-primary">New</span>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Modals can be dragged by their header. Click and hold the header to move the modal around the screen.</p>

            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showDraggableModal()">
                    Draggable Modal
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showDraggableModal('lg')">
                    Large Draggable
                </button>
            </div>

            <div class="so-alert so-alert-info so-alert-sm so-mb-4">
                <span class="material-icons">info</span>
                <div>Dragging is disabled on mobile devices and when the modal is maximized.</div>
            </div>

            <div class="so-mt-4">
                <?= so_code_tabs('draggable-modal', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Draggable modal via data attribute -->
<div class="so-modal so-modal-draggable" data-so-draggable="true">
    <div class="so-modal-dialog">
        <div class="so-modal-header" style="cursor: move">
            <h5 class="so-modal-title">Draggable Modal</h5>
            <button class="so-modal-close" data-dismiss="modal">...</button>
        </div>
        <div class="so-modal-body">...</div>
        <div class="so-modal-footer">...</div>
    </div>
</div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => '// Create draggable modal programmatically
const modal = SOModal.create({
    title: \'Draggable Modal\',
    content: \'<p>Drag me by the header!</p>\',
    draggable: true,
    footer: [
        { content: \'Close\', dismiss: true }
    ]
});
modal.show();

// Events
modal.element.addEventListener(\'so:modal:drag-start\', () => {
    console.log(\'Started dragging\');
});

modal.element.addEventListener(\'so:modal:drag-end\', () => {
    console.log(\'Stopped dragging\');
});'
                    ]
                ]) ?>
            </div>
        </div>
    </div>

    <!-- Maximizable Modal -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Maximizable Modal</h3>
            <span class="so-badge so-badge-primary">New</span>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Modals can have a maximize button that expands them to fullscreen. Click the maximize button in the header or double-click the header (when draggable).</p>

            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showMaximizableModal()">
                    Maximizable Modal
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showDraggableMaximizableModal()">
                    Draggable + Maximizable
                </button>
            </div>

            <div class="so-alert so-alert-info so-alert-sm so-mb-4">
                <span class="material-icons">info</span>
                <div>When both draggable and maximizable, double-click the header to toggle maximize.</div>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('// Create maximizable modal
const modal = SOModal.create({
    title: \'Maximizable Modal\',
    content: \'<p>Click the expand button to maximize!</p>\',
    maximizable: true,
    footer: [
        { content: \'Close\', dismiss: true }
    ]
});
modal.show();

// Programmatic control
modal.maximize();   // Maximize the modal
modal.restore();    // Restore to original size
modal.toggleMaximize(); // Toggle between states
modal.isMaximized(); // Check if maximized

// Events
modal.element.addEventListener(\'so:modal:maximize\', () => {
    console.log(\'Modal maximized\');
});

modal.element.addEventListener(\'so:modal:restore\', () => {
    console.log(\'Modal restored\');
});

// Draggable + Maximizable (double-click to maximize)
SOModal.create({
    title: \'Window-like Modal\',
    content: \'...\',
    draggable: true,
    maximizable: true
});', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- Nested Modals -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Nested Modals</h3>
            <span class="so-badge so-badge-primary">Improved</span>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Multiple modals can be stacked. Each nested modal gets a higher z-index and its own backdrop. Only the topmost modal responds to Escape key.</p>

            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showNestedModalDemo()">
                    Open Nested Modals Demo
                </button>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('// Open first modal
const modal1 = SOModal.create({
    title: \'First Modal\',
    content: `
        <p>This is the first (parent) modal.</p>
        <button class="so-btn so-btn-primary" onclick="openSecondModal()">
            Open Second Modal
        </button>
    `
});
modal1.show();

// Open second modal (stacks on top)
function openSecondModal() {
    const modal2 = SOModal.create({
        title: \'Second Modal\',
        content: `
            <p>This modal is stacked on top of the first.</p>
            <p>Press Escape to close this modal only.</p>
        `
    });
    modal2.show();
}

// Z-index stacking is automatic
// Escape closes only the topmost modal
// Each modal has its own backdrop', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- Mobile Fullscreen -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Mobile Fullscreen</h3>
            <span class="so-badge so-badge-primary">New</span>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Modals can automatically switch to fullscreen mode on mobile devices. This improves usability on small screens.</p>

            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showMobileFullscreenModal()">
                    Mobile Fullscreen Modal
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showMobileFullscreenModal(480)">
                    Custom Breakpoint (480px)
                </button>
            </div>

            <div class="so-alert so-alert-info so-alert-sm so-mb-4">
                <span class="material-icons">info</span>
                <div>Resize your browser to below 768px to see the fullscreen effect.</div>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('// Auto fullscreen on mobile (< 768px)
const modal = SOModal.create({
    title: \'Responsive Modal\',
    content: \'<p>This modal becomes fullscreen on mobile!</p>\',
    mobileFullscreen: true,
    footer: [...]
});

// Custom breakpoint
SOModal.create({
    title: \'Custom Breakpoint\',
    content: \'...\',
    mobileFullscreen: true,
    mobileBreakpoint: 480 // Fullscreen below 480px
});

// Mobile fullscreen automatically:
// - Disables dragging
// - Hides maximize button
// - Removes border radius
// - Expands to full viewport', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- Modal with Sidebar -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">Modal with Sidebar</h3>
            <span class="so-badge so-badge-primary">New</span>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Modals can have a sidebar layout, useful for settings panels, file browsers, or any content that benefits from a navigation area.</p>

            <div class="so-btn-group so-flex-wrap so-mb-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showSidebarModal('left')">
                    Sidebar Left
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSidebarModal('right')">
                    Sidebar Right
                </button>
                <button type="button" class="so-btn so-btn-outline" onclick="showSidebarModalCustomWidth()">
                    Custom Width (200px)
                </button>
            </div>

            <div class="so-alert so-alert-info so-alert-sm so-mb-4">
                <span class="material-icons">info</span>
                <div>On mobile, the sidebar stacks above the main content.</div>
            </div>

            <div class="so-mt-4">
                <?= so_code_block('// Sidebar on the left (default)
const modal = SOModal.create({
    title: \'Settings\',
    sidebar: \'left\', // or true (defaults to left)
    sidebarWidth: \'280px\', // default
    content: {
        sidebar: `
            <div class="so-list-group so-list-group-flush">
                <a href="#" class="so-list-group-item so-list-group-item-action so-active">General</a>
                <a href="#" class="so-list-group-item so-list-group-item-action">Account</a>
                <a href="#" class="so-list-group-item so-list-group-item-action">Privacy</a>
            </div>
        `,
        main: `
            <h4>General Settings</h4>
            <div class="so-form-group">
                <label class="so-form-label">Language</label>
                <select class="so-form-control" data-so-select>
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                </select>
            </div>
        `
    },
    footer: [
        { content: \'Cancel\', dismiss: true },
        { content: \'Save\', class: \'so-btn-primary\' }
    ]
});
modal.show();

// Initialize select components after modal is shown
modal.element.addEventListener(\'so:modal:shown\', () => {
    modal.element.querySelectorAll(\'[data-so-select]\').forEach(el => {
        if (!el._soSelectInstance) new SOSelect(el);
    });
});

// Custom sidebar width
SOModal.create({
    title: \'Compact Sidebar\',
    sidebar: \'left\',
    sidebarWidth: \'200px\',
    content: {...}
});', 'javascript') ?>
            </div>
        </div>
    </div>

    <!-- JavaScript API -->
    <div class="so-card so-mb-4">
        <div class="so-card-header">
            <h3 class="so-card-title">JavaScript API</h3>
        </div>
        <div class="so-card-body">
            <p class="so-text-secondary so-mb-4">Full API reference for the modal component.</p>

            <?= so_code_block('// Get modal instance
const modal = SOModal.getInstance(\'#myModal\');

// Instance Methods
modal.show();           // Show the modal
modal.hide();           // Hide the modal
modal.toggle();         // Toggle visibility
modal.isOpen();         // Check if open
modal.setTitle(\'New\'); // Set modal title
modal.setContent(html); // Set body content

// Static Methods
SOModal.create(options);      // Create modal dynamically
SOModal.confirm(options);     // Confirmation dialog (returns Promise)
SOModal.alert(options);       // Alert dialog (returns Promise)

// Options
{
    backdrop: true,      // Show backdrop
    keyboard: true,      // Close on Escape
    focus: true,         // Focus trap
    closable: true,      // Allow closing
    size: \'default\',     // sm, default, lg, xl, fullscreen
    animation: true      // Animate open/close
}

// Events
modal.element.addEventListener(\'so:modal:show\', (e) => {
    // Before modal shows (can call e.preventDefault())
});

modal.element.addEventListener(\'so:modal:shown\', () => {
    // After modal is visible
});

modal.element.addEventListener(\'so:modal:hide\', (e) => {
    // Before modal hides (can call e.preventDefault())
});

modal.element.addEventListener(\'so:modal:hidden\', () => {
    // After modal is hidden
});

modal.element.addEventListener(\'so:modal:confirm\', () => {
    // Confirm button clicked
});

modal.element.addEventListener(\'so:modal:cancel\', () => {
    // Cancel button clicked
});', 'javascript') ?>
        </div>
    </div>

</div>

<!-- Basic Modal (for demo) -->
<div class="so-modal so-fade" id="basicModal" tabindex="-1">
    <div class="so-modal-dialog">
        <div class="so-modal-header">
            <h5 class="so-modal-title">Basic Modal</h5>
            <button type="button" class="so-modal-close" onclick="closeModal('basicModal')">
                <span class="material-icons">close</span>
            </button>
        </div>
        <div class="so-modal-body">
            <p>This is a basic modal dialog. You can put any content here including forms, text, images, and more.</p>
            <p>The modal can be closed by clicking the X button, pressing Escape, or clicking outside the modal.</p>
        </div>
        <div class="so-modal-footer">
            <button type="button" class="so-btn so-btn-outline" onclick="closeModal('basicModal')">Cancel</button>
            <button type="button" class="so-btn so-btn-primary" onclick="closeModal('basicModal')">Save Changes</button>
        </div>
    </div>
</div>

<!-- Modal Backdrop -->
<div class="so-modal-backdrop so-fade" onclick="closeAllModals()"></div>

<script>
function createBackdrop() {
    let backdrop = document.querySelector('.so-modal-backdrop');
    if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'so-modal-backdrop so-fade';
        backdrop.onclick = closeAllModals;
        document.body.appendChild(backdrop);
    }
    setTimeout(() => backdrop.classList.add('so-show'), 10);
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('so-show');
    }
    const backdrop = document.querySelector('.so-modal-backdrop');
    if (backdrop) {
        backdrop.classList.remove('so-show');
    }
    document.body.style.overflow = '';
}

function closeAllModals() {
    document.querySelectorAll('.so-modal.so-show').forEach(modal => {
        modal.classList.remove('so-show');
    });
    // Also close any open drawers
    document.querySelectorAll('.so-drawer.so-show').forEach(drawer => {
        drawer.classList.remove('so-show');
        setTimeout(() => drawer.remove(), 300);
    });
    const backdrop = document.querySelector('.so-modal-backdrop');
    if (backdrop) {
        backdrop.classList.remove('so-show');
    }
    document.body.style.overflow = '';
}

function showSizeModal(size) {
    const sizeClass = size === 'default' ? '' : `so-modal-${size}`;
    const modal = SOModal.create({
        title: `${size.charAt(0).toUpperCase() + size.slice(1)} Modal`,
        content: `<p>This is a ${size} modal. The max-width is set based on the size class.</p>`,
        size: size,
        footer: '<button class="so-btn so-btn-primary" data-dismiss="modal">Close</button>'
    });
    modal.show();
}

function showScrollableModal() {
    const longContent = Array(20).fill('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>').join('');

    const modal = SOModal.create({
        title: 'Scrollable Modal',
        content: longContent,
        className: 'so-modal-scrollable',
        footer: '<button class="so-btn so-btn-primary" data-dismiss="modal">Close</button>'
    });
    modal.show();
}

function showContextualModal(variant) {
    const titles = {
        'primary': 'Primary Modal',
        'primary-light': 'Primary Light Modal',
        'secondary': 'Secondary Modal',
        'secondary-light': 'Secondary Light Modal',
        'success': 'Success Modal',
        'success-light': 'Success Light Modal',
        'danger': 'Danger Modal',
        'danger-light': 'Danger Light Modal',
        'warning': 'Warning Modal',
        'warning-light': 'Warning Light Modal',
        'info': 'Info Modal',
        'info-light': 'Info Light Modal',
        'light': 'Light Modal',
        'dark': 'Dark Modal',
        'dark-light': 'Dark Light Modal'
    };

    const messages = {
        'primary': 'This modal has a primary colored header.',
        'primary-light': 'This modal has a light primary colored header.',
        'secondary': 'This modal has a secondary colored header.',
        'secondary-light': 'This modal has a light secondary colored header.',
        'success': 'Great! Your operation was successful.',
        'success-light': 'This modal has a light success colored header.',
        'danger': 'Warning! This action may have serious consequences.',
        'danger-light': 'This modal has a light danger colored header.',
        'warning': 'Please review the following information carefully.',
        'warning-light': 'This modal has a light warning colored header.',
        'info': 'Here is some important information for you.',
        'info-light': 'This modal has a light info colored header.',
        'light': 'This modal has a light colored header.',
        'dark': 'This modal has a dark colored header.',
        'dark-light': 'This modal has a light dark (gray) colored header.'
    };

    const modal = SOModal.create({
        title: titles[variant] || 'Modal',
        content: `<p>${messages[variant] || 'This is a contextual modal.'}</p>
            <p class="so-text-secondary">You can use contextual classes to style the modal header with different colors. Add the class <code>so-modal-${variant}</code> to the modal element.</p>`,
        className: `so-modal-${variant}`,
        footer: '<button class="so-btn so-btn-outline" data-dismiss="modal">Cancel</button><button class="so-btn so-btn-primary" data-dismiss="modal">OK</button>'
    });
    modal.show();
}

async function showConfirmDialog() {
    const result = await SOModal.confirm({
        title: 'Confirm Action',
        message: 'Are you sure you want to proceed with this action?',
        confirmText: 'Yes, Continue',
        cancelText: 'Cancel'
    });

    document.getElementById('confirm-result').innerHTML = result
        ? '<div class="so-alert so-alert-success so-alert-sm"><span class="material-icons">check_circle</span> User confirmed the action</div>'
        : '<div class="so-alert so-alert-warning so-alert-sm"><span class="material-icons">cancel</span> User cancelled the action</div>';
}

async function showDeleteConfirm() {
    const result = await SOModal.confirm({
        title: 'Delete Item',
        message: 'This will permanently delete the item. This action cannot be undone.',
        confirmText: 'Delete',
        cancelText: 'Keep It',
        danger: true
    });

    document.getElementById('confirm-result').innerHTML = result
        ? '<div class="so-alert so-alert-danger so-alert-sm"><span class="material-icons">delete</span> Item was deleted</div>'
        : '<div class="so-alert so-alert-info so-alert-sm"><span class="material-icons">info</span> Delete was cancelled</div>';
}

async function showMultiActionDialog() {
    const action = await SOModal.confirm({
        title: 'Unsaved Changes',
        message: 'You have unsaved changes. What would you like to do?',
        actions: [
            { id: 'discard', text: 'Discard', class: 'so-btn-outline' },
            { id: 'save-draft', text: 'Save Draft', class: 'so-btn-secondary' },
            { id: 'save', text: 'Save & Close', class: 'so-btn-primary' }
        ]
    });

    const messages = {
        'save': '<div class="so-alert so-alert-success so-alert-sm"><span class="material-icons">save</span> User chose: Save & Close</div>',
        'save-draft': '<div class="so-alert so-alert-info so-alert-sm"><span class="material-icons">drafts</span> User chose: Save Draft</div>',
        'discard': '<div class="so-alert so-alert-warning so-alert-sm"><span class="material-icons">delete_outline</span> User chose: Discard</div>',
        'dismiss': '<div class="so-alert so-alert-secondary so-alert-sm"><span class="material-icons">close</span> User dismissed the dialog</div>'
    };
    document.getElementById('confirm-result').innerHTML = messages[action] || messages['dismiss'];
}

async function showFileActionDialog() {
    const action = await SOModal.confirm({
        title: 'File Already Exists',
        message: 'A file with this name already exists in the destination folder.',
        actions: [
            { id: 'cancel', text: 'Cancel', class: 'so-btn-outline' },
            { id: 'keep-both', text: 'Keep Both', class: 'so-btn-secondary' },
            { id: 'skip', text: 'Skip', class: 'so-btn-secondary' },
            { id: 'replace', text: 'Replace', class: 'so-btn-danger' }
        ]
    });

    const messages = {
        'replace': '<div class="so-alert so-alert-danger so-alert-sm"><span class="material-icons">sync</span> User chose: Replace existing file</div>',
        'keep-both': '<div class="so-alert so-alert-info so-alert-sm"><span class="material-icons">file_copy</span> User chose: Keep both files</div>',
        'skip': '<div class="so-alert so-alert-warning so-alert-sm"><span class="material-icons">skip_next</span> User chose: Skip this file</div>',
        'cancel': '<div class="so-alert so-alert-secondary so-alert-sm"><span class="material-icons">cancel</span> User chose: Cancel</div>',
        'dismiss': '<div class="so-alert so-alert-secondary so-alert-sm"><span class="material-icons">close</span> User dismissed the dialog</div>'
    };
    document.getElementById('confirm-result').innerHTML = messages[action] || messages['dismiss'];
}

// Centered Confirmation Dialog Functions
async function showCenteredConfirm(type) {
    const configs = {
        danger: {
            title: 'Delete Item',
            message: 'This will permanently delete the item. This action cannot be undone.',
            icon: { name: 'delete', type: 'danger' },
            confirm: [{ icon: 'delete' }, 'Delete'],
            cancel: 'Cancel',
            danger: true
        },
        warning: {
            title: 'Warning',
            message: 'This action may have unintended consequences. Do you want to proceed?',
            icon: { name: 'warning', type: 'warning' },
            confirm: [{ icon: 'warning' }, 'Proceed'],
            cancel: 'Cancel'
        },
        success: {
            title: 'Save Changes?',
            message: 'Do you want to save your changes before leaving?',
            icon: { name: 'save', type: 'success' },
            confirm: [{ icon: 'save' }, 'Save'],
            cancel: 'Cancel'
        },
        info: {
            title: 'Information',
            message: 'You are about to start a new process. Continue?',
            icon: { name: 'info', type: 'info' },
            confirm: ['Continue', { icon: 'arrow_forward' }],
            cancel: 'Cancel'
        }
    };

    const config = configs[type] || configs.info;
    const result = await SOModal.confirm(config);

    const resultEl = document.getElementById('centered-confirm-result');
    resultEl.innerHTML = result
        ? `<div class="so-alert so-alert-${type === 'danger' ? 'danger' : 'success'} so-alert-sm"><span class="material-icons">check_circle</span> User confirmed</div>`
        : `<div class="so-alert so-alert-secondary so-alert-sm"><span class="material-icons">cancel</span> User cancelled</div>`;
}

async function showIconLeftConfirm() {
    const result = await SOModal.confirm({
        title: 'Delete Item',
        message: 'Icon is positioned on the left of the button text.',
        icon: { name: 'delete', type: 'danger' },
        confirm: [{ icon: 'delete' }, 'Delete'],
        cancel: 'Cancel',
        danger: true
    });
    updateCenteredResult(result);
}

async function showIconRightConfirm() {
    const result = await SOModal.confirm({
        title: 'Continue?',
        message: 'Icon is positioned on the right of the button text.',
        icon: { name: 'arrow_forward', type: 'info' },
        confirm: ['Continue', { icon: 'arrow_forward' }],
        cancel: 'Cancel'
    });
    updateCenteredResult(result);
}

async function showBothIconsConfirm() {
    const result = await SOModal.confirm({
        title: 'Save Changes?',
        message: 'Both buttons have icons.',
        icon: { name: 'save', type: 'success' },
        confirm: [{ icon: 'check' }, 'Save'],
        cancel: [{ icon: 'close' }, 'Discard']
    });
    updateCenteredResult(result);
}

async function showButtonPosition(position) {
    const result = await SOModal.confirm({
        title: 'Button Position: ' + position.charAt(0).toUpperCase() + position.slice(1),
        message: 'Buttons are aligned to: ' + position,
        icon: { name: 'view_quilt', type: 'info' },
        confirm: 'OK',
        cancel: 'Cancel',
        buttonPosition: position
    });
    updateCenteredResult(result);
}

async function showStackedButtons() {
    const result = await SOModal.confirm({
        title: 'Stacked Buttons',
        message: 'Buttons are displayed vertically (stacked layout).',
        icon: { name: 'view_agenda', type: 'info' },
        confirm: [{ icon: 'check' }, 'Primary Action'],
        cancel: [{ icon: 'close' }, 'Secondary Action'],
        buttonLayout: 'stacked',
        fullWidthButtons: true
    });
    updateCenteredResult(result);
}

async function showReversedButtons() {
    const result = await SOModal.confirm({
        title: 'Reversed Order',
        message: 'Confirm button appears first, then Cancel.',
        icon: { name: 'swap_horiz', type: 'info' },
        confirm: 'Confirm',
        cancel: 'Cancel',
        reverseButtons: true
    });
    updateCenteredResult(result);
}

async function showWithCloseButton() {
    const result = await SOModal.confirm({
        title: 'With Close Button',
        message: 'This dialog has an X close button in the header.',
        icon: { name: 'help_outline', type: 'info' },
        confirm: 'OK',
        cancel: 'Cancel',
        showCloseButton: true
    });
    updateCenteredResult(result);
}

function updateCenteredResult(result) {
    const resultEl = document.getElementById('centered-confirm-result');
    resultEl.innerHTML = result
        ? '<div class="so-alert so-alert-success so-alert-sm"><span class="material-icons">check_circle</span> User confirmed</div>'
        : '<div class="so-alert so-alert-secondary so-alert-sm"><span class="material-icons">cancel</span> User cancelled</div>';
}

function showProgrammaticModal() {
    const modal = SOModal.create({
        title: 'Dynamic Modal',
        content: `
            <p>This modal was created entirely with JavaScript using <code>SOModal.create()</code>.</p>
            <p>You can pass any HTML content and it will be rendered in the modal body.</p>
            <div class="so-alert so-alert-info so-alert-sm so-mt-3">
                <span class="material-icons">lightbulb</span>
                <div>Tip: The modal is automatically removed from DOM when closed.</div>
            </div>
        `,
        size: 'default',
        footer: `
            <button class="so-btn so-btn-outline" data-dismiss="modal">Cancel</button>
            <button class="so-btn so-btn-primary" data-dismiss="modal">Got It</button>
        `
    });
    modal.show();
}

function showFlexibleFooterModal() {
    const modal = SOModal.create({
        title: 'Flexible Footer Buttons',
        content: `
            <p>This modal uses the flexible array format for footer buttons.</p>
            <p>Each button can have icons, custom classes, and click handlers.</p>
            <div class="so-alert so-alert-info so-alert-sm so-mt-3">
                <span class="material-icons">info</span>
                <div>Buttons are defined as an array with flexible content options.</div>
            </div>
        `,
        size: 'default',
        footer: [
            'Cancel',
            { content: [{ icon: 'close' }, 'Discard'], class: 'so-btn-outline' },
            { content: [{ icon: 'save' }, 'Save'], class: 'so-btn-primary' }
        ],
        footerPosition: 'right'
    });
    modal.show();
}

function showSectionsFooterModal() {
    const modal = SOModal.create({
        title: 'Footer Sections Layout',
        content: `
            <p>This modal demonstrates the <strong>footer sections</strong> feature.</p>
            <p>Buttons can be independently positioned in <code>left</code>, <code>center</code>, or <code>right</code> sections.</p>
            <div class="so-alert so-alert-info so-alert-sm so-mt-3">
                <span class="material-icons">info</span>
                <div>Uses CSS Grid for true centering regardless of left/right content width.</div>
            </div>
        `,
        size: 'default',
        footer: {
            left: [
                { content: [{ icon: 'help_outline' }, 'Help'], class: 'so-btn-link' }
            ],
            center: [
                { content: 'Preview', class: 'so-btn-outline' }
            ],
            right: [
                'Cancel',
                { content: [{ icon: 'save' }, 'Save'], class: 'so-btn-primary' }
            ]
        }
    });
    modal.show();
}

function showFormModal() {
    const modal = SOModal.create({
        title: 'Sign In',
        content: `
            <form>
                <div class="so-form-group">
                    <label class="so-form-label">Email Address</label>
                    <div class="so-input-wrapper">
                        <span class="so-input-icon"><span class="material-icons">email</span></span>
                        <input type="email" class="so-form-control" placeholder="Enter your email">
                    </div>
                </div>
                <div class="so-form-group">
                    <label class="so-form-label">Password</label>
                    <div class="so-input-wrapper">
                        <span class="so-input-icon"><span class="material-icons">lock</span></span>
                        <input type="password" class="so-form-control" placeholder="Enter your password">
                    </div>
                </div>
                <div class="so-form-group">
                    <label class="so-checkbox">
                        <input type="checkbox">
                        <span class="so-checkbox-mark"></span>
                        <span class="so-checkbox-label">Remember me</span>
                    </label>
                </div>
            </form>
        `,
        size: 'sm',
        footer: `
            <button class="so-btn so-btn-primary so-w-100" data-dismiss="modal">Sign In</button>
        `
    });
    modal.show();
}

function showDrawer(position, size = 'default') {
    const sizeClass = size === 'default' ? '' : `so-drawer-${size}`;
    const positionClass = position === 'left' ? 'so-drawer-left' : '';

    // Create drawer element
    const drawer = document.createElement('div');
    drawer.className = `so-drawer ${positionClass} ${sizeClass}`.trim();
    drawer.innerHTML = `
        <div class="so-drawer-header">
            <h5 class="so-drawer-title">${position.charAt(0).toUpperCase() + position.slice(1)} Drawer (${size})</h5>
            <button type="button" class="so-drawer-close" onclick="closeDrawer(this)">
                <span class="material-icons">close</span>
            </button>
        </div>
        <div class="so-drawer-body">
            <p>This is a ${position} drawer panel with ${size} size.</p>
            <p>Drawers are useful for:</p>
            <ul>
                <li>Detailed item views</li>
                <li>Filter panels</li>
                <li>Settings panels</li>
                <li>Quick edit forms</li>
            </ul>
            <div class="so-form-group so-mt-4">
                <label class="so-form-label">Sample Input</label>
                <input type="text" class="so-form-control" placeholder="Type something...">
            </div>
        </div>
        <div class="so-drawer-footer">
            <button class="so-btn so-btn-outline" onclick="closeDrawer(this)">Cancel</button>
            <button class="so-btn so-btn-primary" onclick="closeDrawer(this)">Save</button>
        </div>
    `;

    document.body.appendChild(drawer);
    createBackdrop();

    // Trigger animation
    setTimeout(() => drawer.classList.add('so-show'), 10);
}

function closeDrawer(btn) {
    const drawer = btn.closest('.so-drawer');
    if (drawer) {
        drawer.classList.remove('so-show');
        setTimeout(() => drawer.remove(), 300);
    }
    closeAllModals();
}

// Close on Escape key - only for manually created modals (not SOModal instances)
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        // Check for static modals first - don't close them, just shake
        const staticModals = document.querySelectorAll('.so-modal-static.so-show');
        if (staticModals.length > 0) {
            staticModals.forEach(modal => {
                modal.classList.add('so-modal-static-shake');
                setTimeout(() => modal.classList.remove('so-modal-static-shake'), 300);
            });
            return; // Don't close anything
        }

        // Only close the static demo modal (basicModal)
        const basicModal = document.getElementById('basicModal');
        if (basicModal && basicModal.classList.contains('so-show')) {
            closeModal('basicModal');
        }
        // Close any drawers
        document.querySelectorAll('.so-drawer.so-show').forEach(drawer => {
            drawer.classList.remove('so-show');
            setTimeout(() => drawer.remove(), 300);
        });
        // Close demo backdrop if no modals are open
        const demoBackdrop = document.querySelector('.so-modal-backdrop');
        const anyDemoModalOpen = document.querySelectorAll('.so-modal.so-show:not([data-so-component])').length > 0;
        if (demoBackdrop && !anyDemoModalOpen) {
            demoBackdrop.classList.remove('so-show');
        }
    }
});

// Static Modal functions
function showStaticModal() {
    const modal = SOModal.create({
        title: 'Terms of Service',
        content: `
            <p>Please read and accept our Terms of Service to continue using the application.</p>
            <div class="so-border so-rounded-md so-p-3 so-bg-light" style="max-height: 200px; overflow-y: auto;">
                <h6>1. Acceptance of Terms</h6>
                <p class="so-text-secondary so-text-sm">By accessing or using our service, you agree to be bound by these Terms of Service.</p>
                <h6>2. Use of Service</h6>
                <p class="so-text-secondary so-text-sm">You agree to use the service only for lawful purposes and in accordance with these Terms.</p>
                <h6>3. Privacy Policy</h6>
                <p class="so-text-secondary so-text-sm">Your use of the service is also governed by our Privacy Policy.</p>
            </div>
            <div class="so-mt-3">
                <label class="so-checkbox">
                    <input type="checkbox" id="accept-terms">
                    <span class="so-checkbox-mark"></span>
                    <span class="so-checkbox-label">I have read and agree to the Terms of Service</span>
                </label>
            </div>
        `,
        className: 'so-modal-static',
        static: true,
        footer: `
            <button class="so-btn so-btn-outline" onclick="handleDeclineTerms(this)">Decline</button>
            <button class="so-btn so-btn-primary" onclick="handleAcceptTerms(this)">Accept & Continue</button>
        `
    });
    modal.show();
}

function handleAcceptTerms(btn) {
    const modal = btn.closest('.so-modal');
    if (modal) {
        SOModal.getInstance(modal)?.hide();
    }
    SOToast?.show({ message: 'Terms accepted! Welcome aboard.', type: 'success' });
}

function handleDeclineTerms(btn) {
    const modal = btn.closest('.so-modal');
    SOModal.getInstance(modal)?.hide();
    SOToast?.show({ message: 'You declined the terms of service.', type: 'warning' });
}

function showStaticModalWithLock() {
    const modal = SOModal.create({
        title: 'Session Timeout Warning',
        content: `
            <div class="so-text-center so-py-3">
                <div class="so-confirm-icon so-warning so-mx-auto">
                    <span class="material-icons">timer</span>
                </div>
                <h5 class="so-mt-3">Your session is about to expire</h5>
                <p class="so-text-secondary">Due to inactivity, you will be logged out in <strong id="countdown">30</strong> seconds.</p>
                <p class="so-text-secondary so-text-sm">Click "Stay Logged In" to continue your session.</p>
            </div>
        `,
        className: 'so-modal-static so-modal-show-lock',
        static: true,
        size: 'sm',
        footer: `
            <button class="so-btn so-btn-outline" onclick="handleLogout(this)">Log Out Now</button>
            <button class="so-btn so-btn-primary" onclick="handleStayLoggedIn(this)">Stay Logged In</button>
        `
    });
    modal.show();

    // Simulate countdown
    let count = 30;
    const countdownEl = document.getElementById('countdown');
    const countdownInterval = setInterval(() => {
        count--;
        if (countdownEl) countdownEl.textContent = count;
        if (count <= 0) {
            clearInterval(countdownInterval);
            handleLogout(document.querySelector('.so-modal-static .so-btn-outline'));
        }
    }, 1000);

    // Store interval ID to clear if modal is closed
    modal.element._countdownInterval = countdownInterval;
}

function handleStayLoggedIn(btn) {
    const modal = btn.closest('.so-modal');
    if (modal?._countdownInterval) clearInterval(modal._countdownInterval);
    SOModal.getInstance(modal)?.hide();
    SOToast?.show({ message: 'Session extended successfully!', type: 'success' });
}

function handleLogout(btn) {
    const modal = btn.closest('.so-modal');
    if (modal?._countdownInterval) clearInterval(modal._countdownInterval);
    SOModal.getInstance(modal)?.hide();
    SOToast?.show({ message: 'You have been logged out.', type: 'info' });
}

function showStaticConfirmModal() {
    const modal = SOModal.create({
        title: 'Delete Your Account',
        content: `
            <div class="so-text-center so-py-2">
                <div class="so-confirm-icon so-danger so-mx-auto">
                    <span class="material-icons">warning</span>
                </div>
                <h5 class="so-mt-3 so-text-danger">This action is irreversible!</h5>
                <p class="so-text-secondary">All your data, including files, settings, and history will be permanently deleted.</p>
                <p class="so-text-secondary so-text-sm so-mt-2">Are you sure you want to proceed?</p>
            </div>
        `,
        className: 'so-modal-static so-modal-danger',
        static: true,
        footer: `
            <button class="so-btn so-btn-outline" onclick="handleCancelDelete(this)">Cancel</button>
            <button class="so-btn so-btn-danger" onclick="handleConfirmDelete(this)">Delete Account</button>
        `
    });
    modal.show();
}

function handleCancelDelete(btn) {
    const modal = btn.closest('.so-modal');
    SOModal.getInstance(modal)?.hide();
    SOToast?.show({ message: 'Account deletion cancelled.', type: 'info' });
}

function handleConfirmDelete(btn) {
    const modal = btn.closest('.so-modal');
    SOModal.getInstance(modal)?.hide();
    SOToast?.show({ message: 'Account has been deleted.', type: 'danger' });
}

// Focus Element Demo Functions
function showFocusModal(focusOption) {
    const descriptions = {
        'footer': 'Focus is on the first footer button (Cancel). This is the new default behavior.',
        'close': 'Focus is on the X close button in the header.',
        'first': 'Focus is on the first focusable element (original behavior).',
        '#custom-input': 'Focus is on a specific element using a CSS selector.'
    };

    let content = `<p>${descriptions[focusOption]}</p>`;

    // Add an input for the custom selector demo
    if (focusOption === '#custom-input') {
        content = `
            <p>${descriptions[focusOption]}</p>
            <div class="so-form-group so-mt-3">
                <label class="so-form-label">Custom Input (focused)</label>
                <input type="text" id="custom-input" class="so-form-control" placeholder="This input receives focus">
            </div>
        `;
    }

    const modal = SOModal.create({
        title: `Focus: ${focusOption}`,
        content: content,
        focusElement: focusOption,
        footer: [
            'Cancel',
            { content: 'OK', class: 'so-btn-primary' }
        ],
        footerPosition: 'right'
    });
    modal.show();

    document.getElementById('focus-result').innerHTML = `
        <div class="so-alert so-alert-info so-alert-sm">
            <span class="material-icons">center_focus_strong</span>
            <div>focusElement: <code>${focusOption}</code></div>
        </div>
    `;
}

// DOM Modal Demo Functions
function showDomModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;

    const modal = SOModal.getInstance(modalEl);
    modal.show();
}

// Normal Modal Demo (multiple instances allowed)
function showNormalModal() {
    const modal = SOModal.create({
        title: 'Normal Modal',
        content: `
            <p>This is a <strong>normal modal</strong> - multiple instances can exist at the same time.</p>
            <p>Click the button below to open another instance. Each click creates a new modal that stacks on top.</p>
            <div class="so-mt-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showNormalModal()">
                    <span class="material-icons">add</span> Open Another Modal
                </button>
            </div>
        `,
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true }
        ]
    });
    modal.show();
}

// Singleton Modal Demo (only one instance allowed)
function showSingletonModal() {
    const modal = SOModal.create({
        title: 'Singleton Modal',
        content: `
            <p>This modal is a <strong>singleton</strong> - only one instance can exist at a time.</p>
            <p>Click the button below to try opening another instance. Instead of creating a new modal, this one will <strong>shake</strong> to indicate it's already open.</p>
            <div class="so-mt-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showSingletonModal()">
                    <span class="material-icons">add</span> Try Open Another
                </button>
            </div>
            <div class="so-alert so-alert-info so-alert-sm so-mt-3">
                <span class="material-icons">info</span>
                <div>Useful for modals that should never have multiple instances, like settings or login dialogs.</div>
            </div>
        `,
        singleton: true,
        singletonId: 'demo-singleton',
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true }
        ]
    });
    modal.show();
}

// Singleton Modal with Duplicate Attempt Feedback
function showSingletonModalWithFeedback(feedbackType) {
    const feedbackNames = {
        'shake': 'Shake',
        'pulse': 'Pulse',
        'bounce': 'Bounce',
        'headshake': 'Head Shake'
    };

    const options = {
        title: `Singleton - ${feedbackNames[feedbackType]} Feedback`,
        content: `
            <p>This singleton uses <strong>${feedbackType}</strong> animation when you try to open it again while already open.</p>
            <p>Click the button below to see the feedback animation:</p>
            <div class="so-mt-4">
                <button type="button" class="so-btn so-btn-primary" onclick="showSingletonModalWithFeedback('${feedbackType}')">
                    <span class="material-icons">add</span> Try Open Again
                </button>
            </div>
        `,
        singleton: true,
        singletonId: 'demo-singleton-feedback',
        singletonFeedback: feedbackType,
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true }
        ]
    };

    const modal = SOModal.create(options);
    modal.show();
}

// Draggable Modal Demos
function showDraggableModal(size = 'default') {
    const modal = SOModal.create({
        title: 'Draggable Modal',
        content: `
            <p>This modal can be dragged by its header. Try clicking and dragging the header bar!</p>
            <p>The modal is constrained to the viewport boundaries.</p>
            <div class="so-alert so-alert-info so-alert-sm so-mt-3">
                <span class="material-icons">touch_app</span>
                <div>Works with both mouse and touch events.</div>
            </div>
        `,
        size: size,
        draggable: true,
        footer: [
            { content: 'Cancel', class: 'so-btn-outline', dismiss: true },
            { content: 'OK', class: 'so-btn-primary', dismiss: true }
        ]
    });
    modal.show();
}

// Maximizable Modal Demos
function showMaximizableModal() {
    const modal = SOModal.create({
        title: 'Maximizable Modal',
        content: `
            <p>Click the <span class="material-icons" style="vertical-align: middle; font-size: 18px;">open_in_full</span> button in the header to maximize this modal to fullscreen.</p>
            <p>Click it again (or the <span class="material-icons" style="vertical-align: middle; font-size: 18px;">close_fullscreen</span> button) to restore it.</p>
            <div class="so-mt-4">
                <h5>Maximized State Features:</h5>
                <ul>
                    <li>Full viewport coverage</li>
                    <li>No border radius</li>
                    <li>Content area expands</li>
                    <li>Dragging is disabled</li>
                </ul>
            </div>
        `,
        maximizable: true,
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true }
        ]
    });
    modal.show();
}

function showDraggableMaximizableModal() {
    const modal = SOModal.create({
        title: 'Draggable + Maximizable',
        content: `
            <p>This modal combines both features:</p>
            <ul>
                <li><strong>Drag:</strong> Click and hold the header to move</li>
                <li><strong>Maximize:</strong> Click the expand button OR double-click the header</li>
            </ul>
            <p class="so-text-secondary so-mt-3">When maximized, dragging is disabled. Restore to normal size to drag again.</p>
        `,
        draggable: true,
        maximizable: true,
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true }
        ]
    });
    modal.show();
}

// Nested Modals Demo
function showNestedModalDemo() {
    const modal1 = SOModal.create({
        title: 'First Modal (Level 1)',
        content: `
            <p>This is the first (parent) modal.</p>
            <p>Each nested modal gets a higher z-index and its own backdrop.</p>
            <div class="so-mt-4">
                <button type="button" class="so-btn so-btn-primary" onclick="openNestedModal2()">
                    <span class="material-icons">layers</span> Open Second Modal
                </button>
            </div>
        `,
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true }
        ]
    });
    modal1.show();
}

function openNestedModal2() {
    const modal2 = SOModal.create({
        title: 'Second Modal (Level 2)',
        content: `
            <p>This modal is stacked on top of the first.</p>
            <p>Press <kbd>Escape</kbd> to close only this modal.</p>
            <div class="so-mt-4">
                <button type="button" class="so-btn so-btn-warning" onclick="openNestedModal3()">
                    <span class="material-icons">layers</span> Open Third Modal
                </button>
            </div>
        `,
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true }
        ]
    });
    modal2.show();
}

function openNestedModal3() {
    const modal3 = SOModal.create({
        title: 'Third Modal (Level 3)',
        content: `
            <p>This is the third level!</p>
            <p>Each modal maintains its own state and can be closed independently.</p>
            <div class="so-alert so-alert-success so-alert-sm so-mt-3">
                <span class="material-icons">check_circle</span>
                <div>Z-index stacking is handled automatically.</div>
            </div>
        `,
        size: 'sm',
        footer: [
            { content: 'Close All', class: 'so-btn-outline', onclick: () => {
                // Close all modals by pressing escape multiple times equivalent
                document.querySelectorAll('.so-modal.so-show').forEach(m => {
                    SOModal.getInstance(m)?.hide();
                });
            }},
            { content: 'Close This', class: 'so-btn-primary', dismiss: true }
        ]
    });
    modal3.show();
}

// Mobile Fullscreen Demo
function showMobileFullscreenModal(breakpoint = 768) {
    const modal = SOModal.create({
        title: 'Responsive Modal',
        content: `
            <p>This modal automatically switches to fullscreen on mobile devices.</p>
            <p><strong>Current breakpoint:</strong> ${breakpoint}px</p>
            <p>Resize your browser window below ${breakpoint}px to see the fullscreen effect.</p>
            <div class="so-alert so-alert-info so-alert-sm so-mt-3">
                <span class="material-icons">phone_android</span>
                <div>In mobile fullscreen mode:</div>
            </div>
            <ul>
                <li>Modal fills the entire viewport</li>
                <li>Dragging is disabled</li>
                <li>Maximize button is hidden</li>
                <li>Border radius is removed</li>
            </ul>
        `,
        mobileFullscreen: true,
        mobileBreakpoint: breakpoint,
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true },
            { content: 'Got It', class: 'so-btn-primary', dismiss: true }
        ]
    });
    modal.show();
}

// Modal with Sidebar Demos
function showSidebarModal(position = 'left') {
    const sidebarContent = `
        <div class="so-list-group so-list-group-flush">
            <a href="#" class="so-list-group-item so-list-group-item-action so-active">
                <span class="material-icons">settings</span>
                General
            </a>
            <a href="#" class="so-list-group-item so-list-group-item-action">
                <span class="material-icons">person</span>
                Account
            </a>
            <a href="#" class="so-list-group-item so-list-group-item-action">
                <span class="material-icons">lock</span>
                Privacy
            </a>
            <a href="#" class="so-list-group-item so-list-group-item-action">
                <span class="material-icons">notifications</span>
                Notifications
            </a>
            <a href="#" class="so-list-group-item so-list-group-item-action">
                <span class="material-icons">palette</span>
                Appearance
            </a>
        </div>
    `;

    const mainContent = `
        <h4 class="so-mb-4">General Settings</h4>
        <div class="so-form-group">
            <label class="so-form-label">Language</label>
            <select class="so-form-control" data-so-select>
                <option value="en" selected>English</option>
                <option value="es">Spanish</option>
                <option value="fr">French</option>
                <option value="de">German</option>
                <option value="ja">Japanese</option>
            </select>
        </div>
        <div class="so-form-group">
            <label class="so-form-label">Timezone</label>
            <select class="so-form-control" data-so-select>
                <option value="utc" selected>UTC</option>
                <option value="est">EST (Eastern)</option>
                <option value="pst">PST (Pacific)</option>
                <option value="gmt">GMT</option>
                <option value="ist">IST (India)</option>
            </select>
        </div>
        <div class="so-form-group">
            <label class="so-checkbox">
                <input type="checkbox" checked>
                <span class="so-checkbox-mark"></span>
                <span class="so-checkbox-label">Enable auto-save</span>
            </label>
        </div>
    `;

    const modal = SOModal.create({
        title: 'Settings',
        sidebar: position,
        size: 'lg',
        content: {
            sidebar: sidebarContent,
            main: mainContent
        },
        footer: [
            { content: 'Cancel', class: 'so-btn-outline', dismiss: true },
            { content: [{ icon: 'save' }, 'Save Changes'], class: 'so-btn-primary', dismiss: true }
        ]
    });
    modal.show();

    // Initialize select components after modal is shown
    modal.element.addEventListener('so:modal:shown', () => {
        modal.element.querySelectorAll('[data-so-select]').forEach(el => {
            if (typeof SOSelect !== 'undefined' && !el._soSelectInstance) {
                new SOSelect(el);
            }
        });
    });
}

function showSidebarModalCustomWidth() {
    const modal = SOModal.create({
        title: 'Compact Sidebar',
        sidebar: 'left',
        sidebarWidth: '200px',
        content: {
            sidebar: `
                <div class="so-text-center so-py-3">
                    <span class="material-icons so-text-primary" style="font-size: 48px;">folder</span>
                </div>
                <div class="so-list-group so-list-group-flush so-list-group-sm">
                    <a href="#" class="so-list-group-item so-list-group-item-action so-active">Documents</a>
                    <a href="#" class="so-list-group-item so-list-group-item-action">Images</a>
                    <a href="#" class="so-list-group-item so-list-group-item-action">Downloads</a>
                    <a href="#" class="so-list-group-item so-list-group-item-action">Shared</a>
                </div>
            `,
            main: `
                <h5 class="so-mb-3">Documents</h5>
                <p class="so-text-secondary">Select a folder from the sidebar to view its contents.</p>
                <div class="so-border so-rounded so-p-3 so-mt-3 so-bg-light">
                    <p class="so-text-center so-text-secondary so-my-4">
                        <span class="material-icons" style="font-size: 48px; opacity: 0.5;">folder_open</span>
                        <br>
                        No files in this folder
                    </p>
                </div>
            `
        },
        footer: [
            { content: 'Close', class: 'so-btn-outline', dismiss: true }
        ]
    });
    modal.show();
}
</script>

</main>

<?php
require_once '../includes/footer.php';
?>
