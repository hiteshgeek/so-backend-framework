<?php
/**
 * SixOrbit UI Engine - Toast Element Demo
 */

$pageTitle = 'Toast - UI Engine';
$pageDescription = 'Lightweight notifications for user feedback';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Toast</h1>
            <p class="so-page-subtitle">Lightweight notifications for providing user feedback without interrupting workflow.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Toast -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Toast</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Click the button to show a basic toast notification.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <button type="button" class="so-btn so-btn-primary" onclick="SOToast.show({ title: 'Notification', message: 'Hello! This is a toast message.' })">
                        Show Toast
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-toast', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$toast = UiEngine::toast()
    ->title('Notification')
    ->message('Hello! This is a toast message.');

echo \$toast->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Show toast via JavaScript
SOToast.show({
    title: 'Notification',
    message: 'Hello! This is a toast message.'
});

// Or using UiEngine
UiEngine.toast()
    .title('Notification')
    .message('Hello! This is a toast message.')
    .show();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-toast so-fade so-show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="so-toast-header">
        <strong class="so-me-auto">Notification</strong>
        <button type="button" class="so-btn-close" data-so-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="so-toast-body">
        Hello! This is a toast message.
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Toast Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Toast Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Contextual toast variants for different message types.</p>

                <!-- Live Demo -->
                <div class="so-btn-group so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-success" onclick="SOToast.success('Your changes have been saved.')">Success</button>
                    <button type="button" class="so-btn so-btn-danger" onclick="SOToast.error('Something went wrong.')">Error</button>
                    <button type="button" class="so-btn so-btn-warning" onclick="SOToast.warning('Please review your input.')">Warning</button>
                    <button type="button" class="so-btn so-btn-info" onclick="SOToast.info('New features available.')">Info</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('toast-variants', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Success toast
UiEngine::toast()
    ->success()
    ->title('Success!')
    ->message('Your changes have been saved.');

// Error toast
UiEngine::toast()
    ->danger()
    ->title('Error!')
    ->message('Something went wrong.');

// Warning toast
UiEngine::toast()
    ->warning()
    ->title('Warning')
    ->message('Please review your input.');

// Info toast
UiEngine::toast()
    ->info()
    ->title('Info')
    ->message('New features available.');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Quick toast methods (simple style)
SOToast.success('Your changes have been saved.');
SOToast.error('Something went wrong.');
SOToast.warning('Please review your input.');
SOToast.info('New features available.');

// With title and options
SOToast.show({
    type: 'success',
    title: 'Success!',
    message: 'Your changes have been saved.'
});"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Success Toast -->
<div class="so-toast so-toast-success so-fade so-show" role="alert">
    <div class="so-toast-header">
        <span class="material-icons so-me-2">check_circle</span>
        <strong class="so-me-auto">Success!</strong>
        <button type="button" class="so-btn-close" data-so-dismiss="toast"></button>
    </div>
    <div class="so-toast-body">Your changes have been saved.</div>
</div>

<!-- Error Toast -->
<div class="so-toast so-toast-danger so-fade so-show" role="alert">...</div>

<!-- Warning Toast -->
<div class="so-toast so-toast-warning so-fade so-show" role="alert">...</div>

<!-- Info Toast -->
<div class="so-toast so-toast-info so-fade so-show" role="alert">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Toast Positions -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Toast Positions</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Toasts can appear in different positions on the screen.</p>

                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-grid-cols-sm-2 so-gap-2 so-mb-4">
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="SOToast.show({ message: 'Top Left', position: 'top-left' })">Top Left</button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="SOToast.show({ message: 'Top Center', position: 'top-center' })">Top Center</button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="SOToast.show({ message: 'Top Right', position: 'top-right' })">Top Right</button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="SOToast.show({ message: 'Bottom Left', position: 'bottom-left' })">Bottom Left</button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="SOToast.show({ message: 'Bottom Center', position: 'bottom-center' })">Bottom Center</button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="SOToast.show({ message: 'Bottom Right', position: 'bottom-right' })">Bottom Right</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('toast-positions', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Position options
UiEngine::toast()->message('Message')->position('top-right');     // Default
UiEngine::toast()->message('Message')->position('top-left');
UiEngine::toast()->message('Message')->position('top-center');
UiEngine::toast()->message('Message')->position('bottom-right');
UiEngine::toast()->message('Message')->position('bottom-left');
UiEngine::toast()->message('Message')->position('bottom-center');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Position options
SOToast.show({ message: 'Message', position: 'top-right' });    // Default
SOToast.show({ message: 'Message', position: 'top-left' });
SOToast.show({ message: 'Message', position: 'top-center' });
SOToast.show({ message: 'Message', position: 'bottom-right' });
SOToast.show({ message: 'Message', position: 'bottom-left' });
SOToast.show({ message: 'Message', position: 'bottom-center' });"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Toast Container Positions -->
<div class="so-toast-container so-toast-top-right">...</div>
<div class="so-toast-container so-toast-top-left">...</div>
<div class="so-toast-container so-toast-top-center">...</div>
<div class="so-toast-container so-toast-bottom-right">...</div>
<div class="so-toast-container so-toast-bottom-left">...</div>
<div class="so-toast-container so-toast-bottom-center">...</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Auto-dismiss and Duration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Auto-dismiss Options</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Configure auto-dismiss behavior and duration.</p>

                <!-- Live Demo -->
                <div class="so-btn-group so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-outline" onclick="SOToast.show({ message: 'Quick (2s)', duration: 2000 })">Quick (2s)</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="SOToast.show({ message: 'Default (5s)', duration: 5000 })">Default (5s)</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="SOToast.show({ message: 'Long (10s)', duration: 10000 })">Long (10s)</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="SOToast.show({ message: 'Persistent - close manually', autohide: false })">Persistent</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('toast-duration', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Auto-dismiss after 5 seconds (default)
UiEngine::toast()
    ->message('Auto-dismiss toast')
    ->autoDismiss(5000);

// Persistent toast (no auto-dismiss)
UiEngine::toast()
    ->message('This stays until dismissed')
    ->persistent();

// Custom duration
UiEngine::toast()
    ->message('Quick notification')
    ->autoDismiss(2000); // 2 seconds"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Auto-dismiss after 5 seconds (default)
SOToast.show({
    message: 'Auto-dismiss toast',
    duration: 5000
});

// Persistent toast (no auto-dismiss)
SOToast.show({
    message: 'This stays until dismissed',
    autohide: false
});

// Quick notification
SOToast.show({
    message: 'Quick notification',
    duration: 2000
});"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Auto-dismiss toast (via data attributes) -->
<div class="so-toast"
     data-so-autohide="true"
     data-so-delay="5000">
    ...
</div>

<!-- Persistent toast -->
<div class="so-toast"
     data-so-autohide="false">
    ...
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Actions -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Toast with Action Buttons</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add action buttons to toasts for user interaction.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <button type="button" class="so-btn so-btn-primary" onclick="showActionToast()">Show Toast with Actions</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('toast-actions', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Toast with actions is primarily JavaScript-driven
// The PHP class generates the base toast structure"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "SOToast.show({
    title: 'New Message',
    message: 'You have a new message from John Doe.',
    autohide: false,
    actions: `
        <button class=\"so-btn so-btn-sm so-btn-primary\">View</button>
        <button class=\"so-btn so-btn-sm so-btn-outline\" data-dismiss=\"toast\">Dismiss</button>
    `
});"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-toast" role="alert">
    <div class="so-toast-header">
        <strong class="so-me-auto">New Message</strong>
        <button type="button" class="so-btn-close" data-so-dismiss="toast"></button>
    </div>
    <div class="so-toast-body">
        <p>You have a new message from John Doe.</p>
        <div class="so-mt-2">
            <button class="so-btn so-btn-sm so-btn-primary">View</button>
            <button class="so-btn so-btn-sm so-btn-outline" data-dismiss="toast">Dismiss</button>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Stacking Toasts -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Stacking Multiple Toasts</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Multiple toasts stack automatically when shown.</p>

                <!-- Live Demo -->
                <div class="so-btn-group so-mb-4">
                    <button type="button" class="so-btn so-btn-primary" onclick="showStackedToasts()">Show Multiple Toasts</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="SOToast.clear()">Clear All</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('toast-stack', [
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Multiple toasts stack automatically
SOToast.success('File uploaded');
SOToast.info('Processing...');
SOToast.success('Complete!');

// Clear all toasts
SOToast.clear();

// Clear by position
SOToast.clear('top-right');

// Clear by type
SOToast.clearByType('success');

// Get active toast count
SOToast.getCount();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Toast container with multiple stacked toasts -->
<div class="so-toast-container so-toast-top-right">
    <div class="so-toast so-toast-success so-show">
        <div class="so-toast-body">File uploaded</div>
    </div>
    <div class="so-toast so-toast-info so-show">
        <div class="so-toast-body">Processing...</div>
    </div>
    <div class="so-toast so-toast-success so-show">
        <div class="so-toast-body">Complete!</div>
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
                                <td><code>title()</code></td>
                                <td><code>string $title</code></td>
                                <td>Set toast title</td>
                            </tr>
                            <tr>
                                <td><code>message()</code></td>
                                <td><code>string $message</code></td>
                                <td>Set toast message</td>
                            </tr>
                            <tr>
                                <td><code>variant()</code></td>
                                <td><code>string $variant</code></td>
                                <td>Set variant: success, danger, warning, info</td>
                            </tr>
                            <tr>
                                <td><code>success()</code></td>
                                <td>-</td>
                                <td>Success variant with check icon</td>
                            </tr>
                            <tr>
                                <td><code>danger()</code></td>
                                <td>-</td>
                                <td>Danger variant with error icon</td>
                            </tr>
                            <tr>
                                <td><code>warning()</code></td>
                                <td>-</td>
                                <td>Warning variant with warning icon</td>
                            </tr>
                            <tr>
                                <td><code>info()</code></td>
                                <td>-</td>
                                <td>Info variant with info icon</td>
                            </tr>
                            <tr>
                                <td><code>icon()</code></td>
                                <td><code>string $icon</code></td>
                                <td>Set Material icon</td>
                            </tr>
                            <tr>
                                <td><code>position()</code></td>
                                <td><code>string $position</code></td>
                                <td>Set position on screen</td>
                            </tr>
                            <tr>
                                <td><code>autoDismiss()</code></td>
                                <td><code>int $ms</code></td>
                                <td>Auto-dismiss duration in ms</td>
                            </tr>
                            <tr>
                                <td><code>persistent()</code></td>
                                <td>-</td>
                                <td>Disable auto-dismiss</td>
                            </tr>
                            <tr>
                                <td><code>dismissible()</code></td>
                                <td><code>bool $dismissible</code></td>
                                <td>Show/hide close button</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">CSS Classes Reference</h5>
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
                                <td><code>.so-toast</code></td>
                                <td>Base toast container</td>
                            </tr>
                            <tr>
                                <td><code>.so-toast-header</code></td>
                                <td>Toast header section</td>
                            </tr>
                            <tr>
                                <td><code>.so-toast-body</code></td>
                                <td>Toast body section</td>
                            </tr>
                            <tr>
                                <td><code>.so-toast-success</code></td>
                                <td>Success variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-toast-danger</code></td>
                                <td>Danger variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-toast-warning</code></td>
                                <td>Warning variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-toast-info</code></td>
                                <td>Info variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-toast-container</code></td>
                                <td>Container for positioning toasts</td>
                            </tr>
                            <tr>
                                <td><code>.so-toast-top-right</code></td>
                                <td>Top-right position</td>
                            </tr>
                            <tr>
                                <td><code>.so-fade</code></td>
                                <td>Fade animation</td>
                            </tr>
                            <tr>
                                <td><code>.so-show</code></td>
                                <td>Visible state</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function showActionToast() {
    if (typeof SOToast !== 'undefined') {
        SOToast.show({
            title: 'New Message',
            message: 'You have a new message from John Doe.',
            autohide: false,
            actions: '<button class="so-btn so-btn-sm so-btn-primary">View</button> <button class="so-btn so-btn-sm so-btn-outline" data-dismiss="toast">Dismiss</button>'
        });
    } else {
        alert('SOToast is not available. This demo requires the SixOrbit Toast component.');
    }
}

function showStackedToasts() {
    if (typeof SOToast !== 'undefined') {
        SOToast.success('File uploaded');
        setTimeout(() => SOToast.info('Processing...'), 300);
        setTimeout(() => SOToast.success('Complete!'), 600);
    } else {
        alert('SOToast is not available. This demo requires the SixOrbit Toast component.');
    }
}
</script>

<?php require_once '../../includes/footer.php'; ?>
