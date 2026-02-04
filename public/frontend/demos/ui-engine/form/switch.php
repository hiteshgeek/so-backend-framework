<?php
/**
 * SixOrbit UI Engine - Switch Element Demo
 */

$pageTitle = 'Switch - UI Engine';
$pageDescription = 'Toggle switch for boolean on/off states';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Switch</h1>
            <p class="so-page-subtitle">Toggle switch element for boolean on/off states with labels, icons, and various sizes.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Switch -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Switch</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-flex so-flex-col so-gap-3">
                    <label class="so-switch">
                        <input type="checkbox" id="demo-notifications" name="notifications">
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Enable notifications</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-switch', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$switch = UiEngine::switch('notifications')
    ->label('Enable notifications');

echo \$switch->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const switchEl = UiEngine.switch('notifications')
    .label('Enable notifications');

document.getElementById('container').innerHTML = switchEl.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-switch">
    <input type="checkbox" id="notifications" name="notifications">
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Enable notifications</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Switch States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Switch States</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-flex so-flex-col so-gap-3">
                    <label class="so-switch">
                        <input type="checkbox">
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Default (Off)</span>
                    </label>
                    <label class="so-switch">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Checked (On)</span>
                    </label>
                    <label class="so-switch so-disabled">
                        <input type="checkbox" disabled>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Disabled (Off)</span>
                    </label>
                    <label class="so-switch so-disabled">
                        <input type="checkbox" checked disabled>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Disabled (On)</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('switch-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Default (Off)
UiEngine::switch('default')->label('Default (Off)');

// Checked (On)
UiEngine::switch('checked')->label('Checked (On)')->checked();

// Disabled (Off)
UiEngine::switch('disabled_off')->label('Disabled (Off)')->disabled();

// Disabled (On)
UiEngine::switch('disabled_on')->label('Disabled (On)')->checked()->disabled();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Default (Off)
UiEngine.switch('default').label('Default (Off)');

// Checked (On)
UiEngine.switch('checked').label('Checked (On)').checked();

// Disabled (Off)
UiEngine.switch('disabled_off').label('Disabled (Off)').disabled();

// Disabled (On)
UiEngine.switch('disabled_on').label('Disabled (On)').checked().disabled();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Default (Off) -->
<label class="so-switch">
    <input type="checkbox" id="default" name="default">
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Default (Off)</span>
</label>

<!-- Checked (On) -->
<label class="so-switch">
    <input type="checkbox" id="checked" name="checked" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Checked (On)</span>
</label>

<!-- Disabled (Off) -->
<label class="so-switch so-disabled">
    <input type="checkbox" id="disabled_off" name="disabled_off" disabled>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Disabled (Off)</span>
</label>

<!-- Disabled (On) -->
<label class="so-switch so-disabled">
    <input type="checkbox" id="disabled_on" name="disabled_on" checked disabled>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Disabled (On)</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Switch Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Switch Sizes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-flex so-flex-col so-gap-3">
                    <label class="so-switch so-switch-sm">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Small</span>
                    </label>
                    <label class="so-switch">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Default</span>
                    </label>
                    <label class="so-switch so-switch-lg">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Large</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('switch-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small switch
UiEngine::switch('small')->size('sm')->label('Small')->checked();

// Default switch
UiEngine::switch('default')->label('Default')->checked();

// Large switch
UiEngine::switch('large')->size('lg')->label('Large')->checked();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small switch
UiEngine.switch('small').size('sm').label('Small').checked();

// Default switch
UiEngine.switch('default').label('Default').checked();

// Large switch
UiEngine.switch('large').size('lg').label('Large').checked();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small -->
<label class="so-switch so-switch-sm">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Small</span>
</label>

<!-- Default -->
<label class="so-switch">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Default</span>
</label>

<!-- Large -->
<label class="so-switch so-switch-lg">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Large</span>
</label>'
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
                <!-- Live Demo -->
                <div class="so-flex so-gap-4 so-flex-wrap">
                    <label class="so-switch so-switch-primary">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Primary</span>
                    </label>
                    <label class="so-switch so-switch-secondary">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Secondary</span>
                    </label>
                    <label class="so-switch so-switch-success">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Success</span>
                    </label>
                    <label class="so-switch so-switch-danger">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Danger</span>
                    </label>
                    <label class="so-switch so-switch-warning">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Warning</span>
                    </label>
                    <label class="so-switch so-switch-info">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Info</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('switch-colors', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Primary (default)
UiEngine::switch('primary')->color('primary')->label('Primary')->checked();

// Secondary
UiEngine::switch('secondary')->color('secondary')->label('Secondary')->checked();

// Success
UiEngine::switch('success')->color('success')->label('Success')->checked();

// Danger
UiEngine::switch('danger')->color('danger')->label('Danger')->checked();

// Warning
UiEngine::switch('warning')->color('warning')->label('Warning')->checked();

// Info
UiEngine::switch('info')->color('info')->label('Info')->checked();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Primary (default)
UiEngine.switch('primary').color('primary').label('Primary').checked();

// Secondary
UiEngine.switch('secondary').color('secondary').label('Secondary').checked();

// Success
UiEngine.switch('success').color('success').label('Success').checked();

// Danger
UiEngine.switch('danger').color('danger').label('Danger').checked();

// Warning
UiEngine.switch('warning').color('warning').label('Warning').checked();

// Info
UiEngine.switch('info').color('info').label('Info').checked();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Primary -->
<label class="so-switch so-switch-primary">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Primary</span>
</label>

<!-- Secondary -->
<label class="so-switch so-switch-secondary">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Secondary</span>
</label>

<!-- Success -->
<label class="so-switch so-switch-success">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Success</span>
</label>

<!-- Danger -->
<label class="so-switch so-switch-danger">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Danger</span>
</label>

<!-- Warning -->
<label class="so-switch so-switch-warning">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Warning</span>
</label>

<!-- Info -->
<label class="so-switch so-switch-info">
    <input type="checkbox" checked>
    <span class="so-switch-track"></span>
    <span class="so-switch-label">Info</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Switch with Inner Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Switch with Inner Icons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-flex so-gap-4 so-flex-wrap so-items-center">
                    <label class="so-switch so-switch-icon so-switch-success">
                        <input type="checkbox">
                        <span class="so-switch-track">
                            <span class="so-switch-on"><span class="material-icons">check</span></span>
                            <span class="so-switch-off"><span class="material-icons">close</span></span>
                        </span>
                        <span class="so-switch-label">Icon switch</span>
                    </label>
                    <label class="so-switch so-switch-icon so-switch-success">
                        <input type="checkbox" checked>
                        <span class="so-switch-track">
                            <span class="so-switch-on"><span class="material-icons">check</span></span>
                            <span class="so-switch-off"><span class="material-icons">close</span></span>
                        </span>
                        <span class="so-switch-label">Checked</span>
                    </label>
                    <label class="so-switch so-switch-icon so-switch-danger">
                        <input type="checkbox" checked>
                        <span class="so-switch-track">
                            <span class="so-switch-on"><span class="material-icons">notifications_active</span></span>
                            <span class="so-switch-off"><span class="material-icons">notifications_off</span></span>
                        </span>
                        <span class="so-switch-label">Notifications</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('switch-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Switch with check/close icons
\$switch = UiEngine::switch('agree')
    ->color('success')
    ->icon()                     // Enable icon mode
    ->onIcon('check')            // Icon when on
    ->offIcon('close')           // Icon when off
    ->label('Icon switch');

// Custom notification icons
\$notifSwitch = UiEngine::switch('notifications')
    ->color('danger')
    ->icon()
    ->onIcon('notifications_active')
    ->offIcon('notifications_off')
    ->label('Notifications')
    ->checked();

echo \$switch->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Switch with check/close icons
const switchEl = UiEngine.switch('agree')
    .color('success')
    .icon()
    .onIcon('check')
    .offIcon('close')
    .label('Icon switch');

// Custom notification icons
const notifSwitch = UiEngine.switch('notifications')
    .color('danger')
    .icon()
    .onIcon('notifications_active')
    .offIcon('notifications_off')
    .label('Notifications')
    .checked();

document.getElementById('container').innerHTML = switchEl.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-switch so-switch-icon so-switch-success">
    <input type="checkbox">
    <span class="so-switch-track">
        <span class="so-switch-on"><span class="material-icons">check</span></span>
        <span class="so-switch-off"><span class="material-icons">close</span></span>
    </span>
    <span class="so-switch-label">Icon switch</span>
</label>

<label class="so-switch so-switch-icon so-switch-danger">
    <input type="checkbox" checked>
    <span class="so-switch-track">
        <span class="so-switch-on"><span class="material-icons">notifications_active</span></span>
        <span class="so-switch-off"><span class="material-icons">notifications_off</span></span>
    </span>
    <span class="so-switch-label">Notifications</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Switch with Inner Text -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Switch with Inner Text</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-flex so-gap-4 so-flex-wrap so-items-center">
                    <label class="so-switch so-switch-text so-switch-success">
                        <input type="checkbox">
                        <span class="so-switch-track">
                            <span class="so-switch-on">ON</span>
                            <span class="so-switch-off">OFF</span>
                        </span>
                        <span class="so-switch-label">Text switch</span>
                    </label>
                    <label class="so-switch so-switch-text so-switch-success">
                        <input type="checkbox" checked>
                        <span class="so-switch-track">
                            <span class="so-switch-on">ON</span>
                            <span class="so-switch-off">OFF</span>
                        </span>
                        <span class="so-switch-label">Checked</span>
                    </label>
                    <label class="so-switch so-switch-text so-switch-primary">
                        <input type="checkbox" checked>
                        <span class="so-switch-track">
                            <span class="so-switch-on">YES</span>
                            <span class="so-switch-off">NO</span>
                        </span>
                        <span class="so-switch-label">Yes/No</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('switch-text', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// ON/OFF text switch
\$switch = UiEngine::switch('status')
    ->color('success')
    ->text()                     // Enable text mode
    ->onText('ON')               // Text when on
    ->offText('OFF')             // Text when off
    ->label('Text switch');

// YES/NO variant
\$yesNo = UiEngine::switch('agree')
    ->color('primary')
    ->text()
    ->onText('YES')
    ->offText('NO')
    ->label('Yes/No')
    ->checked();

echo \$switch->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// ON/OFF text switch
const switchEl = UiEngine.switch('status')
    .color('success')
    .text()
    .onText('ON')
    .offText('OFF')
    .label('Text switch');

// YES/NO variant
const yesNo = UiEngine.switch('agree')
    .color('primary')
    .text()
    .onText('YES')
    .offText('NO')
    .label('Yes/No')
    .checked();

document.getElementById('container').innerHTML = switchEl.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-switch so-switch-text so-switch-success">
    <input type="checkbox">
    <span class="so-switch-track">
        <span class="so-switch-on">ON</span>
        <span class="so-switch-off">OFF</span>
    </span>
    <span class="so-switch-label">Text switch</span>
</label>

<label class="so-switch so-switch-text so-switch-primary">
    <input type="checkbox" checked>
    <span class="so-switch-track">
        <span class="so-switch-on">YES</span>
        <span class="so-switch-off">NO</span>
    </span>
    <span class="so-switch-label">Yes/No</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Settings Example -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Settings Example</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-list-group">
                    <div class="so-list-group-item so-d-flex so-justify-content-between so-align-items-center">
                        <div>
                            <div class="so-fw-medium">Email Notifications</div>
                            <small class="so-text-muted">Receive email updates about your account</small>
                        </div>
                        <label class="so-switch so-switch-success so-mb-0">
                            <input type="checkbox" checked>
                            <span class="so-switch-track"></span>
                        </label>
                    </div>
                    <div class="so-list-group-item so-d-flex so-justify-content-between so-align-items-center">
                        <div>
                            <div class="so-fw-medium">SMS Notifications</div>
                            <small class="so-text-muted">Receive text messages for important alerts</small>
                        </div>
                        <label class="so-switch so-switch-success so-mb-0">
                            <input type="checkbox">
                            <span class="so-switch-track"></span>
                        </label>
                    </div>
                    <div class="so-list-group-item so-d-flex so-justify-content-between so-align-items-center">
                        <div>
                            <div class="so-fw-medium">Two-Factor Authentication</div>
                            <small class="so-text-muted">Add an extra layer of security</small>
                        </div>
                        <label class="so-switch so-switch-success so-mb-0">
                            <input type="checkbox" checked>
                            <span class="so-switch-track"></span>
                        </label>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('switch-settings', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$settings = [
    UiEngine::switch('email_notifications')
        ->color('success')
        ->checked()
        ->title('Email Notifications')
        ->description('Receive email updates about your account'),
    UiEngine::switch('sms_notifications')
        ->color('success')
        ->title('SMS Notifications')
        ->description('Receive text messages for important alerts'),
    UiEngine::switch('two_factor')
        ->color('success')
        ->checked()
        ->title('Two-Factor Authentication')
        ->description('Add an extra layer of security'),
];

foreach (\$settings as \$switch) {
    echo \$switch->renderSettingItem();
}"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const settings = [
    UiEngine.switch('email_notifications')
        .color('success')
        .checked()
        .title('Email Notifications')
        .description('Receive email updates about your account'),
    UiEngine.switch('sms_notifications')
        .color('success')
        .title('SMS Notifications')
        .description('Receive text messages for important alerts'),
    UiEngine.switch('two_factor')
        .color('success')
        .checked()
        .title('Two-Factor Authentication')
        .description('Add an extra layer of security'),
];

const html = settings.map(s => s.toSettingItem()).join('');
document.getElementById('settings-list').innerHTML = html;"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-list-group">
    <div class="so-list-group-item so-d-flex so-justify-content-between so-align-items-center">
        <div>
            <div class="so-fw-medium">Email Notifications</div>
            <small class="so-text-muted">Receive email updates about your account</small>
        </div>
        <label class="so-switch so-switch-success so-mb-0">
            <input type="checkbox" checked>
            <span class="so-switch-track"></span>
        </label>
    </div>
    <div class="so-list-group-item so-d-flex so-justify-content-between so-align-items-center">
        <div>
            <div class="so-fw-medium">SMS Notifications</div>
            <small class="so-text-muted">Receive text messages for important alerts</small>
        </div>
        <label class="so-switch so-switch-success so-mb-0">
            <input type="checkbox">
            <span class="so-switch-track"></span>
        </label>
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
                <!-- API Tabs -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-php">PHP Class</button>
                    <button class="so-tab" role="tab" data-so-target="#api-js">JS UiEngine</button>
                </div>

                <div class="so-tab-content">
                    <!-- PHP Class Reference -->
                    <div class="so-tab-pane so-fade so-show so-active" id="api-php" role="tabpanel">
                        <h5 class="so-mt-3">Core\\UiEngine\\Elements\\Form\\SwitchElement</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine::switch(string $name)</code></td>
                                        <td>Create switch with name</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">State Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>checked(bool $checked = true)</code></td>
                                        <td>Set checked state</td>
                                    </tr>
                                    <tr>
                                        <td><code>unchecked()</code></td>
                                        <td>Set unchecked state</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Variant Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>variant(string $variant)</code></td>
                                        <td>Set variant/color</td>
                                    </tr>
                                    <tr>
                                        <td><code>color(string $color)</code></td>
                                        <td>Alias for variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>primary()</code></td>
                                        <td>Primary variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>secondary()</code></td>
                                        <td>Secondary variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>success()</code></td>
                                        <td>Success variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>danger()</code></td>
                                        <td>Danger variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>warning()</code></td>
                                        <td>Warning variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>info()</code></td>
                                        <td>Info variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>size(string $size)</code></td>
                                        <td>Set size (sm, lg)</td>
                                    </tr>
                                    <tr>
                                        <td><code>small()</code></td>
                                        <td>Small size shortcut</td>
                                    </tr>
                                    <tr>
                                        <td><code>large()</code></td>
                                        <td>Large size shortcut</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Display Mode Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>icon(bool $enable = true)</code></td>
                                        <td>Enable icon mode</td>
                                    </tr>
                                    <tr>
                                        <td><code>onIcon(string $icon)</code></td>
                                        <td>Set on state icon (Material icon name)</td>
                                    </tr>
                                    <tr>
                                        <td><code>offIcon(string $icon)</code></td>
                                        <td>Set off state icon</td>
                                    </tr>
                                    <tr>
                                        <td><code>text(bool $enable = true)</code></td>
                                        <td>Enable text mode</td>
                                    </tr>
                                    <tr>
                                        <td><code>onText(string $text)</code></td>
                                        <td>Set on state text (e.g., 'ON', 'YES')</td>
                                    </tr>
                                    <tr>
                                        <td><code>offText(string $text)</code></td>
                                        <td>Set off state text (e.g., 'OFF', 'NO')</td>
                                    </tr>
                                    <tr>
                                        <td><code>labels(string $on, string $off)</code></td>
                                        <td>Set both on/off labels</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Inherited Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>name(string $name)</code></td>
                                        <td>Set input name</td>
                                    </tr>
                                    <tr>
                                        <td><code>id(string $id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>label(string $label)</code></td>
                                        <td>Set label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code></td>
                                        <td>Disable the switch</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>Render switch HTML</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray()</code></td>
                                        <td>Export configuration array</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JS UiEngine Reference -->
                    <div class="so-tab-pane so-fade" id="api-js" role="tabpanel">
                        <h5 class="so-mt-3">UiEngine.switch()</h5>
                        <p class="so-text-muted">Extends FormElement (Toggle class)</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine.switch(name)</code></td>
                                        <td>Create switch with name</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">State Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>checked(val = true)</code></td>
                                        <td>Set checked state</td>
                                    </tr>
                                    <tr>
                                        <td><code>unchecked()</code></td>
                                        <td>Set unchecked state</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Variant Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>variant(v)</code></td>
                                        <td>Set variant/color</td>
                                    </tr>
                                    <tr>
                                        <td><code>color(c)</code></td>
                                        <td>Alias for variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>primary()</code></td>
                                        <td>Primary variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>secondary()</code></td>
                                        <td>Secondary variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>success()</code></td>
                                        <td>Success variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>danger()</code></td>
                                        <td>Danger variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>warning()</code></td>
                                        <td>Warning variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>info()</code></td>
                                        <td>Info variant</td>
                                    </tr>
                                    <tr>
                                        <td><code>size(size)</code></td>
                                        <td>Set size (sm, lg)</td>
                                    </tr>
                                    <tr>
                                        <td><code>small()</code></td>
                                        <td>Small size shortcut</td>
                                    </tr>
                                    <tr>
                                        <td><code>large()</code></td>
                                        <td>Large size shortcut</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Display Mode Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>icon(enable = true)</code></td>
                                        <td>Enable icon mode</td>
                                    </tr>
                                    <tr>
                                        <td><code>onIcon(icon)</code></td>
                                        <td>Set on state icon</td>
                                    </tr>
                                    <tr>
                                        <td><code>offIcon(icon)</code></td>
                                        <td>Set off state icon</td>
                                    </tr>
                                    <tr>
                                        <td><code>text(enable = true)</code></td>
                                        <td>Enable text mode</td>
                                    </tr>
                                    <tr>
                                        <td><code>onText(text)</code></td>
                                        <td>Set on state text</td>
                                    </tr>
                                    <tr>
                                        <td><code>offText(text)</code></td>
                                        <td>Set off state text</td>
                                    </tr>
                                    <tr>
                                        <td><code>labels(on, off)</code></td>
                                        <td>Set both on/off labels</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Inherited Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>name(name)</code></td>
                                        <td>Set input name</td>
                                    </tr>
                                    <tr>
                                        <td><code>id(id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>label(label)</code></td>
                                        <td>Set label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code></td>
                                        <td>Disable the switch</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr(name, value)</code></td>
                                        <td>Set custom attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>data(key, value)</code></td>
                                        <td>Set data-* attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>toHtml()</code></td>
                                        <td>Get HTML string</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>Render to DOM element</td>
                                    </tr>
                                    <tr>
                                        <td><code>toConfig()</code></td>
                                        <td>Export configuration object</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Interactivity Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>toggle()</code></td>
                                        <td>Toggle the switch state</td>
                                    </tr>
                                    <tr>
                                        <td><code>isChecked()</code></td>
                                        <td>Get current checked state (boolean)</td>
                                    </tr>
                                    <tr>
                                        <td><code>setChecked(val)</code></td>
                                        <td>Set checked state programmatically</td>
                                    </tr>
                                    <tr>
                                        <td><code>onChange(callback)</code></td>
                                        <td>Listen to change events. Callback receives (checked, event)</td>
                                    </tr>
                                    <tr>
                                        <td><code>addClass(cls)</code></td>
                                        <td>Add CSS class to switch wrapper</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeClass(cls)</code></td>
                                        <td>Remove CSS class from switch wrapper</td>
                                    </tr>
                                    <tr>
                                        <td><code>setId(id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr(name, value)</code></td>
                                        <td>Set custom attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>data(key, value)</code></td>
                                        <td>Set data-* attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>on(event, callback)</code></td>
                                        <td>Attach event listener</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Events</h6>
                        <p class="so-text-muted so-mb-2">Switches use native HTML checkbox events:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Event</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>change</code></td>
                                        <td>Fires when switch state changes (after interaction completes)</td>
                                    </tr>
                                    <tr>
                                        <td><code>input</code></td>
                                        <td>Fires immediately on input change</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <h5 class="so-mt-6 so-mb-3">CSS Classes Reference</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr>
                                <th style="width:40%">Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-switch</code></td>
                                <td>Base switch wrapper (label element)</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-track</code></td>
                                <td>The toggle track/slider</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-label</code></td>
                                <td>Label text next to switch</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-on</code></td>
                                <td>Content shown when on (inside track)</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-off</code></td>
                                <td>Content shown when off (inside track)</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-{size}</code></td>
                                <td>Size variants (sm, lg)</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-{color}</code></td>
                                <td>Color variants (primary, secondary, success, danger, warning, info)</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-icon</code></td>
                                <td>Enable icon display inside track</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-text</code></td>
                                <td>Enable text display inside track</td>
                            </tr>
                            <tr>
                                <td><code>.so-switch-icon-text</code></td>
                                <td>Enable icon + text display inside track</td>
                            </tr>
                            <tr>
                                <td><code>.so-disabled</code></td>
                                <td>Disabled state</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
