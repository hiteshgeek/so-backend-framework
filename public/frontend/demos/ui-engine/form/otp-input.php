<?php
/**
 * SixOrbit UI Engine - OTP Input Element Demo
 * Comprehensive documentation with all sections
 */

$pageTitle = 'OTP Input - UI Engine';
$pageDescription = 'One-time password input with auto-focus, paste support, and validation';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">OTP Input</h1>
            <p class="so-page-subtitle">One-time password input element with automatic focus navigation, paste support, and validation.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic OTP Input -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic OTP Input</h3>
            </div>
            <div class="so-card-body">
                <p class="so-mb-3">Default 6-digit OTP input with automatic focus advancement and paste support.</p>

                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">Enter verification code</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-basic-otp" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"inputType":"text","masked":false,"autoSubmit":false,"autoFocus":false,"allowPaste":true}'>
                        <input type="hidden" class="so-otp-value" name="verification_code">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="3">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="4">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="5">
                        </div>
                    </div>
                    <div class="so-form-hint so-mt-2">Enter the 6-digit code sent to your phone</div>
                </div>

                <?= so_code_tabs('basic-otp', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

// Basic 6-digit OTP input
\$otp = UiEngine::otpInput('verification_code')
    ->label('Enter verification code')
    ->help('Enter the 6-digit code sent to your phone');

echo \$otp->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Create OTP input using UiEngine
const otp = UiEngine.otpInput('verification_code')
    .label('Enter verification code')
    .help('Enter the 6-digit code sent to your phone');

document.getElementById('container').appendChild(otp.renderGroup());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-otp-group so-otp-group-default" data-so-ui-init="otp-input"
     data-so-ui-config=\'{"length":6,"inputType":"text","masked":false,"autoSubmit":false,"autoFocus":true,"allowPaste":true}\'>
    <input type="hidden" class="so-otp-value" name="verification_code">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code"
               inputmode="numeric" pattern="[0-9]" data-so-index="0" autofocus>
        <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code"
               inputmode="numeric" pattern="[0-9]" data-so-index="1">
        <!-- ... more inputs ... -->
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Different Lengths -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Different Lengths</h3>
            </div>
            <div class="so-card-body">
                <p class="so-mb-3">OTP inputs support various lengths with shortcut methods <code>pin4()</code> and <code>pin6()</code>.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-form-label">4-digit PIN</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-pin4" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"inputType":"text","autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="pin">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="3">
                        </div>
                    </div>
                </div>
                <div class="so-mb-4">
                    <label class="so-form-label">8-digit code</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-code8" data-so-ui-init="otp-input" data-so-ui-config='{"length":8,"inputType":"text","autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="long_code">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="3">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="4">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="5">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="6">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="7">
                        </div>
                    </div>
                </div>

                <?= so_code_tabs('otp-lengths', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// 4-digit PIN using shortcut
UiEngine::otpInput('pin')
    ->label('4-digit PIN')
    ->pin4();  // Shortcut for length(4)

// Custom 8-digit code
UiEngine::otpInput('long_code')
    ->label('8-digit code')
    ->length(8);

// 6-digit (default, explicit)
UiEngine::otpInput('code')
    ->pin6();  // Shortcut for length(6)"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// 4-digit PIN
UiEngine.otpInput('pin')
    .label('4-digit PIN')
    .pin4();

// Custom 8-digit code
UiEngine.otpInput('long_code')
    .label('8-digit code')
    .length(8);

// 6-digit (explicit)
UiEngine.otpInput('code')
    .pin6();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- 4-digit PIN -->
<div class="so-otp-group so-otp-group-default" data-so-ui-config=\'{"length":4}\'>
    <input type="hidden" class="so-otp-value" name="pin">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" ...>
        <input type="text" class="so-otp-input" maxlength="1" ...>
        <input type="text" class="so-otp-input" maxlength="1" ...>
        <input type="text" class="so-otp-input" maxlength="1" ...>
    </div>
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
                <p class="so-mb-3">Control input type for numeric, alphanumeric, or password (masked) OTP codes.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-form-label">Numeric Only</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-numeric" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"inputType":"number","autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="numeric_code">
                        <div class="so-otp-inputs">
                            <input type="tel" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="0">
                            <input type="tel" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="1">
                            <input type="tel" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="2">
                            <input type="tel" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="3">
                            <input type="tel" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="4">
                            <input type="tel" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="5">
                        </div>
                    </div>
                    <small class="so-text-muted">Shows numeric keyboard on mobile</small>
                </div>
                <div class="so-mb-4">
                    <label class="so-form-label">Alphanumeric</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-alphanumeric" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"inputType":"text","autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="alpha_code">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="text" pattern="[a-zA-Z0-9]" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="text" pattern="[a-zA-Z0-9]" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="text" pattern="[a-zA-Z0-9]" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="text" pattern="[a-zA-Z0-9]" data-so-index="3">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="text" pattern="[a-zA-Z0-9]" data-so-index="4">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="text" pattern="[a-zA-Z0-9]" data-so-index="5">
                        </div>
                    </div>
                    <small class="so-text-muted">Allows letters and numbers</small>
                </div>
                <div class="so-mb-4">
                    <label class="so-form-label">Password (Masked)</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-password" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"inputType":"password","masked":true,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="secure_code">
                        <div class="so-otp-inputs">
                            <input type="password" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="0">
                            <input type="password" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="1">
                            <input type="password" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="2">
                            <input type="password" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="3">
                            <input type="password" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="4">
                            <input type="password" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="5">
                        </div>
                    </div>
                    <small class="so-text-muted">Input is hidden with dots</small>
                </div>

                <?= so_code_tabs('otp-types', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Numeric only (shows numeric keyboard on mobile)
UiEngine::otpInput('numeric_code')
    ->numeric();  // inputType('number')

// Alphanumeric (letters and numbers)
UiEngine::otpInput('alpha_code')
    ->alphanumeric();  // inputType('text')

// Password/masked (shows dots)
UiEngine::otpInput('secure_code')
    ->password();  // inputType('password') + masked(true)

// Just masked (text input but hidden)
UiEngine::otpInput('hidden_code')
    ->masked();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Numeric only
UiEngine.otpInput('numeric_code').numeric();

// Alphanumeric
UiEngine.otpInput('alpha_code').alphanumeric();

// Password/masked
UiEngine.otpInput('secure_code').password();

// Just masked
UiEngine.otpInput('hidden_code').masked();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Numeric: type="tel" with inputmode="numeric" -->
<input type="tel" class="so-otp-input" inputmode="numeric" pattern="[0-9]">

<!-- Alphanumeric: type="text" with inputmode="text" -->
<input type="text" class="so-otp-input" inputmode="text" pattern="[a-zA-Z0-9]">

<!-- Password/Masked: type="password" -->
<input type="password" class="so-otp-input" inputmode="numeric" pattern="[0-9]">'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Grouped OTP -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Grouped OTP (with Separators)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-mb-3">Add visual separators for better readability with <code>groupSize()</code> or <code>grouped()</code>.</p>

                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">6-digit code (XXX-XXX)</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-grouped" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"inputType":"text","groupSize":3,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="grouped_code">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="2">
                            <span class="so-otp-separator">-</span>
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="3">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="4">
                            <input type="text" class="so-otp-input" maxlength="1" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]" data-so-index="5">
                        </div>
                    </div>
                </div>

                <?= so_code_tabs('otp-grouped', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Group size 3 (XXX-XXX)
UiEngine::otpInput('grouped_code')
    ->length(6)
    ->grouped();  // Shortcut for groupSize(3)

// Custom group size
UiEngine::otpInput('code')
    ->length(8)
    ->groupSize(4);  // XXXX-XXXX"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Group size 3
UiEngine.otpInput('grouped_code')
    .length(6)
    .grouped();

// Custom group size
UiEngine.otpInput('code')
    .length(8)
    .groupSize(4);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-otp-inputs">
    <input type="text" class="so-otp-input" data-so-index="0">
    <input type="text" class="so-otp-input" data-so-index="1">
    <input type="text" class="so-otp-input" data-so-index="2">
    <span class="so-otp-separator">-</span>
    <input type="text" class="so-otp-input" data-so-index="3">
    <input type="text" class="so-otp-input" data-so-index="4">
    <input type="text" class="so-otp-input" data-so-index="5">
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Style Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-mb-3">Different visual styles: default, outline, filled, and underline.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-form-label">Default</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-variant-default" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                        </div>
                    </div>
                </div>
                <div class="so-mb-4">
                    <label class="so-form-label">Outline</label>
                    <div class="so-otp-group so-otp-group-outline" id="demo-variant-outline" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                        </div>
                    </div>
                </div>
                <div class="so-mb-4">
                    <label class="so-form-label">Filled</label>
                    <div class="so-otp-group so-otp-group-filled" id="demo-variant-filled" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                        </div>
                    </div>
                </div>
                <div class="so-mb-4">
                    <label class="so-form-label">Underline</label>
                    <div class="so-otp-group so-otp-group-underline" id="demo-variant-underline" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                        </div>
                    </div>
                </div>

                <?= so_code_tabs('otp-variants', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Default variant
UiEngine::otpInput('code');  // or ->variant('default')

// Outline variant
UiEngine::otpInput('code')->outline();

// Filled variant
UiEngine::otpInput('code')->filled();

// Underline variant
UiEngine::otpInput('code')->underline();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Variants
UiEngine.otpInput('code');           // default
UiEngine.otpInput('code').outline();  // outline border
UiEngine.otpInput('code').filled();   // filled background
UiEngine.otpInput('code').underline(); // bottom border only"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Variant classes -->
<div class="so-otp-group so-otp-group-default">...</div>
<div class="so-otp-group so-otp-group-outline">...</div>
<div class="so-otp-group so-otp-group-filled">...</div>
<div class="so-otp-group so-otp-group-underline">...</div>'
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
                <p class="so-mb-3">Disabled, readonly, and error states for OTP inputs.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <label class="so-form-label">Disabled</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-disabled" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" disabled data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" disabled data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" disabled data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" disabled data-so-index="3">
                        </div>
                    </div>
                </div>
                <div class="so-mb-4">
                    <label class="so-form-label">Readonly (with value)</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-readonly" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" value="1234">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" readonly value="1" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" readonly value="2" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" readonly value="3" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" readonly value="4" data-so-index="3">
                        </div>
                    </div>
                </div>
                <div class="so-mb-4">
                    <label class="so-form-label">Error State</label>
                    <div class="so-otp-group so-otp-group-default so-is-invalid" id="demo-error" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input error" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input error" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input error" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input error" maxlength="1" inputmode="numeric" data-so-index="3">
                        </div>
                    </div>
                    <div class="so-invalid-feedback so-d-block">Invalid verification code</div>
                </div>

                <?= so_code_tabs('otp-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Disabled
UiEngine::otpInput('code')->disabled();

// Readonly with value
UiEngine::otpInput('code')
    ->readonly()
    ->value('1234');

// Error state
UiEngine::otpInput('code')
    ->error('Invalid verification code');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// States
UiEngine.otpInput('code').disabled();
UiEngine.otpInput('code').readonly().value('1234');
UiEngine.otpInput('code').error('Invalid code');

// Runtime error handling
const otp = SOOtpInput.getInstance('#myOtp');
otp.setError(true);   // Add error state
otp.setError(false);  // Remove error state"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Disabled inputs -->
<input type="text" class="so-otp-input" disabled>

<!-- Readonly inputs -->
<input type="text" class="so-otp-input" readonly value="1">

<!-- Error state: so-is-invalid on wrapper, error on inputs -->
<div class="so-otp-group so-otp-group-default so-is-invalid">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input error">
        ...
    </div>
</div>
<div class="so-invalid-feedback">Invalid code</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Behavior Options -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Behavior Options</h3>
            </div>
            <div class="so-card-body">
                <p class="so-mb-3">Control auto-focus, paste handling, and auto-submit behavior.</p>

                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">Auto-submit when complete</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-autosubmit" data-so-ui-init="otp-input" data-so-ui-config='{"length":4,"autoSubmit":true,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="auto_submit_code">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                        </div>
                    </div>
                    <small class="so-text-muted">Form will submit automatically when all digits are entered</small>
                </div>

                <?= so_code_tabs('otp-behavior', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Auto-focus first input on load (default: true)
UiEngine::otpInput('code')
    ->autoFocus(true);

// Disable auto-focus
UiEngine::otpInput('code')
    ->autoFocus(false);

// Auto-submit form when complete
UiEngine::otpInput('code')
    ->autoSubmit(true);

// Disable paste support
UiEngine::otpInput('code')
    ->allowPaste(false);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Behavior options
UiEngine.otpInput('code')
    .autoFocus(true)    // Focus first input on render
    .autoSubmit(true)   // Submit form when complete
    .allowPaste(true);  // Allow paste (default)

// Disable behaviors
UiEngine.otpInput('code')
    .autoFocus(false)
    .allowPaste(false);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Config passed via data attribute -->
<div class="so-otp-group so-otp-group-default"
     data-so-ui-init="otp-input"
     data-so-ui-config=\'{
         "length": 6,
         "autoFocus": true,
         "autoSubmit": true,
         "allowPaste": true
     }\'>
    ...
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
                <p class="so-mb-3">Interactive methods for getting/setting values, clearing, and controlling OTP inputs at runtime.</p>

                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">Interactive OTP Demo</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-interactive" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="interactive_code">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="4">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="5">
                        </div>
                    </div>
                    <div class="so-btn-group so-mt-3">
                        <button type="button" class="so-btn so-btn-primary so-btn-sm" onclick="setOtpValue()">Set Value (123456)</button>
                        <button type="button" class="so-btn so-btn-secondary so-btn-sm" onclick="getOtpValue()">Get Value</button>
                        <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="clearOtp()">Clear</button>
                        <button type="button" class="so-btn so-btn-info so-btn-sm" onclick="focusOtp()">Focus</button>
                    </div>
                    <div class="so-alert so-alert-info so-mt-3" id="interactiveOutput">
                        <span class="material-icons">info</span>
                        <span>Use the buttons above to interact with the OTP input</span>
                    </div>
                </div>

                <!-- Code Tabs -->
                <div class="so-tabs so-mb-3" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#js-interactivity-get">Getting Values</button>
                    <button class="so-tab" role="tab" data-so-target="#js-interactivity-set">Setting Values</button>
                    <button class="so-tab" role="tab" data-so-target="#js-interactivity-control">Control Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#js-interactivity-state">State Methods</button>
                </div>

                <div class="so-tab-content">
                    <!-- Getting Values Tab -->
                    <div class="so-tab-pane so-fade so-show so-active" id="js-interactivity-get" role="tabpanel">
                        <?= so_code_tabs('js-get-value', [
                            [
                                'label' => 'JavaScript',
                                'language' => 'javascript',
                                'icon' => 'javascript',
                                'code' => "// Get OTP instance
const otp = SOOtpInput.getInstance('#myOtp');

// Get combined value
const value = otp.getValue();
console.log('OTP value:', value);  // '123456'

// Check if complete
if (otp.isComplete()) {
    console.log('All digits entered');
}

// Get individual inputs
const inputs = otp._inputs;  // Array of input elements"
                            ],
                        ]) ?>
                    </div>

                    <!-- Setting Values Tab -->
                    <div class="so-tab-pane so-fade" id="js-interactivity-set" role="tabpanel">
                        <?= so_code_tabs('js-set-value', [
                            [
                                'label' => 'JavaScript',
                                'language' => 'javascript',
                                'icon' => 'javascript',
                                'code' => "const otp = SOOtpInput.getInstance('#myOtp');

// Set OTP value programmatically
otp.setValue('123456');

// Chain with other methods
otp.setValue('654321').focus();

// Clear all inputs
otp.clear();  // Also re-focuses first input if autoFocus is true"
                            ],
                        ]) ?>
                    </div>

                    <!-- Control Methods Tab -->
                    <div class="so-tab-pane so-fade" id="js-interactivity-control" role="tabpanel">
                        <?= so_code_tabs('js-control', [
                            [
                                'label' => 'JavaScript',
                                'language' => 'javascript',
                                'icon' => 'javascript',
                                'code' => "const otp = SOOtpInput.getInstance('#myOtp');

// Focus first empty input (or first if all filled)
otp.focus();

// Clear all inputs
otp.clear();

// Disable component
otp.disable();

// Enable component
otp.enable();

// Show/hide component
otp.hide();
otp.show();

// Destroy component
otp.destroy();"
                            ],
                        ]) ?>
                    </div>

                    <!-- State Methods Tab -->
                    <div class="so-tab-pane so-fade" id="js-interactivity-state" role="tabpanel">
                        <?= so_code_tabs('js-state', [
                            [
                                'label' => 'JavaScript',
                                'language' => 'javascript',
                                'icon' => 'javascript',
                                'code' => "const otp = SOOtpInput.getInstance('#myOtp');

// Set error state
otp.setError(true);   // Adds 'error' class to inputs
otp.setError(false);  // Removes 'error' class

// Validate against expected value
const isValid = otp.validate('123456');
// If invalid, automatically sets error state

// Check states
const complete = otp.isComplete();
const disabled = otp.isDisabled();
const visible = otp.isVisible();

// Add/remove CSS classes
otp.addClass('my-custom-class');
otp.removeClass('my-custom-class');
otp.toggleClass('highlighted', true);

// Check class
if (otp.hasClass('my-class')) { ... }"
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Validation -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-mb-3">Server-side and client-side validation for OTP inputs.</p>

                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">Enter code: <strong>123456</strong></label>
                    <div class="so-otp-group so-otp-group-default" id="demo-validation" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value" name="validated_code">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="4">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="5">
                        </div>
                    </div>
                    <div class="so-invalid-feedback" id="validation-error" style="display:none;">Invalid code entered</div>
                    <div class="so-valid-feedback" id="validation-success" style="display:none;">Code verified successfully!</div>
                    <button type="button" class="so-btn so-btn-primary so-btn-sm so-mt-3" onclick="validateOtp()">Validate</button>
                </div>

                <?= so_code_tabs('otp-validation', [
                    [
                        'label' => 'PHP (Server)',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Server-side validation
\$code = \$request->input('verification_code');

// Validate format
if (!preg_match('/^\\d{6}\$/', \$code)) {
    return back()->withErrors(['code' => 'Invalid code format']);
}

// Verify against stored code
\$storedCode = Cache::get('otp_' . \$user->id);
if (\$code !== \$storedCode) {
    return back()->withErrors(['code' => 'Invalid verification code']);
}

// Code is valid - continue
Cache::forget('otp_' . \$user->id);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const otp = SOOtpInput.getInstance('#myOtp');

// Check if complete before submitting
if (!otp.isComplete()) {
    alert('Please enter all digits');
    otp.focus();
    return;
}

// Client-side validation against expected value
const isValid = otp.validate('123456');
if (!isValid) {
    // Error state is automatically set
    console.log('Invalid OTP');
    return;
}

// Or manual validation with custom error handling
const value = otp.getValue();
if (value !== expectedCode) {
    otp.setError(true);
    showError('Invalid code');
} else {
    otp.setError(false);
    showSuccess('Code verified!');
}"
                    ],
                    [
                        'label' => 'AJAX Validation',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const otp = SOOtpInput.getInstance('#myOtp');

// Listen for complete event
otp.element.addEventListener('so:otp:complete', async (e) => {
    const code = e.detail.value;

    try {
        const response = await fetch('/api/verify-otp', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ code })
        });

        const result = await response.json();

        if (result.valid) {
            otp.setError(false);
            showSuccess('Verified!');
        } else {
            otp.setError(true);
            showError(result.message);
            otp.clear();
        }
    } catch (err) {
        otp.setError(true);
        showError('Verification failed');
    }
});"
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
                <p class="so-mb-3">Display and manage error states for OTP inputs.</p>

                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">Error handling demo</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-error-handling" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="4">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="5">
                        </div>
                    </div>
                    <div class="so-invalid-feedback" id="error-message" style="display:none;"></div>
                    <div class="so-btn-group so-mt-3">
                        <button type="button" class="so-btn so-btn-danger so-btn-sm" onclick="showOtpError('Invalid verification code')">Show Error</button>
                        <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="clearOtpError()">Clear Error</button>
                    </div>
                </div>

                <?= so_code_tabs('otp-error-handling', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Create OTP with error message
UiEngine::otpInput('code')
    ->error('Invalid verification code');

// Clear error (in form re-render)
UiEngine::otpInput('code')
    ->error(null);  // or just don't call error()"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const otp = SOOtpInput.getInstance('#myOtp');

// Show error state
otp.setError(true);

// Hide error state
otp.setError(false);

// Validate and auto-set error
const isValid = otp.validate('123456');
// If invalid, setError(true) is called automatically

// Listen for errors during input
otp.element.addEventListener('so:otp:change', (e) => {
    // Clear error when user starts typing
    otp.setError(false);
    hideErrorMessage();
});

// Display error message with element
function showError(message) {
    const errorEl = document.getElementById('error-message');
    errorEl.textContent = message;
    errorEl.style.display = 'block';
    otp.setError(true);
}

function clearError() {
    const errorEl = document.getElementById('error-message');
    errorEl.style.display = 'none';
    otp.setError(false);
}"
                    ],
                    [
                        'label' => 'CSS Classes',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Error state classes -->

<!-- On wrapper element -->
<div class="so-otp-group so-otp-group-default so-is-invalid">

<!-- On individual digit inputs (set by JS) -->
<input type="text" class="so-otp-input error">

<!-- Error message -->
<div class="so-invalid-feedback">Error message here</div>

<!-- Styling typically applies red border and text -->'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JS Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-mb-3">Pass configuration from PHP to JavaScript via data attributes for seamless server-client integration.</p>

                <?= so_code_tabs('php-to-js', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// PHP UiEngine generates data attributes
\$otp = UiEngine::otpInput('verification_code')
    ->length(6)
    ->numeric()
    ->autoSubmit(true)
    ->autoFocus(true)
    ->allowPaste(true)
    ->grouped();

echo \$otp->render();

// Output includes:
// data-so-ui-init=\"otp-input\"
// data-so-ui-config='{\"length\":6,\"inputType\":\"number\",\"autoSubmit\":true,...}'"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// JS auto-initializes from data attributes
// No manual initialization needed!

// The SOOtpInput component reads config from data-so-ui-config
// and applies all settings automatically.

// To customize after initialization:
const otp = SOOtpInput.getInstance('#myOtp');
otp.setOptions({
    numericOnly: false,  // Override config
    autoFocus: false
});

// Or access existing options:
console.log(otp.options);
// { length: 6, inputType: 'number', autoSubmit: true, ... }"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Generated by PHP -->
<div class="so-otp-group so-otp-group-default"
     data-so-ui-init="otp-input"
     data-so-ui-config=\'{"length":6,"inputType":"number","masked":false,"autoSubmit":true,"autoFocus":true,"allowPaste":true,"groupSize":3}\'>
    <input type="hidden" class="so-otp-value" name="verification_code">
    <div class="so-otp-inputs">
        <input type="tel" class="so-otp-input" maxlength="1"
               autocomplete="one-time-code" inputmode="numeric"
               pattern="[0-9]" data-so-index="0" autofocus>
        ...
        <span class="so-otp-separator">-</span>
        ...
    </div>
</div>'
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
                <p class="so-mb-3">OTP inputs emit custom events prefixed with <code>so:</code> for changes and completion.</p>

                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">Type to see events</label>
                    <div class="so-otp-group so-otp-group-default" id="demo-events" data-so-ui-init="otp-input" data-so-ui-config='{"length":6,"autoFocus":false}'>
                        <input type="hidden" class="so-otp-value">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="0">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="1">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="2">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="3">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="4">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" data-so-index="5">
                        </div>
                    </div>
                    <div class="so-alert so-alert-info so-mt-3" id="eventLog">
                        <span class="material-icons">info</span>
                        <div>
                            <strong>Event Log:</strong> <span id="eventOutput">Type in the OTP field above...</span>
                        </div>
                    </div>
                </div>

                <h5 class="so-mt-4">Available Events</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th style="width:25%">Event</th>
                                <th style="width:35%">Detail Data</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so:otp:change</code></td>
                                <td><code>{ value, index, component }</code></td>
                                <td>Fired when any digit changes. <code>index</code> is the changed digit index (undefined on paste).</td>
                            </tr>
                            <tr>
                                <td><code>so:otp:complete</code></td>
                                <td><code>{ value, component }</code></td>
                                <td>Fired when all digits are entered.</td>
                            </tr>
                            <tr>
                                <td><code>so:show</code></td>
                                <td><code>{ component }</code></td>
                                <td>Fired when component is shown (inherited).</td>
                            </tr>
                            <tr>
                                <td><code>so:hide</code></td>
                                <td><code>{ component }</code></td>
                                <td>Fired when component is hidden (inherited).</td>
                            </tr>
                            <tr>
                                <td><code>so:enable</code></td>
                                <td><code>{ component }</code></td>
                                <td>Fired when component is enabled (inherited).</td>
                            </tr>
                            <tr>
                                <td><code>so:disable</code></td>
                                <td><code>{ component }</code></td>
                                <td>Fired when component is disabled (inherited).</td>
                            </tr>
                            <tr>
                                <td><code>so:destroy</code></td>
                                <td><code>{ component }</code></td>
                                <td>Fired when component is destroyed (inherited).</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?= so_code_tabs('otp-events', [
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const otpElement = document.getElementById('myOtp');

// Listen for value changes
otpElement.addEventListener('so:otp:change', (e) => {
    console.log('Value changed:', e.detail.value);
    console.log('Changed index:', e.detail.index);  // undefined if pasted
});

// Listen for completion
otpElement.addEventListener('so:otp:complete', (e) => {
    console.log('OTP complete:', e.detail.value);

    // Auto-submit form
    e.target.closest('form')?.submit();

    // Or validate via AJAX
    validateOtp(e.detail.value);
});

// Using the instance
const otp = SOOtpInput.getInstance('#myOtp');
otp.element.addEventListener('so:otp:complete', handleComplete);"
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
                                <th style="width:30%">Class</th>
                                <th style="width:20%">Element</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so-otp-group</code></td>
                                <td>Wrapper</td>
                                <td>Main wrapper class for the OTP input component</td>
                            </tr>
                            <tr>
                                <td><code>so-otp-group-default</code></td>
                                <td>Wrapper</td>
                                <td>Default variant style</td>
                            </tr>
                            <tr>
                                <td><code>so-otp-group-outline</code></td>
                                <td>Wrapper</td>
                                <td>Outline variant with prominent borders</td>
                            </tr>
                            <tr>
                                <td><code>so-otp-group-filled</code></td>
                                <td>Wrapper</td>
                                <td>Filled variant with background</td>
                            </tr>
                            <tr>
                                <td><code>so-otp-group-underline</code></td>
                                <td>Wrapper</td>
                                <td>Underline variant with bottom border only</td>
                            </tr>
                            <tr>
                                <td><code>so-otp-value</code></td>
                                <td>Hidden input</td>
                                <td>Hidden field storing the combined OTP value</td>
                            </tr>
                            <tr>
                                <td><code>so-otp-inputs</code></td>
                                <td>Container</td>
                                <td>Flex container for digit inputs</td>
                            </tr>
                            <tr>
                                <td><code>so-otp-input</code></td>
                                <td>Input</td>
                                <td>Individual digit input field</td>
                            </tr>
                            <tr>
                                <td><code>so-otp-separator</code></td>
                                <td>Span</td>
                                <td>Visual separator between groups</td>
                            </tr>
                            <tr>
                                <td><code>so-is-invalid</code></td>
                                <td>Wrapper</td>
                                <td>Error state class on wrapper</td>
                            </tr>
                            <tr>
                                <td><code>error</code></td>
                                <td>Input</td>
                                <td>Error state class on individual inputs (added by JS)</td>
                            </tr>
                            <tr>
                                <td><code>filled</code></td>
                                <td>Input</td>
                                <td>Added when digit input has value (added by JS)</td>
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
                <!-- API Tabs -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-otp-methods">OTP Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-inherited">Inherited Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#api-runtime">Runtime API</button>
                    <button class="so-tab" role="tab" data-so-target="#api-events">Events</button>
                    <button class="so-tab" role="tab" data-so-target="#api-php">PHP Reference</button>
                </div>

                <div class="so-tab-content">
                    <!-- OTP Methods Tab -->
                    <div class="so-tab-pane so-fade so-show so-active" id="api-otp-methods" role="tabpanel">
                        <h5 class="so-mt-4">OtpInput Configuration Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:20%">Returns</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Length</strong></td></tr>
                                    <tr>
                                        <td><code>length(int $n)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set number of digits (default: 6)</td>
                                    </tr>
                                    <tr>
                                        <td><code>pin4()</code></td>
                                        <td><code>static</code></td>
                                        <td>Shortcut for <code>length(4)</code></td>
                                    </tr>
                                    <tr>
                                        <td><code>pin6()</code></td>
                                        <td><code>static</code></td>
                                        <td>Shortcut for <code>length(6)</code></td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Input Type</strong></td></tr>
                                    <tr>
                                        <td><code>inputType(string $type)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set input type: text, number, password</td>
                                    </tr>
                                    <tr>
                                        <td><code>numeric()</code></td>
                                        <td><code>static</code></td>
                                        <td>Numbers only (shows numeric keyboard)</td>
                                    </tr>
                                    <tr>
                                        <td><code>alphanumeric()</code></td>
                                        <td><code>static</code></td>
                                        <td>Letters and numbers</td>
                                    </tr>
                                    <tr>
                                        <td><code>masked(bool $val = true)</code></td>
                                        <td><code>static</code></td>
                                        <td>Mask input with dots</td>
                                    </tr>
                                    <tr>
                                        <td><code>password()</code></td>
                                        <td><code>static</code></td>
                                        <td>Shortcut for <code>inputType('password')->masked()</code></td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Behavior</strong></td></tr>
                                    <tr>
                                        <td><code>autoSubmit(bool $val = true)</code></td>
                                        <td><code>static</code></td>
                                        <td>Auto-submit form when complete</td>
                                    </tr>
                                    <tr>
                                        <td><code>autoFocus(bool $val = true)</code></td>
                                        <td><code>static</code></td>
                                        <td>Auto-focus first input on load (default: true)</td>
                                    </tr>
                                    <tr>
                                        <td><code>allowPaste(bool $val = true)</code></td>
                                        <td><code>static</code></td>
                                        <td>Allow paste from clipboard (default: true)</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Grouping</strong></td></tr>
                                    <tr>
                                        <td><code>groupSize(int $size)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set group size for visual separators</td>
                                    </tr>
                                    <tr>
                                        <td><code>grouped()</code></td>
                                        <td><code>static</code></td>
                                        <td>Shortcut for <code>groupSize(3)</code></td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Variants</strong></td></tr>
                                    <tr>
                                        <td><code>variant(string $v)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set style variant: default, outline, filled, underline</td>
                                    </tr>
                                    <tr>
                                        <td><code>outline()</code></td>
                                        <td><code>static</code></td>
                                        <td>Outline border style</td>
                                    </tr>
                                    <tr>
                                        <td><code>filled()</code></td>
                                        <td><code>static</code></td>
                                        <td>Filled background style</td>
                                    </tr>
                                    <tr>
                                        <td><code>underline()</code></td>
                                        <td><code>static</code></td>
                                        <td>Underline (bottom border) style</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Inherited Methods Tab -->
                    <div class="so-tab-pane so-fade" id="api-inherited" role="tabpanel">
                        <h5 class="so-mt-4">Inherited from FormElement</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:20%">Returns</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Identification</strong></td></tr>
                                    <tr>
                                        <td><code>name(string $name)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set input name attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>id(string $id)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>value(mixed $val)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set initial OTP value</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Labels & Help</strong></td></tr>
                                    <tr>
                                        <td><code>label(string $label)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set input label</td>
                                    </tr>
                                    <tr>
                                        <td><code>help(string $text)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set help text</td>
                                    </tr>
                                    <tr>
                                        <td><code>error(string $msg)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set error message</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>States</strong></td></tr>
                                    <tr>
                                        <td><code>required(bool $val = true)</code></td>
                                        <td><code>static</code></td>
                                        <td>Mark as required</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled(bool $val = true)</code></td>
                                        <td><code>static</code></td>
                                        <td>Disable all inputs</td>
                                    </tr>
                                    <tr>
                                        <td><code>readonly(bool $val = true)</code></td>
                                        <td><code>static</code></td>
                                        <td>Make all inputs readonly</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Styling</strong></td></tr>
                                    <tr>
                                        <td><code>addClass(string $class)</code></td>
                                        <td><code>static</code></td>
                                        <td>Add CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeClass(string $class)</code></td>
                                        <td><code>static</code></td>
                                        <td>Remove CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr(string $name, $value)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set custom attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>data(string $key, $value)</code></td>
                                        <td><code>static</code></td>
                                        <td>Set data-* attribute</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Rendering</strong></td></tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td><code>string</code></td>
                                        <td>Render OTP input HTML</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderGroup()</code></td>
                                        <td><code>string</code></td>
                                        <td>Render with label, help, error</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray()</code></td>
                                        <td><code>array</code></td>
                                        <td>Export configuration array</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Runtime API Tab -->
                    <div class="so-tab-pane so-fade" id="api-runtime" role="tabpanel">
                        <h5 class="so-mt-4">SOOtpInput Runtime Methods</h5>
                        <p class="so-text-muted">Available on instantiated components in JavaScript.</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:20%">Returns</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Instance Access</strong></td></tr>
                                    <tr>
                                        <td><code>SOOtpInput.getInstance(el, opts)</code></td>
                                        <td><code>SOOtpInput</code></td>
                                        <td>Get or create instance for element</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Value Methods</strong></td></tr>
                                    <tr>
                                        <td><code>getValue()</code></td>
                                        <td><code>string</code></td>
                                        <td>Get combined OTP value</td>
                                    </tr>
                                    <tr>
                                        <td><code>setValue(value)</code></td>
                                        <td><code>this</code></td>
                                        <td>Set OTP value and update UI</td>
                                    </tr>
                                    <tr>
                                        <td><code>clear()</code></td>
                                        <td><code>this</code></td>
                                        <td>Clear all inputs</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>State Methods</strong></td></tr>
                                    <tr>
                                        <td><code>isComplete()</code></td>
                                        <td><code>boolean</code></td>
                                        <td>Check if all digits filled</td>
                                    </tr>
                                    <tr>
                                        <td><code>setError(hasError)</code></td>
                                        <td><code>this</code></td>
                                        <td>Set or remove error state</td>
                                    </tr>
                                    <tr>
                                        <td><code>validate(expected)</code></td>
                                        <td><code>boolean</code></td>
                                        <td>Validate against expected value, sets error if invalid</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Focus & Control</strong></td></tr>
                                    <tr>
                                        <td><code>focus()</code></td>
                                        <td><code>this</code></td>
                                        <td>Focus first empty input (or first)</td>
                                    </tr>
                                    <tr>
                                        <td><code>enable()</code></td>
                                        <td><code>this</code></td>
                                        <td>Enable component</td>
                                    </tr>
                                    <tr>
                                        <td><code>disable()</code></td>
                                        <td><code>this</code></td>
                                        <td>Disable component</td>
                                    </tr>
                                    <tr>
                                        <td><code>isDisabled()</code></td>
                                        <td><code>boolean</code></td>
                                        <td>Check if disabled</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Visibility</strong></td></tr>
                                    <tr>
                                        <td><code>show()</code></td>
                                        <td><code>this</code></td>
                                        <td>Show component</td>
                                    </tr>
                                    <tr>
                                        <td><code>hide()</code></td>
                                        <td><code>this</code></td>
                                        <td>Hide component</td>
                                    </tr>
                                    <tr>
                                        <td><code>toggle(force)</code></td>
                                        <td><code>this</code></td>
                                        <td>Toggle visibility</td>
                                    </tr>
                                    <tr>
                                        <td><code>isVisible()</code></td>
                                        <td><code>boolean</code></td>
                                        <td>Check if visible</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>CSS Classes</strong></td></tr>
                                    <tr>
                                        <td><code>addClass(...classes)</code></td>
                                        <td><code>this</code></td>
                                        <td>Add CSS class(es)</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeClass(...classes)</code></td>
                                        <td><code>this</code></td>
                                        <td>Remove CSS class(es)</td>
                                    </tr>
                                    <tr>
                                        <td><code>toggleClass(class, force)</code></td>
                                        <td><code>this</code></td>
                                        <td>Toggle CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasClass(class)</code></td>
                                        <td><code>boolean</code></td>
                                        <td>Check if has class</td>
                                    </tr>
                                    <tr><td colspan="3" class="so-bg-light"><strong>Lifecycle</strong></td></tr>
                                    <tr>
                                        <td><code>setOptions(opts)</code></td>
                                        <td><code>this</code></td>
                                        <td>Update component options</td>
                                    </tr>
                                    <tr>
                                        <td><code>destroy()</code></td>
                                        <td><code>void</code></td>
                                        <td>Destroy component and cleanup</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Events Tab -->
                    <div class="so-tab-pane so-fade" id="api-events" role="tabpanel">
                        <h5 class="so-mt-4">Custom Events</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:25%">Event</th>
                                        <th style="width:30%">Detail</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>so:otp:change</code></td>
                                        <td><code>{ value, index, component }</code></td>
                                        <td>Fired on any digit change. <code>index</code> is digit position (undefined on paste).</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:otp:complete</code></td>
                                        <td><code>{ value, component }</code></td>
                                        <td>Fired when all digits entered.</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:show</code></td>
                                        <td><code>{ component }</code></td>
                                        <td>Fired when component shown.</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:hide</code></td>
                                        <td><code>{ component }</code></td>
                                        <td>Fired when component hidden.</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:enable</code></td>
                                        <td><code>{ component }</code></td>
                                        <td>Fired when component enabled.</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:disable</code></td>
                                        <td><code>{ component }</code></td>
                                        <td>Fired when component disabled.</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:destroy</code></td>
                                        <td><code>{ component }</code></td>
                                        <td>Fired when component destroyed.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <?= so_code_block("// Event usage example
const otp = document.getElementById('myOtp');

otp.addEventListener('so:otp:change', (e) => {
    console.log('Changed:', e.detail.value);
});

otp.addEventListener('so:otp:complete', (e) => {
    console.log('Complete:', e.detail.value);
    submitForm();
});", 'javascript') ?>
                    </div>

                    <!-- PHP Reference Tab -->
                    <div class="so-tab-pane so-fade" id="api-php" role="tabpanel">
                        <h5 class="so-mt-4">Core\UiEngine\Elements\Form\OtpInput</h5>
                        <p class="so-text-muted">Extends <code>FormElement</code></p>

                        <h6 class="so-mt-4">Factory Method</h6>
                        <?= so_code_block("UiEngine::otpInput(string \$name): OtpInput", 'php') ?>

                        <h6 class="so-mt-4">Properties</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Property</th>
                                        <th>Type</th>
                                        <th>Default</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>$length</code></td>
                                        <td>int</td>
                                        <td>6</td>
                                        <td>Number of digits</td>
                                    </tr>
                                    <tr>
                                        <td><code>$inputType</code></td>
                                        <td>string</td>
                                        <td>'text'</td>
                                        <td>Input type: text, number, password</td>
                                    </tr>
                                    <tr>
                                        <td><code>$masked</code></td>
                                        <td>bool</td>
                                        <td>false</td>
                                        <td>Mask input with dots</td>
                                    </tr>
                                    <tr>
                                        <td><code>$autoSubmit</code></td>
                                        <td>bool</td>
                                        <td>false</td>
                                        <td>Auto-submit on complete</td>
                                    </tr>
                                    <tr>
                                        <td><code>$autoFocus</code></td>
                                        <td>bool</td>
                                        <td>true</td>
                                        <td>Auto-focus first input</td>
                                    </tr>
                                    <tr>
                                        <td><code>$allowPaste</code></td>
                                        <td>bool</td>
                                        <td>true</td>
                                        <td>Allow paste from clipboard</td>
                                    </tr>
                                    <tr>
                                        <td><code>$groupSize</code></td>
                                        <td>int|null</td>
                                        <td>null</td>
                                        <td>Group size for separators</td>
                                    </tr>
                                    <tr>
                                        <td><code>$variant</code></td>
                                        <td>string</td>
                                        <td>'default'</td>
                                        <td>Style variant</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Notes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Usage Notes</h3>
            </div>
            <div class="so-card-body">
                <div class="so-row">
                    <div class="so-col-md-6">
                        <h5 class="so-text-success"><span class="material-icons so-align-middle">check_circle</span> Do</h5>
                        <ul class="so-mb-0">
                            <li>Use <code>numeric()</code> for codes that are numbers only</li>
                            <li>Enable <code>autoFocus()</code> for verification flows</li>
                            <li>Use <code>grouped()</code> for long codes (8+ digits)</li>
                            <li>Validate on server even if client validates</li>
                            <li>Clear OTP after successful verification</li>
                            <li>Add timeout/retry limits for security</li>
                            <li>Listen for <code>so:otp:complete</code> to auto-verify</li>
                        </ul>
                    </div>
                    <div class="so-col-md-6">
                        <h5 class="so-text-danger"><span class="material-icons so-align-middle">cancel</span> Don't</h5>
                        <ul class="so-mb-0">
                            <li>Don't disable paste for legitimate users</li>
                            <li>Don't auto-submit without user awareness</li>
                            <li>Don't show OTP in error messages</li>
                            <li>Don't store OTPs in plain text</li>
                            <li>Don't allow unlimited verification attempts</li>
                            <li>Don't use very long expiry times</li>
                            <li>Don't rely solely on client-side validation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>

<script>
// Initialize OTP inputs after DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Wait for SOOtpInput to be available
    const initOtps = () => {
        if (typeof SOOtpInput === 'undefined') {
            setTimeout(initOtps, 100);
            return;
        }

        // Initialize all OTP inputs (they auto-init via data-so-ui-init)
        // Setup event handling demo
        const eventsOtp = document.getElementById('demo-events');
        const eventOutput = document.getElementById('eventOutput');

        if (eventsOtp) {
            eventsOtp.addEventListener('so:otp:change', (e) => {
                const idx = e.detail.index !== undefined ? e.detail.index : 'paste';
                eventOutput.textContent = `so:otp:change - value="${e.detail.value}", index=${idx}`;
            });

            eventsOtp.addEventListener('so:otp:complete', (e) => {
                eventOutput.innerHTML = `<strong class="so-text-success">so:otp:complete</strong> - value="${e.detail.value}"`;
            });
        }
    };

    initOtps();
});

// Interactive demo functions
function setOtpValue() {
    const otp = SOOtpInput.getInstance('#demo-interactive');
    otp.setValue('123456');
    document.getElementById('interactiveOutput').innerHTML = '<span class="material-icons">check</span><span>Value set to: 123456</span>';
}

function getOtpValue() {
    const otp = SOOtpInput.getInstance('#demo-interactive');
    const value = otp.getValue();
    const complete = otp.isComplete();
    document.getElementById('interactiveOutput').innerHTML = `<span class="material-icons">info</span><span>Current value: "${value}" (complete: ${complete})</span>`;
}

function clearOtp() {
    const otp = SOOtpInput.getInstance('#demo-interactive');
    otp.clear();
    document.getElementById('interactiveOutput').innerHTML = '<span class="material-icons">info</span><span>OTP cleared</span>';
}

function focusOtp() {
    const otp = SOOtpInput.getInstance('#demo-interactive');
    otp.focus();
    document.getElementById('interactiveOutput').innerHTML = '<span class="material-icons">info</span><span>Focused on first empty input</span>';
}

// Validation demo
function validateOtp() {
    const otp = SOOtpInput.getInstance('#demo-validation');
    const isValid = otp.validate('123456');

    const errorEl = document.getElementById('validation-error');
    const successEl = document.getElementById('validation-success');

    if (isValid) {
        errorEl.style.display = 'none';
        successEl.style.display = 'block';
    } else {
        successEl.style.display = 'none';
        errorEl.style.display = 'block';
    }
}

// Error handling demo
function showOtpError(message) {
    const otp = SOOtpInput.getInstance('#demo-error-handling');
    otp.setError(true);
    const errorEl = document.getElementById('error-message');
    errorEl.textContent = message;
    errorEl.style.display = 'block';
}

function clearOtpError() {
    const otp = SOOtpInput.getInstance('#demo-error-handling');
    otp.setError(false);
    document.getElementById('error-message').style.display = 'none';
}
</script>
