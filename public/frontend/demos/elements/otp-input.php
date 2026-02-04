<?php
/**
 * SixOrbit UI Demo - OTP Input
 */
$pageTitle = 'OTP Input';
$pageDescription = 'Auto-advancing OTP/PIN input component';

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
            <h1 class="so-page-title">OTP Input</h1>
            <p class="so-page-subtitle">Auto-advancing one-time password and PIN input fields</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
        <!-- Basic Usage -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Usage (6 Digits)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">A standard 6-digit OTP input with auto-advance to the next field.</p>

                <div class="so-otp-group" id="basicOtp">
                    <div class="so-otp-inputs">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    </div>
                </div>

                <?= so_code_tabs('basic', [
                    ['label' => 'HTML', 'language' => 'html', 'icon' => 'code', 'code' => '<div class="so-otp-group" id="otpInput">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
    </div>
</div>'],
                    ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript', 'code' => '// Get or create instance
const otp = SOOtpInput.getInstance(\'#otpInput\');

// Get the entered value
const value = otp.getValue();']
                ]) ?>
            </div>
        </div>

        <!-- Different Lengths -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Different Lengths</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">OTP inputs can have different lengths based on your requirements.</p>

                <!-- 4-Digit PIN -->
                <div class="so-mb-4">
                    <h5 class="so-mb-3">4-Digit PIN</h5>
                    <div class="so-otp-group" id="pin4">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        </div>
                    </div>
                    <?= so_code_block('<div class="so-otp-group" id="pin4">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
    </div>
</div>', 'html') ?>
                </div>

                <!-- 6-Digit OTP -->
                <div class="so-mb-4">
                    <h5 class="so-mb-3">6-Digit OTP</h5>
                    <div class="so-otp-group" id="otp6">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        </div>
                    </div>
                    <?= so_code_block('<div class="so-otp-group" id="otp6">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <!-- ... 6 inputs total ... -->
    </div>
</div>', 'html') ?>
                </div>

                <!-- 8-Digit Code -->
                <div>
                    <h5 class="so-mb-3">8-Digit Code</h5>
                    <div class="so-otp-group" id="code8">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        </div>
                    </div>
                    <?= so_code_block('<div class="so-otp-group" id="code8">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <!-- ... 8 inputs total ... -->
    </div>
</div>', 'html') ?>
                </div>
            </div>
        </div>

        <!-- Different Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Different Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">OTP inputs come in three sizes: small, default, and large.</p>

                <!-- Small Size -->
                <div class="so-mb-4">
                    <h5 class="so-mb-3">Small (<code>.so-otp-group-sm</code>)</h5>
                    <div class="so-otp-group so-otp-group-sm" id="otpSm">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        </div>
                    </div>
                    <?= so_code_block('<div class="so-otp-group so-otp-group-sm">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <!-- ... -->
    </div>
</div>', 'html') ?>
                </div>

                <!-- Default Size -->
                <div class="so-mb-4">
                    <h5 class="so-mb-3">Default</h5>
                    <div class="so-otp-group" id="otpDefault">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        </div>
                    </div>
                    <?= so_code_block('<div class="so-otp-group">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <!-- ... -->
    </div>
</div>', 'html') ?>
                </div>

                <!-- Large Size -->
                <div>
                    <h5 class="so-mb-3">Large (<code>.so-otp-group-lg</code>)</h5>
                    <div class="so-otp-group so-otp-group-lg" id="otpLg">
                        <div class="so-otp-inputs">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        </div>
                    </div>
                    <?= so_code_block('<div class="so-otp-group so-otp-group-lg">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <!-- ... -->
    </div>
</div>', 'html') ?>
                </div>
            </div>
        </div>

        <!-- Error State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Error State</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Show an error state when the entered OTP is invalid.</p>

                <div class="so-otp-group" id="errorOtp">
                    <div class="so-otp-inputs">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    </div>
                </div>

                <div class="so-btn-group so-mt-4">
                    <button type="button" class="so-btn so-btn-danger" onclick="setErrorState(true)">Show Error</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="setErrorState(false)">Clear Error</button>
                </div>

                <?= so_code_tabs('error', [
                    ['label' => 'HTML', 'language' => 'html', 'icon' => 'code', 'code' => '<div class="so-otp-group" id="errorOtp">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <!-- ... -->
    </div>
</div>'],
                    ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript', 'code' => 'const otp = SOOtpInput.getInstance(\'#errorOtp\');

// Show error state
otp.setError(true);

// Clear error state
otp.setError(false);']
                ]) ?>
            </div>
        </div>

        <!-- Event Handling -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Event Handling</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Listen to events when the OTP value changes or is complete.</p>

                <div class="so-otp-group" id="eventOtp">
                    <div class="so-otp-inputs">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    </div>
                </div>

                <div class="so-alert so-alert-info so-mt-4" id="eventLog">
                    <span class="material-icons">info</span>
                    <div>
                        <strong>Event Log:</strong> <span id="eventOutput">Type in the OTP field above...</span>
                    </div>
                </div>

                <?= so_code_tabs('event', [
                    ['label' => 'HTML', 'language' => 'html', 'icon' => 'code', 'code' => '<div class="so-otp-group" id="eventOtp">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <!-- ... -->
    </div>
</div>'],
                    ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript', 'code' => 'const otp = SOOtpInput.getInstance(\'#eventOtp\');

// Listen for value changes
otp.element.addEventListener(\'otp:change\', (e) => {
    console.log(\'Current value:\', e.detail.value);
    console.log(\'Changed index:\', e.detail.index);
});

// Listen for completion
otp.element.addEventListener(\'otp:complete\', (e) => {
    console.log(\'OTP complete:\', e.detail.value);
    // Submit form or validate
});']
                ]) ?>
            </div>
        </div>

        <!-- Validation Demo -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation Demo</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Validate the entered OTP against an expected value. Enter <strong>123456</strong> for success.</p>

                <div class="so-otp-group" id="validateOtp">
                    <div class="so-otp-inputs">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    </div>
                </div>

                <div class="so-btn-group so-mt-4">
                    <button type="button" class="so-btn so-btn-primary" onclick="validateOtp()">Validate OTP</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="clearValidateOtp()">Clear</button>
                </div>

                <div id="validationResult" class="so-mt-4" style="display: none;"></div>

                <?= so_code_tabs('validate', [
                    ['label' => 'HTML', 'language' => 'html', 'icon' => 'code', 'code' => '<div class="so-otp-group" id="validateOtp">
    <div class="so-otp-inputs">
        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric">
        <!-- ... -->
    </div>
</div>

<button class="so-btn so-btn-primary" onclick="validateOtp()">Validate</button>'],
                    ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript', 'code' => 'const otp = SOOtpInput.getInstance(\'#validateOtp\');

// Validate against expected value
const isValid = otp.validate(\'123456\');

if (isValid) {
    console.log(\'OTP is correct!\');
} else {
    console.log(\'Invalid OTP\');
    // Error state is automatically set
}']
                ]) ?>
            </div>
        </div>

        <!-- Features -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Features</h3>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-4">
                    <div class="so-col-12 so-col-md-6">
                        <div class="so-card so-card-border">
                            <div class="so-card-body">
                                <h5 class="so-mb-2"><span class="material-icons so-text-primary so-me-2" style="vertical-align: middle;">arrow_forward</span> Auto-Advance</h5>
                                <p class="so-text-secondary so-mb-0">Automatically moves focus to the next input when a digit is entered.</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <div class="so-card so-card-border">
                            <div class="so-card-body">
                                <h5 class="so-mb-2"><span class="material-icons so-text-primary so-me-2" style="vertical-align: middle;">backspace</span> Backspace Navigation</h5>
                                <p class="so-text-secondary so-mb-0">Pressing backspace on an empty field moves to the previous input.</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <div class="so-card so-card-border">
                            <div class="so-card-body">
                                <h5 class="so-mb-2"><span class="material-icons so-text-primary so-me-2" style="vertical-align: middle;">content_paste</span> Paste Support</h5>
                                <p class="so-text-secondary so-mb-0">Paste a full OTP code and it will fill all inputs automatically.</p>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <div class="so-card so-card-border">
                            <div class="so-card-body">
                                <h5 class="so-mb-2"><span class="material-icons so-text-primary so-me-2" style="vertical-align: middle;">keyboard</span> Arrow Key Navigation</h5>
                                <p class="so-text-secondary so-mb-0">Use left/right arrow keys to move between inputs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript API -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript API</h3>
            </div>
            <div class="so-card-body">
                <h5 class="so-mb-3">Methods</h5>
                <div class="so-table-container so-mb-4">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>Returns</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>getValue()</code></td>
                                <td>string</td>
                                <td>Returns the combined OTP value as a string</td>
                            </tr>
                            <tr>
                                <td><code>setValue(value)</code></td>
                                <td>this</td>
                                <td>Sets the OTP value and updates the UI</td>
                            </tr>
                            <tr>
                                <td><code>clear()</code></td>
                                <td>this</td>
                                <td>Clears all inputs and resets to initial state</td>
                            </tr>
                            <tr>
                                <td><code>focus()</code></td>
                                <td>this</td>
                                <td>Focuses on the first empty input (or first input)</td>
                            </tr>
                            <tr>
                                <td><code>setError(hasError)</code></td>
                                <td>this</td>
                                <td>Sets or removes the error state on all inputs</td>
                            </tr>
                            <tr>
                                <td><code>isComplete()</code></td>
                                <td>boolean</td>
                                <td>Returns true if all inputs are filled</td>
                            </tr>
                            <tr>
                                <td><code>validate(expected)</code></td>
                                <td>boolean</td>
                                <td>Validates OTP against expected value, sets error state if invalid</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mb-3">Events</h5>
                <div class="so-table-container so-mb-4">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Detail</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>otp:change</code></td>
                                <td><code>{ value, index }</code></td>
                                <td>Fired when any input value changes</td>
                            </tr>
                            <tr>
                                <td><code>otp:complete</code></td>
                                <td><code>{ value }</code></td>
                                <td>Fired when all inputs are filled</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mb-3">Options</h5>
                <div class="so-table-container">
                    <table class="so-table">
                        <thead>
                            <tr>
                                <th>Option</th>
                                <th>Type</th>
                                <th>Default</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>length</code></td>
                                <td>number</td>
                                <td><code>6</code></td>
                                <td>Number of OTP digits (for programmatic creation)</td>
                            </tr>
                            <tr>
                                <td><code>inputSelector</code></td>
                                <td>string</td>
                                <td><code>.so-otp-input</code></td>
                                <td>CSS selector for input elements</td>
                            </tr>
                            <tr>
                                <td><code>autoFocus</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Auto-focus first input on initialization</td>
                            </tr>
                            <tr>
                                <td><code>numericOnly</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Only allow numeric input</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Programmatic Control -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Programmatic Control</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Control the OTP input programmatically using the JavaScript API.</p>

                <div class="so-otp-group" id="controlOtp">
                    <div class="so-otp-inputs">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="so-otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    </div>
                </div>

                <div class="so-btn-group so-mt-4 so-flex-wrap">
                    <button type="button" class="so-btn so-btn-outline" onclick="setOtpValue('123456')">Set "123456"</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="setOtpValue('987654')">Set "987654"</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="getOtpValue()">Get Value</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="focusOtp()">Focus</button>
                    <button type="button" class="so-btn so-btn-outline" onclick="clearOtp()">Clear</button>
                </div>

                <div id="controlOutput" class="so-alert so-alert-info so-mt-4" style="display: none;">
                    <span class="material-icons">info</span>
                    <div id="controlOutputText"></div>
                </div>

                <?= so_code_block('const otp = SOOtpInput.getInstance(\'#controlOtp\');

// Set value programmatically
otp.setValue(\'123456\');

// Get current value
const value = otp.getValue();
console.log(value); // "123456"

// Check if complete
if (otp.isComplete()) {
    // All inputs filled
}

// Focus on first empty input
otp.focus();

// Clear all inputs
otp.clear();', 'javascript') ?>
            </div>
        </div>
    </div>
</main>

<script>
// Initialize all OTP inputs after DOM and framework are ready
document.addEventListener('DOMContentLoaded', () => {
    // Wait for framework to be available
    if (typeof SOOtpInput !== 'undefined') {
        initOtpInputs();
    } else {
        // If not ready, wait a bit for ES modules to load
        setTimeout(initOtpInputs, 100);
    }
});

function initOtpInputs() {
    // Initialize all OTP inputs with autoFocus disabled
    document.querySelectorAll('.so-otp-group').forEach(el => {
        SOOtpInput.getInstance(el, { autoFocus: false });
    });

    // Setup event handling demo
    const eventOtp = document.getElementById('eventOtp');
    const eventOutput = document.getElementById('eventOutput');

    if (eventOtp) {
        eventOtp.addEventListener('otp:change', (e) => {
            eventOutput.textContent = `Change: value="${e.detail.value}", index=${e.detail.index ?? 'paste'}`;
        });

        eventOtp.addEventListener('otp:complete', (e) => {
            eventOutput.innerHTML = `<strong class="so-text-success">Complete!</strong> value="${e.detail.value}"`;
        });
    }
}

// Error state demo
function setErrorState(hasError) {
    const otp = SOOtpInput.getInstance('#errorOtp');
    otp.setError(hasError);
}

// Validation demo
function validateOtp() {
    const otp = SOOtpInput.getInstance('#validateOtp');
    const resultDiv = document.getElementById('validationResult');
    const isValid = otp.validate('123456');

    resultDiv.style.display = 'block';
    if (isValid) {
        resultDiv.innerHTML = '<div class="so-alert so-alert-success"><span class="material-icons">check_circle</span><div><strong>Success!</strong> OTP is valid.</div></div>';
    } else {
        resultDiv.innerHTML = '<div class="so-alert so-alert-danger"><span class="material-icons">error</span><div><strong>Invalid OTP.</strong> Please try again. (Hint: 123456)</div></div>';
    }
}

function clearValidateOtp() {
    const otp = SOOtpInput.getInstance('#validateOtp');
    otp.clear();
    document.getElementById('validationResult').style.display = 'none';
}

// Programmatic control demo
function setOtpValue(value) {
    const otp = SOOtpInput.getInstance('#controlOtp');
    otp.setValue(value);
    showControlOutput(`Set value to "${value}"`);
}

function getOtpValue() {
    const otp = SOOtpInput.getInstance('#controlOtp');
    const value = otp.getValue();
    showControlOutput(`Current value: "${value}" (isComplete: ${otp.isComplete()})`);
}

function focusOtp() {
    const otp = SOOtpInput.getInstance('#controlOtp');
    otp.focus();
    showControlOutput('Focused on first empty input');
}

function clearOtp() {
    const otp = SOOtpInput.getInstance('#controlOtp');
    otp.clear();
    showControlOutput('Cleared all inputs');
}

function showControlOutput(text) {
    const output = document.getElementById('controlOutput');
    const outputText = document.getElementById('controlOutputText');
    output.style.display = 'flex';
    outputText.textContent = text;
}
</script>

<?php require_once '../includes/footer.php'; ?>
