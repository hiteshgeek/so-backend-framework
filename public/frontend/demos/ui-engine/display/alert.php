<?php
/**
 * SixOrbit UI Engine - Alert Element Demo
 */

$pageTitle = 'Alert - UI Engine';
$pageDescription = 'Contextual feedback messages for user actions';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Alert</h1>
            <p class="so-page-subtitle">Contextual feedback messages for user actions and important notifications.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Alerts -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Alerts</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-alert so-alert-primary so-mb-3">
                    <span class="so-alert-icon"><span class="material-icons">lightbulb</span></span>
                    <div class="so-alert-content">
                        <strong>Primary Alert</strong>
                        This is a primary alert for tips and highlights.
                    </div>
                </div>
                <div class="so-alert so-alert-success so-mb-3">
                    <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
                    <div class="so-alert-content">
                        <strong>Success Alert</strong>
                        Operation completed successfully!
                    </div>
                </div>
                <div class="so-alert so-alert-warning so-mb-3">
                    <span class="so-alert-icon"><span class="material-icons">warning</span></span>
                    <div class="so-alert-content">
                        <strong>Warning Alert</strong>
                        Please review your changes before proceeding.
                    </div>
                </div>
                <div class="so-alert so-alert-danger so-mb-3">
                    <span class="so-alert-icon"><span class="material-icons">error</span></span>
                    <div class="so-alert-content">
                        <strong>Danger Alert</strong>
                        Something went wrong. Please try again.
                    </div>
                </div>
                <div class="so-alert so-alert-info so-mb-4">
                    <span class="so-alert-icon"><span class="material-icons">info</span></span>
                    <div class="so-alert-content">
                        <strong>Info Alert</strong>
                        Here's some helpful information you might need.
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-alerts', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

echo UiEngine::alert('Operation completed successfully!')
    ->variant('success')
    ->title('Success Alert')
    ->icon('check_circle');

echo UiEngine::alert('Something went wrong. Please try again.')
    ->variant('danger')
    ->title('Danger Alert')
    ->icon('error');

// Available variants: primary, secondary, success, danger, warning, info, light, dark"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.alert('Operation completed successfully!')
    .variant('success')
    .title('Success Alert')
    .icon('check_circle')
    .toHtml();

UiEngine.alert('Something went wrong. Please try again.')
    .variant('danger')
    .title('Danger Alert')
    .icon('error')
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-alert so-alert-success">
    <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
    <div class="so-alert-content">
        <strong>Success Alert</strong>
        Operation completed successfully!
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Dismissible Alerts -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Dismissible Alerts</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Add <code>.so-alert-dismissible</code> and a close button to make alerts dismissible.</p>
                <!-- Live Demo -->
                <div class="so-alert so-alert-info so-alert-dismissible so-mb-3">
                    <span class="so-alert-icon"><span class="material-icons">info</span></span>
                    <div class="so-alert-content">
                        <strong>Dismissible Info</strong>
                        Click the X button to dismiss this alert.
                    </div>
                    <button type="button" class="so-alert-close" data-dismiss="alert" aria-label="Close">
                        <span class="material-icons">close</span>
                    </button>
                </div>
                <div class="so-alert so-alert-warning so-alert-dismissible so-mb-4">
                    <span class="so-alert-icon"><span class="material-icons">warning</span></span>
                    <div class="so-alert-content">
                        <strong>Session Expiring</strong>
                        Your session will expire in 5 minutes. Save your work.
                    </div>
                    <button type="button" class="so-alert-close" data-dismiss="alert" aria-label="Close">
                        <span class="material-icons">close</span>
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('alert-dismissible', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$alert = UiEngine::alert('Your session will expire in 5 minutes.')
    ->variant('warning')
    ->title('Session Expiring')
    ->icon('warning')
    ->dismissible();

echo \$alert->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const alert = UiEngine.alert('Your session will expire in 5 minutes.')
    .variant('warning')
    .title('Session Expiring')
    .icon('warning')
    .dismissible();

document.getElementById('container').innerHTML = alert.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-alert so-alert-warning so-alert-dismissible">
    <span class="so-alert-icon"><span class="material-icons">warning</span></span>
    <div class="so-alert-content">
        <strong>Session Expiring</strong>
        Your session will expire in 5 minutes.
    </div>
    <button type="button" class="so-alert-close" data-dismiss="alert">
        <span class="material-icons">close</span>
    </button>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Outline Alerts -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Outline Alerts</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Add <code>.so-alert-outline</code> for a lighter, border-only style.</p>
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-3 so-mb-4">
                    <div class="so-alert so-alert-primary so-alert-outline">
                        <span class="so-alert-icon"><span class="material-icons">lightbulb</span></span>
                        <div>Primary outline alert</div>
                    </div>
                    <div class="so-alert so-alert-success so-alert-outline">
                        <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
                        <div>Success outline alert</div>
                    </div>
                    <div class="so-alert so-alert-warning so-alert-outline">
                        <span class="so-alert-icon"><span class="material-icons">warning</span></span>
                        <div>Warning outline alert</div>
                    </div>
                    <div class="so-alert so-alert-danger so-alert-outline">
                        <span class="so-alert-icon"><span class="material-icons">error</span></span>
                        <div>Danger outline alert</div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('alert-outline', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::alert('Primary outline alert')
    ->variant('primary')
    ->icon('lightbulb')
    ->outline();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.alert('Primary outline alert')
    .variant('primary')
    .icon('lightbulb')
    .outline()
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-alert so-alert-primary so-alert-outline">
    <span class="so-alert-icon"><span class="material-icons">lightbulb</span></span>
    <div>Primary outline alert</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Alert Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Alert Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Use <code>.so-alert-sm</code> for a compact alert.</p>
                <!-- Live Demo -->
                <div class="so-alert so-alert-info so-alert-sm so-mb-3">
                    <span class="so-alert-icon"><span class="material-icons">info</span></span>
                    <div class="so-alert-content">
                        <strong>Small Alert</strong>
                        This is a compact alert with smaller padding.
                    </div>
                </div>
                <div class="so-alert so-alert-info so-mb-4">
                    <span class="so-alert-icon"><span class="material-icons">info</span></span>
                    <div class="so-alert-content">
                        <strong>Default Alert</strong>
                        This is a standard alert with default padding.
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('alert-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small alert
UiEngine::alert('This is a compact alert.')
    ->variant('info')
    ->title('Small Alert')
    ->icon('info')
    ->small();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small alert
UiEngine.alert('This is a compact alert.')
    .variant('info')
    .title('Small Alert')
    .icon('info')
    .small()
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-alert so-alert-info so-alert-sm">
    <span class="so-alert-icon"><span class="material-icons">info</span></span>
    <div class="so-alert-content">
        <strong>Small Alert</strong>
        This is a compact alert with smaller padding.
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Additional Content -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Additional Content</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Alerts can contain headings, paragraphs, lists, and links.</p>
                <!-- Live Demo -->
                <div class="so-alert so-alert-success so-mb-4">
                    <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
                    <div class="so-alert-content">
                        <h4 class="so-alert-heading">Well done!</h4>
                        <p>You have successfully completed the registration process. Your account is now active and ready to use.</p>
                        <hr>
                        <p class="so-mb-0">Need help? <a href="#" class="so-alert-link">Contact support</a> for assistance.</p>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('alert-content', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$alert = UiEngine::alert()
    ->variant('success')
    ->icon('check_circle')
    ->title('Well done!')
    ->content('You have successfully completed the registration process. Your account is now active and ready to use.')
    ->footer('Need help? <a href=\"#\" class=\"so-alert-link\">Contact support</a> for assistance.');

echo \$alert->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const alert = UiEngine.alert()
    .variant('success')
    .icon('check_circle')
    .title('Well done!')
    .content('You have successfully completed the registration process.')
    .footer('Need help? <a href=\"#\" class=\"so-alert-link\">Contact support</a>');

document.getElementById('container').innerHTML = alert.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-alert so-alert-success">
    <span class="so-alert-icon"><span class="material-icons">check_circle</span></span>
    <div class="so-alert-content">
        <h4 class="so-alert-heading">Well done!</h4>
        <p>You have successfully completed...</p>
        <hr>
        <p>Need help? <a href="#" class="so-alert-link">Contact support</a></p>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <?= so_tabs('alert-api-tabs', [
                    [
                        'id' => 'configuration-methods',
                        'label' => 'Configuration Methods',
                        'icon' => 'settings',
                        'active' => true,
                        'content' => '<div class="so-table-responsive">
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
                                        <td><code>variant()</code></td>
                                        <td><code>string $variant</code></td>
                                        <td>Set variant: primary, secondary, success, danger, warning, info, light, dark</td>
                                    </tr>
                                    <tr>
                                        <td><code>primary()</code>, <code>success()</code>, etc.</td>
                                        <td>-</td>
                                        <td>Shortcut methods for each variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>title()</code></td>
                                        <td><code>string $title</code></td>
                                        <td>Set alert heading (wrapped in <code>&lt;strong&gt;</code>)</td>
                                    </tr>
                                    <tr>
                                        <td><code>message()</code></td>
                                        <td><code>string $message</code></td>
                                        <td>Set alert message text</td>
                                    </tr>
                                    <tr>
                                        <td><code>content()</code></td>
                                        <td><code>string $content</code></td>
                                        <td>Alias for message() - set alert body content</td>
                                    </tr>
                                    <tr>
                                        <td><code>icon()</code></td>
                                        <td><code>string $icon</code></td>
                                        <td>Add Material icon to alert</td>
                                    </tr>
                                    <tr>
                                        <td><code>dismissible()</code></td>
                                        <td><code>bool $dismissible = true</code></td>
                                        <td>Make alert dismissible with close button</td>
                                    </tr>
                                    <tr>
                                        <td><code>autoDismiss()</code></td>
                                        <td><code>int $seconds</code></td>
                                        <td>Auto-dismiss alert after specified seconds</td>
                                    </tr>
                                    <tr>
                                        <td><code>outline()</code></td>
                                        <td><code>bool $outline = true</code></td>
                                        <td>Use outline style (border-only)</td>
                                    </tr>
                                    <tr>
                                        <td><code>small()</code></td>
                                        <td><code>bool $small = true</code></td>
                                        <td>Use compact size</td>
                                    </tr>
                                    <tr>
                                        <td><code>footer()</code></td>
                                        <td><code>string $content</code></td>
                                        <td>Add footer content with <code>&lt;hr&gt;</code> separator</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>'
                    ],
                    [
                        'id' => 'interactivity-methods',
                        'label' => 'Interactivity Methods',
                        'icon' => 'touch_app',
                        'content' => '<p class="so-text-muted so-mb-3">These methods are available in JavaScript for runtime manipulation:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Returns</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>show()</code></td>
                                        <td>-</td>
                                        <td><code>this</code></td>
                                        <td>Show the alert if hidden</td>
                                    </tr>
                                    <tr>
                                        <td><code>hide()</code></td>
                                        <td>-</td>
                                        <td><code>this</code></td>
                                        <td>Hide the alert (non-destructive)</td>
                                    </tr>
                                    <tr>
                                        <td><code>close()</code></td>
                                        <td>-</td>
                                        <td><code>this</code></td>
                                        <td>Close/dismiss alert (removes from DOM)</td>
                                    </tr>
                                    <tr>
                                        <td><code>dismiss()</code></td>
                                        <td>-</td>
                                        <td><code>this</code></td>
                                        <td>Alias for close()</td>
                                    </tr>
                                    <tr>
                                        <td><code>setVariant()</code></td>
                                        <td><code>variant: string</code></td>
                                        <td><code>this</code></td>
                                        <td>Change alert variant at runtime</td>
                                    </tr>
                                    <tr>
                                        <td><code>setMessage()</code></td>
                                        <td><code>message: string</code></td>
                                        <td><code>this</code></td>
                                        <td>Update alert message</td>
                                    </tr>
                                    <tr>
                                        <td><code>setTitle()</code></td>
                                        <td><code>title: string</code></td>
                                        <td><code>this</code></td>
                                        <td>Update alert title</td>
                                    </tr>
                                    <tr>
                                        <td><code>setIcon()</code></td>
                                        <td><code>icon: string</code></td>
                                        <td><code>this</code></td>
                                        <td>Change alert icon</td>
                                    </tr>
                                    <tr>
                                        <td><code>toggleOutline()</code></td>
                                        <td><code>enable?: boolean</code></td>
                                        <td><code>this</code></td>
                                        <td>Toggle outline style on/off</td>
                                    </tr>
                                    <tr>
                                        <td><code>toggleSmall()</code></td>
                                        <td><code>enable?: boolean</code></td>
                                        <td><code>this</code></td>
                                        <td>Toggle small size on/off</td>
                                    </tr>
                                    <tr>
                                        <td><code>isVisible()</code></td>
                                        <td>-</td>
                                        <td><code>boolean</code></td>
                                        <td>Check if alert is currently visible</td>
                                    </tr>
                                    <tr>
                                        <td><code>getVariant()</code></td>
                                        <td>-</td>
                                        <td><code>string</code></td>
                                        <td>Get current variant</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        ' . so_code_tabs('alert-interactivity', [
                            [
                                'label' => 'JavaScript',
                                'language' => 'javascript',
                                'icon' => 'javascript',
                                'code' => "// Create and render alert
const alert = UiEngine.alert('File uploaded successfully!')
    .variant('success')
    .title('Success')
    .icon('check_circle');

document.getElementById('container').appendChild(alert.render());

// Runtime manipulation
alert.setMessage('File processing complete!');
alert.setVariant('info');
alert.setIcon('info');

// Toggle styles
alert.toggleOutline(true);
alert.toggleSmall(true);

// Check state
if (alert.isVisible()) {
    console.log('Alert is visible');
}

// Hide/show
alert.hide();  // Hide without removing
alert.show();  // Show again

// Close (remove from DOM)
alert.close();"
                            ],
                        ])
                    ],
                    [
                        'id' => 'events',
                        'label' => 'Events',
                        'icon' => 'event',
                        'content' => '<p class="so-text-muted so-mb-3">Alert dispatches custom events with the <code>so:</code> prefix:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so:alert:close</code></td>
                                        <td>Fired before alert closes (cancelable)</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:alert:closed</code></td>
                                        <td>Fired after alert has been closed</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Event Listener Methods (JS)</h5>
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
                                        <td><code>onClose()</code></td>
                                        <td><code>callback: Function</code></td>
                                        <td>Listen to close events</td>
                                    </tr>
                                    <tr>
                                        <td><code>onClosed()</code></td>
                                        <td><code>callback: Function</code></td>
                                        <td>Listen to closed events</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        ' . so_code_tabs('alert-events', [
                            [
                                'label' => 'JavaScript',
                                'language' => 'javascript',
                                'icon' => 'javascript',
                                'code' => "const alert = UiEngine.alert('Important message')
    .variant('warning')
    .dismissible()
    .onClose((e) => {
        console.log('Alert is closing');
        // Prevent closing if needed
        // e.preventDefault();
    })
    .onClosed(() => {
        console.log('Alert has been closed');
    });

// Or listen via standard addEventListener
alert.element.addEventListener('so:alert:close', (e) => {
    console.log('Close event:', e);
    // Can prevent default here
    if (someCondition) {
        e.preventDefault(); // Cancel close
    }
});"
                            ],
                        ])
                    ]
                ]) ?>
            </div>
        </div>

        <!-- DOM Structure Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">DOM Structure Reference</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">The alert generates the following HTML structure:</p>
                <?= so_code_tabs('alert-dom', [
                    [
                        'label' => 'HTML Structure',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-alert so-alert-success" role="alert">
    <span class="so-alert-icon">
        <span class="material-icons">check_circle</span>
    </span>
    <div class="so-alert-content">
        <strong>Success!</strong>
        Your changes have been saved.
    </div>
</div>

<!-- Dismissible alert -->
<div class="so-alert so-alert-warning so-alert-dismissible" role="alert">
    <span class="so-alert-icon">
        <span class="material-icons">warning</span>
    </span>
    <div class="so-alert-content">
        <strong>Warning</strong>
        Please review your input.
    </div>
    <button type="button" class="so-alert-close" data-dismiss="alert" aria-label="Close">
        <span class="material-icons">close</span>
    </button>
</div>'
                    ],
                    [
                        'label' => 'CSS Classes',
                        'language' => 'text',
                        'icon' => 'style',
                        'code' => 'so-alert                - Base alert class
so-alert-{variant}      - Variant (primary, success, warning, etc.)
so-alert-icon           - Icon wrapper
so-alert-content        - Content wrapper
so-alert-dismissible    - Dismissible alert
so-alert-close          - Close button
so-alert-outline        - Outline style
so-alert-sm             - Small/compact size
so-alert-heading        - Heading style (for h4/h5/h6)
so-alert-link           - Link style within alert'
                    ],
                    [
                        'label' => 'Attributes',
                        'language' => 'text',
                        'icon' => 'data_object',
                        'code' => 'role="alert"              - ARIA role for accessibility
data-dismiss="alert"     - Trigger close on click
data-so-auto-dismiss     - Auto-dismiss after N seconds
aria-label="Close"       - Accessibility label for close button'
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
